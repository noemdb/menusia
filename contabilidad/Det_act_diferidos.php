<?include ("../class/conect.php");  include ("../class/funciones.php");
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];
if($fecha_d==""){$sfecha_d="2011-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}
if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD FISCAL (Detalles Actualiza Diferido)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">

<style type="text/css">
<!--
.Estilo16 {color: #003399; font-weight: bold; font-size: 18px; font-family: Arial; }
-->
</style>
</head>

<script language="JavaScript" type="text/JavaScript">

function Llama_Grabar(fechad,fechah){var murl; var r;
  r=confirm("Desea Grabar los Comprobantes diferedios seleccionados como Actualizados ?");
  if (r==true) { r=confirm("Esta Realmente seguro en Grabar los Comprobantes diferedios seleccionados como Actualizados ?");
    if (r==true) {  murl="Update_comp_diferido.php?fecha_d="+fechad+"&fecha_h="+fechah; document.location=murl;} }
}
function Llama_seleccionar(fechad,fechah,fecha,referencia,tipo){
var murl;
  if (referencia=="") {alert("Comprobante debe ser Seleccionada");}
  else{ murl="Sel_comp_dif.php?fechad="+fechad+"&fechah="+fechah+"&fecha="+fecha+"&tipo="+tipo+"&referencia="+referencia; document.location=murl;}
}
function Llama_Marcar_todos(fechad,fechah){var murl; var r;
  r=confirm("Desea Seleccionar Todos Comprobantes diferedios para Actualizar ?");
  if (r==true) { r=confirm("Esta Realmente seguro en Seleccionar Todos Comprobantes diferedios para Actualizar ?");
    if (r==true) { murl="Sel_todos_dif.php?fecha_d="+fechad+"&fecha_h="+fechah; document.location=murl; } }
}

function Llama_Desmarca_todos(fechad,fechah){var murl; var r;
  r=confirm("Desea Desmarcar Todos Comprobantes Seleccionado ?");
  if (r==true) {  murl="Des_todos_dif.php?fecha_d="+fechad+"&fecha_h="+fechah; document.location=murl; }
}
</script>
<body>
 <table width="904" border="0" cellspacing="0" cellpadding="0">
   <tr>
	  <td align="center" class="Estilo16">ACTUALIZAR COMPROBANTES DIFERIDOS</td>
	</tr>
	<tr>
	  <td>&nbsp;</td>
	</tr>
	<tr>
      <td align="left"><table width="1000" border="0" align="left">
          <tr>
            <td width="200" align="center" valign="middle"><input name="btgrabar" type="button" id="btgrabar" value="Grabar" title="Grabar los Comprobantes como Actualizado" onclick="JavaScript:Llama_Grabar('<?echo $fecha_d?>','<?echo $fecha_h?>')"></td>
            <td width="200" align="center"><input name="bttodos" type="button" id="bttodos" value="Todos" title="Seleccionar Todos los Comprobante" onClick="JavaScript:Llama_Marcar_todos('<?echo $fecha_d?>','<?echo $fecha_h?>')"></td>
            <td width="200" align="center"><input name="btdesmarca" type="button" id="btdesmarca" value="Desmarca" title="Deseleccionar Todos los Comprobante" onClick="JavaScript:Llama_Desmarca_todos('<?echo $fecha_d?>','<?echo $fecha_h?>')"></td>
            <td width="200" align="center" valign="middle"><input name="btmenu" type="button" id="btmenu" value="Volver al Menu" title="Retornar al Menu" onclick="javascript:LlamarURL('menu.php')"></td>
            <td width="200" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Comprobantes Diferidos"></td>
          </tr>
      </table></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	</tr>
   <tr>
     <td>
<?php 
$sql="SELECT * FROM cuentas_comp where text(fecha)>='$sfecha_d' and fecha<='$sfecha_h' order by fecha,referencia,tipo_asiento";
$sql="select con002.referencia,con002.fecha,con002.tipo_comp,con002.tipo_asiento,con002.status,con002.nro_expediente,con002.descripcion,con003.debito_credito,con003.cod_cuenta,con003.monto_asiento from con002,con003 where con002.referencia=con003.referencia and con002.fecha=con003.fecha and con002.tipo_comp=con003.tipo_comp and con002.fecha>='$sfecha_d' and con002.fecha<='$sfecha_h' and con003.debito_credito='D' and con002.status='D' order by con002.fecha,con002.referencia";
?>
       <table width="1000"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="20"  align="left" bgcolor="#99CCFF"><strong>Sel</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
		   <td width="40"  align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
           <td width="80" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
           <td width="700" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
         </tr>
         <? $t_debe=0; $t_haber=0; $prev_cod=""; $monto_asiento=0; $sel=""; $fec=""; $ref=""; $tipo=""; $desc=""; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $cod=$registro["referencia"].$registro["fecha"].$registro["tipo_asiento"]; 
if($prev_cod==""){$prev_cod=$cod; $monto_asiento=0; $ref=$registro["referencia"]; $fec=$registro["fecha"]; $tipo=$registro["tipo_asiento"]; $desc=$registro["descripcion"]; $sel=$registro["nro_expediente"];}

if($prev_cod<>$cod){ $monto_asiento=formato_monto($monto_asiento); $fec=formato_ddmmaaaa($fec); if($sel=="S"){$sel="*";}else{$sel="";}
?>
	 <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_seleccionar('<?echo $fecha_d?>','<?echo $fecha_h?>','<? echo $fec; ?>','<? echo $ref; ?>','<? echo $tipo; ?>');" >
	   <td width="40" align="left"><? echo $sel; ?></td>
	   <td width="100" align="left"><? echo $ref; ?></td>
	   <td width="100" align="center"><? echo $fec; ?></td>
	   <td width="50" align="center"><? echo $tipo; ?></td>
	   <td width="100" align="right"><? echo $monto_asiento; ?></td>
	   <td width="450" align="left"><? echo $desc; ?></td>
	 </tr>
<?  
   $prev_cod=$cod; $monto_asiento=0; $ref=$registro["referencia"]; $fec=$registro["fecha"]; $tipo=$registro["tipo_asiento"]; $desc=$registro["descripcion"]; $sel=$registro["nro_expediente"];}
   if ($registro["debito_credito"]=="D"){$monto_asiento=$monto_asiento+$registro["monto_asiento"];}
 } $monto_asiento=formato_monto($monto_asiento); if($fec==""){$fec="";} else{$fec=formato_ddmmaaaa($fec);} if($sel=="S"){$sel="*";}else{$sel="";} 
?>
     <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_seleccionar('<?echo $fecha_d?>','<?echo $fecha_h?>','<? echo $fec; ?>','<? echo $ref; ?>','<? echo $tipo; ?>');" >
	   <td width="40" align="left"><? echo $sel; ?></td>
	   <td width="100" align="left"><? echo $ref; ?></td>
	   <td width="100" align="center"><? echo $fec; ?></td>
	   <td width="50" align="center"><? echo $tipo; ?></td>
	   <td width="100" align="right"><? echo $monto_asiento; ?></td>
	   <td width="450" align="left"><? echo $desc; ?></td>
	 </tr>
       </table></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>   
 </table>
 <p>&nbsp;</p>
</body>
</html>
<?   pg_close(); ?>