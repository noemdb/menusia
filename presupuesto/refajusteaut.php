<?php include ("../class/conect.php"); include ("../class/funciones.php"); $password=$_GET["password"];$user=$_GET["user"];$dbname=$_GET["dbname"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$ult_ref="00000001";$tipo_ajuste=$_GET["tipo_ajuste"];
$StrSQL="select max(referencia_ajuste) as referencia from pre011 where tipo_ajuste='$tipo_ajuste'";$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;}
?><input class="Estilo10" name="txtreferencia_ajuste" type="text"  id="txtreferencia_ajuste" size="12" onFocus="encender(this);" onBlur="apagar(this);"  onchange="checkreferencia(this.form);" value=<?php echo $ult_ref ?> >
<?pg_close();?>