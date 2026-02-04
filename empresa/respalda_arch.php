<?php date_default_timezone_set("America/Caracas"); set_time_limit(0); $tipo_resp=$_POST["txttipo_resp"]; $modulos=$_POST["txtmodulos"]; 
$host=$_POST["txthost"]; $port=$_POST["txtport"]; $password=$_POST["txtpassword"]; $user=$_POST["txtuser"]; $dbname=$_POST["txtdbname"]; 
$presup=substr($modulos,0,1); $contab=substr($modulos,1,1); $bancos=substr($modulos,2,1); $pagos=substr($modulos,3,1);
$compras=substr($modulos,4,1); $ingresos=substr($modulos,5,1); $bienes=substr($modulos,6,1); $nomina=substr($modulos,7,1); $empresa=substr($modulos,8,1);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$dfecha=date("Y-m-d"); $nombre_arh="datos".$dfecha.".sql";  $nombre_arh=$dbname."_".$dfecha.".sql";
$mencoding = pg_client_encoding($conn);
header('Content-type: application/txt');
//header('Content-Disposition: attachment; filename="datos.sql"'); 
header('Content-Disposition: attachment; filename="'.$nombre_arh.'"');
//echo "La codificación del cliente es: ", $mencoding, "\n";
echo "set client_encoding ='".$mencoding."';", "\n";
$salto="\n";
$sqlt="SELECT tablename FROM pg_tables WHERE schemaname = 'public' and substring(tablename,1,4)<>'pga_' order by tablename"; $rest=pg_query($sqlt);
while($regt=pg_fetch_array($rest)){ $nombre_tabla=$regt["tablename"]; $resp=0;
  if($tipo_resp=="TOTAL"){$resp=0;
    if(($nombre_tabla=="pre012")or($nombre_tabla=="pre020")or($nombre_tabla=="pre021")or($nombre_tabla=="pre026")or($nombre_tabla=="pre029")or($nombre_tabla=="pre030")or($nombre_tabla=="pre034")or($nombre_tabla=="pre040")or($nombre_tabla=="pre051")){$resp=1;}
	if(($nombre_tabla=="con008")or($nombre_tabla=="con010")or($nombre_tabla=="con011")or($nombre_tabla=="con013")or($nombre_tabla=="con014")or($nombre_tabla=="con016")or($nombre_tabla=="con017")or($nombre_tabla=="con018")or($nombre_tabla=="con020")or($nombre_tabla=="con021")){$resp=1;}
	if(($nombre_tabla=="ban019")or($nombre_tabla=="ban023")or($nombre_tabla=="ban029")or($nombre_tabla=="ban030")or($nombre_tabla=="ban031")or($nombre_tabla=="ban034")or($nombre_tabla=="ban035")or($nombre_tabla=="ban036")or($nombre_tabla=="ban037")or($nombre_tabla=="ban038")or($nombre_tabla=="ban039")){$resp=1;}
	if(($nombre_tabla=="pag027")or($nombre_tabla=="pag028")or($nombre_tabla=="pag029")or($nombre_tabla=="pag030")or($nombre_tabla=="pag036")or($nombre_tabla=="pag038")or($nombre_tabla=="pag040")or($nombre_tabla=="pag041")or($nombre_tabla=="pag042")or($nombre_tabla=="pag043")or($nombre_tabla=="pag044")or($nombre_tabla=="pag045")or($nombre_tabla=="pag046")){$resp=1;} 
	if(($nombre_tabla=="comp042")or($nombre_tabla=="comp066")or($nombre_tabla=="comp068")or($nombre_tabla=="comp069")or($nombre_tabla=="comp070")){$resp=1;} 
	if(($nombre_tabla=="ingre004")or($nombre_tabla=="ingre021")or($nombre_tabla=="ingre023")){$resp=1;}
	if(($nombre_tabla=="bien050")or($nombre_tabla=="bien056")){$resp=1;} 
	if(($nombre_tabla=="nom016")or($nombre_tabla=="nom065")or($nombre_tabla=="nom066")or($nombre_tabla=="nom076")or($nombre_tabla=="nom065")or($nombre_tabla=="nom090")){$resp=1;}
  } else{ $resp=1; $sufijo=substr($nombre_tabla,0,3); 
    if(($presup=="S")and($sufijo=="pre")){if(($nombre_tabla<>"pre012")and($nombre_tabla<>"pre020")and($nombre_tabla<>"pre021")and($nombre_tabla<>"pre026")and($nombre_tabla<>"pre029")and($nombre_tabla<>"pre030")and($nombre_tabla<>"pre034")and($nombre_tabla<>"pre040")and($nombre_tabla<>"pre051")){$resp=0;}} 
	if(($contab=="S")and($sufijo=="con")){if(($nombre_tabla<>"con008")and($nombre_tabla<>"con010")and($nombre_tabla<>"con011")and($nombre_tabla<>"con013")and($nombre_tabla<>"con014")and($nombre_tabla<>"con016")and($nombre_tabla<>"con017")and($nombre_tabla<>"con018")and($nombre_tabla<>"con020")and($nombre_tabla<>"con021")){$resp=0;} } 
	if(($bancos=="S")and($sufijo=="ban")){if(($nombre_tabla<>"ban019")and($nombre_tabla<>"ban023")and($nombre_tabla<>"ban029")and($nombre_tabla<>"ban030")and($nombre_tabla<>"ban031")and($nombre_tabla<>"ban034")and($nombre_tabla<>"ban035")and($nombre_tabla<>"ban036")and($nombre_tabla<>"ban037")and($nombre_tabla<>"ban038")and($nombre_tabla<>"ban039")){$resp=0;}} 
	if(($pagos=="S")and($sufijo=="pag")){if(($nombre_tabla<>"pag027")and($nombre_tabla<>"pag028")and($nombre_tabla<>"pag029")and($nombre_tabla<>"pag030")and($nombre_tabla<>"pag036")and($nombre_tabla<>"pag038")and($nombre_tabla<>"pag040")and($nombre_tabla<>"pag041")and($nombre_tabla<>"pag042")and($nombre_tabla<>"pag043")and($nombre_tabla<>"pag044")and($nombre_tabla<>"pag045")and($nombre_tabla<>"pag046")){$resp=0;}} 
	if(($compras=="S")and($sufijo=="com")){if(($nombre_tabla<>"comp042")and($nombre_tabla<>"comp066")and($nombre_tabla<>"comp068")and($nombre_tabla<>"comp069")and($nombre_tabla<>"comp070")){$resp=0;}} 
	if(($ingresos=="S")and($sufijo=="ing")){if(($nombre_tabla<>"ingre004")and($nombre_tabla<>"ingre021")and($nombre_tabla<>"ingre023")){$resp=0;}} 
	if(($bienes=="S")and($sufijo=="bie")){if(($nombre_tabla<>"bien050")and($nombre_tabla<>"bien056")){$resp=0;}} 
	//if(($nomina=="S")and($sufijo=="nom")){if(($nombre_tabla<>"nom016")and($nombre_tabla<>"nom011")and($nombre_tabla<>"nom017")and($nombre_tabla<>"nom018")and($nombre_tabla<>"nom019")and($nombre_tabla<>"nom065")and($nombre_tabla<>"nom066")and($nombre_tabla<>"nom076")and($nombre_tabla<>"nom090")){$resp=0;}} 
	if(($nomina=="S")and($sufijo=="nom")){if(($nombre_tabla<>"nom016")and($nombre_tabla<>"nom065")and($nombre_tabla<>"nom066")and($nombre_tabla<>"nom076")and($nombre_tabla<>"nom090")){$resp=0;}} 
	if(($empresa=="S")and($sufijo=="sia")){ if($nombre_tabla<>"sia004"){$resp=0;}  } 
  }
  if($resp==0){
    echo "-- Tabla : ".$nombre_tabla." ".date("d/m/Y g:i:s").$salto;
	echo "Delete from ".$nombre_tabla.";".$salto;
	$sql="select * from ".$nombre_tabla." order by 1"; $resultado = pg_query($sql) or die('Consulta fallida: ' . pg_last_error());
	while ($linea = pg_fetch_array($resultado, null, PGSQL_ASSOC)) {$campos=""; $registro=""; $i=0;
		foreach ($linea as $valor_col){  if($i<>0){$campos=$campos.",";$registro=$registro.",";}
			$campos=$campos."'".$valor_col."'"; $registro=$registro."".pg_field_name($resultado,$i)."";  $i=$i+1; }
	   echo "insert into ".$nombre_tabla." (".$registro.") ";  echo " values (".$campos.");".$salto;}
    pg_free_result($resultado);
  }  
}
pg_free_result($rest);
pg_close();
?>