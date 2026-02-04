<?php include ("../class/conect.php"); if($_GET["ciudad"]){$ciudad=$_GET["ciudad"];$cod_estado=$_GET["cod_estado"];}else{$ciudad="";$cod_estado="";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select * from PRE094 where substr(cod_ciudad,1,2)='".$cod_estado."'  order by cod_ciudad";  $res=pg_query($StrSQL);
?><select name="txtciudad" id="txtciudad" onFocus="encender(this)" onBlur="apagar(this);">  <?php
while($registro=pg_fetch_array($res)){$codigo=$registro["cod_ciudad"];  $nombre=$registro["nombre_ciudad"];
if($nombre==$ciudad){?><option value="<?php echo $nombre;?>" selected><?php echo $nombre;?></option>
<?php }else{?><option value="<?php echo $nombre;?>"><?php echo $nombre;?></option> <?php }}?></select><?php pg_close();?>
