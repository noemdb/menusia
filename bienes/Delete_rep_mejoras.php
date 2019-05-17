<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha=asigna_fecha_hoy();
$cod_bien_mue=$_GET["cod_bien_mue"]; $cod_bien_aso=$_GET["cod_bien_aso"]; $url="Det_rep_mejoras.php?cod_bien_mue=".$cod_bien_mue;
echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;  $fecha=asigna_fecha_hoy();
$valor_rep=0; $campo_str1=""; $campo_str2=""; $monto1=0; $monto2=0; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$error=0;
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $sSQL="Select * from BIEN058 WHERE cod_bien_aso='$cod_bien_aso' and cod_bien_mue='$cod_bien_mue'";
  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO REPARACION NO EXISTE EN EL BIEN');</script> <? }
   else{ $sfecha=formato_aaaammdd($fecha);    $sql="SELECT ACTUALIZA_BIEN058(3,'$cod_bien_mue','$cod_bien_aso','$sfecha',$valor_rep,'','',0,0)";
	 $resultado=pg_exec($conn,$sql);   $error=pg_errormessage($conn);  $error=substr($error, 0, 90);   if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>