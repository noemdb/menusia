<?include ("../class/conect.php");  include ("../class/funciones.php");$fecha_hoy=asigna_fecha_hoy();
$cod_dependen=$_POST["txtcod_dependen"]; $cod_direcci=$_POST["txtcod_direccion"];$denominacion_dir=$_POST["txtdenominacion_dir"]; $direccion_dir=$_POST["txtdireccion_dir"];$nombre_contacto_r=$_POST["txtnombre_contacto_r"];$observacion_dir=$_POST["txtobservacion_dir"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $url="Det_direcciones.php?cod_dependen=".$cod_dependen;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select denominacion_dir from BIEN005 WHERE cod_dependencia='$cod_dependen' and cod_direccion='$cod_direcci'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DIRECCION NO EXISTE');</script><? }  
  if($error==0){$sSQL="SELECT ACTUALIZA_BIEN005(2,'$cod_dependen','$cod_direcci','$denominacion_dir','$direccion_dir','$nombre_contacto_r','$observacion_dir','$minf_usuario')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?}
  }
}pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>
