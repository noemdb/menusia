<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Detalles C&oacute;digos de la Modificaciones)</title>
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="845">
       <?php
if (!$_GET){$criterio='';$referencia_modif=''; $tipo_modif=''; }
 else{$criterio=$_GET["criterio"];$referencia_modif=substr($criterio,0,8); $tipo_modif=substr($criterio,8,1);}
$sql="SELECT * FROM codigos_modif where tipo_modif='$tipo_modif' and referencia_modif='$referencia_modif' order by cod_presup";
$res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="40"  align="left" bgcolor="#99CCFF"><strong>Grupo</strong></td>
           <td width="190"  align="left" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="420" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
           <td width="40"  align="left" bgcolor="#99CCFF"><strong>Oper.</strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
         </tr>
        <? $total=0; $totaln=0; $totalm=0;
while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto"]); $total=$total+$registro["monto"]; if($registro["operacion"]=="+"){$totalm=$totalm+$registro["monto"];}else{$totaln=$totaln+$registro["monto"];}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="40" align="left"><? echo $registro["grupo"]; ?></td>
           <td width="190" align="left"><? echo $registro["cod_presup"]; ?></td>
           <td width="40" align="left"><? echo $registro["fuente_financ"]; ?></td>
           <td width="420" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="40" align="center"><? echo $registro["operacion"]; ?></td>
           <td width="110" align="right"><? echo $monto; ?></td>
         </tr>
         <?} $total=formato_monto($total); $totalm=formato_monto($totalm); $totaln=formato_monto($totaln);?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
<? if(($tipo_modif=='5')or($tipo_modif=='2')){?> 
     <td><table width="842" border="0">
       <tr>
         <td width="78">&nbsp;</td>
         <td width="128">&nbsp;</td>
         <td width="80"><span class="Estilo5">TOTAL (+):</span></td>
         <td width="204"><table width="151" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td align="right" class="Estilo5"><? echo $totalm; ?></td>
           </tr>
         </table></td>
         <td width="93"><span class="Estilo5">TOTAL (-):</span></td>
         <td width="233"><table width="151" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td align="right" class="Estilo5"><? echo $totaln; ?></td>
           </tr>
         </table></td>
       </tr>
     </table></td>
<?} else{ ?> 
     <td><table width="842" border="0">
       <tr>
         <td width="133">&nbsp;</td>
         <td width="438">&nbsp;</td>
         <td width="82"><span class="Estilo5">TOTAL :</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td align="right" class="Estilo5"><? echo $total; ?></td>
           </tr>
         </table></td>
       </tr>
     </table></td>
<?} ?> 
 
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<? pg_close(); ?>