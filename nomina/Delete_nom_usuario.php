<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$criterio=$_GET["criterio"];  $tipo_nomina=$_GET["tipo_nomina"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a");  echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $url="Det_nom_usuarios.php?criterio=".$criterio;
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{  $sSQL="Select tipo_nomina from nom059 WHERE usuario_sia='$criterio' and tipo_nomina='$tipo_nomina'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; ?>  <script language="JavaScript">  muestra('TIPO DE NOMINA NO EXISTE EN LA DEFINCION DE ARCHIVO');  </script> <? }
   else{$sSQL="SELECT ACTUALIZA_NOM059(3,'$criterio','$tipo_nomina','NO')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{$error=0;?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?}
  }
}pg_close(); ?><script language="JavaScript">document.location ='<? echo $url; ?>';</script>
