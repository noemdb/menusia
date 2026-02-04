<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if(!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];} $cod_tipo_orden=""; $ced_emp="";
$StrSQL="select tipo_orden,ced_rif from pag036 where codigo_mov='$codigo_mov'";$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $cod_tipo_orden=$registro["tipo_orden"]; $ced_emp=$registro["ced_rif"]; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGO (Detalles Codigos de la Orden)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,codigo,fuente,ref_imput,ref_comp,tipo_comp){var murl;
  if (codigo=="") {alert("Codigo debe ser Seleccionada");}
  else{ murl="Mod_comp_ord.php?codigo_mov="+codigo_mov+"&codigo="+codigo+"&fuente="+fuente+"&ref_imput="+ref_imput+"&ref_comp="+ref_comp+"&tipo_comp="+tipo_comp; document.location=murl;}
}
</script>
<body>
<table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
		  <!--
            <td width="255" align="center"><? if($cod_tipo_orden=='0004'){?> <input name="btcargaest" type="button" id="btcargaest"  value="Carga Estructura" title="Carga Estructura" onclick="javascript:LlamarURL('Carga_est_emp.php?codigo_mov=<?echo $codigo_mov?>&ced_emp=<?echo $ced_emp?>&password=<?echo $password?>&user=<?echo $user?>&dbname=<?echo $dbname?>')"><? }?> </td>
          -->  
			<td width="210" align="center">&nbsp;</td>			
			<td width="210" align="center">&nbsp;</td>
			<td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Codigos de la Orden"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="5">
      <td><p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
<?$sql="SELECT * FROM COD_PRE026_ORD where codigo_mov='$codigo_mov' order by tipo_compromiso,referencia_comp,cod_presup"; $res=pg_query($sql);
?>
 <table width="2250" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="2240">
       <table width="2140"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
           <td width="190"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
		   
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Comprometido </strong></td>
           <td width="110" align="right" bgcolor="#99CCFF" ><strong>Causado </strong></td>
		   <td width="100" align="left" bgcolor="#99CCFF"><strong>Documento</strong></td>
           <td width="500" align="center" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Cod.Cuenta </strong></td>
           <td width="400" align="left" bgcolor="#99CCFF" ><strong>Nombre Cuenta </strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Tipo Imputacion</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF" ><strong>Referencia Cred.</strong></td>
           <td width="110" align="left" bgcolor="#99CCFF" ><strong>Credito </strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Cuenta Anticipo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF" ><strong>Tasa</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto"]); $monto_c=formato_monto($registro["monto_presup"]);
  $monto_credito=formato_monto($registro["monto_credito"]); $tasa=formato_monto($registro["amort_anticipo"]);
  $total=$total+$registro["monto"]; $tipo_imput_presu=$registro["tipo_imput_presu"];  $ref_imput_presu=$registro["ref_imput_presu"];
  $fecha=$registro["fecha_aep"]; if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
  if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["cod_presup"]; ?>','<? echo $registro["fuente_financ"]; ?>','<? echo $registro["ref_imput_presu"]; ?>','<? echo $registro["referencia_comp"]; ?>','<? echo $registro["tipo_compromiso"]; ?>');">
           <td width="100" align="left"><? echo $registro["referencia_comp"]; ?></td>
           <td width="40" align="left"><? echo $registro["tipo_compromiso"]; ?></td>
           <td width="80" align="left"><? echo $fecha; ?></td>
           <td width="190" align="left"><? echo $registro["cod_presup"]; ?></td>
           <td width="40" align="left"><? echo $registro["fuente_financ"]; ?></td>
          
           <td width="110" align="right"><? echo $monto_c; ?></td>
           <td width="110" align="right"><? echo $monto; ?></td>
		    <td width="100" align="left"><? echo $registro["nro_documento"]; ?></td>
		   <td width="500" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="120" align="left"><? echo $registro["cod_con_g_pagar"]; ?></td>
           <td width="400" align="left"><? echo $registro["nombre_cuenta"]; ?></td>
           <td width="120" align="left"><? echo $tipo_imput_presu; ?></td>
           <td width="100" align="left"><? echo $ref_imput_presu; ?></td>
           <td width="110" align="right"><? echo $monto_credito; ?></td>
           <td width="120" align="left"><? echo $registro["ref_aep"]; ?></td>
           <td width="40" align="right"><? echo $tasa; ?></td>
         </tr>
<?} $total=formato_monto($total);?>
       </table></td>
   </tr>
   <tr><td>&nbsp;</td></tr>
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