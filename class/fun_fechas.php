<?php 
//putenv("TZ=America/Caracas");
date_default_timezone_set("America/Caracas"); 
        
function formato_ddmmaaaa($cfecha){
   $valor = substr($cfecha,8,2)."/".substr($cfecha,5,2)."/".substr($cfecha,0,4);
   return $valor;
}
function formato_aaaammdd($cfecha){
   $valor = substr($cfecha,6,4)."-".substr($cfecha,3,2)."-".substr($cfecha,0,2);
   return $valor;
}
function asigna_fecha_hoy(){
   $cfecha=date("d/m/y");  $valor=substr($cfecha,0,6)."20".substr($cfecha,6,2);
   return $valor;
}
function colocar_pdiames($cfecha){
   $dia1="01"; $mes1=substr($cfecha,3,2); $ano1=substr($cfecha,6,4);
   $valor = $dia1.substr($cfecha,2,4).$ano1;
   return $valor;
}
function colocar_udiames($cfecha){
   $dia1="31"; $mes1=substr($cfecha,3,2); $ano1=substr($cfecha,6,4);
   if ($mes1=='01' || $mes1=='03' || $mes1=='05' || $mes1=='07' || $mes1=='08' || $mes1=='10' || $mes1=='12') {$dia1="31";}
   else{ $dia1="30"; } If ($mes1=='02'){  If ($ano1%4!=0) { $dia1="28"; } else { $dia1="29"; } }
   $valor = $dia1.substr($cfecha,2,4).$ano1;
   return $valor;
}
function checkData($date){
  if (!isset($date) || $date=="") { return false; }
  if (strlen($date)==10){list($dd,$mm,$yy)=explode("/",$date);
    if ($dd!="" && $mm!="" && $yy!="") {return checkdate($mm,$dd,$yy);}}
  return false;
}
function operacion_mes($cfecha,$num){
   $dia1=substr($cfecha,0,2); $mes1=substr($cfecha,3,2); $ano1=substr($cfecha,6,4);
   $mes2=$mes1+$num; if($mes2<=0){$mes2=$mes2+12; $ano1=$ano1-1;}  if($mes2>=13){$mes2=$mes2-12; $ano1=$ano1+1;} if($mes2<=9){$mes2='0'.$mes2;}
   $valor = $dia1.substr($cfecha,2,1).$mes2.substr($cfecha,5,1).$ano1;
   return $valor;
}
function bisiesto($año){
  if ($año%4!=0){  $bisiesto=false; }
  else {if ($año%400==0) { $bisiesto=true; }
    else{ if ($año%100==0) {$bisiesto=false;} else {$bisiesto=true;}} }
  return $bisiesto;
}
function Armar_Fecha($MPeriodo, $Ini_Fin, $Fec_Ini_Ejer ) {
 $VFecha=formato_ddmmaaaa($Fec_Ini_Ejer);     $Sfecha="";
 $Ano=substr($VFecha,6,4); $Mes=substr($VFecha,3,2);  $Dia=substr($VFecha,0,2);
   $Mes = $MPeriodo;
   if ($Ini_Fin==1) { $Dia = '01'; }
     else {
      if ($MPeriodo=='02') { $Dia=28+bisiesto($Ano); }
      if ($Mes=='01' || $Mes=='03' || $Mes=='05' || $Mes=='07' || $Mes=='08' || $Mes=='10' || $Mes=='12') { $Dia=31; }
      if ($Mes=='04' || $Mes=='06' || $Mes=='09' || $Mes=='11') { $Dia=30; }
      }
   $Sfecha = $Dia."-".$Mes."-".$Ano;
   If ($MPeriodo == '00') { $Sfecha = $Fec_Ini_Ejer; }  // OJO
   return $Sfecha;
}

function weekday($fecha){ $fecha=str_replace("/","-",$fecha); list($dia,$mes,$anio)=explode("-",$fecha); return (((mktime ( 0, 0, 0, $mes, $dia, $anio) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;}

function nextDate($fecha,$dias) {
$diaActual = substr($fecha,0,2); $mesActual = $mesProx = substr($fecha,3,2);  $anioActual = $anioProx = substr($fecha,6,4);
$diaProx = $diaActual + $dias;
$diasMes = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);
if ($diaProx > $diasMes) { $diaProx = $dias - ($diasMes - $diaActual);  $mesProx = $mesActual + 1;
if ($mesProx > 12) { $mesProx = "01"; $anioProx = $anioActual + 1; }
$diasProxMes = cal_days_in_month(CAL_GREGORIAN, $mesProx, $anioProx);
if ($diaProx > $diasProxMes) { $dias = $diaProx - $diasProxMes;
$diaProx = (strlen($diaProx) == 1)?"0".$diaProx:$diaProx; $mesProx = (strlen($mesProx) == 1)?"0".$mesProx:$mesProx;
return nextDate($diaProx."/".$mesProx."/".$anioProx,$dias);}
}
$diaProx = (strlen($diaProx) == 1)?"0".$diaProx:$diaProx;  $mesProx = (strlen($mesProx) == 1)?"0".$mesProx:$mesProx;
if($mesProx=="02"){  if($diaProx>29){$diaProx="28";}   if($diaProx==29){ if(bisiesto($anioProx)==true){$diaProx=29;}else{$diaProx=28;} }    }
if($diaProx>30){ if ($mesProx=='04' || $mesProx=='06' || $mesProx=='09' || $mesProx=='11') { $diaProx=30; } }
return $diaProx."/".$mesProx."/".$anioProx;
}

function prevDate($fecha,$dias) {
$diaActual = substr($fecha,0,2); $mesActual = $mesPrev = substr($fecha,3,2); $anioActual = $anioPrev = substr($fecha,6,4);
$diaPrev =  $diaActual - $dias;
while ($diaPrev <= 0){$diaPrev=$diaPrev+30;}
$mesr=floor($dias/30); $mesPrev = $mesActual - $mesr;
if ($mesPrev < 1) {$mesPrev = 12+$mesPrev;  $anioPrev = $anioActual - 1; }
if ($dias>360) {$anor=floor($dias/360); $anioPrev = $anioActual  - $anor;}
$diaPrev = (strlen($diaPrev) == 1)?"0".$diaPrev:$diaPrev; $mesPrev = (strlen($mesPrev) == 1)?"0".$mesPrev:$mesPrev;
if($mesPrev=="02"){  if($diaPrev>29){$diaPrev="28";}   if($diaPrev==29){ if(bisiesto($anioPrev)==true){$diaPrev=29;}else{$diaPrev=28;} }    }
if($diaPrev>30){ if ($mesPrev=='04' || $mesPrev=='06' || $mesPrev=='09' || $mesPrev=='11') { $diaPrev=30; } }
return $diaPrev."/".$mesPrev."/".$anioPrev;
}

function Asigna_Nro_Semanas($fechad, $fechah){
  $num_lunes=0; $f_dia=$fechad;
  while(formato_aaaammdd($f_dia)<=formato_aaaammdd($fechah)){ If(weekday($f_dia)==0){$num_lunes=$num_lunes+1;} $f_dia= nextDate($f_dia,1);  }
  return $num_lunes;
}
function diferencia_dias($fecha1,$fecha2){
$ano1 = substr($fecha1,6,4); $mes1 = substr($fecha1,3,2); $dia1 = substr($fecha1,0,2);
$ano2 = substr($fecha2,6,4); $mes2 = substr($fecha2,3,2); $dia2 = substr($fecha2,0,2);
//calculo timestam de las dos fechas
$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1); $timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2);
//resto a una fecha la otra
$segundos_diferencia = $timestamp1 - $timestamp2;
//convierto segundos en días
$dias_diferencia = $segundos_diferencia / (60 * 60 * 24);
//obtengo el valor absoulto de los días (quito el posible signo negativo)
$dias_diferencia = abs($dias_diferencia);
//quito los decimales a los días de diferencia
$dias_diferencia = floor($dias_diferencia);
return $dias_diferencia;
}

function diferencia_años($fecha1,$fecha2){
$ano1=substr($fecha1,6,4); $mes1=substr($fecha1,3,2); $dia1=substr($fecha1,0,2); $ano2=substr($fecha2,6,4); $mes2=substr($fecha2,3,2); $dia2=substr($fecha2,0,2);
$dif=$ano2-$ano1; $cfecha=date("d/m/y"); $fecha3=substr($cfecha,0,6)."20".substr($cfecha,6,2); $ano3=substr($fecha3,6,4); $mes3=substr($fecha3,3,2); $dia3=substr($fecha3,0,2);
if($mes2<$mes1){$dif=$dif-1;} 
if(($mes2==$mes1)and($dia1>$dia2)){$dif=$dif-1;} 
$ano_diferencia=$dif; return $ano_diferencia;
}

function FDate($fecha){ $r=0;  $suma=0;
  If (strlen($fecha)==10){$ano=substr($fecha,6,4)*1; $mes=substr($fecha,3,2)*1; $dia=substr($fecha,0,2)*1; $b=$ano%4; $c=($ano-1)%4;
   if($mes==2){ $suma=2; If ($c==0){$suma=1;} }   if($b==0){ if($mes>=3){$suma=1;} } if($c==0){ if($mes<3){$suma=$suma+1;} } 
   If (($ano < 0) or ($mes<1) or ($mes>12) or ($dia<1) or ($dia>31)) {$r=0;}
   else {$Temp=floor(($mes-14.00)/12.0); $r=$dia-32075.0 + floor(1461.0 * ($ano + 4800.0 + $Temp) / 4.0) + floor(367.0 * ($mes - 2.0 - $Temp * 12.0) / 12.0) - floor(3.0 * floor(($ano + 4900.0 + $Temp) / 100.0) / 4.00);}
   $r=$r+$suma;
  }
return $r;}

function NDate($nro_days){ $r=0;
    $tempa=$nro_days + 68569.0;    $tempB=floor(4.0 * $tempa / 146097.0);
    $tempa= $tempa - floor((146097.0 * $tempB + 3.0) / 4.0);    $year=floor(4000.0 * ($tempa + 1.0) / 1461001.0);
    $tempa= $tempa - floor(1461.0 * $year / 4.0) + 31.0;    $month=floor (80.0 * $tempa / 2447.0);
    $day=floor($tempa - floor(2447.0 * $month / 80.0));    $tempa= floor($month / 11.0);   $month=floor($month + 2.0 - 12.0 * $tempa);
    //$year=floor(100.0 * ($tempB - 49.0) + $year + $tempa) - 1900;
    $year=floor(100.0 * ($tempB - 49.0) + $year + $tempa);
	$dayS=$day;	$monthS=$month;	$yearS=$year;
    If (strlen($dayS)<2){$dayS='0'.$dayS;}  If (strlen($monthS)<2){$monthS='0'.$monthS;}
    If (strlen($yearS)==1){$yearS='000'.$yearS;}   If (strlen($yearS)==2){$yearS='00'.$yearS;}   If (strlen($yearS)==3){$yearS='0'.$yearS;}  
	$f=$dayS . '/' . $monthS . '/' . $yearS;
return $f;}

 
function Calcula_dif_fechas($fechad,$fechah){
$dia_desde=substr($fechad,0,2)*1; $mes_desde=substr($fechad,3,2)*1; $ano_desde=substr($fechad,6,4)*1;
$dia_hasta=substr($fechah,0,2)*1; $mes_hasta=substr($fechah,3,2)*1; $ano_hasta=substr($fechah,6,4)*1;
$mes_desde_max = date ("t",mktime (0,0,0,$mes_desde,$dia_desde,$ano_desde));
$dia_dif=$mes_desde_max-$dia_desde; $mes_dif=12-$mes_desde-1; $dia_ini=1;  $mes_ini=1; $ano_ini=$ano_desde+1;
$dia_diferencia = ($dia_hasta - $dia_ini) + 1; $mes_diferencia = ($mes_hasta - $mes_ini) + 1; $ano_diferencia = ($ano_hasta - $ano_ini);
$dia_diferencia = $dia_diferencia + $dia_dif;  $mes_diferencia = $mes_diferencia + $mes_dif;
if ($dia_diferencia >= $mes_desde_max){$dia_diferencia = $dia_diferencia - $mes_desde_max; $mes_diferencia = $mes_diferencia + 1;}
if ($mes_diferencia >= 12){$mes_diferencia = $mes_diferencia - 12; $ano_diferencia = $ano_diferencia + 1; }
if($dia_desde=="01"){
}
//if((($dia_desde=="30")or($dia_hasta=="31") ) and ( ($mes_hasta=='04' or $mes_hasta=='06' or $mes_hasta=='09' or $mes_hasta=='11') )){  $mes_diferencia=$mes_diferencia+1; $dia_diferencia=0; }
//if((($dia_desde=="31")or($dia_hasta=="30") ) and ( ($mes_hasta=='04' or $mes_hasta=='06' or $mes_hasta=='09' or $mes_hasta=='11') )){  $mes_diferencia=$mes_diferencia+1; $dia_diferencia=0; }
if($mes_diferencia==13){ $mes_diferencia=0; $ano_diferencia=$ano_diferencia+1; }
$l=strlen($ano_diferencia); $ano_diferencia=substr("0000",0,4-$l).$ano_diferencia; $l=strlen($mes_diferencia); $mes_diferencia=substr("00",0,2-$l).$mes_diferencia;
//echo $fechad." Calcula_dif_f ".$fechah." ".$ano_diferencia." ".$mes_diferencia." ".$dia_diferencia,"<br>";
$r=$ano_diferencia.$mes_diferencia.$dia_diferencia; return $r;
}

function diferencia_meses($fecha1,$fecha2){
 $periodof=Calcula_dif_fechas($fecha1,$fecha2); $mes1=substr($fecha1,3,2); $mes2=substr($fecha2,3,2);
 $anof=substr($periodof,0,4); $mesf=substr($periodof,4,2); $diaf=substr($periodof,6,2);
 if($mesf=="02"){ if(($diaf=="30")and(($mes2=="04")or($mes2=="06")or($mes2=="09")or($mes2=="11"))){ $mesf="03";} }
 //echo $periodof." ".$mesf." ".$diaf." ".$mes2,"<br>";
 $r=$anof*12+$mesf;
return $r;}

function nextmes($fecha,$meses) {
  $diaActual=substr($fecha,0,2); $mesActual=$mesProx=substr($fecha,3,2);  $anioActual=$anioProx=substr($fecha,6,4);
   if($meses>12){ $ta=$meses/12;  $a=round($ta,0); $anioProx=$anioProx+$a; $meses=$meses-($a*12); }   $mesProx=$mesProx+$meses;
  if($mesProx>12){$mesProx=$mesProx-12; $anioProx=$anioProx+1;}  if($mesProx<10){$mesProx="0".$mesProx;} 
  if($mesProx=="00"){$mesProx=12; $anioProx=$anioProx-1;}
  $diaProx=$diaActual*1;
  if($mesProx=="02"){  if($diaProx>29){$diaActual="28";}   if($diaProx==29){ if(bisiesto($anioProx)==true){$diaActual=29;}else{$diaActual=28;} }    }
  if($diaProx>30){ if ($mesProx=='04' || $mesProx=='06' || $mesProx=='09' || $mesProx=='11') { $diaActual=30; } }
return $diaActual."/".$mesProx."/".$anioProx;}

function nextano($fecha,$anos) {
$diaActual=substr($fecha,0,2); $mesActual=substr($fecha,3,2);  $anioProx=substr($fecha,6,4); $anioProx=$anioProx+$anos;
return $diaActual."/".$mesActual."/".$anioProx;}

function diferencia_horas($phora,$pap,$shora,$sap){
$_phora=$phora; $h=substr($phora,0,2); if(($pap=="pm")and($h<>"12")){ $nh=substr($phora,0,2)+12; $_phora=$nh.substr($phora,2,6);  }
$_shora=$shora; $h=substr($shora,0,2); if(($sap=="pm")and($h<>"12")){ $nh=substr($shora,0,2)+12; $_shora=$nh.substr($shora,2,6);  }
$_hpu=strtotime($_phora); $_hsu=strtotime($_shora);
$_z=$_hsu - $_hpu;
$_d=floor($_z/86400);
$_d_resto=floor($_z % 86400);
$_h=floor($_d_resto/3600);
$_h_resto=floor($_d_resto % 3600);
$_m=floor($_h_resto/60);
$_s=floor($_h_resto%60);
$_retorno=$_h."h ".$_m."m ".$_s."s ";
if($_h<10){$_h="0".$_h;} if($_m<10){$_m="0".$_m;} if($_m<10){$_s="0".$_s;}
$_retorno=$_h.":".$_m.":".$_s;
return $_retorno;}

function diferencia_horas_num($phora,$pap,$shora,$sap){
 $thora=diferencia_horas($phora,$pap,$shora,$sap);
 $nh=substr($thora,0,2); $nm=substr($thora,3,2);
 $mm=($nm*100)/60; $mm=$mm/100;
 $num=$nh+$mm;
return $num;}

?>