<?php include ("../class/conect.php"); include ("../class/funciones.php"); $existencia="";  
if($_GET["cod_art"]){$cod_art=$_GET["cod_art"]; $cod_alm=$_GET["cod_alm"]; $unidad=$_GET["unidad"];}else{$cod_art=""; $cod_alm="000"; $unidad="";}
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname.""); 
$StrSQL="select existencia,unidad_medida,unidad_alterna,relacion  from COMP002 where cod_articulo='$cod_art'";   $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $existencia=$registro["existencia"]; $unidad_medida=$registro["unidad_medida"]; 
$unidad_alterna=$registro["unidad_alterna"]; $relacion=$registro["relacion"]; if($unidad==$unidad_alterna){$relacion=$relacion;}else{$relacion=1;}
$StrSQL="select existencia from COMP004 where cod_articulo='$cod_art' and cod_almacen='$cod_alm'";   $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $existencia=$registro["existencia"];} $existencia=$existencia*$relacion; $existencia=formato_monto($existencia); }
?><input name="txtexistencia" type="text" id="txtexistencia" size="12" maxlength="12" align="right" value=<?php echo $existencia ?>    value="0" readonly> 
<? pg_close();?>