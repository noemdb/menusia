<?include ("../class/conect.php");  include ("../class/funciones.php");$fecha_hoy=asigna_fecha_hoy();   $url="Act_tasa_inte_pres_ar.php";
$numero=$_POST["txtnumero"]; $fecha_desde=$_POST["txtfecha_desde"]; $fecha_hasta=$_POST["txtfecha_hasta"]; $tasa=$_POST["txttasa"]; $tasa=formato_numero($tasa); if(is_numeric($tasa)){$tasa=$tasa;}else{$tasa=0;}
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0; $ahasta=$fecha_hasta;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  $sSQL="Select * from NOM021 WHERE numero='$numero'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NÚMERO DE GACETA NO EXISTE');</script><? }
   else{$registro=pg_fetch_array($resultado); $adesde=$registro["fecha_desde"]; $ahasta=$registro["fecha_hasta"]; $atasa=$registro["tasa"]; $sfecha=formato_aaaammdd($fecha_hoy); }
   if($error==0){if(checkData($fecha_desde)=='1'){$sfechad=formato_aaaammdd($fecha_desde);} else{$error=1;?><script language="JavaScript">muestra('FECHA DESDE NO ES VALIDA');</script><?}}
   if($error==0){if(checkData($fecha_hasta)=='1'){$sfechah=formato_aaaammdd($fecha_hasta);} else{$error=1;?><script language="JavaScript">muestra('FECHA HASTA NO ES VALIDA');</script><?}}
   if($error==0){if(strlen($numero)==6){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD NUMERO DE GACETA INVALIDA');</script><?} }
  if($error==0){$sfecha=formato_aaaammdd($fecha_hoy); $sSQL="SELECT ACTUALIZA_NOM021(2,'$numero','$sfechad','$sfechah',$tasa)";
    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?}
  }
}pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>