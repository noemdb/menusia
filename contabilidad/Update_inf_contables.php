<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_informe=$_POST["txtcod_informe"]; $nombre_informe=$_POST["txtnombre_informe"];  $arch_informe=$_POST["txtarch_informe"];  $equipo = getenv("COMPUTERNAME");
$MInf_Usuario = $equipo." ".date("d/m/y H:i a");echo "ESPERE POR FAVOR MODIFICANDO....";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{$sSQL="Select * from con005 WHERE cod_informe='$cod_informe'";$resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript"> muestra('CODIGO DE INFORME NO EXISTE');  </script>  <? }
   else{$resultado=pg_exec($conn,"SELECT ACTUALIZA_CON005(2,'$cod_informe','$nombre_informe','$arch_informe')"); $merror=pg_errormessage($conn);$merror=substr($merror,0,91);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
      else{?><script language="JavaScript">muestra('MODIFCO EXITOSAMENTE');</script><? }
  }
}
pg_close();?><script language="JavaScript">history.back();</script>