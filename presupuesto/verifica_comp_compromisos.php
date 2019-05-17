<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("Ver_dispon.php"); include ("../class/configura.inc");
  $dbnombre=$dbname;
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  //$dbnombre="CPDVSA";
  //$conn=pg_connect("host=".$host." port=".$port." password=super user=usia dbname=$dbnombre");
  $codigo_mov="VPRE006";
  $resg=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn);
  
  $sql="select * from pre006 where tipo_compromiso<>'0000' and tipo_compromiso<>'A000' Order by tipo_compromiso,referencia_comp,cod_comp,fecha_compromiso"; $res=pg_query($sql);
  echo "VERFICANDO COMPROBANTES DE COMPROMISOS ".$dbnombre,"<br>";
  echo $sql,"<br>";
  while($registro=pg_fetch_array($res)){
    $referencia_comp=$registro["referencia_comp"]; $cod_comp=$registro["cod_comp"]; 
    $fecha=$registro["fecha_compromiso"];  $tipo_compromiso=$registro["tipo_compromiso"]; 
	$cod_tipo_comp=$registro["cod_tipo_comp"]; $ced_rif=$registro["ced_rif"];
	$descripcion=$registro["descripcion_comp"]; $inf_usuario=$registro["inf_usuario"];
    
	$referencia=$referencia_comp;
	$tipo_comp='P'.$tipo_compromiso; $letra=substr($tipo_compromiso,0,1); if($letra=="A"){ $referencia="A".substr($referencia_comp,1,7); $tipo_comp='P0'.substr($tipo_compromiso,1,3); }
	$sqlr="Select * FROM CON002 WHERE referencia='$referencia' And fecha='$fecha' And tipo_comp='$tipo_comp'";
	if($referencia_comp=="00000005"){ echo $sqlr,"<br>"; }
	
	$resr=pg_exec($conn,$sqlr);  $filasr=pg_numrows($resr);
    if ($filasr==0){
	   echo "Referencia:".$referencia_comp." Tipo:".$tipo_compromiso." Fecha:".$fecha,"<br>";
	   $error=0; 
	   $sqlr="SELECT tipo_comp,cod_contable from pre016 WHERE tipo_comp='$cod_tipo_comp'"; $resr=pg_exec($conn,$sqlr); $filasr=pg_numrows($resr);
       if ($filasr>=1){ $regr=pg_fetch_array($resr);  $cod_con_g_pagar=$regr["cod_contable"]; } else{ $error=1;}
	   
	   $tipodc="D"; if($letra=="A"){ $tipodc="C"; }
	   $resg=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $total=0; 
	   if($error==0){ $sqlr="SELECT * FROM codigos_compromisos where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_comp='$cod_comp' order by cod_presup"; $resr=pg_query($sqlr); 
         while($regr=pg_fetch_array($resr)){ $monto=$regr["monto"]; $cod_contable=$regr["cod_contable"];
		    $monto_asiento=$regr["monto"]; $codigo_cuenta=$regr["cod_contable"]; if($monto_asiento<1){$monto_asiento=$monto_asiento*-1;} $total=$total+$monto_asiento;
			$sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='$tipodc'"; $resg=pg_exec($conn,$sSQL); $filasr=pg_numrows($resg);
			if ($filasr>0){ $reg=pg_fetch_array($resg);
			   $monto_c=$monto_asiento+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c);
			   $sql8="SELECT MODIFICA_CUENTA_CON008('$codigo_mov','$tipodc','$codigo_cuenta',$monto_c,'$descripcion')";
			   $resg=pg_exec($conn, $sql8);
			   $mvalor=pg_errormessage($conn);  $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resg){echo $sql8,"<br>"; ?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? } }
			 else{ 
			   $sql8="SELECT INCLUYE_CON008('$codigo_mov','$referencia','$tipodc','$codigo_cuenta','$tipo_comp','',$monto_asiento,'D','C','N','01','0','$descripcion')";
			   $resg=pg_exec($conn,$sql8);
			  $mvalor=pg_errormessage($conn); $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61);   if (!$resg){echo $sql8,"<br>"; ?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? }}
		 
		 }
		 $tipodc="C"; $tipo_asiento="COM"; if($letra=="A"){ $tipodc="D"; $tipo_asiento="ANU"; }
		 $resultado=pg_exec($conn,"SELECT INCLUYE_CON008('$codigo_mov','$referencia','$tipodc','$cod_con_g_pagar','$tipo_comp','',$total,'D','C','N','01','0','$descripcion')");
         $mvalor=pg_errormessage($conn); $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61);   if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? }   
	   
	    $sqlg="INSERT INTO CON002 (referencia,fecha,tipo_comp,tipo_asiento,status,modulo,aoperacion,doperacion,nro_comprobante,ced_rif,nro_expediente,inf_usuario,descripcion) 
            VALUES ('$referencia','$fecha','$tipo_comp','$tipo_asiento','D','P','01','0','$referencia','$ced_rif','','$inf_usuario','$descripcion')";
		$resg=pg_exec($conn,$sqlg);	 $mvalor=pg_errormessage($conn);	$mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61);   if (!$resg){echo $sql8." ".$mvalor,"<br>"; }
		$sqlg="insert into con003 select referencia,'$fecha',debito_credito,cod_cuenta,tipo_comp,monto_asiento,modificable,descripcion_a from con008 where codigo_mov='$codigo_mov'";
		$resg=pg_exec($conn,$sqlg);  $mvalor=pg_errormessage($conn);	$mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61);   if (!$resg){echo $sql8." ".$mvalor,"<br>"; }
		
	   }
	} 
  }
  
  //1-2-103-08
  
  $sql="select * from con003 where (substring(cod_cuenta,1,7)='3-1-300') and (tipo_comp='O0001' or tipo_comp='OA001')  order by fecha,referencia"; $res=pg_query($sql);
   echo "VERFICANDO COMPROBANTES DE ORDENES DE PAGO ","<br>";
  echo $sql,"<br>";
  while($registro=pg_fetch_array($res)){
    $referencia=$registro["referencia"]; $tipo_comp=$registro["tipo_comp"]; $tipo_causado=substr($tipo_comp,1,4); $fecha=$registro["fecha"];
	$nro_orden=$referencia; if(substr($nro_orden,0,1)=="A"){ $nro_orden="0".substr($referencia,1,7); }
    $sSQL="Select cod_con_g_pagar from pre006 where text(referencia_comp)||text(tipo_compromiso) in (select text(referencia_comp)||text(tipo_compromiso) from pre007 where referencia_caus='$nro_orden' and tipo_causado='$tipo_causado')";
    $resg=pg_exec($conn,$sSQL); $filasr=pg_numrows($resg); 
	if ($filasr>0){ $reg=pg_fetch_array($resg);   $cod_con_g_pagar=$reg["cod_con_g_pagar"];
	  $sqlg="Update con003 set cod_cuenta='$cod_con_g_pagar' where substring(cod_cuenta,1,7)='3-1-300' and tipo_comp='O0001' and referencia='$referencia' and tipo_comp='$tipo_comp'";
	  $resg=pg_exec($conn,$sqlg); $mvalor=pg_errormessage($conn);	$mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61);   if (!$resg){echo $sql8." ".$mvalor,"<br>"; }
	
	  echo "Orden:".$referencia." Tipo:".$tipo_comp." Fecha:".$fecha,"<br>";
	}
  }
  
  
  



?>