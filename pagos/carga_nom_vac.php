<?include ("../class/conect.php");  include ("../class/funciones.php"); 
   $conn = pg_connect("host=".$host." port=".$port." password=super user=usia dbname=DATOS");
   if (!$conn) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
    $codigo_mov="00000003";  $cod_pre_ret="";
    $ssql = "UPDATE pag009 set monto_est=0 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);
    $ssql = "UPDATE pag011 set monto_objeto=0,monto_ret=0 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);

   $path="vacac.txt"; $fp = fopen($path,"r");
   while ($linea= fgets($fp,1024)) {
      echo $linea,"<br>";
      $datos = explode(";", $linea);
      $des_concepto=$datos[0];
      $codigo=$datos[1];
      $unidad=$datos[2];
      $monto=$datos[3];
      $tipo=$datos[4];
      $cod_ret="000";
	  
	  $unidad=$unidad*1;
	  
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

      $tipo=substr($tipo,0,1); $error=0;

      if(($codigo=="401060100")or($codigo=="401060300")or($codigo=="401060400")or($codigo=="401060500")or($codigo=="401070700")){$error=1;}
      if(($tipo=="1")and($error==0)){ $monto=elimina_puntos($monto);  $monto=cambia_coma_numero($monto);
        $cod_partida=substr($codigo,0,3)."-".substr($codigo,3,2)."-".substr($codigo,5,2) ."-".substr($codigo,7,2);
        $referencia_comp="00000000";  $tipo_compromiso="0000"; $cod_presup=$unidad."-".$cod_partida; $fuente_financ="00";
        $sSQL="Select * from pag009 WHERE cod_estructura='$codigo_mov' and ref_comp_est='$referencia_comp' and tipo_comp_est='$tipo_compromiso' and cod_presup_est='$cod_presup' and fuente_est='$fuente_financ'";
        $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
        if ($filas>0){ $ssql="UPDATE pag009 SET monto_est=monto_est+$monto where cod_estructura='$codigo_mov' and ref_comp_est='$referencia_comp' and tipo_comp_est='$tipo_compromiso' and cod_presup_est='$cod_presup' and fuente_est='$fuente_financ'"; }
        else{ $ssql = "INSERT INTO pag009(cod_estructura,cod_presup_est,fuente_est,ref_comp_est,tipo_comp_est,tipo_imput_presu,ref_imput_presu,monto_est) VALUES ('".$codigo_mov."','".$cod_presup."','".$fuente_financ."','".$referencia_comp."','0000','P','00000000',".$monto.")"; }
        $resultado=pg_exec($conn,$ssql); $error=1;
        if($cod_pre_ret==""){$cod_pre_ret=$cod_presup;}
      }

      if($codigo=="211040100"){$cod_ret="001";  echo $cod_ret,"<br>"; } if($codigo=="211040300"){$cod_ret="002";} if($codigo=="211040400"){$cod_ret="003";}
      if($codigo=="211040501"){$cod_ret="004";} if($codigo=="211040600"){$cod_ret="005";} if($codigo=="211049901"){$cod_ret="006";}
      if($codigo=="211017223"){$cod_ret="017";} if($codigo=="211016565"){$cod_ret="018";} if($codigo=="211012520"){$cod_ret="019";}
      if($codigo=="112020200"){$cod_ret="020";}
      if($codigo=="211049902"){$cod_ret="000";   if(substr($des_concepto,0,11)=="RETENC.F.AH"){$cod_ret="007";}
        if(substr($des_concepto,0,11)=="RETENC.CAJA"){$cod_ret="008";}
        if(substr($des_concepto,0,11)=="CORTO PLAZO"){$cod_ret="009";}
        if(substr($des_concepto,0,9)=="CORTO ESP"){$cod_ret="010";}
        if(substr($des_concepto,0,11)=="MEDIANO PLA"){$cod_ret="011";}
        if(substr($des_concepto,0,11)=="MEDIANO ESP"){$cod_ret="011";} 
        if(substr($des_concepto,0,10)=="SALUD CAJA"){$cod_ret="012";}
        if(substr($des_concepto,0,10)=="LINEA BLAN"){$cod_ret="013";}
        if(substr($des_concepto,0,10)=="COMPUTADOR"){$cod_ret="014";}
        if(substr($des_concepto,0,10)=="FERRETERIA"){$cod_ret="015";}
        if(substr($des_concepto,0,8)=="FERRET C"){$cod_ret="015";}
		if(substr($des_concepto,0,11)=="CREDITO FER"){$cod_ret="015";}
        if(substr($des_concepto,0,10)=="CREDITO RE"){$cod_ret="016";}
		if(substr($des_concepto,0,10)=="MEDIANO ES"){$cod_ret="024";}
        if(substr($des_concepto,0,10)=="CONTRA QUI"){$cod_ret="025";}
		if(substr($des_concepto,0,11)=="CREDITO ESC"){$cod_ret="026";}
		if(substr($des_concepto,0,11)=="CREDITO SAL"){$cod_ret="027";}
		if(substr($des_concepto,0,11)=="RECREACIONAL M/P"){$cod_ret="016";}
      }
      if($codigo=="211016946"){$cod_ret="000"; if(substr($des_concepto,0,17)=="DESC. JUZ.CALDERA"){$cod_ret="051";}
        if(substr($des_concepto,0,17)=="DESC.JUZG.JIMENEZ"){$cod_ret="052";}
        if(substr($des_concepto,0,17)=="DESC JUZ ALVA GAR"){$cod_ret="053";}
      }
      if($cod_ret=="000"){$error=1;}
      if(($tipo=="2")and($error==0)){ $monto=elimina_puntos($monto); 
        $monto=cambia_coma_numero($monto); $monto=$monto*-1;
        $referencia_comp="00000000";  $tipo_compromiso="0000"; $cod_presup=$cod_pre_ret; $fuente_financ="00";
        $sSQL="Select * from pag011 WHERE cod_estructura='$codigo_mov' and tipo_ret='$cod_ret'";
        $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
        if ($filas>0){ $ssql="UPDATE pag011 SET monto_ret=monto_ret+$monto where cod_estructura='$codigo_mov' and tipo_ret='$cod_ret'"; }
        else{$ssql = "INSERT INTO pag011(cod_estructura,tipo_ret,ref_comp_est,tipo_comp_est,cod_presup_est,fuente_est,ref_imput_presu,tasa,monto_objeto,monto_ret,ced_rif_ret,concepto_ret)  VALUES ('".$codigo_mov."','".$cod_ret."','".$referencia_comp."','0000','".$cod_presup."','".$fuente_financ."','00000000',0,0,".$monto.",'G-20009014-6','')";}
        $resultado=pg_exec($conn,$ssql);

      }
   }
?>
