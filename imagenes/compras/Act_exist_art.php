<?include ("../class/conect.php"); include ("../class/funciones.php");

echo "ESPERE ACTUALIZANDO EXISTENCIA....","<br>";
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{
  $resultado=pg_exec($conn,"SELECT actualiza_existencia()");   $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error." ACT "; ?>'); </script> <? }
  
  ?> <script language="JavaScript">  muestra('PROCESO FINALIZADO'); </script> <?
}pg_close();?> <script language="JavaScript">javascript:window.close();</script>