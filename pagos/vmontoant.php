<?php include ("../class/conect.php");  include ("../class/funciones.php");
$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];
$tasa=$_GET["tasa"];$cod_cuenta=$_GET["cod_cuenta"];$codigo_mov=$_GET["codigo_mov"]; if(is_numeric($tasa)){$tasa=$tasa;} else{$tasa=0;} $monto=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select * from pag036 where codigo_mov='$codigo_mov'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $total=$registro["total_retencion"]; $monto=$total*($tasa/100);  $monto=round($monto,2); 
$StrSQL="SELECT UPDATE_PAG036_MONTO(1,'$codigo_mov',$monto,0)"; $resultado=pg_exec($conn,$StrSQL); $sSQL="SELECT UPDATE_PAG036_ANT('$codigo_mov',$tasa,'S','$cod_cuenta')";   $resultado=pg_exec($conn,$sSQL); } $monto=formato_monto($monto);
?> <input name="txtmonto" type="text" id="txtmonto" size="20" align="right" maxlength="20" onFocus="encender(this)" onBlur="apaga_monto(this);" onchange="checkmonto(this.form);" value="<? echo $monto?>"> <? pg_close();?>