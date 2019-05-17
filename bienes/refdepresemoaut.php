<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$nro_aut=$_GET["nro_aut"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select max(referencia_dep) as referencia_dep from bien029"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia_dep"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;}
if($nro_aut=='S'){?>
<input class="Estilo10" name="txtreferencia_dep" type="text"  id="txtreferencia_dep" size="8" maxlength="8" value=<?php echo $ult_ref ?> readonly>
<? }else{?>
<input class="Estilo10" name="txtreferencia_dep" type="text"  id="txtreferencia_dep" size="8" maxlength="8" onFocus="encender(this); " onBlur="apagar(this);" onchange="checkreferencia_dep(this.form);" value=<?php echo $ult_ref ?>>
<? }
pg_close();  error_reporting(E_ALL ^ E_WARNING); ?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script>
