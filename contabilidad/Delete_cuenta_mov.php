<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_cuenta=$_GET["cod_cuenta"];$codigo_mov=$_GET["codigo_mov"]; $nro_linea=$_GET["nro_linea"];
echo "ESPERE POR FAVOR ELIMINANDO....";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?>  <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{
  $sSQL="Select cod_cuenta from con017 WHERE codigo_mov='$codigo_mov' and nro_linea='$nro_linea'";
  $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
  if ($filas==0){?> <script language="JavaScript">  muestra('MOVIMIENTO NO LOCALIZADO'); </script>    <? }
   else{ $resultado=pg_exec($conn,"SELECT ELIM_LINEA_CON017('$codigo_mov','$nro_linea')");    $error=pg_errormessage($conn);     $error=substr($error, 0, 61);
     if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }  }
  
}
pg_close();?><script language="JavaScript">document.location ='Det_inc_mov_comp.php?codigo_mov=<?echo $codigo_mov?>';</script>