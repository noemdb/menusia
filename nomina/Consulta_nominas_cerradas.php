<?include ("../class/conect.php"); include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Tipos de Nomina Cerradas)</title>
<LINK  href="../class/sia.css" type="text/css"  rel="stylesheet">
</head>
<script language="JavaScript" type="text/JavaScript">
function Llama_Detalle_nomina(tipo_nomina,tp_calculo,fecha_p_hasta,dtp_calculo,num_periodos){var murl;
  murl="Consulta_det_nom_cerradas.php?tipo_nomina="+tipo_nomina+"&tp_calculo="+tp_calculo+"&fecha_p_hasta="+fecha_p_hasta+"&num_periodos="+num_periodos+"&dtp_calculo="+dtp_calculo; document.location=murl;
}
</script>
<body>
 <table width="520" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td>
<?php
if (!$_GET){$tipo_nomina='';} else{$tipo_nomina=$_GET["txttipo_nomina"];}
$sql="select distinct tp_calculo,fecha_p_desde,fecha_p_hasta,concepto_vac,num_periodos from nom019 where tipo_nomina='$tipo_nomina' order by fecha_p_desde desc ,fecha_p_hasta desc";$res=pg_query($sql);
?>
       <table width="500"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_pasivo">
         <tr height="20" class="Estilo5">
		   <td width="120" align="center" bgcolor="#99CCFF"><strong>Tipo de Calculo</strong></td>
           <td width="120"  align="left" bgcolor="#99CCFF"><strong>Fecha Desde</strong></td>
           <td width="120" align="left" bgcolor="#99CCFF"><strong>Fechas Hasta</strong></td>
           <td width="120" align="center" bgcolor="#99CCFF" ><strong>Conceptos</strong></td>
         </tr>
         <? while($registro=pg_fetch_array($res)){  $fecha_p_desde=$registro["fecha_p_desde"]; $fecha_p_desde = substr($fecha_p_desde,8,2)."/".substr($fecha_p_desde,5,2)."/".substr($fecha_p_desde,0,4);
 $fecha_p_hasta=$registro["fecha_p_hasta"]; $fecha_p_hasta = substr($fecha_p_hasta,8,2)."/".substr($fecha_p_hasta,5,2)."/".substr($fecha_p_hasta,0,4); $num_periodos=$registro["num_periodos"];
 if ($registro["tp_calculo"]=="E"){$tp_calculo="EXTRAORDINARIA"; if ($registro["concepto_vac"]=="S"){$concepto_vac="VACACIONES - ".$num_periodos;}else{ $concepto_vac="NOMINA - ".$num_periodos;}
 }else{ $tp_calculo="NORMAL"; if ($registro["concepto_vac"]=="S"){$concepto_vac="VACACIONES";}else{ $concepto_vac="NOMINA";} }   $tfecha_p_hasta=$registro["fecha_p_hasta"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Detalle_nomina('<? echo $tipo_nomina; ?>','<? echo $registro["tp_calculo"]; ?>','<? echo $tfecha_p_hasta; ?>','<? echo $concepto_vac; ?>','<? echo $num_periodos; ?>') " >
   		   <td width="120" align="center"><? echo $tp_calculo; ?></td>
		   <td width="120" align="left"><? echo $fecha_p_desde; ?></td>
		   <td width="120" align="left"><? echo $fecha_p_hasta; ?></td>
		   <td width="120" align="center"><? echo $concepto_vac; ?></td>           
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