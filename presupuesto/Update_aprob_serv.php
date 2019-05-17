<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();   $sfecha=formato_aaaammdd($fecha_hoy);
$cod_servicio=$_POST["txtcod_servicio"]; $denominacion=$_POST["txtdes_servicio"]; $ramo=$_POST["txtcod_ramo"];  $partida=$_POST["txtpartida"]; $cod_contable=""; $observacion="";  $fecha_vence=$sfecha;
$tipo_servicio=$_POST["txttipo_servicio"]; $tipo_servicio=substr($tipo_servicio,0,1); $unidad_medida=$_POST["txtunidad_medida"];
$ultimo_costo=$_POST["txtultimo_costo"];   $ultimo_costo=formato_numero($ultimo_costo); if(is_numeric($ultimo_costo)){$ultimo_costo=$ultimo_costo;}else{$ultimo_costo=0;}
$fecha_u_costo=$_POST["txtfecha_u_costo"]; if(checkData($fecha_u_costo)=='1'){$fecha_u_costo=$sfecha;}else{$fecha_u_costo=$sfecha;}
$impuesto=$_POST["txtimpuesto"]; $impuesto=formato_numero($impuesto);  if(is_numeric($impuesto)){$impuesto=$impuesto;}else{$impuesto=0;}
$fecha_creado=$_POST["txtfecha_creado"]; if(checkData($fecha_creado)=='1'){$fecha_creado=$sfecha;}else{$fecha_creado=$sfecha;}
$cod_aux1=$_POST["txtcod_aux1"]; $fecha_aprobada=$_POST["txtfecha_aprobada"]; $error=0;
if (checkData($fecha_aprobada)=='1'){ $afecha=formato_aaaammdd($fecha_aprobada);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA APROBACION NO ES VALIDA');</script><? }
$usuario_aprueba=$usuario_sia;$aprobado="S";$fecha_aprobada=$afecha;
$cod_aux2="";$campo_str1="";$campo_str2="";$campo_num1=0;$campo_num2=0; $costo1 =0;$fecha_costo1=$sfecha;$costo2=0;$fecha_costo2=$sfecha;$costo3=0;$fecha_costo3=$sfecha; $status=""; $inf_usuario="";
$equipo = getenv("COMPUTERNAME"); $inf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $url="Act_Def_Serv.php?Gcod_servicio=C".$cod_servicio;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select cod_servicio,aprobado from COMP077 WHERE cod_servicio='$cod_servicio'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE SERVICIO NO EXISTE');</script><? }
    else{  $registro=pg_fetch_array($resultado,0);  $prev_aprobado=$registro["aprobado"];
     if($prev_aprobado=="S"){$error=1; ?> <script language="JavaScript"> muestra('SERVICIO YA APROBADO');</script><? } 
	 else{$part="000001";
     $StrSQL="Select max(cod_servicio) As cod_servicio FROM COMP027 where substring(cod_servicio,1,3)='$ramo'"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
     if($filas>0){$registro=pg_fetch_array($resultado); $part=$registro["cod_servicio"];  $part=substr($part,4,6); if(is_numeric($part)){$part=$part+1;}else{$part="000001";} $part=Rellenarcerosizq($part,6); } $cod_aux2=$ramo.'-'.$part; }	 
  } 
  if($error==0){if(strlen($cod_aux2)==10){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD CODIGO DE SERVICIO INVALIDA');</script><?} }
  if($error==0){if(strlen($denominacion)==0){$error=1; ?> <script language="JavaScript"> muestra('DESCRIPCIÓN INVALIDA');</script><?} }
  if($error==0){$sSQL="Select cod_par_ramo_ser from COMP026 WHERE cod_ramo_ser='$ramo'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('CODIGO RAMO DE SERVICIO NO EXISTE');</script><?}else{$registro=pg_fetch_array($resultado); $cod_par_ramo_ser=$registro["cod_par_ramo_ser"];}}
  if($error==0){if($ramo==substr($cod_aux2,0,3)){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE SERVICIO INVALIDO');</script><?}}
  if($error==0){$l=strlen($cod_par_ramo_ser); if($cod_par_ramo_ser==substr($partida,0,$l)){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE PARTIDA INVALIDO');</script><?} }
  if($error==0){$sSQL="Select cod_servicio,des_servicio from COMP027 WHERE des_servicio='$denominacion'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('SERVICIO YA EXISTE CON LA MISMA DESCRIPCION');</script><? }}
  if($error==0){$sSQL="SELECT ACTUALIZA_COMP077(4,'$cod_servicio','$denominacion','$ramo','$tipo_servicio','$partida','$cod_contable','$unidad_medida','$observacion',$ultimo_costo,'$fecha_u_costo',$impuesto,'$status','$cod_aux1','$cod_aux2','$campo_str1','$campo_str2',$campo_num1,$campo_num2,'$fecha_creado','$aprobado','$fecha_aprobada','$usuario_aprueba','$inf_usuario')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('APROBO EXITOSAMENTE');</script><?}
  }
}pg_close();
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>
