<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");   error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"];  $cod_banco=$_POST["txtcod_banco"]; $referencia=$_POST["txtreferencia"]; $tipo_mov=$_POST["txttipo_mov"];
$cod_bancoA=$_POST["txtcod_banco"]; $referenciaA=$_POST["txtreferencia"]; $fechac=$_POST["txtfecha"];
$fecha=$_POST["txtfecha_mov"];  $descripcion=$_POST["txtdescripcion"];  $monto=$_POST["txtmonto"]; $benef_mov_banco=$_POST["txtbeneficiario"];  $tipodc="D";
$monto_d=$_POST["txtmonto_d"]; $monto_h=$_POST["txtmonto_h"]; $solop=$_POST["txtsolop"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$url="Det_carga_libros.php?codigo_mov=".$codigo_mov."&cod_banco=".$cod_banco."&fecha=".$fechac."&monto_d=".$monto_d."&monto_h=".$monto_h."&solop=".$solop;   $monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;} else{$monto=0;}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
if($error==0){$campo502="NNNNNNNNNNNNNNNNNNNN"; $des_chq=""; $periodom=$SIA_Periodo; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='02'"; $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $periodom=$registro["campo503"]; $des_chq=$registro["campo510"];} $sobreg_saldo=substr($campo502,0,1); $doc_concepto=substr($campo502,5,1); $ret_presup=substr($campo502,6,1); $chq_proceso=substr($campo502,7,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql); if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"];} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
}
$fecha_desde=colocar_pdiames($fechac);
if(($error==0)and($monto==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DE MOVIMIENTO INVALIDO');</script><? }
if($error==0){$sfecha=formato_aaaammdd($fecha); if(($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){echo $sfecha; $error=1;?><script language="JavaScript">muestra('FECHA DE MOVIMIENTO INVALIDA, FUERA DEL PERIODO FISCAL');</script><?}}
if($error==0){$sfechac=formato_aaaammdd($fechac); if($sfecha>$sfechac){echo $fechac; $error=1;?><script language="JavaScript">muestra('FECHA DE MOVIMIENTO MAYOR A FECHA DE CONCILIACION');</script><?}}
if($error==0){$sfechad=formato_aaaammdd($fecha_desde); if($sfecha<$sfechad){echo $fechac; $error=1;?><script language="JavaScript">muestra('FECHA DE MOVIMIENTO MENOR A FECHA DE CONCILIACION');</script><?}}

if($error==0){$nmes=substr($fecha,3, 2);  if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}if($periodom>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}}
if($error==0){if(strlen($referencia)==8){$error=0;} else{$error=1; ?> <script language="JavaScript"> muestra('LONGITUD MOVIMIENTO INVALIDO');</script><? } }
if($error==0){$sSQL="SELECT cod_banco FROM BAN005 WHERE cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_banco='$tipo_mov'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('MOVIMIENTO EN BANCO YA EXISTE');</script><? }}
if($error==0){$sSQL="SELECT tipo FROM BAN003 WHERE tipo_movimiento='$tipo_mov'";  $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE MOVIMIENTO NO EXISTE');</script><?} else{$registro=pg_fetch_array($resultado,0); $tipodc=$registro["tipo"];}}
if($error==0){if(($tipo_mov=="REV") Or ($tipo_mov=="ANU") Or ($tipo_mov=="ANC") Or ($tipo_mov=="AND")) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE MOVIMIENTO INVALIDO');</script><? } }
if($error==0){$nmes=substr($fecha,3, 2); $codc_banco=""; $tasa_idb=0; $cod_cont_idb="";   $total=$monto;
 $sSQL="SELECT cod_banco,nombre_banco,nro_cuenta,descripcion_banco,tipo_cuenta,cod_contable,tipo_bco,control_chequera,status_control,activa,fecha_activa,fecha_desactiva,s_inic_libro,deb_libro01,cre_libro01,deb_libro02,cre_libro02,deb_libro03,cre_libro03,deb_libro04,cre_libro04,deb_libro05,cre_libro05,deb_libro06,cre_libro06,deb_libro07,cre_libro07,deb_libro08,cre_libro08,deb_libro09,cre_libro09,deb_libro10,cre_libro10,deb_libro11,cre_libro11,deb_libro12,cre_libro12,campo_str1,campo_str2,campo_num1,campo_num2 FROM ban002 WHERE cod_banco='$cod_banco'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE BANCO NO EXISTE');</script><? }
 else {$registro=pg_fetch_array($resultado,0); $codc_banco=$registro["cod_contable"]; $activo=$registro["activa"]; $saldo_ant_libro=$registro["s_inic_libro"]; $tasa_idb=$registro["campo_num1"]; $cod_cont_idb=$registro["campo_str1"]; if($activo=="N"){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO NO ESTA ACTIVO');</script><? }
 if($error==0){$disponible=$saldo_ant_libro; for ($i=1;$i<=$nmes;$i++){$spos=$i; If($i<=9){$spos="0".$spos;} $disponible=$disponible+$registro["deb_libro".$spos] - $registro["cre_libro".$spos]; } }}
}
if($error==0){$sfecha=formato_aaaammdd($fecha); if($tipodc=="C"){$tipodca="D";}else{$tipodca="C";}  $DOperacion="0"; if($tipodc=="C"){$AOperacion="03";}else{$AOperacion="01";}
  $sSQL="SELECT ACTUALIZA_BAN005(1,'$cod_banco','$referencia','$tipo_mov','$sfecha','N','$sfecha',$monto,'00','$benef_mov_banco','$minf_usuario','$tipodc','N','$tipo_mov','$tipodca','$descripcion')";  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error, 0, 61);
  if(!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
  else{$error=0; $sSQL="SELECT ACT_MES_BAN035('$codigo_mov','$cod_banco','$referencia','$tipo_mov','00','$sfecha')";  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error, 0, 61); }  }
pg_close();error_reporting(E_ALL ^ E_WARNING);
?><script language="JavaScript">document.location ='<? echo $url; ?>';</script> 