<?
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
 // echo $StrSQL." ".$Cual." ".$Total." ".$Cantidad."  ".$Desde." ".substr($codigo,6,6),"<br>";
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
function Valor_Concepto($codigo){global $cual,$tipo_nomina,$cod_empleado,$cod_concepto,$cantidad,$valor,$valorx,$valorw,$valory,$valorz,$valorv,$valore,$valoru,$valorq,$fecha_hasta,$frec_nom,$cal_frecuencia,$u_semana;
 $cual=strtoupper($cual); $v=0; $entro=0;
 If($cual=="H"){$v=Valor_Concepto_Historico($codigo);}
  else{ $mcodigo=substr($codigo,2,3); 
    $sqlc="SELECT * FROM NOM065 where (codigo_mov='$tipo_nomina') and (cod_concepto='$mcodigo')"; $resc=pg_query($sqlc);
	//echo $sqlc,"<br>";
    while($regc=pg_fetch_array($resc)){ $entro=1;
        switch($cual){
         Case "C":
           $v=$regc["cantidad"]; if($mcodigo==$cod_concepto){$v=$cantidad;} break;
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
	if($entro==0){		$tempf=formato_aaaammdd($fecha_hasta);
		//SELECT tipo_nomina, cod_empleado, cod_concepto, cantidad, monto, fecha_ini,    fecha_exp, activo, calculable, acumulado, saldo, cod_presup,frecuencia, afecta_presup, cod_retencion, cod_presup_ant, prestamo, monto_prestamo, nro_cuotas, nro_cuotas_c, status, inf_usuario,  observacion  FROM nom011
		//$sqlc="SELECT * FROM nom011 where (tipo_nomina='$tipo_nomina') and (cod_concepto='$mcodigo') and (activo='SI') and (cod_empleado='$cod_empleado')"; $resc=pg_query($sqlc); $filasc=pg_num_rows($resc);
	    $sqlc="SELECT * FROM CONCEPTOS_ASIGNADOS WHERE (activo='SI') and (activoa='SI') and (tipo_nomina='$tipo_nomina') and (cod_concepto='$mcodigo') and (cod_empleado='$cod_empleado') and (fecha_exp<='$tempf')"; $resc=pg_query($sqlc); $filasc=pg_num_rows($resc);
        //echo $sqlc;
		if($filasc>=1){$regc=pg_fetch_array($resc); $mcantidad=$regc["cantidad"]; $mmonto=$regc["monto"]; $frecuencia=$rega["frecuencia"]; $continua=0; 
	       if(frecuencia_valida($frec_nom,$cal_frecuencia,$frecuencia,$u_semana)==false){$continua=1;}
           if($continua==0)	{	   
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
		   }	
		}
	}
   	//echo $mcodigo." ".$cual." ".$entro." ".$v,"<br>";
  }  
return $v;}
function factor(){ global $Ch,$pos,$eofline,$formula,$a_dic,$cual,$fecha_nacimiento,$fecha_ing,$fecha_ing_a,$fecha_desde,$fecha_hasta,$status_trab,$fecha_c_sem,$fecha_h_sem,$cod_concepto,$campo_num1;
global $calculo1_val,$calculo2_val,$calculo_final_val,$Monto_Sueldo_SSO,$num_semanas,$cal_frecuencia,$cod_empleado,$campo502,$Cod_Emp; $f=0; $fecha_ley="19/06/1997";
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
    If(($a_dic=="M") Or ($a_dic=="T") Or ($a_dic=="C") Or ($a_dic=="R") Or ($a_dic=="N") Or ($a_dic=="H")  Or ($a_dic=="J") Or ($a_dic=="A") Or ($a_dic=="P") Or ($a_dic=="O") Or ($a_dic=="S") Or ($a_dic=="V") Or ($a_dic=="X") Or ($a_dic=="Y") Or ($a_dic=="Z") Or ($a_dic=="Q") Or ($a_dic=="U") Or ($a_dic=="W") Or ($a_dic=="E") Or ($a_dic=="B") Or ($a_dic=="D") Or ($a_dic=="I")){
      NextCh();
      if(($Ch<>"-") And ($Ch<>"+") And ($Ch<>"/") And ($Ch<>"*") And ($Ch<>"^") And ($Ch<>$eofline)){$f=0; $EXY=strtoupper($Ch); NextCh();
        while(($Ch<>"-") And ($Ch<>"+") And ($Ch<>"/") And ($Ch<>"*") And ($Ch<>"^") And ($Ch<>$eofline)){$EXY=$EXY.strtoupper($Ch);  NextCh();} $l=strlen($EXY);
        if (($l==1) And (($a_dic=="R") Or ($a_dic=="N") Or ($a_dic=="A") Or ($a_dic=="P") Or ($a_dic=="O") Or ($a_dic=="U") Or ($a_dic=="H") Or ($a_dic=="J")  Or ($a_dic=="E") Or ($a_dic=="S") Or ($a_dic==" ") Or ($a_dic=="B") Or ($a_dic=="D") Or ($a_dic=="C") Or ($a_dic=="Q") Or ($a_dic=="T") Or ($a_dic=="2"))) {
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
                    while($regp=pg_fetch_array($resp)){ $fecha_nac=$regp["fecha_nac"];  $e=$regp["edad"]; $e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_hasta); if($Cod_Emp=="02"){$e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_desde); }
					   If($e<18){$f=$f+1;} }
					//echo "HE ".$f." ".$StrSQL,"<br>";   
			   }
			   if ($a_dic=="J"){ $f=0; $StrSQL="select ci_partida,fecha_nac,edad from nom009 where (parentesco='HIJO' or parentesco='HIJO GUARD' or parentesco='HIJA' or parentesco='HIJA GUARD') and (cod_empleado='$cod_empleado') order by ci_partida"; $resp=pg_query($StrSQL);
                    while($regp=pg_fetch_array($resp)){ $fecha_nac=$regp["fecha_nac"]; $e=$regp["edad"]; $e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_hasta); if($Cod_Emp=="02"){$e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_desde); } If($e<18){$f=$f+1;} }
			    //echo "1 ".$f." ".$StrSQL,"<br>";
			   }
               if ($a_dic=="I"){ $f=0; if($grado_inst=="BACHILLER"){$f=1;} if($grado_inst=="PRIMARIA"){$f=2;} if($grado_inst=="BASICO"){$f=3;} if($grado_inst=="TECNICO MEDIO"){$f=4;} if($grado_inst=="TECNICO SUPERIOR"){$f=5;} if($grado_inst=="UNIVERSITARIO"){$f=6;} if($grado_inst=="MAESTRIA"){$f=7;} if($grado_inst=="DOCTORADO"){$f=8;} }
               if (($a_dic<>"S")and($a_dic<>"B")and($a_dic<>"D")and($a_dic<>"C")and($a_dic<>"T")and($a_dic<>"I")and($a_dic<>"H")and($a_dic<>"J")){ $f=diferencia_años(formato_ddmmaaaa($fecha_nacimiento),$fecha_hasta); }
               break;
             Case "T":
               $f=0;
               if ($a_dic=="A"){$f=$campo_num1;}
			   else{if($status_trab=="ACTIVO"){$f=1;} if($status_trab=="VACACIONES"){$f=2;} if($status_trab=="PERMISO RE"){$f=3;}    if($status_trab=="PERMISO NO"){$f=3;} }
               break;
             Case "S":  // numero de semanas
               if ($a_dic=="S"){$f=$Monto_Sueldo_SSO;}   // sueldo sso
                else{$f=$num_semanas;  $m1=FDate($fecha_c_sem); $m2=FDate($fecha_desde); $a=0;
				if($m1>$m2){$f=Asigna_Nro_Semanas($fecha_c_sem,$fecha_hasta);}else{ $m1=FDate($fecha_h_sem); $m2=FDate($fecha_hasta); if($m1<$m2){$a=1; $f=Asigna_Nro_Semanas($fecha_desde,$fecha_h_sem);	} }
				if($f>$num_semanas){$f=$num_semanas;} } 
				// echo $cod_empleado.' '.$cod_concepto.' '.$fecha_ing." A0 ".$fecha_c_sem." ".$fecha_h_sem." ".$a." ".$f." ".$fecha_desde." ".$fecha_hasta,"<br>";
               break;
             Case "Q":			 
			   if ($a_dic=="A"){ $fecha1=$fecha_ing; $fecha1=substr($fecha1,0,6).substr($fecha_hasta,6,4);  
				   $tfecha_d=nextDate($fecha_hasta,1);   $dia=substr($tfecha_d,0,2); $tfecha_h=colocar_udiames($tfecha_d); if($dia=='01'){$tfecha_h=nextDate($tfecha_d,14);}
				   $m1=FDate($fecha1); $m2=FDate($tfecha_d); $m3=FDate($tfecha_h);
				   $a=diferencia_años($fecha_ing,$tfecha_h); $f=0;
				   if($a>0){if(($m1>=$m2)and($m1<=$m3)){$f=$a;} }
				  // echo $cod_empleado.' '.$cod_concepto.' '.$fecha_ing." A1 ".$tfecha_d." ".$tfecha_h." ".$a." ".$f." ".$fecha_desde." ".$fecha_hasta,"<br>";
				}
				else{
				$f=$cal_frecuencia; }
               break;
             Case "D" :  // antiguedad en dias
               $m1=FDate($fecha_ing); $m2=FDate($fecha_desde); $m3=FDate($fecha_hasta);
               if($a_dic=="I"){if($m1>=$m2){$f=1;}else{$f=0;} }   //ID   si ingreso en el periodo de calculo
                else{ $f=$m3-$m1; if($f<0){$f=0;} }
                break;
             Case "M":
                $f=diferencia_meses($fecha_ing,$fecha_hasta); 
				$tmdia=substr($fecha_ing,0,2); $tmdian=substr($fecha_hasta,0,2);
				//$tmdia=$tmdia*1; $tmdian=$tmdian*1; if(($tmdia==1)and(($tmdian==31)or($tmdian==30))){ $f=$f+1;  }
				if($f<0){$f=0;}
                break;
            Case "P":
                $f=diferencia_años($fecha_ing_a,$fecha_hasta); if($f<0){$f=0;}
                break;
			 Case "O":
                //$f=diferencia_años($fecha_ing_a,$fecha_hasta); if($f<0){$f=0;}
				$temp_fh=colocar_udiames($fecha_hasta);
				$f=diferencia_meses($fecha_ing_a,$temp_fh); if($f<0){$f=0;}else{$f=$f/12;}
				$f=intval($f);
				break;
             Case "A":
                If(($a_dic=="D") Or ($a_dic=="C")){$f=0; $tempf=operacion_mes($fecha_desde,-1); $tempf=colocar_udiames($tempf); $m1=substr($fecha_ing,3,2); $m2=substr($tempf,3,2);
                  if($m1=$m2){ $tempf=formato_aaaammdd($tempf);
                    $StrSQL="SELECT c_presta_adic,dias_adicionales From NOM030 Where (cod_empleado='$cod_empleado') and (fecha_calculo>='$tempf') order by cod_empleado,fecha_calculo"; $resp=pg_query($StrSQL);
                    while(($regp=pg_fetch_array($resp))and($f==0)){ If($a_dic=="D"){$f=$regp["c_presta_adic"];}else{$f=$regp["dias_adicionales"];} }
                  }
                }
                else{
				 if($a_dic=="P"){ if(fdate($fecha_ing)>fdate($fecha_ley)){$tempf=$fecha_ing;}else{$tempf=$fecha_ley;} $f=diferencia_años($tempf,$fecha_hasta); if($f<0){$f=0;}
                 If($Dias_Adic_Primer=="S"){$f=$f;}else{$f=$f-1;}
                 If(($f*2)<30){ If($Acum_Dias_Adic=="N"){$f=($f*2);}else{If($f>0){$f=2;}}}
                  else{ If($Acum_Dias_Adic=="N"){$f=30;}else{$f=2;} }
                 }
				 if ($a_dic=="A"){$f=diferencia_años($fecha_ing,$fecha_hasta);   if($Cod_Emp=="02"){ $f=diferencia_años($fecha_ing,$fecha_desde); }
				   $m1=FDate($fecha_h_sem); $m2=FDate($fecha_hasta); if($m1<$m2){ $f=diferencia_años($fecha_ing,$fecha_h_sem); }
				 }				 
				}
                if($f<0){$f=0;}
				//echo $cod_empleado.' '.$cod_concepto.' '.$fecha_ing." 1 ".$fecha_hasta." ".$formula.' '.$a_dic.' RETORNA '.$f,"<br>";
                break;
		     Case "C": 
				if ($a_dic=="A"){ $fecha1=$fecha_ing; $fecha1=substr($fecha1,0,6).substr($fecha_hasta,6,4);  $tfecha_h=colocar_udiames($fecha_hasta);
				   $m1=FDate($fecha1); $m2=FDate($fecha_desde); $m3=FDate($tfecha_h);
				   $a=diferencia_años($fecha_ing,$tfecha_h); $f=0;
				   if($a>0){if(($m1>=$m2)and($m1<=$m3)){$f=$a;} }
				  // echo $fecha_ing." A1 ".$tfecha_h." ".$a." ".$f,"<br>";
				}	
				if ($a_dic=="P"){ $fecha1=$fecha_ing; $fecha1=substr($fecha1,0,6).substr($fecha_hasta,6,4); $tfecha_d="01".substr($fecha_desde,2,8);
				   $m1=FDate($fecha1); $m2=FDate($tfecha_d); $m3=FDate($fecha_hasta);
				   $a=diferencia_años($fecha_ing,$fecha_hasta); $f=0;
				   if($a>0){if(($m1>=$m2)and($m1<=$m3)){$f=$a;} }
				  // echo $fecha_ing." P1 ".$fecha_hasta." ".$a." ".$f,"<br>";
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
			  // echo "a ".$f,"<br>";
               //$f=parte_entera($f);
                $f = Round($f, 0);			   
			   //echo "b ".$f,"<br>";
			   break;
             Case "FABS":
               if($f<0){$f=$f*-1;}  break;
             Case "FNTD":
                $f = NRD($f);  break;
             Case "FRD":
                $f = RD($f);
				break;
             Case "FRTD":
                $f = Round($f, 2);
				break;
             Case "FRBD":
                $f = RDB($f);
				break;
          }
        }
       }}
     }
   }
 }
 //if($cod_concepto=="050"){echo $formula.' '.$a_dic.' RETORNA '.$f,"<br>"; } 
return $f;}
function factor2(){ global $Ch,$pos,$eofline,$formula,$a_dic,$cual,$fecha_nacimiento,$fecha_ing,$fecha_ing_a,$fecha_desde,$fecha_hasta,$status_trab,$fecha_c_sem,$fecha_h_sem,$cod_concepto,$campo_num1;
global $calculo1_val,$calculo2_val,$calculo_final_val,$Monto_Sueldo_SSO,$num_semanas,$cal_frecuencia,$cod_empleado,$campo502,$Cod_Emp; $f=0; $fecha_ley="19/06/1997"; $st=26;
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
    If(($a_dic=="M") Or ($a_dic=="T") Or ($a_dic=="C") Or ($a_dic=="R") Or ($a_dic=="N") Or ($a_dic=="H")  Or ($a_dic=="J") Or ($a_dic=="A") Or ($a_dic=="P") Or ($a_dic=="O") Or ($a_dic=="S") Or ($a_dic=="V") Or ($a_dic=="X") Or ($a_dic=="Y") Or ($a_dic=="Z") Or ($a_dic=="Q") Or ($a_dic=="U") Or ($a_dic=="W") Or ($a_dic=="E") Or ($a_dic=="B") Or ($a_dic=="D") Or ($a_dic=="I")){
      NextCh();
      if(($Ch<>"-") And ($Ch<>"+") And ($Ch<>"/") And ($Ch<>"*") And ($Ch<>"^") And ($Ch<>$eofline)){$f=0; $EXY=strtoupper($Ch); NextCh();
        while(($Ch<>"-") And ($Ch<>"+") And ($Ch<>"/") And ($Ch<>"*") And ($Ch<>"^") And ($Ch<>$eofline)){$EXY=$EXY.strtoupper($Ch);  NextCh();} $l=strlen($EXY);
        if (($l==1) And (($a_dic=="R") Or ($a_dic=="N") Or ($a_dic=="A") Or ($a_dic=="P") Or ($a_dic=="O") Or ($a_dic=="U") Or ($a_dic=="E") Or ($a_dic=="S") Or ($a_dic==" ") Or ($a_dic=="B") Or ($a_dic=="D") Or ($a_dic=="H") Or ($a_dic=="J") Or ($a_dic=="C") Or ($a_dic=="Q") Or ($a_dic=="T") Or ($a_dic=="2"))) {
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
			   if ($a_dic=="H"){ $f=0; $StrSQL="select ci_partida,fecha_nac,edad  from nom009 where (parentesco='HIJO' or parentesco='HIJA') and (cod_empleado='$cod_empleado') order by ci_partida"; $resp=pg_query($StrSQL);
                    while($regp=pg_fetch_array($resp)){ $fecha_nac=$regp["fecha_nac"]; $e=$regp["edad"]; $e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_hasta); if($Cod_Emp=="02"){$e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_desde); } If($e<18){$f=$f+1;} }
			   }
			   if ($a_dic=="J"){ $f=0; $StrSQL="select ci_partida,fecha_nac,edad from nom009 where (parentesco='HIJO' or parentesco='HIJO GUARD' or parentesco='HIJA' or parentesco='HIJA GUARD') and (cod_empleado='$cod_empleado') order by ci_partida"; $resp=pg_query($StrSQL);
                    while($regp=pg_fetch_array($resp)){ $fecha_nac=$regp["fecha_nac"]; $e=$regp["edad"]; $e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_hasta); if($Cod_Emp=="02"){$e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_desde); }  If($e<18){$f=$f+1;} }
			    //echo "2 ".$f." ".$StrSQL,"<br>";
			   }
               if ($a_dic=="I"){ $f=0; if($grado_inst=="BACHILLER"){$f=1;} if($grado_inst=="PRIMARIA"){$f=2;} if($grado_inst=="BASICO"){$f=3;} if($grado_inst=="TECNICO MEDIO"){$f=4;} if($grado_inst=="TECNICO SUPERIOR"){$f=5;} if($grado_inst=="UNIVERSITARIO"){$f=6;} if($grado_inst=="MAESTRIA"){$f=7;} if($grado_inst=="DOCTORADO"){$f=8;} }
               if (($a_dic<>"S")and($a_dic<>"B")and($a_dic<>"D")and($a_dic<>"C")and($a_dic<>"T")and($a_dic<>"I")and($a_dic<>"H")and($a_dic<>"J")){ $f=diferencia_años(formato_ddmmaaaa($fecha_nacimiento),$fecha_hasta); }
               break;
             Case "T":
               $f=0;
               if ($a_dic=="A"){$f=$campo_num1;}
			   else{if($status_trab=="ACTIVO"){$f=1;} if($status_trab=="VACACIONES"){$f=2;} if($status_trab=="PERMISO RE"){$f=3;}    if($status_trab=="PERMISO NO"){$f=3;} }
               break;
            Case "S":  // numero de semanas
               if ($a_dic=="S"){$f=$Monto_Sueldo_SSO;}   // sueldo sso
                else{$f=$num_semanas;  $m1=FDate($fecha_c_sem); $m2=FDate($fecha_desde); $a=0;
				if($m1>$m2){$f=Asigna_Nro_Semanas($fecha_c_sem,$fecha_hasta);}else{ $m1=FDate($fecha_h_sem); $m2=FDate($fecha_hasta); if($m1<$m2){$a=1; $f=Asigna_Nro_Semanas($fecha_desde,$fecha_h_sem);	} }
				if($f>$num_semanas){$f=$num_semanas;} } 
				// echo $cod_empleado.' '.$cod_concepto.' '.$fecha_ing." A1 ".$fecha_c_sem." ".$fecha_h_sem." ".$a." ".$f." ".$fecha_desde." ".$fecha_hasta,"<br>";
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
                $f=diferencia_meses($fecha_ing,$fecha_hasta); if($f<0){$f=0;}
                break;
             Case "P":
                $f=diferencia_años($fecha_ing_a,$fecha_hasta); if($f<0){$f=0;}
                break;
			 Case "O":
                //$f=diferencia_años($fecha_ing_a,$fecha_hasta); if($f<0){$f=0;}
				$temp_fh=colocar_udiames($fecha_hasta);
				$f=diferencia_meses($fecha_ing_a,$temp_fh); if($f<0){$f=0;}else{$f=$f/12;}
				$f=intval($f);
                break;	
             Case "A":
                If(($a_dic=="D") Or ($a_dic=="C")){$f=0; $tempf=operacion_mes($fecha_desde,-1); $tempf=colocar_udiames($tempf); $m1=substr($fecha_ing,3,2); $m2=substr($tempf,3,2);
                  if($m1=$m2){ $tempf=formato_aaaammdd($tempf);
                    $StrSQL="SELECT c_presta_adic,dias_adicionales From NOM030 Where (cod_empleado='$cod_empleado') and (fecha_calculo>='$tempf') order by cod_empleado,fecha_calculo"; $resp=pg_query($StrSQL);
                    while(($regp=pg_fetch_array($resp))and($f==0)){ If($a_dic=="D"){$f=$regp["c_presta_adic"];}else{$f=$regp["dias_adicionales"];} }
                  }
                }
                else{
				 if($a_dic=="P"){ if(fdate($fecha_ing)>fdate($fecha_ley)){$tempf=$fecha_ing;}else{$tempf=$fecha_ley;} $f=diferencia_años($tempf,$fecha_hasta); if($f<0){$f=0;}
                 If($Dias_Adic_Primer=="S"){$f=$f;}else{$f=$f-1;}
                 If(($f*2)<30){ If($Acum_Dias_Adic=="N"){$f=($f*2);}else{If($f>0){$f=2;}}}
                  else{ If($Acum_Dias_Adic=="N"){$f=30;}else{$f=2;} }
                 }				 
				 if ($a_dic=="A"){$f=diferencia_años($fecha_ing,$fecha_hasta);  if($Cod_Emp=="02"){ $f=diferencia_años($fecha_ing,$fecha_desde); }
				   $m1=FDate($fecha_h_sem); $m2=FDate($fecha_hasta); if($m1<$m2){ $f=diferencia_años($fecha_ing,$fecha_h_sem); }
				 }			 
				}
                if($f<0){$f=0;}
				//echo $cod_empleado.' '.$cod_concepto.' '.$fecha_ing." 2 ".$fecha_hasta." ".$formula.' '.$a_dic.' RETORNA '.$f,"<br>";
                break;
			  Case "C": 
				if ($a_dic=="A"){ $fecha1=$fecha_ing; $fecha1=substr($fecha1,0,6).substr($fecha_hasta,6,4);  $tfecha_h=colocar_udiames($fecha_hasta);
				   $m1=FDate($fecha1); $m2=FDate($fecha_desde); $m3=FDate($tfecha_h);
				   $a=diferencia_años($fecha_ing,$tfecha_h); $f=0;
				   if($a>0){if(($m1>=$m2)and($m1<=$m3)){$f=$a;} }
				  // echo $fecha_ing." A1 ".$tfecha_h." ".$a." ".$f,"<br>";
				}	
				if ($a_dic=="P"){ $fecha1=$fecha_ing; $fecha1=substr($fecha1,0,6).substr($fecha_hasta,6,4); $tfecha_d="01".substr($fecha_desde,2,8);
				   $m1=FDate($fecha1); $m2=FDate($tfecha_d); $m3=FDate($fecha_hasta);
				   $a=diferencia_años($fecha_ing,$fecha_hasta); $f=0;
				   if($a>0){if(($m1>=$m2)and($m1<=$m3)){$f=$a;} }
				  // echo $fecha_ing." P1 ".$fecha_hasta." ".$a." ".$f,"<br>";
				}			
				break;
			 Case "V":
			    $f=0;				
				break;
             default:
               $f=$calculo_final_val; break;
           }
        } else{ $l=strlen($EXY); if($l>=1){ $cual=$a_dic; $f=Valor_Concepto($EXY); } else{ $f=0; } }
      }
   } else { $found=false; $f=0; 
       for ($i=0; $i<$st; $i++) { if($found==false){ $l=strlen($StandardFunction[$i]);
        if(substr($formula,$pos-1,$l)==$StandardFunction[$i]){
          $pos=$pos+$l; NextCh(); $f=factor2();
          switch($StandardFunction[$i]){
             Case "FFRAC":
               $f=$f-parte_entera($f);  break;
             Case "FINT":
               //$f=parte_entera($f);  
			   $f = Round($f, 0);
			   break;
             Case "FABS":
               if($f<0){$f=$f*-1;}  break;
             Case "FNTD":
                $f = NRD($f);  break;
             Case "FRD":
                $f = RD($f); break;
             Case "FRTD":
                $f = Round($f, 2); break;
             Case "FRBD":
                $f = RDB($f); break;
          }
        }
       }}
     }
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
 //echo $formula.' '.$calculo_final_val,"<br>";
 return $calculo_final_val;} 
?>