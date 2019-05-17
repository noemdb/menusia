<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); 
$tipo_nomina=$_POST["txttipo_nomina"]; $cod_concepto=$_POST["txtcod_concepto"]; $cod_empleado=$_POST["txtcod_empleado"]; $tp_calculo=$_POST["txttp_calculo"]; 
$fecha_p_hasta=$_POST["txtfecha_p_hasta"];  $monto_a=$_POST["txtmonto_a"]; $monto=$_POST["txtmonto"]; $sfechan=formato_ddmmaaaa($fecha_p_hasta);
$fecha_hoy=asigna_fecha_hoy(); $monto_a=formato_numero($monto_a); if(is_numeric($monto_a)){$monto_a=$monto_a;}else{$monto_a=0;} $monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;}else{$monto=0;}
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$url="Det_conc_hist_nom.php?cod_empleado=".$cod_empleado."&tipo_nomina=".$tipo_nomina."&fecha_nomina=".$sfechan; $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $Nom_Emp=busca_conf();  $amonto=0; $valorz=0; $asig_ded_apo="";
 $sql="Select * from nom019 where (tipo_nomina='$tipo_nomina') and (cod_empleado='$cod_empleado') and  (cod_concepto='$cod_concepto') and (fecha_p_hasta='$fecha_p_hasta') and (tp_calculo='$tp_calculo') "; $res=pg_query($sql);
 $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
 if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('HISTORICO DE CONCEPTO DE NOMINA CALULADA NO EXISTE');</script><? } else{$registro=pg_fetch_array($resultado); $acantidad=$registro["cantidad"]; $amonto=$registro["monto"]; $valorz=$registro["valorz"];  $asig_ded_apo=$registro["asig_ded_apo"]; }
 if(($error==0)and($monto<>$amonto)and($amonto<>0)){ $sfecha=formato_aaaammdd($fecha_hoy); $sfechan=formato_ddmmaaaa($fecha_p_hasta);	 
	if( $valorz==0){ $valorz=0; } else { if($monto<$valorz) { $valorz=$monto; } } 	 
	$sqlg="update nom019 set monto=$monto,valorz=$valorz where (tipo_nomina='$tipo_nomina') and (cod_empleado='$cod_empleado') and  (cod_concepto='$cod_concepto') and (fecha_p_hasta='$fecha_p_hasta') and (tp_calculo='$tp_calculo')";
    if($asig_ded_apo=="A"){ $sqlg="update nom019 set monto=$monto,valorz=$valorz,monto_asignacion=$monto where (tipo_nomina='$tipo_nomina') and (cod_empleado='$cod_empleado') and  (cod_concepto='$cod_concepto') and (fecha_p_hasta='$fecha_p_hasta') and (tp_calculo='$tp_calculo')"; }
	if($asig_ded_apo=="D"){ $sqlg="update nom019 set monto=$monto,valorz=$valorz,monto_deduccion=$monto where (tipo_nomina='$tipo_nomina') and (cod_empleado='$cod_empleado') and  (cod_concepto='$cod_concepto') and (fecha_p_hasta='$fecha_p_hasta') and (tp_calculo='$tp_calculo')"; }
	if($asig_ded_apo=="P"){ $sqlg="update nom019 set monto=$monto,valorz=$valorz,monto_aporte=$monto where (tipo_nomina='$tipo_nomina') and (cod_empleado='$cod_empleado') and  (cod_concepto='$cod_concepto') and (fecha_p_hasta='$fecha_p_hasta') and (tp_calculo='$tp_calculo')"; }
	$resultado=pg_exec($conn,$sqlg); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?
      $desc_doc="HISTORICO DE CONCEPTO DE NOMINA CALULADA, TIPO NOMINA:".$tipo_nomina.", CODIGO TRABAJADOR:".$cod_empleado.", CODIGO CONCEPTO:".$cod_concepto.", MONTO ANTERIOR:".$amonto.", MONTO:".$monto.", FECHA :".$sfechan; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
      $error=pg_errormessage($conn); $error=substr($error, 0, 91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }
	}
 }
}pg_close();  if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>

 
 