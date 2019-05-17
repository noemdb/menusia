<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){$cod_banco='';$num_cheque=''; }  else{$cod_banco=$_GET["cod_banco"];$num_cheque=$_GET["num_cheque"];}
$sql="Select * from EDO_CHEQUES where cod_banco='$cod_banco' and num_cheque='$num_cheque'";

$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
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
//if ($mes=="01"){$mes="ENERO";}else{if ($mes=="02"){$mes="FEBRERO";}else{$mes="MARZO";}}
if ($mes=="01"){$mes="ENERO";}else{if ($mes=="02"){$mes="FEBRERO";}else{if ($mes=="03"){$mes="MARZO";}else {if ($mes=="04"){$mes="ABRIL";}else {if ($mes=="05"){$mes="MAYO";}else {if ($mes=="06"){$mes="JUNIO";}else {if ($mes=="07"){$mes="JULIO";}else {if ($mes=="08"){$mes="AGOSTO";}else {if ($mes=="09"){$mes="SEPTIEMBRE";}else {if ($mes=="10"){$mes="OCTUBRE";}else {if ($mes=="11"){$mes="NOVIEMBRE";}else {$mes="DICIEMBRE";}}}}}}}}}}}

$lugar="SAN FELIPE, ".substr($fecha,0,2)." DE ".$mes; $ano=substr($fecha,6,4); $facturas="";

//$sql="SELECT * FROM PAG016  where  nro_orden in (select nro_orden from pag001 where status='I' and nro_cheque='$num_cheque')  order by nro_factura";$res=pg_query($sql);
//while($registro=pg_fetch_array($res)){  $nro_fact=$registro["nro_factura"]; $nro_control=$registro["nro_con_factura"];  $nro_fact=elimina_ceros($nro_fact);  $nro_control=elimina_ceros($nro_control);
//if($facturas==""){$facturas=" FACTURA: ".$nro_fact;}else{$facturas=$facturas.", ".$nro_fact; } }
//concepto=$concepto.$facturas;


//$sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$num_cheque' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
//while($registro=pg_fetch_array($res)){$monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);
//if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";}else{$debe="";$haber=$monto_asiento;} }

$cod_c=array ('','','','','','','','','','','','','','',''); $debe_c=array ('','','','','','','','','','','','','','','');
$den_c=array ('','','','','','','','','','','','','','',''); $haber_c=array ('','','','','','','','','','','','','','','');


$k=0; $max_ccont=6;
$sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$num_cheque' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){$monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";}else{$debe="";$haber=$monto_asiento;} 
$cod_c[$k]=$registro["cod_cuenta"]; $den_c[$k]=$registro["nombre_cuenta"]; $debe_c[$k]=$debe; $haber_c[$k]=$haber; if($k<15){$k=$k+1;}} $cant_cont=$k;

$sqlc="SELECT cod_presup,denominacion,sum(monto) as monto_chq FROM codigos_pagos where referencia_pago='$num_cheque' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' group by cod_presup,denominacion order by cod_presup";
//$sqlc="SELECT * FROM codigos_causados where tipo_causado='$tipo_causado' and referencia_caus='$nro_orden' order by cod_presup";
$resc=pg_query($sqlc); $filas=pg_num_rows($resc); $cant_cod_presup=$filas; $max_cpre=35; 


require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $monto_cheque; global $nombre_benef; global $monto_letras; global $lugar; global $ano; global $nombre_banco; 
	   global $concepto; global $nro_cuenta; global $num_cheque; global $fecha; global $nro_orden;  
        $this->AddFont('lucon','','lucon.php');		
		$this->SetFont('lucon','',10);
		//$this->Cell(200,4,'',0,1,'L');
		//$this->Cell(200,4,'   ',0,1,'L');
		$this->Cell(120,4,'',0,0,'L');
		$this->Cell(80,4,'***'.$monto_cheque.'***',0,0,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(10,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(10,4,'',0,0,'L');
                $this->SetFont('lucon','',9);
		$nombre_benef=utf8_decode($nombre_benef);
		$this->Cell(180,4,'***'.$nombre_benef.'***',0,0,'L');
		$this->Cell(10,4,'',0,1,'L');
		$this->SetFont('lucon','',2);
		//$this->Cell(200,2,'',1,1,'L');
		//$this->Cell(5,4,'',0,0,'L');
		//$this->MultiCell(175,8,'       '.$monto_letras,'T');
		$this->Cell(200,4,'',0,1,'L'); //aqui sume 2
		$this->SetFont('lucon','',10);
		$long_line=78; $part1=$monto_letras; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($monto_letras,0,$long_line); }
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
		//$this->Write(5,'PRUEBA');
		$this->Cell(55,4,$lugar,0,0,'L');
                
		$this->Cell(40,4,$ano,0,1,'L');
                $this->Cell(95,4,'',0,0,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		//$this->Cell(200,4,'',0,1,'L');
		//$this->Cell(200,4,'',0,1,'L');
		//$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->SetFont('lucon','U',10);
		$this->Cell(180,4,'CADUCA A LOS 60 DIAS',0,0,'C');
		$this->Cell(20,4,'',0,1,'L');
        $this->SetFont('lucon','',10);		
		$this->Cell(200,38,'',0,1,'L');		// aqui reste 2
		$this->Cell(100,4,'',0,0,'L');
		$this->Cell(60,4,$num_cheque,0,0,'L');
		$this->Cell(40,4,$fecha,0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->SetFont('lucon','U',10);
		$this->Cell(20,4,'Banco:',0,0,'L');		
		$this->SetFont('lucon','',10);
		$this->Cell(130,4,$nombre_banco." ".$nro_cuenta,0,0,'L');
		$this->SetFont('lucon','U',10);
		$this->Cell(25,4,'Cheque:',0,0,'L');
		$this->SetFont('lucon','',10);
		$this->Cell(25,4,$num_cheque,0,1,'L');
		$this->MultiCell(200,4,'Por Concepto de: '.$concepto,0);
		$this->SetFont('lucon','U',10);
		$this->Cell(175,4,'S/OP Nº:',0,0,'R');
		$this->SetFont('lucon','',10);
		$this->Cell(25,4,$nro_orden,0,1,'R');
		$this->Cell(200,4,'',0,1,'L');
		$this->SetFont('lucon','',10);
		$this->Cell(150,4,'CODIGOS PRESUPUESTARIOS','B',0,'L');
		$this->Cell(50,4,'MONTO','B',1,'L');
        $this->Cell(200,1,'',0,1,'L');		
		$y=$this->GetY();
		//$this->Line(10,$y-0.04,210,$y-0.04);
	}
    function Footer(){ global $max_ccont; global $cant_cont; global $cod_c; global $debe_c; global $den_c; global $haber_c;
		$this->SetY(-65);
        //$this->Line(10,$p,210,$p);			
		$this->SetFont('lucon','',9);	
		$this->Cell(36,3,'COD. CONTABLE',1,0,'L');
		$this->Cell(118,3,'NOMBRE DE LA CUENTA',1,0,'L');
		$this->Cell(23,3,'DEBE',1,0,'C');
		$this->Cell(23,3,'HABER',1,1,'C');
		$this->Cell(200,1,'',0,1,'L');
		$this->SetFont('lucon','',9);
		$z=$this->GetY();
		if($cant_cont>$max_ccont){ $l=($max_ccont-1)*3; $m=($l/2);
		   $this->Ln($m);
		   $this->Cell(180,3,'VER RELACION ANEXA',0,1,'C');
		   $this->Ln($m);
		}else{ for ($k=0; $k<$max_ccont; $k++) {  
		  $this->Cell(36,3,$cod_c[$k],0,0,'L'); 
	      $this->Cell(118,3,$den_c[$k],0,0,'L'); 					
	      $this->Cell(23,3,$debe_c[$k],0,0,'R');
          $this->Cell(23,3,$haber_c[$k],0,1,'R'); 		  
		} }
		$this->SetFont('lucon','',10);		
		$this->Cell(40,4,'Preparado Por:',1,0,'C');		
		$this->Cell(40,4,'Registrado Por:',1,0,'C');
		$this->Cell(40,4,'Revisado Por:',1,0,'C');
		//$this->rect(130,239.2,40.2,20.2);
		$this->Cell(40,4,'Recibido Por:',1,0,'C');
		//$this->rect(170,239.2,40,20);
		$this->Cell(40,4,'Rif/C.I.:',1,1,'C');
		$this->Cell(40,8,'',1,0,'C');
		$this->Cell(40,8,'',1,0,'C');
		$this->Cell(40,8,'',1,0,'C');
		$this->Cell(40,8,'','LR',0,'C');
		$this->Cell(40,8,'','LR',1,'C');
		$this->Cell(120,4,'Autorizado:',1,0,'C');
		$this->Cell(40,4,'','LR',0,'C');
		$this->Cell(40,4,'','LR',1,'C');
		$this->Cell(120,8,'',1,0,'C');
		$this->Cell(40,8,'','LRB',0,'C');
		$this->Cell(40,8,'','LRB',1,'C');		
		$this->Ln(2);
		$this->SetFont('lucon','',6);
		$this->Cell(200,4,'SIA Control Bancario',0,1,'R');
	}
  
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('lucon','',10);
  $pdf->SetAutoPageBreak(true, 65);
  $i=0;  
  $total=0;
  if($cant_cod_presup>$max_cpre){
    $pdf->Ln(20);
	$pdf->Cell(180,3,'VER RELACION ANEXA',0,1,'C');
  }else{
  $sql="SELECT cod_presup,denominacion,sum(monto) as monto_chq FROM codigos_pagos where referencia_pago='$num_cheque' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' group by cod_presup,denominacion order by cod_presup";$res=pg_query($sql);$filas=pg_num_rows($res);
  while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto_chq"]); $total=$total+$registro["monto_chq"];$total=formato_monto($total); $denominacion=$registro["denominacion"]; 
    $denominacion=substr($denominacion,0,140); if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}
    $pdf->Cell(175,3,$registro["cod_presup"],0,0,'L');
	// $pdf->Cell(135,3,substr($denominacion,0,89),0,0,'L');
	$pdf->Cell(25,3,$monto,0,1,'R');
  }}

 $pdf->Output();
 pg_close();
?>
