<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="03-0000180"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
$tipo_pago_d=""; $tipo_pago_h="";$referencia_d=""; $referencia_h=""; $ref_caus_d=""; $ref_caus_h="zzzzzzzz";
$fecha_d=date("01/01/Y"); $fecha_h=date("31/12/Y");  $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer); 
$cod_presup_d=""; $cod_presup_h="";$cod_fuente_d=""; $cod_fuente_h="";$cedula_d=""; $cedula_h=""; $tipo_regis=""; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte de Pagos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);     mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);     mform.txtFechah.value=mfec;}
return true;}

function Llama_Rpt_pago(murl){var url;var r;var tipo;
  if(document.form1.optipo[0].checked==true){tipo="ANU";}  if(document.form1.optipo[1].checked==true){tipo="AJU";}
  if(document.form1.optipo[2].checked==true){tipo="NANU";}  if(document.form1.optipo[3].checked==true){tipo="TO";}
  r=confirm("Desea Generar el Reporte de Pagos?");
  if (r==true){url=murl+"?&tipo_pago_d="+document.form1.txttipo_pagod.value+"&tipo_pago_h="+document.form1.txttipo_pagoh.value+"&referencia_d="+document.form1.txtreferencia_d.value+"&referencia_h="+document.form1.txtreferencia_h.value+
	"&ref_caus_d="+document.form1.txtref_caus_d.value+"&ref_caus_h="+document.form1.txtref_caus_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+
	"&cod_presupd="+document.form1.txtcod_presupd.value+"&cod_presuph="+document.form1.txtcod_presuph.value+"&cod_fuente_d="+document.form1.txtcod_fuented.value+"&cod_fuente_h="+document.form1.txtcod_fuenteh.value+"&cedula_d="+document.form1.txtced_rif_d.value+"&cedula_h="+document.form1.txtced_rif_h.value+"&tipo_regis="+tipo+"&tipo_rep="+document.form1.txttipo_rep.value;
	  window.open(url,"Reporte de Pagos")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

<?$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"];} $l=strlen($formato_presup);
$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001 where (length(Cod_Presup)=".$l.")"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_presup_d=$registro["min_cod_presup"];  $cod_presup_h=$registro["max_cod_presup"];}
$sql="Select max(tipo_pago) As max_tipo_pago, min(tipo_pago) As min_tipo_pago from pre004"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $tipo_pago_d=$registro["min_tipo_pago"];  $tipo_pago_h=$registro["max_tipo_pago"];}
$sql="Select max(referencia_pago) As max_referencia_pago, min(referencia_pago) As min_referencia_pago from pre008"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $referencia_d=$registro["min_referencia_pago"];  $referencia_h=$registro["max_referencia_pago"];}
$sql="Select max(ced_rif ) As max_ced_rif , min(ced_rif ) As min_ced_rif  from pre099"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cedula_d=$registro["min_ced_rif"];  $cedula_h=$registro["max_ced_rif"];}
$sql="SELECT min(cod_fuente_financ) as min_fuente, max(cod_fuente_financ) as max_fuente  from pre095"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_fuente_d=$registro["min_fuente"];  $cod_fuente_h=$registro["max_fuente"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_d'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_d=$registro["des_fuente_financ"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_h'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_h=$registro["des_fuente_financ"];}
$cod_presup_d=str_replace("X","?",$formato_presup); $cod_presup_h=str_replace("X","?",$formato_presup);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE DE PAGOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="635" border="1" id="tablacuerpo">
  <tr>
    <td width="992" height="612">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:952px; height:748px; z-index:1; top: 69px; left: 30px;">
        <form name="form1" method="get">
           <table width="950" height="610" border="0">
    <tr>
      <td width="958" height="609" align="center" valign="top"><table width="830" height="605" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19"><table width="829" border="0">
            <tr>
              <td width="211" height="26"><div align="right"> </div></td>
              <td width="328"><span class="Estilo12"><strong>DESDE</strong></span></td>
              <td width="276"><span class="Estilo12"><strong>HASTA</strong></span></td>
            </tr>
          </table></td>
        </tr>
		<tr>
          <td height="19"><table width="827" border="0">
            <tr>
              <td width="206" height="26"><span class="Estilo5">DOCUM. PAGO :</span></td>
			  <td width="59"><span class="Estilo5"><input class="Estilo10" name="txttipo_pagod" type="text" id="txttipo_pagod" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_pago_d?>" size="5" maxlength="4"> </span></td>
              <td width="278"><span class="Estilo5"><input class="Estilo10" name="btdoc_comp" type="button" id="btdoc_comp" title="Abrir Catalogo Documentos Pagos" onClick="VentanaCentrada('Cat_tipo_pagod.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
              <td width="60"><span class="Estilo5"><input class="Estilo10" name="txttipo_pagoh" type="text" id="txttipo_pagoh" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_pago_h?>" size="5" maxlength="4">  </span></td>
              <td width="203"><span class="Estilo5"><input class="Estilo10" name="btdoc_comp" type="button" id="btdoc_comp" title="Abrir Catalogo Documentos Pagos" onClick="VentanaCentrada('Cat_tipo_pagoh.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
			  <td width="206"><span class="Estilo5">REFERENCIA : </span></td>
              <td width="169"><span class="Estilo5"><input class="Estilo10" name="txtreferencia_d" type="text" id="txtreferencia_d" size="10" maxlength="8" value="<?echo $referencia_d?>" onFocus="encender(this);" onBlur="apagar(this);"  onchange="checkrefe_comp(this.form);"> </span></td>
              <td width="164"></td>
              <td width="229"><span class="Estilo5"><input class="Estilo10" name="txtreferencia_h" type="text" id="txtreferencia_h" size="10" maxlength="8" value="<?echo $referencia_h?>" onFocus="encender(this);" onBlur="apagar(this);"  onchange="checkrefe_comp(this.form);"> </span></td>
              <td width="38"></td>
            </tr>
          </table></td>
        </tr>
		<tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
			  <td width="206"><span class="Estilo5">REFERENCIA CAUSADO : </span></td>
              <td width="169"><span class="Estilo5"><input class="Estilo10" name="txtref_caus_d" type="text" id="txtref_caus_d" size="10" maxlength="8" value="<?echo $ref_caus_d?>" onFocus="encender(this);" onBlur="apagar(this);"  onchange="checkrefe_comp(this.form);"> </span></td>
              <td width="164"></td>
              <td width="229"><span class="Estilo5"><input class="Estilo10" name="txtref_caus_h" type="text" id="txtref_caus_h" size="10" maxlength="8" value="<?echo $ref_caus_h?>" onFocus="encender(this);" onBlur="apagar(this);"  onchange="checkrefe_comp(this.form);"> </span></td>
              <td width="38"></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="18"><table width="827" border="0">
            <tr>
			  <td width="206"><span class="Estilo5">FECHA PAGO  : </span></td>
              <td width="172"><span class="Estilo5"><input class="Estilo10" name="txtFechad" type="text" id="txtFechad" size="12" maxlength="10" onFocus="encender(this); " onBlur="apagar(this);"  value="<?echo $fecha_d?>" onchange="checkrefecha(this.form)">
                <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha" onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /> </span></td>
              <td width="165"><span class="Estilo5"> </span></td>
              <td width="243"><span class="Estilo5"><input class="Estilo10" name="txtFechah" type="text" id="txtFechah" size="12" maxlength="10" onFocus="encender(this); " onBlur="apagar(this);"  value="<?echo $fecha_h?>" onchange="checkrefecha(this.form)">
                <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /></span></td>
              <td width="23"><span class="Estilo5"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
			  <td width="191"><span class="Estilo5">C&Oacute;DIGO PARTIDAS  : </span></td>
              <td width="188"><span class="Estilo5"><input class="Estilo10" name="txtcod_presupd" type="text" id="txtcod_presupd" size="35" maxlength="35" value="<?echo $cod_presup_d?>" onFocus="encender(this); " onBlur="apagar(this);">  </span></td>
              <td width="169"><span class="Estilo5"> <input class="Estilo10" name="btCodPre2" type="button" id="btCodPre2" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onclick="VentanaCentrada('Cat_codigos_presupd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
              <td width="194"><span class="Estilo5"><input class="Estilo10" name="txtcod_presuph" type="text" id="txtcod_presuph" size="35" maxlength="35" value="<?echo $cod_presup_h?>" onFocus="encender(this); " onBlur="apagar(this);">  </span></td>
              <td width="63"><span class="Estilo5"><input class="Estilo10" name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onclick="VentanaCentrada('Cat_codigos_presuph.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
			  <td width="225"><span class="Estilo5">FUENTE DE FINANCIAMIENTO DESDE  : </span></td>
              <td width="47"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuented" type="text" id="txtcod_fuented" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="2" value="<?echo $cod_fuente_d?>">   </span></td>
              <td width="51"><span class="Estilo5"><input class="Estilo10" name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesd.php?criterio=','SIA','','750','500','true')" value="...">    </span></td>
              <td width="486"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuented" type="text" id="txtdes_fuented" size="75" maxlength="75"  value="<?echo $des_fuente_d?>" readonly>  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="228"> <span class="Estilo5"><div align="left">HASTA :</div>  </span></td>
              <td width="42"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="2" value="<?echo $cod_fuente_h?>">   </span></td>
              <td width="54"><span class="Estilo5"><input class="Estilo10" name="btfuente2" type="button" id="btfuente7" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesh.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
              <td width="486"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuenteh" type="text" id="txtdes_fuenteh" size="75" maxlength="75" value="<?echo $des_fuente_h?>" readonly>   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="829" border="0">
            <tr>
              <td width="205" height="26"><span class="Estilo5"> <div align="left">C&Eacute;DULA/RIF : </div></span></td>
              <td width="106"><span class="Estilo5"><input class="Estilo10" name="txtced_rif_d" type="text" id="txtced_rif_d" size="15" maxlength="15" value="<?echo $cedula_d?>" onFocus="encender(this); " onBlur="apagar(this);">  </span></td>
              <td width="330"><span class="Estilo5"><input class="Estilo10" name="btfuente8" type="button" id="btfuente9"" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_beneficiarios_d.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
              <td width="102"><span class="Estilo5"> <input class="Estilo10" name="txtced_rif_h" type="text" id="txtced_rif_h" size="15" maxlength="15" value="<?echo $cedula_h?>" onFocus="encender(this); " onBlur="apagar(this);">  </span></td>
              <td width="67"><span class="Estilo5"><input class="Estilo10" name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_beneficiarios_h.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>        
        <tr>
          <td height="19"><table width="814" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="204"><span class="Estilo5"><div align="left">TIPO DE GASTO : </div></span></td>
              <td width="610"><span class="Estilo5"><select name="txtfunc_inv" size="1" id="txtfunc_inv" onFocus="encender(this)" onBlur="apagar(this)">
                  <option >CORRIENTE</option> <option>INVERSION</option> <option selected>CORRIENTE/INVERSION</option>
                </select></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="10"><table width="824" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="204"><span class="Estilo5">TIPOS DE REGISTROS (STATUS) </span></td>
              <td width="613"><table width="492" height="10" border="1">
                <tr>
                  <td width="482"  class="Estilo5">
                      <p>
                        <label>
                        <input class="Estilo10" name="optipo" type="radio" value="ANU"> </label> <label>ANULADOS </label>
                        <input class="Estilo10" name="optipo" type="radio" value="AJU"><label>AJUSTADOS</label>
                        <input class="Estilo10" name="optipo" type="radio" value="NANU"><label>NI ANULADO,NI AJUSTADO </label>
                        <input class="Estilo10" name="optipo" type="radio" value="TO" checked><label>TODOS</label>
                      </p>
                      </td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="19">&nbsp;</td></tr>
		<tr>
          <td height="19"><table width="814" border="0">
            <tr>
			  <td width="204"><span class="Estilo5">TIPO DE REPORTE : </span></td>
              <td width="610"><span class="Estilo5"><select class="Estilo10" name="txttipo_rep" size="1" id="txttipo_rep" onFocus="encender(this)" onBlur="apagar(this)">
			<option value='HTML'>FORMATO HTML</option>  <option value='PDF'>FORMATO PDF</option> <option value='EXCEL'>FORMATO EXCEL</option> </select></td>
            </tr>
          </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.txttipo_rep.options[1].selected = true;}else{document.form1.txttipo_rep.options[0].selected = true;} </script>
        <tr><td height="19">&nbsp;</td></tr>  
        <tr>
          <td height="40"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_pago('Rpt_pago.php');">  </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">   </div></td>
		</tr>
          </table></td>
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


