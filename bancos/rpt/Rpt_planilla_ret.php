<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS;
$orden="00000000";  
$cod_banco=$_GET["cod_banco"]; $tipo_mov=$_GET["tipo_mov"]; $referencia=$_GET["referencia"]; $tipo_planilla=$_GET["tipo"]; $ano_fiscal="";
$fecha_hoy=asigna_fecha_hoy();
$nombre_planilla="COMPROBANTE DE RETENCION DE IMPUESTO SOBRE LA RENTA";
if($tipo_planilla=="02"){$nombre_planilla="COMPROBANTE DE RETENCION DE 1*1000"; }
if($tipo_planilla=="03"){$nombre_planilla="COMPROBANTE DE RESPONSABILIDAD SOCIAL"; }
if($tipo_planilla=="04"){$nombre_planilla="COMPROBANTE DE RETENCION LABORAL"; }
if($tipo_planilla=="05"){$nombre_planilla="COMPROBANTE DE RETENCION FIEL CUMPLIMIENTO"; }

$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$direccion="AVENIDA CARACAS CON LIBERTADOR EDIFICIO ADMINISTRATIVO PISO 2A"; $nombre_emp="GOBERNACION DEL ESTADO YARACUY"; $ced_rif_emp="G-20000164-0";
$nro_comp=""; $sustraendo=0; $descripcion_ret=""; $fechae=""; $tipo_en=""; $tipo_documento=""; $nro_documento=""; $nro_con_factura=""; $fecha=""; $descripcion=""; $tipo_operacion="A";
$ced_rif="";  $nombre_benef=""; $total_r=0; $monto_o=0; $tasa=0; $error=0;

$sql="SELECT nro_orden FROM PAG001 Where (cod_banco='$cod_banco') and (nro_cheque='$referencia') and (tipo_pago='$tipo_mov')"; $res=pg_query($sql);
if ($registro=pg_fetch_array($res)){   $orden=$registro["nro_orden"]; }

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
$clasificacion="00";
$sSQL="SELECT ced_rif,clasificacion FROM pre099 WHERE ced_rif='$ced_rif'";  $res=pg_query($sSQL);
if ($registro=pg_fetch_array($res)){  $clasificacion=$registro["clasificacion"]; }

function elimina_ceros($str){$texto=$str; $l=0; $mcontinue=0;
while ($mcontinue==0){ if(substr($texto,0, 1)=="0"){$l=strlen($texto); $texto=substr($texto,1,$l-1);}else{$mcontinue=1;}  if(strlen($texto)<=0){$mcontinue=1;}  }
return $texto;}


require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $nro_comp; global $fecha; global $nombre_emp; global $ced_rif_emp; global $ano_fiscal; global $mes_fiscal; global $direccion; global $nombre_planilla;
	   global $nombre_benef; global $ced_rif; global $unidad_sol; global $php_os;	global $fechae;	
        		
		$this->Image('../../imagenes/logo escudo.png',12,8,13);
		$this->Cell(15);
		$this->SetFont('Arial','B',8);		
		$this->Cell(100,3,'REPÚBLICA BOLIVARIANA DE VENEZUELA',0,0,'L');
		$this->Cell(35,3,'',0,0,'L');		
		$this->Cell(50,3,'',0,1,'L');		
		$this->Cell(15);
		$this->SetFont('Arial','B',8);
		$this->Cell(100,3,'GOBERNACIÓN DEL ESTADO YARACUY',0,0,'L');
		$this->Cell(35,3,'',0,0,'L');		
		$this->SetFont('Arial','B',6);		
		$this->Cell(50,3,'0.- NRO. DE COMPROBANTE','LTR',1,'L');		
		$this->Cell(15);
		$this->SetFont('Arial','B',8);
		$this->Cell(100,3,'COORDINACIÓN DE TESORERÍA',0,0,'L');
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
		$this->Cell(123,4,'3.- NOMBRE O RAZÓN SOCIAL DEL AGENTE DE RETENCIÓN','LTR',0,'L');
		$this->Cell(2,4,'',0,0,'L');
		$this->Cell(75,4,'4.- REGISTRO DE INFORMACIÓN FISCAL DEL AGENTE DE RETENCIÓN','LTR',1,'L');		
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
		$this->Cell(200,4,'5.- DIRECCIÓN FISCAL DEL AGENTE DE RETENCIÓN','LTR',1,'L');		
		$this->SetFont('Arial','',8);		
		$this->Cell(200,3,$direccion,'LR',1,'C');		
		$this->SetFont('Arial','',1);		
		$this->Cell(200,1,'','LRB',1,'C');
		$this->Cell(200,3,' ',0,1,'L');		
		$this->SetFont('Arial','B',6);		
		$this->Cell(123,4,'6.- NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO','LTR',0,'L');
		$this->Cell(2,4,'',0,0,'L');
		$this->Cell(75,4,'7.- REGISTRO DE INFORMACIÓN FISCAL DEL SUJETO RETENIDO','LTR',1,'L');		
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
		$this->Cell(21,3,'','LTR',0,'C',true);
		$this->Cell(21,3,'','LTR',0,'C',true);
		$this->Cell(21,3,'','LTR',0,'C',true);		
		$this->Cell(21,3,'NÚMERO DE','LTR',0,'C',true);
		$this->Cell(21,3,'NÚMERO DE','LTR',0,'C',true);		
		$this->Cell(21,3,'','LTR',0,'C',true);
		$this->Cell(21,3,'','LTR',0,'C',true);
		$this->Cell(12,3,'','LTR',0,'C',true);
		$this->Cell(21,3,'','LTR',1,'C',true);			
		$this->Cell(20,3,'ORDEN DE','LR',0,'C',true);
		$this->Cell(21,3,'FECHA DE','LR',0,'C',true);
		$this->Cell(21,3,'NÚMERO DE','LR',0,'C',true);
		$this->Cell(21,3,'NÚMERO DE','LR',0,'C',true);		
		$this->Cell(21,3,'NOTA DE','LR',0,'C',true);
		$this->Cell(21,3,'FACTURA','LR',0,'C',true);		
		$this->Cell(21,3,'MONTO DE LA','LR',0,'C',true);
		$this->Cell(21,3,'BASE','LR',0,'C',true);
		$this->Cell(12,3,'%','LR',0,'C',true);
		$this->Cell(21,3,'IMPUESTO','LR',1,'C',true);			
		$this->Cell(20,3,'PAGO','LRB',0,'C',true);
		$this->Cell(21,3,'LA FACTURA','LRB',0,'C',true);
		$this->Cell(21,3,'FACTURA','LRB',0,'C',true);
		$this->Cell(21,3,'CONTROL','LRB',0,'C',true);		
		$this->Cell(21,3,'CRÉDITO','LRB',0,'C',true);
		$this->Cell(21,3,'AFECTADA','LRB',0,'C',true);		
		$this->Cell(21,3,'OPERACIÓN','LRB',0,'C',true);
		$this->Cell(21,3,'IMPONIBLE','LRB',0,'C',true);
		$this->Cell(12,3,'ALICUOTA','LRB',0,'C',true);
		$this->Cell(21,3,'RETENIDO','LRB',1,'C',true);	
		$this->Line(10,80,10,234.2);
		$this->Line(30,80,30,234.2);
		$this->Line(51,80,51,234.2);
		$this->Line(72,80,72,234.2);
		$this->Line(93,80,93,234.2);		
		$this->Line(114,80,114,234.2);
		$this->Line(135,80,135,234.2);		
		$this->Line(156,80,156,234.2);
		$this->Line(177,80,177,234.2);		
		$this->Line(189,80,189,234.2);
		$this->Line(210,80,210,234.2);
		
	}
    function Footer(){ global $total_d; global $total_e; global $total_b; global $total_ret; global $total_iva; global $total_r; 
  	    global $orden; global $fin;
	    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  
	    $mtotal_d=formato_monto($total_d); $total_e=formato_monto($total_e); $mtotal_b=formato_monto($total_b);        
		if($fin==0){$mtotal_ret=formato_monto($total_ret);} else{$mtotal_ret=$total_r;}		
		$mtotal_iva=formato_monto($total_iva);
		$this->SetY(-45); $y=$this->GetY(); $l=$y-0.2; $p=$y+5.1;		
		$this->SetFillColor(192,192,192);
		$this->SetFont('Arial','B',7);		
		//$this->Line(250,$l,270,$l);		
		$this->Cell(125,5,'',1,0,'R');
		$this->Cell(21,5,$mtotal_d,1,0,'R');
		$this->Cell(21,5,$mtotal_b,1,0,'R');
		$this->Cell(12,5,'',1,0,'R');
		$this->Cell(21,5,$mtotal_ret,1,1,'R');		
		$this->Cell(200,15,' ',0,1,'C');		
		$this->Cell(100,2,'_____________________________',0,0,'C');
		$this->Cell(100,2,'_____________________________',0,1,'C');		
		$this->Cell(100,3,'FIRMA Y SELLO AGENTE',0,0,'C');
		$this->Cell(100,3,'FRIMA Y SELLO DEL',0,1,'C');
		$this->Cell(100,3,'DE RETENCIÓN',0,0,'C');
		$this->Cell(100,3,'CONTRIBUYENTE',0,1,'C');
		$morden=$orden; 
		if(substr($morden,0,1)=="P"){$this->Cell(200,3,'Nota: Retención aplicada a facturas declaradas que forman parte del total acumulado las cuales alcanzan las 2.500 UT, según lo indicado en la Ley de Contratación Pública',0,1,'L');
		                             $this->Cell(200,3,'y Opinión Jurídica de Consultoría Jurídica, según Oficio Nº 272/11 y procedimiento emitido por la Dirección de Informática según Oficio Nº 2001/015.',0,1,'L');
									 $this->Cell(200,3,'Nomenclatura Utilizada: Inicial del mes y Nº de Factura.',0,1,'L');}
		$this->SetFillColor(255,0,0);
		$this->Ln(2);
	}	
}
  $fin=0;
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $pdf->SetAutoPageBreak(true, 45);  
  
    $total_d=0;  $total_s=0;  $total_b=0;  $total_iva=0;  $total_ret=0; $total_ret_fact=0; $aplica_sust=1;
	$monto_r="";$monto_o=""; $monto1=0; $monto2=0;  $nro_op=0;
	if($tipo_planilla=="01"){$sql="SELECT * FROM PAG016  where nro_orden='$orden' order by fecha_factura,nro_factura";}
	else {$sql="SELECT * FROM PAG016  where nro_orden='$orden'  and status_2='N' order by fecha_factura,nro_factura";}
	$res=pg_query($sql);
	while(($registro=pg_fetch_array($res))and($error==0)) {
    	$sfecha=$registro["fecha_factura"]; $fecha = substr($sfecha,8,2)."/".substr($sfecha,5,2)."/".substr($sfecha,0,4); $nro_op=$nro_op+1;
		$nro_fact=$registro["nro_factura"]; $nro_control=$registro["nro_con_factura"]; $nro_fact=elimina_ceros($nro_fact);  $nro_control=elimina_ceros($nro_control);
		$monto=$registro["monto_factura"]; $pmonto=$monto; $monto_m=formato_monto($monto);	
        $montos=$registro["monto_sin_iva"]; $pmontos=$montos; $montos=formato_monto($montos);
		$tasa_iva=$registro["tasa_iva1"];  $tasa_iva=formato_monto($tasa_iva);
		$montoo=$registro["monto_iva1_so"];  $montob=$registro["monto_iva4_so"]; 
		if($tipo_planilla=="01"){$montob=$montob;} else {$montob=$montoo;}
		if($tipo_planilla=="03"){   if($clasificacion=="CLINICAS"){$montob=$registro["monto_sin_iva"];} else {$montob=$montob;} }
		$montor=($montob*$tasa)/100; $pmontob=$montob; $monto_b=formato_monto($montob); $montoo=formato_monto($montoo);
		if($aplica_sust==0){$montor=$montor-$sustraendo; $aplica_sust=1;} 
		$pmontor=$montor; $monto_r=formato_monto($montor);
        $nro_cred=""; $nro_afecta="";
		if($monto<0){$nro_cred=$nro_fact; $nro_fact=""; $nro_afecta=$registro["campo_str2"];}
		$morden=$orden; if(substr($morden,0,1)=="P"){$morden="";}
        $pdf->Cell(20,3,$morden,0,0,'C');
	    $pdf->Cell(21,3,$fecha,0,0,'C');	
	    $pdf->Cell(21,3,$nro_fact,0,0,'C');
	    $pdf->Cell(21,3,$nro_control,0,0,'C');
		
		$pdf->Cell(21,3,$nro_cred,0,0,'C');
	    $pdf->Cell(21,3,$nro_afecta,0,0,'C');
		
	    $pdf->Cell(21,3,$monto_m,0,0,'R');
	    $pdf->Cell(21,3,$monto_b,0,0,'R');
	    $pdf->Cell(12,3,$tasa,0,0,'C');
	    $pdf->Cell(21,3,$monto_r,0,1,'R'); 
		
		$total_d=$total_d+$pmonto; $total_s=$total_s+$pmontos; $total_b=$total_b+$pmontob; 
	    $total_ret=$pmontor+$total_ret;
	 }
	 $morden=$orden; if(substr($morden,0,1)=="P"){$pdf->Cell(20,3,"Ver Nota",0,0,'C');}
     $fin=1;
 $pdf->Output();
 pg_close();


?>