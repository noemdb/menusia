<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT"; error_reporting(E_ALL ^ E_NOTICE); 
if (!$_GET){ $cod_empleado='';} else{$cod_empleado=$_GET["txtcod_empleado"];} 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$nombre=""; $cedula=""; $fecha_ingreso=""; $fecha_caus_hasta=""; $fecha_caus_desde=""; $denominacion=""; $cod_concepto_v=""; $fecha_d_desde=""; $fecha_d_hasta=""; $cod_cargo=""; $cod_departam="";
$dias_habiles=0; $dias_no_habiles=0; $fecha_d_desde=""; $fecha_d_hasta=""; $fecha_reincorp=""; $dias_bono_vac=0; $monto_bono_vac=0; $dias_disfrutados=0; $inf_usuario="";
$calcula_nomina="NO"; $fecha_cal_d=""; $fecha_cal_h=""; $des_cargo=""; $des_departamento=""; $monto_concepto=0; $des_nomina=""; $tipo_nomina=""; $monto_sueldo=0;
$sql="Select * FROM CALCULO_VACACIONES where (cod_empleado='$cod_empleado')";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);
  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);
  $cod_empleado=$registro["cod_empleado"];  $fecha_caus_hasta=$registro["fecha_caus_hasta"]; $fecha_caus_desde=$registro["fecha_caus_desde"]; $fecha_caus_desde=formato_ddmmaaaa($fecha_caus_desde);  $fecha_caus_hasta=formato_ddmmaaaa($fecha_caus_hasta);
  $cod_concepto_v=$registro["cod_concepto_v"]; $dias_habiles=$registro["dias_habiles"]; $dias_no_habiles=$registro["dias_no_habiles"]; $tipo_nomina=$registro["tipo_nomina"];
  $fecha_d_desde=$registro["fecha_desde"]; $fecha_d_hasta=$registro["fecha_hasta"]; $fecha_reincorp=$registro["fecha_reincorp"]; 
  $fecha_d_desde=formato_ddmmaaaa($fecha_d_desde); $fecha_d_hasta=formato_ddmmaaaa($fecha_d_hasta);  $fecha_reincorp=formato_ddmmaaaa($fecha_reincorp); 
  $dias_bono_vac=$registro["dias_bono_vaca"]; $monto_bono_vac=$registro["monto_bono_vaca"]; $calcula_nomina=$registro["calcula_nomina"]; $cod_cargo=$registro["cod_cargo"]; $cod_departam=$registro["cod_departam"];
  $fecha_cal_d=$registro["fecha_calculo_d"]; $fecha_cal_h=$registro["fecha_calculo_h"]; $fecha_cal_d=formato_ddmmaaaa($fecha_cal_d);  $fecha_cal_h=formato_ddmmaaaa($fecha_cal_h);
  $des_cargo=$registro["des_cargo"]; $des_departamento=$registro["des_departamento"]; $monto_concepto=$registro["monto_concepto_v"]; $usuario_vac=$registro["usuario_sia"];
  $monto_sueldo=$registro["sueldo"]; $monto_sueldo=formato_monto($monto_sueldo);
}
$sql="SELECT tipo_nomina,descripcion FROM nom001 where tipo_nomina='$tipo_nomina'"; $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$des_nomina=$registro["descripcion"];}
$dias_no_habiles=parte_entera($dias_no_habiles); $dias_bono_vac=parte_entera($dias_bono_vac); 
$mperiodo=substr($fecha_caus_desde,6,4)." - ".substr($fecha_caus_hasta,6,4);
$dias1=15; $dias2=$dias_habiles-$dias1; $mdia=$monto_bono_vac/$dias_bono_vac; $mmensual=$mdia*30;
$mmensual=$monto_concepto; $mdia=$monto_concepto/30;$mdia=formato_monto($mdia); $mmensual=formato_monto($mmensual);
$sql="select * from sia001 where campo101='$usuario_vac'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];}

require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){ global $nombre; global $cedula; global $fecha_ingreso; global $des_cargo; global $cod_cargo; global $cod_departam;
        global $monto_sueldo; global $mperiodo; global $fecha_d_desde; global $fecha_d_hasta; global $fecha_reincorp;
		global $dias1; global $dias2; global $dias_no_habiles; global $dias_bono_vac; global $des_departamento;
	    $this->Image('../../imagenes/logo_emp.png',10,4,20);
		$this->SetFont('Arial','',7);
		$this->Cell(20,4,'',0,0,'L');
		$this->Cell(20,4,'IMAUBAR',0,1,'L');
		$this->SetFont('Arial','',7);
		$this->Cell(20,4,'',0,0,'L');
		$this->Cell(90,4,'SIPAP Nómina y Personal',0,1,'L'); 
		$this->SetFont('Arial','B',12);
		$this->Cell(50);
		$this->Cell(100,10,'LIQUIDACION DE VACACIONES',0,0,'C');
		$this->Ln(20);
		$this->SetFont('Arial','B',9);
		
		
		$y=$this->GetY();
		$this->rect(10,$y,200,250-$y);
		$this->Cell(155,5,'Departamento','LTR',0,'C');
		$this->Cell(45,5,'Código del Departamento','LTR',1,'C');
		$this->SetFont('Arial','',10);
		$this->Cell(155,6,$des_departamento,'LBR',0,'C');
		$this->Cell(45,6,$cod_departam,'LBR',1,'C');
		$this->SetFont('Arial','B',9);
		$this->Cell(115,5,'Apellidos y Nombres','LTR',0,'C'); 
		$this->Cell(32,5,'Cedula de identidad','LTR',0,'C');
		$this->Cell(28,5,'Fecha de Ingreso','LTR',0,'C');
		$this->Cell(25,5,'Sueldo','LTR',1,'C');
		$this->SetFont('Arial','',10);
		$this->Cell(115,6,$nombre,'LBR',0,'L'); 
		$this->Cell(32,6,$cedula,'LBR',0,'C');
		$this->Cell(28,6,$fecha_ingreso,'LBR',0,'C');
		$this->Cell(25,6,$monto_sueldo,'LBR',1,'C');
        $this->SetFont('Arial','B',9);
		$this->Cell(30,5,'Codigo del Cargo','LTR',0,'C');
		$this->Cell(100,5,'Cargo','LTR',0,'C');
		$this->Cell(70,5,'Fecha de Vacaciones a Disfrutar','LTR',1,'C');
		$this->SetFont('Arial','',10);
		$this->Cell(30,6,$cod_cargo,'LBR',0,'C');
		$this->Cell(100,6,$des_cargo,'LBR',0,'L');
		$this->Cell(70,6,'Desde: '.$fecha_d_desde.'   Hasta: '.$fecha_d_hasta,'LBR',1,'C');
		
		$this->SetFont('Arial','B',9);
		$this->Cell(90,5,'Lapso Vacaciones a Disfrutar','LTR',0,'C');
		$this->Cell(60,5,'Dias Bono Vacacional','LTR',0,'C');
		$this->Cell(50,5,'Fecha a Reincorporarse','LTR',1,'C');
		$this->SetFont('Arial','',10);
		$this->Cell(90,6,$mperiodo,'LBR',0,'C');
		$this->Cell(60,6,$dias_bono_vac,'LBR',0,'C');
		$this->Cell(50,6,$fecha_reincorp,'LBR',1,'C');
		
		$this->SetFont('Arial','B',11);
		$this->Cell(200,8,'CALCULO DE VACACIONES',1,1,'C');
		$this->SetFont('Arial','B',9);
        $this->Cell(125,5,'Descripcion de Concepto',1,0,'L');
        $this->Cell(15,5,'Dias',1,0,'C');
		$this->Cell(30,5,'Sueldo Diario',1,0,'C');
		$this->Cell(30,5,'Sub-Total',1,1,'C');
		
      	
		
	
							
	}
	
	function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
	  $this->SetY(-85);
	  $this->Cell(200,5,'  ','T',1,'C');
	  
	  $this->SetFont('Arial','B',9);
	    $this->Cell(10,5,'  ',0,0,'L');
		$this->Cell(50,5,'Elaborado Por:',0,0,'C');
		$this->Cell(60,5,'Gerente de Recursos Humanos',0,0,'C');
		$this->Cell(80,5,'Apellidos y Nombres del Trabajador',0,1,'C');
		
	  $this->Ln(10);
	  $this->Cell(10,4,'  ','',0,'L');
	  $this->Cell(50,4,'  ','',0,'L'); 
	  $this->Cell(10,4,'  ',0,0,'L'); 
	  $this->Cell(50,4,'  ','',0,'L');
      $this->Cell(10,4,'  ','',0,'L');	  
	  $this->Cell(65,4,'  ','T',0,'L'); 
	  $this->Cell(5,4,'  ',0,1,'C'); 
	  $this->Ln(14);
	  $this->Cell(10,4,'  ','',0,'L');
	  $this->Cell(50,4,'  ','T',0,'L'); 
	  $this->Cell(10,4,'  ',0,0,'L'); 
	  $this->Cell(50,4,'  ','T',0,'L'); 
	  $this->Cell(5,4,'  ',0,0,'L'); 
	  $this->Cell(25,4,'  ','T',0,'L'); 
	  $this->Cell(5,4,'  ',0,0,'C');
	  $this->Cell(40,4,'  ','T',1,'L');
	  
	  $this->Cell(130,4,'  ','',0,'L');
	  $this->Cell(30,5,'C.I.No:',0,0,'L');
	  $this->Cell(40,5,'Firma del Trabajador',0,1,'L');
	  
	  $this->Ln(10);
	  $this->SetFont('Arial','B',7);
	  $this->Cell(50,3,'Unidad de Personal',0,1,'L');
	  $this->Cell(50,3,'c.c. Original Expediente',0,1,'L');
	  $this->Cell(50,3,'c.c. Funcionario',0,1,'L');
	  $this->SetFont('Arial','',7);
	  $this->Cell(100,5,'Fecha: '.$ffechar.' -  Hora: '.$fhorar,0,1,'L');
	} 
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',9);
  $pdf->SetAutoPageBreak(true, 85); 
  $sql="SELECT cod_concepto,denominacion,asig_ded_apo,sum(monto) as monto,sum(cantidad) as cantidad FROM NOM023 where (oculto='NO') and (cod_empleado='$cod_empleado') group by cod_concepto,denominacion,asig_ded_apo order by cod_concepto";
  $res=pg_query($sql); $filas=pg_num_rows($res); $prev_conc=""; $prev_monto=0; $total=0; $totala=0; $totald=0;
  while($registro=pg_fetch_array($res)){     
	$monto=formato_monto($registro["monto"]); $denominacion=$registro["denominacion"];
	$asig_ded_apo=$registro["asig_ded_apo"]; $asignacion=""; $deduccion=""; $cantidad=$registro["cantidad"]; $sueldo_dia="";
	if($asig_ded_apo=="A"){ $total=$total+$registro["monto"]; $totala=$totala+$registro["monto"]; $asignacion=$monto; if($cantidad>0){$sueldo_dia=$registro["monto"]/$cantidad; $sueldo_dia=formato_monto($sueldo_dia);} } 
	if($asig_ded_apo=="D"){ $totald=$totald+$registro["monto"];  $cantidad=""; $total=$total-$registro["monto"]; $deduccion=$monto;}
    $x=$pdf->GetX();   $y=$pdf->GetY();  $w=125;		   
	$pdf->SetXY($x+$w,$y);		   
	$pdf->Cell(15,8,$cantidad,0,0,'R'); 
	$pdf->Cell(30,8,$sueldo_dia,0,0,'R'); 
	$pdf->Cell(30,8,$asignacion,0,0,'R'); 
	$pdf->SetXY($x,$y);	
	$pdf->MultiCell($w,8,$denominacion,'L'); 
  }
  $total=formato_monto($total); $totala=formato_monto($totala); $totald=formato_monto($totald);
  
  $pdf->SetFont('Arial','B',10);
  $pdf->Cell(200,8,'NETO A COBRAR  :        '.$total,1,0,'R');
  $pdf->Ln(10);
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(100,5,' Observaciones :',0,1,'L');
  $pdf->Output();
  pg_close();
?>
