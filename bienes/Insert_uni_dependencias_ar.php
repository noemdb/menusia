<?include ("../class/conect.php");  include ("../class/funciones.php");
$des_unidad_sol=$_POST["txtdes_unidad_sol"]; $cod_dependencia=$_POST["txtcod_dependencia"];$cod_direccion=$_POST["txtcod_direccion"]; $cod_departamento=$_POST["txtcod_departamento"]; echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN051 WHERE des_unidad_sol='$des_unidad_sol'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('EL CODIGO YA EXISTE'); </script> <? }
   else{ $error=1; $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN051(1,'$des_unidad_sol','$cod_dependencia','$cod_direccion','$cod_departamento')"); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close(); if ($error==0){?><script language="JavaScript">document.location ='Act_uni_dependencias_ar.php';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>
