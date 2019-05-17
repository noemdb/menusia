<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$criterio='';$cod_estructura='';} else{$criterio=$_GET["criterio"];$cod_estructura=substr($criterio,0,8);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Detalles del Conceptos Calculados)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="982" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="982">
       <?php

$sql="SELECT * FROM RET_ESTRUCTURA  where cod_estructura='$cod_estructura' order by tipo_ret,tipo_comp_est,ref_comp_est,cod_presup_est,fuente_est,ref_imput_presu";
$res=pg_query($sql);
?>
       <table width="982"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="59" align="center" bgcolor="#99CCFF"><strong>C&oacute;digo</strong></td>
           <td width="159" align="center" bgcolor="#99CCFF"><strong>Denominaci&oacute;n</strong></td>
		   <td width="39" align="center" bgcolor="#99CCFF"><strong>A/D</strong></td>
		   <td width="68" align="center" bgcolor="#99CCFF"><strong>Cantidad</strong></td>
		   <td width="66" align="center" bgcolor="#99CCFF"><strong>Monto</strong></td>
		   <td width="46" align="center" bgcolor="#99CCFF"><strong>Acum.</strong></td>
		   <td width="57" align="center" bgcolor="#99CCFF"><strong>Frec.</strong></td>
		   <td width="57" align="center" bgcolor="#99CCFF"><strong>Seman.</strong></td>
		   <td width="66" align="center" bgcolor="#99CCFF"><strong>Oculto</strong></td>
		   <td width="88" align="center" bgcolor="#99CCFF"><strong>Monto Orig.</strong></td>
		   <td width="83" align="center" bgcolor="#99CCFF"><strong>Afecta</strong></td>
		   <td width="154" align="center" bgcolor="#99CCFF"><strong>Cod. Presupuestario</strong></td>
         </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto_ret"]; $monto=formato_monto($monto);$total=$total+$registro["monto_ret"];
$concepto_ret=$registro["concepto_ret"]; $concepto_ret=substr($concepto_ret,0,150);
$codigo=$registro["ref_comp_est"]." ".$registro["cod_presup_est"]." ".$registro["fuente_est"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="59" align="left"><? echo $registro["tipo_ret"]; ?></td>
           <td width="159" align="left"><? echo $registro["descripcion_ret"]; ?></td>
		   <td width="39" align="left"><? echo $registro["tipo_ret"]; ?></td>
		   <td width="68" align="left"><? echo $registro["tipo_ret"]; ?></td>
		   <td width="66" align="left"><? echo $registro["tipo_ret"]; ?></td>
		   <td width="46" align="left"><? echo $registro["tipo_ret"]; ?></td>
		   <td width="57" align="left"><? echo $registro["tipo_ret"]; ?></td>
           <td width="57" align="left"><? echo $registro["descripcion_ret"]; ?></td>
		   <td width="66" align="left"><? echo $registro["tipo_ret"]; ?></td>
		   <td width="88" align="left"><? echo $registro["tipo_ret"]; ?></td>
		   <td width="83" align="left"><? echo $registro["tipo_ret"]; ?></td>
		   <td width="154" align="left"><? echo $registro["tipo_ret"]; ?></td>
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