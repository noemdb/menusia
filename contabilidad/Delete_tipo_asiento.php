<?include ("../class/conect.php");  include ("../class/funciones.php");
$Tipo_Asiento=$_GET["txtTipo_Asiento"];$Des_Asiento="";echo "ESPERE POR FAVOR ELIMINANDO....";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script>  <?}
 else{  $sSQL="Select * from con009 WHERE tipo_asiento='$Tipo_Asiento'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript">  muestra('TIPO DE ASIENTO NO EXISTE'); </script> <? }
   else{ $equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_CON009(3,'$Tipo_Asiento','$Des_Asiento','','',0,0,'$minf_usuario')");     $error=pg_errormessage($conn);     $error=substr($error,0,91);
     if (!$resultado){?><script language="JavaScript">  muestra('<? echo $error; ?>');  </script><? }      else{  ?><script language="JavaScript"> muestra('ELIMINO EXITOSAMENTE'); </script>  <? }
  }
}
pg_close();?><script language="JavaScript">window.close(); window.opener.location.reload();</script>