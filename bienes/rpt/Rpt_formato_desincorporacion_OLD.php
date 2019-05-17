<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){ $referencia_desin=""; } else{$referencia_desin=$_GET["Greferencia_desin"];}

$sql="Select * from BIEN045 where referencia_desin='$referencia_desin' ";

$conn = pg_connect("host=localhost port=5432 password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$rif_emp=""; $nom_completo=""; $direccion="";
$sqle="Select * from SIA000 order by campo001"; $resultado=pg_query($sqle);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"];
$direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }

$referencia_desin="";  $fecha_desin=""; $tipo_desin=""; $cod_dependencia=""; $descripcion="";$nombre1="";$departamento1=""; $nombre2="";$departamento2="";$denominacion_dep="";$denominacion_dir=""; $cod_departamento_r="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if ($filas==0){if ($p_letra=="S"){$sql="SELECT * From BIEN045 ORDER BY referencia_desin";} if ($p_letra=="A"){$sql="SELECT * From BIEN045 ORDER BY referencia_desin desc";} $res=pg_query($sql); $filas=pg_num_rows($res);}
if($filas>=1){  $registro=pg_fetch_array($res,0);
	$referencia_desin=$registro["referencia_desin"];	$fecha_desin=$registro["fecha_desin"]; $sfecha=$registro["fecha_desin"];
	if($fecha_desin==""){$fecha_desin="";}else{$fecha_desin=formato_ddmmaaaa($fecha_desin);}
	$cod_dependencia=$registro["cod_dependencia"]; 	$tipo_desin=$registro["tipo_desin"]; 
	$status=$registro["status"]; 	$cod_conta_desin=""; 	
	$cargo1=$registro["cargo1"]; $departamento1=$registro["departamento1"];	$nombre1=$registro["nombre1"]; 	
	$cargo2=$registro["cargo2"]; $departamento2=$registro["departamento2"]; $nombre2=$registro["nombre2"]; 
	$cargo3=$registro["cargo3"]; $departamento3=$registro["departamento3"]; $nombre3=$registro["nombre3"]; 
	$campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];
	$observacion=$registro["observacion"]; $inf_usuario=$registro["inf_usuario"];$descripcion=$registro["descripcion"];
}
$clave=$referencia_desin; $criterio=$sfecha.$referencia_desin.$tipo_comp; $des_desin=""; $denominacion_dependencia="";
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia_e."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dependen_e=$registro["denominacion_dep"];}
/*
1- INSERVIBILIDAD - 056
2- FALTANTES POR INVESTIGAR - 060
3- VENTAS - 052
4 -DESARME - 055
5- DETERIORO - 057
6- DEMOLICION - 058
7- POR TRABAJO - 051
8- SUMINISTRO A OTRAS ENTIDADES - 054
9- POR DONACION - 062
0- OTROS CONCEPTOS - 067
*/
if($tipo_desin=='056'){ $des_desin="INSERVIBILIDAD"; }
if($tipo_desin=='060'){ $des_desin="FALTANTES POR INVESTIGAR"; }
if($tipo_desin=='052'){ $des_desin="VENTAS"; }
if($tipo_desin=='055'){ $des_desin="DESARME"; }
if($tipo_desin=='057'){ $des_desin="DETERIORO"; }
if($tipo_desin=='058'){ $des_desin="DEMOLICION"; }
if($tipo_desin=='051'){ $des_desin="POR TRABAJO"; }
if($tipo_desin=='054'){ $des_desin="SUMINISTRO A OTRAS ENTIDADES"; }
if($tipo_desin=='062'){ $des_desin="POR DONACION"; }
if($tipo_desin=='067'){ $des_desin="OTROS CONCEPTOS"; }
$fecha=$fecha_desin; $num_mes=substr($fecha,3,2); $num_dia=substr($fecha,0,2); $num_ano=substr($fecha,6,4);  $des_mes="";
if ($num_mes=="01"){$des_mes="ENERO";}else{if ($num_mes=="02"){$des_mes="FEBRERO";}else{if ($num_mes=="03"){$des_mes="MARZO";}else {if ($num_mes=="04"){$des_mes="ABRIL";}else {if ($num_mes=="05"){$des_mes="MAYO";}else {if ($num_mes=="06"){$des_mes="JUNIO";}else {if ($num_mes=="07"){$des_mes="JULIO";}else {if ($num_mes=="08"){$des_mes="AGOSTO";}else {if ($num_mes=="09"){$des_mes="SEPTIEMBRE";}else {if ($num_mes=="10"){$des_mes="OCTUBRE";}else {if ($num_mes=="11"){$des_mes="NOVIEMBRE";}else {$des_mes="DICIEMBRE";}}}}}}}}}}}
$lugar="SAN FELIPE, ".substr($num_dia,0,2)." DE ".$des_mes;

require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){	 global $denomina_depart_e; global $denomina_depart_r;   global $descripcion; global $des_desin;
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
		$this->MultiCell($n,4,$descripcion,0); 
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
  $i=0; $total=0;  
  $sql="SELECT * FROM DET_DES_MUE where referencia_desin='$referencia_desin' order by referencia_desin"; $res=pg_query($sql); 
  $x1=$pdf->GetX();   $y1=$pdf->GetY();
  while($registro=pg_fetch_array($res)){ $i=$i+1;
    $codigo=$registro["cod_bien_mue"]; $monto=$registro["monto"]; $denominacion=$registro["denominacion"];
	$monto=formato_monto($monto);$total=$total+$registro["monto"];
	$pdf->Cell(20);
	$pdf->Cell(25,4,$codigo,0,0,'L');
	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=120;
	$pdf->SetXY($x+$n,$y);
	$pdf->Cell(20,4,$monto,0,1,'R');
	$pdf->SetXY($x,$y);
	$pdf->MultiCell($n,4,$denominacion,0);
  } $total=formato_monto($total);
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