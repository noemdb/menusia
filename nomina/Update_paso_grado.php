<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_tipo_personal=$_POST["txtcod_tipo_personal"]; $fecha=$_POST["txtfecha_aprobacion"]; $paso=$_POST["txtpaso"];  $grado=$_POST["txtgrado"];$sueldo=$_POST["txtsueldo"];
$sueldo=formato_numero($sueldo); if(is_numeric($sueldo)){$sueldo=$sueldo;}else{$sueldo=0;}
$equipo = getenv("COMPUTERNAME"); $MInf_Usuario=$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Det_pasos_grado.php?Gcodigo=".$cod_tipo_personal;  $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ if(checkData($fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? } }
  if($error==0){$sSQL="Select * from NOM015 WHERE cod_tipo_personal='$cod_tipo_personal'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO TIPO DE PERSONAL NO EXISTE');</script><?}}
  $sfecha=formato_aaaammdd($fecha); 
 if($error==0){ $sSQL="Select * from NOM040 WHERE cod_tipo_personal='$cod_tipo_personal' and grado='$grado' and paso='$paso'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1;  ?> <script language="JavaScript"> muestra('PASO Y GRADO NO EXISTE EN LA TABLA');</script><? }
   else{$sfecha=formato_aaaammdd($fecha);
      $sSQL="SELECT ACTUALIZA_NOM040(2,'$cod_tipo_personal','$sfecha','$grado','$paso',$sueldo)"; //echo $sSQL;
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){echo $sSQL; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
  }
}
pg_close();
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
/* */
?>


