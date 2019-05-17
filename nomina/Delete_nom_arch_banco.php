<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$cod_arch_banco=$_GET["cod_arch_banco"]; $tipo_arch_banco=$_GET["tipo_arch_banco"]; $tipo_nomina=$_GET["tipo_nomina"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a");  echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $url="Det_nomina_arch_banco.php?criterio=".$tipo_arch_banco.$cod_arch_banco;
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select tipo_nomina from NOM046 WHERE cod_arch_banco='$cod_arch_banco' and tipo_arch_banco='$tipo_arch_banco' and tipo_nomina='$tipo_nomina'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; ?>  <script language="JavaScript">  muestra('TIPO DE NOMINA NO EXISTE EN LA DEFINCION DE ARCHIVO');  </script> <? }
   else{$sSQL="SELECT ACTUALIZA_NOM046(3,'$cod_arch_banco','$tipo_arch_banco','$tipo_nomina')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?}
  }
}pg_close(); ?><script language="JavaScript">document.location ='<? echo $url; ?>';</script>
