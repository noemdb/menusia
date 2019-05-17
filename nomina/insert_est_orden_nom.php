<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();   $error=0; $referencia_comp="00000000"; $tipo_compromiso="0000";  $ref_imput_presu="00000000";  $tipo_imput_presu="P";
$cod_estructura=$_POST["txtcod_estructura"];  $tipo_pago=$_POST["txttipo_pago"]; $tp_calculo=$_POST["txttp_calculo"];  $codigo_mov=$_POST["txtcodigo_mov"];
$fecha_d=$_POST["txtfecha_d"]; $fecha_h=$_POST["txtfecha_h"]; $criterio=$tp_calculo.$cod_estructura;
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $url="Gen_orden_nomina.php?criterio=".$criterio;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sSQL="Select * from PAG006 WHERE cod_estructura='$cod_estructura'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; ?>  <script language="JavaScript">muestra('CODIGO DE ESTRUCTURA NO EXISTE'); </script><?}
   else{$registro=pg_fetch_array($resultado); $ced_rif_est=$registro["ced_rif_est"]; $concepto_est=$registro["concepto_est"];}
  if($error==0){$sql="SELECT * FROM pag009 WHERE (cod_estructura='$cod_estructura')"; $res=pg_query($sql); $filas=pg_num_rows($res);
    if($filas>0){$reg=pg_fetch_array($res); $referencia_comp=$reg["ref_comp_est"]; $tipo_compromiso=$reg["tipo_comp_est"];  $ref_imput_presu=$reg["ref_imput_presu"]; $tipo_imput_presu=$reg["tipo_imput_presu"];} }
  if($error==0){$sql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup"; $res=pg_query($sql);$total=0;
    while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]; $total=$total+$registro["monto"]; $disponible=$registro["disponible"];  $monto_c=$monto; 
      if($registro["tipo_compromiso"]=="0000"){if($registro["monto"]>$registro["disponible"]){$error=0; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO : <? echo $registro["cod_presup"]; ?> NO TIENE DISPONIBILIDAD');</script><? }} 
	  else{ $ref_imput_presu=$registro["ref_imput_presu"]; $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"]; $cod_presup=$registro["cod_presup"];$fuente_financ=$registro["fuente_financ"];
		  $sSQL="Select * from PRE036 WHERE (ref_imput_presu='$ref_imput_presu') and (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";  $resultadoc=pg_query($sSQL);  $filasc=pg_num_rows($resultadoc);
		  if ($filasc==0){$error=1; $error=0; ?> <script language="JavaScript"> muestra('NO EXISTE EN EL COMPROMISO EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
			else{$regc=pg_fetch_array($resultadoc);  $compromiso=$regc["monto"]-$regc["causado"]-$regc["ajustado"]; $disponible=$compromiso;
				if ($compromiso>$monto_c){$diferencia=$compromiso-$monto_c; }else{$diferencia=$monto_c-$compromiso; }  $error_c='Referencia: '.$referencia_comp.' Codigo: '.$cod_presup.' Monto: '.$monto_c.' Saldo Compromiso: '.$compromiso.' Diferencia: '.$diferencia;
				if(($monto_c>$compromiso)and($diferencia>0.001)){$error=1; $error=0; ?> <script language="JavaScript"> muestra('MONTO A CAUSAR MAYOR AL MONTO DEL CODIGO POR COMPROMETER CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?>');</script><? }
			}
		}
	}
  }
  if($error==0){ $sql="SELECT * FROM COD_RET where codigo_mov='$codigo_mov' order by tipo_retencion,cod_presup_ret"; $res=pg_query($sql);
    while($registro=pg_fetch_array($res)){$monto=$registro["monto_retencion"];  $tipo_retencion=$registro["tipo_retencion"];  $cod_presup=$registro["cod_presup_ret"];  $cod_fuente=$registro["fuente_fin_ret"];   $referencia_comp=$registro["ref_comp_ret"]; $tipo_compromiso=$registro["tipo_comp_ret"];
      $sSQL="SELECT monto FROM PRE026 where codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and ref_imput_presu='$ref_imput_presu' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'";  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if($filas==0){$error=1;?> <script language="JavaScript">muestra('CODIGO PRESUPUESTARIO <? echo $cod_presup; ?> \n ASOCIADO A LA RETENCION <? echo $tipo_retencion; ?>, NO TIENE IMPUTACIÓN ');</script><?}}
  }
  if($error==0){ $dfecha=formato_aaaammdd($fecha_hoy); $tipo_documento="NOMINA";  $nro_documento="DEPOSITO"; if($tipo_pago=="CHEQUE"){$nro_documento="CHEQUE";}
    $sSQL="SELECT EST_NOM_PAG006('$codigo_mov','$cod_estructura','$fecha_d','$fecha_h','$tipo_documento','$nro_documento','$tp_calculo')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error, 0, 61); echo $sSQL;
    if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?
     $resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); $resultado=pg_exec($conn,"SELECT BORRAR_PAG028('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);}
  }
}pg_close();
$furl="/sia/nomina/rpt/Rpt_inf_confirmacion.php?cod_estructura=".$cod_estructura;
if($error==0){?><script language="JavaScript"> Ventana_chq('<? echo $furl; ?>'); document.location='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>


