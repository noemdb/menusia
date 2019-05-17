<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); $php_os=PHP_OS; $php_os="WINNT"; error_reporting(E_ALL ^ E_NOTICE);
if (!$_GET){ $referencia_transf=""; } else{$referencia_transf=$_GET["Greferencia_transf"];}

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }
$rif_emp=""; $nom_completo=""; $direccion=""; $sqle="Select * from SIA000 order by campo001"; $resultado=pg_query($sqle);
if ($registro=pg_fetch_array($resultado,0)){$cod_emp=$registro["campo001"]; $direccion=$registro["campo006"]; $nombre_emp=$registro["campo004"]; $nom_completo=$registro["campo005"]; $rif_emp=$registro["campo007"]; $nit_emp=$registro["campo008"]; }

$fecha_transf=""; $tipo_transferencia=""; $cod_dependencia_r=""; $cod_empresa_r=""; $cod_direccion_r=""; $cod_departamento_r=""; $tipo_movimiento_r="";  $cod_dependencia_e="";$cod_empresa_e=""; $cod_direccion_e=""; $cod_departamento_e="";     $tipo_movimiento_e=""; $ced_responsable=""; $ced_responsable_uso=""; $ced_rotulador=""; $ced_verificador=""; $departamento_r=""; $nombre_r=""; $departamento_e=""; $nombre_e=""; $cargo1=""; $departamento1=""; $nombre1=""; $referencia_mov_e=""; $referencia_mov_r="";    $campo_str1="";$campo_str2=""; $observacion=""; $musuario_sia=""; $inf_usuario=""; $descripcion="";  $denominacion_empresa_e="";$denominacion_dependen_e=""; $denominacion_dir_e=""; $denominacion_dep_e="";$denominacion_empresa_r=""; $denominacion_dependen_r=""; $denominacion_dir_r=""; $denominacion_dep_r=""; $nombre_res=""; $nombre_res_uso=""; $fecha_recibe_bienes=""; $ref_solic_trans=""; 
$sql="Select * from BIEN036 where referencia_transf='$referencia_transf' "; $res=pg_query($sql);
$filas=pg_num_rows($res);
if($filas>=1){ $registro=pg_fetch_array($res,0); 	$referencia_transf=$registro["referencia_transf"];$fecha_transf=$registro["fecha_transf"]; 
	$tipo_transferencia=$registro["tipo_transferencia"];  $cod_dependencia_r=$registro["cod_dependencia_r"];  	$cod_empresa_r=$registro["cod_empresa_r"]; $cod_direccion_r=$registro["cod_direccion_r"]; 
	$cod_departamento_r=$registro["cod_departamento_r"]; $tipo_movimiento_r=$registro["tipo_movimiento_r"];   $cod_dependencia_e=$registro["cod_dependencia_e"];$cod_empresa_e=$registro["cod_empresa_e"]; 
	$cod_direccion_e=$registro["cod_direccion_e"];  $cod_departamento_e=$registro["cod_departamento_e"]; 
	$cod_sub_departamento_e=$registro["cod_sub_departamento_e"]; $cod_sub_departamento_r=$registro["cod_sub_departamento_r"];
	
	$tipo_movimiento_e=$registro["tipo_movimiento_e"]; $ced_responsable=$registro["ced_responsable"]; 
	$ced_responsable_uso=$registro["ced_responsable_uso"]; $ced_rotulador=$registro["ced_rotulador"]; $ced_verificador=$registro["ced_verificador"]; $departamento_r=$registro["departamento_r"]; 
	$nombre_r=$registro["nombre_r"]; $departamento_e=$registro["departamento_e"]; $nombre_e=$registro["nombre_e"]; $cargo1=$registro["cargo1"];$departamento1=$registro["departamento1"];  $nombre1=$registro["nombre1"]; 
	$referencia_mov_e=$registro["referencia_mov_e"]; $referencia_mov_r=$registro["referencia_mov_r"];  $campo_str1=$registro["campo_str1"]; $campo_str2=$registro["campo_str2"];$observacion=$registro["observacion"]; 
	$inf_usuario=$registro["inf_usuario"];$descripcion=$registro["descripcion"]; $musuario_sia=$registro["usuario_sia"];
// 	$inf_usuario_a=explode(" ", $inf_usuario); $fecha_recibe_bienes=$inf_usuario_a[2];
	$ref_solic_trans=$registro["ref_solic_trans"];
}
$clave=$referencia_transf; $denomina_depart_e=""; $denomina_depart_r=""; $denominacion_dependen_e="";  $denominacion_dependen_r=""; $direccion_dep="";
$cedula_e=""; $cedula_r=""; $nombre_e=""; $nombre_r="";
/////////Empresa Emisor
$Ssql="SELECT * FROM bien007 where cod_empresa='".$cod_empresa_e."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_empresa_e=$registro["denominacion_emp"];}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia_e."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dependen_e=$registro["denominacion_dep"];}
//Direcciones
$Ssql="SELECT * FROM bien005 where cod_dependencia='".$cod_dependencia_e."' and cod_direccion='".$cod_direccion_e."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dir_e=$registro["denominacion_dir"];}
//Departamento
$Ssql="SELECT * FROM bien006 where cod_dependencia='".$cod_dependencia_e."' and cod_direccion='".$cod_direccion_e."' and cod_departamento='".$cod_departamento_e."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denomina_depart_e=$registro["denominacion_dep"]; $cedula_e=$registro["nombre_contacto_d"];}
//Sub-Departamento
$Ssql="SELECT * FROM bien059 where cod_dependencia='".$cod_dependencia_e."' and cod_direccion='".$cod_direccion_e."' and cod_departamento='".$cod_departamento_e."' and cod_sub_departamento='".$cod_sub_departamento_e."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);$denominacion_sub_dep_e=$registro["denominacion_sub_dep"];}
//Sub-Departamento
$Ssql="SELECT * FROM bien059 where cod_dependencia='".$cod_dependencia_e."' and cod_direccion='".$cod_direccion_e."' and cod_departamento='".$cod_departamento_e."' and cod_sub_departamento='".$cod_sub_departamento_e."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_sub_dep_e=$registro["denominacion_sub_dep"];}


//Responsable Primario
$Ssql="SELECT * FROM bien002 where ced_responsable='".$cedula_e."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_e=$registro["nombre_res"];}


////////Empresa Receptor
$Ssql="SELECT * FROM bien007 where cod_empresa='".$cod_empresa_r."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_empresa_r=$registro["denominacion_emp"];}
//Dependencia
$Ssql="SELECT * FROM bien001 where cod_dependencia='".$cod_dependencia_r."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dependen_r=$registro["denominacion_dep"];}
//Direcciones
$Ssql="SELECT * FROM bien005 where cod_dependencia='".$cod_dependencia_r."' and cod_direccion='".$cod_direccion_r."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denominacion_dir_r=$registro["denominacion_dir"];}
//Departamento
$Ssql="SELECT * FROM bien006 where cod_dependencia='".$cod_dependencia_r."' and cod_direccion='".$cod_direccion_r."' and cod_departamento='".$cod_departamento_r."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $denomina_depart_r=$registro["denominacion_dep"]; $direccion_dep=$registro["direccion_dep"]; $cedula_r=$registro["nombre_contacto_d"]; }
//Sub-Departamento
$Ssql="SELECT * FROM bien059 where cod_dependencia='".$cod_dependencia_r."' and cod_direccion='".$cod_direccion_r."' and cod_departamento='".$cod_departamento_r."' and cod_sub_departamento='".$cod_sub_departamento_r."'"; $resultado=pg_query($Ssql); if ($registro=pg_fetch_array($resultado,0)){$denominacion_sub_dep_r=$registro["denominacion_sub_dep"];}

//Responsable Primario
$Ssql="SELECT * FROM bien002 where ced_responsable='".$ced_responsable."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_res=$registro["nombre_res"];}
$cedula_r=$ced_responsable; $nombre_r=$nombre_res;

//Responsable Uso
$Ssql="SELECT * FROM bien031 where ced_res_uso='".$ced_responsable_uso."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0);  $nombre_res_uso=$registro["nombre_res_uso"];}


//NOMBRE usuario
$nombre_usuario_sia=''; $cedula_u='';
$Ssql="SELECT * FROM SIA001 where campo101='".$musuario_sia."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0); $cedula_u=$registro["campo109"]; $nombre_usuario_sia=$registro["campo104"];}

//Fechas de aprobación de la solicitud de transferencia
$fecha_aprob_e=''; $fecha_aprob_r='';
$Ssql="SELECT * FROM bien061 WHERE referencia_sol_transf='".$ref_solic_trans."'"; $resultado=pg_query($Ssql); $filas=pg_num_rows($resultado); if($filas>=1){ $registro=pg_fetch_array($resultado,0); $fecha_aprob_e=formato_ddmmaaaa($registro["fecha_sol_transf"]);  $fecha_aprob_r=formato_ddmmaaaa($registro["fecha_aprobada"]);  $fecha_recibe_bienes=formato_ddmmaaaa($registro["fecha_recibida"]); }


if($fecha_transf==""){$fecha_transf="";}else{$fecha_transf=formato_ddmmaaaa($fecha_transf);}
if($tipo_transferencia=="E"){$tipo_transferencia="EXTERNA";}else{$tipo_transferencia="INTERNA";}


require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){	 global $denomina_depart_e; global $denomina_depart_r;   global $descripcion; global $fecha_transf; global $clave; global $denominacion_sub_dep_r; global $denominacion_sub_dep_e;
        //$this->rect(10,5,200,185);		
		$this->Image('../../imagenes/logo escudo.png',12,8,30);
		$this->Ln(5);
		$this->SetFont('Arial','B',12);
		$this->Cell(240,5,'GERENCIA DE ADMINISTRACION Y FINANZAS',0,0,'C');
		$this->SetFont('Arial','B',8);
		$this->Cell(20,5,'Pagina No. '.$this->PageNo(),0,1,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(230,5,'DEPARTAMENTO DE BIENES',0,0,'C');
		$this->SetFont('Arial','B',8);
		$this->Cell(30,5,'Referencia: '.$clave,0,1,'L');
		$this->SetFont('Arial','B',12);
		$this->Cell(240,5,'TRANSFERENCIA INTERNA DE BIENES',0,1,'C');
		$this->Ln(5);
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
        
        $this->Cell(260,4,'FAF-032',0,1,'R');
        
        
		
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
?>