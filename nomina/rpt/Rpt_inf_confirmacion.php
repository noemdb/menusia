<?include("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;  error_reporting(E_ALL ^ E_NOTICE); 
if (!$_GET){ $cod_estructura='';} else{$cod_estructura=$_GET["cod_estructura"];} 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else { $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } } 
$descripcion_est="";$ced_rif_est="";$fecha_desde_est="";$fecha_hasta_est="";
$sql="Select * from ESTRUCTURA_ORD where cod_estructura='$cod_estructura'"; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){ $registro=pg_fetch_array($res,0);
  $cod_estructura=$registro["cod_estructura"];  $descripcion_est=$registro["descripcion_est"];  $ced_rif_est=$registro["ced_rif_est"];  $fecha_desde_est=$registro["fecha_desde_est"];
  $fecha_hasta_est=$registro["fecha_hasta_est"];  $tipo_documento=$registro["tipo_documento"];  $nro_documento=$registro["nro_documento"];  $cod_tipo_ord=$registro["cod_tipo_ord"];
  $concepto_est=$registro["concepto_est"];  $nombre=$registro["nombre"];  $des_tipo_orden=$registro["des_tipo_orden"];  $inf_usuario=$registro["inf_usuario"];}
if($fecha_desde_est==""){$fecha_desde_est="";}else{$fecha_desde_est=formato_ddmmaaaa($fecha_desde_est);}
if($fecha_hasta_est==""){$fecha_hasta_est="";}else{$fecha_hasta_est=formato_ddmmaaaa($fecha_hasta_est);}

$sql="SELECT * FROM COD_ESTRUCTURA  where cod_estructura='$cod_estructura' order by tipo_comp_est,ref_comp_est,cod_presup_est,fuente_est"; $res=pg_query($sql); $total=0;
while($registro=pg_fetch_array($res)){ $total=$total+$registro["monto_est"]; }
$sql="SELECT * FROM RET_ESTRUCTURA  where cod_estructura='$cod_estructura' order by tipo_ret,tipo_comp_est,ref_comp_est,cod_presup_est,fuente_est,ref_imput_presu";$res=pg_query($sql);$total_ret=0;
while($registro=pg_fetch_array($res)){ $total_ret=$total_ret+$registro["monto_ret"]; }
$monto_neto=$total-$total_ret;
$total=formato_monto($total); $total_ret=formato_monto($total_ret); $monto_neto=formato_monto($monto_neto);

require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){ global $Nom_Emp; global $cod_estructura; global $descripcion_est;
	    $this->Image('../../imagenes/logo_emp.png',10,4,20);
		$this->SetFont('Arial','',7);
		$this->Cell(20,4,'',0,0,'L');
		$this->Cell(150,4,$Nom_Emp,0,1,'L');
		$this->SetFont('Arial','',7);
		$this->Cell(20,4,'',0,0,'L');
		$this->Cell(90,4,'SIA Nómina y Personal',0,1,'L'); 
		$this->Ln(5);
		$this->SetFont('Arial','B',12);
		$this->Cell(25);
		$this->Cell(150,10,'INFORME DE CONFIRMACIÓN  GENERACIÓN ORDEN DE PAGO DE NÓMINA',0,1,'C');
		$this->Ln(10);
		$this->SetFont('Arial','',10);
		$this->Cell(55,6,'CÓDIGO ESTRUCTURA O/P :',0,0,'L');		
		$this->Cell(145,6,$cod_estructura,0,1,'L');
		$this->Cell(65,6,'DESCRIPCIÓN ESTRUCTURA O/P :',0,0,'L');
		$this->Cell(135,6,$descripcion_est,0,1,'L');
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
	$pdf->Cell(200,6,'FECHA DE PROCESO NÓMINA DESDE : '.$fecha_desde_est.'         HASTA: '.$fecha_hasta_est,0,1,'L');	
	$pdf->Ln(5);
	$pdf->Cell(200,6,'MONTO DE CÓDIGOS PRESUPUESTARIOS  :   '.$total,0,1,'L');
    $pdf->Ln(5);
	$pdf->Cell(200,6,'MONTO DE RETENCIONES :   '.$total_ret,0,1,'L');	
	$pdf->Ln(5);
	$pdf->Cell(200,6,'MONTO NETO :   '.$monto_neto,0,1,'L');
    $pdf->Ln(35);
    $pdf->Cell(65,6,'',0,0,'L');
    $pdf->Cell(65,6,'Por Recursos Humanos ','T',1,'C');	
	$pdf->Output();
	$pg_close();
?>
	  	
		