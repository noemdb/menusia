<?php include ("../class/conect.php");  include ("../class/funciones.php"); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Detalles Planillas de Retencion)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="1045" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1045">
       <?php
if (!$_GET){$criterio='';$nro_planilla='';$tipo_planilla='';$tipo_mov='';  $cod_banco=''; $referencia=''; }
 else{$criterio=$_GET["criterio"];$nro_planilla=substr($criterio,2,8);  $tipo_planilla=substr($criterio,0,2);
    $tipo_mov=substr($criterio,10,3);  $cod_banco=substr($criterio,13,4); $referencia=substr($criterio,17,8);
} $tasa_ret=0; $orden="";
$sql="select * from planillas_ret where tipo_planilla='$tipo_planilla' and nro_planilla='$nro_planilla'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res)){  
  $orden=$registro["nro_orden"];  $tipo_ret=$registro["tipo_retencion"];  $tasa_ret=$registro["tasa"];  $sustraendo=$registro["sustraendo"];
} 
$criterio=" nro_orden='$orden' and status_2='N' ";
if($tipo_mov=='O/P'){ if($tipo_planilla=="01"){$criterio=" nro_orden='$orden'";}else{ $criterio=" nro_orden='$orden' and status_2='N'";}  }
if(($tipo_mov=='000')and($cod_banco=='0000')and($referencia=='00000000')){ $temp_plan="P".substr($nro_planilla,1,7);
$criterio=" nro_orden='$temp_plan' and campo_str2='$tipo_planilla' "; }
$sql="SELECT * FROM PAG016  where ".$criterio." order by nro_factura"; $res=pg_query($sql);
?>
       <table width="1040"  border="1" cellspacing='0' cellpadding='0' align="left" id="comp_iva">
         <tr height="20" class="Estilo5">
           <td width="150"  align="left" bgcolor="#99CCFF"><strong>Nro. Factura</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
           <td width="170" align="left" bgcolor="#99CCFF"><strong>Nro. Control</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF"><strong>Monto sin IVA</strong></td>
           <td width="60" align="right" bgcolor="#99CCFF"><strong>Tasa IVA</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF"><strong>Monto Objeto</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF"><strong>Monto con IVA</strong></td>
		   <td width="100" align="right" bgcolor="#99CCFF"><strong>Objeto Retencion</strong></td>
           <td width="50" align="right" bgcolor="#99CCFF"><strong>% Retenc.</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF"><strong>Retenido</strong></td>
         </tr>
         <?php  $total=0; $subtotal=0; $total_ret=0;
while($registro=pg_fetch_array($res))
{  $sfecha=$registro["fecha_factura"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
$monto=$registro["monto_factura"]; $total=$total+$monto; $monto=formato_monto($monto);
$montos=$registro["monto_sin_iva"]; $subtotal=$subtotal+$montos; $montos=formato_monto($montos);
$tasa=$registro["tasa_iva1"]; $montoo=$registro["monto_iva1_so"]; $tasa=formato_monto($tasa);  $montoo=formato_monto($montoo);
$montoor=$registro["monto_iva4_so"]; $montor=($montoor*$tasa_ret)/100; 
if(($tipo_mov=='000')and($cod_banco=='0000')and($referencia=='00000000')){ $montor=$registro["monto_iva3"]; $tasa_ret=$registro["tasa_iva3"];}   
 $total_ret=$montor+$total_ret; 
$monto_r=formato_monto($montor); $montoor=formato_monto($montoor);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="150" align="left"><?php  echo $registro["nro_factura"]; ?></td>
           <td width="80" align="left"><?php  echo $fecha; ?></td>
           <td width="170" align="left"><?php  echo $registro["nro_con_factura"]; ?></td>
           <td width="100" align="right"><?php  echo $montos; ?></td>
           <td width="60" align="right"><?php  echo $tasa; ?></td>
           <td width="100" align="right"><?php  echo $montoo; ?></td>
           <td width="100" align="right"><?php  echo $monto; ?></td>
		   <td width="100" align="right"><?php  echo $montoor; ?></td>
           <td width="50" align="right"><?php  echo $tasa_ret; ?></td>
           <td width="100" align="right"><?php  echo $monto_r; ?></td>
         </tr>
         <?php }
 $tiva=$total-$subtotal; $total=formato_monto($total); $subtotal=formato_monto($subtotal); $tiva=formato_monto($tiva);  $total_ret=formato_monto($total_ret);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="842" border="0">
       <tr>
         <td width="133">&nbsp;</td>
         <td width="400">&nbsp;</td>
         <td width="120"><span class="Estilo5">TOTAL RETENCION :</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td align="right" class="Estilo5"><?php  echo $total_ret; ?></td>
           </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?php  pg_close($conn); ?>