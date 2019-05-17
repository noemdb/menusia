<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Detalles Codigos de la Orden)</title>
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
</head>
<body>
 <table width="1610" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1610">
       <?php
if (!$_GET){$criterio='';$tipo_causado=''; $referencia_caus='';}
 else{$criterio=$_GET["clave"];$referencia_caus=substr($criterio,0,8);  $tipo_causado=substr($criterio,8,4);
}
$sql="SELECT * FROM codigos_causados where tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' order by referencia_comp,tipo_compromiso,cod_presup";
$res=pg_query($sql);
?>
       <table width="1900"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Ref.Comp</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="190"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="500" align="center" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Causado </strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Cod.Cuenta </strong></td>
           <td width="400" align="left" bgcolor="#99CCFF" ><strong>Nombre Cuenta </strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Tipo Imputacion</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF" ><strong>Referencia Cred.</strong></td>
           <td width="110" align="left" bgcolor="#99CCFF" ><strong>Credito </strong></td>
         </tr>
         <? $total=0;$totaln=0;$totalp=0;$totala=0;$totalr=0;
while($registro=pg_fetch_array($res))
{ $monto=formato_monto($registro["monto"]);
  $pagado=formato_monto($registro["pagado"]); $ajustado=formato_monto($registro["ajustado"]);
  $monto_credito=formato_monto($registro["monto_credito"]);
  $neto=$registro["monto"]-$registro["pagado"]-$registro["ajustado"];
  $totaln=$totaln+$neto;$totalr=$totalr+$registro["monto_credito"];
  $total=$total+$registro["monto"];$totalp=$totalp+$registro["pagado"];
  $totala=$totala+$registro["ajustado"];  $neto=formato_monto($neto);
  $tipo_imput_presu=$registro["tipo_imput_presu"];
  $ref_imput_presu=$registro["ref_imput_presu"];
  if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="80" align="left"><? echo $registro["referencia_comp"]; ?></td>
           <td width="40" align="left"><? echo $registro["tipo_compromiso"]; ?></td>
           <td width="190" align="left"><? echo $registro["cod_presup"]; ?></td>
           <td width="40" align="left"><? echo $registro["fuente_financ"]; ?></td>
           <td width="500" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="110" align="right"><? echo $monto; ?></td>
           <td width="120" align="left"><? echo $registro["cod_contable"]; ?></td>
           <td width="400" align="left"><? echo $registro["nombre_cuenta"]; ?></td>
           <td width="120" align="left"><? echo $tipo_imput_presu; ?></td>
           <td width="100" align="left"><? echo $ref_imput_presu; ?></td>
           <td width="110" align="right"><? echo $monto_credito; ?></td>
         </tr>
         <?}
 $total=formato_monto($total);$totalp=formato_monto($totalp);
 $totala=formato_monto($totala);$totalr=formato_monto($totalr);$totaln=formato_monto($totaln);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="830" border="0">
       <tr>
         <td width="530">&nbsp;</td>
         <td width="150" align="center"><span class="Estilo5">TOTAL CAUSADO :</span></td>
         <td><table width="125" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td width="123" align="right" class="Estilo5"><? echo $total; ?></td>
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