<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT"; error_reporting(E_ALL ^ E_NOTICE); 
if (!$_GET){ $cod_empleado=''; $letra='A';} else{$cod_empleado=$_GET["txtcod_empleado"]; $letra=$_GET["letra"]; } 

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$nombre="";$cedula=""; $fecha_ingreso=""; $fecha_liquidacion=""; $referencia=""; $total_asignacion=0;  $total_deduccion=0;
$ant_ano="";$ant_mes="";$ant_dia="";$cod_sue_int="";$monto_sue_int=0;$sueldo_basico=0;$tiempo_servicio=0;$campo_str1="";$campo_str2="";$campo_num1="";$campo_num2="";$inf_usuario="";
$tipo_liquidacion="";$sueldo_liquidacion=0;$sueldo_vacaciones=0;$dias_preaviso=0;$monto_preaviso=0; $total_adelantos=0; $total_intereses=0; $int_fraccionados=0;
$dias_vacaciones_f=0;$monto_vacaciones_f=0;$dias_bono_vac_f=0;$monto_bono_vac_f=0;$total_vacaciones_p=0;$total_bono_vac_p=0; $monto_banco=0;
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
  $total_vacaciones_p=$registro["total_vacaciones_p"];$total_bono_vac_p=$registro["total_bono_vac_p"];  $total_asignacion=$registro["total_asignacion"];  $total_deduccion=$registro["total_deduccion"];
  $monto_ant_depositada=$registro["monto_ant_depositada"]; $monto_art142=$registro["monto_art142"]; $fecha_ant_depositada=$registro["fecha_ant_depositada"]; $fecha_ant_depositada=formato_ddmmaaaa($fecha_ant_depositada);  
  $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"]; $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"]; $inf_usuario=$registro["inf_usuario"];  $usuario_cal=$registro["usuario_sia"];
  $cod_cargo=$registro["cod_cargo"]; $des_cargo=$registro["des_cargo"];$cod_departamento=$registro["cod_departamento"]; $des_departamento=$registro["des_departamento"];
  $referencia=$registro["campo_str1"]; $total_neto=$total_asignacion-$total_deduccion; $monto_banco=$registro["campo_num1"];
  $nombre=$registro["nombre"]; $cedula=$registro["cedula"]; $fecha_ingreso=$registro["fecha_ingreso"];  $fecha_ingreso=formato_ddmmaaaa($fecha_ingreso);  
  
} 
$temp_monto_art142=$monto_art142;  $temp_monto_ant_depositada=$monto_ant_depositada; $temp_dias=$tiempo_servicio*30; if($temp_dias>0){$temp_diario=$monto_art142/$temp_dias;}else{$temp_diario=0;}
$monto_sue_int=formato_monto($monto_sue_int);  $sueldo_basico=formato_monto($sueldo_basico); $monto_preaviso=formato_monto($monto_preaviso);  $monto_banco=formato_monto($monto_banco);  
$sueldo_liquidacion=formato_monto($sueldo_liquidacion);  $sueldo_vacaciones=formato_monto($sueldo_vacaciones);
$monto_ant_depositada=formato_monto($monto_ant_depositada);   $monto_art142=formato_monto($monto_art142);
$total_bono_vac_p=formato_monto($total_bono_vac_p); $total_vacaciones_p=formato_monto($total_vacaciones_p);
$monto_vacaciones_f=formato_monto($monto_vacaciones_f); $monto_bono_vac_f=formato_monto($monto_bono_vac_f); 
$total_adelantos=formato_monto($total_adelantos);  $total_intereses=formato_monto($total_intereses);  $int_fraccionados=formato_monto($int_fraccionados); $t_neto=formato_monto($total_neto);
$monto_letras=monto_letras($t_neto); $monto_letras_ban=monto_letras($monto_banco);
$sql="select * from sia001 where campo101='$usuario_cal'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];}

require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){ global $nombre; global $cedula; global $fecha_ingreso; global $des_cargo;  global $sueldo_basico; global $sueldo_liquidacion; global $fecha_liquidacion;
	    global $ant_ano; global $ant_mes; global $ant_dia; global $tipo_liquidacion; global $referencia; global $sueldo_vacaciones; global $letra; global $total_neto; global $total; global $monto_letras;
		
		$this->rect(10,5,200,262);		
		//$this->Image('../../imagenes/logo_emp.png',190,6,15);
		$this->Image('../../imagenes/logo escudo.png',12,6,20);
		//$this->Cell(5);
		$this->SetFont('Arial','B',8);	
		$this->Cell(200,4,'República Bolivariana de Venezuela ',0,1,'C');
		$this->Cell(200,4,'Gobierno Bolivariano del Estado Yaracuy ',0,1,'C');
		//$this->Cell(200,4,'Empresa Socialista Asfaltos Yaracuy,C.A.',0,1,'C');
		$this->SetFillColor(192,192,192);
		$this->SetFont('Arial','B',8);
		$this->Cell(25);
		$this->Cell(145,3,'',0,0,'L');
		$this->Cell(25,3,'NUMERO',1,0,'C',true);
		$this->Cell(5,3,'',0,1,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(25);
		$this->SetFont('Arial','B',10);	
		$this->Cell(145,4,'LIQUIDACION DE PRESTACIONES SOCIALES ',0,0,'C');
		$this->SetFont('Arial','',9);
		$this->Cell(25,4,$referencia,1,0,'C');
		$this->Cell(5,4,'',0,1,'L');		
		$this->SetFont('Arial','B',7);
		$this->Cell(25);
		
		$this->Cell(145,3,'',0,0,'L');
		$this->SetFont('Arial','B',8);
		$this->Cell(25,3,'FECHA',1,0,'C',true);
		$this->Cell(5,3,'',0,1,'L');
		$this->Cell(25);
		$this->SetFont('Arial','B',14);		
		$this->Cell(145,4,'',0,0,'C');
		$this->SetFont('Arial','',9);	   
		$this->Cell(25,4,$fecha_liquidacion,1,0,'C');
		$this->Cell(5,4,'',0,1,'L');
		$this->Ln(5);		
		$this->SetFont('Arial','B',8);
		$this->Cell(200,5,'DATOS DEL(A) TRABAJADOR(A)',1,1,'C',true);
		$this->Cell(115,4,'Apellidos y Nombre',1,0,'C',true);
		$this->Cell(25,4,'Cedula Identidad',1,0,'C',true);
		$this->Cell(30,4,'Fecha Ingreso',1,0,'C',true);
		$this->Cell(30,4,'Fecha Egreso',1,1,'C',true);
		$this->SetFont('Arial','',8);
		$this->Cell(115,5,$nombre,1,0,'C');
		$this->Cell(25,5,$cedula,1,0,'C');
		$this->Cell(30,5,$fecha_ingreso,1,0,'C');
		$this->Cell(30,5,$fecha_liquidacion,1,1,'C');
		$this->Cell(125,4,'Cargo',1,0,'C',true);
		$this->Cell(75,4,'Motivo Liquidacion',1,1,'C',true);
		$this->Cell(125,5,$des_cargo,1,0,'C');
		$this->Cell(75,5,$tipo_liquidacion,1,1,'C');
		$this->SetFont('Arial','B',8);
		$this->Cell(65,4,'Antiguedad',1,0,'C',true);
		$this->Cell(45,4,'Salario Basico',1,0,'C',true);
		$this->Cell(45,4,'Salario Promedio',1,0,'C',true);
		$this->Cell(45,4,'Salario Integral',1,1,'C',true);
		$this->SetFont('Arial','',9);
		$this->Cell(65,4," ".$ant_ano." Años  ".$ant_mes." Meses  ".$ant_dia."  Dias",1,0,'C');
		$this->Cell(45,4,$sueldo_basico,1,0,'C');
		$this->Cell(45,4,$sueldo_vacaciones,1,0,'C');
		$this->Cell(45,4,$sueldo_liquidacion,1,1,'C');
		$total_neto=formato_monto($total_neto);
		$this->Ln(4);
		$this->SetFont('Arial','',9);
        $texto1='He recibido de la GOBERNACION DEL ESTADO YARACUY,C.A. la cantidad de bolivares:'."   ".$monto_letras."  ( Bsf. ".$total_neto." ) . Por concepto de las Prestaciones de Antiguedad conforme a lo establecido en la  Ley  Orgánica  del  Trabajo, los trabajadores y las trabajadoras de  acuerdo a la siguiente discriminación:'";
	    $this->MultiCell(200,4,$texto1,0);
	    $this->Ln(5);
        $this->Cell(120,6,'Firma del Trabajador _______________________________________',0,0,'L');
        $this->Cell(80,6,'Cedula de Identidad _____________________',0,1,'L');
			
		$this->SetFont('Arial','B',8);
		$this->Cell(200,5,'ASIGNACIONES',1,1,'C',true);
		$this->Cell(10,3,'','RL',0,'C',true);
        $this->Cell(113,3,'','RL',0,'L',true);
		$this->Cell(32,3,'Periodos',1,0,'C',true);
		$this->Cell(12,3,'','RL',0,'C',true);
		$this->Cell(13,3,'Salario','RL',0,'R',true);
		$this->Cell(20,3,'','RL',1,'R',true);
		$this->Cell(10,4,'Nro.','RLB',0,'C',true);
        $this->Cell(113,4,'Descripcion de Conceptos','RLB',0,'L',true);
		$this->Cell(16,4,'Desde','RLB',0,'C',true);
		$this->Cell(16,4,'Hasta','RLB',0,'C',true);
		$this->Cell(12,4,'Dias','RLB',0,'C',true);
		$this->Cell(13,4,'Diario','RLB',0,'R',true);
		$this->Cell(20,4,'Monto','RLB',1,'R',true);
	}
	
	function Footer(){ global $monto_letras;  global $monto_letras_ban;
	  $this->SetY(-100);
	  $this->SetFillColor(192,192,192);
	   $this->Ln(4);
	  $this->SetFont('Arial','',8);
	  $this->Cell(200,6,$monto_letras_ban,'',1,'C');
	  $texto1='El  Fideicomiso de Prestaciones Sociales de Antigüedad de los trabajadores de la Empresa Socialista Asfaltos Yaracuy   C.A., esta depositado en  el Banco de Venezuela y serà liberado al trabajador, de acuerdo a los procedimientos establecidos por esa entidad bancaria; una vez que  presente la Declaraciòn Jurada de Patrimonio de Egreso ante la Contralorìa General de la Republica establecidos por  el  Banco de Venezuela.';
      $this->MultiCell(200,4,$texto1,0);
	  $this->Ln(10);
      $this->Cell(120,6,'Firma del Trabajador _______________________________________',0,0,'L');
      $this->Cell(80,6,'Cedula de Identidad _____________________',0,1,'L');
	  $this->Ln(8);
	  $this->SetFont('Arial','B',8);
		$this->Cell(200,4,' FIRMAS Y SELLOS',1,1,'C',true);		
		$this->SetFont('Arial','B',7);
		$this->Cell(50,4,'Elaborado Por',1,0,'C',true);
		$this->Cell(50,4,'Aprobado por',1,0,'C',true);
		$this->Cell(50,4,'Autorizado por',1,0,'C',true);
		$this->Cell(50,4,'Recibido conforme por el Trabajador',1,1,'C',true);		
        $this->Cell(50,33,'','LR',0,'C');
		$this->Cell(50,33,'','LR',0,'C');
		$this->Cell(50,33,'','LR',0,'C');
		$this->Cell(50,33,'','R',1,'C');		
			  
	} 
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',8);
  $pdf->SetAutoPageBreak(true, 100); 
  $pdf->SetFillColor(192,192,192);
  $sql="SELECT * FROM NOM036 where (cod_empleado='$cod_empleado') order by asig_ded_apo,tipo_asigna,cod_concepto";
  $res=pg_query($sql); $filas=pg_num_rows($res); $prev_conc=""; $prev_monto=0; $total=0; $totala=0; $totald=0; $na=0; $nd=0;
  while($registro=pg_fetch_array($res)){     $tmonto=$registro["monto"];
	$denominacion=$registro["den_concepto"]; $fecha_desde=$registro["fecha_desde"]; $fecha_hasta=$registro["fecha_hasta"];  $fecha_desde=formato_ddmmaaaa($fecha_desde);  $fecha_hasta=formato_ddmmaaaa($fecha_hasta); 
	$asig_ded_apo=$registro["asig_ded_apo"]; $asignacion=""; $deduccion=""; $cantidad=$registro["cantidad"]; $sueldo_dia=$registro["monto_base"];
    if(($letra=="B")and($registro["cod_concepto"]=="L01")){
	    if($tmonto==$temp_monto_art142){$tmonto=$temp_monto_ant_depositada;  $denominacion="Garantia de Prestaciones Sociales enviadas a Fidecomiso"; $cantidad=""; $sueldo_dia="";}
		 else{ $tmonto=$temp_monto_art142;  $denominacion="Calculo de Prestaciones Sociales. Art. 142 Lit C";  $cantidad=$temp_dias; $sueldo_dia=$temp_diario;  }    
	}
	if(($letra=="A")and($registro["cod_concepto"]=="L01")){
	    if($tmonto==$temp_monto_ant_depositada){ $denominacion="Garantia de Prestaciones Sociales enviadas a Fidecomiso"; $cantidad=$cantidad; $sueldo_dia="";}
	}
	$monto=formato_monto($tmonto); 
	if(($letra=="B")and($registro["cod_concepto"]=="L02")){ }
	else{
	if($asig_ded_apo=="A"){ $total=$total+$tmonto; $totala=$totala+$tmonto; $asignacion=$monto; $sueldo_dia=formato_monto($sueldo_dia); $na=$na+1; 
	  $pdf->SetFont('Arial','',8);
	  $pdf->Cell(10,5,$na,0,0,'C'); 
	  $pdf->Cell(113,5,$denominacion,'RL',0,'L'); 
	  $pdf->Cell(16,5,$fecha_desde,'RL',0,'C'); 
	  $pdf->Cell(16,5,$fecha_hasta,'RL',0,'C'); 
	  $pdf->Cell(12,5,$cantidad,'RL',0,'C'); 
	  $pdf->Cell(13,5,$sueldo_dia,'RL',0,'R'); 
	  $pdf->Cell(20,5,$asignacion,0,1,'R'); 
	} 
	if($asig_ded_apo=="D"){ $totald=$totald+$tmonto;  $cantidad=""; $sueldo_dia=""; $total=$total-$tmonto; $deduccion=$monto; $nd=$nd+1;  $totala=formato_monto($totala);
	  if($nd==1){$pdf->SetFont('Arial','B',8);   
      $pdf->Cell(180,5,'Total asignaciones Bs. ',1,0,'R');
      $pdf->Cell(20,5,$totala,1,1,'R');
	  $pdf->Cell(200,5,'DEDUCCIONES',1,1,'C',true);}
	  $pdf->SetFont('Arial','',8);
	  $pdf->Cell(10,5,$nd,0,0,'C'); 
	  $pdf->Cell(170,5,$denominacion,'RL',0,'L'); 
	  $pdf->Cell(20,5,$deduccion,0,1,'R'); 
	}
    }
  }
  $total=formato_monto($total); $totala=formato_monto($totala); $totald=formato_monto($totald);
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(180,5,'Total deducciones Bs. ',1,0,'R');
  $pdf->Cell(20,5,$totald,1,1,'R');
  $pdf->Ln(5);
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(180,6,'TOTAL A CANCELAR Bs. : ',1,0,'R');
  $pdf->Cell(20,6,$total,1,1,'R');
  $pdf->Cell(100,6,'',0,1,'R');; 
  $monto_letras=monto_letras($total);
  $pdf->Output();
  pg_close();
?>

<