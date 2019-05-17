<?include ("../class/conect.php");  include ("../class/funciones.php");$fecha_hoy=asigna_fecha_hoy(); $php_os=PHP_OS; $fechah=formato_aaaammdd($fecha_hoy); $codigo_mov=$_POST["txtcodigo_mov"];
$cod_empleado=$_POST["txtcod_empleado"]; $cedula=$_POST["txtcedula"]; $nacionalidad=$_POST["txtnacionalidad"]; $nombre=$_POST["txtnombre"]; $nombre1=$_POST["txtnombre1"]; $nombre2=$_POST["txtnombre2"]; $apellido1=$_POST["txtapellido1"]; $apellido2=$_POST["txtapellido2"];
$nombre=strtoupper($nombre); $nombre1=strtoupper($nombre1); $nombre2=strtoupper($nombre2); $apellido1=strtoupper($apellido1); $apellido2=strtoupper($apellido2);
$fecha_ingreso=$_POST["txtfecha_ingreso"]; $fecha_ing_adm=$_POST["txtfecha_ing_adm"]; $status=$_POST["txtstatus"]; $tipo_nomina=$_POST["txttipo_nomina"]; $cod_categoria=$_POST["txtcod_cat_alter"]; $calculo_grupos=""; $pago_vaciones="N"; $rif_emp=$_POST["txtrif_empleado"];
$tipo_pago=$_POST["txttipo_pago"]; $cta_empleado=$_POST["txtcta_empleado"]; $tipo_cuenta=$_POST["txttipo_cuenta"]; $cod_banco=$_POST["txtcod_banco"]; $nombre_banco=$_POST["txtnombre_banco"]; $cta_empresa=$_POST["txtnro_cuenta"];
$tiene_dec_jurada=$_POST["txttiene_dec_jurada"]; $fecha_declaracion=$_POST["txtfecha_declaracion"]; $monto_declaracion=$_POST["txtmonto_declaracion"]; if(is_numeric($monto_declaracion)){$monto_declaracion=$monto_declaracion;}else{$monto_declaracion=0;} $tiene_dec_jurada=substr($tiene_dec_jurada,0,1);  if(checkData($fecha_declaracion)=='1'){$error=0;} else{$fecha_declaracion=$fecha_hoy;}
$tiene_lph=$_POST["txttiene_lph"]; $banco_lph=$_POST["txtbanco_lph"]; $cta_lph=$_POST["txtcta_lph"]; $fecha_lph=$_POST["txtfecha_lph"]; $fecha_des_lph=$_POST["txtfecha_des_lph"]; $cont_fijo=$_POST["txtcont_fijo"];  $cont_fijo=substr($cont_fijo,0,1);  if(checkData($fecha_lph)=='1'){$error=0;} else{$fecha_lph=$fecha_ingreso;} 
if(checkData($fecha_des_lph)=='1'){$error=0;} else{$fecha_des_lph=$fecha_ingreso;}
$fecha_egreso=$_POST["txtfecha_egreso"]; $motivo_egreso=$_POST["txtmotivo_egreso"]; $fecha_fin_con=$_POST["txtfecha_fin_con"];  $jerarquia=$_POST["txtjerarquia"];  $campo_str1=$_POST["txtcod_fuente"];
$tipo_vacaciones=$_POST["txttipo_vacaciones"]; $fecha_pago=$_POST["txtfecha_pago"]; $codigo_ubicacion=$_POST["txtcodigo_ubicacion"];  $tipo_vacaciones=substr($tipo_vacaciones,0,1);  $tiene_lph=substr($tiene_lph,0,1);  if(checkData($fecha_pago)=='1'){$error=0;} else{$fecha_pago=$fecha_hoy;}
$grado_inst=$_POST["txgrado_inst"]; $profesion=$_POST["txtprofesion"]; $edo_civil=$_POST["txtedo_civil"];  $fecha_nacimiento=$_POST["txtfecha_nacimiento"]; $edad=$_POST["txtedad"]; $sexo=$_POST["txtsexo"]; $edad_num=diferencia_años($fecha_nacimiento,$fecha_hoy);
$lugar_nacimiento=$_POST["txtlugar_nacimiento"]; $direccion=$_POST["txtdireccion"]; $estado=$_POST["txtestado"]; $municipio=$_POST["txtmunicipio"];$ciudad=$_POST["txtciudad"]; $parroquia=$_POST["txtparroquia"]; $telefono=$_POST["txttelefono"]; $tlf_movil=$_POST["txttlf_movil"]; $cod_postal=$_POST["txtcod_postal"];
$correo=$_POST["txtcorreo"]; $aptdo_postal=$_POST["txtaptdo_postal"]; $poliza=$_POST["txtpoliza"];  $talla_camisa=$_POST["txttalla_camisa"]; $talla_pantalon=$_POST["txttalla_pantalon"]; $talla_calzado=$_POST["txttalla_calzado"];
$tiene_aus_pro=$_POST["txttiene_aus_pro"]; $fecha_aus_desde=$_POST["txtfecha_aus_desde"];  $fecha_aus_hasta=$_POST["txtfecha_aus_hasta"];   $motivo_ausencia=$_POST["txtmotivo_ausencia"]; $tiene_aus_pro=substr($tiene_aus_pro,0,1); 
$p_apellido=$_POST["txtp_apellido"]; if($p_apellido=="S"){ $nombre=$apellido1.' '.$apellido2.' '.$nombre1.' '.$nombre2;  } else{ $nombre=$nombre1.' '.$nombre2.' '.$apellido1.' '.$apellido2;}
if(checkData($fecha_aus_desde)=='1'){$error=0;} else{$fecha_aus_desde=$fecha_hoy;}  if(checkData($fecha_aus_hasta)=='1'){$error=0;} else{$fecha_aus_hasta=$fecha_hoy;}
$cta_empleado=str_replace("-","",$cta_empleado);if(strlen($cta_empleado)>20){$error=1; ?> <script language="JavaScript"> muestra('LONGITUD CUENTA DE TRABAJADOR INVALIDA');</script><?} 
$cta_empresa=str_replace("-","",$cta_empresa);if(strlen($cta_empresa)>20){$error=1; ?> <script language="JavaScript"> muestra('LONGITUD CUENTA DE EMPRESA INVALIDA');</script><?} 
$edad_num=formato_numero($edad_num); if(is_numeric($edad_num)){$edad_num=$edad_num;}else{$edad_num=0;}  $fecha_asigna_cargo=$fecha_ingreso;
$campo_num1=0; $campo_num1=$_POST["txtcampo_num1"]; $campo_num1=formato_numero($campo_num1); if(is_numeric($campo_num1)){$campo_num1=$campo_num1;}else{$campo_num1=0;} 
if($tiene_lph=="N"){$banco_lph=""; $cta_lph="";}  $motivo_suplen="";$cedula_titular=""; $mstatus="NNNNNNNNNN"; $cod_jerarquia="00";
if($jerarquia=="ADMINISTRATIVO"){$cod_jerarquia="01";} if($jerarquia=="PROFESIONALES Y TECNICOS"){$cod_jerarquia="02";} if($jerarquia=="ALTO NIVEL"){$cod_jerarquia="03";}
if($jerarquia=="OBREROS"){$cod_jerarquia="04";} if($jerarquia=="OTROS"){$cod_jerarquia="05";} $cod_conc_s="001"; $cod_conc_c="002"; $g_orden_pago="N";
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
//echo $fecha_des_lph,"<br>";
$url="Act_info_trabajadores.php?Gcod_empleado=C".$cod_empleado;
if($php_os=="WINNT"){$equipo = getenv("COMPUTERNAME");}else{if($_SERVER["HTTP_X_FORWARDED_FOR"]){$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];}else{$ip=$_SERVER["REMOTE_ADDR"];} if($equipo==""){$equipo=$ip;} }
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  if(checkData($fecha_nacimiento)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE NACIMIENTO NO ES VALIDA');</script><? } }
 if($error==0){if(checkData($fecha_ingreso)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE INGRESO NO ES VALIDA');</script><? }}
 if($error==0){if(checkData($fecha_ing_adm)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE INGRESO ADMINISTRACION NO ES VALIDA');</script><? }}
 if($error==0){if(checkData($fecha_egreso)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE EGRESO NO ES VALIDA');</script><? }}
 if($error==0){if(checkData($fecha_fin_con)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA FIN DE CONTRATO NO ES VALIDA');</script><? }}
 if($error==0){if(checkData($fecha_declaracion)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE DECLARACION NO ES VALIDA');</script><? }}
 if($error==0){if(checkData($fecha_lph)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE LPH NO ES VALIDA');</script><? }}
 if($error==0){$sfecha=formato_aaaammdd($fecha_nacimiento); if ($sfecha>$fechah){ $error=1; ?> <script language="JavaScript">muestra('FECHA NACIMIENTO MAYOR A FECHA DE HOY');</script><? }  }
 if($error==0){$sfecha=formato_aaaammdd($fecha_ingreso); if ($sfecha>$fechah){ $error=1; ?> <script language="JavaScript">muestra('FECHA INGRESO MAYOR A FECHA DE HOY');</script><? }  }
 if($error==0){ if ($gnomina=="00"){$error=0;} else {  if($tipo_nomina<>$gnomina) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO ACTIVA PARA EL USUARIO');</script><?}  } } 
 if($error==0){if($nombre==""){$error=1; ?> <script language="JavaScript">muestra('NOMBRE NO ES VALIDO');</script><? }}
 if($error==0){if($cedula==""){$error=1; ?> <script language="JavaScript">muestra('CEDULA NO ES VALIDA');</script><? }}
 if($error==0){$formato_trab="XXXXXXXXXX";$sql="Select * from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$formato_trab=$registro["campo504"];$formato_cargo=$registro["campo505"];$formato_dep=$registro["campo506"];}}
 if($error==0){$cod_cargo=""; $cod_departam=""; $cod_tipo_personal=""; $paso="000"; $grado="000"; $sueldo=0; $prima=0; $compensacion=0; $otros=0; $sueldo_integral=0; $cant_cargo=0; $sql="SELECT * FROM NOM068 where codigo_mov='$codigo_mov' order by fecha_asigna"; $res=pg_query($sql);
   while($registro=pg_fetch_array($res)){$cant_cargo=$cant_cargo+1;$cod_cargo=$registro["cod_cargo"];$cod_departam=$registro["cod_departamento"];$cod_tipo_personal=$registro["cod_tipo_personal"];$paso=$registro["paso"];$grado=$registro["grado"];$sueldo=$registro["sueldo"];$prima=$registro["prima"];$compensacion=$registro["compensacion"];$fecha_asigna_cargo=$registro["fecha_asigna"];}
   if($cant_cargo==0){$error=1; ?> <script language="JavaScript">muestra('NO EXISTEN CARGOS ASIGNADOS');</script><?}
   if($error==0){$sSQL="Select denominacion from NOM004 WHERE codigo_cargo='$cod_cargo'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CARGO NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado); $des_cargo=$registro["denominacion"];}}
   if($error==0){$sSQL="Select cod_tipo_personal from NOM015 WHERE cod_tipo_personal='$cod_tipo_personal'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO TIPO DE PERSONAL NO EXISTE');</script><?}}
   if($error==0){$sSQL="Select descripcion_dep from NOM005 WHERE codigo_departamento='$cod_departam'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE DEPARTAMENTO NO EXISTE');</script><?}else{$registro=pg_fetch_array($resultado); $des_departamento=$registro["descripcion_dep"];}}
 }
 if($error==0){$sSQL="Select tipo_nomina,descripcion,con_sue_bas,con_compen,g_orden_pago from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado); $g_orden_pago=$registro["g_orden_pago"]; $cod_conc_s=$registro["con_sue_bas"]; $cod_conc_c=$registro["con_compen"];}}
 if(($error==0)and($g_orden_pago=="S")){$sSQL="Select denominacion from pre001 WHERE cod_presup='$cod_categoria'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CATEGORIA NO EXISTE');</script><?} }
 if($error==0){$Ssql="SELECT * FROM pre091 where cod_estado='".$estado."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$estado=$registro["estado"];}
  $Ssql="SELECT * FROM PRE093 where cod_municipio='".$municipio."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$municipio=$registro["nombre_municipio"];}
  $Ssql="SELECT * FROM PRE096 where cod_parroquia='".$parroquia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$parroquia=$registro["nombre_parroquia"];}
 }
 if($error==0){$sSQL="Select nombre,cedula,cod_cargo,cod_departam from NOM006 WHERE cod_empleado='$cod_empleado'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado); $adescrip=$registro["nombre"]; $acedula=$registro["cedula"]; $acargo=$registro["cod_cargo"]; $adep=$registro["cod_departam"]; $sfecha=formato_aaaammdd($fecha_hoy);}
   //echo $sSQL." ".$filas;
   if($error==0){if(strlen($cod_empleado)==strlen($formato_trab)){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD CODIGO DE TRABAJADOR INVALIDA');</script><?} }
   if($error==0){$sfecha=formato_aaaammdd($fecha_hoy); $sfechan=formato_aaaammdd($fecha_nacimiento); $sfechai=formato_aaaammdd($fecha_ingreso); $sfechaia=formato_aaaammdd($fecha_ing_adm);  $sfechaac=$fecha_asigna_cargo; $sfechap=formato_aaaammdd($fecha_pago);   $sfechalph=formato_aaaammdd($fecha_lph);  $sfechadlph=formato_aaaammdd($fecha_des_lph);   $sfechad=formato_aaaammdd($fecha_declaracion);  $sfechae=formato_aaaammdd($fecha_egreso); $sfechafc=formato_aaaammdd($fecha_fin_con);   $sfechaad=formato_aaaammdd($fecha_aus_desde); $sfechaah=formato_aaaammdd($fecha_aus_hasta);
     //echo $sfechadlph,"<br>";
	 $sSQL="SELECT ACTUALIZA_NOM006(2,'$cod_empleado','$cedula','$nombre','$tipo_nomina','$nacionalidad','$status','$sfechai','$sfechaia','$cod_categoria','$tipo_pago','$cta_empleado','$tipo_cuenta','$cod_banco','$nombre_banco','$cta_empresa','$calculo_grupos','$sfechaac','$cod_cargo','$cod_departam','$cod_tipo_personal','$paso','$grado',$sueldo,$prima,$compensacion,$otros,$sueldo_integral,'$tipo_vacaciones','$pago_vaciones','$sfecha','$tiene_lph','$banco_lph','$cta_lph','$sfechalph','$sfechadlph','N','$tiene_dec_jurada','$sfechad',$monto_declaracion,'$sfechafc','$sfechae','$motivo_egreso','$cont_fijo','0000','$tiene_aus_pro','$motivo_ausencia','$sfechaad','$sfechaah','$codigo_ubicacion','$motivo_suplen','$cedula_titular','$campo_str1',$campo_num1,'$mstatus','$usuario_sia','$minf_usuario','$nombre1','$nombre2','$apellido1','$apellido2','$sexo','$edo_civil','$sfechan',$edad_num,'$lugar_nacimiento','$direccion','$cod_postal','$telefono','$tlf_movil','$correo','$profesion','$grado_inst',0,'$poliza','$sfechan','$estado','$ciudad','$municipio','$parroquia','','$talla_camisa','$talla_pantalon','$talla_calzado',0,0,'$aptdo_postal','$cod_jerarquia','$rif_emp','$cod_conc_s','$cod_conc_c','$codigo_mov')";
     $resultado=pg_exec($conn,$sSQL); 
	 
	 echo $sSQL,"<br>";
	 $merror=pg_errormessage($conn); $merror=substr($merror,0,91); if (!$resultado){$error=1;?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?
     $desc_doc="TRABAJADOR, CODIGO:".$cod_empleado.", NOMBRE:".$adescrip.", CARGO:".$acargo.", DEPARTAMENTO:".$adep; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
   }
 }
pg_close(); 
/* */
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}

?>
