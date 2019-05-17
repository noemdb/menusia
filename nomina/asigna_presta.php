<?include ("../class/funciones.php");

   $conn = pg_connect("host=localhost port=5432 password=super user=usia dbname=DATOS");
   if (!$conn) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }

   

   $error=0;
   if($error==0){
   
     //$sql="Update NOM011 set cantidad=0,monto=0,saldo=0,acumulado=0 WHERE (cod_concepto='524') or (cod_concepto='507') or (cod_concepto='580')or (cod_concepto='581')or (cod_concepto='582')or (cod_concepto='583')or (cod_concepto='584')or (cod_concepto='585')or (cod_concepto='586')or (cod_concepto='588')or (cod_concepto='589')or (cod_concepto='591')or (cod_concepto='592')";
     //$resultado=pg_exec($conn,$sql);
   
     $path="nmpp011.txt"; $fp = fopen($path,"r");
     while ($linea= fgets($fp,1024)) { 
	     //echo $linea,"<br>";
         $datos = explode(";", $linea); 
         $cod_empleado=$datos[1]; $cod_empleado=ltrim($cod_empleado); $cod_empleado=Rellenarcerosizq($cod_empleado,10);     $tipo_nomina='NN';
         $cod_concepto=$datos[2]; $cod_concepto=ltrim($cod_concepto); $cod_concepto=Rellenarcerosizq($cod_concepto,3);

         $sSQL="Select * from NOM006 WHERE cod_empleado='$cod_empleado'"; $res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){$reg=pg_fetch_array($res); $tipo_nomina=$reg["tipo_nomina"];  
		 //echo "Existe: ".$cod_empleado." ".$tipo_nomina,"<br>"; 
		 } else{$cod_concepto="000"; 
		 //echo "NO LOCALIZADO: ".$cod_empleado." ".$sSQL,"<br>";   
		 } 
    
		 $cantidad=$datos[4]; $cantidad=cambia_coma_numero($cantidad);   
         $monto=$datos[5]; $monto=cambia_coma_numero($monto);   
		 $saldo=$datos[6]; $saldo=cambia_coma_numero($saldo);
         
		 $fecha1=trim($datos[8]); $fecha2=trim($datos[9]);
		 if($fecha1==""){$fec_ini="2010-01-01";} else{ $fec_ini=substr($fecha1,0,4)."-".substr($fecha1,4,2)."-".substr($fecha1,6,2); }
		 if($fecha2==""){$fec_exp="9999-12-31"; } else{ $fec_exp=substr($fecha2,0,4)."-".substr($fecha2,4,2)."-".substr($fecha2,6,2); }
		 
         if(($cod_concepto=='516')or($cod_concepto=='507')or($cod_concepto=='580')or ($cod_concepto=='581')or ($cod_concepto=='582')or ($cod_concepto=='583')or ($cod_concepto=='584')or ($cod_concepto=='585')or ($cod_concepto=='586')or ($cod_concepto=='588')or ($cod_concepto=='589')or ($cod_concepto=='591')or ($cod_concepto=='592')){ 
		 //if ($cod_concepto=='516'){
		    $temp10=0; $temp11=0; $temp18=0; $temp19=0; $temp20=0; if ($cod_concepto=='516'){$cod_concepto='524';}
		    $sSQL="Select cod_empleado from NOM011 WHERE tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado' and cod_concepto='$cod_concepto'"; $res=pg_query($sSQL); $filas=pg_num_rows($res); 
			if($filas>=1){ $sql="Update NOM011 set cantidad=".$cantidad.",monto=".$monto.",saldo=".$saldo." WHERE tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado' and cod_concepto='$cod_concepto'"; 
          		$resultado=pg_exec($conn,$sql); 
				echo "Existe: ".$cod_empleado." ".$tipo_nomina." ".$cod_concepto." ".$monto,"<br>";}
         }

     }
   }
?>