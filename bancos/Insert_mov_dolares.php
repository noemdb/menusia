<?include ("../class/conect.php");  include ("../class/funciones.php");include ("../class/configura.inc");   error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"];  $cod_banco=$_POST["txtcod_banco"]; $referencia=$_POST["txtreferencia"]; $tipo_mov=$_POST["txttipo_movimiento"];  
$cod_bancoA=$_POST["txtcod_bancoA"]; $referenciaA=$_POST["txtreferenciaA"]; $fecha=$_POST["txtfecha"]; $ced_rif=$_POST["txtced_rif"]; $descripcion=$_POST["txtdescripcion"];  
$monto=$_POST["txtmonto_mov_libro"]; $monto_bs=$_POST["txtmonto_bs"];$tasa_cambio=$_POST["txttasa_cambio"];$cod_cta_flujo=$_POST["txtcod_cta_flujo"];$cod_presup=""; $tipodc="D";
$monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;} else{$monto=0;}
$monto_bs=formato_numero($monto_bs); if(is_numeric($monto_bs)){$monto_bs=$monto_bs;} else{$monto_bs=0;}
$tasa_cambio=formato_numero($tasa_cambio); if(is_numeric($tasa_cambio)){$tasa_cambio=$tasa_cambio;} else{$tasa_cambio=0;} $monto_bs=$monto*$tasa_cambio;
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$url="Act_Mov_cta_dolares.php?Gcod_banco=C".$cod_banco.$referencia.$tipo_mov;  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
if($error==0){$campo502="NNNNNNNNNNNNNNNNNNNN"; $des_chq=""; $periodom=$SIA_Periodo; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='02'"; $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $periodom=$registro["campo503"]; $des_chq=$registro["campo510"];} $sobreg_saldo=substr($campo502,0,1); $doc_concepto=substr($campo502,5,1); $ret_presup=substr($campo502,6,1); $chq_proceso=substr($campo502,7,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql); if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"];} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
}
if(checkData($fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if(($error==0)and($monto==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE MOVIMIENTO INVALIDO');</script><? }
if(($error==0)and($tasa_cambio==0)){$error=1; ?> <script language="JavaScript"> muestra('TASA DE CAMBIO INVALIDO');</script><? }
if(($error==0)and($monto_bs==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO EN BOLIVARES INVALIDO');</script><? }
if($error==0){$sfecha=formato_aaaammdd($fecha); if(($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){echo $sfecha; $error=1;?><script language="JavaScript">muestra('FECHA DE MOVIMIENTO INVALIDA');</script><?}}
/*
if($error==0){$nmes=substr($fecha,3, 2);  if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}if($periodom>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}}
*/
if($error==0){if(strlen($referencia)==8){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD REFERENCIA MOVIMIENTO INVALIDO');</script><? } }
if($error==0){$sSQL="SELECT cod_banco FROM BAN044 WHERE cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('MOVIMIENTO EN DOLARES YA EXISTE');</script><? }}
if($error==0){$sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}}
if($error==0){$sSQL="SELECT tipo FROM BAN003 WHERE tipo_movimiento='$tipo_mov'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE MOVIMIENTO NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado,0); $tipodc=$registro["tipo"];}}
if($error==0){if(($tipo_mov=="CHQ") Or ($tipo_mov=="REV") Or ($tipo_mov=="ANU") Or ($tipo_mov=="TRD") Or ($tipo_mov=="ANC") Or ($tipo_mov=="AND")Or($tipo_mov=="IDB")) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE MOVIMIENTO INVALIDO');</script><? } }
if($error==0){$nmes=substr($fecha,3, 2); $codc_banco=""; $tasa_idb=0; $cod_cont_idb="";   $total=$monto;
 
 $sSQL="SELECT cod_banco,nombre_banco,nro_cuenta,descripcion_banco,tipo_cuenta,cod_contable,tipo_bco,control_chequera,status_control,activa,fecha_activa,fecha_desactiva,s_inic_libro,deb_libro01,cre_libro01,deb_libro02,cre_libro02,deb_libro03,cre_libro03,deb_libro04,cre_libro04,deb_libro05,cre_libro05,deb_libro06,cre_libro06,deb_libro07,cre_libro07,deb_libro08,cre_libro08,deb_libro09,cre_libro09,deb_libro10,cre_libro10,deb_libro11,cre_libro11,deb_libro12,cre_libro12,campo_str1,campo_str2,campo_num1,campo_num2 FROM ban042 WHERE cod_banco='$cod_banco'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BANCO NO EXISTE');</script><? }
 else {$registro=pg_fetch_array($resultado,0); $codc_banco=$registro["cod_contable"]; $activo=$registro["activa"]; $saldo_ant_libro=$registro["s_inic_libro"]; $tasa_idb=$registro["campo_num1"]; $cod_cont_idb=$registro["campo_str1"]; if($activo=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BANCO NO ESTA ACTIVO');</script><? }
 if($error==0){ $disponible=$saldo_ant_libro;   echo "Saldo Inicial: ".formato_monto($disponible)." ".$nmes,"<br>"; $m=$nmes*1;
 for ($i=1;$i<=$m;$i++){$spos=$i; If($i<=9){$spos="0".$spos;} $disponible=$disponible+$registro["deb_libro".$spos] - $registro["cre_libro".$spos]; }
   if($tipodc=="C"){ if($disponible>$monto){$balance=$disponible-$monto;}else{$balance=$monto-$disponible;}
   if(($disponible<$monto)and($balance>0.001)){if($sobreg_saldo=="N"){$error=1;} echo "Disponible: ".formato_monto($disponible).'  Requerido: '.formato_monto($monto),"<br>"; ?> <script language="JavaScript"> muestra('SOBREGIRA SALDO DEL BANCO');</script><? }}
 }}
}
if($error==0){$sSQL="Select * from BAN043 WHERE codigo_cuenta='$cod_cta_flujo'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('CODIGO CUENTA FLUJO NO EXISTE');</script><?}}
$cod_bancoA=$cod_banco; $referenciaA=$referencia;   $existe_cta="N";
if($error==0){$sfecha=formato_aaaammdd($fecha); if($tipodc=="C"){$tipodca="D";}else{$tipodca="C";}  $DOperacion="0"; if($tipodc=="C"){$AOperacion="03";}else{$AOperacion="01";}
  $sSQL="SELECT ACTUALIZA_BAN044(1,'$codigo_mov','$cod_banco','$referencia','$tipo_mov','$ced_rif','$sfecha','$referenciaA','$cod_bancoA','N','$sfecha',$monto,$monto_bs,$tasa_cambio,'$cod_cta_flujo','$cod_presup','','',0,0,'$usuario_sia','$minf_usuario','$tipodc','N','$tipo_mov','$tipodca','$statusc','$descripcion')";  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
  if(!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
    else{$error=0;?><script language="JavaScript"> muestra('INCLUYO EXITOSAMENTE');</script><? $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");  $mvalor=pg_errormessage($conn); $mvalor=substr($mvalor, 0, 61); if(!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $mvalor; ?>'); </script> <? }  }
}
pg_close();error_reporting(E_ALL ^ E_WARNING); if($error==0){?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <?}?>

