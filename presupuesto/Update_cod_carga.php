<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo=$_GET["codigo"];$cod_presup=$_GET["cod_presup"];$monto=$_GET["monto"];$monto=formato_numero($monto);
$cod_fuente=substr($codigo,1,2);$url="Part_det_carga.php?Gcodigo=".$codigo;
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";$error=0;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from pre032 WHERE cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE PRESUPUESTARIO NO LOCALIZADO');</script> <? }
   else{ $resultado=pg_exec($conn,"SELECT MODIFICA_PRE032('$cod_presup','$cod_fuente',$monto)");    $error=pg_errormessage($conn);    $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>