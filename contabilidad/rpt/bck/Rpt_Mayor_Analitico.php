<?php include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <?php } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="03-0000040"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?php }
  $periodod='01';$periodoh='01';   $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
 $cod_cuenta_d=""; $cod_cuenta_h="9-9-999-99-99-9999"; $tipo_asiento_d=""; $tipo_asiento_h="zzz"; $cedula_d="";$cedula_h="zzzzzzzzzzzz"; $salto_pag="S"; $ordenar="S"; $imprimir="N";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP CONTABILIDAD (Reporte Mayor Analitico)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref; var mfec;  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){  mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref; var mfec;  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtFechah.value=mfec;}
return true;}
function Llama_Rpt_Mayor_A(murl){var url; var r; var imp;   var saltopag;var ord;  ord="S";
  if(document.form1.opimprimir[0].checked==true){imp="S";}
  if(document.form1.opimprimir[1].checked==true){imp="N";}
  r=confirm("Desea Generar el Reporte Mayor Analitico ?");
  if (r==true) { url=murl+"?fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&cod_cuenta_d="+document.form1.txtCodigo_Cuenta_D.value+"&cod_cuenta_h="+document.form1.txtCodigo_Cuenta_H.value+"&tipo_asiento_d="+document.form1.txttipo_asientod.value+"&tipo_asiento_h="+document.form1.txttipo_asientoh.value+"&ced_rif_d="+document.form1.txtcedula_d.value+"&ced_rif_h="+document.form1.txtcedula_h.value+"&ordenar="+ord+"&imprimir="+imp+"&tipo_rep="+document.form1.txttipo_rep.value+"&inc_benef="+document.form1.txtinc_benef.value;
    window.open(url,"Reporte Mayor Analitico")
  }
}
function Llama_Menu_Rpt(murl){var url;    url="../"+murl;  LlamarURL(url);}
</script>
</head>
<?php 
$sql="SELECT MAX(Referencia) As Max_Referencia, MIN(Referencia) As Min_Referencia,MAX(Tipo_Asiento) As Max_Tipo,MIN(Tipo_Asiento) As Min_Tipo FROM CON002";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$referencia_d=$registro["min_referencia"];$referencia_h=$registro["max_referencia"];$tipo_asiento_d=$registro["min_tipo"];$tipo_asiento_h=$registro["max_tipo"];}
$sql="SELECT MAX(ced_rif) As Max_Ced_Rif, MIN(ced_rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
$sql="SELECT MAX(cod_cuenta) As max_cod_cuenta, MIN(cod_cuenta) As min_cod_cuenta FROM con003";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cod_cuenta_d=$registro["min_cod_cuenta"];$cod_cuenta_h=$registro["max_cod_cuenta"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE MAYOR ANALITICO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="451" border="1" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:961px; height:484px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="959" height="437" border="0">
			<tr>
			  <td width="958" height="283" align="center" valign="top"><table width="830" height="430" border="0" cellpadding="0" cellspacing="0">
				<tr>
				  <td width="1566" colspan="2"><table width="785" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td width="170" align=""left"><span class="Estilo5">FECHA DESDE: </span></td>
					  <td width="268" align="left"><span class="Estilo5"><input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_d?>" size="12" maxlength="10" onchange="checkrefechad(this.form)">
						 <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
						onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></td>
					  <td width="70" align="left"><span class="Estilo5">HASTA:</span></div></td>
					  <td width="286" align="center"> <div align="left"><span class="Estilo5"> <input class="Estilo10" name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $fecha_h?>" size="12" maxlength="10" onchange="checkrefechah(this.form)">
						  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
						onmouseover="this.style.background='blue';" onmouseout="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></td>
					  </tr>
				  </table></td>
				</tr>
				<tr> <td colspan="2">&nbsp;</td></tr>
				<tr>
				  <td colspan="2"><div align="center">
					<table width="785" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td width="170" align="left"><span class="Estilo5">CODIGO CUENTA DESDE: </span></td>
						<td width="198"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Cuenta_D" type="text" id="txtCodigo_Cuenta_D" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_cuenta_d?>" size="28" maxlength="30"></span></td>
						<td width="61"><span class="Estilo5"><input class="Estilo10" name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
						<td width="70" align="left"><span class="Estilo5">HASTA:</span></td>
						<td width="200"><span class="Estilo5"><input class="Estilo10" name="txtCodigo_Cuenta_H" type="text" id="txtCodigo_Cuenta_H" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cod_cuenta_h?>" size="28" maxlength="30"> </span></td>
					   <td width="86"><span class="Estilo5"><input class="Estilo10" name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesh.php?criterio=','SIPAP','','750','500','true')" value="..."></span></td>
						</tr>
					</table>
				  </div></td>
				</tr> 
				<tr><td colspan="2">&nbsp;</td> </tr>
				<tr>
				  <td colspan="2"><div align="center">
					<table width="785" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td width="170" align="left"><span class="Estilo5">TIPO ASIENTO DESDE: </span></td>
						<td width="259" align="left"><span class="Estilo5">   <input class="Estilo10" name="txttipo_asientod" type="text" id="txttipo_asientod" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_asiento_d?>" size="6" maxlength="3">
							  <input class="Estilo10" name="cattipod" type="button" id="cattipod" title="Abrir Catalogo Tipos de Asientos" onclick="VentanaCentrada('../Cat_tipo_asientod.php?criterio=','SIPAP','','650','500','true')" value="..."></span></td>					
						<td width="70" align="left"><span class="Estilo5">HASTA:</span></td>
						<td width="286" align="left"><span class="Estilo5">  <input class="Estilo10" name="txttipo_asientoh" type="text" id="txttipo_asientoh" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $tipo_asiento_h?>" size="6" maxlength="3">
							  <input class="Estilo10" name="cattipoh" type="button" id="cattipoh" title="Abrir Catalogo Tipos de Asientos" onclick="VentanaCentrada('../Cat_tipo_asientoh.php?criterio=','SIPAP','','650','500','true')" value="..."></span></td>
					  </tr>
					</table>
				  </div></td>
				</tr> 
				<tr><td colspan="2">&nbsp;</td>  </tr>
				<tr>
				  <td colspan="2"><div align="center">
					<table width="785" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td width="170" align="left"><span class="Estilo5">CEDULA/RIF DESDE : </span></td>
						<td width="259" align="left"><span class="Estilo5"> <input class="Estilo10" name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_d?>" size="15" maxlength="12">
							<input class="Estilo10" name="cat_rifd" type="button" id="cat_rifd" title="Abrir Catalogo Beneficiario" onclick="VentanaCentrada('../Cat_Beneficiariosd.php?criterio=','SIPAP','','650','500','true')" value="..."> </span></td>
					    <td width="70" align="left"><span class="Estilo5">HASTA:</span></td>
						<td width="286" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?php echo $cedula_h?>" size="15" maxlength="12">
							<input class="Estilo10" name="cat_rifh" type="button" id="cat_rifh" title="Abrir Catalogo Beneficiario" onclick="VentanaCentrada('../Cat_Beneficiariosh.php?criterio=','SIPAP','','650','500','true')" value="..."> </span></td>
					  </tr>
					</table>
				  </div></td>
				</tr>        
			   <tr><td colspan="2">&nbsp;</td>  </tr>
				<tr>
				  <td colspan="2"><table width="785" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td width="246" align="left"><span class="Estilo5">IMPRIMIR CUENTAS SIN MOVIMIENTOS :</span></td>
					  <td width="183" align="left"><table width="113" height="30" border="1">
						  <tr>
							<td width="126" valign="top"><label><input class="Estilo10" name="opimprimir" type="radio" value="S" checked>  <span class="Estilo5"> SI </span></label>
								<label><input class="Estilo10" name="opimprimir" type="radio" value="N"> <span class="Estilo5"> NO </span></label></td>
						  </tr>
						</table>
						  <span class="Estilo5"> </span></td>
					  <td width="286" align="left"><span class="Estilo5"> </span></td>
					</tr>
				  </table></td>
				</tr>
				<tr> <td colspan="2">&nbsp;</td> </tr>
				<tr>
				  <td colspan="2"><table width="785" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td width="170" align="left"><span class="Estilo5">TIPO DE REPORTE : </span></td>
					  <td width="259" align="left"><span class="Estilo5"><select class="Estilo10" name="txttipo_rep" size="1" id="txttipo_rep" onFocus="encender(this)" onBlur="apagar(this)">
						  <option value='HTML'>FORMATO HTML CORTO</option> <option value='HTMLL'>FORMATO HTML LARGO</option> 
						  <option value='PDF'>FORMATO PDF</option> <option value='EXCEL'>FORMATO EXCEL</option> </select> </span></td>
					  <td width="170" align="left"><span class="Estilo5">INCLUIR BENEFICIARIO : </span></td>
					  <td width="186" align="left"><span class="Estilo5"><select class="Estilo10" name="txtinc_benef" size="1" id="txtinc_benef" onFocus="encender(this)" onBlur="apagar(this)">
						  <option value='NO'>NO</option> <option value='SI'>SI</option> </select></span></td>
					</tr>
				  </table></td>
				</tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.txttipo_rep.options[2].selected = true;}else{document.form1.txttipo_rep.options[0].selected = true;} </script>

				<tr>
				  <td colspan="2">&nbsp;</td>
				</tr>
				<tr>
				  <td colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr align="center" valign="middle">
					  <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Mayor_A('Rpt_Mayor_A.php');"> </div></td>
					  <td><div align="center"> <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></div></td></tr>
				  </table></td>
				</tr>
				<tr>
				  <td height="38" colspan="2">&nbsp;</td>
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
<?php  pg_close($conn);?>
