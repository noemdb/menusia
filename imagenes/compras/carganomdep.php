<?php   
$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];  $nro_req=$_GET["nro_req"];  $codigo_mov=$_GET["codigo_mov"]; $fecha=$_GET["fecha"];
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$ano1=substr($fecha,6,9);$mes1=substr($fecha,3,2);$dia1=substr($fecha,0,2); $sfecha=$ano1.$mes1.$dia1; $concepto="";
$sql="SELECT * FROM REQUISICIONES  where nro_requisicion='$nro_req'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>0){$registro=pg_fetch_array($res);  $concepto=$registro["observacion"]; $des_unidad_sol=$registro["denominacion_cat"]; $unidad_solicitante=$registro["unidad_solicitante"];  $nombre_departamento=$registro["nombre_departamento"]; }
pg_close();?>
<input name="txtnombre_departamento" type="text" id="txtnombre_departamento" size="100" readonly class="Estilo5" value="<?echo $nombre_departamento?>">
                          