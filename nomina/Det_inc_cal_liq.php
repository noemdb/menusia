<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$codigo_mov='';}else{$codigo_mov=$_GET["codigo_mov"];} 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Conceptos de Liquidacion)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(codigo_mov,codigo){var murl;
  if (codigo=="") {alert("Codigo no puede ser Modificado");}
  else{ murl="Mod_cod_liq.php?codigo_mov="+codigo_mov+"&cod_concepto="+codigo; document.location=murl;}
}
</script>
<body>
 <table width="945" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="940" border="0" align="left">
          <tr>
            <td width="400" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Concepto a la Liquidacion" onclick="javascript:LlamarURL('Inc_concepto_liq.php?codigo_mov=<?echo $codigo_mov?>')"></td>
            <td width="440" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar Conceptos"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="10">
      <td><p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
<?php
 $cant_trab=0;  $t_asina=0;  $t_deducc=0;
$sql="Select * from NOM076 where (codigo_mov='$codigo_mov') order by asig_ded_apo,tipo_asigna,cod_concepto,fecha_hasta"; $res=pg_query($sql);
?>
       <table width="940"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="40" align="center" bgcolor="#99CCFF" ><strong>Conc.</strong></td>
           <td width="450" align="center" bgcolor="#99CCFF" ><strong>Denominaci&oacute;n del Concepto</strong></td>
		   <td width="30" align="center" bgcolor="#99CCFF" ><strong>A/D</strong></td>
           <td width="70" align="center" bgcolor="#99CCFF" ><strong>Cantidad</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Monto</strong></td>
		   <td width="100" align="center" bgcolor="#99CCFF" ><strong>Total</strong></td>
		   <td width="70" align="center" bgcolor="#99CCFF" ><strong>Desde</strong></td>
           <td width="70" align="center" bgcolor="#99CCFF" ><strong>Hasta</strong></td>
       </tr>
<?$total=0; while($registro=pg_fetch_array($res)) { $cantidad=$registro["cantidad"]; $monto=$registro["monto_orig"]; $total=$registro["valor"]; 
   if($registro["oculto"]=="NO"){ if($registro["asig_ded_apo"]=="A"){$t_asina=$t_asina+$registro["valor"];} if($registro["asig_ded_apo"]=="D"){$t_deducc=$t_deducc+$registro["valor"];} }
   $cantidad=formato_monto($cantidad); $monto=formato_monto($monto);   $total=formato_monto($total);   $fecha1=formato_ddmmaaaa($registro["fecha_ini"]); $fecha2=formato_ddmmaaaa($registro["fecha_hasta"]);
?>
        <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["cod_concepto"]; ?>'); " >
           <td width="40" align="left"><? echo $registro["cod_concepto"]; ?></td>
           <td width="450" align="left"><? echo $registro["denominacion"]; ?></td>
		   <td width="30" align="center"><? echo $registro["asig_ded_apo"]; ?></td>
           <td width="70" align="right"><? echo $cantidad; ?></td>
		   <td width="100" align="right"><? echo $monto; ?></td>
		   <td width="100" align="right"><? echo $total; ?></td>
		   <td width="70" align="center"><? echo $fecha1; ?></td>
		    <td width="70" align="center"><? echo $fecha2; ?></td>
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