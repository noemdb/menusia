<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){ $cod_empleado='';} else{$cod_empleado=$_GET["txtcod_empleado"];} 

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$nombre="";$cedula=""; $fecha_ingreso=""; $fecha_liquidacion=""; 
$ant_ano="";$ant_mes="";$ant_dia="";$cod_sue_int="";$monto_sue_int=0;$sueldo_basico=0;$tiempo_servicio=0;$campo_str1="";$campo_str2="";$campo_num1="";$campo_num2="";$inf_usuario="";
$tipo_liquidacion="";$sueldo_liquidacion=0;$sueldo_vacaciones=0;$dias_preaviso=0;$monto_preaviso=0; $total_adelantos=0; $total_intereses=0; $int_fraccionados=0;
$dias_vacaciones_f=0;$monto_vacaciones_f=0;$dias_bono_vac_f=0;$monto_bono_vac_f=0;$total_vacaciones_p=0;$total_bono_vac_p=0; 
$monto_ant_depositada=0;$monto_art142=0;$fecha_ant_depositada="";$status=""; $cod_cargo=""; $des_cargo=""; $cod_departamento=""; $des_departamento="";
$sql="Select * FROM CALCULO_LIQUIDACION  where (cod_empleado='$cod_empleado') "; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){  $registro=pg_fetch_array($res,0);  
  $cod_empleado=$registro["cod_empleado"];  $fecha_liquidacion=$registro["fecha_liquidacion"]; $fecha_liquidacion=formato_ddmmaaaa($fecha_liquidacion);  
  $ant_ano=$registro["ant_ano"]; $ant_mes=$registro["ant_mes"]; $ant_dia=$registro["ant_dia"]; $cod_sue_int=$registro["cod_sue_int"];
  $monto_sue_int=$registro["monto_sue_int"]; $sueldo_basico=$registro["sueldo_basico"]; $tiempo_servicio=$registro["tiempo_servicio"];
  $tipo_liquidacion=$registro["tipo_liquidacion"];   $sueldo_liquidacion=$registro["sueldo_liquidacion"];  $sueldo_vacaciones=$registro["sueldo_vacaciones"];
  $dias_preaviso=$registro["dias_preaviso"];  $monto_preaviso=$registro["monto_preaviso"];  $total_adelantos=$registro["total_adelantos"]; 
  $total_intereses=$registro["total_intereses"];   $int_fraccionados=$registro["int_fraccionados"];$dias_vacaciones_f=$registro["dias_vacaciones_f"];
  $monto_vacaciones_f=$registro["monto_vacaciones_f"];$dias_bono_vac_f=$registro["dias_bono_vac_f"];$monto_bono_vac_f=$registro["monto_bono_vac_f"];
  $total_vacaciones_p=$registro["total_vacaciones_p"];$total_bono_vac_p=$registro["total_bono_vac_p"];  
  $monto_ant_depositada=$registro["monto_ant_depositada"]; $monto_art142=$registro["monto_art142"]; $fecha_ant_depositada=$registro["fecha_ant_depositada"]; $fecha_ant_depositada=formato_ddmmaaaa($fecha_ant_depositada);  
  $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"]; $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"]; $inf_usuario=$registro["inf_usuario"];  $usuario_cal=$registro["usuario_sia"];
  $cod_cargo=$registro["cod_cargo"]; $des_cargo=$registro["des_cargo"];$cod_departamento=$registro["cod_departamento"]; $des_departamento=$registro["des_departamento"];
  
  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);   	
} 
$monto_sue_int=formato_monto($monto_sue_int);  $sueldo_basico=formato_monto($sueldo_basico); $monto_preaviso=formato_monto($monto_preaviso);  
$sueldo_liquidacion=formato_monto($sueldo_liquidacion);  $sueldo_vacaciones=formato_monto($sueldo_vacaciones);
$monto_ant_depositada=formato_monto($monto_ant_depositada);   $monto_art142=formato_monto($monto_art142);
$total_bono_vac_p=formato_monto($total_bono_vac_p); $total_vacaciones_p=formato_monto($total_vacaciones_p);
$monto_vacaciones_f=formato_monto($monto_vacaciones_f); $monto_bono_vac_f=formato_monto($monto_bono_vac_f); 
$total_adelantos=formato_monto($total_adelantos);  $total_intereses=formato_monto($total_intereses);  $int_fraccionados=formato_monto($int_fraccionados); 

$sql="select * from sia001 where campo101='$usuario_cal'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];}

require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){ global $nombre; global $cedula; global $fecha_ingreso; global $des_cargo;  global $sueldo_basico; global $sueldo_liquidacion; global $fecha_liquidacion;
	    global $ant_ano; global $ant_mes; global $ant_dia; global $tipo_liquidacion;
		$this->Image('../../imagenes/Logo_emp.png',7,7,20);
		$this->SetFont('Arial','B',12);
		$this->Cell(50);
		$this->Cell(100,10,'RECIBO CALCULO DE LIQUIDACION',1,0,'C');
		$this->Ln(20);
		$this->SetFont('Arial','B',9);
		$this->Cell(40,4,'Apellidos y Nombres :',0,0,'L'); 
		$this->SetFont('Arial','',9);
        $this->Cell(160,4,$nombre,0,1,'L');
		
		$this->SetFont('Arial','B',9);
		$this->Cell(40,4,'Cedula de identidad :',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(30,4,$cedula,0,0,'L');
        $this->SetFont('Arial','B',9);		
		$this->Cell(30,4,'Fecha de Ingreso : ',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(30,4,$fecha_ingreso,0,0,'L');
		
		$this->SetFont('Arial','B',9);		
		$this->Cell(35,4,'Fecha Liquidacion : ',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(35,4,$fecha_liquidacion,0,1,'L');
		
		$this->SetFont('Arial','B',9);
		$this->Cell(100,4,"Antiguedad : ".$ant_ano." Años  ".$ant_mes." Meses  ".$ant_dia."  Dias",0,0,'L');
		
		$this->SetFont('Arial','B',9);		
		$this->Cell(35,4,'Motivo Liquidacion : ',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(35,4,$tipo_liquidacion,0,1,'L');
		
		$this->SetFont('Arial','B',9);
	    $this->Cell(20,4,'Cargo : ',0,0,'L');
		$this->SetFont('Arial','',9);
        $this->Cell(180,4,$des_cargo,0,1,'L');
		
        $this->SetFont('Arial','B',9);	
        $this->Cell(25,4,'Sueldo Base :',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(75,4,$sueldo_basico,0,0,'L');
        $this->SetFont('Arial','B',9);	
		$this->Cell(45,4,'Sueldo Calculo Liquidacion :',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(55,4,$sueldo_liquidacion,0,1,'L');

		
		
		$this->Ln(4);
        $this->Cell(120,5,'Descripcion de Concepto',1,0,'L');
		$this->Cell(14,5,'Dias',1,0,'C');
		$this->Cell(22,5,'Sueldo Diario',1,0,'R');
		$this->Cell(22,5,'Asignaciones',1,0,'R');
		$this->Cell(22,5,'Deducciones',1,1,'R');
							
	}
	
	function Footer(){ 
	  $this->SetY(-45);
	  $this->Cell(65,4,'Elaborado :',0,0,'L'); 
	  $this->Cell(65,4,'Revisado: ',0,0,'L'); 
	  $this->Cell(70,4,'Firma del Tabajador :',0,1,'L'); 
	  $this->Ln(16);
	  $this->Cell(55,4,'  ','T',0,'L'); 
	  $this->Cell(10,4,'  ',0,0,'L'); 
	  $this->Cell(55,4,'  ','T',0,'L'); 
	  $this->Cell(10,4,'  ',0,0,'L'); 
	  $this->Cell(60,4,'  ','T',0,'L'); 
	  $this->Cell(10,4,'  ',0,1,'L'); 
	} 
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',8);
  $pdf->SetAutoPageBreak(true, 45); 
  $sql="SELECT * FROM NOM036 where (cod_empleado='$cod_empleado') order by cod_concepto";
  $res=pg_query($sql); $filas=pg_num_rows($res); $prev_conc=""; $prev_monto=0; $total=0; $totala=0; $totald=0;
  while($registro=pg_fetch_array($res)){     
	$monto=formato_monto($registro["monto"]); $denominacion=$registro["den_concepto"];
	$asig_ded_apo=$registro["asig_ded_apo"]; $asignacion=""; $deduccion=""; $cantidad=$registro["cantidad"]; $sueldo_dia=$registro["monto_base"]; 
	if($asig_ded_apo=="A"){ $total=$total+$registro["monto"]; $totala=$totala+$registro["monto"]; $asignacion=$monto; $sueldo_dia=formato_monto($sueldo_dia); } 
	if($asig_ded_apo=="D"){ $totald=$totald+$registro["monto"];  $cantidad=""; $sueldo_dia=""; $total=$total-$registro["monto"]; $deduccion=$monto;}
    $x=$pdf->GetX();   $y=$pdf->GetY();  $w=120;		   
	$pdf->SetXY($x+$w,$y);		   
	$pdf->Cell(14,4,$cantidad,0,0,'R'); 
	$pdf->Cell(22,4,$sueldo_dia,0,0,'R'); 
	$pdf->Cell(22,4,$asignacion,0,0,'R'); 
	$pdf->Cell(22,4,$deduccion,'R',1,'R'); 
	$pdf->SetXY($x,$y);	
	$pdf->MultiCell($w,4,$denominacion,'L'); 
  }
  $total=formato_monto($total); $totala=formato_monto($totala); $totald=formato_monto($totald);
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(156,5,'',1,0,'R');
  $pdf->Cell(22,5,$totala,1,0,'R'); 
  $pdf->Cell(22,5,$totald,1,1,'R');
  $pdf->Ln(5);
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(200,6,'NETO A COBRAR : '.$total,1,1,'C');
  $pdf->Cell(100,6,'',0,1,'R');; 
  
  $x1=$pdf->GetX();   $y1=$pdf->GetY();
 	
  
  $monto_letras=monto_letras($total_neto);
  $pdf->SetFont('Arial','',9);
  $texto1='El suscrito Trabajador decjara haber recibido a su entera satisfacccion la catidad de bolivares';
  $pdf->Cell(200,6,$texto1,0,1,'L');
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(200,6,$monto_letras,0,1,'C');
  $texto2='por concepto de pago completo de los salarios e indemnizaciones hasta la fecha de la presente liquidacion';
  $pdf->MultiCell(200,4,$texto2,0);
  $pdf->Ln(15);
  $pdf->Cell(120,6,'Firma del Tarbajador _______________________________________',0,0,'L');
  $pdf->Cell(80,6,'Cedula de Identidad _____________________',0,1,'L');
  
  $x2=$pdf->GetX();   $y2=$pdf->GetY(); $t=$y2-y1;
  $pdf->rect(10,$y1,200,40);
  
  $pdf->Output();
  pg_close();
?>

<