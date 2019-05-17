<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$referencia_modif=$_GET["txtreferencia_modif"];$tipo_modif=$_GET["txttipo_modif"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR COPIANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from pre009 WHERE referencia_modif='$referencia_modif' and tipo_modif='$tipo_modif'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE MODIFICACION NO EXISTE');</script><?}
   else{ $registro=pg_fetch_array($resultado);   $fecha_registro=$registro["fecha_registro"];  $total=0;$desc_cod="";
    $cod_busca="PRE009".$usuario_sia; 	 $sfecha=$fecha_registro;   
	$resultado=pg_exec($conn,"SELECT COPIA_PRE009('$cod_busca','$referencia_modif','$tipo_modif','$sfecha')"); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      else{?><script language="JavaScript">/*muestra('COPIO EXITOSAMENTE');*/ alert('COPIO EXITOSAMENTE');</script><?}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript"> window.close(); window.opener.location.reload(); </script>
