<?php include ("../class/conect.php");  include ("../class/funciones.php"); $codigo_mov=$_GET["codigo_mov"]; $cod_banco=$_GET["cod_banco"]; $cedrif=$_GET["cedrif"];  $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$resultado=pg_exec($conn,"SELECT INCLUYE_BAN030(1,'$codigo_mov','$cod_banco','00000000','0001','2014-01-01','2014-01-01','2014-01-01','N','N','$cedrif','',0,0,'')");
pg_close();?>REFERENCIA  :