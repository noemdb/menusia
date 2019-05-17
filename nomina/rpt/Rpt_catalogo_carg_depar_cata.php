<? include ("../../class/seguridad.inc"); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$codigo_departamento_d=$_GET["codigo_departamento_d"];   $codigo_departamento_h=$_GET["codigo_departamento_h"]; $codigo_cargo_d=$_GET["codigo_cargo_d"];   $codigo_cargo_h=$_GET["codigo_cargo_h"]; $tipo_rpt=$_GET["tipo_rpt"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{ $php_os=PHP_OS;   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}

   $sSQL = "SELECT NOM005.Codigo_Departamento, NOM005.Descripcion_Dep, NOM043.Codigo_Cargo, NOM043.Cod_Tipo_Personal, NOM043.Nro_Cargos, NOM043.Asignados,NOM004.Denominacion
            FROM NOM005,NOM004,NOM043  WHERE NOM005.Codigo_Departamento=NOM043.Codigo_Departamento  And NOM004.Codigo_Cargo=NOM043.Codigo_Cargo AND
            NOM005.Codigo_Departamento>='$codigo_departamento_d' and NOM005.Codigo_Departamento<='$codigo_departamento_h' AND
            NOM004.Codigo_Cargo>='$codigo_cargo_d' and NOM004.Codigo_Cargo<='$codigo_cargo_h' ORDER BY NOM005.Codigo_Departamento";
	  
  if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML("Catalogo_carg_depar_cata_re.xml");
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
  if($tipo_rpt=="PDF"){	 $res=pg_query($sSQL);  $descripcion_dep_grupo=""; 
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $descripcion_dep;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(120,10,'CATALOGOS DE CARGOS POR DEPARTAMENTO',1,0,'C');
			$this->Ln(18);
			$this->SetFont('Arial','B',8);
			$this->Cell(20,5,'CODIGO',1,0,'L');
			$this->Cell(140,5,'DENOMINACION CARGO',1,0,'L');
			$this->Cell(20,5,'NRO. CARGO',1,0,'C');
			$this->Cell(20,5,'ASIGNADO',1,1,'C');
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
	  $i=0; $cantidad=0; $total_cantidad=0; $prev_descripcion_dep=""; 
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		    $descripcion_dep=$registro["descripcion_dep"]; $codigo_cargo=$registro["codigo_cargo"]; 
            if($php_os=="WINNT"){$descripcion_dep=$registro["descripcion_dep"]; }else{$descripcion_dep=utf8_decode($descripcion_dep);}
            $descripcion_dep_grupo=$descripcion_dep; $codigo_cargo_grupo=$codigo_cargo; 
            $pdf->SetFont('Arial','B',8);
            if($prev_descripcion_dep<>$descripcion_dep_grupo){ 
              if($cantidad>0){$pdf->Cell(200,5,'CANTIDAD CARGOS : '.$cantidad,0,1,'L'); $pdf->Ln(3); }
			  $pdf->Cell(200,5,$descripcion_dep_grupo,0,1,'L');
			  $prev_descripcion_dep=$descripcion_dep_grupo; $cantidad=0; } 

		    $descripcion_dep=$registro["descripcion_dep"]; $codigo_cargo=$registro["codigo_cargo"]; $denominacion=$registro["denominacion"]; $nro_cargos=$registro["nro_cargos"]; 
            $asignados=$registro["asignados"]; $cantidad=$cantidad+1; $total_cantidad=$total_cantidad+1;
            if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }else{$denominacion=utf8_decode($denominacion);}
		    $pdf->SetFont('Arial','',8); 
		    $pdf->Cell(20,4,$codigo_cargo,0,0,'L'); 		   
		    $x=$pdf->GetX();   $y=$pdf->GetY();  $w=140;		   
		    $pdf->SetXY($x+$w,$y);
            $pdf->Cell(20,4,$nro_cargos,0,0,'C'); 
		    $pdf->Cell(20,4,$asignados,0,1,'C'); 
		    $pdf->SetXY($x,$y);	
		    $pdf->MultiCell($w,4,$denominacion,0); 
		} $pdf->SetFont('Arial','B',8);
        if($cantidad>0){$pdf->Cell(200,5,'CANTIDAD CARGOS : '.$cantidad,0,1,'L'); $pdf->Ln(3); }			 
		$pdf->Output();   
    }	  
    if($tipo_rpt=="EXCEL"){ $res=pg_query($sSQL);  $descripcion_dep_grupo=""; 
	    header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Catalago_Cargos_Departamentos.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		        <td width="100" align="left" ><strong></strong></td>
                <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CATALOGOS DE CARGOS POR DEPARTAMENTO</strong></font></td>
	      </tr>
	      <tr height="20">
	     </tr>
             <tr height="20">
           	<td width="100" align="left" bgcolor="#99CCFF"><strong>CODIGO</strong></td>
           	<td width="400" align="left" bgcolor="#99CCFF"><strong>DENOMINACION CARGO</strong></td>
           	<td width="100" align="center" bgcolor="#99CCFF" ><strong>NRO. CARGO</strong></font></td>
           	<td width="100" align="center" bgcolor="#99CCFF" ><strong>ASIGNADO</strong></font></td>
            </tr>
     <?	  
	    $i=0; $cantidad=0;  $total_cantidad=0; $prev_descripcion_dep=""; $prev_descripcion=""; $prev_cod_concepto="";
	    while($registro=pg_fetch_array($res)){ $i=$i+1;
		    $descripcion_dep=$registro["descripcion_dep"]; $codigo_cargo=$registro["codigo_cargo"]; 
            $descripcion_dep_grupo=$descripcion_dep; $codigo_cargo_grupo=$codigo_cargo;  $descripcion=conv_cadenas($descripcion,0); 

            if($prev_descripcion_dep<>$descripcion_dep_grupo){ 
                if($cantidad>0){ 
				?>	   
				   <tr>
				        <td width="100" align="left"><strong></strong></td>
           				<td width="400" align="left"><strong><? echo 'CANTIDAD CARGOS:'.$cantidad; ?></strong></td>
         			</tr>
			        <tr>
				      <td width="100" align="left"></td>
			        </tr>
				<?}
				?>	   
				<tr>
           			<td width="100" align="left"><strong>'<? echo $descripcion_dep_grupo; ?></strong></td>
         		</tr>
				<?
				$prev_descripcion_dep=$descripcion_dep_grupo; $cantidad=0; } 
		    $descripcion_dep=$registro["descripcion_dep"]; $codigo_cargo=$registro["codigo_cargo"]; $denominacion=$registro["denominacion"]; $nro_cargos=$registro["nro_cargos"]; 
            $asignados=$registro["asignados"]; $cantidad=$cantidad+1; $total_cantidad=$total_cantidad+1;$denominacion=conv_cadenas($denominacion,0);  
		?>	 
			<tr>
           			<td width="100" align="left">'<? echo $codigo_cargo; ?></td>
           			<td width="400" align="left"><? echo $denominacion; ?></td>
           			<td width="100" align="center"><? echo $nro_cargos; ?></td>
           			<td width="100" align="center"><? echo $asignados; ?></td>
         		</tr>
		<? }
               if($cantidad>0){ 
				?>	   
				    <tr>
					    <td width="100" align="left"><strong></strong></td>
           				<td width="400" align="left"><strong><? echo 'CANTIDAD CARGOS:'.$cantidad; ?></strong></td>
           				
         			</tr>
				<?} 
         ?>
	   <tr>
            <td>&nbsp;</td>
           </tr>      
	  </table><?
	}

   }
?>
