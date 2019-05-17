<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo_mov=$_GET["codigo_mov"]; $cedula=$_GET["cedula"];   $fecha_hoy=asigna_fecha_hoy();
$equipo = getenv("COMPUTERNAME"); $MInf_Usuario=$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$url="Det_inc_inf_familiar_e.php?codigo_mov=".$codigo_mov;  $cod_empleado="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $error=0;
if (pg_ErrorMessage($conn)){$error=1; ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $sSQL="Select * from NOM069 WHERE codigo_mov='$codigo_mov' and ci_partida='$cedula'";
  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado); ECHO $sSQL;
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('INFORMACION FAMILIAR NO EXISTE');</script><? }
   else{$sfecha=formato_aaaammdd($fecha_hoy);
      $sSQL="SELECT ACTUALIZA_NOM069(3,'$codigo_mov','$cod_empleado','$cedula','','','$sfecha',0,'')";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR ELIMINANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
  }
}
pg_close(); 
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}

?>