<?php include ("../class/conect.php");  include ("../class/funciones.php");
$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"]; $mref=$_GET["mref"]; $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$montoc=0;$tipo=substr($mref,0,4);$refcomp=substr($mref,5,8);$fuente=substr($mref,14,2); $codigo=substr($mref,17,32);
$StrSQL="select * from pre026 where codigo_mov='$codigo_mov' and cod_presup='$codigo' and fuente_financ='$fuente' and referencia_comp='$refcomp' and tipo_compromiso='$tipo'";
$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $montoc=$registro["monto"];}$montoc=formato_monto($montoc);
?><input class="Estilo10" name="txtmonto_objeto" type="text" id="txtmonto_objeto" size="15" style="text-align:right" maxlength="22" onFocus="encender(this)" onBlur="apaga_objeto(this)"  onchange="chequea_objeto(this.form);" value="<?php echo $montoc ?>" onKeypress="return validarNum(event)" >
<?pg_close();?>
