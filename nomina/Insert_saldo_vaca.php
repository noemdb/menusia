<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $fecha_ley="19/06/2007";
$cod_empleado=$_POST["txtcod_empleado"]; 
$fecha_causa_desde=$_POST["txtfecha_causa_desde"]; $fecha_causa_hasta=$_POST["txtfecha_causa_hasta"];
$fecha_d_desde=$_POST["txtfecha_d_desde"]; $fecha_d_hasta=$_POST["txtfecha_d_hasta"];
$fecha_reincorp=$_POST["txtfecha_reincorp"]; $calcula_nomina="NO";
$fecha_calculo_d=$_POST["txtfecha_causa_desde"]; $fecha_calculo_h=$_POST["txtfecha_causa_hasta"];
$dias_habiles=$_POST["txtdias_habiles"];  $dias_habiles=formato_numero($dias_habiles); if(is_numeric($dias_habiles)){$dias_habiles=$dias_habiles;}else{$dias_habiles=0;}
$dias_no_habiles=$_POST["txtdias_no_habiles"];  $dias_no_habiles=formato_numero($dias_no_habiles); if(is_numeric($dias_no_habiles)){$dias_no_habiles=$dias_no_habiles;}else{$dias_no_habiles=0;}
$dias_bono_vac=$_POST["txtdias_bono_vac"]; $dias_bono_vac=formato_numero($dias_bono_vac); if(is_numeric($dias_bono_vac)){$dias_bono_vac=$dias_bono_vac;}else{$dias_bono_vac=0;}
$monto_bono_vac=$_POST["txtmonto_bono_vac"]; $monto_bono_vac=formato_numero($monto_bono_vac); if(is_numeric($monto_bono_vac)){$monto_bono_vac=$monto_bono_vac;}else{$monto_bono_vac=0;}
$dias_disfrutados=$_POST["txtdias_disfrutados"]; $dias_disfrutados=formato_numero($dias_disfrutados); if(is_numeric($dias_disfrutados)){$dias_disfrutados=$dias_disfrutados;}else{$dias_disfrutados=0;}
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_sal_vacaciones.php?Gcriterio=C".$fecha_causa_hasta.$cod_empleado;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select cod_empleado from NOM025 WHERE cod_empleado='$cod_empleado'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR TIENE SALDO DE VACACIONES');</script><? }
  if($error==0){if(checkData($fecha_causa_desde)=='1'){$error=0; $fechacd=formato_aaaammdd($fecha_causa_desde);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE CAUSADO DESDE NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_causa_hasta)=='1'){$error=0; $fechach=formato_aaaammdd($fecha_causa_hasta);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE CAUSADO HASTA NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_d_desde)=='1'){$error=0; $fechadd=formato_aaaammdd($fecha_d_desde);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE DISFRUTE NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_d_hasta)=='1'){$error=0; $fechadh=formato_aaaammdd($fecha_d_hasta);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE DISFRUTE NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_calculo_d)=='1'){$error=0; $fechaad=formato_aaaammdd($fecha_d_desde);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE CALCULO NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_calculo_h)=='1'){$error=0; $fechaah=formato_aaaammdd($fecha_calculo_h);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE CALCULO NO ES VALIDA');</script><? }}
  if($error==0){if(checkData($fecha_reincorp)=='1'){$error=0; $fechar=formato_aaaammdd($fecha_reincorp);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE REINCORPORASE NO ES VALIDA');</script><? }}
  if($error==0){$sql="SELECT NOM006.cod_empleado,NOM006.tipo_nomina,NOM006.fecha_ingreso,NOM006.cod_categoria FROM NOM006 Where cod_empleado='$cod_empleado'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado); if($filas==0){$error=1;?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? }
    else{$registro=pg_fetch_array($resultado); $fecha_ingreso=$registro["fecha_ingreso"];  }  }
  if($error==0){
    if(substr($fechacd,5,5)<>substr($fecha_ingreso,5,5)){ $error=1; ?> <script language="JavaScript">muestra('FECHA DE CAUSADO DESDE NO ES VALIDA');</script><? }
	if(substr($fechach,5,5)<>substr($fecha_ingreso,5,5)){ $error=1; ?> <script language="JavaScript">muestra('FECHA DE CAUSADO HASTA NO ES VALIDA');</script><? }
  }	
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy); 
	 $sSQL="SELECT ACTUALIZA_NOM025(1,'$cod_empleado','$fechacd','$fechach','$fechadd','$fechadh','$fechar','$fechaad','$fechaah','$calcula_nomina',$dias_habiles,$dias_no_habiles,$dias_bono_vac,$monto_bono_vac,$dias_disfrutados,'$usuario_sia','$minf_usuario','',0,0)";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}  } 
}
pg_close();
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}


?>