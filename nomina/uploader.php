<? 
// C:\AppServ\www\sia\nomina
$target_path = "c:/uploads/";
$target_path = "c:/AppServ/www/sia/nomina/";
$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) { echo "El archivo ". basename( $_FILES['uploadedfile']['name']). " ha sido subido";
} else{
echo "Ha ocurrido un error, trate de nuevo!";
} 
?>
