<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Detalles Causados del Compromiso)</title>
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
</head>
<body>
 <table width="785" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php if (!$_GET){$criterio='';$referencia_comp='';$tipo_diferido='';}
 else{$criterio=$_GET["criterio"];$referencia_comp=substr($criterio,4,8); $tipo_compromiso=substr($criterio,0,4); $cod_comp=substr($criterio,12,4);}
$sql="select * from pre037 where (pre037.referencia_comp='$referencia_comp') and (pre037.tipo_compromiso='$tipo_compromiso') order by fecha_causado,referencia_caus"; $res=pg_query($sql);
?>
       <table width="768"  border="1" cellspacing='0' cellpadding='0' align="left" id="caus_comp">
         <tr height="20" class="Estilo5">
           <td width="110"  align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
                   <td width="90"  align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
                   <td width="190"  align="left" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Ajustado </strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Neto </strong></td>
         </tr>
         <?php  $total=0;$totaln=0;$totala=0;
while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto"]);  $ajustado=formato_monto($registro["ajustado"]); 
  $neto=$registro["monto"]-$registro["pagado"]-$registro["ajustado"];  $totaln=$totaln+$neto;  
  $neto=formato_monto($neto);  $total=$total+$registro["monto"];  $totala=$totala+$registro["ajustado"]; $fecha=$registro["fecha_causado"];
  if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="120" align="left"><?php  echo $registro["referencia_caus"].' '.$registro["tipo_causado"]; ?></td>
            <td width="100" align="left"><?php  echo $fecha; ?></td>
            <td width="190" align="left"><?php  echo $registro["cod_presup"]; ?></td>
           <td width="40" align="left"><?php  echo $registro["fuente_financ"]; ?></td>
           <td width="110" align="right"><?php  echo $monto; ?></td>
           <td width="110" align="right"><?php  echo $ajustado; ?></td>
           <td width="110" align="right"><?php  echo $neto; ?></td>
         </tr>
         <?php }
 $total=formato_monto($total); $totala=formato_monto($totala); $totaln=formato_monto($totaln);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="768" border="0">
       <tr>
         <td width="306">&nbsp;</td>
         <td width="110" align="center"><span class="Estilo5">TOTALES :</span></td>
         <td width="335"><table width="335" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td width="123" align="right" class="Estilo5"><?php  echo $total; ?></td>
             <td width="110" align="right" class="Estilo5"><?php  echo $totala; ?></td>
             <td width="110" align="right" class="Estilo5"><?php  echo $totaln; ?></td>
             </tr>
         </table></td>
       </tr>
     </table>
     <p>&nbsp;</p></td>
   </tr>
   <tr>
     <td align="center"><input name="btcerrar" type="button" id="btcerrar" value="Cerra Ventana" onclick="javascrip:cerrar_ventana();"></td>
   </tr>
</table>
 <p>&nbsp;</p>
</body>
</html>
<?php   pg_close($conn); ?>