<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo_c=$_POST["txtcod_clasificacion"]; $num_descrip=$_POST["txtnum_descrip"]; $descripcion_b=$_POST["txtdescripcion_b"];echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN033 WHERE codigo_c='$codigo_c' and num_descrip='$num_descrip'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('NUMERO DE DESCRIPCION YA EXISTE'); </script> <? }
   else{ $error=1; $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN033(1,'$codigo_c','$num_descrip','$descripcion_b','')"); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close(); if ($error==0){?><script language="JavaScript">document.location ='Act_descrip_bienes_ar.php?Gcodigo_c=<?echo $num_descrip.$codigo_c?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>
