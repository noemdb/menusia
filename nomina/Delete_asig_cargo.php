<?include ("../class/conect.php");  include ("../class/funciones.php");error_reporting(E_ALL);$fecha=$_GET["fecha"];$codigo_mov=$_GET["codigo_mov"]; $cod_empleado="";
$url="Det_inc_asig_cargo.php?codigo_mov=".$codigo_mov;echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0; $sSQL="Select * from NOM068 WHERE codigo_mov='$codigo_mov' and  fecha_asigna='$fecha'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('ASIGNACION DE CARGO NO EXISTE');</script><? }
   else{$sSQL="SELECT ACTUALIZA_NOM068(3,'$codigo_mov','','$fecha','','','','','','','','',0,0,0,0,0)";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR ELIMINANDO: ".substr($error,0,91); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>