<?php include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS;
if (!$_GET){  $referencia_caus='';$tipo_causado='';$tipo_pago=''; $referencia_pago=''; $referencia_comp='';$tipo_compromiso=''; $cod_banco='';}
 else {  $referencia_caus=$_GET["txtreferencia_caus"];  $tipo_causado=$_GET["txttipo_causado"];  $referencia_comp = $_GET["txtreferencia_comp"];  $tipo_compromiso = $_GET["txttipo_compromiso"]; $cod_banco='';}

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else { $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){ $php_os="WINNT";}}
$l_cat=0;  $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); if ($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_cat=$registro["campo526"];$l_cat=strlen($formato_cat);} 
$sql="Select * from CAUSADOS where tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'" ;
  
$descripcion="";$fecha="";$nombre_abrev_caus="";$nombre_abrev_pago="";$nombre_abrev_comp="";$ced_rif="";$nombre="";$num_proyecto="";$des_proyecto="";$func_inv="";$genera_comprobante="";$inf_usuario="";$modulo="";$anulado="";
$res=pg_query($sql);$filas=pg_num_rows($res); $des_unidad_sol =""; $unidad_sol="";
if($filas>0){  $registro=pg_fetch_array($res);
  $referencia_caus=$registro["referencia_caus"];   $tipo_causado=$registro["tipo_causado"];   $referencia_comp=$registro["referencia_comp"];
  $tipo_compromiso=$registro["tipo_compromiso"];   $fecha=$registro["fecha_causado"];    $descripcion=$registro["descripcion_caus"];
  $inf_usuario=$registro["inf_usuario"];   $nombre_abrev_caus=$registro["nombre_abrev_caus"];   $nombre_abrev_comp=$registro["nombre_abrev_comp"];
  $ced_rif=$registro["ced_rif"];  $nombre=$registro["nombre"];   $num_proyecto=$registro["num_proyecto"];    $des_proyecto=$registro["des_proyecto"];
  $func_inv=$registro["func_inv"];   $genera_comprobante=$registro["genera_comprobante"];  $anulado=$registro["anulado"];  $modulo=$registro["modulo"];
} $sfecha=$fecha;
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="C"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
$clave=$tipo_causado.$referencia_caus.$tipo_compromiso.$referencia_comp;
$sql="Select * from pre002 WHERE tipo_compromiso='$tipo_compromiso'";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);$nombre_tipo_comp=$registro["nombre_tipo_comp"]; }

if($php_os=="WINNT"){$descripcion=$descripcion;}else{$descripcion=utf8_decode($descripcion); $nombre=utf8_decode($nombre);  $nombre_tipo_comp=utf8_decode($nombre_tipo_comp);  $des_unidad_sol=utf8_decode($des_unidad_sol); }	
$sql="SELECT * FROM codigos_causados where tipo_causado='$tipo_causado' and referencia_caus='$referencia_caus' and  referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' order by cod_presup";
$res=pg_query($sql); $filas=pg_num_rows($res);
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $referencia_comp; global $nombre_tipo_comp; global $des_unidad_sol; global $fecha; global $nombre; global $ced_rif; 
	   global $descripcion; global $tipo_compromiso; global $unidad_sol; global $referencia_caus; global $tipo_causado; global $nombre_abrev_caus;	global $Nom_Emp;		
        $this->rect(10,5,200,260);	
        $this->Image('../../imagenes/logo escudo.png',12,7,15);
		$this->SetFont('Arial','B',10);
		$this->Cell(25);
		$this->Cell(100,4,$Nom_Emp,0,0,'L');
		$this->Cell(75,4,'',0,1,'R');
		$this->Ln(5);
		$this->SetFont('Arial','B',13);
		$this->Cell(200,5,'REGISTRO DE CAUSADO',0,1,'C');
		$this->Ln(3);
		$this->SetFont('Arial','B',9);
		$this->Cell(33,6,'Referencia Causado:','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(25,6,$referencia_caus,'TB',0,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(37,6,'Documento Causado :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(45,6,$tipo_causado.' '.$nombre_abrev_caus,'TB',0,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(30,6,'Fecha Causado :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(30,6,$fecha,'TB',1,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(42,6,'Referencia Compromisos :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(25,6,$referencia_comp,'TB',0,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(43,6,'Documento Compromisos :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(45,6,$tipo_compromiso.' '.$nombre_tipo_comp,'TB',0,'L');
		$this->Cell(45,6,'','TB',1,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(37,6,'Cedula/Rif Beneficiario : ','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(20,6,$ced_rif,'TB',0,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(15,6,'Nombre : ','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(128,6,$nombre,'TB',1,'L');
		$this->SetFont('Arial','B',9);		
		$this->Cell(40,4,"POR CONCEPTO DE : ",0,1);
		$this->SetFont('Arial','',9);
        $this->MultiCell(200,3,$descripcion,0);
		$this->Cell(200,3,' ','B',1,'C');
		$this->Cell(40,4,'C�digo Presupuestario',1,0,'C');
		$this->Cell(140,4,'Denominaci�n C�digo Presupuestario',1,0,'C');
		$this->Cell(20,4,'Monto','TB',1,'C');
		$y=$this->GetY();
		$this->SetFillColor(255,0,0);		
		$this->SetFont('Arial','',8);
	}
	function Footer(){ global $total_comp; $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $total_c=formato_monto($total_comp); 
		$this->SetY(-45); $y=$this->GetY(); $l=$y-0.2; $p=$y+5.1;
		$this->SetFillColor(192,192,192);
		$this->SetFont('Arial','B',8);
		$this->Line(10,$l,210,$l);
		$this->Cell(180,5,'TOTAL ',0,0,'R');
		$this->Cell(19.8,5,$total_c,0,1,'R');
        $this->Line(10,$y,10,$y+5);	
        $this->Line(10,$p,210,$p);	
        $this->SetFont('Arial','',8);		
		$this->Cell(200,20,' ',0,1,'C');		
		$this->Cell(200,2,'__________________________________',0,1,'C');	
		$this->Cell(200,4,'FIRMA Y SELLO',0,1,'C');		
		$this->SetFillColor(255,0,0);
		$this->Ln(5);
		$this->SetFont('Arial','B',5);
		$this->Cell(100,3,'SIPAP CONTABILIDAD PRESUPUESTARIA',0,0,'L');
		$this->Cell(100,3,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
	}
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',8);
  $pdf->SetAutoPageBreak(true, 45);  
  $i=0; $total_comp=0;  $res=pg_query($sql);$filas=pg_num_rows($res);
  while($registro=pg_fetch_array($res)){ $i=$i+1;  
    $monto=formato_monto($registro["monto"]);  $denominacion=$registro["denominacion"];	
	if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}	
	$pdf->Cell(40,4,$registro["cod_presup"],0,0,'C'); 
	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=140; 	   
	$pdf->SetXY($x+$n,$y);
	$pdf->Cell(20,4,$monto,0,1,'R'); 
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(140,4,$denominacion,0); 
	$total_comp=$total_comp+$registro["monto"];
  }	
 $pdf->Output();
 pg_close($conn);
?> 