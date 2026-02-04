<?php include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Emisi&oacute;n Notas de D&eacute;bitos Directa)</title>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6"> INCLUIR - EMISI&Oacute;N  NOTA DE D&Eacute;BITO DIRECTA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="532" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="526"><table width="92" height="523" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Emision_Ndb_Dir.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu
            href="Act_Emision_Ndb_Dir.php">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="890">       <div id="Layer1" style="position:absolute; width:860px; height:500px; z-index:1; top: 70px; left: 115px;">
      <form name="form1" method="post">
        <table width="856" height="126" border="0" >
          <tr>
            <td width="850"><table width="848" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="119"><span class="Estilo12"><span class="Estilo5">DOCUMENTO PAGO </span> :</span></td>
                <td width="51"><span class="Estilo12"> <span class="Estilo5">
                  <input name="txtTipo_Pago" type="text" id="txtcod_titulo2" size="5" maxlength="4"  value="<?php echo $Tipo_Pago?>" readonly>
                </span></span></td>
                <td width="351"><span class="Estilo12"><span class="Estilo5">
                  <input name="txtNombre_Abrev" type="text" id="txtcod_titulo22" size="10" maxlength="10"  value="<?php echo $Nombre_Abrev?>" readonly>
                </span><span class="Estilo5"> </span> </span></td>
                <td width="114"><span class="Estilo12"><span class="Estilo5">C&Oacute;DIGO BANCO</span> :</span></td>
                <td width="127"><div align="left"><span class="Estilo12"> <span class="Estilo5">
                    <input name="txtCod_Banco" type="text" id="txtced_rif33" size="13" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)">
                </span> </span></div></td>
                <td width="42"><input name="btCat_Bancos" type="button" id="bttipo_orden3" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="..."></td>
                <td width="42"><img src="../pagos/b_info.png" width="11" height="11"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="840" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                <tr>
                  <td width="134"><span class="Estilo5">N&Uacute;MERO DE CUENTA :</span></td>
                  <td width="706"><div align="left"><span class="Estilo5"> <span class="Estilo12">
                      <input name="txtNro_Cuenta" type="text" class="Estilo5" id="txttipo_benef24"  value="<?php ECHO $Nro_Cuenta?>" size="25" maxlength="24" readonly>
                  </span> </span></div></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="841" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="132"><span class="Estilo5">NOMBRE DEL BANCO : </span></td>
                  <td width="709"><span class="Estilo5"> <span class="Estilo12">
                    <input name="txtNombre_Banco" type="text" class="Estilo5" id="txtNombre_Banco"  value="<?php ECHO $Nombre_Banco?>" size="121" maxlength="102" readonly>
                  </span> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="32"><table width="826">
                <tr>
                  <td width="126" height="19"><span class="Estilo5">FECHA DE EMISI&Oacute;N :</span></td>
                  <td width="347"><span class="Estilo5"><span class="Estilo12">
                    <input name="txtFecha" type="text" class="Estilo5" id="txtced_rif32"  onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="9">
                  </span> </span></td>
                  <td width="147"><span class="Estilo5">N&Uacute;MERO NOTA D&Eacute;BITO :</span></td>
                  <td width="186"><span class="Estilo5"><span class="Estilo12">
                    <input name="txtReferencia" type="text" class="Estilo5" id="txtced_rif322"  onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="19">
                  </span> </span></td>
                  </tr>
            </table></td>
          </tr>
        </table>
        <table width="847" height="338" border="0" dwcopytype="CopyTableCell">
          <tr>
            <td width="885" height="21"><table width="401" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
                <tr>
                  <td width="88"><span class="Estilo5">C&Eacute;DULA/RIF :</span></td>
                  <td width="98"><span class="Estilo5"> <span class="Estilo12">
                    <input name="txtCed_Rif" type="text" class="Estilo5" id="txttipo_benef3334"  value="<?php ECHO $Ced_Rif?>" size="15" maxlength="14" readonly>
                  </span></span></td>
                  <td width="215"><span class="Estilo5">
                    <input name="btCat_Benef" type="button" id="btCat_Benef" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="...">
                  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="830" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
                <tr>
                  <td width="95"><span class="Estilo5">BENEFICIARIO : </span></td>
                  <td width="735"><span class="Estilo5"> <span class="Estilo12">
                    <input name="txtBeneficiario" type="text" class="Estilo5" id="txtBeneficiario"  value="<?php ECHO $Beneficiario?>" size="128" maxlength="127" readonly>
                  </span> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="284"><table width="862" height="119" border="0" dwcopytype="CopyTableCell">
                <tr>
                  <td width="892" height="14"><table width="830" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
                    <tr>
                      <td width="173"><span class="Estilo5">DESCRIPCI&Oacute;N NOTA D&Eacute;BITO  : </span></td>
                      <td width="657"><span class="Estilo5"> <span class="Estilo12">
                        <textarea name="txtDescripcion" cols="93" class="Estilo5" id="textarea2" onFocus="encender(this)" onBlur="apagar(this)"></textarea>
                      </span> </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="840" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="106"><span class="Estilo5"><span class="Estilo12">TIPO DE GASTO :</span></span></td>
                      <td width="285"><span class="Estilo5"><span class="Estilo12">
                        <select name="selectTipo_Gasto" class="Estilo5" id="selectTipo_Gasto">
                          <option>FUNCINAMIENTO</option>
                          <option>INVERSI&Oacute;N</option>
                          <option>FUNCIONA/INVER</option>
                        </select>
                      </span></span></td>
                      <td width="217"><span class="Estilo5"><span class="Estilo12">IMPUTACI&Oacute;N PRESUPUESTARIA :</span></span></td>
                      <td width="232"><span class="Estilo5"><span class="Estilo12">
                        <select name="selectTipo_Imputacion" class="Estilo5" id="selectTipo_Imputacion">
                          <option>PRESUPUESTO</option>
                          <option>CR&Eacute;DITO ADICIONAL</option>
                        </select>
                      </span></span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="856" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="226"><span class="Estilo5"><span class="Estilo12">REFERENCIA CR&Eacute;DITO ADICIONAL  :</span></span></td>
                      <td width="105"><span class="Estilo5"><span class="Estilo12">
                        <input name="txtRef_Imput_Presu" type="text" class="Estilo5" id="txtRef_Imput_Presu"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15">
                      </span></span></td>
                      <td width="89"><span class="Estilo5">
                      <input name="btCat_Credito" type="button" id="btCat_Credito3" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="...">
</span></td>
                      <td width="187"><span class="Estilo5"><span class="Estilo12">C&Oacute;DIGO PRESUPUESTARIO :</span></span></td>
                      <td width="168"><span class="Estilo5"><span class="Estilo12">
                        <input name="txtCod_Pre" type="text" class="Estilo5" id="txtCod_Pre"  onFocus="encender(this)" onBlur="apagar(this)" size="27" maxlength="26">
                      </span></span></td>
                      <td width="81"><span class="Estilo5">
                        <input name="btCat_Codigos" type="button" id="bttipo_orden22" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="...">
                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="856" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="82"><span class="Estilo5"><span class="Estilo12">FUENTE  :</span></span></td>
                      <td width="101"><span class="Estilo5"><span class="Estilo12">
                        <input name="txtFuente_Financ" type="text" class="Estilo5" id="txtFuente_Financ"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15">
                      </span></span></td>
                      <td width="265"><span class="Estilo5">
                        <input name="btFuente_Financ" type="button" id="btCat_Credito" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIPAP','','750','500','true')" value="...">
                      </span></td>
                      <td width="159"><span class="Estilo5"><span class="Estilo12">MONTO NOTA D&Eacute;BITO :</span></span></td>
                      <td width="168"><span class="Estilo5"><span class="Estilo12">
                        <input name="txtMonto_Movimiento" type="text" class="Estilo5" id="txtMonto_Movimiento"  onFocus="encender(this)" onBlur="apagar(this)" size="27" maxlength="26">
                      </span></span></td>
                      <td width="81"><span class="Estilo5">                      </span></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="841" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="189"><span class="Estilo5"><span class="Estilo12">DESCRIPCI&Oacute;N DEL C&Oacute;DIGO :</span></span></td>
                      <td width="652"><span class="Estilo5"><span class="Estilo12">
                        <textarea name="textDes_Codigo" cols="93" readonly="readonly" class="Estilo5" id="textDes_Codigo"><?php ECHO $Des_Codigo?></textarea>
                      </span></span></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14"><table width="847" height="94" border="0" dwcopytype="CopyTableRow">
                    <tr>
                      <td height="14"><strong><span class="Estilo14">CELDAS</span></strong></td>
                    </tr>
                    <tr>
                      <td height="19"><table width="827" border="0" cellspacing="0" cellpadding="0">
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
                      <td height="19"><table width="605" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="62"><span class="Estilo5"><span class="Estilo17">D&Eacute;BITOS</span></span></td>
                            <td width="247"><span class="Estilo5"><span class="Estilo12">
                              <input name="txtT_Debitos" type="text" class="Estilo5" id="txtcedula3325242222222233" size="12" maxlength="11" readonly>
                            </span></span></td>
                            <td width="70"><span class="Estilo5"><span class="Estilo17">CR&Eacute;DITOS</span></span></td>
                            <td width="226"><span class="Estilo5"><span class="Estilo12">
                              <input name="txtT_Creditos" type="text" class="Estilo5" id="txtcedula33252422222222322" size="12" maxlength="11" readonly>
                            </span></span></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="19">&nbsp;</td>
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
