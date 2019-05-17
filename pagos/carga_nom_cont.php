<?include ("../class/funciones.php");
   $conn = pg_connect("host=".$host." port=".$port." password=super user=usia dbname=DATOS");
   if (!$conn) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
    $codigo_mov="00000004";  $cod_pre_ret="01-00-54-401-01-18-00";
    $ssql = "UPDATE pag009 set monto_est=0 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);
    $ssql = "UPDATE pag011 set monto_objeto=0,monto_ret=0 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);

    $ssql = "delete from pag033 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);
    $ssql = "delete from pag034 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);
    $ssql = "delete from pag035 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);
	
	$ssql = "UPDATE pag037 set monto_est=0 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);

    $error=0;
   $path="cont.txt"; $fp = fopen($path,"r");
   while ($linea= fgets($fp,1024)) {
      //echo $linea,"<br>";
      $datos = explode(";", $linea);
      $cedula=$datos[0]; $concepto=$datos[1]; $cedula=trim($cedula);
      $codigo=$datos[3];  $monto=$datos[4];  $unidad=$datos[5];
      $cod_ret="000";  $unidad="01-00-54";
      $tipo=substr($codigo,0,1); $error=0;
      if((($concepto=="1")or($concepto=="2")or($concepto=="75")or($concepto=="522")or($concepto=="525"))and($error==0)and($codigo="401011800")){  $monto=cambia_coma_numero($monto); $cod_partida=substr($codigo,0,3)."-".substr($codigo,3,2)."-".substr($codigo,5,2) ."-".substr($codigo,7,2);
        $referencia_comp="00000000";  $tipo_compromiso="0000"; $cod_presup=$unidad."-".$cod_partida; $fuente_financ="00";
        
		
		if(($concepto=="522")or($concepto=="525")){$monto=$monto*-1;}
		$sSQL="select * from pag037 WHERE cod_estructura='$codigo_mov' and ced_rif_est='$cedula'"; $res=pg_query($sSQL);  $filas=pg_num_rows($res);
        if ($filas>0){ $reg=pg_fetch_array($res); $referencia_comp=$reg["ref_comp_est"]; $tipo_compromiso=$reg["tipo_comp_est"]; 
		   $ssql="UPDATE pag037 SET monto_est=monto_est+$monto where cod_estructura='$codigo_mov' and ced_rif_est='$cedula'"; $resultado=pg_exec($conn,$ssql);}
		 else{$error=1;  echo "Compromiso no localizado de la Cedula:".$cedula,"<br>";}
		 
		if($error==0){
		  $sSQL="select sum(monto-causado-ajustado) as saldo from pre036 WHERE referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'"; $res=pg_query($sSQL);  $filas=pg_num_rows($res);
        if ($filas>0){ $reg=pg_fetch_array($res); $saldo=$reg["saldo"]; 
		   if($saldo<$monto){ $error=1;  echo "Compromiso no tiene Saldo de la Cedula:".$cedula." Referencia:".$referencia_comp." Tipo:".$tipo_compromiso." Saldo:".$saldo." Monto:".$monto,"<br>"; }
		} } 
		
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
      if($concepto=="516"){$cod_ret="006"; $tipo="2";} if($concepto=="512"){$cod_ret="004"; $tipo="2";}

      if($cod_ret=="000"){$error=1; if ($tipo=="2"){$error=1; echo "no localizado retencion concepto: ".$concepto,"<br>";} }
      if(($tipo=="2")and($error==0)){       $monto=cambia_coma_numero($monto);
        $referencia_comp="00000000";  $tipo_compromiso="0000"; $cod_presup=$cod_pre_ret; $fuente_financ="00";
		$sSQL="select * from pag037 WHERE cod_estructura='$codigo_mov' and ced_rif_est='$cedula'"; $res=pg_query($sSQL);  $filas=pg_num_rows($res);
        if ($filas>0){ $reg=pg_fetch_array($res); $referencia_comp=$reg["ref_comp_est"]; $tipo_compromiso=$reg["tipo_comp_est"]; }
		
        $sSQL="Select * from pag011 WHERE cod_estructura='$codigo_mov' and tipo_ret='$cod_ret' and ref_comp_est='$referencia_comp' and tipo_comp_est='$tipo_compromiso' and cod_presup_est='$cod_presup'";
        $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
        if ($filas>0){ $ssql="UPDATE pag011 SET monto_ret=monto_ret+$monto where cod_estructura='$codigo_mov' and tipo_ret='$cod_ret' and ref_comp_est='$referencia_comp' and tipo_comp_est='$tipo_compromiso' and cod_presup_est='$cod_presup'"; }
        else{$ssql = "INSERT INTO pag011(cod_estructura,tipo_ret,ref_comp_est,tipo_comp_est,cod_presup_est,fuente_est,ref_imput_presu,tasa,monto_objeto,monto_ret,ced_rif_ret,concepto_ret) VALUES('".$codigo_mov."','".$cod_ret."','".$referencia_comp."','".$tipo_compromiso."','".$cod_presup."','".$fuente_financ."','00000000',0,0,".$monto.",'G-20009014-6','')";}
        $resultado=pg_exec($conn,$ssql);
        $ssql = "INSERT INTO pag035(cod_estructura,cod_rif_est,ced_rif_est,tipo_ret,ref_comp_est,tipo_comp_est,cod_presup_est,fuente_est,tasa,monto_objeto,monto_ret,ced_rif_ret,concepto_ret) VALUES('".$codigo_mov."','".$cedula."','".$cedula."','".$cod_ret."','".$referencia_comp."','".$tipo_compromiso."','".$cod_presup."','".$fuente_financ."',0,0,".$monto.",'G-20009014-6','')";
        $resultado=pg_exec($conn,$ssql);
      }
   }
   if($error==0) {echo "GRABO CON EXITO","<br>";}
?>
