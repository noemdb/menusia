<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; error_reporting(E_ALL ^ E_NOTICE);
$orden=$_GET["orden"];  $tipo_planilla=$_GET["tipo"]; $ano_fiscal=""; $fecha_hoy=asigna_fecha_hoy();

$tipo_planilla="03"; $tipo_planilla_lab="05";
$nombre_planilla="COMPROBANTE DE RETENCION FIEL CUMPLIMIENTO/LABORAL";

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  $error=0;
$direccion=""; $nombre_emp=""; $ced_rif_emp="";$sql="Select * from SIA000 order by campo001"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"]; $direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $ced_rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
$nro_comp=""; $sustraendo=0; $descripcion_ret=""; $fechae=""; $tipo_en=""; $tipo_documento=""; $nro_documento=""; $nro_con_factura=""; $fecha=""; $descripcion=""; $tipo_operacion="A";
$ced_rif="";  $nombre_benef=""; $total_r=0; $monto_o=0; $tasa=0; $error=0;
$sql="select * from planillas_ret where tipo_planilla='$tipo_planilla' and nro_orden='$orden' and anulada='N'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res)){  
  $orden=$registro["nro_orden"];  $aux_orden=$registro["aux_orden"]; $tipo_ret=$registro["tipo_retencion"];  $planilla=$registro["tipo_planilla"]; $nro_planilla=$registro["nro_planilla"]; $descripcion=$registro["descripcion"];
  $total_r=formato_monto($registro["monto_retencion"]); $monto_o=formato_monto($registro["monto_objeto"]); $tasa=$registro["tasa"];
  $descripcion_ret=$registro["descripcion_ret"]; $tipo_en=$registro["tipo_en"];   $tipo_documento=$registro["tipo_documento"];
  $nro_documento=$registro["nro_documento"];  $nro_con_factura=$registro["nro_con_factura"]; $sfecha=$registro["fecha_factura"];
  $efecha=$registro["fecha_emision"]; $fechae = substr($efecha,8,2)."/".substr($efecha,5,2)."/".substr($efecha,0,4);  $ano_fiscal=substr($criterio,0,4);
  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
  $nro_comp=$nro_planilla; $ced_rif=$registro["ced_rif"];  $nombre_benef=$registro["nombre"];
  $sustraendo=$registro["sustraendo"];
} 
$tasa_lab=0; $total_r_lab=0; $monto_o_lab=0;

$sql="select * from planillas_ret where tipo_planilla='$tipo_planilla_lab' and nro_orden='$orden' and anulada='N'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res)){  
  $total_r_lab=formato_monto($registro["monto_retencion"]); $monto_o_lab=formato_monto($registro["monto_objeto"]); $tasa_lab=$registro["tasa"];
}

function elimina_ceros($str){$texto=$str; $l=0; $mcontinue=0;
while ($mcontinue==0){ if (substr($texto,0, 1)=="0") {$l=strlen($texto); $texto=substr($texto,1,$l-1); } else{$mcontinue=1;} }
return $texto;}


require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $nro_comp; global $fecha; global $nombre_emp; global $ced_rif_emp; global $ano_fiscal; global $mes_fiscal; global $direccion; global $nombre_planilla;
	   global $nombre_benef; global $ced_rif; global $unidad_sol; global $php_os;	global $fechae;	
        		
		$this->Image('../../imagenes/logo escudo.png',12,8,55);			
		$this->Cell(15);
		$this->SetFont('Arial','B',8);
		$this->Cell(100,3,'',0,0,'L');
		$this->Cell(35,3,'',0,0,'L');		
		$this->SetFont('Arial','B',6);		
		$this->Cell(50,3,'0.- NRO. DE COMPROBANTE','LTR',1,'L');		
		$this->Cell(40);
		$this->SetFont('Arial','B',8);
		//$this->Cell(100,4,$nombre_emp,0,0,'L');
		$this->Cell(100,4,'',0,0,'L');
		$this->Cell(10,4,'',0,0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(50,4,$nro_comp,'LR',1,'C');			
		$this->Cell(15);
		$this->SetFont('Arial','B',2);
		$this->Cell(100,1,'  ',0,0,'L');
		$this->Cell(35,1,'',0,0,'L');
		$this->Cell(50,1,' ','LRB',1,'C');			
		$this->Cell(200,3,' ',0,1,'L');	
		$this->Cell(15);
		$this->SetFont('Arial','',8);
		$this->Cell(100,3,' ',0,0,'L');
		$this->Cell(35,3,'',0,0,'L');
		$this->SetFont('Arial','B',6);
		$this->Cell(30,3,'1.- FECHA','LTR',0,'L');
		$this->Cell(2,3,'',0,0,'L');
		$this->Cell(18,3,'2.- PERIODO','LTR',1,'L');	
		$this->Cell(15);
		$this->SetFont('Arial','B',8);
		$this->Cell(100,3,' ',0,0,'L');
		$this->Cell(35,3,'',0,0,'L');		
		$this->SetFont('Arial','',8);
		$this->Cell(30,3,$fechae,'LR',0,'C');
		$this->Cell(2,3,'',0,0,'L');
		$this->Cell(18,3,substr($fecha,6,4),'LR',1,'C');		
		$this->Cell(15);
		$this->SetFont('Arial','B',2);
		$this->Cell(100,1,'  ',0,0,'L');
		$this->Cell(35,1,'',0,0,'L');
		$this->Cell(30,1,' ','LRB',0,'C');
		$this->Cell(2,1,' ',0,0,'C');
		$this->Cell(18,1,' ','LRB',1,'C');		
		$this->Cell(200,5,' ',0,1,'L');
		$this->SetFont('Arial','B',12);
		$this->Cell(200,3,$nombre_planilla,0,1,'C');
		$this->Cell(200,5,' ',0,1,'L');		
		$this->SetFont('Arial','B',6);		
		$this->Cell(123,4,'3.- NOMBRE O RAZ�N SOCIAL DEL AGENTE DE RETENCI�N','LTR',0,'L');
		$this->Cell(2,4,'',0,0,'L');
		$this->Cell(75,4,'4.- REGISTRO DE INFORMACI�N FISCAL DEL AGENTE DE RETENCI�N','LTR',1,'L');		
		$this->SetFont('Arial','',8);		
		$this->Cell(123,3,$nombre_emp,'LR',0,'C');
		$this->Cell(2,3,'',0,0,'L');
		$this->Cell(75,3,$ced_rif_emp,'LR',1,'C');		
		$this->SetFont('Arial','',1);		
		$this->Cell(123,1,'','LRB',0,'C');
		$this->Cell(2,1,'',0,0,'L');
		$this->Cell(75,1,'','LRB',1,'C');
		$this->Cell(200,3,' ',0,1,'L');		
		$this->SetFont('Arial','B',6);		
		$this->Cell(200,4,'5.- DIRECCI�N FISCAL DEL AGENTE DE RETENCI�N','LTR',1,'L');		
		$this->SetFont('Arial','',8);		
		$this->Cell(200,3,$direccion,'LR',1,'C');		
		$this->SetFont('Arial','',1);		
		$this->Cell(200,1,'','LRB',1,'C');
		$this->Cell(200,3,' ',0,1,'L');		
		$this->SetFont('Arial','B',6);		
		$this->Cell(123,4,'6.- NOMBRE O RAZ�N SOCIAL DEL SUJETO RETENIDO','LTR',0,'L');
		$this->Cell(2,4,'',0,0,'L');
		$this->Cell(75,4,'7.- REGISTRO DE INFORMACI�N FISCAL DEL SUJETO RETENIDO','LTR',1,'L');		
		$this->SetFont('Arial','',8);		
		$this->Cell(123,3,$nombre_benef,'LR',0,'C');
		$this->Cell(2,3,'',0,0,'L');
		$this->Cell(75,3,$ced_rif,'LR',1,'C');		
		$this->SetFont('Arial','',1);		
		$this->Cell(123,1,'','LRB',0,'C');
		$this->Cell(2,1,'',0,0,'L');
		$this->Cell(75,1,'','LRB',1,'C');
		$this->Cell(200,5,' ',0,1,'L');
		
		//ENCABEZADO DE CELDAS
		$this->SetFont('Arial','B',6);
        $this->SetFillColor(192,192,192);
		$this->Cell(20,3,'','LTR',0,'C',true);
		$this->Cell(20,3,'','LTR',0,'C',true);
		$this->Cell(28,3,'','LTR',0,'C',true);
		$this->Cell(28,3,'','LTR',0,'C',true);
		$this->Cell(22,3,'','LTR',0,'C',true);
		$this->Cell(22,3,'','LTR',0,'C',true);
		$this->Cell(30,3,'FIEL CIMPLUMIENTO','BLTR',0,'C',true);
		$this->Cell(30,3,'LABORAL','BLTR',1,'C',true);	


		
		$this->Cell(20,3,'ORDEN DE','LR',0,'C',true);
		$this->Cell(20,3,'FECHA DE','LR',0,'C',true);
		
		
		$this->Cell(28,3,'N�MERO DE','LR',0,'C',true);
		$this->Cell(28,3,'N�MERO DE','LR',0,'C',true);
		$this->Cell(22,3,'MONTO DE LA','LR',0,'C',true);
		$this->Cell(22,3,'BASE','LR',0,'C',true);
		$this->Cell(12,3,'%','LR',0,'C',true);
		$this->Cell(18,3,'IMPUESTO','LR',0,'C',true);
		$this->Cell(12,3,'%','LR',0,'C',true);
		$this->Cell(18,3,'IMPUESTO','LR',1,'C',true);	


		
		$this->Cell(20,3,'PAGO','LRB',0,'C',true);
		$this->Cell(20,3,'LA FACTURA','LRB',0,'C',true);
		$this->Cell(28,3,'FACTURA','LRB',0,'C',true);
		$this->Cell(28,3,'CONTROL','LRB',0,'C',true);
		$this->Cell(22,3,'OPERACI�N','LRB',0,'C',true);
		$this->Cell(22,3,'IMPONIBLE','LRB',0,'C',true);
		$this->Cell(12,3,'ALICUOTA','LRB',0,'C',true);
		$this->Cell(18,3,'RETENIDO','LRB',0,'C',true);	
		$this->Cell(12,3,'ALICUOTA','LRB',0,'C',true);
		$this->Cell(18,3,'RETENIDO','LRB',1,'C',true);	
		
		
		$this->Line(10,80,10,234.2);
		$this->Line(30,80,30,234.2);
		$this->Line(50,80,50,234.2);
		$this->Line(78,80,78,234.2);
		$this->Line(106,80,106,234.2);
		$this->Line(128,80,128,234.2);
		$this->Line(150,80,150,234.2);
		$this->Line(162,80,162,234.2);
		$this->Line(180,80,180,234.2);
		$this->Line(192,80,192,234.2);
		$this->Line(210,80,210,234.2);
		
	}
    function Footer(){ global $total_d; global $total_e; global $total_b; global $total_ret; global $total_iva; global $total_r; global $total_ret_lab;
	    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  
	    $total_d=formato_monto($total_d); $total_e=formato_monto($total_e); $total_b=formato_monto($total_b);
        $total_ret=formato_monto($total_ret); $total_iva=formato_monto($total_iva); $total_ret_lab=formato_monto($total_ret_lab);
		$this->SetY(-45); $y=$this->GetY(); $l=$y-0.2; $p=$y+5.1;
		
		$this->SetFillColor(192,192,192);
		$this->SetFont('Arial','B',7);
		
		//$this->Line(250,$l,270,$l);
		
		
		$this->Cell(96,5,'',1,0,'R');
		$this->Cell(22,5,$total_d,1,0,'R');
		$this->Cell(22,5,$total_b,1,0,'R');
		$this->Cell(12,5,'',1,0,'R');
		$this->Cell(18,5,$total_r,1,0,'R');
		$this->Cell(12,5,'',1,0,'R');
		$this->Cell(18,5,$total_ret_lab,1,1,'R');
		
		$this->Cell(200,15,' ',0,1,'C');		
		$this->Cell(100,2,'_____________________________',0,0,'C');
		$this->Cell(100,2,'_____________________________',0,1,'C');		
		$this->Cell(100,4,'FIRMA Y SELLO AGENTE',0,0,'C');
		$this->Cell(100,4,'FRIMA Y SELLO DEL',0,1,'C');
		$this->Cell(100,3,'DE RETENCI�N',0,0,'C');
		$this->Cell(100,3,'CONTRIBUYENTE',0,1,'C');
		$this->SetFillColor(255,0,0);
		$this->Ln(5);
	}

	
	
	
}
  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $pdf->SetAutoPageBreak(true, 45);  
  
	$total_d=0;  $total_s=0;  $total_b=0;  $total_iva=0;  $total_ret=0; $aplica_sust=1; $total_ret_lab=0;
	$monto_r="";$monto_o=""; $monto1=0; $monto2=0;  $nro_op=0;
	if($tipo_planilla=="01"){$sql="SELECT * FROM PAG016  where nro_orden='$orden' and monto_iva1_so>0 order by nro_factura";}
	else{$sql="SELECT * FROM PAG016  where nro_orden='$orden'  and status_2='N' order by nro_factura";}
	$res=pg_query($sql);
	while(($registro=pg_fetch_array($res))and($error==0)) {
    	$sfecha=$registro["fecha_factura"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); $nro_op=$nro_op+1;
		$nro_fact=$registro["nro_factura"]; $nro_control=$registro["nro_con_factura"]; $nro_fact=elimina_ceros($nro_fact);  $nro_control=elimina_ceros($nro_control);
		$monto=$registro["monto_factura"]; $total_d=$total_d+$monto; $monto_m=formato_monto($monto);
		$montos=$registro["monto_sin_iva"]; $total_s=$total_s+$montos; $montos=formato_monto($montos);
		$tasa_iva=$registro["tasa_iva1"];  $tasa_iva=formato_monto($tasa_iva);
		
		$montoo=$registro["monto_iva1_so"];  $montob=$registro["monto_iva4_so"]; 
		if($tipo_planilla=="01"){$montob=$montob;} else {$montob=$montoo;}
		$montor=($montob*$tasa)/100; $total_b=$total_b+$montob; $monto_b=formato_monto($montob); $montoo=formato_monto($montoo);
		
		$montor_lab=($montob*$tasa_lab)/100;
		
		
		if($aplica_sust==0){$montor=$montor-$sustraendo; $aplica_sust=1;} 
		$total_ret=$montor+$total_ret; $monto_r=formato_monto($montor);
		
		
		$montor_lab=($montob*$tasa_lab)/100;
		
		$total_ret_lab=$montor_lab+$total_ret_lab; $monto_r_lab=formato_monto($montor_lab);
		
		$nro_cred=""; $nro_afecta="";
		if($monto<0){ $nro_cred=$nro_fact; $nro_afecta=$registro["campo_str2"]; $nro_fact=""; }
        
		$pdf->Cell(20,3,$orden,0,0,'C');
	    $pdf->Cell(20,3,$fecha,0,0,'C');	
	    $pdf->Cell(28,3,$nro_fact,0,0,'C');
	    $pdf->Cell(28,3,$nro_control,0,0,'C');
	    $pdf->Cell(22,3,$monto_m,0,0,'R');
	    $pdf->Cell(22,3,$monto_b,0,0,'R');
	    $pdf->Cell(12,3,$tasa,0,0,'C');
	    $pdf->Cell(18,3,$monto_r,0,0,'R');
        $pdf->Cell(12,3,$tasa_lab,0,0,'C');
	    $pdf->Cell(18,3,$monto_r_lab,0,1,'R');		
	
	 }

  
 $pdf->Output();
 pg_close();


?>