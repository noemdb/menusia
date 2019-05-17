<?php include ("../class/conect.php");  include ("../class/funciones.php"); $password=$_GET["password"]; $user=$_GET["user"];$dbname=$_GET["dbname"]; $pasivo_comp=$_GET["pasivo_comp"];$codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
$StrSQL="select * from pag036 where codigo_mov='$codigo_mov'";  $resultado=pg_query($StrSQL); $filas=pg_num_rows($resultado);
if($filas==0){ $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(1,'$codigo_mov','00000000','0000','','0000','','$pasivo_comp')"); }
else{$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(4,'$codigo_mov','00000000','0000','','0000','','$pasivo_comp')"); }
?><span class="Estilo5">CUENTAS FORMAN PARTE DEL COMPROBANTE:</span> <?pg_close();?>