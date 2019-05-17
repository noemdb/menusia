<?include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANCARIO (Emisi&oacute;n Notas de D&eacute;bitos a Orden)</title>
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
        {alert("Código de Cuenta debe ser Seleccionada");}
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
.Estilo13 {color: #0000FF}
.Estilo10 {	font-size: 12px;
	font-weight: bold;
	color: #0000FF;
}
.Estilo14 {font-size: 10px; color: #0000FF; }
.Estilo17 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> INCLUIR - EMISI&Oacute;N  NOTA DE D&Eacute;BITO A ORDEN </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="677" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="618"><table width="92" height="660" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Emision_NotaDebito.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu
            href="Act_Emision_NotaDebito.php">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="890">       <div id="Layer1" style="position:absolute; width:860px; height:604px; z-index:1; top: 70px; left: 115px;">
      <form name="form1" method="post">
        <table width="856" height="140" border="0" >
          <tr>
            <td width="850"><table width="848" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="123"><span class="Estilo12"><span class="Estilo5">DOCUMENTO PAGO </span> :</span></td>
                <td width="70"><span class="Estilo12"> <span class="Estilo5">
                  <input name="txtcod_titulo" type="text" id="txtcod_titulo2" size="5" maxlength="4"  value="<?echo $cod_pago?>" readonly>
                </span></span></td>
                <td width="49"><input name="bttipo_orden22" type="button" id="bttipo_orden2" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="..."></td>
                <td width="299"><span class="Estilo12"><span class="Estilo5">
                  <input name="txtcod_titulo2" type="text" id="txtcod_titulo22" size="10" maxlength="10"  value="<?echo $doc_pago?>" readonly>
                </span><span class="Estilo5"> </span> </span></td>
                <td width="108"><span class="Estilo12"><span class="Estilo5">C&Oacute;DIGO BANCO</span> :</span></td>
                <td width="120"><div align="left"><span class="Estilo12"> <span class="Estilo5">
                    <input name="txtced_rif3" type="text" id="txtced_rif33" size="13" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)">
                </span> </span></div></td>
                <td width="40"><input name="bttipo_orden2" type="button" id="bttipo_orden3" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="..."></td>
                <td width="37"><img src="../pagos/b_info.png" width="11" height="11"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="840" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                <tr>
                  <td width="134"><span class="Estilo5">N&Uacute;MERO DE CUENTA :</span></td>
                  <td width="706"><div align="left"><span class="Estilo5"> <span class="Estilo12">
                      <input name="txttipo_benef2" type="text" class="Estilo5" id="txttipo_benef24"  value="<?ECHO $num_cuenta?>" size="25" maxlength="24" readonly>
                  </span> </span></div></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="841" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="132"><span class="Estilo5">NOMBRE DEL BANCO : </span></td>
                  <td width="709"><span class="Estilo5"> <span class="Estilo12">
                    <input name="txttipo_benef" type="text" class="Estilo5" id="txttipo_benef"  value="<?ECHO $nom_banco?>" size="121" maxlength="102" readonly>
                  </span> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="849">
                <tr>
                  <td width="124" height="24"><span class="Estilo5">FECHA DE EMISI&Oacute;N :</span></td>
                  <td width="88"><span class="Estilo5"><span class="Estilo12">
                    <input name="txtced_rif322" type="text" class="Estilo5" id="txtced_rif32"  onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="9">
                  </span> </span></td>
                  <td width="91"><span class="Estilo5">NOTA D&Eacute;BITO :</span></td>
                  <td width="86"><span class="Estilo5"><span class="Estilo12">
                    <input name="txtced_rif323" type="text" class="Estilo5" id="txtced_rif322"  onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="9">
                  </span> </span></td>
                  <td width="150"><span class="Estilo5">FECHA ORDENES DESDE :</span></td>
                  <td width="64"><span class="Estilo5"><span class="Estilo12">
                    <input name="txtced_rif324" type="text" class="Estilo5" id="txtced_rif323"  onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="9">
                  </span></span></td>
                  <td width="51"><span class="Estilo5">HASTA :</span></td>
                  <td width="159"><span class="Estilo5"><span class="Estilo12">
                    <input name="txtced_rif325" type="text" class="Estilo5" id="txtced_rif324"  onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="9">
                  </span></span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="24"><table width="839" height="28" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="14">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td width="283" height="14"><strong><span class="Estilo5"><span class="Estilo10">INFORMACI&Oacute;N DE CHEQUES</span></span></strong></td>
                  <td width="287"><span class="Estilo5"> <span class="Estilo12"> </span> </span></td>
                </tr>
            </table></td>
          </tr>
        </table>
        <table width="847" height="142" border="0" dwcopytype="CopyTableCell">
          <tr>
            <td width="885">&nbsp;</td>
          </tr>
          <tr>
            <td><table width="203" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
                <tr>
                  <td width="88"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                  <td width="115"><span class="Estilo5"> <span class="Estilo12">
                    <input name="txttipo_benef3333" type="text" class="Estilo5" id="txttipo_benef3334"  value="<?ECHO $ced_rif?>" size="15" maxlength="14" readonly>
                  </span></span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="830" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
                <tr>
                  <td width="95"><span class="Estilo5">BENEFICIARIO : </span></td>
                  <td width="735"><span class="Estilo5"> <span class="Estilo12">
                    <input name="txttipo_benef33422" type="text" class="Estilo5" id="txttipo_benef33422"  value="<?ECHO $nom_benf?>" size="128" maxlength="116" readonly>
                  </span> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="847" height="94" border="0" dwcopytype="CopyTableCell">
                <tr>
                  <td height="14"><strong><span class="Estilo14">CELDAS</span></strong></td>
                </tr>
                <tr>
                  <td height="19"><table width="827" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="75"><span class="Estilo5">NRO. ORDEN </span></td>
                        <td width="42"><span class="Estilo5">FECHA</span></td>
                        <td width="86"><span class="Estilo5">DESCRIPCI&Oacute;N</span></td>
                        <td width="21">&nbsp;</td>
                        <td width="408"><span class="Estilo5">MONTO</span></td>
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
            </table></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><table width="847" height="142" border="0" dwcopytype="CopyTableCell">
                <tr>
                  <td><strong><span class="Estilo5"><span class="Estilo10">EMISI&Oacute;N NOTA DE D&Eacute;BITO </span></span></strong></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><table width="645" height="170" border="1" align="center" cellpadding="0" cellspacing="2">
                    <tr>
                      <td width="12">&nbsp;</td>
                      <td width="604" valign="top"><table width="594" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="202"><span class="Estilo5">EMISI&Oacute;N NOTA DE D&Eacute;BITO DESDE :</span></td>
                            <td width="97"><span class="Estilo5"><span class="Estilo12">
                              <input name="txtReferencia_Desde" type="text" id="txtReferencia_Desde" size="10" maxlength="10" readonly>
                            </span> </span></td>
                            <td width="203"><span class="Estilo5">EMISI&Oacute;N NOTA DE D&Eacute;BITO DESDE </span>:</td>
                            <td width="92"><span class="Estilo5"><span class="Estilo12">
                              <input name="txtReferencia_Hasta" type="text" id="txtReferencia_Hasta" size="10" maxlength="10" readonly>
                            </span> </span></td>
                          </tr>
                        </table>
                          <table width="598" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="245"><span class="Estilo5">CANTIDAD DE ORDENES SELECCIONADAS : </span></td>
                              <td width="160"><span class="Estilo12"><span class="Estilo5">
                                <input name="txtCant_Ord_Seleccionadas" type="text" id="txtCant_Ord_Seleccionadas" size="05" maxlength="10" readonly>
                              </span></span></td>
                              <td width="97"><span class="Estilo5">TOTAL NOTAS :</span></td>
                              <td width="96"><span class="Estilo12"><span class="Estilo5">
                                <input name="txtT_Notas" type="text" id="txtT_Notas" size="15" maxlength="10" readonly>
                              </span></span></td>
                            </tr>
                          </table>
                          <table width="598" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="182">&nbsp;</td>
                              <td width="59">&nbsp;</td>
                              <td width="357">&nbsp;</td>
                            </tr>
                            <tr>
                              <td><span class="Estilo5">IPRIMIR NOTAS DE D&Eacute;BITOS :</span></td>
                              <td><span class="Estilo12"> SI
                                    <input name="radioImp_Si" type="radio" class="Estilo5" value="radioImp_Si">
                              </span></td>
                              <td><span class="Estilo12">NO
                                    <input name="radioImp_No" type="radio" value="radioImp_No">
                              </span></td>
                            </tr>
                          </table>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p></td>
                      <td width="13" height="166"><p>&nbsp;</p></td>
                    </tr>
                  </table></td>
                </tr>
            </table></td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </form>
      </div>
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>    </td>
</tr>
</table>
</body>
</html>
