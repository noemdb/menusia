<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc");   error_reporting(E_ALL);  $error=0; 
$codigo_mov=$_POST["txtcodigo_mov"]; $tipo_planilla=$_POST["txtplanilla"]; $nro_planilla=$_POST["txtnro_planilla"]; $tipo_en=$_POST["txttipo_en"];
$ced_rif=$_POST["txtced_rif"];$tipo_retencion=$_POST["txttipo_retencion"]; $tasa_retencion=$_POST["txttasa"]; $fecha_e=$_POST["txtfecha_e"];
$tasa_retencion=formato_numero($tasa_retencion); if(is_numeric($tasa_retencion)){$tasa_retencion=$tasa_retencion;} else{$tasa_retencion=0;}
$nro_orden="P".substr($nro_planilla,1,7); $aux_orden="00000000"; $fecha_factura=formato_aaaammdd($_POST["txtfecha_e"]); $tipo_documento="FACTURA"; $nro_documento=""; $nro_con_factura="";
$monto_objeto=0; $monto_pago=0; $monto_retencion=0; $monto1=0; $monto2=0; $monto3=0; $nro_comprobante="";
$equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $url="Act_planillas_ret.php?Gcriterio=C".$tipo_planilla.$nro_planilla;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $Nom_Emp=busca_conf();
  $sql="Select campo502,campo503 from SIA005 where campo501='01'"; $resultado=pg_query($sql);  if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} } 
  $sSQL="SELECT codigo FROM BAN011 WHERE codigo='$tipo_planilla'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE PLANILLA NO EXISTE');</script><? }
   else{
    $sSQL="SELECT nro_planilla FROM BAN012 WHERE tipo_planilla='$tipo_planilla' and nro_planilla='$nro_planilla'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
    if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('NUMERO PLANILLA DE RETENCION YA EXISTE');</script><? }
	if($error==0){if (checkData($fecha_e)=='1'){$fecha_emision=formato_aaaammdd($fecha_e);}else{$error=1; ?> <script language="JavaScript">muestra('FECHA EMISION NO ES VALIDA');</script><? }   }
    if($error==0){      
      $sSQL="SELECT * FROM PAG029 where codigo_mov='$codigo_mov' order by campo_str1,nro_factura"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
      while($reg=pg_fetch_array($resultado)){  $fecha_factura=$reg["fecha_factura"];
	    $nro_fact=$reg["nro_factura"]; $nro_con_factura=$reg["nro_con_factura"]; if(is_numeric($nro_fact)){$nro_fact=elimina_ceros($nro_fact);} if(is_numeric($nro_con_factura)){$nro_con_factura=elimina_ceros($nro_con_factura);}
        $tipo_d="FACTURA"; $nro_documento=$nro_documento." ".$nro_fact; $monto=$reg["monto_factura"]; 
	    $monto_pago=$monto_pago+$monto; $monto1=$monto1+$reg["monto_sin_iva"];   $monto2=$monto2+$reg["monto_iva1"];
	    $monto_objeto=$monto_objeto+$reg["monto_iva4_so"]; $monto_retencion=$monto_retencion+$reg["monto_iva3"];
	  }
	}
	if($monto_retencion==0){$error=1; ?> <script language="JavaScript">muestra('MONTO DE PLANILLA INVALIDA');</script><? }
	if (strlen($nro_planilla)==8){$error=$error;} else{$error=1; ?> <script language="JavaScript">muestra('NUMERO DE PLANILLA INVALIDA');</script><? }
	if($error==0){ $nmes=substr($fecha_e,3,2);
      if ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE EMISION MENOR A ULTIMO PERIODO CERRADO');</script><?}
    }
	if($error==0){$sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('CÉDULA/RIF BENEFICIARIO NO EXISTE');</script><?}}
    if($error==0){$sfechaf=$fecha_factura;  
      $sSQL="SELECT ACTUALIZA_BAN012(7,'0000','000','00000000','$tipo_planilla','$nro_planilla','$ced_rif','$fecha_emision','$nro_orden','$aux_orden','$tipo_retencion','$tipo_documento','$nro_documento','$nro_con_factura','$sfechaf','','$tipo_en',$monto_pago,$monto_objeto,$tasa_retencion,$monto_retencion,$monto1,$monto2,$monto3,'$minf_usuario','$codigo_mov')";
      echo $sSQL; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{ ?><script language="JavaScript"> muestra('INCLUYO EXITOSAMENTE');</script><? }
    }
  }
}pg_close(); error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script><? } else {?>  <script language="JavaScript">history.back();</script> <? }
?>