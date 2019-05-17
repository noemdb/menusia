<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"];   $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"]; $tipo_rpt=$_GET["tipo_rpt"]; $fecha_ant=$_GET["fecha_ant"];
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"];  $forma_pago=$_GET["forma_pago"];$tipo_calculo=$_GET["tipo_calculo"]; $tipo_concepto="NOMINA";
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a"); $cfechan=formato_aaaammdd($fecha_nom); $afechan=formato_aaaammdd($fecha_ant);  $php_os=PHP_OS; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_errorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $nom_emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
   $criterio=""; $criterio1=""; $criterio2=""; $ordenar=" order by tipo_nomina, cod_concepto, cod_empleado";
   if($act_hist=='S'){    
     $criterio=" rpt_nom_hist WHERE ((fecha_p_hasta='".$afechan."') or (fecha_p_hasta='".$cfechan."')) and (oculto='NO') and (cod_concepto<>'VVV') ";
     $criterio=$criterio." and (tp_calculo='".$tipo_calculo."') and (oculto='NO') and (cod_concepto<>'VVV') and (tipo_nomina='".$tipo_nomina_d."') and (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."')";
     if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
	 if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (concepto_vac='N') ";} 
	 if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and (concepto_vac='S') ";}
	 $sSQL = "SELECT * FROM ".$criterio.$ordenar;
   } else {
     $criterio=" (nom017.tp_calculo='".$tipo_calculo."') and (nom017.oculto='NO') and (nom017.cod_concepto<>'VVV') and (nom017.tipo_nomina='".$tipo_nomina_d."') and (nom017.cod_departam>='".$cod_departd."' and nom017.cod_departam<='".$cod_departh."') "; 
	 $criterio1=" (nom019.tp_calculo='".$tipo_calculo."') and (nom019.oculto='NO') and (nom019.cod_concepto<>'VVV') and (nom019.tipo_nomina='".$tipo_nomina_d."') and (nom019.cod_departam>='".$cod_departd."' and nom019.cod_departam<='".$cod_departh."')";
     $criterio=$criterio." and (nom017.fecha_p_hasta='".$cfechan."') ";
	 $criterio1=$criterio1." and (nom019.fecha_p_hasta='".$afechan."') ";
	 if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (nom017.tipo_pago='".$forma_pago."') ";   $criterio1=$criterio1." and (nom019.tipo_pago='".$forma_pago."') ";}
	 if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (nom017.concepto_vac='N') "; $criterio1=$criterio1." and (nom019.concepto_vac='N') ";} 
     $sql17 = "SELECT nom017.tipo_nomina,nom017.fecha_p_hasta,nom017.cod_empleado,nom017.cod_concepto,nom017.fecha_p_desde,nom017.fecha_hasta,nom017.fecha_desde,nom017.tp_calculo,nom017.Num_periodos,nom017.fecha_proceso,nom017.des_nomina,nom017.cod_grupo,nom017.desc_grupo,nom017.nombre,nom017.cedula,nom017.fecha_ingreso,nom017.status_emp,nom017.denominacion,nom017.asignacion,nom017.oculto,nom017.tipo_asigna,nom017.asig_ded_apo,nom017.prestamo,nom017.concepto_vac,nom017.cantidad,nom017.monto_orig,nom017.monto,nom017.monto_asignacion,nom017.monto_deduccion,nom017.acumulado,nom017.saldo,nom017.valorE,nom017.valorU,nom017.valorQ,nom017.valorW,nom017.valorX,nom017.valorY,nom017.valorZ,nom017.frecuencia,nom017.nro_semana,nom017.cod_cargo,nom017.sueldo_cargo,nom017.prima_cargo,nom017.compensa_cargo,nom017.sueldo_integral,nom017.otros,nom017.cod_departam,nom017.cod_tipo_personal,nom017.cod_presup,nom017.cod_contable,nom017.acumula,nom017.tipo_pago,nom017.cta_empleado,nom017.cta_empresa,nom017.afecta_presup,nom017.cod_retencion,nom017.codigo_ubicacion,nom017.status_calculo,to_char(nom017.fecha_p_hasta,'DD/MM/YYYY') as fechaph,to_char(nom017.fecha_p_desde,'DD/MM/YYYY') as fechapd,to_char(nom017.fecha_hasta,'DD/MM/YYYY') as fechah,to_char(nom017.fecha_desde,'DD/MM/YYYY') as fechad,to_char(nom017.fecha_ingreso,'DD/MM/YYYY') as fechai FROM nom017 "; 
     $sql19 = "SELECT nom019.tipo_nomina,nom019.fecha_p_hasta,nom019.cod_empleado,nom019.cod_concepto,nom019.fecha_p_desde,nom019.fecha_hasta,nom019.fecha_desde,nom019.tp_calculo,nom019.Num_periodos,nom019.fecha_proceso,nom019.des_nomina,nom019.cod_grupo,nom019.desc_grupo,nom019.nombre,nom019.cedula,nom019.fecha_ingreso,nom019.status_emp,nom019.denominacion,nom019.asignacion,nom019.oculto,nom019.tipo_asigna,nom019.asig_ded_apo,nom019.prestamo,nom019.concepto_vac,nom019.cantidad,nom019.monto_orig,nom019.monto,nom019.monto_asignacion,nom019.monto_deduccion,nom019.acumulado,nom019.saldo,nom019.valorE,nom019.valorU,nom019.valorQ,nom019.valorW,nom019.valorX,nom019.valorY,nom019.valorZ,nom019.frecuencia,nom019.nro_semana,nom019.cod_cargo,nom019.sueldo_cargo,nom019.prima_cargo,nom019.compensa_cargo,nom019.sueldo_integral,nom019.otros,nom019.cod_departam,nom019.cod_tipo_personal,nom019.cod_presup,nom019.cod_contable,nom019.acumula,nom019.tipo_pago,nom019.cta_empleado,nom019.cta_empresa,nom019.afecta_presup,nom019.cod_retencion,nom019.codigo_ubicacion,nom019.status_calculo,to_char(nom019.fecha_p_hasta,'DD/MM/YYYY') as fechaph,to_char(nom019.fecha_p_desde,'DD/MM/YYYY') as fechapd,to_char(nom019.fecha_hasta,'DD/MM/YYYY') as fechah,to_char(nom019.fecha_desde,'DD/MM/YYYY') as fechad,to_char(nom019.fecha_ingreso,'DD/MM/YYYY') as fechai FROM nom019 ";    
	 $sSQL = $sql17 . " Where " . $criterio . " Union All " . $sql19 . " Where " . $criterio1 . " order by 1,4,3,2"; 
   }
   if(($tipo_rpt=="PDF")){$res=pg_query($sSQL); $filas=pg_num_rows($res);
      $prev_tipo=""; $prev_den_nom=""; $prev_conc=""; $den_conc=""; $prev_emp="";       $cod_empleado=""; $tipo_nomina=""; $des_nomina="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; 
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $denominacion=utf8_decode($denominacion);}
        $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_emp=$cod_empleado;
	  }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $fecha_ant; global $fecha_nom;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(140,7,'RESUMEN VARIACIONES DE NOMINA',1,0,'C');
			$this->Cell(50);
			$this->Ln(17);
			$this->SetFont('Arial','B',9);
			$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');
			$this->Cell(130,5,"FECHA HASTA : ".$fecha_nom,0,0,'L');
			$this->Cell(130,5,"COMPARACION CON NOMINA FECHA HASTA : ".$fecha_ant,0,1,'R');
			$this->SetFont('Arial','B',8);
			$this->Cell(10,5,'','TL',0);
			$this->Cell(100,5,'','TR',0,'L');
			$this->Cell(50,5,'PERIODO ACTUAL','TRL',0,'C');
			$this->Cell(50,5,'PERIODO ANTERIOR','TRL',0,'C');
			$this->Cell(50,5,'VARIACIONES','TRL',1,'C');
			$this->Cell(10,5,'Codigo','BL',0);
			$this->Cell(100,5,' Descripcion del Concepto','BR',0,'L');
			$this->Cell(10,5,'Cant.','B',0);
			$this->Cell(20,5,'Asignaciones','B',0);
			$this->Cell(20,5,'Deducciones','BR',0);			
			$this->Cell(10,5,'Cant.','B',0);
			$this->Cell(20,5,'Asignaciones','B',0);
			$this->Cell(20,5,'Deducciones','BR',0);			
			$this->Cell(10,5,'Cant.','B',0);
			$this->Cell(20,5,'Asignaciones','B',0);
			$this->Cell(20,5,'Deducciones','BR',1);			
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  //$pdf=new PDF('P', 'mm', Letter);
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  //$pdf->MultiCell(260,4,$sSQL,0);
	  $i=0;  $gtotala_nom=0; $gtotald_nom=0; $gcant_nom=0;	$gtotala_ant=0; $gtotald_ant=0; $gcant_var=0;  $gtotala_var=0; $gtotald_var=0; 	  
	  $can_conc=0; $totala_conc=0; $totald_conc=0; $can_var=0; $totala_var=0; $totald_var=0;  $can_ant=0; $totala_ant=0; $totald_ant=0; 	  
	  $prev_conc=""; $den_conc="";  $total_emp=0; $atotal_emp=0;  
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $fecha_p_hasta=$registro["fecha_p_hasta"]; 
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		$valorz=$registro["valorz"]; $monto=$registro["monto"]; $asig_ded_apo=$registro["asig_ded_apo"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $denominacion=utf8_decode($denominacion);}
		
		if($prev_emp<>$cod_empleado){	  if($total_emp<>$atotal_emp){ $can_var=$can_var+1; } $prev_emp=$cod_empleado;  $total_emp=0; $atotal_emp=0; 	}
		
		
		if($prev_conc<>$cod_concepto){	
		  if($prev_conc<>""){
		    $gtotala_nom=$gtotala_nom+$totala_conc; $gtotald_nom=$gtotald_nom+$totald_conc;
			$gtotala_ant=$gtotala_ant+$totala_ant; $gtotald_ant=$gtotald_ant+$totald_ant;
			$can_dif=$can_conc-$can_ant; $totala_var=$totala_conc-$totala_ant;  $totald_var=$totald_conc-$totald_ant;
			$can_var=$can_conc-$can_ant; $gtotala_var=$gtotala_var+$totala_var; $gtotald_var=$gtotald_var+$totald_var; 
			$totala_var=abs($totala_var); $totald_var=abs($totald_var);				
			if(($totala_ant>$totala_conc)and ($totala_var<>0)) { $totala_var="(".formato_monto($totala_var).")";  } else { $totala_var=formato_monto($totala_var); }
			if(($totald_ant>$totald_conc)and ($totald_var<>0)) { $totald_var="(".formato_monto($totald_var).")";  } else { $totald_var=formato_monto($totald_var); 	}	
            if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
			if($totala_ant==0){$totala_ant="";}else{$totala_ant=formato_monto($totala_ant);} 	if($totald_ant==0){$totald_ant="";}else{$totald_ant=formato_monto($totald_ant);}
			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(10,4,$prev_conc,'L',0);
			$pdf->Cell(100,4,$den_conc,'R',0,'L');
			$pdf->Cell(10,4,$can_conc,0,0,'C');
			$pdf->Cell(20,4,$totala_conc,0,0,'R');
			$pdf->Cell(20,4,$totald_conc,'R',0,'R');
            $pdf->Cell(10,4,$can_ant,0,0,'C');
			$pdf->Cell(20,4,$totala_ant,0,0,'R');
			$pdf->Cell(20,4,$totald_ant,'R',0,'R');
            $pdf->Cell(10,4,$can_var,0,0,'C');
			$pdf->Cell(20,4,$totala_var,0,0,'R');
			$pdf->Cell(20,4,$totald_var,'R',1,'R');	
		  }
		  $prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_part=substr($cod_presup,$ini,$p);	$totala_conc=0; $totald_conc=0;  $can_conc=0;
		  $can_ant=0; $totala_ant=0; $totald_ant=0; $can_var=0; $totala_var=0; $totald_var=0; $total_emp=0; $atotal_emp=0;
		}
		if($fecha_p_hasta==$cfechan){$can_conc=$can_conc+1; $totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion; $total_emp=$total_emp+$monto;	}	
		if($fecha_p_hasta==$afechan){$can_ant=$can_ant+1; $totala_ant=$totala_ant+$monto_asignacion; $totald_ant=$totald_ant+$monto_deduccion;	 $atotal_emp=$atotal_emp+$monto; }	
      }
	  if($prev_conc<>""){
	       $gtotala_nom=$gtotala_nom+$totala_conc; $gtotald_nom=$gtotald_nom+$totald_conc;
			$gtotala_ant=$gtotala_ant+$totala_ant; $gtotald_ant=$gtotald_ant+$totald_ant;
			$can_dif=$can_conc-$can_ant; $totala_var=$totala_conc-$totala_ant;  $totald_var=$totald_conc-$totald_ant;
			$can_var=$can_conc-$can_ant; $gtotala_var=$gtotala_var+$totala_var; $gtotald_var=$gtotald_var+$totald_var; 
			$totala_var=abs($totala_var); $totald_var=abs($totald_var);				
			if(($totala_ant>$totala_conc)and ($totala_var<>0)) { $totala_var="(".formato_monto($totala_var).")";  } else { $totala_var=formato_monto($totala_var); }
			if(($totald_ant>$totald_conc)and ($totald_var<>0)) { $totald_var="(".formato_monto($totald_var).")";  } else { $totald_var=formato_monto($totald_var); 	}	
            if($totala_conc==0){$totala_conc="";}else{$totala_conc=formato_monto($totala_conc);} if($totald_conc==0){$totald_conc="";}else{$totald_conc=formato_monto($totald_conc);}
			if($totala_ant==0){$totala_ant="";}else{$totala_ant=formato_monto($totala_ant);} 	if($totald_ant==0){$totald_ant="";}else{$totald_ant=formato_monto($totald_ant);}
			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(10,4,$prev_conc,'LB',0);
			$pdf->Cell(100,4,$den_conc,'RB',0,'L');
			$pdf->Cell(10,4,$can_conc,'B',0,'C');
			$pdf->Cell(20,4,$totala_conc,'B',0,'R');
			$pdf->Cell(20,4,$totald_conc,'RB',0,'R');
            $pdf->Cell(10,4,$can_ant,'B',0,'C');
			$pdf->Cell(20,4,$totala_ant,'B',0,'R');
			$pdf->Cell(20,4,$totald_ant,'RB',0,'R');
            $pdf->Cell(10,4,$can_var,'B',0,'C');
			$pdf->Cell(20,4,$totala_var,'B',0,'R');
			$pdf->Cell(20,4,$totald_var,'RB',1,'R');
	  } $gtotala_nom=formato_monto($gtotala_nom); $gtotald_nom=formato_monto($gtotald_nom);
	  $gtotala_ant=formato_monto($gtotala_ant); $gtotald_ant=formato_monto($gtotald_ant);
	  $gtotala_var=formato_monto($gtotala_var); $gtotald_var=formato_monto($gtotald_var);
	  $pdf->SetFont('Arial','B',9);
      $pdf->Cell(110,5,'TOTAL ',1,0,'R');
      $pdf->Cell(10,5,' ','B',0,'R');
	  $pdf->Cell(20,5,$gtotala_nom,'B',0,'R');
	  $pdf->Cell(20,5,$gtotald_nom,'RB',0,'R'); 
	  $pdf->Cell(10,5,' ','B',0,'R');
	  $pdf->Cell(20,5,$gtotala_ant,'B',0,'R');
	  $pdf->Cell(20,5,$gtotald_ant,'RB',0,'R'); 
	  $pdf->Cell(10,5,' ','B',0,'R');
	  $pdf->Cell(20,5,$gtotala_var,'B',0,'R');
	  $pdf->Cell(20,5,$gtotald_var,'RB',0,'R'); 	  
	   
	  $pdf->Output();    
    }
   
   
}
?>