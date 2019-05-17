<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");   error_reporting(E_ALL);
$cod_cuenta="6-1-3-06"; $cod_presup="01-00-53-403-08-02-00"; $cod_fuente="00";
echo "ESPERE POR FAVOR REVISANDO PAGOS PRESUPUESTARIOS....","<br>";
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
//cod_banco='$cod_banco' and
$sql="select * from pre008 where fecha_pago>='2010-10-01' and tipo_pago='0007' and text(tipo_pago)||text(referencia_pago) not in (select text(tipo_pago)||text(referencia_pago) from pre038) order by fecha_pago";  $res=pg_query($sql);
//echo $sql,"<br>";

$sql="select * from con003 where con003.fecha>'2010-10-01' and con003.tipo_comp<>'00000'  and con003.cod_cuenta='6-1-3-06' and referencia not in (select referencia_pago from pre008 where fecha_pago>'2010-10-01') order by debito_credito,fecha"; $res=pg_query($sql);
//echo $sql,"<br>";  
$tabla="<table>";
while($reg=pg_fetch_array($res)){ 

  $monto=$reg["monto_asiento"];   $referencia=$reg["referencia"]; $fecha=$reg["fecha"]; $descripcion_a=$reg["descripcion_a"];
  $tipo_comp=$reg["tipo_comp"]; 

  $tipo_pago="0007"; $referencia_pago=$referencia;
  $referencia_caus=$referencia;  $tipo_causado="0000";
  $referencia_comp=$referencia;  $tipo_compromiso="0000";
  
  $cod_banco="0007";  
  
  //echo $referencia." ".$fecha." ".$tipo_comp." ".$monto,"<br>";
  
  $sSQL="select * from pre008 where referencia_pago='$referencia_pago' and tipo_pago='$tipo_pago' and referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado'";$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); 
  //echo $sSQL,"<br>";  
  if($filas==0){  
	
	      
		  
    $sSQL="INSERT INTO PRE008 (referencia_Pago,tipo_Pago,referencia_Comp,tipo_compromiso,referencia_Caus,tipo_Causado,fecha_Pago,Ref_AEP,Num_proyecto,fecha_AEP,Anulado,fecha_Anu,Ced_Rif,cod_banco,tipo_Pago_B,Genera_Comprobante,Cod_Con_G_Pagar,Modulo,func_inv,status,Inf_Usuario,descripcion_pago)
                 VALUES ('".$referencia_pago."','".$tipo_pago."','".$referencia_comp."','0000','".$referencia_caus."','0000','".$fecha."','".$referencia_pago."','','".$fecha."',''N'','".$fecha."','G-20009014-6','0007','NDB',''N'','''',''C','F','N'','CMENDOZA  03/11/10 08:10 am','COMISION TARJETA CREDITO/DEBITO-COBRANZA')";
    $resultado=pg_exec($conn,$sSQL);      	
	$sSQL="INSERT INTO pre038(referencia_pago,tipo_pago,referencia_comp,tipo_compromiso,referencia_caus,tipo_causado,cod_banco,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto,ajustado,amort_anticipo,monto_credito) 
    VALUES ('".$referencia_pago."','".$tipo_pago."','".$referencia_comp."','0000','".$referencia_caus."','0000','".$cod_banco."','".$cod_presup."','".$cod_fuente."','P','00000000',".$monto.",0,0,0)" ;
    $resultado=pg_exec($conn,$sSQL);
	
	$sSQL="INSERT INTO PRE007 (referencia_caus,tipo_causado,referencia_comp,tipo_compromiso,fecha_causado,ref_aep,num_proyecto,fecha_aep,anulado,fecha_anu,ced_rif,modulo,func_inv,genera_comprobante,status,inf_usuario,descripcion_caus)
                    VALUES ('".$referencia_caus."','0000','".$referencia_comp."','0000',Pfecha,".$referencia_comp."','','".$fecha."',''N'','".$fecha."','G-20009014-6',''C','F','N','N'','CMENDOZA  03/11/10 08:10 am','COMISION TARJETA CREDITO/DEBITO-COBRANZA')";
	$resultado=pg_exec($conn,$sSQL);  
	$sSQL="INSERT INTO pre037(referencia_caus,tipo_causado,referencia_comp,tipo_compromiso,fecha_causado,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto,pagado,ajustado,amort_anticipo,monto_credito) 
    VALUES ('".$referencia_caus."','0000','".$referencia_comp."','0000','".$fecha."','".$cod_presup."','".$cod_fuente."','P','00000000',".$monto.",0,0,0,0)" ;
    $resultado=pg_exec($conn,$sSQL);
	
	$sSQL="INSERT INTO PRE006 (referencia_comp,tipo_compromiso,cod_comp,fecha_compromiso,cod_tipo_comp,ref_aep,num_proyecto,fecha_aep,tipo_documento,nro_documento,diferido,anulado,fecha_anu,unidad_sol,ced_rif,fecha_vencim,pago_periodico,cantidad_pago,frecuencia,fecha_prim_pago,func_inv,genera_comprobante,cod_con_g_pagar,tiene_anticipo,cod_con_anticipo,monto_anticipo,tasa_anticipo,amort_anticipo,tipo_anticipo,modulo,aprobado,status,nro_expediente,inf_usuario,descripcion_comp)
                       VALUES ('".$referencia_comp."',''0000'','".$tipo_pago."','".$fecha."','000000','".$referencia_comp."','''','".$fecha."','','','N','N','".$fecha."','01-00-53','G-20009014-6','".$fecha."','N',0,'M','".$fecha."','F','N','','N','',0,0,0,'P','C','N','N','','CMENDOZA  03/11/10 08:10 am','COMISION TARJETA CREDITO/DEBITO-COBRANZA')";
	$resultado=pg_exec($conn,$sSQL);  
	$sSQL="INSERT INTO PRE036 (referencia_comp,tipo_compromiso,cod_comp,fecha_compromiso,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto,causado,pagado,ajustado,monto_credito) 
    VALUES ('".$referencia_comp."','0000','".$tipo_pago."','".$fecha."','".$cod_presup."','".$cod_fuente."','P','00000000',".$monto.",0,0,0,0)" ;
    $resultado=pg_exec($conn,$sSQL);
	
	
	echo $referencia." ".$fecha." ".$monto,"<br>";
	
  }
  
  
}$tabla.="</table>";
echo $tabla;
pg_close(); error_reporting(E_ALL ^ E_WARNING); 
?>