<?include ("../class/conect.php");  include ("../class/funciones.php");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
echo "ESPERE POR FAVOR REVISANDO CANCELACIONES....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
else{
  $sqlb="select pag004.nro_cheque_r,pag004.nro_orden_ret,pag004.tipo_caus_ret,pag004.tipo_caus_ret,pag004.ref_comp_ret,pag004.tipo_comp_ret,pag004.cod_presup_ret,pag004.fuente_fin_ret,sum(pag004.monto_retencion) as monto_retencion from pag004 where (status_r='I') and  (tipo_pago_r='O/P')   group by pag004.nro_cheque_r,pag004.nro_orden_ret,pag004.tipo_caus_ret,pag004.tipo_caus_ret,pag004.ref_comp_ret,pag004.tipo_comp_ret,pag004.cod_presup_ret,pag004.fuente_fin_ret order by pag004.nro_cheque_r,pag004.nro_orden_ret,pag004.tipo_caus_ret,pag004.ref_comp_ret,pag004.tipo_comp_ret,pag004.cod_presup_ret,pag004.fuente_fin_ret"; $res=pg_query($sqlb);
  while($reg=pg_fetch_array($res)){ $monto_c=$reg["monto_retencion"]; $cod_presup=$reg["cod_presup_ret"]; $fuente_financ=$reg["fuente_fin_ret"]; $nro_orden_r=$reg["nro_orden_ret"]; $tipo_causado_r=$reg["tipo_caus_ret"]; $referencia_comp=$reg["ref_comp_ret"]; $tipo_compromiso=$reg["tipo_comp_ret"]; $nro_cheque_r=$reg["nro_cheque_r"];
    
	$tsqlp="SELECT * FROM pre037 where (pagado<>0 and pagado<monto) and referencia_caus='$nro_orden_r' and  tipo_causado='$tipo_causado_r' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ'";
	
	$sqlp="SELECT referencia_caus,tipo_causado,referencia_comp,tipo_compromiso,fecha_causado,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto,pagado,ajustado,amort_anticipo,monto_credito FROM pre037 where (pagado<>0 and pagado<monto) and referencia_caus='$nro_orden_r' and  tipo_causado='$tipo_causado_r' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ'";
	$resp=pg_query($tsqlp);   $filasp=pg_num_rows($resp);
   // if($nro_cheque_r=="00000059"){ echo" ".$filasp." ". $tsqlp,"<br>"; }	
    if ($filasp>=1){ $ref_pagado=""; $cod_banco=""; $fecha_cheque=""; $tipo_pago_O=""; $ced_rif="";
	    $sqlo="select cod_banco, nro_cheque, fecha_cheque, tipo_pago,ced_rif from pag001 where nro_orden='$nro_cheque_r' and status='I'"; $reso=pg_query($sqlo);   $filaso=pg_num_rows($reso); 
		//if($nro_cheque_r=="00000059"){ echo $sqlo." ".$filaso,"<br>"; }	
        if ($filaso>=1){  $rego=pg_fetch_array($reso); $ced_rif=$rego["ced_rif"];  $ref_pagado=$rego["nro_cheque"]; $tipo_pago_O=$rego["tipo_pago"]; $cod_banco=$rego["cod_banco"]; $fecha_cheque=$rego["fecha_cheque"];
		   $tipo_pago="0000"; if($tipo_pago_O=="CHQ"){$tipo_pago="0001"; } if($tipo_pago_O=="NDB"){$tipo_pago="0003"; } 

		   $sqlp="SELECT referencia_pago FROM pre038 where referencia_pago='$ref_pagado' and referencia_caus='$nro_orden_r' and  cod_banco='$cod_banco' and tipo_pago='$tipo_pago' and tipo_causado='$tipo_causado_r' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ'"; 
	       $resp=pg_query($sqlp);   $filasp=pg_num_rows($resp);
		   if ($filasp==0){
			  $sqlg="INSERT INTO pre038(referencia_pago, tipo_pago, referencia_comp, tipo_compromiso,referencia_caus, tipo_causado, cod_banco, cod_presup, fuente_financ,tipo_imput_presu, ref_imput_presu, monto, ajustado, amort_anticipo,monto_credito)
			    VALUES ('$ref_pagado','$tipo_pago','$referencia_comp','$tipo_compromiso','$nro_orden_r','$tipo_causado_r','$cod_banco','$cod_presup','$fuente_financ','P','00000000',$monto_c,0,0,0) ";
		   }else{ 
              $sqlg="update pre038 set monto=$monto_c where pre038.referencia_pago='$ref_pagado' and pre038.referencia_caus='$nro_orden_r' and pre038.tipo_causado='$tipo_causado_r' and pre038.referencia_comp='$referencia_comp' and pre038.tipo_compromiso='$tipo_compromiso' and pre038.cod_presup='$cod_presup' and pre038.fuente_financ='$fuente_financ'"; 
		   }
		   $resultado=pg_exec($conn,$sqlg); $merror=pg_errormessage($conn); $merror="ERROR GRABANDO: ".substr($merror, 0, 91);  if (!$resultado){ echo $merror." ".$sqlg,"<br>";   }
		   
		   if ($filasp==0){
			  $sqlp="SELECT referencia_pago FROM pre008 where referencia_pago='$ref_pagado' and referencia_caus='$nro_orden_r' and  cod_banco='$cod_banco' and tipo_pago_b='$tipo_pago_O'";
			   $resp=pg_query($sqlp);   $filasp=pg_num_rows($resp);
			   if ($filasp==0){ $descrip="CANCELACION ORDEN DE PAGO NUMERO:".$nro_orden_r;
				 $sqlg="INSERT INTO pre008(referencia_pago,tipo_pago,referencia_comp,tipo_compromiso,referencia_caus,tipo_causado,fecha_pago,ref_aep,num_proyecto,fecha_aep,anulado,fecha_anu,ced_rif,cod_banco,tipo_pago_b,genera_comprobante,cod_con_g_pagar,modulo,func_inv,status,inf_usuario,descripcion_pago)
					VALUES ('$ref_pagado','$tipo_pago','$referencia_comp','$tipo_compromiso','$nro_orden_r','$tipo_causado_r','$fecha_cheque','$referencia_comp','0000000000','$fecha_cheque','N','$fecha_cheque','$ced_rif','$cod_banco','$tipo_pago_O','N','','B','C','N','','$descrip') ";
				 $resultado=pg_exec($conn,$sqlg); $merror=pg_errormessage($conn); $merror="ERROR GRABANDO: ".substr($merror, 0, 91);
			   } 
		   }   
		   //if($nro_cheque_r=="00000059"){ echo $sqlg,"<br>"; }	
		}
	
	}
  }
}
pg_close(); ?> <script language="JavaScript"> muestra('PROCESO TERMINADO'); window.close(); window.opener.location.reload();  </script>