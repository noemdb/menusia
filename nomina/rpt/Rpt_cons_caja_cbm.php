<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist="N"; $mes_comp="N";
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_rpt="PDF";
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $forma_pago=$_GET["forma_pago"];
   
   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"]; $codigo_cargo_d=$_GET["codigo_cargo_d"];  $codigo_cargo_h=$_GET["codigo_cargo_h"]; 
   $fecha_desde=$_GET["fecha_desde"]; $fecha_nom=$_GET["fecha_hasta"];  $fecha_hasta=$_GET["fecha_hasta"];
   
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a"); $cfechan=formato_aaaammdd($fecha_nom);  $cfechad=formato_aaaammdd($fecha_desde); $cfechah=formato_aaaammdd($fecha_hasta);

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";}
   
   $criterio="rpt_nom_cal WHERE (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') ";  $criterio1="";
   
   $sql="select fecha_p_hasta from nom017 where (fecha_p_hasta='".$cfechan."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') ".$cri_tp;
   $res=pg_query($sql); $filas=pg_num_rows($res); if($filas==0){$act_hist="S";  }   
   
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta>='".$cfechad."') and (fecha_p_hasta<='".$cfechah."')   ";  $mes_comp="S"; $criterio1="FECHA: ".$fecha_desde." AL ".$fecha_hasta; } 
   
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (concepto_vac='N') ";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and (concepto_vac='S') ";}
   
   if($tipo_calculo=='T'){$criterio=$criterio;}else{$criterio=$criterio." and (tp_calculo='".$tipo_calculo."') ";}
   
   $criterio4="CAJA DE AHORRO"; $criterio_concepto="(cod_concepto='505' or cod_concepto='519' or cod_concepto='704')";
   
   $criterio3="";
   if($tipo_nomina_d<>$tipo_nomina_h){ 
	  $sql="SELECT tipo_nomina,descripcion,desc_grupo from nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$criterio3=$registro["desc_grupo"];}
   }

  $sSQL = "SELECT *  FROM ".$criterio."  and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and ".$criterio_concepto."   and
	  (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') ORDER BY tipo_nomina, cod_empleado, cod_concepto";
  
      $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre=""; $prev_cedula="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  	$cedula=$registro["cedula"];		
        if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		$prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula;
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $criterio4; global $mes_comp; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $cod_concepto; global $tipo_nomina_d; global $tipo_nomina_h;  global $denominacion; global $criterio3;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(40);
			$this->Cell(130,7,"RELACION DE CONCEPTOS DETALLE RETENCION/APORTE",1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
			if($tipo_nomina_d==$tipo_nomina_h){	$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');}
			else{$this->Cell(140,5,$criterio3,0,1,'L');}
			if($mes_comp=='S'){ $this->Cell(140,5,$criterio1,0,1,'L');
			}else{$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');}
			//$this->Cell(140,5,$denominacion,0,1,'L');
			$this->Cell(140,5,$criterio4,0,1,'L');	
			$this->Cell(20,3,'Codigo','RLT',0,'L');
			$this->Cell(120,3,'','RT',0,'L');
			$this->Cell(20,3,'Retencion','RT',0,'C');
			$this->Cell(20,3,'Aporte','RT',0,'C');	
            $this->Cell(20,3,'','RT',1,'C');

			
			$this->Cell(20,4,'Trabajador','LB',0,'L');
			$this->Cell(120,4,'Nombre Trabajador','LB',0,'L');
			$this->Cell(20,4,'Trabajador','LB',0,'C');
			$this->Cell(20,4,'Empresa','RLB',0,'C');
            $this->Cell(20,4,'Total','RLB',1,'C');				
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-7);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
	  $pdf->SetAutoPageBreak(true, 7);  
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  //$pdf->MultiCell(200,3,$sSQL,0); 
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_emp=0; $totald_emp=0; $cant_emp=0;  $totala_conc=0; $totald_conc=0;  
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];
		$monto_asignacion=$registro["monto_deduccion"]; $monto_deduccion=$registro["monto_aporte"];
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina); $nombre=utf8_decode($nombre); $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		if(($prev_tipo<>$tipo_nomina)and($mes_comp=='N')){		$total_emp=$totala_emp+$totald_emp;	$total_emp=formato_monto($total_emp);	
		    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,4,$prev_cedula,0,0);
			$pdf->Cell(120,4,$prev_nombre,0,0);	
			$pdf->Cell(20,4,$totala_emp,0,0,'R');
			$pdf->Cell(20,4,$totald_emp,0,0,'R');
            $pdf->Cell(20,4,$total_emp,0,1,'R');				
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $prev_cedula=$cedula; $cant_emp=$cant_emp+1; 
		    
			$total_conc=$totala_conc+$totald_conc;	$total_conc=formato_monto($total_conc);
		    $totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
			$pdf->SetFont('Arial','B',8);
		    $pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'---------------',0,0,'R');
			$pdf->Cell(20,2,'---------------',0,0,'R');
			$pdf->Cell(20,2,'---------------',0,1,'R');
			$pdf->Cell(40,4,'Nro. Trabjadores : '.$cant_emp,0,0);			
			$pdf->Cell(100,4,'TOTAL '.$den_conc,0,0);
			$pdf->Cell(20,4,$totala_conc,0,0,'R');
			$pdf->Cell(20,4,$totald_conc,0,0,'R');
            $pdf->Cell(20,4,$total_conc,0,1,'R');			
			$prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0;  $cant_emp=0;$prev_tipo=$tipo_nomina;
			$pdf->AddPage();
            
		} 
		
		if($prev_emp<>$cod_empleado){	$total_emp=$totala_emp+$totald_emp;	$total_emp=formato_monto($total_emp);	
		   if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,4,$prev_cedula,0,0);
			$pdf->Cell(120,4,$prev_nombre,0,0);	
			$pdf->Cell(20,4,$totala_emp,0,0,'R');
			$pdf->Cell(20,4,$totald_emp,0,0,'R');
            $pdf->Cell(20,4,$total_emp,0,1,'R');				
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula; $cant_emp=$cant_emp+1; 
		}	
		$can_conc=$can_conc+$cantidad; $totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;		
		$totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;		
		
		
      } $total_emp=$totala_emp+$totald_emp;	$total_emp=formato_monto($total_emp);
	    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(20,4,$prev_cedula,0,0);
		$pdf->Cell(120,4,$prev_nombre,0,0);	
		$pdf->Cell(20,4,$totala_emp,0,0,'R');
		$pdf->Cell(20,4,$totald_emp,0,0,'R');
		$pdf->Cell(20,4,$total_emp,0,1,'R');		
		$can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; 
		
		$totala_nom=$totala_nom+$totala_conc; $totald_nom=$totald_nom+$totald_conc;
		$total_conc=$totala_conc+$totald_conc;	$total_conc=formato_monto($total_conc);
		$totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(140,2,'',0,0);
		$pdf->Cell(20,2,'---------------',0,0,'R');
		$pdf->Cell(20,2,'---------------',0,0,'R');
		$pdf->Cell(20,2,'---------------',0,1,'R');
		
		$pdf->Cell(40,4,'Nro. Trabjadores : '.$cant_emp,0,0);			
		if($mes_comp=='S'){ $pdf->Cell(100,4,'TOTAL GENERAL ',0,0); }
		else{ $pdf->Cell(100,4,'TOTAL '.$den_conc,0,0);}
		$pdf->Cell(20,4,$totala_conc,0,0,'R');
		$pdf->Cell(20,4,$totald_conc,0,0,'R');	
		$pdf->Cell(20,4,$total_conc,0,1,'R');

        $y=$pdf->GetY();  $t=10;
        if($y>260){$t=30; $pdf->Cell(5,4,'',0,1);  } 
        $pdf->ln($t); $y=$pdf->GetY();
	    if($y<255){$t=255-$y; $pdf->ln($t);} 
		$pdf->SetFont('Arial','',7);
        $pdf->Cell(60,4,'Elaborado por Analista','T',0,'C');
        $pdf->Cell(10,4,'',0,0);
        $pdf->Cell(60,4,'Revisado por','T',0,'C');
        $pdf->Cell(10,4,'',0,0);
		$pdf->Cell(60,4,'Conformado por ','T',1,'C');
		
        $pdf->Cell(70,3,' ',0,0,'C');
		$pdf->Cell(60,3,'Dir. Recursos Humanos y Capacitacion',0,0,'C');
		$pdf->Cell(10,3,'',0,0,'C');
        $pdf->Cell(60,3,'Dir. Administracion y Presupuesto',0,1,'C');  		 			
	  $pdf->Output();   
    
}
?>
