<?include ("../../class/seguridad.inc");?>
<?include ("../../class/conects.php");  include ("../../class/funciones.php"); ?>
<?php include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 $cod_presup_d="";  $cod_presup_h="zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz"; 
 $cod_fuente_d="";  $cod_fuente_h="zz"; $des_fuente_d=""; $des_fuente_h="";$tipo_deuda="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIACONTABILIDAD PRESUPUESTARIA (Reporte Ejecucion Presupuestaria por Partida y Niveles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">

function Llama_Rpt_presup_partida_nive(murl){var url;var r;var tip;
  if(document.form1.optipo[0].checked==true){tip="CO";}
  if(document.form1.optipo[1].checked==true){tip="CA";}
  r=confirm("Desea Generar el Reporte Ejecucion Presupuestaria por Partida y Niveles?");
  if (r==true) {
    url=murl+"?cod_presup_d="+document.form1.txtcod_presupd.value+"&cod_presup_h="+document.form1.txtcod_presuph.value+"&cod_fuente_d="+document.form1.txtcod_fuented.value+"&cod_fuente_h="+document.form1.txtcod_fuenteh.value+"&tipo_deuda="+tip;
        window.open(url);
  }
}

function Llama_Menu_Rpt(murl){var url;   url="../"+murl; LlamarURL(url);}
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
.Estilo12 {font-size: 12px}
.Estilo15 {font-size: 8pt; font-weight: bold; }
-->
</style>
</head>
<?$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"];}
$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_presup_d=$registro["min_cod_presup"];  $cod_presup_h=$registro["max_cod_presup"];}
$sql="SELECT min(cod_fuente_financ) as min_fuente, max(cod_fuente_financ) as max_fuente  from pre095"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_fuente_d=$registro["min_fuente"];  $cod_fuente_h=$registro["max_fuente"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_d'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_d=$registro["des_fuente_financ"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_h'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_h=$registro["des_fuente_financ"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE EJECUCI&Oacute;N PRESUPUESTARIA POR PARTIDA Y NIVELES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="674" border="1" id="tablacuerpo">
  <tr>
    <td width="965" height="668">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:644px; z-index:1; top: 71px; left: 16px;">
        <form name="form1" method="get">
           <table width="950" height="637" border="0">
    <tr>
      <td width="958" height="633" align="center" valign="top"><table width="830" height="488" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="766" border="0">
            <tr>
              <td width="325" height="26"><div align="right"> </div></td>
              <td width="223"><span class="Estilo15"><?echo $titulo?></span></td>
              <td width="204">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30" colspan="2"><table width="813" border="0">
            <tr>
              <td width="326" height="26">
                <div align="left">C&Oacute;DIGO PRESUPUESTARIO DESDE : </div></td>
              <td width="221"><span class="Estilo12"><span class="Estilo5">
                <input name="txtcod_presupd" type="text" id="txtcod_presupd" size="35" maxlength="32"  value="<?echo $cod_presup_d?>" onFocus="encender(this); " onBlur="apagar(this);">
              </span></span></td>
              <td width="252"><span class="Estilo5">
                <input name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presupd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="766" border="0">
            <tr>
              <td width="325" height="26"><div align="right"> </div></td>
              <td width="223"><span class="Estilo15"><?echo $titulo?></span></td>
              <td width="204">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30" colspan="2"><table width="827" border="0">
            <tr>
              <td width="223" height="26">
                <div align="left"></div></td>
              <td width="98">HASTA :</td>
              <td width="222"><span class="Estilo12"><span class="Estilo5">
                <input name="txtcod_presuph" type="text" id="txtcod_presuph" size="35" maxlength="32"  value="<?echo $cod_presup_h?>" onFocus="encender(this); " onBlur="apagar(this);">
              </span></span></td>
              <td width="266"><span class="Estilo5">
                <input name="btCodPre2" type="button" id="btCodPre2" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presuph.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="827" border="0">
            <tr>
              <td width="321" height="26">
                <div align="left">FUENTE DE FINANCIAMIENTO DESDE : </div></td>
              <td width="62"><span class="Estilo5">
                <input name="txtcod_fuented" type="text" id="txtcod_fuented" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="2" value="<?echo $cod_fuente_d?>">
              </span></td>
              <td width="45"><span class="Estilo5">
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="381"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdes_fuented" type="text" id="txtdes_fuented" size="50" maxlength="50" readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="828" border="0">
            <tr>
              <td width="243" height="26">
                <div align="left"></div></td>
              <td width="75">HASTA : </td>
              <td width="61"><span class="Estilo5">
                <input name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="2" value="<?echo $cod_fuente_h?>">
              </span></td>
              <td width="46"><span class="Estilo5">
                <input name="btfuente2" type="button" id="btfuente7" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesh.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="381"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdes_fuenteh" type="text" id="txtdes_fuenteh" size="50" maxlength="50" readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="828" border="0">
            <tr>
              <td width="203" height="26">
                <div align="left"></div></td>
              <td width="115">MES HASTA  : </td>
              <td width="160"><span class="Estilo5">
                <select name="select">
                  <option>ENERO</option>
                  <option>FEBRERO</option>
                  <option>MARZO</option>
                  <option>ABRIL</option>
                  <option>MAYO</option>
                  <option>JUNIO</option>
                  <option>JULIO</option>
                  <option>AGOSTO</option>
                  <option>SEPTIEMBRE</option>
                  <option>OCTUBRE</option>
                  <option>NOVIEMBRE</option>
                  <option>DICIEMBRE</option>
                </select>
</span></td>
              <td width="74">&nbsp;</td>
              <td width="254"><span class="Estilo12"><span class="Estilo5">                </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="827" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="9">&nbsp;</td>
              <td width="10">&nbsp;</td>
              <td width="15">&nbsp;</td>
              <td width="380">ASIGNACI&Oacute;N GLOBAL </td>
              <td width="397">SUB TOTAL POR PARTIDAS </td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="765" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="59" height="32">&nbsp;</td>
              <td width="408"><table width="115" height="30" border="1">
                <tr>
                  <td width="111" valign="top"><label>
                    <input name="opimprimir" type="radio" value="S">
      SI </label>
                      <label>
                      <input name="opimprimir" type="radio" value="N" checked>
      NO </label></td>
                </tr>
              </table></td>
              <td width="288"><table width="115" height="30" border="1">
                <tr>
                  <td width="111" valign="top"><label>
                    <input name="opimprimir" type="radio" value="S">
      SI </label>
                      <label>
                      <input name="opimprimir" type="radio" value="N" checked>
      NO </label></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="34" height="19">&nbsp;</td>
          <td width="796">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="827" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="46">&nbsp;</td>
              <td width="404">TAMA&Ntilde;O DEL PAPEL </td>
              <td width="367">DEUDA EN BASE A</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="34" colspan="2"><table width="829" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="10" height="32">&nbsp;</td>
              <td width="389"><table width="247" height="30" border="1">
                <tr>
                  <td width="237" valign="top"><label>
                    <input name="opimprimir" type="radio" value="S">
      EXTRAOFICIO</label>
                      <label>
                      <input name="opimprimir" type="radio" value="N" checked>
      CARTA</label></td>
                </tr>
              </table></td>
              <td width="420"><table width="264" height="30" border="1">
                <tr>
                  <td width="335" valign="top"><label>
                    <input name="optipo" type="radio" value="CO">
      COMPROMISO</label>
                      <label>
                      <input name="optipo" type="radio" value="CA" checked>
      CAUSADO</label></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="91" colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_presup_partida_nive('Rpt_presup_partida_nive.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="2">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
    </div>    </td>
</tr>
</table>
</body>
</html>

<? pg_close();?>
