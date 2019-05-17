<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
$tipo_pago_d=$_GET["tipo_pago_d"];$tipo_pago_h=$_GET["tipo_pago_h"];$referencia_d=$_GET["referencia_d"]; $referencia_h=$_GET["referencia_h"];
$ref_caus_d=$_GET["ref_caus_d"]; $ref_caus_h=$_GET["ref_caus_h"];  $tipo_rep=$_GET["tipo_rep"];$fecha_d=$_GET["fecha_d"]; $fecha_h=$_GET["fecha_h"];$cod_presupd=$_GET["cod_presupd"]; $cod_presuph=$_GET["cod_presuph"];
$cod_fuente_d=$_GET["cod_fuente_d"]; $cod_fuente_h=$_GET["cod_fuente_h"];$cedula_d=$_GET["cedula_d"]; $cedula_h=$_GET["cedula_h"];$tipo_regis=$_GET["tipo_regis"];
$date = date("d-m-Y");$hora = date("H:i:s a");$Sql=""; $criterio_est="";  $cod_mov="PRE021".$usuario_sia;
  if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}$fecha_desde=$ano1.$mes1.$dia1;
  if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
  if ($tipo_regis=='TO'){$nombre='TODOS';}
  if($tipo_regis=='ANU'){$nombre='ANULADOS'; $criterio_est="(pre008.anulado='S') And ";}
  if($tipo_regis=='AJU'){$nombre='AJUSTADOS';  $criterio_est="(pre038.ajustado<>0) And ";}
  if($tipo_regis=='NANU'){$nombre='NI ANULADOS,NI AJUSTADOS'; $criterio_est="(pre008.anulado='N') And (pre038.ajustado=0) And ";}
$mcontrol=array (0,0,0,0,0,0,0,0,0,0);
function buscar_control($clave, $formato){  global $mcontrol;  $j=0;
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }  
  return $actual;
}

  $criteriopa="(Tipo_Pago>='$tipo_pago_d' and Tipo_Pago<='$tipo_pago_h') And (Referencia_Pago>='$referencia_d' and Referencia_Pago<='$referencia_h') And (Referencia_Caus>='$ref_caus_d' and Referencia_Caus<='$ref_caus_h') And (Fecha_Pago>='$fecha_desde' and Fecha_Pago<='$fecha_hasta') And (Cod_Presup>='$cod_presupd' and Cod_Presup<='$cod_presuph') And (Fuente_Financ>='$cod_fuente_d' and Fuente_Financ<='$cod_fuente_h') And (Ced_Rif>='$cedula_d' and Ced_Rif<='$cedula_h')";
  $criteriopa="(Tipo_Pago>='$tipo_pago_d' and Tipo_Pago<='$tipo_pago_h') And (Referencia_Pago>='$referencia_d' and Referencia_Pago<='$referencia_h') And (Referencia_Caus>='$ref_caus_d' and Referencia_Caus<='$ref_caus_h') And (fecha_doc>='$fecha_desde' and fecha_doc<='$fecha_hasta') And (Ced_Rif>='$cedula_d' and Ced_Rif<='$cedula_h')";
  
  $criteriop=$criterio_est."(pre008.Tipo_Pago>='$tipo_pago_d' and pre008.Tipo_Pago<='$tipo_pago_h') And (pre008.Referencia_Pago>='$referencia_d' and pre008.Referencia_Pago<='$referencia_h') And (pre008.Referencia_Caus>='$ref_caus_d' and pre008.Referencia_Caus<='$ref_caus_h') And (pre008.Fecha_Pago>='$fecha_desde' and pre008.Fecha_Pago<='$fecha_hasta') And (pre038.Cod_Presup>='$cod_presupd' and pre038.Cod_Presup<='$cod_presuph') And (pre038.Fuente_Financ>='$cod_fuente_d' and pre038.Fuente_Financ<='$cod_fuente_h') And (pre008.Ced_Rif>='$cedula_d' and pre008.Ced_Rif<='$cedula_h')";
  $criteriop=$criterio_est."(pre008.Tipo_Pago>='$tipo_pago_d' and pre008.Tipo_Pago<='$tipo_pago_h') And (pre008.Referencia_Pago>='$referencia_d' and pre008.Referencia_Pago<='$referencia_h') And (pre008.Referencia_Caus>='$ref_caus_d' and pre008.Referencia_Caus<='$ref_caus_h') And (pre008.Fecha_Pago>='$fecha_desde' and pre008.Fecha_Pago<='$fecha_hasta') And (pre008.Ced_Rif>='$cedula_d' and pre008.Ced_Rif<='$cedula_h')";
    
  $cfecha_h=formato_aaaammdd($fecha_h); $cfecha_d=formato_aaaammdd($fecha_d);	
$criterio1="Fecha Desde : ".$fecha_d."   "."Hasta : ".$fecha_h; $criterio2=$nombre;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
   $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
   if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
   $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;
   $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presupd,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
	$pos=strrpos($cod_presupd,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($cod_presuph,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
	if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$cod_presupd); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$cod_presuph); $long_h=strlen($codigo_h);
		if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
		   for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; if($i==0){$a=0;}else{$a=$mcontrol[$i-1];} 
			 if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
				$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
				$criterio=$criterio."substring(pre038.cod_presup,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(pre038.cod_presup,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
		   } $criterio=$criterio."and  pre038.fuente_financ>='".$cod_fuente_d."' and pre038.fuente_financ<='".$cod_fuente_h."'";
		}else{$criterio="pre038.cod_presup>='".$codigo_d."' and pre038.cod_presup<='".$codigo_h."' and  pre038.fuente_financ>='".$cod_fuente_d."' and pre038.fuente_financ<='".$cod_fuente_h."'";}
	}else{$criterio="pre038.cod_presup>='".$cod_presupd."' and pre038.cod_presup<='".$cod_presuph."' and  pre038.fuente_financ>='".$cod_fuente_d."' and pre038.fuente_financ<='".$cod_fuente_h."'";}
	$criteriop=$criteriop." and (".$criterio.")";
  
	$sSQL = "SELECT pre008.Referencia_Pago, pre008.Fecha_Pago, pre008.Tipo_Pago,pre004.Nombre_Abrev_Pago, pre008.Anulado, pre004.RefiereA,
          pre008.Referencia_Comp, pre008.Tipo_Compromiso, pre002.Nombre_Abrev_Comp, pre008.Referencia_Caus, pre008.Tipo_Causado, pre003.Nombre_Abrev_Caus, pre008.Descripcion_Pago, 
          pre008.cod_banco, pre008.Ced_Rif, pre099.Nombre, pre038.Cod_Presup, pre038.Fuente_Financ, pre001.denominacion, to_char(pre008.Fecha_Pago,'DD/MM/YYYY') as fechad,
          pre038.Monto, pre038.Ajustado FROM pre001, pre002, pre003, pre004, pre008, pre038, pre099
          WHERE pre001.Cod_Presup = pre038.Cod_Presup And pre038.Fuente_Financ=pre001.Cod_Fuente  AND pre002.Tipo_Compromiso = pre008.Tipo_Compromiso AND 
          pre003.Tipo_Causado = pre008.Tipo_Causado AND pre004.Tipo_Pago = pre008.Tipo_Pago AND pre038.Referencia_Pago = pre008.Referencia_Pago AND pre038.Tipo_Pago = pre008.Tipo_Pago AND            
		  pre038.Referencia_Caus = pre008.Referencia_Caus AND pre038.Tipo_Causado = pre008.Tipo_Causado AND  pre038.Referencia_Comp = pre008.Referencia_Comp AND pre038.Tipo_Compromiso = pre008.Tipo_Compromiso AND pre008.cod_banco=pre038.cod_banco and  pre008.Ced_Rif = pre099.Ced_Rif AND ".$criteriop."
          ORDER BY pre008.Fecha_Pago, pre008.Referencia_Pago, pre008.Tipo_Pago";



$StrSQL = "DELETE FROM PRE021 Where (tipo_registro='P') And (nombre_usuario='".$cod_mov."')";
$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

		  
if($cfecha_h==$Fec_Fin_Ejer){$StrSQL= "INSERT INTO PRE021 SELECT '$cod_mov' as nombre_usuario,'P' as tipo_registro,pre008.Referencia_Comp,pre008.Tipo_Compromiso,PRE002.Nombre_Abrev_Comp,PRE002.Nombre_Tipo_Comp,
pre008.referencia_caus,pre008.tipo_causado,PRE003.nombre_tipo_caus,PRE003.nombre_abrev_caus,pre008.Referencia_Pago,pre008.Tipo_Pago,pre004.Nombre_Tipo_Pago,pre004.Nombre_Abrev_Pago, pre038.Cod_Presup,pre038.Fuente_Financ,PRE001.Denominacion,
pre008.Fecha_Pago as fecha_doc,pre008.Ref_AEP,pre008.Num_Proyecto, pre008.Fecha_AEP,'' as Tipo_Documento,'' as Nro_Documento,pre008.Anulado,pre008.Fecha_Anu AS Fecha_Anulado, pre008.Ced_Rif,
PRE099.Nombre as Nombre_Benef,pre038.Monto,0 as Comprometido,0 as Causado, pre038.Monto as Pagado,pre038.Ajustado as Ajustado,pre008.Func_Inv,
pre038.Tipo_Imput_Presu,pre038.Ref_Imput_Presu, pre038.Monto_Credito,pre008.inf_usuario,pre008.Descripcion_Pago as Descripcion_Doc  FROM pre001, pre002, pre003, pre004, pre008, pre038, pre099
          WHERE pre001.Cod_Presup = pre038.Cod_Presup And pre038.Fuente_Financ=pre001.Cod_Fuente  AND pre002.Tipo_Compromiso = pre008.Tipo_Compromiso AND 
          pre003.Tipo_Causado = pre008.Tipo_Causado AND pre004.Tipo_Pago = pre008.Tipo_Pago AND pre038.Referencia_Pago = pre008.Referencia_Pago AND pre038.Tipo_Pago = pre008.Tipo_Pago AND            
		  pre038.Referencia_Caus = pre008.Referencia_Caus AND pre038.Tipo_Causado = pre008.Tipo_Causado AND  pre038.Referencia_Comp = pre008.Referencia_Comp AND pre038.Tipo_Compromiso = pre008.Tipo_Compromiso AND pre008.cod_banco=pre038.cod_banco and  pre008.Ced_Rif = pre099.Ced_Rif AND ".$criteriop; }
else{$StrSQL= "INSERT INTO PRE021 SELECT '$cod_mov' as nombre_usuario,'P' as tipo_registro,pre008.Referencia_Comp,pre008.Tipo_Compromiso,PRE002.Nombre_Abrev_Comp,PRE002.Nombre_Tipo_Comp,
pre008.referencia_caus,pre008.tipo_causado,PRE003.nombre_tipo_caus,PRE003.nombre_abrev_caus,pre008.Referencia_Pago,pre008.Tipo_Pago,pre004.Nombre_Tipo_Pago,pre004.Nombre_Abrev_Pago, pre038.Cod_Presup,pre038.Fuente_Financ,PRE001.Denominacion,
pre008.Fecha_Pago as fecha_doc,pre008.Ref_AEP,pre008.Num_Proyecto, pre008.Fecha_AEP,'' as Tipo_Documento,'' as Nro_Documento,pre008.Anulado,pre008.Fecha_Anu AS Fecha_Anulado, pre008.Ced_Rif,
PRE099.Nombre as Nombre_Benef,pre038.Monto,0 as Comprometido,0 as Causado, 0 as Pagado,0 as Ajustado,pre008.Func_Inv,
pre038.Tipo_Imput_Presu,pre038.Ref_Imput_Presu, pre038.Monto_Credito,pre008.inf_usuario,pre008.Descripcion_Pago as Descripcion_Doc  FROM pre001, pre002, pre003, pre004, pre008, pre038, pre099
          WHERE pre001.Cod_Presup = pre038.Cod_Presup And pre038.Fuente_Financ=pre001.Cod_Fuente  AND pre002.Tipo_Compromiso = pre008.Tipo_Compromiso AND 
          pre003.Tipo_Causado = pre008.Tipo_Causado AND pre004.Tipo_Pago = pre008.Tipo_Pago AND pre038.Referencia_Pago = pre008.Referencia_Pago AND pre038.Tipo_Pago = pre008.Tipo_Pago AND            
		  pre038.Referencia_Caus = pre008.Referencia_Caus AND pre038.Tipo_Causado = pre008.Tipo_Causado AND  pre038.Referencia_Comp = pre008.Referencia_Comp AND pre038.Tipo_Compromiso = pre008.Tipo_Compromiso AND pre008.cod_banco=pre038.cod_banco and  pre008.Ced_Rif = pre099.Ced_Rif AND ".$criteriop; 
//echo $StrSQL;
		  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$StrSQL="SELECT ACT_PAG_pre021('P','".$cod_mov."','P','$referencia_d','$referencia_h','$tipo_pago_d','$tipo_pago_h','$cfecha_d','$cfecha_h')";

} 
//echo $StrSQL;
$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
	
	$sSQL = "SELECT * FROM PRE021 WHERE ".$criteriopa." and (tipo_registro='P') And (nombre_usuario='".$cod_mov."') ORDER BY PRE021.fecha_doc, PRE021.Referencia_Comp, PRE021.Tipo_Compromiso";
    $sSQL = "SELECT nombre_usuario, tipo_registro, referencia_comp, tipo_compromiso, nombre_abrev_comp, nombre_tipo_comp, referencia_caus, tipo_causado, nombre_tipo_caus, nombre_abrev_caus, referencia_pago, tipo_pago, nombre_tipo_pago, nombre_abrev_pago, cod_presup, fuente_financ, denominacion, 
       substr(denominacion,1,45) as denom_cort, fecha_doc, ref_aep, num_proyecto, fecha_aep, tipo_documento,nro_documento, anulado, fecha_anulado, ced_rif, nombre_benef, 
       monto, comprometido, causado, pagado, ajustado, (ajustado*-1) as ajuste, func_inv, tipo_imput_presu, ref_imput_presu, monto_credito, inf_usuario, descripcion_doc, substr(descripcion_doc,1,140) AS descripciond, to_char(fecha_doc,'DD/MM/YYYY') as fechad FROM pre021 WHERE ".$criteriopa." and (tipo_registro='P') And (Nombre_Usuario='".$cod_mov."') ORDER BY pre021.fecha_doc, pre021.referencia_caus,pre021.tipo_causado,pre021.cod_presup,pre021.fuente_financ";

//echo $sSQL;
	   
	if($tipo_rep=="HTML"){  include ("../../class/phpreports/PHPReportMaker.php");
		$oRpt = new PHPReportMaker();
		$oRpt->setXML("Rpt_pagos.xml");
		$oRpt->setUser("$user");
		$oRpt->setPassword("$password");
		$oRpt->setConnection("$host");
		$oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
		$oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
		$oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
		$oRpt->run();
		$aBench = $oRpt->getBenchmark();
		$iSec   = $aBench["report_end"]-$aBench["report_start"];
	}
	if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $fecha_pago_grupo=""; $referencia_pago_grupo="00000000"; $tipo_pago_grupo="0000"; 
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $tam_logo; global $criterio2; global $fecha_pago_grupo; global $referencia_pago_grupo; global $tipo_pago_grupo; global $registro;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(150,10,'REPORTE DE PAGOS',1,0,'C');
				$this->Ln(15);
				$this->SetFont('Arial','B',8);
				$this->Cell(100,10,$criterio1,0,0,'L');	
				$this->Cell(100,10,$criterio2,0,0,'L');			
				$this->Ln(10);
			    $this->SetFont('Arial','B',6);
				$this->Cell(16,5,'REFERENCIA',1,0);
				$this->Cell(14,5,'FECHA',1,0,'L');						
				$this->Cell(7,5,'TIPO',1,0,'L');
				$this->Cell(8,5,'ABRV',1,0,'C');	
				$this->Cell(5,5,'ST',1,0,'C');	
				$this->Cell(20,5,'REFIERE A',1,0,'L');
				$this->Cell(110,5,'DESCRIPCION ',1,0,'L');
				$this->Cell(16,5,'CEDULA/RIF',1,0,'L');				
				$this->Cell(64,5,'NOMBRE BENEFICIARIO',1,1,'L');
				
				$this->Cell(40,5,'          CODIGO PRESUPUESTARIO',1,0,'L');						
				$this->Cell(159,5,'DENOMINACION CODIGO PRESUPUESTARIO',1,0,'L');
				$this->Cell(21,5,'MONTO ORIGINAL',1,0,'R');	
				$this->Cell(18,5,'AJUSTADO',1,0,'R');
				$this->Cell(22,5,'MONTO AJUSTADO',1,1,'R');
		    }
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $total_monto=0; $total_ajustado=0; $total_monto_ajustado=0; $sub_total_monto=0; $sub_total_ajustado=0; $sub_total_monto_ajustado=0; $cantidad_ordenes=0; 
			 $prev_fecha_pago=""; $prev_referencia_pago="";  $prev_tipo_pago=""; $prev_referencia_caus="";
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $fecha_pago=$registro["fecha_doc"]; $referencia_pago=$registro["referencia_pago"]; $tipo_pago=$registro["tipo_pago"]; 
			$nombre_abrev_pago=$registro["nombre_abrev_pago"]; $anulado=$registro["anulado"]; $nombre_abrev_caus=$registro["nombre_abrev_caus"]; $referencia_caus=$registro["referencia_caus"];
			$descripcion_pago=$registro["descripcion_doc"]; $ced_rif=$registro["ced_rif"]; $nombre_benef=$registro["nombre"];  $fecha_pago=formato_ddmmaaaa($fecha_pago);
			if($php_os=="WINNT"){$descripcion_pago=$registro["descripcion_doc"]; }else{$descripcion_pago=utf8_decode($descripcion_pago);$nombre_benef=utf8_decode($nombre_benef);}
		       $fecha_pago_grupo=$fecha_pago; $referencia_pago_grupo=$referencia_pago; $tipo_pago_grupo=$tipo_pago; $nombre_abrev_pago_grupo=$nombre_abrev_pago; 	$anulado_grupo=$anulado;
			   $nombre_abrev_caus_grupo=$nombre_abrev_caus;$descripcion_pago_grupo=$descripcion_pago;$ced_rif_grupo=$ced_rif; $nombre_grupo=$nombre;

			   if(($prev_fecha_pago<>$fecha_pago_grupo)or($prev_tipo_pago<>$tipo_pago_grupo)or($prev_referencia_pago<>$referencia_pago_grupo)or($prev_referencia_caus<>$referencia_caus)){  $cantidad_ordenes=$cantidad_ordenes+1;
			     $pdf->SetFont('Arial','B',7); 
			     if(($sub_total_monto<>0)or($sub_total_ajustado>0)or($sub_total_monto_ajustado>0)){ $sub_total_monto=formato_monto($sub_total_monto); $sub_total_ajustado=formato_monto($sub_total_ajustado); $sub_total_monto_ajustado=formato_monto($sub_total_monto_ajustado); 					    						    
					$pdf->Cell(200,2,'',0,0);
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,1,'R');
					$pdf->Cell(200,2,'',0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto,0,0,'R');
					$pdf->Cell(20,3,$sub_total_ajustado,0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto_ajustado,0,1,'R');
                    $pdf->Ln(3);
				 }	
                 $pdf->SetFont('Arial','',7);				 
				 $pdf->Cell(15,3,$referencia_pago_grupo,0,0,'L'); 
				 $pdf->Cell(15,3,$fecha_pago_grupo,0,0,'L');
				 $pdf->Cell(7,3,$tipo_pago_grupo,0,0,'L');
				 $pdf->Cell(8,3,$nombre_abrev_pago_grupo,0,0,'C');
				 $pdf->Cell(5,3,$anulado_grupo,0,0,'C');
				 $pdf->Cell(20,3,$nombre_abrev_caus_grupo." ".$referencia_caus,0,0,'L');
		   	     $x=$pdf->GetX();   $y=$pdf->GetY(); $n=110; $w=63;
		         $pdf->SetXY($x+$n,$y);
				 $pdf->Cell(17,3,$ced_rif_grupo,0,0,'L');
				 $nombre_temp=$nombre_benef;
				 if ($y>=179) { $nombre_temp=substr($nombre_temp,0,35);}				 
				 if(strlen(trim($descripcion_pago_grupo))>strlen(trim($nombre_temp))){
				    $pdf->MultiCell($w,3,$nombre_temp,0,1);
					$pdf->SetXY($x,$y);
					$pdf->MultiCell($n,3,$descripcion_pago_grupo,0);  
				 }else{
				    $pdf->SetXY($x,$y);
					$pdf->MultiCell($n,3,$descripcion_pago_grupo,0); 
					$pdf->SetXY($x+$n+17,$y);
					$pdf->MultiCell($w,3,$nombre_temp,0,1);
				 }
				 $pdf->Ln(2);
				 $prev_fecha_pago=$fecha_pago_grupo; $prev_referencia_pago=$referencia_pago_grupo; $prev_tipo_pago=$tipo_pago_grupo; $prev_referencia_caus=$referencia_caus; $sub_total_monto=0; $sub_total_ajustado=0; $sub_total_monto_ajustado=0; } 

		       $fecha_pago=$registro["fecha_pago"]; $referencia_pago=$registro["referencia_pago"]; $tipo_pago=$registro["tipo_pago"]; 
			   $nombre_abrev_pago=$registro["nombre_abrev_pago"]; $anulado=$registro["anulado"]; $nombre_abrev_caus=$registro["nombre_abrev_caus"]; 
			   $ced_rif=$registro["ced_rif"]; $descripcion_pago=$registro["descripcion_pago"];$nombre=$registro["nombre"]; $cod_presup=$registro["cod_presup"]; 
			   $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"]; $monto=$registro["monto"]; $ajustado=$registro["ajustado"]; 
			   $total_monto=$total_monto+$monto; $total_ajustado=$total_ajustado+$ajustado; $total_monto_ajustado=$total_monto_ajustado+$monto-$ajustado; 
			   $sub_total_monto=$sub_total_monto+$monto; $sub_total_ajustado=$sub_total_ajustado+$ajustado; $sub_total_monto_ajustado=$sub_total_monto_ajustado+$monto-$ajustado; 
			   $monto_ajus=$monto-$ajustado; $monto_ajus=formato_monto($monto_ajus); 
		       $monto=formato_monto($monto); $ajustado=formato_monto($ajustado); $fecha_pago=formato_ddmmaaaa($fecha_pago);	
			   if($php_os=="WINNT"){$descripcion_pago=$registro["descripcion_pago"]; }else{$descripcion_pago=utf8_decode($descripcion_pago);$nombre=utf8_decode($nombre);$denominacion=utf8_decode($denominacion);}

			   $pdf->Cell(40,3,$cod_presup."   ".$fuente_financ,0,0,'R'); 			   
		   	   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=160; 
		       $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$monto,0,0,'R');
			   $pdf->Cell(20,3,$ajustado,0,0,'R');
			   $pdf->Cell(20,3,$monto_ajus,0,1,'R');
		   	   $pdf->SetXY($x,$y);
		       $pdf->MultiCell($n,3,$denominacion,0); 
				
			} $total_monto=formato_monto($total_monto); $total_ajustado=formato_monto($total_ajustado); $total_monto_ajustado=formato_monto($total_monto_ajustado); 
			$pdf->SetFont('Arial','B',7);
			     if(($sub_total_monto<>0)or($sub_total_ajustado>0)or($sub_total_monto_ajustado>0)){ $sub_total_monto=formato_monto($sub_total_monto); $sub_total_ajustado=formato_monto($sub_total_ajustado); $sub_total_monto_ajustado=formato_monto($sub_total_monto_ajustado);						    
					$pdf->Cell(200,2,'',0,0);
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,1,'R');
					$pdf->Cell(200,2,'',0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto,0,0,'R');
					$pdf->Cell(20,3,$sub_total_ajustado,0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto_ajustado,0,1,'R');
                    			$pdf->Ln(5);}
			
			$pdf->Cell(200,2,'',0,0);
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,1,'R');
			$pdf->Cell(100,5,'Cantidad Pagos: '.$cantidad_ordenes,0,0,'L');
		    $pdf->Cell(100,5,'TOTAL GENERAL ',0,0,'R');
			$pdf->Cell(20,5,$total_monto,0,0,'R');
			$pdf->Cell(20,5,$total_ajustado,0,0,'R');
			$pdf->Cell(20,5,$total_monto_ajustado,0,1,'R');
			$pdf->Output();   
		}
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_pagos.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
			        <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE DE PAGOS</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio2?></strong></font></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Referencia</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Abrv.</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>St</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Refiere A</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF" ><strong>Cedula/Rif</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF" ><strong>Nombre Beneficiario</strong></td>
			 </tr>
			 <tr height="20">
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo Presupuestario</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Denominacion Codigo Presupuestario</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="400" align="right" bgcolor="#99CCFF"><strong>Monto Original</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>Ajustado</strong></td>
			   <td width="400" align="right" bgcolor="#99CCFF"><strong>Monto Ajustado</strong></td>
			 </tr>
		  <?  $i=0; $total_monto=0; $total_ajustado=0; $total_monto_ajustado=0; $sub_total_monto=0; $sub_total_ajustado=0; $sub_total_monto_ajustado=0; $cantidad_ordenes=""; 
			 $prev_fecha_pago=""; $prev_referencia_pago="";  $prev_tipo_pago="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $fecha_pago=$registro["fecha_pago"]; $referencia_pago=$registro["referencia_pago"]; $tipo_pago=$registro["tipo_pago"]; 
			$nombre_abrev_pago=$registro["nombre_abrev_pago"]; $anulado=$registro["anulado"]; $nombre_abrev_caus=$registro["nombre_abrev_caus"]; 
			$descripcion_pago=$registro["descripcion_pago"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; 						     	                     $fecha_pago=formato_ddmmaaaa($fecha_pago); 
		         $fecha_pago_grupo=$fecha_pago; $referencia_pago_grupo=$referencia_pago; $tipo_pago_grupo=$tipo_pago; $nombre_abrev_pago_grupo=$nombre_abrev_pago; 			         $anulado_grupo=$anulado;$nombre_abrev_caus_grupo=$nombre_abrev_caus;$descripcion_pago_grupo=$descripcion_pago;$ced_rif_grupo=$ced_rif; $nombre_grupo=$nombre;

			   if(($prev_fecha_pago<>$fecha_pago_grupo)or($prev_tipo_pago<>$tipo_pago_grupo)or($prev_referencia_pago<>$referencia_pago_grupo)){ $cantidad_ordenes=$cantidad_ordenes+1;
			     if(($sub_total_monto<>0)or($sub_total_ajustado>0)or($sub_total_monto_ajustado>0)){ $sub_total_monto=formato_monto($sub_total_monto); $sub_total_ajustado=formato_monto($sub_total_ajustado); $sub_total_monto_ajustado=formato_monto($sub_total_monto_ajustado); 		
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="400" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="400" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="400" align="right"><? echo $sub_total_monto; ?></td>
			           <td width="100" align="right"><? echo $sub_total_ajustado; ?></td>
			           <td width="400" align="right"><? echo $sub_total_monto_ajustado; ?></td>
			        </tr>	
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			      ?>	   
			      <tr>
				   <td width="100" align="left">'<? echo $referencia_pago_grupo; ?></td>
				   <td width="400" align="left"><? echo $fecha_pago_grupo; ?></td>
				   <td width="100" align="left"><? echo $tipo_pago_grupo; ?></td>
				   <td width="100" align="left"><? echo $nombre_abrev_pago_grupo; ?></td>
				   <td width="100" align="left"><? echo $anulado_grupo; ?></td>
				   <td width="100" align="left"><? echo $nombre_abrev_caus_grupo; ?></td>
				   <td width="400" align="left"><? echo $descripcion_pago_grupo; ?></td>
				   <td width="100" align="left"><? echo $ced_rif_grupo; ?></td>
				   <td width="400" align="left"><? echo $nombre_grupo; ?></td>
			      </tr>
			      <tr>
				  <td width="90" align="left"></td>
			      </tr>	
			     <? 					 
			    $prev_fecha_pago=$fecha_pago_grupo; $prev_referencia_pago=$referencia_pago_grupo; $prev_tipo_pago=$tipo_pago_grupo; $sub_total_monto=0; $sub_total_ajustado=0; $sub_total_monto_ajustado=0; }

		           $fecha_pago=$registro["fecha_pago"]; $referencia_pago=$registro["referencia_pago"]; $tipo_pago=$registro["tipo_pago"]; 
			   $nombre_abrev_pago=$registro["nombre_abrev_pago"]; $anulado=$registro["anulado"]; $nombre_abrev_caus=$registro["nombre_abrev_caus"]; 
			   $ced_rif=$registro["ced_rif"]; $descripcion_pago=$registro["descripcion_pago"];$nombre=$registro["nombre"]; $cod_presup=$registro["cod_presup"]; 
			   $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"]; $monto=$registro["monto"]; $ajustado=$registro["ajustado"]; 
			   $total_monto=$total_monto+$monto; $total_ajustado=$total_ajustado+$ajustado; $total_monto_ajustado=$total_monto_ajustado+$monto-$ajustado; 
			   $sub_total_monto=$sub_total_monto+$monto; $sub_total_ajustado=$sub_total_ajustado+$ajustado; $sub_total_monto_ajustado=$sub_total_monto_ajustado+$monto-$ajustado; 
		           $monto=formato_monto($monto); $ajustado=formato_monto($ajustado); $fecha_pago=formato_ddmmaaaa($fecha_pago);		   
			   $descripcion_pago=conv_cadenas($descripcion_pago,0);
			   $nombre=conv_cadenas($nombre,0);
			   $denominacion=conv_cadenas($denominacion,0); 
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_presup."   ".$fuente_financ; ?></td>
				   <td width="400" align="justify"><? echo $denominacion; ?></td>
				   <td width="100" align="right"></td>
				   <td width="100" align="right"></td>
				   <td width="100" align="right"></td>
				   <td width="100" align="right"></td>
				   <td width="400" align="right"><? echo $monto; ?></td>
				   <td width="100" align="right"><? echo $ajustado; ?></td>
				   <td width="400" align="right"><? echo $monto-$ajustado; ?></td>
				 </tr>
			   <? 	

		  }$total_monto=formato_monto($total_monto); $total_ajustado=formato_monto($total_ajustado); $total_monto_ajustado=formato_monto($total_monto_ajustado);
		  if(($sub_total_mont<>0)or($sub_total_ajustado>0)or($sub_total_monto_ajustado>0)){ $sub_total_monto=formato_monto($sub_total_monto); $sub_total_ajustado=formato_monto($sub_total_ajustado); $sub_total_monto_ajustado=formato_monto($sub_total_monto_ajustado); 			
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="400" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="400" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="100" align="right"></td>
			           <td width="400" align="right"><? echo $sub_total_monto; ?></td>
			           <td width="100" align="right"><? echo $sub_total_ajustado; ?></td>
			           <td width="400" align="right"><? echo $sub_total_monto_ajustado; ?></td>
			        </tr>			
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			    <td width="400" align="right">---------------</td>
			</tr>	
			<tr>
			    <td width="100" align="left">Cantidad Pagos: <strong><? echo $cantidad_ordenes; ?></strong></td>
			    <td width="400" align="right"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"><strong>TOTAL GENERAL : </strong></td>
			    <td width="400" align="right"><strong><? echo $total_monto; ?></strong></td>
			    <td width="100" align="right"><strong><? echo $total_ajustado; ?></strong></td>
			    <td width="400" align="right"><strong><? echo $total_monto_ajustado; ?></strong></td>
			</tr>	
		       <? 				  
		  ?></table><?
        }	
		
}
?>
