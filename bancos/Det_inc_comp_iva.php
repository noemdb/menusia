<?include ("../class/conect.php");  include ("../class/funciones.php"); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';$agregar="N";}else{$codigo_mov=$_GET["codigo_mov"];$agregar=$_GET["agregar"];}
$ivag=0;$sql="Select * from SIA000"; $res=pg_query($sql); if ($registro=pg_fetch_array($res,0)){$ivag=$registro["campo056"]; $opn=0;  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTROL BANCARIO (Detalles Comprobante Retencion IVA)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,operacion){var murl;  murl="Mod_fact_ret_iva.php?codigo_mov="+codigo_mov+"&operacion="+operacion+"&agregar=<? echo $agregar; ?>"; document.location=murl;}
</script>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
          <?if ($agregar=="S"){?><td width="222" align="center" valign="middle"> <input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar retencion Iva" onclick="javascript:Llama_Incluir('<? echo $opn; ?>')">   </td>
          <?}else{?><td width="222" align="center">&nbsp;</td><?}?>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Codigos de la Orden"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="5"><td> <p>&nbsp;</p></td>  </tr>
   <tr> <td width="845">
<?php $sql="SELECT * FROM BAN029 where codigo_mov='$codigo_mov' order by tipo_retencion,nro_planilla"; $res=pg_query($sql);
?>
       <table width="1640"  border="1" cellspacing='0' cellpadding='0' align="left" id="comp_iva">
         <tr height="20" class="Estilo5">
           <td width="40"  align="left" bgcolor="#99CCFF"><strong>Op.N</strong></td>
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
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>Cod.B.</strong></td>
           <td width="40" align="center" bgcolor="#99CCFF" ><strong>Mov.</strong></td>
           <td width="80" align="center" bgcolor="#99CCFF" ><strong>Referencia</strong></td>
         </tr>
         <? $total=0; $opn=0;  $orden="";
while($registro=pg_fetch_array($res))
{ $sfecha=$registro["fecha_factura"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); $opn=$registro["tipo_retencion"]; $orden=$registro["nro_orden"];
$monto=formato_monto($registro["monto_pago"]); $montob=formato_monto($registro["monto_objeto"]);  $montos=formato_monto($registro["monto1"]);
$retenc=formato_monto($registro["monto3"]); $montoi=formato_monto($registro["monto2"]);$tasa=formato_monto($registro["tasa"]); $montor=formato_monto($registro["monto_retencion"]); $total=$total+$registro["monto_retencion"];
$nro_fact=""; $nro_ndb=""; $nro_ncr=""; if($registro["tipo_documento"]=="01"){$nro_fact=$registro["nro_documento"];}
if($registro["tipo_documento"]=="02"){$nro_ndb=$registro["nro_documento"];} if($registro["tipo_documento"]=="02"){$nro_ncr=$registro["nro_documento"];}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["tipo_retencion"]; ?>');" >
           <td width="40" align="left"><? echo $registro["tipo_retencion"]; ?></td>
           <td width="40" align="left"><? echo $registro["tipo_documento"]; ?></td>
           <td width="100" align="left"><? echo $fecha; ?></td>
           <td width="100" align="left"><? echo $nro_fact; ?></td>
           <td width="100" align="left"><? echo $registro["nro_con_factura"]; ?></td>
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
           <td width="60" align="left"><? echo $registro["nro_planilla"]; ?></td>
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
           <td width="50" align="center"><? echo $registro["cod_banco"]; ?></td>
           <td width="40" align="center"><? echo $registro["tipo_mov"]; ?></td>
           <td width="80" align="center"><? echo $registro["referencia"]; ?></td>
         </tr>
         <?}
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td> </tr>
   <tr> <td><table width="842" border="0">
       <tr>
         <td width="133">&nbsp;</td>
         <td width="418">&nbsp;</td>
         <td width="102"><span class="Estilo5">TOTAL PLANILLA :</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
         <tr> <td align="right" class="Estilo5"><? echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
<script language="JavaScript" type="text/JavaScript">
function Llama_Incluir(num_op){var murl; num_op=num_op*1; num_op=num_op+1; murl="Inc_fact_ret_iva.php?codigo_mov=<?echo $codigo_mov?>&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>&ivag=<?echo $ivag?>&opn=<?echo $opn?>&orden=<?echo $orden?>"; document.location=murl;}
</script>
</body>
</html>
<? pg_close(); ?>