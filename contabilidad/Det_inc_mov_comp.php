<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA (Detalles Cuentas del Comprobante)</title>
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function Llama_Eliminar(codigo_mov,nro_linea,cuenta){var murl; var r;
  if (cuenta=="") {alert("Cuenta debe ser Seleccionada");}
  else { murl="Esta seguro en Eliminar la Cuenta:"+cuenta+" del Movimiento ?";  r=confirm(murl);
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Cuenta del Movimiento ?");
    if (r==true) { murl="Delete_cuenta_mov.php?codigo_mov="+codigo_mov+"&nro_linea="+nro_linea+"&cod_cuenta="+cuenta;   document.location=murl;}    }
   else { url="Cancelado, no elimino"; }
  }
}
</script>
</head>
<body>
<form name="form1" method="post" action="">
  <table width="1150" border="0">
    <tr>
      <td align="left"><table width="870" border="0" align="left">
          <tr>
            <td width="175" align="center" valign="middle"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Cuenta Contable al Comprobante" onclick="javascript:LlamarURL('Inc_contab_mov.php?codigo_mov=<?echo $codigo_mov?>')"></td>
            <td width="175" align="center"><input name="btBancos" type="button" id="btBancos" value="Bancos" title="Agregar Mov. Banco al Comprobante" onClick="javascript:LlamarURL('Inc_banco_mov.php?codigo_mov=<?echo $codigo_mov?>')"></td>
            <td width="175" align="center"><input name="btEgreso" type="button" id="btEgreso" value="Egreso" title="Agregar Mov. Presupuesto de Egreso al Comprobante" onClick="JavaScript:LlamarURL('Inc_egreso_mov.php?codigo_mov=<?echo $codigo_mov?>')"></td>
			<td width="175" align="center"><input name="btIngreso" type="button" id="btIngreso" value="Ingreso" title="Agregar Mov. Presupuesto de Ingreso al Comprobante" onClick="JavaScript:LlamarURL('Inc_ingreso_mov.php?codigo_mov=<?echo $codigo_mov?>')"></td>
		    <td width="175" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar los Movimientos del Comprobante"></td>
          </tr>
      </table></td>
    </tr>
    <tr height="10">
      <td>
        <p>&nbsp;</p></td>
    </tr>
    <tr>
      <td><?php
if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}
$sql="SELECT * FROM CON017  where codigo_mov='$codigo_mov' order by nro_linea";$res=pg_query($sql);
?>
          <table width="1150"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
            <tr height="20" class="Estilo5">
              <td width="50"  align="left" bgcolor="#99CCFF"><strong>Modulo</strong></td>
              <td width="150"  align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
              <td width="270" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
			  <td width="80" align="center" bgcolor="#99CCFF"><strong>Referencia</strong></td>
              <td width="40" align="center" bgcolor="#99CCFF"><strong>Tipo</strong></td>
              <td width="80" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
              <td width="480" align="left" bgcolor="#99CCFF"><strong>Descripcion Asiento</strong></td>              
            </tr>
            <? $t_debe=0; $t_haber=0;$balance=0;
while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);
  if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}
  if ($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;} $des_modulo="";
  $tipo=$registro["tipo_asiento"]; if($registro["modulo"]=="C"){$tipo=$registro["debito_credito"]; $des_modulo="CONTAB";}
   if($registro["modulo"]=="B"){$des_modulo="BANCOS";} if($registro["modulo"]=="E"){$des_modulo="EGRESO";} if($registro["modulo"]=="I"){$des_modulo="INGRESO";}
  
?>
            <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:Llama_Eliminar('<? echo $codigo_mov; ?>','<? echo $registro["nro_linea"]; ?>','<? echo $registro["cod_cuenta"]; ?>');">
              <td width="50" height="20" align="left"><? echo $des_modulo; ?></td>
              <td width="150" height="20" align="left"><? echo $registro["cod_cuenta"]; ?></td>
              <td width="270" align="left"><? echo $registro["nombre_cta"]; ?></td>
			  <td width="80" align="center"><? echo $registro["referencia"]; ?></td>
              <td width="40" align="center"><? echo $tipo; ?></td>
              <td width="80" align="right"><? echo $monto_asiento; ?></td>
              <td width="480" align="left"><? echo $registro["descripcion_a"]; ?></td>
             
            </tr>
    <?} $t_debe=formato_monto($t_debe); $t_haber=formato_monto($t_haber); $balance=formato_monto($balance);
?>
        </table></td>
    </tr>
        <tr height="10">
          <td>&nbsp;</td>
    </tr>
        <tr>
      <td>
        <table width="817" border="0">
          <tr>
            <td width="88"><span class="Estilo5">TOTAL DEBE  :</span></td>
            <td width="163"><table width="151" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right" class="Estilo5"><? echo $t_debe; ?></td>
              </tr>
            </table></td>
            <td width="92"><span class="Estilo5">TOTAL HABER :</span></td>
            <td width="163"><table width="151" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right" class="Estilo5"><? echo $t_haber; ?></td>
              </tr>
            </table></td>
            <td width="84"><span class="Estilo5">BALANCE :</span></td>
            <td width="201"><table width="151" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right" class="Estilo5"><? echo $balance; ?></td>
              </tr>
            </table></td>
          </tr>
        </table>      </td>
    </tr>
  </table>
</form>
 <p>&nbsp;</p>
</body>
</html>
<?  pg_close();?>