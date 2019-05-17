<?php include ("../class/conect.php"); include ("../class/funciones.php"); $tipo_nomina=$_GET["tipo_nomina"]; $cod_empleado=$_GET["cod_empleado"]; $fecha_nomina=$_GET["fecha_nomina"]; 
?>
<iframe src="Det_conc_hist_nom.php?cod_empleado=<?echo $cod_empleado?>&tipo_nomina=<?echo $tipo_nomina?>&fecha_nomina=<?echo $fecha_nomina?>" width="950" height="350" scrolling="auto" frameborder="1"></iframe>
