<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Incluir Plan de Cuentas)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript  src="../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function chequea_cuenta()
var f=document.form1;
    if(f.txtCodigo_Cuenta.value==""){alert("C&oacute;digo Cuenta no puede estar Vacio");return false;}
return true;}
</script>
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
var Valido;
    if(f.txtCodigo_Cuenta.value==""){alert("C&oacute;digo de Cuenta no puede estar Vacio");return false;}
    if(f.txtNombre_Cuenta.value==""){alert("Denominaci&oacute;n de Cuenta no puede estar Vacia"); return false; }
         else{f.txtNombre_Cuenta.value=f.txtNombre_Cuenta.value.toUpperCase();}
        if(f.txtTSaldo.value=="Deudor" || f.txtTSaldo.value=="Acreedor") {Valido=true;}
        else{alert("Tipo de Saldo no valida");return false; }
        if(f.txtClasificacion.value=="Nominal" || f.txtClasificacion.value=="Orden" || f.txtClasificacion.value=="Real" || f.txtClasificacion.value=="Valoracion") {Valido=true;}
        else{alert("Clasificaci&oacute;n de Cuenta no valida");return false; }
document.form1.submit;
return true;}
</script>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066" id="tablaencabezado">
  <tr>
    <td><div align="center"><span class="Estilo2 Estilo6">INCLUIR PLAN DE CUENTAS</span> </div></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick=mClk(this);
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu
            href="Act_plan_cuentas.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu
            href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:355px; z-index:1; top: 67px; left: 112px;">
      <form name="form1" method="post" action="Insert_plan_cuentas.php" onSubmit="return revisar()">
        <p>&nbsp;</p>
        <table width="859" height="136" border="0" id="tabcampos">
          <tr>
            <td> <blockquote>
                          </p>
                          <p class="Estilo5">C&Oacute;DIGO DE CUENTA :
                            <input name="txtCodigo_Cuenta" type="text" id="txtCodigo_Cuenta" title="Registre el C&oacute;digo de la Cuenta" onchange="javascript:chequea_cuenta();" size="30" maxlength="30" onFocus="encender(this); " onBlur="apagar(this);">
</p>
              </blockquote></td>
          </tr>
          <tr>
            <td><blockquote>
              <p align="left"><span class="Estilo5">DENOMINACI&Oacute;N  :</span>
                  <input name="txtNombre_Cuenta" type="text" id="txtNombre_Cuenta" title="Registre la denominaci&oacute;n de la Cuenta" size="105" maxlength="200"  onFocus="encender(this)" onBlur="apagar(this)">
              </p>
              </blockquote></td>
          </tr>
          <tr>
            <td><blockquote>
              <p class="Estilo5">CLASIFICACI&Oacute;N :
                <select name="txtClasificacion" size="1" id="select2" onFocus="encender(this)" onBlur="apagar(this)">
                  <option selected>Nominal</option>
                  <option>Orden</option>
                  <option>Real</option>
                  <option>Valoracion</option>
                </select>
</p>
            </blockquote> </td>
          </tr>
          <tr>
            <td><blockquote>
              <p class="Estilo5">TIPO DE SALDO :                <select name="txtTSaldo" size="1" id="txtTSaldo" onFocus="encender(this)" onBlur="apagar(this)">
                  <option>Deudor</option>
                  <option>Acreedor</option>
                </select>
</p>
                <p>&nbsp;</p>
              </blockquote></td>
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