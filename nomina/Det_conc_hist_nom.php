<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Calculo de Nomina)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(tipo_nomina,cod_concepto,cod_empleado,fecha_h,tp_calculo){var murl;
  if(cod_empleado==""){alert("Trabajador debe ser Seleccionado");}
  else{murl="Mod_conc_hist_nom.php?tipo_nomina="+tipo_nomina+"&cod_concepto="+cod_concepto+"&cod_empleado="+cod_empleado+"&fecha_h="+fecha_h+"&tp_calculo="+tp_calculo; document.location=murl;}
}
</script>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
if (!$_GET){$tipo_nomina='';}else{$tipo_nomina=$_GET["tipo_nomina"]; $cod_empleado=$_GET["cod_empleado"]; $fecha_nomina=$_GET["fecha_nomina"];}  
  $tp_calculo="N"; $cant_trab=0; $prev_cod=""; $t_asina=0;  $t_deducc=0; $fechab=formato_aaaammdd($fecha_nomina);
$sql="Select * from NOM019 where (tipo_nomina='$tipo_nomina') and (cod_empleado='$cod_empleado') and (fecha_p_hasta='$fechab') and (tp_calculo='$tp_calculo') ".$criterioc." order by tipo_nomina,cod_departam,cod_cargo,cod_empleado,cod_concepto,fecha_hasta"; $res=pg_query($sql);
//echo $sql;
?>
       <table width="1070"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Fecha</strong></td>
           <td width="40" align="center" bgcolor="#99CCFF" ><strong>Conc.</strong></td>
           <td width="250" align="center" bgcolor="#99CCFF" ><strong>Denominaci&oacute;n del Concepto</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF" ><strong>Total</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Cantidad</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>Oculto</strong></td>
       </tr>
<?$total=0; while($registro=pg_fetch_array($res)) { $cantidad=$registro["cantidad"]; $monto=$registro["monto"]; $cantidad=formato_monto($cantidad); $monto=formato_monto($monto); if($prev_cod<>$registro["cod_empleado"]){$prev_cod=$registro["cod_empleado"]; $cant_trab=$cant_trab+1;} if($registro["oculto"]=="NO"){$t_asina=$t_asina+$registro["monto_asignacion"];  $t_deducc=$t_deducc+$registro["monto_deduccion"];}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $registro["tipo_nomina"]; ?>','<? echo $registro["cod_concepto"]; ?>','<? echo $registro["cod_empleado"]; ?>','<? echo $registro["fecha_p_hasta"]; ?>','<? echo $registro["tp_calculo"]; ?>');" >
           <td width="100" align="left"><? echo formato_ddmmaaaa($registro["fecha_p_hasta"]); ?></td>
           <td width="40" align="left"><? echo $registro["cod_concepto"]; ?></td>
           <td width="250" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="120" align="right"><? echo $monto; ?></td>
           <td width="100" align="right"><? echo $cantidad; ?></td>
           <td width="50" align="center"><? echo $registro["oculto"]; ?></td>
          </tr>
         <?} $neto=$t_asina-$t_deducc; $neto=formato_monto($neto); $t_asina=formato_monto($t_asina); $t_deducc=formato_monto($t_deducc); ?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td>  </tr>
   <tr>
     <td><table width="902" border="0">
       <tr>
         <td width="102"><span class="Estilo5"></span></td>
         <td width="81" align="center"></td>
         <td width="86"><span class="Estilo5">TOTAL ASIGNACION :</span></td>
         <td width="155"><table width="130" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $t_asina; ?></td></tr>
         </table></td>
         <td width="86"><span class="Estilo5">TOTAL DEDUCCION :</span></td>
         <td width="155"><table width="130" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $t_deducc; ?></td> </tr>
         </table></td>
         <td width="62" align="center"><span class="Estilo5">NETO :</span></td>
         <td width="141"><table width="130" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $neto; ?></td></tr>
                 </table></td>
       </tr>
     </table></td>
   </tr>

 </table>
</body>
</html>
<?   pg_close(); ?>