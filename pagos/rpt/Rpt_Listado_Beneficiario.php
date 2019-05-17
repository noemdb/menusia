<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="03-0000057"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
 $cedula_d="";$cedula_h="";$clasificacion_d="";$clasificacion_h="";$detallado="";$ordenado="";$vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA ORDENAMIENTO DE PAGOS (Reporte Listado Beneficiario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<SCRIPT language="JavaScript" src="../../class/sia.js" type="text/javascript"></SCRIPT>
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
function Llama_Rpt_Listado_Benefi(murl){var url;var r;var det;var ord;
  if(document.form1.opdetallado[0].checked==true){det="S";}
  if(document.form1.opdetallado[1].checked==true){det="N";}
  if(document.form1.opordenar[0].checked==true){ord="ced_rif";}
  if(document.form1.opordenar[1].checked==true){ord="nombre";}
  r=confirm("Desea Generar el Reporte Listado Beneficiario?");
  if (r==true) { url=murl+"?cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&clasificacion_d="+document.form1.txtclasificacion_d.value+"&clasificacion_h="+document.form1.txtclasificacion_h.value+"&detallado="+det+"&ordenado="+ord+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url,"Reporte Listado Beneficiario") }
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
</head>
<?
$sql="SELECT MAX(Ced_Rif) As Max_Ced_Rif, MIN(Ced_Rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE LISTADO BENEFICIARIO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="350" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="331">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:303px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="300" border="0">
    <tr>
      <td width="958" height="296" align="center" valign="top"><table width="783" height="308" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="19" colspan="3" align="center"  >&nbsp;</td>
        </tr>
        <tr>
          <td width="219">&nbsp;</td>
          <td width="266"><span class="Estilo5"><strong>DESDE</strong></span></td>
          <td width="299"><span class="Estilo5"><strong>HASTA</strong></span></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  ><table width="784" border="0">
            <tr>
              <td width="199" height="26"><span class="Estilo5"><div align="left">CEDULA /RIF: </div></span></td>
              <td width="99"><span class="Estilo5"> <input class="Estilo10" name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedula_d?>" size="15" maxlength="15"></span></td>
              <td width="118"><span class="Estilo5"><input class="Estilo10" name="catcedd" type="button" id="catcedd" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Beneficiariosd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
              <td width="102"><span class="Estilo5"><input class="Estilo10" name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedula_h?>" size="15" maxlength="15"></span></td>
              <td width="253"><span class="Estilo5"><input class="Estilo10" name="catcedh" type="button" id="catcedh" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Cat_Beneficiariosh.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  ><table width="782" border="0">
            <tr>
              <td width="188" height="26"><span class="Estilo5"><p align="left">CLASIFICACION:</p></span></td>
              <td width="226"><span class="Estilo5"><select class="Estilo10" name="txtclasificacion_d" id="txtclasificacion_d">
                  <option></option> <option value="PROVEEDOR">PROVEDOR</option> <option>COOPERATIVAS</option> <option >CONTRATISTAS</option> <option>MICROEMPRESAS</option>
                  <option>COLABORACIONES</option> <option>EMPLEADO</option> <option>PASANTES</option> <option>CLINICAS</option>
                  <option value="OTROS">OTROS</option>
                </select>
              </span></td>
              <td width="354"><span class="Estilo5"><select class="Estilo10" name="txtclasificacion_h" id="txtclasificacion_h">
                  <option>zzzzzzzzzzzzzzzzzzzz</option>  <option value="PROVEEDOR">PROVEDOR</option> <option>COOPERATIVAS</option> <option>CONTRATISTAS</option>  <option>MICROEMPRESAS</option>
                  <option>COLABORACIONES</option> <option>EMPLEADO</option> <option>PASANTES</option> <option>CLINICAS</option>
                  <option value="OTROS">OTROS</option>
                </select>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="378"><span class="Estilo5">DETALLADO:</span></td>
              <td width="386"><span class="Estilo5">ORDENADO POR:</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  ><table width="771" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="10">&nbsp;</td>
              <td width="365"><table width="113" height="30" border="1">
                  <tr>
                    <td width="126" valign="top"><label> <input class="Estilo10" name="opdetallado" type="radio" value="S"><span class="Estilo5">SI</span></label>
                        <label> <input class="Estilo10" name="opdetallado" type="radio" value="N"  checked> <span class="Estilo5">NO</span></label></td>
                  </tr>
              </table></td>
              <td width="386"><table width="245" height="30" border="1">
                <tr>
                  <td width="248" valign="top"><label><input class="Estilo10" name="opordenar" type="radio" value="ced_rif" checked><span class="Estilo5">CEDULA/RIF</span></label>
                      <label><input type="radio" name="opordenar" value="nombre"> <span class="Estilo5">NOMBRE</span></label></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center">&nbsp;</td>
        </tr>
		<tr>
		  <td height="19" colspan="3" align="center"  ><table width="782" border="0">
			  <tr>
				<td width="188" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="580"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt"> <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select></span></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
        <tr>
          <td height="80" colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Listado_Benefi('Rpt_Listado_Benefi.php');"> </td>
              <td align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">    </td>
			</tr>
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
    <div align="left"></div></td>
</tr>
</table>
</body>
</html>
<? pg_close();?>
