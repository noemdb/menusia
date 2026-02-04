<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Incluir Fuentes de Financiamiento)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type="text/javascript"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function LlamarURL(url){  document.location = url; }
function revisar(){var f=document.form1;var Valido;
    if(f.txtCodigo_Fuente.value==""){alert("COdigo de Fuente no puede estar Vacio");return false;}
    if(f.txtNombre_Fuente.value==""){alert("Denominación de Fuente no puede estar Vacia"); return false; }
       else{f.txtNombre_Fuente.value=f.txtNombre_Fuente.value.toUpperCase();} 
    if(f.txtCodigo_Fuente.value.length==2){f.txtCodigo_Fuente.value=f.txtCodigo_Fuente.value.toUpperCase();}
       else{alert("Longitud COdigo de Fuente Invalida");return false;}      
document.form1.submit;
return true;}
function chequea_codigo(mform){var mref;
   mref=mform.txtCodigo_Fuente.value;   mref = Rellenarizq(mref,"0",2);   mform.txtCodigo_Fuente.value=mref;
return true;}
</script>

</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066" id="tablaencabezado">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR FUENTES DE FINANCIAMIENTO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_fuentes.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_fuentes.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:335px; z-index:1; top: 67px; left: 112px;">
      <form name="form1" method="post" action="Insert_fuente.php" onSubmit="return revisar()">
        <table width="865" border="0">
          <tr>
            <td><table width="825" height="235" border="0" align="center" id="tabcampos">
               <tr> <td>&nbsp;</td>  </tr>
               <tr> <td>&nbsp;</td>  </tr>
              <tr>
                <td><table width="800" border="0">
                  <tr>
                    <td width="148"><span class="Estilo5">C&Oacute;DIGO DE FUENTE :</span></td>
                    <td width="650"><span class="Estilo5">
                      <input name="txtCodigo_Fuente" type="text" id="txtCodigo_Fuente" title="Registre el Codigo de la Fuente" size="10" maxlength="2"  onchange="chequea_codigo(this.form);" onFocus="encender(this); " onBlur="apagar(this);">
                    </span></td>
                  </tr>
                </table></td>
              </tr>
               <tr> <td>&nbsp;</td>  </tr>
              <tr>
                <td>
                  <table width="816" border="0">
                    <tr>
                      <td width="148"><span class="Estilo5">DENOMINACI&Oacute;N :</span></td>
                      <td width="666"><input name="txtNombre_Fuente" type="text" id="txtNombre_Fuente" title="Registre la denominacion de la Fuente" size="100" maxlength="200"  onFocus="encender(this)" onBlur="apagar(this)"></td>
                    </tr>
                  </table>                  </td>
              </tr>

               <tr> <td>&nbsp;</td>  </tr>
               <tr> <td>&nbsp;</td>  </tr>
            </table>
            </td>
          </tr>
        </table>
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input name="btgrabar" type="submit" id="btgrabar"  value="Grabar"></td>
            <td width="88"><input name="btblanquear" type="reset" value="Blanquear"></td>
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