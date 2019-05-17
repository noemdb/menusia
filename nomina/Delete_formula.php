<?include ("../class/conect.php");  include ("../class/funciones.php");$tipo_nomina=$_GET["txttipo_nomina"]; $cod_concepto=$_GET["txtcod_concepto"];  $consecutivo=$_GET["txtconsecutivo"]; $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sSQL="Select * from NOM003 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto' and consecutivo='$consecutivo'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('FORMULA DE CONCEPTO NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado); $aaccion=$registro["accion"]; $mrago1=$registro["rango_inicial"]; $mrago2=$registro["rango_final"]; $mresult=$registro["calculofinal"];    $sfecha=formato_aaaammdd($fecha_hoy);}
   if($error==0){ if ($gnomina=="00"){$error=0;} else {  if($tipo_nomina<>$gnomina) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO ACTIVA PARA EL USUARIO');</script><?}  } } 
   if($error==0){ $sSQL="SELECT ACTUALIZA_NOM003(3,'$tipo_nomina','$cod_concepto','$consecutivo','$aaccion',$mrago1,$mrago2,'','','','$minf_usuario')";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR ELIMINANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
      $desc_doc="FROMULA DE CONCEPTO, TIPO NOMINA:".$tipo_nomina.", CODIGO CONCEPTO:".$cod_concepto.", CONSECUTIVO:".$consecutivo.", ACCION:".$aaccion.", RANGO INICIAL:".$mrago1.", RANGO FINAL:".$mrago2.", RESULTADO FINAL:".$mresult; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
       $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } }
  }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>