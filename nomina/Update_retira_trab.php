<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); $fecha_hoy=asigna_fecha_hoy();
$cod_empleado=$_POST["txtcod_empleado"]; $accion=$_POST["txtaccion"]; $fecha_eg=$_POST["txtfecha_eg"]; $motivo=$_POST["txtmotivo"]; echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0; $operacion=substr($accion,0,1); if($operacion=="E"){$opcion=2;}else{$opcion=1;}
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$error=0; $sSQL="Select * from NOM006 WHERE  cod_empleado='$cod_empleado'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? }
   else{ $registro=pg_fetch_array($resultado,0);  $tipo_nomina=$registro["tipo_nomina"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ing=$registro["fecha_ingreso"]; $nacionalidad=$registro["nacionalidad"]; $fecha_asig=$registro["fecha_asigna_cargo"];}
  if($error==0){if(checkData($fecha_eg)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE EGRESO NO ES VALIDA');</script><? }}
  if($error==0){$sSQL="Select tipo_nomina from NOM017 WHERE tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('TRABAJADOR TIENE NOMINA CALCULADA');</script><?} }
  if($error==0){$sfechae=formato_aaaammdd($fecha_eg); $sSQL="SELECT RETIRA_TRABAJADOR($opcion,'$cod_empleado','$cedula','$fecha_asig','$nombre','$nacionalidad','$sfechae','$motivo','$minf_usuario')"; echo $sSQL; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
    $error="ACTUALIZANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('RETIRO DE TRABAJADOR, SE REGISTRO EXITOSAMENTE'); </script><?  $sfecha=formato_aaaammdd($fecha_hoy);
    $desc_doc="CAMBIO CODIGO DEL TRABAJADOR CODIGO :".$cod_empleado.", NOMBRE:".$nombre.", CEDULA:".$cedula.", FECHA EGRESO:".$fecha_eg.", ACCIÓN:".$accion; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}
pg_close();if($error==0){?><script language="JavaScript">window.close(); window.opener.location.reload(); </script> <?}else{?><script language="JavaScript">history.back();</script><?}?>

