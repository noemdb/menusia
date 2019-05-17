<?include ("../class/conect.php");  include ("../class/funciones.php");$tipo_nomina=$_GET["tipo_nomina"]; $tp_calculo=$_GET["tp_calculo"]; $url="Det_cal_nomina.php?criterio=".$tipo_nomina; echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 $error=0; $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); $fecha_hoy=asigna_fecha_hoy();
 if($error==0){ if ($gnomina=="00"){$error=0;} else {  if($tipo_nomina<>$gnomina) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO ACTIVA PARA EL USUARIO');</script><?}  } } 
 if($error==0){ $fecha_p_desde=""; $fecha_p_hasta=""; $des_nomina="";
    $sql="Select * from NOM017 where (tipo_nomina='$tipo_nomina') and (tp_calculo='$tp_calculo') ";   $res=pg_query($sql); $filas=pg_num_rows($res);
    if($filas>0){$registro=pg_fetch_array($res);   $fecha_p_desde=$registro["fecha_p_desde"]; $fecha_p_hasta=$registro["fecha_p_hasta"]; $des_nomina=$registro["des_nomina"]; $fecha_p_desde=formato_ddmmaaaa($fecha_p_desde); $fecha_p_hasta=formato_ddmmaaaa($fecha_p_hasta); }   
 }
 if($error==0){$sSQL="Select * from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA NO EXISTE');</script><?}else{$registro=pg_fetch_array($resultado);  $bloqueada=$registro["bloqueada"]; if($tp_calculo=="E"){$bloqueada=$registro["bloqueada_ext"];}  }  }
 if($error==0){if($bloqueada=='S'){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA ESTA BLOQUEADA');</script><?}}
 if($error==0){ $sSQL="SELECT ELIM_CAL_NOMINA('$tipo_nomina','$tp_calculo')"; $resultado=pg_exec($conn,$sSQL);
    $error=pg_errormessage($conn); $error="ERROR ELIMINANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
    if($tp_calculo=="E"){ $des_tipo_cal="EXTRAORDINARIA"; }else{ $des_tipo_cal="NORMAL";}   $sfecha=formato_aaaammdd($fecha_hoy);
	$desc_doc="ELIMINO, CALCULO DE NOMINA:".$tipo_nomina.", DESCRIPCION:".$des_nomina.", TIPO CALCULO:".$des_tipo_cal.", FECHA DESDE:".$fecha_p_desde.", FECHA HASTA:".$fecha_p_hasta; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
    $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } }
}	
pg_close(); ?>
<script language="JavaScript"> document.location ='<? echo $url; ?>'; </script>