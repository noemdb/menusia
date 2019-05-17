<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="03-0000155"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
$cedula_d=""; $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Reporte Comprobante Retenciones ISRL)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_Comp_Islr(murl){var url; var r;
  r=confirm("Desea Generar el Reporte Comprobaten Retenciones ISLR ?");
  if (r==true) {url=murl+"?cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&tipo_rpt="+document.form1.tipo_rpt.value+"&redondear="+document.form1.txtredonde_monto.value+"&detallado="+document.form1.txtdetallado.value;
    window.open(url,"Comprobaten Retenciones ISLR"); }
}
function Llama_Menu_Rpt(murl){var url;   url="../"+murl;   LlamarURL(url);}
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE COMPROBANTE RETENCIONES ISRL </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="268" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="262">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:258px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="248" border="0">
			<tr>
			  <td width="958" height="244" align="center" valign="top"><table width="783" height="224" border="0" cellpadding="0" cellspacing="0">
				<tr>
				  <td width="783" height="19" align="center" >&nbsp;</td>
				</tr>
				<tr>
				  <td height="19" colspan="5" align="center" ><table width="784" border="0">
					<tr>
					  <td width="188" height="26"><div align="left"><span class="Estilo5">CEDULA /RIF DESDE : </span></div></td>
					  <td width="130"><span class="Estilo5"><input class="Estilo10" name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedula_d?>" size="15" maxlength="12"></span></td>
					  <td width="108"><span class="Estilo5"><input class="Estilo10" name="cat_cedd" type="button" id="cat_cedd" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Beneficiariosd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
					  <td width="127"><span class="Estilo5"><input class="Estilo10" name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedula_h?>" size="15" maxlength="12"></span></td>
					  <td width="209"><span class="Estilo5"><input class="Estilo10" name="cat_cedh" type="button" id="cat_cedh" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('../Beneficiariosh.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
					</tr>
				  </table></td>
				</tr>
				<tr>
				  <td height="19" align="center" >&nbsp;</td>
				</tr>
				<tr>
				 <td height="19" colspan="5" align="center" ><table width="784" border="0">
					<tr>
					  <td width="188" height="26"> <div align="left"><span class="Estilo5">REDONDEAR MONTO : </span></div></td>
					  <td width="238"><span class="Estilo5"> <select class="Estilo10" name="txtredonde_monto" id="txtredonde_monto"> <option>NO</option> <option>SI</option> </select> </span></td>
					  <td width="97"><span class="Estilo5">DETALLADO :</span></td>
					  <td width="239"><span class="Estilo5"><select class="Estilo10" name="txtdetallado" id="txtdetallado"><option>NO</option> <option>SI</option> </select></span></td>
					</tr>
				  </table></td>
				</tr>
				<tr>
				  <td height="19" align="center" >&nbsp;</td>
				</tr>
				
				<tr>
				 <td height="19" colspan="5" align="center" ><table width="784" border="0">
					<tr>
					  <td width="188" class="Estilo5"> TIPO DE REPORTE :</td>
					  <td width="596"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt">
					    <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option></select></span></td>
					</tr>
				  </table></td>
				</tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
				<tr>
				  <td height="19" align="center" >&nbsp;</td>
				</tr>
				<tr>
				  <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr align="center" valign="middle">
					  <td><div align="center"><input  name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Comp_Islr('Rpt_Comp_ret_islr.php');"> </div></td>
					  <td><div align="center"> <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"> </div></td>
					</tr>
				  </table></td>
				</tr>
				<tr> <td height="19">&nbsp;</td> </tr>
			  </table></td>
			</tr>
		  </table>
        </form>
    </div>  
</tr>
</table>
</body>
</html>
<? pg_close();?>
