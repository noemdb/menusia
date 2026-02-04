<?php include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
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
<title>SIPAP CONTROL BANCARIO (Reporte Planillas de Retenci&oacute;n)</title>
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
-->
</style>
</head>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE PLANILLAS DE RETENCI&Oacute;N </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="561" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="555">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:533px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="461" border="0">
    <tr>
      <td width="958" height="457" align="center" valign="top"><table width="783" height="503" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="783" height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="201" height="26"> <div align="left">TIPO PLANILLA DESDE : </div></td><td width="292"><span class="Estilo5">
                <span class="Estilo12">
                <input name="txtcod_planilla_ret_d" type="text" id="txtcod_planilla_ret_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_planilla_ret_d?>" size="15" maxlength="15">
                </span>              </span></td>
              <td width="76">HASTA : </td>
              <td width="189"><span class="Estilo12"><span class="Estilo5">
              <input name="txtcod_planilla_ret_h" type="text" id="txtcod_planilla_ret_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_planilla_ret_h?>" size="15" maxlength="15">
</span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="197" height="26"> <div align="left">Nro. PLANILLA DESDE : </div></td><td width="299"><span class="Estilo5">
                <input name="txtnum_planilla_ret_d" type="text" id="txtnum_planilla_ret_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $num_planilla_ret_d?>" size="15" maxlength="15">
              </span></td>
              <td width="76">HASTA : </td>
              <td width="186"><span class="Estilo12"><span class="Estilo5">
                <input name="txtnum_planilla_ret_h" type="text" id="txtnum_planilla_ret_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $num_planilla_ret_h?>" size="15" maxlength="15">
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="776" border="0">
            <tr>
              <td width="239" height="26">
                <div align="left">C&Oacute;DIGO DE BANCO DESDE : </div></td>
              <td width="46"><span class="Estilo5">
                <input name="txtcod_banco_d" type="text" id="txtcod_banco_d2" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_banco_d?>" size="5" maxlength="32">
              </span></td>
              <td width="48"><span class="Estilo5">
                <input name="Catalogo3" type="button" id="Catalogo32" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="425"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesc_banco_d" type="text" id="txtcod_titulo22" size="60" maxlength="60"  value="<?php echo $desc_banco_d?>" readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="240" height="26">
                <div align="left">C&Oacute;DIGO DE BANCO HASTA : </div></td>
              <td width="46"><span class="Estilo5">
                <input name="txtcod_banco_h" type="text" id="txtcod_banco_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_banco_h?>" size="5" maxlength="32">
              </span></td>
              <td width="46"><span class="Estilo5">
                <input name="Catalogo32" type="button" id="Catalogo323" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="426"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesc_banco_h" type="text" id="txtDesc_Banco_D" size="60" maxlength="60"  value="<?php echo $desc_banco_h?>" readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="261" height="26">
                <div align="left">TIPO DE MOVIMIENTO DESDE : </div></td>
              <td width="49"><span class="Estilo5">
                <input name="txttipo_mov_d" type="text" id="txttipo_mov_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_mov_d?>" size="5" maxlength="32">
              </span></td>
              <td width="40"><span class="Estilo5">
                <input name="Catalogo33" type="button" id="Catalogo333" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="408"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesc_tipo_Mov_d" type="text" id="txtdesc_tipo_Mov_d" size="59" maxlength="58"  value="<?php echo $desc_tipo_mov_d?>" readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="261" height="26">
                <div align="left">TIPO DE MOVIMIENTO HASTA : </div></td>
              <td width="46"><span class="Estilo5">
                <input name="txttipo_mov_h" type="text" id="txttipo_mov_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_mov_h?>" size="5" maxlength="32">
              </span></td>
              <td width="44"><span class="Estilo5">
                <input name="Catalogo332" type="button" id="Catalogo3322" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="407"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesc_tipo_mov_h" type="text" id="txtDesc_Tipo_Mov_D" size="59" maxlength="58"  value="<?php echo $desc_tipo_mov_h?>" readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="783" border="0">
            <tr>
              <td width="294" height="26"><p align="left">REFERENCIA MOVIMIENTO DESDE :</p></td>
              <td width="263"><span class="Estilo5">
                <input name="txtreferencia_h" type="text" id="txtreferencia_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $referencia_h?>" size="8" maxlength="8">
              </span></td>
              <td width="73">HASTA :</td>
              <td width="135"><span class="Estilo5">
                <input name="txtCodigo_Cuenta_D23" type="text" id="txtCodigo_Cuenta_D23" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_cuenta_d?>" size="12" maxlength="12">
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
              <td width="301" height="26">
                <div align="left">C&Eacute;DULA/RIF BENEFICIARIO DESDE : </div></td>
              <td width="109"><span class="Estilo5">
                <input name="txtced_rif_benef_d" type="text" id="txtced_rif_benef_d2" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $ced_rif_benef_d?>" size="15" maxlength="15">
              </span></td>
              <td width="44"><span class="Estilo5">
                <input name="Catalogo322" type="button" id="Catalogo3225" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="304"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesc_ced_rif_benef_d" type="text" id="txtdesc_ced_rif_benef_d3" size="41" maxlength="15"  value="<?php echo $desc_ced_rif_benef_d?>" readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="303" height="26">
                <div align="left">C&Eacute;DULA/RIF BENEFICIARIO HASTA : </div></td>
              <td width="107"><span class="Estilo5">
                <input name="txtced_rif_benef_h" type="text" id="txtced_rif_benef_h2" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $ced_rif_benef_h?>" size="15" maxlength="15">
              </span></td>
              <td width="41"><span class="Estilo5">
                <input name="Catalogo3222" type="button" id="Catalogo3222" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="307"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesc_ced_rif_benef_h" type="text" id="txtdesc_ced_rif_benef_h" size="41" maxlength="41"  value="<?php echo $desc_ced_rif_benef_h?>" readonly>
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
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

<?php  pg_close($conn);?>
