<?php include ("../class/conect.php"); include ("../class/funciones.php"); $cod_banco=$_GET["cod_banco"];$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];   $nro_cuenta="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $StrSQL="select nombre_banco,nro_cuenta from ban002 where cod_banco='$cod_banco'";
$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $nro_cuenta=$registro["nro_cuenta"];} pg_close();?>
<input name="txtcuenta_new" type="text" id="txtcuenta_new" size="30" maxlength="30" value="<?echo $nro_cuenta?>" onFocus="encender(this)" onBlur="apagar(this)">
