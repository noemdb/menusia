<? include ("../../class/conect.php"); include ("../../class/configura.inc");   error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS; $tipo_rpt="PDF"; //$tipo_rpt="HTML";
$cod_dependenciad=$_GET["cod_dependenciad"];$cod_dependenciah=$_GET["cod_dependenciah"]; $date = date("d-m-Y");$hora = date("H:i:s a"); $php_os=PHP_OS;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }

    $sSQL = "SELECT bien001.cod_dependencia, bien001.denominacion_dep, bien001.cod_region, pre092.nombre_region, bien001.cod_entidad, pre091.cod_estado, pre091.estado, bien001.cod_municipio,bien001.ci_contacto,pre093.nombre_municipio, bien001.cod_ciudad,bien001.cod_parroquia, pre094.nombre_ciudad, bien001.direccion_dep, bien001.cod_postal_dep, bien001.telefonos_dep, bien001.nombre_contacto  
    FROM bien001 bien001, pre091, pre092, pre093, pre094  WHERE bien001.cod_region = pre092.cod_region and bien001.cod_municipio = pre093.cod_municipio and bien001.cod_ciudad = pre094.cod_ciudad and bien001.cod_entidad = pre091.cod_estado and bien001.cod_dependencia>='".$cod_dependenciad."' and bien001.cod_dependencia<='".$cod_dependenciah."' 
    ORDER BY bien001.cod_dependencia, bien001.cod_region, bien001.cod_entidad, bien001.cod_municipio";

    if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
            $oRpt = new PHPReportMaker();
            $oRpt->setXML("Rpt_depen_repor_cata.xml");
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
			$this->Cell(80);
			$this->Cell(100,10,'CATALOGO DE DEPENDENCIAS',1,1,'C');
			$this->Ln(10);			
			$this->SetFont('Arial','B',8);	
			$this->Cell(15,4,'CODIGO','LT',0,'L');
			$this->Cell(100,4,'denominacion DEPENDENCIA','T',0,'L');
			$this->Cell(20,4,'COD. POSTAL','T',0,'C');
			$this->Cell(20,4,'TELEFONO','T',0,'C');
			$this->Cell(105,4,'RESPONSABLE','TR',1,'C');			
			$this->Cell(130,3,'   REGION','L',0,'L');
			$this->Cell(130,3,'ESTADO','R',1);			
			$this->Cell(130,3,'   MUNICIPIO','L',0,'L');
			$this->Cell(130,3,'CIUDAD','R',1);
			$this->Cell(260,3,'   DIRECCION','LRB',1,'L');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  $res=pg_query($sSQL); $i=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		$cod_dependencia=$registro["cod_dependencia"]; $denominacion_dep=$registro["denominacion_dep"]; $cod_region=$registro["cod_region"]; $cod_entidad=$registro["cod_entidad"]; $cod_municipio=$registro["cod_municipio"]; $cod_ciudad=$registro["cod_ciudad"]; $cod_parroquia=$registro["cod_parroquia"]; $direccion_dep=$registro["direccion_dep"]; 
        $cod_postal_dep=$registro["cod_postal_dep"]; $telefonos_dep=$registro["telefonos_dep"];$ci_contacto=$registro["ci_contacto"]; $nombre_contacto=$registro["nombre_contacto"]; $nombre_region=$registro["nombre_region"]; $estado=$registro["estado"]; $nombre_municipio=$registro["nombre_municipio"]; $nombre_ciudad=$registro["nombre_ciudad"]; //$nombre_parroquia=$registro["nombre_parroquia"];
	    if($php_os=="WINNT"){$denominacion_dep=$registro["denominacion_dep"]; }else{$denominacion_dep=utf8_decode($denominacion_dep); $direccion_dep=utf8_decode($direccion_dep);}
		$pdf->Cell(10,4,$cod_dependencia,0,0,'L');
		$pdf->Cell(105,4,$denominacion_dep,0,0,'L');
		$pdf->Cell(20,4,$cod_postal_dep,0,0,'L');
		$pdf->Cell(20,4,$telefonos_dep,0,0,'L');
		$pdf->Cell(105,4,$ci_contacto." ".$nombre_contacto,0,1,'L');		
		$pdf->Cell(5);
		$pdf->Cell(125,4,$cod_region." ".$nombre_region,0,0,'L');
		$pdf->Cell(125,4,$cod_entidad." ".$estado,0,1,'L');		
		$pdf->Cell(5);
		$pdf->Cell(125,4,$cod_municipio." ".$nombre_municipio,0,0,'L');
		$pdf->Cell(125,4,$cod_ciudad." ".$nombre_ciudad,0,1,'L');		
		$pdf->Cell(5);
		$pdf->Cell(255,4,$direccion_dep,0,1,'L');		
		$pdf->Ln(3);
	  }
      $pdf->Output();	
  }	  
}   
?>
