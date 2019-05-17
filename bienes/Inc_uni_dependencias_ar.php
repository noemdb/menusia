<?include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Incluir Unidades/Dependencias)</title>
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
    if(f.txtdes_unidad_sol.value==""){alert("Descripcion no puede estar Vacia");return false;}else{f.txtdes_unidad_sol.value=f.txtdes_unidad_sol.value.toUpperCase();}
    if(f.txtcod_dependencia.value==""){alert("Codigo no puede estar Vacio"); return false; } else{f.txtcod_dependencia.value=f.txtcod_dependencia.value.toUpperCase();}
    if(f.txtcod_direccion.value==""){alert("Codigo no puede estar Vacio"); return false; } else{f.txtcod_direccion.value=f.txtcod_direccion.value.toUpperCase();}
    if(f.txtcod_departamento.value==""){alert("Codigo no puede estar Vacio"); return false; } else{f.txtcod_departamento.value=f.txtcod_departamento.value.toUpperCase();}
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
-->
</style>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR SITUACI&Oacute;N LEGAL DEL BIEN </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="106" border="1" id="tablacuerpo">
  <td ><tr>
    <td width="92" height="96"><table width="92" height="188" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_uni_dependencias_ar.php?Gdes_unidad_sol=U')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_uni_dependencias_ar.php?Gdes_unidad_sol=U">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td height="114">&nbsp;</td>
  </tr>
    </table></td>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:816px; height:34px; z-index:1; top: 86px; left: 124px;">
            <form name="form1" method="post" action="Insert_uni_dependencias_ar.php" onSubmit="return revisar()">
        <table width="828" border="0" align="center" >
          <tr>
            <td><div align="left">
              <table width="792">
                <tr>
                  <td width="100" scope="col"><div align="left"><span class="Estilo5">UNIDAD SOLICITABLES :</span></div></td>
                  <td width="686" scope="col"><div align="left"><span class="Estilo5">
                      <input name="txtdes_unidad_sol" type="text" id="txtdes_unidad_sol" size="80" maxlength="250"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                  </span></div></td>
                </tr>
              </table>
            </div></td>
          </tr>
          <tr>
            <td><table width="792">
              <tr>
                <td width="100" scope="col"><div align="left"><span class="Estilo5">DEPENDENCIA :</span></div></td>
                <td width="692" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcod_dependencia" type="text" id="txtcod_dependencia" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="792">
              <tr>
                <td width="100" scope="col"><div align="left"><span class="Estilo5">DIRECI&Oacute;N :</span></div></td>
                <td width="711" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcod_direccion" type="text" id="txtcod_direccion" size="5" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="792">
              <tr>
                <td width="100" scope="col"><div align="left"><span class="Estilo5">DEPARTAMENTO :</span></div></td>
                <td width="678" scope="col"><div align="left"><span class="Estilo5">
                    <input name="txtcod_departamento" type="text" id="txtcod_departamento" size="10" maxlength="8"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                </span></div></td>
              </tr>
            </table></td>
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
