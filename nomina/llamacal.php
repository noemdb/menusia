<?include ("../class/conect.php"); include ("../class/funciones.php"); include ("../class/configura.inc");
$tipo_nomina=$_GET["tipo_nomina"];$fdesde=$_GET["fdesde"];$fhasta=$_GET["fhasta"]; $num_semana=$_GET["num_semana"];   $parametro="T"; $u_semana=$_GET["u_semana"];
$criterio=$tipo_nomina.$fdesde.$fhasta.$num_semana.$parametro.$u_semana; $nomb_llama="Calcula_nomina.php"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ $error=1; $nomb_llama="erorr.php";  echo 'OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS',"<br>";} else{ $Nom_Emp=busca_conf(); }
if($Cod_Emp=="70"){$nomb_llama="Calcula_nomina_hl.php";}  
/*
if($error==0){ if ($gnomina=="00"){$error=0;} 
else {  if($tipo_nomina<>$gnomina) {$error=1; echo $tipo_nomina." a ".$gnomina." b ".$criterio; echo 'TIPO DE NOMINA NO ACTIVA PARA EL USUARIO',"<br>";}  } } 
*/ 
if($error==0){}?>
<iframe src="Calcula_nomina.php?criterio=<?echo $criterio?>" width="950" height="350" scrolling="auto" frameborder="1"></iframe> 