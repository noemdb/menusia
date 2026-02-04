<?include "../../class/seguridad.inc";include "../../class/conects.php";include "../../class/fun_fechas.php";include "../../class/fun_numeros.php";include "../../class/configura.inc";
error_reporting(E_ALL ^ E_NOTICE);
$tipo_nomina_d = $_GET["tipo_nomina_d"];
$tipo_nomina_h = $_GET["tipo_nomina_h"];
$act_hist = $_GET["act_hist"];
$fecha_nom = $_GET["fecha_nom"];
$tipo_concepto = $_GET["tipo_concepto"];
$num_periodos = $_GET["num_periodos"];
$forma_pago = $_GET["forma_pago"];
$fecha_abono = $_GET["fecha_abono"];
$solo_r = $_GET["solo_r"];
$tipo_calculo = $_GET["tipo_calculo"];
$observacion = $_GET["observacion"];
$dep_p = $_GET["dep_p"];
$Sql = "";
$date = date("d-m-Y");
$hora = date("h:i:s a");
$cfechan = formato_aaaammdd($fecha_nom);
$tipo_rpt = $_GET["tipo_rpt"];
$tipo_monto = $_GET["tipo_monto"];
$php_os = PHP_OS;
$criterio = "rpt_nom_cal WHERE (oculto='NO') ";
$rpt_num = 1;
$criterio1 = "RELACION DE PAGOS";
$nom_rpt = "Rpt_rela_pago_rn_re.xml";
$orden = "ORDER BY tipo_nomina, cta_empresa, to_number(cedula,'999999999999'), cod_empleado, cod_concepto";

if ($act_hist == 'S') {$criterio = "rpt_nom_hist WHERE (fecha_p_hasta='" . $cfechan . "') and (oculto='NO') ";}
$ordenado = "ORDER BY tipo_nomina, to_number(cedula,'999999999999'), cod_empleado, cod_concepto";
if ($forma_pago == "CHEQUE") {$ordenado = "ORDER BY tipo_nomina, cedula, cod_empleado, cod_concepto";}
if ($forma_pago == "DEPOSITO") {
	$criterio1 = "RELACION DE BANCOS";
	$nom_rpt = "Rpt_rela_banco_rn_re.xml";
	$rpt_num = 2;
	$criterio = $criterio . " and tipo_pago='DEPOSITO'";
	$ordenado = "ORDER BY cta_empresa, to_number(cedula,'999999999999'), cod_empleado, cod_concepto";}
if ($forma_pago == "CHEQUE") {
	$criterio1 = "RELACION DE PAGOS (CHEQUE)";
	$criterio = $criterio . " and tipo_pago='CHEQUE'";}
if ($forma_pago == "EFECTIVO") {
	$criterio1 = "RELACION DE PAGOS (EFECTIVO)";
	$criterio = $criterio . " and tipo_pago='EFECTIVO'";}
if ($forma_pago == "RECIBO") {
	$criterio1 = "RELACION DE PAGOS (RECIBO)";
	$criterio = $criterio . " and tipo_pago='RECIBO'";}

if ($tipo_monto == "PRI") {$criterio1 = $criterio1 . " PRIMERA QUINCENA";}if ($tipo_monto == "SEG") {$criterio1 = $criterio1 . " SEGUNDA QUINCENA";}

if ($tipo_concepto == "NOMINA") {$criterio = $criterio . " and (concepto_vac='N') ";}
if ($tipo_concepto == "VACACIONES") {$criterio = $criterio . " and (concepto_vac='S') ";}

if ($solo_r == "SI") {
	$rpt_num = 4;
	$criterio1 = "RESUMEN " . $criterio1;}

$cri_tp = " and (tp_calculo='" . $tipo_calculo . "') ";
if ($tipo_calculo == "E") {$cri_tp = " and ((tp_calculo='E')and(num_periodos=$num_periodos))  ";}
$criterio = $criterio . $cri_tp . " and (tipo_nomina>='" . $tipo_nomina_d . "' and tipo_nomina<='" . $tipo_nomina_h . "') and (monto>0) ";

$conn = pg_connect("host=" . $host . " port=" . $port . " password=" . $password . " user=" . $user . " dbname=" . $dbname . "");
if (pg_ErrorMessage($conn)) {?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?} else {
	$Nom_Emp = busca_conf();if ($utf_rpt == "SI") {if ($php_os == "WINNT") {$php_os = "LINUX";} else { $php_os = "WINNT";}}
	$criterio3 = "NOMINA";

	if ($tipo_concepto == "VACACIONES") {$criterio3 = "NOMINA DE VACACIONES";} else {
		$sql = "SELECT tipo_nomina,descripcion,desc_grupo from nom001 where tipo_nomina='$tipo_nomina_d'";
		$res = pg_query($sql);if ($registro = pg_fetch_array($res, 0)) {if ($tipo_nomina_d != $tipo_nomina_h) {$criterio3 = $registro["desc_grupo"];} else { $criterio3 = "NOMINA : " . $registro["tipo_nomina"] . " " . $registro["descripcion"];}}}

	$Sql = "SELECT count(distinct cod_empleado) as cant_trab  FROM " . $criterio;
	$res = pg_query($Sql);
	$filas = pg_num_rows($res);if ($filas > 0) {
		$registro = pg_fetch_array($res, 0);
		$criterio2 = $registro["cant_trab"];}

	$sSQL = "SELECT *  FROM " . $criterio . $ordenado;

	if ($tipo_rpt == "HTML") {
		include "../../class/phpreports/PHPReportMaker.php";
		//echo $sSQL;
		$oRpt = new PHPReportMaker();
		$oRpt->setXML($nom_rpt);
		$oRpt->setUser("$user");
		$oRpt->setPassword("$password");
		$oRpt->setConnection("localhost");
		$oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
		$oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1" => $criterio1, "criterio2" => $criterio2, "criterio3" => $criterio3, "monto" => $monto, "date" => $date, "hora" => $hora));
		$oRpt->run();
		$aBench = $oRpt->getBenchmark();
	}
	if (($tipo_rpt == "PDF") and ($rpt_num == 1)) {
		$res = pg_query($sSQL);
		$cta_empresa_grupo = "";
		$cedula_grupo = "";
		$filas = pg_num_rows($res);
		$tipo_nomina = "";
		$des_nomina = "";
		$cod_empleado = "";
		$nombre_banco = "";
		$cta_empresa = "";
		$cedula = "";
		$nombre = "";
		if ($filas >= 1) {
			$registro = pg_fetch_array($res, 0);
			$tipo_nomina = $registro["tipo_nomina"];
			$des_nomina = $registro["des_nomina"];
			$fechad = $registro["fechapd"];
			$fechah = $registro["fechaph"];
			$nombre_banco = $registro["nombre_banco"];
			$cta_empresa = $registro["cta_empresa"];
			if ($php_os == "WINNT") {$des_nomina = $des_nomina;} else {
				$des_nomina = utf8_decode($des_nomina);
				$nombre_banco = utf8_decode($nombre_banco);}
		}
		require '../../class/fpdf/fpdf.php';
		class PDF extends FPDF {
			function Header() {
				global $criterio1;global $tipo_nomina;global $des_nomina;global $fechad;global $fechah;
				$this->Image('../../imagenes/Logo_emp.png', 7, 7, 20);
				$this->SetFont('Arial', 'B', 10);
				$this->Cell(50);
				$this->Cell(120, 7, $criterio1, 1, 0, 'C');
				$this->Ln(18);
				$this->SetFont('Arial', 'B', 8);
				$this->Cell(140, 5, "NOMINA : " . $tipo_nomina . " " . $des_nomina, 0, 1, 'L');
				$this->Cell(140, 5, "FECHA : " . $fechad . " AL " . $fechah, 0, 1, 'L');
				$this->Cell(20, 5, 'Cedula', 1, 0, 'L');
				$this->Cell(160, 5, 'Nombre', 1, 0, 'L');
				$this->Cell(20, 5, 'Monto', 1, 1, 'R');
			}
			function Footer() {
				$ffechar = date("d-m-Y");
				$fhorar = date("H:i:s a");
				$this->SetY(-10);
				$this->SetFont('Arial', 'I', 5);
				//$this->SetFont('Arial','B',8);
				$this->Cell(100, 5, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
				$this->Cell(100, 5, 'Fecha: ' . $ffechar . ' Hora: ' . $fhorar, 0, 0, 'R');
			}
		}
		$pdf = new PDF('P', 'mm', Letter);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial', '', 8);
		$i = 0;
		$cant_trab = 0;
		$total_monto = 0;
		$sub_total_monto = 0;
		$sub_total_monto1 = 0;
		$prev_cta_empresa = "";
		$prev_cedula = "";
		$prev_nombre = "";
		$prev_cta_empleado = "";
		$prev_tipo = "";
		//$pdf->MultiCell(200,3,$sSQL,0);
		while ($registro = pg_fetch_array($res)) {
			$i = $i + 1;
			$tipo_nomina = $registro["tipo_nomina"];
			$des_nomina = $registro["des_nomina"];
			$fechad = $registro["fechapd"];
			$cod_empleado = $registro["cod_empleado"];
			$fechah = $registro["fechaph"];
			$nombre_banco = $registro["nombre_banco"];
			$cta_empresa = $registro["cta_empresa"];
			$cedula = $registro["cedula"];
			$nombre = $registro["nombre"];
			$cta_empleado = $registro["cta_empleado"];
			$monto_asignacion = $registro["monto_asignacion"];
			$monto_deduccion = $registro["monto_deduccion"];
			if ($php_os == "WINNT") {$des_nomina = $des_nomina;} else {
				$des_nomina = utf8_decode($des_nomina);
				$nombre = $nombre;
				$nombre_banco = $nombre_banco;}
			$cta_empresa_grupo = $cta_empresa;
			$cedula_grupo = $cedula;
			$tipo_nomina_grupo = $tipo_nomina;
			$des_nomina_grupo = $des_nomina;
			$fechad_grupo = $fechad;
			$fechah_grupo = $fechah;
			$nombre_banco_grupo = $nombre_banco;
			$cta_empresa_grupo = $cta_empresa;
			$grupo_trab = $cedula;
			if (($prev_cedula != $cedula)) {
				if ($prev_cedula != "") {
					$sub_total_monto = formato_monto($sub_total_monto);
					$cant_trab = $cant_trab + 1;
					$pdf->SetFont('Arial', '', 8);
					$pdf->Cell(20, 3, $prev_cedula, 0, 0, 'L');
					$pdf->Cell(160, 3, $prev_nombre, 0, 0, 'L');
					$pdf->Cell(20, 3, $sub_total_monto, 0, 1, 'R');
				}
				$prev_cedula = $cedula;
				$prev_nombre = $nombre;
				$prev_cta_empleado = $cta_empleado;
				$sub_total_monto = 0;
				if ($prev_tipo != $tipo_nomina) {
					if ($prev_tipo != "") {
						$sub_total_monto1 = formato_monto($sub_total_monto1);
						$pdf->SetFont('Arial', 'B', 8);
						$pdf->Cell(180, 2, '', 0, 0);
						$pdf->Cell(20, 2, '-----------------', 0, 1, 'R');
						$pdf->Cell(100, 5, 'No. Trabajadores: ' . $cant_trab, 0, 0, 'L');
						$pdf->Cell(80, 5, 'TOTAL NOMINA ', 0, 0, 'R');
						$pdf->Cell(20, 5, $sub_total_monto1, 0, 1, 'R');
						$pdf->AddPage();
					}
					$sub_total_monto1 = 0;
					$prev_tipo = $tipo_nomina;
					$cant_trab = 0;
				}
			}
			$monto_asignacion = $registro["monto_asignacion"];
			$monto_deduccion = $registro["monto_deduccion"];
			$valorz = $registro["valorz"];
			$monto = $registro["monto"];
			$asig_ded_apo = $registro["asig_ded_apo"];
			if ($tipo_monto == "PRI") {
				$monto_asignacion = 0;
				$monto_deduccion = 0;if ($asig_ded_apo == "A") {$monto_asignacion = $valorz;}if ($asig_ded_apo == "D") {$monto_deduccion = $valorz;}}
			if ($tipo_monto == "SEG") {
				$monto_asignacion = 0;
				$monto_deduccion = 0;if ($asig_ded_apo == "A") {$monto_asignacion = $monto - $valorz;}if ($asig_ded_apo == "D") {$monto_deduccion = $monto - $valorz;}}
			$total_monto = $total_monto + $monto_asignacion - $monto_deduccion;
			$sub_total_monto = $sub_total_monto + $monto_asignacion - $monto_deduccion;
			$sub_total_monto1 = $sub_total_monto1 + $monto_asignacion - $monto_deduccion;
			$monto_asignacion = formato_monto($monto_asignacion);
			$monto_deduccion = formato_monto($monto_deduccion);
		}
		$total_monto = formato_monto($total_monto);
		$sub_total_monto1 = formato_monto($sub_total_monto1);
		$sub_total_monto = formato_monto($sub_total_monto);
		$pdf->SetFont('Arial', '', 8);
		$cant_trab = $cant_trab + 1;
		$pdf->Cell(20, 3, $prev_cedula, 0, 0, 'L');
		$pdf->Cell(160, 3, $prev_nombre, 0, 0, 'L');
		$pdf->Cell(20, 3, $sub_total_monto, 0, 1, 'R');
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(180, 2, '', 0, 0);
		$pdf->Cell(20, 2, '-----------------', 0, 1, 'R');
		$pdf->Cell(100, 5, 'No. Trabajadores: ' . $cant_trab, 0, 0, 'L');
		$pdf->Cell(80, 5, 'TOTAL NOMINA ', 0, 0, 'R');
		$pdf->Cell(20, 5, $sub_total_monto1, 0, 1, 'R');
		$pdf->Ln(6);
		$pdf->Cell(180, 2, '', 0, 0);
		$pdf->Cell(20, 2, '=============', 0, 1, 'R');
		$pdf->Cell(100, 5, 'No. Trabajadores: ' . $criterio2, 0, 0, 'L');
		$pdf->Cell(80, 5, 'TOTAL GENERAL ', 0, 0, 'R');
		$pdf->Cell(20, 5, $total_monto, 0, 1, 'R');

		$y = $pdf->GetY();
		$t = 10;
		if ($y > 230) {
			$t = 30;
			$pdf->Cell(5, 4, '', 0, 1);}
		$pdf->ln($t);
		$y = $pdf->GetY();
		if ($y < 235) {
			$t = 235 - $y;
			$pdf->ln($t);}
		$pdf->SetFont('Arial', '', 7);

		$pdf->Cell(45, 4, 'Elaborado', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Revisado por', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Aprobado por ', 'T', 1, 'C');
		$pdf->Cell(50, 3, 'Analista de Nomina', 0, 0, 'C'); //nmdb (20171121) Arendriz Chirinos
		$pdf->Cell(50, 3, 'Lcda. Soraya Muñoz', 0, 0, 'C'); //nmdb (20171121) Zuleima Rivas
		$pdf->Cell(50, 3, 'Lcdo. Jose Medina', 0, 0, 'C');

		if ($Cod_Emp == "02") {
			$y = $pdf->GetY();
			$t = 10;
			if ($y > 260) {
				$t = 30;
				$pdf->Cell(5, 4, '', 0, 1);}
			$pdf->ln($t);
			$y = $pdf->GetY();
			if ($y < 250) {
				$t = 250 - $y;
				$pdf->ln($t);}
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(45, 4, 'Elaborado', 'T', 0, 'C');
			$pdf->Cell(5, 4, '', 0, 0);
			$pdf->Cell(45, 4, 'Revisado por', 'T', 0, 'C');
			$pdf->Cell(5, 4, '', 0, 0);
			$pdf->Cell(45, 4, 'Conformado por', 'T', 0, 'C');
			$pdf->Cell(5, 4, '', 0, 0);
			$pdf->Cell(45, 4, 'Aprobado por Contralor(a)', 'T', 1, 'C');
			$pdf->Cell(50, 3, ' ', 0, 0, 'C');
			$pdf->Cell(50, 3, 'Dir. Recursos Humanos y Capacitacion', 0, 0, 'C');
			$pdf->Cell(50, 3, 'Dir. Administracion y Presupuesto', 0, 0, 'C');
			//$pdf->Cell(45,3,'Interventora de la CEBM',0,1,'C');
		}

		$pdf->Output();
	}
	if (($tipo_rpt == "PDF") and ($rpt_num == 2)) {
		$res = pg_query($sSQL);
		$cta_empresa_grupo = "";
		$cedula_grupo = "";
		$filas = pg_num_rows($res);
		$tipo_nomina = "";
		$des_nomina = "";
		$cod_empleado = "";
		$nombre_banco = "";
		$cta_empresa = "";
		$cedula = "";
		$nombre = "";
		if ($filas >= 1) {
			$registro = pg_fetch_array($res, 0);
			$tipo_nomina = $registro["tipo_nomina"];
			$des_nomina = $registro["des_nomina"];
			$cod_empleado = $registro["cod_empleado"];
			$fechad = $registro["fechapd"];
			$fechah = $registro["fechaph"];
			$nombre_banco = $registro["nombre_banco"];
			$cta_empresa = $registro["cta_empresa"];
			if ($php_os == "WINNT") {$des_nomina = $des_nomina;} else {
				$des_nomina = utf8_decode($des_nomina);
				$nombre_banco = utf8_decode($nombre_banco);}}
		require '../../class/fpdf/fpdf.php';
		class PDF extends FPDF {
			function Header() {
				global $criterio1;global $criterio3;global $tipo_nomina;global $des_nomina;global $fechad;global $fechah;global $nombre_banco;global $cta_empresa;
				$this->Image('../../imagenes/Logo_emp.png', 7, 7, 20);
				$this->SetFont('Arial', 'B', 10);
				$this->Cell(50);
				$this->Cell(120, 7, $criterio1, 1, 0, 'C');
				$this->Ln(18);
				$this->SetFont('Arial', 'B', 8);
				$this->Cell(140, 5, $criterio3, 0, 1, 'L');
				$this->Cell(140, 5, "FECHA : " . $fechad . " AL " . $fechah, 0, 1, 'L');
				$this->Cell(200, 5, "BANCO : " . $nombre_banco . " CUENTA " . $cta_empresa, 0, 1, 'L');
				$this->Cell(20, 5, 'Cedula', 1, 0, 'L');
				$this->Cell(120, 5, 'Nombre', 1, 0, 'L');
				$this->Cell(40, 5, 'Numero Cuenta', 1, 0, 'L');
				$this->Cell(20, 5, 'Monto', 1, 1, 'R');
			}
			function Footer() {
				$ffechar = date("d-m-Y");
				$fhorar = date("H:i:s a");
				$this->SetY(-10);
				$this->SetFont('Arial', 'I', 5);
				//$this->SetFont('Arial','B',8);
				$this->Cell(100, 5, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
				//$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		}
		$pdf = new PDF('P', 'mm', Letter);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial', '', 8);
		$i = 0;
		$cant_trab = 0;
		$gcant_trab = 0;
		$total_monto = 0;
		$sub_total_monto = 0;
		$sub_total_monto1 = 0;
		$prev_cta_empresa = "";
		$prev_cedula = "";
		$prev_grupo = "";
		$prev_nombre = "";
		$prev_cta_empleado = "";
		$prev_tipo = "";
		$prev_empresa_grupo = "";
		while ($registro = pg_fetch_array($res)) {
			$i = $i + 1;
			$tipo_nomina = $registro["tipo_nomina"];
			$des_nomina = $registro["des_nomina"];
			$fechad = $registro["fechapd"];
			$cod_empleado = $registro["cod_empleado"];
			$fechah = $registro["fechaph"];
			$nombre_banco = $registro["nombre_banco"];
			$cta_empresa = $registro["cta_empresa"];
			$cedula = $registro["cedula"];
			$nombre = $registro["nombre"];
			$cta_empleado = $registro["cta_empleado"];
			$monto_asignacion = $registro["monto_asignacion"];
			$monto_deduccion = $registro["monto_deduccion"];
			if ($php_os == "WINNT") {$des_nomina = $des_nomina;} else {
				$des_nomina = utf8_decode($des_nomina);
				$nombre = utf8_decode($nombre);
				$nombre_banco = utf8_decode($nombre_banco);}
			$cta_empresa_grupo = $cta_empresa;
			$cedula_grupo = $cedula;
			$tipo_nomina_grupo = $tipo_nomina;
			$des_nomina_grupo = $des_nomina;
			$fechad_grupo = $fechad;
			$fechah_grupo = $fechah;
			$nombre_banco_grupo = $nombre_banco;
			$grupo_trab = $cedula . $cod_empleado;
			//if(($prev_cedula<>$cedula) or ($prev_empresa_grupo<>$cta_empresa)){
			if (($prev_grupo != $grupo_trab) or ($prev_empresa_grupo != $cta_empresa)) {
				if ($prev_cedula != "") {
					$sub_total_monto = formato_monto($sub_total_monto);
					$cant_trab = $cant_trab + 1;
					$gcant_trab = $gcant_trab + 1;
					$pdf->SetFont('Arial', '', 8);
					$pdf->Cell(20, 4, $prev_cedula, 0, 0, 'L');
					$pdf->Cell(120, 4, $prev_nombre, 0, 0, 'L');
					$pdf->Cell(40, 4, $prev_cta_empleado, 0, 0, 'L');
					$pdf->Cell(20, 4, $sub_total_monto, 0, 1, 'R');
				}
				$prev_cedula = $cedula;
				$prev_grupo = $grupo_trab;
				$prev_nombre = $nombre;
				$sub_total_monto = 0;
				$prev_cta_empleado = $cta_empleado;
				if ($prev_empresa_grupo != $cta_empresa) {
					if (($prev_empresa_grupo != "") or ($cant_trab >= 1)) {
						$sub_total_monto1 = formato_monto($sub_total_monto1);
						$pdf->SetFont('Arial', 'B', 8);
						$pdf->Cell(180, 2, '', 0, 0);
						$pdf->Cell(20, 2, '-----------------', 0, 1, 'R');
						$pdf->Cell(100, 5, 'No. Trabajadores: ' . $cant_trab, 0, 0, 'L');
						$pdf->Cell(80, 5, 'TOTAL CUENTA ' . $prev_empresa_grupo . ' ', 0, 0, 'R');
						$pdf->Cell(20, 5, $sub_total_monto1, 0, 1, 'R');
						$pdf->AddPage();
					}
					$sub_total_monto1 = 0;
					$prev_tipo = $tipo_nomina;
					$prev_empresa_grupo = $cta_empresa;
					$cant_trab = 0;
				}
			}
			$monto_asignacion = $registro["monto_asignacion"];
			$monto_deduccion = $registro["monto_deduccion"];
			$valorz = $registro["valorz"];
			$monto = $registro["monto"];
			$asig_ded_apo = $registro["asig_ded_apo"];
			if ($tipo_monto == "PRI") {
				$monto_asignacion = 0;
				$monto_deduccion = 0;if ($asig_ded_apo == "A") {$monto_asignacion = $valorz;}if ($asig_ded_apo == "D") {$monto_deduccion = $valorz;}}
			if ($tipo_monto == "SEG") {
				$monto_asignacion = 0;
				$monto_deduccion = 0;if ($asig_ded_apo == "A") {$monto_asignacion = $monto - $valorz;}if ($asig_ded_apo == "D") {$monto_deduccion = $monto - $valorz;}}
			$total_monto = $total_monto + $monto_asignacion - $monto_deduccion;
			$sub_total_monto = $sub_total_monto + $monto_asignacion - $monto_deduccion;
			$sub_total_monto1 = $sub_total_monto1 + $monto_asignacion - $monto_deduccion;
			$monto_asignacion = formato_monto($monto_asignacion);
			$monto_deduccion = formato_monto($monto_deduccion);
		}
		$total_monto = formato_monto($total_monto);
		$sub_total_monto1 = formato_monto($sub_total_monto1);
		$sub_total_monto = formato_monto($sub_total_monto);
		$pdf->SetFont('Arial', '', 8);
		$cant_trab = $cant_trab + 1;
		$gcant_trab = $gcant_trab + 1;
		$pdf->Cell(20, 4, $prev_cedula, 0, 0, 'L');
		$pdf->Cell(120, 4, $prev_nombre, 0, 0, 'L');
		$pdf->Cell(40, 4, $prev_cta_empleado, 0, 0, 'L');
		$pdf->Cell(20, 4, $sub_total_monto, 0, 1, 'R');

		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(180, 2, '', 0, 0);
		$pdf->Cell(20, 2, '-----------------', 0, 1, 'R');
		$pdf->Cell(100, 5, 'No. Trabajadores: ' . $cant_trab, 0, 0, 'L');
		$pdf->Cell(80, 5, 'TOTAL CUENTA ' . $prev_empresa_grupo . ' ', 0, 0, 'R');
		$pdf->Cell(20, 5, $sub_total_monto1, 0, 1, 'R');
		$pdf->Ln(5);
		$pdf->Cell(180, 2, '', 0, 0);
		$pdf->Cell(20, 2, '=============', 0, 1, 'R');
		$pdf->Cell(100, 5, 'No. Trabajadores: ' . $gcant_trab, 0, 0, 'L');
		$pdf->Cell(80, 5, 'TOTAL GENERAL ', 0, 0, 'R');
		$pdf->Cell(20, 5, $total_monto, 0, 1, 'R');
		$y = $pdf->GetY();
		$t = 10;
		if ($y > 230) {
			$t = 30;
			$pdf->Cell(5, 4, '', 0, 1);}
		$pdf->ln($t);
		$y = $pdf->GetY();
		if ($y < 235) {
			$t = 235 - $y;
			$pdf->ln($t);}
		$pdf->SetFont('Arial', '', 7);

		$pdf->Cell(45, 4, 'Elaborado', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Revisado por', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Aprobado por ', 'T', 1, 'C');
		$pdf->Cell(50, 3, 'Analista de Nomina', 0, 0, 'C'); //nmdb (20171121) Arendriz Chirinos
		$pdf->Cell(50, 3, 'Lcda. Soraya Muñoz', 0, 0, 'C'); //nmdb (20171121) Zuleima Rivas
		$pdf->Cell(50, 3, 'Lcdo. Jose Medina', 0, 0, 'C');

		if ($Cod_Emp == "02") {
			$y = $pdf->GetY();
			$t = 10;
			if ($y > 260) {
				$t = 30;
				$pdf->Cell(5, 4, '', 0, 1);}
			$pdf->ln($t);
			$y = $pdf->GetY();
			if ($y < 250) {
				$t = 250 - $y;
				$pdf->ln($t);}
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(45, 4, 'Elaborado', 'T', 0, 'C');
			$pdf->Cell(5, 4, '', 0, 0);
			$pdf->Cell(45, 4, 'Revisado por', 'T', 0, 'C');
			$pdf->Cell(5, 4, '', 0, 0);
			$pdf->Cell(45, 4, 'Conformado por', 'T', 0, 'C');
			$pdf->Cell(5, 4, '', 0, 0);
			$pdf->Cell(45, 4, 'Aprobado por Contralor(a)', 'T', 1, 'C');
			$pdf->Cell(50, 3, ' ', 0, 0, 'C');
			$pdf->Cell(50, 3, 'Dir. Recursos Humanos y Capacitacion', 0, 0, 'C');
			$pdf->Cell(50, 3, 'Dir. Administracion y Presupuesto', 0, 0, 'C');
			$pdf->Cell(45, 3, 'Interventora de la CEBM', 0, 1, 'C');
		}
		$pdf->Output();
	}
	if (($tipo_rpt == "PDF") and ($rpt_num == 3)) {
		$res = pg_query($sSQL);
		$cta_empresa_grupo = "";
		$cedula_grupo = "";
		$filas = pg_num_rows($res);
		$tipo_nomina = "";
		$des_nomina = "";
		$cod_empleado = "";
		$nombre_banco = "";
		$cta_empresa = "";
		$cedula = "";
		$nombre = "";
		if ($filas >= 1) {
			$registro = pg_fetch_array($res, 0);
			$tipo_nomina = $registro["tipo_nomina"];
			$des_nomina = $registro["des_nomina"];
			$fechad = $registro["fechapd"];
			$fechah = $registro["fechaph"];
			$nombre_banco = $registro["nombre_banco"];
			$cta_empresa = $registro["cta_empresa"];
			if ($php_os == "WINNT") {$des_nomina = $des_nomina;} else {
				$des_nomina = utf8_decode($des_nomina);
				$nombre_banco = utf8_decode($nombre_banco);}}
		require '../../class/fpdf/fpdf.php';
		class PDF extends FPDF {
			function Header() {
				global $criterio1;global $tipo_nomina;global $des_nomina;global $fechad;global $fechah;
				$this->Image('../../imagenes/Logo_emp.png', 7, 7, 20);
				$this->SetFont('Arial', 'B', 10);
				$this->Cell(50);
				$this->Cell(120, 7, $criterio1, 1, 0, 'C');
				$this->Ln(18);
				$this->SetFont('Arial', 'B', 8);
				$this->Cell(140, 5, "A LA FECHA : " . $fechah, 0, 1, 'L');
				$this->Cell(40, 5, 'Numero Cuenta', 1, 0, 'L');
				$this->Cell(20, 5, 'Cedula', 1, 0, 'L');
				$this->Cell(120, 5, 'Nombre', 1, 0, 'L');
				$this->Cell(20, 5, 'Monto', 1, 1, 'R');
			}
			function Footer() {
				$ffechar = date("d-m-Y");
				$fhorar = date("H:i:s a");
				$this->SetY(-10);
				$this->SetFont('Arial', 'I', 5);
				//$this->SetFont('Arial','B',8);
				$this->Cell(100, 5, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
				$this->Cell(100, 5, 'Fecha: ' . $ffechar . ' Hora: ' . $fhorar, 0, 0, 'R');
			}
		}
		$pdf = new PDF('P', 'mm', Letter);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial', '', 8);
		$i = 0;
		$cant_trab = 0;
		$total_monto = 0;
		$sub_total_monto = 0;
		$sub_total_monto1 = 0;
		$prev_cta_empresa = "";
		$prev_cedula = "";
		$prev_nombre = "";
		$prev_cta_empleado = "";
		$prev_tipo = "";
		while ($registro = pg_fetch_array($res)) {
			$i = $i + 1;
			$tipo_nomina = $registro["tipo_nomina"];
			$des_nomina = $registro["des_nomina"];
			$fechad = $registro["fechapd"];
			$fechah = $registro["fechaph"];
			$nombre_banco = $registro["nombre_banco"];
			$cta_empresa = $registro["cta_empresa"];
			$cedula = $registro["cedula"];
			$nombre = $registro["nombre"];
			$cta_empleado = $registro["cta_empleado"];
			$monto_asignacion = $registro["monto_asignacion"];
			$monto_deduccion = $registro["monto_deduccion"];
			if ($php_os == "WINNT") {$des_nomina = $des_nomina;} else {
				$des_nomina = utf8_decode($des_nomina);
				$nombre = utf8_decode($nombre);
				$nombre_banco = utf8_decode($nombre_banco);}
			$cta_empresa_grupo = $cta_empresa;
			$cedula_grupo = $cedula;
			$tipo_nomina_grupo = $tipo_nomina;
			$des_nomina_grupo = $des_nomina;
			$fechad_grupo = $fechad;
			$fechah_grupo = $fechah;
			$nombre_banco_grupo = $nombre_banco;
			$cta_empresa_grupo = $cta_empresa;
			if (($prev_cedula != $cedula)) {
				if ($prev_cedula != "") {
					$sub_total_monto = formato_monto($sub_total_monto);
					$cant_trab = $cant_trab + 1;
					$pdf->SetFont('Arial', '', 8);
					$pdf->Cell(40, 3, $prev_cta_empleado, 0, 0, 'L');
					$pdf->Cell(20, 3, $prev_cedula, 0, 0, 'L');
					$pdf->Cell(120, 3, $prev_nombre, 0, 0, 'L');
					$pdf->Cell(20, 3, $sub_total_monto, 0, 1, 'R');
				}
				$prev_cedula = $cedula;
				$prev_nombre = $nombre;
				$prev_cta_empleado = $cta_empleado;
				$sub_total_monto = 0;
			}
			$monto_asignacion = $registro["monto_asignacion"];
			$monto_deduccion = $registro["monto_deduccion"];
			$valorz = $registro["valorz"];
			$monto = $registro["monto"];
			$asig_ded_apo = $registro["asig_ded_apo"];
			if ($tipo_monto == "PRI") {
				$monto_asignacion = 0;
				$monto_deduccion = 0;if ($asig_ded_apo == "A") {$monto_asignacion = $valorz;}if ($asig_ded_apo == "D") {$monto_deduccion = $valorz;}}
			if ($tipo_monto == "SEG") {
				$monto_asignacion = 0;
				$monto_deduccion = 0;if ($asig_ded_apo == "A") {$monto_asignacion = $monto - $valorz;}if ($asig_ded_apo == "D") {$monto_deduccion = $monto - $valorz;}}
			$total_monto = $total_monto + $monto_asignacion - $monto_deduccion;
			$sub_total_monto = $sub_total_monto + $monto_asignacion - $monto_deduccion;
			$sub_total_monto1 = $sub_total_monto1 + $monto_asignacion - $monto_deduccion;
			$monto_asignacion = formato_monto($monto_asignacion);
			$monto_deduccion = formato_monto($monto_deduccion);
		}
		$total_monto = formato_monto($total_monto);
		$sub_total_monto1 = formato_monto($sub_total_monto1);
		$sub_total_monto = formato_monto($sub_total_monto);
		$pdf->SetFont('Arial', '', 8);
		$cant_trab = $cant_trab + 1;
		$pdf->Cell(40, 3, $prev_cta_empleado, 0, 0, 'L');
		$pdf->Cell(20, 3, $prev_cedula, 0, 0, 'L');
		$pdf->Cell(120, 3, $prev_nombre, 0, 0, 'L');
		$pdf->Cell(20, 3, $sub_total_monto, 0, 1, 'R');
		$pdf->Ln(3);
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(180, 2, '', 0, 0);
		$pdf->Cell(20, 2, '=============', 0, 1, 'R');
		$pdf->Cell(100, 5, 'No. Trabajadores: ' . $cant_trab, 0, 0, 'L');
		$pdf->Cell(80, 5, 'TOTAL GENERAL ', 0, 0, 'R');
		$pdf->Cell(20, 5, $total_monto, 0, 1, 'R');

		$y = $pdf->GetY();
		$t = 10;
		if ($y > 230) {
			$t = 30;
			$pdf->Cell(5, 4, '', 0, 1);}
		$pdf->ln($t);
		$y = $pdf->GetY();
		if ($y < 235) {
			$t = 235 - $y;
			$pdf->ln($t);}
		$pdf->SetFont('Arial', '', 7);

		$pdf->Cell(45, 4, 'Elaborado', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Revisado por', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Aprobado por ', 'T', 1, 'C');
		$pdf->Cell(50, 3, 'Analista de Nomina', 0, 0, 'C'); //nmdb (20171121) Arendriz Chirinos
		$pdf->Cell(50, 3, 'Lcda. Soraya Muñoz', 0, 0, 'C'); //nmdb (20171121) Zuleima Rivas
		$pdf->Cell(50, 3, 'Lcdo. Jose Medina', 0, 0, 'C');

		if ($Cod_Emp == "02") {
			$y = $pdf->GetY();
			$t = 10;
			if ($y > 260) {
				$t = 30;
				$pdf->Cell(5, 4, '', 0, 1);}
			$pdf->ln($t);
			$y = $pdf->GetY();
			if ($y < 250) {
				$t = 250 - $y;
				$pdf->ln($t);}
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(45, 4, 'Elaborado', 'T', 0, 'C');
			$pdf->Cell(5, 4, '', 0, 0);
			$pdf->Cell(45, 4, 'Revisado por', 'T', 0, 'C');
			$pdf->Cell(5, 4, '', 0, 0);
			$pdf->Cell(45, 4, 'Conformado por', 'T', 0, 'C');
			$pdf->Cell(5, 4, '', 0, 0);
			$pdf->Cell(45, 4, 'Aprobado por Contralor(a)', 'T', 1, 'C');
			$pdf->Cell(50, 3, ' ', 0, 0, 'C');
			$pdf->Cell(50, 3, 'Dir. Recursos Humanos y Capacitacion', 0, 0, 'C');
			$pdf->Cell(50, 3, 'Dir. Administracion y Presupuesto', 0, 0, 'C');
			//$pdf->Cell(45,3,'Interventora de la CEBM',0,1,'C');
		}
		$pdf->Output();
	}

	if (($tipo_rpt == "PDF") and ($rpt_num == 4)) {
		$res = pg_query($sSQL);
		$cta_empresa_grupo = "";
		$cedula_grupo = "";
		$filas = pg_num_rows($res);
		$tipo_nomina = "";
		$des_nomina = "";
		$cod_empleado = "";
		$nombre_banco = "";
		$cta_empresa = "";
		$cedula = "";
		$nombre = "";
		if ($filas >= 1) {
			$registro = pg_fetch_array($res, 0);
			$tipo_nomina = $registro["tipo_nomina"];
			$des_nomina = $registro["des_nomina"];
			$cod_empleado = $registro["cod_empleado"];
			$fechad = $registro["fechapd"];
			$fechah = $registro["fechaph"];
			$nombre_banco = $registro["nombre_banco"];
			$cta_empresa = $registro["cta_empresa"];
			if ($php_os == "WINNT") {$des_nomina = $des_nomina;} else {
				$des_nomina = utf8_decode($des_nomina);
				$nombre_banco = utf8_decode($nombre_banco);}}
		require '../../class/fpdf/fpdf.php';
		class PDF extends FPDF {
			function Header() {
				global $criterio1;global $criterio3;global $tipo_nomina;global $des_nomina;global $fechad;global $fechah;global $nombre_banco;global $cta_empresa;
				$this->Image('../../imagenes/Logo_emp.png', 7, 7, 20);
				$this->Ln(10);
				$this->SetFont('Arial', 'B', 11);
				$this->Cell(50);
				$this->Cell(120, 7, $criterio1, 1, 0, 'C');
				$this->Ln(18);
				$this->SetFont('Arial', 'B', 10);
				$this->Cell(140, 5, $criterio3, 0, 1, 'L');
				$this->Cell(140, 5, "FECHA : " . $fechad . " AL " . $fechah, 0, 1, 'L');
				$this->Cell(200, 5, "BANCO : " . $nombre_banco . " CUENTA " . $cta_empresa, 0, 1, 'L');
				$this->Ln(5);
			}
			function Footer() {
				$ffechar = date("d-m-Y");
				$fhorar = date("H:i:s a");
				$this->SetY(-10);
				$this->SetFont('Arial', 'I', 5);
				//$this->SetFont('Arial','B',8);
				$this->Cell(100, 5, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
				//$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		}
		$pdf = new PDF('P', 'mm', Letter);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial', '', 8);
		$i = 0;
		$cant_trab = 0;
		$gcant_trab = 0;
		$total_monto = 0;
		$sub_total_monto = 0;
		$sub_total_monto1 = 0;
		$prev_cta_empresa = "";
		$prev_cedula = "";
		$prev_grupo = "";
		$prev_nombre = "";
		$prev_cta_empleado = "";
		$prev_tipo = "";
		$prev_empresa_grupo = "";
		while ($registro = pg_fetch_array($res)) {
			$i = $i + 1;
			$tipo_nomina = $registro["tipo_nomina"];
			$des_nomina = $registro["des_nomina"];
			$fechad = $registro["fechapd"];
			$cod_empleado = $registro["cod_empleado"];
			$fechah = $registro["fechaph"];
			$nombre_banco = $registro["nombre_banco"];
			$cta_empresa = $registro["cta_empresa"];
			$cedula = $registro["cedula"];
			$nombre = $registro["nombre"];
			$cta_empleado = $registro["cta_empleado"];
			$monto_asignacion = $registro["monto_asignacion"];
			$monto_deduccion = $registro["monto_deduccion"];
			if ($php_os == "WINNT") {$des_nomina = $des_nomina;} else {
				$des_nomina = utf8_decode($des_nomina);
				$nombre = utf8_decode($nombre);
				$nombre_banco = utf8_decode($nombre_banco);}
			$cta_empresa_grupo = $cta_empresa;
			$cedula_grupo = $cedula;
			$tipo_nomina_grupo = $tipo_nomina;
			$des_nomina_grupo = $des_nomina;
			$fechad_grupo = $fechad;
			$fechah_grupo = $fechah;
			$nombre_banco_grupo = $nombre_banco;
			$grupo_trab = $cedula . $cod_empleado;
			//if(($prev_cedula<>$cedula) or ($prev_empresa_grupo<>$cta_empresa)){
			if (($prev_grupo != $grupo_trab) or ($prev_empresa_grupo != $cta_empresa)) {
				if ($prev_cedula != "") {
					$sub_total_monto = formato_monto($sub_total_monto);
					$cant_trab = $cant_trab + 1;
					$gcant_trab = $gcant_trab + 1;

				}
				$prev_cedula = $cedula;
				$prev_grupo = $grupo_trab;
				$prev_nombre = $nombre;
				$sub_total_monto = 0;
				$prev_cta_empleado = $cta_empleado;
				if ($prev_empresa_grupo != $cta_empresa) {
					if (($prev_empresa_grupo != "") or ($cant_trab >= 1)) {
						$sub_total_monto1 = formato_monto($sub_total_monto1);
						$pdf->SetFont('Arial', '', 10);
						$pdf->Ln(5);
						$pdf->Cell(180, 5, 'DISCO PARA EL BANCO', 0, 1);
						$pdf->Ln(5);
						$pdf->Cell(60, 5, 'TOTAL de REGISTRO : ' . $cant_trab, 0, 0, 'L');
						$pdf->Cell(80, 5, 'TOTAL MONTO BS. : ', 0, 0, 'R');
						$pdf->Cell(20, 5, $sub_total_monto1, 0, 1, 'R');
						$pdf->AddPage();
					}
					$sub_total_monto1 = 0;
					$prev_tipo = $tipo_nomina;
					$prev_empresa_grupo = $cta_empresa;
					$cant_trab = 0;
				}
			}
			$monto_asignacion = $registro["monto_asignacion"];
			$monto_deduccion = $registro["monto_deduccion"];
			$valorz = $registro["valorz"];
			$monto = $registro["monto"];
			$asig_ded_apo = $registro["asig_ded_apo"];
			if ($tipo_monto == "PRI") {
				$monto_asignacion = 0;
				$monto_deduccion = 0;if ($asig_ded_apo == "A") {$monto_asignacion = $valorz;}if ($asig_ded_apo == "D") {$monto_deduccion = $valorz;}}
			if ($tipo_monto == "SEG") {
				$monto_asignacion = 0;
				$monto_deduccion = 0;if ($asig_ded_apo == "A") {$monto_asignacion = $monto - $valorz;}if ($asig_ded_apo == "D") {$monto_deduccion = $monto - $valorz;}}
			$total_monto = $total_monto + $monto_asignacion - $monto_deduccion;
			$sub_total_monto = $sub_total_monto + $monto_asignacion - $monto_deduccion;
			$sub_total_monto1 = $sub_total_monto1 + $monto_asignacion - $monto_deduccion;
			$monto_asignacion = formato_monto($monto_asignacion);
			$monto_deduccion = formato_monto($monto_deduccion);
		}
		$total_monto = formato_monto($total_monto);
		$sub_total_monto1 = formato_monto($sub_total_monto1);
		$sub_total_monto = formato_monto($sub_total_monto);
		$pdf->SetFont('Arial', '', 8);
		$cant_trab = $cant_trab + 1;
		$gcant_trab = $gcant_trab + 1;

		$pdf->SetFont('Arial', '', 10);
		$pdf->Ln(5);
		$pdf->Cell(180, 5, 'DISCO PARA EL BANCO', 0, 1);
		$pdf->Ln(5);
		$pdf->Cell(60, 5, 'TOTAL de REGISTRO : ' . $cant_trab, 0, 0, 'L');
		$pdf->Cell(80, 5, 'TOTAL MONTO BS. : ', 0, 0, 'R');
		$pdf->Cell(20, 5, $sub_total_monto1, 0, 1, 'R');
		$y = $pdf->GetY();
		$t = 10;
		if ($y > 230) {
			$t = 30;
			$pdf->Cell(5, 4, '', 0, 1);}
		$pdf->ln($t);
		$y = $pdf->GetY();
		if ($y < 235) {
			$t = 235 - $y;
			$pdf->ln($t);}
		$pdf->SetFont('Arial', '', 7);

		$pdf->Cell(45, 4, 'Elaborado', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Revisado por', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Aprobado por ', 'T', 1, 'C');
		/*INI modificación (30-10-2017): Elaborado: (T.S.U Arendriz Chirinos), Revisado (Lcda. Zuleima Rivaz): nmdb */
		$pdf->Cell(50, 3, 'Analista de Nomina', 0, 0, 'C');
		$pdf->Cell(50, 3, 'Lcda. Soraya Muñoz', 0, 0, 'C');
		/*FIN modificación (30-10-2017): Elaborado: (T.S.U Arendriz Chirinos), Revisado (Lcda. Zuleima Rivaz): nmdb */
		$pdf->Cell(50, 3, 'Lcdo. Jose Medina', 0, 0, 'C');

		if ($Cod_Emp == "02") {
			$y = $pdf->GetY();
			$t = 10;
			if ($y > 240) {
				$t = 30;
				$pdf->Cell(5, 4, '', 0, 1);}
			$pdf->ln($t);
			$y = $pdf->GetY();
			if ($y < 240) {
				$t = 240 - $y;
				$pdf->ln($t);}
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(45, 4, 'Elaborado', 'T', 0, 'C');
			$pdf->Cell(5, 4, '', 0, 0);
			$pdf->Cell(45, 4, 'Revisado por', 'T', 0, 'C');
			$pdf->Cell(5, 4, '', 0, 0);
			$pdf->Cell(45, 4, 'Conformado por ', 'T', 0, 'C');
			$pdf->Cell(5, 4, '', 0, 0);
			$pdf->Cell(45, 4, 'Aprobado por Contralor(a)', 'T', 1, 'C');
			$pdf->Cell(50, 3, ' ', 0, 0, 'C');
			$pdf->Cell(50, 3, 'Dir. Recursos Humanos y Capacitacion', 0, 0, 'C');
			$pdf->Cell(50, 3, 'Dir. Administracion y Presupuesto', 0, 0, 'C');
			// $pdf->Cell(45,3,'Interventora de la CEBM',0,1,'C');
		}
		$pdf->Output();
	}
}
?>
