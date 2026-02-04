<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="03-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
$codigo_cargo_d=""; $codigo_cargo_h="";  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Reporte catalogo de Cargos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language="JavaScript" src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_cargos_cata(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Catalogo de Cargos ?");
  if (r==true){
    url=murl+"?&codigo_cargo_d="+document.form1.txtcodigo_cargo_d.value+"&codigo_cargo_h="+document.form1.txtcodigo_cargo_h.value+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url,"Reporte Catalogo de Cargos")}
}

function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
</script>
</head>
<?
$denominacion_d="";$denominacion_h=""; 
$sql="SELECT MAX(codigo_cargo) As Max_codigo_cargo, MIN(codigo_cargo) As Min_codigo_cargo FROM nom004 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$codigo_cargo_d=$registro["min_codigo_cargo"];$codigo_cargo_h=$registro["max_codigo_cargo"];   }
$sql="SELECT codigo_cargo,denominacion FROM nom004 where codigo_cargo='$codigo_cargo_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_d=$registro["denominacion"];}
$sql="SELECT codigo_cargo,denominacion FROM nom004 where codigo_cargo='$codigo_cargo_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_h=$registro["denominacion"];}

?>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.png" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE CATALOGO DE CARGOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="312" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="306"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:504px; height:94px; z-index:1; top: 80px; left: 41px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><table width="898">
               <tr>
                 <td width="401" scope="col"><div align="left"></div></td>
                 <td width="141" scope="col"><div align="left"><span class="Estilo13">CRITERIOS</span></div></td>
                 <td width="173" scope="col"><div align="left"></div></td>
                 <td width="163" scope="col">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
		   <tr> <td>&nbsp;</td></tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="150" align="center" class="Estilo5"><div align="left">CODIGO CARGO DESDE : </div></td>
                 <td width="83"><div align="left"><span class="Estilo5">  <input name="txtcodigo_cargo_d" type="text" id="txtcodigo_cargo_d" onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="10" value="<?echo $codigo_cargo_d?>" class="Estilo5">
                 </span></div></td>
                 <td width="41"><div align="left"><span class="Estilo5"> <input name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo Cargos" onClick="VentanaCentrada('../Cat_cargosd.php?criterio=','SIA','','650','500','true')" value="...">
                 </span></div></td>
                 <td width="629"><div align="left"><span class="Estilo5"><input name="txtdenominacion_d" type="text" id="txtdenominacion_d" size="80" maxlength="108" value="<?echo $denominacion_d?>" readonly class="Estilo5" >
                 </span></div></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
           <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
             <tr>
               <td width="150" align="center" class="Estilo5"><div align="left">CODIGO CARGO HASTA : </div></td>
               <td width="83"><div align="left"><span class="Estilo5"><input name="txtcodigo_cargo_h" type="text" id="txtcodigo_cargo_h" onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="10" value="<?echo $codigo_cargo_h?>" class="Estilo5">
               </span></div></td>
               <td width="41"><div align="left"><span class="Estilo5"><input name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo Cargos" onClick="VentanaCentrada('../Cat_cargosh.php?criterio=','SIA','','650','500','true')" value="...">
               </span></div></td>
               <td width="629" align="center"><div align="left"><span class="Estilo5"><input name="txtdenominacion_h" type="text" id="txtdenominacion_h" size="80" maxlength="109" value="<?echo $denominacion_h?>" readonly class="Estilo5">
               </span></div></td>
             </tr>
           </table></td>
           </tr>
           <tr><td>&nbsp;</td>  </tr>
          
	       <tr>
            <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
                 <td width="200"  align="left" class="Estilo5">TIPO SALIDA DEL REPORTE :</td>
				 <td width="700" align="left"><span class="Estilo5"><select name="tipo_rpt" id="tipo_rpt"> <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option>  </select></span></td>
              </tr>
             </table></td>
           </tr>
           <script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
           <tr><td>&nbsp;</td>  </tr>            
           <tr>
             <td><div align="left">
               <table width="894">
                   <tr>
                     <th width="445" scope="col"><div align="center">
                         <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_cargos_cata('Rpt_cargos_cata.php');">
                     </div></th>
                     <th width="448" scope="col"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></th>
                   </tr>
               </table>
             </div></td>
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
