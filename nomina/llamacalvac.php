<?php $codigo_mov=$_GET["codigo_mov"]; $cod_empleado=$_GET["cod_empleado"]; $fdesde=$_GET["fdesde"]; $fdhasta=$_GET["fdhasta"]; $fddesde=$_GET["fddesde"]; $fhasta=$_GET["fhasta"]; $mbase=$_GET["mbase"]; $mbono=$_GET["mbono"]; $dbono=$_GET["dbono"]; $mdianh=$_GET["mdianh"];
 $parametro="T"; $criterio=$cod_empleado.$fdesde.$fhasta.$codigo_mov; $cant_cal=1;
?>
<iframe src="Calcula_conc_vacaciones.php?codigo_mov=<?echo $codigo_mov?>&cod_empleado=<?echo $cod_empleado?>&fdesde=<?echo $fdesde?>&fhasta=<?echo $fhasta?>&fddesde=<?echo $fddesde?>&fdhasta=<?echo $fdhasta?>&mbono=<?echo $mbono?>&dbono=<?echo $dbono?>&mbase=<?echo $mbase?>&mdianh=<?echo $mdianh?>&cant_cal=<?echo $cant_cal?>" width="850" height="300" scrolling="auto" frameborder="1"></iframe>