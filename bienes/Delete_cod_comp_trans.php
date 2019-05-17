<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha=asigna_fecha_hoy();
$cod_bien=$_GET["codigo"]; $codigo_mov=$_GET["codigo_mov"]; $cod_comp=$_GET["cod_comp"]; $url="Det_inc_trans_comp_bienes.php?codigo_mov=".$codigo_mov;
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";$error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from BIEN050 WHERE codigo_mov='$codigo_mov' and cod_bien='$cod_bien' and campo_str1='$cod_comp'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO COMPONENTE NO EXISTE');</script> <? }
   else{ $sfecha=formato_aaaammdd($fecha);
     $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN050(4,'$codigo_mov','','$sfecha','$cod_bien','','','',1,0,'$cod_comp','',0,0)");   $error=pg_errormessage($conn);  $error=substr($error,0,91);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
