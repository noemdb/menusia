<?php include ("../../class/conect.php");  include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;  error_reporting(E_ALL ^ E_NOTICE); 

if (!$_GET){ $referencia_ajuste=''; $tipo_ajuste=''; } else{$referencia_ajuste=$_GET["txtreferencia_aju"]; $tipo_ajuste=$_GET["txttipo_ajuste"]; $fecha=$_GET["txtfecha"]; }
   $sql="Select * from AJUSTE_ORD where referencia_aju_ord='$referencia_ajuste' and tipo_aju_ord='$tipo_ajuste'";

$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_last_error($conn)) { echo "<p><b>Ocurrio un error conectando a la base de datos: .</b></p>"; exit; }  else { $Nom_Emp=busca_conf(); }

$tipo_pago="0000"; $referencia_pago="00000000"; $sfecha=""; $fecha=""; $nombre_tipo_aju=""; $nombre_refiere_a="";
$tipo_ajuste=""; $nro_orden="";  $tipo_causado=""; $fecha=""; $concepto=""; $nombre_abrev_caus=""; $nombre_abrev_aju=""; $inf_usuario=""; $total_ajuste=0; $anulado="N"; $fecha_anu=""; $descripcion="";
$res=pg_query($sql);$filas=pg_num_rows($res); $temp=$sql." ".$filas;
if($filas>0){  $registro=pg_fetch_array($res);
  $referencia_ajuste=$registro["referencia_aju_ord"];   $tipo_ajuste=$registro["tipo_aju_ord"]; $sfecha=$registro["fecha_aju_ord"];
  $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $total_ajuste=$registro["monto_aju_ord"];
  $fecha=$registro["fecha_aju_ord"];  $concepto=$registro["descripcion"];   $inf_usuario=$registro["inf_usuario"];  $fecha_anu=$registro["fecha_anulado_aju"];
  $nombre_abrev_caus=$registro["nombre_abrev_caus"]; $nombre_abrev_aju=$registro["nombre_abrev_ajuste"]; $anulado=$registro["anulado_aju"];
} $descripcion=$concepto;

$total_ajuste=formato_monto($total_ajuste); if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}
 $refierea=""; $nombre_tipo=""; $ced_rif="";  $nombre=""; $tipo_comp='J'.$tipo_ajuste; $nombre_tipo_aju="";
$sSQL="Select refierea from pre005 WHERE tipo_ajuste='$tipo_ajuste'";     $resultado=pg_exec($conn,$sSQL);    $filas=pg_numrows($resultado);
if ($filas>0){$registro=pg_fetch_array($resultado);  $refierea=$registro["refierea"]; $nombre_tipo_aju=$registro["nombre_tipo_ajuste"];}
for ($i=0; $i<strlen($inf_usuario); $i++) { if (substr($inf_usuario,$i, 1)==" "){$l=$i; $i=strlen($inf_usuario);} } $usuario_comp=substr($inf_usuario,0,$l);
$sql="select * from sia001 where campo101='$usuario_comp'";$res=pg_query($sql);$filas=pg_num_rows($res);if($filas>0){  $registro=pg_fetch_array($res); $nomb_usuario_comp=$registro["campo104"];
if( $nomb_usuario_comp=="ADMINISTRADOR"){$nomb_usuario_comp="";}}
if($php_os=="WINNT"){$descripcion=$descripcion;}else{$descripcion=utf8_decode($descripcion);  }


$cod_c=array ('','','','','','','','','','','','','','',''); $debe_c=array ('','','','','','','','','','','','','','','');
$den_c=array ('','','','','','','','','','','','','','',''); $haber_c=array ('','','','','','','','','','','','','','','');
$k=0; $max_ccont=10;
$sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$referencia_ajuste' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql);
while($registro=pg_fetch_array($res)){$monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";}else{$debe="";$haber=$monto_asiento;} 
$cod_c[$k]=$registro["cod_cuenta"]; $den_c[$k]=$registro["nombre_cuenta"]; $debe_c[$k]=$debe; $haber_c[$k]=$haber; if($k<15){$k=$k+1;}} $cant_cont=$k;
	
$sql="SELECT * FROM CODIGOS_AJUSTES where referencia_ajuste='$referencia_ajuste' and tipo_ajuste='$tipo_ajuste' and tipo_pago='$tipo_pago' and referencia_pago='$referencia_pago' and referencia_caus='$nro_orden' and tipo_causado='$tipo_causado'  order by cod_presup";
$res=pg_query($sql); $filas=pg_num_rows($res); $cant_cod_presup=$filas; $max_cpre=33; 
$temp2=$sql." ".$filas;

require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){ global $fecha; global $nro_orden;   global $descripcion;   global $tipo_causado; global $nombre_abrev_caus; global $nombre_refiere_a;
        global $referencia_ajuste;  global $nombre_tipo_aju; global $tipo_ajuste; global $Nom_Emp; 
       $this->rect(10,5,200,264);	
        $this->Image('../../imagenes/Logo_emp.png',12,7,15);
		$this->SetFont('Arial','B',10);
		$this->Cell(25);
		$this->Cell(100,4,$Nom_Emp,0,0,'L');
		$this->Cell(75,4,'',0,1,'R');		
		$this->Ln(5);		
		$this->SetFont('Arial','B',13);
		$this->Cell(200,5,'REGISTRO DE AJUSTE A ORDEN',0,1,'C');
		$this->Ln(3);
		$this->SetFont('Arial','B',9);
		$this->Cell(23,6,'Referencia :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(25,6,$referencia_ajuste,'TB',0,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(35,6,'Documento Ajuste :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(60,6,$tipo_ajuste.' '.$nombre_tipo_aju,'TB',0,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(27,6,'Fecha Ajuste :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(30,6,$fecha,'TB',1,'L');
		$this->SetFont('Arial','B',9);
		$this->Cell(40,6,'Numero Orden :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(60,6,$nro_orden,'TB',0,'L');
        $this->SetFont('Arial','B',9);
        $this->Cell(40,6,'Documento Orden :','TB',0,'L');
		$this->SetFont('Arial','',9);
		$this->Cell(60,6,$tipo_causado,'TB',1,'L');		
		$this->Cell(40,4,"POR CONCEPTO DE : ",0,1);
		$this->SetFont('Arial','',9);
        $this->MultiCell(200,3,$descripcion,0);
		$this->Cell(200,3,' ','B',1,'C');
		$this->Cell(40,4,'Codigo Presupuestario',1,0,'C');
		$this->Cell(140,4,'Denominacion Codigo Presupuestario',1,0,'C');
		$this->Cell(20,4,'Monto','TB',1,'C');
		$y=$this->GetY();
		$this->SetFillColor(255,0,0);
		$this->SetFont('Arial','',8);
	}
	function Footer(){ global $max_ccont; global $cant_cont; global $cod_c; global $debe_c; global $den_c; global $haber_c;
	global $total_comp; $ffechar=date("d-m-Y");$fhorar=date("H:i:s a");  $total_c=formato_monto($total_comp); 
		$this->SetY(-80); $y=$this->GetY(); $l=$y-0.2; $p=$y+5.1;
		$this->SetFillColor(192,192,192);
		
		$this->SetFont('Arial','B',8);		
		$this->Line(10,$l,210,$l);
		$this->Cell(180,5,'TOTAL ',0,0,'R');
		$this->Cell(19.8,5,$total_c,0,1,'R');
        $this->Line(10,$y,10,$y+5);	
        
		
		
		/* */
		$this->SetFont('Arial','B',8);
		$this->Cell(200,4,'CONTABILIDAD',1,1,'C',true);		
		$this->Cell(30,4,'CODIGO CONTABLE',1,0,'C',true);
		$this->Cell(128,4,'NOMBRE DE LA CUENTA',1,0,'C',true);
		$this->Cell(22,4,'DEBE',1,0,'C',true);
		$this->Cell(20,4,'HABER',1,1,'C',true);
		$z=$this->GetY();
		if($cant_cont>$max_ccont){ $l=($max_ccont-1)*3; $m=($l/2);
		   $this->Ln($m);
		   $this->Cell(180,3,'VER RELACION ANEXA',0,1,'C');
		   $this->Ln($m);
		}else{ for ($k=0; $k<$max_ccont; $k++) {  $this->SetFont('Arial','',7.5);
		  $this->Cell(30,3,$cod_c[$k],0,0,'L'); 
	      $this->Cell(128,3,$den_c[$k],0,0,'L'); 					
	      $this->Cell(22,3,$debe_c[$k],0,0,'R');
          $this->Cell(20,3,$haber_c[$k],0,1,'R'); 		  
		} }
		$y=$this->GetY();
        $this->Line(40,$z,40,$y-0.1);
		$this->Line(168,$z,168,$y-0.1);
        $this->Line(190,$z,190,$y-0.1);		
		
		
		$y=$this->GetY();
		$this->Line(10,$y,210,$y);	
		
		
        $this->SetFont('Arial','',8);		
		$this->Cell(200,18,' ',0,1,'C');		
		$this->Cell(200,2,'__________________________________',0,1,'C');	
		$this->Cell(200,4,'FIRMA Y SELLO',0,1,'C');		
		$this->SetFillColor(255,0,0);
		$this->Ln(5);
		$this->SetFont('Arial','B',5);
		$this->Cell(100,3,'SIPAP ORDENAMIENTO DE PAGO',0,0,'L');
		$this->Cell(100,3,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
	}
}  
  $pdf=new PDF('P', 'mm', Letter);
  $pdf->AliasNbPages();
  $pdf->AddPage();  
  $pdf->SetFont('Arial','',8);
  $pdf->SetAutoPageBreak(true, 80);  
  $i=0;  $res=pg_query($sql);$filas=pg_num_rows($res);
  while(($registro=pg_fetch_array($res)) and ($i<=$max_cpre) ){ $i=$i+1;  
    $monto=formato_monto($registro["monto"]);  $denominacion=$registro["denominacion"];	
	if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}	
	$pdf->Cell(40,4,$registro["cod_presup"],0,0,'C'); 
	$x=$pdf->GetX();   $y=$pdf->GetY(); $n=140; 	   
	$pdf->SetXY($x+$w+$n,$y);
	$pdf->Cell(20,4,$monto,0,1,'R'); 
	$pdf->SetXY($x,$y);
	$pdf->MultiCell(140,3,$denominacion,0); 
	$total_comp=$total_comp+$registro["monto"];
  }	
 $pdf->Output();
 pg_close($conn);
?> 
