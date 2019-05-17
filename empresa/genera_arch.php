<? include ("../class/conect.php"); include ("../class/fun_numeros.php");
$tipo_formato=$_POST["txttipo_formato"]; $separador=$_POST["txtseparados"]; $inc_encab=$_POST["txtinc_encab"]; $tsql=$_POST["txtsql"];$nombre_tabla=$_POST["txtnombre_tabla"];
$l=strlen($tsql); $valor=""; for ($i=0; $i<strlen($tsql); $i++) {  if (substr($tsql,$i,1)==';') {$valor=$valor."'"; } else { $valor=$valor.substr($tsql,$i,1); }  }
$tsql=str_replace(";","'",$tsql); $l=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if($tipo_formato=="ARCHIVO EXCEL"){
	header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=archivo.xls");	
    ?><table border="0" cellspacing='0' cellpadding='0' align="left"><?	
	$sql=$tsql; $resultado = pg_query($sql) or die('Consulta fallida: ' . pg_last_error() );
    while ($linea = pg_fetch_array($resultado, null, PGSQL_ASSOC)) {  $campos=""; $registro=""; $i=0;
	    if(($inc_encab=="SI")and($l==0)){ $i=0;
		   ?><tr><?
		   foreach ($linea as $valor_col){   ?> <td width="150"><? echo pg_field_name($resultado,$i); ?></td> <?	$i=$i+1; } 
		   ?></tr> <?
		}
		?><tr><?
		foreach ($linea as $valor_col){   ?> <td width="150"><? echo $valor_col; ?></td> <?	 } 
		?></tr> <?
		$l=$l+1;
    }
    pg_free_result($resultado);
	?></table><?
}
if($tipo_formato=="ARCHIVO TXT SEPARADO"){
  $salto="\n";
  header('Content-type: application/txt');
  header('Content-Disposition: attachment; filename="archivo.txt"');     
  $sql=$tsql; $resultado = pg_query($sql) or die('Consulta fallida: ' . pg_last_error(). ' '.$sql);
  while ($linea = pg_fetch_array($resultado, null, PGSQL_ASSOC)) { $campos=""; $registro=""; $i=0;
		foreach ($linea as $valor_col){  if($i<>0){$campos=$campos.$separador; $registro=$registro.$separador;}
			$campos=$campos.$valor_col; $registro=$registro."".pg_field_name($resultado,$i)."";  $i=$i+1; }
	    if(($inc_encab=="SI")and($l==0)){ echo $registro.$salto;  }				
	    echo $campos.$salto;
		$l=$l+1;
  }
  pg_free_result($resultado);
}
if($tipo_formato=="ARCHIVO SQL"){
  header('Content-type: application/txt');
  header('Content-Disposition: attachment; filename="archivo.sql"'); 
  $salto="\n";  //echo $tsql.";".$salto;
  $sql=$tsql; $resultado = pg_query($sql) or die('Consulta fallida: ' . pg_last_error());
  while ($linea = pg_fetch_array($resultado, null, PGSQL_ASSOC)) {  $campos=""; $registro=""; $i=0;
		foreach ($linea as $valor_col){  if($i<>0){$campos=$campos.",";$registro=$registro.",";}
			$campos=$campos."'".$valor_col."'"; $registro=$registro."".pg_field_name($resultado,$i)."";  $i=$i+1; }
	   echo "insert into ".$nombre_tabla." (".$registro.") ";  echo " values (".$campos.");".$salto;
  }
  pg_free_result($resultado); 
}	
pg_close();
?>