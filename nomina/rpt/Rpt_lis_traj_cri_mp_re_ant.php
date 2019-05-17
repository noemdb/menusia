<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
 $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);
 $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);

 $vurl;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA NMINA Y PERSONAL (Reporte Diario General)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK
href="../../class/sia.css" type=text/css
rel=stylesheet>
<SCRIPT language=JavaScript
src="../../class/sia.js"
type=text/javascript></SCRIPT>


<script language="JavaScript" type="text/JavaScript">




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
-->
</style>
<body>
<table width="991" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="76"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="650"><div align="center" class="Estilo2 Estilo6"> REPORTE LISTADO TRABAJADORES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>


         <div id="Layer1" style="position:absolute; width:900px; height:470px; z-index:2; left: 17px; top: 73px;">
           <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 950;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Criterios Generales";        // Requiere: <div id="T11" class="tab-body">  ... </div>
   rows[1][2] = "Ordenar Por :";        // Requiere: <div id="T12" class="tab-body">  ... </div>
   </script>
        <?include ("../../class/class_tab.php");?>
        <script type="text/javascript" language="javascript"> DrawTabs(); </script>
        <!-- PESTA&Ntilde;A 1 -->
        <div id="T11" class="tab-body">
          <iframe src="Det_criterio_generales_rn_re.php?criterio=<?echo $cod_estructura?>"  width="950" height="470" scrolling="auto" frameborder="0"> </iframe>
        </div>
        <!--PESTA&Ntilde;A 2 -->
        <div id="T12" class="tab-body" >
          <iframe src="Det_criterio_campos_rn_re.php?criterio=<?echo $cod_estructura?>"  width="850" height="300" scrolling="auto" frameborder="0"> </iframe>
        </div>
</div>

      <div id="Layer1" style="position:absolute; width:907px; height:470px; z-index:1; top: 68px; left: 14px;">

</div>


</body>
</html>
