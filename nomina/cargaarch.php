<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha_hoy=asigna_fecha_hoy();
$tipo_nomina=$_GET["tipo_nomina"];$cod_concepto=$_GET["cod_concepto"]; $nombre_arch=$_GET["nombre_arch"];
$col1=$_GET["col1"]; $col2=$_GET["col2"]; $cambia=$_GET["cambia"]; $buscarp=$_GET["buscarp"]; $col1=$col1*1; $col2=$col2*1;
$col1=$col1-1; $col2=$col2-1; $criterio=$tipo_nomina.$cod_concepto."0"; 
//echo "ESPERE POR FAVOR CARGANDO ARCHIVO....","<br>";
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  
if (pg_ErrorMessage($conn)){$error=1; echo 'OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS',"<br>";}
 else{ $error=0; $mov=9; $cod_partida=""; $frecuencia="3"; $afecta_presup="SI"; $cod_retencion="000";
    $formato_trab="XXXXXXXXXX";$sql="Select * from SIA005 where campo501='04'";$resultado=pg_query($sql);if($registro=pg_fetch_array($resultado,0)){$formato_trab=$registro["campo504"];$formato_cargo=$registro["campo505"];$formato_dep=$registro["campo506"];}
	$l=strlen($formato_trab);
    $sSQL="Select * from NOM002 WHERE cod_concepto='$cod_concepto' and tipo_nomina='$tipo_nomina'";  $res=pg_query($sSQL); $filas=pg_num_rows($res); 
    if($filas>=1){$reg=pg_fetch_array($res); $cod_partida=$reg["cod_partida"]; $frecuencia=$reg["frecuencia"]; $afecta_presup=$reg["afecta_presup"]; $cod_retencion=$reg["cod_retencion"];}
      else{$error=1; echo 'CODIGO DE CONCEPTO NO LOCALIZADO',"<br>"; }
    if($error==0){ if (file_exists($nombre_arch)){$error=0;}else{$error=1; echo 'ARCHIVO NO LOCALIZADO',"<br>";} }
	if($error==0){ if ($gnomina=="00"){$error=0;} else {  if($tipo_nomina<>$gnomina) {$error=1; echo 'TIPO DE NOMINA NO ACTIVA PARA EL USUARIO',"<br>"; }  } } 
    if($error==0){ 
	  if($cambia=="CANTIDAD"){$sql="Update NOM011 set cantidad=0 WHERE tipo_nomina='$tipo_nomina'  and cod_concepto='$cod_concepto'"; }
	   else{$sql="Update NOM011 set monto=0 WHERE tipo_nomina='$tipo_nomina'  and cod_concepto='$cod_concepto'"; }
	  $resultado=pg_exec($conn,$sql);
	  $path=$nombre_arch; $fp = fopen($path,"r");
      while ($linea=fgets($fp,1024)) { $datos = explode(";", $linea); $cantidad=0; $monto=0;         
         if($buscarp=="CEDULA"){ $cedula=$datos[$col1]; $cedula=ltrim($cedula);
		    $sSQL="Select cod_categoria,cedula,cod_empleado from NOM006 WHERE cedula='$cedula' and tipo_nomina='$tipo_nomina'";}
		 else{ $cod_empleado=$datos[$col1]; $cod_empleado=ltrim($cod_empleado); $cod_empleado=Rellenarcerosizq($cod_empleado,$l);
			$sSQL="Select cod_categoria,cedula,cod_empleado from NOM006 WHERE cod_empleado='$cod_empleado' and tipo_nomina='$tipo_nomina'";} 
		 $res=pg_query($sSQL); $filas=pg_num_rows($res); 
		 if($filas>=1){$reg=pg_fetch_array($res); $cod_categoria=$reg["cod_categoria"]; $cedula=$reg["cedula"]; $cod_empleado=$reg["cod_empleado"]; $error2=0;  } else { $error2=1; }     
	     if($cambia=="CANTIDAD"){$cantidad=$datos[$col2]; $cantidad=cambia_coma_numero($cantidad); $mov=2;}  
           else{$monto=$datos[$col2]; $monto=cambia_coma_numero($monto); $mov=3; }  
         if($error2==0) { $cod_presup=$cod_categoria."-".$cod_partida;		    
			$fec_ini="2012-01-01"; $fec_exp="9999-12-31";  $temp10=0; $temp11=0; $temp18=0; $temp19=0; $temp20=0;
		    $sSQL="Select cod_empleado from NOM011 WHERE tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado' and cod_concepto='$cod_concepto'"; $res=pg_query($sSQL); $filas=pg_num_rows($res); 
			if($filas>=1){$sql="Update NOM011 set cantidad=".$cantidad.",monto=".$monto." WHERE tipo_nomina='$tipo_nomina' and cod_empleado='$cod_empleado' and cod_concepto='$cod_concepto'"; 
			   $sql="SELECT ACT_MOVIMIENTO_NOM011($mov,'$tipo_nomina','$cod_empleado','$cod_concepto',$cantidad,$monto,'SI','SI','$frecuencia')";}
            else{$sql="SELECT ACTUALIZA_NOM011(1,'$tipo_nomina','$cod_empleado','$cod_concepto',$cantidad,$monto,'$fec_ini','$fec_exp','SI','SI',0,0,'$cod_presup','$frecuencia','$afecta_presup','$cod_retencion','','N',0,0,0,'N','$minf_usuario')";}
           //echo $sql,"<br>";
		   $resultado=pg_exec($conn,$sql);
         }
      }
     }
}pg_close(); 
if($error==0){?> <iframe src="Det_carga_manual.php?criterio=<?echo $criterio?>" width="950" height="350" scrolling="auto" frameborder="1"></iframe> <?} else{ echo $error;}?>
