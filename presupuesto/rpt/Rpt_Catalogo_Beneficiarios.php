<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="Javascript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="03-0000030"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
 $cedrifd="zzzzzzzzzz"; $cedrifh="zzzzzzzzzz"; $clasificad=""; $clasificah=""; $detallado="S"; 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte Catalogo de Beneficiarios)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_catalogo_benefi(murl){var url;var det;var ord;
  if(document.form1.opdetallado[0].checked==true){det="S";}
  if(document.form1.opdetallado[1].checked==true){det="N";}
  if(document.form1.opordenar[0].checked==true){ord="ced_rif";}
  if(document.form1.opordenar[1].checked==true){ord="nombre";}
  r=confirm("Desea Generar el Reporte Catalogo de Beneficiarios?");
  if (r==true) {  url=murl+"?cedrifd="+document.form1.txtced_rifd.value+"&cedrifh="+document.form1.txtced_rifh.value+"&clasificad="+document.form1.txtclasificacion_d.value+"&clasificah="+document.form1.txtclasificacion_h.value+"&detallado="+det+"&ordenado="+ord+"&tipo_rep="+document.form1.txttipo_rep.value;
        window.open(url);
  }
}
function Llama_Menu_Rpt(murl){var url;   url="../"+murl; LlamarURL(url);}
</script>
</head>
<?$sql="SELECT MAX(ced_rif) As Max_bene, MIN(ced_rif) As Min_bene  FROM PRE099";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){ $cedrifd=$registro["min_bene"]; $cedrifh=$registro["max_bene"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE CATALOGO DE BENEFICIARIOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="974" height="394" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="388">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:360px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="352" border="0">
    <tr>
      <td width="958" height="348" align="center" valign="top"><table width="830" height="330" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="830" height="19" align="center" class="Estilo16">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  ><table width="784" border="0">
            <tr>
              <td width="199">&nbsp;</td>
              <td width="227"><span class="Estilo12">DESDE</span></td>
              <td width="355"><span class="Estilo12">HASTA</span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  ><table width="784" border="0">
            <tr>
              <td width="199" height="26"><span class="Estilo5"><div align="left">CEDULA /RIF: </div></span></td>
              <td width="99"><span class="Estilo5"> <input class="Estilo10" name="txtced_rifd" type="text" id="txtced_rifd" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedrifd?>" size="15" maxlength="15" class="Estilo5">  </span></td>			  
              <td width="118"><span class="Estilo5"><input class="Estilo10" name="catcedd" type="button" id="catcedd" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_benefi_d.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
              <td width="102"><span class="Estilo5"><input class="Estilo10" name="txtced_rifh" type="text" id="txtced_rifh" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedrifh?>" size="15" maxlength="15" class="Estilo5">   </span></td>
              <td width="253"><span class="Estilo5"><input class="Estilo10" name="catcedh" type="button" id="catcedh" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('Cat_benefi_h.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  >&nbsp;</td>
        </tr>
        <tr>
          <td height="19" colspan="3" align="center"  ><table width="782" border="0">
            <tr>
              <td width="193" height="26"><span class="Estilo5">
                <p align="left">CLASIFICACION:</p></span></td>
              <td width="221"><span class="Estilo5">
                <select class="Estilo10" name="txtclasificacion_d" id="txtclasificacion_d">
                  <option></option> <option value="PROVEEDOR">PROVEDOR</option>
                  <option >CONTRATISTAS</option> <option>MICROEMPRESAS</option>
                  <option>COLABORACIONES</option> <option>EMPLEADO</option>
                  <option value="OTROS">OTROS</option>
                </select>
              </span></td>
              <td width="354"><span class="Estilo5"><select class="Estilo10" name="txtclasificacion_h" id="txtclasificacion_h">
                  <option>zzzzzzzzzzzzzzzzzzzz</option>  <option value="PROVEEDOR">PROVEDOR</option>
                  <option>CONTRATISTAS</option>  <option>MICROEMPRESAS</option>
                  <option>COLABORACIONES</option> <option>EMPLEADO</option>
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
              <td width="189">&nbsp;</td>
              <td width="186"><table width="113" height="30" border="1">
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
	<tr> <td>&nbsp;</td></tr>
	 <tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="217" align="right"><div align="left"><span class="Estilo5"> TIPO DE REPORTE : </span></div></td>
              <td width="601"><span class="Estilo5">
                <select class="Estilo10" name="txttipo_rep" size="1" id="txttipo_rep" onFocus="encender(this)" onBlur="apagar(this)">
			<option value='HTML'>FORMATO HTML</option>  <option value='PDF'>FORMATO PDF</option> <option value='EXCEL'>FORMATO EXCEL</option> </select></td>
            </tr>
          </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.txttipo_rep.options[1].selected = true;}else{document.form1.txttipo_rep.options[0].selected = true;} </script>

        <tr>
          <td height="101"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_catalogo_benefi('Rpt_catalogo_bene.php');"></td>
              <td align="center"> <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">  </td>
		     </tr>
          </table></td>
        </tr>
        <tr><td height="19">&nbsp;</td></tr>
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
