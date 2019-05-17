<?include ("../class/conect.php");  include ("../class/funciones.php");
$Codigo_Cuenta=$_POST["txtCodigo_Cuenta"];$nombre_cuenta=$_POST["txtNombre_Cuenta"];$Clasificacion=$_POST["txtClasificacion"];$TSaldo=$_POST["txtTSaldo"];
echo "ESPERE POR FAVOR INCLUYENDO....";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{
  $sSQL="Select * from con098 WHERE codigo_cuenta='$Codigo_Cuenta'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){?> <script language="JavaScript"> muestra('CODIGO DE CUENTA YA EXISTE'); </script> <? }
   else{
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_CON098(1,'$Codigo_Cuenta','$nombre_cuenta','$TSaldo','$Clasificacion')");     $error=pg_errormessage($conn); $error=substr($error,0,91);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }  else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? }
  }
}
pg_close();
?>
<script language="JavaScript">history.back();</script>