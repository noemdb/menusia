<?php include ("../class/conect.php");  include ("../class/funciones.php");
$op=$_GET["op"]; $cod_est=$_GET["cod_est"]; $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$cedrif="";$tipo_ord="";$nomb="";$concepto_est="";$fecha_d="";$fecha_h="";
$sql="SELECT * FROM ESTRUCTURA_ORD where cod_estructura='$cod_est'";
$res=pg_query($sql);  if ($registro=pg_fetch_array($res,0)) {$cedrif=$registro["ced_rif_est"]; $nomb=$registro["nombre"]; $tipo_ord=$registro["cod_tipo_ord"]; $concepto_est=$registro["concepto_est"]; $fecha_d=$registro["fecha_desde_est"];  $fecha_h=$registro["fecha_hasta_est"];}
if($fecha_d==""){$fecha_d="";}else{$fecha_d=formato_ddmmaaaa($fecha_d);}  if($fecha_h==""){$fecha_h="";}else{$fecha_h=formato_ddmmaaaa($fecha_h);}
?>
<? if($op=='1'){?><input class="Estilo10" name="txtced_rif" type="text" id="txtced_rif" size="15" maxlength="15" onFocus="encender(this); " onBlur="apaga_cedrif(this);" onchange="checkcedrif(this.form);" value="<?php echo $cedrif ?>" onkeypress="return stabular(event,this)">  <? }?>
<? if($op=='2'){?><textarea  class="Estilo10" name="txtconcepto" cols="95" onFocus="encender(this); " onBlur="apagar(this);" class="headers" id="txtconcepto" onkeypress="return stabular(event,this)"><?echo $concepto_est?></textarea>   <? }?>
<? if($op=='3'){?><input class="Estilo10" name="txttipo_orden" type="text" id="txttipo_orden" size="8" maxlength="15"  onFocus="encender(this);" onBlur="apaga_tipoord(this);" onchange="checktipoord(this.form);"  value="<?php echo $tipo_ord ?>" onkeypress="return stabular(event,this)">  <? }?>
<? if($op=='4'){?><input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde" size="15" onchange="checkrefecha_desde(this.form)" onFocus="encender(this);" onBlur="apagar(this);" value="<?echo $fecha_d?>" onkeypress="return stabular(event,this)" >  <? }?>
<? if($op=='5'){?><input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" onFocus="encender(this);" onchange="checkrefecha_hasta(this.form)" onBlur="apagar(this);" size="15" value="<?echo $fecha_h?>" onkeypress="return stabular(event,this)" >   <? }?>
<?pg_close();?>