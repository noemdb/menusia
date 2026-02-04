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
.Estilo15 {font-size: 12px; font-weight: bold; color: #B1C3D9; }
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
<table width="834" height="165" border="0" id="tablacuerpo">
  <tr>
   <td width="922" height="161"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>      <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:821px; height:141px; z-index:1; top: 23px; left: 16px;">
         <table width="815" border="0" align="center" >
           <tr>
             <td width="847"><table width="814">
               <tr>
                 <td width="320" scope="col"><div align="left"></div></td>
                 <td width="453" scope="col"><div align="left"><span class="Estilo13">CRITERIOS</span></div></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="786">
               <tr>
                 <td width="212" scope="col"><div align="left"><span class="Estilo12">Mostrar Informaci&oacute;n Ordenado por :</span></div></td>
                 <td width="463" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                     <select name="select">
                       <option>C&Oacute;DIGO</option>
                       <option>C&Eacute;DULA</option>
                       <option>NOMBRE</option>
                       <option>COLUMNA1</option>
                       <option>COLUMNA2</option>
                       <option>COLUMNA3</option>
                       <option>COLUMNA4</option>
                     </select>
                 </strong></strong></span></span> </span></div></td>
                 <td width="95" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="809">
               <tr>
                 <td width="118" scope="col"><div align="left"><span class="Estilo12">Campos Col.  N&ordm;. 1 :</span></div></td>
                 <td width="291" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                     <select name="select3">
                       <option selected>C&Eacute;DULA</option>
                       <option>NACIONALIDAD</option>
                       <option>FECHA DE INGRESO</option>
                       <option>ESTATUS</option>
                       <option>TIPO DE N&Oacute;MINA</option>
                       <option>C&Oacute;DIGO CATEGORIA</option>
                       <option>TIPO DE PAGO</option>
                       <option>CTA. DEL TRABAJADOR</option>
                       <option>CTA. DE LA EMPRESA</option>
                       <option>SEXO</option>
                       <option>ESTADO CIVIL</option>
                       <option>FECHA DE NACIMIENTO </option>
                       <option>EDAD </option>
                       <option>DIRECCI&Oacute;N </option>
                       <option>TELEFONO</option>
                       <option>E-MAIL</option>
                       <option>PROFESI&Oacute;N</option>
                       <option>GRADO DE INSTRUCI&Oacute;N</option>
                       <option>C&Oacute;DIGO DEL CARGO</option>
                       <option>DESCRIPCI&Oacute;N DEL CARGO</option>
                       <option>C&Oacute;DIGO DEL DEPARTAMENTO</option>
                       <option>DESCRIPCI&Oacute;N DEL DEPARTAMENTO</option>
                       <option>FECHA DE ASIGNACI&Oacute;N</option>
                       <option>SUELDO DEL CARGO</option>
                       <option>COMPENSACI&Oacute;N DEL CARGO</option>
                       <option>SUELDO+COMPENSACI&Oacute;N</option>
                       <option>GRADO </option>
                       <option>PASO</option>
                       <option>TIPO DE PERSONAL</option>
                       <option>DESCRIPCI&Oacute;N DEL TIPO DE PERSONAL</option>
                       <option>FECHA DE EGRESO</option>
                       <option>FECHA DE INGRESO ADM. PUBLICA</option>
                       <option>NINGUNO</option>
                     </select>
                 </strong></strong></span></span> </span></div></td>
                 <td width="118" scope="col"><span class="Estilo12">Campos Col. N&ordm;. 2 :</span></td>
                 <td width="262" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <select name="select7">
                     <option>C&Eacute;DULA</option>
                     <option selected>NACIONALIDAD</option>
                     <option>FECHA DE INGRESO</option>
                     <option>ESTATUS</option>
                     <option>TIPO DE N&Oacute;MINA</option>
                     <option>C&Oacute;DIGO CATEGORIA</option>
                     <option>TIPO DE PAGO</option>
                     <option>CTA. DEL TRABAJADOR</option>
                     <option>CTA. DE LA EMPRESA</option>
                     <option>SEXO</option>
                     <option>ESTADO CIVIL</option>
                     <option>FECHA DE NACIMIENTO </option>
                     <option>EDAD </option>
                     <option>DIRECCI&Oacute;N </option>
                     <option>TELEFONO</option>
                     <option>E-MAIL</option>
                     <option>PROFESI&Oacute;N</option>
                     <option>GRADO DE INSTRUCI&Oacute;N</option>
                     <option>C&Oacute;DIGO DEL CARGO</option>
                     <option>DESCRIPCI&Oacute;N DEL CARGO</option>
                     <option>C&Oacute;DIGO DEL DEPARTAMENTO</option>
                     <option>DESCRIPCI&Oacute;N DEL DEPARTAMENTO</option>
                     <option>FECHA DE ASIGNACI&Oacute;N</option>
                     <option>SUELDO DEL CARGO</option>
                     <option>COMPENSACI&Oacute;N DEL CARGO</option>
                     <option>SUELDO+COMPENSACI&Oacute;N</option>
                     <option>GRADO </option>
                     <option>PASO</option>
                     <option>TIPO DE PERSONAL</option>
                     <option>DESCRIPCI&Oacute;N DEL TIPO DE PERSONAL</option>
                     <option>FECHA DE EGRESO</option>
                     <option>FECHA DE INGRESO ADM. PUBLICA</option>
                     <option>NINGUNO</option>
                      </select>
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="808">
               <tr>
                 <td width="118" scope="col"><div align="left"><span class="Estilo12">Campos Col. N&ordm;. 3 :</span></div></td>
                 <td width="293" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                     <select name="select2">
                       <option>C&Eacute;DULA</option>
                       <option>NACIONALIDAD</option>
                       <option selected>FECHA DE INGRESO</option>
                       <option>ESTATUS</option>
                       <option>TIPO DE N&Oacute;MINA</option>
                       <option>C&Oacute;DIGO CATEGORIA</option>
                       <option>TIPO DE PAGO</option>
                       <option>CTA. DEL TRABAJADOR</option>
                       <option>CTA. DE LA EMPRESA</option>
                       <option>SEXO</option>
                       <option>ESTADO CIVIL</option>
                       <option>FECHA DE NACIMIENTO </option>
                       <option>EDAD </option>
                       <option>DIRECCI&Oacute;N </option>
                       <option>TELEFONO</option>
                       <option>E-MAIL</option>
                       <option>PROFESI&Oacute;N</option>
                       <option>GRADO DE INSTRUCI&Oacute;N</option>
                       <option>C&Oacute;DIGO DEL CARGO</option>
                       <option>DESCRIPCI&Oacute;N DEL CARGO</option>
                       <option>C&Oacute;DIGO DEL DEPARTAMENTO</option>
                       <option>DESCRIPCI&Oacute;N DEL DEPARTAMENTO</option>
                       <option>FECHA DE ASIGNACI&Oacute;N</option>
                       <option>SUELDO DEL CARGO</option>
                       <option>COMPENSACI&Oacute;N DEL CARGO</option>
                       <option>SUELDO+COMPENSACI&Oacute;N</option>
                       <option>GRADO </option>
                       <option>PASO</option>
                       <option>TIPO DE PERSONAL</option>
                       <option>DESCRIPCI&Oacute;N DEL TIPO DE PERSONAL</option>
                       <option>FECHA DE EGRESO</option>
                       <option>FECHA DE INGRESO ADM. PUBLICA</option>
                       <option>NINGUNO</option>
                        </select>
                 </strong></strong></span></span> </span></div></td>
                 <td width="116" scope="col"><span class="Estilo12">Campos Col. N&ordm;. 4 :</span></td>
                 <td width="261" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <select name="select2">
                     <option>C&Eacute;DULA</option>
                     <option>NACIONALIDAD</option>
                     <option>FECHA DE INGRESO</option>
                     <option selected>ESTATUS</option>
                     <option>TIPO DE N&Oacute;MINA</option>
                     <option>C&Oacute;DIGO CATEGORIA</option>
                     <option>TIPO DE PAGO</option>
                     <option>CTA. DEL TRABAJADOR</option>
                     <option>CTA. DE LA EMPRESA</option>
                     <option>SEXO</option>
                     <option>ESTADO CIVIL</option>
                     <option>FECHA DE NACIMIENTO </option>
                     <option>EDAD </option>
                     <option>DIRECCI&Oacute;N </option>
                     <option>TELEFONO</option>
                     <option>E-MAIL</option>
                     <option>PROFESI&Oacute;N</option>
                     <option>GRADO DE INSTRUCI&Oacute;N</option>
                     <option>C&Oacute;DIGO DEL CARGO</option>
                     <option>DESCRIPCI&Oacute;N DEL CARGO</option>
                     <option>C&Oacute;DIGO DEL DEPARTAMENTO</option>
                     <option>DESCRIPCI&Oacute;N DEL DEPARTAMENTO</option>
                     <option>FECHA DE ASIGNACI&Oacute;N</option>
                     <option>SUELDO DEL CARGO</option>
                     <option>COMPENSACI&Oacute;N DEL CARGO</option>
                     <option>SUELDO+COMPENSACI&Oacute;N</option>
                     <option>GRADO </option>
                     <option>PASO</option>
                     <option>TIPO DE PERSONAL</option>
                     <option>DESCRIPCI&Oacute;N DEL TIPO DE PERSONAL</option>
                     <option>FECHA DE EGRESO</option>
                     <option>FECHA DE INGRESO ADM. PUBLICA</option>
                     <option>NINGUNO</option>
                      </select>
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
         </table>
        </div>
    </form>    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<? pg_close();?>
