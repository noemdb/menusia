<?include ("../class/conect.php");  include ("../class/funciones.php");$codigo_departamento=$_GET["txtcodigo"]; $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?} else{$error=0; }
 if($error==0){$sSQL="Select cod_cargo from NOM006 WHERE cod_departam='$codigo_departamento'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado); if($filas>0){$error=1;?><script language="JavaScript">muestra('DEPARTAMENTO TIENE TRABAJADORES ASIGNADO');</script><?}}
  if($error==0){$sSQL="Select * from NOM005 WHERE codigo_departamento='$codigo_departamento'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE DEPARTAMENTO NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado); $adescrip=$registro["descripcion_dep"]; $sfecha=formato_aaaammdd($fecha_hoy);  $sSQL="SELECT ACTUALIZA_NOM005(3,'$codigo_departamento','$adescrip','S')";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR ELIMINANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
      $desc_doc="DEPARTAMENTO, CODIGO:".$codigo_departamento.", DESCRIPCION:".$adescrip; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
      $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } }
  }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>