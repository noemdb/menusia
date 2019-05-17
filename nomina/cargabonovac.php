<?include ("../class/conect.php"); include ("../class/funciones.php"); include ("../class/configura.inc"); $fecha_hoy=asigna_fecha_hoy(); $eofline="@"; $php_os=PHP_OS;
$tipo_nomina=$_GET["tipo_nomina"]; $fecha_desde=$_GET["fdesde"];  $fecha_hasta=$_GET["fhasta"]; $conc_bono=$_GET["conc_bono"]; 
$num_semana=1;   $parametro="T"; $u_semana="N"; $pcod_trab="";
$cod_empleado=""; $fecha_pago_vac=$fecha_hoy; $pago_vacaciones="N"; $num_recibo=0; $redondear="N"; $bloqueada="N"; 
$calculo1_val=0; $calculo2_val=0; $calculo_final_val=0; $a_dic=""; $pos=0; $formula=""; $opr=""; $cual=""; $Ch=""; $EXY="";  $valor=0; $fecha_nacimiento="";
include ("cal_conceptos.php"); 
?>
<?php
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); //echo "ESPERE POR FAVOR CARGANDO BONO VACACIONAL....","<br>";
$mensaje="PROCESO TERMINO SATISFACTORIAMENTE";

$hora1=time(); $cod_grupo=""; $cod_concepto_reposo="000"; $cant_trab=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}else{ $Nom_Emp=busca_conf(); }
$campo502="NNNNNNNNNNNNNNNNNNN"; $error=0;  $Monto_Sueldo_SSO=0;
$sql="Select campo502,campo535  from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $Monto_Sueldo_SSO=$registro["campo535"];} $proc_vac_nom=substr($campo502,5,1);
if($error==0){$sSQL="Select * from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA NO EXISTE');</script><?}else{$registro=pg_fetch_array($resultado); $g_orden_pago=$registro["g_orden_pago"]; $frec_nom=$registro["frecuencia"]; $des_nomina=$registro["descripcion"]; $desc_grupo=$registro["desc_grupo"]; $redondear=$registro["redondear"]; $bloqueada=$registro["bloqueada"];$con_cal_vac=$registro["con_cal_vac"];$con_bon_vac=$registro["con_bon_vac"];$con_cal_vac=$registro["con_cal_vac"]; $con_bon_vac_ant=$registro["con_bon_vac"];  $cod_grupo=$registro["cod_grupo"]; if(trim($cod_grupo)==""){$cod_grupo="00";} } }
if($error==0){if($bloqueada=='S'){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA ESTA BLOQUEADA');</script><?}}
if($error==0){$cal_frecuencia=1; $dia=substr($fecha_hasta,0,2); if($frec_nom=="Q"){if($dia==15){$cal_frecuencia=1;}else{$cal_frecuencia=2;} }   if($frec_nom=="S"){ if($u_semana=="S"){$cal_frecuencia=0;} }  }
if($error==0){if(checkData($fecha_desde)=='1'){$fechad=formato_aaaammdd($fecha_desde);}else{$error=1;?><script language="JavaScript">muestra('FECHA DESDE NO ES VALIDA');</script><?}}
if($error==0){if(checkData($fecha_hasta)=='1'){$fechah=formato_aaaammdd($fecha_hasta);}else{$error=1;?><script language="JavaScript">muestra('FECHA HASTA NO ES VALIDA');</script><?}}
//$error=0;
//echo $sSQL,"<br>";
if($error==0){if($parametro=="T"){$sSQL="SELECT ELIM_CAL_NOMINA('$tipo_nomina','N')"; $resultado=pg_exec($conn,$sSQL); $sql="select * from CAL_NOMINA where (tipo_nomina='$tipo_nomina') and (fecha_ingreso<='$fechah') and (fecha_egreso>='$fechad') order by tipo_nomina,cod_departam,cod_cargo,cod_empleado"; }
 else{$sSQL="SELECT ELIM_CAL_NOM_TRAB('$tipo_nomina','N','$pcod_trab')"; $resultado=pg_exec($conn,$sSQL); $sql="select * from CAL_NOMINA where (tipo_nomina='$tipo_nomina') and (cod_empleado='$pcod_trab') and (fecha_ingreso<='$fechah') and (fecha_egreso>='$fechad') order by tipo_nomina,cod_departam,cod_cargo,cod_empleado"; } $res=pg_query($sql);  
 //echo $sql,"<br>";
 while($reg=pg_fetch_array($res)){ $cod_empleado=$reg["cod_empleado"]; $status_trab=$reg["status"]; $pago_vacaciones=$reg["pago_vaciones"]; $fecha_pago_vac=$reg["fecha_pago"];  $cedula=$reg["cedula"]; $nacionalidad=$reg["nacionalidad"]; $nombre=$reg["nombre"]; $fecha_ingreso=$reg["fecha_ingreso"]; $cod_cargo=$reg["cod_cargo"]; $cod_departam=$reg["cod_departam"]; $cod_tipo_personal=$reg["cod_tipo_personal"]; $fecha_ing_adm=$reg["fecha_ing_adm"];  if($Cod_Emp=="71"){$fuente_emp="";}else{$fuente_emp=$reg["campo_str1"];}
  $des_cargo=$reg["denominacion"]; $des_departam=$reg["descripcion_dep"]; $des_tipo_personal=$reg["des_tipo_personal"]; $sueldo=$reg["sueldo"]; $compensacion=$reg["compensacion"]; $prima=$reg["prima"]; $sueldo_integral=$reg["sueldo"]+$reg["prima"]+$reg["compensacion"]; $otros=$reg["otros"]; $tipo_pago=$reg["tipo_pago"];  $cta_empleado=$reg["cta_empleado"];  $cta_empresa=$reg["cta_empresa"]; $cod_banco=$reg["cod_banco"]; $nombre_banco=$reg["nombre_banco"]; $cod_ubicacion=$reg["codigo_ubicacion"]; $sexo=$reg["sexo"];
  $edo_civil=substr($reg["edo_civil"],0,1); if($reg["edo_civil"]=="CONCUBINO"){$edo_civil="U";} $tipo_cuenta=substr($reg["tipo_cuenta"],0,1); if($tipo_cuenta==""){$tipo_cuenta="N";} $cont_fijo=$reg["cont_fijo"]; $status_calculo=$reg["cont_fijo"].substr($nacionalidad,0,1).$tipo_cuenta.substr($reg["sexo"],0,1).$edo_civil;  $des_ubicacion=$reg["descripcion_ubi"]; $fecha_egreso=$reg["fecha_egreso"];  $fecha_nacimiento=$reg["fecha_nacimiento"];  $grado_inst=$reg["grado_inst"]; $fecha_ing=formato_ddmmaaaa($fecha_ingreso);  $fecha_ing_a=formato_ddmmaaaa($fecha_ing_adm);
  $fecha_c_sem=$fecha_ing;   $tiene_aus_pro=$reg["tiene_aus_pro"]; $motivo_ausencia=$reg["motivo_ausencia"];  $fecha_aus_desde=$reg["fecha_aus_desde"]; $fecha_aus_hasta=$reg["fecha_aus_hasta"]; $camb_fecha_exp='N'; $sueldo_integral=cambia_coma_numero($sueldo_integral);
  $fecha1=$fecha_ing; $fecha1=substr($fecha1,0,6).substr($fecha_hasta,6,4);  $tfecha_h=colocar_udiames($fecha_hasta); $tfecha_h=$fecha_hasta;
  $m1=FDate($fecha1); $m2=FDate($fecha_desde); $m3=FDate($tfecha_h); $a=diferencia_años($fecha_ing,$tfecha_h); $f=0; $continua=1;
  if($a>0){if(($m1>=$m2)and($m1<=$m3)){$f=$a; $continua=0;} }
  
  if($continua==0){$cant_trab=$cant_trab+1;  $MNeto=0; $MAsignacion=0; $MDeduccion=0; 
   //echo $cod_empleado." ".$fecha_ing." A1 ".$tfecha_h." ".$a." ".$f,"<br>";
   If((($status_trab=="ACTIVO") Or ($status_trab=="VACACIONES")) And ($continua==0)){  
     $sSQL="SELECT ELIMINA_NOM065('$tipo_nomina')"; $resultado=pg_exec($conn,$sSQL);  $num_recibo=$num_recibo+1; $l=strlen($num_recibo); $srecibo="00000".$num_recibo; $srecibo=substr($srecibo,$l,5); $nd_s=0;
     $sqla="SELECT * FROM CONCEPTOS_ASIGNADOS WHERE (activo='SI') And (activoa='SI') And (tipo_nomina='$tipo_nomina') And (cod_empleado='$cod_empleado')  order by cod_empleado,cod_orden,cod_concepto"; $resa=pg_query($sqla);
     //echo $sqla." ".$error,"<br>";
	 while(($rega=pg_fetch_array($resa))and($error==0)){ $cod_concepto=$rega["cod_concepto"]; $den_concepto=$rega["denominacion"]; $cod_orden=$rega["cod_orden"]; $fecha_exp=$rega["fecha_exp"]; $fecha_ini=$rega["fecha_ini"]; $frecuenciaa=$rega["frecuenciaa"]; $frecuencia=$rega["frecuencia"]; $frec_valida="S";  $calculable=$rega["calculable"]; $status=$rega["status"]; $concepto_vac="N"; if($camb_fecha_exp=='S'){ $fecha_ini=$fecha_aus_hasta; }  $asig_ded_apo=$rega["asig_ded_apo"]; if($Cod_Emp=="71"){$den_concepto=substr($den_concepto,0,250);}else{ $observacion=''; //$observacion=$rega["observacion"]; 
	 $den_concepto=$den_concepto.' '.$observacion; $den_concepto=substr($den_concepto,0,250);}
      //echo $cod_empleado." ".$fecha_exp." ".$fechad." ".$status_trab." ".$cod_concepto." ".$frec_nom,"<br>";
	  if($fechad<=$fecha_exp){ $continua=0; 
	   if(frecuencia_valida($frec_nom,$cal_frecuencia,$frecuencia,$u_semana)==false){$continua=1;} 	  
	   if(frecuencia_valida($frec_nom,$cal_frecuencia,$frecuenciaa,$u_semana)==false){$continua=1;} 	  
	   $ndif=0;
       if($continua==0){$calculable=$rega["calculable"]; $asignacion=$rega["asignacion"]; $oculto=$rega["oculto"]; $acumula=$rega["acumula"]; $tipo_a=$rega["tipo_asigna"]; $asig_ded_apo=$rega["asig_ded_apo"]; $prestamo=$rega["prestamo"]; $int_cal_vac=substr($status,0,1); $cantidad=$rega["cantidad"]; $monto_orig=$rega["monto"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $cod_contable=$rega["cod_contable"];$cod_presup=$rega["cod_presup"]; $afecta_presup=$rega["afecta_presup"]; $cod_retencion=$rega["cod_retencion"]; if($fuente_emp<>""){$cod_contable=$fuente_emp;} $cod_grupo=$cod_contable;
        $valor=$cantidad*$monto_orig; $valore=0; $valorq=0; $valoru=0; $valorv=0; $valorw=0; $valorx=0; $valory=0; $valorz=0; if($fecha_egreso<$fecha_exp){$fecha_exp=$fecha_egreso;} 
		$temp_nroc_c=$rega["nro_cuotas_c"]+1; $temp_nroc=$rega["nro_cuotas"];
		$cantidad=cambia_coma_numero($cantidad); $valor=cambia_coma_numero($valor);
		//echo $cod_empleado." ".$fecha_ini." ".$fechad." ".$status_trab." ".$cod_concepto." ".$cantidad." ".$nd_s," ".$frec_nom,"<br>";
		if($cantidad==""){$cantidad=0;}		$valor=cambia_coma_numero($valor); 
        if($redondear=="SI"){ $valor=RD($valor);}		
        if($frec_nom=="M"){ $tfrec=$frecuenciaa*1; $valorz=$valor;  $valorz=($valorz/2);  $valorz=Round($valorz, 2); 
		if($tfrec==1){$valorz=$valor;} if($tfrec==2){$valorz=0;}  $valorz=cambia_coma_numero($valorz); }	
		$sSQL="SELECT ACTUALIZA_NOM065(1,'$tipo_nomina','$cod_concepto','$den_concepto','$calculable','$asignacion','$acumula','$oculto','$tipo_a','$asig_ded_apo','$frec_valida','$prestamo','$concepto_vac','$int_cal_vac',$acumulado,$saldo,$valore,$valorq,$valoru,$valorv,$valorw,$valorx,$valory,$valorz,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$fecha_ini','$fecha_exp','$fechah',$frecuenciaa,'$cod_orden')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){ echo "Agrega Concepto ".$cod_concepto,"<br>" ;?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;}
        if(($calculable=="NO")and($oculto=="NO")){if(($asig_ded_apo=="A")and($oculto=="NO")){$MAsignacion=$MAsignacion+$valor;} if(($asig_ded_apo=="D")and($oculto=="NO")){$MDeduccion=$MDeduccion+$valor;}}
      }}}     
     $sqla="SELECT * FROM NOM065 where (codigo_mov='$tipo_nomina') and (calculable='SI') and (concepto_vac='N') and (cod_concepto in (select cod_concepto from nom003 where tipo_nomina='$tipo_nomina')) order by cod_orden"; 
	 $sqla="SELECT * FROM NOM065 where (codigo_mov='$tipo_nomina') and (calculable='SI') order by cod_orden";  $resa=pg_query($sqla);
     while(($rega=pg_fetch_array($resa))and($error==0)){ $cod_concepto=$rega["cod_concepto"]; $valor=$rega["valor"]; $cantidad=$rega["cantidad"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $monto_orig=$rega["monto_orig"]; $valore=$rega["valore"]; $valoru=$rega["valoru"]; $valorq=$rega["valorq"]; $valorw=$rega["valorw"]; $valorx=$rega["valorx"]; $valory=$rega["valory"]; $valorz=$rega["valorz"]; $cod_orden=$rega["cod_orden"]; $frecuenciaa=$rega["frecuencia"];
       $calculo_final_val=0;  $calculo1_val=0;  $calculo2_val=0;  $asig_ded_apo=$rega["asig_ded_apo"]; $fecha_ini=$rega["fecha_ini"]; $fecha_exp=$rega["fecha_exp"]; $oculto=$rega["oculto"];
       if($cod_concepto==$conc_bono){ $criteriobv=" and consecutivo>='002' ";} else { $criteriobv="";}
       $sqlf="Select * from nom003 where tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto' ".$criteriobv."  Order BY tipo_nomina,cod_concepto,consecutivo";$resf=pg_query($sqlf);  $continuaf=0;
       while(($regf=pg_fetch_array($resf))and($error==0)and($continuaf==0)){ $consecutivo=$regf["consecutivo"];  $accion=$regf["accion"]; $rango_inicial=$regf["rango_inicial"]; $rango_final=$regf["rango_final"]; $calculo1=$regf["calculo1"]; $calculo2=$regf["calculo2"]; $calculofinal=$regf["calculofinal"];
        if(($valor>=$rango_inicial)and($valor<=$rango_final)){ 
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
		 //if($cod_concepto=="208"){	 echo $cod_concepto." ".$accion." ".$valor,"<br>";  }
       } }
	   $entra=0; //if(($valor>0)and($asig_ded_apo=="A")){$entra=1;}  
	   if(($valor>0)and($monto_orig>0)and($asig_ded_apo=="D")){$entra=1;}	   
	   if(($asig_ded_apo=="A")and($valor>0)and($cantidad==0)){$entra=1;} 
	  if(($error==0)and($oculto=="NO")and($cantidad==0)and($entra==1)and($fecha_ini<=$fechah)){ $ndif=15; if($frec_nom=="S"){$ndif=7;} if($frec_nom=="M"){$ndif=30;}
         $temp_e=formato_ddmmaaaa($fecha_exp); $temp_i=formato_ddmmaaaa($fecha_ini); $t_dia=substr($temp_e,0,2); if($t_dia=="31"){$temp_e="30".substr($temp_e,2,8);}
		 If (($fecha_exp<$fechah) and ($fecha_ini<$fechah)){$dias_dif=diferencia_dias($fecha_desde,$temp_e)+1; $valor=($valor/$ndif)*$dias_dif; }
         If (($fecha_exp>$fechah) and ($fecha_ini>$fechad)){$dias_dif=diferencia_dias($temp_i,$fecha_hasta);  $valor=($valor/$ndif)*$dias_dif; }
         If (($fecha_exp<$fechah) and ($fecha_ini>$fechad)){$dias_dif=diferencia_dias($temp_i,$temp_e)+1; $valor=($valor/$ndif)*$dias_dif;}
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
     $sqla="SELECT * FROM NOM065 where (codigo_mov='$tipo_nomina')and (cod_concepto='$conc_bono')";  $resa=pg_query($sqla); $filasa=pg_num_rows($resa);
     if($filasa>0){$rega=pg_fetch_array($resa); $cod_concepto=$rega["cod_concepto"]; $valor=$rega["valor"]; $cantidad=$rega["cantidad"]; $frecuencia=$rega["frecuencia"];
	   $sSQL="SELECT ACT_MOVIMIENTO_NOM011(3,'$tipo_nomina','$cod_empleado','$cod_concepto',$cantidad,$valor,'S','S','$frecuencia')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){ echo "Error Agrega Calculo ".$cod_empleado,"<br>"; echo $sSQL,"<br>"; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?  $error=1;}
     }
	 //echo $sSQL,"<br>";
	}
	$MNeto=$MAsignacion-$MDeduccion;  if($MNeto<0){ ?><script language="JavaScript">muestra('ERROR EN TRABAJADOR:<? echo $cod_empleado; ?> MONTO ES NEGATIVO:<? echo $MNeto; ?> \n ASIGNACIONES:<? echo $MAsignacion; ?> DEDUCCIONES:<? echo $MDeduccion; ?> \n POR FAVOR VERIFIQUE');</script><?}
 }}
}
$criterio=$tipo_nomina.$cod_concepto."0"; pg_close(); ?><script language="JavaScript"> muestra('<? echo $mensaje; ?>'); </script>
<iframe src="Det_carga_bono_vac.php?criterio=<?echo $criterio?>" width="950" height="350" scrolling="auto" frameborder="1"></iframe>


