<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"]; $rango_f=$_GET["rango_f"];
   $cod_presup_d=$_GET["cod_presup_d"];$cod_presup_h=$_GET["cod_presup_h"]; $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $fecha_desde=$_GET["fecha_desde"];  $fecha_hasta=$_GET["fecha_hasta"];
   $tipo_calculo=$_GET["tipo_calculo"]; $detalle_concepto=$_GET["detalle_concepto"];  $mes_comp=$_GET["mes_comp"]; $tipo_rpt=$_GET["tipo_rpt"];   $php_os=PHP_OS;
   $Sql=""; $date=date("d-m-Y"); $hora=date("h:i:s a"); $cfechan=formato_aaaammdd($fecha_nom);  $criterio2=""; $criterio3=""; $cfechad=formato_aaaammdd($fecha_desde); $cfechah=formato_aaaammdd($fecha_hasta);
   $criterio=" and (oculto='SI') and (asig_ded_apo='P') "; $criterio1="FECHA AL ".$fecha_nom;
   if($act_hist=='S'){$criterio=" and (fecha_p_hasta='".$cfechan."') and (oculto='SI') and (asig_ded_apo='P') ";
      if($mes_comp=='S'){ $fecha_d=$fecha_nom; $fecha_d=colocar_pdiames($fecha_d); $dfechan=formato_aaaammdd($fecha_d); $criterio=" and (fecha_p_desde>='".$dfechan."') and (fecha_p_hasta<='".$cfechan."')  and (oculto='SI') and (asig_ded_apo='P')"; 
         $criterio1="FECHA: ".$fecha_d." AL ".$fecha_nom; } } 
   if($rango_f=='S'){ $act_hist='S';  $mes_comp='S'; $criterio="and (fecha_p_hasta>='".$cfechad."') and (fecha_p_hasta<='".$cfechah."') and (oculto='SI') and (asig_ded_apo='P') ";   
                      $criterio1="FECHA: ".$fecha_desde." AL ".$fecha_hasta;	}
   		 
   if($estatus_trab_d=='TODOS'){$status="";}else{$status." and (status_emp='".$estatus_trab_d."') ";}
   if($tipo_calculo=="T"){ $criterio=$criterio." and ((tp_calculo='N')or(tp_calculo='E')) "; } else { $criterio=$criterio." and (tp_calculo='".$tipo_calculo."')"; }
    if($cod_conceptod==$cod_conceptoh){$criterio3="S";}
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE de DATOS'); </script> <?}
else{  $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} $criterio3="";
         if($tipo_nomina_d<>$tipo_nomina_h){$sql="SELECT tipo_nomina,descripcion,desc_grupo from nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); 
			if($registro=pg_fetch_array($res,0)){$criterio2=$registro["desc_grupo"];}  }
		 
         if($act_hist=='S'){ $sSQL = "SELECT nom019.tipo_nomina, nom019.des_Nomina, nom019.fecha_desde, nom019.fecha_Hasta, nom019.cod_concepto, nom019.denominacion, nom019.cod_Empleado, nom019.Nombre, nom019.Asignacion, nom019.Monto_Asignacion, nom019.Monto_deduccion, nom019.Oculto, nom019.monto, nom019.monto_aporte, nom019.cod_presup, nom019.cod_contable, nom019.fecha_p_Hasta, nom019.Tp_calculo, nom019.desc_Grupo,
                   nom019.Afecta_presup,nom019.cod_Retencion,  nom019.Asig_ded_Apo,to_char(nom019.fecha_hasta,'DD/MM/YYYY') as fechah,to_char(nom019.fecha_desde,'DD/MM/YYYY') as fechad, to_char(nom019.fecha_p_hasta,'DD/MM/YYYY') as fechaph,to_char(nom019.fecha_p_desde,'DD/MM/YYYY') as fechapd, pre022.cod_presup_p, pre022.cod_fuente_p, pre022.denominacion_p
                   FROM nom019 left join pre022 on (nom019.cod_presup=pre022.cod_presup_p and nom019.cod_contable=pre022.cod_fuente_p)
                   WHERE  ((nom019.cod_concepto<>'VVV') and  (nom019.Monto>0)) and
                   (nom019.tipo_nomina>='".$tipo_nomina_d."' and nom019.tipo_nomina<='".$tipo_nomina_h."') and  (nom019.cod_concepto>='".$cod_conceptod."' and nom019.cod_concepto<='".$cod_conceptoh."') and
                   (nom019.cod_presup>='".$cod_presup_d."' and nom019.cod_presup<='".$cod_presup_h."')  ".$status.$criterio.
                   " order by nom019.cod_presup, nom019.tipo_nomina, nom019.cod_concepto"; }
		   
		   else{ $sSQL = "SELECT nom017.tipo_nomina, nom017.des_Nomina, nom017.fecha_desde, nom017.fecha_Hasta, nom017.cod_concepto, nom017.denominacion, nom017.cod_Empleado, nom017.Nombre, nom017.Asignacion, nom017.Monto_Asignacion, nom017.Monto_deduccion, nom017.Oculto, nom017.monto, nom017.monto_aporte, nom017.cod_presup, nom017.cod_contable, nom017.fecha_p_Hasta, nom017.Tp_calculo, nom017.desc_Grupo,
                   nom017.Afecta_presup,nom017.cod_Retencion,  nom017.Asig_ded_Apo,to_char(nom017.fecha_hasta,'DD/MM/YYYY') as fechah,to_char(nom017.fecha_desde,'DD/MM/YYYY') as fechad, to_char(nom017.fecha_p_hasta,'DD/MM/YYYY') as fechaph,to_char(nom017.fecha_p_desde,'DD/MM/YYYY') as fechapd, pre022.cod_presup_p, pre022.cod_fuente_p, pre022.denominacion_p
                   FROM nom017 left join pre022 on (nom017.cod_presup=pre022.cod_presup_p and nom017.cod_contable=pre022.cod_fuente_p)
                   WHERE  ((nom017.cod_concepto<>'VVV') and (nom017.Monto>0)) and
                   (nom017.tipo_nomina>='".$tipo_nomina_d."' and nom017.tipo_nomina<='".$tipo_nomina_h."') and (nom017.cod_concepto>='".$cod_conceptod."' and nom017.cod_concepto<='".$cod_conceptoh."') and
                   (nom017.cod_presup>='".$cod_presup_d."' and nom017.cod_presup<='".$cod_presup_h."')  ".$status.$criterio.
                   " order by nom017.cod_presup, nom017.tipo_nomina, nom017.cod_concepto";}
		$nomb_rpt="Rpt_rela_con_cod_pre_apor_rn_re.xml";	$num_rpt=1;	
        if($detalle_concepto=="SI"){$nomb_rpt="Rpt_rela_con_cod_pre_apor_rn_re_deta_concep.xml";	$num_rpt=2;}		   
	
	if($tipo_rpt=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");
          $oRpt = new PHPReportMaker();
          $oRpt->setXML($nomb_rpt);
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"criterio3"=>$criterio3,"mes_comp"=>$mes_comp,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
          $aBench = $oRpt->getBenchmark();
    }
	if(($tipo_rpt=="PDF")and($num_rpt==1)){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_presup_grupo=""; $des_nomina="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $fechad=$registro["fechad"]; $fechaph=$registro["fechaph"]; $des_nomina=$registro["des_nomina"]; }	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 	
		function Header(){ global $criterio2;  global $criterio1; global $criterio3; global $mes_comp; global $fechad; global $fechaph;  global $registro;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(30);
			$this->Cell(140,10,'RELACION CONCEPTOS/CODIGOS PRESUPUESTARIOS(APORTES)',1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',8);
			if($criterio2==""){$this->Cell(120,5,"NOMINA : ".$registro["tipo_nomina"]." ".$registro["des_nomina"],0,1,'L');}     
			else{$this->Cell(120,5,$criterio2,0,1,'L');	}
			if($mes_comp=="S"){$this->Cell(120,5,$criterio1,0,1,'L');	}  
			else{$this->Cell(120,5,"Fecha : ".$fechad." al ".$fechaph,0,1,'L');	}
			$this->SetFont('Arial','B',7);
			$this->Cell(44,5,'CODIGO PRESUPUESTARIO',1,0);
			$this->Cell(136,5,'DENOMINACION',1,0,'L');
			$this->Cell(20,5,'MONTO',1,1,"C");
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total_monto_asignacion=0; $total_monto_deduccion=0; $total_monto=0; $sub_total_monto_asignacion=""; $sub_total_monto_deduccion=""; $sub_total_monto=""; $prev_cod_presup="";  $prev_cod_contable=""; $prev_denominacion_p="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_presup=$registro["cod_presup"];  $denominacion_p=$registro["denominacion_p"]; $cod_contable=$registro["cod_contable"]; 
		   if($php_os=="WINNT"){$denominacion_p=$registro["denominacion_p"];}else{$denominacion_p=utf8_decode($registro["denominacion_p"]); }
		   $cod_presup_grupo=$cod_presup." ".$cod_contable;  $denominacion_p_grupo=$denominacion_p;  
		   if($prev_cod_presup<>$cod_presup_grupo){ 
			 if(($sub_total_monto>0)){  $sub_total_monto=formato_monto($sub_total_monto);				    
				$pdf->Cell(44,4,$prev_cod_presup,0,0,'L');
		        $x=$pdf->GetX();   $y=$pdf->GetY();  $w=136;		   
		   		$pdf->SetXY($x+$w,$y);	
		   		$pdf->Cell(20,4,$sub_total_monto,0,1,'R'); 
		  		$pdf->SetXY($x,$y);	
		   		$pdf->MultiCell($w,4,$prev_denominacion_p,0); 	
			 }	
			 $prev_cod_presup=$cod_presup_grupo;  $prev_cod_contable=$cod_contable; $prev_denominacion_p=$denominacion_p_grupo; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $sub_total_monto=0;
		   }		   

		   $cod_presup=$registro["cod_presup"]; $cod_contable=$registro["cod_contable"];  $denominacion_p=$registro["denominacion_p"]; $monto_aporte=$registro["monto_aporte"]; 
		   $total_monto=$total_monto+$monto_aporte;  $sub_total_monto=$sub_total_monto+$monto_aporte;
		   if($php_os=="WINNT"){$denominacion_p=$registro["denominacion_p"]; }   else{$denominacion_p=utf8_decode($denominacion_p); $denominacion_p=utf8_decode($denominacion_p);}

		} 
		if(($sub_total_monto>0)){ $sub_total_monto=formato_monto($sub_total_monto);				    
			$pdf->Cell(44,4,$prev_cod_presup,0,0,'L');
			$x=$pdf->GetX();   $y=$pdf->GetY();  $w=136;		   
			$pdf->SetXY($x+$w,$y);
			$pdf->Cell(20,4,$sub_total_monto,0,1,'R'); 
			$pdf->SetXY($x,$y);	
			$pdf->MultiCell($w,4,$prev_denominacion_p,0); 	
			$pdf->Ln(2);
		} $total_monto=formato_monto($total_monto); 
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(180,3,'',0,0);
		$pdf->Cell(20,3,'=============',0,1,'R');
		$pdf->Cell(180,3,'TOTAL GENERAL : ',0,0,'R');
		$pdf->Cell(20,3,$total_monto,0,1,'R');  
		
		//para las firmas en la ultima pagina		
		$sql="SELECT campo103, campo104 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  
        if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $Nom_usuario=$registro["campo104"];}
            $pdf->Ln(10);
			$x=$pdf->GetX();   $y=$pdf->GetY(); if($y<235){$y=235;   $pdf->SetXY($x,$y);}  
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(5,4,'',0,0);
			$pdf->Cell(60,4,'Analista de Nomina','T',0,'C');
			$pdf->Cell(5,4,'',0,0);
			$pdf->Cell(60,4,'Revisado Por','T',0,'C');
			$pdf->Cell(5,4,'',0,0);
			$pdf->Cell(60,4,'Aprobado Por','T',1,'C');
			
			$pdf->Cell(5,4,'',0,0);
			$pdf->Cell(60,4,$Nom_usuario,0,0,'C');
			$pdf->Cell(5,4,'',0,0);
			$pdf->Cell(60,4,'',0,0,'C');
			$pdf->Cell(5,4,'',0,0);
			$pdf->Cell(60,4,'Direccion de RHHH',0,1,'C');
			
			$pdf->Cell(5,4,'',0,0);
			$pdf->Cell(60,4,'',0,0,'C');
			$pdf->Cell(5,4,'',0,0);
			$pdf->Cell(60,4,'',0,0,'C');
			$pdf->Cell(5,4,'',0,0);
			$pdf->Cell(60,4,'ABOG. FRAXNEIS FIGUEROA',0,1,'C');
		//termina las firmas	
			
			
		$pdf->Output();   
    }
	
	if(($tipo_rpt=="PDF")and($num_rpt==2)){ $res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_presup_grupo=""; 
      if($filas>=1){ $registro=pg_fetch_array($res,0); $fechad=$registro["fechad"]; $fechaph=$registro["fechaph"]; }	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 	
		function Header(){ global $criterio2; global $criterio1; global $criterio3; global $mes_comp; global $fechad; global $fechaph;  global $registro;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(30);
			$this->Cell(140,10,'RELACION CONCEPTOS/CODIGOS PRESUPUESTARIOS(APORTES)',1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',8);
			if($criterio2==""){$this->Cell(120,5,"NOMINA : ".$registro["tipo_nomina"]." ".$registro["des_nomina"],0,1,'L');}       
			else{$this->Cell(120,5,$criterio2,0,1,'L');	}
			if($mes_comp=="S"){$this->Cell(120,5,$criterio1,0,1,'L');	}  
			else{$this->Cell(120,5,"Fecha : ".$fechad." al ".$fechaph,0,1,'L');	}
			$this->SetFont('Arial','B',7);
			$this->Cell(35,5,'CODIGO PRESUPUESTARIO',1,0);
			$this->Cell(145,5,'DENOMINACION',1,0,'L');
			$this->Cell(20,5,'MONTO',1,1,"C");
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',6);
	  $i=0;  $total_monto_asignacion=0; $total_monto_deduccion=0; $total_monto=0; $sub_total_monto_asignacion=""; $sub_total_monto_deduccion=""; $sub_total_monto=0; $sub_total_monto_asignacion1=""; $sub_total_monto_deduccion1=""; $sub_total_monto1=0; $prev_cod_presup=""; $prev_denominacion_p=""; $prev_cod_concepto=""; $prev_denominacion="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_presup=$registro["cod_presup"]; $denominacion_p=$registro["denominacion_p"];  $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; 
		if($php_os=="WINNT"){$denominacion_p=$registro["denominacion_p"];}else{$denominacion_p=utf8_decode($registro["denominacion_p"]);$denominacion=utf8_decode($registro["denominacion"]); }
		   $cod_presup_grupo=$cod_presup." ".$cod_contable; $denominacion_p_grupo=$denominacion_p; $cod_concepto_grupo=$cod_concepto;  $denominacion_grupo=$denominacion;   

		   if($prev_cod_concepto<>$cod_concepto_grupo){ 
			 if(($sub_total_monto>0)){ $sub_total_monto=formato_monto($sub_total_monto);	 			    
				$pdf->Cell(10,3,'',0,0,'R');
				$pdf->Cell(10,3,$prev_cod_concepto,0,0,'R');
		        $x=$pdf->GetX();   $y=$pdf->GetY();  $w=160;		   
		   		$pdf->SetXY($x+$w,$y);		   
		   		$pdf->Cell(20,3,$sub_total_monto,0,1,'R'); 
		  		$pdf->SetXY($x,$y);	
		   		$pdf->MultiCell($w,3,$prev_denominacion,0);
				$sub_total_monto=0;
			 }	
			 $prev_cod_concepto=$cod_concepto_grupo; $prev_denominacion=$denominacion_grupo; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; 
		   }	 

		   if($prev_cod_presup<>$cod_presup_grupo){ 
			 if(($sub_total_monto1>0)){  $sub_total_monto1=formato_monto($sub_total_monto1);	
				$pdf->Cell(180,2,'',0,0,'R');		
				$pdf->Cell(20,2,'____________',0,1,'R');			
				$pdf->Cell(180,3,'Total : '.$prev_cod_presup,0,0,'R');
				$pdf->Cell(20,3,$sub_total_monto1,0,1,'R');
				$pdf->Ln(3); $sub_total_monto1=0;
			 }			 
				 $pdf->Cell(30,5,$cod_presup_grupo,0,0,'L');  
				 $pdf->Cell(170,5,$denominacion_p_grupo,0,1,'L');   
				 $prev_cod_presup=$cod_presup_grupo; $prev_denominacion_p=$denominacion_p_grupo; $sub_total_monto_asignacion=0; $sub_total_monto_deduccion=0; $sub_total_monto=0;} 

		    $cod_presup=$registro["cod_presup"]; $denominacion_p=$registro["denominacion_p"]; $cod_concepto=$registro["cod_concepto"]; 
		    $denominacion=$registro["denominacion"];      $monto_aporte=$registro["monto_aporte"]; 
		    $total_monto=$total_monto+$monto_aporte; $sub_total_monto=$sub_total_monto+$monto_aporte;	$sub_total_monto1=$sub_total_monto1+$monto_aporte;	   
		   } if(($sub_total_monto>0)){ $sub_total_monto=formato_monto($sub_total_monto);	 			    
				$pdf->Cell(10,3,'',0,0,'R');
				$pdf->Cell(10,3,$prev_cod_concepto,0,0,'R');
		        $x=$pdf->GetX();   $y=$pdf->GetY();  $w=160;		   
		   		$pdf->SetXY($x+$w,$y);		   
		   		$pdf->Cell(20,3,$sub_total_monto,0,1,'R'); 
		  		$pdf->SetXY($x,$y);	
		   		$pdf->MultiCell($w,3,$prev_denominacion,0);
			 }	
			if($sub_total_monto1>0){  $sub_total_monto1=formato_monto($sub_total_monto1);
  			    $pdf->Cell(180,2,'',0,0,'R');			    
				$pdf->Cell(20,2,'____________',0,1,'R');		
				$pdf->Cell(180,3,'Total : '.$prev_cod_presup,0,0,'R');
				$pdf->Cell(20,3,$sub_total_monto1,0,1,'R');
				$pdf->Ln(5);
			 }$total_monto=formato_monto($total_monto);
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(180,3,'',0,0);
		$pdf->Cell(20,3,'=============',0,1,'R');
		$pdf->Cell(180,3,'TOTAL GENERAL : ',0,0,'R');
		$pdf->Cell(20,3,$total_monto,0,1,'R');  
	

	
		$pdf->Output();   
    }
	
}
     
?>
