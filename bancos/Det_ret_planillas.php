<?include ("../class/conect.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];}  $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTROL BANCARIO (Detalles Planillas de Retencion)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,orden,tipo,aux,planilla,nro_planilla){var murl;
   murl="Mod_planilla_ret.php?codigo_mov="+codigo_mov+"&orden="+orden+"&tipo="+tipo+"&aux="+aux+"&planilla="+planilla+"&nro_planilla="+nro_planilla; document.location=murl; }
</script>
<body>
<table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"> <input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar planilla de retención" onclick="javascript:LlamarURL('Inc_plan_ret.php?codigo_mov=<?echo $codigo_mov?>&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>&fechah=<?echo $fecha_hoy?>')">   </td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Códigos de la Orden"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="5">
      <td><p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
<?php $sql="SELECT * FROM BAN029 where codigo_mov='$codigo_mov' order by tipo_retencion,nro_planilla"; $res=pg_query($sql); ?>
 <table width="1510" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1500">
       <table width="1500"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_orden">
         <tr height="20" class="Estilo5">
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Orden</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Tipo R</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Ord. Retencion</strong></td>
           <td width="50" align="right" bgcolor="#99CCFF" ><strong>Tasa </strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto Objeto </strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto Ret.</strong></td>
           <td width="60" align="left" bgcolor="#99CCFF" ><strong>Planilla</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF" ><strong>Nro. Planilla</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF" ><strong>Tipo Enriquecimiento </strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Tipo Documento </strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Nro. Documento </strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Nro. Control </strong></td>
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Fecha Factura</strong></td>
           <td width="140" align="right" bgcolor="#99CCFF" ><strong>Total Factura</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto IVA</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)){ $monto_r=formato_monto($registro["monto_retencion"]);
  $monto_o=formato_monto($registro["monto_objeto"]); $tasa=formato_monto($registro["tasa"]); $monto1=formato_monto($registro["monto1"]);  $monto2=formato_monto($registro["monto2"]);
  if($registro["tipo_planilla"]!="00"){$total=$total+$registro["monto_retencion"];} else{$total=$total;}  $sfecha=$registro["fecha_factura"];  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["nro_orden"]; ?>','<? echo $registro["tipo_retencion"]; ?>','<? echo $registro["aux_orden"]; ?>','<? echo $registro["tipo_planilla"]; ?>','<? echo $registro["nro_planilla"]; ?>');">
           <td width="100" align="left"><? echo $registro["nro_orden"]; ?></td>
           <td width="40" align="left"><? echo $registro["tipo_retencion"]; ?></td>
           <td width="100" align="left"><? echo $registro["aux_orden"]; ?></td>
           <td width="50" align="right"><? echo $tasa; ?></td>
           <td width="120" align="right"><? echo $monto_o; ?></td>
           <td width="120" align="right"><? echo $monto_r; ?></td>
           <td width="60" align="center"><? echo $registro["tipo_planilla"]; ?></td>
           <td width="100" align="left"><? echo $registro["nro_planilla"]; ?></td>
           <td width="200" align="left"><? echo $registro["tipo_en"]; ?></td>
           <td width="120" align="left"><? echo $registro["tipo_documento"]; ?></td>
           <td width="120" align="left"><? echo $registro["nro_documento"]; ?></td>
           <td width="120" align="left"><? echo $registro["nro_con_factura"]; ?></td>
           <td width="100" align="left"><? echo $fecha; ?></td>
           <td width="140" align="right"><? echo $monto1; ?></td>
           <td width="120" align="right"><? echo $monto2; ?></td>
         </tr>
         <?} $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr> <td>&nbsp;</td> </tr>  <tr> <td>&nbsp;</td> </tr>
   <tr>
     <td><table width="830" border="0">
       <tr>
         <td width="530">&nbsp;</td>
         <td width="150" align="center"><span class="Estilo5">TOTAL :</span></td>
         <td><table width="125" border="1" cellspacing="0" cellpadding="0">
           <tr> <td width="123" align="right" class="Estilo5"><? echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<? pg_close(); ?>