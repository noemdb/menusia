<?include ("../class/conect.php");  include ("../class/funciones.php");
$referencia=$_POST["txtreferencia"];
$fecha=$_POST["txtfecha"];
$tipo_salida=$_POST["txttipo_salida"];
$cod_dependencia=$_POST["txtcod_dependencia"];
$descripcion=$_POST["txtdescripcion"];
$nombre1=$_POST["txtnombre1"];
$departamento1=$_POST["txtdepartamento1"];
$nombre2=$_POST["txtnombre2"];
$departamento2=$_POST["txtdepartamento2"];
$sfecha=formato_aaaammdd($fecha);
$url="Act_orden_salida_bienes_muebles_pro.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from bien043 WHERE referencia='$referencia'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE LA REFERENCIA NO EXISTE');</script> <? }
   else{$error=1;$resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN043(2,'$referencia','$sfecha','$tipo_salida','$cod_dependencia','$descripcion','$nombre1','$departamento1','$nombre2','$departamento2')");$error=pg_errormessage($conn); $error=substr($error,0,91);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
