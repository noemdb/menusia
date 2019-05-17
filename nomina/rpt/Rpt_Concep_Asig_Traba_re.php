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
<title>SIA N&Oacute;MINA Y PERSONAL (Reporte Mayor Analitico)</title>
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
-->
</style>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE MAYOR ANALITICO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="507" border="1" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:478px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="471" border="0">
    <tr>
      <td width="958" height="283" align="center" valign="top"><table width="783" height="262" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="783" height="18" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="60"><table width="783" border="0">
            <tr>
              <td width="209"><div align="right">                 CUENTA DESDE: </div></td>
              <td width="212"><span class="Estilo5">
                <input name="txtCodigo_Cuenta_D" type="text" id="txtCodigo_Cuenta_D" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cuenta_d?>" size="32" maxlength="32">
              </span></td>
              <td width="34"><span class="Estilo5">
                <input name="Catalogo3" type="button" id="Catalogo32" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="63">HASTA:</td>
              <td width="199"><span class="Estilo5">
                <input name="txtCodigo_Cuenta_H" type="text" id="txtCodigo_Cuenta_H" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cuenta_h?>" size="32" maxlength="32">
              </span></td>
              <td width="40"><span class="Estilo5">
              <input name="Catalogo4" type="button" id="Catalogo43" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesh.php?criterio=','SIA','','750','500','true')" value="...">
</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="24"><div align="center">
              <table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="191" align="center"><div align="right">TIPO ASIENTO DESDE: </div></td>
                  <td width="261" align="center">
                    <div align="left"><span class="Estilo5">
                      <input name="txtTipo_Asientod" type="text" id="txttipo_asientod" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_asiento_d?>" size="12" maxlength="3">
                      <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo Tipos de Asientos" onclick="VentanaCentrada('../Cat_tipo_asientod.php?criterio=','SIA','','650','500','true')" value="...">
                  </span></div></td>
                  <td width="67" align="center"><div align="left">HASTA:</div></td>
                  <td width="264" align="center">
                    <div align="left"><span class="Estilo5">
                      <input name="txtTipo_Asientoh" type="text" id="txttipo_asientoh" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_asiento_h?>" size="12" maxlength="3">
                      <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo Tipos de Asientos" onclick="VentanaCentrada('../Cat_tipo_asientoh.php?criterio=','SIA','','650','500','true')" value="...">
                  </span></div></td>
                </tr>
              </table>
          </div></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        <tr>
          <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Mayor_Analitico('Rpt_Mayor_A.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('Menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="38">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>

<? pg_close();?>
