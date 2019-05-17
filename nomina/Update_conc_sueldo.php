<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");   $fecha_hoy=asigna_fecha_hoy();
$tipo_nomina=$_POST["txttipo_desde"]; echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  $error=0;
  $sSQL="Select tipo_nomina,descripcion,con_sue_bas,con_compen,g_orden_pago from NOM001 WHERE tipo_nomina='$tipo_nomina'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO EXISTE');</script><? }
   else{ 
    $sSQL="SELECT ACTUALIZA_SUELDO_ASIGNA('$tipo_nomina')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
	 echo $sSQL;
	 
    $error=substr($error, 0, 67); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
    
    else{?><script language="JavaScript">  muestra('CAMBIO HECHO SATISFACTORIAMENTE'); </script><?   }  $sfecha=formato_aaaammdd($fecha_hoy);
    
   }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>