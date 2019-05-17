<?php
if($_SESSION["usuario"]!=""){$user=$usuario;}else{$user="usia";}
if($_SESSION["usr_password"]!=""){$password=$usr_password;}else{$password="super";}
if($_SESSION["bdatos"]!=""){$dbname=$bdatos;}else{$dbname="SIA";}
if($_SESSION["user_sia"]!=""){$usuario_sia=$user_sia;}else{$usuario_sia="";}
//$user="usia";$password="super";$dbname="SIA";$usuario_sia="";
$port=5432;$host="localhost";
?>