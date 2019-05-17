<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();
$tipo_nomina=$_POST["txttipo_nomina"];  $consecutivo=$_POST["txtconsecutivo"];  $tipo_new=$_POST["txttipo_new"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$url="Act_tabla_indemnizacion.php?Gcodigo=C".$tipo_nomina.$consecutivo;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select consecutivo from NOM020 WHERE tipo_nomina='$tipo_nomina'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TABLA DE INDEMNIZACION PARA ESTA NOMINA NO EXISTE');</script><? }
   if($error==0){$sSQL="Select tipo_nomina from NOM001 WHERE tipo_nomina='$tipo_new'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE NOMINA A COPIAR NO EXISTE');</script><?}}
   if($error==0){ if ($gnomina=="00"){$error=0;} else {  if($tipo_new<>$gnomina) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO ACTIVA PARA EL USUARIO');</script><?}  } } 
   if($error==0){$sSQL="Select consecutivo from NOM020 WHERE tipo_nomina='$tipo_new'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado); if ($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('TABLA DE INDEMNIZACION PARA ESTA NOMINA YA EXISTE');</script><? }  }
     if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);
    $sSQL="insert into nom020 SELECT '".$tipo_new."',consecutivo,desde,hasta,antiguedad,preaviso,vacaciones,vac_adicional,bono_vacacional,auxiliar1,valor1,valor2,valor3,valor4,valor5 FROM nom020 where tipo_nomina='$tipo_nomina'"; echo $sSQL;
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('COPIO EXITOSAMENTE');</script><? }
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>


