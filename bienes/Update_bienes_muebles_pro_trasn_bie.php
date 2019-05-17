<?include ("../class/conect.php");  include ("../class/funciones.php");
$referencia_transf=$_POST["txtreferencia_transf"];
$fecha_transf=$_POST["txtfecha_transf"];
$tipo_transferencia=$_POST["txttipo_transferencia"];
$descripcion=$_POST["txtdescripcion"];
$cod_empresa_e=$_POST["txtcod_empresa_e"];
$cod_dependencia_e=$_POST["txtcod_dependencia_e"];
$cod_direccion_e=$_POST["txtcod_direccion_e"];
$cod_departamento_e=$_POST["txtcod_departamento_e"];
$cod_empresa_r=$_POST["txtcod_empresa_r"];
$cod_dependencia_r=$_POST["txtcod_dependencia_r"];
$cod_direccion_r=$_POST["txtcod_direccion_r"];
$cod_departamento_r=$_POST["txtcod_departamento_r"];
$ced_responsable=$_POST["txtced_responsable"];
$ced_res_uso=$_POST["txtced_res_uso"];
$nombre_e=$_POST["txtnombre_e"];
$departamento_e=$_POST["txtdepartamento_e"];
$nombre_r=$_POST["txtnombre_r"];
$departamento_r=$_POST["txtdepartamento_r"];
$nombre1=$_POST["txtnombre1"];
$departamento1=$_POST["txtdepartamento1"];
$sfecha=formato_aaaammdd($fecha_transf);
$url="Act_bienes_muebles_pro_trasn_bie.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from bien036 WHERE referencia_transf='$referencia_transf'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE LA REFERENCIA NO EXISTE');</script> <? }
   else{$error=1;$resultado=pg_exec($conn,"SELECT MODIFICA_BIEN036('$referencia_transf','$fecha_transf','$tipo_transferencia','$descripcion','$cod_empresa_e','$cod_dependencia_e','$cod_direccion_e','$cod_departamento_e','$cod_empresa_r','$cod_dependencia_r','$cod_direccion_r','$cod_departamento_r','$ced_responsable','$ced_res_uso','$nombre_e','$departamento_e','$nombre_r','$departamento_r','$nombre1','$departamento1')");$error=pg_errormessage($conn); $error=substr($error,0,91);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
