<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="Javascript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="03-0000005"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
$cod_presup_d="";  $cod_presup_h="zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz"; $formato_presup=""; $titulo=""; $cod_fuente_d="";  $cod_fuente_h="zz"; $des_fuente_d=""; $des_fuente_h="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTABILIDAD PRESUPUESTARIA (Reporte Catalogos de Codigos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="Javascript" src="../../class/sia.js" type="text/javascript"></script>
<script language="Javascript" type="text/Javascript">
function Llama_Rpt_Cat_Codigos(murl){var url; var r; var tipo; 
  if(document.form1.txtTipo_reporte.value=="SOLO CATEGORIAS"){tipo="C";}
   else{ if(document.form1.txtTipo_reporte.value=="CODIGOS ULTIMO NIVEL"){tipo="U";} else{tipo="T";} }  
  r=confirm("Desea Generar el Reporte  ?");
  if (r==true) {url=murl+"?cod_presupd="+document.form1.txtcod_presupd.value+"&cod_presuph="+document.form1.txtcod_presuph.value+"&cod_fuented="+document.form1.txtcod_fuented.value+"&cod_fuenteh="+document.form1.txtcod_fuenteh.value+"&tipo="+tipo+"&tipo_rep="+document.form1.txttipo_rep.value;
    window.open(url);}
}
function Llama_Menu_Rpt(murl){var url;  url="../"+murl; LlamarURL(url);}
function stabular(e,obj) {tecla=(document.all) ? e.keyCode : e.which;   if(tecla!=13) return;  frm=obj.form;  for(i=0;i<frm.elements.length;i++)  if(frm.elements[i]==obj) {if (i==frm.elements.length-1) i=-1; break } frm.elements[i+1].focus(); return false;} 
</script>
</head>
<?$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"];} 
$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_presup_d=$registro["min_cod_presup"];  $cod_presup_h=$registro["max_cod_presup"];}
$sql="SELECT min(cod_fuente_financ) as min_fuente, max(cod_fuente_financ) as max_fuente  from pre095"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_fuente_d=$registro["min_fuente"];  $cod_fuente_h=$registro["max_fuente"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_d'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_d=$registro["des_fuente_financ"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_h'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_h=$registro["des_fuente_financ"];}
$cod_presup_d=str_replace("X","?",$formato_presup); $cod_presup_h=str_replace("X","?",$formato_presup);
$mpatron="Array(2,2,2,2,2,3,2,2,2,2)";  $mpatron=arma_patron($formato_presup);
?>
<script language="Javascript" type="text/Javascript">var patroncodigo = new <?php echo $mpatron ?>;</script>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE CATALOGOS DE CODIGOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="465" border="1" id="tablacuerpo">
  <tr>
    <td width="965" height="460">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:956px; height:511px; z-index:1; top: 71px; left: 16px;">
        <form name="form1" method="get">
           <table width="950" height="499" border="0">
    <tr>
      <td width="958" height="450" align="center" valign="top"><table width="830" height="434" border="0" cellpadding="0" cellspacing="0">
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td height="19"><table width="766" border="0">
            <tr>
              <td width="331" height="26"></td>
              <td width="235"><span class="Estilo15"><? echo $titulo; ?></span></td>
              <td width="200">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30"><table width="813" border="0">
            <tr>
              <td width="326" align="right" ><span class="Estilo5">C&Oacute;DIGO PRESUPUESTARIO DESDE : </td></span>
              <td width="221"><span class="Estilo5"><input class="Estilo10" name="txtcod_presupd" type="text" id="txtcod_presupd" size="32" maxlength="32" value="<?echo $cod_presup_d?>" onFocus="encender(this); " onBlur="apagar(this);" onkeyup="mascara(this,'-',patroncodigo,true)" onkeypress="return stabular(event,this)" > </span></td>
              <td width="252"><span class="Estilo5"><input class="Estilo10" name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo Codigos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presupd.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td height="30"><table width="827" border="0">
            <tr>
              <td width="223" height="26"> </td>
              <td width="98"  align="right"><span class="Estilo5">HASTA : </span></td>
              <td width="222"><span class="Estilo5"><input class="Estilo10" name="txtcod_presuph" type="text" id="txtcod_presuph" size="32" maxlength="32" value="<?echo $cod_presup_h?>" onFocus="encender(this); " onBlur="apagar(this);" onkeyup="mascara(this,'-',patroncodigo,true)" onkeypress="return stabular(event,this)"></span></td>
              <td width="266"><span class="Estilo5"><input class="Estilo10" name="btCodPre2" type="button" id="btCodPre2" title="Abrir Catalogo Codigos Presupuestarios"  onClick="VentanaCentrada('Cat_codigos_presuph.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
              <td width="321" align="right"><span class="Estilo5">FUENTE DE FINANCIAMIENTO DESDE : </span></td>
              <td width="62"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuented" type="text" id="txtcod_fuented" value="<?echo $cod_fuente_d?>" onFocus="encender(this)" onBlur="apagar(this)" maxlength="2" size="5" maxlength="5" onkeypress="return stabular(event,this)"> </span></td>
              <td width="45"><span class="Estilo5"><input class="Estilo10" name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesd.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"> </span></td>
              <td width="381"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuented" type="text" id="txtdes_fuented" size="50" maxlength="50" value="<?echo $des_fuente_d?>" readonly onkeypress="return stabular(event,this)"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="243" height="26"></td>
              <td width="75" align="right"><span class="Estilo5">HASTA : </span></td>
              <td width="61"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" value="<?echo $cod_fuente_h?>" onFocus="encender(this)" onBlur="apagar(this)" maxlength="2"  size="5" maxlength="5" onkeypress="return stabular(event,this)"> </span></td>
              <td width="46"><span class="Estilo5"><input class="Estilo10" name="btfuente2" type="button" id="btfuente2" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_fuentesh.php?criterio=','SIA','','750','500','true')" value="..." onkeypress="return stabular(event,this)"></span></td>
              <td width="381"><span class="Estilo5"><input class="Estilo10" name="txtdes_fuenteh" type="text" id="txtdes_fuenteh" size="50" maxlength="50" value="<?echo $des_fuente_h?>" readonly onkeypress="return stabular(event,this)"></span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
		<tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="318" align="right"><span class="Estilo5">TIPO DE REPORTES: </span></td>
              <td width="488"><span class="Estilo5"> <select class="Estilo10" name="txtTipo_reporte" size="1" id="select" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)">
                      <option selected>TODOS LOS CODIGOS</option>  <option>SOLO CATEGORIAS</option> <option>CODIGOS ULTIMO NIVEL</option>  </select></span></td>
            </tr>
          </table></td>
        </tr>
        <tr> <td>&nbsp;</td></tr>
		<tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="318" align="right"><span class="Estilo5">TIPO DE REPORTE : </span></td>
              <td width="488"><span class="Estilo5"><select class="Estilo10" name="txttipo_rep" size="1" id="txttipo_rep" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return stabular(event,this)">
			<option value='HTML'>FORMATO HTML</option>  <option value='PDF'>FORMATO PDF</option> <option value='EXCEL'>FORMATO EXCEL</option> </select></td>
            </tr>
          </table></td>
        </tr>
<script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.txttipo_rep.options[1].selected = true;}else{document.form1.txttipo_rep.options[0].selected = true;} </script>

        <tr> <td>&nbsp;</td></tr>
        <tr>
          <td height="91"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_Cat_Codigos('Rpt_partidas_presup.php');"> </div></td>
              <td><div align="center"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></div></td></tr>
          </table></td>
        </tr>
        <tr><td height="18">&nbsp;</td>
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