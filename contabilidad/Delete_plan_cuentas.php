<?include ("../class/conect.php");  include ("../class/funciones.php");
$Codigo_Cuenta=$_GET["txtCodigo_Cuenta"];
$nombre_cuenta="";
$Clasificacion="";
$TSaldo="";
echo "ESPERE POR FAVOR ELIMINANDO....";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn))  { ?>  <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script>  <?}
 else{
  $sSQL="Select * from con098 WHERE codigo_cuenta='$Codigo_Cuenta'";
  $resultado=pg_exec($conn,$sSQL);
  $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript"> muestra('C&Oacute;DIGO DE CUENTA NO EXISTE');  </script> <? }
   else{
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_CON098(3,'$Codigo_Cuenta','$nombre_cuenta','$TSaldo','$Clasificacion')");
     $error=pg_errormessage($conn);
     $error=substr($error, 0, 61);
     if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
      else{$error= "ELIMINO EXITOSAMENTE"; ?><script language="JavaScript"> muestra('<? echo $error; ?>'); </script>         <? }
  }
}
pg_close();
?>
<script language="JavaScript"> cerrar_ventana(); </script>