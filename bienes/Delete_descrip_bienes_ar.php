<?include ("../class/conect.php");  include ("../class/funciones.php"); $codigo_c=$_GET["Gcodigo_c"]; $num_descrip=$_GET["num_descrip"];  $equipo=getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="SELECT * From BIEN033 where codigo_c='$codigo_c' and num_descrip='$num_descrip'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('EL BIEN NO EXISTE');</script> <? }
    else{ $error=1; $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN033(3,'$codigo_c','$num_descrip','','')"); $error=pg_errormessage($conn);  $error=substr($error,0,91);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close(); if ($error==0){?><script language="JavaScript"> window.close();window.opener.location.reload(); </script> <? }?>


