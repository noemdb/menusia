<? include ("../../class/conect.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); $tipo_rpt="PDF"; //$tipo_rpt="HTML";
$date=date("d-m-Y");$hora=date("H:i:s a"); $php_os=PHP_OS;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{  $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
	$sql="SELECT campo103 FROM sia001 where campo101='$usuario_sia'"; $resultado=pg_exec($conn,$sql);$filas=pg_numrows($resultado);  $tipo_u="U";	if ($filas>0){$registro=pg_fetch_array($resultado); $tipo_u=$registro["campo103"]; $tiene_acceso="S";} $Mcamino="NNNNNNNNNNNNNNNNNNNN";
	if($tipo_u=="A"){$Mcamino="SSSSSSSSSSSSSSSSSSSS";}  else{$modulo="13"; $opcion="03-0000030"; $sql="select * from sia006 where campo601='$usuario_sia' and campo602='$modulo' and campo603='$opcion'";$res=pg_exec($conn,$sql);$filas=pg_numrows($res);
	 if ($filas>0){$reg=pg_fetch_array($res); $Mcamino=$reg["campo607"].$reg["campo608"].$reg["campo609"].$reg["campo610"].$reg["campo611"].$reg["campo612"].$reg["campo613"].$reg["campo614"].$reg["campo615"].$reg["campo616"].$reg["campo617"].$reg["campo618"].$reg["campo619"].$reg["campo620"].$reg["campo621"].$reg["campo622"].$reg["campo623"].$reg["campo624"].$reg["campo625"].$reg["campo626"]; }
	}$posicion=strpos($Mcamino,'S'); if(is_numeric($posicion)){$Mcamino=$Mcamino;}else{?><script language="JavaScript"> document.location='../menu.php';</script><?}

    $sSQL = "SELECT codigo, denomina_tipo, tipo, status_tipo, gen_comprobante FROM bien003 order by codigo";
    if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_tipo_movi_repor_cata.xml");
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
			$this->Cell(130,10,'CATALOGO DE TIPOS DE MOVIMIENTO',1,1,'C');
			$this->Ln(10);			
			$this->SetFont('Arial','B',8);	
			$this->Cell(13,4,'CODIGO',1,0,'L');
			$this->Cell(135,4,'DENOMINACION',1,0,'L');
			$this->Cell(32,4,'TIPO',1,0,'C');
			$this->Cell(20,4,'GEN.COMPR.',1,1,'C');
			
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
		$codigo=$registro["codigo"]; $denomina_tipo=$registro["denomina_tipo"]; $tipo=$registro["tipo"]; $gen_comprobante=$registro["gen_comprobante"]; 
		if($php_os=="WINNT"){$denomina_tipo=$registro["denomina_tipo"]; }else{$denomina_tipo=utf8_decode($denomina_tipo);}	        $des_tipo=""; $gen_comp="";
        if($tipo=="I"){$des_tipo="INCORPORACION";}if($tipo=="R"){$des_tipo="REASIGNACIONES";}if($tipo=="D"){$des_tipo="DESINCORPORACION";}if($tipo=="M"){$des_tipo="MODIFICACIONES";}
        if($gen_comprobante=="S"){$gen_comp="SI";}else{$gen_comp="NO";}		
		$pdf->Cell(13,4,$codigo,0,0,'L');
		$pdf->Cell(135,4,$denomina_tipo,0,0,'L');
		$pdf->Cell(32,4,$des_tipo,0,0,'C');
		$pdf->Cell(20,4,$gen_comp,0,1,'C');
	  }
      $pdf->Output(); 
  }
	
	
}	
?>
