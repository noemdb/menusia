<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 $tipo_retencion_d="";$tipo_retencion_h="";$nro_orden_d="";$nro_orden_h="";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$partidas_d="";$partidas_h="";
 $informacion_beneficiario="";$imprimir_monto="";$imprimir_orden="";$fecha_cancelada_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_cancelada_h=formato_ddmmaaaa($Fec_Fin_Ejer);$status_orden="";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Reporte Relacion Ordenes de Pago Retencion)</title>
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

function Llama_Rpt_Ordenes_Pago_Retencion_Cod_Pres(murl){var url;var r;var bene;

   if(document.form1.opimprimir_bene[0].checked==true){bene="S";}
   if(document.form1.opimprimir_bene[1].checked==true){bene="N";}
  /* if(document.form1.opimprimir_monto[0].checked==true){monto="S";}
   if(document.form1.opimprimir_monto[1].checked==true){monto="N";} */
  r=confirm("Desea Generar el Reporte Ordenes Pago Retencion / Codigos Presupuestarios?");
  if (r==true)
  {
    url=murl+"?tipo_retencion_d="+document.form1.txttipo_reten_d.value+"&tipo_retencion_h="+document.form1.txttipo_reten_h.value+"&nro_orden_d="+document.form1.txtnro_orden_d.value+"&nro_orden_h="+document.form1.txtnro_orden_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&partidas_d="+document.form1.txtcod_partidad.value+"&partidas_h="+document.form1.txtcod_partidah.value+"&informacion_beneficiario="+bene+/* "&imprimir_monto="+monto+*/"&fecha_cancelada_d="+document.form1.txtFecha_cancd.value+"&fecha_cancelada_h="+document.form1.txtFecha_canch.value;
    window.open(url,"Reporte Ordenes Pago Retencion / Codigos Presupuestarios")
  }
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
.Estilo13 {
        color: #0000FF;
        font-weight: bold;
}
-->
</style>
</head>
<?
$sql="SELECT MAX(Tipo_Retencion) As Max_Tipo_Retencion, MIN(Tipo_Retencion) As Min_Tipo_Retencion FROM RETENCIONES";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$tipo_retencion_d=$registro["min_tipo_retencion"];$tipo_retencion_h=$registro["max_tipo_retencion"];}

$sql="SELECT MAX(nro_orden) As Max_Nro_Orden, MIN(nro_orden) As Min_Nro_Orden FROM ORD_PAGO";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$nro_orden_d=$registro["min_nro_orden"];$nro_orden_h=$registro["max_nro_orden"];}

$sql="SELECT MAX(Cod_Presup) As Max_Cod_Presup, MIN(Cod_Presup) As Min_Cod_Presup FROM CODIGOS";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$partidas_d=$registro["min_cod_presup"];$partidas_h=$registro["max_cod_presup"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="45"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE ORDENES DE PAGO RETENCION / CODIGOS PRESUPUESTARIOS</div></td>
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
              <td width="183" height="26">
                <div align="left">TIPO RETENCION: </div></td>
              <td width="98"><span class="Estilo5">
                <input name="txttipo_reten_d" type="text" id="txttipo_reten_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_retencion_d?>" size="15" maxlength="15">
              </span></td>
              <td width="152"><span class="Estilo5">
                <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Tipos de Retenciones" onClick="VentanaCentrada('../Cat_Tipo_Retencionesd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="93"><span class="Estilo5">
                <input name="txttipo_reten_h" type="text" id="txttipo_reten_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_retencion_h?>" size="15" maxlength="15">
              </span></td>
              <td width="228"><span class="Estilo5">
                <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo de Tipos de Retenciones" onClick="VentanaCentrada('../Cat_Tipo_Retencionesh.php?criterio=','SIA','','750','500','true')" value="...">
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
              <td width="184" height="26">
                <div align="left">NUMERO DE ORDEN: </div></td>
              <td width="97"><span class="Estilo5">
                  <input name="txtnro_orden_d" type="text" id="txtnro_orden_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $nro_orden_d?>" size="15" maxlength="15">
                </span></td>
                <td width="155"><span class="Estilo5">
                </span></td>
                <td width="93"><span class="Estilo5">
                  <input name="txtnro_orden_h" type="text" id="txtnro_orden_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $nro_orden_h?>" size="15" maxlength="15">
                </span></td>
                <td width="225"><span class="Estilo5">
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
              <td width="261" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="324" align="center">
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
              <td width="184" height="26"><p align="left">CODIGOS PARTIDAS :</p></td>
              <td width="261"><span class="Estilo5">
                <input name="txtcod_partidad" type="text" id="txtcod_partidad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $partidas_d?>" size="30" maxlength="50">
                <input name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Tipos de Retenciones" onClick="VentanaCentrada('../Cat_cod_presupuestariod.php?criterio=','SIA','','750','500','true')" value="...">
</span></td>
              <td width="323"><span class="Estilo5">
                <input name="txtcod_partidah" type="text" id="txtcod_partidah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $partidas_h?>" size="30" maxlength="50">
                <input name="Catalogo5" type="button" id="Catalogo5" title="Abrir Catalogo de Tipos de Retenciones" onClick="VentanaCentrada('../Cat_cod_presupuestarioh.php?criterio=','SIA','','750','500','true')" value="...">
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
              <td width="414">IMPRIMIR INFORMACION DEL BENEFICIARIO:</td>
              <td width="350">&nbsp;</td>
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
                      <input name="opimprimir_bene" type="radio" value="S">
            SI </label>
                        <label>
                        <input name="opimprimir_bene" type="radio" value="N" checked>
            NO </label></td>
                  </tr>
              </table></td>
              <td width="281">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="414">IMPRIMIR SOLO ORDEN CON PPAL. CANCELADA:</td>
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
                      <input name="opimprimir_orden" type="radio" value="S">
            SI </label>
                        <label>
                        <input name="opimprimir_orden" type="radio" value="N" checked>
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
              <td width="239" align="center"><div align="left">FECHA CANCELADA DESDE: </div></td>
              <td width="177" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFecha_cancd" type="text" id="txtFecha_cancd" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="75" align="center"><div align="left">HASTA :</div></td>
              <td width="280" align="center">
                <div align="left"><span class="Estilo5">
                  <input name="txtFecha_canch" type="text" id="txtFecha_canch" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
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
              <td width="390">ESTATUS DE LAS ORDENES:</td>
              <td width="374">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td width="42" height="18">&nbsp;</td>
          <td width="351"><table width="278" height="75" border="1">
            <tr>
              <td width="131" height="69" valign="top"><label>
                <input name="opestatus" type="radio" value="S" checked>
      TODAS</label>
                  <p>
                    <input name="opestatus" type="radio" value="N">
        LIBERADAS</p>
                  <p>
                    <label>
                    <input name="opestatus" type="radio" value="N">
        ANULADAS</label>
                </p></td>
              <td width="131" valign="top"><p>
                  <input name="opestatus" type="radio" value="S">
        PENDIENTE</p>
                  <p>
                    <input name="opestatus" type="radio" value="N">
        LIBERADAS</p></td>
            </tr>
          </table></td>
          <td width="390">&nbsp;</td>
        </tr>
        <tr>
          <td height="89" colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Ordenes_Pago_Retencion_Cod_Pres('Rpt_Ordenes_Pago_Retencion_Cod_Pres.php');">
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
