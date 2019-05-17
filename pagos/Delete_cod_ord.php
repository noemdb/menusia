<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$ref_imput_presu=$_GET["ref_imput"];$cod_presup=$_GET["codigo"];$cod_fuente=$_GET["fuente"];$codigo_mov=$_GET["codigo_mov"];$referencia_comp=$_GET["ref_comp"];$tipo_compromiso=$_GET["tipo_comp"];
$url="Det_inc_cod_ord.php?codigo_mov=".$codigo_mov."&bloqueada=N";echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$sSQL="Select * from PRE026 WHERE codigo_mov='$codigo_mov' and ref_imput_presu='$ref_imput_presu' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'";
  $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NO EXISTE EN LA ORDEN');</script> <? }
   else{ $resultado=pg_exec($conn,"SELECT ELIM_COD_PRE026('$codigo_mov','$cod_presup','$cod_fuente','$referencia_comp','$tipo_compromiso','$ref_imput_presu')"); 
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error=substr($error, 0, 91);   if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>