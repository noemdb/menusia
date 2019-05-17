<?include ("../class/seguridad.inc"); include ("../class/ventana.php"); include ("../class/fun_fechas.php");  $fecha_hoy=asigna_fecha_hoy(); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD FINANCIERA</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/JavaScript"></script>
<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>
<script language="JavaScript" type="text/JavaScript">
function revisar(){var f=document.form1; var Valido=true;
    if(f.txtcod_informe.value==""){alert("Codigo del Informe no puede estar Vacio");return false;}
    if(f.txtnombre_informe.value==""){alert("Descripcion del Informe no puede estar Vacia"); return false; }
         else{f.txtnombre_informe.value=f.txtnombre_informe.value.toUpperCase();}
    if(f.txtarch_informe.value==""){alert("Nombre del archivo no puede estar Vacia"); return false; }
document.form1.submit;
return true;}
</script>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INCLUIR INFORMES CONTABLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="349" border="1">
  <tr>
    <td width="92"><table width="92" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_inf_contab.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="Act_inf_contab.php">Atras</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu</A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="869"><div id="Layer1" style="position:absolute; width:868px; height:355px; z-index:1; top: 80px; left: 112px;">
      <form name="form1" method="post" action="Insert_inf_contables.php" onSubmit="return revisar()">
        <table width="861" border="0">
          <tr>
            <td width="432"><span class="Estilo5">C&Oacute;DIGO DEL INFORME :  <input class="Estilo10" name="txtcod_informe" type="text" id="txtcod_informe" title="Registre el Codigo del informe"  size="4" maxlength="2" onFocus="encender(this); " onBlur="apagar(this);" ></span></td>
            <td width="419"></td>
          </tr>
		  <tr> <td>&nbsp;</td>  </tr>
        </table>
		<table width="859" border="0">
          <tr>
            <td width="170"><span class="Estilo5">DESCRIPCION DEL INFORME :</span></td>
            <td width="679"><textarea name="txtnombre_informe" cols="80" class="Estilo10" maxlength="250" onFocus="encender(this)" onBlur="apagar(this)" id="txtnombre_informe"></textarea></td>
          </tr>
		  <tr> <td>&nbsp;</td>  </tr>
        </table>
		
        <table width="859" border="0">
          <tr>
            <td width="209"><span class="Estilo5">NOMBRE DEL ARCHIVO REPORTES :</span></td>
			<td width="650"><span class="Estilo5"><input class="Estilo10" name="txtarch_informe" type="text" id="txtarch_informe" title="Registre el nombre del archivo"  size="100" maxlength="250" onFocus="encender(this); " onBlur="apagar(this);" ></span></td>
          </tr>
		  <tr> <td>&nbsp;</td>  </tr>
        </table>
        <p>&nbsp;</p>       
        <table width="768">
          <tr>
            <td width="664">&nbsp;</td>
            <td width="88" valign="middle"><input  name="button" type="submit" id="button"  value="Grabar"></td>
            <td width="88"><input  name="blanquea" type="reset" value="Blanquear"></td>
          </tr>
        </table>
        <div align="right"></div>
        <div align="right"></div>
        <p>&nbsp;</p>
        </form>
    </div>
  </tr>
</table>
</body>
</html>