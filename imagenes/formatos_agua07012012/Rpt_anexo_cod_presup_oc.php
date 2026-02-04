<?php include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){ $nro_orden="";$tipo_compromiso=""; } else{$nro_orden=$_GET["txtnro_orden"];  $tipo_compromiso=$_GET["txttipo_compromiso"];}
$sql="Select * from ORD_COMPRA where tipo_compromiso='$tipo_compromiso' and nro_orden='$nro_orden'";
$rif_emp="G-20009014-6";
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$fecha_orden=""; $unidad_solicitante=""; $tipo_documento=""; $nro_documento=""; $rif_proveedor=""; $nro_requisicion=""; $inf_canc=""; $nombre_abrev_comp=""; $nombre=""; $des_fuente_financ=""; $concepto="";
$fecha_requisicion=""; $tiempo_entrega=""; $lugar_entrega=""; $direccion_entrega=""; $operacion=""; $dias_credito=""; $afecta_presupuesto=""; $fuente_financ=""; $anulado=""; $fecha_anulado=""; $cancelada="";
$fecha_cancelacion=""; $nro_ord_pago=""; $cant_articulo=""; $redondeo_total=""; $redondeo_impuesto=""; $aplica_impuesto=""; $cod_presup_imp=""; $tasa_flete=""; $monto_flete=""; $cod_presup_flete=""; $des_unidad_sol="";
$tasa_otros=""; $monto_otros=""; $cod_presup_otros=""; $tasa_imp1=""; $monto_obj_imp1=""; $cod_presup_imp1=""; $tasa_imp2=""; $monto_obj_imp2=""; $cod_presup_imp2=""; $tasa_imp3=""; $monto_obj_imp3=""; $cod_presup_imp3="";
$status=""; $fecha_vencim=""; $nro_cod_pre=""; $campo_str1=""; $campo_str2=""; $campo_num1=0; $campo_num2=0; $aprobado=""; $fecha_aprobada=""; $usuario_sia_aprueba=""; $nro_expediente=""; $usuario_sia_ord=""; $inf_usuario="";
$rnc=""; $nil=""; $sunacoop=""; $costo=0; $total_articulo=0;
$res=pg_query($sql); $filas=pg_num_rows($res);  $direccion="";  $telefono="";

if($filas>0){  $registro=pg_fetch_array($res); $nro_orden=$registro["nro_orden"];   $tipo_compromiso=$registro["tipo_compromiso"];
  $nro_orden=$registro["nro_orden"];  $tipo_compromiso=$registro["tipo_compromiso"];   $fecha_orden=$registro["fecha_orden"]; $nombre_abrev_comp=$registro["nombre_abrev_comp"]; $nombre=$registro["nombre"]; $concepto=$registro["concepto"];
  $unidad_solicitante=$registro["unidad_solicitante"]; $tipo_documento=$registro["tipo_documento"]; $nro_requisicion=$registro["nro_requisicion"]; $fecha_requisicion=$registro["fecha_requisicion"]; $des_unidad_sol=$registro["denominacion_cat"];
  $nro_documento=$registro["nro_documento"]; $rif_proveedor=$registro["rif_proveedor"];  $tiempo_entrega=$registro["tiempo_entrega"]; $lugar_entrega=$registro["lugar_entrega"];  $direccion_entrega=$registro["direccion_entrega"];  $operacion=$registro["operacion"]; $dias_credito=$registro["dias_credito"];
  $afecta_presupuesto=$registro["afecta_presupuesto"]; $fuente_financ=$registro["fuente_financ"]; $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $cancelada=$registro["cancelada"];
  $fecha_cancelacion=$registro["fecha_cancelacion"]; $nro_ord_pago=$registro["nro_ord_pago"]; $cant_articulo=$registro["cant_articulo"]; $redondeo_total=$registro["redondeo_total"]; $redondeo_impuesto=$registro["redondeo_impuesto"]; $aplica_impuesto=$registro["aplica_impuesto"];
  $cod_presup_imp=$registro["cod_presup_imp"]; $tasa_flete=$registro["tasa_flete"]; $monto_flete=$registro["monto_flete"]; $cod_presup_flete=$registro["cod_presup_flete"]; $status=$registro["status"]; $fecha_vencim=$registro["fecha_vencim"];
  $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"]; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];
  $aprobado=$registro["aprobado"]; $fecha_aprobada=$registro["fecha_aprobada"]; $usuario_sia_aprueba=$registro["usuario_sia_aprueba"]; $nro_expediente=$registro["nro_expediente"]; $usuario_sia_ord=$registro["usuario_sia"];$inf_usuario=$registro["inf_usuario"];
} 

if($fecha_orden==""){$fecha_orden="";}else{$fecha_orden=formato_ddmmaaaa($fecha_orden);} $flete=$campo_str1;
if($fecha_requisicion==""){$fecha_requisicion="";}else{$fecha_requisicion=formato_ddmmaaaa($fecha_requisicion);}
if($fecha_vencim==""){$fecha_vencim="";}else{$fecha_vencim=formato_ddmmaaaa($fecha_vencim);}
If($operacion=="C"){ $operacion="CREDITO";}else{ $operacion="CONTADO";} if($aplica_impuesto=="S"){$aplica_impuesto="SI";}else{$aplica_impuesto="NO";}
$Ssql="Select * from COMPROMISOS where tipo_compromiso='$tipo_compromiso' and referencia_comp='$nro_orden'" ;
$resultado=pg_query($Ssql); $filasp=pg_num_rows($resultado);$cod_comp="";$func_inv="";$tiene_anticipo="";$tasa_anticipo="";$cod_con_anticipo="";
if($filasp>0){$reg=pg_fetch_array($resultado);$cod_comp=$reg["cod_comp"]; $func_inv=$reg["func_inv"]; $tiene_anticipo=$reg["tiene_anticipo"]; $tasa_anticipo=$reg["tasa_anticipo"]; $cod_con_anticipo=$reg["cod_con_anticipo"]; }
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="C"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
if($tiene_anticipo=="S"){$tiene_anticipo="SI";}else{$tiene_anticipo="NO";} $clave=$nro_orden.$tipo_compromiso.$cod_comp;
$total_orden=$campo_num1+$campo_num2; $c_num1=$campo_num1; $c_num2=$campo_num2; $total_orden=formato_monto($total_orden); $campo_num1=formato_monto($campo_num1); $campo_num2=formato_monto($campo_num2);
If($operacion=="C"){ $forma_pago="CREDITO";}else{ $forma_pago="CONTADO";} if($dias_credito>0){ $forma_pago=$dias_credito." DIAS";}
$clave=$tipo_compromiso.$nro_orden.$cod_comp;

$monto_letras=monto_letras($total_orden); 

$sql="Select * from pre002 WHERE tipo_compromiso='$tipo_compromiso'";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);$nombre_tipo_comp=$registro["nombre_tipo_comp"]; }
$sql="Select * from COMP005 WHERE ced_rif='$rif_proveedor'";$res=pg_query($sql);$filas=pg_num_rows($res); $fax=""; $direccion="";  $telefono="";
if($filas>0){  $registro=pg_fetch_array($res); $nombre=$registro["nombre_proveedor"]; $direccion=$registro["direccion_proveedor"];  $telefono=$registro["telefono_proveedor"]; $fax=$registro["fax_proveedor"]; $rnc=$registro["nro_ocei"]; $nil=$registro["nro_otro1"]; $sunacoop=$registro["nro_otro2"]; }
$sql="select * from sia001 where campo101='$usuario_sia_ord'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nombre_usuario=$registro["campo104"];}


require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header() {global $nro_orden; global $des_unidad_sol; global $fecha_orden; global $nombre; global $rif_proveedor; 
	   global $concepto; global $tipo_compromiso; global $unidad_solicitante; global $php_os; global $rnc; global $direccion; 
	   global $nil; global $sunacoop; global $forma_pago; global $telefono; global $direccion_entrega; global $func_inv; global $nro_requisicion;
	    $dir_e=substr($direccion,0,97);
        $this->rect(10,5,200,260);		
		$this->Image('../../imagenes/logo escudo.png',12,8,13);
		$this->SetFont('Arial','B',9);
		$this->Cell(25);
		$this->Cell(100,3,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,1,'L');		
		$this->Cell(25);
		$this->Cell(100,3,'GOBERNACION DEL ESTADO YARACUY',0,1,'L');
		$this->Cell(25);
		$this->Cell(100,3,'COORDINACION DE COMPRAS',0,1,'L');
		$this->Ln(4);
		$this->SetFont('Arial','B',12);
		$this->Cell(200,3,'RELACION ANEXA ORDEN DE COMPRA N� '.$nro_orden,0,1,'C');		
        $this->Ln(2);		
		$this->SetFont('Arial','B',9);
		$this->Cell(180,3,'FECHA: ',0,0,'R');
		$this->Cell(20,3,$fecha_orden,0,1,'R');
		$this->Ln(2);		
		$this->Cell(200,3,' ',0,1,'C');
		$this->SetFont('Arial','B',12);
        $this->Cell(200,5,'CONTABILIDAD PRESUPUESTARIA',1,1,'C');		
		$this->SetFont('Arial','',7);
		$this->Cell(15,3,'Compromiso',1,0,'C');
		$this->Cell(7,3,'Doc.',1,0,'C');
		$this->Cell(38,3,'Codigo Presupuestario',1,0,'C');
		$this->Cell(110,3,'Denominacion',1,0,'C');		
		$this->Cell(30,3,'Monto',1,1,'C');		 
	}
	
	function Footer(){$ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		$this->SetY(-10);		
        $this->SetFillColor(255,0,0);
		$this->Ln(5);
		$this->SetFont('Arial','I',5);
		$this->Cell(50,4,'SIPAP Compras, Almacen y Servicios',0,0,'L');
		$this->Cell(50,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
		$this->Cell(100,5,'fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
	} 
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $pdf->SetAutoPageBreak(true, 10);  
  $i=0;  

  $total_pre=0; 
  $sql="select * from codigos_compromisos where referencia_comp='$nro_orden' and tipo_compromiso='$tipo_compromiso' and cod_comp='$cod_comp' order by cod_presup"; $res=pg_query($sql); $filas=pg_num_rows($res);
  while(($registro=pg_fetch_array($res))and($error==0)){ $monto=formato_monto($registro["monto"]); $total=$total+$registro["monto"]; $denominacion=$registro["denominacion"];
    $denominacion=substr($denominacion,0,80); if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}

    $pdf->Cell(15,3,$registro["referencia_comp"],0,0,'L'); 
	$pdf->Cell(7,3,$registro["tipo_compromiso"],0,0,'L'); 
	$pdf->Cell(38,3,$registro["cod_presup"],0,0,'L');	
    $pdf->Cell(110,3,$denominacion,0,0,'L'); 		  
	$pdf->Cell(30,3,$monto,0,1,'R');
    $total_pre=$total_pre+$registro["monto"];
   

  }
  $total_pre=formato_monto($total_pre);
  $pdf->Cell(200,2,'',0,1,'R');
  $y=$pdf->GetY();
  $pdf->Line(185,$y-0.2,210,$y-0.2);
  $pdf->Cell(175,3,'TOTAL COMPROMISO Bs.',0,0,'R');
  $pdf->Cell(25,3,$total_pre,0,1,'R');
 $pdf->Output();
 pg_close($conn);
?>

