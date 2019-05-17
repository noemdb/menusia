<?php session_start();
if($_SESSION["usuario"]!=""){$user=$_SESSION["usuario"];}else{$user="csia";}
if($_SESSION["usr_password"]!=""){$password=$_SESSION["usr_password"];}else{$password="consulta";}
if($_SESSION["bdatos"]!=""){$dbname=$_SESSION["bdatos"];}else{$dbname="DATOS";}
if($_SESSION["user_sia"]!=""){$usuario_sia=$_SESSION["user_sia"];}else{$usuario_sia="";}
if($_SESSION["gnom"]!=""){$gnomina=$_SESSION["gnom"];}else{$gnomina="";}
//$user="usia";$password="super";$dbname="DATOS";$usuario_sia="";
$port=5432;$host="localhost";
?>