<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); $fecha_hoy=asigna_fecha_hoy(); $eofline="@"; $fechah=$_GET["fechah"]; $tfechah=$fechah;  $fechah=formato_aaaammdd($fechah);
$cod_empleado_d=$_GET["codigo_d"];  $cod_empleado_h=$_GET["codigo_h"]; $tipo_nomina_d=$_GET["tipod"]; $tipo_nomina_h=$_GET["tipoh"];
$cod_empleado=""; $fecha_ingreso=formato_aaaammdd($fecha_hoy);  $dep_tercer_mes="N"; $dias_adic_primer="N"; $dep_diferencia="N"; $acum_dias_adic="N"; $prom_dias_adic="N"; $acum_intereses="S";$acum_int_anual="N"; $prom_sueldo="N";
$sueldo_adic=0;  $valor_formula=36000; $fecha_ley="19/06/1997"; $fecha_dep_ley="19/07/1997"; $fecha_c=$tfechah;  $anos_cumplidos=0; $fecha_tope="30/04/2012"; $fecha_i_tope="01/01/2012"; $dias_dep_mes=5; $dias_dep_mes=6; $MNum_dias_dep=15;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?} else{ $Nom_Emp=busca_conf(); }
function Grabar_Prestaciones($fecha_calculo,$mtipoc,$sueldoc,$sueldoa,$mprestaciones,$tprestaciones,$madelanto,$tadelanto,$sprestaciones,$minteres,$interes_noacum,$interes_acum,$interes_pagado,$tinteres,$tasa,$tiempo,$atotal,$mnum_dias,$mnum_dias_adic,$mpresta_adic){ global $cod_empleado,$conn;
  $ncalculo="0"; $mgraba=0;  $monto_presta=$mprestaciones+$mpresta_adic; $fecha_calculo=formato_aaaammdd($fecha_calculo);
  $sSQL="Select num_calculo FROM NOM030 Where cod_empleado='$cod_empleado' and fecha_calculo='$fecha_calculo' order by num_calculo desc";
  $resultado=pg_query($sSQL); if($registro=pg_fetch_array($resultado,0)){ $ncalculo=$registro["num_calculo"]; if($ncalculo=="1"){$ncalculo="2";}else{$ncalculo="1";} }
  if($mprestaciones==0){$mnum_dias=0;}  
  $sSQL="SELECT ACTUALIZA_NOM030(1,'$cod_empleado','$fecha_calculo','$ncalculo','$mtipoc',$sueldoc,$mnum_dias,$mprestaciones,$sueldoa,$mnum_dias_adic,$mpresta_adic,$monto_presta,$tprestaciones,$madelanto,$tadelanto,0,0,$sprestaciones,$minteres,$interes_noacum,$interes_acum,$interes_pagado,$tinteres,$tasa,$tiempo,$atotal)";
  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){$mgraba=1; echo $sSQL,"<br>"; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$mgraba=0;}
return $mgraba;}
function Asigna_Sueldo($bfecha){ global $cod_empleado,$fecha_ingreso,$sueldo_adic,$status_trab,$prom_sueldo; $msueldo=0; $sueldo_adic=0;
   $fechab=formato_aaaammdd($bfecha); if($fechab<$fecha_ingreso){$fechab=$fecha_ingreso;}
   $sSQL="Select * from NOM028 where cod_empleado='$cod_empleado' and fecha_sueldo<='$fechab' order by fecha_sueldo desc";
   if(($status_trab=="PERMISO")OR($status_trab=="PERMISO NO")OR($status_trab=="PERMISO RE")){ $sSQL="Select * from NOM028 where cod_empleado='$cod_empleado' and fecha_sueldo<='$fechab' and monto_sueldo>0 order by fecha_sueldo desc";}
   //echo $sSQL,"<br>"; 
   $resultado=pg_query($sSQL); if($registro=pg_fetch_array($resultado,0)){$msueldo=$registro["monto_sueldo"]; $sueldo_adic=$registro["monto_sueldo_adic"]; }
   else{echo "Codigo:".$cod_empleado.", Fecha Ingreso:".$fecha_ingreso.", Fecha Buscar:".$fechab,"<br>"; ?> <script language="JavaScript">muestra('CODIGO DE TRABAJADOR:<? echo $cod_empleado; ?> NO TIENE SUELDO DE PRESTACIONES');</script><?}
   if($prom_sueldo=="S"){$mesh=substr($bfecha,3,2); 
     if(($mesh=="03")or($mesh=="06")or($mesh=="09")or($mesh=="12")) { $mesd=$mesh*1; $mesd=$mesd-2; $tmesd=$mesd; if(strlen($tmesd)==1){ $tmesd="0".$tmesd; }
	   if($bfecha=="30/06/2012"){ $tmesd="05"; }
	   $tfechah=$bfecha; $tfechad="01/".$tmesd.substr($bfecha,5,5); $tfechad=colocar_udiames($tfechad);
	   $fechabd=formato_aaaammdd($tfechad); $fechabh=formato_aaaammdd($tfechah);
	   $sSQL="Select * from NOM028 where cod_empleado='$cod_empleado' and fecha_sueldo>='$fechabd' and fecha_sueldo<='$fechabh' order by fecha_sueldo"; $res28=pg_query($sSQL);
	   //echo $sSQL,"<br>"; 
	   $msueldo=0; $cm=0;
       while($reg28=pg_fetch_array($res28)){ $msueldo=$msueldo+$reg28["monto_sueldo"]; $cm=$cm+1;}
	   if($msueldo<>0){ $msueldo=$msueldo/$cm; }
	 }
   }
return $msueldo;}
function Asigna_Sueldo_Promedio($bfecha){ global $cod_empleado; $msueldo=0;  $fechab=formato_aaaammdd($bfecha);
 $hfecha=formato_aaaammdd($bfecha);  $dfecha=operacion_mes($bfecha,-12); $dfecha=formato_aaaammdd($dfecha);
 $sSQL="SELECT sum(sueldo_calculo_adic) as t_sueldo FROM NOM030 Where ((dias_prestaciones=5) or (tipo_calculo='S')) And (cod_empleado='$cod_empleado') And (fecha_calculo>='$dfecha') And (fecha_calculo<='$hfecha')";
 $sSQL="SELECT sum(sueldo_calculo_adic) as t_sueldo FROM NOM030 Where ((tipo_calculo='P') or (tipo_calculo='S')) And (cod_empleado='$cod_empleado') And (fecha_calculo>='$dfecha') And (fecha_calculo<='$hfecha')";
 $resultado=pg_query($sSQL); if($registro=pg_fetch_array($resultado,0)){$msueldo=$registro["t_sueldo"]; $msueldo=$msueldo/12; $msueldo=round($msueldo,2);}
return $msueldo;}
function Cumple_Meses($fecha_i,$fecha_d,$fecha_h){global $fecha_ingreso,$fecha_ley,$fecha_c,$Ant_m;   $fecha_l=formato_aaaammdd($fecha_ley); $cm=0;
  $fecha_c=$fecha_d; if($fecha_ingreso>$fecha_l){$dia_i=substr($fecha_ingreso,8,2);}else{$dia_i=substr($fecha_i,0,2);}  $mes_i=substr($fecha_c,3,2);
  if(($dia_i=="31")Or($dia_i=="30")Or($dia_i=="29")){ if($mes_i=="02"){$dia_i="28"; $ano=substr($fecha_c,6,4); $c=$ano%4; if($c==0){$dia_i="29";} }
   if(($dia_i=="31")and(($mes_i=="04")or($mes_i=="06")or($mes_i=="09")or($mes_i=="11"))){$dia_i="30";}
  } $mfechac=formato_aaaammdd($fecha_c); $mfechad=formato_aaaammdd($fecha_d); $mfechah=formato_aaaammdd($fecha_h);
  if((substr($fecha_c,0,2)==$dia_i) And ($mfechac>=$mfechad) And ($mfechac<=$mfechah)){$cm=1;}
  while(($mfechac<$mfechah)and($cm==0)){ $fecha_c=nextDate($fecha_c,1); if($fecha_ingreso>$fecha_l){$dia_i=substr($fecha_ingreso,8,2);}else{$dia_i=substr($fecha_i,0,2);}
    if(($dia_i=="31")Or($dia_i=="30")Or($dia_i=="29")){ if($mes_i=="02"){$dia_i="28"; $ano=substr($fecha_c,6,4); $c=$ano%4; if($c==0){$dia_i="29";} }
      if(($dia_i=="31")and(($mes_i=="04")or($mes_i=="06")or($mes_i=="09")or($mes_i=="11"))){$dia_i="30";}
    }$mfechac=formato_aaaammdd($fecha_c); if((substr($fecha_c,0,2)==$dia_i) And ($mfechac>=$mfechad) And ($mfechac<=$mfechah)){$cm=1;}
  }
  $f=diferencia_meses($fecha_i,$fecha_h); if($f<0){$f=0;} $Ant_m=$f;
return $cm;}
function Verifica_Antiguedad($fecha_i){global $fecha_ingreso,$fecha_ley,$fecha_c,$anos_cumplidos;   $fecha_l=formato_aaaammdd($fecha_ley); $va=0;
   $fechaa=$fecha_c; $tfecha_ing=formato_ddmmaaaa($fecha_ingreso);$tfecha_ley=formato_ddmmaaaa($fecha_ley);
   $m1=FDate($tfecha_ing); $m2=FDate($tfecha_ley);
   if($m1>$m2){$fechai=formato_ddmmaaaa($fecha_ingreso);}else{$fechai=$fecha_i;} $anos_cumplidos=0;
   if(substr($fechaa,0,6)==substr($fecha_i,0,6)){ $fechaa=$fechai; $mfechac=formato_aaaammdd($fecha_c); $mfechaa=formato_aaaammdd($fechaa);   
     $f1=FDate($fecha_c); $f2=FDate($fechaa);	 
     while(($va==0)and($mfechaa<$mfechac)){  $anos_cumplidos=$anos_cumplidos+1;   $fechaa=nextano($fechaa,1);   if($fechaa==$fecha_c){$va=1;}  }	   
   }
   //echo $fecha_i." ".$fechaa." ".$va;	 
return $va;}
function Verifica_Pago_Intereses($fecha_d,$fecha_h){ global $cod_empleado,$valor_formula,$fecha_c,$sueldo_adic,$fecha_pago,$mtiempo; 
 global $fecha_mes,$mprestaciones,$tprestaciones,$tadelanto,$sprestaciones,$interes_noacum,$tinteres,$interes_acum,$minteres,$mtasa,$mtotal,$monto_sueldo;
 $Go=0;   $entro=0;   $mvalor=0;   $fecha_p=$fecha_d;   $mmonto_i=0; $tfecha_h=formato_aaaammdd($fecha_h);  $fecha_pago=$fecha_h;
 $sSQL="SELECT * From NOM032 Where (cod_empleado='$cod_empleado') And (fecha_pago<='$tfecha_h') Order by fecha_pago"; $res32=pg_query($sSQL);
 while(($reg31=pg_fetch_array($res32))){ $fecha_p=$reg32["fecha_pago"];  $fecha_pago=$reg32["fecha_pago"]; $fecha_pago=formato_aaaammdd($fecha_pago);
    $Go=1;   $entro=1;   $mvalor=1; 
	$interes_noacum=$interes_noacum-$minteres;  $m1=FDate(formato_ddmmaaaa($fecha_p)); $m2=FDate($fecha_d);  $mtiempo=$m1-$m2+1;
	if($mtiempo==0){ $minteres=0; }  else{$minteres=(($mtotal*$mtiempo*$mtasa)/$valor_formula); $minteres=Round($minteres,2); }
    $interes_noacum=$interes_noacum+$minteres; $mmonto_i=$reg32["monto_pago"];
	If ($mmonto_i> $interes_noacum) { $interes_acum=$interes_acum+$interes_noacum-$mmonto_i; $interes_noacum=0;  }
	 else{$interes_noacum=$interes_noacum-$mmonto_i;}
	$tinteres=$interes_acum+$interes_noacum; $mtotal=$sprestaciones+$interes_acum; $fecha_c=formato_ddmmaaaa($fecha_p);
	if(Grabar_Prestaciones($fecha_c,'I',$monto_sueldo,$sueldo_adic,0,$tprestaciones,0,$tadelanto,$sprestaciones,$minteres,$interes_noacum,$interes_acum,$mmonto_i,$tinteres,$mtasa,$mtiempo,$mtotal,0,0,0)==0){  
		$fecha_m=formato_ddmmaaaa($fecha_p);  $fecha_m=nextDate($fecha_m,1); $m2=FDate($fecha_m); $m1=FDate($fecha_h);  $mtiempo=$m1-$m2+1; $fecha_c=$fecha_m;
		if($mtiempo==0){ $minteres=0; }  else{$minteres=(($mtotal*$mtiempo*$mtasa)/$valor_formula); $minteres=Round($minteres,2); }
		$interes_noacum=$interes_noacum+$minteres; $mmonto_i=0; $tinteres=$interes_acum+$interes_noacum;  $fecha_pago=$fecha_m;
	}
 }	
return $mvalor;} 
function Verifica_Anticipo($fecha_d,$fecha_h){ global $cod_empleado,$valor_formula,$fecha_c,$sueldo_adic,$fecha_pago,$mtiempo; 
 global $fecha_mes,$mprestaciones,$tprestaciones,$tadelanto,$sprestaciones,$interes_noacum,$tinteres,$interes_acum,$minteres,$mtasa,$mtotal,$monto_sueldo;
 $Go=0;   $entro=0;   $mvalor=0;   $fecha_p=$fecha_d;   $mmonto_a=0; $tfecha_h=formato_aaaammdd($fecha_h);  $fecha_pago=$fecha_h;
 $sSQL="SELECT * From NOM031 Where (cod_empleado='$cod_empleado') And (fecha_adelanto<='$tfecha_h') Order by fecha_adelanto"; $res31=pg_query($sSQL);
 while(($reg31=pg_fetch_array($res31))){ $fecha_p=$reg31["fecha_adelanto"];  $fecha_ua=$reg31["fecha_adelanto"]; 
    $Go=1;   $entro=1;   $mvalor=1; 
	if (Verifica_Pago_Intereses($fecha_d,$fecha_h)==0){  $interes_noacum=$interes_noacum-$minteres;  $tfecha_p=formato_ddmmaaaa($fecha_p); $m1=FDate($tfecha_p); $m2=FDate($fecha_d);  $mtiempo=$m1-$m2+1;
	}else{$interes_noacum=$interes_noacum-$minteres;  $m1=FDate(formato_ddmmaaaa($fecha_p)); $m2=FDate($fecha_pago);  $mtiempo=$m1-$m2+1;	}  
    if($mtiempo==0){ $minteres=0; }  else{$minteres=(($mtotal*$mtiempo*$mtasa)/$valor_formula); $minteres=Round($minteres,2); }
    $interes_noacum=$interes_noacum+$minteres; $mmonto_a=$reg31["monto_adelanto"]; $tinteres=$interes_acum+$interes_noacum; 
    $tadelanto=$tadelanto+$mmonto_a; $sprestaciones=$tprestaciones-$tadelanto;  $mtotal=$sprestaciones+$interes_acum; $fecha_c=formato_ddmmaaaa($fecha_p);
    if($sprestaciones>0){
 	  if(Grabar_Prestaciones($fecha_c,'A',$monto_sueldo,$sueldo_adic,0,$tprestaciones,$mmonto_a,$tadelanto,$sprestaciones,$minteres,$interes_noacum,$interes_acum,0,$tinteres,$mtasa,$mtiempo,$mtotal,0,0,0)==0){  
		$fecha_m=formato_ddmmaaaa($fecha_p);  $fecha_m=nextDate($fecha_m,1); $m2=FDate($fecha_m); $m1=FDate($fecha_h);  $mtiempo=$m1-$m2+1; $fecha_c=$fecha_m;
		if($mtiempo==0){ $minteres=0; }  else{$minteres=(($mtotal*$mtiempo*$mtasa)/$valor_formula); $minteres=Round($minteres,2); }
		$interes_noacum=$interes_noacum+$minteres; $mmonto_a=0; $tinteres=$interes_acum+$interes_noacum; $mtotal=$sprestaciones+$interes_acum;		
		//echo $minteres." ".$mtotal." ".$mtiempo." ".$mtasa." ".$tfecha_p." ".$fecha_d." ".$m1." ".$m2."  ".$fecha_m,"<br>"; 
	  }
    } 
 }
 if($entro==1){ $fecha_m=formato_ddmmaaaa($fecha_ua);   $fecha_m=nextDate($fecha_m,1); if (Verifica_Pago_Intereses($fecha_m,$fecha_h)==0){ $Go=1; }  }
return $mvalor;}
function procesar_prestaciones() {global $p,$tfechah,$cod_empleado,$fechah,$fecha_c,$fecha_ingreso,$dep_tercer_mes,$dias_adic_primer,$sueldo_adic,$valor_formula,$fecha_ley,$fecha_dep_ley,$anos_cumplidos,$dep_diferencia,$acum_dias_adic,$prom_dias_adic,$acum_intereses,$acum_int_anual,$dep_dias_adic,$fecha_i_tope;
global $fecha_mes,$mprestaciones,$tprestaciones,$tadelanto,$sprestaciones,$interes_noacum,$tinteres,$interes_acum,$minteres,$mtasa,$mtotal,$monto_sueldo,$mtiempo;
  $p=0; $anos_cumplidos=0; $fecha_max=$tfechah; $fecha_max=formato_aaaammdd($fecha_max); $fecha_l=formato_aaaammdd($fecha_ley);  $fecha_ing=formato_ddmmaaaa($fecha_ingreso);  $m1=FDate($fecha_ing); $m2=FDate($fecha_ley); $mcontinua=1;
  if($m1<$m2){$num_dias=$m2-$m1; if($num_dias<180){ if($dep_tercer_mes=="S"){ if(substr($fecha_ingreso,8,2)=="31"){$fecha_ing="30/09".substr($fecha_ley,5,5);}else{$fecha_ing=substr($fecha_ingreso,8,2)."/09".substr($fecha_ley,5,5);}} else{$fecha_ing=substr($fecha_ingreso,8,2)."/10".substr($fecha_ley,5,5);} } else{$fecha_ing=$fecha_ley;}}
   else{ $fecha_ing=$fecha_ing;}  $cant_mes_dep=3; $tmesp=0; $mesi=0;
  $StrSQL= "SELECT fecha_calculo,Sueldo_calculo,total_prestaciones,total_adelanto,saldo_prestaciones,acumulado_total,total_interes,interes_acum,interes_noacum from NOM030 Where (cod_empleado='$cod_empleado') Order by fecha_calculo desc,num_calculo desc"; $resultado=pg_query($StrSQL);
  if($registro=pg_fetch_array($resultado,0)){ $primera_fecha=$fecha_ingreso;  $fecha_umov=$registro["fecha_calculo"]; $fecha_c=formato_ddmmaaaa($registro["fecha_calculo"]); $monto_sueldo=$registro["sueldo_calculo"];
  $tprestaciones=$registro["total_prestaciones"]; $tadelanto=$registro["total_adelanto"]; $sprestaciones=$registro["saldo_prestaciones"]; $mtotal=$registro["acumulado_total"];
  $tinteres=$registro["total_interes"]; $interes_acum=$registro["interes_acum"]; $interes_noacum=$registro["interes_noacum"];
  $num_dias=0; $mprestaciones=0; $num_dias_adic=0; $mpresta_adic=0; $minteres=0; $mtasa=0; $mtiempo=0; $mcontinua=0;  if(($fecha_umov=="2012-04-30")or($fecha_umov=="2012-05-31")){ $cant_mes_dep=2; }  }
  //echo $mcontinua,"<br>";
  if($mcontinua==0){ if($fecha_ingreso>$fecha_l){$fecha_ing=formato_ddmmaaaa($fecha_ingreso);} else{$sdia=substr($fecha_ing,0,2); if($sdia=="31"){$sdia="30";} $fecha_ing=$sdia.substr($fecha_ley,2,8);} }
   else{ $fecha_mes=$fecha_ing; $m1=FDate($fecha_ing); $m2=FDate($fecha_i_tope); $fecha_c=$fecha_mes;
	if($m1<$m2){ $mcontinua=1; $error=1;?><script language="JavaScript">muestra('FECHA CALCULO DE PRESTACIONES INVALIDA PARA EL TRABAJADOR <? echo $cod_empleado; ?>');</script><?}
	else{  $mesh=substr($tfechah,3,2); if(($mesh=="03")or($mesh=="06")or($mesh=="09")or($mesh=="12")) { $mcontinua=0; } else { $mcontinua=1; }  }
	if($mcontinua==0){ $fecha_t="2012-06-30";
	   $cant_mes_dep=2;	$mesi=substr($fecha_ing,3,2); $mesi=$mesi*1; $tmesp=4-$mesi; $cant_mes_dep=$cant_mes_dep+$tmesp;
	   if($fecha_ingreso>$fecha_t){ $cant_mes_dep=3;} }
   }
   $fecha_m=nextDate($fecha_c,1); 
   $fecha_hasta=colocar_udiames($fecha_m);  $fm=FDate($tfechah); $fh=FDate($fecha_hasta); 
   while(($fm>=$fh)and($mcontinua==0)){ $fecha_desde=colocar_pdiames($fecha_hasta);
     $num_dias=0; $mprestaciones=0; $num_dias_adic=0; $mpresta_adic=0; $minteres=0; $mtasa=0; $mtiempo=0; $fechab=formato_aaaammdd($fecha_hasta);	 
	 $sSQL="SELECT fecha_desde,fecha_hasta,tasa FROM NOM021 Where fecha_hasta='$fechab'"; $res21=pg_query($sSQL); 
	 if($reg21=pg_fetch_array($res21,0)){$fecha_c=formato_ddmmaaaa($reg21["fecha_hasta"]); $mtasa=$reg21["tasa"]; }		 
	 if(Cumple_Meses($fecha_ing,$fecha_desde,$fecha_hasta)==1) { 
	   $fecha_mes=$fecha_c; $num_dias=5; $num_dias_adic=0;
	   $mesh=substr($fecha_hasta,3,2); if(($mesh=="03")or($mesh=="06")or($mesh=="09")or($mesh=="12")) { $num_dias=5*$cant_mes_dep;} else { $num_dias=0;}
	   if(Verifica_Antiguedad($fecha_ing)==1){  
	     if($dias_adic_primer=="S"){$ma_cumplido=$anos_cumplidos;}else{$ma_cumplido=$anos_cumplidos-1;}  $mopa=$ma_cumplido*2;
         if($mopa<30){  if($acum_dias_adic=="N"){$num_dias_adic=$mopa;}else{if($ma_cumplido>0){$num_dias_adic=2;}} }
          else{  if($acum_dias_adic=="N"){$num_dias_adic=30;}else{$num_dias_adic=2;} } if($dep_dias_adic=="N"){ $num_dias_adic=0;}         
		 if($dep_dias_adic=="N"){$num_dias_adic=0;}
       }  $fecha_c=$fecha_hasta; $fecha_mes=$fecha_c; 	   
	   $m1=FDate($fecha_mes); $m2=FDate($fecha_desde);  $mtiempo=$m1-$m2+1;
       $minteres=(($mtotal*$mtiempo*$mtasa)/$valor_formula); $minteres=Round($minteres,2);  $interes_noacum=$interes_noacum+$minteres;
       $monto_sueldo=Asigna_Sueldo($fecha_mes); $sueldo_adic=$monto_sueldo; If(($num_dias_adic!=0)and($prom_dias_adic=="S")){$sueldo_adic=Asigna_Sueldo_Promedio($fecha_mes);}
       if($mtiempo<1){$mcontinua=1;}
        else{ $mprestaciones=($monto_sueldo/30)*$num_dias;  $mpresta_adic=($sueldo_adic/30)*$num_dias_adic;
	    //verifica anticipos y pagos
		$mfecha_d=$fecha_desde; $mfecha_h=$fecha_hasta;
		if(Verifica_Anticipo($mfecha_d,$mfecha_h)==1){ $fecha_desde=$fecha_c; $fecha_c=$fecha_hasta;}
		else{ if (Verifica_Pago_Intereses($mfecha_d,$mfecha_h)==1){ $fecha_desde=$fecha_c; $fecha_c=$fecha_hasta; } }		
        if($mcontinua==0){ $tprestaciones=$tprestaciones+$mprestaciones+$mpresta_adic; $tadelanto=$tadelanto; $sprestaciones=$tprestaciones-$tadelanto;          
		  if(substr($fecha_c,0,5)==substr($fecha_ing,0,5)){ if(Verifica_Antiguedad($fecha_ing)==1){$anos_cumplidos=$anos_cumplidos;} }  
		  if((($anos_cumplidos!=0)or($acum_intereses=="S"))and($acum_int_anual=="S")){$interes_acum=$interes_acum+$interes_noacum;$interes_noacum=0;}
		   //echo substr($fecha_c,0,5)." ".substr($fecha_ing,0,5)." ".$anos_cumplidos,"<br>"; 
		 $tinteres=$interes_acum+$interes_noacum; $mtotal=$sprestaciones+$interes_acum; $m1=FDate($fecha_c); $m2=FDate($fecha_desde);  $mtiempo=$m1-$m2+1;
          if(Grabar_Prestaciones($fecha_c,'P',$monto_sueldo,$sueldo_adic,$mprestaciones,$tprestaciones,0,$tadelanto,$sprestaciones,$minteres,$interes_noacum,$interes_acum,0,$tinteres,$mtasa,$mtiempo,$mtotal,$num_dias,$num_dias_adic,$mpresta_adic)==0){$p=1;$mcontinua=0;$num_dias=0;$mprestaciones=0;$fecha_c=nextDate($fecha_c,1);$fecha_mes=$fecha_c;}else{$mcontinua=1;}
        }}
	 }	 
     $fecha_m=nextDate($fecha_hasta,1); $fecha_hasta=colocar_udiames($fecha_m);  $fm=FDate($tfechah); $fh=FDate($fecha_hasta);
	 //echo $fecha_m." ".$fecha_hasta." ".$fm." ".$fh,"<br>"; 
   }
return $p;}


function procesar_prestaciones5() {global $p,$tfechah,$cod_empleado,$fechah,$fecha_c,$fecha_ingreso,$dep_tercer_mes,$dias_adic_primer,$sueldo_adic,$valor_formula,$fecha_ley,$fecha_dep_ley,$anos_cumplidos,$dep_diferencia,$acum_dias_adic,$prom_dias_adic,$acum_intereses,$acum_int_anual,$dep_dias_adic,$fecha_i_tope;
global $fecha_mes,$mprestaciones,$tprestaciones,$tadelanto,$sprestaciones,$interes_noacum,$tinteres,$interes_acum,$minteres,$mtasa,$mtotal,$monto_sueldo,$mtiempo,$MNum_dias_dep;
  $p=0; $anos_cumplidos=0; $fecha_max=$tfechah; $fecha_max=formato_aaaammdd($fecha_max); $fecha_l=formato_aaaammdd($fecha_ley);  $fecha_ing=formato_ddmmaaaa($fecha_ingreso);  $m1=FDate($fecha_ing); $m2=FDate($fecha_ley); $mcontinua=1;
  if($m1<$m2){$num_dias=$m2-$m1; if($num_dias<180){ if($dep_tercer_mes=="S"){ if(substr($fecha_ingreso,8,2)=="31"){$fecha_ing="30/09".substr($fecha_ley,5,5);}else{$fecha_ing=substr($fecha_ingreso,8,2)."/09".substr($fecha_ley,5,5);}} else{$fecha_ing=substr($fecha_ingreso,8,2)."/10".substr($fecha_ley,5,5);} } else{$fecha_ing=$fecha_ley;}}
   else{ $fecha_ing=$fecha_ing;}  $cant_mes_dep=3; $tmesp=0; $mesi=0;
  $StrSQL= "SELECT fecha_calculo,Sueldo_calculo,total_prestaciones,total_adelanto,saldo_prestaciones,acumulado_total,total_interes,interes_acum,interes_noacum from NOM030 Where (cod_empleado='$cod_empleado') Order by fecha_calculo desc,num_calculo desc"; $resultado=pg_query($StrSQL);
  if($registro=pg_fetch_array($resultado,0)){ $primera_fecha=$fecha_ingreso;  $fecha_umov=$registro["fecha_calculo"]; $fecha_c=formato_ddmmaaaa($registro["fecha_calculo"]); $monto_sueldo=$registro["sueldo_calculo"];
  $tprestaciones=$registro["total_prestaciones"]; $tadelanto=$registro["total_adelanto"]; $sprestaciones=$registro["saldo_prestaciones"]; $mtotal=$registro["acumulado_total"];
  $tinteres=$registro["total_interes"]; $interes_acum=$registro["interes_acum"]; $interes_noacum=$registro["interes_noacum"];
  $num_dias=0; $mprestaciones=0; $num_dias_adic=0; $mpresta_adic=0; $minteres=0; $mtasa=0; $mtiempo=0; $mcontinua=0;  if(($fecha_umov=="2012-04-30")or($fecha_umov=="2012-05-31")){ $cant_mes_dep=2; }  }
  //echo $mcontinua." ".$fecha_ing." ".$fecha_ingreso." ".$fecha_l,"<br>";
  if($mcontinua==0){ $m1=FDate($fecha_ing); $m2=FDate($fecha_ley);
  if($m1>$m2){$fecha_ing=formato_ddmmaaaa($fecha_ingreso);} 
  else{$sdia=substr($fecha_ing,0,2); if($sdia=="31"){$sdia="30";} 
    $fecha_ing=formato_ddmmaaaa($fecha_ingreso); $fecha_ing=$sdia.substr($fecha_ley,2,8);  } }
  else{ $fecha_mes=$fecha_ing; $m1=FDate($fecha_ing); $m2=FDate($fecha_i_tope); $fecha_c=$fecha_mes;
	if($m1<$m2){ $mcontinua=1; $error=1;?><script language="JavaScript">muestra('FECHA CALCULO DE PRESTACIONES INVALIDA PARA EL TRABAJADOR <? echo $cod_empleado; ?>');</script><?}
	else{  $mesh=substr($tfechah,3,2); if(($mesh=="03")or($mesh=="06")or($mesh=="09")or($mesh=="12")) { $mcontinua=0; } else { $mcontinua=1; }  }
	if($mcontinua==0){ $fecha_t="2012-06-30";
	   $cant_mes_dep=2;	$mesi=substr($fecha_ing,3,2); $mesi=$mesi*1; $tmesp=4-$mesi; $cant_mes_dep=$cant_mes_dep+$tmesp;
	   if($fecha_ingreso>$fecha_t){ $cant_mes_dep=3;} }
   }
   $fecha_m=nextDate($fecha_c,1); 
   $fecha_hasta=colocar_udiames($fecha_m);  $fm=FDate($tfechah); $fh=FDate($fecha_hasta); 
   while(($fm>=$fh)and($mcontinua==0)){ $fecha_desde=colocar_pdiames($fecha_hasta);
     $num_dias=0; $mprestaciones=0; $num_dias_adic=0; $mpresta_adic=0; $minteres=0; $mtasa=0; $mtiempo=0; $fechab=formato_aaaammdd($fecha_hasta);	 
	 $sSQL="SELECT fecha_desde,fecha_hasta,tasa FROM NOM021 Where fecha_hasta='$fechab'"; $res21=pg_query($sSQL); 
	 if($reg21=pg_fetch_array($res21,0)){$fecha_c=formato_ddmmaaaa($reg21["fecha_hasta"]); $mtasa=$reg21["tasa"]; }		 
	 if(Cumple_Meses($fecha_ing,$fecha_desde,$fecha_hasta)==1) { 
	   $fecha_mes=$fecha_c; $num_dias=$MNum_dias_dep; $num_dias_adic=0;
	   $mesh=substr($fecha_hasta,3,2); if(($mesh=="03")or($mesh=="06")or($mesh=="09")or($mesh=="12")) { $num_dias=($MNum_dias_dep/3)*$cant_mes_dep;} else { $num_dias=0;}
	   if(Verifica_Antiguedad($fecha_ing)==1){  
	     if($dias_adic_primer=="S"){$ma_cumplido=$anos_cumplidos;}else{$ma_cumplido=$anos_cumplidos-1;}  $mopa=$ma_cumplido*2;
         if($mopa<30){  if($acum_dias_adic=="N"){$num_dias_adic=$mopa;}else{if($ma_cumplido>0){$num_dias_adic=2;}} }
          else{  if($acum_dias_adic=="N"){$num_dias_adic=30;}else{$num_dias_adic=2;} } if($dep_dias_adic=="N"){ $num_dias_adic=0;}         
		 if($dep_dias_adic=="N"){$num_dias_adic=0;}
       }  $fecha_c=$fecha_hasta; $fecha_mes=$fecha_c; 	   
	   $m1=FDate($fecha_mes); $m2=FDate($fecha_desde);  $mtiempo=$m1-$m2+1;
       $minteres=(($mtotal*$mtiempo*$mtasa)/$valor_formula); $minteres=Round($minteres,2);  $interes_noacum=$interes_noacum+$minteres;
       $monto_sueldo=Asigna_Sueldo($fecha_mes); $sueldo_adic=$monto_sueldo;
	   If(($num_dias_adic!=0)and($prom_dias_adic=="S")){$sueldo_adic=Asigna_Sueldo_Promedio($fecha_mes);}       
	   If($num_dias_adic!=0){$sueldo_adic=$monto_sueldo; }
	   //echo $mcontinua." ".$mtiempo." ".$sueldo_adic." ".$num_dias_adic,"<br>";
	   if($mtiempo<1){$mcontinua=1;}
        else{ $mprestaciones=($monto_sueldo/30)*$num_dias;  $mpresta_adic=($sueldo_adic/30)*$num_dias_adic;
	    //verifica anticipos y pagos
		$mfecha_d=$fecha_desde; $mfecha_h=$fecha_hasta;
		if(Verifica_Anticipo($mfecha_d,$mfecha_h)==1){ $fecha_desde=$fecha_c; $fecha_c=$fecha_hasta;}
		else{ if (Verifica_Pago_Intereses($mfecha_d,$mfecha_h)==1){ $fecha_desde=$fecha_c; $fecha_c=$fecha_hasta; } }		
        if($mcontinua==0){ $tprestaciones=$tprestaciones+$mprestaciones+$mpresta_adic; $tadelanto=$tadelanto; $sprestaciones=$tprestaciones-$tadelanto;          
		  if(substr($fecha_c,0,5)==substr($fecha_ing,0,5)){ if(Verifica_Antiguedad($fecha_ing)==1){$anos_cumplidos=$anos_cumplidos;} }  
		  if((($anos_cumplidos!=0)or($acum_intereses=="S"))and($acum_int_anual=="S")){$interes_acum=$interes_acum+$interes_noacum;$interes_noacum=0;}
		   //echo substr($fecha_c,0,5)." ".substr($fecha_ing,0,5)." ".$anos_cumplidos,"<br>"; 
		 $tinteres=$interes_acum+$interes_noacum; $mtotal=$sprestaciones+$interes_acum; $m1=FDate($fecha_c); $m2=FDate($fecha_desde);  $mtiempo=$m1-$m2+1;
          if(Grabar_Prestaciones($fecha_c,'P',$monto_sueldo,$sueldo_adic,$mprestaciones,$tprestaciones,0,$tadelanto,$sprestaciones,$minteres,$interes_noacum,$interes_acum,0,$tinteres,$mtasa,$mtiempo,$mtotal,$num_dias,$num_dias_adic,$mpresta_adic)==0){$p=1;$mcontinua=0;$num_dias=0;$mprestaciones=0;$fecha_c=nextDate($fecha_c,1);$fecha_mes=$fecha_c;}else{$mcontinua=1;}
        }}
	 }	 
     $fecha_m=nextDate($fecha_hasta,1); $fecha_hasta=colocar_udiames($fecha_m);  $fm=FDate($tfechah); $fh=FDate($fecha_hasta);
	 //echo $fecha_m." ".$fecha_hasta." ".$fm." ".$fh,"<br>"; 
   }
return $p;}

function procesar_prestaciones_mes() {global $p,$tfechah,$cod_empleado,$fechah,$fecha_c,$fecha_ingreso,$dep_tercer_mes,$dias_adic_primer,$sueldo_adic,$valor_formula,$fecha_ley,$fecha_dep_ley,$anos_cumplidos,$dep_diferencia,$acum_dias_adic,$prom_dias_adic,$acum_intereses,$acum_int_anual,$dep_dias_adic;
global $fecha_mes,$mprestaciones,$tprestaciones,$tadelanto,$sprestaciones,$interes_noacum,$tinteres,$interes_acum,$minteres,$mtasa,$mtotal,$monto_sueldo,$mtiempo;
  $p=0; $anos_cumplidos=0; $fecha_max=$tfechah; $fecha_max=formato_aaaammdd($fecha_max); $fecha_l=formato_aaaammdd($fecha_ley);  $fecha_ing=formato_ddmmaaaa($fecha_ingreso);  $m1=FDate($fecha_ing); $m2=FDate($fecha_ley); $mcontinua=1;
  $sSQL="Select max(fecha_Hasta) as fecha from NOM021 where fecha_hasta<='$fechah'"; $resultado=pg_query($sSQL); if($registro=pg_fetch_array($resultado,0)){$fecha_max=$registro["fecha"];}
  $StrSQL= "SELECT fecha_calculo,Sueldo_calculo,total_prestaciones,total_adelanto,saldo_prestaciones,acumulado_total,total_interes,interes_acum,interes_noacum from NOM030 Where (cod_empleado='$cod_empleado') Order by fecha_calculo desc,num_calculo desc"; $resultado=pg_query($StrSQL);
  if($registro=pg_fetch_array($resultado,0)){ $primera_fecha=$fecha_ingreso;  $fecha_umov=$registro["fecha_calculo"]; $fecha_c=formato_ddmmaaaa($registro["fecha_calculo"]); $monto_sueldo=$registro["sueldo_calculo"];
  $tprestaciones=$registro["total_prestaciones"]; $tadelanto=$registro["total_adelanto"]; $sprestaciones=$registro["saldo_prestaciones"]; $mtotal=$registro["acumulado_total"];
  $tinteres=$registro["total_interes"]; $interes_acum=$registro["interes_acum"]; $interes_noacum=$registro["interes_noacum"];
  $num_dias=0; $mprestaciones=0; $num_dias_adic=0; $mpresta_adic=0; $minteres=0; $mtasa=0; $mtiempo=0; $mcontinua=0;}
  if($mcontinua==0){ if($fecha_ingreso>$fecha_l){$fecha_ing=formato_ddmmaaaa($fecha_ingreso);} else{$sdia=substr($fecha_ing,0,2); if($sdia=="31"){$sdia="30";} $fecha_ing=$sdia.substr($fecha_ley,2,8);} }
   else{ $fecha_mes=$fecha_ing; if($fecha_ing==$fecha_ley){$fecha_mes=$fecha_dep_ley;}  $monto_sueldo=Asigna_Sueldo($fecha_mes); $fecha_m=formato_aaaammdd($fecha_mes);
    if(($monto_sueldo!=0)and($fecha_max>=$fecha_m)){ $fecha_c=$fecha_mes; $num_dias=5; $mprestaciones=($monto_sueldo/30)*$num_dias;  $tprestaciones=$mprestaciones; $sprestaciones=$mprestaciones; $mtotal=$mprestaciones;
     $num_dias_adic=0; $mpresta_adic=0; $tadelanto=0; $tinteres=0; $interes_acum=0; $interes_noacum=0; $minteres=0; $mtasa=0; $mtiempo=0; $primera_fecha=$fecha_c;
     if(Grabar_Prestaciones($fecha_c,'P',$monto_sueldo,$sueldo_adic,$mprestaciones,$tprestaciones,0,$tadelanto,$sprestaciones,$minteres,$interes_noacum,$interes_acum,0,$tinteres,$mtasa,$mtiempo,$mtotal,$num_dias,$num_dias_adic,$mpresta_adic)==0){$mcontinua=0;$fechab=formato_aaaammdd($fecha_mes);
       $sSQL="SELECT fecha_desde,fecha_hasta,tasa FROM NOM021 Where fecha_hasta>='$fechab' and fecha_hasta<='$fechah' order by fecha_hasta"; $res21=pg_query($sSQL); if($reg21=pg_fetch_array($res21,0)){$fecha_c=formato_ddmmaaaa($reg21["fecha_hasta"]); $mtasa=$reg21["tasa"]; } $m1=FDate($fecha_c); $m2=FDate($fecha_mes);  $mtiempo=$m1-$m2;
       if($mtiempo>=1){ $minteres=(($mtotal*$mtiempo*$mtasa)/$valor_formula); $minteres=Round($minteres,2); $interes_noacum=$interes_noacum+$minteres; $num_dias=0; $mprestaciones=0; $num_dias_adic=0; $mpresta_adic=0; $tprestaciones=$tprestaciones+$mprestaciones+$mpresta_adic; $tadelanto=$tadelanto; $sprestaciones=$tprestaciones-$tadelanto; $interes_noacum=$interes_noacum; $tinteres=$interes_acum+$interes_noacum; $mtotal=$sprestaciones+$interes_acum;
         if(Grabar_Prestaciones($fecha_c,'C',$monto_sueldo,$sueldo_adic,$mprestaciones,$tprestaciones,0,$tadelanto,$sprestaciones,$minteres,$interes_noacum,$interes_acum,0,$tinteres,$mtasa,$mtiempo,$mtotal,$num_dias,$num_dias_adic,$mpresta_adic)==0){$mcontinua=0; $p=1;
           if($fecha_ingreso>$fecha_l){$fecha_ing=formato_ddmmaaaa($fecha_ingreso);} else{$sdia=substr($fecha_ing,0,2); if($sdia=="31"){$sdia="30";} $fecha_ing=$sdia.substr($fecha_ley,2,8);}
         }else{$mcontinua=1;}
       }
     }else{$mcontinua=1;}
    }
   }
  if($mcontinua==0){ $fecha_mes=$fecha_c; $fechab=formato_aaaammdd($fecha_mes);
    $sSQL="SELECT fecha_desde,fecha_hasta,tasa FROM NOM021 Where fecha_hasta>'$fechab' and fecha_hasta<='$fechah' order by fecha_hasta"; $res21=pg_query($sSQL);
    while(($reg21=pg_fetch_array($res21))and($mcontinua==0)){ $fecha_max=$reg21["fecha_desde"]; $fecha_desde=$reg21["fecha_desde"]; $fecha_hasta=$reg21["fecha_hasta"]; $num_dias=0; $mprestaciones=0; $num_dias_adic=0; $mpresta_adic=0;
     if(Cumple_Meses($fecha_ing,formato_ddmmaaaa($fecha_desde),formato_ddmmaaaa($fecha_hasta))==1) { $fecha_mes=$fecha_c; $num_dias=5; $num_dias_adic=0;
       if(Verifica_Antiguedad($fecha_ing)==1){  if($dias_adic_primer=="S"){$ma_cumplido=$anos_cumplidos;}else{$ma_cumplido=$anos_cumplidos-1;} $mopa=$ma_cumplido*2;
         if($mopa<30){ $num_dias=5;  if($acum_dias_adic=="N"){$num_dias_adic=$mopa;}else{if($ma_cumplido>0){$num_dias_adic=2;}} }
          else{ $num_dias=5; if($acum_dias_adic=="N"){$num_dias_adic=30;}else{$num_dias_adic=2;} } if($dep_dias_adic=="N"){ $num_dias_adic=0;}
         //if(($dep_diferencia=="S")and($anos_cumplidos=1)){ if($dep_tercer_mes=="S"){$num_dias=$num_dias+10;}else{$num_dias=$num_dias+15;} }
		 if($dep_dias_adic=="N"){$num_dias_adic=0;}
       } $mtasa=$reg21["tasa"]; $m1=FDate($fecha_mes); $m2=FDate(formato_ddmmaaaa($fecha_desde));  $mtiempo=$m1-$m2+1;
       $minteres=(($mtotal*$mtiempo*$mtasa)/$valor_formula); $minteres=Round($minteres,2);  $interes_noacum=$interes_noacum+$minteres;
       $monto_sueldo=Asigna_Sueldo($fecha_mes); If(($num_dias_adic!=0)and($prom_dias_adic== "S")){$sueldo_adic=Asigna_Sueldo_Promedio($fecha_mes);}
       if(($monto_sueldo==0) Or ($mtiempo<1)){$mcontinua=1;}
        else{ $mprestaciones=($monto_sueldo/30)*$num_dias;  $mpresta_adic=($sueldo_adic/30)*$num_dias_adic;
        //verifica anticipos y pagos
		$mfecha_d=$fecha_desde; $mfecha_h=$fecha_mes;
		if(Verifica_Anticipo($mfecha_d,$mfecha_h)==1){ $fecha_desde=$fecha_c; $fecha_c=$fecha_mes;}
		else{ if (Verifica_Pago_Intereses($mfecha_d,$mfecha_h)==1){ $fecha_desde=$fecha_c; $fecha_c=$fecha_mes; } }		
        if($mcontinua==0){ $tprestaciones=$tprestaciones+$mprestaciones+$mpresta_adic; $tadelanto=$tadelanto; $sprestaciones=$tprestaciones-$tadelanto;
          if(substr($fecha_c,0,5)==substr($fecha_ing,0,5)){ if(Verifica_Antiguedad($fecha_ing)==1){$anos_cumplidos=$anos_cumplidos;} }
          if((($num_dias!=5)or($anos_cumplidos!=0)or($acum_intereses=="S"))and($acum_int_anual=="S")){$interes_acum=$interes_acum+$interes_noacum;$interes_noacum=0;}
          $tinteres=$interes_acum+$interes_noacum; $mtotal=$sprestaciones+$interes_acum;
          if(Grabar_Prestaciones($fecha_c,'P',$monto_sueldo,$sueldo_adic,$mprestaciones,$tprestaciones,0,$tadelanto,$sprestaciones,$minteres,$interes_noacum,$interes_acum,0,$tinteres,$mtasa,$mtiempo,$mtotal,$num_dias,$num_dias_adic,$mpresta_adic)==0){$p=1;$mcontinua=0;$num_dias=0;$mprestaciones=0;$fecha_c=nextDate($fecha_c,1);$fecha_mes=$fecha_c;}else{$mcontinua=1;}
        }}
     }else{$fecha_c=formato_ddmmaaaa($fecha_desde); $fecha_mes=$fecha_c;}
     if(($mcontinua==0)and(formato_ddmmaaaa($fecha_c)<$fecha_hasta)){$mtasa=$reg21["tasa"]; $m2=FDate($fecha_mes); $m1=FDate(formato_ddmmaaaa($fecha_hasta));  $mtiempo=$m1-$m2+1;
      $minteres=(($mtotal*$mtiempo*$mtasa)/$valor_formula); $minteres=Round($minteres,2);  $interes_noacum=$interes_noacum+$minteres; $num_dias_adic=0; $mpresta_adic=0;
      if(($monto_sueldo==0) Or ($mtiempo<1)){$mcontinua=1;}
       else{ //verifica anticipos y pagos
	    $mfecha_d=$fecha_mes; $mfecha_h=$fecha_hasta;
	    if(Verifica_Anticipo($mfecha_d,$mfecha_h)==1){ $fecha_desde=$fecha_c; $fecha_c=$fecha_hasta;}
		else{ if (Verifica_Pago_Intereses($mfecha_d,$mfecha_h)==0){ $fecha_desde=$fecha_c; $fecha_c=$fecha_hasta; } }
        $tprestaciones=$tprestaciones; $tadelanto=$tadelanto; $sprestaciones=$tprestaciones-$tadelanto;  $tinteres=$interes_acum+$interes_noacum; $mtotal=$sprestaciones+$interes_acum;  $fecha_c=formato_ddmmaaaa($fecha_hasta);
        if(Grabar_Prestaciones($fecha_c,'C',$monto_sueldo,$sueldo_adic,$mprestaciones,$tprestaciones,0,$tadelanto,$sprestaciones,$minteres,$interes_noacum,$interes_acum,0,$tinteres,$mtasa,$mtiempo,$mtotal,$num_dias,$num_dias_adic,$mpresta_adic)==0){$mcontinua=0; $p=1;}else{$mcontinua=1;}
       }
     }
    }
  }
return $p;}
function procesar_prestaciones2() {global $p,$tfechah,$cod_empleado,$fechah,$fecha_c,$fecha_ingreso,$dep_tercer_mes,$dias_adic_primer,$sueldo_adic,$valor_formula,$fecha_ley,$fecha_dep_ley,$anos_cumplidos,$dep_diferencia,$acum_dias_adic,$prom_dias_adic,$acum_intereses,$acum_int_anual,$dep_dias_adic,$fecha_i_tope;
global $fecha_mes,$mprestaciones,$tprestaciones,$tadelanto,$sprestaciones,$interes_noacum,$tinteres,$interes_acum,$minteres,$mtasa,$mtotal,$monto_sueldo,$mtiempo;
  $p=0; $anos_cumplidos=0; $fecha_max=$tfechah; $fecha_max=formato_aaaammdd($fecha_max); $fecha_l=formato_aaaammdd($fecha_ley);  $fecha_ing=formato_ddmmaaaa($fecha_ingreso);  $m1=FDate($fecha_ing); $m2=FDate($fecha_ley); $mcontinua=1;
  if($m1<$m2){$num_dias=$m2-$m1; if($num_dias<180){ if($dep_tercer_mes=="S"){ if(substr($fecha_ingreso,8,2)=="31"){$fecha_ing="30/09".substr($fecha_ley,5,5);}else{$fecha_ing=substr($fecha_ingreso,8,2)."/09".substr($fecha_ley,5,5);}} else{$fecha_ing=substr($fecha_ingreso,8,2)."/10".substr($fecha_ley,5,5);} } else{$fecha_ing=$fecha_ley;}}
   else{ $fecha_ing=$fecha_ing;}  $cant_mes_dep=3; $tmesp=0; $mesi=0;
  $StrSQL= "SELECT fecha_calculo,Sueldo_calculo,total_prestaciones,total_adelanto,saldo_prestaciones,acumulado_total,total_interes,interes_acum,interes_noacum from NOM030 Where (cod_empleado='$cod_empleado') Order by fecha_calculo desc,num_calculo desc"; $resultado=pg_query($StrSQL);
  if($registro=pg_fetch_array($resultado,0)){ $primera_fecha=$fecha_ingreso;  $fecha_umov=$registro["fecha_calculo"]; $fecha_c=formato_ddmmaaaa($registro["fecha_calculo"]); $monto_sueldo=$registro["sueldo_calculo"];
  $tprestaciones=$registro["total_prestaciones"]; $tadelanto=$registro["total_adelanto"]; $sprestaciones=$registro["saldo_prestaciones"]; $mtotal=$registro["acumulado_total"];
  $tinteres=$registro["total_interes"]; $interes_acum=$registro["interes_acum"]; $interes_noacum=$registro["interes_noacum"];
  $num_dias=0; $mprestaciones=0; $num_dias_adic=0; $mpresta_adic=0; $minteres=0; $mtasa=0; $mtiempo=0; $mcontinua=0;  if(($fecha_umov=="2012-04-30")or($fecha_umov=="2012-05-31")){ $cant_mes_dep=2; }  }
  //echo $mcontinua,"<br>";
  if($mcontinua==0){ if($fecha_ingreso>$fecha_l){$fecha_ing=formato_ddmmaaaa($fecha_ingreso);} else{$sdia=substr($fecha_ing,0,2); if($sdia=="31"){$sdia="30";} $fecha_ing=$sdia.substr($fecha_ley,2,8);} }
   else{ $fecha_mes=$fecha_ing; $m1=FDate($fecha_ing); $m2=FDate($fecha_i_tope); $fecha_c=$fecha_mes;
	if($m1<$m2){ $mcontinua=1; $error=1;?><script language="JavaScript">muestra('FECHA CALCULO DE PRESTACIONES INVALIDA PARA EL TRABAJADOR <? echo $cod_empleado; ?>');</script><?}
	else{  $mesh=substr($tfechah,3,2); if(($mesh=="03")or($mesh=="06")or($mesh=="09")or($mesh=="12")) { $mcontinua=0; } else { $mcontinua=1; }  }
	if($mcontinua==0){ $fecha_t="2012-06-30";
	   $cant_mes_dep=2;	$mesi=substr($fecha_ing,3,2); $mesi=$mesi*1; $tmesp=4-$mesi; $cant_mes_dep=$cant_mes_dep+$tmesp;
	   //if($fecha_ingreso>$fecha_t){ $cant_mes_dep=3;} 
	   }
   }
   $fecha_m=nextDate($fecha_c,1); 
   $fecha_hasta=colocar_udiames($fecha_m);  $fm=FDate($tfechah); $fh=FDate($fecha_hasta); 
   //echo $fecha_ing." ".$fecha_hasta." ".$tfechah." ".$fm." ".$fh." ".$cant_mes_dep." ".$tmesp." ".$mesi,"<br>";   
   while(($fm>=$fh)and($mcontinua==0)){ $fecha_desde=colocar_pdiames($fecha_hasta);
     $num_dias=0; $mprestaciones=0; $num_dias_adic=0; $mpresta_adic=0; $minteres=0; $mtasa=0; $mtiempo=0;
	 if(Cumple_Meses($fecha_ing,$fecha_desde,$fecha_hasta)==1) { 
	    //$fecha_c=$fecha_hasta; 
		$fecha_mes=$fecha_c; $num_dias=5; $num_dias_adic=0;
	   $mesh=substr($fecha_hasta,3,2); if(($mesh=="03")or($mesh=="06")or($mesh=="09")or($mesh=="12")) { $num_dias=5*$cant_mes_dep;} else { $num_dias=0;}
	   if(Verifica_Antiguedad($fecha_ing)==1){  
	     if($dias_adic_primer=="S"){$ma_cumplido=$anos_cumplidos;}else{$ma_cumplido=$anos_cumplidos-1;}  $mopa=$ma_cumplido*2;
         if($mopa<30){  if($acum_dias_adic=="N"){$num_dias_adic=$mopa;}else{if($ma_cumplido>0){$num_dias_adic=2;}} }
          else{  if($acum_dias_adic=="N"){$num_dias_adic=30;}else{$num_dias_adic=2;} } if($dep_dias_adic=="N"){ $num_dias_adic=0;}         
		 //echo $fecha_ing." ".$fecha_desde." ".$fecha_hasta." ".$ma_cumplido." ".$mopa." ".$dep_dias_adic." ".$num_dias_adic,"<br>";		 
		 //if(($dep_diferencia=="S")and($anos_cumplidos=1)){ if($dep_tercer_mes=="S"){$num_dias=$num_dias+10;}else{$num_dias=$num_dias+15;} }		 
		 if($dep_dias_adic=="N"){$num_dias_adic=0;}
       }  $fecha_c=$fecha_hasta; $fecha_mes=$fecha_c; 	   
	   $mtasa=0; $m1=FDate($fecha_mes); $m2=FDate($fecha_desde);  $mtiempo=$m1-$m2+1;
       $minteres=(($mtotal*$mtiempo*$mtasa)/$valor_formula); $minteres=Round($minteres,2);  $interes_noacum=$interes_noacum+$minteres;
       $monto_sueldo=Asigna_Sueldo($fecha_mes); If(($num_dias_adic!=0)and($prom_dias_adic=="S")){$sueldo_adic=Asigna_Sueldo_Promedio($fecha_mes);}
	   $dm=diferencia_meses($fecha_ing,$fecha_c); $dd=diferencia_dias($fecha_ing,$fecha_c);
	   if($dm==0){  if($dd>=1){$dm=1;} } else{ if($dm<3){ $dm=$dm+1; } }
		   
	   if(($num_dias>=15)and($dm<3)){ $dm=round($dm,0); $num_dias=5*$dm;}
	   //echo $fecha_ing." ".$fecha_desde." ".$fecha_hasta." ".$fecha_c." ".$dm,"<br>";
       if($mtiempo<1){$mcontinua=1;}
        else{ $mprestaciones=($monto_sueldo/30)*$num_dias;  $mpresta_adic=($sueldo_adic/30)*$num_dias_adic;
	    //verifica anticipos y pagos
		$mfecha_d=$fecha_desde; $mfecha_h=$fecha_hasta;
		if(Verifica_Anticipo($mfecha_d,$mfecha_h)==1){ $fecha_desde=$fecha_c; $fecha_c=$fecha_hasta;}		
        if($mcontinua==0){ $tprestaciones=$tprestaciones+$mprestaciones+$mpresta_adic; $tadelanto=$tadelanto; $sprestaciones=$tprestaciones-$tadelanto;          
		  if(substr($fecha_c,0,5)==substr($fecha_ing,0,5)){ if(Verifica_Antiguedad($fecha_ing)==1){$anos_cumplidos=$anos_cumplidos;} }          
		  if((($num_dias!=5)or($anos_cumplidos!=0)or($acum_intereses=="S"))and($acum_int_anual=="S")){$interes_acum=$interes_acum+$interes_noacum;$interes_noacum=0;}
          $tinteres=$interes_acum+$interes_noacum; $mtotal=$sprestaciones+$interes_acum; $m1=FDate($fecha_c); $m2=FDate($fecha_desde);  $mtiempo=$m1-$m2+1;
          if(Grabar_Prestaciones($fecha_c,'P',$monto_sueldo,$sueldo_adic,$mprestaciones,$tprestaciones,0,$tadelanto,$sprestaciones,$minteres,$interes_noacum,$interes_acum,0,$tinteres,$mtasa,$mtiempo,$mtotal,$num_dias,$num_dias_adic,$mpresta_adic)==0){$p=1;$mcontinua=0;$num_dias=0;$mprestaciones=0;$fecha_c=nextDate($fecha_c,1);$fecha_mes=$fecha_c;}else{$mcontinua=1;}
        }}
	 }	 
     $fecha_m=nextDate($fecha_hasta,1); $fecha_hasta=colocar_udiames($fecha_m);  $fm=FDate($tfechah); $fh=FDate($fecha_hasta);
	 //echo $fecha_m." ".$fecha_hasta." ".$fm." ".$fh,"<br>"; 
   }
return $p;}
function Calcula_dif_fechas_p($fechad,$fechah){
$dia_desde=substr($fechad,0,2)*1; $mes_desde=substr($fechad,3,2)*1; $ano_desde=substr($fechad,6,4)*1;
$dia_hasta=substr($fechah,0,2)*1; $mes_hasta=substr($fechah,3,2)*1; $ano_hasta=substr($fechah,6,4)*1;
$mes_desde_max = date ("t",mktime (0,0,0,$mes_desde,$dia_desde,$ano_desde));
$dia_dif=$mes_desde_max-$dia_desde; $mes_dif=12-$mes_desde-1; $dia_ini=1;  $mes_ini=1; $ano_ini=$ano_desde+1;
$dia_diferencia = ($dia_hasta - $dia_ini) + 1; $mes_diferencia = ($mes_hasta - $mes_ini) + 1; $ano_diferencia = ($ano_hasta - $ano_ini);
$dia_diferencia = $dia_diferencia + $dia_dif;  $mes_diferencia = $mes_diferencia + $mes_dif;
if ($dia_diferencia >= $mes_desde_max){$dia_diferencia = $dia_diferencia - $mes_desde_max; $mes_diferencia = $mes_diferencia + 1;}
if ($mes_diferencia >= 12){$mes_diferencia = $mes_diferencia - 12; $ano_diferencia = $ano_diferencia + 1; }
if($dia_desde=="01"){}
//if((($dia_desde=="30")or($dia_hasta=="31") ) and ( ($mes_hasta=='04' or $mes_hasta=='06' or $mes_hasta=='09' or $mes_hasta=='11') )){  $mes_diferencia=$mes_diferencia+1; $dia_diferencia=0; }
//if((($dia_desde=="31")or($dia_hasta=="30") ) and ( ($mes_hasta=='04' or $mes_hasta=='06' or $mes_hasta=='09' or $mes_hasta=='11') )){  $mes_diferencia=$mes_diferencia+1; $dia_diferencia=0; }
if($mes_diferencia==13){ $mes_diferencia=0; $ano_diferencia=$ano_diferencia+1; }
$l=strlen($ano_diferencia); $ano_diferencia=substr("0000",0,4-$l).$ano_diferencia; $l=strlen($mes_diferencia); $mes_diferencia=substr("00",0,2-$l).$mes_diferencia;
$r=$ano_diferencia.$mes_diferencia.$dia_diferencia; return $r;
}
function procesar_prestaciones3() {global $p,$tfechah,$cod_empleado,$fechah,$fecha_c,$fecha_ingreso,$dep_tercer_mes,$dias_adic_primer,$sueldo_adic,$valor_formula,$fecha_ley,$fecha_dep_ley,$anos_cumplidos,$dep_diferencia,$acum_dias_adic,$prom_dias_adic,$acum_intereses,$acum_int_anual,$dep_dias_adic,$fecha_i_tope;
global $fecha_mes,$mprestaciones,$tprestaciones,$tadelanto,$sprestaciones,$interes_noacum,$tinteres,$interes_acum,$minteres,$mtasa,$mtotal,$monto_sueldo,$mtiempo;
  $fecha_c_tope="31/12/2012";
  $p=0; $anos_cumplidos=0; $fecha_max=$tfechah; $fecha_max=formato_aaaammdd($fecha_max); $fecha_l=formato_aaaammdd($fecha_ley);  $fecha_ing=formato_ddmmaaaa($fecha_ingreso);  $m1=FDate($fecha_ing); $m2=FDate($fecha_ley); $mcontinua=1;
  if($m1<$m2){$num_dias=$m2-$m1; if($num_dias<180){ if($dep_tercer_mes=="S"){ if(substr($fecha_ingreso,8,2)=="31"){$fecha_ing="30/09".substr($fecha_ley,5,5);}else{$fecha_ing=substr($fecha_ingreso,8,2)."/09".substr($fecha_ley,5,5);}} else{$fecha_ing=substr($fecha_ingreso,8,2)."/10".substr($fecha_ley,5,5);} } else{$fecha_ing=$fecha_ley;}}
   else{ $fecha_ing=$fecha_ing;}  $cant_mes_dep=3; $tmesp=0; $mesi=0;
  $StrSQL= "SELECT fecha_calculo,Sueldo_calculo,total_prestaciones,total_adelanto,saldo_prestaciones,acumulado_total,total_interes,interes_acum,interes_noacum,dias_prestaciones from NOM030 Where (cod_empleado='$cod_empleado') Order by fecha_calculo desc,num_calculo desc"; $resultado=pg_query($StrSQL);
  if($registro=pg_fetch_array($resultado,0)){ $primera_fecha=$fecha_ingreso;  $fecha_umov=$registro["fecha_calculo"]; $fecha_c=formato_ddmmaaaa($registro["fecha_calculo"]); $monto_sueldo=$registro["sueldo_calculo"];
  $tprestaciones=$registro["total_prestaciones"]; $tadelanto=$registro["total_adelanto"]; $sprestaciones=$registro["saldo_prestaciones"]; $mtotal=$registro["acumulado_total"];
  $tinteres=$registro["total_interes"]; $interes_acum=$registro["interes_acum"]; $interes_noacum=$registro["interes_noacum"]; $dias_prestaciones=$registro["dias_prestaciones"];
  $num_dias=0; $mprestaciones=0; $num_dias_adic=0; $mpresta_adic=0; $minteres=0; $mtasa=0; $mtiempo=0; $mcontinua=0;  if(($fecha_umov=="2012-04-30")or($fecha_umov=="2012-05-31")){ $cant_mes_dep=2; }  
  $fecha_up=$fecha_ing; if($dias_prestaciones>0){ $fecha_up=$fecha_c; }
  else{ $StrSQL= "SELECT fecha_calculo from NOM030 Where (cod_empleado='$cod_empleado') and (dias_prestaciones>0) Order by fecha_calculo desc,num_calculo desc"; $resultado=pg_query($StrSQL);
  if($registro=pg_fetch_array($resultado,0)){   $fecha_up=formato_ddmmaaaa($registro["fecha_calculo"]); } }
  }
  //echo $mcontinua." ".$fecha_c,"<br>";
  if($mcontinua==0){ if($fecha_ingreso>$fecha_l){$fecha_ing=formato_ddmmaaaa($fecha_ingreso);} else{$sdia=substr($fecha_ing,0,2); if($sdia=="31"){$sdia="30";} $fecha_ing=$sdia.substr($fecha_ley,2,8);} }
   else{ $fecha_mes=$fecha_ing; $m1=FDate($fecha_ing); $m2=FDate($fecha_i_tope); $fecha_c=$fecha_mes;
	if($m1<$m2){ $mcontinua=1; $error=1;?><script language="JavaScript">muestra('FECHA CALCULO DE PRESTACIONES INVALIDA PARA EL TRABAJADOR <? echo $cod_empleado; ?>');</script><?}
	else{  $mesh=substr($tfechah,3,2); 	     //if(($mesh=="03")or($mesh=="06")or($mesh=="09")or($mesh=="12")) { $mcontinua=0; } else { $mcontinua=1; } 
	    $periodof=Calcula_dif_fechas_p($fecha_ing,$tfechah); $ant_ano=substr($periodof,0,4); $ant_mes=substr($periodof,4,2); $ant_dia=substr($periodof,6,2);
		$tmes=$ant_mes*1; $tdia=$ant_dia*1; 
		//echo $fecha_ing." ".$tfechah." ".$periodof." ".$ant_mes." ".$tmes,"<br>";
	    if(($tmes==3)) { $mcontinua=0; } else { $mcontinua=1; } 	
		$fecha_up=$fecha_ing;
	}
	//if($mcontinua==0){ $fecha_t="2012-06-30";  $cant_mes_dep=2;	$mesi=substr($fecha_ing,3,2); $mesi=$mesi*1; $tmesp=4-$mesi; $cant_mes_dep=$cant_mes_dep+$tmesp;	   if($fecha_ingreso>$fecha_t){ $cant_mes_dep=3;} }
   }
   $fecha_m=nextDate($fecha_c,1);  $fecha_hasta=colocar_udiames($fecha_m);  $fm=FDate($tfechah); $fh=FDate($fecha_hasta); 
   //echo $fecha_ing." ".$fecha_hasta." ".$tfechah." ".$fm." ".$fh." ".$cant_mes_dep." ".$tmesp." ".$mesi." ".$mcontinua,"<br>"; 
   $procesa_trim=0;
   $tfecha_ing=$fecha_ing; $m1=FDate($fecha_ing); $m2=FDate($fecha_c_tope); if($m1<$m2){ $procesa_trim=1; }   
   while(($fm>=$fh)and($mcontinua==0)){ $fecha_desde=colocar_pdiames($fecha_hasta);
     $num_dias=0; $mprestaciones=0; $num_dias_adic=0; $mpresta_adic=0; $minteres=0; $mtasa=0; $mtiempo=0;
	 if(Cumple_Meses($tfecha_ing,$fecha_desde,$fecha_hasta)==1) { 
	    //$fecha_c=$fecha_hasta; 
	   $fecha_mes=$fecha_c; $num_dias=0; $num_dias_adic=0;		
	   $mesh=substr($fecha_hasta,3,2); 
	   if($procesa_trim==1){ if(($mesh=="03")or($mesh=="06")or($mesh=="09")or($mesh=="12")) { $num_dias=5*$cant_mes_dep;} else { $num_dias=0;}	}  
	   else{ $periodof=Calcula_dif_fechas_p($fecha_up,$fecha_c); $ant_ano=substr($periodof,0,4); $ant_mes=substr($periodof,4,2); $ant_dia=substr($periodof,6,2);
	   $num_mes=$ant_mes*1; if( ($num_mes%3==0)and($num_mes<>0)){  $num_dias=15; }    }
	   if(Verifica_Antiguedad($fecha_ing)==1){  
	     if($dias_adic_primer=="S"){$ma_cumplido=$anos_cumplidos;}else{$ma_cumplido=$anos_cumplidos-1;}  $mopa=$ma_cumplido*2;
         if($mopa<30){  if($acum_dias_adic=="N"){$num_dias_adic=$mopa;}else{if($ma_cumplido>0){$num_dias_adic=2;}} }
          else{  if($acum_dias_adic=="N"){$num_dias_adic=30;}else{$num_dias_adic=2;} } if($dep_dias_adic=="N"){ $num_dias_adic=0;}         
		 //echo $fecha_ing." ".$fecha_desde." ".$fecha_hasta." ".$ma_cumplido." ".$mopa." ".$dep_dias_adic." ".$num_dias_adic,"<br>";		 
		 //if(($dep_diferencia=="S")and($anos_cumplidos=1)){ if($dep_tercer_mes=="S"){$num_dias=$num_dias+10;}else{$num_dias=$num_dias+15;} }		 
		 if($dep_dias_adic=="N"){$num_dias_adic=0;}
       }  $fecha_c=$fecha_hasta; $fecha_mes=$fecha_c; 	   
	   $mtasa=0; $m1=FDate($fecha_mes); $m2=FDate($fecha_desde);  $mtiempo=$m1-$m2+1;
       $minteres=(($mtotal*$mtiempo*$mtasa)/$valor_formula); $minteres=Round($minteres,2);  $interes_noacum=$interes_noacum+$minteres;
       $monto_sueldo=Asigna_Sueldo($fecha_mes); If(($num_dias_adic!=0)and($prom_dias_adic=="S")){$sueldo_adic=Asigna_Sueldo_Promedio($fecha_mes);}
	   $dm=diferencia_meses($fecha_up,$fecha_c);
	   //if(($num_dias==15)and($dm==3)){ $dm=round($dm,0); $num_dias=5*$dm;}
	   if($dm==3){ $dm=round($dm,0); $num_dias=5*$dm;}
	  // echo $fecha_ing." ".$fecha_desde." ".$fecha_hasta." ".$fecha_c." ".$dm." ".$num_mes." ".$fecha_up,"<br>";
       if($mtiempo<1){$mcontinua=1;}
        else{ $mprestaciones=($monto_sueldo/30)*$num_dias;  $mpresta_adic=($sueldo_adic/30)*$num_dias_adic;
	    //verifica anticipos y pagos
		$mfecha_d=$fecha_desde; $mfecha_h=$fecha_hasta;
		if(Verifica_Anticipo($mfecha_d,$mfecha_h)==1){ $fecha_desde=$fecha_c; $fecha_c=$fecha_hasta;}		
        if($mcontinua==0){ $tprestaciones=$tprestaciones+$mprestaciones+$mpresta_adic; $tadelanto=$tadelanto; $sprestaciones=$tprestaciones-$tadelanto;          
		  if(substr($fecha_c,0,5)==substr($fecha_ing,0,5)){ if(Verifica_Antiguedad($fecha_ing)==1){$anos_cumplidos=$anos_cumplidos;} }          
		  if((($num_dias!=5)or($anos_cumplidos!=0)or($acum_intereses=="S"))and($acum_int_anual=="S")){$interes_acum=$interes_acum+$interes_noacum;$interes_noacum=0;}
          $tinteres=$interes_acum+$interes_noacum; $mtotal=$sprestaciones+$interes_acum; $m1=FDate($fecha_c); $m2=FDate($fecha_desde);  $mtiempo=$m1-$m2+1;		  
          if(Grabar_Prestaciones($fecha_c,'P',$monto_sueldo,$sueldo_adic,$mprestaciones,$tprestaciones,0,$tadelanto,$sprestaciones,$minteres,$interes_noacum,$interes_acum,0,$tinteres,$mtasa,$mtiempo,$mtotal,$num_dias,$num_dias_adic,$mpresta_adic)==0){$p=1;$mcontinua=0;$num_dias=0;$mprestaciones=0;$fecha_c=nextDate($fecha_c,1);$fecha_mes=$fecha_c;}else{$mcontinua=1;}		  
        }}
	 }	 
     $fecha_m=nextDate($fecha_hasta,1); $fecha_hasta=colocar_udiames($fecha_m);  $fm=FDate($tfechah); $fh=FDate($fecha_hasta);
	 //echo $fecha_m." ".$fecha_hasta." ".$fm." ".$fh,"<br>"; 
   }
return $p;}

function procesar_prestaciones_mes2() {global $p,$tfechah,$cod_empleado,$fechah,$fecha_c,$fecha_ingreso,$dep_tercer_mes,$dias_adic_primer,$sueldo_adic,$valor_formula,$fecha_ley,$fecha_dep_ley,$anos_cumplidos,$dep_diferencia,$acum_dias_adic,$prom_dias_adic,$acum_intereses,$acum_int_anual,$dep_dias_adic;
global $fecha_mes,$mprestaciones,$tprestaciones,$tadelanto,$sprestaciones,$interes_noacum,$tinteres,$interes_acum,$minteres,$mtasa,$mtotal,$monto_sueldo,$mtiempo,$dias_dep_mes;
  $dep_dias_adic="N";
  $p=0; $anos_cumplidos=0; $fecha_max=$tfechah; $fecha_max=formato_aaaammdd($fecha_max); $fecha_l=formato_aaaammdd($fecha_ley);  $fecha_ing=formato_ddmmaaaa($fecha_ingreso);  $m1=FDate($fecha_ing); $m2=FDate($fecha_ley); $mcontinua=1;
  $StrSQL= "SELECT fecha_calculo,Sueldo_calculo,total_prestaciones,total_adelanto,saldo_prestaciones,acumulado_total,total_interes,interes_acum,interes_noacum from NOM030 Where (cod_empleado='$cod_empleado') Order by fecha_calculo desc,num_calculo desc"; $resultado=pg_query($StrSQL);
  if($registro=pg_fetch_array($resultado,0)){ $primera_fecha=$fecha_ingreso;  $fecha_umov=$registro["fecha_calculo"]; $fecha_c=formato_ddmmaaaa($registro["fecha_calculo"]); $monto_sueldo=$registro["sueldo_calculo"];
  $tprestaciones=$registro["total_prestaciones"]; $tadelanto=$registro["total_adelanto"]; $sprestaciones=$registro["saldo_prestaciones"]; $mtotal=$registro["acumulado_total"];
  $tinteres=$registro["total_interes"]; $interes_acum=$registro["interes_acum"]; $interes_noacum=$registro["interes_noacum"];
  $num_dias=0; $mprestaciones=0; $num_dias_adic=0; $mpresta_adic=0; $minteres=0; $mtasa=0; $mtiempo=0; $mcontinua=0;}
 
  if($mcontinua==0){ if($fecha_ingreso>$fecha_l){$fecha_ing=formato_ddmmaaaa($fecha_ingreso);} else{$sdia=substr($fecha_ing,0,2); if($sdia=="31"){$sdia="30";} $fecha_ing=$sdia.substr($fecha_ley,2,8);} }
   else{ $fecha_mes=$fecha_ing; if($fecha_ing==$fecha_ley){$fecha_mes=$fecha_dep_ley;} $fecha_mes=nextmes($fecha_mes,1); $fecha_mes=colocar_udiames($fecha_mes);  $fecha_m=formato_aaaammdd($fecha_mes);
	$dm=diferencia_meses($fecha_ing,$fecha_mes);  //echo $cod_empleado." ".$fecha_mes." ".$monto_sueldo,"<br>";
	if(($fecha_max>=$fecha_m)and($dm>=1)){  $monto_sueldo=Asigna_Sueldo($fecha_mes); } else{ $monto_sueldo=0; $mcontinua=1;}	
	//if(($monto_sueldo!=0)and($fecha_max>=$fecha_m)){
	if($fecha_max>=$fecha_m){ $fecha_c=$fecha_mes; $num_dias=$dias_dep_mes; $mprestaciones=($monto_sueldo/30)*$num_dias;  $tprestaciones=$mprestaciones; $sprestaciones=$mprestaciones; $mtotal=$mprestaciones;
     $num_dias_adic=0; $mpresta_adic=0; $tadelanto=0; $tinteres=0; $interes_acum=0; $interes_noacum=0; $minteres=0; $mtasa=0; $mtiempo=0; $primera_fecha=$fecha_c; $fecha_umov=$fecha_c;
     if(Grabar_Prestaciones($fecha_c,'P',$monto_sueldo,$sueldo_adic,$mprestaciones,$tprestaciones,0,$tadelanto,$sprestaciones,$minteres,$interes_noacum,$interes_acum,0,$tinteres,$mtasa,$mtiempo,$mtotal,$num_dias,$num_dias_adic,$mpresta_adic)==0){$mcontinua=0; $p=1;}
		else{$mcontinua=1;}
    }
   }
   $fecha_m=nextDate($fecha_c,1); 
   $fecha_hasta=colocar_udiames($fecha_m);  $fm=FDate($tfechah); $fh=FDate($fecha_hasta);  
   while(($fm>=$fh)and($mcontinua==0)){ $fecha_desde=colocar_pdiames($fecha_hasta);
     $num_dias=0; $mprestaciones=0; $num_dias_adic=0; $mpresta_adic=0; $minteres=0; $mtasa=0; $mtiempo=0;
	 if(Cumple_Meses($fecha_ing,$fecha_desde,$fecha_hasta)==1) { 
	   //$fecha_c=$fecha_hasta; 
	   $fecha_mes=$fecha_c; $num_dias=$dias_dep_mes; $num_dias_adic=0;
	   //echo $fecha_ing." ".$fecha_desde." ".$fecha_hasta." ".$fecha_c,"<br>";
	   if(Verifica_Antiguedad($fecha_ing)==1){  if($dias_adic_primer=="S"){$ma_cumplido=$anos_cumplidos;}else{$ma_cumplido=$anos_cumplidos-1;}  $mopa=$ma_cumplido*2;
         if($mopa<30){ $num_dias=$dias_dep_mes;  if($acum_dias_adic=="N"){$num_dias_adic=$mopa;}else{if($ma_cumplido>0){$num_dias_adic=2;}} }
          else{ $num_dias=$dias_dep_mes; if($acum_dias_adic=="N"){$num_dias_adic=30;}else{$num_dias_adic=2;} } if($dep_dias_adic=="N"){ $num_dias_adic=0;}
         //if(($dep_diferencia=="S")and($anos_cumplidos=1)){ if($dep_tercer_mes=="S"){$num_dias=$num_dias+10;}else{$num_dias=$num_dias+15;} }
		 if($dep_dias_adic=="N"){$num_dias_adic=0;}
       } $fecha_c=$fecha_hasta; $fecha_mes=$fecha_c; $mtasa=0; $m1=FDate($fecha_mes); $m2=FDate($fecha_desde);  $mtiempo=$m1-$m2+1;
       $minteres=(($mtotal*$mtiempo*$mtasa)/$valor_formula); $minteres=Round($minteres,2);  $interes_noacum=$interes_noacum+$minteres;
       $monto_sueldo=Asigna_Sueldo($fecha_mes); If(($num_dias_adic!=0)and($prom_dias_adic== "S")){$sueldo_adic=Asigna_Sueldo_Promedio($fecha_mes);}
	   $dm=diferencia_meses($fecha_ing,$fecha_c); if($dm>=2){$mtiempo=$mtiempo;}else{$mtiempo=0;}
	   //echo $fecha_ing." ".$fecha_desde." ".$fecha_hasta." ".$fecha_c." ".$dm,"<br>";
       if($mtiempo<1){$mcontinua=1;}
        else{ $mprestaciones=($monto_sueldo/30)*$num_dias;  $mpresta_adic=($sueldo_adic/30)*$num_dias_adic;
	    //verifica anticipos y pagos
		$mfecha_d=$fecha_desde; $mfecha_h=$fecha_hasta;
		if(Verifica_Anticipo($mfecha_d,$mfecha_h)==1){ $fecha_desde=$fecha_c; $fecha_c=$fecha_hasta;}		
        if($mcontinua==0){ $tprestaciones=$tprestaciones+$mprestaciones+$mpresta_adic; $tadelanto=$tadelanto; $sprestaciones=$tprestaciones-$tadelanto;
          if(substr($fecha_c,0,5)==substr($fecha_ing,0,5)){ if(Verifica_Antiguedad($fecha_ing)==1){$anos_cumplidos=$anos_cumplidos;} }
          if((($num_dias!=$dias_dep_mes)or($anos_cumplidos!=0)or($acum_intereses=="S"))and($acum_int_anual=="S")){$interes_acum=$interes_acum+$interes_noacum;$interes_noacum=0;}
          $tinteres=$interes_acum+$interes_noacum; $mtotal=$sprestaciones+$interes_acum; $m1=FDate($fecha_c); $m2=FDate($fecha_desde);  $mtiempo=$m1-$m2+1;
          if(Grabar_Prestaciones($fecha_c,'P',$monto_sueldo,$sueldo_adic,$mprestaciones,$tprestaciones,0,$tadelanto,$sprestaciones,$minteres,$interes_noacum,$interes_acum,0,$tinteres,$mtasa,$mtiempo,$mtotal,$num_dias,$num_dias_adic,$mpresta_adic)==0){$p=1;$mcontinua=0;$num_dias=0;$mprestaciones=0;$fecha_c=nextDate($fecha_c,1);$fecha_mes=$fecha_c;}else{$mcontinua=1;}
        }}
	 }	 
     $fecha_m=nextDate($fecha_hasta,1); $fecha_hasta=colocar_udiames($fecha_m);  $fm=FDate($tfechah); $fh=FDate($fecha_hasta);
	 //echo $fecha_m." ".$fecha_hasta." ".$fm." ".$fh,"<br>"; 
   }
return $p;}
?>
<?php
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR CALCULANDO....","<br>";
$url="Act_cal_prest_lott.php?Gcodigo=C".$cod_empleado_d; $cant_trab=0; $hora1=time(); $campo502="NNNNNNNNNNNNNNNNNNN"; $campo573="NNNNN"; $error=0;  $cal_intereses="N"; $dep_prest_mes="N"; $dep_dias_adic="N"; $prom_sueldo="N";
$sql="Select campo502,campo535,campo573 from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $campo573=$registro["campo573"];}
$acum_intereses=substr($campo502,0,1); $dep_diferencia=substr($campo502,1,1); $dias_adic_primer=substr($campo502,2,1);   $dep_tercer_mes=substr($campo502,3,1); $acum_dias_adic=substr($campo502,4,1);
$cal_intereses=substr($campo502,10,1);  $prom_dias_adic=substr($campo502,11,1); $dep_prest_mes=substr($campo502,12,1); $acum_int_anual=substr($campo502,16,1); $dep_dias_adic=substr($campo573,0,1); $prom_sueldo=substr($campo573,1,1); if($Cod_Emp=="71"){$prom_sueldo="S";}
$m1=FDate($tfechah); $m2=FDate($fecha_tope); if($m1<=$m2){  echo " Fecha Calculo:".$tfechah." numero:".$m1."     Fecha desde Valida mayor a:".$fecha_tope." numero:".$m2; $error=1;?><script language="JavaScript">muestra('FECHA CALCULO DE PRESTACIONES INVALIDA');</script><? }
if($error==0){ $sql= "SELECT nom006.cod_empleado,nom006.nombre,nom006.cedula,nom006.fecha_ingreso,nom006.fecha_ing_adm,nom006.status,nom001.tipo_nomina,nom001.status_tipo,nom001.cod_tipo_liq from NOM006,NOM001 Where (nom001.tipo_nomina=nom006.tipo_nomina) and (nom006.Status='ACTIVO' Or nom006.Status='VACACIONES' Or nom006.Status='PERMISO' Or nom006.Status='PERMISO NO') And (nom006.Status<>'JUBILADO') And (nom006.Status<>'PENSIONADO') And (nom001.tipo_nomina>='$tipo_nomina_d') And (nom001.tipo_nomina<='$tipo_nomina_h') And (nom006.cod_empleado>='$cod_empleado_d') And (nom006.cod_empleado<='$cod_empleado_h') order by nom006.cod_empleado"; $res=pg_query($sql);
while($reg=pg_fetch_array($res)){ $cod_empleado=$reg["cod_empleado"]; $fecha_ingreso=$reg["fecha_ingreso"];  $status_trab=$reg["status"];  $status_tipo=$reg["status_tipo"]; $MNum_dias_dep=$reg["cod_tipo_liq"]; $MNum_dias_dep=$MNum_dias_dep*1; if($MNum_dias_dep==0){$MNum_dias_dep=15;}
 $fecha_mes=$fecha_ingreso;$mprestaciones=0;$tprestaciones=0;$tadelanto=0;$sprestaciones=0;$interes_noacum=0;$tinteres=0;$interes_acum=0; $mtotal=0; $mtasa=0; $fecha_m=formato_aaaammdd($tfechah);
 //echo $Cod_Emp." ".$reg["fecha_ingreso"]." ".$reg["fecha_ing_adm"];
 if($Cod_Emp=="A3"){ $fecha_ingreso=$reg["fecha_ing_adm"]; }
 if($dep_prest_mes=="N"){  if(substr($status_tipo,1,1)=="S"){$dep_prest_mes="S";} } 
 If((($status_trab=="ACTIVO") Or ($status_trab=="VACACIONES") Or ($status_trab=="PERMISO") Or ($status_trab=="PERMISO NO"))and($fecha_ingreso<$fecha_m)){ $mCal_intereses=$cal_intereses; if(substr($status_tipo,0,1)=="S"){$mCal_intereses="S";} $p=0;
  // echo "paso 3 ","<br>"; 
  // echo $Cod_Emp." ".$status_trab." ".$fecha_ingreso." ".$fecha_m." ".$cal_intereses." ".$mCal_intereses." A ".$dep_prest_mes,"<br>";
   if($mCal_intereses=="S"){  if($Cod_Emp=="34"){  $p=procesar_prestaciones5();}else{ if($dep_prest_mes=="S"){   $p=procesar_prestaciones_mes(); } else {   $p=procesar_prestaciones(); } } } else{
   if($dep_prest_mes=="S"){ $p=procesar_prestaciones_mes2(); } else {    if($Cod_Emp=="88"){  $p=procesar_prestaciones3();}else{   $p=procesar_prestaciones2();}   }  }
    $cant_trab=$cant_trab+$p;
 }
} }
pg_close();
/* */
if($error==0){?><script language="JavaScript"> muestra('FINALIZO CALCULO, CANTIDAD TRABAJADORES: '+'<? echo $cant_trab; ?>'); document.location ='<? echo $url; ?>'; </script> <?} else{ ?><script language="JavaScript">document.location ='<? echo $url; ?>'; </script> <? }
?>