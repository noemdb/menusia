<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");   error_reporting(E_ALL);
$cod_banco="0005";
echo "ESPERE POR FAVOR REVISANDO ANULADOS....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
//cod_banco='$cod_banco' and
$sql="select * from ban004 where cod_banco='$cod_banco' and anulado='S' and tipo_mov_libro<>'ANU' and tipo_mov_libro<>'ANC' and tipo_mov_libro<>'AND' order by cod_banco,referencia,tipo_mov_libro";  $res=pg_query($sql);
//echo $sql,"<br>";

$tabla="<table>";
while($reg=pg_fetch_array($res)){ $cod_banco=$reg["cod_banco"]; $tipo_mov=$reg["tipo_mov_libro"]; $referencia=$reg["referencia"]; $fecha=$reg["fecha_mov_libro"];  $monto_mov_libro=$reg["monto_mov_libro"]; $monto=$reg["monto_mov_libro"]; $montoc=$reg["monto_mov_libro"];
  $descripcion=$reg["descrip_mov_libro"];  $ced_rif=$reg["ced_rif"]; $inf_usuario=$reg["inf_usuario"]; $referenciaa=$reg["referenciaa"];
  $fecha_anulado=$reg["fecha_anulado"]; $fecha_anulado=formato_ddmmaaaa($fecha_anulado); $monto_mov_libro=formato_monto($monto_mov_libro); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}  $monto=cambia_punto_comas($monto);
  $sSQL="select * from ban003 where tipo_movimiento='$tipo_mov'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;} else{$registro=pg_fetch_array($resultado,0); $tipodc=$registro["tipo"];}
  if($tipodc=="C"){$tipodca="D";$tipo_mova="AND";$AOperacion="03";if($tipo_mov=="CHQ"){$AOperacion="02";$tipo_mova="ANU";}}else{$tipodca="C";$tipo_mova="ANC";$AOperacion="01";if($tipo_mov=="CHQ"){$AOperacion="02";$tipo_mova="ANU";}}

  $sSQL="select * from ban004 where cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mova'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); 
  if($filas==0){$error=1;  $DOperacion="1";
  //echo "Anulado no existe: ".$cod_banco." ".$referencia." ".$tipo_mov." ".$fecha." ".$monto_mov_libro,"<br>"; 
  $tabla.="<tr><td>".$cod_banco."</td><td>".$referencia."</td><td>".$tipo_mov."</td><td>".$fecha."</td><td>".$fecha_anulado."</td><td>".$monto."</td></tr>"; 
  $ref_comp='A'.substr($referencia,1,7); $tipo_comp='B'.$cod_banco; $sfecha=formato_aaaammdd($fecha_anulado);
  
  $sSQL="select * from con002 where fecha='$sfecha' and referencia='$ref_comp' and tipo_comp='$tipo_comp'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); 
  if($filas>0){  $registro=pg_fetch_array($resultado,0); $descripcion=$registro["descripcion"];   $inf_usuario=$registro["inf_usuario"]; $us_sia="";
    $sSQL="INSERT INTO BAN004(cod_banco,referencia,tipo_mov_libro,ced_rif,fecha_mov_libro,referenciaa,cod_bancoa,anulado,fecha_anulado,monto_mov_libro,mes_conciliacion,aoperacion,doperacion,status,por_emision,aprobado,nro_expediente,usuario_sia,inf_usuario,descrip_mov_libro) 
    VALUES ('".$cod_banco."','".$referencia."','".$tipo_mova."','".$ced_rif."','".$fecha_anulado."','".$referenciaa."','".$cod_banco."','S','".$fecha_anulado."',".$montoc.",'00','".$AOperacion."','".$DOperacion."','N','N','N','','".$us_sia."','".$inf_usuario."','".$descripcion."')" ;
    echo $sSQL,"<br>";
	$resultado=pg_exec($conn,$sSQL);
  }
  
  }
  
}$tabla.="</table>";
echo $tabla;

echo "ESPERE POR FAVOR REVISANDO COMPROBANTES DE MOV. LIBROS....","<br>";
$sql="select * from ban004 where cod_banco='$cod_banco' and tipo_mov_libro<>'ANU' and tipo_mov_libro<>'ANC' and tipo_mov_libro<>'AND' order by cod_banco,fecha_mov_libro,referencia,tipo_mov_libro";  $res=pg_query($sql);
$tabla="<table>";
while($reg=pg_fetch_array($res)){ $cod_banco=$reg["cod_banco"]; $tipo_mov=$reg["tipo_mov_libro"]; $referencia=$reg["referencia"]; $fecha=$reg["fecha_mov_libro"];  $monto_mov_libro=$reg["monto_mov_libro"]; $monto=$reg["monto_mov_libro"]; $montoc=$reg["monto_mov_libro"];
  $descripcion=$reg["descrip_mov_libro"];  $ced_rif=$reg["ced_rif"]; $inf_usuario=$reg["inf_usuario"]; $referenciaa=$reg["referenciaa"]; $cod_bancoa=$reg["cod_bancoa"]; $aprobado=$reg["aprobado"];
  $fecha_anulado=$reg["fecha_anulado"]; $fecha_anulado=formato_ddmmaaaa($fecha_anulado); $monto_mov_libro=formato_monto($monto_mov_libro); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}  $monto=cambia_punto_comas($monto);
  
  $sSQL="select * from ban003 where tipo_movimiento='$tipo_mov'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;} else{$registro=pg_fetch_array($resultado,0); $tipodc=$registro["tipo"];}
  if($tipodc=="C"){$tipodca="D";$tipo_mova="AND";$AOperacion="03";if($tipo_mov=="CHQ"){$AOperacion="02";$tipo_mova="ANU";}}else{$tipodca="C";$tipo_mova="ANC";$AOperacion="01";if($tipo_mov=="CHQ"){$AOperacion="02";$tipo_mova="ANU";}}

  $ref_comp=$referencia; $tipo_comp='B'.$cod_banco; $sfecha=formato_aaaammdd($fecha);
  If(($tipo_mov=="ANU")or($tipo_mov=="ANC")or($tipo_mov=="AND")){$ref_comp='A'.substr($referencia,1,7); $tipo_comp='B'.$cod_banco; $sfecha=formato_aaaammdd($fecha_anulado);}
  if($cod_bancoa=="AJC"){$ref_comp=$referenciaa; $tipo_comp='00000';} IF($tipo_mov=="TRD"){$ref_comp=$referenciaa; $tipo_comp='B'.$cod_bancoa;}
  $sSQL="select * from con002 where fecha='$sfecha' and referencia='$ref_comp' and tipo_comp='$tipo_comp'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); 
  if($filas==0){  $tabla.="<tr><td>".$cod_banco."</td><td>".$referencia."</td><td>".$tipo_mov."</td><td>".$fecha."</td><td>".$referenciaa." ".$cod_bancoa."</td><td>".$monto."</td></tr>"; 
  
  }  
}$tabla.="</table>";
echo $tabla;

pg_close(); error_reporting(E_ALL ^ E_WARNING); 
?>