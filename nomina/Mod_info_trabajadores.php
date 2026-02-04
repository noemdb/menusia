<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc"); $equipo=getenv("COMPUTERNAME"); $mcod_m="TRAB".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49); $fecha_hoy=asigna_fecha_hoy();
if ($gnomina=="00"){ $criterion="";$criterioc="";}else{ $criterion=" where tipo_nomina='$gnomina' ";  $criterioc=" and tipo_nomina='$gnomina' ";}
if (!$_GET){$cod_empleado="";$Gcedula="";} else{$cod_empleado=$_GET["Gcod_empleado"];$Gcedula=$_GET["Gcedula"];} $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
$cod_modulo="04";$campo502="NNNNNNNNNNNNNNNNNNNN";$sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"];}$p_apellido=substr($campo502,18,1);
//echo $Cod_Emp;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<LINK REL="SHORTCUT ICON" HREF="../imagenes/sia.ico">
<html>
<head>
<title>SIPAP N&Oacute;MINA Y PERSONAL (Informaci&oacute;n Trabajadores)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../class/sia.js" type="text/javascript"></script>
<script language="javascript" src="ajax_nom.js" type="text/javascript"></script>
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
var muser='<?php echo $user ?>';
var mpassword='<?php echo $password ?>';
var mdbname='<?php echo $dbname ?>';
var mcodigo_mov='<?php echo $codigo_mov ?>';
var mp_apellido='<?php echo $p_apellido ?>';
function chequea_nombre(mform){
var mnombre; var mnombre2; var mnombre2; var mapellido1; var mapellido2;
   mnombre1=mform.txtnombre1.value;  mnombre2=mform.txtnombre2.value; mapellido1=mform.txtapellido1.value; mapellido2=mform.txtapellido2.value;
   mnombre=mnombre1+' '+mnombre2+' '+mapellido1+' '+mapellido2;
   if(mp_apellido=="S"){ mnombre=mapellido1+' '+mapellido2+' '+mnombre1+' '+mnombre2;  }
   mform.txtnombre.value=mnombre;
return true;}
function chequea_fecha(mthis){var mref; var mfec;   mref=mthis.value;
  if(mref.length==8){mfec=mref.substring(0,6)+"20"+mref.charAt(6)+mref.charAt(7); mthis.value=mfec;}
return true;}
function chequea_fecha_nac(mform){ var mfecha; var mref=mform.txtfecha_nacimiento.value; var mfec; var yearn; var miFecha; var dif;
var mhoy=new Date();  var year=mhoy.getFullYear(); var mmonth=mhoy.getMonth(); var mday=mhoy.getDate(); var ano=2000; var mes; var dia; mfecha=mref;
 if(mfecha.length==8){mfec=mfecha.substring(0,6)+"20"+mfecha.charAt(6)+mfecha.charAt(7);  mform.txtfecha_nacimiento.value=mfec; mfecha=mref;}
 dia=mfecha.charAt(0)+mfecha.charAt(1); dia=dia*1; mes=mfecha.charAt(3)+mfecha.charAt(4); ano=mfecha.charAt(6)+mfecha.charAt(7)+mfecha.charAt(8)+mfecha.charAt(9);
 miFecha=new Date(ano,mes-1,dia);  yearn=miFecha.getFullYear(); dif=mhoy-miFecha; dif=dif/(86400000*365); dif=year-yearn;
 if(mmonth<(mes-1)){dif=dif-1;} if((mmonth==(mes-1))&&(dia>mday)){dif=dif-1; } mform.txtedad.value=dif;
return true;}
function apaga_fec_ing(mthis){apagar(mthis);
  document.form1.txtfecha_ing_adm.value=mthis.value;
return true;}
function chequea_tipo(mform){var mref;
   mref=mform.txttipo_nomina.value; mref = Rellenarizq(mref,"0",2); mform.txttipo_nomina.value=mref;
return true;}
function apaga_status(mthis){var mstat;
  apagar(mthis);
  mstat=document.form1.txtstatus.value;
  if(mstat=="REPOSO"){document.form1.txttiene_aus_pro.options[1].selected=true; document.form1.txtmotivo_ausencia.value="REPOSO";}
  if(mstat=="VACACIONES"){document.form1.txttiene_aus_pro.options[1].selected=true; document.form1.txtmotivo_ausencia.value="VACACIONES";}
return true;}
function carga_ced_trab(){ var murl; var Gcod_empleado=""; var Gcedula_emp="";
	murl='Mod_info_trabajadores.php?Gcod_empleado=';
	Gcod_empleado=document.form1.txtcod_empleado.value; Gcedula_emp=document.form1.txtcedula.value; 
	murl=murl+Gcod_empleado+"&Gcedula="+Gcedula_emp;
    document.location = murl;
	
}
function camb_nombre(){ var f=document.form1; var mnombre; var mnombre2; var mnombre2; var mapellido1; var mapellido2;
   mnombre1=f.txtnombre1.value;  mnombre2=f.txtnombre2.value; mapellido1=f.txtapellido1.value; mapellido2=f.txtapellido2.value;
   f.txtnombre1.value=mapellido1;   f.txtnombre2.value=mapellido2;   f.txtapellido1.value=mnombre1;   f.txtapellido2.value=mnombre2;
return true;}
function revisar(){var f=document.form1;
    if(f.txtcedula.value==""){alert("Cedula del Trabajador no puede estar Vacio");return false;}else{f.txtcedula.value=f.txtcedula.value.toUpperCase();}
    if(f.txtcod_empleado.value==""){alert("Codigo del Trabajador no puede estar Vacio");return false;}
    if(f.txtnombre.value==""){alert("Nombre del Trabajador no puede estar Vacia"); return false; } else{f.txtnombre.value=f.txtnombre.value.toUpperCase();}
    if(f.txttipo_nomina.value==""){alert("Tipo de Nomina no puede estar Vacio");return false;}else{f.txttipo_nomina.value=f.txttipo_nomina.value.toUpperCase();}
    f.txtdireccion.value=f.txtdireccion.value.toUpperCase();
    document.form1.submit;
return true;}
</script>
</head>
<body>
 <?
$nombre=""; $nacionalidad=""; $descripcion=""; $cod_jerarquia=""; $codigo_ubicacion=""; $descripcion_ubi=""; $cedula=""; $campo_str1="";  $campo_num1=0;
$tipo_nomina=""; $nacionalidad=""; $status=""; $fecha_ingreso=""; $fecha_ing_adm=""; $cod_categoria=""; $tipo_pago=""; $cta_empleado=""; $tipo_cuenta=""; $cod_banco=""; $nombre_banco=""; $cta_empresa=""; $calculo_grupos=""; $fecha_asigna_cargo=""; $cod_cargo=""; $cod_departam=""; $cod_tipo_personal=""; $paso=""; $grado=""; $sueldo=""; $prima=""; $compensacion=""; $otros=""; $sueldo_integral=""; $tipo_vacaciones="N"; $pago_vaciones="N"; $fecha_pago=""; $tiene_lph=""; $banco_lph=""; $cta_lph=""; $fecha_lph=""; $fecha_des_lph=""; $modif_lph=""; $tiene_dec_jurada=""; $fecha_declaracion=""; $monto_declaracion=""; $fecha_fin_con=""; $fecha_egreso=""; $motivo_egreso=""; $cont_fijo=""; $cod_cont_colec=""; $tipo_nom_ant=""; $cod_emp_ant=""; $fecha_camb_n=""; $motivo_camb_n=""; $tiene_aus_pro=""; $motivo_ausencia=""; $fecha_aus_desde=""; $fecha_aus_hasta="";  $motivo_suplen=""; $cedula_titular="";
$nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $sexo=""; $edo_civil=""; $fecha_nacimiento=""; $edad=""; $lugar_nacimiento=""; $direccion=""; $cod_postal=""; $telefono=""; $tlf_movil=""; $correo=""; $profesion=""; $grado_inst=""; $tiempo_e=""; $poliza=""; $fecha_seguro=""; $estado=""; $ciudad=""; $municipio=""; $parroquia=""; $observacion=""; $talla_camisa=""; $talla_pantalon=""; $talla_calzado=""; $peso=""; $estatura=""; $aptdo_postal=""; $rif_empleado="";
$sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado' ".$criterioc.""; $res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"];   $status=$registro["status"];
  $fecha_ingreso=$registro["fecha_ingreso"]; $fecha_ing_adm=$registro["fecha_ing_adm"]; $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);  $fecha_ing_adm=formato_ddmmaaaa($fecha_ing_adm);
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
  $inf_usuario=$registro["inf_usuario"]; $monto_declaracion=formato_monto($monto_declaracion); $edad=round($edad); $campo_num1=round($campo_num1);
} 
if($Gcedula<>""){ $sql="Select * from TRABAJADORES where cedula='$Gcedula'"; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){ $registro=pg_fetch_array($res,0); 
  $cedula=$registro["cedula"]; $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"]; 
  $tipo_pago=$registro["tipo_pago"]; $cta_empleado=$registro["cta_empleado"]; $tipo_cuenta=$registro["tipo_cuenta"];
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $cta_empresa=$registro["cta_empresa"]; 
  $cod_jerarquia=$registro["cod_jerarquia"];  $tiene_dec_jurada=$registro["tiene_dec_jurada"]; 
  $fecha_declaracion=$registro["fecha_declaracion"]; $monto_declaracion=$registro["monto_declaracion"];  $fecha_declaracion=formato_ddmmaaaa($fecha_declaracion);
  $tiene_lph=$registro["tiene_lph"]; $banco_lph=$registro["banco_lph"]; $cta_lph=$registro["cta_lph"]; $fecha_lph=$registro["fecha_lph"]; $fecha_des_lph=$registro["fecha_des_lph"]; $modif_lph=$registro["modif_lph"]; $fecha_lph=formato_ddmmaaaa($fecha_lph); $fecha_des_lph=formato_ddmmaaaa($fecha_des_lph);
  $fecha_fin_con=$registro["fecha_fin_con"]; $fecha_egreso=$registro["fecha_egreso"]; $motivo_egreso=$registro["motivo_egreso"]; $cont_fijo=$registro["cont_fijo"];  $fecha_fin_con=formato_ddmmaaaa($fecha_fin_con);  $fecha_egreso=formato_ddmmaaaa($fecha_egreso);
  $cod_jerarquia=$registro["cod_jerarquia"];  $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $rif_empleado=$registro["rif_empleado"];
  $apellido1=$registro["apellido1"];$apellido2=$registro["apellido2"]; $direccion=$registro["direccion"];$grado_inst=$registro["grado_inst"]; $profesion=$registro["profesion"]; $campo_str1=$registro["campo_str1"];
  $sexo=$registro["sexo"]; $edo_civil=$registro["edo_civil"]; $fecha_nacimiento=$registro["fecha_nacimiento"]; $edad=$registro["edad"];  $fecha_nacimiento=formato_ddmmaaaa($fecha_nacimiento);
  $lugar_nacimiento=$registro["lugar_nacimiento"]; $cod_postal=$registro["cod_postal"]; $telefono=$registro["telefono"];  $tlf_movil=$registro["tlf_movil"];  $correo=$registro["correo"];
  $estado=$registro["estado"]; $ciudad=$registro["ciudad"]; $municipio=$registro["municipio"]; $parroquia=$registro["parroquia"]; $aptdo_postal=$registro["aptdo_postal"];
  $observacion=$registro["observacion"]; $talla_camisa=$registro["talla_camisa"]; $talla_pantalon=$registro["talla_pantalon"]; $talla_calzado=$registro["talla_calzado"]; $campo_num1=$registro["campo_num1"];
  $edad=round($edad);  $campo_num1=round($campo_num1); //$monto_declaracion=formato_monto($monto_declaracion);
} }
if($tiene_dec_jurada=="S"){$tiene_dec_jurada="SI";}else{$tiene_dec_jurada="NO"; $monto_declaracion=0;} if($tiene_lph=="S"){$tiene_lph="SI";}else{$tiene_lph="NO";}  $sfecha=formato_aaaammdd($fecha_hoy);
If(($status=="INACTIVO")Or($status=="JUBILADO")Or($status=="PENSIONADO")Or($status=="RETIRADO")Or($status=="DESPEDIDO")Or($status=="RENUNCIA")Or($status=="FALLECIDO")Or($status=="AÑO SABATICO")Or($status=="VACANTE")){$egresado="S";}else{$egresado="N";}
If($cont_fijo=="F"){$cont_fijo="FIJO";} If($cont_fijo=="C"){$cont_fijo="CONTRATADO";} If($cont_fijo=="S"){$cont_fijo="SUPLENTE";}
if($tipo_vacaciones=="N"){$tipo_vacaciones="NO";$fecha_pago="";}else{$tipo_vacaciones="SI";} if($tiene_aus_pro=="N"){$tiene_aus_pro="NO";$fecha_aus_desde="";$fecha_aus_hasta="";}else{$tiene_aus_pro="SI";}
$jerarquia="OTROS"; if($cod_jerarquia=="01"){$jerarquia="ADMINISTRATIVO";} if($cod_jerarquia=="02"){$jerarquia="PROFESIONALES Y TECNICOS";} if($cod_jerarquia=="03"){$jerarquia="ALTO NIVEL";} if($cod_jerarquia=="04"){$jerarquia="OBREROS";}
if($tiene_aus_pro=="NO"){$fecha_aus_desde=$fecha_hoy; $fecha_aus_hasta=$fecha_hoy;}
$sSQL="SELECT ACTUALIZA_NOM067(4,'$codigo_mov','','$sfecha','','','')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sSQL="SELECT ACTUALIZA_NOM068(4,'$codigo_mov','','$sfecha','','','','','','','','',0,0,0,0,0)"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sSQL="SELECT ACTUALIZA_NOM069(4,'$codigo_mov','','','','','$sfecha',0,'')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sSQL="SELECT ACTUALIZA_NOM070(4,'$codigo_mov','','$sfecha','$sfecha','','','',0)"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sSQL="SELECT ACTUALIZA_NOM071(4,'$codigo_mov','','$sfecha','')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
$sql="SELECT * FROM NOM013 where cod_empleado='$cod_empleado' order by fecha"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){  $sfecha=$registro["fecha"]; $observacion=$registro["observacion"];
  $sSQL="SELECT ACTUALIZA_NOM071(1,'$codigo_mov','$cod_empleado','$sfecha','$observacion')";
  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
}
$sql="SELECT * FROM ASIG_CARGO  where cod_empleado='$cod_empleado' order by fecha_asigna"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){  $sfecha=$registro["fecha_asigna"]; $cod_cargo=$registro["cod_cargo"];  $cod_departamento=$registro["cod_departamento"];  $des_cargo=$registro["des_cargo"];   $des_departamento=$registro["des_departamento"]; $cod_tipo_personal=$registro["cod_tipo_personal"]; $paso=$registro["paso"]; $grado=$registro["grado"]; $observacion=""; $sueldo=$registro["sueldo"];  $compensacion=$registro["compensacion"]; $prima=$registro["prima"];
 $sSQL="SELECT ACTUALIZA_NOM068(1,'$codigo_mov','$cod_empleado','$sfecha','$cod_cargo','$cod_departamento','$des_cargo','$des_departamento','$cod_tipo_personal','$paso','$grado','$observacion',$sueldo,$prima,$compensacion,0,0)";
 $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
}
$sql="SELECT * FROM NOM010  where cod_empleado='$cod_empleado' order by fecha_desde"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $fechad=$registro["fecha_desde"]; $fechah=$registro["fecha_hasta"]; $monto_s=$registro["sueldo"]; $empresa=$registro["empresa"]; $depar=$registro["departamento"]; $cargo=$registro["cargo"];
 $sSQL="SELECT ACTUALIZA_NOM070(1,'$codigo_mov','$cod_empleado','$fechad','$fechah','$empresa','$depar','$cargo',$monto_s)";
 $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
}
$sql="SELECT * FROM NOM014 where cod_empleado='$cod_empleado' order by fecha"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){$fechac=$registro["fecha"]; $titulo=$registro["titulo"]; $instituto=$registro["instituto"];  $descripcion_c=$registro["descripcion"];
  $sSQL="SELECT ACTUALIZA_NOM067(1,'$codigo_mov','$cod_empleado','$fechac','$titulo','$instituto','$descripcion_c')";
  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
}
$sql="SELECT * FROM NOM009 where cod_empleado='$cod_empleado' order by ci_partida"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $sfecha=$registro["fecha_nac"]; $cedulaf=trim($registro["ci_partida"]);$nombref=$registro["nombre"];$sexof=$registro["sexo"];$edadf=$registro["edad"];$parentesco=$registro["parentesco"];
 $status=$registro["status"];
 $sSQL="SELECT ACTUALIZA_NOM069(1,'$codigo_mov','$cod_empleado','$cedulaf','$nombref','$sexof','$sfecha',$edadf,'$parentesco','$status','',0)";
 $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
}
$Ssql="select * from SIA000"; $resultado=pg_query($Ssql);if ($registro=pg_fetch_array($resultado,0)){$reg_e=$registro["campo041"];$edo_e=$registro["campo010"];$mun_e=$registro["campo011"];$ciu_e=$registro["campo009"];}else{$reg_e="REGION CENTRO-OCCIDENTAL";$edo_e="LARA";$mun_e="IRIBARREN";$ciu_e="BARQUISIMETO";}
$cod_e="00"; $Ssql="select * FROM pre091 where estado='".$edo_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_e=$registro["cod_estado"];}
$cod_m="00"; $Ssql="select * FROM PRE093 where nombre_municipio='".$mun_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_m=$registro["cod_municipio"];}
$cod_p=$cod_m."00"; $Ssql="select * from PRE096 where substr(cod_parroquia,1,4)='".$cod_m."'  Order by cod_parroquia"; $resultado=pg_query($Ssql); if($registro=pg_fetch_array($resultado,0)){$cod_p=$registro["cod_parroquia"];}
$cod_estado=""; $Ssql="SELECT * FROM pre091 where estado='".$estado."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_estado=$registro["cod_estado"];}if($cod_estado==""){ $cod_estado=$cod_e; $estado=$edo_e;}
$cod_muni=$cod_estado."01"; $Ssql="select * FROM PRE093 where nombre_municipio='".$municipio."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$cod_muni=$registro["cod_municipio"];} else { $cod_muni=$cod_m; } 
if($municipio==""){ $Ssql="select * FROM PRE093 where cod_municipio='".$cod_muni."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$municipio=$registro["nombre_municipio"];}  };
pg_close();
?>
<body>
<table width="978" height="38" border="0" bgcolor="#000066">
  <tr>
    <td width="73"><div align="center" class="Estilo2 Estilo4"><img src="../imagenes/Logo_sia.gif" width="72" height="42"></div></td>
    <td width="836"><div align="center" class="Estilo2 Estilo6">MODIFICAR INFORMACI&Oacute;N TRABAJADORES</div></td>
    <td width="55" class="Estilo2"><strong class="Estilo2 Estilo9">VER 6.0 </strong></td>
  </tr>
</table>
<table width="978" height="1345" border="1" id="tablacuerpo">
  <tr>
    <td width="92" height="1340"><table width="92" height="1340" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF" id="tablamenu">
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('Act_info_trabajadores.php?Gcod_empleado=C<?echo $cod_empleado?>')";
          onMouseOut="this.style.backgroundColor='#EAEAEA' "o"];" height="30"  bgcolor=#EAEAEA><a class=menu href="Act_info_trabajadores.php?Gcod_empleado=C<?echo $cod_empleado?>">Atras</a></td>
      </tr>
      <tr>
        <td onMouseOver="this.style.backgroundColor='#CCCCCC';this.style.cursor='hand';" onClick="javascript:LlamarURL('menu.php')";
          onMouseOut="this.style.backgroundColor='#EAEAEA'"o"];" height="30"  bgcolor=#EAEAEA><a class=menu href="menu.php">Menu</a></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>

    <td width="890">       <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><b></b></font>
      <div id="Layer1" style="position:absolute; width:867px; height:472px; z-index:1; top: 68px; left: 119px;">
        <form name="form1" method="post" action="Update_trabajadores.php" onSubmit="return revisar()">

        <table width="865" border="0" >
           <tr>
             <td><table width="865">
               <tr>
                 <td width="140"><span class="Estilo5">C&Oacute;DIGO TRABAJADOR :</span></td>
                 <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtcod_empleado" type="text" id="txtcod_empleado" size="15" maxlength="15"  value="<?echo $cod_empleado?>" readonly></span></td>
                 <td width="150"><span class="Estilo5">C&Eacute;DULA DE IDENTIDAD :</span></td>
                 <td width="110"><span class="Estilo5"> <input class="Estilo10" name="txtcedula" type="text" id="txtcedula" size="12" maxlength="10"  value="<?echo $cedula?>" ></span></td>
                 <?if($Cod_Emp=="32"){?>
                  <td width="55"><input class="Estilo10" name="btcargaced" type="button" id="btcargaced" title="Carga Cedula de Trabajador" onclick="javascript:carga_ced_trab();" value="..."></td>
                          <?} else {?>
			     <td width="55">&nbsp;</td>
			     <?}?>	
				 <td width="100"><span class="Estilo5">NACIONALIDAD : </span></td>
<script language="JavaScript" type="text/JavaScript"> function asig_nacionalidad(mvalor){var f=document.form1;  if(mvalor=="VENEZOLANO"){document.form1.txtnacionalidad.options[0].selected = true;}else{document.form1.txtnacionalidad.options[1].selected = true;}} </script>
                 <td width="120"><span class="Estilo5"><select class="Estilo10" name="txtnacionalidad" size="1" id="txtnacionalidad" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>VENEZOLANO</option> <option>EXTRANJERO</option> </select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_nacionalidad('<?echo $nacionalidad;?>');</script>
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
                 <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtnombre1" type="text" id="txtnombre1" size="20" maxlength="20" value="<?echo $nombre1?>" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_nombre(this.form);"> </span></td>
                 <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtnombre2" type="text" id="txtnombre2" size="20" maxlength="20" value="<?echo $nombre2?>" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_nombre(this.form);"> </span></td>
                 <td width="75"><span class="Estilo5">APELLIDOS :</span></td>
                 <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtapellido1" type="text" id="txtapellido1" size="20" maxlength="20" value="<?echo $apellido1?>" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_nombre(this.form);"></span></td>
                 <td width="175"><span class="Estilo5"><input class="Estilo10" name="txtapellido2" type="text" id="txtapellido2" size="20" maxlength="20" value="<?echo $apellido2?>" onFocus="encender(this)" onBlur="apagar(this)" onchange="chequea_nombre(this.form);"></span></td>
                 <td width="25"><input class="Estilo10" name="btcambia" type="button" id="btcambia" title="cambia nombres y apellidos" onclick="javascript:camb_nombre();" value="..."></td>
                 
			  </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">
function asig_status(mvalor){var f=document.form1;
    if(mvalor=="ACTIVO"){document.form1.txtstatus.options[0].selected = true;}
        if(mvalor=="AÑO SABATICO"){document.form1.txtstatus.options[1].selected = true;}
        if(mvalor=="DESPEDIDO"){document.form1.txtstatus.options[2].selected = true;}
        if(mvalor=="FALLECIDO"){document.form1.txtstatus.options[3].selected = true;}
        if(mvalor=="INACTIVO"){document.form1.txtstatus.options[4].selected = true;}
        if(mvalor=="JUBILADO"){document.form1.txtstatus.options[5].selected = true;}
        if(mvalor=="PERMISO RE"){document.form1.txtstatus.options[6].selected = true;}
        if(mvalor=="PERMISO NO"){document.form1.txtstatus.options[7].selected = true;}
        if(mvalor=="PENSIONADO"){document.form1.txtstatus.options[8].selected = true;}
        if(mvalor=="REPOSO"){document.form1.txtstatus.options[9].selected = true;}
        if(mvalor=="RENUNCIA"){document.form1.txtstatus.options[10].selected = true;}
        if(mvalor=="RETIRADO"){document.form1.txtstatus.options[11].selected = true;}
        if(mvalor=="SUSPENDIDO"){document.form1.txtstatus.options[12].selected = true;}
        if(mvalor=="VACACIONES"){document.form1.txtstatus.options[13].selected = true;}
        if(mvalor=="VACANTE"){document.form1.txtstatus.options[14].selected = true;}
		if(mvalor=="REMOCION"){document.form1.txtstatus.options[15].selected = true;}
}</script>

           <tr>
             <td><table width="864">
               <tr>
                 <td width="120"><span class="Estilo5">FECHA INGRESO  :</span></td>
                 <td width="110"><span class="Estilo5"><input class="Estilo10" name="txtfecha_ingreso" type="text" id="txtfecha_ingreso" size="11" maxlength="10"  onFocus="encender(this)" onBlur="apaga_fec_ing(this)" value="<?echo $fecha_ingreso?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return tabular(event,this)"></span></td>
                 <td width="214"><span class="Estilo5">FECHA ING. ADMINIST. PUBLICA :</span></td>
                 <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_ing_adm" type="text" id="txtfecha_ing_adm" size="11" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_ing_adm?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)" onkeypress="return tabular(event,this)"></span></td>
                 <td width="200"><span class="Estilo5">A&Ntilde;OS ANTIGUEDAD ACUMULADO :</span></td>
				 <td width="50"><span class="Estilo5"> <input class="Estilo10" name="txtcampo_num1" type="text" id="txtcampo_num1" size="2" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)"   value="<?echo $campo_num1?>"  > </span></td>
               
               </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="864">
               <tr>
                  <td width="200"><span class="Estilo5">ESTATUS DEL TRABAJADOR : </span></td>
                 <td width="664"><span class="Estilo5"><select class="Estilo10" name="txtstatus" size="1" id="txtstatus" onFocus="encender(this)" onBlur="apagar(this)" onkeypress="return tabular(event,this)">
                     <option>ACTIVO</option>  <option>A&Ntilde;O SABATICO</option>  <option>DESPEDIDO</option>
                     <option>FALLECIDO</option> <option>INACTIVO</option>  <option>JUBILADO</option>
                     <option>PERMISO RE</option>  <option>PERMISO NO</option> <option>PENSIONADO</option>
                     <option>REPOSO</option>  <option>RENUNCIA</option><option>RETIRADO</option>
                     <option>SUSPENDIDO</option>  <option>VACACIONES</option> <option>VACANTE</option> <option>REMOCION</option>
                 </select> </span></td>
				
				
				</tr>
             </table></td>
           </tr>
		   
		   <script language="JavaScript" type="text/JavaScript"> asig_status('<?echo $status;?>');</script>
		   
          
           <tr>
             <td><table width="864">
               <tr>
                 <td width="144"><span class="Estilo5">TIPO DE N&Oacute;MINA :</span></td>
                 <td width="100"><span class="Estilo5"> <input class="Estilo10" name="txttipo_nomina" type="text" id="txttipo_nomina" size="2" maxlength="2" value="<?echo $tipo_nomina?>" readonly > </span></td>
                 <td width="620"><span class="Estilo5"><input class="Estilo10" name="txtdes_nomina" type="text" id="txtdes_nomina" size="90" maxlength="100" value="<?echo $descripcion?>" readonly> </span></td>
                </tr>
             </table></td>
           </tr>
		   <tr>
             <td><table width="864">
               <tr>
                 <td width="144"><span class="Estilo5">CODIGO CATEGORIA : </span></td>
                 <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtcod_cat_alter" type="text" id="txtcod_cat_alter" size="16" maxlength="16" value="<?echo $cod_categoria?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                 <td width="60"><input class="Estilo10" name="btcodcat" type="button" id="btcodcat" title="Abrir Catalogo Categorias"  onClick="VentanaCentrada('Cat_codigos_cat.php?criterio=','SIA','','750','500','true')" value="..."> </span></td>
                 <td width="175"><span class="Estilo5">FUENTE DE FINANCIAMIENTO :</span></td>
				 <td width="50"><span class="Estilo5"><span class="Estilo5"><input class="Estilo10" name="txtcod_fuente" type="text" id="txtcod_fuente" size="2" maxlength="2" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $campo_str1?>">  </span></td>
				 <td width="45"><input class="Estilo10" name="btfuente" type="button" id="btfuente" title="Abrir Catalogo Fuentes de Financiamiento" onclick="VentanaCentrada('../presupuesto/Cat_fuentes.php?criterio=','SIA','','750','500','true')" value="..."></td>
                 <td width="250"><span class="Estilo5"> <input class="Estilo10" name="txtdes_fuente" type="text" id="txtdes_fuente" size="35" readonly> </span></td>
				</tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">
function asig_forma_pago(mvalor){var f=document.form1;
    if(mvalor=="EFECTIVO"){document.form1.txttipo_pago.options[0].selected = true;}
        if(mvalor=="CHEQUE"){document.form1.txttipo_pago.options[1].selected = true;}
        if(mvalor=="DEPOSITO"){document.form1.txttipo_pago.options[2].selected = true;}
        if(mvalor=="RECIBO"){document.form1.txttipo_pago.options[3].selected = true;}
}
function asig_tipo_cuenta(mvalor){var f=document.form1;
    if(mvalor=="AHORRO"){document.form1.txttipo_cuenta.options[0].selected = true;}
        if(mvalor=="CORRIENTE"){document.form1.txttipo_cuenta.options[1].selected = true;}
        if(mvalor=="FAL"){document.form1.txttipo_cuenta.options[2].selected = true;}
}</script>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="110"><span class="Estilo5">FORMA DE PAGO  :</span></td>
                 <td width="104"><span class="Estilo5"><select class="Estilo10" name="txttipo_pago" size="1" id="txttipo_pago" onFocus="encender(this)" onBlur="apagar(this)">
                   <option>EFECTIVO</option><option>CHEQUE</option><option>DEPOSITO</option> <option>RECIBO</option></select></span></td>
<script language="JavaScript" type="text/JavaScript"> asig_forma_pago('<?echo $tipo_pago;?>');</script>
                 <td width="200"><span class="Estilo5">N&Uacute;MERO CUENTA TRABAJADOR : </span></td>
                 <td width="220"><span class="Estilo5"> <input class="Estilo10" name="txtcta_empleado" type="text" id="txtcta_empleado" size="28" maxlength="20" value="<?echo $cta_empleado?>"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="120"><span class="Estilo5">TIPO DE CUENTA  :</span></td>
                 <td width="110"><span class="Estilo5"><select class="Estilo10" name="txttipo_cuenta" size="1" id="txttipo_cuenta" onFocus="encender(this)" onBlur="apagar(this)">
                   <option>AHORRO</option>  <option>CORRIENTE</option> <option>FAL</option> </select></span></td>
                </tr>
<script language="JavaScript" type="text/JavaScript"> asig_tipo_cuenta('<?echo $tipo_cuenta;?>');</script>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="130"><span class="Estilo5">CUENTA EMPRESA :</span></td>
                 <td width="60"><span class="Estilo5"><input class="Estilo10" name="txtcod_banco" type="text" id="txtcod_banco" value="<?echo $cod_banco?>" size="4" maxlength="4"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="40"><input class="Estilo10" name="btcod_banco" type="button" id="btcod_banco" title="Abrir Catalogo de Bancos" onclick="VentanaCentrada('Cat_bancos.php?criterio=','SIA','','750','500','true')" value="..."></td>
                 <td width="360"><span class="Estilo5"><input class="Estilo10" name="txtnombre_banco" type="text" id="txtnombre_banco" value="<?echo $nombre_banco?>" size="60" maxlength="100"  onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                 <td width="74"><span class="Estilo5">NUMERO : </span></td>
                 <td width="200"><span class="Estilo5"> <input class="Estilo10" name="txtnro_cuenta" type="text" id="txtnro_cuenta" size="24" maxlength="20" value="<?echo $cta_empresa?>"  onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
<script language="JavaScript" type="text/JavaScript"> function asig_tiene_dec(mvalor){var f=document.form1;  if(mvalor=="SI"){document.form1.txttiene_dec_jurada.options[0].selected = true;}else{document.form1.txttiene_dec_jurada.options[1].selected = true;}} </script>
               <tr>
                 <td width="205"><span class="Estilo5">PRESENTA DECLARACI&Oacute;N JURADA :</span></td>
                 <td width="70"><span class="Estilo5"><select class="Estilo10" name="txttiene_dec_jurada" size="1" id="txttiene_dec_jurada" onFocus="encender(this)" onBlur="apagar(this)"><option>SI</option> <option>NO</option></select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_tiene_dec('<?echo $tiene_dec_jurada;?>');</script>
                 <td width="194"><span class="Estilo5">FECHA DECLARACI&Oacute;N JURADA :</span></td>
                 <td width="125"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_declaracion" type="text" id="txtfecha_declaracion" size="11" maxlength="10" value="<?echo $fecha_declaracion?>"  onFocus="encender(this)" onBlur="apagar(this)"  onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="140"><span class="Estilo5">MONTO DECLARACI&Oacute;N : </span></td>
                 <td width="130"><span class="Estilo5"> <input class="Estilo10" name="txtmonto_declaracion" type="text" id="txtmonto_declaracion" size="14" maxlength="14" value="<?echo $monto_declaracion?>"  onFocus="encender(this)" onBlur="apagar(this)"  style="text-align:right"></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
<script language="JavaScript" type="text/JavaScript"> function asig_tiene_lph(mvalor){var f=document.form1;  if(mvalor=="SI"){document.form1.txttiene_lph.options[0].selected = true;}else{document.form1.txttiene_lph.options[1].selected = true;}} </script>
               <tr>
                 <td width="115"><span class="Estilo5">COTIZA L.P.H. :</span></td>
                 <td width="70"><span class="Estilo5"><select class="Estilo10" name="txttiene_lph" size="1" id="txttiene_lph" onFocus="encender(this)" onBlur="apagar(this)"><option>SI</option> <option>NO</option></select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_tiene_dec('<?echo $tiene_lph;?>');</script>
                 <td width="65"><span class="Estilo5">BANCO :</span></td>
                 <td width="334"><span class="Estilo5"> <input class="Estilo10" name="txtbanco_lph" type="text" id="txtbanco_lph" size="45" maxlength="45" value="<?echo $banco_lph?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="70"><span class="Estilo5">CUENTA : </span></td>
                 <td width="210"><span class="Estilo5"> <input class="Estilo10" name="txtcta_lph" type="text" id="txtcta_lph" size="27" maxlength="20" value="<?echo $cta_lph?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="174"><span class="Estilo5">FECHA INSCRIPCI&Oacute;N L.P.H. :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtfecha_lph" type="text" id="txtfecha_lph" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_lph?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="170"><span class="Estilo5">FECHA DESINCORP. L.P.H :</span></td>
                 <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_des_lph" type="text" id="txtfecha_des_lph" size="12" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_des_lph?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
<script language="JavaScript" type="text/JavaScript"> function asig_cont_fijo(mvalor){var f=document.form1;  if(mvalor=="FIJO"){document.form1.txtcont_fijo.options[0].selected = true;}        if(mvalor=="CONTRATADO"){document.form1.txtcont_fijo.options[1].selected = true;}   if(mvalor=="SUPLENTE"){document.form1.txtcont_fijo.options[2].selected = true;} }</script>
                 <td width="150"><span class="Estilo5">TIPO DE TRABAJADOR :</span></td>
                 <td width="130"><span class="Estilo5"><select class="Estilo10" name="txtcont_fijo" size="1" id="txtcont_fijo" onFocus="encender(this)" onBlur="apagar(this)">
                     <option>FIJO</option><option>CONTRATADO</option> <option>SUPLENTE</option> </select></span></td>
               </tr>
<script language="JavaScript" type="text/JavaScript"> asig_cont_fijo('<?echo $cont_fijo;?>');</script>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="170"><span class="Estilo5">FECHA PROGRAMADO EGRESO :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtfecha_egreso" type="text" id="txtfecha_egreso" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_egreso?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="124"><span class="Estilo5">MOTIVO DEL EGRESO :</span></td>
                 <td width="350"><span class="Estilo5"> <input class="Estilo10" name="txtmotivo_egreso" type="text" id="txtmotivo_egreso" size="55" maxlength="55" value="<?echo $motivo_egreso?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">
function asig_jerarquia(mvalor){var f=document.form1; if(mvalor=="ADMINISTRATIVO"){document.form1.txtjerarquia.options[0].selected = true;}
   if(mvalor=="PROFESIONALES Y TECNICOS"){document.form1.txtjerarquia.options[1].selected = true;} if(mvalor=="ALTO NIVEL"){document.form1.txtjerarquia.options[2].selected = true;}
   if(mvalor=="OPERATIVO"){document.form1.txtjerarquia.options[3].selected = true;} if(mvalor=="OBREROS"){document.form1.txtjerarquia.options[4].selected = true;} if(mvalor=="OTROS"){document.form1.txtjerarquia.options[5].selected = true;}
}</script>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="174"><span class="Estilo5">FECHA FIN DEL CONTRATO :</span></td>
                 <td width="220"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_fin_con" type="text" id="txtfecha_fin_con" size="12" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_fin_con?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="190"><span class="Estilo5">JERARQUIA DEL TRABAJADOR :</span></td>
                 <td width="280"><span class="Estilo5"><select class="Estilo10" name="txtjerarquia" size="1" id="txtjerarquia" onFocus="encender(this)" onBlur="apagar(this)">
                    <option>ADMINISTRATIVO</option> <option>PROFESIONALES Y TECNICOS</option> <option>ALTO NIVEL</option> <option>OPERATIVO</option> <option>OBREROS</option> <option>OTROS</option> </select></span></td>
                </tr>
<script language="JavaScript" type="text/JavaScript"> asig_jerarquia('<?echo $jerarquia;?>');</script>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript"> function asig_pago_vac(mvalor){var f=document.form1;  if(mvalor=="SI"){document.form1.txttipo_vacaciones.options[0].selected = true;}else{document.form1.txttipo_vacaciones.options[1].selected = true;}} </script>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="204"><span class="Estilo5">PAGO VACACIONES POR N&Oacute;MINA :</span></td>
                 <td width="100"><span class="Estilo5"><select class="Estilo10" name="txttipo_vacaciones" size="1" id="txttipo_vacaciones" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select>  </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_pago_vac('<?echo $tipo_vacaciones;?>');</script>
                 <td width="190"><span class="Estilo5">FECHA RETORNO VACACIONES  :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtfecha_pago" type="text" id="txtfecha_pago" size="12" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_pago?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="120"><span class="Estilo5">RIF TRABAJADOR :</span></td>
                 <td width="140"><span class="Estilo5"><input class="Estilo10" name="txtrif_empleado" type="text" id="txtrif_empleado" size="12" maxlength="12" onFocus="encender(this)" onBlur="apagar(this)"  value="<?echo $rif_empleado?>"></span></td>

                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="170"><span class="Estilo5">CODIGO DE UBICACION :</span></td>
                 <td width="120"><span class="Estilo5"><input class="Estilo10" name="txtcodigo_ubicacion" type="text" id="txtcodigo_ubicacion" size="15" maxlength="15" value="<?echo $codigo_ubicacion?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="40"><input class="Estilo10" name="btcod_ubica" type="button" id="btcod_ubica" title="Abrir Catalogo de Ubicaciones" onclick="VentanaCentrada('Cat_ubicacion.php?criterio=','SIA','','750','500','true')" value="..."></td>
                 <td width="534"><span class="Estilo5"><input class="Estilo10" name="txtdescripcion_ubi" type="text" id="txtdescripcion_ubi" size="80" maxlength="100"  value="<?echo $descripcion_ubi?>" readonly> </span></td>
                 </tr>
             </table></td>
           </tr>		   
<script language="JavaScript" type="text/JavaScript">
function asig_grado_inst(mvalor){var f=document.form1;
    if(mvalor=="PRIMARIA"){document.form1.txgrado_inst.options[0].selected = true;}
        if(mvalor=="BASICO"){document.form1.txgrado_inst.options[1].selected = true;}
        if(mvalor=="BACHILLER"){document.form1.txgrado_inst.options[2].selected = true;}
        if(mvalor=="TECNICO MEDIO"){document.form1.txgrado_inst.options[3].selected = true;}
        if(mvalor=="TECNICO SUPERIOR"){document.form1.txgrado_inst.options[4].selected = true;}
        if(mvalor=="UNIVERSITARIO"){document.form1.txgrado_inst.options[5].selected = true;}
        if(mvalor=="POSTGRADO"){document.form1.txgrado_inst.options[6].selected = true;}
		if(mvalor=="MAESTRIA"){document.form1.txgrado_inst.options[7].selected = true;}
        if(mvalor=="DOCTORADO"){document.form1.txgrado_inst.options[8].selected = true;}
        if(mvalor=="NINGUNO"){document.form1.txgrado_inst.options[9].selected = true;}
}</script>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="160"><span class="Estilo5">GRADO DE INSTRUCCI&Oacute;N : </span></td>
                 <td width="206"><span class="Estilo5"><select class="Estilo10" name="txgrado_inst" size="1" id="txgrado_inst" onFocus="encender(this)" onBlur="apagar(this)">
                      <option>PRIMARIA</option> <option>BASICO</option> <option>BACHILLER</option> <option>TECNICO MEDIO</option> <option>TECNICO SUPERIOR</option>
                      <option>UNIVERSITARIO</option>  <option>POSTGRADO</option> <option>MAESTRIA</option> <option>DOCTORADO</option>  <option>NINGUNO</option>
                    </select>
                 </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_grado_inst('<?echo $grado_inst;?>');</script>
                 <td width="82"><span class="Estilo5">PROFESI&Oacute;N : </span></td>
                 <td width="396"><span class="Estilo5"> <input class="Estilo10" name="txtprofesion" type="text" id="txtprofesion" size="60" maxlength="55" value="<?echo $profesion?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript">
function asig_edo_civil(mvalor){var f=document.form1;
    if(mvalor=="SOLTERO"){document.form1.txtedo_civil.options[0].selected = true;}
	if(mvalor=="SOLTERA"){document.form1.txtedo_civil.options[1].selected = true;}
        if(mvalor=="CASADO"){document.form1.txtedo_civil.options[2].selected = true;}
		if(mvalor=="CASADA"){document.form1.txtedo_civil.options[3].selected = true;}
        if(mvalor=="VIUDO"){document.form1.txtedo_civil.options[4].selected = true;}
		if(mvalor=="VIUDA"){document.form1.txtedo_civil.options[5].selected = true;}
        if(mvalor=="DIVORCIADO"){document.form1.txtedo_civil.options[6].selected = true;}
		if(mvalor=="DIVORCIADA"){document.form1.txtedo_civil.options[7].selected = true;}
        if(mvalor=="CONCUBINO"){document.form1.txtedo_civil.options[8].selected = true;}
		if(mvalor=="CONCUBINA"){document.form1.txtedo_civil.options[9].selected = true;}
        if(mvalor=="OTROS"){document.form1.txtedo_civil.options[10].selected = true;}
}
function asig_sexo(mvalor){var f=document.form1; if(mvalor=="MASCULINO"){document.form1.txtsexo.options[0].selected = true;}else{document.form1.txtsexo.options[1].selected = true;}}
</script>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="100"><span class="Estilo5">ESTADO CIVIL  : </span></td>
                 <td width="139"><span class="Estilo5"> <select class="Estilo10" name="txtedo_civil" size="1" id="txtedo_civil" onFocus="encender(this)" onBlur="apagar(this)">
                    <option>SOLTERO</option> <option>SOLTERA</option>  <option>CASADO</option> <option>CASADA</option> <option>VIUDO</option> <option>VIUDA</option>  <option>DIVORCIADO</option>  <option>DIVORCIADA</option> <option>CONCUBINO</option> <option>CONCUBINA</option>  <option>OTROS</option> </select> </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_edo_civil('<?echo $edo_civil;?>');</script>
                 <td width="55"><span class="Estilo5">SEXO : </span></td>
                 <td width="150"><span class="Estilo5"> <select class="Estilo10" name="txtsexo" size="1" id="txtsexo" onFocus="encender(this)" onBlur="apagar(this)"> <option>MASCULINO</option><option>FEMENINO</option> </select> </span></td>
<script language="JavaScript" type="text/JavaScript"> asig_sexo('<?echo $sexo;?>');</script>
                 <td width="150"><span class="Estilo5">FECHA DE NACIMIENTO :</span></td>
                 <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_nacimiento" type="text" id="txtfecha_nacimiento" size="10" maxlength="10"  onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_nacimiento?>" onchange="chequea_fecha_nac(this.form)" onkeyup="mascara(this,'/',patronfecha,true)"> </span></td>
                 <td width="50"><span class="Estilo5">EDAD : </span></td>
                 <td width="80"><span class="Estilo5"><input class="Estilo10" name="txtedad" type="text" id="txtedad" size="4" maxlength="4" value="<?echo $edad?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="154"><span class="Estilo5">LUGAR DE NACIMIENTO : </span></td>
                 <td width="695"><span class="Estilo5"><input class="Estilo10" name="txtlugar_nacimiento" type="text" id="txtlugar_nacimiento" size="85" maxlength="85"  value="<?echo $lugar_nacimiento?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="860">
               <tr>
                 <td width="85"><span class="Estilo5">DIRECCI&Oacute;N :</span></td>
                 <td width="745"><textarea name="txtdireccion" cols="84" class="Estilo10" onFocus="encender(this)" onBlur="apagar(this)" id="txtdireccion"><?echo $direccion?></textarea></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
<script language="JavaScript" type="text/JavaScript">
function chequea_estado(mform){ var cod_edo;  var cod_mun; cod_edo=mform.txtestado.value;  cod_mun=cod_edo+'01';
ajaxSenddoc('GET', 'cargamunicipio.php?municipio=<? echo $municipio;?>&cod_estado='+cod_edo, 'municipio', 'innerHTML');
ajaxSenddoc('GET', 'cargaciudad.php?ciudad=<? echo $ciudad;?>&cod_estado='+cod_edo, 'ciudad', 'innerHTML');
ajaxSenddoc('GET', 'cargaparroquia.php?parroquia=<? echo $parroquia;?>&cod_muni='+cod_mun, 'parro', 'innerHTML');
return true;}
function apaga_municipio(mthis){
var mcod_mun;  apagar(mthis); mcod_mun=mthis.value;}
function chequea_municipio(mform){ var mcod_mun; mcod_mun=mform.txtmunicipio.value; 
ajaxSenddoc('GET', 'cargaparroquia.php?parroquia=<? echo $parroquia;?>&cod_muni='+mcod_mun, 'parro', 'innerHTML');
return true;}
</script>
               <tr>
                 <td width="73"><span class="Estilo5">ESTADO :</span></td>
                 <td width="323"><span class="Estilo5"> <div id="estado"><select class="Estilo10" name="txtestado" id="txtestado" onFocus="encender(this)" onBlur="apagar(this);" onchange="chequea_estado(this.form)">
                    <option value="<? echo $cod_estado;?>"><? echo $estado;?></option></div></span></td>
<script language="JavaScript" type="text/JavaScript"> ajaxSenddoc('GET', 'cargaentidades.php?mestado=<? echo $estado;?>', 'estado', 'innerHTML'); </script>
                 <td width="92"><span class="Estilo5">MUNICIPIO  : </span></td>
                 <td width="355"><span class="Estilo5"><div id="municipio"><select class="Estilo10" name="txtmunicipio" id="txtmunicipio" onFocus="encender(this)" onBlur="apagar(this);" onchange="chequea_municipio(this.form)" >
                     <option value="<? echo $cod_muni;?>"><? echo $municipio;?></option> </div></span></td>
<script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtestado.value; ajaxSenddoc('GET', 'cargamunicipio.php?municipio=<? echo $municipio;?>&cod_estado='+cod_e, 'municipio', 'innerHTML'); </script>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="73"><span class="Estilo5">CIUDAD  : </span></td>
                 <td width="333"><span class="Estilo5"> <div id="ciudad"><select class="Estilo10" name="txtciudad" id="txtciudad" onFocus="encender(this)" onBlur="apagar(this);">
                    <option><? echo $ciudad;?></option> </div></span></td>
<script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtestado.value; ajaxSenddoc('GET','cargaciudad.php?ciudad=<? echo $ciudad;?>&cod_estado='+cod_e, 'ciudad', 'innerHTML');  </script>
                 <td width="92"><span class="Estilo5">PARROQUIA  : </span></td>
                 <td width="355"><span class="Estilo5"><div id="parro"><select class="Estilo10" name="txtparroquia" id="txtparroquia" onFocus="encender(this)" onBlur="apagar(this);">
                    <option><? echo $parroquia;?></option> </div></span></td>
<script language="JavaScript" type="text/JavaScript">var cod_e='01'; cod_e=document.form1.txtmunicipio.value; ajaxSenddoc('GET', 'cargaparroquia.php?parroquia=<? echo $parroquia;?>&cod_muni='+cod_e, 'parro', 'innerHTML'); </script>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="149"><span class="Estilo5">TELEFONO HABITACI&Oacute;N : </span></td>
                 <td width="163"><span class="Estilo5"> <input class="Estilo10" name="txttelefono" type="text" id="txttelefono" size="20" maxlength="20" value="<?echo $telefono?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="165"><span class="Estilo5">TELEFONO MOVIL/CELULAR : </span></td>
                 <td width="172"><span class="Estilo5"> <input class="Estilo10" name="txttlf_movil" type="text" id="txttlf_movil" size="20" maxlength="20" value="<?echo $tlf_movil?>" onFocus="encender(this)" onBlur="apagar(this)"></td>
                 <td width="109"><span class="Estilo5">C&Oacute;DIGO POSTAL : </span></td>
                 <td width="78"><span class="Estilo5"><input class="Estilo10" name="txtcod_postal" type="text" id="txtcod_postal" size="5" maxlength="5" value="<?echo $cod_postal?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="149"><span class="Estilo5">CORREO ELECTRONICO  :</span></td>
                 <td width="308"><span class="Estilo5"> <input class="Estilo10" name="txtcorreo" type="text" id="txtcorreo" size="40" maxlength="40" value="<?echo $correo?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="142"><span class="Estilo5">APARTADO POSTAL  : </span></td>
                 <td width="241"><span class="Estilo5"> <input class="Estilo10" name="txtaptdo_postal" type="text" id="txtaptdo_postal" size="20" maxlength="20" value="<?echo $aptdo_postal?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
               </tr>
             </table></td>
           </tr>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="144"><span class="Estilo5">NRO. POLIZA SEGURO : </span></td>
                 <td width="150"><span class="Estilo5"> <input class="Estilo10" name="txtpoliza" type="text" id="txttalla_camisa" size="15" maxlength="15" value="<?echo $poliza?>"  onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                 <td width="100"><span class="Estilo5">TALLA CAMISA  : </span></td>
                 <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txttalla_camisa" type="text" id="txttalla_camisa" size="3" maxlength="3" value="<?echo $talla_camisa?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
                 <td width="110"><span class="Estilo5">TALLA PANTALON  : </span></td>
                 <td width="90"><span class="Estilo5"> <input class="Estilo10" name="txttalla_pantalon" type="text" id="txttalla_pantalon" size="3" maxlength="3" value="<?echo $talla_pantalon?>" onFocus="encender(this)" onBlur="apagar(this)"></span></td>
                 <td width="110"><span class="Estilo5">TALLA CALZADO  : </span></td>
                 <td width="70"><span class="Estilo5"><input class="Estilo10" name="txttalla_calzado" type="text" id="txttalla_calzado" size="3" maxlength="3" value="<?echo $talla_calzado?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
               </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript"> function asig_tiene_aus(mvalor){var f=document.form1; if(mvalor=="NO"){document.form1.txttiene_aus_pro.options[0].selected = true;}else{document.form1.txttiene_aus_pro.options[1].selected = true;}} </script>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="200"><span class="Estilo5">TIENE AUSENCIA PROGRAMADA :</span></td>
                 <td width="84"><span class="Estilo5"><select class="Estilo10" name="txttiene_aus_pro" size="1" id="txttiene_aus_pro" onFocus="encender(this)" onBlur="apagar(this)"><option>NO</option> <option>SI</option></select>  </span></td>
                 <td width="250"><span class="Estilo5">FECHA PROGRAMADA AUSENCIA DESDE : </span></td>
                 <td width="140"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_aus_desde" type="text" id="txtfecha_aus_desde" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_aus_desde?>"  onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                 <td width="70"><span class="Estilo5">HASTA : </span></td>
                 <td width="120"><span class="Estilo5"> <input class="Estilo10" name="txtfecha_aus_hasta" type="text" id="txtfecha_aus_hasta" size="10" maxlength="10" onFocus="encender(this)" onBlur="apagar(this)" value="<?echo $fecha_aus_hasta?>" onchange="chequea_fecha(this);" onkeyup="mascara(this,'/',patronfecha,true)"></span></td>
                </tr>
             </table></td>
           </tr>
<script language="JavaScript" type="text/JavaScript"> asig_tiene_aus('<?echo $tiene_aus_pro;?>');</script>
           <tr>
             <td><table width="864">
               <tr>
                 <td width="164" ><span class="Estilo5">MOTIVO DE LA AUSENCIA  :</span></td>
                 <td width="700" ><span class="Estilo5"><input class="Estilo10" name="txtmotivo_ausencia" type="text" id="txtmotivo_ausencia" size="100" maxlength="100"  value="<?echo $motivo_ausencia?>" onFocus="encender(this)" onBlur="apagar(this)"> </span></td>
               </tr>
             </table></td>
           </tr>
        </table>
          <table width="864" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>
              <div id="Layer3" style="position:absolute; width:860px; height:290px; z-index:2; left: 1px; top: 940px;">
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
              </script>
                <?include ("../class/class_tab.php");?>
                <script type="text/javascript" language="javascript"> DrawTabs(); </script>
                 <!--PESTAÑA 1 -->
                <div id="T11" class="tab-body" >
                  <iframe src="Det_inc_asig_cargo.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 2 -->
                <div id="T12" class="tab-body">
                  <iframe src="Det_inc_hoja_vida.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!--PESTAÑA 3 -->
                <div id="T13" class="tab-body" >
                  <iframe src="Det_inc_inf_familiar_e.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 4 -->
                <div id="T14" class="tab-body">
                  <iframe src="Det_inc_exp_laboral_e.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
                <!-- PESTAÑA 5 -->
                <div id="T15" class="tab-body">
                  <iframe src="Det_inc_inf_curricular_e.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>
                </div>
              </div>
              </td>
            </tr>
          </table>
                  <div id="Layer3" style="position:absolute; width:859px; height:37px; z-index:2; left: 0px; top: 1290px;">
          <table width="859">
                <tr>
                  <td width="50"><input class="Estilo10" name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
                  <td width="50"><input class="Estilo10" name="txtp_apellido" type="hidden" id="txtp_apellido" value="<?echo $p_apellido?>"></td>
                  <td width="564">&nbsp;</td>
                  <td width="88"><input name="Grabar" type="submit" id="Grabar"  value="Grabar"></td>
                  <td width="88"><input name="Blanquear" type="reset" value="Blanquear"></td>
                </tr>
          </table>
                  </div>
      </form> </div>
    </td>
</tr>
</table>
</body>
</html>