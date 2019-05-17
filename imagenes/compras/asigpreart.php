<?php include ("../class/conect.php"); include ("../class/funciones.php");  $cod_articulo="";  $part="0000000001";
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="Select max(cod_articulo) As cod_articulo FROM COMP072 "; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $part=$registro["cod_articulo"];  $part=substr($part,4,6); if(is_numeric($part)){$part=$part+1;}else{$part="0000000001";} $part=Rellenarcerosizq($part,10); } $cod_articulo=$part;  pg_close();?>
<input name="txtcod_articulo" type="text" id="txtcod_articulo" size="15" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $cod_articulo?>" >