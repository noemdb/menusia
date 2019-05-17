<?include ("../../class/seguridad.inc"); include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="03-0000060"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
$tipo_nominad="";$tipo_nominah="zz";$cod_conceptod="";$cod_conceptoh="zzzz";$codigo_departamentod="";$codigo_departamentoh="zzzz";$tipo_calculo=""; $fecha_nomina=asigna_fecha_hoy();
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Reportes De Ralaci&oacute;n De Conceptos Detalle)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_deta_concep_rn(murl){var url;var r; var mtipo_monto=document.form1.tipo_monto.value;
  if(mtipo_monto=="SEL"){ if(document.form1.optipo[0].checked==true){mtipo_monto="TOT";}  if(document.form1.optipo[1].checked==true){mtipo_monto="PRI";} if(document.form1.optipo[2].checked==true){mtipo_monto="SEG";}  }
  r=confirm("Desea Generar el Reporte Relacion de Conceptos Detalle?");
  if (r==true){url=murl+"?&tipo_nomina_d="+document.form1.txttipo_nomina_d.value+"&tipo_nomina_h="+document.form1.txttipo_nomina_h.value+"&estatus_trab_d="+document.form1.txtestatus_t.value+"&salto_conc="+document.form1.txtsalto_conc.value+
  "&cod_conceptod="+document.form1.txtcod_concepto_d.value+"&cod_conceptoh="+document.form1.txtcod_concepto_h.value+"&tipo_concepto="+document.form1.txtconcepto_t.value+"&tipo_rpt="+document.form1.tipo_rpt.value+"&num_periodos="+document.form1.txtnum_periodos.value+
  "&cod_departd="+document.form1.txtcodigo_departamento_d.value+"&cod_departh="+document.form1.txtcodigo_departamento_h.value+"&tipo_calculo="+document.form1.txttipo_calculo.value+"&act_hist="+document.form1.txtact_hist.value+"&fecha_nom="+document.form1.txtfecha_nom.value+"&tipo_monto="+mtipo_monto;
  window.open(url,"Reporte Relacion de Conceptos Detalle")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
function chequea_tipo(mform){var mref;   mref=mform.txttipo_nomina_d.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina_d.value=mref; return true;}
function apaga_tipo(mthis){apagar(mthis);  document.form1.txttipo_nomina_h.value=mthis.value; document.form1.txtdescripcion_h.value=document.form1.txtdescripcion_d.value;  return true; }
function chequea_fecha(mthis){var mref; var mfec;   mref=mthis.value; if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec; } return true;}
</script>
</head>
<?
$descripcion_d="";$descripcion_h=""; $denominacion_concep_d="";$denominacion_concep_h="";  $descripcion_dep_d="";$descripcion_dep_d="";
$sql="SELECT MAX(tipo_nomina) As Max_tipo_nomina, MIN(tipo_nomina) As Min_tipo_nomina FROM nom001 ".$criterion." ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_nomina_d=$registro["min_tipo_nomina"];$tipo_nomina_h=$registro["max_tipo_nomina"];   }
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_d=$registro["descripcion"];}
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_h=$registro["descripcion"];}
$sql="SELECT MAX(cod_concepto) As Max_cod_concepto, MIN(cod_concepto) As Min_cod_concepto FROM nom002 where  oculto='NO' ".$criterioc." ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cod_conceptod=$registro["min_cod_concepto"];$cod_conceptoh=$registro["max_cod_concepto"]; }
$sql="SELECT cod_concepto,denominacion FROM nom002 where cod_concepto='$cod_conceptod'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_concep_d=$registro["denominacion"];}
$sql="SELECT cod_concepto,denominacion FROM nom002 where cod_concepto='$cod_conceptoh'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_concep_h=$registro["denominacion"];}
$sql="SELECT MAX(codigo_departamento) As Max_codigo_departamento, MIN(codigo_departamento) As Min_codigo_departamento FROM nom005 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$codigo_departamento_d=$registro["min_codigo_departamento"];$codigo_departamento_h=$registro["max_codigo_departamento"];   }
$sql="SELECT codigo_departamento,descripcion_dep FROM nom005 where codigo_departamento='$codigo_departamento_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_dep_d=$registro["descripcion_dep"];}
$sql="SELECT codigo_departamento,descripcion_dep FROM nom005 where codigo_departamento='$codigo_departamento_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_dep_h=$registro["descripcion_dep"];}
$sql="SELECT fecha_p_hasta FROM nom017 where tipo_nomina='$tipo_nomina_d' and tp_calculo='N'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){  $fecha_nomina=$registro["fecha_p_hasta"];   $fecha_nomina=formato_ddmmaaaa($fecha_nomina);}
$tipo_nomina_h=$tipo_nomina_d; $descripcion_h=$descripcion_d;
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE RELACI&Oacute;N DE CONCEPTOS DETALLE</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="410" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="395"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:504px; height:390px; z-index:1; top: 61px; left: 42px;">
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
           <tr>
             <td><table width="828" border="0" align="center">
               <tr>
                 <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
                   <tr>
                     <td width="131" align="left" class="Estilo5">TIPO N&Oacute;MINA DESDE :</td>
                     <td width="43" align="left"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina_d" type="text" id="txttipo_nomina_d" onFocus="encender(this)" onBlur="apaga_tipo(this)" size="2" maxlength="2"  value="<?echo $tipo_nomina_d?>" onchange="chequea_tipo(this.form);"> </span></td>
                     <td width="41" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_tipod" type="button" id="cat_tipod" title="Abrir Catalogo Tipos de nominas" onClick="VentanaCentrada('../Cat_tipo_nominad.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                     <td width="688" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_d" type="text" id="txtdescripcion_d" size="90" maxlength="90" readonly value="<?echo $descripcion_d?>">  </span></td>
                   </tr>
                 </table></td>
               </tr>
               <tr>
                 <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
                   <tr>
                     <td width="131" align="left" class="Estilo5">TIPO N&Oacute;MINA HASTA :</td>
                     <td width="43" align="left"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina_h" type="text" id="txttipo_nomina_h" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_h?>">  </span></td>
                     <td width="41" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_tipoh" type="button" id="cat_tipoh" title="Abrir Catalogo Tipos de nominas" onClick="VentanaCentrada('../Cat_tipo_nominah.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                     <td width="688" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_h" type="text" id="txtdescripcion_h" size="90" maxlength="90" readonly value="<?echo $descripcion_h?>">  </span></td>
                   </tr>
                 </table></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="120" align="left" class="Estilo5">CONCEPTO DESDE :</td>
                 <td width="50" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto_d" type="text" id="txtcod_concepto_d" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $cod_conceptod?>"> </span></td>
                 <td width="43" align="left"><span class="Estilo5"><input class="Estilo10" name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('../Cat_conceptosd.php?criterio=','SIA','','650','500','true')" value="..."></span></td>
                 <td width="690" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_d" type="text" id="txtdenominacion_d" size="90" maxlength="100" readonly value="<?echo $denominacion_concep_d?>"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="120" align="left" class="Estilo5">CONCEPTO HASTA :</td>
                 <td width="50" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto_h" type="text" id="txtcod_concepto_h" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $cod_conceptoh?>"></span></td>
                 <td width="43" align="left"><span class="Estilo5"><input class="Estilo10" name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('../Cat_conceptosh.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                 <td width="690" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_h" type="text" id="txtdenominacion_h" size="90" maxlength="100" readonly value="<?echo $denominacion_concep_h?>"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="left" class="Estilo5">C&Oacute;DIGO DEPARTAMENTO DESDE :</td>
                 <td width="160" align="left" ><span class="Estilo5"><input class="Estilo10" name="txtcodigo_departamento_d" type="text" id="txtcodigo_departamento_d" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="15" value="<?echo $codigo_departamento_d?>"> </span></td>
                 <td width="49" align="left"><span class="Estilo5"><input class="Estilo10" name="Cat_depd" type="button" id="Cat_depd" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamentod.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                 <td width="499" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_dep_d" type="text" id="txtdescripcion_dep_d" size="70" maxlength="100" readonly value="<?echo $descripcion_dep_d?>">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="left" class="Estilo5">C&Oacute;DIGO DEPARTAMENTO HASTA :</td>
                 <td width="160" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_departamento_h" type="text" id="txtcodigo_departamento_h" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="15" value="<?echo $codigo_departamento_h?>"></span></td>
                 <td width="49" align="left"><span class="Estilo5"><input class="Estilo10" name="Cat_deph" type="button" id="Cat_deph" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamentoh.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                 <td width="499" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_dep_h" type="text" id="txtdescripcion_dep_h" size="70" maxlength="100" readonly value="<?echo $descripcion_dep_h?>"> </span></td>
               </tr>
             </table></td>
           </tr>		   
           <tr>
            <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
                 <td width="200"  align="left" class="Estilo5">ESTATUS DEL TRABAJADOR :</td>
				 <td width="250" align="left"><span class="Estilo5"><select class="Estilo10" name="txtestatus_t" size="1" id="txtestatus_t"><option value='TODOS' selected>TODOS</option> <option value='ACTIVO'>ACTIVO</option> <option value='VACACIONES'>VACACIONES</option>  </select></span></td>
				 <td width="180"  align="left" class="Estilo5">TIPO DE C&Aacute;LCULO :</td>				 
				 <td width="170" align="left"><span class="Estilo5"><select class="Estilo10" name="txttipo_calculo" size="1" id="txttipo_calculo"><option value='N' selected>NORMAL</option> <option value='E'>EXTRAORDINARIA</option> </select> </span></td>
                 <td width="100"><span class="Estilo5"><input name="txtnum_periodos" type="text" id="txtnum_periodos" size="1" maxlength="1" value="1" onFocus="encender(this)" onBlur="apagar(this)" title="Num. Calculo para Nominas Extrordinaria" onKeypress="return validarNum(event)"> </span></td>
		
			  </tr>
             </table></td>
           </tr>
		   <tr>
            <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
                 <td width="200"  align="left" class="Estilo5">CONCEPTOS CALCULADOR POR :</td>
				 <td width="250" align="left"><span class="Estilo5"><select class="Estilo10" name="txtconcepto_t" size="1" id="txtconcepto_t"><option value='NOMINA' selected>NOMINA</option><option value='VACACIONES'>VACACIONES</option><option value='TODOS'>TODOS</option></select></span></td>
				 <td width="180"  align="left" class="Estilo5">TIPO SALIDA DEL REPORTE :</td>				 
				 <td width="270"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt"> <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option> </select></span></td>              
              </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
			     <td width="210"  align="left" class="Estilo5">SALTO DE PAGINA POR CONCEPTO :</td>	
                 <td width="240" align="left"><span class="Estilo5"><select class="Estilo10" name="txtsalto_conc" size="1" id="txtsalto_conc"> <option value='S' selected>SI</option> <option value='N'>NO</option></select></span></td>
				 <td width="180"  align="left" class="Estilo5"></td>				 
				 <td width="270" align="left"><span class="Estilo5"></span></td>
               </tr>
             </table></td>
           </tr> 
		   <script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
           <tr><td>&nbsp;</td></tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
			     <td width="200"  align="left" class="Estilo5">ACTIVA HISTORICO N&Oacute;MINA :</td>	
                 <td width="250" align="left"><span class="Estilo5"><select class="Estilo10" name="txtact_hist" size="1" id="txtact_hist"> <option value='N' selected>NO</option> <option value='S'>SI</option></select></span></td>
				 <td width="180"  align="left" class="Estilo5">FECHA HASTA DE N&Oacute;MINA :</td>				 
				 <td width="270" align="left"><span class="Estilo5"><input class="Estilo10" name="txtfecha_nom" type="text" id="txtfecha_nom" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_nomina?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
               </tr>
             </table></td>
           </tr> 
           <tr><td>&nbsp;</td></tr>
		   <?if($Cod_Emp=="58"){?>
           <tr>
			  <td height="10"><table width="824" border="0" cellspacing="1" cellpadding="1">
				<tr>
				  <td width="204"><span class="Estilo5">PARA NOMINA MENSUAL : </span></td>
				  <td width="615"><table width="390" height="10" border="1" cellspacing="0" >
					<tr>
					  <td width="380"  class="Estilo5">
						  <p>
							<label><input class="Estilo10" name="optipo" type="radio" value="TOT" checked> </label><label>PAGO TOTAL </label>
							<input class="Estilo10" name="optipo" type="radio" value="PRI"> <label>PRIMER PAGO</label>
							<input class="Estilo10" name="optipo" type="radio" value="SEG"> <label>SEGUNDO PAGO </label>
						  </p>
					  </td>
					</tr>
				  </table></td>
				  <td width="5"><input class="Estilo10" name="tipo_monto" type="hidden" id="tipo_monto" value="SEL" ></td>	
				</tr>
			  </table></td>
		   </tr>
		   <tr><td>&nbsp;</td></tr>	
           <?}else{?>
		   <tr>
		      <td width="5"><input class="Estilo10" name="tipo_monto" type="hidden" id="tipo_monto" value="TOT" ></td>			  
			</tr>
           <?}?>		   
           <tr>
             <td><table width="905">
               <tr>
                 <th width="446" scope="col"><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_deta_concep_rn('Rpt_deta_concep_rn.php');">  </div></th>
                 <th width="447" scope="col"><input name="btcancelar" type="button" id="btcancelar2" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></th>
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
