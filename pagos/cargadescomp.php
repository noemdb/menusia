<?php include ("../class/conect.php");  include ("../class/funciones.php");  $password=$_GET["password"]; $user=$_GET["user"]; $todos=$_GET["todos"]; $dbname=$_GET["dbname"];$ced_rif=$_GET["criterio"]; $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $concepto="";
if($todos=="SI"){
$sql="SELECT * FROM pre006 where ced_rif='$ced_rif' and (text(referencia_comp)||text(tipo_compromiso) in (SELECT text(referencia_comp)||text(tipo_compromiso) FROM codigos_compromisos where (monto-causado-ajustado>0) and (tipo_compromiso<>'0000') and (tipo_compromiso<>'A000') and (ced_rif='$ced_rif')) ) ";$res=pg_query($sql); $filas=pg_numrows($res);
if ($filas>0){ $registro=pg_fetch_array($res); $concepto=$registro["descripcion_comp"]; //if ($filas>1){$concepto='';} 
}
}
else{$sql="SELECT * FROM PAG029 where codigo_mov='$codigo_mov' order by nro_factura";$res=pg_query($sql); $filas=pg_numrows($res);
if ($filas>0){ $registro=pg_fetch_array($res); $referencia_comp=$registro["ref_compromiso"];  $tipo_compromiso=$registro["tipo_compromiso"]; 
$sql="SELECT * FROM pre006 where tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'";$res=pg_query($sql); $filas=pg_numrows($res);
if ($filas>0){ $registro=pg_fetch_array($res); $concepto=$registro["descripcion_comp"];  $nro_documento=$registro["nro_documento"];
  if(($tipo_compromiso>="0005")AND ($tipo_compromiso<="0010")){$concepto="CONTRATO NRO.".$nro_documento." ".$registro["descripcion_comp"]; } }
} }
pg_close();
?>
<textarea name="txtconcepto" cols="95" onFocus="encender(this); " onBlur="apagar(this);" class="Estilo10" id="txtconcepto"><?echo $concepto?></textarea>
