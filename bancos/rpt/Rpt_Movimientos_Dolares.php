<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="02"; $opcion="03-0000015"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
$cod_banco_d="";$cod_banco_h="";$tipo_mov_d="";$tipo_mov_h="";$referencia_d="";$referencia_h="zzzzzzzz";$periodod='01';$periodoh='01';$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);$fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);$subtotales="S";$ordenarcheque="S";$imprimirbene="N";$imprimircuen="N";$imprimirorden="N";$imprimirsolo="N";$vurl;
$des_tipo_d="";$des_tipo_h=""; $nombre_banco_d="";  $nombre_banco_h=""; $cedula_d="";$cedula_h="zzzzzzzzzzzz";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL BANCARIO (Reporte Movimientos en Dolares)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;   mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);mform.txtFechah.value=mfec;}
return true;}
function apaga_referenciad(mthis){var mref;
   apagar(mthis); mref=document.form1.txtreferencia_d.value;  mref=Rellenarizq(mref,"0",8);  document.form1.txtreferencia_d.value=mref;
return true;}
function apaga_referenciah(mthis){var mref;
   apagar(mthis); mref=document.form1.txtreferencia_h.value;  mref=Rellenarizq(mref,"0",8);  document.form1.txtreferencia_h.value=mref;
return true;}
function apaga_periodo_d(mthis){
var mmes;  var mano; var mdesde; var mhasta; var mdia;
   apagar(mthis); mmes=document.form1.selectperiodo_d.value; mmes=Rellenarizq(mmes,"0",2); 
   mdesde=document.form1.txtFechad.value; mano=mdesde.charAt(6)+mdesde.charAt(7)+mdesde.charAt(8)+mdesde.charAt(9);
   mdesde="01/"+mmes+"/"+mano; document.form1.txtFechad.value=mdesde; 
true;}
function apaga_periodo_h(mthis){
var mmes;  var mano; var mdesde; var mhasta; var mdia;
   apagar(mthis); mmes=document.form1.selectperiodo_h.value; mmes=Rellenarizq(mmes,"0",2); 
   mhasta=document.form1.txtFechad.value; mano=mhasta.charAt(6)+mhasta.charAt(7)+mhasta.charAt(8)+mhasta.charAt(9);
   mdia="31"; if(mmes=="02"){mdia="28";} if((mmes=="04")||(mmes=="06")||(mmes=="09")||(mmes=="11")){mdia="30";}
   mhasta=mdia+"/"+mmes+"/"+mano; document.form1.txtFechah.value=mhasta;
true;}
function Llama_Rpt_Movimientos_Dol(murl){var url;var r; var mbenef="N"; var mimpsinmov="N"; var mimpnroorden="N";
  if(document.form1.impbenef[0].checked==true){mbenef="S";}
  if(document.form1.impbenef[1].checked==true){mbenef="N";}
  if(document.form1.impbenef[2].checked==true){mbenef="B";}  
  if(document.form1.impsinmov[0].checked==true){mimpsinmov="S";}
  if(document.form1.impsinmov[1].checked==true){mimpsinmov="N";}
  r=confirm("Desea Generar el Reporte Movimientos en Dolares?");
  if (r==true){url=murl+"?cod_banco_d="+document.form1.txtcod_banco_d.value+"&cod_banco_h="+document.form1.txtcod_banco_h.value+"&tipo_mov_d="+document.form1.txttipo_mov_d.value+"&tipo_mov_h="+document.form1.txttipo_mov_h.value+"&referencia_d="+document.form1.txtreferencia_d.value+"&referencia_h="+document.form1.txtreferencia_h.value+"&periodod="+document.form1.selectperiodo_d.value+"&periodoh="+document.form1.selectperiodo_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+
     "&cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&imp_benef="+mbenef+ "&imp_sinmov="+mimpsinmov+"&tipo_rep="+document.form1.tipo_rep.value;
    window.open(url,"Reporte Movimientos en Dolares")}}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head>
<?
$sql="SELECT MAX(cod_banco) As Max_cod_banco, MIN(cod_banco) As Min_cod_banco FROM BAN042";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cod_banco_d=$registro["min_cod_banco"];$cod_banco_h=$registro["max_cod_banco"];}
$sql="SELECT MAX(ced_rif) As Max_Ced_Rif, MIN(ced_rif) As Min_Ced_Rif FROM PRE099";$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_ced_rif"];$cedula_h=$registro["max_ced_rif"];}
$sql="SELECT MAX(tipo_movimiento) As Max_Tipo_Movimiento, MIN(tipo_movimiento) As Min_Tipo_Movimiento FROM BAN003"; $res=pg_query($sql);if($registro=pg_fetch_array($res,0)){$tipo_mov_d=$registro["min_tipo_movimiento"];$tipo_mov_h=$registro["max_tipo_movimiento"];}
$sql="Select nombre_banco from BAN042 where cod_banco='$cod_banco_d'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_banco_d=$registro["nombre_banco"];}
$sql="Select nombre_banco from BAN042 where cod_banco='$cod_banco_h'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_banco_h=$registro["nombre_banco"];}
$cedula_d="";$nombre_d="";$nombre_h="";
$sql="Select nombre from pre099 where ced_rif='$cedula_d'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_d=$registro["nombre"];}
$sql="Select nombre from pre099 where ced_rif='$cedula_h'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$nombre_h=$registro["nombre"];}
$sql="Select descrip_tipo_mov from ban003 where tipo_movimiento='$tipo_mov_d'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$des_tipo_d=$registro["descrip_tipo_mov"];}
$sql="Select descrip_tipo_mov from ban003 where tipo_movimiento='$tipo_mov_h'"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$des_tipo_h=$registro["descrip_tipo_mov"];}
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE MOVIMIENTOS EN DOLARES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="615" border="1" id="tablacuerpo">
  <tr>
    <td width="870" height="612">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:506px; z-index:1; top: 63px; left: 19px;">
        <form name="form1" method="get"><table width="950" height="512" border="0">
    <tr>
      <td width="958" height="610" align="center" valign="top"><table width="783" height="605" border="0" cellpadding="0" cellspacing="0">
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
        <tr>
          <td height="30"><table width="776" border="0">
            <tr>
              <td width="244" height="26"><div align="left"><span class="Estilo5">CODIGO DE BANCO DESDE : </span></div></td>
              <td width="52"><span class="Estilo5"> <input name="txtcod_banco_d" type="text" id="txtcod_banco_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_d?>" size="5" maxlength="4">  </span></td>
              <td width="35"><span class="Estilo5"><input name="Cat_codd" type="button" id="Cat_codd" title="Abrir Catalogo de Bancos" onClick="VentanaCentrada('../Cat_Bancosd.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
              <td width="427"><span class="Estilo5"><input name="txtdesc_banco_d" type="text" id="txtdesc_banco_d" size="60" maxlength="150" value="<?echo $nombre_banco_d?>" readonly>  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="245" height="26"> <div align="left"><span class="Estilo5">CODIGO DE BANCO HASTA : </span></div></td>
              <td width="51"><span class="Estilo5"><input name="txtcod_banco_h" type="text" id="txtcod_banco_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_banco_h?>" size="5" maxlength="4">  </span></td>
              <td width="34"><span class="Estilo5"><input name="Cat_codh" type="button" id="Cat_codh" title="Abrir Catalogo de Bancos" onClick="VentanaCentrada('../Cat_Bancosh.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
              <td width="428"><span class="Estilo5"> <input name="txtdesc_banco_h" type="text" id="txtdesc_banco_h" size="60" maxlength="150" value="<?echo $nombre_banco_h?>" readonly>  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="247" height="26"><div align="left"><span class="Estilo5">TIPO DE MOVIMIENTO DESDE : </span></div></td>
              <td width="49"><span class="Estilo5"><input name="txttipo_mov_d" type="text" id="txttipo_mov_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_mov_d?>" size="5" maxlength="3">     </span></td>
              <td width="38"><span class="Estilo5"><input name="Cat_tipod" type="button" id="Cat_tipod" title="Abrir Catalogo de Tipo Movimiento" onClick="VentanaCentrada('../Cat_Tipo_Movd.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
              <td width="424"><span class="Estilo5"><input name="txtdesc_tipo_Mov_d" type="text" id="txtdesc_tipo_Mov_d" size="60" maxlength="150" value="<?echo $des_tipo_d?>"  readonly>  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="248" height="26"><div align="left"><span class="Estilo5">TIPO DE MOVIMIENTO HASTA : </span></div></td>
              <td width="50"><span class="Estilo5"><input name="txttipo_mov_h" type="text" id="txttipo_mov_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $tipo_mov_h?>" size="5" maxlength="3">   </span></td>
              <td width="35"><span class="Estilo5"><input name="Cat_tipoh" type="button" id="Cat_tipoh" title="Abrir Catalogo de Tipo Movimiento" onClick="VentanaCentrada('../Cat_Tipo_Movh.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
              <td width="425"><span class="Estilo5"><input name="txtdesc_tipo_mov_h" type="text" id="txtDesc_Tipo_Mov_D" size="60" maxlength="150" value="<?echo $des_tipo_h?>"  readonly>    </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
        <tr>
          <td height="19" colspan="2"><table width="833" border="0">
            <tr>
              <td width="208" align="left" ><span class="Estilo5">CEDULA/RIF BENEFICIARIO DESDE: </span> </td>
              <td width="109"><span class="Estilo5"> <input name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedula_d?>" size="15" maxlength="12">   </span></td>
              <td width="54"><span class="Estilo5"><input name="cat_benefd" type="button" id="cat_benefd" title="Abrir Catalogo de Beneficiario" onClick="VentanaCentrada('../Cat_Beneficiariosd.php?criterio=','SIA','','750','500','true')" value="...">   </span></td>
              <td width="444"><span class="Estilo5"><input name="txtdesccedrifbenefd" type="text" id="txtdesccedrifbenefd" size="60" maxlength="60"  value="<?echo $nombre_d?>" readonly>   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
        <tr>
          <td height="19" colspan="2"><table width="834" border="0">
            <tr>
              <td width="211" align="left" ><span class="Estilo5">CEDULA/RIF BENEFICIARIO HASTA:</span> </td>
              <td width="109"><span class="Estilo5"> <input name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cedula_h?>" size="15" maxlength="12">   </span></td>
              <td width="54"><span class="Estilo5"> <input name="cat_benefh" type="button" id="cat_benefh" title="Abrir Catalogo de Beneficiario" onClick="VentanaCentrada('../Cat_Beneficiariosh.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
              <td width="442"><span class="Estilo5"><input name="txtdesccedrifbenefh" type="text" id="txtdesccedrifbenefh" size="60" maxlength="60" value="<?echo $nombre_h?>"  readonly>   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td>        </tr>	
        <tr>
          <td height="19"><table width="783" border="0">
            <tr>
              <td width="247" height="26"><p align="left"><span class="Estilo5">REFERENCIA DESDE :</span></p></td>
              <td width="167"><span class="Estilo5"> <input name="txtreferencia_d" type="text" id="txtreferencia_d" onFocus="encender(this)" onBlur="apaga_referenciad(this)" value="<?echo $referencia_d?>" size="8" maxlength="8">  </span></td>
              <td width="108"><span class="Estilo5">HASTA :</span></td>
              <td width="243"><span class="Estilo5"><input name="txtreferencia_h" type="text" id="txtreferencia_h" onFocus="encender(this)" onBlur="apaga_referenciah(this)" value="<?echo $referencia_h?>" size="8" maxlength="8">  </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
        <tr>
          <td height="19"><table width="783" border="0">
            <tr>
              <td width="247" align="left"><span class="Estilo5">PERIODO DESDE :</span></td>
              <td width="170"><select name="selectperiodo_d" size="1" id="selectperiodo_d" onFocus="encender(this)" onBlur="apaga_periodo_d(this)">
                  <option selected>01</option> <option>02</option> <option>03</option>
                  <option>04</option> <option>05</option> <option>06</option>
                  <option>07</option> <option>08</option> <option>09</option>
                  <option>10</option> <option>11</option> <option>12</option>
              </select></td>
              <td width="107"><span class="Estilo5">HASTA :</span></td>
              <td width="241"><select name="selectperiodo_h" size="1" id="selectperiodo_h" onFocus="encender(this)" onBlur="apaga_periodo_h(this)">
                <option>01</option> <option>02</option> <option>03</option>
                <option>04</option> <option>05</option> <option>06</option>
                <option>07</option> <option>08</option> <option>09</option>
                <option>10</option> <option>11</option> <option selected>12</option>
              </select></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
        <tr>
          <td height="19"><table width="776" border="0">
            <tr>
              <td width="247" align="left"><span class="Estilo5">FECHA MOVIMIENTO DESDE : </span></td>
              <td width="174" align="left"><span class="Estilo5"><input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></td>
              <td width="111" align="left"><span class="Estilo5">HASTA :</span></td>
              <td width="244" align="left"><span class="Estilo5"><input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="19">&nbsp;</td> </tr>
		<tr>
		  <td height="19"><table width="775" border="0">
			  <tr>
				<td width="245" class="Estilo5"> TIPO DE REPORTE :</td>
				<td width="175"><span class="Estilo5"> <select name="tipo_rep" id="tipo_rep">
				  <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select>
				</span></td>
				<td width="150" align="left"><span class="Estilo5">IMPRIMIR BENEFICIARIO : </span></td>
                <td width="195"><table width="195" height="20" border="1">
                  <tr>
                    <td width="195" valign="top" class="Estilo5"><label><input name="impbenef" type="radio" value="S" >SI </label><label><input name="impbenef" type="radio" value="N" checked>NO </label> <label><input name="impbenef" type="radio" value="B" >SOLO BENEF.</label></td>
                  </tr>
                </table></td>
			  </tr>
		  </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rep.options[1].selected = true;}else{document.form1.tipo_rep.options[0].selected = true;} </script>
        <tr><td height="19">&nbsp;</td> </tr>
		<tr>
		  <td height="19"><table width="775" border="0">
			  <tr>
				<td width="245" class="Estilo5"> CUENTAS SIN MOVIMIENTO:</td>
				<td width="175"><table width="115" height="20" border="1">
                  <tr>
                    <td width="105" valign="top" class="Estilo5"><label><input name="impsinmov" type="radio" value="S" >SI </label><label><input name="impsinmov" type="radio" value="N" checked>NO </label></td>
                  </tr>
                </table></td>
				<td width="345" align="left"><span class="Estilo5"> </span></td>                
			  </tr>
		  </table></td>
        </tr>
		<tr><td height="19">&nbsp;</td> </tr>
        <tr>
          <td height="54"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Movimientos_Dol('Rpt_Movimientos_Dol.php');"> </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"> </div></td>
			</tr>
          </table></td>
        </tr>
        <tr><td height="10" colspan="2">&nbsp;</td></tr>
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
