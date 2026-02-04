<?php include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$formato_presup="XX-XX-XX-XXX-XX-XX-XX"; $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];} $long_c=strlen($formato_presup); 
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="03-0000022"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
  $nro_orden_d="";$nro_orden_h="";$documento_causado_d="";$documento_causado_h="";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$cedula_d="";$cedula_h="";
 $tipo_orden_d="";$tipo_orden_h="";$codigo_presu_d="";$codigo_presu_h="";$status_orden="";$ref_comp_d="00000000"; $ref_comp_h="99999999"; $cod_fuente_d="";  $cod_fuente_h="zz";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Reporte Relacion Listado Ordenes Ordenes de Pago/Codigo Presupuestario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
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
function checkreferenciad(mform){var mref;
   mref=mform.txtnro_orden_d.value;   mref = Rellenarizq(mref,"0",8);  mform.txtnro_orden_d.value=mref;   
return true;}
function checkreferenciah(mform){var mref;
   mref=mform.txtnro_orden_h.value;   mref = Rellenarizq(mref,"0",8);  mform.txtnro_orden_h.value=mref;   
return true;}

function checkrefcompd(mform){var mref;
   mref=mform.txtref_comp_d.value;   mref = Rellenarizq(mref,"0",8);  mform.txtref_comp_d.value=mref;
return true;}
function checkrefcomph(mform){var mref;
   mref=mform.txtref_comp_h.value;   mref = Rellenarizq(mref,"0",8);  mform.txtref_comp_h.value=mref;
return true;}
function Llama_Rpt_Ordenes_Pago_Cod_Presupuesta(murl){var url;var r;var st;
  if(document.form1.opestatus[0].checked==true){st="T";}
  if(document.form1.opestatus[1].checked==true){st="I";}
  if(document.form1.opestatus[2].checked==true){st="S";}
  if(document.form1.opestatus[3].checked==true){st="N";}
  if(document.form1.opestatus[4].checked==true){st="L";}
  r=confirm("Desea Generar el Reporte Listado de Ordenes de Pago por Codigos Presupuestarios?");
  if (r==true) { url=murl+"?&nro_orden_d="+document.form1.txtnro_orden_d.value+"&nro_orden_h="+document.form1.txtnro_orden_h.value+"&doc_causado_d="+document.form1.txtdoc_causado_d.value+"&doc_causado_h="+document.form1.txtdoc_causado_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&tipo_orden_d="+document.form1.txttipo_ordend.value+"&tipo_orden_h="+document.form1.txttipo_ordenh.value+"&codigo_presu_d="+document.form1.txtcod_presupd.value+"&codigo_presu_h="+document.form1.txtcod_presuph.value+"&cod_fuented="+document.form1.txtcod_fuented.value+"&cod_fuenteh="+document.form1.txtcod_fuenteh.value+"&ref_comp_d="+document.form1.txtref_comp_d.value+"&ref_comp_h="+document.form1.txtref_comp_h.value+"&status_orden="+st+"&tipo_rpt="+document.form1.tipo_rpt.value;;
    window.open(url,"Reporte Listado de Ordenes de Pago Por Codigos Presupuestarios")
  }
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
</head>
<?php 
$sql="SELECT MAX(nro_orden) As Max_Nro_Orden, MIN(nro_orden) As Min_Nro_Orden FROM ORD_PAGO";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$nro_orden_d=$registro["min_nro_orden"];$nro_orden_h=$registro["max_nro_orden"];}
$sql="SELECT MAX(Ced_Rif) As Max_Ced_Rif, MIN(Ced_Rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
$sql="SELECT MAX(Tipo_Orden) As Max_Tipo_Orden, MIN(Tipo_Orden) As Min_Tipo_Orden FROM TIPOS_ORDEN";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_orden_d=$registro["min_tipo_orden"];$tipo_orden_h=$registro["max_tipo_orden"];}
$sql="SELECT MAX(tipo_causado) As Max_tipo_causado, MIN(tipo_causado) As Min_tipo_causado FROM pre003 where tipo_causado<>'0000'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$documento_causado_d=$registro["min_tipo_causado"];$documento_causado_h=$registro["max_tipo_causado"];}
$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001 where (length(Cod_Presup)=".$long_c.")"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $codigo_presu_d=$registro["min_cod_presup"];  $codigo_presu_h=$registro["max_cod_presup"];}
$sql="SELECT min(cod_fuente_financ) as min_fuente, max(cod_fuente_financ) as max_fuente  from pre095"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_fuente_d=$registro["min_fuente"];  $cod_fuente_h=$registro["max_fuente"];}
$codigo_presu_d=str_replace("X","?",$formato_presup); $codigo_presu_h=str_replace("X","?",$formato_presup);
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="45"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO DE ORDENES PAGOS / COD. PRESUPUESTARIO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="670" border="1" id="tablacuerpo">
  <tr>
    <td width="970" height="666">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:1168px; height:463px; z-index:1; top: 58px; left: 14px;">
        <form name="form1" method="get">
           <table width="981" height="637" border="0">
    <tr>
      <td width="969" height="633" align="center" valign="top"><table width="839" height="413" border="0" cellpadding="0" cellspacing="0">
         <tr><td>&nbsp;</td></tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo16"><table width="757" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="260">&nbsp;</td>
              <td width="258"><span class="Estilo13">DESDE</span></td>
              <td width="239"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
           <td height="19" colspan="3"><table width="771" border="0">
             <tr>
	        <td width="249" height="26"><span class="Estilo5">NUMERO DE ORDEN:</span></td>
                <td width="202"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden_d" type="text" id="txtnro_orden_d" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkreferenciad(this.form)" value="<?php echo $nro_orden_d?>" size="12" maxlength="8" class="Estilo5"></span></td>
                <td width="81"></td>
                <td width="221"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden_h" type="text" id="txtnro_orden_h" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkreferenciah(this.form)" value="<?php echo $nro_orden_h?>" size="12" maxlength="8" class="Estilo5"></span></td>
	     </tr>
          </table></td>
        </tr>
		<tr><td>&nbsp;</td></tr>
        <tr>
          <td height="19" colspan="3"><table width="776" border="0">
            <tr>
              <td width="252" height="26"> <span class="Estilo5">DOCUMENTO CAUSADO: </span></td>
              <td width="79"><span class="Estilo5"><input class="Estilo10" name="txtdoc_causado_d" type="text" id="txtdoc_causado_d" onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $documento_causado_d?>" size="6" maxlength="4" class="Estilo5"></span></td>
              <td width="203"><span class="Estilo5"><input class="Estilo10" name="catadocd" type="button" id="catadocd" title="Abrir Catalogo Documentos causados" onClick="VentanaCentrada('../Cat_doc_causd.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
              <td width="57"><span class="Estilo5"><input class="Estilo10" name="txtdoc_causado_h" type="text" id="txtdoc_causado_h" onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $documento_causado_h?>" size="6" maxlength="4" class="Estilo5"></span></td>
              <td width="163"><span class="Estilo5"> <input class="Estilo10" name="catadoch" type="button" id="catadoch" title="Abrir Catalogo  Documentos causados" onClick="VentanaCentrada('../Cat_doc_caush.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
           <td height="19" colspan="3"><table width="771" border="0">
             <tr>
	        <td width="249" height="26"><span class="Estilo5">REFERENCIA COMPROMISO:</span></td>
                <td width="202"><span class="Estilo5"><input class="Estilo10" name="txtref_comp_d" type="text" id="txtref_comp_d" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkrefcompd(this.form)" value="<?php echo $ref_comp_d?>" size="12" maxlength="8" class="Estilo5"></span></td>
                <td width="81"></td>
                <td width="221"><span class="Estilo5"><input class="Estilo10" name="txtref_comp_h" type="text" id="txtref_comp_h" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkrefcomph(this.form)" value="<?php echo $ref_comp_h?>" size="12" maxlength="8" class="Estilo5"></span></td>
	     </tr>
          </table></td>
        </tr>
		<tr><td>&nbsp;</td></tr>
        <tr>
          <td height="19" colspan="3"><table width="771" border="0"  >
            <tr>
              <td width="251" align="left"><span class="Estilo5">FECHA ORDEN: </span></td>
              <td width="285" align="center"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)" class="Estilo5">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
              <td width="221" align="center"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)" class="Estilo5">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="776" border="0">
            <tr>
              <td width="253" height="26"><span class="Estilo5">CEDULA/RIF PROVEEDOR: </span></td>
              <td width="104"><span class="Estilo5"><input class="Estilo10" name="txtcedula_d" type="text" id="txtcedula_d4" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_d?>" size="15" maxlength="12" class="Estilo5"></span></td>
              <td width="171"><span class="Estilo5"><input class="Estilo10" name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Beneficiariosd.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
              <td width="104"><span class="Estilo5"><input class="Estilo10" name="txtcedula_h" type="text" id="txtcedula_h3" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_h?>" size="15" maxlength="12" class="Estilo5"></span></td>
              <td width="122"><span class="Estilo5"><input class="Estilo10" name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Beneficiariosh.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="776" border="0">
            <tr>
              <td width="254" height="26"><span class="Estilo5">TIPO ORDEN: </span></td>
              <td width="65"><span class="Estilo5"><input class="Estilo10" name="txttipo_ordend" type="text" id="txttipo_ordend" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_orden_d?>" size="6" maxlength="4" class="Estilo5"></span></td>
              <td width="206"><span class="Estilo5"><input class="Estilo10" name="Catalogo5" type="button" id="Catalogo5" title="Abrir Catalogo de Tipo Orden" onClick="VentanaCentrada('../Cat_tipo_ordend.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
              <td width="64"><span class="Estilo5"><input class="Estilo10" name="txttipo_ordenh" type="text" id="txttipo_ordenh" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_orden_h?>" size="6" maxlength="4" class="Estilo5"></span></td>
              <td width="155"><span class="Estilo5"><input class="Estilo10" name="Catalogo6" type="button" id="Catalogo6" title="Abrir Catalogo de Tipo Orden" onClick="VentanaCentrada('../Cat_tipo_ordenh.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="30" colspan="3"><table width="826" border="0">
            <tr>
              <td width="253" height="26"><span class="Estilo5">CODIGOS PRESUPUESTARIO: </span></td>
              <td width="210"><span class="Estilo5"><input class="Estilo10" name="txtcod_presupd" type="text" id="txtcod_presupd" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $codigo_presu_d?>" size="36" maxlength="30" class="Estilo5"></span></td>
              <td width="62"><span class="Estilo5"><input class="Estilo10" name="cat_cod_pred" type="button" id="cat_cod_pred" title="Abrir Catalogo Codigo Presupuestario" onClick="VentanaCentrada('../Cat_codigos_presupd.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
              <td width="204"><span class="Estilo5"><input class="Estilo10" name="txtcod_presuph" type="text" id="txtcod_presuph" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $codigo_presu_h?>" size="36" maxlength="30" class="Estilo5"></span></td>
              <td width="75"><span class="Estilo5"><input class="Estilo10" name="cat_cod_preh" type="button" id="cat_cod_preh" title="Abrir Catalogo Codigo Presupuestario" onClick="VentanaCentrada('../Cat_codigos_presuph.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
		 <tr>
          <td height="30" colspan="3"><table width="826" border="0">
            <tr>
              <td width="253" height="26"><span class="Estilo5">CODIGOS FUENTE: </span></td>
			  <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuented" type="text" id="txtcod_fuented" value="<?php echo $cod_fuente_d?>" onFocus="encender(this)" onBlur="apagar(this)" maxlength="2" size="5" class="Estilo5"> </span></td>
              <td width="62"><span class="Estilo5"><input class="Estilo10" name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('../../presupuesto/rpt/Cat_fuentesd.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
              <td width="160"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuented" type="hidden" id="txtdes_fuented" ></span></td>
              <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" value="<?php echo $cod_fuente_h?>" onFocus="encender(this)" onBlur="apagar(this)" maxlength="2"  size="5" class="Estilo5"> </span></td>
              <td width="75"><span class="Estilo5"><input class="Estilo10" name="btfuente2" type="button" id="btfuente2" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('../../presupuesto/rpt/Cat_fuentesh.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
              <td width="154"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuenteh" type="hidden" id="txtdes_fuenteh" ></span></td>
             </tr>
          </table></td>
        </tr>
		<tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="256"><span class="Estilo5">ESTATUS DE LAS ORDENES  :</span></td>
              <td width="508"><table width="278" height="75" border="1">
                <tr>
                  <td width="140" height="69" valign="top"  class="Estilo5"><label>
                    <input class="Estilo10" name="opestatus" type="radio" value="T" checked>TODAS</label>
                      <p> <input class="Estilo10" name="opestatus" type="radio" value="I">CANCELADAS </p>
                      <p><label> <input class="Estilo10" name="opestatus" type="radio" value="S">ANULADAS</label> </p></td>
                  <td width="130" valign="top"  class="Estilo5"><p><input class="Estilo10" name="opestatus" type="radio" value="N">PENDIENTE</p>
                      <p><input class="Estilo10" name="opestatus" type="radio" value="L">LIBERADAS</p></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
         <tr><td>&nbsp;</td></tr>
		<tr>
		  <td height="19"><table width="782" border="0">
			  <tr>
				<td width="252" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="530"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt">
				  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option> <option value='PDF2'>FORMATO PDF2</option> <option value='EXCEL'>FORMATO EXCEL</option> </select></span></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>

         <tr><td>&nbsp;</td></tr>
        <tr>
          <td height="68" colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td> <div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Ordenes_Pago_Cod_Presupuesta('Rpt_Ordenes_Pago_Cod_Presupuesta.php');">   </div></td>
              <td><div align="center"> <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">    </div></td></tr>
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
<?php  pg_close($conn);?>
