<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL); $nro_aut=$_GET["nro_aut"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select max(referencia) as referencia from bien043"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;}
if($nro_aut=='S'){?>
<input class="Estilo10" name="txtreferencia" type="text"  id="txtreferencia" size="10" maxlength="8" value='<?php echo $ult_ref ?>' readonly>
<? }else{?>
<input class="Estilo10" name="txtreferencia" type="text" id="txtreferencia" size="10" maxlength="8"  onFocus="encender(this); " onBlur="apagar(this);"  onchange="checkreferencia(this.form);" value='<?php echo $ult_ref ?>'>
<? } pg_close();  ?> 
