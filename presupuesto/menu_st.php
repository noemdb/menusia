<? include("../class/seguridad.inc"); ?>
<? include("../class/funciones.php");
include("../class/configura.inc");
$conn = pg_connect("host=" . $host . " port=" . $port . " password=" . $password . " user=" . $user . " dbname=" . $dbname . "");
if (pg_ErrorMessage($conn)) { ?>
  <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script>
<? } else {
  $Nom_Emp = busca_conf();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../class/imagenes/sia.ico">
<html>

<head>
  <title>SIA CONTABILIDAD PRESUPUESTARIA</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <LINK href="../class/sia.css" type=text/css rel=stylesheet>
  <!-- .css DEL MENU //-->
  <link rel="stylesheet" href="../class/default.css" type="text/css">
  <SCRIPT language=JavaScript src="../class/sia.js" type=text/javascript></SCRIPT>
  <!-- .js DEL MENU //-->
  <SCRIPT language=JavaScript src="../class/sdtree.js" type="text/javascript"></SCRIPT>
  <SCRIPT language=JavaScript src="/sia/presupuesto/structure.js" type="text/javascript"></SCRIPT>
  <script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
function Llamar_comp(def,url){
 if (def=="N"){ alert('ETAPA DE DEFINICION INICIAL ABIERTA'); }
  else {document.location = url;}
}
</script>
  <style type="text/css">
    <!--
    .Estilo2 {
      color: #FFFFFF
    }

    .Estilo4 {
      font-size: 14pt;
      font-weight: bold;
    }

    .Estilo5 {
      font-size: 14pt
    }

    .Estilo6 {
      font-size: 16pt
    }

    .Estilo8 {
      color: #FFFFFF;
      font-weight: bold;
    }

    .Estilo14 {
      font-size: 9px
    }

    .Estilo15 {
      color: #000066
    }

    .Estilo10 {
      color: #000066
    }
    -->
  </style>
</head>

<body>
  <!-- MENU //-->
  <script type="text/javascript">
    var tree1 = new SoftDrawerTree('PRESUPUESTO', TREE_NODES1);
    function ExpandAndDraw(tree) { tree.closeAll(); tree.draw(1); }
    ExpandAndDraw(tree1);
  </script>
  <table width="955" height="38" border="0" bgcolor="#000066">
    <tr>
      <td width="70">
        <div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div>
      </td>
      <td width="786">
        <div align="center"><span class="Estilo2 Estilo4 Estilo6">CONTABILIDAD PRESUPUESTARIA</span></div>
      </td>
      <td width="85"><span class="Estilo8">VER 6.0 </span></td>
    </tr>
  </table>
  <table width="955" height="686" border="1">
    <tr>
      <td height="680">
        <table width="943" height="653" border="0">
          <tr>
            <td width="296" height="649">
              <table width="236" height="639" id="tablamenu">
                <td width="228" height="633">&nbsp;</td>
          </tr>
        </table>
      </td>
      <td width="637" align="center" valign="middle">
        <div id="Layer3" style="position:absolute; width:573px; height:65px; z-index:3; left: 190px; top: 83px;">
          <div align="center" class="Estilo5"> <? echo $Nom_Emp ?></div>
        </div>
        <div id="Layer1" style="position:absolute; width:264px; height:127px; z-index:1; left: 694px; top: 280px;">
          <div align="center">
            <table width="251" height="123" border="0">
              <tr>
                <td width="131" rowspan="3"><img src="../imagenes/Logo_sia.gif" alt="Ceinco Logo" width="126"
                    height="99" longdesc="http://www.ceinco.com/"></td>
                <td width="99" height="20">&nbsp;</td>
              </tr>
              <tr>
                <td height="71" align="center" valign="middle" class="Estilo9  Estilo14"><span
                    class="Estilo14 Estilo9"><strong><span class="Estilo9  Estilo14 Estilo15">SISTEMA INTEGRADO
                        ADMINISTRATIVO SIPAP 6.0 </span></strong></span></td>
              </tr>
              <tr>
                <td height="20">&nbsp;</td>
              </tr>
            </table>
          </div>
        </div>
        <div align="left"></div>
        <div align="center"></div>
        <div id="Layer2" style="position:absolute; width:230px; height:226px; z-index:2; left: 360px; top: 150px;"><img
            src="../imagenes/Logo_empresa.gif" width="204" height="221" border="0"></div>
      </td>
    </tr>
  </table>
  </td>
  </tr>
  </table>
  <p>&nbsp;</p>
</body>

</html>
<? pg_close(); ?>