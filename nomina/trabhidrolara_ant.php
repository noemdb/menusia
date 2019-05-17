<?include ("../class/funciones.php");

  $conn = pg_connect("host=localhost port=5432 password=super user=usia dbname=DATOS");
   if (!$conn) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }

   
   $error=0;
   if($error==0){
   //$sSQL="Delete from NOM006";   $resultado=pg_exec($conn,$sSQL);    $sSQL="Delete from NOM007";   $resultado=pg_exec($conn,$sSQL);    $sSQL="Delete from NOM008";   $resultado=pg_exec($conn,$sSQL);    $sSQL="Delete from NOM068";   $resultado=pg_exec($conn,$sSQL);
   $path="nmpp007.txt"; $fp = fopen($path,"r");
   while ($linea= fgets($fp,1024)) { 
	 //echo $linea,"<br>";
      $datos = explode(";", $linea); $tcod_emp=$datos[0];  $codigo_mov="000000";
	  
      $cod_empleado=$datos[1]; $cod_empleado=ltrim($cod_empleado);$cod_empleado=Rellenarcerosizq($cod_empleado,10);
	  
      $tipon=$datos[2].$datos[3]; $tipo_nomina="00";  $cont_fijo="F";
      if($tipon=="GG"){$tipo_nomina="01";} if($tipon=="EF"){$tipo_nomina="02";} if($tipon=="EC"){$tipo_nomina="03";$cont_fijo="C";}if($tipon=="EI"){$tipo_nomina="04";$cont_fijo="C";} if($tipon=="EQ"){$tipo_nomina="05";$cont_fijo="C";}
      $nombre=$datos[5];
      $direccion=$datos[7].$datos[8];
      $lugar_nacimiento=$datos[10];if($lugar_nacimiento=='BQTO'){$lugar_nacimiento='BARQUISIMETO';}
      $telefono=$datos[13];
      $nacionalidad=$datos[14];  if($nacionalidad=="1"){$nacionalidad="VENEZOLANO";}else{$nacionalidad="EXTRANJERO";}
      $fecha=$datos[15]; $fecha_nac=substr($fecha,0,4)."-".substr($fecha,4,2)."-".substr($fecha,6,2);
      $cedula=$datos[16]; $cedula=ltrim($cedula);
      $sexo=$datos[17]; if($sexo=="1"){$sexo="MASCULINO";}else{$sexo="FEMENINO";}
      $edo_civil=$datos[19]; if($edo_civil=="C"){$edo_civil="CASADOS";} if($edo_civil=="S"){$edo_civil="SOLTERO";} if($edo_civil=="D"){$edo_civil="DIVORCIADO";}
      $cod_departam=$datos[24]; $status=$datos[34];
      $cod_cargo=$datos[26];
      $forma_pago=$datos[35]; if($forma_pago=="1"){$forma_pago="EFECTIVO";} $tipo_cuenta=""; if($forma_pago=="2"){$forma_pago="DEPOSITO"; $tipo_cuenta='CORRIENTE';} if($forma_pago=="3"){$forma_pago="CHEQUE";} if($forma_pago=="4"){$forma_pago="DEPOSITO"; $tipo_cuenta='AHORROS';}
      $cta_empleado=$datos[43];
      $fecha=$datos[56]; $fecha_ingreso=substr($fecha,0,4)."-".substr($fecha,4,2)."-".substr($fecha,6,2);
      $monto_sueldo=$datos[58];
      $fecha=$datos[61]; $fecha_cargo=substr($fecha,0,4)."-".substr($fecha,4,2)."-".substr($fecha,6,2);
      $rif_empleado=$datos[108];
      $compensacion=0; $sfechah="9999-12-31";  $estado="LARA"; $ciudad="BARQUISIMETO"; $municipio="IRIBARREN"; $parroquia="";  $talla_camisa="";$talla_pantalon="";$talla_calzado="";$aptdo_postal="";$cod_jerarquia=""; $cod_conc_s="001";$cod_conc_c="002";
      $cod_categoria="";  $cta_empresa="";   $cod_banco="0001"; $nombre_banco="BANCO PROVINCIAL"; $calculo_grupos="1"; $paso="00"; $grado="00"; $motivo_suplen="";$cedula_titular="";$campo_str1="";$campo_num1=0;$mstatus="NNNNNNNNNN"; $usuario_sia="MIGRADO 15-04-2010";
      
	  $unidad=substr($cod_departam,1,4);
	  if($unidad=="1051"){ $unidad="01-00-51";}
      if($unidad=="1052"){ $unidad="01-00-52";}
      if($unidad=="1053"){ $unidad="01-00-53";}
      if($unidad=="1054"){ $unidad="01-00-54";}
      if($unidad=="1055"){ $unidad="01-00-55";}
      if($unidad=="1056"){ $unidad="01-00-56";}
      if($unidad=="1057"){ $unidad="01-00-57";}
      if($unidad=="1058"){ $unidad="01-00-58";}

      if($unidad=="1062"){ $unidad="01-00-62";}
      if($unidad=="1063"){ $unidad="01-00-63";}
      if($unidad=="1064"){ $unidad="01-00-64";}
      if($unidad=="1065"){ $unidad="01-00-65";}
      if($unidad=="1066"){ $unidad="01-00-66";}
      if($unidad=="1067"){ $unidad="01-00-67";}
	  if($unidad=="1068"){ $unidad="01-00-68";}

      if($unidad=="3051"){ $unidad="03-00-51";}
      if($unidad=="3052"){ $unidad="03-00-52";}
      if($unidad=="3053"){ $unidad="03-00-53";}
      if($unidad=="3054"){ $unidad="03-00-54";}
      if($unidad=="3055"){ $unidad="03-00-55";}
      if($unidad=="3056"){ $unidad="03-00-56";}
      if($unidad=="3057"){ $unidad="03-00-57";}
      if($unidad=="3058"){ $unidad="03-00-58";}
      if($unidad=="3059"){ $unidad="03-00-59";}

      if($unidad=="2151"){ $unidad="02-01-51";}
      if($unidad=="2152"){ $unidad="02-01-52";}
      if($unidad=="2153"){ $unidad="02-01-53";}
      if($unidad=="2154"){ $unidad="02-01-54";}
      if($unidad=="2155"){ $unidad="02-01-55";}
      if($unidad=="2156"){ $unidad="02-01-56";}
      if($unidad=="2157"){ $unidad="02-01-57";}
      if($unidad=="2158"){ $unidad="02-01-58";}

      if($unidad=="2251"){ $unidad="02-02-51";}
      if($unidad=="2252"){ $unidad="02-02-52";}
      if($unidad=="2253"){ $unidad="02-02-53";}
      if($unidad=="2254"){ $unidad="02-02-54";}
      if($unidad=="2255"){ $unidad="02-02-55";}
      if($unidad=="2256"){ $unidad="02-02-56";}
      if($unidad=="2257"){ $unidad="02-02-57";}
      if($unidad=="2258"){ $unidad="02-02-58";}

      if($unidad=="102351"){ $unidad="02-03-51";}
      if($unidad=="102352"){ $unidad="02-03-52";}
      if($unidad=="102353"){ $unidad="02-03-53";}
      if($unidad=="102354"){ $unidad="02-03-54";}
      if($unidad=="102355"){ $unidad="02-03-55";}
      if($unidad=="102356"){ $unidad="02-03-56";}
      if($unidad=="102357"){ $unidad="02-03-57";}
      if($unidad=="102358"){ $unidad="02-03-58";}

      if($unidad=="102451"){ $unidad="02-04-51";}
      if($unidad=="202255"){ $unidad="02-02-55";}
      if($unidad=="301053"){ $unidad="01-00-53";}
	  $cod_categoria=$unidad;

	if($status=="1"){  
      $nombre1="";$nombre2="";  $apellido1=""; $apellido2="";    $p1=0; $p2=0;$p3=0;  $c=0; $j=1;
      for ($j=0; $j<strlen($nombre); $j++) {if(substr($nombre,$j,1)==" "){ $c=$c+1; if($c==1){$p1=$j;}else{ if($c==2){$p2=$j;}else{$p3=$j;} }  }}
      if($c==1){$l=strlen($nombre)-$p1; $nombre1=substr($nombre,$p1,$l); $nombre2=""; $apellido1=substr($nombre,0,$p1); $apellido2="";}
      if($c==2){$l=$p2-$p1; $nombre1=substr($nombre,$p1,$l); $l=strlen($nombre)-$p2; $nombre2=substr($nombre,$p2,$l); $apellido1=substr($nombre,0,$p1); $apellido2="";}
      if($c>=3){$l=$p3-$p2; $nombre1=substr($nombre,$p2,$l); $l=strlen($nombre)-$p3; $nombre2=substr($nombre,$p3,$l);$apellido1=substr($nombre,0,$p1); $l=$p2-$p1; $apellido2=substr($nombre,$p1,$l);}
      If((ltrim($nombre1)== "") Or (ltrim($nombre1)== ",")) {$nombre1=$nombre2; $nombre2="";}

     // echo $nombre1.' n2  '.$nombre2.' a1 '.$apellido1.' a2 '.$apellido2,"<br>";

      $nombre1=substr($nombre1,0,20);   $monto_sueldo=cambia_coma_numero($monto_sueldo); 

      echo $cod_empleado.' '.$unidad.' '.$cod_categoria.' '.$nombre.' '.$tipo_nomina.' '.$fecha_nac.' '.$sexo.' '.$edo_civil.' '.$fecha_ingreso.' '.$monto_sueldo.' '.$rif_empleado.' '.$nombre1.' '.$nombre2.' '.$apellido1.' '.$apellido2,"<br>";

      $des_cargo=""; $des_departamento=""; $cod_tipo_personal="01-02";
      $sSQL="Select * from NOM004 WHERE codigo_cargo='$cod_cargo'"; $res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){$reg=pg_fetch_array($res); $des_cargo=$reg["denominacion"]; }

      $sSQL="Select * from NOM005 WHERE codigo_departamento='$cod_departam'"; $res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){$reg=pg_fetch_array($res); $des_departamento=$reg["descripcion_dep"]; }

	  
	  
      if(strlen($fecha_cargo)==10){$fecha_cargo=$fecha_cargo;}else{$fecha_cargo=$fecha_ingreso;}
      $sql="INSERT INTO NOM068 (codigo_mov,cod_empleado,fecha_asigna,cod_cargo,cod_departamento,des_cargo,des_departamento,cod_tipo_personal,paso,grado,observacion,sueldo,prima,compensacion,otros,sueldo_integral)";
      $sql=$sql."VALUES ('$codigo_mov','$cod_empleado','$fecha_cargo','$cod_cargo','$cod_departam','$des_cargo','$des_departamento','$cod_tipo_personal','000','000','',$monto_sueldo,0,$compensacion,0,0)"; $resultado=pg_exec($conn,$sql);
      
	  $sSQL="Select * from NOM006 WHERE cod_empleado='$cod_empleado'"; $res=pg_query($sSQL); $filas=pg_num_rows($res); 
	  if($filas>=1){
	     $sSQL="Update NOM006 set tipo_nomina='$tipo_nomina',fecha_ingreso='$fecha_ingreso',fecha_ing_adm='$fecha_ingreso',cod_categoria='$cod_categoria',tipo_pago='$forma_pago',cta_empleado='$cta_empleado',tipo_cuenta='$tipo_cuenta',cod_banco='$cod_banco',nombre_banco='$nombre_banco',cta_empresa='$cta_empresa',cod_cargo='$cod_cargo',cod_departam='$cod_departam',sueldo=".$monto_sueldo.",inf_usuario='MIGRADO ACT' WHERE cod_empleado='$cod_empleado'";
	     $resultado=pg_exec($conn,$sSQL); 
		 
		 echo $sSQL;
		 $sSQL="delete from  NOM008 WHERE cod_empleado='$cod_empleado'";    $resultado=pg_exec($conn,$sSQL); 
		 
		 $sql="INSERT INTO NOM008 (cod_empleado, fecha_asigna, cod_cargo, cod_departamento, des_cargo, des_departamento, cod_tipo_personal, paso, grado, observacion,sueldo, prima, compensacion, otros, sueldo_integral)";
         $sql=$sql."VALUES ('$cod_empleado','$fecha_cargo','$cod_cargo','$cod_departam','$des_cargo','$des_departamento','$cod_tipo_personal','000','000','',$monto_sueldo,0,$compensacion,0,0)"; 
		 
		 $resultado=pg_exec($conn,$sql); $error=pg_errormessage($conn); if (!$resultado){  echo "Error: ".$error,"<br>"; }
      
	     $sSQL="Update NOM011 set monto=$monto_sueldo where  tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado' and cod_concepto='001'";
	     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); if (!$resultado){  echo "Error: ".$error,"<br>"; }
		  
	  }
      else{	  
    //  $sSQL="SELECT ACTUALIZA_NOM006(2,'$cod_empleado','$cedula','$nombre','$tipo_nomina','$nacionalidad','$status','$sfechai','$sfechaia','$cod_categoria','$tipo_pago','$cta_empleado','$tipo_cuenta','$cod_banco','$nombre_banco','$cta_empresa','$calculo_grupos','$sfechaac','$cod_cargo','$cod_departam','$cod_tipo_personal','$paso','$grado',$sueldo,$prima,$compensacion,$otros,$sueldo_integral,'$tipo_vacaciones','$pago_vaciones','$sfecha','$tiene_lph','$banco_lph','$cta_lph','$sfechalph','$sfechadlph','N','$tiene_dec_jurada','$sfechad',$monto_declaracion,'$sfechae','$sfechafc','$motivo_egreso','$cont_fijo','0000','$tiene_aus_pro','$motivo_ausencia','$sfechaad','$sfechaah','$codigo_ubicacion','$motivo_suplen','$cedula_titular','$campo_str1',$campo_num1,'$mstatus','$usuario_sia','$minf_usuario','$nombre1','$nombre2','$apellido1','$apellido2','$sexo','$edo_civil','$sfechan',$edad_num,'$lugar_nacimiento','$direccion','$cod_postal','$telefono','$tlf_movil','$correo','$profesion','$grado_inst',0,'$poliza','$sfechan','$estado','$ciudad','$municipio','$parroquia','','$talla_camisa','$talla_pantalon','$talla_calzado',0,0,'$aptdo_postal','$cod_jerarquia','$rif_emp','$cod_conc_s','$cod_conc_c','$codigo_mov')";
      
      $sSQL="SELECT ACTUALIZA_NOM006(1,'$cod_empleado','$cedula','$nombre','$tipo_nomina','$nacionalidad','ACTIVO','$fecha_ingreso','$fecha_ingreso','$cod_categoria','$forma_pago','$cta_empleado','$tipo_cuenta','$cod_banco','$nombre_banco','$cta_empresa','$calculo_grupos','$fecha_cargo','$cod_cargo','$cod_departam','$cod_tipo_personal','$paso','$grado',$monto_sueldo,0,$compensacion,0,0,'N','N','$fecha_ingreso','N','','','$fecha_ingreso','$sfechah','N','','$fecha_ingreso',0,'$sfechah','$sfechah','','$cont_fijo','0000','N','','$fecha_ingreso','$sfechah','','','','',0,'$mstatus','$usuario_sia','$usuario_sia','$nombre1','$nombre2','$apellido1','$apellido2','$sexo','$edo_civil','$fecha_nac',0,'$lugar_nacimiento','$direccion','','$telefono','','','','',0,'','$sfechah','$estado','$ciudad','$municipio','$parroquia','','$talla_camisa','$talla_pantalon','$talla_calzado',0,0,'$aptdo_postal','$cod_jerarquia','$rif_empleado','$cod_conc_s','$cod_conc_c','$codigo_mov')";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);
       }
      $sql="delete from nom068  where codigo_mov='$codigo_mov'";  $resultado=pg_exec($conn,$sql);
    }             
	}
	
	}

   
?>