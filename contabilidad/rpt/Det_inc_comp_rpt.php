<?include ("../../class/conect.php");  include ("../../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<script language="JavaScript" type="text/JavaScript">
function Llama_Eliminar(codigo_mov,mref,mfecha,mtipo){var murl; var r;
  if (mref=="") {alert("Comprobante debe ser Seleccionada");}
  else { murl="Esta seguro en Eliminar el Comprobante de la lista ?";  r=confirm(murl);
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar el Comprobante de la lista ?");
    if (r==true) { murl="Delete_comp_rpt.php?codigo_mov="+codigo_mov+"&referencia="+mref+"&fecha="+mfecha+"&tipo="+mtipo;   document.location=murl;}    }
   else { url="Cancelado, no elimino"; }
  }
}
</script>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Detalles Movimientos Reporte)</title>
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
</head>
<body>
 <table width="420" border="0" cellspacing="0" cellpadding="0">   
   <tr>
     <td><table width="400" border="0" cellspacing="0" cellpadding="0">
	   <tr>
		 <td  width="130" align="center"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Comprobante" onclick="javascript:LlamarURL('Inc_comp_rpt.php?codigo_mov=<?echo $codigo_mov?>')"></td>
		 <td  width="140" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar el Comprobante"> </span></td>
	     <td  width="130" align="center"><input name="btCerrar" type="button" id="btCerrar" value="Cerrar" title="Cerrar Ventana" onclick="javascript:window.close()"></td>
		 
	   </tr>
	   <tr>
		 <td >&nbsp;</td>
	   </tr>
     </table></td>
	</tr>
   <tr> 
     <td>
<?php $total=0; if (!$_GET){$codigo_mov='';} else{ $codigo_mov=$_GET["codigo_mov"];}
$sql="SELECT * FROM con018 where codigo_mov='$codigo_mov' order by fecha,referencia,tipo_asiento";$res=pg_query($sql);
?>
       <table width="400"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
         <tr height="20" class="Estilo5">
           <td width="150"  align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
           <td width="150" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
		   <td width="100" align="left" bgcolor="#99CCFF"><strong>Tipo Asiento</strong></td>
         </tr>
         <? 
while($registro=pg_fetch_array($res)){$fecha=$registro["fecha"];  $fecha=formato_ddmmaaaa($fecha); 
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Eliminar('<? echo $codigo_mov; ?>','<? echo $registro["referencia"]; ?>','<? echo $registro["fecha"]; ?>','<? echo $registro["tipo_asiento"]; ?>');" >
           <td width="150" align="left"><? echo $registro["referencia"]; ?></td>
           <td width="150" align="left"><? echo $fecha; ?></td>
		   <td width="100" align="left"><? echo $registro["tipo_asiento"]; ?></td>  
         </tr>
         <?} 
?>
       </table></td>
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