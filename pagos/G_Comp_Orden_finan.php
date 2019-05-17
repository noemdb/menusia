<?php
function g_comprobante_ord($mconn,$codigo_mov,$G_Comp_Ret,$G_Ord_Ret){ $mvalor=0; $error=0;
  $sSQL="Select * from PAG036 WHERE codigo_mov='$codigo_mov'"; $resultado=pg_exec($mconn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE ORDEN NO VALIDA');</script> <? }
   else{ $registro=pg_fetch_array($resultado); $tipo_ord=$registro["tipo_orden"]; $monto_t=$registro["total_causado"]; $monto_am_ant=$registro["monto_am_ant"];  $cod_cont_ant=$registro["campo_str1"];
    $StrSQL="select * from pag008 where tipo_orden='$tipo_ord'";  $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
    if($filas>0){$registro=pg_fetch_array($resultado); $cod_contable=$registro["cod_contable_t"];}
     else {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE ORDEN NO VALIDA');</script> <? }
    if($error==0){$resultado=pg_exec($mconn,"SELECT ELIMINA_CON008('$codigo_mov')");
      $error=pg_errormessage($mconn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
      if (($G_Comp_Ret=="S") and ($G_Ord_Ret=="N")) {
      $sql="Select * from cod_ret where codigo_mov='$codigo_mov' order by tipo_retencion";$res=pg_query($sql);
      while(($registro=pg_fetch_array($res))){
        $monto_asiento=$registro["monto_retencion"];$codigo_cuenta=$registro["cod_contable_ret"];
        if($registro["cargable"]=="C"){$monto_t=$monto_t-$monto_asiento;
          $sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='C'";
          $resultado=pg_exec($mconn,$sSQL); $filas=pg_numrows($resultado);
          if ($filas>0){ $reg=pg_fetch_array($resultado);
             $monto_c=$monto_asiento+$reg["monto_asiento"];  $monto_c=formato_numero($monto_c);
             if ($monto_c>0){$resultado=pg_exec($mconn,"SELECT MODIFICA_CUENTA_CON008('$codigo_mov','C','$codigo_cuenta',$monto_c,'CAUSADO PRESUPUESTARIO')");
             $error=pg_errormessage($mconn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } } }
           else{$resultado=pg_exec($mconn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','C','$codigo_cuenta','00000','',$monto_asiento,'D','C','N','01','0','')");
            $error=pg_errormessage($mconn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}
        }
      }}
	  if ($monto_am_ant>0) {  $codigo_cuenta=$cod_cont_ant; $monto_asiento=$monto_am_ant; $monto_t=$monto_t-$monto_asiento;
         $sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='C'"; $resultado=pg_exec($mconn,$sSQL); $filas=pg_numrows($resultado);
         if ($filas>0){ $reg=pg_fetch_array($resultado);
            $monto_c=$monto_asiento+$reg["monto_asiento"]; $monto_c=cambia_coma_numero($monto_c);
            $resultado=pg_exec($mconn,"SELECT MODIFICA_CUENTA_CON008('$codigo_mov','C','$codigo_cuenta',$monto_c,'CAUSADO PRESUPUESTARIO')");
            $mvalor=pg_errormessage($mconn);  $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? } }
          else{
            $resultado=pg_exec($mconn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','C','$codigo_cuenta','00000','',$monto_asiento,'D','C','N','01','0','')");
            $mvalor=pg_errormessage($mconn);  $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? }}
      } $monto_t=cambia_coma_numero($monto_t);
      $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contable'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);  $mvalor=0;
      if ($filas==0){$mvalor=1; ?> <script language="JavaScript"> muestra('CUENTA TIPO DE ORDEN NO EXISTE');</script><? }
      else{$registro=pg_fetch_array($resultado); if ($registro["cargable"]=="N"){$mvalor=1; ?> <script language="JavaScript"> muestra('CUENTA TIPO DE ORDEN NO ES CARGABLE');</script><?} }
      if($mvalor==0){$resultado=pg_exec($mconn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','C','$cod_contable','00000','',$monto_t,'D','C','N','01','0','')");
      $error=pg_errormessage($mconn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}
    }
   }
return $mvalor;
}
?>