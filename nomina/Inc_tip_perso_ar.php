<?include ("../class/ventana.php");?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTROL N&Oacute;MINA Y PERSONAL (Incluir Tipo De Personal)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css"   rel="stylesheet">
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
function revisar(){
var f=document.form1;
    if(f.txtcod_tipo_personal.value==""){alert("Codigo Tipo de Personal no puede estar Vacio");return false;}  else{f.txtcod_tipo_personal.value=f.txtcod_tipo_personal.value.toUpperCase();}
    if(f.txtdes_tipo_personal.value==""){alert("Descripcion Tipo de Personal no puede estar Vacia"); return false;}  else{f.txtdes_tipo_personal.value=f.txtdes_tipo_personal.value.toUpperCase();}
document.form1.submit;
return true;}
</script> 
</head>
<body>
<table width="978" height="52" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR TIPO DE PERSONAL </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>

<table width="978" height="288" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="285"><table width="92" height="285" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onclick="javascript:LlamarURL('Act_tip_perso_ar.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_tip_perso_ar.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu </A></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="870">       <div id="Layer1" style="position:absolute; width:833px; height:248px; z-index:1; top: 83px; left: 121px;">
      <form name="form1" method="post" action="Insert_tipo_personal.php" onSubmit="return revisar()">
        <table width="868" border="0" align="center" >
          <tr>
            <td><table width="866">
                <tr>
                  <td width="204" ><span class="Estilo5">C&Oacute;DIGO TIPO DE PERSONAL : </span></td>
                  <td width="660" ><span class="Estilo5"> <input class="Estilo10" name="txtcod_tipo_personal" type="text" id="txtcod_tipo_personal" size="15" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)" > </span></td>
                </tr>
            </table></td>
          </tr>
          <tr>
             <td><table width="866">
               <tr>
                 <td width="205" ><span class="Estilo5">DESCRIPCI&Oacute;N TIPO DE PERSONAL : </span></td>
                 <td width="660" ><span class="Estilo5"><textarea name="txtdes_tipo_personal" cols="70" maxlength="100" class="Estilo10"  id="txtdes_tipo_personal" onFocus="encender(this)" onBlur="apagar(this)" ></textarea></span></td>
               </tr>
             </table></td>
          </tr>
          <tr>
             <td><table width="866">
               <tr>
                 <td width="205" ><span class="Estilo5">FIJO/CONTRATADO :</span></td>
                 <td width="230"><span class="Estilo5"> <select class="Estilo10" name="txtfijo_cont" size="1" id="txtfijo_cont" onFocus="encender(this)" onBlur="apagar(this)"> <option>FIJO</option><option>CONTRATADO</option> </select> </span></td>
                 <td width="200" ><span class="Estilo5">EMPLEADO/OBRERO :</span></td>
                 <td width="230"><span class="Estilo5"> <select class="Estilo10" name="txtemp_obr" size="1" id="txtemp_obr" onFocus="encender(this)" onBlur="apagar(this)"> <option>EMPLEADO</option><option>OBRERO</option> </select> </span></td>
               </tr>
             </table></td>
          </tr>
          <tr> <td>&nbsp;</td> </tr>
          <tr> <td>&nbsp;</td> </tr>
        </table>
        <table width="812">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
            <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
          </tr>
        </table>
            </form>
      </div>
    </td>
</tr>
</table>
<p>&nbsp;</p>
</body>
</html>