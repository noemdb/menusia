<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Detalles Cuentas del Comprobante)</title>
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
</head>
<body>
 <table width="904" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
       <?php
if (!$_GET){ $criterio='';  $referencia='';  $fecha='';  $tipo_comp='';} else{$criterio=$_GET["criterio"];  $fecha=substr($criterio,0,10);  $referencia=substr($criterio,10,8); $tipo_comp=substr($criterio,18,5);}
$sql="SELECT * FROM cuentas_orden_ant where text(fecha)='$fecha' and referencia='$referencia'  order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
//echo $sql;
?>
       <table width="900"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="50"  align="left" bgcolor="#99CCFF"><strong>Cuenta</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="10" align="center" bgcolor="#99CCFF"><strong>D/C</strong></td>
           <td width="80" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
           <td width="500" align="left" bgcolor="#99CCFF"><strong>Descripcion Asiento</strong></td>
         </tr>
         <? $t_debe=0; $t_haber=0;
while($registro=pg_fetch_array($res))
{ $monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);
if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}
$balance=$t_debe-$t_haber;
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="80" align="left"><? echo $registro["cod_cuenta"]; ?></td>
           <td width="230" align="left"><? echo $registro["nombre_cuenta"]; ?></td>
           <td width="10" align="center"><? echo $registro["debito_credito"]; ?></td>
           <td width="80" align="right"><? echo $monto_asiento; ?></td>
           <td width="500" align="left"><? echo substr($registro["descripcion_a"],0,100); ?></td>
         </tr>
         <?} $t_debe=formato_monto($t_debe);  $t_haber=formato_monto($t_haber);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="794" border="0">
       <tr>
         <td width="88"><span class="Estilo5">TOTAL DEBE :</span></td>
         <td width="163"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><? echo $t_debe; ?></td>
             </tr>
         </table></td>
         <td width="104"><span class="Estilo5">TOTAL HABER :</span></td>
         <td width="151"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><? echo $t_haber; ?></td>
             </tr>
         </table></td>
         <td width="84">&nbsp;</td>
         <td width="178">&nbsp;</td>
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