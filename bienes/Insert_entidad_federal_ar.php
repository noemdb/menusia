<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_estado=$_POST["txtcod_estado"]; $estado=$_POST["txtestado"]; echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from PRE091 WHERE codigo='$cod_estado'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('EL CODIGO YA EXISTE'); </script> <? }
   else{ $error=1; $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE091(1,'$cod_estado','$estado')"); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close(); if ($error==0){?><script language="JavaScript">document.location ='Act_entidad_federal_ar.php';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>
