<?include ("../class/conect.php");  include ("../class/funciones.php");$cedula=$_GET["Gcedula"];   $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$url="Act_info_elegibles.php?Gcedula=C".$cedula;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM053 WHERE cedula='$cedula'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado); $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('INFORMACION DE ELEGIBLE NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado); $nombre=$registro["nombre_e"];  $sfecha=formato_aaaammdd($fecha_hoy);
      $sSQL="SELECT ACTUALIZA_NOM053(3,'$cedula','','','','','','','','','$sfechan',0,'','','','','','','',0,'','','$sfechan','','','','','','','','',0,0,'',0,'',0,'','$usuario_sia','$minf_usuario','')";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR ELIMINANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
      $desc_doc="INFORMACION DE ELEGIBLE, CEDULA:".$cedula.", NOMBRE:".$anombre;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
      $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } }
  }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>