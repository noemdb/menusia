<?include ("../class/seguridad.inc"); include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (TITULO FLUJO DE CAJA)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel=stylesheet>
<script language=JavaScript src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function LlamarURL(url){  document.location = url; }
function chequea_codigo(mform){var mref;
   mref=mform.txtcodigo_titulo.value;   mref = Rellenarizq(mref,"0",2);   mform.txtcodigo_titulo.value=mref;
return true;}
function revisar(){var f=document.form1;var Valido;
    if(f.txtcodigo_titulo.value==""){alert("Codigo de Titulo no puede estar Vacio");return false;}
    if(f.txtdenominacion_titulo.value==""){alert("Denominacion de Titulo no puede estar Vacia"); return false; }
       else{f.txtdenominacion_titulo.value=f.txtdenominacion_titulo.value.toUpperCase();} 
    if(f.txtcodigo_titulo.value.length==2){f.txtcodigo_titulo.value=f.txtcodigo_titulo.value.toUpperCase();}
       else{alert("Longitud Codigo de Titulo Invalida");return false;}      
document.form1.submit;
return true;}


</script>

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
</head>

<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR TITULO  FLUJO DE CAJA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="265" border="1" id="tablacuerpo">
  <tr>
    <td width="92"><table width="92" height="262" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_Titulo_Pre_Caja.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu  href="Act_Titulo_Pre_Caja.php">Atras</a></div></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgcolor=#EAEAEA><div align="center"><a class=menu href="menu.php">Menu</a></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:832px; height:248px; z-index:1; top: 70px; left: 128px;">
        <form name="form1" method="post" action="Insert_titulo_pre_caja.php" onSubmit="return revisar()">
              <table width="825" height="68" border="0" align="center" >
			    <tr> <td>&nbsp;</td>  </tr>
                <tr>
                  <td width="820"><table width="820" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="200"><span class="Estilo5">C&Oacute;DIGO TITULO :</span></td>
                      <td width="620"><span class="Estilo5"> <input name="txtcodigo_titulo" type="text" class="Estilo5" id="txtcodigo_titulo"  onFocus="encender(this)" onBlur="apagar(this)" size="4" maxlength="2" onchange="chequea_codigo(this.form);"></span></td>
                    </tr>
                  </table></td>
                </tr>
				<tr> <td>&nbsp;</td>  </tr>
                <tr>
                  <td><table width="820" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="200"><span class="Estilo5">DENOMINACI&Oacute;N DEL TITULO : </span></td>
                      <td width="620"><div align="left"><span class="Estilo5"><input name="txtdenominacion_titulo" type="text" class="Estilo5" id="txtdenominacion_titulo"  onFocus="encender(this)" onBlur="apagar(this)" size="100" maxlength="100"></span></div></td>
                    </tr>
                  </table></td>
                </tr>
                <tr> <td>&nbsp;</td>  </tr>
              </table>
              <p>&nbsp;</p>
            
            <table width="812">
              <tr>
                <td width="664">&nbsp;</td>
                <td width="88"><input name="btgrabar" type="submit" id="btgrabar"  value="Grabar"></td>
                <td width="88"><input name="btblanquear" type="reset" value="Blanquear"></td>
              </tr>
            </table>
		</form>	
      </div>
    </td>
</tr>
</table>
</body>
</html>
