<?php include ("../class/conect.php");  include ("../class/funciones.php"); $nro_aut=$_GET["nro_aut"];$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"]; $port=$_GET["port"]; $host=$_GET["host"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $ult_ref="00000001";
$StrSQL="select max(referencia_aju_ord) as referencia from pag019"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;}
if($nro_aut=='S'){?>
<input class="Estilo10" name="txtreferencia_aju" type="text"  id="txtreferencia_aju" size="10" maxlength="8" value=<?php echo $ult_ref ?> readonly>
<? }else{?>
<input class="Estilo10" name="txtreferencia_aju" type="text"  id="txtreferencia_aju" size="10" maxlength="8" onFocus="encender(this); " onBlur="apagar(this);" onchange="checkreferencia(this.form);" value=<?php echo $ult_ref ?>>
<? }
pg_close();?>