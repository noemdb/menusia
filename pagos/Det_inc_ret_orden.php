<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';$bloqueada="N";}else{$codigo_mov=$_GET["codigo_mov"];$bloqueada=$_GET["bloqueada"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Detalles Incluir Retencion a la Orden)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,tipo_ret,tipo,referencia,codigo,fuente){var murl;
var mbloq = '<?echo $bloqueada?>';
  if ((codigo=="")||(mbloq=="S")) {alert("Retencion no puede ser Modificada");}
  else{ murl="Mod_ret_ord.php?codigo_mov="+codigo_mov+"&tipo_ret="+tipo_ret+"&tipo="+tipo+"&referencia="+referencia+"&codigo="+codigo+"&fuente="+fuente+"&bloqueada="+mbloq; document.location=murl;}
}
</script>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="140" align="center" valign="middle"><? if($bloqueada=='N'){?><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Retencion a la Orden" onclick="javascript:LlamarURL('Inc_ret_orden.php?codigo_mov=<?echo $codigo_mov?>&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>')"><? }?> </td>
            <td width="200" align="center"><? if($bloqueada=='N'){?> <input name="btGenRetIva" type="button" id="btGenRetIva"  value="Gen. Retencion Iva" title="Generar Retenciones de Iva" onclick="javascript:LlamarURL('Inc_ret_iva.php?codigo_mov=<?echo $codigo_mov?>&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>')"><? }?> </td>
            <td width="200" align="center"><? if($bloqueada=='N'){?> <input name="btGenRetIslr" type="button" id="btGenRetIslr"  value="Gen. Retencion ISLR" title="Generar Retenciones de Islr" onclick="javascript:LlamarURL('Inc_ret_islr.php?codigo_mov=<?echo $codigo_mov?>&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>')"><? }?> </td>
            <td width="140" align="center"><? if($bloqueada=='N'){?> <input name="btGenRetotros" type="button" id="btGenRetotros"  value="Gen. Retencion Otro" title="Generar Retenciones de 1*100" onclick="javascript:LlamarURL('Inc_ret_otros.php?codigo_mov=<?echo $codigo_mov?>&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>')"><? }?> </td>
			<td width="200" align="center"><? if($bloqueada=='N'){?> <input name="btGenRetotros" type="button" id="btGenRetotros"  value="Gen. Retencion Lab." title="Generar Retenciones Laboral y Fiel" onclick="javascript:LlamarURL('Inc_ret_laboral.php?codigo_mov=<?echo $codigo_mov?>&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>')"><? }?> </td>
          </tr>
      </table></td>
    </tr>
    <tr height="10">
      <td>
        <p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
       <?php
$sql="SELECT * FROM COD_RET where codigo_mov='$codigo_mov' order by tipo_retencion";$res=pg_query($sql);
?>
      <table width="1440"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="50" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
           <td width="50" align="right" bgcolor="#99CCFF" ><strong>Tasa </strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>M. Objeto </strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Retencion </strong></td>
           <td width="300"  align="left" bgcolor="#99CCFF"><strong>Codigo presupuestario</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Ced/Rif</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>Concepto</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)){ $monto=$registro["monto_retencion"]; $monto=formato_monto($monto);$total=$total+$registro["monto_retencion"];$concepto_ret=$registro["des_orden_ret"]; $concepto_ret=substr($concepto_ret,0,150); $tasa=$registro["tasa_retencion"];$tasa=formato_monto($tasa); $monto_objeto=$registro["monto_objeto_ret"];$monto_objeto=formato_monto($monto_objeto);
$codigo=$registro["tipo_comp_ret"]." ".$registro["ref_comp_ret"]." ".$registro["fuente_fin_ret"]." ".$registro["cod_presup_ret"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["tipo_retencion"]; ?>','<? echo $registro["tipo_comp_ret"]; ?>','<? echo $registro["ref_comp_ret"]; ?>','<? echo $registro["cod_presup_ret"]; ?>','<? echo $registro["fuente_fin_ret"]; ?>');">
           <td width="50" align="left"><? echo $registro["tipo_retencion"]; ?></td>
           <td width="300" align="left"><? echo $registro["descripcion_ret"]; ?></td>
           <td width="50" align="right"><? echo $tasa; ?></td>
           <td width="100" align="right"><? echo $monto_objeto; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
           <td width="300" align="left"><? echo $codigo; ?></td>
           <td width="50" align="left"><? echo $registro["ced_rif_r"]; ?></td>
           <td width="100" align="left"><? echo $concepto_ret; ?></td>
         </tr>
 <?}  $total=formato_monto($total); ?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="802" border="0">
       <tr>
         <td width="103">&nbsp;</td>
         <td width="378">&nbsp;</td>
         <td width="132"><span class="Estilo5">TOTAL RETENCIONES:</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td align="right" class="Estilo5"><? echo $total; ?></td>
           </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?   pg_close(); ?>
