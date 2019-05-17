<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("Ver_dispon.php"); include ("../class/configura.inc");
error_reporting(E_ALL);$formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $cod_comp="0000"; $fecha_hoy=asigna_fecha_hoy(); $aprobado="S";
$codigo_mov=$_POST["txtcodigo_mov"];  $referencia_comp=$_POST["txtreferencia_comp"]; $tipo_compromiso=$_POST["txttipo_compromiso"];
$referencia_dife=$_POST["txtreferencia_dife"]; $tipo_diferido=$_POST["txttipo_diferido"];
$fecha_compromiso=$_POST["txtfecha"]; $unidad_sol=$_POST["txtunidad_sol"]; $cod_tipo_comp=$_POST["txtcod_tipo_comp"];
$ced_rif=$_POST["txtced_rif"];$descripcion_comp=$_POST["txtDescripcion"]; $nro_documento=$_POST["txtnro_documento"];
$fecha_vencim=$_POST["txtfecha_vencim"]; $num_proyecto="0000000000"; $func_inv=$_POST["txtfunc_inv"];
if($func_inv=="CORRIENTE"){$func_inv="C";}else{if($func_inv=="INVERSION"){$func_inv="I";}else{$func_inv="N";}}
$tiene_anticipo=$_POST["txttiene_anticipo"];$tiene_anticipo=substr($tiene_anticipo,0,1);  $tasa_anticipo=$_POST["txttasa_anticipo"];
$cod_con_anticipo=$_POST["txtCodigo_Cuenta"]; $nro_aut=$_POST["txtnro_aut"]; $fecha_aut=$_POST["txtfecha_aut"];  $cod_est=$_POST["txtcod_est"];
$tasa_anticipo=formato_numero($tasa_anticipo); if(is_numeric($tasa_anticipo)){$tasa_anticipo=$tasa_anticipo;}else{$tasa_anticipo=0;}
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha_compromiso)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if (checkData($fecha_vencim)=='1'){$error=$error;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA VENCIMIENTO NO ES VALIDA');</script><? }
if ($error==0){ if($fecha_aut=="S"){$fecha_compromiso=$fecha_hoy;}   $sfecha=formato_aaaammdd($fecha_compromiso);
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA');</script><?}  
  $sql="Select * from SIA005 where campo501='09'";$resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){$tipo_doc_oc=$registro["campo504"]; $tipo_doc_os=$registro["campo505"];  }
  
  $campo502=""; $g_comprobante="N"; $cod_con_g_pagar=""; $status="";
  if($error==0){ $l_cat=0; $sql="Select campo502,campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"]; $campo502=$registro["campo502"];
	    $l_cat=strlen($formato_cat); if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}}		
	$g_comprobante=substr($campo502,3,1);
  }  
  
  if($error==0){
    $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
    if(($tipo_compromiso==$tipo_doc_oc)or($tipo_compromiso==$tipo_doc_os)){ $error=1;?><script language="JavaScript">  muestra('DOCUMENTO DE COMPROMISO NO VALIDO');</script><? }
  }  
  if($error==0){$sSQL="Select * from pre002 WHERE tipo_compromiso='$tipo_compromiso'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE COMPROMISO NO EXISTE');</script><?}
     else{if(($tipo_compromiso=="0000")or(substr($tipo_compromiso,0,1)=='A')){$error=1;?><script language="JavaScript">  muestra('DOCUMENTO DE COMPROMISO NO VALIDO');</script><?}}
  }
  if(($error==0)and($nro_aut=="N")) {
    $sSQL="Select referencia_comp from pre006 WHERE referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and fecha_compromiso='$sfecha' and cod_comp='$cod_comp'"; 
	$sSQL="Select referencia_comp from pre006 WHERE referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'"; 	
	$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas>0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE COMPROMISO YA EXISTE');</script><?}
	else{	 
	  $sql="Select max(fecha_compromiso) as ult_fecha from pre006 where referencia_comp<'$referencia_comp'  and  tipo_compromiso='$tipo_compromiso'";  $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
      if ($filas>0){ $reg=pg_fetch_array($resultado); $ult_fecha=$reg["ult_fecha"]; 
	      if($sfecha<$ult_fecha){$error=1; $fecha_up=formato_ddmmaaaa($ult_fecha); echo "Ultima Fecha: ".$fecha_up; ?><script language="JavaScript">muestra('FECHA DE COMPROMISO MENOR AL ANTERIOR');</script><?}
	  }	  
	}  
  }
  if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer); $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE COMPROMISO INVALIDA');</script><?}
  }  
  if($error==0){$nmes=substr($fecha_compromiso,3, 2);
    if ($SIA_Periodo>$nmes){echo "Ultimo Periodo: ".$SIA_Periodo." Periodo del Compromiso: ".$nmes; $error=1;?><script language="JavaScript">muestra('FECHA DE COMPROMISO MENOR A ULTIMO PERIODO CERRADO');</script><?}
  }  
  if($error==0){ $sSQL="Select cod_presup_cat,cod_fuente_cat,denominacion_cat from pre019 WHERE cod_presup_cat='$unidad_sol'";
    $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('CODIGO DE CATEGORIA PRESUPUESTARIA NO EXISTE');</script><?}
  }
  if($error==0){ $sSQL="SELECT tipo_comp,cod_contable from pre016 WHERE tipo_comp='$cod_tipo_comp'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('CODIGO TIPO DE COMPROMISO NO EXISTE');</script><?}
	 else{ $registro=pg_fetch_array($resultado);  $cod_con_g_pagar=$registro["cod_contable"]; }
  }
  if($error==0){ $sSQL="SELECT ced_rif from pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}
  }
  if(($error==0)and($tiene_anticipo=="S")){ $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_con_anticipo'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE ANTICIPO NO EXISTE');</script><? }
      else{ $registro=pg_fetch_array($resultado); if($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE ANTICIPO NO ES CARGABLE');</script><?}
      }
    }else{$cod_con_anticipo="";$tasa_anticipo=0;}
  if (strlen($referencia_comp)==8){$error=$error;} else{$error=1; ?> <script language="JavaScript">muestra('REFERENCIA DE COMPROMISO INVALIDA');</script><? }
  
  if($error==0){ $sql="Select * from CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup"; $res=pg_query($sql);  $total=0; $sfecha=formato_aaaammdd($fecha_compromiso);
    while(($registro=pg_fetch_array($res))and($error==0)){$total=$total+$registro["monto"];$cod_presup=$registro["cod_presup"];$fuente_financ=$registro["fuente_financ"];
      $monto_c=$registro["monto"];$ref_imput_presu=$registro["ref_imput_presu"];$monto_credito=$registro["monto_credito"]; $tipo_imput_presu=$registro["tipo_imput_presu"]; $monto_presup=$registro["monto_presup"];  
      if (verifica_disponibilidad_dif($conn,$registro["cod_presup"],$registro["fuente_financ"],$fecha_compromiso,$monto_c,$monto_presup)==0){$error=0;}
       else{$error=1;?><script language="JavaScript">muestra('ERROR EN CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
      if(($error==0)and($tipo_imput_presu=="C")){
        $sSQL="Select * from PRE010 WHERE (referencia_adicion='$ref_imput_presu') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')"; $resusltado=pg_query($sSQL); $filas=pg_num_rows($resusltado);
        if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?> \ncon NO EXISTE EN LA EJECUCION DEL CREDITO ADICIONAL');</script><? }
         else{$reg=pg_fetch_array($resusltado);
           if($reg["disponible"]<$monto_credito) {$error=1; $dispon=$registro["disponible"]; $dispon=formato_monto($dispon); ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?> \ncon Monto Mayor que Disponibilidad del Credito Adicional, Disponibilidad: <? echo $dispon; ?> ');</script><? }
        }
      }
	  if(($error==0)and($g_comprobante=="S")){ $monto_asiento=$registro["monto"]; $codigo_cuenta=$registro["cod_contable"];
	    $sSQL="Select * from CON008 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
		if ($filas>0){ $reg=pg_fetch_array($resultado);
           $monto_c=$monto_asiento+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c);
           $resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON008('$codigo_mov','D','$codigo_cuenta',$monto_c,'COMPROMISO PRESUPUESTARIO')");
           $mvalor=pg_errormessage($conn);  $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? } }
         else{ $resultado=pg_exec($conn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','D','$codigo_cuenta','00000','',$monto_asiento,'D','C','N','01','0','COMPROMISO PRESUPUESTARIO')");
          $mvalor=pg_errormessage($conn); $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61);   if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? }}
      }
    }
    if($total==0){$error=1;?><script language="JavaScript">muestra('MONTO TOTAL DEL COMPROMISO INVALIDO');</script><?}
  }  
  if($error==0){ $sSQL="Select * from pre023 WHERE referencia_dife='$referencia_dife' and tipo_diferido='$tipo_diferido'";  $resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE MOVIMIENTO DIFERIDO NO EXISTE');</script><?}
     else{ $registro=pg_fetch_array($resultado); $fecha_diferido=$registro["fecha_diferido"]; }
  } 
  if(($error==0)and($g_comprobante=="S")){ $monto_c=cambia_coma_numero($total); $status="D";  
    $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_con_g_pagar'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
    if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE GASTO NO EXISTE');</script><? }
    else{$registro=pg_fetch_array($resultado);if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE GASTO NO ES CARGABLE');</script><?}}
	if($error==0){$resultado=pg_exec($conn,"SELECT INCLUYE_CON008('$codigo_mov','00000000','C','$cod_con_g_pagar','00000','',$total,'D','C','N','01','0','COMPROMISO PRESUPUESTARIO')");
    $mvalor=pg_errormessage($conn); $mvalor="ERROR GRABANDO: ".substr($mvalor, 0, 61);   if (!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><? }   }	
  }
  if($error==0){$sfecha=formato_aaaammdd($fecha_compromiso); $fechav=formato_aaaammdd($fecha_vencim);   
     $sSQL="SELECT INCLUYE_PRE006('$codigo_mov','$referencia_comp','$tipo_compromiso','$cod_comp','$sfecha','$cod_tipo_comp','$referencia_comp','$num_proyecto','','$nro_documento','$unidad_sol','$ced_rif','$fechav','N',0,'M','$sfecha','$func_inv','$g_comprobante','$cod_con_g_pagar','$tiene_anticipo','$cod_con_anticipo',0,$tasa_anticipo,0,'P','P','$aprobado','$status','','$minf_usuario','$descripcion_comp','$nro_aut','$cod_est')";
     $sSQL="SELECT INCLUYE_PRE006_DIFE('$codigo_mov','$referencia_comp','$tipo_compromiso','$cod_comp','$sfecha','$cod_tipo_comp','$referencia_dife','$num_proyecto','$tipo_diferido','$nro_documento','$unidad_sol','$ced_rif','$fechav','N',0,'M','$fecha_diferido','$func_inv','$g_comprobante','$cod_con_g_pagar','$tiene_anticipo','$cod_con_anticipo',0,$tasa_anticipo,0,'P','P','$aprobado','$status','','$minf_usuario','$descripcion_comp','$nro_aut','$cod_est')";
     $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); $error=substr($error, 0, 61); 
     if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;} else{  $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?
       $resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">muestra('<? echo $error; ?>');</script><?}}
    echo $sSQL;
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING); 
if ($error==0){?><script language="JavaScript">document.location ='Act_compromisos.php?Gcriterio=<? echo $tipo_compromiso.$referencia_comp.$cod_comp; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? } 
 ?>
