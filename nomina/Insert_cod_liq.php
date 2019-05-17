<?include ("../class/conect.php");  include ("../class/funciones.php"); $fecha=asigna_fecha_hoy();
$codigo_mov=$_POST["txtcodigo_mov"]; $cod_concepto=$_POST["txtcod_concepto"];  $den_concepto=$_POST["txtdenominacion"]; $asig_ded_apo=$_POST["txtasig_ded_apo"];
$cantidad=$_POST["txtcantidad"]; $costo=$_POST["txtcosto"]; $fecha_ini=$_POST["txtfecha_ini"]; $fecha_hasta=$_POST["txtfecha_hasta"];
$cantidad=formato_numero($cantidad); if(is_numeric($cantidad)){$cantidad=$cantidad;} else{$cantidad=0;}
$costo=formato_numero($costo); if(is_numeric($costo)){$costo=$costo;} else{$costo=0;}
$total=$cantidad*$costo; $total=round($total,2); $sfecha=formato_aaaammdd($fecha); $tipo_asigna='O'; if(($cod_concepto=="L01")or($cod_concepto=="L02")){ $tipo_asigna='A';}
$equipo = getenv("COMPUTERNAME");$MInf_Usuario = $equipo." ".date("d/m/y H:i a"); $part_iva="403-18-01-00";
echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $url="Det_inc_cal_liq.php?codigo_mov=".$codigo_mov;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $error=0;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{ $sSQL="Select cod_concepto from nom076 WHERE codigo_mov='$codigo_mov' and cod_concepto='$cod_concepto' "; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
  if ($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO CONCEPTO YA EXISTE EN LA LIQUIDACION');</script><? }
  if($error==0){if(checkData($fecha_ini)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA INCIO NO ES VALIDA');</script><?}}
  if($error==0){if(checkData($fecha_hasta)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA HASTA NO ES VALIDA');</script><?}}   
  if($error==0){  $sfechai=formato_aaaammdd($fecha_ini); $sfechah=formato_aaaammdd($fecha_hasta); $cod_presup=""; $cod_contable=""; $afecta_presup=""; $cod_retencion=""; if($asig_ded_apo=="ASIGNACION"){ $asignacion="SI"; $asig_ded_apo="A"; } else { $asignacion="NO"; $asig_ded_apo="D";} 
     $sSQL="SELECT ACTUALIZA_NOM076(1,'$codigo_mov','$cod_concepto','$den_concepto','NO','$asignacion','NO','NO','$tipo_asigna','$asig_ded_apo','0','N','N','N',0,0,0,0,0,0,0,0,0,0,$cantidad,$total,$costo,'$cod_presup','$cod_contable','$afecta_presup','$cod_retencion','$sfechai','$sfecha','$sfechah',1,'000')";  $resultado=pg_exec($conn,$sSQL);$error=pg_errormessage($conn); 
	 $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} echo $sSQL;
   }
}pg_close();  
if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script><?}else{?><script language="JavaScript">history.back();</script><?}
?>
