<?include ("../class/conect.php");  include ("../class/funciones.php");    error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"]; $agregar=$_POST["txtagregar"]; $tipo_retencion=$_POST["txttipo_retencion"]; $tipo_operacion=$_POST["txttipo_operacion"]; $nro_orden=$_POST["txtnro_orden"];
$tipo_documento=$_POST["txtdocumento"]; $fecha_factura=$_POST["txtfecha_doc"]; $nro_fact=$_POST["txtnro_factura"]; $nro_con_factura=$_POST["txtnro_con_factura"];
$nro_ncr=$_POST["txtnro_nota_c"]; $nro_ndb=$_POST["txtnro_nota_d"]; if($tipo_documento=="01"){$nro_documento=$nro_fact;}if($tipo_documento=="02"){$nro_documento=$nro_ndb;} if($tipo_documento=="03"){$nro_documento=$nro_ncr;}
$nro_planilla=$_POST["txttipo_trans"]; $nro_doc_afectado=$_POST["txtnro_doc_afectado"]; $tipo_planilla=$_POST["txttipo_planilla"];
$monto_pago=$_POST["txtmonto"]; $monto_objeto=$_POST["txtmontob"]; $monto1=$_POST["txtmontos"]; $tasa_retencion=$_POST["txttasa"]; $monto2=$_POST["txtmontoi"];
$monto_retencion=$_POST["txtmontor"];$monto3=$_POST["txtretenc"]; $tipo_en=$_POST["txttipo_en"];
$fecha=asigna_fecha_hoy(); $ced_rif=$_POST["txtced_rif"]; $fecha_emision=formato_aaaammdd($fecha);  $nro_comprobante="";    
$tasa_retencion=formato_numero($tasa_retencion);if(is_numeric($tasa_retencion)){$tasa_retencion=$tasa_retencion;} else{$tasa_retencion=0;}
$monto_pago=formato_numero($monto_pago);if(is_numeric($monto_pago)){$monto_pago=$monto_pago;} else{$monto_pago=0;}
$monto_objeto=formato_numero($monto_objeto);if(is_numeric($monto_objeto)){$monto_objeto=$monto_objeto;} else{$monto_objeto=0;}
$monto_retencion=formato_numero($monto_retencion);if(is_numeric($monto_retencion)){$monto_retencion=$monto_retencion;} else{$monto_retencion=0;}
$monto1=formato_numero($monto1);if(is_numeric($monto1)){$monto1=$monto1;} else{$monto1=0;}
$monto2=formato_numero($monto2);if(is_numeric($monto2)){$monto2=$monto2;} else{$monto2=0;}
$monto3=formato_numero($monto3);if(is_numeric($monto3)){$monto3=$monto3;} else{$monto2=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $url="Det_inc_libro_comp.php?codigo_mov=".$codigo_mov."&agregar=".$agregar;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $num_opcion=1;   $error=0; $tmonto_r=$monto_retencion; if($tmonto_r<0){ $tmonto_r=$tmonto_r*-1; } 
    $tmonto2=$monto2; if($tmonto2<0){ $tmonto2=$tmonto2*-1; }
    if(($tmonto_r>$tmonto2)){  echo $tmonto_r." ".$tmonto2; $error=1; ?> <script language="JavaScript"> muestra('MONTO DE RETENCION INVALIDO');</script><? }
    if($error==0){
      $sSQL="SELECT codigo_mov,ced_rif,fecha_emision,monto_pago,cod_banco,tipo_mov,referencia,tipo_planilla,nro_comprobante  FROM BAN029 WHERE codigo_mov='$codigo_mov' and tipo_retencion='$tipo_retencion' and nro_orden='$nro_orden'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
      if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('ERROR LOCALIZANO FACTURA DEL COMPROBANTE');</script><? }
      else{ $registro=pg_fetch_array($resultado); $cod_banco=$registro["cod_banco"]; $tipo_mov=$registro["tipo_mov"]; $referencia=$registro["referencia"]; $fechae=$registro["fecha_emision"]; $tipo_planilla=$registro["tipo_planilla"]; $nro_comp=$registro["nro_comprobante"];}
    }
    if (checkData($fecha_factura)=='1'){$error=$error;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA FACTURA NO ES VALIDA');</script><? }
    if($error==0){$sfechaf=formato_aaaammdd($fecha_factura);
      $sSQL="SELECT MODIFICA_BAN029('$codigo_mov','$cod_banco','$tipo_mov','$referencia','$tipo_planilla','$nro_planilla','$ced_rif','$fechae','$nro_orden','$nro_orden','A','$tipo_retencion','$tipo_documento','$nro_documento','$nro_con_factura','$nro_doc_afectado','$sfechaf','$nro_comp','$tipo_en',$monto_pago,$monto_objeto,$tasa_retencion,$monto_retencion,$monto1,$monto2,$monto3)";
      $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    }
}pg_close(); error_reporting(E_ALL ^ E_WARNING); if ($error==0){?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script><? } else {?>  <script language="JavaScript">history.back();</script> <? }?>