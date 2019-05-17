<?php  $password=$_GET["password"]; $user=$_GET["user"]; $dbname=$_GET["dbname"];  $nro_aut=$_GET["nro_aut"]; $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
$ult_ref="00000001"; $tipo_comp=$_GET["tipo_pago"]; $filas=0;
$StrSQL="Select referencia  from CON017 WHERE codigo_mov='$codigo_mov' and modulo='E' and referencia<'99999999'"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado); 
if($filas>0){
$StrSQL="Select max(referencia) as referencia  from CON017 WHERE codigo_mov='$codigo_mov' and modulo='E' and referencia<'99999999'"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
$registro=pg_fetch_array($resultado);  $ult_ref=$registro["referencia"]; $ult_ref=$ult_ref+1;$len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;
}else{$StrSQL="select max(referencia_pago) as referencia from pre008 where tipo_pago='$tipo_comp' and referencia_pago<'99999999'";$resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;} }
if($nro_aut=='S'){?><input name="txtreferencia_pago" type="text"  id="txtreferencia_pago" size="10" maxlength="8" value=<?php echo $ult_ref ?> readonly></div></td>
<? }else{?><input name="txtreferencia_pago" type="text"  id="txtreferencia_pago" size="10" maxlength="8" onFocus="encender(this);" onBlur="apaga_referencia(this);"  onchange="checkreferencia(this.form);" value=<?php echo $ult_ref ?> >
<?}pg_close();?>