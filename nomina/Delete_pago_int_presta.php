<?include ("../class/conect.php");  include ("../class/funciones.php");    $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$cod_empleado=$_GET["txtcod_empleado"]; $fecha_pago=$_GET["txtfecha_pago"]; $fechap=formato_aaaammdd($fecha_pago);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0; $monto_pago=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$error=0; $sSQL="Select cod_empleado,monto_pago from NOM032 WHERE cod_empleado='$cod_empleado' and fecha_pago='$fechap'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('PAGO INTERESES DE PRESTACIONES NO EXISTE');</script><? }     else{$registro=pg_fetch_array($resultado); $monto_pago=$registro["monto_pago"];} }
   if($error==0){$sfecha=formato_aaaammdd($fecha_hoy); $sSQL="SELECT ACTUALIZA_NOM032(3,'$cod_empleado','$fechap',0,$monto_pago)";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
      $desc_doc="PAGO INTERESES PRESTACIONES CODIGO:".$cod_empleado.", FECHA:".$fecha_pago.", MONTO:".$monto_pago;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')"); $error=pg_errormessage($conn); $error=substr($error,0,61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><?}}
} pg_close();
?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>
