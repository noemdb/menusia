<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$tipo_nominad="";$tipo_nominah="zz";$cod_conceptod="";$cod_conceptoh="zzzz";$codigo_departamentod="";$codigo_departamentoh="zzzz";$tipo_resumen="";;$forma_pago="";$tipo_calculo="";
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Reportes Resumen de Conceptos)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_resu_concep_rn(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Resumen de Conceptos?");
  if (r==true){url=murl+"?&tipo_nomina_d="+document.form1.txttipo_nomina_d.value+"&tipo_nomina_h="+document.form1.txttipo_nomina_h.value+
  "&cod_conceptod="+document.form1.txtcod_concepto_d.value+"&cod_conceptoh="+document.form1.txtcod_concepto_d.value+
  "&codigo_departamentod="+document.form1.txtcodigo_departamento_d.value+"&codigo_departamentoh="+document.form1.txtcodigo_departamento_h.value+
  "&tipo_resumen="+document.form1.txttipo_resumen.value+"&forma_pago="+document.form1.txtforma_pago.value+"&tipo_calculo="+document.form1.txttipo_calculo.value;
  window.open(url,"Reporte Resumen de Conceptos")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
<style type="text/css">
<!--
.Estilo5 {font-size: 10px}
.Estilo2 {color: #FFFFFF}
.Estilo6 {
        font-size: 16pt;
        font-weight: bold;
}
.Estilo9 {font-size: 8pt}
.Estilo10 {font-size: 12px}
.Estilo12 {font-size: 10px; font-weight: bold; }
-->
</style>
</head>
<?
$descripcion_d="";$descripcion_h=""; $denominacion_concep_d;$denominacion_concep_h;  $descripcion_dep_d="";$descripcion_dep_d="";
$sql="SELECT MAX(tipo_nomina) As Max_tipo_nomina, MIN(tipo_nomina) As Min_tipo_nomina FROM nom001 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_nomina_d=$registro["min_tipo_nomina"];$tipo_nomina_h=$registro["max_tipo_nomina"];   }
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_d=$registro["descripcion"];}
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_h=$registro["descripcion"];}
$sql="SELECT MAX(cod_concepto) As Max_cod_concepto, MIN(cod_concepto) As Min_cod_concepto FROM nom002 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cod_conceptod=$registro["min_cod_concepto"];$cod_conceptoh=$registro["max_cod_concepto"]; }
$sql="SELECT cod_concepto,denominacion FROM nom002 where cod_concepto='$cod_conceptod'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_concep_d=$registro["denominacion"];}
$sql="SELECT cod_concepto,denominacion FROM nom002 where cod_concepto='$cod_conceptoh'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_concep_h=$registro["denominacion"];}
$sql="SELECT MAX(codigo_departamento) As Max_codigo_departamento, MIN(codigo_departamento) As Min_codigo_departamento FROM nom005 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$codigo_departamento_d=$registro["min_codigo_departamento"];$codigo_departamento_h=$registro["max_codigo_departamento"];   }
$sql="SELECT codigo_departamento,descripcion_dep FROM nom005 where codigo_departamento='$codigo_departamento_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_dep_d=$registro["descripcion_dep"];}
$sql="SELECT codigo_departamento,descripcion_dep FROM nom005 where codigo_departamento='$codigo_departamento_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_dep_h=$registro["descripcion_dep"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE RESUMEN DE CONCEPTOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="379" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="373"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:504px; height:94px; z-index:1; top: 81px; left: 42px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td colspan="4"><table width="898">
               <tr>
                 <td width="401" scope="col"><div align="left"></div></td>
                 <td width="141" scope="col"><div align="left"><span class="Estilo12">CRITERIOS</span></div></td>
                 <td width="173" scope="col"><div align="left"></div></td>
                 <td width="163" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td colspan="4"><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="129" align="center" class="Estilo5"><div align="left">TIPO NOMINA DESDE :</div></td>
                 <td width="37" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txttipo_nomina_d" type="text" id="txttipo_nomina_d" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $tipo_nomina_d?>">
                 </span></div></td>
                 <td width="45" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo Tipos de nóminas" onClick="VentanaCentrada('../Cat_tipo_nominad.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="691" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_d" type="text" id="txtdescripcion_d" size="50" maxlength="108" readonly value="<?echo $descripcion_d?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td colspan="4"><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="130" align="center" class="Estilo5"><div align="left">TIPO NOMINA HASTA:</div></td>
                 <td width="35" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txttipo_nomina_h" type="text" id="txttipo_nomina_h" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $tipo_nomina_d?>">
                 </span></div></td>
                 <td width="47" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo Tipos de nóminas" onClick="VentanaCentrada('../Cat_tipo_nominah.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="690" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_h" type="text" id="txtdescripcion_h" size="50" maxlength="109" readonly value="<?echo $descripcion_h?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td colspan="4"><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="136" align="center" class="Estilo5"><div align="left">CONCEPTO DESDE :</div></td>
                 <td width="28" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtcod_concepto_d" type="text" id="txtcod_concepto_d" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $cod_conceptod?>">
                 </span></div></td>
                 <td width="42" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('../Cat_conceptosd.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="696" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_d" type="text" id="txtdenominacion_d" size="50" maxlength="99" readonly value="<?echo $denominacion_concep_d?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td colspan="4"><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="132" align="center" class="Estilo5"><div align="left">CONCEPTO HASTA :</div></td>
                 <td width="31" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtcod_concepto_h" type="text" id="txtcod_concepto_h" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $cod_conceptoh?>">
                 </span></div></td>
                 <td width="44" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('../Cat_conceptosh.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="695" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_h" type="text" id="txtdenominacion_h" size="50" maxlength="109" readonly value="<?echo $denominacion_concep_h?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td colspan="4"><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="center" class="Estilo5"><div align="left">CODIGO DEPARTAMENTO DESDE :</div></td>
                 <td width="189" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtcodigo_departamento_d" type="text" id="txtcodigo_departamento_d" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" value="<?echo $codigo_departamento_d?>">
                 </span></div></td>
                 <td width="49" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo5" type="button" id="Catalogo5" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamentod.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="469" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_dep_d" type="text" id="txtdescripcion_dep_d" size="50" maxlength="100" readonly value="<?echo $descripcion_dep_d?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td colspan="4"><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="center" class="Estilo5"><div align="left">CODIGO DEPARTAMENTO HASTA :</div></td>
                 <td width="190" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtcodigo_departamento_h" type="text" id="txtcodigo_departamento_h" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" value="<?echo $codigo_departamento_h?>">
                 </span></div></td>
                 <td width="48" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo6" type="button" id="Catalogo6" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamentoh.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="469" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_dep_h" type="text" id="txtdescripcion_dep_h" size="50" maxlength="100" readonly value="<?echo $descripcion_dep_h?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
                   <tr>
             <td width="192" align="left" class="Estilo5">FORMA DE PAGO:</td>
             <td width="317"><select name="txtforma_pago" size="1" id="txtforma_pago">
                     <option selected value ='TODOS'>TODOS</option>
                     <option value ='DEPOSITO'>DEPOSITO</option>
                     <option value ='EFECTIVO'>EFECTIVO</option>
                     <option value ='CHEQUE'>CHEQUE</option>
                     <option value ='RECIBO'>RECIBO</option>
                 </select></td>
             <td width="196">&nbsp;</td>
             <td width="186">&nbsp;</td>
           </tr>

           <tr>
             <td colspan="4"><table width="903">
               <tr>
                 <td width="118" scope="col"><div align="right"><span class="Estilo5"><span class="Estilo10"></span></span></div></td>
                 <td width="174" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">TIPO DE CALCULO</span></span></span></div></td>
                 <td width="367" scope="col"><span class="Estilo12">SALTO DE PAGINA AL FINALIZAR CADA NOMINA </span></td>
                 <td width="224" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">TOTAL POR NOMINA</span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td colspan="4"><table width="901">
               <tr>
                 <td width="103" height="16" scope="col"><div align="right"> <span class="Estilo5"> </span></div></td>
                 <td width="286" scope="col"><div align="left"><span class="Estilo5">
                     <select name="txttipo_calculo" size="1" id="txttipo_calculo">
                        <option value='N' selected>NORMAL</option>
                        <option value='E'>EXTRAORDINARIA</option>
                     </select>
                 </span></div></td>
                 <td width="269" scope="col"><span class="Estilo5">
                   <select name="select" size="1" id="select2">
                     <option>SI</option>
                     <option>NO</option>
                   </select>
                   </span></td>
                 <td width="223" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <select name="select9" size="1" id="select9" disabled=true>
                     <option>NO</option>
                     <option>SI</option>
                   </select>
                 </span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td width="192">&nbsp;</td>
             <td width="317"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">TIPO DE RESUMEN</span></span></span></td>
             <td width="196">&nbsp;</td>
             <td width="186">&nbsp;</td>
           </tr>
                   <tr>
             <td height="22">&nbsp;</td>
             <td><span class="Estilo5"><span class="Estilo10">
               <select name="txttipo_resumen" size="1" id="txttipo_resumen">
                 <option selected value='ASIGNACIONES'>ASIGNACIONES</option>
                 <option value='DEDUCCIONES'>DEDUCCIONES</option>
                 <option value='APORTES'>APORTES</option>
                 <option value='TODOS'>TODOS</option>
               </select>
             </span></span></td>
             <td>&nbsp;</td>
             <td>&nbsp;</td>
                         <td width="2">&nbsp;</td>
             <td width="2">&nbsp;</td>
                   </tr>
           <tr>
             <td colspan="4"><table width="896">
               <tr>
                 <th width="446" scope="col"><div align="center">
                     <input name="btgenera2" type="button" id="btgenera22" value="GENERAR" onClick="javascript:Llama_Rpt_resu_concep_rn('Rpt_resu_concep_rn.php');">
                 </div></th>
                 <th width="438" scope="col"><input name="btcancelar2" type="button" id="btcancelar22" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></th>
               </tr>
             </table></td>
           </tr>
         </table>
         <p align="left">&nbsp;</p>
       </div>
    </form>    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<? pg_close();?>
