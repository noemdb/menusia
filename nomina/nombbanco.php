<?php $cod_banco=$_GET["cod_banco"];$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];   $nombre_banco="";
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname.""); $StrSQL="select nombre_banco,nro_cuenta from ban002 where cod_banco='$cod_banco'";
$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $nombre_banco=$registro["nombre_banco"];} pg_close();?>
<input name="txtnombre_banco" type="text" id="txtnombre_banco" size="45" maxlength="100" value="<?echo $nombre_banco?>" onFocus="encender(this)" onBlur="apagar(this)">
