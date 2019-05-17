<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $url="Cierre_nomina.php"; $tipo_nomina=$_GET["tipo_nomina"]; $tp_calculo=$_GET["tp_calculo"]; $num_periodos=$_GET["num_periodos"]; $carga_bono_vac=$_GET["carga_bono_vac"]; $php_os=PHP_OS; $cod_modulo="04";
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR CERRANDO NOMINA....","<br>";
if($php_os=="WINNT"){$equipo = getenv("COMPUTERNAME");}else{if($_SERVER["HTTP_X_FORWARDED_FOR"]){$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];}else{$ip=$_SERVER["REMOTE_ADDR"];} if($equipo==""){$equipo=$ip;} }
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;   $MDivisible=15;  $conc_int="000";  $conc_vac="000"; if($tp_calculo=="N"){ $num_periodos=1; }
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{ $campo502="NNNNNNNNNNNNNNNNNNN"; $sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; } if (substr($campo502,15,1)=="N"){$carga_bono_vac='S';} 
$StrSQL="select fecha_p_desde,fecha_p_hasta from nom017 where (tipo_nomina='$tipo_nomina') and (tp_calculo='$tp_calculo') and (num_periodos=$num_periodos)"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $fechah=$registro["fecha_p_hasta"]; } else{$error=1; ?><script language="JavaScript">muestra('NOMINA NO HA SIDO CALCULADO');</script><?}
$StrSQL="select bloqueada,bloqueada_ext,g_orden_pago,frecuencia,con_bon_vac,con_sue_int from nom001 where (tipo_nomina='$tipo_nomina')"; $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas>0){$registro=pg_fetch_array($resultado); $conc_vac=$registro["con_bon_vac"]; $conc_int=$registro["con_sue_int"]; if($registro["frecuencia"]=="M"){$MDivisible=30;} if($registro["frecuencia"]=="S"){$MDivisible=7;} }
if($error==0){ $actualiza='N'; }
if($error==0){ $mfecha=formato_ddmmaaaa($fechah);  $mfecha_hasta=formato_ddmmaaaa($fechah); $mfecha=colocar_udiames($mfecha); $mfecha=formato_aaaammdd($mfecha);
$sql="SELECT PROCESAR_CONCEPTOS_nom018('$tipo_nomina','$tp_calculo','$fechah','$actualiza','$mfecha',$MDivisible,'$conc_int','$carga_bono_vac','$conc_vac')"; 
$sql="SELECT PROCESAR_CONCEPTOS_nom018('$tipo_nomina','$tp_calculo','$fechah','$actualiza','$mfecha',$MDivisible,'$conc_int','$carga_bono_vac','$conc_vac',$num_periodos)"; 
$res=pg_exec($conn,$sql); $terror=pg_errormessage($conn); $merror=substr($terror, 0, 91); if (!$res){$error=1;  echo $terror,"<br>"; ?><script language="JavaScript">muestra('ERROR CERRANDO NOMINA');   muestra('<?echo $merror;?>');</script><?}else{$error=0;}
//actualiza sueldo integral y primas
if(($tp_calculo=="N")and($error==0)){
  //$StrSQL = "Update NOM006 Set sueldo_integral = (SELECT Monto FROM NOM017 Where NOM017.Cod_Concepto = '$conc_int' And NOM017.Cod_Empleado=NOM006.cod_empleado And Concepto_Vac ='N') WHERE (COD_EMPLEADO IN (SELECT NOM007.Cod_Empleado FROM NOM007,NOM017 A where NOM007.Cod_Empleado=A.Cod_Empleado AND A.Cod_Concepto='$conc_int')) And (NOM006.Tipo_Nomina = '$tipo_nomina')";
}
if($error==0){ $mensaje="PROCESO TERMINO SATISFACTORIAMENTE"; $sql="SELECT ACTUALIZA_EDAD_EMPLEADO(0)"; $res=pg_exec($conn,$sql); $sfecha=formato_aaaammdd($fecha_hoy);
  $desc_doc="CIERRE DE NOMINA, TIPO:".$tipo_nomina.", TIPO DE CALCULO:".$tp_calculo.", FECHA HASTA:".$mfecha_hasta; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Cierre','$sfecha','$desc_doc')"); $error=pg_errormessage($conn); $error=substr($error, 0, 91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }
} else{$mensaje="ERROR EN CIERRE DE NOMINA"; echo $merror." ".$sql;} }}
pg_close(); ?><script language="JavaScript"> muestra('<? echo $mensaje; ?>'); window.close(); </script>