<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="03-0000127"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
   $tipo_nominad=""; $tipo_nominah="zz";   $cod_empleado_d=""; $cod_empleado_h="";  $cedula_d=""; $cedula_h="zzzzzzzz";
   $sexo="";  $estado_civil="";  $fecha_d="01/01/1900";  $fecha_h="31/12/9999";
   $edad_d="0";  $edad_h="99";  $estatus="";  $codigo_cargo_d="";   $codigo_cargo_h="zzzzzzzz";   $codigo_departamentod="";  $codigo_departamentoh="zzzzzzzz";
   $fecha_ingreso_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_ingreso_h=formato_ddmmaaaa($Fec_Fin_Ejer);  
   $fecha_ingreso_d="01/01/1900";  $fecha_ingreso_h="31/12/9999"; $inf_per="";  $inf_car="";
 if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Reporte Informacion Familiar del Trabajador)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="../../class/cal2.js"></script>
<script language="javascript" src="../../class/cal_conf2.js"></script>
<script language="JavaScript" type="text/JavaScript">
function checkrefechad(mform){var mref;var mfec;
  mref=mform.txtFechad.value;
  if(mform.txtFechad.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtFechad.value=mfec;}
return true;}
function checkrefechah(mform){var mref;var mfec;
  mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtFechah.value=mfec;}
return true;}
function checkfechaingd(mform){var mref;var mfec;
  mref=mform.txtFechaingresod.value;
  if(mform.txtFechaingresod.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtFechaingresod.value=mfec;}
return true;}
function checkfechaingh(mform){var mref;var mfec;
  mref=mform.txtFechaingresoh.value;
  if(mform.txtFechaingresoh.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtFechaingresoh.value=mfec;}
return true;}

function Llama_Rpt_info_fami_mp_mit(murl){var url; var r; 
  r=confirm("Desea Generar el Reporte Informacion Familiar del Trabajador?");
  if (r==true) {url=murl+"?tipo_nominad="+document.form1.txttipo_nomina_d.value+"&tipo_nominah="+document.form1.txttipo_nomina_h.value+
  "&cod_empleado_d="+document.form1.txtcod_empleado_d.value+"&cod_empleado_h="+document.form1.txtcod_empleado_h.value+
  "&cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&sexo="+document.form1.txt_sexo.value+
  "&estado_civil="+document.form1.txt_edocivil.value+ "&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+
  "&edad_d="+document.form1.txtedad_d.value+"&edad_h="+document.form1.txtedad_h.value+"&fecha_ingreso_d="+document.form1.txtFechaingresod.value+
  "&fecha_ingreso_h="+document.form1.txtFechaingresoh.value+"&estatus="+document.form1.txt_estatus.value+
  "&codigo_cargo_d="+document.form1.txtcodigo_cargo_d.value+"&codigo_cargo_h="+document.form1.txtcodigo_cargo_h.value+
  "&codigo_departamentod="+document.form1.txtcodigo_departamento_d.value+"&codigo_departamentoh="+document.form1.txtcodigo_departamento_h.value+
  "&parentesco="+document.form1.txtparentesco.value+"&tipo_rpt="+document.form1.tipo_rpt.value;   
   window.open(url,"Reporte Informacion Familiar del Trabajador")
  }
}
function Llama_Menu_Rpt(murl){var url;    url="../"+murl;  LlamarURL(url);}
</script>


</head>
<?
$sql="SELECT MAX(tipo_nomina) As Max_tipo_nomina, MIN(tipo_nomina) As Min_tipo_nomina FROM nom001 ".$criterion." ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$tipo_nomina_d=$registro["min_tipo_nomina"]; $tipo_nomina_h=$registro["max_tipo_nomina"];   }
$sql="SELECT MAX(cod_empleado) As Max_cod_empleado, MIN(cod_empleado) As Min_cod_empleado FROM nom006 ".$criterion." ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $cod_empleado_d=$registro["min_cod_empleado"]; $cod_empleado_h=$registro["max_cod_empleado"];   }
$sql="SELECT MAX(cedula) As Max_cedula, MIN(cedula) As Min_cedula FROM NOM006 ".$criterion." ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cedula_d=$registro["min_cedula"]; $cedula_h=$registro["max_cedula"]; }
$sql="SELECT MAX(codigo_cargo) As Max_codigo_cargo, MIN(codigo_cargo) As Min_codigo_cargo FROM nom004 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$codigo_cargo_d=$registro["min_codigo_cargo"]; $codigo_cargo_h=$registro["max_codigo_cargo"];   }
$sql="SELECT MAX(codigo_departamento) As Max_codigo_departamento, MIN(codigo_departamento) As Min_codigo_departamento FROM nom005 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $codigo_departamento_d=$registro["min_codigo_departamento"]; $codigo_departamento_h=$registro["max_codigo_departamento"];   }
?>
</head>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6"> REPORTE DE INFORMACION FAMILIAR DEL TRABAJADOR  </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="599" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="595"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:520px; height:94px; z-index:1; top: 61px; left: 42px;">
         <table width="828" border="0" align="center" >
           <tr>
             <td><table width="898">
               <tr>
                 <td width="401"><div align="left"></div></td>
                 <td width="141"><div align="left"><span class="Estilo13">CRITERIOS</span></div></td>
                 <td width="173"><div align="left"></div></td>
                 <td width="163">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
		   <tr><td>&nbsp;</td></tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="182"><div align="right"><span class="Estilo5">TIPO DE NOMINA:</span></div></td>
                 <td width="30"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina_d" type="text" id="txttipo_nomina_d" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_d?>">  </span></div></td>
                 <td width="231"><span class="Estilo5"> <input class="Estilo10" name="Catalogo1" type="button" id="Catalogo1" title="Abrir Catalogo Tipos de n&oacute;minas" onClick="VentanaCentrada('../Cat_tipo_nomina_d.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                 <td width="58" class="Estilo5">HASTA : </td>
                 <td width="29"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina_h" type="text" id="txttipo_nomina_h" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_h?>">  </span></td>
                 <td width="347"><span class="Estilo5"> <input class="Estilo10" name="Catalogo2" type="button" id="Catalogo2" title="Abrir Catalogo Tipos de n&oacute;minas" onClick="VentanaCentrada('../Cat_tipo_nomina_h.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td height="34"><table width="905">
               <tr>
                 <td width="180"><div align="right"><span class="Estilo5">CODIGO TRABAJADOR DESDE:</span></div></td>
                 <td width="142"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado_d" type="text" id="txtcod_empleado_d" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="15" value="<?echo $cod_empleado_d?>">   </span></div></td>
                 <td width="123"><span class="Estilo5"> <input class="Estilo10" name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('../Cat_trabajadoresd.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                 <td width="54"><span class="Estilo5">HASTA :</span></td>
                 <td width="137"><span class="Estilo5"> <input class="Estilo10" name="txtcod_empleado_h" type="text" id="txtcod_empleado_h" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="20" value="<?echo $cod_empleado_h?>"> </span></td>
                 <td width="241"><span class="Estilo5"><input class="Estilo10" name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('../Cat_trabajadoresh.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="180"><div align="right"><span class="Estilo5">CEDULA TRABAJADOR DESDE:</span></div></td>
                 <td width="94"><div align="left"><span class="Estilo5"> <input class="Estilo10" name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $cedula_d?>">  </span></div></td>
                 <td width="171"><span class="Estilo5"> <input class="Estilo10" name="Catalogo5" type="button" id="Catalogo5" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_cedulasd.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                 <td width="56" class="Estilo5">HASTA : </td>
                 <td width="94"><span class="Estilo5"> <input class="Estilo10" name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $cedula_h?>">  </span></td>
                 <td width="282"><span class="Estilo5"><input class="Estilo10" name="Catalogo6" type="button" id="Catalogo6" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_cedulash.php?criterio=','SIA','','650','500','true')" value="..."></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="906">
               <tr>
                 <td width="180"><div align="right"><span class="Estilo5">SEXO:</span></div></td>
                 <td width="445"><div align="left"><span class="Estilo5">   <select class="Estilo10" name="txt_sexo"> <option value="TODOS">TODOS</option> <option value="MASCULINO">MASCULINO</option> <option value="FEMENINO">FEMENINO</option>  </select></span></div></td>
                 <td width="265">&nbsp;</td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="906">
               <tr>
                 <td width="181"><div align="right"><span class="Estilo5">ESTADO CIVIL:</span></div></td>
                  <td width="713"><div align="left"><span class="Estilo5">  <select class="Estilo10" name="txt_edocivil">   <option value="TODOS">TODOS</option>
				     <option value="SOLTERO">SOLTERO</option> <option value="SOLTERA">SOLTERA</option>  <option value="CASADO">CASADO</option> <option value="CASADA">CASADA</option> <option value="VIUDO">VIUDO</option> <option value="VIUDA">VIUDA</option>  <option value="DIVORCIADO">DIVORCIADO</option>  <option value="DIVORCIADA">DIVORCIADA</option> <option value="CONCUBINO">CONCUBINO</option> <option value="CONCUBINA">CONCUBINA</option>  <option value="OTROS">OTROS</option>  </select></span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="182"><div align="right"><span class="Estilo5">FECHA NACIMIENTO DESDE:</span></div></td>
                 <td width="269"><div align="left"><span class="Estilo5">  <input class="Estilo10" name="txtFechad" type="text" id="txtFechad" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkrefechad(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario1" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario1')"  /></span></div></td>
                 <td width="56"><span class="Estilo5">HASTA :</span></td>
                 <td width="378"><span class="Estilo5"><input class="Estilo10" name="txtFechah" type="text" id="txtFechah" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkrefechah(this.form)">
                  <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario2" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario2')"  /> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="182"><div align="right"><span class="Estilo5">EDAD DESDE:</span></div></td>
                 <td width="269"><div align="left"><span class="Estilo5">
                     <input class="Estilo10" name="txtedad_d" type="text" id="txtedad_d" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $edad_d?>"> </span></div></td>
                 <td width="56"><span class="Estilo5">HASTA :</span></td>
                 <td width="378"><span class="Estilo5"><input class="Estilo10" name="txtedad_h" type="text" id="txtedad_h" size="5" maxlength="15"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $edad_h?>">
                  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="180"><div align="right"><span class="Estilo5">FECHA INGRESO:</span></div></td>
                 <td width="272"><div align="left"><span class="Estilo5">  <input class="Estilo10" name="txtFechaingresod" type="text" id="txtFechaingresod" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkfechaingd(this.form)">
                     <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario9" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario9')"  />  </span></div></td>
                 <td width="57"><span class="Estilo5">HASTA :</span></td>
                 <td width="376"><span class="Estilo5"> <input class="Estilo10" name="txtFechaingresoh" type="text" id="txtFechaingresoh" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkfechaingh(this.form)">
                   <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario10" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario10')"  /> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="176"><div align="right"><span class="Estilo5">ESTATUS :</span></div></td>
                 <td width="718"><div align="left"><span class="Estilo5"> <select class="Estilo10" name="txt_estatus">  <option value="TODOS">TODOS</option>
                       <option value="ACTIVO">ACTIVO</option>  <option value="AÑO SABATICO">A&Ntilde;O SABATICO</option>  <option value="DESPEDIDO">DESPEDIDO</option>
                       <option value="FALLECIDO">FALLECIDO</option> <option value="INACTIVO">INACTIVO</option>  <option value="JUBILADO">JUBILADO</option>
                       <option value="PERMISO RE">PERMISO RE</option>  <option value="PERMISO NO">PERMISO NO</option> <option value="PENSIONADO">PENSIONADO</option>
                       <option value="REPOSO">REPOSO</option>  <option value="RENUNCIA">RENUNCIA</option><option value="RETIRADO">RETIRADO</option>
                       <option value="SUSPENDIDO">SUSPENDIDO</option>  <option value="VACACIONES">VACACIONES</option> <option value="VACANTE">VACANTE</option>
                       <option value="ACTIVO/VACACIONES/REPOSO">ACTIVO/VACACIONES/REPOSO</option> <option value="ACTIVO/VACACIONES/PERMISO">ACTIVO/VACACIONES/PERMISO</option>
                     </select> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="178"><div align="right"><span class="Estilo5">CODIGO CARGO DESDE:</span></div></td>
                 <td width="91"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_cargo_d" type="text" id="txtcodigo_cargo_d" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $codigo_cargo_d?>"> </span></div></td>
                 <td width="178"><span class="Estilo5"><input class="Estilo10" name="cat_car_d" type="button" id="cat_car_d" title="Abrir Catalogo de Cargos" onClick="VentanaCentrada('../Cat_cargos_d.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                 <td width="57"><span class="Estilo5">HASTA :</span></td>
                 <td width="93"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_cargo_h" type="text" id="txtcodigo_cargo_h" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $codigo_cargo_h?>"> </span></td>
                 <td width="280"><span class="Estilo5"><input class="Estilo10" name="cat_car_h" type="button" id="cat_car_h" title="Abrir Catalogo de Cargos" onClick="VentanaCentrada('../Cat_cargos_h.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="177"><div align="right"><span class="Estilo5">CODIGO DEPARTAMENTO:</span></div></td>
                 <td width="174"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_departamento_d" type="text" id="txtcodigo_departamento_d" onFocus="encender(this)" onBlur="apagar(this)" size="25" maxlength="25" value="<?echo $codigo_departamento_d?>"> </span></div></td>
                 <td width="95"><span class="Estilo5"> <input class="Estilo10" name="cat_dep_d" type="button" id="cat_dep_d" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamento_d.php?criterio=','SIA','','650','500','true')" value="..."></span></td>
                 <td width="56"><span class="Estilo5">HASTA :</span></td>
                 <td width="174"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_departamento_h" type="text" id="txtcodigo_departamento_h" onFocus="encender(this)" onBlur="apagar(this)" size="25" maxlength="25" value="<?echo $codigo_departamento_h?>">  </span></td>
                 <td width="201"><span class="Estilo5"><input class="Estilo10" name="cat_dep_h" type="button" id="cat_dep_h" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamento_h.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="176"><div align="right"><span class="Estilo5">PARENTESCO :</span></div></td>
                 <td width="718"><div align="left"><span class="Estilo5"> <select class="Estilo10" name="txtparentesco">  <option value="TODOS">TODOS</option>  <option value="SOLO">SOLO HIJOS</option>
                   <option>HIJO</option>  <option>HIJO GUARD</option>  <option>HIJA</option> <option>HIJA GUARD</option> <option>ESPOSO</option>  <option>ESPOSA</option> <option>MADRE</option> <option>PADRE</option> <option>CONYUGE</option>
                   <option>NIETO</option> <option>NIETA</option> <option>ABUELO</option> <option>ABUELA</option> <option>HERMANO</option> <option>HERMANA</option> 
				   <option>PRIMO</option> <option>PRIMA</option> <option>SOBRINO</option> <option>SOBRINA</option> <option>TIO</option> <option>TIA</option>
                 </select> </span></div></td>
               </tr>
             </table></td>
           </tr>
		   <tr><td>&nbsp;</td></tr>
		   <tr>
            <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0" >
               <tr>
                 <td width="200"  align="left" class="Estilo5">TIPO SALIDA DEL REPORTE :</td>
				 <td width="700" align="left"><span class="Estilo5"><select class="Estilo10" name="tipo_rpt" id="tipo_rpt"> <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option> <option value='EXCEL'>FORMATO EXCEL</option> </select></span></td>
              </tr>
             </table></td>
           </tr>
           <script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
           
           <tr><td>&nbsp;</td></tr>
           <tr><td>&nbsp;</td></tr>
           <tr>
             <td><table width="905">
               <tr>
                 <th width="446" scope="col"><div align="center"><input name="btgenerar" type="button" id="btgenerar" value="GENERAR" onClick="javascript:Llama_Rpt_info_fami_mp_mit('Rpt_info_fami_mp_mit.php');">   </div></th>
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
