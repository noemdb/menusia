<?include ("../class/conect.php");  include ("../class/funciones.php"); $mes=$_GET["mes"]; $ano=$_GET["ano"]; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$fecha_d="01-".$mes."-".$ano; $fecha_h=colocar_udiames($fecha_d); $fecha_1=formato_aaaammdd($fecha_d);  $fecha_2=formato_aaaammdd($fecha_h);
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
$sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
$long_c=strlen($formato_presup); $c=strlen($formato_categoria)+1; $p=strlen($formato_partida); $busca_b=False;   $busca_p=False;  $busca_c=False;   $busca_r=False;    $busca_j=False;   $busca_g=False;
$ssql = "SELECT * From ban016 where (periodo='$mes')"; $resultado=pg_query($ssql);  $filas=pg_num_rows($resultado);if ($filas>0){echo "Flujo de Caja para este periodo Ya Existe","<br>"; }
else{ $aperiodo=$mes-1; if($aperiodo<=9){$aperiodo="0".$aperiodo;}  $contador=0; $contadore=0;	
  $ssql="SELECT * From ban017 where (periodo='$mes')"; $resultado=pg_query($ssql);  $filas=pg_num_rows($resultado);
  if ($filas>0){ $ssqlg="SELECT ACTUALIZA_BAN017(4,'$mes','','','o','','','','','','',0,0)"; $resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";   } }
  $sql="SELECT ban015.cod_movimiento,ban015.cod_grupo,ban015.operacion,ban015.tipo_operacion,ban015.modulo,ban015.tipo_mov,ban015.cod_contable,ban015.descripcion,ban015.signo,ban015.monto,ban015.acumulado,ban015.cod_titulo,ban017.acumulado as aacumulado,ban014.denominacion,ban018.denominacion_titulo FROM ban015 LEFT JOIN ban017 ON ((ban017.cod_movimiento=ban015.cod_movimiento) and (ban017.periodo='$aperiodo')) LEFT JOIN ban014 ON (ban015.cod_grupo=ban014.codigo_grupo) LEFT JOIN ban018 ON (ban015.cod_titulo=ban018.codigo_titulo) WHERE (activo='SI') Order by ban015.cod_movimiento";   $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){ $cod_movimiento=$registro["cod_movimiento"]; $modulo=$registro["modulo"];  $tipo_operacion=$registro["tipo_operacion"];  $operacion=$registro["operacion"];     
    $tipo_mov=$registro["tipo_mov"]; $cod_contable=$registro["cod_contable"]; $descripcion=$registro["descripcion"]; $signo=$registro["signo"]; $cod_grupo=$registro["cod_grupo"];
	$monto=$registro["monto"]; $acumulado=$registro["acumulado"]; $aacumulado=$registro["aacumulado"]; $top=substr($tipo_operacion,0,1); $op=substr($operacion,0,1); $mod=substr($modulo,0,1);
	If($modulo=="BANCOS NO AFECT"){$mod="N";} If($modulo=="RETENCION CANC"){$mod="A";}  If($modulo=="RETENCION LIB"){$mod="L";}  If($modulo=="AJUSTE PRESUP"){$mod="J";}
	if($top=="A"){ 
	   If (($modulo=="BANCOS NO AFECTA") and ($to=="A") and (($tipo_mov=="CHQ") Or ($tipo_mov== "NDB") Or ($tipo_mov=="ANU") Or ($tipo_mov=="AND"))) { $busca_b=True;  }
	   If ($modulo=="BANCOS") { $busca_b=True;}   If ($modulo=="CONTABILIDAD") { $busca_c=True;}  If ($modulo=="GASTO FLUJO") { $busca_g=True;}
	   If (($modulo=="PRESUPUESTO")and($tipo_mov<>"000")) { $busca_b=True;  } If (($modulo=="PRESUPUESTO")and($tipo_mov=="000")) { $busca_p=True;  }
	   If ($modulo=="RETENCIONES") { $busca_r=True;}  If ($modulo=="AJUSTE PRESUP") { $busca_j=True;} 
	   If ($op<>"S"){ if($aperiodo<>"00"){$acumulado=$acumulado+$aacumulado;} }
	   else{ $macumulado=0; $mmonto=0;
	      $sqls="SELECT acumulado FROM BAN016 WHERE (periodo='01') and (operacion='S') and (status='M')"; $ress=pg_query($sqls);
		  while($regs=pg_fetch_array($ress)){ $macumulado=$macumulado+$regs["acumulado"]; }		  
		  $sqls="SELECT monto FROM BAN016 WHERE (periodo='$aperiodo') and (operacion='F') and (status='M')"; $ress=pg_query($sqls);
		  while($regs=pg_fetch_array($ress)){ $mmonto=$mmonto+$regs["monto"]; }		  
		  $acumulado=$macumulado; $monto=$mmonto;
	   }
	}	
	//periodo,cod_movimiento,descripcion,cod_grupo,operacion,tipo_operacion,modulo,tipo_mov,signo,cod_contable,monto,acumulado
	$ssqlg="SELECT ACTUALIZA_BAN017(1,'$mes','$cod_movimiento','$descripcion','$cod_grupo','$op','$top','$mod','$tipo_mov','$signo','$cod_contable',$monto,$acumulado)";
	$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
  }
  //$busca_b=False;   $busca_p=False;  $busca_c=False;   $busca_r=False;    $busca_j=False;  
  if($busca_b==True){
    $sql="SELECT ban004.cod_banco,ban004.referencia,ban004.referenciaa,ban004.tipo_mov_libro,ban004.monto_mov_libro,ban004.fecha_mov_libro,ban004.cod_bancoa,ban004.anulado,ban006.nro_orden_pago,ban006.chq_o_f_c,ban006.num_cheque,ban006.tipo_pago  FROM ban004 Left Join ban006 ON ((ban006.cod_banco=ban004.cod_banco) and (ban006.num_cheque=ban004.referencia)) where (ban004.fecha_mov_libro>='$fecha_1') and (ban004.fecha_mov_libro<='$fecha_2') order by ban004.tipo_mov_libro,ban004.referencia,ban004.fecha_mov_libro,ban004.cod_banco,ban004.referencia"; $res=pg_query($sql);
    //echo $sql,"<br>";
	while($registro=pg_fetch_array($res)){ $cod_banco=$registro["cod_banco"]; $referencia=$registro["referencia"];  $tipo_mov=$registro["tipo_mov_libro"];  $fecha=$registro["fecha_mov_libro"]; $monto_mov_libro=$registro["monto_mov_libro"]; $nro_orden_pago=$registro["nro_orden_pago"]; $cod_bancoa=$registro["cod_bancoa"]; $anulado=$registro["anulado"];
       $sqlm="select cod_movimiento,cod_contable,tipo_mov,monto,acumulado  from ban017 where (ban017.periodo='$mes') and modulo='B' and tipo_operacion='A' and tipo_mov='$tipo_mov'";  $resm=pg_query($sqlm); 
       while($regm=pg_fetch_array($resm)){  $cod_contable=$regm["cod_contable"]; $cod_movimiento=$regm["cod_movimiento"]; $monto=$regm["monto"]; $acumulado=$regm["acumulado"]; $monto_asiento=0;
	      if($cod_contable=="000000000000000000"){ $monto=$monto+$monto_mov_libro; $acumulado=$acumulado+$monto_mov_libro; }
		  else{ $mreferencia=$referencia; $tipo_comp="B".$cod_banco; If(($tipo_mov=="ANC")or($tipo_mov=="AND")or($tipo_mov=="ANU")){ $mreferencia="A".substr($referencia,1,7); }  
		    $lc=strlen($cod_contable);
			$sqlc="SELECT cod_cuenta,monto_asiento from con003 where text(fecha)='$fecha' and referencia='$mreferencia' and tipo_comp='$tipo_comp' and substring(cod_cuenta,1,$lc)='$cod_contable'";
		    //$resc=pg_query($sqlc);  $filas=pg_num_rows($resc); if ($filas>0){ $regc=pg_fetch_array($resc); $monto_asiento=$regc["monto_asiento"];  $monto=$monto+$monto_asiento; $acumulado=$acumulado+$monto_asiento;}
		    $resc=pg_query($sqlc);  while($regc=pg_fetch_array($resc)){$monto_asiento=$regc["monto_asiento"];  $monto=$monto+$monto_asiento; $acumulado=$acumulado+$monto_asiento;}
		  }
		  $ssqlg="SELECT ACTUALIZA_BAN017(2,'$mes','$cod_movimiento','','','','A','B','$tipo_mov','','$cod_contable',$monto,$acumulado)";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>"; echo $sqlm." ".$ssqlg,"<br>";  }
	      //if($cod_movimiento=="559"){ $contador=$contador+1; echo $cod_banco." ".$referencia." ".$tipo_mov." ".$fecha." ".$cod_contable." ".$monto_mov_libro." ".$monto_asiento." ".$contador,"<br>";}
	   
	   }
	   //FALTA
	   $sqlm="select cod_movimiento,cod_contable,monto,acumulado  from ban017 where (ban017.periodo='$mes') and modulo='P' and tipo_operacion='A' and tipo_mov='$tipo_mov'";  $resm=pg_query($sqlm);  $filas=pg_num_rows($resm);
       while($regm=pg_fetch_array($resm)){
	   }	
          
	   $sqlm="select cod_movimiento,cod_contable,monto,acumulado  from ban017 where (ban017.periodo='$mes') and modulo='N' and tipo_operacion='A' and tipo_mov='$tipo_mov' and tipo_mov='CHQ'";  $resm=pg_query($sqlm);  $filas=pg_num_rows($resm);
       while($regm=pg_fetch_array($resm)){ $ord_f=False; $cod_movimiento=$regm["cod_movimiento"]; $cod_contable=$regm["cod_contable"]; $monto=$regm["monto"]; $acumulado=$regm["acumulado"];
	     If(($nro_orden_pago<>"")and($ord_f==True)){ }
		 If(($nro_orden_pago=="")and($ord_f==False)){ 
		   if($cod_contable=="000000000000000000"){ $monto=$monto+$monto_mov_libro; $acumulado=$acumulado+$monto_mov_libro;}
		   else{ $mreferencia=$referencia; $tipo_comp="B".$cod_banco; If(($tipo_mov=="ANC")or($tipo_mov=="AND")or($tipo_mov=="ANU")){ $mreferencia="A".substr($referencia,1,7); }  
		      $sqlc="SELECT cod_cuenta,monto_asiento from con003 where text(fecha)='$fecha' and referencia='$mreferencia' and tipo_comp='$tipo_comp' and cod_cuenta='$cod_contable'";
		      $resc=pg_query($sqlc);  $filas=pg_num_rows($resc); if ($filas>0){ $regc=pg_fetch_array($resc); $monto=$monto+$monto_mov_libro; $acumulado=$acumulado+$monto_mov_libro; $contadore=$contadore+1;	   }
		   }
		 }
		 $ssqlg="SELECT ACTUALIZA_BAN017(2,'$mes','$cod_movimiento','','','','A','N','$tipo_mov','','$cod_contable',$monto,$acumulado)";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
	     //if($cod_movimiento=="559"){ $contador=$contador+1; echo $cod_banco." ".$referencia." ".$tipo_mov." ".$fecha." ".$cod_contable." ".$monto_mov_libro." ".$monto_asiento." ".$contador." ".$monto." ".$contadore,"<br>";}
	   }
	   $sqlm="select cod_movimiento,cod_contable,monto,acumulado  from ban017 where (ban017.periodo='$mes') and modulo='N' and tipo_operacion='A' and tipo_mov='$tipo_mov' and tipo_mov='ANU'";  $resm=pg_query($sqlm);  $filas=pg_num_rows($resm);
       while($regm=pg_fetch_array($resm)){ $ord_f=False; $cod_movimiento=$regm["cod_movimiento"]; $cod_contable=$regm["cod_contable"];$monto=$regm["monto"]; $acumulado=$regm["acumulado"];
	     If(($nro_orden_pago<>"")and($ord_f==True)){ }
		 If(($nro_orden_pago=="")and($ord_f==False)){ 
		   if($cod_contable=="000000000000000000"){ $monto=$monto+$monto_mov_libro; $acumulado=$acumulado+$monto_mov_libro;}
		   else{ $mreferencia=$referencia; $tipo_comp="B".$cod_banco; If(($tipo_mov=="ANC")or($tipo_mov=="AND")or($tipo_mov=="ANU")){ $mreferencia="A".substr($referencia,1,7); }  
		      $sqlc="SELECT cod_cuenta,monto_asiento from con003 where text(fecha)='$fecha' and referencia='$mreferencia' and tipo_comp='$tipo_comp' and cod_cuenta='$cod_contable'";
		      $resc=pg_query($sqlc);  $filas=pg_num_rows($resc); if ($filas>0){ $regc=pg_fetch_array($resc); $monto=$monto+$monto_mov_libro; $acumulado=$acumulado+$monto_mov_libro;}
		   }
		 }
		 $ssqlg="SELECT ACTUALIZA_BAN017(2,'$mes','$cod_movimiento','','','','A','N','$tipo_mov','','$cod_contable',$monto,$acumulado)";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
	   }
	   $coda=substr($cod_bancoa,0,1);	 
	   if(($coda<>'D')and ($coda<>'A')){
	   $sqlm="select cod_movimiento,cod_contable,monto,acumulado  from ban017 where (ban017.periodo='$mes') and modulo='N' and tipo_operacion='A' and tipo_mov='$tipo_mov' and tipo_mov='NDB'";  $resm=pg_query($sqlm);  $filas=pg_num_rows($resm);
       while($regm=pg_fetch_array($resm)){ $ord_f=False; $cod_movimiento=$regm["cod_movimiento"]; $cod_contable=$regm["cod_contable"]; $monto=$regm["monto"]; $acumulado=$regm["acumulado"];   $tipo_comp="B".$cod_banco;  
		  if($coda=='P'){
		    $sqlo="SELECT nro_orden,fecha,total_causado,total_retencion,cod_contable_o From pag001 Where (status='I') and ((anulado='N') or ((anulado='S') and (fecha_anulado>'$fecha_2'))) and (afecta_presu='N') and (tipo_pago='NDB') and (cod_banco='$cod_banco') and (nro_cheque='$referencia')"; 
            //if($referencia=='00014502'){echo $anulado." ".$sqlo,"<br>";}
			if($anulado=="S"){ $sqlt="select nro_orden from pag007 where (pag007.cod_banco='$cod_banco') And (pag007.nro_Cheque='$referencia') and (pag007.tipo_pago='NDB')";
			  //echo $sqlt,"<br>";
			  $reso=pg_query($sqlt); $filas=pg_num_rows($reso); if ($filas>0){$rego=pg_fetch_array($reso); $nro_orden=$rego["nro_orden"];
			  $sqlo="SELECT nro_orden,tipo_causado,tipo_orden,fecha,total_causado,cod_contable_o,afecta_presu,total_retencion,total_pasivos,monto_am_ant from pag001 Where (nro_orden='$nro_orden')"; }
			}
			$reso=pg_query($sqlo);  $filas=pg_num_rows($reso);
			while($rego=pg_fetch_array($reso)){ $monto_ord=$rego["total_causado"]-$rego["total_retencion"];
			   if($cod_contable=="000000000000000000"){ $monto=$monto+$monto_ord; $acumulado=$acumulado+$monto_ord;}
			   else{ $sqlc="SELECT cod_cuenta,monto_asiento from con003 where text(fecha)='$fecha' and referencia='$referencia' and tipo_comp='$tipo_comp' and cod_cuenta='$cod_contable'";
				  $resc=pg_query($sqlc);  $filas=pg_num_rows($resc); if ($filas>0){ $regc=pg_fetch_array($resc); $monto=$monto+$monto_ord; $acumulado=$acumulado+$monto_ord;}
			   }
            }  
		  }else{		    
		    if($cod_contable=="000000000000000000"){ $monto=$monto+$monto_mov_libro; $acumulado=$acumulado+$monto_mov_libro;}
		    else{ $mreferencia="A".substr($referencia,1,7); $sqlc="SELECT cod_cuenta,monto_asiento from con003 where text(fecha)='$fecha' and referencia='$referencia' and tipo_comp='$tipo_comp' and cod_cuenta='$cod_contable'";
		      $resc=pg_query($sqlc);  $filas=pg_num_rows($resc);
			  //if($referencia=='00406335'){ echo $sqlc." ".$cod_contable." ".$filas,"<br>"; }
			  if ($filas>0){ $regc=pg_fetch_array($resc); $monto=$monto+$monto_mov_libro; $acumulado=$acumulado+$monto_mov_libro;}			  
			  //if($cod_movimiento=="410"){ echo $cod_banco." ".$referencia." ".$tipo_mov." ".$fecha." ".$cod_contable." ".$monto_mov_libro." ".$monto_asiento,"<br>";}	   
		    }		  
		  }
		  $ssqlg="SELECT ACTUALIZA_BAN017(2,'$mes','$cod_movimiento','','','','A','N','$tipo_mov','','$cod_contable',$monto,$acumulado)";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }	     
	     //if($cod_movimiento=="410"){ echo $cod_banco." ".$referencia." ".$tipo_mov." ".$fecha." ".$cod_contable." ".$monto_mov_libro." ".$monto_asiento,"<br>";}
	  } 	   
	   $sqlm="select cod_movimiento,cod_contable,monto,acumulado  from ban017 where (ban017.periodo='$mes') and modulo='N' and tipo_operacion='A' and tipo_mov='$tipo_mov' and tipo_mov='AND'";  $resm=pg_query($sqlm);  $filas=pg_num_rows($resm);
       while($regm=pg_fetch_array($resm)){ $ord_f=False; $cod_movimiento=$regm["cod_movimiento"]; $cod_contable=$regm["cod_contable"]; $monto=$regm["monto"]; $acumulado=$regm["acumulado"]; $tipo_comp="B".$cod_banco;   $mreferencia="A".substr($referencia,1,7);
	      if($coda=='P'){
		    $sqlo="SELECT pag001.nro_orden,pag001.fecha,pag001.total_causado,pag001.total_retencion From pag001, pag007 Where (pag001.nro_orden=pag007.nro_orden) And (pag001.tipo_causado=pag007.tipo_causado) and (pag007.anulado='S') And (pag001.afecta_Presu='N') And  (pag007.tipo_pago='NDB') And (pag007.Cod_Banco='$cod_banco') And (pag007.Nro_Cheque='$referencia')"; $reso=pg_query($sqlo);  $filas=pg_num_rows($reso);
            while($rego=pg_fetch_array($reso)){ $monto_ord=$rego["total_causado"]-$rego["total_retencion"];
			   if($cod_contable=="000000000000000000"){ $monto=$monto+$monto_ord; $acumulado=$acumulado+$monto_ord;}
			   else{ $sqlc="SELECT cod_cuenta,monto_asiento from con003 where text(fecha)='$fecha' and referencia='$mreferencia' and tipo_comp='$tipo_comp' and cod_cuenta='$cod_contable'";
				  $resc=pg_query($sqlc);  $filas=pg_num_rows($resc); if ($filas>0){ $regc=pg_fetch_array($resc); $monto=$monto+$monto_ord; $acumulado=$acumulado+$monto_ord;}
			   }
            }                           
		  }else{
		    if($cod_contable=="000000000000000000"){ $monto=$monto+$monto_mov_libro; $acumulado=$acumulado+$monto_mov_libro;}
		    else{ $sqlc="SELECT cod_cuenta,monto_asiento from con003 where text(fecha)='$fecha' and referencia='$mreferencia' and tipo_comp='$tipo_comp' and cod_cuenta='$cod_contable'";
		      $resc=pg_query($sqlc);  $filas=pg_num_rows($resc); if ($filas>0){ $regc=pg_fetch_array($resc); $monto=$monto+$monto_mov_libro; $acumulado=$acumulado+$monto_mov_libro;}
		    }		  
		  }
		  $ssqlg="SELECT ACTUALIZA_BAN017(2,'$mes','$cod_movimiento','','','','A','N','$tipo_mov','','$cod_contable',$monto,$acumulado)";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }	     
	   }
	   }
    }	
  }
  if($busca_c==True){
    $sql="SELECT referencia,fecha,tipo_asiento,monto_asiento,cod_cuenta  FROM con003  where (fecha>='$fecha_1') and (fecha<='$fecha_2') order by fecha,referencia"; $res=pg_query($sql);
    while($registro=pg_fetch_array($res)){  $cod_cuenta=$registro["cod_cuenta"]; $referencia=$registro["referencia"]; $tipo_asiento=$registro["tipo_asiento"]; $fecha=$registro["fecha"]; $monto_asiento=$registro["monto_asiento"]; 
      $sqlm="select cod_movimiento,cod_contable,monto,acumulado  from ban017 where (ban017.periodo='$mes') and (modulo='C') and (tipo_operacion='A') and (cod_contable='$cod_cuenta' or cod_contable='000000000000000000') and (tipo_mov='$tipo_asiento' or tipo_mov='000' )";  $resm=pg_query($sqlm);  $filas=pg_num_rows($resm);
      while($regm=pg_fetch_array($resm)){  $cod_movimiento=$regm["cod_movimiento"]; $cod_contable=$regm["cod_contable"]; $monto=$regm["monto"]; $acumulado=$regm["acumulado"];  $monto=$monto+$monto_asiento; $acumulado=$acumulado+$monto_asiento;
	     $ssqlg="SELECT ACTUALIZA_BAN017(2,'$mes','$cod_movimiento','','','','A','N','$tipo_mov','','$cod_contable',$monto,$acumulado)";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
	  }	
	}
  }
  if($busca_g==True){  
      //echo $cod_movimiento." ".$modulo." ".$busca_g,"<br>"; 
    $sql="SELECT fecha_mov_libro,cod_presup,fuente_financ,cod_partida,cod_contable,monto_codigo from ban021 where (fecha_mov_libro>='$fecha_1') and (fecha_mov_libro<='$fecha_2') order by cod_partida,fecha_mov_libro"; $res=pg_query($sql);
    while($registro=pg_fetch_array($res)){  $cod_partida=$registro["cod_partida"]; $monto_codigo=$registro["monto_codigo"]; $cod_contable=$registro["cod_contable"];
	  $pl=substr($cod_partida,0,1);
	  if($pl=="4"){$cod_c=substr($cod_partida,0,1).'-'.substr($cod_partida,1,2); } else{ $cod_c=$cod_partida; }
	  $sqlm="select cod_movimiento,cod_contable,monto,acumulado from ban017 where (ban017.periodo='$mes') and (modulo='G') and (tipo_operacion='A') and (cod_contable='$cod_c') and (tipo_mov='000')";  $resm=pg_query($sqlm);  $filas=pg_num_rows($resm);
      //echo $sqlm,"<br>"; 
	  while($regm=pg_fetch_array($resm)){ $cod_movimiento=$regm["cod_movimiento"]; $cod_contable=$regm["cod_contable"]; $monto=$regm["monto"]; $acumulado=$regm["acumulado"]; $monto=$monto+$monto_codigo; $acumulado=$acumulado+$monto_codigo; 
	     $ssqlg="SELECT ACTUALIZA_BAN017(2,'$mes','$cod_movimiento','','','','A','N','$tipo_mov','','$cod_contable',$monto,$acumulado)";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
	  }	
    }         
  }  
 $sql="Delete from ban017 where monto=0 and acumulado=0 and (periodo='$mes')"; $resultadog=pg_exec($conn,$sql); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
 $tsaldo=0; $tsaldoa=0; $num_linea=0;
 //periodo,linea,consecutivo,descripcion,monto,acumulado,operacion,status
 $sql="select ban017.cod_movimiento,ban017.descripcion,ban017.cod_grupo,ban017.operacion,ban017.tipo_operacion,ban017.signo,ban017.monto,ban017.acumulado,ban014.denominacion from ban017 left join ban014 on (ban014.codigo_grupo=ban017.cod_grupo) where (ban017.periodo='$mes') and (ban017.operacion='S') order by ban017.cod_movimiento"; $res=pg_query($sql);
 while($registro=pg_fetch_array($res)){  $cod_movimiento=$registro["cod_movimiento"]; $monto=$registro["monto"]; $acumulado=$registro["acumulado"]; $denominacion=$registro["denominacion"]; $descripcion=$registro["descripcion"];
   $cod_grupo=$registro["cod_grupo"]; $operacion=$registro["operacion"]; $signo=$registro["signo"]; if($signo=="NEGATIVO"){ $monto=$monto*-1; $acumulado=$acumulado*-1; }
   $sqlc="SELECT linea,descripcion,monto,acumulado from ban016 where (ban016.periodo='$mes') and (ban016.operacion='$operacion') and (ban016.consecutivo='$cod_grupo')";
   $resc=pg_query($sqlc);  $filas=pg_num_rows($resc); if ($filas>0){   $regc=pg_fetch_array($resc); $mdescrip=$regc["descripcion"];  $linea=$regc["linea"];
     $montom=$monto+$regc["monto"]; $acumuladom=$acumulado+$regc["acumulado"]; if($denominacion<>""){ $mdescrip=$denominacion;}
     $ssqlg="SELECT ACTUALIZA_BAN016(2,'$mes','$linea','$cod_grupo','$mdescrip',$montom,$acumuladom,'$operacion','M')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
   }else{  $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; if($denominacion<>""){ $mdescrip=$denominacion;}else{$mdescrip=$descripcion;}
     $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','$cod_grupo','$mdescrip',$monto,$acumulado,'$operacion','M')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
   }
   $tsaldo=$tsaldo+$monto; $tsaldoa=$tsaldoa+$acumulado;
 }
 $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; $mdescrip=""; $monto=0;$acumulado=0; $operacion="S";
 $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','000','$mdescrip',$monto,$acumulado,'$operacion','B')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
 $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; $mdescrip="INGRESOS DEL PERIODO"; $monto=0;$acumulado=0; $operacion="I";
 $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','000','$mdescrip',$monto,$acumulado,'$operacion','S')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
 $prev_titulo='00'; $tingreso=0; $tingresoa=0; $operacion="I";
 $sql="select ban017.cod_movimiento,ban017.descripcion,ban017.cod_grupo,ban017.operacion,ban017.tipo_operacion,ban017.signo,ban017.monto,ban017.acumulado,ban014.denominacion,ban015.cod_titulo,ban018.denominacion_titulo from (ban017 left join ban014 on (ban014.codigo_grupo=ban017.cod_grupo)), (ban015 left join ban018 on (ban018.codigo_titulo=ban015.cod_titulo)) where (ban017.cod_movimiento=ban015.cod_movimiento) and (ban017.periodo='$mes') and (ban017.operacion='$operacion') order by ban017.cod_movimiento"; $res=pg_query($sql);
 while($registro=pg_fetch_array($res)){  $cod_movimiento=$registro["cod_movimiento"]; $monto=$registro["monto"]; $acumulado=$registro["acumulado"]; $denominacion=$registro["denominacion"]; $descripcion=$registro["descripcion"]; $cod_titulo=$registro["cod_titulo"]; $den_titulo=$registro["denominacion_titulo"];
   $cod_grupo=$registro["cod_grupo"]; $operacion=$registro["operacion"]; $signo=$registro["signo"]; if($signo=="NEGATIVO"){ $monto=$monto*-1; $acumulado=$acumulado*-1; }
   $sqlc="SELECT linea,descripcion,monto,acumulado from ban016 where (ban016.periodo='$mes') and (ban016.operacion='$operacion') and (ban016.consecutivo='$cod_grupo')";
   $resc=pg_query($sqlc);  $filas=pg_num_rows($resc); if ($filas>0){   $regc=pg_fetch_array($resc); $mdescrip=$regc["descripcion"];  $linea=$regc["linea"];
     $montom=$monto+$regc["monto"]; $acumuladom=$acumulado+$regc["acumulado"]; if($denominacion<>""){ $mdescrip=$denominacion;}
     $ssqlg="SELECT ACTUALIZA_BAN016(2,'$mes','$linea','$cod_grupo','$mdescrip',$montom,$acumuladom,'$operacion','M')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
   }else{  
     if($prev_titulo<>$cod_titulo){ $prev_titulo=$cod_titulo;  $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; $mdescrip=$den_titulo;  $operacion="I";
       $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','000','$mdescrip',0,0,'$operacion','S')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  } }
	 $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; if($denominacion<>""){ $mdescrip=$denominacion;}else{$mdescrip=$descripcion;}
     $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','$cod_grupo','$mdescrip',$monto,$acumulado,'$operacion','M')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
   }
   $tingreso=$tingreso+$monto; $tingresoa=$tingresoa+$acumulado;
 }  
 $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; $mdescrip="TOTAL INGRESOS"; $monto=$tingreso;$acumulado=$tingresoa; $operacion="I";
 $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','000','$mdescrip',$monto,$acumulado,'$operacion','T')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
 $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; $mdescrip=""; $monto=0;$acumulado=0; $operacion="I";
 $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','000','$mdescrip',$monto,$acumulado,'$operacion','B')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
 $tingreso=$tingreso+$tsaldo; $tingresoa=$tingresoa+$tsaldoa;
 $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; $mdescrip="SALDO INICIAL + INGRESOS"; $monto=$tingreso;$acumulado=$tingresoa; $operacion="I";
 $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','000','$mdescrip',$monto,$acumulado,'$operacion','G')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
 $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; $mdescrip=""; $monto=0;$acumulado=0; $operacion="I";
 $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','000','$mdescrip',$monto,$acumulado,'$operacion','B')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
 $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; $mdescrip="EGRESOS DEL PERIODO"; $monto=0;$acumulado=0; $operacion="E";
 $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','000','$mdescrip',$monto,$acumulado,'$operacion','S')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
 $tegreso=0; $tegresoa=0; $operacion="E";
 $sql="select ban017.cod_movimiento,ban017.descripcion,ban017.cod_grupo,ban017.operacion,ban017.tipo_operacion,ban017.signo,ban017.monto,ban017.acumulado,ban014.denominacion,ban015.cod_titulo,ban018.denominacion_titulo from (ban017 left join ban014 on (ban014.codigo_grupo=ban017.cod_grupo)), (ban015 left join ban018 on (ban018.codigo_titulo=ban015.cod_titulo)) where (ban017.cod_movimiento=ban015.cod_movimiento) and (ban017.periodo='$mes') and (ban017.operacion='$operacion') order by ban017.cod_grupo,ban017.cod_movimiento"; $res=pg_query($sql);
 while($registro=pg_fetch_array($res)){  $cod_movimiento=$registro["cod_movimiento"]; $monto=$registro["monto"]; $acumulado=$registro["acumulado"]; $denominacion=$registro["denominacion"]; $descripcion=$registro["descripcion"]; $cod_titulo=$registro["cod_titulo"]; $den_titulo=$registro["denominacion_titulo"];
   $cod_grupo=$registro["cod_grupo"]; $operacion=$registro["operacion"]; $signo=$registro["signo"]; if($signo=="NEGATIVO"){ $monto=$monto*-1; $acumulado=$acumulado*-1; }
   $sqlc="SELECT linea,descripcion,monto,acumulado from ban016 where (ban016.periodo='$mes') and (ban016.operacion='$operacion') and (ban016.consecutivo='$cod_grupo')";
   //echo $sqlc,"<br>";
   $resc=pg_query($sqlc);  $filas=pg_num_rows($resc); if ($filas>0){   $regc=pg_fetch_array($resc); $mdescrip=$regc["descripcion"];  $linea=$regc["linea"];
     $montom=$monto+$regc["monto"]; $acumuladom=$acumulado+$regc["acumulado"]; if($denominacion<>""){ $mdescrip=$denominacion;}
     $ssqlg="SELECT ACTUALIZA_BAN016(2,'$mes','$linea','$cod_grupo','$mdescrip',$montom,$acumuladom,'$operacion','M')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
   }else{  
	 $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; if($denominacion<>""){ $mdescrip=$denominacion;}else{$mdescrip=$descripcion;}
     $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','$cod_grupo','$mdescrip',$monto,$acumulado,'$operacion','M')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
   }
   $tegreso=$tegreso+$monto; $tegresoa=$tegresoa+$acumulado;
 } 
 $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; $mdescrip="TOTAL EGRESOS"; $monto=$tegreso;$acumulado=$tegresoa; $operacion="E";
 $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','000','$mdescrip',$monto,$acumulado,'$operacion','T')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
 $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; $mdescrip=""; $monto=0;$acumulado=0; 
 $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','000','$mdescrip',$monto,$acumulado,'$operacion','B')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
 $tegreso=$tingreso-$tegreso; $tegresoa=$tingresoa-$tegresoa;
 $num_linea=$num_linea+1; $len=strlen($num_linea); $linea=substr("000",0,3-$len).$num_linea; $mdescrip="SALDO FINAL DE CAJA"; $monto=$tegreso;$acumulado=$tegresoa; $operacion="F";
 $ssqlg="SELECT ACTUALIZA_BAN016(1,'$mes','$linea','000','$mdescrip',$monto,$acumulado,'$operacion','M')";$resultadog=pg_exec($conn,$ssqlg); $errorg=pg_errormessage($conn);  $error=substr($errorg, 0, 100); if(!$resultadog){ echo $error,"<br>";  }
}
pg_close();
?>
<!-- -->
<iframe src="Det_inc_flujo_caja.php?criterio=<?echo $mes?>" width="870" height="360" scrolling="auto" frameborder="1"></iframe>
