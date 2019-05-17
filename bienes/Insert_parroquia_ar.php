<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo=$_POST["txtcod_parroquia"]; $nombre=$_POST["txtnombre_parroquia"]; echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from PRE096 WHERE cod_parroquia='$codigo'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE LA PARROQUIA YA EXISTE'); </script> <? }
   else{ $error=1; $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE096(1,'$codigo','$nombre')"); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close(); if ($error==0){?><script language="JavaScript">document.location ='Act_parroquias_ar.php';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>
