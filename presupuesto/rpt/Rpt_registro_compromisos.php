<?include ("../../class/seguridad.inc");?>
<?include ("../../class/funciones.php");?>
<?php include ("../../class/configura.inc");
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
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte Registros de Compromisos)</title>
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
.Estilo15 {font-size: 8pt; font-weight: bold; }
.Estilo17 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE REGISTRO DE COMPROMISOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="316" border="1" id="tablacuerpo">
  <tr>
    <td width="992" height="310">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:952px; height:285px; z-index:1; top: 79px; left: 30px;">
        <form name="form1" method="get">
           <table width="950" height="275" border="0">
    <tr>
      <td width="958" height="222" align="center" valign="top"><table width="830" height="262" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="61" height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="829" border="0">
            <tr>
              <td width="134" height="26"><div align="right"> </div></td>
              <td width="349"><span class="Estilo17">DESDE</span></td>
              <td width="332"><span class="Estilo17">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
              <td width="135" height="26">
                <div align="right">REFERENCIA : </div></td>
              <td width="239"><span class="Estilo12"><span class="Estilo5">
                <input name="txtcodbancoh36" type="text" id="txtcodbancoh36" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_h?>" size="10" maxlength="10">
              </span></span></td>
              <td width="99"><span class="Estilo5">              </span></td>
              <td width="294"><span class="Estilo12"><span class="Estilo5">
                <input name="txtcodbancoh362" type="text" id="txtcodbancoh362" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_h?>" size="10" maxlength="10">
              </span></span></td>
              <td width="38"><span class="Estilo5">              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="827" border="0">
            <tr>
              <td width="136" height="26">
                <div align="right">DOCUMENTO : </div></td>
              <td width="238"><span class="Estilo12"><span class="Estilo5">
                <input name="txtcodbancoh363" type="text" id="txtcodbancoh363" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_h?>" size="10" maxlength="10">
              </span></span></td>
              <td width="99"><span class="Estilo5"> </span></td>
              <td width="294"><span class="Estilo12"><span class="Estilo5">
                <input name="txtcodbancoh3622" type="text" id="txtcodbancoh3622" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_h?>" size="10" maxlength="10">
              </span></span></td>
              <td width="38"><span class="Estilo5"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
              <td width="136" height="26">
                <div align="right">FECHA  : </div></td>
              <td width="238"><span class="Estilo12"><span class="Estilo5">
                <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="12" onChange="checkrefechad(this.form)">
                <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></span></td>
              <td width="211"><span class="Estilo5"> </span></td>
              <td width="197"><span class="Estilo12"><span class="Estilo5">                </span></span></td>
              <td width="23"><span class="Estilo5"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="59"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
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
          <td height="18">&nbsp;</td>
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