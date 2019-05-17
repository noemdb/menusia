<? include ("../../class/seguridad.inc"); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
   $fecha_d=$_GET["fecha_d"];   $fecha_h=$_GET["fecha_h"]; $tipo_rpt=$_GET["tipo_rpt"];   $date = date("d-m-Y");   $hora = date("H:i:s a"); 
   
   $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else{ $nom_emp=busca_conf(); $php_os=PHP_OS;  if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
       
	$sSQL = "SELECT nom021.numero, nom021.fecha_desde, nom021.fecha_hasta, nom021.tasa, 
	        to_char(nom021.fecha_desde,'DD/MM/YYYY') as fechad, to_char(nom021.fecha_hasta,'DD/MM/YYYY') as fechah  FROM nom021 WHERE nom021.fecha_desde>='".$fecha_d."' AND nom021.fecha_hasta<='".$fecha_h."' ORDER BY nom021.numero";
    if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML("Rpt_list_inter_pres_mpr_re.xml");
	  $oRpt->setUser("$user");
	  $oRpt->setPassword("$password");
	  $oRpt->setConnection("$host");
	  $oRpt->setDatabaseInterface("postgresql");
	  $oRpt->setSQL($sSQL);
	  $oRpt->setDatabase("$dbname");
	  $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"monto"=>$monto,"date"=>$date,"hora"=>$hora));
	  $oRpt->run();
	  $aBench = $oRpt->getBenchmark();
    }
	if($tipo_rpt=="PDF"){$res=pg_query($sSQL); $filas=pg_num_rows($res); 
      if($filas>=1){ $registro=pg_fetch_array($res,0); $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; }	  
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1;  global $tipo_nomina;  global $descripcion;  
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',12);
			$this->Cell(50);
			$this->Cell(120,7,'LISTADO TASAS INTERESES DE PRESTACIONES',1,0,'C');
			$this->Ln(20);
			$this->SetFont('Arial','B',8);
			$this->Cell(30,5,'',0,0,'L');
			$this->Cell(30,5,'Numero Resolucion',1,0,'L');
			$this->Cell(30,5,'Fecha Desde',1,0,'C');
			$this->Cell(30,5,'Fecha Hasta',1,0,'C');
			$this->Cell(30,5,'Tasa Interes (%)',1,1,'R');

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
	  $pdf->SetFont('Arial','',9);
	  $i=0; 
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $numero=$registro["numero"]; $fecha_desde=$registro["fecha_desde"]; $fecha_hasta=$registro["fecha_hasta"]; $tasa=$registro["tasa"];   
		   $tasa=formato_monto($tasa); $fecha_desde=formato_ddmmaaaa($fecha_desde); $fecha_hasta=formato_ddmmaaaa($fecha_hasta);
		   $pdf->SetFont('Arial','',9);
		   $pdf->Cell(30,5,'',0,0,'L');
	       $pdf->Cell(30,5,$numero,0,0,'L'); 
	       $pdf->Cell(30,5,$fecha_desde,0,0,'C'); 				   
		   $pdf->Cell(30,5,$fecha_hasta,0,0,'C'); 
           $pdf->Cell(30,5,$tasa,0,1,'R'); 
	    } 		
		$pdf->Output();  
    }
    if($tipo_rpt=="EXCEL"){
	      header("Content-type: application/vnd.ms-excel");
          header("Content-Disposition: attachment; filename=RPT_Listado_Intereses_Tasa_Prestaciones.xls"); 	
		?>

	   <table border="0" cellspacing='0' cellpadding='0' align="left">
		 <tr height="20">
		    	<td width="100" align="left" ><strong></strong></td>
			<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO TASAS INTERESES DE PRESTACIONES</strong></font></td>
		 </tr>
		 <tr height="20">
		 </tr>
		 <tr height="20">
		   <td width="100" align="left"  bgcolor="#99CCFF"><strong>Numero Resolucion</strong></td>
		   <td width="400" align="center"  bgcolor="#99CCFF"><strong>Fecha Desde</strong></td>
		   <td width="100" align="center"  bgcolor="#99CCFF"><strong>Fecha Hasta</strong></td>
		   <td width="100" align="right"  bgcolor="#99CCFF"><strong>Tasa</strong></td>
		 </tr>
		<?  $i=0; $res=pg_query($sSQL);
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		   $numero=$registro["numero"]; $fecha_desde=$registro["fecha_desde"]; $fecha_hasta=$registro["fecha_hasta"]; $tasa=$registro["tasa"];   
		   $tasa=formato_monto($tasa); $fecha_desde=formato_ddmmaaaa($fecha_desde); $fecha_hasta=formato_ddmmaaaa($fecha_hasta);
			?>	 				 
                <tr>
					  <td width="100" align="left">'<? echo $numero; ?></td>
					  <td width="400" align="center"><? echo $fecha_desde; ?></td>
					  <td width="100" align="center"><? echo $fecha_hasta; ?></td>	
					  <td width="100" align="right"><? echo $tasa; ?></td>	
				    </tr>
             <?  			
		  }
        ?>	    
	  </table><?
	}	
}	
?>
