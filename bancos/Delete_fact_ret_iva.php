<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$codigo_mov=$_GET["codigo_mov"]; $nro_orden=$_GET["orden"];$tipo_retencion=$_GET["tipo"]; $agregar=$_GET["agregar"];
$cod_banco=$_GET["cod_banco"]; $tipo_mov=$_GET["tipo_mov"]; $referencia=$_GET["referencia"];
$url="Det_inc_comp_iva.php?codigo_mov=".$codigo_mov."&agregar=".$agregar; echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$sSQL="SELECT codigo_mov,ced_rif,fecha_emision,monto_pago FROM BAN029 WHERE codigo_mov='$codigo_mov' and tipo_retencion='$tipo_retencion' and cod_banco='$cod_banco' and tipo_mov='$tipo_mov' and referencia='$referencia'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('FACTURA NO EXISTE EN EL COMPROBANTE');</script> <? }
   else{$sSQL="SELECT ELIMINA_BAN029('$codigo_mov','$cod_banco','$tipo_mov','$referencia','$tipo_retencion')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error=substr($error,0,91);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>