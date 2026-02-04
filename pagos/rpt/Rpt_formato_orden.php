<? error_reporting(E_ALL);include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  $php_os=PHP_OS; $php_os="WINNT"; error_reporting(E_ALL ^ E_NOTICE);
if (!$_GET){ $nro_orden="";$tipo_causado=""; } else{$nro_orden=$_GET["txtnro_orden"];  $tipo_causado=$_GET["txttipo_causado"];} 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname." ");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }

$sqle="Select * from SIA000 order by campo001"; $resultado=pg_query($sqle); $rif_emp=""; $nom_completo=""; $direccion="";
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"]; $direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
$sql="Select * from ORD_PAGO where tipo_causado='$tipo_causado' and nro_orden='$nro_orden'";
$concepto="";$fecha="";$nombre_abrev_caus=""; $ced_rif="";$nombre="";$inf_usuario="";$anulado="";  $tipo_documento="";  $nro_documento=""; $afecta_presu=""; $status_1=""; $usuario_sia="";
$func=""; $inv=""; $con_comp=""; $directa=""; $financ=""; $caja_chica=""; $permanente=""; $orden_permanen=""; $cod_tipo_orden="";
$oc=""; $os=""; $fact=""; $nom=""; $anticipo=""; $recibo=""; $otros="";
$ing_ord=""; $fuente_otra="";

$res=pg_query($sql); $filas=pg_num_rows($res); $total_neto=0;

echo $filas;

if($filas>0){  $registro=pg_fetch_array($res); $nro_orden=$registro["nro_orden"];   $tipo_causado=$registro["tipo_causado"];
  $fecha=$registro["fecha"]; $concepto=utf8_decode($registro["concepto"]); $afecta_presu=$registro["afecta_presu"]; $status_1=$registro["status_1"];
  $inf_usuario=$registro["inf_usuario"];  $nombre_abrev_caus=$registro["nombre_abrev_caus"]; $cod_tipo_orden=$registro["tipo_orden"];
  $ced_rif=$registro["ced_rif"];  $nombre=$registro["nombre"];  $func_inv=$registro["func_inv"];
  $anulado=$registro["anulado"];  $pago_ces=$registro["pago_ces"];  $ced_rif_ces=$registro["ced_rif_ces"]; $usuario_sia=$registro["usuario_sia"];
  $nombre_ces=$registro["nombre_ces"];  $tipo_documento=$registro["tipo_documento"];  $nro_documento=$registro["nro_documento"];
  $total_causado=$registro["total_causado"];  $total_retencion=$registro["total_retencion"];
  $total_ajuste=$registro["total_ajuste"];  $total_pasivos=$registro["total_pasivos"];  $monto_am_ant=$registro["monto_am_ant"];
  $orden_permanen=$registro["orden_permanen"]; 

if($pago_ces=="S"){ $nombre_ces=$nombre_ces;}else { $nombre_ces=""; $ced_rif_ces="";  }
  $total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant + $total_pasivos;
} $tipo_comp='O'.$tipo_causado; $sfecha=$fecha; $referencia=$nro_orden;



if($func_inv=="C"){$func="x";}else{if($func_inv=="I"){$inv="x";}else{$inv="x"; $func="x";}}
if ($tipo_causado<"0002") {$con_comp="x"; $con_imp="x";}else{$con_comp=" "; $con_imp=" ";}
if ($tipo_causado=="0003") {$financ="x";}else{$financ=" ";}



if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);} $total_neto=formato_monto($total_neto); $total_causado=formato_monto($total_causado); $total_aju=formato_monto($total_ajuste); $monto_am_ant=formato_monto($monto_am_ant);
if($afecta_presu=="S"){$tipo_orden="CON IMPUTACION";}else{$tipo_orden="SIN IMPUTACION";}
$sql="SELECT * FROM codigos_causados where tipo_causado='$tipo_causado' and referencia_caus='$nro_orden' order by cod_presup";$res=pg_query($sql);$filas=pg_num_rows($res); $tipo_compromiso=""; $fuente_financ=""; $referencia_comp="";
if($filas>0){  $registro=pg_fetch_array($res); $tipo_compromiso=$registro["tipo_compromiso"]; $fuente_financ=$registro["fuente_financ"]; $referencia_comp=$registro["referencia_comp"]; }
$sql="SELECT * FROM PAG016  where nro_orden='$nro_orden' order by nro_factura";$res=pg_query($sql); $cant_fact=pg_num_rows($res);
$firma="PRESUPUESTO";if(($afecta_presu=="N")and($status_1=="S")){$firma="CONTABILIDAD";}
if(substr($tipo_causado,0,1)=='A'){$referencia='A'.substr($nro_orden,1,7);}
$monto_letras= monto_letras($total_neto);
$usuario_comp=$usuario_sia;



$ing_ord=" ";$fuente_otra=" ";
if ($fuente_financ=="00") {$ing_ord="x";}else{$fuente_otra="x";}
$sql="select * from sia001 where campo101='$usuario_comp'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];}

$total_ret=0; $sqlc="SELECT tipo_retencion,descripcion_ret,cod_presup_ret,tasa_retencion,sum(monto_retencion) as monto_retencion FROM RET_ORD where nro_orden_ret='$nro_orden' group by tipo_retencion,descripcion_ret,cod_presup_ret,tasa_retencion order by tipo_retencion";
$resret=pg_query($sqlc); $filas=pg_num_rows($resret); $k=0; $max_cret=8;
$cod_r=array ('','','','','','','','','','','','','','',''); $tasa_r=array ('','','','','','','','','','','','','','',''); $cod_p_r=array ('','','','','','','','','','','','','','',''); 
$den_r=array ('','','','','','','','','','','','','','',''); $monto_r=array ('','','','','','','','','','','','','','','');
while($registro=pg_fetch_array($resret)){  
$tasa=$registro["tasa_retencion"]; $tasa=formato_monto($tasa); $monto=$registro["monto_retencion"]; $monto=formato_monto($monto); 
$total_ret=$total_ret+$registro["monto_retencion"]; $concepto_ret=utf8_decode($registro["descripcion_ret"]); //$concepto_ret=utf8_decode($concepto_ret);
$concepto_ret=substr($concepto_ret,0,100);
$cod_r[$k]=$registro["tipo_retencion"]; $cod_r[$k]=$registro["tipo_retencion"]; $cod_p_r[$k]=$registro["cod_presup_ret"];
$tasa_r[$k]=$tasa; $monto_r[$k]=$monto; $den_r[$k]=$concepto_ret; if($k<15){$k=$k+1;} } $cant_r=$k;  $total_ret=formato_monto($total_ret); 


$cod_c=array ('','','','','','','','','','','','','','',''); $debe_c=array ('','','','','','','','','','','','','','','');
$den_c=array ('','','','','','','','','','','','','','',''); $haber_c=array ('','','','','','','','','','','','','','','');


$k=0; $max_ccont=8;
$sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$referencia' and tipo_comp='$tipo_comp' and monto_asiento <> 0 order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){$monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";}else{$debe="";$haber=$monto_asiento;} 
$cod_c[$k]=$registro["cod_cuenta"]; $den_c[$k]=$registro["nombre_cuenta"]; $debe_c[$k]=$debe; $haber_c[$k]=$haber; if($k<15){$k=$k+1;}} $cant_cont=$k;


$sqlc="SELECT * FROM codigos_causados where tipo_causado='$tipo_causado' and referencia_caus='$nro_orden' order by cod_presup";
$resc=pg_query($sqlc); $filas=pg_num_rows($resc); $cant_cod_presup=$filas; $max_cpre=15; 


require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $nro_orden; global $func_inv; global $tipo_orden; global $fecha; global $nombre; global $ced_rif; global $ced_rif_ces; global $nombre_ces;
	   global $concepto; global $php_os; global $func; global $inv;	global	$con_comp; global $directa; global $financ; global $caja_chica;
	   global $permanente; global $monto_letras; global $total_neto; global $cant_r; global $max_cret; global $total_causado; global $con_imp;
	   global $cod_r; global $den_r; global $tasa_r;  global $monto_r; global $cod_p_r;	global $total_ret; global $total_aju; global $total_neto; global $monto_am_ant;	    
        
		$this->Image('../../imagenes/Logo_emp.png',10,7,25);
		//$this->rect(10,25,200,250);	
		$this->Ln(8);		
		$this->SetFont('Arial','B',10);
		$this->Cell(130,4,' ',0,0,'C');
		$this->SetFont('Arial','B',12);	   
		$this->Cell(40,5,'ORDEN DE PAGO NRO.: '.$nro_orden,0,1,'C');
		$this->Ln(6);
        		
		$this->SetFont('Arial','',9);        
		$y=$this->GetY();		
		$this->rect(10,28,200,247);	
		$this->Cell(155,1,'  ','R',0,'L');
		$this->Cell(45,1,'  ','R',1,'L');
		
		$this->Cell(5,5,'',0,0,'L');
		$this->Cell(2.5,3.5,$con_imp,1,0,'C');
		$this->SetFont('Arial','',9);
		$this->Cell(70,5,'Con Imputacion Presupuestaria',0,0,'L');
		$this->Cell(5,5,'',0,0,'L');
		$this->Cell(2.5,3.5,$financ,1,0,'C');
		$this->Cell(68,5,'Sin Imputacion Presupuestaria',0,0,'L');	
        $this->Cell(2,5,'  ','R',0,'L');
		
		$this->SetFont('Arial','B',9);
		$this->Cell(20,5,'FECHA :  ',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(25,5,$fecha,0,1,'C');
		$this->Cell(155,1,'  ','R',0,'L');
		$this->Cell(45,1,'  ','R',1,'L');
		
		$this->SetFont('Arial','B',9);
		$this->Cell(25,5,'BENEFICIARIO :','T',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(130,5,$nombre,'T',0,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(21,5,'CEDULA/RIF :  ','TL',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(24,5,$ced_rif,'T',1,'C');		
		$this->SetFont('Arial','B',9);
		$this->Cell(30,5,'CHEQUE A FAVOR :','B',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(125,5,$nombre_ces,'B',0,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(21,5,'CEDULA/RIF :  ','BL',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(24,5,$ced_rif_ces,'B',1,'C');
		$y=$this->GetY();
		$monto_letras="POR LA CANTIDAD DE: ".$monto_letras;  $part2="";
		$part1=$monto_letras; $l=strlen($part1); if($l>105){$part1=substr($monto_letras,0,105); $part2=substr($monto_letras,106,255); }
        $this->Cell(200,5,$part1,0,1);   
		$this->Cell(200,4,$part2,'B',1);
		//$this->Line(180,$y,180,$y+8);	
        $this->Cell(200,0.5,'',0,1,'L');		
        $this->MultiCell(200,4,'POR CONCEPTO DE: '.$concepto,0);
		$this->Cell(200,2,' ','B',1,'C');
		$this->SetFont('Arial','B',9);
		$this->Cell(175,5,'MONTO BRUTO Bs.','B',0,'R');		
		$this->Cell(25,5,$total_causado,'B',1,'R'); 
		$this->SetFont('Arial','',9);
		
       
		$this->SetFont('Arial','B',8);			
		$this->Cell(9,5,'Cod','B',0,'L');
		$this->Cell(117,5,'Descripcion','B',0,'L');
		$this->Cell(35,5,'Codigo Presupuestario','B',0,'L');
		$this->Cell(12,5,'Tasa(%)','B',0,'C');
		$this->Cell(27,5,'Monto Retencion','B',1,'C');
        $this->SetFont('Arial','',8);		
		$z=$this->GetY();
		if($cant_r>$max_cret){ $l=($max_cret-1)*4; $m=($l/2);
		   $this->Ln($m);
		   $this->Cell(180,4,'VER RELACION ANEXA',0,1,'C');
		   $this->Ln($m);
		}else{ for ($k=0; $k<$max_cret; $k++) {  $tdes=substr($den_r[$k],0,70);
		  $this->Cell(9,4,$cod_r[$k],0,0,'L'); 
	      $this->Cell(117,4,$tdes,0,0,'L'); 
		  $this->Cell(35,4,$cod_p_r[$k],0,0,'L'); 
		  
          $this->Cell(12,4,$tasa_r[$k],0,0,'R'); 		  
	      $this->Cell(25,4,$monto_r[$k],0,1,'R'); 
		} }
		$y=$this->GetY();
		$this->Line(185,$y-0.2,210,$y-0.2);
		$this->SetFont('Arial','B',9);
		$this->Cell(175,5,'TOTAL RETENCIONES Bs.',0,0,'R');
		$this->Cell(25,5,$total_ret,0,1,'R'); 
		
		$this->Cell(175,1,'',0,0,'R');
		$this->Cell(25,1,'','T',1,'R'); 
		$this->Cell(175,5,'MONTO NETO Bs.',0,0,'R');
		$this->Cell(25,5,$total_neto,'T',1,'R'); 
		
		$y=$y+3.5;
		//$this->Line(10,$y,210,$y);
		
		$this->SetFont('Arial','B',9);		
		$this->Cell(200,4,'CODIFICACION PRESUPUESTARIA',1,1,'C');
        $this->SetFont('Arial','B',8);		
		$this->Cell(36,4,'Codigo Presupuestario   ',1,0,'C');
		$this->Cell(144,4,'Denominacion',1,0,'C');
		$this->Cell(20,4,'Monto',1,1,'C');
		$this->SetFont('Arial','',7);
	}	
	
	function Footer(){ global $max_ccont; global $cant_cont; global $cod_c; global $debe_c; global $den_c; global $haber_c;
	                   global $oc; global $os; global $fact; global $nom; global $anticipo; global $recibo; global $otros;
                       global $ing_ord; global $fuente_otra;
		$this->SetY(-75);
        //$this->Line(10,$p,210,$p);			
		$this->SetFont('Arial','B',9);
		$this->Cell(200,5,'CONTABILIDAD FISCAL',1,1,'C');
        $this->SetFont('Arial','B',8);		
		$this->Cell(30,4,'Codigo de Cuenta',1,0,'C');
		$this->Cell(130,4,'Nombre',1,0,'C');
		$this->Cell(20,4,'Debe',1,0,'C');
		$this->Cell(20,4,'Haber',1,1,'C');
		$this->SetFont('Arial','',8);
		$z=$this->GetY();
		if($cant_cont>$max_ccont){ $l=($max_ccont-1)*3; $m=($l/2);
		   $this->Ln($m);
		   $this->Cell(180,4,'VER RELACION ANEXA',0,1,'C');
		   $this->Ln($m);
		}else{ for ($k=0; $k<$max_ccont; $k++) {  
		  $this->Cell(30,4,$cod_c[$k],0,0,'L'); 
	      //$this->Cell(128,3,$den_c[$k],0,0,'L');
          $x=$this->GetX();   $y=$this->GetY();  $n=130;
          $this->SetXY($x+$n,$y);		  
	      $this->Cell(20,4,$debe_c[$k],0,0,'R');
          $this->Cell(20,4,$haber_c[$k],0,1,'R'); 
          $this->SetXY($x,$y);
	      $this->MultiCell($n,4,$den_c[$k],0);		  
		} }
		$y=$this->GetY();
        //$this->Line(40,$z,40,$y-0.1);
		//$this->Line(168,$z,168,$y-0.1);
        //$this->Line(190,$z,190,$y-0.1);			
		$y=$this->GetY();		
        $this->Cell(60,4,'ELABORADO POR',1,0,'C');	
		$this->Cell(70,4,'DIRECCION DE ADMINITRACION Y SERVICIOS',1,0,'C');
		$this->Cell(70,4,'CONTRALOR MUNICIPAL',1,1,'C');		
		$z=$this->GetY();		
		$this->SetFont('Arial','',7);
		$this->Cell(60,23,' ','LR',0,'C');		
		$this->Cell(70,23,' ','R',0,'C');	
		$this->Cell(70,23,'','R',1,'C');			
			
		$this->Ln(1);
		$this->SetFont('Arial','',5);
		$this->Cell(100,2,'',0,0,'L');
		$this->Cell(100,2,'',0,1,'R');
	}
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',8);
  $pdf->SetAutoPageBreak(true, 75);  
  $i=0;  
  if($cant_cod_presup>$max_cpre){
    $pdf->Ln(20);
	$pdf->Cell(180,4,'VER RELACION ANEXA',0,1,'C');
  }else{ $total=0;
  $sql="SELECT * FROM codigos_causados where tipo_causado='$tipo_causado' and referencia_caus='$nro_orden' order by cod_presup";$res=pg_query($sql);$filas=pg_num_rows($res);
  while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto"]); $total=$total+$registro["monto"]; $denominacion=$registro["denominacion"];
    $denominacion=substr($denominacion,0,140); //if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}
    //$pdf->Cell(42,4,$registro["cod_presup"]."  ".$registro["fuente_financ"] ,0,0,'L');  
	//$pdf->Cell(135,3,substr($denominacion,0,89),0,0,'L');
	$pdf->SetFont('Arial','',7.5);
	$pdf->Cell(36,4,$registro["cod_presup"] ,0,0,'L'); 
	$x=$pdf->GetX();   $y=$pdf->GetY();  $n=144;	   
	$pdf->SetXY($x+$n,$y);
	$pdf->Cell(20,4,$monto,0,1,'R');
	$pdf->SetXY($x,$y);
	$pdf->MultiCell($n,4,$denominacion,0);
	
	
  }}
 /*nmdb*/
 ob_end_clean();
 $pdf->Output();
 pg_close();
?>

