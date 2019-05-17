<?include ("../class/conect.php"); include ("../class/funciones.php");  $nro_aut="S";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$ult_ref="00000001"; $tipo_dife=$_GET["tipo_dife"];
$StrSQL="select max(referencia_dife) as referencia from pre023 where tipo_diferido='$tipo_dife' and referencia_dife<='99999999' and (referencia_dife ~ '^[0-9]+$')";$resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;}{?>
<input name="txtreferencia_dife" type="text"  id="txtreferencia_dife" size="12" onFocus="encender(this);" onBlur="apagar(this);"  onchange="checkreferencia(this.form);" value=<?php echo $ult_ref ?> >
<?}pg_close();?>