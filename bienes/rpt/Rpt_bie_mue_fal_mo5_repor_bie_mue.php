<?include ("../../class/funciones.php");
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Reportes Bienes Muebles Faltante (Modelo 5))</title>
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
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE BIENES MUEBLES FALTANTES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="258" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="252"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:861px; height:141px; z-index:1; top: 93px; left: 14px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><div align="center">
               <table width="961">
                 <tr>
                   <td width="305" scope="col"><div align="right"><span class="Estilo12">CRITERIOS</span></div></td>
                   <td width="644" scope="col"><div align="left"><span class="Estilo5">                       <span class="Estilo10"><span class="menu"><strong><strong>                   </strong></strong></span></span> </span></div></td>
                 </tr>
               </table>
              </div></td>
           </tr>
           <tr>
             <td><table width="963">
               <tr>
                 <td width="323" scope="col"><div align="left"></div></td>
                 <td width="220" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">DESDE</span></span></span></div></td>
                 <td width="122" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="Estilo12">HASTA</span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="278" scope="col"><div align="left"><span class="Estilo5">                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="231" scope="col"><div align="right"><span class="Estilo5">COD. BIEN MUEBLE :</span></div></td>
                 <td width="258" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcode_ingre_mora22222" type="text" id="txtcode_ingre_mora22222" size="30" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                   <span class="menu"><strong><strong>
                   <input name="bttipo_codeingre22422222" type="button" id="bttipo_codeingre22422225" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                   </strong></strong></span> </span></span></div></td>
                 <td width="460" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="txtcode_ingre_mora222222" type="text" id="txtcode_ingre_mora2222222" size="30" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                   <strong><strong><strong><strong>
                   <input name="bttipo_codeingre224222222" type="button" id="bttipo_codeingre224222222" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                   </strong></strong></strong></strong> </strong></strong></span></span></span></div></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="310" scope="col"><div align="right"><span class="Estilo5">COD. DEPENEDNCIA :</span></div></td>
                 <td width="220" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcode_ingre_mora22222322" type="text" id="txtcode_ingre_mora2222232" size="10" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <span class="menu"><strong><strong>
                     <input name="bttipo_codeingre22422222322" type="button" id="bttipo_codeingre2242222232" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></span> </span></span></div></td>
                 <td width="419" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                     <input name="txtcode_ingre_mora222222222" type="text" id="txtcode_ingre_mora22222222" size="10" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" class="Estilo5">
                     <strong><strong><strong><strong>
                     <input name="bttipo_codeingre224222222222" type="button" id="bttipo_codeingre22422222222" title="Abrir Catalogo Tipos de Orden" onClick="VentanaCentrada('Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="...">
                 </strong></strong></strong></strong> </strong></strong></span></span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="294" scope="col"><div align="right"><span class="Estilo5">FECHA INCORPORACI&Oacute;N :</span></div></td>
                 <td width="224" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong>
                     <select name="select3">
                       <option>CALENDARIO</option>
                     </select>
                     <strong><strong><strong><strong><strong><strong> </strong></strong></strong></strong></strong></strong></strong></strong></span> </span></span></div></td>
                 <td width="431" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong> <strong><strong>
                     <select name="select3">
                       <option>CALENDARIO</option>
                     </select>
                 </strong></strong> <strong><strong><strong><strong> </strong></strong></strong></strong> </strong></strong></span></span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr align="center" valign="middle">
                 <td>
                   <div align="center">
                     <input name="btgenera2" type="button" id="btgenera7" value="GENERAR" onClick="javascript:Llama_Rpt_Diario_Gen('Rpt_Diario_Gen.php');">
                 </div></td>
                 <td>
                   <div align="center">
                     <input name="btcancelar2" type="button" id="btcancelar7" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu_repor_bie_mue.php');">
                 </div></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
       </div>
    </form>    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<? pg_close();?>
