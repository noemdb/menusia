<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_presup=$_GET["codigo"];$cod_fuente=$_GET["fuente"];$codigo_mov=$_GET["codigo_mov"];$grupo=$_GET["grupo"];
$url="Det_inc_traspasos.php?codigo_mov=".$codigo_mov;
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from PRE026 WHERE codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and grupo='$grupo'";
  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO PRESUPUESTARIO NO EXISTE EN EL TRASPASO');</script> <? }
   else{  $resultado=pg_exec($conn,"SELECT ELIMINA_PRE026('$codigo_mov','$cod_presup','$cod_fuente','$grupo')");
     $error=pg_errormessage($conn);  $error=substr($error, 0, 61);    if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>