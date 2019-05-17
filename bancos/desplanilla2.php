<?php include ("../class/conect.php");  include ("../class/funciones.php"); $codigo=$_GET["codigo"];$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"]; $descripcion="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $ult_ref="00000000";
$StrSQL="select descripcion from ban011 where codigo='$codigo'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $descripcion=$registro["descripcion"];}
pg_close();?> <input class="Estilo10" name="txtdescripcion" type="text" id="txtdescripcion" size="80" value="<? echo $descripcion ?>" readonly>