<?include ("../class/conect.php"); include ("../class/funciones.php");  $cod_unidad=""; $cod_empresa="";
$login=$_GET["usuario"]; $cod_dependencia=$_GET["dep"]; $cod_direccion=$_GET["dir"]; $cod_departamento=$_GET["depart"]; $cod_sub_departamento=$_GET["subdep"]; $url="Det_asig_ubic_bienes.php?usuario=".$login;
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $sSQL="Select * from SIA009 WHERE usuario='$login' and cod_dependencia='$cod_dependencia' and (cod_direccion='$cod_direccion') and (cod_departamento='$cod_departamento') and (cod_sub_departamento='$cod_sub_departamento')"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript"> muestra('CODIGO ubicacion NO ASIGNADO AL USUARIO'); </script>  <? }
   else{ $resultado=pg_exec($conn,"SELECT ACTUALIZA_SIA009(3, '$login','$cod_dependencia','$cod_direccion','$cod_departamento','$cod_sub_departamento','$cod_unidad','$cod_empresa', '', '', '', '', '', 0, 0)");  $error=pg_errormessage($conn); $error=substr($error, 0, 91);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? }
  }
}pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? } ?>