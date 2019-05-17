<?  include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"];
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $mes_comp=$_GET["mes_comp"]; $tipo_rpt=$_GET["tipo_rpt"];   $php_os=PHP_OS;
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"];
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a"); $cfechan=formato_aaaammdd($fecha_nom);  
   
   $criterio="rpt_nom_cal WHERE (oculto='SI') "; $criterio1="Fecha:"; $fecha_nom_d="";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='SI') ";
     if($mes_comp=='S'){ $fecha_d=$fecha_nom; $fecha_d=colocar_pdiames($fecha_d); $dfechan=formato_aaaammdd($fecha_d); $criterio="rpt_nom_hist WHERE (fecha_p_desde>='".$dfechan."') and (fecha_p_hasta<='".$cfechan."')  and (oculto='SI') ";  
	  $criterio1="FECHA: ".$fecha_d." AL ".$fecha_nom; $fecha_nom_d=$fecha_d; }    
   }else{$mes_comp="N";}  
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{    $php_os=PHP_OS;  $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
   $sSQL = "SELECT *  FROM ".$criterio." and (tp_calculo='".$tipo_calculo."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
		  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_concepto>='".$cod_conceptod."' AND cod_concepto<='".$cod_conceptoh."')  ORDER BY tipo_nomina, cod_concepto, cod_empleado";

  if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php"); 
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML("Rpt_deta_concep_apor_rn_re.xml");
	  $oRpt->setUser("$user");
	  $oRpt->setPassword("$password");
	  $oRpt->setConnection("localhost");
	  $oRpt->setDatabaseInterface("postgresql");
	  $oRpt->setSQL($sSQL);
	  $oRpt->setDatabase("$dbname");
	  $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"mes_comp"=>$mes_comp,"date"=>$date,"hora"=>$hora));
	  $oRpt->run();
	  $aBench = $oRpt->getBenchmark();
  }
  if($tipo_rpt=="PDF"){	 $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; 
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		$prev_conc=$cod_concepto; $den_conc=$denominacion;	$prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; 
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $mes_comp; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $cod_concepto; global $denominacion;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(120,7,"RELACION DE CONCEPTOS DETALLE(APORTES)",1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',8);
			$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');
			if($mes_comp=='S'){ $this->Cell(140,5,$criterio1,0,1,'L'); }
			else{$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');}
			$this->SetFont('Arial','B',7);
			$this->Cell(20,5,'Cod. Trabajador',1,0);
			$this->Cell(145,5,'Nombre Trabajador',1,0,'L');
			$this->Cell(15,5,'Cedula',1,0,'C');
			$this->Cell(20,5,'Aporte',1,1,'R');
			$this->Cell(140,5,$cod_concepto." ".$denominacion,0,1,'L');
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
	  $pdf->SetFont('Arial','',7);
	  $i=0; $can_conc=0; $total_aporte=0; $cant_emp=0;   
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_aporte=$registro["monto_aporte"]; 
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina); $nombre=utf8_decode($nombre);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		if(($prev_conc<>$cod_concepto)or($prev_tipo<>$tipo_nomina)){$total_aporte=formato_monto($total_aporte); 
			$pdf->SetFont('Arial','B',7);
		    $pdf->Cell(180,2,'',0,0);
			$pdf->Cell(20,2,'-----------------------',0,1,'R');
			$pdf->Cell(40,3,'Nro. Trabjadores : '.$cant_emp,0,0);			
			$pdf->Cell(140,3,'TOTAL '.$den_conc,0,0,'R');
			$pdf->Cell(20,3,$total_aporte,0,0,'R');			
			$prev_conc=$cod_concepto; $den_conc=$denominacion; $total_aporte=0;  $cant_emp=0;$prev_tipo=$tipo_nomina;
			$pdf->AddPage();            
		} 
           $pdf->SetFont('Arial','',7);
		   $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $monto_aporte=$registro["monto_aporte"]; 
		   $total_aporte=$total_aporte+$monto_aporte; $cant_emp=$cant_emp+1;  
		   if($php_os=="WINNT"){$nombre=$nombre; }else{$nombre=utf8_decode($nombre);}
		   
		   $pdf->Cell(20,3,$cod_empleado,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=145; 		   
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(15,3,$cedula,0,0,'C'); 
		   $pdf->Cell(20,3,$monto_aporte,0,1,'R');
           $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$nombre,0);
		} 
		$total_aporte=formato_monto($total_aporte); 
		$pdf->SetFont('Arial','B',7);
		$pdf->Cell(180,2,'',0,0);
		$pdf->Cell(20,2,'-----------------------',0,1,'R');
		$pdf->Cell(40,3,'Nro. Trabjadores : '.$cant_emp,0,0);			
		$pdf->Cell(140,3,'TOTAL '.$den_conc,0,0);
		$pdf->Cell(20,3,$total_aporte,0,0,'R');	
	    $pdf->Output();   
    }
    if($tipo_rpt=="EXCEL"){	 $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  $prev_conc=$cod_concepto; $den_conc=$denominacion;			
        $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; 
	  }	  
	      header("Content-type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=Relacion_Conceptos_Detalle_Aportes.xls"); 	
		?>

	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RELACION DE CONCEPTOS DETALLE(APORTES)</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		    	<td width="100" align="left" ><strong>Nomina: </strong></td>
		    	<td width="400" align="left" ><strong><? echo $tipo_nomina."    ".$des_nomina; ?></strong></td>
		 </tr>
		        <tr height="20">
		    	<td width="100" align="left" ><strong>Fecha: </strong></td>
				<?if($mes_comp=='S'){ ?>
		    	<td width="400" align="left" ><strong><? echo $fecha_nom_d."  "." Al   ".$fecha_nom; ?></strong></td>
				<?}else{ ?>
				<td width="400" align="left" ><strong><? echo $fechad."  "." Al   ".$fechah; ?></strong></td>
				
				<?} ?>
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"><strong>Codigo Trabajador</strong></td>
		   <td width="400" align="left"><strong>Nombre Trabajador</strong></td>
		   <td width="100" align="center"><strong>Cedula</strong></td>
		   <td width="100" align="right"><strong>Aporte</strong></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"><strong><? echo $cod_concepto; ?></strong></td>
		   <td width="400" align="left"><strong><? echo $denominacion; ?></strong></td>
		 </tr>
		<?  $can_conc=0; $total_aporte=0; $cant_emp=0;    $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	       $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
           $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		   $des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		   $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_aporte=$registro["monto_aporte"];
		   if(($prev_conc<>$cod_concepto)or($prev_tipo<>$tipo_nomina)){$total_aporte=formato_monto($total_aporte); 
                     ?>
                    <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="100" align="right"></td>
					  <td width="100" align="right">-----------------</td>
				    </tr>	
				    <tr>
				      <td width="100" align="left"><? echo "Nro. Trabjadores : ".$cant_emp; ?></td>
					  <td width="400" align="right"><? echo "TOTAL  : ".$den_conc; ?></td>
					  <td width="100" align="left"></td>
					  <td width="100" align="right"><? echo $total_aporte; ?></td> 
				    </tr>	
				    <tr>
				      <td width="90" align="left"></td>
				    </tr>
		 		    <tr height="20">
		                <td width="100" align="left"><strong><? echo $cod_concepto; ?></strong></td>
		                 <td width="400" align="left"><strong><? echo $denominacion; ?></strong></td>
		            </tr>
				<?	$prev_conc=$cod_concepto; $den_conc=$denominacion; $total_aporte=0;  $cant_emp=0;$prev_tipo=$tipo_nomina;          
		} 
			$cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $monto_aporte=$registro["monto_aporte"]; 
			$total_aporte=$total_aporte+$monto_aporte; $cant_emp=$cant_emp+1;  

		    ?>	   
			<tr>
			   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo $cod_empleado; ?></td>
			   <td width="400" align="justify"><? echo $nombre; ?></td>				   
			   <td width="100" align="center"><? echo $cedula; ?></td>
			   <td width="100" align="right"><? echo $monto_aporte; ?></td>
			 </tr>
		    <? 		  
		  }$total_aporte=formato_monto($total_aporte);  ?>
                    <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="100" align="right"></td>
					  <td width="100" align="right">-----------------</td>
				    </tr>	
				    <tr>
				       <td width="100" align="left"><? echo "Nro. Trabjadores : ".$cant_emp; ?></td>
					  <td width="400" align="right"><? echo "TOTAL  : ".$den_conc; ?></td>
					  <td width="100" align="left"></td>
					  <td width="100" align="right"><? echo $total_aporte; ?></td> 
				    </tr>	
				    <tr>
				      <td width="90" align="left"></td>
				    </tr>
				<?
		  ?></table><?
	}	
}	
?>
