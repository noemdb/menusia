<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$codigo_mov=$_GET["codigo_mov"]; $ref_comp=$_GET["ref_comp"];$ced_rif=$_GET["ced_rif"];$nro_factura=$_GET["factura"];
$url="Det_inc_fact_ord.php?codigo_mov=".$codigo_mov."&ref_comp=".$ref_comp."&ced_rif=".$ced_rif;
echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$sSQL="Select * from PAG029 WHERE codigo_mov='$codigo_mov' and nro_factura='$nro_factura'";$resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('FACTURA NO EXISTE EN LA ORDEN');</script> <? }
   else{$sSQL="SELECT ACTUALIZA_PAG029(3,'$codigo_mov','$nro_factura','','','','2007-01-01',0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','','','','')";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>