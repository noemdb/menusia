<?include ("../class/funciones.php");
   $conn = pg_connect("host=".$host." port=".$port." password=super user=usia dbname=DATOS");
   if (!$conn) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
    $codigo_mov="00000007";  $cod_pre_ret="01-00-54-401-01-01-00";
    $ssql = "UPDATE pag009 set monto_est=0 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);
    $ssql = "UPDATE pag011 set monto_objeto=0,monto_ret=0 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);

    $ssql = "delete from pag033 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);
    $ssql = "delete from pag034 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);
    $ssql = "delete from pag035 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);
	
	$ssql = "UPDATE pag037 set monto_est=0 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);

    $error=0;
   $path="liqui.txt"; $fp = fopen($path,"r");
   while ($linea= fgets($fp,1024)) {
      echo $linea,"<br>";
      $datos = explode(";", $linea);
      $cedula=$datos[0]; $concepto=$datos[1]; $cedula=trim($cedula);
      $codigo=$datos[3];  $monto=$datos[4];  $unidad=trim($datos[5]); 
      echo $unidad,"<br>";

      

      if($unidad=="P1051"){ $unidad="01-00-51";}
      if($unidad=="P1052"){ $unidad="01-00-52";}
      if($unidad=="P1053"){ $unidad="01-00-53";}
      if($unidad=="P1054"){ $unidad="01-00-54";}
      if($unidad=="P1055"){ $unidad="01-00-55";}
      if($unidad=="P1056"){ $unidad="01-00-56";}
      if($unidad=="P1057"){ $unidad="01-00-57";}
      if($unidad=="P1058"){ $unidad="01-00-58";}

      if($unidad=="P1062"){ $unidad="01-00-62";}
      if($unidad=="P1063"){ $unidad="01-00-63";}
      if($unidad=="P1064"){ $unidad="01-00-64";}
      if($unidad=="P1065"){ $unidad="01-00-65";}
      if($unidad=="P1066"){ $unidad="01-00-66";}
      if($unidad=="P1067"){ $unidad="01-00-67";}
	  if($unidad=="P1068"){ $unidad="01-00-68";}

      if($unidad=="P3051"){ $unidad="03-00-51";}
      if($unidad=="P3052"){ $unidad="03-00-52";}
      if($unidad=="P3053"){ $unidad="03-00-53";}
      if($unidad=="P3054"){ $unidad="03-00-54";}
      if($unidad=="P3055"){ $unidad="03-00-55";}
      if($unidad=="P3056"){ $unidad="03-00-56";}
      if($unidad=="P3057"){ $unidad="03-00-57";}
      if($unidad=="P3058"){ $unidad="03-00-58";}
      if($unidad=="P3059"){ $unidad="03-00-59";}

      if($unidad=="102151"){ $unidad="02-01-51";}
      if($unidad=="102152"){ $unidad="02-01-52";}
      if($unidad=="102153"){ $unidad="02-01-53";}
      if($unidad=="102154"){ $unidad="02-01-54";}
      if($unidad=="102155"){ $unidad="02-01-55";}
      if($unidad=="102156"){ $unidad="02-01-56";}
      if($unidad=="102157"){ $unidad="02-01-57";}
      if($unidad=="102158"){ $unidad="02-01-58";}

      if($unidad=="102251"){ $unidad="02-02-51";}
      if($unidad=="102252"){ $unidad="02-02-52";}
      if($unidad=="102253"){ $unidad="02-02-53";}
      if($unidad=="102254"){ $unidad="02-02-54";}
      if($unidad=="102255"){ $unidad="02-02-55";}
      if($unidad=="102256"){ $unidad="02-02-56";}
      if($unidad=="102257"){ $unidad="02-02-57";}
      if($unidad=="102258"){ $unidad="02-02-58";}

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
      $cod_ret="000";
      $tipo=substr($codigo,0,1); $error=0;
      if(($concepto>="1")and($concepto<="499")and($error==0)){  $monto=cambia_coma_numero($monto); $cod_partida=substr($codigo,0,3)."-".substr($codigo,3,2)."-".substr($codigo,5,2) ."-".substr($codigo,7,2);
        $referencia_comp="00000000";  $tipo_compromiso="0000"; $cod_presup=$unidad."-".$cod_partida; $fuente_financ="00"; $cod_pre_ret=$cod_presup;
        

		$sSQL="Select * from pag009 WHERE cod_estructura='$codigo_mov' and ref_comp_est='$referencia_comp' and tipo_comp_est='$tipo_compromiso' and cod_presup_est='$cod_presup' and fuente_est='$fuente_financ'";
        $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
        if ($filas>0){ $ssql="UPDATE pag009 SET monto_est=monto_est+$monto where cod_estructura='$codigo_mov' and ref_comp_est='$referencia_comp' and tipo_comp_est='$tipo_compromiso' and cod_presup_est='$cod_presup' and fuente_est='$fuente_financ'"; }
        else{ $ssql = "INSERT INTO pag009(cod_estructura,cod_presup_est,fuente_est,ref_comp_est,tipo_comp_est,tipo_imput_presu,ref_imput_presu,monto_est) VALUES ('".$codigo_mov."','".$cod_presup."','".$fuente_financ."','".$referencia_comp."','".$tipo_compromiso."','P','00000000',".$monto.")"; }
        $resultado=pg_exec($conn,$ssql); $error=1;
        $ssql = "INSERT INTO pag034(cod_estructura,cod_rif_est,ced_rif_est,cod_presup_est,fuente_est,ref_comp_est,tipo_comp_est,monto_cod) VALUES ('".$codigo_mov."','".$cedula."','".$cedula."','".$cod_presup."','".$fuente_financ."','".$referencia_comp."','".$tipo_compromiso."',".$monto.")";
        $resultado=pg_exec($conn,$ssql); $error=1;
      }
      if($concepto=="500"){$cod_ret="001"; $tipo="2";} if($concepto=="502"){$cod_ret="003";$tipo="2";}
      if($concepto=="505"){$cod_ret="002"; $tipo="2";} if($concepto=="506"){$cod_ret="005";$tipo="2";}
      if($concepto=="516"){$cod_ret="006"; $tipo="2";}  if($concepto=="517"){$cod_ret="007"; $tipo="2";}

      if($cod_ret=="000"){$error=1; if ($tipo=="2"){$error=1; echo "no localizado retencion concepto: ".$concepto,"<br>";} }
      if(($tipo=="2")and($error==0)){       $monto=cambia_coma_numero($monto);
        $referencia_comp="00000000";  $tipo_compromiso="0000"; $cod_presup=$cod_pre_ret; $fuente_financ="00";

        $sSQL="Select * from pag011 WHERE cod_estructura='$codigo_mov' and tipo_ret='$cod_ret' and ref_comp_est='$referencia_comp' and tipo_comp_est='$tipo_compromiso' and cod_presup_est='$cod_presup'";
        $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
        if ($filas>0){ $ssql="UPDATE pag011 SET monto_ret=monto_ret+$monto where cod_estructura='$codigo_mov' and tipo_ret='$cod_ret' and ref_comp_est='$referencia_comp' and tipo_comp_est='$tipo_compromiso' and cod_presup_est='$cod_presup'"; }
        else{$ssql = "INSERT INTO pag011(cod_estructura,tipo_ret,ref_comp_est,tipo_comp_est,cod_presup_est,fuente_est,ref_imput_presu,tasa,monto_objeto,monto_ret,ced_rif_ret,concepto_ret) VALUES('".$codigo_mov."','".$cod_ret."','".$referencia_comp."','".$tipo_compromiso."','".$cod_presup."','".$fuente_financ."','00000000',0,0,".$monto.",'G-20009014-6','')";}
        $resultado=pg_exec($conn,$ssql);
        $ssql = "INSERT INTO pag035(cod_estructura,cod_rif_est,ced_rif_est,tipo_ret,ref_comp_est,tipo_comp_est,cod_presup_est,fuente_est,tasa,monto_objeto,monto_ret,ced_rif_ret,concepto_ret) VALUES('".$codigo_mov."','".$cedula."','".$cedula."','".$cod_ret."','".$referencia_comp."','".$tipo_compromiso."','".$cod_presup."','".$fuente_financ."',0,0,".$monto.",'G-20009014-6','')";
        $resultado=pg_exec($conn,$ssql);
      }
      if($error==0) {echo "GRABO CON EXITO","<br>";}
   }

?>
