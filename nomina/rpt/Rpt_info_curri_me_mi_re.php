<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$cod_empleado_d="";$cod_empleado_h="";$fecha_d="01/01/1900";$fecha_h="31/12/9999";
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Reportes nformacion Curricular de Elegibles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_info_curri_me_mi(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Informacion Curricular de Elegibles?");
  if (r==true){url=murl+"?&cod_empleado_d="+document.form1.txtcod_empleado_d.value+"&cod_empleado_h="+document.form1.txtcod_empleado_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value;
  window.open(url,"Reporte Informacion Personal de Elegibles")}
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
  <?  $nombre_d="";
      $nombre_h="";
$sql="SELECT MAX(cedula) As Max_cedula, MIN(cedula) As Min_cedula FROM nom006 ";
$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$encontro=true;}
else{
  $encontro=false;
}
if($encontro=true){
  $cedula_d=$registro["min_cedula"];
  $cedula_h=$registro["max_cedula"];   }
?>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE INFORMACION CURRICULAR DE ELEGIBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="288" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="282"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:504px; height:94px; z-index:1; top: 81px; left: 42px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><table width="898">
               <tr>
                 <td width="308" scope="col"><div align="left"></div></td>
                 <td width="234" scope="col"><div align="left"><span class="Estilo12">CRITERIOS</span></div></td>
                 <td width="173" scope="col"><div align="left"></div></td>
                 <td width="163" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="95" class="Estilo5" scope="col">CEDULA DESDE :</td>
                 <td width="90" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcedula_d" type="text" id="txtcod_empleado_d" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $cod_empleado_d?>">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="216" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo5" type="button" id="Catalogo55" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_trab_inf_curri_d.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
                 <td width="53" class="Estilo5" scope="col">HASTA : </td>
                 <td width="89" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcedula_h" type="text" id="txtcod_empleado_h" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $cod_empleado_h?>">
                   <span class="menu"><strong><strong> </strong></strong></span></span></span></td>
                 <td width="334" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo6" type="button" id="Catalogo64" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_trab_inf_curri_h.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="899" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="140" height="22" align="center"><div align="left">
                     <p align="left" class="Estilo5">FECHA TITULO DESDE : </p>
                 </div></td>
                 <td width="270" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                     <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
                 <td width="57" align="center"><div align="left" class="Estilo5">HASTA :</div></td>
                 <td width="432" align="center">
                   <div align="left"><span class="Estilo5">
                     <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                     <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="907">
               <tr>
                 <td width="58" scope="col"><div align="left"><span class="Estilo5">TITULO  :</span></div></td>
                 <td width="837" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                     <input name="txtcant_vence_fact2253222224" type="text" id="txtcant_vence_fact2253222222" size="130" maxlength="129"  onFocus="encender(this)" onBlur="apagar(this)">
                 </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="907">
               <tr>
                 <td width="76" scope="col"><div align="left"><span class="Estilo5">INSTITUTO  :</span></div></td>
                 <td width="819" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                     <input name="txtcant_vence_fact22532222242" type="text" id="txtcant_vence_fact22532222242" size="127" maxlength="129"  onFocus="encender(this)" onBlur="apagar(this)">
                 </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <th width="446" scope="col"><div align="center">
                     <input name="btgenera2" type="button" id="btgenera22" value="GENERAR" onClick="javascript:Llama_Rpt_info_curri_me_mi('Rpt_info_curri_me_mi.php');">
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
