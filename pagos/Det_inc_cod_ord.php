<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';$bloqueada="N";}else{$codigo_mov=$_GET["codigo_mov"];$bloqueada=$_GET["bloqueada"];}
$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];}else{$formato_presup="XX-XX-XX-XXX-XX-XX-XX";$formato_cat="XX-XX-XX";}$len_cat=strlen($formato_cat);  $len_cod=strlen($formato_presup);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Detalles Incluir Codigos de la Orden)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,codigo,fuente,ref_imput,ref_comp,tipo_comp){var murl;
var mbloq = '<?echo $bloqueada?>';
  if ((codigo=="")||(mbloq=="S")) {alert("Codigo no puede ser Modificado");}
  else{ murl="Mod_codigo_ord.php?codigo_mov="+codigo_mov+"&codigo="+codigo+"&fuente="+fuente+"&ref_imput="+ref_imput+"&ref_comp="+ref_comp+"&tipo_comp="+tipo_comp; document.location=murl;}
}
function Llama_Iva(codigo_mov){var murl; Gcodigo_mov=codigo_mov;  murl="Inc_codiva_ord.php?codigo_mov="+Gcodigo_mov+"&formato=<?echo $formato_presup?>"; document.location=murl;}
</script>
<body>
<table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="222" align="center" valign="middle"> <? if($bloqueada=='N'){?> <input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Codigo a la Orden" onclick="javascript:LlamarURL('Inc_codigo_ord.php?codigo_mov=<?echo $codigo_mov?>&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>&formato=<?echo $formato_presup?>')"  ><? }?> </td>
            <td width="150" align="center">&nbsp;</td>
            <td width="170" align="center"><? if($bloqueada=='N'){?> <input name="btIva" type="button" id="btIva" value="IVA" title="Registra Codigo del IVA" onClick="JavaScript:Llama_Iva('<?echo $codigo_mov?>')" ><? }?> </td>
            <td width="150" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Codigos de la Orden"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="5">
      <td>
        <p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
<?php
$sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup";$res=pg_query($sql);
?>
 <table width="1810" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1800">
       <table width="1800"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="190"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="500" align="center" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Causado </strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Cod.Cuenta </strong></td>
           <td width="400" align="left" bgcolor="#99CCFF" ><strong>Nombre Cuenta </strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Tipo Imputacion</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF" ><strong>Referencia Cred.</strong></td>
           <td width="110" align="left" bgcolor="#99CCFF" ><strong>Credito </strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto"]);
  $monto_credito=formato_monto($registro["monto_credito"]);  $total=$total+$registro["monto"];
  $tipo_imput_presu=$registro["tipo_imput_presu"];  $ref_imput_presu=$registro["ref_imput_presu"];
  if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["cod_presup"]; ?>','<? echo $registro["fuente_financ"]; ?>','<? echo $registro["ref_imput_presu"]; ?>','<? echo $registro["referencia_comp"]; ?>','<? echo $registro["tipo_compromiso"]; ?>');">
           <td width="190" align="left"><? echo $registro["cod_presup"]; ?></td>
           <td width="40" align="left"><? echo $registro["fuente_financ"]; ?></td>
           <td width="500" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="110" align="right"><? echo $monto; ?></td>
           <td width="120" align="left"><? echo $registro["cod_con_g_pagar"]; ?></td>
           <td width="400" align="left"><? echo $registro["nombre_cuenta"]; ?></td>
           <td width="120" align="left"><? echo $tipo_imput_presu; ?></td>
           <td width="100" align="left"><? echo $ref_imput_presu; ?></td>
           <td width="110" align="right"><? echo $monto_credito; ?></td>
         </tr>
         <?} $total=formato_monto($total);?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="830" border="0">
       <tr>
         <td width="530">&nbsp;</td>
         <td width="150" align="center"><span class="Estilo5">TOTAL CAUSADO :</span></td>
         <td><table width="125" border="1" cellspacing="0" cellpadding="0">
           <tr>
             <td width="123" align="right" class="Estilo5"><? echo $total; ?></td>
           </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<? pg_close(); ?>