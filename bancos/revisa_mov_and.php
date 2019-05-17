<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");   error_reporting(E_ALL);
echo "ESPERE POR FAVOR REVISANDO MOVIMIENTOS....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");

$sql="select * from con002 where tipo_asiento='AND' and substring(referencia,2,7)||substring(tipo_comp,2,4)||tipo_asiento not in (SELECT substring(referencia,2,7)||cod_banco||tipo_mov_libro from ban004 WHERE tipo_mov_libro='AND') and fecha='2010-09-17'  order by fecha"; $res=pg_query($sql);
$tabla="<table>";
while($reg=pg_fetch_array($res)){ 
  $referencia=$reg["referencia"]; $fecha=$reg["fecha"];  $tipo_asiento=$reg["tipo_asiento"]; $tipo_comp=$reg["tipo_comp"]; $descripcion=$reg["descripcion"];   $inf_usuario=$reg["inf_usuario"];

  $cod_banco=substr($tipo_comp,1,4); $tipo_mov=$tipo_asiento; $tipo_busca='NDB'; $ref_busca=substr($referencia,1,7);
  $sSQL="select * from ban004 where cod_banco='$cod_banco' and substring(referencia,2,7)='$ref_busca' and tipo_mov_libro='$tipo_busca' and fecha_mov_libro='$fecha'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); 
  if($filas==1){ $registro=pg_fetch_array($resultado,0);  $monto=$registro["monto_mov_libro"];  $ced_rif=$registro["ced_rif"];  $ref_mov=$registro["referencia"]; $referenciaa=$registro["referenciaa"]; $fecha_anulado=$fecha; $AOperacion="03"; $DOperacion="1"; $us_sia="";
  
     $tabla.="<tr><td>".$cod_banco."</td><td>".$referencia."</td><td>".$tipo_mov."</td><td>".$fecha."</td><td>".$fecha_anulado."</td><td>".$monto."</td></tr>"; 
	 
    $sSQL="UPDATE ban004 set anulado='S',fecha_anulado='$fecha' where cod_banco='$cod_banco' and referencia='$ref_mov' and tipo_mov_libro='$tipo_busca'";
    $resultado=pg_exec($conn,$sSQL);
    $sSQL="INSERT INTO ban004(cod_banco,referencia,tipo_mov_libro,ced_rif,fecha_mov_libro,referenciaa,cod_bancoa,anulado,fecha_anulado,monto_mov_libro,mes_conciliacion,aoperacion,doperacion,status,por_emision,aprobado,nro_expediente,usuario_sia,inf_usuario,descrip_mov_libro) 
      VALUES ('".$cod_banco."','".$ref_mov."','".$tipo_asiento."','".$ced_rif."','".$fecha_anulado."','".$referenciaa."','".$cod_banco."','S','".$fecha_anulado."',".$monto.",'00','".$AOperacion."','".$DOperacion."','N','N','N','','".$us_sia."','".$inf_usuario."','".$descripcion."')" ;
    echo $sSQL,"<br>";
	$resultado=pg_exec($conn,$sSQL);
  }
}


$sql="select * from con002 where tipo_asiento='ANC' and substring(referencia,2,7)||substring(tipo_comp,2,4)||tipo_asiento not in (SELECT substring(referencia,2,7)||cod_banco||tipo_mov_libro from ban004 WHERE tipo_mov_libro='ANC') and fecha='2010-09-17'  order by fecha"; $res=pg_query($sql);
$tabla="<table>";
while($reg=pg_fetch_array($res)){ 
  $referencia=$reg["referencia"]; $fecha=$reg["fecha"];  $tipo_asiento=$reg["tipo_asiento"]; $tipo_comp=$reg["tipo_comp"]; $descripcion=$reg["descripcion"];   $inf_usuario=$reg["inf_usuario"];

  $cod_banco=substr($tipo_comp,1,4); $tipo_mov=$tipo_asiento; $tipo_busca='DEP'; $ref_busca=substr($referencia,1,7);
  $sSQL="select * from ban004 where cod_banco='$cod_banco' and substring(referencia,2,7)='$ref_busca' and tipo_mov_libro='$tipo_busca' and fecha_mov_libro='$fecha'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); 
  if($filas==1){ $registro=pg_fetch_array($resultado,0);  $monto=$registro["monto_mov_libro"];  $ced_rif=$registro["ced_rif"];  $ref_mov=$registro["referencia"]; $referenciaa=$registro["referenciaa"]; $fecha_anulado=$fecha; $AOperacion="03"; $DOperacion="1"; $us_sia="";
  
     $tabla.="<tr><td>".$cod_banco."</td><td>".$referencia."</td><td>".$tipo_mov."</td><td>".$fecha."</td><td>".$fecha_anulado."</td><td>".$monto."</td></tr>"; 
	 
    $sSQL="UPDATE ban004 set anulado='S',fecha_anulado='$fecha' where cod_banco='$cod_banco' and referencia='$ref_mov' and tipo_mov_libro='$tipo_busca'";
    $resultado=pg_exec($conn,$sSQL);
	echo $sSQL,"<br>";
    $sSQL="INSERT INTO ban004(cod_banco,referencia,tipo_mov_libro,ced_rif,fecha_mov_libro,referenciaa,cod_bancoa,anulado,fecha_anulado,monto_mov_libro,mes_conciliacion,aoperacion,doperacion,status,por_emision,aprobado,nro_expediente,usuario_sia,inf_usuario,descrip_mov_libro) 
      VALUES ('".$cod_banco."','".$ref_mov."','".$tipo_asiento."','".$ced_rif."','".$fecha_anulado."','".$referenciaa."','".$cod_banco."','S','".$fecha_anulado."',".$monto.",'00','".$AOperacion."','".$DOperacion."','N','N','N','','".$us_sia."','".$inf_usuario."','".$descripcion."')" ;
    $resultado=pg_exec($conn,$sSQL);
	echo $sSQL,"<br>";
  }
}

$tabla.="</table>";
echo $tabla;

pg_close(); error_reporting(E_ALL ^ E_WARNING); 
?>