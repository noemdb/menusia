<?include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");   include ("../class/configura.inc");
$equipo=getenv("COMPUTERNAME"); $mcod_m="TRAB".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $fecha_hoy=asigna_fecha_hoy();
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";
if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="01-0000045"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
}$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='menu.php';</script><?}
if ($gnomina=="00"){ $criterion=""; $criterioc=""; $temp_nomina="";}else{ $temp_nomina=$gnomina; $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
if (!$_GET){ $cod_empleado='';  $p_letra=''; $sql="SELECT * FROM TRABAJADORES ".$criterion." Order by cod_empleado";}
else {$cod_empleado = $_GET["Gcod_empleado"];$p_letra=substr($cod_empleado, 0, 1);
  if(($p_letra=="P")||($p_letra=="U")||($p_letra=="S")||($p_letra=="A")||($p_letra=="C")){$cod_empleado=substr($cod_empleado,1,15);} else{$cod_empleado=substr($cod_empleado,0,15);}
  $sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado' ".$criterioc."";
  if ($p_letra=="P"){$sql="SELECT * FROM TRABAJADORES ".$criterion." Order by cod_empleado";}
  if ($p_letra=="U"){$sql="SELECT * From TRABAJADORES ".$criterion." Order by cod_empleado desc";}
  if ($p_letra=="S"){$sql="SELECT * From TRABAJADORES Where (cod_empleado>'$cod_empleado') ".$criterioc." Order by cod_empleado";}
  if ($p_letra=="A"){$sql="SELECT * From TRABAJADORES Where (cod_empleado<'$cod_empleado') ".$criterioc." Order by cod_empleado desc";}
 // echo $sql,"<br>";
}?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIA N&Oacute;MINA Y PERSONAL  (Informaci&oacute;n Trabajadores)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
var Gcod_empleado="";
function Llamar_Incluir(mop){ document.form2.submit(); }
function Llamar_Ventana(url){var murl;
    Gcod_empleado=document.form1.txtcod_empleado.value;murl=url+Gcod_empleado;
    if (Gcod_empleado==""){alert("Codigo Trabajador debe ser Seleccionada");}else {document.location = murl;}
}
function Llamar_modificar(url){var murl;
    Gcod_empleado=document.form1.txtcod_empleado.value; murl=url+Gcod_empleado+"&Gcedula=";
    if (Gcod_empleado==""){alert("Codigo Trabajador debe ser Seleccionada");}else {document.location = murl;}
}
function Mover_Registro(MPos){var murl;
   murl="Act_info_trabajadores.php";
   if(MPos=="P"){murl="Act_info_trabajadores.php?Gcod_empleado=P"}
   if(MPos=="U"){murl="Act_info_trabajadores.php?Gcod_empleado=U"}
   if(MPos=="S"){murl="Act_info_trabajadores.php?Gcod_empleado=S"+document.form1.txtcod_empleado.value;}
   if(MPos=="A"){murl="Act_info_trabajadores.php?Gcod_empleado=A"+document.form1.txtcod_empleado.value;}
   document.location = murl;
}
function Llama_Eliminar(){var url; var r;
  r=confirm("Esta seguro en Eliminar los Datos del Trabajador ?");
  if (r==true) { r=confirm("Esta Realmente seguro en Eliminar los Datos del Trabajador ?");
    if (r==true) {url="Delete_trabajador.php?Gcod_empleado="+document.form1.txtcod_empleado.value; VentanaCentrada(url,'Eliminar Trabajador','','400','400','true');}}
   else { url="Cancelado, no elimino"; }
}
function Llama_Asignar(){var url; var r;  var mstatus = document.form1.txtstatus.value;
  if((mstatus=="ACTIVO")||(mstatus=="VACACIONES")) {  r=confirm("Asignar Conceptos al Trabajador por Grupo ?");
   if (r==true) {url="Asig_concepto_trab.php?Gcod_empleado="+document.form1.txtcod_empleado.value; VentanaCentrada(url,'Asignar Concepto al Trabajador','','420','250','true'); }}
     else{alert("Estatus de Trabajador Invalido");}
}
function Llama_Act_edad(){var url; var r;  r=confirm("Actualizar Edades de Trabajadores y Familiares ?");
  if(r==true){url="Act_edad_trab.php?Gcod_empleado="+document.form1.txtcod_empleado.value; VentanaCentrada(url,'Actualizar Edades','','420','250','true'); }
}
function Llama_Act_cargo(){var url; var r;  r=confirm("Actualizar Asignacion de Cargo a los Trabajadores ?");
  if(r==true){url="Act_asig_cargo.php?Gcod_empleado="+document.form1.txtcod_empleado.value; VentanaCentrada(url,'Actualizar Asignacion de Cargo','','420','250','true'); }
}
function Llama_Act_sueldo(){ var url;
  url="Act_sueldo_cargo.php?Gtipo_nomina="+document.form1.txttipo_nomina.value; VentanaCentrada(url,'Actualizar Sueldo de Cargo','','500','350','true');
}
function Llama_camb_nomina(){ var url; var mstatus = document.form1.txtstatus.value;
  if(mstatus=="ACTIVO"){ url="Camb_tipo_nomina.php?Gtipo_nomina="+document.form1.txttipo_nomina.value+"&Gcod_empleado="+document.form1.txtcod_empleado.value; VentanaCentrada(url,'Cambiar Tipo de Nomina','','600','350','true');}
   else{alert("Estatus de Trabajador Invalido");}
}
function Llama_camb_codigo(){ var url; var mstatus = document.form1.txtstatus.value;
  if((mstatus=="ACTIVO")||(mstatus=="VACANTE")){ url="Camb_cod_empleado.php?Gcod_empleado="+document.form1.txtcod_empleado.value; VentanaCentrada(url,'Cambiar Codigo de Trabajador','','600','350','true');}
   else{alert("Estatus de Trabajador Invalido");}
}
function Llama_camb_cuenta(){ var url;
  url="Camb_cuenta_emp.php?Gtipo_nomina="+document.form1.txttipo_nomina.value+"&Gcuenta="+document.form1.txtcta_empresa.value; VentanaCentrada(url,'Cambiar Cuenta de Empresa','','600','350','true');
}
function Llama_camb_categoria(){ var url;
  url="Camb_categoria_emp.php?Gtipo_nomina="+document.form1.txttipo_nomina.value+"&Gcategoria="+document.form1.txtcod_categoria.value; VentanaCentrada(url,'Cambiar Catgeoria de Trabajador','','600','350','true');
}
function Llama_retira_trab(){ var url;
  url="Retira_trab.php?Gcod_empleado="+document.form1.txtcod_empleado.value; VentanaCentrada(url,'Retira Trabajador','','600','400','true');
}
function Llama_camb_sueldos(){ var url;
  url="Camb_sueldo_trab.php?Gtipo_nomina="+document.form1.txttipo_nomina.value+"&Gcod_sueldo=001&Gcod_ret=000"; VentanaCentrada(url,'Cambiar Sueldos Trabajadores','','700','450','true');
}
function Llama_Act_conc_sueldo(){ var url;
  url="Camb_concepto_sueldo.php?Gtipo_nomina="+document.form1.txttipo_nomina.value+"&Gcod_sueldo=001&Gcod_ret=002"; VentanaCentrada(url,'Cambiar Sueldos Trabajadores','','700','400','true');
}
function Llama_forma_sso(url){var murl; var r;
   Gcod_empleado=document.form1.txtcod_empleado.value; murl=url+Gcod_empleado;
    if (Gcod_empleado==""){alert("Codigo Trabajador debe ser Seleccionada");}else {
	   window.open(murl,"Forma SSO")
	}
}

function Llamar_Desactiva_trab(mtipo_nom){ var url; var r;
 if((mtipo_nom=="27")||(mtipo_nom=="37")||(mtipo_nom=="47")){
	r=confirm("Esta seguro en Inactivar los Trabajadores de la Nomina "+mtipo_nom+" ?");
    if (r==true) { r=confirm("Esta Realmente seguro en Inactivar los Trabajadores de la Nomina "+mtipo_nom+" ?");
       if (r==true) { url="update_incativar_trab.php?Gtipo_nomina="+document.form1.txttipo_nomina.value; 
	VentanaCentrada(url,'Inactivar Trabajador','','400','400','true');}}
 }
}


function Llama_Rpt_info_ho_vid_mp_mit(murl){var url; var r;
  r=confirm("Desea Generar el Reporte Informacion Hoja de Vida del Trabajador?");
  if (r==true) {url=murl+"?cod_empleado_d="+document.form1.txtcod_empleado.value+"&cod_empleado_h="+document.form1.txtcod_empleado.value+
    "&tipo_nominad="+document.form1.txttipo_nomina.value+"&tipo_nominah="+document.form1.txttipo_nomina.value+
    "&cedula_d="+document.form1.txtcedula.value+"&cedula_h="+document.form1.txtcedula.value+"&sexo="+document.form1.txtsexo.value+
    "&estado_civil="+document.form1.txtedo_civil.value+ "&fecha_d="+document.form1.txtfecha_nacimiento.value+"&fecha_h="+document.form1.txtfecha_nacimiento.value+
    "&edad_d="+document.form1.txtedad.value+"&edad_h="+document.form1.txtedad.value+"&fecha_ingreso_d="+document.form1.txtfecha_ingreso.value+
    "&fecha_ingreso_h="+document.form1.txtfecha_ingreso.value+"&estatus="+document.form1.txtstatus.value+
    "&codigo_cargo_d="+document.form1.txtcod_cargo.value+"&codigo_cargo_h="+document.form1.txtcod_cargo.value+
    "&codigo_departamentod="+document.form1.txtcod_dep.value+"&codigo_departamentoh="+document.form1.txtcod_dep.value;	
  window.open(url,"Reporte Informacion Hoja de Vida del Trabajador")
  }
}
</script>
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
</head>
<?
$nombre="";$cod_empleado=""; $nacionalidad=""; $descripcion=""; $cod_jerarquia=""; $codigo_ubicacion=""; $descripcion_ubi=""; $cedula=""; $rif_empleado=""; $campo_str1="";  $campo_num1=0;
$tipo_nomina=""; $nacionalidad=""; $status=""; $fecha_ingreso=""; $fecha_ing_adm=""; $cod_categoria=""; $tipo_pago=""; $cta_empleado=""; $tipo_cuenta=""; $cod_banco=""; $nombre_banco=""; $cta_empresa=""; $calculo_grupos=""; $fecha_asigna_cargo=""; $cod_cargo=""; $cod_departam=""; $cod_tipo_personal=""; $paso=""; $grado=""; $sueldo=""; $prima=""; $compensacion=""; $otros=""; $sueldo_integral=""; $tipo_vacaciones="N"; $pago_vaciones="N"; $fecha_pago=""; $tiene_lph=""; $banco_lph=""; $cta_lph=""; $fecha_lph=""; $fecha_des_lph=""; $modif_lph=""; $tiene_dec_jurada=""; $fecha_declaracion=""; $monto_declaracion=""; $fecha_fin_con=""; $fecha_egreso=""; $motivo_egreso=""; $cont_fijo=""; $cod_cont_colec=""; $tipo_nom_ant=""; $cod_emp_ant=""; $fecha_camb_n=""; $motivo_camb_n=""; $tiene_aus_pro=""; $motivo_ausencia=""; $fecha_aus_desde=""; $fecha_aus_hasta="";  $motivo_suplen=""; $cedula_titular="";
$nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $sexo=""; $edo_civil=""; $fecha_nacimiento=""; $edad=""; $lugar_nacimiento=""; $direccion=""; $cod_postal=""; $telefono=""; $tlf_movil=""; $correo=""; $profesion=""; $grado_inst=""; $tiempo_e=""; $poliza=""; $fecha_seguro=""; $estado=""; $ciudad=""; $municipio=""; $parroquia=""; $observacion=""; $talla_camisa=""; $talla_pantalon=""; $talla_calzado=""; $peso=""; $estatura=""; $aptdo_postal=""; 
$res=pg_query($sql); $filas=pg_num_rows($res);
if ($filas==0){ if ($p_letra=="S"){$sql="SELECT * From TRABAJADORES ".$criterion." Order by cod_empleado";}  if ($p_letra=="A"){$sql="SELECT * From TRABAJADORES ".$criterion." Order by cod_empleado desc";}  $res=pg_query($sql);  $filas=pg_num_rows($res);}
if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"];   $status=$registro["status"];
  $fecha_ingreso=$registro["fecha_ingreso"]; $fecha_ing_adm=$registro["fecha_ing_adm"]; $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);  $fecha_ing_adm=formato_ddmmaaaa($fecha_ing_adm); $cod_cargo=$registro["cod_cargo"]; $cod_departam=$registro["cod_departam"];
  $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $cod_categoria=$registro["cod_categoria"]; $tipo_pago=$registro["tipo_pago"]; $cta_empleado=$registro["cta_empleado"]; $tipo_cuenta=$registro["tipo_cuenta"];
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $cta_empresa=$registro["cta_empresa"]; $calculo_grupos=$registro["calculo_grupos"]; $cod_jerarquia=$registro["cod_jerarquia"];
  $tiene_dec_jurada=$registro["tiene_dec_jurada"]; $fecha_declaracion=$registro["fecha_declaracion"]; $monto_declaracion=$registro["monto_declaracion"];  $fecha_declaracion=formato_ddmmaaaa($fecha_declaracion);
  $tiene_lph=$registro["tiene_lph"]; $banco_lph=$registro["banco_lph"]; $cta_lph=$registro["cta_lph"]; $fecha_lph=$registro["fecha_lph"]; $fecha_des_lph=$registro["fecha_des_lph"]; $modif_lph=$registro["modif_lph"]; $fecha_lph=formato_ddmmaaaa($fecha_lph); $fecha_des_lph=formato_ddmmaaaa($fecha_des_lph);
  $fecha_fin_con=$registro["fecha_fin_con"]; $fecha_egreso=$registro["fecha_egreso"]; $motivo_egreso=$registro["motivo_egreso"]; $cont_fijo=$registro["cont_fijo"];  $fecha_fin_con=formato_ddmmaaaa($fecha_fin_con);  $fecha_egreso=formato_ddmmaaaa($fecha_egreso);
  $tipo_vacaciones=$registro["tipo_vacaciones"]; $pago_vaciones=$registro["pago_vaciones"]; $fecha_pago=$registro["fecha_pago"]; $cod_jerarquia=$registro["cod_jerarquia"]; $fecha_pago=formato_ddmmaaaa($fecha_pago);
  $codigo_ubicacion=$registro["codigo_ubicacion"]; $descripcion_ubi=$registro["descripcion_ubi"]; $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $rif_empleado=$registro["rif_empleado"];
  $apellido1=$registro["apellido1"];$apellido2=$registro["apellido2"]; $direccion=$registro["direccion"];$grado_inst=$registro["grado_inst"]; $profesion=$registro["profesion"]; $campo_str1=$registro["campo_str1"];
  $sexo=$registro["sexo"]; $edo_civil=$registro["edo_civil"]; $fecha_nacimiento=$registro["fecha_nacimiento"]; $edad=$registro["edad"];  $fecha_nacimiento=formato_ddmmaaaa($fecha_nacimiento);
  $lugar_nacimiento=$registro["lugar_nacimiento"]; $cod_postal=$registro["cod_postal"]; $telefono=$registro["telefono"];  $tlf_movil=$registro["tlf_movil"];  $correo=$registro["correo"];
  $estado=$registro["estado"]; $ciudad=$registro["ciudad"]; $municipio=$registro["municipio"]; $parroquia=$registro["parroquia"]; $aptdo_postal=$registro["aptdo_postal"];
  $observacion=$registro["observacion"]; $talla_camisa=$registro["talla_camisa"]; $talla_pantalon=$registro["talla_pantalon"]; $talla_calzado=$registro["talla_calzado"];  $campo_num1=$registro["campo_num1"];
  $poliza=$registro["poliza"]; $fecha_seguro=$registro["fecha_seguro"]; $fecha_seguro=formato_ddmmaaaa($fecha_seguro);
  $tiene_aus_pro=$registro["tiene_aus_pro"]; $motivo_ausencia=$registro["motivo_ausencia"];  $fecha_aus_desde=$registro["fecha_aus_desde"]; $fecha_aus_hasta=$registro["fecha_aus_hasta"];  $fecha_aus_desde=formato_ddmmaaaa($fecha_aus_desde); $fecha_aus_hasta=formato_ddmmaaaa($fecha_aus_hasta);
  $inf_usuario=$registro["inf_usuario"]; $monto_declaracion=formato_monto($monto_declaracion); $edad=round($edad);  $campo_num1=round($campo_num1);
} if($tiene_dec_jurada=="S"){$tiene_dec_jurada="SI";}else{$tiene_dec_jurada="NO"; $monto_declaracion=0;} if($tiene_lph=="S"){$tiene_lph="SI";}else{$tiene_lph="NO";}
If(($status=="INACTIVO")Or($status=="JUBILADO")Or($status=="PENSIONADO")Or($status=="RETIRADO")Or($status=="DESPEDIDO")Or($status=="RENUNCIA")Or($status=="FALLECIDO")Or($status=="AÑO SABATICO")Or($status=="VACANTE")){$egresado="S";}else{$egresado="N";}
If($cont_fijo=="F"){$cont_fijo="FIJO";} If($cont_fijo=="C"){$cont_fijo="CONTRATADO";} If($cont_fijo=="S"){$cont_fijo="SUPLENTE";}
if($tipo_vacaciones=="N"){$tipo_vacaciones="NO";$fecha_pago="";}else{$tipo_vacaciones="SI";} if($tiene_aus_pro=="N"){$tiene_aus_pro="NO";$fecha_aus_desde="";$fecha_aus_hasta="";}else{$tiene_aus_pro="SI";}
$jerarquia="OTROS"; if($cod_jerarquia=="01"){$jerarquia="ADMINISTRATIVO";} if($cod_jerarquia=="02"){$jerarquia="PROFESIONALES Y TECNICOS";} if($cod_jerarquia=="03"){$jerarquia="ALTO NIVEL";} if($cod_jerarquia=="04"){$jerarquia="OBREROS";}
$Ssql="select * from SIA000"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$reg_e=$registro["campo041"];$edo_e=$registro["campo010"];$mun_e=$registro["campo011"];$ciu_e=$registro["campo009"];}else{$reg_e="REGION CENTRO-OCCIDENTAL";$edo_e="LARA";$mun_e="IRIBARREN";$ciu_e="BARQUISIMETO";}
$cod_e="00"; $Ssql="select * FROM pre091 where estado='".$edo_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_e=$registro["cod_estado"];}
$cod_m="00"; $Ssql="select * FROM PRE093 where nombre_municipio='".$mun_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_m=$registro["cod_municipio"];}
$cod_p=$cod_m."00"; $Ssql="select * from PRE096 where substr(cod_parroquia,1,4)='".$cod_m."'  Order by cod_parroquia"; $resultado=pg_query($Ssql); if($registro=pg_fetch_array($resultado,0)){$cod_p=$registro["cod_parroquia"];}
$cod_modulo="04";$campo502="NNNNNNNNNNNNNNNNNNNN";$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"];} $primero_apellido=substr($campo502,18,1); $sfecha=formato_aaaammdd($fecha_hoy);
$sSQL="SELECT ACTUALIZA_NOM067(4,'$codigo_mov','','$sfecha','','','')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sSQL="SELECT ACTUALIZA_NOM068(4,'$codigo_mov','','$sfecha','','','','','','','','',0,0,0,0,0)"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sSQL="SELECT ACTUALIZA_NOM069(4,'$codigo_mov','','','','','$sfecha',0,'')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sSQL="SELECT ACTUALIZA_NOM070(4,'$codigo_mov','','$sfecha','$sfecha','','','',0)"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sSQL="SELECT ACTUALIZA_NOM071(4,'$codigo_mov','','$sfecha','')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$formato_trab="XXXXXXXXXX";$sql="Select * from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$formato_trab=$registro["campo504"];$formato_cargo=$registro["campo505"];$formato_dep=$registro["campo506"];}
$temp_des_nomina=$descripcion;
?>
<body>
<table width="977" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">INFORMACI&Oacute;N DEL TRABAJADOR </div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="977" height="1292" border="1" id="tablacuerpo">
  <tr>
   <td width="92" height="1290"><table width="92" height="1290" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <?if ($Mcamino{0}=="S"){?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Incluir()";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Incluir()">Incluir</A></td>
      </tr>
	  <?} if ($Mcamino{1}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_modificar('Mod_info_trabajadores.php?Gcod_empleado=')";
                onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llamar_modificar('Mod_info_trabajadores.php?Gcod_empleado=');">Modificar</A></td>
      </tr>
	  <?} if ($Mcamino{2}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('P')";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Mover_Registro('P');">Primero</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('A')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('A');" class="menu">Anterior</a></td>
      </tr>
      <tr>
        <td  onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('S')";
                  onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('S');" class="menu">Siguiente</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Mover_Registro('U')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Mover_Registro('U');" class="menu">Ultimo</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Cat_act_trabajadores.php')";
                          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="Cat_act_trabajadores.php" class="menu">Catalogo</a></td>
      </tr>
	  <?} if ($Mcamino{6}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Eliminar();">Eliminar</A></td>
      </tr>
	  <?} if ($Mcamino{10}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Asignar();">Asignar Conceptos</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Act_edad();">Actualiza Edad</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Act_cargo();">Actualiza Asignaci&oacute;n de Cargos</A></td>
      </tr>
	  <!--
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Act_sueldo();">Actualiza Montos de Sueldo</A></td>
      </tr>
	  -->

      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_camb_nomina();">Cambia Tipo de N&oacute;mina</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_camb_codigo();">Cambia Cod. Trabajador</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_camb_cuenta();">Cambia Cuenta Emp.</A></td>
      </tr>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_camb_categoria();">Cambia Categoria Emp.</A></td>
      </tr>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_camb_sueldos();">Cambia Sueldos Trabajador</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_retira_trab();">Retira Cod. Trabajador</A></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Act_conc_sueldo();">Actualiza Concepto Sueldo</A></td>
      </tr>
	  
	  
	    <?if(($Cod_Emp=="32")and(($tipo_nomina=="27")or($tipo_nomina=="37")or($tipo_nomina=="47"))){?>
		  <tr>
            <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Llamar_Desactiva_trab('<?echo $tipo_nomina ?>') ";
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="javascript:Llamar_Desactiva_trab('<?echo $tipo_nomina?>');">Desactivar Trabajadores</A></td>
          </tr>
		<?}?>
		
	  <?} if ($Mcamino{3}=="S"){?>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_Rpt_info_ho_vid_mp_mit('/sia/nomina/rpt/Rpt_info_ho_vid_mp_mit.php');">Formato Hoja de Vida</A></td>
      </tr>
	  
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_forma_sso('llama_forma_1402.php?txtcod_empleado=');">Forma 14-02</A></td>
      </tr>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" ;
               onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu  href="javascript:Llama_forma_sso('llama_forma_1403.php?txtcod_empleado=');">Forma 14-03</A></td>
      </tr>
	  <?} ?>
	  <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:Ventana_002('/sia/nomina/ayuda/ayuda_inf_trabaja.htm','Ayuda Trabajadores','','900','600','true');";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><a href="javascript:Ventana_002('/sia/nomina/ayuda/ayuda_inf_trabaja.htm','Ayuda Trabajadores','','900','600','true');" class="menu">Ayuda </a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
              onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="35"  bgColor=#EAEAEA><A class=menu href="menu.php">Menu </A></td>
      </tr>
  <td>&nbsp;</td>
  </tr>
    </table></td>
    <td width="888"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <form name="form1" method="post" action=""><div id="Layer1" style="position:absolute; width:841px; height:1198px; z-index:1; top: 79px; left: 115px;">
         <table width="865" border="0" >
           <tr>
             <td><table width="864">
               <tr>
                 <td width="144"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR :</span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15"  value="<?echo $cod_empleado?>" readonly></span></td>
                 <td width="150"><span class="Estilo5">C&Eacute;DULA DE IDENTIDAD :</span></td>
                 <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="12" maxlength="10"  value="<?echo $cedula?>" readonly></span></td>
                 <td width="110"><span class="Estilo5">NACIONALIDAD : </span></td>
                 <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txtnacionalidad" type="text" id="txtnacionalidad" size="15" maxlength="15"   value="<?echo $nacionalidad?>" readonly></span></td>
                 <td width="20"><img src="../imagenes/b_info.png" onclick="javascript:alert('<?echo $inf_usuario?>');"></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="144"><span class="Estilo5">NOMBRE TRABAJADOR  :</span></td>
                 <td width="720"><span class="Estilo5"><input class="Estilo10" name="txtnombre" type="text" id="txtnombre" size="100" maxlength="100"  value="<?echo $nombre?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="864">
               <tr>
                 <td width="75"><span class="Estilo5">NOMBRES :</span></td>
                 <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtnombre1" type="text" id="txtnombre1" size="20" maxlength="20" value="<?echo $nombre1?>" readonly> </span></td>
                 <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtnombre2" type="text" id="txtnombre2" size="20" maxlength="20" value="<?echo $nombre2?>" readonly> </span></td>
                 <td width="75"><span class="Estilo5">APELLIDOS :</span></td>
                 <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtapellido1" type="text" id="txtapellido1" size="20" maxlength="20" value="<?echo $apellido1?>" readonly></span></td>
                 <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtapellido2" type="text" id="txtapellido2" size="20" maxlength="20" value="<?echo $apellido2?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="110"><span class="Estilo5">FECHA INGRESO  :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ingreso" type="text" id="txtfecha_ingreso" size="12" maxlength="10"  value="<?echo $fecha_ingreso?>" readonly></span></td>
                 <td width="214"><span class="Estilo5">FECHA ING. ADMINIST. PUBLICA :</span></td>
                 <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_ing_adm" type="text" id="txtfecha_ing_adm" size="12" maxlength="10"  value="<?echo $fecha_ing_adm?>" readonly></span></td>
                 <td width="200"><span class="Estilo5">A&Ntilde;OS ANTIGUEDAD ACUMULADO   :</span></td>
				 <td width="70"><span class="Estilo5"> <input class="Estilo10" name="txtcampo_num1" type="text" id="txtcampo_num1" size="2" maxlength="2"   value="<?echo $campo_num1?>" readonly > </span></td>
                </tr>
             </table></td>
           </tr>
		   
		   <tr>
             <td><table width="864">
               <tr>
                 
				 <td width="200"><span class="Estilo5">ESTATUS : </span></td>
                 <td width="664"><span class="Estilo5"> <input class="Estilo10" name="txtstatus" type="text" id="txtstatus" size="15" maxlength="15"   value="<?echo $status?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="144"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="3" maxlength="2"  value="<?echo $tipo_nomina?>" readonly></span></td>
                 <td width="600"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion" type="text" id="txtdescripcion" size="90" maxlength="100"  value="<?echo $descripcion?>" readonly> </span></td>
                </tr>
             </table></td>
           </tr>
		   
		   <tr>
             <td><table width="864">
               <tr>
                 <td width="144"><span class="Estilo5">CODIGO CATEGORIA : </span></td>
                 <td width="220"><span class="Estilo5"> <input class="Estilo10" name="txtcod_categoria" type="text" id="txtcod_categoria" size="18" maxlength="16"   value="<?echo $cod_categoria?>" readonly></span></td>
                 <td width="200"><span class="Estilo5">FUENTE DE FINANCIAMIENTO :</span></td>
				 <td width="300"><span class="Estilo5"><span class="Estilo5"><input class="Estilo10" name="txtfuente" type="text" id="txtfuente" size="2" maxlength="2" readonly value="<?echo $campo_str1?>">  </span></td>
				</tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="110"><span class="Estilo5">FORMA DE PAGO  :</span></td>
                 <td width="104"><span class="Estilo5"><input class="Estilo10" name="txttipo_pago" type="text" id="txttipo_pago" size="10" maxlength="10" value="<?echo $tipo_pago?>" readonly></span></td>
                 <td width="200"><span class="Estilo5">N&Uacute;MERO CUENTA TRABAJADOR : </span></td>
                 <td width="230"><span class="Estilo5"> <input class="Estilo10" name="txtcta_empleado" type="text" id="txtcta_empleado" size="28" maxlength="20" value="<?echo $cta_empleado?>" readonly></span></td>
                 <td width="115"><span class="Estilo5">TIPO DE CUENTA  :</span></td>
                 <td width="105"><span class="Estilo5"><input class="Estilo10" name="txttipo_cuenta" type="text" id="txttipo_cuenta" size="12" maxlength="10"  value="<?echo $tipo_cuenta?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="120"><span class="Estilo5">CUENTA EMPRESA :</span></td>
                 <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco" size="4" maxlength="4" value="<?echo $cod_banco?>" readonly></span></td>
                 <td width="394"><span class="Estilo5"><input class="Estilo10" name="txtnombre_banco" type="text" id="txtnombre_banco" size="60" maxlength="100" value="<?echo $nombre_banco?>" readonly> </span></td>
                 <td width="80"><span class="Estilo5">NUMERO : </span></td>
                 <td width="210"><span class="Estilo5"> <input class="Estilo10" name="txtcta_empresa" type="text" id="txtcta_empresa" size="27" maxlength="20" value="<?echo $cta_empresa?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="205"><span class="Estilo5">PRESENTA DECLARACI&Oacute;N JURADA :</span></td>
                 <td width="70"><span class="Estilo5"><input class="Estilo10" name="txttiene_dec_jurada" type="text" id="txttiene_dec_jurada" size="3" maxlength="2"  value="<?echo $tiene_dec_jurada?>" readonly></span></td>
                 <td width="194"><span class="Estilo5">FECHA DECLARACI&Oacute;N JURADA :</span></td>
                 <td width="125"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_declaracion" type="text" id="txtfecha_declaracion" size="11" maxlength="10" value="<?echo $fecha_declaracion?>" readonly></span></td>
                 <td width="140"><span class="Estilo5">MONTO DECLARACI&Oacute;N : </span></td>
                 <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_declaracion" type="text" id="txtmonto_declaracion" size="14" maxlength="14" value="<?echo $monto_declaracion?>" style="text-align:right" readonly></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="115"><span class="Estilo5">COTIZA L.P.H. :</span></td>
                 <td width="70"><span class="Estilo5"><input class="Estilo10" name="txttiene_lph" type="text" id="txttiene_lph" size="3" maxlength="2"  value="<?echo $tiene_lph?>" readonly></span></td>
                 <td width="65"><span class="Estilo5">BANCO :</span></td>
                 <td width="334"><span class="Estilo5"> <input class="Estilo10" name="txtbanco_lph" type="text" id="txtbanco_lph" size="45" maxlength="45"  value="<?echo $banco_lph?>" readonly></span></td>
                 <td width="70"><span class="Estilo5">CUENTA : </span></td>
                 <td width="210"><span class="Estilo5"> <input class="Estilo10" name="txtcta_lph" type="text" id="txtcta_lph" size="27" maxlength="20"   value="<?echo $cta_lph?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="174"><span class="Estilo5">FECHA INSCRIPCI&Oacute;N L.P.H. :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtfecha_lph" type="text" id="txtfecha_lph" size="12" maxlength="10"  value="<?echo $fecha_lph?>" readonly></span></td>
                 <td width="180"><span class="Estilo5">FECHA DESINCORP. L.P.H :</span></td>
                 <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_des_lph" type="text" id="txtfecha_des_lph" size="12" maxlength="10"  value="<?echo $fecha_des_lph?>" readonly></span></td>
                 <td width="150"><span class="Estilo5">TIPO DE TRABAJADOR :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtcont_fijo" type="text" id="txtcont_fijo" size="13" maxlength="13"  value="<?echo $cont_fijo?>" readonly></span></td>

               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <?if($egresado=="N"){?><td width="170"><span class="Estilo5">FECHA PROGRAMADO EGRESO :</span></td>
                 <?}else{?><td width="170"><span class="Estilo5">FECHA DEL EGRESO :</span></td> <?}?>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtfecha_egreso" type="text" id="txtfecha_egreso" size="12" maxlength="10"  value="<?echo $fecha_egreso?>" readonly></span></td>
                 <td width="124"><span class="Estilo5">MOTIVO DEL EGRESO :</span></td>
                 <td width="350"><span class="Estilo5"> <input class="Estilo10" name="txtmotivo_egreso" type="text" id="txtmotivo_egreso" size="55" maxlength="55" value="<?echo $motivo_egreso?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="174"><span class="Estilo5">FECHA FIN DEL CONTRATO :</span></td>
                 <td width="220"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_fin_con" type="text" id="txtfecha_fin_con" size="12" maxlength="10"  value="<?echo $fecha_fin_con?>" readonly></span></td>
                 <td width="190"><span class="Estilo5">JERARQUIA DEL TRABAJADOR :</span></td>
                 <td width="280"><span class="Estilo5"><input class="Estilo10" name="txtjerarquia" type="text" id="txtjerarquia" size="35" maxlength="25"  value="<?echo $jerarquia?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="204"><span class="Estilo5">PAGO VACACIONES POR N&Oacute;MINA :</span></td>
                 <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txttipo_vacaciones" type="text" id="txttipo_vacaciones" size="4" maxlength="2"  value="<?echo $tipo_vacaciones?>" readonly></span></td>
                 <td width="190"><span class="Estilo5">FECHA RETORNO VACACIONES  :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtfecha_pago" type="text" id="txtfecha_pago" size="10" maxlength="10"  value="<?echo $fecha_pago?>" readonly></span></td>
				 <td width="120"><span class="Estilo5">RIF TRABAJADOR :</span></td>
				 <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtrif_empleado" type="text" id="txtrif_empleado" size="12" maxlength="12"  value="<?echo $rif_empleado?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="175"><span class="Estilo5">CODIGO DE UBICACION :</span></td>
                 <td width="155"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_ubicacion" type="text" id="txtcodigo_ubicacion" size="12" maxlength="15"  value="<?echo $codigo_ubicacion?>" readonly></span></td>
                 <td width="534"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_ubi" type="text" id="txtdescripcion_ubi" size="70" maxlength="100"  value="<?echo $descripcion_ubi?>" readonly> </span></td>
                 </tr>
             </table></td>
           </tr>           
           <tr>
             <td><table width="864">
               <tr>
                 <td width="160"><span class="Estilo5">GRADO DE INSTRUCCI&Oacute;N : </span></td>
                 <td width="206"><span class="Estilo5"><input class="Estilo10" name="txgrado_inst" type="text" id="txtgrado_inst" size="25" maxlength="25" value="<?echo $grado_inst?>" readonly> </span></td>
                 <td width="82"><span class="Estilo5">PROFESI&Oacute;N : </span></td>
                 <td width="396"><span class="Estilo5"> <input class="Estilo10" name="txtprofesion" type="text" id="txtprofesion" size="60" maxlength="55" value="<?echo $profesion?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="100"><span class="Estilo5">ESTADO CIVIL  : </span></td>
                 <td width="139"><span class="Estilo5"><input class="Estilo10" name="txtedo_civil" type="text" id="txtedo_civil" size="12" maxlength="12"  value="<?echo $edo_civil?>" readonly></span></td>
                 <td width="55"><span class="Estilo5">SEXO : </span></td>
                 <td width="150"><span class="Estilo5"><input class="Estilo10" name="txtsexo" type="text" id="txtsexo" size="12" maxlength="12"  value="<?echo $sexo?>" readonly></span></td>
                 <td width="150"><span class="Estilo5">FECHA DE NACIMIENTO  :</span></td>
                 <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_nacimiento" type="text" id="txtfecha_nacimiento" size="10" maxlength="10"  value="<?echo $fecha_nacimiento?>" readonly> </span></td>
                 <td width="50"><span class="Estilo5">EDAD : </span></td>
                 <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtedad" type="text" id="txtedad" size="4" maxlength="4" value="<?echo $edad?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="154"><span class="Estilo5">LUGAR DE NACIMIENTO : </span></td>
                 <td width="695"><span class="Estilo5"><input class="Estilo10" name="txtlugar_nacimiento" type="text" id="txtlugar_nacimiento" size="75" maxlength="85"  value="<?echo $lugar_nacimiento?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="860">
               <tr>
                 <td width="85"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                 <td width="745"><textarea name="txtdireccion" cols="84" readonly="readonly" class="Estilo10" id="txtdireccion"><?echo $direccion?></textarea></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                             <td width="73"><span class="Estilo5">ESTADO :</span></td>
                 <td width="323"><span class="Estilo5"><input class="Estilo10" name="txtestado" type="text" id="txtestado" size="30"  value="<?echo $estado?>" readonly>  </span></td>
                 <td width="92"><span class="Estilo5">MUNICIPIO  : </span></td>
                 <td width="355"><span class="Estilo5"><input class="Estilo10" name="txtmunicipio" type="text" id="txtmunicipio" size="40"  value="<?echo $municipio?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="73"><span class="Estilo5">CIUDAD  : </span></td>
                 <td width="323"><span class="Estilo5"><input class="Estilo10" name="txtciudad" type="text" id="txtciudad" size="30"  value="<?echo $ciudad?>" readonly>  </span></td>
                 <td width="92"><span class="Estilo5">PARROQUIA  : </span></td>
                 <td width="355"><span class="Estilo5"><input class="Estilo10" name="txtparroquia" type="text" id="txtparroquia" size="40"  value="<?echo $parroquia?>" readonly></span></td>
              </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="149"><span class="Estilo5">TELEFONO HABITACI&Oacute;N : </span></td>
                 <td width="163"><span class="Estilo5"> <input class="Estilo10" name="txttelefono" type="text" id="txttelefono" size="20" maxlength="20" value="<?echo $telefono?>" readonly></span></td>
                 <td width="165"><span class="Estilo5">TELEFONO MOVIL/CELULAR : </span></td>
                 <td width="172"><span class="Estilo5"> <input class="Estilo10" name="txttlf_movil" type="text" id="txttlf_movil" size="20" maxlength="20"  value="<?echo $tlf_movil?>" readonly></td>
                 <td width="109"><span class="Estilo5">C&Oacute;DIGO POSTAL : </span></td>
                 <td width="78"><span class="Estilo5"><input class="Estilo10" name="txtcod_postal" type="text" id="txtcod_postal" size="5" maxlength="5"  value="<?echo $cod_postal?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="149"><span class="Estilo5">CORREO ELECTRONICO  :</span></td>
                 <td width="308"><span class="Estilo5"> <input class="Estilo10" name="txtcorreo" type="text" id="txtcorreo" size="30" maxlength="40"  value="<?echo $correo?>" readonly></span></td>
                 <td width="142"><span class="Estilo5">APARTADO POSTAL  : </span></td>
                 <td width="241"><span class="Estilo5"> <input class="Estilo10" name="txtaptdo_postal" type="text" id="txtaptdo_postal" size="15" maxlength="20"  value="<?echo $aptdo_postal?>" readonly></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="144"><span class="Estilo5">NRO. POLIZA SEGURO : </span></td>
                 <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtpoliza" type="text" id="txttalla_camisa" size="15" maxlength="15" value="<?echo $poliza?>" readonly> </span></td>
                 <td width="100"><span class="Estilo5">TALLA CAMISA  : </span></td>
                 <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txttalla_camisa" type="text" id="txttalla_camisa" size="3" maxlength="3" value="<?echo $talla_camisa?>" readonly> </span></td>
                 <td width="110"><span class="Estilo5">TALLA PANTALON  : </span></td>
                 <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txttalla_pantalon" type="text" id="txttalla_pantalon" size="3" maxlength="3" value="<?echo $talla_pantalon?>" readonly></span></td>
                 <td width="110"><span class="Estilo5">TALLA CALZADO  : </span></td>
                 <td width="70"><span class="Estilo5"><input class="Estilo10" name="txttalla_calzado" type="text" id="txttalla_calzado" size="3" maxlength="3" value="<?echo $talla_calzado?>" readonly> </span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="200"><span class="Estilo5">TIENE AUSENCIA PROGRAMADA :</span></td>
                 <td width="84"><span class="Estilo5"> <input class="Estilo10" name="txttiene_aus_pro" type="text" id="txttiene_aus_pro" size="3" maxlength="3"  value="<?echo $tiene_aus_pro?>" readonly></span></td>
                 <td width="250"><span class="Estilo5">FECHA PROGRAMADA AUSENCIA DESDE : </span></td>
                 <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_aus_desde" type="text" id="txtfecha_aus_desde" size="10" maxlength="10"  value="<?echo $fecha_aus_desde?>" readonly></span></td>
                 <td width="70"><span class="Estilo5">HASTA : </span></td>
                 <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_aus_hasta" type="text" id="txtfecha_aus_hasta" size="10" maxlength="10"  value="<?echo $fecha_aus_hasta?>" readonly></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="164" ><span class="Estilo5">MOTIVO DE LA AUSENCIA  :</span></td>
                 <td width="690" ><span class="Estilo5"><input class="Estilo10" name="txtmotivo_ausencia" type="text" id="txtmotivo_ausencia" size="80" maxlength="100"  value="<?echo $motivo_ausencia?>" readonly> </span></td>
                 <td width="5"><input class="Estilo10" name="txtcod_cargo" type="hidden" id="txtcod_cargo" value="<?echo $cod_cargo?>" ></td>
                 <td width="5"><input class="Estilo10" name="txtcod_dep" type="hidden" id="txtcod_dep" value="<?echo $cod_departam?>" ></td>
                    
			  </tr>
             </table></td>
           </tr>
         </table>
         <table width="864" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>
              <div id="Layer3" style="position:absolute; width:847px; height:291px; z-index:2; left: 5px; top: 920px;">
                <script language="javascript" type="text/javascript">
   var rows = new Array;
   var num_rows = 1;             //numero de filas
   var width = 848;              //anchura
   for ( var x = 1; x <= num_rows; x++ ) { rows[x] = new Array; }
   rows[1][1] = "Asignaci&oacute;n de Cargo";        // Requiere: <div id="T14" class="tab-body">  ... </div>
   rows[1][2] = "Hoja de Vida";        // Requiere: <div id="T13" class="tab-body">  ... </div>
   rows[1][3] = "Informaci&oacute;n Familiar";        // Requiere: <div id="T12" class="tab-body">  ... </div>
   rows[1][4] = "Experiencia Laboral";        // Requiere: <div id="T13" class="tab-body">  ... </div>
   rows[1][5] = "Informaci&oacute;n Curricular";        // Requiere: <div id="T14" class="tab-body">  ... </div>
   rows[1][6] = "Conceptos";        // Requiere: <div id="T14" class="tab-body">  ... </div>
              </script>
                <?include ("../class/class_tab.php");?>
                <script type="text/javascript" language="javascript"> DrawTabs(); </script>
                 <!--PESTAÑA 1 -->
                <div id="T11" class="tab-body">
                  <iframe src="Det_cons_asig_cargo.php?cod_empleado=<?echo $cod_empleado?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 2 -->
                <div id="T12" class="tab-body" >
                  <iframe src="Det_cons_hoja_vida.php?cod_empleado=<?echo $cod_empleado?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!--PESTAÑA 3 -->
                <div id="T13" class="tab-body" >
                  <iframe src="Det_cons_inf_familiar.php?cod_empleado=<?echo $cod_empleado?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 4 -->
                <div id="T14" class="tab-body">
                  <iframe src="Det_cons_exp_laboral.php?cod_empleado=<?echo $cod_empleado?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 5 -->
                <div id="T15" class="tab-body">
                  <iframe src="Det_cons_inf_curricular.php?cod_empleado=<?echo $cod_empleado?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 6 -->
                <div id="T16" class="tab-body">
                  <iframe src="Det_cons_conc_asig.php?cod_empleado=<?echo $cod_empleado?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
              </div>
              </td>
            </tr>
          </table>
       </div>
      </form>
<form name="form2" method="post" action="Inc_info_trabajadores.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
	 <td width="5"><input class="Estilo10" name="txtcedula_c" type="hidden" id="txtcedula_c" value="" ></td>	 
     <td width="5"><input class="Estilo10" name="txttipo_nomina" type="hidden" id="txttipo_nomina" value="<?echo $temp_nomina?>" ></td>	
     <td width="5"><input class="Estilo10" name="txtdes_nomina" type="hidden" id="txtdes_nomina" value="<?echo $temp_des_nomina?>" ></td>	
     <td width="5"><input class="Estilo10" name="txtregion_e" type="hidden" id="txtregion_e" value="<?echo $reg_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtestado_e" type="hidden" id="txtestado_e" value="<?echo $edo_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtmunicipio_e" type="hidden" id="txtmunicipio_e" value="<?echo $mun_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtciudad_e" type="hidden" id="txtciudad_e" value="<?echo $ciu_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtparroquia_e" type="hidden" id="txtparroquia_e" value="<?echo $mun_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcod_estado" type="hidden" id="txtcod_estado" value="<?echo $cod_e?>" ></td>
     <td width="5"><input class="Estilo10" name="txtcod_municipio" type="hidden" id="txtcod_municipio" value="<?echo $cod_m?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtformato_trab" type="hidden" id="txtformato_trab" value="<?echo $formato_trab?>" ></td>
     <td width="5"><input class="Estilo10" name="txtprimero_apellido" type="hidden" id="txtprimero_apellido" value="<?echo $primero_apellido?>" ></td>
  </tr>
</table>
</form>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close();?>