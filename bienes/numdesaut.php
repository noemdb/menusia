<?php  include ("../class/conect.php");  include ("../class/funciones.php");  $ult_ref="00000001"; $cod_c=$_GET["cod_c"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select max(num_descrip) as referencia from BIEN033 where codigo_c='$cod_c' and num_descrip<='99999999'";$resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;}
pg_close();
?><input class="Estilo10" name="txtnum_descrip" type="text" id="txtnum_descrip" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" value=<? echo $ult_ref ?> >
