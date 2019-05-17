<? include ("../../class/conect.php"); include ("../../class/configura.inc");   error_reporting(E_ALL ^ E_NOTICE); $tipo_rpt="PDF"; //$tipo_rpt="HTML";
$ced_responsabled=$_GET["ced_responsabled"];$ced_responsableh=$_GET["ced_responsableh"];$ordenado=$_GET["ordenado"];
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $date = date("d-m-Y");$hora = date("H:i:s a"); $php_os=PHP_OS;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
         $sSQL = "SELECT BIEN002.ced_responsable, BIEN002.nombre_res, BIEN002.observaciones  FROM BIEN002 WHERE ced_responsable>='".$ced_responsabled."' AND ced_responsable<='".$ced_responsableh."' ORDER BY $ordenado";
    if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_resp_pri_repor_cata.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("localhost");
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
			$this->Cell(130,10,'CATALOGO DE RESPONSABLES PRIMARIOS',1,1,'C');
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
		$ced_responsable=$registro["ced_responsable"]; $nombre_res=$registro["nombre_res"]; $observaciones=$registro["observaciones"]; 
		if($php_os=="WINNT"){$nombre_res=$registro["nombre_res"]; }else{$nombre_res=utf8_decode($nombre_res);$observaciones=utf8_decode($observaciones);}		
		$pdf->Cell(17,4,$ced_responsable,0,0,'L');
		$pdf->Cell(100,4,$nombre_res,0,0,'L');
		$pdf->Cell(83,4,$observaciones,0,1,'L');
	  }
      $pdf->Output(); 
  }	  
}   
?>


