<?include ("../class/conect.php");  include ("../class/funciones.php");    $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$cod_empleado=$_GET["txtcod_empleado"]; $fecha_sueldo=$_GET["txtfecha_sueldo"]; $fechap=formato_aaaammdd($fecha_sueldo);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$error=0; $sSQL="Select cod_empleado,monto_sueldo,monto_sueldo_adic from NOM028 WHERE cod_empleado='$cod_empleado' and fecha_sueldo='$fechap'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('SUELDO DE PRESTACIONES NO EXISTE');</script><? }
    else{$registro=pg_fetch_array($resultado); $asueldo=$registro["monto_sueldo"]; $asueldoa=$registro["monto_sueldo_adic"];} }
   if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);
     $sSQL="SELECT ACTUALIZA_NOM028(5,'$cod_empleado','$fechap',0,0,0,0,0,0,0,0,0,0,0,'$minf_usuario','000','$fechap','','000','$fechap','')";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
      $desc_doc="SUELDO PRESTACIONES CODIGO:".$cod_empleado.", FECHA SUELDO:".$fecha_sueldo.", SUELDO:".$asueldo.", SUELDO DIAS ADIC:".$asueldoa;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')"); $error=pg_errormessage($conn); $error=substr($error,0,61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><?}}
} pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>