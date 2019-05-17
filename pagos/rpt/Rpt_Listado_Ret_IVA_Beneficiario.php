<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="03-0000080"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
 $cedula_d="";$cedula_h="";$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$comprobante_d="00000000";$comprobante_h="99999999";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGO (Reporte Listado Retencion IVA)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechah.value=mfec;}
return true;}

function Llama_Rpt_Listado_Ret_IVA_Benefi(murl){var url;var r;
   r=confirm("Desea Generar el Reporte Listado Retencion IVA por Beneficiario?");
  if (r==true){
    url=murl+"?cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&comprobante_d="+document.form1.txtnum_comprobante_d.value+"&comprobante_h="+document.form1.txtnum_comprobante_h.value+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url,"Reporte Listado Retencion IVA por Beneficiario")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?
$sql="SELECT MAX(Ced_Rif) As Max_Ced_Rif, MIN(Ced_Rif) As Min_Ced_Rif FROM PRE099"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO RETENCI&Oacute;N IVA POR BENEFICIARIO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="350" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="309"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
        <div id="Layer1" style="position:absolute; width:1011px; height:833px; z-index:1; top: 75px; left: 16px;">
          <form name="form1" method="get">
            <table width="950" height="290" border="0">
              <tr>
                <td width="958" height="286" align="center" valign="top"><table width="783" height="214" border="0" cellpadding="0" cellspacing="0">
                   
                    <tr>
                      <td height="19" colspan="6"><table width="784" border="0">
                          <tr>
                            <td width="201">&nbsp;</td>
                            <td width="163"><span class="Estilo13">DESDE</span></td>
                            <td width="293"><span class="Estilo13">HASTA</span></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="19" colspan="6"></td>
                    </tr>
					<tr>
                      <td height="19" colspan="4"><table width="782" border="0">
                          <tr>
                            <td width="207" height="26" class="Estilo5"><p align="left">CEDULA /RIF :</p></td>
                            <td width="101"><span class="Estilo5">
                              <input class="Estilo10" name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedula_d?>" size="15" maxlength="12" class="Estilo5">
                                      </span></td>
                                      <td width="71"><span class="Estilo5">
                                        <input class="Estilo10" name="Catalogo1" type="button" id="Catalogo14" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Beneficiariosd.php?criterio=','SIA','','750','500','true')" value="...">
                                      </span></td>
                                      <td width="106"><span class="Estilo12"><span class="Estilo5">
                                        <input class="Estilo10" name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedula_h?>" size="12" maxlength="15" class="Estilo5">
                                      </span></span></td>
                                      <td width="149"><span class="Estilo5">
                                        <input class="Estilo10" name="Catalogo2" type="button" id="Catalogo24" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Beneficiariosh.php?criterio=','SIA','','750','500','true')" value="...">
</span></td>
                            <td width="122"><span class="Estilo5">
                            </span></td>
                          </tr>
                      </table></td>
                    </tr>
                    
                    <tr>
                      <td height="19" colspan="6"></td>
                    </tr>
                    <tr>
                      <td height="19" colspan="6"><table width="776" border="0">
                          <tr>
                            <td width="210" height="27" class="Estilo5">FECHA DESDE</td>
                            <td width="171"><span class="Estilo5">
                              <input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)" class="Estilo5">
                            </span><span class="Estilo5"><span class="Estilo5"><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></td>
              <td width="381" align="center"><div align="left"><span class="Estilo5">
                <input class="Estilo10" name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)" class="Estilo5">
              </span><span class="Estilo5"><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /></span></div></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="19" colspan="6"></td>
                    </tr>
                    <tr>
                      <td width="217" height="26" class="Estilo5"><p align="left">Nro. COMPROBANTE:</p></td>
                      <td width="174"><span class="Estilo5">
                        <input class="Estilo10" name="txtnum_comprobante_d" type="text" id="txtnum_comprobante_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $comprobante_d?>" size="10" maxlength="8" class="Estilo5">
                      </span></td>
                      <td width="393"><span class="Estilo5">
                        <input class="Estilo10" name="txtnum_comprobante_h" type="text" id="txtnum_comprobante_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $comprobante_h?>" size="10" maxlength="8" class="Estilo5">
                      </span></td>
                    </tr>
                   <tr>
                      <td height="19" colspan="4">&nbsp;</td>
                    </tr>
                     <tr>
                        <td height="19" colspan="3"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
                             <tr>
								<td width="214" class="Estilo5"> TIPO DE REPORTE :</td>
								<td width="550"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt">
								  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select>	</span></td>
							  </tr>
                         </table></td>
                    </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>

                     <tr>
                      <td height="19" colspan="6">&nbsp;</td>
                     </tr>
					 <tr>
                      <td height="19" colspan="4">&nbsp;</td>
                     </tr>
                      <td colspan="6"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr align="center" valign="middle">
                            <td><div align="center"><input name="btgenera" type="button" id="btgenera2" value="GENERAR" onClick="javascript:Llama_Rpt_Listado_Ret_IVA_Benefi('Rpt_Listado_Ret_IVA_Benefi.php');"></div></td>
                            <td><div align="center"><input name="btcancelar" type="button" id="btcancelar2" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">  </div></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="19" colspan="6">&nbsp;</td>
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
<? pg_close();?>
