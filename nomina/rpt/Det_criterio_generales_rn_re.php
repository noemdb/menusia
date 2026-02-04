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
<title>SIPAP N&Oacute;MINA Y PERSONAL (Reportes Detalles de los Criterios)</title>
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
.Estilo10 {font-size: 12px}
.Estilo12 {font-size: 10px; font-weight: bold; }
.Estilo13 {
	font-size: 12px;
	font-weight: bold;
	color: #0000FF;
}
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
<?  $nombre_d="";
    $nombre_h="";
$sql="SELECT MAX(cod_empleado) As Max_cod_empleado, MIN(cod_empleado) As Min_cod_empleado FROM nom006 ";
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
$sql="SELECT MAX(cedula) As Max_cedula, MIN(cedula) As Min_cedula FROM nom006 ";
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
<?  $denominacion_d="";
 $denominacion_d="";
$sql="SELECT MAX(TIPOPERSNAL_cargo) As Max_codigo_cargo, MIN(codigo_cargo) As Min_codigo_cargo FROM nom004 ";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{
  $encontro=false;
}
if($encontro=true){
  $codigo_cargo_d=$registro["min_codigo_cargo"];
  $codigo_cargo_h=$registro["max_codigo_cargo"];   }
?>

<body>
<div id="Layer1" style="position:absolute; width:889px; height:460px; z-index:1; top: 6px; left: 9px;">
  <table width="865" border="0" align="center" >
    <tr>
      <td><table width="898">
        <tr>
          <td width="214" scope="col"><div align="left"></div></td>
          <td width="390" scope="col"><div align="left"><span class="Estilo12">DESDE</span></div></td>
          <td width="111" scope="col"><div align="left"><span class="Estilo12">HASTA</span></div></td>
          <td width="163" scope="col">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td width="847"><table width="882">
          <tr>
            <td width="156" height="26" scope="col"><div align="left"><span class="Estilo5">TIPO DE N&Oacute;MINA </span></div></td>
            <td width="16" scope="col"><span class="Estilo5">:</span></td>
            <td width="26" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                <input name="txttipo_nomina_d" type="text" id="txttipo_nomina_d5" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2">
                <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
            <td width="327" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <input name="Catalogo1" type="button" id="Catalogo12" title="Abrir Catalogo Tipos de n&oacute;minas" onClick="VentanaCentrada('../Cat_tipo_nomina_d.php?criterio=','SIA','','650','500','true')" value="...">
            </strong></strong></span></span></span></td>
            <td width="35" scope="col"><span class="Estilo5"><span class="Estilo10">
              <input name="txttipo_nomina_h" type="text" id="txttipo_nomina_h3" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2">
              <span class="menu"><strong><strong> <strong><strong> </strong></strong> </strong></strong></span></span></span></td>
            <td width="255" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong>
              <input name="Catalogo2" type="button" id="Catalogo23" title="Abrir Catalogo Tipos de n&oacute;minas" onClick="VentanaCentrada('../Cat_tipo_nomina_h.php?criterio=','SIA','','650','500','true')" value="...">
            </strong></strong></strong></strong> </strong></strong></strong></strong></span></span></span></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="34"><table width="885">
          <tr>
            <td width="157" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR </span></div></td>
            <td width="15" scope="col"><span class="Estilo5">:</span></td>
            <td width="137" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                <input name="txtcod_empleado_d" type="text" id="txtcod_empleado_d3" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="15">
                <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
            <td width="253" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <input name="Catalogo32" type="button" id="Catalogo33" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('../Cat_trabajadoresd.php?criterio=','SIA','','650','500','true')" value="...">
            </strong></strong></span></span></span></td>
            <td width="137" scope="col"><span class="Estilo5"><span class="Estilo10">
              <input name="txtcod_empleado_h" type="text" id="txtcod_empleado_h3" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="20">
              <span class="menu"><strong><strong> </strong></strong></span></span></span></td>
            <td width="158" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <input name="Catalogo42" type="button" id="Catalogo43" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('../Cat_trabajadoresh.php?criterio=','SIA','','650','500','true')" value="...">
            </strong></strong></span></span></span></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="889">
          <tr>
            <td width="157" scope="col"><div align="left"><span class="Estilo5">C&Eacute;DULA </span></div></td>
            <td width="13" scope="col"><span class="Estilo5">:</span></td>
            <td width="92" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                <input name="txtcedula_d" type="text" id="txtcedula_d4" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12">
                <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
            <td width="298" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <input name="Catalogo52" type="button" id="Catalogo55" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_cedula_re_d.php?criterio=','SIA','','650','500','true')" value="...">
            </strong></strong></span></span></span></td>
            <td width="92" scope="col"><span class="Estilo5"><span class="Estilo10">
              <input name="txtcedula_h" type="text" id="txtcedula_h2" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12">
              <span class="menu"><strong><strong> </strong></strong></span></span></span></td>
            <td width="209" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <input name="Catalogo62" type="button" id="Catalogo64" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_cedula_re_h.php?criterio=','SIA','','650','500','true')" value="...">
            </strong></strong></span></span></span></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="886">
          <tr>
            <td width="157" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO CARGO DESDE </span></div></td>
            <td width="14" scope="col"><span class="Estilo5">:</span></td>
            <td width="91" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                <input name="txtcodigo_cargo_d" type="text" id="txtcodigo_cargo_d3" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12">
                <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
            <td width="302" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <input name="Catalogo10" type="button" id="Catalogo103" title="Abrir Catalogo Tipos de n&oacute;minas" onClick="VentanaCentrada('../Cat_cargos_d.php?criterio=','SIA','','650','500','true')" value="...">
            </strong></strong></span></span></span></td>
            <td width="87" scope="col"><span class="Estilo5"><span class="Estilo10">
              <input name="txtcodigo_cargo_h" type="text" id="txtcodigo_cargo_h3" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12">
              <span class="menu"><strong><strong> </strong></strong></span></span></span></td>
            <td width="207" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <input name="Catalogo7" type="button" id="Catalogo73" title="Abrir Catalogo Tipos de n&oacute;minas" onClick="VentanaCentrada('../Cat_cargos_h.php?criterio=','SIA','','650','500','true')" value="...">
            </strong></strong></span></span></span></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="20"><table width="886">
          <tr>
            <td width="157" scope="col"><div align="left"><span class="Estilo5">C&Oacute;DIGO DEPARTAMENTO </span></div></td>
            <td width="13" scope="col"><span class="Estilo5">:</span></td>
            <td width="172" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                <input name="txtcodigo_departamento_d" type="text" id="txtcodigo_departamento_d" onFocus="encender(this)" onBlur="apagar(this)" size="25" maxlength="25">
                <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
            <td width="211" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <input name="Catalogo8" type="button" id="Catalogo83" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamento_d.php?criterio=','SIA','','650','500','true')" value="...">
            </strong></strong></span></span></span></td>
            <td width="179" scope="col"><span class="Estilo5"><span class="Estilo10">
              <input name="txtcodigo_departamento_h" type="text" id="txtcodigo_departamento_h2" onFocus="encender(this)" onBlur="apagar(this)" size="25" maxlength="25">
              <span class="menu"><strong><strong> </strong></strong></span></span></span></td>
            <td width="126" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <input name="Catalogo9" type="button" id="Catalogo92" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamento_h.php?criterio=','SIA','','650','500','true')" value="...">
            </strong></strong></span></span></span></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="886">
          <tr>
            <td width="157" scope="col"><div align="left"><span class="Estilo5">TIPO PERSONAL</span></div></td>
            <td width="14" scope="col"><span class="Estilo5">:</span></td>
            <td width="172" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                <input name="txtcodigo_departamento_d2" type="text" id="txtcodigo_departamento_d3" onFocus="encender(this)" onBlur="apagar(this)" size="25" maxlength="25">
                <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
            <td width="209" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <input name="Catalogo82" type="button" id="Catalogo8" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamento_d.php?criterio=','SIA','','650','500','true')" value="...">
            </strong></strong></span></span></span></td>
            <td width="181" scope="col"><span class="Estilo5"><span class="Estilo10">
              <input name="txtcodigo_departamento_h2" type="text" id="txtcodigo_departamento_h3" onFocus="encender(this)" onBlur="apagar(this)" size="25" maxlength="25">
              <span class="menu"><strong><strong> </strong></strong></span></span></span></td>
            <td width="125" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <input name="Catalogo92" type="button" id="Catalogo9" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamento_h.php?criterio=','SIA','','650','500','true')" value="...">
            </strong></strong></span></span></span></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="881" border="0">
          <tr>
            <td width="158" class="Estilo5">
              <div align="left">CATEGORIA DESDE</div></td>
            <td width="12" class="Estilo5">:</td>
            <td width="142" class="Estilo5">
              <input name="txtcod_presup_d" type="text" id="txtcod_presup_d" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="20">
            </td>
            <td width="242" class="Estilo5">
              <input name="Catalogo93" type="button" id="Catalogo94" title="Abrir Catalogo de Categorias" onClick="VentanaCentrada('../Cat_codigos_catd.php?criterio=','SIA','','750','500','true')" value="...">
            </td>
            <td width="147" class="Estilo5">
              <input name="txtcod_presup_h" type="text" id="txtcod_presup_h" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="20">
            </td>
            <td width="154"><span class="Estilo5">
              <input name="Catalogo102" type="button" id="Catalogo10" title="Abrir Catalogo de Categorias" onClick="VentanaCentrada('../Cat_codigos_cath.php?criterio=','SIA','','750','500','true')" value="...">
            </span></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="888">
          <tr>
            <td width="157" scope="col"><div align="left"><span class="Estilo5">FECHA NACIMIENTO DESDE </span></div></td>
            <td width="12" scope="col"><span class="Estilo5">:</span></td>
            <td width="387" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong>
                <input name="txtFechad" type="text" id="txtFechad2" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                <strong><strong><strong><strong><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span> </span></div></td>
            <td width="312" scope="col"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong>
              <input name="txtFechah" type="text" id="txtFechah2" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
              <strong><strong><strong><strong><strong><strong><strong><strong><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span></span></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="888">
          <tr>
            <td width="158" scope="col"><div align="left"><span class="Estilo5">FECHA INGRESO DESDE </span></div></td>
            <td width="10" scope="col"><span class="Estilo5">:</span></td>
            <td width="388" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong>
                <input name="txtFechad2" type="text" id="txtFechad3" onFocus="encender(this)" onBlur="apagar(this)" value="OJO" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                <strong><strong><strong><strong><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span> </span></div></td>
            <td width="312" scope="col"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong>
              <input name="txtFechah2" type="text" id="txtFechah3" onFocus="encender(this)" onBlur="apagar(this)" value="OJO" size="12" maxlength="10" onChange="checkrefechah(this.form)">
              <strong><strong><strong><strong><strong><strong><strong><strong><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span></span></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="889">
          <tr>
            <td width="160" scope="col"><div align="left"><span class="Estilo5">FECHA EGRESO DESDE </span></div></td>
            <td width="10" scope="col"><span class="Estilo5">:</span></td>
            <td width="387" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong>
                <input name="txtFechad22" type="text" id="txtFechad22" onFocus="encender(this)" onBlur="apagar(this)" value="OJO" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                <strong><strong><strong><strong><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span> </span></div></td>
            <td width="312" scope="col"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong>
              <input name="txtFechah22" type="text" id="txtFechah22" onFocus="encender(this)" onBlur="apagar(this)" value="OJO" size="12" maxlength="10" onChange="checkrefechah(this.form)">
              <strong><strong><strong><strong><strong><strong><strong><strong><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span></span></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="890">
          <tr>
            <td width="176" scope="col"><div align="left"><span class="Estilo5">FECHA FIN CONTRATO DESDE : </span></div></td>
            <td width="385" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong>
                <input name="txtFechad23" type="text" id="txtFechad23" onFocus="encender(this)" onBlur="apagar(this)" value="OJO" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                <strong><strong><strong><strong><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span> </span></div></td>
            <td width="313" scope="col"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong>
              <input name="txtFechah23" type="text" id="txtFechah23" onFocus="encender(this)" onBlur="apagar(this)" value="OJO" size="12" maxlength="10" onChange="checkrefechah(this.form)">
              <strong><strong><strong><strong><strong><strong><strong><strong><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span></span></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="886" border="0">
          <tr>
            <td width="162" class="Estilo5">
              <div align="left">EDAD DESDE </div></td>
            <td width="13" class="Estilo5">:</td>
            <td width="383"><span class="Estilo5"><span class="Estilo10">
              <input name="txtcant_vence_fact225322222333" type="text" id="txtcant_vence_fact225322222332" size="02" maxlength="02"  onFocus="encender(this)" onBlur="apagar(this)">
            </span></span></td>
            <td width="310"><span class="Estilo5"><span class="Estilo10">
              <input name="txtcant_vence_fact2253222223322" type="text" id="txtcant_vence_fact2253222223322" size="02" maxlength="02"  onFocus="encender(this)" onBlur="apagar(this)">
            </span></span></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="890">
          <tr>
            <td width="44" scope="col"><div align="left"><span class="Estilo5">SEXO : </span></div></td>
            <td width="208" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                <select name="select2">
                  <option>TODOS</option>
                  <option>MASCULINO</option>
                  <option>FEMENINO</option>
                </select>
            </strong></strong></span></span> </span></div></td>
            <td width="98" scope="col"><span class="Estilo5">ESTADO CIVIL :</span></td>
            <td width="191" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <select name="select3">
                <option>TODOS</option>
                <option>SOLTERO</option>
                <option>CASADO</option>
                <option>VIUDO</option>
                <option>DIVORCIADO</option>
                <option>OTROS</option>
              </select>
            </strong></strong></span></span></span></td>
            <td width="68" scope="col"><span class="Estilo5">ESTATUS :</span></td>
            <td width="253" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <select name="select4">
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
            </strong></strong></span></span></span></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<? pg_close();?>
