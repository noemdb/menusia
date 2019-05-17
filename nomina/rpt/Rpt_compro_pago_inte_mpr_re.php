<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
   $cod_empleado_d="";
   $cod_empleado_h="";
   ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Reporte de Prestamos Asignados por Trabajador)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../../class/sia.css" type=text/css
rel=stylesheet>
<SCRIPT language=JavaScript
src="../../class/sia.js"
type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_compro_pago_inte_mpr(murl){
var url; var r;

  r=confirm("Desea Generar el Reporte Comprobante de Pago de Intereses?");
  if (r==true) {url=murl+"?cod_empleado_d="+document.form1.txtcod_empleado_d.value+"&cod_empleado_h="+document.form1.txtcod_empleado_h.value;
   window.open(url,"Reporte Comprobante de Pago de Intereses")
  }
}
function Llama_Menu_Rpt(murl){var url;    url="../"+murl;  LlamarURL(url);}
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
  $cod_empleado_h=$registro["max_cod_empleado"];
  }
?>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE COMPROBANTE   DE PAGO DE INTERESES </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="162" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="156"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
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
                 <td width="180" scope="col"><div align="right"><span class="Estilo5">CODIGO TRABAJADOR DESDE :</span></div></td>
                 <td width="142" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                     <input name="txtcod_empleado_d" type="text" id="txtcod_empleado_d" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="15" value="<?echo $cod_empleado_d?>">
                     <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="123" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('../Cat_trabajadoresd.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
                 <td width="54" scope="col"><span class="Estilo5">HASTA :</span></td>
                 <td width="137" scope="col"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtcod_empleado_h" type="text" id="txtcod_empleado_h" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="20" value="<?echo $cod_empleado_d?>">
                   <span class="menu"><strong><strong> </strong></strong></span></span></span></td>
                 <td width="241" scope="col"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('../Cat_trabajadoresh.php?criterio=','SIA','','650','500','true')" value="...">
                 </strong></strong></span></span></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <th width="446" scope="col"><div align="center">
                     <input name="btgenera2" type="button" id="btgenera23" value="GENERAR" onClick="javascript:Llama_Rpt_compro_pago_inte_mpr('Rpt_compro_pago_inte_mpr.php');">
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
