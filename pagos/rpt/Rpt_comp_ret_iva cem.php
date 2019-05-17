<?include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; error_reporting(E_ALL ^ E_NOTICE);
function Rellenarcerosizq($str,$n){$numeroarellenar=$n-strlen($str); $texto=""; for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto."0";} $texto=$texto.$str; return $texto;}
if (!$_GET){$ano_fiscal=""; $mes_fiscal=""; $nro_comprobante=""; $criterio="";} else{$criterio=$_GET["criterio"]; $nro_comprobante=substr($criterio,6,8);  $ano_fiscal=substr($criterio,0,4);  $mes_fiscal=substr($criterio,4,2);}
$fecha_hoy=asigna_fecha_hoy();  $clave=$ano_fiscal.$mes_fiscal.$nro_comprobante;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  $error=0;
$direccion=""; $nombre_emp=""; $ced_rif_emp="";$sql="Select * from SIA000 order by campo001"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"]; $direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $ced_rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
$ced_rif="";  $nombre_benef=""; $fecha_e=""; $cant_tot=0;
$sql="Select * from COMP_IVA where ano_fiscal='$ano_fiscal' and  mes_fiscal='$mes_fiscal' and nro_comprobante='$nro_comprobante' and monto_iva_retenido>0"; $res=pg_query($sql);
$filas=pg_num_rows($res); if($filas>0){$registro=pg_fetch_array($res); $fecha_e=$registro["fecha_emision"]; $ced_rif=$registro["ced_rif"];  $nombre_benef=$registro["nombre"]; $referencia=$registro["referencia"];  $inf_usuario=$registro["inf_usuario"];}
else{$error=1; }
$nombre_benef=$nombre_benef;
if($fecha_e==""){$fechae="";}else{$fechae=formato_ddmmaaaa($fecha_e);} $nro_comp=$ano_fiscal.'-'.$mes_fiscal.'-'.$nro_comprobante;
$sql="SELECT count(*) as cant_tot FROM BAN027 where ano_fiscal='$ano_fiscal' and  mes_fiscal='$mes_fiscal' and nro_comprobante='$nro_comprobante'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){ $cant_tot=$registro["cant_tot"]; }  $cant_tot= $cant_tot*1;  $mdes_pie='ORIGINAL';
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $nro_comp; global $fechae; global $nombre_emp; global $ced_rif_emp; global $ano_fiscal; global $mes_fiscal; global $direccion; 
	   global $nombre_benef; global $ced_rif; global $unidad_sol; global $php_os;		
        $this->rect(155,10,60,9);		
		$this->Image('../../imagenes/logo escudo.png',12,7,40);
		$this->SetFont('Arial','B',12);
		$this->Cell(20);
		$this->Cell(100,4,'COMPROBANTE DE RETENCION IVA',0,0,'C');
		$this->SetFont('Arial','B',6);		
		$this->Cell(30,4,'',0,0,'L');
		$this->Cell(60,4,'0.- NRO. DE COMPROBANTE',0,0,'L');
		$this->Cell(5,4,'',0,0,'L');
		
		$this->rect(220,10,50,9);
		$this->Cell(50,4,'1.- FECHA',0,1,'L');
		$this->SetFont('Arial','B',7);
		$this->Cell(15);
		$this->Cell(100,3,'',0,0,'L');
		$this->SetFont('Arial','',8);		
		$this->Cell(30,3,'',0,0,'L');
		$this->Cell(60,3,$nro_comp,0,0,'C');
		$this->Cell(5,3,'',0,0,'L');
		$this->Cell(50,3,$fechae,0,1,'C');
		$this->SetFont('Arial','B',7);
		$this->Cell(15);
		$this->Cell(100,2,'',0,0,'L');
		$this->SetFont('Arial','B',6);		
		$this->Cell(30,2,'',0,0,'L');
		$this->Cell(60,2,'',0,0,'L');
		$this->Cell(5,2,'',0,0,'L');
		$this->Cell(50,2,'',0,1,'L');
		$this->Cell(260,3,'  ',0,1,'L');
		$this->Cell(260,3,'Ley IVA - Art. 11: "Serán responsables del pago del impuesto en calidad de agentes de retención, los compradores o adquirientes de',0,1,'C');
		$this->Cell(260,3,'determinados bienes muebles y los receptores de ciertos servicios, a quienes la Administración designe como tal"',0,1,'C');
		$this->Cell(260,3,'  ',0,1,'L');
		$this->rect(10,31,140,9);
		$this->SetFont('Arial','B',6);		
		$this->Cell(140,4,'2.- NOMBRE O RAZÓN SOCIAL DEL AGENTE DE RETENCIÓN',0,0,'L');
		$this->Cell(5,4,'',0,0,'L');
		$this->rect(155,31,75,9);
		$this->Cell(75,4,'3.- REGISTRO DE INFORMACIÓN FISCAL DEL AGENTE DE RETENCIÓN',0,0,'L');
		$this->rect(235,31,35,9);
		$this->Cell(5,4,'',0,0,'L');
		$this->Cell(35,4,'4.- PERIODO FISCAL',0,1,'L');
		$this->SetFont('Arial','',8);		
		$this->Cell(140,3,$nombre_emp,0,0,'C');
		$this->Cell(5,3,'',0,0,'L');
		$this->Cell(75,3,$ced_rif_emp,0,0,'C');
		$this->Cell(5,3,'',0,0,'L');
		$this->Cell(35,3,'AÑO: '.$ano_fiscal.'   MES: '.$mes_fiscal,0,1,'C');
		$this->SetFont('Arial','B',6);		
		$this->Cell(140,2,'',0,0,'L');
		$this->Cell(5,2,'',0,0,'L');
		$this->Cell(75,2,'',0,0,'L');
		$this->Cell(5,2,'',0,0,'L');
		$this->Cell(35,2,'',0,1,'L');
		$this->Cell(260,3,'  ',0,1,'L');
		$this->rect(10,43,260,9);
		$this->SetFont('Arial','B',6);	
		$this->Cell(260,4,'5.- DIRECCIÓN FISCAL DEL AGENTE DE RETENCIÓN',0,1,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(260,3,$direccion,0,1,'C');		
		$this->SetFont('Arial','B',6);	
		$this->Cell(260,2,'',0,1,'L');
		$this->Cell(260,3,'  ',0,1,'L');		
		$this->rect(10,55,140,9);
		$this->SetFont('Arial','B',6);		
		$this->Cell(140,4,'6.- NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO',0,0,'L');
		$this->rect(155,55,75,9);
		$this->Cell(5,4,'',0,0,'L');
		$this->Cell(75,4,'7.- REGISTRO DE INFORMACIÓN FISCAL DEL SUJETO RETENIDO',0,0,'L');
		$this->Cell(5,4,'',0,0,'L');
		$this->Cell(35,4,'',0,1,'L');		
		$this->SetFont('Arial','',8);		
		$this->Cell(140,3,$nombre_benef,0,0,'C');
		$this->Cell(5,3,'',0,0,'L');
		$this->Cell(75,3,$ced_rif,0,0,'C');
		$this->Cell(5,3,'',0,0,'L');
		$this->Cell(35,3,'',0,1,'L');		
		$this->SetFont('Arial','B',6);		
		$this->Cell(140,2,'',0,0,'L');
		$this->Cell(5,2,'',0,0,'L');
		$this->Cell(75,2,'',0,0,'L');
		$this->Cell(5,2,'',0,0,'L');
		$this->Cell(35,2,'',0,1,'L');
		$this->Cell(260,3,'  ',0,1,'L');		
		//ENCABEZADO DE CELDAS
		$this->SetFont('Arial','B',6);
        $this->SetFillColor(192,192,192);		
		$this->Cell(191,2,'',0,0,'C');
		$this->Cell(46,2,'','LTR',0,'C',true);
		$this->Cell(3,2,'',0,0,'C');
		$this->Cell(20,2,'',0,1,'C');	
 		$this->Cell(191,3,'',0,0,'C');
		$this->Cell(46,3,'COMPRAS INTERNAS O IMPORTACIONES','LR',0,'C',true);
		$this->Cell(3,3,'',0,0,'C');
		$this->Cell(20,3,'',0,1,'C');
		$this->Cell(7,3,'','LTR',0,'C',true);
		$this->Cell(17,3,'','LTR',0,'C',true);
		$this->Cell(25,3,'NÚMERO','LTR',0,'C',true);
		$this->Cell(25,3,'','LTR',0,'C',true);
		$this->Cell(20,3,'','LTR',0,'C',true);
		$this->Cell(20,3,'','LTR',0,'C',true);
		$this->Cell(17,3,'','LTR',0,'C',true);
		$this->Cell(20,3,'NÚMERO DE','LTR',0,'C',true);
		$this->Cell(20,3,' ','LTR',0,'C',true);
		$this->Cell(20,3,'COMPRAS SIN','LTR',0,'C',true);
		$this->Cell(20,3,'','LTR',0,'C',true);
		$this->Cell(6,3,'','LTR',0,'C',true);
		$this->Cell(20,3,'','LTR',0,'C',true);		
		$this->Cell(3,3,'',0,0,'C');
		$this->Cell(20,3,'','LTR',1,'C',true);
		$this->Cell(7,3,'OPER.','LR',0,'C',true);
		$this->Cell(17,3,'FECHA DE','LR',0,'C',true);
		$this->Cell(25,3,'NÚMERO DE','LR',0,'C',true);
		$this->Cell(25,3,'CONTROL DE','LR',0,'C',true);
		$this->Cell(20,3,'NÚMERO','LR',0,'C',true);
		$this->Cell(20,3,'NÚMERO','LR',0,'C',true);
		$this->Cell(17,3,'TIPO DE','LR',0,'C',true);
		$this->Cell(20,3,'FACTURA','LR',0,'C',true);
		$this->Cell(20,3,'TOTAL COMPRAS','LR',0,'C',true);
		$this->Cell(20,3,'DERECHO A','LR',0,'C',true);
		$this->Cell(20,3,'BASE','LR',0,'C',true);
		$this->Cell(6,3,'%','LR',0,'C',true);
		$this->Cell(20,3,'','LR',0,'C',true);		
		$this->Cell(3,3,'',0,0,'C');
		$this->Cell(20,3,'','LR',1,'C',true);
		$this->Cell(7,3,'N°','LRB',0,'C',true);
		$this->Cell(17,3,'LA FACTURA','LRB',0,'C',true);
		$this->Cell(25,3,'LA FACTURA','LRB',0,'C',true);
		$this->Cell(25,3,'LA FACTURA','LRB',0,'C',true);
		$this->Cell(20,3,'NOTA DE DÉBITO','LRB',0,'C',true);
		$this->Cell(20,3,'NOTA DE CRÉDITO','LRB',0,'C',true);
		$this->Cell(17,3,'TRANSACC.','LRB',0,'C',true);
		$this->Cell(20,3,'AFECTADA','LRB',0,'C',true);
		$this->Cell(20,3,'INCLUYENDO IVA','LRB',0,'C',true);
		$this->Cell(20,3,'CRÉDITO IVA','LRB',0,'C',true);
		$this->Cell(20,3,'IMPONIBLE','LRB',0,'C',true);
		$this->Cell(6,3,'ALIC.','LRB',0,'C',true);
		$this->Cell(20,3,'IMPUESTO IVA','LRB',0,'C',true);		
		$this->Cell(3,3,'',0,0,'C');
		$this->Cell(20,3,'IVA RETENIDO','LRB',1,'C',true);	
        $y=$this->GetY();		
		$x=$this->GetX();
		$this->Line(10,$y-0.1,10,170.9);
		$this->Line(17,$y-0.1,17,170.9);
		$this->Line(34,$y-0.1,34,170.9);
		$this->Line(59,$y-0.1,59,170.9);
		$this->Line(84,$y-0.1,84,170.9);
		$this->Line(104,$y-0.1,104,170.9);
		$this->Line(124,$y-0.1,124,170.9);
		$this->Line(141,$y-0.1,141,170.9);
		$this->Line(161,$y-0.1,161,170.9);
		$this->Line(181,$y-0.1,181,170.9);
		$this->Line(201,$y-0.1,201,170.9);
		$this->Line(221,$y-0.1,221,170.9);
		$this->Line(227,$y-0.1,227,170.9);
		$this->Line(247,$y-0.1,247,170.9);
		$this->Line(250,$y-0.1,250,170.9);
		$this->Line(270,$y-0.1,270,170.9);
	}
    function Footer(){ global $total_d; global $total_e; global $total_b; global $total_ret; global $total_iva; global $cant_tot; global $cant_fact; global $mdes_pie;
	    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  
	    $total_d1=formato_monto($total_d); $total_e1=formato_monto($total_e); $total_b1=formato_monto($total_b);
        $total_ret1=formato_monto($total_ret); $total_iva1=formato_monto($total_iva);
		$pag=$this->PageNo();
		$tpag='{nb}';
		if($cant_tot>$cant_fact){$etiq='SUB-TOTAL ';}else{$etiq='TOTAL ';}
		$this->SetY(-45); $y=$this->GetY(); $l=$y-0.2; $p=$y+5.1;
		$this->SetFillColor(192,192,192);
		$this->SetFont('Arial','B',7.5);
		$this->Cell(151,5,$etiq,1,0,'R');
		$this->Cell(20,5,$total_d1,1,0,'R');
		$this->Cell(20,5,$total_e1,1,0,'R');
		$this->Cell(20,5,$total_b1,1,0,'R');
		$this->Cell(6,5,'',1,0,'R');
		$this->Cell(20,5,$total_iva1,1,0,'R');
		$this->Cell(3,5,'',0,0,'R');
		$this->Cell(20,5,$total_ret1,1,1,'R');		
		$this->Cell(200,15,' ',0,1,'C');
        $this->SetFont('Arial','',8);		
		$this->Cell(10,2,'',0,0,'C');
		$this->Cell(80,2,'_________________________________________',0,0,'C');
		$this->Cell(60,2,'',0,0,'C');
		$this->Cell(80,2,'_________________________________________',0,1,'C');
        $this->Cell(10,4,'',0,0,'C');		
		$this->Cell(80,4,'FRIMA Y SELLO AGENTE DE RETENCION',0,0,'C');
		$this->Cell(60,4,'',0,0,'C');	
		$this->Cell(80,4,'FIRMA Y SELLO DE BENEFICIARIO',0,1,'C');		
		$this->Cell(200,5,' ',0,1,'C');
        $this->Cell(50,4,$mdes_pie,0,1,'L');		
		
		//$this->Cell(50,5,'Pagina '.$this->PageNo().'/{nb}',0,1,'R');
	}
  }  
  $pdf=new PDF('L', 'mm', Letter);
  $pdf->AliasNbPages();
  for ($pc=1; $pc <= 2; $pc++) {	
	  $pdf->AddPage();  
	  $pdf->SetFont('Arial','',7);
	  $pdf->SetAutoPageBreak(true, 45);  
	  if($pc==1){$mdes_pie='ORIGINAL - PROVEEDOR';} 
	  if($pc==2){$mdes_pie='COPIA - AGENTE DE RETENCION';} 
      if($pc==3){$mdes_pie='COPIA - CONTABILIDAD';}
	  $i=0;  $res=pg_query($sql);$filas=pg_num_rows($res);
	  $total_d=0;  $total_e=0;  $total_b=0;  $total_iva=0;  $total_ret=0; $cant_fact=0;
	  $y=$pdf->GetY();  
	  $sql="SELECT * FROM BAN027 where ano_fiscal='$ano_fiscal' and  mes_fiscal='$mes_fiscal' and nro_comprobante='$nro_comprobante' order by nro_operacion"; $res=pg_query($sql);
	  while(($registro=pg_fetch_array($res))and($error==0)){ $cant_fact=$cant_fact+1;
		$fecha_e=$registro["fecha_emision"]; if($fecha_e==""){$fechae="";}else{$fechae=formato_ddmmaaaa($fecha_e);} 
		$sfecha=$registro["fecha_documento"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
		$monto=formato_monto($registro["monto_documento"]); $montob=formato_monto($registro["base_imponible"]);  $montos=formato_monto($registro["monto_exento_iva"]);
		$retenc=formato_monto($registro["tasa_retencion"]); $montoi=formato_monto($registro["monto_iva"]); $montor=formato_monto($registro["monto_iva_retenido"]); $espacio=" "; $tasa=round($registro["tasa_iva"],0); $montor=formato_monto($registro["monto_iva_retenido"]);
		$nro_fact="".$espacio.""; $nro_ndb=""; $nro_ncr="";  if($registro["tipo_documento"]=="01"){$nro_fact=$registro["nro_documento"];} $nro_con_d=$registro["nro_con_documento"];
		if($registro["tipo_documento"]=="02"){$nro_ndb=$registro["nro_documento"];} if($registro["tipo_documento"]=="03"){$nro_ncr=$registro["nro_documento"];}
		if($nro_ndb==""){$nro_ndb="".$espacio."";} if($nro_ncr==""){$nro_ncr="".$espacio."";}
		$nro_fact_af=$registro["nro_doc_afectado"]; if($nro_fact_af==""){$nro_fact_af="".$espacio."";}  
		$lf=strlen($nro_fact); if($lf<8){ $nro_fact=Rellenarcerosizq($nro_fact,8); } $lf=strlen($nro_con_d); if($lf<8){ $nro_con_d=Rellenarcerosizq($nro_con_d,8); }
		$pdf->SetFont('Arial','',7.5);	
		$pdf->Cell(7,4,$registro["nro_operacion"],0,0,'C');
		$pdf->Cell(17,4,$fecha,0,0,'C');
		$pdf->Cell(25,4,$nro_fact,0,0,'C');
		$pdf->Cell(25,4,$nro_con_d,0,0,'C');
		$pdf->Cell(20,4,$nro_ndb,0,0,'C');
		$pdf->Cell(20,4,$nro_ncr,0,0,'C');
		$pdf->Cell(17,4,$registro["tipo_transaccion"],0,0,'C');
		$pdf->Cell(20,4,$nro_fact_af,0,0,'C');
		$pdf->Cell(20,4,$monto,0,0,'R');
		$pdf->Cell(20,4,$montos,0,0,'R');
		$pdf->Cell(20,4,$montob,0,0,'R');	
		$pdf->Cell(6,4,$tasa,0,0,'C');
		$pdf->Cell(20,4,$montoi,0,0,'R');		
		$pdf->Cell(3,4,'',0,0,'C');
		$pdf->Cell(20,4,$montor,0,1,'R'); 
		$total_d=$total_d+$registro["monto_documento"]; $total_e=$total_e+$registro["monto_exento_iva"]; $total_b=$total_b+$registro["base_imponible"];
		$total_iva=$total_iva+$registro["monto_iva"]; $total_ret=$total_ret+$registro["monto_iva_retenido"];     
	  }
  }
 $pdf->Output();
 pg_close();
?>