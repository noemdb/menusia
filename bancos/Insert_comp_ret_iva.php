<?include ("../class/conect.php");  include ("../class/funciones.php");   error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"]; $ano_fiscal=$_POST["txtano_fiscal"]; $mes_fiscal=$_POST["txtmes_fiscal"]; $nro_comprobante=$_POST["txtnro_comprobante"];
$fecha_emision=$_POST["txtfecha_e"];  $cod_banco=$_POST["txtcod_banco"]; $referencia=$_POST["txtreferencia"]; $tipo_mov=$_POST["txttipo_movimiento"]; $ced_rif=$_POST["txtced_rif"];
if (checkData($fecha_emision)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA DE EMISION NO ES VALIDA');</script><? }
if (($nro_comprobante=="")or(strlen($nro_comprobante)<8)){$error=1; ?> <script language="JavaScript">muestra('NUMERO DE COMPROBANTE NO VALIDO');</script><? }
if (($ano_fiscal=="")or(strlen($ano_fiscal)<4)){$error=1; ?> <script language="JavaScript">muestra('AÑO FISCAL NO VALIDO');</script><? }
if (($mes_fiscal=="")or(strlen($mes_fiscal)<2)){$error=1; ?> <script language="JavaScript">muestra('MES FISCAL NO VALIDO');</script><? }
$mes_f=substr($fecha_emision,3,2); $ano_f=substr($fecha_emision,6,4);
if ($mes_fiscal<>$mes_f){$error=1; ?> <script language="JavaScript">muestra('MES FECHA NO ES IGUAL AL MES FISCAL');</script><? }
if ($ano_fiscal<>$ano_f){$error=1; ?> <script language="JavaScript">muestra('MES FECHA NO ES IGUAL AL MES FISCAL');</script><? }
$equipo = getenv("COMPUTERNAME");$minf_usuario=$equipo." ".date("d/m/y H:i a");
echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $url="Act_comp_ret_iva.php?Gcriterio=U";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
 else{ $num_opcion=1;
    if($error==0){ $sql="Select nro_comprobante from BAN027 where ano_fiscal='$ano_fiscal' and  mes_fiscal='$mes_fiscal' and nro_comprobante='$nro_comprobante'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
      if ($filas>0){$error=1; echo $sql; ?> <script language="JavaScript"> muestra('NUMERO DE COMPROBANTE YA EXISTE');</script><? }
    }
	if($error==0){$sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}}
    $gced_rif=$ced_rif;
	if($error==0){$fecha_emision=formato_aaaammdd($fecha_emision);
      $sql="SELECT * FROM BAN029 where codigo_mov='$codigo_mov' order by tipo_retencion,nro_planilla"; $res=pg_query($sql);
      while($registro=pg_fetch_array($res)){ $tipo_retencion=$registro["tipo_retencion"]; $nro_op=$tipo_retencion*1; $tipo_operacion=$registro["tipo_operacion"]; $tipo_documento=$registro["tipo_documento"]; $sfechaf=$registro["fecha_factura"]; $nro_orden=$registro["nro_orden"]; $ced_rif=$registro["ced_rif"];
          $nro_documento=$registro["nro_documento"];  $nro_con_factura=$registro["nro_con_factura"]; $nro_doc_afectado=$registro["nro_doc_afectado"];  $tipo_transaccion=$registro["nro_planilla"]; $monto=$registro["monto_pago"]; $montob=$registro["monto_objeto"];  $montos=$registro["monto1"];$retenc=$registro["monto3"]; $montoi=$registro["monto2"]; $tasa=$registro["tasa"]; $montor=$registro["monto_retencion"];
          if($ced_rif==""){ $ced_rif=$gced_rif;}
		  $sSQL="SELECT  INCLUYE_BAN027('$ano_fiscal','$mes_fiscal','$nro_comprobante',$nro_op,'$ced_rif','$fecha_emision','$tipo_operacion','$tipo_documento','$sfechaf','$nro_documento','$nro_con_factura','$nro_doc_afectado','$tipo_transaccion',$monto,$montos,$montob,$tasa,$montoi,$retenc,$montor,'$cod_banco','$tipo_mov','$referencia','','$minf_usuario')";     //echo $sSQL;
		  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 91);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } else{?><script language="JavaScript">muestra('GRABO EXITOSAMENTE');</script><?} 
      }
    }
}pg_close(); error_reporting(E_ALL ^ E_WARNING);
if ($error==0){?> <script language="JavaScript">document.location ='<? echo $url; ?>';</script><? } else {?>  <script language="JavaScript">history.back();</script> <? }
 ?>