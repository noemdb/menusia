<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);  $referencia=$_GET["txtreferencia"]; $tipo_en=""; $fecha=asigna_fecha_hoy();
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a");  echo "ESPERE POR FAVOR INCLUYENDO....","<br>";$error=0; if($fecha==""){$sfecha="2007-01-01";}else{$sfecha=formato_aaaammdd($fecha);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select * from ban025 WHERE referencia='$referencia'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; ?>  <script language="JavaScript">  muestra('REFERENCIA DE COLOCACION  NO EXISTE');  </script> <? }
   else{$registro=pg_fetch_array($resultado); $adescripcion=$registro["observacion"]; $tipo_inv=$registro["tipo_inv"]; $cod_cuenta=$registro["cod_cuenta"]; $monto_inv=$registro["monto_inv"]; $sfecha=$registro["fecha_inicio"]; $error=0;
     if($error==0){  $sSQL="SELECT ACTUALIZA_BAN025(3,'$referencia','$tipo_inv','$cod_cuenta','$sfecha','$sfecha',0,0,$monto_inv,'S','','','','','',0,0,'$adescripcion')";  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error,0,91);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE'); </script><?}
         $desc_doc="COLOCACION BANCARIA:".$referencia.", DESCRIPCION:".$adescripcion.", CUENTA:".$cod_cuenta.", MONTO:".$monto_inv; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')"); $error=pg_errormessage($conn);$error=substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>