<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 $periodod='01';
 $periodoh='01';
 $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);
 $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
 $cod_cuenta_d="";
 $cod_cuenta_h="zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz";
 $tipo_asiento_d="";
 $tipo_asiento_h="zzz";
 $salto_pag="S";
 $ordenar="S";
 $imprimir="N";
 $vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Reporte Notificaci&oacute;n de Tributos)</title>
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
function checkrefechad(mform){
var mref;
var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){
var mref;
var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtFechah.value=mfec;}
return true;}

function Llama_Rpt_Mayor_Analitico(murl){
var url;
var r;
var imp;
var saltopag;
var ord;
  if(document.form1.opsaltopag[0].checked==true){saltopag="S";}
  if(document.form1.opsaltopag[1].checked==true){saltopag="N";}
  if(document.form1.opordenar[0].checked==true){ord="S";}
  if(document.form1.opordenar[1].checked==true){ord="N";}
  if(document.form1.opimprimir[0].checked==true){imp="S";}
  if(document.form1.opimprimir[1].checked==true){imp="N";}
  r=confirm("Desea Generar el Reporte Mayor Analitico ?");
  if (r==true) {
    url=murl+"?periodod="+document.form1.txtperiodod.value+"&periodoh="+document.form1.txtperiodoh.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&cod_cuenta_d="+document.form1.txtCodigo_Cuenta_D.value+"&cod_cuenta_h="+document.form1.txtCodigo_Cuenta_H.value+"&tipo_asiento_d="+document.form1.txtTipo_Asientod.value+"&tipo_asiento_h="+document.form1.txtTipo_Asientoh.value+"&salto_pag="+saltopag+"&ordenar="+ord+"&imprimir="+imp;
    LlamarURL(url);
  }
}

function Llama_Menu_Rpt(murl){
var url;
   url="../"+murl;
   LlamarURL(url);
}

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
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE NOTIFICACI&Oacute;N DE TRIBUTOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="484" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="478">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:454px; z-index:1; top: 73px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="451" border="0">
    <tr>
      <td width="958" height="447" align="center" valign="top"><table width="783" height="440" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="783" height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="207" height="26">
                <div align="left">NUMERO DE ORDEN   : </div></td>
              <td width="559"><span class="Estilo5">
                <input name="txtcod_banco_d5" type="text" id="txtcod_banco_d5" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="776" border="0">
            <tr>
              <td width="222" height="26">
                <div align="left">BENEFICIARIO : </div></td>
              <td width="104"><span class="Estilo5">
                <input name="txtnro_orden" type="text"  id="txtnro_orden"  size="15" maxlength="15" readonly>
              </span></td>
              <td width="436"><span class="Estilo5">
                <input name="txtnro_orden2" type="text"  id="txtnro_orden2"  size="65" readonly>
              </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="211" height="26">
                <div align="left">FECHA ORDEN  : </div></td>
              <td width="172"><span class="Estilo5">
                <input name="txtnro_orden3" type="text"  id="txtnro_orden3"  size="10" maxlength="10" readonly>
              </span></td>
              <td width="150">MONTO ORDEN : </td>
              <td width="225"><span class="Estilo5">
                <input name="txtnro_orden32" type="text"  id="txtnro_orden32"  size="12" maxlength="12" readonly>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="22"><table width="771" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="214" align="center"><div align="left">FECHA DE EMISI&Oacute;N : </div></td>
              <td width="127" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="307" align="center">
                <div align="left">N&Uacute;MERO DEL CONTRATO/SERVICIO : </div></td>
              <td width="123" align="center"><span class="Estilo5">
                <input name="txtcod_banco_d53" type="text" id="txtcod_banco_d54" onFocus="encender(this)" onBlur="apagar(this)"  size="15" maxlength="15">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="753" border="0">
            <tr>
              <td width="213" height="26">
                <div align="left">N&Uacute;MERO DE FACTURA  : </div></td>
              <td width="161"><span class="Estilo5">
                <input name="txtcod_banco_d52" type="text" id="txtcod_banco_d52" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15">
              </span></td>
              <td width="154">MONTO SIN IVA :              </td>
              <td width="207"><span class="Estilo5">
                <input name="txtcod_banco_d2422" type="text" id="txtcod_banco_d2422" onFocus="encender(this)" onBlur="apagar(this)"  size="15" maxlength="15">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="18"><table width="384" border="0">
            <tr>
              <td width="215" height="26">
                <div align="left">MONTO DEL TRIBUTO  : </div></td>
              <td width="159"><span class="Estilo5">
                <input name="txtcod_banco_d522" type="text" id="txtcod_banco_d522" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15">
              </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="384" border="0">
            <tr>
              <td width="217" height="26">
                <div align="left">VALUACI&Oacute;N : </div></td>
              <td width="157"><span class="Estilo5">
                <input name="txtcod_banco_d5222" type="text" id="txtcod_banco_d5222" onFocus="encender(this)" onBlur="apagar(this)"  size="15" maxlength="15">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="89"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Mayor_Analitico('Rpt_Mayor_A.php');">
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
