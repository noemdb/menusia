<?include ("../../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA NÓMINA Y PERSONAL (Reportes De Listado De Trabajadores)</title>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE LISTADO DE TRABAJADORES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="2636" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="2630"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
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
             <td><table width="898">
               <tr>
                 <td width="401" scope="col"><div align="left"></div></td>
                 <td width="141" scope="col"><div align="left"><span class="Estilo12">CRIT. GENERALES </span></div></td>
                 <td width="173" scope="col"><div align="left"></div></td>
                 <td width="163" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="898">
               <tr>
                 <td width="330" scope="col"><div align="left"></div></td>
                 <td width="166" scope="col"><div align="left"><span class="Estilo12">DESDE</span></div></td>
                 <td width="219" scope="col"><div align="left"><span class="Estilo12">HASTA</span></div></td>
                 <td width="163" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="324" scope="col"><div align="right"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></div></td>
                 <td width="175" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcant_vence_fact2253222226" type="text" id="txtcant_vence_fact22532222262" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224223224" type="button" id="bttipo_codeingre2242232242" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="390" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcant_vence_fact22532222223" type="text" id="txtcant_vence_fact225322222232" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                   <span class="menu"><strong><strong>
                   <input name="bttipo_codeingre2242232223" type="button" id="bttipo_codeingre22422322232" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="296" scope="col"><div align="right"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR :</span></div></td>
                 <td width="177" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcant_vence_fact2253222223" type="text" id="txtcant_vence_fact22532222235" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224223223" type="button" id="bttipo_codeingre2242232235" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="416" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcant_vence_fact22532222222" type="text" id="txtcant_vence_fact225322222225" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                   <span class="menu"><strong><strong>
                   <input name="bttipo_codeingre2242232222" type="button" id="bttipo_codeingre22422322225" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="298" scope="col"><div align="right"><span class="Estilo5">C&Eacute;DULA TRABAJADOR :</span></div></td>
                 <td width="176" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcant_vence_fact22532222232" type="text" id="txtcant_vence_fact225322222323" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre2242232232" type="button" id="bttipo_codeingre22422322323" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="415" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcant_vence_fact225322222222" type="text" id="txtcant_vence_fact2253222222223" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                   <span class="menu"><strong><strong>
                   <input name="bttipo_codeingre22422322222" type="button" id="bttipo_codeingre224223222223" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="906">
               <tr>
                 <td width="401" scope="col"><div align="right"><span class="Estilo5">SEXO :</span></div></td>
                 <td width="492" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                     <select name="select">
                       <option>TODOS</option>
                       <option>MASCULINO</option>
                       <option>FEMENINO</option>
                     </select>
                 </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="906">
               <tr>
                 <td width="401" scope="col"><div align="right"><span class="Estilo5">ESTADO CIVIL :</span></div></td>
                 <td width="492" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
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
                 <td width="298" scope="col"><div align="right"><span class="Estilo5">FECHA NACIMIENTO :</span></div></td>
                 <td width="176" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong><strong><strong>
                     <select name="select3">
                       <option>CALENDARIO</option>
                     </select>
                 </strong></strong> </strong></strong></span></span> </span></div></td>
                 <td width="415" scope="col"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong>
                   <select name="select4">
                     <option>CALENDARIO</option>
                   </select>
                 </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="319" scope="col"><div align="right"><span class="Estilo5">EDAD :</span></div></td>
                 <td width="177" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcant_vence_fact2253222224" type="text" id="txtcant_vence_fact22532222245" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="393" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcant_vence_fact2253222225" type="text" id="txtcant_vence_fact22532222255" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                   <span class="menu"><strong><strong> </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="298" scope="col"><div align="right"><span class="Estilo5">FECHA DE INGRESO :</span></div></td>
                 <td width="176" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong><strong><strong>
                     <select name="select5">
                       <option>CALENDARIO</option>
                     </select>
                 </strong></strong> </strong></strong></span></span> </span></div></td>
                 <td width="415" scope="col"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong>
                   <select name="select5">
                     <option>CALENDARIO</option>
                   </select>
                 </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="906">
               <tr>
                 <td width="379" scope="col"><div align="right"><span class="Estilo5">ESTATUS :</span></div></td>
                 <td width="515" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                     <select name="select6">
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
                 <td width="296" scope="col"><div align="right"><span class="Estilo5">C&Oacute;DIGO CARGO :</span></div></td>
                 <td width="177" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcant_vence_fact225322222332" type="text" id="txtcant_vence_fact2253222223326" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422322332" type="button" id="bttipo_codeingre224223223326" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="416" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcant_vence_fact2253222222232" type="text" id="txtcant_vence_fact22532222222326" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                   <span class="menu"><strong><strong>
                   <input name="bttipo_codeingre224223222232" type="button" id="bttipo_codeingre2242232222326" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="296" scope="col"><div align="right"><span class="Estilo5">C&Oacute;DIGO DPTO. :</span></div></td>
                 <td width="177" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcant_vence_fact225322222333" type="text" id="txtcant_vence_fact2253222223338" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422322333" type="button" id="bttipo_codeingre224223223338" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="416" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcant_vence_fact2253222222233" type="text" id="txtcant_vence_fact22532222222338" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                   <span class="menu"><strong><strong>
                   <input name="bttipo_codeingre224223222233" type="button" id="bttipo_codeingre2242232222338" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="296" scope="col"><div align="right"><span class="Estilo5">TIPO PERSONAL :</span></div></td>
                 <td width="177" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcant_vence_fact2253222223332" type="text" id="txtcant_vence_fact22532222233324" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224223223332" type="button" id="bttipo_codeingre2242232233324" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="416" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcant_vence_fact22532222222332" type="text" id="txtcant_vence_fact225322222223324" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                   <span class="menu"><strong><strong>
                   <input name="bttipo_codeingre2242232222332" type="button" id="bttipo_codeingre22422322223324" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="298" scope="col"><div align="right"><span class="Estilo5">FECHA DE EGRESO :</span></div></td>
                 <td width="176" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong><strong><strong>
                     <select name="select8">
                       <option>CALENDARIO</option>
                     </select>
                 </strong></strong> </strong></strong></span></span> </span></div></td>
                 <td width="415" scope="col"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong>
                   <select name="select8">
                     <option>CALENDARIO</option>
                   </select>
                 </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="296" scope="col"><div align="right"><span class="Estilo5">C&Oacute;DIGO CATEGORIA :</span></div></td>
                 <td width="177" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcant_vence_fact2253222223333" type="text" id="txtcant_vence_fact22532222233332" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre224223223333" type="button" id="bttipo_codeingre2242232233332" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="416" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcant_vence_fact22532222222333" type="text" id="txtcant_vence_fact225322222223332" size="15" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)">
                   <span class="menu"><strong><strong>
                   <input name="bttipo_codeingre2242232222333" type="button" id="bttipo_codeingre22422322223332" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="298" scope="col"><div align="right"><span class="Estilo5">FECHA FIN DE CONTRATO :</span></div></td>
                 <td width="176" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong><strong><strong>
                     <select name="select7">
                       <option>CALENDARIO</option>
                     </select>
                 </strong></strong> </strong></strong></span></span> </span></div></td>
                 <td width="415" scope="col"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong>
                   <select name="select7">
                     <option>CALENDARIO</option>
                   </select>
                 </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="898">
               <tr>
                 <td width="318" height="15" scope="col"><div align="left"></div></td>
                 <td width="356" scope="col"><div align="left"><span class="Estilo12">MOSTRAR INFORMACI&Oacute;N ORDENADO POR </span></div></td>
                 <td width="41" scope="col"><div align="left"></div></td>
                 <td width="163" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="400" scope="col"><div align="right"><span class="Estilo5">
                     <input type="checkbox" name="checkbox202" value="checkbox">
        C&Oacute;DIGO</span></div></td>
                 <td width="74" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox212" value="checkbox">
        C&Eacute;DULA</span></div></td>
                 <td width="416" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox222" value="checkbox">
      NOMBRE</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="361" scope="col"><div align="right"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2022" value="checkbox">
        COLUMNA 1 </span></div></td>
                 <td width="95" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2122" value="checkbox">
        COLUMNA 2 </span></div></td>
                 <td width="99" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2222" value="checkbox">
      COLUMNA 3 </span></td>
                 <td width="333" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox22222" value="checkbox">
      COLUMNA 4 </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="898">
               <tr>
                 <td width="401" scope="col"><div align="left"></div></td>
                 <td width="141" scope="col"><div align="left"><span class="Estilo12">CAMPOS COL. 1</span></div></td>
                 <td width="173" scope="col"><div align="left"></div></td>
                 <td width="163" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="233" scope="col"><div align="right"></div></td>
                 <td width="181" scope="col"><div align="left"><span class="Estilo5">
                 <input type="checkbox" name="checkbox2023" value="checkbox">
C&Eacute;DULA</span></div></td>
                 <td width="85" scope="col">&nbsp;</td>
                 <td width="389" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox2123" value="checkbox">
PROFESI&Oacute;N</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="213" scope="col"><div align="left"><span class="Estilo5">
                 <input type="checkbox" name="checkbox20232" value="checkbox">
NACIONALIDAD</span></div></td>
                 <td width="51" scope="col">&nbsp;</td>
                 <td width="390" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox21232" value="checkbox">
GRADO DE INSTRUCCI&Oacute;N </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="233" scope="col"><div align="right"></div></td>
                 <td width="221" scope="col"><div align="left"><span class="Estilo5">
                 <input type="checkbox" name="checkbox20233" value="checkbox">
FECHA DE INGRESO </span></div></td>
                 <td width="46" scope="col">&nbsp;</td>
                 <td width="388" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox21233" value="checkbox">
C&Oacute;DIGO DE CARGO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="143" scope="col"><div align="right"></div></td>
                 <td width="87" scope="col"><div align="left"></div></td>
                 <td width="269" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox20234" value="checkbox">
TIPO DE N&Oacute;MINA </span></td>
                 <td width="389" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox21234" value="checkbox">
C&Oacute;DIGO DEL DEPARTAMENTO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="133" scope="col"><div align="right"></div></td>
                 <td width="97" scope="col"><div align="left"></div></td>
                 <td width="271" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox202342" value="checkbox">
C&Oacute;DIGO CATEGORIA </span></td>
                 <td width="387" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox212342" value="checkbox">
DESCRPCI&Oacute;N DEL DEPARTAMENTO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="230" scope="col"><div align="left"><span class="Estilo5">
                 <input type="checkbox" name="checkbox202343" value="checkbox">
TIPO DE PAGO</span></div></td>
                 <td width="35" scope="col">&nbsp;</td>
                 <td width="388" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox212343" value="checkbox">
FECHA DE ASIGNACI&Oacute;N </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="245" scope="col"><div align="left"><span class="Estilo5">
                 <input type="checkbox" name="checkbox202344" value="checkbox">
CUENTA DEL TRABAJADOR </span></div></td>
                 <td width="23" scope="col">&nbsp;</td>
                 <td width="386" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox212344" value="checkbox">
SUELDO DEL CARGO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="234" scope="col"><div align="left"><span class="Estilo5">
                 <input type="checkbox" name="checkbox20235" value="checkbox">
CUENTA DE LA EMPRESA </span></div></td>
                 <td width="32" scope="col">&nbsp;</td>
                 <td width="387" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox21235" value="checkbox">
COMPESACI&Oacute;N DEL CARGO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="233" scope="col"><div align="right"></div></td>
                 <td width="218" scope="col"><div align="left"><span class="Estilo5">
                 <input type="checkbox" name="checkbox20236" value="checkbox">
SEXO</span></div></td>
                 <td width="53" scope="col">&nbsp;</td>
                 <td width="384" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox21236" value="checkbox">
SUELDO + COMPENSACI&Oacute;N </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="231" scope="col"><div align="left"><span class="Estilo5">
                 <input type="checkbox" name="checkbox20237" value="checkbox">
ESTADO CIVIL </span></div></td>
                 <td width="37" scope="col">&nbsp;</td>
                 <td width="386" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox21237" value="checkbox">
GRADO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="237" scope="col"><div align="left"><span class="Estilo5">
                 <input type="checkbox" name="checkbox20238" value="checkbox">
FECHA DE NACIMIENTO </span></div></td>
                 <td width="34" scope="col">&nbsp;</td>
                 <td width="383" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox21238" value="checkbox">
PASO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="172" scope="col"><div align="left"><span class="Estilo5">
                 <input type="checkbox" name="checkbox20239" value="checkbox">
EDAD</span></div></td>
                 <td width="97" scope="col">&nbsp;</td>
                 <td width="384" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox21239" value="checkbox">
TIPO DE PERSONAL </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="191" scope="col"><div align="left"><span class="Estilo5">
                 <input type="checkbox" name="checkbox202310" value="checkbox">
DIRECCI&Oacute;N</span></div></td>
                 <td width="79" scope="col">&nbsp;</td>
                 <td width="383" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox212310" value="checkbox">
DESCRIPCI&Oacute;N TIPO DE PERSONA</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="236" scope="col"><div align="right"></div></td>
                 <td width="206" scope="col"><div align="left"><span class="Estilo5">
                 <input type="checkbox" name="checkbox202311" value="checkbox">
E-MAIL</span></div></td>
                 <td width="62" scope="col">&nbsp;</td>
                 <td width="384" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox212311" value="checkbox">
FECHA INGRESO ADM. PUBLICA </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="138" scope="col"><div align="right"></div></td>
                 <td width="238" scope="col"><div align="left"></div></td>
                 <td width="270" scope="col"><span class="Estilo5">
                 <input type="checkbox" name="checkbox2123112" value="checkbox">
NINGUNO</span></td>
                 <td width="242" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="898">
               <tr>
                 <td width="401" scope="col"><div align="left"></div></td>
                 <td width="141" scope="col"><div align="left"><span class="Estilo12">CAMPOS COL. 2 </span></div></td>
                 <td width="173" scope="col"><div align="left"></div></td>
                 <td width="163" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="233" scope="col"><div align="right"></div></td>
                 <td width="181" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox202312" value="checkbox">
        C&Eacute;DULA</span></div></td>
                 <td width="85" scope="col">&nbsp;</td>
                 <td width="389" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212312" value="checkbox">
      PROFESI&Oacute;N</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="213" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox202322" value="checkbox">
        NACIONALIDAD</span></div></td>
                 <td width="51" scope="col">&nbsp;</td>
                 <td width="390" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212322" value="checkbox">
      GRADO DE INSTRUCCI&Oacute;N </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="233" scope="col"><div align="right"></div></td>
                 <td width="221" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox202332" value="checkbox">
        FECHA DE INGRESO </span></div></td>
                 <td width="46" scope="col">&nbsp;</td>
                 <td width="388" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212332" value="checkbox">
      C&Oacute;DIGO DE CARGO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="143" scope="col"><div align="right"></div></td>
                 <td width="87" scope="col"><div align="left"></div></td>
                 <td width="269" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox202345" value="checkbox">
      TIPO DE N&Oacute;MINA </span></td>
                 <td width="389" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212345" value="checkbox">
      C&Oacute;DIGO DEL DEPARTAMENTO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="133" scope="col"><div align="right"></div></td>
                 <td width="97" scope="col"><div align="left"></div></td>
                 <td width="271" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2023422" value="checkbox">
      C&Oacute;DIGO CATEGORIA </span></td>
                 <td width="387" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123422" value="checkbox">
      DESCRPCI&Oacute;N DEL DEPARTAMENTO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="230" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2023432" value="checkbox">
        TIPO DE PAGO</span></div></td>
                 <td width="35" scope="col">&nbsp;</td>
                 <td width="388" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123432" value="checkbox">
      FECHA DE ASIGNACI&Oacute;N </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="245" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2023442" value="checkbox">
        CUENTA DEL TRABAJADOR </span></div></td>
                 <td width="23" scope="col">&nbsp;</td>
                 <td width="386" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123442" value="checkbox">
      SUELDO DEL CARGO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="234" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox202352" value="checkbox">
        CUENTA DE LA EMPRESA </span></div></td>
                 <td width="32" scope="col">&nbsp;</td>
                 <td width="387" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212352" value="checkbox">
      COMPESACI&Oacute;N DEL CARGO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="233" scope="col"><div align="right"></div></td>
                 <td width="218" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox202362" value="checkbox">
        SEXO</span></div></td>
                 <td width="53" scope="col">&nbsp;</td>
                 <td width="384" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212362" value="checkbox">
      SUELDO + COMPENSACI&Oacute;N </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="231" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox202372" value="checkbox">
        ESTADO CIVIL </span></div></td>
                 <td width="37" scope="col">&nbsp;</td>
                 <td width="386" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212372" value="checkbox">
      GRADO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="237" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox202382" value="checkbox">
        FECHA DE NACIMIENTO </span></div></td>
                 <td width="34" scope="col">&nbsp;</td>
                 <td width="383" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212382" value="checkbox">
      PASO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="172" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox202392" value="checkbox">
        EDAD</span></div></td>
                 <td width="97" scope="col">&nbsp;</td>
                 <td width="384" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212392" value="checkbox">
      TIPO DE PERSONAL </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="191" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2023102" value="checkbox">
        DIRECCI&Oacute;N</span></div></td>
                 <td width="79" scope="col">&nbsp;</td>
                 <td width="383" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123102" value="checkbox">
      DESCRIPCI&Oacute;N TIPO DE PERSONA</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="236" scope="col"><div align="right"></div></td>
                 <td width="206" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2023112" value="checkbox">
        E-MAIL</span></div></td>
                 <td width="62" scope="col">&nbsp;</td>
                 <td width="384" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123113" value="checkbox">
      FECHA INGRESO ADM. PUBLICA </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="138" scope="col"><div align="right"></div></td>
                 <td width="238" scope="col"><div align="left"></div></td>
                 <td width="270" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21231122" value="checkbox">
      NINGUNO</span></td>
                 <td width="242" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="898">
               <tr>
                 <td width="401" scope="col"><div align="left"></div></td>
                 <td width="141" scope="col"><div align="left"><span class="Estilo12">CAMPOS COL. 3 </span></div></td>
                 <td width="173" scope="col"><div align="left"></div></td>
                 <td width="163" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="233" scope="col"><div align="right"></div></td>
                 <td width="181" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2023122" value="checkbox">
        C&Eacute;DULA</span></div></td>
                 <td width="85" scope="col">&nbsp;</td>
                 <td width="389" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123122" value="checkbox">
      PROFESI&Oacute;N</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="213" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2023222" value="checkbox">
        NACIONALIDAD</span></div></td>
                 <td width="51" scope="col">&nbsp;</td>
                 <td width="390" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123222" value="checkbox">
      GRADO DE INSTRUCCI&Oacute;N </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="233" scope="col"><div align="right"></div></td>
                 <td width="221" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2023322" value="checkbox">
        FECHA DE INGRESO </span></div></td>
                 <td width="46" scope="col">&nbsp;</td>
                 <td width="388" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123322" value="checkbox">
      C&Oacute;DIGO DE CARGO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="143" scope="col"><div align="right"></div></td>
                 <td width="87" scope="col"><div align="left"></div></td>
                 <td width="269" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2023452" value="checkbox">
      TIPO DE N&Oacute;MINA </span></td>
                 <td width="389" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123452" value="checkbox">
      C&Oacute;DIGO DEL DEPARTAMENTO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="133" scope="col"><div align="right"></div></td>
                 <td width="97" scope="col"><div align="left"></div></td>
                 <td width="271" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox20234222" value="checkbox">
      C&Oacute;DIGO CATEGORIA </span></td>
                 <td width="387" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21234222" value="checkbox">
      DESCRPCI&Oacute;N DEL DEPARTAMENTO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="230" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox20234322" value="checkbox">
        TIPO DE PAGO</span></div></td>
                 <td width="35" scope="col">&nbsp;</td>
                 <td width="388" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21234322" value="checkbox">
      FECHA DE ASIGNACI&Oacute;N </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="245" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox20234422" value="checkbox">
        CUENTA DEL TRABAJADOR </span></div></td>
                 <td width="23" scope="col">&nbsp;</td>
                 <td width="386" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21234422" value="checkbox">
      SUELDO DEL CARGO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="234" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2023522" value="checkbox">
        CUENTA DE LA EMPRESA </span></div></td>
                 <td width="32" scope="col">&nbsp;</td>
                 <td width="387" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123522" value="checkbox">
      COMPESACI&Oacute;N DEL CARGO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="233" scope="col"><div align="right"></div></td>
                 <td width="218" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2023622" value="checkbox">
        SEXO</span></div></td>
                 <td width="53" scope="col">&nbsp;</td>
                 <td width="384" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123622" value="checkbox">
      SUELDO + COMPENSACI&Oacute;N </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="231" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2023722" value="checkbox">
        ESTADO CIVIL </span></div></td>
                 <td width="37" scope="col">&nbsp;</td>
                 <td width="386" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123722" value="checkbox">
      GRADO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="237" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2023822" value="checkbox">
        FECHA DE NACIMIENTO </span></div></td>
                 <td width="34" scope="col">&nbsp;</td>
                 <td width="383" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123822" value="checkbox">
      PASO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="172" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox2023922" value="checkbox">
        EDAD</span></div></td>
                 <td width="97" scope="col">&nbsp;</td>
                 <td width="384" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox2123922" value="checkbox">
      TIPO DE PERSONAL </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="191" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox20231022" value="checkbox">
        DIRECCI&Oacute;N</span></div></td>
                 <td width="79" scope="col">&nbsp;</td>
                 <td width="383" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21231022" value="checkbox">
      DESCRIPCI&Oacute;N TIPO DE PERSONA</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="236" scope="col"><div align="right"></div></td>
                 <td width="206" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox20231122" value="checkbox">
        E-MAIL</span></div></td>
                 <td width="62" scope="col">&nbsp;</td>
                 <td width="384" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21231132" value="checkbox">
      FECHA INGRESO ADM. PUBLICA </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="138" scope="col"><div align="right"></div></td>
                 <td width="238" scope="col"><div align="left"></div></td>
                 <td width="270" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21231123" value="checkbox">
      NINGUNO</span></td>
                 <td width="242" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="898">
               <tr>
                 <td width="401" height="14" scope="col"><div align="left"></div></td>
                 <td width="141" scope="col"><div align="left"><span class="Estilo12">CAMPOS COL. 4 </span></div></td>
                 <td width="173" scope="col"><div align="left"></div></td>
                 <td width="163" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="233" scope="col"><div align="right"></div></td>
                 <td width="181" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox20231222" value="checkbox">
        C&Eacute;DULA</span></div></td>
                 <td width="85" scope="col">&nbsp;</td>
                 <td width="389" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21231222" value="checkbox">
      PROFESI&Oacute;N</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="213" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox20232222" value="checkbox">
        NACIONALIDAD</span></div></td>
                 <td width="51" scope="col">&nbsp;</td>
                 <td width="390" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21232222" value="checkbox">
      GRADO DE INSTRUCCI&Oacute;N </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="233" scope="col"><div align="right"></div></td>
                 <td width="221" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox20233222" value="checkbox">
        FECHA DE INGRESO </span></div></td>
                 <td width="46" scope="col">&nbsp;</td>
                 <td width="388" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21233222" value="checkbox">
      C&Oacute;DIGO DE CARGO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="143" scope="col"><div align="right"></div></td>
                 <td width="87" scope="col"><div align="left"></div></td>
                 <td width="269" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox20234522" value="checkbox">
      TIPO DE N&Oacute;MINA </span></td>
                 <td width="389" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21234522" value="checkbox">
      C&Oacute;DIGO DEL DEPARTAMENTO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="133" scope="col"><div align="right"></div></td>
                 <td width="97" scope="col"><div align="left"></div></td>
                 <td width="271" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox202342222" value="checkbox">
      C&Oacute;DIGO CATEGORIA </span></td>
                 <td width="387" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212342222" value="checkbox">
      DESCRPCI&Oacute;N DEL DEPARTAMENTO </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="230" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox202343222" value="checkbox">
        TIPO DE PAGO</span></div></td>
                 <td width="35" scope="col">&nbsp;</td>
                 <td width="388" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212343222" value="checkbox">
      FECHA DE ASIGNACI&Oacute;N </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="245" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox202344222" value="checkbox">
        CUENTA DEL TRABAJADOR </span></div></td>
                 <td width="23" scope="col">&nbsp;</td>
                 <td width="386" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212344222" value="checkbox">
      SUELDO DEL CARGO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="234" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox20235222" value="checkbox">
        CUENTA DE LA EMPRESA </span></div></td>
                 <td width="32" scope="col">&nbsp;</td>
                 <td width="387" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21235222" value="checkbox">
      COMPESACI&Oacute;N DEL CARGO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="233" scope="col"><div align="right"></div></td>
                 <td width="218" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox20236222" value="checkbox">
        SEXO</span></div></td>
                 <td width="53" scope="col">&nbsp;</td>
                 <td width="384" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21236222" value="checkbox">
      SUELDO + COMPENSACI&Oacute;N </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="231" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox20237222" value="checkbox">
        ESTADO CIVIL </span></div></td>
                 <td width="37" scope="col">&nbsp;</td>
                 <td width="386" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21237222" value="checkbox">
      GRADO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="234" scope="col"><div align="right"></div></td>
                 <td width="237" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox20238222" value="checkbox">
        FECHA DE NACIMIENTO </span></div></td>
                 <td width="34" scope="col">&nbsp;</td>
                 <td width="383" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21238222" value="checkbox">
      PASO</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="172" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox20239222" value="checkbox">
        EDAD</span></div></td>
                 <td width="97" scope="col">&nbsp;</td>
                 <td width="384" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox21239222" value="checkbox">
      TIPO DE PERSONAL </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="235" scope="col"><div align="right"></div></td>
                 <td width="191" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox202310222" value="checkbox">
        DIRECCI&Oacute;N</span></div></td>
                 <td width="79" scope="col">&nbsp;</td>
                 <td width="383" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212310222" value="checkbox">
      DESCRIPCI&Oacute;N TIPO DE PERSONA</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="236" scope="col"><div align="right"></div></td>
                 <td width="206" scope="col"><div align="left"><span class="Estilo5">
                     <input type="checkbox" name="checkbox202311222" value="checkbox">
        E-MAIL</span></div></td>
                 <td width="62" scope="col">&nbsp;</td>
                 <td width="384" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212311322" value="checkbox">
      FECHA INGRESO ADM. PUBLICA </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="908">
               <tr>
                 <td width="138" scope="col"><div align="right"></div></td>
                 <td width="238" scope="col"><div align="left"></div></td>
                 <td width="270" scope="col"><span class="Estilo5">
                   <input type="checkbox" name="checkbox212311232" value="checkbox">
      NINGUNO</span></td>
                 <td width="242" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <th width="446" scope="col"><div align="center">
                     <input name="btgenera2" type="button" id="btgenera210" value="GENERAR" onClick="javascript:Llama_Rpt_Diario_Gen('Rpt_Diario_Gen.php');">
                 </div></th>
                 <th width="447" scope="col"><input name="btcancelar2" type="button" id="btcancelar210" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu_repor_perso_re.php');"></th>
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