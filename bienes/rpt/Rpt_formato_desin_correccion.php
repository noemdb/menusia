<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){ $cod_bien_mue=""; } else{$cod_bien_mue=$_GET["Gcod_bien_mue"];}

$sql="Select * from BIEN055 where cod_bien_mue='$cod_bien_mue' ";

$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$rif_emp=""; $nom_completo=""; $direccion="";
$sqle="Select * from SIA000 order by campo001"; $resultado=pg_query($sqle);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"];
$direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
$tipo_desin='066'; $des_desin="CORRECCION DE INCORPORACIONES";
$cod_bien_mue=""; $cod_clasificacion=""; $num_bien="";$denominacion=""; $cod_dependencia=""; $cod_empresa=""; $cod_direccion=""; $cod_departamento=""; $ced_responsable=""; $fecha_actualizacion=""; $denomina_tipo="";
$ced_responsable_uso="";$cod_metodo_rot="";$ced_rotulador=""; $fecha_rotulacion="";$direccion=""; $cod_region=""; $cod_entidad=""; $cod_municipio=""; $cod_ciudad=""; $cod_parroquia=""; $cod_postal="";$caracteristicas="";$marca="";  $modelo="";$color="";$matricula="";$serial1="";$serial2="";$tipo_clase="";$uso="";$dimension_tam="";$material="";$codigo_alterno="";$ano=""; $antiguedad="";$cod_contablea="";$cod_contabled="";$tipo_depreciacion="";$tasa_deprec=""; $vida_util=""; $valor_residual=""; $sit_contable="";$sit_legal=""; $edo_conservacion="";$ced_verificador=""; $fecha_verificacion=""; $tipo_incorporacion=""; $cod_imp_presup=""; $nom_imp_presup="";$des_imp_nopresup=""; $fecha_incorporacion=""; $valor_incorporacion="";$garantia="";$nro_oc=""; $fecha_oc=""; $nro_op=""; $fecha_op=""; $tipo_doc_cancela=""; $nro_doc_cancela=""; $fecha_doc_cancela="";$ced_rif_proveedor=""; $codigo_tipo_incorp=""; $nom_proveedor=""; $cod_presup_dep=""; $monto_depreciado=""; $nro_factura=""; $fecha_factura=""; $desincorporado=""; $fecha_desincorporado="";$des_desincorporado="";$bien_en_salida="";$status_bien_inm=""; $usuario_sia=""; $inf_usuario="";$accesorios="";  $descripcion_b="";  $denominacion_empresa=""; $denominacion_dependencia=""; $denominacion_dir="";$denominacion_dep="";  $nombre_res="";  $nombre_res_uso="";  $metodo_rotula="";  $nombre_res_rotu="";$nombre_region="";  $estado="";  $nombre_municipio=""; $nombre_ciudad="";  $nombre_parroquia=""; $tipo_situacion_cont="";  $tipo_situacion_legal=""; $edo_bien="";  $nombre_res_ver="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){  if ($p_letra=="S"){$sql="SELECT * From BIEN055 ORDER BY cod_bien_mue";}  if ($p_letra=="A"){$sql="SELECT * From BIEN055 ORDER BY cod_bien_mue desc";}  $res=pg_query($sql);  $filas=pg_num_rows($res);}
if($filas>=1){  $registro=pg_fetch_array($res,0);
  $cod_bien_mue=$registro["cod_bien_mue"];  $cod_clasificacion=$registro["cod_clasificacion"];  $num_bien=$registro["num_bien"];
  $denominacion=$registro["denominacion"];   $cod_dependencia=$registro["cod_dependencia"];   $cod_empresa=$registro["cod_empresa"]; 
  $cod_direccion=$registro["cod_direccion"];  $cod_departamento=$registro["cod_departamento"];   $ced_responsable=$registro["ced_responsable"];
  $fecha_actualizacion=$registro["fecha_actualizacion"];  if($fecha_actualizacion==""){$fecha_actualizacion="";}else{$fecha_actualizacion=formato_ddmmaaaa($fecha_actualizacion);}
  $ced_responsable_uso=$registro["ced_responsable_uso"];  $cod_metodo_rot=$registro["cod_metodo_rot"];  $ced_rotulador=$registro["ced_rotulador"];
  $fecha_rotulacion=$registro["fecha_rotulacion"];if($fecha_rotulacion==""){$fecha_rotulacion="";}else{$fecha_rotulacion=formato_ddmmaaaa($fecha_rotulacion);}
  $direccion=$registro["direccion"];   $cod_region=$registro["cod_region"];   $cod_entidad=$registro["cod_entidad"];
  $cod_municipio=$registro["cod_municipio"];   $cod_ciudad=$registro["cod_ciudad"];   $cod_parroquia=$registro["cod_parroquia"]; 
  $cod_postal=$registro["cod_postal"];  $caracteristicas=$registro["caracteristicas"];  $marca=$registro["marca"];
  $modelo=$registro["modelo"];  $color=$registro["color"];  $matricula=$registro["matricula"];
  $serial1=$registro["serial1"];  $serial2=$registro["serial2"];  $tipo_clase=$registro["tipo_clase"];
  $uso=$registro["uso"];  $dimension_tam=$registro["dimension_tam"];   $material=$registro["material"]; 
  $codigo_alterno=$registro["codigo_alterno"];   $ano=$registro["ano"];   $antiguedad=$registro["antiguedad"]; 
  $cod_contablea=$registro["cod_contablea"];   $cod_contabled=$registro["cod_contabled"];   $tipo_depreciacion=$registro["tipo_depreciacion"]; 
  $tasa_deprec=$registro["tasa_deprec"];   $vida_util=$registro["vida_util"];  $valor_residual=$registro["valor_residual"]; 
  $sit_contable=$registro["sit_contable"];   $sit_legal=$registro["sit_legal"];  $edo_conservacion=$registro["edo_conservacion"];
  $ced_verificador=$registro["ced_verificador"];   $fecha_verificacion=$registro["fecha_verificacion"];
  if($fecha_verificacion==""){$fecha_verificacion="";}else{$fecha_verificacion=formato_ddmmaaaa($fecha_verificacion);}
  $tipo_incorporacion=$registro["tipo_incorporacion"];   $cod_imp_presup=$registro["cod_imp_presup"]; 
  $nom_imp_presup=$registro["nom_imp_presup"];  $des_imp_nopresup=$registro["des_imp_nopresup"];   
  $fecha_incorporacion=$registro["fecha_incorporacion"]; if($fecha_incorporacion==""){$fecha_incorporacion="";}else{$fecha_incorporacion=formato_ddmmaaaa($fecha_incorporacion);}
  $valor_incorporacion=$registro["valor_incorporacion"];  $garantia=$registro["garantia"];  $nro_oc=$registro["nro_oc"]; $nro_op=$registro["nro_op"]; 
  $fecha_oc=$registro["fecha_oc"]; if($fecha_oc==""){$fecha_oc="";}else{$fecha_oc=formato_ddmmaaaa($fecha_oc);}    
  $fecha_op=$registro["fecha_op"]; if($fecha_op==""){$fecha_op="";}else{$fecha_op=formato_ddmmaaaa($fecha_op);}
  $tipo_doc_cancela=$registro["tipo_doc_cancela"];  $nro_doc_cancela=$registro["nro_doc_cancela"]; 
  $fecha_doc_cancela=$registro["fecha_doc_cancela"];if($fecha_doc_cancela==""){$fecha_doc_cancela="";}else{$fecha_doc_cancela=formato_ddmmaaaa($fecha_doc_cancela);} 
  $ced_rif_proveedor=$registro["ced_rif_proveedor"];  $codigo_tipo_incorp=$registro["codigo_tipo_incorp"];  $nom_proveedor=$registro["nom_proveedor"]; 
  $cod_presup_dep=$registro["cod_presup_dep"];  $monto_depreciado=$registro["monto_depreciado"];   $nro_factura=$registro["nro_factura"]; 
  $fecha_factura=$registro["fecha_factura"]; if($fecha_factura==""){$fecha_factura="";}else{$fecha_factura=formato_ddmmaaaa($fecha_factura);}
  $des_desincorporado=$registro["des_desincorporado"]; $desincorporado=$registro["desincorporado"];   
  $fecha_desincorporado=$registro["fecha_desincorporado"];if($fecha_desincorporado==""){$fecha_desincorporado="";}else{$fecha_desincorporado=formato_ddmmaaaa($fecha_desincorporado);}
  $bien_en_salida=$registro["bien_en_salida"]; $accesorios=$registro["accesorios"];
}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia_e."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dependen_e=$registro["denominacion_dep"];}

$num_mes=substr($fecha_desincorporado,3,2); $num_dia=substr($fecha_desincorporado,0,2); $num_ano=substr($fecha_desincorporado,6,4);  $des_mes="";
if ($num_mes=="01"){$des_mes="ENERO";}else{if ($num_mes=="02"){$des_mes="FEBRERO";}else{if ($num_mes=="03"){$des_mes="MARZO";}else {if ($num_mes=="04"){$des_mes="ABRIL";}else {if ($num_mes=="05"){$des_mes="MAYO";}else {if ($num_mes=="06"){$des_mes="JUNIO";}else {if ($num_mes=="07"){$des_mes="JULIO";}else {if ($num_mes=="08"){$des_mes="AGOSTO";}else {if ($num_mes=="09"){$des_mes="SEPTIEMBRE";}else {if ($num_mes=="10"){$des_mes="OCTUBRE";}else {if ($num_mes=="11"){$des_mes="NOVIEMBRE";}else {$des_mes="DICIEMBRE";}}}}}}}}}}}
$lugar="SAN FELIPE, ".substr($num_dia,0,2)." DE ".$des_mes;

require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){	 global $denomina_depart_e; global $denomina_depart_r;   global $des_desincorporado; global $des_desin;
        //$this->rect(10,5,200,185);		
		$this->Image('../../imagenes/logo escudo.png',12,8,13);
		$this->SetFont('Arial','B',9);
		$this->Cell(25);
		$this->Cell(100,3,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,0,'L');
		$this->Cell(75,3,'',0,1,'R');
		$this->Cell(25);
		$this->Cell(100,3,'GOBERNACION DEL ESTADO YARACUY',0,1,'L');
		$this->Ln(10);
		$this->SetFont('Arial','B',12);
		$this->Cell(200,3,'ACTA DE SOLICITUD DE DESINCORPORACION',0,1,'C');
		$descrip="MOTIVO DE LA DESINCOPORACION: ".$des_desin;
		$this->Ln(5);	
        $x=$this->GetX();   $y=$this->GetY(); $n=200;
		$this->SetFont('Arial','',8);
		$this->MultiCell($n,4,$descrip,0);
		$this->Ln(4);
		$this->MultiCell($n,4,$des_desincorporado,0); 
		$this->Ln(5);
		$this->SetFont('Arial','B',8);
		$this->Cell(20);
		$this->Cell(25,4,'CODIGO',1,0,'C');
		$this->Cell(120,4,'DESCRIPCION',1,0,'C');
		$this->Cell(20,4,'MONTO BS.',1,1,'C');
	}
	
	function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		$this->SetY(-10);
		$this->SetFont('Arial','I',5);
		$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'L');
		$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
	}
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $i=1; $total=0; 
  $x1=$pdf->GetX();   $y1=$pdf->GetY();
  $codigo=$registro["cod_bien_mue"]; $monto=formato_monto($valor_incorporacion);$total=$total+$valor_incorporacion;
	$pdf->Cell(20);
	$pdf->Cell(25,4,$cod_bien_mue,0,0,'L');
	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=120;
	$pdf->SetXY($x+$n,$y);
	$pdf->Cell(20,4,$monto,0,1,'R');
	$pdf->SetXY($x,$y);
	$pdf->MultiCell($n,4,$denominacion,0); 
  
  $total=formato_monto($total);
  $pdf->Ln(3); $x=$pdf->GetX();   $y=$pdf->GetY();
  if($i<=5){ 
    $pdf->Line(30,$y1-0.1,30,$y);
	$pdf->Line(195,$y1-0.1,195,$y);
  }
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(20);
  $pdf->Cell(30,4,'','T',0,'C');
  $pdf->Cell(110,4,'TOTAL ...  ','T',0,'R');
  $pdf->Cell(25,4,$total,'T',1,'R');
  
  
  $pdf->Ln(5);
  $descrip="    Con tal motivo Se Solicita su Desincorporacion y Descargo de las cuentas respectiva correspondiente a la Oficina: GOBERNACION DEL ESTADO YARACUY";
  $x=$pdf->GetX();   $y=$pdf->GetY(); $n=200;
  $pdf->SetFont('Arial','',8);
  $pdf->MultiCell($n,4,$descrip,0);
  $pdf->Ln(5); 
  $pdf->Cell(60,3,'Lugar San Felipe, Dia '.$num_dia.' Mes '.$des_mes.' de '.$num_ano,0,1);
  
  $pdf->Ln(30);  
  $pdf->SetFont('Arial','',6);  
  $pdf->Cell(70);
  $pdf->Cell(60,3,'COORDINADOR DE BIENES','T',0,'C');
  $pdf->Output();
pg_close();
?>