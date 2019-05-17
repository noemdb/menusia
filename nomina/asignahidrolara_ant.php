<?include ("../class/funciones.php");

   $conn = pg_connect("host=localhost port=5432 password=super user=usia dbname=DATOS");
   if (!$conn) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }

   

   $error=0;
   if($error==0){
     $path="nmpp011.txt"; $fp = fopen($path,"r");
     while ($linea= fgets($fp,1024)) { 
	     //echo $linea,"<br>";
         $datos = explode(";", $linea); 
         $cod_empleado=$datos[1]; $cod_empleado=ltrim($cod_empleado); $cod_empleado=Rellenarcerosizq($cod_empleado,10);     $tipo_nomina='NN';
         $cod_concepto=$datos[2]; $cod_concepto=ltrim($cod_concepto); $cod_concepto=Rellenarcerosizq($cod_concepto,3);

         $sSQL="Select * from NOM006 WHERE cod_empleado='$cod_empleado'"; $res=pg_query($sSQL); $filas=pg_num_rows($res); if($filas>=1){$reg=pg_fetch_array($res); $tipo_nomina=$reg["tipo_nomina"];  echo "Existe: ".$cod_empleado." ".$tipo_nomina,"<br>"; } else{$cod_concepto="000"; echo "NO LOCALIZADO: ".$cod_empleado." ".$sSQL,"<br>";   } 
    
		 $cantidad=$datos[4]; $cantidad=cambia_coma_numero($cantidad);   
         $monto=$datos[5]; $monto=cambia_coma_numero($monto);   

         if(($cod_concepto<>'000')){ 
		    $fec_ini="2009-11-01"; $fec_exp="9999-12-31";  $temp10=0; $temp11=0; $temp18=0; $temp19=0; $temp20=0;
		    $sSQL="Select cod_empleado from NOM011 WHERE tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado' and cod_concepto='$cod_concepto'"; $res=pg_query($sSQL); $filas=pg_num_rows($res); 
			if($filas>=1){ $sql="Update NOM011 set cantidad=".$cantidad.",monto=".$monto.",inf_usuario='MIGRADO ACT' WHERE tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado' and cod_concepto='$cod_concepto'"; }
            else{$sql="INSERT INTO NOM011(tipo_nomina,cod_empleado,cod_concepto,cantidad,monto,fecha_ini,fecha_exp,activo, calculable, acumulado, saldo, cod_presup,frecuencia, afecta_presup, cod_retencion, cod_presup_ant, prestamo,monto_prestamo, nro_cuotas, nro_cuotas_c, status, inf_usuario)";
            $sql=$sql."VALUES ('".$tipo_nomina."','".$cod_empleado."','".$cod_concepto."',".$cantidad.",".$monto.",'".$fec_ini."','".$fec_exp."','S','S',".$temp10.",".$temp11.",'','','SI','000','','NO',".$temp18.",".$temp19.",".$temp20.",'','MIGRADO')" ;}
            $resultado=pg_exec($conn,$sql);
         }

     }
   }
?>