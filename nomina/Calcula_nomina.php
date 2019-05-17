<?include ("../class/conect.php"); include ("../class/funciones.php"); include ("../class/configura.inc"); $fecha_hoy=asigna_fecha_hoy(); $eofline="@"; $php_os=PHP_OS;
set_time_limit(0);
if (!$_GET){$criterio='';}else{$criterio=$_GET["criterio"];}  $u_semana="S"; //echo $criterio,"<br>";
 $tipo_nomina=substr($criterio,0,2); $fecha_desde=substr($criterio,2,10); $fecha_hasta=substr($criterio,12,10); 
 $num_semanas=substr($criterio,22,1); $parametro=substr($criterio,23,1); $u_semana=substr($criterio,24,1); $pcod_trab=substr($criterio,26,15);
$cod_empleado=""; $fecha_pago_vac=$fecha_hoy; $pago_vacaciones="N"; $num_recibo=0; $redondear="N"; $bloqueada="N"; $tp_calculo='N'; $campo_num1=0; 
$calculo1_val=0; $calculo2_val=0; $calculo_final_val=0; $a_dic=""; $pos=0; $formula=""; $opr=""; $cual=""; $Ch=""; $EXY="";  $valor=0; $fecha_nacimiento="";
include ("cal_conceptos.php"); 
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR CALCULANDO....","<br>";
?>
<html>
<head>
<title>SIA CONTROL N&Oacute;MINA Y PERSONAL (Calculo de Nomina)</title>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
<LINK  href="../class/sia.css" type="text/css" rel="stylesheet">
<script language="JavaScript" type="text/JavaScript">
function callprogress(vValor){
 document.getElementById("getprogress").innerHTML = vValor;
 document.getElementById("getProgressBarFill").innerHTML = '<div class="ProgressBarFill" style="width: '+vValor+'%;"></div>';
}
</script>
<style type="text/css">
    .ProgressBar     { width: 50em; border: 2px solid black; background: #eef; height: 2.5em; display: block; }
    .ProgressBarText { position: absolute; font-size: 1em; width: 50em; text-align: center; font-weight: normal; }
    .ProgressBarFill { height: 100%; background: #aae; display: block; overflow: visible; }
</style>
</head>
<body>
<body>
<form name="form1" method="post" action="" >
  <table width="761" height="70" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="660" border="0" cellpadding="3" cellspacing="3">
        
           <tr> <td>&nbsp;</td> </tr>
           <tr>
             <td><table width="760">
                 <tr> <td>
				   <div class="ProgressBar">
					  <div class="ProgressBarText"><span id="getprogress"></span>&nbsp;% completado</div>
					  <div id="getProgressBarFill"></div>
					</div></td> </tr>
             </table></td>
           </tr>
        <tr> <td>&nbsp;</td> </tr>
		</table></td>      
    </tr>  
  </table>

<?php
$url="Det_cal_nomina.php?criterio=".$tipo_nomina.$tp_calculo; $cant_trab=0; $hora1=time(); $cod_grupo=""; $cod_concepto_reposo="000";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}else{ $Nom_Emp=busca_conf(); }
$campo502="NNNNNNNNNNNNNNNNNNN"; $error=0;  $Monto_Sueldo_SSO=0;
$sql="Select campo502,campo535  from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $Monto_Sueldo_SSO=$registro["campo535"];} $proc_vac_nom=substr($campo502,5,1);
if($error==0){$sSQL="Select * from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA NO EXISTE');</script><?}else{$registro=pg_fetch_array($resultado); $g_orden_pago=$registro["g_orden_pago"]; $frec_nom=$registro["frecuencia"]; $des_nomina=$registro["descripcion"]; $desc_grupo=$registro["desc_grupo"]; $redondear=$registro["redondear"]; $bloqueada=$registro["bloqueada"];$con_cal_vac=$registro["con_cal_vac"];$con_bon_vac=$registro["con_bon_vac"];$con_cal_vac=$registro["con_cal_vac"]; $con_bon_vac_ant=$registro["con_bon_vac"];  $cod_grupo=$registro["cod_grupo"]; if(trim($cod_grupo)==""){$cod_grupo="00";} } }
if($error==0){if($bloqueada=='S'){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA ESTA BLOQUEADA');</script><?}}
if($error==0){$cal_frecuencia=1; $dia=substr($fecha_hasta,0,2); if($frec_nom=="Q"){if($dia==15){$cal_frecuencia=1;}else{$cal_frecuencia=2;} }   if($frec_nom=="S"){ if($u_semana=="S"){$cal_frecuencia=0;} }  }
if($error==0){if(checkData($fecha_desde)=='1'){$fechad=formato_aaaammdd($fecha_desde);}else{$error=1;?><script language="JavaScript">muestra('FECHA DESDE NO ES VALIDA');</script><?}}
if($error==0){if(checkData($fecha_hasta)=='1'){$fechah=formato_aaaammdd($fecha_hasta);}else{$error=1;?><script language="JavaScript">muestra('FECHA HASTA NO ES VALIDA');</script><?}}
if($error==0){if(($proc_vac_nom=="S")or($Cod_Emp=="71")){$sSQL="Select cod_empleado,fecha_reincorp FROM NOM024 Where (fecha_reincorp<='$fechah') And (NOM024.cod_empleado IN (SELECT NOM006.cod_empleado FROM NOM006 Where tipo_nomina='$tipo_nomina'))";$resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);if($filas>=1){$error=0;?><script language="JavaScript">muestra('Existen Trabajadores en Vacaciones, los Cuales deben ser Retornados');</script><?} } }
if($error==0){if(($proc_vac_nom=="S")or($Cod_Emp=="71")){$sSQL="Select cod_empleado,fecha_desde FROM NOM022 Where (fecha_desde<='$fechah') And (NOM022.cod_empleado IN (SELECT NOM006.cod_empleado FROM NOM006 Where tipo_nomina='$tipo_nomina'))";if($Cod_Emp=="58"){ $sSQL="Select cod_empleado,fecha_desde FROM NOM022 Where (fecha_desde<'$fechad') And (NOM022.cod_empleado IN (SELECT NOM006.cod_empleado FROM NOM006 Where tipo_nomina='$tipo_nomina'))";} $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);if($filas>=1){$error=0;?><script language="JavaScript">muestra('Existen Trabajadores con Calculo Vacaciones, los Cuales deben tener Salida de Vacaciones');</script><?} }}
//$error=0;
//echo $sSQL,"<br>";
if($error==0){if($parametro=="T"){$sSQL="SELECT ELIM_CAL_NOMINA('$tipo_nomina','N')"; $resultado=pg_exec($conn,$sSQL); $sql="select * from CAL_NOMINA where (tipo_nomina='$tipo_nomina') and (fecha_ingreso<='$fechah') and (fecha_egreso>='$fechad') order by tipo_nomina,cod_departam,cod_cargo,cod_empleado"; }
 else{$sSQL="SELECT ELIM_CAL_NOM_TRAB('$tipo_nomina','N','$pcod_trab')"; $resultado=pg_exec($conn,$sSQL); $sql="select * from CAL_NOMINA where (tipo_nomina='$tipo_nomina') and (cod_empleado='$pcod_trab') and (fecha_ingreso<='$fechah') and (fecha_egreso>='$fechad') order by tipo_nomina,cod_departam,cod_cargo,cod_empleado"; } $res=pg_query($sql);   $ValorTotal=pg_num_rows($res);
 //echo $sql,"<br>";
 while($reg=pg_fetch_array($res)){ $cod_empleado=$reg["cod_empleado"]; $status_trab=$reg["status"]; $pago_vacaciones=$reg["pago_vaciones"]; $fecha_pago_vac=$reg["fecha_pago"];  $cedula=$reg["cedula"]; $nacionalidad=$reg["nacionalidad"]; $nombre=$reg["nombre"]; $fecha_ingreso=$reg["fecha_ingreso"]; $cod_cargo=$reg["cod_cargo"]; $cod_departam=$reg["cod_departam"]; $cod_tipo_personal=$reg["cod_tipo_personal"]; $fecha_ing_adm=$reg["fecha_ing_adm"];  if($Cod_Emp=="71"){$fuente_emp="";}else{$fuente_emp=$reg["campo_str1"];} $cod_categoria=$reg["cod_categoria"];
  $des_cargo=$reg["denominacion"]; $des_departam=$reg["descripcion_dep"]; $des_tipo_personal=$reg["des_tipo_personal"]; $sueldo=$reg["sueldo"]; $compensacion=$reg["compensacion"]; $prima=$reg["prima"]; $sueldo_integral=$reg["sueldo"]+$reg["prima"]+$reg["compensacion"]; $otros=$reg["otros"]; $tipo_pago=$reg["tipo_pago"];  $cta_empleado=$reg["cta_empleado"];  $cta_empresa=$reg["cta_empresa"]; $cod_banco=$reg["cod_banco"]; $nombre_banco=$reg["nombre_banco"]; $cod_ubicacion=$reg["codigo_ubicacion"]; $sexo=$reg["sexo"]; $campo_num1=$reg["campo_num1"];
  $edo_civil=substr($reg["edo_civil"],0,1); if($reg["edo_civil"]=="CONCUBINO"){$edo_civil="U";} $tipo_cuenta=substr($reg["tipo_cuenta"],0,1); if($tipo_cuenta==""){$tipo_cuenta="N";} $cont_fijo=$reg["cont_fijo"]; $status_calculo=$reg["cont_fijo"].substr($nacionalidad,0,1).$tipo_cuenta.substr($reg["sexo"],0,1).$edo_civil;  $des_ubicacion=$reg["descripcion_ubi"]; $fecha_egreso=$reg["fecha_egreso"];  $fecha_nacimiento=$reg["fecha_nacimiento"];  $grado_inst=$reg["grado_inst"]; $fecha_ing=formato_ddmmaaaa($fecha_ingreso);  $fecha_ing_a=formato_ddmmaaaa($fecha_ing_adm);
  $fecha_c_sem=$fecha_ing;   $tiene_aus_pro=$reg["tiene_aus_pro"]; $motivo_ausencia=$reg["motivo_ausencia"];  $fecha_aus_desde=$reg["fecha_aus_desde"]; $fecha_aus_hasta=$reg["fecha_aus_hasta"]; $camb_fecha_exp='N'; $sueldo_integral=cambia_coma_numero($sueldo_integral);
  if(($status_trab=="VACACIONES")and($tiene_aus_pro=="S")){
    $temp_h=$fecha_hasta; $t_dia=substr($temp_h,0,2); if($t_dia=="31"){   $t_dia=substr($fecha_aus_hasta=$reg["fecha_aus_hasta"],8,2);  if($t_dia=="30"){ $fecha_aus_hasta=substr($fecha_aus_hasta=$reg["fecha_aus_hasta"],0,8)."31"; } }
  }  
  $fecha_h_sem=$fecha_hasta; 
  if((($status_trab=="VACACIONES")or($status_trab=="ACTIVO"))and($status_trab<>"REPOSO")and($tiene_aus_pro=="S")and($fecha_aus_hasta>$fechad)and($fecha_aus_hasta<=$fechah)){ $status_trab="ACTIVO"; $camb_fecha_exp='S'; $fecha_c_sem=formato_ddmmaaaa($fecha_aus_hasta); }
   $fecha_fin_c=formato_ddmmaaaa($reg["fecha_fin_con"]); $fecha_f_c=$reg["fecha_fin_con"]; $tipo_vacaciones=$reg["tipo_vacaciones"]; $bono_post_vac=0; $cod_post_vac="103"; $dias_post_vac=10;
  if((($fecha_egreso<$fechah)or($fecha_f_c<$fechah))){ $fecha_h_sem=formato_ddmmaaaa($fecha_egreso);}  
  if(($status_trab=="VACACIONES")and($tipo_vacaciones=="S")and($pago_vacaciones=="N")and(($proc_vac_nom=="S")or($Cod_Emp=="71"))){$sSQL="SELECT cod_empleado,fecha_reincorp,fecha_calculo_h FROM NOM024 Where (cod_empleado='$cod_empleado') and (fecha_reincorp<='$fechah')";$resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);if($filas>=1){$registro=pg_fetch_array($resultado); 
     $status_trab="ACTIVO";$pago_vacaciones="S";$fecha_pago_vac=$registro["fecha_reincorp"]; }} 
  if($cont_fijo=="F"){$continua=0;}else{ $numf1=fdate($fecha_fin_c);  $numf2=fdate($fecha_desde); if($numf1>$numf2){$continua=0;}else{$continua=1;  }}   $MNeto=0; $MAsignacion=0; $MDeduccion=0;
  //echo $cod_empleado."  ".$status_trab."  ".$motivo_ausencia."  ".$fecha_aus_hasta." ".$fechah." ".$tiene_aus_pro." ".$tipo_vacaciones." ".$continua,"<br>";
  if($continua==0){$cant_trab=$cant_trab+1;  $MNeto=0; $MAsignacion=0; $MDeduccion=0;   
   if(($status_trab=="ACTIVO")and($tiene_aus_pro=="S")and(($fecha_aus_hasta<$fechah)and($fecha_aus_hasta>$fechad))and($motivo_ausencia=="REPOSO")){$status_trab="REPOSO"; }
   if(($status_trab=="VACACIONES") And ($tipo_vacaciones=="S") and($tiene_aus_pro=="S") and ($fecha_aus_hasta>=$fechah)){ $tipo_vacaciones="N"; }
   //echo $cod_empleado."  ".$status_trab."  ".$motivo_ausencia."  ".$fecha_aus_hasta." ".$fechah." ".$tiene_aus_pro." ".$tipo_vacaciones." ".$continua,"<br>";
   if(($motivo_ausencia=="VACACIONES")and($status_trab=="ACTIVO") And ($tiene_aus_pro=="S") and ($fecha_aus_hasta==$fechah))
    { $tipo_vacaciones="N"; $status_trab="VACACIONES";  }   
   //echo $cod_empleado."  ".$motivo_ausencia." ".$pago_vacaciones." ".$proc_vac_nom."  ".$fecha_aus_hasta." ".$fechah." ".$fechad,"<br>";   
   if(($motivo_ausencia=="VACACIONES")and($pago_vacaciones=="S")and($proc_vac_nom=="S")and(($fecha_aus_hasta<=$fechah)and($fecha_aus_hasta>=$fechad))){
     $sSQL="SELECT cod_empleado,fecha_reincorp,fecha_calculo_h,monto_bono_vac,dias_bono_vac FROM NOM025 Where (cod_empleado='$cod_empleado') and (fecha_reincorp='$fecha_aus_hasta')"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
	 if($filas>=1){$registro=pg_fetch_array($resultado); $monto_bono_vac=$registro["monto_bono_vac"]; $dias_bono_vac=$registro["dias_bono_vac"]; $bono_post_vac=($monto_bono_vac/$dias_bono_vac)*$dias_post_vac; }
   }   
   //echo $cod_empleado."  ".$status_trab." B ".$fecha_aus_hasta." ".$fechah." ".$continua,"<br>";
   If(($status_trab=="ACTIVO") Or ($status_trab=="PERMISO RE")  Or ($status_trab=="REPOSO")  Or (($status_trab=="VACACIONES") And ($tipo_vacaciones=="S") And ($proc_vac_nom=="S"))){  $cambio_cantidad=0;
     $sSQL="SELECT ELIMINA_NOM065('$tipo_nomina')"; $resultado=pg_exec($conn,$sSQL);  $num_recibo=$num_recibo+1; $l=strlen($num_recibo); $srecibo="00000".$num_recibo; $srecibo=substr($srecibo,$l,5); $nd_s=0;
     $sqla="SELECT * FROM CONCEPTOS_ASIGNADOS WHERE (activo='SI') And (activoa='SI') And (tipo_nomina='$tipo_nomina') And (cod_empleado='$cod_empleado') order by cod_empleado,cod_orden,cod_concepto"; $resa=pg_query($sqla);
     //echo $sqla,"<br>";
	 while(($rega=pg_fetch_array($resa))and($error==0)){ $cod_concepto=$rega["cod_concepto"]; $den_concepto=$rega["denominacion"]; $cod_orden=$rega["cod_orden"]; $fecha_exp=$rega["fecha_exp"]; $fecha_ini=$rega["fecha_ini"]; $frecuenciaa=$rega["frecuenciaa"]; $frecuencia=$rega["frecuencia"]; $frec_valida="S";  $calculable=$rega["calculable"]; $status=$rega["status"]; $concepto_vac="N"; if($camb_fecha_exp=='S'){ $fecha_ini=$fecha_aus_hasta; }  $asig_ded_apo=$rega["asig_ded_apo"]; if($Cod_Emp=="71"){$den_concepto=substr($den_concepto,0,250);}else{ $observacion=''; //$observacion=$rega["observacion"]; 
	 $den_concepto=$den_concepto.' '.$observacion; $den_concepto=substr($den_concepto,0,250);}
      //echo $cod_empleado." ".$fecha_exp." ".$fechad." ".$status_trab." ".$cod_concepto." ".$frec_nom." ".$calculable,"<br>";
	  if($fechad<=$fecha_exp){ $continua=0; 
	   if(frecuencia_valida($frec_nom,$cal_frecuencia,$frecuencia,$u_semana)==false){$continua=1;} 	  
	   if(frecuencia_valida($frec_nom,$cal_frecuencia,$frecuenciaa,$u_semana)==false){$continua=1;} 
	   if(($proc_vac_nom=="S")and(($cod_concepto==$con_bon_vac)or($cod_concepto==$con_bon_vac_ant))){$continua=1; }  
	   if(((($status_trab=="ACTIVO") Or ($status_trab=="VACACIONES"))) and (($asig_ded_apo=="D")) and (($fecha_aus_hasta<$fechah)and($fecha_aus_hasta>$fechad))and($motivo_ausencia=="VACACIONES")and($tiene_aus_pro=="S")){ 
		 if(($motivo_ausencia=="VACACIONES")and($tiene_aus_pro=="S")){		 
		 }	   
	   }	
       //if(($cod_concepto=="502")or($cod_concepto=="030")){	   
	   //   echo $cod_empleado."  ".$status_trab." C ".$cod_concepto." ".$frec_nom." ".$frecuenciaa." ".$cal_frecuencia." ".$continua." ".$u_semana,"<br>";
	  // }
       if($Cod_Emp=="71"){ $asignacion=$rega["asignacion"]; $asig_ded_apo=$rega["asig_ded_apo"]; $fecha_p_vac=formato_ddmmaaaa($fecha_pago_vac);
	     $m1=FDate($fecha_p_vac); $m2=FDate($fecha_desde); $m3=FDate($fecha_hasta);
	     if(($cod_concepto<>"506")and($cod_concepto<>"538")and($asignacion=="NO")and($asig_ded_apo=="D") ){
		    //echo $fecha_pago_vac.' '.$pago_vacaciones.' '.$cod_concepto.' '.$m1.' '.$m2.' '.$m3,"<br>";
		    if(($pago_vacaciones=="S")and($m2<=$m1)and($m3>=$m1)){$continua=1;}
		 }
       }	
	   
       //echo $cod_empleado." ".$fecha_exp." ".$fechad." ".$status_trab." ".$cod_concepto." ".$continua,"<br>";	
	   $ndif=0;
       if($continua==0){$calculable=$rega["calculable"]; $asignacion=$rega["asignacion"]; $oculto=$rega["oculto"]; $acumula=$rega["acumula"]; $tipo_a=$rega["tipo_asigna"]; $asig_ded_apo=$rega["asig_ded_apo"]; $prestamo=$rega["prestamo"]; $int_cal_vac=substr($status,0,1); $cantidad=$rega["cantidad"]; $monto_orig=$rega["monto"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $cod_contable=$rega["cod_contable"];$cod_presup=$rega["cod_presup"]; $afecta_presup=$rega["afecta_presup"]; $cod_retencion=$rega["cod_retencion"]; if($fuente_emp<>""){$cod_contable=$fuente_emp;} $cod_grupo=$cod_contable;
        $valor=$cantidad*$monto_orig; $valore=0; $valorq=0; $valoru=0; $valorv=0; $valorw=0; $valorx=0; $valory=0; $valorz=0; if($fecha_egreso<$fecha_exp){$fecha_exp=$fecha_egreso;} 
		$temp_nroc_c=$rega["nro_cuotas_c"]+1; $temp_nroc=$rega["nro_cuotas"];
		if($prestamo=="S"){  //echo $cod_empleado." ".$cod_concepto." ".$temp_nroc_c." ".$temp_nroc." ".$valor." ".$monto_orig,"<br>"; 
		  if($temp_nroc_c<=$temp_nroc){$calculable="N"; $valore=$rega["monto_prestamo"]; $valorq=$rega["nro_cuotas"]; $valoru=$rega["nro_cuotas_c"]+1; $cantidad=0; $valor=$monto_orig;} 
		  else{  $calculable="N"; $valore=0; $valorq=0; $valoru=0; $cantidad=0; $valor=0;  }
		} 
		$cantidad=cambia_coma_numero($cantidad); $valor=cambia_coma_numero($valor);
		//if($cod_concepto=="001"){echo $cod_empleado." ".$fecha_ini." ".$fechad." ".$status_trab." ".$cod_concepto." ".$cantidad." ".$nd_s," ".$frec_nom,"<br>";}
		if(($fecha_ini>$fechad)and($fecha_ini<$fechah)and($status_trab<>"REPOSO")and($cod_concepto=="001")and($cantidad>0)and(($Cod_Emp<>"76")and($Cod_Emp<>"71"))){ $ndif=15; if($frec_nom=="S"){$ndif=7;} if($frec_nom=="M"){$ndif=30;}
          if(($fechah==$fecha_aus_hasta)and($tiene_aus_pro=="S")){$cantidad=0;}
		  else{$temp_h=$fecha_hasta; $t_dia=substr($temp_h,0,2); 
		  if(($t_dia=="31")or($t_dia=="28")or($t_dia=="29")){$temp_h="30".substr($temp_h,2,8);} $temp_i=formato_ddmmaaaa($fecha_ini);
		  $dias_dif=diferencia_dias($temp_i,$temp_h)+1;  $cantidad=($cantidad/$ndif)*$dias_dif;  if($temp_i==$temp_h){$cantidad=0;}  
		  }
		  $nd_s=$cantidad; 		$cambio_cantidad=1;  
		  //echo $temp_h." a ".$temp_i." ".$dias_dif,"<br>"; 
		  }
		if((($fecha_egreso<$fechah)or($fecha_f_c<$fechah))and($cont_fijo=="C")and($cod_concepto=="001")and($cantidad>0)){ $ndif=15; if($frec_nom=="S"){$ndif=7;} if($frec_nom=="M"){$ndif=30;}
          $temp_h=formato_ddmmaaaa($fecha_egreso); $t_dia=substr($temp_h,0,2); if($t_dia=="31"){$temp_h="30".substr($temp_h,2,8);} 		  
		  $temp_i=formato_ddmmaaaa($fecha_desde);  $dias_dif=diferencia_dias($fecha_desde,$temp_h)+1;  $cantidad=($cantidad/$ndif)*$dias_dif; if($cantidad>$ndif){$cantidad=$ndif;}		  
		  //echo $fecha_egreso." ".$fechah." ".$fecha_f_c." ".$temp_h." a ".$fecha_desde." ".$dias_dif,"<br>"; 
		 }
		//if($cod_concepto=="001"){ echo $cod_empleado." ".$status_trab." ".$cod_concepto." ".$cantidad." ".$ndif." ".$nd_s,"<br>";	}
		if(($status_trab=="REPOSO")and($cod_concepto=="001")and($cantidad>0)){		  
		  //echo $status_trab." ".$cod_concepto." ".$fecha_aus_desde." ".$fecha_aus_hasta,"<br>";		  
		  if(($fecha_aus_desde<$fechad)and($fecha_aus_hasta>=$fechah)){ $cantidad=0; $nd_s=0;} 		  
		  if(($fecha_aus_desde>=$fechad)and($fecha_aus_hasta>$fechah)){ $ndif=15; if($frec_nom=="S"){$ndif=7;} if($frec_nom=="M"){$ndif=30;}
		    $temp_h=formato_ddmmaaaa($fecha_aus_desde); $t_dia=substr($temp_h,0,2); if($t_dia=="31"){$temp_h="30".substr($temp_h,2,8);} $temp_i=formato_ddmmaaaa($fechad); 
		    $dias_dif=diferencia_dias($temp_i,$temp_h);  $cantidad=($cantidad/$ndif)*$dias_dif; $nd_s=$cantidad; } 		  
		  if(($fecha_aus_desde>=$fechad)and($fecha_aus_hasta<=$fechah)){ $ndif=15;
		    $temp_h=formato_ddmmaaaa($fecha_aus_desde); $temp_i=formato_ddmmaaaa($fecha_aus_hasta);
		    $dias_dif=diferencia_dias($temp_i,$temp_h)+2;  $cantidad=$ndif-$dias_dif; $nd_s=$cantidad;}		  
		  if(($fecha_aus_desde<=$fechad)and($fecha_aus_hasta<$fechah)){ $ndif=15; if($frec_nom=="S"){$ndif=7;} if($frec_nom=="M"){$ndif=30;}
		  $temp_h=formato_ddmmaaaa($fechad); $t_dia=substr($temp_h,0,2); if($t_dia=="31"){$temp_h="30".substr($temp_h,2,8);} $temp_i=formato_ddmmaaaa($fecha_aus_hasta); 
		  $dias_dif=diferencia_dias($temp_h,$temp_i);  $dias_dif=$dias_dif+1; $cantidad=$cantidad-$dias_dif; $nd_s=$cantidad; } 
		}
		if(($status_trab=="REPOSO")and($cod_concepto==$cod_concepto_reposo)){ $ndif=15; $cantidad=$ndif-$nd_s; }	
		if($cantidad==""){$cantidad=0;}			
		if(($bono_post_vac>0)and($cod_post_vac==$cod_concepto)){$cantidad=1; $valor=$bono_post_vac; $calculable="NO"; }	
		//if($redondear=="SI"){ if($asignacion=="NO"){$valor=RD($valor);}else{$valor=round($valor,0);} }
		$valor=cambia_coma_numero($valor); 
        if($redondear=="SI"){ $valor=RD($valor);}		
        if($frec_nom=="M"){ $tfrec=$frecuenciaa*1; $valorz=$valor;  $valorz=($valorz/2);  $valorz=Round($valorz, 2); 
		if($tfrec==1){$valorz=$valor;} if($tfrec==2){$valorz=0;}  $valorz=cambia_coma_numero($valorz); }	
		$sSQL="SELECT ACTUALIZA_NOM065(1,'$tipo_nomina','$cod_concepto','$den_concepto','$calculable','$asignacion','$acumula','$oculto','$tipo_a','$asig_ded_apo','$frec_valida','$prestamo','$concepto_vac','$int_cal_vac',$acumulado,$saldo,$valore,$valorq,$valoru,$valorv,$valorw,$valorx,$valory,$valorz,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$fecha_ini','$fecha_exp','$fechah',$frecuenciaa,'$cod_orden')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){ echo "Agrega Concepto ".$cod_concepto,"<br>" ;?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;}
        //if(($cod_concepto=="703")or($cod_concepto=="503")or($cod_concepto=="518")){			  echo $sSQL,"<br>";	
		//echo $cod_concepto." ".$asig_ded_apo." ".$valor,"<br>"; 	}
		if(($calculable=="NO")and($oculto=="NO")){if(($asig_ded_apo=="A")and($oculto=="NO")){$MAsignacion=$MAsignacion+$valor;} if(($asig_ded_apo=="D")and($oculto=="NO")){$MDeduccion=$MDeduccion+$valor;}}
      }}}
      
     if($proc_vac_nom=="S"){$fechaaux=$fechah; 
	  $sqla="SELECT nom023.cod_empleado,nom023.fecha_hasta,nom023.fecha_desde,nom023.fecha_p_hasta,nom023.cod_concepto,nom023.tipo_nomina,nom023.denominacion,nom023.asignacion,nom023.oculto,nom023.acumula,nom023.tipo_asigna,nom023.asig_ded_apo,nom023.prestamo,nom023.frecuencia,nom023.nro_semana,nom023.cantidad,nom023.monto_orig,nom023.monto,nom023.acumulado,nom023.saldo,nom023.cod_presup,nom023.cod_contable,nom023.afecta_presup,nom023.cod_retencion,nom022.fecha_calculo_d,nom022.fecha_calculo_h,nom022.calcula_nomina FROM nom023,nom022 where (nom023.cod_empleado=nom022.cod_empleado) and (nom023.cod_empleado='$cod_empleado') and (nom023.fecha_hasta>'$fechah') and (nom022.fecha_calculo_d>'$fechaaux')"; 
	  if($Cod_Emp=="58"){ $sqla="SELECT nom023.cod_empleado,nom023.fecha_hasta,nom023.fecha_desde,nom023.fecha_p_hasta,nom023.cod_concepto,nom023.tipo_nomina,nom023.denominacion,nom023.asignacion,nom023.oculto,nom023.acumula,nom023.tipo_asigna,nom023.asig_ded_apo,nom023.prestamo,nom023.frecuencia,nom023.nro_semana,nom023.cantidad,nom023.monto_orig,nom023.monto,nom023.acumulado,nom023.saldo,nom023.cod_presup,nom023.cod_contable,nom023.afecta_presup,nom023.cod_retencion,nom022.fecha_calculo_d,nom022.fecha_calculo_h,nom022.calcula_nomina FROM nom023,nom022 where (nom023.cod_empleado=nom022.cod_empleado) and (nom023.cod_empleado='$cod_empleado') and (nom023.fecha_desde<='$fechah')";}
	  $resa=pg_query($sqla);
      //echo $sqla,"<br>";
	  while(($rega=pg_fetch_array($resa))){ $cod_concepto=$rega["cod_concepto"]; $den_concepto=$rega["denominacion"]; $fecha_exp="9999-12-31";$fecha_ini=$fecha_ingreso; $frecuenciaa=$rega["frecuencia"]; $frec_valida="S"; $concepto_vac="S"; $int_cal_vac="S"; $calculable="NO"; $prestamo="N";  $valore=0; $valorq=0; $valoru=0; $valorv=0; $valorw=0; $valorx=0; $valory=0; $valorz=0;  $cantidad=cambia_coma_numero($cantidad);  $valor=cambia_coma_numero($valor);
        $asignacion=$rega["asignacion"]; $oculto=$rega["oculto"]; $acumula=$rega["acumula"]; $tipo_a=$rega["tipo_asigna"]; $asig_ded_apo=$rega["asig_ded_apo"]; $cantidad=$rega["cantidad"]; $monto_orig=$rega["monto_orig"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $cod_contable=$rega["cod_contable"]; if($fuente_emp<>""){$cod_contable=$fuente_emp;} $cod_presup=$rega["cod_presup"]; $afecta_presup=$rega["afecta_presup"]; $cod_retencion=$rega["cod_retencion"]; $valor=$rega["monto"]; $fechavh=$rega["fecha_hasta"];
        $calcula_nomina=$rega["calcula_nomina"]; if($calcula_nomina=="NO") { $concepto_vac="N"; } 
		$valor=cambia_coma_numero($valor); 
		if($redondear=="SI"){ $valor=RD($valor);}
		$sqla="DELETE FROM NOM065 where (codigo_mov='$tipo_nomina') and (cod_concepto='$cod_concepto')"; 
	    $resa=pg_exec($conn,$sqla);$merror=pg_errormessage($conn); $merror=substr($merror,0,70);if(!$resa){?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><? $merror=1;}
		$sSQL="SELECT ACTUALIZA_NOM065(1,'$tipo_nomina','$cod_concepto','$den_concepto','$calculable','$asignacion','$acumula','$oculto','$tipo_a','$asig_ded_apo','$frec_valida','$prestamo','$concepto_vac','$int_cal_vac',$acumulado,$saldo,$valore,$valorq,$valoru,$valorv,$valorw,$valorx,$valory,$valorz,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$fecha_ini','$fecha_exp','$fechah',$frecuenciaa,'$cod_concepto')"; 
		//echo $sSQL,"<br>";		
		$resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); $merror=substr($merror,0,70);if(!$resultado){?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><? $merror=1;}
     }}	 	  
     $sqla="SELECT * FROM NOM065 where (codigo_mov='$tipo_nomina') and (calculable='SI') and (concepto_vac='N') and (cod_concepto in (select cod_concepto from nom003 where tipo_nomina='$tipo_nomina')) order by cod_orden"; 
	 $sqla="SELECT * FROM NOM065 where (codigo_mov='$tipo_nomina') and (calculable='SI') and (concepto_vac='N') order by cod_orden";  $resa=pg_query($sqla);
     while(($rega=pg_fetch_array($resa))and($error==0)){ $cod_concepto=$rega["cod_concepto"]; $valor=$rega["valor"]; $cantidad=$rega["cantidad"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $monto_orig=$rega["monto_orig"]; $valore=$rega["valore"]; $valoru=$rega["valoru"]; $valorq=$rega["valorq"]; $valorw=$rega["valorw"]; $valorx=$rega["valorx"]; $valory=$rega["valory"]; $valorz=$rega["valorz"]; $cod_orden=$rega["cod_orden"]; $frecuenciaa=$rega["frecuencia"];
       $calculo_final_val=0;  $calculo1_val=0;  $calculo2_val=0;  $asig_ded_apo=$rega["asig_ded_apo"]; $fecha_ini=$rega["fecha_ini"]; $fecha_exp=$rega["fecha_exp"]; $oculto=$rega["oculto"];
       $sqlf="Select * from nom003 where tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto' Order BY tipo_nomina,cod_concepto,consecutivo";$resf=pg_query($sqlf);  $continuaf=0;
       while(($regf=pg_fetch_array($resf))and($error==0)and($continuaf==0)){ $consecutivo=$regf["consecutivo"];  $accion=$regf["accion"]; $rango_inicial=$regf["rango_inicial"]; $rango_final=$regf["rango_final"]; $calculo1=$regf["calculo1"]; $calculo2=$regf["calculo2"]; $calculofinal=$regf["calculofinal"];
        if(($valor>=$rango_inicial)and($valor<=$rango_final)){ 		
		 //if($cod_concepto=="703"){	 
		 //   echo $cod_concepto." ".$consecutivo." ".$accion." ".$calculo1,"<br>";
		 //   echo $cod_concepto." ".$consecutivo." ".$accion." ".$calculo2,"<br>";
		 //   echo $cod_concepto." ".$consecutivo." ".$accion." ".$calculofinal,"<br>";
		 //}
		 if($accion=="F"){ $valor=calcular_formulas(); $continuaf=1; }
         else{ if($accion!= "F"){
           switch($accion){
             Case "T":$valor=calcular_formulas();  break;
             Case "A":$acumulado=calcular_formulas(); break;
             Case "S":$saldo=calcular_formulas(); break;
             Case "M":$monto_orig=calcular_formulas(); break;
             Case "C":$cantidad=calcular_formulas(); break;
			 Case "E":$valore=calcular_formulas(); break;    
             Case "U":$valoru=calcular_formulas(); break;
             Case "Q":$valorq=calcular_formulas(); break;
             Case "W":$valorw=calcular_formulas(); break;
             Case "X":$valorx=calcular_formulas(); break;
             Case "Y":$valory=calcular_formulas(); break;
             Case "Z":$valorz=calcular_formulas(); break;
           }
         }}
		 if($valor<0){$valor=0;}
		 //if(($cod_concepto=="703")or($cod_concepto=="503")or($cod_concepto=="518")){	 echo $cod_empleado." ".$cod_concepto." ".$consecutivo." ".$accion." ".$valor,"<br>";  }
       } }
	   $entra=0; //if(($valor>0)and($asig_ded_apo=="A")){$entra=1;}  
	   if($Cod_Emp=="02"){   //contraloria miranda
	     if(($asig_ded_apo=="A")and($valor>0)){$entra=1;}
	     //esto es para que no haga regla de tres a la prima de antiguedad
	     if($cod_concepto=="006"){ $entra=0;  }
	     if(($cod_concepto=="001")and($cambio_cantidad==1)){ $entra=0;  }
		 if(($valor>0)and($monto_orig>0)and($asig_ded_apo=="D")){$entra=1;}	
		 if(($error==0)and($oculto=="NO")and($entra==1)and($fecha_ini<=$fechah)){ $ndif=15; if($frec_nom=="S"){$ndif=7;} if($frec_nom=="M"){$ndif=30;} $dias_dif=$ndif;
           $temp_e=formato_ddmmaaaa($fecha_exp); $temp_i=formato_ddmmaaaa($fecha_ini); $t_dia=substr($temp_e,0,2); if(($t_dia=="31")or($t_dia=="28")or($t_dia=="29")){$temp_e="30".substr($temp_e,2,8);}
		   $temp_h=$fecha_hasta; $t_dia=substr($temp_h,0,2); if(($t_dia=="31")or($t_dia=="28")or($t_dia=="29")){$temp_h="30".substr($temp_h,2,8);}If (($fecha_exp<$fechah) and ($fecha_ini<$fechah)){$dias_dif=diferencia_dias($fecha_desde,$temp_e)+1; $valor=($valor/$ndif)*$dias_dif; }
           If(($fecha_exp>$fechah) and ($fecha_ini>$fechad)){$dias_dif=diferencia_dias($temp_i,$temp_h)+1;  $valor=($valor/$ndif)*$dias_dif; }
           If(($fecha_exp<$fechah) and ($fecha_ini>$fechad)){$dias_dif=diferencia_dias($temp_i,$temp_e)+1; $valor=($valor/$ndif)*$dias_dif;}
           if(($cantidad==$ndif)and($dias_dif<>$ndif)){ $cantidad=$dias_dif; }
		 }
	   } 
	   else{
		   if(($valor>0)and($monto_orig>0)and($asig_ded_apo=="D")){$entra=1;}	   
		   if(($asig_ded_apo=="A")and($valor>0)and($cantidad==0)){$entra=1;} 
		  // if(($cod_concepto=="001")or($cod_concepto=="006")){echo $cod_concepto." Cantidad: ".$cantidad." Monto: ".$valor." ".$entra,"<br>";  }
		   if($Cod_Emp=="71"){ if(($cod_concepto=="094")or($cod_concepto=="095")or($cod_concepto=="036")){ $entra=0; } }
		   if(($error==0)and($oculto=="NO")and($cantidad==0)and($entra==1)and($fecha_ini<=$fechah)){ $ndif=15; if($frec_nom=="S"){$ndif=7;} if($frec_nom=="M"){$ndif=30;}
			 $temp_e=formato_ddmmaaaa($fecha_exp); $temp_i=formato_ddmmaaaa($fecha_ini); $t_dia=substr($temp_e,0,2); if(($t_dia=="31")or($t_dia=="28")or($t_dia=="29")){$temp_e="30".substr($temp_e,2,8);}
			 $temp_h=$fecha_hasta; $t_dia=substr($temp_h,0,2); if(($t_dia=="31")or($t_dia=="28")or($t_dia=="29")){$temp_h="30".substr($temp_h,2,8);}If (($fecha_exp<$fechah) and ($fecha_ini<$fechah)){$dias_dif=diferencia_dias($fecha_desde,$temp_e)+1; $valor=($valor/$ndif)*$dias_dif; }
             If (($fecha_exp<$fechah) and ($fecha_ini<$fechah)){$dias_dif=diferencia_dias($fecha_desde,$temp_e)+1; $valor=($valor/$ndif)*$dias_dif; }
			 If (($fecha_exp>$fechah) and ($fecha_ini>$fechad)){$dias_dif=diferencia_dias($temp_i,$temp_h)+1;  $valor=($valor/$ndif)*$dias_dif; }
			 If (($fecha_exp<$fechah) and ($fecha_ini>$fechad)){$dias_dif=diferencia_dias($temp_i,$temp_e)+1; $valor=($valor/$ndif)*$dias_dif;}
		   }
	   }
       if($error==0){$cantidad=cambia_coma_numero($cantidad); $valor=cambia_coma_numero($valor); 
	   //echo $cod_concepto." ".$asig_ded_apo." ".$valor,"<br>";
	   if($redondear=="SI"){ $valor=RD($valor);}
	   //echo $cod_concepto." ".$asig_ded_apo." ".$valor,"<br>";  
	   if(($asig_ded_apo=="A")and($oculto=="NO")){$MAsignacion=$MAsignacion+$valor;} if(($asig_ded_apo=="D")and($oculto=="NO")){$MDeduccion=$MDeduccion+$valor;}
       if($frec_nom=="M"){ $tfrec=$frecuenciaa*1; $valorz=$valor;  $valorz=($valorz/2); $valorz=Round($valorz,2);   if($tfrec==1){$valorz=$valor;} if($tfrec==2){$valorz=0;}   }	$valorz=cambia_coma_numero($valorz);	
	   $valorx=cambia_coma_numero($valorx); $valory=cambia_coma_numero($valory); $valoru=cambia_coma_numero($valoru); $valore=cambia_coma_numero($valore); $valorq=cambia_coma_numero($valorq);  $valorw=cambia_coma_numero($valorw); $valorv=cambia_coma_numero($valorv); 
	   $sSQL="SELECT ACTUALIZA_NOM065(2,'$tipo_nomina','$cod_concepto','','S','S','S','N','A','A','S','N','N','N',$acumulado,$saldo,$valore,$valorq,$valoru,$valorv,$valorw,$valorx,$valory,$valorz,$cantidad,$valor,$monto_orig,'','','','','$fechah','$fechah','$fechah',0,'$cod_orden')";  $resultado=pg_exec($conn,$sSQL); }
       //if($cod_concepto=="208"){ echo $sSQL,"<br>";  }
	 }
     
	 /* */
	 $sSQL="SELECT AGREGA_NOM017('$tipo_nomina','$fechah','$cod_empleado','$srecibo','$fechad','$fechah','$fechad','N',1,'$fechah','$des_nomina','$tipo_nomina','$desc_grupo','$nombre','$cedula','$fecha_ingreso','$status_trab',$num_semanas,'$cod_cargo','$des_cargo',$sueldo,$prima,$compensacion,$sueldo_integral,$otros,'$cod_departam','$des_departam','$cod_tipo_personal','$des_tipo_personal','$tipo_pago','$cta_empleado','$cta_empresa','$nombre_banco','$cod_ubicacion','$status_calculo','$des_ubicacion')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){ echo "Agrega Calculo ".$cod_empleado,"<br>"; echo $sSQL,"<br>"; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?  $error=1;}
     
	 //echo $sSQL,"<br>";
	}else{ $num_recibo=$num_recibo+1; $l=strlen($num_recibo); $srecibo="00000".$num_recibo; $srecibo=substr($srecibo,$l,5);
	  if($status_trab=="VACACIONES"){$den_concepto="VACACIONES DEL:".formato_ddmmaaaa($fecha_aus_desde)." AL:".formato_ddmmaaaa($fecha_aus_hasta);	$concepto_vac="S";}else{$den_concepto="PERMISO NO REMUNERADO";$concepto_vac="N";} 	  
	  
	  if($status_trab=="VACANTE"){$den_concepto="VACANTE";$concepto_vac="N";} 
	  $sSQL="SELECT INCLUYE_NOM017('$tipo_nomina','$fechah','$cod_empleado','VVV','$srecibo','$fechad','$fechah','$fechad','N',1,'$fechah','$des_nomina','$tipo_nomina','$desc_grupo','$nombre','$cedula','$fecha_ingreso','$status_trab','$den_concepto','SI','NO','O','A','N','$concepto_vac',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,$num_semanas,'$cod_cargo','$des_cargo',$sueldo,$prima,$compensacion,$sueldo_integral,$otros,'$cod_departam','$des_departam','$cod_tipo_personal','$des_tipo_personal','$cod_categoria','','NO','$tipo_pago','$cta_empleado','$cta_empresa','$nombre_banco','NO','000','$cod_ubicacion','$status_calculo','$des_ubicacion')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} 
	  
	  
	  if($status_trab=="VACACIONES"){
	    if(($motivo_ausencia=="VACACIONES")and($pago_vacaciones=="S")and($proc_vac_nom=="S")and($fecha_aus_hasta=$fechah)){
				$sSQL="SELECT cod_empleado,fecha_reincorp,fecha_calculo_h,monto_bono_vac,dias_bono_vac FROM NOM025 Where (cod_empleado='$cod_empleado') and (fecha_reincorp='$fecha_aus_hasta')"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
				if($filas>=1){$registro=pg_fetch_array($resultado); $monto_bono_vac=$registro["monto_bono_vac"]; $dias_bono_vac=$registro["dias_bono_vac"]; $bono_post_vac=($monto_bono_vac/$dias_bono_vac)*$dias_post_vac; }
			}   
	    $sSQL="SELECT ELIMINA_NOM065('$tipo_nomina')"; $resultado=pg_exec($conn,$sSQL);   $nd_s=0;
        $sqla="SELECT * FROM CONCEPTOS_ASIGNADOS WHERE (activo='SI') And (activoa='SI') and (substring(status,2,1)='S') And (tipo_nomina='$tipo_nomina') And (cod_empleado='$cod_empleado') order by cod_empleado,cod_orden,cod_concepto"; $resa=pg_query($sqla);
        while(($rega=pg_fetch_array($resa))and($error==0)){ $cod_concepto=$rega["cod_concepto"]; $den_concepto=$rega["denominacion"]; $cod_orden=$rega["cod_orden"]; $fecha_exp=$rega["fecha_exp"]; $fecha_ini=$rega["fecha_ini"]; $frecuenciaa=$rega["frecuenciaa"]; $frecuencia=$rega["frecuencia"]; $frec_valida="S";  $calculable=$rega["calculable"]; $status=$rega["status"]; $concepto_vac="N"; if($camb_fecha_exp=='S'){ $fecha_ini=$fecha_aus_hasta; }  $asig_ded_apo=$rega["asig_ded_apo"];
	      if(($fechad<=$fecha_exp)and(substr($status,1,2)=="S")){ $continua=0;  if(frecuencia_valida($frec_nom,$cal_frecuencia,$frecuencia,$u_semana)==false){$continua=1;} if(frecuencia_valida($frec_nom,$cal_frecuencia,$frecuenciaa,$u_semana)==false){$continua=1;} if(($proc_vac_nom=="S")and(($cod_concepto==$con_bon_vac)or($cod_concepto==$con_bon_vac_ant))){$continua=1; }
		   if($continua==0){$calculable=$rega["calculable"]; $asignacion=$rega["asignacion"]; $oculto=$rega["oculto"]; $acumula=$rega["acumula"]; $tipo_a=$rega["tipo_asigna"]; $asig_ded_apo=$rega["asig_ded_apo"]; $prestamo=$rega["prestamo"]; $int_cal_vac=substr($status,0,1); $cantidad=$rega["cantidad"]; $monto_orig=$rega["monto"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $cod_contable=$rega["cod_contable"];$cod_presup=$rega["cod_presup"]; $afecta_presup=$rega["afecta_presup"]; $cod_retencion=$rega["cod_retencion"]; $cod_grupo=$cod_contable;
			$valor=$cantidad*$monto_orig; $valore=0; $valorq=0; $valoru=0; $valorv=0; $valorw=0; $valorx=0; $valory=0; $valorz=0; if($fecha_egreso<$fecha_exp){$fecha_exp=$fecha_egreso;} if(($prestamo=="S")and(($rega["nro_cuotas_c"]+1)<$rega["nro_cuotas"])){$calculable="N"; $valore=$rega["monto_prestamo"]; $valorq=$rega["nro_cuotas"]; $valoru=$rega["nro_cuotas_c"]+1; } $cantidad=cambia_coma_numero($cantidad); $valor=cambia_coma_numero($valor);
			$valor=cambia_coma_numero($valor); 
			if($redondear=="SI"){ $valor=RD($valor);}
			if(($bono_post_vac>0)and($cod_post_vac==$cod_concepto)){$cantidad=1; $valor=$bono_post_vac; $calculable="NO"; }	
			$sSQL="SELECT ACTUALIZA_NOM065(1,'$tipo_nomina','$cod_concepto','$den_concepto','$calculable','$asignacion','$acumula','$oculto','$tipo_a','$asig_ded_apo','$frec_valida','$prestamo','$concepto_vac','$int_cal_vac',$acumulado,$saldo,$valore,$valorq,$valoru,$valorv,$valorw,$valorx,$valory,$valorz,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$fecha_ini','$fecha_exp','$fechah',$frecuenciaa,'$cod_orden')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){ echo "Agrega Concepto ".$cod_concepto,"<br>" ;?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;}
            //echo $sSQL,"<br>";			
			if($calculable="NO"){if($asig_ded_apo=="A"){$MAsignacion=$MAsignacion+$valor;} if($asig_ded_apo=="D"){$MDeduccion=$MDeduccion+$valor;}}
		  }}
		}
		//echo $sqla,"<br>";
		$sqla="SELECT * FROM NOM065 where (codigo_mov='$tipo_nomina') and (calculable='SI') and (concepto_vac='N') and (cod_concepto in (select cod_concepto from nom003 where tipo_nomina='$tipo_nomina')) order by cod_orden"; $resa=pg_query($sqla);
        //echo $sqla,"<br>";
		while(($rega=pg_fetch_array($resa))and($error==0)){ $cod_concepto=$rega["cod_concepto"]; $valor=$rega["valor"]; $cantidad=$rega["cantidad"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $monto_orig=$rega["monto_orig"]; $valore=$rega["valore"]; $valoru=$rega["valoru"]; $valorq=$rega["valorq"]; $valorw=$rega["valorw"]; $valorx=$rega["valorx"]; $valory=$rega["valory"]; $valorz=$rega["valorz"]; $cod_orden=$rega["cod_orden"]; $frecuenciaa=$rega["frecuencia"];
		   $calculo_final_val=0;  $calculo1_val=0;  $calculo2_val=0;  $asig_ded_apo=$rega["asig_ded_apo"]; $fecha_ini=$rega["fecha_ini"]; $fecha_exp=$rega["fecha_exp"]; $oculto=$rega["oculto"];
		   $sqlf="Select * from nom003 where tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto' Order BY tipo_nomina,cod_concepto,consecutivo";$resf=pg_query($sqlf);  $continuaf=0;
          while(($regf=pg_fetch_array($resf))and($error==0)and($continuaf==0)){ $consecutivo=$regf["consecutivo"];  $accion=$regf["accion"]; $rango_inicial=$regf["rango_inicial"]; $rango_final=$regf["rango_final"]; $calculo1=$regf["calculo1"]; $calculo2=$regf["calculo2"]; $calculofinal=$regf["calculofinal"];
			if(($valor>=$rango_inicial)and($valor<=$rango_final)){ if($accion=="F"){ $valor=calcular_formulas(); $continuaf=1; }
			 else{ if($accion!= "F"){
			   switch($accion){
				 Case "T":
				  $valor=calcular_formulas();  break;
				 Case "A":
				  $acumulado=calcular_formulas(); break;
				 Case "S":
				  $saldo=calcular_formulas(); break;
				 Case "M":
				  $monto_orig=calcular_formulas(); break;
				 Case "C":
				  $cantidad=calcular_formulas(); break;
				 Case "U":
				  $valoru=calcular_formulas(); break;
				 Case "Q":
				  $valorq=calcular_formulas(); break;
				 Case "W":
				  $valorw=calcular_formulas(); break;
				 Case "X":
				  $valorx=calcular_formulas(); break;
				 Case "Y":
				  $valory=calcular_formulas(); break;
				 Case "Z":
				  $valorz=calcular_formulas(); break;
			   }
			 }}
		   } }
		   $cantidad=cambia_coma_numero($cantidad); $valor=cambia_coma_numero($valor); 
		   if($redondear=="SI"){ $valor=RD($valor);}
		   if($asig_ded_apo=="A"){$MAsignacion=$MAsignacion+$valor;} if($asig_ded_apo=="D"){$MDeduccion=$MDeduccion+$valor;}
		   $valorx=cambia_coma_numero($valorx); $valory=cambia_coma_numero($valory); $valoru=cambia_coma_numero($valoru); $valore=cambia_coma_numero($valore); $valorq=cambia_coma_numero($valorq);  $valorw=cambia_coma_numero($valorw); $valorv=cambia_coma_numero($valorv);
	       $sSQL="SELECT ACTUALIZA_NOM065(2,'$tipo_nomina','$cod_concepto','','S','S','S','N','A','A','S','N','N','N',$acumulado,$saldo,$valore,$valorq,$valoru,$valorv,$valorw,$valorx,$valory,$valorz,$cantidad,$valor,$monto_orig,'','','','','$fechah','$fechah','$fechah',0,'$cod_orden')";   $resultado=pg_exec($conn,$sSQL);
		} 
		/**/
		$sSQL="SELECT AGREGA_NOM017('$tipo_nomina','$fechah','$cod_empleado','$srecibo','$fechad','$fechah','$fechad','N',1,'$fechah','$des_nomina','$tipo_nomina','$desc_grupo','$nombre','$cedula','$fecha_ingreso','$status_trab',$num_semanas,'$cod_cargo','$des_cargo',$sueldo,$prima,$compensacion,$sueldo_integral,$otros,'$cod_departam','$des_departam','$cod_tipo_personal','$des_tipo_personal','$tipo_pago','$cta_empleado','$cta_empresa','$nombre_banco','$cod_ubicacion','$status_calculo','$des_ubicacion')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){ echo "Agrega Calculo ".$cod_empleado,"<br>"; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?  $error=1;}
        
		//echo $sSQL,"<br>";
	  }
    }$MNeto=$MAsignacion-$MDeduccion;  if($MNeto<0){ ?><script language="JavaScript">muestra('ERROR EN TRABAJADOR:<? echo $cod_empleado; ?> MONTO ES NEGATIVO:<? echo $MNeto; ?> \n ASIGNACIONES:<? echo $MAsignacion; ?> DEDUCCIONES:<? echo $MDeduccion; ?> \n POR FAVOR VERIFIQUE');</script><?}
 } $porcentaje = $cant_trab * 100 / $ValorTotal;  echo "<script>callprogress(".round($porcentaje).")</script>";  flush(); if($php_os=="WINNT"){$nob=0;}else{ob_flush();}
  }
 if($g_orden_pago=="S"){ $sSQL="SELECT cod_presup,monto,cod_concepto,cod_empleado,cod_contable  FROM nom017 where (afecta_presup='SI') and (asignacion='SI') and (oculto='NO') and (tipo_nomina='$tipo_nomina') and (tp_calculo='N') and (cod_presup not in (select cod_presup from pre001)) order by cod_presup"; $res=pg_query($sSQL);
/*
   while($reg=pg_fetch_array($res)){ $cod_presup=$reg["cod_presup"]; $cod_fuente="00"; $cod_fuente=$reg["cod_contable"];  $cod_concepto=$reg["cod_concepto"]; $cod_empleado=$reg["cod_empleado"]; $error=0;
    ?><script language="JavaScript">muestra('CODIGO PRESUPUESTARIO:<? echo $cod_presup; ?> FUENTE:<? echo $cod_fuente; ?> \n TRABAJADOR:<? echo $cod_empleado; ?> CONCEPTO:<? echo $cod_concepto; ?> \n NO EXISTE EN PRESUPUESTO');</script><? }
*/	
   $sSQL="SELECT cod_presup,cod_contable,sum(monto) as monto FROM nom017 where (afecta_presup='SI') and (oculto='NO') and (asignacion='SI') and (tipo_nomina='$tipo_nomina') and (tp_calculo='N') group by cod_presup,cod_contable order by cod_presup,cod_contable"; $res=pg_query($sSQL);
   while(($reg=pg_fetch_array($res))and($error==0)){ $cod_presup=$reg["cod_presup"]; $monto=$reg["monto"]; $cod_fuente="00"; $cod_fuente=$reg["cod_contable"];
    $sqlp = "SELECT denominacion,disponible,diferido FROM PRE001 WHERE (Cod_Presup='$cod_presup') and (cod_fuente='$cod_fuente')"; $resp=pg_query($sqlp); $filas=pg_num_rows($resp);
    if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO <? echo $cod_presup; ?> NO EXISTE EN DISPONIBILIDAD');</script><? }
    else{ $regp=pg_fetch_array($resp); $disponible=$regp["disponible"]; if($disponible<$monto){ echo "Codigo: ".$cod_presup." Requiere: ".$monto." Disponible: ".$disponible,"<br>";
        ?><script language="JavaScript">muestra('NO EXISTE DISPONIBILIDAD PARA EL CODIGO PRESUPUESTARIO:<? echo $cod_presup; ?> FUENTE:<? echo $cod_fuente; ?> \n DISPONIBILIDAD ACTUAL:<? echo $disponible; ?> MONTO REQUERIDO:<? echo $monto; ?> \n POR FAVOR VERIFIQUE');</script><?}}
   }}
 $sSQL= "SELECT cod_concepto,denominacion,cod_aporte FROM NOM002 where (cod_aporte<>'000') and (cod_aporte<>'') and (tipo_nomina='$tipo_nomina')  and (asig_ded_apo='D') and cod_concepto in (select cod_concepto from nom017 where (tipo_nomina='$tipo_nomina') and (tp_calculo='N'))";$res=pg_query($sSQL);
 while(($reg=pg_fetch_array($res))and($error==0)){ $t_reten=0; $t_aporte=0; $denominacion=$reg["denominacion"];  $cod_reten=$reg["cod_concepto"]; $cod_aporte=$reg["cod_aporte"];
    $sqlp = "select count(*) as cantidad from nom017 where (tipo_nomina='$tipo_nomina') and (tp_calculo='N') and (cod_concepto='$cod_reten')"; $resp=pg_query($sqlp); $filas=pg_num_rows($resp); if($filas>0){ $regp=pg_fetch_array($resp); $t_reten=$regp["cantidad"]; }
    $sqlp = "select count(*) as cantidad from nom017 where (tipo_nomina='$tipo_nomina') and (tp_calculo='N') and (cod_concepto='$cod_aporte')"; $resp=pg_query($sqlp); $filas=pg_num_rows($resp); if($filas>0){ $regp=pg_fetch_array($resp); $t_aporte=$regp["cantidad"]; }
    if($t_reten<>$t_aporte){ ?> <script language="JavaScript"> muestra('EXISTE UNA DIFERENCIA ENTRE LA RETENCION Y EL APORTE DEL CONCEPTO <? echo $cod_reten.' '.$denominacion; ?> POR FAVOR VERIFIQUE');</script><?}
    //$sql="SELECT AGREGA_NOM017_APORTE('$tipo_nomina','$cod_reten','$cod_aporte')"; $resultado=pg_exec($conn,$sql);
 }
} $sSQL="SELECT ELIMINA_NOM065('$tipo_nomina')"; $resultado=pg_exec($conn,$sSQL); 
$hora2=time(); $dif=$hora2-$hora1; echo " Tiempo en segundos: ".$dif,"<br>";
pg_close();if($error==0){?><script language="JavaScript">muestra('FINALIZO CALCULO, CANTIDAD: '+'<? echo $cant_trab; ?>');
//document.location ='<? echo $url; ?>';
</script> <?}?>
</form>
</body>
</html>
