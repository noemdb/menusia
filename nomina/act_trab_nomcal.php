<? include ("../class/seguridad.inc");include ("../class/conects.php"); include ("../class/funciones.php");  

  echo "ESPERE POR FAVOR REVISANDO INF. NOMINAS CALCULADAS....","<br>";
  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (!$conn) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
  $sql="SELECT * FROM TRABAJADORES Order by cod_empleado";  $sql="SELECT * FROM CAL_NOMINA Order by cod_empleado";
  $i=0;  $total=0; 	  $res=pg_query($sql); echo $sql,"<br>";
  while($registro=pg_fetch_array($res)){ $i=$i+1;
	    $cod_empleado=$registro["cod_empleado"];  $cedula=$registro["cedula"]; $nombre=$registro["nombre"]; 
        $cod_cargo=$registro["cod_cargo"]; $des_cargo=$registro["denominacion"];
		
		$sqlb="select * from NOM019 where cod_empleado='$cod_empleado' and nombre<>'$nombre'"; $resb=pg_query($sqlb); $filasb=pg_num_rows($resb);
		if($filasb>=1){  $sqlb="update NOM019 set nombre='$nombre' where cod_empleado='$cod_empleado' and nombre<>'$nombre'"; 
		  $resultado=pg_exec($conn,$sqlb);$error=pg_errormessage($conn); $error=substr($error,0,70);
		  if(!$resultado){ echo "Error modificando nombre ".$cod_empleado,"<br>"; }else{ echo "Cambio de nombre : ".$cod_empleado." ".$nombre,"<br>"; }
		
		}
		
		$sqlb="select * from NOM019 where cod_empleado='$cod_empleado' and des_cargo<>'$des_cargo'"; $resb=pg_query($sqlb); $filasb=pg_num_rows($resb);
		
		//echo $sqlb,"<br>";
		if($filasb>=1){  $sqlb="update NOM019 set des_cargo='$des_cargo' where cod_empleado='$cod_empleado' and des_cargo<>'$des_cargo'"; 
		   $resultado=pg_exec($conn,$sqlb);$error=pg_errormessage($conn); $error=substr($error,0,70);
		   if(!$resultado){ echo "Error modificando Cargo ".$cod_empleado,"<br>"; }else{ echo "Cambio de Cargo : ".$cod_empleado." ".$nombre." ".$des_cargo,"<br>"; }
		}
  }		
  pg_close();
?>