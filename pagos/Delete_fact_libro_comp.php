<?include ("../class/conect.php");  include ("../class/funciones.php"); 
error_reporting(E_ALL);$codigo_mov=$_GET["codigo_mov"]; $nro_orden=$_GET["orden"];$tipo_retencion=$_GET["tipo"]; $agregar=$_GET["agregar"];
$url="Det_inc_libro_comp.php?codigo_mov=".$codigo_mov."&agregar=".$agregar;
echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$sSQL="SELECT codigo_mov,ced_rif,fecha_emision,monto_pago,cod_banco,tipo_mov,referencia FROM BAN029 WHERE codigo_mov='$codigo_mov' and tipo_retencion='$tipo_retencion' and nro_orden='$nro_orden'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('FACTURA NO EXISTE EN LA ORDEN');</script> <? }
   else{$registro=pg_fetch_array($resultado); $cod_banco=$registro["cod_banco"]; $tipo_mov=$registro["tipo_mov"]; $referencia=$registro["referencia"]; $sSQL="SELECT ELIMINA_BAN029('$codigo_mov','$cod_banco','$tipo_mov','$referencia','$tipo_retencion')"; echo $sSQL; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>