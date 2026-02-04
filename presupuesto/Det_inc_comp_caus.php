<?php include ("../class/conect.php");  include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Comprobante del Causado)</title>
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
var Gcuenta = "";
var Gcodigo_mov = "";
var Gdebito_credito="";
function enviar(codigo_mov,debito_credito,cuenta) {Gcodigo_mov=codigo_mov; Gdebito_credito=debito_credito; Gcuenta=cuenta;}
function Llama_Inc_Codigos(mcodigo_mov,dcmov){var mmonto; var mdebe; var mhaber;  mmonto=0;   
  mdebe=quitaformatomonto(document.form1.txtdebe.value); mdebe=(mdebe*1);  mhaber=quitaformatomonto(document.form1.txthaber.value); mhaber=(mhaber*1);
  if(dcmov=="D"){mmonto=mdebe-mhaber;}else{mmonto=mhaber-mdebe;} if(mmonto<0){mmonto=0;} 
  LlamarURL('Inc_cuenta_comp.php?codigo_mov=<?php echo $codigo_mov?>&monto='+mmonto+'&dcmov='+dcmov);
}
function Llama_Eliminar(){var murl;var r;
  if (Gcuenta=="") {alert("Cuenta debe ser Seleccionada");}
  else { murl="Esta seguro en Eliminar la Cuenta:"+Gcuenta+" del comprobante ?"; r=confirm(murl);
  if (r==true) {r=confirm("Esta Realmente seguro en Eliminar la Cuenta del comprobante ?");
    if (r==true) { murl="Delete_cuenta_comp.php?codigo_mov="+Gcodigo_mov+"&debito_credito="+Gdebito_credito+"&cod_cuenta="+Gcuenta;
          document.location=murl;}
    }   else { url="Cancelado, no elimino"; }
  }
}
function Llama_Modificar(){var murl;
  if (Gcuenta=="") {alert("Cuenta debe ser Seleccionada");}
  else { murl="Mod_cuenta_comp.php?codigo_mov="+Gcodigo_mov+"&debito_credito="+Gdebito_credito+"&cod_cuenta="+Gcuenta;
    document.location=murl;}
}
function Llama_Cargar_Codigos(mcodigo_mov){var murl; murl="Carg_comp_caus.php?codigo_mov="+mcodigo_mov;  document.location=murl;}
</script>
</head>
<body>
<?php
if (!$_GET){$codigo_mov='';} else{$codigo_mov=$_GET["codigo_mov"];}if(substr($codigo_mov,0,6)=="PRE007"){$MProc="A";}else{$MProc="P";};
?>
 <table width="904" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td><table width="861" border="0" align="left">
       <tr>
         <td width="222" align="center"><input name="btAgregar" type="button" id="btAgregar" value="Agregar" title="Agregar Cuentas al Comprobante" onclick="javascript:Llama_Inc_Codigos('<?php echo $codigo_mov?>','D')"></td>
         <td width="255" align="center"><input name="btModificar" type="button" id="btModificar" value="Modificar" title="Modificar Cuenta del Comprobante" onClick="JavaScript:Llama_Modificar()"></td>
         <td width="215" align="center"><input name="btEliminar" type="button" id="btEliminar" value="Eliminar" title="Eliminar Cuenta del Comprobante" onClick="JavaScript:Llama_Eliminar()"></td>
      <?php  if($MProc=='A'){?>
          <td width="215" align="center"><input name="btCargarCod" type="button" id="btCargarCod" value="Cargar C&oacute;digos del Causado" title="Cargar C&oacute;digos Contables del Causado al Comprobante" onClick="JavaScript:Llama_Cargar_Codigos('<?php echo $codigo_mov?>')"></td>
      <?php }else{?>
          <td width="215" align="center"><input name="btCargarCod" type="button" id="btCargarCod" value="Cargar C&oacute;digos del Pago" title="Cargar C&oacute;digos Contables del Pago al Comprobante" onClick="JavaScript:Llama_Cargar_Codigos('<?php echo $codigo_mov?>')"></td>
      <?php }?>
         <td width="215" align="center"><input name="btRefrescar" type="button" id="btRefrescar" onClick="JavaScript:self.location.reload();" value="Refrescar" title="Refrescar las Cuentas del Comprobante"></td>
       </tr>
     </table></td>
   </tr>
   <tr><td>&nbsp;</td></tr>
   <tr>
     <td>
<?php
$sql="SELECT * FROM CUENTAS_CON008  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
?>
          <table width="900"  border="1" cellspacing='0' cellpadding='0' align="left" id="ctas_comprobante">
            <tr height="20" class="Estilo5">
              <td width="50"  align="left" bgcolor="#99CCFF"><strong>Cuenta</strong></td>
              <td width="200" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
              <td width="10" align="center" bgcolor="#99CCFF"><strong>D/C</strong></td>
              <td width="80" align="right" bgcolor="#99CCFF" ><strong>Monto </strong></td>
              <td width="480" align="left" bgcolor="#99CCFF"><strong>Descripcion Asiento</strong></td>
              <td width="10" align="center" bgcolor="#99CCFF"><strong>Mod.</strong></td>
            </tr>
            <?php  $t_debe=0; $t_haber=0;$balance=0;
while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);
  if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}
  IF ($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
?>
            <tr bgcolor='#FFFFFF' bordercolor='#000000' height="20" class="Estilo5" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onMouseOut="this.style.backgroundColor='#FFFFFF'"o"];" onDblClick="javascript:enviar('<?php  echo $codigo_mov; ?>','<?php  echo $registro["debito_credito"]; ?>','<?php  echo $registro["cod_cuenta"]; ?>');">
              <td width="80" height="20" align="left"><?php  echo $registro["cod_cuenta"]; ?></td>
              <td width="230" align="left"><?php  echo $registro["nombre_cuenta"]; ?></td>
              <td width="10" align="center"><?php  echo $registro["debito_credito"]; ?></td>
              <td width="80" align="right"><?php  echo $monto_asiento; ?></td>
              <td width="480" align="left"><?php  echo $registro["descripcion_a"]; ?></td>
              <td width="10" align="center"><?php  echo $registro["modificable"]; ?></td>
            </tr>
            <?php }
 $t_debe=formato_monto($t_debe); $t_haber=formato_monto($t_haber); $balance=formato_monto($balance);
?>
        </table></td>
    </tr>
        <tr height="10">
          <td>&nbsp;</td>
    </tr>
        <tr>
      <td> <form name="form1">

        <table width="817" border="0">
          <tr>
            <td width="88"><span class="Estilo5">TOTAL DEBE  :</span></td>
            <td width="163"><table width="151" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right" class="Estilo5"><?php  echo $t_debe; ?></td>
              </tr>
            </table></td>
            <td width="92"><span class="Estilo5">TOTAL HABER :</span></td>
            <td width="163"><table width="151" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right" class="Estilo5"><?php  echo $t_haber; ?></td>
              </tr>
            </table></td>
            <td width="84"><span class="Estilo5">BALANCE :</span></td>
            <td width="201"><table width="151" border="1" cellspacing="0" cellpadding="0">
              <tr>
                <td align="right" class="Estilo5"><?php  echo $balance; ?></td>
              </tr>
            </table></td>
			<td width="5"><input name="txtdebe" type="hidden" id="txtdebe" value="<?php echo $t_debe;?>"></td>
            <td width="5"><input name="txthaber" type="hidden" id="txthaber" value="<?php echo $t_haber;?>"></td>
          </tr>
        </table>   </form>   </td>
    </tr>
  </table>
 <p>&nbsp;</p>
</body>
</html>
<?php   pg_close($conn);?>