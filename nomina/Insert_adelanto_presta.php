<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $fecha_ley="19/06/2007";   $saldo_prestaciones=0;  $fecha_calculo="";
$cod_empleado=$_POST["txtcod_empleado"]; $fecha_adelanto=$_POST["txtfecha_adelanto"];   $total_prestaciones=0;$total_adelanto=0;$total_prestamo=0;
$monto_adelanto=$_POST["txtmonto_adelanto"]; $monto_adelanto=formato_numero($monto_adelanto); if(is_numeric($monto_adelanto)){$monto_adelanto=$monto_adelanto;}else{$monto_adelanto=0;}
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_adelanto_prestaciones.php?Gcriterio=C".$fecha_adelanto.$cod_empleado;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ if(checkData($fecha_adelanto)=='1'){$error=0;$fechap=formato_aaaammdd($fecha_adelanto);  } else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE PAGO NO ES VALIDA');</script><? }
  if($error==0){$sSQL="Select cod_empleado from NOM031 WHERE cod_empleado='$cod_empleado' and fecha_adelanto='$fechap'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('PAGO DE INTERES YA EXISTE');</script><? } }
  if($error==0){$sql="SELECT NOM006.cod_empleado,NOM006.tipo_nomina,NOM006.fecha_ingreso,NOM006.cod_categoria FROM NOM006 Where cod_empleado='$cod_empleado'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado); if($filas==0){$error=1;?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? } }
  if($error==0){$StrSQL="Select fecha_calculo,total_prestaciones,total_adelanto,total_prestamo,saldo_prestaciones from NOM030 WHERE cod_empleado='$cod_empleado' order by fecha_calculo desc,num_calculo desc";
  $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado);$saldo_prestaciones=$registro["saldo_prestaciones"]; $total_prestaciones=$registro["total_prestaciones"]; $total_adelanto=$registro["total_adelanto"]; $total_prestamo=$registro["total_prestamo"]; $fecha_calculo=$registro["fecha_calculo"];}else{$error=1;?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO TIENE CALCULO DE PRESTACIONES');</script><? }}
  if($error==0){$StrSQL="Select fecha_adelanto from NOM031 WHERE cod_empleado='$cod_empleado' order by fecha_adelanto desc";
  $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $fecha_calculo=$registro["fecha_adelanto"];}  }
  if($error==0){ $fechap=formato_aaaammdd($fecha_adelanto); if($fechap<$fecha_calculo){$error=1; ?> <script language="JavaScript">muestra('FECHA DE ADELANTO NO PUEDE SER MENOR ULTIMA FECHA CALCULO');</script><?} }
  if($error==0){ if($monto_adelanto==0){$error=1; ?> <script language="JavaScript">muestra('MONTO DE ADELANTO NO VALIDO');</script><?} }

  if($error==0){ if($monto_adelanto>$saldo_prestaciones){$error=1; ?> <script language="JavaScript">muestra('MONTO DE ADELANTO NO PUEDE SER MAYOR A SALDO DE PRESTACIONES');</script><?} }
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy); $sSQL="SELECT ACTUALIZA_NOM031(1,'$cod_empleado','$fechap',$total_prestaciones,$total_adelanto,$total_prestamo,$saldo_prestaciones,$monto_adelanto)";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? } }
}
pg_close();
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>

