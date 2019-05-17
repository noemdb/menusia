<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();
$cod_empleado=$_POST["txtcod_empleado"]; $fecha_sueldo=$_POST["txtfecha_sueldo"];
$monto_sueldo=$_POST["txtmonto_sueldo"]; $monto_sueldo=formato_numero($monto_sueldo); if(is_numeric($monto_sueldo)){$monto_sueldo=$monto_sueldo;}else{$monto_sueldo=0;}
$monto_sueldo_adic=$_POST["txtmonto_sueldo_adic"]; $monto_sueldo_adic=formato_numero($monto_sueldo_adic); if(is_numeric($monto_sueldo_adic)){$monto_sueldo_adic=$monto_sueldo_adic;}else{$monto_sueldo_adic=0;}
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_sueldo_prestaciones.php?Gcriterio=C".$fecha_sueldo.$cod_empleado;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ if(checkData($fecha_sueldo)=='1'){$error=0;$fechap=formato_aaaammdd($fecha_sueldo);  } else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE PAGO NO ES VALIDA');</script><? }
  if($error==0){$sSQL="Select cod_empleado from NOM028 WHERE cod_empleado='$cod_empleado' and fecha_sueldo='$fechap'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('SUELDO DE PRESTACIONES YA EXISTE');</script><? } }
  if($error==0){$sql="SELECT NOM006.cod_empleado,NOM006.tipo_nomina,NOM006.fecha_ingreso,NOM006.cod_categoria FROM NOM006 Where cod_empleado='$cod_empleado'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado); if($filas==0){$error=1;?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? } }
  if($error==0){ if($monto_sueldo==0){$error=1; ?> <script language="JavaScript">muestra('MONTO DE SUELDO NO VALIDO');</script><?} }
  if($error==0){ IF($monto_sueldo_adic==0){$error=1; ?> <script language="JavaScript">muestra('MONTO DE SUELDO PRESTACIONES NO VALIDO');</script><?} }
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);
     $sSQL="SELECT ACTUALIZA_NOM028(1,'$cod_empleado','$fechap',$monto_sueldo,$monto_sueldo_adic,0,0,0,0,0,0,0,0,0,'$minf_usuario','000','$fechap','','000','$fechap','')";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? } }
}
pg_close();if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>