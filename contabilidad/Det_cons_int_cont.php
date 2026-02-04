<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Detalles Interfaz Contables)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="904" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
       <?php
//<div id="Layer1" style="position:absolute; width:910px; height:500px; z-index:1; top: 10px; left: 5px;">

if (!$_GET){$criterio='';$referencia=''; $fecha=''; $tipo_comp='';}
 else{ $criterio=$_GET["criterio"];$fecha=substr($criterio,0,10);$referencia=''; $tipo_comp='';}
$sql="SELECT * FROM con012 where text(fecha_mov)='$fecha'  order by num_asiento,num_linea";
$res=pg_query($sql);
?>
       <table width="1000"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
		   <td width="50"  align="left" bgcolor="#99CCFF"><strong>Asiento</strong></td>
		   <td width="50"  align="left" bgcolor="#99CCFF"><strong>Linea</strong></td>
           <td width="80"  align="left" bgcolor="#99CCFF"><strong>Num.Cuenta</strong></td>
		   <td width="100"  align="left" bgcolor="#99CCFF"><strong>Cod.Cuenta</strong></td>
           <td width="220" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
		   <td width="150"  align="left" bgcolor="#99CCFF"><strong>Concepto</strong></td>
		   <td width="150"  align="left" bgcolor="#99CCFF"><strong>Des.Referencia</strong></td>
		   <td width="80" align="left" bgcolor="#99CCFF" ><strong>Ref.Doc.</strong></td>
           <td width="10" align="center" bgcolor="#99CCFF"><strong>D/C</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>           
         </tr>
         <?php  $t_debe=0; $t_haber=0;  $tc_debe=0; $tc_haber=0; 
while($registro=pg_fetch_array($res))
{ $monto_asiento=$registro["monto_mov"]; $monto_asiento=formato_monto($monto_asiento); $num_asiento=$registro["num_asiento"]; 
if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_mov"]; if(substr($num_asiento,0,3)=='400'){$tc_debe=$tc_debe+$registro["monto_mov"];} } 
else{$t_haber=$t_haber+$registro["monto_mov"]; if(substr($num_asiento,0,3)=='400'){$tc_haber=$tc_haber+$registro["monto_mov"];}}
$balance=$t_debe-$t_haber; $des_concepto=$registro["clave_con"]; 
if($des_concepto=="48"){$des_concepto="48 CARG.FACT.ABNADA";}
if($des_concepto=="35"){$des_concepto="35 COBRADO";}
if($des_concepto=="15"){$des_concepto="15 COBRADO";} 
if($des_concepto=="37"){$des_concepto="37 DEVOLUCION";}  
if($des_concepto=="41"){$des_concepto="41 TRASPASO";}
if($des_concepto=="59"){$des_concepto="59 INGRESADO BANCOS";} 
if($des_concepto=="65"){$des_concepto="65 REMESA DE CHEQUES";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF' "o"];" >
           <td width="50" align="left"><?php  echo $registro["num_asiento"]; ?></td>
		   <td width="50" align="left"><?php  echo $registro["num_linea"]; ?></td>
		   <td width="80" align="left"><?php  echo $registro["num_cuenta"]; ?></td>
		   <td width="100" align="left"><?php  echo $registro["cod_cuenta"]; ?></td>
           <td width="220" align="left"><?php  echo $registro["campo_str1"]; ?></td>		   
           <td width="150" align="left"><?php  echo $des_concepto; ?></td>
		   <td width="150" align="left"><?php  echo $registro["des_referencia"]; ?></td>
		   <td width="10" align="center"><?php  echo $registro["referencia_doc"]; ?></td>
           <td width="10" align="center"><?php  echo $registro["debito_credito"]; ?></td>
           <td width="100" align="right"><?php  echo $monto_asiento; ?></td>
         </tr>
         <?php } $t_debe=formato_monto($t_debe); $t_haber=formato_monto($t_haber); $tc_debe=formato_monto($tc_debe); $tc_haber=formato_monto($tc_haber);
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
               <td align="right" class="Estilo5"><?php  echo $t_debe; ?></td>
             </tr>
         </table></td>
         <td width="104"><span class="Estilo5">TOTAL HABER :</span></td>
         <td width="151"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><?php  echo $t_haber; ?></td>
             </tr>
         </table></td>
         <td width="84">&nbsp;</td>
         <td width="178">&nbsp;</td>
       </tr>
     </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="794" border="0">
       <tr>
         <td width="160" align="center"><span class="Estilo5">TOTAL DEBE COBRANZA:</span></td>
         <td width="150"><table width="150" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><?php  echo $tc_debe; ?></td>
             </tr>
         </table></td>
         <td width="170" align="center"><span class="Estilo5">TOTAL HABER COBRANZA:</span></td>
         <td width="150"><table width="150" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><?php  echo $tc_haber; ?></td>
             </tr>
         </table></td>
         <td width="160" align="center"><span class="Estilo5"></span></td>
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