<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA BIENES NACIONALES (Detalles Bienes Muebles)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="1620" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
       <?php
if (!$_GET){$criterio='';$referencia_dep=''; } else{$criterio=$_GET["criterio"];$referencia_dep=substr($criterio,0,8);}
$sql="SELECT * FROM DET_DEPRECIACION_INM where referencia_dep='$referencia_dep' order by referencia_dep"; $res=pg_query($sql);
?>
       <table width="1600"  border="1" cellspacing='0' cellpadding='0' align="left" id="codigos">
         <tr height="20" class="Estilo5">
           <td width="150"  align="left" bgcolor="#99CCFF"><strong>Codigo Bien</strong></td>
           <td width="500" align="center" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="80"  align="left" bgcolor="#99CCFF"><strong>Valor Residual</strong></td>
           <td width="70" align="center" bgcolor="#99CCFF"><strong>Vida Util</strong></td>
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Monto Depreciado</strong></td>
           <td width="150"  align="left" bgcolor="#99CCFF"><strong>Codigo Contable</strong></td>
           <td width="150" align="left" bgcolor="#99CCFF" ><strong>Codigo Depreciacion</strong></td>
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Depreciado</strong></td>
           <td width="200"  align="left" bgcolor="#99CCFF"><strong>Codigo Presupuestario</strong></td>
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Monto</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto_dep"]; $monto=formato_monto($monto);$total=$total+$registro["monto_dep"];  $saldo_dep=$registro["saldo_dep"]; $saldo_dep=formato_monto($saldo_dep);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:enviar('<? echo $codigo_mov; ?>','<? echo $registro["cod_bien_inm"]; ?>');">
           <td width="150" align="left"><? echo $registro["cod_bien_inm"]; ?></td>
           <td width="500" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="80" align="left"><? echo $registro["valor_residual"]; ?></td>
           <td width="70" align="left"><? echo $registro["vida_util"]; ?></td>
           <td width="100" align="left"><? echo $registro["monto_depreciado"]; ?></td>
           <td width="150" align="left"><? echo $registro["cod_contablea"]; ?></td>
           <td width="150" align="left"><? echo $registro["cod_contabled"]; ?></td>
           <td width="100" align="right"><? echo $saldo_dep; ?></td>
           <td width="200" align="left"><? echo $registro["cod_presup_dep"]; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
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
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?
  pg_close();
?>
