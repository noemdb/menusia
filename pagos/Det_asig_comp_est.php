<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
if (!$_GET){$cod_estructura='';}else{$cod_estructura=$_GET["cod_estructura"];}  $fecha_hoy=asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Detalles Asignacion Compromisos Estructura)</title>
<LINK  href="../class/sia.css" type=text/css rel=stylesheet>
</head>
<body>
<table width="845" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td align="left"><table width="840" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
		    <td width="222" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Codigo a la Estructura" onclick="javascript:LlamarURL('Inc_comp_est.php?cod_estructura=<?echo $cod_estructura?>')"></td>
            <td width="222" align="center">&nbsp;</td>
			<td width="215" align="center">&nbsp;</td>
            <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Codigos de la Orden"></td>
          </tr>
      </table></td>
    </tr>
   <tr height="5"> <td><p>&nbsp;</p></td></tr>
   <tr> <td>
<? 
$sql="SELECT pag037.cod_estructura,pag037.ced_rif_est,pag037.ref_comp_est,pag037.tipo_comp_est,pag037.monto_est,compromisos.ced_rif,compromisos.nombre,compromisos.nro_documento FROM pag037 left join compromisos on (pag037.ref_comp_est=compromisos.referencia_comp and pag037.tipo_comp_est=compromisos.tipo_compromiso ) where cod_estructura='$cod_estructura' order by ced_rif_est"; $res=pg_query($sql);
?>
 <table width="810" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="800">
       <table width="800"  border="1" cellspacing='0' cellpadding='0' align="left" id="ret_orden">
         <tr height="20" class="Estilo5">
           <td width="100"  align="left" bgcolor="#99CCFF"><strong>Cedula</strong></td>
           <td width="50" align="left" bgcolor="#99CCFF"><strong>Doc.Comp.</strong></td>
           <td width="80"  align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
           <td width="120" align="left" bgcolor="#99CCFF"><strong>Contrato</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
           <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
         </tr>
<? $total=0;
while($registro=pg_fetch_array($res))
{ $monto=formato_monto($registro["monto_est"]); $total=$total+$registro["monto_est"];  $nro_doc=$registro["nro_documento"]; $nombre=$registro["nombre"]; $ced_rif=$registro["ced_rif_est"];
?>
         <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Eliminar('<? echo $cod_estructura; ?>','<? echo $ced_rif; ?>');">
           <td width="100" align="left"><? echo $registro["ced_rif_est"]; ?></td>
           <td width="50" align="left"><? echo $registro["tipo_comp_est"]; ?></td>
           <td width="100" align="center"><? echo $registro["ref_comp_est"]; ?></td>
           <td width="100" align="left"><? echo $nro_doc; ?></td>
           <td width="300" align="left"><? echo $nombre; ?></td>
           <td width="120" align="right"><? echo $monto; ?></td>
         </tr>
         <? }
 $total=formato_monto($total);
?>
       </table></td>
   </tr>
   <tr> <td>&nbsp;</td> </tr>  <tr> <td>&nbsp;</td> </tr>
   <tr>
     <td><table width="800" border="0">
       <tr>
         <td width="500">&nbsp;</td>
         <td width="150" align="center"><span class="Estilo5">TOTAL :</span></td>
         <td><table width="150" border="1" cellspacing="0" cellpadding="0">
           <tr> <td width="123" align="right" class="Estilo5"><? echo $total; ?></td> </tr>
         </table></td>
       </tr>
     </table></td>
   </tr>
 </table>
 <p>&nbsp;</p>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">

function Llama_Eliminar(cod_est,cedula){var url; var r;
  r=confirm("Esta seguro en Eliminar la Cedula de la Estructura ?");
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Cedula de la Estructura ?");
    if (r==true) { url="Delete_asig_est.php?cod_estructura="+cod_est+"&cedula="+cedula;
	   document.location=url;
	   }    }
   else { url="Cancelado, no elimino"; }
}
</script>
<? pg_close(); ?>