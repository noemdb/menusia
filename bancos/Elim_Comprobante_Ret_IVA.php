<?include ("../class/seguridad.inc");?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Comprobante Retenci&oacute;n del IVA)</title>
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
.Estilo14 {font-size: 10px; color: #FF0000; }
.Estilo17 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">ELIMINAR COMPROBANTE  RETECI&Oacute;N DEL IVA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="354" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="348"><table width="93" height="344" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td width="85""];" height="35"  bgcolor=#EAEAEA onClick="javascript:LlamarURL('Act_Comprobante_Ret_IVA.php')" onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
          onMouseOut="this.style.backgroundColor='#EAEAEA'";o><div align="center"><a class=menu
            href="Act_Comprobante_Ret_IVA.php">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu_p.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="890">       <div id="Layer1" style="position:absolute; width:868px; height:227px; z-index:1; top: 69px; left: 114px;">
      <form name="form1" method="post">
        <table width="853" height="102" border="0">
          <tr>
            <td height="16">&nbsp;</td>
          </tr>
          <tr>
            <td width="885" height="16"><table width="850">
              <tr>
                <td width="131" height="19"><span class="Estilo5">PERIODO FISCAL A&Ntilde;O:</span></td>
                <td width="87"><span class="Estilo5"><span class="Estilo12">
                  <input name="txtTipo_Cuenta2222" type="text" class="Estilo5" id="txtTipo_Cuenta22222"  onFocus="encender(this)" onBlur="apagar(this)" size="11" maxlength="10">
                </span></span></td>
                <td width="36"><span class="Estilo5">MES :</span></td>
                <td width="93"><span class="Estilo5"><span class="Estilo12">
                  <input name="txtTipo_Cuenta2232" type="text" class="Estilo5" id="txtTipo_Cuenta2232"  onFocus="encender(this)" onBlur="apagar(this)" size="11" maxlength="10">
                </span></span></td>
                <td width="149"><span class="Estilo5">N&Uacute;MERO COMPROBANTE :</span></td>
                <td width="95"><span class="Estilo5"><span class="Estilo12">
                  <input name="txtTipo_Cuenta2242" type="text" class="Estilo5" id="txtTipo_Cuenta2242"  onFocus="encender(this)" onBlur="apagar(this)" size="11" maxlength="10">
                </span></span></td>
                <td width="113"><span class="Estilo5">FDECHA EMISI&Oacute;N :</span></td>
                <td width="107"><span class="Estilo5"><span class="Estilo12">
                  <input name="txtTipo_Cuenta2252" type="text" class="Estilo5" id="txtTipo_Cuenta2252"  onFocus="encender(this)" onBlur="apagar(this)" size="11" maxlength="10">
                </span></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="724" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="66"><span class="Estilo5">C&Eacute;D/RIF :</span></td>
                <td width="109"><span class="Estilo5"> <span class="Estilo12">
                  <input name="txtcodigo_titulo525" type="text" class="Estilo5" id="txtcodigo_titulo525"  value="<?echo $codigo_titulo?>" size="15" maxlength="15" readonly>
                </span></span></td>
                <td width="149">&nbsp;</td>
                <td width="400"><span class="Estilo5"> <span class="Estilo12"> </span> </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="847" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
              <tr>
                <td width="63"><span class="Estilo5">NOMBRE :</span></td>
                <td width="784"><span class="Estilo5"> <span class="Estilo12">
                  <input name="txtcodigo_titulo6" type="text" class="Estilo5" id="txtcodigo_titulo5"  value="<?echo $codigo_titulo?>" size="147" maxlength="10" readonly>
                </span> </span></td>
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
    </div>      <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
    </td>
</tr>
</table>
</body>
</html>
