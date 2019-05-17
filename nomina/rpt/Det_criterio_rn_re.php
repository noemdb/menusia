<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
   $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);
   $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
   $tipo_nominad="";
   $tipo_nominah="zz";
   $cod_conceptod="";
   $cod_conceptoh="zzzz";
   $codigo_departamentod="";
   $codigo_departamentoh="zzzz";
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Reportes Detalles de los Criterios)</title>
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
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->

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
<?  $descripcion_d="";
    $descripcion_h="";
$sql="SELECT MAX(tipo_nomina) As Max_tipo_nomina, MIN(tipo_nomina) As Min_tipo_nomina FROM nom001 ";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{
  $encontro=false;
}
if($encontro=true){
  $tipo_nomina_d=$registro["min_tipo_nomina"];
  $tipo_nomina_h=$registro["max_tipo_nomina"];   }
?>
<?
    $denominacion_d;
    $denominacion_h;
$sql="SELECT MAX(cod_concepto) As Max_cod_concepto, MIN(cod_concepto) As Min_cod_concepto FROM nom002 ";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{
  $encontro=false;
}
if($encontro=true){
  $cod_conceptod=$registro["min_cod_concepto"];
  $cod_conceptoh=$registro["max_cod_concepto"];   }
?>
<?  $descripcion_dep_d="";
 $descripcion_dep_d="";
$sql="SELECT MAX(codigo_departamento) As Max_codigo_departamento, MIN(codigo_departamento) As Min_codigo_departamento FROM nom005 ";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{
  $encontro=false;
}
if($encontro=true){
  $codigo_departamento_d=$registro["min_codigo_departamento"];
  $codigo_departamento_h=$registro["max_codigo_departamento"];   }
?>
<body>
<table width="872" height="300" border="0" id="tablacuerpo">
  <tr>
   <td width="920" height="309"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:847px; height:342px; z-index:1; top: 24px; left: 13px;">
         <table width="853" border="0" align="center" >
           <tr>
             <td width="847"><table width="844" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="128" align="center" class="Estilo5"><div align="left">TIPO N&Oacute;MINA DESDE :</div></td>
                 <td width="46" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txttipo_nomina_d" type="text" id="txttipo_nomina_d" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2">
                 </span></div></td>
                 <td width="40" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo Tipos de nóminas" onClick="VentanaCentrada('../Cat_tipo_nominad.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="629" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_d" type="text" id="txtdescripcion_d" size="95" maxlength="98" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="844" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="129" align="center" class="Estilo5"><div align="left">TIPO N&Oacute;MINA HASTA :</div></td>
                 <td width="45" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txttipo_nomina_h" type="text" id="txttipo_nomina_h" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2">
                 </span></div></td>
                 <td width="41" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo Tipos de nóminas" onClick="VentanaCentrada('../Cat_tipo_nominah.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="629" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_h" type="text" id="txtdescripcion_h" size="95" maxlength="95" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="844" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="118" align="center" class="Estilo5"><div align="left">CONCEPTO DESDE :</div></td>
                 <td width="57" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtcod_concepto_d" type="text" id="txtcod_concepto_d" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3">
                 </span></div></td>
                 <td width="41" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('../Cat_conceptosd.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="628" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_d" type="text" id="txtdenominacion_d" size="95" maxlength="95" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="842" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="118" align="center" class="Estilo5"><div align="left">CONCEPTO HASTA :</div></td>
                 <td width="58" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtcod_concepto_h" type="text" id="txtcod_concepto_h" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3">
                 </span></div></td>
                 <td width="41" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('../Cat_conceptosh.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="625" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdenominacion_h" type="text" id="txtdenominacion_h" size="95" maxlength="98" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="29"><table width="817" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="194" align="center" class="Estilo5"><div align="left">C&Oacute;DIGO DEPARTAMENTO DESDE :</div></td>
                 <td width="185" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtcodigo_departamento_d" type="text" id="txtcodigo_departamento_d2" onFocus="encender(this)" onBlur="apagar(this)" size="25" maxlength="25">
                 </span></div></td>
                 <td width="44" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo5" type="button" id="Catalogo5" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamentod.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="394" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_dep_d" type="text" id="txtdescripcion_dep_d" size="61" maxlength="60" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="816" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="center" class="Estilo5"><div align="left">C&Oacute;DIGO DEPARTAMENTO HASTA :</div></td>
                 <td width="184" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtcodigo_departamento_h" type="text" id="txtcodigo_departamento_h" onFocus="encender(this)" onBlur="apagar(this)" size="25" maxlength="25">
                 </span></div></td>
                 <td width="44" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo6" type="button" id="Catalogo6" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamentoh.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="392" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_dep_h" type="text" id="txtdescripcion_dep_h" size="61" maxlength="62" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="837" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="96" align="center"><div align="left" class="Estilo5">MES PROCESO : </div></td>
                 <td width="208" align="center">
                   <div align="left"><span class="Estilo5">
                     <select name="select2" size="1" id="select">
                       <option>FECHA</option>
                        </select>
</span></div></td>
                 <td width="91" align="center"><div align="left" class="Estilo5">FECHA DESDE :</div></td>
                 <td width="207" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                     <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
                 <td width="54" align="center"><div align="left" class="Estilo5">HASTA :</div></td>
                 <td width="181" align="center"><div align="left"><span class="Estilo5">
                   <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                   <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="837" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="110" align="center"><div align="left" class="Estilo5">FORMA DE PAGO  : </div></td>
                 <td width="194" align="center">
                   <div align="left"><span class="Estilo5">
                     <select name="select4" size="1" id="select3">
                       <option>DEPOSITO</option>
                       <option>EFECTIVO</option>
                       <option>CHEQUE</option>
                       <option>RECIBO</option>
                       <option selected>TODOS</option>
                                                               </select>
                 </span></div></td>
                 <td width="91" align="center"><div align="left" class="Estilo5"></div></td>
                 <td width="207" align="center">
                   <div align="left"><span class="Estilo5">                     </span></div></td>
                 <td width="54" align="center"><div align="left" class="Estilo5"></div></td>
                 <td width="181" align="center"><div align="left"><span class="Estilo5">                      </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="844" border="0" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="141" align="center"><div align="left" class="Estilo5">NOMBRE DEL REPORTE  : </div></td>
                 <td width="703" align="center">
                   <div align="left"><span class="Estilo5">
                     <select name="select5" size="1" id="select4">
                       <option>............................................................................................................................................................</option>
                                                                                                                                                   </select>
                 </span></div></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td><table width="806">
               <tr>
                 <td width="118" scope="col"><div align="right"><span class="Estilo5"><span class="Estilo10"></span></span></div></td>
                 <td width="174" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">TIPO DE C&Aacute;LCULO</span></span></span></div></td>
                 <td width="367" scope="col"><span class="Estilo12">SALTO DE P&Aacute;GINA AL FINALIZAR CADA N&Oacute;MINA </span></td>
                 <td width="224" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">TIPO DE RESUMEN</span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="813">
               <tr>
                 <td width="103" height="16" scope="col"><div align="right"> <span class="Estilo5"> </span></div></td>
                 <td width="286" scope="col"><div align="left"><span class="Estilo5">
                     <select name="select8" size="1" id="select8">
                       <option>NORMAL</option>
                       <option>EXTRAORDINARIA</option>
                     </select>
                 </span></div></td>
                 <td width="269" scope="col"><span class="Estilo5">
                   <select name="select" size="1" id="select2">
                     <option>SI</option>
                     <option>NO</option>
                   </select>
                   </span></td>
                 <td width="223" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <select name="select3" size="1" id="select5">
                     <option>ASIGNACIONES</option>
                     <option>DEDUCCIONES</option>
                     <option>APORTES</option>
                     <option>TODOS</option>
                   </select>
                 </span></span></td>
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
