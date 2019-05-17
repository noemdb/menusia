<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){$cod_banco='';$num_cheque=''; }  else{$cod_banco=$_GET["cod_banco"];$num_cheque=$_GET["num_cheque"];}  $fecha_hoy=asigna_fecha_hoy(); 
$sql="Select * from EDO_CHEQUES where cod_banco='$cod_banco' and num_cheque='$num_cheque'";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos; .</b></p>"; exit; }
$nombre_banco="";$nro_cuenta="";$concepto="";$num_cheque=""; $nro_orden=""; $nombre_benef=""; $ced_rif=""; $concepto=""; $monto_cheque=0; $fecha=""; $mes=""; $inf_usuario=""; $anulado="N";  $fecha_anulado="";  $tipo_pago=""; $edo_cheque=""; $entregado="N";$fecha_entregado="";$ced_rif_recib="";$nombre_recib="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"];  $fecha_anulado=$registro["fecha_anulado"]; $tipo_pago=$registro["tipo_pago"];
  $concepto=$registro["concepto"]; $num_cheque=$registro["num_cheque"];  $fecha=$registro["fecha"]; $sfecha=$registro["fecha"];  $nro_orden=$registro["nro_orden_pago"]; $monto_cheque=$registro["monto_cheque"];  $ced_rif=$registro["ced_rif"];
  $nombre_benef=$registro["nombre"];  $entregado=$registro["entregado"]; $fecha_entregado=$registro["fecha_entregado"];$ced_rif_recib=$registro["ced_rif_recib"];$nombre_recib=$registro["nombre_recib"];  $inf_usuario=$registro["inf_usuario"];
} $tipo_comp="B".$cod_banco;
$sql="select * from sia001 where campo101='$usuario_comp'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];}
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $Nom_Emp;  global $cod_banco; global $num_cheque; global $tipo_mov; global $des_tipo_mov; global $monto_mov_libro;
			    global $fecha; global $nombre_banco; global $nro_cuenta; global $concepto; global $nombre_benef; global $ced_rif;	    
        $this->Image('../../imagenes/logo escudo.png',12,8,13);
		$this->rect(10,5,200,267);
		$this->SetFont('Arial','B',10);
		$this->Cell(20);
		$this->Cell(150,5,$Nom_Emp,0,0,'L');
		$this->SetFont('Arial','B',7);
		$this->Cell(30,5,'Pagina '.$this->PageNo(),0,1,'R');
		$this->SetFont('Arial','B',13);
		$this->Cell(40);
		$this->Cell(130,10,'RELACION ANEXA CHEQUES ',0,0,'C');
		$this->Ln(10);							
		$this->SetFont('Arial','B',9);
		$this->Cell(16,6,'CHEQUE :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(18,6,$num_cheque,'TB',0,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(18,6,'BANCO :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(148,6,$nombre_banco." ".$nro_cuenta,'TB',1,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(24,6,'BENEFICIARIO: ','TB',0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(132,6,$nombre_benef,'TB',0,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(22,6,'CEDULA/RIF : ','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(22,6,$ced_rif,'TB',1,'L');		
		//$this->SetFont('Arial','B',9);
		//$this->Cell(40,4,"POR CONCEPTO DE : ",0,1);
		//$this->SetFont('Arial','',9);
		//$this->MultiCell(200,3,$concepto,0);
		//$this->Cell(200,3,' ','B',1,'C');
		$this->SetFont('Arial','B',12);
        	$this->Cell(200,5,'CONTIBILIDAD FINANCIERA/FISCAL',1,1,'C');		
		$this->SetFont('Arial','',8);
		$this->Cell(30,5,'CODIGO CUENTA',1,0,'C');
		$this->Cell(130,5,'NOMBRE CUENTA',1,0,'C');	
		$this->Cell(20,5,'DEBE',1,0,'C');
		$this->Cell(20,5,'HABER',1,1,'C');
	}	
	function Footer(){$ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		$this->SetY(-10);
		$this->Ln(5);
		$this->SetFont('Arial','I',5);
		$this->Cell(50,5,'SIA Control Bancario',0,1,'L');
	} 
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $pdf->SetAutoPageBreak(true, 10);  
  $i=0;    $total_columna1=0; $total_columna2=0; 
  $sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$num_cheque' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
  $res=pg_query($sql);$filas=pg_num_rows($res);
  while(($registro=pg_fetch_array($res))and($error==0)){ $monto_a=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_a); $codigo_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"];
             if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";$total_columna1=$total_columna1+$monto_a;}else{$debe="";$haber=$monto_asiento; $total_columna2=$total_columna2+$monto_a;}
             if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"];}else{$nombre_cuenta=utf8_decode($registro["nombre_cuenta"]); } 		     
			 $pdf->SetFont('Arial','',8);	
		   	 $pdf->Cell(30,4,$codigo_cuenta,0,0);
			 $x=$pdf->GetX();   $y=$pdf->GetY(); $n=130; 			   
			 $pdf->SetXY($x+$n,$y);
			 $pdf->Cell(20,4,$debe,0,0,'R');
             $pdf->Cell(20,4,$haber,0,1,'R'); 				
			 $pdf->SetXY($x,$y);
			 $pdf->MultiCell($n,4,$nombre_cuenta,0); 
  }
  $total_columna1=formato_monto($total_columna1);  $total_columna2=formato_monto($total_columna2);
  $pdf->Cell(200,2,'',0,1,'R');
  $y=$pdf->GetY();
  $pdf->Line(165,$y-0.2,210,$y-0.2);
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(160,4,'TOTAL Bs.',0,0,'R');
  $pdf->Cell(20,4,$total_columna1,0,0,'R');
  $pdf->Cell(20,4,$total_columna2,0,1,'R');
 $pdf->Output();
 pg_close();
?>

