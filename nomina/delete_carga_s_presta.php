<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); 
$fechab=$_GET["fechah"];  $fechah=formato_aaaammdd($fechab);  $cod_empleado_d=$_GET["codigo_d"]; $cod_empleado_h=$_GET["codigo_h"]; $tipo_nomina_d=$_GET["tipod"]; $tipo_nomina_h=$_GET["tipoh"];  
$url="Act_sueldo_prestaciones.php?Gcriterio=C".$fechab.$cod_empleado_d;  $cod_empleado=$cod_empleado_d;  $sfecha=formato_aaaammdd($fecha_hoy);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sql="Select * FROM SUELDO_PRESTA where (fecha_sueldo='$fechah') And (tipo_nomina>='$tipo_nomina_d') And (tipo_nomina<='$tipo_nomina_h') And (cod_empleado>='$cod_empleado_d') And (cod_empleado<='$cod_empleado_h') order by cod_empleado";
    $res=pg_query($sql);  $prev_cod="";  echo $sql,"<br>";
    while($reg=pg_fetch_array($res)){ $cod_empleado=$reg["cod_empleado"]; $fechap=$reg["fecha_sueldo"];  $asueldo=$reg["monto_sueldo"]; $asueldoa=$reg["monto_sueldo_adic"]; $fecha_sueldo=formato_ddmmaaaa($fechap);	
	  $sSQL="SELECT ACTUALIZA_NOM028(5,'$cod_empleado','$fechap',0,0,0,0,0,0,0,0,0,0,0,'$minf_usuario','000','$fechap','','000','$fechap','')"; //echo $sSQL,"<br>";
      $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror="ERROR GRABANDO: ".substr($merror, 0,91); if (!$resultado){$error=1;?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><?}else{$error=0;
      $desc_doc="SUELDO PRESTACIONES CODIGO:".$cod_empleado.", FECHA SUELDO:".$fecha_sueldo.", SUELDO:".$asueldo.", SUELDO DIAS ADIC:".$asueldoa;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')"); $error=pg_errormessage($conn); $error=substr($error,0,61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><?}}
    }
 }pg_close();  $url="Act_sueldo_prestaciones.php?Gcriterio=C".$fechab.$cod_empleado;
 if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>