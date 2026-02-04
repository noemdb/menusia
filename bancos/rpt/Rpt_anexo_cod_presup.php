<?php include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){$cod_banco='';$num_cheque=''; }  else{$cod_banco=$_GET["cod_banco"];$num_cheque=$_GET["num_cheque"];}  $fecha_hoy=asigna_fecha_hoy(); 
$sql="Select * from EDO_CHEQUES where cod_banco='$cod_banco' and num_cheque='$num_cheque'";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos; .</b></p>"; exit; }
$nombre_banco="";$nro_cuenta="";$concepto="";$num_cheque=""; $nro_orden=""; $nombre_benef=""; $ced_rif=""; $concepto=""; $monto_cheque=0; $fecha=""; $mes=""; $inf_usuario=""; $anulado="N";  $fecha_anulado="";  $tipo_pago=""; $edo_cheque=""; $entregado="N";$fecha_entregado="";$ced_rif_recib="";$nombre_recib="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"];  $fecha_anulado=$registro["fecha_anulado"]; $tipo_pago=$registro["tipo_pago"];
  $concepto=$registro["concepto"]; $num_cheque=$registro["num_cheque"];  $fecha=$registro["fecha"]; $sfecha=$registro["fecha"];  $nro_orden=$registro["nro_orden_pago"]; $monto_cheque=$registro["monto_cheque"];  $ced_rif=$registro["ced_rif"];
  $nombre_benef=$registro["nombre"];  $entregado=$registro["entregado"]; $fecha_entregado=$registro["fecha_entregado"];$ced_rif_recib=$registro["ced_rif_recib"];$nombre_recib=$registro["nombre_recib"];  $inf_usuario=$registro["inf_usuario"];
}
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
        $this->Cell(200,5,'CONTABILIDAD PRESUPUESTARIA',1,1,'C');		
		$this->SetFont('Arial','',8);
		$this->Cell(40,4,'Codigo Presupuestario',1,0,'C');
		$this->Cell(130,4,'Denominacion',1,0,'C');		
		$this->Cell(30,4,'Monto',1,1,'C');
	}	
	function Footer(){$ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		$this->SetY(-10);
		$this->Ln(5);
		$this->SetFont('Arial','I',5);
		$this->Cell(50,5,'SIPAP Control Bancario',0,1,'L');
	} 
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $pdf->SetAutoPageBreak(true, 10);  
  $i=0;    $total_pre=0; 
  $sql="SELECT cod_presup,fuente_financ,denominacion,sum(monto) as monto_chq FROM codigos_pagos where referencia_pago='$num_cheque' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' group by cod_presup,fuente_financ,denominacion order by cod_presup,fuente_financ";
  $res=pg_query($sql);$filas=pg_num_rows($res);
  while(($registro=pg_fetch_array($res))and($error==0)){ $monto=formato_monto($registro["monto_chq"]); $total=$total+$registro["monto"]; $denominacion=$registro["denominacion"];
    $denominacion=substr($denominacion,0,80); if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}
	$pdf->Cell(40,4,$registro["cod_presup"]." ".$registro["fuente_financ"],0,0,'L');	
    $pdf->Cell(130,4,$denominacion,0,0,'L'); 		  
	$pdf->Cell(30,4,$monto,0,1,'R');
    $total_pre=$total_pre+$registro["monto_chq"];
  }
  $total_pre=formato_monto($total_pre);
  $pdf->Cell(200,2,'',0,1,'R');
  $y=$pdf->GetY();
  $pdf->Line(185,$y-0.2,210,$y-0.2);
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(175,4,'TOTAL Bs.',0,0,'R');
  $pdf->Cell(25,4,$total_pre,0,1,'R');
 $pdf->Output();
 pg_close($conn);
?>

