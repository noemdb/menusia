<?php include ("../class/conect.php"); include ("../class/funciones.php"); $ramo=$_GET["ramo"];  $cod_servicio ="";  $part="000001";
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="Select max(cod_servicio) As cod_servicio  FROM COMP027 where substring(cod_servicio ,1,3)='$ramo'";  $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $part=$registro["cod_servicio"];  $part=substr($part,4,6); if(is_numeric($part)){$part=$part+1;}else{$part="000001";} $part=Rellenarcerosizq($part,6); } $cod_servicio =$ramo.'-'.$part;  pg_close();?>
<input name="txtcod_servicio" type="text" id="txtcod_servicio" size="15" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $cod_servicio ?>" >