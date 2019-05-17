<?include ("../class/conect.php");  include ("../class/funciones.php");error_reporting(E_ALL);$cod_concepto=$_GET["cod_concepto"];$cod_arch_banco=$_GET["cod_arch_banco"];
$url="Cat_conceptos_e.php?cod_arch_banco=".$cod_arch_banco."&cod_concepto=&denominacion="; echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0; $fecha_hoy=asigna_fecha_hoy();  $sfecha=formato_aaaammdd($fecha_hoy);
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0;$sSQL="Select * from nom061 WHERE cod_arch_banco='$cod_arch_banco' and cod_concepto='$cod_concepto'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CONCEPTO NO LOCALIZADO EN LA LISTA');</script><? }
   else{$sSQL="SELECT ACTUALIZA_NOM061(3,'$cod_arch_banco','$cod_concepto','','','')";
      $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror="ERROR ELIMINANDO: ".substr($merror, 0, 91); if (!$resultado){$error=1; ?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><? }
  }
}
pg_close(); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}?>
