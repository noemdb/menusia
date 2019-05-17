<?include ("../class/conect.php");  include ("../class/funciones.php");
$tipo_comp=$_POST["txttipo_comp"];$des_tipo_comp=$_POST["txtdes_tipo_comp"];$cod_part_iva=$_POST["txtcod_part_iva"];
$func_inv_tpcomp=$_POST["txtTipo_Gasto"];$c_imp_unico=$_POST["txtc_imp_unico"];$func_inv_tpcomp=substr($func_inv_tpcomp,0,1);$c_imp_unico=substr($c_imp_unico,0,1);
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from pre016 WHERE tipo_comp='$tipo_comp'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO TIPO DE COMPROMISO NO EXISTE'); </script> <? }
   else{  $error=1;  $sSQL="SELECT ACTUALIZA_PRE016(3,'$tipo_comp','$des_tipo_comp','','$cod_part_iva','$func_inv_tpcomp','$c_imp_unico')";
     $resultado=pg_exec($conn,$sSQL);     $error=pg_errormessage($conn);  $error=substr($error, 0, 61);   if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }      else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='Act_tipo_compromiso.php';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }?>