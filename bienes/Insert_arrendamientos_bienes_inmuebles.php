<?include ("../class/conect.php");  include ("../class/funciones.php");
$cod_bien_inm=$_POST["txtcod_bien_inm"]; 
$ced_arrendatario=$_POST["txtced_arrendatario"]; 
$numero_contrato=$_POST["txtnumero_contrato"]; 
$fecha_contrato=$_POST["txtfecha_contrato"];
$fecha_desde=$_POST["txtfecha_desde"]; 
$fecha_hasta=$_POST["txtfecha_hasta"];
$canon_arr=$_POST["txtcanon_arr"]; 
$garantia_fianza=$_POST["txtgarantia_fianza"];
$observacion=$_POST["txtobservacion"];
echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $sSQL="Select * from BIEN017 WHERE cod_bien_inm='$cod_bien_inm'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('LA CODIGO YA EXISTE'); </script> <? }
   else{ $error=1; $resultado=pg_exec($conn,"SELECT ACTUALIZA_BIEN017(1,'$cod_bien_inm','$ced_arrendatario','$numero_contrato','$fecha_contrato','$fecha_desde','$fecha_hasta','$canon_arr','$garantia_fianza','$observacion')"); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
     if (!$resultado){ ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }else{?><script language="JavaScript">muestra('INCLUYO EXITOSAMENTE');</script><? $error=0; }
  }
}
pg_close(); if ($error==0){?><script language="JavaScript">document.location ='Act_arrendamientos_bienes_inmuebles_pro_arren_bie_inmu.php';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }?>
