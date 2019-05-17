<?php
function g_comp_ret_islr($mconn,$codigo_mov,$orden,$cod_p,$minf_usuario){ $nro_d="";
  $resultado=pg_exec($mconn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($mconn); $error=substr($error, 0, 61);
  $sql="SELECT ced_rif,fecha,total_causado,total_retencion,total_ajuste,total_pagado,tipo_documento,nro_documento FROM PAG001 Where (nro_orden='$orden')";
  $resultado=pg_exec($mconn,$sql);  $filas=pg_numrows($resultado);
  if ($filas>0){$reg=pg_fetch_array($resultado); $ced_rif=$reg["ced_rif"]; $fecha_ord=$reg["fecha"]; $tipo_d=$reg["tipo_documento"]; $nro_fact=$reg["nro_documento"]; $neto_ord=$reg["total_causado"]-$reg["total_retencion"]-$reg["total_ajuste"];} else{ $ced_rif=""; $fecha_ord=""; $tipo_d=""; $nro_fact=""; $neto_ord=0; }  $neto_ord=cambia_coma_numero($neto_ord);
  
  $sql="SELECT nro_factura,nro_con_factura,fecha_factura,monto_factura,monto_iva1 FROM PAG016 Where (nro_orden='$orden')" ; $resultado=pg_exec($mconn,$sql);  $filas=pg_numrows($resultado);
  if ($filas>0){$nro_con_fac=""; $nro_fact=""; $tipo_d=""; $fecha_f=$fecha_ord; $monto_fact=0; $iva_fact=0;  
    //$reg=pg_fetch_array($resultado); $nro_fact=$reg["nro_factura"]; $nro_con_fac=$reg["nro_con_factura"]; $fecha_f=$reg["fecha_factura"]; $monto_fact=$reg["monto_factura"]; $iva_fact=$reg["monto_iva1"]; $tipo_d="FACTURA";
	while($reg=pg_fetch_array($resultado)) {$nro_fact=$reg["nro_factura"]; $nro_con_fac=$reg["nro_con_factura"]; $fecha_f=$reg["fecha_factura"]; if(is_numeric($nro_fact)){$nro_fact=elimina_ceros($nro_fact);  $nro_fact=Rellenarcerosizq($nro_fact,8);}
      $monto_fact=$monto_fact+$reg["monto_factura"]; $iva_fact=$iva_fact+$reg["monto_iva1"]; $tipo_d="FACTURA"; if($nro_d==""){$nro_d=$nro_fact;}else{$nro_d=$nro_d." ".$nro_fact;} if(is_numeric($nro_con_fac)){$nro_con_fac=elimina_ceros($nro_con_fac);  $nro_con_fac=Rellenarcerosizq($nro_con_fac,8);} 
	  }
  }else{  $nro_con_fac=""; $nro_fact=""; $tipo_d=""; $fecha_f=$fecha_ord; $monto_fact=0; $iva_fact=0; }
   
  $sql="SELECT pag004.nro_orden_ret From pag004,pag003 Where (pag003.ret_grupo='I') and (pag003.tipo_retencion=pag004.tipo_retencion) and (nro_orden_ret='$orden')"; $res=pg_query($sql); $filas=pg_num_rows($res);
  if($filas>0){ $nro_p="00000000";
     $StrSQL="select max(nro_planilla) as referencia from ban012 where tipo_planilla='$cod_p'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
     if($filas>0){$registro=pg_fetch_array($resultado); $nro_p=$registro["referencia"];}
     $sql="SELECT pag004.nro_orden_ret,pag004.tipo_retencion,pag004.aux_orden,pag004.tasa_retencion,sum(pag004.monto_objeto_ret) as monto_objeto,sum(pag004.monto_retencion) as monto_retencion From pag004,pag003 Where (pag003.ret_Grupo='I') and (pag003.tipo_retencion=pag004.tipo_retencion) and (nro_orden_ret='$orden') group by pag004.nro_orden_ret,pag004.tipo_retencion,pag004.aux_orden,pag004.tasa_retencion order by pag004.nro_orden_ret,pag004.tipo_retencion";
     $res=pg_query($sql); if(is_numeric($nro_con_fac)){$nro_con_fac=elimina_ceros($nro_con_fac);  $nro_fact=Rellenarcerosizq($nro_fact,8);}
     while($registro=pg_fetch_array($res)){ $ult_ref=$nro_p+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref; $nro_p=$ult_ref;
       $tipo_p=$cod_p;  $fecha_e=$fecha_ord; $nro_o=$registro["nro_orden_ret"]; $aux_o=$registro["aux_orden"]; $tipo_r=$registro["tipo_retencion"];
       $nro_c="00000000"; $tipo_e=""; $monto_p=$neto_ord; $monto_o=$registro["monto_objeto"]; $tasa=$registro["tasa_retencion"]; $monto_r=$registro["monto_retencion"]; $monto1=$monto_fact; $monto2=$iva_fact; $monto3=0;
       $ssql="SELECT INCLUYE_BAN029('$codigo_mov','0000','O/P','$orden','$tipo_p','$nro_p','$ced_rif','$fecha_e','$nro_o','$aux_o','A','$tipo_r','$tipo_d','$nro_d','$nro_con_fac','','$fecha_f','$nro_c','$tipo_e',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";
       $resultado=pg_exec($mconn,$ssql); $error=pg_errormessage($mconn);
     }
     $num_opcion=1; $tipo_planilla=$cod_p;  $fecha_emision=$fecha_ord;
     $monto_retencion=0;$monto_objeto=0; $monto1=0; $tasa=0; $monto2=0; $monto3=0; $monto_pago= 0; $descripcion_ret=""; $tipo_en=""; $tipo_documento=""; $nro_documento=""; $nro_con_factura=""; $fecha=""; $descripcion=""; $tipo_operacion="A";
     $sql="SELECT * FROM ban029 where codigo_mov='$codigo_mov'"; $res=pg_query($sql);
     while($registro=pg_fetch_array($res)){$orden=$registro["nro_orden"];  $aux_orden=$registro["aux_orden"]; $tipo_ret=$registro["tipo_retencion"];  $planilla=$registro["tipo_planilla"]; $nro_planilla=$registro["nro_planilla"];
        $monto_retencion=$registro["monto_retencion"]; $monto_objeto=$registro["monto_objeto"]; $tasa_retencion=$registro["tasa"]; $monto_pago=$registro["monto_pago"]; $monto1=$registro["monto1"];  $monto2=$registro["monto2"];
        $tipo_retencion=$registro["tipo_retencion"]; $tipo_en=$registro["tipo_en"];   $tipo_documento=$registro["tipo_documento"]; $tipo_operacion=$registro["tipo_operacion"];$nro_documento=$registro["nro_documento"];  $nro_con_factura=$registro["nro_con_factura"]; $sfechaf=$registro["fecha_factura"];
        $sSQL="SELECT ACTUALIZA_BAN012($num_opcion,'0000','O/P','$orden','$tipo_planilla','$nro_planilla','$ced_rif','$fecha_emision','$orden','$aux_orden','$tipo_retencion','$tipo_documento','$nro_documento','$nro_con_factura','$sfechaf','','$tipo_en',$monto_pago,$monto_objeto,$tasa_retencion,$monto_retencion,$monto1,$monto2,$monto3,'$minf_usuario','$codigo_mov')";
        $resultado=pg_exec($mconn,$sSQL); $error=pg_errormessage($mconn); $error="ERROR GRABANDO: ".substr($error, 0, 61);  if (!$resultado){}
      }

  }
}

function g_comp_ret_otro($mconn,$codigo_mov,$orden,$cod_p,$tipo_ret,$minf_usuario){ $nro_d="";
  $resultado=pg_exec($mconn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($mconn); $error=substr($error, 0, 61);
  $sql="SELECT ced_rif,fecha,total_causado,total_retencion,total_ajuste,total_pagado,tipo_documento,nro_documento FROM PAG001 Where (nro_orden='$orden')"; $resultado=pg_exec($mconn,$sql);  $filas=pg_numrows($resultado);
  if ($filas>0){$reg=pg_fetch_array($resultado); $ced_rif=$reg["ced_rif"]; $fecha_ord=$reg["fecha"]; $tipo_d=$reg["tipo_documento"]; $nro_fact=$reg["nro_documento"]; $neto_ord=$reg["total_causado"]-$reg["total_retencion"]-$reg["total_ajuste"];} else{ $ced_rif=""; $fecha_ord=""; $tipo_d=""; $nro_fact=""; $neto_ord=0; }  $neto_ord=cambia_coma_numero($neto_ord);
  $sql="SELECT nro_factura,nro_con_factura,fecha_factura,monto_factura,monto_iva1 FROM PAG016 Where (nro_orden='$orden') and (status_2='N')"; $resultado=pg_exec($mconn,$sql);  $filas=pg_numrows($resultado);
  if ($filas>0){$nro_con_fac=""; $nro_fact=""; $tipo_d=""; $fecha_f=$fecha_ord; $monto_fact=0; $iva_fact=0;  
    //$reg=pg_fetch_array($resultado); $nro_fact=$reg["nro_factura"]; $nro_con_fac=$reg["nro_con_factura"]; $fecha_f=$reg["fecha_factura"]; $monto_fact=$reg["monto_factura"]; $iva_fact=$reg["monto_iva1"]; $tipo_d="FACTURA";
	while($reg=pg_fetch_array($resultado)) {$nro_fact=$reg["nro_factura"]; $nro_con_fac=$reg["nro_con_factura"]; $fecha_f=$reg["fecha_factura"]; if(is_numeric($nro_fact)){$nro_fact=elimina_ceros($nro_fact); $nro_fact=Rellenarcerosizq($nro_fact,8);}
      $monto_fact=$monto_fact+$reg["monto_factura"]; $iva_fact=$iva_fact+$reg["monto_iva1"]; $tipo_d="FACTURA"; if($nro_d==""){$nro_d=$nro_fact;}else{$nro_d=$nro_d." ".$nro_fact;} if(is_numeric($nro_con_fac)){$nro_con_fac=elimina_ceros($nro_con_fac); $nro_con_fac=Rellenarcerosizq($nro_con_fac,8);} 
	  }
  }else{$nro_con_fac=""; $nro_fact=""; $tipo_d=""; $fecha_f=$fecha_ord; $monto_fact=0; $iva_fact=0; }
  echo $orden." Codigo Planilla:".$cod_p." Tipo Retentcion:".$tipo_ret." Monto Factura:".$monto_fact,"<br>";
  if($monto_fact>0){
  $sql="SELECT pag004.nro_orden_ret From pag004,pag003 Where (pag004.tipo_retencion='$tipo_ret') and (pag003.tipo_retencion=pag004.tipo_retencion) and (nro_orden_ret='$orden')"; $res=pg_query($sql); $filas=pg_num_rows($res);
  if($filas>0){ $nro_p="00000000";
     $StrSQL="select max(nro_planilla) as referencia from ban012 where tipo_planilla='$cod_p'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
     if($filas>0){$registro=pg_fetch_array($resultado); $nro_p=$registro["referencia"];}
     $sql="SELECT pag004.nro_orden_ret,pag004.tipo_retencion,pag004.aux_orden,pag004.tasa_retencion,sum(pag004.monto_objeto_ret) as monto_objeto,sum(pag004.monto_retencion) as monto_retencion From pag004,pag003 Where (pag004.tipo_retencion='$tipo_ret') and (pag003.tipo_retencion=pag004.tipo_retencion) and (nro_orden_ret='$orden')  group by pag004.nro_orden_ret,pag004.tipo_retencion,pag004.aux_orden,pag004.tasa_retencion order by pag004.nro_orden_ret,pag004.tipo_retencion";
     $res=pg_query($sql); if(is_numeric($nro_con_fac)){$nro_con_fac=elimina_ceros($nro_con_fac); $nro_fact=Rellenarcerosizq($nro_fact,8);}
     while($registro=pg_fetch_array($res)){ $ult_ref=$nro_p+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref; $nro_p=$ult_ref;
       $tipo_p=$cod_p;  $fecha_e=$fecha_ord; $nro_o=$registro["nro_orden_ret"]; $aux_o=$registro["aux_orden"]; $tipo_r=$registro["tipo_retencion"];
       $nro_c="00000000"; $tipo_e=""; $monto_p=$neto_ord; $monto_o=$registro["monto_objeto"]; $tasa=$registro["tasa_retencion"]; $monto_r=$registro["monto_retencion"]; $monto1=$monto_fact; $monto2=$iva_fact; $monto3=0;
       $ssql="SELECT INCLUYE_BAN029('$codigo_mov','0000','O/P','$orden','$tipo_p','$nro_p','$ced_rif','$fecha_e','$nro_o','$aux_o','A','$tipo_r','$tipo_d','$nro_d','$nro_con_fac','','$fecha_f','$nro_c','$tipo_e',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";
       $resultado=pg_exec($mconn,$ssql); $error=pg_errormessage($mconn);
     }$num_opcion=1; $tipo_planilla=$cod_p;  $fecha_emision=$fecha_ord; //echo $sql,"<br>";
     $monto_retencion=0;$monto_objeto=0; $monto1=0; $tasa=0; $monto2=0; $monto3=0; $monto_pago= 0; $descripcion_ret=""; $tipo_en=""; $tipo_documento=""; $nro_documento=""; $nro_con_factura=""; $fecha=""; $descripcion=""; $tipo_operacion="A";
     $sql="SELECT * FROM ban029 where codigo_mov='$codigo_mov'"; $res=pg_query($sql);
     while($registro=pg_fetch_array($res)){$orden=$registro["nro_orden"];  $aux_orden=$registro["aux_orden"]; $tipo_ret=$registro["tipo_retencion"];  $planilla=$registro["tipo_planilla"]; $nro_planilla=$registro["nro_planilla"];
        $monto_retencion=$registro["monto_retencion"]; $monto_objeto=$registro["monto_objeto"]; $tasa_retencion=$registro["tasa"]; $monto_pago=$registro["monto_pago"]; $monto1=$registro["monto1"];  $monto2=$registro["monto2"];
        $tipo_retencion=$registro["tipo_retencion"]; $tipo_en=$registro["tipo_en"];   $tipo_documento=$registro["tipo_documento"]; $tipo_operacion=$registro["tipo_operacion"];$nro_documento=$registro["nro_documento"];  $nro_con_factura=$registro["nro_con_factura"]; $sfechaf=$registro["fecha_factura"];
        $sSQL="SELECT ACTUALIZA_BAN012($num_opcion,'0000','O/P','$orden','$tipo_planilla','$nro_planilla','$ced_rif','$fecha_emision','$orden','$aux_orden','$tipo_retencion','$tipo_documento','$nro_documento','$nro_con_factura','$sfechaf','','$tipo_en',$monto_pago,$monto_objeto,$tasa_retencion,$monto_retencion,$monto1,$monto2,$monto3,'$minf_usuario','$codigo_mov')";
        $resultado=pg_exec($mconn,$sSQL); $error=pg_errormessage($mconn); $error="ERROR GRABANDO: ".substr($error, 0, 61);  if (!$resultado){}
      }

  }}
}
?>