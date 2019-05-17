<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc"); error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"]; $tipo_pago=$_POST["txttipo_pago"]; $cod_banco=$_POST["txtcod_banco"]; $num_nota=$_POST["txtnro_ndb"]; 
$nro_orden=$_POST["txtnro_orden"];  $monto=$_POST["txtmonto_nota"];  $fecha=$_POST["txtfecha"]; $ced_rif=$_POST["txtced_rif"]; $descripcion=$_POST["txtconcepto"]; $multiple="N"; $fecha_cheque=$fecha;
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$url="Emision_Ndb_ord_nomina_gby.php?continua=N"; $furl="../bancos/rpt/Rpt_formato_mov_libro.php?cod_banco=".$cod_banco."&referencia=".$num_nota."&tipo_mov=NDB";
$monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;} else{$monto=0;} $monto_nota=$monto;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if(pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
if($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA');</script><?}
if($error==0){ $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"]; $l_cat=strlen($formato_cat); if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$$registro["campo503"];}}
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $des_chq=""; $periodom=$SIA_Periodo; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='02'"; $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $periodom=$registro["campo503"]; $des_chq=$registro["campo510"];}
    $sobreg_saldo=substr($campo502,0,1); $doc_concepto=substr($campo502,5,1); $ret_presup=substr($campo502,6,1); $chq_proceso=substr($campo502,7,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"];} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
}
if(checkData($fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if(($error==0)and($monto==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO NOTA DE DEBITO INVALIDO');</script><? }

if($error==0){$sfecha=formato_aaaammdd($fecha); if(($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){echo $sfecha; $error=1;?><script language="JavaScript">muestra('FECHA DE NOTA DEBITO INVALIDA');</script><?}}
if($error==0){$nmes=substr($fecha,3, 2);  if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}  if($periodom>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}}
if($error==0){ if(strlen($num_nota)==8){$error=0;} else {$error=1; ?> <script language="JavaScript"> muestra('LONGITUD NOTA DEBITO INVALIDO');</script><? } }
if($error==0){ $sSQL="SELECT cod_banco FROM BAN004 WHERE cod_banco='$cod_banco' and referencia='$num_nota' and tipo_mov_libro='NDB'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('NUMERO NOTA DEBITO YA EXISTE');</script><? }}
if($error==0){$sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}} 
if($error==0){ $tipo_comp="B".$cod_banco; $sSql="Select * from con002 where text(fecha)='$sfecha' and referencia='$num_nota' and tipo_comp='$tipo_comp'";  $resultado=pg_query($sSql);  $filas=pg_num_rows($resultado);
  if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE YA EXISTE');</script><? }}
if($error==0){ $nmes=substr($fecha,3, 2); $codc_banco=""; $tasa_idb=0; $cod_cont_idb="";
 $sSQL="SELECT cod_banco,nombre_banco,nro_cuenta,descripcion_banco,tipo_cuenta,cod_contable,tipo_bco,control_chequera,status_control,activa,fecha_activa,fecha_desactiva,s_inic_libro,deb_libro01,cre_libro01,deb_libro02,cre_libro02,deb_libro03,cre_libro03,deb_libro04,cre_libro04,deb_libro05,cre_libro05,deb_libro06,cre_libro06,deb_libro07,cre_libro07,deb_libro08,cre_libro08,deb_libro09,cre_libro09,deb_libro10,cre_libro10,deb_libro11,cre_libro11,deb_libro12,cre_libro12,campo_str1,campo_str2,campo_num1,campo_num2 FROM ban002 WHERE cod_banco='$cod_banco'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO NO EXISTE');</script><? }
 else {$registro=pg_fetch_array($resultado,0); $codc_banco=$registro["cod_contable"];  $activo=$registro["activa"]; $saldo_ant_libro=$registro["s_inic_libro"]; $tasa_idb=$registro["campo_num1"]; $cod_cont_idb=$registro["campo_str1"];  if($activo=="N"){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO NO ESTA ACTIVO');</script><? }
 if($error==0){$disponible=$saldo_ant_libro; for ($i=1;$i<=$nmes;$i++){$spos=$i; If($i<=9){$spos="0".$spos;} $disponible=$disponible+$registro["deb_libro".$spos] - $registro["cre_libro".$spos]; } $balance=$monto-$disponible;
  if(($disponible<$monto)and($balance>0.001)){if($sobreg_saldo=="N"){$error=1;} echo "Disponible: ".$disponible.'  Requerido: '.$monto,"<br>"; ?> <script language="JavaScript"> muestra('SOBREGIRA SALDO DEL BANCO');</script><? }
 }}
}
$total_orden=0; $total_abono=0;
if($error==0){$sql="Select * from ORD_PAGO where nro_orden='$nro_orden' and anulado='N'"; $res=pg_query($sql); $filas=pg_num_rows($res); 
	if($filas>=1){ $registro=pg_fetch_array($res,0);   $tipo_caus=$registro["tipo_causado"]; 
	  $fecha_ord=$registro["fecha"];
	  $orden_permanen=$registro["orden_permanen"]; $nro_periodos=$registro["nro_periodos"];  $cod_contable_o=$registro["cod_contable_o"]; $tipo_orden=$registro["tipo_orden"];
	  $anulado=$registro["anulado"]; $mstatus_ord=$registro["status"]; $pago_ces=$registro["pago_ces"];  $ced_rif_ces=$registro["ced_rif_ces"];   $nombre_ces=$registro["nombre_ces"]; 	  
	  $total_orden=$registro["total_causado"]-$registro["total_ajuste"]-$registro["total_retencion"]-$registro["monto_am_ant"]+$registro["total_pasivos"];  $total_abono=$registro["total_pagado"]; 
	  $total_neto = $registro["total_causado"]-$registro["total_ajuste"]-$registro["total_retencion"]-$registro["monto_am_ant"]+$registro["total_pasivos"]-$registro["total_pagado"] ;
	  $dispo_ord=$total_neto; $total_neto=0; if($total_abono==0){$total_retencion=$registro["total_retencion"]; $nro_orden_ret=$nro_orden;}else{$total_retencion=0;$nro_orden_ret="";}	  	  
	  $resta_abono=$monto_nota+$total_retencion; $monto_abono=0;	 $monto_bruto=$monto_nota+$total_retencion;
	  if($anulado=="S"){ $error=1; ?><script language="JavaScript">muestra('ORDEN DE PAGO ESTA ANULADA');</script><? }
	  if($mstatus_ord=="I"){ $error=1; ?><script language="JavaScript">muestra('ORDEN DE PAGO ESTA CANCELADA');</script><? }
	  if(($tipo_orden=="0003")or($tipo_orden=="0015")or($tipo_orden=="0029")){}else{ $error=1; ?><script language="JavaScript">muestra('TIPO DE ORDEN NO ES VALIDO');</script><? }    
	  if($error==0){ $resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $mvalor=pg_errormessage($conn); $mvalor=substr($mvalor,0,91); 
	    $sql="select pre037.referencia_caus,pre037.tipo_causado,pre037.referencia_comp,pre037.tipo_compromiso,pre037.cod_presup,pre037.fuente_financ,pre037.monto,pre037.ajustado,pre037.tipo_imput_presu,pre037.ref_imput_presu,pre037.monto_credito,pre037.pagado,pre037.amort_anticipo,pre007.ref_aep,pre007.num_proyecto,pre007.fecha_aep,pre007.func_inv,pre003.ref_compromiso from pre037,pre007 Left Join pre003 On (pre003.tipo_causado=pre007.tipo_causado) where (pre037.referencia_caus=pre007.referencia_caus) and (pre037.tipo_causado=pre007.tipo_causado) and (pre037.referencia_comp=pre007.referencia_comp) and (pre037.tipo_compromiso=pre007.tipo_compromiso) and (pre007.referencia_caus='$nro_orden') and (pre007.tipo_causado='$tipo_caus') order by cod_presup,fuente_financ"; $res=pg_query($sql);
	    while($reg=pg_fetch_array($res)){ $monto_c=$reg["monto"]-$reg["ajustado"]; $pagado=$reg["pagado"]; $cod_presup=$reg["cod_presup"]; $fuente_financ=$reg["fuente_financ"];  $referencia_comp=$reg["referencia_comp"]; $tipo_compromiso=$reg["tipo_compromiso"]; $tipo_imput_presu=$reg["tipo_imput_presu"];  $ref_imput_presu=$reg["ref_imput_presu"]; $monto_credito=$reg["monto_credito"]; $func_inv=$reg["func_inv"];  $fecha_aep=$reg["fecha_aep"]; $ref_aep=$reg["ref_aep"]; $num_proyecto=$reg["num_proyecto"];  $operacion="N";  if($reg["ref_compromiso"]="SI"){$operacion="C";}
		   $monto_cre=0; $monto_p=0;			   
		   $m_cod=$monto_c-$pagado;
		   if(($m_cod>0)and($resta_abono>0)){if($resta_abono>=$m_cod){$m_cod=$m_cod;}else{$m_cod=$resta_abono;}  
			 $resta_abono=$resta_abono-$m_cod;  $monto_abono=$monto_abono+$m_cod;   $monto_p=$m_cod; 
			 if($tipo_imput_presu=="P"){$monto_cre=0;}else{if($m_cod>=$monto_credito){$monto_cre=$monto_credito;}else{$monto_cre=$m_cod;} }			 
		   } 
		   $resultado=pg_exec($conn,"SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$nro_orden','$tipo_caus','','0000','','0000','$operacion','','','','$ref_aep','$num_proyecto','$fecha_aep','$func_inv','$tipo_imput_presu','$ref_imput_presu','$fecha_ord',$monto_p,$monto_c,$monto_cre,$pagado)"); $error=pg_errormessage($conn);   $error="ERROR GRABANDO: ".substr($error, 0, 61);  if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }
		}
		
	  }
	  if($error==0){ $monto_asiento=0; $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61); 
		$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','D','$cod_contable_o','00000','',$monto_nota,'D','B','N','02','0','$descripcion')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }
		$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','C','$codc_banco','00000','',$monto_nota,'D','B','N','02','0','$descripcion')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }
	  }	   
	  
	}else{$error=1; ?> <script language="JavaScript"> muestra('NUMERO DE ORDEN NO EXISTE');</script><? }	
	if($error==0){ if($monto_bruto>$monto_abono){$balance=$monto_bruto-$monto_abono;}else{$balance=$monto_abono-$monto_bruto;}
	if(($monto_bruto<>$monto_abono)and($balance>0.001)){$error=1; echo $monto_bruto.' '.$monto_abono.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('MONTO DEL PAGADO PRESUPUESTARIO NO VALIDO');</script><? } }
}
if($error==0){$sql="SELECT * FROM CON010  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";  $res=pg_query($sql);  $t_debe=0; $t_haber=0; $balance=0;
  while($registro=pg_fetch_array($res)){if($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}}
    if($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
    if($balance>0.001){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
    if(($t_debe==0)or($t_haber==0)or($monto_nota<>$t_debe)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
}
if($error==0){$status_ord="A"; $monto_abono=$total_orden-$total_abono; if($monto_nota>=$monto_abono){ $status_ord="I";} }
if($error==0){ if($tasa_idb>0)  {$mstatus="I";$monto_idb=$total_Cheques*($tasa_idb/100); $monto_idb=Round($monto_idb, 2);} else{$cod_cont_idb=""; $mstatus="N"; $monto_idb=0;}    $sfecha=formato_aaaammdd($fecha);
   $sSQL="SELECT INCLUYE_NDB_ABONA_ORDEN('$codigo_mov','$cod_banco','$num_nota','$sfecha','$ced_rif',$monto_nota,'N','','$usuario_sia','$minf_usuario','$mstatus',$monto_idb,'$cod_cont_idb','$codc_banco','$tipo_pago','$statusc','$status_ord','$nro_orden','$tipo_caus','$descripcion')";  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
   if(!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
    else{$error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?   
	$resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");  $mvalor=pg_errormessage($conn); $mvalor=substr($mvalor,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><?}  
    $resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $mvalor=pg_errormessage($conn); $mvalor=substr($mvalor,0,91); 	if(!$resultado){?><script language="JavaScript">muestra('<? echo $mvalor; ?>');</script><?}  
	}
}
pg_close();error_reporting(E_ALL ^ E_WARNING); ?>


<table width="957">
  <tr> <td height="50">&nbsp;</td> </tr>
  <tr><td><table width="923">
      <td width="250"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
<? if($error==0){?><td width="250"><input name="btEmitir" type="button" id="btEmitir" value="Imprimir Nota Debito" title="Impresion Nota Debito Emitida" onclick="javascript:Ventana_chq('<? echo $furl; ?>');"></td>
<? }else{?>  <td width="250"><input name="txtnum_cheque" type="hidden" id="txtnum_cheque" value="<?echo $num_cheque?>"></td> <? } ?>
        <td width="250"><input name="btEmitir" type="button" id="btEmitir" value="Volver a Emision Nota Debito" title="Retornar Emision de Nota Debito" onclick="javascript:document.location ='<? echo $url; ?>';"></td>
        <td width="173" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:document.location ='menu.php'" value="Menu Principal"></td>
   </table></td></tr>
   <tr> <td>&nbsp;</td> </tr>
</table>

