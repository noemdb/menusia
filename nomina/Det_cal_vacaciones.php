<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Calculo de Nomina)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>

<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
if (!$_GET){$criterio='';}else{$criterio=$_GET["criterio"];}  $tipo_nomina=substr($criterio,0,2);  $tp_calculo=substr($criterio,2,1); $cant_trab=0; $prev_cod=""; $t_asina=0;  $t_deducc=0;
$sql="Select * from NOM017 where (tipo_nomina='$tipo_nomina') and (tp_calculo='$tp_calculo') order by tipo_nomina,cod_departam,cod_cargo,cod_empleado,cod_concepto"; $res=pg_query($sql);
?>
       <table width="1070"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="100" align="center" bgcolor="#99CCFF"><strong>Fecha</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
           <td width="300" align="center" bgcolor="#99CCFF"><strong>Nombre Trabajador</strong></td>
           <td width="40" align="center" bgcolor="#99CCFF" ><strong>Conc.</strong></td>
           <td width="250" align="center" bgcolor="#99CCFF" ><strong>Denominaci&oacute;n del Concepto</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF" ><strong>Total</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Cantidad</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>Oculto</strong></td>
       </tr>
<?$total=0; while($registro=pg_fetch_array($res)) { $cantidad=$registro["cantidad"]; $monto=$registro["monto"]; $cantidad=formato_monto($cantidad); $monto=formato_monto($monto); if($prev_cod<>$registro["cod_empleado"]){$prev_cod=$registro["cod_empleado"]; $cant_trab=$cant_trab+1;} if($registro["oculto"]=="NO"){$t_asina=$t_asina+$registro["monto_asignacion"];  $t_deducc=$t_deducc+$registro["monto_deduccion"];}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];"  >
           <td width="100" align="left"><? echo formato_ddmmaaaa($registro["fecha_hasta"]); ?></td>
           <td width="100" align="left"><? echo $registro["cod_empleado"]; ?></td>
           <td width="300" align="left"><? echo $registro["nombre"]; ?></td>
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
         <td width="102"><span class="Estilo5">CANTIDAD TRABAJADORES :</span></td>
         <td width="81" align="center"><table width="46" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $cant_trab; ?></td></tr>
         </table></td>
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