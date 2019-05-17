<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="03-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
 $cod_cuenta_d="";  $cod_cuenta_h="9-9-999-99-99-9999";   $vstatus="T";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD (Reporte Resumen de Diario)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref; var mfec;  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref; var mfec;  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechah.value=mfec;}
return true;}
function Llama_Rpt_Res_Diario(murl){var url; var r;  var st;
  if(document.form1.opcomprob[0].checked==true){st="A";}
  if(document.form1.opcomprob[1].checked==true){st="D";}
  if(document.form1.opcomprob[2].checked==true){st="T";}
  r=confirm("Desea Generar el Reporte Resumen de Diario ?");
  if (r==true) {   url=murl+"?fecha_d="+document.form1.txtFechad.value+"&cod_cuenta_d="+document.form1.txtCodigo_Cuenta_D.value+"&fecha_h="+document.form1.txtFechah.value+"&cod_cuenta_h="+document.form1.txtCodigo_Cuenta_H.value+"&vstatus="+st+"&tipo_rpt="+document.form1.tipo_rpt.value;
   window.open(url,"Reporte  Resumen de Diario")
  }
}
function Llama_Menu_Rpt(murl){var url;    url="../"+murl;  LlamarURL(url);}
</script>
</head>
<?
$sql="SELECT MAX(codigo_cuenta) As max_cod_cuenta, MIN(codigo_cuenta) As min_cod_cuenta FROM con001";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cod_cuenta_d=$registro["min_cod_cuenta"];$cod_cuenta_h=$registro["max_cod_cuenta"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE RESUMEN DE DIARIO</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="324" border="1" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:306px; z-index:1; top: 68px; left: 18px;">
        <form name="form1" method="get">
           <table width="941" height="287" border="0">
    <tr>
      <td width="958" height="283" align="center" valign="top"><table width="783" border="0" cellspacing="0" cellpadding="0">
        <tr><td colspan="3">&nbsp;</td>  </tr>
        <tr>
          <td colspan="3"><table width="781" border="0">
            <tr>
              <td width="167"><div align="right"><span class="Estilo5">FECHA DESDE: </span></div></td>
              <td width="72"><span class="Estilo5"><input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onchange="checkrefechad(this.form)">  </span></td>
              <td width="47"><span class="Estilo5"><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onmouseover="this.style.background='blue';" onmouseout="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></td>
              <td width="135"><div align="right"></div></td>
              <td width="64"><span class="Estilo5">HASTA:</span></td>
              <td width="72"><span class="Estilo5"><input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onchange="checkrefechah(this.form)">   </span></td>
              <td width="194"><span class="Estilo5"><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onmouseover="this.style.background='blue';" onmouseout="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /></span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td colspan="3">&nbsp;</td>  </tr>
        <tr>
          <td colspan="3"><table width="783" border="0">
            <tr>
              <td width="168"><div align="right"><span class="Estilo5">CUENTA DESDE:</span></div></td>
              <td width="205"><span class="Estilo5"><input name="txtCodigo_Cuenta_D" type="text" id="txtCodigo_Cuenta_D" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cuenta_d?>" size="25" maxlength="25">  </span></td>
              <td width="52"><span class="Estilo5"> <input name="Catalogo3" type="button" id="Catalogo32" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIA','','750','500','true')" value="...">    </span></td>
              <td width="65"><span class="Estilo5">HASTA:</span></td>
              <td width="212"><span class="Estilo5"> <input name="txtCodigo_Cuenta_H" type="text" id="txtCodigo_Cuenta_H" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cuenta_h?>" size="25" maxlength="25"> </span></td>
              <td width="55"><span class="Estilo5"><input name="Catalogo4" type="button" id="Catalogo43" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesh.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td colspan="3">&nbsp;</td>  </tr>
        <tr>
          <td colspan="3"><table width="774" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td width="168"><div align="right"><span class="Estilo5">COMPROBANTES: </span></div></td>
              <td width="603"><table width="317" height="32" border="1">
                <tr>
                  <td width="288" height="30" valign="top"><label>
                    <input type="radio" name="opcomprob" value="A"><span class="Estilo5"> Actuales</span></label>
                    <input type="radio" name="opcomprob" value="D"> <label><span class="Estilo5">Diferidos</span></label>
                    <input name="opcomprob" type="radio" value="T" checked><label><span class="Estilo5">Todos</span></label>
                  </td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
	      <td ><table width="590" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="136" align="left"><span class="Estilo5">TIPO DE REPORTE :</span></td>
				<td width="194" align="left"><span class="Estilo5"><select name="tipo_rpt" id="tipo_rpt">
				  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select>
				</span></td>
				<td width="260"></td>
			  </tr>
			</table></td>
		</tr>	
		<tr><td colspan="2">&nbsp;</td> </tr>
		<tr><td colspan="2">&nbsp;</td> </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>	
    
        <tr>
          <td colspan="3"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Res_Diario('Rpt_Resumen_Dia.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="38" colspan="3">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
        </form>
      </div>
    </td>
</tr>
</table>
</body>
</html>
<? pg_close();?>
