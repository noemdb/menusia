<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");  $cod_empleado=$_GET["cod_empleado"]; $fecha_cal_fin=$_GET["fecha_cal"]; ?>
<html>
<head>  <title>PROCESAR CALCULO DE PRESTACIONES</title>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Calculo(mop){  document.form2.submit(); }
</script>
</head>
<body>
<?$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
 echo "ESPERE POR FAVOR PROCESANDO CALCULO.... ","<br>";  $fecha_hoy=asigna_fecha_hoy();
 $nombre="";$cedula=""; $fecha_ingreso="";  $ant_ano="";$ant_mes="";$ant_dia="";$cod_sue_int="";$monto_sue_int=0;$sueldo_basico=0;$tiempo_servicio=0;$monto_garantia=0;$monto_art142=0;$fecha_cal_garantia="";
 $sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado'"; $res=pg_query($sql); $filas=pg_num_rows($res);  
 echo  $sql,"<br>"; 
 if($filas>=1){ $registro=pg_fetch_array($res); $error=0; 
   $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; $tipo_nomina=$registro["tipo_nomina"];
   $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"];   $status=$registro["status"];  $sueldo_basico=$registro["sueldo"];
   $fecha_ing=$registro["fecha_ingreso"]; $fecha_ingreso=formato_ddmmaaaa($fecha_ing); 
 }
 $sql="Select * from NOM001 where tipo_nomina='$tipo_nomina'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO EXISTE');</script><?} 
else{ $registro=pg_fetch_array($res); $cod_sue_int=$registro["con_cal_liqui"]; }

$periodof=Calcula_dif_fechas($fecha_ingreso,$fecha_cal_fin);
$ant_ano=substr($periodof,0,4); $ant_mes=substr($periodof,4,2); $ant_dia=substr($periodof,6,2);
$dia_desde=substr($fecha_ingreso,0,2); $dia_hasta=substr($fecha_cal_fin,0,2); $mes_hasta=substr($fecha_cal_fin,3,2); $ano_hasta=substr($fecha_cal_fin,6,4);
if($dia_desde=="01"){ $diaProx=31;
   if ($mes_hasta=='04' || $mes_hasta=='06' || $mes_hasta=='09' || $mes_hasta=='11') { $diaProx=30; } 
   if ($mes_hasta=='02'){ $diaProx=28; if(bisiesto($anioPrev)==true){$diaProx=29;} } 
   if ($diaProx==$dia_hasta){ $ant_mes=$ant_mes*1; $ant_ano=$ant_ano*1; $ant_dia=0; $ant_mes=$ant_mes+1; if($ant_mes>=12){$ant_mes=$ant_mes-12; $ant_ano=$ant_ano+1; } }
}
$tano=$ant_ano*1; $tmes=$ant_mes*1; $tiempo_servicio=$tano;
If ($tmes >= 6){ $tiempo_servicio=$tano+1; } $fecha_cal_garantia=$fecha_ingreso;
$sql="Select * from nom030 where cod_empleado='$cod_empleado' order by fecha_calculo,num_calculo"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $fecha_cal=$registro["fecha_calculo"];  $fecha_cal_garantia=formato_ddmmaaaa($fecha_cal); 
  $monto_garantia=$registro["total_prestaciones"]; $monto_sue_int=$registro["sueldo_calculo"];  
}
$monto_art142=$monto_sue_int*$tiempo_servicio;
$monto_garantia=formato_monto($monto_garantia); $monto_art142=formato_monto($monto_art142); 
$sueldo_basico=formato_monto($sueldo_basico);  $monto_sue_int=formato_monto($monto_sue_int);
 ?>
<form name="form2" method="post" action="Inc_cal_prest_fin_relac.php">
<table width="10">
  <tr>
     <td width="5"><input class="Estilo10" name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input class="Estilo10" name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input class="Estilo10" name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input class="Estilo10" name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	
     <td width="5"><input class="Estilo10" name="txtcod_empleado" type="hidden" id="txtcod_empleado" value="<?echo $cod_empleado?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtcedula" type="hidden" id="txtcedula" value="<?echo $cedula?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtfecha_ingreso" type="hidden" id="txtfecha_ingreso" value="<?echo $fecha_ingreso?>" ></td>
	 <td width="5"><input class="Estilo10" name="txtnombre" type="hidden" id="txtnombre" value="<?echo $nombre?>" ></td>
     <td width="5"><input class="Estilo10" name="txtfecha_cal_fin" type="hidden" id="txtfecha_cal_fin" value="<?echo $fecha_cal_fin?>" ></td>
     <td width="5"><input class="Estilo10" name="txtant_ano" type="hidden" id="txtant_ano" value="<?echo $ant_ano?>"></td>
     <td width="5"><input class="Estilo10" name="txtant_mes" type="hidden" id="txtant_mes" value="<?echo $ant_mes?>"></td>
     <td width="5"><input class="Estilo10" name="txtant_dia" type="hidden" id="txtant_dia" value="<?echo $ant_dia?>"></td>	 
     <td width="5"><input class="Estilo10" name="txtcod_sue_int" type="hidden" id="txtcod_sue_int" value="<?echo $cod_sue_int?>"></td>
     <td width="5"><input class="Estilo10" name="txtmonto_sue_int" type="hidden" id="txtmonto_sue_int" value="<?echo $monto_sue_int?>"></td>
     <td width="5"><input class="Estilo10" name="txtsueldo_basico" type="hidden" id="txtsueldo_basico" value="<?echo $sueldo_basico?>"></td>
     <td width="5"><input class="Estilo10" name="txttiempo_servicio" type="hidden" id="txttiempo_servicio" value="<?echo $tiempo_servicio?>"></td>
     <td width="5"><input class="Estilo10" name="txtmonto_garantia" type="hidden" id="txtmonto_garantia" value="<?echo $monto_garantia?>"></td>
	 <td width="5"><input class="Estilo10" name="txtmonto_art142" type="hidden" id="txtmonto_art142" value="<?echo $monto_art142?>"></td>	
	 <td width="5"><input class="Estilo10" name="txtfecha_cal_garantia" type="hidden" id="txtfecha_cal_garantia" value="<?echo $fecha_cal_garantia?>"></td>	 
	 <td width="5"><input class="Estilo10" name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input class="Estilo10" name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?echo $Cod_Emp?>" ></td> 
  </tr>
</table>
</form>
<?   
pg_close();
if ($error==0){?><script language="JavaScript"> Llamar_Inc_Calculo('I');</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }
?>