<?php include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
 $periodo_fiscal='2008';
 $mes_fiscal='01';
 $num_comprobante_d="00000000";
 $num_comprobante_h="99999999";
 $cedula_d="";
 $cedula_h="";
 $vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGO (Reporte Comprobante Retenci&oacute;n IVA)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
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

function Llama_Rpt_Comprobante_Ret(murl){
var url;
var r;
  r=confirm("Desea Generar el Reporte Comprobante Retencion IVA?");
  if (r==true) {
    url=murl+"?periodo_fiscal="+document.form1.txtperiodofiscal.value+"&mes_fiscal="+document.form1.txtmesfiscal.value+
    "&num_comprobante_d"+document.form1.txtCodigo_Cuenta_d.value+"&num_comprobante_h="+document.form1.txtCodigo_Cuenta_h.value+
    "&cedula_d"+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value;
    window.open(url,"Reporte Comprobante Retencion IVA")
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
<?php 
$sql="SELECT MAX(Ced_Rif) As Max_Ced_Rif, MIN(Ced_Rif) As Min_Ced_Rif FROM PRE099";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE COMPROBANTE RETENCION IVA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="313" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="307">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:278px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="274" border="0">
    <tr>
      <td width="958" height="270" align="center" valign="top"><table width="783" height="214" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="783" height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="219" height="26"> <div align="left">PERIODO FISCAL A�O : </div></td>
              <td width="197"><span class="Estilo5">
                <input name="txtperiodofiscal" type="text" id="txtperiodofiscal" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $periodo_fiscal?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                 </span></td>
              <td width="73">MES : </td>
              <td width="269"><span class="Estilo12"><span class="Estilo5">
              <input name="txtmesfiscal" type="text" id="txtmesfiscal" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $mes_fiscal?>" size="3" maxlength="3">
</span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="782" border="0">
            <tr>
              <td width="224" height="26"><p align="left">Nro. COMPROBANTE  :</p></td>
              <td width="198"><span class="Estilo5">
                <input name="txtCodigo_Cuenta_d" type="text" id="txtCodigo_Cuenta_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $num_comprobante_d?>" size="15" maxlength="15">
              </span></td>
              <td width="72">HASTA :</td>
              <td width="270"><span class="Estilo5">
                <input name="txtCodigo_Cuenta_h" type="text" id="txtCodigo_Cuenta_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $num_comprobante_h?>" size="15" maxlength="15">
              </span></td>
            </tr>
          </table></td>
        </tr>
                <tr>
          <td height="19">&nbsp;</td>
        </tr>
                <tr>
          <td height="19"><table width="782" border="0">
            <tr>
              <td width="239" height="26">
                <div align="left">RIF BENEFICIARIO DESDE:</div></td>
              <td width="90"><span class="Estilo5">
                <input name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_d?>" size="15" maxlength="15">
              </span></td>
              <td width="88"><span class="Estilo5">
                <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Beneficiariosd.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
                          <td width="81">HASTA :</td>
              <td width="90"><span class="Estilo5">
                <input name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_h?>" size="15" maxlength="15">
              </span></td>
              <td width="168"><span class="Estilo5">
                <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Beneficiariosh.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19">&nbsp; </td>
        </tr>
        <tr>
          <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Comprobante_Ret('Rpt_Comprobante_Ret.php');">
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
    </div>
    <div align="left"></div></td>
</tr>
</table>
</body>
</html>

<?php  pg_close($conn);?>
