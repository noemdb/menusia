<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$cedula_d="";$cedula_h="";$fecha_d="01/01/1900";$fecha_h="31/12/9999";$sexo="";$edad_d="0";$edad_h="99";$edo_civil="";
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Reportes Inf&oacute;rmacion Personal de Elegibles)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_info_ele_me_mi(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Informacion Personal de Elegibles?");
  if (r==true){url=murl+"?&cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+
  "&sexo="+document.form1.txt_sexo.value+"&edad_d="+document.form1.txtedad_d.value+"&edad_h="+document.form1.txtedad_h.value+"&edo_civil="+document.form1.txt_edocivil.value;
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
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE INFORMACI&Oacute;N DE ELEGIBLES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="270" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="264"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:504px; height:94px; z-index:1; top: 67px; left: 61px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td colspan="5"><table width="898">
               <tr>
                 <td width="345" scope="col"><div align="left"></div></td>
                 <td width="197" scope="col"><div align="left"><span class="Estilo12">CRITERIOS</span></div></td>
                 <td width="173" scope="col"><div align="left"></div></td>
                 <td width="163" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td colspan="5"><table width="905">
               <tr>
                 <td width="180" scope="col"><div align="right"><span class="Estilo5">CEDULA DESDE :</span></div></td>
                 <td width="94" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $cedula_d?>">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="159" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo5" type="button" id="Catalogo55" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_cedula_re_d.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
                 <td width="55" class="Estilo5" scope="col">HASTA : </td>
                 <td width="72" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $cedula_h?>">
                   <span class="menu"><strong><strong> </strong></strong></span></span></span></td>
                 <td width="317" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo6" type="button" id="Catalogo64" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_cedula_re_h.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td colspan="5"><table width="905">
               <tr>
                 <td width="182" scope="col"><div align="right"><span class="Estilo5">FECHA NACIMIENTO DESDE :</span></div></td>
                 <td width="257" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong>
                     <input name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                     <strong><strong><strong><strong><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span> </span></div></td>
                 <td width="53" scope="col"><span class="Estilo5">HASTA :</span></td>
                 <td width="393" scope="col"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong><strong><strong> <strong><strong><strong><strong> <strong><strong><strong><strong><strong><strong><strong><strong>
                   <input name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                   <strong><strong><strong><strong><strong><strong><strong><strong><img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /></strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong></strong></strong></strong></strong> </strong></strong></strong></strong> </strong></strong> </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td colspan="5"><table width="906">
               <tr>
                 <td width="180" scope="col"><div align="right"><span class="Estilo5">EDAD DESDE:</span></div></td>
                 <td width="262" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong>
                   <input name="txtedad_d" type="text" id="txtedad_d" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $edad_d?>">
                 </strong></strong></span></span> </span></div></td>
                 <td width="53" scope="col"><div align="left"><span class="Estilo5">HASTA :</span></div></td>
                 <td width="298" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="txtedad_h" type="text" id="txtedad_h" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $edad_h?>">
                 </strong></strong></span></span></span></td>
                 <td width="88" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td colspan="5"></td>
           </tr>
           <tr>
             <td colspan="5"></td>
           </tr>
           <tr>
             <td width="185"><div align="right"><span class="Estilo5">SEXO :</span></div></td>
             <td width="217"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
              <select name="txt_sexo">
                    <option value="TODOS">TODOS</option>
                    <option value="MASCULINO">MASCULINO</option>
                    <option value="FEMENINO">FEMENINO</option>
              </select>
             </strong></strong></span></span></span></td>
             <td width="97"><span class="Estilo5">ESTADO CIVIL :</span></td>
             <td width="369"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
               <select name="txt_edocivil">
                  <option value="TODOS">TODOS</option>
                  <option value="SOLTERO">SOLTERO</option>
                  <option value="CASADO">CASADO</option>
                  <option value="VIUDO">VIUDO</option>
                  <option value="DIVORCIADO">DIVORCIADO</option>
                  <option value="OTROS">OTROS</option>
                </select>
             </strong></strong></span></span></span></td>
             <td width="22">&nbsp;</td>
           </tr>
           <tr>
             <td colspan="5">&nbsp;</td>
           </tr>
           <tr>
             <td colspan="5"><table width="710">
               <tr>
                 <th width="446" scope="col"><div align="center">
                     <input name="btgenera2" type="button" id="btgenera22" value="GENERAR" onClick="javascript:Llama_Rpt_info_ele_me_mi('Rpt_info_ele_me_mi.php');">
                 </div></th>
                 <th width="334" scope="col"><input name="btcancelar2" type="button" id="btcancelar22" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></th>
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
