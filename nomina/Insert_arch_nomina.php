<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();   $error=0;
$cod_arch_banco=$_POST["txtcod_arch_banco"]; $den_arch_banco=$_POST["txtden_arch_banco"]; $tipo_arch_banco=$_POST["txttipo_arch_banco"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $url="Act_archivo_nomina.php?Gcriterio=C".$cod_arch_banco;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM045 WHERE cod_arch_banco='$cod_arch_banco' and tipo_arch_banco='$tipo_arch_banco'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE ARCHIVO YA EXISTE');</script><? }
  if($error==0){if(strlen($cod_arch_banco)==6){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD CODIGO DE ARCHIVO INVALIDA');</script><?} }
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy); $sSQL="SELECT ACTUALIZA_NOM045(1,'$cod_arch_banco','$tipo_arch_banco','$den_arch_banco','','','','','','','','','','','','','','$minf_usuario')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}
  }
}pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>