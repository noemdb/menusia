<?include ("../class/conect.php");  include ("../class/funciones.php"); 
$codigo_mov=$_POST["txtcodigo_mov"];$codigo_mov=$_POST["txtcodigo_mov"];$nro_orden=$_POST["txtnro_orden"];
$tipo_causado=$_POST["txttipo_causado"];$fecha=$_POST["txtfecha"];$ced_rif=$_POST["txtced_rif"];$ced_rif_ces=$_POST["txtced_rif_ces"];$nombre_ces=$_POST["txtnombre_ces"];$concepto=$_POST["txtconcepto"];$tipo_documento=$_POST["txttipo_documento"];
$nro_documento=$_POST["txtnro_documento"];$tipo_orden=$_POST["txttipo_orden"];$fecha_desde=$_POST["txtfecha_desde"];$fecha_hasta=$_POST["txtfecha_hasta"];$fecha_vencim=$_POST["txtfecha_vencim"];$pago_ces=$_POST["txtp_ces"];
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$error=0;  $sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";    $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}
    if(($error==0)and($pago_ces=="S")){$sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif_ces'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
      if ($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF CESIONARIO NO EXISTE');</script><?} }
    if($error==0){$sql="Select * from PAG001 where nro_orden='$nro_orden'"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('NUMERO DE ORDEN NO EXISTE');</script><?}
     else { $reg=pg_fetch_array($resultado); $num_proyecto=$reg["num_proyecto"];
      $sfecha=formato_aaaammdd($fecha); $sfechad=formato_aaaammdd($fecha_desde); $sfechah=formato_aaaammdd($fecha_hasta); $sfechav=formato_aaaammdd($fecha_vencim); $cambia_est="N";
      $sSQL="SELECT MODIFICA_ORDEN('$codigo_mov','$nro_orden','$tipo_causado','$sfecha','$ced_rif','$ced_rif_ces','$nombre_ces','$pago_ces','$num_proyecto','$sfechav','$sfechad','$sfechah','$tipo_documento','$nro_documento','$cambia_est','$concepto')";
      $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
      if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}else{ $error=0;?><script language="JavaScript">  muestra('MODIFICO EXITOSAMENTE');</script><? }
    }}
 }
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='Act_orden_pago.php?Gcriterio=C<? echo $nro_orden.$tipo_causado; ?>';</script> <? }
else { ?> <script language="JavaScript"> alert('Error Modificando'); history.back(); </script>  <? } ?>