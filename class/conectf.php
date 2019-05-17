<?php session_start();
if($_SESSION["usuario"]!=""){$user=$_SESSION["usuario"];}else{$user="usia";}
if($_SESSION["usr_password"]!=""){$password=$_SESSION["usr_password"];}else{$password="super";}
if($_SESSION["bdatos"]!=""){$dbname=$_SESSION["bdatos"];}else{$dbname="DATFACT";}
if($_SESSION["user_sia"]!=""){$usuario_sia=$_SESSION["user_sia"];}else{$usuario_sia="";}
if($_SESSION["gnom"]!=""){$gnomina=$_SESSION["gnom"];}else{$gnomina="";}
if($_SESSION["bdata"]!=""){$dbdatos=$_SESSION["bdata"];}else{$dbdatos="DATOS";}
//$user="usia";$password="super";$dbname="DATOS";$usuario_sia="";
$port=5432;$host="localhost";
?>