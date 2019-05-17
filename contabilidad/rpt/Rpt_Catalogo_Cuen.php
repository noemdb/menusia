<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$codigod=$_GET["cod_cuenta_d"];$codigoh=$_GET["cod_cuenta_h"]; $tipo_rpt=$_GET["tipo_rpt"];}else{$codigod="";$codigoh="";$tipo_rpt="PDF";} $Sql="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } $efiscal=substr($Fec_Fin_Ejer,0, 4);   $criterio1="EJERCICIO FISCAL: ".$efiscal;
  $sSQL = "select codigo_cuenta,nombre_cuenta,cargable,tsaldo from con001 WHERE codigo_cuenta>='".$codigod."' and codigo_cuenta<='".$codigoh."' order by codigo_cuenta";
  if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML("Catalogo_de_Cuentas.xml");
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
  if($tipo_rpt=="PDF"){	 
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,'CATALOGO DE CUENTAS',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);	
			$this->Cell(30,5,'CODIGO',1,0,'L');
			$this->Cell(130,5,'NOMBRE',1,0,'L');
			$this->Cell(20,5,'CARGABLE',1,0,'C');
			$this->Cell(20,5,'TP SALDO',1,1,'C');
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
	  while($registro=pg_fetch_array($res)){ $i=$i+1;$codigo_cuenta=$registro["codigo_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; $cargable=$registro["cargable"]; $tsaldo=$registro["tsaldo"];  
           if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta);}
		   $pdf->Cell(30,4,$codigo_cuenta,0,0,'L'); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=130;		   
		   $pdf->SetXY($x+$w,$y);
           $pdf->Cell(20,4,$cargable,0,0,'C'); 		   
		   $pdf->Cell(20,4,$tsaldo,0,1,'C'); 
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($w,4,$nombre_cuenta,0); 
		   } 
					 
		$pdf->Output();   
    }	  
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Catalago_Cuentas.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		      <td width="100" align="left" ><strong></strong></td>
              <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CATALOGO DE CUENTAS</strong></font></td>
	     </tr>
	     <tr height="20">
		    <td width="100" align="left" ><strong><? echo $criterio1; ?></strong></td>
            <td width="400" align="center" > <strong></font></td>
		 </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><strong>TIPO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>NOMBRE DE LA CUENTA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>CARGABLE</strong></font></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>TP SALDO</strong></font></td>
         </tr>
     <?	  
	  $i=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;	$codigo_cuenta=$registro["codigo_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; $cargable=$registro["cargable"]; $tsaldo=$registro["tsaldo"];  
		$nombre_cuenta=conv_cadenas($nombre_cuenta,0);  
	?>	   
	   <tr>
           <td width="100" align="left">'<? echo $codigo_cuenta; ?></td>
           <td width="400" align="left"><? echo $nombre_cuenta; ?></td>
           <td width="100" align="center"><? echo $cargable; ?></td>
           <td width="100" align="center"><? echo $tsaldo; ?></td>
         </tr>
	<? }  
        ?>
	   <tr><td>&nbsp;</td>  </tr>	       
	  </table><?
	}
}
?>
