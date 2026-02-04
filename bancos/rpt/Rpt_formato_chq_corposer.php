<?php include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT"; error_reporting(E_ALL ^ E_NOTICE);
if (!$_GET){$cod_banco='';$num_cheque=''; }  else{$cod_banco=$_GET["cod_banco"];$num_cheque=$_GET["num_cheque"];}
$sql="Select * from EDO_CHEQUES where cod_banco='$cod_banco' and num_cheque='$num_cheque'";

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$nombre_banco="";$nro_cuenta="";$concepto="";$num_cheque=""; $nro_orden=""; $nombre_benef=""; $ced_rif=""; $concepto=""; $monto_cheque=0; $fecha=""; $mes=""; $inf_usuario=""; $anulado="N";  $fecha_anulado="";  $tipo_pago=""; $edo_cheque=""; $entregado="N";$fecha_entregado="";$ced_rif_recib="";$nombre_recib="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"];  $fecha_anulado=$registro["fecha_anulado"]; $tipo_pago=$registro["tipo_pago"];
  $concepto=$registro["concepto"]; $num_cheque=$registro["num_cheque"];  $fecha=$registro["fecha"]; $sfecha=$registro["fecha"];  $nro_orden=$registro["nro_orden_pago"]; $monto_cheque=$registro["monto_cheque"];  $ced_rif=$registro["ced_rif"];
  $nombre_benef=$registro["nombre"];  $entregado=$registro["entregado"]; $fecha_entregado=$registro["fecha_entregado"];$ced_rif_recib=$registro["ced_rif_recib"];$nombre_recib=$registro["nombre_recib"];  $inf_usuario=$registro["inf_usuario"];
}
$nombre_benef=utf8_decode($nombre_benef); $concepto=utf8_decode($concepto);
$monto_cheque=formato_monto($monto_cheque); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
$monto_letras= monto_letras($monto_cheque); $tipo_comp="B".$cod_banco;
$mes=substr($fecha,3,2);
if ($mes=="01"){$mes="ENERO";}else{if ($mes=="02"){$mes="FEBRERO";}else{if ($mes=="03"){$mes="MARZO";}else {if ($mes=="04"){$mes="ABRIL";}else {if ($mes=="05"){$mes="MAYO";}else {if ($mes=="06"){$mes="JUNIO";}else {if ($mes=="07"){$mes="JULIO";}else {if ($mes=="08"){$mes="AGOSTO";}else {if ($mes=="09"){$mes="SEPTIEMBRE";}else {if ($mes=="10"){$mes="OCTUBRE";}else {if ($mes=="11"){$mes="NOVIEMBRE";}else {$mes="DICIEMBRE";}}}}}}}}}}}
$lugar="CARACAS, ".substr($fecha,0,2)." DE ".$mes; $ano=substr($fecha,6,4);
$lugar="      ".substr($fecha,0,2)." DE ".$mes; $ano=substr($fecha,6,4); $facturas="";
$cod_c=array ('','','','','','','','','','','','','','',''); $debe_c=array ('','','','','','','','','','','','','','','');
$den_c=array ('','','','','','','','','','','','','','',''); $haber_c=array ('','','','','','','','','','','','','','','');


$k=0; $max_ccont=6;
$sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$num_cheque' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){$monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";}else{$debe="";$haber=$monto_asiento;} 
$cod_c[$k]=$registro["cod_cuenta"]; $den_c[$k]=$registro["nombre_cuenta"]; $debe_c[$k]=$debe; $haber_c[$k]=$haber; if($k<15){$k=$k+1;}} $cant_cont=$k;

$sqlc="SELECT cod_presup,denominacion,sum(monto) as monto_chq FROM codigos_pagos where referencia_pago='$num_cheque' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' group by cod_presup,denominacion order by cod_presup";
$resc=pg_query($sqlc); $filas=pg_num_rows($resc); $cant_cod_presup=$filas; $max_cpre=35; 


require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $monto_cheque; global $nombre_benef; global $monto_letras; global $lugar; global $ano; global $nombre_banco; 
	   global $concepto; global $nro_cuenta; global $num_cheque; global $fecha; global $nro_orden;  
        $this->AddFont('lucon','','lucon.php');		
        $this->SetFont('lucon','',10);
		$this->Cell(200,6,'',0,1,'L');
		//$this->Cell(200,4,'',0,1,'L');
		$this->Cell(145,4,'',0,0,'L');
		$this->Cell(45,4,'***'.$monto_cheque.'***',0,0,'L');
		$this->Cell(10,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,6,'',0,1,'L');
		$this->Cell(30,4,'',0,0,'L');
		$this->Cell(160,4,'***'.$nombre_benef.'***',0,0,'L');
		$this->Cell(10,4,'',0,1,'L');
		$this->SetFont('lucon','',2);
		//$this->Cell(200,2,'',1,1,'L');
		//$this->Cell(5,4,'',0,0,'L');
		//$this->MultiCell(175,8,'       '.$monto_letras,'T');
		$this->Cell(200,2,'',0,1,'L');
		$this->SetFont('lucon','',10);
		$long_line=78; $part1=$monto_letras; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($monto_letras,0,$long_line); }
        $lp=strlen($part1);  $c2=$lp; $care="N"; 
        if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($monto_letras,0,$c2); }       
        $part2=substr($monto_letras,$c2,$long_line);
		//$part1=$monto_letras; $part2=' '; $l=strlen($part1); if($l>72){$part1=substr($monto_letras,0,72); $part2=substr($monto_letras,72,255); }
		$this->Cell(30,4,'',0,0,'L');
		$this->Cell(165,4,$part1,0,0,'L');
		$this->Cell(5,4,'',0,1,'L');
		$this->Cell(200,1,'',0,1,'L');
		$this->Cell(15,4,'',0,0,'L');
		$this->Cell(165,4,$part2,0,0,'L');
		$this->Cell(10,4,'',0,1,'L');
		$this->Cell(200,3,'',0,1,'L');
		$this->Cell(15,4,'',0,0,'L');
		$this->Cell(75,4,$lugar,0,0,'L');
		$this->Cell(110,4,$ano,0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		//$this->Cell(200,4,'',0,1,'L');
		//$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->SetFont('lucon','U',10);
		//$this->Cell(180,4,'CADUCA A LOS 60 DIAS',0,0,'C');
		
		
		$this->Cell(20,4,'',0,1,'L');
        $this->SetFont('Arial','',10);		
		$this->Cell(200,20,'',0,1,'L');		// aqui reste 2
		
		
		$y=$this->GetY();
        //$this->Line(10,$y-1,210,$y-1);
		
		$this->rect(10,$y-1,200,275-$y);
		$this->SetFont('Arial','',11);
		$this->Image('../../imagenes/logo escudo.png',12,$y,30);
		$this->Cell(40,3,'   ',0,1,'L');
		
		$this->Cell(40,5,'   ',0,0,'L');
	    $this->Cell(160,5,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,1,'L');
		$this->Cell(40,5,'   ',0,0,'L');
	    $this->Cell(100,5,'CORPOSERVICIOS MIRANDA, S.A.',0,0,'L');
		$this->SetFont('Arial','',12);
		$this->Cell(60,5,'COMPROBANTE DE',0,1,'C');
		$this->SetFont('Arial','',11);
		$this->Cell(40,5,'   ',0,0,'L');
	    $this->Cell(100,5,'  ',0,0,'L');
		$this->SetFont('Arial','',12);
		$this->Cell(60,5,'CHEQUE VOUCHER',0,1,'C');
		
		
		$this->SetFont('Arial','',10);
		$this->Cell(200,8,'   ',0,1,'L');
		$this->Cell(145,4,'',0,0,'L');
		$this->Cell(45,4,'***'.$monto_cheque.'***',0,0,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(10,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(30,4,'',0,0,'L');
		$this->Cell(160,4,'***'.$nombre_benef.'***',0,0,'L');
		$this->Cell(10,4,'',0,1,'L');
		$this->SetFont('Arial','',2);
		$this->Cell(200,4,'',0,1,'L'); //aqui sume 2
		$this->SetFont('Arial','',10);
		$long_line=78; $part1=$monto_letras; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($monto_letras,0,$long_line); }
        $lp=strlen($part1);  $c2=$lp; $care="N"; 
        if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($monto_letras,0,$c2); }       
        $part2=substr($monto_letras,$c2,$long_line);
		$this->Cell(30,4,'',0,0,'L');
		$this->Cell(165,4,$part1,0,0,'L');
		$this->Cell(5,4,'',0,1,'L');
		$this->Cell(200,2,'',0,1,'L');
		$this->Cell(15,4,'',0,0,'L');
		$this->Cell(165,4,$part2,0,0,'L');
		$this->Cell(10,4,'',0,1,'L');
		$this->Cell(15,4,'',0,0,'L');
		$this->Cell(75,4,$lugar,0,0,'L');
		$this->Cell(110,4,$ano,0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->SetFont('Arial','U',10);
		//$this->Cell(180,4,'CADUCA A LOS 90 DIAS',0,0,'C');
		$this->Cell(20,4,'',0,1,'L');
        $this->SetFont('Arial','',10);		
		$this->Cell(200,10,'',0,1,'L');		// aqui reste 2
		$this->SetFont('Arial','B',8);
		$this->Cell(80,3,'BANCO',1,0,'C');
		$this->Cell(50,3,'CUENTA',1,0,'C');
		$this->Cell(20,3,'CHEQUE',1,0,'C');
		$this->Cell(20,3,'FECHA',1,0,'C');
		$this->Cell(30,3,'ORDEN DE PAGO',1,1,'C');
		$this->SetFont('Arial','',10);	
		$this->SetFont('Arial','',8);
		$this->Cell(80,4,$nombre_banco,1,0,'C');
		$this->Cell(50,4,$nro_cuenta,1,0,'C');
		$this->Cell(20,4,$num_cheque,1,0,'C');
		$this->Cell(20,4,$fecha,1,0,'C');		
		$this->Cell(30,4,$nro_orden,1,1,'C');
		$this->SetFont('Arial','B',8);
		$this->Cell(200,3.3,'POR CONCEPTO DE',1,1,'C');
		$this->SetFont('Arial','',8);
		$this->MultiCell(200,4,$concepto,0);
		$this->Cell(200,3,'',0,1,'C');
	}
    function Footer(){ global $max_ccont; global $cant_cont; global $cod_c; global $debe_c; global $den_c; global $haber_c;
		$this->SetY(-60);	
		$this->SetFont('Arial','B',8);	
		$this->Cell(36,3,'COD. CONTABLE',1,0,'L');
		$this->Cell(118,3,'NOMBRE DE LA CUENTA',1,0,'L');
		$this->Cell(23,3,'DEBE',1,0,'C');
		$this->Cell(23,3,'HABER',1,1,'C');
		//$this->Cell(200,1,'',0,1,'L');
		$this->SetFont('Arial','',8);
		$z=$this->GetY();
		if($cant_cont>$max_ccont){ $l=($max_ccont-1)*3; $m=($l/2);
		   $this->Ln($m);
		   $this->Cell(180,3,'VER RELACION ANEXA',0,1,'C');
		   $this->Ln($m);
		}else{ for ($k=0; $k<$max_ccont; $k++) {  
		  $this->Cell(36,3,$cod_c[$k],'RL',0,'L'); 
	      $this->Cell(118,3,$den_c[$k],'R',0,'L'); 					
	      $this->Cell(23,3,$debe_c[$k],'R',0,'R');
          $this->Cell(23,3,$haber_c[$k],'R',1,'R'); 		  
		} }
		$this->SetFont('Arial','B',8);	
		$this->Cell(65,4,'Hecho Por:',1,0,'C');	
		$this->Cell(65,4,'Aprobado Por:',1,0,'C');
		$this->Cell(70,4,'Recibido Por:',1,1,'C');
		$this->Cell(65,24,'',1,0,'C');
		$this->Cell(65,24,'',1,0,'C');
		$this->Cell(70,24,'',1,1,'C');
			
		$this->Ln(2);
		$this->SetFont('Arial','',6);
		$this->Cell(200,4,'SIPAP Control Bancario',0,1,'R');
	}
  
  }  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',10);
  $pdf->SetAutoPageBreak(true, 60);
  $i=0;  
  $total=0; 

  $pdf->Output();
  pg_close($conn);
?>
