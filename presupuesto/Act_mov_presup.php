<?include ("../class/conect.php"); include ("../class/funciones.php"); echo "ESPERE ACTUALIZANDO MOVIMIENTOS....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_MOVIMIENTOS(0)"); $error=pg_errormessage($conn); $error=substr($error, 0, 90);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  echo "ESPERE ACTUALIZANDO AJUSTES....","<br>";
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_MOVIMIENTOS(3)");  $error=pg_errormessage($conn);  $error=substr($error, 0, 90);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  echo "ESPERE ACTUALIZANDO CAUSADOS....","<br>";
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_MOVIMIENTOS(1)");  $error=pg_errormessage($conn);  $error=substr($error, 0, 90);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  echo "ESPERE ACTUALIZANDO PAGOS....","<br>";
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_MOVIMIENTOS(2)");  $error=pg_errormessage($conn);  $error=substr($error, 0, 90);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  echo "ESPERE ACTUALIZANDO DIFERIDOS....","<br>";
  $resultado=pg_exec($conn,"SELECT ACTUALIZA_MOVIMIENTOS(4)");  $error=pg_errormessage($conn);  $error=substr($error, 0, 90);
  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
  ?> <script language="JavaScript">  muestra('PROCESO FINALIZADO'); </script> <?
}pg_close();?>
<script language="JavaScript">javascript:window.close();</script>