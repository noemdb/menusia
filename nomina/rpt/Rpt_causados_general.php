<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 $cod_presup_d="";  $cod_presup_h="zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz"; $referencia_d=""; $referencia_h="";$doc_causa_d=""; $doc_causa_h="";
 $cod_fuente_d="";  $cod_fuente_h="zz"; $des_fuente_d=""; $des_fuente_h=""; $cedula_d=""; $cedula_h=""; $tipo_regis="";
 $doc_comp_d=""; $doc_comp_h=""; $tipo_comp_d=""; $tipo_comp_h=""; $referenciacomp_d=""; $referenciacomp_h=""; $ref_credd="00000000"; $ref_credh="99999999";
 $fecha_d=date("01/01/Y"); $fecha_h=date("31/12/Y"); $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Reporte de Causados)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">

function Llama_Rpt_causados_gene(murl){var url;var r;var tipo="TO";
   r=confirm("Desea Generar el Reporte de Causados?");
  if (r==true) {url=murl+"?doc_causa_d="+document.form1.txttipo_causado_d.value+"&doc_causa_h="+document.form1.txttipo_causado_h.value+
"&referencia_d="+document.form1.txtreferencia_d.value+"&referencia_h="+document.form1.txtreferencia_h.value+
"&doc_comp_d="+document.form1.txtdoc_compromiso_d.value+"&doc_comp_h="+document.form1.txtdoc_compromiso_h.value+
"&referenciacomp_d="+document.form1.txtreferenciacomp_d.value+"&referenciacomp_h="+document.form1.txtreferenciacomp_h.value+
"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+
"&cod_presupd="+document.form1.txtcod_presupd.value+"&cod_presuph="+document.form1.txtcod_presuph.value+
"&cod_fuented="+document.form1.txtcod_fuented.value+"&cod_fuenteh="+document.form1.txtcod_fuenteh.value+
"&cedula_d="+document.form1.txtced_rif_d.value+"&cedula_h="+document.form1.txtced_rif_h.value+"&tipo_regis="+tipo;
window.open(url);
  }
}

function Llama_Menu_Rpt(murl){var url;   url="../"+murl; LlamarURL(url);}
</script>
</head>
<?
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
$sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$titulo=$registro["campo525"]; $formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
$l=strlen($formato_presup); $c=strlen($formato_categoria)+2; $p=strlen($formato_partida);

$sql="Select max(cod_presup) As max_cod_presup, min(cod_presup) As min_cod_presup from pre001 where (substring(cod_presup from ".$c." for 3)='401') and  (length(Cod_Presup)=".$l.")"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_presup_d=$registro["min_cod_presup"];  $cod_presup_h=$registro["max_cod_presup"];}

$sql="Select max(tipo_compromiso) As max_tipo_compromiso, min(tipo_compromiso) As min_tipo_compromiso from pre002"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $doc_comp_d=$registro["min_tipo_compromiso"];  $doc_comp_h=$registro["max_tipo_compromiso"];}

$sql="Select max(referencia_caus) As max_referencia_caus, min(referencia_caus) As min_referencia_caus from pre007"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $referencia_d=$registro["min_referencia_caus"];  $referencia_h=$registro["max_referencia_caus"];}

$sql="Select max(referencia_comp) As max_referencia_comp, min(referencia_comp) As min_referencia_comp from pre006"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $referenciacomp_d=$registro["min_referencia_comp"];  $referenciacomp_h=$registro["max_referencia_comp"];}

$sql="Select max(tipo_causado) As max_tipo_causado, min(tipo_causado) As min_tipo_causado from pre003"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $doc_causa_d=$registro["min_tipo_causado"];  $doc_causa_h=$registro["max_tipo_causado"];}

$sql="Select max(ced_rif ) As max_ced_rif , min(ced_rif ) As min_ced_rif  from pre099"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cedula_d=$registro["min_ced_rif"];  $cedula_h=$registro["max_ced_rif"];}

$sql="SELECT min(cod_fuente_financ) as min_fuente, max(cod_fuente_financ) as max_fuente  from pre095"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $cod_fuente_d=$registro["min_fuente"];  $cod_fuente_h=$registro["max_fuente"];}

$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_d'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_d=$registro["des_fuente_financ"];}
$sql="Select des_fuente_financ from pre095 where cod_fuente_financ='$cod_fuente_h'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$des_fuente_h=$registro["des_fuente_financ"];}

if($referencia_h==""){$referencia_h="zzzzzzzz";} if($doc_causa_d=="0000"){$doc_causa_d="0001";}

?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE DE CAUSADOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="903" border="1" id="tablacuerpo">
  <tr>
    <td width="992" height="897">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:952px; height:878px; z-index:1; top: 69px; left: 30px;">
        <form name="form1" method="get">
           <table width="950" height="871" border="0">
    <tr>
      <td width="958" height="867" align="center" valign="top"><table width="830" height="854" border="0" cellpadding="0" cellspacing="0">
        
        <tr>
          <td height="19"><table width="829" border="0">
            <tr>
              <td width="220" height="26"><div align="right"> </div></td>
              <td width="328"><span class="Estilo12"><strong>DESDE</strong></span></td>
              <td width="276"><span class="Estilo12"><strong>HASTA</strong></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="30"><table width="827" border="0">
            <tr>
              <td width="206" height="26"><div align="left"><span class="Estilo5">DOCUM. CAUSADO : </span></div></td><td width="53"><span class="Estilo5">
                <input name="txttipo_causado_d" type="text"  id="txttipo_causado_d" size="6" maxlength="4" value="<?echo $doc_causa_d?>" onFocus="encender(this);" onBlur="apaga_doc(this)"  onchange="chequea_tipo(this.form);">
              </span></td>
              <td width="283"><span class="Estilo5">
                <input name="btdoc_comp" type="button" id="btdoc_comp" title="Abrir Catalogo Documentos Compromiso" onClick="VentanaCentrada('/sia/presupuesto/rpt/Cat_doc_causad.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="61"><span class="Estilo5">
                <input name="txttipo_causado_h" type="text"  id="txttipo_causado_h" size="6" maxlength="4" value="<?echo $doc_causa_h?>" onFocus="encender(this);" onBlur="apaga_doc(this)"  onchange="chequea_tipo(this.form);">
              </span></td>
              <td width="202"><span class="Estilo5">
                <input name="btdoc_comp2" type="button" id="btdoc_comp2" title="Abrir Catalogo Documentos Compromiso" onClick="VentanaCentrada('/sia/presupuesto/rpt/Cat_doc_causah.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
              <td width="206" height="26"><div align="left"><span class="Estilo5">REFERENCIA CAUSADO : </span></div></td>
              <td width="169"><span class="Estilo5">
                <input name="txtreferencia_d" type="text" id="txtreferencia_d" size="10" maxlength="8" value="<?echo $referencia_d?>" onFocus="encender(this);" onBlur="apagar(this);"  onchange="checkrefe_comp(this.form);">
              </span></td>
              <td width="168"><span class="Estilo5">              </span></td>
              <td width="229"><span class="Estilo5">
                <input name="txtreferencia_h" type="text" id="txtreferencia_h" size="10" maxlength="8" value="<?echo $referencia_h?>" onFocus="encender(this);" onBlur="apagar(this);"  onchange="checkrefe_comp(this.form);">
              </span></td>
              <td width="38"><span class="Estilo5">              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="827" border="0">
            <tr>
              <td width="206" height="26"><div align="left"><span class="Estilo5">DOCUM. COMPROMISO : </span></div></td><td width="53"><span class="Estilo5">
                <input name="txtdoc_compromiso_d" type="text"  id="txtdoc_compromiso_d" size="6" maxlength="4" value="<?echo $doc_comp_d?>" onFocus="encender(this);" onBlur="apagar(this)"  onchange="chequea_tipo(this.form);">
              </span></td>
              <td width="283"><span class="Estilo5">
                <input name="btdoc_comp" type="button" id="btdoc_comp" title="Abrir Catalogo Documentos Compromiso" onClick="VentanaCentrada('/sia/presupuesto/rpt/Cat_doc_compd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="61"><span class="Estilo5">
                <input name="txtdoc_compromiso_h" type="text"  id="txtdoc_compromiso_h" size="6" maxlength="4" value="<?echo $doc_comp_h?>" onFocus="encender(this);" onBlur="apagar(this)"  onchange="chequea_tipo(this.form);">
              </span></td>
              <td width="202"><span class="Estilo5">
                <input name="btdoc_comp2" type="button" id="btdoc_comp2" title="Abrir Catalogo Documentos Compromiso" onClick="VentanaCentrada('/sia/presupuesto/rpt/Cat_doc_comph.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="30"><table width="827" border="0">
            <tr>
              <td width="211" height="26">
                <div align="left"><span class="Estilo5">REFERENCIA COMPROMISO: </span></div></td>
              <td width="169"><span class="Estilo5">
                <input name="txtreferenciacomp_d" type="text" id="txtreferenciacomp_d" size="10" maxlength="8" value="<?echo $referenciacomp_d?>" onFocus="encender(this);" onBlur="apagar(this);"  onchange="checkrefe_comp(this.form);">
              </span></td>
              <td width="164"><span class="Estilo5">              </span></td>
              <td width="229"><span class="Estilo5">
                <input name="txtreferenciacomp_h" type="text" id="txtreferenciacomp_h" size="10" maxlength="8" value="<?echo $referenciacomp_h?>" onFocus="encender(this);" onBlur="apagar(this);"  onchange="checkrefe_comp(this.form);">
              </span></td>
              <td width="38"><span class="Estilo5"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
              <td width="212" height="24">
                <div align="left"><span class="Estilo5">FECHA CAUSADO : </span></div></td>
              <td width="172"><span class="Estilo5">
                <input name="txtFechad" type="text" id="txtFechad" size="12" maxlength="10" onFocus="encender(this); " onBlur="apagar(this);"  value="<?echo $fecha_d?>" onchange="checkrefecha(this.form)">
                                <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha" onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /> </span></td>
              <td width="165"><span class="Estilo5"> </span></td>
              <td width="243"><span class="Estilo5">
                <input name="txtFechah" type="text" id="txtFechah" size="12" maxlength="10" onFocus="encender(this); " onBlur="apagar(this);"  value="<?echo $fecha_h?>" onchange="checkrefecha(this.form)">
                <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /></span></td>
              <td width="23"><span class="Estilo5"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="824" border="0">
            <tr>
              <td width="208" height="26"><div align="right"> </div></td>
              <td width="354"><span class="Estilo15"><strong><? echo $titulo; ?></span></td>
              <td width="243"><span class="Estilo15"><strong><? echo $titulo; ?></span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
              <td width="196" height="26">
                <div align="left"><span class="Estilo5">C&Oacute;DIGO PARTIDAS  : </span></div></td>
            <td width="188"><span class="Estilo5">
                <input name="txtcod_presupd" type="text" id="txtcod_presupd" size="30" maxlength="30" value="<?echo $cod_presup_d?>" onFocus="encender(this); " onBlur="apagar(this);">
              </span></td>
              <td width="169"><span class="Estilo5">
                <input name="btCodPre2" type="button" id="btCodPre2" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onclick="VentanaCentrada('../Cat_codigos_presupd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="194"><span class="Estilo5">
                <input name="txtcod_presuph" type="text" id="txtcod_presuph" size="30" maxlength="30" value="<?echo $cod_presup_h?>" onFocus="encender(this); " onBlur="apagar(this);">
              </span></td>
              <td width="63"><span class="Estilo5">
                <input name="btCodPre" type="button" id="btCodPre" title="Abrir Catalogo C&oacute;digos Presupuestarios"  onclick="VentanaCentrada('../Cat_codigos_presuph.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
			  <td width="225"><span class="Estilo5">FUENTE DE FINANCIAMIENTO DESDE  : </span></td>
               <td width="47"><span class="Estilo5">
                <input name="txtcod_fuented" type="text" id="txtcod_fuented" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="2" value="<?echo $cod_fuente_d?>">
              </span></td>
              <td width="51"><span class="Estilo5">
                <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('../Cat_fuentesd.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="486"><span class="Estilo5">
                <input name="txtdes_fuented" type="text" id="txtdes_fuented" size="75" maxlength="75"  value="<?echo $des_fuente_d?>" readonly>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="828" border="0">
            <tr>
              <td width="228"> <span class="Estilo5"><div align="left">HASTA :</div> 
              </span></td>
              <td width="42"><span class="Estilo5">
                <input name="txtcod_fuenteh" type="text" id="txtcod_fuenteh" onFocus="encender(this)" onBlur="apagar(this)" size="5" maxlength="2" value="<?echo $cod_fuente_h?>">
              </span></td>
              <td width="54"><span class="Estilo5">
                <input name="btfuente2" type="button" id="btfuente7" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('../Cat_fuentesh.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="486"><span class="Estilo5">
                <input name="txtdes_fuenteh" type="text" id="txtdes_fuenteh" size="75" maxlength="75" value="<?echo $des_fuente_h?>" readonly>
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="829" border="0">
            <tr>
              <td width="149" height="26">
                <div align="left"><span class="Estilo5">C&Eacute;DULA/RIF : </span></div></td>
              <td width="106"><span class="Estilo5">
                <input name="txtced_rif_d" type="text" id="txtced_rif_d" size="15" maxlength="15" value="<?echo $cedula_d?>" onFocus="encender(this); " onBlur="apagar(this);">
              </span></td>
              <td width="335"><span class="Estilo5">
                <input name="btfuente8"" type="button" id="btfuente9"" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('/sia/presupuesto/rpt/Cat_beneficiarios_d.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
              <td width="102"><span class="Estilo5">
                <input name="txtced_rif_h" type="text" id="txtced_rif_h" size="15" maxlength="15" value="<?echo $cedula_h?>" onFocus="encender(this); " onBlur="apagar(this);">
              </span></td>
              <td width="67"><span class="Estilo5">
                <input name="btced_rif" type="button" id="btced_rif" title="Abrir Catalogo de Beneficiarios" onClick="VentanaCentrada('/sia/presupuesto/rpt/Cat_beneficiarios_h.php?criterio=','SIA','','750','500','true')" value="...">
              </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="827" border="0">
            <tr>
              <td width="202" height="26"><span class="Estilo5"><div align="left">CR&Eacute;DITO ADICIONAL  : </div></span></td>
              <td width="182"><span class="Estilo5">
              <input name="txtref_creditod" type="text" id="txtref_creditod" title="Registre el codigo del documento compromiso" onChange="chequea_tipo(this.form);" size="12" maxlength="8" value="<?echo $ref_credd?>" onFocus="encender(this); " onBlur="apagar(this);"></span></td>
              <td width="264"><span class="Estilo5"> </span></td>
              <td width="130"><span class="Estilo5">
                <input name="txtref_creditoh" type="text" id="txtref_creditoh" title="Registre el codigo del documento compromiso" onChange="chequea_tipo(this.form);" size="12" maxlength="8" value="<?echo $ref_credh?>" onFocus="encender(this); " onBlur="apagar(this);">
              </span></span></td>
              <td width="37"><span class="Estilo5"> </span></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td height="10">&nbsp;</td>
        </tr>
        <tr>
          <td height="19"><table width="814" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="202"><div align="left"><span class="Estilo5">TIPO DE GASTO : </span></div></td>
              <td width="612"><span class="Estilo5"><span class="Estilo12">
                <select name="txtfunc_inv" size="1" id="txtfunc_inv" onFocus="encender(this)" onBlur="apagar(this)">
                  <option >CORRIENTE</option> <option>INVERSION</option> <option selected>CORRIENTE/INVERSION</option>
                </select>
              </span></td>
            </tr>
          </table></td>
        </tr>
        
        <tr>
          <td height="18">&nbsp;</td>
        </tr>
        
        <tr>
          <td height="48"><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr align="center" valign="middle">
              <td>
                    <div align="center">
                      <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_causados_gene('Rpt_causados_gene.php');">
                      </div></td>
              <td>
                    <div align="center">
                      <input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                      </div></td></tr>
          </table></td>
        </tr>
        
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