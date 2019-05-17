<?include ("../../class/seguridad.inc");?>
<?include ("../../class/funciones.php");?>
<?php include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 $cod_presup_d="";  $cod_presup_h="zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz"; 
 $cod_fuente_d="";  $cod_fuente_h="zz"; $des_fuente_d=""; $des_fuente_h="";
 $vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte Financiera)</title>
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
-->
</style>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE EJECUCI&Oacute;N FINANCIERA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="609" border="1" id="tablacuerpo">
  <tr>
    <td width="965" height="603">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:575px; z-index:1; top: 71px; left: 16px;">
        <form name="form1" method="get">
           <table width="950" height="554" border="0">
    <tr>
      <td width="958" height="550" align="center" valign="top"><table width="830" height="484" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="766" border="0">
            <tr>
              <td width="294" height="26"><div align="right"> </div></td>
              <td width="254"><span class="Estilo15">SE-PR-AC-PAR-GE-ES-SE</span></td>
              <td width="204">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30" colspan="2"><table width="813" border="0">
            <tr>
              <td width="298" height="26">                <div align="left">C&Oacute;DIGO PRESUPUESTARIO DESDE : </div></td><td width="149"><span class="Estilo12"><span class="Estilo5">
                <input name="txtFechad22" type="text" id="txtFechad22" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="22" maxlength="22" onChange="checkrefechad(this.form)">
              </span></span></td>
              <td width="352"><span class="Estilo5">
                <input name="Catalogo32222" type="button" id="Catalogo32222" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIA','','750','500','true')" value="...">
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
              <td width="294" height="26"><div align="right"> </div></td>
              <td width="254"><span class="Estilo15">SE-PR-AC-PAR-GE-ES-SE</span></td>
              <td width="204">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30" colspan="2"><table width="815" border="0">
            <tr>
              <td width="229" height="26">
                <div align="left"></div></td>
              <td width="73">HASTA :</td>
              <td width="148"><span class="Estilo12"><span class="Estilo5">
                <input name="txtFechad222" type="text" id="txtFechad222" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="22" maxlength="22" onChange="checkrefechad(this.form)">
              </span></span></td>
              <td width="347"><span class="Estilo5">
                <input name="Catalogo322222" type="button" id="Catalogo322222" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIA','','750','500','true')" value="...">
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
                <div align="left">FUENTE DE FINANCIAMIENTO  DESDE : </div></td>
              <td width="62"><span class="Estilo5">
                <input name="txtced_rif_benef_d2" type="text" id="txtced_rif_benef_d2" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $ced_rif_benef_d?>" size="5" maxlength="5">
              </span></td>
              <td width="45"><span class="Estilo5">
                <input name="Catalogo3223" type="button" id="Catalogo322" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="381"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesc_ced_rif_benef_d2" type="text" id="txtdesc_ced_rif_benef_d" size="50" maxlength="50"  value="C&Oacute;DIGO PRESUPUESTARIO" readonly>
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
                <input name="txtced_rif_benef_d222" type="text" id="txtced_rif_benef_d222" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $ced_rif_benef_d?>" size="5" maxlength="5">
              </span></td>
              <td width="46"><span class="Estilo5">
                <input name="Catalogo322322" type="button" id="Catalogo322322" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="381"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesc_ced_rif_benef_d222" type="text" id="txtdesc_ced_rif_benef_d222" size="50" maxlength="50"  value="C&Oacute;DIGO PRESUPUESTARIO" readonly>
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
              <td width="115">TRIMESTRE  : </td>
              <td width="160"><span class="Estilo5">
                <select name="select">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
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
          <td height="30" colspan="2"><table width="824" border="0">
            <tr>
              <td width="226" height="26">NOMBRE DEL PROGRAMA  : </td>
              <td width="588"><span class="Estilo5">
                <input name="txtced_rif_benef_d2222" type="text" id="txtced_rif_benef_d2222" onFocus="encender(this)" onBlur="apagar(this)" size="85" maxlength="85">
              </span></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="827" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="24">&nbsp;</td>
              <td width="31">&nbsp;</td>
              <td width="444"><strong>SE-PR-AC-PAR-GE-ES-SE</strong></td>
              <td width="315">UTILIZAR</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="829" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="25" height="32">&nbsp;</td>
              <td width="66">&nbsp;</td>
              <td width="357">1_2_3_4_5_6_7</td>
              <td width="368"><table width="196" height="30" border="1">
                <tr>
                  <td width="206" valign="top"><label>
                    <input name="opimprimir" type="radio" value="S">
      PAGO</label>
                      <label>
                      <input name="opimprimir" type="radio" value="N" checked>
      CAUSADO</label></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="61" height="19">&nbsp;</td>
          <td width="769"><table width="201" height="30" border="1">
            <tr>
              <td width="191" valign="top"><label> TOTAL AL NIVEL : </label>
                  <label><span class="Estilo5">
                  <input name="txtced_rif_benef_d22222" type="text" id="txtced_rif_benef_d22222" onFocus="encender(this)" onBlur="apagar(this)" value="1" size="1" maxlength="1">
                </span></label></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="91" colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
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
