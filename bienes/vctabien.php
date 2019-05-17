<?php include ("../class/conect.php");  include ("../class/funciones.php"); $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"]; $des_tipo_orden="";$tipo_ord="";
$cod_cont=$_GET["cod_cont"];$cedrif=$_GET["cedrif"];$codigo_mov=$_GET["codigo_mov"]; $nro_orden=$_GET["norden"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select * from pag036 where codigo_mov='$codigo_mov'";$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas==0){ $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(1,'$codigo_mov','$nro_orden','0000','$cedrif','$tipo_ord','$cod_cont','NO')"); }
else{ $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(2,'$codigo_mov','$nro_orden','0000','$cedrif','$tipo_ord','$cod_cont','NO')"); }
pg_close();?>CUENTA CONTABLE :