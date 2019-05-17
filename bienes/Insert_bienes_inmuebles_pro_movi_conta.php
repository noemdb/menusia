<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");error_reporting(E_ALL); $cod_modulo="13";
$referencia=$_POST["txtreferencia"];$fecha=$_POST["txtfecha"];$cod_dependencia=$_POST["txtcod_dependencia"];$descripcion=$_POST["txtdescripcion"];
$codigo_mov=$_POST["txtcodigo_mov"]; $nro_aut=$_POST["txtnro_aut"]; $ced_rif=$_POST["txtced_rif"]; $statusc="D";
$equipo = getenv("COMPUTERNAME");$minf_usuario = $usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha)=='1'){$error=0;}else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
$url="Act_bienes_inmuebles_pro_movi_conta.php?Greferencia=".$referencia;
if ($error==0){ $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  $sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);   
  if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}
  $formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"];$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"];}
  $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if ($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
  if($error==0){  $sSQL="Select * from bien024 WHERE referencia='$referencia'";
    $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas>0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DE MOVIMIENTO YA EXISTE');</script><?}
  }  
  $sfecha=formato_aaaammdd($fecha);
  if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);   $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE MOVIMIENTO INVALIDA');</script><?}
  }
  if($error==0){$nmes=substr($fecha,3, 2);
	If ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA MOVIMIENTO MENOR A ULTIMO PERIODO CERRADO');</script><?}
  }  
  if($error==0){ $sql="SELECT * FROM BIEN050 where codigo_mov='$codigo_mov' order by cod_bien";  $res=pg_query($sql); $total=0;
    while($registro=pg_fetch_array($res)){    $total=$total+$registro["monto"];  $tipo_id=$registro["tipo_id"];   $monto_c=$registro["monto"]; $cod_bien_mue=$registro["cod_bien"];
       if($error==0){ $sSQL="Select * from BIEN014 WHERE cod_bien_inm='$cod_bien_mue'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
         if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN <? echo $cod_bien_mue; ?> NO EXISTE');</script><? }  
		  else{   $reg=pg_fetch_array($resultado); $desincorporado=$reg["desincorporado"];   $cod_empb=$reg["cod_empresa"]; 
            $cod_depb=$reg["cod_dependencia"];   $cod_dirb=$reg["cod_direccion"];  $cod_departb=$reg["cod_departamento"]; 
		    if($cod_depb<>$cod_dependencia) {$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEPENDECIA DEL BIEN <? echo $cod_bien_mue; ?> DIFERENTE A LA DEL MOVIMIENTO');</script><? }
			if(($desincorporado=="S")and($tipo_id=="I")){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN <? echo $cod_bien_mue; ?> ESTA DESINCORPORADO');</script><?}
		  }
	    }
	}
    if($total==0){$error=1;?><script language="JavaScript">muestra('MONTO DEL MOVIMIENTO INVALIDO');</script><?}
  } $balance=0; $t_debe=0; $t_haber=0; $gen_comp="N";
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
	}
  }  
  if($error==0){$sfecha=formato_aaaammdd($fecha); if($ced_rif==""){ $ced_rif=$Rif_Emp; }
     $resultado=pg_exec($conn,"SELECT actualiza_bien024(1,'$codigo_mov','$referencia','$sfecha','$cod_dependencia','$gen_comp','N','N','$sfecha',0,'$minf_usuario','$descripcion','$statusc','$ced_rif')");
     $error=pg_errormessage($conn);   $error=substr($error, 0, 61);
     if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
      else{ $error=0;?><script language="JavaScript">  muestra('INCLUYO EXITOSAMENTE');</script><?
       $resultado=pg_exec($conn,"SELECT ELIMINA_BIEN050('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");
       $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 61);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } }
  } 
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<?echo $url;?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }
?>

