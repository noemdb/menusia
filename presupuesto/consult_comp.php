<?include ("../class/conect.php");  include ("../class/funciones.php");error_reporting(E_ALL);
$referencia_comp=$_POST["txtreferencia_comp"]; $tipo_compromiso=$_POST["txttipo_compromiso"];
$cod_comp="0000"; $error=0; $equipo=getenv("COMPUTERNAME"); echo "ESPERE POR FAVOR BUSCANDO....","<br>";
if ($error==0){
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)) {$error=1; ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
  $sSQL="Select fecha_compromiso,cod_comp from pre006 WHERE referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'";
  $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE COMPROMISO NO EXISTE');</script><?}
    else{ $registro=pg_fetch_array($resultado);$cod_comp=$registro["cod_comp"];}
}
pg_close(); error_reporting(E_ALL ^ E_WARNING); if ($error==0){?><script language="JavaScript">document.location ='Act_compromisos.php?Gcriterio=<? echo $tipo_compromiso.$referencia_comp.$cod_comp; ?>';</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }  ?>