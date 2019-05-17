<?include ("../class/conect.php");  include ("../class/funciones.php");   include ("../class/configura.inc"); error_reporting(E_ALL);
$referencia_dife=$_GET["txtreferencia_dife"]; $tipo_diferido=$_GET["txttipo_diferido"]; $equipo = getenv("COMPUTERNAME");
$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");  echo "ESPERE POR FAVOR ELIMINANDO....","<br>";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{  $Nom_Emp=busca_conf(); $periodom=$SIA_Periodo; $error=0;
  $sSQL="Select * from pre023 WHERE referencia_dife='$referencia_dife' and tipo_diferido='$tipo_diferido'"; $resultado=pg_exec($conn,$sSQL);   $filas=pg_numrows($resultado);
  if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE MOVIMIENTO DIFERIDO NO EXISTE');</script><?}
   else{ $registro=pg_fetch_array($resultado); $fecha_diferido=$registro["fecha_diferido"];   $adescripcion=$registro["descripcion_dife"]; }   
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA');</script><?} 
  if($error==0){ $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"]; $l_cat=strlen($formato_cat); if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}}
  } $periodom=$SIA_Periodo; 
  if($error==0){  $sql="Select * from pre006 WHERE diferido='S' and ref_aep='$referencia_dife' and tipo_documento='$tipo_diferido'"; $resultado=pg_exec($conn,$sql);   $filas=pg_numrows($resultado);
     if ($filas>=1){ $registro=pg_fetch_array($resultado); $ref_comp=$registro["referencia_comp"]; $tipo_comp=$registro["tipo_compromiso"]; $error=1;?><script language="JavaScript">muestra('MOVIMIENTO DIFERIDO TIENE COMPROMISO, REFERENCIA COMPROMISO: <? echo $ref_comp.' '.$tipo_comp; ?> ');</script><?}
  }  
  if($error==0){$nmes=substr($fecha_diferido,5, 2);if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}
  if($periodom>$nmes){echo $periodom.' '.$nmes.' '.$fecha_diferido;$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}}
  if($error==0){ $total=0;$desc_cod="";   $sfecha=$fecha_diferido;
     $sql="Select * from pre033 WHERE referencia_dife='$referencia_dife' and tipo_diferido='$tipo_diferido'";     $res=pg_query($sql);     
     while($registro=pg_fetch_array($res)){ $total=$total+$registro["monto_diferido"];  $desc_cod=$desc_cod.", CODIGO:".$registro["cod_presup"]." FUENTE:".$registro["fuente_financ"]." MONTO:".$registro["monto_diferido"];   }
     $resultado=pg_exec($conn,"SELECT ELIMINA_PRE023('$referencia_dife','$tipo_diferido','$sfecha')"); $merror=pg_errormessage($conn);  $merror=substr($merror,0,91);
     if (!$resultado){$error=1;?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><? }    else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
         $desc_doc="MOV.DIFERIDO: TIPO:".$tipo_diferido.", REFERENCIA:".$referencia_dife.", DESCRIPCION:".$adescripcion.", TOTAL:".$total;   $desc_doc=$desc_doc.$desc_cod;
         $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')"); $merror=pg_errormessage($conn);  $merror=substr($merror,0,91);  if (!$resultado){ $error=1; ?><script language="JavaScript">muestra('<?echo $merror;?>');</script><? }}
  }
}pg_close();?><script language="JavaScript"> window.close(); window.opener.location.reload(); </script>