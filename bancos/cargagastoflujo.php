<?include ("../class/conect.php");  include ("../class/funciones.php");
$password=$_GET["password"];$user=$_GET["user"]; $dbname=$_GET["dbname"]; $mes=$_GET["mes"]; $ano=$_GET["ano"];  $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$fecha_d="01-".$mes."-".$ano; $fecha_h=colocar_udiames($fecha_d); $fecha_1=formato_aaaammdd($fecha_d);  $fecha_2=formato_aaaammdd($fecha_h);
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
$sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
$long_c=strlen($formato_presup); $c=strlen($formato_categoria)+1; $p=strlen($formato_partida);
$ssql = "SELECT * From ban021 where (periodo='$mes')"; $resultado=pg_query($ssql);  $filas=pg_num_rows($resultado);
if ($filas>0){echo "Gastos de Flujo para este periodo Ya Existe","<br>"; }
else{
$sql="SELECT ban004.cod_banco,ban004.referencia,ban004.referenciaa,ban004.tipo_mov_libro,ban004.monto_mov_libro,ban004.fecha_mov_libro,ban004.cod_bancoa,ban004.ced_rif,ban004.descrip_mov_libro,ban004.anulado,ban006.nro_orden_pago,ban006.chq_o_f_c,ban006.anulado,ban006.num_cheque,ban006.tipo_pago  FROM ban004 Left Join ban006 ON ((ban006.cod_banco=ban004.cod_banco) And (ban006.num_cheque=ban004.referencia)) where (ban004.fecha_mov_libro>='$fecha_1') And (ban004.fecha_mov_libro<='$fecha_2') And (ban004.tipo_mov_libro='CHQ' OR ban004.tipo_mov_libro='ANU' OR ban004.tipo_mov_libro='NDB' OR ban004.tipo_mov_libro='AND') Order by ban004.fecha_mov_libro,ban004.cod_banco,ban004.referencia,ban004.tipo_mov_libro"; $res=pg_query($sql);
//echo $sql,"<br>";
while($registro=pg_fetch_array($res)){ $cod_banco=$registro["cod_banco"]; $referencia=$registro["referencia"]; $referenciaa=$registro["referenciaa"]; $tipo_mov=$registro["tipo_mov_libro"]; $cod_bancoa=$registro["cod_bancoa"];
$fecha=$registro["fecha_mov_libro"]; $nro_orden=$registro["nro_orden_pago"]; $monto_mov_libro=$registro["monto_mov_libro"]; $descripcion=$registro["descrip_mov_libro"]; $anulado=$registro["anulado"];
$ced_rif=$registro["ced_rif"]; $chq_o_f_c=$registro["chq_o_f_c"]; $tipo_pago=$registro["tipo_pago"]; $Busca_B=True;
   If (($tipo_mov=="NDB") Or ($tipo_mov=="AND")) {  $primera=substr($cod_bancoa,0,1);
    if($primera=="D"){    
      $tipo_pago="0".substr($cod_bancoa,1,3);  If($tipo_mov=="AND") { $tipo_pago="A".substr($cod_bancoa,1,3); }   
      $sqlp="SELECT tipo_pago,cod_presup,fuente_financ,cod_contable,monto FROM CODIGOS_PAGOS Where (referencia_pago='$referencia') And (cod_banco='$cod_banco') And (tipo_pago='$tipo_pago')";   $resp=pg_query($sqlp); 
      while($registrop=pg_fetch_array($resp)){ $cod_presup=$registrop["cod_presup"]; $cod_contable=$registrop["cod_contable"];
	    $cod_partida=substr($cod_presup,$c,$p); $monto=$registrop["monto"]; $fuente_financ=$registrop["fuente_financ"];
		$ssqlg="SELECT ACTUALIZA_BAN021(1,'$mes','$cod_banco','$referencia','$tipo_mov','$ced_rif','$fecha',$monto_mov_libro,'$cod_presup','$fuente_financ','$cod_partida','$cod_contable',$monto,'','',0,0,'$descripcion')";
	    $resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>"; }
      }	 
    }	
	if($primera=="A"){
	  $tipo_pago="0".substr($cod_bancoa,1,3);  If($tipo_mov=="AND") { $tipo_pago="A".substr($cod_bancoa,1,3); }  
      $total_pasivos=0;	  $monto_retencion=0;
      $sqlp="SELECT tipo_pago,cod_presup,fuente_financ,cod_contable,referencia_caus,referencia_comp,monto FROM CODIGOS_PAGOS Where (referencia_pago='$referencia') And (cod_banco='$cod_banco') And (tipo_pago='$tipo_pago')";   $resp=pg_query($sqlp); 
      while($registrop=pg_fetch_array($resp)){ $cod_presup=$registrop["cod_presup"]; $cod_contable=$registrop["cod_contable"];
	    $cod_partida=substr($cod_presup,$c,$p); $monto=$registrop["monto"]; $fuente_financ=$registrop["fuente_financ"]; $referencia_caus=$registrop["referencia_caus"]; $referencia_comp=$registrop["referencia_comp"];
		$sqlo="SELECT nro_orden,tipo_causado,tipo_orden,fecha,total_causado,cod_contable_o,afecta_presu,total_retencion,total_pasivos,monto_am_ant from pag001 Where (status='I') And ((anulado='N') or ((anulado='S') And (fecha_anulado>'$fecha_2'))) And (tipo_pago='NDB') And (nro_cheque<>'$referencia') And (nro_orden='$referenciaa')";	  
	    $reso=pg_query($sqlo);
		while($registroo=pg_fetch_array($reso)){ $nro_orden=$registroo["nro_orden"]; $tipo_causado=$registroo["tipo_causado"]; $total_pasivos=$registroo["total_pasivos"]; $afecta_presu=$registroo["afecta_presu"]; $cod_contable_o=$registroo["cod_contable_o"]; $tipo_orden=$registroo["tipo_orden"];  $monto_am_ant=$registroo["monto_am_ant"];
	       $sqlr="SELECT pag004.nro_orden_ret,pag004.aux_orden,pag004.cod_presup_ret,pag004.monto_retencion FROM pag004 Where (nro_orden_ret='$referencia_caus') and (cod_presup_ret='$cod_presup') and (fuente_fin_ret='$fuente_financ') and (ref_comp_ret='$referencia_comp')";   $resr=pg_query($sqlr);
		   while($registror=pg_fetch_array($resr)){ $monto_retencion=$registror["monto_retencion"];  $monto=$monto-$monto_retencion; } 
		}
		//echo $referencia."  ".$monto_mov_libro,"<br>";
		$ssqlg="SELECT ACTUALIZA_BAN021(1,'$mes','$cod_banco','$referencia','$tipo_mov','$ced_rif','$fecha',$monto_mov_libro,'$cod_presup','$fuente_financ','$cod_partida','$cod_contable',$monto,'','',0,0,'$descripcion')";
	    $resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>"; }
      }	 
      //echo $sqlo,"<br>";
	  //echo $referenciaa."  ".$total_pasivos,"<br>";
      if($total_pasivos>0){
		  $sqlp="SELECT cod_cuenta,monto_pasivo FROM pag020 Where (monto_pasivo>0) and (nro_orden='$nro_orden' ) And (tipo_causado='$tipo_causado')";$resp=pg_query($sqlp);
		  //echo $sqlp,"<br>";
		  while($registrop=pg_fetch_array($resp)){ $cod_cuenta=$registrop["cod_cuenta"]; $monto=$registrop["monto_pasivo"]; $cod_partida=""; $cod_presup=""; $fuente_financ="00";
			If($tipo_mov=="AND") {$monto=$monto*-1; }	
			If (substr($cod_cuenta, 0, 7)=="1-01-02"){$cod_partida="401-01-01-00"; }
			If (substr($cod_cuenta, 0, 10)=="2-01-05-02"){$cod_partida="401-01-01-00"; } 
			If (substr($cod_cuenta, 0, 10)=="2-01-01-04"){$cod_partida= "401-01-01-00"; }  // presgunta retenciones laborales			
			//Modificado el 17-10-2013
			If (substr($cod_cuenta, 0, 7)=="1-01-02"){$cod_partida=$cod_cuenta; }
			If (substr($cod_cuenta, 0, 10)=="2-01-05-02"){$cod_partida=$cod_cuenta; } 
			If (substr($cod_cuenta, 0, 10)=="2-01-01-04"){$cod_partida= $cod_cuenta; }			
			If ($cod_cuenta=="2-03-01-02-01"){$cod_partida="407"; } 
			If ($cod_cuenta=="2-03-02-01-01"){$cod_partida="500"; } 
			If ($cod_cuenta=="1-02-05-03-01"){$cod_partida="403"; }	
            //2-01-01-04-04-099			
			//If (substr($cod_cuenta, 0, 7)=="1-01-02"){$cod_partida="401-01-01-00"; }
			//If (substr($cod_cuenta, 0, 10)=="2-01-05-02"){$cod_partida="401-01-01-00"; }   
			//If (substr($cod_cuenta, 0, 10)=="2-01-01-04"){$cod_partida= "401-01-01-00"; }
			//If ($cod_cuenta=="2-03-01-02-01"){$cod_partida="407"; } If ($cod_cuenta=="2-03-02-01-01"){$cod_partida="403"; } If ($cod_cuenta=="1-02-05-03-01"){$cod_partida="403"; }
			$ssqlg="SELECT ACTUALIZA_BAN021(1,'$mes','$cod_banco','$referencia','$tipo_mov','$ced_rif','$fecha',$monto_mov_libro,'$cod_presup','$fuente_financ','$cod_partida','$cod_cuenta',$monto,'','',0,0,'$descripcion')";
			$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>"; }
		  } 
		}	
	}
    if($primera=="P"){
	  $tipo_pago="0".substr($cod_bancoa,1,3);  If($tipo_mov=="AND") { $tipo_pago="A".substr($cod_bancoa,1,3); } 
      $sqlo="SELECT nro_orden,tipo_causado,tipo_orden,fecha,total_causado,cod_contable_o,afecta_presu,total_retencion,total_pasivos,monto_am_ant from pag001 Where (status='I') And ((anulado='N') or ((anulado='S') And (fecha_anulado>'$fecha_2'))) And (tipo_pago='NDB') And (cod_banco='$cod_banco') And (nro_cheque='$referencia')";	  
	  /*if($anulado=="X"){
	    $sqlo="select nro_orden from pag007 where (pag007.cod_banco='$cod_banco') And (pag007.nro_Cheque='$referencia') and (tipo_pago='NDB')";
		$reso=pg_query($sqlo); $filas=pg_num_rows($reso); if ($filas>0){$rego=pg_fetch_array($reso); $nro_orden=$rego["nro_orden"];
		$sqlo="SELECT nro_orden,tipo_causado,tipo_orden,fecha,total_causado,cod_contable_o,afecta_presu,total_retencion,total_pasivos,monto_am_ant from pag001 Where (nro_orden='$nro_orden')";
		}
	  }*/
      $reso=pg_query($sqlo);
      while($registroo=pg_fetch_array($reso)){ $nro_orden=$registroo["nro_orden"]; $tipo_causado=$registroo["tipo_causado"]; $total_pasivos=$registroo["total_pasivos"]; $afecta_presu=$registroo["afecta_presu"]; $cod_contable_o=$registroo["cod_contable_o"]; $tipo_orden=$registroo["tipo_orden"];  $monto_am_ant=$registroo["monto_am_ant"];
		$sqlp="SELECT tipo_pago,referencia_comp,cod_presup,fuente_financ,cod_contable,monto FROM CODIGOS_PAGOS Where (referencia_pago='$referencia') And (referencia_caus='$nro_orden') And (cod_banco='$cod_banco') And (tipo_pago='$tipo_pago')";   $resp=pg_query($sqlp);
		while($registrop=pg_fetch_array($resp)){  $referencia_comp=$registrop["referencia_comp"]; $cod_presup=$registrop["cod_presup"]; $cod_contable=$registrop["cod_contable"];
			$cod_partida=substr($cod_presup,$c,$p); $monto=$registrop["monto"]; $fuente_financ=$registrop["fuente_financ"];		
			$sqlr="SELECT pag004.nro_orden_ret,pag004.aux_orden,pag004.cod_presup_ret,pag004.monto_retencion FROM pag004 Where (nro_orden_ret='$nro_orden') and (cod_presup_ret='$cod_presup') and (fuente_fin_ret='$fuente_financ') and (ref_comp_ret='$referencia_comp')";   $resr=pg_query($sqlr);
			while($registror=pg_fetch_array($resr)){ $monto_retencion=$registror["monto_retencion"];  $monto=$monto-$monto_retencion; }  
			$ssqlg="SELECT ACTUALIZA_BAN021(1,'$mes','$cod_banco','$referencia','$tipo_mov','$ced_rif','$fecha',$monto_mov_libro,'$cod_presup','$fuente_financ','$cod_partida','$cod_contable',$monto,'','',0,0,'$descripcion')";
			$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>"; }
		}
		if($total_pasivos>0){
		  $sqlp="SELECT cod_cuenta,monto_pasivo FROM pag020 Where (monto_pasivo>0) and (nro_orden='$nro_orden' ) And (tipo_causado='$tipo_causado')";$resp=pg_query($sqlp);
		  //echo $sqlp,"<br>";
		  while($registrop=pg_fetch_array($resp)){ $cod_cuenta=$registrop["cod_cuenta"]; $monto=$registrop["monto_pasivo"]; $cod_partida=""; $cod_presup=""; $fuente_financ="00";
			If($tipo_mov=="AND") {$monto=$monto*-1; }	
			If (substr($cod_cuenta, 0, 7)=="1-01-02"){$cod_partida="401-01-01-00"; }
			If (substr($cod_cuenta, 0, 10)=="2-01-05-02"){$cod_partida="401-01-01-00"; } 
			If (substr($cod_cuenta, 0, 10)=="2-01-01-04"){$cod_partida= "401-01-01-00"; }  // presgunta retenciones laborales			
			//Modificado el 17-10-2013
			If (substr($cod_cuenta, 0, 7)=="1-01-02"){$cod_partida=$cod_cuenta; }
			If (substr($cod_cuenta, 0, 10)=="2-01-05-02"){$cod_partida=$cod_cuenta; } 
			If (substr($cod_cuenta, 0, 10)=="2-01-01-04"){$cod_partida= $cod_cuenta; }			
			If ($cod_cuenta=="2-03-01-02-01"){$cod_partida="407"; } 
			If ($cod_cuenta=="2-03-02-01-01"){$cod_partida="500"; } 
			If ($cod_cuenta=="1-02-05-03-01"){$cod_partida="403"; }	
            //2-01-01-04-04-099			
			//If (substr($cod_cuenta, 0, 7)=="1-01-02"){$cod_partida="401-01-01-00"; }
			//If (substr($cod_cuenta, 0, 10)=="2-01-05-02"){$cod_partida="401-01-01-00"; }   
			//If (substr($cod_cuenta, 0, 10)=="2-01-01-04"){$cod_partida= "401-01-01-00"; }
			//If ($cod_cuenta=="2-03-01-02-01"){$cod_partida="407"; } If ($cod_cuenta=="2-03-02-01-01"){$cod_partida="403"; } If ($cod_cuenta=="1-02-05-03-01"){$cod_partida="403"; }
			$ssqlg="SELECT ACTUALIZA_BAN021(1,'$mes','$cod_banco','$referencia','$tipo_mov','$ced_rif','$fecha',$monto_mov_libro,'$cod_presup','$fuente_financ','$cod_partida','$cod_cuenta',$monto,'','',0,0,'$descripcion')";
			$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>"; }
		  } 
		}        
		/*if(($Busca_B==FALSE)and($afecta_presu=="X")){ $cod_partida="412"; $monto=$monto_mov_libro; $cod_presup=""; $fuente_financ="00";
			  $monto_orden=$monto_orden-$monto_am_ant; 
			  if($monto>$monto_orden){ $monto=$monto_orden; } If($tipo_mov=="AND") {$monto=$monto*-1; }	
			  if($cod_contable_o=="2-01-01-07"){$cod_partida="412";} if($tipo_orden=="0002"){$cod_partida="401";}  if($tipo_orden=="0017"){$cod_partida="402";} 
			  if($tipo_orden=="0003"){$cod_partida="403-18-01-00";} if($tipo_orden=="0004"){$cod_partida="403-15-04-00";}  if($tipo_orden=="0007"){$cod_partida="403-15-02-00";}
              $ssqlg="SELECT ACTUALIZA_BAN021(1,'$mes','$cod_banco','$referencia','$tipo_mov','$ced_rif','$fecha',$monto_mov_libro,'$cod_presup','$fuente_financ','$cod_partida','$cod_contable_o',$monto,'','',0,0,'$descripcion')";
			  $resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>"; }
		}*/	  
	  }                    
    }	
   }
   If (($tipo_mov=="CHQ") Or ($tipo_mov=="ANU")) {
      $tipo_pago="0".substr($tipo_pago,1,3);  If($tipo_mov=="ANU") { $tipo_pago="A".substr($tipo_pago,1,3); } 
      if($chq_o_f_c=="O"){
	    $sqlo="SELECT pag007.nro_orden,pag007.tipo_causado,pag007.fecha_cheque,pag007.anulado,pag007.fecha_anulado,pag001.tipo_orden,pag001.cod_contable_o,pag001.afecta_presu,pag001.total_causado,pag001.total_pasivos,pag001.total_retencion,pag001.clasif_orden,pag001.monto_am_ant FROM pag007,pag001 WHERE (pag007.nro_orden=pag001.nro_orden) and (pag007.tipo_causado=pag001.tipo_causado) and (pag007.cod_banco='$cod_banco') And (pag007.nro_Cheque='$referencia') and (pag007.tipo_pago='CHQ')"; $reso=pg_query($sqlo);
		//echo $sqlo,"<br>";
		while($registroo=pg_fetch_array($reso)){ $nro_orden=$registroo["nro_orden"]; $tipo_causado=$registroo["tipo_causado"];  $afecta_presu=$registroo["afecta_presu"]; $cod_contable_o=$registroo["cod_contable_o"];
		    $Busca_B=True; $monto_orden=$registroo["total_causado"]+$registroo["total_pasivos"]-$registroo["total_retencion"];	$clasif_orden=$registroo["clasif_orden"]; $tipo_orden=$registroo["tipo_orden"]; $total_pasivos=$registroo["total_pasivos"]; $monto_am_ant=$registroo["monto_am_ant"];
			if($clasif_orden=="P"){ $Busca_B=False; $aa=0;
            $sqlp="SELECT tipo_pago,cod_banco,referencia_caus,tipo_causado,referencia_comp,tipo_compromiso,cod_presup,fuente_financ,cod_contable,monto FROM CODIGOS_PAGOS Where (referencia_pago='$referencia') And (referencia_caus='$nro_orden') And (cod_banco='$cod_banco') And (tipo_pago='$tipo_pago')";   $resp=pg_query($sqlp);
            while($registrop=pg_fetch_array($resp)){ $referencia_comp=$registrop["referencia_comp"]; $cod_presup=$registrop["cod_presup"]; $cod_contable=$registrop["cod_contable"];
	  		  $cod_partida=substr($cod_presup,$c,$p); $monto=$registrop["monto"]; $fuente_financ=$registrop["fuente_financ"]; $pmonto=$registrop["monto"];		
		      $sqlr="SELECT pag004.nro_orden_ret,pag004.aux_orden,pag004.cod_presup_ret,pag004.monto_retencion FROM pag004 Where (nro_orden_ret='$nro_orden') and (tipo_caus_ret='$tipo_causado') and (cod_presup_ret='$cod_presup') and (fuente_fin_ret='$fuente_financ') and (ref_comp_ret='$referencia_comp')";   $resr=pg_query($sqlr);
              while($registror=pg_fetch_array($resr)){  $monto_retencion=$registror["monto_retencion"];   //$monto=$monto-$monto_retencion;
				   if($pmonto>0){$monto=$monto-$monto_retencion;}else{$monto=$monto+$monto_retencion;} 
			  } 
			  if(($aa==0)and($monto_am_ant>0)and($monto>$monto_am_ant)){ $monto=$monto-$monto_am_ant; $aa=1; }
			  $ssqlg="SELECT ACTUALIZA_BAN021(1,'$mes','$cod_banco','$referencia','$tipo_mov','$ced_rif','$fecha',$monto_mov_libro,'$cod_presup','$fuente_financ','$cod_partida','$cod_contable',$monto,'','',0,0,'$descripcion')";
	          $resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>"; }			                       
			}	
			}
			if($total_pasivos>0){
            $sqlp="SELECT cod_cuenta,monto_pasivo FROM pag020 Where (monto_pasivo>0) and (nro_orden='$nro_orden' ) and (tipo_causado='$tipo_causado')";$resp=pg_query($sqlp);
		    while($registrop=pg_fetch_array($resp)){ $cod_cuenta=$registrop["cod_cuenta"]; $monto=$registrop["monto_pasivo"]; $cod_partida=""; $cod_presup=""; $fuente_financ="00";
		  	  //echo $sqlp,"<br>";
			  If($tipo_mov=="ANU") {$monto=$monto*-1; }		
			  If (substr($cod_cuenta, 0, 7)=="1-01-02"){$cod_partida="401-01-01-00"; }
			  If (substr($cod_cuenta, 0, 10)=="2-01-05-02"){$cod_partida="401-01-01-00"; } 
			  If (substr($cod_cuenta, 0, 10)=="2-01-01-04"){$cod_partida= "401-01-01-00"; }  // presgunta retenciones laborales			  
			  //Modificado el 17-10-2013
			  If (substr($cod_cuenta, 0, 7)=="1-01-02"){$cod_partida=$cod_cuenta; }
			  If (substr($cod_cuenta, 0, 10)=="2-01-05-02"){$cod_partida=$cod_cuenta; } 
			  If (substr($cod_cuenta, 0, 10)=="2-01-01-04"){$cod_partida= $cod_cuenta; }			  
			  If ($cod_cuenta=="2-03-01-02-01"){$cod_partida="407"; } 
			  If ($cod_cuenta=="2-03-02-01-01"){$cod_partida="500"; } 
			  If ($cod_cuenta=="1-02-05-03-01"){$cod_partida="403"; }			  
			  $ssqlg="SELECT ACTUALIZA_BAN021(1,'$mes','$cod_banco','$referencia','$tipo_mov','$ced_rif','$fecha',$monto_mov_libro,'$cod_presup','$fuente_financ','$cod_partida','$cod_cuenta',$monto,'','',0,0,'$descripcion')";
			  $resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>"; }
		    } } 
            if(($Busca_B==True)and($afecta_presu=="N")){ $cod_partida="500"; $monto=$monto_mov_libro; $cod_presup=""; $fuente_financ="00";
			  $monto_orden=$monto_orden-$monto_am_ant; 
			  if($monto>$monto_orden){ $monto=$monto_orden; } If($tipo_mov=="ANU") {$monto=$monto*-1; }	
			  if($cod_contable_o=="2-01-01-07"){$cod_partida="500";} 			  
			  if($tipo_orden=="0003"){$cod_partida="2-01-01-04-04-017";}      // iva
			  if($tipo_orden=="0004"){$cod_partida="2-01-01-04-04-002";}      // islr
			  if($tipo_orden=="0006"){$cod_partida="2-01-01-04-04-005";}      // fiel cumplimiento
			  if($tipo_orden=="0007"){$cod_partida="2-01-01-04-04-021";} // uno por mil
			  //if($tipo_orden=="0002"){$cod_partida="401";}    if($tipo_orden=="0017"){$cod_partida="402";} 
			  //if($tipo_orden=="0007"){$cod_partida="403-15-02-00";}  // if($tipo_orden=="0004"){$cod_partida="403-15-04-00";}
              $ssqlg="SELECT ACTUALIZA_BAN021(1,'$mes','$cod_banco','$referencia','$tipo_mov','$ced_rif','$fecha',$monto_mov_libro,'$cod_presup','$fuente_financ','$cod_partida','$cod_contable_o',$monto,'','',0,0,'$descripcion')";
			  $resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>"; }
			}			
        }
     }	  
   }        
}
}
pg_close();?>
<!-- -->
<iframe src="Det_inc_gasto_flujo.php?criterio=<?echo $mes?>" width="870" height="360" scrolling="auto" frameborder="1"></iframe>
