<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");   error_reporting(E_ALL);
$cod_cuenta="6-1-3-06"; $cod_presup="01-00-53-403-08-02-00"; $cod_fuente="00";
echo "ESPERE POR FAVOR REVISANDO PAGOS PRESUPUESTARIOS....","<br>";
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
//cod_banco='$cod_banco' and
$sql="select * from pre008 where fecha_pago>='2010-10-01' and tipo_pago='0007' and text(tipo_pago)||text(referencia_pago) not in (select text(tipo_pago)||text(referencia_pago) from pre038) order by fecha_pago";  $res=pg_query($sql);
//echo $sql,"<br>";

$tabla="<table>";
while($reg=pg_fetch_array($res)){ $tipo_pago=$reg["tipo_pago"]; $referencia_pago=$reg["referencia_pago"];
  $referencia_caus=$reg["referencia_caus"];  $tipo_causado=$reg["tipo_causado"];
  $referencia_comp=$reg["referencia_comp"];  $tipo_compromiso=$reg["tipo_compromiso"];
  $cod_banco=$reg["cod_banco"];  $fecha=$reg["fecha_pago"];
  
  $sSQL="select * from con003 where referencia='$referencia_pago' and fecha='$fecha' and cod_cuenta='$cod_cuenta'";$resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); 
  if($filas>0){  $reg=pg_fetch_array($resultado,0); $monto=$reg["monto_asiento"];      
	
		   
	$sSQL="INSERT INTO pre038(referencia_pago,tipo_pago,referencia_comp,tipo_compromiso,referencia_caus,tipo_causado,cod_banco,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto,ajustado,amort_anticipo,monto_credito) 
    VALUES ('".$referencia_pago."','".$tipo_pago."','".$referencia_comp."','0000','".$referencia_caus."','0000','".$cod_banco."','".$cod_presup."','".$cod_fuente."','P','00000000',".$monto.",0,0,0)" ;
    $resultado=pg_exec($conn,$sSQL);
	
	$sSQL="INSERT INTO pre037(referencia_caus,tipo_causado,referencia_comp,tipo_compromiso,fecha_causado,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto,pagado,ajustado,amort_anticipo,monto_credito) 
    VALUES ('".$referencia_caus."','0000','".$referencia_comp."','0000','".$fecha."','".$cod_presup."','".$cod_fuente."','P','00000000',".$monto.",0,0,0,0)" ;
    $resultado=pg_exec($conn,$sSQL);
	
	$sSQL="INSERT INTO PRE036 (referencia_comp,tipo_compromiso,cod_comp,fecha_compromiso,cod_presup,fuente_financ,tipo_imput_presu,ref_imput_presu,monto,causado,pagado,ajustado,monto_credito) 
    VALUES ('".$referencia_comp."','0000','".$tipo_pago."','".$fecha."','".$cod_presup."','".$cod_fuente."','P','00000000',".$monto.",0,0,0,0)" ;
    $resultado=pg_exec($conn,$sSQL);
	
	echo $referencia_pago." ".$fecha." ".$monto,"<br>";
	
  }
  
  
}$tabla.="</table>";
echo $tabla;
pg_close(); error_reporting(E_ALL ^ E_WARNING); 
?>