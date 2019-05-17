<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$equipo=getenv("COMPUTERNAME"); $mcod_m="VAC".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
if (!$_GET){$cod_empleado='';} else { $cod_empleado=$_GET["Gcodigo"]; } $fecha_hoy=asigna_fecha_hoy();
?>
<html>
<head>  <title>CARGAR CALCULO DE LIQUIDACION</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Calculo(mop){ document.form2.submit(); }
</script>
</head>
<body>
<?$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }else{ $Nom_Emp=busca_conf(); }
$sSQL="SELECT ELIMINA_NOM076('$codigo_mov')"; $resultado=pg_exec($conn,$sSQL);

$sql="Select * FROM CALCULO_LIQUIDACION  where (cod_empleado='$cod_empleado') "; $res=pg_query($sql);$filas=pg_num_rows($res);
$nombre="";$cod_empleado=""; $cedula=""; $fecha_ingreso=""; $fecha_liquidacion=""; 
$ant_ano="";$ant_mes="";$ant_dia="";$cod_sue_int="";$monto_sue_int=0;$sueldo_basico=0;$tiempo_servicio=0;$campo_str1="";$campo_str2="";$campo_num1="";$campo_num2="";$inf_usuario="";
$tipo_liquidacion="";$sueldo_liquidacion=0;$sueldo_vacaciones=0;$dias_preaviso=0;$monto_preaviso=0; $total_adelantos=0; $total_intereses=0; $int_fraccionados=0; $dias_int_fraccionados=0;
$dias_vacaciones_f=0;$monto_vacaciones_f=0;$dias_bono_vac_f=0;$monto_bono_vac_f=0;$total_vacaciones_p=0;$total_bono_vac_p=0; 
$monto_ant_depositada=0;$monto_art142=0; $dias_art142=0;$fecha_ant_depositada="";$status="";$sueldo=0; $dias_dep=0; $dias_vac=0; $dias_bono_vac=0;
if($filas>=1){  $registro=pg_fetch_array($res,0);  
  $cod_empleado=$registro["cod_empleado"];  $fecha_liquidacion=$registro["fecha_liquidacion"]; $fecha_liquidacion=formato_ddmmaaaa($fecha_liquidacion);  
  $ant_ano=$registro["ant_ano"]; $ant_mes=$registro["ant_mes"]; $ant_dia=$registro["ant_dia"]; $cod_sue_int=$registro["cod_sue_int"];
  $monto_sue_int=$registro["monto_sue_int"]; $sueldo_basico=$registro["sueldo_basico"]; $tiempo_servicio=$registro["tiempo_servicio"];
  $tipo_liquidacion=$registro["tipo_liquidacion"];   $sueldo_liquidacion=$registro["sueldo_liquidacion"];  $sueldo_vacaciones=$registro["sueldo_vacaciones"];
  $dias_preaviso=$registro["dias_preaviso"];  $monto_preaviso=$registro["monto_preaviso"];  $total_adelantos=$registro["total_adelantos"]; 
  $total_intereses=$registro["total_intereses"]; $int_fraccionados=$registro["int_fraccionados"]; $dias_int_fraccionados=$registro["dias_int_fraccionados"];  $dias_vacaciones_f=$registro["dias_vacaciones_f"];
  $monto_vacaciones_f=$registro["monto_vacaciones_f"];$dias_bono_vac_f=$registro["dias_bono_vac_f"];$monto_bono_vac_f=$registro["monto_bono_vac_f"];
  $total_vacaciones_p=$registro["total_vacaciones_p"];$total_bono_vac_p=$registro["total_bono_vac_p"];  $dias_dep=$registro["dias_ant_depositada"]; 
  $monto_ant_depositada=$registro["monto_ant_depositada"]; $monto_art142=$registro["monto_art142"];  $dias_art142=$registro["dias_art142"]; $fecha_ant_depositada=$registro["fecha_ant_depositada"]; $fecha_ant_depositada=formato_ddmmaaaa($fecha_ant_depositada);  
  $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"]; $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"]; $inf_usuario=$registro["inf_usuario"];  
  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);   	
}else{$error=1; echo $sql; ?> <script language="JavaScript"> muestra('CALCULO DE LIQUIDACION NO EXISTE');</script><?} 
$monto_banco=$monto_ant_depositada-$total_adelantos;   $monto_banco=$campo_num1;   $monto_banco=formato_monto($monto_banco); 

$monto_cal_vac=$sueldo_vacaciones;  $fecha_cal_garantia=$fecha_ant_depositada; $monto_garantia=$monto_ant_depositada; 
if(($tipo_liquidacion<>"JUSTIFICADO") And ($tipo_liquidacion<>"RENUNCIA") And  ($tipo_liquidacion<>"JUBILACION") ){  if($monto_art142>$monto_garantia){$dias_art92=$dias_art142; $monto_art92=$monto_art142; } else{ $dias_art92=$dias_dep; $monto_art92=$monto_garantia; }  }else{ $dias_art92=0; $monto_art92=0;}
$sueldo=0; $tipo_nomina=""; $nacionalidad="";
$sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){ $registro=pg_fetch_array($res); $error=0; 
  $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; 
  $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"];   $status=$registro["status"];  
  $fecha_ing=$registro["fecha_ingreso"]; $fecha_ing_a=$registro["fecha_ing_adm"]; 
  $fecha_ingreso=formato_ddmmaaaa($fecha_ing);  $fecha_ing_adm=formato_ddmmaaaa($fecha_ing_a);  
  $tipo_nomina=$registro["tipo_nomina"]; $sueldo=$registro["sueldo"];
}else{$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><?} 
//$sueldo_basico=$sueldo;
$con_cal_vac=""; $con_bon_vac=""; $con_sue_int=""; $con_sue_bas=""; $nom_conc=""; $frec="";  $ultima_fecha=""; $monto_bono_vac=0;
$sql="Select * from NOM001 where tipo_nomina='$tipo_nomina'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO EXISTE');</script><?} 
else{ $registro=pg_fetch_array($res); $con_cal_vac=$registro["con_cal_vac"]; $con_bon_vac=$registro["con_bon_vac"]; $con_sue_bas=$registro["con_sue_bas"]; $con_sue_int=$registro["con_sue_int"]; $frec=$registro["frecuencia"];  $ultima_fecha=$registro["ultima_fecha"]; }
$sql="SELECT * FROM NOM036 where (cod_empleado='$cod_empleado') order by asig_ded_apo,tipo_asigna,cod_concepto"; $res=pg_query($sql); $filas=pg_num_rows($res); 
while($registro=pg_fetch_array($res)){  $cod_concepto=$registro["cod_concepto"];
	$denominacion=$registro["den_concepto"]; $fecha_desde=$registro["fecha_desde"]; $fecha_hasta=$registro["fecha_hasta"]; $cod_presup="";  $cod_contable=""; $afecta_presup="";  $cod_retencion=""; $tipo_asigna=$registro["tipo_asigna"];
	$asig_ded_apo=$registro["asig_ded_apo"]; $asignacion=$registro["asignacion"];  $cantidad=$registro["cantidad"]; $sueldo_dia=$registro["monto_base"]; $tmonto=$registro["monto"]; $sueldo_dia=$registro["monto_base"]; if(($cod_concepto=="L01")or($cod_concepto=="L02")){ $tipo_asigna='A';}
    $sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$denominacion','NO','$asignacion','NO','NO','$tipo_asigna','$asig_ded_apo','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$tmonto,$sueldo_dia,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$fecha_desde','$fecha_desde','$fecha_hasta',1,'000')";  
	$resg=pg_exec($conn,$sSQL);$merror=pg_errormessage($conn); 
}
$monto_sue_int=formato_monto($monto_sue_int);  $sueldo_basico=formato_monto($sueldo_basico); $monto_preaviso=formato_monto($monto_preaviso);   $monto_garantia=formato_monto($monto_garantia); 
$sueldo_liquidacion=formato_monto($sueldo_liquidacion);  $sueldo_vacaciones=formato_monto($sueldo_vacaciones); $monto_cal_vac=formato_monto($monto_cal_vac);
$monto_ant_depositada=formato_monto($monto_ant_depositada);   $monto_art142=formato_monto($monto_art142);
$total_bono_vac_p=formato_monto($total_bono_vac_p); $total_vacaciones_p=formato_monto($total_vacaciones_p);
$monto_vacaciones_f=formato_monto($monto_vacaciones_f); $monto_bono_vac_f=formato_monto($monto_bono_vac_f); 
$total_adelantos=formato_monto($total_adelantos);  $total_intereses=formato_monto($total_intereses);  $int_fraccionados=formato_monto($int_fraccionados); 
$dias_vacaciones_f=formato_monto($dias_vacaciones_f);  $dias_bono_vac_f=formato_monto($dias_bono_vac_f);
$dias_vac=formato_monto($dias_vac);  $dias_bono_vac=formato_monto($dias_bono_vac); $tiempo_servicio=formato_monto($tiempo_servicio);
$dias_art142=formato_monto($dias_art142);  $dias_art92=formato_monto($dias_art92); $dias_dep=formato_monto($dias_dep);
$ufecha_p=$fecha_ingreso;
$sql="SELECT fecha_causa_hasta From NOM025 Where (cod_empleado='$cod_empleado') Order by fecha_causa_desde DESC"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>0){ $registro=pg_fetch_array($res); $ufecha_p=$registro["fecha_causa_hasta"]; $ufecha_p=formato_ddmmaaaa($ufecha_p);  }
$fecha_caus_h=nextano($ufecha_p,1);
?>
<form name="form2" method="post" action="Mod_cal_liquidacion.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
	 <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>	 
     <td width="5"><input name="txtcod_empleado" type="hidden" id="txtcod_empleado" value="<?echo $cod_empleado?>" ></td>
	 <td width="5"><input name="txtcedula" type="hidden" id="txtcedula" value="<?echo $cedula?>" ></td>
	 <td width="5"><input name="txtfecha_ingreso" type="hidden" id="txtfecha_ingreso" value="<?echo $fecha_ingreso?>" ></td>
	 <td width="5"><input name="txtnombre" type="hidden" id="txtnombre" value="<?echo $nombre?>" ></td>
	 <td width="5"><input name="txtcod_sue_bas" type="hidden" id="txtcod_sue_bas" value="<?echo $con_sue_bas?>"></td>
	 <td width="5"><input name="txtcod_sue_int" type="hidden" id="txtcod_sue_int" value="<?echo $con_sue_int?>" ></td>
     <td width="5"><input name="txtcon_cal_vac" type="hidden" id="txtcon_cal_vac" value="<?echo $con_cal_vac?>" ></td>     
     <td width="5"><input name="txtcon_bon_vac" type="hidden" id="txtcon_bon_vac" value="<?echo $con_bon_vac?>" ></td>
     <td width="5"><input name="txtfrec" type="hidden" id="txtfrec" value="<?echo $frec?>"></td>
     <td width="5"><input name="txtultima_fecha" type="hidden" id="txtultima_fecha" value="<?echo $ultima_fecha?>"></td>	 
     <td width="5"><input name="txtfecha_liquidacion" type="hidden" id="txtfecha_liquidacion" value="<?echo $fecha_liquidacion?>" ></td>
	 <td width="5"><input name="txttipo_liquidacion" type="hidden" id="txttipo_liquidacion" value="<?echo $tipo_liquidacion?>" ></td>
     <td width="5"><input name="txtant_ano" type="hidden" id="txtant_ano" value="<?echo $ant_ano?>"></td>
     <td width="5"><input name="txtant_mes" type="hidden" id="txtant_mes" value="<?echo $ant_mes?>"></td>
     <td width="5"><input name="txtant_dia" type="hidden" id="txtant_dia" value="<?echo $ant_dia?>"></td>
     <td width="5"><input name="txtmonto_sue_int" type="hidden" id="txtmonto_sue_int" value="<?echo $monto_sue_int?>"></td>
     <td width="5"><input name="txtsueldo_basico" type="hidden" id="txtsueldo_basico" value="<?echo $sueldo_basico?>"></td>
	 <td width="5"><input name="txtmonto_cal_vac" type="hidden" id="txtmonto_cal_vac" value="<?echo $monto_cal_vac?>"></td>
     <td width="5"><input name="txttiempo_servicio" type="hidden" id="txttiempo_servicio" value="<?echo $tiempo_servicio?>"></td>
     <td width="5"><input name="txtmonto_garantia" type="hidden" id="txtmonto_garantia" value="<?echo $monto_garantia?>"></td>
	 <td width="5"><input name="txtdias_dep" type="hidden" id="txtdias_dep" value="<?echo $dias_dep?>"></td>
	 <td width="5"><input name="txtmonto_banco" type="hidden" id="txtmonto_banco" value="<?echo $monto_banco?>"></td>
	 <td width="5"><input name="txtcampo_str1" type="hidden" id="txtcampo_str1" value="<?echo $campo_str1?>"></td>
	 
	 <td width="5"><input name="txtmonto_art142" type="hidden" id="txtmonto_art142" value="<?echo $monto_art142?>"></td>	
	 <td width="5"><input name="txtdias_art142" type="hidden" id="txtdias_art142" value="<?echo $dias_art142?>"></td>	
	 <td width="5"><input name="txtmonto_art92" type="hidden" id="txtmonto_art92" value="<?echo $monto_art92?>"></td>	
	 <td width="5"><input name="txtdias_art92" type="hidden" id="txtdias_art92" value="<?echo $dias_art92?>"></td>
	 <td width="5"><input name="txtfecha_ant_depositada" type="hidden" id="txtfecha_ant_depositada" value="<?echo $fecha_cal_garantia?>"></td>	 
	 <td width="5"><input name="txttotal_adelantos" type="hidden" id="txttotal_adelantos" value="<?echo $total_adelantos?>"></td>
	 <td width="5"><input name="txttotal_intereses" type="hidden" id="txttotal_intereses" value="<?echo $total_intereses?>"></td>
	 <td width="5"><input name="txtint_fraccionados" type="hidden" id="txtint_fraccionados" value="<?echo $int_fraccionados?>"></td>
	 <td width="5"><input name="txtdias_int_fraccionados" type="hidden" id="txtdias_int_fraccionados" value="<?echo $dias_int_fraccionados?>"></td>
	 <td width="5"><input name="txtdias_vacaciones_f" type="hidden" id="txtdias_vacaciones_f" value="<?echo $dias_vacaciones_f?>"></td>
	 <td width="5"><input name="txtmonto_vacaciones_f" type="hidden" id="txtmonto_vacaciones_f" value="<?echo $monto_vacaciones_f?>"></td>
	 <td width="5"><input name="txtdias_bono_vac_f" type="hidden" id="txtdias_bono_vac_f" value="<?echo $dias_bono_vac_f?>"></td>
	 <td width="5"><input name="txtmonto_bono_vac_f" type="hidden" id="txtmonto_bono_vac_f" value="<?echo $monto_bono_vac_f?>"></td>	 
	 <td width="5"><input name="txttotal_vacaciones_p" type="hidden" id="txttotal_vacaciones_p" value="<?echo $total_vacaciones_p?>"></td>
	 <td width="5"><input name="txttotal_bono_vac_p" type="hidden" id="txttotal_bono_vac_p" value="<?echo $total_bono_vac_p?>"></td>
	 <td width="5"><input name="txtdias_vac" type="hidden" id="txtdias_vac" value="<?echo $dias_vac?>"></td>
	 <td width="5"><input name="txtdias_bono_vac" type="hidden" id="txtdias_bono_vac" value="<?echo $dias_bono_vac?>"></td>	 
	 <td width="5"><input name="txtufecha_p" type="hidden" id="txtufecha_p" value="<?echo $ufecha_p?>"></td>
	 <td width="5"><input name="txtfecha_caus_h" type="hidden" id="txtfecha_caus_h" value="<?echo $fecha_caus_h?>"></td>	 
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?echo $Cod_Emp?>" ></td> 
  </tr>
</table>
</form>
</body>
</html>
<?pg_close();
if ($error==0){?><script language="JavaScript">Llamar_Inc_Calculo('S');</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }
?>