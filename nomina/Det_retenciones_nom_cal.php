<?include ("../class/conect.php");  include ("../class/funciones.php");$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Detalles del C&oacute;digo Presupuestarios)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="1005" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1148">
<?php if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$sql="SELECT * FROM COD_RET where codigo_mov='$codigo_mov' order by tipo_retencion,cod_presup_ret"; $res=pg_query($sql);
?>
       <table width="1005"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="50" align="center" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="300" align="center" bgcolor="#99CCFF"><strong>Descripci&oacute;n Retenci&oacute;n</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
           <td width="200" align="center" bgcolor="#99CCFF" ><strong>C&oacute;d. Presupuestario</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>Fuente</strong></td>
           <td width="140" align="center" bgcolor="#99CCFF" ><strong>C&eacute;dula/Rif</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Ref.Comp</strong></td>
           <td width="50" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)){ $monto=$registro["monto_retencion"]; $monto=formato_monto($monto);$total=$total+$registro["monto_retencion"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="50" align="left"><? echo $registro["tipo_retencion"]; ?></td>
           <td width="300" align="left"><? echo $registro["descripcion_ret"]; ?></td>
           <td width="120" align="right"><? echo $monto; ?></td>
           <td width="200" align="center"><? echo $registro["cod_presup_ret"]; ?></td>
           <td width="50" align="center"><? echo $registro["fuente_fin_ret"]; ?></td>
           <td width="140" align="center"><? echo $registro["ced_rif_r"]; ?></td>
           <td width="80" align="center"><? echo $registro["ref_comp_ret"]; ?></td>
           <td width="50" align="center"><? echo $registro["tipo_comp_ret"]; ?></td>
          </tr>
         <?}
 $total=formato_monto($total);
?>
</table></td>
   </tr>
   <tr> <td>&nbsp;</td></tr>
   <tr>
     <td><table width="840" border="0">
       <tr>
         <td width="400">&nbsp;</td>
         <td width="200"><span class="Estilo5">TOTAL RETENCIONES:</span></td>
         <td width="240"><table width="150" border="1" cellspacing="0" cellpadding="0">
         <tr><td align="right" class="Estilo5"><? echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<? pg_close();  ?>