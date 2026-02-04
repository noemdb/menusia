<?include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Incluir Tipos de Orden)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language=JavaScript src="../class/sia.js" type=text/javascript></script>
<script language="Javascript" type="text/Javascript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
    if(f.txttipo_orden.value==""){alert("Tipo de Orden no puede estar Vacio");return false;}
    if(f.txtdes_tipo_orden.value==""){alert("Descripción Tipo de Orden no puede estar Vacia");return false; }
       else{f.txtdes_tipo_orden.value=f.txtdes_tipo_orden.value.toUpperCase();}
    if(f.txttipo_orden.value.length==4){f.txttipo_orden.value=f.txttipo_orden.value.toUpperCase();}
       else{alert("Longitud Tipo de Orden Invalida");return false;}
    if(f.txtcod_contable.value==""){alert("Código Contable no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>
<script language="JavaScript" type="text/JavaScript">
function LlamarURL(url){  document.location = url; }
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_orden.value;   mref = Rellenarizq(mref,"0",4);   mform.txttipo_orden.value=mref; return true;}
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR TIPOS DE ORDEN </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="397" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="395" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_tipos_orden.pho')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_tipos_orden.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
          <div id="Layer1" style="position:absolute; width:872px; height:346px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Insert_tipo_orden.php" onSubmit="return revisar()">
        <table width="867" height="188" border="0" align="center" >
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="844" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="163"><span class="Estilo5">C&Oacute;DIGO TIPO DE ORDEN:</span></td>
                  <td width="121"><div align="left"><span class="Estilo5">
                      <input class="Estilo10" name="txttipo_orden" type="text" id="txttipo_orden" size="8" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_tipo(this.form);">
                  </span></div></td>
                  <td width="204">&nbsp;</td>
                  <td width="356"><span class="Estilo5"> </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="848" height="20" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="190"><span class="Estilo5">DESCRIPCI&Oacute;N TIPO DE ORDEN:</span></td>
                  <td width="634"><span class="Estilo5"> <input class="Estilo10" name="txtdes_tipo_orden" type="text" id="txtdes_tipo_orden"  onFocus="encender(this)" onBlur="apagar(this)" size="100">
                  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="843" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="135"><span class="Estilo5">C&Oacute;DIGO CONTABLE :</span></td>
                  <td width="188"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta"  onFocus="encender(this)" onBlur="apagar(this)" size="25">
                  </span></td>
                  <td width="50"><div align="left"><span class="Estilo5">
                    <input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Cuentas"  onClick="VentanaCentrada('../contabilidad/Cat_cuentas_cargables.php?criterio=','SIA','','750','500','true')" value="...">
                  </span></div></td>
                  <td width="470"><span class="Estilo5">
                    <input class="Estilo10" name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta"  readonly  size="70">
                  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td width="883" height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"><table width="843" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="135"><span class="Estilo5">C&Oacute;DIGO DE BANCO :</span></td>
                  <td width="88"><div align="left"><span class="Estilo5">
                      <input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco"  onFocus="encender(this)" onBlur="apagar(this)"size="8" maxlength="15">
                  </span></div></td>
                 <td width="50"><div align="left"><span class="Estilo5">
                    <input class="Estilo10" name="btcuentas" type="button" id="btcuentas" title="Abrir Catalogo C&oacute;digo de Bancos"  onClick="VentanaCentrada('Cat_bancos.php?criterio=','SIA','','750','500','true')" value="...">
                  </span></div></td>
                  <td width="570"><span class="Estilo5">
                    <input class="Estilo10" name="txtnombre_banco" type="text" id="txtnombre_banco"  readonly size="80">
                  </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
          <tr>
            <td height="24"><table width="843" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="135" height="22"><span class="Estilo5">GENERA TRIBUTO :</span></td>
                  <td width="354"><span class="Estilo5">
                    <select name="txtgen_tributo" size="1" id="txtgen_tributo" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>NO</option>
                      <option>SI</option>
                    </select>
                  </span></td>
                  <td width="354"><input class="Estilo10" name="txtnro_cuenta" type="hidden" id="txtnro_cuenta"></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td height="14">&nbsp;</td>
          </tr>
        </table>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input  name="Grabar" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
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