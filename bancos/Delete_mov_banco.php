<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc");
$cod_banco=$_GET["cod_banco"]; $referencia=$_GET["referencia"]; $tipo_mov=$_GET["tipo_mov"]; $equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");   $tipo_pago="0001";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";   $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$Nom_Emp=busca_conf();  $error=0; $sSQL="SELECT * FROM BAN005 WHERE cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_banco='$tipo_mov'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?><script language="JavaScript">  muestra('MOVIMIENTO EN BANCO NO EXISTE');  </script><?}
   else{$registro=pg_fetch_array($resultado); $adescripcion=$registro["des_mov_banco"]; $mes_conciliacion=$registro["mes_conciliacion"]; $fecha_mov=$registro["fecha_mov_banco"]; $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $monto=$registro["monto_mov_banco"]; $benef_mov_banco=$registro["benef_mov_banco"]; $error=0; $tipo_chq="N";}
  if($error==0){$campo502="NNNNNNNNNNNNNNNNNNNN"; $des_chq=""; $periodom=$SIA_Periodo; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='02'"; $resultado=pg_query($sql);
    if($reg=pg_fetch_array($resultado,0)){$campo502=$reg["campo502"]; $periodom=$reg["campo503"]; $des_chq=$reg["campo510"];} $sobreg_saldo=substr($campo502,0,1); $doc_concepto=substr($campo502,5,1); $ret_presup=substr($campo502,6,1); $chq_proceso=substr($campo502,7,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql); if($reg=pg_fetch_array($resultado,0)){$campo502=$reg["campo502"];} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
  }
  if($error==0){$sSQL="Select descrip_tipo_mov,tipo from ban003 WHERE tipo_movimiento='$tipo_mov'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE MOVIMIENTO NO EXISTE');</script><?} else{$reg=pg_fetch_array($resultado); $tipodc=$reg["tipo"];} }
  if($error==0){if(($tipo_mov=="ANU")Or($tipo_mov=="REV")Or($tipo_mov=="ANC")Or($tipo_mov=="AND")) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE MOVIMIENTO NO PUEDE SER ELIMINADO');</script><? }}
  if($error==10){$nmes=substr($fecha_mov,5, 2);  if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}if($periodom>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}}
  if($error==0){if($mes_conciliacion<>"00"){$error=1; ?><script language="JavaScript">  muestra('MOVIMIENTO EN BANCO ESTA CONCILIADO');  </script><?}
  if($error==0){ $sSQL="select * from ban010 where cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_trans='$tipo_mov' and tipo_registro='3'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas>0){$error=1; ?><script language="JavaScript">  muestra('MOVIMIENTO EXISTE EN CONCILIACION COMO TRANSITO');  </script><?} }  }
  if($error==0){$DOperacion="1";
      if($tipodc=="C"){$tipodca="D";$tipo_mova="AND";$AOperacion="03";if($tipo_mov=="CHQ"){$AOperacion="02";$tipo_mova="ANU";}}else{$tipodca="C";$tipo_mova="ANC";$AOperacion="01";if($tipo_mov=="CHQ"){$AOperacion="02";$tipo_mova="ANU";}}
      if($error==0){ $sfecha=$fecha_mov; $sfechaa=$fecha_anulado; $proceso=0;  echo $tipo_mova;
       $sSQL="SELECT ACTUALIZA_BAN005(3,'$cod_banco','$referencia','$tipo_mov','$sfecha','$anulado','$sfechaa',$monto,'00','$benef_mov_banco','$minf_usuario','$tipodc','$anulado','$tipo_mova','$tipodca','$adescripcion')";  $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
       if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
          $desc_doc="MOVIMIENTO EN BANCO, BANCO:".$cod_banco.", REFERENCIA:".$referencia.", TIPO MOVIMIENTO:".$tipo_mov.", DESCRIPCION:".$adescripcion;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
          $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } } }
  }
}pg_close(); ?>  <script language="JavaScript"> window.close(); window.opener.location.reload(); </script>