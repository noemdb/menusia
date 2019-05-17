<?php
$tipo_doc=$_GET["tipo_doc"];$codigo_mov=$_GET["codigo_mov"];
if($tipo_doc=="FACTURA"){?><input name="btfacturas" type="button" id="btfacturas" title="Registrar Facturas de la Orden " onClick="Llamar_factura();" value="..." onkeypress="return stabular(event,this)">
<? }else{?>&nbsp;<? }?>