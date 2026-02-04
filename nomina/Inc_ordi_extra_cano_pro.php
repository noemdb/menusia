<?include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL NÓMINA Y PERSONAL (Incluir Calculo De Nómina Extraordinaria)</title>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR CALCULO DE N&Oacute;MINA EXTRAORDINARIA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="244" border="1" id="tablacuerpo">
  <td ><tr>
    <td width="92" height="234"><table width="92" height="230" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_ordi_extra_camo_pro.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_ordi_extra_camo_pro.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td height="161">&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:833px; height:29px; z-index:1; top: 83px; left: 121px;">
            <form name="form1" method="post" action="Insert_beneficiario.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><table width="834">
              <tr>
                <td width="59" scope="col"><div align="left"><span class="Estilo5">TIPO DE N&Oacute;MINA : </span></div></td>
                <td width="95" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10">
                    <input name="txtcode_ingre_mora224233" type="text" id="txtcode_ingre_mora224233" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                    <input type="submit" name="Submit3" value="...">
                </span></strong></strong> </strong></strong></span> </span></div></td>
                <td width="664" scope="col"><div align="left"><span class="Estilo5"><span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo10">
                    <input name="txtcode_ingre_mora22423222" type="text" id="txtcode_ingre_mora22423222" size="60" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                </span></strong></strong></strong></strong></strong></strong></span></span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="836">
              <tr>
                <td width="100" scope="col"><div align="left"><span class="Estilo5">FECHA PROCESO DESDE : </span></div></td>
                <td width="147" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><span class="Estilo10">
                    <input name="txtcode_ingre_mora2555" type="text" id="txtcode_ingre_mora2555" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                </span></strong></strong> </strong></strong></span> </span></div></td>
                <td width="49" scope="col"><div align="left"><span class="Estilo5">HASTA : </span></div></td>
                <td width="155" scope="col"><div align="left"><span class="Estilo5"> <span class="menu"><strong><strong><strong><strong><strong><strong><span class="Estilo10">
                    <input name="txtcode_ingre_mora25552" type="text" id="txtcode_ingre_mora255522" size="20" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                </span></strong></strong></strong></strong> </strong></strong></span> </span></div></td>
                <td width="72" scope="col"><span class="Estilo5">N&Uacute;MERO DE PERIODOS : </span></td>
                <td width="91" scope="col"><span class="Estilo5">
                  <input name="txtcode_ingre_multa33223" type="text" id="txtcode_ingre_multa33223" size="10" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                </span></td>
                <td width="71" scope="col"><span class="Estilo5">N&Uacute;MERO DE SEMANAS : </span></td>
                <td width="115" scope="col"><span class="Estilo5">
                  <input name="txtcode_ingre_multa332232" type="text" id="txtcode_ingre_multa332232" size="10" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><div align="left">
              <table width="826">
                <tr>
                  <th width="58" scope="col"><div align="right"><span class="Estilo12">CONCEPTOS</span></div></th>
                  <th width="756" scope="col">&nbsp;</th>
                </tr>
              </table>
            </div></td>
          </tr>
          <tr>
            <td><div align="center">AQUI VA UNA TABLA </div></td>
          </tr>
          <tr>
            <td><table width="826">
              <tr>
                <th width="58" scope="col"><div align="right"><span class="Estilo12">C&Aacute;LCULO</span></div></th>
                <th width="756" scope="col">&nbsp;</th>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><div align="center">AQUI VA UNA TABLA </div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
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