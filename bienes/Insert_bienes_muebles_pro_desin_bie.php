<?include ("../class/conect.php");  include ("../class/funciones.php"); include ("../class/configura.inc");error_reporting(E_ALL); $cod_modulo="13";
$referencia_desin=$_POST["txtreferencia_desin"];$fecha_desin=$_POST["txtfecha_desin"];$tipo_desin=$_POST["txttipo_desin"];
$cod_dependencia=$_POST["txtcod_dependencia"]; $cod_conta_desin=$_POST["txtCodigo_Cuenta"];$cod_direccion=$_POST["txtcod_direccion"]; $cod_departamento=$_POST["txtcod_departamento"]; 
$cargo1=$_POST["txtcod_direccion"];$departamento1=$_POST["txtdenominacion_dir"];$cargo2=$_POST["txtcod_departamento"];$departamento2=$_POST["txtdenominacion_depart"];
$descripcion=$_POST["txtdescripcion"]; $codigo_mov=$_POST["txtcodigo_mov"]; $nro_aut=$_POST["txtnro_aut"]; $ced_rif=$_POST["txtced_rif"];
$status="N"; $nombre1=""; $nombre2=""; $des_desin="OTROS CONCEPTOS";$cargo3=""; $departamento3=""; $nombre3="";  $campo_str1="00000001";  $campo_str2="N"; $observacion=""; $statusc="D";
$url="Act_bienes_muebles_pro_desin_bie.php?Greferencia_desin=".$referencia_desin;
$equipo = getenv("COMPUTERNAME");$minf_usuario=$usuario_sia." ".$equipo." ".date("d/m/y H:i a"); echo "ESPERE POR FAVOR INCLUYENDO....","<br>";
if (checkData($fecha_desin)=='1'){$error=0; $sfecha=formato_aaaammdd($fecha_desin);}else{$error=1; ?> <script language="JavaScript">muestra('FECHA NO ES VALIDA');</script><? }
if ($error==0){  $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
  if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); }
  $sql="Select * from SIA005 where campo501='$cod_modulo'";$resultado=pg_query($sql);   
  if($registro=pg_fetch_array($resultado,0)){$cod_modulo=$registro["campo501"]; $campo502=$registro["campo502"]; $periodo=$registro["campo503"]; if($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}
  $formato_bien=$registro["campo504"];$long_num_bien=$registro["campo549"];$doc_caus_inm=$registro["campo509"]; $doc_caus_mue=$registro["campo510"]; $doc_caus_sem=$registro["campo511"];}
  $campo502="NNNNNNNNNNNNNNNNNNNN"; $sql="Select campo502,campo503,campo510 from SIA005 where campo501='06'"; $resultado=pg_query($sql);
  if ($registro=pg_fetch_array($resultado,0)){$campo502=$registro["campo502"]; if ($SIA_Periodo<$registro["campo503"]){$SIA_Periodo=$registro["campo503"];}} $comp_dif=substr($campo502,1,1); if($comp_dif=="S"){$statusc="D";}else{$statusc="A";}
  if($error==0){  $sSQL="Select * from bien045 WHERE referencia_desin='$referencia_desin'";
    $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
    if ($filas>0){$error=1;?><script language="JavaScript">muestra('REFERENCIA DESINCORPORACION YA EXISTE');</script><?}
  }
  if($error==0){$sql="SELECT cod_dependencia,denominacion_dep  FROM bien001 where cod_dependencia='$cod_dependencia'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
     if($filas==0){$error=1; echo $cod_dependen; ?> <script language="JavaScript"> muestra('CODIGO DEPENDENCIA NO EXISTE');</script><? }
  }
  if($error==0){$sql="SELECT cod_direccion,denominacion_dir FROM bien005 where cod_dependencia='$cod_dependencia' and cod_direccion='$cod_direccion'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
    if($filas==0){$error=1; echo $cod_direcci; ?> <script language="JavaScript"> muestra('CODIGO DIRECCION NO EXISTE');</script><? }
	else{ $registro=pg_fetch_array($resultado); $departamento1=$registro["denominacion_dir"];}
  }
  if($error==0){$sql="Select denominacion_dep from BIEN006 WHERE cod_dependencia='$cod_dependencia' and cod_direccion='$cod_direccion' and cod_departamento='$cod_departamento'"; $resultado=pg_query($sql);  $filas=pg_num_rows($resultado);
    if($filas==0){$error=1; echo $cod_departamento; ?> <script language="JavaScript"> muestra('CODIGO DEPARTAMENTO NO EXISTE');</script><? }
	else{  $registro=pg_fetch_array($resultado); $departamento2=$registro["denominacion_dep"];}
  }
  if($error==0){ $sSQL="Select denomina_tipo from BIEN003 WHERE codigo='$tipo_desin'";  $resultado=pg_exec($conn,$sSQL);  $filas=pg_numrows($resultado);
     if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO TIPO DE DESINCORPORACION NO EXISTE');</script> <? }
   }   
  if($error==0){ $fecha_d=formato_ddmmaaaa($Fec_Ini_Ejer);   $fecha_h=formato_ddmmaaaa($Fec_Fin_Ejer);
    if (($sfecha>$Fec_Fin_Ejer)or($sfecha<$Fec_Ini_Ejer)){$error=1;?><script language="JavaScript">muestra('FECHA DE DESINCORPORACION INVALIDA');</script><?}
  }  
  if($error==0){$nmes=substr($fecha_desin,3, 2);
	If ($SIA_Periodo>$nmes){$error=1;?><script language="JavaScript">muestra('FECHA DESINCORPORACION MENOR A ULTIMO PERIODO CERRADO');</script><?}
  }
  if($error==0){ $sql="SELECT * FROM BIEN050 where codigo_mov='$codigo_mov' order by cod_bien";  $res=pg_query($sql); $total=0;
    while($registro=pg_fetch_array($res)){    $total=$total+$registro["monto"];     $monto_c=$registro["monto"]; $cod_bien_mue=$registro["cod_bien"];
       if($error==0){ $sSQL="Select * from BIEN015 WHERE cod_bien_mue='$cod_bien_mue'";  $resultado=pg_query($sSQL);  $filas=pg_num_rows($resultado);
         if ($filas==0){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN <? echo $cod_bien_mue; ?> NO EXISTE');</script><? }  
		  else{   $reg=pg_fetch_array($resultado); $desincorporado=$reg["desincorporado"];   $cod_empb=$reg["cod_empresa"]; 
            $cod_depb=$reg["cod_dependencia"];   $cod_dirb=$reg["cod_direccion"];  $cod_departb=$reg["cod_departamento"]; 
		    if($cod_depb<>$cod_dependencia) {$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEPENDECIA DEL BIEN <? echo $cod_bien_mue; ?> DIFERENTE A LA DEL MOVIMIENTO');</script><? }
			if($cod_dirb<>$cod_direccion) {$error=1; ?> <script language="JavaScript"> muestra('CODIGO DIRECCION DEL BIEN <? echo $cod_bien_mue; ?> DIFERENTE A LA DEL MOVIMIENTO');</script><? }
			if($cod_departb<>$cod_departamento) {$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEPARTAMENTO DEL BIEN <? echo $cod_bien_mue; ?> DIFERENTE A LA DEL MOVIMIENTO');</script><? }
		    if($desincorporado=="S"){$error=1; ?> <script language="JavaScript"> muestra('CODIGO DEL BIEN <? echo $cod_bien_mue; ?> ESTA DESINCORPORADO');</script><?}
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
        $balance=$t_debe-$t_haber; $campo_str2="S";
	}	
	if($campo_str2=="S"){
	   if ($t_debe>$t_haber){$balance=$t_debe-$t_haber;}else{$balance=$t_haber-$t_debe;}
       if ($balance>0.001){$error=1; echo ' Debe:'.$t_debe.' Haber:'.$t_haber.' Balance:'.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE CONTABLE NO CUADRA');</script><? }
       if (($t_debe==0)){$error=1; ?> <script language="JavaScript"> muestra('MONTO DEL COMPROBANTE CONTABLE NO VALIDO');</script><? }
	   if($error==0){ if ($t_debe>$total){$balance=$t_debe-$total;}else{$balance=$total-$t_debe;}
         if($balance>0.001){$error=1; echo 'Comprobante:'.$t_debe.' Movimiento:'.$total.' '.formato_monto($balance),"<br>"; ?> <script language="JavaScript"> muestra('COMPROBANTE NO CUADRA CON TOTAL MOVIMIENTO');</script><? } }
	}
  }
  if($error==0){$sfecha=formato_aaaammdd($fecha_desin); if($ced_rif==""){ $ced_rif=$Rif_Emp; }
     $sSQL="SELECT actualiza_bien045(1,'$codigo_mov','$referencia_desin','$sfecha','$cod_dependencia','$tipo_desin','$status','$cod_conta_desin','$cargo1','$departamento1','$nombre1','$cargo2','$departamento2','$nombre2','$cargo3','$departamento3','$nombre3','$campo_str1','$campo_str2','$observacion','$usuario_sia','$minf_usuario','$descripcion',0,'$statusc','$ced_rif')";
     $resultado=pg_exec($conn,$sSQL); $error=pg_errormessage($conn); $error=substr($error, 0, 91); if (!$resultado){?><script language="JavaScript"> muestra('<? echo $error; ?>');</script><? $error=1;}
      else{  $error=0;?><script language="JavaScript"> muestra('INCLUYO EXITOSAMENTE');</script><?
	   $resultado=pg_exec($conn,"SELECT ELIMINA_BIEN050('$codigo_mov')"); $resultado=pg_exec($conn,"SELECT ELIMINA_CON010('$codigo_mov')");
       $resultado=pg_exec($conn,"SELECT ACTUALIZA_PAG036(3,'$codigo_mov','00000000','0000','','','','NO')");  $error=pg_errormessage($conn); $error=substr($error, 0, 91);  if (!$resultado){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? } }
  } 
}
pg_close();
if ($error==0){?><script language="JavaScript">document.location ='<?echo $url;?>';</script> <? } else {?>  <script language="JavaScript">history.back();</script> <? }
?>

