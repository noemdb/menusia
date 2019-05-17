<? include ("../../class/conect.php");   require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc"); $php_os=PHP_OS;    error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"];   $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"]; $tipo_rpt=$_GET["tipo_rpt"];
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_concepto=$_GET["tipo_concepto"];
   $forma_pago=$_GET["forma_pago"]; $detalle_trab=$_GET["detalle_trab"]; $tipo_calculo=$_GET["tipo_calculo"]; $salto_dep=$_GET["salto_dep"]; $num_periodos=$_GET["num_periodos"];
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a"); $criterio1="CONCEPTOS POR DEPARTAMENTO";
   $cfechan=formato_aaaammdd($fecha_nom);   $criterio="rpt_nom_cal WHERE (oculto='NO') and (cod_concepto<>'VVV')";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') and (cod_concepto<>'VVV')";} 
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (concepto_vac='N') ";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and (concepto_vac='S') ";}   
   $nom_reporte="Rpt_concep_depart_rn.xml"; if ($detalle_trab=='S'){$nom_reporte="Rpt_concep_depart_detalle_rn.xml";  $criterio1="CONCEPTOS POR DEPARTAMENTO (DETALLADO)";}
      
   $cri_tp=" and (tp_calculo='".$tipo_calculo."') ";  
   if($tipo_calculo=="E") { $cri_tp=" and ((tp_calculo='E')and(num_periodos=$num_periodos))  "; } 
   $criterio=$criterio.$cri_tp." and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."')  ";
	
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}

   $sSQL = "SELECT *  FROM ".$criterio." and  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') ORDER BY tipo_nomina, cod_departam, cod_concepto, cod_empleado";
    if($tipo_rpt=="HTML"){  include("../../class/phpreports/PHPReportMaker.php");
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML($nom_reporte);
	  $oRpt->setUser("$user");
	  $oRpt->setPassword("$password");
	  $oRpt->setConnection("localhost");
	  $oRpt->setDatabaseInterface("postgresql");
	  $oRpt->setSQL($sSQL);
	  $oRpt->setDatabase("$dbname");
	  $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
	  $oRpt->run();
	  $aBench = $oRpt->getBenchmark();
    }
	 if(($tipo_rpt=="PDF")){$res=pg_query($sSQL); $filas=pg_num_rows($res);
      $prev_tipo=""; $prev_den_nom=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_dep=""; $prev_den_dep="";
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $i=0; 
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		$prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp="";
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $criterio2;  global $des_nomina; global $fechad; global $fechah;  global $cod_departam; global $des_departam; global $salto_dep; global $i;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(120,7,$criterio1,1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
			$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');
			$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');
			$this->Cell(12,5,'Codigo',1,0);
			$this->Cell(122,5,'Descripcion Concepto',1,0,'L');
			$this->Cell(22,5,'Asignaciones',1,0);
			$this->Cell(22,5,'Deducciones',1,0);
			$this->Cell(22,5,'',1,1,'C');
			if(($salto_dep=="S")or($i==0)){$this->Cell(140,5,"DEPARTAMENTO : ".$cod_departam." ".$des_departam,0,1,'L'); }
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			//$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_dep=0; $totald_dep=0; $cant_dep=0;  $totala_emp=0; $totald_emp=0; 
	  $totala_conc=0; $totald_conc=0; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre="";  $cant_emp=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		
		if(($prev_dep<>$cod_departam)or($prev_tipo<>$tipo_nomina)){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
			if($detalle_trab=='S'){
 			 if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		 	 if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			 $pdf->SetFont('Arial','',7);
			 $pdf->Cell(4,3,'',0,0);
			 $pdf->Cell(15,3,$prev_emp,0,0);
			 $pdf->Cell(115,3,$prev_nombre,0,0);
			 $pdf->Cell(22,3,$totala_emp,0,0,'R');
			 $pdf->Cell(22,3,$totald_emp,0,1,'R');			
		     $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $cant_emp=$cant_emp+1; }
			$pdf->SetFont('Arial','',8);
			if($detalle_trab=='S'){
			$pdf->Cell(134,2,'',0,0);
			$pdf->Cell(22,2,'------------------',0,0,'R');
			$pdf->Cell(22,2,'------------------',0,0,'R');
			$pdf->Cell(22,2,'------------------',0,1,'R');
			$pdf->Cell(134,3,'TOTAL '.$den_conc.' ',0,0,'R');
			$pdf->Cell(22,3,$totala_conc,0,0,'R');
			$pdf->Cell(22,3,$totald_conc,0,0,'R');
			$pdf->Cell(22,3,$neto,0,1,'R');
            $pdf->Ln(3); 
			}else{
			$pdf->Cell(12,3,$prev_conc,0,0);
			$pdf->Cell(122,3,$den_conc,0,0,'L');
			$pdf->Cell(22,3,$totala_conc,0,0,'R');
			$pdf->Cell(22,3,$totald_conc,0,0,'R');
			$pdf->Cell(22,3,$neto,0,1,'R'); }
		    $prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0; 
		
		    $neto=$totala_dep-$totald_dep; $neto=formato_monto($neto); $imp_encabezado=0;
		    $totala_dep=formato_monto($totala_dep); $totald_dep=formato_monto($totald_dep);
			$pdf->SetFont('Arial','B',8);
		    $pdf->Cell(134,2,'',0,0);
			$pdf->Cell(22,2,'============',0,0,'R');
			$pdf->Cell(22,2,'============',0,0,'R');
			$pdf->Cell(22,2,'============',0,1,'R');			
			$pdf->Cell(134,4,'Total : '.$prev_den_dep,0,0);
			$pdf->Cell(22,4,$totala_dep,0,0,'R');
			$pdf->Cell(22,4,$totald_dep,0,0,'R');
			$pdf->Cell(22,4,$neto,0,1,'R');
			$prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $cant_dep=0; $totala_dep=0; $totald_dep=0; $camb_nomina=0;
			if($prev_tipo<>$tipo_nomina){$neto=$totala_nom-$totald_nom; $neto=formato_monto($neto);
				$totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom); $camb_nomina=1;
				$pdf->Ln(10);
				$pdf->Cell(134,2,'',0,0);
				$pdf->Cell(22,2,'============',0,0,'R');
				$pdf->Cell(22,2,'============',0,0,'R');
				$pdf->Cell(22,2,'============',0,1,'R');			
				$pdf->Cell(134,4,'Total : '.$prev_den_nom,0,0);
				$pdf->Cell(22,4,$totala_nom,0,0,'R');
				$pdf->Cell(22,4,$totald_nom,0,0,'R');
				$pdf->Cell(22,4,$neto,0,1,'R');
				$prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $cant_nom=0; $totala_nom=0; $totald_nom=0; 
			}
		    //$pdf->AddPage(); 
			
			if(($salto_dep=="S")or($camb_nomina==1)){$pdf->AddPage();}else{$pdf->Ln(10);
			  $pdf->Cell(140,5,"DEPARTAMENTO : ".$cod_departam." ".$des_departam,0,1,'L');
			}
			if($detalle_trab=='S'){
			$pdf->SetFont('Arial','B',8);
		    $pdf->Cell(10,4,$cod_concepto,0,0);
			$pdf->Cell(70,4,$denominacion,0,1,'L');}
		  }
		
		if($prev_conc<>$cod_concepto){		
		  if($prev_conc<>""){$neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
			if($detalle_trab=='S'){
  			 if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		 	 if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			 $pdf->SetFont('Arial','',7);
			 $pdf->Cell(4,3,'',0,0);
			 $pdf->Cell(15,3,$prev_emp,0,0);
			 $pdf->Cell(115,3,$prev_nombre,0,0);
			 $pdf->Cell(22,3,$totala_emp,0,0,'R');
			 $pdf->Cell(22,3,$totald_emp,0,1,'R');			
		     $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $cant_emp=$cant_emp+1; }
			$pdf->SetFont('Arial','',8);
			if($detalle_trab=='S'){
			$pdf->Cell(134,2,'',0,0);
			$pdf->Cell(22,2,'------------------',0,0,'R');
			$pdf->Cell(22,2,'------------------',0,0,'R');
			$pdf->Cell(22,2,'------------------',0,1,'R');
			$pdf->Cell(134,3,'TOTAL '.$den_conc.' ',0,0,'R');
			$pdf->Cell(22,3,$totala_conc,0,0,'R');
			$pdf->Cell(22,3,$totald_conc,0,0,'R');
			$pdf->Cell(22,3,$neto,0,1,'R');
            $pdf->Ln(3); 
			}else{
			$pdf->Cell(12,3,$prev_conc,0,0);
			$pdf->Cell(122,3,$den_conc,0,0,'L');
			$pdf->Cell(22,3,$totala_conc,0,0,'R');
			$pdf->Cell(22,3,$totald_conc,0,0,'R');
			$pdf->Cell(22,3,$neto,0,1,'R');} 
		  }
		  if($detalle_trab=='S'){
		    $pdf->SetFont('Arial','B',8);
		    $pdf->Cell(10,4,$cod_concepto,0,0);
			$pdf->Cell(70,4,$denominacion,0,1,'L');	}	
		  $prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0; 
		}	
		
		$pdf->SetFont('Arial','',8);
		if($detalle_trab=='S'){
		   if($prev_emp<>$cod_empleado){
             if($prev_emp<>""){		   
		     if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		 	 if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			 $pdf->SetFont('Arial','',7);
			 $pdf->Cell(4,3,'',0,0);
			 $pdf->Cell(15,3,$prev_emp,0,0);
			 $pdf->Cell(115,3,$prev_nombre,0,0);
			 $pdf->Cell(22,3,$totala_emp,0,0,'R');
			 $pdf->Cell(22,3,$totald_emp,0,1,'R');	}		
		     $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $cant_emp=$cant_emp+1; 
		  }	
		}
		$can_conc=$can_conc+1; $totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;		
		$totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;
		$totala_nom=$totala_nom+$monto_asignacion; $totald_nom=$totald_nom+$monto_deduccion;
		$totala_dep=$totala_dep+$monto_asignacion; $totald_dep=$totald_dep+$monto_deduccion;
      
	  } $neto=""; if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} 
			if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
			$pdf->SetFont('Arial','',8);
			if($detalle_trab=='S'){
  			 if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		 	 if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			 $pdf->SetFont('Arial','',7);
			 $pdf->Cell(4,3,'',0,0);
			 $pdf->Cell(15,3,$prev_emp,0,0);
			 $pdf->Cell(115,3,$prev_nombre,0,0);
			 $pdf->Cell(22,3,$totala_emp,0,0,'R');
			 $pdf->Cell(22,3,$totald_emp,0,1,'R');			
		     $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $cant_emp=$cant_emp+1; }
			$pdf->SetFont('Arial','',8);
			if($detalle_trab=='S'){
			$pdf->Cell(134,2,'',0,0);
			$pdf->Cell(22,2,'------------------',0,0,'R');
			$pdf->Cell(22,2,'------------------',0,0,'R');
			$pdf->Cell(22,2,'------------------',0,1,'R');
			$pdf->Cell(134,3,'TOTAL '.$den_conc.' ',0,0,'R');
			$pdf->Cell(22,3,$totala_conc,0,0,'R');
			$pdf->Cell(22,3,$totald_conc,0,0,'R');
			$pdf->Cell(22,3,$neto,0,1,'R');
            $pdf->Ln(3); 
			}else{
			$pdf->Cell(12,3,$prev_conc,0,0);
			$pdf->Cell(122,3,$den_conc,0,0,'L');
			$pdf->Cell(22,3,$totala_conc,0,0,'R');
			$pdf->Cell(22,3,$totald_conc,0,0,'R');
			$pdf->Cell(22,3,$neto,0,1,'R'); }
			$neto=$totala_dep-$totald_dep; $neto=formato_monto($neto);
		    $totala_dep=formato_monto($totala_dep); $totald_dep=formato_monto($totald_dep);
			$pdf->SetFont('Arial','B',8);
		    $pdf->Cell(134,2,'',0,0);
			$pdf->Cell(22,2,'============',0,0,'R');
			$pdf->Cell(22,2,'============',0,0,'R');
			$pdf->Cell(22,2,'============',0,1,'R');			
			$pdf->Cell(134,4,'Total : '.$prev_den_dep,0,0);
			$pdf->Cell(22,4,$totala_dep,0,0,'R');
			$pdf->Cell(22,4,$totald_dep,0,0,'R');
			$pdf->Cell(22,4,$neto,0,1,'R');     
            $pdf->Ln(10);			
            $neto=$totala_nom-$totald_nom; $neto=formato_monto($neto);
			$totala_nom=formato_monto($totala_nom); $totald_nom=formato_monto($totald_nom);
			$pdf->Cell(134,2,'',0,0);
			$pdf->Cell(22,2,'============',0,0,'R');
			$pdf->Cell(22,2,'============',0,0,'R');
			$pdf->Cell(22,2,'============',0,1,'R');			
			$pdf->Cell(134,4,'Total : '.$prev_den_nom,0,0);		
			$pdf->Cell(22,4,$totala_nom,0,0,'R');
			$pdf->Cell(22,4,$totald_nom,0,0,'R');
			$pdf->Cell(22,4,$neto,0,1,'R');
	  $pdf->Output();   
    }

}
?>
