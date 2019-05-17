<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;   error_reporting(E_ALL ^ E_NOTICE);
   $tipo_nomina_d=$_GET["tipo_nomina_d"]; $tipo_nomina_h=$_GET["tipo_nomina_h"]; $act_hist=$_GET["act_hist"]; $fecha_nom=$_GET["fecha_nom"];
   $cod_conceptod=$_GET["cod_conceptod"]; $cod_conceptoh=$_GET["cod_conceptoh"]; $tipo_concepto=$_GET["tipo_concepto"]; $tipo_rpt=$_GET["tipo_rpt"];
   $cod_departd=$_GET["cod_departd"];  $cod_departh=$_GET["cod_departh"]; $estatus_trab_d=$_GET["estatus_trab_d"]; $tipo_calculo=$_GET["tipo_calculo"]; $tipo_monto=$_GET["tipo_monto"];
   $Sql="";$date = date("d-m-Y"); $hora = date("h:i:s a"); $cfechan=formato_aaaammdd($fecha_nom);  
   
   $criterio="rpt_nom_cal WHERE (oculto='NO') ";
   if($act_hist=='S'){$criterio="rpt_nom_hist WHERE (fecha_p_hasta='".$cfechan."') and (oculto='NO') ";} 
   if($estatus_trab_d=='TODOS'){$criterio=$criterio;}else{$criterio=$criterio." and (status_emp='".$estatus_trab_d."') ";}
   if($tipo_concepto=="NOMINA"){$criterio=$criterio." and (concepto_vac='N') ";}
   if($tipo_concepto=="VACACIONES"){$criterio=$criterio." and (concepto_vac='S') ";}
   
   $criterio1="RELACION DE CONCEPTOS DETALLES";
   if($tipo_monto=="PRI"){ $criterio1=$criterio1." PRIMERA QUINCENA";} if($tipo_monto=="SEG"){ $criterio1=$criterio1." SEGUNDA QUINCENA";}
   
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";}
  $sSQL = "SELECT *  FROM ".$criterio." and (tp_calculo='".$tipo_calculo."') and (tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."') and
	  (cod_departam>='".$cod_departd."' and cod_departam<='".$cod_departh."') and (cod_concepto>='".$cod_conceptod."' AND cod_concepto<='".$cod_conceptoh."')  ORDER BY tipo_nomina, cod_concepto, cod_empleado";
  if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML("Rpt_deta_concep_rn_re.xml");
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
  if($tipo_rpt=="PDF"){	 $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"]; $cedula=$registro["cedula"]; 			
        if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		$prev_conc=$cod_concepto; $den_conc=$denominacion; $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre;
        $prev_cedula=$cedula;		
	  }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tipo_nomina; global $des_nomina; global $fechad; global $fechah; global $cod_concepto; global $denominacion; global $cedula;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(150,7,$criterio1,1,0,'C');
			$this->Ln(17);
			$this->SetFont('Arial','B',8);
			$this->Cell(140,5,"NOMINA : ".$tipo_nomina." ".$des_nomina,0,1,'L');
			$this->Cell(140,5,"FECHA : ".$fechad." AL ".$fechah,0,1,'L');
			$this->Cell(17,5,'Codigo',1,0);
			$this->Cell(130,5,'Nombre Trabajador',1,0,'L');
			$this->Cell(13,5,'Cedula',1,0,'C');
			$this->Cell(20,5,'Asignaciones',1,0);
			$this->Cell(20,5,'Deducciones',1,1);
			$this->Cell(200,5,$cod_concepto." ".$denominacion,0,1,'L');
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
	  $i=0; $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_emp=0; $totald_emp=0; $cant_emp=0;  $totala_conc=0; $totald_conc=0;  
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $tnomina=$registro["tipo_nomina"]; $cconcepto=$registro["cod_concepto"]; 
	    if(($prev_conc<>$cconcepto)or($prev_tipo<>$tnomina)){		
		    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(17,3,$prev_emp,0,0);
			$pdf->Cell(131,3,$prev_nombre,0,0);			
			$pdf->Cell(12,3,$prev_cedula,0,0,'L');
			$pdf->Cell(20,3,$totala_emp,0,0,'R');
			$pdf->Cell(20,3,$totald_emp,0,1,'R');			
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; $prev_cedula=$cedula;		    
		    $totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
			$pdf->SetFont('Arial','B',8);
		    $pdf->Cell(148,2,'',0,0);
			$pdf->Cell(12,2,'',0,0,'R');
			$pdf->Cell(20,2,'--------------------',0,0,'R');
			$pdf->Cell(20,2,'--------------------',0,1,'R');
			$pdf->Cell(60,4,'Nro. Trabjadores : '.$cant_emp,0,0);			
			$pdf->Cell(100,4,'TOTAL '.$den_conc,0,0);
			$pdf->Cell(20,4,$totala_conc,0,0,'R');
			$pdf->Cell(20,4,$totald_conc,0,0,'R');			
			$pdf->AddPage();
			$denominacion=$registro["denominacion"]; if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion);}
			$prev_conc=$cconcepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0;  $cant_emp=0;$prev_tipo=$tnomina; $prev_cedula=$cedula;
			
		} 		
		 $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	    $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
        $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		$des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
		$valorz=$registro["valorz"]; $monto=$registro["monto"]; $asig_ded_apo=$registro["asig_ded_apo"];
		if($tipo_monto=="PRI"){  $monto_asignacion=0; $monto_deduccion=0; if($asig_ded_apo=="A"){$monto_asignacion=$valorz;} if($asig_ded_apo=="D"){$monto_deduccion=$valorz;} }
		if($tipo_monto=="SEG"){  $monto_asignacion=0; $monto_deduccion=0; if($asig_ded_apo=="A"){$monto_asignacion=$monto-$valorz;} if($asig_ded_apo=="D"){$monto_deduccion=$monto-$valorz;} }
		if($php_os=="WINNT"){$des_nomina=$des_nomina; }else{$des_nomina=utf8_decode($des_nomina);  $des_departam=utf8_decode($des_departam); $denominacion=utf8_decode($denominacion);}
		
		if($prev_emp<>$cod_empleado){		
		   if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
			$pdf->SetFont('Arial','',8);
			$pdf->Cell(17,3,$prev_emp,0,0);
			$pdf->Cell(131,3,$prev_nombre,0,0);			
			$pdf->Cell(12,3,$prev_cedula,0,0,'L');
			$pdf->Cell(20,3,$totala_emp,0,0,'R');
			$pdf->Cell(20,3,$totald_emp,0,1,'R');			
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $cant_emp=$cant_emp+1; $prev_cedula=$cedula;			
		}	
		$can_conc=$can_conc+$cantidad; $totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;		
		$totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;		
		
		
      } if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(17,3,$prev_emp,0,0);
		$pdf->Cell(131,3,$prev_nombre,0,0);			
		$pdf->Cell(12,3,$prev_cedula,0,0,'L');
		$pdf->Cell(20,3,$totala_emp,0,0,'R');
		$pdf->Cell(20,3,$totald_emp,0,1,'R');			
		$can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; $prev_cedula=$cedula;
		
		$totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(148,2,'',0,0);
		$pdf->Cell(12,2,'',0,0,'R');
		$pdf->Cell(20,2,'--------------------',0,0,'R');
		$pdf->Cell(20,2,'--------------------',0,1,'R');
		$pdf->Cell(60,4,'Nro. Trabjadores : '.$cant_emp,0,0);			
		$pdf->Cell(100,4,'TOTAL '.$den_conc,0,0);
		$pdf->Cell(20,4,$totala_conc,0,0,'R');
		$pdf->Cell(20,4,$totald_conc,0,0,'R');	
		
		//para las firmas en la ultima pagina
            $pdf->Ln(10);
			$x=$pdf->GetX();   $y=$pdf->GetY(); if($y<235){$y=235;   $pdf->SetXY($x,$y);}  
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(10,5,'',0,0);
			$pdf->Cell(45,5,'Elaborado Por:',1,0,'C');
			$pdf->Cell(45,5,'Revisado Por:',1,0,'C');
			$pdf->Cell(45,5,'Conformidad Presupuestaria',1,0,'C');
			$pdf->Cell(45,5,'Aprobado Por:',1,0,'C');
			$pdf->Cell(10,5,'',0,1);			
			$pdf->Cell(10,10,'',0,0);
			$pdf->Cell(45,10,'',1,0,'C');
			$pdf->Cell(45,10,'',1,0,'C');
			$pdf->Cell(45,10,'',1,0,'C');
			$pdf->Cell(45,10,'',1,0,'C');
			$pdf->Cell(10,10,'',0,1);			
			$pdf->Cell(10,5,'',0,0);
			$pdf->Cell(45,5,'Analista de Nomina',1,0,'C');
			$pdf->Cell(45,5,'Coordinacion de Nomina',1,0,'C');
			$pdf->Cell(45,5,'Coordinacion  Administrativa',1,0,'C');
			$pdf->Cell(45,5,'Directora de Recursos Humanos',1,0,'C');
			$pdf->Cell(10,5,'',0,1);
		
	  $pdf->Output();   
    }
	if($tipo_rpt=="EXCEL"){	 $res=pg_query($sSQL); $prev_tipo=""; $prev_den_nom=""; $prev_dep=""; $prev_den_dep=""; $filas=pg_num_rows($res);
      $cod_empleado=""; $tipo_nomina=""; $des_nomina=""; $prev_conc=""; $den_conc=""; $prev_emp=""; $prev_nombre="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $cod_empleado=$registro["cod_empleado"];  $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];	   
        $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"];  $nombre=$registro["nombre"];
		$cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];  $prev_conc=$cod_concepto; $den_conc=$denominacion;			
        $prev_tipo=$tipo_nomina; $prev_den_nom=$des_nomina; $prev_dep=$cod_departam;  $prev_den_dep=$des_departam; $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $prev_cedula=$cedula;
	  }	  
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Relacion_Conceptos_Detalle.xls"); 	
	  ?>
	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RELACION DE CONCEPTOS DETALLES</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong>Nomina: </strong></td>
		    <td width="400" align="left" ><strong><? echo $tipo_nomina."    ".$des_nomina; ?></strong></td>
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong>Fecha: </strong></td>
		    <td width="400" align="left" ><strong><? echo $fechad."  "." Al   ".$fechah; ?></strong></td>
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"><strong>Codigo</strong></td>
		   <td width="400" align="left"><strong>Nombre Trabajador</strong></td>
		   <td width="100" align="right"><strong>Cedula</strong></td>
		   <td width="100" align="right"><strong>Asignaciones</strong></td>
		   <td width="100" align="right"><strong>Deducciones</strong></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"><strong><? echo $cod_concepto; ?></strong></td>
		   <td width="400" align="left"><strong><? echo $denominacion; ?></strong></td>
		 </tr>
		<?  $can_conc=0; $totala_nom=0; $totald_nom=0; $cant_nom=0;	$totala_emp=0; $totald_emp=0; $cant_emp=0;  $totala_conc=0; $totald_conc=0;   $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $tipo_nomina=$registro["tipo_nomina"]; $des_nomina=$registro["des_nomina"];
	      $fechad=$registro["fechapd"]; $fechah=$registro["fechaph"]; $cod_departam=$registro["cod_departam"]; $des_departam=$registro["des_departam"]; 
          $cod_empleado=$registro["cod_empleado"]; $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fechai=$registro["fechai"]; 
		  $des_cargo=$registro["des_cargo"]; $sueldoc=$registro["sueldo_cargo"]; $cantidad=$registro["cantidad"];
		  $cod_concepto=$registro["cod_concepto"]; $denominacion=$registro["denominacion"];$monto_asignacion=$registro["monto_asignacion"]; $monto_deduccion=$registro["monto_deduccion"];
          if(($prev_conc<>$cod_concepto)or($prev_tipo<>$tipo_nomina)){		
		    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
				?>
		 		    <tr height="20">
		   			   <td width="100" align="left"><strong><? echo $cod_concepto; ?></strong></td>
		   			   <td width="400" align="left"><strong><? echo $denominacion; ?></strong></td>
		 		    </tr>				 
                    <tr>
					  <td width="100" align="left"><? echo $prev_emp; ?></td>
					  <td width="400" align="left"><? echo $prev_nombre; ?></td>				 
					  <td width="100" align="center"><? echo $prev_cedula; ?></td>
					  <td width="100" align="right"><? echo $totala_emp; ?></td>
					  <td width="100" align="right"><? echo $totald_emp; ?></td>
				    </tr>
                <?			
		    $can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; 
		    $totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc); ?>
                   <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="100" align="right"></td>
					  <td width="100" align="right">-----------------</td>
					  <td width="100" align="right">-----------------</td>
				    </tr>	
				    <tr>
				      <td width="100" align="left"><? echo "Nro. Trabjadores : ".$cant_emp; ?></td>
					  <td width="400" align="right"><? echo "TOTAL  : ".$den_conc; ?></td>
					  <td width="100" align="left"></td>
					  <td width="100" align="right"><? echo $totala_conc; ?></td>
					  <td width="100" align="right"><? echo $totald_conc; ?></td> 
				    </tr>	
				    <tr>
				      <td width="90" align="left"></td>
				    </tr>
				<?		
			$prev_conc=$cod_concepto; $den_conc=$denominacion;	$totala_conc=0; $totald_conc=0;  $cant_emp=0;$prev_tipo=$tipo_nomina;
		} 
		if($prev_emp<>$cod_empleado){		
		    if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
			if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}?>	 				 
			<tr>
			  <td width="100" align="left"><? echo $prev_emp; ?></td>
			  <td width="400" align="left"><? echo $prev_nombre; ?></td>				 
			  <td width="100" align="center"><? echo $prev_cedula; ?></td>
			  <td width="100" align="right"><? echo $totala_emp; ?></td>
			  <td width="100" align="right"><? echo $totald_emp; ?></td>
			</tr>
           <?$can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado;  $prev_nombre=$nombre; $cant_emp=$cant_emp+1; 
		}	
		$can_conc=$can_conc+$cantidad; $totala_emp=$totala_emp+$monto_asignacion; $totald_emp=$totald_emp+$monto_deduccion;		
		$totala_conc=$totala_conc+$monto_asignacion; $totald_conc=$totald_conc+$monto_deduccion;

      } if($totala_emp==0){$totala_emp="";}else{$totala_emp=formato_monto($totala_emp);} 
		if($totald_emp==0){$totald_emp="";}else{$totald_emp=formato_monto($totald_emp);}			
		?>	 				 
         <tr>
		  <td width="100" align="left"><? echo $prev_emp; ?></td>
		  <td width="400" align="left"><? echo $prev_nombre; ?></td>				 
		  <td width="100" align="center"><? echo $prev_cedula; ?></td>
		  <td width="100" align="right"><? echo $totala_emp; ?></td>
		  <td width="100" align="right"><? echo $totald_emp; ?></td>
		</tr>
		<?				
		$can_conc=0;  $totala_emp=0; $totald_emp=0;  $prev_emp=$cod_empleado; $prev_nombre=$nombre;  $cant_emp=$cant_emp+1; 		
		$totala_conc=formato_monto($totala_conc); $totald_conc=formato_monto($totald_conc);
        ?>
		<tr>
		  <td width="100" align="left"></td>
		  <td width="400" align="left"></td>
		  <td width="100" align="right"></td>
		  <td width="100" align="right">-----------------</td>
		  <td width="100" align="right">-----------------</td>
		</tr>	
		<tr>
			 <td width="100" align="left"><? echo "Nro. Trabjadores : ".$cant_emp; ?></td>
		  <td width="400" align="right"><? echo "TOTAL  : ".$den_conc; ?></td>
		  <td width="100" align="left"></td>
		  <td width="100" align="right"><? echo $totala_conc; ?></td>
		  <td width="100" align="right"><? echo $totald_conc; ?></td> 
		</tr>	
		<tr>
		  <td width="90" align="left"></td>
		</tr>
		</table><?
	}
}
?>
