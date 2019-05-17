<?include ("../class/conect.php"); include ("../class/funciones.php"); $tipo_nomina=$_GET["Gtipo_nomina"]; $fecha_hoy=asigna_fecha_hoy(); $sfecha=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $error=0; $sSQL="UPDATE nom006 set status='INACTIVO' where status='ACTIVO' and tipo_nomina='$tipo_nomina' "; $resultado=pg_exec($conn,$sSQL);
    $error=pg_errormessage($conn); $error="ACTUALIZANDO: ".substr($error, 0, 91); 
	if (!$resultado){echo $resultado; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ACTUALIZO EXITOSAMENTE'); </script><? 
		$desc_doc="DESACTIVAR TRABAJADORES, TIPO NOMINA:".$tipo_nomina; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
        $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }	
	} 
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>