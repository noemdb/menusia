<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Detalles C&oacute;digos del Pago)</title>
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
</head>
<body>
 <table width="1610" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1610">
       <?php
if (!$_GET){$criterio='';$referencia_comp='';$tipo_compromiso='';$tipo_causado=''; $referencia_caus='';$tipo_pago=''; $referencia_pago=''; $cod_banco='';}
 else{$criterio=$_GET["criterio"];$tipo_pago=substr($criterio,0,4); $referencia_pago=substr($criterio,4,8);;$referencia_caus=substr($criterio,16,8);$tipo_causado=substr($criterio,12,4); $referencia_comp=substr($criterio,28,8); $tipo_compromiso=substr($criterio,24,4);$cod_banco=substr($criterio,36,4);
}
$sql="SELECT * FROM codigos_pagos where tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_banco='$cod_banco' order by cod_presup";
$res=pg_query($sql);
?>
       <table width="1590"  border="1" cellspacing='0' cellpadding='0' align="left" id="cod_pagos">
         <tr height="20" class="Estilo5">
           <td width="222"  align="left" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
           <td width="47" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="560" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Ajustado </strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Neto </strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Credito </strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Tipo Imputacion</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF" ><strong>Referencia Cred.</strong></td>
         </tr>
         <?php  $total=0;$totaln=0;$totala=0;$totalr=0;
while($registro=pg_fetch_array($res))
{ $monto=formato_monto($registro["monto"]);  $ajustado=formato_monto($registro["ajustado"]);
  $monto_credito=formato_monto($registro["monto_credito"]);
  $neto=$registro["monto"]-$registro["ajustado"];
  $totaln=$totaln+$neto;$totalr=$totalr+$registro["monto_credito"];
  $total=$total+$registro["monto"];$totala=$totala+$registro["ajustado"];$neto=formato_monto($neto);
  $tipo_imput_presu=$registro["tipo_imput_presu"];
  $ref_imput_presu=$registro["ref_imput_presu"];
  if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="222" align="left"><?php  echo $registro["cod_presup"]; ?></td>
           <td width="47" align="left"><?php  echo $registro["fuente_financ"]; ?></td>
           <td width="560" align="left"><?php  echo $registro["denominacion"]; ?></td>
           <td width="120" align="right"><?php  echo $monto; ?></td>
           <td width="120" align="right"><?php  echo $ajustado; ?></td>
           <td width="120" align="right"><?php  echo $neto; ?></td>
           <td width="120" align="right"><?php  echo $monto_credito; ?></td>
           <td width="120" align="left"><?php  echo $tipo_imput_presu; ?></td>
           <td width="100" align="left"><?php  echo $ref_imput_presu; ?></td>
         </tr>
         <?php }
 $total=formato_monto($total);$totala=formato_monto($totala);$totalr=formato_monto($totalr);$totaln=formato_monto($totaln);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="1390" border="0">
       <tr>
         <td width="290">&nbsp;</td>
         <td width="469">&nbsp;</td>
         <td width="87" align="center"><span class="Estilo5">TOTALES :</span></td>
         <td width="506"><table width="485" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td width="128" align="right" class="Estilo5"><?php  echo $total; ?></td>
             <td width="125" align="right" class="Estilo5"><?php  echo $totala; ?></td>
             <td width="125" align="right" class="Estilo5"><?php  echo $totaln; ?></td>
             <td width="125" align="right" class="Estilo5"><?php  echo $totalr; ?></td>
           </tr>
         </table></td>
       </tr>
       <tr>
         <td width="290">&nbsp;</td>
         <td width="469">&nbsp;</td>
         <td width="87" align="center">&nbsp;</td>
         <td width="506"><table width="488" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="128">&nbsp;</td>
             <td width="125" align="center"><input name="btajustado" type="button" id="btajustado" value="Ajustes" onclick="javascrip:Ventana_002('Det_aju_pago.php?criterio=<?php  echo $criterio; ?>','SIPAP','','580','400','true')"></td>
             <td width="125">&nbsp;</td>
             <td width="125">&nbsp;</td>
           </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?php  pg_close($conn); ?>