<? include ("../class/conect.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Detalles Facturas de la Orden)</title>
<LINK   href="../class/sia.css" type="text/css"   rel="stylesheet">
</head>
<body>
 <table width="1084" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
if (!$_GET){$criterio='';$nro_orden='';}else{$criterio=$_GET["clave"];$nro_orden=substr($criterio,0,8);}
$sql="SELECT * FROM PAG016  where nro_orden='$nro_orden' order by nro_factura";$res=pg_query($sql);
?>
       <table width="1180"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_pasivo">
         <tr height="20" class="Estilo5">
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Rif Factura</strong></td>
           <td width="150"  align="left" bgcolor="#99CCFF"><strong>Nro. Factura</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
           <td width="170" align="left" bgcolor="#99CCFF"><strong>Nro. Control</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto sin IVA</strong></td>
           <td width="60" align="right" bgcolor="#99CCFF" ><strong>Tasa IVA</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto Objeto</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto con IVA</strong></td>
		   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Objeto Retencion</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Ref.Comp</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
         </tr>
         <? $total=0; $subtotal=0;
while($registro=pg_fetch_array($res)){  $sfecha=$registro["fecha_factura"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
$monto=$registro["monto_factura"]; $total=$total+$monto; $monto=formato_monto($monto);
$montos=$registro["monto_sin_iva"]; $subtotal=$subtotal+$montos; $montos=formato_monto($montos);
$tasa=$registro["tasa_iva1"];  $tasa=formato_monto($tasa);
$montoo=$registro["monto_iva1_so"];  $montoo=formato_monto($montoo);
$montoor=$registro["monto_iva4_so"];  $montoor=formato_monto($montoor);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="100" align="left"><? echo $registro["rif_factura"]; ?></td>
           <td width="150" align="left"><? echo $registro["nro_factura"]; ?></td>
           <td width="80" align="left"><? echo $fecha; ?></td>
           <td width="170" align="left"><? echo $registro["nro_con_factura"]; ?></td>
           <td width="100" align="right"><? echo $montos; ?></td>
           <td width="60" align="right"><? echo $tasa; ?></td>
           <td width="100" align="right"><? echo $montoo; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
		   <td width="100" align="right"><? echo $montoor; ?></td>
           <td width="80" align="left"><? echo $registro["ref_compromiso"]; ?></td>
           <td width="40" align="left"><? echo $registro["tipo_compromiso"]; ?></td>
         </tr>
         <?}
 $tiva=$total-$subtotal;
 $total=formato_monto($total);
 $subtotal=formato_monto($subtotal);
 $tiva=formato_monto($tiva);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="700" border="0">
       <tr>
         <td width="20">&nbsp;</td>
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
     </table><p>&nbsp;</p></td>
   </tr>
   <tr>
     <td align="center"><input name="btcerrar" type="button" id="btcerrar" value="Cerra Ventana" onclick="javascrip:cerrar_ventana();"></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?
  pg_close();
?>