<?php include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");   error_reporting(E_ALL);

$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");

$sql="select * from comp002 where existencia>0  order by cod_articulo"; $res=pg_query($sql);
while($reg=pg_fetch_array($res)){ 
  $cod_articulo=$reg["cod_articulo"]; $des_articulo=$reg["des_articulo"];  
  $unidad_medida=$reg["unidad_medida"]; $existencia=$reg["existencia"]; $ultimo_costo=$reg["ultimo_costo"];   $impuesto=$reg["impuesto"];
  $monto_iva=$ultimo_costo*($impuesto/100); $total_iva=$monto_iva*$existencia;
  
  $linea="INSERT INTO comp045 (nro_ajuste, codigo_articulo, unidad_medida, cantidad_ajuste, costo_actual, tasa_impuesto, existencia_actual, monto_iva, total_iva, unidad_p_a, relacion, descripcion_articulo)
                    VALUES ('00000001', '".$cod_articulo."', '".$unidad_medida."',".$existencia.",".$ultimo_costo.",".$impuesto.",0,".$monto_iva.",".$total_iva.",'', 0, '".$des_articulo."');";

 echo $linea,"<br>";
  
}



pg_close(); error_reporting(E_ALL ^ E_WARNING); 
?>