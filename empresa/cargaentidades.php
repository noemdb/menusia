<?php include ("../class/conect.php"); if($_GET["mestado"]){$estado=$_GET["mestado"];}else{$estado="";}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select * from PRE091 order by cod_estado";  $res=pg_query($StrSQL);
?><select name="txtestado" id="txtestado" onFocus="encender(this)" onBlur="apagar(this);" onchange="chequea_estado(this.form)">  <?
while($registro=pg_fetch_array($res)){$codigo=$registro["cod_estado"];  $nombre=$registro["estado"];
if($nombre==$estado){?><option value="<? echo $codigo;?>" selected><? echo $nombre;?></option>
<?}else{?><option value="<? echo $codigo;?>"><? echo $nombre;?></option> <?}}?></select><?pg_close();?>
