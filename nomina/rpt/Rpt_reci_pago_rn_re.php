<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php"); include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="03-0000103"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
$tipo_nominad="";$tipo_nominah="zz";$cod_empleado_d="";$cod_empleado_h="zzzzzzzzzzz";$codigo_departamentod="";$codigo_departamentoh="zzzzzzzzzzzzzzzz";
$codigo_cargo_d="";$codigo_cargo_h="zzzzzzzzzzz"; $cod_concepto_d=""; $cod_concepto_h="zzz"; $forma_pago=""; $tipo_calculo="";$fecha_nomina=asigna_fecha_hoy(); $num_rec_d="00000"; $num_rec_h="99999";
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Reporte Recibos de N&oacute;minas)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
function Llama_Rpt_reci_pago_rn(murl){var url;var r; var morden=" order by tipo_nomina, cod_departam, cod_cargo, cod_empleado, cod_concepto"; var moporden=0;
  if(document.form1.optipo[0].checked==true){morden="order by tipo_nomina,num_recibo,cod_empleado,cod_concepto"; moporden=1;}
  if(document.form1.optipo[1].checked==true){morden="order by cod_empleado,cod_concepto"; moporden=2;}
  if(document.form1.optipo[2].checked==true){morden="order by substr(cod_presup,1,12),cod_empleado,cod_concepto"; moporden=3;}
  if(document.form1.optipo[3].checked==true){morden="order by codigo_ubicacion,cod_empleado,cod_concepto"; moporden=4;}
  if(document.form1.optipo[4].checked==true){morden="order by nombre,cod_empleado,cod_concepto"; moporden=5;}
  r=confirm("Desea Generar el Reporte Recibos de Nomina?");
  if (r==true){url=murl+"?&tipo_nomina_d="+document.form1.txttipo_nomina_d.value+"&tipo_nomina_h="+document.form1.txttipo_nomina_h.value+"&cod_empleado_d="+document.form1.txtcod_empleado_d.value+"&cod_empleado_h="+document.form1.txtcod_empleado_h.value+"&tipo_concepto="+document.form1.txtconcepto_t.value+
  "&codigo_cargo_d="+document.form1.txtcodigo_cargo_d.value+"&codigo_cargo_h="+document.form1.txtcodigo_cargo_h.value+"&cod_departamento_d="+document.form1.txtcodigo_departamento_d.value+"&cod_departamento_h="+document.form1.txtcodigo_departamento_h.value+
  "&cod_concepto_d="+document.form1.txtcod_concepto_d.value+"&cod_concepto_h="+document.form1.txtcod_concepto_h.value+"&forma_pago="+document.form1.txtforma_pago.value+"&tipo_calculo="+document.form1.txttipo_calculo.value+"&act_hist="+document.form1.txtact_hist.value+"&fecha_nom="+document.form1.txtfecha_nom.value+"&num_recibo_d="+document.form1.txtnum_recibo_d.value+"&num_recibo_h="+document.form1.txtnum_recibo_h.value+
  "&orden="+morden+"&oporden="+moporden+"&tipo_rpt="+document.form1.tipo_rpt.value+"&rango_f="+document.form1.txtrang_fec.value+"&fecha_desde="+document.form1.txtfecha_nomd.value+"&fecha_hasta="+document.form1.txtfecha_nomh.value;   
  window.open(url,"Reporte Recibos de Nomina")}
}
function Llama_Menu_Rpt(murl){var url;url="../"+murl;LlamarURL(url);}
function chequea_tipo(mform){var mref;   mref=mform.txttipo_nomina_d.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina_d.value=mref; return true;}
function apaga_tipo(mthis){apagar(mthis);  document.form1.txttipo_nomina_h.value=mthis.value; document.form1.txtdescripcion_h.value=document.form1.txtdescripcion_d.value;  return true; }
function chequea_fecha(mthis){var mref; var mfec;   mref=mthis.value; if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec; } return true;}
</script>
</head>
<?  $descripcion_d=""; $descripcion_h=""; $nombre_empled=""; $nombre_empleh=""; $denominacion_cargod=""; $denominacion_cargoh="";$descripcion_dep_d=""; $descripcion_dep_h="";
$descripcion_d=""; $descripcion_h="";   $denominacion_catd=""; $denominacion_cath="zzzzzzzzzzzzzzzzzzzz";
$sql="SELECT MAX(tipo_nomina) As Max_tipo_nomina, MIN(tipo_nomina) As Min_tipo_nomina FROM nom001 ".$criterion." "; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_nomina_d=$registro["min_tipo_nomina"];$tipo_nomina_h=$registro["max_tipo_nomina"];   }
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_d=$registro["descripcion"];}
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_h=$registro["descripcion"];}
$sql="SELECT MAX(cod_empleado) As Max_cod_empleado, MIN(cod_empleado) As Min_cod_empleado FROM nom006 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cod_empleado_d=$registro["min_cod_empleado"];$cod_empleado_h=$registro["max_cod_empleado"];   }
$sql="SELECT cod_empleado,nombre FROM nom006 where cod_empleado='$cod_empleado_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$nombre_empled=$registro["nombre"];}
$sql="SELECT cod_empleado,nombre FROM nom006 where cod_empleado='$cod_empleado_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$nombre_empleh=$registro["nombre"];}
$sql="SELECT MAX(codigo_cargo) As Max_codigo_cargo, MIN(codigo_cargo) As Min_codigo_cargo FROM nom004 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$codigo_cargo_d=$registro["min_codigo_cargo"];$codigo_cargo_h=$registro["max_codigo_cargo"];   }
$sql="SELECT codigo_cargo,denominacion FROM nom004 where codigo_cargo='$codigo_cargo_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_cargod=$registro["denominacion"];}
$sql="SELECT codigo_cargo,denominacion FROM nom004 where codigo_cargo='$codigo_cargo_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_cargoh=$registro["denominacion"];}
$sql="SELECT MAX(codigo_departamento) As Max_codigo_departamento, MIN(codigo_departamento) As Min_codigo_departamento FROM nom005 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$codigo_departamento_d=$registro["min_codigo_departamento"];$codigo_departamento_h=$registro["max_codigo_departamento"];   }
$sql="SELECT codigo_departamento,descripcion_dep FROM nom005 where codigo_departamento='$codigo_departamento_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_dep_d=$registro["descripcion_dep"];}
$sql="SELECT codigo_departamento,descripcion_dep FROM nom005 where codigo_departamento='$codigo_departamento_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_dep_h=$registro["descripcion_dep"];}
$sql="SELECT fecha_p_desde,fecha_p_hasta FROM nom017 where tipo_nomina='$tipo_nomina_d' and tp_calculo='N'"; $res=pg_query($sql);  $fecha_nominad=$fecha_nomina;
if ($registro=pg_fetch_array($res,0)){  $fecha_nomina=$registro["fecha_p_hasta"];   $fecha_nomina=formato_ddmmaaaa($fecha_nomina);$fecha_nominad=$registro["fecha_p_desde"]; $fecha_nominad=formato_ddmmaaaa($fecha_nominad);  $fecha_nomina=$registro["fecha_p_hasta"];   $fecha_nomina=formato_ddmmaaaa($fecha_nomina);}
$tipo_nomina_h=$tipo_nomina_d; $descripcion_h=$descripcion_d; $fecha_desde=$fecha_nominad; $fecha_hasta=$fecha_nomina;
$sql="SELECT MAX(cod_concepto) As Max_cod_concepto, MIN(cod_concepto) As Min_cod_concepto FROM nom002 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cod_concepto_d=$registro["min_cod_concepto"];$cod_concepto_h=$registro["max_cod_concepto"];   }
$sql="SELECT denominacion FROM nom002 where cod_concepto='$cod_concepto_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_d=$registro["denominacion"];}
$sql="SELECT denominacion FROM nom002 where cod_concepto='$cod_concepto_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_h=$registro["denominacion"];}
?>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE RECIBOS DE N&Oacute;MINA </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="615" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="610"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:504px; height:94px; z-index:1; top: 61px; left: 42px;">
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
             <td>&nbsp;</td>
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
                 <td width="130" align="left" class="Estilo5">TRABAJADOR DESDE :</td>
                 <td width="159" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado_d" type="text" id="txtcod_empleado_d" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" value="<?echo $cod_empleado_d?>" ></span></td>
                 <td width="47" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_trabd" type="button" id="cat_trabd" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('../Cat_trabajadores_d.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                 <td width="567" align="left"><span class="Estilo5"><input class="Estilo10" name="txtnombre_d" type="text" id="txtnombre_d" size="90" maxlength="90" readonly value="<?echo $nombre_empled?>"> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="130" align="left" class="Estilo5">TRABAJADOR HASTA :</td>
                 <td width="159" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado_h" type="text" id="txtcod_empleado_h" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="20" value="<?echo $cod_empleado_h?>"> </span></td>
                 <td width="47" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_trabh" type="button" id="cat_trabh" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('../Cat_trabajadores_h.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                 <td width="567" align="left"><span class="Estilo5"><input class="Estilo10" name="txtnombre_h" type="text" id="txtnombre_h" size="90" maxlength="90" readonly value="<?echo $nombre_empleh?>"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="145" align="left" class="Estilo5">CODIGO CARGO DESDE :</div></td>
                 <td width="145" align="left"><span class="Estilo5"> <input class="Estilo10" name="txtcodigo_cargo_d" type="text" id="txtcodigo_cargo_d" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" value="<?echo $codigo_cargo_d?>">  </span></td>
                 <td width="46" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_cargod" type="button" id="cat_cargod" title="Abrir Catalogo de Cargos" onClick="VentanaCentrada('../Cat_cargosd.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                 <td width="567" align="left"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion_d" type="text" id="txtdenominacion_d" size="70" maxlength="75" readonly value="<?echo $denominacion_cargod?>">  </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="145" align="left" class="Estilo5">CODIGO CARGO HASTA :</div></td>
                 <td width="145" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_cargo_h" type="text" id="txtcodigo_cargo_h" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="20" value="<?echo $codigo_cargo_h?>"> </span></td>
                 <td width="46" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_cargoh" type="button" id="cat_cargoh" title="Abrir Catalogo de Cargos" onClick="VentanaCentrada('../Cat_cargosh.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                 <td width="567" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_h" type="text" id="txtdenominacion_h" size="70" maxlength="75" readonly value="<?echo $denominacion_cargoh?>">   </span></td>
               </tr>
             </table></td>
           </tr>		   
		   <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="left" class="Estilo5">C&Oacute;DIGO DEPARTAMENTO DESDE :</td>
                 <td width="160" align="left" ><span class="Estilo5"><input class="Estilo10" name="txtcodigo_departamento_d" type="text" id="txtcodigo_departamento_d" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" value="<?echo $codigo_departamento_d?>"> </span></td>
                 <td width="49" align="left"><span class="Estilo5"><input class="Estilo10" name="Cat_depd" type="button" id="Cat_depd" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamentod.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                 <td width="499" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_dep_d" type="text" id="txtdescripcion_dep_d" size="70" maxlength="100" readonly value="<?echo $descripcion_dep_d?>">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="left" class="Estilo5">C&Oacute;DIGO DEPARTAMENTO HASTA :</td>
                 <td width="160" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_departamento_h" type="text" id="txtcodigo_departamento_h" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" value="<?echo $codigo_departamento_h?>"></span></td>
                 <td width="49" align="left"><span class="Estilo5"><input class="Estilo10" name="Cat_deph" type="button" id="Cat_deph" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamentoh.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                 <td width="499" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_dep_h" type="text" id="txtdescripcion_dep_h" size="70" maxlength="100" readonly value="<?echo $descripcion_dep_h?>"> </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="120" align="left" class="Estilo5">CONCEPTO DESDE :</td>
                 <td width="50" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto_d" type="text" id="txtcod_concepto_d" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $cod_concepto_d?>"> </span></td>
                 <td width="43" align="left"><span class="Estilo5"><input class="Estilo10" name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('../Cat_conceptosd.php?criterio=','SIA','','650','500','true')" value="..."></span></td>
                 <td width="690" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_d" type="text" id="txtdenominacion_d" size="90" maxlength="100" readonly value="<?echo $denominacion_d?>"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="120" align="left" class="Estilo5">CONCEPTO HASTA :</td>
                 <td width="50" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto_h" type="text" id="txtcod_concepto_h" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $cod_concepto_h?>"></span></td>
                 <td width="43" align="left"><span class="Estilo5"><input class="Estilo10" name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('../Cat_conceptosh.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                 <td width="690" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_h" type="text" id="txtdenominacion_h" size="90" maxlength="100" readonly value="<?echo $denominacion_h?>"> </span></td>
               </tr>
             </table></td>
           </tr>
		    <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="left" class="Estilo5">N&Uacute;MERO DE RECIBO DESDE :</td>
                 <td width="160" align="left"><span class="Estilo5"><input class="Estilo10" name="txtnum_recibo_d" type="text" id="txtnum_recibo_d" size="8" maxlength="5" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $num_rec_d?>"></span></td>
                 <td width="49" align="left"><span class="Estilo5">HASTA : </span></td>
                 <td width="499" align="left"><span class="Estilo5"><input class="Estilo10" name="txtnum_recibo_h" type="text" id="txtnum_recibo_h" size="8" maxlength="5" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $num_rec_h?>"> </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td>&nbsp;</td>
           </tr>
           <tr>
            <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
			     <td width="103"  align="left" class="Estilo5">CONCEPTOS :</td>
				 <td width="190" align="left"><span class="Estilo5"><select class="Estilo10" name="txtconcepto_t" size="1" id="txtconcepto_t"><option value='NOMINA' selected>NOMINA</option><option value='VACACIONES'>VACACIONES</option><option value='TODOS'>TODOS</option></select></span></td>
				 <td width="110"  align="left" class="Estilo5">FORMA DE PAGO :</td>				 
				 <td width="170" align="left"><span class="Estilo5"><select class="Estilo10" name="txtforma_pago" size="1" id="txtforma_pago">
                     <option selected value='TODOS'>TODOS</option> <option value ='DEPOSITO'>DEPOSITO</option><option value ='EFECTIVO'>EFECTIVO</option>
                     <option value ='CHEQUE'>CHEQUE</option> <option value ='RECIBO'>RECIBO</option></select></span></td>                
				 <td width="130"  align="left" class="Estilo5">TIPO DE C&Aacute;LCULO :</td>				 
				 <td width="200" align="left"><span class="Estilo5"><select class="Estilo10" name="txttipo_calculo" size="1" id="txttipo_calculo"> <option value='N' selected>NORMAL</option> <option value='E'>EXTRAORDINARIA</option></select>
                </span></td>
              </tr>
             </table></td>
           </tr>
           <tr>
             <td>&nbsp;</td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
			     <td width="200"  align="left" class="Estilo5">ACTIVA HISTORICO N&Oacute;MINA :</td>	
                 <td width="250" align="left"><span class="Estilo5"><select class="Estilo10" name="txtact_hist" size="1" id="txtact_hist"><option value='N' selected>NO</option> <option value='S'>SI</option></select></span></td>
				 <td width="180"  align="left" class="Estilo5">FECHA HASTA DE N&Oacute;MINA :</td>				 
				 <td width="270" align="left"><span class="Estilo5"><input class="Estilo10" name="txtfecha_nom" type="text" id="txtfecha_nom" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_nomina?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
               </tr>
             </table></td>
           </tr> 
		   <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
			     <td width="123"  align="left" class="Estilo5">RANGO DE FECHAS :</td>	
                 <td width="150" align="left"><span class="Estilo5"><select class="Estilo10" name="txtrang_fec" size="1" id="txtrang_fec"><option value='N' selected>NO</option> <option value='S'>SI</option></select></span></td>
				 <td width="150"  align="left" class="Estilo5">FECHA N&Oacute;MINA DESDE :</td>	
				 <td width="150" align="left"><span class="Estilo5"><input class="Estilo10" name="txtfecha_nomd" type="text" id="txtfecha_nomd" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_desde?>" onchange="checkrefecha(this.form)" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="150"  align="left" class="Estilo5">FECHA N&Oacute;MINA HASTA :</td>				 
				 <td width="180" align="left"><span class="Estilo5"><input class="Estilo10" name="txtfecha_nomh" type="text" id="txtfecha_nomh" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_hasta?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
               </tr>
             </table></td>
           </tr> 
           <tr><td>&nbsp;</td></tr>
           <tr>
            <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
                 <td width="160"  align="left" class="Estilo5">TIPO SALIDA REPORTE :</td>
				 <td width="180" align="left"><span class="Estilo5"><select class="Estilo10" name="tipo_rpt" id="tipo_rpt"> <option value='PDF'>FORMATO PDF</option> <option value='TXT'>FORMATO TXT</option> <option value='WORD'>FORMATO WORD</option> <option value='ARC'>FORMATO ARCHIVO PDF</option> </select></span></td>
                 <td width="110"><span class="Estilo5">ORDENADO POR : </span></td>
				 <td width="453"><table width="450" height="10" border="1" cellspacing="0" >
					<tr>
					  <td width="450"  class="Estilo5">
						  <p>
							<label><input class="Estilo10" name="optipo" type="radio" value="REC" checked> </label><label>RECIBO</label>
							<input class="Estilo10" name="optipo" type="radio" value="COD"> <label>TRABAJADOR</label>
							<input class="Estilo10" name="optipo" type="radio" value="CAT"> <label>CATEGORIA</label>
							<input class="Estilo10" name="optipo" type="radio" value="UBI"> <label>UBICACION</label>
							<input class="Estilo10" name="optipo" type="radio" value="NOM"> <label>NOMBRE</label>
						  </p>
					  </td>
					</tr>
				  </table></td>
			 </tr>
             </table></td>
           </tr>
           <tr><td>&nbsp;</td></tr>
           <tr>
             <td><table width="905">
               <tr>
                 <th width="446" scope="col"><div align="center"><input name="btgenerar" type="button" id="btgenerar" value="GENERAR" onClick="javascript:Llama_Rpt_reci_pago_rn('Rpt_reci_pago_rn.php');"> </div></th>
                 <th width="447" scope="col"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></th>
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
