<?php include ("../class/conect.php");  $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$ult_ref="00000001";
$StrSQL="Select referencia  from CON017 WHERE codigo_mov='$codigo_mov' and modulo='I'"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas>0){$StrSQL="Select max(referencia) as referencia  from CON017 WHERE codigo_mov='$codigo_mov' and modulo='I'"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;
}else{$StrSQL="select max(referencia_mov) as referencia from ingre002"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;} }
?><input name="txtreferencia" type="text"  id="txtreferencia"  size="10" maxlength="8" value=<?php echo $ult_ref ?> onFocus="encender(this)" onBlur="apaga_referencia(this)">
<? pg_close();?>