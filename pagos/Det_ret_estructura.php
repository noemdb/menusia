<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Detalles Codigos de la Estructura)</title>
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
       <?php
if (!$_GET){$criterio='';$cod_estructura='';} else{$criterio=$_GET["criterio"];$cod_estructura=substr($criterio,0,8);}
$sql="SELECT * FROM RET_ESTRUCTURA  where cod_estructura='$cod_estructura' order by tipo_ret,tipo_comp_est,ref_comp_est,cod_presup_est,fuente_est,ref_imput_presu";
$res=pg_query($sql);
?>
       <table width="1440"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="50" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
           <td width="50" align="right" bgcolor="#99CCFF" ><strong>Tasa </strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>M. Objeto </strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Retencion </strong></td>
           <td width="300"  align="left" bgcolor="#99CCFF"><strong>Codigo presupuestario</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Ced/Rif</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>Concepto</strong></td>
         </tr>
         <?php  $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto_ret"]; $monto=formato_monto($monto);$total=$total+$registro["monto_ret"];
$concepto_ret=$registro["concepto_ret"]; $concepto_ret=substr($concepto_ret,0,150);
$codigo=$registro["ref_comp_est"]." ".$registro["cod_presup_est"]." ".$registro["fuente_est"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="50" align="left"><?php  echo $registro["tipo_ret"]; ?></td>
           <td width="300" align="left"><?php  echo $registro["descripcion_ret"]; ?></td>
           <td width="50" align="right"><?php  echo $registro["tasa"]; ?></td>
           <td width="100" align="right"><?php  echo $registro["monto_objeto"]; ?></td>
           <td width="100" align="right"><?php  echo $monto; ?></td>
           <td width="300" align="left"><?php  echo $codigo; ?></td>
           <td width="50" align="left"><?php  echo $registro["ced_rif_ret"]; ?></td>
           <td width="100" align="left"><?php  echo $concepto_ret; ?></td>
         </tr>
         <?php }
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="802" border="0">
       <tr>
         <td width="103">&nbsp;</td>
         <td width="378">&nbsp;</td>
         <td width="132"><span class="Estilo5">TOTAL RETENCIONES:</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td align="right" class="Estilo5"><?php  echo $total; ?></td>
           </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?php 
  pg_close($conn);
?>