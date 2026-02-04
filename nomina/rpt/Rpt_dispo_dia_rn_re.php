<? include("../../class/seguridad.inc");
include("../../class/conects.php");
include("../../class/funciones.php");
include("../../class/configura.inc");
$conn = pg_connect("host=" . $host . " port=" . $port . " password=" . $password . " user=" . $user . " dbname=" . $dbname . "");
if (pg_ErrorMessage($conn)) { ?>
  <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else {
  $Nom_Emp = busca_conf();
}
$sql = "SELECT campo103 FROM sia001 where campo101='$usuario_sia'";
$resultado = pg_exec($conn, $sql);
$filas = pg_numrows($resultado);
$tipo_u = "U";
if ($filas > 0) {
  $registro = pg_fetch_array($resultado);
  $tipo_u = $registro["campo103"];
  $tiene_acceso = "S";
}
$Mcamino = "NNNNNNNNNNNNNNNNNNNN";
if ($tipo_u == "A") {
  $Mcamino = "SSSSSSSSSSSSSSSSSSSS";
} else {
  $modulo = "09";
  $opcion = "03-0000055";
  $sql = "select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";
  $res = pg_exec($conn, $sql);
  $filas = pg_numrows($res);
  if ($filas > 0) {
    $reg = pg_fetch_array($res);
    $Mcamino = $reg["campo607"] . $reg["campo608"] . $reg["campo609"] . $reg["campo610"] . $reg["campo611"] . $reg["campo612"] . $reg["campo613"] . $reg["campo614"] . $reg["campo615"] . $reg["campo616"] . $reg["campo617"] . $reg["campo618"] . $reg["campo619"] . $reg["campo620"] . $reg["campo621"] . $reg["campo622"] . $reg["campo623"] . $reg["campo624"] . $reg["campo625"] . $reg["campo626"];
  }
}
$posicion = strpos($Mcamino, 'S');
if (is_numeric($posicion)) {
  $Mcamino = $Mcamino;
} else { ?>
  <script language="JavaScript"> document.location = '../menu.php';</script>
<? }
$cod_presup_d = "";
$cod_presup_h = "zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz";
$cod_fuente_d = "";
$cod_fuente_h = "zz";
$des_fuente_d = "";
$des_fuente_h = "";
$fecha_hoy = asigna_fecha_hoy();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>

<head>
  <title>SIPAP N&Oacute;MINA Y PERSONAL (Reporte Disponibilidad Diaria)</title>
  <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
  <LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
  <script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
  <script language="javascript" src="../../class/cal2.js"></script>
  <script language="javascript" src="../../class/cal_conf2.js"></script>
  <script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);     mform.txtFechad.value=mfec;}
return true;}
function Llama_Rpt_Disp_Diaria(murl){var url;  
  r=confirm("Desea Generar el Reporte Disponibilidad Diaria ?");
  if (r==true) {url=murl+"?cod_presupd="+document.form1.txtcod_presupd.value+"&cod_presuph="+document.form1.txtcod_presuph.value+"&cod_fuented="+document.form1.txtcod_fuented.value+"&cod_fuenteh="+document.form1.txtcod_fuenteh.value+"&fecha="+document.form1.txtFechad.value+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url);  }
}
function Llama_Menu_Rpt(murl){var url;   url="../"+murl;   LlamarURL(url);}
</script>
</head>
<?
$formato_presup = "XX-XX-XX-XXX-XX-XX-XX";
$formato_categoria = "XX-XX-XX";
$formato_partida = "XXX-XX-XX-XX";
$sql = "Select * from SIA005 where campo501='05'";
$resultado = pg_query($sql);
if ($registro = pg_fetch_array($resultado, 0)) {
  $titulo = $registro["campo525"];
  $formato_presup = $registro["campo504"];
  $formato_categoria = $registro["campo526"];
  $formato_partida = $registro["campo527"];
}
$l = strlen($formato_presup);
$c = strlen($formato_categoria) + 2;
$p = strlen($formato_partida);

$sql = "Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001 where (substring(cod_presup from " . $c . " for 3)='401') and  (length(Cod_Presup)=" . $l . ")";
$resultado = pg_query($sql);
if ($registro = pg_fetch_array($resultado, 0)) {
  $cod_presup_d = $registro["min_cod_presup"];
  $cod_presup_h = $registro["max_cod_presup"];
}
$sql = "SELECT min(cod_fuente_financ) as min_fuente, max(cod_fuente_financ) as max_fuente  from pre095";
$resultado = pg_query($sql);
if ($registro = pg_fetch_array($resultado, 0)) {
  $cod_fuente_d = $registro["min_fuente"];
  $cod_fuente_h = $registro["max_fuente"];
}
$sql = "Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_d'";
$resultado = pg_query($sql);
if ($registro = pg_fetch_array($resultado, 0)) {
  $des_fuente_d = $registro["des_fuente_financ"];
}
$sql = "Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_h'";
$resultado = pg_query($sql);
if ($registro = pg_fetch_array($resultado, 0)) {
  $des_fuente_h = $registro["des_fuente_financ"];
}
?>

<body>
  <table width="978" height="38" border="0" bgcolor="#000066">
    <tr>
      <td width="73">
        <div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div>
      </td>
      <td width="836">
        <div align="center" class="Estilo2 Estilo6">REPORTE DISPONIBILIDAD DIARIA </div>
      </td>
      <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
    </tr>
  </table>
  <table width="978" height="442" border="1" id="tablacuerpo">
    <tr>
      <td width="965" height="436">
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
        <div id="Layer1" style="position:absolute; width:956px; height:414px; z-index:1; top: 71px; left: 16px;">
          <form name="form1" method="get">
            <table width="950" height="408" border="0">
              <tr>
                <td width="958" height="404" align="center" valign="top">
                  <table width="916" height="400" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="830" height="18">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="19">
                        <table width="884" border="0">
                          <tr>
                            <td width="244" height="26">
                              <div align="right"> </div>
                            </td>
                            <td width="358"><span class="Estilo15"><? echo $titulo; ?></span></td>
                            <td width="268"><span class="Estilo15"><? echo $titulo; ?></span></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td height="30">
                        <table width="915" border="0">
                          <tr>
                            <td width="245" height="26"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DESDE :
                              </span></td>
                            <td width="201"><span class="Estilo5"><input class="Estilo10" name="txtcod_presupd"
                                  type="text" id="txtcod_presupd" size="35" maxlength="32" onFocus="encender(this); "
                                  onBlur="apagar(this);" value="<? echo $cod_presup_d ?>"> </span></td>
                            <td width="90"><span class="Estilo5"> <input class="Estilo10" name="btCodPre" type="button"
                                  id="btCodPre" title="Abrir Catalogo C&oacute;digos Presupuestarios"
                                  onClick="VentanaCentrada('../Cat_codigos_presupd.php?criterio=','SIA','','750','500','true')"
                                  value="..."> </span></td>
                            <td width="55"><span class="Estilo5">HASTA : </span></td>
                            <td width="206"><span class="Estilo5"><input class="Estilo10" name="txtcod_presuph"
                                  type="text" id="txtcod_presuph" size="35" maxlength="32" onFocus="encender(this); "
                                  onBlur="apagar(this);" value="<? echo $cod_presup_h ?>"></span></td>
                            <td width="92"><span class="Estilo5"><input class="Estilo10" name="btCodPre2" type="button"
                                  id="btCodPre2" title="Abrir Catalogo C&oacute;digos Presupuestarios"
                                  onClick="VentanaCentrada('../Cat_codigos_presuph.php?criterio=','SIA','','750','500','true')"
                                  value="..."> </span></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td height="19">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="19">
                        <table width="827" border="0">
                          <tr>
                            <td width="244" height="26"><span class="Estilo5">FUENTE DE FINANCIAMIENTO DESDE : </span>
                            </td>
                            <td width="48"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuented"
                                  type="text" id="txtcod_fuented" value="<? echo $cod_fuente_d ?>"
                                  onFocus="encender(this)" onBlur="apagar(this)" maxlength="2" size="5"> </span></td>
                            <td width="47"><span class="Estilo5"><input class="Estilo10" name="btfuente" type="button"
                                  id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento"
                                  onClick="VentanaCentrada('../Cat_fuentesd.php?criterio=','SIA','','750','500','true')"
                                  value="..."> </span></td>
                            <td width="470"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuented"
                                  type="text" id="txtdes_fuented" size="90" maxlength="90"
                                  value="<? echo $des_fuente_d ?>" readonly></span></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td height="19">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="19">
                        <table width="890" border="0">
                          <tr>
                            <td width="152" height="26"></td>
                            <td width="86"><span class="Estilo5">HASTA : </span></td>
                            <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuenteh"
                                  type="text" id="txtcod_fuenteh" value="<? echo $cod_fuente_h ?>"
                                  onFocus="encender(this)" onBlur="apagar(this)" maxlength="2" size="5"> </span></td>
                            <td width="47"><span class="Estilo5"><input class="Estilo10" name="btfuente2" type="button"
                                  id="btfuente2" title="Abrir Catalogo Fuentes de Financiamiento"
                                  onClick="VentanaCentrada('../Cat_fuentesh.php?criterio=','SIA','','750','500','true')"
                                  value="..."></span></td>
                            <td width="530"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuenteh"
                                  type="text" id="txtdes_fuenteh" size="90" maxlength="60"
                                  value="<? echo $des_fuente_h ?>" readonly></span></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td height="19">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="19">
                        <table width="492" border="0">
                          <tr>
                            <td width="88" height="26"></td>
                            <td width="150"><span class="Estilo5">FECHA PROCESO : </span> </td>
                            <td width="240"><span class="Estilo5"><input class="Estilo10" name="txtFechad" type="text"
                                  id="txtFechad" readonly value="<? echo $fecha_hoy ?>" size="12" maxlength="10"> </span>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td height="19">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="19">
                        <table width="890" border="0">
                          <tr>
                            <td width="240" align="left" class="Estilo5">TIPO SALIDA DEL REPORTE :</td>
                            <td width="650" align="left"><span class="Estilo5"><select class="Estilo10" name="tipo_rpt"
                                  id="tipo_rpt">
                                  <option value='HTML'>FORMATO HTML</option>
                                  <option value='PDF'>FORMATO PDF</option>
                                </select></span></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <script language="JavaScript"
                      type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>

                    <tr>
                      <td height="19">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="59">
                        <table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr align="center" valign="middle">
                            <td>
                              <div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR"
                                  onClick="javascript:Llama_Rpt_Disp_Diaria('Rpt_Disponibilidad_Diari.php');"> </div>
                            </td>
                            <td>
                              <div align="center"><input name="btcancelar" type="button" id="btcancelar"
                                  value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"> </div>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td height="18">&nbsp;</td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </form>
        </div>
      </td>
    </tr>
  </table>
</body>

</html>

<? pg_close(); ?>