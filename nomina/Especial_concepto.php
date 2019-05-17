<?include ("../class/conect.php");  include ("../class/funciones.php");$tipo_nomina=$_GET["txttipo_nomina"]; $cod_concepto=$_GET["txtcod_concepto"]; $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sSQL="Select * from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CONCEPTO NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado); $adescrip=$registro["denominacion"];  $status=$registro["status"];    $sfecha=date("y/m/d");
      $s_cal="S"; if(substr($status,1,1)=="S"){ $s_cal="N";}
      $status=substr($status,0,1).$s_cal.substr($status,2,8);
      $sSQL="UPDATE NOM002 SET status='$status' WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR ELIMINANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ACTUALIZO EXITOSAMENTE'); </script><?
      $desc_doc="CONCEPTO, TIPO NOMINA:".$tipo_nomina.", CODIGO CONCEPTO:".$cod_concepto.", DENOMINACION:".$adescrip.", INTERVIENE CALCULO ESPECIAL:"; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
      $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } }
  }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>