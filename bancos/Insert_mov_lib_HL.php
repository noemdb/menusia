<?include ("../class/conect.php");  include ("../class/funciones.php"); ?>
<?php include ("../class/configura.inc");   error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"];  $cod_banco=$_POST["txtcod_banco"]; $referencia=$_POST["txtreferencia"]; $tipo_mov=$_POST["txttipo_movimiento"];  $cod_bancoA=$_POST["txtcod_bancoA"]; $referenciaA=$_POST["txtreferenciaA"];
$fecha=$_POST["txtfecha"]; $ced_rif=$_POST["txtced_rif"]; $descripcion=$_POST["txtdescripcion"];  $monto=$_POST["txtmonto_mov_libro"];  $tipodc="D";
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$url="Act_Mov_Libros.php?Gcod_banco=C".$cod_banco.$referencia.$tipo_mov;   $monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;} else{$monto=0;}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
if($error==0){$campo502="NNNNNNNNNNNNNNNNNNNN"; $des_chq=""; $periodom=$SIA_Periodo; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='02'"; $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $periodom=$registro["campo503"]; $des_chq=$registro["campo510"];} $sobreg_saldo=substr($campo502,0,1); $doc_concepto=substr($campo502,5,1); $ret_presup=substr($campo502,6,1); $chq_proceso=substr($campo502,7,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql); if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"];} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
}
if(checkData($fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if(($error==0)and($monto==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE MOVIMIENTO INVALIDO');</script><? }
if($error==0){$sfecha=formato_aaaammdd($fecha); if(($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){echo $sfecha; $error=1;?><script language="JavaScript">muestra('FECHA DE MOVIMIENTO INVALIDA');</script><?}}

if($error==0){$nmes=substr($fecha,3, 2);  if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}if($periodom>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}}

if($error==0){if(strlen($referencia)==8){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD MOVIMIENTO INVALIDO');</script><? } }
if($error==0){$sSQL="SELECT cod_banco FROM BAN004 WHERE cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('MOVIMIENTO EN LIBRO YA EXISTE');</script><? }}
if($error==0){$sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('CÉDULA/RIF BENEFICIARIO NO EXISTE');</script><?}}
if($error==0){$sSQL="SELECT tipo FROM BAN003 WHERE tipo_movimiento='$tipo_mov'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE MOVIMIENTO NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado,0); $tipodc=$registro["tipo"];}}
if($error==0){if(($tipo_mov=="CHQ") Or ($tipo_mov=="REV") Or ($tipo_mov=="ANU") Or ($tipo_mov=="TRD") Or ($tipo_mov=="ANC") Or ($tipo_mov=="AND")Or($tipo_mov=="IDB")) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE MOVIMIENTO INVALIDO');</script><? } }
if($error==0){$tipo_comp="B".$cod_banco;   $sSql="Select * from con002 where text(fecha)='$sfecha' and referencia='$referencia' and tipo_comp='$tipo_comp'";  $resultado=pg_query($sSql);  $filas=pg_num_rows($resultado);  if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE YA EXISTE');</script><? }}
if($error==0){$nmes=substr($fecha,5, 2); $codc_banco=""; $tasa_idb=0; $cod_cont_idb="";   $total=$monto;
 $sSQL="SELECT cod_banco,nombre_banco,nro_cuenta,descripcion_banco,tipo_cuenta,cod_contable,tipo_bco,control_chequera,status_control,activa,fecha_activa,fecha_desactiva,s_inic_libro,deb_libro01,cre_libro01,deb_libro02,cre_libro02,deb_libro03,cre_libro03,deb_libro04,cre_libro04,deb_libro05,cre_libro05,deb_libro06,cre_libro06,deb_libro07,cre_libro07,deb_libro08,cre_libro08,deb_libro09,cre_libro09,deb_libro10,cre_libro10,deb_libro11,cre_libro11,deb_libro12,cre_libro12,campo_str1,campo_str2,campo_num1,campo_num2 FROM ban002 WHERE cod_banco='$cod_banco'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO NO EXISTE');</script><? }
 else {$registro=pg_fetch_array($resultado,0); $codc_banco=$registro["cod_contable"]; $activo=$registro["activa"]; $saldo_ant_libro=$registro["s_inic_libro"]; $tasa_idb=$registro["campo_num1"]; $cod_cont_idb=$registro["campo_str1"]; if($activo=="N"){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO NO ESTA ACTIVO');</script><? }
 if($error==0){$disponible=$saldo_ant_libro; for ($i=1;$i<=$nmes;$i++){$spos=$i; If($i<=9){$spos="0".$spos;} $disponible=$disponible+$registro["deb_libro".$spos] - $registro["cre_libro".$spos]; }
  if($tipodc=="C"){if($disponible<$monto){if($sobreg_saldo=="N"){$error=1;} echo "Disponible: ".formato_monto($disponible).'  Requerido: '.formato_monto($monto),"<br>"; ?> <script language="JavaScript"> muestra('SOBREGIRA SALDO DEL BANCO');</script><? }}
 }}
}
if(($error==0)and($tipo_mov=="CAN")){
$sSQL="SELECT cod_banco FROM BAN004 WHERE cod_banco='$cod_banco' and referencia='$referencia' and (tipo_mov_libro='CHQ' OR tipo_mov_libro='NDB')"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CHEQUE O NOTA DEBITO EXISTE EN MOVIMIENTO EN LIBROS');</script><? }
$sSQL="SELECT cod_banco FROM BAN005 WHERE cod_banco='$cod_banco' and referencia='$referencia' and (tipo_mov_banco='CHQ' or tipo_mov_banco='NDB')"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('CHEQUE O NOTA DEBITO EXISTE EN MOVIMIENTO EN BANCOS');</script><? }
$sSQL="SELECT cod_banco FROM BAN007 WHERE cod_banco='$cod_banco' and referencia='$referencia' and (tipo_trans_libro='CHQ' or tipo_trans_libro='NDB')"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CHEQUE O NOTA DEBITO NO EXISTE EN TRANSITO LIBROS');</script><? } 
}
if(($error==0)and($tipo_mov=="DAN")){
$sSQL="SELECT cod_banco FROM BAN004 WHERE cod_banco='$cod_banco' and referencia='$referencia' and (tipo_mov_libro='DEP' OR tipo_mov_libro='NCR' or tipo_mov_libro='TDB' or tipo_mov_libro='TCR')"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('DEPOSITO O NOTA CREDITO EXISTE EN MOVIMIENTO EN LIBROS');</script><? }
$sSQL="SELECT cod_banco FROM BAN005 WHERE cod_banco='$cod_banco' and referencia='$referencia' and (tipo_mov_banco='DEP' or tipo_mov_banco='NCR' or tipo_mov_banco='TDB' or tipo_mov_banco='TCR')"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('DEPOSITO O NOTA CREDITO EXISTE EN MOVIMIENTO EN BANCOS');</script><? }
$sSQL="SELECT cod_banco FROM BAN007 WHERE cod_banco='$cod_banco' and referencia='$referencia' and (tipo_trans_libro='DEP' or tipo_trans_libro='NCR' or tipo_trans_libro='TDB' or tipo_trans_libro='TCR')"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('DEPOSITO O NOTA CREDITO NO EXISTE EN TRANSITO LIBROS');</script><? } 
}
if(($error==0)and($tipo_mov=="TRC")){
if(strlen($referenciaA)==8){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD MOVIMIENTO A DEBITAR INVALIDA');</script><? }
if($error==0){$sSQL="SELECT cod_banco,cod_contable,activa,fecha_activa,fecha_desactiva FROM ban002 WHERE cod_banco='$cod_bancoA'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO A DEBITAR NO EXISTE');</script><? }
 else{$registro=pg_fetch_array($resultado,0); $codc_bancoA=$registro["cod_contable"]; $activoA=$registro["activa"]; if($activoA=="N"){$error=1; ?> <script language="JavaScript"> muestra('BANCO A DEBITAR NO ESTA ACTIVO');</script><? } } }
if($error==0){if($cod_bancoA==$cod_banco){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO A DEBITAR NO PUEDE SER EL MISMO');</script><? } }
if($error==0){$sSQL="SELECT cod_banco FROM BAN004 WHERE cod_banco='$cod_bancoA' and referencia='$referenciaA' and tipo_mov_libro='TRD'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('MOVIMIENTO A DEBITAR YA EXISTE');</script><? }}
} else{$cod_bancoA=$cod_banco; $referenciaA=$referencia;}
if($error==0){  $sql="SELECT * FROM CON010  where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";  $res=pg_query($sql);  $t_debe=0; $t_haber=0; $balance=0;
  while($registro=pg_fetch_array($res)){if($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];}}
    if($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
    if($balance>0.001){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
    if(($t_debe==0)or($t_haber==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
   if($error==0){  if(($total<>$t_debe)){$error=0; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? } }
}
if($error==0){$sfecha=formato_aaaammdd($fecha); if($tipodc=="C"){$tipodca="D";}else{$tipodca="C";}  $DOperacion="0"; if($tipodc=="C"){$AOperacion="03";}else{$AOperacion="01";}
  $sSQL="SELECT ACTUALIZA_BAN004(1,'$codigo_mov','$cod_banco','$referencia','$tipo_mov','$ced_rif','$sfecha','$referenciaA','$cod_bancoA','N','$sfecha',$monto,'00','$AOperacion','$DOperacion','N','N','N','','$usuario_sia','$minf_usuario','$tipodc','N','$tipo_mov','$tipodca','$statusc','$descripcion')";  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
  if(!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
    else{$error=0;?><script language="JavaScript"> muestra('INCLUYO EXITOSAMENTE');</script><? $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");  $mvalor=pg_errormessage($conn); $mvalor=substr($mvalor, 0, 61); if(!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $mvalor; ?>'); </script> <? }  }
}
pg_close();error_reporting(E_ALL ^ E_WARNING); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <?}?>
