<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc");  error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){ $referencia_desin=""; } else{$referencia_desin=$_GET["Greferencia_desin"];}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } }
$rif_emp=""; $nom_completo=""; $direccion=""; $sqle="Select * from SIA000 order by campo001"; $resultado=pg_query($sqle);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"]; $direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
$sql="Select * from BIEN045 where referencia_desin='$referencia_desin'";
$fecha_desin=""; $tipo_desin=""; $denominacion_dependencia=""; $cod_dependencia=""; $descripcion="";$nombre1="";$departamento1=""; $nombre2="";$departamento2="";$denominacion_dep="";$denominacion_dir=""; $cod_departamento_r="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){  $registro=pg_fetch_array($res,0);
	$referencia_desin=$registro["referencia_desin"];	$fecha_desin=$registro["fecha_desin"]; $sfecha=$registro["fecha_desin"];	if($fecha_desin==""){$fecha_desin="";}else{$fecha_desin=formato_ddmmaaaa($fecha_desin);}
	$cod_dependencia=$registro["cod_dependencia"]; 	$tipo_desin=$registro["tipo_desin"]; 	$status=$registro["status"]; 	$cod_conta_desin=""; 	
	$cargo1=$registro["cargo1"]; $departamento1=$registro["departamento1"];	$nombre1=$registro["nombre1"]; 		$cargo2=$registro["cargo2"]; $departamento2=$registro["departamento2"]; $nombre2=$registro["nombre2"]; 
	$cargo3=$registro["cargo3"]; $departamento3=$registro["departamento3"]; $nombre3=$registro["nombre3"]; 	$campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];
	$observacion=$registro["observacion"]; $inf_usuario=$registro["inf_usuario"];$descripcion=$registro["descripcion"];
	//Dependencia
  $Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dependencia=$registro["denominacion_dep"];}
}
$clave=$referencia_desin; $criterio=$sfecha.$referencia_desin.$tipo_comp; $des_desin=""; 
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
$lugar="SAN FELIPE, Dia ".$num_dia." del Mes de  ".$des_mes." de año ".$num_ano;
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){	 global $denomina_depart_e; global $denomina_depart_r;   global $descripcion; global $des_desin;
        //$this->rect(10,5,200,185);		
		$this->Image('../../imagenes/logo escudo.png',12,8,35);	
		
		$this->Ln(20);
		$this->SetFont('Arial','B',12);
		$this->Cell(200,3,'ACTA DE SOLICITUD DE DESINCORPORACION',0,1,'C');
		$descrip="Quien sucribe funcionario, mayor de edad y de este domicilio; certifica que de conformidad con  la Ley Orgánica de la Hacienda Pública Nacional y las Instrucciones y Modelos de la Publicación Nº 21,  Para la Contabilidad Fiscal de Bienes Nacionales de la Contraloria General de la República, hacen constar que los BIENES - MUEBLES, especificados en la presente Acta, se encuentran totalmente inservibles y por lo tanto inútiles para el servicio a que fueron destinados:".$des_desin;
		$this->Ln(5);	
        $x=$this->GetX();   $y=$this->GetY(); $n=200;
		$this->SetFont('Arial','',8);
		$this->MultiCell($n,4,$descrip,0);
		//$this->Ln(4);
		//$this->MultiCell($n,4,$descripcion,0); 
		$this->Ln(5);
		$this->SetFont('Arial','B',9);
		$this->Cell(15,4,'CANT',1,0,'C');
		$this->Cell(30,4,'CODIGO',1,0,'C');
		$this->Cell(130,4,'DESCRIPCION',1,0,'C');
		$this->Cell(25,4,'MONTO BS.',1,1,'C');
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
  $pdf->SetFont('Arial','',9);
  $i=0; $total=0;  
  $sql="SELECT * FROM DET_DES_MUE where referencia_desin='$referencia_desin' order by referencia_desin"; $res=pg_query($sql); 
  $x1=$pdf->GetX();   $y1=$pdf->GetY();
  while($registro=pg_fetch_array($res)){ $i=$i+1;
    $codigo=$registro["cod_bien_mue"]; $monto=$registro["monto"]; $denominacion=$registro["denominacion"]; $marca=$registro["marca"]; $modelo=$registro["modelo"]; $color=$registro["color"]; $matricula=$registro["matricula"]; $serial1=$registro["serial1"]; $material=$registro["material"];
	if($marca==''){ $desc_marca=''; }else{ $denominacion=$denominacion.', MARCA: '.$marca; }	
	if($modelo==''){ $desc_modelo=''; }else{ $denominacion=$denominacion.',MODELO: '.$modelo; }
	if($serial==''){ $desc_serial=''; }else{ $denominacion=$denominacion.',SERIAL: '.$serial; }
	if($material==''){ $desc_material=''; }else{ $denominacion=$denominacion.', MATERIAL: '.$material; }
	if($color==''){ $desc_color=''; }else{ $denominacion=$denominacion.', COLOR: '.$color; }
    if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denom_departamento=utf8_decode($denom_departamento); $direccion_dep=utf8_decode($direccion_dep); } 
    $monto=formato_monto($monto);$total=$total+$registro["monto"];
	$pdf->Cell(15,4,'',0,0,'L');
	$pdf->Cell(30,4,$codigo,0,0,'L');
	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=130;
	$pdf->SetXY($x+$n,$y);
	$pdf->Cell(25,4,$monto,0,1,'R');
	$pdf->SetXY($x,$y);
	$pdf->MultiCell($n,4,$denominacion,0);
  } $total=formato_monto($total);
  $pdf->Ln(3); $x=$pdf->GetX();   $y=$pdf->GetY();
  if($i<=5){ 
    $pdf->Line(10,$y1-0.1,10,$y);
	$pdf->Line(210,$y1-0.1,210,$y);
  }
  $pdf->SetFont('Arial','B',9);
  $pdf->Cell(15,4,'','T',0,'C');
  $pdf->Cell(30,4,'','T',0,'C');
  $pdf->Cell(130,4,'TOTAL ...  ','T',0,'R');
  $pdf->Cell(25,4,$total,'T',1,'R');
  
  $pdf->Ln(5);
  $descrip="Por tal motivo Se Solicita su desincorporación y descargo de la cuenta respectiva correspondiente a la Oficina:  ".$departamento2.", situado en : ".$denominacion_dependencia;
  $x=$pdf->GetX();   $y=$pdf->GetY(); $n=200;
  $pdf->SetFont('Arial','',8);
  $pdf->MultiCell($n,4,$descrip,0);
  $pdf->Ln(5); 
  $pdf->Cell(60,3,$lugar,0,1);  
  $pdf->Ln(30);  
  $pdf->SetFont('Arial','',7);    
  //$pdf->Cell(75,3,'Firma del Testigo, Nombre y Apellido ','T',0,'C');
 // $pdf->Cell(50);
 // $pdf->Cell(75,3,'Firma del Testigo, Nombre y Apellido ','T',1,'C');  
//  $pdf->Cell(75,5,'C.I No.: ___________________________  ',0,0,'C');
 // $pdf->Cell(50);
  //$pdf->Cell(75,5,'C.I No.: ___________________________  ',0,1,'C');  
  $pdf->Ln(30);
  $pdf->Cell(65);
  $pdf->Cell(70,3,'Firma del Contralor Municipal','T',1,'C');  
  $pdf->Output();
pg_close();
?>
