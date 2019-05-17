<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc");
error_reporting(E_ALL);$formato_presup="XX-XX-XX-XXX-XX-XX-XX";
$codigo_mov=$_POST["txtcodigo_mov"];$nro_orden=$_POST["txtnro_orden"];$tipo_causado=$_POST["txttipo_causado"];
$referencia_comp=$_POST["txtreferencia_comp"];$tipo_compromiso=$_POST["txttipo_compromiso"];$fecha=$_POST["txtfecha"];
$ced_rif=$_POST["txtced_rif"];$ced_rif_ces=$_POST["txtced_rif"];$nombre_ces=$_POST["txtnombre"];
$concepto=$_POST["txtconcepto"];$tipo_documento=$_POST["txttipo_documento"];$nro_documento=$_POST["txtnro_documento"];
$tipo_orden=$_POST["txttipo_orden"];$fecha_desde=$_POST["txtfecha"];$fecha_hasta=$_POST["txtfecha"];$fecha_vencim=$_POST["txtfecha_vencim"];
$caus_directo=$_POST["txtcaus_directo"];$cuenta_anticipo=$_POST["txtCodigo_Cuenta"];$func_inv=$_POST["txtfunc_inv"]; $pago_ces="N";
$monto_ord=$_POST["txtmonto"];$tasa=$_POST["txttasa_ant"];$total=formato_numero($monto_ord); $nro_aut=$_POST["txtnro_aut"]; 
if(is_numeric($total)){$total=$total;} else{$total=0;} $tasa=formato_numero($tasa);if(is_numeric($tasa)){$tasa=$tasa;} else{$tasa=0;}
if($func_inv=="CORRIENTE"){$func_inv="C";}else{if($func_inv=="INVERSION"){$func_inv="I";}else{$func_inv="N";}}
if($func_inv==""){$func_inv="CORRIENTE"; $func_inv=substr($func_inv,0,1);} $num_proyecto="0000000000";
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if (checkData($fecha_desde)=='1'){$error=$error;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DESDE NO ES VALIDA');</script><? }
if (checkData($fecha_hasta)=='1'){$error=$error;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA HASTA NO ES VALIDA');</script><? }
if (checkData($fecha_vencim)=='1'){$error=$error;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA VENCIMIENTO NO ES VALIDA');</script><? }
if (strlen($nro_orden)==8){$error=$error;} else{$error=1; ?> <script language="JavaScript">muestra('NUMERO DE ORDEN VALIDA');</script><? }
if ($error==0){  $sfecha=formato_aaaammdd($fecha);  $rfecha=$sfecha; $campo_str2=""; $campo_str1="";
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA');</script><?}
  if($error==0){ $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$l_cat=strlen($formato_cat); if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} }
    $campo502="NNNNNNNNNNNNNNNNNNNN";   $sql="Select campo502,campo503 from SIA005 where campo501='01'"; $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}}
    $gen_ord_ret=substr($campo502,0,1); $gen_comp_ret=substr($campo502,1,1); $gen_pre_ret=substr($campo502,2,1); $ant_presup=substr($campo502,14,1); $fecha_aut=substr($campo502,5,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
  }
  if($error==0){$fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)or($sfecha<$rfecha)){$error=1;?><script language="JavaScript">muestra('FECHA DE ORDEN INVALIDA');</script><?}
  }
  if($error==0){$nmes=substr($fecha,3, 2);
    if ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE ORDEN MENOR A ULTIMO PERIODO CERRADO');</script><?}
  }
  if($error==0){$sSQL="Select * from pre006 WHERE tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'";   $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE COMPROMISO NO EXISTE');</script><?}
    else{$registro=pg_fetch_array($resultado); $campo_str2=$referencia_comp; $campo_str1=$tipo_compromiso;}
  }
  if($error==0){$sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}
  }
  if($error==0){$StrSQL="select cod_contable_t,cod_banco_t from pag008 where tipo_orden='$tipo_orden'"; $res=pg_exec($conn,$StrSQL);$filas=pg_num_rows($res);
    if($filas>0){$reg=pg_fetch_array($res); $cod_contable=$reg["cod_contable_t"]; $cod_banco_t=$reg["cod_banco_t"];
      $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(2,'$codigo_mov','$nro_orden','$tipo_causado','$ced_rif','$tipo_orden','$cod_contable','NO')"); }
     else {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE ORDEN NO VALIDA');</script> <? }
  }
  $totalr=0;
  if($error==0){ $nro_cod_ret=0;
    $sql="Select * from cod_ret where codigo_mov='$codigo_mov' order by tipo_retencion";   $res=pg_query($sql);	
    while(($registro=pg_fetch_array($res))){ $nro_cod_ret=$nro_cod_ret+1; $tipo_retencion=$registro["tipo_retencion"]; $totalr=$totalr+$registro["monto_retencion"];
      $monto_asiento=$registro["monto_retencion"];$codigo_cuenta=$registro["cod_contable_ret"];$descripcion_ret=$registro["descripcion_ret"];
      if ($descripcion_ret==""){ $error=1;?><script language="JavaScript">muestra('TIPO DE RETENCION NO INVALIDA: <? echo $tipo_retencion; ?>'); </script> <?}
    }
    if($totalr<0){$error=1;?><script language="JavaScript">muestra('MONTO TOTAL DE RETENCION INVALIDO');</script><?}
    if($totalr>=$total) {$error=1; echo $total; ?><script language="JavaScript">muestra('TOTAL NETO DE LA ORDEN INVALIDO');</script><?}
  } $totaloc=0; $Status_1="N";  $Status_2="N"; $t_debe=0;
  if($error==0){
    $sql="SELECT * FROM CON008  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";   $res=pg_query($sql);  $t_debe=0; $t_haber=0;$balance=0;
    while($registro=pg_fetch_array($res)) {
      if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}       
    }
	if ($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
	if ($balance>0.001){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>"; ?><script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
    if (($t_debe==0)or($balance>0.001)){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
  } $totalop=0;
  if ($gen_comp_ret=="N"){$monto=($total+$totalr)-$t_debe; $monto=abs($monto);} else {$monto=($total-$t_debe); $monto=Abs($monto);}
  $rmonto = $total;
  if (($rmonto <> $t_debe) And ($monto > 0.001)) {$error=1;   ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA CON CAUSADO');</script><? }
  if (($error==0)And($nro_aut=="N")){
     $sql="Select nro_orden from PAG001 where nro_orden='$nro_orden'";   $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
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
  if($error==0){ 
    $sql="Select * from PAG001 where nro_orden>'$nro_orden'  and tipo_causado<='9999'";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
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
  if($error==0){
     $sfecha=formato_aaaammdd($fecha); $sfechad=formato_aaaammdd($fecha_desde); $sfechah=formato_aaaammdd($fecha_hasta); $sfechav=formato_aaaammdd($fecha_vencim);
     $total=cambia_coma_numero($total);  $totalr=cambia_coma_numero($totalr); $totalop=cambia_coma_numero($totalop);
     $sSQL="SELECT INCLUYE_ORDEN_ANTICIPO('$codigo_mov','$nro_orden','$tipo_causado','$sfecha','$ced_rif','$cod_contable','N','A','$tipo_documento','$nro_documento','$cod_banco_t',0,$total,$totalr,0,$totalop,'$tipo_orden','$num_proyecto','D','N','$func_inv','00','$ced_rif_ces','$nombre_ces','$pago_ces','','000','$sfechav','00','N',0,'$sfechad','$sfechah','S','$gen_comp_ret','$gen_pre_ret','$gen_ord_ret',0,$nro_cod_ret,'$Status_1','$Status_2','$campo_str1','$campo_str2',$tasa,0,'N','','$usuario_sia','','$minf_usuario','$nro_aut','$cuenta_anticipo','$statusc','$concepto')";  //echo $sSQL,"<br>";
	 $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error,0,91);
     if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
      else{ $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?
       $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $res=pg_exec($conn,"SELECT BORRAR_PAG028('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG029(4,'$codigo_mov','','','','','2007-01-01',0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','','','','')");$error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 (4,'$codigo_mov','','',0)");  $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
       $resultado=pg_exec($conn,"SELECT BORRAR_PAG038 ('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    }
  }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?><script language="JavaScript">document.location ='Act_orden_pago.php?Gcriterio=C<? echo $nro_orden.$tipo_causado; ?>';</script> <? }  else { ?> <script language="JavaScript">history.back();</script>  <? } 
?>