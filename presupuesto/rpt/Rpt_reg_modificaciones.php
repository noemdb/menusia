<?include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS;
if (!$_GET){ $referencia_modif=''; $tipo_modif='';} else { $referencia_modif=$_GET["txtreferencia_modif"];$tipo_modif=$_GET["txttipo_modif"];} $rif_emp="";  
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname.""); if (pg_ErrorMessage($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else { $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){if($php_os=="WINNT"){$php_os="LINUX";}else{$php_os="WINNT";}} }
$descripcion="";$fecha_registro="";$modif_i_e="";$fecha_modif="";$modif_aprob="";$inf_usuario="";$aprobada_por="";$nro_documento="";$fecha_documento="";
$sql="Select * FROM PRE009 where tipo_modif='$tipo_modif' and referencia_modif='$referencia_modif'";   $res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>0){  $registro=pg_fetch_array($res);  $referencia_modif=$registro["referencia_modif"];  $fecha_registro=$registro["fecha_registro"]; $ano_registro=substr($registro["fecha_registro"],0,4);
  $fecha_modif=$registro["fecha_modif"];  $tipo_modif=$registro["tipo_modif"];  $descripcion=$registro["descripcion_modif"];  $modif_i_e=$registro["modif_i_e"];
  $modif_aprob=$registro["modif_aprob"];  $aprobada_por=$registro["aprobada_por"];  $nro_documento=$registro["nro_documento"];  $fecha_documento=$registro["fecha_documento"];  $inf_usuario=$registro["inf_usuario"];
}
if($fecha_registro==""){$fecha_registro="";}else{$fecha_registro=formato_ddmmaaaa($fecha_registro);}
if($fecha_modif==""){$fecha_modif="";}else{$fecha_modif=formato_ddmmaaaa($fecha_modif);}
if($fecha_documento==""){$fecha_documento="";}else{$fecha_documento=formato_ddmmaaaa($fecha_documento);}
$des_tipo_modif=""; $chk1='';$chk2=''; $chk3=''; $chk4=''; $chk5=''; $chk6='';
if($tipo_modif==1){$des_tipo_modif="CREDITOS ADICIONALES"; $chk1='X';}
if($tipo_modif==2){$des_tipo_modif="RECTIFICACIONES"; $chk2='X';}
if($tipo_modif==3){$des_tipo_modif="INSUBSISTENCIAS"; $chk3='X';}
if($tipo_modif==4){$des_tipo_modif="REDUCCION DE INGRESOS"; $chk4='X';}
if($tipo_modif==5){$des_tipo_modif="TRASPASOS DE CREDITOS"; $chk5='';}
if($tipo_modif=='5'){if($modif_i_e=='E'){$chk5="X";} else {if($modif_i_e=='I'){$chk6="X";}}}
if($modif_i_e=='I'){$modif_i_e="INTERNA";}else{$modif_i_e="EXTERNA";}
if($modif_i_e=='1'){$modif_i_e="EXTERNA MAYOR AL 20%";} else {if($modif_i_e=='2'){$modif_i_e="EXTERNA MENOR AL 20%";} else {if($modif_i_e=='3'){$modif_i_e="EXTERNA IGUAL 10%";}}}
if($modif_aprob=='S'){$modif_aprob="SI";} else {$modif_aprob="NO";} $clave=$referencia_modif.$tipo_modif;$des_fuente_financ="";
$sql="SELECT * FROM codigos_modif where tipo_modif='$tipo_modif' and referencia_modif='$referencia_modif' order by cod_presup,fuente_financ"; $res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res);  $des_fuente_financ=$registro["des_fuente_financ"];}
require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){ global $referencia_modif; global $ano_registro; global $fecha_modif; global $fecha; global $nombre; global $ced_rif; global $Nom_Emp;
	   global $chk1; global $chk2; global $chk3; global $chk4; global $chk5; global $chk6;
	   global $descripcion; global $tipo_compromiso; global $unidad_sol; global $php_os;		
        $this->rect(10,5,200,265);		
		$this->Image('../../imagenes/logo escudo.png',12,8,13);
		$this->SetFont('Arial','B',9);
		$this->Cell(25);
		$this->Cell(100,4,$Nom_Emp,0,0,'L');
		$this->Cell(75,4,'',0,1,'R');		
		$this->Ln(5);		
		$this->SetFont('Arial','B',13);		
		$this->SetFont('Arial','B',14);
		$this->Cell(200,3,'SOLICITUD DE MODIFICACIONES PRESUPUESTARIAS',0,1,'C');
		$this->Cell(200,3,'',0,1,'L');
		$this->Cell(200,3,'',0,1,'L');
		$this->SetFont('Arial','B',10);
		$this->SetFont('Arial','B',10);
        $this->Cell(30,3,'PRESUPUESTO:',0,0,'L');
        $this->SetFont('Arial','',10);		
		$this->Cell(40,3,$ano_registro,0,0,'L');
		$this->SetFont('Arial','B',10);
		$this->Cell(20,3,'NUMERO:',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(60,3,$referencia_modif,0,0,'L');
		$this->SetFont('Arial','B',10);
		$this->Cell(20,3,'FECHA:',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(30,3,$fecha_modif,0,1,'L');
		$this->Cell(200,3,'',0,1,'L');
		//$this->Cell(200,3,'',0,1,'L');
		$this->SetFillColor(192,192,192);
		$this->SetFont('Arial','B',9);
		$this->Cell(199.9,3,'','LT',1,'L',true);
		$this->Cell(1,3,'','L',0,'L',true);
		$this->Cell(29,3,'INSUBSISTENCIA',0,0,'L',true);
		$this->Cell(3,3,$chk3,1,0,'L',true);		
		$this->Cell(4,3,'','L',0,'L',true);
		$this->Cell(22,3,'REDUCCION',0,0,'L',true);
		$this->Cell(3,3,$chk4,1,0,'L',true);		
		$this->Cell(4,3,'','L',0,'L',true);
		$this->Cell(35,3,'TRASPASO INTERNO',0,0,'L',true);
		$this->Cell(3,3,$chk6,1,0,'L',true);		
		$this->Cell(4,3,'','L',0,'L',true);
		$this->Cell(36,3,'TRASPASO EXTERNO',0,0,'L',true);
		$this->Cell(3,3,$chk5,1,0,'L',true);		
		$this->Cell(4,3,'','L',0,'L',true);
		$this->Cell(43,3,'RECURSOS ADICIONALES',0,0,'L',true);
		$this->Cell(3,3,$chk1,1,0,'L',true);
		$this->Cell(2.99,3,'','LR',1,'L',true);
		$this->Cell(1,3,'','L',0,'L',true);
		$this->Cell(29,3,'',0,0,'L',true);
		$this->Cell(3,3,'','T',0,'L',true);
		$this->Cell(4,3,'',0,0,'L',true);
		$this->Cell(22,3,'',0,0,'L',true);
		$this->Cell(3,3,'','T',0,'L',true);
		$this->Cell(4,3,'',0,0,'L',true);
		$this->Cell(35,3,'',0,0,'L',true);
		$this->Cell(3,3,'','T',0,'L',true);
		$this->Cell(4,3,'',0,0,'L',true);
		$this->Cell(36,3,'',0,0,'L',true);
		$this->Cell(3,3,'','T',0,'L',true);
		$this->Cell(4,3,'',0,0,'L',true);
		$this->Cell(43,3,'',0,0,'L',true);
		$this->Cell(3,3,'','T',0,'L',true);
		$this->Cell(2.99,3,'','R',1,'L',true);	
		$this->Cell(199.9,2,'','LB',1,'L',true);		
		$this->Cell(40,4,"POR CONCEPTO DE : ",0,1);
		$this->SetFont('Arial','',9);
        $this->MultiCell(200,3,$descripcion,0);
		$this->Cell(200,3,' ','B',1,'C');		
		$this->SetFont('Arial','B',7);
		$this->Cell(199.9,3,'CONTABILIDAD PRESUPUESTARIA',1,1,'C',true);		
		$this->Cell(45,3,'CODIGO',1,0,'C',true);
		$this->Cell(135,3,'DENOMINACION',1,0,'C',true);
		$this->Cell(19.9,3,'MONTO',1,1,'C',true);
		$y=$this->GetY();
		$this->SetFillColor(255,0,0);
		$this->Line(55,$y,55,240);
		$this->Line(190,$y,190,240);
	}
	function Footer(){ global $total_comp; $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $total_c=formato_monto($total_comp);
	    $this->SetY(-40); $y=$this->GetY(); $l=$y-0.2; $p=$y+5.1;
	    $this->SetFont('Arial','',8);
		$this->SetFillColor(192,192,192);
		$y=$this->GetY();
		$this->Cell(80,6,'PRESUPUESTO',1,0,'C',true);
		$this->Cell(60,6,'ADMINISTRADOR',1,0,'C',true);
		$this->Cell(60,6,'CONTRALOR MUNICIPAL',1,1,'C',true);
		$z=$this->GetY();	
		$this->Cell(40,5,'ELABORADO POR',0,0,'C');
        $this->Cell(40,5,'REVISADO POR',0,0,'C');		
        $this->Cell(60,5,'',0,0,'C');
        $this->Cell(60,5,'',0,1,'C');
		$this->SetFont('Arial','',5);
		$this->Cell(200,17,' ',0,1,'C');
		$this->Cell(40,3,'',0,0,'C');
        $this->Cell(40,3,'',0,0,'C');		
        $this->Cell(60,3,'',0,0,'C');
        $this->Cell(60,3,'',0,1,'C'); 
		$x=$this->GetY()-0.5;
		$this->Line(50,$z,50,$x);
        $this->Line(90,$z,90,$x);		
		$this->Line(150,$z,150,$x);	
		$this->SetFillColor(255,0,0);
		$this->Ln(2);
		$this->SetFont('Arial','',5);
		$this->Cell(100,4,'SIA Contabilidad Presupuestaria',0,1,'L');		
	}
}	
$pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',7);
  $pdf->SetAutoPageBreak(true, 40);  
  if(($tipo_modif==5)or($tipo_modif==2)){ 
    $sql="SELECT * FROM codigos_modif where tipo_modif='$tipo_modif' and referencia_modif='$referencia_modif' and operacion='-' order by grupo,cod_presup,fuente_financ"; $res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res);  $des_fuente_financ=$registro["des_fuente_financ"];}
    $pdf->SetFont('Arial','B',7);
	$pdf->Cell(45,4,'',0,0,'C');
	$pdf->Cell(135,4,'DE : ',0,0,'L');
	$pdf->Cell(20,4,'',0,1,'R');
	$pdf->SetFont('Arial','',7);
    $res=pg_query($sql);$filas=pg_num_rows($res); $total_mod=0; $i=0;  
    while($registro=pg_fetch_array($res)){ $i=$i+1;  
      $monto=formato_monto($registro["monto"]);  $denominacion=$registro["denominacion"];	
	  if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}	
	  $pdf->Cell(45,3,$registro["cod_presup"]."  ".$registro["fuente_financ"],0,0,'L'); 
	  $x=$pdf->GetX();   $y=$pdf->GetY(); $n=135; 	   
	  $pdf->SetXY($x+$n,$y);
	  $pdf->Cell(20,3,$monto,0,1,'R'); 
	  $pdf->SetXY($x,$y);
	  $pdf->MultiCell($n,3,$denominacion,0); 
	  $total_mod=$total_mod+$registro["monto"];
    }$total_mod=formato_monto($total_mod);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(180,2,'',0,0,'C');
	$pdf->Cell(20,2,'============',0,1,'R');
	$pdf->Cell(180,3,'TOTAL ',0,0,'R');
	$pdf->Cell(20,3,$total_mod,0,1,'R');
	$pdf->Ln(3);
	$pdf->Cell(45,4,'',0,0,'C');
	$pdf->Cell(135,4,'PARA : ',0,0,'L');
	$pdf->Cell(20,4,'',0,1,'R');
	$pdf->SetFont('Arial','',7);
	$sql="SELECT * FROM codigos_modif where tipo_modif='$tipo_modif' and referencia_modif='$referencia_modif' and operacion='+' order by grupo,cod_presup,fuente_financ"; $res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res);  $des_fuente_financ=$registro["des_fuente_financ"];}
    $res=pg_query($sql);$filas=pg_num_rows($res); $total_mod=0; $i=0;  
    while($registro=pg_fetch_array($res)){ $i=$i+1;  
      $monto=formato_monto($registro["monto"]);  $denominacion=$registro["denominacion"];	
	  if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}	
	  $pdf->Cell(45,3,$registro["cod_presup"]."  ".$registro["fuente_financ"],0,0,'L'); 
	  $x=$pdf->GetX();   $y=$pdf->GetY(); $n=135; 	   
	  $pdf->SetXY($x+$n,$y);
	  $pdf->Cell(20,3,$monto,0,1,'R'); 
	  $pdf->SetXY($x,$y);
	  $pdf->MultiCell($n,3,$denominacion,0); 
	  $total_mod=$total_mod+$registro["monto"];
    } $total_mod=formato_monto($total_mod);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(180,2,'',0,0,'C');
	$pdf->Cell(20,2,'============',0,1,'R');
	$pdf->Cell(180,3,'TOTAL ',0,0,'R');
	$pdf->Cell(20,3,$total_mod,0,1,'R');	
  }else{ $sql="SELECT * FROM codigos_modif where tipo_modif='$tipo_modif' and referencia_modif='$referencia_modif' order by grupo,cod_presup,fuente_financ"; $res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res);  $des_fuente_financ=$registro["des_fuente_financ"];}
    $res=pg_query($sql);$filas=pg_num_rows($res); $total_mod=0; $i=0;  
    while($registro=pg_fetch_array($res)){ $i=$i+1;  
      $monto=formato_monto($registro["monto"]);  $denominacion=$registro["denominacion"];	
	  if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}	
	  $pdf->Cell(45,3,$registro["cod_presup"]."  ".$registro["fuente_financ"],0,0,'L'); 
	  $x=$pdf->GetX();   $y=$pdf->GetY(); $n=135; 	   
	  $pdf->SetXY($x+$n,$y);
	  $pdf->Cell(20,3,$monto,0,1,'R'); 
	  $pdf->SetXY($x,$y);
	  $pdf->MultiCell($n,3,$denominacion,0); 
	  $total_mod=$total_mod+$registro["monto"];
    } $total_mod=formato_monto($total_mod);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(180,2,'',0,0,'C');
	$pdf->Cell(20,2,'============',0,1,'R');
	$pdf->Cell(180,3,'TOTAL ',0,0,'R');
	$pdf->Cell(20,3,$total_mod,0,1,'R');
  }
 $pdf->Output();
 pg_close();

?>
