<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT"; error_reporting(E_ALL ^ E_NOTICE);
if (!$_GET){$cod_banco='';$num_cheque=''; $tipo_rpt='PDF';}  else{$cod_banco=$_GET["cod_banco"];$num_cheque=$_GET["num_cheque"]; $tipo_rpt=$_GET["tipo_rpt"];}
$sql="Select * from EDO_CHEQUES where cod_banco='$cod_banco' and num_cheque='$num_cheque'";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$nombre_banco="";$nro_cuenta="";$concepto="";$num_cheque=""; $nro_orden=""; $nombre_benef=""; $ced_rif=""; $concepto=""; $monto_cheque=0; $fecha=""; $mes=""; $inf_usuario=""; $anulado="N";  $fecha_anulado="";  $tipo_pago=""; $edo_cheque=""; $entregado="N";$fecha_entregado="";$ced_rif_recib="";$nombre_recib="";
$musuario_sia=""; $mnombre_usuario_sia=""; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"];  $fecha_anulado=$registro["fecha_anulado"]; $tipo_pago=$registro["tipo_pago"];
  $concepto=$registro["concepto"]; $num_cheque=$registro["num_cheque"];  $fecha=$registro["fecha"]; $sfecha=$registro["fecha"];  $nro_orden=$registro["nro_orden_pago"]; $monto_cheque=$registro["monto_cheque"];  $ced_rif=$registro["ced_rif"];
  $nombre_benef=$registro["nombre"];  $entregado=$registro["entregado"]; $fecha_entregado=$registro["fecha_entregado"];$ced_rif_recib=$registro["ced_rif_recib"];$nombre_recib=$registro["nombre_recib"];  $inf_usuario=$registro["inf_usuario"];
  $musuario_sia=$registro["usuario_sia"];
}
$monto_cheque=formato_monto($monto_cheque); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
$monto_letras= monto_letras($monto_cheque); $tipo_comp="B".$cod_banco;$mes=substr($fecha,3,2);
if ($mes=="01"){$mes="ENERO";}else{if ($mes=="02"){$mes="FEBRERO";}else{if ($mes=="03"){$mes="MARZO";}else {if ($mes=="04"){$mes="ABRIL";}else {if ($mes=="05"){$mes="MAYO";}else {if ($mes=="06"){$mes="JUNIO";}else {if ($mes=="07"){$mes="JULIO";}else {if ($mes=="08"){$mes="AGOSTO";}else {if ($mes=="09"){$mes="SEPTIEMBRE";}else {if ($mes=="10"){$mes="OCTUBRE";}else {if ($mes=="11"){$mes="NOVIEMBRE";}else {$mes="DICIEMBRE";}}}}}}}}}}}
$lugar="CARRIZAL, ".substr($fecha,0,2)." DE ".$mes; $ano=substr($fecha,6,4); $facturas="";
$cod_c=array ('','','','','','','','','','','','','','',''); $debe_c=array ('','','','','','','','','','','','','','','');$den_c=array ('','','','','','','','','','','','','','',''); $haber_c=array ('','','','','','','','','','','','','','','');
$sqlu="SELECT campo101,  campo104  FROM sia001 where campo101='$musuario_sia'"; $resu=pg_query($sqlu); $filasu=pg_num_rows($resu);if($filasu>=1){$regu=pg_fetch_array($resu,0); $mnombre_usuario_sia=$regu["campo104"]; }
$k=0; $max_ccont=3;
$sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$num_cheque' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){$monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";}else{$debe="";$haber=$monto_asiento;} 
$cod_c[$k]=$registro["cod_cuenta"]; $den_c[$k]=$registro["nombre_cuenta"]; $debe_c[$k]=$debe; $haber_c[$k]=$haber; if($k<15){$k=$k+1;}} $cant_cont=$k;
$total_ret=0; $sqlc="SELECT tipo_retencion,descripcion_ret,cod_contable_ret,tasa_retencion,monto_retencion,monto_objeto_ret FROM RET_ORD where nro_orden_ret='$nro_orden' order by tipo_retencion";
$resret=pg_query($sqlc); $filas=pg_num_rows($resret); $k=0; $max_cret=4;
$cod_r=array ('','','','','','','','','','','','','','',''); $tasa_r=array ('','','','','','','','','','','','','','','');$den_r=array ('','','','','','','','','','','','','','',''); $monto_r=array ('','','','','','','','','','','','','','','');  $montoo_r=array ('','','','','','','','','','','','','','','');
while($registro=pg_fetch_array($resret)){  
$tasa=$registro["tasa_retencion"]; $tasa=formato_monto($tasa); $monto=$registro["monto_retencion"]; $monto=formato_monto($monto); $montoo=$registro["monto_objeto_ret"]; $montoo=formato_monto($montoo); 
$total_ret=$total_ret+$registro["monto_retencion"]; $concepto_ret=$registro["descripcion_ret"]; $concepto_ret=substr($concepto_ret,0,100);
$cod_r[$k]=$registro["tipo_retencion"]; $cod_r[$k]=$registro["tipo_retencion"];
$tasa_r[$k]=$tasa; $monto_r[$k]=$monto; $montoo_r[$k]=$montoo; $den_r[$k]=$concepto_ret; if($k<15){$k=$k+1;} } $cant_r=$k;  $total_ret=formato_monto($total_ret);
$concepto=utf8_decode($concepto); $nombre=utf8_decode($nombre); 
$sqlc="SELECT cod_presup,denominacion,sum(monto) as monto_chq FROM codigos_pagos where referencia_pago='$num_cheque' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' group by cod_presup,denominacion order by cod_presup";
$resc=pg_query($sqlc); $filas=pg_num_rows($resc); $cant_cod_presup=$filas; $max_cpre=10; 

if($tipo_rpt=="PDF"){
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $monto_cheque; global $nombre_benef; global $monto_letras; global $lugar; global $ano; global $nombre_banco; 
	   global $concepto; global $nro_cuenta; global $num_cheque; global $fecha; global $nro_orden;  global $tipo_letra;
        //$this->AddFont($tipo_letra,'','lucon.php');		
		$this->SetFont($tipo_letra,'',11);
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,10,'   ',0,1,'L');
		$this->Cell(130,4,'',0,0,'L');
		$this->Cell(70,4,'***'.$monto_cheque.'***',0,0,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(10,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		//$this->Cell(200,4,'',0,1,'L');
		$this->Cell(10,4,'',0,0,'L');
        $this->SetFont($tipo_letra,'',10);
		$this->Cell(180,4,'***'.$nombre_benef.'***',0,0,'L');
		$this->Cell(10,4,'',0,1,'L');
		$this->SetFont($tipo_letra,'',2);		
		$this->Cell(200,2,'',0,1,'L'); //aqui sume 2
		$this->SetFont($tipo_letra,'',10);
		$long_line=70; $part1=$monto_letras; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($monto_letras,0,$long_line); }
        $lp=strlen($part1);  $c2=$lp; $care="N"; 
        if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($monto_letras,0,$c2); }       
        $part2=substr($monto_letras,$c2,$long_line);
		//$part1=$monto_letras; $part2=' '; $l=strlen($part1); if($l>72){$part1=substr($monto_letras,0,72); $part2=substr($monto_letras,72,255); }
		$this->Cell(10,4,'',0,0,'L');
		$this->Cell(185,4,$part1,0,0,'L');
		$this->Cell(5,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(15,4,'',0,0,'L');
		$this->Cell(165,4,$part2,0,0,'L');
		$this->Cell(10,4,'',0,1,'L');
		//$this->Cell(200,4,'',0,1,'L');
		$this->Cell(10,4,'',0,0,'L');
		$this->Cell(70,4,$lugar,0,0,'L');                
		$this->Cell(40,4,$ano,0,1,'L');		
        $this->Cell(60,4,'',0,0,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,6,'',0,1,'L');
		//$this->Cell(200,4,'',0,1,'L');
		//$this->Cell(200,4,'',0,1,'L');		
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(120,4,'',0,0,'L');
		$this->SetFont($tipo_letra,'',10);
		$this->Cell(50,4,'CADUCA A LOS 90 DIAS',0,1,'C');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(120,4,'',0,0,'L');
		$this->Cell(50,4,'NO ENDOSABLE',0,1,'C');
        $this->SetFont($tipo_letra,'',9);		
		$this->Cell(200,26,'',0,1,'L');		// aqui reste 2
		$this->MultiCell(170,4,$concepto,0);
		$this->Ln(3);
		$this->SetFont($tipo_letra,'',9);
		$this->Cell(32,4,'COD.CONTABLE',0,0,'L'); 
	    $this->Cell(90,4,'DENOMINACION',0,0,'L'); 					
	    $this->Cell(22,4,'DEBE',0,0,'C');
        $this->Cell(22,4,'HABER',0,1,'C');
		$this->SetFont($tipo_letra,'',10);
	}
    function Footer(){ global $max_ccont; global $cant_cont; global $cod_c; global $debe_c; global $den_c; global $haber_c;
		$this->SetY(-10);		
		$this->SetFont($tipo_letra,'',9);
		$this->Cell(200,1,'',0,1,'L');
	}  
}  
  //$tipo_letra='lucon'; $tipo_letra='Times'; $tipo_letra='Courier'; $tipo_letra='Helvetica';
  $tipo_letra='Arial'; $tipo_letra='Times'; $tipo_letra='Courier'; 
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont($tipo_letra,'',10);
  $pdf->SetAutoPageBreak(true, 10);
  $i=0;   $total=0;
  $pdf->SetFont($tipo_letra,'',9);
		$z=$pdf->GetY();
		if($cant_cont>$max_ccont){ $l=($max_ccont-1)*3; $m=($l/2);
		   $pdf->Ln($m);
		   $pdf->Cell(160,4,'',0,1,'C');
		   $pdf->Ln($m);
		}else{ for ($k=0; $k<$max_ccont; $k++) {  
		  $pdf->Cell(32,4,$cod_c[$k],0,0,'L'); 
	      $pdf->Cell(90,4,substr($den_c[$k],0,45),0,0,'L'); 					
	      $pdf->Cell(22,4,$debe_c[$k],0,0,'R');
          $pdf->Cell(22,4,$haber_c[$k],0,1,'R'); 		  
		} }
  //$pdf->Ln(3);	
  $pdf->SetFont($tipo_letra,'',9);
		$pdf->Cell(15,4,'CODIGO',0,0,'L'); 
	    $pdf->Cell(90,4,'DESCRIPCION DE LA RETENCION',0,0,'L'); 					
	    $pdf->Cell(30,4,'MONTO OBJETO',0,0,'C');
        $pdf->Cell(30,4,'MONTO RETENIDO',0,1,'C');
		$pdf->SetFont($tipo_letra,'',9);
  $z=$pdf->GetY();
		if($cant_r>$max_cret){ $l=($max_cret-1)*3; $m=($l/2);
		   $pdf->Ln($m);
		   $pdf->Cell(160,3,'',0,1,'C');
		   $pdf->Ln($m);
		}else{ for ($k=0; $k<$max_cret; $k++) {  
		  $pdf->Cell(15,3,$cod_r[$k],0,0,'L'); 
	      $pdf->Cell(90,3,$den_r[$k],0,0,'L'); 
          $pdf->Cell(30,3,$montoo_r[$k],0,0,'R'); 		  
	      $pdf->Cell(28,3,$monto_r[$k],0,1,'R'); 
		} }		
  $pdf->Ln(3);
  $pdf->Cell(60,4,$nombre_banco,0,0,'L');
  $pdf->Cell(90,4,$nro_cuenta,0,1,'L');
  $pdf->Ln(3); 
  $pdf->Cell(30,4,'',0,0,'L');
  $pdf->Cell(40,4,$num_cheque,0,1,'L');
  $pdf->Ln(4);		
  $pdf->Cell(40,4,$nro_orden,0,1,'L');
  $pdf->Ln(4);	
  $pdf->Cell(200,3,$mnombre_usuario_sia,0,1,'L');
  $pdf->Output();
}

if($tipo_rpt=="TXT"){ 
    header('Content-type: application/txt');
    header("Content-Disposition: attachment; filename=Impresion_cheque.txt");		   
	include ("../../class/printtxt.php");
	function encabezado(){global $monto_cheque; global $nombre_benef; global $monto_letras; global $lugar; global $ano; global $nombre_banco; 
	   global $concepto; global $nro_cuenta; global $num_cheque; global $fecha; global $nro_orden;  global $tipo_letra; global $linea_puntos;			 
	   $lineap="   ";  print_line($lineap);	
	   $temp1='***'.$monto_cheque.'***';
	   $lineap=centrar_linea('  ',50).build_print($temp1,30);
	   print_line($lineap);
	   $lineap="   ";  print_line($lineap);	
	   $lineap="   ";  print_line($lineap);	
	   $lineap="   ";  print_line($lineap);	
	   $temp1='     '.'***'.$nombre_benef.'***';
	   $lineap=build_print($temp1,80);
	   print_line($lineap);
	   $lineap="   ";  print_line($lineap);	
	   $long_line=70; $part1=$monto_letras; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($monto_letras,0,$long_line); }
       $lp=strlen($part1);  $c2=$lp; $care="N"; 
       if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($monto_letras,0,$c2); }       
       $part2=substr($monto_letras,$c2,$long_line);
	   $temp1='     '.$part1;
	   $lineap=build_print($temp1,80);
	   print_line($lineap);
	   $lineap="   ";  print_line($lineap);	
	   $lineap="   ";  print_line($lineap);	
	   $temp1='     '.$part2;
	   $lineap=build_print($temp1,80);
	   print_line($lineap);
	   $temp1='     '.$lugar;
	   $lineap=build_print($temp1,50).build_print($ano,20);
	   print_line($lineap);
	   $lineap="   ";  print_line($lineap);	
       $lineap="   ";  print_line($lineap);	
	   $lineap="   ";  print_line($lineap);	   
	   $lineap=build_print('',50).build_print('CADUCA A LOS 90 DIAS',20);
	   print_line($lineap);
	   $lineap=build_print('',50).build_print('    NO ENDOSABLE',20);
	   print_line($lineap);
	   $lineap="   ";  print_line($lineap);	
       $lineap="   ";  print_line($lineap);	
	   $lineap="   ";  print_line($lineap);	
	   $lineap="   ";  print_line($lineap);	
       $lineap="   ";  print_line($lineap);	
	   $lineap="   ";  print_line($lineap);	
	   print_multi_line($concepto,80);
	   $lineap="   ";  print_line($lineap);	
	   $lineap=centrar_linea('COD.CONTABLE',20).build_print('DENOMINACION',34).centrar_linea('DEBE',13).centrar_linea('HABER',13);
	   print_line($lineap); print_line($linea_puntos);
	}
    $l=0; $max_lines=65;  $nlines_top=2; $nlines_bot=2;
	$linea_puntos="--------------------------------------------------------------------------------";			 
	encabezado();	
	$i=0;   $total=0;
    for ($k=0; $k<$max_ccont; $k++) {  $temp1=substr($den_c[$k],0,34);
	   $lineap=build_print($cod_c[$k],20).build_print($temp1,34).build_print_r($debe_c[$k],13).build_print_r($haber_c[$k],13);
	   print_line($lineap);

    } 
	$lineap=build_print('CODIGO',7).build_print('DESCRIPCION DE LA RETENCION',45).centrar_linea('MONTO OBJETO',14).centrar_linea('MONTO RETENIDO',14);
	   print_line($lineap); print_line($linea_puntos);		 		

	for ($k=0; $k<$max_cret; $k++) {  $den_r=substr($den_c[$k],0,45);
	    $lineap=build_print($cod_r[$k],20).build_print($temp1,45).build_print_r($montoo_r[$k],13).build_print_r($monto_r[$k],13);
	   print_line($lineap);
    }		
	$lineap="   ";  print_line($lineap);
	$lineap=build_print($nombre_banco,35).build_print($nro_cuenta,45);
	print_line($lineap);
	
	$lineap="   ";  print_line($lineap);
	$lineap=build_print('',18).build_print($num_cheque,45);
	print_line($lineap);
	
	$lineap="   ";  print_line($lineap);
	$lineap=build_print($nro_orden,45);
	print_line($lineap);
	
	$lineap="   ";  print_line($lineap);
	$lineap=build_print($mnombre_usuario_sia,45);
	print_line($lineap);
	   
 
}
 pg_close();
?>
