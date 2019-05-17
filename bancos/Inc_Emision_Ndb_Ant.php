<?include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANCARIO (Emisi&oacute;n Notas de D&eacute;bitos Directa - Ordenes A&ntilde;os Anteriores)</title>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6"> INCLUIR   NOTA DE D&Eacute;BITO DIRECTA - ORDENES A&Ntilde;OS ANTERIORES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="528" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="522"><table width="92" height="513" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Emision_Ndb_Ant.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu
            href="Act_Emision_Ndb_Ant.php">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td height="439">&nbsp;</td>
      </tr>
    </table></td>
    <td width="890">       <div id="Layer1" style="position:absolute; width:860px; height:515px; z-index:1; top: 70px; left: 119px;">
      <form name="form1" method="post">
        <table width="856" height="83" border="0" >
          <tr>
            <td width="850" height="24"><table width="844" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="104"><span class="Estilo12"><span class="Estilo5">C&Oacute;DIGO BANCO</span> :</span></td>
                <td width="131"><div align="left"><span class="Estilo12"> <span class="Estilo5">
                <input name="txtCod_Banco" type="text" id="txtced_rif33" size="13" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)">
                </span> </span></div></td>
                <td width="286"><input name="btCat_Bancos" type="button" id="bttipo_orden3" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="..."></td>
                <td width="133"><span class="Estilo5">N&Uacute;MERO DE CUENTA :</span></td>
                <td width="157"><span class="Estilo5"><span class="Estilo12">
                  <input name="txtNro_Cuenta2" type="text" class="Estilo5" id="txtNro_Cuenta"  value="<?ECHO $Nro_Cuenta?>" size="25" maxlength="24" readonly>
                </span></span></td>
                <td width="33"><img src="../pagos/b_info.png" width="11" height="11"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="19"><table width="841" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="126"><span class="Estilo5">NOMBRE DEL BANCO : </span></td>
                  <td width="715"><span class="Estilo5"> <span class="Estilo12">
                    <input name="txtNombre_Banco" type="text" class="Estilo5" id="txtNombre_Banco"  value="<?ECHO $Nombre_Banco?>" size="130" maxlength="102" readonly>
                  </span> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="32"><table width="826">
              <tr>
                <td width="120" height="19"><span class="Estilo5">FECHA DE EMISI&Oacute;N :</span></td>
                <td width="397"><span class="Estilo5"><span class="Estilo12">
                  <input name="txtFecha" type="text" class="Estilo5" id="txtced_rif32"  onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="9">
                </span> </span></td>
                <td width="143"><span class="Estilo5">N&Uacute;MERO NOTA D&Eacute;BITO :</span></td>
                <td width="146"><span class="Estilo5"><span class="Estilo12">
                  <input name="txtReferencia" type="text" class="Estilo5" id="txtced_rif322"  onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="19">
                </span> </span></td>
              </tr>
            </table></td>
          </tr>
        </table>
        <table width="847" height="336" border="0" dwcopytype="CopyTableCell">
          <tr>
            <td height="19"><table width="203" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
              <tr>
                <td width="81"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                <td width="122"><span class="Estilo5"> <span class="Estilo12">
                  <input name="txtCed_Rif2" type="text" class="Estilo5" id="txtCed_Rif"  value="<?ECHO $Ced_Rif?>" size="15" maxlength="14" readonly>
                </span></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td width="885" height="19"><table width="830" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
              <tr>
                <td width="94"><span class="Estilo5">BENEFICIARIO : </span></td>
                <td width="736"><span class="Estilo5"> <span class="Estilo12">
                  <input name="txtBeneficiario2" type="text" class="Estilo5" id="txtBeneficiario2"  value="<?ECHO $Beneficiario?>" size="136" maxlength="127" readonly>
                </span> </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="847" height="72" border="0" dwcopytype="CopyTableRow">
              <tr>
                <td height="14"><strong><span class="Estilo14">CELDAS</span></strong></td>
              </tr>
              <tr>
                <td height="14"><table width="827" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="113"><span class="Estilo5">C&Oacute;DIGO CUENTA </span></td>
                      <td width="114"><span class="Estilo5">NOMBRE CUENTA </span></td>
                      <td width="96"><span class="Estilo5">DESCRIPCI&Oacute;N</span></td>
                      <td width="87"><span class="Estilo5">REFERENCIA</span></td>
                      <td width="41"><span class="Estilo5">D/C</span></td>
                      <td width="376"><span class="Estilo5">MONTO</span></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height="19"><table width="832" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="84" class="Estilo14">&nbsp;</td>
                      <td width="327"><span class="Estilo5"><span class="Estilo12">
</span></span></td>
                      <td width="50"><span class="Estilo5"><span class="Estilo17">TOTAL : </span></span></td>
                      <td width="371"><span class="Estilo5"><span class="Estilo12">
                        <input name="txtT_Creditos" type="text" class="Estilo5" id="txtT_Creditos" size="12" maxlength="11" readonly>
                      </span></span></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="847" height="142" border="0" dwcopytype="CopyTableRow">
              <tr>
                <td><strong><span class="Estilo5"><span class="Estilo10">EMISI&Oacute;N NOTA DE D&Eacute;BITO </span></span></strong></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><table width="710" height="170" border="1" align="center" cellpadding="0" cellspacing="2">
                    <tr>
                      <td width="12">&nbsp;</td>
                      <td width="671" valign="top"><table width="669" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="203"><span class="Estilo5">EMISI&Oacute;N NOTA DE D&Eacute;BITO DESDE :</span></td>
                            <td width="145"><span class="Estilo5"><span class="Estilo12">
                              <input name="txtReferencia_Desde" type="text" id="txtReferencia_Desde" size="10" maxlength="10" readonly>
                            </span> </span></td>
                            <td width="201"><span class="Estilo5">EMISI&Oacute;N NOTA DE D&Eacute;BITO DESDE :</span></td>
                            <td width="118"><span class="Estilo5"><span class="Estilo12">
                              <input name="txtReferencia_Hasta" type="text" id="txtReferencia_Hasta" size="10" maxlength="10" readonly>
                            </span> </span></td>
                          </tr>
                        </table>
                          <table width="670" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td width="238"><span class="Estilo5">CANTIDAD DE ORDENES SELECCIONADAS : </span></td>
                              <td width="218"><span class="Estilo12"><span class="Estilo5">
                                <input name="txtCant_Ord_Seleccionadas" type="text" id="txtCant_Ord_Seleccionadas" size="05" maxlength="10" readonly>
                              </span></span></td>
                              <td width="94"><span class="Estilo5">TOTAL NOTAS :</span></td>
                              <td width="117"><span class="Estilo12"><span class="Estilo5">
                                <input name="txtT_Notas" type="text" id="txtT_Notas" size="13" maxlength="12" readonly>
                              </span></span></td>
                            </tr>
                          </table>
                          <table width="668" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="183">&nbsp;</td>
                              <td width="62">&nbsp;</td>
                              <td width="422">&nbsp;</td>
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
                      <td width="11" height="166"><p>&nbsp;</p></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
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
    <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>    </td>
</tr>
</table>
</body>
</html>
