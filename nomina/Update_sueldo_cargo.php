<?include ("../class/conect.php");  include ("../class/funciones.php");   $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$tipo_nomina=$_POST["txttipo_nomina"]; $cod_concepto=$_POST["txtcod_concepto"]; $nuevo_reg=$_POST["txtnuevo_reg"]; $fecha_reg=$_POST["txtfecha_reg"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sql="SELECT NOM006.cod_empleado,NOM006.tipo_nomina,NOM008.fecha_asigna,NOM001.con_sue_bas,NOM001.con_compen,NOM008.cod_cargo,NOM008.cod_departamento,NOM008.des_cargo,NOM008.des_departamento,NOM008.cod_tipo_personal,NOM008.paso,NOM008.grado,NOM008.sueldo,NOM008.compensacion,NOM008.prima,NOM008.otros,NOM008.sueldo_integral,NOM008.observacion FROM NOM006,NOM001,NOM008 WHERE (NOM001.tipo_nomina=NOM006.tipo_nomina) AND (NOM008.cod_empleado=NOM006.cod_empleado) AND (NOM008.fecha_asigna=NOM006.fecha_asigna_cargo) AND (NOM006.Status='ACTIVO' or NOM006.Status='PERMISO RE' or NOM006.Status='VACACIONES' or NOM006.Status='PERMISO NO') And (NOM006.tipo_nomina='$tipo_nomina') Order by NOM006.cod_empleado"; $res=pg_query($sql);
 while($registro=pg_fetch_array($res)){ $continua=true; $cod_empleado=$registro["cod_empleado"]; $cod_conc_s=$registro["con_sue_bas"]; $cod_conc_c=$registro["con_compen"];  $cod_emp=$registro["cod_empleado"];
   $fecha=$registro["fecha_asigna"]; $cod_car=$registro["cod_cargo"]; $des_cargo=$registro["des_cargo"]; $cod_dep=$registro["cod_departamento"]; $des_departam=$registro["des_departamento"];
   $cod_tipo_personal=$registro["cod_tipo_personal"]; $paso=$registro["paso"]; $grado=$registro["grado"]; $sueldo=$registro["sueldo"]; $compensa=$registro["compensacion"];
   $prima=$registro["prima"]; $prima=0; $otros=$registro["otros"]; $sueldo_integral=$registro["sueldo_integral"]; $observacion=$registro["observacion"]; $monto=0;
   $sSQL="Select monto from NOM011 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto' and cod_empleado='$cod_empleado'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
   if($filas==0){$continua=false; $monto=0;}else{$reg=pg_fetch_array($resultado); $monto=$reg["monto"]; }
   if(($continua==true)and($monto!=$sueldo)){if($nuevo_reg=="SI"){$fecha=formato_aaaammdd($fecha_reg);} $sSQL="SELECT ACTUALIZA_NOM008(4,'$cod_empleado','$fecha','$cod_car','$cod_dep','$des_cargo','$des_departam','$cod_tipo_personal','$grado','$paso','$observacion',$monto,$prima,$compensa,$otros,$sueldo_integral,'$tipo_nomina','$cod_conc_s','$cod_conc_c')";  echo $sSQL;
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;} }
 }
}pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>

