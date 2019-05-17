<? include ("../../class/conect.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS; $tipo_rpt="PDF"; //$tipo_rpt="HTML";
$cod_dependenciad=$_GET["cod_dependenciad"];$cod_dependenciah=$_GET["cod_dependenciah"]; $cod_direciond=$_GET["cod_direciond"];$cod_direcionh=$_GET["cod_direcionh"]; $date = date("d-m-Y");$hora = date("H:i:s a"); $php_os=PHP_OS;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }

    $sSQL = "SELECT bien006.cod_dependencia, bien001.denominacion_dep, bien006.cod_direccion, bien005.denominacion_dir,bien006.cod_departamento, bien006.denominacion_dep as denomina_dep, bien006.Direccion_dep, bien006.Nombre_Contacto_d, bien006.Observacion_dep FROM bien006 LEFT JOIN bien001 ON (bien001.cod_dependencia=bien006.cod_dependencia) LEFT JOIN bien005 ON (bien005.cod_direccion=bien006.cod_direccion) 
    WHERE bien006.cod_dependencia>='".$cod_dependenciad."' AND bien006.cod_dependencia<='".$cod_dependenciah."' AND bien006.cod_direccion>='".$cod_direciond."' AND bien006.cod_direccion<='".$cod_direcionh."' 
    ORDER BY bien006.cod_dependencia,bien006.cod_direccion,bien006.cod_departamento";

    if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_depen_direc_depar_repor_cata.xml");                           
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
			$this->Cell(130,10,'CATALOGO DE DEPENDENCIAS/DIRECCIONES/DEPARTAMENTOS',1,1,'C');
			$this->Ln(10);			
			$this->SetFont('Arial','B',8);				
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
	  $res=pg_query($sSQL); $prev_depen=""; $prev_dir="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		$cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"]; $cod_direccion=$registro["cod_direccion"]; $denominacion_dir=$registro["denominacion_dir"];
        $cod_departamento=$registro["cod_departamento"]; $denomina_dep=$registro["denomina_dep"]; 
		if($php_os=="WINNT"){$denominacion_dep=$registro["denominacion_dep"]; }else{$denominacion_dep=utf8_decode($denominacion_dep);$denominacion_dir=utf8_decode($denominacion_dir);$denomina_dep=utf8_decode($denomina_dep);}
		if($prev_depen<>$cod_dependencia){  $prev_depen=$cod_dependencia;
		  $pdf->Ln(3);
		  $pdf->Cell(10,4,$cod_dependencia,0,0,'L');
		  $pdf->Cell(190,4,$denominacion_dep,0,1,'L');
		}		
		if($prev_dir<>$cod_direccion){ $prev_dir=$cod_direccion;
		  $pdf->Ln(2);
		  $pdf->Cell(10);
		  $pdf->Cell(10,4,$cod_direccion,0,0,'L');
		  $pdf->Cell(180,4,$denominacion_dir,0,1,'L');
		}		
		$pdf->Cell(20);
		$pdf->Cell(20,4,$cod_departamento,0,0,'L');
		$pdf->Cell(155,4,$denomina_dep,0,1,'L');
	  }
      $pdf->Output(); 
  }	  
}   
?>

