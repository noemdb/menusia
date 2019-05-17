<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo=$_GET["codigo"];$cod_presup=$_GET["cod_presup"];$cod_fuente=substr($codigo,1,2);
$url="Part_det_carga.php?Gcodigo=".$codigo;echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from pre032 WHERE cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE PRESUPUESTARIO NO LOCALIZADO');</script> <? }
   else{ $resultado=pg_exec($conn,"SELECT ELIMINA_PRE032('$cod_presup','$cod_fuente')");   $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>