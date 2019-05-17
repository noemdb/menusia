<?include ("../class/conect.php");  include ("../class/funciones.php");$fecha_hoy=asigna_fecha_hoy();
$cod_dependen=$_POST["txtcod_dependen"]; $cod_direcci=$_POST["txtcod_direcci"];$cod_departamen=$_POST["txtcod_departamento"];$denominacion_dep=$_POST["txtdenominacion_dep"]; $direccion_dep=$_POST["txtdireccion_dep"];$nombre_contacto_d=$_POST["txtnombre_contacto_d"];$observacion_dep=$_POST["txtobservacion_dep"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; 
$url="Det_departamentos.php?cod_dependen=$cod_dependen&cod_direcci=$cod_direcci";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select denominacion_dep from BIEN006 WHERE cod_dependencia='$cod_dependen' and cod_direccion='$cod_direcci' and cod_departamento='$cod_departamen'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEPARTAMENTO NO EXISTE');</script><? }  
  if($error==0){$sSQL="SELECT ACTUALIZA_BIEN006(2,'$cod_dependen','$cod_direcci','$cod_departamen','$denominacion_dep','$direccion_dep','$nombre_contacto_d','$observacion_dep','$minf_usuario')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?}
  }
}pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>
