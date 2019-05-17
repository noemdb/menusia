<?include ("../../class/seguridad.inc");include ("../../class/conects.php");  include ("../../class/funciones.php");include ("../../class/configura.inc");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="03-0000115"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}
 $tipo_nominad=""; $tipo_nominah="zz";   $cod_empleado_d=""; $cod_empleado_h="";  $cedula_d=""; $cedula_h="zzzzzzzz";
 $sexo="";  $estado_civil="";  $fecha_d="01/01/1900";  $fecha_h="31/12/9999"; $fecha_ingreso_d="01/01/1900";  $fecha_ingreso_h="31/12/9999"; 
 $edad_d="0";  $edad_h="99";  $estatus="";  $codigo_cargo_d="";   $codigo_cargo_h="zzzzzzzz";   $codigo_departamentod="";  $codigo_departamentoh="zzzzzzzz";
 $tipo_personal_d=""; $tipo_personal_h="zzzzzzzzzz";
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL (Reporte Listado de Trabajadores con Criterio )</title>
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
function checkrefechah(mform){var mref;var mfec;   mref=mform.txtFechah.value;
  if(mform.txtFechah.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7);  mform.txtFechah.value=mfec;}
return true;}
function checkfechaingd(mform){var mref;var mfec;  mref=mform.txtFechaingresod.value;
  if(mform.txtFechaingresod.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtFechaingresod.value=mfec;}
return true;}
function checkfechaingh(mform){var mref;var mfec;  mref=mform.txtFechaingresoh.value;
  if(mform.txtFechaingresoh.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtFechaingresoh.value=mfec;}
return true;}
function checkfechaegd(mform){var mref;var mfec;   mref=mform.txtFechaegresod.value;
  if(mform.txtFechaegresod.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtFechaegresod.value=mfec;}
return true;}
function checkfechaeh(mform){var mref;var mfec;  mref=mform.txtFechaegresoh.value;
  if(mform.txtFechaegresoh.value.length==8){ mfec = mref.substring (0, 6) + "20" + mref.charAt(6)+mref.charAt(7); mform.txtFechaegresoh.value=mfec;}
return true;}
function Llama_Rpt_list_traj_cri(murl){var url; var r; 
  r=confirm("Desea Generar el Reporte Listado de Trabajadores con Criterios ?");
  if (r==true) {url=murl+"?tipo_nominad="+document.form1.txttipo_nomina_d.value+"&tipo_nominah="+document.form1.txttipo_nomina_h.value+
  "&cod_empleado_d="+document.form1.txtcod_empleado_d.value+"&cod_empleado_h="+document.form1.txtcod_empleado_h.value+
  "&cedula_d="+document.form1.txtcedula_d.value+"&cedula_h="+document.form1.txtcedula_h.value+"&sexo="+document.form1.txt_sexo.value+
  "&estado_civil="+document.form1.txt_edocivil.value+ "&fecha_d="+document.form1.txtFechad.value+"&fecha_h="+document.form1.txtFechah.value+
  "&edad_d="+document.form1.txtedad_d.value+"&edad_h="+document.form1.txtedad_h.value+"&fecha_ingreso_d="+document.form1.txtFechaingresod.value+
  "&fecha_ingreso_h="+document.form1.txtFechaingresoh.value+"&estatus="+document.form1.txt_estatus.value+  
  "&codigo_cargo_d="+document.form1.txtcodigo_cargo_d.value+"&codigo_cargo_h="+document.form1.txtcodigo_cargo_h.value+
  "&codigo_departamentod="+document.form1.txtcodigo_departamento_d.value+"&codigo_departamentoh="+document.form1.txtcodigo_departamento_h.value+
  "&tipo_personal_d="+document.form1.txttipo_personal_d.value+"&tipo_personal_h="+document.form1.txttipo_personal_h.value+
  "&fecha_egreso_d="+document.form1.txtFechaegresod.value+"&fecha_egreso_h="+document.form1.txtFechaegresoh.value+
  "&ordenado="+document.form1.txtordenado.value+"&columna1="+document.form1.txtcolumna1.value+"&columna2="+document.form1.txtcolumna2.value+
  "&columna3="+document.form1.txtcolumna3.value+"&columna4="+document.form1.txtcolumna4.value+"&columna5="+document.form1.txtcolumna5.value+
  "&columna6="+document.form1.txtcolumna6.value+"&columna7="+document.form1.txtcolumna7.value+"&columna8="+document.form1.txtcolumna8.value+
  "&mesnac_d="+document.form1.txtmesnac_d.value+"&mesnac_h="+document.form1.txtmesnac_h.value+"&tipo_rpt="+document.form1.tipo_rpt.value; 
  window.open(url,"Reporte Listado de Trabajadores");
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
$sql="SELECT MAX(cod_tipo_personal) As max_tipo_personal, MIN(cod_tipo_personal) As min_tipo_personal FROM nom015 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $tipo_personal_d=$registro["min_tipo_personal"]; $tipo_personal_h=$registro["max_tipo_personal"];   }
?>
<body>
<table width="980" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="76"><div align="center" class="Estilo2 Estilo4"><img src="../../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="650"><div align="center" class="Estilo2 Estilo6"> REPORTE LISTADO TRABAJADORES CON CRITERIOS</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="980" height="775" border="1" id="tablacuerpo">
  <tr>
   <td width="888" height="770"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
         <form name="form1" method="post" action="">
       <div id="Layer1" style="position:absolute; width:754px; height:94px; z-index:1; top: 61px; left: 42px;">
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
		   <tr>
             <td><table width="905">
               <tr>
                 <td width="182"><div align="right"><span class="Estilo5">TIPO DE NOMINA:</span></div></td>
                 <td width="30"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina_d" type="text" id="txttipo_nomina_d" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_d?>">  </span></div></td>
                 <td width="231"><span class="Estilo5"> <input class="Estilo10" name="Catalogo1" type="button" id="Catalogo14" title="Abrir Catalogo Tipos de n&oacute;minas" onClick="VentanaCentrada('../Cat_tipo_nomina_d.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                 <td width="58" class="Estilo5">HASTA : </td>
                 <td width="29"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina_h" type="text" id="txttipo_nomina_h" onFocus="encender(this)" onBlur="apagar(this)" size="2" maxlength="2" value="<?echo $tipo_nomina_h?>">  </span></td>
                 <td width="347"><span class="Estilo5"> <input class="Estilo10" name="Catalogo2" type="button" id="Catalogo25" title="Abrir Catalogo Tipos de n&oacute;minas" onClick="VentanaCentrada('../Cat_tipo_nomina_h.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="180"><div align="right"><span class="Estilo5">CODIGO TRABAJADOR DESDE:</span></div></td>
                 <td width="142"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado_d" type="text" id="txtcod_empleado_d" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="15" value="<?echo $cod_empleado_d?>">   </span></div></td>
                 <td width="123"><span class="Estilo5"> <input class="Estilo10" name="Catalogo3" type="button" id="Catalogo36" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('../Cat_trabajadoresd.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                 <td width="54"><span class="Estilo5">HASTA :</span></td>
                 <td width="137"><span class="Estilo5"> <input class="Estilo10" name="txtcod_empleado_h" type="text" id="txtcod_empleado_h" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="20" value="<?echo $cod_empleado_h?>"> </span></td>
                 <td width="241"><span class="Estilo5"><input class="Estilo10" name="Catalogo4" type="button" id="Catalogo43" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('../Cat_trabajadoresh.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="180"><div align="right"><span class="Estilo5">CEDULA TRABAJADOR DESDE:</span></div></td>
                 <td width="94"><div align="left"><span class="Estilo5"> <input class="Estilo10" name="txtcedula_d" type="text" id="txtcedula_d" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $cedula_d?>">  </span></div></td>
                 <td width="171"><span class="Estilo5"> <input class="Estilo10" name="Catalogo5" type="button" id="Catalogo55" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_cedulasd.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                 <td width="56" class="Estilo5">HASTA : </td>
                 <td width="94"><span class="Estilo5"> <input class="Estilo10" name="txtcedula_h" type="text" id="txtcedula_h" onFocus="encender(this)" onBlur="apagar(this)" size="12" maxlength="12" value="<?echo $cedula_h?>">  </span></td>
                 <td width="282"><span class="Estilo5"><input class="Estilo10" name="Catalogo6" type="button" id="Catalogo64" title="Abrir Catalogo de C&eacute;dula" onClick="VentanaCentrada('../Cat_cedulash.php?criterio=','SIA','','650','500','true')" value="..."></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="905">
               <tr>
                 <td width="180"><div align="right"><span class="Estilo5">SEXO:</span></div></td>
                 <td width="270"><div align="left"><span class="Estilo5"> <select class="Estilo10" name="txt_sexo"> <option value="TODOS">TODOS</option> <option value="MASCULINO">MASCULINO</option> <option value="FEMENINO">FEMENINO</option> </select></span></div></td>
                 <td width="100"><span class="Estilo5">ESTADO CIVIL:</span></td>
                 <td width="338"><div align="left"><span class="Estilo5">  <select class="Estilo10" name="txt_edocivil">   <option value="TODOS">TODOS</option>
				     <option value="SOLTERO">SOLTERO</option> <option value="SOLTERA">SOLTERA</option>  <option value="CASADO">CASADO</option> <option value="CASADA">CASADA</option> <option value="VIUDO">VIUDO</option> <option value="VIUDA">VIUDA</option>  <option value="DIVORCIADO">DIVORCIADO</option>  <option value="DIVORCIADA">DIVORCIADA</option> <option value="CONCUBINO">CONCUBINO</option> <option value="CONCUBINA">CONCUBINA</option>  <option value="OTROS">OTROS</option>  </select></td>
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
                 <td width="182"><div align="right"><span class="Estilo5">MES NACIMIENTO DESDE:</span></div></td>
                 <td width="269"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtmesnac_d" type="text" id="txtmesnac_d" size="5" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" value="1"> </span></div></td>
                 <td width="56"><span class="Estilo5">HASTA :</span></td>
                 <td width="378"><span class="Estilo5"><input class="Estilo10" name="txtmesnac_h" type="text" id="txtmesnac_h" size="5" maxlength="2"  onFocus="encender(this)" onBlur="apagar(this)" value="12">   </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="905">
               <tr>
                 <td width="182"><div align="right"><span class="Estilo5">EDAD DESDE:</span></div></td>
                 <td width="269"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtedad_d" type="text" id="txtedad_d" size="5" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $edad_d?>"> </span></div></td>
                 <td width="56"><span class="Estilo5">HASTA :</span></td>
                 <td width="378"><span class="Estilo5"><input class="Estilo10" name="txtedad_h" type="text" id="txtedad_h" size="5" maxlength="5"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $edad_h?>">
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
                 <td width="174"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_departamento_d" type="text" id="txtcodigo_departamento_d" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="20" value="<?echo $codigo_departamento_d?>"> </span></div></td>
                 <td width="95"><span class="Estilo5"> <input class="Estilo10" name="cat_dep_d" type="button" id="cat_dep_d" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamento_d.php?criterio=','SIA','','650','500','true')" value="..."></span></td>
                 <td width="56"><span class="Estilo5">HASTA :</span></td>
                 <td width="174"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_departamento_h" type="text" id="txtcodigo_departamento_h" onFocus="encender(this)" onBlur="apagar(this)" size="20" maxlength="20" value="<?echo $codigo_departamento_h?>">  </span></td>
                 <td width="201"><span class="Estilo5"><input class="Estilo10" name="cat_dep_h" type="button" id="cat_dep_h" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('../Cat_departamento_h.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="905">
               <tr>
				<td width="177"><div align="right"><span class="Estilo5">TIPO DE PERSONAL:</span></div></td>
				<td width="95"><div align="left"><span class="Estilo5"><input class="Estilo10" name="txttipo_personal_d" type="text" id="txttipo_personal_d" onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="10" value="<?echo $tipo_personal_d?>"></span></div></td> 
				<td width="174"><span class="Estilo5"> <input class="Estilo10" name="cat_tipo_persd" type="button" id="cat_tipo_persd" title="Abrir Catalogo Tipo de Personal" onClick="VentanaCentrada('../Cat_tipo_personal_d.php?criterio=','SIA','','650','500','true')" value="..."></span></td>
				<td width="56"><span class="Estilo5">HASTA :</span></td>                 
				<td width="94"><span class="Estilo5"><input class="Estilo10" name="txttipo_personal_h" type="text" id="txttipo_personal_h" onFocus="encender(this)" onBlur="apagar(this)" size="10" maxlength="10" value="<?echo $tipo_personal_h?>"></span></span></td>
				<td width="281"><span class="Estilo5"><input class="Estilo10" name="cat_tipo_persh" type="button" id="cat_tipo_persh" title="Abrir Catalogo Tipo de Personal" onClick="VentanaCentrada('../Cat_tipo_personal_h.php?criterio=','SIA','','650','500','true')" value="..."></span></td>
			  </tr>
		    </table></td>
		   </tr>
		   <tr>
             <td><table width="905">
               <tr>
                 <td width="180"><div align="right"><span class="Estilo5">FECHA EGRESO:</span></div></td>
                 <td width="272"><div align="left"><span class="Estilo5">  <input class="Estilo10" name="txtFechaegresod" type="text" id="txtFechaegresod" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkfechaegd(this.form)">
                     <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario11" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario11')"  />  </span></div></td>
                 <td width="57"><span class="Estilo5">HASTA :</span></td>
                 <td width="376"><span class="Estilo5"> <input class="Estilo10" name="txtFechaegresoh" type="text" id="txtFechaegresoh" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkfechaegh(this.form)">
                   <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario12" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario12')"  /> </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="905">
               <tr>
                 <td width="180"><div align="right"><span class="Estilo5">FECHA FIN CONTRATO:</span></div></td>
                 <td width="272"><div align="left"><span class="Estilo5">  <input class="Estilo10" name="txtFechafincod" type="text" id="txtFechafincod" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_d?>" size="12" maxlength="10" onChange="checkfechaegd(this.form)">
                     <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario13" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario13')"  />  </span></div></td>
                 <td width="57"><span class="Estilo5">HASTA :</span></td>
                 <td width="376"><span class="Estilo5"> <input class="Estilo10" name="txtFechafincoh" type="text" id="txtFechafincoh" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_h?>" size="12" maxlength="10" onChange="checkfechaegh(this.form)">
                   <img src="../../imagenes/img_cal.png" width="20" height="14" id="calendario14" style="cursor: pointer; border: 1px solid blue;" title="Seleccionar Fecha"
                onMouseOver="this.style.background='blue';" onMouseOut="this.style.background=''"  onClick="javascript:showCal('Calendario14')"  /> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr><td>&nbsp;</td></tr>
		   <tr>
             <td><table width="905">
               <tr>
                 <td width="265"><div align="right"><span class="Estilo5">MOSTRAR INFORMACION ORDENADO POR :</span></div></td>
                 <td width="200"><div align="left"><span class="Estilo5"><select class="Estilo10" name="txtordenado">
					   <option selected value="nom006.cod_empleado">CODIGO</option>  <option value="nom006.cedula">CEDULA</option>  <option value="nom006.nombre">NOMBRE</option>
                       <option value="col1">COLUMNA1</option><option value="col2">COLUMNA2</option>
                       <option value="col3">COLUMNA3</option>   <option value="col4">COLUMNA4</option></select>  </span></div></td>
			     <td width="170" class="Estilo5">TIPO SALIDA DEL REPORTE :</td>
				 <td width="270"><span class="Estilo5"> <select class="Estilo10" name="tipo_rpt" id="tipo_rpt">
				     <option value='HTML'>FORMATO HTML</option><option value='PDF'>FORMATO PDF</option><option value='EXCEL'>FORMATO EXCEL</option> </select></span></td>
               </tr>
             </table></td>
           </tr>
		   <script language="JavaScript" type="text/JavaScript">var mpdf_rpt='<?php echo $pdf_rpt ?>';if(mpdf_rpt=="SI"){document.form1.tipo_rpt.options[1].selected = true;}else{document.form1.tipo_rpt.options[0].selected = true;} </script>
           
		   <tr><td>&nbsp;</td></tr>
		   <tr>
             <td><table width="905">
               <tr>
                <td width="190"><div align="right"><span class="Estilo5">CAMPOS COLUMNA  N&ordm;. 1 :</span></div></td>
                <td width="260"><div align="left"><span class="Estilo5">
                     <select class="Estilo10" name="txtcolumna1"> <option selected value="00">NINGUNO</option>
                       <option value="01">CEDULA</option>  <option value="02">NACIONALIDAD</option> <option value="03">RIF EMPLEADO</option>
                       <option value="04">FECHA DE INGRESO</option> <option value="05">ESTATUS</option>
                       <option value="06">TIPO DE N&Oacute;MINA</option> <option value="07">C&Oacute;DIGO CATEGORIA</option>
                       <option value="08">TIPO DE PAGO</option> <option value="09">CTA. DEL TRABAJADOR</option>
                       <option value="10">CTA. DE LA EMPRESA</option> <option value="11">SEXO</option>
                       <option value="12">ESTADO CIVIL</option>  <option value="13">FECHA DE NACIMIENTO </option>
                       <option value="14">EDAD </option> <option value="15">DIRECCI&Oacute;N </option>
                       <option value="16">TELEFONO</option> <option value="17">E-MAIL</option>
                       <option value="18">PROFESI&Oacute;N</option> <option value="19">GRADO DE INSTRUCI&Oacute;N</option>
                       <option value="20">C&Oacute;DIGO DEL CARGO</option> <option value="21">DESCRIPCI&Oacute;N DEL CARGO</option>
                       <option value="22">C&Oacute;DIGO DEL DEPARTAMENTO</option> <option value="23">DESCRIPCI&Oacute;N DEL DEPARTAMENTO</option>
                       <option value="24">FECHA DE ASIGNACI&Oacute;N</option> <option value="25">SUELDO DEL CARGO</option>
                       <option value="26">COMPENSACI&Oacute;N DEL CARGO</option> <option value="27">SUELDO+COMPENSACI&Oacute;N</option>
                       <option value="28">GRADO </option>  <option value="29">PASO</option>
                       <option value="30">TIPO DE PERSONAL</option> <option value="31">DESCRIPCI&Oacute;N DEL TIPO DE PERSONAL</option>
                       <option value="32">FECHA DE EGRESO</option> <option value="33">FECHA DE INGRESO ADM. PUBLICA</option>
					   <option value="34">C&Oacute;DIGO UBICACION</option><option value="35">DESCRIPCION UBICACION</option>
					   <option value="36">TELEFONO MOVIL</option>	   <option value="37">DIAS DE TRABAJO</option>
					   <option value="38">DIA NACIMIENTO</option>	   <option value="39">MES NACIMIENTO</option>
					   <option value="40">PRIMA DEL CARGO</option>   <option value="41">SUELDO INTEGRAL DEL CARGO</option>
					   <option value="42">ESTADO</option> <option value="43">MUNICIPIO</option> <option value="44">CIUDAD</option> <option value="45">PARROQUIA</option>
                     </select> </span></div></td>
				<td width="190"><div align="right"><span class="Estilo5">CAMPOS COLUMNA  N&ordm;. 2 :</span></div></td>
                <td width="260"><div align="left"><span class="Estilo5">
                     <select class="Estilo10" name="txtcolumna2"> <option selected value="00">NINGUNO</option>
                       <option value="01">CEDULA</option>  <option value="02">NACIONALIDAD</option> <option value="03">RIF EMPLEADO</option>
                       <option value="04">FECHA DE INGRESO</option> <option value="05">ESTATUS</option>
                       <option value="06">TIPO DE N&Oacute;MINA</option> <option value="07">C&Oacute;DIGO CATEGORIA</option>
                       <option value="08">TIPO DE PAGO</option> <option value="09">CTA. DEL TRABAJADOR</option>
                       <option value="10">CTA. DE LA EMPRESA</option> <option value="11">SEXO</option>
                       <option value="12">ESTADO CIVIL</option>  <option value="13">FECHA DE NACIMIENTO </option>
                       <option value="14">EDAD </option> <option value="15">DIRECCI&Oacute;N </option>
                       <option value="16">TELEFONO</option> <option value="17">E-MAIL</option>
                       <option value="18">PROFESI&Oacute;N</option> <option value="19">GRADO DE INSTRUCI&Oacute;N</option>
                       <option value="20">C&Oacute;DIGO DEL CARGO</option> <option value="21">DESCRIPCI&Oacute;N DEL CARGO</option>
                       <option value="22">C&Oacute;DIGO DEL DEPARTAMENTO</option> <option value="23">DESCRIPCI&Oacute;N DEL DEPARTAMENTO</option>
                       <option value="24">FECHA DE ASIGNACI&Oacute;N</option> <option value="25">SUELDO DEL CARGO</option>
                       <option value="26">COMPENSACI&Oacute;N DEL CARGO</option> <option value="27">SUELDO+COMPENSACI&Oacute;N</option>
                       <option value="28">GRADO </option>  <option value="29">PASO</option>
                       <option value="30">TIPO DE PERSONAL</option> <option value="31">DESCRIPCI&Oacute;N DEL TIPO DE PERSONAL</option>
                       <option value="32">FECHA DE EGRESO</option> <option value="33">FECHA DE INGRESO ADM. PUBLICA</option>
					   <option value="34">C&Oacute;DIGO UBICACION</option><option value="35">DESCRIPCION UBICACION</option>
					   <option value="36">TELEFONO MOVIL</option>	  <option value="37">DIAS DE TRABAJO</option>
					   <option value="38">DIA NACIMIENTO</option>	   <option value="39">MES NACIMIENTO</option>
					   <option value="40">PRIMA DEL CARGO</option>   <option value="41">SUELDO INTEGRAL DEL CARGO</option>
					   <option value="42">ESTADO</option> <option value="43">MUNICIPIO</option> <option value="44">CIUDAD</option> <option value="45">PARROQUIA</option>
                     </select> </span></div></td>
               </tr>
             </table></td>
           </tr>
		   
		    <tr>
             <td><table width="905">
               <tr>
                <td width="190"><div align="right"><span class="Estilo5">CAMPOS COLUMNA  N&ordm;. 3 :</span></div></td>
                <td width="260"><div align="left"><span class="Estilo5">
                     <select class="Estilo10" name="txtcolumna3"> <option selected value="00">NINGUNO</option>
                       <option value="01">CEDULA</option>  <option value="02">NACIONALIDAD</option> <option value="03">RIF EMPLEADO</option>
                       <option value="04">FECHA DE INGRESO</option> <option value="05">ESTATUS</option>
                       <option value="06">TIPO DE N&Oacute;MINA</option> <option value="07">C&Oacute;DIGO CATEGORIA</option>
                       <option value="08">TIPO DE PAGO</option> <option value="09">CTA. DEL TRABAJADOR</option>
                       <option value="10">CTA. DE LA EMPRESA</option> <option value="11">SEXO</option>
                       <option value="12">ESTADO CIVIL</option>  <option value="13">FECHA DE NACIMIENTO </option>
                       <option value="14">EDAD </option> <option value="15">DIRECCI&Oacute;N </option>
                       <option value="16">TELEFONO</option> <option value="17">E-MAIL</option>
                       <option value="18">PROFESI&Oacute;N</option> <option value="19">GRADO DE INSTRUCI&Oacute;N</option>
                       <option value="20">C&Oacute;DIGO DEL CARGO</option> <option value="21">DESCRIPCI&Oacute;N DEL CARGO</option>
                       <option value="22">C&Oacute;DIGO DEL DEPARTAMENTO</option> <option value="23">DESCRIPCI&Oacute;N DEL DEPARTAMENTO</option>
                       <option value="24">FECHA DE ASIGNACI&Oacute;N</option> <option value="25">SUELDO DEL CARGO</option>
                       <option value="26">COMPENSACI&Oacute;N DEL CARGO</option> <option value="27">SUELDO+COMPENSACI&Oacute;N</option>
                       <option value="28">GRADO </option>  <option value="29">PASO</option>
                       <option value="30">TIPO DE PERSONAL</option> <option value="31">DESCRIPCI&Oacute;N DEL TIPO DE PERSONAL</option>
                       <option value="32">FECHA DE EGRESO</option> <option value="33">FECHA DE INGRESO ADM. PUBLICA</option>
					   <option value="34">C&Oacute;DIGO UBICACION</option><option value="35">DESCRIPCION UBICACION</option>
					   <option value="36">TELEFONO MOVIL</option><option value="37">DIAS DE TRABAJO</option>
					   <option value="38">DIA NACIMIENTO</option>	   <option value="39">MES NACIMIENTO</option>
					   <option value="40">PRIMA DEL CARGO</option>   <option value="41">SUELDO INTEGRAL DEL CARGO</option>
					   <option value="42">ESTADO</option> <option value="43">MUNICIPIO</option> <option value="44">CIUDAD</option> <option value="45">PARROQUIA</option>
                     </select> </span></div></td>
				<td width="190"><div align="right"><span class="Estilo5">CAMPOS COLUMNA  N&ordm;. 4 :</span></div></td>
                <td width="260"><div align="left"><span class="Estilo5">
                     <select class="Estilo10" name="txtcolumna4"> <option selected value="00">NINGUNO</option>
                       <option value="01">CEDULA</option>  <option value="02">NACIONALIDAD</option> <option value="03">RIF EMPLEADO</option>
                       <option value="04">FECHA DE INGRESO</option> <option value="05">ESTATUS</option>
                       <option value="06">TIPO DE N&Oacute;MINA</option> <option value="07">C&Oacute;DIGO CATEGORIA</option>
                       <option value="08">TIPO DE PAGO</option> <option value="09">CTA. DEL TRABAJADOR</option>
                       <option value="10">CTA. DE LA EMPRESA</option> <option value="11">SEXO</option>
                       <option value="12">ESTADO CIVIL</option>  <option value="13">FECHA DE NACIMIENTO </option>
                       <option value="14">EDAD </option> <option value="15">DIRECCI&Oacute;N </option>
                       <option value="16">TELEFONO</option> <option value="17">E-MAIL</option>
                       <option value="18">PROFESI&Oacute;N</option> <option value="19">GRADO DE INSTRUCI&Oacute;N</option>
                       <option value="20">C&Oacute;DIGO DEL CARGO</option> <option value="21">DESCRIPCI&Oacute;N DEL CARGO</option>
                       <option value="22">C&Oacute;DIGO DEL DEPARTAMENTO</option> <option value="23">DESCRIPCI&Oacute;N DEL DEPARTAMENTO</option>
                       <option value="24">FECHA DE ASIGNACI&Oacute;N</option> <option value="25">SUELDO DEL CARGO</option>
                       <option value="26">COMPENSACI&Oacute;N DEL CARGO</option> <option value="27">SUELDO+COMPENSACI&Oacute;N</option>
                       <option value="28">GRADO </option>  <option value="29">PASO</option>
                       <option value="30">TIPO DE PERSONAL</option> <option value="31">DESCRIPCI&Oacute;N DEL TIPO DE PERSONAL</option>
                       <option value="32">FECHA DE EGRESO</option> <option value="33">FECHA DE INGRESO ADM. PUBLICA</option>
					   <option value="34">C&Oacute;DIGO UBICACION</option><option value="35">DESCRIPCION UBICACION</option>
					    <option value="36">TELEFONO MOVIL</option> <option value="37">DIAS DE TRABAJO</option>
						<option value="38">DIA NACIMIENTO</option>	   <option value="39">MES NACIMIENTO</option>
						<option value="40">PRIMA DEL CARGO</option>   <option value="41">SUELDO INTEGRAL DEL CARGO</option>
					   <option value="42">ESTADO</option> <option value="43">MUNICIPIO</option> <option value="44">CIUDAD</option> <option value="45">PARROQUIA</option>
                     </select> </span></div></td>
               </tr>
             </table></td>
           </tr> 
           <tr><td><strong class="Estilo5">SOLO PARA TIPO SALIDA DEL REPORTE EXCEL</strong></td></tr>
		   <tr>
             <td><table width="905">
               <tr>
                <td width="190"><div align="right"><span class="Estilo5">CAMPOS COLUMNA  N&ordm;. 5 :</span></div></td>
                <td width="260"><div align="left"><span class="Estilo5">
                     <select class="Estilo10" name="txtcolumna5"> <option selected value="00">NINGUNO</option>
                       <option value="01">CEDULA</option>  <option value="02">NACIONALIDAD</option> <option value="03">RIF EMPLEADO</option>
                       <option value="04">FECHA DE INGRESO</option> <option value="05">ESTATUS</option>
                       <option value="06">TIPO DE N&Oacute;MINA</option> <option value="07">C&Oacute;DIGO CATEGORIA</option>
                       <option value="08">TIPO DE PAGO</option> <option value="09">CTA. DEL TRABAJADOR</option>
                       <option value="10">CTA. DE LA EMPRESA</option> <option value="11">SEXO</option>
                       <option value="12">ESTADO CIVIL</option>  <option value="13">FECHA DE NACIMIENTO </option>
                       <option value="14">EDAD </option> <option value="15">DIRECCI&Oacute;N </option>
                       <option value="16">TELEFONO</option> <option value="17">E-MAIL</option>
                       <option value="18">PROFESI&Oacute;N</option> <option value="19">GRADO DE INSTRUCI&Oacute;N</option>
                       <option value="20">C&Oacute;DIGO DEL CARGO</option> <option value="21">DESCRIPCI&Oacute;N DEL CARGO</option>
                       <option value="22">C&Oacute;DIGO DEL DEPARTAMENTO</option> <option value="23">DESCRIPCI&Oacute;N DEL DEPARTAMENTO</option>
                       <option value="24">FECHA DE ASIGNACI&Oacute;N</option> <option value="25">SUELDO DEL CARGO</option>
                       <option value="26">COMPENSACI&Oacute;N DEL CARGO</option> <option value="27">SUELDO+COMPENSACI&Oacute;N</option>
                       <option value="28">GRADO </option>  <option value="29">PASO</option>
                       <option value="30">TIPO DE PERSONAL</option> <option value="31">DESCRIPCI&Oacute;N DEL TIPO DE PERSONAL</option>
                       <option value="32">FECHA DE EGRESO</option> <option value="33">FECHA DE INGRESO ADM. PUBLICA</option>
					   <option value="34">C&Oacute;DIGO UBICACION</option><option value="35">DESCRIPCION UBICACION</option>
					   <option value="36">TELEFONO MOVIL</option><option value="37">DIAS DE TRABAJO</option>
					   <option value="38">DIA NACIMIENTO</option>	   <option value="39">MES NACIMIENTO</option>
					   <option value="40">PRIMA DEL CARGO</option>   <option value="41">SUELDO INTEGRAL DEL CARGO</option>
					   <option value="42">ESTADO</option> <option value="43">MUNICIPIO</option> <option value="44">CIUDAD</option> <option value="45">PARROQUIA</option>
                     </select> </span></div></td>
				<td width="190"><div align="right"><span class="Estilo5">CAMPOS COLUMNA  N&ordm;. 6 :</span></div></td>
                <td width="260"><div align="left"><span class="Estilo5">
                     <select class="Estilo10" name="txtcolumna6"> <option selected value="00">NINGUNO</option>
                       <option value="01">CEDULA</option>  <option value="02">NACIONALIDAD</option> <option value="03">RIF EMPLEADO</option>
                       <option value="04">FECHA DE INGRESO</option> <option value="05">ESTATUS</option>
                       <option value="06">TIPO DE N&Oacute;MINA</option> <option value="07">C&Oacute;DIGO CATEGORIA</option>
                       <option value="08">TIPO DE PAGO</option> <option value="09">CTA. DEL TRABAJADOR</option>
                       <option value="10">CTA. DE LA EMPRESA</option> <option value="11">SEXO</option>
                       <option value="12">ESTADO CIVIL</option>  <option value="13">FECHA DE NACIMIENTO </option>
                       <option value="14">EDAD </option> <option value="15">DIRECCI&Oacute;N </option>
                       <option value="16">TELEFONO</option> <option value="17">E-MAIL</option>
                       <option value="18">PROFESI&Oacute;N</option> <option value="19">GRADO DE INSTRUCI&Oacute;N</option>
                       <option value="20">C&Oacute;DIGO DEL CARGO</option> <option value="21">DESCRIPCI&Oacute;N DEL CARGO</option>
                       <option value="22">C&Oacute;DIGO DEL DEPARTAMENTO</option> <option value="23">DESCRIPCI&Oacute;N DEL DEPARTAMENTO</option>
                       <option value="24">FECHA DE ASIGNACI&Oacute;N</option> <option value="25">SUELDO DEL CARGO</option>
                       <option value="26">COMPENSACI&Oacute;N DEL CARGO</option> <option value="27">SUELDO+COMPENSACI&Oacute;N</option>
                       <option value="28">GRADO </option>  <option value="29">PASO</option>
                       <option value="30">TIPO DE PERSONAL</option> <option value="31">DESCRIPCI&Oacute;N DEL TIPO DE PERSONAL</option>
                       <option value="32">FECHA DE EGRESO</option> <option value="33">FECHA DE INGRESO ADM. PUBLICA</option>
					   <option value="34">C&Oacute;DIGO UBICACION</option><option value="35">DESCRIPCION UBICACION</option>
					   <option value="36">TELEFONO MOVIL</option> <option value="37">DIAS DE TRABAJO</option>
					   <option value="38">DIA NACIMIENTO</option>	   <option value="39">MES NACIMIENTO</option>
					   <option value="40">PRIMA DEL CARGO</option>   <option value="41">SUELDO INTEGRAL DEL CARGO</option>
					   <option value="42">ESTADO</option> <option value="43">MUNICIPIO</option> <option value="44">CIUDAD</option> <option value="45">PARROQUIA</option>
                     </select> </span></div></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="905">
               <tr>
                <td width="190"><div align="right"><span class="Estilo5">CAMPOS COLUMNA  N&ordm;. 7 :</span></div></td>
                <td width="260"><div align="left"><span class="Estilo5">
                     <select class="Estilo10" name="txtcolumna7"> <option selected value="00">NINGUNO</option>
                       <option value="01">CEDULA</option>  <option value="02">NACIONALIDAD</option> <option value="03">RIF EMPLEADO</option>
                       <option value="04">FECHA DE INGRESO</option> <option value="05">ESTATUS</option>
                       <option value="06">TIPO DE N&Oacute;MINA</option> <option value="07">C&Oacute;DIGO CATEGORIA</option>
                       <option value="08">TIPO DE PAGO</option> <option value="09">CTA. DEL TRABAJADOR</option>
                       <option value="10">CTA. DE LA EMPRESA</option> <option value="11">SEXO</option>
                       <option value="12">ESTADO CIVIL</option>  <option value="13">FECHA DE NACIMIENTO </option>
                       <option value="14">EDAD </option> <option value="15">DIRECCI&Oacute;N </option>
                       <option value="16">TELEFONO</option> <option value="17">E-MAIL</option>
                       <option value="18">PROFESI&Oacute;N</option> <option value="19">GRADO DE INSTRUCI&Oacute;N</option>
                       <option value="20">C&Oacute;DIGO DEL CARGO</option> <option value="21">DESCRIPCI&Oacute;N DEL CARGO</option>
                       <option value="22">C&Oacute;DIGO DEL DEPARTAMENTO</option> <option value="23">DESCRIPCI&Oacute;N DEL DEPARTAMENTO</option>
                       <option value="24">FECHA DE ASIGNACI&Oacute;N</option> <option value="25">SUELDO DEL CARGO</option>
                       <option value="26">COMPENSACI&Oacute;N DEL CARGO</option> <option value="27">SUELDO+COMPENSACI&Oacute;N</option>
                       <option value="28">GRADO </option>  <option value="29">PASO</option>
                       <option value="30">TIPO DE PERSONAL</option> <option value="31">DESCRIPCI&Oacute;N DEL TIPO DE PERSONAL</option>
                       <option value="32">FECHA DE EGRESO</option> <option value="33">FECHA DE INGRESO ADM. PUBLICA</option>
					   <option value="34">C&Oacute;DIGO UBICACION</option><option value="35">DESCRIPCION UBICACION</option>
					   <option value="36">TELEFONO MOVIL</option><option value="37">DIAS DE TRABAJO</option>
					   <option value="38">DIA NACIMIENTO</option>	   <option value="39">MES NACIMIENTO</option>
					   <option value="40">PRIMA DEL CARGO</option>   <option value="41">SUELDO INTEGRAL DEL CARGO</option>
					   <option value="42">ESTADO</option> <option value="43">MUNICIPIO</option> <option value="44">CIUDAD</option> <option value="45">PARROQUIA</option>
                     </select> </span></div></td>
				<td width="190"><div align="right"><span class="Estilo5">CAMPOS COLUMNA  N&ordm;. 8 :</span></div></td>
                <td width="260"><div align="left"><span class="Estilo5">
                     <select class="Estilo10" name="txtcolumna8"> <option selected value="00">NINGUNO</option>
                       <option value="01">CEDULA</option>  <option value="02">NACIONALIDAD</option> <option value="03">RIF EMPLEADO</option>
                       <option value="04">FECHA DE INGRESO</option> <option value="05">ESTATUS</option>
                       <option value="06">TIPO DE N&Oacute;MINA</option> <option value="07">C&Oacute;DIGO CATEGORIA</option>
                       <option value="08">TIPO DE PAGO</option> <option value="09">CTA. DEL TRABAJADOR</option>
                       <option value="10">CTA. DE LA EMPRESA</option> <option value="11">SEXO</option>
                       <option value="12">ESTADO CIVIL</option>  <option value="13">FECHA DE NACIMIENTO </option>
                       <option value="14">EDAD </option> <option value="15">DIRECCI&Oacute;N </option>
                       <option value="16">TELEFONO</option> <option value="17">E-MAIL</option>
                       <option value="18">PROFESI&Oacute;N</option> <option value="19">GRADO DE INSTRUCI&Oacute;N</option>
                       <option value="20">C&Oacute;DIGO DEL CARGO</option> <option value="21">DESCRIPCI&Oacute;N DEL CARGO</option>
                       <option value="22">C&Oacute;DIGO DEL DEPARTAMENTO</option> <option value="23">DESCRIPCI&Oacute;N DEL DEPARTAMENTO</option>
                       <option value="24">FECHA DE ASIGNACI&Oacute;N</option> <option value="25">SUELDO DEL CARGO</option>
                       <option value="26">COMPENSACI&Oacute;N DEL CARGO</option> <option value="27">SUELDO+COMPENSACI&Oacute;N</option>
                       <option value="28">GRADO </option>  <option value="29">PASO</option>
                       <option value="30">TIPO DE PERSONAL</option> <option value="31">DESCRIPCI&Oacute;N DEL TIPO DE PERSONAL</option>
                       <option value="32">FECHA DE EGRESO</option> <option value="33">FECHA DE INGRESO ADM. PUBLICA</option>
					   <option value="34">C&Oacute;DIGO UBICACION</option><option value="35">DESCRIPCION UBICACION</option>
					   <option value="36">TELEFONO MOVIL</option> <option value="37">DIAS DE TRABAJO</option>
					   <option value="38">DIA NACIMIENTO</option>	   <option value="39">MES NACIMIENTO</option>
					   <option value="40">PRIMA DEL CARGO</option>   <option value="41">SUELDO INTEGRAL DEL CARGO</option>
					   <option value="42">ESTADO</option> <option value="43">MUNICIPIO</option> <option value="44">CIUDAD</option> <option value="45">PARROQUIA</option>
                     </select> </span></div></td>
               </tr>
             </table></td>
           </tr>
		   <tr><td>&nbsp;</td></tr>
           <tr>
             <td><table width="894">
               <tr>
                 <th width="445"><div align="center"> <input name="btgenera" type="button" id="btgenera" value="GENERAR" onClick="javascript:Llama_Rpt_list_traj_cri('Rpt_list_traj_cri.php');">   </div></th>
                 <th width="448"><input name="btcancelar" type="button" id="btcancelar" value="CANCELAR" onClick="javascript:Llama_Menu_Rpt('menu.php');"></th>
               </tr>
             </table></td>
           </tr>
         </table>
         <p align="left">&nbsp;</p>
       </div>
    </form>    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>


         


</body>
</html>
