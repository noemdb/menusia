<? error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/funciones.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;  
$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"]; $tipo_rpt=$_GET["tipo_rpt"]; $redondear=$_GET["redondear"]; $detallado=$_GET["detallado"]; 
$equipo = getenv("COMPUTERNAME"); $nomb_rpt="Rpt_Comprobante_ISLR_html.php?";  $mcod_m="BAN19C".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); $fecha_hoy=asigna_fecha_hoy(); $fecha=formato_aaaammdd($fecha_hoy); $prev_fecha=formato_aaaammdd($fecha_hoy);
$Sql="SELECT ACTUALIZA_BAN019(2,'".$usuario_sia."','','".$fecha."','',0,0,0,0,0,0,'".$fecha."','','','','','',0,0)";
$resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);      $error="ERROR GRABANDO: ".substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
$sql="SELECT ban012.cod_banco,ban012.tipo_mov,ban012.referencia,ban012.tipo_planilla,ban012.nro_planilla,ban012.ced_rif,ban012.fecha_emision,ban012.nro_orden,ban012.aux_orden,ban012.tipo_retencion,ban012.tipo_documento,ban012.nro_documento,ban012.nro_con_factura,ban012.fecha_factura,ban012.nro_comprobante,ban012.tipo_en,ban012.monto_pago,ban012.monto_objeto,ban012.tasa,ban012.monto_retencion,ban012.monto1,ban012.monto2,ban012.monto3,ban012.anulada,
ban013.cod_retencion,ban013.fecha_enterado,ban013.nombre_banco_ent,ban013.nro_deposito,pag003.cod_fondo from ban013,(ban012 LEFT JOIN PAG003 ON (PAG003.Tipo_Retencion=ban012.Tipo_Retencion)) Where (ban012.nro_planilla=BAN013.nro_planilla) And (ban012.tipo_planilla=BAN013.tipo_planilla) And (ban012.ced_rif>='$cedula_d' And ban012.ced_rif<='$cedula_h') and (ban012.monto_retencion>0) order by ban012.ced_rif,ban012.fecha_emision,ban012.nro_planilla,ban012.referencia";$res=pg_query($sql);
$res=pg_query($sql); $error=0; $prev_mes=""; $monto_abonado=0; $monto_objeto=0; $tasa=0; $monto_retencion=0; $acum_retenido=0; $acum_objeto=0;	 
while(($registro=pg_fetch_array($res))and($error==0)){
    $fecha_emision=$registro["fecha_emision"]; $ced_rif=$registro["ced_rif"]; 
	$mes=substr($fecha_emision,5,2); $tipo_retencion=$registro["tipo_retencion"]; $monto_pago=$registro["monto_pago"];  $total_causado=$registro["monto_pago"];
	if($prev_mes==""){ $prev_fecha=$registro["fecha_emision"]; $prev_cod=$registro["cod_fondo"]; 
	     $prev_mes=$mes; $prev_ced=$registro["ced_rif"]; $fecha_abono=$registro["fecha_emision"]; $cod_retencion=$registro["cod_retencion"];	$nro_planilla=$registro["nro_planilla"];	 
		 $fecha_enterado=$registro["fecha_enterado"]; $nombre_banco_ent=$registro["nombre_banco_ent"]; $total_causado=$registro["monto_pago"]; $nro_orden=$registro["nro_orden"];}
	If(($prev_mes <> $mes)Or($prev_ced<>$ced_rif)Or($detallado=="SI")){
	   $acum_retenido=$acum_retenido+$monto_retencion; $acum_objeto=$acum_objeto+$monto_objeto;
       if($detallado=="SI"){ $fechat=$prev_fecha;}
       else{$p_fecha=formato_ddmmaaaa($prev_fecha); $fecha_desde=colocar_pdiames($p_fecha); $fecha_hasta=colocar_udiames($p_fecha);     $fecha_temp=colocar_udiames($p_fecha);
	   $fechat=formato_aaaammdd($fecha_temp);}
	   if($monto_retencion>0){ $monto_retencion=cambia_coma_numero($monto_retencion); $monto_abonado=cambia_coma_numero($monto_abonado); $monto_objeto=cambia_coma_numero($monto_objeto); $acum_retenido=cambia_coma_numero($acum_retenido); $acum_objeto=cambia_coma_numero($acum_objeto);
	      $Sql="SELECT ACTUALIZA_BAN019(1,'$usuario_sia','$prev_ced','$fechat','$prev_cod',$monto_abonado,$monto_objeto,$tasa,$monto_retencion,$acum_retenido,$acum_objeto,'$fecha_enterado','$nombre_banco_ent','','','$nro_planilla','$nro_orden',0,0)";
          $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);      $error="ERROR GRABANDO: ".substr($error,0,91);
		  if (!$resultado){echo $Sql,"<br>"; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{ $error=0;}
       }
	   $monto_abonado=0; $monto_objeto=0; $tasa=0; $monto_retencion=0;
	   if($prev_ced<>$registro["ced_rif"]){ $acum_retenido=0; $acum_objeto=0;}
	   $prev_fecha=$registro["fecha_emision"]; $prev_cod=$registro["cod_fondo"];  $fecha_enterado=$registro["fecha_enterado"]; $nombre_banco_ent=$registro["nombre_banco_ent"];
	   $prev_mes=$mes; $prev_ced=$registro["ced_rif"]; $fecha_abono=$registro["fecha_emision"]; 
    }
	$tasa=$registro["tasa"];	$nro_orden=$registro["nro_orden"];	$nro_planilla=$registro["nro_planilla"];
	if($Cod_Emp=="58"){
	  $sSQL="SELECT nro_orden,fecha,total_causado from PAG001 Where nro_orden='$nro_orden'";  $resp=pg_query($sSQL);  $filasp=pg_num_rows($resp);
      if($filasp>=1){$regp=pg_fetch_array($resp,0); $total_causado=$regp["total_causado"]; }
	}
	if($redondear=="SI"){$total_causado=round($total_causado,0);}
	$monto_abonado=$monto_abonado+$total_causado;
	$monto_objeto=$monto_objeto+$registro["monto_objeto"];
	$monto_retencion=$monto_retencion+$registro["monto_retencion"];
}
$acum_retenido=$acum_retenido+$monto_retencion; $acum_objeto=$acum_objeto+$monto_objeto;	   
	   if($detallado=="SI"){ $fechat=$prev_fecha;}       else{$p_fecha=formato_ddmmaaaa($prev_fecha);
	   $fecha_desde=colocar_pdiames($p_fecha); $fecha_hasta=colocar_udiames($p_fecha);     $fecha_temp=colocar_udiames($p_fecha);
	   $fechat=formato_aaaammdd($fecha_temp);}
	   if($monto_retencion>0){ $monto_retencion=cambia_coma_numero($monto_retencion); $monto_abonado=cambia_coma_numero($monto_abonado); $monto_objeto=cambia_coma_numero($monto_objeto); $acum_retenido=cambia_coma_numero($acum_retenido); $acum_objeto=cambia_coma_numero($acum_objeto);
	      $Sql="SELECT ACTUALIZA_BAN019(1,'$usuario_sia','$prev_ced','$fechat','$prev_cod',$monto_abonado,$monto_objeto,$tasa,$monto_retencion,$acum_retenido,$acum_objeto,'$fecha_enterado','$nombre_banco_ent','','','$nro_planilla','$nro_orden',0,0)";
          $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);      $error="ERROR GRABANDO: ".substr($error,0,91);if (!$resultado){echo $Sql,"<br>";?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{ $error=0;}
       }
  if($tipo_rpt=="HTML"){$nomb_rpt="Rpt_Comprobante_ISLR_html.php?";	}
  if($tipo_rpt=="PDF"){	$nomb_rpt="Rpt_Comprobante_ISLR_pdf.php?";}
  if($tipo_rpt=="EXCEL"){ $nomb_rpt="Rpt_Comprobante_ISLR_excel.php?";	}   
  $nomb_rpt=$nomb_rpt."cedula_d=".$cedula_d."&cedula_h=".$cedula_h;
} pg_close();
?>
<script language="JavaScript">document.location ='<? echo $nomb_rpt; ?>'; </script>

 