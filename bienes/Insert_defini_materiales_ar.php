<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_material=$_POST["txtcod_material"]; $des_material=$_POST["txtdes_material"];echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN035 WHERE cod_material='$cod_material'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO MATERIAL YA EXISTE'); </script> <? }
   else{ $error=1; $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN035(1,'$cod_material','$des_material')"); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close(); if ($error==0){?><script language="JavaScript">document.location ='Act_defini_materiales_ar.php?Gcod_material=<?echo $cod_material?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>
