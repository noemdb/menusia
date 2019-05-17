<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");
$equipo=getenv("COMPUTERNAME"); $mcod_m="LIQ".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$cod_empleado=$_POST["txtcod_empleado"]; $fecha_liquidacion=$_POST["txtfecha_liquidacion"]; $tipo_liquidacion=$_POST["txttipo_liquidacion"]; $fecha_hoy=asigna_fecha_hoy();
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
$error=1; $nombre=""; $nacionalidad=""; $descripcion=""; $cod_jerarquia=""; $codigo_ubicacion=""; $descripcion_ubi=""; 
$cedula=""; $rif_empleado=""; $fecha_ing=""; $fecha_ing_a=""; $ultima_fecha="2010-01-01"; $frec="Q";
$tipo_nomina=""; $nacionalidad=""; $status=""; $fecha_ingreso=""; $fecha_ing_adm=""; $cod_categoria=""; $tipo_pago=""; $cta_empleado=""; $campo_str1="";
$sueldo=0; $ant_ano="";$ant_mes="";$ant_dia="";$cod_sue_int="";$monto_sue_int=0;$sueldo_basico=0;$tiempo_servicio=0;$monto_garantia=0;$monto_art142=0;$fecha_cal_garantia="";
$sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){ $registro=pg_fetch_array($res); $error=0; 
  $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; 
  $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"];   $status=$registro["status"];  
  $fecha_ing=$registro["fecha_ingreso"]; $fecha_ing_a=$registro["fecha_ing_adm"]; 
  $fecha_ingreso=formato_ddmmaaaa($fecha_ing);  $fecha_ing_adm=formato_ddmmaaaa($fecha_ing_a);  
  $tipo_nomina=$registro["tipo_nomina"]; $sueldo=$registro["sueldo"];
}
$sueldo_basico=$sueldo;
$con_cal_vac=""; $con_bon_vac=""; $con_sue_int=""; $con_sue_bas=""; $nom_conc=""; $frec="";  $ultima_fecha=""; $monto_bono_vac=0;
$sql="Select * from NOM001 where tipo_nomina='$tipo_nomina'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO EXISTE');</script><?} 
else{ $registro=pg_fetch_array($res); $con_cal_vac=$registro["con_cal_vac"]; $con_bon_vac=$registro["con_bon_vac"]; $con_sue_bas=$registro["con_sue_bas"]; $con_sue_int=$registro["con_sue_int"]; $frec=$registro["frecuencia"];  $ultima_fecha=$registro["ultima_fecha"]; }

$periodof=Calcula_dif_fechas($fecha_ingreso,$fecha_liquidacion);
$ant_ano=substr($periodof,0,4); $ant_mes=substr($periodof,4,2); $ant_dia=substr($periodof,6,2);
$dia_desde=substr($fecha_ingreso,0,2); $dia_hasta=substr($fecha_liquidacion,0,2); $mes_hasta=substr($fecha_liquidacion,3,2); $ano_hasta=substr($fecha_liquidacion,6,4);
if($dia_desde=="01"){ $diaProx=31;
   if ($mes_hasta=='04' || $mes_hasta=='06' || $mes_hasta=='09' || $mes_hasta=='11') { $diaProx=30; } 
   if ($mes_hasta=='02'){ $diaProx=28; if(bisiesto($anioPrev)==true){$diaProx=29;} } 
   if ($diaProx==$dia_hasta){ $ant_mes=$ant_mes*1; $ant_ano=$ant_ano*1; $ant_dia=0; $ant_mes=$ant_mes+1; if($ant_mes>=12){$ant_mes=$ant_mes-12; $ant_ano=$ant_ano+1; } }
}
$tano=$ant_ano*1; $tmes=$ant_mes*1; $tiempo_servicio=$tano; $total_adelantos=0; $total_intereses=0; $total_prestamos=0; $ultima_tasa=0; $acumulado_total=0; $dias_dep=0;
If ($tmes >= 6){ $tiempo_servicio=$tano+1; } $fecha_cal_garantia=$fecha_ingreso; $tpresta=0;
$sql="Select * from nom030 where cod_empleado='$cod_empleado' order by fecha_calculo,num_calculo"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $fecha_cal=$registro["fecha_calculo"];  $fecha_cal_garantia=formato_ddmmaaaa($fecha_cal);  $tpresta=1;
  $monto_garantia=$registro["total_prestaciones"]; $monto_sue_int=$registro["sueldo_calculo"];  $acumulado_total=$registro["acumulado_total"];
  $total_adelantos=$registro["total_adelanto"];  $total_intereses=$registro["total_interes"];  $ultima_tasa=$registro["tasa_interes"]; $dias_dep=$registro["dias_prestaciones"];
} 
if($tpresta==1){
  $sql="Select dias_prestaciones from nom030 where cod_empleado='$cod_empleado' and (tipo_calculo='P' or  tipo_calculo='S')"; $res=pg_query($sql); $filas=pg_num_rows($res); 
  if($filas>1){
    $sql="Select sum(dias_prestaciones+dias_adicionales) as dias_dep from nom030 where cod_empleado='$cod_empleado' and (tipo_calculo='P' or  tipo_calculo='S')"; $res=pg_query($sql);$filas=pg_num_rows($res);
    if ($registro=pg_fetch_array($res,0)){  $dias_dep=$registro["dias_dep"]; } }
}  
if($monto_sue_int==0){$monto_sue_int=$sueldo_basico;} $monto_cal_vac=$sueldo_basico;
$monto_art142=$monto_sue_int*$tiempo_servicio; $dias_art142=30*$tiempo_servicio;
if(($tipo_liquidacion<>"JUSTIFICADO") And ($tipo_liquidacion<>"RENUNCIA") And  ($tipo_liquidacion<>"JUBILACION") )
{  if($monto_art142>$monto_garantia){$dias_art92=$dias_art142; $monto_art92=$monto_art142; } else{ $dias_art92=$dias_dep; $monto_art92=$monto_garantia; }  }else{ $dias_art92=0; $monto_art92=0;}
$temp_fecha=formato_ddmmaaaa($ultima_fecha); $mdia=substr($temp_fecha,0,2);
if($mdia=="15"){$temp_fecha=operacion_mes($temp_fecha,-1); }
$temp_fecha=colocar_udiames($temp_fecha); $sfecha=formato_aaaammdd($temp_fecha);
$sql="Select * from nom018 where tipo_nomina='$tipo_nomina' and cod_concepto='$con_cal_vac' and cod_empleado='$cod_empleado' and fecha_nomina='$sfecha'"; $res=pg_query($sql);$filas=pg_num_rows($res);
if ($registro=pg_fetch_array($res,0)){  $monto_cal_vac=$registro["monto"]; } if($monto_cal_vac==0){$monto_cal_vac=$sueldo;} 
$ufecha_p=$fecha_ingreso;
$sql="SELECT fecha_causa_hasta From NOM025 Where (cod_empleado='$cod_empleado') Order by fecha_causa_desde DESC"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>0){ $registro=pg_fetch_array($res); $ufecha_p=$registro["fecha_causa_hasta"]; $ufecha_p=formato_ddmmaaaa($ufecha_p);  }
$fecha_caus_h=nextano($ufecha_p,1);




$fecha1=formato_ddmmaaaa($fecha_ing); $fecha2=$fecha_caus_h; $f=diferencia_meses($fecha1,$fecha2); $dias_vac=0; $dias_bono_vac=0; $dias_nohabiles=0; $dias_bono_vac_a=0;


$sql="SELECT * from NOM020 where tipo_nomina='$tipo_nomina' order by consecutivo"; $res=pg_query($sql);
while(($registro=pg_fetch_array($res))and($dias_vac==0)) { $desde=$registro["desde"]; $hasta=$registro["hasta"];
  if(($f >=$desde)and($f<=$hasta)) { $dias_vac=$registro["vacaciones"]+$registro["vac_adicional"];  $dias_bono_vac=$registro["bono_vacacional"]; $dias_nohabiles=6; $dias_bono_vac_a=$registro["auxiliar1"]; echo $f." ".$desde." ".$hasta." ".$registro["consecutivo"],"<br>";}
}  
$m1=FDate($ufecha_p); $m2=FDate($fecha_liquidacion);
$monto_bono_vac_f=0; $monto_vacaciones_f=0; $dias_vacaciones_f=0; $dias_bono_vac_f=0; 
if ($m1<$m2){
  $dias_vac=($dias_vac*$ant_mes) / 12; $dias_vac=round($dias_vac,2);
  $dias_bono_vac=($dias_bono_vac*$ant_mes) / 12; $dias_bono_vac=round($dias_bono_vac,2);
  $dias_vacaciones_f=$dias_vac; $dias_bono_vac_f=$dias_bono_vac;
  $monto_vacaciones_f=($dias_vac * ($monto_cal_vac/30));  $monto_vacaciones_f=round($monto_vacaciones_f, 2);
  $monto_bono_vac_f=($dias_bono_vac * ($monto_cal_vac/30)); $monto_bono_vac_f=round($monto_bono_vac_f, 2);
}      
$total_vacaciones_p=0; $total_bono_vac_p=0; $dias_vac_p=0; $dias_bono_vac_p=0; $dias_vac=0; $dias_bono_vac=0; 
$fecha_caus_h=nextano($ufecha_p,1);
$m1=FDate($fecha_caus_h); $m2=FDate($fecha_liquidacion);
While ($m1<$m2) {
   $fecha1=formato_ddmmaaaa($fecha_ing); $fecha2=$fecha_caus_h; $f=diferencia_meses($fecha1,$fecha2); $dias_vac=0; $dias_bono_vac=0; $dias_nohabiles=0; $dias_bono_vac_a=0;
   $sql="SELECT * from NOM020 where tipo_nomina='$tipo_nomina' order by consecutivo"; $res=pg_query($sql);
   while(($registro=pg_fetch_array($res))and($dias_vac==0)) { $desde=$registro["desde"]; $hasta=$registro["hasta"];
     if(($f >=$desde)and($f<=$hasta)) { $dias_vac=$registro["vacaciones"]+$registro["vac_adicional"];  $dias_bono_vac=$registro["bono_vacacional"]; $dias_nohabiles=6; $dias_bono_vac_a=$registro["auxiliar1"]; echo $f." ".$desde." ".$hasta." ".$registro["consecutivo"],"<br>";}
   }  
   $total_vacaciones_p=$total_vacaciones_p+($dias_vac*($monto_cal_vac/30));  $total_vacaciones_p=round($total_vacaciones_p,2); 
   $total_bono_vac_p=$total_bono_vac_p+($dias_bono_vac*($monto_cal_vac/30));  $total_bono_vac_p=round($total_bono_vac_p,2); 
   $dias_vac_p=$dias_vac_p+$dias_vac; $dias_bono_vac_p=$dias_bono_vac_p+$dias_bono_vac;
   $fecha_caus_h=nextano($fecha_caus_h,1); $m1=FDate($fecha_caus_h); $m2=FDate($fecha_liquidacion);
   //echo "Diferencia: ".$f." ".$fecha1." ".$fecha2,"<br>";
}
$m1=FDate($fecha_cal_garantia); $m2=FDate($fecha_liquidacion); 
$cant_int_fracc=$m2-$m1; $int_fraccionados=0; $dias_int_fraccionados=0;
if($cant_int_fracc>1){
  $dias_int_fraccionados=$cant_int_fracc;
  $int_fraccionados=($acumulado_total*$dias_int_fraccionados*$ultima_tasa)/36500;
  $int_fraccionados=round($int_fraccionados,2);
}  
$monto_banco=$monto_garantia-$total_adelantos; $monto_banco=formato_monto($monto_banco); 
$monto_garantia=formato_monto($monto_garantia); $monto_art142=formato_monto($monto_art142); 
$sueldo_basico=formato_monto($sueldo_basico);  $monto_sue_int=formato_monto($monto_sue_int); $monto_cal_vac=formato_monto($monto_cal_vac);   
$total_adelantos=formato_monto($total_adelantos);  $total_intereses=formato_monto($total_intereses);  $int_fraccionados=formato_monto($int_fraccionados); 
$monto_vacaciones_f=formato_monto($monto_vacaciones_f); $monto_bono_vac_f=formato_monto($monto_bono_vac_f);
$dias_vacaciones_f=formato_monto($dias_vacaciones_f);  $dias_bono_vac_f=formato_monto($dias_bono_vac_f);
$total_vacaciones_p=formato_monto($total_vacaciones_p); $total_bono_vac_p=formato_monto($total_bono_vac_p);
$dias_vac=formato_monto($dias_vac_p);  $dias_bono_vac=formato_monto($dias_bono_vac_p);
$sSQL="SELECT ELIMINA_NOM076('$codigo_mov')"; $resultado=pg_exec($conn,$sSQL);
?>
<form name="form2" method="post" action="Inc_cal_liquidacion.php">
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
/* */
if ($error==0){?><script language="JavaScript">Llamar_Inc_Calculo('S');</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }

?>