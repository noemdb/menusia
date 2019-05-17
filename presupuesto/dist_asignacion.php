<?include ("../class/conect.php");  include ("../class/funciones.php");
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } 
else{  
  $sql="SELECT cod_presup,cod_fuente,denominacion,cod_contable,status_dist,asignado,disponible,diferido,disp_diferida,func_inv,ord_cord,
       aplicacion,cod_unidad_ejec,fecha_creado,asignado01,asignado02,asignado03,asignado04,asignado05,asignado06,asignado07,asignado08,
       asignado09,asignado10,asignado11,asignado12 FROM pre001 where length(cod_presup)=31 "; $res=pg_query($sql);$numeroRegistros=pg_num_rows($res);
  while($registro=pg_fetch_array($res)){	  
	$cod_presup=$registro["cod_presup"];  $cod_fuente=$registro["cod_fuente"];   $denominacion=$registro["denominacion"];   $cod_contable=$registro["cod_contable"];
    $func_inv=$registro["func_inv"];   $aplicacion=$registro["aplicacion"];    $status_dist=$registro["status_dist"];    $asignado=$registro["asignado"];
    $disponible=$registro["disponible"];   $diferido=$registro["diferido"];   $disp_diferida=$registro["disp_diferida"];
    $asignado01=$registro["asignado01"];  $asignado02=$registro["asignado02"];  $asignado03=$registro["asignado03"];  $asignado04=$registro["asignado04"];
    $asignado05=$registro["asignado05"];  $asignado06=$registro["asignado06"];  $asignado07=$registro["asignado07"];  $asignado08=$registro["asignado08"];
    $asignado09=$registro["asignado09"];  $asignado10=$registro["asignado10"];   $asignado11=$registro["asignado11"];  $asignado12=$registro["asignado12"]; 
	if($asignado==0){$f=0;}else{$f=($asignado/12);$f=FNRTD($f);}
	$asignado01=$f;$asignado02=$f;$asignado03=$f;$asignado04=$f;$asignado05=$f;$asignado06=$f; $asignado07=$f;$asignado08=$f;$asignado09=$f;$asignado10=$f;$asignado11=$f;$asignado12=$f;
    $monto=$asignado01+$asignado02+$asignado03+$asignado04+$asignado05+$asignado06+$asignado07+$asignado08+$asignado09+$asignado10+$asignado11+$asignado12;
    if($monto!=$asignado){ $f=round($f,2); $p=$asignado-$monto; $p=round($p,2); $f=$f+$p; $asignado12=$f; }	
	$asignado01=cambia_coma_numero($asignado01);$asignado02=cambia_coma_numero($asignado02);$asignado03=cambia_coma_numero($asignado03);$asignado04=cambia_coma_numero($asignado04);$asignado05=cambia_coma_numero($asignado05);$asignado06=cambia_coma_numero($asignado06);
    $asignado07=cambia_coma_numero($asignado07);$asignado08=cambia_coma_numero($asignado08);$asignado09=cambia_coma_numero($asignado09);$asignado10=cambia_coma_numero($asignado10);$asignado11=cambia_coma_numero($asignado11);$asignado12=cambia_coma_numero($asignado12);

	$sqlg="update pre001 set asignado01=$asignado01,asignado02=$asignado02,asignado03=$asignado03,asignado04=$asignado04,asignado05=$asignado05,asignado06=$asignado06,asignado07=$asignado07,asignado08=$asignado08,asignado09=$asignado09,asignado10=$asignado10,asignado11=$asignado11,asignado12=$asignado12 WHERE cod_presup='$cod_presup' and cod_fuente='$cod_fuente'"; 	
	$resultado=pg_exec($conn,$sqlg);   $error=pg_errormessage($conn);$error=substr($error, 0, 91); 
  }
  ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? 
  echo " ","<br>";  
}

echo "FINALIZO la actualizacion....","<br>";  
pg_close();
?>