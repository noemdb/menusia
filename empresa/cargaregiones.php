<?php include ("../class/conect.php"); if($_GET["mregion"]){$region=$_GET["mregion"];}else{$region="";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select * from PRE092 order by cod_region";  $res=pg_query($StrSQL);
?><select name="txtregion" id="txtregion" onFocus="encender(this)" onBlur="apagar(this);">  <?
while($registro=pg_fetch_array($res)){$codigo=$registro["cod_region"];  $nombre=$registro["nombre_region"];
if($nombre==$region){?><option value="<? echo $nombre;?>" selected><? echo $nombre;?></option>
<?}else{?><option value="<? echo $nombre;?>"><? echo $nombre;?></option>
<?}}?></select><?pg_close();?>
