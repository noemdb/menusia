<?php include("../class/seguridad.inc");
include("../class/conects.php");
include("../class/funciones.php");
include("../class/configura.inc");
$conn = pg_connect("host=" . $host . " port=" . $port . " password=" . $password . " user=" . $user . " dbname=" . $dbname . "");
if (pg_ErrorMessage($conn)) { ?>
  <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script>
<?php } else {
  $Nom_Emp = busca_conf();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>

<head>
  <title>SIA CONFIGURACI&Oacute;N Y MANTENIMIENTO</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
  <LINK href="../class/sia.css" type="text/css" rel="stylesheet">
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
  <style type="text/css">
    <!--
    .Estilo4 {
      font-size: 14pt;
      font-weight: bold;
    }

    .Estilo6 {
      font-size: 16pt
    }

    .Estilo8 {
      color: #FFFFFF;
      font-weight: bold;
    }

    .Estilo15 {
      color: #000066
    }
    -->
  </style>
</head>

<body>
  <table width="955" height="38" border="0" bgcolor="#000066">
    <tr>
      <td width="70">
        <div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div>
      </td>
      <td width="786">
        <div align="center"><span class="Estilo2 Estilo4 Estilo6">CONFIGURACI&Oacute;N Y MANTENIMIENTO (MENU AUDITORIA)
          </span></div>
      </td>
      <td width="85"><span class="Estilo8">VER 6.0 </span></td>
    </tr>
  </table>
  <table width="955" height="327" border="1">
    <tr>
      <td width="116">
        <table width="116" height="350" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
          <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
              onClick="javascript:LlamarURL('Auditoria_Contab.php')" ;
              onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35" bgColor=#EAEAEA><A class=menu
                href="Auditoria_Contab.php">Contabilidad</A></td>
          </tr>
          <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
              onclick="javascript:window.close()" ; onMouseOut="this.style.backgroundColor='#EAEAEA';" height="35"
              bgColor=#EAEAEA><A class=menu href="javascript:window.close()">Presupuesto</A></td>
          </tr>
          <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';"
              onClick="javascript:LlamarURL('menu.php')" ; onMouseOut="this.style.backgroundColor='#EAEAEA';"
              height="35" bgColor=#EAEAEA><a href="menu.php" class="menu">Menu Principal </a></td>
          </tr>
          <td>&nbsp;</td>
    </tr>
  </table>
  </td>
  <td width="823" align="center" valign="middle">
    <div id="Layer1" style="position:absolute; width:264px; height:127px; z-index:1; left: 694px; top: 280px;">
      <div align="center">
        <table width="251" height="123" border="0">
          <tr>
            <td width="131" rowspan="3"><img src="../imagenes/Logo_sia.gif" alt="Ceinco Logo" width="126" height="99"
                longdesc="http://www.ceinco.com/"></td>
            <td width="99" height="20">&nbsp;</td>
          </tr>
          <tr>
            <td height="71" align="center" valign="middle" class="Estilo9  Estilo14"><span
                class="Estilo14 Estilo9"><strong><span class="Estilo9  Estilo14 Estilo15"><span
                      class="Estilo9  Estilo14">SISTEMA INTEGRADO ADMINISTRATIVO SIPAP 6.0
                    </span></span></strong></span></td>
          </tr>
          <tr>
            <td height="20">&nbsp;</td>
          </tr>
        </table>
      </div>
    </div>
    <div id="Layer3" style="position:absolute; width:804px; height:36px; z-index:3; left: 149px; top: 83px;">
      <div align="center" class="Estilo4"><?php echo $Nom_Emp ?></div>
    </div>
    <div align="left"></div>
    <div align="center"></div>
    <div id="Layer2" style="position:absolute; width:230px; height:226px; z-index:2; left: 383px; top: 131px;"><img
        src="../imagenes/Logo_empresa.gif" width="204" height="221"></div>
  </td>
  </tr>
  </table>
  <p>&nbsp;</p>
</body>

</html>
<?php pg_close(); ?>