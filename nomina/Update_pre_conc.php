<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");   $fecha_hoy=asigna_fecha_hoy();
$tipo_desde=$_POST["txttipo_desde"]; $tipo_hasta=$_POST["txttipo_hasta"]; $cod_desde=$_POST["txtcod_desde"]; $cod_hasta=$_POST["txtcod_hasta"];
$conc_desde=$_POST["txtconc_desde"]; $conc_hasta=$_POST["txtconc_hasta"]; echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;  $sfecha=formato_aaaammdd($fecha_hoy);
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $formula="(nom011.tipo_nomina>='$tipo_desde') and (nom011.tipo_nomina<='$tipo_hasta') and (nom011.cod_empleado>='$cod_desde') and (nom011.cod_empleado<='$cod_hasta') and (nom011.cod_concepto>='$conc_desde') and (nom011.cod_concepto<='$conc_hasta') ";
 $sql="SELECT nom011.tipo_nomina,nom011.cod_empleado,nom011.cod_concepto,nom011.status,nom011.cod_presup,nom011.frecuencia,nom002.cod_cat_alter,nom002.afecta_presup,nom002.cod_partida,nom002.cod_retencion,nom006.cod_categoria FROM nom011,nom002,nom006 Where (nom011.tipo_nomina=nom002.tipo_nomina) And (nom011.cod_concepto=nom002.cod_concepto) And (nom011.cod_empleado=nom006.cod_empleado) And ".$formula."  Order by nom011.tipo_nomina,nom011.cod_empleado,nom011.cod_concepto"; $res=pg_query($sql);
 //echo $sql,"<br>";
 while($registro=pg_fetch_array($res)){ $status=$registro["status"]; $cod_cat_alter=$registro["cod_cat_alter"]; $cod_categoria=$registro["cod_categoria"]; $afecta_presup=$registro["afecta_presup"]; $cod_partida=$registro["cod_partida"]; $cod_retencion=$registro["cod_retencion"]; $tipo_nomina=$registro["tipo_nomina"];  $cod_empleado=$registro["cod_empleado"]; $cod_concepto=$registro["cod_concepto"]; $frec=$registro["frecuencia"]; $cod_presup=$registro["cod_presup"];
  if($cod_cat_alter==""){$cod_presup=$cod_categoria."-".$cod_partida;}else{$cod_presup=$cod_cat_alter."-".$cod_partida;} $afecta_p=substr($status,0,1);
  if($afecta_p=="N"){ 
    $sSQL="SELECT ACTUALIZA_NOM011(4,'$tipo_nomina','$cod_empleado','$cod_concepto',0,0,'$sfecha','$sfecha','SI','SI',0,0,'$cod_presup','$frec','$afecta_presup','$cod_retencion','','N',0,0,0,'$status','')";
    // echo $sSQL,"<br>";
	$resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
  }
 }
}
pg_close();
/**/
if($error==0){?><script language="JavaScript"> alert('PROCESO TERMINADO'); window.close(); window.opener.location.reload(); </script> <?}else{?><script language="JavaScript">history.back();</script><?}?>

