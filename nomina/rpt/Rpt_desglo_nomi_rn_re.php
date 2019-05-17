<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
   $tipo_nomina_d="";
   $tipo_nomina_h="zzzz";
   ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Reportes De Desglose De N&oacute;mina)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_desglo_nomi_rn(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Desglose de Nomina?");
  if (r==true){url=murl+"?&tipo_nomina_d="+document.form1.txttipo_nomina_d.value+"&tipo_nomina_h="+document.form1.txttipo_nomina_h.value;
  window.open(url,"Reporte Desglose de Nomina")}
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
$descripcion_d=""; $descripcion_h="";
$sql="SELECT MAX(tipo_nomina) As Max_tipo_nomina, MIN(tipo_nomina) As Min_tipo_nomina FROM nom001 "; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_nomina_d=$registro["min_tipo_nomina"];$tipo_nomina_h=$registro["max_tipo_nomina"];   }
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_d=$registro["descripcion"];}
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_h=$registro["descripcion"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE DESGLOSE  DE N&Oacute;MINA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="245" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="239"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:504px; height:94px; z-index:1; top: 69px; left: 42px;">
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
                 <td width="61" align="center" class="Estilo5"><div align="left"></div></td>
                 <td width="134" align="center" class="Estilo5"><div align="left">TIPO N&Oacute;MINA DESDE :</div></td>
                 <td width="49" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txttipo_nomina_d" type="text" id="txttipo_nomina_d" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_d?>">
                 </span></div></td>
                 <td width="47" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo Tipos de nóminas" onClick="VentanaCentrada('../Cat_tipo_nominad.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="612" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_d" type="text" id="txtdescripcion_d" size="50" maxlength="100" readonly value="<?echo $descripcion_d?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="60" align="center" class="Estilo5"><div align="left"></div></td>
                 <td width="135" align="center" class="Estilo5"><div align="left">TIPO N&Oacute;MINA HASTA :</div></td>
                 <td width="49" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txttipo_nomina_h" type="text" id="txttipo_nomina_h" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_h?>">
                 </span></div></td>
                 <td width="46" align="center"><div align="left"><span class="Estilo5">
                     <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo Tipos de nóminas" onClick="VentanaCentrada('../Cat_tipo_nominah.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="613" align="center"><div align="left"><span class="Estilo5">
                     <input name="txtdescripcion_h" type="text" id="txtdescripcion_h" size="50" maxlength="100" readonly value="<?echo $descripcion_h?>">
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="898">
               <tr>
                 <td width="401" scope="col"><div align="left"></div></td>
                 <td width="141" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">TIPO DE C&Aacute;LCULO </span></span></span></div></td>
                 <td width="173" scope="col"><div align="left"></div></td>
                 <td width="163" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="904">
               <tr>
                 <td width="385" height="16" scope="col"><div align="right"> <span class="Estilo5">
                     </span></div></td>
                 <td width="507" scope="col"><div align="left"><span class="Estilo5">
                   <select name="select8" size="1" id="select8">
                     <option>NORMAL</option>
                     <option>EXTRAORDINARIA</option>
                   </select>
                     </span></div></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <th scope="col">&nbsp;</th>
                 <th scope="col">&nbsp;</th>
               </tr>
               <tr>
                 <th width="446" scope="col"><div align="center">
                     <input name="btgenera2" type="button" id="btgenera25" value="GENERAR" onClick="javascript:Llama_Rpt_desglo_nomi_rn('Rpt_desglo_nomi_rn.php');">
                 </div></th>
                 <th width="447" scope="col"><input name="btcancelar2" type="button" id="btcancelar25" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></th>
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
