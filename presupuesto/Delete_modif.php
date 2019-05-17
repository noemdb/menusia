<?include ("../class/seguridad.inc"); include ("../class/conects.php");  include ("../class/funciones.php"); include ("../class/configura.inc");error_reporting(E_ALL);
$referencia_modif=$_GET["txtreferencia_modif"];$tipo_modif=$_GET["txttipo_modif"];$error=0;
echo "ESPERE POR FAVOR MODIFICANDO....","<br>";$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a");
if ($error==0){$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  if ($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA');</script><?}
  if($error==0){ $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U"; if($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNNN";
    if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="05"; $opcion="02-0000025"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
     if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
    }$posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{$error=1;} if($Mcamino{6}=="S"){$error=0;}else{$error=1;} if($error==1){?><script language="JavaScript"> muestra(' NO TIENE DERECHOS PARA EJECUTAR ESTA OPCION'); </script><?}
  }
  $Ssql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($Ssql); $tipo_dife="0001"; $campo572="";
  if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $campo572=trim($registro["campo572"]); if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}}
  $nro_aut=substr($mconf,10,1);$fecha_aut=substr($mconf,11,1);$preg_t=substr($mconf,12,1);  $corr_m=substr($mconf,13,1); $modif_apr=substr($mconf,15,1); if($campo572==""){$campo572="0001";} $tipo_dife=$campo572;
	
 if($error==0){$sSQL="Select referencia_modif,descripcion_modif,fecha_registro from pre009 WHERE referencia_modif='$referencia_modif' and tipo_modif='$tipo_modif'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE LA MODIFICACION NO EXISTE');</script><?}
    else{$registro=pg_fetch_array($resultado,0);  $adescripcion=$registro["descripcion_modif"]; $fecha_registro=$registro["fecha_registro"];}
 }  
 if(($error==0)and($tipo_modif=='1')){ $sSQL="select referencia_comp,tipo_compromiso from pre036 where tipo_imput_presu='C' and ref_imput_presu='$referencia_modif'";
   $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado); if ($filas>0){$error=0; ?><script language="JavaScript">muestra('REFERENCIA DE CREDITO TIENE EJECUCION DE PRESUPUESTO');</script><?} }
 if($error==0){ $total=0;$desc_cod=""; $sql="SELECT * FROM codigos_modif where tipo_modif='$tipo_modif' and referencia_modif='$referencia_modif' order by cod_presup";  $res=pg_query($sql);
     while($registro=pg_fetch_array($res)){$total=$total+$registro["monto"];       $desc_cod=$desc_cod.", CODIGO:".$registro["cod_presup"]." FUENTE:".$registro["fuente_financ"]." MONTO:".$registro["monto"];}
	$sfecha=$fecha_registro;
    $resultado=pg_exec($conn,"SELECT ELIMINA_PRE009('$referencia_modif','$tipo_modif','$tipo_dife')");   $error=pg_errormessage($conn); $error=substr($error,0,91);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
     else{?><script language="JavaScript">muestra('ELIMINO EXITOSAMENTE');</script><?
        $desc_doc="MODIFICACION PRESUPUESTARIA, TIPO:".$tipo_modif.", REFERENCIA:".$referencia_modif.", DESCRIPCION:".$adescripcion.", TOTAL:".$total;  $desc_doc=$desc_doc.$desc_cod;
        $resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('05','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
        $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error;?>');</script><?}}
  }
}
pg_close();error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript">window.close(); window.opener.location.reload();</script>