<?include ("../class/conect.php");  include ("../class/funciones.php");error_reporting(E_ALL);$cod_empleado=$_GET["cod_empleado"];$codigo_mov=$_GET["codigo_mov"];
$url="Det_trab_nom_ext.php?codigo_mov=".$codigo_mov;echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0; $fecha_hoy=asigna_fecha_hoy();  $sfecha=formato_aaaammdd($fecha_hoy);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0;$sSQL="Select * from NOM072 WHERE codigo_mov='$codigo_mov' and cod_empleado='$cod_empleado'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE TRABAJADOR NO LOCALIZADO EN EL CALCULO');</script><? }
   else{$sSQL="SELECT ACTUALIZA_NOM072(3,'$codigo_mov','$cod_empleado','','','','','','$sfecha')";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR ELIMINANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>
