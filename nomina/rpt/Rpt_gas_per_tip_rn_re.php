<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
   $tipo_nominad="";
   $tipo_nominah="zz";
   $codigo_departamentod="";
   $codigo_departamentoh="zzzz";
   $fecha_d="01/01/2009";
   $fecha_h="31/12/2009";
   $detallado="";
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Reportes De Ralaci&oacute;n De Conceptos Detalle Aportes)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){
var mref;
var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){
var mref;
var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){
     mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);
     mform.txtFechah.value=mfec;}
return true;}
function Llama_Rpt_gas_per_tip_rn(murl){var url;var r;
  r=confirm("Desea Generar el Reporte de Gastos de Personal por Tipo?");
  if (r==true){url=murl+"?&tipo_nomina_d="+document.form1.txttipo_nomina_d.value+"&tipo_nomina_h="+document.form1.txttipo_nomina_h.value+
  "&codigo_departamentod="+document.form1.txtcodigo_departamento_d.value+"&codigo_departamentoh="+document.form1.txtcodigo_departamento_h.value+
  "&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+
  "&detallado="+document.form1.txtdetallado.value;
  window.open(url,"Reporte de Gastos de Personal por Tipo")}
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
$descripcion_d="";$descripcion_h="";$descripcion_dep_d=""; $descripcion_dep_h="";
$sql="SELECT MAX(tipo_nomina) As Max_tipo_nomina, MIN(tipo_nomina) As Min_tipo_nomina FROM nom001 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_nomina_d=$registro["min_tipo_nomina"];$tipo_nomina_h=$registro["max_tipo_nomina"];   }
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_d=$registro["descripcion"];}
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_h=$registro["descripcion"];}
$sql="SELECT MAX(codigo_departamento) As Max_codigo_departamento, MIN(codigo_departamento) As Min_codigo_departamento FROM nom005 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}{$codigo_departamento_d=$registro["min_codigo_departamento"];$codigo_departamento_h=$registro["max_codigo_departamento"];   }
$sql="SELECT codigo_departamento,descripcion_dep FROM nom005 where codigo_departamento='$codigo_departamento_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_dep_d=$registro["descripcion_dep"];}
$sql="SELECT codigo_departamento,descripcion_dep FROM nom005 where codigo_departamento='$codigo_departamento_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_dep_h=$registro["descripcion_dep"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE GASTOS DE PERSONAL POR TIPO </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="333" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="327"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
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
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="130" align="center" class="Estilo5"><div align="left">TIPO NOMINA DESDE :</div></td>
                 <td width="43" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txttipo_nomina_d" type="text" id="txttipo_nomina_d" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_d?>">
                 </span></div></td>
                 <td width="41" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo Tipos de nóminas" onClick="VentanaCentrada('../Cat_tipo_nominad.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="689" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_d" type="text" id="txtdescripcion_d" size="50" maxlength="108" readonly value="<?echo $descripcion_d?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="131" align="center" class="Estilo5"><div align="left">TIPO NOMINA HASTA :</div></td>
                 <td width="43" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txttipo_nomina_h" type="text" id="txttipo_nomina_h" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_h?>">
                 </span></div></td>
                 <td width="41" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo Tipos de nóminas" onClick="VentanaCentrada('../Cat_tipo_nominah.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="688" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_h" type="text" id="txtdescripcion_h" size="50" maxlength="109" readonly value="<?echo $descripcion_h?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
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
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="center" class="Estilo5"><div align="left">CODIGO DEPARTAMENTO HASTA :</div></td>
                 <td width="190" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtcodigo_departamento_h" type="text" id="txtcodigo_departamento_h2" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" value="<?echo $codigo_departamento_h?>">
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
             <td><table width="903" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="center"><div align="left" class="Estilo5">FECHA DESDE : </div></td>
                 <td width="127" align="center">                   <div align="left"><span class="Estilo5">
                     <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="7" >
                     <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
                     </span></div></td>
                 <td width="420" align="center"><div align="left" class="Estilo5">HASTA :
                   <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="7" >
                   <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
                 </div></td>
                 <td width="160" align="center">
                   <div align="left"><span class="Estilo5">
                      </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="301" scope="col"><div align="right"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">TIPO DE CALCULO </span></span></span></div></td>
                 <td width="236" scope="col"><div align="center"></div></td>
                 <td width="352" scope="col"><span class="Estilo12">DETALLADO POR PERSONA </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903">
               <tr>
                 <td width="185" height="16" scope="col"><div align="right"> <span class="Estilo5"> </span></div></td>
                 <td width="196" scope="col"><div align="left"><span class="Estilo5">
                     <select name="txttipo_cal" size="1" id="txttipo_cal">
                       <option selected value="NORMAL">NORMAL</option>
                       <option value="EXTRAORDINARIA">EXTRAORDINARIA</option>
                     </select>
                 </span></div></td>
                 <td width="19" scope="col"><span class="Estilo5"> </span></td>
                 <td width="138" scope="col"><span class="Estilo5"> </span></td>
                 <td width="221" scope="col"><span class="Estilo5">
                   <select name="txtdetallado" size="1" id="txtdetallado">
                     <option value="POR FECHA">POR FECHA</option>
                     <option value="POR PERSONA">POR PRESONA</option>
                     <option selected value="NO">NO</option>
                      </select>
                 </span></td>
                 <td width="116" scope="col"><span class="Estilo5"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <th width="446" scope="col"><div align="center">
                     <input name="btgenera2" type="button" id="btgenera2" value="GENERAR" onClick="javascript:Llama_Rpt_gas_per_tip_rn('Rpt_gas_per_tip_rn.php');">
                 </div></th>
                 <th width="447" scope="col"><input name="btcancelar2" type="button" id="btcancelar2" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></th>
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
