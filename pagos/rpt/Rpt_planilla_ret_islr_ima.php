<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS;
$orden=$_GET["orden"];  $tipo_planilla=$_GET["tipo"]; $ano_fiscal="";
$fecha_hoy=asigna_fecha_hoy();
$nombre_planilla="COMPROBANTE DE RETENCION DE IMPUESTO SOBRE LA RENTA";

if($tipo_planilla=="01"){$nombre_planilla="COMPROBANTE DE RETENCION ISLR"; }
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$direccion=""; $nombre_emp="IMAUBAR"; $ced_rif_emp="J-08529006-0"; $nro_ord=' ';
$nro_comp=""; $sustraendo=0; $descripcion_ret=""; $fechae=""; $tipo_en=""; $tipo_documento=""; $nro_documento=""; $nro_con_factura=""; $fecha=""; $descripcion=""; $tipo_operacion="A";
$ced_rif="";  $nombre_benef=""; $monto_r=0; $monto_o=0; $tasa=0; $error=0;
$sql="select concepto,ced_rif from PAG001 where nro_orden='$orden' and anulado='N'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res)){ $des_orden=$registro["concepto"];  $ced_rif=$registro["ced_rif"]; }
$clasificacion="00";
$sSQL="SELECT ced_rif,clasificacion FROM pre099 WHERE ced_rif='$ced_rif'";  $res=pg_query($sSQL);
if ($registro=pg_fetch_array($res)){  $clasificacion=$registro["clasificacion"]; }
  
 $sql="SELECT sum (monto_factura) as monto_factura, sum (monto_iva1) as monto_iva1, sum (monto_iva1_so) as monto_iva1_so, sum (monto_sin_iva) as monto_sin_iva FROM PAG016  where nro_orden='$orden'  and status_2='N'"; $res=pg_query($sql);
 if ($registro=pg_fetch_array($res)){  
  $monto_bruto=formato_monto($registro["monto_factura"]);
  $monto_iva=formato_monto($registro["monto_iva1"]);
  
  $monto_sin_iva=formato_monto($registro["monto_sin_iva"]);
  
  if($clasificacion=="CLINICAS"){ $monto_sin_iva=formato_monto($registro["monto_sin_iva"]); }
     else{$monto_sin_iva=formato_monto($registro["monto_iva1_so"]); }
	 
   
}
 $sql="SELECT tasa_iva1 FROM PAG016  where nro_orden='$orden'  and status_2='N'"; $res=pg_query($sql);
 if ($registro=pg_fetch_array($res)){
  $tasa_iva=formato_monto($registro["tasa_iva1"]);
  
}
  
$sql="select * from planillas_ret where tipo_planilla='$tipo' and nro_orden='$orden' and anulada='N'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res)){  
  $aux_orden=$registro["aux_orden"]; $tipo_ret=$registro["tipo_retencion"];  $planilla=$registro["tipo_planilla"]; $nro_planilla=$registro["nro_planilla"]; $descripcion=$registro["descripcion"];
  $monto_r=formato_monto($registro["monto_retencion"]); $monto_o=formato_monto($registro["monto_objeto"]); $tasa=$registro["tasa"];
  $descripcion_ret=$registro["descripcion_ret"]; $tipo_en=$registro["tipo_en"];   $tipo_documento=$registro["tipo_documento"]; $monto_pago=$registro["monto_pago"];
  $nro_documento=$registro["nro_documento"];  $nro_con_factura=$registro["nro_con_factura"]; $sfecha=$registro["fecha_factura"];
  $efecha=$registro["fecha_emision"]; $fechae = substr($efecha,8,2)."/".substr($efecha,5,2)."/".substr($efecha,0,4);  $ano_fiscal=substr($criterio,0,4);
  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
  $nro_comp=$nro_planilla; $ced_rif=$registro["ced_rif"];  $nombre_benef=$registro["nombre"]; $nro_orden=$registro["nro_orden"];
  $ciudad=$registro["ciudad"]; $estado=$registro["estado"]; $telefono=$registro["telefono"]; $direccion=$registro["direccion"]; $referencia=$registro["referencia"];
  $sustraendo=$registro["sustraendo"];  
 } 
 
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $nro_comp; global $fecha; global $nombre_emp; global $ced_rif_emp; global $ano_fiscal; global $mes_fiscal; global $direccion; global $nombre_planilla; global $nro_ord; global $monto_pago;
	   global $nombre_benef; global $ced_rif; global $unidad_sol; global $php_os; global $des_orden; global $fechae; global $orden;	global $monto_bruto; global $estado; global $fechae;  global $nro_con_factura; global $referencia;
	   global $monto_iva; global $monto_sin_iva; global $monto_r; global $tasa_iva; global $clasificacion; global $monto_o; global $tasa; global $descripcion_ret; global $ciudad; global $tipo_documento; global $telefono; global $tipo_en;
        $monto_pago=formato_monto($monto_pago);
		$this->Image('../../imagenes/logo escudo.png',12,8,20);
		$this->Cell(18);
		$this->SetFont('Arial','B',9);		
		$this->Cell(150,3,utf8_decode($nombre_emp),0,0,'L');
		$this->Cell(35,3,'',0,0,'L');		
		$this->Cell(50,3,'',0,1,'L');		
		$this->Cell(15);
		$this->SetFont('Arial','B',8);
		$this->Cell(100,3,' ',0,0,'L');
		$this->Cell(35,3,'',0,0,'L');		
		
		$this->SetFont('Arial','B',8);
		$this->Cell(100,3,' ',0,0,'L');
		$this->Cell(35,3,'',0,0,'L');		
		$this->SetFont('Arial','',8);
		$this->Cell(24,3,$fechae,'LR',0,'C');
		$this->Cell(26,3,$orden,'LR',1,'C');		
		$this->Cell(15);
		$this->SetFont('Arial','B',2);
		$this->Cell(100,1,'  ',0,0,'L');
		$this->Cell(35,1,'',0,0,'L');
		$this->Cell(24,1,' ',0,0,'C');
		$this->Cell(26,1,' ',0,1,'C');		
		$this->Cell(200,5,' ',0,1,'L');
		$this->Ln(4);
		$this->SetFont('Arial','BI',12);
		$this->Cell(200,6,$nombre_planilla,1,1,'C');
		$this->Ln(4);	
		
		
		$this->SetFont('Arial','B',8);		
		$this->Cell(170,3,'N° DE COMPROBANTE:  ',0,0,'R');
		$this->SetFont('Arial','',8);
		$this->Cell(30,3,substr($fechae,6,4)." - ".substr($fechae,3,2)." - ".$nro_comp,0,1,'C');			
		$this->Cell(15);
		$this->SetFont('Arial','B',8);
		$this->Cell(100,3,'',0,0,'L');
		$this->Cell(35,3,'',0,0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(200,3,$nro_comp,0,1,'R');			
		$this->Cell(15);
		$this->SetFont('Arial','B',2);
		$this->Cell(100,1,'  ',0,0,'L');
		$this->Cell(35,1,'',0,0,'L');
			
		$this->Cell(15);
		$this->SetFont('Arial','',8);
		$this->Cell(100,3,' ',0,0,'L');
		$this->Cell(35,3,'',0,0,'L');
		$this->SetFont('Arial','B',6);
		
		$this->Cell(15);
		$this->Cell(200,5,' ',0,1,'L');		
		$this->SetFont('Arial','B',7);		
		$this->Cell(170,5,'NOMBRE O RAZÓN SOCIAL DEL AGENTE DE RETENCIÓN',1,0,'C');
		$this->Cell(30,5,'RIF',1,1,'C');		
		$this->SetFont('Arial','',8);		
		$this->Cell(170,5,$nombre_emp,'1',0,'C');
		$this->Cell(30,5,$ced_rif_emp,'1',1,'C');	
		$this->Cell(200,5,'DIRECCION: CALLE ROSARITO NRO S/N URB LOMAS DEL ESTE','LRT',1,'L');
		$this->Cell(200,10,' ','LR',1,'C');
		$this->Cell(200,1,' ','BLR',1,'C');
		$this->SetFont('Arial','B',8);	
		$this->Cell(70,5,'TELEFONO','LRT',0,'C');
		$this->Cell(70,5,'CIUDAD','LRT',0,'C');
		$this->Cell(60,5,'ESTADO','LRT',1,'C');
		$this->SetFont('Arial','',8);
		$this->Cell(70,5,'0251-7172930 ','LRT',0,'C');
		$this->Cell(70,5,'BARQUISIMETO ','LRT',0,'C');
		$this->Cell(60,5,'LARA','LRT',1,'C');
		
		$this->SetFont('Arial','B',7);		
		$this->Cell(125,5,'NOMBRE DEL CONTRIBUYENTE',1,0,'C');
		$this->Cell(75,5,'RIF',1,1,'C');		
		$this->SetFont('Arial','',8);		
		$this->Cell(125,5,$nombre_benef,'LR',0,'C');
		$this->Cell(75,5,$ced_rif,'LR',1,'C');		
		$this->SetFont('Arial','',7);		
		$this->Cell(200,1,'','LRB',1,'C');
		$this->Cell(200,5,'DIRECCION: ','LRT',1,'L');
		$this->Cell(200,10,$direccion,'LR',1,'L');
		$this->Cell(200,1,' ','BLR',1,'C');
		$this->SetFont('Arial','B',8);	
		$this->Cell(70,5,'TELEFONO','LRT',0,'C');
		$this->Cell(70,5,'CIUDAD','LRT',0,'C');
		$this->Cell(60,5,'ESTADO','LRT',1,'C');
		$this->SetFont('Arial','',8);	
		$this->Cell(70,5,$telefono,'LRT',0,'C');
		$this->Cell(70,5,$ciudad,'LRT',0,'C');
		$this->Cell(60,5,$estado,'LRT',1,'C');
		$this->SetFont('Arial','B',8);
		$this->Cell(40,5,'FECHA ORDEN DE PAGO','LRT',0,'C');
		$this->Cell(130,5,'DOCUMENTO','LRT',0,'C');
		$this->Cell(30,5,'No ORDEN DE PAGO','LRT',1,'C');
		
		
		$this->SetFont('Arial','',8);	
		$this->Cell(40,5,$fechae,'LRT',0,'C');
		$this->Cell(130,5,$tipo_documento.' '.$nro_con_factura,'LRT',0,'C');
		$this->Cell(30,5,$referencia,'LRT',1,'C');
		
		$this->SetFont('Arial','B',8);
		$this->Cell(100,5,'TIPO DE ENRIQUECIMIENTO','LRT',0,'C');
		$this->Cell(100,5,'MONTO PAGADO O ABONADO EN CUENTA','LRT',1,'C');
		$this->SetFont('Arial','',8);	
		$this->Cell(100,5,$tipo_en,'LRT',0,'C');
		$this->Cell(100,5,$monto_pago,'LRT',1,'C');
		$this->SetFont('Arial','B',8);
		$this->Cell(70,5,'MONTO OBJETO DE RETENCION','LRT',0,'C');
		$this->Cell(70,5,'PORCENTAJE DE RETENCION','LRT',0,'C');
		$this->Cell(60,5,'MONTO RETENIDO','LRT',1,'C');
		$this->SetFont('Arial','',8);	
		$this->Cell(70,5,$monto_o,'LRT',0,'C');
		$this->Cell(70,5,$tasa,'LRT',0,'C');
		$this->Cell(60,5,$monto_r,'LRT',1,'C');
		$this->SetFont('Arial','B',8);
		$this->Cell(200,5,'DESCRIPCION DE LA RETENCION','1',1,'C');
		$this->SetFont('Arial','',8);	
		$this->Cell(200,8,$descripcion_ret,1,1,'C');
		
		$this->Ln(20);
		
			
		$this->Cell(200,3,'_____________________________',0,1,'C');
			
		$this->Cell(200,4,'LCDA MAYELA VIRGUEZ',0,1,'C');
		$this->Cell(200,4,'GERENTE DE ADM Y FINANZAS',0,1,'C');
		
		
		
	}	
	
}
  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $pdf->SetAutoPageBreak(true, 45); 
  $pdf->Output();  
  pg_close();


?>