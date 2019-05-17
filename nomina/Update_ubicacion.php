<?include ("../class/conect.php");  include ("../class/funciones.php");$fecha_hoy=asigna_fecha_hoy();
$codigo_ubicacion=$_POST["txtcodigo_ubicacion"]; $descripcion_ubi=$_POST["txtdescripcion_ubi"]; $url="Act_ubi_ar.php";
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM058 WHERE codigo_ubicacion='$codigo_ubicacion'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE UBICACION NO EXISTE');</script><? }
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);  $sSQL="SELECT ACTUALIZA_NOM058(2,'$codigo_ubicacion','$descripcion_ubi')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?}
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>