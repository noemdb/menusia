<?include ("../class/conect.php");  include ("../class/funciones.php"); $periodo=$_POST["txtperiodo"]; 
$equipo=getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $error=0;
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $error=0;
   $resultado=pg_exec($conn,"UPDATE SIA005 set campo503='$periodo' where campo501='06'"); $error=pg_errormessage($conn); $error=substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?} 
   $resultado=pg_exec($conn,"UPDATE SIA005 set campo503='$periodo' where campo501='02'"); $error=pg_errormessage($conn); $error=substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?} 
   $resultado=pg_exec($conn,"UPDATE SIA005 set campo503='$periodo' where campo501='01'"); $error=pg_errormessage($conn); $error=substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?} 
  }
pg_close(); error_reporting(E_ALL ^ E_WARNING);
if($error==0){?><script language="JavaScript">document.location='menu.php';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>


