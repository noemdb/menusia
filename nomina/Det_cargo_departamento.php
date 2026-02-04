<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Detalles de los Cargos por Departamento)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
.Estilo10 {font-size: 12px}
-->
</style>
</head>
<body>
 <table width="815" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td><table width="821" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td width="23" height="18">&nbsp;</td>
         <td width="106"><span class="Estilo5">DEPARTAMENTO :</span></td>
         <td width="87"><span class="Estilo5"><span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
           <input name="txtnombre" type="text" class="Estilo5" id="txtnombre"  size="10" maxlength="10" readonly>
         </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong></strong></strong></strong></strong></span></span></td>
         <td width="605"><span class="Estilo5"><span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
           <input name="txtnombre2" type="text" class="Estilo5" id="txtnombre2"  size="117" maxlength="80" readonly>
         </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong></strong></strong></strong></strong></span></span></td>
       </tr>
     </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>
       <?php
if (!$_GET){$criterio='';$cod_estructura='';}
 else{$criterio=$_GET["criterio"];$cod_estructura=substr($criterio,0,8);;
}
$sql="SELECT * FROM RET_ESTRUCTURA  where cod_estructura='$cod_estructura' order by tipo_ret,tipo_comp_est,ref_comp_est,cod_presup_est,fuente_est,ref_imput_presu";
$res=pg_query($sql);
?>
       <table width="830"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="79" align="center" bgcolor="#99CCFF"><strong>C&oacute;digo Cargo</strong></td>
           <td width="262" align="center" bgcolor="#99CCFF"><strong>Descripci&oacute;n del Cargo</strong></td>
		   <td width="90" align="center" bgcolor="#99CCFF"><strong>Tipo Personal</strong></td>
           <td width="267" align="center" bgcolor="#99CCFF"><strong>Descripci&oacute;n Tipo Personal</strong></td>
		   <td width="97" align="center" bgcolor="#99CCFF"><strong>Cantidad Cargos</strong></td>
           </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto_ret"]; $monto=formato_monto($monto);$total=$total+$registro["monto_ret"];
$concepto_ret=$registro["concepto_ret"]; $concepto_ret=substr($concepto_ret,0,150);
$codigo=$registro["ref_comp_est"]." ".$registro["cod_presup_est"]." ".$registro["fuente_est"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="79" align="left"><? echo $registro["tipo_ret"]; ?></td>
           <td width="262" align="left"><? echo $registro["descripcion_ret"]; ?></td>
		   <td width="90" align="left"><? echo $registro["tipo_ret"]; ?></td>
           <td width="267" align="left"><? echo $registro["descripcion_ret"]; ?></td>
		   <td width="97" align="left"><? echo $registro["descripcion_ret"]; ?></td>
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
     <td>&nbsp;</td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?
  pg_close();
?>