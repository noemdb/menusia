<?php   
$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];  $nro_req=$_GET["nro_req"];  $codigo_mov=$_GET["codigo_mov"]; $fecha=$_GET["fecha"];
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$ano1=substr($fecha,6,9);$mes1=substr($fecha,3,2);$dia1=substr($fecha,0,2); $sfecha=$ano1.$mes1.$dia1; $concepto="";
$sql="SELECT * FROM REQUISICIONES  where nro_requisicion='$nro_req'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>0){$registro=pg_fetch_array($res);  $concepto=$registro["observacion"];}
pg_close();?>
<textarea name="txtdescripcion" cols="89"  onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="txtdescripcion"><?echo $concepto?></textarea>
