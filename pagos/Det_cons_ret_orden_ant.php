<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Detalles retenciones de la Orden)</title>
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
if (!$_GET){$criterio='';$nro_orden='';} else{$criterio=$_GET["clave"];$nro_orden=substr($criterio,0,8);}
$sql="SELECT * FROM ret_orden_ant where nro_orden_ret='$nro_orden' order by aux_orden,tipo_retencion,tipo_caus_ret,ref_comp_ret,tipo_comp_ret,cod_presup_ret,fuente_fin_ret";$res=pg_query($sql);
?>
       <table width="2100"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_orden">
         <tr height="20" class="Estilo5">
           <td width="70" align="left" bgcolor="#99CCFF"><strong>Orden</strong></td>
           <td width="30" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
           <td width="50" align="right" bgcolor="#99CCFF" ><strong>Tasa </strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>M. Objeto </strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Retencion </strong></td>
           <td width="300"  align="left" bgcolor="#99CCFF"><strong>Codigo presupuestario</strong></td>
           <td width="400"  align="left" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="120"  align="left" bgcolor="#99CCFF"><strong>Codigo Cuenta</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Ced/Rif</strong></td>
           <td width="500" align="left" bgcolor="#99CCFF"><strong>Concepto</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto_retencion"]; $monto=formato_monto($monto);$total=$total+$registro["monto_retencion"];
$concepto_ret=$registro["des_orden_ret"]; $concepto_ret=substr($concepto_ret,0,140);$deno_ret=""; $deno_ret=substr($deno_ret,0,100);
$nom_cuenta=""; $nom_cuenta=substr($nom_cuenta,0,100);$nom_benef=""; $nom_benef=substr($nom_benef,0,100);
$codigo=$registro["tipo_comp_ret"]." ".$registro["ref_comp_ret"]." ".$registro["fuente_fin_ret"]." ".$registro["cod_presup_ret"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="70" align="left"><? echo $registro["aux_orden"]; ?></td>
           <td width="30" align="left"><? echo $registro["tipo_retencion"]; ?></td>
           <td width="300" align="left"><? echo $registro["descripcion_ret"]; ?></td>
           <td width="50" align="right"><? echo $registro["tasa_retencion"]; ?></td>
           <td width="100" align="right"><? echo $registro["monto_objeto_ret"]; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
           <td width="300" align="left"><? echo $codigo; ?></td>
           <td width="400" align="left"><? echo $deno_ret; ?></td>
           <td width="120" align="left"><? echo $registro["cod_contable_ret"]; ?></td>
           <td width="100" align="left"><? echo $registro["ced_rif_r"]; ?></td>
           <td width="500" align="left"><? echo $concepto_ret; ?></td>
         </tr>
         <?}
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td> </tr>
   <tr>
     <td><table width="802" border="0">
       <tr>
         <td width="103">&nbsp;</td>
         <td width="378">&nbsp;</td>
         <td width="132"><span class="Estilo5">TOTAL RETENCIONES:</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
           <tr> <td align="right" class="Estilo5"><? echo $total; ?></td></tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close();?>