<?php include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS; error_reporting(E_ALL ^ E_NOTICE); 
if (!$_GET){ $referencia_ajuste=''; $tipo_ajuste=''; $tipo_pago=''; $referencia_pago='';} else{$referencia_ajuste=$_GET["txtreferencia_ajuste"]; $tipo_ajuste=$_GET["txttipo_ajuste"]; $tipo_pago=$_GET["txttipo_pago"]; $referencia_pago=$_GET["txtreferencia_pago"];
$referencia_caus=$_GET["txtreferencia_caus"];$tipo_causado=$_GET["txttipo_causado"];$referencia_comp = $_GET["txtreferencia_comp"];$tipo_compromiso = $_GET["txttipo_compromiso"];}
$sql="Select * from AJUSTES where tipo_ajuste='$tipo_ajuste' and referencia_ajuste='$referencia_ajuste' and tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'";
$rif_emp=""; $total_comp=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else { $Nom_Emp=busca_conf(); }
$descripcion="";$fecha="";$nombre_abrev_ajuste="";$inf_usuario=""; $nombre_refiere_a=""; $tpo_ajuste="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);
  $tipo_ajuste=$registro["tipo_ajuste"];  $referencia_ajuste=$registro["referencia_ajuste"]; $tpo_ajuste=$registro["tpo_ajuste"];
  $tipo_pago=$registro["tipo_pago"];  $referencia_pago=$registro["referencia_pago"];
  $referencia_caus=$registro["referencia_caus"];  $tipo_causado=$registro["tipo_causado"];
  $referencia_comp=$registro["referencia_comp"];  $tipo_compromiso=$registro["tipo_compromiso"];
  $fecha=$registro["fecha_ajuste"];  $descripcion=$registro["descripcion"];  $inf_usuario=$registro["inf_usuario"];
  $nombre_abrev_ajuste=$registro["nombre_abrev_ajuste"];  $nombre_abrev_pago=$registro["nombre_abrev_pago"];
  $nombre_abrev_caus=$registro["nombre_abrev_caus"];  $nombre_abrev_comp=$registro["nombre_abrev_comp"];
  $modulo=$registro["modulo"];  $anulado=$registro["anulado"];
}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);} $refierea="";  $nombre_tipo=""; $nombre_tipo_aju=""; $ced_rif="";  $nombre=""; $unidad_sol=""; $nombre_tipo_comp="";
$sSQL="Select refierea,nombre_tipo_ajuste from pre005 WHERE tipo_ajuste='$tipo_ajuste'";     $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
if ($filas>0){$registro=pg_fetch_array($resultado);  $refierea=$registro["refierea"]; $nombre_tipo_aju=$registro["nombre_tipo_ajuste"]; }
if($refierea=="COMPROMISO"){$sSQL="Select tipo_compromiso,nombre_tipo_comp from pre002 WHERE tipo_compromiso='$tipo_compromiso'";     $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
  if ($filas>0){$registro=pg_fetch_array($resultado);  $nombre_tipo_comp=$registro["nombre_tipo_comp"];  $nombre_tipo=$registro["nombre_tipo_comp"]; } $nombre_refiere_a=$nombre_tipo.' NUMERO:'.$referencia_comp;
$nro_documento=""; $des_unidad_sol=""; $nombre_refiere_c=$nombre_refiere_a;
$sSQL="Select * from COMPROMISOS where tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp'";     
$resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
if ($filas>0){$registro=pg_fetch_array($resultado);  $nro_documento=$registro["nro_documento"]; $des_unidad_sol=$registro["denominacion_cat"];  
$ced_rif=$registro["ced_rif"];  $nombre=$registro["nombre"];  $unidad_sol=$registro["unidad_sol"];
$nombre_refiere_a=$nombre_refiere_a." ".$nro_documento;  }
}
if($refierea=="CAUSADO"){$sSQL="Select tipo_causado,nombre_tipo_caus from pre003 WHERE tipo_causado='$tipo_causado'";     $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
  if ($filas>0){$registro=pg_fetch_array($resultado);  $nombre_tipo=$registro["nombre_tipo_caus"]; } $nombre_refiere_a=$nombre_tipo.' NUMERO :'.$referencia_caus;}
if($refierea=="PAGO"){$sSQL="Select tipo_pago,nombre_tipo_pago from pre004 WHERE tipo_pago='$tipo_pago'";     $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
  if ($filas>0){$registro=pg_fetch_array($resultado);  $nombre_tipo=$registro["nombre_tipo_pago"]; }$nombre_refiere_a=$nombre_tipo.' NUMERO : '.$referencia_pago;}
if($tpo_ajuste=="A"){$titulo="REGISTRO DE AUMENTO A COMPROMISO";}else{$titulo="REGISTRO AJUSTE PRESUPUESTARIO"; if($refierea=="COMPROMISO"){$titulo="REGISTRO DE DISMINUCION A COMPROMISO";}}
$l=0;
for ($i=0; $i<strlen($inf_usuario); $i++) { if (substr($inf_usuario,$i, 1)==" "){$l=$i; $i=strlen($inf_usuario);} } $usuario_comp=substr($inf_usuario,0,$l);
$sql="select * from sia001 where campo101='$usuario_comp'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];
if( $nomb_usuario_comp=="ADMINISTRADOR"){$nomb_usuario_comp="";}}
if($php_os=="WINNT"){$descripcion=$descripcion;}else{$descripcion=$descripcion; $nombre=$nombre;  $nombre_tipo_comp=$nombre_tipo_comp;  $des_unidad_sol=$des_unidad_sol; }	
$sql="SELECT * FROM CODIGOS_AJUSTES where referencia_ajuste='$referencia_ajuste' and tipo_ajuste='$tipo_ajuste' and tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and referencia_caus='$referencia_caus' and tipo_causado='$tipo_causado' and tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' order by cod_presup";
$res=pg_query($sql); $filas=pg_num_rows($res);

require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $referencia_comp; global $nombre_tipo_comp; global $des_unidad_sol; global $fecha; global $nombre; global $ced_rif; 
	   global $descripcion; global $tipo_compromiso; global $unidad_sol; global $referencia_caus; global $tipo_causado; global $nombre_abrev_caus; global $nombre_refiere_a;
       global $referencia_pago; global $nombre_abrev_pago; 	 global $tipo_pago;  global $referencia_ajuste;  global $nombre_tipo_aju; global $tipo_ajuste; global $Nom_Emp;
        $this->rect(10,5,200,260);	
        $this->Image('../../imagenes/logo escudo.png',12,7,15);
		$this->SetFont('Arial','B',10);
		$this->Cell(25);
		$this->Cell(100,4,$Nom_Emp,0,0,'L');
		$this->Cell(75,4,'',0,1,'R');		
		$this->Ln(5);		
		$this->SetFont('Arial','B',13);
		$this->Cell(200,5,'REGISTRO DE AJUSTE',0,1,'C');
		$this->Ln(3);
		$this->SetFont('Arial','B',9);
		$this->Cell(23,6,'Referencia :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(25,6,$referencia_ajuste,'TB',0,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(35,6,'Documento Ajuste :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(60,6,$tipo_ajuste.' '.$nombre_tipo_aju,'TB',0,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(27,6,'Fecha Ajuste :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(30,6,$fecha,'TB',1,'L');		
		$this->SetFont('Arial','B',9);
		$this->Cell(23,6,'Documento :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(177,6,$nombre_refiere_a,'TB',1,'L');
		$this->Cell(40,4,"POR CONCEPTO DE : ",0,1);
		$this->SetFont('Arial','',9);
        $this->MultiCell(200,3,$descripcion,0);
		$this->Cell(200,3,' ','B',1,'C');
		$this->Cell(40,4,'Codigo Presupuestario',1,0,'C');
		$this->Cell(140,4,'Denominacion Codigo Presupuestario',1,0,'C');
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
  $i=0;  $res=pg_query($sql);$filas=pg_num_rows($res);
  while($registro=pg_fetch_array($res)){ $i=$i+1;  
    $monto=formato_monto($registro["monto"]);  $denominacion=$registro["denominacion"];	
	if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=$denominacion;}	
	$pdf->Cell(40,4,$registro["cod_presup"],0,0,'C'); 
	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=140; 	   
	$pdf->SetXY($x+$w+$n,$y);
	$pdf->Cell(20,4,$monto,0,1,'R'); 
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(140,3,$denominacion,0); 
	$total_comp=$total_comp+$registro["monto"];
  }	
 $pdf->Output();
 pg_close($conn);
?> 
