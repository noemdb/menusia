<?include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php");include ("../../class/configura.inc");include ("../../class/conect.php");  $php_os=PHP_OS;
if (!$_GET){$cod_banco='';$referencia=''; $tipo_mov='';}  else{$cod_banco=$_GET["cod_banco"];$referencia=$_GET["referencia"];$tipo_mov=$_GET["tipo_mov"];}
$sql="Select * from MOV_LIBROS where cod_banco='$cod_banco' and referencia='$referencia' and tipo_mov_libro='$tipo_mov'"; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){ $php_os="WINNT";} }
$nombre_banco="";$nro_cuenta="";$des_tipo_mov="";$referencia=""; $tipo_mov="";$nombre_benef=""; $ced_rif=""; $descripcion=""; $monto_mov_libro=0; $fecha=""; $inf_usuario=""; $anulado="N"; $mes_conciliacion="00"; $fecha_anulado="";
$res=pg_query($sql);$filas=pg_num_rows($res);
if($filas>=1){$registro=pg_fetch_array($res,0);
  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"];$nro_cuenta=$registro["nro_cuenta"]; $anulado=$registro["anulado"]; $mes_conciliacion=$registro["mes_conciliacion"]; $fecha_anulado=$registro["fecha_anulado"];
  $des_tipo_mov=$registro["descrip_tipo_mov"]; $referencia=$registro["referencia"];  $tipo_mov=$registro["tipo_mov_libro"];   $fecha=$registro["fecha_mov_libro"]; $por_emision=$registro["por_emision"]; $cod_bancoa=$registro["cod_bancoa"];
  $monto_mov_libro=$registro["monto_mov_libro"]; $descripcion=$registro["descrip_mov_libro"];  $nombre_benef=$registro["nombre"]; $ced_rif=$registro["ced_rif"]; $inf_usuario=$registro["inf_usuario"];
}else{ echo $sql;} $total_debe=0; $total_haber=0; $ref_comp=$referencia; 
$clave=$cod_banco.$referencia.$tipo_mov;  $monto_mov_libro=formato_monto($monto_mov_libro); $monto_letras=monto_letras($monto_mov_libro); 
if($fecha==""){$fecha="";}else{$fecha=formato_ddmmaaaa($fecha);}  if($fecha==""){$sfecha="0000000000";}else{$sfecha=formato_aaaammdd($fecha);}  $criterio=$sfecha.$referencia.'B'.$cod_banco;if(($anulado=='S')and(($tipo_mov=="ANU")or($tipo_mov=="ANC")or($tipo_mov=="AND"))){$criterio=$sfecha.'A'.substr($referencia,1,7).'B'.$cod_banco; $ref_comp='A'.substr($referencia,1,7);}

$tipo_comp="B".$cod_banco; $ano=substr($fecha,6,4); $mes=substr($fecha,3,2);
if ($mes=="01"){$mes="ENERO";}else{if ($mes=="02"){$mes="FEBRERO";}else{if ($mes=="03"){$mes="MARZO";}else {if ($mes=="04"){$mes="ABRIL";}else {if ($mes=="05"){$mes="MAYO";}else {if ($mes=="06"){$mes="JUNIO";}else {if ($mes=="07"){$mes="JULIO";}else {if ($mes=="08"){$mes="AGOSTO";}else {if ($mes=="09"){$mes="SEPTIEMBRE";}else {if ($mes=="10"){$mes="OCTUBRE";}else {if ($mes=="11"){$mes="NOVIEMBRE";}else {$mes="DICIEMBRE";}}}}}}}}}}}
$lugar="BARQUISIMETO, ".substr($fecha,0,2)." DE ".$mes; 
$tipo_rpt="1"; $sub_total_columna1=0; $sub_total_columna2=0;
//if(($tipo_mov=="NDB")and($por_emision<>"N")){ $tipo_rpt="2"; 
if(($tipo_mov=="NDB")){ $tipo_rpt="3";
$tipo_pago="0".substr($cod_bancoa,1,3);  $tipo_n=substr($cod_bancoa,0,1); $nro_orden="";
$cod_c=array ('','','','','','','','','','','','','','',''); $debe_c=array ('','','','','','','','','','','','','','','');
$den_c=array ('','','','','','','','','','','','','','',''); $haber_c=array ('','','','','','','','','','','','','','','');
$cod_p=array ('','','','','','','','','','','','','','',''); $fuente_p=array ('','','','','','','','','','','','','','','');
$den_p=array ('','','','','','','','','','','','','','',''); $monto_p=array ('','','','','','','','','','','','','','','');
$k=0; $max_ccont=15; $cant_cont=0;
$sql="SELECT * FROM CUENTAS_COMPROB where text(fecha)='$sfecha' and referencia='$ref_comp' and tipo_comp='$tipo_comp' order by debito_credito desc,cod_cuenta"; $res=pg_query($sql);
while($registro=pg_fetch_array($res)){$monto_asiento=$registro["monto_asiento"]; $monto_asiento=formato_monto($monto_asiento);if ($registro["debito_credito"]=="D"){$debe=$monto_asiento;$haber="";}else{$debe="";$haber=$monto_asiento;} 
$cod_c[$k]=$registro["cod_cuenta"]; $den_c[$k]=$registro["nombre_cuenta"]; $debe_c[$k]=$debe; $haber_c[$k]=$haber; if($k<15){$k=$k+1;}} $cant_cont=$k;
$total_p=0; $k=0; $max_cpre=15; $cant_pre=0;		  
$sqlc="SELECT cod_presup,fuente_financ,denominacion,sum(monto) as monto_chq FROM codigos_pagos where referencia_pago='$referencia' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' group by cod_presup,fuente_financ,denominacion order by cod_presup,fuente_financ";
$resc=pg_query($sqlc); $filas=pg_num_rows($resc); $cant_cod_presup=$filas; $max_cpre=15; 
while($registro=pg_fetch_array($resc)){   $monto=formato_monto($registro["monto_chq"]); $total_p=$total_p+$registro["monto_chq"];	$cod_p[$k]=$registro["cod_presup"]; $fuente_p[$k]=$registro["fuente_financ"];$den_p[$k]=$registro["denominacion"];   $monto_p[$k]=$monto; if($k<15){$k=$k+1;} $cant_pre=$k; }
if($tipo_n=="P"){
 $sqlc="SELECT  referencia_caus FROM pre008 where referencia_pago='$referencia' and cod_banco='$cod_banco' and tipo_pago='$tipo_pago' order by referencia_caus";
 $resc=pg_query($sqlc); $filas=pg_num_rows($resc); if($filas>=1){$regc=pg_fetch_array($resc,0);  $nro_orden=$regc["referencia_caus"]; }
}
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
			$pdf->Cell(135,3,$denominacion,0,0,'L');
			$pdf->Cell(25,3,$monto,0,1,'R');
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
	
	if($tipo_rpt=="3"){ 
	   require('../../class/fpdf/fpdf.php');
class PDF extends FPDF{ 
	function Header(){global $monto_mov_libro; global $nombre_benef; global $monto_letras; global $lugar; global $ano; global $nombre_banco; 
	   global $concepto; global $nro_cuenta; global $referencia; global $fecha; global $nro_orden;  global $fecha_hoy;        
		$this->AddFont('lucon','','lucon.php');			        		
		$this->SetFont('lucon','',10);		
		$this->Cell(200,10,'',0,1,'L');
		$this->Cell(140,4,'',0,0,'L');
		$this->Cell(60,4,$fecha_hoy,0,1,'L');	
        $this->Cell(200,5,'',0,1,'L');		
		$this->Cell(145,4,'',0,0,'L');		
		$this->Cell(45,4,'***'.$monto_mov_libro.'***',0,0,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(10,2,'',0,1,'L');
		$this->SetFont('lucon','',12);
		$this->Cell(200,4,'NO ENDOSABLE',0,1,'C');
		$this->Cell(200,3,'',0,1,'L');
		$this->SetFont('lucon','',10);
		$this->ln();
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(160,4,'***'.$nombre_benef.'***',0,0,'L');
		$this->Cell(15,4,'',0,1,'L');
		$this->SetFont('lucon','',2);		
		$this->Cell(200,2,'',0,1,'L');
		$this->SetFont('lucon','',10);
		$long_line=70; $part1=$monto_letras; $part2=' '; $l=strlen($part1); if($l>$long_line){$part1=substr($monto_letras,0,$long_line); }
        $lp=strlen($part1);  $c2=$lp; $care="N"; 
        if($l>=$long_line){ for($h=$lp-1; $h>0; $h--){  $care=substr($part1,$h,1); if($care==" ") {$c2=$h; $h=0; } }  $part1=substr($monto_letras,0,$c2); }       
        $part2=substr($monto_letras,$c2,$long_line);
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(160,4,$part1,0,0,'L');
		$this->Cell(5,4,'',0,1,'L');
		$this->Cell(200,2,'',0,1,'L');
		$this->Cell(10,4,'',0,0,'L');
		$this->Cell(170,4,$part2,0,0,'L');
		$this->Cell(10,4,'',0,1,'L');
		$this->Cell(200,2,'',0,1,'L');
		$this->Cell(74,4,$lugar,0,0,'L');
		$this->Cell(96,4,$ano,0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->Cell(200,4,'',0,1,'L');
		$this->SetFont('lucon','',12);
        $this->Cell(60,4,'',0,0,'L');
		$this->Cell(100,4,'CADUCA A LOS 90 DIAS',0,0,'C');
		$this->Cell(20,4,'',0,1,'L');
        $this->SetFont('lucon','',10);		
		$this->Cell(200,18,'',0,1,'L');	
		$this->Cell(70, 4, $nombre_banco, 0, 0, 'C');
		$this->Cell(40, 4, $referencia, 0, 0, 'C');
		$this->Cell(45,4,$nro_cuenta,0,0,'L');
        $this->Cell(40, 4, $nro_orden, 0, 1, 'C');		
        $this->Cell(200, 5, '', 0, 1, 'L');
        $this->SetFont('lucon', '', 10);        
		$this->Cell(5, 4, '', 0, 0, 'L');
		$this->MultiCell(195,4,$concepto,0); 
		$y=$this->GetY();
		if($y<150){$t=150-$y; $this->ln($t);}    
	}
    function Footer(){ 
	   $this->SetY(-10);
    }
}

$pdf = new PDF('P', 'mm', Letter);
$pdf->AliasNbPages();
$pdf->SetMargins(10,5,10);
$pdf->AddPage();
$pdf->SetFont('lucon', '', 9);
$z = $pdf->GetY();
	for ($k = 0; $k < $max_ccont; $k++) {
	    $temp1=substr($cod_p[$k],0,9); $temp2=substr($cod_p[$k],10,15);
	    $pdf->Cell(40, 3, $temp1, 0, 0, 'C');
		$pdf->Cell(40, 3, $temp2, 0, 0, 'C');
		$pdf->Cell(30, 3, $monto_p[$k], 0, 0, 'R');
		$pdf->Cell(5, 3, " ", 0, 0, 'C');
		$pdf->Cell(30, 3, $cod_c[$k], 0, 0, 'C');
		$pdf->Cell(30, 3, $debe_c[$k], 0, 0, 'R');
		$pdf->Cell(30, 3, $haber_c[$k], 0, 1, 'R');
	}
 $pdf->Output();
	
	}
 pg_close();
?>
