<?include ("../class/conect.php");  include ("../class/funciones.php");  include ("../class/configura.inc"); error_reporting(E_ALL);
$codigo_mov=$_POST["txtcodigo_mov"]; $tipo_pago=$_POST["txttipo_pago"]; $cod_banco=$_POST["txtcod_banco"]; $num_nota=$_POST["txtnro_ndb"];  $monto=$_POST["txtmonto_ndb"];  $fecha=$_POST["txtfecha"]; $multiple=$_POST["txtmultiple"]; $fecha_nota=$fecha;  $concepto=$_POST["txtconcepto"];
$equipo = getenv("COMPUTERNAME"); $minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>"; $error=0;
$url="Emision_Ndb_orden.php?continua=S";   $furl="../bancos/rpt/Rpt_formato_mov_libro.php?cod_banco=".$cod_banco."&referencia=".$num_nota."&tipo_mov=NDB";
$monto=formato_numero($monto); if(is_numeric($monto)){$monto=$monto;} else{$monto=0;}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if(pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
if($SIA_Definicion=="N"){$error=1;?><script language="JavaScript">muestra('ETAPA DE DEFINICIÒN ABIERTA');</script><?}
if($error==0){ $l_cat=0; $sql="Select campo503,campo504,campo526 from SIA005 where campo501='05'";    $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"]; $l_cat=strlen($formato_cat); if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$$registro["campo503"];}}
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $des_chq=""; $periodom=$SIA_Periodo; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='02'"; $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $periodom=$registro["campo503"]; $des_chq=$registro["campo510"];}	
    $sobreg_saldo=substr($campo502,0,1); $doc_concepto=substr($campo502,5,1); $ret_presup=substr($campo502,6,1); $chq_proceso=substr($campo502,7,1);
    $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
    if($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"];} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
}
if(checkData($fecha)=='1'){$error=0;} else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if(($error==0)and($monto==0)){  $error=1; ?> <script language="JavaScript"> muestra('MONTO NOTA DEBITO INVALIDO');</script><? }
if($error==0){$sfecha=formato_aaaammdd($fecha); if(($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){echo $sfecha; $error=1;?><script language="JavaScript">muestra('FECHA DE NOTA DEBITO INVALIDA');</script><?}}
if($error==0){$nmes=substr($fecha,3, 2);  if($periodom<$SIA_Periodo){$periodom=$SIA_Periodo;}  if($periodom>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DE MES MENOR A ULTIMO PERIODO CERRADO');</script><?}}

/*INI(20171117) nmdb encontrando array con los meses ya concialiados para evitar que se le incluyan movimientos*/
$nmes=substr($fecha,3, 2);
$sql   = "SELECT * FROM ban009 where cod_banco='" . $cod_banco . "'";
$res   = pg_query($sql);
$filas = pg_num_rows($res);
$reg   = pg_fetch_array($res, 0);

if ($reg["mes".$nmes] == "S") {
  $error = 1; ?> <script language="JavaScript"> muestra('Verifique fecha de Movimiento: Mes <?php echo $nmes; ?> Conciliado');</script><?php
}
/*FIN(20171117) nmdb encontrando array con los meses ya concialiados para evitar que se le incluyan movimientos*/

if($error==0){ if(strlen($num_nota)==8){$error=0;} else {$error=1; ?> <script language="JavaScript"> muestra('LONGITUD NOTA DEBITO INVALIDO');</script><? } }
if($error==0){ $sSQL="SELECT cod_banco FROM BAN004 WHERE cod_banco='$cod_banco' and referencia='$num_nota' and tipo_mov_libro='NDB'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('NUMERO NOTA DEBITO YA EXISTE');</script><? }}
if($error==0){ $tipo_comp="B".$cod_banco; $sSql="Select * from con002 where text(fecha)='$sfecha' and referencia='$num_nota' and tipo_comp='$tipo_comp'";  $resultado=pg_query($sSql);  $filas=pg_num_rows($resultado);
  if($filas>0){$error=1; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE YA EXISTE');</script><? }}
if($error==0){ $nmes=substr($fecha,3, 2); $codc_banco=""; $tasa_idb=0; $cod_cont_idb="";
 $sSQL="SELECT cod_banco,nombre_banco,nro_cuenta,descripcion_banco,tipo_cuenta,cod_contable,tipo_bco,control_chequera,status_control,activa,fecha_activa,fecha_desactiva,s_inic_libro,deb_libro01,cre_libro01,deb_libro02,cre_libro02,deb_libro03,cre_libro03,deb_libro04,cre_libro04,deb_libro05,cre_libro05,deb_libro06,cre_libro06,deb_libro07,cre_libro07,deb_libro08,cre_libro08,deb_libro09,cre_libro09,deb_libro10,cre_libro10,deb_libro11,cre_libro11,deb_libro12,cre_libro12,campo_str1,campo_str2,campo_num1,campo_num2 FROM ban002 WHERE cod_banco='$cod_banco'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
 if($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO NO EXISTE');</script><? }
 else {$registro=pg_fetch_array($resultado,0); $codc_banco=$registro["cod_contable"];  $activo=$registro["activa"]; $saldo_ant_libro=$registro["s_inic_libro"]; $tasa_idb=$registro["campo_num1"]; $cod_cont_idb=$registro["campo_str1"];  if($activo=="N"){$error=1; ?> <script language="JavaScript"> muestra('CÓDIGO DE BANCO NO ESTA ACTIVO');</script><? }
 if($error==0){$disponible=$saldo_ant_libro; for ($i=1;$i<=$nmes;$i++){$spos=$i; If($i<=9){$spos="0".$spos;} $disponible=$disponible+$registro["deb_libro".$spos] - $registro["cre_libro".$spos]; } $balance=$monto-$disponible;
  if(($disponible<$monto)and($balance>0.001)){if($sobreg_saldo=="N"){$error=1;} echo "Disponible: ".$disponible.'  Requerido: '.$monto,"<br>"; ?> <script language="JavaScript"> muestra('SOBREGIRA SALDO DEL BANCO');</script><? }
 }}
}
$ced_rif=""; $fecha1=$fecha; 
if(($error==0)and($multiple=="S")){ $sql="SELECT * FROM pag027 where codigo_mov='$codigo_mov' and seleccionada='S' order by ced_rif"; $res=pg_query($sql);
  while($registro=pg_fetch_array($res)) { if($ced_rif==""){$ced_rif=$registro["ced_rif"];} else { if($ced_rif<>$registro["ced_rif"]){$error=1; ?> <script language="JavaScript"> muestra('SELECCION DE DIFERENTE BENEFICIARIO');</script><? } }
}}
if($error==0){
 if($multiple=="S"){ $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");  $mvalor=pg_errormessage($conn); $mvalor=substr($mvalor,0,91); if(!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $mvalor; ?>'); </script> <? }  $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if(!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? $error=1; }
  $sql="SELECT * FROM pag027 where codigo_mov='$codigo_mov' and seleccionada='S' order by nro_orden,tipo_causado"; $resp=pg_query($sql); $total=0; $cant=0; $total_notas=0;  $prev_ord_can = ""; $t_debe=0;  $t_haber=0;
  while($registro=pg_fetch_array($resp)){  $nro_orden=$registro["nro_orden"]; $tipo_causado=$registro["tipo_causado"]; $monto=$registro["monto_orden"]; $t_ajuste=$registro["total_ajuste"]; IF($t_ajuste==0){$orden_aju="N";}else{$orden_aju="S";} $monto_orden_aju=0; $busca_orden_aju="S"; $cta_orden_aju="";  $total_notas=$total_notas+$monto; $orden_ret=$registro["orden_ret"];  $cant=$cant+1;
    $sSql="Select * from ORD_PAGO where nro_orden='$nro_orden' and tipo_causado='$tipo_causado' and status<>'I' and anulado='N'";  $resultado=pg_query($sSql);  $filas=pg_num_rows($resultado);
    if($filas==1){$pag001=pg_fetch_array($resultado,0); $fecha_e=$pag001["fecha"]; $total_causado=$pag001["total_causado"]; $total_retencion=$pag001["total_retencion"]; $monto_pasivo=$pag001["total_pasivos"]; $monto_am_ant=$pag001["monto_am_ant"]; $genera_comp=$pag001["genera_comp"]; $status=$pag001["status"];  $status_r=$pag001["status_r"];  $anulado=$pag001["anulado"];  $nro_documento=$pag001["nro_documento"]; $tipo_documento=$pag001["tipo_documento"]; $amort_ant=$pag001["status_1"]; $status_1=$pag001["status_1"]; $status_2=$pag001["status_2"]; $cta_anticipo=$pag001["campo_str1"]; $g_comp_ret=$pag001["genera_comp_ret"]; $retencion=$pag001["retencion"]; $genera_orden_r=$pag001["genera_orden_r"];  if($prev_ord_can==""){$prev_ord_can=$nro_orden;}else{$prev_ord_can=$prev_ord_can.", ".$nro_orden;}
     if(((($status=="N") and (($orden_ret=="S") Or ($orden_ret=="N"))) Or  (($status_r=="N") and ($orden_ret=="R"))) and ($anulado=="N")){ $tipo_chq="O"; if($orden_ret=="R"){$tipo_chq="R";}  $fecha_orden=$pag001["fecha"]; $tipo_comp="O".$tipo_causado; $descripcion=$des_chq.$pag001["concepto"]; if(($doc_concepto=="S")and($nro_documento!=="")){$descripcion=$descripcion.", ".$tipo_documento.": ".$nro_documento;} $F=0; $cod_contable_o=$pag001["cod_contable_o"]; $afecta_presu=$pag001["afecta_presu"];  $ced_rif=$pag001["ced_rif"]; $beneficiario=$pag001["nombre"]; if($pag001["pago_ces"]=="S"){$ced_rif=$pag001["ced_rif_ces"];$beneficiario=$pag001["nombre_ces"];} $descripcion_a=$beneficiario." Orden:".$prev_ord_can;
       if((($g_comp_ret=="S") Or ($retencion=="N"))and($genera_comp=="N")) { $sql="SELECT * FROM pag020  where nro_orden='$nro_orden' order by cod_cuenta"; $res=pg_query($sql);
        while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_pasivo"]; $cod_cuenta=$registro["cod_cuenta"];  $tipo_dc=$registro["debito_credito"]; $F=$F+1; $t_debe=$t_debe+$monto_asiento;
          $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
          if($filas>0){ $reg=pg_fetch_array($resultado);   $monto_c=$monto_asiento+$reg["monto_asiento"]; $monto_c=cambia_coma_numero($monto_c);  if($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','D','$cod_cuenta',$monto_c,'$descripcion_a')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} } }
           else{$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','D','$cod_cuenta','00000','',$monto_asiento,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }}
        }
        if($F==0){$codigo_cuenta=$cod_contable_o;$sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
          if($filas>0){ $reg=pg_fetch_array($resultado);   $monto_c=$monto_asiento+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c);  if($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','D','$codigo_cuenta',$monto_c,'$descripcion_a')"); $F=$F+1; $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?$error=1; } } }
           else{$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','D','$codigo_cuenta','00000','',$monto_asiento,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); $F=$F+1; if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?$error=1; }} $t_debe=$t_debe+$monto_asiento; }
       }
       if((($g_comp_ret=="S") Or ($retencion=="N"))and($genera_comp=="S")) { $sql="SELECT * FROM con003  where referencia='$nro_orden' and fecha='$fecha_orden' and tipo_comp='$tipo_comp' and debito_credito='C' order by cod_cuenta"; $res=pg_query($sql); $continua=1;
        while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_asiento"]; $cod_cuenta=$registro["cod_cuenta"];  $tipo_dc=$registro["debito_credito"];   $continua=1;
         if($genera_orden_r=="N"){  if($orden_ret=="R"){$monto=abs($total_retencion-($t_debe+$monto_asiento)); if(($total_retencion!==($t_debe+$monto_asiento))and($monto>0.001)){$continua=0;}}
          else{ if($g_comp_ret=="N"){$monto=$total_causado-$total_retencion;} else{ if($status_2=="C"){$monto=$total_causado-$total_retencion-$monto_am_ant+$monto_pasivo;} else{$monto=$total_causado-$total_retencion-$monto_am_ant+$monto_pasivo;} $monto=abs($monto-$monto_asiento); } if(($total_retencion!==0)and($monto>0.001)){$continua=0;} } }
         if($continua==1){
           if(($orden_aju=="S")and($busca_orden_aju=="S")and($cta_anticipo!==$cod_cuenta)){ if($t_ajuste==$monto_asiento){$busca_orden_aju="N";$cta_orden_aju=$cod_cuenta;}else{ if($monto_orden_aju<$monto_asiento){ $monto_orden_aju=$monto_asiento;$cta_orden_aju=$cod_cuenta;} } }  if($amort_ant=="S"){if($cta_anticipo==$cod_cuenta){$continua=0;}else{$continua=1;} } else{$continua=1;}
           if($continua==1){$monto_asiento=$registro["monto_asiento"]; $t_debe=$t_debe+$monto_asiento; $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
             if($filas>0){  $reg=pg_fetch_array($resultado);   $monto_c=$monto_asiento+$reg["monto_asiento"]; $monto_c=cambia_coma_numero($monto_c); if($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','D','$cod_cuenta',$monto_c,'$descripcion_a')"); $F=$F+1; $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} } }
              else{$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','D','$cod_cuenta','00000','',$monto_asiento,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn); $F=$F+1; $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;}}
             } }
        }
        if(($monto_pasivo>0) and ($status_2<>"C")){ $sql="SELECT * FROM pag020 where nro_orden='$nro_orden' and debito_credito='D' order by cod_cuenta"; $res=pg_query($sql);
         while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_pasivo"]; $cod_cuenta=$registro["cod_cuenta"];  $tipo_dc="D"; $F=$F+1;
          $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
          if($filas>0){ $reg=pg_fetch_array($resultado);   $monto_c=$monto_asiento+$reg["monto_asiento"];   $monto_c=cambia_coma_numero($monto_c);  if($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','D','$cod_cuenta',$monto_c,'$descripcion_a')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} } }
           else{$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','D','$cod_cuenta','00000','',$monto_asiento,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }}  $t_debe=$t_debe+$monto_asiento;
         }
        }
		if(($monto_pasivo==0) and ($status_2=="C")){ $sql="SELECT * FROM pag020 where nro_orden='$nro_orden' and debito_credito='C' order by cod_cuenta"; $res=pg_query($sql);
          while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_pasivo"];  $cod_cuenta=$registro["cod_cuenta"]; 
		    $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
            if($filas>0){ $sSQL="SELECT ELIMINA_CUENTA_CON010('$codigo_mov','D','$cod_cuenta')";    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error="ERROR ELIMINANDO: ".substr($error,0,91); 
			   if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }   else{   $t_debe=$t_debe-$monto_asiento; } }
		  }
        }	
        if($orden_aju=="S"){$sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cta_orden_aju' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
           if($filas>0){ $reg=pg_fetch_array($resultado);  $monto_c=$reg["monto_asiento"]-$t_ajuste; if($monto_c<0){$monto_c=0;} $monto_c=cambia_coma_numero($monto_c); $sqlg="SELECT MODIFICA_CUENTA_CON010('$codigo_mov','D','$cta_orden_aju',$monto_c,'$descripcion_a')";$resultado=pg_exec($conn,$sqlg); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,90); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?  $error=1; }  $t_debe=$t_debe-$t_ajuste;  }
           //echo $sSQL." ".$filas." ".$monto_c." ".$reg["monto_asiento"]." ".$t_ajuste." ".$sqlg;
		}
       }
       if(($g_comp_ret=="N")and($retencion=="S")){  $sql="SELECT * FROM pag005  where referencia='$nro_orden' and fecha='$fecha_orden' and debito_credito='C' order by cod_cuenta"; $res=pg_query($sql);
        while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_asiento"]; $cod_cuenta=$registro["cod_cuenta"];  $tipo_dc=$registro["debito_credito"];
         $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
         if($filas>0){ $reg=pg_fetch_array($resultado);   $monto_c=$monto_asiento+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c); if($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','D','$cod_cuenta',$monto_c,'$descripcion_a')"); $F=$F+1; $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} } }
            else{$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','D','$cod_cuenta','00000','',$monto_asiento,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn); $F=$F+1; $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }}  $t_debe=$t_debe+$monto_asiento;
        }
       }
       if($error==0){ $sql="select pre037.referencia_caus,pre037.tipo_causado,pre037.referencia_comp,pre037.tipo_compromiso,pre037.cod_presup,pre037.fuente_financ,pre037.monto,pre037.ajustado,pre037.tipo_imput_presu,pre037.ref_imput_presu,pre037.monto_credito,pre037.amort_anticipo,pre007.ref_aep,pre007.num_proyecto,pre007.fecha_aep,pre007.func_inv,pre003.ref_compromiso from pre037,pre007 Left Join pre003 On (pre003.tipo_causado=pre007.tipo_causado) where (pre037.referencia_caus=pre007.referencia_caus) and (pre037.tipo_causado=pre007.tipo_causado) and (pre037.referencia_comp=pre007.referencia_comp) and (pre037.tipo_compromiso=pre007.tipo_compromiso) and (pre007.referencia_caus='$nro_orden') and (pre007.tipo_causado='$tipo_causado') order by cod_presup,fuente_financ"; $res=pg_query($sql);
        while($reg=pg_fetch_array($res)){ $monto_c=$reg["monto"]-$reg["ajustado"]; $cod_presup=$reg["cod_presup"]; $fuente_financ=$reg["fuente_financ"];  $referencia_comp=$reg["referencia_comp"]; $tipo_compromiso=$reg["tipo_compromiso"]; $tipo_imput_presu=$reg["tipo_imput_presu"];  $ref_imput_presu=$reg["ref_imput_presu"]; $monto_credito=$reg["monto_credito"]; $func_inv=$reg["func_inv"];  $fecha_aep=$reg["fecha_aep"]; $ref_aep=$reg["ref_aep"]; $num_proyecto=$reg["num_proyecto"];  $operacion="N";  if($reg["ref_compromiso"]="SI"){$operacion="C";}
           $monto_c=cambia_coma_numero($monto_c); $resultado=pg_exec($conn,"SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$nro_orden','$tipo_causado','','0000','','0000','$operacion','','','','$ref_aep','$num_proyecto','$fecha_aep','$func_inv','$tipo_imput_presu','$ref_imput_presu','$fecha_orden',$monto_c,0,$monto_credito,0)"); $error=pg_errormessage($conn);   $error="ERROR GRABANDO: ".substr($error,0,91);  if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }
        }
       }
       if(((($genera_comp=="N") and ($status_1=="S")) Or (($genera_comp=="S") and ($status_2=="S"))) and ($genera_orden_r=="N") and ($ret_presup=="S")) {
         $sql="select pag004.nro_orden_ret,pag004.tipo_retencion,pag004.tipo_caus_ret,pag004.ref_comp_ret,pag004.tipo_comp_ret,pag004.cod_presup_ret,pag004.fuente_fin_ret,pag004.des_orden_ret,pag004.cod_contable_ret,pag004.monto_retencion,pre007.ref_AEP,pre007.num_proyecto,pre007.fecha_AEP,pre007.func_inv,pre037.tipo_imput_presu,pre037.ref_imput_presu,pre037.monto_credito,pre003.ref_compromiso from pag004,pre037,pre007 left join pre003 on (pre003.tipo_causado=pre007.tipo_causado) where  (pre037.referencia_caus=pag004.nro_orden_ret) and (pre037.tipo_causado=pag004.tipo_caus_ret) and (pre037.referencia_comp=pag004.ref_comp_ret) and (pre037.tipo_compromiso=pag004.tipo_comp_ret) and (pre037.cod_presup=pag004.cod_presup_ret) and (pre037.fuente_financ=pag004.fuente_fin_ret) and (status_r='I') and (pre037.referencia_caus=pre007.referencia_caus) and (pre037.tipo_causado=pre007.tipo_causado) and (pre037.referencia_comp=pre007.referencia_comp) and (pre037.tipo_compromiso=pre007.tipo_compromiso) and (tipo_pago_r='O/P') and (nro_cheque_r='$nro_orden')  order by pag004.nro_orden_ret,pag004.tipo_retencion,pag004.tipo_caus_ret,pag004.cod_presup_ret"; $res=pg_query($sql);
         while($reg=pg_fetch_array($res)){ $monto_c=$reg["monto_retencion"]; $cod_presup=$reg["cod_presup_ret"]; $fuente_financ=$reg["fuente_fin_ret"]; $nro_orden_r=$reg["nro_orden_ret"]; $tipo_causado_r=$reg["tipo_caus_ret"]; $referencia_comp=$reg["ref_comp_ret"]; $tipo_compromiso=$reg["tipo_comp_ret"]; $tipo_imput_presu=$reg["tipo_imput_presu"];  $ref_imput_presu=$reg["ref_imput_presu"]; $monto_credito=$reg["monto_credito"]; $func_inv=$reg["func_inv"];  $fecha_aep=$reg["fecha_aep"]; $ref_aep=$reg["ref_aep"]; $num_proyecto=$reg["num_proyecto"];  $operacion="N";  if($reg["ref_compromiso"]="SI"){$operacion="C";}
          $sSQL="Select monto,monto_credito,ref_imput_presu from pre026 WHERE codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and referencia_caus='$nro_orden_r' and tipo_causado='$tipo_causado_r' and ref_imput_presu='$ref_imput_presu' and tipo_imput_presu='$tipo_imput_presu'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
          if($filas==0){ $resultado=pg_exec($conn,"SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$nro_orden_r','$tipo_causado_r','','0000','','0000','$operacion','','','','$ref_aep','$num_proyecto','$fecha_aep','$func_inv','$tipo_imput_presu','$ref_imput_presu','$fecha_orden',$monto_c,0,$monto_credito,0)");  $error=pg_errormessage($conn);   $error="ERROR GRABANDO: ".substr($error,0,91);  if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; } }
           else { $reg=pg_fetch_array($resultado); $ref_imput_presu=$reg["ref_imput_presu"]; $monto_c=$reg["monto"]+$monto_c; if($tipo_imput_presu=="C"){$monto_credito=$monto_c+$reg["monto_credito"];} $monto_c=cambia_coma_numero($monto_c); $monto_credito=cambia_coma_numero($monto_credito); $ref_imput_presu=$reg["ref_imput_presu"];
			$sqlg="SELECT MOD_MONTOA_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$nro_orden_r','$tipo_causado_r',$monto_c,0)";
			$sqlg="SELECT MOD_MONTO_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$ref_imput_presu',$monto_c,$monto_credito)";
			$resultado=pg_exec($conn,$sqlg);  $merror=pg_errormessage($conn);   $merror="ERROR GRABANDO: ".substr($merror,0,90);  if(!$resultado){?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><? $error=1; } }
         }
       }
       if(($total_retencion>0) and ($retencion=="N") and (($g_comp_ret=="N")Or($genera_orden_r=="N"))) { $prev_orden = ""; $sql="select nro_orden_ret,aux_orden,tipo_caus_ret,ref_comp_ret,tipo_comp_ret,cod_presup_ret,fuente_fin_ret,monto_retencion from pag004 where (nro_orden_ret='$nro_orden')"; $res=pg_query($sql);
         while($reg=pg_fetch_array($res)){ $aux_orden=$reg["aux_orden"]; $monto_r=$reg["monto_retencion"]; $monto_c=$reg["monto_retencion"]; $cod_presup=$reg["cod_presup_ret"]; $fuente_financ=$reg["fuente_fin_ret"]; $nro_orden_r=$reg["nro_orden_ret"]; $tipo_causado_r=$reg["tipo_caus_ret"]; $referencia_comp=$reg["ref_comp_ret"]; $tipo_compromiso=$reg["tipo_comp_ret"];
           if(($genera_orden_r=="N") and ($ret_presup=="S") and ($afecta_presu=="S")) {
            $sSQL="Select monto,monto_credito,ref_imput_presu from pre026 WHERE codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and referencia_caus='$nro_orden_r' and tipo_causado='$tipo_causado_r'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
            if($filas>0){ $reg=pg_fetch_array($resultado); $monto_c=$reg["monto"]-$monto_r;  $monto_credito=$reg["monto_credito"]; if ($monto_credito>=$monto_r){ $monto_credito=$reg["monto_credito"]-$monto_r;}
			$monto_c=cambia_coma_numero($monto_c); $monto_credito=cambia_coma_numero($monto_credito); $ref_imput_presu=$reg["ref_imput_presu"];
			$sqlg="SELECT MOD_MONTOA_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$nro_orden_r','$tipo_causado_r',$monto_c,0)";
			$sqlg="SELECT MOD_MONTO_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$ref_imput_presu',$monto_c,$monto_credito)";
			$resultado=pg_exec($conn,$sqlg);   $error=pg_errormessage($conn);   $error="ERROR GRABANDO: ".substr($error,0,91);  if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} }
           }
           if(($prev_orden!==$aux_orden) and ($g_comp_ret=="N")) { $prev_orden=$aux_orden; $sSQL="select referencia,cod_cuenta,monto_asiento,debito_credito from pag005 Where (referencia='$nro_orden') and (fecha='$fecha_orden') and (debito_credito='c')"; $res=pg_query($sSQL);
            while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_asiento"]; $cod_cuenta=$registro["cod_cuenta"];  $tipo_dc=$registro["debito_credito"];
              $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='C'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
              if($filas>0){ $reg=pg_fetch_array($resultado);   $monto_c=$monto_asiento+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c);  if($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','C','$cod_cuenta',$monto_c,'$descripcion_a')"); $F=$F+1; $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} } }
               else{$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','C','$cod_cuenta','00000','',$monto_asiento,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn); $F=$F+1; $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }}  $t_haber=$t_haber+$monto_asiento;
            }
           }
         }
       }
       if($F==0){$error=1; ?> <script language="JavaScript"> muestra('LOCALIZANDO COMPROBANTE DE ORDEN :'+<? echo $nro_orden; ?>);</script><? }
       if($error==0){  $fecha2=formato_ddmmaaaa($fecha_e); if(FDate($fecha1)<FDate($fecha2)){ echo "Orden .".$nro_orden." Fecha: ".$fecha2.", Fecha Nota: ".$fecha1,"<br>"; $error=1; ?> <script language="JavaScript">  muestra('Fecha Nota Debito menor a Fecha Orden'); </script> <? } }
       if($error==0){ $resultado=pg_exec($conn,"SELECT SELECCIONA_PAG027('$codigo_mov','$nro_orden','$tipo_causado','I')"); $error=pg_errormessage($conn); $error=substr($error,0,91); if(!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?  $error=1;}}
     }
    }else{$error=1; ?> <script language="JavaScript"> muestra('ERROR LOCALIZANDO ORDEN :'+<? echo $nro_orden; ?>);</script><? }
  }
  if(($total_notas>0) and ($error==0)){  $descripcion_a=$beneficiario." Orden:".$prev_ord_can; $total_notas=cambia_coma_numero($total_notas); 
     $resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$num_nota','C','$codc_banco','00000','',$total_notas,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn); $F=$F+1; $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }  $t_haber=$t_haber+$total_notas;
     if($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
     if($balance>0.001){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
     if(($t_debe==0)or($t_haber==0)){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
     if($error==0){ $resultado=pg_exec($conn,"SELECT MODIFICA_DES_CON010('$codigo_mov','$descripcion_a')"); $error=pg_errormessage($conn); $error=substr($error,0,91); if(!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?  $error=1;}}

     if($error==0){ if($tasa_idb>0)  {$mstatus="I";$monto_idb=$total_notas*($tasa_idb/100); $monto_idb=Round($monto_idb, 2);} else{$cod_cont_idb=""; $mstatus="N"; $monto_idb=0;}    $sfecha=formato_aaaammdd($fecha_nota);    $descripcion=$concepto;
        $sSQL="SELECT INCLUYE_NDB_ORDEN('$codigo_mov','$cod_banco','$num_nota','$sfecha','$ced_rif',$total_notas,'N','','$usuario_sia','$minf_usuario','$mstatus',$monto_idb,'$cod_cont_idb','$codc_banco','$tipo_pago','$statusc','$descripcion')";  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error,0,91);
        if(!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
        else{ $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?   
		$resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");  $mvalor=pg_errormessage($conn); $mvalor=substr($mvalor,0,91); if(!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $mvalor; ?>'); </script> <? }  
		/*
		$res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if(!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? $error=1; } 
		*/
		}
     }
  }
 }
 else{$sql="SELECT * FROM pag027 where codigo_mov='$codigo_mov' and seleccionada='S' order by nro_orden,tipo_causado"; $resp=pg_query($sql); $total=0; $cant=0;
  while(($registro=pg_fetch_array($resp))) { $cant=$cant+1; if($cant>1){$ult_ref=$num_nota+1; $len=strlen($ult_ref); $ult_ref=substr("00000000",0,8-$len).$ult_ref;  $num_nota=$ult_ref; }
    $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");  $mvalor=pg_errormessage($conn); $mvalor=substr($mvalor,0,91); if(!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $mvalor; ?>'); </script> <? }  $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if(!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? $error=1; }
    $nro_orden=$registro["nro_orden"]; $tipo_causado=$registro["tipo_causado"]; $monto=$registro["monto_orden"]; $t_ajuste=$registro["total_ajuste"]; IF($t_ajuste==0){$orden_aju="N";}else{$orden_aju="S";} $monto_orden_aju=0; $busca_orden_aju="S"; $cta_orden_aju=""; $t_debe=0;  $t_haber=0;  $total_notas=$monto; $orden_ret=$registro["orden_ret"];
    $sSql="Select * from ORD_PAGO where nro_orden='$nro_orden' and tipo_causado='$tipo_causado' and status<>'I' and anulado='N'";  $resultado=pg_query($sSql);  $filas=pg_num_rows($resultado);
    if($filas==1){$pag001=pg_fetch_array($resultado,0); $fecha_e=$pag001["fecha"]; $total_causado=$pag001["total_causado"]; $total_retencion=$pag001["total_retencion"]; $monto_pasivo=$pag001["total_pasivos"]; $monto_am_ant=$pag001["monto_am_ant"]; $genera_comp=$pag001["genera_comp"]; $status=$pag001["status"];  $status_r=$pag001["status_r"];  $anulado=$pag001["anulado"];  $nro_documento=$pag001["nro_documento"]; $tipo_documento=$pag001["tipo_documento"]; $amort_ant=$pag001["status_1"]; $status_1=$pag001["status_1"]; $status_2=$pag001["status_2"]; $cta_anticipo=$pag001["campo_str1"]; $g_comp_ret=$pag001["genera_comp_ret"]; $retencion=$pag001["retencion"]; $genera_orden_r=$pag001["genera_orden_r"];
     if(((($status=="N") and (($orden_ret=="S") Or ($orden_ret=="N"))) Or  (($status_r=="N") and ($orden_ret=="R"))) and ($anulado=="N")){ $tipo_chq="O"; if($orden_ret=="R"){$tipo_chq="R";}  $fecha_orden=$pag001["fecha"]; $tipo_comp="O".$tipo_causado; $descripcion=$des_chq.$pag001["concepto"]; if(($doc_concepto=="S")and($nro_documento!=="")){$descripcion=$descripcion.", ".$tipo_documento.": ".$nro_documento;} $F=0; $cod_contable_o=$pag001["cod_contable_o"]; $afecta_presu=$pag001["afecta_presu"];  $ced_rif=$pag001["ced_rif"]; $beneficiario=$pag001["nombre"]; if($pag001["pago_ces"]=="S"){$ced_rif=$pag001["ced_rif_ces"];$beneficiario=$pag001["nombre_ces"];} $descripcion_a=$beneficiario." Orden:".$nro_orden;
       if((($g_comp_ret=="S") Or ($retencion=="N"))and($genera_comp=="N")) { $sql="SELECT * FROM pag020  where nro_orden='$nro_orden' order by cod_cuenta"; $res=pg_query($sql);
        while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_pasivo"]; $cod_cuenta=$registro["cod_cuenta"];  $tipo_dc=$registro["debito_credito"]; $F=$F+1;
          $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
          if($filas>0){ $reg=pg_fetch_array($resultado);   $monto_c=$monto_asiento+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c); if($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','D','$cod_cuenta',$monto_c,'$descripcion_a')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} } }
           else{$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','D','$cod_cuenta','00000','',$monto_asiento,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }}   $t_debe=$t_debe+$monto_asiento;
        }
        if($F==0){$codigo_cuenta=$cod_contable_o;$sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$codigo_cuenta' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
          if($filas>0){ $reg=pg_fetch_array($resultado);   $monto_c=$monto_asiento+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c); if($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','D','$codigo_cuenta',$monto_c,'$descripcion_a')"); $F=$F+1; $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?$error=1; } } }
           else{$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','D','$codigo_cuenta','00000','',$monto_asiento,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); $F=$F+1; if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?$error=1; }} $t_debe=$t_debe+$monto_asiento; }
       }
       if((($g_comp_ret=="S") Or ($retencion=="N"))and($genera_comp=="S")) { $sql="SELECT * FROM con003  where referencia='$nro_orden' and fecha='$fecha_orden' and tipo_comp='$tipo_comp' and debito_credito='C' order by cod_cuenta"; $res=pg_query($sql); $continua=1;
        //echo $sql.' '.$filas.' '.$t_debe.' '.$t_haber,"<br>";		
		while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_asiento"]; $cod_cuenta=$registro["cod_cuenta"];  $tipo_dc=$registro["debito_credito"]; $continua=1;
         if($genera_orden_r=="N"){ 
			  if($orden_ret=="R"){$monto=abs($total_retencion-($t_debe+$monto_asiento)); if(($total_retencion!==($t_debe+$monto_asiento))and($monto>0.001)){$continua=0;}}
			  else{ if($g_comp_ret=="N"){$monto=$total_causado-$total_retencion; }
			  else{if($status_2=="C"){$monto=$total_causado-$total_retencion-$monto_am_ant+$monto_pasivo;} 
			  else{$monto=$total_causado-$total_retencion-$monto_am_ant+$monto_pasivo;  } $resto=abs($monto-$monto_asiento); } 
			  if(($total_retencion!=0)and($resto>0.009)){$continua=0;} } 	  
		  }
		  if($continua==1){
           if(($orden_aju=="S")and($busca_orden_aju=="S")and($cta_anticipo!==$cod_cuenta)){  if($t_ajuste==$monto_asiento){$busca_orden_aju="N";$cta_orden_aju=$cod_cuenta;}else{ if($monto_orden_aju<$monto_asiento){ $monto_orden_aju=$monto_asiento;$cta_orden_aju=$cod_cuenta;}  }  }  if($amort_ant=="S"){if($cta_anticipo==$cod_cuenta){$continua=0;}else{$continua=1;} } else{$continua=1;}
           if($continua==1){ $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
             if($filas>0){ $reg=pg_fetch_array($resultado);   $monto_c=$monto_asiento+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c); if($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','D','$cod_cuenta',$monto_c,'$descripcion_a')"); $F=$F+1; $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,90); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} } }
              else{$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','D','$cod_cuenta','00000','',$monto_asiento,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn); $F=$F+1; $error="ERROR GRABANDO: ".substr($error,0,90); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;}}
            $t_debe=$t_debe+$monto_asiento; } }
        }		
		if($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
		//echo $t_debe.' '.$t_haber.' '.formato_monto($balance).' '.$busca_orden_aju.' A '.$cta_anticipo.'M '.$monto_orden_aju.' '.$cta_orden_aju,"<br>"; 
		//echo $t_debe.' '.$t_haber.' '.formato_monto($balance).' '.$monto_pasivo.' A '.$status_2,"<br>"; 
        if(($monto_pasivo>0) and ($status_2<>"C")){ $sql="SELECT * FROM pag020 where nro_orden='$nro_orden' and debito_credito='D' order by cod_cuenta"; $res=pg_query($sql); $filas=pg_numrows($res);
         // echo $sql.' '.$filas.' '.$t_debe.' '.$t_haber,"<br>";
		 while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_pasivo"]; $cod_cuenta=$registro["cod_cuenta"];  $tipo_dc="D"; $F=$F+1;
          $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
          if($filas>0){ $reg=pg_fetch_array($resultado);   $monto_c=$monto_asiento+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c); if($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','D','$cod_cuenta',$monto_c,'$descripcion_a')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} } }
           else{$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','D','$cod_cuenta','00000','',$monto_asiento,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }}  $t_debe=$t_debe+$monto_asiento;
		 }
		 //echo $nro_orden.' '.$t_debe.' '.$t_haber,"<br>";
        }
		if(($monto_pasivo==0) and ($status_2=="C")){ $sql="SELECT * FROM pag020 where nro_orden='$nro_orden' and debito_credito='C' order by cod_cuenta"; $res=pg_query($sql);
          while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_pasivo"];  $cod_cuenta=$registro["cod_cuenta"]; 
		    $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
            if($filas>0){ $sSQL="SELECT ELIMINA_CUENTA_CON010('$codigo_mov','D','$cod_cuenta')";    $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn);  $error="ERROR ELIMINANDO: ".substr($error,0,91); 
			   if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }   else{   $t_debe=$t_debe-$monto_asiento; } }
		  }
        }	
		if($orden_aju=="S"){ $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cta_orden_aju' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
           if($filas>0){ $reg=pg_fetch_array($resultado);  $monto_c=$reg["monto_asiento"]-$t_ajuste; if($monto_c<0){$monto_c=0;} $monto_c=cambia_coma_numero($monto_c); $sqlg="SELECT MODIFICA_CUENTA_CON010('$codigo_mov','D','$cta_orden_aju',$monto_c,'$descripcion_a')";$resultado=pg_exec($conn,$sqlg); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,90); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><?  $error=1; }  $t_debe=$t_debe-$t_ajuste;  }
           //echo $sSQL." ".$filas." ".$monto_c." ".$reg["monto_asiento"]." ".$t_ajuste." ".$sqlg;
		}
       }
       if(($g_comp_ret=="N")and($retencion=="S")){  $sql="SELECT * FROM pag005  where referencia='$nro_orden' and fecha='$fecha_orden' and debito_credito='C' order by cod_cuenta"; $res=pg_query($sql);
        while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_asiento"]; $cod_cuenta=$registro["cod_cuenta"];  $tipo_dc=$registro["debito_credito"];
         $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='D'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
         if($filas>0){ $reg=pg_fetch_array($resultado);   $monto_c=$monto_asiento+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c); if($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','D','$cod_cuenta',$monto_c,'$descripcion_a')"); $F=$F+1; $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} } }
            else{$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','D','$cod_cuenta','00000','',$monto_asiento,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn); $F=$F+1; $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }}  $t_debe=$t_debe+$monto_asiento;
        }
       }
       if($error==0){ $sql="select pre037.referencia_caus,pre037.tipo_causado,pre037.referencia_comp,pre037.tipo_compromiso,pre037.cod_presup,pre037.fuente_financ,pre037.monto,pre037.ajustado,pre037.tipo_imput_presu,pre037.ref_imput_presu,pre037.monto_credito,pre037.amort_anticipo,pre007.ref_aep,pre007.num_proyecto,pre007.fecha_aep,pre007.func_inv,pre003.ref_compromiso from pre037,pre007 Left Join pre003 On (pre003.tipo_causado=pre007.tipo_causado) where (pre037.referencia_caus=pre007.referencia_caus) and (pre037.tipo_causado=pre007.tipo_causado) and (pre037.referencia_comp=pre007.referencia_comp) and (pre037.tipo_compromiso=pre007.tipo_compromiso) and (pre007.referencia_caus='$nro_orden') and (pre007.tipo_causado='$tipo_causado') order by cod_presup,fuente_financ"; $res=pg_query($sql);
        while($reg=pg_fetch_array($res)){ $monto_c=$reg["monto"]-$reg["ajustado"]; $cod_presup=$reg["cod_presup"]; $fuente_financ=$reg["fuente_financ"];  $referencia_comp=$reg["referencia_comp"]; $tipo_compromiso=$reg["tipo_compromiso"]; $tipo_imput_presu=$reg["tipo_imput_presu"];  $ref_imput_presu=$reg["ref_imput_presu"]; $monto_credito=$reg["monto_credito"]; $func_inv=$reg["func_inv"];  $fecha_aep=$reg["fecha_aep"]; $ref_aep=$reg["ref_aep"]; $num_proyecto=$reg["num_proyecto"];  $operacion="N";  if($reg["ref_compromiso"]="SI"){$operacion="C";}
          $monto_c=cambia_coma_numero($monto_c); $resultado=pg_exec($conn,"SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$nro_orden','$tipo_causado','','0000','','0000','$operacion','','','','$ref_aep','$num_proyecto','$fecha_aep','$func_inv','$tipo_imput_presu','$ref_imput_presu','$fecha_orden',$monto_c,0,$monto_credito,0)"); $error=pg_errormessage($conn);   $error="ERROR GRABANDO: ".substr($error,0,91);  if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }
        }
       }
	   //echo $genera_comp." ".$status_1." ".$status_2." ".$genera_orden_r." ".$ret_presup,"<br>";
       if(((($genera_comp=="N") and ($status_1=="S")) Or (($genera_comp=="S") and ($status_2=="S"))) and ($genera_orden_r=="N") and ($ret_presup=="S")) {
		 // echo "PASO 1 ","<br>";  
         $sql="select pag004.nro_orden_ret,pag004.tipo_retencion,pag004.tipo_caus_ret,pag004.ref_comp_ret,pag004.tipo_comp_ret,pag004.cod_presup_ret,pag004.fuente_fin_ret,pag004.des_orden_ret,pag004.cod_contable_ret,pag004.monto_retencion,pre007.ref_AEP,pre007.num_proyecto,pre007.fecha_AEP,pre007.func_inv,pre037.tipo_imput_presu,pre037.ref_imput_presu,pre037.monto_credito,pre003.ref_compromiso from pag004,pre037,pre007 left join pre003 on (pre003.tipo_causado=pre007.tipo_causado) where  (pre037.referencia_caus=pag004.nro_orden_ret) and (pre037.tipo_causado=pag004.tipo_caus_ret) and (pre037.referencia_comp=pag004.ref_comp_ret) and (pre037.tipo_compromiso=pag004.tipo_comp_ret) and (pre037.cod_presup=pag004.cod_presup_ret) and (pre037.fuente_financ=pag004.fuente_fin_ret) and (status_r='I') and (pre037.referencia_caus=pre007.referencia_caus) and (pre037.tipo_causado=pre007.tipo_causado) and (pre037.referencia_comp=pre007.referencia_comp) and (pre037.tipo_compromiso=pre007.tipo_compromiso) and (tipo_pago_r='O/P') and (nro_cheque_r='$nro_orden')  order by pag004.nro_orden_ret,pag004.tipo_retencion,pag004.tipo_caus_ret,pag004.cod_presup_ret"; $res=pg_query($sql);
         //echo $sql,"<br>"; 
		 while($reg=pg_fetch_array($res)){ $monto_c=$reg["monto_retencion"]; $cod_presup=$reg["cod_presup_ret"]; $fuente_financ=$reg["fuente_fin_ret"]; $nro_orden_r=$reg["nro_orden_ret"]; $tipo_causado_r=$reg["tipo_caus_ret"]; $referencia_comp=$reg["ref_comp_ret"]; $tipo_compromiso=$reg["tipo_comp_ret"]; $tipo_imput_presu=$reg["tipo_imput_presu"];  $ref_imput_presu=$reg["ref_imput_presu"]; $monto_credito=$reg["monto_credito"]; $func_inv=$reg["func_inv"];  $fecha_aep=$reg["fecha_aep"]; $ref_aep=$reg["ref_aep"]; $num_proyecto=$reg["num_proyecto"];  $operacion="N";  if($reg["ref_compromiso"]="SI"){$operacion="C";}
          $sSQL="Select monto,monto_credito,ref_imput_presu from pre026 WHERE codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and referencia_caus='$nro_orden_r' and tipo_causado='$tipo_causado_r' and ref_imput_presu='$ref_imput_presu' and tipo_imput_presu='$tipo_imput_presu'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
          //echo $sSQL." ".$filas,"<br>"; 
		  if($filas==0){ $resultado=pg_exec($conn,"SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$nro_orden_r','$tipo_causado_r','','0000','','0000','$operacion','','','','$ref_aep','$num_proyecto','$fecha_aep','$func_inv','$tipo_imput_presu','$ref_imput_presu','$fecha_orden',$monto_c,0,$monto_credito,0)");  $merror=pg_errormessage($conn);   $merror="ERROR GRABANDO: ".substr($merror,0,91);  if(!$resultado){?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><? $error=1; } }
           else { $reg=pg_fetch_array($resultado); $ref_imput_presu=$reg["ref_imput_presu"]; $monto_c=$reg["monto"]+$monto_c; if($tipo_imput_presu=="C"){$monto_credito=$monto_c+$reg["monto_credito"];} $monto_c=cambia_coma_numero($monto_c); $monto_credito=cambia_coma_numero($monto_credito); 
			$sqlg="SELECT MOD_MONTOA_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$nro_orden_r','$tipo_causado_r',$monto_c,0)";
			$sqlg="SELECT MOD_MONTO_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$ref_imput_presu',$monto_c,$monto_credito)";
			$resultado=pg_exec($conn,$sqlg);  $merror=pg_errormessage($conn);   $merror="ERROR GRABANDO: ".substr($merror,0,90);  if(!$resultado){?><script language="JavaScript">muestra('<? echo $merror; ?>');</script><? $error=1; } }
         }
       }
	   //echo $total_retencion." ".$retencion." ".$g_comp_ret." ".$genera_orden_r." ".$ret_presup,"<br>";
       if(($total_retencion>0) and ($retencion=="N") and (($g_comp_ret=="N")Or($genera_orden_r=="N"))) { $prev_orden = ""; $sql="select nro_orden_ret,aux_orden,tipo_caus_ret,ref_comp_ret,tipo_comp_ret,cod_presup_ret,fuente_fin_ret,sum(monto_retencion) as monto_retencion from pag004 where (nro_orden_ret='$nro_orden') group by nro_orden_ret,aux_orden,tipo_caus_ret,ref_comp_ret,tipo_comp_ret,cod_presup_ret,fuente_fin_ret"; $res=pg_query($sql);
        // echo "PASO 2 ","<br>"; 
		 while($reg=pg_fetch_array($res)){ $aux_orden=$reg["aux_orden"]; $monto_r=$reg["monto_retencion"]; $monto_c=$reg["monto_retencion"]; $cod_presup=$reg["cod_presup_ret"]; $fuente_financ=$reg["fuente_fin_ret"]; $nro_orden_r=$reg["nro_orden_ret"]; $tipo_causado_r=$reg["tipo_caus_ret"]; $referencia_comp=$reg["ref_comp_ret"]; $tipo_compromiso=$reg["tipo_comp_ret"];
           if(($genera_orden_r=="N") and ($ret_presup=="S") and ($afecta_presu=="S")) {
			//echo "PASO 3 ","<br>"; 
            $sSQL="Select monto,monto_credito,ref_imput_presu from pre026 WHERE codigo_mov='$codigo_mov' and cod_presup='$cod_presup' and fuente_financ='$fuente_financ' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and referencia_caus='$nro_orden_r' and tipo_causado='$tipo_causado_r'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
            //echo $sSQL." ".$filas,"<br>";
			if($filas>0){  $reg=pg_fetch_array($resultado); $monto_c=$reg["monto"]-$monto_r;  $monto_credito=$reg["monto_credito"]; if ($monto_credito>=$monto_r){ $monto_credito=$reg["monto_credito"]-$monto_r;}
			$monto_c=cambia_coma_numero($monto_c); $monto_credito=cambia_coma_numero($monto_credito); $ref_imput_presu=$reg["ref_imput_presu"];
			$sqlg="SELECT MOD_MONTOA_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$nro_orden_r','$tipo_causado_r',$monto_c,0)";
			$sqlg="SELECT MOD_MONTO_PRE026('$codigo_mov','$cod_presup','$fuente_financ','$referencia_comp','$tipo_compromiso','$ref_imput_presu',$monto_c,$monto_credito)";
            //echo $sqlg." ".$monto_c." ".$monto_r,"<br>"; 			
			$resultado=pg_exec($conn,$sqlg);  $error=pg_errormessage($conn);   $error="ERROR GRABANDO: ".substr($error,0,91);  if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} }
           }		   
           if(($prev_orden!==$aux_orden) and ($g_comp_ret=="N")) { $prev_orden=$aux_orden; $sSQL="select referencia,cod_cuenta,monto_asiento,debito_credito from pag005 Where (referencia='$nro_orden') and (fecha='$fecha_orden') and (debito_credito='c')"; $res=pg_query($sSQL);
            while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_asiento"]; $cod_cuenta=$registro["cod_cuenta"];  $tipo_dc=$registro["debito_credito"];
              $sSQL="Select * from CON010 WHERE codigo_mov='$codigo_mov' and cod_cuenta='$cod_cuenta' and debito_credito='C'"; $resultado=pg_exec($conn,$sSQL); $filas=pg_numrows($resultado);
              if($filas>0){ $reg=pg_fetch_array($resultado);   $monto_c=$monto_asiento+$reg["monto_asiento"];  $monto_c=cambia_coma_numero($monto_c); if($monto_c>0){$resultado=pg_exec($conn,"SELECT MODIFICA_CUENTA_CON010('$codigo_mov','C','$cod_cuenta',$monto_c,'$descripcion_a')"); $F=$F+1; $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1;} } }
               else{$resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$nro_orden','C','$cod_cuenta','00000','',$monto_asiento,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn); $F=$F+1; $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }}  $t_haber=$t_haber+$monto_asiento;
            }
           }
         }
       }
       if($F==0){$error=1; ?> <script language="JavaScript"> muestra('LOCALIZANDO COMPROBANTE DE ORDEN :'+<? echo $nro_orden; ?>);</script><? }
       if($error==0){  $fecha2=formato_ddmmaaaa($fecha_e); if(FDate($fecha1)<FDate($fecha2)){ echo "Orden .".$nro_orden." Fecha: ".$fecha2.", Fecha Nota: ".$fecha1,"<br>"; $error=1; ?> <script language="JavaScript">  muestra('Fecha Nota Debito menor a Fecha Orden'); </script> <? } }
       if($error==0){ $resultado=pg_exec($conn,"SELECT INCLUYE_CON010('$codigo_mov','$num_nota','C','$codc_banco','00000','',$total_notas,'D','B','N','02','0','$descripcion_a')"); $error=pg_errormessage($conn); $F=$F+1; $error="ERROR GRABANDO: ".substr($error,0,91); if(!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? $error=1; }  $t_haber=$t_haber+$total_notas; }
       if($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
       if($balance>0.001){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NOTA NO CUADRA');</script><? }
       if(($t_debe==0)or($t_haber==0)){$error=1; echo $t_debe.' '.$t_haber.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
       if($error==0){ $resultado=pg_exec($conn,"SELECT SELECCIONA_PAG027('$codigo_mov','$nro_orden','$tipo_causado','I')"); $error=pg_errormessage($conn); $error=substr($error,0,91); if(!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <?  $error=1;}}
       if($error==0){ if($tasa_idb>0)  {$mstatus="I";$monto_idb=$total_notas*($tasa_idb/100); $monto_idb=Round($monto_idb, 2);} else{$cod_cont_idb=""; $mstatus="N"; $monto_idb=0;}    $sfecha=formato_aaaammdd($fecha_nota);
         $sSQL="SELECT INCLUYE_NDB_ORDEN('$codigo_mov','$cod_banco','$num_nota','$sfecha','$ced_rif',$total_notas,'N','','$usuario_sia','$minf_usuario','$mstatus',$monto_idb,'$cod_cont_idb','$codc_banco','$tipo_pago','$statusc','$descripcion')";  $resultado=pg_exec($conn,$sSQL);  $error=pg_errormessage($conn);  $error=substr($error,0,91);
         if(!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
         else{ $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?   $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");  $mvalor=pg_errormessage($conn); $mvalor=substr($mvalor,0,91); if(!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $mvalor; ?>'); </script> <? }  
		   /* */ 
		   $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error,0,91);if(!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? $error=1; } 
		 }
       }
     }
    }else{$error=1; ?> <script language="JavaScript"> muestra('ERROR LOCALIZANDO ORDEN :'+<? echo $nro_orden; ?>);</script><? }
  }
 }
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