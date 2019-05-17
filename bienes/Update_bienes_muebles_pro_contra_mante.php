<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_bien_mue=$_POST["txtcod_bien_mue"];
$ced_rif_proveedor=$_POST["txtced_rif_proveedor"]; 
$numero_contrato=$_POST["txtnumero_contrato"]; 
$fecha_contrato=$_POST["txtfecha_contrato"];    
$fecha_desde=$_POST["txtfecha_desde"]; 
$fecha_hasta=$_POST["txtfecha_hasta"]; 
$monto_contrato=$_POST["txtmonto_contrato"]; 
$observacion=$_POST["txtobservacion"]; 
$url="Act_bienes_muebles_pro_contra_mante.php"; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN019 WHERE cod_bien_mue='$cod_bien_mue'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL INMUEBLE NO EXISTE');</script> <? }
   else{$error=1;$sfecha=formato_aaaammdd($fecha_contrato);$fecha_d=formato_aaaammdd($fecha_desde);$fecha_h=formato_aaaammdd($fecha_hasta);$resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN019(2,'$cod_bien_mue', '$ced_rif_proveedor', '$numero_contrato', '$sfecha', '$fecha_d', '$fecha_h', '$monto_contrato', '$observacion')");$error=pg_errormessage($conn); $error=substr($error,0,91);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? } else{ ?> <script language="JavaScript"> muestra('MODIFICO EXITOSAMENTE'); </script><? $error=0; }
  }
}
pg_close();?> <script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>
