<?include ("../../class/seguridad.inc");?>
<?include ("../../class/conects.php");  include ("../../class/funciones.php"); ?>
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte Definido por el Usuario)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
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
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE DEFINIDO POR EL USUARIO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="209" border="1" id="tablacuerpo">
  <tr>
    <td width="890" height="203">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:860px; height:192px; z-index:1; top: 70px; left: 115px;">
        <form name="form1" method="post">
          <table width="856" height="60" border="0" >
                <tr>
                  <td width="850" height="24"><table width="839" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="157" class="Estilo13">NOMBRE DEL REPORTE : </td>
                      <td width="657"><div align="left"><span class="Estilo12"> <span class="Estilo5">
                          <input name="txtnom_reporte" type="text" id="txtnom_reporte" title="Escribe el Nombre del Reporte"  onFocus="encender(this)" onBlur="apagar(this)" size="60">
                      </span> </span></div></td>
                      <td width="25">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
                <tr>
                  <td height="14">&nbsp;</td>
                </tr>
          </table>
              <p>&nbsp; </p>
        </form>
        <table width="812" height="49">
          <tr>
            <td width="564" height="34">&nbsp;</td>
            <td width="54"><form name="form2" method="post" action="">
              <img src="../../imagenes/OPEN.BMP" width="49" height="32">                </form></td>
            <td width="85"><input name="graba" type="submit" id="graba"  value="Grabar"></td>
            <td width="89"><input name="Submit2" type="reset" value="Blanquear"></td>
          </tr>
        </table>
    </div>    </td>
</tr>
</table>
</body>
</html>
