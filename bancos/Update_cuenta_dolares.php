<?include ("../class/seguridad.inc");  include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();
$Formato_Cuenta="X-X-X-XX-XX-XX-XX"; $error=0;
$codigo_cuenta=$_POST["txtcodigo_cuenta"];$descripcion_cuenta=$_POST["txtdescripcion_cuenta"]; $Saldo_Anterior=0;  $fecha=$fecha_hoy;
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$url="Act_cuentas_dolares.php?Gcodigo_cuenta=C".$codigo_cuenta; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
If (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{  $sql="Select * from SIA005 where campo501='06'";  $resultado=pg_query($sql);  if ($registro=pg_fetch_array($resultado,0)){$Formato_Cuenta=$registro["campo504"];}
  if (checkData($fecha)=='1'){$sfecha=formato_aaaammdd($fecha);} else{$error=1; ?> <script language="JavaScript"> muestra('FECHA NO ES VALIDA');</script><? }
  if ($error==0){
    $l=strlen($codigo_cuenta);
    if ($error==0){  $sSQL="Select * from BAN043 WHERE codigo_cuenta='$codigo_cuenta'";       $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
      if ($filas==0){?> <script language="JavaScript">muestra('CODIGO DE CUENTA NO EXISTE');</script> <? }
       else{
         $resultado=pg_exec($conn,"SELECT ACTUALIZA_BAN043(2,'$codigo_cuenta','$descripcion_cuenta',$Saldo_Anterior,'C',0,0,0,0,0,0,0,0,0,0,0,0,'','',0,0,'$usuario_sia','$minf_usuario',$l)");
         $error=pg_errormessage($conn);$error="ERROR GRABANDO: ".substr($error, 0, 61);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><? }
      }
    }
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>
