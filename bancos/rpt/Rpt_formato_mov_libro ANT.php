<?include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php");include ("../../class/configura.inc");include ("../../class/conect.php");  $php_os=PHP_OS; error_reporting(E_ALL ^ E_NOTICE); 
if (!$_GET){$cod_banco='';$referencia=''; $tipo_mov='';}  else{$cod_banco=$_GET["cod_banco"];$referencia=$_GET["referencia"];$tipo_mov=$_GET["tipo_mov"];}
$sql="Select * from MOV_LIBROS where cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";} }
$nombre_banco="";$nro_cuenta="";$des_tipo_mov="";$referencia=""; $tipo_mov="";$nombre_benef=""; $ced_rif=""; $descripcion=""; $monto_mov_libro=0; $fecha=""; $inf_usuario=""; $anulado="N"; $mes_conciliacion="00"; $fecha_anulado="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"];$nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"]; $mes_conciliacion=$registro["mes_conciliacion"]; $fecha_anulado=$registro["fecha_anulado"];
  $des_tipo_mov=$registro["descrip_tipo_mov"]; $referencia=$registro["referencia"];  $tipo_mov=$registro["tipo_mov_libro"];   $fecha=$registro["fecha_mov_libro"]; $por_emision=$registro["por_emision"]; $cod_bancoa=$registro["cod_bancoa"];
  $monto_mov_libro=$registro["monto_mov_libro"]; $descripcion=$registro["descrip_mov_libro"];  $nombre_benef=$registro["nombre"]; $ced_rif=$registro["ced_rif"]; $inf_usuario=$registro["inf_usuario"];
} $total_debe=0; $total_haber=0; $ref_comp=$referencia;
$clave=$cod_banco.$referencia.$tipo_mov;  $monto_mov_libro=formato_monto($monto_mov_libro); 
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}  if($fecha==""){$sfecha="0000000000";}else{$sfecha=formato_aaaammdd($fecha);}  $criterio=$sfecha.$referencia.'B'.$cod_banco;if(($anulado=='S')and(($tipo_mov=="ANU")or($tipo_mov=="ANC")or($tipo_mov=="AND"))){$criterio=$sfecha.'A'.substr($referencia,1,7).'B'.$cod_banco; $ref_comp='A'.substr($referencia,1,7);}
//$monto_letras= monto_en_letras($monto_mov_libro); 
$tipo_comp="B".$cod_banco; $lugar="BARQUISIMETO, ".substr($fecha,0,5); $ano=substr($fecha,6,4);
$tipo_rpt="1"; $sub_total_columna1=0; $sub_total_columna2=0;
if(($tipo_mov=="NDB")and($por_emision<>"N")){ $tipo_rpt="2"; $tipo_pago="0".substr($cod_bancoa,1,3);
$sqlc="SELECT cod_presup,denominacion,sum(monto) as monto_chq FROM codigos_pagos where referencia_pago='$referencia' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' group by cod_presup,denominacion order by cod_presup";
$resc=pg_query($sqlc); $filas=pg_num_rows($resc); $cant_cod_presup=$filas; $max_cpre=35; 
}
    if($tipo_rpt=="1"){  
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $Nom_Emp;  global $cod_banco; global $referencia; global $tipo_mov; global $des_tipo_mov; global $monto_mov_libro;
			    global $fecha; global $nombre_banco; global $nro_cuenta; global $descripcion; global $nombre_benef; global $ced_rif;
				$this->Image('../../imagenes/logo escudo.png',12,8,13);
				$this->rect(10,5,200,267);
				$this->SetFont('Arial','B',10);
				$this->Cell(20);
				$this->Cell(150,5,$Nom_Emp,0,0,'L');
				$this->SetFont('Arial','B',7);
				$this->Cell(30,5,'Pagina '.$this->PageNo(),0,1,'R');
				$this->SetFont('Arial','B',13);
				$this->Cell(40);
				$this->Cell(130,10,'FORMATO '.$des_tipo_mov,0,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',9);
				$this->Cell(25,6,'REFERENCIA:','TB',0,'L');
				$this->SetFont('Arial','',9);
				$this->Cell(33,6,$referencia,'TB',0,'L');
				$this->SetFont('Arial','B',9);
				$this->Cell(27,6,'FECHA :','TB',0,'L');
				$this->SetFont('Arial','',9);
				$this->Cell(55,6,$fecha,'TB',0,'L');
				$this->SetFont('Arial','B',9);
				$this->Cell(30,6,'MONTO :','TB',0,'L');
				$this->SetFont('Arial','',9);
				$this->Cell(30,6,$monto_mov_libro,'TB',1,'R');
				
				$this->SetFont('Arial','B',9);
				$this->Cell(20,6,'BANCO :','TB',0,'L');
				$this->SetFont('Arial','',9);
				$this->Cell(105,6,$cod_banco." ".$nombre_banco,'TB',0,'L');
				$this->SetFont('Arial','B',9);
				$this->Cell(30,6,'CUENTA NRO. :','TB',0,'L');
				$this->SetFont('Arial','',9);
				$this->Cell(45,6,$nro_cuenta,'TB',1,'L');
				
				$this->SetFont('Arial','B',9);
				$this->Cell(24,6,'BENEFICIARIO: ','TB',0,'L');
				$this->SetFont('Arial','',8);
				$this->Cell(133,6,$nombre_benef,'TB',0,'L');
				$this->SetFont('Arial','B',9);
				$this->Cell(22,6,'CEDULA/RIF : ','TB',0,'L');
				$this->SetFont('Arial','',9);
				$this->Cell(21,6,$ced_rif,'TB',1,'L');
		
				$this->SetFont('Arial','B',9);
				$this->Cell(40,4,"POR CONCEPTO DE : ",0,1);
				$this->SetFont('Arial','',9);
				$this->MultiCell(200,3,$descripcion,0);
				$this->Cell(200,3,' ','B',1,'C');
				$this->SetFillColor(192,192,192);
				$this->Cell(200,5,'CONTIBILIDAD FINANCIERA/FISCAL',1,1,'C',true);
				$this->Cell(30,5,'CODIGO CUENTA',1,0,'C',true);
				$this->Cell(130,5,'NOMBRE CUENTA',1,0,'C',true);	
				$this->Cell(20,5,'DEBE',1,0,'C',true);
				$this->Cell(20,5,'HABER',1,1,'C',true);
			}
			function Footer(){ global $total_columna1; global $total_columna2; $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$sub_total_c1=formato_monto($total_columna1); $sub_total_c2=formato_monto($total_columna2); 
				$this->SetFillColor(192,192,192);
				$this->SetY(-40); $y=$this->GetY(); $l=$y-0.2; 
				$this->SetFont('Arial','B',9);
				$this->Line(10,$l,210,$l);
				$this->Cell(160,5,'TOTALES : ',0,0,'R');
				$this->Cell(20,5,$sub_total_c1,0,0,'R');
				$this->Cell(20,5,$sub_total_c2,0,1,'R');
				
				$this->SetFont('Arial','B',7);
				$this->Cell(100,3,'ELABORADO POR: ',1,0,'C',true);
				$this->Cell(100,3,'CONTABILIDAD: ',1,1,'C',true);
		
				$this->SetFont('Arial','',6);		
				$this->Cell(100,16,'','LR',0,'C');
				$this->Cell(100,16,'','R',1,'C');		
				$this->Cell(100,4,'Firma:','LR',0,'L');
				$this->Cell(100,4,'Firma:','R',1,'L');
				$this->Cell(100,4.5,'Sello:','R',0,'L');
				$this->Cell(100,4.5,'Sello:','R',1,'L');	
				
			}
		}		  
		$pdf=new PDF('P', 'mm', Letter);
		$pdf->SetAutoPageBreak(true, 40);  
		$pdf->AliasNbPages();
		$pdf->AddPage();
		  
		$pdf->SetFont('Arial','',8);
		$i=0; $total_columna1=0; $total_columna2=0; 		  
		$sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$ref_comp' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql); 
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		     $monto_a=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_a); $codigo_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"];
             if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";$total_columna1=$total_columna1+$monto_a;}else{$debe="";$haber=$monto_asiento; $total_columna2=$total_columna2+$monto_a;}
             if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"];}else{$nombre_cuenta=utf8_decode($registro["nombre_cuenta"]); } 		     
			 $pdf->SetFont('Arial','',8);	
		   	 $pdf->Cell(30,4,$codigo_cuenta,0,0);
			 $x=$pdf->GetX();   $y=$pdf->GetY(); $n=130; 			   
			 $pdf->SetXY($x+$n,$y);
			 $pdf->Cell(20,4,$debe,0,0,'R');
             $pdf->Cell(20,4,$haber,0,1,'R'); 				
			 $pdf->SetXY($x,$y);
			 $pdf->MultiCell($n,4,$nombre_cuenta,0); 
		} 
		$pdf->Output();     
	}
	
	if($tipo_rpt=="2"){  
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $Nom_Emp;  global $cod_banco; global $referencia; global $tipo_mov; global $des_tipo_mov; global $monto_mov_libro;
			    global $fecha; global $nombre_banco; global $nro_cuenta; global $descripcion; global $nombre_benef; global $ced_rif;
				$this->Image('../../imagenes/logo escudo.png',12,8,13);
				$this->rect(10,5,200,267);
				$this->SetFont('Arial','B',10);
				$this->Cell(20);
				$this->Cell(150,5,$Nom_Emp,0,0,'L');
				$this->SetFont('Arial','B',7);
				$this->Cell(30,5,'Pagina '.$this->PageNo(),0,1,'R');
				$this->SetFont('Arial','B',13);
				$this->Cell(40);
				$this->Cell(130,10,'FORMATO NOTA DE DEBITO',0,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',9);
				$this->Cell(25,6,'REFERENCIA:','TB',0,'L');
				$this->SetFont('Arial','',9);
				$this->Cell(33,6,$referencia,'TB',0,'L');
				$this->SetFont('Arial','B',9);
				$this->Cell(27,6,'FECHA :','TB',0,'L');
				$this->SetFont('Arial','',9);
				$this->Cell(55,6,$fecha,'TB',0,'L');
				$this->SetFont('Arial','B',9);
				$this->Cell(30,6,'MONTO :','TB',0,'L');
				$this->SetFont('Arial','',9);
				$this->Cell(30,6,$monto_mov_libro,'TB',1,'R');
				
				$this->SetFont('Arial','B',9);
				$this->Cell(20,6,'BANCO :','TB',0,'L');
				$this->SetFont('Arial','',9);
				$this->Cell(105,6,$cod_banco." ".$nombre_banco,'TB',0,'L');
				$this->SetFont('Arial','B',9);
				$this->Cell(30,6,'CUENTA NRO. :','TB',0,'L');
				$this->SetFont('Arial','',9);
				$this->Cell(45,6,$nro_cuenta,'TB',1,'L');
				
				$this->SetFont('Arial','B',9);
				$this->Cell(24,6,'BENEFICIARIO: ','TB',0,'L');
				$this->SetFont('Arial','',8);
				$this->Cell(133,6,$nombre_benef,'TB',0,'L');
				$this->SetFont('Arial','B',9);
				$this->Cell(22,6,'CEDULA/RIF : ','TB',0,'L');
				$this->SetFont('Arial','',9);
				$this->Cell(21,6,$ced_rif,'TB',1,'L');
		
				$this->SetFont('Arial','B',9);
				$this->Cell(40,4,"POR CONCEPTO DE : ",0,1);
				$this->SetFont('Arial','',9);
				$this->MultiCell(200,3,$descripcion,0);
				$this->Cell(200,3,' ','B',1,'C');
				$this->SetFillColor(192,192,192);
				$this->Cell(200,5,'CONTIBILIDAD PRESUPUESTARIA',1,1,'C',true);
				$this->Cell(40,4,'CODIGO ',1,0,'C',true);
				$this->Cell(135,4,'DENOMINACION',1,0,'C',true);
		        $this->Cell(25,4,'MONTO',1,1,'C',true);
		
		        
			}
			function Footer(){ global $total_columna1; global $total_columna2; $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$sub_total_c1=formato_monto($total_columna1); $sub_total_c2=formato_monto($total_columna2); 
				$this->SetFillColor(192,192,192);
				$this->SetY(-40); $y=$this->GetY(); $l=$y-0.2; 
				$this->SetFont('Arial','B',9);
				$this->Line(10,$l,210,$l);
				$this->Cell(160,5,'TOTALES : ',0,0,'R');
				$this->Cell(20,5,$sub_total_c1,0,0,'R');
				$this->Cell(20,5,$sub_total_c2,0,1,'R');
				
				$this->SetFont('Arial','B',7);
				$this->Cell(100,3,'ELABORADO POR: ',1,0,'C',true);
				$this->Cell(100,3,'CONTABILIDAD: ',1,1,'C',true);
		
				$this->SetFont('Arial','',6);		
				$this->Cell(100,16,'','LR',0,'C');
				$this->Cell(100,16,'','R',1,'C');		
				$this->Cell(100,4,'Firma:','LR',0,'L');
				$this->Cell(100,4,'Firma:','R',1,'L');
				$this->Cell(100,4.5,'Sello:','R',0,'L');
				$this->Cell(100,4.5,'Sello:','R',1,'L');	
				
			}
		}		  
		$pdf=new PDF('P', 'mm', Letter);
		$pdf->SetAutoPageBreak(true, 40);  
		$pdf->AliasNbPages();
		$pdf->AddPage();
		  
		$pdf->SetFont('Arial','',8);
		if($cant_cod_presup>$max_cpre){
			$pdf->Ln(18);
			$pdf->Cell(180,3,'VER RELACION ANEXA',0,1,'C');
			$c=($max_cpre-7)*3;
			$pdf->Ln($c);
		}else{ $i=0;
		  $sql="SELECT cod_presup,denominacion,sum(monto) as monto_chq FROM codigos_pagos where referencia_pago='$referencia' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' group by cod_presup,denominacion order by cod_presup"; $res=pg_query($sql); 
		  //$pdf->SetFont('Arial','',5);
		  //$pdf->Cell(180,3,$sql,0,1,'C');
		  $pdf->SetFont('Arial','',8);
		  while($registro=pg_fetch_array($res)){ $monto=formato_monto($registro["monto_chq"]); $total=$total+$registro["monto_chq"];$total=formato_monto($total); $denominacion=$registro["denominacion"]; 
			$denominacion=substr($denominacion,0,100); if($php_os=="WINNT"){$denominacion=$denominacion;}else{$denominacion=utf8_decode($denominacion);}
			$pdf->Cell(40,3,$registro["cod_presup"],0,0,'L');
			$x=$pdf->GetX();   $y=$pdf->GetY(); $n=133; 			   
			$pdf->SetXY($x+$n,$y);
			//$pdf->Cell(135,3,$denominacion,0,0,'L');
			$pdf->Cell(25,3,$monto,0,1,'R');
			$pdf->SetXY($x,$y);
			$pdf->MultiCell($n,3,$denominacion,0); 
			$i=$i+1;
		  }
		  $c=($max_cpre-$i)*3;
		  if($c>=1){$pdf->Ln($c);}
		}  
		$pdf->SetFillColor(192,192,192);
       $pdf->Cell(200,5,'CONTIBILIDAD FINANCIERA/FISCAL',1,1,'C',true);
				$pdf->Cell(30,5,'CODIGO CUENTA',1,0,'C',true);
				$pdf->Cell(130,5,'NOMBRE CUENTA',1,0,'C',true);	
				$pdf->Cell(20,5,'DEBE',1,0,'C',true);
				$pdf->Cell(20,5,'HABER',1,1,'C',true);
		$pdf->SetFont('Arial','',8);
		$i=0; $total_columna1=0; $total_columna2=0; 		  
		$sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$ref_comp' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta";$res=pg_query($sql); 
		while($registro=pg_fetch_array($res)){ $i=$i+1; 
		     $monto_a=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_a); $codigo_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"];
             if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";$total_columna1=$total_columna1+$monto_a;}else{$debe="";$haber=$monto_asiento; $total_columna2=$total_columna2+$monto_a;}
             if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"];}else{$nombre_cuenta=utf8_decode($registro["nombre_cuenta"]); } 		     
			 $pdf->SetFont('Arial','',8);	
		   	 $pdf->Cell(30,4,$codigo_cuenta,0,0);
			 $x=$pdf->GetX();   $y=$pdf->GetY(); $n=130; 			   
			 $pdf->SetXY($x+$n,$y);
			 $pdf->Cell(20,4,$debe,0,0,'R');
             $pdf->Cell(20,4,$haber,0,1,'R'); 				
			 $pdf->SetXY($x,$y);
			 $pdf->MultiCell($n,4,$nombre_cuenta,0); 
		} 
		$pdf->Output();     
	}
 pg_close();
?>
