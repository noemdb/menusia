<?php include ("../class/conect.php"); if($_GET["municipio"]){$municipio=$_GET["municipio"];$cod_estado=$_GET["cod_estado"];}else{$municipio="";$cod_estado="";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select * from PRE093 where substr(cod_municipio,1,2)='".$cod_estado."'  order by cod_municipio";  $res=pg_query($StrSQL);
?><select name="txtmunicipio" id="txtmunicipio" onFocus="encender(this)" onBlur="apagar(this);">  <?php
while($registro=pg_fetch_array($res)){$codigo=$registro["cod_municipio"];  $nombre=$registro["nombre_municipio"];
if($nombre==$municipio){?><option value="<?php echo $nombre;?>" selected><?php echo $nombre;?></option>
<?php }else{?><option value="<?php echo $nombre;?>"><?php echo $nombre;?></option> <?php }}?></select><?php pg_close();?>
