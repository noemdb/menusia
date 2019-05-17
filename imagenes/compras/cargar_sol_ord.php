<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../presupuesto/Ver_dispon.php"); 
$codigo_mov=$_GET["txtcodigo_mov"]; $nro_solicitud=$_GET["nro_sol"]; $fecha_hoy=asigna_fecha_hoy();

?>
<html>
<head>  <title>CARGAR SOLICITUD DE SERVICIO EN LA ORDEN DE SREVICIO</title>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Orden(){ document.form2.submit(); }
</script>
</head>
<body>
<?$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
echo "ESPERE POR FAVOR CARGANDO SOLICITUD.... ","<br>";
if ($codigo_mov==""){$codigo_mov="";}else{
 $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $res=pg_exec($conn,"SELECT BORRAR_COMP042('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $res=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
}

$mconf="";$Ssql="Select * from SIA005 where campo501='05'";$resultado=pg_query($Ssql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
if($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
$nro_aut=substr($mconf,1,1); $fecha_aut=substr($mconf,2,1); $aprueba_comp=substr($mconf,15,1); $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+1;
$mconf="";$tipo_ords="0002"; $cod_tipos="000002"; $nomb_a_ordc="O/S"; $cod_imp_unico="S"; $cod_imp_part="S"; $cod_part_iva="403-18-01-00"; $mconf73="";
$Ssql="Select * from SIA005 where campo501='09'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $mconf73=$registro["campo573"]; $tipo_ordc=$registro["campo504"]; $cod_tipoc=$registro["campo507"]; $cod_part_iva=$registro["campo509"]; }
$valida_requis=substr($mconf,1,1); $valida_req_aprobada=substr($mconf,2,1); $nro_aut=substr($mconf,3,1); $fecha_aut=substr($mconf,4,1); $modifc_presup=substr($mconf,7,1); $cod_imp_unico=substr($mconf73,1,1); $cod_imp_part=substr($mconf73,2,1);
$fecha_orden=$fecha_hoy; $unidad_solicitante=""; $tipo_documento=""; $nro_documento=""; $rif_proveedor="";  $inf_canc=""; $nombre_abrev_comp=""; $nombre=""; $des_fuente_financ=""; $concepto="";
$fecha_solicitud=""; $tiempo_entrega=""; $lugar_entrega=""; $direccion_entrega=""; $operacion="C"; $dias_credito="30"; $afecta_presupuesto=""; $fuente_financ=""; $anulado=""; $fecha_anulado=""; $cancelada="";
$fecha_cancelacion=""; $nro_ord_pago=""; $nro_linea=""; $redondeo_total=""; $redondeo_impuesto=""; $aplica_impuesto="S"; $cod_presup_imp=""; $tasa_flete=""; $monto_flete=""; $cod_presup_flete=""; $des_unidad_sol="";
$tasa_otros=""; $monto_otros=""; $cod_presup_otros=""; $tasa_imp1=""; $monto_obj_imp1=""; $cod_presup_imp1=""; $tasa_imp2=""; $monto_obj_imp2=""; $cod_presup_imp2=""; $tasa_imp3=""; $monto_obj_imp3=""; $cod_presup_imp3="";
$status=""; $fecha_vencim=$fecha_hoy; $nro_cod_pre=""; $campo_str1=""; $campo_str2=""; $campo_num1=0; $campo_num2=0; $aprobado=""; $fecha_aprobada=""; $usuario_sia_aprueba=""; $nro_expediente=""; $usuario_sia_ord=""; $inf_usuario="";
$tasa_anticipo=0; $tiene_anticipo="N"; $cod_con_anticipo="";

$sql="Select * from SOLICITUDES  where nro_solicitud='$nro_solicitud'"; $res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>0){$registro=pg_fetch_array($res);
   $nro_solicitud=$registro["nro_solicitud"];   $des_unidad_sol=$registro["denominacion_cat"]; $concepto=$registro["observacion"];
  $fecha_solicitud=$registro["fecha"]; $unidad_solicitante=$registro["unidad_solicitante"];  $nombre_departamento=$registro["nombre_departamento"]; 
  $cod_presup_imp=$unidad_solicitante."-".$cod_part_iva; $lugar_entrega=$nombre_departamento;   
}else{$error=1;  echo "Solicitud de Servicio No Localizada","<br>";} echo $nro_solicitud,"<br>"; 
$cod_iva=$cod_presup_imp; $sfecha=formato_aaaammdd($fecha_orden);
if($fecha_solicitud==""){$fecha_solicitud="";}else{$fecha_solicitud=formato_ddmmaaaa($fecha_solicitud);}

$resultado=pg_exec($conn,"SELECT ACT_PAG036_COMP(1,'$codigo_mov','','0000','$rif_proveedor','','$unidad_solicitante','NO','$aplica_impuesto','N','$cod_presup_imp','',0,0)");


$sql="SELECT * FROM SERV_SOLICITUD  where nro_solicitud='$nro_solicitud' order by nro_linea";$res=pg_query($sql); 
while($registro=pg_fetch_array($res)){ $cod_articulo=$registro["cod_servicio"]; $nro_linea=$registro["nro_linea"];  $des_articulo=$registro["concepto_linea"];
 $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $cantidad=$registro["cantidad"]; $costo=$registro["monto"]; $total=$registro["cantidad"]*$registro["monto"];
 $marca=""; $modelo=""; $unidad_medida=$registro["unidad_medida"]; $impuesto=$registro["tasa_impuesto"]; $total_iva=$registro["total_iva"]; $tasa=$registro["tasa_impuesto"]; $monto_iva=$registro["monto_iva"];
 $partida=$registro["cod_partida"]; $cod_cat=$registro["cod_categoria"];$tipo_imput_presu="P";  $ref_imput_presu="00000000";

$StrSQL="SELECT ACTUALIZA_COMP042(1,'$codigo_mov','$cod_articulo','$ref_imput_presu','0000000000','$nro_linea','','$sfecha','$marca','$modelo','$unidad_medida','$cod_presup','$fuente_financ',$costo,$tasa,0,$monto_iva,$total_iva,$cantidad,0,0,0,$total,0,0,'$tipo_imput_presu','','$sfecha','','','$partida','$cod_cat',0,0,'','$sfecha','','','$des_articulo','')";
$resultado=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} 
//echo $StrSQL,"<br>";
} $fecha=$sfecha;
    $sql="SELECT * FROM comp042 where codigo_mov='$codigo_mov' order by nro_linea";$res=pg_query($sql); $gsub_total=0; $gtotal_iva=0; $gtotal_ord=0; $cant_articulo=0;
	while($registro=pg_fetch_array($res)){ $cod_articulo=$registro["codigo_articulo"]; $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $cant_articulo=$cant_articulo+1;
	  $des_articulo=$registro["des_articulo"]; $unidad=$registro["unidad_medida"]; $nro_linea=$registro["nro_linea"]; $marca=$registro["marca"]; $modelo=$registro["modelo"];
	  $cantidad=$registro["cantidad_ordenada"]; $costo=$registro["costo"]; $total=$registro["total_articulo"]; $total_iva=$registro["total_iva"];
	  $tipo_imput_presu=$registro["cod_almacen"];  $ref_imput_presu=$registro["nro_articulo"]; $tasa=$registro["tasa_impuesto"]; if($aplica_impuesto=="S"){$tasa=$tasa;}else{$tasa=0;} 
	  $gsub_total=$gsub_total+$total; $gtotal_iva=$gtotal_iva+$total_iva; $gtotal_ord=$gtotal_ord+($total_iva+$total);
	  $sSQL="Select cod_servicio from COMP027 WHERE cod_servicio='$cod_articulo'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
      if($filas==0){$error=1; echo "Codigo Servicio:".$cod_articulo; ?> <script language="JavaScript"> muestra('CODIGO DE SERVICIO NO EXISTE');</script><? }  
 	  if($error==0){ $sSQL="Select * from PRE026 WHERE codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ'";
		  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
		  if ($filas>0){ $exist_cod="S"; $reg=pg_fetch_array($resultado); $monto_cod=$reg["monto"]+$total; }
		   else{ $exist_cod="N"; $monto_cod=$total; $nro_cod_pre=$nro_cod_pre+1; } $monto_credito=0;
		  if (verifica_disponibilidad($conn,$cod_presup,$fuente_financ,$fecha,$monto_cod)==0){$error=0;}else{$error=1;} 
		  if(($error==0)and($tipo_imput_presu=="C")){ $monto_credito=$monto_cod;
			$sSQL="Select * from PRE010 WHERE (referencia_adicion='$ref_imput_presu') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";
			$resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
			if ($filas==0){$error=1; echo "Codigo Servicio:".$cod_articulo; ?> <script language="JavaScript"> muestra('CÓDIGO NO EXISTE EN LA EJECUCIÓN DEL CREDITO ADICIONAL');</script><? }
			 else{$registro=pg_fetch_array($resultado);
			   if($registro["disponible"]<$monto_credito) {$error=1; $dispon=$registro["disponible"]; $dispon=formato_monto($dispon); ?> <script language="JavaScript"> muestra('Monto Mayor que Disponibilidad del Crédito Adicional, Disponibilidad: <? echo $dispon; ?> ');</script><? }
			 }
		  }	  
		}  
	  if($total_iva>0){ if($cod_cat==substr($cod_presup,0,$c)){$cod_pre_iva=$cod_iva;}else{$cod_pre_iva=substr($cod_presup,0,$c)."-".$part_iva;}
		if($error==0){ $sSQL="Select * from PRE026 WHERE codigo_mov='$codigo_mov' and cod_presup='$cod_pre_iva' and fuente_financ='$fuente_financ'";
		  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
		  if ($filas>0){ $exist_cod_iva="S"; $reg=pg_fetch_array($resultado); $monto_cod_iva=$reg["monto"]+$total_iva; }
		   else{ $exist_cod_iva="N"; $monto_cod_iva=$total_iva; $nro_cod_pre=$nro_cod_pre+1; } $monto_credito=0;
		  if (verifica_disponibilidad($conn,$cod_pre_iva,$fuente_financ,$fecha,$monto_cod_iva)==0){$error=0;}else{$error=1;} 		  
		  if(($error==0)and($tipo_imput_presu=="C")){ $monto_credito=$monto_cod;
			$sSQL="Select * from PRE010 WHERE (referencia_adicion='$ref_imput_presu') and (cod_presup='$cod_pre_iva') and (fuente_financ='$fuente_financ')";
			$resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
			if ($filas==0){$error=1; echo "Codigo Articulo:".$cod_articulo; ?> <script language="JavaScript"> muestra('CÓDIGO IVA NO EXISTE EN LA EJECUCIÓN DEL CREDITO ADICIONAL');</script><? }
			 else{$registro=pg_fetch_array($resultado);
			   if($registro["disponible"]<$monto_credito) {$error=1; $dispon=$registro["disponible"]; $dispon=formato_monto($dispon); ?> <script language="JavaScript"> muestra('Monto Mayor que Disponibilidad del Crédito Adicional, Disponibilidad: <? echo $dispon; ?> ');</script><? }
			 }
		  }	  
		} } 	
	  if($error==0){$StrSQL="SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente_financ','','0001','','0000','','0000','','0000','','','','','','','$sfecha','C','P','00000000','$sfecha',$monto_cod,0,0,0)"; if($exist_cod=="S"){$StrSQL="SELECT MODIFICA_PRE026('$codigo_mov','$cod_presup','$fuente_financ','','0001','','0000','','0000','','0000','','','','','','','$sfecha','C','P','00000000','$sfecha',$monto_cod,0,0,0)";}
		  $resultado=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } 
		  if($total_iva>0){$StrSQL="SELECT INCLUYE_PRE026('$codigo_mov','$cod_pre_iva','$fuente_financ','','0001','','0000','','0000','','0000','','','','','','','$sfecha','C','P','00000000','$sfecha',$monto_cod_iva,0,0,0)"; if($exist_cod_iva=="S"){$StrSQL="SELECT MODIFICA_PRE026('$codigo_mov','$cod_iva','$fuente_financ','','0001','','0000','','0000','','0000','','','','','','','$sfecha','C','P','00000000','$sfecha',$monto_cod_iva,0,0,0)";} 
			 if($error==0){$resultado=pg_exec($conn,$StrSQL);$error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61); if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? } }
		} }
	}  
?>
<form name="form2" method="post" action="Inc_Orden_Servicio.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtnro_ord" type="hidden" id="txtnro_ord" value="<?echo $nro_orden?> " ></td>
     <td width="5"><input name="txtasig_orden" type="hidden" id="txtasig_orden" value="S" ></td>
     <td width="5"><input name="txtfecha_ord" type="hidden" id="txtfecha_ord" value="<?echo $fecha_orden?>" ></td>
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="<?echo $nro_aut?>" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>	 
     <td width="5"><input name="txtcod_tipos" type="hidden" id="txtcod_tipos" value="<?echo $cod_tipos?>" ></td>
     <td width="5"><input name="txttipo_ords" type="hidden" id="txttipo_ords" value="<?echo $tipo_ords?>" ></td>
     <td width="5"><input name="txtnombre_abrev" type="hidden" id="txtnombre_abrev" value="<?echo $nomb_a_ordc?>" ></td>
	 
     <td width="5"><input name="txtmodifc_presup" type="hidden" id="txtmodifc_presup" value="<?echo $modifc_presup?>" ></td>
     <td width="5"><input name="txtcod_imp_unico" type="hidden" id="txtcod_imp_unico" value="<?echo $cod_imp_unico?>" ></td>
     <td width="5"><input name="txtcod_imp_part" type="hidden" id="txtcod_imp_part" value="<?echo $cod_imp_part?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtbloqueada" type="hidden" id="txtbloqueada" value="N" ></td>
	 
     <td width="5"><input name="txtnro_sol" type="hidden" id="txtnro_sol" value="<?echo $nro_solicitud?>"></td>   
     <td width="5"><input name="txtfecha_sol"" type="hidden" id="txtfecha_sol"" value="<?echo $fecha_solicitud?>"></td>
	 
     <td width="5"><input name="txtdias_c" type="hidden" id="txtdias_c" value="<?echo $dias_credito?>"></td>  
     <td width="5"><input name="txtoper" type="hidden" id="txtoper" value="<?echo $operacion?>"></td>
     <td width="5"><input name="txtconcep" type="hidden" id="txtconcep" value="<?echo $concepto?>" ></td>	 
	 <td width="5"><input name="txtuni_sol" type="hidden" id="txtuni_sol" value="<?echo $unidad_solicitante?>"></td>
     <td width="5"><input name="txtdes_unidad" type="hidden" id="txtdes_unidad" value="<?echo $des_unidad_sol?>"></td>
     <td width="5"><input name="txtlugar_ent" type="hidden" id="txtlugar_ent" value="<?echo $lugar_entrega?>"></td>     
     <td width="5"><input name="txtced_r" type="hidden" id="txtced_r" value="<?echo $rif_proveedor?>"></td>
     <td width="5"><input name="txtnomb_r" type="hidden" id="txtnomb_r" value="<?echo $nombre?>"></td>
	 <td width="5"><input name="txtfecha_ven" type="hidden" id="txtfecha_ven" value="<?echo $fecha_vencim?>"></td>	
     <td width="5"><input name="txtaplica_imp" type="hidden" id="txtaplica_imp" value="<?echo $aplica_impuesto?>" ></td>
     <td width="5"><input name="txtcod_part_iva" type="hidden" id="txtcod_part_iva" value="<?echo $cod_part_iva?>" ></td> 
     <td width="5"><input name="txtcod_pre_imp" type="hidden" id="txtcod_pre_imp" value="<?echo $cod_presup_imp?>" ></td>     	 
	 <td width="5"><input name="txtf_inv" type="hidden" id="txtf_inv" value="<?echo $func_inv?>" ></td>
     <td width="5"><input name="txttipo_f" type="hidden" id="txttipo_f" value="<?echo $campo_str1?>" ></td>
     <td width="5"><input name="txttiene_ant" type="hidden" id="txttiene_ant" value="<?echo $tiene_anticipo?>" ></td>
     <td width="5"><input name="txttasa_ant" type="hidden" id="txttasa_ant" value="<?echo $tasa_anticipo?>"></td>
     <td width="5"><input name="txtcta_ant" type="hidden" id="txtcta_ant" value="<?echo $cod_con_anticipo?>"></td>
     <td width="5"><input name="txtfecha_d" type="hidden" id="txtfecha_d" value=""></td>
     <td width="5"><input name="txtfecha_h" type="hidden" id="txtfecha_h" value=""></td>
  </tr>
</table>
</form>
</body>
</html>
<?pg_close();
if ($error==0){?><script language="JavaScript">alert('Solicitud de Servicio Cargada'); Llamar_Inc_Orden();</script> <? }else {?>  <script language="JavaScript"> alert('Error en Carga'); history.back();</script> <? }
?>