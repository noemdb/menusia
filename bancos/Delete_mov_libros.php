<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc");
$cod_banco=$_GET["cod_banco"]; $referencia=$_GET["referencia"]; $tipo_mov=$_GET["tipo_mov"]; $equipo=getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a");   $tipo_pago="0001";
echo "ESPERE POR FAVOR ELIMINANDO....","<br>";   $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { ?> <script language="JavaScript"> muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');  </script> <?}
 else{$Nom_Emp=busca_conf();  $error=0; $sSQL="SELECT * FROM BAN004 WHERE cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
  if ($filas==0){$error=1; ?><script language="JavaScript">  muestra('MOVIMIENTO EN LIBRO NO EXISTE');  </script><?}
   else{$registro=pg_fetch_array($resultado); $adescripcion=$registro["descrip_mov_libro"]; $por_emision=$registro["por_emision"]; $mes_conciliacion=$registro["mes_conciliacion"]; $fecha_mov=$registro["fecha_mov_libro"]; $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $monto=$registro["monto_mov_libro"]; $ced_rif=$registro["ced_rif"]; $cod_bancoa=$registro["cod_bancoa"]; $referenciaa=$registro["referenciaa"]; $error=0; $tipo_chq="N";}
  if($error==0){$campo502="NNNNNNNNNNNNNNNNNNNN"; $des_chq=""; $periodom=$SIA_Periodo; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='02'"; $resultado=pg_query($sql);
    if($reg=pg_fetch_array($resultado,0)){$campo502=$reg["campo502"]; $periodom=$reg["campo503"]; $des_chq=$reg["campo510"];} $sobreg_saldo=substr($campo502,0,1); $doc_concepto=substr($campo502,5,1); $ret_presup=substr($campo502,6,1); $chq_proceso=substr($campo502,7,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql); if($reg=pg_fetch_array($resultado,0)){$campo502=$reg["campo502"];} $valida_c=substr($campo502,2,1); $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
  }
  if($error==0){$sSQL="Select descrip_tipo_mov,tipo from ban003 WHERE tipo_movimiento='$tipo_mov'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado); if($filas==0){$error=1;?><script language="JavaScript">muestra('TIPO DE MOVIMIENTO NO EXISTE');</script><?} else{$reg=pg_fetch_array($resultado); $tipodc=$reg["tipo"];} }
  if($error==0){if(($tipo_mov=="TRD")Or($tipo_mov=="ANU")Or($tipo_mov=="TRD")Or($tipo_mov=="ANC")Or($tipo_mov=="AND")Or($tipo_mov=="IDB")) {$error=1; ?> <script language="JavaScript"> muestra('TIPO DE MOVIMIENTO NO PUEDE SER ELIMINADO');</script><? }}
  if($error==0){$nmes=substr($fecha_mov,5, 2);if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}
  if($periodom>$nmes){echo $periodom.' '.$nmes.' '.$fecha_mov;$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}}
  if(($tipo_mov=="NDB")or($tipo_mov=="CHQ")){
    if ($error==0){$sql="SELECT Ano_Fiscal,Mes_Fiscal,nro_comprobante FROM BAN027 Where (Referencia='$referencia') And (Tipo_Mov='$tipo_mov')"; $resultado=pg_exec($conn,$sql); $filas=pg_numrows($resultado); if($filas>0){$error=1;?><script language="JavaScript">muestra('Existe Comprobante de Retencion IVA Asociado al movimiento');</script><?}}
    if ($error==0){$sql="SELECT nro_planilla FROM BAN012 Where (Referencia='$referencia') And (Tipo_Mov='$tipo_mov')"; $resultado=pg_exec($conn,$sql); $filas=pg_numrows($resultado); if($filas>0){$error=1;?><script language="JavaScript">muestra('Existe Comprobante de Retencion Asociado al movimiento');</script><?}}
  }
  if($error==0){ $sSQL="select * from ban010 where cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_trans='$tipo_mov' and tipo_registro='1'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
     if ($filas>0){$error=1; ?><script language="JavaScript">  muestra('MOVIMIENTO EXISTE EN CONCILIACION COMO TRANSITO');  </script><?} }
	 
  if(($error==0)and($valida_c=="S")){ $tipo_comp='B'.$cod_banco;
	    $sql="SELECT referencia,status from con002 Where referencia='$referencia' And fecha='$fecha_mov' And tipo_comp='$tipo_comp'"; $resultado=pg_exec($conn,$sql);  $filas=pg_numrows($resultado);
       if ($filas>0){ $reg=pg_fetch_array($resultado); $mstatusc=$reg["status"]; if($mstatusc=="A"){$error=1;?><script language="JavaScript">muestra('Comprobante Contable del Movimiento esta Actualizado, debe cambiar a Diferido');</script><?} }
  }	 
  if($error==0){$DOperacion="1";
      if($tipodc=="C"){$tipodca="D";$tipo_mova="AND";$AOperacion="03";if($tipo_mov=="CHQ"){$AOperacion="02";$tipo_mova="ANU";}}else{$tipodca="C";$tipo_mova="ANC";$AOperacion="01";if($tipo_mov=="CHQ"){$AOperacion="02";$tipo_mova="ANU";}}
      if($mes_conciliacion<>"00"){$error=1; ?><script language="JavaScript">  muestra('MOVIMIENTO EN LIBRO ESTA CONCILIADO');  </script><?}
      if(($error==0)and($tipo_mov=="CHQ")){$sSQL="SELECT num_cheque,chq_o_f_c,nro_orden_pago,tipo_pago From BAN006 Where (cod_banco='$cod_banco') And (num_cheque='$referencia')"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
        if($filas>=1){$reg=pg_fetch_array($resultado); $morden=$reg["nro_orden_pago"]; $tipo_pago=$reg["tipo_pago"]; $chq_o_f_c=$reg["chq_o_f_c"]; if(($chq_o_f_c=="A")or($chq_o_f_c=="O")or($chq_o_f_c=="P")or($chq_o_f_c=="F")or($chq_o_f_c=="B")){$tipo_chq=$chq_o_f_c;}} else{$error=1; ?><script language="JavaScript">  muestra('NUMERO DE CHEQUE NO EXISTE EN ESTADO DE CHEQUES');  </script><?}
      }
      if(($error==0)and($tipo_mov=="NDB")){ if($por_emision=="A"){$por_emision="S";} }
      if($error==0){ $sfecha=$fecha_mov; $sfechaa=$fecha_anulado; $proceso=0;  echo $tipo_mova." ".$tipo_chq;
      if($tipo_mov=="CHQ"){$proceso=1;   echo $tipo_chq;
        if($tipo_chq=="F"){$sSQL="SELECT ELIMINA_CHQ_FINANCIEROS('$cod_banco','$referencia','$sfecha',$monto)"; $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror=substr($merror,0,91);  }
        if($tipo_chq=="P"){$sSQL="SELECT ELIMINA_CHQ_PER_ANT('$cod_banco','$referencia','$sfecha',$monto,'$referenciaa')"; $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror=substr($merror,0,91);  }
        if($tipo_chq=="O"){$sSQL="SELECT ELIMINA_CHQ_ORDEN('$cod_banco','$referencia','$sfecha',$monto,'$tipo_pago')"; $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror=substr($merror,0,191); }
        if($tipo_chq=="B"){$sSQL="SELECT ELIMINA_CHQ_ABONA_ORDEN('$cod_banco','$referencia','$sfecha',$monto,'$tipo_pago','$morden')"; $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror=substr($merror,0,91); }
		//echo $sSQL;
	  }
      if(($tipo_mov=="NDB")and($por_emision<>"N")){$proceso=1; $tipo_pago="0".substr($cod_bancoa,1,3); $tipo_chq=substr($cod_bancoa,0, 1);
        if($tipo_chq=="D"){ $sSQL="SELECT ELIMINA_NDB_DIRECTA('$cod_banco','$referencia','$sfecha',$monto,'$tipo_pago')"; $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror=substr($merror,0,91);}
        else{if($tipo_chq=="A"){ $sSQL="SELECT ELIMINA_NDB_ABONA_ORDEN('$cod_banco','$referencia','$sfecha',$monto,'$tipo_pago','$referenciaa')"; $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror=substr($merror,0,91); }
        else{
		   if($tipo_chq=="P"){
		      
		      if($cod_bancoa=="P002"){$sSQL="SELECT ELIMINA_NDB_PER_ANT('$cod_banco','$referencia','$sfecha',$monto,'$referenciaa')"; $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror=substr($merror,0,91); }
        	
		      else{$sSQL="SELECT ELIMINA_NDB_ORDEN('$cod_banco','$referencia','$sfecha',$monto,'$tipo_pago')"; $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror=substr($merror,0,91); } 
		   }
		} }
		//echo $sSQL;
      }
      if($proceso==0){ $sSQL="SELECT ACTUALIZA_BAN004(3,'$referencia','$cod_banco','$referencia','$tipo_mov','$ced_rif','$sfecha','$referenciaa','$cod_bancoa','$anulado','$sfechaa',$monto,'00','$AOperacion','$DOperacion','N','N','N','','$usuario_sia','$minf_usuario','$tipodc','$anulado','$tipo_mova','$tipodca','$statusc','$adescripcion')"; $resultado=pg_exec($conn,$sSQL); $merror=pg_errormessage($conn); $merror=substr($merror,0,191); }
      if (!$resultado){$error=1; echo $merror,"<br>"; ?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><?}else{?><script language="JavaScript">  muestra('ELIMINO EXITOSAMENTE'); </script><?
         $desc_doc="MOVIMIENTO EN LIBRO, BANCO:".$cod_banco.", REFERENCIA:".$referencia.", TIPO MOVIMIENTO:".$tipo_mov.", DESCRIPCION:".$adescripcion.", MONTO:".$monto;$resultado=pg_exec($conn,"SELECT INCLUYE_SIA004('02','$usuario_sia','$usuario_sia','$equipo','Elimino','$sfecha','$desc_doc')");
         $Merror=pg_errormessage($conn); $Merror=substr($error,0,91);  if (!$resultado){$error=1;?><script language="JavaScript">muestra('<?echo $error;?>');</script><? } } }
  }
}pg_close(); ?>
<script language="JavaScript"> window.close(); window.opener.location.reload(); </script>
