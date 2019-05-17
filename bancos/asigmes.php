<?php include ("../class/conect.php"); include ("../class/funciones.php"); $cod_banco=$_GET["cod_banco"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $temp_mes="01";
$sql="SELECT * FROM ban009 where cod_banco='".$cod_banco."'";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$reg=pg_fetch_array($res,0); $temp_mes=$reg["u_conciliacion"];} pg_close(); ?>
<select name="txtmes" id="txtmes">
<?if($temp_mes=="00"){?><option selected>01</option><?}else{?><option>01</option><?}?>
<?if($temp_mes=="01"){?><option selected>02</option><?}else{?><option>02</option><?}?>
<?if($temp_mes=="02"){?><option selected>03</option><?}else{?><option>03</option><?}?>
<?if($temp_mes=="03"){?><option selected>04</option><?}else{?><option>04</option><?}?>
<?if($temp_mes=="04"){?><option selected>05</option><?}else{?><option>05</option><?}?>
<?if($temp_mes=="05"){?><option selected>06</option><?}else{?><option>06</option><?}?>
<?if($temp_mes=="06"){?><option selected>07</option><?}else{?><option>07</option><?}?>
<?if($temp_mes=="07"){?><option selected>08</option><?}else{?><option>08</option><?}?>
<?if($temp_mes=="08"){?><option selected>09</option><?}else{?><option>09</option><?}?>
<?if($temp_mes=="09"){?><option selected>10</option><?}else{?><option>10</option><?}?>
<?if($temp_mes=="10"){?><option selected>11</option><?}else{?><option>11</option><?}?>
<?if($temp_mes=="11"){?><option selected>12</option><?}else{?><option>12</option><?}?>
</select>

