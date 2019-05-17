<?include ("../class/conect.php");  include ("../class/funciones.php"); if (!$_GET){$criterio='';$cod_estructura='';} else{$criterio=$_GET["criterio"];$cod_estructura=substr($criterio,0,8);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Detalles Conceptos)</title>
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
</head>
<body>
 <table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
$sql="SELECT * FROM RET_ESTRUCTURA  where cod_estructura='$cod_estructura' order by tipo_ret,tipo_comp_est,ref_comp_est,cod_presup_est,fuente_est,ref_imput_presu";
$res=pg_query($sql);
?>
       <table width="8550"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_estructura">
         <tr height="20" class="Estilo5">
           <td width="184" align="center" bgcolor="#99CCFF"><strong>Fecha Ingreso</strong></td>
           <td width="358" align="center" bgcolor="#99CCFF"><strong>Fecha Ingreso Administraci&oacute;n Publica</strong></td>
           <td width="263" align="center" bgcolor="#99CCFF" ><strong>Estatus Trabajador </strong></td>
           <td width="362" align="center" bgcolor="#99CCFF" ><strong>Tipo N&oacute;mina </strong></td>
           <td width="235" align="center" bgcolor="#99CCFF" ><strong>C&oacute;digo Categoria </strong></td>
		   <td width="164" align="center" bgcolor="#99CCFF" ><strong>Forma de Pago </strong></td>
		   <td width="263" align="center" bgcolor="#99CCFF" ><strong>Número Cuenta Trabajador </strong></td>
		   <td width="176" align="center" bgcolor="#99CCFF" ><strong>Tipo Cuenta </strong></td>
		   <td width="362" align="center" bgcolor="#99CCFF" ><strong>Cuenta Empresa </strong></td>
		   <td width="195" align="center" bgcolor="#99CCFF" ><strong>Número </strong></td>
		   <td width="283" align="center" bgcolor="#99CCFF" ><strong>Presenta Declaraci&oacute;n Jurada </strong></td>
		   <td width="283" align="center" bgcolor="#99CCFF" ><strong>Fecha Declaraci&oacute;n Jurada </strong></td>
		   <td width="283" align="center" bgcolor="#99CCFF" ><strong>Monto Declaraci&oacute;n </strong></td>
		   <td width="168" align="center" bgcolor="#99CCFF" ><strong>C&oacute;digo LPH </strong></td>
		   <td width="797" align="center" bgcolor="#99CCFF" ><strong>Banco </strong></td>
		   <td width="176" align="center" bgcolor="#99CCFF" ><strong>Cuenta </strong></td>
		   <td width="267" align="center" bgcolor="#99CCFF" ><strong>Fecha Inscripci&oacute;n LPH </strong></td>
		   <td width="409" align="center" bgcolor="#99CCFF" ><strong>Fecha Desincorporaci&oacute;n LPH </strong></td>
		   <td width="797" align="center" bgcolor="#99CCFF" ><strong>Fecha Programado Egreso </strong></td>
		   <td width="283" align="center" bgcolor="#99CCFF" ><strong>Tipo de Trabajador </strong></td>
		   <td width="283" align="center" bgcolor="#99CCFF" ><strong>Motivo Suplencia </strong></td>
		   <td width="215" align="center" bgcolor="#99CCFF" ><strong>Fin Contrato </strong></td>
		   <td width="231" align="center" bgcolor="#99CCFF" ><strong>Cédula Titular Suplencia </strong></td>
		   <td width="599" align="center" bgcolor="#99CCFF" ><strong>Nombre Titular Suplencia </strong></td>
		   <td width="283" align="center" bgcolor="#99CCFF" ><strong>Jerarquia del Trabajador </strong></td>
		   <td width="249" align="center" bgcolor="#99CCFF" ><strong>Pago de Vacaciones por N&oacute;mina </strong></td>
		   <td width="303" align="center" bgcolor="#99CCFF" ><strong>Fecha Retorno Vacaciones </strong></td>
		   </tr>
         <? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=$registro["monto_ret"]; $monto=formato_monto($monto);$total=$total+$registro["monto_ret"];
$concepto_ret=$registro["concepto_ret"]; $concepto_ret=substr($concepto_ret,0,150);
$codigo=$registro["ref_comp_est"]." ".$registro["cod_presup_est"]." ".$registro["fuente_est"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" >
           <td width="184" align="left"><? echo $registro["tipo_ret"]; ?></td>
           <td width="358" align="left"><? echo $registro["descripcion_ret"]; ?></td>
           <td width="263" align="right"><? echo $registro["tasa"]; ?></td>
           <td width="362" align="right"><? echo $registro["monto_objeto"]; ?></td>
           <td width="235" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="164" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="263" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="176" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="362" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="195" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="283" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="283" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="283" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="168" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="797" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="176" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="267" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="409" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="797" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="283" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="283" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="215" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="231" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="599" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="283" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="249" align="right"><? echo $registro["tasa"]; ?></td>
		   <td width="303" align="right"><? echo $registro["tasa"]; ?></td>
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