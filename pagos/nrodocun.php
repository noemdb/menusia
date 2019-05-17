<?php
$tipo_doc=$_GET["tipo_doc"];
if($tipo_doc=="FACTURA"){?>
<input class="Estilo10" name="txtnro_documento" type="text" id="txtnro_documento"  size="55" readonly onkeypress="return stabular(event,this)">
<? }else{?>
<input class="Estilo10" name="txtnro_documento" type="text" id="txtnro_documento"  onFocus="encender(this); " onBlur="apagar(this);" onkeypress="return stabular(event,this)"  size="55">
<? }?>