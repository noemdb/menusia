<?include ("../class/conect.php");  include ("../class/funciones.php");
$ced_res_verificador=$_POST["txtced_res_verificador"]; 
$nombre_res_ver=$_POST["txtnombre_res_ver"]; 
$observaciones_ver=$_POST["textobservaciones_ver"]; echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN030 WHERE ced_res_verificador='$ced_res_verificador'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('LA CEDULA YA EXISTE'); </script> <? }
   else{ $error=1; $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN030(1,'$ced_res_verificador','$nombre_res_ver','$observaciones_ver')"); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close(); if ($error==0){?><script language="JavaScript">document.location ='Act_verificador_ar_resp.php';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>
