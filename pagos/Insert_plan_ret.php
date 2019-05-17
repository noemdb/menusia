<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc");   error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"]; $nro_orden=$_POST["txtnro_orden"]; $aux_orden=$_POST["txtaux_orden"];
$tipo_retencion=$_POST["txttipo_retencion"]; $tipo_operacion=$_POST["txttipo_operacion"];
$tasa_retencion=$_POST["txttasa"]; $monto_objeto=$_POST["txtmonto_objeto"]; $monto_retencion=$_POST["txtmonto_retencion"];
$tipo_planilla=$_POST["txtplanilla"]; $nro_planilla=$_POST["txtnro_planilla"]; $fecha_factura=$_POST["txtfecha"]; $tipo_en=$_POST["txttipo_en"];
$tipo_documento=$_POST["txttipo_documento"]; $nro_documento=$_POST["txtnro_documento"]; $nro_con_factura=$_POST["txtnro_con_factura"];
$monto1=$_POST["txtmonto1"]; $monto2=$_POST["txtmonto2"]; $monto3=0;
$fecha=asigna_fecha_hoy(); $ced_rif =""; $fecha_emision=formato_aaaammdd($fecha); $nro_doc_afectado="";  $nro_comprobante=""; $monto_pago=0;
$tasa_retencion=formato_numero($tasa_retencion);if(is_numeric($tasa_retencion)){$tasa_retencion=$tasa_retencion;} else{$tasa_retencion=0;}
$monto_objeto=formato_numero($monto_objeto);if(is_numeric($monto_objeto)){$monto_objeto=$monto_objeto;} else{$monto_objeto=0;}
$monto_retencion=formato_numero($monto_retencion);if(is_numeric($monto_retencion)){$monto_retencion=$monto_retencion;} else{$monto_retencion=0;}
$monto1=formato_numero($monto1);if(is_numeric($monto1)){$monto1=$monto1;} else{$monto1=0;}
$monto2=formato_numero($monto2);if(is_numeric($monto2)){$monto1=$monto2;} else{$monto2=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $url="Det_ret_planillas.php?codigo_mov=".$codigo_mov;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $num_opcion=1;  $error=0;  $Nom_Emp=busca_conf();
  $sql="Select campo502,campo503 from SIA005 where campo501='01'"; $resultado=pg_query($sql);  if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} } 
  $sSQL="SELECT codigo FROM BAN011 WHERE codigo='$tipo_planilla'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('TIPO DE PLANILLA NO EXISTE');</script><? }
   else{
    $sSQL="SELECT nro_planilla FROM BAN012 WHERE tipo_planilla='$tipo_planilla' and nro_planilla='$nro_planilla'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
    if($filas>0){$error=1; echo $sSQL,"<br>"; ?> <script language="JavaScript"> muestra('NUMERO PLANILLA DE RETENCION YA EXISTE');</script><? }
    if($error==0){
      if ($tipo_operacion=="N"){ $tipo_operacion="M";  $num_opcion=2;}
      else{
      $sSQL="SELECT codigo_mov,ced_rif,fecha_emision,monto_pago FROM BAN029 WHERE codigo_mov='$codigo_mov' and tipo_retencion='$tipo_retencion' and nro_orden='$nro_orden'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; echo $sSQL; ?> <script language="JavaScript"> muestra('ERROR LOCALIZANO DETALLE DE PLANILLA');</script><? }
      else{ $reg=pg_fetch_array($resultado); $ced_rif=$reg["ced_rif"]; $fecha_emision=$reg["fecha_emision"]; $monto_pago=$reg["monto_pago"];} }    
      if (checkData($fecha_factura)=='1'){$error=$error;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA FACTURA NO ES VALIDA');</script><? }
    }
	if (strlen($nro_planilla)==8){$error=$error;} else{$error=1; ?> <script language="JavaScript">muestra('NUMERO DE PLANILLA INVALIDA');</script><? }
	if(($error==0)and($nro_planilla=="00000000")){ $error=1; ?> <script language="JavaScript"> muestra('NUMERO PLANILLA DE INVALIDA');</script><?}
	if($error==0){$fecha=formato_ddmmaaaa($fecha_emision); $nmes=substr($fecha,3, 2);
      if ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE EMISION MENOR A ULTIMO PERIODO CERRADO');</script><?}
    }
	if($error==0){$sfechaf=formato_aaaammdd($fecha_factura);   echo $tipo_operacion;
      $sSQL="SELECT ACTUALIZA_BAN012($num_opcion,'0000','O/P','$nro_orden','$tipo_planilla','$nro_planilla','$ced_rif','$fecha_emision','$nro_orden','$aux_orden','$tipo_retencion','$tipo_documento','$nro_documento','$nro_con_factura','$sfechaf','','$tipo_en',$monto_pago,$monto_objeto,$tasa_retencion,$monto_retencion,$monto1,$monto2,$monto3,'$MInf_Usuario','$codigo_mov')";
      echo $sSQL; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    }
  }
}pg_close(); error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script><? } else {?>  <script language="JavaScript">history.back();</script> <? }?>