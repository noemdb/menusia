<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="03-0000205"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
 $cod_presup_d="";  $cod_presup_h="zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz";  $cod_fuente_d="";  $cod_fuente_h="zz"; $des_fuente_d=""; $des_fuente_h="";
 $fecha_d=date("01/01/Y"); $fecha_h=date("31/12/Y"); $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte de Consolidado de Ejecucion de Credito Adicional)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;   mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){ mfec = mref.substring (0,6) + "20" + mref.charAt(6)+mref.charAt(7);     mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){ mfec = mref.substring (0,6) + "20" + mref.charAt(6)+mref.charAt(7);     mform.txtFechah.value=mfec;}
return true;}

function Llama_Rpt_consolidado_credito_adici(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Consolidado de Credito Adicional?");
  if (r==true){url=murl+"?ref_credito="+document.form1.txtref_imput_presu.value+"&cod_presupd="+document.form1.txtcod_presupd.value+"&cod_presuph="+document.form1.txtcod_presuph.value+"&fuente_d="+document.form1.txtcod_fuented.value+"&fuente_h="+document.form1.txtcod_fuenteh.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+"&tipo_rep="+document.form1.txttipo_rep.value;
  window.open(url,"Reporte Consolidado de Credito Adicional")}
}


function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

<?$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"];} $l=strlen($formato_presup);
$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001 where (length(Cod_Presup)=".$l.")"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_presup_d=$registro["min_cod_presup"];  $cod_presup_h=$registro["max_cod_presup"];}
//$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001"; $resultado=pg_query($sql);
//if ($registro=pg_fetch_array($resultado,0)){ $cod_presup_d=$registro["min_cod_presup"];  $cod_presup_h=$registro["max_cod_presup"];}
$sql="SELECT min(cod_fuente_financ) as min_fuente, max(cod_fuente_financ) as max_fuente  from pre095"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_fuente_d=$registro["min_fuente"];  $cod_fuente_h=$registro["max_fuente"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_d'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_d=$registro["des_fuente_financ"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_h'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_h=$registro["des_fuente_financ"];}
$sql="Select max(referencia_modif) As max_referencia_doc, min(referencia_modif) As min_referencia_doc from pre009"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $referencia_d=$registro["min_referencia_doc"];  $referencia_h=$registro["max_referencia_doc"];}
$cod_presup_d=str_replace("X","?",$formato_presup); $cod_presup_h=str_replace("X","?",$formato_presup);

?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">CONSOLIDADO DE EJECUCI&Oacute;N DE CR&Eacute;DITO ADICIONAL </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="450" border="1" id="tablacuerpo">
  <tr>
    <td width="992" height="446">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:952px; height:434px; z-index:1; top: 69px; left: 30px;">
        <form name="form1" method="get">
           <table width="950" height="439" border="0">
    <tr>
      <td width="958" height="365" align="center" valign="top"><table width="830" height="306" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="61" height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="277" height="26"> <div align="left"><span class="Estilo5">REFERENCIA CR&Eacute;DITO : </span></div></td>
              <td width="100"><span class="Estilo5"><input name="txtref_imput_presu" type="text" id="txtref_imput_presu" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $referencia_d?>" size="10" maxlength="8" class="Estilo10"> </span></td>
			  <td width="500"><span class="Estilo5"><input name="btref_cred" type="button" id="btref_cred" title="Abrir Catalogo Cr&eacute;ditos Adicional" onClick="VentanaCentrada('../Cat_cred_adic.php?criterio=','SIA','','750','500','true')" value="..."></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>

        <tr>
          <td height="19"><table width="827" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="277" height="26"><div align="right"> </div></td>
              <td width="600"><span class="Estilo15"><?echo $titulo?></span></td>
            </tr>
          </table></td>
        </tr>        
        <tr>
          <td height="30"><table width="827" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="277" height="26"><div align="left"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DESDE : </span></div></td>
              <td width="230"><span class="Estilo5"><input name="txtcod_presupd" type="text" id="txtcod_presupd" size="40" maxlength="35" onFocus="encender(this); " onBlur="apagar(this);" value="<?echo $cod_presup_d?>" class="Estilo10">  </span></td>
              <td width="370"><span class="Estilo5"> <input name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presupd.php?criterio=','SIA','','750','500','true')" value="...">  </span></td>
            </tr>
          </table></td>
        </tr>
       
        <tr>
          <td height="30"><table width="827" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="277"> <div align="left"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO HASTA :</span></div></td>
              <td width="230"><span class="Estilo5"> <input name="txtcod_presuph" type="text" id="txtcod_presuph" size="40" maxlength="35" onFocus="encender(this); " onBlur="apagar(this);" value="<?echo $cod_presup_h?>" class="Estilo10">  </span></td>
              <td width="370"><span class="Estilo5"><input name="btCodPre2" type="button" id="btCodPre2" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presuph.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
            </tr>
          </table></td>
        </tr>
		 <tr>
          <td height="19">&nbsp;</td>
        </tr>
		<tr>
          <td height="19"><table width="827" border="0">
            <tr>
              <td width="277" align="left"><span class="Estilo5">FUENTE DE FINANCIAMIENTO DESDE : </span></td>
              <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuented" type="text" id="txtcod_fuented" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="2" value="<?echo $cod_fuente_d?>" onkeypress="return stabular(event,this)">
              <td width="60"><span class="Estilo5"><input class="Estilo10" name="catalogo3" type="button" id="catalogo3" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesd.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></span></td>
              <td width="470"><span class="Estilo5"> <input class="Estilo10" name="txtdes_fuented" type="text" id="txtdes_fuented" size="60" maxlength="60"  value="<?echo $des_fuente_d?>"  readonly onkeypress="return stabular(event,this)"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="200" height="26"></td>
              <td width="77" align="left"><span class="Estilo5">HASTA : </span></td>
              <td width="70"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="2" value="<?echo $cod_fuente_h?>" onkeypress="return stabular(event,this)"></span></td>
              <td width="60"><span class="Estilo5"><input class="Estilo10" name="catalogo4" type="button" id="catalogo4" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesh.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></span></td>
              <td width="470"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuenteh" type="text" id="txtdes_fuenteh" size="60" maxlength="60"  value="<?echo $des_fuente_h?>"  readonly onkeypress="return stabular(event,this)"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="18"><table width="827" border="0.5" cellspacing="1" cellpadding="1">
            <tr>
              <td width="272" height="26"><div align="left"><span class="Estilo5">FECHA DE PROCESO  : </span></div></td>
              <td width="5"><input name="txtFechad" type="hidden" id="txtFechad" value="<?echo $fecha_d?>" ></td>
			  <td width="600"><span class="Estilo5"> <input name="txtFechah" type="text" id="txtFechah" size="12" maxlength="10" onFocus="encender(this); " onBlur="apagar(this);"  value="<?echo $fecha_h?>" onchange="checkrefecha(this.form)" class="Estilo10">
                                <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha" onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
		<tr>
           <td height="19" colspan="3"><table width="827" border="0.5" cellspacing="1" cellpadding="1">
			<tr>
			 <td width="277" class="Estilo5"> TIPO DE REPORTE :</td>
			 <td width="600"><span class="Estilo5"> <select name="txttipo_rep" id="txttipo_rep"><option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select>	</span></td>
			</tr>
           </table></td>
        </tr>        
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.txttipo_rep.options[1].selected = true;}else{document.form1.txttipo_rep.options[0].selected = true;} </script>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="48"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td> <div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_consolidado_credito_adici('Rpt_consolidado_credito_adici.php');">
                      </div></td>
              <td> <div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        <tr>
          <td height="18">&nbsp;</td>
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
