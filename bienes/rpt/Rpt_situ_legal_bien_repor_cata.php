<? include ("../../class/conect.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); $tipo_rpt="PDF"; //$tipo_rpt="HTML";
$date=date("d-m-Y");$hora=date("H:i:s a"); $php_os=PHP_OS;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
	$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";	if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
	if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="03-0000040"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
	 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
	}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}

    $sSQL = "SELECT codigo, tipo_situacion, des_sit_legal FROM bien009 order by codigo";
	if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php"); 
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_situ_legal_bien_repor_cata.xml");
            $oRpt->setUser("$user");
            $oRpt->setPassword("$password");
            $oRpt->setConnection("$host");
            $oRpt->setDatabaseInterface("postgresql");
            $oRpt->setSQL($sSQL);
            $oRpt->setDatabase("$dbname");
            $oRpt->setParameters(array("date"=>$date,"hora"=>$hora));
            $oRpt->run();
    }
	
	if($tipo_rpt=="PDF"){	 
      require('../../class/fpdf/fpdf.php');	  
	  class PDF extends FPDF{
		function Header(){ global $criterio1; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(40);
			$this->Cell(130,10,'CATALOGO DE SITUACION LEGAL DEL BIEN',1,1,'C');
			$this->Ln(10);			
			$this->SetFont('Arial','B',8);	
			$this->Cell(13,4,'CODIGO',1,0,'L');
			$this->Cell(52,4,'ESTADO',1,0,'C');
			$this->Cell(135,4,'DESCRIPCION',1,1,'L');
			
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
	  $res=pg_query($sSQL);  $i=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		$codigo=$registro["codigo"]; $descripcion=$registro["des_sit_legal"]; $tipo_situacion=$registro["tipo_situacion"]; 
		if($php_os=="WINNT"){$descripcion=$registro["des_sit_legal"]; }else{$descripcion=utf8_decode($descripcion);}	    
		$pdf->Cell(13,4,$codigo,0,0,'L');
		$pdf->Cell(52,4,$tipo_situacion,0,0,'L');
		$pdf->MultiCell(135,4,$descripcion,0,'L');
	  }
      $pdf->Output(); 
    }
	
}	
?>
