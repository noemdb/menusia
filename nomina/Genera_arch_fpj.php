<? include ("../class/seguridad.inc"); include ("../class/conects.php"); include("../class/fun_fechas.php"); include("../class/fun_numeros.php");   include ("../class/configura.inc"); $fecha_hoy=asigna_fecha_hoy();  $error=0; $equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
  $tipo_formato=$_POST["txttipo_formato"]; 
function elimina_puntos($str){  $texto="";
  for ($i=0; $i<strlen($str); $i++) { if (substr($str,$i, 1)==".") {$texto=$texto; }  else {$texto=$texto.substr($str,$i, 1);}  }
return $texto;}
 $str_campo="<br>";
if($tipo_formato=="TXT"){ $str_campo="\r\n"; }
$cod_arch_banco=$_POST["txtcod_arch_banco"];  $tipo_arch_banco=$_POST["txttipo_arch_banco"]; $den_arch_banco="FONDO ESPECIAL DE JUBILACIONES Y PENSIONADOS";
$cod_emp=$_POST["txtcod_emp"];  $tipo_calculo=$_POST["txttipo_calculo"];
$fecha_hasta=$_POST["txtfecha_hasta"]; $fecha_desde=$_POST["txtfecha_desde"]; $fechad=formato_aaaammdd($fecha_desde); $fechah=formato_aaaammdd($fecha_hasta);
$cod_concepto1=$_POST["txtcod_concepto_d"]; $cod_concepto2=$_POST["txtcod_concepto_h"]; $cod_concepto3=$_POST["txtcod_concepto"];
$medio_envio=strtoupper($_POST["txtacciond"]); $cod_moneda=strtoupper($_POST["txtaccionh"]); $cod_nomina_arch=strtoupper($_POST["txtaccion"]); 
$accion1=$medio_envio; $accion2=$cod_moneda; $accion3=$cod_nomina_arch; $cod_reposo="000";  $mformula="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $tipo_calculo=substr($tipo_calculo,0,1);
$sSQL="Select * from nom045 WHERE cod_arch_banco='$cod_arch_banco' and tipo_arch_banco='$tipo_arch_banco'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
if($filas>=1){$sSQL="SELECT ACTUALIZA_nom045(2,'$cod_arch_banco','$tipo_arch_banco','$den_arch_banco','','','','$cod_emp','$cod_nomina_arch','$medio_envio','$cod_moneda','$cod_concepto1','$cod_concepto2','$cod_concepto3','','','','$minf_usuario')";}
else{$sSQL="SELECT ACTUALIZA_nom045(1,'$cod_arch_banco','$tipo_arch_banco','$den_arch_banco','','','','$cod_emp','$cod_nomina_arch','$medio_envio','$cod_moneda','$cod_concepto1','$cod_concepto2','$cod_concepto3','','','','$minf_usuario')";}
$resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){ $error=1;?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}
if($error==0){$sql="SELECT nom046.tipo_nomina,nom001.descripcion FROM nom046,nom001 Where (nom046.tipo_nomina=nom001.tipo_nomina) And (Cod_Arch_Banco='$cod_arch_banco') And (tipo_arch_banco='$tipo_arch_banco')"; $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){ $tipo=$registro["tipo_nomina"]; if($mformula!=""){$mformula=$mformula." or ";}  $mformula=$mformula."(tipo_nomina='$tipo')";}
  if($mformula==""){$error=1;?> <script language="JavaScript">muestra('NO EXISTEN NOMINAS SELECCIONADAS');</script><? }
  if($error==0){ $mformula="(".$mformula.")"; 
    if($tipo_calculo=="T"){ $mformula=$mformula." and ((nom019.tp_calculo='N')or(nom019.tp_calculo='E')) "; } else {$mformula=$mformula." and (nom019.tp_calculo='$tipo_calculo') ";}
    $sql="SELECT * FROM nom019 Where ((nom019.cod_concepto='$cod_concepto1') or (nom019.cod_concepto='$cod_concepto2') or (nom019.cod_concepto='$cod_concepto3') or (nom019.cod_concepto='$cod_reposo')) And ((nom019.fecha_proceso>='$fechad') and (nom019.fecha_proceso<='$fechah')) And ". $mformula ." order by char_length(nom019.cedula),nom019.cedula,nom019.cod_concepto";
    //echo $sql;
	$fecha_p=substr($fecha_hasta, 0, 2).substr($fecha_hasta, 3, 2).substr($fecha_hasta, 6, 4); $detalle="";
	$monto_tot=0; $monto_emp=0; $leidos=0; $num_linea=0; $prev_cedula=""; $prev_nombre=""; $num_emp=0; $monto_te=0; $monto_ta=0; $monto_r=0; $monto_e=0; $monto_a=0; $res=pg_query($sql);
	while($reg=pg_fetch_array($res)){ $cedula=$reg["cedula"]; $nombre=$reg["nombre"]; $cod_concepto=$reg["cod_concepto"];  $monto=$reg["monto"]; $cantidad=$reg["cantidad"]; $monto_orig=$reg["monto_orig"]; 
	  $valore=$reg["valore"]; $valoru=$reg["valoru"]; $valorq=$reg["valorq"]; $valorw=$reg["valorw"];  $valorx=$reg["valorx"]; $valory=$reg["valory"]; $valorz=$reg["valorz"];
	  if($prev_cedula==""){ $prev_cedula=$cedula; $prev_nombre=$nombre;} 	  
	  if($prev_cedula!=$cedula){ $monto_emp=$monto_e+$monto_a; 
		if($monto_emp>0){$monto_tot=$monto_tot+$monto_emp;$monto_te=$monto_te+$monto_e; $monto_ta=$monto_ta+$monto_a;
		$cedula1=elimina_puntos($prev_cedula);	$nombre1=rtrim($prev_nombre); $num_linea=$num_linea+1;
		$monto_r=formato_monto($monto_r); $monto1=elimina_puntos($monto_r); 
		$monto_e=formato_monto($monto_e); $monto2=elimina_puntos($monto_e);
		$monto_a=formato_monto($monto_a); $monto3=elimina_puntos($monto_a);
		$detalle=$detalle.$cedula1."|".$fecha_p."|".$nombre1."|".$cod_emp."|".$monto1."|".$monto2."|".$monto3.$str_campo;	}	
		$prev_cedula=$cedula; $prev_nombre=$nombre;	
		$monto_r=0; $monto_e=0; $monto_a=0;
	  }	  
	  if(($cod_concepto==$cod_concepto3)or($cod_concepto==$cod_reposo)){ 
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
		// echo $monto.' '.$accion3.' '.$monto_r,"<br>";
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
	  
	} $monto_emp=$monto_e+$monto_a; 
	if($monto_emp>0){$monto_tot=$monto_tot+$monto_emp;$monto_te=$monto_te+$monto_e; $monto_ta=$monto_ta+$monto_a;
		$cedula1=elimina_puntos($prev_cedula);	$nombre1=rtrim($prev_nombre);  $num_linea=$num_linea+1;
		$monto_r=formato_monto($monto_r); $monto1=elimina_puntos($monto_r); 
		$monto_e=formato_monto($monto_e); $monto2=elimina_puntos($monto_e);
		$monto_a=formato_monto($monto_a); $monto3=elimina_puntos($monto_a);			
		$detalle=$detalle.$cedula1."|".$fecha_p."|".$nombre1."|".$cod_emp."|".$monto1."|".$monto2."|".$monto3.$str_campo;	}
		
	$tot_emp=formato_monto($monto_te); $tot_aport=formato_monto($monto_ta);
     if($tipo_formato=="TXT"){   header('Content-type: application/txt');	  header("Content-Disposition: attachment; filename=arch_fpj.txt"); }
    else{?><script language="JavaScript">alert('Archivo Generado,\n Cantidad de Trabajadores : <? echo $num_linea; ?> \n Monto Total Aporte Empleado : <? echo $tot_emp; ?> \n Monto Total Aporte Patronal : <? echo $tot_aport; ?>'); </script><?		}
    if($num_linea==0){$error=1;}	
    else{ echo $detalle;    }
   } 
}
pg_close();

if($error==0){$error=0;}else{?><script language="JavaScript">window.close(); </script><?} 

?>