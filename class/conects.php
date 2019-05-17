<?php
if($_SESSION["usuario"]!=""){$user=$_SESSION["usuario"];}else{$user="usia";}
if($_SESSION["usr_password"]!=""){$password=$_SESSION["usr_password"];}else{$password="super";}
if($_SESSION["bdatos"]!=""){$dbname=$_SESSION["bdatos"];}else{$dbname="DATOS";}
if($_SESSION["user_sia"]!=""){$usuario_sia=$_SESSION["user_sia"];}else{$usuario_sia="";}
if($_SESSION["gnom"]!=""){$gnomina=$_SESSION["gnom"];}else{$gnomina="";}
// if($_SESSION["options"]!=""){$options=$_SESSION["options"];}else{$gnomina=" options='--client_encoding=UTF8' ";}
$port=5432;$host="localhost";
?>
