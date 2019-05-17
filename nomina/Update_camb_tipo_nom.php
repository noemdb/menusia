<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");   $fecha_hoy=asigna_fecha_hoy();
$cod_empleado=$_POST["txtcod_empleado"]; $tipo_nomina=$_POST["txttipo_nomina"]; $tipo_new=$_POST["txttipo_new"]; echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  $error=0;
  $sSQL="Select * from NOM006 WHERE cod_empleado='$cod_empleado'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? }
   else{ $registro=pg_fetch_array($resultado,0);  $tipo_nomina=$registro["tipo_nomina"]; $nombre=$registro["nombre"]; $cod_categoria=$registro["cod_categoria"];  $fecha_ing=$registro["fecha_ingreso"];      $calculo_grupos=$registro["calculo_grupos"];}
   if($error==0){$sSQL="Select tipo_nomina from NOM017 WHERE tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('TRABAJADOR TIENE NOMINA CALCULADA');</script><?} }
   if($error==0){$sSQL="Select tipo_nomina,descripcion,con_sue_bas,con_compen,g_orden_pago from NOM001 WHERE tipo_nomina='$tipo_new'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NUEVA NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado); $g_orden_pago=$registro["g_orden_pago"]; $cod_conc_s=$registro["con_sue_bas"]; $cod_conc_c=$registro["con_compen"];}}
   if($error==0){
     $sSQL="SELECT CAMBIA_TIPO_NOMINA('$cod_empleado','$tipo_nomina','$tipo_new')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
	 echo $sSQL;
	 
    $error=substr($error, 0, 67); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('CAMBIO HECHO SATISFACTORIAMENTE, DEBE INGRESAR A ASIGNACION DE CONCEPTOS Y ACTUALIZAR CONCEPTOS Y CODIGOS PRESUPUESTARIOS'); </script><?     $sfecha=formato_aaaammdd($fecha_hoy);
    $desc_doc="CAMBIO TIPO DE NOMINA, CODIGO TRABAJADOR :".$cod_empleado.", NOMBRE:".$nombre.", TIPO ANTERIOR:".$tipo_nomina.", TIPO NUEVO:".$tipo_new; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')"); $error=pg_errormessage($conn); $error=substr($error, 0, 65);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
   }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>