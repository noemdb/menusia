<?php include ("../class/conect.php");  include ("../class/funciones.php");
$codigo_mov=$_GET["codigo_mov"]; $cod_presup=$_GET["cod_presup"]; $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$montoc=0; $total=0; $subtotal=0;
$sql="SELECT * FROM PAG029 where codigo_mov='$codigo_mov' order by nro_factura"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){$monto=$registro["monto_factura"]; $total=$total+$monto; $montos=$registro["monto_sin_iva"]; $subtotal=$subtotal+$montos;}
$tiva=$total-$subtotal; $busca='403-18-01'; $pos2=stripos($cod_presup, $busca);
if($pos2!== false){$montoc=formato_monto($tiva);} else {$montoc=formato_monto($subtotal);}
?><input class="Estilo10" name="txtmonto" type="text" id="txtmonto" size="25" style="text-align:right" maxlength="22" onFocus="encender(this)" onBlur="apaga_monto(this)"  onchange="chequea_monto(this.form);" onKeypress="return validarNum(event)"  value=<?php echo $montoc ?>>
<?pg_close();?>