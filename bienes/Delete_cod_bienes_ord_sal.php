<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha=asigna_fecha_hoy();
$cod_bien=$_GET["codigo"]; $codigo_mov=$_GET["codigo_mov"];$url="Det_inc_bienes_ord_salida.php?codigo_mov=".$codigo_mov;
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from BIEN050 WHERE codigo_mov='$codigo_mov' and cod_bien='$cod_bien'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO BIEN NO EXISTE');</script> <? }
   else{ $sfecha=formato_aaaammdd($fecha);
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN050(3,'$codigo_mov','','$sfecha','$cod_bien','','','',1,0,'','',0,0)");   $error=pg_errormessage($conn);  $error=substr($error,0,91);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
