<? 
$url="cargaflujocaja.php?mes=".$mes."&ano=".$ano;
$password=$_GET["password"];$user=$_GET["user"]; $dbname=$_GET["dbname"]; $mes=$_GET["mes"]; $ano=$_GET["ano"];  $codigo_mov=$_GET["codigo_mov"];
echo "EPERE POR FAVOR PROCESANDO FLUJO DE CAJA ...","<br>";

 //header("Location: index.php");
 
include("cargaflujocaja.php");
?>



<!--
<iframe src="cargaflujocaja.php?mes=<?echo $mes?>&ano=<?echo $ano?>" width="870" height="360" scrolling="auto" frameborder="1"></iframe>

-->