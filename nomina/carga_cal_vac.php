<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$equipo=getenv("COMPUTERNAME"); $mcod_m="VAC".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$cod_empleado=$_POST["txtcod_empleado"];  $fecha_hoy=asigna_fecha_hoy();
?>
<html>
<head>  <title>CARGAR CALCULO DE VACACIONES</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Calculo(mop){ document.form2.submit(); }
</script>
</head>
<body>
<?$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$error=1; $fecha_caus_d=""; $fecha_caus_h=""; $dias_vac=0; $dias_bono_vac=0; $dias_nohabiles=0; $dias_bono_vac_a=0;
$con_cal_vac=""; $con_bon_vac=""; $con_sue_int=""; $nom_conc=""; $frec="";  $ultima_fecha=""; $monto_bono_vac=0;
$nombre=""; $nacionalidad=""; $descripcion=""; $cod_jerarquia=""; $codigo_ubicacion=""; $descripcion_ubi=""; 
$cedula=""; $rif_empleado=""; $fecha_ing=""; $fecha_ing_a=""; $ultima_fecha="2010-01-01"; $frec="Q";
$tipo_nomina=""; $nacionalidad=""; $status=""; $fecha_ingreso=""; $fecha_ing_adm=""; $cod_categoria=""; $tipo_pago=""; $cta_empleado=""; 
$tipo_cuenta=""; $cod_banco=""; $nombre_banco=""; $cta_empresa=""; $calculo_grupos=""; $fecha_asigna_cargo=""; $cod_cargo=""; $cod_departam=""; 
$cod_tipo_personal=""; $paso=""; $grado=""; $sueldo=""; $prima=""; $compensacion=""; $otros=""; $sueldo_integral=""; $tipo_vacaciones="N"; $pago_vaciones="N"; 
$fecha_pago=""; $tiene_lph=""; $banco_lph=""; $cta_lph=""; $fecha_lph=""; $fecha_des_lph=""; $modif_lph=""; $tiene_dec_jurada=""; $fecha_declaracion=""; 
$monto_declaracion=""; $fecha_fin_con=""; $fecha_egreso=""; $motivo_egreso=""; $cont_fijo=""; $cod_cont_colec=""; $tipo_nom_ant=""; $cod_emp_ant=""; $fecha_camb_n=""; 
$motivo_camb_n=""; $tiene_aus_pro=""; $motivo_ausencia=""; $fecha_aus_desde=""; $fecha_aus_hasta="";  $motivo_suplen=""; $cedula_titular="";
$nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $sexo=""; $edo_civil=""; $fecha_nacimiento=""; $edad=""; $lugar_nacimiento=""; $direccion=""; $cod_postal=""; $telefono=""; 
$tlf_movil=""; $correo=""; $profesion=""; $grado_inst=""; $tiempo_e=""; $poliza=""; $fecha_seguro=""; $estado=""; $ciudad=""; $municipio=""; $parroquia=""; $observacion=""; 
$talla_camisa=""; $talla_pantalon=""; $talla_calzado=""; $peso=""; $estatura=""; $aptdo_postal="";
$sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){ $registro=pg_fetch_array($res); $error=0; 
  $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; 
  $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"];   $status=$registro["status"];  
  $fecha_ing=$registro["fecha_ingreso"]; $fecha_ing_a=$registro["fecha_ing_adm"]; 
  $fecha_ingreso=formato_ddmmaaaa($fecha_ing);  $fecha_ing_adm=formato_ddmmaaaa($fecha_ing_a);  
  $tipo_nomina=$registro["tipo_nomina"]; $sueldo=$registro["sueldo"];
  $descripcion=$registro["descripcion"]; $cod_categoria=$registro["cod_categoria"]; 
  $tipo_pago=$registro["tipo_pago"]; $cta_empleado=$registro["cta_empleado"]; $tipo_cuenta=$registro["tipo_cuenta"];
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $cta_empresa=$registro["cta_empresa"]; 
  $calculo_grupos=$registro["calculo_grupos"]; $cod_jerarquia=$registro["cod_jerarquia"];
  $tiene_dec_jurada=$registro["tiene_dec_jurada"]; $fecha_declaracion=$registro["fecha_declaracion"]; $monto_declaracion=$registro["monto_declaracion"];  
  $fecha_declaracion=formato_ddmmaaaa($fecha_declaracion);
  $tiene_lph=$registro["tiene_lph"]; $banco_lph=$registro["banco_lph"]; $cta_lph=$registro["cta_lph"]; $fecha_lph=$registro["fecha_lph"]; $fecha_des_lph=$registro["fecha_des_lph"]; $modif_lph=$registro["modif_lph"]; 
  $fecha_lph=formato_ddmmaaaa($fecha_lph); $fecha_des_lph=formato_ddmmaaaa($fecha_des_lph);
  $fecha_fin_con=$registro["fecha_fin_con"]; $fecha_egreso=$registro["fecha_egreso"]; $motivo_egreso=$registro["motivo_egreso"]; $cont_fijo=$registro["cont_fijo"];  
  $fecha_fin_con=formato_ddmmaaaa($fecha_fin_con);  $fecha_egreso=formato_ddmmaaaa($fecha_egreso);
  $tipo_vacaciones=$registro["tipo_vacaciones"]; $pago_vaciones=$registro["pago_vaciones"]; $fecha_pago=$registro["fecha_pago"]; $cod_jerarquia=$registro["cod_jerarquia"]; $fecha_pago=formato_ddmmaaaa($fecha_pago);
  $codigo_ubicacion=$registro["codigo_ubicacion"]; $descripcion_ubi=$registro["descripcion_ubi"]; $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $rif_empleado=$registro["rif_empleado"];
  $apellido1=$registro["apellido1"];$apellido2=$registro["apellido2"]; $direccion=$registro["direccion"];$grado_inst=$registro["grado_inst"]; $profesion=$registro["profesion"];
  $sexo=$registro["sexo"]; $edo_civil=$registro["edo_civil"]; $fecha_nacimiento=$registro["fecha_nacimiento"]; $edad=$registro["edad"];  $fecha_nacimiento=formato_ddmmaaaa($fecha_nacimiento);
  $lugar_nacimiento=$registro["lugar_nacimiento"]; $cod_postal=$registro["cod_postal"]; $telefono=$registro["telefono"];  $tlf_movil=$registro["tlf_movil"];  $correo=$registro["correo"];
  $estado=$registro["estado"]; $ciudad=$registro["ciudad"]; $municipio=$registro["municipio"]; $parroquia=$registro["parroquia"]; $aptdo_postal=$registro["aptdo_postal"];
  $observacion=$registro["observacion"]; $talla_camisa=$registro["talla_camisa"]; $talla_pantalon=$registro["talla_pantalon"]; $talla_calzado=$registro["talla_calzado"];
  $poliza=$registro["poliza"]; $fecha_seguro=$registro["fecha_seguro"]; $fecha_seguro=formato_ddmmaaaa($fecha_seguro);}
else{$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><?} 
if($error==0){ 
$sql="Select * from NOM001 where tipo_nomina='$tipo_nomina'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO EXISTE');</script><?} 
else{ $registro=pg_fetch_array($res); $con_cal_vac=$registro["con_cal_vac"];  $con_sue_bas=$registro["con_sue_bas"]; $con_bon_vac=$registro["con_bon_vac"]; $con_sue_int=$registro["con_sue_int"]; $frec=$registro["frecuencia"];  $ultima_fecha=$registro["ultima_fecha"]; }
$sql="Select * FROM CALCULO_VACACIONES where (cod_empleado='$cod_empleado')"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CALCULO DE VACACIONES YA EXISTE');</script><?} }
if($error==0){ $sql="Select * FROM NOM024 where (cod_empleado='$cod_empleado')"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('TRABAJADOR TIENE SALIDA DE VACACIONES REGISTRADA');</script><?}
}
if($error==0){ $fecha_caus_d=$fecha_ing;  $fecha1=formato_ddmmaaaa($fecha_caus_d); $fecha_caus_h=nextano($fecha1,1);
$sql= "SELECT fecha_causa_hasta From NOM025 where (cod_empleado='$cod_empleado') Order by fecha_causa_hasta desc"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){ $registro=pg_fetch_array($res); $fecha_caus_d=$registro["fecha_causa_hasta"];  $fecha1=formato_ddmmaaaa($fecha_caus_d); $fecha_caus_h=nextano($fecha1,1); }
$fecha1=formato_ddmmaaaa($fecha_ing); $fecha2=$fecha_caus_h; $f=diferencia_meses($fecha1,$fecha2);
$fecha_caus_d=formato_ddmmaaaa($fecha_caus_d);
$sql="SELECT * from NOM020 where tipo_nomina='$tipo_nomina' order by consecutivo"; $res=pg_query($sql);
while(($registro=pg_fetch_array($res))and($dias_vac==0)) { $desde=$registro["desde"]; $hasta=$registro["hasta"];
  if(($f >=$desde)and($f<=$hasta)) { $dias_vac=$registro["vacaciones"]+$registro["vac_adicional"];  $dias_bono_vac=$registro["bono_vacacional"]; $dias_nohabiles=6; $dias_bono_vac_a=$registro["auxiliar1"]; echo $f." ".$desde." ".$hasta." ".$registro["consecutivo"],"<br>";}
}  
}
$fecha_desde=formato_ddmmaaaa($ultima_fecha); $fecha_desde=nextDate($fecha_desde,1);  $nro_semanas=0; $num_semana=0;
if($Cod_Emp=="58"){ $fecha_hasta=colocar_udiames($fecha_desde);}
else{
if($frec=="M"){$fecha_hasta=colocar_udiames($fecha_desde);} 
if($frec=="S"){$fecha_hasta=nextDate($fecha_desde,6);$nro_semanas=$num_semana+1;} 
if($frec=="Q"){$dia=substr($fecha_desde,0,2); $fecha_hasta=colocar_udiames($fecha_desde); if($dia=='01'){$fecha_hasta=nextDate($fecha_desde,14);}}
$fecha_desde=nextDate($fecha_hasta,1);
if($frec=="M"){$fecha_hasta=colocar_udiames($fecha_desde);} 
if($frec=="S"){$fecha_hasta=nextDate($fecha_desde,6);$nro_semanas=$num_semana+1;} 
if($frec=="Q"){$dia=substr($fecha_desde,0,2); $fecha_hasta=colocar_udiames($fecha_desde); if($dia=='01'){$fecha_hasta=nextDate($fecha_desde,14);}}
}
$fecha_c_desde=$fecha_desde; $fecha_c_hasta=$fecha_hasta;
$temp_fecha=formato_ddmmaaaa($ultima_fecha); $mdia=substr($temp_fecha,0,2);
//$temp_fecha=colocar_pdiames($temp_fecha); 
if($mdia=="15"){$temp_fecha=operacion_mes($temp_fecha,-1); }
$temp_fecha=colocar_udiames($temp_fecha);
$sfecha=formato_aaaammdd($temp_fecha);
echo $ultima_fecha." ".$temp_fecha." ".$sfecha,"<br>";
$sql="Select * from conceptos where tipo_nomina='$tipo_nomina' and cod_concepto='$con_cal_vac'"; $res=pg_query($sql);$filas=pg_num_rows($res);
if ($registro=pg_fetch_array($res,0)){  $nom_conc=$registro["denominacion"]; }  
//$fecha_desde=$fecha_hoy; 
$num_dias=$dias_vac+$dias_nohabiles-1; $fecha_hasta=nextDate($fecha_desde,$num_dias); $num_dias=$num_dias+1;
$fecha_rein=nextDate($fecha_desde,$num_dias);$fecha_hist=$temp_fecha; $monto_base=0;

if(($frec=="S")and($con_sue_bas==$con_cal_vac)){ $monto_base=0; }
else{$sql="Select * from nom018 where tipo_nomina='$tipo_nomina' and cod_concepto='$con_cal_vac' and cod_empleado='$cod_empleado' and fecha_nomina='$sfecha'"; $res=pg_query($sql);$filas=pg_num_rows($res);
echo $sql,"<br>"; if ($registro=pg_fetch_array($res,0)){  $monto_base=$registro["monto"]; } }
if($monto_base==0){$monto_base=$sueldo;}
$monto_bono_vac=($monto_base/30) * $dias_bono_vac;
$monto_base=formato_monto($monto_base); $monto_bono_vac=formato_monto($monto_bono_vac); $dias_bono_vac=formato_monto($dias_bono_vac);
$sSQL="SELECT ELIMINA_NOM076('$codigo_mov')"; $resultado=pg_exec($conn,$sSQL);
?>
<form name="form2" method="post" action="Inc_cal_vacaciones.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>	 
     <td width="5"><input name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?echo $cod_empleado?>" ></td>
     <td width="5"><input name="txtcedula" type="hidden" id="txtcedula" value="<?echo $cedula?>" ></td>
     <td width="5"><input name="txtnombre" type="hidden" id="txtnombre" value="<?echo $nombre?>" ></td>
     <td width="5"><input name="txtfecha_ing" type="hidden" id="txtfecha_ing" value="<?echo $fecha_ingreso?>" ></td>	 
     <td width="5"><input name="txtcon_sue_int" type="hidden" id="txtcon_sue_int" value="<?echo $con_sue_int?>" ></td>
     <td width="5"><input name="txtnom_conc" type="hidden" id="txtnom_conc" value="<?echo $nom_conc?>" ></td>	 
     <td width="5"><input name="txtcon_cal_vac" type="hidden" id="txtcon_cal_vac" value="<?echo $con_cal_vac?>" ></td>     
     <td width="5"><input name="txtcon_bon_vac" type="hidden" id="txtcon_bon_vac" value="<?echo $con_bon_vac?>" ></td>
     <td width="5"><input name="txtfrec" type="hidden" id="txtfrec" value="<?echo $frec?>"></td>
     <td width="5"><input name="txtultima_fecha" type="hidden" id="txtultima_fecha" value="<?echo $ultima_fecha?>"></td>
     <td width="5"><input name="txtfecha_caus_d" type="hidden" id="txtfecha_caus_d" value="<?echo $fecha_caus_d?>"></td>
     <td width="5"><input name="txtfecha_caus_h" type="hidden" id="txtfecha_caus_h" value="<?echo $fecha_caus_h?>"></td>	 
     <td width="5"><input name="txtdias_vac" type="hidden" id="txtdias_vac" value="<?echo $dias_vac?>"></td>	 
     <td width="5"><input name="txtdias_bono_vac" type="hidden" id="txtdias_bono_vac" value="<?echo $dias_bono_vac?>"></td>	 
	 <td width="5"><input name="txtmonto_bono_vac" type="hidden" id="txtmonto_bono_vac" value="<?echo $monto_bono_vac?>"></td>	 
     <td width="5"><input name="txtdias_nohabiles" type="hidden" id="txtdias_nohabiles" value="<?echo $dias_nohabiles?>"></td>     
	 <td width="5"><input name="txtdias_bono_vac_a" type="hidden" id="txtdias_bono_vac_a" value="<?echo $dias_bono_vac_a?>"></td>     
	 <td width="5"><input name="txtfecha_desde" type="hidden" id="txtfecha_desde" value="<?echo $fecha_desde?>"></td>
     <td width="5"><input name="txtfecha_hasta" type="hidden" id="txtfecha_hasta" value="<?echo $fecha_hasta?>"></td>
	 <td width="5"><input name="txtfecha_rein" type="hidden" id="txtfecha_rein" value="<?echo $fecha_rein?>"></td>	 
	 <td width="5"><input name="txtfecha_hist" type="hidden" id="txtfecha_hist" value="<?echo $fecha_hist?>"></td>
     <td width="5"><input name="txtmonto_base" type="hidden" id="txtmonto_base" value="<?echo $monto_base?>"></td>
	 <td width="5"><input name="txtfecha_cal_d" type="hidden" id="txtfecha_cal_d" value="<?echo $fecha_c_desde?>"></td>
     <td width="5"><input name="txtfecha_cal_h" type="hidden" id="txtfecha_cal_h" value="<?echo $fecha_c_hasta?>"></td>
  </tr>
</table>
</form>

<form name="form3" method="post" action="Inc_cal_vacaciones_ima.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>	 
     <td width="5"><input name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?echo $cod_empleado?>" ></td>
     <td width="5"><input name="txtcedula" type="hidden" id="txtcedula" value="<?echo $cedula?>" ></td>
     <td width="5"><input name="txtnombre" type="hidden" id="txtnombre" value="<?echo $nombre?>" ></td>
     <td width="5"><input name="txtfecha_ing" type="hidden" id="txtfecha_ing" value="<?echo $fecha_ingreso?>" ></td>	 
     <td width="5"><input name="txtcon_sue_int" type="hidden" id="txtcon_sue_int" value="<?echo $con_sue_int?>" ></td>
     <td width="5"><input name="txtnom_conc" type="hidden" id="txtnom_conc" value="<?echo $nom_conc?>" ></td>	 
     <td width="5"><input name="txtcon_cal_vac" type="hidden" id="txtcon_cal_vac" value="<?echo $con_cal_vac?>" ></td>     
     <td width="5"><input name="txtcon_bon_vac" type="hidden" id="txtcon_bon_vac" value="<?echo $con_bon_vac?>" ></td>
     <td width="5"><input name="txtfrec" type="hidden" id="txtfrec" value="<?echo $frec?>"></td>
     <td width="5"><input name="txtultima_fecha" type="hidden" id="txtultima_fecha" value="<?echo $ultima_fecha?>"></td>
     <td width="5"><input name="txtfecha_caus_d" type="hidden" id="txtfecha_caus_d" value="<?echo $fecha_caus_d?>"></td>
     <td width="5"><input name="txtfecha_caus_h" type="hidden" id="txtfecha_caus_h" value="<?echo $fecha_caus_h?>"></td>	 
     <td width="5"><input name="txtdias_vac" type="hidden" id="txtdias_vac" value="<?echo $dias_vac?>"></td>	 
     <td width="5"><input name="txtdias_bono_vac" type="hidden" id="txtdias_bono_vac" value="<?echo $dias_bono_vac?>"></td>	 
	 <td width="5"><input name="txtmonto_bono_vac" type="hidden" id="txtmonto_bono_vac" value="<?echo $monto_bono_vac?>"></td>	 
     <td width="5"><input name="txtdias_nohabiles" type="hidden" id="txtdias_nohabiles" value="<?echo $dias_nohabiles?>"></td>     
	 <td width="5"><input name="txtdias_bono_vac_a" type="hidden" id="txtdias_bono_vac_a" value="<?echo $dias_bono_vac_a?>"></td>     
	 <td width="5"><input name="txtfecha_desde" type="hidden" id="txtfecha_desde" value="<?echo $fecha_desde?>"></td>
     <td width="5"><input name="txtfecha_hasta" type="hidden" id="txtfecha_hasta" value="<?echo $fecha_hasta?>"></td>
	 <td width="5"><input name="txtfecha_rein" type="hidden" id="txtfecha_rein" value="<?echo $fecha_rein?>"></td>	 
	 <td width="5"><input name="txtfecha_hist" type="hidden" id="txtfecha_hist" value="<?echo $fecha_hist?>"></td>
     <td width="5"><input name="txtmonto_base" type="hidden" id="txtmonto_base" value="<?echo $monto_base?>"></td>
	 <td width="5"><input name="txtfecha_cal_d" type="hidden" id="txtfecha_cal_d" value="<?echo $fecha_c_desde?>"></td>
     <td width="5"><input name="txtfecha_cal_h" type="hidden" id="txtfecha_cal_h" value="<?echo $fecha_c_hasta?>"></td>
  </tr>
</table>
</form>
</body>
</html>
<?pg_close();
if ($error==0){?><script language="JavaScript">Llamar_Inc_Calculo('S');</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }
?>