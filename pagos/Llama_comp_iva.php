<?  include ("../class/conect.php"); include ("../class/funciones.php");
if (!$_GET){$nro_orden='';$tipo_causado='';}  else {$nro_orden=$_GET["txtnro_orden"];$tipo_causado=$_GET["txttipo_causado"]; }
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$fecha=""; $ced_rif=""; $nombre_benef=""; $nro_comprobante='';  $ano_fiscal='';  $mes_fiscal='';
$sql="Select * from COMP_IVA where referencia='$nro_orden' and tipo_mov='O/P'";  $res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);
  $nro_comprobante=$registro["nro_comprobante"]; $ano_fiscal=$registro["ano_fiscal"]; $mes_fiscal=$registro["mes_fiscal"];
  $fecha=$registro["fecha_emision"];  $ced_rif=$registro["ced_rif"];   $nombre_benef=$registro["nombre"];  $inf_usuario=$registro["inf_usuario"];
}
$clave=$ano_fiscal.$mes_fiscal.$nro_comprobante; $url="../pagos/rpt/Rpt_comp_ret_iva.php?criterio=".$clave;
pg_close(); ?> <script language="JavaScript"> document.location='<? echo $url; ?>';</script><?

