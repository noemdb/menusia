<?php $tipo_nomina=$_GET["tipo_nomina"];$fdesde=$_GET["fdesde"];$fhasta=$_GET["fhasta"]; $num_semana=$_GET["num_semana"]; $u_semana=$_GET["u_semana"];  $parametro="E";
$criterio=$tipo_nomina.$fdesde.$fhasta.$num_semana.$parametro.$u_semana;?>
<iframe src="Cal_nom_trab.php?criterio=<?echo $criterio?>" width="950" height="350" scrolling="auto" frameborder="1"></iframe>