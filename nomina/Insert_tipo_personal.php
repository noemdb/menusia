<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $url="Act_tip_perso_ar.php";  $formato_tipo="XX-XX";
$cod_tipo_personal=$_POST["txtcod_tipo_personal"]; $des_tipo_personal=$_POST["txtdes_tipo_personal"]; $fijo_cont=$_POST["txtfijo_cont"];  $emp_obr=$_POST["txtemp_obr"];
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$fijo_cont=substr($fijo_cont, 0,1); $emp_obr=substr($emp_obr, 0,1);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM015 WHERE cod_tipo_personal='$cod_tipo_personal'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE PERSONAL YA EXISTE');</script><? }
  if($error==0){if(strlen($cod_tipo_personal)==strlen($formato_tipo)){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD TIPO DE PERSONAL INVALIDA');</script><?} }
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);
    $sSQL="SELECT ACTUALIZA_NOM015(1,'$cod_tipo_personal','$des_tipo_personal','$sfecha','','$sfecha','S',0,0,'000','$fijo_cont','$emp_obr','S')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}
  }
}
pg_close();if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>