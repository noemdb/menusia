<?php include ("../class/conect.php");  include ("../class/funciones.php"); $nro_aut=$_GET["nro_aut"];$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $ult_ref="00000001";
$StrSQL="select max(nro_orden) as referencia from pag001"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;}
if($nro_aut=='S'){?>
<input class="Estilo10" name="txtnro_orden" type="text"  id="txtnro_orden" size="12" maxlength="8" value="<?php echo $ult_ref ?>" onkeypress="return stabular(event,this)" readonly>
<? }else{?>
<input class="Estilo10" name="txtnro_orden" type="text"  id="txtnro_orden" size="12" maxlength="8" onFocus="encender(this); " onBlur="apagar(this);" onchange="checkreferencia(this.form);" value="<?php echo $ult_ref ?>" onkeypress="return stabular(event,this)">
<? }
pg_close();?>