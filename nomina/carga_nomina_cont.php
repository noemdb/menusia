<?include ("../class/conect.php"); include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();
  
   $conn=pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");  if (!$conn) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
   $codigo_mov="00000004";  $cod_pre_ret="01-00-54-401-01-18-00"; $tipo_nomina="03"; $tp_calculo="N"; $codigo_mov2="00000009"; 
   $ssql = "UPDATE pag009 set monto_est=0 where cod_estructura='$codigo_mov' or cod_estructura='$codigo_mov2'";  $resultado=pg_exec($conn,$ssql);
   $ssql = "UPDATE pag011 set monto_objeto=0,monto_ret=0 where cod_estructura='$codigo_mov' or cod_estructura='$codigo_mov2'";  $resultado=pg_exec($conn,$ssql);
   $ssql = "delete from pag033 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);
   $ssql = "delete from pag034 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);
   $ssql = "delete from pag035 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);	
   $ssql = "UPDATE pag037 set monto_est=0 where cod_estructura='$codigo_mov'";  $resultado=pg_exec($conn,$ssql);
   $url="Mostrar_est_cont.php?criterio=".$codigo_mov.$codigo_mov2;   $error=0;
   $sql="SELECT * FROM NOM017 Where (NOM017.Oculto='NO') and (concepto_vac='N') and  (NOM017.afecta_presup='SI') And (NOM017.cod_concepto<>'VVV') And (NOM017.tp_calculo='$tp_calculo') and (NOM017.tipo_nomina='$tipo_nomina') and (NOM017.cod_presup='$cod_pre_ret') order by cod_concepto";
   $sql="SELECT * FROM NOM017 Where (NOM017.Oculto='NO') and (concepto_vac='N') and  (NOM017.afecta_presup='SI') And (NOM017.cod_concepto<>'VVV') And (NOM017.tp_calculo='$tp_calculo') and (NOM017.tipo_nomina='$tipo_nomina') order by cod_concepto";
   $resb=pg_query($sql); $error_comp=0;
   //$sql="SELECT * FROM NOM019 Where (NOM019.Oculto='NO') and (concepto_vac='N') and  (NOM019.afecta_presup='SI') And (NOM019.cod_concepto<>'VVV') And (NOM019.tp_calculo='$tp_calculo') and (NOM019.tipo_nomina='$tipo_nomina') AND fecha_p_hasta='2011-10-31' order by cod_concepto";
   //$resb=pg_query($sql); $error_comp=0;
   //echo $sql,"<br>";
   while($regb=pg_fetch_array($resb)){ $cod_presup=$regb["cod_presup"]; $monto=$regb["monto"]; $cod_fuente="00";
      $asig_ded_apo=$regb["asig_ded_apo"]; $cedula=$regb["cedula"]; $concepto=$regb["cod_concepto"]; $cod_ret="000";  $unidad="01-00-54"; $error=0;	  
	  if($asig_ded_apo=="A"){ $tipo="1"; } else {$tipo="2";} 	  
	  //if($concepto=="550"){echo $cedula." ".$concepto." ".$tipo,"<br>";}
      if((($concepto=="001")or($concepto=="002")or($concepto=="008")or($concepto=="014")or($concepto=="075")or($concepto=="121")or($concepto=="522")or($concepto=="525")or($concepto=="526")or($concepto=="520"))and($error==0)and($cod_presup==$cod_pre_ret)){  
	    $monto=cambia_coma_numero($monto);      $referencia_comp="00000000";  $tipo_compromiso="0000";  $fuente_financ="00";  
		if(($concepto=="522")or($concepto=="520")or($concepto=="525")or($concepto=="526")){$monto=$monto*-1;}
		$sSQL="select * from pag037 WHERE cod_estructura='$codigo_mov' and ced_rif_est='$cedula'"; $res=pg_query($sSQL);  $filas=pg_num_rows($res);
        if ($filas>0){ $reg=pg_fetch_array($res); $referencia_comp=$reg["ref_comp_est"]; $tipo_compromiso=$reg["tipo_comp_est"]; 
		   $ssql="UPDATE pag037 SET monto_est=monto_est+$monto where cod_estructura='$codigo_mov' and ced_rif_est='$cedula'"; $resultado=pg_exec($conn,$ssql);}
		 else{$error=1;  $error_comp=1; echo "Compromiso no localizado de la Cedula: ".$cedula,"<br>"; ?><script language="JavaScript">muestra('COMPROMISO NO LOCALIZADO DE CEDULA: <? echo $cedula; ?>');</script><?}		 
		if($error==0){
		  $sSQL="select sum(monto-causado-ajustado) as saldo from pre036 WHERE referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'"; $res=pg_query($sSQL);  $filas=pg_num_rows($res);
        if ($filas>0){ $reg=pg_fetch_array($res); $saldo=$reg["saldo"]; 
		   if($saldo<$monto){ $error=1; $error_comp=1;  echo "Compromiso no tiene Saldo de la Cedula:".$cedula." Referencia:".$referencia_comp." Tipo:".$tipo_compromiso." Saldo:".$saldo." Monto:".$monto,"<br>"; ?><script language="JavaScript">muestra('COMPROMISO NO TIENE SALDO DE CEDULA: <? echo $cedula; ?>');</script><? }
		} } 		
		$sSQL="Select * from pag009 WHERE cod_estructura='$codigo_mov' and ref_comp_est='$referencia_comp' and tipo_comp_est='$tipo_compromiso' and cod_presup_est='$cod_presup' and fuente_est='$fuente_financ'";
        $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
        if ($filas>0){ $ssql="UPDATE pag009 SET monto_est=monto_est+$monto where cod_estructura='$codigo_mov' and ref_comp_est='$referencia_comp' and tipo_comp_est='$tipo_compromiso' and cod_presup_est='$cod_presup' and fuente_est='$fuente_financ'"; }
        else{ $ssql = "INSERT INTO pag009(cod_estructura,cod_presup_est,fuente_est,ref_comp_est,tipo_comp_est,tipo_imput_presu,ref_imput_presu,monto_est) VALUES ('".$codigo_mov."','".$cod_presup."','".$fuente_financ."','".$referencia_comp."','".$tipo_compromiso."','P','00000000',".$monto.")"; }
        $resultado=pg_exec($conn,$ssql); $error=0;
        $ssql = "INSERT INTO pag034(cod_estructura,cod_rif_est,ced_rif_est,cod_presup_est,fuente_est,ref_comp_est,tipo_comp_est,monto_cod) VALUES ('".$codigo_mov."','".$cedula."','".$cedula."','".$cod_presup."','".$fuente_financ."','".$referencia_comp."','".$tipo_compromiso."',".$monto.")";
        $resultado=pg_exec($conn,$ssql); $error=0;
      }
	  else{ if($tipo=="1"){ $monto=cambia_coma_numero($monto);      $referencia_comp="00000000";  $tipo_compromiso="0000";  $fuente_financ="00";
	    $sSQL="Select * from pag009 WHERE cod_estructura='$codigo_mov2' and ref_comp_est='$referencia_comp' and tipo_comp_est='$tipo_compromiso' and cod_presup_est='$cod_presup' and fuente_est='$fuente_financ'";
        $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
        if ($filas>0){ $ssql="UPDATE pag009 SET monto_est=monto_est+$monto where cod_estructura='$codigo_mov2' and ref_comp_est='$referencia_comp' and tipo_comp_est='$tipo_compromiso' and cod_presup_est='$cod_presup' and fuente_est='$fuente_financ'"; }
        else{ $ssql = "INSERT INTO pag009(cod_estructura,cod_presup_est,fuente_est,ref_comp_est,tipo_comp_est,tipo_imput_presu,ref_imput_presu,monto_est) VALUES ('".$codigo_mov2."','".$cod_presup."','".$fuente_financ."','".$referencia_comp."','".$tipo_compromiso."','P','00000000',".$monto.")"; }
        $resultado=pg_exec($conn,$ssql);
	  }}	  
      if($concepto=="500"){$cod_ret="001"; $tipo="2";} if($concepto=="502"){$cod_ret="003";$tipo="2";}
      if($concepto=="505"){$cod_ret="002"; $tipo="2";} if($concepto=="506"){$cod_ret="005";$tipo="2";}
      if($concepto=="524"){$cod_ret="006"; $tipo="2";} if($concepto=="512"){$cod_ret="004"; $tipo="2";}	  
      if($concepto=="517"){$cod_ret="002"; $tipo="2";} if($concepto=="544"){$cod_ret="006"; $tipo="2";}
      if($concepto=="510"){$cod_ret="056"; $tipo="2";}
      if($concepto=="507"){$cod_ret="007"; $tipo="2";}
      if($concepto=="550"){$cod_ret="055"; $tipo="2";}
      if(($cod_ret=="000")and ($tipo=="2")){$error=1; if (($tipo=="2")and(($concepto<>"522")OR($concepto<>"520")OR($concepto<>"525"))){$error=1; echo "no localizado retencion concepto: ".$concepto,"<br>";} }
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
   
   $sql="Select cod_presup_est,fuente_est,sum(monto_est) as monto from pag009 WHERE cod_estructura='$codigo_mov2' group by cod_presup_est,fuente_est"; $res=pg_query($sql);
   while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]; $cod_presup=$registro["cod_presup_est"]; $cod_fuente=$registro["fuente_est"];
    $sqlp = "SELECT denominacion,disponible,diferido FROM PRE001 WHERE (Cod_Presup='$cod_presup') and (Cod_Fuente='$cod_fuente')"; $resp=pg_query($sqlp); $filas=pg_num_rows($resp);
    if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO <? echo $cod_presup; ?> NO EXISTE EN DISPONIBILIDAD');</script><? }
    else{ $regp=pg_fetch_array($resp); $disponible=$regp["disponible"]; if($disponible<$monto){ echo "Codigo: ".$cod_presup." Requiere: ".$monto." Disponible: ".$disponible,"<br>";
        ?><script language="JavaScript">muestra('NO EXISTE DISPONIBILIDAD PARA EL CODIGO PRESUPUESTARIO:<? echo $cod_presup; ?> FUENTE:<? echo $cod_fuente; ?> \n DISPONIBILIDAD ACTUAL:<? echo $disponible; ?> MONTO REQUERIDO:<? echo $monto; ?> \n POR FAVOR VERIFIQUE');</script><?}}
   
   } 
   if(($error==0)and($error_comp==0)){ echo "GRABO CON EXITO","<br>";    
   ?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?
   } else { echo $error;} 
?>
