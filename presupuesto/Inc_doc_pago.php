<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Incluir Documentos Pagos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
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
    if(f.txtdoc_pago.value==""){alert("Código de Documento Pago no puede estar Vacio");return false;}
        if(f.txtdoc_pago.value.charAt(0)=='A'){alert("Documento de Pago no valido");return false;}
    if(f.txtnombre_doc_pago.value==""){alert("Nombre del Documento Pago no puede estar Vacio");return false; }
       else{f.txtnombre_doc_pago.value=f.txtnombre_doc_pago.value.toUpperCase();}
    if(f.txtnombre_abrev.value==""){alert("Nombre Abreviado del Documento Pago no puede estar Vacio");return false; }
       else{f.txtnombre_abrev.value=f.txtnombre_abrev.value.toUpperCase();}
        if(f.txtRefierea.value=="COMPROMISO" || f.txtRefierea.value=="CAUSADO" || f.txtRefierea.value=="NINGUNO") {Valido=true;}
        else{alert("Valor de Refiere a no valido");return false; }
        if(f.TxtAfecta.value=="SI" || f.TxtAfecta.value=="NO") {Valido=true;}
        else{alert("Valor de Afecta Presupuesto no valido");return false; }
    if(f.txtdoc_pago.value.length==4){f.txtdoc_pago.value=f.txtdoc_pago.value.toUpperCase();}
       else{alert("Longitud Código de Documento Pago Invalida");return false;}
document.form1.submit;
return true;}
</script>
<script language="JavaScript" type="text/JavaScript">
function LlamarURL(url){  document.location = url; }
function chequea_tipo(mform){
var mref;
   mref=mform.txtdoc_pago.value;
   mref = Rellenarizq(mref,"0",4);
   mform.txtdoc_pago.value=mref;
return true;}
</script>
</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">DOCUMENTOS PAGOS (Incluir)</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_doc_pago.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_doc_pago.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:355px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Insert_doc_pago.php" onSubmit="return revisar()">
        <p>&nbsp;</p>
        <table width="859" height="111" border="0" id="tabcampos">
          <tr>
            <td height="45" colspan="3" valign="middle"><blockquote class="Estilo5">C&Oacute;DIGO :
                            <input name="txtdoc_pago" type="text" id="txtdoc_pago" title="Registre el código del documento pago" onchange="chequea_tipo(this.form);" size="10" maxlength="4" onFocus="encender(this); " onBlur="apagar(this);">
</blockquote></td>
          </tr>
          <tr>
            <td height="45" colspan="3" valign="middle"><blockquote>
              <p align="left"><span class="Estilo5">NOMBRE DEL DOCUMENTO  :</span>
                <input name="txtnombre_doc_pago" type="text" id="txtnombre_doc_pago" title="Registre el Nombre del Documento Pago" size="80" maxlength="70"  onFocus="encender(this)" onBlur="apagar(this)">
              </p>
            </blockquote></td>
          </tr>
          <tr>
            <td width="393" height="45" valign="middle"><blockquote>
              <p><span class="Estilo5">NOMBRE ABREVIADO DOCUMENTO :</span>
                  <input name="txtnombre_abrev" type="text" id="txtnombre_abrev" title="Registre el Nombre Abreviado del Documento Pago" size="8" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)">
              </p>
              </blockquote></td>
            <td width="231" valign="middle"><span class="Estilo5">REFIERE A   :
                <select name="txtRefierea" size="1" id="txtRefierea" onFocus="encender(this)" onBlur="apagar(this)">
                  <option>COMPROMISO</option>
                  <option>CAUSADO</option>
                  <option>NINGUNO</option>
                </select>
            </span></td>
            <td width="221" valign="middle"><span class="Estilo5">AFECTA PRESUPUESTO  :
                <select name="TxtAfecta" size="1" id="TxtAfecta" onFocus="encender(this)" onBlur="apagar(this)">
                  <option>SI</option>
                  <option>NO</option>
                </select>
            </span></td>
          </tr>
          <tr>
            <td height="55" colspan="3" valign="top">&nbsp;</td>
          </tr>
        </table>
        <div align="center">
          <p>&nbsp;</p>
          </div>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        <div align="right"></div>
        <div align="right"></div>
        <p>&nbsp;</p>
        </form>
    </div>

  </tr>
</table>
</body>
</html>