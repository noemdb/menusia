<?include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);

   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"];  $cod_conceptod=$_GET["cod_concepto_d"]; $cod_conceptoh=$_GET["cod_concepto_h"];   
   $forma_pago=$_GET["forma_pago"]; $tipo_calculo=$_GET["tipo_calculo"];   $cod_empleado_d=$_GET["cod_empleado_d"]; $cod_empleado_h=$_GET["cod_empleado_h"];   
   $cod_presup_catd=$_GET["cod_presup_catd"];  $cod_presup_cath=$_GET["cod_presup_cath"];  $codigo_cargo_d=$_GET["codigo_cargo_d"];  $codigo_cargo_h=$_GET["codigo_cargo_h"]; 
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"];  $fecha_desde=$_GET["fecha_desde"];    $fecha_hasta=$_GET["fecha_hasta"];    
   $codigo_rpt=$_GET["codigo_rpt"];   $Sql=""; $date=date("d-m-Y"); $hora=date("h:i:s a"); $mes_comp="S";
   $cfechan=formato_aaaammdd($fecha_hasta);      $php_os=PHP_OS;
   $dfechan=formato_aaaammdd($fecha_desde); $hfechan=formato_aaaammdd($fecha_hasta);
   $cod_concepto_r="500"; $cod_concepto_a="700";
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
   $criterio="rpt_nom_cal WHERE (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and ";   $criterio1=""; $criterio2=""; $criterio3=""; $criterio4="";
   if($tipo_calculo=="T"){ $cri_tp=" and ((tp_calculo='N')or(tp_calculo='E'))  "; } else { $cri_tp=" and (tp_calculo='".$tipo_calculo."') "; }
   $sql="select fecha_p_hasta from nom017 where (fecha_p_hasta='".$cfechan."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') ".$cri_tp;
   $res=pg_query($sql); $filas=pg_num_rows($res); if($filas==0){$act_hist="S";  } 
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta>='".$dfechan."') and (fecha_p_hasta<='".$hfechan."') and ";  $mes_comp="S"; $criterio1="FECHA: ".$fecha_desde." AL ".$fecha_hasta;   } 
    $ordenar="  order by tipo_nomina, cod_empleado, cod_concepto";
   $ordenar="  order by cod_departam, cod_concepto, cod_empleado";   
   $criterio1="Fecha: ".$fecha_desde." al ".$fecha_hasta;   
   //$criterio4="Codigo Concepto Retencion: ".$cod_concepto_r."     "."Codigo Concepto Aporte: ".$cod_concepto_a;   
   $criterio4="RELACION RETENCION/APORTE SEGURO SOCIAL OBLIGATORIO POR DEPARTAMENTO"; $criterio_concepto="(cod_concepto='500' or cod_concepto='515' or cod_concepto='700')";
      
  // if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." (status_emp='".$estatus_trab_d."') and ";}   
   if($tipo_calculo=="T"){ $criterio=$criterio." ((tp_calculo='N')or(tp_calculo='E')) and "; } else { $criterio=$criterio." (tp_calculo='".$tipo_calculo."') and "; }
   if($forma_pago=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio."  (tipo_pago='".$forma_pago."') and ";}
   $criterio=$criterio." (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and (cod_empleado>='".$cod_empleado_d."' and cod_empleado<='".$cod_empleado_h."') and
		  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_cargo>='".$codigo_cargo_d."' and cod_cargo<='".$codigo_cargo_h."') 
		  and ".$criterio_concepto." ";
   
   $criterio3="";
   if($tipo_nomina_d<>$tipo_nomina_h){ 
	  $sql="SELECT tipo_nomina,descripcion,desc_grupo from nom001 where tipo_nomina='$tipo_nomina_d'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$criterio3=$registro["desc_grupo"];}
   }
   $Sql = "SELECT count(distinct cod_empleado) as cant_trab  FROM ".$criterio;
   $res=pg_query($Sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res,0); $criterio2=$registro["cant_trab"];  }	
   $sSQL = "SELECT *  FROM ".$criterio.$ordenar;  
   
  
      $res=pg_query($sSQL); $filas=pg_num_rows($res); $tipo_nomina_grupo=""; $cod_empleado_grupo=""; $cod_departam_grupo="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"]; $fechapd=$registro["fechapd"]; $fechaph=$registro["fechaph"]; $denominacion=$registro["denominacion"]; $cod_concepto=$registro["cod_concepto"];
	   if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $denominacion=utf8_decode($denominacion);} 	}	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $criterio3; global $tipo_nomina_grupo; global $cod_empleado_grupo; global $cod_departam_grupo; global $tipo_nomina;  global $criterio4; global $des_nomina; global $fechapd; global $fechaph; global $descripcion; global $tipo_nomina_d; global $tipo_nomina_h;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(30);
			$this->Cell(150,7,$criterio4,0,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',9);
			if($tipo_nomina_d==$tipo_nomina_h){	$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');}
			else{$this->Cell(140,5,$criterio3,0,1,'L');}
			$this->Cell(200,5,$criterio1,0,1,'L');
			$this->Cell(200,5,$criterio4,0,1,'L');
			$this->SetFont('Arial','B',8);
			$this->Cell(21,3,'Codigo','RLT',0,'L');
			$this->Cell(99,3,'','RT',0,'L');
			$this->Cell(20,3,'Cantidad','RT',0,'C');
			$this->Cell(20,3,'Retencion','RT',0,'C');
			$this->Cell(20,3,'Aporte','RT',0,'C');
			$this->Cell(20,3,'','RT',1,'R');
			
			$this->Cell(21,4,'Departamento','LB',0,'L');
			$this->Cell(99,4,'Denominacion','LB',0,'L');
			$this->Cell(20,4,'Trabajadores','LB',0,'C');
			$this->Cell(20,4,'Trabajador','LB',0,'C');
			$this->Cell(20,4,'Empresa','LB',0,'C');
			$this->Cell(20,4,'Total','RLB',1,'C');
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
	  $pdf->SetAutoPageBreak(true, 7);
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  $i=0; $cantidad=0; $total_cantidad=0; $sub_total_monto_deduccion=0;  $total_monto_deduccion=0; $sub_total_monto_aporte=0; $total_monto_aporte=0; $sub_total=0; $sub_total=0; $total=0;
	  $prev_cod_departam=""; $prev_des_departam="";  $prev_tipo_nomina=""; $prev_cod_empleado="";   
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"]; $denominacion=$registro["denominacion"]; $cod_concepto=$registro["cod_concepto"];
	      $fechapd=$registro["fechapd"]; $fechaph=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
          $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $monto_deduccion=$registro["monto_deduccion"]; $monto_aporte=$registro["monto_aporte"]; 
		  if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina); $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);} 	
          $cod_departam_grupo=$cod_departam; $des_departam_grupo=$des_departam; $tipo_nomina_grupo=$tipo_nomina; $des_nomina_grupo=$des_nomina; $denominacion_grupo=$denominacion; 
          $cod_empleado_grupo=$cod_empleado; $nombre_grupo=$nombre; $cedula_grupo=$cedula;

		  if($prev_cod_departam<>$cod_departam_grupo){
			     if(($sub_total_monto_deduccion>0)or($sub_total_monto_aporte>0)or($sub_total>0)){ $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto_aporte=formato_monto($sub_total_monto_aporte); $sub_total=formato_monto($sub_total);
					$pdf->SetFont('Arial','',8);
		   			$pdf->Cell(20,3,$prev_cod_departam,0,0); 		   
		   			$x=$pdf->GetX();   $y=$pdf->GetY(); $n=100; 		   
		   			$pdf->SetXY($x+$n,$y);
		   			$pdf->Cell(20,3,$total_cantidad,0,0,'C');
					$pdf->Cell(20,3,$sub_total_monto_deduccion,0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto_aporte,0,0,'R');
					$pdf->Cell(20,3,$sub_total,0,1,'R');
                   	$pdf->SetXY($x,$y);
		   			$pdf->MultiCell($n,3,$prev_des_departam,0);}
		  $prev_cod_departam=$cod_departam_grupo; $prev_des_departam=$des_departam_grupo; $sub_total_monto_deduccion=0; $sub_total_monto_aporte=0; $sub_total=0; $total_cantidad=0; $prev_cod_empleado=""; }
          $monto_deduccion=$registro["monto_deduccion"]; $monto_aporte=$registro["monto_aporte"];
          $sub_total_monto_deduccion=$sub_total_monto_deduccion+$monto_deduccion; $sub_total_monto_aporte=$sub_total_monto_aporte+$monto_aporte; 
          $sub_total=$sub_total+$monto_deduccion+$monto_aporte; 
		  $total_monto_deduccion=$total_monto_deduccion+$monto_deduccion; $total_monto_aporte=$total_monto_aporte+$monto_aporte;
          $total=$total+$monto_deduccion+$monto_aporte; 
          $monto_deduccion=formato_monto($monto_deduccion);  $monto_aporte=formato_monto($monto_aporte); 
		  if(($prev_cod_empleado<>$cod_empleado)and($cod_concepto_a==$cod_concepto)){ $total_cantidad=$total_cantidad+1; $prev_cod_empleado=$cod_empleado;    }
		} $total_monto_deduccion=formato_monto($total_monto_deduccion); $total_monto_aporte=formato_monto($total_monto_aporte); $total=formato_monto($total);
		if(($sub_total_monto_deduccion>0)or($sub_total_monto_aporte>0)){ $sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto_aporte=formato_monto($sub_total_monto_aporte);
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(20,3,$prev_cod_departam,0,0); 		   
			$x=$pdf->GetX();   $y=$pdf->GetY(); $n=100; 		   
			$pdf->SetXY($x+$n,$y);
			$pdf->Cell(20,3,$total_cantidad,0,0,'C');
			$pdf->Cell(20,3,$sub_total_monto_deduccion,0,0,'R');
			$pdf->Cell(20,3,$sub_total_monto_aporte,0,0,'R');
			$pdf->Cell(20,3,$sub_total,0,1,'R');
			$pdf->SetXY($x,$y);
			$pdf->MultiCell($n,3,$prev_des_departam,0);}
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(140,2,'',0,0);
		$pdf->Cell(20,2,'----------------',0,0,'R');
		$pdf->Cell(20,2,'----------------',0,0,'R');
		$pdf->Cell(20,2,'----------------',0,1,'R');
		$pdf->Cell(40,3,'Nro. Trabjadores : '.$criterio2,0,0,'L');			
		$pdf->Cell(100,3,'TOTAL GENERAL:',0,0,'R');
		$pdf->Cell(20,3,$total_monto_deduccion,0,0,'R');
		$pdf->Cell(20,3,$total_monto_aporte,0,0,'R');	
		$pdf->Cell(20,3,$total,0,1,'R');

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
