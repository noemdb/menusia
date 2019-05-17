<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS; $php_os="WINNT";
if (!$_GET){ $referencia_transf=""; } else{ $referencia_transf=$_GET["Greferencia_transf"]; }
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?} else{ $Nom_Emp=busca_conf(); }
$rif_emp=""; $nom_completo=""; $direccion="";$sqle="Select * from SIA000 order by campo001"; $resultado=pg_query($sqle);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"];$direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }
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
if($tipo_transferencia=="E"){$tipo_transferencia="EXTERNA";}if($tipo_transferencia=="I"){$tipo_transferencia="INTERNA";}
$chk1='';$chk2=''; $chk3=''; $chk4=''; $chk5=''; $chk6='';
if($tipo_transferencia=='P'){$chk1='X';}
if($tipo_transferencia=='C'){$chk2='X';}
if($tipo_transferencia=='T'){$chk3='X';}
if($tipo_transferencia=='M'){$chk4='X';}
if($tipo_transferencia=='D'){$chk5='X';}


require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){	 global $denomina_depart_e; global $denomina_depart_r;   global $descripcion; global $fecha_transf; global $clave; global $denominacion_sub_dep_r; global $denominacion_sub_dep_e;
        //$this->rect(10,5,200,185);		
		$this->Image('../../imagenes/logo escudo.png',10,7,20);
		$this->Ln(5);
		$this->SetFont('Arial','B',8);
		$this->Cell(240,5,'',0,0,'C');
		$this->SetFont('Arial','B',8);
		$this->Cell(20,5,'Pagina No. '.$this->PageNo(),0,1,'L');
		$this->SetFont('Arial','B',14);
		$this->Cell(230,5,'TRASPASO DE BIENES',0,0,'C');
		$this->SetFont('Arial','B',8);
		$this->Cell(30,5,'Referencia: '.$clave,0,1,'L');
		$this->Ln(7);
        $this->SetFont('Arial','B',8);
        
		$long_line=70; $part1=$denomina_depart_e; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($denomina_depart_e,0,$long_line); }      $lp=strlen($part1);  $c2=$lp; $care="N"; 
        if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($denomina_depart_e,0,$c2); }   $part2=substr($denomina_depart_e,$c2,$long_line);
		$linea1e=$part1; $linea2e=$part2;
		$long_line=70; $part1=$denomina_depart_r; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($denomina_depart_r,0,$long_line); }      $lp=strlen($part1);  $c2=$lp; $care="N"; 
        if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($denomina_depart_r,0,$c2); }   $part2=substr($denomina_depart_r,$c2,$long_line);
		$linea1r=$part1; $linea2r=$part2;		
		
		
		
		$long_line=70; $part1=$denominacion_sub_dep_e; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($denominacion_sub_dep_e,0,$long_line); }      $lp=strlen($part1);  $c2=$lp; $care="N"; 
        if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($denominacion_sub_dep_e,0,$c2); }   $part2=substr($denominacion_sub_dep_e,$c2,$long_line);
		$linea1e=$part1; $linea2e=$part2;
		$long_line=70; $part1=$denominacion_sub_dep_r; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($denominacion_sub_dep_r,0,$long_line); }      $lp=strlen($part1);  $c2=$lp; $care="N"; 
        if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($denominacion_sub_dep_r,0,$c2); }   $part2=substr($denominacion_sub_dep_r,$c2,$long_line);
		$linea1r=$part1; $linea2r=$part2;
		
		
		$this->Cell(117,4,'DE:','LRT',0,'L');
		$this->Cell(117,4,'PARA:','LRT',0,'L');
		$this->Cell(26,4,'FECHA:','LRT',1,'L');		
		$this->Cell(117,4,$linea1e,'LR',0,'L');
		$this->Cell(117,4,$linea1r,'LR',0,'L');
		$this->Cell(26,4,$fecha_transf,'LR',1,'L');		
		$this->Cell(117,4,$linea2e,'BLR',0,'L');
		$this->Cell(117,4,$linea2r,'BLR',0,'L');
		$this->Cell(26,4,'','BLR',1,'L');
		$this->SetFont('Arial','B',8);
		$this->Cell(51,4,'CODIGO',1,0,'C');
		$this->SetFont('Arial','B',7);
		$this->Cell(21,4,'CODIGO DE','TRL',0,'C');
		$this->SetFont('Arial','B',8);
		$this->Cell(162,4,'DESCRIPCION DE LOS BIENES','TRL',0,'C');
		$this->Cell(26,4,'MONTO BS.','TRL',1,'C');		
		$this->SetFont('Arial','B',7);
		$this->Cell(17,3,'Grupo',1,0,'C');
		$this->Cell(17,3,'Sub-Grupo',1,0,'C');
		$this->Cell(17,3,'Cantidad',1,0,'C');
		$this->Cell(21,3,'IDENTIFICACION','BRL',0,'C');
		$this->Cell(162,3,'','BRL',0,'C');
		$this->Cell(26,3,'','BRL',1,'C');
		$y=$this->GetY();
		$this->Line(10,$y,10,186);
		$this->Line(27,$y,27,186);
		$this->Line(44,$y,44,186);
		$this->Line(61,$y,61,186);
		$this->Line(82,$y,82,186);
		$this->Line(244,$y,244,186);
		$this->Line(270,$y,270,186);
	}
	
	function Footer(){global $total; global $nombre_usuario_sia; global $cedula_u; global $descripcion; global $cedula_r; global $cedula_e; global $nombre_r; global $nombre_e; $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); global $fecha_recibe_bienes; global $fecha_aprob_e; global $fecha_aprob_r;
		$this->SetY(-30);
		$long_line=90; $part1=$descripcion; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($descripcion,0,$long_line); }      $lp=strlen($part1);  $c2=$lp; $care="N"; 
        if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($descripcion,0,$c2); }   
		$part2=substr($descripcion,$c2,$long_line);  $part3="";		
		if($l>=($long_line*2)){ $descripcion2=substr($descripcion,$c2,($long_line*2)); $part2=$descripcion2; $part3=' '; $l=strlen($part2); if($l>$long_line){$part2=substr($descripcion2,0,$long_line); }      $lp=strlen($part2);  $c2=$lp; $care="N"; 
        if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part2,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part2=substr($descripcion2,0,$c2); }   
		$part3=substr($descripcion2,$c2,$long_line); 
		}			
		$linea1=utf8_decode($part1); $linea2=utf8_decode($part2); $linea3=utf8_decode($part3); $linea4="";  $Gtotal=formato_monto($total);
		
		$this->SetFont('Arial','B',7);
		$this->Cell(50,4,'RECIBE CONFORME ','TRL',0,'L');
		$this->Cell(50,4,'ENTREGA CONFORME ','TRL',0,'L');
		$this->Cell(50,4,'DEPARTAMENTO DE BIENES ','TRL',0,'L');
        $this->Cell(84,4,'TOTAL EN BS...  ',1,0,'R');
		$this->SetFont('Arial','B',7);  
        $this->Cell(26,4,$Gtotal,1,1,'R');
		$this->SetFont('Arial','',6);
		
		$this->Cell(50,4,'Fecha: '.$fecha_aprob_r,'RL',0,'L');
		$this->Cell(50,4,'Fecha: '.$fecha_aprob_e,'RL',0,'L');
		$this->Cell(50,4,'Fecha: '.$fecha_recibe_bienes,'RL',0,'L');
		/*$this->Cell(50,4,'','RL',0,'L');
		$this->Cell(50,4,'','RL',0,'L');
		$this->Cell(50,4,'','RL',0,'L');*/
        $this->Cell(110,4,'Observaciones :','RL',1,'L');
		
		$this->Cell(50,4,'CI No. : '.$cedula_r,'RL',0,'L');
		$this->Cell(50,4,'CI No. : '.$cedula_e,'RL',0,'L');
		$this->Cell(50,4,'CI No. : '.$cedula_u,'RL',0,'L');
        $this->Cell(110,4,$linea1,'RL',1,'L');
		
		$this->Cell(50,4,'Nombre : '.utf8_decode($nombre_r),'RL',0,'L');
		$this->Cell(50,4,'Nombre : '.utf8_decode($nombre_e),'RL',0,'L');
		$this->Cell(50,4,'Nombre : '.utf8_decode($nombre_usuario_sia),'RL',0,'L');
        $this->Cell(110,4,$linea2,'RL',1,'L');
		
		$this->Cell(50,4,'Funcionario Responsable ',1,0,'L');
		$this->Cell(50,4,'Funcionario Responsable ',1,0,'L');
		$this->Cell(50,4,'Funcionario Responsable ',1,0,'L');
        $this->Cell(110,4,$linea3,'BRL',1,'L');
        
        
        
		
		//$this->SetFont('Arial','I',5);
		//$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'L');
		//$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
	}
}  
  $pdf=new PDF('L', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $i=0; $total=0;  $sql="Select * from bien037 WHERE referencia_transf='$referencia_transf'";   
  $sql="Select * from DET_TRANSF_BIEN_MUE where referencia_transf='$referencia_transf' order by cod_bien_mue"; $res=pg_query($sql); 
  $x1=$pdf->GetX();   $y1=$pdf->GetY();
  while($registro=pg_fetch_array($res)){ $i=$i+1;
    $codigo=$registro["cod_bien_mue"]; $monto=$registro["monto"]; $denominacion=utf8_decode($registro["denominacion"]);
	$monto=formato_monto($monto); $cantidad=1;
	$grupo=substr($codigo,0,1); $sub_grupo=substr($codigo,2,2); $numero=substr($codigo,7,10);
	if($i==30){
	  $pdf->AddPage();  
	  $pdf->SetFont('Arial','',7);
	  $i=0;
	}
	$pdf->Cell(17,4,$grupo,0,0,'C');
	$total=$total+$registro["monto"];
	$pdf->Cell(17,4,$sub_grupo,0,0,'C');
	$pdf->Cell(17,4,$cantidad,0,0,'C');
	$pdf->Cell(21,4,$numero,0,0,'C');
	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=162;
	$pdf->SetXY($x+$n,$y);
	$pdf->Cell(26,4,$monto,0,1,'R');
	$pdf->SetXY($x,$y);
	$pdf->MultiCell($n,4,$denominacion,0);
  } 

  $pdf->Output();
pg_close();

/*
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
		$this->Cell(200,5,'3.- DESCRIPCIÓN',1,1,'C',true);
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
		$this->Cell(100,2,'SIA CONTROL DE BIENES NACIONALES',0,1,'R');
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
  $i=0; $total=0;  $sql="Select * from bien037 WHERE referencia_transf='$referencia_transf'";   
  $sql="Select * from DET_TRANSF_BIEN_MUE where referencia_transf='$referencia_transf' order by cod_bien_mue"; $res=pg_query($sql); 
  $x1=$pdf->GetX();   $y1=$pdf->GetY();
  while($registro=pg_fetch_array($res)){ $i=$i+1;
    $codigo=$registro["cod_bien_mue"]; $monto=$registro["monto"]; $denominacion=$registro["denominacion"]; $marca=$registro["marca"]; $modelo=$registro["modelo"]; $serial1=$registro["serial1"]; $marca=substr($marca,0,15); $modelo=substr($modelo,0,15); $serial1=substr($serial1,0,20);
	if($php_os=="WINNT"){$denominacion=$denominacion; }else{$denominacion=utf8_decode($denominacion); $denominacion_dep=utf8_decode($denominacion_dep); $denom_departamento=utf8_decode($denom_departamento); $marca=utf8_decode($marca); $modelo=utf8_decode($modelo); $serial1=utf8_decode($serial1); }  
	$monto=formato_monto($monto);$total=$total+$registro["monto"];
	$pdf->Cell(10,4,$i,0,0,'L');
	$pdf->Cell(16,4,$codigo,0,0,'L');
	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=100;
	$pdf->SetXY($x+$n,$y);
	$pdf->Cell(19,4,$marca,0,0,'L');
	$pdf->Cell(19,4,$modelo,0,0,'L');
	$pdf->Cell(20,4,$serial,0,1,'L');
	$pdf->SetXY($x,$y);
	$pdf->MultiCell($n,4,$denominacion,0);
  } $total=formato_monto($total);
  $pdf->Output();
pg_close();
*/


?>