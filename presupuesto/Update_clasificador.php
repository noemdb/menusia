<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_partida=$_POST["txtCodigo_Partida"];$den_partida=$_POST["txtNombre_Partida"];$func_inv=$_POST["txtTipo_Gasto"];$func_inv=substr($func_inv,0,1);
$aplicacion=$_POST["txtAplicacion"];$aplicacion=substr($aplicacion,0,1);$cod_contable=$_POST["txtCodigo_Cuenta"];$ord_cord="O";
$url="Mod_clasificador.php?Gpartida=".$cod_partida;echo "ESPERE POR FAVOR MODIFICANDO....","<br>";$error=0;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from PRE098 WHERE cod_partida='$cod_partida'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE PARTIDA NO EXISTE');</script> <? }
   else{ $resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE098(2,'$cod_partida','$den_partida','$aplicacion','$ord_cord','$func_inv','$cod_contable')");
     $error=pg_errormessage($conn);  $error=substr($error, 0, 61);   if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }   else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}
pg_close();?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>