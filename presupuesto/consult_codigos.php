<?include ("../class/conect.php");  include ("../class/funciones.php");error_reporting(E_ALL);
$cod_presup=$_POST["txtcod_presup"]; $cod_fuente=$_POST["txtcod_fuente"]; $error=0; $equipo=getenv("COMPUTERNAME"); echo "ESPERE POR FAVOR BUSCANDO....","<br>";
if ($error==0){
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)) {$error=1; ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
  $sSQL="Select * from codigos where cod_presup='$cod_presup' and cod_fuente='$cod_fuente'";   $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('CODIGO PRESUPUESTARIO NO EXISTE');</script><?}
}
pg_close(); error_reporting(E_ALL ^ E_WARNING); if ($error==0){?><script language="JavaScript">document.location ='Act_codigos.php?Gcodigo=<? echo $cod_fuente.$cod_presup; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }  ?>