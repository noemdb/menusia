<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $url="Act_ubi_ar.php"; $codigo_ubicacion=$_GET["txtcodigo_ubicacion"];
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM058 WHERE codigo_ubicacion='$codigo_ubicacion'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE UBICACION NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado);$adescrip=$registro["descripcion_ubi"];}
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);      $sSQL="SELECT ACTUALIZA_NOM058(3,'$codigo_ubicacion','$adescrip')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
     $desc_doc="UBICACION, CODIGO:".$codigo_ubicacion.", DESCRIPCION:".$adescrip; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
      $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>