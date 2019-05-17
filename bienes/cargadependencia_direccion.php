<?include ("../class/conect.php"); include ("../class/funciones.php");
$password=$_GET["password"];$user=$_GET["user"]; $dbname=$_GET["dbname"];  $cod_dependen=$_GET["cod_dependen"];$cod_direcci=$_GET["cod_direcci"]; 
?><iframe src="Det_departamentos.php?cod_dependen=<?echo $cod_dependen?>&cod_direcci=<?echo $cod_direcci?>" width="940" height="350" scrolling="auto" frameborder="1"> </iframe>
<?pg_close();?>
