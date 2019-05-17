<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();
$cod_empleado=$_POST["txtcod_empleado"]; $fecha_cal_fin=$_POST["txtfecha_cal_fin"];
$ant_ano=$_POST["txtant_ano"]; $ant_mes=$_POST["txtant_mes"]; $ant_dia=$_POST["txtant_dia"]; $cod_sue_int=$_POST["txtcod_sue_int"];
$monto_sue_int=$_POST["txtmonto_sue_int"];$sueldo_basico=$_POST["txtsueldo_basico"];$tiempo_servicio=$_POST["txttiempo_servicio"];
$monto_garantia=$_POST["txtmonto_garantia"];$monto_art142=$_POST["txtmonto_art142"];$fecha_cal_garantia=$_POST["txtfecha_cal_garantia"];
$monto_garantia=formato_numero($monto_garantia); if(is_numeric($monto_garantia)){$monto_garantia=$monto_garantia;}else{$monto_garantia=0;}
$monto_art142=formato_numero($monto_art142); if(is_numeric($monto_art142)){$monto_art142=$monto_art142;}else{$monto_art142=0;}
$monto_sue_int=formato_numero($monto_sue_int); if(is_numeric($monto_sue_int)){$monto_sue_int=$monto_sue_int;}else{$monto_sue_int=0;}
$sueldo_basico=formato_numero($sueldo_basico); if(is_numeric($sueldo_basico)){$sueldo_basico=$sueldo_basico;}else{$sueldo_basico=0;}
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_cal_prest_fin_relac.php?Gcriterio=C".$cod_empleado;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ if(checkData($fecha_cal_fin)=='1'){$error=0; $fechap=formato_aaaammdd($fecha_cal_fin);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE PAGO NO ES VALIDA');</script><?  }
  if($error==0){$sSQL="Select cod_empleado from NOM077 WHERE cod_empleado='$cod_empleado' "; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CALCULO YA EXISTE PARA ESTE TRABAJADOR');</script><? } }
  if($error==0){$sql="SELECT NOM006.cod_empleado,NOM006.tipo_nomina,NOM006.fecha_ingreso,NOM006.cedula,NOM006.nombre FROM NOM006 Where cod_empleado='$cod_empleado'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado); 
    if($filas==0){$error=1;?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? } 
	else{ $registro=pg_fetch_array($resultado);   $cedula=$registro["cedula"]; $tipo_nomina=$registro["tipo_nomina"]; $fecha_ing=$registro["fecha_ingreso"];} 
  }
  if($error==0){ $fechap=formato_aaaammdd($fecha_cal_fin); if($fechap<$fecha_ing){$error=1; ?> <script language="JavaScript">muestra('FECHA DE CALCULO NO PUEDE SER MENOR FECHA INGRESO');</script><?} }
  
  if($error==0){$StrSQL="Select fecha_calculo,total_interes from NOM030 WHERE cod_empleado='$cod_empleado' order by fecha_calculo desc,num_calculo desc";
  $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $fecha_cal_garantia=$registro["fecha_calculo"];}else{$error=1;?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO TIENE CALCULO DE PRESTACIONES');</script><? }}
  if($error==0){ $fechap=formato_aaaammdd($fecha_cal_fin); if($fechap<$fecha_cal_garantia){$error=1; ?> <script language="JavaScript">muestra('FECHA DE CALCULO NO PUEDE SER MENOR ULTIMA FECHA CALCULO PRESTACIONES');</script><?} }
  if($error==0){ if($monto_art142==0){$error=1; ?> <script language="JavaScript">muestra('MONTO DE CALCULO NO VALIDO');</script><?} }
  
  if($error==0){ $sSQL="SELECT ACTUALIZA_NOM077(1,'$cod_empleado','$fecha_ing','$fechap','$ant_ano','$ant_mes','$ant_dia','$cod_sue_int',$monto_sue_int,$sueldo_basico,$tiempo_servicio,$monto_garantia,$monto_art142,'$fecha_cal_garantia','','','',0,0,'$minf_usuario')";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? }
  
  }
}
pg_close();if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>