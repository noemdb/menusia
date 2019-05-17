<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();
$codigo_cargo=$_POST["txtcodigo_cargo"]; $denominacion=$_POST["txtdenominacion"]; $grado=$_POST["txtgrado"]; $paso=$_POST["txtpaso"];
$nro_cargos=$_POST["txtnro_cargos"]; $asignados=$_POST["txtasignados"]; $sueldo_cargo=$_POST["txtsueldo_cargo"];
if($grado==""){$grado="000";} if($paso==""){$paso="000";} $nro_cargos=formato_numero($nro_cargos); if(is_numeric($nro_cargos)){$nro_cargos=$nro_cargos;}else{$nro_cargos=0;}
$asignados=formato_numero($asignados); if(is_numeric($asignados)){$asignados=$asignados;}else{$asignados=0;} $sueldo_cargo=formato_numero($sueldo_cargo); if(is_numeric($sueldo_cargo)){$sueldo_cargo=$sueldo_cargo;}else{$sueldo_cargo=0;}
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$url="Act_cargo_ar.php?Gcodigo=C".$codigo_cargo;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM004 WHERE codigo_cargo='$codigo_cargo'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CARGO YA EXISTE');</script><? }
  if($error==0){$formato_cargo="XXXXXXXXXX";$sql="Select * from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$formato_trab=$registro["campo504"];$formato_cargo=$registro["campo505"];$formato_dep=$registro["campo506"];}}
  if($error==0){if(strlen($codigo_cargo)==strlen($formato_cargo)){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD CODIGO DE CARGO INVALIDA');</script><?} }
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);
    $sSQL="SELECT ACTUALIZA_NOM004(1,'$codigo_cargo','$denominacion','$grado','$paso',$nro_cargos,$asignados,$sueldo_cargo)"; echo $sSQL;
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?> 
