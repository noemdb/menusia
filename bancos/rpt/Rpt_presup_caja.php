<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$periodo_d=$_GET["periodo_d"];$periodo_h=$_GET["periodo_h"]; $Sql="";$date = date("d-m-Y"); $hora = date("H:i:s a"); 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ echo "OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS","<br>"; }
else{   $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){ $php_os="WINNT";} 
    $ano=substr($Fec_Fin_Ejer,0,4);
	$fecha_d="01-".$periodo_d."-".$ano; $fecha_H="01-".$periodo_h."-".$ano; $fecha_h=colocar_udiames($fecha_d); $fecha_1=formato_aaaammdd($fecha_d);  $fecha_2=formato_aaaammdd($fecha_h);
	$criterio1="DESDE : ".$fecha_d." HASTA : ".$fecha_d;
	$sSQL = "SELECT ban016.periodo,ban016.linea,ban016.consecutivo,ban016.descripcion,ban016.monto,ban016.acumulado,ban016.operacion,ban016.status  from ban016 where ban016.periodo>='$periodo_d' and  ban016.periodo<='$periodo_h' order by ban016.linea ";

    	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 
		function Header(){ global $criterio1;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(150,10,'PRESUPUESTO DE CAJA',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',11);
			$this->Cell(200,10,$criterio1,0,1,'C');	
			$this->SetFont('Arial','B',10);
			$this->Cell(170,5,'DENOMINACION',1,0);
			$this->Cell(30,5,'MONTO',1,1,'C');
			$this->Ln(5);
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
	  $pdf->SetFont('Arial','',10);
	  $i=0;  $total=0; $prev_tipo_bco=""; $prev_desc=""; $subtotal=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $descripcion=$registro["descripcion"]; $operacion=$registro["operacion"]; $status=$registro["status"];
           $monto=$registro["monto"];	$acumulado=$registro["acumulado"];
		   if($monto==0){$monto="";}else{ $monto=formato_monto($monto); }
		   $pdf->SetFont('Arial','',10);
		   if (($status=="T") or ($status=="S") or ($status=="G") or  (($status=="M") and ($operacion== "S")) or  (($status=="M") and ($operacion=="F"))) 
		   { $pdf->SetFont('Arial','B',10); }
          
   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=170; 
		   if(($status=="M")and(($operacion<>"S")and($operacion<>"F"))){ $n=160; 
		     $pdf->Cell(10);
			 $x=$pdf->GetX();   $y=$pdf->GetY();
		   }
		   if($status=="T") { 
		    $pdf->Cell(170);
			$pdf->Cell(30,2,"__________________",0,1,'R');
			$pdf->Cell(50); $n=120; $x=$pdf->GetX();   $y=$pdf->GetY();
		   }
		   $pdf->SetXY($x+$n,$y);		   
		   $pdf->Cell(30,6,$monto,0,1,'R');
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,6,$descripcion,0); 
		} 
		$total=formato_monto($total); 
		$pdf->Output();   
   
}
?>