<?include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php");include ("../../class/configura.inc");include ("../../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS;
 $periodo=$_GET["periodo"];  $cod_cuenta_d=$_GET["cod_cuenta_d"]; $cod_cuenta_h=$_GET["cod_cuenta_h"]; $tipo_res=$_GET["tipo_res"];
 $conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
 if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?} else{ $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){ $php_os="WINNT";} }
 $fecha_d=Armar_Fecha($periodo, 1, $Fec_Ini_Ejer); $fecha_h=Armar_Fecha($periodo, 2, $Fec_Ini_Ejer);
 $criterio1="Desde ".$fecha_d." Al ".$fecha_h; $Sql="";
 if($fecha_d==""){$sfecha_d="2011-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);} if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}

$nro_linea=0; $cod_cuenta=""; $nom_cuenta=""; $c=0;  $prev_cuenta=""; $prev_fecha=""; $prev_deb_cre=""; 
$Sql="SELECT ELIMINA_CON013('".$usuario_sia."','6')"; $resultado=pg_exec($conn,$Sql);$error=pg_errormessage($conn); $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
else{ 

 $criterio=" (con003.cod_cuenta>='".$cod_cuenta_d."'and con003.cod_cuenta<='".$cod_cuenta_h."') and (con002.fecha>='".$sfecha_d."'and con002.fecha<='".$sfecha_h."') ";
 $criterio=$criterio." and (con002.tipo_asiento<>'TRC') And (con002.tipo_asiento<>'TRD') ";
 
if($tipo_res=="T"){  
  /*
 $criterio=$criterio." and (con002.tipo_asiento<>'RDP') And (con002.tipo_asiento<>'RNC') ";
 $criterio=$criterio." and (text(con002.fecha)||text(con002.referencia)||text(con002.tipo_comp) not in (SELECT text(con002.fecha)||text(con002.referencia)||text(con002.tipo_comp) FROM con002 where (cod_cuenta='1-1-102-03-03-0002' or cod_cuenta='1-1-110-03-03-0002' or cod_cuenta='1-1-110-03-03-0002') or (substring(cod_cuenta,1,7)='1-1-126' and modulo<>'B') ) )";
 $criterio=$criterio." and ( (substring(con003.cod_cuenta,1,10)='1-1-102-02') or (substring(con003.cod_cuenta,1,10)='1-1-102-03') or (substring(con003.cod_cuenta,1,7)='1-1-110') or (substring(con003.cod_cuenta,1,7)='1-1-122')  or (substring(con003.cod_cuenta,1,7)='1-2-101') 
  or (substring(con003.cod_cuenta,1,7)='1-1-132') or (substring(con003.cod_cuenta,1,7)='1-2-133') or (substring(con003.cod_cuenta,1,7)='1-1-130')  or (substring(con003.cod_cuenta,1,7)='1-2-131') or (substring(con003.cod_cuenta,1,7)='3-2-301') or (substring(con003.cod_cuenta,1,7)='3-2-303') 
  or ((con002.tipo_asiento='NDB' OR con002.tipo_asiento='CHQ' OR con002.tipo_asiento='ANU' OR con002.tipo_asiento='AND') and (modulo='B')) 
  or ((substring(con003.cod_cuenta,1,7)='1-1-126') and (con002.tipo_asiento='NCR' OR con002.tipo_asiento='DEP' OR con002.tipo_asiento='ANC') and (modulo='B')) 
  or ((substring(con003.cod_cuenta,1,10)='1-1-128-01') and (con002.tipo_asiento='CHQ' OR con002.tipo_asiento='ANU' OR con002.tipo_asiento='DEP') and (modulo='B')) )";
*/
  
 // or ((substring(con003.cod_cuenta,1,7)='3-1-300') and (con002.tipo_asiento='NDB' OR con002.tipo_asiento='CHQ' OR con002.tipo_asiento='ANU' OR con002.tipo_asiento='AND') and (modulo='B')) 
 //$criterio=$criterio." and (text(con002.fecha)||text(con002.referencia)||text(con002.tipo_comp) not in (SELECT text(con002.fecha)||text(con002.referencia)||text(con002.tipo_comp) FROM con002,con003 where con002.referencia=con003.referencia and con002.fecha=con003.fecha and con002.tipo_comp=con003.tipo_comp and (con003.cod_cuenta='1-1-102-03-03-0002' or cod_cuenta='1-1-110-03-03-0002' or (substring(cod_cuenta,1,7)='1-1-126' and (modulo<>'B')) ) ) )";
 
 
 $criterio=$criterio." and (con002.tipo_asiento<>'RDP') And (con002.tipo_asiento<>'RNC') ";
 $criterio=$criterio." and (text(con002.fecha)||text(con002.referencia)||text(con002.tipo_comp) not in (SELECT text(con002.fecha)||text(con002.referencia)||text(con002.tipo_comp) FROM con002,con003 where con002.referencia=con003.referencia and con002.fecha=con003.fecha and con002.tipo_comp=con003.tipo_comp and (con003.cod_cuenta='1-1-102-03-03-0002' or cod_cuenta='1-1-110-03-03-0002'  ) ) )";
 $criterio=$criterio." and ( (substring(con003.cod_cuenta,1,10)='1-1-102-02') or (substring(con003.cod_cuenta,1,10)='1-1-102-03') or (substring(con003.cod_cuenta,1,7)='1-1-110') or (substring(con003.cod_cuenta,1,7)='1-1-122')  or (substring(con003.cod_cuenta,1,7)='1-2-101') 
  or (substring(con003.cod_cuenta,1,7)='1-1-132') or (substring(con003.cod_cuenta,1,7)='1-2-133') or (substring(con003.cod_cuenta,1,7)='1-1-130')  or (substring(con003.cod_cuenta,1,7)='1-2-131') or (substring(con003.cod_cuenta,1,7)='3-2-301') or (substring(con003.cod_cuenta,1,7)='3-2-303')  
  or ((substring(con003.cod_cuenta,1,10)='1-1-128-01') and (con002.tipo_asiento='CHQ' OR con002.tipo_asiento='ANU' OR con002.tipo_asiento='DEP') and (modulo='B')) 
  or ((substring(con003.cod_cuenta,1,7)='1-1-126') and (con002.tipo_asiento='DEP' OR con002.tipo_asiento='NCR') and (modulo='B'))  )";
 $sql="SELECT substring(con003.cod_cuenta,1,7) as cuenta,con003.debito_credito,sum(con003.monto_asiento) as monto from con002,con003 where (con002.referencia=con003.referencia and con002.fecha=con003.fecha and con002.tipo_comp=con003.tipo_comp) and ((con002.modulo='I') or (con002.modulo='B')) and ".$criterio." group by substring(con003.cod_cuenta,1,7),con003.debito_credito order by substring(con003.cod_cuenta,1,7),con003.debito_credito "; 
  $temp_sql=$sql;
 $resultado=pg_query($sql);  $c=0; $temp1=$sql;  $nro_linea=0; $sfecha=$sfecha_h;
 while($registro=pg_fetch_array($resultado)){ 
      $cod_cuenta=$registro["cuenta"]; $monto=$registro["monto"]; $debito_credito=$registro["debito_credito"]; 
      $sSQL="Select con001.nombre_cuenta,con001.tsaldo from con001 WHERE codigo_cuenta='$cod_cuenta'"; $resc=pg_query($sSQL); $filasc=pg_num_rows($resc);
      if ($filasc==0){$nombre=""; $tsaldo=""; }  else{ $regc=pg_fetch_array($resc); $nombre=$regc["nombre_cuenta"]; $tsaldo=$regc["tsaldo"]; }	  
	  if($debito_credito=="D"){ $monto1=$monto; $monto2=0; $grupo="0";} else { $monto2=$monto; $monto1=0; $grupo="1";}	  
	  $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','6',$nro_linea,'00000000','$sfecha','$debito_credito','$cod_cuenta','00000','','01','$grupo','N','$cod_cuenta','$nombre','$tsaldo','','','',$monto1,$monto2,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);	  
 } 
 $criterio=$criterio." and ( (substring(con003.cod_cuenta,1,10)='1-1-102-02') or (substring(con003.cod_cuenta,1,10)='1-1-102-03') )";
 $sql="SELECT substring(con003.cod_cuenta,1,10) as cuenta,con003.debito_credito,sum(con003.monto_asiento) as monto from con002,con003 where (con002.referencia=con003.referencia and con002.fecha=con003.fecha and con002.tipo_comp=con003.tipo_comp) and ((con002.modulo='I') or (con002.modulo='B')) and ".$criterio." group by substring(con003.cod_cuenta,1,10),con003.debito_credito order by substring(con003.cod_cuenta,1,10),con003.debito_credito "; 
 $resultado=pg_query($sql);  $c=0; $temp1=$sql;  $nro_linea=0; $sfecha=$sfecha_h;
 while($registro=pg_fetch_array($resultado)){ 
      $cod_cuenta=$registro["cuenta"]; $monto=$registro["monto"]; $debito_credito=$registro["debito_credito"]; 
      $sSQL="Select con001.nombre_cuenta,con001.tsaldo from con001 WHERE codigo_cuenta='$cod_cuenta'"; $resc=pg_query($sSQL); $filasc=pg_num_rows($resc);
      if ($filasc==0){$nombre=""; $tsaldo=""; }  else{ $regc=pg_fetch_array($resc); $nombre=$regc["nombre_cuenta"]; $tsaldo=$regc["tsaldo"]; }	
      $monto1=0; $monto2=0; $monto3=$monto;	  
	  if($debito_credito=="D"){  $grupo="0";} else {  $grupo="1";}	  
	  $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','6',$nro_linea,'00000000','$sfecha','$debito_credito','$cod_cuenta','00000','','01','$grupo','C','$cod_cuenta','$nombre','$tsaldo','','','',$monto1,$monto2,$monto3,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);	  
 } 
   $sSQL="SELECT * from CON013 Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') order by  doperacion,substr(cod_cuenta,5,3),cod_cuenta";
   if($nro_linea>0){ $fin_rpt=0;  
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',5);
			    $this->Cell(20);
			    $this->Cell(40,8,'GOBERNACIÓN DEL ESTADO YARACUY',0,0,'L');
				$this->SetFont('Arial','B',12);
				$this->Cell(120,8,'RESUMEN MENSUAL DEL MOVIMIENTO DE TESORERIA',1,1,'C');
				$this->SetFont('Arial','B',5);
				$this->Cell(20);
			    $this->Cell(30,4,'DIRECCIÓN DE TESORERIA',0,0,'L');
				$this->SetFont('Arial','B',10);				
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);
				$this->SetFont('Arial','B',7);
				$this->Cell(23,5,'CODIGO CUENTA',1,0,'L');
				$this->Cell(128,5,'NOMBRE DE CUENTA',1,0,'L');	
				$this->Cell(25,5,'DEBE',1,0,'R');
				$this->Cell(25,5,'HABER',1,1,'R');
				$this->Ln(2);
			}
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-20);
				$this->SetFont('Arial','B',7);
				$this->Cell(65,3,'___________________________________',0,0,'C');
				$this->Cell(65,3,'___________________________________',0,0,'C');
				$this->Cell(70,3,'_______________________________________',0,1,'C');			
				$this->Cell(65,3,'Director de Tesoreria(E)',0,0,'C');
				$this->Cell(65,3,'Contador',0,0,'C');
				$this->Cell(70,3,'Secretario(a) de Administracion Finanzas',0,1,'C');
                $this->Ln(7);		
				$this->SetFont('Arial','I',5);
				$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('P', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7); $d=0;
		  //$pdf->MultiCell(200,3,$temp_sql,0);
		  $i=0;  $total_columna1=0; $total_columna2=0;  $prev_codigo_cuenta="";  $prev_dc=""; $res=pg_query($sSQL);		 
		  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		       $cod_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; $columna1=$registro["columna1"]; $columna2=$registro["columna2"];  
			   $columna3=$registro["columna3"]; $columna4=$registro["columna4"]; $debito_credito=$registro["debito_credito"]; $status=$registro["status"];
			   $total_columna1=$total_columna1+$columna1; $total_columna2=$total_columna2+$columna2;			   
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta);}			   
			   if($prev_dc<>$debito_credito){
			     if($i>1){ $pdf->Ln(5);
				 //$pdf->AddPage(); 
				 }
				 $pdf->SetFont('Arial','B',8);
				 if($debito_credito=="D"){ $pdf->Cell(50,5,'   CUENTAS DEUDORAS',0,1,'L'); } else { $pdf->Cell(50,5,'   CUENTAS ACREEDORAS ',0,1,'L'); }
				 $pdf->SetFont('Arial','',7); $prev_dc=$debito_credito;
				 $pdf->Ln(2);
			   }
			   if($status=="N"){ if($columna1==0){$col1="";}else{$col1=formato_monto($columna1);}	   if($columna2==0){$col2="";}else{$col2=formato_monto($columna2);}	
				   if($d==1){
				     $pdf->Cell(130,1,"",0,0,'L'); 
					 $pdf->Cell(20,1,"",'T',1,'L'); 
				   } $d=0;
				   $mcuenta=substr($cod_cuenta,4,3);
				   $pdf->Cell(22,5,$mcuenta,0,0,'L'); 		   
				   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=128;		   
				   $pdf->SetXY($x+$w,$y);
				   $pdf->Cell(25,5,$col1,0,0,'R');
				   $pdf->Cell(25,5,$col2,0,1,'R');	   
				   $pdf->SetXY($x,$y);	
				   $pdf->MultiCell($w,5,$nombre_cuenta,0); }
			    else{ if($columna3==0){$col3="";}else{$col3=formato_monto($columna3);} $d=1;
				   $pdf->Cell(30,4,"",0,0,'L'); 		   
				   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=100;		   
				   $pdf->SetXY($x+$w,$y);
				   $pdf->Cell(20,4,$col3,0,1,'R');
				   $pdf->SetXY($x,$y);	
				   $pdf->MultiCell($w,4,$nombre_cuenta,0); }				
			   
			} $col1=formato_monto($total_columna1); $col2=formato_monto($total_columna2);
			$pdf->Ln(4);
			$pdf->SetFont('Arial','B',7); 
			$pdf->Cell(150,2,'',0,0);
			$pdf->Cell(25,2,'==============',0,0,'R');
			$pdf->Cell(25,2,'==============',0,1,'R');
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(150,5,' ',0,0,'R');
			$pdf->Cell(25,5,$col1,0,0,'R'); 
			$pdf->Cell(25,5,$col2,0,1,'R'); 
				
			$pdf->Output();    
	} 
}

if($tipo_res=="C"){ 
 $criterio=$criterio." and (con002.tipo_asiento<>'RDP') And (con002.tipo_asiento<>'RNC') "; 
 $criterio=$criterio." and (text(con002.fecha)||text(con002.referencia)||text(con002.tipo_comp) not in (SELECT text(con002.fecha)||text(con002.referencia)||text(con002.tipo_comp) FROM con002,con003 where con002.referencia=con003.referencia and con002.fecha=con003.fecha and con002.tipo_comp=con003.tipo_comp and (con003.cod_cuenta='1-1-102-03-03-0002' or cod_cuenta='1-1-110-03-03-0002' ) ) )";
 $criterio=$criterio." and (  (substring(con003.cod_cuenta,1,7)='1-1-132') or (substring(con003.cod_cuenta,1,7)='1-2-133') or (substring(con003.cod_cuenta,1,7)='1-1-130')  or (substring(con003.cod_cuenta,1,7)='1-2-131') or (substring(con003.cod_cuenta,1,7)='3-2-301') or (substring(con003.cod_cuenta,1,7)='3-2-303')  
  or ((substring(con003.cod_cuenta,1,10)='1-1-128-01') and (con002.tipo_asiento='CHQ' OR con002.tipo_asiento='ANU' OR con002.tipo_asiento='DEP') and (modulo='B')) 
  or ((substring(con003.cod_cuenta,1,7)='1-1-126') and (con002.tipo_asiento='DEP' OR con002.tipo_asiento='NCR') and (modulo='B')) )";
 $sql="SELECT substring(con003.cod_cuenta,1,7) as cuenta,con003.debito_credito,sum(con003.monto_asiento) as monto from con002,con003 where (con002.referencia=con003.referencia and con002.fecha=con003.fecha and con002.tipo_comp=con003.tipo_comp) and ((con002.modulo='I') or (con002.modulo='B')) and ".$criterio." group by substring(con003.cod_cuenta,1,7),con003.debito_credito order by substring(con003.cod_cuenta,1,7),con003.debito_credito "; 
 $resultado=pg_query($sql);  $c=0; $temp1=$sql;  $nro_linea=0; $sfecha=$sfecha_h;
 while($registro=pg_fetch_array($resultado)){ 
      $cod_cuenta=$registro["cuenta"]; $monto=$registro["monto"]; $debito_credito=$registro["debito_credito"]; 
      $sSQL="Select con001.nombre_cuenta,con001.tsaldo from con001 WHERE codigo_cuenta='$cod_cuenta'"; $resc=pg_query($sSQL); $filasc=pg_num_rows($resc);
      if ($filasc==0){$nombre=""; $tsaldo=""; }  else{ $regc=pg_fetch_array($resc); $nombre=$regc["nombre_cuenta"]; $tsaldo=$regc["tsaldo"]; }	  
	  if($debito_credito=="D"){ $monto1=$monto; $monto2=0; $grupo="0";} else { $monto2=$monto; $monto1=0; $grupo="1";}	  
	  $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','6',$nro_linea,'00000000','$sfecha','$debito_credito','$cod_cuenta','00000','','01','$grupo','N','$cod_cuenta','$nombre','$tsaldo','','','',$monto1,$monto2,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);	  
 }
 $sSQL="SELECT * from CON013 Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') order by  doperacion,substr(cod_cuenta,5,3),cod_cuenta";
   if($nro_linea>0){ $fin_rpt=0;  
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(30);
				$this->Cell(150,10,'RESUMEN MENSUAL COLUMNAS VARIAS',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',10);
				$this->Cell(50);
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);
				$this->SetFont('Arial','B',7);
				$this->Cell(23,5,'CODIGO CUENTA',1,0,'L');
				$this->Cell(128,5,'NOMBRE DE CUENTA',1,0,'L');	
				$this->Cell(25,5,'DEBE',1,0,'R');
				$this->Cell(25,5,'HABER',1,1,'R');
				$this->Ln(2);
			}
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-20);
				$this->SetFont('Arial','B',7);
				$this->Cell(65,3,'___________________________________',0,0,'C');
				$this->Cell(65,3,'___________________________________',0,0,'C');
				$this->Cell(70,3,'_______________________________________',0,1,'C');			
				$this->Cell(65,3,'Director de Tesoreria(E)',0,0,'C');
				$this->Cell(65,3,'Contador',0,0,'C');
				$this->Cell(70,3,'Secretario(a) de Administracion Finanzas',0,1,'C');
                $this->Ln(7);		
				$this->SetFont('Arial','I',5);
				$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('P', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7); $d=0;		  
		  //$pdf->MultiCell(200,5,$temp1,0); 
		  //$pdf->Ln(5);
		  $i=0;  $total_columna1=0; $total_columna2=0;  $prev_codigo_cuenta="";  $prev_dc=""; $res=pg_query($sSQL);		 
		  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		       $cod_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; $columna1=$registro["columna1"]; $columna2=$registro["columna2"];  
			   $columna3=$registro["columna3"]; $columna4=$registro["columna4"]; $debito_credito=$registro["debito_credito"]; $status=$registro["status"];
			   $total_columna1=$total_columna1+$columna1; $total_columna2=$total_columna2+$columna2;			   
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta);}			   
			   if($columna1==0){$col1="";}else{$col1=formato_monto($columna1);}	   if($columna2==0){$col2="";}else{$col2=formato_monto($columna2);}					   
			   $mcuenta=substr($cod_cuenta,4,3);
			   $pdf->Cell(22,5,$mcuenta,0,0,'L'); 		   
			   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=128;		   
			   $pdf->SetXY($x+$w,$y);
			   $pdf->Cell(25,5,$col1,0,0,'R');
			   $pdf->Cell(25,5,$col2,0,1,'R');	   
			   $pdf->SetXY($x,$y);	
			   $pdf->MultiCell($w,5,$nombre_cuenta,0);			   
			} $col1=formato_monto($total_columna1); $col2=formato_monto($total_columna2);
			$pdf->Ln(4);
			$pdf->SetFont('Arial','B',7); 
			$pdf->Cell(150,2,'',0,0);
			$pdf->Cell(25,2,'==============',0,0,'R');
			$pdf->Cell(25,2,'==============',0,1,'R');
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(150,5,' ',0,0,'R');
			$pdf->Cell(25,5,$col1,0,0,'R'); 
			$pdf->Cell(25,5,$col2,0,1,'R'); 
			
			$pdf->Output();    
	}
}

if($tipo_res=="V"){ 
 $criterio=$criterio." and (con002.tipo_asiento<>'RDP') And (con002.tipo_asiento<>'RNC') "; 
 $criterio=$criterio." and (text(con002.fecha)||text(con002.referencia)||text(con002.tipo_comp) not in (SELECT text(con002.fecha)||text(con002.referencia)||text(con002.tipo_comp) FROM con002,con003 where con002.referencia=con003.referencia and con002.fecha=con003.fecha and con002.tipo_comp=con003.tipo_comp and (con003.cod_cuenta='1-1-102-03-03-0002' or cod_cuenta='1-1-110-03-03-0002') ) )";
 $criterio=$criterio." and (  (substring(con003.cod_cuenta,1,7)='1-1-132') or (substring(con003.cod_cuenta,1,7)='1-2-133') or (substring(con003.cod_cuenta,1,7)='1-1-130')  or (substring(con003.cod_cuenta,1,7)='1-2-131') or (substring(con003.cod_cuenta,1,7)='3-2-301') or (substring(con003.cod_cuenta,1,7)='3-2-303')  
  or ((substring(con003.cod_cuenta,1,10)='1-1-128-01') and (con002.tipo_asiento='CHQ' OR con002.tipo_asiento='ANU' OR con002.tipo_asiento='DEP') and (modulo='B')) 
  or ((substring(con003.cod_cuenta,1,7)='1-1-126') and (con002.tipo_asiento='DEP' OR con002.tipo_asiento='NCR') and (modulo='B')))";
 $sql="SELECT con003.cod_cuenta,con003.debito_credito,sum(con003.monto_asiento) as monto from con002,con003 where (con002.referencia=con003.referencia and con002.fecha=con003.fecha and con002.tipo_comp=con003.tipo_comp) and ((con002.modulo='I') or (con002.modulo='B')) and ".$criterio." group by con003.cod_cuenta,con003.debito_credito order by con003.cod_cuenta,con003.debito_credito "; 
 $resultado=pg_query($sql);  $c=0; $temp1=$sql;  $nro_linea=0; $sfecha=$sfecha_h; $prev_cuenta2=""; $nombre2="";
 while($registro=pg_fetch_array($resultado)){ 
      $cod_cuenta=$registro["cod_cuenta"]; $monto=$registro["monto"]; $debito_credito=$registro["debito_credito"];  $cuenta2=substr($cod_cuenta,0,7);	  
	  if($prev_cuenta2<>$cuenta2){
	     $sSQL="Select con001.nombre_cuenta,con001.tsaldo from con001 WHERE codigo_cuenta='$cuenta2'"; $resc=pg_query($sSQL); $filasc=pg_num_rows($resc);
         if ($filasc==0){$nombre=""; $tsaldo=""; }  else{ $regc=pg_fetch_array($resc); $nombre2=$regc["nombre_cuenta"]; }	  
	     $prev_cuenta2=$cuenta2;
	  }	  
	  $sSQL="Select con001.nombre_cuenta,con001.tsaldo from con001 WHERE codigo_cuenta='$cod_cuenta'"; $resc=pg_query($sSQL); $filasc=pg_num_rows($resc);
      if ($filasc==0){$nombre=""; $tsaldo=""; }  else{ $regc=pg_fetch_array($resc); $nombre=$regc["nombre_cuenta"]; $tsaldo=$regc["tsaldo"]; }  
	  if($debito_credito=="D"){ $monto1=$monto; $monto2=0; $grupo="0";} else { $monto2=$monto; $monto1=0; $grupo="1";}	  
	  $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','6',$nro_linea,'00000000','$sfecha','$debito_credito','$cod_cuenta','00000','','01','$grupo','N','$cod_cuenta','$nombre','$tsaldo','$cuenta2','$nombre2','',$monto1,$monto2,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);	  
 }
 
 $sSQL="SELECT * from CON013 Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') order by  substring(cod_cuenta,5,3),cod_cuenta,doperacion";
   if($nro_linea>0){ $fin_rpt=0;  
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(30);
				$this->Cell(150,10,'RESUMEN MENSUAL COLUMNAS VARIAS',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',10);
				$this->Cell(50);
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);
				$this->SetFont('Arial','B',7);
				$this->Cell(25,5,'CODIGO CUENTA',1,0,'L');
				$this->Cell(125,5,'NOMBRE DE CUENTA',1,0,'L');	
				$this->Cell(25,5,'DEBE',1,0,'R');
				$this->Cell(25,5,'HABER',1,1,'R');
				$this->Ln(2);
			}
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-20);
				$this->SetFont('Arial','B',7);
				$this->Cell(65,3,'___________________________________',0,0,'C');
				$this->Cell(65,3,'___________________________________',0,0,'C');
				$this->Cell(70,3,'_______________________________________',0,1,'C');			
				$this->Cell(65,3,'Director de Tesoreria(E)',0,0,'C');
				$this->Cell(65,3,'Contador',0,0,'C');
				$this->Cell(70,3,'Secretario(a) de Administracion Finanzas',0,1,'C');
                $this->Ln(7);					
				$this->SetFont('Arial','I',5);
				$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('P', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetAutoPageBreak(true, 20);  
		  $pdf->SetFont('Arial','',7); $d=0;
		  $i=0;  $total_columna1=0; $total_columna2=0;  $prev_cuenta="";  $prev_dc=""; $res=pg_query($sSQL);		 
		  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		       $cod_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; $columna1=$registro["columna1"]; $columna2=$registro["columna2"];  
			   $columna3=$registro["columna3"]; $columna4=$registro["columna4"]; $debito_credito=$registro["debito_credito"]; $status=$registro["status"];
			   $cuenta=substr($cod_cuenta,4,3); $nombre2=$registro["nombre_cuenta2"];
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta); $nombre2=utf8_decode($nombre2);}			   
			   if($prev_cuenta<>$cuenta){
			     if($i>1){ $col1=formato_monto($total_columna1); $col2=formato_monto($total_columna2);
					$pdf->Ln(2);
					$pdf->SetFont('Arial','B',7); 
					$pdf->Cell(150,2,'',0,0);
					$pdf->Cell(25,2,'==============',0,0,'R');
					$pdf->Cell(25,2,'==============',0,1,'R');
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(150,5,' ',0,0,'R');
					$pdf->Cell(25,5,$col1,0,0,'R'); 
					$pdf->Cell(25,5,$col2,0,1,'R'); 
				    $pdf->AddPage(); 
				 }
			     $pdf->SetFont('Arial','B',8);
				 $pdf->Cell(50,5,$cuenta.'  '. $nombre2,0,1,'L');
				 $pdf->SetFont('Arial','',7); $prev_cuenta=$cuenta; $total_columna1=0; $total_columna2=0; 
				 $pdf->Ln(2);
			   }
			   $total_columna1=$total_columna1+$columna1; $total_columna2=$total_columna2+$columna2;
			   if($columna1==0){$col1="";}else{$col1=formato_monto($columna1);}	   if($columna2==0){$col2="";}else{$col2=formato_monto($columna2);}					
			   $pdf->Cell(25,4,$cod_cuenta,0,0,'L'); 		   
			   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=125;		   
			   $pdf->SetXY($x+$w,$y);
			   $pdf->Cell(25,4,$col1,0,0,'R');
			   $pdf->Cell(25,4,$col2,0,1,'R');	   
			   $pdf->SetXY($x,$y);	
			   $pdf->MultiCell($w,4,$nombre_cuenta,0);
			} $col1=formato_monto($total_columna1); $col2=formato_monto($total_columna2);
			$pdf->Ln(2);
			$pdf->SetFont('Arial','B',7); 
			$pdf->Cell(150,2,'',0,0);
			$pdf->Cell(25,2,'==============',0,0,'R');
			$pdf->Cell(25,2,'==============',0,1,'R');
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(150,5,' ',0,0,'R');
			$pdf->Cell(25,5,$col1,0,0,'R'); 
			$pdf->Cell(25,5,$col2,0,1,'R'); 
			$pdf->Output();    
	}
}

if($tipo_res=="R"){
 $criterio=" (con003.cod_cuenta>='".$cod_cuenta_d."'and con003.cod_cuenta<='".$cod_cuenta_h."') and (con002.fecha>='".$sfecha_d."'and con002.fecha<='".$sfecha_h."') ";
 $criterio=$criterio." and ((substring(con003.cod_cuenta,1,7)='3-1-300') and (con002.tipo_asiento='RDP' OR con002.tipo_asiento='RNC') and (modulo='B')) ";
 $sql="SELECT con003.cod_cuenta,con003.debito_credito,sum(con003.monto_asiento) as monto from con002,con003 where (con002.referencia=con003.referencia and con002.fecha=con003.fecha and con002.tipo_comp=con003.tipo_comp) and ((con002.modulo='I') or (con002.modulo='B')) and ".$criterio." group by con003.cod_cuenta,con003.debito_credito order by con003.cod_cuenta,con003.debito_credito "; 
 $resultado=pg_query($sql);  $c=0; $temp1=$sql;  $nro_linea=0; $sfecha=$sfecha_h; $prev_cuenta2=""; $nombre2="";
 while($registro=pg_fetch_array($resultado)){ 
      $cod_cuenta=$registro["cod_cuenta"]; $monto=$registro["monto"]; $debito_credito=$registro["debito_credito"];   $cuenta2=substr($cod_cuenta,0,7);	  
	  if($prev_cuenta2<>$cuenta2){
	     $sSQL="Select con001.nombre_cuenta,con001.tsaldo from con001 WHERE codigo_cuenta='$cuenta2'"; $resc=pg_query($sSQL); $filasc=pg_num_rows($resc);
         if ($filasc==0){$nombre=""; $tsaldo=""; }  else{ $regc=pg_fetch_array($resc); $nombre2=$regc["nombre_cuenta"]; }	  
	     $prev_cuenta2=$cuenta2;
	  }	  
	  $sSQL="Select con001.nombre_cuenta,con001.tsaldo from con001 WHERE codigo_cuenta='$cod_cuenta'"; $resc=pg_query($sSQL); $filasc=pg_num_rows($resc);
      if ($filasc==0){$nombre=""; $tsaldo=""; }  else{ $regc=pg_fetch_array($resc); $nombre=$regc["nombre_cuenta"]; $tsaldo=$regc["tsaldo"]; }	
	  if($debito_credito=="D"){ $monto1=$monto; $monto2=0; $grupo="0";} else { $monto2=$monto; $monto1=0; $grupo="1";}	  
	  $nro_linea=$nro_linea+1; $res=pg_exec($conn,"SELECT INCLUYE_CON013('$usuario_sia','6',$nro_linea,'00000000','$sfecha','$debito_credito','$cod_cuenta','00000','','01','$grupo','N','$cod_cuenta','$nombre','$tsaldo','$cuenta2','$nombre2','',$monto1,$monto2,0,0,0,0,0,0,0,0,'','')"); $error=pg_errormessage($conn);	  
 }
 
 $sSQL="SELECT * from CON013 Where (tipo_registro='6') And (nombre_usuario='$usuario_sia') order by  substring(cod_cuenta,5,3),cod_cuenta,doperacion";
   if($nro_linea>0){ $fin_rpt=0;  
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(30);
				$this->Cell(150,10,'REINTEGROS',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',10);
				$this->Cell(50);
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);
				$this->SetFont('Arial','B',7);
				$this->Cell(25,5,'CODIGO CUENTA',1,0,'L');
				$this->Cell(125,5,'NOMBRE DE CUENTA',1,0,'L');	
				$this->Cell(25,5,'DEBE',1,0,'R');
				$this->Cell(25,5,'HABER',1,1,'R');
				$this->Ln(2);
			}
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-20);
				$this->SetFont('Arial','B',7);
				$this->Cell(65,3,'___________________________________',0,0,'C');
				$this->Cell(65,3,'___________________________________',0,0,'C');
				$this->Cell(70,3,'_______________________________________',0,1,'C');			
				$this->Cell(65,3,'Director de Tesoreria(E)',0,0,'C');
				$this->Cell(65,3,'Contador',0,0,'C');
				$this->Cell(70,3,'Secretario(a) de Administracion Finanzas',0,1,'C');
                $this->Ln(7);		
				$this->SetFont('Arial','I',5);
				$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('P', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7); $d=0;	
		  $i=0;  $total_columna1=0; $total_columna2=0;  $prev_cuenta="";  $prev_dc=""; $res=pg_query($sSQL);		 
		  while($registro=pg_fetch_array($res)){ $i=$i+1; 
		       $cod_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; $columna1=$registro["columna1"]; $columna2=$registro["columna2"];  
			   $columna3=$registro["columna3"]; $columna4=$registro["columna4"]; $debito_credito=$registro["debito_credito"]; $status=$registro["status"];
			   $cuenta=substr($cod_cuenta,4,3); $nombre2=$registro["nombre_cuenta2"];
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta); $nombre2=utf8_decode($nombre2);}			   
			   if($prev_cuenta<>$cuenta){
			     if($i>1){ $col1=formato_monto($total_columna1); $col2=formato_monto($total_columna2);
					$pdf->Ln(2);
					$pdf->SetFont('Arial','B',7); 
					$pdf->Cell(150,2,'',0,0);
					$pdf->Cell(25,2,'==============',0,0,'R');
					$pdf->Cell(25,2,'==============',0,1,'R');
					$pdf->SetFont('Arial','B',7);
					$pdf->Cell(150,5,' ',0,0,'R');
					$pdf->Cell(25,5,$col1,0,0,'R'); 
					$pdf->Cell(25,5,$col2,0,1,'R'); 
				    $pdf->AddPage(); 
				 }
			     $pdf->SetFont('Arial','B',8);
				 $pdf->Cell(50,5,$cuenta.'  '. $nombre2,0,1,'L');
				 $pdf->SetFont('Arial','',7); $prev_cuenta=$cuenta; $total_columna1=0; $total_columna2=0; 
				 $pdf->Ln(2);
			   }
			   $total_columna1=$total_columna1+$columna1; $total_columna2=$total_columna2+$columna2;
			   if($columna1==0){$col1="";}else{$col1=formato_monto($columna1);}	   if($columna2==0){$col2="";}else{$col2=formato_monto($columna2);}					
			   $pdf->Cell(25,4,$cod_cuenta,0,0,'L'); 		   
			   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=125;		   
			   $pdf->SetXY($x+$w,$y);
			   $pdf->Cell(25,4,$col1,0,0,'R');
			   $pdf->Cell(25,4,$col2,0,1,'R');	   
			   $pdf->SetXY($x,$y);	
			   $pdf->MultiCell($w,4,$nombre_cuenta,0); 
			} $col1=formato_monto($total_columna1); $col2=formato_monto($total_columna2);
			$pdf->Ln(2);
			$pdf->SetFont('Arial','B',7); 
			$pdf->Cell(150,2,'',0,0);
			$pdf->Cell(25,2,'==============',0,0,'R');
			$pdf->Cell(25,2,'==============',0,1,'R');
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(150,5,' ',0,0,'R');
			$pdf->Cell(25,5,$col1,0,0,'R'); 
			$pdf->Cell(25,5,$col2,0,1,'R'); 
			$pdf->Output();    
	} 
}

}
 
 pg_close();?>