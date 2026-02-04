<?php include ("../class/conect.php"); if($_GET["mregion"]){$region=$_GET["mregion"];}else{$region="";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select * from PRE092 order by cod_region";  $res=pg_query($StrSQL);
?><select name="txtregion" id="txtregion" onFocus="encender(this)" onBlur="apagar(this);">  <?php
while($registro=pg_fetch_array($res)){$codigo=$registro["cod_region"];  $nombre=$registro["nombre_region"];
if($nombre==$region){?><option value="<?php echo $nombre;?>" selected><?php echo $nombre;?></option>
<?php }else{?><option value="<?php echo $nombre;?>"><?php echo $nombre;?></option>
<?php }}?></select><?php pg_close();?>
