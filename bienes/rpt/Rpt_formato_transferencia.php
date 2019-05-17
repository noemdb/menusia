<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){ $referencia_transf=""; } else{$referencia_transf=$_GET["Greferencia_transf"];}

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$rif_emp=""; $nom_completo=""; $direccion=""; $sqle="Select * from SIA000 order by campo001"; $resultado=pg_query($sqle);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"]; $direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }

$fecha_transf=""; $tipo_transferencia=""; $cod_dependencia_r=""; $cod_empresa_r=""; $cod_direccion_r=""; $cod_departamento_r=""; $tipo_movimiento_r="";  $cod_dependencia_e="";$cod_empresa_e=""; $cod_direccion_e=""; $cod_departamento_e="";     $tipo_movimiento_e=""; $ced_responsable=""; $ced_responsable_uso=""; $ced_rotulador=""; $ced_verificador=""; $departamento_r=""; $nombre_r=""; $departamento_e=""; $nombre_e=""; $cargo1=""; $departamento1=""; $nombre1=""; $referencia_mov_e=""; $referencia_mov_r="";    $campo_str1="";$campo_str2=""; $observacion=""; $usuario_sia=""; $inf_usuario=""; $descripcion="";  $denominacion_empresa_e="";$denominacion_dependen_e=""; $denominacion_dir_e=""; $denominacion_dep_e="";$denominacion_empresa_r=""; $denominacion_dependen_r=""; $denominacion_dir_r=""; $denominacion_dep_r=""; $nombre_res=""; $nombre_res_uso=""; 
$sql="Select * from BIEN036 where referencia_transf='$referencia_transf' "; $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){ $registro=pg_fetch_array($res,0); 	$referencia_transf=$registro["referencia_transf"];$fecha_transf=$registro["fecha_transf"]; 
	$tipo_transferencia=$registro["tipo_transferencia"];  $cod_dependencia_r=$registro["cod_dependencia_r"];  	$cod_empresa_r=$registro["cod_empresa_r"]; $cod_direccion_r=$registro["cod_direccion_r"]; 
	$cod_departamento_r=$registro["cod_departamento_r"]; $tipo_movimiento_r=$registro["tipo_movimiento_r"];   $cod_dependencia_e=$registro["cod_dependencia_e"];$cod_empresa_e=$registro["cod_empresa_e"]; 
	$cod_direccion_e=$registro["cod_direccion_e"];  $cod_departamento_e=$registro["cod_departamento_e"];   $tipo_movimiento_e=$registro["tipo_movimiento_e"]; $ced_responsable=$registro["ced_responsable"]; 
	$ced_responsable_uso=$registro["ced_responsable_uso"]; $ced_rotulador=$registro["ced_rotulador"]; $ced_verificador=$registro["ced_verificador"]; $departamento_r=$registro["departamento_r"]; 
	$nombre_r=$registro["nombre_r"]; $departamento_e=$registro["departamento_e"]; $nombre_e=$registro["nombre_e"]; $cargo1=$registro["cargo1"];$departamento1=$registro["departamento1"];  $nombre1=$registro["nombre1"]; 
	$referencia_mov_e=$registro["referencia_mov_e"]; $referencia_mov_r=$registro["referencia_mov_r"];  $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];$observacion=$registro["observacion"]; 
	$inf_usuario=$registro["inf_usuario"];$descripcion=$registro["descripcion"];
}
$clave=$referencia_transf; $denomina_depart_e=""; $denomina_depart_r=""; $denominacion_dependen_e="";  $denominacion_dependen_r=""; 
/////////Empresa Emisor
$Ssql="SELECT * FROM bien007 where cod_empresa='".$cod_empresa_e."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_empresa_e=$registro["denominacion_emp"];}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia_e."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dependen_e=$registro["denominacion_dep"];}
//Direcciones
$Ssql="SELECT * FROM bien005 where cod_dependencia='".$cod_dependencia_e."' and cod_direccion='".$cod_direccion_e."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dir_e=$registro["denominacion_dir"];}
//Departamento
$Ssql="SELECT * FROM bien006 where cod_dependencia='".$cod_dependencia_e."' and cod_direccion='".$cod_direccion_e."' and cod_departamento='".$cod_departamento_e."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denomina_depart_e=$registro["denominacion_dep"];}
////////Empresa Receptor
$Ssql="SELECT * FROM bien007 where cod_empresa='".$cod_empresa_r."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_empresa_r=$registro["denominacion_emp"];}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia_r."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dependen_r=$registro["denominacion_dep"];}
//Direcciones
$Ssql="SELECT * FROM bien005 where cod_dependencia='".$cod_dependencia_r."' and cod_direccion='".$cod_direccion_r."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dir_r=$registro["denominacion_dir"];}
//Departamento
$Ssql="SELECT * FROM bien006 where cod_dependencia='".$cod_dependencia_r."' and cod_direccion='".$cod_direccion_r."' and cod_departamento='".$cod_departamento_r."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denomina_depart_r=$registro["denominacion_dep"];}
//Responsable Primario
$Ssql="SELECT * FROM bien002 where ced_responsable='".$ced_responsable."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_res=$registro["nombre_res"];}
//Responsable Uso
$Ssql="SELECT * FROM bien031 where ced_res_uso='".$ced_responsable_uso."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_res_uso=$registro["nombre_res_uso"];}

if($fecha_transf==""){$fecha_transf="";}else{$fecha_transf=formato_ddmmaaaa($fecha_transf);}
if($tipo_transferencia=="E"){$tipo_transferencia="EXTERNA";}else{$tipo_transferencia="INTERNA";}

$mes=substr($fecha_transf,3,2);  $ano=substr($fecha_transf,6,4);
if ($mes=="01"){$mes="ENERO";}else{if ($mes=="02"){$mes="FEBRERO";}else{if ($mes=="03"){$mes="MARZO";}else {if ($mes=="04"){$mes="ABRIL";}else {if ($mes=="05"){$mes="MAYO";}else {if ($mes=="06"){$mes="JUNIO";}else {if ($mes=="07"){$mes="JULIO";}else {if ($mes=="08"){$mes="AGOSTO";}else {if ($mes=="09"){$mes="SEPTIEMBRE";}else {if ($mes=="10"){$mes="OCTUBRE";}else {if ($mes=="11"){$mes="NOVIEMBRE";}else {$mes="DICIEMBRE";}}}}}}}}}}}
$lugar="San Felipe, Dia ".substr($fecha_transf,0,2)." del Mes de  ".$mes." de año ".$ano;


require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){	 global $denomina_depart_e; global $denomina_depart_r;   global $descripcion;
        //$this->rect(10,5,200,185);		
		$this->Image('../../imagenes/logo escudo.png',12,15,25);
		$this->SetFont('Arial','B',7);
		$this->Cell(100,3,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,1,'L');
		
		$this->Ln(30);
		$this->SetFont('Arial','UB',12);
		$this->Cell(200,3,'ACTA DE TRANSFERENCIA DE BIENES MUEBLES',0,1,'C');
		$this->Ln(5);	
        $descrip='Los que suscriben funcionarios, mayores de edad y de este domicilio; hacen constar que de acuerdo con lo previsto en el Artículo Nº 140 de la Ley Orgánica de la Hacienda Pública Nacional y la Publicación Nº 9, Instrucciones y Modelos Para la Contabilidad Fiscal de Bienes Nacionales; ';
		$descrip=$descrip.'Código Nº 51 Desincorporación por traspaso de la Contraloria General de la República, los Bienes Nacionales que se citan en la presente Acta ha sido traspasados con carácter Permanente al "'.$denomina_depart_r.'", los cuales aparecen registrados en el Inventario de la Dependencia emisora:  ';
		$x=$this->GetX();   $y=$this->GetY(); $n=200;
		$this->SetFont('Arial','',9);
		$this->MultiCell($n,4,$descrip,0);
		$this->MultiCell($n,4,$descripcion,0); 
		$this->Ln(5);
		$this->SetFont('Arial','B',9);
		$this->Cell(140,5,'DESCRIPCION',1,0,'C');
		$this->Cell(30,5,'B/N',1,0,'C');
		$this->Cell(30,5,'MONTO BS.',1,1,'C');
	}
	
	function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
		$this->SetY(-15);
		$this->SetFont('Arial','',7);
		//$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'L');
		$this->Cell(100,4,' ',0,0,'L');
		$this->Cell(100,4,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,1,'R');
		$this->Cell(200,4,'Direccion: Avenida Caracas entre Calle 4ta y 5ta Avenida. Edif: Vingiu, Piso 2, Ofic. No.2','T',1,'C');
		$this->Cell(200,3,'Telefonos: (0254) 2348350',0,1,'C');
	}
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',9);
  $i=0; $total=0;  $sql="Select * from bien037 WHERE referencia_transf='$referencia_transf'";   
  $sql="Select * from DET_TRANSF_BIEN_MUE where referencia_transf='$referencia_transf' order by cod_bien_mue"; $res=pg_query($sql); 
  $x1=$pdf->GetX();   $y1=$pdf->GetY();
  while($registro=pg_fetch_array($res)){ $i=$i+1;
    $codigo=$registro["cod_bien_mue"]; $monto=$registro["monto"]; $denominacion=$registro["denominacion"];
	$monto=formato_monto($monto);$total=$total+$registro["monto"];
	
	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=140;
	$pdf->SetXY($x+$n,$y);
	$pdf->Cell(30,5,$codigo,0,0,'C');
	$pdf->Cell(30,5,$monto,0,1,'R');
	$pdf->SetXY($x,$y);
	$pdf->MultiCell($n,5,$denominacion,0);
  } $total=formato_monto($total);
  $pdf->Ln(3); $x=$pdf->GetX();   $y=$pdf->GetY();
  if($i<=5){ 
    $pdf->Line(10,$y1-0.1,10,$y);
	$pdf->Line(210,$y1-0.1,210,$y);
  }
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(170,5,'TOTAL ...  ',1,0,'R');
  $pdf->Cell(30,5,$total,1,1,'R');
  
  
  $pdf->Ln(5);
  $descrip="Lugar ".$lugar;
  $x=$pdf->GetX();   $y=$pdf->GetY(); $n=200;
  $pdf->SetFont('Arial','',9);
  $pdf->MultiCell($n,4,$descrip,0);
   
  $pdf->Ln(10);  
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(43,4,'DEPENDENCIA EMISORA','B',1,'L');
  $pdf->SetFont('Arial','',9);
  $pdf->Ln(20);
  $pdf->Cell(60);
  $pdf->Cell(80,5,$denomina_depart_e,'T',1,'C'); 

  $pdf->Ln(10);  
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(45,4,'DEPENDENCIA RECEPTORA','B',1,'L');
  $pdf->SetFont('Arial','',9);
  $pdf->Ln(20);
  $pdf->Cell(60);
  $pdf->Cell(80,5,$denomina_depart_r,'T',1,'C'); 

  //$pdf->Ln(10);  
  //$pdf->SetFont('Arial','B',9);
  //$pdf->Cell(35,4,'BIENES ESTADALES','B',1,'L');
  //$pdf->SetFont('Arial','',9);
  //$pdf->Ln(20);
  //$pdf->Cell(60);
  //$pdf->Cell(80,5,'JEFE DEL DEPARTAMENTO DE BIENES ESTADALES','T',1,'C');   
  
  
  $pdf->Output();
pg_close();
?>
