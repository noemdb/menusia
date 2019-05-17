<?include ("../class/conect.php");  include ("../class/funciones.php");
$tipo_nomina=$_GET["txttipo_nomina"]; $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR DESBLOQUEANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$error=0; }
  if($error==0){$sSQL="Select * from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado); $adescrip=$registro["descripcion"]; $afrec=$registro["frecuencia"]; $aredon=$registro["redondear"]; $afechap=$registro["ultima_fecha"]; $afechap=formato_ddmmaaaa($afechap); $agen_ord=$registro["g_orden_pago"];     $sfecha=date("y/m/d");
      $sSQL="UPDATE NOM001 SET bloqueada_ext='N' WHERE tipo_nomina='$tipo_nomina'";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR DESBLOQUEANDO: ".substr($error, 0, 61); 
	  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('DESBLOQUEO EXITOSAMENTE'); </script><? }
       
	}
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>