<? 
$conn = pg_connect("host=localhost port=5432 password=super user=usia dbname=DATOS");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }

ECHO "REVISANDO PAGOS PRESUPUESTARIO...","<br>";
$sql="select distinct referencia_pago,tipo_pago,referencia_comp,tipo_compromiso,referencia_caus,tipo_causado,cod_banco from pre038 where text(referencia_pago)||text(tipo_pago)||text(referencia_comp)||text(tipo_compromiso)||text(referencia_caus)||text(tipo_causado) not in (select text(referencia_pago)||text(tipo_pago)||text(referencia_comp)||text(tipo_compromiso)||text(referencia_caus)||text(tipo_causado) from pre008)";
$res=pg_query($sql);
while($registro=pg_fetch_array($res)){
  $tipo_pago=$registro["tipo_pago"]; $referencia_pago=$registro["referencia_pago"]; $referencia_caus=$registro["referencia_caus"];  $tipo_causado=$registro["tipo_causado"];
  $referencia_comp=$registro["referencia_comp"];  $tipo_compromiso=$registro["tipo_compromiso"]; $cod_banco=$registro["cod_banco"];

  $sql2="Select * FROM PAGOS where tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and cod_banco='$cod_banco'" ; $res2=pg_query($sql2);  $filas2=pg_num_rows($res2);
  if($filas2>0){  $reg2=pg_fetch_array($res2);
    $tipo_pago=$reg2["tipo_pago"]; $referencia_pago=$reg2["referencia_pago"];  $cod_banco=$reg2["cod_banco"];  $fecha=$reg2["fecha_pago"];  $descripcion=$reg2["descripcion_pago"];
    $ced_rif=$reg2["ced_rif"];   $ref_aep=$reg2["ref_aep"]; $cod_con_g_pagar=$reg2["cod_con_g_pagar"];  $num_proyecto=$reg2["num_proyecto"];  $func_inv=$reg2["func_inv"]; $tipo_pago_b=$reg2["tipo_pago_b"];
    $genera_comprobante=$reg2["genera_comprobante"];   $modulo=$reg2["modulo"];   $anulado=$reg2["anulado"]; $fecha_anu=$reg2["fecha_anu"]; $inf_usuario=$reg2["inf_usuario"];  $status=$reg2["status"];
    $sqlg="INSERT INTO PRE008 (referencia_pago,tipo_pago,referencia_comp,tipo_compromiso,referencia_caus,tipo_causado,fecha_pago,ref_aep,num_proyecto,fecha_aep,anulado,fecha_anu,ced_rif,cod_banco,tipo_pago_b,genera_comprobante,cod_con_g_pagar,modulo,func_inv,status,inf_usuario,descripcion_pago) 
	      VALUES ('".$referencia_pago."','".$tipo_pago."','".$referencia_comp."','".$tipo_compromiso."','".$referencia_caus."','".$tipo_causado."','".$fecha."','".$ref_aep."','".$num_proyecto."','".$fecha."','".$anulado."','".$fecha_anu."','".$ced_rif."','".$cod_banco."','".$tipo_pago_b."','".$genera_comprobante."','".$cod_con_g_pagar."','".$modulo."','".$func_inv."','".$status."','".$inf_usuario."','".$descripcion."')" ;
    $resg=pg_exec($conn,$sqlg); $errorg=pg_errormessage($conn); $errorg="ERROR GRABANDO: ".substr($errorg, 0, 61); if (!$resg){ echo $sqlg.";<br>"; }
      
  }
}


ECHO "REVISANDO CAUSADOS PRESUPUESTARIO...","<br>";
$sql="select distinct referencia_comp,tipo_compromiso,referencia_caus,tipo_causado from pre037 where text(referencia_comp)||text(tipo_compromiso)||text(referencia_caus)||text(tipo_causado) not in (select text(referencia_comp)||text(tipo_compromiso)||text(referencia_caus)||text(tipo_causado) from pre007)";
$res=pg_query($sql);
while($registro=pg_fetch_array($res)){
  $referencia_caus=$registro["referencia_caus"];  $tipo_causado=$registro["tipo_causado"];
  $referencia_comp=$registro["referencia_comp"];  $tipo_compromiso=$registro["tipo_compromiso"]; 
  
  $sql2="Select * from CAUSADOS where tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus'" ;
  $res2=pg_query($sql2);  $filas2=pg_num_rows($res2);
  if($filas2>0){  $reg2=pg_fetch_array($res2);
    $referencia_caus=$reg2["referencia_caus"]; $tipo_causado=$reg2["tipo_causado"];	$descripcion=$reg2["descripcion_caus"];
	$fecha=$reg2["fecha_causado"];  $ced_rif=$reg2["ced_rif"]; $num_proyecto=$reg2["num_proyecto"]; $ref_aep=$reg2["ref_aep"];  $status=$reg2["status"];
	$func_inv=$reg2["func_inv"];   $genera_comprobante=$reg2["genera_comprobante"];  $anulado=$reg2["anulado"];  $modulo=$reg2["modulo"];  $anulado=$reg2["anulado"]; $fecha_anu=$reg2["fecha_anu"]; $inf_usuario=$reg2["inf_usuario"];

	$sqlg="INSERT INTO PRE007 (referencia_caus,tipo_causado,referencia_comp,tipo_compromiso,fecha_causado,ref_aep,num_proyecto,fecha_aep,anulado,fecha_anu,ced_rif,modulo,func_inv,genera_comprobante,status,inf_usuario, descripcion_caus) 
	    VALUES ('".$referencia_caus."','".$tipo_causado."','".$referencia_comp."','".$tipo_compromiso."','".$fecha."','".$ref_aep."','".$num_proyecto."','".$fecha."','".$anulado."','".$fecha_anu."','".$ced_rif."','".$modulo."','".$func_inv."','".$genera_comprobante."','".$status."','".$inf_usuario."','".$descripcion."')" ;
    $resg=pg_exec($conn,$sqlg); $errorg=pg_errormessage($conn); $errorg="ERROR GRABANDO: ".substr($errorg, 0, 61); if (!$resg){ echo $sqlg.";<br>"; }
     
  }
  
  
}

pg_close(); ?>