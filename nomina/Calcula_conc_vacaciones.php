<?include ("../class/conect.php"); include ("../class/funciones.php"); include ("../class/configura.inc"); $fecha_hoy=asigna_fecha_hoy(); $eofline="@";
$codigo_mov=$_GET["codigo_mov"]; $cod_empleado=$_GET["cod_empleado"];$fecha_desde=$_GET["fdesde"];$fecha_hasta=$_GET["fhasta"]; $fecha_d_desde=$_GET["fddesde"];$fecha_d_hasta=$_GET["fdhasta"]; $mbono=$_GET["mbono"]; $dbono=$_GET["dbono"]; $cant_cal=$_GET["cant_cal"]; $mbase=$_GET["mbase"]; $mdianh=$_GET["mdianh"];
$fecha_nacimiento=""; $tipo_nomina=""; $mbono=formato_numero($mbono); $dbono=formato_numero($dbono); $mbase=formato_numero($mbase); $mdianh=formato_numero($mdianh); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else{ $Nom_Emp=busca_conf(); }
$sql="Select * from TRABAJADORES where cod_empleado='$cod_empleado'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
if($filas>=1){ $registro=pg_fetch_array($res); $error=0; 
  $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; $nacionalidad=$registro["nacionalidad"]; $nombre=$registro["nombre"]; $status=$registro["status"];  
  $fecha_ing=$registro["fecha_ingreso"]; $fecha_ing_a=$registro["fecha_ing_adm"]; $tipo_nomina=$registro["tipo_nomina"]; $sueldo=$registro["sueldo"]; $fecha_nacimiento=$registro["fecha_nacimiento"];
}
$nro_semanas=Asigna_Nro_Semanas($fecha_desde,$fecha_hasta); $num_semanas=$nro_semanas;
//echo "Semanas: ".$nro_semanas,"<br>";
$fecha_pago_vac=$fecha_hoy; $pago_vacaciones="N"; $num_recibo=0; $redondear="N"; $bloqueada="N"; $u_semana="S"; $fecha_proc_d=$fecha_desde;
$calculo1_val=0; $calculo2_val=0; $calculo_final_val=0; $a_dic=""; $pos=0; $formula=""; $opr=""; $cual=""; $Ch=""; $EXY="";  $valor=0; 
function Conv_Num($mval) {$fmonto=$mval*1; return $fmonto;}
function frecuencia_valida($frecn,$cal_frec,$cfrec,$u_sem){$mval=false;
if($frecn=="Q"){ if(($cfrec==1)and($cal_frec==1)){$mval=true;} if(($cfrec==2)and($cal_frec==2)){$mval=true;} if($cfrec==3){$mval=true;} }
if($frecn=="S"){ if(($cfrec==4)and($cal_frec==1)){$mval=true;} if(($cfrec==5)and($cal_frec==2)){$mval=true;} if(($cfrec==6)and($cal_frec==3)){$mval=true;} if(($cfrec==7)and($cal_frec==4)){$mval=true;} if(($cfrec==8)and($cal_frec==5)){$mval=true;}  if($cfrec==9){$mval=true;} if(($cfrec==0)and($u_sem=="S")){$mval=true;} }
if($frecn=="M"){$mval=true;}
return $mval;}
function NextCh(){global $formula,$pos,$eofline,$Ch,$EXY;  $nextcont=0; $l=strlen($formula);  //echo $pos.' '.$formula.' '.$l;
 while($nextcont==0){$pos=$pos+1;  if($pos>$l){$Ch=$eofline;}else{$Ch=substr($formula,$pos-1,1);}  if($Ch<>" "){$nextcont=1;} } }
function Valor_Concepto_Historico($codigo){  global $cual,$fecha_hasta,$cod_empleado,$tipo_nomina,$fecha_proc_d,$codigo_mov,$cod_concepto;
  $H=0; $Total=0;  $Cantidad=0;  $Mayor=0; $Menor=9999999999.99;
  If(strlen($codigo)>=16){$Cual=substr($codigo,16,1);}else{$Cual="T";}
  $Desde=substr($codigo,6,6); $Hasta=substr($codigo,13,6); $mcod_concepto=substr($codigo,2,3); $tDesde=$Desde;
  If($Desde=="ANTEMM"){$F_Desde=colocar_pdiames($fecha_hasta);  $F_Desde=nextmes($F_Desde,-1); $Desde=substr($F_Desde,6,4).substr($F_Desde,3,2); $Hasta=$Desde;  }
  If(($Desde=="AAAAMM")or(is_numeric($Desde)==false)){$Desde=substr($fecha_hasta, 6, 4).substr($fecha_hasta, 3, 2); }
  If(($Hasta=="AAAAMM")or(is_numeric($Hasta)==false)){$Hasta=substr($fecha_hasta, 6, 4).substr($fecha_hasta, 3, 2); }
  $F_Desde = colocar_pdiames("01/".substr($Desde,4,2)."/".substr($Desde,0,4));
  $F_Hasta = colocar_udiames("01/".substr($Hasta,4,2)."/".substr($Hasta,0,4));
  $t_desde = formato_aaaammdd($fecha_proc_d);  $tcd=FDate($F_Desde); $tpd=FDate($fecha_proc_d);
  $F_Desde = formato_aaaammdd($F_Desde);   $F_Hasta = formato_aaaammdd($F_Hasta);    $mcod_concepto=substr($codigo,2,3);  
  If(($tDesde=="AAAAMM")and($tpd>=$tcd)){ $tfechah="15/".substr($Desde,4,2)."/".substr($Desde,0,4); $F_Hasta=formato_aaaammdd($tfechah);
    $StrSQL="SELECT * FROM NOM076 where (codigo_mov='$codigo_mov') and (cod_concepto='$mcod_concepto') and (fecha_hasta='$F_Hasta')"; $resp=pg_query($StrSQL);
    while(($regp=pg_fetch_array($resp))){ $valor=$regp["valor"]; $Cantidad=$Cantidad+1; $Total=$Total+$valor;    }
  }else{
  $StrSQL="select cod_empleado,tipo_nomina,cod_concepto,fecha_nomina,monto from nom018 Where (cod_empleado='$cod_empleado') and (tipo_nomina='$tipo_nomina') and (cod_concepto='$mcod_concepto') and (fecha_nomina>='$F_Desde') and (fecha_nomina<='$F_Hasta') order by cod_empleado,fecha_nomina"; $resp=pg_query($StrSQL);
  while(($regp=pg_fetch_array($resp))){ $Cantidad=$Cantidad+1; $Total=$Total+$regp["monto"];  If ($regp["monto"]>$Mayor){$Mayor=$regp["monto"];}  If ($regp["monto"]<$Menor){$Menor=$regp["monto"];} }
  }
  //IF($mcod_concepto=="005"){ echo $StrSQL." ".$Desde." ".$tpd." ".$tcd." ".$cod_concepto,"<br>"; }
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
function Valor_Concepto($codigo){global $cual,$codigo_mov,$cod_concepto,$valorx,$valorw,$valory,$valorz,$fechah,$valorz,$valorv,$valore,$valoru,$valorq;
 $cual=strtoupper($cual); $v=0;
 If($cual=="H"){$v=Valor_Concepto_Historico($codigo);}
  else{ $mcodigo=substr($codigo,2,3); 
    $sqlc="SELECT * FROM NOM076 where (codigo_mov='$codigo_mov') and (cod_concepto='$mcodigo') and (fecha_hasta='$fechah')"; $resc=pg_query($sqlc);
	while($regc=pg_fetch_array($resc)){
        switch($cual){
         Case "C":
           $v=$regc["cantidad"]; break;
         Case "M":
           $v=$regc["monto_orig"]; break;
         Case "T":
           $v=$regc["valor"]; break;
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
  }
return $v;}
function factor(){ global $Ch,$pos,$eofline,$formula,$a_dic,$cual,$fecha_nacimiento,$fecha_ing,$fecha_ing_a,$fecha_desde,$fecha_hasta,$status_trab,$fecha_c_sem;
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
    If(($a_dic=="M") Or ($a_dic=="T") Or ($a_dic=="C") Or ($a_dic=="R") Or ($a_dic=="N") Or ($a_dic=="H") Or ($a_dic=="A") Or ($a_dic=="P") Or ($a_dic=="S") Or ($a_dic=="V") Or ($a_dic=="X") Or ($a_dic=="Y") Or ($a_dic=="Z") Or ($a_dic=="Q") Or ($a_dic=="U") Or ($a_dic=="W") Or ($a_dic=="E") Or ($a_dic=="B") Or ($a_dic=="D") Or ($a_dic=="I")){
      NextCh();
      if(($Ch<>"-") And ($Ch<>"+") And ($Ch<>"/") And ($Ch<>"*") And ($Ch<>"^") And ($Ch<>$eofline)){$f=0; $EXY=strtoupper($Ch); NextCh();
        while(($Ch<>"-") And ($Ch<>"+") And ($Ch<>"/") And ($Ch<>"*") And ($Ch<>"^") And ($Ch<>$eofline)){$EXY=$EXY.strtoupper($Ch);  NextCh();} $l=strlen($EXY);
        if (($l==1) And (($a_dic=="R") Or ($a_dic=="N") Or ($a_dic=="A") Or ($a_dic=="P") or ($a_dic=="H") Or ($a_dic=="U") Or ($a_dic=="E") Or ($a_dic=="S") Or ($a_dic==" ") Or ($a_dic=="B") Or ($a_dic=="D") Or ($a_dic=="C") Or ($a_dic=="T") Or ($a_dic=="2"))) {
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
               if ($a_dic=="I"){ $f=0; if($grado_inst=="BACHILLER"){$f=1;} if($grado_inst=="PRIMARIA"){$f=2;} if($grado_inst=="BASICO"){$f=3;} if($grado_inst=="TECNICO MEDIO"){$f=4;} if($grado_inst=="TECNICO SUPERIOR"){$f=5;} if($grado_inst=="UNIVERSITARIO"){$f=6;} if($grado_inst=="MAESTRIA"){$f=7;} if($grado_inst=="DOCTORADO"){$f=8;} }
               if ($a_dic=="H"){ $f=0; $StrSQL="select ci_partida,fecha_nac,edad from nom009 where (parentesco='HIJO' or parentesco='HIJA') and (cod_empleado='$cod_empleado') order by ci_partida"; $resp=pg_query($StrSQL);
                    while($regp=pg_fetch_array($resp)){ $fecha_nac=$regp["fecha_nac"];  $e=$regp["edad"]; $e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_hasta); 
					   If($e<13){$f=$f+1;} }
			   }
			   if (($a_dic<>"S")and($a_dic<>"B")and($a_dic<>"D")and($a_dic<>"C")and($a_dic<>"T")and($a_dic<>"H")and($a_dic<>"I")){ $f=diferencia_años(formato_ddmmaaaa($fecha_nacimiento),$fecha_hasta); }
               break;
             Case "T":
               $f=0;
               if($status_trab=="ACTIVO"){$f=1;} if($status_trab=="VACACIONES"){$f=2;} if($status_trab=="PERMISO RE"){$f=3;}    if($status_trab=="PERMISO NO"){$f=3;}
               break;
             Case "S":  // numero de semanas
               if ($a_dic=="S"){$f=$Monto_Sueldo_SSO;}   // sueldo sso
                else{$f=$num_semanas;  $m1=FDate($fecha_c_sem); $m2=FDate($fecha_desde); if($m1>$m2){$f=Asigna_Nro_Semanas($fecha_c_sem,$fecha_hasta);} if($f>$num_semanas){$f=$num_semanas;} }
               break;
             Case "Q":
               $f=$cal_frecuencia;
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
function factor2(){ global $Ch,$pos,$eofline,$formula,$a_dic,$cual,$fecha_nacimiento,$fecha_ing,$fecha_ing_a,$fecha_desde,$fecha_hasta,$status_trab,$fecha_c_sem;
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
    If(($a_dic=="M") Or ($a_dic=="T") Or ($a_dic=="C") Or ($a_dic=="R") Or ($a_dic=="N") Or ($a_dic=="H") Or ($a_dic=="A") Or ($a_dic=="P") Or ($a_dic=="S") Or ($a_dic=="V") Or ($a_dic=="X") Or ($a_dic=="Y") Or ($a_dic=="Z") Or ($a_dic=="Q") Or ($a_dic=="U") Or ($a_dic=="W") Or ($a_dic=="E") Or ($a_dic=="B") Or ($a_dic=="D") Or ($a_dic=="I")){
      NextCh();
      if(($Ch<>"-") And ($Ch<>"+") And ($Ch<>"/") And ($Ch<>"*") And ($Ch<>"^") And ($Ch<>$eofline)){$f=0; $EXY=strtoupper($Ch); NextCh();
        while(($Ch<>"-") And ($Ch<>"+") And ($Ch<>"/") And ($Ch<>"*") And ($Ch<>"^") And ($Ch<>$eofline)){$EXY=$EXY.strtoupper($Ch);  NextCh();} $l=strlen($EXY);
        if (($l==1) And (($a_dic=="R") Or ($a_dic=="N") Or ($a_dic=="A") Or ($a_dic=="P") or ($a_dic=="H") Or ($a_dic=="U") Or ($a_dic=="E") Or ($a_dic=="S") Or ($a_dic==" ") Or ($a_dic=="B") Or ($a_dic=="D") Or ($a_dic=="C") Or ($a_dic=="T") Or ($a_dic=="2"))) {
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
               if ($a_dic=="I"){ $f=0; if($grado_inst=="BACHILLER"){$f=1;} if($grado_inst=="PRIMARIA"){$f=2;} if($grado_inst=="BASICO"){$f=3;} if($grado_inst=="TECNICO MEDIO"){$f=4;} if($grado_inst=="TECNICO SUPERIOR"){$f=5;} if($grado_inst=="UNIVERSITARIO"){$f=6;} if($grado_inst=="MAESTRIA"){$f=7;} if($grado_inst=="DOCTORADO"){$f=8;} }
               if ($a_dic=="H"){ $f=0; $StrSQL="select ci_partida,fecha_nac,edad from nom009 where (parentesco='HIJO' or parentesco='HIJA') and (cod_empleado='$cod_empleado') order by ci_partida"; $resp=pg_query($StrSQL);
                    while($regp=pg_fetch_array($resp)){ $fecha_nac=$regp["fecha_nac"];  $e=$regp["edad"]; $e=diferencia_años(formato_ddmmaaaa($fecha_nac),$fecha_hasta); 
					   If($e<13){$f=$f+1;} }
			   }			   
			   if (($a_dic<>"S")and($a_dic<>"B")and($a_dic<>"D")and($a_dic<>"C")and($a_dic<>"T")and($a_dic<>"H")and($a_dic<>"I")){ $f=diferencia_años(formato_ddmmaaaa($fecha_nacimiento),$fecha_hasta); }
               break;
             Case "T":
               $f=0;
               if($status_trab=="ACTIVO"){$f=1;} if($status_trab=="VACACIONES"){$f=2;} if($status_trab=="PERMISO RE"){$f=3;}    if($status_trab=="PERMISO NO"){$f=3;}
               break;
             Case "S":  // numero de semanas
               if ($a_dic=="S"){$f=$Monto_Sueldo_SSO;}   // sueldo sso
                else{$f=$num_semanas;  $m1=FDate($fecha_c_sem); $m2=FDate($fecha_desde); if($m1>$m2){$f=Asigna_Nro_Semanas($fecha_c_sem,$fecha_hasta);} if($f>$num_semanas){$f=$num_semanas;} }
               break;
             Case "Q":
               $f=$cal_frecuencia;
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
$url="Det_inc_cal_vac.php?codigo_mov=".$codigo_mov; 
$cant_trab=0; $hora1=time();  $campo502="NNNNNNNNNNNNNNNNNNN"; $error=0;  $Monto_Sueldo_SSO=0; $cod_grupo=""; $cod_conc_vac="105"; $cod_conc_sueldo="001";
$sql="Select campo502,campo535  from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $Monto_Sueldo_SSO=$registro["campo535"];} $proc_vac_nom=substr($campo502,5,1);
if($error==0){$sSQL="Select * from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA NO EXISTE');</script><?}else{$registro=pg_fetch_array($resultado);  $g_orden_pago=$registro["g_orden_pago"]; $frec_nom=$registro["frecuencia"]; $num_semana=$registro["nro_semana"]; $des_nomina=$registro["descripcion"]; $desc_grupo=$registro["desc_grupo"]; $redondear=$registro["redondear"]; $bloqueada=$registro["bloqueada"];$con_cal_vac=$registro["con_cal_vac"];$con_bon_vac=$registro["con_bon_vac"];$con_cal_vac=$registro["con_cal_vac"]; $con_bon_vac_ant=$registro["con_bon_vac"]; $cod_grupo=$registro["cod_grupo"]; if(trim($cod_grupo)==""){$cod_grupo="00";} }}
if($error==0){$cal_frecuencia=1; $dia=substr($fecha_hasta,0,2); if($frec_nom=="Q"){if($dia==15){$cal_frecuencia=1;}else{$cal_frecuencia=2;} } }
if($error==0){if(checkData($fecha_desde)=='1'){$fechad=formato_aaaammdd($fecha_desde);}else{$error=1;?><script language="JavaScript">muestra('FECHA DESDE NO ES VALIDA');</script><?}}
if($error==0){if(checkData($fecha_hasta)=='1'){$fechah=formato_aaaammdd($fecha_hasta);}else{$error=1;?><script language="JavaScript">muestra('FECHA HASTA NO ES VALIDA');</script><?}}
if($error==0){ $fecha_proc_h=$fecha_hasta; $f_proc_h=$fechah; $cant_cal=0; $frec=$frec_nom; $fecha_proc_d=$fecha_desde;
$mf=FDate($fecha_hasta);  $md=FDate($fecha_desde); $fin_ciclo=0; $mdia=$mbase/30; $resto_mdianh=0;
while(($mf>=$md)and($fin_ciclo==0)){ $cambio_periodo="N";
 if($cant_cal>0){ $fecha_desde=nextDate($fecha_hasta,1);} 
 if($frec=="M"){$fecha_hasta=colocar_udiames($fecha_desde);} 
 if($frec=="S"){$fecha_hasta=nextDate($fecha_desde,6);$nro_semanas=$num_semana+1;} 
 if($frec=="Q"){$dia=substr($fecha_desde,0,2); $fecha_hasta=colocar_udiames($fecha_desde); if($dia=='01'){$fecha_hasta=nextDate($fecha_desde,14);}   
   $edia=$dia*1;; if($edia<15){$fecha_hasta="15".substr($fecha_desde,2,8);}
 }
 if($error==0){if(checkData($fecha_desde)=='1'){$fechad=formato_aaaammdd($fecha_desde);}else{$error=1;?><script language="JavaScript">muestra('FECHA DESDE NO ES VALIDA');</script><?}}
 if($error==0){if(checkData($fecha_hasta)=='1'){$fechah=formato_aaaammdd($fecha_hasta);}else{$error=1;?><script language="JavaScript">muestra('FECHA HASTA NO ES VALIDA');</script><?}}
 $mh=FDate($fecha_hasta); $temp_f_hasta=$fecha_hasta;
 if($mh>$mf){$fecha_hasta=$fecha_proc_h; $fechah=$f_proc_h;  $cambio_periodo="S";  }
 $nro_semanas=Asigna_Nro_Semanas($fecha_desde,$fecha_hasta); if($Cod_Emp=="71"){$nro_semanas=Asigna_Nro_Semanas($fecha_desde,$temp_f_hasta);} $num_semanas=$nro_semanas; 
 $md=FDate($fecha_desde); $monto_sueldo=0; 
 $cal_frecuencia=1; $dia=substr($fecha_hasta,0,2); if($frec_nom=="Q"){if($dia<=15){$cal_frecuencia=1;}else{$cal_frecuencia=2;} } 
 if ($mf<$md){$error=1; $fin_ciclo=1;}else{echo "Periodo desde: ".$fecha_desde." Hasta:".$fecha_hasta." Semanas: ".$nro_semanas." ".$cal_frecuencia,"<br>";}
 //echo $mh." ".$md." ".$mf." ".$fechad." ".$fechah,"<br>"; 
 $monto_303=0; $cod_presup_temp=""; $cod_contable_temp="";
 $sql="select * from CAL_NOMINA where (tipo_nomina='$tipo_nomina') and (cod_empleado='$cod_empleado') and (fecha_ingreso<='$fechah') and (fecha_egreso>='$fechad') order by tipo_nomina,cod_departam,cod_cargo,cod_empleado";  $res=pg_query($sql);  $filas=pg_num_rows($res);
 if(($filas>0)and($error==0)){ $reg=pg_fetch_array($res); $cod_empleado=$reg["cod_empleado"]; $status_trab=$reg["status"]; $pago_vacaciones=$reg["pago_vaciones"]; $fecha_pago_vac=$reg["fecha_pago"];  $cedula=$reg["cedula"]; $nacionalidad=$reg["nacionalidad"]; $nombre=$reg["nombre"]; $fecha_ingreso=$reg["fecha_ingreso"]; $cod_cargo=$reg["cod_cargo"]; $cod_departam=$reg["cod_departam"]; $cod_tipo_personal=$reg["cod_tipo_personal"]; $fecha_ing_adm=$reg["fecha_ing_adm"];
  $des_cargo=$reg["denominacion"]; $des_departam=$reg["descripcion_dep"]; $des_tipo_personal=$reg["des_tipo_personal"]; $sueldo=$reg["sueldo"]; $compensacion=$reg["compensacion"]; $prima=$reg["prima"]; $sueldo_integral=$reg["sueldo"]+ $reg["prima"]+$reg["compensacion"]; $otros=$reg["otros"]; $tipo_pago=$reg["tipo_pago"];  $cta_empleado=$reg["cta_empleado"];  $cta_empresa=$reg["cta_empresa"]; $cod_banco=$reg["cod_banco"]; $nombre_banco=$reg["nombre_banco"]; $cod_ubicacion=$reg["codigo_ubicacion"]; $sexo=$reg["sexo"];
  $edo_civil=substr($reg["edo_civil"],0,1); if($reg["edo_civil"]=="CONCUBINO"){$edo_civil="U";} $tipo_cuenta=substr($reg["tipo_cuenta"],0,1); if($tipo_cuenta==""){$tipo_cuenta="N";} $status_calculo=$reg["cont_fijo"].substr($nacionalidad,0,1).$tipo_cuenta.substr($reg["sexo"],0,1).$edo_civil;  $des_ubicacion=$reg["descripcion_ubi"]; $fecha_egreso=$reg["fecha_egreso"];  $fecha_nacimiento=$reg["fecha_nacimiento"];  $grado_inst=$reg["grado_inst"]; $fecha_ing=formato_ddmmaaaa($fecha_ingreso);  $fecha_ing_a=formato_ddmmaaaa($fecha_ing_adm);
  $fecha_c_sem=$fecha_ing; $cant_cal=$cant_cal+1; $cant_105=15;
  $tiene_aus_pro=$reg["tiene_aus_pro"]; $motivo_ausencia=$reg["motivo_ausencia"];  $fecha_aus_desde=$reg["fecha_aus_desde"]; $fecha_aus_hasta=$reg["fecha_aus_hasta"]; $camb_fecha_exp='N';
  //echo $cod_empleado."  ".$status_trab."  ".$fecha_aus_hasta." ".$fechah,"<br>";
  if((($status_trab=="VACACIONES")or($status_trab=="ACTIVO"))and($status_trab<>"REPOSO")and($tiene_aus_pro=="S")and($fecha_aus_hasta>$fechad)and($fecha_aus_hasta<$fechah)){ $status_trab="ACTIVO"; $camb_fecha_exp='S'; $fecha_c_sem=formato_ddmmaaaa($fecha_aus_hasta); }
  //echo $status_trab." B ".$fecha_aus_hasta." ".$fechah,"<br>";   
  $fecha_fin_c=formato_ddmmaaaa($reg["fecha_fin_con"]);
  if($reg["cont_fijo"]=="F"){$continua=0;}else{ $numf1=fdate($fecha_fin_c);  $numf2=fdate($fecha_desde); if($numf1>$numf2){$continua=0;}else{$continua=1;  }}   $MNeto=0; $MAsignacion=0; $MDeduccion=0;
   if($continua==0){$cant_trab=$cant_trab+1;  $MNeto=0; $MAsignacion=0; $MDeduccion=0;   
   if(($status_trab=="ACTIVO")and(($fecha_aus_hasta<$fechah)and($fecha_aus_hasta>$fechad))and($motivo_ausencia=="REPOSO")){$status_trab="REPOSO"; }
   If(($status_trab=="ACTIVO") Or ($status_trab=="PERMISO RE")  Or ($status_trab=="REPOSO")  Or (($status_trab=="VACACIONES") And ($reg["tipo_vacaciones"]=="S") And ($proc_vac_nom=="S"))){  
     if($cant_cal==1){$sSQL="SELECT ELIMINA_NOM076('$codigo_mov')"; $resultado=pg_exec($conn,$sSQL);}  $num_recibo=$num_recibo+1; $l=strlen($num_recibo); $srecibo="00000".$num_recibo; $srecibo=substr($srecibo,$l,5); $nd_s=0;
     $sqla="SELECT * FROM CONCEPTOS_ASIGNADOS WHERE (activo='SI')  And (substring(status,1,1)='S') And (activoa='SI') And  (tipo_nomina='$tipo_nomina') And (cod_empleado='$cod_empleado') order by cod_empleado,cod_orden,cod_concepto"; $resa=pg_query($sqla);
     //echo $sqla,"<br>";
	 $paso_bono_vac=0;
	 while(($rega=pg_fetch_array($resa))and($error==0)){ $cod_concepto=$rega["cod_concepto"]; $den_concepto=$rega["denominacion"]; $cod_orden=$rega["cod_orden"]; $fecha_exp=$rega["fecha_exp"]; $fecha_ini=$rega["fecha_ini"]; $frecuenciaa=$rega["frecuenciaa"]; $frecuencia=$rega["frecuencia"]; $frec_valida="S";  $calculable=$rega["calculable"]; $status=$rega["status"]; $concepto_vac="N"; if($camb_fecha_exp=='S'){ $fecha_ini=$fecha_aus_hasta; }
      if($fechad<=$fecha_exp){ $continua=0;  if(frecuencia_valida($frec_nom,$cal_frecuencia,$frecuencia,$u_semana)==false){$continua=1;} if(frecuencia_valida($frec_nom,$cal_frecuencia,$frecuenciaa,$u_semana)==false){$continua=1;} 
       if($continua==0){$calculable=$rega["calculable"]; $asignacion=$rega["asignacion"]; $oculto=$rega["oculto"]; $acumula=$rega["acumula"]; $tipo_a=$rega["tipo_asigna"]; $asig_ded_apo=$rega["asig_ded_apo"]; $prestamo=$rega["prestamo"]; $int_cal_vac=substr($status,0,1); $cantidad=$rega["cantidad"]; $monto_orig=$rega["monto"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $cod_contable=$rega["cod_contable"];$cod_presup=$rega["cod_presup"]; $afecta_presup=$rega["afecta_presup"]; $cod_retencion=$rega["cod_retencion"];
        $valor=$cantidad*$monto_orig; $valore=0; $valorq=0; $valoru=0; $valorv=0; $valorw=0; $valorx=0; $valory=0; $valorz=0; if($fecha_egreso<$fecha_exp){$fecha_exp=$fecha_egreso;} 
		//if(($prestamo=="S")and(($rega["nro_cuotas_c"]+1)<$rega["nro_cuotas"])){$calculable="N"; $valore=$rega["monto_prestamo"]; $valorq=$rega["nro_cuotas"]; $valoru=$rega["nro_cuotas_c"]+1; $cantidad=0;} $cantidad=cambia_coma_numero($cantidad); $valor=cambia_coma_numero($valor);		
		$temp_nroc_c=$rega["nro_cuotas_c"]+1; $temp_nroc=$rega["nro_cuotas"];
		if(($prestamo=="S")and($temp_nroc_c<=$temp_nroc)){$calculable="N"; $valore=$rega["monto_prestamo"]; $valorq=$rega["nro_cuotas"]; $valoru=$rega["nro_cuotas_c"]+1; $cantidad=0; $valor=$monto_orig;} 
		//if(($cod_concepto==$cod_conc_sueldo)and($cantidad>0)){ $oculto="SI";  $valor=0; $monto_sueldo=$monto_orig;  }		
		if($con_bon_vac==$cod_concepto){ $calculable="NO";  
		//if($paso_bono_vac==0)
		if($cant_cal==1){$valor=$mbono; $cantidad=$dbono; $paso_bono_vac=1;}	$concepto_vac="S"; $cod_presup_temp=$cod_presup; $cod_contable_temp=$cod_contable; }		
		//echo $cod_concepto." B ".$valor." ".$monto_orig,"<br>"; 
		if($Cod_Emp=="71"){
		  if(($cod_concepto==$cod_conc_vac)){ $ndif=15; if($frec_nom=="S"){$ndif=7;} if($frec_nom=="M"){$ndif=30;} $cantidad=$ndif;
			  $monto_orig=$mbase; $valor=$cantidad*$mdia;	$calculable="NO"; 
			  $temp_h=$fecha_hasta; $t_dia=substr($temp_h,0,2); if($t_dia=="31"){$temp_h="30".substr($temp_h,2,8);}
			  $dias_dif=diferencia_dias($fecha_desde,$temp_h)+1; 
			  $cantidad=($cantidad/$ndif)*$dias_dif; $valor=$cantidad*$mdia;
			  $monto_orig=$mdia*30;		  
		  }
		  if($cod_concepto=="005"){
			  $dia=substr($fecha_hasta,0,2); $cant_tdia=15; $dia_p=$dia*1;
			  $dias_dif=diferencia_dias($fecha_desde,$fecha_proc_h)+1;
			  If($dias_dif < 15){ $cant_tdia=$dias_dif; }
			  $tch=FDate($fecha_hasta); $tph=FDate($fecha_proc_h);			
			  If(($dia_p <> 15) and ($tph>=$tch)){	 $cant_tdia=$dia_p-15;	}	
			  //echo  $fecha_proc_d." ".$fecha_proc_h." ".$fecha_desde." ".$dias_dif." ".$cant_tdia." ".$dia_p." ".$mdianh." ".$resto_mdianh,"<br>";
			  If($fecha_proc_d==$fecha_desde){ $cant_tdia=$cant_tdia-$mdianh; } else { $cant_tdia=$cant_tdia-$resto_mdianh; }
			  If($fecha_proc_h==$fecha_hasta){ $cant_tdia=$dias_dif; }
			  if($cant_tdia<0) {  $resto_mdianh=$cant_tdia*-1; $cant_tdia=0;} else { $resto_mdianh=0; }
			  $calculable="NO"; $cantidad=$cant_tdia;  $monto_orig=$mbase; $valor=$cantidad*($mbase/30);  $cant_105=$cant_tdia;
		  }	  
		  if($cod_concepto=="182"){ $calculable="NO"; $cantidad=0;  $monto_orig=0; $valor=0;
		    If($fecha_proc_d==$fecha_desde){ $cantidad=$mdianh; $monto_orig=$mbase; $valor=$cantidad*($mbase/30);}
          }	
          if($cod_concepto=="011"){ $cantidad=0;  $monto_orig=0; $valor=0;	$dias_dif=0;	  
		    if($fecha_d_desde<>$fecha_desde){$dias_dif=diferencia_dias($fecha_d_desde,$fecha_desde)+1;   }		   
		    If(($fecha_proc_d==$fecha_desde)and($dias_dif>0)){ $cantidad=$dias_dif;}
			//echo $cod_concepto." ".$fecha_hasta." ".$fecha_proc_h." ".$fecha_d_desde." ".$fecha_desde." ".$cantidad,"<br>";
          }		 
          if(($cod_concepto=="094")or($cod_concepto=="095")or($cod_concepto=="036")){ 
		    $tch=FDate($fecha_hasta); $tph=FDate($fecha_proc_h);  $tch=FDate($temp_f_hasta);   $tph=FDate($fecha_d_hasta);
		    if($tph<$tch){ $calculable="NO"; $cantidad=0;  $monto_orig=0; $valor=0; }
			//echo $cod_concepto." ".$fecha_hasta." ".$fecha_proc_h." ".$tph." ".$tch,"<br>";
          }	
          if(($asig_ded_apo=="D")and($cambio_periodo=="S")and($cant_105==1)and($cod_concepto<>'506')){  $calculable='NO'; $cantidad=0; $monto_orig=0; $valor=0; }
          //echo $cod_concepto." ".$cambio_periodo." ".$fecha_desde." ".$fecha_d_desde.' '.$fecha_proc_d.' '.$cantidad,"<br>";		  
		}
		if(($asig_ded_apo=="D")and(($Cod_Emp=="88")or($Cod_Emp=="A1"))){ if($cod_presup_temp<>""){  $cod_presup=$cod_presup_temp;   $cod_contable=$cod_contable_temp;} }		
		if($Cod_Emp=="70"){
			if(($asig_ded_apo=="A")and($cambio_periodo=="S")){ if($cod_concepto=="303"){$calculable='SI';}
			 //echo $cod_concepto," ".$calculable,"<br>";
			}
			//if($cod_concepto==$cod_conc_vac){ $monto_303=$valor; $cant_105=$cantidad; }        
			if(($asig_ded_apo=="D")and($cambio_periodo=="S")and($cant_105<10)){		
			  if(($cod_concepto<>'500')and($cod_concepto<>'502')and($cod_concepto<>'505')and($cod_concepto<>'506')){ $calculable='NO'; $cantidad=0; $monto_orig=0; $valor=0; }
			} 
		}
		$cantidad=cambia_coma_numero($cantidad); $valor=cambia_coma_numero($valor); $monto_orig=cambia_coma_numero($monto_orig);
		$sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','$calculable','$asignacion','$acumula','$oculto','$tipo_a','$asig_ded_apo','$frec_valida','$prestamo','$concepto_vac','$int_cal_vac',$acumulado,$saldo,$valore,$valorq,$valoru,$valorv,$valorw,$valorx,$valory,$valorz,$cantidad,$valor,$monto_orig,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$fecha_ini','$fecha_exp','$fechah',$frecuenciaa,'$cod_orden')"; $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); 
		$error=substr($error,0,40); if(!$resultado){ echo $cod_concepto." ".$sSQL,"<br>"; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=11;}
        if($calculable=="NO"){if(($asig_ded_apo=="A")and($oculto=="NO")){$MAsignacion=$MAsignacion+$valor;} 
		if(($asig_ded_apo=="D")and($oculto=="NO")){$MDeduccion=$MDeduccion+$valor;}}
	  }}}
     $sqla="SELECT * FROM NOM076 where (codigo_mov='$codigo_mov') and (calculable='SI') and (fecha_hasta='$fechah') and (cod_concepto in (select cod_concepto from nom003 where tipo_nomina='$tipo_nomina')) order by cod_orden,cod_concepto"; $resa=pg_query($sqla);
     //echo $sqla,"<br>";
	 while(($rega=pg_fetch_array($resa))and($error==0)){ $cod_concepto=$rega["cod_concepto"]; $valor=$rega["valor"]; $cantidad=$rega["cantidad"]; $acumulado=$rega["acumulado"]; $saldo=$rega["saldo"]; $monto_orig=$rega["monto_orig"]; $valore=$rega["valore"]; $valoru=$rega["valoru"]; $valorq=$rega["valorq"]; $valorw=$rega["valorw"]; $valorx=$rega["valorx"]; $valory=$rega["valory"]; $valorz=$rega["valorz"]; $cod_orden=$rega["cod_orden"];
       $calculo_final_val=0;  $calculo1_val=0;  $calculo2_val=0;  $asig_ded_apo=$rega["asig_ded_apo"]; $fecha_ini=$rega["fecha_ini"]; $fecha_exp=$rega["fecha_exp"]; $oculto=$rega["oculto"];
       $sqlf="Select * from nom003 where tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto' Order BY tipo_nomina,cod_concepto,consecutivo";$resf=pg_query($sqlf);  $continuaf=0;
       while(($regf=pg_fetch_array($resf))and($error==0)and($continuaf==0)){ $consecutivo=$regf["consecutivo"];  $accion=$regf["accion"]; $rango_inicial=$regf["rango_inicial"]; $rango_final=$regf["rango_final"]; $calculo1=$regf["calculo1"]; $calculo2=$regf["calculo2"]; $calculofinal=$regf["calculofinal"];
         if(($valor>=$rango_inicial)and($valor<=$rango_final)){ if($accion=="F"){ $valor=calcular_formulas(); $continuaf=1; }
         else{ if($accion!= "F"){
           switch($accion){
             Case "T":$valor=calcular_formulas();  break;
             Case "A":$acumulado=calcular_formulas(); break;
             Case "S":$saldo=calcular_formulas(); break;
             Case "M":$monto_orig=calcular_formulas(); break;
             Case "C":$cantidad=calcular_formulas(); break;
             Case "U":$valoru=calcular_formulas(); break;
             Case "Q":$valorq=calcular_formulas(); break;
             Case "W":$valorw=calcular_formulas(); break;
             Case "X":$valorx=calcular_formulas(); break;
             Case "Y":$valory=calcular_formulas(); break;
             Case "Z":$valorz=calcular_formulas(); break;
           }
         }		
		 }
       } } 
	  $entra=0; if(($valor>0)and($asig_ded_apo=="A")){$entra=1;}    if(($valor>0)and($monto_orig>0)and($asig_ded_apo=="D")){$entra=1;}	  //$entra=10; 
	  //echo $cod_concepto." C ".$valor." ".$monto_orig." ".$fecha_ini." ".$fechah." ".$fecha_exp." ".$entra,"<br>";
	  if($Cod_Emp=="71"){  if(($cod_concepto=="005")or($cod_concepto=="499")or($cod_concepto=="182")){$entra=0; } }
	   // echo $cod_concepto." B ".$valor." ".$monto_orig." ".$fecha_ini." ".$fechah." ".$fecha_exp." ".$entra,"<br>";
	   if(($error==0)and($oculto=="NO")and($cantidad==0)and($entra==1)and($fecha_ini<=$fechah)){ $ndif=15; if($frec_nom=="S"){$ndif=7;} if($frec_nom=="M"){$ndif=30;} $ar=0;
	     $temp_e=formato_ddmmaaaa($fecha_exp); $temp_i=formato_ddmmaaaa($fecha_ini); $t_dia=substr($temp_e,0,2); if($t_dia=="31"){$temp_e="30".substr($temp_e,2,8);}
		 If (($fecha_exp<$fechah) and ($fecha_ini<$fechah)){$dias_dif=diferencia_dias($fecha_desde,$temp_e)+1; $valor=($valor/$ndif)*$dias_dif; }
         If (($fecha_exp>$fechah) and ($fecha_ini>$fechad)){$dias_dif=diferencia_dias($temp_i,$fecha_hasta);  $valor=($valor/$ndif)*$dias_dif; }
         If (($fecha_exp<$fechah) and ($fecha_ini>$fechad)){$dias_dif=diferencia_dias($temp_i,$temp_e)+1; $valor=($valor/$ndif)*$dias_dif;}
		 $dias_dif=diferencia_dias($fecha_desde,$fecha_proc_h)+1;
		 If(($dias_dif<$ndif)and($ar==0)){ $valor=($valor/$ndif)*$dias_dif;   }
		 //echo $cod_concepto." C ".$valor." ".$monto_orig." ".$fecha_ini." ".$fechah." ".$fecha_exp." ".$entra,"<br>";
       }
	   if($error==0){$cantidad=cambia_coma_numero($cantidad); $valor=cambia_coma_numero($valor); 
	   if(($asig_ded_apo=="A")and($oculto=="NO")){$MAsignacion=$MAsignacion+$valor;} if(($asig_ded_apo=="D")and($oculto=="NO")){$MDeduccion=$MDeduccion+$valor;} 
	   $valorx=cambia_coma_numero($valorx); $valory=cambia_coma_numero($valory); $valoru=cambia_coma_numero($valoru); $valore=cambia_coma_numero($valore); $valorq=cambia_coma_numero($valorq);  $valorw=cambia_coma_numero($valorw); $valorv=cambia_coma_numero($valorv);
	   $sSQL="SELECT ACTUALIZA_NOM076(2,'$codigo_mov','$cod_concepto','','S','S','S','N','A','A','S','N','N','N',$acumulado,$saldo,$valore,$valorq,$valoru,$valorv,$valorw,$valorx,$valory,$valorz,$cantidad,$valor,$monto_orig,'','','','','$fechah','$fechah','$fechah',0,'$cod_orden')";  $resultado=pg_exec($conn,$sSQL); }
     }  
    } 
 }$MNeto=$MAsignacion-$MDeduccion;  if($MNeto<0){ ?><script language="JavaScript">muestra('ERROR EN TRABAJADOR:<? echo $cod_empleado; ?> MONTO ES NEGATIVO:<? echo $MNeto; ?> \n ASIGNACIONES:<? echo $MAsignacion; ?> DEDUCCIONES:<? echo $MDeduccion; ?> \n POR FAVOR VERIFIQUE');</script><? }
 } 
}
 if($g_orden_pago=="S"){ $sSQL="SELECT cod_presup,valor,cod_concepto,cod_empleado,cod_contable  FROM nom076 where (afecta_presup='SI') and (asignacion='SI') and (codigo_mov='$codigo_mov') and (cod_presup not in (select cod_presup from pre001)) order by cod_presup"; $res=pg_query($sSQL);
 while($reg=pg_fetch_array($res)){ $cod_presup=$reg["cod_presup"]; $cod_fuente="00"; $cod_fuente=$reg["cod_contable"]; $cod_concepto=$reg["cod_concepto"]; $cod_empleado=$reg["cod_empleado"]; $error=1;
    ?><script language="JavaScript">muestra('CODIGO PRESUPUESTARIO:<? echo $cod_presup; ?> FUENTE:<? echo $cod_fuente; ?> \n TRABAJADOR:<? echo $cod_empleado; ?> CONCEPTO:<? echo $cod_concepto; ?> \n NO EXISTE EN PRESUPUESTO');</script><? }
 $sSQL="SELECT cod_presup,cod_contable,sum(valor) as valor FROM nom076 where (afecta_presup='SI') and (asignacion='SI') and (codigo_mov='$codigo_mov') group by cod_presup,cod_contable order by cod_presup,cod_contable"; $res=pg_query($sSQL);
 while(($reg=pg_fetch_array($res))and($error==0)){ $cod_presup=$reg["cod_presup"]; $valor=$reg["valor"]; $cod_fuente="00"; $cod_fuente=$reg["cod_contable"];
    $sqlp = "SELECT denominacion,disponible,diferido FROM PRE001 WHERE (Cod_Presup='$cod_presup') and (Cod_Fuente='$cod_fuente')"; $resp=pg_query($sqlp); $filas=pg_num_rows($resp);
    if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO <? echo $cod_presup; ?> NO EXISTE EN DISPONIBILIDAD');</script><? }
    else{ $regp=pg_fetch_array($resp); $disponible=$regp["disponible"]; if($disponible<$valor){
        ?><script language="JavaScript">muestra('NO EXISTE DISPONIBILIDAD PARA EL CODIGO PRESUPUESTARIO:<? echo $cod_presup; ?> FUENTE:<? echo $cod_fuente; ?> \n DISPONIBILIDAD ACTUAL:<? echo $disponible; ?> MONTO REQUERIDO:<? echo $valor; ?> \n POR FAVOR VERIFIQUE');</script><?}}
 }}
 $sSQL="SELECT BORRAR_nom076('$codigo_mov')"; // $resultado=pg_exec($conn,$sSQL);
}
$hora2=time(); $dif=$hora2-$hora1; echo " Tiempo en segundos: ".$dif,"<br>";
pg_close();?>
<script language="JavaScript">alert('FINALIZO CALCULO'); 
document.location ='<? echo $url; ?>';
</script>
