<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $url="Act_tip_perso_ar.php";  $formato_tipo="XX-XX";
$cod_tipo_personal=$_GET["txtcod_tipo_personal"]; $fijo_cont="F";  $emp_obr="E";
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$fijo_cont=substr($fijo_cont, 0,1); $emp_obr=substr($emp_obr, 0,1);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM015 WHERE cod_tipo_personal='$cod_tipo_personal'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE PERSONAL NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado);$adescrip=$registro["des_tipo_personal"];}
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);
    $sSQL="SELECT ACTUALIZA_NOM015(3,'$cod_tipo_personal','$adescrip','$sfecha','','$sfecha','S',0,0,'000','$fijo_cont','$emp_obr','S')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
     $desc_doc="TIPO DE PERSONAL, CODIGO:".$cod_tipo_personal.", DESCRIPCION:".$adescrip; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
      $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>  
