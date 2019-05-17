<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$codigo_departamento_d=$_GET["codigo_departamento_d"];   $codigo_departamento_h=$_GET["codigo_departamento_h"]; $tipo_rpt=$_GET["tipo_rpt"]; $php_os=PHP_OS; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}}
  $sSQL = "SELECT codigo_departamento,descripcion_dep  FROM nom005 where nom005.codigo_departamento>='$codigo_departamento_d' and nom005.codigo_departamento<='$codigo_departamento_h'  ORDER BY codigo_departamento";
  if($tipo_rpt=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
	  $oRpt = new PHPReportMaker();
	  $oRpt->setXML("Catalogo_depart_cata_re.xml");
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
			$this->Cell(100,10,'CATALOGO DE DEPARTAMENTOS',1,0,'C');
			$this->Ln(18);
			$this->SetFont('Arial','B',8);
			$this->Cell(20,5,'CODIGO',1,0,'L');
			$this->Cell(180,5,'DESCRIPCION DEPARTAMENTO',1,1,'L');
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
		   $codigo_departamento=$registro["codigo_departamento"]; $descripcion_dep=$registro["descripcion_dep"]; $cantidad=$cantidad+1; 
           if($php_os=="WINNT"){$descripcion_dep=$registro["descripcion_dep"]; }else{$descripcion_dep=utf8_decode($descripcion_dep);}
		   $pdf->Cell(20,4,$codigo_departamento,0,0,'L'); 		   
		   $pdf->Cell(180,4,$descripcion_dep,0,1,'L');
	  } 
		$pdf->Cell(200,5,'',0,1,'L');	
		$pdf->Cell(50,5,'CANTIDAD DEPARTAMENTOS : '.$cantidad,0,0,'L');			 
		$pdf->Output();   
    }	  
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Catalago_Departamentos.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CATALOGO DE DEPARTAMENTOS</strong></font></td>
	      </tr>
	      <tr height="20">
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><strong>CODIGO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>DESCRIPCION DEPARTAMENTO</strong></td>
         </tr>
     <?	  
	  $i=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
	     $codigo_departamento=$registro["codigo_departamento"]; $descripcion_dep=$registro["descripcion_dep"]; $cantidad=$cantidad+1; 
		 $descripcion_dep=conv_cadenas($descripcion_dep,0);  
	   ?>	   
	    <tr>
           <td width="100" align="left">'<? echo $codigo_departamento; ?></td>
           <td width="400" align="left"><? echo $descripcion_dep; ?></td>
         </tr>
	<? }  
        ?>
	   <tr>
            <td>&nbsp;</td>
        </tr>
	    <tr>
             <td width="100" align="center"></td>
		    <td width="400" align="left"><strong>CANTIDAD DEPARTAMENTOS: <? echo $cantidad; ?></strong></td>	
        </tr>      
	  </table><?
	}

   }
?>
