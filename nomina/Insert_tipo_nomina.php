<?include ("../class/conect.php");  include ("../class/funciones.php");
$tipo_nomina=$_POST["txttipo_nomina"]; $descripcion=$_POST["txtdescripcion"]; $frec=$_POST["txtfrecuencia"]; $frecuencia="Q"; $cod_grupo=$_POST["txtcod_grupo"];
if($frec=="QUINCENAL"){$frecuencia="Q";} if($frec=="SEMANAL"){$frecuencia="S";} if($frec=="MENSUAL"){$frecuencia="M";}
$ultima_fecha=$_POST["txtultima_fecha"]; $nro_semana=$_POST["txtnro_semana"]; if(is_numeric($nro_semana)){$nro_semana=$nro_semana;}else{$nro_semana=0;}
$redondear=$_POST["txtredondear"]; $desc_grupo=$_POST["texdesc_grupo"]; $con_sue_bas=$_POST["txtcon_sue_bas"]; $con_compen=$_POST["txtcon_compen"];
$con_tot_compen=$_POST["txtcon_tot_compen"]; $con_tot_prima=$_POST["txtcon_tot_prima"]; $con_sue_int=$_POST["txtcon_sue_int"];  $con_sue_tot=$_POST["txtcon_sue_tot"];
$con_bon_vac=$_POST["txtcon_bon_vac"]; $con_liqui2=$_POST["txtcon_liqui2"]; $con_cal_vac=$_POST["txtcon_cal_vac"]; $con_cal_liqui=$_POST["txtcon_cal_liqui"];
$con_liqui3=$_POST["txtcon_liqui3"]; $g_orden_pago=$_POST["txtg_orden_pago"];  $cal_int_fidecomiso=$_POST["txtcal_int_fidecomiso"]; $cod_relac_nom=$_POST["txtcod_relac_nom"];
$cod_relac_ext=$_POST["txtcod_relac_ext"];  $cod_relac_apo=$_POST["txtcod_relac_apo"];    $dep_prest_mes=$_POST["txtdep_prest_mes"]; $cod_relac_vac=$_POST["txtcod_relac_vac"]; 
$cod_tipo_liq=$_POST["txtcod_tipo_liq"]; $cod_tipo_liq=formato_numero($cod_tipo_liq); if(is_numeric($cod_tipo_liq)){$cod_tipo_liq=$cod_tipo_liq;}else{$cod_tipo_liq=0;}
$fecha_hoy=asigna_fecha_hoy(); $status=substr($cal_int_fidecomiso,0,1).substr($dep_prest_mes,0,1); $g_orden_pago=substr($g_orden_pago,0,1);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_tip_nomi_ar.php?Gtipo_nomina=C".$tipo_nomina;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ if(checkData($ultima_fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? } }
 if($error==0){if(strlen($tipo_nomina)==2){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD TIPO DE NOMINA INVALIDA');</script><? } }
 if($error==0){ if ($gnomina=="00"){$error=0;} else {  if($tipo_nomina<>$gnomina) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO ACTIVA PARA EL USUARIO');</script><?}  } } 
 if($error==0){$sSQL="Select * from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA YA EXISTE');</script><? }
   else{$ufecha=formato_aaaammdd($ultima_fecha); $sfecha=formato_aaaammdd($fecha_hoy);
      $sSQL="SELECT ACTUALIZA_NOM001(1,'$tipo_nomina','$descripcion','$cod_grupo','$desc_grupo','$frecuencia',$nro_semana,'$ufecha','$ufecha','$sfecha','$sfecha','$redondear','$status','','$con_sue_bas','$con_compen','$con_cal_vac','$con_bon_vac','$con_sue_int','$con_sue_tot','$con_tot_prima','$con_tot_compen','$con_cal_liqui','$con_liqui2','$con_liqui3','$g_orden_pago','$g_orden_pago','$cod_relac_nom','$cod_relac_ext','$cod_relac_apo','$cod_relac_vac','','','','','','$cod_tipo_liq','N','N','$minf_usuario')"; 
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}
  }
}
pg_close();if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>