<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_color=$_POST["txtcod_color"]; $des_color=$_POST["txtdes_color"];echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN034 WHERE cod_color='$cod_color'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('EL CODIGO YA EXISTE'); </script> <? }
   else{ $error=1; $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN034(1,'$cod_color','$des_color')"); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close(); if ($error==0){?><script language="JavaScript">document.location ='Act_defini_colores_ar.php?Gcod_color=<?echo $cod_color?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>
