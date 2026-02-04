<?php
 /*echo 'hola LARGO';
 phpinfo();
?>

<?
 echo 'hola CORTO';*/
?>

<? $tempresa=$_POST["txtempresa"]; $tclave=$_POST["txtclave"]; $tusuario=$_POST["txtusuario"];  $tusuario=str_replace("-","",$tusuario); $tusuario=str_replace("'","",$tusuario); $tusuario=str_replace(";","",$tusuario);  $tusuario=str_replace("*","",$tusuario);  $tusuario=str_replace("%","",$tusuario); $tusuario=str_replace("[","",$tusuario); $tusuario=str_replace("#","",$tusuario);  $tusuario=str_replace("/","",$tusuario);  $tusuario=str_replace("=","",$tusuario); $tclave=str_replace("/","",$tclave); $tclave=str_replace("-","",$tclave); $tclave=str_replace("'","",$tclave);   $tclave=str_replace(";","",$tclave);  $tclave=str_replace("=","",$tclave);   
$port=5432;$host="localhost";$existdb="N";$user="invsia";$key="0agi6s";$conn = pg_connect("host=".$host." port=".$port." password=".$key." user=".$user." dbname=".$tempresa."");
if (!$conn) { echo "OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS 1","<br>"; }else{ $sql="Select * from SIA000";  $res=pg_query($sql); if ($registro=pg_fetch_array($res,0)){$user=$registro["campo038"];$key=$registro["campo039"];$existdb="S";} pg_close(); }
if($existdb=="S"){$conn = pg_connect("host=".$host." port=".$port." password=".$key." user=".$user." dbname=".$tempresa."");
if (pg_ErrorMessage($conn)) { echo "OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS 2","<br>";}
 else{ $sql="Select * from SIA001 WHERE campo101='$tusuario' and campo102='$tclave'"; $res=pg_query($sql); $filas=pg_num_rows($res); $sql="select busca_sia001('$tusuario','$tclave');"; $res=pg_query($sql);$filas=pg_num_rows($res);
 if ($filas>=1){  $registro=pg_fetch_array($res);$filas=$registro[0]; }
 if ($filas==1){ $sql="Select * from SIA001 WHERE campo101='$tusuario'"; $res=pg_query($sql); $filas=pg_num_rows($res); }
   if ($filas==0){$existdb="N";}else {$registro=pg_fetch_array($res); $tipo_u=$registro["campo103"]; $tgnomina="";
      if($tipo_u=="A"){ $tgnomina="00"; }
	  else{ $modulo="04"; $opcion="04-0000099"; $sql="select campo618 from sia006 where campo601='$tusuario' and campo602='$modulo' and campo603='$opcion'"; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);
           if ($filas>0){$reg=pg_fetch_array($res); if($reg["campo618"]=="S"){$tgnomina="00"; } if($tgnomina==""){ $sql="select nom059.tipo_nomina,nom059.status from nom059 Where (usuario_sia='$tusuario') and (status='SI') "; $res=pg_exec($conn,$sql);$filas=pg_numrows($res);    if ($filas>0){$reg=pg_fetch_array($res); $tgnomina=$reg["tipo_nomina"]; }	}	 }
	  }session_start(); $_SESSION["autentificado"]="SI"; $_SESSION["usuario"]=$user; $_SESSION["usr_password"]=$key;  $_SESSION["user_sia"]=$tusuario; $_SESSION["bdatos"]=$tempresa; $_SESSION["gnom"]=$tgnomina; $existdb="S";}
  // echo $existdb,"<br>";
  if($existdb=="S"){header ("Location: menu.php");}  else { header("Location: index.php?errorusuario=si"); }
 }
pg_close();
}
