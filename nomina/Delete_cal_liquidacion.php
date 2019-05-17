<?include ("../class/conect.php");  include ("../class/funciones.php");$cod_empleado=$_GET["txtcod_empleado"];  $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sSQL="Select cod_empleado,fecha_liquidacion from NOM035 WHERE cod_empleado='$cod_empleado'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CALCULO DE VACACIONES NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado);$fecha_liquidacion=$registro["fecha_liquidacion"]; $fechal=$fecha_liquidacion;     $sfecha=formato_aaaammdd($fecha_hoy);  $fecha_c=formato_ddmmaaaa($fecha_liquidacion);  }
  if($error==0){
     $sSQL="SELECT ACTUALIZA_NOM035(3,'','$cod_empleado','$fechal',0,0,0,'',0,'',0,'','',0,'',0,'','','','','',0,0,0,0,0,0,0,0,0,0,0,'$fechal',0,0,0,0,0,0,0,0,0,0,0,0,0,'','','','',0,0,'$usuario_sia','$minf_usuario')"; echo $sSQL;
     $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror="ERROR GRABANDO: ".substr($merror,0,91); if (!$resultado){$error=1; ?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
     $desc_doc="CALCULO DE LIQUIDACION, CODIGO TRABAJADOR:".$cod_empleado.", FECHA LIQUIDACION:".$fecha_c; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
     $merror=pg_errormessage($conn); $merror="ERROR GRABANDO: ".substr($merror,0,91); if (!$resultado){$error=1; ?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><?} }
  }
}
pg_close();  ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script> 