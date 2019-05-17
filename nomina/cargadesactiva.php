<?include ("../class/conect.php"); include ("../class/funciones.php");  $tipo_nomina=$_GET["tipo_nomina"];$cod_concepto=$_GET["cod_concepto"];
$password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"]; $criterio=$tipo_nomina.$cod_concepto."0"; $url="Det_carga_manual.php?criterio=".$criterio;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$sSQL="update nom011 set activo='NO' WHERE tipo_nomina='$tipo_nomina' and cod_concepto='$cod_concepto'";  $resultado=pg_exec($conn,$sSQL); 
$error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); pg_close();  ?>
<iframe src="Det_carga_manual.php?criterio=<?echo $criterio?>" width="950" height="350" scrolling="auto" frameborder="1"></iframe>





