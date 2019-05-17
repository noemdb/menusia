<? include ("../../class/seguridad.inc"); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); include ("../../class/phpreports/PHPReportMaker.php");
   $tipo_nomina_d=$_GET["tipo_nomina_d"];  $tipo_nomina_h=$_GET["tipo_nomina_h"];  $cod_conceptod=$_GET["cod_conceptod"];   $cod_conceptoh=$_GET["cod_conceptoh"]; $agrup=$_GET["agrup"]; 
   $fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];   $cod_empleado_d=$_GET["cod_empleado_d"];   $cod_empleado_h=$_GET["cod_empleado_h"]; $tipo_rpt=$_GET["tipo_rpt"];   $php_os=PHP_OS; 
   $Sql="";   $date = date("d-m-Y");   $hora = date("H:i:s a");
    if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
    if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}  else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_errorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else { $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} $criterio3="";
    $orden=" ORDER BY nom018.tipo_nomina, nom018.cod_empleado, nom018.cod_concepto, nom018.fecha_nomina ";
	if($agrup<>"S"){ $orden=" ORDER BY  nom018.cod_empleado, nom018.fecha_nomina, nom018.tipo_nomina, nom018.cod_concepto "; }
    $sSQL = "SELECT nom018.tipo_nomina, nom001.descripcion, nom018.cod_empleado, nom018.nombre_empleado, nom018.cod_concepto, nom018.des_concepto, nom018.fecha_nomina, nom018.monto, nom018.asig_ded_apo,
               nom018.tipo_asigna, nom018.Monto_Diario, to_char(nom018.fecha_nomina,'DD/MM/YYYY') as fechan, nom006.fecha_ingreso, to_char(nom006.fecha_ingreso,'DD/MM/YYYY') as fechai FROM  (nom018 left join nom006 on (nom018.cod_empleado=nom006.cod_empleado)), nom001 WHERE nom001.tipo_nomina = nom018.tipo_nomina  AND
               nom001.tipo_nomina>= '".$tipo_nomina_d."' AND nom001.tipo_nomina <= '".$tipo_nomina_h."' AND  nom018.cod_concepto>='".$cod_conceptod."' AND nom018.cod_concepto<='".$cod_conceptoh."' AND
               nom018.fecha_nomina>='".$fecha_desde."' AND nom018.fecha_nomina<='".$fecha_hasta."' AND nom018.cod_empleado>='".$cod_empleado_d."' AND nom018.cod_empleado<='".$cod_empleado_h."' ".$orden;
    
	if($tipo_rpt=="HTML"){
          $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_histo_concep_rn_re.xml");
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
	
	if(($tipo_rpt=="PDF")and($agrup=="S")){$res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_empleado_grupo=""; $cod_concepto_grupo="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"];  
	   if($php_os=="WINNT"){$descripcion=$descripcion; }else{$descripcion=utf8_decode($descripcion); }	  }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $cod_empleado_grupo; global $cod_concepto_grupo; global $tipo_nomina;  global $descripcion;  
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(120,7,'HISTORICO DE CONCEPTOS',1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',8);
			$this->Cell(140,5,"TIPO NOMINA : ".$tipo_nomina." ".$descripcion,0,1,'L');
			$this->Cell(30,5,'CONCEPTO',1,0,'L');
			$this->Cell(130,5,'DESCRIPCION',1,0,'L');
			$this->Cell(20,5,'PERIODO',1,0,'C');
			$this->Cell(20,5,'MONTO',1,1,'R');
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
	  $i=0; $cant_emp=0; $sub_total_monto=0; $sub_total_monto1=0; $prev_cod_empleado=""; $prev_cod_concepto=""; 
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_empleado=$registro["cod_empleado"]; $nombre_empleado=$registro["nombre_empleado"]; $cod_concepto=$registro["cod_concepto"];
	      $des_concepto=$registro["des_concepto"]; $fechan=$registro["fechan"]; $fechai=$registro["fechai"]; $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; 
		  if($php_os=="WINNT"){$nombre_empleado=$nombre_empleado; }else{$nombre_empleado=utf8_decode($nombre_empleado);  $des_concepto=utf8_decode($des_concepto); }
		  $cod_empleado_grupo=$cod_empleado; $cod_concepto_grupo=$cod_concepto; $nombre_empleado_grupo=$nombre_empleado; $des_concepto_grupo=$des_concepto;  $fechan_grupo=$fechan;
		  if(($prev_cod_concepto<>$cod_concepto_grupo)or($prev_cod_empleado<>$cod_empleado)){ 
			 if($sub_total_monto1>0){ $sub_total_monto1=formato_monto($sub_total_monto1);
				$pdf->SetFont('Arial','',7);
				$pdf->Cell(180,2,'',0,0,'L');
				$pdf->Cell(20,2,'-----------------',0,1,'R');
				$pdf->Cell(180,3,"Total Concepto: ".$prev_cod_concepto,0,0,'R');
				$pdf->Cell(20,3,$sub_total_monto1,0,1,'R');	
				$pdf->Ln(3);
			 }	
			 $prev_cod_concepto=$cod_concepto_grupo; $sub_total_monto1=0; 
		  }	 			   
		  if($prev_cod_empleado<>$cod_empleado){
			     if($sub_total_monto>0){$sub_total_monto=formato_monto($sub_total_monto);
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(180,2,'',0,0,'L');
					$pdf->Cell(20,2,'==============',0,1,'R');
					$pdf->Cell(180,3,"Total Trabajador: ".$prev_cod_empleado,0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto,0,1,'R');
					$pdf->Ln(3);
				 }
			     $pdf->SetFont('Arial','B',7);
				 $pdf->Cell(30,5,$cod_empleado_grupo,0,0,'L');  
				 $pdf->Cell(170,5,$nombre_empleado_grupo.",  FECHA INGRESO:".$fechai,0,1,'L');   
				 $prev_cod_empleado=$cod_empleado_grupo;  $sub_total_monto=0; } 
		    $cod_empleado=$registro["cod_empleado"]; $nombre_empleado=$registro["nombre_empleado"]; $cod_concepto=$registro["cod_concepto"];$des_concepto=$registro["des_concepto"]; 
	        $fechan=$registro["fechan"]; $monto=$registro["monto"]; if($php_os=="WINNT"){$nombre_empleado=$nombre_empleado; }else{$nombre_empleado=utf8_decode($nombre_empleado);  $des_concepto=utf8_decode($des_concepto); }
		    $sub_total_monto=$sub_total_monto+$monto; $sub_total_monto1=$sub_total_monto1+$monto; $monto=formato_monto($monto); 
		    $pdf->SetFont('Arial','',7);
	        $pdf->Cell(30,3,$cod_concepto,0,0,'L'); 				   
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=130; 
		    $pdf->SetXY($x+$n,$y);
		    $pdf->Cell(20,3,$fechan,0,0,'L'); 
            $pdf->Cell(20,3,$monto,0,1,'R'); 
		    $pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,3,$des_concepto,0); 
		} 
		if($sub_total_monto1>0){ $sub_total_monto1=formato_monto($sub_total_monto1);
			$pdf->SetFont('Arial','',7);
			$pdf->Cell(180,2,'',0,0,'L');
			$pdf->Cell(20,2,'-----------------',0,1,'R');
			$pdf->Cell(180,3,"Total Concepto: ".$prev_cod_concepto,0,0,'R');
			$pdf->Cell(20,3,$sub_total_monto1,0,1,'R');	
			$pdf->Ln(3);
		 }
		if($sub_total_monto>0){$sub_total_monto=formato_monto($sub_total_monto);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(180,2,'',0,0,'L');
			$pdf->Cell(20,2,'==============',0,1,'R');
			$pdf->Cell(180,3,"Total Trabajador: ".$prev_cod_empleado,0,0,'R');
			$pdf->Cell(20,3,$sub_total_monto,0,1,'R');
		}
		$pdf->Output();  
    }
	
	if(($tipo_rpt=="PDF")and($agrup<>"S")){$res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_empleado_grupo=""; $cod_concepto_grupo=""; $prev_cod_empleado="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $fechai=$registro["fechai"]; 
	   $cod_empleado=$registro["cod_empleado"]; $nombre_empleado=$registro["nombre_empleado"]; $cod_empleado_grupo=$cod_empleado; $nombre_empleado_grupo=$nombre_empleado; $prev_cod_empleado=$cod_empleado_grupo; 
	   if($php_os=="WINNT"){$descripcion=$descripcion; }else{$descripcion=utf8_decode($descripcion);$nombre_empleado=utf8_decode($nombre_empleado);  }	 $prev_cod_empleado=$cod_empleado;  }
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
	  
		function Header(){ global $criterio1; global $cod_empleado_grupo; global $nombre_empleado_grupo; global $tipo_nomina;  global $descripcion; global $fechai;   
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(120,7,'HISTORICO DE CONCEPTOS',1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',8);
			$this->Cell(20,5,$cod_empleado_grupo,0,0,'L');  
			$this->Cell(150,5,$nombre_empleado_grupo,0,0,'L');
            $this->Cell(30,5,"FECHA INGRESO: ".$fechai,0,1,'L');			
			$this->Cell(70,5,'NOMINA',1,0,'L');
			$this->Cell(20,5,'FECHA',1,0,'C');
			$this->Cell(90,5,'DESCRIPCION',1,0,'L');
			$this->Cell(20,5,'MONTO',1,1,'R');
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
	  $i=0; $cant_emp=0; $sub_total_monto=0; $sub_total_monto1=0;  $prev_cod_concepto=""; 
	  //$pdf->MultiCell(200,3,$sSQL,0);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
	      $cod_empleado=$registro["cod_empleado"]; $nombre_empleado=$registro["nombre_empleado"]; $cod_concepto=$registro["cod_concepto"];
	      $des_concepto=$registro["des_concepto"]; $fechan=$registro["fechan"]; $fechai=$registro["fechai"]; $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; 
		  if($php_os=="WINNT"){$nombre_empleado=$nombre_empleado; }else{$nombre_empleado=utf8_decode($nombre_empleado);  $des_concepto=utf8_decode($des_concepto); }
		  $cod_empleado_grupo=$cod_empleado; $cod_concepto_grupo=$cod_concepto; $nombre_empleado_grupo=$nombre_empleado; $des_concepto_grupo=$des_concepto;  $fechan_grupo=$fechan;
		   
		   
		    if($prev_cod_empleado<>$cod_empleado){
			     if($sub_total_monto>0){$sub_total_monto=formato_monto($sub_total_monto);
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(180,2,'',0,0,'L');
					$pdf->Cell(20,2,'==============',0,1,'R');
					$pdf->Cell(180,3,"Total Trabajador: ".$prev_cod_empleado,0,0,'R');
					$pdf->Cell(20,3,$sub_total_monto,0,1,'R');
				 }
			     $pdf->AddPage();  
				 $prev_cod_empleado=$cod_empleado_grupo;  $sub_total_monto=0; 
		    } 
			  
		    $cod_empleado=$registro["cod_empleado"]; $nombre_empleado=$registro["nombre_empleado"]; $cod_concepto=$registro["cod_concepto"];$des_concepto=$registro["des_concepto"]; 
	        $fechan=$registro["fechan"]; $monto=$registro["monto"]; if($php_os=="WINNT"){$nombre_empleado=$nombre_empleado; }else{$nombre_empleado=utf8_decode($nombre_empleado);  $des_concepto=utf8_decode($des_concepto); }
		    $sub_total_monto=$sub_total_monto+$monto; $sub_total_monto1=$sub_total_monto1+$monto; $monto=formato_monto($monto); 
		   
			$pdf->SetFont('Arial','',7);
	        $pdf->Cell(70,3,$descripcion,0,0,'L'); 	
            $pdf->Cell(20,3,$fechan,0,0,'L'); 			
		    $x=$pdf->GetX();   $y=$pdf->GetY(); $n=90; 
		    $pdf->SetXY($x+$n,$y);
            $pdf->Cell(20,3,$monto,0,1,'R'); 
		    $pdf->SetXY($x,$y);
		    $pdf->MultiCell($n,3,$des_concepto,0); 
		} 
		if($sub_total_monto>0){$sub_total_monto=formato_monto($sub_total_monto);
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(180,2,'',0,0,'L');
			$pdf->Cell(20,2,'==============',0,1,'R');
			$pdf->Cell(180,3,"Total Trabajador: ".$prev_cod_empleado,0,0,'R');
			$pdf->Cell(20,3,$sub_total_monto,0,1,'R');
		}
		$pdf->Output();  
    }

	if($tipo_rpt=="EXCEL"){$res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_empleado_grupo=""; $cod_concepto_grupo="";
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; }
	    header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Historico_Conceptos.xls"); 	
		?>

	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>HISTORICO DE CONCEPTOS</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong>Tipo Nomina: </strong></td>
		    <td width="400" align="left" >'<strong><? echo $tipo_nomina."    ".$descripcion; ?></strong></td>
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"><strong>Concepto</strong></td>
		   <td width="400" align="left"><strong>Descripcion</strong></td>
		   <td width="100" align="center"><strong>Periodo</strong></td>
		   <td width="100" align="right"><strong>Monto</strong></td>
		 </tr>
		 <tr height="20">
		 </tr>
		<?  $i=0; $cant_emp=0; $sub_total_monto=0; $sub_total_monto1=0; $prev_cod_empleado=""; $prev_cod_concepto="";  $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $cod_empleado=$registro["cod_empleado"]; $nombre_empleado=$registro["nombre_empleado"]; $cod_concepto=$registro["cod_concepto"];$des_concepto=$registro["des_concepto"]; 
		   $fechan=$registro["fechan"]; $cod_empleado_grupo=$cod_empleado; $cod_concepto_grupo=$cod_concepto; $nombre_empleado_grupo=$nombre_empleado; $des_concepto_grupo=$des_concepto; 
	           $fechan_grupo=$fechan; 

		   if(($prev_cod_concepto<>$cod_concepto_grupo)or($prev_cod_empleado<>$cod_empleado)){ 
			 if($sub_total_monto1>0){ $sub_total_monto1=formato_monto($sub_total_monto1);
				?>	 				 
                    <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>	
					  <td width="100" align="right"></td>
					  <td width="100" align="right">_____________</td>
				    </tr>
                    <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>	
					  <td width="100" align="right">'<? echo $prev_cod_concepto; ?></td>
					  <td width="100" align="right"><? echo $sub_total_monto1; ?></td>
				    </tr>
                <?
			 }	
			 $prev_cod_concepto=$cod_concepto_grupo; $sub_total_monto1=0; }	
			  if($prev_cod_empleado<>$cod_empleado){
			     if($sub_total_monto>0){$sub_total_monto=formato_monto($sub_total_monto);
				?>	 				 
                     <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>	
					  <td width="100" align="right"></td>
					  <td width="100" align="right">============</td>
				    </tr>
                    <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>	
					  <td width="100" align="right"><strong>'<? echo $prev_cod_empleado; ?></strong></td>
					  <td width="100" align="right"><strong><? echo $sub_total_monto; ?></strong></td>
				    </tr>
					<tr height="20">
		            </tr>
                 <?
				 }
				?>	 				 
                    <tr>
					  <td width="100" align="left"><strong>'<? echo $cod_empleado_grupo; ?></strong></td>
					  <td width="400" align="left"><strong><? echo $nombre_empleado_grupo; ?></strong></td>	
				    </tr>
                <?  
				 $prev_cod_empleado=$cod_empleado_grupo;  $sub_total_monto=0; } 

		   $cod_empleado=$registro["cod_empleado"]; $nombre_empleado=$registro["nombre_empleado"]; $cod_concepto=$registro["cod_concepto"];$des_concepto=$registro["des_concepto"]; 
	       $fechan=$registro["fechan"]; $monto=$registro["monto"];	 $sub_total_monto=$sub_total_monto+$monto; $sub_total_monto1=$sub_total_monto1+$monto; 	 $monto=formato_monto($monto); 
				?>	 				 
                     <tr>
					  <td width="100" align="left">'<? echo $cod_concepto; ?></td>
					  <td width="400" align="left"><? echo $des_concepto; ?></td>
					  <td width="100" align="center"><? echo $fechan; ?></td>
					  <td width="100" align="right"><? echo $monto; ?></td>	
				    </tr>
                 <?  			
		  }
		  if($sub_total_monto1>0){ $sub_total_monto1=formato_monto($sub_total_monto1);
				?>	 				 
                     <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>	
					  <td width="100" align="right"></td>
					  <td width="100" align="right">_____________</td>
				    </tr>
                     <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>	
					  <td width="100" align="right">'<? echo $prev_cod_concepto; ?></td>
					  <td width="100" align="right"><? echo $sub_total_monto1; ?></td>
				    </tr>
            <?
			 }	
			     if($sub_total_monto>0){$sub_total_monto=formato_monto($sub_total_monto);
				?>	 				 
                    <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>	
					  <td width="100" align="right"></td>
					  <td width="100" align="right">============</td>
				    </tr>
                     <tr>
					  <td width="100" align="left"></td>
					  <td width="400" align="left"></td>	
					  <td width="100" align="right"><strong>'<? echo $prev_cod_empleado; ?></strong></td>
					  <td width="100" align="right"><strong><? echo $sub_total_monto; ?></strong></td>
				    </tr>
                 <?
				 }
		  ?></table><?
	} 
}
?>
