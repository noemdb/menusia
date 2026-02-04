<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Detalles retenciones de la Orden)</title>
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
if (!$_GET){$criterio='';$nro_orden='';} else{$criterio=$_GET["clave"];$nro_orden=substr($criterio,0,8);
}
$sql="SELECT * FROM ret_orden_ant where aux_orden='$nro_orden' order by aux_orden,tipo_retencion,tipo_caus_ret,ref_comp_ret,tipo_comp_ret,cod_presup_ret,fuente_fin_ret";
$res=pg_query($sql);
?>
       <table width="800"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_orden">
         <tr height="20" class="Estilo5">
           <td width="70" align="left" bgcolor="#99CCFF"><strong>Orden</strong></td>
           <td width="30" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
           <td width="50" align="right" bgcolor="#99CCFF" ><strong>Tasa </strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>M. Objeto </strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Retencion </strong></td>
         </tr>
         <?php  $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto_retencion"]; $monto=formato_monto($monto);$total=$total+$registro["monto_retencion"];
$codigo=$registro["tipo_comp_ret"]." ".$registro["ref_comp_ret"]." ".$registro["fuente_fin_ret"]." ".$registro["cod_presup_ret"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="70" align="left"><?php  echo $registro["aux_orden"]; ?></td>
           <td width="30" align="left"><?php  echo $registro["tipo_retencion"]; ?></td>
           <td width="300" align="left"><?php  echo $registro["descripcion_ret"]; ?></td>
           <td width="50" align="right"><?php  echo $registro["tasa_retencion"]; ?></td>
           <td width="100" align="right"><?php  echo $registro["monto_objeto_ret"]; ?></td>
           <td width="100" align="right"><?php  echo $monto; ?></td>
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