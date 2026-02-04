<?php include ("../class/conect.php"); include ("../class/funciones.php");$dbdatos="DATOS"; $act_trans=$_GET["act_trans"]; $act_ord=$_GET["act_ordenes"]; $act_almacen=$_GET["act_almacen"]; 
$temp=substr($dbname,0,6);if($temp=="PPADRE"){$dbdatos="PPADRE";}if($temp=="CPDVSA"){$dbdatos="CPDVSA";}  $dbdatos="DATOS"; 
$conn2=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbdatos."");
$sql="Select * from SIA000 order by campo001";$resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$SIA_Integrado=$registro["campo036"];$Fec_Ini_Ejer_new=$registro["campo031"];$Fec_Fin_Ejer_new=$registro["campo032"]; }
echo $dbdatos." ".$Fec_Ini_Ejer_new,"<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); window.close(); </script> <?php }
else{ $SIA_Cierre="N"; $SIA_Precierre="N"; $cod_modulo="06";$sql="Select * from SIA000 order by campo001";$resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$SIA_Integrado=$registro["campo036"];$Fec_Ini_Ejer=$registro["campo031"];$Fec_Fin_Ejer=$registro["campo032"];$SIA_Precierre=substr($SIA_Integrado,16,1); $SIA_Cierre=substr($SIA_Integrado,17,1);} else{ ?><script language="JavaScript">muestra('INFORMACION DE EMPRESA NO LOCALIZADA'); window.close(); </script><?php }
if($SIA_Precierre=="S"){$SIA_Precierre="S";}else{ ?><script language="JavaScript">muestra('PRE-CIERRE DEL EJERCICIO NO EJECUTADO'); window.close(); </script><?php } 
if($SIA_Cierre=="S"){ ?><script language="JavaScript">muestra('EJERCICIO YA CERRADO'); window.close(); </script><?php } 
if(substr($SIA_Integrado,2,1)=="S"){ $contab_fiscal=1; $cod_modulo="03"; } else { $contab_fiscal=0; }
echo "ESPERE ACTUALIZANDO SALDOS BANCOS....","<br>";
$resultado=pg_exec($conn,"SELECT INCIALIZA_TABLAS(11,1,1,'')"); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php echo $error; ?>'); </script> <?php }
echo "ESPERE ACTUALIZANDO LIBROS....","<br>";
$resultado=pg_exec($conn,"SELECT ACTUALIZA_libro()"); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php echo $error; ?>'); </script> <?php }
echo "ESPERE ACTUALIZANDO BANCOS....","<br>";
$resultado=pg_exec($conn,"SELECT ACTUALIZA_banco()"); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php echo $error; ?>'); </script> <?php }
$sql="select * from bancos order by cod_banco"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $descripcion_banco=$registro["descripcion_banco"];  $cod_contable=$registro["cod_contable"]; $inf_usuario=$registro["inf_usuario"]; $des_tipo_cuenta=$registro["descripcion_tipo"]; $activa=$registro["activa"]; $campo_str1=$registro["campo_str1"];$campo_str2=$registro["campo_str2"];
 $tipo_cuenta=$registro["tipo_cuenta"]; $tipo_bco=$registro["tipo_bco"]; $activa=$registro["activa"]; $formato_cheque=$registro["formato_cheque"]; $fecha_activa=$registro["fecha_activa"]; $fecha_desactiva=$registro["fecha_desactiva"]; $nombre_cuenta=$registro["nombre_cuenta"]; $saldo_ant_libro=$registro["s_inic_libro"]; $saldo_ant_banco=$registro["s_inic_banco"]; $campo_num1=$registro["campo_num1"];$nombre_grupob=$registro["nombre_grupob"];
 $debito01=$registro["deb_libro01"];$credito01=$registro["cre_libro01"];$debitob01=$registro["deb_banco01"];$creditob01=$registro["cre_banco01"];$debito02=$registro["deb_libro02"];$credito02=$registro["cre_libro02"];$debitob02=$registro["deb_banco02"];$creditob02=$registro["cre_banco02"];$debito03=$registro["deb_libro03"];$credito03=$registro["cre_libro03"];$debitob03=$registro["deb_banco03"];$creditob03=$registro["cre_banco03"];
 $debito04=$registro["deb_libro04"];$credito04=$registro["cre_libro04"];$debitob04=$registro["deb_banco04"];$creditob04=$registro["cre_banco04"];$debito05=$registro["deb_libro05"];$credito05=$registro["cre_libro05"];$debitob05=$registro["deb_banco05"];$creditob05=$registro["cre_banco05"];$debito06=$registro["deb_libro06"];$credito06=$registro["cre_libro06"];$debitob06=$registro["deb_banco06"];$creditob06=$registro["cre_banco06"];
 $debito07=$registro["deb_libro07"];$credito07=$registro["cre_libro07"];$debitob07=$registro["deb_banco07"];$creditob07=$registro["cre_banco07"];$debito08=$registro["deb_libro08"];$credito08=$registro["cre_libro08"];$debitob08=$registro["deb_banco08"];$creditob08=$registro["cre_banco08"];$debito09=$registro["deb_libro09"];$credito09=$registro["cre_libro09"];$debitob09=$registro["deb_banco09"];$creditob09=$registro["cre_banco09"];
 $debito10=$registro["deb_libro10"];$credito10=$registro["cre_libro10"];$debitob10=$registro["deb_banco10"];$creditob10=$registro["cre_banco10"];$debito11=$registro["deb_libro11"];$credito11=$registro["cre_libro11"];$debitob11=$registro["deb_banco11"];$creditob11=$registro["cre_banco11"];$debito12=$registro["deb_libro12"];$credito12=$registro["cre_libro12"];$debitob12=$registro["deb_banco12"];$creditob12=$registro["cre_banco12"];
 $saldo_libro=$saldo_ant_libro+$debito01-$credito01+$debito02-$credito02+$debito03-$credito03+$debito04-$credito04+$debito05-$credito05+$debito06-$credito06+$debito07-$credito07+$debito08-$credito08+$debito09-$credito09+$debito10-$credito10+$debito11-$credito11+$debito12-$credito12;
 $saldo_banco=$saldo_ant_banco+$debitob01-$creditob01+$debitob02-$creditob02+$debitob03-$creditob03+$debitob04-$creditob04+$debitob05-$creditob05+$debitob06-$creditob06+$debitob07-$creditob07+$debitob08-$creditob08+$debitob09-$creditob09+$debitob10-$creditob10+$debitob11-$creditob11+$debitob12-$creditob12;
 $saldo_libro=cambia_coma_numero($saldo_libro);
 $saldo_banco=cambia_coma_numero($saldo_banco);
 $SSQL="UPDATE BAN002 SET s_inic_libro=".$saldo_libro.",s_inic_banco=".$saldo_banco." where cod_banco='".$cod_banco."'";
 $resultado=pg_exec($conn2,$SSQL); $merror=pg_errormessage($conn2); $merror=substr($merror,0,91);if (!$resultado){ echo $SSQL,"<br>"; ?> <script language="JavaScript">  muestra('<?php echo $merror; ?>'); </script> <?php }
}
echo "ESPERE ACTUALIZANDO SALDOS CONTABILIDAD....","<br>";
$MControl = array (0,0,0,0,0,0,0,0,0,0);
function BUSCAR_ACTUAL($Clave,$Formato){  global $MControl;  $j=0;
  for ($i=0; $i<strlen($Formato); $i++) { if (substr($Formato,+$i,1) == "-") {$j++;} else{$MControl[$j]++;} }
  $Ultimo=$j;  $k=$MControl[0];
  for ($i=1; $i<10; $i++) {if ($MControl[$i] == 0) {$MControl[$i]=0;} else { $j=$MControl[$i]+$k; $MControl[$i]=$j+1; $k=$MControl[$i];} }
  for ($i=1; $i<10; $i++) {if ($MControl[$i] < 0) {$MControl[$i]=0;}}  $actual=-1;
  for ($i=0; $i<10; $i++) {if (strlen($Clave) == $MControl[$i]){$actual=$i; $i=10;}}
  if ($actual==-1){?><script language="JavaScript">muestra('ERROR Longitud de la Cuenta Invalida');</script><?php }
  return $actual;
}
$Cta_Activo="1";$Cta_Pasivo="2";$Cta_Ingreso="5";$Cta_Egreso="6"; $Cta_Resultado="7";$Cta_Capital="3"; $Cta_Orden="4";$Cta_Result_Eje="3-1-5-02";$Cta_Result_Ant="3-1-5-01"; $Cta_Costo_Venta=""; $r=0; $Formato_Cuenta="X-X-X-XX-XX-XX-XX";
if($contab_fiscal==0){
$sql="Select * from SIA005 where campo501='06'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $Formato_Cuenta=$registro["campo504"]; $Cta_Activo=$registro["campo505"];$Cta_Pasivo=$registro["campo506"];
 $Cta_Ingreso=$registro["campo507"];  $Cta_Egreso=$registro["campo508"];  $Cta_Resultado=$registro["campo509"];$Cta_Capital=$registro["campo510"]; $Cta_Orden=$registro["campo511"];
 $Cta_Result_Eje=$registro["campo512"]; $Cta_Result_Ant=$registro["campo513"];$Cta_Costo_Venta=$registro["campo517"];
} $Cta_Ingreso=trim($Cta_Ingreso); $Cta_Egreso=trim($Cta_Egreso); $li=strlen($Cta_Ingreso); $le=strlen($Cta_Egreso);
}else{
$sql="Select * from SIA005 where campo501='03'"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){ $Formato_Cuenta=$registro["campo504"]; $Cta_Activo=$registro["campo505"];$Cta_Pasivo=$registro["campo506"]; $Cta_Orden=$registro["campo507"]; $Cta_Ingreso=$registro["campo510"];  $Cta_Egreso=$registro["campo509"];  $Cta_Resultado=$registro["campo509"];
$Cta_Sit_Finan=$registro["campo513"]; $Cta_Sit_Fiscal=$registro["campo514"]; $Cta_Ejec_Presup=$registro["campo515"]; $Cta_Hacienda_Mun=$registro["campo516"]; $Cta_Result_Fis=$registro["campo517"];  }
$Cta_Ingreso=trim($Cta_Ingreso); $Cta_Egreso=trim($Cta_Egreso); $li=strlen($Cta_Ingreso); $le=strlen($Cta_Egreso);
}
$error=0;
if($error==0){
$resultado=pg_exec($conn,"SELECT ACTUALIZA_MAES_CONTAB('$Cta_Result_Eje')"); $error=pg_errormessage($conn); $error=substr($error,0,91);
if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php echo $error; ?>'); </script> <?php }
echo "ESPERE ACTUALIZANDO SALDOS....","<br>"; $r=0; $a=BUSCAR_ACTUAL($Formato_Cuenta,$Formato_Cuenta);
if($a>0){
  for ($i=$a-1; $i>=0; $i--) {
	$str_C = $MControl[$i]; $str_L = $MControl[$i+1];if (strlen($Cta_Result_Eje)==$MControl[$i]){$r = $i;}
	$resultado=pg_exec($conn,"SELECT ACTUALIZA_SALDO_CONTAB($str_C,$str_L)"); 
	$error=pg_errormessage($conn); $error=substr($error,0,91);if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php echo $error; ?>'); </script> <?php }
  }
}
if($contab_fiscal==0){
echo "ESPERE ACTUALIZANDO CUENTA DE RESULTADOS....","<br>";
$resultado=pg_exec($conn,"SELECT ACTUALIZA_RESULTADO('$Cta_Ingreso','$Cta_Egreso','$Cta_Costo_Venta','$Cta_Result_Eje')");  $error=pg_errormessage($conn); $error=substr($error,0,91);
if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php echo $error; ?>'); </script> <?php }
if($r>0){ $str_C = $MControl[$r-1];  $str_L = $MControl[$r]; $cuenta=substr($Cta_Result_Eje,0,$str_L);
  for ($i=$r-1; $i>=0; $i--) { $str_C = $MControl[$i];  $str_L = $MControl[$i+1]; 
	$resultado=pg_exec($conn,"SELECT ACTUALIZA_SALDO_RESULT('$cuenta',$str_C,$str_L)");   $error=pg_errormessage($conn); $error=substr($error,0,91);
	if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php echo $error; ?>'); </script> <?php }
  }
}  
}
$monto_resultado=0;  
$sql="Select * from con001 order by codigo_cuenta"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){ $codigo_cuenta=$registro["codigo_cuenta"];   $nombre_cuenta=$registro["nombre_cuenta"]; $lc=strlen($codigo_cuenta);
  if(($registro["cargable"]=="C")){
	  $clasificacion=$registro["clasificacion"];  $tSaldo=$registro["tsaldo"];  $fecha_creado=$registro["fecha_creado"];
	  $saldo_anterior=$registro["saldo_anterior"];
	  $debito01=formato_monto($registro["debito_01"]);
	  $credito01=formato_monto($registro["credito_01"]);
	  If($tSaldo== "Deudor"){$saldop01=$registro["debito_01"]-$registro["credito_01"];}else{$saldop01=$registro["credito_01"]-$registro["debito_01"];}
	  $saldo01= $saldo_anterior+$saldop01;
	  $debito02=formato_monto($registro["debito_02"]);
	  $credito02=formato_monto($registro["credito_02"]);
	  If($tSaldo== "Deudor"){$saldop02=$registro["debito_02"]-$registro["credito_02"];}else{$saldop02=$registro["credito_02"]-$registro["debito_02"];}
	  $saldo02= $saldo01+$saldop02;
	  $debito03=formato_monto($registro["debito_03"]);
	  $credito03=formato_monto($registro["credito_03"]);
	  If($tSaldo== "Deudor"){$saldop03=$registro["debito_03"]-$registro["credito_03"];}else{$saldop03=$registro["credito_03"]-$registro["debito_03"];}
	  $saldo03= $saldo02+$saldop03;
	  $debito04=formato_monto($registro["debito_04"]);
	  $credito04=formato_monto($registro["credito_04"]);
	  If($tSaldo== "Deudor"){$saldop04=$registro["debito_04"]-$registro["credito_04"];}else{$saldop04=$registro["credito_04"]-$registro["debito_04"];}
	  $saldo04= $saldo03+$saldop04;
	  $debito05=formato_monto($registro["debito_05"]);
	  $credito05=formato_monto($registro["credito_05"]);
	  If($tSaldo== "Deudor"){$saldop05=$registro["debito_05"]-$registro["credito_05"];}else{$saldop05=$registro["credito_05"]-$registro["debito_05"];}
	  $saldo05= $saldo04+$saldop05;
	  $debito06=formato_monto($registro["debito_06"]);
	  $credito06=formato_monto($registro["credito_06"]);
	  If($tSaldo== "Deudor"){$saldop06=$registro["debito_06"]-$registro["credito_06"];}else{$saldop06=$registro["credito_06"]-$registro["debito_06"];}
	  $saldo06= $saldo05+$saldop06;
	  $debito07=formato_monto($registro["debito_07"]);
	  $credito07=formato_monto($registro["credito_07"]);
	  If($tSaldo== "Deudor"){$saldop07=$registro["debito_07"]-$registro["credito_07"];}else{$saldop07=$registro["credito_07"]-$registro["debito_07"];}
	  $saldo07= $saldo06+$saldop07;
	  $debito08=formato_monto($registro["debito_08"]);
	  $credito08=formato_monto($registro["credito_08"]);
	  If($tSaldo=="Deudor"){$saldop08=$registro["debito_08"]-$registro["credito_08"];}else{$saldop08=$registro["credito_08"]-$registro["debito_08"];}
	  $saldo08= $saldo07+$saldop08;
	  $debito09=formato_monto($registro["debito_09"]);
	  $credito09=formato_monto($registro["credito_09"]);
	  If($tSaldo=="Deudor"){$saldop09=$registro["debito_09"]-$registro["credito_09"];}else{$saldop09=$registro["credito_09"]-$registro["debito_09"];}
	  $saldo09= $saldo08+$saldop09;
	  $debito10=formato_monto($registro["debito_10"]);
	  $credito10=formato_monto($registro["credito_10"]);
	  If($tSaldo=="Deudor"){$saldop10=$registro["debito_10"]-$registro["credito_10"];}else{$saldop10=$registro["credito_10"]-$registro["debito_10"];}
	  $saldo10= $saldo09+$saldop10;
	  $debito11=formato_monto($registro["debito_11"]);
	  $credito11=formato_monto($registro["credito_11"]);
	  If($tSaldo=="Deudor"){$saldop11=$registro["debito_11"]-$registro["credito_11"];}else{$saldop11=$registro["credito_11"]-$registro["debito_11"];}
	  $saldo11= $saldo10+$saldop11;
	  $debito12=formato_monto($registro["debito_12"]);
	  $credito12=formato_monto($registro["credito_12"]);
	  If($tSaldo=="Deudor"){$saldop12=$registro["debito_12"]-$registro["credito_12"];}else{$saldop12=$registro["credito_12"]-$registro["debito_12"];}
	  $saldo12=$saldo11+$saldop12;
	  
  }else{$saldo12=0;}
  if($Cta_Result_Eje==$codigo_cuenta){$monto_resultado=$saldo12; $saldo12=0;}
  if((substr($codigo_cuenta,0,$li)==substr($Cta_Ingreso,0,$li))or(substr($codigo_cuenta,0,$le)==substr($Cta_Egreso,0,$le))){$saldo12=0;}
  $saldo12=cambia_coma_numero($saldo12);
  $SSQL="UPDATE CON001 SET saldo_anterior=".$saldo12." where codigo_cuenta='".$codigo_cuenta."'";
  $resultado=pg_exec($conn2,$SSQL); $error=pg_errormessage($conn2); $error=substr($error,0,91);if (!$resultado){ echo $SSQL,"<br>"; ?> <script language="JavaScript">  muestra('<?php echo $error; ?>'); </script> <?php }
}
$monto_resultado=cambia_coma_numero($monto_resultado);
$SSQL="UPDATE CON001 SET saldo_anterior=saldo_anterior+$monto_resultado where codigo_cuenta='".$Cta_Result_Ant."'";
$resultado=pg_exec($conn2,$SSQL); $error=pg_errormessage($conn2); $error=substr($error,0,91);if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php echo $error; ?>'); </script> <?php }
echo substr($Cta_Ingreso,0,$li)." ".substr($Cta_Egreso,0,$le)." ".$Cta_Result_Eje." ".$monto_resultado,"<br>";
if($act_trans=="SI"){
  echo "ESPERE ACTUALIZANDO MOVIMIENTOS TRANSITO....","<br>";  
  $sSQL="DELETE FROM BAN007";  $resultado=pg_exec($conn2,$sSQL);
  $sql="SELECT BAN004.cod_banco,BAN004.referencia,BAN004.tipo_mov_libro,BAN004.descrip_mov_libro,BAN004.fecha_mov_libro,BAN004.monto_mov_libro,BAN004.inf_usuario,PRE099.nombre FROM BAN004 LEFT JOIN PRE099 ON (BAN004.ced_rif=PRE099.ced_rif) where (BAN004.mes_conciliacion = '00') And (BAN004.anulado<>'S') And(BAN004.tipo_mov_libro <> 'ANU') And (BAN004.tipo_mov_libro <> 'CAN')  And (BAN004.tipo_mov_libro <> 'DAN') And (BAN004.tipo_mov_libro <> 'ANC') And (BAN004.tipo_mov_libro <> 'AND') Order by BAN004.cod_banco,BAN004.fecha_mov_libro,BAN004.tipo_mov_libro,BAN004.referencia";
  $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){ $cod_banco=$registro["cod_banco"];$referencia=$registro["referencia"];$tipo_mov=$registro["tipo_mov_libro"];
    $fecha=$registro["fecha_mov_libro"]; $monto=$registro["monto_mov_libro"]; $beneficiario=$registro["nombre"];$descripcion=$registro["descrip_mov_libro"];$minf_usuario=$registro["inf_usuario"];
    $sSQL="SELECT ACTUALIZA_BAN007(1,'$cod_banco','$referencia','$tipo_mov','$fecha',$monto,'$beneficiario','00','$minf_usuario','$descripcion')";  $resultado=pg_exec($conn2,$sSQL);  $merror=pg_errormessage($conn2);  $merror=substr($merror,0,91);
  
  }     
  $sql="SELECT cod_banco,referencia,tipo_trans_libro,desc_trans_libro,fecha_trans_libro,monto_trans_libro,beneficiario,inf_usuario FROM BAN007 where (mes_conciliacion = '00') And (BAN007.tipo_trans_libro <> 'CAN')  And (BAN007.tipo_trans_libro <> 'DAN') And (BAN007.tipo_trans_libro <> 'ANC') And (BAN007.tipo_trans_libro <> 'AND') Order by cod_banco,fecha_trans_libro,tipo_trans_libro,referencia";
  $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){ $cod_banco=$registro["cod_banco"];$referencia=$registro["referencia"];$tipo_mov=$registro["tipo_trans_libro"];
    $fecha=$registro["fecha_trans_libro"]; $monto=$registro["monto_trans_libro"]; $beneficiario=$registro["beneficiario"];$descripcion=$registro["desc_trans_libro"];$minf_usuario=$registro["inf_usuario"];
    $sSQL="SELECT ACTUALIZA_BAN007(1,'$cod_banco','$referencia','$tipo_mov','$fecha',$monto,'$beneficiario','00','$minf_usuario','$descripcion')";  $resultado=pg_exec($conn2,$sSQL);  $merror=pg_errormessage($conn2);  $merror=substr($merror,0,91);
  
  }   
  $sSQL="DELETE FROM BAN008";  $resultado=pg_exec($conn2,$sSQL);	   
  $sql="SELECT cod_banco,referencia,tipo_mov_banco,des_mov_banco,fecha_mov_banco,monto_mov_banco,benef_mov_banco,inf_usuario FROM BAN005 where (mes_conciliacion = '00') And (BAN005.anulado<>'S') And (BAN005.tipo_mov_banco <> 'ANU') And (BAN005.tipo_mov_banco <> 'CAN')  And (BAN005.tipo_mov_banco <> 'DAN') And (BAN005.tipo_mov_banco <> 'ANC') And (BAN005.tipo_mov_banco <> 'AND') Order by cod_banco,fecha_mov_banco,tipo_mov_banco,referencia";
  $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){ $cod_banco=$registro["cod_banco"];$referencia=$registro["referencia"];$tipo_mov=$registro["tipo_mov_banco"];     	 
	$fecha=$registro["fecha_mov_banco"]; $monto=$registro["monto_mov_banco"]; $beneficiario=$registro["benef_mov_banco"];$descripcion=$registro["des_mov_banco"];$minf_usuario=$registro["inf_usuario"];
	$sSQL="SELECT ACTUALIZA_BAN008(1,'$cod_banco','$referencia','$tipo_mov','$fecha',$monto,'00','$beneficiario','$minf_usuario','$descripcion')";  $resultado=pg_exec($conn2,$sSQL);  $merror=pg_errormessage($conn2);  $merror=substr($merror,0,91);
  }	 
  $sql="SELECT cod_banco,referencia,tipo_trans_banco,des_mov_trans_banco,fecha_trans_banco,monto_trans_banco,bene_mov_trans_banco,inf_usuario FROM BAN008 where (mes_conciliacion = '00') And (BAN008.tipo_trans_banco <> 'CAN')  And (BAN008.tipo_trans_banco <> 'DAN') And (BAN008.tipo_trans_banco <> 'ANC') And (BAN008.tipo_trans_banco <> 'AND') Order by cod_banco,fecha_trans_banco,tipo_trans_banco,referencia";
  $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){ $cod_banco=$registro["cod_banco"];$referencia=$registro["referencia"];$tipo_mov=$registro["tipo_trans_banco"];     	 
	$fecha=$registro["fecha_trans_banco"]; $monto=$registro["monto_trans_banco"]; $beneficiario=$registro["bene_mov_trans_banco"];$descripcion=$registro["des_mov_trans_banco"];$minf_usuario=$registro["inf_usuario"];
	$sSQL="SELECT ACTUALIZA_BAN008(1,'$cod_banco','$referencia','$tipo_mov','$fecha',$monto,'00','$beneficiario','$minf_usuario','$descripcion')";  $resultado=pg_exec($conn2,$sSQL);  $merror=pg_errormessage($conn2);  $merror=substr($merror,0,91);
  }	      		 
}
}
if($act_ord=="SI"){
  echo "ESPERE ACTUALIZANDO ORDENES DE PAGO PENDIENTES....","<br>";  
 // $sSQL="DELETE FROM pag022";  $resultado=pg_exec($conn2,$sSQL);
 // $sSQL="DELETE FROM pag023";  $resultado=pg_exec($conn2,$sSQL);
 // $sSQL="DELETE FROM pag024";  $resultado=pg_exec($conn2,$sSQL);
 // $sSQL="DELETE FROM pag025";  $resultado=pg_exec($conn2,$sSQL);  
  $sql="SELECT * from PAG001 where status='N' and anulado='N'";   $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){ 
    $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"]; $cod_contable_o=$registro["cod_contable_o"];
	$concepto=$registro["concepto"];   $inf_usuario=$registro["inf_usuario"];   $ced_rif=$registro["ced_rif"];   
	$func_inv=$registro["func_inv"];   $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; 
	$pago_ces=$registro["pago_ces"];  $ced_rif_ces=$registro["ced_rif_ces"];   $nombre_ces=$registro["nombre_ces"];
	$tipo_documento=$registro["tipo_documento"];  $nro_documento=$registro["nro_documento"];    $fecha_desde=$registro["fecha_desde"];
	$fecha_hasta=$registro["fecha_hasta"];  $fecha_vencim=$registro["fecha_vencim"];   $tipo_orden=$registro["tipo_orden"];
	$cod_banco=$registro["cod_banco"];    $status=$registro["status"];    $fecha_c=$registro["fecha_cheque"];
	$orden_permanen=$registro["orden_permanen"]; $nro_periodos=$registro["nro_periodos"]; $retencion=$registro["retencion"];
    $total_causado=$registro["total_causado"];  $total_retencion=$registro["total_retencion"]; $usuario_siao=$registro["usuario_sia"];
    $total_ajuste=$registro["total_ajuste"];  $total_pasivos=$registro["total_pasivos"];  $monto_am_ant=$registro["monto_am_ant"];
	$clasif_orden=$registro["clasif_orden"]; $nro_cheque=$registro["nro_cheque"]; $total_pagado=$registro["total_pagado"];
	$num_proyecto=$registro["num_proyecto"]; $forma_pago=$registro["forma_pago"]; $afecta_presu=$registro["afecta_presu"]; 
	$medio_pago=$registro["medio_pago"]; $genera_comp=$registro["genera_comp"]; $genera_comp_ret=$registro["genera_comp_ret"]; 
	$genera_p_ret=$registro["genera_p_ret"]; $genera_orden_r=$registro["genera_orden_r"];
	$aprobado=$registro["aprobado"]; $nro_expediente=$registro["nro_expediente"]; $usuario_sia_aprueba=$registro["usuario_sia_aprueba"];	
	$sSQL="INSERT INTO pag022(nro_orden,tipo_causado,fecha,ced_rif,cod_contable_o,status,retencion,clasif_orden,tipo_documento,nro_documento,cod_banco,nro_cheque,fecha_cheque,tipo_pago,status_r,cod_banco_r,nro_cheque_r,fecha_cheque_r,tipo_pago_r,monto_am_ant,total_causado,total_retencion,total_ajuste,total_pasivos,total_pagado,total_pago_ret,tipo_orden,num_proyecto,forma_pago,afecta_presu,func_inv,medio_pago,ced_rif_ces,nombre_ces,pago_ces,cta_bco_abonar,cod_bco_abonar,fecha_vencim,edo_orden_pago,orden_permanen,nro_periodos,fecha_desde,fecha_hasta,genera_comp,genera_comp_ret,genera_p_ret,genera_orden_r,aprobado,nro_expediente,usuario_sia,usuario_sia_aprueba,inf_usuario,concepto)";
    $sSQL=$sSQL." VALUES ('$nro_orden','$tipo_causado','$fecha','$ced_rif','$cod_contable_o','$status','$retencion','$clasif_orden','$tipo_documento','$nro_documento','$cod_banco','$nro_cheque','$fecha_c','','N','000','00000000','$fecha_c','',$monto_am_ant,$total_causado,$total_retencion,$total_ajuste,$total_pasivos,$total_pagado,0,'$tipo_orden','$num_proyecto','$forma_pago','$afecta_presu','$func_inv','$medio_pago','$ced_rif_ces','$nombre_ces','$pago_ces','','000','$fecha_vencim','','$orden_permanen',$nro_periodos,'$fecha_desde','$fecha_hasta','$genera_comp','$genera_comp_ret','$genera_p_ret','$genera_orden_r','$aprobado','$nro_expediente','$usuario_siao','$usuario_sia_aprueba','$inf_usuario','$concepto')";
	$resultado=pg_exec($conn2,$sSQL);  $merror=pg_errormessage($conn2);  $merror=substr($merror,0,91);
	//echo $sSQL,"<br>";
  }  
  $sql="select * from pre037 where text(referencia_caus)||text(tipo_causado) in (select text(nro_orden)||text(tipo_causado) from pag001 where status='N' and anulado='N')";   $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){ $nro_orden=$registro["referencia_caus"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha_causado"]; 
    $referencia_comp=$registro["referencia_comp"];  $tipo_compromiso=$registro["tipo_compromiso"];  $cod_presup=$registro["cod_presup"];
	$fuente_financ=$registro["fuente_financ"]; $ref_aep=$registro["referencia_caus"]; $causado=$registro["monto"];  
	$ajustado=$registro["ajustado"];  $amort_anticipo=$registro["amort_anticipo"];  $tipo_imput_presu=$registro["tipo_imput_presu"];  
	$ref_imput_presu=$registro["ref_imput_presu"];  $monto_credito=$registro["monto_credito"];   
    $sSQL="INSERT INTO pag023(nro_orden,tipo_causado,referencia_comp,tipo_compromiso,cod_presup,fuente_financ,ref_aep,fecha_aep,causado,ajustado,amort_anticipo,tipo_imput_presu,ref_imput_presu,monto_credito)";
    $sSQL=$sSQL." VALUES ('$nro_orden','$tipo_causado','$referencia_comp','$tipo_compromiso','$cod_presup','$fuente_financ','$ref_aep','$fecha',$causado,$ajustado,$amort_anticipo,'$tipo_imput_presu','$ref_imput_presu',$monto_credito)";
	$resultado=pg_exec($conn2,$sSQL);  $merror=pg_errormessage($conn2);  $merror=substr($merror,0,91);
  }  
  $sql="select * from con003 where tipo_comp='O0001' or tipo_comp='O0002' and referencia in (select nro_orden from pag001 where status='N' and anulado='N')";   $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){ $referencia=$registro["referencia"];  $fecha=$registro["fecha"];  $tipo_asiento='O/P';  
    $debito_credito=$registro["debito_credito"];  $cod_cuenta=$registro["cod_cuenta"];  $monto_asiento=$registro["monto_asiento"];  $descripcion_a=$registro["descripcion_a"];
    $sSQL="INSERT INTO pag024(referencia,fecha,tipo_asiento,debito_credito,cod_cuenta,monto_asiento,descripcion_a)";
    $sSQL=$sSQL." VALUES ('$referencia','$fecha','$tipo_asiento','$debito_credito','$cod_cuenta',$monto_asiento,'$descripcion_a')";
	$resultado=pg_exec($conn2,$sSQL);  $merror=pg_errormessage($conn2);  $merror=substr($merror,0,91);
	//echo $sSQL,"<br>";
  }  
  $sql="SELECT * from PAG004 where nro_orden_ret in (select nro_orden from pag001 where status='N' and anulado='N')";   $res=pg_query($sql);
  while($registro=pg_fetch_array($res)){ $nro_orden_ret=$registro["nro_orden_ret"];  $tipo_retencion=$registro["tipo_retencion"];  
    $ref_comp_ret=$registro["ref_comp_ret"];  $tipo_comp_ret=$registro["tipo_comp_ret"];  $cod_presup_ret=$registro["cod_presup_ret"];  
	$fuente_fin_ret=$registro["fuente_fin_ret"];  $aux_orden=$registro["aux_orden"];  $tipo_caus_ret=$registro["tipo_caus_ret"];  
	$cod_contable_ret=$registro["cod_contable_ret"];  $tasa_retencion=$registro["tasa_retencion"];  $monto_objeto_ret=$registro["monto_objeto_ret"];  
	$monto_retencion=$registro["monto_retencion"];  $monto_pago_ret=$registro["monto_pago_ret"];  $ret_anticipo=$registro["ret_anticipo"];  
	$ced_rif_r=$registro["ced_rif_r"];  $status_r=$registro["status_r"];  $cod_banco_r=$registro["cod_banco_r"];  
	$nro_cheque_r=$registro["nro_cheque_r"];  $fecha_cheque_r=$registro["fecha_cheque_r"];  $tipo_pago_r=$registro["tipo_pago_r"];  
	$aprobado=$registro["aprobado"];  $nro_expediente=$registro["nro_expediente"];  $usuario_sia_aprueba='';  
	$des_orden_ret=$registro["des_orden_ret"];
    $sSQL="INSERT INTO pag025(nro_orden_ret,tipo_retencion,ref_comp_ret,tipo_comp_ret,cod_presup_ret,fuente_fin_ret,aux_orden,tipo_caus_ret,cod_contable_ret,tasa_retencion,monto_objeto_ret,monto_retencion,monto_pago_ret,ret_anticipo,ced_rif_r,status_r,cod_banco_r,nro_cheque_r,fecha_cheque_r,tipo_pago_r,aprobado,nro_expediente,usuario_sia_aprueba,des_orden_ret)";
    $sSQL=$sSQL." VALUES ('$nro_orden_ret','$tipo_retencion','$ref_comp_ret','$tipo_comp_ret','$cod_presup_ret','$fuente_fin_ret','$aux_orden','$tipo_caus_ret','$cod_contable_ret',$tasa_retencion,$monto_objeto_ret,$monto_retencion,$monto_pago_ret,'$ret_anticipo','$ced_rif_r','$status_r','$cod_banco_r','$nro_cheque_r','$fecha_cheque_r','$tipo_pago_r','$aprobado','$nro_expediente','$usuario_sia_aprueba','$des_orden_ret')";
    $resultado=pg_exec($conn2,$sSQL);  $merror=pg_errormessage($conn2);  $merror=substr($merror,0,91);
  }  
}
if($act_almacen=="SI"){
  echo "ESPERE ACTUALIZANDO EXISTENCIAS DE ALMACEN....","<br>";   
  $sql = "SeLect comp002.cod_articulo,comp002.des_articulo,comp002.ramo,comp002.tipo_articulo,comp002.partida,comp002.cod_contable,comp002.unidad_medida,comp002.unidad_alterna, comp002.marca,comp002.modelo,comp002.medida,comp002.relacion,comp002.ultimo_costo,comp002.fecha_u_costo,comp002.impuesto,comp002.pedido_maximo,comp003.cod_almacen,comp003.descripcion_almacen,comp003.ubicacion_almacen,comp004.cod_articulo,comp004.cod_almacen,comp004.existencia  from comp002,comp003,comp004  Where (comp002.cod_articulo=comp004.cod_articulo) and (comp003.cod_almacen=comp004.cod_almacen) and (comp004.existencia>=1) order by comp003.cod_almacen,comp002.cod_articulo";
  $res=pg_query($sql); $prev_almacen=''; $num_ref=0; $nro_ajuste=''; $tipo_ajuste="E"; $fecha=$Fec_Ini_Ejer_new; $concepto="INVENTARIO INICIAL";
  while($registro=pg_fetch_array($res)){ $cod_almacen=$registro["cod_almacen"]; $cod_articulo=$registro["cod_articulo"]; $unidad_medida=$registro["unidad_medida"]; $des_articulo=$registro["des_articulo"];
    $existencia=$registro["existencia"]; $ultimo_costo=$registro["ultimo_costo"]; $impuesto=$registro["impuesto"];  $total=$existencia*$ultimo_costo;	$monto_iva=($ultimo_costo*$impuesto)/100; $total_iva=($total*$impuesto)/100;  
    if($cod_almacen<>$prev_almacen){ $num_ref=$num_ref+1; $len=strlen($num_ref); $nro_ajuste=substr("00000000",0,8-$len).$num_ref;
       $sSQL="INSERT INTO COMP014 (nro_ajuste,tipo_ajuste,fecha_ajuste,Autorizado_Por,fecha_Autorizacion,Codigo_Almacen,Cod_Tipo_Mov,nro_comprobante_a,Procesa_Almacen,Procesado_Por,Usuario_SIA,Inf_Usuario,Descripcion) ";
       $sSQL=$sSQL." VALUES ('$nro_ajuste','$tipo_ajuste','$fecha','','$fecha','$cod_almacen','01','$nro_ajuste','N','','PRE-CIERRE','','$concepto')";
	   $resultado=pg_exec($conn2,$sSQL);  $merror=pg_errormessage($conn2);  $merror=substr($merror,0,91); if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php echo $merror; ?>'); </script> <?php }
       $prev_almacen=$cod_almacen;
     // echo $sSQL,"<br>";
    }	
	$sqld="INSERT INTO comp045(nro_ajuste,codigo_articulo,unidad_medida,cantidad_ajuste,costo_actual,tasa_impuesto,existencia_actual,monto_iva,total_iva,unidad_p_a,relacion,descripcion_articulo)";
	$sqld=$sqld." VALUES ('$nro_ajuste','$cod_articulo','$unidad_medida',$existencia,$ultimo_costo,$impuesto,0,$monto_iva,$total_iva,'P',1,'$des_articulo')";
	$resultado=pg_exec($conn2,$sqld);  $merror=pg_errormessage($conn2);  $merror=substr($merror,0,91);	if (!$resultado){ ?> <script language="JavaScript">  muestra('<?php echo $merror; ?>'); </script> <?php }
	//echo $sqld,"<br>";  
  }   
}
}
?> <script language="JavaScript">  muestra('PROCESO FINALIZADO'); </script> <?php pg_close();?>  <script language="JavaScript"> window.close();  </script>


