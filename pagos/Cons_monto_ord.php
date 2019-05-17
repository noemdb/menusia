<?include ("../class/conect.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Montos de la Orden)</title>
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
</head>
<body>
   
<?php
if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$total_causado=0; $total_retencion=0; $total_ajuste=0; $total_pasivos=0; $monto_am_ant=0;  $total_neto = 0;
$sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup";$res=pg_query($sql);while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto"]); $total_causado=$total_causado+$registro["monto"]; }
$sSQL="Select * from PAG036 WHERE codigo_mov='$codigo_mov'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);if ($filas>=0){$registro=pg_fetch_array($resultado);  $pasivo_comp=$registro["pasivo_comp"]; $monto_am_ant=$registro["monto_am_ant"];  $cod_cont_ant=$registro["campo_str1"]; }
$sql="SELECT * FROM COD_RET where codigo_mov='$codigo_mov' order by tipo_retencion";$res=pg_query($sql);while($registro=pg_fetch_array($res)){ $total_retencion=$total_retencion+$registro["monto_retencion"]; }
$sql="SELECT * FROM cod_pasivo  where codigo_mov='$codigo_mov' order by cod_cuenta";$res=pg_query($sql);while($registro=pg_fetch_array($res)){ $total_pasivos=$total_pasivos+$registro["monto_pasivo"]; }
$total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant;
if($total_pasivos>0) {$total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant + $total_pasivos;}  
$total_causado=formato_monto($total_causado);$total_retencion=formato_monto($total_retencion);
$total_ajuste=formato_monto($total_ajuste); $total_pasivos=formato_monto($total_pasivos);
$monto_am_ant=formato_monto($monto_am_ant);$total_neto=formato_monto($total_neto);
?>
<table width="640" align="center">
	<tr>
	  <td><table width="640" border="0"> 
      <tr>
		<td width="100"> <span class="Estilo5">TOTAL CAUSADO : </span> </td>
		<td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total_causado; ?></td> </tr>
         </table></td>
		<td width="130" align="right"> <span class="Estilo5">AMORT. ANTICIPO : </span> </td>
		<td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $monto_am_ant; ?></td> </tr>
         </table></td>
                 
       </tr>
	   </table></td>
    </tr>
    <tr>
	  <td><table width="640" border="0"> 
      <tr>
		<td width="100"> <span class="Estilo5">RETENCIONES : </span> </td>
		<td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total_retencion; ?></td> </tr>
         </table></td>
		<td width="130" align="right"> <span class="Estilo5">AJUSTE : </span> </td>
		<td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total_ajuste; ?></td> </tr>
         </table></td>
       </tr>
	   </table></td>
    </tr>
    <tr>
	  <td><table width="640" border="0"> 
      <tr>
	    <td width="100"> <span class="Estilo5">TOTAL PASIVO : </span> </td>
		<td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total_pasivos; ?></td> </tr>
         </table></td>
		<td width="130" align="right"> <span class="Estilo5"><strong>NETO</strong> : </span> </td>
		<td width="155"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total_neto; ?></td> </tr>
         </table></td>
      </tr>
	 </table></td>
    </tr>  
	<tr>
     <td>&nbsp;</td>
   </tr>
	<tr>
     <td width="600" align="center"><input name="btcerrar" type="button" id="btcerrar" value="Cerra Ventana" onclick="javascrip:cerrar_ventana();"></td>
   </tr>
</table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close(); ?>