<?include ("../class/conect.php");  include ("../class/funciones.php");  include("../class/configura.inc"); error_reporting(E_ALL);
$codigo_mov=$_GET["codigo_mov"]; $nro_orden=$_GET["orden"];$tipo_ret=$_GET["tipo"];$nro_planilla=$_GET["nro_planilla"];$tipo_planilla=$_GET["planilla"];
$tipo_documento=$_GET["tipo_d"]; $nro_documento=$_GET["nro_doc"]; $nro_con_factura=$_GET["nro_con_f"];
$monto1=$_GET["monto1"]; $monto2=$_GET["monto2"]; $monto3=0; $tipo_en=$_GET["tipo_en"]; $fecha_factura=$_GET["fecha_f"];
$monto1=formato_numero($monto1);if(is_numeric($monto1)){$monto1=$monto1;} else{$monto1=0;}
$monto2=formato_numero($monto2);if(is_numeric($monto2)){$monto2=$monto2;} else{$monto2=0;}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario=$equipo." ".date("d/m/y H:i a");
$url="Det_ret_planillas.php?codigo_mov=".$codigo_mov; echo "ESPERE POR FAVOR MODIFICANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{ $error=0;  $Nom_Emp=busca_conf();
  $sql="Select campo502,campo503 from SIA005 where campo501='01'"; $resultado=pg_query($sql);  if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} } 
  if (checkData($fecha_factura)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA FACTURA NO ES VALIDA');</script><? }
  if($error==0){ $sfechaf=formato_aaaammdd($fecha_factura);
    $sSQL="SELECT * FROM BAN012 WHERE tipo_planilla='$tipo_planilla' and nro_planilla='$nro_planilla'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
    if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NÚMERO PLANILLA DE RETENCIÓN NO EXISTE');</script><? }
    else{ $reg=pg_fetch_array($resultado); $cod_banco=$reg["cod_banco"]; $tipo_mov=$reg["tipo_mov"]; $referencia=$reg["referencia"]; $aux_orden=$reg["aux_orden"]; $tipo_retencion=$reg["tipo_retencion"];
     $ced_rif=$reg["ced_rif"]; $fecha_emision=$reg["fecha_emision"]; $monto_pago=$reg["monto_pago"]; $monto_objeto=$reg["monto_objeto"]; $tasa_retencion=$reg["tasa"]; $monto_retencion=$reg["monto_retencion"]; $fecha=formato_ddmmaaaa($fecha_emision);
  } } 
  if ($error==0){$nmes=substr($fecha,3, 2);if ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE PLANILLA MENOR A ULTIMO PERIODO CERRADO');</script><?}}
  if($error==0){    
	 $sSQL="SELECT ACTUALIZA_BAN012(3,'$cod_banco','$tipo_mov','$referencia','$tipo_planilla','$nro_planilla','$ced_rif','$fecha_emision','$nro_orden','$aux_orden','$tipo_retencion','$tipo_documento','$nro_documento','$nro_con_factura','$sfechaf','','$tipo_en',$monto_pago,$monto_objeto,$tasa_retencion,$monto_retencion,$monto1,$monto2,$monto3,'$MInf_Usuario','$codigo_mov')";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
     if (!$resultado){?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>