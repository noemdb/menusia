<?include ("../class/conect.php");  include ("../class/funciones.php"); 
 if($_GET["rif"]){$rif=$_GET["rif"];}else{$rif="";}  if($_GET["codigo_mov"]){$codigo_mov=$_GET["codigo_mov"];}else{$codigo_mov="";}
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$sql="SELECT comp042.fuente_financ,comp042.cod_presup,comp005.nombre_proveedor FROM comp042 left join comp005 on (comp005.ced_rif=comp042.cod_presup) where comp042.codigo_mov='$codigo_mov' and comp042.cod_almacen<>'000' order by comp042.fuente_financ,comp042.nro_linea";
$res=pg_query($sql); $prev_cot=""; 
?><select name="txtced_rif" id="txtced_rif" onFocus="encender(this)" onBlur="apaga_crif(this);" class="Estilo5">  <?
while($registro=pg_fetch_array($res)){if($prev_cot<>$registro["fuente_financ"]){ $prev_cot=$registro["fuente_financ"];
$codigo=$registro["cod_presup"];  $nombre=$registro["nombre_proveedor"];
if($codigo==$rif){?><option value="<? echo $nombre;?>" selected><? echo $codigo;?></option>
<?}else{?><option value="<? echo $nombre;?>"><? echo $codigo;?></option>
<?} } }?></select><?pg_close();?>