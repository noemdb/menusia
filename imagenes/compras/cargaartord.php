<?php   
$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];  $nro_ord=$_GET["nro_ord"];  $codigo_mov=$_GET["codigo_mov"]; $fecha=$_GET["fecha"];
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$res=pg_exec($conn,"SELECT BORRAR_COMP042('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 91); if(!$res){echo $error; }
$ano1=substr($fecha,6,9);$mes1=substr($fecha,3,2);$dia1=substr($fecha,0,2); $sfecha=$ano1.$mes1.$dia1; 
$sql="SELECT * FROM art_ord_compra  where nro_orden='$nro_ord' order by nro_linea";$res=pg_query($sql); $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ 
 $cod_articulo=$registro["codigo_articulo"]; $cantidad=$registro["cantidad_ordenada"]; $recibida=$registro["cantidad_recibida"]; $por_recibir=$cantidad-$recibida;
 $des_articulo=$registro["descripcion_articulo"]; $nro_linea=$registro["nro_linea"]; $des_articulo=str_replace("&#195;&#8216;","Ñ",$des_articulo);
 $marca=$registro["marca"]; $modelo=$registro["modelo"]; $unidad_medida=$registro["unidad_medida"]; $costo=$registro["costo"]; $impuesto=$registro["tasa_impuesto"];
 if($por_recibir>0){ $ssql="SELECT ACTUALIZA_COMP042(1,'$codigo_mov','$cod_articulo','00000000','0000000000','$nro_linea','','$sfecha','$marca','$modelo','$unidad_medida','','00',$costo,$impuesto,0,0,0,$por_recibir,0,0,0,0,0,0,'000','','$sfecha','','S','$nro_ord','',0,0,'','$sfecha','','','$des_articulo','')";
 $resultado=pg_exec($conn,$ssql);     $error=pg_errormessage($conn); }
}pg_close();?>
<iframe src="Det_inc_rec_orden.php?codigo_mov=<?echo $codigo_mov?>" width="846" height="290" scrolling="auto" frameborder="0">
</iframe>