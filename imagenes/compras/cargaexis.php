<?php include ("../class/conect.php"); include ("../class/funciones.php"); $existencia="";  
if($_GET["cod_art"]){$cod_art=$_GET["cod_art"]; $cod_alm=$_GET["cod_alm"];}else{$cod_art=""; $cod_alm="000";}
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname.""); 
$StrSQL="select existencia from COMP002 where cod_articulo='$cod_art'";   $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $existencia=$registro["existencia"];
$StrSQL="select existencia from COMP004 where cod_articulo='$cod_art' and cod_almacen='$cod_alm'";   $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $existencia=$registro["existencia"];} $existencia=formato_monto($registro["existencia"]); }
?><input name="txtexistencia" type="text" id="txtexistencia" size="12" maxlength="12" align="right" value=<?php echo $existencia ?>    value="0" readonly> 
<? pg_close();?>