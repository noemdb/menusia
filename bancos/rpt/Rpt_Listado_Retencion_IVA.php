<?php include ("../../class/seguridad.inc");?>
<?php include ("../../class/funciones.php");?>
<?php include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$num_comprobante_d="00000000";$num_comprobante_h="99999999";$cedula_d="";$cedula_h="";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Reporte Listado Retenci&oacute;n IVA)</title>
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
function Llama_Rpt_Listado_Retencion(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Listado Retencion IVA?");
  if (r==true){url=murl+"?fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&num_comprobante_d="+document.form1.txtnum_comprobante_d.value+"&num_comprobante_h="+document.form1.txtnum_comprobante_h.value+"&cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value;
  window.open(url,"Reporte Listado Retencion IVA")}
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
-->
</style>
</head>
<?php 
$sql="SELECT MAX(Cod_Banco) As Max_Cod_Banco, MIN(Cod_Banco) As Min_Cod_Banco FROM BAN002";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cod_banco_d=$registro["min_cod_banco"];$cod_banco_h=$registro["max_cod_banco"];}

$sql="SELECT MAX(Ced_Rif) As Max_Ced_Rif, MIN(Ced_Rif) As Min_Ced_Rif FROM PRE099";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO RETENCI&Oacute;N IVA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="979" height="373" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="307">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:965px; height:365px; z-index:1; top: 66px; left: 17px;">
        <form name="form1" method="get">
           <table width="950" height="274" border="0">
    <tr>
      <td width="958" height="270" align="center" valign="top"><table width="883" height="217" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="4" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="34"><div align="center"></div>            <div align="center"></div></td>
          <td height="34"><div align="center"><strong>DESDE</strong></div></td>
          <td height="34"><strong>HASTA</strong></td>
          <td height="34">&nbsp;</td>
          <td width="6" height="34">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="4" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="4" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="203" height="26">
                <div align="left">FECHA</div></td>
              <td width="155" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="81" align="center"><div align="left"><span class="Estilo5">
                <input name="txtFechah" type="text" id="txtFechah2" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
              </span></div></td>
              <td width="319" align="center">
                <div align="left"><span class="Estilo5">                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="4"><table width="782" border="0">
            <tr>
              <td width="256" height="26"><p align="left">Nro. COMPROBANTE  :</p></td>
              <td width="156"><span class="Estilo5">
                <input name="txtnum_comprobante_d" type="text" id="txtnum_comprobante_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $num_comprobante_d?>" size="15" maxlength="15">
              </span></td>
              <td width="97"><span class="Estilo5">
                <input name="txtnum_comprobante_h" type="text" id="txtnum_comprobante_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $num_comprobante_h?>" size="15" maxlength="15">
              </span></td>
              <td width="255"><span class="Estilo5">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="22" colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td width="263" height="19">CEDULA/RIF BENEFICIARIO:</td>
          <td width="161"><span class="Estilo5">
            <input name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_d?>" size="15" maxlength="15">
            <input name="Catalogo322" type="button" id="Catalogo3225" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Beneficiariosd.php?criterio=','SIPAP','','750','500','true')" value="...">
</span></td>
          <td width="327"><span class="Estilo5"><span class="Estilo12">
            <input name="txtdesccedrifbenefd" type="text" id="txtdesc_ced_rif_benef_d" size="41" maxlength="15"   readonly>
          </span>
          </span></td>
        </tr>
        <tr>
          <td height="19" colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td height="19">CEDULA/RIF BENEFICIARIO:</td>
          <td width="161" height="19"><span class="Estilo5">
            <input name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_h?>" size="15" maxlength="15">
            <input name="Catalogo3222" type="button" id="Catalogo3222" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Beneficiariosh.php?criterio=','SIPAP','','750','500','true')" value="...">
</span></td>
          <td width="327"><span class="Estilo12"><span class="Estilo5">
            <input name="txtdesccedrifbenefh" type="text" id="txtdesccedrifbenefh" size="41" maxlength="41"  readonly>
          </span></span></td>
          <td width="126">&nbsp;</td>
        <tr>
          <td height="19" colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="5"><table width="776" border="0">
            <tr>

            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="4"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Listado_Retencion('Rpt_Listado_Retencion.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="4">&nbsp;</td>
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
