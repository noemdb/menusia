<? include ("../../class/seguridad.inc"); include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$tipo_nomina_d=$_GET["tipo_nomina_d"];   $tipo_nomina_h=$_GET["tipo_nomina_h"]; $tipo_rpt=$_GET["tipo_rpt"]; $php_os=PHP_OS; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); $date=date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
  $sSQL = "select tipo_nomina,descripcion,frecuencia,ultima_fecha,redondear, to_char(ultima_fecha,'DD/MM/YYYY') as fecham from nom001 order by tipo_nomina";	  
  if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML("Catalogo_tip_nomi_cata_re.xml");
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
			$this->Cell(100,10,'CATALOGO TIPOS DE NOMINAS',1,0,'C');
			$this->Ln(18);
			$this->SetFont('Arial','B',8);
			$this->Cell(10,5,'TIPO',1,0,'L');
			$this->Cell(128,5,'DESCRIPCION',1,0,'L');
			$this->Cell(20,5,'FRECUENCIA',1,0,'C');
			$this->Cell(22,5,'ULTIMA FECHA',1,0,'C');
			$this->Cell(20,5,'REDONDEAR',1,1,'C');
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
	  $i=0; $cantidad=0;	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cantidad=$cantidad+1; 
		   $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $frecuencia=$registro["frecuencia"]; $fecham=$registro["fecham"]; $redondear=$registro["redondear"]; 
           if($php_os=="WINNT"){$descripcion=$registro["descripcion"]; }else{$descripcion=utf8_decode($descripcion);} $des_frec=$frecuencia;
		   if($frecuencia=="Q"){$des_frec="QUINCENAL";} if($frecuencia=="S"){$des_frec="SEMANAL";} if($frecuencia=="M"){$des_frec="MENSUAL";}
		   $pdf->Cell(10,4,$tipo_nomina,0,0,'L'); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=128;		   
		   $pdf->SetXY($x+$w,$y);
           $pdf->Cell(20,4,$des_frec,0,0,'C'); 		   
		   $pdf->Cell(22,4,$fecham,0,0,'C'); 
		   $pdf->Cell(20,4,$redondear,0,1,'C'); 
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($w,4,$descripcion,0); 
		} 
		$pdf->Cell(200,3,'',0,1,'L');	
		$pdf->Cell(50,3,'TIPOS DE NOMINA :'.$cantidad,0,0,'L');			 
		$pdf->Output();   
    }	  
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Catalago_Tipo_Nomina.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	      <tr height="20">
		       <td width="100" align="left" ><strong></strong></td>
               <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CATALOGO TIPOS DE NOMINA</strong></font></td>
	      </tr>
	      <tr height="20">
	      </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><strong>TIPO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>DESCRIPCION</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>FRECUENCIA</strong></font></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>ULTIMA FECHA</strong></font></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>REDONDEAR</strong></font></td>
         </tr>
     <?	  
	  $i=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cantidad=$cantidad+1; 
		   $tipo_nomina=$registro["tipo_nomina"]; $descripcion=$registro["descripcion"]; $frecuencia=$registro["frecuencia"]; $fecham=$registro["fecham"]; $redondear=$registro["redondear"]; 
           $descripcion=conv_cadenas($descripcion,0);  
	?>	   
	    <tr>
           <td width="100" align="left"><? echo $tipo_nomina; ?></td>
           <td width="400" align="left"><? echo $descripcion; ?></td>
           <td width="100" align="center"><? echo $frecuencia; ?></td>
           <td width="100" align="center"><? echo $fecham; ?></td>
           <td width="100" align="center"><? echo $redondear; ?></td>
         </tr>
	<? }?>
	   <tr>
            <td>&nbsp;</td>
       </tr>
	   <tr>
            <td width="100" align="center"></td>
		    <td width="400" align="left"><strong>TIPOS NOMINA : <? echo $cantidad; ?></strong></td>	
       </tr>      
	  </table><?
	}
}
?>
