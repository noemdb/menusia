<?include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; error_reporting(E_ALL ^ E_NOTICE);
$orden=$_GET["orden"];  $tipo_planilla=$_GET["tipo"]; $ano_fiscal=""; $fecha_hoy=asigna_fecha_hoy(); $nombre_planilla="COMPROBANTE DE RETENCION DE 1*1000"; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }$direccion=""; $nombre_emp=""; $ced_rif_emp="";
$sql="Select * from SIA000 order by campo001"; $resultado=pg_query($sql);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"];
$direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $ced_rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
$nro_comp=""; $sustraendo=0; $descripcion_ret=""; $fechae=""; $tipo_en=""; $tipo_documento=""; $nro_documento=""; $nro_con_factura=""; $fecha=""; $descripcion=""; $tipo_operacion="A";
$ced_rif="";  $nombre_benef=""; $total_r=0; $monto_o=0; $tasa=0; $error=0;
$sql="select * from planillas_ret where tipo_planilla='$tipo_planilla' and nro_orden='$orden' and anulada='N'"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res)){  $orden=$registro["nro_orden"];  $aux_orden=$registro["aux_orden"]; $tipo_ret=$registro["tipo_retencion"];  $planilla=$registro["tipo_planilla"]; $nro_planilla=$registro["nro_planilla"]; $descripcion=$registro["descripcion"];
  $total_r=formato_monto($registro["monto_retencion"]); $monto_o=formato_monto($registro["monto_objeto"]); $tasa=$registro["tasa"];
  $descripcion_ret=$registro["descripcion_ret"]; $tipo_en=$registro["tipo_en"];   $tipo_documento=$registro["tipo_documento"];
  $nro_documento=$registro["nro_documento"];  $nro_con_factura=$registro["nro_con_factura"]; $sfecha=$registro["fecha_factura"];
  $efecha=$registro["fecha_emision"]; $fechae = substr($efecha,8,2)."/".substr($efecha,5,2)."/".substr($efecha,0,4);  $ano_fiscal=substr($criterio,0,4);
  $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4);
  $nro_comp=$nro_planilla; $ced_rif=$registro["ced_rif"];  $nombre_benef=$registro["nombre"];
  $sustraendo=$registro["sustraendo"];
} 
function elimina_ceros($str){$texto=$str; $l=0; $mcontinue=0;while ($mcontinue==0){ if (substr($texto,0, 1)=="0") {$l=strlen($texto); $texto=substr($texto,1,$l-1); } else{$mcontinue=1;} } return $texto;}
function Rellenarcerosizq($str,$n){$numeroarellenar=$n-strlen($str); $texto=""; for ($i=0; $i < $numeroarellenar; $i++){$texto=$texto."0";} $texto=$texto.$str; return $texto;}
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $nro_comp; global $fecha; global $nombre_emp; global $ced_rif_emp; global $ano_fiscal; global $mes_fiscal; global $direccion; global $nombre_planilla;
	   global $nombre_benef; global $ced_rif; global $unidad_sol; global $php_os;	global $fechae;	        		
		$this->Image('../../imagenes/logo escudo.png',12,8,25);
		$this->Cell(18);
		$this->SetFont('Arial','B',9);		
		$this->Cell(150,3,'',0,0,'L');
		$this->Cell(32,3,'',0,1,'L');	
		$this->Cell(150,3,'',0,0,'L');
		$this->SetFont('Arial','B',6);		
		$this->Cell(50,3,'0.- NRO. DE COMPROBANTE','LTR',1,'L');		
		$this->Cell(15);
		$this->SetFont('Arial','B',8);
		$this->Cell(100,3,'',0,0,'L');
		$this->Cell(35,3,'',0,0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(50,3,$nro_comp,'LR',1,'C');			
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
        $this->SetFont('Arial','B',10);
		$this->Cell(150,3,$nombre_planilla,0,0,'C');
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
		$this->Cell(200,3,' ',0,1,'L');
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
		$this->Cell(28,3,'','LTR',0,'C',true);
		$this->Cell(28,3,'','LTR',0,'C',true);
		$this->Cell(28,3,'','LTR',0,'C',true);
		$this->Cell(28,3,'','LTR',0,'C',true);
		$this->Cell(28,3,'','LTR',0,'C',true);
		$this->Cell(12,3,'','LTR',0,'C',true);
		$this->Cell(28,3,'','LTR',1,'C',true);		
		$this->Cell(20,3,'ORDEN DE','LR',0,'C',true);
		$this->Cell(28,3,'FECHA DE','LR',0,'C',true);
		$this->Cell(28,3,'N�MERO DE','LR',0,'C',true);
		$this->Cell(28,3,'N�MERO DE','LR',0,'C',true);
		$this->Cell(28,3,'MONTO DE LA','LR',0,'C',true);
		$this->Cell(28,3,'BASE','LR',0,'C',true);
		$this->Cell(12,3,'%','LR',0,'C',true);
		$this->Cell(28,3,'IMPUESTO','LR',1,'C',true);		
		$this->Cell(20,3,'PAGO','LRB',0,'C',true);
		$this->Cell(28,3,'LA FACTURA','LRB',0,'C',true);
		$this->Cell(28,3,'LA FACTURA','LRB',0,'C',true);
		$this->Cell(28,3,'CONTROL','LRB',0,'C',true);
		$this->Cell(28,3,'OPERACI�N','LRB',0,'C',true);
		$this->Cell(28,3,'IMPONIBLE','LRB',0,'C',true);
		$this->Cell(12,3,'ALICUOTA','LRB',0,'C',true);
		$this->Cell(28,3,'RETENIDO','LRB',1,'C',true);	
		$this->Line(10,77,10,234.2);
		$this->Line(30,77,30,234.2);
		$this->Line(58,77,58,234.2);
		$this->Line(86,77,86,234.2);
		$this->Line(114,77,114,234.2);
		$this->Line(142,77,142,234.2);
		$this->Line(170,77,170,234.2);
		$this->Line(182,77,182,234.2);
		$this->Line(210,77,210,234.2);		
	}
    function Footer(){ global $total_d; global $total_e; global $total_b; global $total_ret; global $total_iva; global $total_r;
	    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  
	    $total_d=formato_monto($total_d); $total_e=formato_monto($total_e); $total_b=formato_monto($total_b);
        $total_ret=formato_monto($total_ret); $total_iva=formato_monto($total_iva);
		$this->SetY(-45); $y=$this->GetY(); $l=$y-0.2; $p=$y+5.1;
		$this->SetFillColor(192,192,192);
		$this->SetFont('Arial','B',7);
		$this->Cell(104,5,'',1,0,'R');
		$this->Cell(28,5,$total_d,1,0,'R');
		$this->Cell(28,5,$total_b,1,0,'R');
		$this->Cell(12,5,'',1,0,'R');
		$this->Cell(28,5,$total_r,1,1,'R');
		$this->Cell(200,15,' ',0,1,'C');		
		$this->Cell(100,2,'_____________________________',0,0,'C');
		$this->Cell(100,2,'_____________________________',0,1,'C');		
		$this->Cell(100,3,'FIRMA Y SELLO DEL AGENTE',0,0,'C');
		$this->Cell(100,3,'FIRMA Y SELLO DEL',0,1,'C');
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
	$total_d=0;  $total_s=0;  $total_b=0;  $total_iva=0;  $total_ret=0; $aplica_sust=1;
	$monto_r="";$monto_o=""; $monto1=0; $monto2=0;  $nro_op=0;
	$sql="SELECT * FROM PAG016  where nro_orden='$orden'  and status_2='N' order by nro_factura";
	$res=pg_query($sql);
	while(($registro=pg_fetch_array($res))and($error==0)) {
    	$sfecha=$registro["fecha_factura"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); $nro_op=$nro_op+1;
		$nro_fact=$registro["nro_factura"]; $nro_control=$registro["nro_con_factura"]; 
		if(is_numeric($nro_fact)){$nro_fact=elimina_ceros($nro_fact);   $nro_fact=Rellenarcerosizq($nro_fact,8);	}  
		if(is_numeric($nro_control)){$nro_control=elimina_ceros($nro_control); $nro_control=Rellenarcerosizq($nro_con_fac,8);}
		$monto=$registro["monto_factura"]; $total_d=$total_d+$monto; 
		$montos=$registro["monto_sin_iva"]; $total_s=$total_s+$montos;
		$tasa_iva=$registro["tasa_iva1"];  
		
		$montoo=$registro["monto_iva1_so"];  $montob=$registro["monto_iva4_so"]; //$montob=$montos;
		$montor=($montob*$tasa)/100; $total_b=$total_b+$montob; 
		if($aplica_sust==0){$montor=$montor-$sustraendo; $aplica_sust=1;} 
		$total_ret=$montor+$total_ret; 
		$nro_cred=""; $nro_afecta="";
		if($monto<0){ $nro_cred=$nro_fact; $nro_afecta=$registro["campo_str2"]; $nro_fact=""; }   

        $montos=formato_monto($montos);	$monto_m=formato_monto($monto);	$tasa_iva=formato_monto($tasa_iva);
		$monto_b=formato_monto($montob); $montoo=formato_monto($montoo); $monto_r=formato_monto($montor);
		$pdf->Cell(20,4,$orden,0,0,'C');
	    $pdf->Cell(28,4,$fecha,0,0,'C');	
	    $pdf->Cell(28,4,$nro_fact,0,0,'C');
	    $pdf->Cell(28,4,$nro_control,0,0,'C');
	    $pdf->Cell(28,4,$monto_m,0,0,'R');
	    $pdf->Cell(28,4,$monto_b,0,0,'R');
	    $pdf->Cell(12,4,$tasa,0,0,'C');
	    $pdf->Cell(28,4,$monto_r,0,1,'R'); 
	
	}   
 $pdf->Output();
 pg_close();


?>
