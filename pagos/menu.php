<?include ("../class/seguridad.inc"); include ("../class/conects.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?} else{ $Nom_Emp=busca_conf(); }
if($dbname<>"DATOS"){ $Nom_Emp=$Nom_Emp." (".$dbname.")"; }
$nombre_menu="stmenu.js"; if($Cod_Emp=="70"){$nombre_menu="stmenu_hl.js";}; if(($Cod_Emp=="32")or($Cod_Emp=="A1")){$nombre_menu="stmenu_cs.js";};
//echo $Cod_Emp." ".$nombre_menu;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js"  type="text/javascript"></script>
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
 if (def=="N"){ alert('ETAPA DE DEFINICION INICIAL ABIERTA'); } else {document.location = url;}
}
var mcod_emp='<? echo $Cod_Emp ?>';
</script>
<style type="text/css">
<!--
.Estilo4 {font-size: 13pt;font-weight: bold;}
.Estilo8 {color: #FFFFFF; font-weight: bold; }
.Estilo14 {font-size: 9px}
.Estilo15 {color: #000066}
.Estilo10 {color: #000066}
-->
</style>
<script type="text/javascript" language="JavaScript1.2" src="../class/tree-menu/dtree1.js"></script>
  <script type="text/javascript" language="JavaScript1.2" src="<?php echo $nombre_menu ?>"></script>
</head>
<?
$sql="SELECT campo103, campo104 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; $modulo="01";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $Nom_usuario=$registro["campo104"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$sql="select campo601 from sia006 where campo601='$usuario_sia' and campo602='$modulo'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
if ($filas==0){ ?><script language="JavaScript"> alert("NO TIENE DEERECHOS PARA ESTE MODULO"); document.location='index.php';</script><?}
}$Nom_usuario="USUARIO: ".$Nom_usuario;
error_reporting(E_ALL ^ E_NOTICE); $userAgent = $_SERVER[HTTP_USER_AGENT]; $nombre_serv=$_SERVER[SERVER_NAME]; error_reporting(E_ALL); 
$userAgent = strtolower ($userAgent); $var_so=""; $PHP_OS=PHP_OS; 
if(strpos($userAgent, "windows") !== false){ $var_so="Sistema Operativo Cliente : Windows"."<br>"; }
if(strpos($userAgent, "linux") !== false){ $var_so="Sistema Operativo Cliente : Linux ";}
$var_so=$var_so." Sistema Operativo Servidor : ". $PHP_OS." ".$nombre_serv;
?>
<body>
<table width="955" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="70"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="786"><div align="center"><span class="Estilo2 Estilo6">ORDENAMIENTO DE PAGOS</span></div></td>
    <td width="85"><span class="Estilo8">VER 6.0 </span></td>
  </tr>
</table>
<table width="955" height="520" border="1">
  <tr>
    <td height="480"><table width="943" height="481" border="0">
      <tr>
        <td width="335" height="449"><table width="335" height="430"  id="tablamenu">
        <td width="228" height="433">&nbsp;</td>
        </tr>
        </table></td>
        <td width="598" align="center" valign="middle"><div id="Layer3" style="position:absolute; width:689px; height:65px; z-index:3; left: 230px; top: 83px;">
             <div align="center" class="Estilo4"> <? echo $Nom_Emp ?></div>
             <div id="Layer4" style="position:absolute; width:229px; height:33px; z-index:4; left: 550px; top: 460px;" class="Estilo9  Estilo14 Estilo15"><? echo $Nom_usuario ?></div>

            </div>
            <div id="Layer5" style="position:absolute; width:83px; height:294px; z-index:4; left: 861px; top: 85px;">
              <table width="140" height="146" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="60" align="center"><img src="../imagenes/scrollbu.gif" width="33" height="35" title="Ordenes de Pago" onclick="javascript:document.location='Act_orden_pago.php';"></td>
                </tr>
                <tr>
                  <td height="59" align="center"><img src="../imagenes/people.gif" width="33" height="34" border="0" title="Beneficiarios" onclick="document.location='Act_beneficiarios.php';"></td>
                </tr>
				<tr>
                  <td height="60" align="center"><img src="../imagenes/printer.gif" width="32" height="32" title="Reporte Listado Ordenes de Pago" onclick="javascript:document.location='/sia/pagos/rpt/Rpt_Listado_Ordenes_Pago.php';"></td>
                </tr>
                <tr>
                  <td height="60" align="center"><img src="../imagenes/printer.gif" width="32" height="32" title="Reporte Ordenes de pago por Beneficiario" onclick="javascript:document.location='/sia/pagos/rpt/Rpt_Ordenes_Pago_Beneficiario.php';"></td>
                </tr>
                <tr>
                  <td align="center">&nbsp;</td>
                </tr>
              </table>
            </div>
            <div id="Layer1" style="position:absolute; width:264px; height:127px; z-index:1; left: 687px; top: 426px;">
              <div align="center">
                <table width="251" height="123" border="0">
                  <tr>
                    <td width="131" rowspan="3"><img src="../imagenes/Logo_sia.gif" alt="Ceinco Logo" width="126" height="99" longdesc="http://www.ceinco.com/"></td>
                    <td width="99" height="20">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="71" align="center" valign="middle" class="Estilo9  Estilo14"><span class="Estilo14 Estilo9"><strong><span class="Estilo9  Estilo14 Estilo15">SISTEMA INTEGRADO ADMINISTRATIVO SIA 6.0 </span></strong></span></td>
                  </tr>
                  <tr>
                    <td height="20">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
            <div align="left"></div>
            <div align="center"></div>
            <div id="Layer2" style="position:absolute; width:230px; height:226px; z-index:2; left: 360px; top: 150px;"><img src="../imagenes/Logo_empresa.gif" width="204" height="221" border="0"></div></td>
			<div id="Layer6" style="position:absolute; width:300px; height:33px; z-index:4; left: 26px; top: 535px;" class="Estilo9  Estilo14 Estilo15"><? echo $var_so ?></div>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<? pg_close();?>