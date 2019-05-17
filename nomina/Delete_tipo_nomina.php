<?include ("../class/conect.php");  include ("../class/funciones.php");
$tipo_nomina=$_GET["txttipo_nomina"]; $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$error=0; }
 if($error==0){ if ($gnomina=="00"){$error=0;} else {  if($tipo_nomina<>$gnomina) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO ACTIVA PARA EL USUARIO');</script><?}  } } 
 if($error==0){$sSQL="Select tipo_nomina from NOM002 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado); if($filas>0){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA TIENE CONCEPTOS');</script><?}}
 if($error==0){$sSQL="Select tipo_nomina from NOM003 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado); if($filas>0){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA TIENE FORMULA CONCEPTOS');</script><?}}
 if($error==0){$sSQL="Select tipo_nomina from NOM011 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado); if($filas>0){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA TIENE ASIGNACION DE CONCEPTOS');</script><?}}
 if($error==0){$sSQL="Select tipo_nomina from NOM006 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado); if($filas>0){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA TIENE TRABAJADORES RELACIONADO');</script><?}}
 if($error==0){$sSQL="Select * from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado); $adescrip=$registro["descripcion"]; $afrec=$registro["frecuencia"]; $aredon=$registro["redondear"]; $afechap=$registro["ultima_fecha"]; $afechap=formato_ddmmaaaa($afechap); $agen_ord=$registro["g_orden_pago"];     $sfecha=date("y/m/d");
      $sSQL="SELECT ACTUALIZA_NOM001(3,'$tipo_nomina','$adescrip','00','','',0,'$sfecha','$sfecha','$sfecha','$sfecha','','','','','','','','','','','','','','','','','','','','','','','','','','','N','N','$minf_usuario')";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR ELIMINANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
      $desc_doc="TIPO DE NOMINA, TIPO:".$tipo_nomina.", DESCRIPCION:".$adescrip.", FRECUENCIA:".$afrec.", REDONDEA:".$aredon.", ULTIMA FECHA PROCESO:".$afechap.", GENERA INF. ORDEN:".$agen_ord; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
      $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } }
  }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>