<?php include ("../class/conect.php"); include ("../class/funciones.php");   if($_GET["tasa"]){$tasa=$_GET["tasa"];}else{$tasa=0;}
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname.""); $StrSQL="select * from COMP023 order by monto_tasa";  $res=pg_query($StrSQL);
?><select name="txtimpuesto" id="txtimpuesto" onFocus="encender(this)" onBlur="apagar(this);">  <?
while($registro=pg_fetch_array($res)){$codigo=$registro["cod_tasa"];  $mtasa=$registro["monto_tasa"];  $mtasa=formato_monto($mtasa);
if($mtasa==$tasa){?><option value="<? echo $mtasa;?>" selected><? echo $mtasa;?></option>
<?}else{?><option value="<? echo $mtasa;?>"><? echo $mtasa;?></option>
<?}}?></select><?pg_close();?>