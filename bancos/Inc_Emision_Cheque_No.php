<?php include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Emisi&oacute;n de Cheques)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Ventana(url)
{
var murl;
var Gcodigo_cuenta=document.form1.txtCodigo_Cuenta.value;
    murl=url+Gcodigo_cuenta;
    if (Gcodigo_cuenta=="")
        {alert("C�digo de Cuenta debe ser Seleccionada");}
        else {document.location = murl;}
}
function Mover_Registro(MPos)
{
var murl;
   murl="Act_cuentas.php";
   if(MPos=="P"){murl="Act_cuentas.php?Gcodigo_cuenta=P"}
   if(MPos=="U"){murl="Act_cuentas.php?Gcodigo_cuenta=U"}
   if(MPos=="S"){murl="Act_cuentas.php?Gcodigo_cuenta=S"+document.form1.txtCodigo_Cuenta.value;}
   if(MPos=="A"){murl="Act_cuentas.php?Gcodigo_cuenta=A"+document.form1.txtCodigo_Cuenta.value;}
   document.location = murl;
}
function Llama_Eliminar(){
var url;
var r;
  if (document.form1.txtCargable.value=="CARGABLE"){
  r=confirm("Esta seguro en Eliminar la Cuenta ?");
  if (r==true) {
    r=confirm("Esta Realmente seguro en Eliminar la Cuenta ?");
    if (r==true) {
       url="Delete_cuentas.php?txtCodigo_Cuenta="+document.form1.txtCodigo_Cuenta.value;
       VentanaCentrada(url,'Eliminar Plan Cuentas','','400','400','true');}
    }
   else { url="Cancelado, no elimino"; }
  }
  else { alert("CUENTA NO ES CARGABLE, NO PUEDE SER ELIMINADA"); }
}
</script>
<SCRIPT language=JavaScript
src="../class/sia.js"
type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
}
.Estilo9 {font-size: 8pt}
.Estilo12 {font-size: 12px}
.Estilo14 {font-size: 10px; color: #0000FF; }
.Estilo15 {font-size: 12px; font-weight: bold; }
.Estilo17 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR - EMISI&Oacute;N DE CHEQUES FINANCIERO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="481" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="475"><table width="92" height="469" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Emision_Cheque_No.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu
            href="Act_Emision_Cheque_No.php">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:867px; height:454px; z-index:1; top: 70px; left: 115px;">
        <form name="form1" method="post">
          <table width="856" height="140" border="0" dwcopytype="CopyTableCell" >
            <tr>
              <td width="850"><table width="848" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="123"><span class="Estilo12"><span class="Estilo5">DOCUMENTO PAGO </span> :</span></td>
                    <td width="71"><span class="Estilo12"> <span class="Estilo5">
                      <input name="txtTipo_Pago" type="text" id="txtcod_titulo2" size="5" maxlength="4"  value="<?php echo $Tipo_Pago?>" readonly>
                    </span></span></td>
                    <td width="347"><span class="Estilo12"><span class="Estilo5">
                      <input name="txtNombre_Abrev" type="text" id="txtcod_titulo22" size="10" maxlength="10"  value="<?php echo $Nombre_Abrev?>" readonly>
                    </span><span class="Estilo5"> </span> </span></td>
                    <td width="108"><span class="Estilo12"><span class="Estilo5">C&Oacute;DIGO BANCO</span> :</span></td>
                    <td width="120"><div align="left"><span class="Estilo12"> <span class="Estilo5">
                        <input name="txtCod_Banco" type="text" id="txtced_rif33" size="13" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)">
                    </span> </span></div></td>
                    <td width="40"><input name="bttipo_orden2" type="button" id="bttipo_orden3" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                    <td width="37"><img src="../pagos/b_info.png" width="11" height="11"></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="841" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="132"><span class="Estilo5">NOMBRE DEL BANCO : </span></td>
                    <td width="709"><span class="Estilo5"> <span class="Estilo12">
                      <input name="txtNombre_Banco" type="text" class="Estilo5" id="txttipo_benef2"  value="<?php ECHO $Nombre_Banco?>" size="128" maxlength="127" readonly>
                    </span> </span></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="840" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                  <tr>
                    <td width="134"><span class="Estilo5">N&Uacute;MERO DE CUENTA :</span></td>
                    <td width="706"><div align="left"><span class="Estilo5"> <span class="Estilo12">
                        <input name="txtNro_Cuenta" type="text" class="Estilo5" id="txttipo_benef3"  value="<?php ECHO $Nro_Cuenta?>" size="25" maxlength="24" readonly>
                    </span> </span></div></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td><table width="841">
                  <tr>
                    <td width="126" height="24"><span class="Estilo5">FECHA DE EMISI&Oacute;N :</span></td>
                    <td width="437"><span class="Estilo5"><span class="Estilo12">
                      <input name="txtFecha" type="text" class="Estilo5" id="txtced_rif326"  onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="9">
                    </span> </span></td>
                    <td width="128"><span class="Estilo5">N&Uacute;MERO DE CHEQUE :</span></td>
                    <td width="130"><span class="Estilo5"><span class="Estilo12">
                      <input name="txtNro_Cheque" type="text" class="Estilo5" id="txtNro_Cheque"  onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="9">
                    </span> </span></td>
                  </tr>
              </table></td>
            </tr>
          </table>
          <table width="847" height="114" border="0" dwcopytype="CopyTableCell">
                <tr>
                  <td width="885"><table width="344" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="82"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                        <td width="127"><span class="Estilo5"> <span class="Estilo12">
                        <input name="txtced_rif" type="text" class="Estilo5" id="txtced_rif3232"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="14">
                        </span></span></td>
                        <td width="135"><input name="bttipo_orden" type="button" id="bttipo_orden" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><table width="830" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="95"><span class="Estilo5">BENEFICIARIO :</span></td>
                      <td width="735"><span class="Estilo5"> <span class="Estilo12">
                        <input name="txtBeneficiario" type="text" class="Estilo5" id="txttipo_benef334"  value="<?php ECHO $Beneficiario?>" size="136" maxlength="116" readonly>
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="839" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                    <tr>
                      <td width="96"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></td>
                      <td width="743"><span class="Estilo5"> <span class="Estilo12">
                        <textarea name="txtDescripcion" cols="84" class="Estilo5" id="textarea3" onFocus="encender(this)" onBlur="apagar(this)"></textarea>
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="19"><table width="410" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="132"><span class="Estilo5">MONTO DEL CHEQUE : </span></td>
                      <td width="278"><span class="Estilo5"><span class="Estilo12">
                        <input name="txtMonto_Cheque" type="text" class="Estilo5" id="txtced_rif3233"  onFocus="encender(this)" onBlur="apagar(this)" size="19" maxlength="18">
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="19"><strong><span class="Estilo14">CELDAS</span></strong></td>
                </tr>
                <tr>
                  <td height="19"><table width="827" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="70"><span class="Estilo5">CODIGO </span></td>
                      <td width="103"><span class="Estilo5">NOMBRE CUENTA </span></td>
                      <td width="88"><span class="Estilo5">REFERENCIA</span></td>
                      <td width="51"><span class="Estilo5">D/C</span></td>
                      <td width="320"><span class="Estilo5">MONTO</span></td>
                      <td width="195">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="19"><table width="605" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="97"><span class="Estilo5"><span class="Estilo17">D&Eacute;BITOS</span></span></td>
                      <td width="212"><span class="Estilo5"><span class="Estilo12">
                        <input name="txtcedula3325242222222233" type="text" class="Estilo5" id="txtcedula33252422222222334" size="12" maxlength="15" readonly>
                      </span></span></td>
                      <td width="90"><span class="Estilo5"><span class="Estilo17">CR&Eacute;DITOS</span></span></td>
                      <td width="206"><span class="Estilo5"><span class="Estilo12">
                        <input name="txtcedula33252422222222322" type="text" class="Estilo5" id="txtcedula332524222222223225" size="12" maxlength="15" readonly>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="19">&nbsp;</td>
                </tr>
          </table>
              <p>&nbsp;</p>
        </form>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
      </div>
    </td>
</tr>
</table>
</body>
</html>
