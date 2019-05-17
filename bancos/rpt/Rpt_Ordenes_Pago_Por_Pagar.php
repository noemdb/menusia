<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="03-0000017"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
 $nro_orden_d="";$nro_orden_h="";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$cedula_d="";$cedula_h="";$tipo_orden_d="";$tipo_orden_h="";$ordenes="";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Reporte Relacion Ordenes de Pago por Pagar)</title>
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
function Llama_Rpt_Ordenes_Pago_Por_Pa(murl){var url;var r;var ord="O";
  r=confirm("Desea Generar el Reporte Ordenes de Pago Por Pagar?");
  if (r==true){
    url=murl+"?nro_orden_d="+document.form1.txtnro_orden_d.value+"&nro_orden_h="+document.form1.txtnro_orden_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&tipo_orden_d="+document.form1.txttipo_ordend.value+"&tipo_orden_h="+document.form1.txttipo_ordenh.value+"&tipo_rpt="+document.form1.tipo_rpt.value;;
    window.open(url,"Reporte Ordenes de Pago Por Pagar")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
</head>
<?
$sql="SELECT MAX(Ced_Rif) As Max_Ced_Rif, MIN(Ced_Rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
$sql="SELECT MAX(nro_orden) As Max_nro_orden, MIN(nro_orden) As Min_nro_orden FROM ORD_PAGO";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$nro_orden_d=$registro["min_nro_orden"];$nro_orden_h=$registro["max_nro_orden"];}
$sql="SELECT MAX(Tipo_Orden) As Max_Tipo_Orden, MIN(Tipo_Orden) As Min_Tipo_Orden FROM TIPOS_ORDEN";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_orden_d=$registro["min_tipo_orden"];$tipo_orden_h=$registro["max_tipo_orden"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="45"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE ORDENES DE PAGO POR PAGAR </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="360" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="355">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:390px; z-index:1; top: 53px; left: 23px;">
        <form name="form1" method="get">
           <table width="950" height="356" border="0">
    <tr>
      <td width="958" height="352" align="center" valign="top"><table width="783" height="351" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="2" align="center"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2" align="center"  ><table width="757" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="207">&nbsp;</td>
              <td width="227"><span class="Estilo13">DESDE</span></td>
              <td width="323"><span class="Estilo13">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2" align="center"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2" align="center"  ><table width="776" border="0">
              <tr>
                <td width="191" height="26"><span class="Estilo5"><div align="left">NUMERO DE ORDEN:</div></span></td>
                <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden_d" type="text" id="txtnro_orden_d" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkreferenciad(this.form)" value="<?echo $nro_orden_d?>" size="15" maxlength="8" class="Estilo5"></span></td>
                <td width="105"></td>
                <td width="101"><span class="Estilo5"><input class="Estilo10" name="txtnro_orden_h" type="text" id="txtnro_orden_h" onFocus="encender(this)" onBlur="apagar(this)" onchange="checkreferenciah(this.form)" value="<?echo $nro_orden_h?>" size="15" maxlength="8" class="Estilo5"></span></td>
                <td width="237"></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2" align="center"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2"><table width="776" align="center" border="0" >
              <tr>
                <td width="190" align="center"><span class="Estilo5"><div align="left">FECHA ORDEN:</div></span></td>
                <td width="223" align="center"><div align="left"><span class="Estilo5">
                    <input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)" class="Estilo5">
                    <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
                <td width="349" align="center"><div align="left"><span class="Estilo5">
                    <input class="Estilo10" name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)" class="Estilo5">
                    <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2" align="center"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="2" align="center"  ><table width="776" border="0">
            <tr>
              <td width="190" height="26"><span class="Estilo5"><div align="left">CEDULA/RIF: </div></span></td>
              <td width="97"><span class="Estilo5"><input class="Estilo10" name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)"  size="15" value="<?echo $cedula_d?>" maxlength="12" class="Estilo5"></span></td>
              <td width="110"><span class="Estilo5"><input class="Estilo10" name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Benefd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
              <td width="97"><span class="Estilo5"><input class="Estilo10" name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" size="15" value="<?echo $cedula_h?>" maxlength="12" class="Estilo5"></span></td>
              <td width="253"><span class="Estilo5"><input class="Estilo10" name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Benefh.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="2" align="center"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="18" colspan="2"><table width="776" border="0">
            <tr>
              <td width="190" height="26"><span class="Estilo5"><div align="left">TIPO ORDEN : </div></span></td>
              <td width="70"><span class="Estilo5"><input class="Estilo10" name="txttipo_ordend" type="text" id="txttipo_ordend" onFocus="encender(this)" onBlur="apagar(this)" size="6" value="<?echo $tipo_orden_d?>" maxlength="4" class="Estilo5"></span></td>
              <td width="130"><span class="Estilo5"><input class="Estilo10" name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Tipo Orden" onClick="VentanaCentrada('../Cat_tipo_ordend.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
              <td width="70"><span class="Estilo5"><input class="Estilo10" name="txttipo_ordenh" type="text" id="txttipo_ordenh" onFocus="encender(this)" onBlur="apagar(this)" size="6" value="<?echo $tipo_orden_h?>" maxlength="4" class="Estilo5"></span></td>
              <td width="290"><span class="Estilo5"><input class="Estilo10" name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo de Tipo Orden" onClick="VentanaCentrada('../Cat_tipo_ordenh.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td height="18" colspan="3">&nbsp;</td>  </tr> 
		<tr>
		  <td height="18" colspan="2"><table width="776" border="0">
			  <tr>
				<td width="190" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="586"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt"> <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select>
				</span></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
        <tr>
          <td height="18" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td height="59" colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Ordenes_Pago_Por_Pa('../../pagos/rpt/Rpt_Ordenes_Pago_Por_Pa.php');">   </div></td>
              <td><div align="center"> <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">   </div></td>
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
