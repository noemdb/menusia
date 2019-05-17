<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");   error_reporting(E_ALL);
$cod_banco=$_POST["txtcod_banco"]; $referencia=$_POST["txtreferencia"]; $tipo_mov=$_POST["txttipo_movimiento"]; $fecha_anu = $_POST["txtfecha_anu"]; $descrip_anu = $_POST["txtdescrip_anu"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR ANULANDO....","<br>"; $error=0; $tipo_pago="0001"; $l_cat=0;
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
if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);  $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer); $afecha=formato_aaaammdd($fecha_anu);
       if (($afecha>$Fec_Fin_Ejer)or($afecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE ANULACION INVALIDA');</script><?}
}
if(($tipo_mov=="NDB")or($tipo_mov=="CHQ")){
  if ($error==0){$sql="SELECT Ano_Fiscal,Mes_Fiscal,nro_comprobante FROM BAN027 Where (Referencia='$referencia') And (Tipo_Mov='$tipo_mov') And (Tipo_Operacion<>'A')"; $resultado=pg_exec($conn,$sql); $filas=pg_numrows($resultado); if($filas>0){$error=1;?><script language="JavaScript">muestra('Existe Comprobante de Retención IVA Asociado al movimiento');</script><?}}
  if ($error==0){$sql="SELECT nro_planilla FROM BAN012 Where (Referencia='$referencia') And (Tipo_Mov='$tipo_mov') And (anulada='N')"; $resultado=pg_exec($conn,$sql); $filas=pg_numrows($resultado); if($filas>0){$error=1;?><script language="JavaScript">muestra('Existe Comprobante de Retención Asociado al movimiento');</script><?}}
} $DOperacion="1";
if($tipodc=="C"){$tipodca="D";$tipo_mova="AND";$AOperacion="03";if($tipo_mov=="CHQ"){$AOperacion="02";$tipo_mova="ANU";}}else{$tipodca="C";$tipo_mova="ANC";$AOperacion="01";if($tipo_mov=="CHQ"){$AOperacion="02";$tipo_mova="ANU";}}
if($mes_conciliacion<>"00"){$error=1; ?><script language="JavaScript">  muestra('MOVIMIENTO EN LIBRO ESTA CONCILIADO');  </script><?}
if(($error==0)and($tipo_mov=="CHQ")){$sSQL="SELECT num_cheque,chq_o_f_c,nro_orden_pago,tipo_pago From BAN006 Where (cod_banco='$cod_banco') And (num_cheque='$referencia')"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if($filas>=1){$reg=pg_fetch_array($resultado); $morden=$reg["nro_orden_pago"]; $tipo_pago=$reg["tipo_pago"]; $chq_o_f_c=$reg["chq_o_f_c"]; if(($chq_o_f_c=="A")or($chq_o_f_c=="O")or($chq_o_f_c=="F")or($chq_o_f_c=="P")or($chq_o_f_c=="B")){$tipo_chq=$chq_o_f_c;}} else{$error=1; ?><script language="JavaScript">  muestra('NÚMERO DE CHEQUE NO EXISTE EN ESTADO DE CHEQUES');  </script><?}
}
if(($error==0)and($tipo_mov=="NDB")){ if($por_emision=="A"){$por_emision="S";} }
if($error==0){ $sfecha=$fecha; $sfechaa=$fecha_anu; $proceso=0;  $proceso=0;
  if($tipo_mov=="CHQ"){$proceso=1;   echo $tipo_chq;
    if($tipo_chq=="F"){$sSQL="SELECT ANULA_CHQ_FINANCIEROS('$cod_banco','$referencia','$sfecha',$monto,'$afecha','N','','$usuario_sia','$minf_usuario','$statusc','$descrip_anu')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61); }
    if($tipo_chq=="P"){$sSQL="SELECT ANULA_CHQ_PER_ANT('$cod_banco','$referencia','$sfecha',$monto,'$afecha','N','','$usuario_sia','$minf_usuario','$statusc','$referenciaa','$descrip_anu')"; $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror=substr($merror,0,91);  }
    if($tipo_chq=="O"){$sSQL="SELECT ANULA_CHQ_ORDEN('$cod_banco','$referencia','$sfecha',$monto,'$afecha','N','','$usuario_sia','$minf_usuario',$l_cat,'$tipo_pago','$statusc','$descrip_anu')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61); } 
	if($tipo_chq=="B"){$sSQL="SELECT ANULA_CHQ_ABONA_ORDEN('$cod_banco','$referencia','$sfecha',$monto,'$afecha','N','','$usuario_sia','$minf_usuario',$l_cat,'$tipo_pago','$statusc','$morden','$descrip_anu')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61); } }	
  if(($tipo_mov=="NDB")and($por_emision<>"N")){$proceso=1; $tipo_pago="0".substr($cod_bancoa,1,3); $tipo_chq=substr($cod_bancoa,0, 1);  $unidad_sol=""; $func_inv="F"; $num_proyecto="0000000000";
    if($tipo_chq=="D"){ $sSQL="SELECT unidad_sol,ced_rif,num_proyecto,func_inv FROM PRE006 WHERE referencia_Comp='$referencia' And tipo_Compromiso='0000' And cod_comp='$cod_banco'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado); if($filas>=1){ $reg=pg_fetch_array($resultado); $unidad_sol=$reg["unidad_sol"]; $func_inv=$reg["func_inv"]; $num_proyecto=$reg["num_proyecto"];}
    $sSQL="SELECT ANULA_NDB_DIRECTA('$cod_banco','$referencia','$sfecha',$monto,'$afecha','N','','$usuario_sia','$minf_usuario','$unidad_sol','$tipo_pago','$num_proyecto','$func_inv','$statusc','$descrip_anu')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61); }
    else{ 
	   if($tipo_chq=="A"){ $sSQL="SELECT ANULA_NDB_ABONA_ORDEN('$cod_banco','$referencia','$sfecha',$monto,'$afecha','N','','$usuario_sia','$minf_usuario',$l_cat,'$tipo_pago','$statusc','$referenciaa','$descrip_anu')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);  }
	     else{if($tipo_chq=="P"){$sSQL="SELECT ANULA_NDB_PER_ANT('$cod_banco','$referencia','$sfecha',$monto,'$referenciaa')"; $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror=substr($merror,0,91);   }
         else{ $sSQL="SELECT ANULA_NDB_ORDEN('$cod_banco','$referencia','$sfecha',$monto,'$afecha','N','','$usuario_sia','$minf_usuario',$l_cat,'$tipo_pago','$statusc','$descrip_anu')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61); }
	   } 
	
	}
   // echo $sSQL,"<br>";
  }
  if($proceso==0){$sSQL="SELECT ACTUALIZA_BAN004(4,'$referencia','$cod_banco','$referencia','$tipo_mov','$ced_rif','$sfecha','$referenciaa','$cod_bancoa','S','$sfechaa',$monto,'00','$AOperacion','$DOperacion','N','N','N','','$usuario_sia','$minf_usuario','$tipodc','N','$tipo_mova','$tipodca','$statusc','$descrip_anu')"; $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61); }
  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ANULO EXITOSAMENTE'); </script><?
    $desc_doc="MOVIMIENTO EN LIBRO, BANCO:".$cod_banco.", REFERENCIA:".$referencia.", TIPO MOVIMIENTO:".$tipo_mov.", DESCRIPCION:".$descripcion;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Anulo','$sfecha','$desc_doc')");
    $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } }
}
pg_close(); error_reporting(E_ALL ^ E_WARNING); 
if($error==0){?><script language="JavaScript">window.close(); window.opener.location.reload();</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? } 
?>
