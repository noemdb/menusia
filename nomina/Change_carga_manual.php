<?include ("../class/conect.php");  include ("../class/funciones.php");$tipo_nomina=$_POST["txttipo_nomina"]; $cod_concepto=$_POST["txtcod_concepto"]; $criterio=$_POST["txtcriterio"];
$can_monto=$_POST["txtcan_monto"]; $val_camb=$_POST["txtval_camb"]; $val_actual=$_POST["txtval_actual"]; $val_nuevo=$_POST["txtval_nuevo"]; $val_camb=substr($val_camb,0,5);
$cod_cargod=$_POST["txtcodigo_cargo_d"]; $cod_cargoh=$_POST["txtcodigo_cargo_h"];
$fecha_hoy=asigna_fecha_hoy(); $val_actual=formato_numero($val_actual); if(is_numeric($val_actual)){$val_actual=$val_actual;}else{$val_actual=0;} $val_nuevo=formato_numero($val_nuevo); if(is_numeric($val_nuevo)){$val_nuevo=$val_nuevo;}else{$val_nuevo=0;}
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR CAMBIANDO....","<br>";
$url="Det_carga_manual.php?criterio=".$criterio; $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sfecha=formato_aaaammdd($fecha_hoy); $error=0; $cant_mod=0;
   $sql="Select * from CONCEPTOS_ASIGNADOS where (tipo_nomina='$tipo_nomina') and (cod_concepto='$cod_concepto') and (cod_cargo>='$cod_cargod' and cod_cargo<='$cod_cargoh') and (statust='ACTIVO' or statust='PERMISO RE' or statust='VACACIONES' or statust='PERMISO NO' or statust='REPOSO')"; $res=pg_query($sql);
   while(($registro=pg_fetch_array($res))and($error==0)){ $opcion=0; $valido=0; $cod_empleado=$registro["cod_empleado"]; $frec=$registro["frecuencia"]; $cantidad=$registro["cantidad"]; $monto=$registro["monto"];
     if($can_monto=="MONTO"){$opcion=3; if($val_camb=="TODOS"){$valido=1;}else{if($val_actual==$monto){$valido=1;}} $monto=$val_nuevo;} else{$opcion=2; if($val_camb=="TODOS"){$valido=1;}else{if($val_actual==$cantidad){$valido=1;}} $cantidad=$val_nuevo;}
     if($valido==1){ $sSQL="SELECT ACT_MOVIMIENTO_NOM011($opcion,'$tipo_nomina','$cod_empleado','$cod_concepto',$cantidad,$monto,'SI','SI','$frec')";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0; $cant_mod=$cant_mod+1;} }
   }
}pg_close(); 
if($error==0){?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE, CATIDAD: '+'<? echo $cant_mod; ?>'); document.location='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>

