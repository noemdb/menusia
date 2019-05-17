<?include ("../class/conect.php"); include ("../class/funciones.php"); $login=$_GET["usuario"]; $cod_presup=$_GET["codigo"]; $fuente_financ=$_GET["fuente"]; $url="Det_asig_part.php?usuario=".$login;
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $sSQL="Select * from SIA008 WHERE usuario='$login' and cod_presup='$cod_presup' and cod_fuente='$fuente_financ'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript"> muestra('CODIGO NO ASIGNADO AL USUARIO'); </script>  <? }
   else{ $resultado=pg_exec($conn,"SELECT ACTUALIZA_SIA008(3, '$login','$cod_presup','$fuente_financ', '', '', '', '', '', 0, 0)");  $error=pg_errormessage($conn); $error=substr($error, 0, 91);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><? }
  }
}pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? } ?>