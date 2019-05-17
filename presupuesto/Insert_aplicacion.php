<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_aplicacion=$_POST["txtCodigo_Aplicacion"];$den_aplicacion=$_POST["txtNombre_Aplicacion"];echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$error=0;$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$sSQL="Select * from PRE025 WHERE cod_aplicacion='$cod_aplicacion'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE APLICACIÓN YA EXISTE'); </script> <? }
   else{ $error=1; $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE025(1,'$cod_aplicacion','$den_aplicacion')"); $error=pg_errormessage($conn);     $error=substr($error, 0, 61);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close();if ($error==0){?><script language="JavaScript">document.location ='Act_tipo_aplica.php';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }?>