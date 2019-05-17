<?include ("../class/conect.php");  include ("../class/funciones.php");$cod_empleado=$_GET["txtcod_empleado"];  $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sSQL="Select cod_empleado,fecha_cal_fin from NOM077 WHERE cod_empleado='$cod_empleado'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CALCULO NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado); $afechac=$registro["fecha_cal_fin"];   $sfecha=formato_aaaammdd($fecha_hoy);  $fecha_c=formato_ddmmaaaa($afechac);  }
  if($error==0){ $sSQL="SELECT ACTUALIZA_NOM077(3,'$cod_empleado','$afechac','$afechac',0,0,0,'000',0,0,0,0,0,'$afechac','','','',0,0,'$minf_usuario')";
	 $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR ELIMINANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
     $desc_doc="CALCULO PRESTACIONES FIN RELACION LABORAL, CODIGO TRABAJADOR:".$cod_empleado.", FECHA CALCULO :".$fecha_c; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
     $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } }
  }
}
pg_close();  ?> <script language="JavaScript"> window.close(); window.opener.location.reload(); </script> 