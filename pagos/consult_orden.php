<?include ("../class/conect.php");  include ("../class/funciones.php");error_reporting(E_ALL);
$nro_orden=$_POST["txtnro_orden"]; 
$cod_comp="0000"; $error=0; $equipo=getenv("COMPUTERNAME"); echo "ESPERE POR FAVOR BUSCANDO....","<br>";
if ($error==0){
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   if (pg_ErrorMessage($conn)) {$error=1; ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
  $sSQL="Select * from ORD_PAGO where nro_orden='$nro_orden'";   $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('ORDEN DE PAGO NO EXISTE');</script><?}
    else{ $registro=pg_fetch_array($resultado);$nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"];}
}
pg_close(); error_reporting(E_ALL ^ E_WARNING); if ($error==0){?><script language="JavaScript">document.location ='Act_orden_pago.php?Gcriterio=<? echo $nro_orden.$tipo_causado; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }  ?>