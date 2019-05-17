<?php $tipo_nomina=$_GET["tipo_nomina"];$cod_concepto=$_GET["cod_concepto"];$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];
$criterio=$tipo_nomina.$cod_concepto;?>
<iframe src="Inc_prestamo.php?criterio=<?echo $criterio?>" width="950" height="350" scrolling="auto" frameborder="1"></iframe>