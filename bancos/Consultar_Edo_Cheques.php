<?include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL BANCARIO (Estados de Cheues)</title>
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
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> CONSULTAR - ESTADO DE CHEQUES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="989" height="396" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="390" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Edo_Cheques.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu
            href="Act_Edo_Cheques.php">Atras</a></div></td>
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
      <div id="Layer1" style="position:absolute; width:874px; height:354px; z-index:1; top: 72px; left: 116px;">
        <form name="form1" method="post">
          <table width="856" height="293" border="0" dwcopytype="CopyTableCell" >
            <tr>
              <td width="850" height="24"><table width="862" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="105" height="22"><span class="Estilo12"><span class="Estilo5">C&Oacute;DIGO BANCO</span> :</span></td>
                  <td width="103"><span class="Estilo12"> <span class="Estilo5">
                    <input name="txtCod_Banco" type="text" class="Estilo5" id="txtCod_Banco4"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="14">
                  </span></span></td>
                  <td width="288"><span class="Estilo12"><span class="Estilo5"> </span><span class="Estilo5">
                    <input name="btCat_Bancos" type="button" id="btCat_Bancos" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                  </span> </span></td>
                  <td width="128"><span class="Estilo12"><span class="Estilo5">N&Uacute;MERO DE CUENTA </span> :</span></td>
                  <td width="187"><div align="left"><span class="Estilo12"> <span class="Estilo5">
                      <input name="txtNro_Cuenta" type="text" class="Estilo5" id="txtNro_Cuenta3"  value="<?echo $Nro_Cuenta?>" size="25" maxlength="24" readonly>
                  </span></span></div></td>
                  <td width="35"><img src="b_info.png" width="11" height="11"></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="24"><table width="859" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="130"><span class="Estilo5">NOMBRE DEL BANCO : </span></td>
                    <td width="713"><span class="Estilo5"> <span class="Estilo12">
                      <input name="txtNombre_Banco" type="text" class="Estilo5" id="txtNombre_Banco3"  value="<?echo $Nombre_Banco?>" size="126" maxlength="125" readonly>
                    </span></span></td>
                    <td width="16">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="14"><table width="842" height="13" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="131"><span class="Estilo5">N&Uacute;MERO DE CHEQUE :</span></td>
                    <td width="151"><span class="Estilo12"><span class="Estilo5">
                      <input name="txtNro_Cheque" type="text" class="Estilo5" id="txtNro_Cheque2"  value="<?echo $Nro_Cheque?>" size="15" maxlength="14" readonly>
                    </span></span></td>
                    <td width="120"><span class="Estilo5">FECHA DE EMISI&Oacute;N :</span></td>
                    <td width="157"><span class="Estilo12"><span class="Estilo5">
                      <input name="txtFecha" type="text" class="Estilo5" id="txtFecha2"  value="<?echo $Fecha?>" size="10" maxlength="09" readonly>
                    </span></span></td>
                    <td width="125"><span class="Estilo5">N&Uacute;MERO DE ORDEN :</span></td>
                    <td width="158"><span class="Estilo12"><span class="Estilo5">
                      <input name="txtNro_Orden" type="text" class="Estilo5" id="txtNro_Orden2"  value="<?echo $Nro_Orden?>" size="15" maxlength="14" readonly>
                    </span></span></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="14"><table width="306" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="142"><span class="Estilo5">C&Eacute;D/RIF BENEFICIARIO:</span></td>
                  <td width="164"><span class="Estilo5"><span class="Estilo12">
                    <input name="txtCed_Rif2" type="text" class="Estilo5" id="txtCed_Rif4"  onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="14">
                  </span> </span></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td height="14"><table width="860" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableColumn">
                  <tr>
                    <td width="63"><span class="Estilo5">NOMBRE :</span></td>
                    <td width="797"><span class="Estilo5"> <span class="Estilo12">
                      <input name="txtBeneficiario2" type="text" class="Estilo5" id="txtBeneficiario2"  value="<?echo $Beneficiario?>" size="139" maxlength="135" readonly>
                    </span></span></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="19"><table width="842" height="13" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="129"><span class="Estilo5">MONTO DEL CHEQUE :</span></td>
                    <td width="211"><span class="Estilo12"><span class="Estilo5">
                      <input name="txtMonto_Cheque" type="text" class="Estilo5" id="txtMonto_Cheque2"  value="<?echo $Monto_Cheque?>" size="15" maxlength="14" readonly>
                    </span></span></td>
                    <td width="63"><span class="Estilo5">ESTADO :</span></td>
                    <td width="180"><span class="Estilo12"><span class="Estilo5">
                      <input name="txtEdo_Cheque" type="text" class="Estilo5" id="txtEdo_Cheque3"  value="<?echo $Edo_Cheque?>" size="10" maxlength="09" readonly>
                    </span></span></td>
                    <td width="122"><span class="Estilo5">FECHA DE ANULADO :</span></td>
                    <td width="137"><span class="Estilo12"><span class="Estilo5">
                      <input name="txtFecha_Anulado" type="text" class="Estilo5" id="txtFecha_Anulado2"  value="<?echo $Fecha_Anulado?>" size="10" maxlength="10" readonly>
                    </span></span></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="14"><table width="860" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="80"><span class="Estilo5">CONCEPTO :</span></td>
                    <td width="756"><span class="Estilo5"><span class="Estilo12">
                      <textarea name="txtConcepto" cols="84" readonly="readonly" id="textarea"><?echo $Concepto?></textarea>
                    </span> </span></td>
                    <td width="24">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="14"><table width="862" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="149"><span class="Estilo5">RECIBIDO POR CED/RIF :</span></td>
                    <td width="417"><span class="Estilo5"><span class="Estilo12">
                      <input name="txtCed_Rif" type="text" class="Estilo5" id="txtCed_Rif3"  value="<?echo $Ced_Rif?>" size="15" maxlength="14" readonly>
                    </span> </span></td>
                    <td width="137"><span class="Estilo5">FECHA DE ENTREGADO : </span></td>
                    <td width="159"><span class="Estilo5"><span class="Estilo12">
                      <input name="txtFecha_Entregado" type="text" class="Estilo5" id="txtFecha_Entregado"  value="<?echo $Fecha_Entregado?>" size="10" maxlength="09" readonly>
                    </span> </span></td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td height="14"><table width="860" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="137"><span class="Estilo5">NOMBRE DE RECIBIDO :</span></td>
                    <td width="590"><span class="Estilo5"><span class="Estilo12">
                      <input name="txtBeneficiario" type="text" class="Estilo5" id="txtBeneficiario3"  value="<?echo $Beneficiario?>" size="123" maxlength="122" readonly>
                    </span> </span></td>
                    <td width="133">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </table>
          <p>&nbsp;</p>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>

