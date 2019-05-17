<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$criterio=$_GET["criterio"]; $criterio1="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";}   
$criterio = " where modulo='02'"; if ($_GET){if ($_GET["criterio"]!=""){  $txt_criterio = $_GET["criterio"]; $txt_criterio = strtoupper ($txt_criterio);
$criterio = " where modulo='02' and (usuario_sia like '%" . $txt_criterio . "%' or descrip_doc like '%" . $txt_criterio . "%' or operacion like '%" . $txt_criterio . "%')";    }}
if ($_GET["fechaop"]!=""){ $tfecha=$_GET["fechaop"]; $tfecha=formato_aaaammdd($tfecha); $criterio=$criterio . " and fecha_op>='$tfecha'"; }
$sql="SELECT * FROM SIA004 ".$criterio; $res=pg_query($sql);

require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
		    function Header(){ global $criterio1; global $Nom_Emp;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'MOVIMIENTOS DE AUDITORIA',1,0,'C');
				$this->Ln(20);				
				$this->SetFont('Arial','B',8);	                
			    $this->Cell(23,5,'Usuario',1,0);
			    $this->Cell(15,5,'Fecha',1,0,'C');						
			    $this->Cell(12,5,'Hora',1,0,'L');	
			    $this->Cell(15,5,'Fecha Doc.',1,0,'C');
			    $this->Cell(15,5,'Operacion',1,0,'C');
			    $this->Cell(120,5,'Descripcion',1,1,'C'); 
                
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
		  $pdf->SetFont('Arial','',7);
		  $i=0;  
		  while($registro=pg_fetch_array($res)){ $i=$i+1;
		    $descripcion=$registro["descrip_doc"]; $sfecha=$registro["fecha_op"];    $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
            $sfecha=$registro["fecha_doc"];   $fechad = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
			$hora=substr($registro["hora_op"],0,8);
		    $pdf->Cell(23,3,$registro["usuario_sia"],0,0,'L');
			$pdf->Cell(15,3,$fecha,0,0,'L');
			$pdf->Cell(12,3,$hora,0,0,'L');
			$pdf->Cell(15,3,$fechad,0,0,'L');
			$pdf->Cell(15,3,$registro["operacion"],0,0,'L');
			$x=$pdf->GetX();   $y=$pdf->GetY(); $n=120;
		    $pdf->SetXY($x,$y);
			$pdf->MultiCell($n,3,$descripcion,0);
		  }
		  
		  $pdf->Output();

}