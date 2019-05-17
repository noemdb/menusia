<? include ("../class/seguridad.inc"); include ("../class/conects.php"); include("../class/fun_fechas.php"); include("../class/fun_numeros.php");   include ("../class/configura.inc"); $fecha_hoy=asigna_fecha_hoy();  $error=0; $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
  $tipo_formato=$_POST["txttipo_formato"]; 
function elimina_puntos($str){  $texto="";
  for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)==".") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  }
return $texto;}
function elimina_comas($str){$texto="";
  for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)==",") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  }
return $texto;}
 $str_campo="<br>";
if($tipo_formato=="TXT"){ $str_campo="\r\n"; }


$cod_arch_banco=$_POST["txtcod_arch_banco"];  $tipo_arch_banco=$_POST["txttipo_arch_banco"]; $den_arch_banco="ARCHIVO FAOV";
$cod_emp=$_POST["txtcod_emp"];  $tipo_calculo=$_POST["txttipo_calculo"];
$fecha_hasta=$_POST["txtfecha_hasta"]; $fecha_desde=$_POST["txtfecha_desde"]; $fechad=formato_aaaammdd($fecha_desde); $fechah=formato_aaaammdd($fecha_hasta);
$cod_concepto1=$_POST["txtcod_concepto_d"]; $cod_concepto2=$_POST["txtcod_concepto_h"]; $cod_concepto3=$_POST["txtcod_concepto"];
$medio_envio=strtoupper($_POST["txtacciond"]); $cod_moneda=strtoupper($_POST["txtaccionh"]); $cod_nomina_arch=strtoupper($_POST["txtaccion"]); 
$accion1=$medio_envio; $accion2=$cod_moneda; $accion3=$cod_nomina_arch; 

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $tipo_calculo=substr($tipo_calculo,0,1);
$sSQL="Select * from nom045 WHERE cod_arch_banco='$cod_arch_banco' and tipo_arch_banco='$tipo_arch_banco'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
if($filas>=1){$sSQL="SELECT ACTUALIZA_nom045(2,'$cod_arch_banco','$tipo_arch_banco','$den_arch_banco','','','','$cod_emp','$cod_nomina_arch','$medio_envio','$cod_moneda','$cod_concepto1','$cod_concepto2','$cod_concepto3','','','','$minf_usuario')";}
else{$sSQL="SELECT ACTUALIZA_nom045(1,'$cod_arch_banco','$tipo_arch_banco','$den_arch_banco','','','','$cod_emp','$cod_nomina_arch','$medio_envio','$cod_moneda','$cod_concepto1','$cod_concepto2','$cod_concepto3','','','','$minf_usuario')";}
$resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){ $error=1;?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
if($error==0){ $mformula="";
  $sql="SELECT nom046.tipo_nomina,nom001.descripcion FROM nom046,nom001 Where (nom046.tipo_nomina=nom001.tipo_nomina) And (Cod_Arch_Banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco')"; $res=pg_query($sql);
  
  while($registro=pg_fetch_array($res)){ $tipo=$registro["tipo_nomina"]; if($mformula!=""){$mformula=$mformula." or ";}  $mformula=$mformula."(tipo_nomina='$tipo')";}
  if($mformula==""){$error=1;?> <script language="JavaScript">muestra('NO EXISTEN NOMINAS SELECCIONADAS');</script><? }
  if($error==0){ $mformula="(".$mformula.")";
    if($tipo_calculo=="T"){ $mformula=$mformula." and ((nom019.tp_calculo='N')or(nom019.tp_calculo='E')) "; } else {$mformula=$mformula." and (nom019.tp_calculo='$tipo_calculo') ";}
    
    $sql="SELECT * FROM nom019 Where ((nom019.cod_concepto='$cod_concepto1') or (nom019.cod_concepto='$cod_concepto2') or (nom019.cod_concepto='$cod_concepto3') ) and ((nom019.fecha_proceso>='$fechad') and (nom019.fecha_proceso<='$fechah')) And ". $mformula ." order by char_length(nom019.cedula),nom019.cedula,nom019.cod_concepto";
    //echo $sql;
	$fecha_p=substr($fecha_hasta, 0, 2).substr($fecha_hasta, 3, 2).substr($fecha_hasta, 8, 2); $detalle=""; 
	$monto_tot=0; $monto_emp=0; $leidos=0; $num_linea=0; $prev_cedula=""; $prev_nombre=""; $prev_status=""; $prev_fecha=""; $num_emp=0; $monto_te=0; $monto_ta=0; $monto_r=0; $monto_e=0; $monto_a=0; $res=pg_query($sql);
	while($reg=pg_fetch_array($res)){ $cedula=$reg["cedula"]; $nombre=$reg["nombre"]; $status_calculo=$reg["status_calculo"]; $fecha_ingreso=$registro["fecha_ingreso"]; $cod_concepto=$reg["cod_concepto"];  $monto=$reg["monto"]; $cantidad=$reg["cantidad"]; $monto_orig=$reg["monto_orig"]; 
	  $valore=$reg["valore"]; $valoru=$reg["valoru"]; $valorq=$reg["valorq"]; $valorw=$reg["valorw"];  $valorx=$reg["valorx"]; $valory=$reg["valory"]; $valorz=$reg["valorz"];
	  if($prev_cedula==""){ $prev_cedula=$cedula; $prev_nombre=$nombre; $prev_status=$status_calculo; $prev_fecha=$fecha_ingreso;} 	  
	  if($prev_cedula!=$cedula){ $monto_emp=$monto_r+$monto_e+$monto_a; $fecha_i=$prev_fecha; $fecha_e="";
		if($monto_emp>0){ $nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $existe=0; $nacionalidad=substr($prev_status,1,1); $sexo=substr($prev_status,3,1);
		  $sSQL="Select * from TRABAJADORES where cedula='$prev_cedula'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
          if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $existe=1; $cod_empleado=$registro["cod_empleado"];  $nacionalidad=$registro["nacionalidad"]; $nacionalidad=substr($nacionalidad,0,1); $sexo=$registro["sexo"]; $sexo=substr($sexo,0,1);
		    $nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"];$apellido2=$registro["apellido2"]; $fecha_i=$registro["fecha_ingreso"]; $fecha_e=$registro["fecha_egreso"]; $status=$registro["status"];
			if(($fecha_e>=$fechah)and($fecha_e<=$fechah)){$fecha_e=$fecha_e;}else{$fecha_e="";}
			if(($status=='ACTIVO') OR ($status=='REPOSO') OR ($status=='PERMISO RE') OR ($status=='VACACIONES') OR ($status=='PERMISO NO')){$fecha_e="";}
		  }
		  if($existe==0){$nombre1=$prev_nombre; } $nombre1=elimina_comas($nombre1); $nombre2=elimina_comas($nombre2); $apellido1=elimina_comas($apellido1); $apellido2=elimina_comas($apellido2); 
		  $monto_tot=$monto_tot+$monto_emp;
		  $monto_emp=$monto_emp*100; 
		  $fecha_i=formato_ddmmaaaa($fecha_i);
		  $fecha_p=substr($fecha_i, 0, 2).substr($fecha_i, 3, 2).substr($fecha_i, 8, 2);
		  $fecha_p=substr($fecha_i, 0, 2).substr($fecha_i, 3, 2).substr($fecha_i, 6, 4);		  
		  if($fecha_e==""){ $fecha_pe=""; }else{ $fecha_e=formato_ddmmaaaa($fecha_e);  $fecha_pe=substr($fecha_e, 0, 2).substr($fecha_e, 3, 2).substr($fecha_e, 6, 4); }
		  
		  $cedula1=elimina_puntos($prev_cedula);	$nombre1=rtrim($nombre1); $nombre2=rtrim($nombre2); $num_linea=$num_linea+1;
		  $monto1=formato_monto($monto_emp); $monto1=elimina_puntos($monto1); $monto1=elimina_comas($monto1); 
		  $nombre1=trim($nombre1);
	      $nombre1=str_replace("Ñ","N",$nombre1); $nombre2=str_replace("Ñ","N",$nombre2);
	      $apellido1=str_replace("Ñ","N",$apellido1); $apellido2=str_replace("Ñ","N",$apellido2);
		  $detalle=$detalle.$nacionalidad.",".$cedula1.",".$nombre1.",".$nombre2.",".$apellido1.",".$apellido2.",".$monto1.",".$fecha_p.",".$fecha_pe.$str_campo;	
		}	
		$prev_cedula=$cedula; $prev_nombre=$nombre;	$prev_status=$status_calculo; $prev_fecha=$fecha_ingreso;
		$monto_r=0; $monto_e=0; $monto_a=0;
	  }
	  if($cod_concepto==$cod_concepto3){ 
		if($accion3=="T"){$monto_r=$monto_r+$monto;}
		if($accion3=="M"){$monto_r=$monto_r+$monto_orig;}
		if($accion3=="C"){$monto_r=$monto_r+$cantidad;}
		if($accion3=="E"){$monto_r=$monto_r+$valore;}
		if($accion3=="U"){$monto_r=$monto_r+$valoru;}
		if($accion3=="Q"){$monto_r=$monto_r+$valorq;}
		if($accion3=="W"){$monto_r=$monto_r+$valorw;}
		if($accion3=="X"){$monto_r=$monto_r+$valorx;}
		if($accion3=="Y"){$monto_r=$monto_r+$valory;}
		if($accion3=="Z"){$monto_r=$monto_r+$valorz;}
	  }
	  if($cod_concepto==$cod_concepto1){ 
		if($accion1=="T"){$monto_e=$monto_e+$monto;}
		if($accion1=="M"){$monto_e=$monto_e+$monto_orig;}
		if($accion1=="C"){$monto_e=$monto_e+$cantidad;}
		if($accion1=="E"){$monto_e=$monto_e+$valore;}
		if($accion1=="U"){$monto_e=$monto_e+$valoru;}
		if($accion1=="Q"){$monto_e=$monto_e+$valorq;}
		if($accion1=="W"){$monto_e=$monto_e+$valorw;}
		if($accion1=="X"){$monto_e=$monto_e+$valorx;}
		if($accion1=="Y"){$monto_e=$monto_e+$valory;}
		if($accion1=="Z"){$monto_e=$monto_e+$valorz;}
	  }
	  if($cod_concepto==$cod_concepto2){ 
		if($accion2=="T"){$monto_a=$monto_a+$monto;}
		if($accion2=="M"){$monto_a=$monto_a+$monto_orig;}
		if($accion2=="C"){$monto_a=$monto_a+$cantidad;}
		if($accion2=="E"){$monto_a=$monto_a+$valore;}
		if($accion2=="U"){$monto_a=$monto_a+$valoru;}
		if($accion2=="Q"){$monto_a=$monto_a+$valorq;}
		if($accion2=="W"){$monto_a=$monto_a+$valorw;}
		if($accion2=="X"){$monto_a=$monto_a+$valorx;}
		if($accion2=="Y"){$monto_a=$monto_a+$valory;}
		if($accion2=="Z"){$monto_a=$monto_a+$valorz;}
	  }	  
	  
	} $monto_emp=$monto_r+$monto_e+$monto_a; $fecha_i=$prev_fecha;
	
	$monto_tot=$monto_tot+$monto_emp;
	
	if($monto_emp>0){ $nombre1=""; $nombre2=""; $apellido1=""; $apellido2=""; $fecha_e=""; $existe=0; $nacionalidad=substr($prev_status,1,1); $sexo=substr($prev_status,3,1);
	  $sSQL="Select * from TRABAJADORES where cedula='$prev_cedula'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
	  if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $existe=1; $cod_empleado=$registro["cod_empleado"];  $nacionalidad=$registro["nacionalidad"]; $nacionalidad=substr($nacionalidad,0,1); $sexo=$registro["sexo"]; $sexo=substr($sexo,0,1);
		$nombre1=$registro["nombre1"]; $nombre2=$registro["nombre2"]; $apellido1=$registro["apellido1"];$apellido2=$registro["apellido2"]; $fecha_i=$registro["fecha_ingreso"]; $fecha_e=$registro["fecha_egreso"]; $status=$registro["status"];
		if(($fecha_e>=$fechah)and($fecha_e<=$fechah)){$fecha_e=$fecha_e;}else{$fecha_e="";}
		if(($status=='ACTIVO') OR ($status=='REPOSO') OR ($status=='PERMISO RE') OR ($status=='VACACIONES') OR ($status=='PERMISO NO')){$fecha_e="";}
	  }
	  if($existe==0){ $nombre1=$prev_nombre; }  
	  $monto_emp=$monto_emp*100; 
	  $fecha_i=formato_ddmmaaaa($fecha_i);
	  $fecha_p=substr($fecha_i, 0, 2).substr($fecha_i, 3, 2).substr($fecha_i, 8, 2);
	  $fecha_p=substr($fecha_i, 0, 2).substr($fecha_i, 3, 2).substr($fecha_i, 6, 4);
	  if($fecha_e==""){ $fecha_pe=""; }else{ $fecha_e=formato_ddmmaaaa($fecha_e);  $fecha_pe=substr($fecha_e, 0, 2).substr($fecha_e, 3, 2).substr($fecha_e, 6, 4); }
		  
	  $cedula1=elimina_puntos($prev_cedula);	$nombre1=rtrim($nombre1); $nombre2=rtrim($nombre2); $num_linea=$num_linea+1;
      $monto1=formato_monto($monto_emp); $monto1=elimina_puntos($monto1); $monto1=elimina_comas($monto1); 
	  $nombre1=trim($nombre1);
	  $nombre1=str_replace("Ñ","N",$nombre1); $nombre2=str_replace("Ñ","N",$nombre2);
	  $apellido1=str_replace("Ñ","N",$apellido1); $apellido2=str_replace("Ñ","N",$apellido2);
	  $detalle=$detalle.$nacionalidad.",".$cedula1.",".$nombre1.",".$nombre2.",".$apellido1.",".$apellido2.",".$monto1.",".$fecha_p.",".$fecha_pe.$str_campo;	
		
	}	$monto_tot=$monto_tot*3; $montot=formato_monto($monto_tot);
    if($tipo_formato=="TXT"){   header('Content-type: application/txt');	  header("Content-Disposition: attachment; filename=arch_faov.txt"); }
    else{?><script language="JavaScript">alert('Archivo Generado,\n Cantidad de Trabajadores : <? echo $num_linea; ?> \n Monto Total Retencion y Aporte : <? echo $montot; ?>'); </script><?}	
    if($num_linea==0){$error=0;}	
    else{echo $detalle;}
   } 
}
pg_close();

if($error==0){$error=0;}else{?><script language="JavaScript">window.close(); </script><?} 

?>