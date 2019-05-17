<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");  include ("../../class/configura.inc"); $php_os=PHP_OS; error_reporting(E_ALL ^ E_NOTICE); 
if (!$_GET){ $referencia=""; } else{$referencia=$_GET["Greferencia"];}

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }  }  

$rif_emp=""; $nom_completo=""; $direccion=""; $sqle="Select * from SIA000 order by campo001"; $resultado=pg_query($sqle);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"]; $direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }

$sql="Select * from BIEN043 where referencia='$referencia'";
$fecha=""; $tipo_salida=""; $cod_dependencia=""; $descripcion="";$nombre1="";$departamento1=""; $nombre2="";$departamento2=""; $denominacion_dep="";  $denominacion_dep=""; 
$res=pg_query($sql); $filas=pg_num_rows($res);
if($filas>=1){  $registro=pg_fetch_array($res,0); $referencia=$registro["referencia"];$fecha=$registro["fecha"]; $tipo_salida=$registro["tipo_salida"];
$descripcion=$registro["descripcion"];  $cod_dependencia=$registro["cod_dependencia"]; $nombre1=$registro["nombre1"]; $departamento1=$registro["departamento1"]; 
$nombre2=$registro["nombre2"]; $departamento2=$registro["departamento2"]; 

//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_dep=$registro["denominacion_dep"];}

}
$clave=$referencia;  $des_tipo_salida="";
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
if($tipo_salida=="1"){$des_tipo_salida="ORDEN POR REPARACION";}
if($tipo_salida=="2"){$des_tipo_salida="DONACION";}
if($tipo_salida=="3"){$des_tipo_salida="RETORNO A PROVEEDOR";}
if($tipo_salida=="4"){$des_tipo_salida="TRASLADO POR REPARACION";}
if($tipo_salida=="5"){$des_tipo_salida="PUNTO CUENTA DONACION";}
if($tipo_salida=="6"){$des_tipo_salida="COMODATO";}
if($tipo_salida=="7"){$des_tipo_salida="PARA USO DE LA DEPENDENCIA";}

require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $Nom_Emp; global $denominacion_dep; global $des_tipo_salida; global $fecha;  global $referencia;
        //$this->rect(10,5,200,185);		
		$this->Image('../../imagenes/logo escudo.png',12,8,13);
		$this->SetFont('Arial','B',9);
		$this->Cell(25);
		$this->Cell(100,5,'REPUBLICA BOLIVARIANA DE VENEZUELA',0,0,'L');
		$this->Cell(75,5,'',0,1,'R');
		$this->Cell(25);
		$this->Cell(100,5,$Nom_Emp,0,1,'L');
		$this->Ln(10);
		$this->SetFont('Arial','B',12);
		$this->Cell(200,5,'ORDEN DE SALIDA DE EQUIPO',0,1,'C');
		$this->Ln(5);	
        
		$this->SetFont('Arial','B',8);
		$this->Cell(100,6,'REFERENCIA ORDEN SALIDA : '.$referencia,0,0,'L');
		$this->Cell(100,6,'FECHA : '.$fecha,0,1,'L');
		
		$x=$this->GetX();   $y=$this->GetY(); $n=200;
		$desc="DEPENDENCIA: ".$denominacion_dep;
		$this->MultiCell($n,4,$desc,0);
		$this->Ln(5);
		$this->Cell(200,4,'MOTIVO DE LA SALIDA : '.$des_tipo_salida,0,1,'L');
		$this->Ln(5);
		$this->SetFont('Arial','B',8);
		$this->Cell(20);
		$this->Cell(25,4,'CODIGO',1,0,'C');
		$this->Cell(120,4,'DESCRIPCION DEL BIEN',1,0,'C');
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
  $sql="SELECT * FROM DET_SAL_MUE where referencia='$referencia' order by cod_bien_mue"; $res=pg_query($sql); 
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
  
  $pdf->Ln(30);  
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(30);
  $pdf->Cell(55,3,'UNIDAD','T',0,'C');
  $pdf->Cell(30);
  $pdf->Cell(55,3,'RECIBE CONFORME','T',0,'C');
  $pdf->Cell(30,3,'',0,1,'C');
  
  $pdf->Output();
pg_close();
?>