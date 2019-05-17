<?include ("../../class/conect.php");  include ("../../class/funciones.php");
$referencia=$_GET["referencia"];$codigo_mov=$_GET["codigo_mov"]; $fecha=$_GET["fecha"]; $tipo=$_GET["tipo"];
echo "ESPERE POR FAVOR ELIMINANDO....";
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{$sSQL="Select referencia from con018 WHERE codigo_mov='$codigo_mov' and referencia='$referencia' and tipo_asiento='$tipo' and fecha='$fecha'";
  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
  if ($filas==0){?> <script language="JavaScript">  muestra('COMPROBANTE NO LOCALIZADO'); </script>    <? }
   else{ $resultado=pg_exec($conn,"SELECT ELIM_REF_CON018('$codigo_mov','$referencia','$fecha','00000','$tipo')");    $error=pg_errormessage($conn);     $error=substr($error, 0, 61);
     if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }  }
  
}
pg_close();?><script language="JavaScript">document.location ='Det_inc_comp_rpt.php?codigo_mov=<?echo $codigo_mov?>';</script>