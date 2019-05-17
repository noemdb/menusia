<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); 
$cod_tipo_personal=$_GET["cod_tipo_personal"]; $grado=$_GET["grado"]; $paso=$_GET["paso"];  
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$url="Det_pasos_grado.php?Gcodigo=".$cod_tipo_personal;  $error=0; $sueldo=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{ $sSQL="Select * from NOM040 WHERE cod_tipo_personal='$cod_tipo_personal' and grado='$grado' and paso='$paso'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
    if ($filas==0){$error=1;  ?> <script language="JavaScript"> muestra('PASO Y GRADO NO EXISTE EN LA TABLA');</script><? }
    if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);
    $sSQL="SELECT ACTUALIZA_NOM040(3,'$cod_tipo_personal','$sfecha','$grado','$paso',$sueldo)"; echo $sSQL;
    $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror="ERROR GRABANDO: ".substr($merror, 0, 91); if (!$resultado){$error=1; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
      $desc_doc="TABLA GRADO Y PASO, CODIGO TIPO:".$cod_tipo_personal.", GRADO:".$grado.", PASO:".$paso; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
      $merror=pg_errormessage($conn); $merror=substr($merror, 0, 91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $merror;?>');</script><? }}
  }
}
pg_close();
/*  */
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>
