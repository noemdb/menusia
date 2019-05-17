<?include ("../class/conect.php");  include ("../class/funciones.php"); 
if (!$_GET){$cod_presup=""; $cod_fuente="00";$codigo_mov="";$ref_imput_presu="";$ref_comp=""; $tipo_comp="0000";}
 else{  $ref_comp=$_GET["ref_comp"]; $tipo_comp=$_GET["tipo_comp"];$codigo_mov=$_GET["codigo_mov"];}  
 $conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
 if(pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?} 
 $Ssql2="UPDATE PRE026 set monto=monto_presup where codigo_mov='$codigo_mov' and referencia_comp='$ref_comp' and tipo_compromiso='$tipo_comp'";  $resultado=pg_exec($conn,$Ssql2);
 echo $Ssql2,"<br>";
 $Ssql2="UPDATE PRE026 set monto_credito=monto_presup where codigo_mov='$codigo_mov' and referencia_comp='$ref_comp' and tipo_compromiso='$tipo_comp' and tipo_imput_presu='C'";  $resultado=pg_exec($conn,$Ssql2);	  
  echo $Ssql2,"<br>";
 $url="Det_inc_comp_ord.php?codigo_mov=".$codigo_mov;  
?>
<script language="JavaScript">document.location ='<? echo $url; ?>';</script> 