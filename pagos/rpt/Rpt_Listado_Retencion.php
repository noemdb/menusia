<?php include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
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
<title>SIPAP CONTROL BANCARIO (Reporte Listado de Retenci&oacute;n)</title>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO DE RETENCI&Oacute;N </div></td>
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
      <td width="958" height="484" align="center" valign="top"><table width="783" height="451" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="783" height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="202" height="26">
                <div align="left">TIPO PLANILLA DESDE : </div></td>
              <td width="231"><span class="Estilo5"> <span class="Estilo12">
                <input name="txttipo_planilla_ret_d" type="text" id="txttipo_planilla_ret_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_planilla_ret_d?>" size="15" maxlength="15">
              </span> </span></td>
              <td width="71">HASTA : </td>
              <td width="254"><span class="Estilo12"><span class="Estilo5">
                <input name="txttipo_planilla_ret_h" type="text" id="txttipo_planilla_ret_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_planilla_ret_h?>" size="15" maxlength="15">
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
              <td width="200" height="26">
                <div align="left">Nro. PLANILLA DESDE : </div></td>
              <td width="233"><span class="Estilo5">
                <input name="txtnum_planilla_ret_d" type="text" id="txtnum_planilla_ret_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $num_planilla_ret_d?>" size="15" maxlength="15">
              </span></td>
              <td width="71">HASTA : </td>
              <td width="254"><span class="Estilo12"><span class="Estilo5">
                <input name="txtnum_planilla_ret_h" type="text" id="txtnum_planilla_ret_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $num_planilla_ret_h?>" size="15" maxlength="15">
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" align="center" class="Estilo16"><table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="136" align="center"><div align="left">
                  <p align="left">FECHA DESDE : </p>
              </div></td>
              <td width="310" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtfecha_d" type="text" id="txtfecha_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="76" align="center"><div align="left">HASTA :</div></td>
              <td width="261" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtfecha_h" type="text" id="txtfecha_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="126" height="26"> <div align="left">TASA DESDE : </div></td>
              <td width="312"><span class="Estilo5">
                <input name="txttasa_d" type="text" id="txttasa_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tasa_d?>" size="15" maxlength="15">
              </span></td>
              <td width="73">HASTA :              </td>
              <td width="247"><span class="Estilo12"><span class="Estilo5">
                <input name="txttasa_h" type="text" id="txttasa_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tasa_h?>" size="15" maxlength="15">
              </span></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="777" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="272">&nbsp;</td>
              <td width="264"><strong>DESDE</strong></td>
              <td width="231"><strong>HASTA</strong></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19"><table width="782" border="0">
            <tr>
              <td width="233" height="26"><p align="left">TIPO ENRRIQUECIMIENTO  :</p></td>
              <td width="257"><span class="Estilo5">
                <select name="selecttipo_enrriq_d" id="selecttipo_enrriq_d">
                  <option>SERVICIOS PRESTADOS</option>
                  <option>HONORARIOS PROFESIONALES</option>
                  <option>PUBLICIDAD</option>
                  <option> EJECUCI&Oacute;N DE OBRAS</option>
                </select>
</span></td>
              <td width="278"><span class="Estilo5">
                <select name="selecttipo_enrriq_h" id="selecttipo_enrriq_h">
                  <option>SERVICIOS PRESTADOS</option>
                  <option>HONORARIOS PROFESIONALES</option>
                  <option>PUBLICIDAD</option>
                  <option> EJECUCI&Oacute;N DE OBRAS</option>
                </select>
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
              <td width="230" height="26"><p align="left"> TIPO BENEFICIARIO :</p></td>
              <td width="262"><span class="Estilo5">
                <select name="selecttipo_benef_d" id="selecttipo_benef_d">
                  <option>JURIDICO</option>
                  <option>NATURAL</option>
                            </select>
              </span></td>
              <td width="276"><span class="Estilo5">
                <select name="selecttipo_benef_h" id="selecttipo_benef_h">
                  <option>JURIDICO</option>
                  <option>NATURAL</option>
                </select>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="369">ORDENADO POR :</td>
              <td width="395">PLANILLAS GENERADAS POR :</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="10" height="32">&nbsp;</td>
              <td width="369"><table width="202" height="30" border="1">
                  <tr>
                    <td width="263" valign="top"><label>
                      <input name="opordenar" type="radio" value="S" checked>
            PLANILLA</label>
                        <label>
                        <input type="radio" name="opordenar" value="N">
            FECHA</label></td>
                  </tr>
              </table></td>
              <td width="382"><table width="191" height="30" border="1">
                  <tr>
                    <td width="191" valign="top"><label>
                      <input name="opimprimir" type="radio" value="S">
            ORDEN
            <input name="opimprimir" type="radio" value="S">
            TODAS</label>
                        <label> </label></td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="65"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
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
    </div>    
    <div align="left"></div></td>
</tr>
</table>
</body>
</html>

<?php  pg_close($conn);?>
