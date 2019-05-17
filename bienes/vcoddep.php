<?php include ("../class/conect.php");  include ("../class/funciones.php"); $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"]; $des_tipo_orden=""; $tipo_ord=""; $tipo_caus=""; $cod_contable_o="";
$cod_cont=$_GET["cod_cont"];$cedrif=$_GET["cedrif"];$codigo_mov=$_GET["codigo_mov"]; $nro_orden=$_GET["norden"]; $tipo_caus=$_GET["tcaus"]; $cod_contable_o=$_GET["ccontab"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select * from pag036 where codigo_mov='$codigo_mov'";$resultado=pg_query($StrSQL);$filas=pg_num_rows($resultado); 
if($filas==0){ $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(1,'$codigo_mov','$nro_orden','$tipo_caus','$cedrif','$tipo_ord','$cod_contable_o','NO')"); }
else{ $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(2,'$codigo_mov','$nro_orden','$tipo_caus','$cedrif','$tipo_ord','$cod_contable_o','NO')"); }
pg_close();?>C&Oacute;DIGO DEPENDENCIA :