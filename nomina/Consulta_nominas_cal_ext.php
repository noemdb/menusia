<?include ("../class/conect.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if(pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<script language="JavaScript">
function cerrar_catalogo(tipo_nomina,des_nomina,fecha_p_d,fecha_p_h,num_per){ 
  window.opener.document.forms[0].txttipo_nomina.value = tipo_nomina;
  window.opener.document.forms[0].txtdes_nomina.value = des_nomina;
  window.opener.document.forms[0].txtfecha_desde.value = fecha_p_d;
  window.opener.document.forms[0].txtfecha_hasta.value = fecha_p_h;
  window.opener.document.forms[0].txtnum_periodos.value = num_per;
  window.opener.document.forms[0].txttipo_nomina.focus();
  window.close();
}</script>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Nominas Calculadas)</title>
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
</head>
<body>
 <table width="820" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
//if (!$_GET){$tipo_nomina='';} else{$tipo_nomina=$_GET["txttipo_nomina"];}
$sql="select distinct tipo_nomina,des_nomina,tp_calculo,fecha_p_desde,fecha_p_hasta,concepto_vac,num_periodos from nom017 where tp_calculo='E' order by tipo_nomina,fecha_p_desde desc ,fecha_p_hasta desc";$res=pg_query($sql);
?>
       <table width="700"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_pasivo">
         <tr height="20" class="Estilo5">
		   <td width="100" align="center" bgcolor="#99CCFF"><strong>Tipo Nomina</strong></td>
		   <td width="300" align="center" bgcolor="#99CCFF"><strong>Denominacion</strong></td>
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Fecha Desde</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>Fechas Hasta</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Conceptos</strong></td>
         </tr>
         <? while($registro=pg_fetch_array($res)){ $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];  $fecha_p_desde=$registro["fecha_p_desde"]; $fecha_p_desde = substr($fecha_p_desde,8,2)."/".substr($fecha_p_desde,5,2)."/".substr($fecha_p_desde,0,4);
 $fecha_p_hasta=$registro["fecha_p_hasta"]; $fecha_p_hasta = substr($fecha_p_hasta,8,2)."/".substr($fecha_p_hasta,5,2)."/".substr($fecha_p_hasta,0,4); $num_periodos=$registro["num_periodos"];
 if ($registro["tp_calculo"]=="E"){$tp_calculo="EXTRAORDINARIA"; if ($registro["concepto_vac"]=="S"){$concepto_vac="VACACIONES - ".$num_periodos;}else{ $concepto_vac="NOMINA - ".$num_periodos;}
 }else{ $tp_calculo="NORMAL"; if ($registro["concepto_vac"]=="S"){$concepto_vac="VACACIONES";}else{ $concepto_vac="NOMINA";} }
/*
 onDblClick="javascript:cerrar_catalogo('<? echo $tipo_nomina; ?>','<? echo $des_nomina; ?>'),'<? echo $fecha_p_desde; ?>'),'<? echo $fecha_p_hasta; ?>'),'<? echo $num_periodos; ?>')"
 */
 ?>
        <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:cerrar_catalogo('<? echo $tipo_nomina; ?>','<? echo $des_nomina; ?>','<? echo $fecha_p_desde; ?>','<? echo $fecha_p_hasta; ?>','<? echo $num_periodos; ?>'); " >
         
		   <td width="100" align="center"><? echo $tipo_nomina; ?></td>
		   <td width="300" align="left"><? echo $des_nomina; ?></td>
		   <td width="100" align="left"><? echo $fecha_p_desde; ?></td>
		   <td width="100" align="left"><? echo $fecha_p_hasta; ?></td>
		   <td width="100" align="center"><? echo $concepto_vac; ?></td>           
         </tr>
         <?}?>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>   
   <tr>
     <td align="center"><input name="btcerrar" type="button" id="btcerrar" value="Cerra Ventana" onclick="javascrip:cerrar_ventana();"></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close(); ?>