<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$codigo_partida_iva="403-18-01-00-00";$codigo_contable="3-1-300-01-03";$tipo="";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Reporte Relacion Orden de Pago / Asociacion Contable)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../../class/sia.css" type=text/css
rel=stylesheet>
<SCRIPT language=JavaScript
src="../../class/sia.js"
type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechah.value=mfec;}
return true;}

function Llama_Rpt_Rel_Orden_Pago_I(murl){var url;var r;var tip;
  if(document.form1.optipo[0].checked==true){tip="G";}
  if(document.form1.optipo[1].checked==true){tip="C";}
  if(document.form1.optipo[2].checked==true){tip="T";}
  r=confirm("Desea Generar el Reporte Relacion Ordenes de Pago/ IVA");
  if (r==true) {url=murl+"?fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&codigo_partida_iva="+document.form1.txtcod_partida.value+"&codigo_contable="+document.form1.txtcod_contable.value+"&tipo="+tip;
  window.open(url,"Reporte Relacion Ordenes de Pago/ IVA")}
}

function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
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
.Estilo13 {
        color: #0000FF;
        font-weight: bold;
}
-->
</style>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="45"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE RELACION ORDENES DE PAGO / IVA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="403" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="397">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:375px; z-index:1; top: 73px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="369" border="0">
    <tr>
      <td width="958" height="365" align="center" valign="top"><table width="783" height="353" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="783" height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16"><table width="757" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="263">&nbsp;</td>
              <td width="151"><span class="Estilo13">DESDE</span></td>
              <td width="343"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="771" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="264" align="center"><div align="left">FECHA ORDENES: </div></td>
              <td width="155" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="352" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="776" border="0">
            <tr>
              <td width="266" height="26">
                <div align="left">CODIGO PARTIDA IVA: </div></td>
              <td width="245"><span class="Estilo5">
                <input name="txtcod_partida" type="text" id="txtcod_partida" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $codigo_partida_iva?>" size="30" maxlength="15" readonly>
              </span></td>
              <td width="64"><span class="Estilo5">
              </span></td>
              <td width="9"><span class="Estilo5">
              </span></td>
              <td width="170"><span class="Estilo5">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="18"><table width="776" border="0">
            <tr>
              <td width="269" height="26">
                <div align="left">CODIGO CONTABLE ASOCIADO: </div></td>
              <td width="228"><span class="Estilo5">
                <input name="txtcod_contable" type="text" id="txtcod_contable" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $codigo_contable?>" size="30" maxlength="15" readonly>
              </span></td>
              <td width="9"><span class="Estilo5"> </span></td>
              <td width="77"><span class="Estilo5">
              </span></td>
              <td width="171"><span class="Estilo5"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="18"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="390">ASOCIACI&Oacute;N:</td>
              <td width="374">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18"><table width="407" height="30" border="1">
            <tr>
              <td width="397" height="24" valign="top">
              <label>
              <input name="optipo" type="radio" value="G"  checked>
                GENERAL
              </label>
                <input name="optipo" type="radio" value="C">
                CORRIENTE
              <label>
              <input name="optipo" type="radio" value="T">
              CAPITALIZABLE
              </label></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="89"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Rel_Orden_Pago_I('Rpt_Rel_Orden_Pago_I.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
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
