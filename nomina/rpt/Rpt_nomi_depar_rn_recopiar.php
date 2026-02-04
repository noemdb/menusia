<?include ("../../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP NÓMINA Y PERSONAL (Reportes De Nómina Por Departamento)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->

function Llama_Rpt_Mayor_Analitico_Presup(murl){
var url;
var r;
var imp;
var saltopag;
var ord;
  if(document.form1.opsaltopag[0].checked==true){saltopag="S";}
  if(document.form1.opsaltopag[1].checked==true){saltopag="N";}
  if(document.form1.opordenar[0].checked==true){ord="S";}
  if(document.form1.opordenar[1].checked==true){ord="N";}
  r=confirm("Desea Generar el Reporte Mayor Analitico de Presupuesto?");
  if (r==true) {
    url=murl+"?periodod="+document.form1.txtperiodod.value+"&periodoh="+document.form1.txtperiodoh.value+"&cod_cuenta_d="+document.form1.txtCodigo_Cuenta_D.value+"&cod_cat_d="+document.form1.txtCodigo_Cat_D.value+"&cod_cat_h="+document.form1.txtCodigo_Cat_H.value+"&cod_par_d="+document.form1.txtCodigo_Par_D.value+"&cod_par_h="+document.form1.txtCodigo_Par_H.value+"&tipo_asiento_d="+document.form1.txtTipo_Asientod.value+"&tipo_asiento_h="+document.form1.txtTipo_Asientoh.value+"&salto_pag="+saltopag+"&ordenar="+ord;
    LlamarURL(url);
  }
}

function Llama_Menu_Rpt(murl){
var url;
   url="../"+murl;
   LlamarURL(url);
}

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
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE N&Oacute;MINA POR DEPARTAMENTO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="403" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="397"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:504px; height:94px; z-index:1; top: 81px; left: 42px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><table width="898">
               <tr>
                 <td width="401" scope="col"><div align="left"></div></td>
                 <td width="141" scope="col"><div align="left"><span class="Estilo12">CRITERIOS</span></div></td>
                 <td width="173" scope="col"><div align="left"></div></td>
                 <td width="163" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="828" border="0" align="center" dwcopytype="CopyTableCell" >
               <tr>
                 <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
                     <tr>
                       <td width="176" align="center" class="Estilo5"><div align="left">TIPO NÓMINA DESDE :</div></td>
                       <td width="54" align="center">
                         <div align="left"><span class="Estilo5">
                           <input name="txttipo_nomina_d" type="text" id="txttipo_nomina_d" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2">
                       </span></div></td>
                       <td width="36" align="center"><div align="left"><span class="Estilo5">
                           <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo Tipos de nóminas" onClick="VentanaCentrada('../Cat_tipo_nominad.php?criterio=','SIA','','650','500','true')" value="...">
                       </span></div></td>
                       <td width="637" align="center"><div align="left"><span class="Estilo5">
                           <input name="txtdescripcion_d" type="text" id="txtdescripcion_d" size="88" maxlength="88" readonly>
                       </span></div></td>
                     </tr>
                 </table></td>
               </tr>
               <tr>
                 <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
                     <tr>
                       <td width="177" align="center" class="Estilo5"><div align="left">TIPO NÓMINA HASTA :</div></td>
                       <td width="53" align="center">
                         <div align="left"><span class="Estilo5">
                           <input name="txttipo_nomina_h" type="text" id="txttipo_nomina_h" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2">
                       </span></div></td>
                       <td width="36" align="center"><div align="left"><span class="Estilo5">
                           <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo Tipos de nóminas" onClick="VentanaCentrada('../Cat_tipo_nominah.php?criterio=','SIA','','650','500','true')" value="...">
                       </span></div></td>
                       <td width="637" align="center"><div align="left"><span class="Estilo5">
                           <input name="txtdescripcion_h" type="text" id="txtdescripcion_h" size="88" maxlength="88" readonly>
                       </span></div></td>
                     </tr>
                 </table></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="237" scope="col"><div align="right"><span class="Estilo12">ESTATUS DEL TRABAJADOR </span></div></td>
                 <td width="389" scope="col"><div align="center"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">OCULTAR NOMBRES </span></span></span></div></td>
                 <td width="263" scope="col"><span class="Estilo12">IMPRIMIR ESPACIOS PARA FIRMAR </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="97" scope="col"><div align="right">                     <span class="Estilo5">
                   <input type="checkbox" name="optodos" value="TODOS" checked>
                   TODOS</span></div></td>
                 <td width="92" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="opactivos" value="ACTIVOS">
        ACTIVOS</span></div></td>
                 <td width="179" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="opvacaciones" value="VACACIONES">
      VACACIONES</span></td>
                 <td width="64" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="opocultar_si" value="OCULTA_S" checked>
      SI </span></td>
                 <td width="241" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="opoculta_no" value="OCULTA_NO">
      NO </span></td>
                 <td width="53" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="opespacio_firma_si" value="ESP_FIRMA_S" checked>
      SI </span></td>
                 <td width="147" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="opespacio_firma_no" value="ESP_FIRMA_NO">
      NO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="270" scope="col"><div align="right"><span class="Estilo12">SALTO DE PAGINAS POR DEPARTAMENTOS </span></div></td>
                 <td width="366" scope="col"><div align="center"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">MOSTRAR CANTIDAD DE CONCEPTOS </span></span></span></div></td>
                 <td width="253" scope="col"><span class="Estilo12">MOSTRAR SALDOS DE CONCEPTOS </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903">
               <tr>
                 <td width="145" height="16" scope="col"><div align="right">
                     <span class="Estilo5">
                     <input type="checkbox" name="opsalto_si" value="SALTO_SI" checked>
                    </span>                     <span class="Estilo5">SI</span></div></td>
                 <td width="253" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="opsalto_no" value="SALTO_NO">
        NO</span></div></td>
                 <td width="51" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="opcantidad_si" value="CANTIDAD_SI" checked>
      SI </span></td>
                 <td width="232" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="opcantidad_no" value="CANTIDAD_NO">
      NO </span></td>
                 <td width="52" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="opsaldos_si" value="SALDOS_SI" checked>
      SI </span></td>
                 <td width="142" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="opsaldos_no" value="SALDOS_NO">
      NO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="253" scope="col"><div align="right"><span class="Estilo12">IMPRIMIR FIRMA ULTIMA P&Aacute;GINA </span></div></td>
                 <td width="426" scope="col"><div align="center"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">TIPO DE C&Aacute;LCULO </span></span></span></div></td>
                 <td width="210" scope="col"><span class="Estilo12">TOTAL POR N&Oacute;MINA</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903">
               <tr>
                 <td width="159" height="16" scope="col"><div align="right">
                     <span class="Estilo5">
                     <input type="checkbox" name="opfirmas_si" value="FIRMAS_SI" checked>
                    </span>                     <span class="Estilo5">SI</span></div></td>
                 <td width="207" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="opfirmas_no" value="FIRMAS_NO">
        NO</span></div></td>
                 <td width="80" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="opnormal" value="NORMAL" checked>
      NORMAL</span></td>
                 <td width="235" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="opextra" value="EXTRA">
      EXTRAORDINARIA</span></td>
                 <td width="52" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="optotal_nom_si" value="TOTAL_NOM_SI" checked>
      SI </span></td>
                 <td width="142" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="optotal_nom_no" value="TOTAL_NOM_NO">
      NO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="316" scope="col"><div align="right"><span class="Estilo12">MANTENER INFORMACI&Oacute;N DEL TRABAJADOR UNIDA</span></div></td>
                 <td width="378" scope="col"><div align="center"></div></td>
                 <td width="195" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">TIPO REPORTE</span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="154" scope="col"><div align="right"><span class="Estilo5">
                     <input type="checkbox" name="opagrupa_trab_si" value="AGRUPA_TRABA_SI" checked>
        SI</span></div></td>
                 <td width="487" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="opagrupa_trab_no" value="AGRUPA_TRABA_NO">
        NO</span></div></td>
                 <td width="80" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="optp_reporte1" value="TP_REPORTE1" checked>
      N&Oacute;MINA </span></td>
                 <td width="164" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="optp_reporte1" value="TP_REPORTE2">
      PRE-N&Oacute;MINA </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <th width="446" scope="col"><div align="center">
                     <input name="btgenera2" type="button" id="btgenera26" value="GENERAR" onClick="javascript:Llama_Rpt_Diario_Gen('Rpt_Diario_Gen.php');">
                 </div></th>
                 <th width="447" scope="col"><input name="btcancelar2" type="button" id="btcancelar26" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu_repor_nomi_re.php');"></th>
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