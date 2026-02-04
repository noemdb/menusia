<?php include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){ $referencia_comp=''; $tipo_compromiso=''; $cod_comp='';}
 else { $nro_orden = $_GET["txtnro_orden"]; $tipo_compromiso = $_GET["txttipo_compromiso"]; $cod_comp = $tipo_compromiso;}

$rif_emp="G-20000831-8"; $flete="NUESTRO CARGO";   $direccion_emp="CALLEJON LA MOSCA ENTRE AV CEDE�O Y YARACUY";
$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$sql="Select * from ORD_SERVICIO where tipo_compromiso='$tipo_compromiso' and nro_orden='$nro_orden'";
$fecha_orden=""; $unidad_solicitante=""; $tipo_documento=""; $nro_documento=""; $rif_proveedor=""; $nro_solicitud=""; $inf_canc=""; $nombre_abrev_comp=""; $nombre=""; $des_fuente_financ=""; $concepto="";
$fecha_solicitud=""; $tiempo_entrega=""; $lugar_entrega=""; $direccion_entrega=""; $operacion=""; $dias_credito=""; $afecta_presupuesto=""; $fuente_financ=""; $anulado=""; $fecha_anulado=""; $cancelada="";
$fecha_cancelacion=""; $nro_ord_pago=""; $cant_servicio=""; $redondeo_total=""; $redondeo_impuesto=""; $aplica_impuesto=""; $cod_presup_imp=""; $tasa_flete=""; $monto_flete=""; $cod_presup_flete=""; $des_unidad_sol="";
$tasa_otros=""; $monto_otros=""; $cod_presup_otros=""; $tasa_imp1=""; $monto_obj_imp1=""; $cod_presup_imp1=""; $tasa_imp2=""; $monto_obj_imp2=""; $cod_presup_imp2=""; $tasa_imp3=""; $monto_obj_imp3=0; $cod_presup_imp3="";
$status=""; $fecha_vencim=""; $nro_cod_pre=""; $campo_str1=""; $campo_str2=""; $campo_num1=0; $campo_num2=0; $aprobado=""; $fecha_aprobada=""; $usuario_sia_aprueba=""; $nro_expediente=""; $usuario_sia_ord=""; $inf_usuario="";
$rnc=""; $nil=""; $sunacoop=""; $monto=0; 
$res=pg_query($sql); $filas=pg_num_rows($res);  $direccion="";  $telefono="";
if($filas>0){$registro=pg_fetch_array($res);
  $nro_orden=$registro["nro_orden"];  $tipo_compromiso=$registro["tipo_compromiso"];   $fecha_orden=$registro["fecha_orden"]; $nombre_abrev_comp=$registro["nombre_abrev_comp"]; $nombre=$registro["nombre"]; $concepto=$registro["concepto"];
  $unidad_solicitante=$registro["unidad_solicitante"]; $tipo_documento=$registro["tipo_documento"]; $nro_solicitud=$registro["nro_solicitud"]; $fecha_solicitud=$registro["fecha_solicitud"]; $des_unidad_sol=$registro["denominacion_cat"];
  $nro_documento=$registro["nro_documento"]; $rif_proveedor=$registro["rif_proveedor"];  $tiempo_entrega=$registro["tiempo_entrega"]; $lugar_entrega=$registro["lugar_entrega"];  $direccion_entrega=$registro["direccion_entrega"];  $operacion=$registro["operacion"]; $dias_credito=$registro["dias_credito"];
  $afecta_presupuesto=$registro["afecta_presupuesto"]; $fuente_financ=$registro["fuente_financ"]; $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $cancelada=$registro["cancelada"];
  $fecha_cancelacion=$registro["fecha_cancelacion"]; $nro_ord_pago=$registro["nro_ord_pago"]; $cant_servicio=$registro["cant_servicio"]; $redondeo_total=$registro["redondeo_total"]; $redondeo_impuesto=$registro["redondeo_impuesto"]; $aplica_impuesto=$registro["aplica_impuesto"];
  $cod_presup_imp=$registro["cod_presup_imp"]; $tasa_flete=$registro["tasa_flete"]; $monto_flete=$registro["monto_flete"]; $cod_presup_flete=$registro["cod_presup_flete"]; $monto_obj_imp3=$registro["monto_obj_imp3"]; $status=$registro["status"]; $fecha_vencim=$registro["fecha_vencim"];
  $campo_num1=$registro["campo_num1"]; $campo_num2=$registro["campo_num2"]; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];
  $aprobado=$registro["aprobado"]; $fecha_aprobada=$registro["fecha_aprobada"]; $usuario_sia_aprueba=$registro["usuario_sia_aprueba"]; $nro_expediente=$registro["nro_expediente"]; $usuario_sia_ord=$registro["usuario_sia"];$inf_usuario=$registro["inf_usuario"];
}
if($fecha_orden==""){$fecha_orden="";}else{$fecha_orden=formato_ddmmaaaa($fecha_orden);} $flete=$campo_str1;
if($fecha_solicitud==""){$fecha_solicitud="";}else{$fecha_solicitud=formato_ddmmaaaa($fecha_solicitud);}
if($fecha_vencim==""){$fecha_vencim="";}else{$fecha_vencim=formato_ddmmaaaa($fecha_vencim);}
If($operacion=="C"){ $operacion="CREDITO";}else{ $operacion="CONTADO";} if($aplica_impuesto=="S"){$aplica_impuesto="SI";}else{$aplica_impuesto="NO";}
$Ssql="Select * from COMPROMISOS where tipo_compromiso='$tipo_compromiso' and referencia_comp='$nro_orden'" ;
$resultado=pg_query($Ssql); $filasp=pg_num_rows($resultado);$cod_comp="";$func_inv="";$tiene_anticipo="";$tasa_anticipo="";$cod_con_anticipo="";
if($filasp>0){$reg=pg_fetch_array($resultado);$cod_comp=$reg["cod_comp"]; $func_inv=$reg["func_inv"]; $tiene_anticipo=$reg["tiene_anticipo"]; $tasa_anticipo=$reg["tasa_anticipo"]; $cod_con_anticipo=$reg["cod_con_anticipo"]; }
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="C"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
if($tiene_anticipo=="S"){$tiene_anticipo="SI";}else{$tiene_anticipo="NO";} $clave=$nro_orden.$tipo_compromiso.$cod_comp;
$total_orden=$monto_obj_imp3+$campo_num2; $c_num1=$campo_num1; $c_num2=$campo_num2; $total_orden=formato_monto($total_orden); $campo_num1=formato_monto($campo_num1); $campo_num2=formato_monto($campo_num2);
If($operacion=="C"){ $forma_pago="CREDITO";}else{ $forma_pago="CONTADO";} if($dias_credito>0){ $forma_pago=$dias_credito." DIAS";}
$clave=$tipo_compromiso.$nro_orden.$cod_comp;

$monto_letras=monto_letras($total_orden); 

$sql="Select * from pre002 WHERE tipo_compromiso='$tipo_compromiso'";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);$nombre_tipo_comp=$registro["nombre_tipo_comp"]; }
$sql="Select * from COMP005 WHERE ced_rif='$rif_proveedor'";$res=pg_query($sql);$filas=pg_num_rows($res); $fax=""; $direccion="";  $telefono="";
if($filas>0){  $registro=pg_fetch_array($res); $nombre=$registro["nombre_proveedor"]; $direccion=substr($registro["direccion_proveedor"],0,90);  $telefono=substr($registro["telefono_proveedor"],0,12); $fax=$registro["fax_proveedor"]; $rnc=$registro["nro_ocei"]; $nil=$registro["nro_otro1"]; $sunacoop=$registro["nro_otro2"]; }
$sql="select * from sia001 where campo101='$usuario_sia_ord'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nombre_usuario=$registro["campo104"];}


$sqlc="select * from codigos_compromisos where referencia_comp='$nro_orden' and tipo_compromiso='$tipo_compromiso' and cod_comp='$cod_comp' order by cod_presup"; $res=pg_query($sql); $filas=pg_num_rows($res);
$resc=pg_query($sqlc); $filas=pg_num_rows($resc); $cant_cod_presup=$filas; $max_cpre=10; $k=0;
$cod_p=array ('','','','','','','','','','','','','','',''); $fuen_p=array ('','','','','','','','','','','','','','','');
$den_p=array ('','','','','','','','','','','','','','',''); $monto_p=array ('','','','','','','','','','','','','','','');
while($registro=pg_fetch_array($resc)){ $montoc=formato_monto($registro["monto"]);   $denominacion=$registro["denominacion"]; if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}
 $cod_p[$k]=$registro["cod_presup"]; $den_p[$k]=$denominacion; $fuen_p[$k]=$registro["fuente_financ"]; $monto_p[$k]=$montoc; if($k<15){$k=$k+1;}} $h=$k;
$sql="SELECT * FROM ser_ord_servicio where nro_orden='$nro_orden' and tipo_compromiso='$tipo_compromiso' order by nro_linea"; $res=pg_query($sql); $filas=pg_num_rows($res); $cant_tot_art=$filas; $pag_act=1; $pag_hasta=1; $max_art_pag=25; 

$nro_art_ant=0; $sub_total=0; $total_impuesto=0; $total_orden=0; $tasa_impuesto=0; $sub_total_iva=0; 
if($php_os=="WINNT"){$concepto=$concepto;}else{$concepto=utf8_decode($concepto); $nombre=utf8_decode($nombre);  $des_unidad_sol=utf8_decode($des_unidad_sol); }	
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $nro_orden; global $des_unidad_sol; global $fecha_orden; global $nombre; global $rif_proveedor; 
	   global $concepto; global $tipo_compromiso; global $unidad_solicitante; global $php_os; global $rnc; global $direccion; 
	   global $nil; global $sunacoop; global $forma_pago; global $telefono; global $direccion_entrega; global $func_inv; global $nro_solicitud;
	    $dir_e=substr($direccion,0,97);
        $this->rect(10,5,200,260);		
		$this->Image('../../imagenes/logo escudo.png',12,8,13);
		$this->SetFont('Arial','B',9);
		$this->Cell(25);
		$this->Cell(100,3,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,1,'L');		
		$this->Cell(25);
		$this->Cell(80,3,'AGUAS DE YARACUY C.A.',0,0,'L');
		$this->SetFont('Arial','B',12);
		$this->Cell(55,3,'ORDEN DE SERVICIO',0,0,'C');			   
		$this->Cell(18,3,'N� '.$nro_orden,0,1,'C');
		$this->SetFont('Arial','B',9);
		$this->Cell(25);
		$this->Cell(75,3,'COORDINACION DE COMPRAS',0,1,'L');
		$this->Line(110,5,110,20);
		$this->SetFont('Arial','B',7);
		$this->Cell(100);
        $this->SetFillColor(192,192,192);
		$this->Cell(35,3,'RIF',1,0,'C',true);
		$this->Cell(35,3,'FECHA',1,0,'C',true);	
		$this->Cell(30,3,'PAGINA',1,1,'C',true);
		$this->SetFont('Arial','',8);
		$this->Cell(100);
		$this->Cell(35,4,"G-20000831-8",1,0,'C');
		$this->Cell(35,4,$fecha_orden,1,0,'C');
		$this->Cell(30,4,$this->PageNo(),1,1,'C');
		$this->SetFont('Arial','B',7);
		$this->Cell(140,3,'NOMBRE O RAZON SOCIAL DEL PROVEEDOR',1,0,'C',true);
		$this->Cell(30,3,'RIF/CEDULA',1,0,'C',true);
		$this->Cell(30,3,'RNC',1,1,'C',true);
		$this->SetFont('Arial','',8);
		$nombre=utf8_decode($nombre);
		$direccion_entrega=utf8_decode($direccion_entrega);
		$dir_e=utf8_decode($dir_e);
		$concepto=utf8_decode($concepto);
		$this->Cell(140,4,$nombre,1,0,'C');
		$this->Cell(30,4,$rif_proveedor,1,0,'C');
		$this->Cell(30,4,$rnc,1,1,'C');
		$this->SetFont('Arial','B',7);
		$this->Cell(20,3,'NIL',1,0,'C',true);
		$this->Cell(20,3,'SUNACOOP',1,0,'C',true);
		$this->Cell(160,3,'DIRECCION',1,1,'C',true);
		$this->SetFont('Arial','',8);
		$this->Cell(20,4,$nil,1,0,'C');
		$this->Cell(20,4,$sunacoop,1,0,'C');
		$this->Cell(160,4,$dir_e,1,1,'C');
		$this->SetFont('Arial','B',7);
		$this->Cell(20,3,'TELEFONO',1,0,'C',true);
		$this->Cell(30,3,'FORMA DE PAGO',1,0,'C',true);
		$this->Cell(150,3,'UNIDAD SOLICITANTE',1,1,'C',true);
		$this->SetFont('Arial','',8);
		$this->Cell(20,4,$telefono,1,0,'C');
		$this->Cell(30,4,$forma_pago,1,0,'C');
		$this->Cell(150,4,$des_unidad_sol,1,1,'C');
		$this->SetFont('Arial','B',7);
		$this->Cell(135,3,'SERVICIO PRESTADO A',1,0,'C',true);
		$this->Cell(40,3,'CLASIFICACION DEL GASTO',1,0,'C',true);
		$this->Cell(25,3,'N� DE SOLICITUD',1,1,'C',true);
		$this->SetFont('Arial','',8);
		$this->Cell(135,4,$direccion_entrega,1,0,'C');
		$this->Cell(40,4,$func_inv,1,0,'C');
		$this->Cell(25,4,$nro_solicitud,1,1,'C');
		$this->MultiCell(200,3,'POR CONCEPTO DE: '.$concepto,0);
		$this->Cell(200,2,' ',0,1,'C');		
		$y=$this->GetY(); $x=$y;		
		$this->Line(10,$y-0.2,210,$y-0.2);		
		$this->SetFont('Arial','',7);		
		$this->Cell(30,3,'PARTIDA',0,0,'C',true);		
		$this->Cell(100,3,' ',0,0,'C',true);
		$this->Cell(20,3,'CANTIDAD',0,0,'C',true);
		$this->Cell(20,3,'PRECIO',0,0,'C',true);
		$this->Cell(29.8,3,' ',0,1,'C',true);		
		$this->Cell(30,3,'PRESUPUESTARIA',0,0,'C',true);	
		$this->Cell(100,3,'DESCRIPCION',0,0,'C',true);
		$this->Cell(20,3,'SOLICITADA',0,0,'C',true);
		$this->Cell(20,3,'UNITARIO',0,0,'C',true);
		$this->Cell(29.8,3,'TOTAL',0,1,'C',true);	
		$y=$this->GetY();		
		$this->Line(10,$y+0.1,210,$y+0.1);
		$this->Line(10,$x-0.1,10,189);
		$this->Line(40,$x,40,189);	
        $this->Line(140,$x,140,202);	
        $this->Line(160,$x,160,189);
        $this->Line(180,$x,180,189);		
    }
	function Footer(){ global $sub_total; global $total_impuesto; global $total_orden; global $tasa_impuesto; global $total_servicio; global $t_serv;
	    global $c_num1; global $c_num2; global $cant_cod_presup; global $max_cpre; global $sub_total_iva;
		global $cod_p; global $den_p; global $fuen_p;  global $monto_p;		global $monto_letras;
		$stotal=$sub_total; $itotal=$sub_total_iva;
	    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $dif=$c_num1-$stotal; $des_total=""; $c_linea=0; $des_total=""; 	
		if($dif>0.01){$imp_t="N";}else{ $des_total="TOTAL BS."; $imp_t="S"; }
		//if($dif>0.01){$imp_t="N";}else{ $des_total="TOTAL BS."; $imp_t="S"; $stotal=$c_num1; $total_impuesto=$c_num2; }
		$t_orden=$stotal+$total_impuesto;
		$stotal=formato_monto($stotal); $total_impuesto=formato_monto($total_impuesto); 
		$t_orden=formato_monto($t_orden); $itotal=formato_monto($itotal); 
		$this->SetY(-90); $y=$this->GetY(); $l=$y-0.2; $p=$y+12.1;
		$this->SetFont('Arial','B',7);
		$this->Line(10,$l,210,$l);		
		$this->Cell(40,4,'POR LA CANTIDAD DE:',0,0,'L');
		$this->Cell(140,4,$imp_t.'UB-TOTAL BS.',0,0,'R');
		//echo "<script language='JavaScript'> alert($sub_total);</script>";
		$this->Cell(19.8,4,$stotal,0,1,'R');
        if($imp_t=="S"){	
		$part1=$monto_letras; $l=strlen($part1); if($l>80){$part1=substr($monto_letras,0,80); $part2=substr($monto_letras,81,80); }
        $this->Cell(125,4,$part1,0,0);        		
		$this->Cell(55,4,'IVA '.$tasa_impuesto."% SOBRE ". $t_serv,0,0,'R');
		$this->Cell(19.8,4,$total_impuesto,0,1,'R');
		
		$this->Cell(125,4,$part2,0,0);
		$this->Cell(55,4,$des_total,0,0,'R');
		$this->Cell(19.8,4,$t_orden,0,1,'R');
		
		
	
		}else{ $this->Cell(180,8,$dif,0,1,'R');
		}
		
        $this->Line(10,$p,210,$p);			
		$this->SetFont('Arial','',7);
		$this->SetFillColor(192,192,192);
		$this->Cell(200,3,'CONTABILIDAD PRESUPUESTARIA',1,1,'C',true);		
		$this->Cell(40,3,'CODIGO',1,0,'C',true);
		$this->Cell(140,3,'DENOMINACION',1,0,'C',true);
		$this->Cell(20,3,'MONTO',1,1,'C',true);
		$z=$this->GetY();
		if($cant_cod_presup>$max_cpre){ $l=$max_cpre*3; $m=($l/2)-3;
		   $this->Ln($m);
		   $this->Cell(180,3,'VER RELACION ANEXA',0,1,'C');
		   $this->Ln($m);
		}else{ for ($k=0; $k<$max_cpre; $k++) {  
		  $this->Cell(40,3,$cod_p[$k],0,0,'L'); 
	      $this->Cell(140,3,$den_p[$k],0,0,'L'); 					
	      $this->Cell(20,3,$monto_p[$k],0,1,'R'); 
		} }
		$y=$this->GetY();
        $this->Line(50,$z,50,$y-0.1);
		$this->Line(190,$z,190,$y-0.1);			
        $this->Cell(160,3,'FIRMAS AUTORIZADAS',1,0,'C',true);		
		$this->Cell(39.8,3,'',0,1,'C',true);		
		$this->Line(10,$y-0.1,210,$y-0.1);		
		$this->Cell(40,3,'REVISADO',1,0,'C',true);
		$this->Cell(40,3,'CONFORMADO',1,0,'C',true);
		$this->Cell(40,3,'TRAMITADO',1,0,'C',true);
		$this->Cell(40,3,'APROBADO',1,0,'C',true);
		$this->Cell(39.8,3,'PROVEEDOR',0,1,'C',true);
		$z=$this->GetY();
        $this->Line(10,$z-0.1,210,$z-0.1);		
		$this->SetFont('Arial','',5);
		$this->Cell(200,12,' ',0,1,'C');		
		$this->Cell(40,3,'',0,0,'C');	
        $this->Cell(40,3,'',0,0,'C');
        $this->Cell(40,3,'',0,0,'C');
        $this->Cell(40,3,'',0,1,'C');		
		$this->Cell(40,3,'',0,0,'C');	
        $this->Cell(40,3,'',0,0,'C');
        $this->Cell(40,3,'',0,0,'C');
        $this->Cell(40,3,'',0,0,'C');
        $this->Cell(40,3,'FIRMA Y SELLO',0,1,'C');		
        $this->Cell(40,3,'JEFE DE COMPRAS',0,0,'C');	
        $this->Cell(40,3,'JEFE DE PRESUPUESTO',0,0,'C');
        $this->Cell(40,3,'GTE. ADMINISTRATIVO',0,0,'C');
        $this->Cell(40,3,'PRESIDENTE',0,0,'C');
        $this->Cell(40,3,'FECHA:',0,1,'L');		
		$x=$this->GetY()+0.5;
		$this->Line(50,$z,50,$x);	
		$this->Line(90,$z,90,$x);	
		$this->Line(130,$z,130,$x);
		$this->Line(170,$y,170,$x);			
		$this->SetFillColor(255,0,0);
		$this->Ln(2);
		$this->SetFont('Arial','',5);
		//$this->Cell(100,4,'NOTA: ARTICULOS CON (*) APLICAN IMPUESTO',0,0,'L');
		$this->Cell(200,4,'SIPAP COMPRAS Y ALMACEN',0,1,'R');
	} 
		
}
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',6);
  $pdf->SetAutoPageBreak(true, 90);  
  $i=0;  $res=pg_query($sql);$filas=pg_num_rows($res);
  while($registro=pg_fetch_array($res)){ $i=$i+1;  
    $denominacion=$registro["concepto_linea"]; $unidad_medida=$registro["unidad_medida"]; 	
	$total_servicio=$registro["cantidad"]*$registro["monto"]; $t_serv=formato_monto($total_servicio);
	$sub_total=$sub_total+$total_servicio; $cant_servicio=$registro["cantidad"];	
	//echo "<script language='JavaScript'> alert($sub_total);</script>";
	$monto=$registro["monto"]; $tasa_impuesto=$registro["tasa_impuesto"];
	$imp_art=$cant_servicio*$monto*($tasa_impuesto/100); $total_impuesto=$total_impuesto+$imp_art;	
	$cant_servicio=formato_monto($cant_servicio); $monto=formato_monto($monto);
	$total_servicio=formato_monto($total_servicio);	
	if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}
	if($tasa_impuesto>0){$denominacion=$denominacion; $sub_total_iva=$sub_total_iva+$total_servicio;}
	$pdf->Cell(30,3,$registro["cod_partida"],0,0,'C');
	$x=$pdf->GetX();   $y=$pdf->GetY();  $w=100;		   
	$pdf->SetXY($x+$w,$y);	
	//$pdf->Cell(15,3,$unidad_medida,0,0,'C');
	$pdf->Cell(20,3,$cant_servicio,0,0,'R');
	$pdf->Cell(20,3,$monto,0,0,'R');
	$pdf->Cell(30,3,$total_servicio,0,0,'R');  
	$pdf->SetXY($x,$y);	
	$pdf->MultiCell($w,3,$denominacion,0); 
  }	
  $pdf->Output();
  pg_close($conn);
?>
