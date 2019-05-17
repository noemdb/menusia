<? include ("../class/conect.php"); include ("../class/funciones.php");  $password=$_GET["password"];$user=$_GET["user"];$dbname=$_GET["dbname"];$corr_m=$_GET["corr_m"]; $nro_aut=$_GET["nro_aut"]; $ult_ref="00000001";$tipo_modif=$_GET["tipo_modif"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if($corr_m=="S"){$StrSQL="select max(referencia_modif) as referencia from pre009 where tipo_modif='$tipo_modif' and referencia_modif<='99999999'";}  else{$StrSQL="select max(referencia_modif) as referencia from pre009 where referencia_modif<='99999999'";}
$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;}
if($nro_aut=='S'){?><input class="Estilo10" name="txtreferencia_modif" type="text"  id="txtreferencia_modif" size="12" value="<?php echo $ult_ref ?>"  readonly>
<? }else{?><input class="Estilo10" name="txtreferencia_modif" type="text"  id="txtreferencia_modif" size="12" onFocus="encender(this)" onBlur="apagar(this)"  onchange="checkreferencia(this.form)" value="<?php echo $ult_ref ?>" onKeypress="return stabular(event,this)">
<?} pg_close();?>