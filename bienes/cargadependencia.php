<?include ("../class/conect.php"); include ("../class/funciones.php");
$password=$_GET["password"];$user=$_GET["user"]; $dbname=$_GET["dbname"];  $cod_dependen=$_GET["cod_dependen"]; 
?><iframe src="Det_direcciones.php?cod_dependen=<?echo $cod_dependen?>"  width="940" height="350" scrolling="auto" frameborder="1"> </iframe>
<?pg_close();?>
