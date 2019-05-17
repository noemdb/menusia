<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="03-0000080"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
 $cod_presup_d="";  $cod_presup_h="zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz"; $categoria_d=""; $categoria_h="zzzzzzzzzzzz"; $cod_fuente_d="";  $cod_fuente_h="zz"; $des_fuente_d=""; $des_fuente_h=""; $fecha_hoy=asigna_fecha_hoy();
$fecha_a=formato_aaaammdd($fecha_hoy); $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer); if($fecha_a>$Fec_Fin_Ejer){$fecha_hoy=$fecha_h;}
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte Disponibilidad Diaria)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);     mform.txtFechad.value=mfec;}
return true;}
function Llama_Rpt_Disp_Diaria(murl){var url;  
  r=confirm("Desea Generar el Reporte Disponibilidad Diaria ?");
  if (r==true) {url=murl+"?cod_presupd="+document.form1.txtcod_presupd.value+"&cod_presuph="+document.form1.txtcod_presuph.value+"&categoria_d="+document.form1.txtcategoria_d.value+"&categoria_h="+document.form1.txtcategoria_h.value+"&cod_fuented="+document.form1.txtcod_fuented.value+"&cod_fuenteh="+document.form1.txtcod_fuenteh.value+"&fecha="+document.form1.txtFechad.value+"&det_modif="+document.form1.txtdet_modif.value+"&disp_dif="+document.form1.txtdisp_dif.value+"&total_part="+document.form1.txttotal_part.value+"&tipo_rep="+document.form1.txttipo_rep.value;
    window.open(url);  }
}
function Llama_Menu_Rpt(murl){var url;   url="../"+murl;   LlamarURL(url);}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
</script>
</head>
<?
$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$titulo=$registro["campo525"];$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$formato_par=$registro["campo527"];}else{$formato_presup="XX-XX-XX-XXX-XX-XX-XX";$formato_cat="XX-XX-XX";$formato_par="XXX-XX-XX-XX";}
$mpatron="Array(2,2,2,2,2,3,2,2,2,2)";  $mpatron=arma_patron($formato_presup);$mpatronp="Array(3,2,2,2,2,2,0,0,0,0)";  $mpatronp=arma_patron($formato_par); $mpatronc="Array(2,2,2,2,2,0,0,0,0,0)";  $mpatronc=arma_patron($formato_cat); $l=strlen($formato_presup);
$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001 where (length(Cod_Presup)=".$l.")"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_presup_d=$registro["min_cod_presup"];  $cod_presup_h=$registro["max_cod_presup"];}
$sql="SELECT min(cod_fuente_financ) as min_fuente, max(cod_fuente_financ) as max_fuente  from pre095"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_fuente_d=$registro["min_fuente"];  $cod_fuente_h=$registro["max_fuente"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_d'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_d=$registro["des_fuente_financ"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_h'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_h=$registro["des_fuente_financ"];}
$sql="SELECT MAX(Cod_Presup_Cat) As Max_Cod_Presup_Cat, MIN(Cod_Presup_Cat) As Min_Cod_Presup_Cat FROM PRE019";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $categoria_d=$registro["min_cod_presup_cat"];  $categoria_h=$registro["max_cod_presup_cat"];}
?>
<script language="JavaScript" type="text/JavaScript">
var patroncodigo = new <?php echo $mpatron ?>;
var patroncodigop = new <?php echo $mpatronp ?>;
var patroncodigoc = new <?php echo $mpatronc ?>;
</script>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE DISPONIBILIDAD DIARIA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="502" border="1" id="tablacuerpo">
  <tr>
    <td width="965" height="506">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:414px; z-index:1; top: 71px; left: 16px;">
        <form name="form1" method="get">
           <table width="950" height="500" border="0">
    <tr>
      <td width="958" height="500" align="center" valign="top"><table width="916" height="500" border="0" cellpadding="0" cellspacing="0">
        <tr> <td width="830" height="18">&nbsp;</td> </tr>
		<tr>
          <td height="30"><table width="915" border="0">
            <tr>
              <td width="245" height="26"><span class="Estilo5">C&Oacute;DIGO CATEGORIA DESDE : </span></td>
			  <td width="200"><span class="Estilo5"><input class="Estilo10" name="txtcategoria_d" type="text" id="txtcategoria_d" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $categoria_d?>" size="20" maxlength="20" class="Estilo5" onkeyup="mascara(this,'-',patroncodigoc,true)" onkeypress="return stabular(event,this)">  </span></td>
              <td width="91"><span class="Estilo5"><input class="Estilo10" name="cat_catd" type="button" id="cat_catd" title="Abrir Catalogo de Categoria" onClick="VentanaCentrada('Cat_Categoriad.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span> </td>
			  
              <td width="55"><span class="Estilo5">HASTA : </span></td>
			  
			  <td width="200"><span class="Estilo5"> <input class="Estilo10" name="txtcategoria_h" type="text" id="" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $categoria_h?>" size="20" maxlength="20" class="Estilo5" onkeyup="mascara(this,'-',patroncodigoc,true)" onkeypress="return stabular(event,this)">   </span></td>
              <td width="98"><span class="Estilo5"><input class="Estilo10" name="cat_cath" type="button" id="cat_cath" title="Abrir Catalogo de Categoria" onClick="VentanaCentrada('Cat_Categoriah.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">      </span></td>
			</tr>
          </table></td>
        </tr>
        <tr><td height="19">&nbsp;</td> </tr>
        <tr>
          <td height="19"><table width="884" border="0">
            <tr>
              <td width="244" height="26"><div align="right"> </div></td>
              <td width="358"><span class="Estilo15"><? echo $titulo; ?></span></td>
              <td width="268"><span class="Estilo15"><? echo $titulo; ?></span></td>
            </tr>
          </table></td>
        </tr>        
        <tr>
          <td height="30"><table width="915" border="0">
            <tr>
              <td width="245" height="26"><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DESDE : </span></td>
              <td width="201"><span class="Estilo5"><input class="Estilo10" name="txtcod_presupd" type="text" id="txtcod_presupd" size="35" maxlength="35" onFocus="encender(this); " onBlur="apagar(this);" value="<?echo $cod_presup_d?>" onkeyup="mascara(this,'-',patroncodigo,true)" onkeypress="return stabular(event,this)">   </span></td>
              <td width="90"><span class="Estilo5"> <input class="Estilo10" name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presupd.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
              <td width="55"><span class="Estilo5">HASTA : </span></td>
              <td width="206"><span class="Estilo5"><input class="Estilo10" name="txtcod_presuph" type="text" id="txtcod_presuph" size="35" maxlength="35" onFocus="encender(this); " onBlur="apagar(this);" value="<?echo $cod_presup_h?>" onkeyup="mascara(this,'-',patroncodigo,true)" onkeypress="return stabular(event,this)">   </span></td>
              <td width="92"><span class="Estilo5"><input class="Estilo10" name="btCodPre2" type="button" id="btCodPre2" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presuph.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="19">&nbsp;</td> </tr>
        <tr>
          <td height="19"><table width="890" border="0">
            <tr>
              <td width="238" height="26"><span class="Estilo5">FUENTE DE FINANCIAMIENTO DESDE : </span></td>
              <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuented" type="text" id="txtcod_fuented" value="<?echo $cod_fuente_d?>" onFocus="encender(this)" onBlur="apagar(this)" maxlength="2" size="5"  onkeypress="return stabular(event,this)">   </span></td>
              <td width="47"><span class="Estilo5"><input class="Estilo10" name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesd.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
              <td width="530"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuented" type="text" id="txtdes_fuented" size="80" maxlength="80" value="<?echo $des_fuente_d?>" readonly onkeypress="return stabular(event,this)">   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="19">&nbsp;</td></tr>
        <tr>
          <td height="19"><table width="890" border="0">
            <tr>
              <td width="152" height="26"></td>
              <td width="86"><span class="Estilo5">HASTA : </span></td>
              <td width="50"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" value="<?echo $cod_fuente_h?>" onFocus="encender(this)" onBlur="apagar(this)" maxlength="2"  size="5"  onkeypress="return stabular(event,this)">   </span></td>
              <td width="47"><span class="Estilo5"><input class="Estilo10" name="btfuente2" type="button" id="btfuente2" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesh.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">   </span></td>
              <td width="530"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuenteh" type="text" id="txtdes_fuenteh" size="80" maxlength="80" value="<?echo $des_fuente_h?>" readonly onkeypress="return stabular(event,this)">   </span></td>
            </tr>
          </table></td>
        </tr>
        <tr><td height="19">&nbsp;</td></tr>
        <tr>
          <td height="19"><table width="890" border="0">
            <tr>
              <td width="100" height="26"></td>
              <td width="150"><span class="Estilo5">FECHA PROCESO : </span> </td>
              <td width="240"><span class="Estilo5"><input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hoy?>" size="12" maxlength="12" onChange="checkrefechad(this.form)" onkeypress="return stabular(event,this)">
                <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha" onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  onkeypress="return stabular(event,this)">   </span></td>
              <td width="185"><div align="left"><span class="Estilo5">TOTAL POR PARTIDAS :  </span></div></td>
              <td width="215"><span class="Estilo5"><select class="Estilo10" name="txttotal_part"  id="txttotal_part" onFocus="encender(this)" onBlur="apagar(this);" onkeypress="return stabular(event,this)"> <option value="N">NO</option><option value="S">SI</option>  </select>    </span></td> 			  
            
			
			</tr>
          </table></td>
        </tr>
		<tr><td height="19">&nbsp;</td></tr>
        <tr>
          <td height="19"><table width="890" border="0">
            <tr>
              <td width="250"><span class="Estilo5">MOSTRAR DISPONIBILIDAD DIFERIDA : </span></td>
              <td width="240"><span class="Estilo5"><select class="Estilo10" name="txtdisp_dif" size="1" id="txtdisp_dif" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)">  <option value='NO'>NO</option>  <option value='SI'>SI</option>  </select></td>
              <td width="185"><div align="left"><span class="Estilo5">DETALLE DE MODIFICACIONES :  </span></div></td>
              <td width="215"><span class="Estilo5"><select class="Estilo10" name="txtdet_modif"  id="txtdet_modif" onFocus="encender(this)" onBlur="apagar(this);" onkeypress="return stabular(event,this)"> <option value="NO">NO</option><option value="SI">SI</option>  </select>    </span></td> 			  
            
            </tr>
          </table></td>
        </tr>
		
		<tr><td height="19">&nbsp;</td></tr>
		<tr>
          <td height="19"><table width="890" border="0">
            <tr>
			  <td width="100" height="26"></td>
              <td width="150"><span class="Estilo5">TIPO DE REPORTE : </span></td>
              <td width="240"><span class="Estilo5"><select class="Estilo10" name="txttipo_rep" size="1" id="txttipo_rep" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)">
			    <option value='HTML'>FORMATO HTML</option>  <option value='PDF'>FORMATO PDF</option> <option value='EXCEL'>FORMATO EXCEL</option> </select></td>
              <td width="400"><div align="left"><span class="Estilo5">  </span></div></td>
            </tr>
          </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.txttipo_rep.options[1].selected = true;}else{document.form1.txttipo_rep.options[0].selected = true;} </script>
        <tr><td height="19">&nbsp;</td></tr>
        <tr>
          <td height="59"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Disp_Diaria('Rpt_Disponibilidad_Diari.php');"> </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">   </div></td></tr>
          </table></td>
        </tr>
        <tr><td height="18">&nbsp;</td></tr>
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