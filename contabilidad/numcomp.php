<?php include ("../class/conect.php"); $fecha=$_GET["fecha"]; $tipo=$_GET["tipo"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $ult_ref="00000001";
$StrSQL="select max(referencia) as referencia from con002 where tipo_asiento='$tipo' and referencia<='99999999'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;}

?><input name="txtReferencia" type="text"  id="txtReferencia"   size="10" maxlength="8" value=<?php echo $ult_ref ?> onFocus="encender(this)" onBlur="apagar(this)"  onchange="checkreferencia(this.form)">
<? pg_close();?>