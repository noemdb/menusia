<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$codigo_cargo_d=$_GET["codigo_cargo_d"];   $codigo_cargo_h=$_GET["codigo_cargo_h"]; $tipo_rpt=$_GET["tipo_rpt"]; $php_os=PHP_OS; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
  $sSQL = "SELECT nom004.codigo_cargo, nom004.denominacion, nom004.nro_cargos, nom004.asignados, nom004.grado, nom004.Paso, nom004.sueldo_cargo  FROM nom004 where nom004.codigo_cargo>='$codigo_cargo_d' and nom004.codigo_cargo<='$codigo_cargo_h' ORDER BY nom004.codigo_cargo";
  if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML("Rpt_cargos_cata_re.xml");
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
  if($tipo_rpt=="PDF"){	 
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,'CATALOGO DE CARGOS',1,0,'C');
			$this->Ln(18);
			$this->SetFont('Arial','B',8);
			$this->Cell(15,5,'CODIGO',1,0,'L');
			$this->Cell(115,5,'DENOMINACION DEL CARGO',1,0,'L');
			$this->Cell(15,5,'SUELDO',1,0,'R');
			$this->Cell(15,5,'CARGOS',1,0,'R');
			$this->Cell(19,5,'ASIGNADOS',1,0,'R');
			$this->Cell(11.5,5,'GRADO',1,0,'C');
			$this->Cell(9.5,5,'PASO',1,1,'C');
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
	  $i=0; $cantidad=0; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $codigo_cargo=$registro["codigo_cargo"]; $denominacion=$registro["denominacion"]; $nro_cargos=$registro["nro_cargos"]; $asignados=$registro["asignados"]; $grado=$registro["grado"];
           $paso=$registro["paso"]; $cantidad=$cantidad+1; if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }else{$denominacion=utf8_decode($denominacion);}
		   $sueldo_cargo=$registro["sueldo_cargo"]; $sueldo_cargo=formato_monto($sueldo_cargo);
		   $pdf->Cell(15,4,$codigo_cargo,0,0,'L'); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=115;		   
		   $pdf->SetXY($x+$w,$y);
           $pdf->Cell(15,4,$sueldo_cargo,0,0,'R');
           $pdf->Cell(15,4,$nro_cargos,0,0,'R'); 		   
		   $pdf->Cell(20,4,$asignados,0,0,'R'); 
		   $pdf->Cell(10,4,$grado,0,0,'C'); 
		   $pdf->Cell(10,4,$paso,0,1,'C'); 
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($w,4,$denominacion,0); 
		   } 
		$pdf->Cell(200,3,'',0,1,'L');	
		$pdf->Cell(50,3,'CANTIDAD DE CARGOS : '.$cantidad,0,0,'L');			 
		$pdf->Output();   
    }	  
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Catalago_Cargos.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		     <td width="100" align="left" ><strong></strong></td>
             <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CATALOGO DE CARGOS</strong></font></td>
	     </tr>
	      <tr height="20">
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><strong>CODIGO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>DENOMINACION DEL CARGO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>SUELDO</strong></font></td>
		   <td width="100" align="center" bgcolor="#99CCFF" ><strong>NRO. CARGO</strong></font></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>ASIGNADOS</strong></font></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>GRADO</strong></font></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>PASO</strong></font></td>
         </tr>
     <?	  
	  $i=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
	  $codigo_cargo=$registro["codigo_cargo"]; $denominacion=$registro["denominacion"]; $nro_cargos=$registro["nro_cargos"]; $asignados=$registro["asignados"]; $grado=$registro["grado"];
          $sueldo_cargo=$registro["sueldo_cargo"]; $sueldo_cargo=formato_monto($sueldo_cargo);$paso=$registro["paso"]; $cantidad=$cantidad+1; $denominacion=conv_cadenas($denominacion,0);  
	 ?>	   
	    <tr>
           <td width="100" align="left">'<? echo $codigo_cargo; ?></td>
           <td width="400" align="left"><? echo $denominacion; ?></td>
           <td width="100" align="right"><? echo $sueldo_cargo; ?></td>
           <td width="100" align="right"><? echo $nro_cargos; ?></td>
           <td width="100" align="right"><? echo $asignados; ?></td>
           <td width="100" align="right"><? echo $grado; ?></td>
           <td width="100" align="right"><? echo $paso; ?></td>
         </tr>
	<? }  
        ?>
	   <tr>
            <td>&nbsp;</td>
       </tr>
	   <tr>
            <td width="100" align="center"></td>
		    <td width="400" align="left"><strong>CANTIDAD DE CARGOS: <? echo $cantidad; ?></strong></td>	
         </tr>      
	  </table><?
	}

}
?>
