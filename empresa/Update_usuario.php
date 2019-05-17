<?include ("../class/conect.php"); include ("../class/funciones.php"); $login=$_POST["txtLogin"]; $clave="";$nombre=$_POST["txtNombre"];$cargo=$_POST["txtCargo"]; $departamento=$_POST["txtDepartamento"];$cat_prog=$_POST["txtCat_prog"]; $cod_almacen=$_POST["txtCod_Almacen"]; $unidad_sol=$_POST["txtUnidad_Sol"];
$unidad_sol=substr($unidad_sol,0,100);
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $error=0; $url="usuarios.php";
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{$sSQL="Select * from SIA001 WHERE campo101='$login'";   $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript"> muestra('USUARIO NO EXISTE'); </script>  <? }
   else{ $resultado=pg_exec($conn,"SELECT ACTUALIZA_SIA001(2,'$login','$clave','U','$nombre','$cargo','$departamento','$cat_prog','$cod_almacen','','','$unidad_sol','','','','')");
     $error=pg_errormessage($conn); $error=substr($error, 0, 91); if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
      else{?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><? }
  }
}
pg_close();if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>
