<?php  include ("../../class/conect.php"); include ("../../class/funciones.php");   
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname.""); 
$StrSQL="select * from nom047  order by cod_reporte";  $res=pg_query($StrSQL);
?><select name="txtnomb_rpt" id="txtnomb_rpt" onFocus="encender(this)" onBlur="apagar(this);">  <?
while($registro=pg_fetch_array($res)){$codigo=$registro["cod_reporte"];  $nombre=$registro["des_repote"]."  ";
?><option value="<? echo $codigo;?>"><? echo $nombre;?></option>
<?}?></select><?pg_close();?>