<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$tipo_pagod=$_GET["tipo_pagod"];$tipo_pagoh=$_GET["tipo_pagoh"];$tipo_rep=$_GET["tipo_rep"];}else{$tipo_pagod="";$tipo_pagoh="zzzz";$tipo_rep="HTML";} $php_os=PHP_OS;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");  $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} 
     $sSQL = "select tipo_pago, nombre_tipo_pago, refierea, afecta_presup from pre004 where pre004.tipo_pago>='".$tipo_pagod."' and pre004.tipo_pago<='".$tipo_pagoh."' order by tipo_pago";

if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php"); 
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Catalogo_de_Documentos_Pag.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1,"date"=>$date,"hora"=>$hora));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run(); 
		}
if($tipo_rep=="PDF"){	 
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(150,10,'CATALOGO DOCUMENTOS PAGOS',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(10,3,'','LT',0,'L');
			$this->Cell(140,3,'','T',0,'L');				
			$this->Cell(25,3,'REFIERE','T',0,'L');
			$this->Cell(25,3,'AFECTA','RT',1,'L');

			$this->Cell(10,4,'TIPO','LB',0,'L');
			$this->Cell(140,4,'NOMBRE DOCUMENTO','B',0,'L');				
			$this->Cell(25,4,'A CAUSADO','B',0,'L');
			$this->Cell(25,4,'PRESUPUESTO','RB',1,'L');
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
		$tipo_pago=$registro["tipo_pago"]; $nombre_tipo_pago=$registro["nombre_tipo_pago"]; $refierea=$registro["refierea"]; $afecta_presup=$registro["afecta_presup"];  
                if($php_os=="WINNT"){$nombre_tipo_pago=$registro["nombre_tipo_pago"]; }else{$nombre_tipo_pago=utf8_decode($nombre_tipo_pago);}
		   $pdf->Ln(2);
		   $pdf->Cell(10,3,$tipo_pago,0,0,'L'); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $n=140;	   
		   $pdf->SetXY($x+$n,$y);
	   	   $pdf->Cell(25,3,$refierea,0,0,'L');
	   	   $pdf->Cell(25,3,$afecta_presup,0,1,'C');
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($n,3,$nombre_tipo_pago,0);
         	   } 
		$pdf->Cell(200,3,'',0,1,'L');	
		$pdf->Cell(50,3,'',0,0,'L');			 
		$pdf->Output();   
    }	  
if($tipo_rep=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Catalogo_Documentos_Pagos.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		<td width="100" align="left" ><strong></strong></td>
                <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CATALOGO DE DOCUMENTOS PAGOS</strong></font></td>
	      </tr>
	      <tr height="20">
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>TIPO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>NOMBRE DOCUMENTO</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>REFIERE A CAUSADO</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>AFECTA PRESUPUESTO</strong></td>
         </tr>
     <?	  
	  $i=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		$tipo_pago=$registro["tipo_pago"]; $nombre_tipo_pago=$registro["nombre_tipo_pago"]; $refierea=$registro["refierea"]; $afecta_presup=$registro["afecta_presup"];
		$nombre_tipo_pago=conv_cadenas($nombre_tipo_pago,0);  
	?>	   
	<tr>
           <td width="100" align="left">'<? echo $tipo_pago; ?></td>
           <td width="400" align="left"><? echo $nombre_tipo_pago; ?></td>
           <td width="100" align="left">'<? echo $refierea; ?></td>
           <td width="100" align="left">'<? echo $afecta_presup; ?></td>
         </tr>
	<? }  
        ?>
	   <tr>
            <td>&nbsp;</td>
           </tr>
	  <tr>
                <td width="100" align="center"></td>
		<td width="400" align="left"><strong></strong></td>	
            </tr>      
	  </table><?
	}

   }
?>
