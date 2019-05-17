<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");   $fecha_hoy=asigna_fecha_hoy();
$tipo_desde=$_POST["txttipo_desde"]; $tipo_hasta=$_POST["txttipo_hasta"]; $cod_desde=$_POST["txtcod_desde"]; $cod_hasta=$_POST["txtcod_hasta"]; $condicion=$_POST["txtcondicion"];
$sueldo_actual=$_POST["txtsueldo_actual"]; $sueldo_nuevo=$_POST["txtsueldo_nuevo"]; $cod_cargod=$_POST["txtcodigo_cargo_d"]; $cod_cargoh=$_POST["txtcodigo_cargo_h"];
$cod_sueldo=$_POST["txtcod_sueldo"]; $cod_ret=$_POST["txtcod_ret"];  $fecha_asigna=$_POST["txtfecha_asigna"]; $usar=$_POST["txtusar"];
$sueldo_actual=formato_numero($sueldo_actual); if(is_numeric($sueldo_actual)){$sueldo_actual=$sueldo_actual;}else{$sueldo_actual=0;} 
$sueldo_nuevo=formato_numero($sueldo_nuevo); if(is_numeric($sueldo_nuevo)){$sueldo_nuevo=$sueldo_nuevo;}else{$sueldo_nuevo=0;} 
echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  $error=0; $existe_ret=0;
    $sSQL="Select cod_concepto from NOM002 WHERE tipo_nomina='$tipo_desde' and cod_concepto='$cod_sueldo'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CONCEPTO SUELDO NO EXISTE');</script><? }
    $sSQL="Select cod_concepto from NOM002 WHERE tipo_nomina='$tipo_desde' and cod_concepto='$cod_ret'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado); 
	/*
	if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CONCEPTO RETROACTIVO NO EXISTE');</script><? }
	*/
	if($filas>=1){ $existe_ret=1; }
	if(($usar=="SUELDO CARGO")or($usar=="TABLA GRADOS Y PASOS")) { $error=$error; } else{
    if($sueldo_actual==0){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE SUELDO ACTUAL INVALIDO');</script><?}
	if($sueldo_nuevo==0){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE SUELDO NUEVO INVALIDO');</script><?} }
	if($error==0){if(checkData($fecha_asigna)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA ASIGNACION NO ES VALIDA');</script><?}}
    if($error==0){ $diferencia=$sueldo_nuevo-$sueldo_actual;  $sfechaa=formato_aaaammdd($fecha_asigna); 
	  $sql="select * from nom006 where (nom006.sueldo=$sueldo_actual) and (nom006.status='ACTIVO' or nom006.status='REPOSO' or nom006.status='PERMISO RE' or nom006.status='VACACIONES' or nom006.status='PERMISO NO') and (tipo_nomina>='$tipo_desde' and tipo_nomina<='$tipo_hasta') and (cod_empleado>='$cod_desde' and cod_empleado<='$cod_hasta') and (cod_cargo>='$cod_cargod' and cod_cargo<='$cod_cargoh') order by cod_empleado"; 
      if($condicion=="MENOR"){  $sql="select * from nom006 where (nom006.sueldo<$sueldo_actual) and (nom006.status='ACTIVO' or nom006.status='REPOSO' or nom006.status='PERMISO RE' or nom006.status='VACACIONES' or nom006.status='PERMISO NO') and (tipo_nomina>='$tipo_desde' and tipo_nomina<='$tipo_hasta') and (cod_empleado>='$cod_desde' and cod_empleado<='$cod_hasta') and (cod_cargo>='$cod_cargod' and cod_cargo<='$cod_cargoh') order by cod_empleado"; }
	  if(($usar=="SUELDO CARGO")or($usar=="TABLA GRADOS Y PASOS")) {$sql="select * from nom006 where (nom006.status='ACTIVO' or nom006.status='REPOSO' or nom006.status='PERMISO RE' or nom006.status='VACACIONES' or nom006.status='PERMISO NO') and (tipo_nomina>='$tipo_desde' and tipo_nomina<='$tipo_hasta') and (cod_empleado>='$cod_desde' and cod_empleado<='$cod_hasta') and (cod_cargo>='$cod_cargod' and cod_cargo<='$cod_cargoh') order by cod_empleado"; }
      $res=pg_query($sql);
	  while($reg=pg_fetch_array($res)){ 
         $cod_empleado=$reg["cod_empleado"]; $fecha_ingreso=$reg["fecha_ingreso"]; $nombre=$reg["nombre"]; $tipo_nomina=$reg["tipo_nomina"]; $sueldo=$reg["sueldo"];
		 $cod_cargo=$reg["cod_cargo"]; $cod_departam=$reg["cod_departam"]; $cod_tipo_personal=$reg["cod_tipo_personal"]; $des_cargo=""; $des_departamento=""; $sueldo_cargo=$sueldo_nuevo;
		 $paso=$reg["paso"]; $grado=$reg["grado"]; $prima=$reg["prima"]; $compensacion=$reg["compensacion"]; $otros=$reg["otros"]; $sueldo_integral=$reg["sueldo_integral"];		 
		 $sSQL="Select denominacion,sueldo_cargo from NOM004 WHERE codigo_cargo='$cod_cargo'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CARGO NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado); $des_cargo=$registro["denominacion"]; $sueldo_cargo=$registro["sueldo_cargo"]; }
         $sSQL="Select descripcion_dep from NOM005 WHERE codigo_departamento='$cod_departam'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE DEPARTAMENTO NO EXISTE');</script><?}else{$registro=pg_fetch_array($resultado); $des_departamento=$registro["descripcion_dep"];}
         if ($usar=="SUELDO CARGO") { $sueldo_nuevo=$sueldo_cargo; } 
		 if ($usar=="TABLA GRADOS Y PASOS") {
			$sueldo_paso=0; $sueldo_grado=0; $msuel=0; $mcompen=0;
		    $sqlg="SELECT * FROM NOM040 where cod_tipo_personal='$cod_tipo_personal' and grado='$grado' and  paso='$paso'"; $resg=pg_query($sqlg); $filasg=pg_num_rows($resg);
		    if($filasg>=1){ $registrog=pg_fetch_array($resg,0);   $sueldo_paso=$registrog["monto"]; }   
		    $sqlg="SELECT * FROM NOM040 where cod_tipo_personal='$cod_tipo_personal' and grado='$grado' and  paso='000'"; $resg=pg_query($sqlg); $filasg=pg_num_rows($resg);
		    if($filasg>=1){ $registrog=pg_fetch_array($resg,0);   $sueldo_grado=$registrog["monto"]; }
		    if($sueldo_grado==0){ $msuel=$sueldo_paso; } else{ $msuel=$sueldo_grado;  $mcompen=$sueldo_paso-$sueldo_grado;  }
			$sueldo_nuevo=$msuel; $compensacion=$mcompen;
		 } $diferencia=$sueldo_nuevo-$sueldo_actual;
		 //echo $cod_empleado." ".$diferencia." ".$sueldo_nuevo,"<br>"; 
		 if(($diferencia>0)and($sueldo_nuevo>0)){
		   $sSQL="Update nom006 set sueldo=$sueldo_nuevo where cod_empleado='$cod_empleado'"; 
		   $sSQL="Select ACTUALIZA_NOM008(2,'$cod_empleado','$sfechaa','$cod_cargo','$cod_departam','$des_cargo','$des_departamento','$cod_tipo_personal','$paso','$grado','',$sueldo_nuevo,$prima,$compensacion,$otros,$sueldo_integral,'$tipo_nomina','$cod_sueldo','')";
		   $resultado=pg_exec($conn,$sSQL); $errore=pg_errormessage($conn); 		 
		   //echo $cod_empleado." ".$sSQL,"<br>"; 		 
		   if(!$resultado){ echo "Actualizando Trabajador ".$cod_empleado." ".$errore,"<br>"; ?><script language="JavaScript">muestra('<? echo substr($errore,0,70); ?>');</script><?  }
		   else{
		    if($existe_ret==1){
		      $sSQL="Update nom011 set monto=$diferencia where cod_empleado='$cod_empleado' and tipo_nomina='$tipo_nomina' and cod_concepto='$cod_ret'";	
              $resultado=pg_exec($conn,$sSQL); $errore=pg_errormessage($conn); 
              if(!$resultado){ echo $sSQL,"<br>"; echo "Actualizando Retroactivo Trabajador ".$cod_empleado,"<br>"; ?><script language="JavaScript">muestra('<? echo substr($errore,0,90); ?>');</script><?  }		   
            }
		   }	
         }
	  }	
	}
 }
pg_close(); 
if($error==0){?><script language="JavaScript"> muestra('Proceso Finalizado'); window.close(); window.opener.location.reload(); </script> <?}else{?><script language="JavaScript">history.back();</script><?}
?> 

