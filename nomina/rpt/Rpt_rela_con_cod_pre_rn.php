<?include "../../class/seguridad.inc";include "../../class/conects.php";include "../../class/fun_fechas.php";include "../../class/fun_numeros.php";include "../../class/configura.inc";
error_reporting(E_ALL ^ E_NOTICE);include "../../class/phpreports/PHPReportMaker.php";
$tipo_nomina_d = $_GET["tipo_nomina_d"];
$tipo_nomina_h = $_GET["tipo_nomina_h"];
$cod_conceptod = $_GET["cod_conceptod"];
$cod_conceptoh = $_GET["cod_conceptoh"];
$act_hist = $_GET["act_hist"];
$fecha_nom = $_GET["fecha_nom"];
$forma_pago = $_GET["forma_pago"];
$cod_presup_d = $_GET["cod_presup_d"];
$cod_presup_h = $_GET["cod_presup_h"];
$tipo_concepto = $_GET["tipo_concepto"];
$num_periodos = $_GET["num_periodos"];
$estatus_trab_d = $_GET["estatus_trab_d"];
$tipo_calculo = $_GET["tipo_calculo"];
$detalle_concepto = $_GET["detalle_concepto"];
$detalle_trabajador = $_GET["detalle_trabajador"];
$detalle_aporte = $_GET["detalle_aporte"];
$tipo_rpt = $_GET["tipo_rpt"];
$php_os = PHP_OS;
$rango_f = $_GET["rango_f"];
$fecha_desde = $_GET["fecha_desde"];
$fecha_hasta = $_GET["fecha_hasta"];
$cfechad = formato_aaaammdd($fecha_desde);
$cfechah = formato_aaaammdd($fecha_hasta);
$Sql = "";
$date = date("d-m-Y");
$hora = date("h:i:s a");
$cfechan = formato_aaaammdd($fecha_nom);
$criterio2 = "Nomina";
$criterio3 = "FECHA AL " . $fecha_nom;
$criterio = "rpt_nom_cal WHERE (oculto='NO') and (cod_concepto<>'VVV')  ";
$num_rpt = 1;
if ($act_hist == 'S') {$criterio = "rpt_nom_hist WHERE (fecha_p_hasta='" . $cfechan . "') and (oculto='NO') and (cod_concepto<>'VVV')";}
if ($rango_f == 'S') {
	$mes_comp = 'S';
	$criterio = "rpt_nom_hist WHERE (fecha_p_hasta>='" . $cfechad . "') and (fecha_p_hasta<='" . $cfechah . "') and (oculto='NO')  and (cod_concepto<>'VVV') ";
	$criterio3 = "FECHA: " . $fecha_desde . " AL " . $fecha_hasta;}
if ($estatus_trab_d == 'TODOS') {$status = "";} else { $status . " and (status_emp='" . $estatus_trab_d . "') ";}
if ($tipo_concepto == "NOMINA") {$status = $status . " and (concepto_vac='N') ";}
if ($tipo_concepto == "VACACIONES") {$status = $status . " and (concepto_vac='S') ";}
if ($rango_f == 'S') {
	$act_hist = 'S';
	$status = $status . " and (fecha_p_hasta>='" . $cfechad . "') and (fecha_p_hasta<='" . $cfechah . "')  ";} else {if ($act_hist == 'S') {$status = $status . " and (fecha_p_hasta='" . $cfechan . "') ";}}
$status = $status . " and (afecta_Presup='SI') ";
if ($forma_pago == 'TODOS') {$status = $status;} else { $status = $status . " and (tipo_pago='" . $forma_pago . "') ";}

$cri_tp19 = "  (nom019.tp_calculo='" . $tipo_calculo . "') ";
if ($tipo_calculo == "E") {$cri_tp19 = "  ((nom019.tp_calculo='E')and(nom019.num_periodos=$num_periodos))  ";}

$cri_tp17 = "  (nom017.tp_calculo='" . $tipo_calculo . "') ";
if ($tipo_calculo == "E") {$cri_tp17 = "  ((nom017.tp_calculo='E')and(nom017.num_periodos=$num_periodos))  ";}

$conn = pg_connect("host=" . $host . " port=" . $port . " password=" . $password . " user=" . $user . " dbname=" . $dbname . "");if (pg_ErrorMessage($conn)) {$error = 1;} else {
	$Nom_Emp = busca_conf();if ($utf_rpt == "SI") {if ($php_os == "WINNT") {$php_os = "LINUX";} else { $php_os = "WINNT";}}
	if ($tipo_nomina_d != $tipo_nomina_h) {
		$sql = "SELECT tipo_nomina,descripcion,desc_grupo from nom001 where tipo_nomina='$tipo_nomina_d'";
		$res = pg_query($sql);if ($registro = pg_fetch_array($res, 0)) {$criterio2 = $registro["desc_grupo"];}
	} else {
		$sql = "SELECT tipo_nomina,descripcion,desc_grupo from nom001 where tipo_nomina='$tipo_nomina_d'";
		$res = pg_query($sql);if ($registro = pg_fetch_array($res, 0)) {$criterio2 = "Nomina: " . $tipo_nomina_d . " " . $registro["descripcion"];}}

	if ($tipo_concepto == "VACACIONES") {$criterio2 = "NOMINA DE VACACIONES";}
	$StrSQL = "delete from nom016 where (linea='000' or  linea='001') and tipo_nomina>='" . $tipo_nomina_d . "' and tipo_nomina<='" . $tipo_nomina_h . "'";
	$res = pg_exec($conn, $StrSQL);
	$error = pg_errormessage($conn);
	$error = substr($error, 0, 91);if (!$res) {?> <script language="JavaScript">  muestra('<?echo $error; ?>'); </script> <?}

	if ($act_hist == 'S') {
		$sSQL = "SELECT nom019.tipo_nomina, nom019.des_Nomina, nom019.fecha_desde, nom019.fecha_Hasta, nom019.cod_concepto, nom019.denominacion, nom019.cod_Empleado, nom019.Nombre, nom019.Asignacion, nom019.Monto_Asignacion, nom019.Monto_deduccion, nom019.Oculto, nom019.Monto, nom019.cod_presup, nom019.fecha_p_Hasta, nom019.Tp_calculo, nom019.desc_Grupo,
                   nom019.Afecta_presup,nom019.cod_Retencion,  nom019.Asig_ded_Apo,to_char(nom019.fecha_hasta,'DD/MM/YYYY') as fechah,to_char(nom019.fecha_desde,'DD/MM/YYYY') as fechad, pre022.cod_presup_p, pre022.cod_fuente_p, pre022.denominacion_p
                   FROM nom019 left join pre022 on (nom019.cod_presup=pre022.cod_presup_p and nom019.cod_contable=pre022.cod_fuente_p)
                   WHERE  ((nom019.cod_concepto<>'VVV') and (nom019.oculto='NO') and (nom019.Monto>0)) and
                   nom019.tipo_nomina>='" . $tipo_nomina_d . "' and nom019.tipo_nomina<='" . $tipo_nomina_h . "' and nom019.cod_concepto>='" . $cod_conceptod . "' and nom019.cod_concepto<='" . $cod_conceptoh . "' and
                   nom019.cod_presup>='" . $cod_presup_d . "' and nom019.cod_presup<='" . $cod_presup_h . "' and " . $cri_tp19 . $status . " order by nom019.cod_presup, nom019.tipo_nomina, nom019.cod_concepto";
		$StrSQL = "INSERT INTO nom016 select tipo_nomina, fecha_p_hasta, cod_empleado, '000', num_recibo, fecha_hasta, fecha_desde, fecha_proceso, tp_calculo, num_periodos,  cod_grupo, desc_grupo, nombre, cedula, fecha_ingreso, status_emp, cod_concepto, denominacion, cantidad, monto_orig, monto_asignacion,
					acumulado, saldo, valore, valoru, valorq, valorw, valorx, valory, valorz, cod_concepto, denominacion, cantidad, monto_orig,  monto_deduccion, acumulado, saldo, valore, valoru, valorq, valorw, valorx, valory, valorz, monto,asignacion,oculto,tipo_asigna,asig_ded_apo, frecuencia, nro_semana, cod_cargo,
					des_cargo, sueldo_cargo, prima_cargo, compensa_cargo, sueldo_integral,  otros, cod_departam, des_departam, cod_presup, cod_contable, tipo_pago, cta_empleado, cta_empresa, nombre_banco, afecta_presup,cod_retencion, codigo_ubicacion, descripcion_ubi, des_nomina
					FROM nom019 WHERE  ((nom019.cod_concepto<>'VVV') and (nom019.oculto='NO') and (nom019.Monto>0)) and nom019.tipo_nomina>='" . $tipo_nomina_d . "' and nom019.tipo_nomina<='" . $tipo_nomina_h . "' and nom019.cod_concepto>='" . $cod_conceptod . "' and nom019.cod_concepto<='" . $cod_conceptoh . "' and
					nom019.cod_presup>='" . $cod_presup_d . "' and nom019.cod_presup<='" . $cod_presup_h . "' and " . $cri_tp19 . $status;
	} else {
		$sSQL = "SELECT nom017.tipo_nomina, nom017.des_Nomina, nom017.fecha_desde, nom017.fecha_Hasta, nom017.cod_concepto, nom017.denominacion, nom017.cod_Empleado, nom017.Nombre, nom017.Asignacion, nom017.Monto_Asignacion, nom017.Monto_deduccion, nom017.Oculto, nom017.Monto, nom017.cod_presup, nom017.fecha_p_Hasta, nom017.Tp_calculo, nom017.desc_Grupo,
                   nom017.Afecta_presup,nom017.cod_Retencion,  nom017.Asig_ded_Apo,to_char(nom017.fecha_hasta,'DD/MM/YYYY') as fechah,to_char(nom017.fecha_desde,'DD/MM/YYYY') as fechad, pre022.cod_presup_p, pre022.cod_fuente_p, pre022.denominacion_p
                   FROM nom017 left join pre022 on (nom017.cod_presup=pre022.cod_presup_p and nom017.cod_contable=pre022.cod_fuente_p)
                   WHERE  ((nom017.cod_concepto<>'VVV') and (nom017.oculto='NO') and (nom017.Monto>0)) and
                   nom017.tipo_nomina>='" . $tipo_nomina_d . "' and nom017.tipo_nomina<='" . $tipo_nomina_h . "' and nom017.cod_concepto>='" . $cod_conceptod . "' and nom017.cod_concepto<='" . $cod_conceptoh . "' and
                   nom017.cod_presup>='" . $cod_presup_d . "' and nom017.cod_presup<='" . $cod_presup_h . "' and " . $cri_tp17 . $status . " order by nom017.cod_presup, nom017.tipo_nomina, nom017.cod_concepto";
		$StrSQL = "INSERT INTO nom016 select tipo_nomina, fecha_p_hasta, cod_empleado, '000', num_recibo, fecha_hasta, fecha_desde, fecha_proceso, tp_calculo, num_periodos,  cod_grupo, desc_grupo, nombre, cedula, fecha_ingreso, status_emp, cod_concepto, denominacion, cantidad, monto_orig, monto_asignacion,
					acumulado, saldo, valore, valoru, valorq, valorw, valorx, valory, valorz, cod_concepto, denominacion, cantidad, monto_orig,  monto_deduccion, acumulado, saldo, valore, valoru, valorq, valorw, valorx, valory, valorz, monto,asignacion,oculto,tipo_asigna,asig_ded_apo, frecuencia, nro_semana, cod_cargo,
					des_cargo, sueldo_cargo, prima_cargo, compensa_cargo, sueldo_integral,  otros, cod_departam, des_departam, cod_presup, cod_contable, tipo_pago, cta_empleado, cta_empresa, nombre_banco, afecta_presup,cod_retencion, codigo_ubicacion, descripcion_ubi, des_nomina
					FROM nom017 WHERE  ((nom017.cod_concepto<>'VVV') and (nom017.oculto='NO') and (nom017.Monto>0)) and nom017.tipo_nomina>='" . $tipo_nomina_d . "' and nom017.tipo_nomina<='" . $tipo_nomina_h . "' and nom017.cod_concepto>='" . $cod_conceptod . "' and nom017.cod_concepto<='" . $cod_conceptoh . "' and
					nom017.cod_presup>='" . $cod_presup_d . "' and nom017.cod_presup<='" . $cod_presup_h . "' and " . $cri_tp17 . $status;
	}
	$temp = $StrSQL;
	$res = pg_exec($conn, $StrSQL);
	$error = pg_errormessage($conn);
	$error = substr($error, 0, 91);if (!$res) {?> <script language="JavaScript">  muestra('<?echo $error; ?>'); </script> <?}

	$StrSQL = "update nom016 set monto1=monto*-1,monto2=0,linea='001' where asignacion='NO' and cod_retencion='000'";
	$res = pg_exec($conn, $StrSQL);
	$error = pg_errormessage($conn);
	$error = substr($error, 0, 91);if (!$res) {?> <script language="JavaScript">  muestra('<?echo $error; ?>'); </script> <?}

	$sSQL = "SELECT nom016.linea,nom016.tipo_nomina,nom016.des_Nomina, nom016.fecha_desde, nom016.fecha_Hasta, nom016.cod_concepto1 as cod_concepto, nom016.denominacion1 as denominacion, nom016.cod_Empleado, nom016.Nombre, nom016.Asignacion, nom016.monto1 as monto_asignacion, nom016.monto2 as monto_deduccion, nom016.Oculto, nom016.Monto, nom016.cod_presup, nom016.cod_contable, nom016.fecha_p_Hasta, nom016.Tp_calculo, nom016.desc_Grupo,
                   nom016.Afecta_presup,nom016.cod_Retencion,nom016.Asig_ded_Apo,to_char(nom016.fecha_p_hasta,'DD/MM/YYYY') as fechaph,to_char(nom016.fecha_hasta,'DD/MM/YYYY') as fechah,to_char(nom016.fecha_desde,'DD/MM/YYYY') as fechad, pre022.cod_presup_p, pre022.cod_fuente_p, pre022.denominacion_p
                   FROM nom016 left join pre022 on (nom016.cod_presup=pre022.cod_presup_p and nom016.cod_contable=pre022.cod_fuente_p)  where (linea='000' or linea='001') and tipo_nomina>='" . $tipo_nomina_d . "' and tipo_nomina<='" . $tipo_nomina_h . "' order by cod_presup,cod_contable,linea,tipo_nomina,cod_concepto,cod_empleado";
	$nomb_rpt = "Rpt_rela_con_cod_pre_rn_re.xml";
	if ($detalle_concepto == "SI") {
		$nomb_rpt = "Rpt_rela_con_cod_pre_rn_re_deta_concep.xml";
		$num_rpt = 2;}
	if ($detalle_trabajador == "SI") {
		$nomb_rpt = "Rpt_rela_con_cod_pre_rn_re_deta_trab.xml";
		$num_rpt = 3;}
	if ($tipo_rpt == "HTML") {
		// echo $temp." ".$sSQL;
		$oRpt = new PHPReportMaker();
		$oRpt->setXML($nomb_rpt);
		$oRpt->setUser("$user");
		$oRpt->setPassword("$password");
		$oRpt->setConnection("$host");
		$oRpt->setDatabaseInterface("postgresql");
		$oRpt->setSQL($sSQL);
		$oRpt->setDatabase("$dbname");
		$oRpt->setParameters(array("criterio1" => $criterio1, "criterio2" => $criterio2, "criterio3" => $criterio3, "monto" => $monto, "date" => $date, "hora" => $hora));
		$oRpt->run();
		$aBench = $oRpt->getBenchmark();
	}
	if (($tipo_rpt == "PDF") and ($num_rpt == 1)) {
		$res = pg_query($sSQL);
		$filas = pg_num_rows($res);
		$cod_presup_grupo = "";
		if ($filas >= 1) {
			$registro = pg_fetch_array($res, 0);
			$fechad = $registro["fechad"];
			$fechaph = $registro["fechaph"];}
		require '../../class/fpdf/fpdf.php';
		class PDF extends FPDF {
			function Header() {
				global $criterio2;global $criterio3;global $cod_presup_grupo;global $fechad;global $fechaph;global $registro;global $rango_f;
				$this->Image('../../imagenes/Logo_emp.png', 7, 7, 25);
				$this->SetFont('Arial', 'B', 10);
				$this->Cell(30);
				$this->Cell(140, 10, 'RELACION CONCEPTOS/CODIGOS PRESUPUESTARIOS', 1, 0, 'C');
				$this->Ln(20);
				$this->SetFont('Arial', 'B', 8);
				$this->Cell(120, 5, $criterio2, 0, 1, 'L');
				if ($rango_f == 'S') {$this->Cell(120, 5, $criterio3, 0, 1, 'L');} else { $this->Cell(120, 5, "Fecha : " . $fechad . " al " . $fechaph, 0, 1, 'L');}
				$this->SetFont('Arial', 'B', 7);
				$this->Cell(43, 5, 'COD. PRESUPUESTARIO', 1, 0);
				$this->Cell(100, 5, 'DENOMINACION', 1, 0, 'L');
				$this->Cell(19, 5, 'ASIGNACION', 1, 0);
				$this->Cell(19, 5, 'DEDUCCION', 1, 0, 'C');
				$this->Cell(19, 5, 'NETO', 1, 1);
			}
			function Footer() {
				$ffechar = date("d-m-Y");
				$fhorar = date("H:i:s a");
				$this->SetY(-10);
				$this->SetFont('Arial', 'I', 5);
				$this->Cell(100, 5, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
				$this->Cell(100, 5, 'fecha: ' . $ffechar . ' Hora: ' . $fhorar, 0, 0, 'R');
			}
		}
		$pdf = new PDF('P', 'mm', Letter);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial', '', 7);
		$i = 0;
		$total_monto_asignacion = 0;
		$total_monto_deduccion = 0;
		$total_monto = 0;
		$sub_total_monto_asignacion = "";
		$sub_total_monto_deduccion = "";
		$sub_total_monto = "";
		$prev_cod_presup = "";
		$prev_cod_contable = "";
		$prev_linea = "";
		$prev_denominacion_p = "";
		$prev_cod_grupo = "";
		$res = pg_query($sSQL);
		//$pdf->MultiCell(200,4,$temp,0);
		while ($registro = pg_fetch_array($res)) {
			$i = $i + 1;
			$cod_presup = $registro["cod_presup"];
			$cod_contable = $registro["cod_contable"];
			$denominacion_p = $registro["denominacion_p"];
			$linea = $registro["linea"];
			if ($php_os == "WINNT") {$denominacion_p = $registro["denominacion_p"];} else { $denominacion_p = utf8_decode($registro["denominacion_p"]);}
			$cod_presup_grupo = $cod_presup . $cod_contable;
			$denominacion_p_grupo = $denominacion_p;
			if ($prev_cod_grupo != $cod_presup_grupo) {
				if (($sub_total_monto_asignacion != 0) or ($sub_total_monto_deduccion > 0) or ($sub_total_monto > 0)) {
					$sub_total_monto_asignacion = formato_monto($sub_total_monto_asignacion);
					$sub_total_monto_deduccion = formato_monto($sub_total_monto_deduccion);
					$sub_total_monto = formato_monto($sub_total_monto);
					$pdf->Cell(43, 4, $prev_cod_presup . "  " . $prev_cod_contable, 0, 0, 'L');
					$x = $pdf->GetX();
					$y = $pdf->GetY();
					$w = 100;
					$pdf->SetXY($x + $w, $y);
					$pdf->Cell(19, 4, $sub_total_monto_asignacion, 0, 0, 'R');
					$pdf->Cell(19, 4, $sub_total_monto_deduccion, 0, 0, 'R');
					$pdf->Cell(19, 4, $sub_total_monto, 0, 1, 'R');
					$pdf->SetXY($x, $y);
					$pdf->MultiCell($w, 4, $prev_denominacion_p, 0);
				}
				$prev_cod_grupo = $cod_presup_grupo;
				$prev_cod_presup = $cod_presup;
				$prev_cod_contable = $cod_contable;
				$prev_linea = $linea;
				$prev_denominacion_p = $denominacion_p_grupo;
				$sub_total_monto_asignacion = 0;
				$sub_total_monto_deduccion = 0;
				$sub_total_monto = 0;
			}
			$cod_presup = $registro["cod_presup"];
			$denominacion_p = $registro["denominacion_p"];
			$monto_asignacion = $registro["monto_asignacion"];
			$monto_deduccion = $registro["monto_deduccion"];
			$total_monto_asignacion = $total_monto_asignacion + $monto_asignacion;
			$total_monto_deduccion = $total_monto_deduccion + $monto_deduccion;
			$total_monto = $total_monto + $monto_asignacion - $monto_deduccion;
			$sub_total_monto_asignacion = $sub_total_monto_asignacion + $monto_asignacion;
			$sub_total_monto_deduccion = $sub_total_monto_deduccion + $monto_deduccion;
			$sub_total_monto = $sub_total_monto + $monto_asignacion - $monto_deduccion;
			$monto_asignacion = formato_monto($monto_asignacion);
			$monto_deduccion = formato_monto($monto_deduccion);
			if ($php_os == "WINNT") {$denominacion_p = $registro["denominacion_p"];} else {
				$denominacion_p = utf8_decode($denominacion_p);
				$denominacion_p = utf8_decode($denominacion_p);}
		}
		if (($sub_total_monto_asignacion > 0) or ($sub_total_monto_deduccion > 0) or ($sub_total_monto > 0)) {
			$sub_total_monto_asignacion = formato_monto($sub_total_monto_asignacion);
			$sub_total_monto_deduccion = formato_monto($sub_total_monto_deduccion);
			$sub_total_monto = formato_monto($sub_total_monto);
			$pdf->Cell(43, 4, $prev_cod_presup . "  " . $prev_cod_contable, 0, 0, 'L');
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$w = 100;
			$pdf->SetXY($x + $w, $y);
			$pdf->Cell(19, 4, $sub_total_monto_asignacion, 0, 0, 'R');
			$pdf->Cell(19, 4, $sub_total_monto_deduccion, 0, 0, 'R');
			$pdf->Cell(19, 4, $sub_total_monto, 0, 1, 'R');
			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w, 4, $prev_denominacion_p, 0);
			$pdf->Ln(5);
		}
		$total_monto_asignacion = formato_monto($total_monto_asignacion);
		$total_monto_deduccion = formato_monto($total_monto_deduccion);
		$total_monto = formato_monto($total_monto);
		$pdf->SetFont('Arial', 'B', 7);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(143, 3, '', 0, 0);
		$pdf->Cell(19, 3, '=============', 0, 0, 'R');
		$pdf->Cell(19, 3, '=============', 0, 0, 'R');
		$pdf->Cell(19, 3, '=============', 0, 1, 'R');
		$pdf->Cell(143, 3, 'TOTAL GENERAL : ', 0, 0, 'R');
		$pdf->Cell(19, 3, $total_monto_asignacion, 0, 0, 'R');
		$pdf->Cell(19, 3, $total_monto_deduccion, 0, 0, 'R');
		$pdf->Cell(19, 3, $total_monto, 0, 1, 'R');

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

		$pdf->Cell(45, 4, 'Elaborado por Analista', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Revisado por', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Aprobado por ', 'T', 1, 'C');
		$pdf->Cell(50, 3, ' ', 0, 0, 'C'); //nmdb (20171121) Arendriz Chirinos
		$pdf->Cell(50, 3, 'Lcda. Soraya Muñoz', 0, 0, 'C'); //nmdb (13095669) Zuleima Rivas
		$pdf->Cell(50, 3, 'Lcdo. Jose Medina', 0, 0, 'C');

		$pdf->Output();
	}

	if (($tipo_rpt == "PDF") and ($num_rpt == 2)) {
		$res = pg_query($sSQL);
		$filas = pg_num_rows($res);
		$cod_presup_grupo = "";
		if ($filas >= 1) {
			$registro = pg_fetch_array($res, 0);
			$fechad = $registro["fechad"];
			$fechaph = $registro["fechaph"];}
		require '../../class/fpdf/fpdf.php';
		class PDF extends FPDF {
			function Header() {
				global $criterio2;global $criterio3;global $cod_presup_grupo;global $fechad;global $fechaph;global $registro;global $rango_f;
				$this->Image('../../imagenes/Logo_emp.png', 7, 7, 25);
				$this->SetFont('Arial', 'B', 10);
				$this->Cell(30);
				$this->Cell(140, 10, 'RELACION CONCEPTOS/CODIGOS PRESUPUESTARIOS', 1, 0, 'C');
				$this->Ln(20);
				$this->SetFont('Arial', 'B', 8);
				$this->Cell(120, 5, $criterio2, 0, 1, 'L');
				if ($rango_f == 'S') {$this->Cell(120, 5, $criterio3, 0, 1, 'L');} else { $this->Cell(120, 5, "Fecha : " . $fechad . " al " . $fechaph, 0, 1, 'L');}
				$this->SetFont('Arial', 'B', 7);
				$this->Cell(32, 5, 'COD. PRESUPUESTARIO', 1, 0);
				$this->Cell(108, 5, 'DENOMINACION', 1, 0, 'L');
				$this->Cell(20, 5, 'ASIGNACION', 1, 0);
				$this->Cell(20, 5, 'DEDUCCION', 1, 0, 'C');
				$this->Cell(20, 5, 'NETO', 1, 1);
			}
			function Footer() {
				$ffechar = date("d-m-Y");
				$fhorar = date("H:i:s a");
				$this->SetY(-10);
				$this->SetFont('Arial', 'I', 5);
				$this->Cell(100, 5, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
				$this->Cell(100, 5, 'fecha: ' . $ffechar . ' Hora: ' . $fhorar, 0, 0, 'R');
			}
		}
		$pdf = new PDF('P', 'mm', Letter);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial', '', 6);
		$i = 0;
		$total_monto_asignacion = 0;
		$total_monto_deduccion = 0;
		$total_monto = 0;
		$sub_total_monto_asignacion = 0;
		$sub_total_monto_deduccion = 0;
		$sub_total_monto = 0;
		$sub_total_monto_asignacion1 = 0;
		$sub_total_monto_deduccion1 = 0;
		$sub_total_monto1 = 0;
		$prev_cod_presup = "";
		$prev_denominacion_p = "";
		$prev_cod_concepto = "";
		$prev_denominacion = "";
		$res = pg_query($sSQL);
		while ($registro = pg_fetch_array($res)) {
			$i = $i + 1;
			$cod_presup = $registro["cod_presup"];
			$denominacion_p = $registro["denominacion_p"];
			$cod_concepto = $registro["cod_concepto"];
			$denominacion = $registro["denominacion"];
			if ($php_os == "WINNT") {$denominacion_p = $registro["denominacion_p"];} else {
				$denominacion_p = utf8_decode($registro["denominacion_p"]);
				$denominacion = utf8_decode($registro["denominacion"]);}
			$cod_presup_grupo = $cod_presup;
			$denominacion_p_grupo = $denominacion_p;
			$cod_concepto_grupo = $cod_concepto;
			$denominacion_grupo = $denominacion;
			if ($prev_cod_concepto != $cod_concepto_grupo) {
				if (($sub_total_monto_asignacion > 0) or ($sub_total_monto_deduccion > 0)) {
					$sub_total_monto_asignacion = formato_monto($sub_total_monto_asignacion);
					$sub_total_monto_deduccion = formato_monto($sub_total_monto_deduccion);
					$pdf->Cell(10, 3, '', 0, 0, 'R');
					$pdf->Cell(10, 3, $prev_cod_concepto, 0, 0, 'R');
					$x = $pdf->GetX();
					$y = $pdf->GetY();
					$w = 120;
					$pdf->SetXY($x + $w, $y);
					$pdf->Cell(20, 3, $sub_total_monto_asignacion, 0, 0, 'R');
					$pdf->Cell(20, 3, $sub_total_monto_deduccion, 0, 0, 'R');
					$pdf->Cell(20, 3, '', 0, 1, 'R');
					$pdf->SetXY($x, $y);
					$pdf->MultiCell($w, 3, $prev_denominacion, 0);
				}
				$prev_cod_concepto = $cod_concepto_grupo;
				$prev_denominacion = $denominacion_grupo;
				$sub_total_monto_asignacion = 0;
				$sub_total_monto_deduccion = 0;
			}
			if ($prev_cod_presup != $cod_presup_grupo) {
				if (($sub_total_monto_asignacion1 > 0) or ($sub_total_monto_deduccion1 > 0) or ($sub_total_monto1 > 0)) {
					$sub_total_monto_asignacion1 = formato_monto($sub_total_monto_asignacion1);
					$sub_total_monto_deduccion1 = formato_monto($sub_total_monto_deduccion1);
					$sub_total_monto1 = formato_monto($sub_total_monto1);
					$pdf->Cell(140, 2, '', 0, 0, 'R');
					$pdf->Cell(20, 2, '--------------', 0, 0, 'R');
					$pdf->Cell(20, 2, '--------------', 0, 0, 'R');
					$pdf->Cell(20, 2, '============', 0, 1, 'R');
					$pdf->Cell(140, 3, 'Total : ' . $prev_cod_presup, 0, 0, 'R');
					$pdf->Cell(20, 3, $sub_total_monto_asignacion1, 0, 0, 'R');
					$pdf->Cell(20, 3, $sub_total_monto_deduccion1, 0, 0, 'R');
					$pdf->Cell(20, 3, $sub_total_monto1, 0, 1, 'R');
					$pdf->Ln(3);
					$sub_total_monto_asignacion1 = 0;
					$sub_total_monto_deduccion1 = 0;
					$sub_total_monto1 = 0;
				}
				$pdf->SetFont('Arial', '', 6);
				$pdf->Cell(32, 5, $cod_presup_grupo, 0, 0, 'L');
				$pdf->Cell(168, 5, $denominacion_p_grupo, 0, 1, 'L');
				$prev_cod_presup = $cod_presup_grupo;
				$prev_denominacion_p = $denominacion_p_grupo;
				$sub_total_monto_asignacion = 0;
				$sub_total_monto_deduccion = 0;
				$sub_total_monto = 0;}

			$cod_presup = $registro["cod_presup"];
			$denominacion_p = $registro["denominacion_p"];
			$cod_concepto = $registro["cod_concepto"];
			$denominacion = $registro["denominacion"];
			$monto_asignacion = $registro["monto_asignacion"];
			$monto_deduccion = $registro["monto_deduccion"];
			$total_monto_asignacion = $total_monto_asignacion + $monto_asignacion;
			$total_monto_deduccion = $total_monto_deduccion + $monto_deduccion;
			$total_monto = $total_monto + $monto_asignacion - $monto_deduccion;
			$sub_total_monto_asignacion = $sub_total_monto_asignacion + $monto_asignacion;
			$sub_total_monto_deduccion = $sub_total_monto_deduccion + $monto_deduccion;
			$sub_total_monto = $sub_total_monto + $monto_asignacion - $monto_deduccion;
			$sub_total_monto_asignacion1 = $sub_total_monto_asignacion1 + $monto_asignacion;
			$sub_total_monto_deduccion1 = $sub_total_monto_deduccion1 + $monto_deduccion;
			$sub_total_monto1 = $sub_total_monto1 + $monto_asignacion - $monto_deduccion;
			$monto_asignacion = formato_monto($monto_asignacion);
			$monto_deduccion = formato_monto($monto_deduccion);
			if ($php_os == "WINNT") {$denominacion_p = $registro["denominacion_p"];} else {
				$denominacion_p = utf8_decode($denominacion_p);
				$denominacion = utf8_decode($denominacion);}
		}

		if (($sub_total_monto_asignacion > 0) or ($sub_total_monto_deduccion > 0) or ($sub_total_monto > 0)) {
			$sub_total_monto_asignacion = formato_monto($sub_total_monto_asignacion);
			$sub_total_monto_deduccion = formato_monto($sub_total_monto_deduccion);
			$sub_total_monto = formato_monto($sub_total_monto);
			$pdf->Cell(10, 3, '', 0, 0, 'R');
			$pdf->Cell(10, 3, $prev_cod_concepto, 0, 0, 'R');
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$w = 120;
			$pdf->SetXY($x + $w, $y);
			$pdf->Cell(20, 3, $sub_total_monto_asignacion, 0, 0, 'R');
			$pdf->Cell(20, 3, $sub_total_monto_deduccion, 0, 0, 'R');
			$pdf->Cell(20, 3, '', 0, 1, 'R');
			$pdf->SetXY($x, $y);
			$pdf->MultiCell($w, 3, $prev_denominacion, 0);
		}

		if (($sub_total_monto_asignacion1 > 0) or ($sub_total_monto_deduccion1 > 0) or ($sub_total_monto1 > 0)) {
			$sub_total_monto_asignacion1 = formato_monto($sub_total_monto_asignacion1);
			$sub_total_monto_deduccion1 = formato_monto($sub_total_monto_deduccion1);
			$sub_total_monto1 = formato_monto($sub_total_monto1);
			$pdf->Cell(140, 2, '', 0, 0, 'R');
			$pdf->Cell(20, 2, '--------------', 0, 0, 'R');
			$pdf->Cell(20, 2, '--------------', 0, 0, 'R');
			$pdf->Cell(20, 2, '============', 0, 1, 'R');
			$pdf->Cell(140, 3, 'Total : ' . $prev_cod_presup, 0, 0, 'R');
			$pdf->Cell(20, 3, $sub_total_monto_asignacion1, 0, 0, 'R');
			$pdf->Cell(20, 3, $sub_total_monto_deduccion1, 0, 0, 'R');
			$pdf->Cell(20, 3, $sub_total_monto1, 0, 1, 'R');
			$pdf->Ln(5);
		}
		$total_monto_asignacion = formato_monto($total_monto_asignacion);
		$total_monto_deduccion = formato_monto($total_monto_deduccion);
		$total_monto = formato_monto($total_monto);
		$pdf->SetFont('Arial', 'B', 7);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(140, 3, '', 0, 0);
		$pdf->Cell(20, 3, '=============', 0, 0, 'R');
		$pdf->Cell(20, 3, '=============', 0, 0, 'R');
		$pdf->Cell(20, 3, '=============', 0, 1, 'R');
		$pdf->Cell(140, 3, 'TOTAL GENERAL : ', 0, 0, 'R');
		$pdf->Cell(20, 3, $total_monto_asignacion, 0, 0, 'R');
		$pdf->Cell(20, 3, $total_monto_deduccion, 0, 0, 'R');
		$pdf->Cell(20, 3, $total_monto, 0, 1, 'R');
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

		$pdf->Cell(45, 4, 'Elaborado por Analista', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Revisado por', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Aprobado por ', 'T', 1, 'C');
		$pdf->Cell(50, 3, 'Analista de Nomina', 0, 0, 'C'); //nmdb (20171121) Arendriz Chirinos
		$pdf->Cell(50, 3, 'Lcda. Soraya Muñoz', 0, 0, 'C'); //nmdb (20171121) Zuleima Rivas
		$pdf->Cell(50, 3, 'Lcdo. Jose Medina', 0, 0, 'C');

		$pdf->Output();
	}

	if (($tipo_rpt == "PDF") and ($num_rpt == 3)) {
		$res = pg_query($sSQL);
		$filas = pg_num_rows($res);
		$cod_presup_grupo = "";
		if ($filas >= 1) {
			$registro = pg_fetch_array($res, 0);
			$fechad = $registro["fechad"];
			$fechaph = $registro["fechaph"];}
		require '../../class/fpdf/fpdf.php';

		class PDF extends FPDF {
			function Header() {
				global $criterio2;global $criterio3;global $cod_presup_grupo;global $fechad;global $fechaph;global $registro;global $rango_f;
				$this->Image('../../imagenes/Logo_emp.png', 7, 7, 25);
				$this->SetFont('Arial', 'B', 10);
				$this->Cell(30);
				$this->Cell(140, 10, 'RELACION CONCEPTOS/CODIGOS PRESUPUESTARIOS', 1, 0, 'C');
				$this->Ln(20);
				$this->SetFont('Arial', 'B', 8);
				$this->Cell(120, 5, $criterio2, 0, 1, 'L');
				if ($rango_f == 'S') {$this->Cell(120, 5, $criterio3, 0, 1, 'L');} else { $this->Cell(120, 5, "Fecha : " . $fechad . " al " . $fechaph, 0, 1, 'L');}
				$this->SetFont('Arial', 'B', 7);
				$this->Cell(32, 5, 'COD. PRESUPUESTARIO', 1, 0);
				$this->Cell(108, 5, 'DENOMINACION', 1, 0, 'L');
				$this->Cell(20, 5, 'ASIGNACION', 1, 0);
				$this->Cell(20, 5, 'DEDUCCION', 1, 0, 'C');
				$this->Cell(20, 5, 'NETO', 1, 1);
			}
			function Footer() {
				$ffechar = date("d-m-Y");
				$fhorar = date("H:i:s a");
				$this->SetY(-10);
				$this->SetFont('Arial', 'I', 5);
				$this->Cell(100, 5, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
				$this->Cell(100, 5, 'fecha: ' . $ffechar . ' Hora: ' . $fhorar, 0, 0, 'R');
			}
		}
		$pdf = new PDF('P', 'mm', Letter);
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial', '', 6);
		$i = 0;
		$total_monto_asignacion = 0;
		$total_monto_deduccion = 0;
		$total_monto = 0;
		$sub_total_monto_asignacion = 0;
		$sub_total_monto_deduccion = 0;
		$sub_total_monto = 0;
		$sub_total_monto_asignacion1 = 0;
		$sub_total_monto_deduccion1 = 0;
		$sub_total_monto1 = 0;
		$prev_cod_presup = "";
		$prev_denominacion_p = "";
		$prev_cod_concepto = "";
		$prev_denominacion = "";
		$res = pg_query($sSQL);
		while ($registro = pg_fetch_array($res)) {
			$i = $i + 1;
			$cod_presup = $registro["cod_presup"];
			$denominacion_p = $registro["denominacion_p"];
			$cod_concepto = $registro["cod_concepto"];
			$denominacion = $registro["denominacion"];
			if ($php_os == "WINNT") {$denominacion_p = $registro["denominacion_p"];} else {
				$denominacion_p = utf8_decode($registro["denominacion_p"]);
				$denominacion = utf8_decode($registro["denominacion"]);}
			$cod_presup_grupo = $cod_presup;
			$denominacion_p_grupo = $denominacion_p;
			$cod_concepto_grupo = $cod_concepto;
			$denominacion_grupo = $denominacion;
			if ($prev_cod_presup != $cod_presup_grupo) {
				if (($sub_total_monto_asignacion1 > 0) or ($sub_total_monto_deduccion1 > 0) or ($sub_total_monto1 > 0)) {
					$sub_total_monto_asignacion1 = formato_monto($sub_total_monto_asignacion1);
					$sub_total_monto_deduccion1 = formato_monto($sub_total_monto_deduccion1);
					$sub_total_monto1 = formato_monto($sub_total_monto1);
					$pdf->Cell(140, 2, '', 0, 0, 'R');
					$pdf->Cell(20, 2, '--------------', 0, 0, 'R');
					$pdf->Cell(20, 2, '--------------', 0, 0, 'R');
					$pdf->Cell(20, 2, '============', 0, 1, 'R');
					$pdf->Cell(140, 3, 'Total : ' . $prev_cod_presup, 0, 0, 'R');
					$pdf->Cell(20, 3, $sub_total_monto_asignacion1, 0, 0, 'R');
					$pdf->Cell(20, 3, $sub_total_monto_deduccion1, 0, 0, 'R');
					$pdf->Cell(20, 3, $sub_total_monto1, 0, 1, 'R');
					$pdf->Ln(3);
					$sub_total_monto_asignacion1 = 0;
					$sub_total_monto_deduccion1 = 0;
					$sub_total_monto1 = 0;
				}
				$pdf->SetFont('Arial', '', 6);
				$pdf->Cell(32, 5, $cod_presup_grupo, 0, 0, 'L');
				$pdf->Cell(168, 5, $denominacion_p_grupo, 0, 1, 'L');
				$prev_cod_presup = $cod_presup_grupo;
				$prev_denominacion_p = $denominacion_p_grupo;
				$sub_total_monto_asignacion = 0;
				$sub_total_monto_deduccion = 0;
				$sub_total_monto = 0;
				$prev_cod_concepto = "";}
			if ($prev_cod_concepto != $cod_concepto_grupo) {
				$pdf->Ln(2);
				$pdf->Cell(10, 3, '', 0, 0, 'R');
				$pdf->Cell(10, 3, $cod_concepto_grupo, 0, 0, 'L');
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$w = 120;
				$pdf->SetXY($x, $y);
				$pdf->MultiCell($w, 3, $denominacion_grupo, 0);
				$prev_cod_concepto = $cod_concepto_grupo;
				$prev_denominacion = $denominacion_grupo;
			}
			$cod_presup = $registro["cod_presup"];
			$denominacion_p = $registro["denominacion_p"];
			$cod_concepto = $registro["cod_concepto"];
			$denominacion = $registro["denominacion"];
			$nombre = $registro["nombre"];
			$cod_empleado = $registro["cod_empleado"];
			$monto_asignacion = $registro["monto_asignacion"];
			$monto_deduccion = $registro["monto_deduccion"];
			$total_monto_asignacion = $total_monto_asignacion + $monto_asignacion;
			$total_monto_deduccion = $total_monto_deduccion + $monto_deduccion;
			$total_monto = $total_monto + $monto_asignacion - $monto_deduccion;
			$sub_total_monto_asignacion = $sub_total_monto_asignacion + $monto_asignacion;
			$sub_total_monto_deduccion = $sub_total_monto_deduccion + $monto_deduccion;
			$sub_total_monto = $sub_total_monto + $monto_asignacion - $monto_deduccion;
			$sub_total_monto_asignacion1 = $sub_total_monto_asignacion1 + $monto_asignacion;
			$sub_total_monto_deduccion1 = $sub_total_monto_deduccion1 + $monto_deduccion;
			$sub_total_monto1 = $sub_total_monto1 + $monto_asignacion - $monto_deduccion;
			$monto_asignacion = formato_monto($monto_asignacion);
			$monto_deduccion = formato_monto($monto_deduccion);
			if ($php_os == "WINNT") {$denominacion_p = $registro["denominacion_p"];} else {
				$nombre = utf8_decode($nombre);
				$denominacion_p = utf8_decode($denominacion_p);
				$denominacion = utf8_decode($denominacion);}
			$pdf->SetFont('Arial', '', 7);
			$pdf->Cell(30, 3, $cod_empleado, 0, 0, 'R');
			$x = $pdf->GetX();
			$y = $pdf->GetY();
			$n = 110;
			$pdf->SetXY($x + $n, $y);
			$pdf->Cell(20, 3, $monto_asignacion, 0, 0, 'R');
			$pdf->Cell(20, 3, $monto_deduccion, 0, 0, 'R');
			$pdf->Cell(20, 3, '', 0, 1, 'R');
			$pdf->SetXY($x, $y);
			$pdf->MultiCell($n, 3, $nombre, 0);
		}
		/*
				 if(($sub_total_monto_asignacion>0)or($sub_total_monto_deduccion>0)or($sub_total_monto>0)){ $sub_total_monto_asignacion=formato_monto($sub_total_monto_asignacion);	$sub_total_monto_deduccion=formato_monto($sub_total_monto_deduccion); $sub_total_monto=formato_monto($sub_total_monto);
					$pdf->Cell(10,3,'',0,0,'R');
					$pdf->Cell(10,3,$prev_cod_concepto,0,0,'R');
			        $x=$pdf->GetX();   $y=$pdf->GetY();  $w=120;
			   		$pdf->SetXY($x+$w,$y);
			   		$pdf->Cell(20,3,$sub_total_monto_asignacion,0,0,'R');
			   		$pdf->Cell(20,3,$sub_total_monto_deduccion,0,0,'R');
			   		$pdf->Cell(20,3,'',0,1,'R');
			  		$pdf->SetXY($x,$y);
			   		$pdf->MultiCell($w,3,$prev_denominacion,0);
				 }
		*/
		if (($sub_total_monto_asignacion1 > 0) or ($sub_total_monto_deduccion1 > 0) or ($sub_total_monto1 > 0)) {
			$sub_total_monto_asignacion1 = formato_monto($sub_total_monto_asignacion1);
			$sub_total_monto_deduccion1 = formato_monto($sub_total_monto_deduccion1);
			$sub_total_monto1 = formato_monto($sub_total_monto1);
			$pdf->Cell(140, 2, '', 0, 0, 'R');
			$pdf->Cell(20, 2, '--------------', 0, 0, 'R');
			$pdf->Cell(20, 2, '--------------', 0, 0, 'R');
			$pdf->Cell(20, 2, '============', 0, 1, 'R');
			$pdf->Cell(140, 3, 'Total : ' . $prev_cod_presup, 0, 0, 'R');
			$pdf->Cell(20, 3, $sub_total_monto_asignacion1, 0, 0, 'R');
			$pdf->Cell(20, 3, $sub_total_monto_deduccion1, 0, 0, 'R');
			$pdf->Cell(20, 3, $sub_total_monto1, 0, 1, 'R');
			$pdf->Ln(5);
		}
		$total_monto_asignacion = formato_monto($total_monto_asignacion);
		$total_monto_deduccion = formato_monto($total_monto_deduccion);
		$total_monto = formato_monto($total_monto);
		$pdf->SetFont('Arial', 'B', 7);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->Cell(140, 3, '', 0, 0);
		$pdf->Cell(20, 3, '=============', 0, 0, 'R');
		$pdf->Cell(20, 3, '=============', 0, 0, 'R');
		$pdf->Cell(20, 3, '=============', 0, 1, 'R');
		$pdf->Cell(140, 3, 'TOTAL GENERAL : ', 0, 0, 'R');
		$pdf->Cell(20, 3, $total_monto_asignacion, 0, 0, 'R');
		$pdf->Cell(20, 3, $total_monto_deduccion, 0, 0, 'R');
		$pdf->Cell(20, 3, $total_monto, 0, 1, 'R');
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

		$pdf->Cell(45, 4, 'Elaborado por Analista', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Revisado por', 'T', 0, 'C');
		$pdf->Cell(5, 4, '', 0, 0);
		$pdf->Cell(45, 4, 'Aprobado por ', 'T', 1, 'C');

		$pdf->Cell(50, 3, ' ', 0, 0, 'C'); //nmdb (20171121) Arendriz Chirinos
		$pdf->Cell(50, 3, 'Lcda. Soraya Muñoz', 0, 0, 'C'); //nmdb (20171121) Zuleima Rivas
		$pdf->Cell(50, 3, 'Lcdo. Jose Medina', 0, 0, 'C');

		$pdf->Output();
	}

	/*
		$StrSQL = "delete from nom016 where linea='000' and tipo_nomina>='".$tipo_nomina_d."' and tipo_nomina<='".$tipo_nomina_h."'";
		$res=pg_exec($conn,$StrSQL); $error=pg_errormessage($conn); $error=substr($error,0,91);
	*/
}

?>
