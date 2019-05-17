<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo=$_POST["txtcodigo"]; $metodo_rotula=$_POST["txtmetodo_rotula"]; $empleo=$_POST["txtempleo"];echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN012 WHERE codigo='$codigo'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO METODO DE ROTULACION YA EXISTE'); </script> <? }
   else{ $error=1; $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN012(1,'$codigo','$metodo_rotula','$empleo')"); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close(); if ($error==0){?><script language="JavaScript">document.location ='Act_meto_rotulacion_ar.php?Gcodigo=<?echo $codigo;?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>
