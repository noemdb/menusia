<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS; error_reporting(E_ALL ^ E_NOTICE); 
if (!$_GET){ $referencia_comp=''; $tipo_compromiso=''; $cod_comp='';}else { $referencia_comp = $_GET["txtreferencia_comp"]; $tipo_compromiso = $_GET["txttipo_compromiso"]; $cod_comp = $_GET["txtcod_comp"];}  $rif_emp=""; $total_comp=0;
$sql="Select * from COMPROMISOS where tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and cod_comp='$cod_comp'";  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; } else { $Nom_Emp=busca_conf(); }
if($utf_rpt=="SI"){ $php_os="WINNT";} 
$descripcion="";$fecha="";$unidad_sol="";$des_unidad_sol="";$nombre_abrev_comp="";$cod_tipo_comp="";$des_tipo_comp="";$ced_rif="";$nombre="";$fecha_vencim="";$nro_documento="";$num_proyecto="";$des_proyecto="";$func_inv="";
$tiene_anticipo="";$tasa_anticipo="";$cod_con_anticipo="";$inf_usuario="";$anulado="";$modulo=""; $nombre_tipo_comp="";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);
  $referencia_comp=$registro["referencia_comp"];  $cod_comp=$registro["cod_comp"];$fecha=$registro["fecha_compromiso"];  $tipo_compromiso=$registro["tipo_compromiso"];
  $descripcion=$registro["descripcion_comp"];  $inf_usuario=$registro["inf_usuario"]; $nombre_abrev_comp=$registro["nombre_abrev_comp"];   $unidad_sol=$registro["unidad_sol"];
  $des_unidad_sol=$registro["denominacion_cat"];  $cod_tipo_comp=$registro["cod_tipo_comp"]; $des_tipo_comp=$registro["des_tipo_comp"];  $ced_rif=$registro["ced_rif"];
  $nombre=$registro["nombre"];  $fecha_vencim=$registro["fecha_vencim"]; $nro_documento=$registro["nro_documento"];  $num_proyecto=$registro["num_proyecto"];
  $des_proyecto=$registro["des_proyecto"];  $func_inv=$registro["func_inv"];  $tiene_anticipo=$registro["tiene_anticipo"];  $tasa_anticipo=$registro["tasa_anticipo"];
  $cod_con_anticipo=$registro["cod_con_anticipo"];  $anulado=$registro["anulado"];  $modulo=$registro["modulo"];
}
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);} $l=0; $nomb_usuario_comp="";
if($fecha_vencim==""){$fecha_vencim="";}else{$fecha_vencim=formato_ddmmaaaa($fecha_vencim);}
if($func_inv=="C"){$func_inv="CORRIENTE";}else{if($func_inv=="C"){$func_inv="INVERSION";}else{$func_inv="CORR/INV";}}
if($tiene_anticipo=="S"){$tiene_anticipo="SI";}else{$tiene_anticipo="NO";}
$clave=$tipo_compromiso.$referencia_comp.$cod_comp;
$sql="Select * from pre002 WHERE tipo_compromiso='$tipo_compromiso'";$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);$nombre_tipo_comp=$registro["nombre_tipo_comp"]; }
for ($i=0; $i<strlen($inf_usuario); $i++) { if (substr($inf_usuario,$i, 1)==" "){$l=$i; $i=strlen($inf_usuario);} } $usuario_comp=substr($inf_usuario,0,$l);
$sql="select * from sia001 where campo101='$usuario_comp'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];}
$des_fuente_financ="";
$sql="SELECT * FROM codigos_compromisos where referencia_comp='$referencia_comp' and tipo_compromiso='$tipo_compromiso' and cod_comp='$cod_comp' order by cod_presup";
$res=pg_query($sql); $filas=pg_num_rows($res); if($filas>0){ $registro=pg_fetch_array($res);  $des_fuente_financ=$registro["des_fuente_financ"];}
if($php_os=="WINNT"){$descripcion=$descripcion;}else{$descripcion=utf8_decode($descripcion); $nombre=utf8_decode($nombre);  $nombre_tipo_comp=utf8_decode($nombre_tipo_comp);  $des_unidad_sol=utf8_decode($des_unidad_sol); }	
$nombre=utf8_decode($nombre);
$sql="SELECT * FROM pre035 where tipo_compromiso='$tipo_compromiso' and referencia_comp='$referencia_comp' and cod_comp='$cod_comp' order by nro_linea";$res=pg_query($sql); $filas=pg_num_rows($res);
$fin=0; $sub_total=0; $total_imp=0;
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $referencia_comp; global $nombre_tipo_comp; global $des_unidad_sol; global $fecha; global $nombre; global $ced_rif; 
	   global $descripcion; global $tipo_compromiso; global $unidad_sol; global $php_os;	global $Nom_Emp;	
        $this->rect(10,5,200,260);		
		$this->Image('../../imagenes/logo escudo.png',12,6,18);
		$this->SetFont('Arial','B',9);
		$this->Cell(25);
		$this->Cell(140,3,$Nom_Emp,0,0,'L');
		$this->Cell(35,3,'Pagina '.$this->PageNo().'/{nb}',0,1,'R');
		$this->Ln(5);
		$this->SetFont('Arial','B',10);
		$this->Cell(200,3,'DETALLE DE COMPROMISO Nro. '.$referencia_comp,0,1,'C');
		$this->Ln(4);		
		$this->SetFont('Arial','',7);
        $this->SetFillColor(192,192,192);
		$this->Cell(150,3,'TIPO DE COMPROMISO',1,0,'C',true);		
		$this->Cell(50,3,'FECHA',1,1,'C',true);	
		$this->Cell(150,4,$tipo_compromiso." ".$nombre_tipo_comp,1,0,'C');		
		$this->Cell(50,4,$fecha,1,1,'C');
        $this->SetFont('Arial','B',8,true);
		$this->Cell(12,3,'','TLR',0,'C',true);
		$this->Cell(133,3,'','TLR',0,'C',true);
		$this->Cell(15,3,'','TLR',0,'C',true);
		$this->Cell(20,3,' ','TLR',0,'C',true);
		$this->Cell(20,3,' ','TLR',1,'C',true);		
		$this->Cell(12,4,'Renglon','BLR',0,'C',true);
		$this->Cell(133,4,'Descripcion del Detalle','BLR',0,'C',true);
		$this->Cell(15,4,'Cantidad','BLR',0,'C',true);
		$this->Cell(20,4,'Monto','BLR',0,'C',true);
		$this->Cell(20,4,'Total','BLR',1,'C',true);		
		$y=$this->GetY();
		$this->SetFillColor(255,0,0);		
		$this->SetFont('Arial','',8);
		$this->Line(22,$y,22,230);
		$this->Line(155,$y,155,235);
		$this->Line(170,$y,170,235);
		$this->Line(190,$y,190,235);
	}
	function Footer(){ global $fin; global $sub_total; global $total_imp;
	    $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  
		$total_orden=$sub_total+$total_imp; $total_orden=formato_monto($total_orden);
        $total_c=formato_monto($sub_total); $total_i=formato_monto($total_imp); 		
		$this->SetY(-50); $y=$this->GetY(); $l=$y+0.5;  $l=$y-0.2; $p=$y+13.1;
		$this->Line(10,$l,210,$l);
		$this->SetFillColor(192,192,192);	
        $this->SetFont('Arial','',9);	
		if($fin==0){
		$this->Cell(145,4,' ','TLR',0,'C');	
       	$this->SetFont('Arial','B',9);	
		$this->Cell(35,4,'SUB-TOTAL ','TLR',0,'R',true);
		$this->Cell(20,4,$total_c,'TLR',1,'R');	
		$this->Cell(130,4,' ','LR',0,'C');
		$this->Cell(70,4,' ','LR',0,'C');
		$this->Cell(130,4,' ','LR',0,'C');
		$this->Cell(70,4,' ','LR',0,'C');		
		}else{	
		$this->Cell(145,4,' ','TLR',0,'C');	
       	$this->SetFont('Arial','B',9);	
		$this->Cell(35,4,'SUB-TOTAL ','TLR',0,'R',true);
		$this->Cell(20,4,$total_c,'TLR',1,'R');
		$this->Cell(145,4,' ','LR',0,'C');	
		$this->Cell(35,4,'IMPUESTO ','LR',0,'R',true);
		$this->Cell(20,4,$total_i,'LR',1,'R');
		$this->Cell(145,5,' ','LR',0,'C');	
		$this->Cell(35,5,'TOTAL ','LR',0,'R',true);
		$this->Cell(20,5,$total_orden,'LR',1,'R');
		}
        $this->Line(10,$y,10,$y+5);	
        $this->Line(10,$p,210,$p);		
		$this->Cell(200,15,' ',0,1,'C');		
		$this->Cell(100,2,'_____________________________',0,0,'C');
		$this->Cell(100,2,'_____________________________',0,1,'C');		
		$this->Cell(100,5,'ELABORADO POR',0,0,'C');
		$this->Cell(100,5,'APROBADO',0,1,'C');		
		$this->SetFillColor(255,0,0);
		$this->Ln(5);
		$this->SetFont('Arial','B',5);
		$this->Cell(100,4,'',0,0,'L');
		$this->Cell(100,4,'SIA CONTABILIDAD PRESUPUESTARIA',0,1,'R');
	}
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',8);
  $pdf->SetAutoPageBreak(true, 50);  $total_req=0;  
  $i=0;  $res=pg_query($sql);$filas=pg_num_rows($res); 
  while($registro=pg_fetch_array($res)){ $i=$i+1;  
    $cantidad=formato_monto($registro["cantidad"]); $costo=formato_monto($registro["costo"]); $cantidad_r=formato_monto($registro["cantidad"]);
    $monto=$registro["cantidad"]*$registro["costo"];	$montot=formato_monto($monto);  $denominacion=$registro["descripcion_detalle"];
	if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}	$unidad=$registro["unidad_medida"];
	$pdf->Cell(12,4,$i,0,0,'C'); 
	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=133; 	   
	$pdf->SetXY($x+$n,$y);
	$pdf->Cell(15,4,$cantidad,0,0,'R'); 
	$pdf->Cell(20,4,$costo,0,0,'R'); 
	$pdf->Cell(20,4,$montot,0,1,'R'); 	
	$pdf->SetXY($x,$y);
	$pdf->MultiCell($n,4,$denominacion,0); 
	$total_req=$total_req+$monto;
	$sub_total=$sub_total+$registro["total_articulo"]; $total_imp=$total_imp +$registro["total_iva"]; 
  }	
  $fin=1;
 $pdf->Output();
 pg_close();
?> 