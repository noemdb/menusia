<?include ("../class/conect.php");  include ("../class/funciones.php");
$codigo=$_POST["txtCodigo_Municipio"]; $nombre=$_POST["txtNombre_Municipio"];
$url="Act_municipios_ar.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from PRE093 WHERE cod_municipio='$codigo'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE MUNICIPIO NO EXISTE');</script> <? }
   else{$error=1;$resultado=pg_exec($conn,"SELECT ACTUALIZA_PRE093(2,'$codigo','$nombre')");$error=pg_errormessage($conn); $error=substr($error,0,91);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
