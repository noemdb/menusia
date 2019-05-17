<?include ("../class/conect.php");  include ("../class/funciones.php");     $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$cod_empleado=$_GET["txtcod_empleado"]; $fecha_adelanto=$_GET["txtfecha_adelanto"]; $fechap=formato_aaaammdd($fecha_adelanto);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0; $monto_adelanto=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$error=0; $sSQL="Select cod_empleado,monto_adelanto from NOM031 WHERE cod_empleado='$cod_empleado' and fecha_adelanto='$fechap'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('ADELANTO DE PRESTACIONES NO EXISTE');</script><? }     else{$registro=pg_fetch_array($resultado); $monto_adelanto=$registro["monto_adelanto"];} }
   if($error==0){$sfecha=formato_aaaammdd($fecha_hoy); $sSQL="SELECT ACTUALIZA_NOM031(3,'$cod_empleado','$fechap',0,0,0,0,0)";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
      $desc_doc="ADELANTO PRESTACIONES CODIGO:".$cod_empleado.", FECHA:".$fecha_adelanto.", MONTO:".$monto_adelanto;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')"); $error=pg_errormessage($conn); $error=substr($error,0,61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><?}}
} pg_close();
?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>

