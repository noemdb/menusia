<?include ("../class/conect.php");  include ("../class/funciones.php"); 
error_reporting(E_ALL);
$codigo_cuenta=$_GET["cod_cuenta"];$debito_credito=$_GET["debito_credito"];$codigo_mov=$_GET["codigo_mov"];
$url="Det_inc_pas_orden.php?codigo_mov=".$codigo_mov;echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from PAG030 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='$debito_credito'";
  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CUENTA NO EXISTE EN OTROS PASIVOS');</script> <? }
   else{$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 ('3','$codigo_mov','$codigo_cuenta','$debito_credito',0)");
     $error=pg_errormessage($conn);  $error=substr($error, 0, 61); if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>