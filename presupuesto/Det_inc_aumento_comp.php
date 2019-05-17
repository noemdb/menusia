<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) {echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Detalles Incluir C&oacute;digos del Ajuste)</title>
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<style type="text/css">
<!--
.Estilo10 {font-size: 12px}
-->
</style>
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Modificar(mcodigo_mov,mcodigo,mfuente,mref_imput_presu){var murl;
  if (mcodigo=="") {alert("Codigo Presupuestario debe ser Seleccionada");}
  else{ murl="Mod_cod_aumento_comp.php?codigo_mov="+mcodigo_mov+"&codigo="+mcodigo+"&fuente="+mfuente+"&ref_imput_presu="+mref_imput_presu; document.location=murl;}
}
</script>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
    <tr height="10">
      <td>
        <p>&nbsp;</p></td>
    </tr>
   <tr>
     <td>
       <?php
$sql="SELECT * FROM CODIGOS_PRE026  where codigo_mov='$codigo_mov' order by cod_presup,fuente_financ,ref_imput_presu";$res=pg_query($sql);
?>
       <table width="1070"  border="1" cellspacing='0' cellpadding='0' align="left" id="codigos">
         <tr height="20" class="Estilo5">
           <td width="200"  align="left" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
           <td width="40" align="left" bgcolor="#99CCFF"><strong>Fuente</strong></td>
           <td width="400" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Saldo </strong></td>
           <td width="100" align="right" bgcolor="#99CCFF" ><strong>Ajuste</strong></td>
           <td width="120" align="left" bgcolor="#99CCFF" ><strong>Tipo Imputacion</strong></td>
           <td width="110" align="left" bgcolor="#99CCFF" ><strong>Referencia Cred.</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto"]; $monto=formato_monto($monto); $montoc=$registro["monto_credito"]; $montoc=formato_monto($montoc);$total=$total+$registro["monto"];
  $tipo_imput_presu=$registro["tipo_imput_presu"];$comprometido=formato_monto($registro["monto_presup"]);$credito=formato_monto($registro["amort_anticipo"]);
  if($tipo_imput_presu=="P"){$tipo_imput_presu="PRESUPUESTO";}else{$tipo_imput_presu="CRED. ADICIONAL";}
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Modificar('<? echo $codigo_mov; ?>','<? echo $registro["cod_presup"]; ?>','<? echo $registro["fuente_financ"]; ?>','<? echo $registro["ref_imput_presu"]; ?>');">
           <td width="200" align="left"><? echo $registro["cod_presup"]; ?></td>
           <td width="40" align="left"><? echo $registro["fuente_financ"]; ?></td>
           <td width="500" align="left"><? echo $registro["denominacion"]; ?></td>
           <td width="100" align="right"><? echo $comprometido; ?></td>
           <td width="100" align="right"><? echo $monto; ?></td>
           <td width="120" align="left"><? echo $tipo_imput_presu; ?></td>
           <td width="110" align="left"><? echo $registro["ref_imput_presu"]; ?></td>
         </tr>
         <?}
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="842" border="0">
       <tr>
         <td width="142">&nbsp;</td>
         <td width="440">&nbsp;</td>
         <td width="80"><span class="Estilo5">TOTAL :</span></td>
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
<?  pg_close();?>