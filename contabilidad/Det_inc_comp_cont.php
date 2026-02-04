<?php include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';} else{ $codigo_mov=$_GET["codigo_mov"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Detalles Cuentas del Comprobante)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="904" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php 

$sql="SELECT * FROM cuentas_CON016 where codigo_mov='$codigo_mov' order by nro_comprobante,referencia,debito_credito desc,cod_cuenta";$res=pg_query($sql);
?>
       <table width="900"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="50"  align="left" bgcolor="#99CCFF"><strong>Asiento</strong></td>
		   <td width="50"  align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
		   <td width="80"  align="left" bgcolor="#99CCFF"><strong>Cuenta</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
		   <td width="40" align="center" bgcolor="#99CCFF"><strong>Tipo M.</strong></td>
           <td width="20" align="center" bgcolor="#99CCFF"><strong>D/C</strong></td>
           <td width="80" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
           <td width="360" align="left" bgcolor="#99CCFF"><strong>Descripcion Asiento</strong></td>
         </tr>
         <?php  $t_debe=0; $t_haber=0;
while($registro=pg_fetch_array($res))
{ $monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);
if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}
$balance=$t_debe-$t_haber;
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="50" align="left"><?php  echo $registro["nro_comprobante"]; ?></td>
           <td width="50" align="left"><?php  echo $registro["referencia"]; ?></td>
           <td width="80" align="left"><?php  echo $registro["cod_cuenta"]; ?></td>
           <td width="200" align="left"><?php  echo $registro["nombre_cuenta"]; ?></td>
		   <td width="40" align="center"><?php  echo $registro["tipo_asiento"]; ?></td>
           <td width="20" align="center"><?php  echo $registro["debito_credito"]; ?></td>
           <td width="80" align="right"><?php  echo $monto_asiento; ?></td>
           <td width="360" align="left"><?php  echo substr($registro["descripcion_a"],0,100); ?></td>
         </tr>
         <?php } $balance=$t_debe-$t_haber; $balance=abs($balance);
		 $balance=formato_monto($balance);$t_debe=formato_monto($t_debe);  $t_haber=formato_monto($t_haber);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="794" border="0">
       <tr>
         <td width="100" align="center"><span class="Estilo5">TOTAL DEBE :</span></td>
         <td width="150"><table width="150" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><?php  echo $t_debe; ?></td>
             </tr>
         </table></td>
         <td width="110" align="center"><span class="Estilo5">TOTAL HABER :</span></td>
         <td width="150"><table width="150" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><?php  echo $t_haber; ?></td>
             </tr>
         </table></td>
         <td width="110" align="center"><span class="Estilo5">BALANCE :</span></td>
         <td width="170"><table width="150" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><?php  echo $balance; ?></td>
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