<? include ("../../class/seguridad.inc"); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc");
   $tipo_nomina_d=$_GET["tipo_nomina_d"];   $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"]; $tipo_rpt=$_GET["tipo_rpt"]; $fecha_ant=$_GET["fecha_ant"];
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"];  $forma_pago=$_GET["forma_pago"];$tipo_calculo=$_GET["tipo_calculo"]; $tipo_concepto="nomINA";
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"];
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a"); $cfechan=formato_aaaammdd($fecha_nom); $afechan=formato_aaaammdd($fecha_ant);  $php_os=PHP_OS; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_errorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $nom_emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
   $criterio=""; $criterio1=""; $criterio2=""; $ordenar=" order by tipo_nomina, cod_concepto, cod_empleado";
   if($act_hist=='S'){    
     $criterio=" rpt_nom_hist WHERE ((fecha_p_hasta='".$afechan."') or (fecha_p_hasta='".$cfechan."')) and (oculto='NO') and (cod_concepto<>'VVV') ";
     $criterio=" and (nom019.tp_calculo='".$tipo_calculo."') and (nom019.oculto='NO') and (nom019.cod_concepto<>'VVV') and (nom019.tipo_nomina='".$tipo_nomina_d."') and (nom019.cod_departam>='".$cod_departd."' and nom019.cod_departam<='".$cod_departh."')";
     if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (tipo_pago='".$forma_pago."') ";}
	 if($tipo_concepto=="nomINA"){$criterio=$criterio." and (concepto_vac='N') ";} 
	 if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and (concepto_vac='S') ";}
	 $sSQL = "SELECT * FROM ".$criterio.$ordenar;	 
   } else {
     $criterio=" (nom017.tp_calculo='".$tipo_calculo."') and (nom017.oculto='NO') and (nom017.cod_concepto<>'VVV') and (nom017.tipo_nomina='".$tipo_nomina_d."') and (nom017.cod_departam>='".$cod_departd."' and nom017.cod_departam<='".$cod_departh."') "; 
	 $criterio1=" (nom019.tp_calculo='".$tipo_calculo."') and (nom019.oculto='NO') and (nom019.cod_concepto<>'VVV') and (nom019.tipo_nomina='".$tipo_nomina_d."') and (nom019.cod_departam>='".$cod_departd."' and nom019.cod_departam<='".$cod_departh."')";
     $criterio=$criterio." and (nom017.fecha_p_hasta='".$cfechan."') ";
	 $criterio1=$criterio1." and (nom019.fecha_p_hasta='".$afechan."') ";
	 if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (nom017.tipo_pago='".$forma_pago."') ";   $criterio1=$criterio1." and (nom019.tipo_pago='".$forma_pago."') ";}
	 if($tipo_concepto=="nomINA"){$criterio=$criterio." and (nom017.concepto_vac='N') "; $criterio1=$criterio1." and (nom019.concepto_vac='N') ";} 
     $sql17 = "SELECT nom017.tipo_nomina,nom017.fecha_p_hasta,nom017.cod_empleado,nom017.cod_concepto,nom017.fecha_p_desde,nom017.fecha_hasta,nom017.fecha_desde,nom017.tp_calculo,nom017.Num_periodos,nom017.fecha_proceso,nom017.des_nomina,nom017.cod_grupo,nom017.desc_grupo,nom017.nombre,nom017.cedula,nom017.fecha_ingreso,nom017.status_emp,nom017.denominacion,nom017.asignacion,nom017.oculto,nom017.tipo_asigna,nom017.asig_ded_apo,nom017.prestamo,nom017.concepto_vac,nom017.cantidad,nom017.monto_orig,nom017.monto,nom017.monto_asignacion,nom017.monto_deduccion,nom017.acumulado,nom017.saldo,nom017.valorE,nom017.valorU,nom017.valorQ,nom017.valorW,nom017.valorX,nom017.valorY,nom017.valorZ,nom017.frecuencia,nom017.nro_semana,nom017.cod_cargo,nom017.sueldo_cargo,nom017.prima_cargo,nom017.compensa_cargo,nom017.sueldo_integral,nom017.otros,nom017.cod_departam,nom017.cod_tipo_personal,nom017.cod_presup,nom017.cod_contable,nom017.acumula,nom017.tipo_pago,nom017.cta_empleado,nom017.cta_empresa,nom017.afecta_presup,nom017.cod_retencion,nom017.codigo_ubicacion,nom017.status_calculo,to_char(nom017.fecha_p_hasta,'DD/MM/YYYY') as fechaph,to_char(nom017.fecha_p_desde,'DD/MM/YYYY') as fechapd,to_char(nom017.fecha_hasta,'DD/MM/YYYY') as fechah,to_char(nom017.fecha_desde,'DD/MM/YYYY') as fechad,to_char(nom017.fecha_ingreso,'DD/MM/YYYY') as fechai FROM nom017 "; 
     $sql19 = "SELECT nom019.tipo_nomina,nom019.fecha_p_hasta,nom019.cod_empleado,nom019.cod_concepto,nom019.fecha_p_desde,nom019.fecha_hasta,nom019.fecha_desde,nom019.tp_calculo,nom019.Num_periodos,nom019.fecha_proceso,nom019.des_nomina,nom019.cod_grupo,nom019.desc_grupo,nom019.nombre,nom019.cedula,nom019.fecha_ingreso,nom019.status_emp,nom019.denominacion,nom019.asignacion,nom019.oculto,nom019.tipo_asigna,nom019.asig_ded_apo,nom019.prestamo,nom019.concepto_vac,nom019.cantidad,nom019.monto_orig,nom019.monto,nom019.monto_asignacion,nom019.monto_deduccion,nom019.acumulado,nom019.saldo,nom019.valorE,nom019.valorU,nom019.valorQ,nom019.valorW,nom019.valorX,nom019.valorY,nom019.valorZ,nom019.frecuencia,nom019.nro_semana,nom019.cod_cargo,nom019.sueldo_cargo,nom019.prima_cargo,nom019.compensa_cargo,nom019.sueldo_integral,nom019.otros,nom019.cod_departam,nom019.cod_tipo_personal,nom019.cod_presup,nom019.cod_contable,nom019.acumula,nom019.tipo_pago,nom019.cta_empleado,nom019.cta_empresa,nom019.afecta_presup,nom019.cod_retencion,nom019.codigo_ubicacion,nom019.status_calculo,to_char(nom019.fecha_p_hasta,'DD/MM/YYYY') as fechaph,to_char(nom019.fecha_p_desde,'DD/MM/YYYY') as fechapd,to_char(nom019.fecha_hasta,'DD/MM/YYYY') as fechah,to_char(nom019.fecha_desde,'DD/MM/YYYY') as fechad,to_char(nom019.fecha_ingreso,'DD/MM/YYYY') as fechai FROM nom019 ";    
	 $sSQL = $sql17 . " Where " . $criterio . " Union All " . $sql19 . " Where " . $criterio1 . " order by 1,4,3"; 
   }
   if(($tipo_rpt=="PDF")){$res=pg_query($sSQL); $filas=pg_num_rows($res);
      $prev_tipo=""; $prev_den_nom=""; $prev_conc=""; $den_conc=""; $prev_emp="";       $cod_empleado=""; $tipo_nomina=""; $des_nomina="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; 
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $denominacion=utf8_decode($denominacion);}
        $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_emp="";
	  }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $fecha_ant; global $fecha_nom;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(40);
			$this->Cell(120,7,'DETALLE VARIACIONES DE NOMINA',1,0,'C');
			$this->Cell(20);
			$this->Ln(17);
			$this->SetFont('Arial','B',9);
			$this->Cell(150,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');
			$this->Cell(100,5,"FECHA HASTA : ".$fecha_nom,0,0,'L');
			$this->Cell(100,5,"COMPARACION CON NOMINA FECHA HASTA : ".$fecha_ant,0,1,'R');
			$this->SetFont('Arial','B',8);
			$this->Cell(17,5,'Codigo',1,0);
			$this->Cell(121,5,'Nombre Trabajador',1,0,'L');
			$this->Cell(22,5,'Monto Actual',1,0,'C');
			$this->Cell(20,5,'Monto Anterior',1,0,'C');
			$this->Cell(20,5,'Diferencia',1,1,'C');
			
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  //$pdf->MultiCell(260,4,$sSQL,0);
	  $i=0;   $can_conc=0; $act_conc=0; $ant_conc=0; $var_conc=0; $monto_emp=0; $ant_emp=0; $var_emp=0;
	  
	  $prev_conc=""; $den_conc=""; $prev_ada="";  $prev_emp=""; $prev_nombre=""; $totala_emp=0; $totald_emp=0; $cant_emp=0; $anta_emp=0; $antd_emp=0; 
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $fecha_p_hasta=$registro["fecha_p_hasta"]; 
		$cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		$valorz=$registro["valorz"]; $monto=$registro["monto"]; $asig_ded_apo=$registro["asig_ded_apo"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina); $nombre=utf8_decode($nombre); $denominacion=utf8_decode($denominacion);}
		
		if($prev_conc<>$cod_concepto){	$i=0;
		  if($prev_conc<>""){
		    $monto_emp=0; $ant_emp=0; $var_emp=0;
			if($prev_ada=="A"){$monto_emp=$totala_emp; $ant_emp=$anta_emp;} else{ $monto_emp=$totald_emp; $ant_emp=$antd_emp;}
			$var_emp=$monto_emp-$ant_emp;
			if($var_emp<>0){	$act_conc=$act_conc+$monto_emp;	$ant_conc=$ant_conc+$ant_emp;	 $var_conc=$var_conc+$var_emp;		
		       $monto_emp=formato_monto($monto_emp);  $ant_emp=formato_monto($ant_emp);	$var_emp=formato_monto($var_emp);	
			   $pdf->SetFont('Arial','',8);
			   $pdf->Cell(17,3,$prev_emp,0,0);
			   $pdf->Cell(123,3,$prev_nombre,0,0);	
			   $pdf->Cell(20,3,$monto_emp,0,0,'R');
			   $pdf->Cell(20,3,$ant_emp,0,0,'R');
			   $pdf->Cell(20,3,$var_emp,0,1,'R');
               $can_conc=$can_conc+1;			   
            } 			
		    $totala_emp=0; $totald_emp=0; $anta_emp=0; $antd_emp=0;   $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; 
			if($var_conc<>0){
		    $act_conc=formato_monto($act_conc);  $ant_conc=formato_monto($ant_conc);  $var_conc=formato_monto($var_conc);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(20,2,'',0,0);
			$pdf->Cell(120,2,'',0,0,'R');
			$pdf->Cell(20,2,'--------------------',0,0,'R');
			$pdf->Cell(20,2,'--------------------',0,0,'R');
			$pdf->Cell(20,2,'--------------------',0,1,'R');
			$pdf->Cell(20,4,'Nro.Trab '.$can_conc,0,0);
			$pdf->Cell(120,4,'TOTAL '.$den_conc,0,0);
			$pdf->Cell(20,4,$act_conc,0,0,'R');
			$pdf->Cell(20,4,$ant_conc,0,0,'R');
			$pdf->Cell(20,4,$var_conc,0,1,'R');
            $pdf->Ln(7); 	}		
		  }
		  $prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_ada=$asig_ded_apo;	$can_conc=0; $act_conc=0; $ant_conc=0; $var_conc=0; 
		  $prev_emp=$cod_empleado; $prev_nombre=$nombre;
		}
		
		if($prev_emp<>$cod_empleado){
		    $monto_emp=0; $ant_emp=0; $var_emp=0;
			if($prev_ada=="A"){$monto_emp=$totala_emp; $ant_emp=$anta_emp;} else{ $monto_emp=$totald_emp; $ant_emp=$antd_emp;}
			$var_emp=$monto_emp-$ant_emp;
			if($var_emp<>0){	$act_conc=$act_conc+$monto_emp;	$ant_conc=$ant_conc+$ant_emp;	 $var_conc=$var_conc+$var_emp;	
               if($can_conc==0){  
			     $pdf->SetFont('Arial','B',8);
  			     $pdf->Cell(200,5,$prev_conc." ".$den_conc,0,1,'L');
			   } $can_conc=$can_conc+1;
		       $monto_emp=formato_monto($monto_emp);  $ant_emp=formato_monto($ant_emp);	$var_emp=formato_monto($var_emp);	
			   $pdf->SetFont('Arial','',8);
			   $pdf->Cell(17,3,$prev_emp,0,0);
			   $pdf->Cell(123,3,$prev_nombre,0,0);	
			   $pdf->Cell(20,3,$monto_emp,0,0,'R');
			   $pdf->Cell(20,3,$ant_emp,0,0,'R');
			   $pdf->Cell(20,3,$var_emp,0,1,'R');	
            } 			
		    $totala_emp=0; $totald_emp=0; $anta_emp=0; $antd_emp=0;   $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; 
		    
		}
		if($fecha_p_hasta==$cfechan){$totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion; }	
		if($fecha_p_hasta==$afechan){$anta_emp=$anta_emp+$monto_asignacion; $antd_emp=$antd_emp+$monto_deduccion;	}	
      }
	  if($prev_conc<>""){
	        $monto_emp=0; $ant_emp=0; $var_emp=0;
			if($prev_ada=="A"){$monto_emp=$totala_emp; $ant_emp=$anta_emp;} else{ $monto_emp=$totald_emp; $ant_emp=$antd_emp;}
			$var_emp=$monto_emp-$ant_emp;
			if($var_emp<>0){	$act_conc=$act_conc+$monto_emp;	$ant_conc=$ant_conc+$ant_emp;	 $var_conc=$var_conc+$var_emp;		
		       $monto_emp=formato_monto($monto_emp);  $ant_emp=formato_monto($ant_emp);	$var_emp=formato_monto($var_emp);	
			   $pdf->SetFont('Arial','',8);
			   $pdf->Cell(17,3,$prev_emp,0,0);
			   $pdf->Cell(127,3,$prev_nombre,0,0);	
			   $pdf->Cell(20,3,$monto_emp,0,0,'R');
			   $pdf->Cell(20,3,$ant_emp,0,0,'R');
			   $pdf->Cell(20,3,$var_emp,0,1,'R');
               $can_conc=$can_conc+1;				   
            } 			
		    $totala_emp=0; $totald_emp=0; $anta_emp=0; $antd_emp=0;   $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; 
			if($var_conc<>0){
		    $act_conc=formato_monto($act_conc);  $ant_conc=formato_monto($ant_conc);  $var_conc=formato_monto($var_conc);
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(20,2,'',0,0);
			$pdf->Cell(120,2,'',0,0,'R');
			$pdf->Cell(20,2,'--------------------',0,0,'R');
			$pdf->Cell(20,2,'--------------------',0,0,'R');
			$pdf->Cell(20,2,'--------------------',0,1,'R');
			$pdf->Cell(20,4,'Nro.Trab '.$can_conc,0,0);
			$pdf->Cell(120,4,'TOTAL '.$den_conc,0,0);
			$pdf->Cell(20,4,$act_conc,0,0,'R');
			$pdf->Cell(20,4,$ant_conc,0,0,'R');
			$pdf->Cell(20,4,$var_conc,0,1,'R');  }
	  } 
	  
	  $pdf->Output();    
    }
   
   
}
?>