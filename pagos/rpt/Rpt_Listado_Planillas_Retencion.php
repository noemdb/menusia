<?php include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="03-0000067"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
 $tipo_planilla_d="01"; $tipo_planilla_h="99";  $numero_planilla_d="00000000"; $numero_planilla_h="99999999";
 $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
 $tasa_d="0"; $tasa_h="999.99"; $tipo_en_d=""; $tipo_en_h=""; $tipo_bene_d=""; $tipo_bene_h=""; $ordenado=""; $generado=""; $vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGO  (Reporte Listado Planillas de Retencion)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="javascript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);     mform.txtFechah.value=mfec;}
return true;}
function Llama_Rpt_Listado_Planillas_Reten(murl){var url;var r;var ord;var gen;
  if(document.form1.opordenar[0].checked==true){ord="nro_planilla,tipo_planilla";}
  if(document.form1.opordenar[1].checked==true){ord="fecha_emision,nro_planilla,tipo_planilla";}
  r=confirm("Desea Generar el Reporte Listado de Planillas de Retencion?");
  if (r==true) {  url=murl+"?tipo_planilla_d="+document.form1.txttipo_planilla_ret_d.value+"&tipo_planilla_h="+document.form1.txttipo_planilla_ret_h.value+
    "&numero_planilla_d="+document.form1.txtnum_planilla_ret_d.value+"&numero_planilla_h="+document.form1.txtnum_planilla_ret_h.value+
    "&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+
    "&tasa_d="+document.form1.txttasa_d.value+"&tasa_h="+document.form1.txttasa_h.value+
    "&tipo_en_d="+document.form1.tipo_enrriq_d.value+"&tipo_en_h="+document.form1.tipo_enrriq_h.value+
    "&tipo_bene_d="+document.form1.tipo_benef_d.value+"&tipo_bene_h="+document.form1.tipo_benef_h.value+
    "&ordenado="+ord+"&generado="+gen+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url,"Reporte Listado de Planillas de Retencion")
  }
}
function Llama_Menu_Rpt(murl){var url;   url="../"+murl;   LlamarURL(url);}
</script>
</head>
<?php 
$sql="SELECT MAX(nro_orden) As Max_Nro_Orden, MIN(nro_orden) As Min_Nro_Orden FROM PAG001";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$nro_orden_d=$registro["min_nro_orden"];$nro_orden_h=$registro["max_nro_orden"];}
$sql="SELECT MAX(Ced_Rif) As Max_Ced_Rif, MIN(Ced_Rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
$sql="SELECT MAX(tipo_causado) As Max_tipo_causado, MIN(tipo_causado) As Min_tipo_causado FROM pre003 where tipo_causado<>'0000'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$documento_causado_d=$registro["min_tipo_causado"];$documento_causado_h=$registro["max_tipo_causado"];}
$sql="SELECT MAX(codigo) As max_planilla, MIN(codigo) As min_planilla FROM ban011";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_planilla_d=$registro["min_planilla"];$tipo_planilla_h=$registro["max_planilla"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO PLANILLAS DE RETENCI&Oacute;N </div></td>
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
          <td height="19" colspan="3" align="center"  ><table width="771" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="233">&nbsp;</td>
              <td width="248"><span class="Estilo13">DESDE</span></td>
              <td width="277"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5"><table width="776" border="0">
            <tr>
              <td width="233" height="26"><div align="left" class="Estilo5">TIPO PLANILLA: </div></td>
              <td width="200"><span class="Estilo5"><input class="Estilo10" name="txttipo_planilla_ret_d" type="text" id="txttipo_planilla_ret_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_planilla_d?>" size="4" maxlength="2" class="Estilo5"></span></td>
              <td width="48">&nbsp;</td>
              <td width="277"><span class="Estilo5"><input class="Estilo10" name="txttipo_planilla_ret_h" type="text" id="txttipo_planilla_ret_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_planilla_h?>" size="4" maxlength="2" class="Estilo5"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5"><table width="776" border="0">
            <tr>
              <td width="232" height="26"> <div align="left" class="Estilo5">NRO. PLANILLA: </div></td>
              <td width="201"><span class="Estilo5"><input class="Estilo10" name="txtnum_planilla_ret_d" type="text" id="txtnum_planilla_ret_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $numero_planilla_d?>" size="10" maxlength="8" class="Estilo5"></span></td>
              <td width="46">&nbsp;</td>
              <td width="279"><span class="Estilo5"><input class="Estilo10" name="txtnum_planilla_ret_h" type="text" id="txtnum_planilla_ret_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $numero_planilla_h?>" size="10" maxlength="8" class="Estilo5"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5"><table width="783" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="244" align="center"><div align="left"><p align="left" class="Estilo5">FECHA:</p></div></td>
              <td width="253" align="center"><div align="left"><span class="Estilo5">
                  <input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)" class="Estilo5">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="286" align="center"><div align="left"><span class="Estilo5">
                  <input class="Estilo10" name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)" class="Estilo5">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="776" border="0">
            <tr>
              <td width="236" height="26" class="Estilo5"> <div align="left">TASA: </div></td>
              <td width="202"><span class="Estilo5"><input class="Estilo10" name="txttasa_d" type="text" id="txttasa_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tasa_d?>" size="8" maxlength="6" class="Estilo5"></span></td>
              <td width="47">&nbsp;</td>
              <td width="273"><span class="Estilo5"><input class="Estilo10" name="txttasa_h" type="text" id="txttasa_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tasa_h?>" size="8" maxlength="6" class="Estilo5"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="782" border="0">
            <tr>
              <td width="234" height="26" class="Estilo5"><p align="left">TIPO ENRRIQUECIMIENTO  :</p></td>
              <td width="256"><span class="Estilo5"><select class="Estilo10" name="tipo_enrriq_d" id="selecttipo_enrriq_d">
                  <option></option>  <option>SERVICIOS PRESTADOS</option><option>HONORARIOS PROFESIONALES</option><option>PUBLICIDAD</option><option> EJECUCION DE OBRAS</option> </select></span></td>
              <td width="278"><span class="Estilo5"><select class="Estilo10" name="tipo_enrriq_h" id="selecttipo_enrriq_h">
                  <option>zzzzzzzzzzzzzzzzzzzz</option>  <option>SERVICIOS PRESTADOS</option><option>HONORARIOS PROFESIONALES</option> <option>PUBLICIDAD</option> <option> EJECUCION DE OBRAS</option>   </select></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="782" border="0">
            <tr>
              <td width="240" height="26" class="Estilo5"><p align="left"> TIPO BENEFICIARIO:</p></td>
              <td width="252"><span class="Estilo5"><select class="Estilo10" name="tipo_benef_d" id="tipo_benef_d">
                  <option></option><option value='Juridico'>JURIDICO</option> <option value='Natural'>NATURAL</option></select>
              </span></td>
              <td width="276"><span class="Estilo5"> <select class="Estilo10" name="tipo_benef_h" id="tipo_benef_h">
                  <option>zzzzzzzzzzzzzzzzzzzz</option><option value='Juridico'>JURIDICO</option> <option value='Natural'>NATURAL</option> </select>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="240" class="Estilo5">ORDENADO POR :</td>
              <td width="528"><table width="202" height="30" border="1">
                  <tr>
                    <td width="263" valign="top"><label class="Estilo5">
                      <input class="Estilo10" name="opordenar" type="radio" value="nro_planilla" checked > PLANILLA</label>
                        <label class="Estilo5">
                        <input type="radio" name="opordenar" value="fecha_emision,nro_planilla">FECHA</label></td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
		<tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
		  <td height="19"><table width="771" border="0">
			  <tr>
				<td width="240" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="528"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt">
				  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select>
				</span></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>

		<tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="65" colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Listado_Planillas_Reten('Rpt_Listado_Planillas_Reten.php');"></div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
    </div>
</tr>
</table>
</body>
</html>

<?php  pg_close($conn);?>
