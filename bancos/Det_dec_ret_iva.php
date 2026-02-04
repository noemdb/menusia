<?php include ("../class/conect.php");  include ("../class/funciones.php"); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];}  $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGO (Detalles Planillas de Retenci�n)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
<table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr height="5"> <td><p>&nbsp;</p></td></tr>
   <tr> <td>
<?php 
$sql="SELECT * FROM BAN029 where codigo_mov='$codigo_mov' order by tipo_retencion,nro_planilla";
$res=pg_query($sql);
?>
 <table width="1410" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1400">
       <table width="1400"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_orden">
         <tr height="20" class="Estilo5">
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Rif</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha Doc.</strong></td>
           <td width="50"  align="left" bgcolor="#99CCFF"><strong>Tipo Op.</strong></td>
           <td width="50" align="left" bgcolor="#99CCFF"><strong>Tipo Doc.</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Nro.Documento</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Nro.Control</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto Documento</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Base Imponible</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>IVA Retenido</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Nro.Doc.Afectado</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Nro.Comprobante</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto Exento</strong></td>
           <td width="80" align="right" bgcolor="#99CCFF" ><strong>% Alic.</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF" ><strong>Nro.Expediente</strong></td>
         </tr>
<?php  $total=0;
while($registro=pg_fetch_array($res))
{ $monto_r=formato_monto($registro["monto_retencion"]); $monto_p=formato_monto($registro["monto_pago"]); $monto_o=formato_monto($registro["monto_objeto"]); $monto_e=formato_monto($registro["monto2"]); $tasa=formato_monto($registro["tasa"]);
  $sfecha=$registro["fecha_factura"];  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);  $total=$total+$registro["monto_retencion"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<?php  echo $codigo_mov; ?>','<?php  echo $registro["nro_orden"]; ?>','<?php  echo $registro["tipo_retencion"]; ?>','<?php  echo $registro["aux_orden"]; ?>','<?php  echo $registro["tipo_planilla"]; ?>','<?php  echo $registro["nro_planilla"]; ?>');">
           <td width="100" align="left"><?php  echo $registro["ced_rif"]; ?></td>
           <td width="100" align="left"><?php  echo $fecha; ?></td>
           <td width="50" align="left"><?php  echo $registro["tipo_operacion"]; ?></td>
           <td width="50" align="center"><?php  echo $registro["tipo_documento"]; ?></td>
           <td width="100" align="left"><?php  echo $registro["nro_documento"]; ?></td>
           <td width="100" align="left"><?php  echo $registro["nro_con_factura"]; ?></td>
           <td width="120" align="right"><?php  echo $monto_p; ?></td>
           <td width="120" align="right"><?php  echo $monto_o; ?></td>
           <td width="120" align="right"><?php  echo $monto_r; ?></td>
           <?php  if ($registro["nro_doc_afectado"]=="") {?>
           <td width="100" align="left">&nbsp;</td>
           <?php }else{?>
           <td width="100" align="left"><?php  echo $registro["nro_doc_afectado"]; ?></td>
           <?php }?>
           <td width="100" align="left"><?php  echo $registro["nro_comprobante"]; ?></td>
           <td width="120" align="right"><?php  echo $monto_e; ?></td>
           <td width="50" align="right"><?php  echo $tasa; ?></td>
           <td width="100" align="left"><?php  echo $registro["tipo_en"]; ?></td>
         </tr>
         <?php }
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr> <td>&nbsp;</td> </tr>  <tr> <td>&nbsp;</td> </tr>
   <tr>
     <td><table width="880" border="0">
       <tr>
         <td width="580">&nbsp;</td>
         <td width="150" align="center"><span class="Estilo5">TOTAL :</span></td>
         <td><table width="150" border="1" cellspacing="0" cellpadding="0">
           <tr> <td width="123" align="right" class="Estilo5"><?php  echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?php  pg_close($conn); ?>