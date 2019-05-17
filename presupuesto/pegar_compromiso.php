<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../presupuesto/Ver_dispon.php"); $codigo_mov=$_GET["codigo_mov"]; include ("../class/configura.inc");
?>
<html>
<head>  <title>PEGAR COMPROMISO</title>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Orden(){ document.form2.submit(); }
</script>
</head>
<body>
<?$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
echo "ESPERE POR FAVOR PEGANDO COMPROMISO.... ","<br>";
$res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");$error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$res=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$mconf="";$Ssql="Select * from SIA005 where campo501='05'";$resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"];}$nro_aut=substr($mconf,1,1); $fecha_aut=substr($mconf,2,1); $aprueba_comp=substr($mconf,15,1);
$nro_aut="N"; $fecha_aut="N";  $fecha_hoy=asigna_fecha_hoy(); $error=0;

$cod_busca="PRE006".$usuario_sia; $referencia_comp="";$tipo_compromiso=""; $descripcion="";$fecha="";$unidad_sol="";$des_unidad_sol="";$nombre_abrev_comp="";$cod_tipo_comp="";$des_tipo_comp="";
$ced_rif="";$nombre="";$fecha_vencim="";$nro_documento="";$num_proyecto="";$des_proyecto="";$func_inv="";$tiene_anticipo="";$tasa_anticipo="";$cod_con_anticipo="";$inf_usuario="";$anulado="";$modulo="";$aprobado="";

$sql="Select * from pre030 Where codigo_mov='$cod_busca'"; $res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>0){$registro=pg_fetch_array($res); $referencia_comp=$registro["referencia_comp"]; $cod_comp=$registro["cod_comp"];
  $fecha=$registro["fecha_compromiso"];  $tipo_compromiso=$registro["tipo_compromiso"]; $descripcion=$registro["descripcion_comp"]; $inf_usuario=$registro["inf_usuario"];
   $unidad_sol=$registro["unidad_sol"];  $cod_tipo_comp=$registro["cod_tipo_comp"];  $ced_rif=$registro["ced_rif"];  $fecha_vencim=$registro["fecha_vencim"];
  $nro_documento=$registro["nro_documento"]; $num_proyecto=$registro["num_proyecto"]; $des_proyecto=""; $func_inv=$registro["func_inv"];
  $tiene_anticipo=$registro["tiene_anticipo"]; $tasa_anticipo=$registro["tasa_anticipo"]; $cod_con_anticipo=$registro["cod_con_anticipo"]; $anulado=$registro["anulado"]; $aprobado=$registro["aprobado"]; $modulo=$registro["modulo"];
}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);} if($tasa_anticipo==0){ $tasa_anticipo=0; }
if($fecha_vencim==""){$fecha_vencim="";}else{$fecha_vencim=formato_ddmmaaaa($fecha_vencim);}
//if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="I"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
if($tiene_anticipo=="S"){$tiene_anticipo="SI";}else{$tiene_anticipo="NO";}
echo $filas." ".$referencia_comp." ".$tipo_compromiso;
$sSQL="Select cod_presup_cat,cod_fuente_cat,denominacion_cat from pre019 WHERE cod_presup_cat='$unidad_sol'";$resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
if ($filas>=1){$registro=pg_fetch_array($resultado); $des_unidad_sol=$registro["denominacion_cat"];}
$sSQL="SELECT ced_rif,nombre from pre099 WHERE ced_rif='$ced_rif'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
if ($filas>=1){$registro=pg_fetch_array($resultado); $nombre=$registro["nombre"];}	
$sSQL="SELECT des_tipo_comp from pre016 WHERE tipo_comp='$cod_tipo_comp'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
if ($filas>=1){$registro=pg_fetch_array($resultado); $des_tipo_comp=$registro["des_tipo_comp"];}
$sSQL="Select nombre_abrev_comp from pre002 WHERE tipo_compromiso='$tipo_compromiso'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
if ($filas>=1){$registro=pg_fetch_array($resultado); $nombre_abrev_comp=$registro["nombre_abrev_comp"]; }
$sql="Select * from pre034 Where codigo_mov='$cod_busca' order by cod_presup,fuente_financ";$res=pg_query($sql); 
while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $ref_imput_presu=$registro["ref_imput_presu"]; 
  $denominacion="";  $monto=$registro["monto"]; $sfecha=$registro["fecha_compromiso"]; $tipo_imput_presu=$registro["tipo_imput_presu"];   $monto_credito=$registro["monto_credito"];  
  $resultado=pg_exec($conn,"SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente_financ','','0000','','0000','','0000','','0000','','','','','','','$sfecha','C','$tipo_imput_presu','$ref_imput_presu','$sfecha',$monto,0,$monto_credito,0)");
}
$resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(1,'$codigo_mov','$referencia_comp','0000','','','$unidad_sol','NO')");
?>
<form name="form2" method="post" action="Inc_compromisos.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
	 <td width="5"><input name="txtdoc_comp" type="hidden" id="txtdoc_comp" value="<?echo $tipo_compromiso?>"></td>
	 <td width="5"><input name="txtabrev_comp" type="hidden" id="txtabrev_comp" value="<?echo $nombre_abrev_comp?>"></td>
     <td width="5"><input name="txtref_comp" type="hidden" id="txtref_comp" value="<?echo $referencia_comp?>"></td>
	 <td width="5"><input name="txtcod_cat" type="hidden" id="txtcod_cat" value="<?echo $unidad_sol?>"></td>
     <td width="5"><input name="txtnomb_cat" type="hidden" id="txtnomb_cat" value="<?echo $des_unidad_sol?>"></td>	 
	 <td width="5"><input name="txttipo_comp" type="hidden" id="txttipo_comp" value="<?echo $cod_tipo_comp ?>"></td>
     <td width="5"><input name="txtdes_tipo_comp" type="hidden" id="txtdes_tipo_comp" value="<?echo $des_tipo_comp?>"></td>
	 <td width="5"><input name="txtfecha_ini" type="hidden" id="txtfecha_ini" value="<?echo $fecha_hoy?>" ></td>
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
     <td width="5"><input name="txtcod_est" type="hidden" id="txtcod_est" value="00000000" ></td>	 
	 <td width="5"><input name="txtced_r" type="hidden" id="txtced_r" value="<?echo $ced_rif ?>"></td>
     <td width="5"><input name="txtnomb_r" type="hidden" id="txtnomb_r" value="<?echo $nombre ?>"></td>
	 <td width="5"><input name="txtconcepto_r" type="hidden" id="txtconcepto_r" value="<?echo $descripcion ?>"></td>
	 <td width="5"><input name="txtfechac" type="hidden" id="txtfechac" value="<?echo $fecha?>"></td>
	 <td width="5"><input name="txtnro_doc" type="hidden" id="txtnro_doc" value="<?echo $nro_documento ?>"></td>
	 <td width="5"><input name="txtfechav" type="hidden" id="txtfechav" value="<?echo $fecha_vencim?>"></td>
	 <td width="5"><input name="txttiene_ant" type="hidden" id="txttiene_ant" value="<?echo $tiene_anticipo?>"></td>
	 <td width="5"><input name="txtfunc_inv" type="hidden" id="txtfunc_inv" value="<?echo $func_inv?>"></td>
	 <td width="5"><input name="txttasa_ant" type="hidden" id="txttasa_ant" value="<?echo $tasa_anticipo?>"></td>
	 <td width="5"><input name="txtcod_cuenta" type="hidden" id="txtcod_cuenta" value="<?echo $cod_con_anticipo?>"></td>
	  <td width="5"><input name="txtcon_est" type="hidden" id="txtcon_est" value="NO"></td>
  </tr>
</table>
</form>
<?

pg_close();
if ($error==0){?><script language="JavaScript">alert('Compromiso Pegado'); Llamar_Inc_Orden();</script> <? }else {?>  <script language="JavaScript">history.back();</script> <? }
?>