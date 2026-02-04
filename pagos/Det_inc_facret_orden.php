<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGO (Incluir Facturas de Retencion ISLR)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llama_Cargar_fact(mcodigo_mov){var murl;
  murl="Carga_fact_sin_ret.php?codigo_mov="+mcodigo_mov; document.location=murl;
}
function Llama_seleccion(mcodigo_mov,n_fact,selec){var murl;
  murl="Selec_fact_sin_ret.php?codigo_mov="+mcodigo_mov+"&nro_fact="+n_fact+"&selec="+selec;   document.location=murl;
}
</script>
</head>
<body>
 <table width="904" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="164">&nbsp;</td>
     <td width="459"><input name="btCargar" type="button" id="btCargar" value="Cargar" title="Cargar Ordenes de Retencion a Cancelar" onclick="javascript:LlamarURL('Carga_fact_sin_ret.php?codigo_mov=<?echo $codigo_mov?>')"></td>
     <td width="345"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar las Facturas sin Retencion ISLR"></td>
     <td width="232">&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td colspan="4">
<?php

$sql="SELECT * FROM pag039 where codigo_mov='$codigo_mov' order by nro_factura";$res=pg_query($sql);
?>
       <table width="800"  border="1" cellspacing='0' cellpadding='0' align="left" id="ord_ret_canceladas">
         <tr height="20" class="Estilo5">
           <td width="20"  align="left" bgcolor="#99CCFF"><strong>Sel.</strong></td>
		   <td width="100"  align="left" bgcolor="#99CCFF"><strong>Nro. Orden</strong></td>
		   <td width="150"  align="left" bgcolor="#99CCFF"><strong>Nro. Factura</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
           <td width="150" align="left" bgcolor="#99CCFF"><strong>Nro. Control</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto sin IVA</strong></td>
           <td width="60" align="right" bgcolor="#99CCFF" ><strong>Tasa IVA</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto con IVA</strong></td>
         </tr>
         <? $total=0; $monto=0; $subtotal=0; 
while($registro=pg_fetch_array($res)){$sfecha=$registro["fecha_factura"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
$monto=$registro["monto_factura"]; $montos=$registro["monto_sin_iva"]; 
if($registro["status_2"]=='N'){$selec=' ';}else{$selec='*';$total=$total+$monto; $subtotal=$subtotal+$montos;} 
$monto=formato_monto($monto); $montos=formato_monto($montos);
$tasa=$registro["tasa_iva1"];  $tasa=formato_monto($tasa);
$montoo=$registro["monto_iva1_so"];  $montoo=formato_monto($montoo);
$montoor=$registro["monto_iva4_so"];  $montoor=formato_monto($montoor);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_seleccion('<? echo $codigo_mov; ?>','<? echo $registro["nro_factura"]; ?>','<? echo $registro["status_2"] ?>');">
           <td width="20" align="left"><? echo $selec; ?></td>
		   <td width="100" align="left"><? echo $registro["campo_str1"]; ?></td>
		   <td width="150" align="left"><? echo $registro["nro_factura"]; ?></td>
           <td width="80" align="left"><? echo $fecha; ?></td>
           <td width="150" align="left"><? echo $registro["nro_con_factura"]; ?></td>
           <td width="100" align="right"><? echo $montos; ?></td>
           <td width="60" align="right"><? echo $tasa; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
         </tr>
<?}  $tiva=$total-$subtotal; $total=formato_monto($total); $subtotal=formato_monto($subtotal); $tiva=formato_monto($tiva);?>
       </table></td>
   </tr>
   <tr>
     <td colspan="4">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="4"><table width="800" border="0">
       <tr>         
		 <td width="100">&nbsp;</td>
         <td width="80"><span class="Estilo5">SUBTOTAL :</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $subtotal; ?></td> </tr>
         </table></td>
         <td width="60"><span class="Estilo5">I.V.A. :</span></td>
         <td width="150"><table width="141" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $tiva; ?></td> </tr>
         </table></td>
         <td width="70"><span class="Estilo5">TOTAL :</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?
  pg_close();
?>