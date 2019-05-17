<?include ("../class/conect.php");  include ("../class/funciones.php"); ?>
<?php include ("../class/configura.inc");   error_reporting(E_ALL);
$cod_banco=$_POST["txtcod_banco"]; $referencia=$_POST["txtreferencia"]; $tipo_mov=$_POST["txttipo_movimiento"]; $fecha_anu=$_POST["txtfecha_anu"]; $descrip_anu=$_POST["txtdescrip_anu"];
$ref_dep=$_POST["txtref_dep"]; $ref_nota=$_POST["txtref_nota"]; $monto_nota=$_POST["txtmonto_nota"]; $monto_dep=$_POST["txtmonto_dep"];
$cod_contab_ban="";  $cod_contab_rev="1-1-1-03-01-01-01"; $cod_contab_rev=$_POST["txtCodigo_Cuenta"]; $tipom=$_POST["txttipo_mov"];
$monto_nota=formato_numero($monto_nota); if(is_numeric($monto_nota)){$monto_nota=$monto_nota;} else{$monto_nota=0;}
$monto_dep=formato_numero($monto_dep); if(is_numeric($monto_dep)){$monto_dep=$monto_dep;} else{$monto_dep=0;}
$cod_banco_new=$_POST["txtcod_bancoA"]; $cod_contab_new="";

$equipo = getenv("COMPUTERNAME"); $minf_usuario = $equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0; $tipo_pago="0001"; $l_cat=0;
$url="Act_Mov_Libros.php?Gcod_banco=C".$cod_banco.$referencia.$tipo_mov;  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
if($error==0){$l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'"; $resultado=pg_query($sql); if($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"]; $l_cat=strlen($formato_cat);}
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $des_chq=""; $periodom=$SIA_Periodo; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='02'"; $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $periodom=$registro["campo503"]; $des_chq=$registro["campo510"];}
    $sobreg_saldo=substr($campo502,0,1); $doc_concepto=substr($campo502,5,1); $ret_presup=substr($campo502,6,1); $chq_proceso=substr($campo502,7,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"];} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
} $anulado='N';
if($error==0){$sSQL="SELECT * FROM BAN004 WHERE cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('MOVIMIENTO EN LIBRO NO EXISTE');</script><? }
else{$registro=pg_fetch_array($resultado);  $anulado=$registro["anulado"]; $mes_conciliacion=$registro["mes_conciliacion"]; $fecha_anulado=$registro["fecha_anulado"];  $fecha=$registro["fecha_mov_libro"]; $monto=$registro["monto_mov_libro"]; $descripcion=$registro["descrip_mov_libro"];  $por_emision=$registro["por_emision"]; $ced_rif=$registro["ced_rif"]; $cod_bancoa=$registro["cod_bancoa"]; $referenciaa=$registro["referenciaa"]; $tipo_chq="N"; }}
if($anulado=='S'){$error=1;?><script language="JavaScript">muestra('MOVIMIENTO ESTA ANULADO');</script><?}
if($error==0){$sfecha=$fecha; if (checkData($fecha_anu)=='1'){$error=0;$afecha=formato_aaaammdd($fecha_anu);} else{$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO ES VALIDA');</script><? } }
if($error==0){if($afecha<$sfecha){$error=1; ?> <script language="JavaScript">muestra('FECHA ANULACION NO PUEDE SER MENOR A FECHA DEL MOVIMIENTO');</script><? } }
if($error==0){$nmes=substr($fecha_anu,3, 2); if ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE ANULACION MENOR A ULTIMO PERIODO CERRADO');</script><?}}
if($error==0){$sSQL="SELECT tipo FROM BAN003 WHERE tipo_movimiento='$tipo_mov'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE MOVIMIENTO NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado,0); $tipodc=$registro["tipo"];}}
if($error==0){if(($tipo_mov=="ANU") Or ($tipo_mov=="TRD") Or ($tipo_mov=="ANC") Or ($tipo_mov=="AND")) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE MOVIMIENTO INVALIDO');</script><? } }
if($error==0){$nmes=substr($fecha_anu,3, 2);  if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}if($periodom>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}}
if($tipom=="DEP. OTRO BANCO"){
if($error==0){ $sSQL="SELECT cod_banco,nombre_banco,nro_cuenta,descripcion_banco,tipo_cuenta,cod_contable,tipo_bco,control_chequera,status_control,activa,fecha_activa,fecha_desactiva,s_inic_libro,deb_libro01,cre_libro01,deb_libro02,cre_libro02,deb_libro03,cre_libro03,deb_libro04,cre_libro04,deb_libro05,cre_libro05,deb_libro06,cre_libro06,deb_libro07,cre_libro07,deb_libro08,cre_libro08,deb_libro09,cre_libro09,deb_libro10,cre_libro10,deb_libro11,cre_libro11,deb_libro12,cre_libro12,campo_str1,campo_str2,campo_num1,campo_num2 FROM ban002 WHERE cod_banco='$cod_banco_new'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO DEPOSITO NO EXISTE');</script><? }
   else {$registro=pg_fetch_array($resultado,0); $cod_contab_new=$registro["cod_contable"]; $activo=$registro["activa"];  if($activo=="N"){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO DEPOSITO NO ESTA ACTIVO');</script><? } }
}
}else{ $cod_banco_new=$cod_banco;
if(($error==0)and($monto_nota==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE NOTA INVALIDO');</script><? }
if(($error==0)and($monto<=$monto_nota)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DEPOSITO NO PUEDE SER MENOR A MONTO NOTA');</script><? }
}
if($error==0){$sSQL="SELECT cod_banco FROM BAN004 WHERE cod_banco='$cod_banco_new' and referencia='$ref_dep' and tipo_mov_libro='$tipo_mov'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('MOVIMIENTO EN LIBRO YA EXISTE');</script><? }}
if($error==0){ $DOperacion="0"; $tipodca="C";$tipo_mova="ANC";$AOperacion="01";
 $sSQL="SELECT cod_banco,nombre_banco,nro_cuenta,descripcion_banco,tipo_cuenta,cod_contable,tipo_bco,control_chequera,status_control,activa,fecha_activa,fecha_desactiva,s_inic_libro,deb_libro01,cre_libro01,deb_libro02,cre_libro02,deb_libro03,cre_libro03,deb_libro04,cre_libro04,deb_libro05,cre_libro05,deb_libro06,cre_libro06,deb_libro07,cre_libro07,deb_libro08,cre_libro08,deb_libro09,cre_libro09,deb_libro10,cre_libro10,deb_libro11,cre_libro11,deb_libro12,cre_libro12,campo_str1,campo_str2,campo_num1,campo_num2 FROM ban002 WHERE cod_banco='$cod_banco'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO NO EXISTE');</script><? }
 else {$registro=pg_fetch_array($resultado,0); $cod_contab_ban=$registro["cod_contable"]; $activo=$registro["activa"]; $saldo_ant_libro=$registro["s_inic_libro"]; $tasa_idb=$registro["campo_num1"]; $cod_cont_idb=$registro["campo_str1"]; if($activo=="N"){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO NO ESTA ACTIVO');</script><? } }
}
if($error==0){ $sSQL="Select * from con001 WHERE codigo_cuenta='$cod_contab_rev'"; $resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
 if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO CONTABLE DE ANULACION NO EXISTE');</script><? }
  else{$registro=pg_fetch_array($resultado);if ($registro["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO CONTABLE DE ANULACION NO ES CARGABLE');</script><?}}
}
if($mes_conciliacion<>"00"){$error=1; ?><script language="JavaScript">  muestra('MOVIMIENTO EN LIBRO ESTA CONCILIADO');  </script><?}
if($error==0){ $sfecha=$fecha; $sfechaa=$afecha; $proceso=0;
  if($tipom=="NOTA DEBITO"){$monto=$monto+$monto_nota; $sSQL="SELECT REVERSA_DEP_NDB('$referencia','$ref_nota','$cod_banco','$ref_dep','$tipo_mov','$ced_rif','$sfechaa','$referenciaa','$cod_bancoa','S','$sfechaa',$monto,'00','$AOperacion','$DOperacion','N','N','N','','$usuario_sia','$minf_usuario','$tipodc','N','$tipo_mova','$tipodca','$statusc','$cod_contab_ban','$cod_contab_rev','',$monto_nota,$monto_dep,'$descrip_anu')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61); }
  if($tipom=="NOTA CREDITO"){$monto=$monto-$monto_nota; $sSQL="SELECT REVERSA_DEP_NCR('$referencia','$ref_nota','$cod_banco','$ref_dep','$tipo_mov','$ced_rif','$sfechaa','$referenciaa','$cod_bancoa','S','$sfechaa',$monto,'00','$AOperacion','$DOperacion','N','N','N','','$usuario_sia','$minf_usuario','$tipodc','N','$tipo_mova','$tipodca','$statusc','$cod_contab_ban','$cod_contab_rev','',$monto_nota,$monto_dep,'$descrip_anu')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61); }
  if($tipom=="DEP. OTRO BANCO"){$sSQL="SELECT REVERSA_DEP_TRANS('$referencia','$ref_nota','$cod_banco_new','$ref_dep','$tipo_mov','$ced_rif','$sfechaa','$referenciaa','$cod_bancoa','S','$sfechaa',$monto,'00','$AOperacion','$DOperacion','N','N','N','','$usuario_sia','$minf_usuario','$tipodc','N','$tipo_mova','$tipodca','$statusc','$cod_contab_new','$cod_contab_rev','$cod_contab_ban','$cod_banco','$descrip_anu')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61); }

  echo $sSQL;
  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ANULO EXITOSAMENTE'); </script><?
    $desc_doc="MOVIMIENTO EN LIBRO, BANCO:".$cod_banco.", REFERENCIA:".$referencia.", TIPO MOVIMIENTO:".$tipo_mov.", DESCRIPCION:".$descripcion;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Anulo','$sfecha','$desc_doc')");
    $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } }
}
pg_close();error_reporting(E_ALL ^ E_WARNING);

if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }

?>