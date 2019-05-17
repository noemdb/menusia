<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Detalles C&oacute;digos del Compromiso)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="1610" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1610">
       <?php
if (!$_GET){$criterio='';$referencia_comp='';$tipo_compromiso='';}
 else{$criterio=$_GET["criterio"];$referencia_comp=substr($criterio,4,8); $tipo_compromiso=substr($criterio,0,4); $cod_comp=substr($criterio,12,4);}
$sql="SELECT * FROM codigos_compromisos where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_comp='$cod_comp' order by cod_presup"; $res=pg_query($sql);
?>
       <table width="1590"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="190"  align="left" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="500" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Causado </strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Pagado </strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Ajustado </strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Neto </strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Credito </strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Tipo Imputacion</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF" ><strong>Referencia Cred.</strong></td>
         </tr>
         <? $total=0;$totaln=0;$totalc=0;$totalp=0;$totala=0;$totalr=0;
while($registro=pg_fetch_array($res))
{ $monto=formato_monto($registro["monto"]); $causado=formato_monto($registro["causado"]);
  $pagado=formato_monto($registro["pagado"]); $ajustado=$registro["ajustado"]*-1; 
  $monto_credito=formato_monto($registro["monto_credito"]);
  $neto=$registro["monto"]-$registro["causado"]-$registro["ajustado"]; $neto=round($neto,2);
  $totaln=$totaln+$neto;$totalr=$totalr+$registro["monto_credito"];
  $total=$total+$registro["monto"];$totalc=$totalc+$registro["causado"];
  $totalp=$totalp+$registro["pagado"];$totala=$totala+$ajustado;
  $neto=formato_monto($neto); $ajustado=formato_monto($ajustado);
  $tipo_imput_presu=$registro["tipo_imput_presu"];
  $ref_imput_presu=$registro["ref_imput_presu"];
  if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="190" align="left"><? echo $registro["cod_presup"]; ?></td>
           <td width="40" align="left"><? echo $registro["fuente_financ"]; ?></td>
           <td width="500" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="110" align="right"><? echo $monto; ?></td>
           <td width="110" align="right"><? echo $causado; ?></td>
           <td width="110" align="right"><? echo $pagado; ?></td>
           <td width="110" align="right"><? echo $ajustado; ?></td>
           <td width="110" align="right"><? echo $neto; ?></td>
           <td width="110" align="right"><? echo $monto_credito; ?></td>
           <td width="120" align="left"><? echo $tipo_imput_presu; ?></td>
           <td width="100" align="left"><? echo $ref_imput_presu; ?></td>
         </tr>
         <?}
 $total=formato_monto($total);$totalc=formato_monto($totalc);$totalp=formato_monto($totalp);
 $totala=formato_monto($totala);$totalr=formato_monto($totalr);$totaln=formato_monto($totaln);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="1403" border="0">
       <tr>
         <td width="234">&nbsp;</td>
         <td width="352">&nbsp;</td>
         <td align="center"><span class="Estilo5">TOTALES :</span></td>
         <td><table width="685" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td width="123" align="right" class="Estilo5"><? echo $total; ?></td>
             <td width="110" align="right" class="Estilo5"><? echo $totalc; ?></td>
             <td width="110" align="right" class="Estilo5"><? echo $totalp; ?></td>
             <td width="110" align="right" class="Estilo5"><? echo $totala; ?></td>
             <td width="110" align="right" class="Estilo5"><? echo $totaln; ?></td>
             <td width="110" align="right" class="Estilo5"><? echo $totalr; ?></td>
           </tr>
         </table></td>
       </tr>
       <tr>
         <td width="234">&nbsp;</td>
         <td width="352">&nbsp;</td>
         <td width="94" align="center">&nbsp;</td>
         <td width="686"><table width="685" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="123">&nbsp;</td>
             <td width="110" align="center"><input name="btcausado" type="button" id="btcausado" value="Causados" onclick="javascrip:Ventana_002('Det_caus_comp.php?criterio=<? echo $criterio; ?>','SIA','','790','400','true')"></td>
             <td width="110" align="center"><input name="btpagado" type="button" id="btpagado" value="Pagos" onclick="javascrip:Ventana_002('Det_pag_comp.php?criterio=<? echo $criterio; ?>','SIA','','790','400','true')"></td>
             <td width="110" align="center"><input name="btajustado" type="button" id="btajustado" value="Ajustes" onclick="javascrip:Ventana_002('Det_aju_comp.php?criterio=<? echo $criterio; ?>','SIA','','580','400','true')"></td>
             <td width="110">&nbsp;</td>
             <td width="110">&nbsp;</td>
           </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<? pg_close(); ?>