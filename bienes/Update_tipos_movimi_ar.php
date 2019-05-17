<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo=$_POST["txtcodigo"]; $denomina_tipo=$_POST["txtdenomina_tipo"]; $tipo=$_POST["txttipo"];$gen_comprobante=$_POST["txtgen_comprobante"];
$tipo=substr($tipo, 0, 1); $gen_comprobante=substr($gen_comprobante, 0, 1);
$url="Act_tipos_movimi_ar.php?Gcodigo=".$codigo; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN003 WHERE codigo='$codigo'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL TIPO DE MOVIMIENTO NO EXISTE');</script> <? }
   else{$error=1;$resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN003(2,'$codigo','$denomina_tipo','$tipo','N','$gen_comprobante')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
