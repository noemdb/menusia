<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();
$tipo_nomina=$_POST["txttipo_nomina"];  $consecutivo=$_POST["txtconsecutivo"];
$desde=$_POST["txtdesde"]; $hasta=$_POST["txthasta"]; $antiguedad=$_POST["txtantiguedad"];  $preaviso=$_POST["txtpreaviso"];  $vacaciones=$_POST["txtvacaciones"];
$vac_adicional=$_POST["txtvac_adicional"]; $bono_vacacional=$_POST["txtbono_vacacional"]; $auxiliar1=$_POST["txtauxiliar1"];
$desde=formato_numero($desde);if(is_numeric($desde)){$desde=$desde;}else{$desde=0;} $hasta=formato_numero($hasta);if(is_numeric($hasta)){$hasta=$hasta;}else{$hasta=0;}
$antiguedad=formato_numero($antiguedad);if(is_numeric($antiguedad)){$antiguedad=$antiguedad;}else{$antiguedad=0;} $preaviso=formato_numero($preaviso);if(is_numeric($preaviso)){$preaviso=$preaviso;}else{$preaviso=0;}
$vacaciones=formato_numero($vacaciones);if(is_numeric($vacaciones)){$vacaciones=$vacaciones;}else{$vacaciones=0;} $vac_adicional=formato_numero($vac_adicional);if(is_numeric($vac_adicional)){$vac_adicional=$vac_adicional;}else{$vac_adicional=0;}
$bono_vacacional=formato_numero($bono_vacacional);if(is_numeric($bono_vacacional)){$bono_vacacional=$bono_vacacional;}else{$bono_vacacional=0;}  $auxiliar1=formato_numero($auxiliar1);if(is_numeric($auxiliar1)){$auxiliar1=$auxiliar1;}else{$auxiliar1=0;}
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_tabla_indemnizacion.php?Gcodigo=C".$tipo_nomina.$consecutivo;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM020 WHERE tipo_nomina='$tipo_nomina' and consecutivo='$consecutivo'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CONSECUTIVO DE TABLA INDEMNIZACIÓN YA EXISTE');</script><? }
   if($error==0){if(strlen($consecutivo)==4){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD DE CONSECUTIVO INVALIDA');</script><?} }
   if($error==0){ if ($gnomina=="00"){$error=0;} else {  if($tipo_nomina<>$gnomina) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO ACTIVA PARA EL USUARIO');</script><?}  } } 
   if($error==0){$sSQL="Select * from NOM001 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA NO EXISTE');</script><?}}
    if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);
    $sSQL="SELECT ACTUALIZA_NOM020(1,'$tipo_nomina','$consecutivo',$desde,$hasta,$antiguedad,$preaviso,$vacaciones,$vac_adicional,$bono_vacacional,$auxiliar1,0,0,0,0,0)";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>
