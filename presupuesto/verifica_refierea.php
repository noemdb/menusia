<? include ("../class/conect.php"); include ("../class/funciones.php");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ echo "ESPERE ACTUALIZANDO PROCESANDO....","<br>";

  $sql="SELECT pre038.referencia_pago,pre038.tipo_pago,pre038.referencia_comp,pre038.tipo_compromiso,pre038.referencia_caus,pre038.tipo_causado,pre038.cod_banco,pre038.cod_presup,pre038.fuente_financ,pre038.tipo_imput_presu,pre038.ref_imput_presu,pre038.monto,pre038.ajustado,pre038.amort_anticipo,pre038.monto_credito,pre008.fecha_pago,pre008.cod_banco,pre008.ced_rif,pre008.ref_aep,pre008.modulo,pre008.inf_usuario,pre008.descripcion_pago  from pre038,PRE008 WHERE pre008.cod_banco=pre038.cod_banco and pre008.tipo_pago=pre038.tipo_pago and pre008.referencia_pago=pre038.referencia_pago and pre008.tipo_causado=pre038.tipo_causado and pre008.referencia_caus=pre038.referencia_caus and pre008.tipo_compromiso=pre038.tipo_compromiso and pre008.referencia_comp=pre038.referencia_comp and pre038.tipo_compromiso='0000' and pre038.tipo_causado='0000' and pre038.cod_presup='01-00-53-403-08-02-00' and pre008.modulo<>'B'";
  $resultado=pg_query($sql); $filas=pg_num_rows($resultado); 
  while($registro=pg_fetch_array($resultado)){ $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $monto=$registro["monto"]; $tipo_imput_presu=$registro["tipo_imput_presu"]; $ref_imput_presu=$registro["ref_imput_presu"]; $ref_aep=$registro["ref_aep"]; $ced_rif=$registro["ced_rif"]; $modulo=$registro["modulo"]; 
    $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"];  $referencia_caus=$registro["referencia_caus"]; $tipo_causado=$registro["tipo_causado"];  $tipo_pago=$registro["tipo_pago"]; $fecha_pago=$registro["fecha_pago"];  $inf_usuario=$registro["inf_usuario"];$descripcion_pago=$registro["descripcion_pago"]; 
    $Ssql="select * from pre036 where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and cod_comp='$tipo_pago' and fecha_compromiso='$fecha_pago' and monto=$monto ";
    $res=pg_query($Ssql); $filas=pg_num_rows($res); 
    if ($filas==0){ 
	  $Ssql="INSERT INTO PRE036 (referencia_comp,tipo_compromiso,cod_comp,fecha_compromiso,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto,causado,pagado,ajustado,monto_credito) VALUES ('$referencia_comp','0000','$tipo_pago','$fecha_pago','$cod_presup','$fuente_financ','$tipo_imput_presu','$ref_imput_presu',$monto,0,0,0,0)";
      $res=pg_exec($conn,$Ssql); echo "Grabo Codigo Compromiso: ".$referencia_comp." ".$tipo_compromiso." ".$cod_presup." ".$monto,"<br>";
	}	
	
	$Ssql="select * from pre006 where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_comp='$tipo_pago' and fecha_compromiso='$fecha_pago'";
    $res=pg_query($Ssql); $filas=pg_num_rows($res); 
    if ($filas==0){ 
	   $Ssql="INSERT INTO PRE006 (referencia_comp,tipo_compromiso,cod_comp,fecha_compromiso,cod_tipo_comp,ref_aep,num_proyecto,fecha_aep,tipo_documento,nro_documento,diferido,anulado,fecha_anu,unidad_sol,ced_rif,fecha_vencim,pago_periodico,cantidad_pago,frecuencia,fecha_prim_pago,func_inv,genera_comprobante,cod_con_g_pagar,tiene_anticipo,cod_con_anticipo,monto_anticipo,tasa_anticipo,amort_anticipo,tipo_anticipo,modulo,aprobado,status,nro_expediente,inf_usuario,descripcion_comp)
                       VALUES ('$referencia_comp','0000','$tipo_pago','$fecha_pago','000000','$ref_aep','','$fecha_pago','','','N','N','$fecha_pago','01-00-53','$ced_rif','$fecha_pago','N',0,'M','$fecha_pago','F','N','','N','',0,0,0,'P','$modulo','N','N','','$inf_usuario','$descripcion_pago')";
	   $res=pg_exec($conn,$Ssql); echo "Grabo Compromiso: ".$referencia_comp." ".$tipo_compromiso." ".$fecha_pago,"<br>";
	}
	
	$Ssql="select * from pre007 where referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and fecha_causado='$fecha_pago' ";
    $res=pg_query($Ssql); $filas=pg_num_rows($res); 
    if ($filas==0){ 
	   $Ssql="INSERT INTO PRE007 (referencia_caus,tipo_causado,referencia_comp,tipo_compromiso,fecha_causado,ref_aep,num_proyecto,fecha_aep,anulado,fecha_anu,ced_rif,modulo,func_inv,genera_comprobante,status,inf_usuario,descripcion_caus)
                    VALUES ('$referencia_caus','0000','$referencia_comp','0000','$fecha_pago','$ref_aep','','$fecha_pago','N','$fecha_pago','$ced_rif','$modulo','F','N','N','$inf_usuario','$descripcion_pago')"; 
	   $res=pg_exec($conn,$Ssql); echo "Grabo Causado: ".$referencia_caus." ".$tipo_causado." ".$fecha_pago,"<br>";
	
	}
	
	$Ssql="select * from pre037 where referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and fecha_causado='$fecha_pago' and monto=$monto ";
    $res=pg_query($Ssql); $filas=pg_num_rows($res); 
    if ($filas==0){ 
	  $Ssql="INSERT INTO pre037(referencia_caus,tipo_causado,referencia_comp,tipo_compromiso,fecha_causado,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto,pagado,ajustado,amort_anticipo,monto_credito) VALUES ('$referencia_caus','0000','$referencia_comp','0000','$fecha_pago','$cod_presup','$fuente_financ','$tipo_imput_presu','$ref_imput_presu',$monto,0,0,0,0)"; 
	  $res=pg_exec($conn,$Ssql); echo "Grabo Codigo Causado: ".$referencia_comp." ".$tipo_compromiso." ".$cod_presup." ".$monto,"<br>";
	}
  }
  
  $sql="SELECT pre038.referencia_pago,pre038.tipo_pago,pre038.referencia_comp,pre038.tipo_compromiso,pre038.referencia_caus,pre038.tipo_causado,pre038.cod_banco,pre038.cod_presup,pre038.fuente_financ,pre038.tipo_imput_presu,pre038.ref_imput_presu,pre038.monto,pre038.ajustado,pre038.amort_anticipo,pre038.monto_credito,pre008.fecha_pago,pre008.cod_banco,pre008.ced_rif,pre008.ref_aep,pre008.modulo,pre008.inf_usuario,pre008.descripcion_pago  from pre038,PRE008 WHERE pre008.cod_banco=pre038.cod_banco and pre008.tipo_pago=pre038.tipo_pago and pre008.referencia_pago=pre038.referencia_pago and pre008.tipo_causado=pre038.tipo_causado and pre008.referencia_caus=pre038.referencia_caus and pre008.tipo_compromiso=pre038.tipo_compromiso and pre008.referencia_comp=pre038.referencia_comp and pre038.tipo_compromiso='0000' and pre038.tipo_causado='0000' and pre038.cod_presup='01-00-53-403-08-02-00' and pre008.modulo='B'";
  $resultado=pg_query($sql); $filas=pg_num_rows($resultado); 
  while($registro=pg_fetch_array($resultado)){ $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $monto=$registro["monto"]; $tipo_imput_presu=$registro["tipo_imput_presu"]; $ref_imput_presu=$registro["ref_imput_presu"]; $ref_aep=$registro["ref_aep"]; $ced_rif=$registro["ced_rif"]; $modulo=$registro["modulo"]; $cod_banco=$registro["cod_banco"]; 
    $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"];  $referencia_caus=$registro["referencia_caus"]; $tipo_causado=$registro["tipo_causado"];  $tipo_pago=$registro["tipo_pago"]; $fecha_pago=$registro["fecha_pago"];  $inf_usuario=$registro["inf_usuario"];$descripcion_pago=$registro["descripcion_pago"]; 
    $Ssql="select * from pre036 where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and cod_comp='$cod_banco' and fecha_compromiso='$fecha_pago' and monto=$monto ";
    $res=pg_query($Ssql); $filas=pg_num_rows($res); 
    if ($filas==0){ 
	  $Ssql="INSERT INTO PRE036 (referencia_comp,tipo_compromiso,cod_comp,fecha_compromiso,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto,causado,pagado,ajustado,monto_credito) VALUES ('$referencia_comp','0000','$cod_banco','$fecha_pago','$cod_presup','$fuente_financ','$tipo_imput_presu','$ref_imput_presu',$monto,0,0,0,0)";
      $res=pg_exec($conn,$Ssql); echo "Grabo Codigo Compromiso: ".$referencia_comp." ".$tipo_compromiso." ".$cod_presup." ".$monto,"<br>";
	}	
	
	$Ssql="select * from pre037 where referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and fecha_causado='$fecha_pago' and monto=$monto ";
    $res=pg_query($Ssql); $filas=pg_num_rows($res); 
    if ($filas==0){ 
	  $Ssql="INSERT INTO pre037(referencia_caus,tipo_causado,referencia_comp,tipo_compromiso,fecha_causado,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto,pagado,ajustado,amort_anticipo,monto_credito) VALUES ('$referencia_caus','0000','$referencia_comp','0000','$fecha_pago','$cod_presup','$fuente_financ','$tipo_imput_presu','$ref_imput_presu',$monto,0,0,0,0)"; 
	  $res=pg_exec($conn,$Ssql); echo "Grabo Codigo Causado: ".$referencia_comp." ".$tipo_compromiso." ".$cod_presup." ".$monto,"<br>";
	}
  }
  
  $sql="SELECT pre036.referencia_comp,tipo_compromiso,cod_comp,fecha_compromiso,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto from pre036 where tipo_compromiso='0000' and cod_comp='0007' and cod_presup='01-00-53-403-08-02-00'";
  $resultado=pg_query($sql); $filas=pg_num_rows($resultado); 
  while($registro=pg_fetch_array($resultado)){ $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $monto=$registro["monto"]; $tipo_imput_presu=$registro["tipo_imput_presu"]; $ref_imput_presu=$registro["ref_imput_presu"];  $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"];  $tipo_pago=$registro["cod_comp"]; $fecha_pago=$registro["fecha_compromiso"];   
    $Ssql="select * from pre038 where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and referencia_caus='$referencia_comp' and tipo_causado='$tipo_compromiso' and referencia_pago='$referencia_comp'  and tipo_pago='$tipo_pago' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and monto=$monto";
    $res=pg_query($Ssql); $filas=pg_num_rows($res); //echo $filas." ".$Ssql,"<br>";
    if ($filas==0){$Ssql="delete from pre036 where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and  cod_comp='$tipo_pago' and fecha_compromiso='$fecha_pago' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and monto=$monto";
	   $res=pg_exec($conn,$Ssql); echo "Elimino Codigo Compromiso: ".$referencia_comp." ".$tipo_compromiso." ".$cod_presup." ".$monto,"<br>";
    }  
  }
  
  

}pg_close(); ?>
