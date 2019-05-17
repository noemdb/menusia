<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc"); include ("../presupuesto/Ver_dispon.php"); $codigo_mov=$_GET["codigo_mov"]; $ref_comp=$_GET["ref_comp"];?>
<html>
<head>  <title>PEGAR ORDEN</title>
<script language="JavaScript" type="text/JavaScript">
function Llamar_Inc_Orden(mref_comp){ if(mref_comp=="S"){document.form3.submit();}else{document.form2.submit();} }
</script>
</head>
<body>
<?$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else{ $Nom_Emp=busca_conf(); }
 echo "ESPERE POR FAVOR PEGANDO ORDEN.... ","<br>";
 $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $res=pg_exec($conn,"SELECT BORRAR_PAG028('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ELIMINA_CON008('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG029(4,'$codigo_mov','','','','','2007-01-01',0,0,0,0,0,0,0,0,0,0,0,0,0,0,'','','','','')");$error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 (4,'$codigo_mov','','',0)");  $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT BORRAR_PAG038 ('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
 $resultado=pg_exec($conn,"SELECT BORRAR_BAN029('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
 $res=pg_exec($conn,"SELECT BORRAR_PAG039('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

$mconf="";$tipo_causd="0002";$tipo_causc="0001";$tipo_causf="0003"; $Ssql="Select * from SIA005 where campo501='01'"; $resultado=pg_query($Ssql);
if ($registro=pg_fetch_array($resultado,0)){$mconf=$registro["campo502"]; $tipo_causc=$registro["campo504"];$tipo_causd=$registro["campo505"];$tipo_causf=$registro["campo506"];}
$gen_ord_ret=substr($mconf,0,1); $gen_comp_ret=substr($mconf,1,1); $gen_pre_ret=substr($mconf,2,1); $nro_aut=substr($mconf,4,1); $fecha_aut=substr($mconf,5,1);
$comp_automatico="S"; $cod_busca="PAG001".$usuario_sia; $nro_orden="";  $tipo_causado=""; $cod_contable_o="";
$concepto="";$fecha="";$nombre_abrev_caus=""; $ced_rif="";$nombre=""; $fecha_desde=""; $fecha_hasta=""; $fecha_vencim=""; $usuario_siao=""; $inf_anul="";
$func_inv="";$genera_comprobante="";  $inf_usuario="";$anulado="";$modulo=""; $mstatus_ord="";$pago_ces="";$ced_rif_ces=""; $nombre_ces="";
$tipo_documento=""; $nro_documento="";$tipo_orden="";$des_tipo_orden="";$cod_banco="";$nombre_cuenta="";$nombre_banco=""; $orden_permanen="N"; $nro_periodos=0;
$total_causado=0; $total_retencion=0; $total_ajuste=0; $total_pasivos=0; $monto_am_ant=0;  $total_neto = 0;
$sql="Select * from PAG041 Where codigo_mov='$cod_busca'"; $res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>0){$registro=pg_fetch_array($res); $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"];
  $concepto=$registro["concepto"];   $inf_usuario=$registro["inf_usuario"];   $nombre_abrev_caus=""; $cod_contable_o=$registro["cod_contable_o"];
  $ced_rif=$registro["ced_rif"];   $nombre="";   $func_inv=$registro["func_inv"];   $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; 
  $pago_ces=$registro["pago_ces"];  $ced_rif_ces=$registro["ced_rif_ces"];   $nombre_ces=$registro["nombre_ces"];
  $tipo_documento=$registro["tipo_documento"];  $nro_documento=$registro["nro_documento"];    $fecha_desde=$registro["fecha_desde"];
  $fecha_hasta=$registro["fecha_hasta"];  $fecha_vencim=$registro["fecha_vencim"];   $tipo_orden=$registro["tipo_orden"];
  $cod_banco=$registro["cod_banco"];  $nombre_cuenta=""; $nombre_banco="";   $mstatus_ord=$registro["status"];    
  $fecha_c=$registro["fecha_cheque"]; $orden_permanen=$registro["orden_permanen"]; $nro_periodos=$registro["nro_periodos"];
  if($fecha_c==""){$fecha_c="";}else{$fecha_c=formato_ddmmaaaa($fecha_c);} $inf_anul="Orden Anulada con Fecha: ".formato_ddmmaaaa($fecha_anulado);
  $inf_canc="Banco:".$registro["cod_banco"]." Cheque Numero:".$registro["nro_cheque"]." Fecha:".$fecha_c;
  if($registro["tipo_pago"]=="NDB"){ $inf_canc="Banco:".$registro["cod_banco"]." Nota Debito:".$registro["nro_cheque"]." Fecha:".$fecha_c;}
  if($registro["tipo_pago"]=="PAG"){ $inf_canc="Pago Presupuestario:".$registro["nro_cheque"]." Fecha:".$fecha_c;}
  $total_causado=$registro["total_causado"];  $total_retencion=$registro["total_retencion"]; $usuario_siao=$registro["usuario_sia"];
  $total_ajuste=$registro["total_ajuste"];  $total_pasivos=$registro["total_pasivos"];  $monto_am_ant=$registro["monto_am_ant"];
  $total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant;
  if($registro["retencion"]=="S"){$total_neto = $total_causado - $total_ajuste;}
  else{if($total_pasivos>0) {$total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant + $total_pasivos;} }
}
$total_causado=formato_monto($total_causado);$total_retencion=formato_monto($total_retencion);
$total_ajuste=formato_monto($total_ajuste); $total_pasivos=formato_monto($total_pasivos);
$monto_am_ant=formato_monto($monto_am_ant);$total_neto=formato_monto($total_neto);
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="I"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
$clave=$nro_orden.$tipo_causado; $error=0; $cod_cont=$cod_contable_o;
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($fecha_desde==""){$fecha_desde="";}else{$fecha_desde=formato_ddmmaaaa($fecha_desde);}
if($fecha_hasta==""){$fecha_hasta="";}else{$fecha_hasta=formato_ddmmaaaa($fecha_hasta);}
if($fecha_vencim==""){$fecha_vencim="";}else{$fecha_vencim=formato_ddmmaaaa($fecha_vencim);}
if($fecha==""){$sfecha="0000000000";}else{$sfecha=formato_aaaammdd($fecha);}
$sSQL="SELECT ced_rif,nombre from pre099 WHERE ced_rif='$ced_rif'"; $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
if ($filas>=1){$registro=pg_fetch_array($resultado); $nombre=$registro["nombre"];}	
$sSQL="Select des_tipo_orden,cod_contable_t from PAG008 WHERE tipo_orden='$tipo_orden'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
if ($filas==0){$registro=pg_fetch_array($resultado); $des_tipo_orden=$registro["des_tipo_orden"]; $cod_cont=$registro["cod_contable_t"]; }

$ref_compromiso="";
$sSQL="SELECT tipo_causado, nombre_tipo_caus,nombre_abrev_caus,ref_compromiso from pre003 Where (tipo_causado='$tipo_causado')";$resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);   
if ($filas>0){ $reg=pg_fetch_array($resultado); $nombre_tipo_caus=$reg["nombre_abrev_caus"]; $ref_compromiso=$reg["ref_compromiso"]; $ref_compromiso=substr($ref_compromiso,0,1);}
if($ref_compromiso==$ref_comp){$error=0; }else{ $error=1; $mensaje="Orden:".$nro_orden." Tipo:".$tipo_causado." No se puede Pegar, Tipo Invalido"; $tipo_causado="";
?> <script language="JavaScript">  muestra('<? echo $mensaje; ?>'); </script> <?}
if($error==0){  $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(1,'$codigo_mov','$nro_orden','0000','$ced_rif','$tipo_orden','$cod_cont','NO')"); 
  $sql="select pre034.codigo_mov,pre034.referencia_comp,pre034.tipo_compromiso,pre034.cod_comp,pre034.fecha_compromiso,pre034.cod_presup,pre034.fuente_financ,pre034.tipo_imput_presu,pre034.ref_imput_presu,pre034.monto,pre034.causado,pre034.pagado,pre034.ajustado,pre034.monto_credito,pre001.cod_contable FROM pre034 LEFT JOIN pre001 ON (pre001.cod_presup=pre034.cod_presup) and (pre001.cod_fuente=pre034.fuente_financ) where pre034.codigo_mov='$cod_busca' order by pre034.cod_presup,pre034.fuente_financ";$res=pg_query($sql); 
  while($registro=pg_fetch_array($res)){ $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $ref_imput_presu=$registro["ref_imput_presu"]; $cod_contabg=$registro["cod_contable"];
	  $denominacion="";  $monto=$registro["monto"]; $sfecha=$registro["fecha_compromiso"]; $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"]; $tipo_imput_presu=$registro["tipo_imput_presu"];   $monto_credito=$registro["monto_credito"];
      $resultado=pg_exec($conn,"SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','','0000','','0000','','0000','','','','$cod_contabg','','','$sfecha','C','$tipo_imput_presu','$ref_imput_presu','$sfecha',$monto,0,$monto_credito,0)");
  }
  
  $sql="Select * from pag046 Where codigo_mov='$cod_busca' order by campo_str1";$res=pg_query($sql);   
  //echo $sql,"<br>";
  while($registro=pg_fetch_array($res)){ $nro_factura=$registro["nro_factura"]; $nro_con_factura=$registro["nro_con_factura"]; $ref_compromiso=$registro["ref_compromiso"]; $tipo_compromiso=$registro["tipo_compromiso"];
    $sfecha=$registro["fecha_factura"]; $monto_sin_iva=$registro["monto_sin_iva"]; $monto_iva1_so=$registro["monto_iva1_so"]; 
	$tasa_iva1=$registro["tasa_iva1"]; $monto_iva1=$registro["monto_iva1"];	$monto_iva3_so=$registro["monto_iva3_so"]; $monto_iva4_so=$registro["monto_iva4_so"]; 
	$monto_factura=$registro["monto_factura"]; $rif_fact=$registro["rif_factura"];	$nro_linea=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];	
    $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG029(1,'$codigo_mov','$nro_factura','$nro_con_factura','$ref_compromiso','$tipo_compromiso','$sfecha',$monto_sin_iva,$monto_iva1_so,$tasa_iva1,$monto_iva1,0,0,0,$monto_iva3_so,0,0,$monto_iva4_so,0,0,$monto_factura,'$rif_fact','N','N','$nro_linea','$campo_str2')");
  }
  
  $sql="Select * from pag042 Where codigo_mov='$cod_busca' order by tipo_retencion";$res=pg_query($sql);   
  //echo $sql,"<br>";
  while($registro=pg_fetch_array($res)){ $tipo_retencion=$registro["tipo_retencion"]; $referencia_comp=$registro["ref_comp_ret"]; $tipo_compromiso=$registro["tipo_comp_ret"]; $cod_presup=$registro["cod_presup_ret"]; $fuente_financ=$registro["fuente_fin_ret"];
    $cod_contable=$registro["cod_contable_ret"]; $tasa_retencion=$registro["tasa_retencion"]; $monto_objeto=$registro["monto_objeto_ret"];  $monto_retencion=$registro["monto_retencion"]; 
	$ced_rif_r=$registro["ced_rif_r"];$nombre_r='';$des_orden_ret=$registro["des_orden_ret"];	
    $sSQL="SELECT ACTUALIZA_PAG028(1,'$codigo_mov','00000000','$tipo_retencion','$referencia_comp','$tipo_compromiso','$cod_presup','$fuente_financ','00000000','0000','$cod_contable',$tasa_retencion,$monto_objeto,$monto_retencion,0,'R','$ced_rif_r','$nombre_r','S','0000','0000','$des_orden_ret')";    $resultado=pg_exec($conn,$sSQL); 
  }
  
  $sql="Select * from pag040 Where codigo_mov='$cod_busca' order by cod_cuenta";$res=pg_query($sql);   
  //echo $sql,"<br>";
  while($registro=pg_fetch_array($res)){ $cod_cuenta=$registro["cod_cuenta"]; $debito_credito=$registro["debito_credito"]; $monto_pasivo=$registro["monto_pasivo"];
    $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG030 ('1','$codigo_mov','$cod_cuenta','$debito_credito','$monto_pasivo')");  
  }  
  if($ref_comp=='N'){$res=pg_exec($conn,"UPDATE PRE026 set tipo_compromiso='0000',referencia_comp='00000000' where codigo_mov='$codigo_mov'");   }
  else{ $sql="Select * from CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup";  $res=pg_query($sql);
    while($registro=pg_fetch_array($res)){$cod_presup=$registro["cod_presup"];$fuente_financ=$registro["fuente_financ"]; $ref_imput_presu=$registro["ref_imput_presu"];  $referencia_comp=$registro["referencia_comp"]; $tipo_compromiso=$registro["tipo_compromiso"];
        $sSQL="Select * from PRE036 WHERE (ref_imput_presu='$ref_imput_presu') and (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
        if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NO EXISTE EN EL COMPROMISO EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
         else{$registro=pg_fetch_array($resultado);  $compromiso=$registro["monto"]-$registro["causado"]-$registro["ajustado"]; 
		    
			$resc=pg_exec($conn,"UPDATE PRE026 set monto_presup=$compromiso where codigo_mov='$codigo_mov' and ref_imput_presu='$ref_imput_presu' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'");
		 }  
	}
  }  
}
?>
<form name="form2" method="post" action="Inc_orden_pago.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser" type="hidden" id="txtuser" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword" type="hidden" id="txtpassword" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname" type="hidden" id="txtdbname" value="<?echo $dbname?>" ></td>
	 <td width="5"><input name="txtport" type="hidden" id="txtport" value="<?echo $port?>" ></td>	 
	 <td width="5"><input name="txthost" type="hidden" id="txthost" value="<?echo $host?>" ></td>	 
     <td width="5"><input name="txtnro_aut" type="hidden" id="txtnro_aut" value="N" ></td>
     <td width="5"><input name="txtfecha_aut" type="hidden" id="txtfecha_aut" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtgen_ord_ret" type="hidden" id="txtgen_ord_ret" value="<?echo $gen_ord_ret?>" ></td>
     <td width="5"><input name="txtgen_comp_ret" type="hidden" id="txtgen_comp_ret" value="<?echo $gen_comp_ret?>" ></td>
     <td width="5"><input name="txtgen_pre_ret" type="hidden" id="txtgen_pre_ret" value="<?echo $gen_pre_ret?>" ></td>
     <td width="5"><input name="txtcomp_automatico" type="hidden" id="txtcomp_automatico" value="N" ></td>
     <td width="5"><input name="txttipo_caus" type="hidden" id="txttipo_caus" value="<?echo $tipo_causado?>" ></td>
     <td width="5"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtbloqueada" type="hidden" id="txtbloqueada" value="N" ></td>
     <td width="5"><input name="txtcod_est" type="hidden" id="txtcod_est" value="" ></td>
     <td width="5"><input name="txtced_r" type="hidden" id="txtced_r" value="<?echo $ced_rif ?>"></td>
     <td width="5"><input name="txtnomb_r" type="hidden" id="txtnomb_r" value="<?echo $nombre ?>"></td>
	 <td width="5"><input name="txtcon_est" type="hidden" id="txtcon_est" value="<?echo $concepto?>"></td>
	 <td width="5"><input name="txttipo_doc" type="hidden" id="txttipo_doc" value="<?echo $tipo_documento?>"></td>
     <td width="5"><input name="txtnro_doc" type="hidden" id="txtnro_doc" value="<?echo $nro_documento?>"></td>
     <td width="5"><input name="txttipo_ord" type="hidden" id="txttipo_ord" value="<?echo $tipo_orden?>"></td>
	 <td width="5"><input name="txtdes_t_orden" type="hidden" id="txtdes_t_orden" value="<?echo $des_tipo_orden?>"></td>
     <td width="5"><input name="txtfecha_d" type="hidden" id="txtfecha_d" value="<?echo $fecha_desde?>"></td>
     <td width="5"><input name="txtfecha_h" type="hidden" id="txtfecha_h" value="<?echo $fecha_hasta?>"></td>
	 <td width="5"><input name="txtfecha_v" type="hidden" id="txtfecha_v" value="<?echo $fecha_vencim?>"></td>	 
	 <td width="5"><input name="txtnro_ord" type="hidden" id="txtnro_ord" value="<?echo $nro_orden?>"></td>
	 <td width="5"><input name="txtfecha_fin" type="hidden" id="txtfecha_fin" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input name="txtcod_emp" type="hidden" id="txtcod_emp" value="<?echo $Cod_Emp?>" ></td> 
  </tr>
</table>
</form>
<form name="form3" method="post" action="Inc_ord_pago_comp.php">
<table width="10">
  <tr>
     <td width="5"><input name="txtuser2" type="hidden" id="txtuser2" value="<?echo $user?>" ></td>
     <td width="5"><input name="txtpassword2" type="hidden" id="txtpassword2" value="<?echo $password?>" ></td>
     <td width="5"><input name="txtdbname2" type="hidden" id="txtdbname2" value="<?echo $dbname?>" ></td>
     <td width="5"><input name="txtnro_aut2" type="hidden" id="txtnro_aut2" value="N" ></td>
	 <td width="5"><input name="txtport2" type="hidden" id="txtport2" value="<?echo $port?>" ></td>	 
	 <td width="5"><input name="txthost2" type="hidden" id="txthost2" value="<?echo $host?>" ></td>	 
     <td width="5"><input name="txtfecha_aut2" type="hidden" id="txtfecha_aut2" value="<?echo $fecha_aut?>" ></td>
     <td width="5"><input name="txtgen_ord_ret2" type="hidden" id="txtgen_ord_ret2" value="<?echo $gen_ord_ret?>" ></td>
     <td width="5"><input name="txtgen_comp_ret2" type="hidden" id="txtgen_comp_ret2" value="<?echo $gen_comp_ret?>" ></td>
     <td width="5"><input name="txtgen_pre_ret2" type="hidden" id="txtgen_pre_ret2" value="<?echo $gen_pre_ret?>" ></td>
     <td width="5"><input name="txtcomp_automatico2" type="hidden" id="txtcomp_automatico2" value="N" ></td>
     <td width="5"><input name="txttipo_caus2" type="hidden" id="txttipo_caus2" value="<?echo $tipo_causado?>" ></td>
     <td width="5"><input name="txtcodigo_mov2" type="hidden" id="txtcodigo_mov2" value="<?echo $codigo_mov?>" ></td>
     <td width="5"><input name="txtbloqueada2" type="hidden" id="txtbloqueada2" value="N" ></td>
     <td width="5"><input name="txtcod_est2" type="hidden" id="txtcod_est2" value="" ></td>
	 <td width="5"><input name="txtced_r2" type="hidden" id="txtced_r2" value="<?echo $ced_rif ?>"></td>
     <td width="5"><input name="txtnomb_r2" type="hidden" id="txtnomb_r2" value="<?echo $nombre ?>"></td>
	 <td width="5"><input name="txtcon_est2" type="hidden" id="txtcon_est2" value="<?echo $concepto?>"></td>
     <td width="5"><input name="txttipo_doc2" type="hidden" id="txttipo_doc2" value="<?echo $tipo_documento?>"></td>
     <td width="5"><input name="txtnro_doc2" type="hidden" id="txtnro_doc2" value="<?echo $nro_documento?>"></td>
     <td width="5"><input name="txttipo_ord2" type="hidden" id="txttipo_ord2" value="<?echo $tipo_orden?>"></td>
	 <td width="5"><input name="txtdes_t_orden2" type="hidden" id="txtdes_t_orden2" value="<?echo $des_tipo_orden?>"></td>
     <td width="5"><input name="txtfecha_d2" type="hidden" id="txtfecha_d2" value="<?echo $fecha_desde?>"></td>
     <td width="5"><input name="txtfecha_h2" type="hidden" id="txtfecha_h2" value="<?echo $fecha_hasta?>"></td>
	 <td width="5"><input name="txtfecha_v2" type="hidden" id="txtfecha_v2" value="<?echo $fecha_vencim?>"></td>
	 <td width="5"><input name="txtnro_ord2" type="hidden" id="txtnro_ord2" value="<?echo $nro_orden?>"></td>
	 <td width="5"><input name="txtfecha_fin2" type="hidden" id="txtfecha_fin2" value="<?echo $Fec_Fin_Ejer?>"></td>
	 <td width="5"><input name="txtcod_emp2" type="hidden" id="txtcod_emp2" value="<?echo $Cod_Emp?>" ></td>
  </tr>
</table>
</form>
<?   
pg_close();
if ($error==0){?><script language="JavaScript">alert('Orden Pegada'); Llamar_Inc_Orden('<?echo $ref_comp?>');</script> <? }
else {?>  <script language="JavaScript">history.back();</script> <? }
?>