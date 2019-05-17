<?include ("../class/conect.php");  include ("../class/funciones.php"); include("../class/configura.inc");error_reporting(E_ALL);
$criterio=$_GET["criterio"]; $nro_comprobante=substr($criterio,6,8);  $ano_fiscal=substr($criterio,0,4);  $mes_fiscal=substr($criterio,4,2);
echo "ESPERE POR FAVOR ANULANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0;   $Nom_Emp=busca_conf();
  $sql="Select campo502,campo503 from SIA005 where campo501='01'"; $resultado=pg_query($sql);  if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} } 
  if ($error==0){$nmes=$mes_fiscal; if($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE COMPROBANTE MENOR A ULTIMO PERIODO CERRADO');</script><?}}
  if($error==0){ $sql="Select nro_comprobante from BAN027 where ano_fiscal='$ano_fiscal' and  mes_fiscal='$mes_fiscal' and nro_comprobante='$nro_comprobante'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
   if ($filas==0){$error=1; echo $sql; ?> <script language="JavaScript"> muestra('NUMERO DE COMPROBANTE NO EXISTE');</script><? }
    else{$sSQL="SELECT ANULA_BAN027('$ano_fiscal','$mes_fiscal','$nro_comprobante')";  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error="ERROR ELIMINANDO: ".substr($error,0,91);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{?><script language="JavaScript">muestra('ANULO EXITOSAMENTE');</script><?}
    } }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>