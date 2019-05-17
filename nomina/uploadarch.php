<? 
$target_path = "c:/uploads/tmpp/";  $nombre_arch="";
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
{ echo "El archivo ". basename( $_FILES['uploadedfile']['name']). " ha sido subido"; $mensaje="El archivo ". basename( $_FILES['uploadedfile']['name']). " ha sido subido";
$nombre_arch=basename( $_FILES['uploadedfile']['name']);
} else{
echo "Ha ocurrido un error, trate de nuevo!";
$mensaje="Ha ocurrido un error, trate de nuevo!";
} $url="Act_car_arch.php?nombre_arch=".$nombre_arch;
?><script language="JavaScript">muestra('FINALIZO LA CARGA: '.'<? echo $mensaje; ?>');
document.location ='<? echo $url; ?>';
</script> 