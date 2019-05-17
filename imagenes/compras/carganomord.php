<?php   
$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];  $nro_ord=$_GET["nro_ord"];  $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$ano1=substr($fecha,6,9);$mes1=substr($fecha,3,2);$dia1=substr($fecha,0,2); $sfecha=$ano1.$mes1.$dia1; $rif_proveedor=""; $nombre=""; 
$sql="Select * from ORD_COMPRA where nro_orden='$nro_ord' and anulado='N'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>0){$registro=pg_fetch_array($res); $rif_proveedor=$registro["rif_proveedor"]; $nombre=$registro["nombre"];  }
pg_close();?>
<input name="txtnombre" type="text" id="txtnombre" value="<?echo $nombre?>" size="89"  class="Estilo5"  readonly> 