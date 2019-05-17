<?php include ("../class/conect.php");  include ("../class/funciones.php"); $password=$_GET["password"];  $user=$_GET["user"];$dbname=$_GET["dbname"]; $criterio=$_GET["criterio"]; $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);$nro_orden=$criterio; $concepto="";
$sql="SELECT * FROM pag001 where nro_orden='$nro_orden' and status='N' and anulado='N'";  $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){$registro=pg_fetch_array($res,0); $tipo_causado=$registro["tipo_causado"]; $concepto=$registro["concepto"]; }
pg_close();?>
<textarea name="txtdescripcion" cols="85" onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="txtdescripcion"><?echo $concepto?></textarea> 
