<?php include ("../class/fun_fechas.php"); include ("../class/ventana.php");
if (!$_GET){$cod_banco='';$tipo_mov='';$referencia='';}  else{$cod_banco=$_GET["cod_banco"];$tipo_mov=$_GET["tipo_mov"];$referencia=$_GET["referencia"];}
$fecha_hoy=asigna_fecha_hoy(); $url="Act_Mov_Libros.php?Gcod_banco=C".$cod_banco.$referencia.$tipo_mov;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Anular Movimientos en Libros)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefecha(mform){var mref; var mfec;
  mref=mform.txtfecha_anu.value;
  if(mform.txtfecha_anu.value.length==8){mfec=mref.substring(0,6)+ "20" + mref.charAt(6)+mref.charAt(7);  mform.txtfecha_anu.value=mfec;}
return true;}
function revisar(){ var f=document.form1;var r;
var Valido=true;
    if(f.txtfecha_anu.value==""){alert("Fecha no puede estar Vacia");return false;}
    if(f.txtdescrip_anu.value==""){alert("Descripcion de Anulaci�n no puede estar Vacia"); return false; }  else{f.txtdescrip_anu.value=f.txtdescrip_anu.value.toUpperCase();}
    if(f.txtCodigo_Cuenta.value==""){alert("Codigo de Cuenta no puede estar Vacia"); return false; }  else{f.txtdescrip_anu.value=f.txtdescrip_anu.value.toUpperCase();}
    if(f.txtfecha_anu.value.length==10){Valido=true;}  else{alert("Longitud de Fecha Invalida");return false;}
    r=confirm("Esta seguro en Anular el Movimiento ?");
    if (r==true) {r=confirm("Esta Realmente seguro en Anular el Movimiento ?");
    if (r==true) {Valido=true;} else {return false;}  }
document.form1.submit;
return true;}
</script>
<style type="text/css">
<!--
.Estilo9 {font-size: 16px;  font-weight: bold; color: #FFFFFF;}
-->
</style>
</head>

<body>
<form name="form1" method="post" action="Rev_nota_deb.php" onSubmit="return revisar()">
  <table width="714" height="70" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="707" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="31" align="center" bgcolor="#000066"><span class="Estilo9">ANULAR MOVIMIENTO EN LIBRO (NOTA DEBITO)</span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="680" border="0" align="center">
              <tr>
                <td width="180"><span class="Estilo5">FECHA DE ANULACI&Oacute;N: </span></td>
                <td width="500"><span class="Estilo5"><input class="Estilo10" name="txtfecha_anu" type="text" id="txtfecha_anu" size="15" value="<?php echo $fecha_hoy?>"  onchange="checkrefecha(this.form)" onFocus="encender(this)" onBlur="apagar(this)"  >
                </span> </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="680" border="0" align="center">
                  <tr>
                    <td width="180"><span class="Estilo5">CONCEPTO DE ANULACI&Oacute;N  : </span></td>
                    <td width="500"><span class="Estilo5"><textarea name="txtdescrip_anu" cols="65" rows="2" onFocus="encender(this)" onBlur="apagar(this)"  id="txtdescrip_anu"></textarea>   </span></td>
                  </tr>
              </table></td>
          </tr>
		  <tr> <td>&nbsp;</td></tr>
			<tr>
			  <td><table width="680" border="0" align="center">
				<tr>
				  <td width="250"><span class="Estilo5">C&Oacute;DIGO CONTABLE DE ANULACION :</span></td>
				  <td width="250"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta"  size="30" maxlength="32" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
				  <td width="180"><input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onClick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
				</tr>
			  </table></td>
			</tr>
			<tr> <td>&nbsp;</td></tr>
			<tr>
			  <td><table width="680" border="0" align="center">
				<tr>
				  <td width="200"><span class="Estilo5">NOMBRE C&Oacute;DIGO CONTABLE :</span></td>
				  <td width="480"><span class="Estilo5"><input class="Estilo10" name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta"  size="70" maxlength="80" readonly> </span></td>
				</tr>
			  </table></td>
			</tr>
			<tr> <td>&nbsp;</td></tr>
          <tr>
          <td><table width="680" border="0" align="center"> <tr>
            <td width="40"><input name="txtcod_banco" type="hidden" id="txtcod_banco" value="<?php echo $cod_banco?>"></td>
            <td width="40"><input name="txttipo_movimiento" type="hidden" id="txttipo_movimiento" value="<?php echo $tipo_mov?>"></td>
            <td width="40"><input name="txtreferencia" type="hidden" id="txtreferencia" value="<?php echo $referencia?>"></td>
          </tr></table></td>
          </tr>
          <tr>
            <td><span class="Estilo5"> </span>                </td>
          </tr>
          <tr>
            <td><table width="660" align="center">
              <tr>
                <td width="182">&nbsp;</td>
                <td width="127" align="center" valign="middle"><input name="Anular" type="submit" id="Anular"  value="Anular"></td>
                <td width="10" align="center">&nbsp;</td>
                <td width="136" align="center"><input name="Cancelar" type="button" id="Cancelar" value="Cancelar" onClick="JavaScript:document.location ='<?php  echo $url; ?>';"></td>
                <td width="181">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr> <td><p>&nbsp;</p></tr>
        </table>
          </td>
    </tr>
  </table>
</form>
</body>
</html>