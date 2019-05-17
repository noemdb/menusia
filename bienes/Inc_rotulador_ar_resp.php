<?include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Incluir Responsables Rotulador)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" src="../class/sia.js" type="text/javascript"></script>
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
    if(f.txtced_res_rotu.value==""){alert("Cedula del Rotulador no puede estar Vacia");return false;}else{f.txtced_res_rotu.value=f.txtced_res_rotu.value.toUpperCase();}
    if(f.txtnombre_res_rotu.value==""){alert("Nombre del Rotulador no puede estar Vacio"); return false; } else{f.txtnombre_res_rotu.value=f.txtnombre_res_rotu.value.toUpperCase();}
    //if(f.textobservaciones_rotu.value==""){alert("Observaciones no puede estar Vacio"); return false; } else{f.textobservaciones_rotu.value=f.textobservaciones_rotu.value.toUpperCase();}
document.form1.submit;
return true;}
</script>

</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR RESPONSABLE ROTULADOR </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="250" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="245"><table width="92" height="241" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_rotulador_ar_resp.php?Gced_res_rotu=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_rotulador_ar_resp.php?Gced_res_rotu=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td >&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:828px; height:129px; z-index:1; top: 84px; left: 126px;">
            <form name="form1" method="post" action="Insert_rotulador_ar_resp.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><table width="820">
              <tr>
                <td width="140" scope="col"><div align="left"><span class="Estilo5">C&Eacute;DULA DE IDENTIDAD:</span></div></td>
                <td width="680" scope="col"><div align="left"><span class="Estilo5"><input name="txtced_res_rotu" type="text" id="txtced_res_rotu" size="15" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  </span></div></td>
              </tr>
            </table></td>
          </tr>
		  <tr><td height="10">&nbsp;</td></tr>
          <tr>
            <td><table width="820">
              <tr>
                <td width="140" scope="col"><div align="left"><span class="Estilo5">NOMBRE :</span></div></td>
                <td width="680" scope="col"><div align="left"><span class="Estilo5"><input name="txtnombre_res_rotu" type="text" id="txtnombre_res_rotu" size="100" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">  </span></div></td>
              </tr>
            </table></td>
          </tr>
		  <tr><td height="10">&nbsp;</td></tr>
          <tr>
            <td><table width="820">
              <tr>
                <td width="140" scope="col"><div align="left"><span class="Estilo5">OBSERVACI&Oacute;N :</span></div></td>
                <td width="680" scope="col"><div align="left"><textarea name="textobservaciones_rotu" cols="80" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" class="headers" id="textobservaciones_rotu"></textarea> </div></td>
              </tr>
            </table></td>
          </tr>
		  <tr><td height="10">&nbsp;</td></tr>
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
</body>
</html>
