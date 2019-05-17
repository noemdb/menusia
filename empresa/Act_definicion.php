<?php include ("../class/conect.php");include ("../class/funciones.php"); $campo034=$_GET["Gdefinicion"];
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{$SQL="SELECT AC_DEFINICION('$campo034')";echo $SQL;$resultado=pg_exec($conn,$SQL); $error=pg_errormessage($conn); $error=substr($error,0,61); if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } }
pg_close();?> <script language="JavaScript">history.back();</script>   
