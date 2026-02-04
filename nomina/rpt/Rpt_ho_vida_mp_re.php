<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
   $tipo_nominad=""; $tipo_nominah="zz";   $cod_empleado_d=""; $cod_empleado_h="";  $cedula_d=""; $cedula_h="zzzzzzzz";
   $sexo="";  $estado_civil="";  $fecha_d="01/01/1900";  $fecha_h="31/12/9999";
   $edad_d="0";  $edad_h="99";  $estatus="";  $codigo_cargo_d="";   $codigo_cargo_h="zzzzzzzz";   $codigo_departamentod="";  $codigo_departamentoh="zzzzzzzz";
   $fecha_ingreso_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_ingreso_h=formato_ddmmaaaa($Fec_Fin_Ejer);  
   $fecha_ingreso_d="01/01/1900";  $fecha_ingreso_h="31/12/9999"; $inf_per="";  $inf_car="";
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Reportes Hoja de Vida del Trabajador)</title>
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
function Llama_Rpt_ho_vida_mp(murl){
var url; var r; var per; var car;

  /*if(document.form1.opinfper[0].checked==true){per="SI";}
  if(document.form1.opinfper[1].checked==true){per="NO";}

  if(document.form1.opinfcar[0].checked==true){car="SI";}
  if(document.form1.opinfcar[1].checked==true){car="NO";} */

  r=confirm("Desea Generar el Reporte Hoja de Vida del Trabajador?");
  if (r==true) {url=murl+"?tipo_nominad="+document.form1.txttipo_nomina_d.value+"&tipo_nominah="+document.form1.txttipo_nomina_h.value+
  "&cod_empleado_d="+document.form1.txtcod_empleado_d.value+"&cod_empleado_h="+document.form1.txtcod_empleado_h.value+
  "&cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value;
   window.open(url,"Reporte Hoja de Vida del Trabajador")
  }
}
function Llama_Menu_Rpt(murl){var url;    url="../"+murl;  LlamarURL(url);}

</script>
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
<?  $nombre_d="";
    $nombre_h="";
$sql="SELECT MAX(cod_empleado) As Max_cod_empleado, MIN(cod_empleado) As Min_cod_empleado FROM nom006";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{
  $encontro=false;
}
if($encontro=true){
  $cod_empleado_d=$registro["min_cod_empleado"];
  $cod_empleado_h=$registro["max_cod_empleado"];   }
?>
<?
    $nombre_d="";
    $nombre_h="";
$sql="SELECT MAX(cedula) As Max_cedula, MIN(cedula) As Min_cedula FROM NOM006";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{
  $encontro=false;
}
if($encontro=true){
  $cedula_d=$registro["min_cedula"];
  $cedula_h=$registro["max_cedula"];
  }
?>
<?  $denominacion_d="";
 $denominacion_d="";
$sql="SELECT MAX(codigo_cargo) As Max_codigo_cargo, MIN(codigo_cargo) As Min_codigo_cargo FROM nom004 ";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{
  $encontro=false;
}
if($encontro=true){
  $codigo_cargo_d=$registro["min_codigo_cargo"];
  $codigo_cargo_h=$registro["max_codigo_cargo"];   }
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
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE HOJA DE VIDA DEL TRABAJADOR</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="488" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="482"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
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
             <td><table width="905">
               <tr>
                 <td width="182" scope="col"><div align="right"><span class="Estilo5">TIPO DE NOMINA :</span></div></td>
                 <td width="30" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txttipo_nomina_d" type="text" id="txttipo_nomina_d" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_d?>">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="231" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo1" type="button" id="Catalogo12" title="Abrir Catalogo Tipos de n&oacute;minas" onClick="VentanaCentrada('../Cat_tipo_nomina_d.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
                 <td width="58" class="Estilo5" scope="col">HASTA : </td>
                 <td width="29" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txttipo_nomina_h" type="text" id="txttipo_nomina_h" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_h?>">
                   <span class="menu"><strong><strong> <strong><strong> </strong></strong> </strong></strong></span></span></span></td>
                 <td width="347" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong>
                   <input name="Catalogo2" type="button" id="Catalogo22" title="Abrir Catalogo Tipos de n&oacute;minas" onClick="VentanaCentrada('../Cat_tipo_nomina_h.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="180" scope="col"><div align="right"><span class="Estilo5">CODIGO TRABAJADOR DESDE :</span></div></td>
                 <td width="142" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_empleado_d" type="text" id="txtcod_empleado_d" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="15"  value="<?echo $cod_empleado_d?>">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="123" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo3" type="button" id="Catalogo33" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('../Cat_trabajadoresd.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
                 <td width="54" scope="col"><span class="Estilo5">HASTA :</span></td>
                 <td width="137" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcod_empleado_h" type="text" id="txtcod_empleado_h" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="20"  value="<?echo $cod_empleado_h?>">
                   <span class="menu"><strong><strong> </strong></strong></span></span></span></td>
                 <td width="241" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo4" type="button" id="Catalogo43" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('../Cat_trabajadoresh.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="180" scope="col"><div align="right"><span class="Estilo5">CEDULA TRABAJADOR DESDE :</span></div></td>
                 <td width="94" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $cedula_d?>">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="171" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo5" type="button" id="Catalogo5" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_cedula_re_d.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
                 <td width="56" class="Estilo5" scope="col">HASTA : </td>
                 <td width="94" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $cedula_h?>">
                   <span class="menu"><strong><strong> </strong></strong></span></span></span></td>
                 <td width="282" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo6" type="button" id="Catalogo6" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_cedula_re_h.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="906">
               <tr>
                 <td width="180" scope="col"><div align="right"><span class="Estilo5">SEXO :</span></div></td>
                 <td width="445" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                     <select name="select">
                       <option>TODOS</option>
                       <option>MASCULINO</option>
                       <option>FEMENINO</option>
                     </select>
                 </strong></strong></span></span> </span></div></td>
                 <td width="265" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="906">
               <tr>
                 <td width="181" scope="col"><div align="right"><span class="Estilo5">ESTADO CIVIL :</span></div></td>
                 <td width="713" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                     <select name="select2">
                       <option>TODOS</option>
                       <option>SOLTERO</option>
                       <option>CASADO</option>
                       <option>VIUDO</option>
                       <option>DIVORCIADO</option>
                       <option>OTROS</option>
                     </select>
                 </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="182" scope="col"><div align="right"><span class="Estilo5">FECHA NACIMIENTO DESDE :</span></div></td>
                 <td width="269" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong>
                     <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                     <strong><strong><strong><strong><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /> </strong></strong> </strong></strong></span></span> </span></div></td>
                 <td width="56" scope="col"><span class="Estilo5">HASTA :</span></td>
                 <td width="378" scope="col"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                   <strong><strong><strong><strong><strong><strong><strong><strong><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="906">
               <tr>
                 <td width="181" scope="col"><div align="right"><span class="Estilo5">SEXO :</span></div></td>
                 <td width="226" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                     <select name="select4">
                       <option>TODOS</option>
                       <option>MASCULINO</option>
                       <option>FEMENINO</option>
                     </select>
                 </strong></strong></span></span> </span></div></td>
                 <td width="99" scope="col"><span class="Estilo5">ESTADO CIVIL :</span></td>
                 <td width="291" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <select name="select4">
                     <option>TODOS</option>
                     <option>SOLTERO</option>
                     <option>CASADO</option>
                     <option>VIUDO</option>
                     <option>DIVORCIADO</option>
                     <option>OTROS</option>
                   </select>
                 </strong></strong></span></span></span></td>
                 <td width="85" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="180" scope="col"><div align="right"><span class="Estilo5">FECHA INGRESO :</span></div></td>
                 <td width="272" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong><strong><strong>
                     <input name="txtFecha" type="text" id="txtFecha" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                     <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario3')"  /> </strong></strong> </strong></strong></span></span> </span></div></td>
                 <td width="57" scope="col"><span class="Estilo5">HASTA :</span></td>
                 <td width="376" scope="col"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong>
                   <input name="txtFechax" type="text" id="txtFechax" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                   <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario4')"  /> </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="906">
               <tr>
                 <td width="176" scope="col"><div align="right"><span class="Estilo5">ESTATUS :</span></div></td>
                 <td width="718" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                     <select name="select3">
                       <option>ACTIVO</option>
                       <option>A&Ntilde;O SABATICO</option>
                       <option>DESPEDIDO</option>
                       <option>FALLECIDO</option>
                       <option>INACTIVO</option>
                       <option>JUBILADO</option>
                       <option>PERMISO RE</option>
                       <option>PERMISO NO</option>
                       <option>PENSIONADO</option>
                       <option>REPOSO</option>
                       <option>RENUNCIA</option>
                       <option>RETIRADO</option>
                       <option>SUSPENDIDO</option>
                       <option>VACACIONES</option>
                       <option>TODOS</option>
                       <option>ACTIVO/VACACIONES/PERMISO</option>
                     </select>
                 </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="178" scope="col"><div align="right"><span class="Estilo5">C&Oacute;DIGO CARGO DESDE :</span></div></td>
                 <td width="91" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcodigo_cargo_d" type="text" id="txtcodigo_cargo_d3" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="178" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo10" type="button" id="Catalogo103" title="Abrir Catalogo Tipos de n&oacute;minas" onClick="VentanaCentrada('../Cat_cargos_d.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
                 <td width="57" scope="col"><span class="Estilo5">HASTA :</span></td>
                 <td width="93" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcodigo_cargo_h" type="text" id="txtcodigo_cargo_h3" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12">
                   <span class="menu"><strong><strong> </strong></strong></span></span></span></td>
                 <td width="280" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo7" type="button" id="Catalogo73" title="Abrir Catalogo Tipos de n&oacute;minas" onClick="VentanaCentrada('../Cat_cargos_h.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="177" scope="col"><div align="right"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO :</span></div></td>
                 <td width="174" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcodigo_departamento_d" type="text" id="txtcodigo_departamento_d2" onFocus="encender(this)" onBlur="apagar(this)" size="25" maxlength="25">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="95" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo8" type="button" id="Catalogo83" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamento_d.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
                 <td width="56" scope="col"><span class="Estilo5">HASTA :</span></td>
                 <td width="174" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcodigo_departamento_h" type="text" id="txtcodigo_departamento_h2" onFocus="encender(this)" onBlur="apagar(this)" size="25" maxlength="25">
                   <span class="menu"><strong><strong> </strong></strong></span></span></span></td>
                 <td width="201" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo9" type="button" id="Catalogo92" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamento_h.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <th width="446" scope="col"><div align="center">
                     <input name="btgenera2" type="button" id="btgenera211" value="GENERAR" onClick="javascript:Llama_Rpt_ho_vida_mp('Rpt_ho_vida_mp.php');">
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
