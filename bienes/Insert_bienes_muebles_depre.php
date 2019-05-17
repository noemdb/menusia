<? include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");error_reporting(E_ALL); $cod_modulo="13";
$referencia=$_POST["txtreferencia"];$fecha=$_POST["txtfecha"];$met_calculo=$_POST["txtmet_calculo"];$descripcion=$_POST["txtdescripcion"];
$codigo_mov=$_POST["txtcodigo_mov"]; $nro_aut=$_POST["txtnro_aut"]; $ced_rif=$_POST["txtced_rif"]; $statusc="D"; $met_calculo=substr($met_calculo,0,1);
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
$url="Act_bienes_muebles_pro_depre_act.php?Greferencia_dep=".$referencia;
if ($error==0){ $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  $sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);   
  if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}
    $formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"];$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"]; $cod_fuente=$registro["campo512"]; $doc_comp=$registro["campo513"]; $ref_comp=$registro["campo514"];}
  
  $l_cat=0;$sql="Select * from SIA005 where campo501='05'"; $campo502="";    $resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; $formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$l_cat=strlen($formato_cat);} $aprueba_comp=substr($campo502,15,1);
  
  $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if ($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
  
  
  $tipo_dep="M"; $tipo_causado="0004"; $cod_fuente="00"; $fecha_d=$fecha; $gen_comp="N"; $afecta_presup="N";
  $sSQL="Select * from pag036 where codigo_mov='$codigo_mov'"; $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
  if ($filas>0){ $registro=pg_fetch_array($resultado); $cod_fuente=$registro["tipo_orden"]; $tipo_causado=$registro["tipo_causado"]; $fecha_d=$registro["cod_contable_o"]; $tipo_dep=$registro["pasivo_comp"]; $gen_comp=$registro["status_1"]; $afecta_presup=$registro["status_2"];  }
  
  
  if($error==0){  $sSQL="Select * from bien028 WHERE referencia_dep='$referencia'";
    $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas>0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE DEPRECIACION YA EXISTE');</script><?}
  }  
  $sfecha=formato_aaaammdd($fecha);
  if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);   $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE DEPRECIACION INVALIDA');</script><?}
  }
  if($error==0){$nmes=substr($fecha,3, 2);
	If ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DEPRECIACION MENOR A ULTIMO PERIODO CERRADO');</script><?}
  }  
  
    
  if($error==0){ $sql="SELECT * FROM BIEN050 where codigo_mov='$codigo_mov' order by cod_bien";  $res=pg_query($sql); $total=0;
    while($registro=pg_fetch_array($res)){    $total=$total+$registro["monto"];  $tipo_id=$registro["tipo_id"];   $monto_c=$registro["monto"]; $cod_bien_mue=$registro["cod_bien"];
       
	   if($met_calculo<>$tipo_id){ $error=1; ?> <script language="JavaScript"> muestra('TIPO CALCULO DEPRECIACION DIFERENTE AL DEL CALCULO');</script><? }
	   if($error==0){ $sSQL="Select * from BIEN015 WHERE cod_bien_mue='$cod_bien_mue'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
         if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN <? echo $cod_bien_mue; ?> NO EXISTE');</script><? }  
		  else{   $reg=pg_fetch_array($resultado); $desincorporado=$reg["desincorporado"];   
		      if(($desincorporado=="S")){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN <? echo $cod_bien_mue; ?> ESTA DESINCORPORADO');</script><?}
		  }
	    }
	}
    if($total==0){$error=1;?><script language="JavaScript">muestra('MONTO DEL MOVIMIENTO INVALIDO');</script><?}
  } $balance=0; $t_debe=0; $t_haber=0; 
  
  if($error==0){$sql="SELECT * FROM CON010 where codigo_mov='$codigo_mov' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
    while($registro=pg_fetch_array($res)){ $monto_asiento=$registro["monto_asiento"]; $cod_cuenta=$registro["cod_cuenta"];	    
		$sSQL="Select * from con001 WHERE codigo_cuenta='$cod_cuenta'"; $resultado=pg_query($sSQL); $filas=pg_num_rows($resultado);
        if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA <? echo $codigo_cuenta; ?> NO EXISTE');</script><? }
          else{ $reg=pg_fetch_array($resultado); if ($reg["cargable"]=="N"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DE CUENTA <? echo $codigo_cuenta; ?> NO ES CARGABLE');</script><?} }
	    if($error==0){   if ($registro["debito_credito"]=="D"){$t_debe=$t_debe+$registro["monto_asiento"];}else{$t_haber=$t_haber+$registro["monto_asiento"];} }
        $balance=$t_debe-$t_haber; $gen_comp="S";
	}	
	if($gen_comp=="S"){
	   if ($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
       if ($balance>0.001){$error=1; echo ' Debe:'.$t_debe.' Haber:'.$t_haber.' Balance:'.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
       if (($t_debe==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }	 

       if ($t_debe>$total){$balance=$t_debe-$total;}else{$balance=$total-$t_debe;}
       if ($balance>0.001){$error=1; echo ' Debe:'.$t_debe.' Total:'.$total.' Diferencia:'.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA CON TOTAL DEPRECIACION');</script><? }
       	   
	}
  }  
  $unidad_sol=""; $ref_compromiso="N"; $tipo_compromiso="0000"; $referencia_comp=""; if($ced_rif==""){ $ced_rif=$Rif_Emp; }
  if($error==0){ $sSQL="SELECT ced_rif FROM pre099 WHERE ced_rif='$ced_rif'";$resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('CEDULA/RIF BENEFICIARIO NO EXISTE');</script><?}
  }
  if(($error==0)and($afecta_presup=="S")){$sSQL="Select * from pre003 WHERE tipo_causado='$tipo_causado'"; $resultado=pg_exec($conn,$sSQL);$filas=pg_numrows($resultado);
    if ($filas==0){$error=1;?><script language="JavaScript">muestra('DOCUMENTO DE CAUSADO NO EXISTE');</script><?}
     else{if(($tipo_causado=="0000")or(substr($tipo_causado,0,1)=='A')){$error=1;?><script language="JavaScript">  muestra('DOCUMENTO DE CAUSADO NO VALIDO');</script><?}
      else{ $registro=pg_fetch_array($resultado); $ref_compromiso=$registro["ref_compromiso"];   }}
  }
  if(($error==0)and($afecta_presup=="S")){$sql="Select * from CODIGOS_PRE026 where codigo_mov='$codigo_mov' order by cod_presup"; $res=pg_query($sql);
    $total_c=0; $sfecha=formato_aaaammdd($fecha);
    while(($registro=pg_fetch_array($res))and($error==0)){
      $total_c=$total_c+$registro["monto"];$cod_presup=$registro["cod_presup"];$fuente_financ=$registro["fuente_financ"];
      $monto_c=$registro["monto"];$ref_imput_presu=$registro["ref_imput_presu"];$monto_credito=$registro["monto_credito"];
      $tipo_imput_presu=$registro["tipo_imput_presu"]; $referencia_comp=$registro["referencia_comp"];$tipo_compromiso=$registro["tipo_compromiso"];
      $unidad_sol=substr($cod_presup,0, $l_cat);
	  if($ref_compromiso=="NO"){ 
        if (verifica_disponibilidad($conn,$registro["cod_presup"],$registro["fuente_financ"],$fecha,$monto_c)==0){$error=0;}
         else{$error=1;?><script language="JavaScript">muestra('ERRRO EN EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
        if(($error==0)and($tipo_imput_presu=="C")){
          $sSQL="Select * from PRE010 WHERE (referencia_adicion='$ref_imput_presu') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";
          $res=pg_query($sSQL);$filas=pg_num_rows($res);
          if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?> \ncon NO EXISTE EN LA EJECUCIÓN DEL CREDITO ADICIONAL');</script><? }
           else{$reg=pg_fetch_array($res);
             if($registro["disponible"]<$monto_credito) {$error=1; $dispon=$registro["disponible"]; $dispon=formato_monto($dispon); ?> <script language="JavaScript"> muestra('CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?> \ncon Monto Mayor que Disponibilidad del Crédito Adicional, Disponibilidad: <? echo $dispon; ?> ');</script><? }
          }
        }
      }else{
	    $sSQL="Select * from PRE036 WHERE (ref_imput_presu='$ref_imput_presu') and (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ')";
        if($aprueba_comp=="S"){ $sSQL="Select * from PRE036 WHERE (ref_imput_presu='$ref_imput_presu') and (referencia_comp='$referencia_comp') and (tipo_compromiso='$tipo_compromiso') and (cod_presup='$cod_presup') and (fuente_financ='$fuente_financ') and (text(referencia_comp)||text(tipo_compromiso) not in ( select text(referencia_comp)||text(tipo_compromiso) from pre006 where ((anulado='S') or (aprobado='N')) ))"; }
		$resultado=pg_query($sSQL);$filas=pg_num_rows($resultado);
        if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('NO EXISTE EN EL COMPROMISO EL CODIGO PRESUPUESTARIO:<? echo $registro["cod_presup"]; ?> FUENTE:<? echo $registro["fuente_financ"]; ?> REF.CREDITO:<? echo $registro["ref_imput_presu"]; ?>');</script><?}
         else{$registro=pg_fetch_array($resultado);$compromiso=$registro["monto"]-$registro["causado"]-$registro["ajustado"];
           if ($compromiso>$monto_c){$diferencia=$compromiso-$monto_c; }else{$diferencia=$monto_c-$compromiso; }
		   if(($monto_c>$compromiso)and($diferencia>0.001)){$error=1; ?> <script language="JavaScript"> muestra('MONTO A CAUSAR MAYOR AL MONTO DEL CODIGO POR COMPROMETER');</script><? }
         }
      }
	}
	if ($total_c>$total){$balance=$total_c-$total;}else{$balance=$total-$total_c;}
    if ($balance>0.001){$error=1; echo ' Causado:'.$total_c.' Total:'.$total.' Diferencia:'.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('CAUSADO NO CUADRA CON TOTAL DEPRECIACION');</script><? }
       
  }
  
  if($error==0){$sfecha=formato_aaaammdd($fecha); $sql="SELECT ACTUALIZA_BIEN028(1,'$codigo_mov','$referencia','$sfecha','$met_calculo','$gen_comp','N','N','$sfecha','$afecta_presup','$tipo_causado','$minf_usuario','$ced_rif','$statusc','$unidad_sol','$referencia_comp','$tipo_compromiso','$descripcion')";
     $resultado=pg_exec($conn,$sql);  $error=pg_errormessage($conn);   $error=substr($error, 0, 61); echo $sql;
     if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
      else{ $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?
       $resultado=pg_exec($conn,"SELECT ELIMINA_BIEN050('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')"); $res=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);
       $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } }
  } 
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<?echo $url;?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }
?>
