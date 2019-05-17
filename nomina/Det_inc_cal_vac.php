<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];} 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Calculo de Nomina)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="1045" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
 $cant_trab=0;  $t_asina=0;  $t_deducc=0;
$sql="Select * from NOM076 where (codigo_mov='$codigo_mov') order by cod_concepto,fecha_hasta"; $res=pg_query($sql); //echo $sql;
?>
       <table width="1030"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Fecha</strong></td>          
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>Conc.</strong></td>
           <td width="350" align="center" bgcolor="#99CCFF" ><strong>Denominaci&oacute;n del Concepto</strong></td>
		   <td width="40" align="center" bgcolor="#99CCFF" ><strong>A/D</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF" ><strong>Total</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Cantidad</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>Oculto</strong></td>
		   <td width="50" align="center" bgcolor="#99CCFF" ><strong>Afecta</strong></td>
		   <td width="200" align="center" bgcolor="#99CCFF" ><strong>Cod.Presupuestario</strong></td>
       </tr>
<?$total=0; while($registro=pg_fetch_array($res)) { $cantidad=$registro["cantidad"]; $monto=$registro["valor"]; $cantidad=formato_monto($cantidad); $monto=formato_monto($monto);  
   if($registro["oculto"]=="NO"){ if($registro["asig_ded_apo"]=="A"){$t_asina=$t_asina+$registro["valor"];} if($registro["asig_ded_apo"]=="D"){$t_deducc=$t_deducc+$registro["valor"];} }
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];"  >
           <td width="100" align="left"><? echo formato_ddmmaaaa($registro["fecha_hasta"]); ?></td>           
           <td width="50" align="left"><? echo $registro["cod_concepto"]; ?></td>
           <td width="350" align="left"><? echo $registro["denominacion"]; ?></td>
		   <td width="40" align="center"><? echo $registro["asig_ded_apo"]; ?></td>
           <td width="120" align="right"><? echo $monto; ?></td>
           <td width="100" align="right"><? echo $cantidad; ?></td>
           <td width="50" align="center"><? echo $registro["oculto"]; ?></td>
		   <td width="50" align="center"><? echo $registro["afecta_presup"]; ?></td>
		   <td width="200" align="center"><? echo $registro["cod_presup"]; ?></td>
          </tr>
         <?} $neto=$t_asina-$t_deducc; $neto=formato_monto($neto); $t_asina=formato_monto($t_asina); $t_deducc=formato_monto($t_deducc); ?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td>  </tr>
   <tr>
     <td><table width="902" border="0">
       <tr>                
         <td width="86"><span class="Estilo5">ASIGNACION :</span></td>
         <td width="155"><table width="130" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $t_asina; ?></td></tr></table></td>
         <td width="86"><span class="Estilo5">DEDUCCION :</span></td>
         <td width="155"><table width="130" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $t_deducc; ?></td> </tr> </table></td>
         <td width="62" align="center"><span class="Estilo5">NETO :</span></td>
         <td width="141"><table width="130" border="1" cellspacing="0" cellpadding="0">
            <tr> <td align="right" class="Estilo5"><? echo $neto; ?></td></tr></table></td>		 
		 <td width="183"></td> 
       </tr>
     </table></td>
   </tr>

 </table>
</body>
</html>
<?   pg_close(); ?>