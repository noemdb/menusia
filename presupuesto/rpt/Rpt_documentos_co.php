<?  include ("../../class/conect.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
if ($_GET){$tipo_comp_d=$_GET["tipo_comp_d"];$tipo_comp_h=$_GET["tipo_comp_h"];$tipo_rep=$_GET["tipo_rep"];}else{$tipo_comp_d="";$tipo_comp_h="zzzz";$tipo_rep="HTML";}  $criterio1="";$php_os=PHP_OS;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");   $date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} 
   $sSQL = "select tipo_compromiso, nombre_tipo_comp, nombre_abrev_comp from pre002 where pre002.tipo_compromiso>='".$tipo_comp_d."' and pre002.tipo_compromiso<='".$tipo_comp_h."' order by tipo_compromiso";

if($tipo_rep=="HTML"){	 include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Catalogo_de_Documentos_Comp.xml");
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
			$this->Cell(150,10,'CATALOGO DE DOCUMENTOS DE COMPROMISOS',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',10);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);	
			$this->Cell(15,5,'TIPO',1,0,'L');
			$this->Cell(160,5,'NOMBRE DOCUMENTO',1,0,'L');
			$this->Cell(25,5,'NOMBRE ABREV.',1,1,'L');
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
		$tipo_compromiso=$registro["tipo_compromiso"]; $nombre_tipo_comp=$registro["nombre_tipo_comp"]; $nombre_abrev_comp=$registro["nombre_abrev_comp"];  
                if($php_os=="WINNT"){$nombre_tipo_comp=$registro["nombre_tipo_comp"]; }else{$nombre_tipo_comp=utf8_decode($nombre_tipo_comp);}
		   $pdf->Ln(2);
		   $pdf->Cell(15,3,$tipo_compromiso,0,0,'L'); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $n=160;	   
		   $pdf->SetXY($x+$n,$y);
	   	   $pdf->Cell(25,3,$nombre_abrev_comp,0,1,'L');
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($n,3,$nombre_tipo_comp,0);
         	   } 
		$pdf->Cell(200,3,'',0,1,'L');	
		$pdf->Cell(50,3,'',0,0,'L');			 
		$pdf->Output();  pg_close(); 
    }	  
if($tipo_rep=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Catalogo_Documentos_Compromisos.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		<td width="100" align="left" ><strong></strong></td>
                <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CATALOGO DE DOCUMENTOS COMPROMISOS</strong></font></td>
	      </tr>
	      <tr height="20">
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>TIPO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>NOMBRE DOCUMENTO</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>NOMBRE ABREV.</strong></td>
         </tr>
     <?	  
	  $i=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		$tipo_compromiso=$registro["tipo_compromiso"]; $nombre_tipo_comp=$registro["nombre_tipo_comp"]; $nombre_abrev_comp=$registro["nombre_abrev_comp"];
		$nombre_tipo_comp=conv_cadenas($nombre_tipo_comp,0);  
	?>	   
	<tr>
           <td width="100" align="left">'<? echo $tipo_compromiso; ?></td>
           <td width="400" align="left"><? echo $nombre_tipo_comp; ?></td>
           <td width="100" align="left">'<? echo $nombre_abrev_comp; ?></td>
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
