<?php include ("../class/conect.php"); include ("../class/funciones.php"); $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];
$cod_cat=$_GET["cod_cat"];$codigo_mov=$_GET["codigo_mov"]; $referencia=$_GET["referencia"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$des_tipo_orden="";$cod_cont="";
$StrSQL="select * from pag036 where codigo_mov='$codigo_mov'";$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado);
if($filas==0){ $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(1,'$codigo_mov','$referencia','0000','','','$cod_cat','NO')"); }
else{ $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(2,'$codigo_mov','$referencia','0000','','','$cod_cat','NO')"); }
pg_close();?>