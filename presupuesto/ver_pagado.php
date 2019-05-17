<?include ("../class/conect.php");  include ("../class/funciones.php");
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } 
else{  
  $sql="SELECT referencia_caus, tipo_causado, referencia_comp, tipo_compromiso,  fecha_causado, cod_presup, fuente_financ, tipo_imput_presu, ref_imput_presu, 
       monto, pagado, ajustado, amort_anticipo, monto_credito FROM pre037 where pagado<>0 and pagado<monto order by referencia_caus"; $res=pg_query($sql);$numeroRegistros=pg_num_rows($res);
  while($registro=pg_fetch_array($res)){	$referencia_caus=$registro["referencia_caus"];   $tipo_causado=$registro["tipo_causado"];   $referencia_comp=$registro["referencia_comp"];
    $tipo_compromiso=$registro["tipo_compromiso"]; $tipo_imput_presu=$registro["tipo_imput_presu"]; $ref_imput_presu=$registro["ref_imput_presu"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"];
    $monto_causado=$registro["monto"]; $diferencia=$registro["monto"]-$registro["pagado"];
	
	$total_retencion=0;
	$sqlb="SELECT nro_orden, tipo_causado,total_retencion from pag001 where nro_orden='$referencia_caus' and tipo_causado='$tipo_causado'";
	$resb=pg_query($sqlb);   $filasb=pg_num_rows($resb); 
    if ($filasb==1){ $regb=pg_fetch_array($resb); $total_retencion=$regb["total_retencion"];  }	
	 
	$tdiferencia=$diferencia-$total_retencion; 
	
	if($diferencia>$total_retencion){$balance=$diferencia-$total_retencion;}else{$balance=$total_retencion-$diferencia;}
	
	//if($referencia_caus=="00000001") { 
	//echo $sqlb." ".$filasb,"<br>";
	//echo $referencia_caus." ".$total_retencion." ".$diferencia." ".$tdiferencia." ".$balance,"<br>"; } 
	
	
	if($balance>0.001){ $balance=1; } else {$balance=0;}
	
	
	//if(($total_retencion>0)and($balance==0)){
    if($total_retencion>0){		
      $sqlb="SELECT pre038.referencia_pago,pre038.tipo_pago,pre038.cod_banco,pre038.cod_presup,pre038.fuente_financ,pre038.monto,pre038.ajustado,pre038.amort_anticipo,pre038.monto_credito FROM pre038 where  pre038.referencia_caus='$referencia_caus' and pre038.tipo_causado='$tipo_causado' and pre038.referencia_comp='$referencia_comp' and pre038.tipo_compromiso='$tipo_compromiso' and pre038.cod_presup='$cod_presup' and pre038.fuente_financ='$fuente_financ' and ref_imput_presu='$ref_imput_presu' order by pre038.tipo_pago,pre038.referencia_pago,pre038.cod_presup";
      $resb=pg_query($sqlb);   $filasb=pg_num_rows($resb); 
      if ($filasb>=1){
		  
		  
		if ($filasb==1){$sqlg="update pre038 set monto=monto+$total_retencion where pre038.referencia_caus='$referencia_caus' and pre038.tipo_causado='$tipo_causado' and pre038.referencia_comp='$referencia_comp' and pre038.tipo_compromiso='$tipo_compromiso' and pre038.cod_presup='$cod_presup' and pre038.fuente_financ='$fuente_financ' and ref_imput_presu='$ref_imput_presu'";
        }else{ }
		
		$sqlg="update pre038 set monto=$monto_causado where pre038.referencia_caus='$referencia_caus' and pre038.tipo_causado='$tipo_causado' and pre038.referencia_comp='$referencia_comp' and pre038.tipo_compromiso='$tipo_compromiso' and pre038.cod_presup='$cod_presup' and pre038.fuente_financ='$fuente_financ' and ref_imput_presu='$ref_imput_presu'"; 
		
		
		$resultado=pg_exec($conn,$sqlg); $merror=pg_errormessage($conn); $merror="ERROR GRABANDO: ".substr($merror, 0, 91);
		if (!$resultado){ echo $merror." ".$sqlg,"<br>";   }		//if($referencia_caus=="00000001") { echo $sqlg,"<br>";  }
	  }
      
    }else{
		//if($total_retencion>0){ echo $referencia_caus." ".$total_retencion." ".$diferencia." ".$balance,"<br>"; }
	}	
  }
  ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? 
  echo " ","<br>";  
}

echo "FINALIZO LA ACTUALIZACION....","<br>";  
pg_close();
?>