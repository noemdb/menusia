<?include ("../../class/seguridad.inc");
include ("../../class/conects.php");  include ("../../class/funciones.php");
include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="03-0000050"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
$ced_rifd="";$ced_rifh="";$ordenado="";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>SIA CONTROL DE BIENES NACIONALES (Reportes Ocupantes Del Bien Inmueble)</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_ocu_bien_inmu_repor(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Catalogo de Ocupantes Del Bien Inmueble?");
  if(document.form1.ordenado[0].checked==true){deta="ced_rif";}
  if(document.form1.ordenado[1].checked==true){deta="nombre_ocupante";}
  if (r==true){url=murl+"?&ced_rifd="+document.form1.txtced_rifd.value+"&ced_rifh="+document.form1.txtced_rifh.value+"&ordenado="+deta;
  window.open(url,"Reporte Catalogo de Ocupantes Del Bien Inmueble")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>

</head><?
//DEPENDENCIAS
$sql="SELECT MAX(ced_rif) As Max_ced_rif, MIN(ced_rif) As Min_ced_rif FROM bien011";
$res=pg_query($sql);if ($registro=pg_fetch_array($res,0)){$encontro=true;}else{$encontro=false;}
if($encontro=true){$ced_rifd=$registro["min_ced_rif"];$ced_rifh=$registro["max_ced_rif"];}
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">REPORTE CATALAGO DE OCUPANTES DEL BIEN INMUEBLE  </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="306" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="300"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:861px; height:141px; z-index:1; top: 122px; left: 16px;">
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
                 <td width="364" scope="col"><div align="left"></div></td>
                 <td width="179" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="Estilo12">DESDE</span></span></span></div></td>
                 <td width="122" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> <span class="Estilo12">HASTA</span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span> <span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
                 <td width="278" scope="col"><div align="left"><span class="Estilo5">                     <span class="Estilo10"><span class="menu"><strong><strong> </strong></strong></span></span> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="306" scope="col"><div align="right"><span class="Estilo5">C&Eacute;DULA RESPONSABLES :</span></div></td>
                 <td width="190" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">
                   <input name="txtced_rifd" type="text" class="Estilo5" id="txtced_rifd" size="15" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $ced_rifd?>">
                   <span class="menu"><strong><strong>
                   <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_ocupa_bien_inmud.php?criterio=','SIA','','750','500','true')" value="...">
                   </strong></strong></span> </span></span></div></td>
                 <td width="453" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>
                   <input name="txtced_rifh" type="text" class="Estilo5" id="txtced_rifh" size="15" maxlength="12"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $ced_rifh?>">
                   <strong><strong><strong><strong>
                   <input name="btfuente" type="button" id="btfuente6" title="Abrir Catalogo Fuentes de Financiamiento" onClick="VentanaCentrada('Cat_ocupa_bien_inmuh.php?criterio=','SIA','','750','500','true')" value="...">
                   </strong></strong></strong></strong> </strong></strong></span></span></span></div></td>
                 </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="331" scope="col"><div align="right"><span class="Estilo12">ORDENADO</span></div></td>
                 <td width="179" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10">                     <span class="menu"><strong><strong>
                 </strong></strong></span> </span></span></div></td>
                 <td width="439" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"><span class="menu"><strong><strong>                     <strong><strong><strong><strong>
                 </strong></strong></strong></strong> </strong></strong></span></span></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="965">
               <tr>
                 <td width="405" scope="col"><div align="right"><span class="Estilo5">
                   <input name="ordenado" type="radio" value="ced_rif" checked>C&Eacute;DULA </span></div></td>
                 <td width="86" scope="col"><div align="left"><span class="Estilo5"><span class="Estilo10"> </span></span></div></td>
                 <td width="458" scope="col"><span class="Estilo5">
                   <input name="ordenado" type="radio" value="nombre_ocupante"> NOMBRE</span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="454" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr align="center" valign="middle">
                 <td>
                   <div align="center">
                     <input name="btgenera" type="button" id="btgenera2" value="GENERAR" onClick="javascript:Llama_Rpt_ocu_bien_inmu_repor('Rpt_ocu_bien_inmu_repor.php');">
                 </div></td>
                 <td>
                   <div align="center">
                     <input name="btcancelar" type="button" id="btcancelar2" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');">
                 </div></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <p>&nbsp;</p>
       </div>
         </form>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<? pg_close();?>
