<?include ("../class/ventana.php"); include ("../class/fun_fechas.php"); $fecha_hoy=asigna_fecha_hoy(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL DE BIENES NACIONALES (Incluir Tipos De Movimientos)</title>
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
 mref=mform.txtcodigo.value;  mref=Rellenarizq(mref,"0",3);   mform.txtcodigo.value=mref; } 
function revisar(){var f=document.form1;
    if(f.txtcodigo.value==""){alert("Codigo no puede estar Vacio");return false;}else{f.txtcodigo.value=f.txtcodigo.value.toUpperCase();}
    if(f.txtdenomina_tipo.value==""){alert("Denominacion no puede estar Vacio"); return false; } else{f.txtdenomina_tipo.value=f.txtdenomina_tipo.value.toUpperCase();}
    if(f.txttipo.value==""){alert("Tipo de Movimiento no puede estar Vacio");return false;}else{f.txttipo.value=f.txttipo.value.toUpperCase();}
    if(f.txtgen_comprobante.value==""){alert("Genera comprobante no puede estar Vacio"); return false; } else{f.txtgen_comprobante.value=f.txtgen_comprobante.value.toUpperCase();}
document.form1.submit;
return true;}
</script>

</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR TIPOS DE MOVIMIENTOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="280" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="270"><table width="92" height="268" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_tipos_movimi_ar.php?Gcodigo=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_tipos_movimi_ar.php?Gcodigo=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
    <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:828px; height:77px; z-index:1; top: 85px; left: 124px;">
            <form name="form1" method="post" action="Insert_tipos_movimi_ar.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><table width="820">
                <tr>
                  <td width="120" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO :</span></div></td>
                  <td width="700" scope="col"><div align="left"><span class="Estilo5"><input name="txtcodigo" type="text" id="txtcodigo" size="5" maxlength="3"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10" onchange="chequea_codigo(this.form);" >  </span></div></td>
                </tr>
              </table></td>
          </tr>
		  <tr><td height="10">&nbsp;</td></tr>
          <tr>
            <td><table width="820">
                <tr>
                  <td width="120" scope="col"><div align="left"><span class="Estilo5">CONCEPTO :</span></div></td>
                  <td width="700" scope="col"><div align="left"><span class="Estilo5"><input name="txtdenomina_tipo" type="text" id="txtdenomina_tipo" size="100" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo10"> </span></div></td>
                </tr>
              </table></td>
          </tr>
		  <tr><td height="10">&nbsp;</td></tr>
          <tr>
            <td><table width="820">
              <tr>
                <td width="170"><div align="left"><span class="Estilo5">TIPO DE MOVIMIENTO:</span></div></td>
				<td width="650"><div align="left"><span class="Estilo5"><select class="Estilo10" name="txttipo" size="1" id="txttipo" onFocus="encender(this)" onBlur="apagar(this)">
                      <option selected>INCORPORACION</option>  <option>DESINCORPORACION</option> <option>REASIGNACIONES</option> <option>MODIFICACIONES</option>
                    </select></span></div></td>
              </tr>
            </table></td>
          </tr>
		  <tr><td height="10">&nbsp;</td></tr>
          <tr>
            <td><table width="820">
              <tr>
                <td width="170" scope="col"><div align="left"><span class="Estilo5">GENERA COMPROBANTE :</span></div></td>
				<td width="650"><span class="Estilo5"> <select class="Estilo10" name="txtgen_comprobante" size="1" id="txtgen_comprobante" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>NO</option><option>SI</option> </select> </span></td>
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
