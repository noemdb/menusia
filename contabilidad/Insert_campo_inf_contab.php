<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy(); $error=0;
$tipo_informe=$_POST["txttipo_informe"]; $linea=$_POST["txtlinea"];
$codigo_cuenta=$_POST["txtCodigo_Cuenta"];   $cod_cuenta=$_POST["txtcod_cuenta"]; $nombre_cuenta=$_POST["txtNombre_Cuenta"]; 
$calculable=substr($_POST["txtcalculable"],0,1); $status_linea=substr($_POST["txtstatus_linea"],0,1); 
$moperacion=substr($_POST["txtmoperacion"],0,1); $columna=substr($_POST["txtcolumna"],0,1); $status=substr($_POST["txtstatus"],0,1);
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $url="Det_inc_inf_contables.php?criterio=".$tipo_informe;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select tipo_informe from CON006 WHERE tipo_informe='$tipo_informe' and linea='$linea'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if($filas>=1){$error=1; ?> <script language="JavaScript"> muestra('LINEA DE ARCHIVO YA EXISTE');</script><? }
  if($error==0){if(strlen($linea)==8){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD LINEA INVALIDA');</script><?} } 
  if($error==0){$sSQL="SELECT ACTUALIZA_CON006(1,'$tipo_informe','$linea','$codigo_cuenta','$cod_cuenta','$nombre_cuenta','$calculable','$status_linea','$moperacion','$columna','$status')";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><?}
  }
}pg_close();
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>

