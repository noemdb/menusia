<?include ("../class/conect.php");  include ("../class/funciones.php");
$ced_rif=$_POST["txtced_rif"]; $nombre_ocupante=$_POST["txtnombre_ocupante"]; $cedula=$_POST["txtcedula"]; $rif=$_POST["txtrif"]; $nit=$_POST["txtnit"]; $observacion=$_POST["txtobservacion"]; 
$url="Act_ocupa_bien_inmu_ar.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN011 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('EL OCUPANTE NO EXISTE');</script> <? }
   else{$error=1;$resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN011(2,'$ced_rif','$nombre_ocupante','$cedula','$rif','$nit','$observacion')");$error=pg_errormessage($conn); $error=substr($error,0,91);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
