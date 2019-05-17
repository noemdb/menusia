<?include ("../class/conect.php");  include ("../class/funciones.php");$fecha_hoy=asigna_fecha_hoy();
$cod_dependen=$_GET["cod_dependen"]; $cod_direcci=$_GET["cod_direcci"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $url="Det_direcciones.php?cod_dependen=".$cod_dependen;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select denominacion_dir from BIEN005 WHERE cod_dependencia='$cod_dependen' and cod_direccion='$cod_direcci'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DIRECCION NO EXISTE');</script><? }
   if ($error==0){
      $sSQL="Select denominacion_dep from BIEN006 WHERE cod_dependencia='$cod_dependen' and cod_direccion='$cod_direcci'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
      if ($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DIRECCION TIENE DEPARTAMENTOS ASOCIADOS');</script><? }
   }	
   if ($error==0){$sSQL="SELECT ACTUALIZA_BIEN005(3,'$cod_dependen','$cod_direcci','','','','','$minf_usuario')";
     $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror="ERROR GRABANDO: ".substr($merror, 0, 91); if (!$resultado){$error=1; ?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?}
  }
}pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>
