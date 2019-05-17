<?include ("../class/conect.php");  include ("../class/funciones.php");
$numero=$_GET["txtnumero"]; $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$error=0; $sSQL="Select * from NOM021 WHERE numero='$numero'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NÚMERO DE GACETA NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado); $adesde=$registro["fecha_desde"]; $ahasta=$registro["fecha_hasta"]; $atasa=$registro["tasa"]; $sfecha=formato_aaaammdd($fecha_hoy);
      $sSQL="SELECT ACTUALIZA_NOM021(3,'$numero','$adesde','$ahasta',0)";  $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror="ERROR ELIMINANDO: ".substr($merror, 0, 91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
      $desc_doc="TASA DE PRESTACIONES, GACETA NUMERO:".$numero.", FECHA DESDE:".formato_ddmmaaaa($adesde).", FECHA HASTA:".formato_ddmmaaaa($ahasta).", TASA:".$atasa; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
      $merror=pg_errormessage($conn); $merror=substr($merror, 0, 91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $merror;?>');</script><? } }
  }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>