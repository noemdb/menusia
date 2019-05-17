<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$cod_documento=$_POST["txtcod_documento"]; $tipo_documento=$_POST["txttipo_documento"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a"); $url="Act_tipo_documento.php";
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $error=0; $sSQL="Select * from PAG017 WHERE cod_documento='$cod_documento'";   $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){ $error=1; ?>  <script language="JavaScript">  muestra('TIPO DE DOCUMENTO NO EXISTE');  </script> <? }
   else{$registro=pg_fetch_array($resultado); $atipo_documento=$registro["tipo_documento"]; $error=0;
     if($error==0){ $fecha=asigna_fecha_hoy(); $sfecha=formato_aaaammdd($fecha); $sSQL="SELECT ACTUALIZA_PAG017(2,'$cod_documento','$tipo_documento')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error=substr($error,0,91);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?} else{?><script language="JavaScript">  muestra('MODIFICO EXITOSAMENTE'); </script><?}
         $desc_doc="TIPO DE DOCUMENTO, CODIGO:".$cod_documento.", DOCUMENTO:".$atipo_documento; $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('01','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);$error=substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? }}
   }
}
pg_close();error_reporting(E_ALL ^ E_WARNING); ?><script language="JavaScript">history.back();</script>