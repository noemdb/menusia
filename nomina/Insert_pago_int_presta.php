<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $fecha_ley="19/06/2007";   $total_interes=0;  $fecha_calculo="";
$cod_empleado=$_POST["txtcod_empleado"]; $fecha_pago=$_POST["txtfecha_pago"];
$monto_pago=$_POST["txtmonto_pago"]; $monto_pago=formato_numero($monto_pago); if(is_numeric($monto_pago)){$monto_pago=$monto_pago;}else{$monto_pago=0;}
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_pago_prestaciones.php?Gcriterio=C".$fecha_pago.$cod_empleado;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ if(checkData($fecha_pago)=='1'){$error=0; $fechap=formato_aaaammdd($fecha_pago);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE PAGO NO ES VALIDA');</script><? }
  if($error==0){$sSQL="Select cod_empleado from NOM032 WHERE cod_empleado='$cod_empleado' and fecha_pago='$fechap'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('PAGO DE INTERES YA EXISTE');</script><? } }
  if($error==0){$sql="SELECT NOM006.cod_empleado,NOM006.tipo_nomina,NOM006.fecha_ingreso,NOM006.cod_categoria FROM NOM006 Where cod_empleado='$cod_empleado'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado); if($filas==0){$error=1;?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? } }
  if($error==0){$StrSQL="Select fecha_calculo,total_interes from NOM030 WHERE cod_empleado='$cod_empleado' order by fecha_calculo desc,num_calculo desc";
  $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado);$total_interes=$registro["total_interes"]; $fecha_calculo=$registro["fecha_calculo"];}else{$error=1;?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO TIENE CALCULO DE PRESTACIONES');</script><? }}
  if($error==0){$StrSQL="Select fecha_pago from NOM032 WHERE cod_empleado='$cod_empleado' order by fecha_pago desc";
  $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);if($filas>0){$registro=pg_fetch_array($resultado); $fecha_calculo=$registro["fecha_pago"];}  }
  if($error==0){ $fechap=formato_aaaammdd($fecha_pago); if($fechap<$fecha_calculo){$error=1; ?> <script language="JavaScript">muestra('FECHA DE PAGO NO PUEDE SER MENOR ULTIMA FECHA CALCULO');</script><?} }
  if($error==0){ if($monto_pago==0){$error=1; ?> <script language="JavaScript">muestra('MONTO DE PAGO NO VALIDO');</script><?} }
  if($error==0){ IF($monto_pago>$total_interes){$error=1; ?> <script language="JavaScript">muestra('MONTO DE PAGO NO PUEDE SER MAYOR A SALDO DE INTERESES');</script><?} }
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy); $sSQL="SELECT ACTUALIZA_NOM032(1,'$cod_empleado','$fechap',$total_interes,$monto_pago)";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? } }
}
pg_close();if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>