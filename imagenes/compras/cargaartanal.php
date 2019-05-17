<?php   
$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];  $nro_req=$_GET["nro_req"];  $codigo_mov=$_GET["codigo_mov"]; $fecha=$_GET["fecha"];
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$res=pg_exec($conn,"SELECT BORRAR_COMP042('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 91); if(!$res){echo $error; }
$ano1=substr($fecha,6,9);$mes1=substr($fecha,3,2);$dia1=substr($fecha,0,2); $sfecha=$ano1.$mes1.$dia1; 
$sql="SELECT * FROM ART_REQUISICION  where nro_requisicion='$nro_req' order by nro_linea,cod_articulo";$res=pg_query($sql); $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $cod_articulo=$registro["cod_articulo"]; $nro_linea=$registro["nro_linea"]; $cantidad=$registro["cant_requerida"]; $des_articulo=$registro["descripcion_articulo"];
 $marca=$registro["marca"]; $modelo=$registro["modelo"]; $unidad_medida=$registro["unidad_medida"]; $costo=$registro["costo_actual"]; $impuesto=$registro["tasa_impuesto"];
 $ssql="SELECT ACTUALIZA_COMP042(1,'$codigo_mov','$cod_articulo','00000000','0000000000','$nro_linea','','$sfecha','$marca','$modelo','$unidad_medida','','00',$costo,$impuesto,0,0,0,$cantidad,0,0,0,0,0,0,'000','','$sfecha','','','$nro_req','',0,0,'','$sfecha','','','$des_articulo','')";
 $resultado=pg_exec($conn,$ssql);     $error=pg_errormessage($conn);
  
}pg_close();?>

<iframe src="Det_inc_art_anal.php?codigo_mov=<?echo $codigo_mov?>" width="846" height="340" scrolling="auto" frameborder="0">
</iframe>