<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc");   error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"]; $ano_fiscal=$_POST["txtano_fiscal"]; $mes_fiscal=$_POST["txtmes_fiscal"]; $nro_comprobante=$_POST["txtnro_comprobante"];$fecha_emision=$_POST["txtfecha_e"];$ced_rif=$_POST["txtced_rif"];
if (checkData($fecha_emision)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE EMISION NO ES VALIDA');</script><? }
if (($nro_comprobante=="")or(strlen($nro_comprobante)<8)){$error=1; ?> <script language="JavaScript">muestra('NUMERO DE COMPROBANTE NO VALIDO');</script><? }
if (($ano_fiscal=="")or(strlen($ano_fiscal)<4)){$error=1; ?> <script language="JavaScript">muestra('A�O FISCAL NO VALIDO');</script><? }
if (($mes_fiscal=="")or(strlen($mes_fiscal)<2)){$error=1; ?> <script language="JavaScript">muestra('MES FISCAL NO VALIDO');</script><? }
$mes_f=substr($fecha_emision,3,2); $ano_f=substr($fecha_emision,6,4);
if ($mes_fiscal<>$mes_f){$error=1; ?> <script language="JavaScript">muestra('MES FECHA NO ES IGUAL AL MES FISCAL');</script><? }
if ($ano_fiscal<>$ano_f){$error=1; ?> <script language="JavaScript">muestra('MES FECHA NO ES IGUAL AL MES FISCAL');</script><? }
$equipo = getenv("COMPUTERNAME");$minf_usuario=$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $url="Act_comp_ret_iva.php?Gcriterio=U";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $Nom_Emp=busca_conf(); $num_opcion=1;
    $campo502="NNNNNNNNNNNNNNNNNNNN";   $sql="Select campo502,campo503 from SIA005 where campo501='01'"; $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} }
    $gen_ord_ret=substr($campo502,0,1); $gen_comp_ret=substr($campo502,1,1); $gen_pre_ret=substr($campo502,2,1); $ant_presup=substr($campo502,14,1);  $fecha_aut=substr($campo502,5,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
    if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} } 
	if($error==0){$sql="Select nro_comprobante from BAN027 where ano_fiscal='$ano_fiscal' and  mes_fiscal='$mes_fiscal' and nro_comprobante='$nro_comprobante'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
      if ($filas>0){$error=1; echo $sql; ?> <script language="JavaScript"> muestra('NUMERO DE COMPROBANTE YA EXISTE');</script><? }
    }	
	if($error==0){$nmes=substr($fecha_emision,3, 2);
       if ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE COMPROBANTE MENOR A ULTIMO PERIODO CERRADO');</script><?}
    }
	if($error==0){$sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}}
    if($error==0){$fecha_emision=formato_aaaammdd($fecha_emision);
      $sql="SELECT * FROM BAN029 where codigo_mov='$codigo_mov' order by tipo_retencion,nro_planilla"; $res=pg_query($sql);
      while($registro=pg_fetch_array($res)){ $tipo_retencion=$registro["tipo_retencion"]; $nro_op=$tipo_retencion*1; $tipo_operacion=$registro["tipo_operacion"]; $tipo_documento=$registro["tipo_documento"]; $sfechaf=$registro["fecha_factura"]; $nro_orden=$registro["nro_orden"]; 
          $nro_documento=$registro["nro_documento"];  $nro_con_factura=$registro["nro_con_factura"]; $nro_doc_afectado=$registro["nro_doc_afectado"];  $tipo_transaccion=$registro["nro_planilla"]; $monto=$registro["monto_pago"]; $montob=$registro["monto_objeto"];  $montos=$registro["monto1"];$retenc=$registro["monto3"]; $montoi=$registro["monto2"]; $tasa=$registro["tasa"]; $montor=$registro["monto_retencion"];
          $sSQL="SELECT  INCLUYE_BAN027('$ano_fiscal','$mes_fiscal','$nro_comprobante',$nro_op,'$ced_rif','$fecha_emision','$tipo_operacion','$tipo_documento','$sfechaf','$nro_documento','$nro_con_factura','$nro_doc_afectado','$tipo_transaccion',$monto,$montos,$montob,$tasa,$montoi,$retenc,$montor,'0000','O/P','$nro_orden','','$minf_usuario')";
          $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error,0,91);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } 
      }
	  if($error==0){?><script language="JavaScript">muestra('GRABO EXITOSAMENTE');</script><?} 
    }
}pg_close(); error_reporting(E_ALL ^ E_WARNING); if ($error==0){?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script><? } else {?>  <script language="JavaScript">history.back();</script> <? }?>