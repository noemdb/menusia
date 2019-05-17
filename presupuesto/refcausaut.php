<?php include ("../class/conect.php"); include ("../class/funciones.php");  $password=$_GET["password"];$user=$_GET["user"];$dbname=$_GET["dbname"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$ult_ref="00000001";$tipo_caus=$_GET["tipo_caus"];
$StrSQL="select max(referencia_caus) as referencia from pre007 where tipo_causado='$tipo_caus'";$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;}
?><input class="Estilo10" name="txtreferencia_caus" type="text"  id="txtreferencia_caus" size="12" maxlength="8" onFocus="encender(this);" onBlur="apagar(this);"  onchange="checkreferencia(this.form);" value=<?php echo $ult_ref ?> >
<?pg_close();?>