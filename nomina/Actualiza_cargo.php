<? include ("../class/conect.php");  include ("../class/funciones.php");
echo "ESPERE POR FAVOR ACTUALIZANDO....","<br>"; echo $dbname,"<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{$sSQL="SELECT ACTUALIZA_CARGOS_ASIGNADOS(1)"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=" ".substr($error, 0, 81); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;}
   if($error==0){?><script language="JavaScript"> muestra('ACTULIZACION DE CARGOS ASIGNADOS FINALIZADA');</script><? }
}
pg_close(); ?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>