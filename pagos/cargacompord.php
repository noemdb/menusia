<?php include ("../class/conect.php");  include ("../class/funciones.php");  $password=$_GET["password"]; $user=$_GET["user"]; $todos=$_GET["todos"]; $dbname=$_GET["dbname"];$ced_rif=$_GET["criterio"]; $codigo_mov=$_GET["codigo_mov"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $cod_part_iva="403-18-01"; $c=13; $p=15;
$formato_presup="XX-XX-XX-XXX-XX-XX-XX";  $formato_categoria="XX-XX-XX";  $formato_partida="XXX-XX-XX-XX"; $campo502=""; 
$sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];  $campo502=$registro["campo502"];}
$long_c=strlen($formato_presup); $c=strlen($formato_categoria)+2; $p=strlen($formato_partida); $li=strlen($cod_part_iva); $g_comprobante=substr($campo502,3,1); $aprueba_comp=substr($campo502,15,1);
$resultado=pg_exec($conn,"SELECT BORRAR_PRE026('$codigo_mov')"); $error=pg_errormessage($conn); $error=substr($error, 0, 61);
$sql="SELECT * FROM codigos_compromisos where (monto-causado-ajustado>0) and (tipo_compromiso<>'0000') and (tipo_compromiso<>'A000') and (ced_rif='$ced_rif') order by cod_presup";
$sql="SELECT * FROM codigos_compromisos where (monto-causado-ajustado>0) and (tipo_compromiso<>'0000') and (tipo_compromiso<>'A000') and (ced_rif='$ced_rif') and (text(referencia_comp)||text(tipo_compromiso) not in ( select text(referencia_comp)||text(tipo_compromiso) from pre006 where (anulado='S')  and (ced_rif='$ced_rif'))) order by cod_presup";
if($aprueba_comp=="S"){$sql="SELECT * FROM codigos_compromisos where (monto-causado-ajustado>0) and (tipo_compromiso<>'0000') and (tipo_compromiso<>'A000') and (ced_rif='$ced_rif') and (text(referencia_comp)||text(tipo_compromiso) not in ( select text(referencia_comp)||text(tipo_compromiso) from pre006 where ((anulado='S') or (aprobado='N')) and (ced_rif='$ced_rif'))) order by cod_presup"; }
$res=pg_query($sql); //echo $sql,"<br>";
while($registro=pg_fetch_array($res)){ $monto=$registro["monto"]-$registro["causado"]-$registro["ajustado"];
  //echo $monto,"<br>";
  if($monto<>0){  $referencia_comp=$registro["referencia_comp"];  $tipo_compromiso=$registro["tipo_compromiso"];
    $cod_presup=$registro["cod_presup"]; $fuente=$registro["fuente_financ"];
    $cod_contable=$registro["cod_contable"]; $fecha=$registro["fecha_compromiso"];
    $tipo_imput_presu=$registro["tipo_imput_presu"]; $ref_imput_presu=$registro["ref_imput_presu"];
    $amort_anticipo=$registro["tasa_anticipo"]; $cod_anticipo=$registro["cod_con_anticipo"];
	$genera_comprobante=$registro["genera_comprobante"]; $cod_con_g_pagar=$registro["cod_con_g_pagar"]; 
	if(($genera_comprobante=="S")and($g_comprobante=="S")){$cod_contable=$cod_con_g_pagar;}
    if($tipo_imput_presu=="C"){$montoc=$monto;}else{$montoc=0;} $montoc=0; $filas=0;
	if($todos=="SI"){$filas=1;}
    else{$ssql="SELECT * FROM PAG029 where codigo_mov='$codigo_mov' and ref_compromiso='$referencia_comp' and tipo_compromiso='$tipo_compromiso'";$resultado=pg_query($ssql); $filas=pg_num_rows($resultado); }
    if($filas>0){ $monto=cambia_coma_numero($monto);$montoc=cambia_coma_numero($montoc);	
	$ssql="SELECT INCLUYE_PRE026('$codigo_mov','$cod_presup','$fuente','$referencia_comp','$tipo_compromiso','','0000','','0000','','0000','','','','$cod_contable','$cod_anticipo','','$fecha','C','$tipo_imput_presu','$ref_imput_presu','$fecha',0,$monto,$montoc,$amort_anticipo)";
    $resultado=pg_exec($conn,$ssql); $error=pg_errormessage($conn);}
  }
} $t_amort=0; $tiene_anticipo="NO";
/**/
$sql="SELECT * FROM PAG029 where codigo_mov='$codigo_mov' order by nro_factura";$res=pg_query($sql);
while($registro=pg_fetch_array($res))
{ $referencia_comp=$registro["ref_compromiso"];  $tipo_compromiso=$registro["tipo_compromiso"]; $montos=$registro["monto_sin_iva"]; $montoi=$registro["monto_iva1"]; $monto3=$registro["monto_iva3_so"];
  $Ssql="SELECT sum(monto_presup) as t_comp FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' and substring(cod_presup from ".$c." for ".$li.")<>'$cod_part_iva' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'";
  $resultado=pg_query($Ssql); $montop=0; 
  if ($reg=pg_fetch_array($resultado,0)){ $montop=$reg["t_comp"];} 
  if($montop<>0){$Ssql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' and substring(cod_presup from ".$c." for ".$li.")<>'$cod_part_iva' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'";$resultado=pg_query($Ssql);
    while($reg=pg_fetch_array($resultado)) { $pmontoa=$reg["monto_presup"]; $amort_anticipo=$reg["amort_anticipo"]; $monto_credito=$reg["monto_credito"];
     $cod_presup=$reg["cod_presup"]; $fuente=$reg["fuente_financ"]; $cod_contable=$reg["cod_con_g_pagar"]; $fecha=$reg["fecha_aep"]; $cod_anticipo=$reg["ref_aep"]; $tipo_imput_presu=$reg["tipo_imput_presu"];  $ref_imput_presu=$reg["ref_imput_presu"];
     
	 if ($pmontoa<>0){ $temp_cod=substr($cod_presup,$c-1,$li);  if($temp_cod==$cod_part_iva){$montof=$montoi;}else{$montof=$montos-$monto3;}
        $mmontoa=$pmontoa*($montof/$montop); $mmontoa=round($mmontoa,2);
        if($pmontoa>=$mmontoa){$monto=$mmontoa;} else{$monto=$pmontoa;} $t_amort=$t_amort+$amort_anticipo;
        if($tipo_imput_presu=="C"){$monto_credito=$monto;}else{$monto_credito=0;}
        $Ssql2="SELECT MODIFICA_PRE026('$codigo_mov','$cod_presup','$fuente','$referencia_comp','$tipo_compromiso','','0000','','0000','','0000','','','','$cod_contable','$cod_anticipo','','$fecha','C','$tipo_imput_presu','$ref_imput_presu','$fecha',$monto,$pmontoa,$monto_credito,$amort_anticipo)";
        $Ssql2="SELECT MOD_MONTO_PRE026('$codigo_mov','$cod_presup','$fuente','$referencia_comp','$tipo_compromiso','$ref_imput_presu',$monto,$monto_credito)";
        $Ssql2="SELECT MOD_MONTO_FACT_PRE026('$codigo_mov','$cod_presup','$fuente','$referencia_comp','$tipo_compromiso','$ref_imput_presu',$monto,$monto_credito)";
    	$res2=pg_exec($conn,$Ssql2);  $error=pg_errormessage($conn);
		
     }
    }
  }
  $Ssql="SELECT sum(monto_presup) as t_comp FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' and substring(cod_presup from ".$c." for ".$li.")='$cod_part_iva' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'";
  $resultado=pg_query($Ssql); $montop=0;
  if ($reg=pg_fetch_array($resultado,0)){ $montop=$reg["t_comp"];}
  if($montop<>0){$Ssql="SELECT * FROM CODIGOS_PRE026 where codigo_mov='$codigo_mov' and substring(cod_presup from ".$c." for ".$li.")='$cod_part_iva' and referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso'";$resultado=pg_query($Ssql);
    while($reg=pg_fetch_array($resultado)) { $pmontoa=$reg["monto_presup"]; $amort_anticipo=$reg["amort_anticipo"]; $monto_credito=$reg["monto_credito"];
     $cod_presup=$reg["cod_presup"]; $fuente=$reg["fuente_financ"]; $cod_contable=$reg["cod_con_g_pagar"]; $fecha=$reg["fecha_aep"]; $cod_anticipo=$reg["ref_aep"]; $tipo_imput_presu=$reg["tipo_imput_presu"];  $ref_imput_presu=$reg["ref_imput_presu"];
     
	 if ($pmontoa<>0){ $temp_cod=substr($cod_presup,$c-1,$li);  if($temp_cod==$cod_part_iva){$montof=$montoi;}else{$montof=$montos;}
        $mmontoa=$pmontoa*($montof/$montop); $mmontoa=round($mmontoa,2);
        if($pmontoa>=$mmontoa){$monto=$mmontoa;} else{$monto=$pmontoa;} $t_amort=$t_amort+$amort_anticipo;
        if($tipo_imput_presu=="C"){$monto_credito=$monto;}else{$monto_credito=0;}
        $Ssql2="SELECT MODIFICA_PRE026('$codigo_mov','$cod_presup','$fuente','$referencia_comp','$tipo_compromiso','','0000','','0000','','0000','','','','$cod_contable','$cod_anticipo','','$fecha','C','$tipo_imput_presu','$ref_imput_presu','$fecha',$monto,$pmontoa,$monto_credito,$amort_anticipo)";
        $Ssql2="SELECT MOD_MONTO_PRE026('$codigo_mov','$cod_presup','$fuente','$referencia_comp','$tipo_compromiso','$ref_imput_presu',$monto,$monto_credito)";
        $Ssql2="SELECT MOD_MONTO_FACT_PRE026('$codigo_mov','$cod_presup','$fuente','$referencia_comp','$tipo_compromiso','$ref_imput_presu',$monto,$monto_credito)";
        
		$res2=pg_exec($conn,$Ssql2);  $error=pg_errormessage($conn);
     }
    }
  }
}
if ($t_amort>0){ $monto_anticipo=0;$codigo_cuenta="";
 $sql="Select PRE026.tipo_compromiso,PRE026.referencia_comp,PRE026.monto,PRE026.amort_anticipo,PRE006.cod_con_anticipo from PRE026,PRE006 where (PRE026.tipo_compromiso=PRE006.tipo_compromiso) and (PRE026.referencia_comp=PRE006.referencia_comp) and (PRE026.codigo_mov='$codigo_mov') and (PRE026.tipo_compromiso<>'0000') and (PRE026.amort_anticipo<>0) order by PRE026.tipo_compromiso,PRE026.referencia_comp,PRE026.cod_presup";
 $res=pg_query($sql);
 while($reg=pg_fetch_array($res)){ $tiene_anticipo="SI"; $tasa=$reg["amort_anticipo"]; $monto_c=$reg["monto"]; $monto_a=$monto_c*($tasa/100); // $monto_a=formato_monto($monto_a);
  $monto_anticipo=$monto_anticipo+$monto_a; $codigo_cuenta=$reg["cod_con_anticipo"];}
}
$tiene_anticipo=substr($tiene_anticipo,0,1);
if($tiene_anticipo=="S") {$sSQL="SELECT UPDATE_PAG036_ANT('$codigo_mov',$monto_anticipo,'$tiene_anticipo','$codigo_cuenta')";  $resultado=pg_exec($conn,$sSQL);}

pg_close();
?><iframe src="Det_inc_comp_ord.php?codigo_mov=<?echo $codigo_mov?>"  width="846" height="290" scrolling="auto" frameborder="0"> </iframe>