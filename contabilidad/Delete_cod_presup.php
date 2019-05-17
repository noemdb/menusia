<?include ("../class/conect.php");  include ("../class/funciones.php"); $equipo=getenv("COMPUTERNAME");
$cod_presup=$_POST["txtcod_presup"];$cod_contab_asoc=$_POST["txtCodigo_Cuenta"]; $url="Act_asoc_activo_hacienda.php";
echo "ESPERE POR FAVOR ELIMINANDO...."; $MInf_Usuario=$equipo." ".date("d/m/y H:i a");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script>  <?}
 else{  $sSQL="Select * from con019 WHERE cod_presup='$cod_presup'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas==0){?> <script language="JavaScript">  muestra('CODIGO PRESUPUESTARIO NO EXISTE'); </script> <? }
   else{ $resultado=pg_exec($conn,"SELECT ACTUALIZA_CON019(3,'$cod_presup','$cod_contab_asoc','','',0,0,'$MInf_Usuario')");
     $error=pg_errormessage($conn);   $error=substr($error,0,91);  if (!$resultado){?><script language="JavaScript">  muestra('<? echo $error; ?>');  </script><? }
      else{  $error=0;  ?><script language="JavaScript"> muestra('ELIMINO EXITOSAMENTE'); </script>  <? }
  }
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? } ?>