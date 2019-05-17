<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();
$tipo_nomina=$_POST["txttipo_nomina"]; $cod_concepto=$_POST["txtcod_concepto"]; $denominacion=$_POST["txtdenominacion"]; $consecutivo=$_POST["txtconsecutivo"]; $accion=$_POST["txtaccion"];
$rango_inicial=$_POST["txtrango_inicial"]; $rango_final=$_POST["txtrango_final"]; $calculo1=$_POST["txtcalculo1"];  $calculo2=$_POST["txtcalculo2"];  $calculofinal=$_POST["txtcalculofinal"];
$rango_inicial=formato_numero($rango_inicial); if(is_numeric($rango_inicial)){$rango_inicial=$rango_inicial;}else{$rango_inicial=0;}
$rango_final=formato_numero($rango_final); if(is_numeric($rango_final)){$rango_final=$rango_final;}else{$rango_final=0;}
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_formula.php?Gcodigo=C".$tipo_nomina.$cod_concepto.$consecutivo;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM003 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto' and consecutivo='$consecutivo'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('FORMULA DE CONCEPTO YA EXISTE');</script><? }
   if($error==0){ if ($gnomina=="00"){$error=0;} else {  if($tipo_nomina<>$gnomina) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO ACTIVA PARA EL USUARIO');</script><?}  } } 
   if($error==0){if(strlen($cod_concepto)==3){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD DE CONCEPTO INVALIDA');</script><?} }
   if($error==0){$sSQL="Select * from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA NO EXISTE');</script><?}}
   if($error==0){$sSQL="Select * from NOM002 WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CONCEPTO NO EXISTE');</script><?}}
   if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);
    $sSQL="SELECT ACTUALIZA_NOM003(1,'$tipo_nomina','$cod_concepto','$consecutivo','$accion',$rango_inicial,$rango_final,'$calculo1','$calculo2','$calculofinal','$minf_usuario')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}
  }
}
pg_close();if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>