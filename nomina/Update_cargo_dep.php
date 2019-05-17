<?include ("../class/conect.php");  include ("../class/funciones.php");$fecha_hoy=asigna_fecha_hoy();
$codigo_departamento=$_POST["txtcodigo_dep"]; $codigo_cargo=$_POST["txtcodigo_cargo"]; $cod_tipo_personal=$_POST["txtcod_tipo_personal"];$nro_cargos=$_POST["txtnro_cargos"]; $asignados=0;
if(is_numeric($nro_cargos)){$nro_cargos=$nro_cargos;}else{$nro_cargos=0;}
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$url="Det_cargo_dep.php?Gcodigo=".$codigo_departamento;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM043 WHERE codigo_departamento='$codigo_departamento' and codigo_cargo='$codigo_cargo'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CARGO NO EXISTE EN EL DEPARTAMENTO');</script><? }
  if($error==0){$formato_cargo="XXXXXXXXXX";$sql="Select * from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$formato_trab=$registro["campo504"];$formato_cargo=$registro["campo505"];$formato_dep=$registro["campo506"];}}
  if($error==0){if(strlen($codigo_cargo)==strlen($formato_cargo)){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD CODIGO DE CARGO INVALIDA');</script><?} }
  if($error==0){$sSQL="Select * from NOM004 WHERE codigo_cargo='$codigo_cargo'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CARGO NO EXISTE');</script><?}}
  if($error==0){$sSQL="Select * from NOM015 WHERE cod_tipo_personal='$cod_tipo_personal'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO TIPO DE PERSONAL NO EXISTE');</script><?}}
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy);
    $sSQL="SELECT ACTUALIZA_NOM043(2,'$codigo_departamento','$codigo_cargo','$cod_tipo_personal',$nro_cargos,$asignados)";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?}
  }
}pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>