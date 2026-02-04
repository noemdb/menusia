<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Detalles Movimientos Libros)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="840" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
       <?php $total=0;
if (!$_GET){$codigo_mov='';} else{ $codigo_mov=$_GET["codigo_mov"];}
$sql="SELECT * FROM ban034 where codigo_mov='$codigo_mov' order by referenciaa,cod_banco,referencia";$res=pg_query($sql);
?>
       <table width="840"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="50"  align="left" bgcolor="#99CCFF"><strong>Aisento</strong></td>
           <td width="50" align="left" bgcolor="#99CCFF"><strong>Cod.banco</strong></td>
		   <td width="80" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
           <td width="40" align="center" bgcolor="#99CCFF"><strong>Tipo M.</strong></td>
           <td width="80" align="right" bgcolor="#99CCFF" ><strong>Monto</strong></td>
           <td width="440" align="left" bgcolor="#99CCFF"><strong>Descripcion </strong></td>
         </tr>
         <?php  
while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_mov_libro"]; $total=$total+$monto_asiento; $monto_asiento=formato_monto($monto_asiento);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="50" align="left"><?php  echo $registro["referenciaa"]; ?></td>
           <td width="50" align="left"><?php  echo $registro["cod_banco"]; ?></td>
		   <td width="80" align="left"><?php  echo $registro["referencia"]; ?></td>           
           <td width="40" align="center"><?php  echo $registro["tipo_mov_libro"]; ?></td>
           <td width="80" align="right"><?php  echo $monto_asiento; ?></td>
           <td width="440" align="left"><?php  echo $registro["descrip_mov_libro"]; ?></td>
         </tr>
         <?php } $total=formato_monto($total); 
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="794" border="0">
       <tr>
         <td width="142"><span class="Estilo5">TOTAL MOVIMIENTOS :</span></td>
         <td width="163"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><?php  echo $total; ?></td>
             </tr>
         </table></td>
         <td width="50">&nbsp;</td>
         <td width="151">&nbsp;</td>
         <td width="84">&nbsp;</td>
         <td width="178">&nbsp;</td>
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