<?include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php");$equipo=getenv("COMPUTERNAME"); $fecha_hoy=asigna_fecha_hoy();  $tipo_arch_banco='98';
if (!$_GET){$cod_arch_banco=""; $tipo_arch_banco="98";}else{$cod_arch_banco=$_GET["cod_arch_banco"];} $criterio=$tipo_arch_banco.$cod_arch_banco;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="04-0000032"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA CONTROL N&Oacute;MINA Y PERSONAL (Generar Archivo de Nomina)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->

</script>
<script language="JavaScript" type="text/JavaScript">
var patronfecha = new Array(2,2,4);
function checkrefecha(mform){var mref; var mfec; var mmes; var mdia; var mano; var mhasta;
  mref=mform.txtfecha_desde.value;  mfec=mform.txtfecha_desde.value;
  if(mform.txtfecha_desde.value.length==8){ mfec=mref.substring (0, 6)+"20"+mref.charAt(6)+mref.charAt(7);  mform.txtfecha_desde.value=mfec; }
  mmes=mref.charAt(3)+mref.charAt(4); mano=mref.charAt(6)+mref.charAt(7)+mref.charAt(8)+mref.charAt(9);
  mdia="31"; if(mmes=="02"){mdia="28";} if((mmes=="04")||(mmes=="06")||(mmes=="09")||(mmes=="11")){mdia="30";}
  mhasta=mdia+"/"+mmes+"/"+mano; 
  mform.txtfecha_hasta.value=mhasta;    
return true;}
function Carga_Arch(){var mcod_arch; var f=document.form1;  var mtipo_arch='<?echo $tipo_arch_banco?>';
  mcod_arch=f.txtcod_arch_banco.value; document.location ='Gen_archivo_nomina.php?cod_arch_banco='+mcod_arch;
return true;}
function Procesar_Archivo(){var murl; var mcod_arch; var f=document.form1;  var mtipo_arch='<?echo $tipo_arch_banco?>';
  mcod_arch=f.txtcod_arch_banco.value;  murl="Desea Generar el Archivo ?"; r=confirm(murl);
  if(r==true){murl="Genera_arch_nomina.php?cod_arch_banco="+mcod_arch+"&tipo_arch_banco=<?echo $tipo_arch_banco?>"; document.location=murl;}
return true;}
function revisa(){var f=document.form1; var Valido=true;
   if(f.txtcod_arch_banco.value==""){alert("Codigo de Archivo no puede estar Vacio");return false;}
   if(f.txttipo_arch_banco.value==""){alert("Tipo de Archivo no puede estar Vacio");return false;}
   if(f.txtfecha_hasta.value.length==10){valido=true;}else{alert("Longitud Fecha proceso Invalida");return false;}
   if(f.txtcod_arch_banco.value.length==6){valido=true;}else{alert("Longitud Codigo de Archivo Invalida");return false;}
 //document.form1.submit;
return true;}
</script>
</head>
<?
$cod_empleado_d="";$cod_empleado_h="zzzzzzzzzzz";$codigo_departamentod="";$codigo_departamentoh="zzzzzzzzzzzzzzzz";$codigo_cargo_d="";$codigo_cargo_h="zzzzzzzzzzz"; $cod_conceptod="";$cod_conceptoh="zzzz";
$nombre_empled=""; $nombre_empleh=""; $denominacion_cargod=""; $denominacion_cargoh="";$descripcion_dep_d=""; $descripcion_dep_h=""; $denominacion_concep_d="";$denominacion_concep_h="";
$sql="Select max(cod_concepto) As max_cod_concepto, min(cod_concepto) As min_cod_concepto from nom002 where  oculto='NO' ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cod_conceptod=$registro["min_cod_concepto"];$cod_conceptoh=$registro["max_cod_concepto"]; }
$den_arch_banco=""; $cod_cta_emp="";  $fecha_hasta=$fecha_hoy; $fecha_dep=$fecha_hoy;  $fecha_desde=$fecha_hoy;
$hora = getdate(time()); $hora_dep=$hora["hours"] . ":" . $hora["minutes"] . ":" . $hora["seconds"];  $hora_dep = date ( "h:i:s");
$cod_moneda="N"; $medio_envio="N";
$sql="Select * from nom045 where (tipo_arch_banco='$tipo_arch_banco') and (cod_arch_banco='$cod_arch_banco')"; $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){ $den_arch_banco=$registro["den_arch_banco"]; $cod_cta_emp=$registro["cod_cta_emp"]; 
$cod_moneda=$registro["cod_moneda"]; $medio_envio=$registro["medio_envio"]; $cod_conceptod=$registro["cod_concepto1"];  $cod_conceptoh=$registro["cod_concepto2"]; }
if($medio_envio=="H"){ $fecha_desde=colocar_pdiames($fecha_desde); $fecha_hasta=colocar_udiames($fecha_desde);  }
else{$sql="Select tipo_nomina from nom046 where (Cod_Arch_Banco='$cod_arch_banco') and (tipo_arch_banco='$tipo_arch_banco')"; $res=pg_query($sql);
if($registro=pg_fetch_array($res,0)){ $tipo_nomina=$registro["tipo_nomina"]; $StrSQL="Select fecha_p_desde,fecha_p_hasta,monto from nom017 Where (Tipo_Nomina='$tipo_nomina') And (Tp_Calculo='N')"; $result=pg_query($StrSQL);
if($reg=pg_fetch_array($result,0)){ $fecha_hasta=$reg["fecha_p_hasta"];   $fecha_hasta=formato_ddmmaaaa($fecha_hasta);  $fecha_desde=$reg["fecha_p_desde"];   $fecha_desde=formato_ddmmaaaa($fecha_desde); } } }
$sql="Select max(cod_empleado) As max_cod_empleado, min(cod_empleado) As min_cod_empleado from nom006 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$cod_empleado_d=$registro["min_cod_empleado"];$cod_empleado_h=$registro["max_cod_empleado"];   }
$sql="Select cod_empleado,nombre from nom006 where cod_empleado='$cod_empleado_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$nombre_empled=$registro["nombre"];}
$sql="Select cod_empleado,nombre from nom006 where cod_empleado='$cod_empleado_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$nombre_empleh=$registro["nombre"];}
$sql="Select max(codigo_cargo) As max_codigo_cargo, min(codigo_cargo) As min_codigo_cargo from nom004 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$codigo_cargo_d=$registro["min_codigo_cargo"];$codigo_cargo_h=$registro["max_codigo_cargo"];   }
$sql="Select codigo_cargo,denominacion from nom004 where codigo_cargo='$codigo_cargo_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_cargod=$registro["denominacion"];}
$sql="Select codigo_cargo,denominacion from nom004 where codigo_cargo='$codigo_cargo_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_cargoh=$registro["denominacion"];}
$sql="Select cod_concepto,denominacion from nom002 where cod_concepto='$cod_conceptod'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_concep_d=$registro["denominacion"];}
$sql="Select cod_concepto,denominacion from nom002 where cod_concepto='$cod_conceptoh'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$denominacion_concep_h=$registro["denominacion"];}
$sql="Select max(codigo_departamento) As max_codigo_departamento, min(codigo_departamento) As min_codigo_departamento from nom005 ";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$codigo_departamento_d=$registro["min_codigo_departamento"];$codigo_departamento_h=$registro["max_codigo_departamento"];   }
$sql="Select codigo_departamento,descripcion_dep from nom005 where codigo_departamento='$codigo_departamento_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_dep_d=$registro["descripcion_dep"];}
$sql="Select codigo_departamento,descripcion_dep from nom005 where codigo_departamento='$codigo_departamento_h'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$descripcion_dep_h=$registro["descripcion_dep"];}
pg_close();?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">GENERAR ARCHIVO DE N&Oacute;MINA</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="660" border="1" id="tablacuerpo">
  <tr>
    <td width="950"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" action="Genera_arch_nomina.php"  target="popup" onsubmit="return revisa(); window.open('', 'popup')" >
       <div id="Layer1" style="position:absolute; width:940px; height:640px; z-index:1; top: 68px; left: 20px;">
         <table width="948" border="0" align="center" >
           <tr>
             <td><table width="946">
                 <tr>
                   <td width="60"><span class="Estilo5">C&Oacute;DIGO:</span></td>
                   <td width="66" ><span class="Estilo5"> <input class="Estilo10" name="txtcod_arch_banco" type="text" id="txtcod_arch_banco" size="10" maxlength="6"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $cod_arch_banco?>" > </span></td>
                   <td width="50"><input class="Estilo10" name="bttiponom" type="button" id="btcodarch" title="Abrir Catalogo Codigo de Archivo"  onClick="VentanaCentrada('Cat_arch_nomina.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                   <td width="500"><span class="Estilo5"> <input class="Estilo10" name="txtden_arch_banco" type="text" id="txtden_arch_banco" size="70" maxlength="100" readonly value="<?echo $den_arch_banco?>" > </span></td>
                   <td width="170" align="center"><input class="Estilo10" name="btcargar" type="button" id="btcargar" title="Cargar" onclick="javascript:Carga_Arch()" value="Cargar Archivo"></td>             
                 </tr>
             </table></td>
           </tr>           
           <tr>
             <td><table width="946">
                 <tr>
				   <td width="60"><span class="Estilo5">NOMINA :</span></td>
                   <td width="110"><span class="Estilo5"><Select name="txttipo_nom" size="1" id="txttipo_nom"><option Selected>ACTUAL</option>  <option>HISTORICO</option> </Select> </span></td>
                   <td width="210"><span class="Estilo5">FECHA PROCESO NOMINA DESDE:</span></td>
                   <td width="100"><span class="Estilo5"><input class="Estilo10" name="txtfecha_desde" type="text" id="txtfecha_desde" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)"   onchange="checkrefecha(this.form)" onkeyup="mascara(this,'/',patronfecha,true)" value="<?echo $fecha_desde?>"> </span></td>
                   <td width="60"><span class="Estilo5">HASTA :</span></td>
                   <td width="186"><span class="Estilo5"><input class="Estilo10" name="txtfecha_hasta" type="text" id="txtfecha_hasta" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" onkeyup="mascara(this,'/',patronfecha,true)" value="<?echo $fecha_hasta?>"> </span></td>
                   <td width="160"  align="left" class="Estilo5">AGRUPAR CONCEPTOS :</td>
				   <td width="60" align="left"><span class="Estilo5"><Select name="txtagrupado" size="1" id="txtagrupado"><option value='SI'>SI</option><option value='NO' Selected>NO</option> </Select></span></td>
				 </tr>
             </table></td>
           </tr>
		   <script language="JavaScript" type="text/JavaScript">var mvalor='<?echo $cod_moneda;?>';  if(mvalor=="S"){document.form1.txtagrupado.options[0].selected=true;}else{document.form1.txtagrupado.options[1].selected=true;} 
		   mvalor='<?echo $medio_envio;?>'; if(mvalor=="H"){document.form1.txttipo_nom.options[1].selected=true;}else{document.form1.txttipo_nom.options[0].selected=true;} 
		   </script>
		   <tr>
             <td><table width="946">
                 <tr>
                   <td width="170"  align="left" class="Estilo5">CONCEPTOS DE CALCULO :</td>
				   <td width="160" align="left"><span class="Estilo5"><Select name="txtconcepto_t" size="1" id="txtconcepto_t"><option value='NOMINA'>NOMINA</option><option value='VACACIONES'>VACACIONES</option><option value='TODOS' Selected>TODOS</option></Select></span></td>
				   <td width="120"><span class="Estilo5">TIPO DE FORMATO  :</span></td>
                   <td width="160"><span class="Estilo5"><Select name="txttipo_formato" size="1" id="txttipo_formato"><option>LINEAL</option> <option>TXT</option>  <option>TABULADO</option> <option>EXCEL</option> </Select> </span></td>
                   <td width="120"><span class="Estilo5">TIPO DE CALCULO  :</span></td>
				   <td width="220"><span class="Estilo5"><Select name="txttipo_calculo" size="1" id="txttipo_calculo"><option value='N'>NORMAL</option>  <option value='E'>EXTRAORDINARIA</option> <option value='T' selected>TODOS</option> </Select> </span></td>                   
                </tr>
             </table></td>
           </tr> 
		   <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="130" align="left" class="Estilo5">TRABAJADOR DESDE :</td>
                 <td width="159" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado_d" type="text" id="txtcod_empleado_d" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" value="<?echo $cod_empleado_d?>" ></span></td>
                 <td width="47" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_trabd" type="button" id="cat_trabd" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('Cat_trabajadores_d.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                 <td width="567" align="left"><span class="Estilo5"><input class="Estilo10" name="txtnombre_d" type="text" id="txtnombre_d" size="50" maxlength="74" readonly value="<?echo $nombre_empled?>"> </span></div></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="130" align="left" class="Estilo5">TRABAJADOR HASTA :</td>
                 <td width="159" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado_h" type="text" id="txtcod_empleado_h" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="20" value="<?echo $cod_empleado_h?>"> </span></td>
                 <td width="47" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_trabh" type="button" id="cat_trabh" title="Abrir Catalogo de Trabajadores" onClick="VentanaCentrada('Cat_trabajadores_h.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                 <td width="567" align="left"><span class="Estilo5"><input class="Estilo10" name="txtnombre_h" type="text" id="txtnombre_h" size="50" maxlength="74" readonly value="<?echo $nombre_empleh?>"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="145" align="left" class="Estilo5">C&Oacute;DIGO CARGO DESDE :</div></td>
                 <td width="145" align="left"><span class="Estilo5"> <input class="Estilo10" name="txtcodigo_cargo_d" type="text" id="txtcodigo_cargo_d" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" value="<?echo $codigo_cargo_d?>">  </span></td>
                 <td width="46" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_cargod" type="button" id="cat_cargod" title="Abrir Catalogo de Cargos" onClick="VentanaCentrada('Cat_cargosd.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                 <td width="567" align="left"><span class="Estilo5"> <input class="Estilo10" name="txtdenominacion_d" type="text" id="txtdenominacion_d" size="50" maxlength="75" readonly value="<?echo $denominacion_cargod?>">  </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="145" align="left" class="Estilo5">C&Oacute;DIGO CARGO HASTA :</div></td>
                 <td width="145" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_cargo_h" type="text" id="txtcodigo_cargo_h" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="20" value="<?echo $codigo_cargo_h?>"> </span></td>
                 <td width="46" align="left"><span class="Estilo5"><input class="Estilo10" name="cat_cargoh" type="button" id="cat_cargoh" title="Abrir Catalogo de Cargos" onClick="VentanaCentrada('Cat_cargosh.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                 <td width="567" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdenominacion_h" type="text" id="txtdenominacion_h" size="50" maxlength="75" readonly value="<?echo $denominacion_cargoh?>">   </span></td>
               </tr>
             </table></td>
           </tr>		   
		   <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="left" class="Estilo5">C&Oacute;DIGO DEPARTAMENTO DESDE :</td>
                 <td width="160" align="left" ><span class="Estilo5"><input class="Estilo10" name="txtcodigo_departamento_d" type="text" id="txtcodigo_departamento_d" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" value="<?echo $codigo_departamento_d?>"> </span></td>
                 <td width="49" align="left"><span class="Estilo5"><input class="Estilo10" name="Cat_depd" type="button" id="Cat_depd" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('Cat_departamentod.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                 <td width="499" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_dep_d" type="text" id="txtdescripcion_dep_d" size="50" maxlength="100" readonly value="<?echo $descripcion_dep_d?>">  </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="196" align="left" class="Estilo5">C&Oacute;DIGO DEPARTAMENTO HASTA :</td>
                 <td width="160" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_departamento_h" type="text" id="txtcodigo_departamento_h" onFocus="encender(this)" onBlur="apagar(this)" size="15" maxlength="15" value="<?echo $codigo_departamento_h?>"></span></td>
                 <td width="49" align="left"><span class="Estilo5"><input class="Estilo10" name="Cat_deph" type="button" id="Cat_deph" title="Abrir Catalogo de Departamentos" onClick="VentanaCentrada('Cat_departamentoh.php?criterio=','SIA','','650','500','true')" value="..."> </span></td>
                 <td width="499" align="left"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_dep_h" type="text" id="txtdescripcion_dep_h" size="50" maxlength="100" readonly value="<?echo $descripcion_dep_h?>"> </span></td>
               </tr>
             </table></td>
           </tr>
		    <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="120" align="left" class="Estilo5">CONCEPTO DESDE :</td>
                 <td width="50" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto_d" type="text" id="txtcod_concepto_d" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $cod_conceptod?>"> </span></td>
                 <td width="43" align="left"><span class="Estilo5"><input class="Estilo10" name="Catalogo3" type="button" id="Catalogo3" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('Cat_conceptd.php?criterio=','SIA','','650','500','true')" value="..."></span></td>
                 <td width="690" align="left"><span class="Estilo5"><input class="Estilo10" name="txtden_concepto_d" type="text" id="" size="60" maxlength="100" readonly value="<?echo $denominacion_concep_d?>"> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="903" border="0" align="center" cellpadding="0" cellspacing="0">
               <tr>
                 <td width="120" align="left" class="Estilo5">CONCEPTO HASTA :</td>
                 <td width="50" align="left"><span class="Estilo5"><input class="Estilo10" name="txtcod_concepto_h" type="text" id="txtcod_concepto_h" onFocus="encender(this)" onBlur="apagar(this)" size="3" maxlength="3" value="<?echo $cod_conceptoh?>"></span></td>
                 <td width="43" align="left"><span class="Estilo5"><input class="Estilo10" name="Catalogo4" type="button" id="Catalogo4" title="Abrir Catalogo de Conceptos" onClick="VentanaCentrada('Cat_concepth.php?criterio=','SIA','','650','500','true')" value="...">  </span></td>
                 <td width="690" align="left"><span class="Estilo5"><input class="Estilo10" name="txtden_concepto_h" type="text" id="txtden_concepto_h" size="60" maxlength="100" readonly value="<?echo $denominacion_concep_h?>"> </span></td>
               </tr>
             </table></td>
           </tr> 
           <tr> <td>&nbsp;</td> </tr>
         </table>
         <div id="T11" align="center" class="tab-body">
         <iframe src="Det_nomina_arch_banco.php?criterio=<?echo $criterio?>" width="770" height="220" scrolling="auto" frameborder="1"></iframe>
         </div>
         <table width="940">
          <tr> <td>&nbsp;</td> </tr>
          <tr>
            <td width="20"><input class="Estilo10" name="txttipo_arch_banco" type="hidden" id="txttipo_arch_banco" value="<?echo $tipo_arch_banco?>"></td>
            <td width="200">&nbsp;</td>
            <td width="250" align="center" valign="middle"><input name="Procesar" type="submit" id="Procesar"  value="Procesar Archivo" title="Procesar Archivo" ></td>
            <td width="250" align="center"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:LlamarURL('menu.php')" value="Menu Principal"></td>
            <td width="220">&nbsp;</td>
          </tr>
        </table>

       </div>
      </form>
    </td>

  </tr>
</table>
</body>
</html>