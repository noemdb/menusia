<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha=asigna_fecha_hoy();
$cod_bien_mue=$_GET["cod_bien_mue"]; $cod_componente=$_GET["cod_componente"]; $url="Det_componentes_bienes.php?cod_bien_mue=".$cod_bien_mue;
echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;  $fecha=asigna_fecha_hoy();
$des_componente=""; $marca=""; $modelo=""; $serial1=""; $serial2="";$campo_str1=""; $campo_str2=""; $monto1=0; $monto2=0; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$error=0;
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from BIEN053 WHERE cod_componente='$cod_componente' and cod_bien_mue='$cod_bien_mue'";
  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO COMPONENTE NO EXISTE EN EL BIEN');</script> <? }
   else{ $sfecha=formato_aaaammdd($fecha); $sql="SELECT ACTUALIZA_BIEN053(3,'$cod_bien_mue','$cod_componente','$des_componente','$marca','$modelo','$serial1','$serial2','$campo_str1','$campo_str2',$monto1,$monto2)";
     $resultado=pg_exec($conn,$sql);   $error=pg_errormessage($conn);  $error=substr($error,0,91);  
	 if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
