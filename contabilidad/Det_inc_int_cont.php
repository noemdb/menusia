<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Detalles Interfaz Contables)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="904" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
       <?php
//<div id="Layer1" style="position:absolute; width:910px; height:500px; z-index:1; top: 10px; left: 5px;">

if (!$_GET){$codigo_mov='';} else{ $codigo_mov=$_GET["codigo_mov"];}
$sql="SELECT * FROM con014 where codigo_mov='$codigo_mov'  order by num_asiento,to_number(num_linea,'999999')"; $res=pg_query($sql);
?>
       <table width="1150"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
		   <td width="50"  align="left" bgcolor="#99CCFF"><strong>Asiento</strong></td>
		   <td width="30"  align="left" bgcolor="#99CCFF"><strong>Linea</strong></td>
           <td width="80"  align="left" bgcolor="#99CCFF"><strong>Num.Cuenta</strong></td>
		   <td width="120"  align="left" bgcolor="#99CCFF"><strong>Cod.Cuenta</strong></td>
           <td width="280" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
		   <td width="150"  align="left" bgcolor="#99CCFF"><strong>Concepto</strong></td>
		   <td width="200"  align="left" bgcolor="#99CCFF"><strong>Des.Referencia</strong></td>
		   <td width="80" align="left" bgcolor="#99CCFF" ><strong>Ref.Doc.</strong></td>
           <td width="10" align="center" bgcolor="#99CCFF"><strong>D/C</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>  
           <td width="40" align="right" bgcolor="#99CCFF" ><strong>Tipo M</strong></td> 		   
         </tr>
         <? $t_debe=0; $t_haber=0; $tc_debe=0; $tc_haber=0; 
while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_mov"]; $monto_asiento=formato_monto($monto_asiento); $num_asiento=$registro["num_asiento"]; 
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
           <td width="50" align="left"><? echo $registro["num_asiento"]; ?></td>
		   <td width="30" align="left"><? echo $registro["num_linea"]; ?></td>
		   <td width="80" align="left"><? echo $registro["num_cuenta"]; ?></td>
		   <td width="120" align="left"><? echo $registro["cod_cuenta"]; ?></td>
           <td width="280" align="left"><? echo $registro["campo_str1"]; ?></td>		   
           <td width="150" align="left"><? echo $des_concepto; ?></td>
		   <td width="200" align="left"><? echo $registro["des_referencia"]; ?></td>
		   <td width="80" align="center"><? echo $registro["referencia_r"]; ?></td>
           <td width="10" align="center"><? echo $registro["debito_credito"]; ?></td>
           <td width="100" align="right"><? echo $monto_asiento; ?></td>
		   <td width="40" align="center"><? echo $registro["tipo_doc"]; ?></td>
         </tr>
         <? } $balance=$t_debe-$t_haber; $balance=formato_monto($balance);
		      $t_debe=formato_monto($t_debe); $t_haber=formato_monto($t_haber); $tc_debe=formato_monto($tc_debe); $tc_haber=formato_monto($tc_haber);
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
               <td align="right" class="Estilo5"><? echo $t_debe; ?></td>
             </tr>
         </table></td>
         <td width="110" align="center"><span class="Estilo5">TOTAL HABER :</span></td>
         <td width="150"><table width="150" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><? echo $t_haber; ?></td>
             </tr>
         </table></td>
         <td width="110" align="center"><span class="Estilo5">BALANCE :</span></td>
         <td width="170"><table width="150" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><? echo $balance; ?></td>
             </tr>
		 </table></td>	 
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
               <td align="right" class="Estilo5"><? echo $tc_debe; ?></td>
             </tr>
         </table></td>
         <td width="170" align="center"><span class="Estilo5">TOTAL HABER COBRANZA:</span></td>
         <td width="150"><table width="150" border="1" cellspacing="0" cellpadding="0">
             <tr>
               <td align="right" class="Estilo5"><? echo $tc_haber; ?></td>
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
<?
  pg_close();
?>