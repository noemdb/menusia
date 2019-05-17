<?php include ("../class/conect.php"); include ("../class/funciones.php");   if($_GET["tasa"]){$tasa=$_GET["tasa"];}else{$tasa=0;} $mtasa=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $StrSQL="select * from COMP023 order by monto_tasa";  $res=pg_query($StrSQL);
?><select class="Estilo10" name="txtimpuesto" id="txtimpuesto" onFocus="encender(this)" onBlur="apaga_tasa(this)" onkeypress="return stabular(event,this)">  <?
while($registro=pg_fetch_array($res)){$codigo=$registro["cod_tasa"];  $mtasa=$registro["monto_tasa"];  $mtasam=formato_monto($mtasa);
if($mtasam==$tasa){?><option value="<? echo $mtasa;?>" selected><? echo $mtasa;?></option>
<?}else{?><option value="<? echo $mtasa;?>"><? echo $mtasa;?></option>
<?}}
if($mtasa==0){?><option value="<? echo $tasa;?>" selected><? echo $tasa;?></option><? }
?></select><?pg_close();?>