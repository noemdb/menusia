<?php include ("../class/conect.php");  include ("../class/funciones.php");
$password=$_GET["password"]; $user=$_GET["user"]; $dbname=$_GET["dbname"]; $codigo_mov=$_GET["codigo_mov"];$tipo=$_GET["tipo"];$refcomp=$_GET["refcomp"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$montoc=0;
$StrSQL="select sum(monto) as total from pre036 where referencia_comp='$refcomp' and tipo_compromiso='$tipo' and cod_presup not like '%403-18-01%'";
$resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $montoc=$registro["total"];}
$montoc=formato_monto($montoc);
?> <input class="Estilo10" name="txtmonto_sin_iva" type="text" id="txtmonto_sin_iva" size="22" style="text-align:right" onFocus="encende_monto(this);" onBlur="apaga_monto(this)"  onchange="chequea_monto(this.form);" value="<?echo $montoc?>" onKeypress="return validarNum(event,this)">
<?pg_close();?>