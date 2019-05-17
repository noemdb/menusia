<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $fecha_ley="19/06/2007";
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$cod_empleado=$_POST["txtcod_empleado"];  $codigo_mov=$_POST["txtcodigo_mov"]; $cod_bon_vac="000"; $tipo_nomina ="00"; $sfecha=formato_aaaammdd($fecha_hoy);
$fecha_causa_desde=$_POST["txtfecha_caus_desde"]; $fecha_causa_hasta=$_POST["txtfecha_caus_hasta"];
$fecha_d_desde=$_POST["txtfecha_d_desde"]; $fecha_d_hasta=$_POST["txtfecha_d_hasta"]; $fecha_reincorp=$_POST["txtfecha_reincorp"]; 
$cod_concepto_v=$_POST["txtcod_concepto_v"]; $fecha_calculo_d=$_POST["txtfecha_calculo_d"]; $fecha_calculo_h=$_POST["txtfecha_calculo_h"];
$dias_habiles=$_POST["txtdias_habiles"];  $dias_habiles=formato_numero($dias_habiles); if(is_numeric($dias_habiles)){$dias_habiles=$dias_habiles;}else{$dias_habiles=0;}
$dias_no_habiles=$_POST["txtdias_no_habiles"];  $dias_no_habiles=formato_numero($dias_no_habiles); if(is_numeric($dias_no_habiles)){$dias_no_habiles=$dias_no_habiles;}else{$dias_no_habiles=0;}
$dias_bono_vac=$_POST["txtdias_bono_vac"]; $dias_bono_vac=formato_numero($dias_bono_vac); if(is_numeric($dias_bono_vac)){$dias_bono_vac=$dias_bono_vac;}else{$dias_bono_vac=0;}
$monto_bono_vac=$_POST["txtmonto_bono_vac"]; $monto_bono_vac=formato_numero($monto_bono_vac); if(is_numeric($monto_bono_vac)){$monto_bono_vac=$monto_bono_vac;}else{$monto_bono_vac=0;}
$dias_bono_vac_a=0; $monto_bono_vac_a=0; $dias_disfrutados=0;
$calcula_nomina=$_POST["txtcalcula_nomina"]; $fecha_calculo_d=$_POST["txtfecha_calculo_d"]; $fecha_calculo_h=$_POST["txtfecha_calculo_h"];
$monto_concepto_v=$_POST["txtmonto_base"]; $monto_concepto_v=formato_numero($monto_concepto_v); if(is_numeric($monto_concepto_v)){$monto_concepto_v=$monto_concepto_v;}else{$monto_concepto_v=0;}
$status="N"; $bloqueada="N"; $Observacion="";$des_cargo="";$des_departamento="";$num_ord_pago="";$fecha_ord_pago=$sfecha;$cod_banco_pago="0000";$nro_cheque="";$fecha_cheque=$sfecha;$tipo_pago="";  
$url="Act_calculo_vacaciones.php?Gcriterio=C".$cod_empleado;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select cod_empleado from NOM022 WHERE cod_empleado='$cod_empleado'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR TIENE CALCULO DE VACACIONES');</script><? }
  if($error==0){if(checkData($fecha_causa_desde)=='1'){$error=0; $fechacd=formato_aaaammdd($fecha_causa_desde);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE CAUSADO NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_causa_hasta)=='1'){$error=0; $fechach=formato_aaaammdd($fecha_causa_hasta);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE CAUSADO NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_d_desde)=='1'){$error=0; $fechadd=formato_aaaammdd($fecha_d_desde);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE DISFRUTE NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_d_hasta)=='1'){$error=0; $fechadh=formato_aaaammdd($fecha_d_hasta);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE DISFRUTE NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_calculo_d)=='1'){$error=0; $fechaad=formato_aaaammdd($fecha_calculo_d);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE CALCULO NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_calculo_h)=='1'){$error=0; $fechaah=formato_aaaammdd($fecha_calculo_h);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE CALCULO NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_reincorp)=='1'){$error=0; $fechar=formato_aaaammdd($fecha_reincorp);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE REINCORPORASE NO ES VALIDA');</script><? }}
  if($error==0){$sql="SELECT * FROM TRABAJADORES Where cod_empleado='$cod_empleado'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado); if($filas==0){$error=1;?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? }
    else{$registro=pg_fetch_array($resultado); $fecha_ingreso=$registro["fecha_ingreso"]; $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso); 
	  $tipo_nomina=$registro["tipo_nomina"]; $tipo_pago=$registro["tipo_pago"];  $cod_cargo=$registro["cod_cargo"]; $cod_departam=$registro["cod_departam"];}  
	if($error==0){$sSQL="Select denominacion from NOM004 WHERE codigo_cargo='$cod_cargo'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CARGO NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado); $des_cargo=$registro["denominacion"];}}
    if($error==0){$sSQL="Select descripcion_dep from NOM005 WHERE codigo_departamento='$cod_departam'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE DEPARTAMENTO NO EXISTE');</script><?}else{$registro=pg_fetch_array($resultado); $des_departamento=$registro["descripcion_dep"];}}
  
  }
  if($error==0){$sSQL="Select tipo_nomina,descripcion,con_sue_bas,con_compen,g_orden_pago,con_cal_vac,con_bon_vac from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado); $con_cal_vac=$registro["con_cal_vac"]; $cod_bon_vac=$registro["con_bon_vac"]; $g_orden_pago=$registro["g_orden_pago"]; $cod_conc_s=$registro["con_sue_bas"]; $cod_conc_c=$registro["con_compen"];}}
  if($error==0){$sSQL="Select cod_concepto from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_bon_vac'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CONCEPTO BONO VACACIONAL NO EXISTE');</script><? }}
   
  if(($error==0)and($calcula_nomina=="NO")){   
    $sSQL="SELECT ELIMINA_NOM076('$codigo_mov')"; $resultado=pg_exec($conn,$sSQL);
	$sqla="SELECT * FROM CONCEPTOS_ASIGNADOS WHERE (tipo_nomina='$tipo_nomina') And (cod_empleado='$cod_empleado') and (cod_concepto='$cod_bon_vac')"; $resa=pg_query($sqla); $filas=pg_num_rows($resa);
	if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CONCEPTO BONO VACACIONAL NO ASIGNADO AL TRABAJADOR');</script><?} 
	 else{$rega=pg_fetch_array($resa); $cod_concepto=$rega["cod_concepto"]; $den_concepto=$rega["denominacion"]; $cod_orden=$rega["cod_orden"]; $fecha_exp=$rega["fecha_exp"]; $fecha_ini=$rega["fecha_ini"]; $frecuenciaa=$rega["frecuenciaa"]; $frecuencia=$rega["frecuencia"]; $frec_valida="S";  $calculable=$rega["calculable"]; $statusa=$rega["status"]; $concepto_vac="S";
	  $calculable="NO"; $asignacion=$rega["asignacion"]; $oculto=$rega["oculto"]; $acumula=$rega["acumula"]; $tipo_a=$rega["tipo_asigna"]; $asig_ded_apo=$rega["asig_ded_apo"]; $prestamo=$rega["prestamo"]; $int_cal_vac=substr($statusa,0,1); $cantidad=$rega["cantidad"]; $monto_orig=$rega["monto"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $cod_contable=$rega["cod_contable"];$cod_presup=$rega["cod_presup"]; $afecta_presup=$rega["afecta_presup"]; $cod_retencion=$rega["cod_retencion"];
      $valor=$monto_bono_vac; $cantidad=$dias_bono_vac; $valore=0; $valorq=0; $valoru=0; $valorv=0; $valorw=0; $valorx=0; $valory=0; $valorz=0; 
	  $cantidad=cambia_coma_numero($cantidad); $valor=cambia_coma_numero($valor);
	  $sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','$calculable','$asignacion','$acumula','$oculto','$tipo_a','$asig_ded_apo','$frec_valida','$prestamo','$concepto_vac','$int_cal_vac',$acumulado,$saldo,$valore,$valorq,$valoru,$valorv,$valorw,$valorx,$valory,$valorz,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$fecha_ini','$fecha_exp','$fechadh',$frecuenciaa,'$cod_orden')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=11;}
    }
  }
  if($error==0){    $tipo_pago=substr($tipo_pago,0,3);    
	 $sSQL="SELECT ACTUALIZA_NOM022(1,'$codigo_mov','$cod_empleado','$fechacd','$fechach','$fechadd','$fechadh','$fechar','$cod_concepto_v','$cod_bon_vac',$dias_habiles,$dias_no_habiles,$dias_bono_vac,$monto_bono_vac,$dias_bono_vac_a,$monto_bono_vac_a,'$calcula_nomina','$fechaad','$fechaah',$monto_concepto_v,'$status','$bloqueada','$Observacion','$des_cargo','$des_departamento','$num_ord_pago','$fecha_ord_pago','$cod_banco_pago','$nro_cheque','$fecha_cheque','$tipo_pago','$usuario_sia','$minf_usuario','$tipo_nomina')";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?  }  
    echo $sSQL;  
  } 
}
pg_close();
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>

