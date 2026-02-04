<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTABILIDAD PRESUPUESTARIA (Incluir Regiones)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
function LlamarURL(url){  document.location = url; }
function revisar(){
var f=document.form1;
var Valido;
    if(f.txtcod_region.value==""){alert("Código de la Region no puede estar Vacio");return false;}
    if(f.txtnombre_region.value==""){alert("Nombre de la Region no puede estar Vacia"); return false; }
       else{f.txtnombre_region.value=f.txtnombre_region.value.toUpperCase();}
    if(f.txtcod_region.value.length==2){f.txtcod_region.value=f.txtcod_region.value.toUpperCase();}
       else{alert("Longitud Código de Region Invalido");return false;}
document.form1.submit;
return true;}
function chequea_codigo(mform){
var mref;
   mref=mform.txtCodigo_Region.value;
   mref = Rellenarizq(mref,"0",2);
   mform.txtCodigo_Region.value=mref;
return true;}
</script>

</head>

<body>
<table width="977" height="38" border="0" bgcolor="#000066" id="tablaencabezado">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR REGIÓN </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9"> </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_regiones_ar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_regiones_ar.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td height="126">&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:822px; height:29px; z-index:1; top: 92px; left: 129px;">
            <form name="form1" method="post" action="Insert_regiones_ar.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><div align="left">
              <table width="792">
                <tr>
                  <td width="100" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO :</span></div></td>
                  <td width="719" scope="col"><div align="left"><span class="Estilo5">
                      <input name="txtcod_region" type="text" id="txtcod_region" size="4" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                  </span></div></td>
                </tr>
              </table>
            </div></td>
          </tr>
          <tr>
            <td><table width="792">
              <tr>
                <td width="100" scope="col"><div align="left"><span class="Estilo5">DENOMINACION :</span></div></td>
                <td width="719" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtnombre_region" type="text" id="txtnombre_region" size="80" maxlength="250"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
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
</body>
</html>
