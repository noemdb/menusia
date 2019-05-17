<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);$tipo_retencion=$_GET["tipo_ret"];$referencia_comp=$_GET["referencia"];
$tipo_compromiso=$_GET["tipo"];$cod_presup=$_GET["codigo"];$fuente_financ=$_GET["fuente"];$codigo_mov=$_GET["codigo_mov"];$url="Det_inc_ret_ord_fin.php?codigo_mov=".$codigo_mov;
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$sSQL="Select * from PAG028 WHERE codigo_mov='$codigo_mov' and tipo_retencion='$tipo_retencion' and ref_comp_ret='$referencia_comp' and tipo_comp_ret='$tipo_compromiso' and cod_presup_ret='$cod_presup' and fuente_fin_ret='$fuente_financ'";
  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('RETENCION NO EXISTE EN LA ORDEN');</script> <? }
   else{ $sSQL="SELECT ELIMIMA_PAG028('$codigo_mov','00000000','$tipo_retencion','$referencia_comp','$tipo_compromiso','$cod_presup','$fuente_financ')";
     $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>