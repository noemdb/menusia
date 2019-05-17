<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc"); include ("../presupuesto/Ver_dispon.php");   error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"]; $tipo_pago=$_POST["txttipo_pago"]; $cod_banco=$_POST["txtcod_banco"]; $num_nota=$_POST["txtnro_ndb"];  $monto=$_POST["txtmonto_nota"];  $fecha=$_POST["txtfecha"]; $ced_rif=$_POST["txtced_rif"]; $descripcion=$_POST["txtconcepto"];
$cod_presup=$_POST["txtcod_presup"]; $fuente_financ=$_POST["txtcod_fuente"]; $tipo_imput_presu=$_POST["txttipo_imput_presu"]; $ref_imput_presu=$_POST["txtref_imput_presu"]; $tipo_imput_presu=substr($tipo_imput_presu,0,1); $num_proyecto="0000000000";
$func_inv=$_POST["txtfunc_inv"]; if($func_inv==""){$func_inv="CORRIENTE";} $func_inv=substr($func_inv,0,1);  if($tipo_imput_presu=="C"){$monto_credito=$monto;}   else{$monto_credito=0;$ref_imput_presu="00000000";$tipo_imput_presu="P";}
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$url="Emision_Ndb_directa.php?continua=S";  $furl="../bancos/rpt/Rpt_formato_mov_libro.php?cod_banco=".$cod_banco."&referencia=".$num_nota."&tipo_mov=NDB"; $monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;} else{$monto=0;}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
if($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICIÒN ABIERTA');</script><?}
if($error==0){ $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";  $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"]; $l_cat=strlen($formato_cat); if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$$registro["campo503"];}}
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $des_chq=""; $periodom=$SIA_Periodo; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='02'"; $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $periodom=$registro["campo503"]; $des_chq=$registro["campo510"];}
    $sobreg_saldo=substr($campo502,0,1); $doc_concepto=substr($campo502,5,1); $ret_presup=substr($campo502,6,1); $chq_proceso=substr($campo502,7,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"];} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
}
if(checkData($fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if(($error==0)and($monto==0)){  $error=1; ?> <script language="JavaScript"> muestra('MONTO DE CHEQUE INVALIDO');</script><? }
if($error==0){$sfecha=formato_aaaammdd($fecha);
  if(($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){echo $sfecha; $error=1;?><script language="JavaScript">muestra('FECHA DE CHEQUE INVALIDA');</script><?}
}
if($error==0){$nmes=substr($fecha,3, 2);  if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}
  if($periodom>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}
}
if($error==0){ if(strlen($num_nota)==8){$error=0;} else {$error=1; ?> <script language="JavaScript"> muestra('LONGITUD NOTA DEBITO INVALIDO');</script><? } }
if($error==0){$sSQL="SELECT cod_banco FROM BAN004 WHERE cod_banco='$cod_banco' and referencia='$num_nota' and tipo_mov_libro='NDB'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('NUMERO NOTA DEBITO YA EXISTE');</script><? }
}
if($error==0){$sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
  if($filas==0){$error=1;?><script language="JavaScript">muestra('CÉDULA/RIF BENEFICIARIO NO EXISTE');</script><?}
}
if($error==0){ $tipo_comp="B".$cod_banco;   $sSql="Select * from con002 where text(fecha)='$sfecha' and referencia='$num_nota' and tipo_comp='$tipo_comp'";  $resultado=pg_query($sSql);  $filas=pg_num_rows($resultado);
  if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE YA EXISTE');</script><? }
}
if($error==0){ $nmes=substr($fecha,3, 2); $codc_banco=""; $tasa_idb=0; $cod_cont_idb="";   $total=$monto;
 $sSQL="SELECT cod_banco,nombre_banco,nro_cuenta,descripcion_banco,tipo_cuenta,cod_contable,tipo_bco,control_chequera,status_control,activa,fecha_activa,fecha_desactiva,s_inic_libro,deb_libro01,cre_libro01,deb_libro02,cre_libro02,deb_libro03,cre_libro03,deb_libro04,cre_libro04,deb_libro05,cre_libro05,deb_libro06,cre_libro06,deb_libro07,cre_libro07,deb_libro08,cre_libro08,deb_libro09,cre_libro09,deb_libro10,cre_libro10,deb_libro11,cre_libro11,deb_libro12,cre_libro12,campo_str1,campo_str2,campo_num1,campo_num2 FROM ban002 WHERE cod_banco='$cod_banco'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO NO EXISTE');</script><? }
 else {$registro=pg_fetch_array($resultado,0); $codc_banco=$registro["cod_contable"];  $activo=$registro["activa"]; $saldo_ant_libro=$registro["s_inic_libro"]; $tasa_idb=$registro["campo_num1"]; $cod_cont_idb=$registro["campo_str1"];  if($activo=="N"){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO NO ESTA ACTIVO');</script><? }
 if($error==0){$disponible=$saldo_ant_libro; for ($i=1;$i<=$nmes;$i++){$spos=$i; If($i<=9){$spos="0".$spos;} $disponible=$disponible+$registro["deb_libro".$spos] - $registro["cre_libro".$spos]; }
  if($disponible<$monto){if($sobreg_saldo=="N"){$error=1;} echo "Disponible: ".formato_monto($disponible).'  Requerido: '.formato_monto($monto),"<br>"; ?> <script language="JavaScript"> muestra('SOBREGIRA SALDO DEL BANCO');</script><? }
 }}
}
$sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); if($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$l_cat=strlen($formato_cat);} else{$formato_presup="";$l_cat=0;}
if($error==0){ $unidad_sol=substr($cod_presup,0, $l_cat);
   if(strlen($cod_presup)==strlen($formato_presup)){ if(verifica_disponibilidad($conn,$cod_presup,$fuente_financ,$fecha,$monto)==0){$error=0;}else{$error=1;}}
    else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD DE CÓDIGO PRESUPUESTARIO INVALIDA');</script><? }
   if($error==0){$sSQL="Select * from PRE095 WHERE cod_fuente_financ='$fuente_financ'";$resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);  if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE FUENTE NO EXISTE');</script><? }}
   if(($error==0)and($monto==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO CODIGO INVALIDO');</script><? }
   if(($error==0)and($tipo_imput_presu=="C")){ if($monto_credito>$monto){ $error=1; ?> <script language="JavaScript"> muestra('MONTO CREDITO INVALIDO');</script><? } }
    else{$monto_credito=0;$ref_imput_presu="00000000";$tipo_imput_presu="P";}
   if(($error==0)and($tipo_imput_presu=="C")){  $sSQL="Select * from PRE010 WHERE (referencia_adicion='$ref_imput_presu') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
     if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO NO EXISTE EN LA EJECUCIÓN DEL CREDITO ADICIONAL');</script><? }
      else{ $registro=pg_fetch_array($resultado);if($registro["disponible"]<$monto_credito) {$error=1; $dispon=$registro["disponible"]; $dispon=formato_monto($dispon); ?> <script language="JavaScript"> muestra('Monto Mayor que Disponibilidad del Crédito Adicional, Disponibilidad: <? echo $dispon; ?> ');</script><? }   }}
}
$resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");  $mvalor=pg_errormessage($conn); $mvalor=substr($mvalor,0,91); if(!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $mvalor; ?>'); </script> <? }
if($error==0){ $sSQL="Select denominacion,cod_contable from pre001 WHERE cod_presup='$cod_presup' and cod_fuente='$fuente_financ'"; ;$resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);  if($filas>0){$registro=pg_fetch_array($resultado,0); $cod_cuentap=$registro["cod_contable"]; } else{$error=1; ?> <script language="JavaScript"> muestra('LOCALIZANDO CÓDIGO PRESUPUESTARIO');</script><? }
$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$num_nota','D','$cod_cuentap','00000','',$monto,'D','B','N','03','0','$descripcion')"); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }
$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$num_nota','C','$codc_banco','00000','',$monto,'D','B','N','03','0','$descripcion')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }
}
if($error==0){  $sql="SELECT * FROM CON010  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";  $res=pg_query($sql);  $t_debe=0; $t_haber=0; $balance=0;
    while($registro=pg_fetch_array($res)){if($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}}
    if($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
    if($balance>0.001){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
    if(($t_debe==0)or($total<>$t_debe)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
}
if($error==0){ if($tasa_idb>0)  {$mstatus="I";$monto_idb=$total_Cheques*($tasa_idb/100); $monto_idb=Round($monto_idb, 2);} else{$cod_cont_idb=""; $mstatus="N"; $monto_idb=0;}    $sfecha=formato_aaaammdd($fecha);
   $sSQL="SELECT INCLUYE_NDB_DIRECTA('$codigo_mov','$cod_banco','$num_nota','$sfecha','$ced_rif',$monto,'N','','$usuario_sia','$minf_usuario','$mstatus',$monto_idb,'$cod_cont_idb','$codc_banco','$cod_cuentap','$cod_presup','$fuente_financ','$tipo_imput_presu','$ref_imput_presu','$func_inv','$unidad_sol',$monto_credito,'$num_proyecto','$tipo_pago','$statusc','$descripcion')";  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error,0,91);
   if(!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
    else{ $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?   $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");  $mvalor=pg_errormessage($conn); $mvalor=substr($mvalor,0,91); if(!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $mvalor; ?>'); </script> <? }  }
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

