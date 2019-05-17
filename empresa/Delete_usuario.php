<?include ("../class/conect.php"); include ("../class/funciones.php"); $login=$_POST["txtLogin"]; $url="usuarios.php";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $error=0;
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select * from SIA001 WHERE campo101='$login'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript"> muestra('USUARIO NO EXISTE'); </script>  <? }
   else{ $resultado=pg_exec($conn,"SELECT ACTUALIZA_SIA001(3,'$login','','U','','','','','','','','','','','','')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? }
  }
}pg_close();if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>
