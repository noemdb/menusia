<?include ("../class/conect.php");  include ("../class/funciones.php"); include("../class/configura.inc"); error_reporting(E_ALL);
$codigo_mov=$_GET["codigo_mov"]; $nro_orden=$_GET["orden"];$tipo_ret=$_GET["tipo"];$nro_planilla=$_GET["nro_planilla"];$tipo_planilla=$_GET["planilla"];$tipo_op=$_GET["tipo_op"];
$equipo = getenv("COMPUTERNAME");$MInf_Usuario=$equipo." ".date("d/m/y H:i a");    $url="Det_ret_planillas.php?codigo_mov=".$codigo_mov; echo "ESPERE POR FAVOR ELIMINANDO....","<br>"; $error=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript">   muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$error=0;  $Nom_Emp=busca_conf();
  $sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";  if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN"; 
  if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="01"; $opcion="02-0000018"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);   if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }}
  $posicion=strpos($Mcamino,'S');if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{$error=1;} if($Mcamino{6}=="S"){$error=0;}else{$error=1;}  
   $sql="Select campo502,campo503 from SIA005 where campo501='01'"; $resultado=pg_query($sql);  if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];} } 
  if($error==0){ $sSQL="SELECT * FROM BAN012 WHERE tipo_planilla='$tipo_planilla' and nro_planilla='$nro_planilla'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
    if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NUMERO PLANILLA DE RETENCION NO EXISTE');</script><? }
    else{ $reg=pg_fetch_array($resultado); $cod_banco=$reg["cod_banco"]; $tipo_mov=$reg["tipo_mov"]; $referencia=$reg["referencia"]; $aux_orden=$reg["aux_orden"]; $tipo_retencion=$reg["tipo_retencion"];
     $ced_rif=$reg["ced_rif"]; $fecha_emision=$reg["fecha_emision"]; $monto_pago=$reg["monto_pago"]; $monto_objeto=$reg["monto_objeto"]; $tasa_retencion=$reg["tasa"]; $monto_retencion=$reg["monto_retencion"];
     if($tipo_op=="A"){$num_op=4;}else{$num_op=5;} $fecha=formato_ddmmaaaa($fecha_emision);
	 if ($error==0){$nmes=substr($fecha,3, 2);if ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE PLANILLA MENOR A ULTIMO PERIODO CERRADO');</script><?}}
  } }
  if($error==0){ $sSQL="SELECT ACTUALIZA_BAN012($num_op,'$cod_banco','$tipo_mov','$referencia','$tipo_planilla','$nro_planilla','$ced_rif','$fecha_emision','$nro_orden','$aux_orden','$tipo_retencion','','','','$fecha_emision','','',0,0,0,0,0,0,0,'$MInf_Usuario','$codigo_mov')";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error=substr($error,0,91);   if (!$resultado){ echo $sSQL,"<br>"; ?> <script language="JavaScript"> muestra('<? echo $error; ?>'); </script> <? }
  }
}
pg_close();  error_reporting(E_ALL ^ E_WARNING);?><script language="JavaScript"> LlamarURL('<?echo $url;?>'); </script>