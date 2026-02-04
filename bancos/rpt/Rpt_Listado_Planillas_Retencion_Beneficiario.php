<?php include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$cedula_d="";$cedula_h="";$tipo_planilla_d="01";$tipo_planilla_h="99";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$clasificacion_d="";$clasificacion_h="";$tipo_bene_d="";$tipo_bene_h="";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP CONTROL BANCARIO (Reporte Listado Planillas de Retencion)</title>
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
function Llama_Rpt_Listado_Planillas_Retencion_Bene(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Listado de Planillas de Retencion por Beneficiario?");
  if (r==true) {url=murl+"?cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&tipo_planilla_d="+document.form1.txttipo_planilla_ret_d.value+"&tipo_planilla_h="+document.form1.txttipo_planilla_ret_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&clasificacion_d="+document.form1.clasificacion_d.value+"&clasificacion_h="+document.form1.clasificacion_h.value+"&tipo_bene_d="+document.form1.tipo_benef_d.value+"&tipo_bene_h="+document.form1.tipo_benef_h.value;
  window.open(url,"Reporte Listado de Planillas de Retencion por Beneficiario")}
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
$sql="SELECT MAX(Ced_Rif) As Max_Ced_Rif, MIN(Ced_Rif) As Min_Ced_Rif FROM PRE099";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO PLANILLAS DE RETENCION BENEFICIARIO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="528" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="522">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:495px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="488" border="0">
    <tr>
      <td width="958" height="484" align="center" valign="top"><table width="783" height="383" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="5" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="34"><div align="center"></div>            <div align="center"></div></td>
          <td height="34"><div align="center"><strong>DESDE</strong></div></td>
          <td height="34">&nbsp;</td>
          <td height="34"><strong>HASTA</strong></td>
          <td height="34">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="5" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td width="241" height="9" align="center" class="Estilo16"><div align="left">CEDULA/RIF BENEFICIARIO: </div></td>
           <td width="102"><span class="Estilo5">
                <input name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_d?>" size="15" maxlength="15">
              </span></td>
              <td width="49"><span class="Estilo5">
                <input name="Catalogo322" type="button" id="Catalogo3225" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Beneficiariosd.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="303"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesccedrifbenefd" type="text" id="txtdesc_ced_rif_benef_d" size="41" maxlength="15"   readonly>
              </span></span></td>
        </tr>
        <tr>
          <td height="10" colspan="5" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16"><div align="left">CEDULA/RIF BENEFICIARIO:</div></td>
           <td width="103"><span class="Estilo5">
                <input name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_h?>" size="15" maxlength="15">
              </span></td>
              <td width="49"><span class="Estilo5">
                <input name="Catalogo3222" type="button" id="Catalogo3222" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_Beneficiariosh.php?criterio=','SIPAP','','750','500','true')" value="...">
              </span></td>
              <td width="302"><span class="Estilo12"><span class="Estilo5">
                <input name="txtdesccedrifbenefh" type="text" id="txtdesccedrifbenefh" size="41" maxlength="41"  readonly>
              </span></span></td>
          <td height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="5" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="5" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="233" height="26">
                <div align="left">TIPO PLANILLA: </div></td>
              <td width="200"><span class="Estilo5"> <span class="Estilo12">
                <input name="txttipo_planilla_ret_d" type="text" id="txttipo_planilla_ret_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_planilla_d?>" size="15" maxlength="15">
              </span> </span></td>
              <td width="48">&nbsp;</td>
              <td width="277"><span class="Estilo12"><span class="Estilo5">
                <input name="txttipo_planilla_ret_h" type="text" id="txttipo_planilla_ret_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_planilla_h?>" size="15" maxlength="15">
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="5" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="5" align="center" class="Estilo16"><table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="244" align="center"><div align="left">
                  <p align="left">FECHA:</p>
              </div></td>
              <td width="253" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="286" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="5"><table width="782" border="0">
            <tr>
              <td width="234" height="26"><p align="left">CLASIFICACION :</p></td>
              <td width="256"><span class="Estilo5">
                <select name="clasificacion_d" id="clasificacion_d">
                  <option></option>
                  <option>PROVEEDOR</option>
                  <option>CONTRATISTAS</option>
                  <option>MICROEMPRESAS</option>
                  <option>COLABORACIONES</option>
                  <option>EMPLEADOS</option>
                  <option>OTROS</option>
                </select>
</span></td>
              <td width="278"><span class="Estilo5">
                <select name="clasificacion_h" id="clasificacion_h">
                  <option>zzzzzzzzzzzzzzzzzzzz</option>
                  <option>PROVEEDOR</option>
                  <option>CONTRATISTAS</option>
                  <option>MICROEMPRESAS</option>
                  <option>COLABORACIONES</option>
                  <option>EMPLEADOS</option>
                  <option>OTROS</option>
                </select>
</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="5"><table width="782" border="0">
            <tr>
              <td width="240" height="26"><p align="left"> TIPO BENEFICIARIO:</p></td>
              <td width="252"><span class="Estilo5">
                <select name="tipo_benef_d" id="tipo_benef_d">
                  <option></option>
                  <option value="Juridico  ">JURIDICO</option>
                  <option value="Natural  ">NATURAL</option>
                </select>
              </span></td>
              <td width="276"><span class="Estilo5">
                <select name="tipo_benef_h" id="tipo_benef_h">
                  <option>zzzzzzzzzzzzzzzzzzzz</option>
                  <option value="Juridico  ">JURIDICO</option>
                  <option value="Natural  ">NATURAL</option>
                </select>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="5">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="5"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="10" height="32">&nbsp;</td>
              <td width="369">&nbsp;</td>
              <td width="382">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="65" colspan="5"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Listado_Planillas_Retencion_Bene('Rpt_Listado_Planillas_Retencion_Bene.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="5">&nbsp;</td>
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
