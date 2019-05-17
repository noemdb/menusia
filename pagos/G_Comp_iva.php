<?php
function g_comp_ret_iva($mconn,$codigo_mov,$orden,$minf_usuario){
  $resultado=pg_exec($mconn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($mconn); $error=substr($error, 0, 91);
  $corr_iva_ano="N"; $sql="Select * from SIA005 where campo501='02'"; $resultado=pg_exec($mconn,$sql); $filas=pg_numrows($resultado);if ($filas>0){$registro=pg_fetch_array($resultado);$mconfb=$registro["campo502"]; $corr_iva_ano=substr($mconfb,8,1);}else{$mconfb="";}
  $orden=substr($orden,0,8);  $tipo_mov='O/P'; $cod_banco='0000'; $monto_ret_ord=0;
  $sql="SELECT ced_rif,fecha,total_causado,total_retencion,total_ajuste,total_pagado,tipo_documento,nro_documento FROM PAG001 Where (nro_orden='$orden')";
  $resultado=pg_exec($mconn,$sql);  $filas=pg_numrows($resultado);if ($filas>0){$reg=pg_fetch_array($resultado); $ced_rif=$reg["ced_rif"]; $fecha_ord=$reg["fecha"]; $tipo_d=$reg["tipo_documento"]; $nro_fact=$reg["nro_documento"]; $neto_ord=$reg["total_causado"]-$reg["total_retencion"]-$reg["total_ajuste"];} else{ $ced_rif=""; $fecha_ord=""; $tipo_d=""; $nro_fact=""; $neto_ord=0; }  $neto_ord=cambia_coma_numero($neto_ord);
  $sql="SELECT pag004.nro_orden_ret,pag004.tipo_retencion,pag004.aux_orden,pag004.tasa_retencion,sum(pag004.monto_objeto_ret) as monto_objeto,sum(pag004.monto_retencion) as monto_retencion From pag004,pag003 Where (pag003.ret_Grupo='A') and (pag003.tipo_retencion=pag004.tipo_retencion) and (nro_orden_ret='$orden') group by pag004.nro_orden_ret,pag004.tipo_retencion,pag004.aux_orden,pag004.tasa_retencion order by pag004.nro_orden_ret,pag004.tipo_retencion";
  $resultado=pg_exec($mconn,$sql);  $filas=pg_numrows($resultado);
  if ($filas>0){$reg=pg_fetch_array($resultado); $tasa_retencion=$reg["tasa_retencion"]; $monto_ret_ord=$reg["monto_retencion"]; } else{$tasa_retencion=0;}
  //echo $tasa_retencion,"<br>";
  if($tasa_retencion>0){ $tot_ret_fact=0;
  $sql="SELECT nro_factura,nro_con_factura,fecha_factura,monto_factura,monto_sin_iva,monto_iva1,tasa_iva1,monto_iva1_so,campo_str2 FROM PAG016 Where (nro_orden='$orden') and (status_2='N')";$res=pg_query($sql); $tipo_r=0;
  while($registro=pg_fetch_array($res))
  { $tipo_r=$tipo_r+1; $fecha_e=$fecha_ord; $fecha_f=$registro["fecha_factura"];  $nro_fact=$registro["nro_factura"]; $nro_con_fac=$registro["nro_con_factura"]; 
    if(is_numeric($nro_fact)){$nro_fact=elimina_ceros($nro_fact);   $nro_fact=Rellenarcerosizq($nro_fact,8);	}  if(is_numeric($nro_con_fac)){$nro_con_fac=elimina_ceros($nro_con_fac); $nro_con_fac=Rellenarcerosizq($nro_con_fac,8);}  
    $nro_d=$nro_fact;  $monto_p=$registro["monto_factura"]; $monto1=$registro["monto_sin_iva"];  $tasa=$registro["tasa_iva1"];  $monto_o=$registro["monto_iva1_so"]; $monto1=$monto1-$monto_o; $nro_doc_afec="";
    $iva_fact=$registro["monto_factura"]-$registro["monto_sin_iva"]; $monto_r=$iva_fact*($tasa_retencion/100);  $monto2=cambia_coma_numero($iva_fact); $monto3=$tasa_retencion; $monto_r=cambia_coma_numero($monto_r);  $monto1=cambia_coma_numero($monto1);
    $tipo_mov="01-REG"; $tipo_planilla="01";        if($monto_p<0){$tipo_mov="03-REG"; $tipo_planilla="03"; $nro_doc_afec=$registro["campo_str2"]; }  $tot_ret_fact=$tot_ret_fact+$monto_r; 
    $ssql="SELECT INCLUYE_BAN029('$codigo_mov','0000','O/P','$orden','$tipo_r','$tipo_mov','$ced_rif','$fecha_e','$orden','$orden','C','$tipo_r','$tipo_planilla','$nro_d','$nro_con_fac','$nro_doc_afec','$fecha_f','00000000','',$monto_p,$monto_o,$tasa,$monto_r,$monto1,$monto2,$monto3)";  $resultado=pg_exec($mconn,$ssql); $error=pg_errormessage($mconn);
   // echo $ssql,"<br>";
  }  if($monto_ret_ord>$tot_ret_fact){$diferencia=$monto_ret_ord-$tot_ret_fact; }else{$diferencia=$tot_ret_fact-$monto_ret_ord; } 
  if($diferencia>0.01){ echo ' Monto Retencion: '.$monto_ret_ord.' Total ret. Facturas: '.$tot_ret_fact.' Diferencia:'.$diferencia,"<br>"; ?><script language="JavaScript">muestra('MONTO TOTAL RETENCION COMPROBANTE IVA NO CUADRA CON RETENCION DE LA ORDEN');</script><?}
  else{$ano_fiscal=substr($fecha_ord,0,4);  $mes_fiscal=substr($fecha_ord,5,2);  $nro_comprobante="00000001"; $fecha_emision=$fecha_ord;
  $StrSQL="select max(nro_comprobante) as ref from ban027 where ano_fiscal='$ano_fiscal'";
  if($corr_iva_ano=="N"){$StrSQL="select max(nro_comprobante) as ref from ban027 where ano_fiscal='$ano_fiscal' and mes_fiscal='$mes_fiscal'";} else{$StrSQL="select max(nro_comprobante) as ref from ban027 where ano_fiscal='$ano_fiscal'";}

  $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["ref"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref; $nro_comprobante=$ult_ref;}
  $sql="SELECT * FROM BAN029 where codigo_mov='$codigo_mov' order by tipo_retencion,nro_planilla"; $res=pg_query($sql);
  //echo $sql." ".$nro_comprobante,"<br>";
  while($registro=pg_fetch_array($res)){ $tipo_retencion=$registro["tipo_retencion"]; $nro_op=$tipo_retencion*1; $tipo_operacion=$registro["tipo_operacion"]; $tipo_documento=$registro["tipo_documento"]; $sfechaf=$registro["fecha_factura"]; $nro_orden=$registro["nro_orden"]; $ced_rif=$registro["ced_rif"];
    $nro_documento=$registro["nro_documento"];  $nro_con_factura=$registro["nro_con_factura"]; $nro_doc_afectado=$registro["nro_doc_afectado"];  $tipo_transaccion=$registro["nro_planilla"]; $monto=$registro["monto_pago"]; $montob=$registro["monto_objeto"];  $montos=$registro["monto1"];$retenc=$registro["monto3"]; $montoi=$registro["monto2"]; $tasa=$registro["tasa"]; $montor=$registro["monto_retencion"];
    $sSQL="SELECT  INCLUYE_BAN027('$ano_fiscal','$mes_fiscal','$nro_comprobante',$nro_op,'$ced_rif','$fecha_emision','$tipo_operacion','$tipo_documento','$sfechaf','$nro_documento','$nro_con_factura','$nro_doc_afectado','$tipo_transaccion',$monto,$montos,$montob,$tasa,$montoi,$retenc,$montor,'0000','O/P','$nro_orden','','$minf_usuario')";
    $resultado=pg_exec($mconn,$sSQL); $error=pg_errormessage($mconn); $error="ERROR GRABANDO: ".substr($error, 0, 91);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{}
  }
  }
  }  
}
?>