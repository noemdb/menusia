<? include ("../../class/conect.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); $tipo_rpt="PDF"; //$tipo_rpt="HTML";
$ced_res_rotud=$_GET["ced_res_rotud"];$ced_res_rotuh=$_GET["ced_res_rotuh"];$ordenado=$_GET["ordenado"]; $date = date("d-m-Y");$hora = date("H:i:s a"); $php_os=PHP_OS;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
         $sSQL = "SELECT BIEN032.ced_res_rotu, BIEN032.nombre_res_rotu, BIEN032.observaciones_rotu  FROM BIEN032 WHERE ced_res_rotu>='".$ced_res_rotud."' AND 
                  ced_res_rotu<='".$ced_res_rotuh."'ORDER BY $ordenado";
    if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_resp_rotu_repor_cata.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("$host");
            $oRpt->setDatabaseInterface("postgresql");
            $oRpt->setSQL($sSQL);
            $oRpt->setDatabase("$dbname");
            $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
            $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
            $oRpt->run();
            $aBench = $oRpt->getBenchmark();
            $iSec   = $aBench["report_end"]-$aBench["report_start"];
   }
   if($tipo_rpt=="PDF"){	 
      require('../../class/fpdf/fpdf.php');	  
	  class PDF extends FPDF{
		function Header(){ global $criterio1; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(40);
			$this->Cell(130,10,'CATALOGO DE RESPONSABLES ROTULADOR',1,1,'C');
			$this->Ln(10);			
			$this->SetFont('Arial','B',8);	
			$this->Cell(17,4,'CEDULA',1,0,'L');
			$this->Cell(100,4,'NOMBRE',1,0,'L');
			$this->Cell(83,4,'OBSERVACIONES',1,1,'C');
			
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
	  $res=pg_query($sSQL); $prev_depen=""; $prev_dir=""; $i=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		$ced_responsable=$registro["ced_res_rotu"]; $nombre_res=$registro["nombre_res_rotu"]; $observaciones=$registro["observaciones_rotu"]; 
		if($php_os=="WINNT"){$nombre_res=$registro["nombre_res_rotu"]; }else{$nombre_res=utf8_decode($nombre_res);$observaciones=utf8_decode($observaciones);}		
		$pdf->Cell(17,4,$ced_responsable,0,0,'L');
		$pdf->Cell(100,4,$nombre_res,0,0,'L');
		$pdf->Cell(83,4,$observaciones,0,1,'L');
	  }
      $pdf->Output(); 
  }	  
}   
?>
