<?include ("../class/conect.php");  include ("../class/funciones.php");$cod_arch_banco=$_GET["txtcod_arch_banco"];   $tipo_arch_banco=$_GET["txttipo_arch_banco"];$fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sSQL="Select den_arch_banco,cod_cta_emp from NOM045 WHERE cod_arch_banco='$cod_arch_banco'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE ARCHIVO NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado); $adescrip=$registro["den_arch_banco"]; $acuenta=$registro["cod_cta_emp"]; $sfecha=formato_aaaammdd($fecha_hoy);
      $sSQL="SELECT ACTUALIZA_NOM045(3,'$cod_arch_banco','$tipo_arch_banco','$adescrip','','','','$acuenta','','','','','','','','','','')";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR ELIMINANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
      $desc_doc="CODIGO DE ARCHIVO:".$cod_arch_banco.", DESCRIPCION:".$adescrip.", CUENTA:".$acuenta; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
      $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } }
  }
}pg_close(); ?> <script language="JavaScript"> window.close(); window.opener.location.reload(); </script>