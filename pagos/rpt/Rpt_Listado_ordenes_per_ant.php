<?php include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc"); 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="03-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?php }
$nro_orden_d="";$nro_orden_h="";$documento_causado_d="";$documento_causado_h="";$cedula_d="";$cedula_h="";$tipo_orden_d="";$tipo_orden_h="";$status_orden="";
$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);  $fecha_d=nextano($fecha_d,-1); $fecha_h=nextano($fecha_h,-1);
$fecha_d=$fecha_d; $fecha_h=$fecha_h; $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP ORDENAMIENTO DE PAGOS (Reporte Listado Ordenes de Pago Periodo Anterior)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
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
function Llama_Rpt_Listado_Ordenes_Pa(murl){var url;var r;var st="T";
  if(document.form1.opestatus[0].checked==true){st="T";}
  if(document.form1.opestatus[1].checked==true){st="I";}
  if(document.form1.opestatus[2].checked==true){st="N";}
  r=confirm("Desea Generar el Reporte Listado Ordenes de Pago Periodo Anterior ?");
  if (r==true) {url=murl+"?&nro_orden_d="+document.form1.txtnro_orden_d.value+"&nro_orden_h="+document.form1.txtnro_orden_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&doc_causado_d="+document.form1.txtdoc_causado_d.value+"&doc_causado_h="+document.form1.txtdoc_causado_h.value+"&tipo_orden_d="+document.form1.txttipo_ordend.value+"&tipo_orden_h="+document.form1.txttipo_ordenh.value+"&status_orden="+st+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url,"Reporte Listado Ordenes de Pago")
  }
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?php $sql="SELECT MAX(nro_orden) As Max_Nro_Orden, MIN(nro_orden) As Min_Nro_Orden FROM PAG022";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$nro_orden_d=$registro["min_nro_orden"];$nro_orden_h=$registro["max_nro_orden"];}
$sql="SELECT MAX(Ced_Rif) As Max_Ced_Rif, MIN(Ced_Rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
$sql="SELECT MAX(Tipo_Orden) As Max_Tipo_Orden, MIN(Tipo_Orden) As Min_Tipo_Orden FROM TIPOS_ORDEN";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_orden_d=$registro["min_tipo_orden"];$tipo_orden_h=$registro["max_tipo_orden"];}
$sql="SELECT MAX(tipo_causado) As Max_tipo_causado, MIN(tipo_causado) As Min_tipo_causado FROM pre003 where tipo_causado<>'0000'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$documento_causado_d=$registro["min_tipo_causado"];$documento_causado_h=$registro["max_tipo_causado"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="45"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO DE ORDENES PAGO PERIODO ANTERIOR</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="553" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="547">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:486px; z-index:1; top: 73px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="482" border="0">
    <tr>
      <td width="958" height="478" align="center" valign="top"><table width="783" height="415" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5"><table width="757" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="230">&nbsp;</td>
              <td width="248"><span class="Estilo13">DESDE</span></td>
              <td width="279"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center" class="Estilo5"><table width="776" border="0">
            <tr>
              <td width="221" class="Estilo5" height="26"><div align="left">NUMERO DE ORDEN:</div></td>
              <td width="231"><span class="Estilo5"><input name="txtnro_orden_d" type="text" id="txtnro_orden_d" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkreferenciad(this.form)" value="<?php echo $nro_orden_d?>" size="15" maxlength="8"></span></td>
              <td width="310"><span class="Estilo5"><input name="txtnro_orden_h" type="text" id="txtnro_orden_h" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkreferenciah(this.form)" value="<?php echo $nro_orden_h?>" size="15" maxlength="8"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="30" colspan="3"><table width="780" border="0">
            <tr>
              <td width="225" class="Estilo5" height="26"> <div align="left">DOCUMENTO CAUSADO: </div></td>
              <td width="72"><span class="Estilo5"><input name="txtdoc_causado_d" type="text" id="txtdoc_causado_d" onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $documento_causado_d?>" size="6" maxlength="4"></span></td>
              <td width="155"><span class="Estilo5"><input name="catadocd" type="button" id="catadocd" title="Abrir Catalogo Documentos causados" onClick="VentanaCentrada('../Cat_doc_causd.php?criterio=','SIPAP','','750','500','true')" value="..."> </span></td>
              <td width="66"><span class="Estilo5"><input name="txtdoc_causado_h" type="text" id="txtdoc_causado_h" onFocus="encender(this)" onBlur="apagar(this)"  value="<?php echo $documento_causado_h?>" size="6" maxlength="4"></span></td>
              <td width="240"><span class="Estilo5"> <input name="catadoch" type="button" id="catadoch" title="Abrir Catalogo  Documentos causados" onClick="VentanaCentrada('../Cat_doc_caush.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3"><table width="780" border="0">
            <tr>
              <td width="229" class="Estilo5" align="center"><div align="left">FECHA ORDEN: </div></td>
              <td width="223" align="left"><span class="Estilo5"><input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></td>
              <td width="314" align="left"><span class="Estilo5"><input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="18" colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="3"><table width="782" border="0">
            <tr>
              <td width="227" class="Estilo5" height="26"><div align="left">CEDULA/RIF:</div></td>
              <td width="130"><span class="Estilo5"><input name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_d?>" size="13" maxlength="12"></span></td>
              <td width="91"><span class="Estilo5"><input name="Catcedd" type="button" id="Catcedd" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Beneficiariosd.php?criterio=','SIPAP','','750','500','true')" value="...">   </span></td>
              <td width="120"><span class="Estilo5"><input name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_h?>" size="13" maxlength="12">     </span></td>
              <td width="192"><span class="Estilo5"><input name="Catcedh" type="button" id="Catcedh" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Beneficiariosh.php?criterio=','SIPAP','','750','500','true')" value="...">    </span></td>
            </tr>
          </table></td>
        </tr>
         <tr> <td height="18" colspan="3">&nbsp;</td>  </tr>  
        <tr>
          <td height="18" colspan="3"><table width="782" border="0">
                  <tr>
              <td width="228" class="Estilo5" height="26"><div align="left">TIPO DE ORDEN:</div></td>
              <td width="97"><span class="Estilo5"><input name="txttipo_ordend" type="text" id="txttipo_ordend" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_orden_d?>" size="6" maxlength="4">  </span></td>
              <td width="126"><span class="Estilo5"><input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Tipo Orden" onClick="VentanaCentrada('../Cat_tipo_ordend.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></td>
              <td width="76"><span class="Estilo5"><input name="txttipo_ordenh" type="text" id="txttipo_ordenh" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_orden_h?>" size="6" maxlength="4"> </span></td>
              <td width="233"><span class="Estilo5"><input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo de Tipo Orden" onClick="VentanaCentrada('../Cat_tipo_ordenh.php?criterio=','SIPAP','','750','500','true')" value="...">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td height="18" colspan="3">&nbsp;</td>  </tr>        
        <tr>
          <td height="18" colspan="3"><table width="782" border="0" cellspacing="1" cellpadding="1">
            <tr>
              <td width="228" class="Estilo5">ESTATUS DE LAS ORDENES:</td>
              <td width="554"><table width="278" height="75" border="1">
                <tr>
                  <td width="140" height="69" valign="top" class="Estilo5">
                    <label><input name="opestatus" type="radio" value="T" checked> TODAS</label>
                    <p><input name="opestatus" type="radio" value="I">  CANCELADAS </p>
                    <p><input name="opestatus" type="radio" value="N">  PENDIENTE</p> </td>
                  
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td height="18" colspan="3">&nbsp;</td>  </tr> 
		<tr>
		  <td height="19"><table width="782" border="0">
			  <tr>
				<td width="228" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="554"><span class="Estilo5"> <select name="tipo_rpt" id="tipo_rpt">
				  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select>
				</span></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
        <tr> <td height="18" colspan="3">&nbsp;</td>  </tr> 
		<tr>
          <td height="89" colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Listado_Ordenes_Pa('Rpt_Listado_ord_per_ant.php');">   </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">  </div></td>
			</tr>
          </table></td>
        </tr>
        <tr> <td height="18" colspan="3">&nbsp;</td>  </tr>  
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
