<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $fecha_ley="19/06/2007";$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$cod_empleado=$_POST["txtcod_empleado"];   $nombre=$_POST["txtnombre"]; $cod_bon_vac="000"; $tipo_nomina ="00"; $sfecha=formato_aaaammdd($fecha_hoy);$cod_concepto_v=$_POST["txtcod_concepto_v"]; $fecha_causa_desde=$_POST["txtfecha_caus_desde"]; $fecha_causa_hasta=$_POST["txtfecha_caus_hasta"];
$dias_habiles=$_POST["txtdias_habiles"];  $dias_habiles=formato_numero($dias_habiles); if(is_numeric($dias_habiles)){$dias_habiles=$dias_habiles;}else{$dias_habiles=0;}
$dias_no_habiles=$_POST["txtdias_no_habiles"];  $dias_no_habiles=formato_numero($dias_no_habiles); if(is_numeric($dias_no_habiles)){$dias_no_habiles=$dias_no_habiles;}else{$dias_no_habiles=0;}
$fecha_d_desde=$_POST["txtfecha_d_desde"]; $fecha_d_hasta=$_POST["txtfecha_d_hasta"]; $fecha_reincorp=$_POST["txtfecha_reincorp"]; 
$dias_bono_vac=$_POST["txtdias_bono_vac"]; $dias_bono_vac=formato_numero($dias_bono_vac); if(is_numeric($dias_bono_vac)){$dias_bono_vac=$dias_bono_vac;}else{$dias_bono_vac=0;}
$monto_bono_vac=$_POST["txtmonto_bono_vac"]; $monto_bono_vac=formato_numero($monto_bono_vac); if(is_numeric($monto_bono_vac)){$monto_bono_vac=$monto_bono_vac;}else{$monto_bono_vac=0;}
$dias_disfrutados=$_POST["txtdias_disfrutados"]; $dias_disfrutados=formato_numero($dias_disfrutados); if(is_numeric($dias_disfrutados)){$dias_disfrutados=$dias_disfrutados;}else{$dias_disfrutados=0;}
$calcula_nomina=$_POST["txtcalcula_nomina"]; $fecha_calculo_d=$_POST["txtfecha_calculo_d"]; $fecha_calculo_h=$_POST["txtfecha_calculo_h"];$url="Retornar_vacaciones.php?Gcodigo=".$cod_empleado; $operacion="N"; $dias_adelantado=0; $dias_pendientes=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select cod_empleado from NOM024 WHERE cod_empleado='$cod_empleado'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO TIENE SALIDA DE VACACIONES');</script><? }
  if($error==0){if(checkData($fecha_causa_desde)=='1'){$error=0; $fechacd=formato_aaaammdd($fecha_causa_desde);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE CAUSADO NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_causa_hasta)=='1'){$error=0; $fechach=formato_aaaammdd($fecha_causa_hasta);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE CAUSADO NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_d_desde)=='1'){$error=0; $fechadd=formato_aaaammdd($fecha_d_desde);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE DISFRUTE NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_d_hasta)=='1'){$error=0; $fechadh=formato_aaaammdd($fecha_d_hasta);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE DISFRUTE NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_reincorp)=='1'){$error=0; $fechar=formato_aaaammdd($fecha_reincorp);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE REINCORPORASE NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_calculo_d)=='1'){$error=0; $fechaad=formato_aaaammdd($fecha_d_desde);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE CALCULO NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_calculo_h)=='1'){$error=0; $fechaah=formato_aaaammdd($fecha_calculo_h);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE CALCULO NO ES VALIDA');</script><? }}
  if($dias_disfrutados>$dias_habiles){$dif1=0; $dif2=$dias_disfrutados-$dias_habiles; } else{ $dif1=$dias_habiles-$dias_disfrutados; $dif2=0;}
  if($error==0){$sql="SELECT * FROM NOM026 Where cod_empleado='$cod_empleado'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado); 
    if($filas==0){$operacion="N"; $dias_adelantado=$dif1; $dias_pendientes=$dif2; }
    else{$registro=pg_fetch_array($resultado); $operacion="M";  $dias_adelantado=$registro["dias_adelantado"]; 	$dias_pendientes=$registro["dias_pendientes"]; 
	    if($dias_adelantado>0){ $dias_adelantado=$dias_adelantado-$dif2+$dif1;   if($dias_adelantado<0){ $dif=$dias_adelantado; $dias_adelantado=0; $dias_pendientes=$dias_pendientes-$dif; }  }
        else{ $dias_pendientes=$dias_pendientes-$dif2+$dif1; if($dias_pendientes<0){$dif=$dias_adelantado; $dias_pendientes=0; $dias_adelantado=$dias_adelantado-$dif; } }		
	}  }
  if($error==0){$sql="SELECT * FROM TRABAJADORES Where cod_empleado='$cod_empleado'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado); if($filas==0){$error=1;?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? }
    else{$registro=pg_fetch_array($resultado); $fecha_ingreso=$registro["fecha_ingreso"]; $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso); 
	  $tipo_nomina=$registro["tipo_nomina"]; $tipo_pago=$registro["tipo_pago"];  $cod_cargo=$registro["cod_cargo"]; $cod_departam=$registro["cod_departam"];}  
  }  
  if($error==0){$sSQL="Select tipo_nomina,descripcion,con_sue_bas,con_compen,g_orden_pago,con_cal_vac,con_bon_vac,ultima_fecha,frecuencia from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado); $g_orden_pago=$registro["g_orden_pago"]; $frec=$registro["frecuencia"]; $ultima_fecha=$registro["ultima_fecha"];}}
  if(($error==0)and($calcula_nomina=="SI")){ $fecha_desde=formato_ddmmaaaa($ultima_fecha); $fecha_desde=nextDate($fecha_desde,1);
     if($frec=="M"){$fecha_hasta=colocar_udiames($fecha_desde);}  if($frec=="S"){$fecha_hasta=nextDate($fecha_desde,6);} 
     if($frec=="Q"){$dia=substr($fecha_desde,0,2); $fecha_hasta=colocar_udiames($fecha_desde); if($dia=='01'){$fecha_hasta=nextDate($fecha_desde,14);}}
     $m2=FDate($fecha_reincorp); $m1=FDate($fecha_hasta); 
     if($m2>$m1){ $error=1; echo $fecha_hasta." ".$fecha_reincorp." ".$m1." ".$m2,"<br>"; ?> <script language="JavaScript">muestra('Fecha Actual Calculo de nomina menor a Fecha Reincorporarse');</script><? }
  }
  if($error==0){$sSQL="SELECT ACTUALIZA_NOM025(2,'$cod_empleado','$fechacd','$fechach','$fechadd','$fechadh','$fechar','$fechaad','$fechaah','$calcula_nomina',$dias_habiles,$dias_no_habiles,$dias_bono_vac,$monto_bono_vac,$dias_disfrutados,'$usuario_sia','$minf_usuario','$operacion',$dias_adelantado,$dias_pendientes)";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}  } 
}
pg_close();
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>