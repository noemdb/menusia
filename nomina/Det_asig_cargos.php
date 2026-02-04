<?include ("../class/funciones.php"); if (!$_GET){$criterio='';$cod_estructura='';} else{$criterio=$_GET["criterio"];$cod_estructura=substr($criterio,0,8);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP NÓMINA Y PERSONAL (Detalles de la Asignación de Cargos)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
.Estilo11 {font-size: 12px}
-->
</style>
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
       <?php

$sql="SELECT * FROM RET_ESTRUCTURA  where cod_estructura='$cod_estructura' order by tipo_ret,tipo_comp_est,ref_comp_est,cod_presup_est,fuente_est,ref_imput_presu";
$res=pg_query($sql);
?>
       <table width="1440"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="93" align="center" bgcolor="#99CCFF"><strong>Código Cargo</strong></td>
           <td width="175" align="center" bgcolor="#99CCFF"><strong>Descripción Cargo</strong></td>
           <td width="101" align="center" bgcolor="#99CCFF" ><strong>Fecha Asig.</strong></td>
           <td width="127" align="center" bgcolor="#99CCFF" ><strong>Cod. Departa.</strong></td>
           <td width="157" align="center" bgcolor="#99CCFF" ><strong>Descripción Departamento</strong></td>
		   <td width="105" align="center" bgcolor="#99CCFF" ><strong>Tipo Pers.</strong></td>
		   <td width="105" align="center" bgcolor="#99CCFF" ><strong>Grado</strong></td>
		   <td width="105" align="center" bgcolor="#99CCFF" ><strong>Paso</strong></td>
		   <td width="105" align="center" bgcolor="#99CCFF" ><strong>Sueldo Base</strong></td>
		   <td width="105" align="center" bgcolor="#99CCFF" ><strong>Compensación</strong></td>
		   <td width="105" align="center" bgcolor="#99CCFF" ><strong>Otros</strong></td>
		   <td width="108" align="center" bgcolor="#99CCFF" ><strong>Sueldo Integral</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto_ret"]; $monto=formato_monto($monto);$total=$total+$registro["monto_ret"];
$concepto_ret=$registro["concepto_ret"]; $concepto_ret=substr($concepto_ret,0,150);
$codigo=$registro["ref_comp_est"]." ".$registro["cod_presup_est"]." ".$registro["fuente_est"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="93" align="left"><? echo $registro["tipo_ret"]; ?></td>
           <td width="175" align="left"><? echo $registro["descripcion_ret"]; ?></td>
           <td width="101" align="right"><? echo $registro["tasa"]; ?></td>
           <td width="127" align="right"><? echo $registro["monto_objeto"]; ?></td>
           <td width="157" align="right"><? echo $registro["monto_objeto"]; ?></td>
		   <td width="105" align="right"><? echo $registro["monto_objeto"]; ?></td>
		   <td width="105" align="right"><? echo $registro["monto_objeto"]; ?></td>
		   <td width="105" align="right"><? echo $registro["monto_objeto"]; ?></td>
		   <td width="105" align="right"><? echo $registro["monto_objeto"]; ?></td>
		   <td width="105" align="right"><? echo $registro["monto_objeto"]; ?></td>
		   <td width="105" align="right"><? echo $registro["monto_objeto"]; ?></td>
		   <td width="108" align="right"><? echo $registro["monto_objeto"]; ?></td>
         </tr>
         <?}
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
 </table>
 <table width="729" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td><table width="867" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="26">&nbsp;</td>
         <td width="134"><span class="Estilo5">C&Oacute;DIGO UBICACI&Oacute;N : </span></td>
         <td width="60"><span class="Estilo5"><span class="Estilo11">
           <input name="txtcedula" type="text" class="Estilo5" id="txtcedula4"   size="5" maxlength="5"readonly>
         </span></span></td>
         <td width="647"><span class="Estilo5"><span class="Estilo11">
           <input name="txtcedula2" type="text" class="Estilo5" id="txtcedula23"   size="60" maxlength="15" readonly>
         </span></span></td>
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