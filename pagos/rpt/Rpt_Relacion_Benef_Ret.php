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
<title>SIA ORDENAMIENTO DE PAGO (Reporte Relaci&oacute;n Beneficiario  Retenci&oacute;n)</title>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE RELACI&Oacute;N BENEFICIARIO RETENCI&Oacute;N</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="696" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="690">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:604px; z-index:1; top: 73px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="663" border="0">
    <tr>
      <td width="958" height="659" align="center" valign="top"><table width="783" height="494" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16"><table width="757" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="197">&nbsp;</td>
              <td width="237"><span class="Estilo13">DESDE</span></td>
              <td width="323"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="182" height="26">
                <div align="left">TIPO RETENCI&Oacute;N : </div></td>
              <td width="99"><span class="Estilo5">
                <input name="txtcod_banco_d52" type="text" id="txtcod_banco_d52" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_d?>" size="15" maxlength="15">
              </span></td>
              <td width="118"><span class="Estilo5">
                <input name="Catalogo352" type="button" id="Catalogo352" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="102"><span class="Estilo5">
                <input name="txtcod_banco_d242" type="text" id="txtcod_banco_d242" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_d?>" size="15" maxlength="15">
              </span></td>
              <td width="253"><span class="Estilo5">
                <input name="Catalogo3242" type="button" id="Catalogo3242" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16"><table width="776" border="0">
            <tr>
              <td width="182" height="26">
                <div align="left">N&Uacute;MERO DE ORDEN   : </div></td>
              <td width="104"><span class="Estilo5">
                <input name="txtcod_banco_d5" type="text" id="txtcod_banco_d5" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_d?>" size="15" maxlength="15">
              </span></td>
              <td width="114"><span class="Estilo5">
                <input name="Catalogo35" type="button" id="Catalogo35" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="102"><span class="Estilo5">
                <input name="txtcod_banco_d24" type="text" id="txtcod_banco_d24" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_d?>" size="15" maxlength="15">
              </span></td>
              <td width="252"><span class="Estilo5">
                <input name="Catalogo324" type="button" id="Catalogo324" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="771" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="186" align="center"><div align="left">FECHA ORDEN : </div></td>
              <td width="233" align="center">
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
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="782" border="0">
            <tr>
              <td width="184" height="26"><p align="left">CLASIFICACI&Oacute;N :</p></td>
              <td width="230"><span class="Estilo5">
                <select name="selectclasificacion_d" id="selectclasificacion_d">
                  <option>PROVEDOR</option>
                  <option>CONTRATISTAS</option>
                  <option>MICROEMPRESAS</option>
                  <option>COLABORACIONES</option>
                  <option>EMPLEADO</option>
                </select>
              </span></td>
              <td width="354"><span class="Estilo5">
                <select name="selectclasificacion_d" id="selectclasificacion_d">
                  <option>PROVEDOR</option>
                  <option>CONTRATISTAS</option>
                  <option>MICROEMPRESAS</option>
                  <option>COLABORACIONES</option>
                  <option>EMPLEADO</option>
                </select>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="414">IMPRIMIR INFORMACI&Oacute;N DEL BENEFICIARIO  :</td>
              <td width="350">IMPRIMIR MOINTO OBJETO :</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="767" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="135">&nbsp;</td>
              <td width="351"><table width="112" height="30" border="1">
                  <tr>
                    <td width="113" valign="top"><label>
                      <input name="opimprimir" type="radio" value="S">
            SI </label>
                        <label>
                        <input name="opimprimir" type="radio" value="N" checked>
            NO </label></td>
                  </tr>
              </table></td>
              <td width="281"><table width="112" height="30" border="1">
                <tr>
                  <td width="113" valign="top"><label>
                    <input name="opimprimir" type="radio" value="S">
      SI </label>
                      <label>
                      <input name="opimprimir" type="radio" value="N" checked>
      NO </label></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="414">IMPRIMIR SOLO ORDEN CON PPAL. CANCELADA :</td>
              <td width="350">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="767" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="135">&nbsp;</td>
              <td width="376"><table width="112" height="30" border="1">
                  <tr>
                    <td width="113" valign="top"><label>
                      <input name="opimprimir" type="radio" value="S">
            SI </label>
                        <label>
                        <input name="opimprimir" type="radio" value="N" checked>
            NO </label></td>
                  </tr>
              </table></td>
              <td width="256">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="771" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="239" align="center"><div align="left">FECHA CANCELADA DESDE : </div></td>
              <td width="177" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechad2" type="text" id="txtFechad2" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="75" align="center"><div align="left">HASTA :</div></td>
              <td width="280" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechah2" type="text" id="txtFechah2" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="390">ESTATUS DE LAS ORDENES  :</td>
              <td width="374">IMPRIMIR INFOIRMACI&Oacute;N CANCELADA  :</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="42" height="18">&nbsp;</td>
          <td width="460"><table width="278" height="75" border="1">
            <tr>
              <td width="131" height="69" valign="top"><label>
                <input name="opimprimir" type="radio" value="S">
      TODAS</label>
                  <p>
                    <input name="opimprimir" type="radio" value="N" checked>
        LIBERADAS</p>
                  <p>
                    <label>
                    <input name="opimprimir" type="radio" value="N" checked>
        ANULADAS</label>
                </p></td>
              <td width="131" valign="top"><p>
                  <input name="opimprimir" type="radio" value="S">
        PENDIENTE</p>
                  <p>
                    <input name="opimprimir" type="radio" value="N" checked>
        LIBERADAS</p></td>
            </tr>
          </table></td>
          <td width="281"><table width="112" height="30" border="1">
            <tr>
              <td width="113" valign="top"><label>
                <input name="opimprimir" type="radio" value="S">
      SI </label>
                  <label>
                  <input name="opimprimir" type="radio" value="N" checked>
      NO </label></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="89" colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
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
          <td height="19" colspan="3">&nbsp;</td>
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
