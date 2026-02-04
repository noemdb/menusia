<?include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL NÓMINA Y PERSONAL (Incluir Definición De Cargos)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../class/sia.css" type=text/css
rel=stylesheet>
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
<script language="JavaScript" type="text/JavaScript">
function revisar(){
var f=document.form1;
    if(f.txtced_rif.value==""){alert("Cédula/Rif del beneficiario no puede estar Vacio");return false;}
          else{f.txtced_rif.value=f.txtced_rif.value.toUpperCase();}
    if(f.txtnombre.value==""){alert("Nombre del Beneficiario no puede estar Vacia"); return false; }
       else{f.txtnombre.value=f.txtnombre.value.toUpperCase();}
document.form1.submit;
return true;}
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
.Estilo10 {font-size: 12px}
.Estilo12 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>
<body>
<table width="978" height="52" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR DEFINICI&Oacute;N DE CARGOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="319" border="1" id="tablacuerpo">
  <td ><tr>
    <td width="92" height="309"><table width="92" height="305" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_carg_ar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_carg_ar.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td height="231">&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:833px; height:248px; z-index:1; top: 83px; left: 121px;">
            <form name="form1" method="post" action="Insert_beneficiario.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><table width="836">
              <tr>
                <td width="106" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO CARGO : </span></div></td>
                <td width="718" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtcedula" type="text" class="Estilo5" id="txtcedula2"  onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="20">
                </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="836">
              <tr>
                <td width="159" scope="col"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N DEL CARGO : </span></div></td>
                <td width="665" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                <textarea name="txtcedula2" cols="99" class="Estilo5" id="txtcedula22" onFocus="encender(this)" onBlur="apagar(this)"></textarea>
                </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="27"><table width="828">
              <tr>
                <td width="53" height="19" scope="col"><div align="left"><span class="Estilo5">GRADO : </span></div></td>
                <td width="86" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10"> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                    <input name="txtcedula32" type="text" class="Estilo5" id="txtcedula32"  onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="10">
                </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </span></strong></strong> </strong></strong></span> </span></div></td>
                <td width="44" scope="col"><span class="Estilo5">PASO :</span></td>
                <td width="78" scope="col"><span class="Estilo5"><span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                  <input name="txtcedula3222" type="text" class="Estilo5" id="txtcedula3222"  onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="10">
                </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong></strong></strong></span></span></td>
                <td width="93" scope="col"><span class="Estilo5">NRO. CARGOS :</span></td>
                <td width="91" scope="col"><span class="Estilo5"><span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                  <input name="txtcedula3422" type="text" class="Estilo5" id="txtcedula3422"  onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="10">
                </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong></strong></strong></span></span></td>
                <td width="72" scope="col"><span class="Estilo5">ASIGNADO :</span></td>
                <td width="92" scope="col"><span class="Estilo5"><span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                  <input name="txtcedula3432" type="text" class="Estilo5" id="txtcedula3432"  onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="10">
                </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong></strong></strong></span></span></td>
                <td width="60" scope="col"><span class="Estilo5">SUELDO :</span></td>
                <td width="123" scope="col"><span class="Estilo5"><span class="menu"><strong><strong><strong><strong><span class="Estilo10"><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong><strong>
                  <input name="txtcedula3442" type="text" class="Estilo5" id="txtcedula3442"  onFocus="encender(this)" onBlur="apagar(this)" size="11" maxlength="11">
                </strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></strong></span></strong></strong></strong></strong></span></span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="27">&nbsp;</td>
          </tr>
        </table>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Submit" type="submit" id="Submit"  value="Grabar"></td>
            <td width="88"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
            </form>
      </div>
    </td>
</tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>