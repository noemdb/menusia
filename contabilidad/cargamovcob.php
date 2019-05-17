<?include ("../class/conect.php");  include ("../class/funciones.php");  $fecha_hoy=asigna_fecha_hoy();
if($_GET["fecha"]){$fecha=$_GET["fecha"];$codigo_mov=$_GET["codigo_mov"]; $afecta_p=$_GET["afecta_p"]; $afecta_p=substr($afecta_p, 0, 1);}else{$codigo_mov=""; $afecta_p="N"; $fecha=formato_aaaammdd($fecha_hoy);}
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; }
$res=pg_exec($conn,"SELECT ELIMINA_CON016('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$resultado=pg_exec($conn,"SELECT ELIMINA_CON014('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$resultado=pg_exec($conn,"SELECT ELIMINA_BAN034('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$resultado=pg_exec($conn,"SELECT ACTUALIZA_INGRE004(4,'$codigo_mov','','',0,0,0)");
$cdia=substr($fecha,0,2); $cmes=substr($fecha,3,2); $cano=substr($fecha,6,4);
$ndia=$cdia*1; $nmes=$cmes*1; $nano=$cano*1; $num_cons=0;
$conex = odbc_pconnect("becoaldhdl", "USERODBC", "INFODBC54");
$ssql="Select * from ffapu2o where xañoap=$nano and xmesap=$nmes and xdiaap=$ndia"; 
$ssql="Select * from flapu2o1"; 
$ssql="Select * from ffapu2o where xanoap=$nano and xmesap=$nmes and xdiaap=$ndia"; 
$rce = odbc_exec($conex, $ssql);
while (odbc_fetch_row($rce)){
  $ano=trim(odbc_result($rce,4)); $mes=trim(odbc_result($rce,5)); $mes=Rellenarcerosizq($mes,2); $dia=trim(odbc_result($rce,6)); $dia=Rellenarcerosizq($dia,2);
  if(($cdia==$dia)and($cmes==$mes)and($cano==$ano)){  $fecha_mov=$fecha; $ref_dia=$dia.$cmes.$ano;
        $num_asiento=odbc_result($rce,7); $tipo_contab=odbc_result($rce,8); $num_linea=odbc_result($rce,9); $num_cuenta=odbc_result($rce,10); $tipo_mov=odbc_result($rce,11);
        $clave_con=odbc_result($rce,12); $des_referencia=odbc_result($rce,13); $referencia_doc=odbc_result($rce,14); $tipo_doc="DEP"; $status_conc=odbc_result($rce,15);
        $monto_mov=odbc_result($rce,16); $monto_mov=cambia_coma_numero($monto_mov); $monto_mov=$monto_mov*1;
        $monto_mov_div=odbc_result($rce,17); $monto_mov_div=cambia_coma_numero($monto_mov_div); $monto_mov_div=$monto_mov_div*1;
        $cod_div=odbc_result($rce,18); $monto_div=odbc_result($rce,19); $monto_div=cambia_coma_numero($monto_div); $monto_div=$monto_div*1;
        $fecha_v=odbc_result($rce,20); $l=strlen($fecha_v); if($l==8){$fecha_vence=$fecha_v;}else{$fecha_vence=$fecha;}
        $cod_act=odbc_result($rce,21); $cod_destino=odbc_result($rce,22); $iva_mov =odbc_result($rce,23); $status_b=odbc_result($rce,24); $situacion=odbc_result($rce,25);
        $usuario_graba=odbc_result($rce,26); $fecha_graba=odbc_result($rce,27); $hora_graba=odbc_result($rce,28); $fecha_gen_mov=$fecha;
        $num_asiento=trim($num_asiento); $referencia_doc=trim($referencia_doc);
		
		if(($referencia_doc==$ref_dia)and(($monto_mov==594.29))){ $temp_cons=$num_cons; $temp_cons=Rellenarcerosizq($temp_cons,4); $referencia_doc=$dia.$mes.$temp_cons; } 
        if(($referencia_doc==$ref_dia)and($num_asiento=='40002')and(($monto_mov==211.96)or($monto_mov==3658.22))){ $temp_cons=$num_cons; $temp_cons=Rellenarcerosizq($temp_cons,4); $referencia_doc=$dia.$mes.$temp_cons; }   		
		if(($referencia_doc==$ref_dia)and($num_asiento=='40005')){  $referencia_doc='05'.$dia.$mes.'01'; } 
		if(($referencia_doc==$ref_dia)and($num_asiento=='40004')){  $referencia_doc='04'.$dia.$mes.'01'; } 
		
        $num_asiento=Rellenarcerosizq($num_asiento,5);

        $cod_cuenta=""; $debito_credito=""; $ced_rif=""; $status="N"; $status=$afecta_p;  $usuario_sia=""; $descripcion=""; $referencia_r="";
        $status_1=""; $status_2=""; $campo_str1=""; $campo_str2=""; $campo_num1=0; $campo_num2=0; $inf_usuario="";
        $sql="Select * from con015 WHERE num_cuenta='$num_cuenta'";$res=pg_query($sql);$filas=pg_num_rows($res);
    if($filas>0){$reg=pg_fetch_array($res);$cod_cuenta=$reg["cod_cuenta"]; $status_2=$reg["gen_gas_presup"]; $campo_str2=$reg["cod_presup"];}
        $sql="Select con001.nombre_cuenta from con001 WHERE con001.codigo_cuenta='$cod_cuenta'";$res=pg_query($sql);$filas=pg_num_rows($res);
    if($filas>0){$registro=pg_fetch_array($res);$campo_str1=$registro["nombre_cuenta"]; } else{echo "Cuenta:".$num_cuenta." Asociada:".$cod_cuenta.' No Localizada ',"<br>";} 
        if($tipo_mov=="1"){$debito_credito="D";}else{$debito_credito="C";} $referencia_r=$referencia_doc;

        if(($referencia_doc=="")or($referencia_doc==$fecha_v)or($referencia_r=="CONVENIO")){ $referencia_r=substr($des_referencia,5,8);}

        
        $mdes=substr($des_referencia,14,14);  $descripcion=$des_referencia; $temp=trim(substr($des_referencia,0,6));
        if($mdes=="TARJETA DE CRE"){$tipo_doc="TCR"; $referencia_r=substr($des_referencia,5,8); if($referencia_r=="00133783"){$referencia_r="01133783";} $descripcion="ABONO TARJETAS DE CREDITO - ".$num_asiento;}
        if($mdes=="TARJETA DE DEB"){$tipo_doc="TDB"; $referencia_r=substr($des_referencia,5,8); $descripcion="ABONO TARJETAS DE DEBITO - ".$num_asiento;}
        if($mdes=="RETENCION DE I"){$tipo_doc="IVA"; $referencia_r=substr($des_referencia,5,8); $descripcion="RETENCIONES DE IVA - ".$num_asiento;}
        
	    if($mdes=="RETENCION 1*10"){$tipo_doc="RET"; $referencia_r=substr($des_referencia,5,8); $descripcion="RETENCIONES DE 1*1000 - ".$num_asiento;}
		
		if((substr($descripcion,0,16)=="INGRESO METALICO")or(substr($descripcion,15,14)=="INGRESO EN CUE")){$descripcion=$descripcion.' '.$num_asiento;}
        
        if((trim($referencia_doc)=="")and($tipo_doc=='DEP')and($clave_con=="59")){ $referencia_r="00".$cdia.$cmes.substr($cano,2,2);} 

        if(($clave_con=="15")and($num_asiento=='40099')){$tipo_doc='NDB';$clave_con="59"; $tipo_mov='1';}

        if(($clave_con=="15")and(substr($num_asiento,0,3)=='400')){  $tipo_doc='NDB';$clave_con="59"; $tipo_mov='1'; $referencia_r=trim($referencia_r);
            if(substr($des_referencia,14,13)=="ANULACION DOC"){$referencia_r=substr($des_referencia,5,8); } $referencia_r=Rellenarcerosizq($referencia_r,8); }

        if(($clave_con=="41")and($num_asiento=='40099')and($debito_credito=="D")){$tipo_doc='NDB'; $tipo_mov='3';} 

        
        if($clave_con=="48"){$tipo_doc="FAC"; $l=8; if($temp=="DELEG"){$l=8;} $referencia_r=substr($des_referencia,$l,2); $referencia_r=$num_asiento;}
        if($clave_con=="35"){$tipo_doc="COB"; $l=3; if($temp=="DELEG"){$l=8;} $referencia_r=substr($des_referencia,$l,2); $referencia_r=$num_asiento;}
        if($clave_con=="37"){$tipo_doc="DEV"; $l=3; if($temp=="DELEG"){$l=8;} $referencia_r=substr($des_referencia,$l,2); $referencia_r=$num_asiento;}
        if($clave_con=="15"){$tipo_doc="COB"; $l=3; if($temp=="DELEG"){$l=8;} $referencia_r=substr($des_referencia,$l,2); $referencia_r=$num_asiento;}

        if(substr($referencia_r,0,2)=="NC"){ $referencia_r=substr($referencia_r,3,5);} 
        
        if(($clave_con=="41")and($tipo_mov=="3")){$referencia_r="00000000";}else{ $referencia_r=Rellenarcerosizq($referencia_r,8);}
		
		if($referencia_r=='ROMOCION'){$tipo_doc="DCT"; $num_cons=$num_cons+1; $temp_cons=$num_cons; $temp_cons=Rellenarcerosizq($temp_cons,4); $referencia_r=$dia.$mes.$temp_cons; }

		if(($num_cuenta=='111010301')and($tipo_doc=='DEP')){ $cod_banco="0005";  $temp1=substr($referencia_r,0,6); $temp2=$cmes.$cano;
		   $sql="Select cod_banco from ban004 where (cod_banco='$cod_banco') and (referencia='$referencia_r') and (tipo_mov_libro='$tipo_doc')"; $res=pg_query($sql);$filas=pg_num_rows($res);
           if($filas>0){ $referencia_r=$mes.substr($referencia_r,2,6);
		    $sql="Select cod_banco from ban004 where (cod_banco='$cod_banco') and (referencia='$referencia_r') and (tipo_mov_libro='$tipo_doc')"; $res=pg_query($sql);$filas=pg_num_rows($res);
            if($filas>0){ $referencia_r="01".substr($referencia_r,2,6); }
			$sql="Select cod_banco from ban004 where (cod_banco='$cod_banco') and (referencia='$referencia_r') and (tipo_mov_libro='$tipo_doc')"; $res=pg_query($sql);$filas=pg_num_rows($res);
            if($filas>0){ $referencia_r="02".substr($referencia_r,2,6); }
		   } 
		     else{ $temp_ref=$cdia.$cmes.$cano; if($referencia_r==$temp_ref){ $num_cons=$num_cons+1; $temp_cons=$num_cons; $temp_cons=Rellenarcerosizq($temp_cons,4); $referencia_r=$temp_cons.$dia.$mes; } }	
			} 
		
		
        $resultado=pg_exec($conn,"SELECT INCLUYE_CON014('$codigo_mov','$fecha_mov','$ano','$mes','$dia','$num_asiento','$tipo_contab','$num_linea','$num_cuenta','$tipo_mov','$clave_con','$des_referencia','$referencia_doc','$tipo_doc','$status_conc','$monto_mov','$monto_mov_div','$cod_div','$monto_div','$fecha_vence','$cod_act','$cod_destino','$iva_mov','$status_b','$situacion','$usuario_graba','$fecha_graba','$hora_graba','$fecha_gen_mov','$cod_cuenta','$debito_credito','$ced_rif','$status','$usuario_sia','$descripcion','$referencia_r','$status_1','$status_2','$campo_str1','$campo_str2','$campo_num1','$campo_num2','$inf_usuario')");
        $error=pg_errormessage($conn); $error=substr($error, 0, 61);
  }
} $prev_asiento=""; $prev_doc=""; $prev_monto=0; $prev_ref=""; $cod_banco="0000"; $ced_rif="G-20009014-6"; $cta_c=""; $prev_cuenta=""; $num_asiento="";
$sSQL="SELECT * FROM con014 where (codigo_mov='$codigo_mov') and (tipo_mov='1') and (tipo_doc='DEP' or tipo_doc='TCR' or tipo_doc='TDB' or tipo_doc='NDB')  order by num_asiento,to_number(num_linea,'999999')"; $resultado=pg_query($sSQL);
while($registro=pg_fetch_array($resultado)){  $num_asiento=$registro["num_asiento"]; $tipo_doc=$registro["tipo_doc"]; $referencia=$registro["referencia_r"]; $cod_cuenta=$registro["cod_cuenta"];  if($prev_cuenta==""){$prev_cuenta=$cod_cuenta;}
 if(($prev_asiento<>$num_asiento)or($prev_doc<>$tipo_doc)or($prev_ref<>$referencia)){ $refa=Rellenarcerosizq($prev_asiento,8);
        if($prev_monto>0){$sql="Select cod_banco from ban004 where (cod_banco='$cod_banco') and (referencia='$prev_ref') and (tipo_mov_libro='$prev_doc')"; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){$error_m=1; if(($cod_banco=="0055")and($prev_doc=="DEP")){ $ant_ref=$prev_ref; $prev_ref=$mes.substr($prev_ref,2,6);  
 $error_m=0; } }
else{$error_m=0;}  
if($error_m==1){echo "Existe en Movimiento en libro, Referencia:".$prev_ref.' Banco:'.$cod_banco.' Tipo:'.$prev_doc.' ',"<br>";}
$sql="SELECT INCLUYE_BAN034('$codigo_mov','$cod_banco','$prev_ref','$prev_doc','$ced_rif','$sfecha','$refa','','N','$sfecha',$prev_monto,'00','01','0','N','N','C','','$usuario_sia','','$descripcion')";  $res=pg_exec($conn,$sql);  $error=pg_errormessage($conn);  $error=substr($error, 0, 70); if (!$res){echo "Mov.libro:".$error." referencia:".$prev_ref.' '.$cod_banco.' '.$prev_doc.' ',"<br>";}}
        $prev_cuenta=$cod_cuenta; $prev_monto=0; $prev_asiento=$num_asiento;$prev_doc=$tipo_doc;$prev_ref=$referencia;

 }
$sql="Select cod_banco from ban002 where (ban002.cod_contable='$cod_cuenta')"; $res=pg_query($sql);$filas=pg_num_rows($res);
 if($filas>0){$reg=pg_fetch_array($res);$cod_banco=$reg["cod_banco"]; $monto=$registro["monto_mov"]; $prev_monto=$prev_monto+$monto; $sfecha=$registro["fecha_mov"]; $num_asiento=$registro["num_asiento"]; $descripcion=$registro["descripcion"]; }
}$refa=Rellenarcerosizq($num_asiento,8);
if($prev_monto>0){

$sql="Select cod_banco from ban004 where (cod_banco='$cod_banco') and (referencia='$prev_ref') and (tipo_mov_libro='$prev_doc')"; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){echo "Existe en Movimiento en libro, Referencia:".$prev_ref.' Banco:'.$cod_banco.' Tipo:'.$prev_doc.' ',"<br>";}

$sql="SELECT INCLUYE_BAN034('$codigo_mov','$cod_banco','$prev_ref','$prev_doc','$ced_rif','$sfecha','$refa','','N','$sfecha',$prev_monto,'00','01','0','N','N','C','','$usuario_sia','','$descripcion')";  $res=pg_exec($conn,$sql);  $error=pg_errormessage($conn);  $error=substr($error, 0, 70);if (!$res){echo "Mov.libro:".$error." referencia:".$prev_ref.' '.$cod_banco.' '.$prev_doc.' ',"<br>";}}
$prev_asiento=""; $prev_doc=""; $prev_monto=0; $prev_ref=""; $cta_c=""; $prev_cuenta="";
$sSQL="SELECT * FROM con014 where (codigo_mov='$codigo_mov') and (tipo_mov='1') and (tipo_doc='DEP' or tipo_doc='TCR' or tipo_doc='TDB' or tipo_doc='NDB' or tipo_doc='IVA' or tipo_doc='RET' or tipo_doc='DCT')  order by num_asiento,to_number(num_linea,'999999')"; $resultado=pg_query($sSQL);
while($registro=pg_fetch_array($resultado)){  $num_asiento=$registro["num_asiento"]; $tipo_doc=$registro["tipo_doc"]; $referencia=$registro["referencia_r"];  $cod_cuenta=$registro["cod_cuenta"]; if($prev_cuenta==""){$prev_cuenta=$cod_cuenta;} $tipo_comp="00000";
 if($prev_asiento<>$num_asiento){   $prev_asiento=$num_asiento;   $refa=Rellenarcerosizq($prev_asiento,8);
    $sql="Select cod_cuenta from con014 where (codigo_mov='$codigo_mov') and (num_asiento='$num_asiento') and (tipo_mov='3') "; $res=pg_query($sql);$filas=pg_num_rows($res);
    if($filas>0){$reg=pg_fetch_array($res);$cta_c=$reg["cod_cuenta"]; }
 } $monto=$registro["monto_mov"]; $debito_credito="D"; $descripcion=$registro["descripcion"]; $cod_ant=$cod_cuenta; $tipo_comp="00000"; $tipo_doc=$registro["tipo_doc"]; $nro_comp=Rellenarcerosizq($num_asiento,8); if($tipo_doc=="NDB"){$debito_credito="C";}
 $sql="Select * from CON016 WHERE codigo_mov='$codigo_mov' and referencia='$referencia' and tipo_comp='$tipo_comp' and nro_comprobante='$nro_comp' and cod_cuenta='$cod_cuenta' and debito_credito='$debito_credito'"; $res=pg_exec($conn,$sql); $filas=pg_numrows($res);
 if ($filas>0){ $reg=pg_fetch_array($res); $monto_c=$monto+$reg["monto_asiento"];   $monto_c=cambia_coma_numero($monto_c); $res=pg_exec($conn,"SELECT MOD_CUENTA_CON016('$codigo_mov','$referencia','$debito_credito','$cod_cuenta','$tipo_comp','$nro_comp',$monto_c,'$descripcion')"); }
  else{$res=pg_exec($conn,"SELECT INCLUYE_CON016('$codigo_mov','$referencia','$debito_credito','$cod_cuenta','$tipo_comp','$tipo_doc',$monto,'$debito_credito','C','N','01','0','$sfecha','$nro_comp','$ced_rif','','','$descripcion')"); $error=pg_errormessage($conn); $error=substr($error, 0, 70);if (!$res){echo "Comp mov.libro:".$error." referencia:".$referencia.' '.$debito_credito.' '.$cod_cuenta.' ',"<br>";} }
 $debito_credito="C"; $cod_cuenta=$cta_c; if($tipo_doc=="NDB"){$debito_credito="D";}
 
 $sql="Select * from CON016 WHERE codigo_mov='$codigo_mov' and referencia='$referencia' and tipo_comp='$tipo_comp' and nro_comprobante='$nro_comp' and cod_cuenta='$cod_cuenta' and debito_credito='$debito_credito'"; $res=pg_exec($conn,$sql); $filas=pg_numrows($res);
 if ($filas>0){ $reg=pg_fetch_array($res); $monto_c=$monto+$reg["monto_asiento"];   $monto_c=cambia_coma_numero($monto_c);
 $res=pg_exec($conn,"SELECT MOD_CUENTA_CON016('$codigo_mov','$referencia','$debito_credito','$cod_cuenta','$tipo_comp','$nro_comp',$monto_c,'$descripcion')"); }
  else{$res=pg_exec($conn,"SELECT INCLUYE_CON016('$codigo_mov','$referencia','$debito_credito','$cod_cuenta','$tipo_comp','$tipo_doc',$monto,'$debito_credito','C','N','01','0','$sfecha','$nro_comp','$ced_rif','','','$descripcion')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ echo $error;} }
 $status_1=$registro["status_1"]; $status_2=$registro["status_2"]; $campo_str2=$registro["campo_str2"]; $fuente="00"; $sfecha=$registro["fecha_mov"];
 if($status_2=="S"){ $sql="SELECT INCLUYE_PRE026('$codigo_mov','$campo_str2','$fuente','','0000','','0000','$referencia','0000','','0000','','','','$cod_cuenta','$nro_comp','','$sfecha','C','P','00000000','$sfecha',$monto,0,0,0)";  $res=pg_exec($conn,$sql);}

 }
$sSQL="SELECT * FROM con014 where (codigo_mov='$codigo_mov') and (tipo_doc<>'DEP' and tipo_doc<>'TCR' and tipo_doc<>'TDB' and tipo_doc<>'NDB' and tipo_doc<>'IVA' and tipo_doc<>'RET' and tipo_doc<>'DCT')  order by num_asiento,to_number(num_linea,'999999')"; $resultado=pg_query($sSQL);
while($registro=pg_fetch_array($resultado)){  $num_asiento=$registro["num_asiento"]; $tipo_doc=$registro["tipo_doc"]; $referencia=$registro["referencia_r"]; $cod_cuenta=$registro["cod_cuenta"]; if($prev_cuenta==""){$prev_cuenta=$cod_cuenta;} $sfecha=$registro["fecha_mov"];
 $monto=$registro["monto_mov"]; $debito_credito=$registro["debito_credito"];$descripcion=$registro["descripcion"]; $tipo_comp="00000"; $tipo_doc=$registro["tipo_doc"]; $nro_comp=Rellenarcerosizq($num_asiento,8);
 if($monto<0){$monto=$monto*-1; if($debito_credito=="D"){$debito_credito="C";}else{$debito_credito="D";}}
 $sql="Select * from CON016 WHERE codigo_mov='$codigo_mov' and referencia='$referencia' and tipo_comp='$tipo_comp' and nro_comprobante='$nro_comp' and cod_cuenta='$cod_cuenta' and debito_credito='$debito_credito'"; $res=pg_exec($conn,$sql); $filas=pg_numrows($res);
 if ($filas>0){ $reg=pg_fetch_array($res); $monto_c=$monto+$reg["monto_asiento"];   $monto_c=cambia_coma_numero($monto_c); $res=pg_exec($conn,"SELECT MOD_CUENTA_CON016('$codigo_mov','$referencia','$debito_credito','$cod_cuenta','$tipo_comp','$nro_comp',$monto_c,'$descripcion')"); }
  else{$res=pg_exec($conn,"SELECT INCLUYE_CON016('$codigo_mov','$referencia','$debito_credito','$cod_cuenta','$tipo_comp','$tipo_doc',$monto,'$debito_credito','C','N','01','0','$sfecha','$nro_comp','$ced_rif','','','$descripcion')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ echo "Comp otros:".$error;} }
}
$sSQL="SELECT * FROM con014 where (codigo_mov='$codigo_mov') and (clave_con='48')  order by num_asiento,to_number(num_linea,'999999')"; $resultado=pg_query($sSQL);
while($registro=pg_fetch_array($resultado)){  $num_asiento=$registro["num_asiento"]; $tipo_doc=$registro["tipo_doc"]; $referencia=$registro["referencia_r"]; $cod_cuenta=$registro["cod_cuenta"]; if($prev_cuenta==""){$prev_cuenta=$cod_cuenta;}
 $monto=$registro["monto_mov"]; $debito_credito=$registro["debito_credito"]; $descripcion=$registro["descripcion"]; $status_1=$registro["status_1"]; $status_2=$registro["status_2"]; $campo_str2=$registro["campo_str2"];
 if($status_2=="I"){ $cod_presup=$campo_str2; $cod_ramo="48"; $refa=Rellenarcerosizq($num_asiento,8);
   $sql="Select cod_presup,monto_mov from ingre004 WHERE codigo_mov='$codigo_mov' and cod_presup='$cod_presup'";  $res=pg_exec($conn,$sql);  $filas=pg_numrows($res);
   if ($filas==0){ $monto_asiento=$monto; $res=pg_exec($conn,"SELECT ACTUALIZA_INGRE004 ('1','$codigo_mov','$cod_presup','$cod_ramo',$monto_asiento,0,0)");  }
     else{ $reg=pg_fetch_array($res); $monto_asiento=$reg["monto_mov"];   $monto_asiento=$monto_asiento+$monto; $res=pg_exec($conn,"SELECT ACTUALIZA_INGRE004 (2,'$codigo_mov','$cod_presup','$cod_ramo',$monto_asiento,0,0)"); }
 }
}
$sSQL="SELECT * FROM ban034 where codigo_mov='$codigo_mov' order by referenciaa,cod_banco,referencia";$resultado=pg_query($sSQL);
while($registro=pg_fetch_array($resultado)){ $refa=$registro["referenciaa"]; $tipo_doc=$registro["tipo_mov_libro"]; $referencia=$registro["referencia"]; $cod_banco=$registro["cod_banco"];$tipo_comp="B".$cod_banco;
 $res=pg_exec($conn,"UPDATE CON016 SET tipo_comp='$tipo_comp' where codigo_mov='$codigo_mov' and referencia='$referencia' and tipo_asiento='$tipo_doc' and nro_comprobante='$refa'");
}
pg_close();?>
<iframe src="Det_inc_int_cont.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="390" scrolling="auto" frameborder="0"> </iframe>



