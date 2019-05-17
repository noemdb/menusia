<?php include ("../class/conect.php");  include ("../class/funciones.php"); error_reporting(E_ALL); $fecha_hoy=asigna_fecha_hoy();
if (!$_GET){ $referencia_dife='';$tipo_diferido='';  } else {$referencia_dife=$_GET["txtreferencia_dife"]; $tipo_diferido=$_GET["txttipo_diferido"];}
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR COPIANDO....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from pre023 WHERE referencia_dife='$referencia_dife' and tipo_diferido='$tipo_diferido'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE DIFERIDO NO EXISTE');</script><?}
   else{ $registro=pg_fetch_array($resultado);   $fecha_diferido=$registro["fecha_diferido"]; $total=0; $desc_cod="";  $cod_busca="PRE023".$usuario_sia; 
	 $sfecha=$fecha_diferido;   $resultado=pg_exec($conn,"SELECT COPIA_PRE023('$cod_busca','$referencia_dife','$tipo_diferido')"); $error=pg_errormessage($conn);$error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }else{?><script language="JavaScript">muestra('COPIO EXITOSAMENTE');</script><?}
  }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING);?> <script language="JavaScript"> window.close(); window.opener.location.reload(); </script>
