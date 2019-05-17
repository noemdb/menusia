<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();  $fecha_ley="19/06/2007";
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$cod_empleado=$_POST["txtcod_empleado"];  $codigo_mov=$_POST["txtcodigo_mov"]; $fecha_liquidacion=$_POST["txtfecha_liquidacion"]; $tipo_liquidacion=$_POST["txttipo_liquidacion"];
$ant_ano=$_POST["txtant_ano"]; $ant_mes=$_POST["txtant_mes"]; $ant_dia=$_POST["txtant_dia"]; $con_bon_vac=$_POST["txtcon_bon_vac"]; $con_cal_vac=$_POST["txtcon_cal_vac"];
$cod_sue_bas=$_POST["txtcod_sue_bas"]; $cod_sue_int=$_POST["txtcod_sue_int"]; $tiempo_servicio=$_POST["txttiempo_servicio"]; $dias_preaviso=$_POST["txtdias_preaviso"];  $dias_art142=$_POST["txtdias_art142"];  
$dias_art92=$_POST["txtdias_art92"];  $dias_ant_dep=$_POST["txtdias_ant_dep"];  $fecha_ant_depositada=$_POST["txtfecha_ant_depositada"]; $dias_int_fraccionados=$_POST["txtdias_int_fraccionados"];
$dias_vacaciones_f=$_POST["txtdias_vacaciones_f"];$dias_bono_vac_f=$_POST["txtdias_bono_vac_f"]; $dias_vac=$_POST["txtdias_vac"];   $dias_bono_vac=$_POST["txtdias_bono_vac"]; $campo_str1=$_POST["txtcampo_str1"];
$total_asignacion=0; $total_deduccion=0; $total_prestamos=0; $monto_banco=$_POST["txtmonto_banco"]; $monto_banco=formato_numero($monto_banco);
$tiempo_servicio=formato_numero($tiempo_servicio);$dias_preaviso=formato_numero($dias_preaviso);$dias_art142=formato_numero($dias_art142);
$dias_art92=formato_numero($dias_art92);$dias_ant_dep=formato_numero($dias_ant_dep);$dias_int_fraccionados=formato_numero($dias_int_fraccionados);
$dias_vacaciones_f=formato_numero($dias_vacaciones_f);$dias_bono_vac_f=formato_numero($dias_bono_vac_f); $dias_vac=formato_numero($dias_vac); $dias_bono_vac=formato_numero($dias_bono_vac);
$sueldo_basico=$_POST["txtsueldo_basico"]; $sueldo_basico=formato_numero($sueldo_basico); if(is_numeric($sueldo_basico)){$sueldo_basico=$sueldo_basico;}else{$sueldo_basico=0;}
$monto_cal_vac=$_POST["txtsueldo_vacaciones"]; $monto_cal_vac=formato_numero($monto_cal_vac); if(is_numeric($monto_cal_vac)){$monto_cal_vac=$monto_cal_vac;}else{$monto_cal_vac=0;}
$monto_sue_int=$_POST["txtsueldo_liquidacion"]; $monto_sue_int=formato_numero($monto_sue_int); if(is_numeric($monto_sue_int)){$monto_sue_int=$monto_sue_int;}else{$monto_sue_int=0;}
$sueldo_liquidacion=$_POST["txtsueldo_liquidacion"]; $sueldo_liquidacion=formato_numero($sueldo_liquidacion); if(is_numeric($sueldo_liquidacion)){$sueldo_liquidacion=$sueldo_liquidacion;}else{$sueldo_liquidacion=0;}
$sueldo_vacaciones=$_POST["txtsueldo_vacaciones"]; $sueldo_vacaciones=formato_numero($sueldo_vacaciones); if(is_numeric($sueldo_vacaciones)){$sueldo_vacaciones=$sueldo_vacaciones;}else{$sueldo_vacaciones=0;}
$monto_preaviso=$_POST["txtmonto_preaviso"]; $monto_preaviso=formato_numero($monto_preaviso); if(is_numeric($monto_preaviso)){$monto_preaviso=$monto_preaviso;}else{$monto_preaviso=0;}
$monto_art142=$_POST["txtmonto_art142"]; $monto_art142=formato_numero($monto_art142); if(is_numeric($monto_art142)){$monto_art142=$monto_art142;}else{$monto_art142=0;}
$monto_art92=$_POST["txtmonto_art92"]; $monto_art92=formato_numero($monto_art92); if(is_numeric($monto_art92)){$monto_art92=$monto_art92;}else{$monto_art92=0;}
$monto_ant_depositada=$_POST["txtmonto_ant_depositada"]; $monto_ant_depositada=formato_numero($monto_ant_depositada); if(is_numeric($monto_ant_depositada)){$monto_ant_depositada=$monto_ant_depositada;}else{$monto_ant_depositada=0;}
$total_adelantos=$_POST["txttotal_adelantos"]; $total_adelantos=formato_numero($total_adelantos); if(is_numeric($total_adelantos)){$total_adelantos=$total_adelantos;}else{$total_adelantos=0;}
$total_intereses=$_POST["txttotal_intereses"]; $total_intereses=formato_numero($total_intereses); if(is_numeric($total_intereses)){$total_intereses=$total_intereses;}else{$total_intereses=0;}
$int_fraccionados=$_POST["txtint_fraccionados"]; $int_fraccionados=formato_numero($int_fraccionados); if(is_numeric($int_fraccionados)){$int_fraccionados=$int_fraccionados;}else{$int_fraccionados=0;}
$monto_vacaciones_f=$_POST["txtmonto_vacaciones_f"]; $monto_vacaciones_f=formato_numero($monto_vacaciones_f); if(is_numeric($monto_vacaciones_f)){$monto_vacaciones_f=$monto_vacaciones_f;}else{$monto_vacaciones_f=0;}
$monto_bono_vac_f=$_POST["txtmonto_bono_vac_f"]; $monto_bono_vac_f=formato_numero($monto_bono_vac_f); if(is_numeric($monto_bono_vac_f)){$monto_bono_vac_f=$monto_bono_vac_f;}else{$monto_bono_vac_f=0;}
$total_vacaciones_p=$_POST["txttotal_vacaciones_p"]; $total_vacaciones_p=formato_numero($total_vacaciones_p); if(is_numeric($total_vacaciones_p)){$total_vacaciones_p=$total_vacaciones_p;}else{$total_vacaciones_p=0;}
$total_bono_vac_p=$_POST["txttotal_bono_vac_p"]; $total_bono_vac_p=formato_numero($total_bono_vac_p); if(is_numeric($total_bono_vac_p)){$total_bono_vac_p=$total_bono_vac_p;}else{$total_bono_vac_p=0;}
$url="Act_liqui_presta.php?Gcriterio=C".$cod_empleado;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{ $sql="Select * FROM NOM035  where (cod_empleado='$cod_empleado')";  $res=pg_query($sql); $filas=pg_num_rows($res); 
  if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR TIENE CALCULO DE LIQUIDACION');</script><? }
  if($error==0){ $sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
    if($filas>=1){ $registro=pg_fetch_array($res); $error=0;  $cod_cargo=$registro["cod_cargo"]; $cod_departamento=$registro["cod_departam"];	
    }else{ $error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? }	
	if($error==0){$sSQL="Select * from NOM004 WHERE codigo_cargo='$cod_cargo'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CARGO NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado); $des_cargo=$registro["denominacion"];}}
    if($error==0){$sSQL="Select * from NOM005 WHERE codigo_departamento='$cod_departamento'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);if($filas==0){$error=1; echo $sSQL; ?> <script language="JavaScript"> muestra('CODIGO DE DEPARTAMENTO NO EXISTE');</script><?}else{$registro=pg_fetch_array($resultado); $des_departamento=$registro["descripcion_dep"];} }
    if($error==0){ $sql="Select * from NOM076 where (codigo_mov='$codigo_mov') order by cod_concepto,fecha_hasta"; $res=pg_query($sql);
      while($registro=pg_fetch_array($res)) { $cantidad=$registro["cantidad"]; $monto=$registro["monto_orig"]; $total=$registro["valor"]; 
      if($registro["oculto"]=="NO"){ if($registro["asig_ded_apo"]=="A"){$total_asignacion=$total_asignacion+$registro["valor"];} if($registro["asig_ded_apo"]=="D"){$total_deduccion=$total_deduccion+$registro["valor"];} } } 
    }	
	if($error==0){if(checkData($fecha_liquidacion)=='1'){$error=0; $fechal=formato_aaaammdd($fecha_liquidacion);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE LIQUIDACION NO ES VALIDA');</script><? }}
    if($error==0){if(checkData($fecha_ant_depositada)=='1'){$error=0; $fechaa=formato_aaaammdd($fecha_ant_depositada);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE ANTIUEDAD DEPOSITADA NO ES VALIDA');</script><? }}
    if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);
      $sSQL="SELECT ACTUALIZA_NOM035(1,'$codigo_mov','$cod_empleado','$fechal',$ant_ano,$ant_mes,$ant_dia,'$cod_sue_bas',$sueldo_basico,'$con_cal_vac',$monto_cal_vac,'$con_cal_vac','$cod_sue_int',$monto_sue_int,'$cod_sue_int',$monto_sue_int,'$cod_cargo','$des_cargo','$cod_departamento','$des_departamento','$tipo_liquidacion',$tiempo_servicio,$sueldo_liquidacion,$sueldo_vacaciones,$dias_preaviso,$monto_preaviso,$dias_art142,$monto_art142,$dias_art92,$monto_art92,$dias_ant_dep,$monto_ant_depositada,'$fechaa',$total_adelantos,$total_prestamos,$total_intereses,$int_fraccionados,$dias_int_fraccionados,$dias_vacaciones_f,$monto_vacaciones_f,$dias_bono_vac_f,$monto_bono_vac_f,$total_vacaciones_p,$total_bono_vac_p,$total_asignacion,$total_deduccion,'','','$campo_str1','',$monto_banco,0,'$usuario_sia','$minf_usuario')"; echo $sSQL;
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}
    }
  }
}
pg_close();
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>