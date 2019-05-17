<?include ("../class/conect.php");  include ("../class/funciones.php");
error_reporting(E_ALL);
$referencia_dife=$_POST["txtreferencia_dife"];
$tipo_diferido=$_POST["txttipo_diferido"];
$fecha_diferido=$_POST["txtfecha"];
$descripcion_dife=$_POST["txtDescripcion"];
$equipo = getenv("COMPUTERNAME");
$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{
  $sSQL="Select * from pre023 WHERE referencia_dife='$referencia_dife' and tipo_diferido='$tipo_diferido'";
  $resultado=pg_exec($conn,$sSQL);
  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE MOVIMIENTO DIFERIDO NO EXISTE');</script><?}
   else{
     $registro=pg_fetch_array($resultado);
     $adescripcion=$registro["descripcion_dife"];
     $sfecha=formato_aaaammdd($fecha_diferido);
     $resultado=pg_exec($conn,"SELECT MODIFICA_PRE023('$referencia_dife','$tipo_diferido','$sfecha','$descripcion_dife','$minf_usuario')");
     $error=pg_errormessage($conn);
     $error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
      else{?><script language="JavaScript">muestra('MODIFICO EXITOSAMENTE');</script><?
         $desc_doc="MOV.DIFERIDO: TIPO:".$tipo_diferido.", REFERENCIA:".$referencia_dife.", DESCRIPCION:".$adescripcion;
         $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Modifico','$sfecha','$desc_doc')");
         $error=pg_errormessage($conn);
         $error=substr($error, 0, 61);
         if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error;?>');</script><?}}
  }
}
pg_close();?>
<script language="JavaScript">history.back();</script>