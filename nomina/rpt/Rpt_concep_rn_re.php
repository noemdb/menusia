<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>SIPAP N&Oacute;MINA Y PERSONAL (Reportes De Relaci&oacute;n De Conceptos)</title>
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

</style>
</head>
<?  $descripcion_d="";
    $descripcion_h="zzzzzzzzzzzzzzz";
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
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE RELACI&Oacute;N DE CONCEPTOS </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="356" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="350"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
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
                 <td width="195" align="center" class="Estilo5"><div align="left">TIPO N&Oacute;MINA DESDE :</div></td>
                 <td width="49" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txttipo_nomina_d" type="text" id="txttipo_nomina_d2" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2">
                 </span></div></td>
                 <td width="47" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo1" type="button" id="Catalogo12" title="Abrir Catalogo Tipos de nóminas" onClick="VentanaCentrada('../Cat_tipo_nominad.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="612" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_d" type="text" id="txtdescripcion_d2" size="84" maxlength="84" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="195" align="center" class="Estilo5"><div align="left">TIPO N&Oacute;MINA HASTA :</div></td>
                 <td width="49" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txttipo_nomina_h" type="text" id="txttipo_nomina_h2" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2">
                 </span></div></td>
                 <td width="46" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo2" type="button" id="Catalogo22" title="Abrir Catalogo Tipos de nóminas" onClick="VentanaCentrada('../Cat_tipo_nominah.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="613" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_h" type="text" id="txtdescripcion_h2" size="84" maxlength="84" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="center" class="Estilo5"><div align="left">C&Oacute;DIGO DEPARTAMENTO DESDE :</div></td>
                 <td width="189" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtcodigo_departamento_d" type="text" id="txtcodigo_departamento_d" onFocus="encender(this)" onBlur="apagar(this)" size="25" maxlength="25">
                 </span></div></td>
                 <td width="48" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamentod.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="470" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_dep_d" type="text" id="txtdescripcion_dep_d" size="60" maxlength="60" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="center" class="Estilo5"><div align="left">C&Oacute;DIGO DEPARTAMENTO DESDE :</div></td>
                 <td width="190" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtcodigo_departamento_h" type="text" id="txtcodigo_departamento_h" onFocus="encender(this)" onBlur="apagar(this)" size="25" maxlength="25">
                 </span></div></td>
                 <td width="48" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamentoh.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="469" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_dep_h" type="text" id="txtdescripcion_dep_h" size="60" maxlength="60" readonly>
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="243" scope="col"><div align="right"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">TIPO DE C&Aacute;LCULO </span></span></span></div></td>
                 <td width="404" scope="col"><div align="center"><span class="Estilo12">IMPRIMIR FIRMA ULTIMA P&Aacute;GINA </span></div></td>
                 <td width="242" scope="col"><span class="Estilo12">CONCEPTO DE</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903">
               <tr>
                 <td width="119" height="16" scope="col"><div align="right"> <span class="Estilo5">
                     </span></div></td>
                 <td width="187" scope="col"><div align="left"><span class="Estilo5">
                   <select name="select8" size="1" id="select8">
                     <option>NORMAL</option>
                     <option>EXTRAORDINARIA</option>
                   </select>
                     </span></div></td>
                 <td width="96" scope="col"><span class="Estilo5">
                   </span></td>
                 <td width="119" scope="col"><span class="Estilo5">
                   <select name="select5" size="1" id="select5">
                     <option>SI</option>
                     <option>NO</option>
                   </select>
                   </span></td>
                 <td width="85" scope="col"><span class="Estilo5">
                   </span></td>
                 <td width="269" scope="col"><span class="Estilo5">
                   <select name="select" size="1" id="select">
                     <option>SOLO DE NOMINAS</option>
                     <option>SOLO DE VACACIONES</option>
                     <option>TODOS</option>
                   </select>
                   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="132" scope="col"><div align="right"></div></td>
                 <td width="519" scope="col"><div align="left"><span class="Estilo12">FORMA DE PAGO </span></div></td>
                 <td width="238" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">TIPO REPORTE</span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="139" scope="col"><div align="right"> <span class="Estilo5">
                     </span></div></td>
                 <td width="152" scope="col"><div align="left"><span class="Estilo5">
                   <select name="select2" size="1" id="select2">
                     <option>DEPOSITO</option>
                     <option>EFECTIVO</option>
                     <option>CHEQUE</option>
                     <option>RECIBO</option>
                     <option>TODOS</option>
                        </select>
                     </span></div></td>
                 <td width="160" scope="col"><span class="Estilo5">
                   </span></td>
                 <td width="81" scope="col">&nbsp;</td>
                 <td width="44" scope="col">&nbsp;</td>
                 <td width="51" scope="col"><span class="Estilo5">
                   </span></td>
                 <td width="246" scope="col"><span class="Estilo5">
                   <select name="select3" size="1" id="select3">
                     <option>N&Oacute;MINA </option>
                     <option>PRE-N&Oacute;MINA</option>
                   </select>
                   </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <th width="446" scope="col"><div align="center">
                     <input name="btgenera2" type="button" id="btgenera2" value="GENERAR" onClick="javascript:Llama_Rpt_Diario_Gen('Rpt_Diario_Gen.php');">
                 </div></th>
                 <th width="447" scope="col"><input name="btcancelar2" type="button" id="btcancelar2" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu_repor_nomi_re.php');"></th>
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
