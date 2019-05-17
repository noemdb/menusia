<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT"; error_reporting(E_ALL ^ E_NOTICE);
if (!$_GET){ $nro_orden="";$tipo_causado=""; } else{$nro_orden=$_GET["txtnro_orden"];  $tipo_causado=$_GET["txttipo_causado"];}
$sql="Select * from ORD_PAGO where tipo_causado='$tipo_causado' and nro_orden='$nro_orden'";
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$direccion=""; $nombre_emp=""; $ced_rif_emp="";$sqle="Select * from SIA000 order by campo001"; $rese=pg_query($sqle); if ($registro=pg_fetch_array($rese,0)){$cod_emp=$registro["campo001"]; $direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $ced_rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
$concepto="";$fecha="";$nombre_abrev_caus=""; $ced_rif="";$nombre="";$inf_usuario="";$anulado="";  $tipo_documento="";  $nro_documento=""; $afecta_presu=""; $status_1=""; $usuario_sia="";
$func=""; $inv=""; $con_comp=""; $directa=""; $financ=""; $caja_chica=""; $permanente=""; $orden_permanen=""; $cod_tipo_orden="";
$oc=""; $os=""; $fact=""; $nom=""; $anticipo=""; $recibo=""; $otros=""; $ing_ord=""; $fuente_otra="";
$res=pg_query($sql); $filas=pg_num_rows($res); $total_neto=0;
if($filas>0){  $registro=pg_fetch_array($res); $nro_orden=$registro["nro_orden"];   $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"];  $concepto=$registro["concepto"]; $afecta_presu=$registro["afecta_presu"]; $status_1=$registro["status_1"];
  $inf_usuario=$registro["inf_usuario"];  $nombre_abrev_caus=$registro["nombre_abrev_caus"]; $cod_tipo_orden=$registro["tipo_orden"];   $ced_rif=$registro["ced_rif"];  $nombre=$registro["nombre"];  $func_inv=$registro["func_inv"];
  $anulado=$registro["anulado"];  $pago_ces=$registro["pago_ces"];  $ced_rif_ces=$registro["ced_rif_ces"]; $usuario_sia=$registro["usuario_sia"];
  $nombre_ces=$registro["nombre_ces"];  $tipo_documento=$registro["tipo_documento"];  $nro_documento=$registro["nro_documento"];  $total_causado=$registro["total_causado"];  $total_retencion=$registro["total_retencion"];
  $total_ajuste=$registro["total_ajuste"];  $total_pasivos=$registro["total_pasivos"];  $monto_am_ant=$registro["monto_am_ant"];  $orden_permanen=$registro["orden_permanen"];
  $total_neto = $total_causado - $total_retencion - $total_ajuste - $monto_am_ant + $total_pasivos;
} $tipo_comp='O'.$tipo_causado; $sfecha=$fecha; $referencia=$nro_orden;

$total_neto=formato_monto($total_neto); $total_causado=formato_monto($total_causado);
$monto_letras= monto_letras($total_neto);
$mes=substr($fecha,3,2);  $ano=substr($fecha,6,4);
if ($mes=="01"){$mes="ENERO";}else{if ($mes=="02"){$mes="FEBRERO";}else{if ($mes=="03"){$mes="MARZO";}else {if ($mes=="04"){$mes="ABRIL";}else {if ($mes=="05"){$mes="MAYO";}else {if ($mes=="06"){$mes="JUNIO";}else {if ($mes=="07"){$mes="JULIO";}else {if ($mes=="08"){$mes="AGOSTO";}else {if ($mes=="09"){$mes="SEPTIEMBRE";}else {if ($mes=="10"){$mes="OCTUBRE";}else {if ($mes=="11"){$mes="NOVIEMBRE";}else {$mes="DICIEMBRE";}}}}}}}}}}}
$lugar="San Felipe, ".substr($fecha,0,2)." DE ".$mes." DE ".$ano;

require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $nro_orden; global $tipo_orden; global $fecha; global $php_os; global $total_pre; global $nombre_emp;	    
        $this->SetFont('Arial','B',12);
		$this->Cell(200,5,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,1,'C');
		$this->Cell(200,5,$nombre_emp,0,1,'C');
		$this->Ln(15);
		
	}	
	function Footer(){$ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		$this->SetY(-10);	
        
	} 
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',12);
  $pdf->SetAutoPageBreak(true, 10);  
  $texto="YO, ".$nombre." RIF ".$ced_rif.", HE RECIBIDO DE LA TESORERÍA DE LA CORPORACIÓN DE SALUD LA SUMA DE ".$monto_letras." (BS.  ".$total_neto.").  POR EL CONCEPTO SIGUIENTE: ".$concepto." (O/P No. ".$nro_orden.")";
  $pdf->Cell(10);
  $pdf->MultiCell(170,6,$texto,0);
  $pdf->Ln(15);
  $pdf->Cell(200,5,$lugar,0,1,'C');
  
  $pdf->Ln(25);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(70,5,' Firma del beneficiario','T',0,'C');
  $pdf->Cell(60,5,'',0,0,'C');
  $pdf->Cell(70,5,' Firma y Sello Jefe Inmediato','T',1,'C');
  $pdf->Output();

pg_close();
?>
