<?include ("../class/conect.php");  include ("../class/funciones.php");
$ced_res_rotu=$_POST["txtced_res_rotu"]; 
$nombre_res_rotu=$_POST["txtnombre_res_rotu"]; 
$observaciones_rotu=$_POST["textobservaciones_rotu"]; echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN032 WHERE ced_res_rotu='$ced_res_rotu'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('LA CEDULA YA EXISTE'); </script> <? }
   else{ $error=1; $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN032(1,'$ced_res_rotu','$nombre_res_rotu','$observaciones_rotu')"); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close(); if ($error==0){?><script language="JavaScript">document.location ='Act_rotulador_ar_resp.php';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>
