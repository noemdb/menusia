<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS;error_reporting(E_ALL ^ E_NOTICE);
$orden=$_GET["orden"];  $tipo_planilla=$_GET["tipo"]; $ano_fiscal="";  $fecha_hoy=asigna_fecha_hoy();
$nombre_planilla="COMPROBANTE DE RETENCION DEL IMPUESTO SOBRE LA RENTA";
if($tipo_planilla=="03"){$nombre_planilla="PLANILLA DE RETENCION FIEL CUMPLIMIENTO"; }
if($tipo_planilla=="02"){$nombre_planilla="PLANILLA PARA EL CALCULO DEL IMPUESTO 1 X 1000"; }
if($tipo_planilla=="04"){$nombre_planilla="COMPROBANTE DE RETENCION DE RESPONSABILIDAD SOCIAL"; }
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$direccion=""; $nombre_emp=""; $ced_rif_emp="";
$sql="Select * from SIA000 order by campo001"; $resultado=pg_query($sql);if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"];$direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $ced_rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
$nro_comp=""; $sustraendo=0; $descripcion_ret=""; $fechae=""; $tipo_en=""; $tipo_documento=""; $nro_documento=""; $nro_con_factura=""; $fecha=""; $descripcion=""; $tipo_operacion="A";
$ced_rif="";  $nombre_benef=""; $total_r=0; $monto_o=0; $tasa=0; $error=0;
$sqlp="select * from planillas_ret where tipo_planilla='$tipo_planilla' and nro_orden='$orden' and anulada='N' order by nro_planilla"; $resp=pg_query($sqlp);
if ($registrop=pg_fetch_array($resp)){  
  $orden=$registrop["nro_orden"];  $aux_orden=$registrop["aux_orden"]; $tipo_ret=$registrop["tipo_retencion"];  $planilla=$registrop["tipo_planilla"]; $nro_planilla=$registrop["nro_planilla"]; $descripcion=$registrop["descripcion"];
  $total_r=$registrop["monto_retencion"]; $monto_o=formato_monto($registrop["monto_objeto"]); $tasa=$registrop["tasa"];
  $descripcion_ret=$registrop["descripcion_ret"]; $tipo_en=$registrop["tipo_en"];   $tipo_documento=$registrop["tipo_documento"];
  $nro_documento=$registrop["nro_documento"];  $nro_con_factura=$registrop["nro_con_factura"]; $sfecha=$registrop["fecha_factura"];
  $efecha=$registrop["fecha_emision"]; $fechae=substr($efecha,8,2)."/".substr($efecha,5,2)."/".substr($efecha,0,4);  $ano_fiscal=substr($efecha,0,4);
  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
  $nro_comp=$nro_planilla; $ced_rif=$registrop["ced_rif"];  $nombre_benef=$registrop["nombre"];
  $sustraendo=$registrop["sustraendo"];
} 
function elimina_ceros($str){$texto=$str; $l=0; $mcontinue=0;while ($mcontinue==0){ if (substr($texto,0, 1)=="0") {$l=strlen($texto); $texto=substr($texto,1,$l-1); } else{$mcontinue=1;} }return $texto;}

require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $nro_comp; global $fecha; global $nombre_emp; global $ced_rif_emp; global $ano_fiscal; global $mes_fiscal; global $direccion; global $nombre_planilla;
	   global $nombre_benef; global $ced_rif; global $unidad_sol; global $php_os;	global $fechae;
		$this->Image('../../imagenes/Logo_emp.png',12,8,18);
		$this->Cell(18);
		$this->SetFont('Arial','B',8);
		$this->Cell(5);
		$this->Cell(100,4,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,0,'L');
		$this->ln(4);
		$this->Cell(23);
		$this->Cell(200,4,utf8_decode($nombre_emp),0,0,'L');
		$this->Cell(32,3,'',0,1,'L');
		$this->Cell(200,3,'',0,0,'L');
		$this->SetFont('Arial','B',6);		
		$this->Cell(50,3,'0.- NRO. DE COMPROBANTE','LTR',1,'L');	
		$this->Cell(15);
		$this->SetFont('Arial','B',8);
		$this->Cell(150,3,'',0,0,'L');
		$this->Cell(35,3,'',0,0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(50,3,substr($fechae,6,4)." - ".substr($fechae,3,2)." - ".$nro_comp,'LR',1,'C');			
		$this->Cell(15);
		$this->SetFont('Arial','B',2);
		$this->Cell(150,1,'  ',0,0,'L');
		$this->Cell(35,1,'',0,0,'L');
		$this->Cell(50,1,' ','LRB',1,'C');			
		$this->Cell(200,3,' ',0,1,'L');	
		$this->Cell(15);
		$this->SetFont('Arial','',8);
		$this->Cell(150,3,' ',0,0,'L');
		$this->Cell(35,3,'',0,0,'L');
		$this->SetFont('Arial','B',6);
		$this->Cell(30,3,'1.- FECHA','LTR',0,'L');
		$this->Cell(2,3,'',0,0,'L');
		$this->Cell(18,3,'2.- PERIODO','LTR',1,'L');
        $this->SetFont('Arial','B',10);
		$this->Cell(200,3,$nombre_planilla,0,0,'C');
		$this->SetFont('Arial','',8);
		$this->Cell(30,3,$fechae,'LR',0,'C');
		$this->Cell(2,3,'',0,0,'L');
		$this->Cell(18,3,substr($fecha,6,4),'LR',1,'C');		
		$this->Cell(15);
		$this->SetFont('Arial','B',2);
		$this->Cell(150,1,'  ',0,0,'L');
		$this->Cell(35,1,'',0,0,'L');
		$this->Cell(30,1,' ','LRB',0,'C');
		$this->Cell(2,1,' ',0,0,'C');
		$this->Cell(18,1,' ','LRB',1,'C');		
		$this->Cell(200,3,' ',0,1,'L');
		$this->SetFont('Arial','B',6);		
		$this->Cell(173,4,'3.- NOMBRE O RAZÓN SOCIAL DEL AGENTE DE RETENCIÓN','LTR',0,'L');
		$this->Cell(2,4,'',0,0,'L');
		$this->Cell(75,4,'4.- REGISTRO DE INFORMACIÓN FISCAL DEL AGENTE DE RETENCIÓN','LTR',1,'L');		
		$this->SetFont('Arial','',8);		
		$this->Cell(173,3,utf8_decode($nombre_emp),'LR',0,'C');
		$this->Cell(2,3,'',0,0,'L');
		$this->Cell(75,3,$ced_rif_emp,'LR',1,'C');		
		$this->SetFont('Arial','',1);		
		$this->Cell(173,1,'','LRB',0,'C');
		$this->Cell(2,1,'',0,0,'L');
		$this->Cell(75,1,'','LRB',1,'C');
		$this->Cell(250,3,' ',0,1,'L');		
		$this->SetFont('Arial','B',6);		
		$this->Cell(250,4,'5.- DIRECCIÓN FISCAL DEL AGENTE DE RETENCIÓN','LTR',1,'L');		
		$this->SetFont('Arial','',8);		
		$this->Cell(250,3,utf8_decode($direccion),'LR',1,'C');		
		$this->SetFont('Arial','',1);		
		$this->Cell(250,1,'','LRB',1,'C');
		$this->Cell(250,3,' ',0,1,'L');		
		$this->SetFont('Arial','B',6);		
		$this->Cell(173,4,'6.- NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO','LTR',0,'L');
		$this->Cell(2,4,'',0,0,'L');
		$this->Cell(75,4,'7.- REGISTRO DE INFORMACIÓN FISCAL DEL SUJETO RETENIDO','LTR',1,'L');		
		$this->SetFont('Arial','',8);		
		$this->Cell(173,3,$nombre_benef,'LR',0,'C');
		$this->Cell(2,3,'',0,0,'L');
		$this->Cell(75,3,$ced_rif,'LR',1,'C');		
		$this->SetFont('Arial','',1);		
		$this->Cell(173,1,'','LRB',0,'C');
		$this->Cell(2,1,'',0,0,'L');
		$this->Cell(75,1,'','LRB',1,'C');
		$this->Cell(250,5,' ',0,1,'L');
		
		//ENCABEZADO DE CELDAS
		$this->SetFont('Arial','B',6);
        $this->SetFillColor(192,192,192);
		$this->Cell(18,2,'','LTR',0,'C',true);
		$this->Cell(20,2,'','LTR',0,'C',true);		
		$this->Cell(25,2,'','LTR',0,'C',true);
		$this->Cell(25,2,'','LTR',0,'C',true);
		$this->Cell(25,2,'','LTR',0,'C',true);
		$this->Cell(25,2,'','LTR',0,'C',true);
		$this->Cell(25,2,'','LTR',0,'C',true);
		$this->Cell(25,2,'','LTR',0,'C',true);
		$this->Cell(25,2,'','LTR',0,'C',true);
		$this->Cell(12,2,'','LTR',0,'C',true);
		$this->Cell(25,2,'','LTR',1,'C',true);		
		
				
		$this->Cell(18,3,'ORDEN DE','LR',0,'C',true);
		$this->Cell(20,3,'FECHA DE','LR',0,'C',true);
		$this->Cell(25,3,'NÚMERO DE','LR',0,'C',true);
		$this->Cell(25,3,'NÚMERO DE','LR',0,'C',true);
		$this->Cell(25,3,'MONTO DE LA','LR',0,'C',true);
		$this->Cell(25,3,'NUM NOTA','LR',0,'C',true);
		$this->Cell(25,3,'NUM NOTA','LR',0,'C',true);
		$this->Cell(25,3,'FACTURA','LR',0,'C',true);
		$this->Cell(25,3,'BASE','LR',0,'C',true);
		$this->Cell(12,3,'%','LR',0,'C',true);
		$this->Cell(25,3,'IMPUESTO','LR',1,'C',true);	
		
		$this->Cell(18,3,'PAGO','LRB',0,'C',true);
		$this->Cell(20,3,'LA FACTURA','LRB',0,'C',true);
		$this->Cell(25,3,'LA FACTURA','LRB',0,'C',true);
		$this->Cell(25,3,'CONTROL','LRB',0,'C',true);
		$this->Cell(25,3,'OPERACIÓN','LRB',0,'C',true);
		$this->Cell(25,3,'CREDITO','LRB',0,'C',true);
		$this->Cell(25,3,'DEBITO','LRB',0,'C',true);
		$this->Cell(25,3,'AFECTADA','LRB',0,'C',true);
		$this->Cell(25,3,'IMPONIBLE','LRB',0,'C',true);
		$this->Cell(12,3,'ALICUOTA','LRB',0,'C',true);
		$this->Cell(25,3,'RETENIDO','LRB',1,'C',true);	
		
		$this->Line(10,77,10,171);
		$this->Line(28,77,28,170.8);
		$this->Line(48,77,48,170.8);
		
		
		$this->Line(73,77,73,170.8);
		$this->Line(98,77,98,170.8);
		$this->Line(123,77,123,170.8);
		$this->Line(148,77,148,170.8);
		$this->Line(173,77,173,170.8);
		$this->Line(198,77,198,170.8);
		$this->Line(223,77,223,170.8);
		$this->Line(235,77,235,170.8);
		$this->Line(260,77,260,170.8);
		
}
    function Footer(){ global $total_d; global $total_e; global $total_b; global $total_ret; global $total_iva; global $total_r; global $fin;
	    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  
	    $mtotal_d=formato_monto($total_d); $mtotal_e=formato_monto($total_e); $mtotal_b=formato_monto($total_b);
        $mtotal_ret=formato_monto($total_ret); $mtotal_iva=formato_monto($total_iva);
		if($fin==1){ $mtotal_ret=formato_monto($total_r); }
		$this->SetY(-45); $y=$this->GetY(); $l=$y-0.2; $p=$y+5.1;
		$this->SetFillColor(192,192,192);
		$this->SetFont('Arial','B',7);
		//$this->Line(250,$l,270,$l);
		$this->Cell(88,5,'',1,0,'R');
		$this->Cell(25,5,$mtotal_d,1,0,'R');
		$this->Cell(25,5,'',1,0,'R');
		$this->Cell(25,5,'',1,0,'R');
		$this->Cell(25,5,'',1,0,'R');
		$this->Cell(25,5,$mtotal_b,1,0,'R');
		$this->Cell(12,5,'',1,0,'R');
		$this->Cell(25,5,$mtotal_ret,1,1,'R');
		$this->Cell(250,15,' ',0,1,'C');		
		$this->Cell(130,2,'_____________________________',0,0,'C');
		$this->Cell(130,2,'_____________________________',0,1,'C');		
		$this->Cell(130,3,'FIRMA Y SELLO DEL AGENTE',0,0,'C');
		$this->Cell(130,3,'FRIMA Y SELLO DEL',0,1,'C');
		$this->Cell(130,3,'DE RETENCION',0,0,'C');
		$this->Cell(130,3,'CONTRIBUYENTE',0,1,'C');
		$this->SetFillColor(255,0,0);
		$this->Ln(5);
	}
	
}
  
  $pdf=new PDF('L', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $pdf->SetAutoPageBreak(true, 45);
  $p=0;
  
  
  $sqlp="select * from planillas_ret where tipo_planilla='$tipo_planilla' and nro_orden='$orden' and anulada='N' order by nro_planilla"; $resp=pg_query($sqlp);
  while(($registrop=pg_fetch_array($resp))and($error==0)) { 
	  $orden=$registrop["nro_orden"];  $aux_orden=$registrop["aux_orden"]; $tipo_ret=$registrop["tipo_retencion"];  $planilla=$registrop["tipo_planilla"]; $nro_planilla=$registrop["nro_planilla"]; $descripcion=$registrop["descripcion"];
	  $total_r=$registrop["monto_retencion"]; $monto_o=formato_monto($registrop["monto_objeto"]); $tasa=$registrop["tasa"];
	  $descripcion_ret=$registrop["descripcion_ret"]; $tipo_en=$registrop["tipo_en"];   $tipo_documento=$registrop["tipo_documento"];
	  $nro_documento=$registrop["nro_documento"];  $nro_con_factura=$registrop["nro_con_factura"]; $sfecha=$registrop["fecha_factura"];
	  $efecha=$registrop["fecha_emision"]; $fechae = substr($efecha,8,2)."/".substr($efecha,5,2)."/".substr($efecha,0,4);  $ano_fiscal=substr($efecha,0,4);
	  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
	  $nro_comp=$nro_planilla; $ced_rif=$registrop["ced_rif"];  $nombre_benef=$registrop["nombre"];
	  $sustraendo=$registrop["sustraendo"];
	  
	   if($p>0){ $pdf->AddPage();}
	   $p=$p+1;
  
	$total_d=0;  $total_s=0;  $total_b=0;  $total_iva=0;  $total_ret=0; $aplica_sust=0;
	$monto_r="";$monto_o=""; $monto1=0; $monto2=0;  $nro_op=0; $fin=0;
	if($tipo_planilla=="01"){$sql="SELECT * FROM PAG016  where nro_orden='$orden' and monto_iva1_so>0 order by nro_factura";}
	else{$sql="SELECT * FROM PAG016  where nro_orden='$orden'  and status_2='N' order by nro_factura";}
	$res=pg_query($sql);
	while(($registro=pg_fetch_array($res))and($error==0)) {
    	$sfecha=$registro["fecha_factura"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); $nro_op=$nro_op+1;
		$nro_fact=$registro["nro_factura"]; $nro_control=$registro["nro_con_factura"]; $nro_fact=elimina_ceros($nro_fact);  $nro_control=elimina_ceros($nro_control);
		$monto=$registro["monto_factura"];  $monto_m=formato_monto($monto);
		$montos=$registro["monto_sin_iva"];  		
		$tasa_iva=$registro["tasa_iva1"]; $montoo=$registro["monto_iva1_so"];  $montob=$registro["monto_iva4_so"]; 
		if($tipo_planilla=="01"){$montob=$montob;} else {$montob=$montoo; $montob=$montos;}
		if(($tipo_planilla=="04")and($ced_rif=="J-30018017-4")){$montob=$registro["monto_iva4_so"]; }
		$montor=($montob*$tasa)/100;  		
		$monto_b=formato_monto($montob); $montoo=formato_monto($montoo); $tasa_iva=formato_monto($tasa_iva);
		if(($aplica_sust==0)and($total_r<$montor)){$montor=$montor-$sustraendo; $aplica_sust=1;} 
		$monto_r=formato_monto($montor);	$nro_cred=""; $nro_afecta="";
		if($monto<0){ $nro_cred=$nro_fact; $nro_afecta=$registro["campo_str2"]; $nro_fact=""; }        
		$pdf->Cell(18,3,$orden,0,0,'C');
	    $pdf->Cell(20,3,$fecha,0,0,'C');	
	    $pdf->Cell(25,3,$nro_fact,0,0,'C');
	    $pdf->Cell(25,3,'00'.$nro_control,0,0,'C');
	    $pdf->Cell(25,3,$monto_m,0,0,'R');
		$pdf->Cell(25,3,'',0,0,'C');
		$pdf->Cell(25,3,'',0,0,'C');
		$pdf->Cell(25,3,'',0,0,'C');
	    $pdf->Cell(25,3,$monto_b,0,0,'R');
	    $pdf->Cell(12,3,$tasa,0,0,'C');
	    $pdf->Cell(25,3,$monto_r,0,1,'R'); 
	    $total_d=$total_d+$monto; $total_s=$total_s+$montos; $total_b=$total_b+$montob; $total_ret=$montor+$total_ret;
	} $fin=1;	
	
   }	
	
	
 $pdf->Output();
 pg_close();
?>
