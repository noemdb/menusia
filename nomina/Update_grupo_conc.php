<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");   $fecha_hoy=asigna_fecha_hoy();
$tipo_desde=$_POST["txttipo_desde"]; $tipo_hasta=$_POST["txttipo_hasta"]; $cod_desde=$_POST["txtcod_desde"]; $cod_hasta=$_POST["txtcod_hasta"];
$conc_desde=$_POST["txtconc_desde"]; $conc_hasta=$_POST["txtconc_hasta"]; echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;  $sfecha=formato_aaaammdd($fecha_hoy);
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $formula="(tipo_nomina>='$tipo_desde') and (tipo_nomina<='$tipo_hasta') and (cod_empleado>='$cod_desde') and (cod_empleado<='$cod_hasta') and (cod_concepto>='$conc_desde') and (cod_concepto<='$conc_hasta') ";
 $sql="SELECT tipo_nomina,cod_empleado,cod_concepto,tipo_grupo,frecuencia  From CONCEPTOS_ASIGNADOS Where ".$formula." Order by tipo_nomina,cod_empleado,cod_concepto"; $res=pg_query($sql);  $prev_empleado=""; $grupo="";
 while($registro=pg_fetch_array($res)){ $frec=$registro["frecuencia"]; $tipo_grupo=$registro["tipo_grupo"]; $tipo_nomina=$registro["tipo_nomina"];  $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"];  if($prev_empleado==""){$prev_empleado=$cod_empleado;$grupo="";}
  $e=0; for($i=0; $i<strlen($grupo);$i++){ if(substr($grupo,$i,1)==$tipo_grupo){$e=$i; $i=strlen($grupo);} } if($e==0){$grupo=$grupo.$tipo_grupo;}
  if($prev_empleado!=$cod_empleado){ $sSQL="SELECT ACT_GRUPO_TRAB('$cod_empleado','$grupo')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $prev_empleado=$cod_empleado;$grupo=""; }
  $sSQL="SELECT ACTUALIZA_NOM011(5,'$tipo_nomina','$cod_empleado','$cod_concepto',0,0,'$sfecha','$sfecha','SI','SI',0,0,'0','$frec','SI','000','','N',0,0,0,'','')";
  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
 }
}
pg_close();if($error==0){?><script language="JavaScript"> alert('PROCESO TERMINADO'); window.close(); window.opener.location.reload(); </script> <?}else{?><script language="JavaScript">history.back();</script><?}?>

