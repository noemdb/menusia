<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Detalles Codigos Cheques permanente)</title>

<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>

<body>
<table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
       <?php
$sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup";$res=pg_query($sql);
?>
 <table width="1510" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1500">
       <table width="1500"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="190"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Causado </strong></td>
		   <td width="110" align="right" bgcolor="#99CCFF" ><strong>Pagado </strong></td>
		   <td width="110" align="right" bgcolor="#99CCFF" ><strong>Abono </strong></td>
		   <td width="500" align="center" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
		   <td width="100" align="left" bgcolor="#99CCFF" ><strong>Referencia Comp</strong></td>
		   <td width="60" align="left" bgcolor="#99CCFF" ><strong>Tipo Comp</strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Tipo Imputacion</strong></td>           
           <td width="110" align="left" bgcolor="#99CCFF" ><strong>Ref. Credito </strong></td>
         </tr>
         <?php  $total=0;
while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto"]); $monto_presup=formato_monto($registro["monto_presup"]);
  $monto_credito=formato_monto($registro["monto_credito"]);   $amort_anticipo=formato_monto($registro["amort_anticipo"]); 
  $total=$total+$registro["monto"];  $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"];
  $tipo_imput_presu=$registro["tipo_imput_presu"];  $ref_imput_presu=$registro["ref_imput_presu"];
  if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<?php  echo $codigo_mov; ?>','<?php  echo $registro["cod_presup"]; ?>','<?php  echo $registro["fuente_financ"]; ?>','<?php  echo $registro["ref_imput_presu"]; ?>','<?php  echo $registro["referencia_comp"]; ?>','<?php  echo $registro["tipo_compromiso"]; ?>');">
           <td width="190" align="left"><?php  echo $registro["cod_presup"]; ?></td>
           <td width="40" align="left"><?php  echo $registro["fuente_financ"]; ?></td>
		   <td width="110" align="right"><?php  echo $monto_presup; ?></td>
		   <td width="110" align="right"><?php  echo $amort_anticipo; ?></td>
		   <td width="110" align="right"><?php  echo $monto; ?></td>		   
           <td width="500" align="left"><?php  echo $registro["denominacion"]; ?></td>
           <td width="100" align="left"><?php  echo $registro["referencia_comp"]; ?></td>
           <td width="60" align="left"><?php  echo $registro["tipo_compromiso"]; ?></td>
           <td width="120" align="left"><?php  echo $tipo_imput_presu; ?></td>
           <td width="110" align="left"><?php  echo $ref_imput_presu; ?></td>
         </tr>
         <?php } $total=formato_monto($total);?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="830" border="0">
       <tr>
         <td width="530">&nbsp;</td>
         <td width="150" align="center"><span class="Estilo5">TOTAL ABONO :</span></td>
         <td><table width="125" border="1" cellspacing="0" cellpadding="0">
           <tr><td width="123" align="right" class="Estilo5"><?php  echo $total; ?></td></tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?php  pg_close($conn); ?>