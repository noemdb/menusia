<?php
function verifica_disponibilidad($mconn,$mcodigo,$mfuente,$mfecha,$amonto){
 $mvalor=0; $nmes = substr($mfecha,3, 2); $sfecha=formato_aaaammdd($mfecha); $fmonto=formato_monto($amonto);
 $SQL="Select * from pre001 WHERE cod_presup='$mcodigo' and cod_fuente='$mfuente'"; $resp=pg_exec($mconn,$SQL);$filas=pg_numrows($resp);
 if ($filas>=1){ $regp=pg_fetch_array($resp);
    $disponibleG = $regp["disponible"]; $disponible=$regp["disponible"];  $disponibleDG=$regp["disponible"]-$regp["diferido"];  $disponibleD = $regp["disponible"] - $regp["diferido"];
    $C_Diponib = "A";
    if ($C_Diponib = "A"){ $disponible=0; $diferido=0;
       for ($i=1; $i<=12; $i++) {$spos=$i;  If ($i<=9){$spos="0".$spos;}
         $disponible = $disponible + $regp["asignado".$spos];
         If ($i<$nmes) {
            $disponible = $disponible + $regp["traslados".$spos] - $regp["trasladon".$spos];
            $disponible = $disponible + $regp["adicion".$spos] - $regp["disminucion".$spos];
            $disponible = $disponible - $regp["compromiso".$spos];
			$diferido=$diferido+$regp["diferido".$spos];
			$temp_compromiso=$regp["compromiso".$spos];
			$temp_diferido=$regp["diferido".$spos];	
         }          
         If($i==$nmes){
		   $temp_compromiso=$regp["compromiso".$spos];  $dfecha=substr($sfecha,0, 8)."01";		   
		   /* */
		   //echo $temp_compromiso,"<br>";
		   
		   if($temp_compromiso<>0){$sqlc="select monto from pre036 where (cod_presup='$mcodigo' and fuente_financ='$mfuente') And (fecha_compromiso>='$dfecha' and fecha_compromiso<='$sfecha')"; $resc=pg_exec($mconn,$sqlc);$filasc=pg_numrows($resc);
           //echo $sqlc." ".$filasc,"<br>";
		   if ($filasc>=1){ $sqlc="select sum(monto) AS mmonto from pre036 where (cod_presup='$mcodigo' and fuente_financ='$mfuente') And (fecha_compromiso>='$dfecha' and fecha_compromiso<='$sfecha')"; $resc=pg_exec($mconn,$sqlc);$filasc=pg_numrows($resc);
              if ($filasc>=1){$reg=pg_fetch_array($resc);$temp_compromiso=$reg["mmonto"];}
		   }else{$temp_compromiso=0;} 
		   $temp_ajuste_compromiso=0;
		   $sqlc="select monto from pre011,pre031 where (pre011.referencia_ajuste=pre031.referencia_ajuste and pre011.tipo_ajuste=pre031.tipo_ajuste and pre011.tipo_pago=pre031.tipo_pago and pre011.referencia_pago=pre031.referencia_pago and pre011.tipo_causado=pre031.tipo_causado and pre011.referencia_caus=pre031.referencia_caus and pre011.tipo_compromiso=pre031.tipo_compromiso and pre011.referencia_comp=pre031.referencia_comp) and (pre011.referencia_comp<>'' and pre011.referencia_comp<>'00000000' and pre011.tipo_pago='0000' and pre011.tipo_causado='0000') and (pre031.cod_presup='$mcodigo' and pre031.fuente_financ='$mfuente') And (pre011.fecha_ajuste>='$dfecha' and pre011.fecha_ajuste<='$sfecha')"; $resc=pg_exec($mconn,$sqlc);$filasc=pg_numrows($resc);
           //echo $sqlc." ".$filasc,"<br>";
		   if ($filasc>=1){ $sqlc="select sum(monto) AS mmonto from pre011,pre031 where (pre011.referencia_ajuste=pre031.referencia_ajuste and pre011.tipo_ajuste=pre031.tipo_ajuste and pre011.tipo_pago=pre031.tipo_pago and pre011.referencia_pago=pre031.referencia_pago and pre011.tipo_causado=pre031.tipo_causado and pre011.referencia_caus=pre031.referencia_caus and pre011.tipo_compromiso=pre031.tipo_compromiso and pre011.referencia_comp=pre031.referencia_comp) and (pre011.referencia_comp<>'' and pre011.referencia_comp<>'00000000' and pre011.tipo_pago='0000' and pre011.tipo_causado='0000') and (pre031.cod_presup='$mcodigo' and pre031.fuente_financ='$mfuente') And (pre011.fecha_ajuste>='$dfecha' and pre011.fecha_ajuste<='$sfecha')"; $resc=pg_exec($mconn,$sqlc);$filasc=pg_numrows($resc);
              if ($filasc>=1){$reg=pg_fetch_array($resc);$temp_ajuste_compromiso=$reg["mmonto"];}
		   }
		   //echo "C ".$temp_compromiso,"<br>";
		   $temp_compromiso=$temp_compromiso-$temp_ajuste_compromiso;
		   //echo "A ".$temp_compromiso,"<br>";
		   }  		   
		   /*	*/	 
           //echo " Disponible:".$disponible.' Mes:'.$nmes,"<br>";		   
           $disponible=$disponible-$temp_compromiso;   $mdiferencia=0;
           //echo "Codigo:".$mcodigo." Fuente:".$mfuente." ".$disponible.' '.$nmes.' '.$temp_compromiso.' '.$dfecha.' '.$sfecha,"<br>";
		   echo " Disponible:".$disponible.' Mes:'.$nmes.' Compromiso:'.$temp_compromiso,"<br>";
           If (($regp["traslados".$spos] > 0) Or ($regp["adicion".$spos] > 0)){
              $StrSQL = "SELECT sum(monto) AS mmonto from pre009 WHERE (operacion='+') And (modif_aprob='S') And (anulado='N') And (cod_presup='$mcodigo' and cod_fuente='$mfuente') And (fecha_modif<='$sfecha') And (Month(fecha_modif)=$nmes)";
              $StrSQL = "SELECT sum(monto) AS mmonto from pre009,pre039 Where (pre009.referencia_modif=pre039.referencia_modif) and (pre009.tipo_modif=pre039.tipo_modif) and (pre039.operacion='+') And (pre009.modif_aprob='S') And (pre009.anulado='N') And (pre039.cod_presup='$mcodigo') and (pre039.Fuente_Financ='$mfuente') And (pre009.fecha_modif<='$sfecha') And (extract(month from pre009.fecha_Modif)=$nmes)";
              $res=pg_exec($mconn,$StrSQL); $filas=pg_numrows($res);  
              if ($filas>=1){$reg=pg_fetch_array($res);$mdiferencia=$mdiferencia+$reg["mmonto"];}
           }
           If (($regp["disminucion".$spos] > 0) Or ($regp["trasladon".$spos] > 0)){
              //$StrSQL = "SELECT sum(monto) AS mmonto from pre009 WHERE (operacion='+') And (modif_aprob='S') And (anulado='N') And (cod_presup='$mcodigo' and cod_fuente='$mfuente') And (fecha_modif<='$sfecha') And (Month(fecha_modif)=$nmes)";  $res=pg_exec($mconn,$StrSQL);$filas=pg_numrows($res);
              $StrSQL = "SELECT sum(monto) AS mmonto from pre009,pre039 Where (pre009.referencia_modif=pre039.referencia_modif) and (pre009.tipo_modif=pre039.tipo_modif) and (pre039.operacion='-') And (pre009.modif_aprob='S') And (pre009.anulado='N') And (pre039.cod_presup='$mcodigo') and (pre039.Fuente_Financ='$mfuente') And (pre009.fecha_modif<='$sfecha') And (extract(month from pre009.fecha_Modif)=$nmes)";
              $res=pg_exec($mconn,$StrSQL); $filas=pg_numrows($res);  
			  if ($filas>=1){$reg=pg_fetch_array($res);$mdiferencia=$mdiferencia-$reg["mmonto"];}
           }
           $disponible=$disponible+$mdiferencia;
		   //echo " Disponible:".$disponible.' Mes:'.$nmes." ".$mdiferencia,"<br>";	
		   //$diferido=$diferido+$regp["diferido".$spos];
		   $temp_diferido=$regp["diferido".$spos];		   
		   if($temp_diferido>0){  $sqlc="select pre033.monto_diferido from pre023,pre033 where (pre023.referencia_dife=pre033.referencia_dife and pre023.tipo_diferido=pre033.tipo_diferido  and pre023.status_2<>'L') and (pre033.cod_presup='$mcodigo' and pre033.fuente_financ='$mfuente') And (pre023.fecha_diferido>='$dfecha' and pre023.fecha_diferido<='$sfecha')"; $resc=pg_exec($mconn,$sqlc);$filasc=pg_numrows($resc);
           if ($filasc>=1){ $sqlc="select sum(pre033.monto_diferido) AS mmonto from pre023,pre033 where (pre023.referencia_dife=pre033.referencia_dife and pre023.tipo_diferido=pre033.tipo_diferido  and pre023.status_2<>'L') and (pre033.cod_presup='$mcodigo' and pre033.fuente_financ='$mfuente') And (pre023.fecha_diferido>='$dfecha' and pre023.fecha_diferido<='$sfecha')"; $resc=pg_exec($mconn,$sqlc);$filasc=pg_numrows($resc);
              if ($filasc>=1){$reg=pg_fetch_array($resc);$temp_diferido=$reg["mmonto"];}
		   } }		   
		   $diferido=$diferido+$temp_diferido;		   
         }
		 //$diferido=$diferido+$regp["diferido".$spos];
         $disponibleD=$disponible-$diferido;		 
		 //echo "Codigo:".$mcodigo." ".$i." Fuente:".$mfuente." Disponible:".$disponible." Diferido:".$disponibleD.' Mes:'.$nmes.' Compromiso:'.$temp_compromiso.'  '.$amonto.'  '.$diferido.' '.$temp_diferido,"<br>";
       }
    }
 }else{$mvalor=1; echo "Codigo:".$mcodigo." Fuente:".$mfuente,"<br>"; ?> <script language="JavaScript">muestra('CODIGO PRESUPUESTARIO NO EXISTE');</script> <? }
 if ($mvalor==0){ $mdiferencia=abs($disponibleG-$amonto);
    if (($amonto>$disponibleG) And ($mdiferencia>0.009)){ $mvalor=1; $dispon=$disponibleG; $dispon=formato_monto($dispon);  $disponD=$disponibleDG; $disponD=formato_monto($disponD); echo "Codigo:".$mcodigo." Fuente:".$mfuente;
       ?> <script language="JavaScript"> muestra('Monto Mayor que Disponibilidad Global, \ncon Disponibilidad Actual: <? echo $dispon; ?> , Disponibilidad Actual Diferida: <? echo $disponD; ?> \n Requiere: <? echo $fmonto; ?>');</script><?}
     else{$mdiferencia=abs($disponible-$amonto);
       if (($amonto>$disponible) And ($mdiferencia>0.009)){ $mvalor=1; $dispon=$disponible; $dispon=formato_monto($dispon); $disponD=$disponibleD; $disponD=formato_monto($disponD); echo "Codigo:".$mcodigo." Fuente:".$mfuente;
         ?> <script language="JavaScript"> muestra('Monto Mayor que Disponibilidad de Distribucion, \ncon Disponibilidad Actual: <? echo $dispon; ?> , Disponibilidad Actual Diferida: <? echo $disponD; ?> \n Requiere: <? echo $fmonto; ?>');</script><?}
     }
 }
 if ($mvalor==0){ $mdiferencia=abs($disponibleDG-$amonto);
    if (($amonto>$disponibleDG) And ($mdiferencia>0.009)){ $mvalor=1; $dispon=$disponibleDG; $dispon=formato_monto($dispon);
       ?> <script language="JavaScript"> muestra('Monto Mayor que Disponibilidad Global Diferida, \ncon Disponibilidad Actual Diferida: <? echo $dispon; ?> \n Requiere: <? echo $fmonto; ?>');</script><?}
     else{$mdiferencia=abs($disponibleD-$amonto);
       if (($amonto>$disponibleD) And ($mdiferencia>0.009)){ $mvalor=1; $dispon=$disponibleD; $dispon=formato_monto($dispon);
         ?> <script language="JavaScript"> muestra('Monto Mayor que Disponibilidad de Distribucion Diferida, \ncon Disponibilidad Actual Diferida: <? echo $dispon; ?> \n Requiere: <? echo $fmonto; ?>');</script><?}
     }
 }
 return $mvalor;
}

function verifica_disponibilidad_dif($mconn,$mcodigo,$mfuente,$mfecha,$amonto,$dmonto){
 $mvalor=0; $nmes = substr($mfecha,3, 2); $sfecha=formato_aaaammdd($mfecha); $fmonto=formato_monto($amonto);
 $SQL="Select * from pre001 WHERE cod_presup='$mcodigo' and cod_fuente='$mfuente'"; $resp=pg_exec($mconn,$SQL);$filas=pg_numrows($resp);
 if ($filas>=1){ $regp=pg_fetch_array($resp);
    $disponibleG=$regp["disponible"]; $disponible=$regp["disponible"];  $disponibleDG=$regp["disponible"]-$regp["diferido"]+$dmonto;  $disponibleD=$regp["disponible"]- $regp["diferido"];
    $C_Diponib = "A";
    if ($C_Diponib = "A"){ $disponible = 0; $diferido = 0;
       for ($i=1; $i<=12; $i++) {$spos = $i;  If ($i<=9){$spos="0".$spos;}
         $disponible = $disponible + $regp["asignado".$spos];
         If ($i<$nmes) {
            $disponible = $disponible + $regp["traslados".$spos] - $regp["trasladon".$spos];
            $disponible = $disponible + $regp["adicion".$spos] - $regp["disminucion".$spos];
            $disponible = $disponible - $regp["compromiso".$spos];
         }          
         If($i==$nmes){
           $disponible=$disponible-$regp["compromiso".$spos];   $mdiferencia=0;
           echo "Codigo:".$mcodigo." Fuente:".$mfuente." ".$disponible.' '.$nmes.' '.$regp["adicion".$spos],"<br>";
           If (($regp["traslados".$spos] > 0) Or ($regp["adicion".$spos] > 0)){
              $StrSQL = "SELECT sum(monto) AS mmonto from pre009 WHERE (operacion='+') And (modif_aprob='S') And (anulado='N') And (cod_presup='$mcodigo' and cod_fuente='$mfuente') And (fecha_modif<='$sfecha') And (Month(fecha_modif)=$nmes)";
              $StrSQL = "SELECT sum(monto) AS mmonto from pre009,pre039 Where (pre009.referencia_modif=pre039.referencia_modif) and (pre009.tipo_modif=pre039.tipo_modif) and (pre039.operacion='+') And (pre009.modif_aprob='S') And (pre009.anulado='N') And (pre039.cod_presup='$mcodigo') and (pre039.Fuente_Financ='$mfuente') And (pre009.fecha_modif<='$sfecha') And (extract(month from pre009.fecha_Modif)=$nmes)";
              $res=pg_exec($mconn,$StrSQL); $filas=pg_numrows($res);  
              if ($filas>=1){$reg=pg_fetch_array($res);$mdiferencia=$mdiferencia+$reg["mmonto"];}
           }
           If (($regp["disminucion".$spos] > 0) Or ($regp["trasladon".$spos] > 0)){
              //$StrSQL = "SELECT sum(monto) AS mmonto from pre009 WHERE (operacion='+') And (modif_aprob='S') And (anulado='N') And (cod_presup='$mcodigo' and cod_fuente='$mfuente') And (fecha_modif<='$sfecha') And (Month(fecha_modif)=$nmes)";  $res=pg_exec($mconn,$StrSQL);$filas=pg_numrows($res);
              $StrSQL = "SELECT sum(monto) AS mmonto from pre009,pre039 Where (pre009.referencia_modif=pre039.referencia_modif) and (pre009.tipo_modif=pre039.tipo_modif) and (pre039.operacion='-') And (pre009.modif_aprob='S') And (pre009.anulado='N') And (pre039.cod_presup='$mcodigo') and (pre039.Fuente_Financ='$mfuente') And (pre009.fecha_modif<='$sfecha') And (extract(month from pre009.fecha_Modif)=$nmes)";
              $res=pg_exec($mconn,$StrSQL); $filas=pg_numrows($res);  
			  if ($filas>=1){$reg=pg_fetch_array($res);$mdiferencia=$mdiferencia-$reg["mmonto"];}
           }
           $disponible=$disponible+$mdiferencia;
         }
         $diferido=$diferido+$regp["diferido".$spos]; $disponibleD=$disponible-$diferido; 
       }
	   $diferido=$diferido-$dmonto; $disponibleD=$disponible-$diferido;
    }
 }else{$mvalor=1; echo "Codigo:".$mcodigo." Fuente:".$mfuente,"<br>"; ?> <script language="JavaScript">muestra('CODIGO PRESUPUESTARIO NO EXISTE');</script> <? }
 if ($mvalor==0){ $mdiferencia=abs($disponibleG-$amonto);
    if (($amonto>$disponibleG) And ($mdiferencia>0.009)){ $mvalor=1; $dispon=$disponibleG; $dispon=formato_monto($dispon);  $disponD=$disponibleDG; $disponD=formato_monto($disponD); echo "Codigo:".$mcodigo." Fuente:".$mfuente;
       ?> <script language="JavaScript"> muestra('Monto Mayor que Disponibilidad Global, \ncon Disponibilidad Actual: <? echo $dispon; ?> , Disponibilidad Actual Diferida: <? echo $disponD; ?> \n Requiere: <? echo $fmonto; ?>');</script><?}
     else{$mdiferencia=abs($disponible-$amonto);
       if (($amonto>$disponible) And ($mdiferencia>0.009)){ $mvalor=1; $dispon=$disponible; $dispon=formato_monto($dispon); $disponD=$disponibleD; $disponD=formato_monto($disponD); echo "Codigo:".$mcodigo." Fuente:".$mfuente;
         ?> <script language="JavaScript"> muestra('Monto Mayor que Disponibilidad de Distribucion, \ncon Disponibilidad Actual: <? echo $dispon; ?> , Disponibilidad Actual Diferida: <? echo $disponD; ?> \n Requiere: <? echo $fmonto; ?>');</script><?}
     }
 }
 if ($mvalor==0){ $mdiferencia=abs($disponibleDG-$amonto);
    if (($amonto>$disponibleDG) And ($mdiferencia>0.009)){ $mvalor=1; $dispon=$disponibleDG; $dispon=formato_monto($dispon);
       ?> <script language="JavaScript"> muestra('Monto Mayor que Disponibilidad Global Diferida, \ncon Disponibilidad Actual Diferida: <? echo $dispon; ?> \n Requiere: <? echo $fmonto; ?>');</script><?}
     else{$mdiferencia=abs($disponibleD-$amonto);
       if (($amonto>$disponibleD) And ($mdiferencia>0.009)){ $mvalor=1; $dispon=$disponibleD; $dispon=formato_monto($dispon);
         ?> <script language="JavaScript"> muestra('Monto Mayor que Disponibilidad de Distribucion Diferida, \ncon Disponibilidad Actual Diferida: <? echo $dispon; ?> \n Requiere: <? echo $fmonto; ?>');</script><?}
     }
 }
 return $mvalor;
}
?>