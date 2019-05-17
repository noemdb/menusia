<?include ("../class/conect.php");  include ("../class/funciones.php");
$ced_res_rotu=$_POST["txtced_res_rotu"]; $nombre_res_rotu=$_POST["txtnombre_res_rotu"]; $observaciones_rotu=$_POST["txtobservaciones_rotu"]; 
$url="Act_rotulador_ar_resp.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN032 WHERE ced_res_rotu='$ced_res_rotu'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA DE RESPONSABLE ROTULADOR NO EXISTE');</script> <? }
   else{$error=1;$resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN032(2,'$ced_res_rotu','$nombre_res_rotu','$observaciones_rotu')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
