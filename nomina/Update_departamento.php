<?include ("../class/conect.php");  include ("../class/funciones.php");$fecha_hoy=asigna_fecha_hoy();
$codigo_departamento=$_POST["txtcodigo_departamento"]; $descripcion_dep=$_POST["txtdescripcion_dep"]; $url="Act_Departamentos.php";
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM005 WHERE codigo_departamento='$codigo_departamento'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE DEPARTAMENTO NO EXISTE');</script><? }
    else{$registro=pg_fetch_array($resultado); $adescrip=$registro["descripcion_dep"]; $sfecha=formato_aaaammdd($fecha_hoy);}
  if($error==0){$formato_dep="XXXXXXXXXX";$sql="Select * from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$formato_trab=$registro["campo504"];$formato_cargo=$registro["campo505"];$formato_dep=$registro["campo506"];}}
  if($error==0){if(strlen($codigo_departamento)==strlen($formato_dep)){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD CODIGO DE DEPARTAMENTO INVALIDA');</script><?} }
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy); $sSQL="SELECT ACTUALIZA_NOM005(2,'$codigo_departamento','$descripcion_dep','S')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?
     $desc_doc="DEPARTAMENTO, CODIGO:".$codigo_departamento.", DESCRIPCION:".$adescrip; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('04','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
      $error=pg_errormessage($conn); $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>