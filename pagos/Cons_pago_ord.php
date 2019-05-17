<?include ("../class/conect.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Cheques de la Orden)</title>
<LINK  href="../class/sia.css" type=text/css  rel=stylesheet>
</head>
<body>
 <table width="640" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
if (!$_GET){$criterio='';$nro_orden='';} else{$criterio=$_GET["clave"];$nro_orden=substr($criterio,0,8);}
$sql="SELECT * FROM PAG007  where nro_orden='$nro_orden' order by fecha_cheque,cod_banco,nro_cheque";$res=pg_query($sql);
?>
       <table width="630"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_pasivo">
         <tr height="20" class="Estilo5">
           <td width="120"  align="left" bgcolor="#99CCFF"><strong>Fecha Cheque</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Cod. Banco</strong></td>
           <td width="120" align="left" bgcolor="#99CCFF"><strong>Nro. Cheque</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto Cheque</strong></td>
           <td width="60" align="center" bgcolor="#99CCFF" ><strong>Anulado</strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Fecha Anulado</strong></td>
         </tr>
         <? $total=0; $subtotal=0;
while($registro=pg_fetch_array($res))
{  $sfecha=$registro["fecha_cheque"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
$monto=$registro["monto_pago"];  $monto=formato_monto($monto);
if ($registro["anulado"]=="N"){$total=$total+$registro["monto_pago"]; $fechaa ="";}
else{$sfecha=$registro["fecha_anulado"]; $fechaa = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="170" align="left"><? echo $fecha; ?></td>
           <td width="80" align="left"><? echo $registro["cod_banco"]; ?></td>
           <td width="170" align="left"><? echo $registro["nro_cheque"]; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
           <td width="60" align="center"><? echo $registro["anulado"]; ?></td>
           <td width="100" align="left"><? echo $fechaa; ?></td>
         </tr>
         <?}
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="620" border="0">
       <tr>
         <td width="250">&nbsp;</td>
         <td width="60"><span class="Estilo5">TOTAL :</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total; ?></td> </tr>
         </table></td>
         <td width="150">&nbsp;</td>
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
<?  pg_close(); ?>