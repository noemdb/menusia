<?include ("../class/conect.php");  include ("../class/funciones.php");
$tipo_nomina=$_POST["txttipo_nomina"]; $cod_concepto=$_POST["txtcod_concepto"]; $cod_empleado=$_POST["txtcod_empleado"];
$fecha_ini=$_POST["txtfecha_ini"]; $fecha_exp=$_POST["txtfecha_exp"]; $activo=$_POST["txtactivo"]; $calculable=$_POST["txtcalculable"];
$cantidad=$_POST["txtcantidad"]; $monto=$_POST["txtmonto"]; $acumulado=$_POST["txtacumulado"]; $saldo=$_POST["txtsaldo"];
$frec=$_POST["txtfrecuencia"];  $cod_presup=$_POST["txtcod_presup"]; $afecta_presup=$_POST["txtafecta_presup"]; $imp_fija=$_POST["txtimp_fija"];  $cod_retencion=$_POST["txtcod_retencion"];
if($frec=="PRIMERA QUINCENA"){$frecuencia="1";} if($frec=="SEGUNDA QUINCENA"){$frecuencia="2";} if($frec=="PRIMERA Y SEGUNDA QUINCENA"){$frecuencia="3";}
if($frec=="PRIMERA SEMANA"){$frecuencia="4";} if($frec=="SEGUNDA SEMANA"){$frecuencia="5";} if($frec=="TERCERA SEMANA"){$frecuencia="6";}
if($frec=="CUARTA SEMANA"){$frecuencia="7";} if($frec=="QUINTA SEMANA"){$frecuencia="8";} if($frec=="TODAS LAS SEMANAS"){$frecuencia="9";} if($frec=="ULTIMA SEMANA"){$frecuencia="0";}
$fecha_hoy=asigna_fecha_hoy(); $status=substr($imp_fija,0,1); $cantidad=formato_numero($cantidad); if(is_numeric($cantidad)){$cantidad=$cantidad;}else{$cantidad=0;} $monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;}else{$monto=0;}
$acumulado=formato_numero($acumulado); if(is_numeric($acumulado)){$acumulado=$acumulado;}else{$acumulado=0;} $saldo=formato_numero($saldo); if(is_numeric($saldo)){$saldo=$saldo;}else{$saldo=0;}
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_asig_concep_ar.php?Gcodigo=C".$tipo_nomina.$cod_concepto.$cod_empleado; $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select cod_concepto from NOM011 WHERE tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado' and cod_concepto='$cod_concepto'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
   if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('ASIGNACION DE CONCEPTO YA EXISTE');</script><? }  $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
   $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} $long_c=strlen($formato_presup); $c=strlen($formato_categoria)+2; $p=strlen($formato_partida);
   if($error==0){ if ($gnomina=="00"){$error=0;} else {  if($tipo_nomina<>$gnomina) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO ACTIVA PARA EL USUARIO');</script><?}  } } 
   if($error==0){if(strlen($cod_concepto)==3){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD DE CONCEPTO INVALIDA');</script><? } }
   if($error==0){$sSQL="Select cod_concepto from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CONCEPTO NO EXISTE');</script><? }}
   if($error==0){$sSQL="Select tipo_nomina,descripcion,con_sue_bas,con_compen,g_orden_pago,frecuencia from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA NO EXISTE');</script><?}else{$registro=pg_fetch_array($resultado); $g_orden_pago=$registro["g_orden_pago"]; $frec_nom=$registro["frecuencia"]; $cod_conc_s=$registro["con_sue_bas"]; $cod_conc_c=$registro["con_compen"];}}
   if($error==0){if($frec_nom=="Q"){ if(($frecuencia=="1")or($frecuencia=="2")or($frecuencia=="3")){$error=0;}else{$error=1;?><script language="JavaScript">muestra('FRECUENCIA NO VALIDA PARA ESTE TIPO DE NOMINA');</script><?}}}
   if($error==0){if($frec_nom=="M"){ if(($frecuencia=="1")or($frecuencia=="2")or($frecuencia=="3")){$error=0;}else{$error=1;?><script language="JavaScript">muestra('FRECUENCIA NO VALIDA PARA ESTE TIPO DE NOMINA');</script><?}}}
   if($error==0){if($frec_nom=="S"){ if(($frecuencia=="4")or($frecuencia=="5")or($frecuencia=="6")or($frecuencia=="7")or($frecuencia=="8")or($frecuencia=="9")or($frecuencia=="0")){$error=0;}else{$error=1;?><script language="JavaScript">muestra('FRECUENCIA NO VALIDA PARA ESTE TIPO DE NOMINA');</script><?}}}
   if($error==0){if(checkData($fecha_ini)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA INCIO NO ES VALIDA');</script><?}}
   if($error==0){if(checkData($fecha_exp)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA EXPIRACION NO ES VALIDA');</script><?}}
   if($error==0){$sql="SELECT NOM006.cod_empleado,NOM006.tipo_nomina,NOM006.fecha_ingreso,NOM006.cod_categoria FROM NOM006 Where cod_empleado='$cod_empleado'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado); if($filas==0){$error=1;?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? }
     else{$registro=pg_fetch_array($resultado); $nom_emp=$registro["tipo_nomina"]; if($tipo_nomina!=$nom_emp){$error=1;?><script language="JavaScript"> muestra('TRABAJADOR NO PERTENECE A ESTA NOMINA');</script><? } } }
   if(($error==0)and($afecta_presup=="SI")and($cod_retencion!="000")and($g_orden_pago=="S")){$sSQL="Select cod_contable from PAG003 WHERE tipo_retencion='$cod_retencion'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE RETENCION NO EXISTE');</script><? }}
   if(($error==0)and($afecta_presup=="SI")and($g_orden_pago=="S")and($cod_presup=="")){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO INVALID0');</script><? }
   if(($error==0)and($afecta_presup=="SI")and($g_orden_pago=="S")){$sSQL="Select cod_presup,denominacion from pre001 WHERE (cod_presup='$cod_presup') and (length(cod_presup)=".$long_c.")"; echo $sSQL; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO NO EXISTE');</script><? }}
   if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);    $sfechai=formato_aaaammdd($fecha_ini); $sfechae=formato_aaaammdd($fecha_exp);
    $sSQL="SELECT ACTUALIZA_NOM011(1,'$tipo_nomina','$cod_empleado','$cod_concepto',$cantidad,$monto,'$sfechai','$sfechae','$activo','$calculable',$acumulado,$saldo,'$cod_presup','$frecuencia','$afecta_presup','$cod_retencion','','N',0,0,0,'$status','$minf_usuario')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}
  }
}pg_close();if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>