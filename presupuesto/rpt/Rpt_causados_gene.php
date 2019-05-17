<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$cod_presupd=$_GET["cod_presupd"];$cod_presuph=$_GET["cod_presuph"];$cod_fuente_d=$_GET["cod_fuented"];$cod_fuente_h=$_GET["cod_fuenteh"];$doc_causa_d=$_GET["doc_causa_d"];$doc_causa_h=$_GET["doc_causa_h"];$doc_comp_d=$_GET["doc_comp_d"]; $doc_comp_h=$_GET["doc_comp_h"];$referencia_d=$_GET["referencia_d"];$referencia_h=$_GET["referencia_h"]; $referenciacomp_d=$_GET["referenciacomp_d"];$referenciacomp_h=$_GET["referenciacomp_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$tipo_regis=$_GET["tipo_regis"]; $tipo_rep=$_GET["tipo_rep"];}
else{$codigod="";$codigoh="";$fuented="";$fuenteh="";$fecha="";$tipo_rep="HTML";} $php_os=PHP_OS;  $equipo=getenv("COMPUTERNAME"); $cod_mov="PRE021".$usuario_sia; 
if ($tipo_regis=='TO'){$nombre='TODOS';}elseif($tipo_regis=='ANU'){$nombre='ANULADOS';}elseif($tipo_regis=='AJU'){$nombre='AJUSTADOS';}elseif($tipo_regis=='NANU'){$nombre='NI ANULADOS';}elseif($tipo_regis=='NAJU'){$nombre='NI AJUSTADOS';}
if ($cod_fuente_d=='00'){$fuente='PRESUPUESTO ORDINARIO';} 
$mcontrol=array (0,0,0,0,0,0,0,0,0,0);
function buscar_control($clave, $formato){  global $mcontrol;  $j=0; 
  for ($i=0; $i<strlen($formato); $i++) {if (substr($formato,+$i,1)=="-") {$j++;} else{$mcontrol[$j]++;} } $ultimo=$j;$k=$mcontrol[0];
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] == 0) {$mcontrol[$i]=0;} else { $j=$mcontrol[$i]+$k; $mcontrol[$i]=$j+1; $k=$mcontrol[$i];}}
  for ($i=1; $i<10; $i++) {if ($mcontrol[$i] < 0) {$mcontrol[$i]=0;}} $actual=-1;
  for ($i=0; $i<10; $i++) { if (strlen($clave) == $mcontrol[$i]){$actual=$i; $i=10;} }  
  return $actual;
}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");    $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){$error=1;?> <script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script> <? } else { $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} }
  $sql="Select * from SIA005 where campo501='05'"; $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
  if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"]; $titulo=$registro["campo525"]; $formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];} 
  $l_c=strlen($formato_presup); $c=strlen($formato_categoria);  $p=strlen($formato_partida); $ini=$c+2;  $criterio="";
  if ($tipo_regis=='TO'){$nombre='TODOS';} $criterio_est="";
  if($tipo_regis=='ANU'){$nombre='ANULADOS'; $criterio_est="(pre007.anulado='S') And ";}
  if($tipo_regis=='AJU'){$nombre='AJUSTADOS';  $criterio_est="(pre037.ajustado<>0) And ";}
  if($tipo_regis=='NANU'){$nombre='NI ANULADOS,NI AJUSTADOS'; $criterio_est="(pre007.anulado='N') And (pre037.ajustado=0) And ";}
 
  $cfecha_h=formato_aaaammdd($fecha_h); $cfecha_d=formato_aaaammdd($fecha_d);
  $criterio1="Fecha Desde : ".$fecha_d."        "."Hasta : ".$fecha_h; 
  $criterio2=$nombre;  
  $criteriop=" (tipo_causado>='$doc_causa_d' and tipo_causado<='$doc_causa_h') And (referencia_caus>='$referencia_d' and referencia_caus<='$referencia_h') And (tipo_compromiso>='$doc_comp_d' and tipo_compromiso<='$doc_comp_h') And (referencia_comp>='$referenciacomp_d' and referencia_comp<='$referenciacomp_h') And (fecha_doc>='$cfecha_d' and fecha_doc<='$cfecha_h') And (cod_presup>='$cod_presupd' and cod_presup<='$cod_presuph') And (fuente_financ>='$cod_fuente_d' and fuente_financ<='$cod_fuente_h') And (ced_rif>='$cedula_d' and ced_rif<='$cedula_h')";
  $criteriop=" (tipo_causado>='$doc_causa_d' and tipo_causado<='$doc_causa_h') And (referencia_caus>='$referencia_d' and referencia_caus<='$referencia_h') And (tipo_compromiso>='$doc_comp_d' and tipo_compromiso<='$doc_comp_h') And (referencia_comp>='$referenciacomp_d' and referencia_comp<='$referenciacomp_h') And (fecha_doc>='$cfecha_d' and fecha_doc<='$cfecha_h') And (fuente_financ>='$cod_fuente_d' and fuente_financ<='$cod_fuente_h') And (ced_rif>='$cedula_d' and ced_rif<='$cedula_h')";
  
  $criterio4=$criterio_est."(PRE007.tipo_causado>='$doc_causa_d' and PRE007.tipo_causado<='$doc_causa_h') And (PRE007.referencia_caus>='$referencia_d' and PRE007.referencia_caus<='$referencia_h') And (PRE037.cod_presup>='$cod_presupd' and PRE037.cod_presup<='$cod_presuph') And (PRE007.tipo_compromiso>='$doc_comp_d' and PRE007.tipo_compromiso<='$doc_comp_h') And (PRE007.referencia_comp>='$referenciacomp_d' and PRE007.referencia_comp<='$referenciacomp_h')  And (PRE007.Fecha_Causado>='$cfecha_d' and PRE007.Fecha_Causado<='$cfecha_h') And (PRE037.fuente_financ>='$cod_fuente_d' and PRE037.fuente_financ<='$cod_fuente_h') And (PRE007.ced_rif>='$cedula_d' and PRE007.ced_rif<='$cedula_h')";
  $criterio4=$criterio_est."(PRE007.tipo_causado>='$doc_causa_d' and PRE007.tipo_causado<='$doc_causa_h') And (PRE007.referencia_caus>='$referencia_d' and PRE007.referencia_caus<='$referencia_h') And (PRE007.tipo_compromiso>='$doc_comp_d' and PRE007.tipo_compromiso<='$doc_comp_h') And (PRE007.referencia_comp>='$referenciacomp_d' and PRE007.referencia_comp<='$referenciacomp_h')  And (PRE007.Fecha_Causado>='$cfecha_d' and PRE007.Fecha_Causado<='$cfecha_h')  And (PRE007.ced_rif>='$cedula_d' and PRE007.ced_rif<='$cedula_h')";
 
  $long_u=strlen($formato_presup); $long_c=strlen($formato_categoria); $a=buscar_control($cod_presupd,$formato_presup); $criterio=""; $en_d=0; $en_h=0;  $mpos=0; 
  $pos=strrpos($cod_presupd,"?"); if($pos===false){$en_d=0;}else{$en_d=1;} $pos=strrpos($cod_presuph,"?"); if($pos===false){$en_h=0;}else{$en_h=1;}   
  if(($en_d==1)or($en_h==1)){$codigo_d=str_replace("?","0",$cod_presupd); $long_d=strlen($codigo_d); $codigo_h=str_replace("?","9",$cod_presuph); $long_h=strlen($codigo_h);
    if(($long_d=$long_u)and ($long_h=$long_u)){ $criterio=""; 
  	   for ($i=0; $i<10; $i++) { $m=$mcontrol[$i]; if($i==0){$a=0;}else{$a=$mcontrol[$i-1];} 
		 if ($m<>0){if($i==0){ $len_nivel=$m; $criterio=""; }else{ $mpos=1+$a;  $len_nivel=($m-$a-1); $criterio=$criterio." and "; }
			$cod_d=substr($codigo_d,$mpos,$len_nivel); $cod_h=substr($codigo_h,$mpos,$len_nivel);$mpp=$mpos+1;
			$criterio=$criterio."substring(pre037.cod_presup,".$mpp.",".$len_nivel.")>='".$cod_d."' and "; $criterio=$criterio."substring(pre037.cod_presup,".$mpp.",".$len_nivel.")<='".$cod_h."' ";  }
	   } $criterio=$criterio."and  pre037.fuente_financ>='".$cod_fuente_d."' and pre037.fuente_financ<='".$cod_fuente_h."'";
    }else{$criterio="pre037.cod_presup>='".$codigo_d."' and pre037.cod_presup<='".$codigo_h."' and  pre037.fuente_financ>='".$cod_fuente_d."' and pre037.fuente_financ<='".$cod_fuente_h."'";}
  }else{$criterio="pre037.cod_presup>='".$cod_presupd."' and pre037.cod_presup<='".$cod_presuph."' and  pre037.fuente_financ>='".$cod_fuente_d."' and pre037.fuente_financ<='".$cod_fuente_h."'";}
  $criterio4= $criterio4." and (".$criterio.")";  
  
  $StrSQL = "DELETE FROM PRE021 Where (tipo_registro='A') And (nombre_usuario='".$cod_mov."')";
  $res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }

 if($cfecha_h==$Fec_Fin_Ejer){$StrSQL= "INSERT INTO PRE021 SELECT '$cod_mov' as nombre_usuario,'A' as tipo_registro,PRE007.Referencia_Comp,PRE007.Tipo_Compromiso,PRE002.Nombre_Abrev_Comp,PRE002.Nombre_Tipo_Comp,
PRE007.referencia_caus,PRE007.tipo_causado,PRE003.nombre_tipo_caus,PRE003.nombre_abrev_caus,'00000000' as Referencia_Pago,'0000' as Tipo_Pago,'' as Nombre_Abrev_Pago,'' as Nombre_Tipo_Pago, PRE037.Cod_Presup,PRE037.Fuente_Financ,PRE001.Denominacion,
PRE007.Fecha_Causado as Fecha_Doc,PRE007.Ref_AEP,PRE007.Num_Proyecto, PRE007.Fecha_AEP,'' as Tipo_Documento,'' as Nro_Documento,PRE007.Anulado,PRE007.Fecha_Anu AS Fecha_Anulado, PRE007.Ced_Rif,
PRE099.Nombre as Nombre_Benef,PRE037.Monto,0 as Comprometido,PRE037.Monto as Causado, PRE037.Pagado as Pagado,PRE037.Ajustado as Ajustado,PRE007.Func_Inv,
PRE037.Tipo_Imput_Presu,PRE037.Ref_Imput_Presu, PRE037.Monto_Credito,PRE007.inf_usuario,PRE007.Descripcion_Caus as Descripcion_Doc FROM PRE001,PRE002,PRE003,PRE007,PRE037,PRE099 
WHERE PRE001.Cod_Presup = PRE037.Cod_Presup AND PRE037.Fuente_Financ=PRE001.cod_fuente AND 
 PRE007.Tipo_Causado = PRE003.Tipo_Causado AND PRE002.Tipo_Compromiso = PRE007.Tipo_Compromiso AND PRE007.Tipo_Compromiso = PRE037.Tipo_Compromiso AND PRE007.Referencia_Comp = PRE037.Referencia_Comp AND
PRE007.Referencia_Caus = PRE037.Referencia_Caus AND PRE007.Tipo_Causado = PRE037.Tipo_Causado
AND PRE007.Ced_Rif = PRE099.Ced_Rif and ".$criterio4; }
else{$StrSQL= "INSERT INTO PRE021 SELECT '$cod_mov' as nombre_usuario,'A' as tipo_registro,PRE007.Referencia_Comp,PRE007.Tipo_Compromiso,PRE002.Nombre_Abrev_Comp,PRE002.Nombre_Tipo_Comp,
PRE007.referencia_caus,PRE007.tipo_causado,PRE003.nombre_tipo_caus,PRE003.nombre_abrev_caus,'00000000' as Referencia_Pago,'0000' as Tipo_Pago,'' as Nombre_Abrev_Pago,'' as Nombre_Tipo_Pago, PRE037.Cod_Presup,PRE037.Fuente_Financ,PRE001.Denominacion,
PRE007.Fecha_Causado as Fecha_Doc,PRE007.Ref_AEP,PRE007.Num_Proyecto, PRE007.Fecha_AEP,'' as Tipo_Documento,'' as Nro_Documento,PRE007.Anulado,PRE007.Fecha_Anu AS Fecha_Anulado, PRE007.Ced_Rif,
PRE099.Nombre as Nombre_Benef,PRE037.Monto,0 as Comprometido,PRE037.Monto as Causado, 0 as Pagado,0 as Ajustado,PRE007.Func_Inv,
PRE037.Tipo_Imput_Presu,PRE037.Ref_Imput_Presu, PRE037.Monto_Credito,PRE007.inf_usuario,PRE007.Descripcion_Caus as Descripcion_Doc FROM PRE001,PRE002,PRE003,PRE007,PRE037,PRE099 
WHERE PRE001.Cod_Presup = PRE037.Cod_Presup AND PRE037.Fuente_Financ=PRE001.cod_fuente AND 
 PRE007.Tipo_Causado = PRE003.Tipo_Causado AND PRE002.Tipo_Compromiso = PRE007.Tipo_Compromiso AND PRE007.Tipo_Compromiso = PRE037.Tipo_Compromiso AND PRE007.Referencia_Comp = PRE037.Referencia_Comp AND
PRE007.Referencia_Caus = PRE037.Referencia_Caus AND PRE007.Tipo_Causado = PRE037.Tipo_Causado
AND PRE007.Ced_Rif = PRE099.Ced_Rif and ".$criterio4; 
$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
$StrSQL="SELECT ACT_CAUS_pre021('P','".$cod_mov."','A','$referencia_d','$referencia_h','$doc_comp_d','$doc_comp_h','$cfecha_d','$cfecha_h')";
} 
$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);if (!$res){ ?> <script language="JavaScript">  muestra('<? echo $error; ?>'); </script> <? }
	
	$sSQL = "SELECT * FROM PRE021 WHERE ".$criteriop." and (tipo_registro='A') And (nombre_usuario='".$cod_mov."') ORDER BY PRE021.Fecha_Doc, PRE021.Referencia_Comp, PRE021.Tipo_Compromiso";
    $sSQL = "SELECT nombre_usuario, tipo_registro, referencia_comp, tipo_compromiso, nombre_abrev_comp, nombre_tipo_comp, referencia_caus, tipo_causado, nombre_tipo_caus, nombre_abrev_caus, referencia_pago, tipo_pago, nombre_tipo_pago, nombre_abrev_pago, cod_presup, fuente_financ, denominacion, 
       substr(denominacion,1,45) as denom_cort, fecha_doc, ref_aep, num_proyecto, fecha_aep, tipo_documento,nro_documento, anulado, fecha_anulado, ced_rif, nombre_benef, 
       monto, comprometido, causado, pagado, ajustado, (ajustado*-1) as ajuste, func_inv, tipo_imput_presu, ref_imput_presu, monto_credito, inf_usuario, descripcion_doc, substr(descripcion_doc,1,140) AS descripciond, to_char(fecha_Doc,'DD/MM/YYYY') as fechad FROM pre021 WHERE ".$criteriop." and (Tipo_Registro='A') And (Nombre_Usuario='".$cod_mov."') ORDER BY pre021.fecha_Doc, pre021.referencia_caus,pre021.tipo_causado,pre021.cod_presup,pre021.fuente_financ";
    if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");
	    
		$oRpt = new PHPReportMaker();	
		$oRpt->setXML("Rpt_causados_general.xml");
		$oRpt->setUser("$user");
        $oRpt->setPassword("$password");
        $oRpt->setConnection("$host");
       	$oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
        $oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2));          
        $oRpt->run();
    }
	if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $fecha_doc_grupo=""; $referencia_caus_grupo="00000000"; $tipo_causado_grupo="0000"; 
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1;  global $tam_logo; global $criterio2; global $fecha_doc_grupo; global $referencia_caus_grupo; global $tipo_causado_grupo; global $registro;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(150,10,'CAUSADOS',1,0,'C');
				$this->Ln(15);
				$this->SetFont('Arial','B',8);
				$this->Cell(100,10,$criterio1,0,0,'L');			
				$this->Ln(10);
			    $this->SetFont('Arial','B',6);
				$this->Cell(16,5,'REFERENCIA',1,0);
				$this->Cell(14,5,'FECHA',1,0,'L');						
				$this->Cell(15,5,'TIPO',1,0,'L');
				$this->Cell(5,5,'ST',1,0,'C');	
				$this->Cell(17,5,'COMPROMISO',1,0,'L');
				$this->Cell(8,5,'TIPO',1,0,'L');
				$this->Cell(105,5,'DESCRIPCION ',1,0,'L');
				$this->Cell(17,5,'CEDULA/RIF',1,0,'L');
				$this->Cell(63,5,'NOMBRE BENEFICIARIO',1,1,'L');
				$this->Cell(40,5,'CODIGO PRESUPUESTARIO',1,0,'L');						
				$this->Cell(119,5,'DENOMINACION CODIGO PRESUPUESTARIO',1,0,'L');
				$this->Cell(21,5,'MONTO CAUSADO',1,0,'R');	
				$this->Cell(19,5,'AJUSTADO',1,0,'R');
				$this->Cell(22,5,'MONTO AJUSTADO',1,0,'R');
				$this->Cell(19,5,'PAGADO',1,0,'R');
				$this->Cell(20,5,'POR PAGAR',1,1,'R');
		    }
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');

				// INI NMDB 30-04-2018
		        // $this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		        $this->Cell(130,5,' ',0,0,'R');
		        // FIN NMDB 30-04-2018
			}
		  }		  
		  $pdf=new PDF('L', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  $i=0;  $total_monto=0; $total_ajuste=0; $total_monto_ajustado=0; $total_causado=0; $total_pagado=0; $total_monto_ajustado_pagado=0; $sub_total_monto=0; $sub_total_ajuste=0; $sub_total_ajustado=0; $total_ajustado=0; $sub_total_monto_ajustado=0; $sub_total_causado=0; $sub_total_pagado=0; $sub_total_monto_ajustado_pagado=0;$cantidad_ordenes=0; 
	      $prev_fecha_doc=""; $prev_referencia_caus="";  $prev_tipo_causado=""; 
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $fecha_doc=$registro["fecha_doc"]; $referencia_comp=$registro["referencia_comp"]; $tipo_causado=$registro["tipo_causado"]; 
			$nombre_abrev_caus=$registro["nombre_abrev_caus"]; $anulado=$registro["anulado"]; $referencia_caus=$registro["referencia_caus"]; 
			$nombre_abrev_comp=$registro["nombre_abrev_comp"]; $ced_rif=$registro["ced_rif"]; $descripciond=$registro["descripciond"]; $nombre_benef=$registro["nombre_benef"]; $fecha_doc=formato_ddmmaaaa($fecha_doc);
			if($php_os=="WINNT"){$descripciond=$registro["descripciond"]; }else{$descripciond=utf8_decode($descripciond);}
			if($php_os=="WINNT"){$nombre_benef=$registro["nombre_benef"]; }else{$nombre_benef=utf8_decode($nombre_benef);}
		    $fecha_doc_grupo=$fecha_doc; $referencia_comp_grupo=$referencia_comp; $referencia_caus_grupo=$referencia_caus;			  
			$tipo_causado_grupo=$tipo_causado; $nombre_abrev_caus_grupo=$nombre_abrev_caus; 	 $anulado_grupo=$anulado;
			$nombre_abrev_comp_grupo=$nombre_abrev_comp;$descripciond_grupo=$descripciond; 
			$ced_rif_grupo=$ced_rif; $nombre_benef_grupo=$nombre_benef;
			if(($prev_fecha_doc<>$fecha_doc_grupo)or($prev_tipo_causado<>$tipo_causado_grupo)or($prev_referencia_caus<>$referencia_caus_grupo)){  $cantidad_ordenes=$cantidad_ordenes+1;
			     $pdf->SetFont('Arial','B',7); 
			     if(($sub_total_monto<>0)or($sub_total_ajuste>0)or($sub_total_monto_ajustado>0)or($sub_total_causado>0)or($sub_total_pagado>0)or($sub_total_monto_ajustado_pagado>0)){ $sub_total_monto=formato_monto($sub_total_monto); $sub_total_ajuste=formato_monto($sub_total_ajuste); $sub_total_ajustado=formato_monto($sub_total_ajustado); $sub_total_monto_ajustado=formato_monto($sub_total_monto_ajustado); $sub_total_causado=formato_monto($sub_total_causado);$sub_total_pagado=formato_monto($sub_total_pagado);$sub_total_monto_ajustado_pagado=formato_monto($sub_total_monto_ajustado_pagado);						    						    
					$pdf->Cell(160,2,'',0,0);
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,1,'R');
					$pdf->Cell(160,2,'',0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto,0,0,'R');
					$pdf->Cell(20,3,$sub_total_ajuste,0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto_ajustado,0,0,'R');
					$pdf->Cell(20,3,$sub_total_pagado,0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto_ajustado_pagado,0,1,'R');
                    $pdf->Ln(3);
				 }			
                 $pdf->SetFont('Arial','',7);				 
				 $pdf->Cell(15,3,$referencia_caus_grupo,0,0,'L'); 
				 $pdf->Cell(15,3,$fecha_doc_grupo,0,0,'L');
				 $pdf->Cell(15,3,$tipo_causado_grupo."  ".$nombre_abrev_caus_grupo,0,0,'L');
				 $pdf->Cell(5,3,$anulado_grupo,0,0,'C');
				 $pdf->Cell(15,3,$referencia_comp_grupo,0,0,'L');
				 $pdf->Cell(10,3,$nombre_abrev_comp,0,0,'C');
		   	     $x=$pdf->GetX();   $y=$pdf->GetY(); $n=105; $w=63;
		         $pdf->SetXY($x+$n,$y);
				 $nombre_temp=$nombre_benef_grupo;
				 if ($y>=179) { $nombre_temp=substr($nombre_temp,0,35);}
			   	 $pdf->Cell(17,3,$ced_rif_grupo,0,0,'L');
		         $pdf->MultiCell($w,3,$nombre_temp,0,1);
		   	   	 $pdf->SetXY($x,$y);
		         $pdf->MultiCell($n,3,$descripciond_grupo,0);  
				 $pdf->Ln(2);
				 $prev_fecha_doc=$fecha_doc_grupo; $prev_referencia_caus=$referencia_caus_grupo; $prev_tipo_causado=$tipo_causado_grupo; $sub_total_monto=0; $sub_total_ajuste=0; $sub_total_monto_ajustado=0; $sub_total_causado=0; $sub_total_pagado=0; $sub_total_monto_ajustado_pagado=0;
			} 
		       $fecha_doc=$registro["fecha_doc"]; $referencia_comp=$registro["referencia_comp"]; $tipo_causado=$registro["tipo_causado"]; 
			   $nombre_abrev_caus=$registro["nombre_abrev_caus"]; $anulado=$registro["anulado"]; $referencia_caus=$registro["referencia_caus"]; 
			   $nombre_abrev_comp=$registro["nombre_abrev_comp"];$ced_rif=$registro["ced_rif"]; $descripciond=$registro["descripciond"];$nombre_benef=$registro["nombre_benef"]; 				   $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"]; $monto=$registro["monto"]; 
			   $ajuste=$registro["ajuste"]; $ajustado=$registro["ajustado"]; $causado=$registro["causado"];$pagado=$registro["pagado"]; 
			   if($tipo_causado=="0000"){$pagado=$causado-$ajustado;}
			   $total_monto=$total_monto+$monto; $total_ajuste=$total_ajuste+$ajuste; $total_monto_ajustado=$total_monto_ajustado+$monto-$ajustado; $total_causado=$total_causado+$causado; 		   $total_pagado=$total_pagado+$pagado; $total_monto_ajustado_pagado=$total_monto_ajustado_pagado+$monto-$ajustado-$pagado; $sub_total_monto=$sub_total_monto+$monto; 				   $sub_total_ajuste=$sub_total_ajuste+$ajuste; $sub_total_monto_ajustado=$sub_total_monto_ajustado+$monto-$ajustado; $sub_total_causado=$sub_total_causado+$causado; 				   $sub_total_pagado=$sub_total_pagado+$pagado; $sub_total_monto_ajustado_pagado=$sub_total_monto_ajustado_pagado+$monto-$ajustado-$pagado;
		       $monto_ajus=$monto-$ajustado; $por_pagar=$monto-$ajustado-$pagado;  $monto=formato_monto($monto); $ajuste=formato_monto($ajuste); $ajustado=formato_monto($ajustado); $causado=formato_monto($causado);
			   $pagado=formato_monto($pagado);  $monto_ajus=formato_monto($monto_ajus); $por_pagar=formato_monto($por_pagar); $fecha_doc=formato_ddmmaaaa($fecha_doc);	
			   if($php_os=="WINNT"){$descripciond=$registro["descripciond"]; }else{$descripciond=utf8_decode($descripciond);$nombre_benef=utf8_decode($nombre_benef);$denominacion=utf8_decode($denominacion);}
			   $pdf->Cell(40,3,$cod_presup."  ".$fuente_financ,0,0,'L'); 			   
		   	   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=119; 		   
		       $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$monto,0,0,'R');
			   $pdf->Cell(20,3,$ajuste,0,0,'R');
			   $pdf->Cell(20,3,$monto_ajus,0,0,'R');
			   $pdf->Cell(20,3,$pagado,0,0,'R');
               $pdf->Cell(20,3,$por_pagar,0,1,'R');  				
		   	   $pdf->SetXY($x+1,$y);
		       $pdf->MultiCell($n,3,$denominacion,0);  	
			} $total_monto=formato_monto($total_monto); $total_ajuste=formato_monto($total_ajuste); $total_ajustado=formato_monto($total_ajustado); $total_monto_ajustado=formato_monto($total_monto_ajustado); $total_causado=formato_monto($total_causado);$total_pagado=formato_monto($total_pagado); $total_monto_ajustado_pagado=formato_monto($total_monto_ajustado_pagado);
			$pdf->SetFont('Arial','B',7);
			if(($sub_total_monto>0)or($sub_total_ajuste>0)or($sub_total_monto_ajustado>0)or($sub_total_causado>0)or($sub_total_pagado>0)or($sub_total_monto_ajustado_pagado>0)){ $sub_total_monto=formato_monto($sub_total_monto); $sub_total_ajuste=formato_monto($sub_total_ajuste); $sub_total_ajustado=formato_monto($sub_total_ajustado); $sub_total_monto_ajustado=formato_monto($sub_total_monto_ajustado); $sub_total_causado=formato_monto($sub_total_causado);$sub_total_pagado=formato_monto($sub_total_pagado);$sub_total_monto_ajustado_pagado=formato_monto($sub_total_monto_ajustado_pagado);						    
					$pdf->Cell(160,2,'',0,0);
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,1,'R');
					$pdf->Cell(160,2,'',0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto,0,0,'R');
					$pdf->Cell(20,3,$sub_total_ajuste,0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto_ajustado,0,0,'R');
					$pdf->Cell(20,3,$sub_total_pagado,0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto_ajustado_pagado,0,1,'R');
                    $pdf->Ln(5);}
			$pdf->Cell(160,2,'',0,0);
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,0,'R');
			$pdf->Cell(20,2,'=============',0,1,'R');
			$pdf->Cell(100,5,'Cantidad Causados: '.$cantidad_ordenes,0,0,'L');
		    $pdf->Cell(60,5,'TOTAL GENERAL ',0,0,'R');
			$pdf->Cell(20,5,$total_monto,0,0,'R');
			$pdf->Cell(20,5,$total_ajuste,0,0,'R');
			$pdf->Cell(20,5,$total_monto_ajustado,0,0,'R');
			$pdf->Cell(20,5,$total_pagado,0,0,'R');
			$pdf->Cell(20,5,$total_monto_ajustado_pagado,0,1,'R');
			$pdf->Output();   
		}
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_causados_general.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
			        <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CAUSADOS</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Referencia</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>St</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Compromiso</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF" ><strong>Cedula/Rif</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF" ><strong>Nombre Beneficiario</strong></td>
			 </tr>
			 <tr height="20">
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo Presupuestario</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Denominacion Codigo Presupuestario</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>Monto Causado</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>Ajustado</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>Monto Ajustado</strong></td>
			   <td width="400" align="right" bgcolor="#99CCFF"><strong>Pagado</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>Por Pagar</strong></td>
			   <td width="400" align="right" bgcolor="#99CCFF"><strong></strong></td>
			   <td width="400" align="right" bgcolor="#99CCFF"><strong></strong></td>
			 </tr>
		  <?  $i=0; $total_monto=0; $total_ajuste=0; $total_monto_ajustado=0; $total_causado=0; $total_pagado=0; $total_monto_ajustado_pagado=0; $sub_total_monto=0; $sub_total_ajuste=0; 				 $sub_total_monto_ajustado=0; $sub_total_causado=0; $sub_total_pagado=0; $sub_total_monto_ajustado_pagado=0;$cantidad_ordenes=0; 
			 $prev_fecha_doc=""; $prev_referencia_caus="";  $prev_tipo_causado="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $fecha_doc=$registro["fecha_doc"]; $referencia_comp=$registro["referencia_comp"]; $tipo_causado=$registro["tipo_causado"]; 
			$nombre_abrev_caus=$registro["nombre_abrev_caus"]; $anulado=$registro["anulado"]; $referencia_caus=$registro["referencia_caus"]; 
			$nombre_abrev_comp=$registro["nombre_abrev_comp"]; $ced_rif=$registro["ced_rif"]; $descripciond=$registro["descripciond"]; $nombre_benef=$registro["nombre_benef"]; 				$fecha_doc=formato_ddmmaaaa($fecha_doc); 
		     $fecha_doc_grupo=$fecha_doc; $referencia_caus_grupo=$referencia_caus; $tipo_causado_grupo=$tipo_causado; $nombre_abrev_caus_grupo=$nombre_abrev_caus; $anulado_grupo=$anulado;
			 $nombre_abrev_comp_grupo=$nombre_abrev_comp;$descripciond_grupo=$descripciond; 
			 $ced_rif_grupo=$ced_rif; $nombre_benef_grupo=$nombre_benef;
			   if(($prev_fecha_doc<>$fecha_doc_grupo)or($prev_tipo_causado<>$tipo_causado_grupo)or($prev_referencia_caus<>$referencia_caus_grupo)){ $cantidad_ordenes=$cantidad_ordenes+1;
			     if(($sub_total_monto<>0)or($sub_total_ajuste>0)or($sub_total_monto_ajustado>0)or($sub_total_causado>0)or($sub_total_pagado>0)or($sub_total_monto_ajustado_pagado>0)){ $sub_total_monto=formato_monto($sub_total_monto); $sub_total_ajuste=formato_monto($sub_total_ajuste); $sub_total_ajustado=formato_monto($sub_total_ajustado); $sub_total_monto_ajustado=formato_monto($sub_total_monto_ajustado); $sub_total_causado=formato_monto($sub_total_causado);$sub_total_pagado=formato_monto($sub_total_pagado);$sub_total_monto_ajustado_pagado=formato_monto($sub_total_monto_ajustado_pagado);
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="left"></td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="400" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"><? echo $sub_total_monto; ?></td>
			           <td width="100" align="right"><? echo $sub_total_ajuste; ?></td>
			           <td width="100" align="right"><? echo $sub_total_monto_ajustado; ?></td>
			           <td width="400" align="right"><? echo $sub_total_pagado; ?></td>
			           <td width="100" align="right"><? echo $sub_monto_ajustado_pagado; ?></td>
			        </tr>	
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			      ?>	   
			      <tr>
				   <td width="100" align="left">'<? echo $referencia_caus_grupo; ?></td>
				   <td width="400" align="left"><? echo $fecha_doc_grupo; ?></td>
				   <td width="100" align="left"><? echo $tipo_causado_grupo."  ".$nombre_abrev_caus_grupo; ?></td>
				   <td width="100" align="left"><? echo $anulado_grupo; ?></td>
				   <td width="100" align="left"><? echo $referencia_caus_grupo; ?></td>
				   <td width="400" align="left"><? echo $nombre_abrev_comp; ?></td>
				   <td width="100" align="left"><? echo $descripciond_grupo; ?></td>
				   <td width="100" align="left"><? echo $ced_rif_grupo; ?></td>
				   <td width="400" align="left"><? echo $nombre_benef_grupo; ?></td>
			      </tr>
			      <tr>
				  <td width="90" align="left"></td>
			      </tr>	
			     <? 					 
			    $prev_fecha_doc=$fecha_doc_grupo; $prev_referencia_caus=$referencia_caus_grupo; $prev_tipo_causado=$tipo_causado_grupo; $sub_total_monto=0; $sub_total_ajuste=0; $sub_total_monto_ajustado=0; $sub_total_causado=0; $sub_total_pagado=0; $sub_total_monto_ajustado_pagado=0;}
		       $fecha_doc=$registro["fecha_doc"]; $referencia_comp=$registro["referencia_comp"]; $tipo_causado=$registro["tipo_causado"]; 
			   $nombre_abrev_caus=$registro["nombre_abrev_caus"]; $anulado=$registro["anulado"]; $referencia_caus=$registro["referencia_caus"]; 
			   $nombre_abrev_comp=$registro["nombre_abrev_comp"];$ced_rif=$registro["ced_rif"]; $descripciond=$registro["descripciond"];$nombre_benef=$registro["nombre_benef"]; 				   $cod_presup=$registro["cod_presup"]; $fuente_financ=$registro["fuente_financ"]; $denominacion=$registro["denominacion"]; $monto=$registro["monto"]; 
			   $ajuste=$registro["ajuste"]; $ajustado=$registro["ajustado"]; $causado=$registro["causado"];$pagado=$registro["pagado"]; if($tipo_causado=="0000"){$pagado=$causado-$ajustado;}
			   $monto_ajus=$monto-$ajustado; $por_pagar=$monto-$ajustado-$pagado; 
			   $total_monto=$total_monto+$monto; $total_ajuste=$total_ajuste+$ajuste; $total_monto_ajustado=$total_monto_ajustado+$monto-$ajustado; $total_causado=$total_causado+$causado; 		   $total_pagado=$total_pagado+$pagado; $total_monto_ajustado_pagado=$total_monto_ajustado_pagado+$monto-$ajustado-$pagado; $sub_total_monto=$sub_total_monto+$monto; 				   $sub_total_ajuste=$sub_total_ajuste+$ajuste; $sub_total_monto_ajustado=$sub_total_monto_ajustado+$monto-$ajustado; $sub_total_causado=$sub_total_causado+$causado; 				   $sub_total_pagado=$sub_total_pagado+$pagado; $sub_total_monto_ajustado_pagado=$sub_total_monto_ajustado_pagado+$monto-$ajustado-$pagado;
		       $monto=formato_monto($monto); $ajuste=formato_monto($ajuste); $ajustado=formato_monto($ajustado); $causado=formato_monto($causado);
			   $pagado=formato_monto($pagado); $monto_ajus=formato_monto($monto_ajus); $por_pagar=formato_monto($por_pagar);   $fecha_doc=formato_ddmmaaaa($fecha_doc);	   
			   $descripciond=conv_cadenas($descripciond,0);			   $nombre_benef=conv_cadenas($nombre_benef,0);			   $denominacion=conv_cadenas($denominacion,0); 
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_presup."   ".$fuente_financ; ?></td>
				   <td width="400" align="justify"><? echo $denominacion; ?></td>
				   <td width="100" align="right"><? echo $monto; ?></td>
				   <td width="100" align="right"><? echo $ajuste; ?></td>
				   <td width="100" align="right"><? echo $monto_ajus; ?></td>
				   <td width="400" align="right"><? echo $pagado; ?></td>
				   <td width="100" align="right"><? echo $por_pagar; ?></td>
				 </tr>
			   <? 	

		  }$total_monto=formato_monto($total_monto); $total_ajuste=formato_monto($total_ajuste); $total_ajustado=formato_monto($total_ajustado); $total_monto_ajustado=formato_monto($total_monto_ajustado); $total_causado=formato_monto($total_causado);$total_pagado=formato_monto($total_pagado); $total_monto_ajustado_pagado=formato_monto($total_monto_ajustado_pagado);

		  if(($sub_total_monto<>0)or($sub_total_ajuste>0)or($sub_total_monto_ajustado>0)or($sub_total_causado>0)or($sub_total_pagado>0)or($sub_total_monto_ajustado_pagado>0)){ $sub_total_monto=formato_monto($sub_total_monto); $sub_total_ajuste=formato_monto($sub_total_ajuste); $sub_total_ajustado=formato_monto($sub_total_ajustado); $sub_tota_monto_ajustado=formato_monto($sub_total_monto_ajustado); $sub_total_causado=formato_monto($sub_total_causado);$sub_total_pagado=formato_monto($sub_total_pagado);$sub_total_monto_ajustado_pagado=formato_monto($sub_total_monto_ajustado_pagado);		
			     ?>	 				 
				<tr>
			    	   <td width="100" align="left"></td>
			           <td width="400" align="left"></td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			           <td width="400" align="right">---------------</td>
			           <td width="100" align="right">---------------</td>
			        </tr>	
				<tr>
			    	   <td width="100" align="left"></td>
			    	   <td width="400" align="left"></td>
			           <td width="100" align="right"><? echo $sub_total_monto; ?></td>
			           <td width="100" align="right"><? echo $sub_total_ajuste; ?></td>
			           <td width="100" align="right"><? echo $sub_total_monto_ajustado; ?></td>
			           <td width="400" align="right"><? echo $sub_total_pagado; ?></td>
			           <td width="100" align="right"><? echo $sub_total_monto_ajustado_pagado; ?></td>
			        </tr>		
			        <tr>
				  <td width="90" align="left"></td>
			        </tr>	
                              <?}
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			    <td width="400" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			</tr>	
			<tr>
			    <td width="100" align="left">Cantidad Causados: <strong><? echo $cantidad_ordenes; ?></strong></td>
			    <td width="400" align="right"><strong>TOTAL GENERAL : </strong></td>
			    <td width="100" align="right"><strong><? echo $total_monto; ?></strong></td>
			    <td width="100" align="right"><strong><? echo $total_ajuste; ?></strong></td>
			    <td width="100" align="right"><strong><? echo $total_monto_ajustado; ?></strong></td>
			    <td width="400" align="right"><strong><? echo $total_pagado; ?></strong></td>
			    <td width="100" align="right"><strong><? echo $total_monto_ajustado_pagado; ?></strong></td>
			</tr>	
		       <? 				  
		  ?></table><?
        }
?>
