<?php
function g_comprobante_ord($mconn,$codigo_mov,$G_Comp_Ret,$G_Ord_Ret){ $mvalor=0;
  $sSQL="Select * from PAG036 WHERE codigo_mov='$codigo_mov'";  $resultado=pg_exec($mconn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$mvalor=1; ?> <script language="JavaScript"> muestra('TIPO DE ORDEN NO VALIDA');</script> <? }
   else{ $registro=pg_fetch_array($resultado); $tipo_ord=$registro["tipo_orden"]; $pasivo_comp=$registro["pasivo_comp"]; $monto_am_ant=$registro["monto_am_ant"];  $cod_cont_ant=$registro["campo_str1"];
    $StrSQL="select * from pag008 where tipo_orden='$tipo_ord'";    $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
    if($filas>0){$registro=pg_fetch_array($resultado); $cod_contable=$registro["cod_contable_t"];  }
     else {$mvalor=1; ?> <script language="JavaScript"> muestra('TIPO DE ORDEN NO VALIDA');</script> <? }
    if($mvalor==0){ $monto_t=0;
      $resultado=pg_exec($mconn,"SELECT ELIMINA_CON008('$codigo_mov')");  $mvalor=pg_errormessage($mconn); $mvalor=substr($mvalor, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $mvalor; ?>'); </script> <? }
      $sql="Select * from CODIGOS_PRE026 where codigo_mov='$codigo_mov' and monto>0 order by cod_presup";  $res=pg_query($sql);
      while(($registro=pg_fetch_array($res))){    $monto_asiento=$registro["monto"]; $codigo_cuenta=$registro["cod_con_g_pagar"];
        $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"];
        $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $ref_imput_presu=$registro["ref_imput_presu"];
        if($registro["cargable"]=="C"){
          if ($G_Ord_Ret=="S") { $monto_ret=0;
             $sql="Select * from cod_ret where codigo_mov='$codigo_mov' and ref_comp_ret='$referencia_comp' and tipo_comp_ret='$tipo_compromiso' and cod_presup_ret='$cod_presup' and fuente_fin_ret='$fuente_financ'"; $result=pg_query($sql);
             while(($reg=pg_fetch_array($result))){$monto_ret=$monto_ret+$reg["monto_retencion"];}  $monto_asiento=$monto_asiento-$monto_ret;
          }
          $monto_t=$monto_t+$monto_asiento;		  
		  $codigo1=$codigo_cuenta; $monto1=$monto_asiento; $codigo2=""; $monto2=0; $codigo3=""; $monto3=0;
		  $sqla="SELECT * FROM con022 where codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and ref_imput_presu='$ref_imput_presu'"; $resa=pg_query($sqla); $filasa=pg_num_rows($resa);
          if ($filasa>0){  $registroa=pg_fetch_array($resa);$codigo1=$registroa["codigo1"]; $monto1=$registroa["monto1"]; $codigo2=$registroa["codigo2"]; $monto2=$registroa["monto2"];
            $codigo3=$registroa["codigo3"]; $monto3=$registroa["monto3"]; $codigo4=$registroa["codigo4"]; $monto4=$registroa["monto4"]; $codigo5=$registroa["codigo5"]; $monto5=$registroa["monto5"];  }

          $sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo1' and debito_credito='D'"; $resultado=pg_exec($mconn,$sSQL); $filas=pg_numrows($resultado);
		  if ($filas>0){ $reg=pg_fetch_array($resultado);
             $monto_c=$monto1+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c);
             $resultado=pg_exec($mconn,"SELECT MODIFICA_CUENTA_CON008('$codigo_mov','D','$codigo1',$monto_c,'CAUSADO PRESUPUESTARIO')");
             $mvalor=pg_errormessage($mconn);  $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? } }
           else{ $resultado=pg_exec($mconn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','D','$codigo1','00000','',$monto1,'D','C','N','01','0','')");
            $mvalor=pg_errormessage($mconn); $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61);   if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? }}
          
		  if($codigo2<>""){
		  $sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo2' and debito_credito='D'"; $resultado=pg_exec($mconn,$sSQL); $filas=pg_numrows($resultado);
		  if ($filas>0){ $reg=pg_fetch_array($resultado);
             $monto_c=$monto2+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c);
             $resultado=pg_exec($mconn,"SELECT MODIFICA_CUENTA_CON008('$codigo_mov','D','$codigo2',$monto_c,'CAUSADO PRESUPUESTARIO')");
             $mvalor=pg_errormessage($mconn);  $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? } }
           else{$resultado=pg_exec($mconn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','D','$codigo2','00000','',$monto2,'D','C','N','01','0','')");
            $mvalor=pg_errormessage($mconn); $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61);   if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? }}
		  }
		  
		  if($codigo3<>""){
		  $sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo3' and debito_credito='D'"; $resultado=pg_exec($mconn,$sSQL); $filas=pg_numrows($resultado);
		  if ($filas>0){ $reg=pg_fetch_array($resultado);
             $monto_c=$monto3+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c);
             $resultado=pg_exec($mconn,"SELECT MODIFICA_CUENTA_CON008('$codigo_mov','D','$codigo3',$monto_c,'CAUSADO PRESUPUESTARIO')");
             $mvalor=pg_errormessage($mconn);  $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? } }
           else{$resultado=pg_exec($mconn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','D','$codigo3','00000','',$monto3,'D','C','N','01','0','')");
            $mvalor=pg_errormessage($mconn); $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61);   if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? }}
		  }
		
		}
      }
      if (($G_Comp_Ret=="S") and ($G_Ord_Ret=="N")) {
      $sql="Select * from cod_ret where codigo_mov='$codigo_mov' order by tipo_retencion";   $res=pg_query($sql);
      while(($registro=pg_fetch_array($res))){
        $monto_asiento=$registro["monto_retencion"];$codigo_cuenta=$registro["cod_contable_ret"];
        if($registro["cargable"]=="C"){
          $monto_t=$monto_t-$monto_asiento;
          $sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='C'"; $resultado=pg_exec($mconn,$sSQL); $filas=pg_numrows($resultado);
          if ($filas>0){ $reg=pg_fetch_array($resultado);  $monto_c=$monto_asiento+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c);
             if ($monto_c>0){$resultado=pg_exec($mconn,"SELECT MODIFICA_CUENTA_CON008('$codigo_mov','C','$codigo_cuenta',$monto_c,'CAUSADO PRESUPUESTARIO')");
             $mvalor=pg_errormessage($mconn);  $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? } } }
           else{
            $resultado=pg_exec($mconn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','C','$codigo_cuenta','00000','',$monto_asiento,'D','C','N','01','0','')");
            $mvalor=pg_errormessage($mconn);  $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? }}
        }
      }}
      if ($pasivo_comp=="SI") {
         $sql="SELECT * FROM cod_pasivo where codigo_mov='$codigo_mov' order by cod_cuenta";  $res=pg_query($sql);
         while(($registro=pg_fetch_array($res))){
            $monto_asiento=$registro["monto_pasivo"];  $codigo_cuenta=$registro["cod_cuenta"];  $debito_credito=$registro["debito_credito"];
            if($registro["cargable"]=="C"){
              if($debito_credito=="C"){$monto_t=$monto_t-$monto_asiento;} else {$monto_t=$monto_t+$monto_asiento;}
              $sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='$debito_credito'";  $resultado=pg_exec($mconn,$sSQL); $filas=pg_numrows($resultado);
              if ($filas>0){$reg=pg_fetch_array($resultado);
                 $monto_c=$monto_asiento+$reg["monto_asiento"]; $monto_c=cambia_coma_numero($monto_c);
                 $resultado=pg_exec($mconn,"SELECT MODIFICA_CUENTA_CON008('$codigo_mov','$debito_credito','$codigo_cuenta',$monto_c,'CAUSADO PRESUPUESTARIO')");
                 $mvalor=pg_errormessage($mconn);  $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? } }
               else{
                 $resultado=pg_exec($mconn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','$debito_credito','$codigo_cuenta','00000','',$monto_asiento,'D','C','N','01','0','')");
                 $mvalor=pg_errormessage($mconn);  $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? }}
            }
         }
      }
      if ($monto_am_ant>0) {  $codigo_cuenta=$cod_cont_ant; $monto_asiento=$monto_am_ant; $monto_t=$monto_t-$monto_asiento;
         $sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='C'"; $resultado=pg_exec($mconn,$sSQL); $filas=pg_numrows($resultado);
         if ($filas>0){ $reg=pg_fetch_array($resultado);
            $monto_c=$monto_asiento+$reg["monto_asiento"]; $monto_c=cambia_coma_numero($monto_c);
            $resultado=pg_exec($mconn,"SELECT MODIFICA_CUENTA_CON008('$codigo_mov','C','$codigo_cuenta',$monto_c,'CAUSADO PRESUPUESTARIO')");
            $mvalor=pg_errormessage($mconn);  $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? } }
          else{
            $resultado=pg_exec($mconn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','C','$codigo_cuenta','00000','',$monto_asiento,'D','C','N','01','0','')");
            $mvalor=pg_errormessage($mconn);  $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? }}
      }  $monto_t=cambia_coma_numero($monto_t);
      $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contable'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);  $mvalor=0;
      if ($filas==0){$mvalor=1; ?> <script language="JavaScript"> muestra('CUENTA TIPO DE ORDEN NO EXISTE');</script><? }
      else{$registro=pg_fetch_array($resultado); if ($registro["cargable"]=="N"){$mvalor=1; ?> <script language="JavaScript"> muestra('CUENTA TIPO DE ORDEN NO ES CARGABLE');</script><?} }
      if($mvalor==0){ $resultado=pg_exec($mconn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','C','$cod_contable','00000','',$monto_t,'D','C','N','01','0','')");
      $mvalor=pg_errormessage($mconn); $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? } }
    }
   }
return $mvalor;
}
?>