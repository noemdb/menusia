<? 
$target_path = "/var/www/html/sia/nomina/";    //para linux
$target_path = "c:/AppServ/www/sia/nomina/";   //para windows
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) { echo "El archivo ". basename( $_FILES['uploadedfile']['name']). " ha sido subido";
$temp_arch=basename( $_FILES['uploadedfile']['name']); ?><script language="JavaScript">muestra('CARGO EXITOSAMENTE');</script><?
} else{echo "Ha ocurrido un error, trate de nuevo!"; $temp_arch=""; ?><script language="JavaScript">muestra('ERROR AL CARGAR EL ARCHIVO ...');</script><?
} 
$url="Act_car_arch.php?nombre_arch=".$temp_arch;
?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?
