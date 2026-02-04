<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$criterio='';$cod_estructura='';} else{$criterio=$_GET["criterio"];$cod_estructura=substr($criterio,0,8);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Detalles del Archivo de N&oacute;mina)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="1456" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="1456">
<?php
$sql="SELECT * FROM RET_ESTRUCTURA  where cod_estructura='$cod_estructura' order by tipo_ret,tipo_comp_est,ref_comp_est,cod_presup_est,fuente_est,ref_imput_presu";
$res=pg_query($sql);
?>
       <table width="1456"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="105" align="center" bgcolor="#99CCFF"><strong>Relleno Cero Izq.</strong></td>
		   <td width="123" align="center" bgcolor="#99CCFF"><strong>Relleno Cero Der.</strong></td>
		   <td width="130" align="center" bgcolor="#99CCFF"><strong>Elimina Espacio Der.</strong></td>
           <td width="94" align="center" bgcolor="#99CCFF"><strong>Elimina Coma</strong></td>
		   <td width="95" align="center" bgcolor="#99CCFF"><strong>Elimina Puntos</strong></td>
           <td width="64" align="center" bgcolor="#99CCFF"><strong>Posici&oacute;n</strong></td>
		   <td width="64" align="center" bgcolor="#99CCFF"><strong>Condici&oacute;n</strong></td>
		   </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto_ret"]; $monto=formato_monto($monto);$total=$total+$registro["monto_ret"];
$concepto_ret=$registro["concepto_ret"]; $concepto_ret=substr($concepto_ret,0,150);
$codigo=$registro["ref_comp_est"]." ".$registro["cod_presup_est"]." ".$registro["fuente_est"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="80" align="left"><? echo $registro["tipo_ret"]; ?></td>
           <td width="125" align="left"><? echo $registro["descripcion_ret"]; ?></td>
		   <td width="31" align="left"><? echo $registro["tipo_ret"]; ?></td>
		   <td width="61" align="left"><? echo $registro["tipo_ret"]; ?></td>
		    <td width="73" align="left"><? echo $registro["tipo_ret"]; ?></td>
		   <td width="41" align="left"><? echo $registro["tipo_ret"]; ?></td>
		    <td width="32" align="left"><? echo $registro["tipo_ret"]; ?></td>
		   <td width="105" align="left"><? echo $registro["tipo_ret"]; ?></td>
		    <td width="123" align="left"><? echo $registro["tipo_ret"]; ?></td>
		   <td width="128" align="left"><? echo $registro["tipo_ret"]; ?></td>
		    <td width="130" align="left"><? echo $registro["tipo_ret"]; ?></td>
		   <td width="94" align="left"><? echo $registro["tipo_ret"]; ?></td>
		    <td width="95" align="left"><? echo $registro["tipo_ret"]; ?></td>
		   <td width="64" align="left"><? echo $registro["tipo_ret"]; ?></td>
		    <td width="64" align="left"><? echo $registro["tipo_ret"]; ?></td>
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