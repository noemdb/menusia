<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="03"; $opcion="03-0000040"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
 $periodod='01'; $periodoh='01';  $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
 $cod_cuenta_d=""; $cod_cuenta_h="zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz"; $cod_cat_d="00-00-0-0-00";  $cod_cat_h="99-99-9-9-99"; $cod_par_d="00-00-0-0-00"; $cod_par_h="999-99-99-99-99"; $tipo_asiento_d=""; $tipo_asiento_h="zzz"; $salto_pag="S";  $ordenar="S";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTABILIDAD (Reporte Mayor Analitico de Presupuesto)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_Mayor_Analitico_Presup(murl){var url; var r; var imp; var saltopag='N'; var ord='N';  
  r=confirm("Desea Generar el Reporte Mayor Analitico de Presupuesto ?");
  if (r==true) {url=murl+"?fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+
   "&cod_cuenta_d="+document.form1.txtCodigo_Cuenta_D.value+"&cod_cat_d="+document.form1.txtcategoria_d.value+"&cod_cat_h="+document.form1.txtcategoria_h.value+
   "&cod_par_d="+document.form1.txtcod_partida_d.value+"&cod_par_h="+document.form1.txtcod_partida_h.value+ "&tipo_asiento_d="+document.form1.txtTipo_Asientod.value+"&tipo_asiento_h="+document.form1.txtTipo_Asientoh.value+
   "&salto_pag="+saltopag+"&ordenar="+ord+"&tipo_rep="+document.form1.txttipo_rep.value+"&inc_benef="+document.form1.txtinc_benef.value;
    window.open(url,"Reporte Mayor Analitico de Presupuesto ")
  }
}
function Llama_Menu_Rpt(murl){var url;    url="../"+murl;  LlamarURL(url);}
</script>
</head>
<?
$sql="SELECT MAX(Referencia) As Max_Referencia, MIN(Referencia) As Min_Referencia,MAX(Tipo_Asiento) As Max_Tipo,MIN(Tipo_Asiento) As Min_Tipo FROM CON002";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$referencia_d=$registro["min_referencia"];$referencia_h=$registro["max_referencia"];$tipo_asiento_d=$registro["min_tipo"];$tipo_asiento_h=$registro["max_tipo"];}
$sql="SELECT MAX(cod_cuenta) As max_cod_cuenta, MIN(cod_cuenta) As min_cod_cuenta FROM con003 where substring(cod_cuenta,1,1)='6'";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cod_cuenta_d=$registro["min_cod_cuenta"];$cod_cuenta_h=$registro["max_cod_cuenta"];}

?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE MAYOR ANALITICO DE PRESUPUESTO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="507" border="1" id="tablacuerpo">
  <tr>
    <td width="870">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:478px; z-index:1; top: 75px; left: 18px;">
        <form name="form1" method="get">
           <table width="950" height="471" border="0">
			<tr>
			  <td width="958" height="283" align="center" valign="top"><table width="783" height="455" border="0" cellpadding="0" cellspacing="0">
				<tr>
				  <td colspan="2" align="center" class="Estilo16">&nbsp;</td>
				</tr>
				<tr>
				  <td width="1566" colspan="2"><table width="785" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td width="170" align="left"><span class="Estilo5">FECHA DESDE: </span></td>
					  <td width="268" align="left"><span class="Estilo5"><input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onchange="checkrefechad(this.form)">
						 <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
						onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></td>
					  <td width="70" align="left"><span class="Estilo5">HASTA:</span></div></td>
					  <td width="286" align="center"> <div align="left"><span class="Estilo5"> <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onchange="checkrefechah(this.form)">
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
						<td width="170" align="left"><span class="Estilo5">CODIGO DE CUENTA DESDE: </span></td>
						<td width="198"><span class="Estilo5"><input name="txtCodigo_Cuenta_D" type="text" id="txtCodigo_Cuenta_D" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cuenta_d?>" size="28" maxlength="30"></span></td>
						<td width="61"><span class="Estilo5"><input name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('../Cat_cuentas_cargablesd.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
						<td width="70" align="left"><span class="Estilo5"></span></td>
						<td width="286"><span class="Estilo5"></span></td>
						</tr>
					</table>
				  </div></td>
				</tr> 
				<tr> <td colspan="2">&nbsp;</td></tr>
				<tr>
				  <td colspan="2"><div align="center">
					<table width="785" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td width="170" align="left"><span class="Estilo5">TIPO ASIENTO DESDE: </span></td>
						<td width="259" align="left"><span class="Estilo5">   <input name="txtTipo_Asientod" type="text" id="txtTipo_Asientod" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_asiento_d?>" size="6" maxlength="3">
							  <input name="cattipod" type="button" id="cattipod" title="Abrir Catalogo Tipos de Asientos" onclick="VentanaCentrada('../Cat_tipo_asientod.php?criterio=','SIA','','650','500','true')" value="..."></span></td>
					    <td width="70" align="left"><span class="Estilo5">HASTA:</span></td>
						<td width="286" align="left"><span class="Estilo5">  <input name="txtTipo_Asientoh" type="text" id="txtTipo_Asientoh" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_asiento_h?>" size="6" maxlength="3">
							  <input name="cattipoh" type="button" id="cattipoh" title="Abrir Catalogo Tipos de Asientos" onclick="VentanaCentrada('../Cat_tipo_asientoh.php?criterio=','SIA','','650','500','true')" value="..."></span></td>
					  </tr>
					</table>
				  </div></td>
				</tr>        
				<tr> <td colspan="2">&nbsp;</td></tr>
				<tr>
				  <td colspan="2"><table width="783" border="0">
					<tr>
					  <td width="170"><div align="left"><span class="Estilo5">COD.CATEGORIA DESDE: </span></div></td>
					  <td width="198"><span class="Estilo5"><input name="txtcategoria_d" type="text" id="txtcategoria_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cat_d?>" size="20" maxlength="20">  </span></td>
					  <td width="61"><span class="Estilo5"> <input name="cat_catd" type="button" id="cat_catd" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('/sia/compras/Cat_Categoriad.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
					  <td width="70"><span class="Estilo5">HASTA:</span></td>
					  <td width="200"><span class="Estilo5"><input name="txtcategoria_h" type="text" id="txtcategoria_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_cat_h?>" size="20" maxlength="20">	</span></td>
					  <td width="86"><span class="Estilo5"><input name="cat_cath" type="button" id="cat_cath" title="Abrir Catalogo de Cuentas" onClick="VentanaCentrada('/sia/compras/Cat_Categoriah.php?criterio=','SIA','','750','500','true')" value="...">	</span></td>
					</tr>
				  </table></td>
				</tr>
				<tr> <td colspan="2">&nbsp;</td></tr>
				<tr>
				  <td colspan="2"><table width="783" border="0">
					<tr>
					  <td width="170"><div align="left"><span class="Estilo5">COD.PARTIDA DESDE: </span></div></td>
					  <td width="198"><span class="Estilo5"><input name="txtcod_partida_d" type="text" id="txtcod_partida_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_par_d?>" size="20" maxlength="20"> </span></td>
					  <td width="61"><span class="Estilo5"><input name="Cat_partd" type="button" id="Cat_partd" title="Abrir Catalogo de Partidas" onClick="VentanaCentrada('../Cat_partidasd.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
					  <td width="70"><span class="Estilo5">HASTA:</span></td>
					  <td width="200"><span class="Estilo5"><input name="txtcod_partida_h" type="text" id="txtcod_partida_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_par_h?>" size="20" maxlength="20">	 </span></td>
					  <td width="86"><span class="Estilo5"><input name="Cat_parth" type="button" id="Cat_parth" title="Abrir Catalogo de Partidas" onClick="VentanaCentrada('../Cat_partidash.php?criterio=','SIA','','750','500','true')" value="...">	</span></td>
					</tr>
				  </table></td>
				</tr>
				<tr> <td colspan="2">&nbsp;</td> </tr>
				<tr>
				  <td colspan="2"><table width="785" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td width="170" align="left"><span class="Estilo5">TIPO DE REPORTE : </span></td>
					  <td width="259" align="left"><span class="Estilo5"><select name="txttipo_rep" size="1" id="txttipo_rep" onFocus="encender(this)" onBlur="apagar(this)">
						  <option value='HTML'>FORMATO HTML</option>  <option value='PDF'>FORMATO PDF</option> <option value='EXCEL'>FORMATO EXCEL</option> </select> </span></td>
					  <td width="170" align="left"><span class="Estilo5">INCLUIR BENEFICIARIO : </span></td>
					  <td width="186" align="left"><span class="Estilo5"><select name="txtinc_benef" size="1" id="txtinc_benef" onFocus="encender(this)" onBlur="apagar(this)">
						  <option value='NO'>NO</option> <option value='SI'>SI</option> </select></span></td>
					</tr>
				  </table></td>
				</tr>	
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.txttipo_rep.options[1].selected = true;}else{document.form1.txttipo_rep.options[0].selected = true;} </script>
				
				<tr> <td colspan="2">&nbsp;</td></tr>
				<tr> <td colspan="2">&nbsp;</td></tr>
				<tr>
				  <td colspan="2"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr align="center" valign="middle">
					  <td align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Mayor_Analitico_Presup('Rpt_Mayor_A_Presup.php');">	 </td>
					  <td align="center"> <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">	 </td></tr>
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
<? pg_close();?>
