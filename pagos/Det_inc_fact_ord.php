<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';$ref_comp='N';$ced_rif="";}else{$codigo_mov=$_GET["codigo_mov"];$ref_comp=$_GET["ref_comp"];$ced_rif=$_GET["ced_rif"];}
$ivag=0;$sql="Select * from SIA000"; $res=pg_query($sql); if ($registro=pg_fetch_array($res,0)){$ivag=$registro["campo056"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Incluir Facturas de la Orden)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function cerrar_fact(mfacturas){
  window.opener.document.forms[0].txtnro_documento.value = mfacturas;
  window.close();
}
function Llamar_Inc_factura(codigo_mov,iva,ref_comp,ced_rif){
var murl;var mtipo_comp="";var mref_comp="";
 murl="Inc_fact_ord.php?codigo_mov=<?echo $codigo_mov?>&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>&ivag="+iva+"&ref_comp="+ref_comp+"&ced_rif="+ced_rif+"&tipo_comp=&ref_compromiso=&monto=";
 document.location=murl;
}
function Llama_Modificar(codigo_mov,factura,ref_comp,ced_rif){var murl;
  if (factura=="") {alert("Factura debe ser Seleccionada");}else{ murl="Mod_fact_ord.php?codigo_mov="+codigo_mov+"&factura="+factura+"&ref_comp="+ref_comp+"&ced_rif="+ced_rif; document.location=murl;}
}
</script>
<body>
 <table width="1084" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Factura" onclick="javascript:Llamar_Inc_factura('<? echo $codigo_mov; ?>','<? echo $ivag; ?>','<? echo $ref_comp; ?>','<? echo $ced_rif; ?>');"></td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar las Facturas"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="5">
      <td>
        <p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
<?php $sql="SELECT * FROM PAG029 where codigo_mov='$codigo_mov' order by campo_str1,nro_factura"; $res=pg_query($sql);?>
       <table width="1180"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_pasivo">
         <tr height="20" class="Estilo5">
           <td width="120"  align="left" bgcolor="#99CCFF"><strong>Rif Factura</strong></td>
           <td width="150"  align="left" bgcolor="#99CCFF"><strong>Nro. Factura</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
           <td width="170" align="left" bgcolor="#99CCFF"><strong>Nro. Control</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto sin IVA</strong></td>
           <td width="60" align="right" bgcolor="#99CCFF" ><strong>Tasa IVA</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto Objeto</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto con IVA</strong></td>
		   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Objeto Retencion</strong></td>           
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Ref.Comp</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
         </tr>
         <? $total=0; $subtotal=0; $stfact="";
while($registro=pg_fetch_array($res))
{  $sfecha=$registro["fecha_factura"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
$monto=$registro["monto_factura"]; $total=$total+$monto; $monto=formato_monto($monto);
$montos=$registro["monto_sin_iva"]; $subtotal=$subtotal+$montos; $montos=formato_monto($montos);
$tasa=$registro["tasa_iva1"];  $tasa=formato_monto($tasa);
$montoo=$registro["monto_iva1_so"];  $montoo=formato_monto($montoo);
$montoor=$registro["monto_iva4_so"];  $montoor=formato_monto($montoor);
if ($stfact=="") {$stfact="";}else{$stfact=$stfact.",";}$stfact=$stfact.elimina_ceros($registro["nro_factura"]);
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["nro_factura"]; ?>','<? echo $ref_comp; ?>','<? echo $ced_rif; ?>');">
           <td width="120" align="left"><? echo $registro["rif_factura"]; ?></td>
           <td width="150" align="left"><? echo $registro["nro_factura"]; ?></td>
           <td width="80" align="left"><? echo $fecha; ?></td>
           <td width="170" align="left"><? echo $registro["nro_con_factura"]; ?></td>
           <td width="100" align="right"><? echo $montos; ?></td>
           <td width="60" align="right"><? echo $tasa; ?></td>
           <td width="100" align="right"><? echo $montoo; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
		   <td width="100" align="right"><? echo $montoor; ?></td>
           <td width="80" align="left"><? echo $registro["ref_compromiso"]; ?></td>
           <td width="40" align="left"><? echo $registro["tipo_compromiso"]; ?></td>
         </tr>
         <?}
 $tiva=$total-$subtotal; $total=formato_monto($total); $subtotal=formato_monto($subtotal); $tiva=formato_monto($tiva);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="700" border="0">
       <tr>
         <td width="20">&nbsp;</td>
         <td width="80"><span class="Estilo5">SUBTOTAL :</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $subtotal; ?></td> </tr>
         </table></td>
         <td width="60"><span class="Estilo5">I.V.A. :</span></td>
         <td width="150"><table width="141" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $tiva; ?></td> </tr>
         </table></td>
         <td width="70"><span class="Estilo5">TOTAL :</span></td>
         <td width="160"><table width="151" border="1" cellspacing="0" cellpadding="0">
             <tr> <td align="right" class="Estilo5"><? echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table><p>&nbsp;</p></td>
   </tr>
   <tr>
     <td align="center"><input name="btcerrar" type="button" id="btcerrar" value="Cerra Ventana" onclick="javascrip:cerrar_fact('<? echo $stfact; ?>');"></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close();?>
