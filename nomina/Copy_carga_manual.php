<?include ("../class/conect.php");  include ("../class/funciones.php");$tipo_nomina=$_POST["txttipo_nomina"]; $cod_concepto=$_POST["txtcod_concepto"]; $criterio=$_POST["txtcriterio"];
$can_monto=$_POST["txtcan_monto"]; $con_ori=$_POST["txtcon_ori"]; $con_des=$_POST["txtcon_des"];  $fecha_hoy=asigna_fecha_hoy();
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR COPIANDO....","<br>";
$url="Det_carga_manual.php?criterio=".$criterio; $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sfecha=formato_aaaammdd($fecha_hoy); $error=0; $cant_mod=0;
   $sql="Select cod_empleado,monto,cantidad,activoa,calculable,frecuenciaa from CONCEPTOS_ASIGNADOS where tipo_nomina='$tipo_nomina' and cod_concepto='$con_ori' and (statust='ACTIVO' or statust='PERMISO RE' or statust='VACACIONES' or statust='PERMISO NO' or statust='REPOSO') and (cod_empleado in (select cod_empleado from nom011 where tipo_nomina='$tipo_nomina' and cod_concepto='$con_des'))"; $res=pg_query($sql);
   while(($registro=pg_fetch_array($res))and($error==0)){ $opcion=0; $valido=0; $cod_empleado=$registro["cod_empleado"]; $frec=$registro["frecuenciaa"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"];
     if($can_monto=="MONTO"){$opcion=3; $valido=1;}else{$opcion=2; $valido=1;}
     if($valido==1){ $sSQL="SELECT ACT_MOVIMIENTO_NOM011($opcion,'$tipo_nomina','$cod_empleado','$con_des',$cantidad,$monto,'SI','SI','$frec')";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0; $cant_mod=$cant_mod+1;} }
   }
}pg_close(); if($error==0){?><script language="JavaScript">muestra('COPIO EXITOSAMENTE, CATIDAD: '+'<? echo $cant_mod; ?>'); document.location='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>


