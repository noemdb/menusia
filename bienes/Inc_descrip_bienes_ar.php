<?include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Incluir Descripción De Bienes)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_bien.js" type="text/javascript"></script>
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
function apaga_cod(mthis){var mref;
 apagar(mthis); mref=mthis.value;   ajaxSenddoc('GET', 'numdesaut.php?cod_c='+mref, 'dnum', 'innerHTML');
}
function chequea_numero(mform){ var mref;
 mref=mform.txtnum_descrip.value;  mref=Rellenarizq(mref,"0",8);   mform.txtnum_descrip.value=mref; }
function revisar(){var f=document.form1;
    if(f.txtcodigo_c.value==""){alert("Codigo no puede estar Vacio");return false;}else{f.txtcodigo_c.value=f.txtcodigo_c.value.toUpperCase();}
    if(f.txtnum_descrip.value==""){alert("El Numero no puede estar Vacio"); return false; } else{f.txtnum_descrip.value=f.txtnum_descrip.value.toUpperCase();}
    if(f.txtdescripcion_b.value==""){alert("Descripcion puede estar Vacio"); return false; } else{f.txtdescripcion_b.value=f.txtdescripcion_b.value.toUpperCase();}
document.form1.submit;
return true;}
</script>

</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR DESCRIPCI&Oacute;N DE BIENES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="260" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="260"><table width="92" height="259" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_descrip_bienes_ar.php?Gcodigo_c=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_descrip_bienes_ar.php?Gcodigo_c=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td >&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:829px; height:60px; z-index:1; top: 98px; left: 122px;">
            <form name="form1" method="post" action="Insert_descrip_bienes_ar.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><table width="820">
                <tr>
                  <td width="120"><div align="left"><span class="Estilo5">C&Oacute;DIGO :</span></div></td>
                  <td width="700"><div align="left"><span class="Estilo5"><input name="txtcod_clasificacion" type="text" id="txtcod_clasificacion" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apaga_cod(this)" class="Estilo10">
				    <input name="btcod_clas" type="button" id="btcod_clas" title="Abrir Catalogo Clasificacion de Bienes" onClick="VentanaCentrada('Cat_clasificaciond.php?criterio=','SIA','','750','500','true')" class="Estilo5" value="...">
                  </span></div></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><table width="820">
              <tr>
                <td width="120"><div align="left"><span class="Estilo5">N&Uacute;MERO :</span></div></td>
                <td width="700"><span class="Estilo5"><input name="txtnum_descrip" type="text" id="txtnum_descrip" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_numero(this.form);" class="Estilo10">
               </span></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="820">
              <tr>
                <td width="120"><div align="left"><span class="Estilo5">DESCRIPCI&Oacute;N :</span></div></td>
                <td width="700"><div align="left"><span class="Estilo5"><textarea name="txtdescripcion_b" cols="80" id="txtdescripcion_b" onFocus="encender(this)" onBlur="apagar(this)" class="headers"></textarea>
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr><td>&nbsp;</td> </tr>
        </table>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
			<td width="5"><input name="txtnom_clasificacion" type="hidden" id="txtnom_clasificacion" value=""></td>
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
