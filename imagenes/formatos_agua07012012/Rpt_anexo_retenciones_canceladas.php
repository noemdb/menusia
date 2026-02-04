<?php include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){ $nro_orden="";$tipo_causado=""; } else{$nro_orden=$_GET["txtnro_orden"];  $tipo_causado=$_GET["txttipo_causado"];}
$sql="Select * from ORD_PAGO where tipo_causado='$tipo_causado' and nro_orden='$nro_orden'";
$rif_emp="G-20009014-6";
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$concepto="";$fecha="";$nombre_abrev_caus=""; $ced_rif="";$nombre="";$inf_usuario="";$anulado="";  $tipo_documento="";  $nro_documento=""; $afecta_presu=""; $status_1=""; $usuario_sia="";
$func=""; $inv=""; $con_comp=""; $directa=""; $financ=""; $caja_chica=""; $permanente=""; $orden_permanen=""; $cod_tipo_orden="";
$oc=""; $os=""; $fact=""; $nom=""; $anticipo=""; $recibo=""; $otros="";
$ing_ord=""; $fuente_otra="";
$res=pg_query($sql); $filas=pg_num_rows($res); $total_neto=0;
if($filas>0){  $registro=pg_fetch_array($res); $nro_orden=$registro["nro_orden"];   $tipo_causado=$registro["tipo_causado"];
  $fecha=$registro["fecha"];  $concepto=$registro["concepto"]; $afecta_presu=$registro["afecta_presu"]; $status_1=$registro["status_1"];
  $inf_usuario=$registro["inf_usuario"];  $nombre_abrev_caus=$registro["nombre_abrev_caus"]; $cod_tipo_orden=$registro["tipo_orden"];
  $ced_rif=$registro["ced_rif"];  $nombre=$registro["nombre"];  $func_inv=$registro["func_inv"];
  $anulado=$registro["anulado"];  $pago_ces=$registro["pago_ces"];  $ced_rif_ces=$registro["ced_rif_ces"]; $usuario_sia=$registro["usuario_sia"];
  $nombre_ces=$registro["nombre_ces"];  $tipo_documento=$registro["tipo_documento"];  $nro_documento=$registro["nro_documento"];
  $total_causado=$registro["total_causado"];  $total_retencion=$registro["total_retencion"];
  $total_ajuste=$registro["total_ajuste"];  $total_pasivos=$registro["total_pasivos"];  $monto_am_ant=$registro["monto_am_ant"];
  $orden_permanen=$registro["orden_permanen"];
  $total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant + $total_pasivos;
} $tipo_comp='O'.$tipo_causado; $sfecha=$fecha; $referencia=$nro_orden;

if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);} $total_neto=formato_monto($total_neto); $total_causado=formato_monto($total_causado); $total_aju=formato_monto($total_ajuste); 
if($afecta_presu=="S"){$tipo_orden="CON IMPUTACION";}else{$tipo_orden="SIN IMPUTACION";}
$sql="SELECT * FROM codigos_causados where tipo_causado='$tipo_causado' and referencia_caus='$nro_orden' order by cod_presup";$res=pg_query($sql);$filas=pg_num_rows($res); $tipo_compromiso=""; $fuente_financ=""; $referencia_comp="";
if($filas>0){  $registro=pg_fetch_array($res); $tipo_compromiso=$registro["tipo_compromiso"]; $fuente_financ=$registro["fuente_financ"]; $referencia_comp=$registro["referencia_comp"]; }
$sql="SELECT * FROM PAG016  where nro_orden='$nro_orden' order by nro_factura";$res=pg_query($sql); $cant_fact=pg_num_rows($res);
$firma="PRESUPUESTO";if(($afecta_presu=="N")and($status_1=="S")){$firma="CONTABILIDAD";}
if(substr($tipo_causado,0,1)=='A'){$referencia='A'.substr($nro_orden,1,7);}
$monto_letras= monto_letras($total_neto);
$usuario_comp=$usuario_sia;

$sql="select * from sia001 where campo101='$usuario_comp'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];}

require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $nro_orden; global $tipo_orden; global $fecha; global $php_os; global $total_ret; 
	    
        $this->rect(10,5,200,270);		
		$this->Image('../../imagenes/logo escudo.png',12,8,13);
		$this->SetFont('Arial','B',9);
		$this->Cell(25);
		$this->Cell(100,3,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,0,'L');
		$this->Cell(75,3,'',0,1,'R');
		$this->Cell(25);
		$this->Cell(100,3,'GOBERNACION DEL ESTADO YARACUY',0,1,'L');
		$this->Cell(25);
		$this->Cell(100,3,'COORDINACION DE ORDENAMIENTO DE PAGOS',0,1,'L');				
		$this->Ln(4);
		$this->SetFont('Arial','B',12);
		$this->Cell(200,3,'RELACION ANEXA ORDEN DE PAGO N� '.$nro_orden,0,1,'C');	
		$this->Ln(2);
		$this->SetFont('Arial','B',9);
		$this->Cell(180,3,'FECHA: ',0,0,'R');
		$this->Cell(20,3,$fecha,0,1,'R');
		$this->Ln(2);		
		$this->Cell(200,3,' ',0,1,'C');
		$this->SetFont('Arial','B',12);
        $this->Cell(200,5,'RETENCIONES CANCELADAS',1,1,'C');
		
		$this->SetFont('Arial','',7);
		$this->Cell(20,3,'Nro.Orden',1,0,'C');
		$this->Cell(15,3,'Codigo',1,0,'C');
		$this->Cell(135,3,'Descripcion',1,0,'C');
		$this->Cell(30,3,'Monto Retencion',1,1,'C');
		 	
		 
	}
	
	function Footer(){$ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		$this->SetY(-10);		
        $this->SetFillColor(255,0,0);
		$this->Ln(5);
		$this->SetFont('Arial','I',5);
		$this->Cell(50,4,'SIPAP Ordenamiento de Pago',0,0,'L');
		$this->Cell(50,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
		$this->Cell(100,5,'fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
	} 
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $pdf->SetAutoPageBreak(true, 10);  
  $i=0;  

  $total_ret=0; 
  $sql="SELECT * FROM OP_RET_CANC where nro_cheque_r='$nro_orden' order by nro_orden_ret,tipo_retencion";
  $res=pg_query($sql);
  
  $total=0; $monto=0;
  while($registro=pg_fetch_array($res)){
     if($total==0){$monto=0;
		$prev_orden = $registro["nro_orden_ret"];$prev_tipo = $registro["tipo_retencion"];
		$prev_concepto = $registro["des_orden_ret"];$prev_des_ret = $registro["descripcion_ret"];
		$prev_con_cont = $registro["cod_contable_ret"];}
		if (($prev_orden!=$registro["nro_orden_ret"]) or ($prev_tipo!=$registro["tipo_retencion"])) {
		   $monto=formato_monto($monto);$prev_concepto=substr($prev_concepto,0,140);$prev_des_ret=$prev_des_ret;
           $pdf->Cell(20,3,$prev_orden,0,0,'L'); 
	       $pdf->Cell(15,3,$prev_tipo,0,0,'L');
	       $pdf->Cell(135,3,$prev_des_ret,0,0,'L'); 
	       $pdf->Cell(28,3,$monto,0,1,'R');	   
	       $monto=0;
		   $prev_orden = $registro["nro_orden_ret"];$prev_tipo = $registro["tipo_retencion"];
		   $prev_concepto = $registro["des_orden_ret"]; $prev_des_ret = $registro["descripcion_ret"];
		   $prev_con_cont = $registro["cod_contable_ret"];
		}
        $monto=$monto+$registro["monto_retencion"];$total=$total+$registro["monto_retencion"];
	}  
    if ($monto>0) { $monto=formato_monto($monto);
       $pdf->Cell(20,3,$prev_orden,0,0,'L'); 
	   $pdf->Cell(15,3,$prev_tipo,0,0,'L');
	   $pdf->Cell(135,3,$prev_des_ret,0,0,'L'); 
	   $pdf->Cell(28,3,$monto,0,1,'R');	 

    }
  $total_ret=formato_monto($total);
  $pdf->Cell(200,2,'',0,1,'R');
  $y=$pdf->GetY();
  $pdf->Line(185,$y-0.2,210,$y-0.2);
  $pdf->Cell(175,3,'TOTAL RETENCIONES Bs.',0,0,'R');
  $pdf->Cell(25,3,$total_ret,0,1,'R');
 $pdf->Output();
 pg_close($conn);
?>

