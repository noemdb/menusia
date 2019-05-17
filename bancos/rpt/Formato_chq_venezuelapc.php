<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){$cod_banco='';$num_cheque=''; }  else{$cod_banco=$_GET["cod_banco"];$num_cheque=$_GET["num_cheque"];}  $fecha_hoy=asigna_fecha_hoy(); 
$tipo_rpt="PDF"; $tipo_rpt="TXT";
$sql="Select * from EDO_CHEQUES where cod_banco='$cod_banco' and num_cheque='$num_cheque'";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos; .</b></p>"; exit; }
$nombre_banco="";$nro_cuenta="";$concepto="";$num_cheque=""; $nro_ordenp=""; $nro_orden=""; $tipo_causado=""; $nombre_benef=""; $ced_rif=""; $concepto=""; $monto_cheque=0; $fecha=""; $mes=""; $inf_usuario=""; $anulado="N";  $fecha_anulado="";  $tipo_pago=""; $edo_cheque=""; $entregado="N";$fecha_entregado="";$ced_rif_recib="";$nombre_recib="";
$res=pg_query($sql);$filas=pg_num_rows($res); 
//$resm=pg_query($sqlm);$filasm=pg_num_rows($resm);
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"];  $fecha_anulado=$registro["fecha_anulado"]; $tipo_pago=$registro["tipo_pago"];
  $concepto=$registro["concepto"]; $num_cheque=$registro["num_cheque"];  $fecha=$registro["fecha"]; $sfecha=$registro["fecha"];  $nro_orden=$registro["nro_orden_pago"]; $monto_cheque=$registro["monto_cheque"];  $ced_rif=$registro["ced_rif"];
  $nombre_benef=$registro["nombre"];  $entregado=$registro["entregado"]; $fecha_entregado=$registro["fecha_entregado"];$ced_rif_recib=$registro["ced_rif_recib"];$nombre_recib=$registro["nombre_recib"];  $inf_usuario=$registro["inf_usuario"]; $nro_ordenp=$registro["nro_orden_pago"];
}
$sqlm="Select * from PAG001 where nro_orden='$nro_ordenp'"; $fechaop="";
$resm=pg_query($sqlm);$filasm=pg_num_rows($resm);
if($filasm>=1){$registro=pg_fetch_array($resm,0);
   $nro_ordenp=$registro["nro_orden"]; $tipo_causado=$registro["tipo_causado"]; $fechaop=$registro["fecha"]; $fechaop=formato_ddmmaaaa($fechaop);
}
$monto_cheque=formato_monto($monto_cheque); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
$monto_letras= monto_letras($monto_cheque); $tipo_comp="B".$cod_banco; $monto_letras2= monto_letras($monto_cheque);
$mes=substr($fecha,3,2);
if ($mes=="01"){$mes="ENERO";}else{if ($mes=="02"){$mes="FEBRERO";}else{if ($mes=="03"){$mes="MARZO";}else {if ($mes=="04"){$mes="ABRIL";}else {if ($mes=="05"){$mes="MAYO";}else {if ($mes=="06"){$mes="JUNIO";}else {if ($mes=="07"){$mes="JULIO";}else {if ($mes=="08"){$mes="AGOSTO";}else {if ($mes=="09"){$mes="SEPTIEMBRE";}else {if ($mes=="10"){$mes="OCTUBRE";}else {if ($mes=="11"){$mes="NOVIEMBRE";}else {$mes="DICIEMBRE";}}}}}}}}}}}
$lugar="Valencia, ".substr($fecha,0,2)." de ".$mes; $ano=substr($fecha,6,4); $facturas="";
$cod_c=array ('','','','','','','','','','','','','','',''); $debe_c=array ('','','','','','','','','','','','','','','');
$den_c=array ('','','','','','','','','','','','','','',''); $haber_c=array ('','','','','','','','','','','','','','','');

$cod_p=array ('','','','','','','','','','','','','','',''); $fuente_p=array ('','','','','','','','','','','','','','','');
$den_p=array ('','','','','','','','','','','','','','',''); $monto_p=array ('','','','','','','','','','','','','','','');

$k=0; $max_ccont=15; $cant_cont=0;
$sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$num_cheque' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){$monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";}else{$debe="";$haber=$monto_asiento;} 
$cod_c[$k]=$registro["cod_cuenta"]; $den_c[$k]=$registro["nombre_cuenta"]; $debe_c[$k]=$debe; $haber_c[$k]=$haber; if($k<15){$k=$k+1;}} $cant_cont=$k;


$total_p=0; $k=0; $max_cpre=15; $cant_pre=0;
$sqlc="SELECT cod_presup,fuente_financ,denominacion,sum(monto) as monto_chq FROM codigos_pagos where referencia_pago='$num_cheque' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' group by cod_presup,fuente_financ,denominacion order by cod_presup,fuente_financ";
$resc=pg_query($sqlc); $filas=pg_num_rows($resc); $cant_cod_presup=$filas; $max_cpre=15; 
while($registro=pg_fetch_array($resc)){ 
    $monto=formato_monto($registro["monto_chq"]); $total_p=$total_p+$registro["monto_chq"];	
	$cod_p[$k]=$registro["cod_presup"]; $fuente_p[$k]=$registro["fuente_financ"]; 	
	$den_p[$k]=$registro["denominacion"];   $monto_p[$k]=$monto;  
	if($k<15){$k=$k+1;} $cant_pre=$k;
  }
  
if($tipo_rpt=="PDF"){  
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $monto_cheque; global $nombre_benef; global $monto_letras; global $lugar; global $ano; global $nombre_banco; global $nro_orden;
	   global $concepto; global $nro_cuenta; global $num_cheque; global $fecha; global $nro_ordenp;  global $tipo_causado; global $fecha_hoy; global $monto_letras2;       
		//$this->AddFont('lucon','','lucon.php');	
		$this->SetFont('Arial','',10);		
		//$this->SetFont('lucon','',10);		
		$this->Cell(200,10,'',0,1,'L');
		$this->Cell(140,4,'',0,0,'L');
		$this->Cell(60,4,'',0,1,'L');	
        $this->Cell(200,5,'',0,1,'L');		
		$this->Cell(145,4,'',0,0,'L');		
		$this->Cell(45,4,'***'.$monto_cheque.'***',0,0,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(10,2,'',0,1,'L');
		$this->SetFont('Arial','',12);
		$this->Cell(200,4,'',0,1,'C');
		$this->Cell(200,3,'',0,1,'L');
		$this->SetFont('Arial','',10);
		$this->ln();
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(160,4,'***'.$nombre_benef.'***',0,0,'L');
		$this->Cell(15,4,'',0,1,'L');
		$this->SetFont('Arial','',2);		
		$this->Cell(200,2,'',0,1,'L');
		$this->SetFont('Arial','',10);
		$long_line=70; $part1=$monto_letras; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($monto_letras,0,$long_line); }
        $lp=strlen($part1);  $c2=$lp; $care="N"; 
        if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($monto_letras,0,$c2); }       
        $part2=substr($monto_letras,$c2,$long_line);
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(160,4,$part1,0,0,'L');
		$this->Cell(5,4,'',0,1,'L');
		$this->Cell(200,2,'',0,1,'L');
		$this->Cell(10,4,'',0,0,'L');
		$this->Cell(170,4,$part2,0,0,'L');
		$this->Cell(10,4,'',0,1,'L');
		$this->Cell(200,2,'',0,1,'L');
		$this->Cell(74,4,$lugar,0,0,'L');
		$this->Cell(96,4,$ano,0,1,'L');
		$this->Cell(200,5,'',0,1,'L');
		$this->Cell(200,5,'',0,1,'L');
		$this->Cell(200,5,'',0,1,'L');
		$this->Cell(200,5,'',0,1,'L');
		$this->Cell(200,5,'',0,1,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(200,5,'',0,1,'L');
		$this->Cell(200,5,'',0,1,'L');
		$this->Cell(200,5,'',0,1,'L');
		$this->Cell(200,5,'',0,1,'L');
		
		$this->Cell(50,5,'',0,0,'C');	
		$this->Cell(50,5,'',0,0,'C');	
		$this->Cell(50,5,'',0,1,'C');
		$this->Cell(15,5,'',0,0,'C');
		$this->Cell(50,5,$tipo_causado,0,0,'L');	
		$this->Cell(50,5,$nro_orden,0,0,'C');	
		$this->Cell(50,5,' ',0,1,'C');	
		
		
		$this->SetFont('Arial','',12);
        $this->Cell(60,4,'',0,0,'L');
		
		$this->Cell(20,4,'',0,1,'L');
        $this->SetFont('Arial','',10);		
		$this->Cell(200,8,'',0,1,'L');	
		$this->Cell(100, 5, $nombre_banco, 0, 0, 'C');
		$this->Cell(100, 5, $num_cheque, 0, 1, 'C');
		$this->Cell(200,4,'',0,1,'C');	
		$this->Cell(130,4,$nro_cuenta,0,0,'C');
		$this->Cell(50,4, $fecha, 0, 0, 'C');
		$this->Cell(20,4,$monto_cheque,0,1,'R');
		$this->Cell(200,2,'',0,1,'L');	
		$this->Cell(30,4,'',0,0,'L');
		$this->Cell(170,4,$nombre_benef,0,1,'L');
		$this->Cell(25,9,'',0,1,'L');
		$this->Cell(20,1,'',0,0,'L');
		$this->Cell(160,4,$part1,0,0,'L');
		$this->Cell(5,4,'',0,1,'L');
		$this->Cell(200,2,'',0,1,'L');
		$this->Cell(10,4,'',0,0,'L');
		$this->Cell(170,4,$part2,0,0,'L');
		//$long_line2=29; $part3=$monto_letras2; $part3=' '; $t=strlen($part3); if($t>$long_line2){$part3=substr($monto_letras2,0,$long_line2); }
        //$tp=strlen($part3);  $r2=$tp; $care="N"; 
       // if($t>=$long_line2){ for($s=$tp-1; $s>0; $s--){  $care=substr($part3,$s,1); if($care==" ") {$r2=$s; $s=0; } }  $part3=substr($monto_letras2,0,$r2); }       
        //$part4=substr($monto_letras2,$r2,$long_line2);
		//$this->Cell(200,3, '', 0, 1, 'L');
		//$this->Cell(200,4,$part3,0,1,'L');
		//$this->SetFont('lucon','',9);		
		//$this->Cell(200,3, '', 0, 1, 'L');
		//$this->Cell(40,4,'',0,0,'L');
		//$this->Cell(37,4,$part3,0,1,'L');
		$this->Cell(5,4,'',0,0,'L');
		//$this->Cell(30,4,$part4,0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(50,1,'',0,1,'L');
		$this->SetFont('Arial','',7);		
		$this->MultiCell(180,4,'         '.$concepto,0); 
		
		
	}
    function Footer(){ 
	   $this->SetY(-10);
    }
}

$pdf = new PDF('P', 'mm', Letter);
$pdf->AliasNbPages();
$pdf->SetMargins(10,5,10);
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);
$z = $pdf->GetY();
	//for ($k = 0; $k < $max_ccont; $k++) {
	  //  $temp1=substr($cod_p[$k],0,9); $temp2=substr($cod_p[$k],10,15);
	  //  $pdf->Cell(40, 3, $temp1, 0, 0, 'C');
	//$pdf->Cell(40, 3, $temp2, 0, 0, 'C');
	//	$pdf->Cell(30, 3, $monto_p[$k], 0, 0, 'R');
	//	$pdf->Cell(5, 3, " ", 0, 0, 'C');
	//	$pdf->Cell(30, 3, $cod_c[$k], 0, 0, 'C');
		//$pdf->Cell(30, 3, $debe_c[$k], 0, 0, 'R');
	//	$pdf->Cell(30, 3, $haber_c[$k], 0, 1, 'R');
	//}
 $pdf->Output();
 
}

if($tipo_rpt=="TXT"){ $nombre_benef=utf8_decode($nombre_benef); $concepto=utf8_decode($concepto);
    header('Content-type: application/txt');
    header("Content-Disposition: attachment; filename=Impresion_cheque.txt");		   
	include ("../../class/printtxt.php");
	function encabezado(){global $monto_cheque; global $nombre_benef; global $monto_letras; global $lugar; global $ano; global $nombre_banco; global $fechaop;
	   global $concepto; global $nro_cuenta; global $num_cheque; global $fecha; global $nro_orden; global $nro_ordenp;  global $tipo_causado; global $tipo_letra; global $linea_puntos;			 
	   $lineap="   ";  print_line($lineap);	
	   $lineap="   ";  print_line($lineap);
	   $lineap="   ";  print_line($lineap);
	   $lineap="   ";  print_line($lineap);
	   $temp1='***'.$monto_cheque.'***';
	   $lineap=centrar_linea('  ',85).build_print($temp1,15);
	   print_line($lineap);
	   $lineap="   ";  print_line($lineap);	
	   $lineap="   ";  print_line($lineap);	
	   $lineap="   ";  print_line($lineap);	
	   
	   $temp1='                         '.'***'.$nombre_benef.'***';
	   $lineap=build_print($temp1,100);
	   print_line($lineap);
	   $lineap="   ";  print_line($lineap);	
	   $long_line=70; $part1=$monto_letras; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($monto_letras,0,$long_line); }
       $lp=strlen($part1);  $c2=$lp; $care="N"; 
       if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($monto_letras,0,$c2); }       
       $part2=substr($monto_letras,$c2,$long_line);
	   $temp1='                            '.$part1;
	   $lineap=build_print($temp1,100);
	   print_line($lineap);
	   $lineap="   ";  print_line($lineap);	
	   //$lineap="   ";  print_line($lineap);	
	   $temp1='     '.$part2;
	   $lineap=build_print($temp1,100);
	   print_line($lineap);
	   $temp1='          '.$lugar;
	   $lineap=build_print($temp1,50).build_print($ano,30);
	   print_line($lineap);
	   $lineap="   ";  print_line($lineap);	
       $lineap="   ";  print_line($lineap);	
	   $lineap="   ";  print_line($lineap);	  
	  // $lineap="   ";  print_line($lineap);		   
	   $lineap=build_print('',80).build_print('CADUCA A LOS 90 DIAS',20);
	   print_line($lineap);
	   $lineap=build_print('',80).build_print('    NO ENDOSABLE',20);
	   print_line($lineap);
	   $lineap="   ";  print_line($lineap);	
	   $lineap="   ";  print_line($lineap);
	   $lineap="   ";  print_line($lineap);	
	   $lineap="   ";  print_line($lineap);
       $lineap="   ";  print_line($lineap);	   
	   $lineap="   ";  print_line($lineap);		  	
       $lineap=build_print('     '.$tipo_causado,50).build_print(' '.$nro_ordenp,20).build_print($fechaop,25);
	   print_line($lineap);	
	  // $lineap="   ";  print_line($lineap);
	}
    $l=0; $max_lines=65;  $nlines_top=2; $nlines_bot=2;
	$linea_puntos="--------------------------------------------------------------------------------";			 
	encabezado();	
	
	
	$lineap="   ";  print_line($lineap);
	$lineap="   ";  print_line($lineap);
	$lineap=build_print('         '.$nombre_banco,65).build_print('   '.$num_cheque,25);
	print_line($lineap);
	
	$lineap="   ";  print_line($lineap);
	$lineap=build_print('                          '.$nro_cuenta,65).build_print($fecha,22).build_print($monto_cheque,13);
	print_line($lineap);
	
	$lineap="   ";  print_line($lineap);
	$lineap=build_print('',25).build_print($nombre_benef,75);
	print_line($lineap);
	
	//$lineap="   ";  print_line($lineap);
	$lineap=build_print('            '.$monto_letras,75);
	print_line($lineap);
	
	$temp1=$concepto;
	$lineap="   ";  print_line($lineap);
	print_multi_line('                  '.$temp1,90);
	print_line($lineap);
	   
 
} 
 pg_close();
?>