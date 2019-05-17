<?include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL);
$referencia_comp=$_GET["txtreferencia_comp"];$tipo_compromiso = $_GET["txttipo_compromiso"]; $cod_comp = $_GET["txtcod_comp"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR COPIANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from pre006 WHERE referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_comp='$cod_comp'";
  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE COMPROMISO NO EXISTE');</script><?}
   else{ $registro=pg_fetch_array($resultado);   $fecha_compromiso=$registro["fecha_compromiso"];$adescripcion=$registro["descripcion_comp"]; $total=0;$desc_cod="";
     $cod_busca="PRE006".$usuario_sia; 
	 $sfecha=$fecha_compromiso;   $resultado=pg_exec($conn,"SELECT COPIA_PRE006('$cod_busca','$referencia_comp','$tipo_compromiso','$cod_comp','$sfecha')"); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      else{?><script language="JavaScript">muestra('COPIO EXITOSAMENTE');</script><?}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript"> window.close(); window.opener.location.reload(); </script>