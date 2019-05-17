<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS;
if (!$_GET){ $referencia_dife=''; $tipo_diferido='';} else{$referencia_dife=$_GET["txtreferencia_dife"]; $tipo_diferido=$_GET["txttipo_diferido"];}
   $sql="Select * from DIFERIDOS where tipo_diferido='$tipo_diferido' and referencia_dife='$referencia_dife'"; $rif_emp=""; $total_comp=0; $nombre="";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else { $Nom_Emp=busca_conf(); }
if($utf_rpt=="SI"){ $php_os="WINNT";} 
$descripcion="";$fecha="";$nombre_abrev_dife="";$inf_usuario=""; $nombre_tipo_dife="";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);   $referencia_dife=$registro["referencia_dife"];$fecha=$registro["fecha_diferido"];  $tipo_diferido=$registro["tipo_diferido"]; $descripcion=$registro["descripcion_dife"];  $inf_usuario=$registro["inf_usuario"]; $nombre_abrev_dife=$registro["nombre_abrev_dife"];}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
$sSQL="Select * from pre024 WHERE tipo_diferido='$tipo_diferido'";     $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
if ($filas>0){$registro=pg_fetch_array($resultado);  $nombre_tipo_dife=$registro["nombre_tipo_dife"]; }
$sql="SELECT * FROM CODIGOS_DIFERIDOS where referencia_dife='$referencia_dife' and tipo_diferido='$tipo_diferido' order by cod_presup";
if($php_os=="WINNT"){$descripcion=$descripcion;}else{$descripcion=utf8_decode($descripcion); $nombre_tipo_dife=utf8_decode($nombre_tipo_dife);   }	
$nombre=utf8_decode($nombre);
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $referencia_dife; global $nombre_tipo_dife; global $fecha;   global $descripcion; global $tipo_diferido; global $unidad_sol; global $php_os;	global $Nom_Emp;	
        $this->rect(10,5,200,260);		
		$this->Image('../../imagenes/logo escudo.png',12,6,18);
		$this->SetFont('Arial','B',9);
		$this->Cell(25);
		$this->Cell(140,3,$Nom_Emp,0,0,'L');
		$this->Cell(35,3,'Pagina '.$this->PageNo().'/{nb}',0,1,'R');
		$this->Ln(5);
		$this->SetFont('Arial','B',10);
		$this->Cell(200,3,'REGISTRO DE DIFERIDO PRESUPUESTARIO Nro. '.$referencia_dife,0,1,'C');
		$this->Ln(4);		
		$this->SetFont('Arial','',7);
        $this->SetFillColor(192,192,192);
		$this->Cell(150,3,'TIPO DE DIFERIDO',1,0,'C',true);		
		$this->Cell(50,3,'FECHA',1,1,'C',true);	
		$this->Cell(150,4,$tipo_diferido." ".$nombre_tipo_dife,1,0,'C');		
		$this->Cell(50,4,$fecha,1,1,'C');        
		$this->Cell(200,3,'CONCEPTO',1,1,'C',true);
		$this->MultiCell(200,3,$descripcion,0);		
		$this->Cell(200,3,' ',0,1,'C');
		$this->Cell(200,3,'CONTABILIDAD PRESUPUESTARIA',1,1,'C',true);		
		$this->Cell(40,3,'CODIGO',1,0,'C',true);
		$this->Cell(140,3,'DENOMINACION',1,0,'C',true);
		$this->Cell(20,3,'MONTO',1,1,'C',true);
		$y=$this->GetY();
		$this->SetFillColor(255,0,0);
		$this->Line(50,$y,50,235);
		$this->Line(190,$y,190,235);
	}
	function Footer(){ global $total_comp; $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $total_c=formato_monto($total_comp); 
		$this->SetY(-45); $y=$this->GetY(); $l=$y-0.2; $p=$y+5.1;
		$this->SetFillColor(192,192,192);
		$this->SetFont('Arial','B',7);
		$this->Line(10,$l,210,$l);
		$this->Cell(180,5,'TOTAL ',0,0,'R',true);
		$this->Cell(19.8,5,$total_c,0,1,'R',true);
        $this->Line(10,$y,10,$y+5);	
        $this->Line(10,$p,210,$p);		
		$this->Cell(200,15,' ',0,1,'C');		
		$this->Cell(100,2,'_____________________________',0,0,'C');
		$this->Cell(100,2,'_____________________________',0,1,'C');		
		$this->Cell(100,4,'ELABORADO POR',0,0,'C');
		$this->Cell(100,4,'APROBADO',0,1,'C');		
		$this->SetFillColor(255,0,0);
		$this->Ln(5);
		$this->SetFont('Arial','B',5);
		$this->Cell(100,4,'',0,0,'L');
		$this->Cell(100,4,'SIA CONTABILIDAD PRESUPUESTARIA',0,1,'R');
	}
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $pdf->SetAutoPageBreak(true, 45);  
  $i=0;  $res=pg_query($sql);$filas=pg_num_rows($res);
  while($registro=pg_fetch_array($res)){ $i=$i+1;  
    $monto=formato_monto($registro["monto_diferido"]);  $denominacion=$registro["denominacion"];	
	if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}	
	$pdf->Cell(40,4,$registro["cod_presup"],0,0,'C'); 
	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=140; 	   
	$pdf->SetXY($x+$n,$y);
	$pdf->Cell(20,4,$monto,0,1,'R'); 
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(140,4,$denominacion,0); 
	$total_comp=$total_comp+$registro["monto_diferido"];
  }	
 $pdf->Output();
 pg_close();
?> 