<?include ("../class/seguridad.inc");  include ("../class/conects.php");  include ("../class/funciones.php");  $php_os=PHP_OS;
$cod_empleado=$_GET["Gcod_empleado"]; $fecha_hoy=asigna_fecha_hoy(); $sfechan=formato_aaaammdd($fecha_hoy);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
if($php_os=="WINNT"){$equipo = getenv("COMPUTERNAME");}
else{if($_SERVER["HTTP_X_FORWARDED_FOR"]){$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];}else{$ip=$_SERVER["REMOTE_ADDR"];} if($equipo==""){$equipo=$ip;} }
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $error=0;  $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
   if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSSS";}  else{$modulo="04"; $opcion="01-0000045"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
   if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
   $opcion="02-0000010"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$Mcamino.$reg["campo617"]; } else{ $Mcamino=$Mcamino."N";}
   }$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{$error=1;} if($Mcamino{6}=="S"){$error=0;}else{$error=1;} if($error==1){?><script language="JavaScript"> muestra(' NO TIENE DERECHOS PARA EJECUTAR ESTA OPCION'); </script><?}
 }
 if($error==0){ if ($gnomina=="00"){$error=0;} else {  if($tipo_nomina<>$gnomina) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE NOMINA NO ACTIVA PARA EL USUARIO');</script><?}  } } 
 if($error==0){$sSQL="Select cod_empleado from NOM017 WHERE cod_empleado='$cod_empleado'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado); if($filas>0){$error=1;?><script language="JavaScript">muestra('TRABAJADOR TIENE NOMINA CALCULADA');</script><?}}
 if($error==0){$sSQL="Select nombre,cedula,cod_cargo,cod_departam from NOM006 WHERE cod_empleado='$cod_empleado'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado); $adescrip=$registro["nombre"]; $acedula=$registro["cedula"]; $acargo=$registro["cod_cargo"]; $adep=$registro["cod_departam"]; $sfecha=date("y/m/d");
      $sSQL="SELECT ACTUALIZA_NOM006(3,'$cod_empleado','$acedula','$adescrip','','','','$sfecha','$sfecha','','','','','','','','','$sfecha','$acargo','$adep','','','',0,0,0,0,0,'','','$sfecha','','','','$sfecha','$sfecha','N','','$sfecha',0,'$sfecha','$sfecha','','','0000','','','$sfecha','$sfecha','','','','',0,'','','','','','','','','','$sfecha',0,'','','','','','','','',0,'','$sfecha','','','','','','','','',0,0,'','','','','','')";
      $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror="ERROR ELIMINANDO: ".substr($merror, 0,91); if (!$resultado){$error=1; ?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
      $desc_doc="TRABAJADOR, CODIGO:".$cod_empleado.", NOMBRE:".$adescrip.", CARGO:".$acargo.", DEPARTAMENTO:".$adep; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
      $merror=pg_errormessage($conn); $merror=substr($merror, 0,91);  if (!$resultado){$error=1;?><script language="JavaScript">muestra('<?echo $merror;?>');</script><? } }
  }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>