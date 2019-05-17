<?include ("../class/funciones.php");

  $conn = pg_connect("host=localhost port=5432 password=super user=usia dbname=DATOS");
   if (!$conn) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }

   
   $error=0;
   if($error==0){
   $path="rifhl.txt"; $fp = fopen($path,"r");
   while ($linea= fgets($fp,1024)) { 
      $datos = explode(";", $linea); $tcod_emp=$datos[0];  $codigo_mov="000000";
	  echo $linea,"<br>";
      $rif=$datos[0]; $rif=ltrim($rif);
	  $cedula=$datos[1]; $cedula=ltrim($cedula);
	  $cod_empleado=$datos[1]; $cod_empleado=ltrim($cod_empleado);$cod_empleado=Rellenarcerosizq($cod_empleado,10);
	  
	  
	  
	   $ssql="Update nom007 set rif_empleado='$rif' where cod_empleado='$cod_empleado'";
       $resultado=pg_exec($conn,$ssql);
	    echo $ssql,"<br>";
} }

pg_close();


?>
   