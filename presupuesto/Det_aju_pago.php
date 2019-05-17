<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Detalles Ajustes del Pago)</title>
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
</head>
<body>
 <table width="575" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
if (!$_GET){$criterio='';$referencia_comp='';$tipo_compromiso='';$tipo_causado=''; $referencia_caus=''; $tipo_pago='';  $referencia_pago='';}
 else{$criterio=$_GET["criterio"];$tipo_pago=substr($criterio,0,4); $referencia_pago=substr($criterio,4,8); $referencia_caus=substr($criterio,16,8);  $tipo_causado=substr($criterio,12,4); $referencia_comp=substr($criterio,28,8); $tipo_compromiso=substr($criterio,24,4);
}
$sql="SELECT pre031.referencia_ajuste,pre031.tipo_ajuste,pre031.cod_presup,pre031.fuente_financ,pre031.monto,pre011.fecha_ajuste FROM PRE031,PRE011,PRE005 where pre031.referencia_ajuste=pre011.referencia_ajuste and pre031.tipo_ajuste=pre011.tipo_ajuste and pre011.tipo_ajuste=pre005.tipo_ajuste and pre031.referencia_pago=pre011.referencia_pago and pre031.tipo_pago=pre011.tipo_pago and pre031.referencia_comp=pre011.referencia_comp and pre031.tipo_compromiso=pre011.tipo_compromiso and pre031.referencia_caus=pre011.referencia_caus and pre031.tipo_causado=pre011.tipo_causado and pre031.tipo_pago='$tipo_pago' and pre031.referencia_pago='$referencia_pago' and pre031.tipo_causado='$tipo_causado' and pre031.referencia_caus='$referencia_caus' and  pre031.referencia_comp='$referencia_comp' and pre031.tipo_compromiso='$tipo_compromiso' Order By PRE011.fecha_ajuste,PRE031.tipo_ajuste,PRE031.referencia_ajuste,PRE031.cod_presup";
$res=pg_query($sql);
?>
       <table width="548"  border="1" cellspacing='0' cellpadding='0' align="left" id="caus_comp">
         <tr height="20" class="Estilo5">
           <td width="110"  align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
                   <td width="90"  align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
                   <td width="190"  align="left" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
         </tr>
         <? $total=0;$totaln=0;$totala=0;
while($registro=pg_fetch_array($res))
{ $monto=formato_monto($registro["monto"]);
  $total=$total+$registro["monto"];
  $fecha=$registro["fecha_ajuste"];
  if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="120" align="left"><? echo $registro["referencia_ajuste"].' '.$registro["tipo_ajuste"]; ?></td>
                   <td width="100" align="left"><? echo $fecha; ?></td>
                   <td width="190" align="left"><? echo $registro["cod_presup"]; ?></td>
           <td width="40" align="left"><? echo $registro["fuente_financ"]; ?></td>
           <td width="110" align="right"><? echo $monto; ?></td>
         </tr>
         <?}
 $total=formato_monto($total);
 $totala=formato_monto($totala);
 $totaln=formato_monto($totaln);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="548" border="0">
       <tr>
         <td width="306">&nbsp;</td>
         <td width="110" align="center"><span class="Estilo5">TOTALES :</span></td>
         <td width="125"><table width="125" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td width="123" align="right" class="Estilo5"><? echo $total; ?></td>
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
<?  pg_close(); ?>