<?php include ("../class/conect.php");  include ("../class/funciones.php"); $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];
$monto=$_GET["mmonto"];$codigo_mov=$_GET["codigo_mov"]; if(is_numeric($monto)){$monto=$monto;} else{$monto=0;} 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select * from pag036 where codigo_mov='$codigo_mov'"; $resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas>0){$StrSQL="SELECT UPDATE_PAG036_MONTO(1,'$codigo_mov',$monto,0)";   $resultado=pg_exec($conn,$StrSQL); }
?> MONTO DE LA ORDEN : <? pg_close();?>