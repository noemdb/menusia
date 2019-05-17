<?include ("../class/conect.php");  include ("../class/funciones.php");
error_reporting(E_ALL); $cod_estructura=$_GET["cod_estructura"];$cedula=$_GET["cedula"];
$url="Det_asig_comp_est.php?cod_estructura=".$cod_estructura;echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from pag037 where cod_estructura='$cod_estructura' and ced_rif_est='$cedula'";    $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CEUDLA NO EXISTE EN LA ESTRUCTURA');</script> <? }
   else{ $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG037(3,'$cod_estructura','$cedula','00000000','0000',0,'','','','',0,0)");
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>


