<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc"); error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"]; $tipo_pago=$_POST["txttipo_pago"]; $nro_orden=$_POST["txtnro_orden"]; $cod_banco=$_POST["txtcod_banco"]; $num_cheque=$_POST["txtnro_cheque"];  $monto=$_POST["txtmonto_cheque"];  $fecha=$_POST["txtfecha"]; $ced_rif=$_POST["txtced_rif"]; $descripcion=$_POST["txtconcepto"]; $multiple="N"; $fecha_cheque=$fecha;
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$url="Emision_Cheque_orden_ant.php?continua=S"; $furl="../bancos/rpt/Rpt_formato_chq.php?cod_banco=".$cod_banco."&num_cheque=".$num_cheque;
$monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;} else{$monto=0;} $st_chq="P";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
if($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICION ABIERTA');</script><?}
if($error==0){ $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){ 	$formato_presup=$registro["campo504"];	$formato_cat=$registro["campo526"]; $l_cat=strlen($formato_cat); 	if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$$registro["campo503"];}}
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $des_chq=""; $periodom=$SIA_Periodo; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='02'"; $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $periodom=$registro["campo503"]; $des_chq=$registro["campo510"];}
    $sobreg_saldo=substr($campo502,0,1); $doc_concepto=substr($campo502,5,1); $ret_presup=substr($campo502,6,1); $chq_proceso=substr($campo502,7,1); if($chq_proceso=="N"){$st_chq="C";}
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"];} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
}
if(checkData($fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if(($error==0)and($monto==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE CHEQUE INVALIDO');</script><? }
if($error==0){$sfecha=formato_aaaammdd($fecha); if(($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){echo $sfecha; $error=1;?><script language="JavaScript">muestra('FECHA DE CHEQUE INVALIDA');</script><?}}
if($error==0){$nmes=substr($fecha,3, 2);  if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;} if($periodom>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}}
if($error==0){if(strlen($num_cheque)==8){$error=0;} else {$error=1; ?> <script language="JavaScript"> muestra('LONGITUD NUMERO DE CHEQUE INVALIDA');</script><? } }
if($error==0){$sSQL="SELECT cod_banco FROM BAN006 WHERE cod_banco='$cod_banco' and num_cheque='$num_cheque'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);  if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('NUMERO DE CHEQUE YA EXISTE');</script><? }}
if($error==0){$sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}}
if($error==0){$tipo_comp="B".$cod_banco;$sSql="Select * from con002 where text(fecha)='$sfecha' and referencia='$num_cheque' and tipo_comp='$tipo_comp'"; $resultado=pg_query($sSql); $filas=pg_num_rows($resultado); if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE YA EXISTE');</script><? }}
if($error==0){ $nmes=substr($fecha,3, 2); $codc_banco=""; $tasa_idb=0; $cod_cont_idb="";   $total=$monto;
 $sSQL="SELECT cod_banco,nombre_banco,nro_cuenta,descripcion_banco,tipo_cuenta,cod_contable,tipo_bco,control_chequera,formato_cheque,status_control,activa,fecha_activa,fecha_desactiva,s_inic_libro,deb_libro01,cre_libro01,deb_libro02,cre_libro02,deb_libro03,cre_libro03,deb_libro04,cre_libro04,deb_libro05,cre_libro05,deb_libro06,cre_libro06,deb_libro07,cre_libro07,deb_libro08,cre_libro08,deb_libro09,cre_libro09,deb_libro10,cre_libro10,deb_libro11,cre_libro11,deb_libro12,cre_libro12,campo_str1,campo_str2,campo_num1,campo_num2 FROM ban002 WHERE cod_banco='$cod_banco'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BANCO NO EXISTE');</script><? }
 else {$registro=pg_fetch_array($resultado,0); $codc_banco=$registro["cod_contable"];  $activo=$registro["activa"]; $saldo_ant_libro=$registro["s_inic_libro"]; $tasa_idb=$registro["campo_num1"]; $cod_cont_idb=$registro["campo_str1"]; $formato=$registro["formato_cheque"];  if($formato<>""){$formato_cheque=$formato;}else{ $formato_cheque="Rpt_formato_chq.php";} if($activo=="N"){$error=1; ?> <script language="JavaScript"> muestra('C�DIGO DE BANCO NO ESTA ACTIVO');</script><? }
 if($error==0){$disponible=$saldo_ant_libro; for ($i=1;$i<=$nmes;$i++){$spos=$i; If($i<=9){$spos="0".$spos;} $disponible=$disponible+$registro["deb_libro".$spos] - $registro["cre_libro".$spos]; }
  $balance=$monto-$disponible;
  if(($disponible<$monto)and($balance>0.001)){if($sobreg_saldo=="N"){$error=1;} echo "Disponible: ".formato_monto($disponible).'  Requerido: '.formato_monto($monto),"<br>"; ?> <script language="JavaScript"> muestra('SOBREGIRA SALDO DEL BANCO');</script><? }
 } $furl="../bancos/rpt/".$formato_cheque."?cod_banco=".$cod_banco."&num_cheque=".$num_cheque; }
}
$existe_cta="N";
if($error==0){$sql="SELECT * FROM CON010  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";  $res=pg_query($sql);  $t_debe=0; $t_haber=0; $balance=0;
  while($registro=pg_fetch_array($res)){if($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}   if($codc_banco==$registro["cod_cuenta"]){$existe_cta="S";} }
    if($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
    if($balance>0.001){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
    /*
	if(($t_debe==0)or($t_haber==0)or($total<>$t_debe)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
	*/	
	if(($t_debe==0)or($t_haber==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
    if($existe_cta=="N"){ $error=1; ?> <script language="JavaScript"> muestra('CODIGO CONTABLE DE BANCO NO EXISTE EN COMPROBANTE');</script><?}
}
if($error==0){ if($tasa_idb>0)  {$mstatus="I";$monto_idb=$total_Cheques*($tasa_idb/100); $monto_idb=Round($monto_idb, 2);} else{$cod_cont_idb=""; $mstatus="N"; $monto_idb=0;}    $sfecha=formato_aaaammdd($fecha);
   $sSQL="SELECT INCLUYE_CHQ_PER_ANT('$codigo_mov','$cod_banco','$num_cheque','$sfecha','$ced_rif',$total,'$st_chq','$usuario_sia','N','','$minf_usuario','$mstatus',$monto_idb,'$cod_cont_idb','$codc_banco','$tipo_pago','$statusc','$nro_orden','$descripcion')";  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error,0,91);
   if(!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
    else{$error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?   $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");  $mvalor=pg_errormessage($conn); $mvalor=substr($mvalor,0,91); if(!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $mvalor; ?>'); </script> <? }  }
}
pg_close();error_reporting(E_ALL ^ E_WARNING); ?>

<table width="957">
  <tr> <td height="50">&nbsp;</td> </tr>
  <tr><td><table width="923">
      <td width="250"><input name="txtcodigo_mov" type="hidden" id="txtcodigo_mov" value="<?echo $codigo_mov?>"></td>
<? if($error==0){?><td width="250"><input name="btEmitir" type="button" id="btEmitir" value="Imprimir Cheque" title="Impresion Cheque Emitido" onclick="javascript:Ventana_chq('<? echo $furl; ?>');"></td>
<? }else{?>  <td width="250"><input name="txtnum_cheque" type="hidden" id="txtnum_cheque" value="<?echo $num_cheque?>"></td> <? } ?>
        <td width="250"><input name="btEmitir" type="button" id="btEmitir" value="Volver a Emision de Cheque" title="Retornar Emision de " onclick="javascript:document.location ='<? echo $url; ?>';"></td>
        <td width="173" valign="middle"><input name="button" type="button" id="button" title="Retornar al menu principal" onclick="javascript:document.location ='menu.php'" value="Menu Principal"></td>
   </table></td></tr>
   <tr> <td>&nbsp;</td> </tr>
</table>

