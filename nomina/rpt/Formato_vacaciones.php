<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT"; error_reporting(E_ALL ^ E_NOTICE); 
if (!$_GET){ $cod_empleado='';} else{$cod_empleado=$_GET["txtcod_empleado"];} 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$nombre=""; $cedula=""; $fecha_ingreso=""; $fecha_caus_hasta=""; $fecha_caus_desde=""; $denominacion=""; $cod_concepto_v=""; $fecha_d_desde=""; $fecha_d_hasta="";
$dias_habiles=0; $dias_no_habiles=0; $fecha_d_desde=""; $fecha_d_hasta=""; $fecha_reincorp=""; $dias_bono_vac=0; $monto_bono_vac=0; $dias_disfrutados=0; $inf_usuario="";
$calcula_nomina="NO"; $fecha_cal_d=""; $fecha_cal_h=""; $des_cargo=""; $des_departamento=""; $monto_concepto=0; $des_nomina=""; $tipo_nomina=""; $monto_sueldo=0;
$sql="Select * FROM CALCULO_VACACIONES where (cod_empleado='$cod_empleado')";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);
  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);
  $cod_empleado=$registro["cod_empleado"];  $fecha_caus_hasta=$registro["fecha_caus_hasta"]; $fecha_caus_desde=$registro["fecha_caus_desde"]; $fecha_caus_desde=formato_ddmmaaaa($fecha_caus_desde);  $fecha_caus_hasta=formato_ddmmaaaa($fecha_caus_hasta);
  $cod_concepto_v=$registro["cod_concepto_v"]; $dias_habiles=$registro["dias_habiles"]; $dias_no_habiles=$registro["dias_no_habiles"]; $tipo_nomina=$registro["tipo_nomina"];
  $fecha_d_desde=$registro["fecha_desde"]; $fecha_d_hasta=$registro["fecha_hasta"]; $fecha_reincorp=$registro["fecha_reincorp"]; 
  $fecha_d_desde=formato_ddmmaaaa($fecha_d_desde); $fecha_d_hasta=formato_ddmmaaaa($fecha_d_hasta);  $fecha_reincorp=formato_ddmmaaaa($fecha_reincorp); 
  $dias_bono_vac=$registro["dias_bono_vaca"]; $monto_bono_vac=$registro["monto_bono_vaca"]; $calcula_nomina=$registro["calcula_nomina"];
  $fecha_cal_d=$registro["fecha_calculo_d"]; $fecha_cal_h=$registro["fecha_calculo_h"]; $fecha_cal_d=formato_ddmmaaaa($fecha_cal_d);  $fecha_cal_h=formato_ddmmaaaa($fecha_cal_h);
  $des_cargo=$registro["des_cargo"]; $des_departamento=$registro["des_departamento"]; $monto_concepto=$registro["monto_concepto_v"]; $usuario_vac=$registro["usuario_sia"];
  $monto_sueldo=$registro["sueldo"]; $monto_sueldo=formato_monto($monto_sueldo);
}
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$des_nomina=$registro["descripcion"];}
$dias_no_habiles=parte_entera($dias_no_habiles); $dias_bono_vac=parte_entera($dias_bono_vac); 
$mperiodo=substr($fecha_caus_desde,6,4)."-".substr($fecha_caus_hasta,6,4);
$dias1=15; $dias2=$dias_habiles-$dias1; $mdia=$monto_bono_vac/$dias_bono_vac; $mmensual=$mdia*30;
$mmensual=$monto_concepto; $mdia=$monto_concepto/30;$mdia=formato_monto($mdia); $mmensual=formato_monto($mmensual);
$sql="select * from sia001 where campo101='$usuario_vac'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];}

require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){ global $nombre; global $cedula; global $fecha_ingreso; global $des_cargo;
        global $monto_sueldo; global $mperiodo; global $fecha_d_desde; global $fecha_d_hasta; global $fecha_reincorp;
		global $dias1; global $dias2; global $dias_no_habiles; global $dias_bono_vac;
	    $this->Image('../../imagenes/Logo_emp.png',7,7,20);
		$this->SetFont('Arial','B',12);
		$this->Cell(50);
		$this->Cell(100,10,'RECIBO LIQUIDACION DE VACACIONES',1,0,'C');
		$this->Ln(20);
		$this->SetFont('Arial','B',9);
		$this->Cell(40,4,'Apellidos y Nombres :',0,0,'L'); 
		$this->SetFont('Arial','',9);
        $this->Cell(160,4,$nombre,0,1,'L'); 
		$this->SetFont('Arial','B',9);
		$this->Cell(40,4,'Cedula de identidad :',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(60,4,$cedula,0,0,'L');
        $this->SetFont('Arial','B',9);		
		$this->Cell(35,4,'Fecha de Ingreso : ',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(65,4,$fecha_ingreso,0,1,'L');
		$this->SetFont('Arial','B',9);
	    $this->Cell(20,4,'Cargo : ',0,0,'L');
		$this->SetFont('Arial','',9);
        $this->Cell(180,4,$des_cargo,0,1,'L');
        $this->SetFont('Arial','B',9);	
        $this->Cell(20,4,'Sueldo :',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(80,4,$monto_sueldo,0,0,'L');
        $this->SetFont('Arial','B',9);		
		$this->Cell(35,4,'Periodo de Disfrute : ',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(65,4,$mperiodo,0,1,'L');
        $this->SetFont('Arial','B',9);	
        $this->Cell(42,4,'Fecha de Disfrute Desde :',0,0,'L');
		$this->SetFont('Arial','',9);
        $this->Cell(30,4,$fecha_d_desde,0,0,'L');
		$this->SetFont('Arial','B',9);	
        $this->Cell(16,4,'Hasta :',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(30,4,$fecha_d_hasta,0,0,'L');
        $this->SetFont('Arial','B',9);		
		$this->Cell(42,4,'Fecha a Reincorporarse : ',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(40,4,$fecha_reincorp,0,1,'L');

        $this->Cell(55,4,'Dias Vacaciones (Art. 190 LOTT) :  ',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(40,4,$dias1,0,0,'L');
        $this->SetFont('Arial','B',9);		
		$this->Cell(73,4,'Dias Adicionales Vacaciones (Art. 190 LOTT) :',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(32,4,$dias2,0,1,'L');
		
		$this->Cell(55,4,'Dias Feriados, Sabados y Domingos :  ',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(45,4,$dias_no_habiles,0,0,'L');
        $this->SetFont('Arial','B',9);		
		$this->Cell(45,4,'Dias Bono Vacacional : ',0,0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(55,4,$dias_bono_vac,0,1,'L');

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
  $sql="SELECT cod_concepto,denominacion,asig_ded_apo,sum(monto) as monto,sum(cantidad) as cantidad FROM NOM023 where (oculto='NO') and (cod_empleado='$cod_empleado') group by cod_concepto,denominacion,asig_ded_apo order by cod_concepto";
  $res=pg_query($sql); $filas=pg_num_rows($res); $prev_conc=""; $prev_monto=0; $total=0; $totala=0; $totald=0;
  while($registro=pg_fetch_array($res)){     
	$monto=formato_monto($registro["monto"]); $denominacion=$registro["denominacion"];
	$asig_ded_apo=$registro["asig_ded_apo"]; $asignacion=""; $deduccion=""; $cantidad=$registro["cantidad"]; $sueldo_dia="";
	if($asig_ded_apo=="A"){ $total=$total+$registro["monto"]; $totala=$totala+$registro["monto"]; $asignacion=$monto; if($cantidad>0){$sueldo_dia=$registro["monto"]/$cantidad; $sueldo_dia=formato_monto($sueldo_dia);} } 
	if($asig_ded_apo=="D"){ $totald=$totald+$registro["monto"];  $cantidad=""; $total=$total-$registro["monto"]; $deduccion=$monto;}
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
  $pdf->Cell(200,6,'NETO A COBRAR : '.$total,1,0,'C');
  $pdf->Ln(10);
  $pdf->MultiCell(200,4,"Declaro que recibo en este acto el pago de mis vacaciones Vencidas Correspondiente al periodo  , como lo estipula la Vigente Ley del Trabajo",0);
  $pdf->Output();
  pg_close();
?>

<