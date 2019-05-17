<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("G_Comp_Orden.php"); include ("../presupuesto/Ver_dispon.php");  include ("G_Comp_iva.php"); include ("G_Comp_islr.php");
include ("../class/configura.inc"); error_reporting(E_ALL);  $comp_automatico="S"; $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
$codigo_mov=$_POST["txtcodigo_mov"];$nro_orden=$_POST["txtnro_orden"]; $tipo_causado=$_POST["txttipo_causado"]; $fecha=$_POST["txtfecha"];$ced_rif=$_POST["txtced_rif"]; $ced_rif_ces=$_POST["txtced_rif_ces"]; $nombre_ces=$_POST["txtnombre_ces"];$concepto=$_POST["txtconcepto"];
$tipo_documento=$_POST["txttipo_documento"]; $nro_documento=$_POST["txtnro_documento"]; $nro_documento=substr($nro_documento,0,248);  $tipo_orden=$_POST["txttipo_orden"]; $fecha_desde=$_POST["txtfecha_desde"];
$fecha_hasta=$_POST["txtfecha_hasta"]; $fecha_vencim=$_POST["txtfecha_vencim"]; $nro_aut=$_POST["txtnro_aut"];$caus_directo=$_POST["txtcaus_directo"]; $func_inv=$_POST["txtfunc_inv"]; $pago_ces=$_POST["txtp_ces"]; $comp_automatico=$_POST["txtcomp_aut"];
$ord_per=$_POST["txtord_per"]; $ord_per=substr($ord_per,0,1); $per_permanente=$_POST["txtper_permanente"]; if(is_numeric($per_permanente)){$per_permanente=$per_permanente;} else{$per_permanente=0;}
$concepto=cambiar_car_especiales($concepto);
if($func_inv=="CORRIENTE"){$func_inv="C";}else{if($func_inv=="INVERSION"){$func_inv="I";}else{$func_inv="N";}}if($func_inv==""){$func_inv="C";} $comp_automatico=substr($comp_automatico,0,1); $num_proyecto="0000000000"; $unidad_sol="";
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if (checkData($fecha_desde)=='1'){$error=$error;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DESDE NO ES VALIDA');</script><? }
if (checkData($fecha_hasta)=='1'){$error=$error;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA HASTA NO ES VALIDA');</script><? }
if (checkData($fecha_vencim)=='1'){$error=$error;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA VENCIMIENTO NO ES VALIDA');</script><? }
if (strlen($nro_orden)==8){$error=$error;} else{$error=1; ?> <script language="JavaScript">muestra('NUMERO DE CAUSADO INVALIDA');</script><? }
if ($error==0){  $sfecha=formato_aaaammdd($fecha);  $rfecha=$sfecha; $campo_str2=""; $gen_comp_ret="N";
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname." ");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA');</script><?}
  if($error==0){ $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"]; $l_cat=strlen($formato_cat); if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}}
    $campo502="NNNNNNNNNNNNNNNNNNNN";   $sql="Select campo502,campo503 from SIA005 where campo501='01'"; $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} } $gen_ord_ret=substr($campo502,0,1); $gen_comp_ret=substr($campo502,1,1); $gen_pre_ret=substr($campo502,2,1); $ant_presup=substr($campo502,14,1);  $fecha_aut=substr($campo502,5,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if ($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
  } $total=0; $nro_cod_pre=0; $pasivo_comp="NO"; echo $gen_pre_ret;
  if($Cod_Emp=="58"){$ord_per=$ord_per; $per_permanente=$per_permanente;} else{$ord_per='N'; $per_permanente=0;}  
  $sSQL="Select * from PAG036 WHERE codigo_mov='$codigo_mov'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('INFORMACION DE LA CAUSADO NO VALIDA');</script> <? }
   else{ $registro=pg_fetch_array($resultado);  $pasivo_comp=$registro["pasivo_comp"]; $monto_am_ant=$registro["monto_am_ant"];  $cod_cont_ant=$registro["campo_str1"]; }
  if($error==0){  $sSQL="Select ref_compromiso from pre003 WHERE tipo_causado='$tipo_causado'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE CAUSADO NO EXISTE');</script><?}
     else{if(($tipo_causado=="0000")or(substr($tipo_causado,0,1)=='A')){$error=1;?><script language="JavaScript">  muestra('DOCUMENTO DE CAUSADO NO VALIDO');</script><?}
      else{ $registro=pg_fetch_array($resultado);  if(($caus_directo=="SI")and($registro["ref_compromiso"]=="SI")){echo $caus_directo; $error=1;?><script language="JavaScript">muestra('DOCUMENTO DE CAUSADO NO VALIDO');</script><?}
        if(($caus_directo=="NO")and($registro["ref_compromiso"]=="NO")){echo $caus_directo; $error=1;?><script language="JavaScript">muestra('DOCUMENTO DE CAUSADO NO VALIDO');</script><?}
      }}
  }
  if($error==0){if($caus_directo=="SI"){$referencia_comp=$nro_orden;$tipo_compromiso="0000";} }
  if (($error==0)And($nro_aut=="N")){  $sSQL="Select referencia_caus from pre007 WHERE referencia_caus='$nro_orden' and tipo_causado='$tipo_causado'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);    if ($filas>0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE CAUSADO YA EXISTE');</script><?}   }
  if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)or($sfecha<$rfecha)){$error=1;?><script language="JavaScript">muestra('FECHA DE CAUSADO INVALIDA');</script><?} }
  if($error==0){$nmes=substr($fecha,3, 2); if ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE CAUSADO MENOR A ULTIMO PERIODO CERRADO');</script><?} }
  if($error==0){  $sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);    if ($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}  }
  if(($error==0)and($pago_ces=="S")){ $sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif_ces'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);    if ($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF CESIONARIO NO EXISTE');</script><?}  }
  if($error==0){ $StrSQL="select cod_contable_t,cod_banco_t from pag008 where tipo_orden='$tipo_orden'";    $res=pg_exec($conn,$StrSQL);$filas=pg_num_rows($res);
    if($filas>0){$reg=pg_fetch_array($res); $cod_contable=$reg["cod_contable_t"]; $cod_banco_t=$reg["cod_banco_t"];
      $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(2,'$codigo_mov','$nro_orden','$tipo_causado','$ced_rif','$tipo_orden','$cod_contable','$pasivo_comp')"); }
     else {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE ORDEN NO VALIDA');</script> <? }
  }
  if($error==0){ $nro_cod_pre=0; $total=0;  $totalc=0; $sfecha=formato_aaaammdd($fecha);
    $sql="Select * from CODIGOS_PRE026 where codigo_mov='$codigo_mov' and monto>0 order by cod_presup";  $res=pg_query($sql);
	//echo $sql,"<br>";
    while($registro=pg_fetch_array($res)){ $nro_cod_pre=$nro_cod_pre+1;
      $totalc=$totalc+$registro["monto"];$cod_presup=$registro["cod_presup"];$fuente_financ=$registro["fuente_financ"];
      $monto_c=$registro["monto"];$ref_imput_presu=$registro["ref_imput_presu"];$monto_credito=$registro["monto_credito"];
      $tipo_imput_presu=$registro["tipo_imput_presu"]; $unidad_sol=substr($cod_presup,0, $l_cat);
      if($caus_directo=="SI"){ $fmonto=formato_monto($monto_c);
        if (verifica_disponibilidad($conn,$registro["cod_presup"],$registro["fuente_financ"],$fecha,$monto_c)==0){$error=0;}
         else{$error=1;?><script language="JavaScript">muestra('ERRRO EN EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>, MONTO: <? echo $fmonto; ?>');</script><?}
        if(($error==0)and($tipo_imput_presu=="C")){
          $sSQL="Select * from PRE010 WHERE (referencia_adicion='$ref_imput_presu') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";   $resc=pg_query($sSQL); $filas=pg_num_rows($resc);
          if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?> \n NO EXISTE EN LA EJECUCION DEL CREDITO ADICIONAL');</script><? }
           else{$regc=pg_fetch_array($resc);
             if($regc["disponible"]<$monto_credito) {$error=1; $dispon=$regc["disponible"]; $dispon=formato_monto($dispon); ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO:<? echo $reg["cod_presup"]; ?> FUENTE:<? echo $reg["fuente_financ"]; ?> REF.CREDITO:<? echo $reg["referencia_adicion"]; ?> \ncon Monto Mayor que Disponibilidad del Credito Adicional, Disponibilidad: <? echo $dispon; ?> ');</script><? }
          }
        }
      }else{   $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"];
        $sSQL="Select * from PRE036 WHERE (ref_imput_presu='$ref_imput_presu') and (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
        if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NO EXISTE EN EL COMPROMISO EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
         else{$registro=pg_fetch_array($resultado);  $compromiso=$registro["monto"]-$registro["causado"]-$registro["ajustado"];
            if ($compromiso>$monto_c){$diferencia=$compromiso-$monto_c; }else{$diferencia=$monto_c-$compromiso; }  $error_c='Referencia: '.$referencia_comp.' Codigo: '.$cod_presup.' Monto: '.$monto_c.' Saldo Compromiso: '.$compromiso.' Diferencia: '.$diferencia;
           if(($monto_c>$compromiso)and($diferencia>0.001)){$error=1; echo $error_c,"<br>"; ?> <script language="JavaScript"> muestra('MONTO A CAUSAR MAYOR AL MONTO DEL CODIGO POR COMPROMETER');</script><? }
         }
		if($error==0){
		   $sSQL="Select * from PRE007 WHERE (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (anulado='S') and (fecha_anu>'$sfecha')";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
		   if ($filas>0){echo "Referencia Compromiso: ".$referencia_comp; $error=1; ?> <script language="JavaScript"> muestra('EXISTEN CAUSADOS ANULADOS ASOCIADOS AL COMPROMISO CON FECHAS POSTERIOES ');</script><?}
		}		 
      }
    } $total=$totalc;
    if($total<=0){$error=1;?><script language="JavaScript">muestra('MONTO TOTAL DEL CAUSADO INVALIDO');</script><?}
  }
  echo 'Total Causado: '.formato_monto($total)." ".$caus_directo." ".$nro_cod_pre,"<br>";
  $totalr=0;
  if($error==0){ $nro_cod_ret=0; 
    $sqlgr="UPDATE PAG028 SET tipo_caus_ret='$tipo_causado' where codigo_mov='$codigo_mov'";
	if($caus_directo=="SI"){ $sqlgr="UPDATE PAG028 SET tipo_caus_ret='$tipo_causado',ref_comp_ret='$nro_orden' where codigo_mov='$codigo_mov'"; }
    $res=pg_exec($conn,$sqlgr);
    $sql="Select * from cod_ret where codigo_mov='$codigo_mov' order by tipo_retencion";   $res=pg_query($sql);
    while(($registro=pg_fetch_array($res))){ $nro_cod_ret=$nro_cod_ret+1; $tipo_retencion=$registro["tipo_retencion"];  $ced_rif_r=$registro["ced_rif_r"]; 
      $monto_asiento=$registro["monto_retencion"];$codigo_cuenta=$registro["cod_contable_ret"];$descripcion_ret=$registro["descripcion_ret"];
      if ($descripcion_ret==""){ $error=1;?><script language="JavaScript">muestra('TIPO DE RETENCION NO VALIDA: <? echo $tipo_retencion; ?>'); </script> <?}
      else{ $totalr=$totalr+$registro["monto_retencion"];
        $cod_presup=$registro["cod_presup_ret"]; $fuente_financ=$registro["fuente_fin_ret"]; $referencia_comp=$registro["ref_comp_ret"]; $tipo_compromiso=$registro["tipo_comp_ret"];
        if ($gen_pre_ret=="S"){  if($caus_directo=="SI"){ $referencia_comp="00000000"; }
			$sSQL="Select * from PRE026 WHERE codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and monto>0 order by ref_imput_presu";  $resr=pg_query($sSQL); $filasr=pg_num_rows($resr);
			if ($filasr==0){$error=1; echo $tipo_retencion." ".$cod_presup." ".$fuente_financ." ".$referencia_comp,"<br>"; echo $sSQL,"<br>"; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO DE LA RETENCION NO EXISTE EN EL CAUSADO');</script><? }
			else { $reg=pg_fetch_array($resr); $ref_imput_presu=$reg["ref_imput_presu"];  $monto_c=$reg["monto"]; $monto_credito=$reg["monto_credito"];
			  if (($gen_pre_ret=="S") and ($gen_ord_ret=="S")){ $monto_c=$monto_c-$monto_asiento;
			   if ($monto_c>=0) { if ($monto_credito>$monto_c) {$monto_credito=$monto_c;} $slqg="SELECT MOD_MONTO_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$ref_imput_presu',$monto_c,$monto_credito)";
				  $resg=pg_exec($conn,$slqg);   $err=pg_errormessage($conn);  $err="ERROR MODIFICANDO: ".substr($err, 0, 61); if (!$resg){ $error=1; ?><script language="JavaScript">muestra('<? echo $err; ?>');</script><? }
			   }else{$error=1;?><script language="JavaScript">muestra('CODIGO PRESUPUESTARIO DE RETENCION: <? echo $tipo_retencion; ?> INVALIDO' </script><?}
			  }
			}
		}
      }
	  if ($ced_rif_r==""){ $error=1;?><script language="JavaScript">muestra('CEDULA/RIF, DEL TIPO DE RETENCION NO VALIDA: <? echo $tipo_retencion; ?>'); </script> <?}
    }
    if($totalr<0){$error=1;?><script language="JavaScript">muestra('MONTO TOTAL DE RETENCION INVALIDO');</script><?}
    if($totalr>=$total) {$error=1;?><script language="JavaScript">muestra('TOTAL NETO DEL CAUSADO INVALIDO');</script><?}
  } $totaloc=0; $Status_1="N";  $Status_2="N";
  
  if($error==0){
    $sql="SELECT * FROM ord_ret_canc  where codigo_mov='$codigo_mov' and seleccionada='S' order by nro_orden_ret,tipo_retencion";  $res=pg_query($sql); $filas=pg_num_rows($res);
    if ($filas>0){ $pasivo_comp="NO";
       $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 (4,'$codigo_mov','','',0)");  $error=pg_errormessage($conn); $error=substr($error, 0, 91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(4,'$codigo_mov','$nro_orden','$tipo_causado','$ced_rif','$tipo_orden','','NO')");
       while(($registro=pg_fetch_array($res))){ $tipo_retencion=$registro["tipo_retencion"];  $totaloc=$totaloc+$registro["monto_retencion"]; $monto_asiento=$registro["monto_retencion"];  $codigo_cuenta=$registro["cod_contable_ret"];
       $sSQL="Select * from PAG030 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='D'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
       if ($filas>0){$reg=pg_fetch_array($resultado); $monto_asiento=$monto_asiento+$reg["monto_pasivo"]; $monto_asiento=cambia_coma_numero($monto_asiento);
          $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 ('2','$codigo_mov','$codigo_cuenta','D','$monto_asiento')");
          $err=pg_errormessage($conn);  $err="ERROR MODIFICANDO: ".substr($err, 0, 61); if (!$resultado){$error=1; ?><script language="JavaScript">muestra('<? echo $err; ?>');</script><? }}
        else{$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 ('1','$codigo_mov','$codigo_cuenta','D','$monto_asiento')");
          $err=pg_errormessage($conn);  $err="ERROR GRABANDO: ".substr($err, 0, 61); if (!$resultado){$error=1; ?><script language="JavaScript">muestra('<? echo $err; ?>');</script><? }}
       }
       if($totaloc>0){$Status_2="S"; If ($totalr>0){$error=1;?><script language="JavaScript">muestra('NO PUEDE TENER RETENCIONES Y CANCELACION DE RETENCIONES');</script><?} }
    }
  } $t_debe=0; $t_haber=0;$balance=0;
  if($error==0){ if (g_comprobante_ord($conn,$codigo_mov,$gen_comp_ret,$gen_ord_ret)==0){$error=0;} else{$error=1;}}
  if($error==0){$sql="SELECT * FROM CON008 where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";
    $res=pg_query($sql);  $t_debe=0; $t_haber=0;$balance=0;
    while($registro=pg_fetch_array($res)) { if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}}
    if ($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
    if ($balance>0.001){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
    if (($t_debe==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
  } $totalop=0; $t_dpas=0;  $t_hpas=0;
  if ($error==0) {
    if($pasivo_comp=="SI"){ $sql="SELECT * FROM pag030  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
      while($registro=pg_fetch_array($res)) {  if ($registro["debito_credito"]=="D"){$t_dpas=$t_dpas+$registro["monto_pasivo"]; $totalop=$totalop+$registro["monto_pasivo"];}else{$t_hpas=$t_hpas+$registro["monto_pasivo"]; $totalop=$totalop-$registro["monto_pasivo"];} }
    }
    if($pasivo_comp=="NO"){$sql="SELECT * FROM pag030  where codigo_mov='$codigo_mov' and debito_credito='D' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
      while($registro=pg_fetch_array($res)) { $totalop=$totalop+$registro["monto_pasivo"]; }
    }
  }
  if ($gen_comp_ret=="N"){$monto=($total+$totalr)-$t_debe; $monto=abs($monto);} else {$monto=($total-$t_debe); $monto=Abs($monto);}
  if ($Status_2=="N") {$monto=$monto-$t_dpas-$t_hpas;}  $rmonto=$total;
  if ($monto_am_ant==0) {$Status_1="N";} else {$Status_1="S";}
  if ($ant_presup=="S") {$rmonto=$rmonto+$monto_am_ant; $monto=$monto+$monto_am_ant;}
  if ($t_debe>$rmonto){$balance=$t_debe-$rmonto;}else{$balance=$rmonto-$t_debe;}
  //if (($rmonto <> $t_debe) And ($monto>0.001))
  if (($rmonto <> $t_debe) And ($balance>0.001)) {$error=1; $dif=0;
      if(($pasivo_comp=="SI"))  {  $Status_2="C"; if ($t_dpas>$balance){$dif=$t_dpas-$balance;}else{$dif=$balance-$t_dpas;}  
      if($dif>0.001){$error=1; }else{ $error=0;} } 
      if($error==1){echo $t_debe.' '.$rmonto.' '.formato_monto($balance)." ".$t_dpas." ".$pasivo_comp." ".formato_monto($dif),"<br>";  ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA CON CAUSADO');</script><? } }
  if (($error==0)And($nro_aut=="N")){
     $sql="Select nro_orden from PAG001 where nro_orden='$nro_orden'";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
     if ($filas>0){$error=1;?><script language="JavaScript">muestra('NUMERO DE ORDEN YA EXISTE');</script><?}
	 else{ $sql="Select max(fecha) as ult_fecha from PAG001 where nro_orden<'$nro_orden'  and tipo_causado<='9999'";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
        if ($filas>0){ $reg=pg_fetch_array($resultado); $ult_fecha=$reg["ult_fecha"]; $sfecha=formato_aaaammdd($fecha);
	      if($sfecha<$ult_fecha){$error=1; $fecha_up=formato_ddmmaaaa($ult_fecha); echo "Ultima Fecha:".$fecha_up; ?><script language="JavaScript">muestra('FECHA DE ORDEN MENOR A LA ANTERIOR');</script><?}
	    }
	 }
  }else{ if($nro_aut=="S"){ $ult_ref="00000001";
    $StrSQL="select max(nro_orden) as referencia from pag001"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
    if($filas>0){$registro=pg_fetch_array($resultado); $ult_ref=$registro["referencia"]+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;} $nro_orden=$ult_ref;  
  } } 
  //if (($error==0)And($nro_aut=="N")){
  if($error==0){ 
    $sql="Select * from PAG001 where nro_orden>'$nro_orden' and tipo_causado<='9999'";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
    if ($filas>0){ $sql="Select min(fecha) as ult_fecha from PAG001 where nro_orden>'$nro_orden'  and tipo_causado<='9999'";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
        $reg=pg_fetch_array($resultado); $ult_fecha=$reg["ult_fecha"]; $sfecha=formato_aaaammdd($fecha);
	    if($sfecha>$ult_fecha){$error=1; $fecha_up=formato_ddmmaaaa($ult_fecha); echo "Fecha proxima orden:".$fecha_up; ?><script language="JavaScript">muestra('FECHA DE ORDEN MAYOR A LA PROXIMA');</script><?}
	}	
  }
  if($error==0){ 
    $sql="Select max(fecha) as ult_fecha from PAG001 where nro_orden<'$nro_orden'  and tipo_causado<='9999'";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
    if ($filas>0){ $reg=pg_fetch_array($resultado); $ult_fecha=$reg["ult_fecha"]; $sfecha=formato_aaaammdd($fecha);
	   if($sfecha<$ult_fecha){$error=1; $fecha_up=formato_ddmmaaaa($ult_fecha); echo "Ultima Fecha:".$fecha_up; ?><script language="JavaScript">muestra('FECHA DE ORDEN MENOR A LA ANTERIOR');</script><?}
	}
  }
  if($error==0){ if(($ord_per=="S") and ($per_permanente<=0)){ $error=1;?><script language="JavaScript">muestra('NUMERO PERIODO DE ORDEN PERMANENTE INVALIDO');</script><? }  }
  if($error==0){  $sfecha=formato_aaaammdd($fecha); $sfechad=formato_aaaammdd($fecha_desde); $sfechah=formato_aaaammdd($fecha_hasta); $sfechav=formato_aaaammdd($fecha_vencim);   $total=cambia_coma_numero($total);  $totalr=cambia_coma_numero($totalr); $totalop=cambia_coma_numero($totalop);
     
	 //echo $statusc;

	 $sSQL="SELECT INCLUYE_ORDEN('$codigo_mov','$nro_orden','$tipo_causado','$sfecha','$ced_rif','$cod_contable','N','P','$tipo_documento','$nro_documento','$cod_banco_t',$monto_am_ant,$total,$totalr,0,$totalop,'$tipo_orden','$num_proyecto','D','S','$func_inv','00','$ced_rif_ces','$nombre_ces','$pago_ces','','000','$sfechav','00','$ord_per',$per_permanente,'$sfechad','$sfechah','S','$gen_comp_ret','$gen_pre_ret','$gen_ord_ret',$nro_cod_pre,$nro_cod_ret,'$Status_1','$Status_2','$cod_cont_ant','$campo_str2',0,$t_hpas,'N','','$usuario_sia','','$minf_usuario','$nro_aut','$unidad_sol','$statusc','$concepto')"; $resultado=pg_exec($conn,$sSQL);  $merror=pg_errormessage($conn);  $merror=substr($merror, 0, 91);
   //nmdb
   //echo $statusc.'<br>'.$sSQL;exit;

     if (!$resultado){ $error=1; ?><script language="JavaScript"> muestra('<? echo $merror; ?>');</script><? $error=1;}  else{ $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?       
	   /*
	   $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $res=pg_exec($conn,"SELECT BORRAR_PAG028('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $resultado=pg_exec($conn,"SELECT ELIMINA_CON022('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG029(4,'$codigo_mov','','','','','2007-01-01',0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','','','','')");$error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 (4,'$codigo_mov','','',0)");  $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $resultado=pg_exec($conn,"SELECT BORRAR_PAG038 ('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       */
//  GENERA COMPROBANTES DE RETENCION	   
	   if($comp_automatico=="S"){if (($error==0)And($nro_aut=="S")){ $StrSQL="select max(nro_orden) as referencia from pag001 where usuario_sia='$usuario_sia'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $nro_orden=$registro["referencia"];  }}
         if (g_comp_ret_iva($conn,$codigo_mov,$nro_orden,$minf_usuario)==0){$error=0;}     if (g_comp_ret_islr($conn,$codigo_mov,$nro_orden,'01',$minf_usuario)==0){$error=0;}
		/* if($Cod_Emp=="58"){		 
		   if(g_comp_ret_otro($conn,$codigo_mov,$nro_orden,'02','103',$minf_usuario)==0){$error=0;}
		   if(g_comp_ret_otro($conn,$codigo_mov,$nro_orden,'02','107',$minf_usuario)==0){$error=0;}
		   if(g_comp_ret_otro($conn,$codigo_mov,$nro_orden,'03','081',$minf_usuario)==0){$error=0;}
		   if(g_comp_ret_otro($conn,$codigo_mov,$nro_orden,'03','082',$minf_usuario)==0){$error=0;}
		   if(g_comp_ret_otro($conn,$codigo_mov,$nro_orden,'03','098',$minf_usuario)==0){$error=0;}
		   if(g_comp_ret_otro($conn,$codigo_mov,$nro_orden,'03','099',$minf_usuario)==0){$error=0;} 
		   if(g_comp_ret_otro($conn,$codigo_mov,$nro_orden,'04','105',$minf_usuario)==0){$error=0;} 
		   if(g_comp_ret_otro($conn,$codigo_mov,$nro_orden,'05','100',$minf_usuario)==0){$error=0;} 
		 }else{	 */
		 $cod_planilla="02";
		 $sql="SELECT distinct pag003.tipo_retencion,pag003.ret_grupo FROM pag003,pag004  where (pag003.ret_grupo='T' or pag003.ret_grupo='F' or pag003.ret_grupo='L'  or pag003.ret_grupo='R' or pag003.ret_grupo='E') and (pag004.tipo_retencion=pag003.tipo_retencion) and (nro_orden_ret='$nro_orden') order by pag003.tipo_retencion";$res=pg_query($sql);		 
         while($registro=pg_fetch_array($res)) { $tipo_retencion=$registro["tipo_retencion"]; $ret_grupo=$registro["ret_grupo"]; $cod_planilla="00";
		    if($ret_grupo=="T"){$cod_planilla="02";} //TIMBRE FISCAL
			if($ret_grupo=="F"){$cod_planilla="03";} //FIEL CUMPLIMIENTO
			if($ret_grupo=="R"){$cod_planilla="04";} //FONDO DE RESPONSABILIDAD SOCIAL
			if($ret_grupo=="L"){$cod_planilla="05";} //RETENCION LABORAL
			if($ret_grupo=="E"){$cod_planilla="06";} //ACTIVIDADES ECONOMICAS
			if($ret_grupo=="M"){$cod_planilla="07";} //MINERALES NO METALICOS - GOB LARA
			if($tipo_retencion=="350"){$cod_planilla="08";} //PARTICIPACION CIUDADANA - IMAUBAR
			$sSQL="SELECT codigo from ban011 WHERE codigo='$cod_planilla'";  $res11=pg_exec($conn,$sSQL); $filas=pg_numrows($res11);			
            if($filas>0){if(g_comp_ret_otro($conn,$codigo_mov,$nro_orden,$cod_planilla,$tipo_retencion,$minf_usuario)==0){$error=0;}  }
		 }
		 //}         
       }
  }}
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);
//nmdb
//exit;
/*  */
if ($error==0){?><script language="JavaScript">document.location ='Act_orden_pago.php?Gcriterio=C<? echo $nro_orden.$tipo_causado; ?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } 

 ?>
