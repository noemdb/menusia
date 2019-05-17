<?include ("../class/conect.php"); include ("../class/funciones.php"); include ("../class/configura.inc"); $fecha_hoy=asigna_fecha_hoy(); $eofline="@";
set_time_limit(0);
if (!$_GET){$criterio='';}else{$criterio=$_GET["criterio"];}  $tipo_nomina=substr($criterio,0,2); $fecha_desde=substr($criterio,2,10); $fecha_hasta=substr($criterio,12,10); $num_semanas=substr($criterio,22,1); $conc_ord=substr($criterio,23,2); $trab_esp=substr($criterio,25,2); $u_semana=substr($criterio,27,1); $n_periodos=substr($criterio,29,1); $codigo_mov=substr($criterio,30,49);
//echo $conc_ord." ".$trab_esp." ".$criterio,"<br>";
$cod_empleado=""; $fecha_pago_vac=$fecha_hoy; $pago_vacaciones="N"; $num_recibo=0; $redondear="N"; $bloqueada="N"; $tp_calculo='E';
$calculo1_val=0; $calculo2_val=0; $calculo_final_val=0; $a_dic=""; $pos=0; $formula=""; $opr=""; $cual=""; $Ch=""; $EXY="";  $valor=0; $fecha_nacimiento="";
function Conv_Num($mval) {$fmonto=$mval*1; return $fmonto;}
function frecuencia_valida($frecn,$cal_frec,$cfrec,$u_sem){$mval=false;
if($frecn=="Q"){ if(($cfrec==1)and($cal_frec==1)){$mval=true;} if(($cfrec==2)and($cal_frec==2)){$mval=true;} if($cfrec==3){$mval=true;} }
if($frecn=="S"){ if(($cfrec==4)and($cal_frec==1)){$mval=true;} if(($cfrec==5)and($cal_frec==2)){$mval=true;} if(($cfrec==6)and($cal_frec==3)){$mval=true;} if(($cfrec==7)and($cal_frec==4)){$mval=true;} if(($cfrec==8)and($cal_frec==5)){$mval=true;}  if($cfrec==9){$mval=true;} if(($cfrec==0)and($u_sem=="S")){$mval=true;} }
if($frecn=="M"){$mval=true;}
return $mval;}
function NextCh(){global $formula,$pos,$eofline,$Ch,$EXY;  $nextcont=0; $l=strlen($formula);  //echo $pos.' '.$formula.' '.$l;
 while($nextcont==0){$pos=$pos+1;  if($pos>$l){$Ch=$eofline;}else{$Ch=substr($formula,$pos-1,1);}  if($Ch<>" "){$nextcont=1;} } }
function Valor_Concepto_Historico($codigo){  global $cual,$fecha_desde,$fecha_hasta,$cod_empleado,$tipo_nomina;
  $H=0; $Total=0;  $Cantidad=0;  $Mayor=0; $Menor=9999999999.99;
  If(strlen($codigo)>=16){$Cual=substr($codigo,16,1);}else{$Cual="T";}
  $Desde=substr($codigo,6,6); $Hasta=substr($codigo,13,6); $tDesde=$Desde;
  If($Desde=="ANTEMM"){$F_Desde=colocar_pdiames($fecha_hasta); $F_Desde=nextmes($F_Desde,-1); $Desde=substr($F_Desde,6,4).substr($F_Desde,3,2); $Hasta=$Desde; }
  If(($Desde=="AAAAMM")or(is_numeric($Desde)==false)){$Desde=substr($fecha_hasta, 6, 4).substr($fecha_hasta, 3, 2); }
  If(($Hasta=="AAAAMM")or(is_numeric($Hasta)==false)){$Hasta=substr($fecha_hasta, 6, 4).substr($fecha_hasta, 3, 2); }
  $F_Desde = colocar_pdiames("01/".substr($Desde,4,2)."/".substr($Desde,0,4));
  $F_Hasta = colocar_udiames("01/".substr($Hasta,4,2)."/".substr($Hasta,0,4));
  $F_Desde = formato_aaaammdd($F_Desde);   $F_Hasta = formato_aaaammdd($F_Hasta);    $mcod_concepto=substr($codigo,2,3);
  $StrSQL="select cod_empleado,tipo_nomina,cod_concepto,fecha_nomina,monto from nom018 Where (cod_empleado='$cod_empleado') and (tipo_nomina='$tipo_nomina') and (cod_concepto='$mcod_concepto') and (fecha_nomina>='$F_Desde') and (fecha_nomina<='$F_Hasta') order by cod_empleado,fecha_nomina"; $resp=pg_query($StrSQL);
  If($tDesde=="ANTEQQ"){  $Desde=substr($codigo,6,6); $Hasta=substr($codigo,13,6);
	  $mdiaq=substr($fecha_desde,0,2);
	  if($mdiaq=="01"){
		$F_Desde=colocar_pdiames($fecha_desde); $F_Desde=nextmes($F_Desde,-1);  
		$F_Hasta=colocar_udiames($F_Desde);  $F_Desde= "15".substr($F_Hasta,2,8);
	  }else{
        $F_Desde=colocar_pdiames($fecha_desde); $F_Hasta= "15".substr($F_Desde,2,8);
      }	
      $F_Desde = formato_aaaammdd($F_Desde);   $F_Hasta = formato_aaaammdd($F_Hasta);    $mcod_concepto=substr($codigo,2,3);
      $StrSQL="select cod_empleado,tipo_nomina,cod_concepto,fecha_p_hasta,monto from nom019 Where (cod_empleado='$cod_empleado') and (tipo_nomina='$tipo_nomina') and (cod_concepto='$mcod_concepto') and (fecha_p_desde>='$F_Desde') and (fecha_p_hasta<='$F_Hasta') order by cod_empleado,fecha_p_hasta"; $resp=pg_query($StrSQL);
     // echo $StrSQL,"<br>";
  }
  while(($regp=pg_fetch_array($resp))){ $Cantidad=$Cantidad+1; $Total=$Total+$regp["monto"];  If ($regp["monto"]>$Mayor){$Mayor=$regp["monto"];}  If ($regp["monto"]<$Menor){$Menor=$regp["monto"];} }
  If($Menor==9999999999.99){$Menor=0;}
  switch($Cual){
    Case "C":
      $H=$Cantidad; break;
     Case "P":
       If ($Cantidad>0){$H=$Total/$Cantidad;} else{$H=0;}  break;
     Case ">":
       $H=$Mayor; break;
     Case "<":
       $H=$Menor; break;
     default:
       $H=$Total; break;
  }
return $H;}

function Valor_Concepto($codigo){global $cual,$tipo_nomina,$cod_concepto,$cod_empleado,$cantidad,$valor,$valorx,$valorw,$valory,$valorz,$valorv,$valore,$valoru,$valorq,$fecha_hasta;
 $cual=strtoupper($cual); $v=0; $entro=0;
 If($cual=="H"){$v=Valor_Concepto_Historico($codigo);}
  else{ $mcodigo=substr($codigo,2,3); 
    $sqlc="SELECT * FROM NOM065 where (codigo_mov='$tipo_nomina') and (cod_concepto='$mcodigo')"; $resc=pg_query($sqlc);
    while($regc=pg_fetch_array($resc)){ $entro=1;
        switch($cual){
         Case "C":
           $v=$regc["cantidad"];  if($mcodigo==$cod_concepto){$v=$cantidad;} break;
         Case "M":
           $v=$regc["monto_orig"]; break;
         Case "T":
           $v=$regc["valor"];  if($mcodigo==$cod_concepto){$v=$valor;} break;
         Case "A":
           $v=$regc["acumulado"]; break;
         Case "S":
           $v=$regc["saldo"]; break;
         Case "E":
           $v=$regc["valore"]; if($mcodigo==$cod_concepto){$v=$valore;} break;
         Case "Q":
           $v=$regc["valorq"]; if($mcodigo==$cod_concepto){$v=$valorq;} break;
         Case "U":
           $v=$regc["valoru"]; if($mcodigo==$cod_concepto){$v=$valoru;} break;
         Case "V":
           $v=$regc["valorv"];if($mcodigo==$cod_concepto){$v=$valorv;} break;
         Case "W":
           $v=$regc["valorw"];if($mcodigo==$cod_concepto){$v=$valorw;}	 break;
         Case "X":
           $v=$regc["valorx"];if($mcodigo==$cod_concepto){$v=$valorx;}  break;
         Case "Y":
           $v=$regc["valory"];if($mcodigo==$cod_concepto){$v=$valory;}	break;
         Case "Z":
           $v=$regc["valorz"]; if($mcodigo==$cod_concepto){$v=$valorz;}	break;
        }
    }
	
	if($entro==0){	$tempf=formato_aaaammdd($fecha_hasta);	
		//SELECT tipo_nomina, cod_empleado, cod_concepto, cantidad, monto, fecha_ini,    fecha_exp, activo, calculable, acumulado, saldo, cod_presup,frecuencia, afecta_presup, cod_retencion, cod_presup_ant, prestamo, monto_prestamo, nro_cuotas, nro_cuotas_c, status, inf_usuario,  observacion  FROM nom011
		//$sqlc="SELECT * FROM nom011 where (tipo_nomina='$tipo_nomina') and (cod_concepto='$mcodigo') and (activo='SI') and (cod_empleado='$cod_empleado')"; $resc=pg_query($sqlc); $filasc=pg_num_rows($resc);
	    $sqlc="SELECT * FROM CONCEPTOS_ASIGNADOS WHERE (activo='SI') and (activoa='SI') and (tipo_nomina='$tipo_nomina') and (cod_concepto='$mcodigo') and (cod_empleado='$cod_empleado') and (fecha_exp<='$tempf')"; $resc=pg_query($sqlc); $filasc=pg_num_rows($resc);
        //echo $sqlc;
		if($filasc>=1){$regc=pg_fetch_array($resc); $mcantidad=$regc["cantidad"]; $mmonto=$regc["monto"]; 
		   switch($cual){
			 Case "C":
			   $v=$mcantidad; break;
			 Case "M":
			   $v=$mmonto; break;
			 Case "T":
			   $v=$mcantidad*$mmonto; break;
			 Case "A":
			   $v=$regc["acumulado"]; break;
			 Case "S":
			   $v=$regc["saldo"]; break;			
			}
			//echo $mcodigo." ".$cod_empleado." ".$v." ".$mcantidad." ".$mmonto." ".$cual,"<br>"; 
		}
	}
  }
return $v;}
function factor(){ global $Ch,$pos,$eofline,$formula,$a_dic,$cual,$fecha_nacimiento,$fecha_ing,$fecha_ing_a,$fecha_desde,$fecha_hasta,$status_trab,$fecha_c_sem,$campo_num1;
global $calculo1_val,$calculo2_val,$calculo_final_val,$Monto_Sueldo_SSO,$num_semanas,$cal_frecuencia,$cod_empleado,$campo502; $f=0; $fecha_ley="19/06/1997";
 $Dias_Adic_Primer=substr($campo502,2,1); $Dep_Tercer_Mes=substr($campo502,3,1); $Acum_Dias_Adic=substr($campo502,4,1);
 $st=26;  $StandardFunction=array("FABS","FSQRT","FSQR","FNOR","FPA","FPC","FPP","FLOG","FEXP","FFACT","FFRAC","FINT","FRD","FTE","FAI","FMI","FDI","FNTD","FRTD","FRBD","FAD","FMD","FDD","FAH","FMH","FDH");
 if(is_numeric($Ch)){ $C_Start=0; $Start=$pos;  NextCh(); while(is_numeric($Ch)){NextCh();}
  if(($Ch==".")or($Ch==",")){ $C_Start=$pos+1; NextCh(); while(is_numeric($Ch)){NextCh();}}
  if(($Ch=="E")or($Ch=="B")or($Ch=="D")Or($Ch=="C")){ NextCh(); while(is_numeric($Ch)){NextCh();}}
  if($C_Start==0){$f=Conv_Num(substr($formula,$Start-1,$pos-$Start));}
   else{$C=Conv_Num(substr($formula,$C_Start-1,$pos-$C_Start)); $f=Conv_Num(substr($formula,$Start-1,($C_Start-$Start-1)));
        if($C<>0){$l=$pos-$C_Start; $D=1; for($i=0;$i<$l;$i++){$D=$D*10;} $C=$C/$D; $f=$f+$C;} }
 }else{
  if($Ch=="("){NextCh(); $f=Expression(); if($Ch==")"){NextCh();} }else{ $a_dic=strtoupper($Ch);
    If(($a_dic=="M") Or ($a_dic=="T") Or ($a_dic=="C") Or ($a_dic=="R") Or ($a_dic=="N") Or ($a_dic=="H")  Or ($a_dic=="J") Or ($a_dic=="A") Or ($a_dic=="P") Or ($a_dic=="S") Or ($a_dic=="V") Or ($a_dic=="X") Or ($a_dic=="Y") Or ($a_dic=="Z") Or ($a_dic=="Q") Or ($a_dic=="U") Or ($a_dic=="W") Or ($a_dic=="E") Or ($a_dic=="B") Or ($a_dic=="D") Or ($a_dic=="I")){
      NextCh();
      if(($Ch<>"-") And ($Ch<>"+") And ($Ch<>"/") And ($Ch<>"*") And ($Ch<>"^") And ($Ch<>$eofline)){$f=0; $EXY=strtoupper($Ch); NextCh();
        while(($Ch<>"-") And ($Ch<>"+") And ($Ch<>"/") And ($Ch<>"*") And ($Ch<>"^") And ($Ch<>$eofline)){$EXY=$EXY.strtoupper($Ch);  NextCh();} $l=strlen($EXY);
        if (($l==1) And (($a_dic=="R") Or ($a_dic=="N") Or ($a_dic=="A") Or ($a_dic=="P") Or ($a_dic=="U") Or ($a_dic=="H") Or ($a_dic=="J")  Or ($a_dic=="E") Or ($a_dic=="S") Or ($a_dic==" ") Or ($a_dic=="B") Or ($a_dic=="D") Or ($a_dic=="C") Or ($a_dic=="T") Or ($a_dic=="2"))) {
           switch($EXY){
             Case "1":
               if ($a_dic=="R"){$f=$calculo1_val;}else{$f=0;}  break;
             Case "2":
               if ($a_dic=="R"){$f=$calculo2_val;}else{$f=0;}  break;
             Case "E":
               if ($a_dic=="S"){ if(substr($sexo,0,1)=="M"){$f=1;}else{$f=2;} }  //1-masculino 2-femenino
               if ($a_dic=="B"){ $f=Conv_Num($cod_banco);}
               if ($a_dic=="D"){ $f=elimina_guion($cod_departam)*1;}
               if ($a_dic=="C"){ $f=elimina_guion($cod_cargo)*1;}
               if ($a_dic=="T"){ $f=elimina_guion($cod_tipo_personal)*1;}
			   if ($a_dic=="H"){ $f=0; $StrSQL="select ci_partida,fecha_nac,edad from nom009 where (parentesco='HIJO' or parentesco='HIJA') and (cod_empleado='$cod_empleado') order by ci_partida"; $resp=pg_query($StrSQL);
                    while($regp=pg_fetch_array($resp)){ $fecha_nac=$regp["fecha_nac"];  $e=$regp["edad"]; $e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_hasta); 
					   If($e<18){$f=$f+1;} }
			   }
			   if ($a_dic=="J"){ $f=0; $StrSQL="select ci_partida,fecha_nac,edad from nom009 where (parentesco='HIJO' or parentesco='HIJO GUARD' or parentesco='HIJA' or parentesco='HIJA GUARD') and (cod_empleado='$cod_empleado') order by ci_partida"; $resp=pg_query($StrSQL);
                    while($regp=pg_fetch_array($resp)){ $fecha_nac=$regp["fecha_nac"]; $e=$regp["edad"]; $e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_hasta);  If($e<18){$f=$f+1;} }
			    //echo "1 ".$f." ".$StrSQL,"<br>";
			   }
               if ($a_dic=="I"){ $f=0; if($grado_inst=="BACHILLER"){$f=1;} if($grado_inst=="PRIMARIA"){$f=2;} if($grado_inst=="BASICO"){$f=3;} if($grado_inst=="TECNICO MEDIO"){$f=4;} if($grado_inst=="TECNICO SUPERIOR"){$f=5;} if($grado_inst=="UNIVERSITARIO"){$f=6;} if($grado_inst=="MAESTRIA"){$f=7;} if($grado_inst=="DOCTORADO"){$f=8;} }
               if (($a_dic<>"S")and($a_dic<>"B")and($a_dic<>"D")and($a_dic<>"C")and($a_dic<>"T")and($a_dic<>"I")and($a_dic<>"H")and($a_dic<>"J")){ $f=diferencia_años(formato_ddmmaaaa($fecha_nacimiento),$fecha_hasta); }
               break;
             Case "T":
               $f=0;
			   if ($a_dic=="A"){$f=$campo_num1;}
			   else{ if($status_trab=="ACTIVO"){$f=1;} if($status_trab=="VACACIONES"){$f=2;} if($status_trab=="PERMISO RE"){$f=3;}    if($status_trab=="PERMISO NO"){$f=3;}
               }
			   break;
             Case "S":  // numero de semanas
               if ($a_dic=="S"){$f=$Monto_Sueldo_SSO;}   // sueldo sso
                else{$f=$num_semanas;  $m1=FDate($fecha_c_sem); $m2=FDate($fecha_desde); if($m1>$m2){$f=Asigna_Nro_Semanas($fecha_c_sem,$fecha_hasta);} if($f>$num_semanas){$f=$num_semanas;} }
               break;
             Case "Q":
               if ($a_dic=="A"){ $fecha1=$fecha_ing; $fecha1=substr($fecha1,0,6).substr($fecha_hasta,6,4);  
				   $tfecha_d=nextDate($fecha_hasta,1);   $dia=substr($tfecha_d,0,2); $tfecha_h=colocar_udiames($tfecha_d); if($dia=='01'){$tfecha_h=nextDate($tfecha_d,14);}
				   $m1=FDate($fecha1); $m2=FDate($tfecha_d); $m3=FDate($tfecha_h);
				   $a=diferencia_años($fecha_ing,$tfecha_h); $f=0;
				   if($a>0){if(($m1>=$m2)and($m1<=$m3)){$f=$a;} }
				  // echo $cod_empleado.' '.$cod_concepto.' '.$fecha_ing." A1 ".$tfecha_d." ".$tfecha_h." ".$a." ".$f." ".$fecha_desde." ".$fecha_hasta,"<br>";
				}
				else{$f=$cal_frecuencia; }
               break;
             Case "D" :  // antiguedad en dias
               $m1=FDate($fecha_ing); $m2=FDate($fecha_desde); $m3=FDate($fecha_hasta);
               if($a_dic=="I"){if($m1>=$m2){$f=1;}else{$f=0;} }   //ID   si ingreso en el periodo de calculo
                else{ $f=$m3-$m1; if($f<0){$f=0;} }
                break;
             Case "M":
                $f=0;
				$f=diferencia_meses($fecha_ing,$fecha_hasta); if($f<0){$f=0;}
				if($a_dic=="B"){ $tempf=$fecha_ing;  $fecha1=$fecha_ing; $dia1=substr($fecha1,0,1);
				  if(($dia1=="01")or($dia1=="02")){ $fecha1="01".substr($fecha1,2,8); }
				  $f=diferencia_meses($fecha1,$fecha_hasta); // echo $fecha1." ".$fecha_hasta." ".$f,"<br>";
				}else{ $f=diferencia_meses($fecha_ing,$fecha_hasta); $af=$f;
				   $tmdia=substr($fecha_ing,0,2); $tmdian=substr($fecha_hasta,0,2);
				  $tmdia=$tmdia*1; $tmdian=$tmdian*1; if(($tmdia==1)and(($tmdian==31)or($tmdian==30))){ $f=$f+1;  }
				  //echo $cod_empleado." ".$fecha_ing." ".$fecha_hasta." ".$f." ".$tmdia." ".$af,"<br>";
				}
				if($f<0){$f=0;}
                break;
             Case "P":
                $f=diferencia_años($fecha_ing_a,$fecha_hasta); if($f<0){$f=0;}
                break;
             Case "A":
                If(($a_dic=="D") Or ($a_dic=="C")){$f=0; $tempf=operacion_mes($fecha_desde,-1); $tempf=colocar_udiames($tempf); $m1=substr($fecha_ing,3,2); $m2=substr($tempf,3,2);
                  if($m1=$m2){ $tempf=formato_aaaammdd($tempf);
                    $StrSQL="SELECT c_presta_adic,dias_adicionales From NOM030 Where (cod_empleado='$cod_empleado') and (fecha_calculo>='$tempf') order by cod_empleado,fecha_calculo"; $resp=pg_query($StrSQL);
                    while(($regp=pg_fetch_array($resp))and($f==0)){ If($a_dic=="D"){$f=$regp["c_presta_adic"];}else{$f=$regp["dias_adicionales"];} }
                  }
                }
                else{if($a_dic=="P"){ if(fadte($fecha_ing)>fdate($fecha_ley)){$tempf=$fecha_ing;}else{$tempf=$fecha_ley;} $f=diferencia_años($tempf,$fecha_hasta); if($f<0){$f=0;}
                 If($Dias_Adic_Primer=="S"){$f=$f;}else{$f=$f-1;}
                 If(($f*2)<30){ If($Acum_Dias_Adic=="N"){$f=($f*2);}else{If($f>0){$f=2;}}}
                  else{ If($Acum_Dias_Adic=="N"){$f=30;}else{$f=2;} }
                 } else{$f=diferencia_años($fecha_ing,$fecha_hasta);}}
                if($f<0){$f=0;}
                break;
			 Case "C": 
				if ($a_dic=="A"){ $fecha1=$fecha_ing; $fecha1=substr($fecha1,0,6).substr($fecha_hasta,6,4);
				   $m1=FDate($fecha1); $m2=FDate($fecha_desde); $m3=FDate($fecha_hasta);
				   $a=diferencia_años($fecha_ing,$fecha_hasta); $f=0;
				   if($a>0){if(($m1>=$m2)and($m1<=$m3)){$f=1;} }
				}	
                break;		
             default:
               $f=$calculo_final_val; break;
           }
        } else{ $l=strlen($EXY); if($l>=1){ $cual=$a_dic; $f=Valor_Concepto($EXY); } else{ $f=0; } }
      }
    } else { $found=false;
       for ($i=0; $i<$st; $i++) { if($found==false){ $l=strlen($StandardFunction[$i]);
        if(substr($formula,$pos-1,$l)==$StandardFunction[$i]){
          $pos=$pos+$l; NextCh(); $f=factor2();
          switch($StandardFunction[$i]){
             Case "FFRAC":
               $f=$f-parte_entera($f);  break;
             Case "FINT":
               $f=parte_entera($f);  break;
             Case "FABS":
               if($f<0){$f=$f*-1;}  break;
             Case "FNTD":
                $f = NRD($f);  break;
             Case "FRD":
                $f = RD($f);
             Case "FRTD":
                $f = Round($f, 2);
             Case "FRBD":
                $f = RDB($f);
          }
        }
       }}
     }
   }
 }
return $f;}
function factor2(){ global $Ch,$pos,$eofline,$formula,$a_dic,$cual,$fecha_nacimiento,$fecha_ing,$fecha_ing_a,$fecha_desde,$fecha_hasta,$status_trab,$fecha_c_sem,$campo_num1;
global $calculo1_val,$calculo2_val,$calculo_final_val,$Monto_Sueldo_SSO,$num_semanas,$cal_frecuencia,$cod_empleado,$campo502; $f=0; $fecha_ley="19/06/1997";
 $Dias_Adic_Primer=substr($campo502,2,1); $Dep_Tercer_Mes=substr($campo502,3,1); $Acum_Dias_Adic=substr($campo502,4,1);
 if(is_numeric($Ch)){ $C_Start=0; $Start=$pos;  NextCh(); while(is_numeric($Ch)){NextCh();}
  if(($Ch==".")or($Ch==",")){ $C_Start=$pos+1; NextCh(); while(is_numeric($Ch)){NextCh();}}
  if(($Ch=="E")or($Ch=="B")or($Ch=="D")Or($Ch=="C")){ NextCh(); while(is_numeric($Ch)){NextCh();}}
  if($C_Start==0){$f=Conv_Num(substr($formula,$Start-1,$pos-$Start));}
   else{$C=Conv_Num(substr($formula,$C_Start-1,$pos-$C_Start)); $f=Conv_Num(substr($formula,$Start-1,($C_Start-$Start-1)));
        if($C<>0){$l=$pos-$C_Start; $D=1; for($i=0;$i<$l;$i++){$D=$D*10;} $C=$C/$D; $f=$f+$C;} }
 }else{
  if($Ch=="("){NextCh(); $f=Expression(); if($Ch==")"){NextCh();} }else{ $a_dic=strtoupper($Ch);
    If(($a_dic=="M") Or ($a_dic=="T") Or ($a_dic=="C") Or ($a_dic=="R") Or ($a_dic=="N") Or ($a_dic=="H")  Or ($a_dic=="J") Or ($a_dic=="A") Or ($a_dic=="P") Or ($a_dic=="S") Or ($a_dic=="V") Or ($a_dic=="X") Or ($a_dic=="Y") Or ($a_dic=="Z") Or ($a_dic=="Q") Or ($a_dic=="U") Or ($a_dic=="W") Or ($a_dic=="E") Or ($a_dic=="B") Or ($a_dic=="D") Or ($a_dic=="I")){
      NextCh();
      if(($Ch<>"-") And ($Ch<>"+") And ($Ch<>"/") And ($Ch<>"*") And ($Ch<>"^") And ($Ch<>$eofline)){$f=0; $EXY=strtoupper($Ch); NextCh();
        while(($Ch<>"-") And ($Ch<>"+") And ($Ch<>"/") And ($Ch<>"*") And ($Ch<>"^") And ($Ch<>$eofline)){$EXY=$EXY.strtoupper($Ch);  NextCh();} $l=strlen($EXY);
        if (($l==1) And (($a_dic=="R") Or ($a_dic=="N") Or ($a_dic=="A") Or ($a_dic=="P") Or ($a_dic=="U") Or ($a_dic=="E") Or ($a_dic=="S") Or ($a_dic==" ") Or ($a_dic=="B") Or ($a_dic=="D") Or ($a_dic=="H") Or ($a_dic=="J") Or ($a_dic=="C") Or ($a_dic=="T") Or ($a_dic=="2"))) {
           switch($EXY){
             Case "1":
               if ($a_dic=="R"){$f=$calculo1_val;}else{$f=0;}  break;
             Case "2":
               if ($a_dic=="R"){$f=$calculo2_val;}else{$f=0;}  break;
             Case "E":
               if ($a_dic=="S"){ if(substr($sexo,0,1)=="M"){$f=1;}else{$f=2;} }  //1-masculino 2-femenino
               if ($a_dic=="B"){ $f=Conv_Num($cod_banco);}
               if ($a_dic=="D"){ $f=elimina_guion($cod_departam)*1;}
               if ($a_dic=="C"){ $f=elimina_guion($cod_cargo)*1;}
               if ($a_dic=="T"){ $f=elimina_guion($cod_tipo_personal)*1;}
			   if ($a_dic=="H"){ $f=0; $StrSQL="select ci_partida,fecha_nac,edad from nom009 where (parentesco='HIJO' or parentesco='HIJA') and (cod_empleado='$cod_empleado') order by ci_partida"; $resp=pg_query($StrSQL);
                    while($regp=pg_fetch_array($resp)){ $fecha_nac=$regp["fecha_nac"];  $e=$regp["edad"]; $e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_hasta); 
					   If($e<18){$f=$f+1;} }
			   }
			   if ($a_dic=="J"){ $f=0; $StrSQL="select ci_partida,fecha_nac,edad from nom009 where (parentesco='HIJO' or parentesco='HIJO GUARD' or parentesco='HIJA' or parentesco='HIJA GUARD') and (cod_empleado='$cod_empleado') order by ci_partida"; $resp=pg_query($StrSQL);
                    while($regp=pg_fetch_array($resp)){ $fecha_nac=$regp["fecha_nac"]; $e=$regp["edad"]; $e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_hasta);  If($e<18){$f=$f+1;} }
			    //echo "1 ".$f." ".$StrSQL,"<br>";
			   }
               if ($a_dic=="I"){ $f=0; if($grado_inst=="BACHILLER"){$f=1;} if($grado_inst=="PRIMARIA"){$f=2;} if($grado_inst=="BASICO"){$f=3;} if($grado_inst=="TECNICO MEDIO"){$f=4;} if($grado_inst=="TECNICO SUPERIOR"){$f=5;} if($grado_inst=="UNIVERSITARIO"){$f=6;} if($grado_inst=="MAESTRIA"){$f=7;} if($grado_inst=="DOCTORADO"){$f=8;} }
               if (($a_dic<>"S")and($a_dic<>"B")and($a_dic<>"D")and($a_dic<>"C")and($a_dic<>"T")and($a_dic<>"I")and($a_dic<>"H")and($a_dic<>"J")){ $f=diferencia_años(formato_ddmmaaaa($fecha_nacimiento),$fecha_hasta); }
               break;
             Case "T":
               $f=0;
			   if ($a_dic=="A"){$f=$campo_num1;}
			   else{ if($status_trab=="ACTIVO"){$f=1;} if($status_trab=="VACACIONES"){$f=2;} if($status_trab=="PERMISO RE"){$f=3;}    if($status_trab=="PERMISO NO"){$f=3;} }
			   break;
             Case "S":  // numero de semanas
               if ($a_dic=="S"){$f=$Monto_Sueldo_SSO;}   // sueldo sso
                else{$f=$num_semanas;  $m1=FDate($fecha_c_sem); $m2=FDate($fecha_desde); if($m1>$m2){$f=Asigna_Nro_Semanas($fecha_c_sem,$fecha_hasta);} if($f>$num_semanas){$f=$num_semanas;} }
               break;
             Case "Q":
               if ($a_dic=="A"){ $fecha1=$fecha_ing; $fecha1=substr($fecha1,0,6).substr($fecha_hasta,6,4);  
				   $tfecha_d=nextDate($fecha_hasta,1);   $dia=substr($tfecha_d,0,2); $tfecha_h=colocar_udiames($tfecha_d); if($dia=='01'){$tfecha_h=nextDate($tfecha_d,14);}
				   $m1=FDate($fecha1); $m2=FDate($tfecha_d); $m3=FDate($tfecha_h);
				   $a=diferencia_años($fecha_ing,$tfecha_h); $f=0;
				   if($a>0){if(($m1>=$m2)and($m1<=$m3)){$f=$a;} }
				  // echo $cod_empleado.' '.$cod_concepto.' '.$fecha_ing." A1 ".$tfecha_d." ".$tfecha_h." ".$a." ".$f." ".$fecha_desde." ".$fecha_hasta,"<br>";
				}
				else{$f=$cal_frecuencia; }
               break;
             Case "D" :  // antiguedad en dias  AD
               $m1=FDate($fecha_ing); $m2=FDate($fecha_desde); $m3=FDate($fecha_hasta);
               if($a_dic=="I"){if($m1>=$m2){$f=1;}else{$f=0;} }   //ID   si ingreso en el periodo de calculo
                else{ $f=$m3-$m1; if($f<0){$f=0;} }
                break;
             Case "M": // antiguedad en meses  AM
                $f=0;
				$f=diferencia_meses($fecha_ing,$fecha_hasta); if($f<0){$f=0;}
				if($a_dic=="B"){ $tempf=$fecha_ing;  $fecha1=$fecha_ing; $dia1=substr($fecha1,0,1);
				  if(($dia1=="01")or($dia1=="02")){ $fecha1="01".substr($fecha1,2,8); }
				  $f=diferencia_meses($fecha1,$fecha_hasta);
				}else{ $f=diferencia_meses($fecha_ing,$fecha_hasta); $af=$f;
				   $tmdia=substr($fecha_ing,0,2); $tmdian=substr($fecha_hasta,0,2);
				  $tmdia=$tmdia*1; $tmdian=$tmdian*1; if(($tmdia==1)and(($tmdian==31)or($tmdian==30))){ $f=$f+1;  }
				  echo $cod_empleado." ".$fecha_ing." ".$fecha_hasta." ".$f." ".$tmdia." ".$af,"<br>";
				}
				if($f<0){$f=0;}
                break;
             Case "P":
                $f=diferencia_años($fecha_ing_a,$fecha_hasta); if($f<0){$f=0;}
                break;
             Case "A":
                If(($a_dic=="D") Or ($a_dic=="C")){$f=0; $tempf=operacion_mes($fecha_desde,-1); $tempf=colocar_udiames($tempf); $m1=substr($fecha_ing,3,2); $m2=substr($tempf,3,2);
                  if($m1=$m2){ $tempf=formato_aaaammdd($tempf);
                    $StrSQL="SELECT c_presta_adic,dias_adicionales From NOM030 Where (cod_empleado='$cod_empleado') and (fecha_calculo>='$tempf') order by cod_empleado,fecha_calculo"; $resp=pg_query($StrSQL);
                    while(($regp=pg_fetch_array($resp))and($f==0)){ If($a_dic=="D"){$f=$regp["c_presta_adic"];}else{$f=$regp["dias_adicionales"];} }
                  }
                }
                else{if($a_dic=="P"){ if(fadte($fecha_ing)>fdate($fecha_ley)){$tempf=$fecha_ing;}else{$tempf=$fecha_ley;} $f=diferencia_años($tempf,$fecha_hasta); if($f<0){$f=0;}
                 If($Dias_Adic_Primer=="S"){$f=$f;}else{$f=$f-1;}
                 If(($f*2)<30){ If($Acum_Dias_Adic=="N"){$f=($f*2);}else{If($f>0){$f=2;}}}
                  else{ If($Acum_Dias_Adic=="N"){$f=30;}else{$f=2;} }
                 } else{$f=diferencia_años($fecha_ing,$fecha_hasta);}}
                if($f<0){$f=0;}
                break;
			  Case "C": 
				if ($a_dic=="A"){ $fecha1=$fecha_ing; $fecha1=substr($fecha1,0,6).substr($fecha_hasta,6,4);
				   $m1=FDate($fecha1); $m2=FDate($fecha_desde); $m3=FDate($fecha_hasta);
				   $a=diferencia_años($fecha_ing,$fecha_hasta); $f=0;
				   if($a>0){if(($m1>=$m2)and($m1<=$m3)){$f=1;} }
				}	
                break;
             default:
               $f=$calculo_final_val; break;
           }
        } else{ $l=strlen($EXY); if($l>=1){ $cual=$a_dic; $f=Valor_Concepto($EXY); } else{ $f=0; } }
      }
    } else { $found=false; $f=0;  }
   }
 }
return $f;}
function SignedFactor(){global $Ch; $sig=0;
  if($Ch=="-"){NextCh(); $sig=factor(); $sig=$sig*-1; }else{$sig=factor();}
return $sig;}
function Term(){global $Ch; $t=SignedFactor();
  while($Ch=="^"){ NextCh();}
return $t;}
function DobleExpression(){global $Ch,$opr; $de=Term();
  while($Ch=="/"){ $opr=$Ch; NextCh(); if($opr=="/"){$r=Term();if($r<>0){$de=$de/$r;}else{$de=0;}}}
return $de;}
function SimpleExpression(){ global $Ch,$opr; $s=DobleExpression();
 while($Ch=="*"){ $opr=$Ch; NextCh(); if($opr=="*"){$s=$s*DobleExpression();} }
return $s;}
function Expression(){ global $Ch,$opr; $e=SimpleExpression();
 while(($Ch=="+")Or($Ch=="-")){ $opr=$Ch; NextCh(); if($opr=="+"){$e=$e+SimpleExpression();} if($opr=="-"){$e=$e-SimpleExpression();} }
return $e;}
function resul_formula(){ global $formula,$pos,$formula;
 $resultado=0; $formula=trim($formula); $l=strlen($formula); if(substr($formula,0,1)=="."){$formula="0".$formula;} if(substr($formula,0,1)=="+"){$formula=substr($formula,1,$l-1);}
 $pos=0; NextCh();  $resultado=Expression();
return $resultado;}
function calcular_formulas(){
 global $calculo1; global $calculo2; global $calculofinal; global $calculo1_val;  global $calculo2_val;  global $calculo_final_val; global $formula;
 if((trim($calculo1)<>"")and(substr($calculo1,0,1)<>"{")){$formula=$calculo1; $calculo1_val=resul_formula();}else{$calculo1_val=0;}
 if((trim($calculo2)<>"")and(substr($calculo2,0,1)<>"{")){$formula=$calculo2; $calculo2_val=resul_formula();}else{$calculo2_val=0;}
 if((trim($calculofinal)<>"")and(substr($calculofinal,0,1)<>"{")){$formula=$calculofinal; $calculo_final_val=resul_formula();}else{$calculo_final_val=0;}
 return $calculo_final_val;}
?>
<?php
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR CALCULANDO....","<br>";
$url="Det_cal_nomina.php?criterio=".$tipo_nomina.$tp_calculo; $cant_trab=0; $hora1=time(); $cod_grupo="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}else{ $Nom_Emp=busca_conf(); }
$campo502="NNNNNNNNNNNNNNNNNNN"; $error=0;  $Monto_Sueldo_SSO=0;
$sql="Select campo502,campo535  from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $Monto_Sueldo_SSO==$registro["campo535"];} $proc_vac_nom=substr($campo502,5,1);
if($error==0){$sSQL="Select * from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA NO EXISTE');</script><?}else{$registro=pg_fetch_array($resultado); $g_orden_pago=$registro["g_orden_pago_e"]; $frec_nom=$registro["frecuencia"]; $des_nomina=$registro["descripcion"]; $desc_grupo=$registro["desc_grupo"]; $redondear=$registro["redondear"]; $bloqueada=$registro["bloqueada_ext"];$con_cal_vac=$registro["con_cal_vac"];$con_bon_vac=$registro["con_bon_vac"];$con_cal_vac=$registro["con_cal_vac"]; $con_bon_vac_ant=$registro["con_bon_vac"]; $cod_grupo=$registro["cod_grupo"]; if(trim($cod_grupo)==""){$cod_grupo="00";} }}
if($error==0){if($bloqueada=='S'){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA ESTA BLOQUEADA');</script><?}}
if($error==0){$cal_frecuencia=1; $dia=substr($fecha_hasta,0,2); if($frec_nom=="Q"){if($dia==15){$cal_frecuencia=1;}else{$cal_frecuencia=2;} } if($frec_nom=="S"){ if($u_semana=="S"){$cal_frecuencia=0;} } }
if($error==0){if(checkData($fecha_desde)=='1'){$fechad=formato_aaaammdd($fecha_desde);}else{$error=1;?><script language="JavaScript">muestra('FECHA DESDE NO ES VALIDA');</script><?}}
if($error==0){if(checkData($fecha_hasta)=='1'){$fechah=formato_aaaammdd($fecha_hasta);}else{$error=1;?><script language="JavaScript">muestra('FECHA HASTA NO ES VALIDA');</script><?}}
if($error==0){ $sSQL="SELECT ELIM_CAL_NOMINA_EXT('$tipo_nomina','E',$n_periodos)"; $resultado=pg_exec($conn,$sSQL);  $crit_trab="";
//if(($trab_esp=="SI")OR($conc_ord=="VA")){ $crit_trab=" and (cod_empleado in (select cod_empleado from NOM072 where (codigo_mov='$codigo_mov')))"; }
if(($trab_esp=="SI")){ $crit_trab=" and (cod_empleado in (select cod_empleado from NOM072 where (codigo_mov='$codigo_mov')))"; }
if($conc_ord=="VA"){ $fechaaux=$fechad; 
  $sql="select * from CAL_NOMINA where (cod_empleado IN (SELECT cod_empleado from NOM022)) and (tipo_nomina='$tipo_nomina') and (fecha_ingreso<='$fechah') and (fecha_egreso>='$fechad') ".$crit_trab." order by tipo_nomina,cod_departam,cod_cargo,cod_empleado";  $res=pg_query($sql);
  //echo $sql,"<br>"; 
  while($reg=pg_fetch_array($res)){ $cod_empleado=$reg["cod_empleado"]; $status_trab=$reg["status"]; $pago_vacaciones=$reg["pago_vaciones"]; $fecha_pago_vac=$reg["fecha_pago"];  $cedula=$reg["cedula"]; $nacionalidad=$reg["nacionalidad"]; $nombre=$reg["nombre"]; $fecha_ingreso=$reg["fecha_ingreso"]; $cod_cargo=$reg["cod_cargo"]; $cod_departam=$reg["cod_departam"]; $cod_tipo_personal=$reg["cod_tipo_personal"]; $fecha_ing_adm=$reg["fecha_ing_adm"];if($Cod_Emp=="71"){$fuente_emp="";}else{$fuente_emp=$reg["campo_str1"];}
      $des_cargo=$reg["denominacion"]; $des_departam=$reg["descripcion_dep"]; $des_tipo_personal=$reg["des_tipo_personal"]; $sueldo=$reg["sueldo"]; $compensacion=$reg["compensacion"]; $prima=$reg["prima"]; $sueldo_integral=$reg["sueldo"]+$reg["prima"]+$reg["compensacion"]; $otros=$reg["otros"]; $tipo_pago=$reg["tipo_pago"];  $cta_empleado=$reg["cta_empleado"];  $cta_empresa=$reg["cta_empresa"]; $cod_banco=$reg["cod_banco"]; $nombre_banco=$reg["nombre_banco"]; $cod_ubicacion=$reg["codigo_ubicacion"]; $sexo=$reg["sexo"]; $campo_num1=$reg["campo_num1"];
      $edo_civil=substr($reg["edo_civil"],0,1); if($reg["edo_civil"]=="CONCUBINO"){$edo_civil="U";} $tipo_cuenta=substr($reg["tipo_cuenta"],0,1); if($tipo_cuenta==""){$tipo_cuenta="N";} $status_calculo=$reg["cont_fijo"].substr($nacionalidad,0,1).$tipo_cuenta.substr($reg["sexo"],0,1).substr($edo_civil,0,1);  $des_ubicacion=$reg["descripcion_ubi"]; $fecha_egreso=$reg["fecha_egreso"];  $fecha_nacimiento=$reg["fecha_nacimiento"];  $grado_inst=$reg["grado_inst"]; $fecha_ing=formato_ddmmaaaa($fecha_ingreso);  $fecha_ing_a=formato_ddmmaaaa($fecha_ing_adm);
      $cant_trab=$cant_trab+1;  $num_recibo=$num_recibo+1; $l=strlen($num_recibo); $srecibo="00000".$num_recibo; $srecibo=substr($srecibo,$l,5); $MNeto=0; $MAsignacion=0; $MDeduccion=0;
	  //echo $cod_empleado;
	   $sSQL="SELECT ELIMINA_NOM065('$tipo_nomina')"; $resultado=pg_exec($conn,$sSQL);
	  $sqla="SELECT nom023.cod_empleado,nom023.fecha_hasta,nom023.fecha_desde,nom023.fecha_p_hasta,nom023.cod_concepto,nom023.tipo_nomina,nom023.denominacion,nom023.asignacion,nom023.oculto,nom023.acumula,nom023.tipo_asigna,nom023.asig_ded_apo,nom023.prestamo,nom023.frecuencia,nom023.nro_semana,nom023.cantidad,nom023.monto_orig,nom023.monto,nom023.acumulado,nom023.saldo,nom023.cod_presup,nom023.cod_contable,nom023.afecta_presup,nom023.cod_retencion,nom022.fecha_calculo_d,nom022.fecha_calculo_h FROM nom023,nom022 where (nom023.cod_empleado=nom022.cod_empleado) and (nom023.cod_empleado='$cod_empleado') and (nom023.fecha_desde>='$fechad') and (nom022.fecha_calculo_d>='$fechaaux') order by cod_concepto,fecha_desde"; $resa=pg_query($sqla);
	  //echo $sqla,"<br>"; 
	  while(($rega=pg_fetch_array($resa))){ $cod_concepto=$rega["cod_concepto"]; $den_concepto=$rega["denominacion"]; $fecha_exp="9999-12-31";$fecha_ini=$fecha_ingreso; $frecuenciaa=$rega["frecuencia"]; $frec_valida="S"; $concepto_vac="S"; $int_cal_vac="S"; $calculable="NO"; $prestamo="N";  $valore=0; $valorq=0; $valoru=0; $valorv=0; $valorw=0; $valorx=0; $valory=0; $valorz=0;  
		$asignacion=$rega["asignacion"]; $oculto=$rega["oculto"]; $acumula=$rega["acumula"]; $tipo_a=$rega["tipo_asigna"]; $asig_ded_apo=$rega["asig_ded_apo"]; $cantidad=$rega["cantidad"]; $monto_orig=$rega["monto_orig"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $cod_contable=$rega["cod_contable"]; $cod_presup=$rega["cod_presup"]; $afecta_presup=$rega["afecta_presup"]; $cod_retencion=$rega["cod_retencion"]; $valor=$rega["monto"]; $fechavh=$rega["fecha_hasta"]; $cantidad=cambia_coma_numero($cantidad);  $valor=cambia_coma_numero($valor); if($fuente_emp<>""){  $cod_contable=$fuente_emp; }
		$valor=cambia_coma_numero($valor); 
		if($redondear=="SI"){ $valor=RD($valor);}
		$sSQL="SELECT ACTUALIZA_NOM065(1,'$tipo_nomina','$cod_concepto','$den_concepto','$calculable','$asignacion','$acumula','$oculto','$tipo_a','$asig_ded_apo','$frec_valida','$prestamo','$concepto_vac','$int_cal_vac',$acumulado,$saldo,$valore,$valorq,$valoru,$valorv,$valorw,$valorx,$valory,$valorz,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$fecha_ini','$fecha_exp','$fechavh',$frecuenciaa,'$cod_concepto')"; 
		$resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;}
	    if($oculto=="NO"){ if($asig_ded_apo=="A"){$MAsignacion=$MAsignacion+$valor;} if($asig_ded_apo=="D"){$MDeduccion=$MDeduccion+$valor;} }
	  }
	  $MNeto=$MAsignacion-$MDeduccion; 
	  if($MNeto<0){ ?><script language="JavaScript">muestra('ERROR EN TRABAJADOR:<? echo $cod_empleado; ?> MONTO ES NEGATIVO:<? echo $MNeto; ?> \n ASIGNACIONES:<? echo $MAsignacion; ?> DEDUCCIONES:<? echo $MDeduccion; ?> \n POR FAVOR VERIFIQUE');</script><?}
      else{ $sueldo_integral=cambia_coma_numero($sueldo_integral);
        $sSQL="SELECT AGREGA_NOM017_EXT('$tipo_nomina','$fechah','$cod_empleado','$srecibo','$fechad','$fechah','$fechad','E',$n_periodos,'$fechah','$des_nomina','$tipo_nomina','$desc_grupo','$nombre','$cedula','$fecha_ingreso','$status_trab',$num_semanas,'$cod_cargo','$des_cargo',$sueldo,$prima,$compensacion,$sueldo_integral,$otros,'$cod_departam','$des_departam','$cod_tipo_personal','$des_tipo_personal','$tipo_pago','$cta_empleado','$cta_empresa','$nombre_banco','$cod_ubicacion','$status_calculo','$des_ubicacion','$codigo_mov')"; 
        $sSQL="SELECT AGREGA_NOM017('$tipo_nomina','$fechah','$cod_empleado','$srecibo','$fechad','$fechah','$fechad','E',$n_periodos,'$fechah','$des_nomina','$tipo_nomina','$desc_grupo','$nombre','$cedula','$fecha_ingreso','$status_trab',$num_semanas,'$cod_cargo','$des_cargo',$sueldo,$prima,$compensacion,$sueldo_integral,$otros,'$cod_departam','$des_departam','$cod_tipo_personal','$des_tipo_personal','$tipo_pago','$cta_empleado','$cta_empresa','$nombre_banco','$cod_ubicacion','$status_calculo','$des_ubicacion')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){ echo "Agrega Calculo ".$cod_empleado,"<br>"; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?  $error=1;}
        //echo $sSQL,"<br>"; 
	  }
  }  
}else{
$sql="select * from CAL_NOMINA where (tipo_nomina='$tipo_nomina') and (fecha_ingreso<='$fechah') and (fecha_egreso>='$fechad') ".$crit_trab." order by tipo_nomina,cod_departam,cod_cargo,cod_empleado";  $res=pg_query($sql);
//echo $sql,"<br>"; 
while($reg=pg_fetch_array($res)){ $cod_empleado=$reg["cod_empleado"]; $status_trab=$reg["status"]; $pago_vacaciones=$reg["pago_vaciones"]; $fecha_pago_vac=$reg["fecha_pago"];  $cedula=$reg["cedula"]; $nacionalidad=$reg["nacionalidad"]; $nombre=$reg["nombre"]; $fecha_ingreso=$reg["fecha_ingreso"]; $cod_cargo=$reg["cod_cargo"]; $cod_departam=$reg["cod_departam"]; $cod_tipo_personal=$reg["cod_tipo_personal"]; $fecha_ing_adm=$reg["fecha_ing_adm"];if($Cod_Emp=="71"){$fuente_emp="";}else{$fuente_emp=$reg["campo_str1"];}
  $des_cargo=$reg["denominacion"]; $des_departam=$reg["descripcion_dep"]; $des_tipo_personal=$reg["des_tipo_personal"]; $sueldo=$reg["sueldo"]; $compensacion=$reg["compensacion"]; $prima=$reg["prima"]; $sueldo_integral=$reg["sueldo"]+ $reg["prima"]+$reg["compensacion"]; $otros=$reg["otros"]; $tipo_pago=$reg["tipo_pago"];  $cta_empleado=$reg["cta_empleado"];  $cta_empresa=$reg["cta_empresa"]; $cod_banco=$reg["cod_banco"]; $nombre_banco=$reg["nombre_banco"]; $cod_ubicacion=$reg["codigo_ubicacion"]; $sexo=$reg["sexo"]; $campo_num1=$reg["campo_num1"];
  $edo_civil=substr($reg["edo_civil"],0,1); if($reg["edo_civil"]=="CONCUBINO"){$edo_civil="U";} $tipo_cuenta=substr($reg["tipo_cuenta"],0,1); if($tipo_cuenta==""){$tipo_cuenta="N";} $status_calculo=$reg["cont_fijo"].substr($nacionalidad,0,1).$tipo_cuenta.substr($reg["sexo"],0,1).substr($edo_civil,0,1);  $des_ubicacion=$reg["descripcion_ubi"]; $fecha_egreso=$reg["fecha_egreso"];  $fecha_nacimiento=$reg["fecha_nacimiento"];  $grado_inst=$reg["grado_inst"]; $fecha_ing=formato_ddmmaaaa($fecha_ingreso);  $fecha_ing_a=formato_ddmmaaaa($fecha_ing_adm);
  if(($status_trab=="VACACIONES")and($reg["tipo_vacaciones"]=="N")and($pago_vacaciones=="N")and($proc_vac_nom=="S")){$sSQL="SELECT cod_empleado,fecha_reincorp,fecha_calculo_h FROM NOM024 Where (cod_empleado='$cod_empleado') and (fecha_reincorp<='$fechah')";$resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);if($filas>=1){$registro=pg_fetch_array($resultado); $status_trab="ACTIVO";$pago_vacaciones="S";$fecha_pago_vac=$registro["fecha_reincorp"]; }} $fecha_fin_c=formato_ddmmaaaa($reg["fecha_fin_con"]);
  if($reg["cont_fijo"]=="F"){$continua=0;}else{ $numf1=fdate($fecha_fin_c);  $numf2=fdate($fecha_desde); if($numf1>$numf2){$continua=0;}else{$continua=1;  }}   $MNeto=0; $MAsignacion=0; $MDeduccion=0;
   if($continua==0){$cant_trab=$cant_trab+1;  $num_recibo=$num_recibo+1; $l=strlen($num_recibo); $srecibo="00000".$num_recibo; $srecibo=substr($srecibo,$l,5); $MNeto=0; $MAsignacion=0; $MDeduccion=0;
   If(($status_trab=="ACTIVO") Or ($status_trab=="PERMISO RE") Or ($status_trab=="REPOSO") Or ($status_trab=="VACACIONES") ){  $sSQL="SELECT ELIMINA_NOM065('$tipo_nomina')"; $resultado=pg_exec($conn,$sSQL);
     if($conc_ord=="SI"){$sqla="SELECT * FROM CONCEPTOS_ASIGNADOS WHERE (tipo_nomina='$tipo_nomina') And (cod_empleado='$cod_empleado')  order by cod_empleado,cod_orden,cod_concepto"; }
	 else{  $sqla="SELECT * FROM CONCEPTOS_ASIGNADOS WHERE (tipo_nomina='$tipo_nomina') And (cod_empleado='$cod_empleado') and (cod_concepto in (select cod_concepto FROM NOM066 where (codigo_mov='$codigo_mov')))  order by cod_empleado,cod_orden,cod_concepto"; }
	 $resa=pg_query($sqla);
     //echo $sqla,"<br>"; 
	 while(($rega=pg_fetch_array($resa))and($error==0)){ $cod_concepto=$rega["cod_concepto"]; $den_concepto=$rega["denominacion"]; $cod_orden=$rega["cod_orden"]; $fecha_exp=$rega["fecha_exp"]; $fecha_ini=$rega["fecha_ini"]; $frecuenciaa=$rega["frecuenciaa"]; $frecuencia=$rega["frecuencia"]; $frec_valida="S";  $calculable=$rega["calculable"]; $status=$rega["status"]; $concepto_vac="N";
      if($fechad<=$fecha_exp){ $continua=0; 
	   if($conc_ord=="SI"){ if(frecuencia_valida($frec_nom,$cal_frecuencia,$frecuencia,$u_semana)==false){$continua=1;} if(frecuencia_valida($frec_nom,$cal_frecuencia,$frecuenciaa,$u_semana)==false){$continua=1;} if(($proc_vac_nom=="S")and(($cod_concepto==$con_bon_vac)or($cod_concepto==$con_bon_vac_ant))){$continua=1; } }
       if($continua==0){$calculable=$rega["calculable"]; $asignacion=$rega["asignacion"]; $oculto=$rega["oculto"]; $acumula=$rega["acumula"]; $tipo_a=$rega["tipo_asigna"]; $asig_ded_apo=$rega["asig_ded_apo"]; $prestamo=$rega["prestamo"]; $int_cal_vac=substr($status,0,1); $cantidad=$rega["cantidad"]; $monto_orig=$rega["monto"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $cod_contable=$rega["cod_contable"];$cod_presup=$rega["cod_presup"]; $afecta_presup=$rega["afecta_presup"]; $cod_retencion=$rega["cod_retencion"]; if($fuente_emp<>""){  $cod_contable=$fuente_emp; } $cod_grupo=$cod_contable;if($Cod_Emp=="71"){$den_concepto=substr($den_concepto,0,100);}else{$observacion=$rega["observacion"]; $den_concepto=$den_concepto.' '.$observacion; $den_concepto=substr($den_concepto,0,100);}
        $valor=$cantidad*$monto_orig; $valore=0; $valorq=0; $valoru=0; $valorv=0; $valorw=0; $valorx=0; $valory=0; $valorz=0; if($fecha_egreso<$fecha_exp){$fecha_exp=$fecha_egreso;} if(($prestamo=="S")and(($rega["nro_cuotas_c"]+1)<$rega["nro_cuotas"])){$calculable="N"; $valore=$rega["monto_prestamo"]; $valorq=$rega["nro_cuotas"]; $valoru=$rega["nro_cuotas_c"]+1; $valor=$monto_orig; } $cantidad=cambia_coma_numero($cantidad); $valor=cambia_coma_numero($valor);
       $valor=cambia_coma_numero($valor);        
	   if($redondear=="SI"){ $valor=RD($valor);}
		$sSQL="SELECT ACTUALIZA_NOM065(1,'$tipo_nomina','$cod_concepto','$den_concepto','$calculable','$asignacion','$acumula','$oculto','$tipo_a','$asig_ded_apo','$frec_valida','$prestamo','$concepto_vac','$int_cal_vac',$acumulado,$saldo,$valore,$valorq,$valoru,$valorv,$valorw,$valorx,$valory,$valorz,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_grupo','$afecta_presup','$cod_retencion','$fecha_ini','$fecha_exp','$fechah',$frecuenciaa,'$cod_orden')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;}
         //echo $sSQL,"<br>"; 
		//if(($calculable="NO")and($oculto=="NO")){if($asig_ded_apo=="A"){$MAsignacion=$MAsignacion+$valor;} if($asig_ded_apo=="D"){$MDeduccion=$MDeduccion+$valor;}}
		if(($calculable=="NO")and($oculto=="NO")){if(($asig_ded_apo=="A")and($oculto=="NO")){$MAsignacion=$MAsignacion+$valor;} if(($asig_ded_apo=="D")and($oculto=="NO")){$MDeduccion=$MDeduccion+$valor;}}
      
      }}}
	 if($conc_ord=="SI"){$sqla="SELECT * FROM NOM065 where (codigo_mov='$tipo_nomina') and (calculable='SI') and (concepto_vac='N') and (cod_concepto in (select cod_concepto from nom003 where tipo_nomina='$tipo_nomina')) order by cod_orden"; $resa=pg_query($sqla);
        //echo $sqla,"<br>";
		while(($rega=pg_fetch_array($resa))and($error==0)){ $cod_concepto=$rega["cod_concepto"]; $valor=$rega["valor"]; $cantidad=$rega["cantidad"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $monto_orig=$rega["monto_orig"]; $valore=$rega["valore"]; $valoru=$rega["valoru"]; $valorq=$rega["valorq"]; $valorw=$rega["valorw"]; $valorx=$rega["valorx"]; $valory=$rega["valory"]; $valorz=$rega["valorz"]; $cod_orden=$rega["cod_orden"];
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
		   } } if($valor<0){$valor=0;}
		   $entra=0; //if(($valor>0)and($asig_ded_apo=="A")){$entra=1;}  
		   if($Cod_Emp=="02"){   //contraloria miranda
			 //esto es para que no haga regla de tres a la prima de antiguedad
			 if($cod_concepto=="006"){ $entra=0;  }
			 if(($cod_concepto=="001")and($cambio_cantidad==1)){ $entra=0;  }
			 if(($asig_ded_apo=="A")and($valor>0)){$entra=1;}
			 if(($valor>0)and($monto_orig>0)and($asig_ded_apo=="D")){$entra=1;}	
			 if(($error==0)and($oculto=="NO")and($entra==1)and($fecha_ini<=$fechah)){ $ndif=15; if($frec_nom=="S"){$ndif=7;} if($frec_nom=="M"){$ndif=30;}
				$temp_e=formato_ddmmaaaa($fecha_exp); $temp_i=formato_ddmmaaaa($fecha_ini); $t_dia=substr($temp_e,0,2); if($t_dia=="31"){$temp_e="30".substr($temp_e,2,8);}
				If (($fecha_exp<$fechah) and ($fecha_ini<$fechah)){$dias_dif=diferencia_dias($fecha_desde,$temp_e)+1; $valor=($valor/$ndif)*$dias_dif; }
			   If (($fecha_exp>$fechah) and ($fecha_ini>$fechad)){$dias_dif=diferencia_dias($temp_i,$fecha_hasta);  $valor=($valor/$ndif)*$dias_dif; }
			   If (($fecha_exp<$fechah) and ($fecha_ini>$fechad)){$dias_dif=diferencia_dias($temp_i,$temp_e)+1; $valor=($valor/$ndif)*$dias_dif;}
			 }
		   } 
		   else{
			   if(($valor>0)and($monto_orig>0)and($asig_ded_apo=="D")){$entra=1;}	   
			   if(($asig_ded_apo=="A")and($valor>0)and($cantidad==0)){$entra=1;} 
			  // if(($cod_concepto=="001")or($cod_concepto=="006")){echo $cod_concepto." Cantidad: ".$cantidad." Monto: ".$valor." ".$entra,"<br>";  }
			   if($Cod_Emp=="71"){ if(($cod_concepto=="094")or($cod_concepto=="095")or($cod_concepto=="036")){ $entra=0; } }
			   if(($error==0)and($oculto=="NO")and($cantidad==0)and($entra==1)and($fecha_ini<=$fechah)){ $ndif=15; if($frec_nom=="S"){$ndif=7;} if($frec_nom=="M"){$ndif=30;}
				 $temp_e=formato_ddmmaaaa($fecha_exp); $temp_i=formato_ddmmaaaa($fecha_ini); $t_dia=substr($temp_e,0,2); if($t_dia=="31"){$temp_e="30".substr($temp_e,2,8);}
				 If (($fecha_exp<$fechah) and ($fecha_ini<$fechah)){$dias_dif=diferencia_dias($fecha_desde,$temp_e)+1; $valor=($valor/$ndif)*$dias_dif; }
				 If (($fecha_exp>$fechah) and ($fecha_ini>$fechad)){$dias_dif=diferencia_dias($temp_i,$fecha_hasta);  $valor=($valor/$ndif)*$dias_dif; }
				 If (($fecha_exp<$fechah) and ($fecha_ini>$fechad)){$dias_dif=diferencia_dias($temp_i,$temp_e)+1; $valor=($valor/$ndif)*$dias_dif;}
			   }
		   }
		   $cantidad=cambia_coma_numero($cantidad); $valor=cambia_coma_numero($valor);  if($redondear=="SI"){ $valor=RD($valor);}  
		   if($oculto=="NO"){ if($asig_ded_apo=="A"){$MAsignacion=$MAsignacion+$valor;} if($asig_ded_apo=="D"){$MDeduccion=$MDeduccion+$valor;} }
		   $valorx=cambia_coma_numero($valorx); $valory=cambia_coma_numero($valory); $valoru=cambia_coma_numero($valoru); $valore=cambia_coma_numero($valore); $valorq=cambia_coma_numero($valorq);  $valorw=cambia_coma_numero($valorw); $valorv=cambia_coma_numero($valorv);  $valorz=cambia_coma_numero($valorz);
	       $sSQL="SELECT ACTUALIZA_NOM065(2,'$tipo_nomina','$cod_concepto','','S','S','S','N','A','A','S','N','N','N',$acumulado,$saldo,$valore,$valorq,$valoru,$valorv,$valorw,$valorx,$valory,$valorz,$cantidad,$valor,$monto_orig,'','','','','$fechah','$fechah','$fechah',0,'$cod_orden')";   $resultado=pg_exec($conn,$sSQL);
		} $sueldo_integral=cambia_coma_numero($sueldo_integral);
		$sqla="SELECT * FROM NOM065 where (codigo_mov='$tipo_nomina') and (valor>0) order by cod_orden"; $resa=pg_query($sqla);		
		$sSQL="SELECT AGREGA_NOM017('$tipo_nomina','$fechah','$cod_empleado','$srecibo','$fechad','$fechah','$fechad','E',$n_periodos,'$fechah','$des_nomina','$tipo_nomina','$desc_grupo','$nombre','$cedula','$fecha_ingreso','$status_trab',$num_semanas,'$cod_cargo','$des_cargo',$sueldo,$prima,$compensacion,$sueldo_integral,$otros,'$cod_departam','$des_departam','$cod_tipo_personal','$des_tipo_personal','$tipo_pago','$cta_empleado','$cta_empresa','$nombre_banco','$cod_ubicacion','$status_calculo','$des_ubicacion')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){ echo "Agrega Calculo ".$cod_empleado,"<br>"; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?  $error=1;}
    }else{  
	     //echo $cod_empleado." ".$MNeto." ".$MAsignacion." ".$MDeduccion,"<br>";
	     $sqla="SELECT * FROM NOM065 where (codigo_mov='$tipo_nomina') and (calculable='SI') and (concepto_vac='N') and (cod_concepto in (select cod_concepto FROM NOM066 where (codigo_mov='$codigo_mov'))) and (cod_concepto in (select cod_concepto from nom048 where tipo_nomina='$tipo_nomina')) order by cod_orden"; $resa=pg_query($sqla);
		 while(($rega=pg_fetch_array($resa))and($error==0)){ $cod_concepto=$rega["cod_concepto"]; $valor=$rega["valor"]; $cantidad=$rega["cantidad"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $monto_orig=$rega["monto_orig"]; $valore=$rega["valore"]; $valoru=$rega["valoru"]; $valorq=$rega["valorq"]; $valorw=$rega["valorw"]; $valorx=$rega["valorx"]; $valory=$rega["valory"]; $valorz=$rega["valorz"]; $cod_orden=$rega["cod_orden"];
		   $calculo_final_val=0;  $calculo1_val=0;  $calculo2_val=0;  $asig_ded_apo=$rega["asig_ded_apo"]; $fecha_ini=$rega["fecha_ini"]; $fecha_exp=$rega["fecha_exp"]; $oculto=$rega["oculto"];
		   $sqlf="Select * from nom048 where tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto' Order BY tipo_nomina,cod_concepto,consecutivo";$resf=pg_query($sqlf);  $continuaf=0;
		   while(($regf=pg_fetch_array($resf))and($error==0)and($continuaf==0)){ $consecutivo=$regf["consecutivo"];  $accion=$regf["accion"]; $rango_inicial=$regf["rango_inicial"]; $rango_final=$regf["rango_final"]; $calculo1=$regf["calculo1"]; $calculo2=$regf["calculo2"]; $calculofinal=$regf["calculofinal"];
			//echo $cod_concepto." ".$asig_ded_apo." ".$valor." ".$cantidad." ".$consecutivo." ".$accion,"<br>";
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
				 Case "E":
				  $valore=calcular_formulas(); break; 
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
		   } if($valor<0){$valor=0;} $valor=cambia_coma_numero($valor); 
		   //echo $cod_concepto." ".$asig_ded_apo." ".$valor." ".$cantidad." ".$consecutivo." ".$accion,"<br>";		   
		   }   if($redondear=="SI"){ $valor=RD($valor);} 
		   $cantidad=cambia_coma_numero($cantidad); $valor=cambia_coma_numero($valor); if($oculto=="NO"){ if($asig_ded_apo=="A"){$MAsignacion=$MAsignacion+$valor;} if($asig_ded_apo=="D"){$MDeduccion=$MDeduccion+$valor;} }
		   $valorx=cambia_coma_numero($valorx); $valory=cambia_coma_numero($valory); $valoru=cambia_coma_numero($valoru); $valore=cambia_coma_numero($valore); $valorq=cambia_coma_numero($valorq);  $valorw=cambia_coma_numero($valorw); $valorv=cambia_coma_numero($valorv); $valorz=cambia_coma_numero($valorz);
	       $sSQL="SELECT ACTUALIZA_NOM065(2,'$tipo_nomina','$cod_concepto','','S','S','S','N','A','A','S','N','N','N',$acumulado,$saldo,$valore,$valorq,$valoru,$valorv,$valorw,$valorx,$valory,$valorz,$cantidad,$valor,$monto_orig,'','','','','$fechah','$fechah','$fechah',0,'$cod_orden')";   $resultado=pg_exec($conn,$sSQL);
		  } 
		$sqla="SELECT * FROM NOM065 where (codigo_mov='$tipo_nomina') and (valor>0) and (cod_concepto in (select cod_concepto FROM NOM066 where (codigo_mov='$codigo_mov'))) order by cod_orden"; $resa=pg_query($sqla);
        $filasa=pg_num_rows($resa);  if($filasa>0){  $sueldo_integral=cambia_coma_numero($sueldo_integral);
          $sSQL="SELECT AGREGA_NOM017_EXT('$tipo_nomina','$fechah','$cod_empleado','$srecibo','$fechad','$fechah','$fechad','E',$n_periodos,'$fechah','$des_nomina','$tipo_nomina','$desc_grupo','$nombre','$cedula','$fecha_ingreso','$status_trab',$num_semanas,'$cod_cargo','$des_cargo',$sueldo,$prima,$compensacion,$sueldo_integral,$otros,'$cod_departam','$des_departam','$cod_tipo_personal','$des_tipo_personal','$tipo_pago','$cta_empleado','$cta_empresa','$nombre_banco','$cod_ubicacion','$status_calculo','$des_ubicacion','$codigo_mov')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error,0,70);if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?  $error=1;}
        }
	 }
     $MNeto=$MAsignacion-$MDeduccion;  
	 if($MNeto<0){ ?><script language="JavaScript">muestra('ERROR EN TRABAJADOR:<? echo $cod_empleado; ?> MONTO ES NEGATIVO:<? echo $MNeto; ?> \n ASIGNACIONES:<? echo $MAsignacion; ?> DEDUCCIONES:<? echo $MDeduccion; ?> \n POR FAVOR VERIFIQUE');</script><?}
    }
 }}
 if($g_orden_pago=="S"){ $sSQL="SELECT cod_presup,monto,cod_concepto,cod_empleado,cod_contable  FROM nom017 where (afecta_presup='SI') and (asignacion='SI') and (tipo_nomina='$tipo_nomina') and (tp_calculo='E') and (cod_presup not in (select cod_presup from pre001)) order by cod_presup"; $res=pg_query($sSQL);
 while($reg=pg_fetch_array($res)){ $cod_presup=$reg["cod_presup"]; $cod_fuente=$reg["cod_contable"];  $cod_concepto=$reg["cod_concepto"]; $cod_empleado=$reg["cod_empleado"]; $error=1;
    ?><script language="JavaScript">muestra('CODIGO PRESUPUESTARIO:<? echo $cod_presup; ?> FUENTE:<? echo $cod_fuente; ?> \n TRABAJADOR:<? echo $cod_empleado; ?> CONCEPTO:<? echo $cod_concepto; ?> \n NO EXISTE EN PRESUPUESTO');</script><? }
 $sSQL="SELECT cod_presup,cod_contable,sum(monto) as monto FROM nom017 where (afecta_presup='SI') and (asignacion='SI') and (tipo_nomina='$tipo_nomina') and (tp_calculo='E') group by cod_presup,cod_contable order by cod_presup,cod_contable"; $res=pg_query($sSQL);
 while(($reg=pg_fetch_array($res))and($error==0)){ $cod_presup=$reg["cod_presup"]; $monto=$reg["monto"]; $cod_fuente=$reg["cod_contable"];
    $sqlp = "SELECT denominacion,disponible,diferido FROM PRE001 WHERE (Cod_Presup='$cod_presup') and (cod_fuente='$cod_fuente')"; $resp=pg_query($sqlp); $filas=pg_num_rows($resp);
    if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO <? echo $cod_presup; ?> NO EXISTE EN DISPONIBILIDAD');</script><? }
    else{ $regp=pg_fetch_array($resp); $disponible=$regp["disponible"]; if($disponible<$monto){
        ?><script language="JavaScript">muestra('NO EXISTE DISPONIBILIDAD PARA EL CODIGO PRESUPUESTARIO:<? echo $cod_presup; ?> FUENTE:<? echo $cod_fuente; ?> \n DISPONIBILIDAD ACTUAL:<? echo $disponible; ?> MONTO REQUERIDO:<? echo $monto; ?> \n POR FAVOR VERIFIQUE');</script><?}}
 }}
 $sSQL= "SELECT cod_concepto,denominacion,cod_aporte FROM NOM002 where (cod_aporte<>'000') and (cod_aporte<>'') and (tipo_nomina='$tipo_nomina')  and (asig_ded_apo='D') and cod_concepto in (select cod_concepto from nom017 where (tipo_nomina='$tipo_nomina') and (tp_calculo='E')";$res=pg_query($sSQL);
 while(($reg=pg_fetch_array($res))and($error==0)){ $t_reten=0; $t_aporte=0; $denominacion=$reg["denominacion"];  $cod_reten=$reg["cod_concepto"]; $cod_aporte=$reg["cod_aporte"];
    $sqlp = "select count(*) as cantidad from nom017 where (tipo_nomina='$tipo_nomina') and (cod_concepto='$cod_reten') and (tp_calculo='E')"; $resp=pg_query($sqlp); $filas=pg_num_rows($resp); if($filas>0){ $regp=pg_fetch_array($resp); $t_reten=$regp["cantidad"]; }
    $sqlp = "select count(*) as cantidad from nom017 where (tipo_nomina='$tipo_nomina') and (cod_concepto='$cod_aporte') and (tp_calculo='E')"; $resp=pg_query($sqlp); $filas=pg_num_rows($resp); if($filas>0){ $regp=pg_fetch_array($resp); $t_aporte=$regp["cantidad"]; }
    if($t_reten<>$t_aporte){ ?> <script language="JavaScript"> muestra('EXISTE UNA DIFERENCIA ENTRE LA RETENCION Y EL APORTE DEL CONCEPTO <? echo $cod_reten.' '.$denominacion; ?> POR FAVOR VERIFIQUE');</script><?}
 }
} }
//$sSQL="SELECT ELIMINA_NOM065('$tipo_nomina')"; $resultado=pg_exec($conn,$sSQL);  $hora2=time(); $dif=$hora2-$hora1; echo " Tiempo en segundos: ".$dif,"<br>";
pg_close();if($error==0){?><script language="JavaScript">muestra('FINALIZO CALCULO, CANTIDAD: '+'<? echo $cant_trab; ?>');
//document.location ='<? echo $url; ?>';
</script> <?}?>

