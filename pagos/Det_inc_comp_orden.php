<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];} $cod_contable="";$monto_am_ant=0;$amort_ant="NO";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sSQL="Select * from PAG036 WHERE codigo_mov='$codigo_mov'";$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);if ($filas>0) { $registro=pg_fetch_array($resultado); $cod_contable=$registro["cod_contable_o"];$monto_am_ant=$registro["monto_am_ant"];}
if ($monto_am_ant==0) {$amort_ant="NO";} else {$amort_ant="SI";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Detalles Comprobante de la Orden)</title>
<LINK href="../class/sia.css" type="text/css"  rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llama_Cargar_Codigos(mcodigo_mov){var murl;
  murl="Gen_Comp_Orden.php?codigo_mov="+mcodigo_mov;   document.location=murl; }
</script>
</head>
<body>
  <table width="888" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td  width="262" align="center"><input name="btGenComp" type="button" id="btGenComp" value="Generar Comprobante" title="Generar Comprobante" onclick="javascript:LlamarURL('Gen_Comp_Orden.php?codigo_mov=<?echo $codigo_mov?>')"></td>
     <td  width="156" align="center"><input name="btAmortAnt" type="button" id="btAmortAnt" value="Amortiza Anticipo" title="Registra Amortizacion de Anticipo" onclick="javascript:LlamarURL('Inc_amort_ant.php?codigo_mov=<?echo $codigo_mov?>')"></td>
     <td  width="75" align="left"><input type="text" name="txtamort_ant" size="2" value="<?echo $amort_ant?>" readonly ></td>
     <td  width="139" align="center"><span class="Estilo5">CUENTA POR PAGAR  :</span></td>
     <td  width="256" align="left"><span class="Estilo5"><input name="txtcod_contable" type="text" id="txtcod_contable" size="25" maxlength="30" value="<?echo $cod_contable?>" readonly></span></td>
   </tr>
   <tr>
     <td colspan="3" align="center">&nbsp;</td>
     <td align="center">&nbsp;</td>
     <td align="left">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="5">
<?php
if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$sql="SELECT * FROM CUENTAS_CON008  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
?>
       <table width="800"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Cuenta</strong></td>
           <td width="500" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="10" align="center" bgcolor="#99CCFF"><strong>D/C</strong></td>
           <td width="80" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
         </tr>
         <? $t_debe=0; $t_haber=0;
while($registro=pg_fetch_array($res))
{ $monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);
if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}
$balance=$t_debe-$t_haber;
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="100" align="left"><? echo $registro["cod_cuenta"]; ?></td>
           <td width="500" align="left"><? echo $registro["nombre_cuenta"]; ?></td>
           <td width="10" align="center"><? echo $registro["debito_credito"]; ?></td>
           <td width="80" align="right"><? echo $monto_asiento; ?></td>
         </tr>
         <?}
 $t_debe=formato_monto($t_debe);
 $t_haber=formato_monto($t_haber);
?>
       </table></td>
   </tr>
   <tr>
     <td colspan="5">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="5"><table width="794" border="0">
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