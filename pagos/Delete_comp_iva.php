<?include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); //error_reporting(E_ALL);
$criterio=$_GET["criterio"]; $nro_comprobante=substr($criterio,6,8);  $ano_fiscal=substr($criterio,0,4);  $mes_fiscal=substr($criterio,4,2);
echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0;  $Nom_Emp=busca_conf();
  $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
  if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="02-0000020"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
   if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
  }$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{$error=1;} if($Mcamino{6}=="S"){$error=0;}else{$error=1;}  
 if($error==1){?><script language="JavaScript"> muestra(' NO TIENE DERECHOS PARA EJECUTAR ESTA OPCION'); </script><?}
  $sql="Select campo502,campo503 from SIA005 where campo501='01'"; $resultado=pg_query($sql);  if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} } 
  if ($error==0){$nmes=$mes_fiscal; if($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE COMPROBANTE MENOR A ULTIMO PERIODO CERRADO');</script><?}}
  if($error==0){ $sql="Select nro_comprobante from BAN027 where ano_fiscal='$ano_fiscal' and  mes_fiscal='$mes_fiscal' and nro_comprobante='$nro_comprobante'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
   if ($filas==0){$error=1; echo $sql; ?> <script language="JavaScript"> muestra('NUMERO DE COMPROBANTE NO EXISTE');</script><? }
    else{$sSQL="SELECT ELIMINA_BAN027('$ano_fiscal','$mes_fiscal','$nro_comprobante')";  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error="ERROR ELIMINANDO: ".substr($error,0,91);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?}
    } }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>