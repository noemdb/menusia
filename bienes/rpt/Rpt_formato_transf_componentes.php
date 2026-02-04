<?php include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){ $referencia_transf_c=""; } else{ $referencia_transf_c=$_GET["Greferencia_transf_c"]; }
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); 
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$rif_emp=""; $nom_completo=""; $direccion="";$sqle="Select * from SIA000 order by campo001"; $resultado=pg_query($sqle);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"];$direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
$fecha_transf=""; $tipo_transferencia=""; $cod_dependencia_r=""; $cod_empresa_r=""; $cod_direccion_r=""; $cod_departamento_r=""; $tipo_movimiento_r="";  $cod_dependencia_e="";$cod_empresa_e=""; $cod_direccion_e=""; $cod_departamento_e="";     $tipo_movimiento_e=""; $ced_responsable=""; $ced_responsable_uso=""; $ced_rotulador=""; $ced_verificador=""; $departamento_r=""; $nombre_r=""; $departamento_e=""; $nombre_e=""; $cargo1=""; $departamento1=""; $nombre1=""; $referencia_mov_e=""; $referencia_mov_r="";    $campo_str1="";$campo_str2=""; $observacion=""; $usuario_sia=""; $inf_usuario=""; $descripcion="";  $denominacion_empresa_e="";$denominacion_dependen_e=""; $denominacion_dir_e=""; $denominacion_dep_e="";$denominacion_empresa_r=""; $denominacion_dependen_r=""; $denominacion_dir_r=""; $denominacion_dep_r=""; $nombre_res=""; $nombre_res_uso=""; 
$sql="Select * from BIEN054 where referencia_transf_c='$referencia_transf_c' "; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=0){ $registro=pg_fetch_array($res,0); $referencia_transf_c=$registro["referencia_transf_c"]; $fecha_transf=$registro["fecha_transf_c"]; 
  $tipo_transferencia=$registro["tipo_transferencia_c"]; $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];$inf_usuario=$registro["inf_usuario"];$descripcion=$registro["descripcion"];
  $departamento_r=$registro["departamento_r"]; $nombre_r=$registro["nombre_r"]; $departamento_e=$registro["departamento_e"]; $nombre_e=$registro["nombre_e"];
}
$clave=$referencia_transf_c; 
if($fecha_transf==""){$fecha_transf="";}else{$fecha_transf=formato_ddmmaaaa($fecha_transf);}
if($tipo_transferencia=="E"){$tipo_transferencia="EXTERNA";}if($tipo_transferencia=="I"){$tipo_transferencia="INTERNA";}
$chk1='';$chk2=''; $chk3=''; $chk4=''; $chk5=''; $chk6='';
if($tipo_transferencia=='P'){$chk1='X';}
if($tipo_transferencia=='C'){$chk2='X';}
if($tipo_transferencia=='T'){$chk3='X';}
if($tipo_transferencia=='M'){$chk4='X';}
if($tipo_transferencia=='D'){$chk5='X';}
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){	 global $denomina_depart_e; global $denomina_depart_r;   global $descripcion; global $fecha_transf; global $referencia_transf;
	     global $chk1; global $chk2; global $chk3; global $chk4; global $chk5; global $chk6; global $nombre_r; global $nombre_e;
        //$this->rect(10,5,200,185);	        
		$this->rect(10,5,200,261);		
		$this->Image('../../imagenes/logo escudo.png',12,6,18);
		$this->SetFillColor(192,192,192);
		$this->SetFont('Arial','B',7);
		$this->Cell(25);
		$this->Cell(145,3,'',0,0,'L');
		$this->Cell(25,3,'1.- NUMERO',1,0,'C',true);
		$this->Cell(5,3,'',0,1,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(25);
		$this->Cell(145,4,'',0,0,'L');
		$this->Cell(25,4,$referencia_transf,1,0,'C');
		$this->Cell(5,4,'',0,1,'L');		
		$this->SetFont('Arial','B',7);
		$this->Cell(25);
		$this->Cell(145,3,'',0,0,'L');
		$this->Cell(25,3,'2.- FECHA',1,0,'C',true);
		$this->Cell(5,3,'',0,1,'L');
		$this->Cell(25);
		$this->SetFont('Arial','B',14);		
		$this->Cell(145,4,'TRASLADO DE BIENES ACTIVOS FIJO',0,0,'C');
		$this->SetFont('Arial','',9);	   
		$this->Cell(25,4,$fecha_transf,1,0,'C');
		$this->Cell(5,4,'',0,1,'L');		
		$this->Ln(3);		
		$this->SetFont('Arial','B',8);
		$this->Cell(200,5,'3.- DESCRIPCI�N',1,1,'C',true);
		$this->SetFont('Arial','B',7);
		$this->Cell(200,4,'3.1 Tipo de Taslado',1,1,'C',true);		
		$this->Cell(1,3,'','L',0,'L',true);
		$this->Cell(20,3,'PRESTAMO',0,0,'L',true);
		$this->Cell(3,3,$chk1,1,0,'L',true);		
		$this->Cell(15,3,'','L',0,'L',true);
		$this->Cell(20,3,'CESION',0,0,'L',true);
		$this->Cell(3,3,$chk2,1,0,'L',true);		
		$this->Cell(12,3,'','L',0,'L',true);
		$this->Cell(30,3,'CAMBIO DE ESTADO',0,0,'L',true);
		$this->Cell(3,3,$chk3,1,0,'L',true);		
		$this->Cell(12,3,'','L',0,'L',true);
		$this->Cell(25,3,'MANTENIMIENTO',0,0,'L',true);
		$this->Cell(3,3,$chk4,1,0,'L',true);		
		$this->Cell(12,3,'','L',0,'L',true);
		$this->Cell(30,3,'DESINCORPORACION',0,0,'L',true);
		$this->Cell(3,3,$chk5,1,0,'L',true);
		$this->Cell(8,3,'','LR',1,'L',true);		
		$this->Cell(21,3,'','BL',0,'L',true);
		$this->Cell(3,3,'','BT',0,'L',true);
		$this->Cell(35,3,'','B',0,0,'L',true);
		$this->Cell(3,3,'','BT',0,'L',true);
		$this->Cell(42,3,'','B',0,'L',true);
		$this->Cell(3,3,'','BT',0,'L',true);
		$this->Cell(37,3,'','B',0,'L',true);
		$this->Cell(3,3,'','BT',0,'L',true);
		$this->Cell(42,3,'','B',0,'L',true);
		$this->Cell(3,3,'','BT',0,'L',true);
		$this->Cell(8,3,'','BR',1,'L',true);		
		$this->SetFont('Arial','',6);
		$this->Cell(50,3,'3.2 Responsable Patrimonial','TRL',0,'C',true);
		$this->Cell(35,3,'','TRL',0,'C',true);
		$this->Cell(50,3,'3.4 Responsable Patrimonial','TRL',0,'C',true);
		$this->Cell(35,3,'','TRL',0,'C',true);
		$this->Cell(30,3,'','TRL',1,'C',true);		
		$this->Cell(50,3,'Primario Solicitante','BRL',0,'C',true);
		$this->Cell(35,3,'3.3 Ubicacion','BRL',0,'C',true);
		$this->Cell(50,3,'Primario Transferente','BRL',0,'C',true);
		$this->Cell(35,3,'3.5 Ubicacion ','BRL',0,'C',true);
		$this->Cell(30,3,'3.6 Lapso de Traslado ','BRL',1,'C',true);		
		$this->Cell(50,4,$nombre_r,1,0,'C');
		$this->Cell(35,4,'',1,0,'C');
		$this->Cell(50,4,$nombre_e,1,0,'C');
		$this->Cell(35,4,'',1,0,'C');
		$this->Cell(30,4,'INDEFINIDO',1,1,'C');		
		$this->SetFont('Arial','B',7);
		$this->Cell(200,4,'3.7 Justificacion',1,1,'C',true);
		$this->SetFont('Arial','',8);
		$this->MultiCell($n,4,$descripcion,0); 
		$this->SetFont('Arial','B',8);
		$this->Cell(200,5,'4.- CARACTERISTICAS DEL BIEN',1,1,'C',true);
		$this->SetFont('Arial','B',7);
		$this->Cell(10,4,'4.1 Item',1,0,'C',true);
		$this->Cell(16,4,'4.2 Codigo ',1,0,'C',true);
		$this->Cell(100,4,'4.3 Descripcion',1,0,'C',true);
		$this->Cell(19,4,'4.4 Marca',1,0,'C',true);
		$this->Cell(19,4,'4.5 Modelo',1,0,'C',true);
		$this->Cell(19,4,'4.6 Serial',1,0,'C',true);
		$this->SetFont('Arial','B',6);
		$this->Cell(17,4,'4.7 Observacion',1,1,'C',true);
	}
	
	function Footer(){ global $total_comp; global $fecha_transf; 
	    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $total_c=formato_monto($total_comp); 
		$this->SetY(-45); $y=$this->GetY(); $l=$y-0.2; $p=$y+5.1;
		$this->SetFillColor(192,192,192);
		$this->SetFont('Arial','B',8);
		$this->Cell(200,4,'6.- FIRMAS Y SELLOS',1,1,'C',true);			
		$this->SetFont('Arial','B',7);
		$this->Cell(50,3,'5.1 Responsable Patrimonial','TLR',0,'C',true);
		$this->Cell(50,3,'5.2 Responsable Patrimonial','TLR',0,'C',true);
		$this->Cell(100,3,'5.3- Oficina de Administracion',1,1,'C',true);
		$this->Cell(50,3,'Primario Solicitante','BLR',0,'C',true);
		$this->Cell(50,3,'Primario Transferente','BLR',0,'C',true);
		$this->Cell(50,3,'5.3.1- Analista Administrativo',1,0,'C',true);
		$this->Cell(50,3,'5.3.1- Responsable de Bienes',1,1,'C',true);		
        $this->SetFont('Arial','',7);		
		$this->Cell(50,12,'','LR',0,'C');
		$this->Cell(50,12,'','LR',0,'C');
		$this->Cell(50,12,'','LR',0,'C');
		$this->Cell(50,12,'','R',1,'C');		
		$this->Cell(30,3,'Firma:',0,0,'L');
		$this->Cell(20,3,'Sello','R',0,'C');
		$this->Cell(30,3,'Firma:',0,0,'L');
		$this->Cell(20,3,'Sello','R',0,'C');
		$this->Cell(30,3,'Firma:',0,0,'L');
		$this->Cell(20,3,'Sello','R',0,'C');
		$this->Cell(30,3,'Firma:',0,0,'L');	
		$this->Cell(20,3,'Sello','R',1,'C');
		$this->Cell(50,3,'Nombre:','R',0,'L');
		$this->Cell(50,3,'Nombre:','R',0,'L');
		$this->Cell(50,3,'Nombre:','R',0,'L');
		$this->Cell(50,3,'Nombre:','R',1,'L');	
		$this->Cell(50,4,'Fecha: ','R',0,'L');
		$this->Cell(50,4,'Fecha: ','R',0,'L');
		$this->Cell(50,4,'Fecha: ','R',0,'L');
		$this->Cell(50,4,'Fecha:','R',1,'L');
		$this->SetFillColor(255,0,0);
		$this->SetFont('Arial','B',5);
		$this->Cell(100,2,'1er ejemplar: Responsable patrimonial primario solicitante,',0,0,'L');
		$this->Cell(100,2,'SIPAP CONTROL DE BIENES NACIONALES',0,1,'R');
		$this->Cell(100,2,'2do ejemplar: Responsable patrimonial primario Transferiente, ',0,1,'L');
		$this->Cell(100,2,'3er ejemplar: Expediente',0,1,'L');
		$this->SetFont('Arial','B',6);
		$this->Ln(2);
		$sano=substr($fecha_transf,6,4); $mes_desde=substr($fecha_transf,3,2); $mesd="";
		if ($mes_desde=='01'){$mesd="Enero";}elseif ($mes_desde=='02'){$mesd="Febrero";}elseif ($mes_desde=='03'){$mesd="Marzo";}elseif ($mes_desde=='04'){$mesd="Abril";}elseif ($mes_desde=='05'){$mesd="Mayo";}elseif ($mes_desde=='06'){$mesd="Junio";}elseif ($mes_desde=='07'){$mesd="Julio";}elseif ($mes_desde=='08'){$mesd="Agosto";}elseif ($mes_desde=='09'){$mesd="Septiembre";}elseif ($mes_desde=='10'){$mesd="Octubre";}elseif ($mes_desde=='11'){$mesd="Noviembre";}elseif ($mes_desde=='12'){$mesd="Diciembre";}
        $this->Cell(100,2,$mesd.' '.$sano.' (060302-01)',0,0,'L');
		$this->Cell(100,2,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
	}
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetAutoPageBreak(true, 45);  
  $pdf->SetFont('Arial','',7);
  $i=0; $total=0;  
  $sql="Select * from bien057 WHERE referencia_transf_c='$referencia_transf_c'";    $res=pg_query($sql); 
  $x1=$pdf->GetX();   $y1=$pdf->GetY();
  while($registro=pg_fetch_array($res)){ $i=$i+1;
    $codigo=$registro["cod_bien_mue"]; $denominacion=$registro["des_componente"]; $marca=$registro["marca"]; $modelo=$registro["modelo"]; $serial1=$registro["serial1"]; $marca=substr($marca,0,15); $modelo=substr($modelo,0,15); $serial1=substr($serial1,0,20);
	if($php_os=="WINNT"){$denominacion=$denominacion;} else{$denominacion=utf8_decode($denominacion); $marca=utf8_decode($marca); $modelo=utf8_decode($modelo); $serial1=utf8_decode($serial1); }  
	
	$pdf->Cell(10,4,$i,0,0,'L');
	$pdf->Cell(16,4,$codigo,0,0,'L');
	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=100;
	$pdf->SetXY($x+$n,$y);
	$pdf->Cell(19,4,$marca,0,0,'L');
	$pdf->Cell(19,4,$modelo,0,0,'L');
	$pdf->Cell(20,4,$serial,0,1,'L');
	$pdf->SetXY($x,$y);
	$pdf->MultiCell($n,4,$denominacion,0);
  } 
  $pdf->Output();
pg_close($conn);
?>