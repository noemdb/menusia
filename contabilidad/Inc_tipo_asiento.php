<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD FINANCIERA (Incluir Tipos de Asientos)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK  href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript  src="../class/sia.js" type=text/javascript></SCRIPT>
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
    if(f.txtTipo_Asiento.value==""){alert("Tipo de Asiento no puede estar Vacio");return false;}
    if(f.txtDes_Tipo_Asi.value==""){alert("Descripcion de Asiento no puede estar Vacia");return false; }
       else{f.txtDes_Tipo_Asi.value=f.txtDes_Tipo_Asi.value.toUpperCase();}
    if(f.txtTipo_Asiento.value.length==3){f.txtTipo_Asiento.value=f.txtTipo_Asiento.value.toUpperCase();}
      else{alert("Longitud Tipo de Asiento Invalida");return false;}
document.form1.submit;
return true;}
</script>
<script language="JavaScript" type="text/JavaScript">
function chequea_tipo()
var f=document.form1;
    if(f.txtTipo_Asiento.value==""){alert("Tipo de Asiento no puede estar Vacio");return false;}
document.form1.submit;
return true;}
</script>

</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR TIPOS DE ASIENTOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick=mClk(this);
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu
            href="Act_tipo_asiento.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu
            href="menu.php">Menu Principal</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:355px; z-index:1; top: 65px; left: 112px;">
      <form name="form1" method="post" action="Insert_tipo_asiento.php" onSubmit="return revisar()">
        <p>&nbsp;</p>
        <table width="859" height="136" border="0" id="tabcampos">
          <tr>
            <td> <blockquote>
                          </p>
                          <p class="Estilo5">TIPO DE ASIENTO :
                            <input name="txtTipo_Asiento" type="text" id="txtTipo_Asiento4" title="Registre el tipo de asiento" onchange="javascript:chequea_tipo();" size="10" maxlength="3" onFocus="encender(this); " onBlur="apagar(this);">
</p>
                          <p>&nbsp;                          </p>
            </blockquote></td>
          </tr>
          <tr>
            <td><blockquote>
              <p align="left"><span class="Estilo5">DESCRIPCI&Oacute;N TIPO DE ASIENTO :</span>
                <input name="txtDes_Tipo_Asi" type="text" id="txtDes_Tipo_Asi" title="Registre descripci&oacute;n del tipo de asiento" size="80" maxlength="200"  onFocus="encender(this)" onBlur="apagar(this)">
              </p>
            </blockquote></td>
          </tr>
          <tr>
            <td><p>&nbsp;</p>
              <blockquote>
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