<?php  include ("../class/conect.php"); include ("../class/funciones.php");   
if($_GET["cod_art"]){$cod_art=$_GET["cod_art"];}else{$cod_art="";}
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname.""); $unidad_medida=""; $unidad_alterna="";
$StrSQL="select unidad_medida,unidad_alterna from COMP002 where cod_articulo='$cod_art'";   $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $unidad_medida=$registro["unidad_medida"]; $unidad_alterna=$registro["unidad_alterna"]; }
pg_close();
?>
<select name="txtunidad_medida" size="1" id="txtunidad_medida" onFocus="encender(this)" onBlur="apaga_unidad(this)"> 
<option value="<? echo $unidad_medida;?>" selected><? echo $unidad_medida;?></option> 
<option value="<? echo $unidad_alterna;?>" ><? echo $unidad_alterna;?></option>
</select>
