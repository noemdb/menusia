<?include ("../class/conect.php");  include ("../class/funciones.php"); 
$cod_cuenta=$_GET["cod_cuenta"]; $codigo_mov=$_GET["codigo_mov"]; $debito_credito=$_GET["debito_credito"];
echo "ESPERE POR FAVOR ELIMINANDO....";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn))  {?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{   $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='$debito_credito'";  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
  if ($filas==0){?> <script language="JavaScript">  muestra('CODIGO DE CUENTA NO EXISTE'); </script>    <? }
   else{  $registro=pg_fetch_array($resultado);
     if ($registro["modificable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CUENTA NO PUEDE SER MODIFICADA EN EL COMPROBANTE');</script><?}
     else{ $resultado=pg_exec($conn,"SELECT ELIMINA_CUENTA_CON010('$codigo_mov','$debito_credito','$cod_cuenta')");
     $error=pg_errormessage($conn);$error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }}
  }
}
pg_close();?><script language="JavaScript">document.location ='Det_inc_comp_libro.php?codigo_mov=<?echo $codigo_mov?>';</script>