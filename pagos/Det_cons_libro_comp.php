<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Detalles Libro de Compras)</title>
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="845">
<?php if (!$_GET){$mes_libro='';}  else{$mes_libro=$_GET["criterio"]; }
$sql="SELECT * FROM LIBRO_COMP  where mes_libro='$mes_libro' order by mes_libro,nro_operacion";
$res=pg_query($sql);
?>
       <table width="2300"  border="1" cellspacing='0' cellpadding='0' align="left" id="comp_iva">
         <tr height="20" class="Estilo5">
           <td width="40"  align="left" bgcolor="#99CCFF"><strong>Op.N</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Ced/Rif</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Doc.</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha Doc.</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Nro.Factura</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Nro.Control</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Nro.Nota Debito</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Nro.Nota Credito</strong></td>
           <td width="60" align="left" bgcolor="#99CCFF"><strong>Tipo Trans.</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Nro.Fact.Afectada</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Total Compras</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Compras S/derecho</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Base Imponible</strong></td>
           <td width="50" align="right" bgcolor="#99CCFF" ><strong>% Alic.</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Impuesto IVA</strong></td>
           <td width="50" align="right" bgcolor="#99CCFF" ><strong>% Retenc.</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>IVA Retenido</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>Año</strong></td>
           <td width="30" align="center" bgcolor="#99CCFF" ><strong>Mes</strong></td>
           <td width="80" align="center" bgcolor="#99CCFF" ><strong>Comprobante</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Fecha Comp.</strong></td>
		   <td width="300" align="left" bgcolor="#99CCFF"><strong>Concepto</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $sfecha=$registro["fecha_documento"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); $sfecha=$registro["fecha_emision"]; $fechae = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
$monto=formato_monto($registro["monto_documento"]); $montob=formato_monto($registro["base_imponible"]);  $montos=formato_monto($registro["monto_exento_iva"]);
$retenc=formato_monto($registro["tasa_retencion"]); $montoi=formato_monto($registro["monto_iva"]); $tasa=formato_monto($registro["tasa_iva"]); $montor=formato_monto($registro["monto_iva_retenido"]);
$total=$total+$registro["monto_iva_retenido"];
$nro_fact=""; $nro_ndb=""; $nro_ncr=""; if($registro["tipo_documento"]=="01"){$nro_fact=$registro["nro_documento"];}
if($registro["tipo_documento"]=="02"){$nro_ndb=$registro["nro_documento"];} if($registro["tipo_documento"]=="02"){$nro_ncr=$registro["nro_documento"];}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="40" align="left"><? echo $registro["nro_operacion"]; ?></td>
           <td width="100" align="left"><? echo $registro["ced_rif"]; ?></td>
           <td width="300" align="left"><? echo $registro["nombre"]; ?></td>
           <td width="40" align="left"><? echo $registro["tipo_documento"]; ?></td>
           <td width="100" align="left"><? echo $fecha; ?></td>
           <td width="100" align="left"><? echo $nro_fact; ?></td>
           <td width="100" align="left"><? echo $registro["nro_con_documento"]; ?></td>
           <? if ($nro_ndb=="") {?>
           <td width="100" align="left">&nbsp;</td>
           <?}else{?>
           <td width="100" align="left"><? echo $nro_ndb; ?></td>
           <?}?>
           <? if ($nro_ncr=="") {?>
           <td width="100" align="left">&nbsp;</td>
           <?}else{?>
           <td width="100" align="left"><? echo $nro_ncr; ?></td>
           <?}?>
           <td width="60" align="left"><? echo $registro["tipo_transaccion"]; ?></td>
           <? if ($registro["nro_doc_afectado"]=="") {?>
           <td width="100" align="left">&nbsp;</td>
           <?}else{?>
           <td width="100" align="left"><? echo $registro["nro_doc_afectado"]; ?></td>
           <?}?>
           <td width="120" align="right"><? echo $monto; ?></td>
           <td width="120" align="right"><? echo $montos; ?></td>
           <td width="120" align="right"><? echo $montob; ?></td>
           <td width="50" align="right"><? echo $tasa; ?></td>
           <td width="120" align="right"><? echo $montoi; ?></td>
           <td width="50" align="right"><? echo $retenc; ?></td>
           <td width="120" align="right"><? echo $montor; ?></td>
           <? if ($registro["ano_fiscal"]=="") {?>
           <td width="50" align="left">&nbsp;</td>
           <?}else{?>
           <td width="50" align="center"><? echo $registro["ano_fiscal"]; ?></td>
           <?}?>
           <? if ($registro["mes_fiscal"]=="") {?>
           <td width="40" align="left">&nbsp;</td>
           <?}else{?>
           <td width="40" align="center"><? echo $registro["mes_fiscal"]; ?></td>
           <?}?>
           <? if ($registro["nro_comprobante"]=="") {?>
           <td width="100" align="left">&nbsp;</td>
           <?}else{?>
           <td width="100" align="center"><? echo $registro["nro_comprobante"]; ?></td>
           <?}?>
           <td width="100" align="center"><? echo $fechae; ?></td>
		    <? if ($registro["campo_str2"]=="") {?>
           <td width="300" align="left">&nbsp;</td>
           <?}else{?>
		   <td width="300" align="left"><? echo $registro["campo_str2"]; ?></td>
		   <?}?>		   
         </tr>
         <?}
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr> <td>&nbsp;</td>   </tr>
   <tr>
     <td><table width="880" border="0">
       <tr>
         <td width="580">&nbsp;</td>
         <td width="150" align="center"><span class="Estilo5">TOTAL RETENCIONES :</span></td>
         <td><table width="150" border="1" cellspacing="0" cellpadding="0">
           <tr> <td width="123" align="right" class="Estilo5"><? echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<? pg_close(); ?>