<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="03-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
$tipo_nomina_d=""; $tipo_nomina_h=""; $cod_concepto_d=""; $cod_concepto_h="zzzzzzzzzzz";
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Reporte catalogo de Conceptos)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type=text/css rel=stylesheet>
<SCRIPT language="JavaScript" src="../../class/sia.js" type=text/javascript></SCRIPT>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_con_asig_trab_cata(murl){var url;var r;
  r=confirm("Desea Generar el Reporte Catalogo de Conceptos ?");
  if (r==true){
    url=murl+"?&tipo_nomina_d="+document.form1.txttipo_nomina_d.value+"&tipo_nomina_h="+document.form1.txttipo_nomina_h.value+"&cod_concepto_d="+document.form1.txtcod_concepto_d.value+"&cod_concepto_h="+document.form1.txtcod_concepto_h.value+"&tipo_rpt="+document.form1.tipo_rpt.value;
    window.open(url,"Reporte Catalogo de Conceptos")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
function chequea_tipo(mform){var mref;   mref=mform.txttipo_nomina_d.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina_d.value=mref; return true;}
function apaga_tipo(mthis){apagar(mthis);  document.form1.txttipo_nomina_h.value=mthis.value; document.form1.txtdescripcion_h.value=document.form1.txtdescripcion_d.value;  return true; }
</script>
</head>
<?
$descripcion_d="";$descripcion_h=""; $denominacion_d="";$denominacion_h="";
$sql="SELECT MAX(tipo_nomina) As Max_tipo_nomina, MIN(tipo_nomina) As Min_tipo_nomina FROM nom001 ".$criterion." ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_nomina_d=$registro["min_tipo_nomina"];$tipo_nomina_h=$registro["max_tipo_nomina"];   }
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_d=$registro["descripcion"];}
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_h=$registro["descripcion"];}
$sql="SELECT MAX(cod_concepto) As Max_cod_concepto, MIN(cod_concepto) As Min_cod_concepto FROM nom002 ".$criterion." ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cod_concepto_d=$registro["min_cod_concepto"];$cod_concepto_h=$registro["max_cod_concepto"];   }
$sql="SELECT denominacion FROM nom002 where cod_concepto='$cod_concepto_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_d=$registro["denominacion"];}
$sql="SELECT denominacion FROM nom002 where cod_concepto='$cod_concepto_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_h=$registro["denominacion"];}
?>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.png" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE CATALOGO DE CONCEPTOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="342" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="336"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
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
                 <td width="140" align="center" class="Estilo5"><div align="left">TIPO N&Oacute;MINA DESDE :</div></td>
                 <td width="43"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina_d" type="text" id="txttipo_nomina_d" onFocus="encender(this)" onBlur="apaga_tipo(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_d?>" onchange="chequea_tipo(this.form);">   </span></div></td>
                 <td width="41"><div align="left"><span class="Estilo5"> <input class="Estilo10" name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo Tipos de nominas" onClick="VentanaCentrada('../Cat_tipo_nominad.php?criterio=','SIA','','650','500','true')" value="...">    </span></div></td>
                 <td width="679"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_d" type="text" id="txtdescripcion_d" size="100" maxlength="108" value="<?echo $descripcion_d?>" readonly>  </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
		     <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
			   <tr>
				   <td width="140" align="center" class="Estilo5"><div align="left">TIPO N&Oacute;MINA HASTA :</div></td>
				   <td width="43"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina_h" type="text" id="txttipo_nomina_h" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_h?>">	 </span></div></td>
				   <td width="41"><div align="left"><span class="Estilo5"> <input class="Estilo10" name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo Tipos de nominas" onClick="VentanaCentrada('../Cat_tipo_nominah.php?criterio=','SIA','','650','500','true')" value="...">	 </span></div></td>
				   <td width="679" align="center"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_h" type="text" id="txtdescripcion_h" size="100" maxlength="109" value="<?echo $descripcion_h?>" readonly>	 </span></div></td>
               </tr>
			</table></td>
           </tr>   
           <tr> <td>&nbsp;</td></tr>
		   <tr>
			 <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
			   <tr>
				 <td width="166" align="center" class="Estilo5"><div align="left">C&Oacute;DIGO CONCEPTO DESDE :</div></td>
				 <td width="56"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto_d" type="text" id="txtcod_concepto_d" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $cod_concepto_d?>">	 </span></div></td>
				 <td width="40"><div align="left"><span class="Estilo5"> <input class="Estilo10" name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('../Cat_conceptosd.php?criterio=','SIA','','650','500','true')" value="...">	 </span></div></td>
				 <td width="641" align="center"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_d" type="text" id="txtdenominacion_d" size="100" maxlength="101" value="<?echo $denominacion_d?>" readonly>	 </span></div></td>
			   </tr>
			 </table></td>
		   </tr>
		   <tr>
			 <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="166" align="center" class="Estilo5"><div align="left">C&Oacute;DIGO CONCEPTO HASTA :</div></td>
				<td width="57"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto_h" type="text" id="txtcod_concepto_h" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $cod_concepto_h?>">	</span></div></td>
				<td width="39"><div align="left"><span class="Estilo5"><input class="Estilo10" name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('../Cat_conceptosh.php?criterio=','SIA','','650','500','true')" value="...">	</span></div></td>
				<td width="641" align="center"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_h" type="text" id="txtdenominacion_h" size="100" maxlength="101" value="<?echo $denominacion_h?>" readonly>	</span></div></td>
			  </tr>
			</table></td>
		   </tr>  
           <tr><td>&nbsp;</td></tr>	
	       <tr>
            <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
                 <td width="200"  align="left" class="Estilo5">TIPO SALIDA DEL REPORTE :</td>
				 <td width="700" align="left"><span class="Estilo5"><select class="Estilo10" name="tipo_rpt" id="tipo_rpt"> <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option>  </select></span></td>
              </tr>
             </table></td>
           </tr>
           <script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
           <tr><td>&nbsp;</td></tr>	
		   <tr><td>&nbsp;</td></tr>	
           <tr>
             <td><div align="left">
               <table width="894">
                   <tr>
                     <th width="445" scope="col"><div align="center"><input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_con_asig_trab_cata('Catalogo_concep_cata_re.php');">   </div></th>
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