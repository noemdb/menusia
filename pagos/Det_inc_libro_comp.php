<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';$agregar="N";}else{$codigo_mov=$_GET["codigo_mov"];$agregar=$_GET["agregar"];}
$ivag=0;$sql="Select * from SIA000"; $res=pg_query($sql); if ($registro=pg_fetch_array($res,0)){$ivag=$registro["campo056"];  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Detalle Libro de Compras)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,operacion){var murl;  murl="Mod_fact_libro_comp.php?codigo_mov="+codigo_mov+"&operacion="+operacion+"&agregar=<?php  echo $agregar; ?>"; document.location=murl;}
</script>
<body>
 <table width="2400" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
          <?php if ($agregar=="S"){?><td width="222" align="center" valign="middle"> <input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Documento al Libro de Compras" onclick="javascript:Llama_Incluir()">   </td>
          <?php }else{?><td width="222" align="center">&nbsp;</td><?php }?>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Codigos de la Orden"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="5"><td> <p>&nbsp;</p></td>  </tr>
   <tr> <td width="2400">
<?php $sql="SELECT * FROM fact_lib_comp where codigo_mov='$codigo_mov' order by to_number(nro_orden,'999999')"; $res=pg_query($sql);
?>
       <table width="2300"  border="1" cellspacing='0' cellpadding='0' align="left" id="libro_comp">
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
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>Ano</strong></td>
           <td width="30" align="center" bgcolor="#99CCFF" ><strong>Mes</strong></td>
           <td width="80" align="center" bgcolor="#99CCFF" ><strong>Comprobante</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Fecha Comp.</strong></td>
		   <td width="300" align="left" bgcolor="#99CCFF"><strong>Concepto</strong></td>
         </tr>
         <?php  $total=0;   $orden=""; $nro_linea=0; $tipo_planilla="00";
while($registro=pg_fetch_array($res))
{ $sfecha=$registro["fecha_factura"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); $sfecha=$registro["fecha_emision"]; $fechac = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); $orden=$registro["nro_orden"];
$monto=formato_monto($registro["monto_pago"]); $montob=formato_monto($registro["monto_objeto"]);  $montos=formato_monto($registro["monto1"]);
$retenc=formato_monto($registro["monto3"]); $montoi=formato_monto($registro["monto2"]);$tasa=formato_monto($registro["tasa"]); $montor=formato_monto($registro["monto_retencion"]); $total=$total+$registro["monto_retencion"];
$nro_fact=""; $nro_ndb=""; $nro_ncr=""; if($registro["tipo_documento"]=="01"){$nro_fact=$registro["nro_documento"];} $nro_linea=$registro["nro_orden"]; $tipo_planilla=$registro["tipo_planilla"];
if($registro["tipo_documento"]=="02"){$nro_ndb=$registro["nro_documento"];} if($registro["tipo_documento"]=="03"){$nro_ncr=$registro["nro_documento"];}
 ?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<?php  echo $codigo_mov; ?>','<?php  echo $registro["nro_orden"]; ?>');" >
           <td width="40" align="left"><?php  echo $registro["nro_orden"]; ?></td>
           <td width="100" align="left"><?php  echo $registro["ced_rif"]; ?></td>
           <td width="300" align="left"><?php  echo $registro["nombre"]; ?></td>
           <td width="40" align="left"><?php  echo $registro["tipo_documento"]; ?></td>
           <td width="100" align="left"><?php  echo $fecha; ?></td>
           <td width="100" align="left"><?php  echo $nro_fact; ?></td>
           <?php  if ($registro["nro_con_factura"]=="") {?>
           <td width="100" align="left">&nbsp;</td>
           <?php }else{?>
           <td width="100" align="left"><?php  echo $registro["nro_con_factura"]; ?></td>
           <?php }?>
           <?php  if ($nro_ndb=="") {?>
           <td width="100" align="left">&nbsp;</td>
           <?php }else{?>
           <td width="100" align="left"><?php  echo $nro_ndb; ?></td>
           <?php }?>
           <?php  if ($nro_ncr=="") {?>
           <td width="100" align="left">&nbsp;</td>
           <?php }else{?>
           <td width="100" align="left"><?php  echo $nro_ncr; ?></td>
           <?php }?>
           <td width="60" align="left"><?php  echo $registro["nro_planilla"]; ?></td>
           <?php  if ($registro["nro_doc_afectado"]=="") {?>
           <td width="100" align="left">&nbsp;</td>
           <?php }else{?>
           <td width="100" align="left"><?php  echo $registro["nro_doc_afectado"]; ?></td>
           <?php }?>
           <td width="120" align="right"><?php  echo $monto; ?></td>
           <td width="120" align="right"><?php  echo $montos; ?></td>
           <td width="120" align="right"><?php  echo $montob; ?></td>
           <td width="50" align="right"><?php  echo $tasa; ?></td>
           <td width="120" align="right"><?php  echo $montoi; ?></td>
           <td width="50" align="right"><?php  echo $retenc; ?></td>
           <td width="120" align="right"><?php  echo $montor; ?></td>
           <td width="50" align="center"><?php  echo $registro["cod_banco"]; ?></td>
           <td width="40" align="center"><?php  echo $registro["tipo_mov"]; ?></td>
           <?php  if ($registro["nro_comprobante"]=="") {?>
           <td width="80" align="left">&nbsp;</td>
           <?php }else{?>
           <td width="80" align="center"><?php  echo $registro["nro_comprobante"]; ?></td>
           <?php }?>
           <td width="100" align="left"><?php  echo $fechac; ?></td>
		   <?php  if ($registro["tipo_en"]=="") {?>
           <td width="300" align="left">&nbsp;</td>
           <?php }else{?>
		   <td width="300" align="left"><?php  echo $registro["tipo_en"]; ?></td>
		   <?php }?>
         </tr>
         <?php }
 $total=formato_monto($total); $nro_linea=$nro_linea+1;
?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td> </tr>
   <tr>
     <td><table width="880" border="0">
       <tr>
         <td width="580">&nbsp;</td>
         <td width="150" align="center"><span class="Estilo5">TOTAL RETENCIONES :</span></td>
         <td><table width="150" border="1" cellspacing="0" cellpadding="0">
           <tr> <td width="123" align="right" class="Estilo5"><?php  echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
<script language="JavaScript" type="text/JavaScript">
function Llama_Incluir(){var murl;  murl="Inc_fact_libro_comp.php?codigo_mov=<?php echo $codigo_mov?>&password=<?php echo $password?>&user=<?php echo $user?>&dbname=<?php echo $dbname?>&ivag=<?php echo $ivag?>&nro_l=<?php echo $nro_linea?>&mes=<?php echo $tipo_planilla?>"; document.location=murl;}
</script>
</body>
</html>
<?php  pg_close($conn); ?>
