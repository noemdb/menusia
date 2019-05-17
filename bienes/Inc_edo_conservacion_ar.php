<?include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIACONTROL DE BIENES NACIONALES (Incluir Estado De Conservación Del Bien)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
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
function chequea_codigo(mform){ var mref;
 mref=mform.txtcodigo.value;  mref=Rellenarizq(mref,"0",2);   mform.txtcodigo.value=mref; } 
function revisar(){var f=document.form1;
    if(f.txtcodigo.value==""){alert("Codigo no puede estar Vacia");return false;}else{f.txtcodigo.value=f.txtcodigo.value.toUpperCase();}
    if(f.txtedo_bien.value==""){alert("Estado del bien no puede estar Vacio"); return false; } else{f.txtedo_bien.value=f.txtedo_bien.value.toUpperCase();}
    if(f.txtdescripcion.value==""){alert("Descripcion no puede estar Vacio"); return false; } else{f.txtdescripcion.value=f.txtdescripcion.value.toUpperCase();}
document.form1.submit;
return true;}
</script>

</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR ESTADO DE CONSERVACI&Oacute;N DEL BIEN </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="250" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="245"><table width="92" height="240" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_edo_conservacion_ar.php?Gcodigo=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_edo_conservacion_ar.php?Gcodigo=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:834px; height:22px; z-index:1; top: 89px; left: 126px;">
            <form name="form1" method="post" action="Insert_edo_conservacion_ar.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><table width="820">
                <tr>
                  <td width="120" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO :</span></div></td>
                  <td width="700" scope="col"><div align="left"><span class="Estilo5"> <input name="txtcodigo" type="text" id="txtcodigo" size="4" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_codigo(this.form);" class="Estilo10">
                  </span></div></td>
                </tr>
              </table>
            </div></td>
          </tr>
          <tr>
            <td><table width="820">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">ESTADO :</span></div></td>
                <td width="700" scope="col"><div align="left"><span class="Estilo5"><input name="txtedo_bien" type="text" id="txtedo_bien" size="50" maxlength="50"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="820">
              <tr>
                <td width="120" scope="col"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></div></td>
                <td width="700" scope="col"><div align="left"><span class="Estilo5"><textarea name="txtdescripcion" cols="80" id="txtdescripcion" onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10"></textarea>
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
