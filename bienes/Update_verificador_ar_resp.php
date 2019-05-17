<?include ("../class/conect.php");  include ("../class/funciones.php");
$ced_res_verificador=$_POST["txtced_res_verificador"]; $nombre_res_ver=$_POST["txtnombre_res_ver"]; $observaciones_ver=$_POST["txtobservaciones_ver"]; 
$url="Act_verificador_ar_resp.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN030 WHERE ced_res_verificador='$ced_res_verificador'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEDULA DEL RESPONSABLE VERIFICADOR NO EXISTE NO EXISTE');</script> <? }
   else{$error=1;$resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN030(2,'$ced_res_verificador','$nombre_res_ver','$observaciones_ver')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
