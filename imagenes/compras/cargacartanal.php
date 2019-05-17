<?include ("../class/conect.php");  include ("../class/funciones.php"); 
 if($_GET["cod_art"]){$cod_art=$_GET["cod_art"];}else{$cod_art="";}  if($_GET["codigo_mov"]){$codigo_mov=$_GET["codigo_mov"];}else{$codigo_mov="";}
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$sql="SELECT * FROM comp042 where codigo_mov='$codigo_mov' and cod_almacen='000' order by nro_linea"; $res=pg_query($sql); 
?><select name="txtcod_articulo" id="txtcod_articulo" onFocus="encender(this)" onBlur="apaga_cart(this);" class="Estilo5">  <?
while($registro=pg_fetch_array($res)){$codigo=$registro["codigo_articulo"];  $nombre=$registro["des_articulo"];
if($codigo==$cod_art){?><option value="<? echo $nombre;?>" selected><? echo $codigo;?></option>
<?}else{?><option value="<? echo $nombre;?>"><? echo $codigo;?></option>
<?}  }?></select><?pg_close();?>