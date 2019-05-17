<?include ("../class/conect.php");  include ("../class/funciones.php"); 
$codigo_mov=$_GET["codigo_mov"]; $password=$_GET["password"];$user=$_GET["user"]; $dbname=$_GET["dbname"]; $tipo=$_GET["tipo"]; $pdesde=$_GET["pdesde"]; $phasta=$_GET["phasta"];
$fdesde=$_GET["fdesde"];  $fhasta=$_GET["fhasta"]; $fdesde=formato_aaaammdd($fdesde);  $fhasta=formato_aaaammdd($fhasta);
?><iframe src="Det_ent_planillas.php?tipo_planilla=<?echo $tipo?>&plan_desde=<?echo $pdesde?>&plan_hasta=<?echo $phasta?>&fecha_desde=<?echo $fdesde?>&fecha_hasta=<?echo $fhasta?>"  width="940" height="350" scrolling="auto" frameborder="1"> </iframe>
<?pg_close();?>