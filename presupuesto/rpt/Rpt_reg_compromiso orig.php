<?php include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS; error_reporting(E_ALL ^ E_NOTICE); 
if (!$_GET){ $referencia_comp=''; $tipo_compromiso=''; $cod_comp='';}else { $referencia_comp = $_GET["txtreferencia_comp"]; $tipo_compromiso = $_GET["txttipo_compromiso"]; $cod_comp = $_GET["txtcod_comp"];}
$sql="Select * from COMPROMISOS where tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and cod_comp='$cod_comp'";   
$rif_emp="G-20009014-6"; $total_comp=0;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else { $Nom_Emp=busca_conf(); }
if($utf_rpt=="SI"){ $php_os="WINNT";} 
$descripcion="";$fecha="";$unidad_sol="";$des_unidad_sol="";$nombre_abrev_comp="";$cod_tipo_comp="";$des_tipo_comp="";$ced_rif="";$nombre="";$fecha_vencim="";$nro_documento="";$num_proyecto="";$des_proyecto="";$func_inv="";
$tiene_anticipo="";$tasa_anticipo="";$cod_con_anticipo="";$inf_usuario="";$anulado="";$modulo=""; $nombre_tipo_comp="";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);
  $referencia_comp=$registro["referencia_comp"];  $cod_comp=$registro["cod_comp"];$fecha=$registro["fecha_compromiso"];  $tipo_compromiso=$registro["tipo_compromiso"];
  $descripcion=$registro["descripcion_comp"];  $inf_usuario=$registro["inf_usuario"]; $nombre_abrev_comp=$registro["nombre_abrev_comp"];   $unidad_sol=$registro["unidad_sol"];
  $des_unidad_sol=$registro["denominacion_cat"];  $cod_tipo_comp=$registro["cod_tipo_comp"]; $des_tipo_comp=$registro["des_tipo_comp"];  $ced_rif=$registro["ced_rif"];
  $nombre=$registro["nombre"];  $fecha_vencim=$registro["fecha_vencim"]; $nro_documento=$registro["nro_documento"];  $num_proyecto=$registro["num_proyecto"];
  $des_proyecto=$registro["des_proyecto"];  $func_inv=$registro["func_inv"];  $tiene_anticipo=$registro["tiene_anticipo"];  $tasa_anticipo=$registro["tasa_anticipo"];
  $cod_con_anticipo=$registro["cod_con_anticipo"];  $anulado=$registro["anulado"];  $modulo=$registro["modulo"];
}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);} $l=0; $nomb_usuario_comp="";
if($fecha_vencim==""){$fecha_vencim="";}else{$fecha_vencim=formato_ddmmaaaa($fecha_vencim);}
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="C"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
if($tiene_anticipo=="S"){$tiene_anticipo="SI";}else{$tiene_anticipo="NO";}
$clave=$tipo_compromiso.$referencia_comp.$cod_comp;
$sql="Select * from pre002 WHERE tipo_compromiso='$tipo_compromiso'";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);$nombre_tipo_comp=$registro["nombre_tipo_comp"]; }
for ($i=0; $i<strlen($inf_usuario); $i++) { if (substr($inf_usuario,$i, 1)==" "){$l=$i; $i=strlen($inf_usuario);} } $usuario_comp=substr($inf_usuario,0,$l);
$sql="select * from sia001 where campo101='$usuario_comp'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];}
$des_fuente_financ="";
$sql="SELECT * FROM codigos_compromisos where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_comp='$cod_comp' order by cod_presup";
$res=pg_query($sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res);  $des_fuente_financ=$registro["des_fuente_financ"];}
if($php_os=="WINNT"){$descripcion=$descripcion;}else{$descripcion=utf8_decode($descripcion); $nombre=utf8_decode($nombre);  $nombre_tipo_comp=utf8_decode($nombre_tipo_comp);  $des_unidad_sol=utf8_decode($des_unidad_sol); }	
$nombre=utf8_decode($nombre);
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $referencia_comp; global $nombre_tipo_comp; global $des_unidad_sol; global $fecha; global $nombre; global $ced_rif; 
	   global $descripcion; global $tipo_compromiso; global $unidad_sol; global $php_os;	global $Nom_Emp;	
        $this->rect(10,5,200,260);		
		$this->Image('../../imagenes/logo escudo.png',12,6,18);
		$this->SetFont('Arial','B',9);
		$this->Cell(25);
		$this->Cell(140,3,$Nom_Emp,0,0,'L');
		$this->Cell(35,3,'Pagina '.$this->PageNo().'/{nb}',0,1,'R');
		$this->Ln(5);
		$this->SetFont('Arial','B',10);
		$this->Cell(200,3,'REGISTRO DE COMPROMISO Nro. '.$referencia_comp,0,1,'C');
		$this->Ln(4);		
		$this->SetFont('Arial','',7);
        $this->SetFillColor(192,192,192);
		$this->Cell(150,3,'TIPO DE COMPROMISO',1,0,'C',true);		
		$this->Cell(50,3,'FECHA',1,1,'C',true);	
		$this->Cell(150,4,$tipo_compromiso." ".$nombre_tipo_comp,1,0,'C');
		
		$this->Cell(50,4,$fecha,1,1,'C');
        $this->Cell(200,3,'UNIDAD SOLICITANTE',1,1,'C',true);	
        $this->MultiCell(200,4,$unidad_sol." ".$des_unidad_sol,0,'L');		
		$this->Cell(200,3,'BENEFICIARIO',1,1,'C',true);		
		$this->Cell(160,3,'NOMBRE',1,0,'C',true);
		$this->Cell(40,3,'RIF O CEDULA DE IDENTIDAD',1,1,'C',true);
		$this->Cell(160,4,$nombre,1,0,'C');
		$this->Cell(40,4,$ced_rif,1,1,'C');		
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
		$this->Cell(100,4,'SIPAP CONTABILIDAD PRESUPUESTARIA',0,1,'R');
	}
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $pdf->SetAutoPageBreak(true, 45);  
  $i=0;  $res=pg_query($sql);$filas=pg_num_rows($res);
  while($registro=pg_fetch_array($res)){ $i=$i+1;  
    $monto=formato_monto($registro["monto"]);  $denominacion=$registro["denominacion"];	
	if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}	
	$pdf->Cell(40,3,$registro["cod_presup"],0,0,'C'); 
	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=140; 	   
	$pdf->SetXY($x+$w+$n,$y);
	$pdf->Cell(20,3,$monto,0,1,'R'); 
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(140,3,$denominacion,0); 
	$total_comp=$total_comp+$registro["monto"];
  }	
 $pdf->Output();
 pg_close($conn);
?> 