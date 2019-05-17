<?include ("../class/conect.php"); include ("../class/funciones.php");
$cod_empleado=$_GET["Gcod_empleado"]; $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$error=0; $sSQL="SELECT ACTUALIZA_CARGO_EMPLEADO('N')"; $resultado=pg_exec($conn,$sSQL);
      $error=pg_errormessage($conn); $error="ACTUALIZANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ACTUALIZO EXITOSAMENTE'); </script><? } }
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>