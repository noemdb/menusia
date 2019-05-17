<?include ("../class/conect.php");  include ("../class/funciones.php");$fecha_hoy=asigna_fecha_hoy();
$cod_empleado=$_POST["txtcod_empleado"]; $fecha_sueldo=$_POST["txtfecha_sueldo"];
$monto_sueldo=$_POST["txtmonto_sueldo"]; $monto_sueldo=formato_numero($monto_sueldo); if(is_numeric($monto_sueldo)){$monto_sueldo=$monto_sueldo;}else{$monto_sueldo=0;}
$monto_base=$_POST["txtmonto_base"]; $monto_base=formato_numero($monto_base); if(is_numeric($monto_base)){$monto_base=$monto_base;}else{$monto_base=0;}
$dias_ajuste=$_POST["txtdias_ajuste"]; $dias_ajuste=formato_numero($dias_ajuste); if(is_numeric($dias_ajuste)){$dias_ajuste=$dias_ajuste;}else{$dias_ajuste=0;}
$monto_ajuste=$_POST["txtmonto_ajuste"]; $monto_ajuste=formato_numero($monto_ajuste); if(is_numeric($monto_ajuste)){$monto_ajuste=$monto_ajuste;}else{$monto_ajuste=0;}
$monto_sueldo_adic=$monto_sueldo; 
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_sueldo_prestaciones_yac.php?Gcriterio=C".$fecha_sueldo.$cod_empleado;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $error=0;  $asueldo=0; $asueldoa=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ if(checkData($fecha_sueldo)=='1'){$error=0;$fechap=formato_aaaammdd($fecha_sueldo);  } else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE PAGO NO ES VALIDA');</script><? }
  if($error==0){$sSQL="Select cod_empleado,monto_sueldo,monto_sueldo_adic from NOM028 WHERE cod_empleado='$cod_empleado' and fecha_sueldo='$fechap'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('SUELDO DE PRESTACIONES NO EXISTE');</script><? }
    else{ $registro=pg_fetch_array($resultado); $asueldo=$registro["monto_sueldo"]; $asueldoa=$registro["monto_sueldo_adic"];  } }
  if($error==0){$sql="SELECT NOM006.cod_empleado,NOM006.tipo_nomina,NOM006.fecha_ingreso,NOM006.cod_categoria FROM NOM006 Where cod_empleado='$cod_empleado'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado); if($filas==0){$error=1;?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? } }
  if($error==0){ if($monto_sueldo==0){$error=1; ?> <script language="JavaScript">muestra('MONTO DE SUELDO NO VALIDO');</script><?} }
  if($error==0){ if($monto_sueldo_adic==0){$error=1; ?> <script language="JavaScript">muestra('MONTO DE SUELDO DIAS ADICIONAL NO VALIDO');</script><?} }
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);
     $sSQL="SELECT ACTUALIZA_NOM028(2,'$cod_empleado','$fechap',$monto_sueldo,$monto_sueldo_adic,$monto_base,$dias_ajuste,$monto_ajuste,0,0,0,0,0,0,'$minf_usuario','000','$fechap','','000','$fechap','')";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?
      $desc_doc="SUELDO PRESTACIONES CODIGO:".$cod_empleado.", FECHA SUELDO:".$fecha_sueldo.", SUELDO:".$asueldo.", SUELDO DIAS ADIC:".$asueldoa;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')"); $error=pg_errormessage($conn); $error=substr($error,0,61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><?}} }
}
pg_close();if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>