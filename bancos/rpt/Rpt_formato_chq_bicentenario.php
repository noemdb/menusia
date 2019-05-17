<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT"; error_reporting(E_ALL ^ E_NOTICE);
if (!$_GET){$cod_banco='';$num_cheque=''; }  else{$cod_banco=$_GET["cod_banco"];$num_cheque=$_GET["num_cheque"];}
$sql="Select * from EDO_CHEQUES where cod_banco='$cod_banco' and num_cheque='$num_cheque'";

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos; .</b></p>"; exit; }
$nombre_banco="";$nro_cuenta="";$concepto="";$num_cheque=""; $nro_orden=""; $nombre_benef=""; $ced_rif=""; $concepto=""; $monto_cheque=0; $fecha=""; $mes=""; $inf_usuario=""; $anulado="N";  $fecha_anulado="";  $tipo_pago=""; $edo_cheque=""; $entregado="N";$fecha_entregado="";$ced_rif_recib="";$nombre_recib="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"];  $fecha_anulado=$registro["fecha_anulado"]; $tipo_pago=$registro["tipo_pago"];
  $concepto=$registro["concepto"]; $num_cheque=$registro["num_cheque"];  $fecha=$registro["fecha"]; $sfecha=$registro["fecha"];  $nro_orden=$registro["nro_orden_pago"]; $monto_cheque=$registro["monto_cheque"];  $ced_rif=$registro["ced_rif"];
  $nombre_benef=$registro["nombre"];  $entregado=$registro["entregado"]; $fecha_entregado=$registro["fecha_entregado"];$ced_rif_recib=$registro["ced_rif_recib"];$nombre_recib=$registro["nombre_recib"];  $inf_usuario=$registro["inf_usuario"];
}
$monto_cheque=formato_monto($monto_cheque); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
$monto_letras= monto_letras($monto_cheque); $tipo_comp="B".$cod_banco;
$mes=substr($fecha,3,2);
if ($mes=="01"){$mes="ENERO";}else{if ($mes=="02"){$mes="FEBRERO";}else{if ($mes=="03"){$mes="MARZO";}else {if ($mes=="04"){$mes="ABRIL";}else {if ($mes=="05"){$mes="MAYO";}else {if ($mes=="06"){$mes="JUNIO";}else {if ($mes=="07"){$mes="JULIO";}else {if ($mes=="08"){$mes="AGOSTO";}else {if ($mes=="09"){$mes="SEPTIEMBRE";}else {if ($mes=="10"){$mes="OCTUBRE";}else {if ($mes=="11"){$mes="NOVIEMBRE";}else {$mes="DICIEMBRE";}}}}}}}}}}}
$lugar="AROA, ".substr($fecha,0,2)." DE ".$mes; $ano=substr($fecha,6,4); $facturas="";
$cod_c=array ('','','','','','','','','','','','','','',''); $debe_c=array ('','','','','','','','','','','','','','','');
$den_c=array ('','','','','','','','','','','','','','',''); $haber_c=array ('','','','','','','','','','','','','','','');

$k=0; $max_ccont=5;
$sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$num_cheque' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){$monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";}else{$debe="";$haber=$monto_asiento;} 
$cod_c[$k]=$registro["cod_cuenta"]; $den_c[$k]=$registro["nombre_cuenta"]; $debe_c[$k]=$debe; $haber_c[$k]=$haber; if($k<15){$k=$k+1;}} $cant_cont=$k;

$cod_p=array ('','','','','','','','','','','','','','',''); $monto_p=array ('','','','','','','','','','','','','','','');
$den_p=array ('','','','','','','','','','','','','','',''); 
$sqlc="SELECT cod_presup,fuente_financ,denominacion,sum(monto) as monto_chq FROM codigos_pagos where referencia_pago='$num_cheque' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' group by cod_presup,fuente_financ,denominacion order by cod_presup";
$resc=pg_query($sqlc); $filas=pg_num_rows($resc); $cant_cod_presup=$filas; $max_cpre=12; $k=0;
$sql="SELECT cod_presup,fuente_financ,denominacion,sum(monto) as monto_chq from codigos_pagos where referencia_pago='$num_cheque' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' group by cod_presup,fuente_financ,denominacion order by cod_presup,fuente_financ";$res=pg_query($sql);$filas=pg_num_rows($res);
while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto_chq"]); $fuente_financ=$registro["fuente_financ"];$denominacion=$registro["denominacion"];
$denominacion=substr($denominacion,0,100);	$cod_p[$k]=$registro["cod_presup"]." ".$registro["fuente_financ"]; $cod_p[$k]=$registro["cod_presup"]; $den_p[$k]=$denominacion; $monto_p[$k]=$monto; if($k<15){$k=$k+1;} } $cant_cod_presup=$k;
 
 
  
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $monto_cheque; global $nombre_benef; global $monto_letras; global $lugar; global $ano; global $nombre_banco; 
	   global $concepto; global $nro_cuenta; global $num_cheque; global $fecha; global $nro_orden; global $ced_rif; 
                $nombre_benef=utf8_decode($nombre_benef);
                $concepto=utf8_decode($concepto);

         $this->AddFont('lucon','','lucon.php');			        		
		$this->SetFont('lucon','',10);
		//$this->SetFont('Arial','',13);
		$this->ln(23);
        $this->Cell(200,12,'',0,1,'L');
		
        $this->Cell(85,4,'',0,0,'L');
        $this->Cell(15, 4, $num_cheque, 0, 0, 'L');	
		$this->Cell(20,4,'',0,0,'L');
		$this->Cell(30,4,'***'.$monto_cheque.'***',0,1,'L');
		$this->Cell(200,5,'',0,1,'L');
		
		$this->Cell(30,4,'',0,0,'L');
		$this->Cell(70,4,'NO ENDOSABLE',0,0,'L');
		$this->Cell(30,4,'',0,0,'L');
		$this->Cell(70,4,'CADUCA A LOS 90 DIAS',0,1,'L');
		$this->ln(3);
		$this->SetFont('lucon','',11);
		$this->Cell(15,4,'',0,0,'L');
		$this->Cell(175,4,'***'.$nombre_benef.'***',0,0,'L');
		$this->Cell(15,4,'',0,1,'L');
		$this->SetFont('lucon','',2);
		$this->Cell(200,2,'',0,1,'L');
		$this->SetFont('lucon','',10);
		$long_line=70; $part1=$monto_letras; $part2=' '; $l=strlen($part1); if($l>$long_line)    {$part1=substr($monto_letras,0,$long_line); }
              $lp=strlen($part1);  $c2=$lp; $care="N"; 
              if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($monto_letras,0,$c2); }       
              $part2=substr($monto_letras,$c2,$long_line);
		$this->Cell(20,4,'',0,0,'L');
		$this->Cell(165,4,$part1,0,0,'L');
		$this->Cell(5,4,'',0,1,'L');
		$this->Cell(200,2,'',0,1,'L');
		$this->Cell(5,4,'',0,0,'L');
		$this->Cell(175,4,$part2,0,0,'L');
		$this->Cell(10,4,'',0,1,'L');
		$this->Cell(200,2,'',0,1,'L');
		$this->Cell(2,4,'',0,0,'L');
				
		$this->Cell(76,4,$lugar,0,0,'L');
		$this->Cell(30,4,$ano,0,1,'R');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->SetFont('lucon','',12);
      		$this->Cell(120,4,'',0,0,'L');
		
		$this->Cell(20,4,'',0,1,'L');
                $this->SetFont('lucon','',10);	


				
		$this->Cell(200,35,'',0,1,'L');   //CAMBIAR PARA SUBIR LE COLOCA MENOS
		
		$this->Cell(30, 4, $nro_orden, 0, 0, 'L');
		$this->Cell(70, 4, $nombre_banco, 0, 0, 'L');
		$this->Cell(60, 4, $nro_cuenta, 0, 0, 'L');
		$this->Cell(30, 4, $num_cheque, 0, 1, 'L');
		
		$this->Cell(20,4,'',0,1,'L');
		
		$this->Cell(20,4,'',0,0,'L');
		$this->MultiCell(170,4,$concepto,0);		
		$y=$this->GetY();
		if($y<170){$t=170-$y; $this->ln($t);}  
        
        $this->Cell(130, 4, $nombre_benef, 0, 0, 'L');
		$this->Cell(40, 4, $ced_rif, 0, 0, 'L');	
		$this->Cell(20, 4, $fecha, 0, 1, 'L');	
		
		      
        
	}
    function Footer(){ 
	   $this->SetY(-10);
    }

}

$pdf = new PDF('P', 'mm', Letter);
$pdf->AliasNbPages();
//$pdf->SetMargins(10,5,10);
$pdf->AddPage();


$pdf->Cell(200, 6, '', 0, 1, 'L');
$pdf->SetFont('lucon', '', 9);
$z = $pdf->GetY();
if ($cant_cont > $max_cpre) {
	$l = ($max_cpre - 1) * 3;
	$m = ($l / 2);
	$pdf->Ln($m);
	$pdf->Cell(170, 3, 'VER RELACION ANEXA', 0, 1, 'C');
	$pdf->Ln($m);
} else {
	for ($k = 0; $k < $max_cpre; $k++) {
		$pdf->Cell(45, 3, $cod_p[$k], 0, 0, 'L');
		$pdf->Cell(120, 3, $den_p[$k], 0, 0, 'L');
		$pdf->Cell(25, 3, $monto_p[$k], 0, 1, 'R');
	}
}
$pdf->Cell(200, 6, '', 0, 1, 'L');	

        	


$pdf->SetFont('lucon', '', 9);
$z = $pdf->GetY();
if ($cant_cont > $max_ccont) {
	$l = ($max_ccont - 1) * 3;
	$m = ($l / 2);
	$pdf->Ln($m);
	$pdf->Cell(170, 3, 'VER RELACION ANEXA', 0, 1, 'C');
	$pdf->Ln($m);
} else {
	for ($k = 0; $k < $max_ccont; $k++) {
		$pdf->Cell(44, 3, $cod_c[$k], 0, 0, 'L');
		$pdf->Cell(100, 3, $den_c[$k], 0, 0, 'L');
		$pdf->Cell(25, 3, $debe_c[$k], 0, 0, 'R');
		$pdf->Cell(25, 3, $haber_c[$k], 0, 1, 'R');
	}
}
$pdf->Cell(200, 2, '', 0, 1, 'L');	



$pdf->Cell(200, 4, 'TSU JOEL  PEREZ                  ', 0, 1, 'L');

 $pdf->Output();
 pg_close();
?>
