<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $error=0; $sfecha=formato_aaaammdd($fecha_hoy);   $codigo_mov=$_POST["txtcodigo_mov"];
$cod_estructura=$_POST["txtcod_estructura"]; $tp_calculo=$_POST["txttipo_calculo"];  $fecha_hasta=$_POST["txtfecha_hasta"]; $tipo_pago=$_POST["txttipo_pago"]; $ref_comp=$_POST["txtref_comp"]; $num_periodos=$_POST["txtnum_periodos"];
$det_trab=$_POST["txtdet_trab"]; $concepto_t=$_POST["txtconcepto_t"]; $tipo_nom=$_POST["txttipo_nom"]; $referencia_comp=$_POST["txtreferencia_comp"];  $tipo_compromiso=$_POST["txttipo_compromiso"]; 
$mformula=""; $fechah=formato_aaaammdd($fecha_hasta);  $ref_imput_presu="00000000";  $tipo_imput_presu="P";
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR GENERANDO ESTRUCTURA....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $criterio=$tp_calculo.$cod_estructura.substr($tipo_pago,0,1);
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{ $resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT BORRAR_PAG028('$codigo_mov')");  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030(4,'$codigo_mov','','',0)");
$resultado=pg_exec($conn,"SELECT BORRAR_PAG043('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT BORRAR_PAG044('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT BORRAR_PAG045('$codigo_mov')");
 $formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX";
$sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql);  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
$fecha_d=""; $fecha_h="";  $lc=strlen($formato_categoria)+2; $lp=32-$lc;
$sql="SELECT tipo_nomina,descripcion,bloqueada,bloqueada_ext FROM NOM001 WHERE ((cod_relac_nom='$cod_estructura') or (cod_relac_ext='$cod_estructura') or (cod_relac_apo='$cod_estructura') or (cod_relac_vac='$cod_estructura'))"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){$v=0; if($tp_calculo=="N"){if($registro["bloqueada"]=="N"){$v=1;}}else{if($registro["bloqueada_ext"]=="N"){$v=1;}} 
if($v==1){$tipo=$registro["tipo_nomina"]; if($mformula!=""){$mformula=$mformula." or ";}  $mformula=$mformula."(tipo_nomina='$tipo')";} }
if($mformula==""){$error=1;?> <script language="JavaScript">muestra('NO EXISTEN NOMINAS SELECCIONADAS');</script><? }
if($error==0){$mformula="(".$mformula.")";  if($tipo_pago=="TODOS"){$mformula=$mformula;}else{$mformula=$mformula." and (tipo_pago='$tipo_pago')";} }
if(($error==0)and($ref_comp=="NO")){ $referencia_comp='00000000'; $tipo_compromiso='0000';
  $sqlu="update pag009 set ref_comp_est='00000000',tipo_comp_est='0000' WHERE (cod_estructura='$cod_estructura')"; $resultado=pg_exec($conn,$sqlu);}
if($error==0){	
  if ($referencia_comp=='00000000'){ $sql="SELECT * FROM pag009 WHERE (cod_estructura='$cod_estructura')"; $res=pg_query($sql); $filas=pg_num_rows($res);
  if($filas>0){$reg=pg_fetch_array($res); $referencia_comp=$reg["ref_comp_est"]; $tipo_compromiso=$reg["tipo_comp_est"];  $ref_imput_presu=$reg["ref_imput_presu"]; $tipo_imput_presu=$reg["tipo_imput_presu"];} }
}
if($error==0){ 
if($tipo_nom=="ACTUAL"){ $tabla="NOM017"; $mformula=$mformula; }else{ $tabla="NOM019"; $mformula=$mformula." and (fecha_p_hasta='$fechah')"; }
if($tp_calculo=="E") { $mformula=$mformula." and (num_periodos='$num_periodos')";  }
$sql="SELECT fecha_p_desde,fecha_p_hasta FROM ". $tabla." Where (Oculto='NO') and (asignacion='SI') and  (afecta_presup='SI') And (Cod_Concepto<>'VVV') And (tp_calculo='$tp_calculo') And  ". $mformula ." order by tipo_nomina";  
$resultado=pg_query($sql); $filas=pg_num_rows($resultado);
//echo $sql." ".$tp_calculo." ".$filas;
  if($filas>0){$regis=pg_fetch_array($resultado); $fecha_d=$regis["fecha_p_desde"]; $fecha_h=$regis["fecha_p_hasta"]; } else{$error=1;?> <script language="JavaScript">muestra('NO EXISTEN NOMINAS CALCULADAS');</script><? }
} $criterio=$criterio.$fecha_d.$fecha_h; $url="Mostrar_est_orden.php?criterio=".$criterio;
if($error==0){
if($concepto_t=="NOMINA"){$mformula=$mformula." and ((concepto_vac='N'))";}
if($concepto_t=="VACACIONES"){$mformula=$mformula." and ((concepto_vac='S') and (cod_concepto<>'VVV')) ";}
$sql="SELECT cod_presup,cod_contable,sum(monto) as monto_c FROM ". $tabla." Where (Oculto='NO') and (asignacion='SI') and  (afecta_presup='SI') And (Cod_Concepto<>'VVV') And (Tp_Calculo='$tp_calculo') And  ". $mformula ." group by cod_presup,cod_contable order by cod_presup,cod_contable";   $res=pg_query($sql);
//echo $sql,"<br>";
while($reg=pg_fetch_array($res)){ $cod_presup=$reg["cod_presup"]; $monto_c=$reg["monto_c"]; $cod_fuente="00"; $cod_fuente=$reg["cod_contable"]; $monto_c=cambia_coma_numero($monto_c);
$resultado=pg_exec($conn,"SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$cod_fuente','$referencia_comp','$tipo_compromiso','','0000','','0000','','0000','','','','','','','$sfecha','F','$tipo_imput_presu','$ref_imput_presu','$sfecha',$monto_c,0,0,0)"); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}
$sql="SELECT cod_presup,cod_contable, sum(monto) as monto_c FROM ". $tabla." Where (Oculto='NO') and (asignacion='NO') and (cod_retencion='000') and  (afecta_presup='SI') And (Cod_Concepto<>'VVV') And (Tp_Calculo='$tp_calculo') And  ". $mformula ." group by cod_presup,cod_contable order by cod_presup";   $res=pg_query($sql);
//echo $sql,"<br>";
while($reg=pg_fetch_array($res)){ $cod_presup=$reg["cod_presup"]; $monto_c=$reg["monto_c"]; $cod_fuente="00"; $cod_fuente=$reg["cod_contable"];
$sSQL="SELECT monto FROM PRE026 where codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and ref_imput_presu='$ref_imput_presu' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'";  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
if($filas>0){ $registro=pg_fetch_array($resultado); $monto=$registro["monto"]-$monto_c; $monto=cambia_coma_numero($monto); $monto_c=cambia_coma_numero($monto_c);
$resultado=pg_exec($conn,"SELECT MOD_MONTO_PRE026('$codigo_mov','$cod_presup','$cod_fuente','$referencia_comp','$tipo_compromiso','$ref_imput_presu',$monto,0)"); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
}else{$error=1;?> <script language="JavaScript">muestra('CODIGO PRESUPUESTARIO <? echo $cod_presup." ".$cod_fuente; ?> \n ASOCIADO AL CONCEPTO DE RETENCION, NO TIENE IMPUTACION ');</script><?}}
$sql="SELECT cod_retencion,cod_presup,cod_contable, sum(monto) as monto_r FROM ". $tabla." Where (Oculto='NO') and (asignacion='NO') and (cod_retencion<>'000') and  (afecta_presup='SI') And (Cod_Concepto<>'VVV') And (Tp_Calculo='$tp_calculo') And  ". $mformula ." group by cod_retencion,cod_presup,cod_contable order by cod_retencion,cod_presup";   $res=pg_query($sql);
//echo $sql,"<br>";
while($reg=pg_fetch_array($res)){ $cod_presup=$reg["cod_presup"]; $cod_retencion=$reg["cod_retencion"];  $monto_r=$reg["monto_r"]; $cod_fuente="00"; $cod_fuente=$reg["cod_contable"];
$sSQL="SELECT  descripcion_ret,ced_rif_ret from PAG003 where tipo_retencion='$cod_retencion'";$resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
if($filas>0){$regis=pg_fetch_array($resultado); $ced_rif_ret=$regis["ced_rif_ret"]; }else{$ced_rif_ret="";}
$sSQL="SELECT monto FROM PRE026 where codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and ref_imput_presu='$ref_imput_presu' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'";  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
if($filas>0){$sSQL="SELECT ACTUALIZA_PAG028(1,'$codigo_mov','00000000','$cod_retencion','$referencia_comp','$tipo_compromiso','$cod_presup','$cod_fuente','$ref_imput_presu','0000','',0,0,$monto_r,0,'R','$ced_rif_ret','','S','0000','0000','')";  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);$error="ERROR GRABANDO: ".substr($error, 0, 61);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}
else{$error=1;?> <script language="JavaScript">muestra('CODIGO PRESUPUESTARIO <? echo $cod_presup." ".$cod_fuente; ?> \n ASOCIADO AL CONCEPTO DE RETENCION, NO TIENE IMPUTACION ');</script><?}}
$c=$lc-1;
$sql="SELECT substring(cod_presup,$lc,$lp) as cod_p,sum(monto) as monto_c FROM ". $tabla." Where (Oculto='NO') and (asignacion='SI') and  (afecta_presup='NO') And (Cod_Concepto<>'VVV') And (Tp_Calculo='$tp_calculo') And  ". $mformula ." group by cod_presup order by substring(cod_presup,$lc,$lp)";   $res=pg_query($sql);
//echo $sql,"<br>";
while($reg=pg_fetch_array($res)){ $cod_presup=$reg["cod_p"]; $monto_c=$reg["monto_c"];  $codigo_cuenta=$cod_presup; $debito_credito="D";
$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 ('1','$codigo_mov','$codigo_cuenta','$debito_credito','$monto_c')"); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
}
if(($det_trab=="SI")and($error==0)){  
$mcod_empleado=""; $mcedula=""; $mnombre=""; $mmonto_benef=0; $i=0;
$sql="SELECT cod_empleado,cedula,nombre,cod_presup,cod_contable,sum(monto) as monto_c FROM ". $tabla." Where (Oculto='NO') and (asignacion='SI') and  (afecta_presup='SI') And (Cod_Concepto<>'VVV') And (Tp_Calculo='$tp_calculo') And  ". $mformula ." group by cod_empleado,cedula,nombre,cod_presup,cod_contable order by cod_empleado,cedula,nombre,cod_presup,cod_contable";   $res=pg_query($sql);
//echo $sql,"<br>";
while($reg=pg_fetch_array($res)){ if($i==0){$mcod_empleado=$reg["cod_empleado"]; $mcedula=$reg["cedula"]; $mnombre=$reg["nombre"];}
 if($mcod_empleado<>$reg["cod_empleado"]){    $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG043(1,'$codigo_mov','$cod_estructura','$mcod_empleado','$mcedula','$mnombre',$mmonto_benef)"); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
   $mcod_empleado=$reg["cod_empleado"]; $mcedula=$reg["cedula"]; $mnombre=$reg["nombre"]; $mmonto_benef=0;
 }
 $cod_empleado=$reg["cod_empleado"]; $cedula=$reg["cedula"]; $nombre=$reg["nombre"]; $cod_presup=$reg["cod_presup"]; $monto_c=$reg["monto_c"]; $cod_fuente=$reg["cod_contable"];
 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG044(1,'$codigo_mov','$cod_estructura','$cod_empleado','$cedula','$cod_presup','$cod_fuente','$referencia_comp','$tipo_compromiso',$monto_c)"); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
 $i=$i+1;  $mmonto_benef=$mmonto_benef+$monto_c;
}  
if( $mmonto_benef<>0){$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG043(1,'$codigo_mov','$cod_estructura','$mcod_empleado','$mcedula','$mnombre',$mmonto_benef)"); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}
}
$mcod_empleado=""; $mcedula=""; $mnombre=""; $mmonto_benef=0; $i=0;
$sql="SELECT cod_empleado,cedula,nombre,cod_presup,cod_contable, sum(monto) as monto_c FROM ". $tabla." Where (Oculto='NO') and (asignacion='NO') and (cod_retencion='000') and  (afecta_presup='SI') And (Cod_Concepto<>'VVV') And (Tp_Calculo='$tp_calculo') And  ". $mformula ." group by cod_empleado,cedula,nombre,cod_presup,cod_contable order by cod_empleado,cedula,nombre,cod_presup,cod_contable";   $res=pg_query($sql);
//echo $sql,"<br>";
while($reg=pg_fetch_array($res)){ 
  $cod_empleado=$reg["cod_empleado"]; $cedula=$reg["cedula"]; $nombre=$reg["nombre"]; $cod_presup=$reg["cod_presup"]; $monto_c=$reg["monto_c"]; $cod_fuente=$reg["cod_contable"];
  $monto=$monto_c*-1;  $monto=cambia_coma_numero($monto);
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG043(3,'$codigo_mov','$cod_estructura','$cod_empleado','$cedula','$nombre',$monto)"); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61);
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG044(3,'$codigo_mov','$cod_estructura','$cod_empleado','$cedula','$cod_presup','$cod_fuente','$referencia_comp','$tipo_compromiso',$monto)"); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); 
}
$sql="SELECT cod_empleado,cedula,cod_retencion,cod_presup,cod_contable, sum(monto) as monto_r FROM ". $tabla." Where (Oculto='NO') and (asignacion='NO') and (cod_retencion<>'000') and  (afecta_presup='SI') And (Cod_Concepto<>'VVV') And (Tp_Calculo='$tp_calculo') And  ". $mformula ." group by cod_empleado,cedula,cod_retencion,cod_presup,cod_contable order by cod_empleado,cedula,cod_retencion,cod_presup";   $res=pg_query($sql);
//echo $sql,"<br>";
while($reg=pg_fetch_array($res)){ 
$cod_empleado=$reg["cod_empleado"]; $cedula=$reg["cedula"]; $nombre=""; $cod_presup=$reg["cod_presup"]; $cod_retencion=$reg["cod_retencion"];  $monto_r=$reg["monto_r"]; $cod_fuente="00"; $cod_fuente=$reg["cod_contable"];
$sSQL="SELECT  descripcion_ret,ced_rif_ret from PAG003 where tipo_retencion='$cod_retencion'";$resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
if($filas>0){$regis=pg_fetch_array($resultado); $ced_rif_ret=$regis["ced_rif_ret"]; }else{$ced_rif_ret="";}
$sSQL="SELECT monto FROM PRE026 where codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$cod_fuente' and ref_imput_presu='$ref_imput_presu' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'";  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
if($filas>0){
$sSQL="SELECT ACTUALIZA_PAG045(1,'$codigo_mov','$cod_estructura','$cod_empleado','$cedula','$cod_retencion','$referencia_comp','$tipo_compromiso','$cod_presup','$cod_fuente',0,0,$monto_r,'$ced_rif_ret','')";  
//echo $sSQL,"<br>";
$resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);$error="ERROR GRABANDO: ".substr($error, 0, 61);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }}
else{$error=1;?> <script language="JavaScript">muestra('CODIGO PRESUPUESTARIO <? echo $cod_presup." ".$cod_fuente; ?> \n ASOCIADO AL CONCEPTO DE RETENCION, NO TIENE IMPUTACION ');</script><?}
$monto=$monto_r*-1;  $monto=cambia_coma_numero($monto);
$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG043(3,'$codigo_mov','$cod_estructura','$cod_empleado','$cedula','$nombre',$monto)"); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61);
//echo "SELECT ACTUALIZA_PAG043(3,'$codigo_mov','$cod_estructura','$cod_empleado','$cedula','$nombre',$monto)","<br>";  
}
}
if($error==0){?><script language="JavaScript">muestra('INFORMACION ORDEN DE PAGO GENERADA')</script><?}
}pg_close();
/* */
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}

?>