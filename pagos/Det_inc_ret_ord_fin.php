<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];}
$sSQL="Select * from PAG036 WHERE codigo_mov='$codigo_mov'";
$resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
if ($filas>0){ $registro=pg_fetch_array($resultado); $monto_t=$registro["total_causado"];} else {$monto_t=0;}  $monto_t=formato_monto($monto_t);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Detalles Incluir Retencion a la Orden)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,tipo_ret){var murl;
  if (tipo_ret=="") {alert("Retencion debe ser Seleccionada");}
  else{ murl="Mod_ret_ord_fin.php?codigo_mov="+codigo_mov+"&tipo_ret="+tipo_ret; document.location=murl;}
}
</script>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Retencion a la Orden" onclick="javascript:LlamarURL('Inc_ret_orden_fin.php?codigo_mov=<?echo $codigo_mov?>&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>&monto_ob=<?echo $monto_t?>')"></td>
            <td width="255" align="center">&nbsp;</td>
            <td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Retenciones de la Orden"></td>
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
$sql="SELECT * FROM COD_RET where codigo_mov='$codigo_mov' order by tipo_retencion";
$res=pg_query($sql);
?>
      <table width="1440"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="50" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
           <td width="50" align="right" bgcolor="#99CCFF" ><strong>Tasa </strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>M. Objeto </strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Retencion </strong></td>
           <td width="300"  align="left" bgcolor="#99CCFF"><strong>Codigo Contable</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Ced/Rif</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>Concepto</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto_retencion"]; $monto=formato_monto($monto);$total=$total+$registro["monto_retencion"];
$concepto_ret=$registro["des_orden_ret"]; $concepto_ret=substr($concepto_ret,0,150);
$tasa=$registro["tasa_retencion"];$tasa=formato_monto($tasa);
$monto_objeto=$registro["monto_objeto_ret"];$monto_objeto=formato_monto($monto_objeto);
$codigo=$registro["cod_contable_ret"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["tipo_retencion"]; ?>');">
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
<?
  pg_close();
?>