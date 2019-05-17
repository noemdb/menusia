<?php $cod_cat=$_GET["cod_cat"];$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname.""); $des_unidad="";
$StrSQL="SELECT * FROM COMP029 where categoria_prog='$cod_cat' order by categoria_prog,cod_unidad_sol"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $des_unidad=$registro["des_unidad_sol"]; } ?>
<input name="txtlugar_entrega" type="text" id="txtlugar_entrega" size="90" maxlength="70" readonly  value=<? echo $des_unidad; ?>>
<?pg_close();?>