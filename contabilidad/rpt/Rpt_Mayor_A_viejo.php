<? include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); include ("../../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE);  $php_os=PHP_OS; $Sql=""; $col_ac_n="N";
$fecha_d=$_GET["fecha_d"]; $fecha_h=$_GET["fecha_h"]; $ced_rif_d=$_GET["ced_rif_d"]; $ced_rif_h=$_GET["ced_rif_h"]; $cod_cuenta_d=$_GET["cod_cuenta_d"];$cod_cuenta_h=$_GET["cod_cuenta_h"]; $tipo_asiento_d=$_GET["tipo_asiento_d"];$tipo_asiento_h=$_GET["tipo_asiento_h"];
$ordenar=$_GET["ordenar"]; $imprimir=$_GET["imprimir"]; $tipo_rep=$_GET["tipo_rep"]; $inc_benef=$_GET["inc_benef"];  
$criterio1="Desde ".$fecha_d." Al ".$fecha_h; if($fecha_d==""){$sfecha_d="2010-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
//cambiar formato a la fecha
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}$fecha_desde=$ano1."/".$mes1."/".$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}$fecha_hasta=$ano1."/".$mes1."/".$dia1;
$date = date("d-m-Y");$hora = date("H:i:s a");
$nombre_rep="Mayor_Analitico.xml"; if($tipo_rep=="HTMLL"){$nombre_rep="Mayor_Analitico_Largo.xml"; $tipo_rep="HTML";} 
if($inc_benef=="SI"){$nombre_rep="Mayor_Analitico_Benef.xml"; if($tipo_rep=="HTMLL"){$tipo_rep="HTML";}   if($tipo_rep=="PDF"){$tipo_rep="PDF2"; }  if($tipo_rep=="EXCEL"){$tipo_rep="EXCEL2"; } }
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }  $fecha_i=formato_ddmmaaaa($Fec_Ini_Ejer);
    if($Cod_Emp=="70"){ $col_ac_n="S";} 
    $Sql="SELECT ELIMINA_CON013('".$usuario_sia."','8')";  $resultado=pg_exec($conn,$Sql);   $error=pg_errormessage($conn);    $error="ERROR INICIALIZANDO: ".substr($error,0,91);
    $Sql="Delete from CON013  WHERE nombre_usuario='".$usuario_sia."' ";  $resultado=pg_exec($conn,$Sql);
	$Sql="SELECT RPT_MAYOR_A_CON013('".$usuario_sia."','8','".$sfecha_d."','".$sfecha_h."','".$cod_cuenta_d."','".$cod_cuenta_h."','".$tipo_asiento_d."','".$tipo_asiento_h."','".$ordenar."','".$imprimir."')";
    $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);      $error="ERROR GRABANDO: ".substr($error,0,91);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
     else{  $Sql="update CON013 set columna5=columna4*-1,columna6=columna3*-1 WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='8'";  $resultado=pg_exec($conn,$Sql);   $error=pg_errormessage($conn);
	 $Sql= "select * from RPT_MAYOR_A WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='8' AND fecha>='".$fecha_desde."' AND (codigo_cuenta2>='$ced_rif_d' and codigo_cuenta2<='$ced_rif_h') ORDER BY cod_cuenta,fecha,nombre_cuenta2,aoperacion,substring(referencia,3,6),doperacion,debito_credito,tsaldo desc";
     $Sql= "select * from RPT_MAYOR_A WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='8' AND fecha>='".$fecha_desde."' AND (codigo_cuenta2>='$ced_rif_d' and codigo_cuenta2<='$ced_rif_h') ORDER BY cod_cuenta,fecha,aoperacion,substring(referencia,3,6),nombre_cuenta2,doperacion,debito_credito,tsaldo desc";
           
	 // $Sql= "select * from RPT_MAYOR_A WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='8' AND fecha>='".$fecha_desde."' ORDER BY cod_cuenta,fecha,referencia";
     $sSQL = $Sql; 
	 if($tipo_rep=="HTML"){	 include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML($nombre_rep);
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1,"col_ac_n"=>$col_ac_n,"date"=>$date,"hora"=>$hora));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
	 }
     if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $cta_enc="00000000";	$nomb_cta_enc=""; $anterior=0;
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $cta_enc; global $nomb_cta_enc; global $anterior;
				$this->Image('../../imagenes/Logo_emp.png',7,7,25);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'MAYOR ANALITICO',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',9);
				$this->Cell(50);
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);
				$this->SetFont('Arial','B',7);
				$this->Cell(15,5,'Fecha',1,0);
				$this->Cell(15,5,'Referencia',1,0);	
                $this->Cell(10,5,'Tipo',1,0);					
				$this->Cell(100,5,'Decripcion',1,0);
				$this->Cell(20,5,'Debe',1,0,'C');
				$this->Cell(20,5,'Haber',1,0,'C');
				$this->Cell(20,5,'Saldo',1,1,'C');
                if($cta_enc<>"00000000"){ 
				  $anterior=formato_monto($anterior);
				  $this->Cell(30,5,$cta_enc,0,0);
                  $x=$this->GetX();   $y=$this->GetY(); $n=110;
			      $this->SetXY($x+$n,$y);
			   	  //$this->Cell(110,5,$nomb_cta_enc,0,0);
				  $this->Cell(40,5,"Saldo Anterior:",0,0,'R');
                  $this->Cell(20,5,$anterior,0,1,'R'); 
                  $this->SetXY($x,$y);
			      $this->MultiCell($n,5,$nomb_cta_enc,0); 		
				}				
			}
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');

				// INI NMDB 30-04-2018
				// $this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		        $this->Cell(100,5,' ',0,0,'R');
		        // FIN NMDB 30-04-2018
			}
		  }		  
		  $pdf=new PDF('P', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  //$pdf->MultiCell(200,3,$Sql,0);
		  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cta="";  $cant_mov=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta"];    $nombre_cuenta=$registro["nombre_cuenta"]; 
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }   else{$nombre_cuenta=utf8_decode($nombre_cuenta); }			         		       
			   if($prev_cta<>$codigo_cuenta){ $anterior=$registro["columna3"]; 
			      //if($registro["columna10"]==0){
				  //  if($registro["tsaldo"]=="Acreedor"){ $anterior=$registro["columna6"]; }else{$anterior=$registro["columna3"]; } }
				  //else{
				  //  if($registro["tsaldo"]=="Acreedor"){ $anterior=$registro["columna5"]; }else{$anterior=$registro["columna4"]; } }
				  if($registro["columna10"]==0){
				    if(($registro["tsaldo"]=="Acreedor")and($col_ac_n=="S")){ $anterior=$registro["columna6"]; }else{$anterior=$registro["columna3"]; } }
				  else{
				    if(($registro["tsaldo"]=="Acreedor")and($col_ac_n=="S")){ $anterior=$registro["columna5"]; }else{$anterior=$registro["columna4"]; } }	
			     $pdf->SetFont('Arial','B',7); 
			     if(($sub_totald>0)or($sub_totalh>0)or($cant_mov>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 						    
				    $pdf->Cell(140,2,'',0,0);
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,1,'R');
					$pdf->Cell(140,5,"Total Cuenta  : ",0,0,'R'); 
					$pdf->Cell(20,5,$sub_totald,0,0,'R'); 
					$pdf->Cell(20,5,$sub_totalh,0,0,'R'); 
					$pdf->Cell(20,5,$saldo,0,1,'R'); 
                    $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;					
					$pdf->AddPage();					
				 }else{	$anterior=formato_monto($anterior); $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;
				 $pdf->Cell(30,5,$cta_enc,0,0);
			   	// $pdf->Cell(110,5,$nomb_cta_enc,0,0);
                 $x=$pdf->GetX();   $y=$pdf->GetY(); $n=110; 			   
			     $pdf->SetXY($x+$n,$y);
                 $pdf->Cell(40,5,"Saldo Anterior:",0,0,'R');
                 $pdf->Cell(20,5,$anterior,0,1,'R'); 	
                 $pdf->SetXY($x,$y);
			     $pdf->MultiCell($n,5,$nomb_cta_enc,0);	}		 
				 $pdf->SetFont('Arial','',7);	
				 $prev_cta=$cta_enc; $sub_totald=0; $sub_totalh=0; $cant_mov=0;
			   }
		       $referencia=$registro["referencia"]; $fecha=$registro["fecha"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; $nombre=$registro["nombre"];
			   $debe=$registro["columna1"]; $haber=$registro["columna2"];  $saldo=$registro["columna4"]; 
			   //if($registro["tsaldo"]=="Acreedor"){ $saldo=$registro["columna5"]; }else{$saldo=$registro["columna4"]; }	
               if(($registro["tsaldo"]=="Acreedor")and($col_ac_n=="S")){ $saldo=$registro["columna5"]; }else{$saldo=$registro["columna4"]; }			   
			   if($inc_benef=="SI"){ $descripcion=$registro["descripcion"]."; BENEFICIARIO: ".$registro["nombre"];}
			   $totald=$totald+$debe; $totalh=$totalh+$haber; $sub_totald=$sub_totald+$debe; $sub_totalh=$sub_totalh+$haber; $cant_mov=$cant_mov+1;
			   $debe=formato_monto($debe); 	$haber=formato_monto($haber); $fechaf=formato_ddmmaaaa($fecha);	$saldo=formato_monto($saldo); 
			   if($php_os=="WINNT"){$descripcion=$descripcion; }   else{$descripcion=utf8_decode($descripcion); }
			   if(($debe==0)and($haber==0)and($referencia=="00000000")){ $referencia=""; $fechaf=""; }
               $pdf->Cell(15,2,'',0,1);
			   $pdf->Cell(15,3,$fechaf,0,0); 
			   $pdf->Cell(15,3,$referencia,0,0); 
               $pdf->Cell(10,3,$tipo_asiento,0,0); 				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=100; 			   
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$debe,0,0,'R');
               $pdf->Cell(20,3,$haber,0,0,'R'); 
               $pdf->Cell(20,3,$saldo,0,1,'R');
               //if($registro["columna10"]==0){
			   //	    if($registro["tsaldo"]=="Acreedor"){ $anterior=$registro["columna6"]; }else{$anterior=$registro["columna3"]; } }
			   //	  else{
			   //	    if($registro["tsaldo"]=="Acreedor"){ $anterior=$registro["columna5"]; }else{$anterior=$registro["columna4"]; } }
			   if($registro["columna10"]==0){
				    if(($registro["tsaldo"]=="Acreedor")and($col_ac_n=="S")){ $anterior=$registro["columna6"]; }else{$anterior=$registro["columna3"]; } }
				  else{
				    if(($registro["tsaldo"]=="Acreedor")and($col_ac_n=="S")){ $anterior=$registro["columna5"]; }else{$anterior=$registro["columna4"]; } }  		   
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$descripcion,0); 				
			} $totald=formato_monto($totald); $totalh=formato_monto($totalh); 
			$pdf->SetFont('Arial','B',7);
			if(($sub_totald>0)or($sub_totalh>0)or($cant_mov>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 						    
				$pdf->Cell(140,2,'',0,0);
				$pdf->Cell(20,2,'-------------------',0,0,'R');
				$pdf->Cell(20,2,'-------------------',0,0,'R');
				$pdf->Cell(20,2,'-------------------',0,1,'R');
				$pdf->Cell(140,5,"Total Cuenta  : ",0,0,'R'); 
				$pdf->Cell(20,5,$sub_totald,0,0,'R'); 
				$pdf->Cell(20,5,$sub_totalh,0,0,'R'); 
				$pdf->Cell(20,5,$saldo,0,1,'R'); 
				$pdf->Ln(10);
			}
			$pdf->Cell(140,2,'',0,0);
			$pdf->Cell(20,2,'============',0,0,'R');
			$pdf->Cell(20,2,'============',0,1,'R');
			$pdf->Cell(140,5,'TOTAL GENERAL : ',0,0,'R');
			$pdf->Cell(20,5,$totald,0,0,'R'); 
			$pdf->Cell(20,5,$totalh,0,1,'R'); 
			$pdf->Output();   
		}
		
		if($tipo_rep=="PDF2"){  $res=pg_query($sSQL); $cta_enc="00000000";	$nomb_cta_enc=""; $anterior=0;
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $cta_enc; global $nomb_cta_enc; global $anterior;
				$this->Image('../../imagenes/Logo_emp.png',7,7,25);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'MAYOR ANALITICO',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',9);
				$this->Cell(50);
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);
				$this->SetFont('Arial','B',7);
				$this->Cell(13,5,'Fecha',1,0);
				$this->Cell(14,5,'Referencia',1,0);	
                $this->Cell(7,5,'Tipo',1,0);
                $this->Cell(40,5,'Beneficiario',1,0);				
				$this->Cell(70,5,'Decripcion',1,0);
				$this->Cell(18,5,'Debe',1,0,'C');
				$this->Cell(18,5,'Haber',1,0,'C');
				$this->Cell(20,5,'Saldo',1,1,'C');
                if($cta_enc<>"00000000"){ 
				  $anterior=formato_monto($anterior);
				  $this->Cell(30,5,$cta_enc,0,0);
                  $x=$this->GetX();   $y=$this->GetY(); $n=110;
			      $this->SetXY($x+$n,$y);
			   	  //$this->Cell(110,5,$nomb_cta_enc,0,0);
				  $this->Cell(40,5,"Saldo Anterior:",0,0,'R');
                  $this->Cell(20,5,$anterior,0,1,'R'); 
                  $this->SetXY($x,$y);
			      $this->MultiCell($n,5,$nomb_cta_enc,0); 		
				}				
			}
			function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
				$this->SetY(-10);
				$this->SetFont('Arial','I',5);
				$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
				$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
			}
		  }		  
		  $pdf=new PDF('P', 'mm', Letter);
		  $pdf->AliasNbPages();
		  $pdf->AddPage();
		  $pdf->SetFont('Arial','',7);
		  //$pdf->MultiCell(200,3,$Sql,0);
		  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cta="";  $cant_mov=0;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta"];    $nombre_cuenta=$registro["nombre_cuenta"]; 
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }   else{$nombre_cuenta=utf8_decode($nombre_cuenta); }			         		       
			   if($prev_cta<>$codigo_cuenta){ $anterior=$registro["columna3"]; 
			      //if($registro["columna10"]==0){
				  //  if($registro["tsaldo"]=="Acreedor"){ $anterior=$registro["columna6"]; }else{$anterior=$registro["columna3"]; } }
				  //else{
				  //  if($registro["tsaldo"]=="Acreedor"){ $anterior=$registro["columna5"]; }else{$anterior=$registro["columna4"]; } }
				  if($registro["columna10"]==0){
				    if(($registro["tsaldo"]=="Acreedor")and($col_ac_n=="S")){ $anterior=$registro["columna6"]; }else{$anterior=$registro["columna3"]; } }
				  else{
				    if(($registro["tsaldo"]=="Acreedor")and($col_ac_n=="S")){ $anterior=$registro["columna5"]; }else{$anterior=$registro["columna4"]; } }	
			     $pdf->SetFont('Arial','B',7); 
			     if(($sub_totald>0)or($sub_totalh>0)or($cant_mov>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 						    
				    $pdf->Cell(144,2,'',0,0);
					$pdf->Cell(18,2,'-------------------',0,0,'R');
					$pdf->Cell(18,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,1,'R');
					$pdf->Cell(144,5,"Total Cuenta  : ",0,0,'R'); 
					$pdf->Cell(18,5,$sub_totald,0,0,'R'); 
					$pdf->Cell(18,5,$sub_totalh,0,0,'R'); 
					$pdf->Cell(20,5,$saldo,0,1,'R'); 
                    $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;					
					$pdf->AddPage();					
				 }else{	 $anterior=formato_monto($anterior); $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;
				 $pdf->Cell(30,5,$cta_enc,0,0);
			   	// $pdf->Cell(110,5,$nomb_cta_enc,0,0);
                 $x=$pdf->GetX();   $y=$pdf->GetY(); $n=110; 			   
			     $pdf->SetXY($x+$n,$y);
                 $pdf->Cell(40,5,"Saldo Anterior:",0,0,'R');
                 $pdf->Cell(20,5,$anterior,0,1,'R'); 	
                 $pdf->SetXY($x,$y);
			     $pdf->MultiCell($n,5,$nomb_cta_enc,0);	}		 
				 $pdf->SetFont('Arial','',7);	
				 $prev_cta=$cta_enc; $sub_totald=0; $sub_totalh=0; $cant_mov=0;
			   }
		       $referencia=$registro["referencia"]; $fecha=$registro["fecha"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; $nombre=$registro["nombre"];
			   $debe=$registro["columna1"]; $haber=$registro["columna2"];  $saldo=$registro["columna4"]; 
			   //if($registro["tsaldo"]=="Acreedor"){ $saldo=$registro["columna5"]; }else{$saldo=$registro["columna4"]; }	
               if(($registro["tsaldo"]=="Acreedor")and($col_ac_n=="S")){ $saldo=$registro["columna5"]; }else{$saldo=$registro["columna4"]; }			   
			   //if($inc_benef=="SI"){ $descripcion=$registro["descripcion"]."; BENEFICIARIO: ".$registro["nombre"];}
			   $totald=$totald+$debe; $totalh=$totalh+$haber; $sub_totald=$sub_totald+$debe; $sub_totalh=$sub_totalh+$haber; $cant_mov=$cant_mov+1;
			   $debe=formato_monto($debe); 	$haber=formato_monto($haber); $fechaf=formato_ddmmaaaa($fecha);	$saldo=formato_monto($saldo); 
			   if($php_os=="WINNT"){$descripcion=$descripcion; }   else{$descripcion=utf8_decode($descripcion); }
			   if(($debe==0)and($haber==0)and($referencia=="00000000")){ $referencia=""; $fechaf=""; }
               $pdf->Cell(13,2,'',0,1);
			   $pdf->Cell(14,3,$fechaf,0,0); 
			   $pdf->Cell(13,3,$referencia,0,0); 
               $pdf->Cell(7,3,$tipo_asiento,0,0); 
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=40; $w=70; 			   
			   $pdf->SetXY($x+$w+$n,$y);
			   $pdf->Cell(18,3,$debe,0,0,'R');
               $pdf->Cell(18,3,$haber,0,0,'R'); 
               $pdf->Cell(20,3,$saldo,0,1,'R');
                if($registro["columna10"]==0){if(($registro["tsaldo"]=="Acreedor")and($col_ac_n=="S")){ $anterior=$registro["columna6"]; }else{$anterior=$registro["columna3"]; } }
				  else{	 if(($registro["tsaldo"]=="Acreedor")and($col_ac_n=="S")){ $anterior=$registro["columna5"]; }else{$anterior=$registro["columna4"]; } } 

               if ($y>=251) { $nombre=substr($nombre,0,40);}
			   if ($y>=254) { $nombre=substr($nombre,0,20);}
			   if(strlen(trim($descripcion))>strlen(trim($nombre))){		   
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$nombre,0);  
			   $pdf->SetXY($x+$n,$y);	
			   $pdf->MultiCell($w,3,$descripcion,0); 
			   }else{
			   $pdf->SetXY($x+$n,$y);	
			   $pdf->MultiCell($w,3,$concepto,0); 
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$descripcion,0); 
			   } 		   
			} $totald=formato_monto($totald); $totalh=formato_monto($totalh); 
			$pdf->SetFont('Arial','B',7);
			if(($sub_totald>0)or($sub_totalh>0)or($cant_mov>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 						    
				$pdf->Cell(144,2,'',0,0);
				$pdf->Cell(18,2,'-------------------',0,0,'R');
				$pdf->Cell(18,2,'-------------------',0,0,'R');
				$pdf->Cell(20,2,'-------------------',0,1,'R');
				$pdf->Cell(144,5,"Total Cuenta  : ",0,0,'R'); 
				$pdf->Cell(18,5,$sub_totald,0,0,'R'); 
				$pdf->Cell(18,5,$sub_totalh,0,0,'R'); 
				$pdf->Cell(20,5,$saldo,0,1,'R'); 
				$pdf->Ln(10);
			}
			$pdf->Cell(144,2,'',0,0);
			$pdf->Cell(18,2,'============',0,0,'R');
			$pdf->Cell(18,2,'============',0,1,'R');
			$pdf->Cell(144,5,'TOTAL GENERAL : ',0,0,'R');
			$pdf->Cell(18,5,$totald,0,0,'R'); 
			$pdf->Cell(18,5,$totalh,0,1,'R'); 
			$pdf->Output();   
		}
		
		if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Mayor_Analitico.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="90" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>MAYOR ANALITICO</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="90" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?echo	$criterio1?></strong></font></td>
			 </tr>
			 <tr height="20">
			   <td width="90" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Fecha</strong></td>
			   <td width="80" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
			   <td width="80" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Debe</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Haber</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Saldo</strong></td>
			 </tr>
		  <?  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cta="";  $cant_mov=0; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta"];  $nombre_cuenta=$registro["nombre_cuenta"]; 
		       $nombre_cuenta=conv_cadenas($nombre_cuenta,0);
		       $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;  		       
			   if($prev_cta<>$cta_enc){ $anterior=$registro["columna3"]; if($registro["tsaldo"]=="Acreedor"){ $anterior=$registro["columna6"]; }else{$anterior=$registro["columna3"]; }
			   $anterior=formato_monto($anterior);
			     if(($sub_totald>0)or($sub_totalh>0)or($cant_mov>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 
					?>	 				 
                    <tr>
				      <td width="90" align="left"></td>
					  <td width="80" align="left"></td>
				      <td width="80" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="120" align="right">---------------</td>
					  <td width="120" align="right">---------------</td>
					  <td width="120" align="left"></td>
				    </tr>	
					<tr>
				      <td width="90" align="left"></td>
				      <td width="80" align="left"></td>
					  <td width="80" align="left"></td>
					  <td width="400" align="right"><? echo "Total Cuenta  : "; ?></td>
					  <td width="120" align="right"><? echo $sub_totald; ?></td>
					  <td width="120" align="right"><? echo $sub_totalh; ?></td>
					  <td width="120" align="left"></td>
				    </tr>	
					<tr>
				      <td width="90" align="left"></td>
				    </tr>	
                  <? 					
				 }
				 ?>	   
				   <tr>
				     <td width="90" align="left"><? echo $cta_enc; ?></td>
					 <td width="80" align="left"></td>
					 <td width="80" align="left"></td>
				     <td width="400" align="left"><? echo $nomb_cta_enc; ?></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="right">Saldo Anterior :</td>
					 <td width="120" align="right"><? echo $anterior; ?></td>
				   </tr>
			     <? 					 
			    $prev_cta=$cta_enc; $sub_totald=0; $sub_totalh=0; $cant_mov=0;
			   }
		       $referencia=$registro["referencia"]; $fecha=$registro["fecha"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; $nombre=$registro["nombre"];
			   $debe=$registro["columna1"]; $haber=$registro["columna2"]; $anterior=$registro["columna3"]; $saldo=$registro["columna4"]; if($registro["tsaldo"]=="Acreedor"){ $saldo=$registro["columna5"]; }else{$saldo=$registro["columna4"]; }
			   if($inc_benef=="SI"){ $descripcion=$registro["descripcion"]."; BENEFICIARIO: ".$registro["nombre"];}
			   $totald=$totald+$debe; $totalh=$totalh+$haber; $sub_totald=$sub_totald+$debe; $sub_totalh=$sub_totalh+$haber; $cant_mov=$cant_mov+1;
			   $debe=formato_monto($debe); 	$haber=formato_monto($haber); $fechaf=formato_ddmmaaaa($fecha);	$saldo=formato_monto($saldo); 			   
			   $descripcion=conv_cadenas($descripcion,0);
			   ?>	   
				<tr>
				   <td width="90" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $fechaf; ?></td>
				   <td width="80" align="left">'<? echo $referencia; ?></td>
				   <td width="80" align="left"><? echo $tipo_asiento; ?></td>
				   <td width="400" align="justify"><? echo $descripcion; ?></td>
				   <td width="120" align="right"><? echo $debe; ?></td>
				   <td width="120" align="right"><? echo $haber; ?></td>
				   <td width="120" align="right"><? echo $saldo; ?></td>
				 </tr>
			   <? 		  
		  }
		  if(($sub_totald>0)or($sub_totalh>0)or($cant_mov>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 
			?>	 				 
			<tr>
			  <td width="90" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="120" align="right">---------------</td>
			  <td width="120" align="right">---------------</td>
			  <td width="120" align="left"></td>
			</tr>	
			<tr>
			  <td width="90" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="400" align="right"><? echo "Total Cuenta  : "; ?></td>
			  <td width="120" align="right"><? echo $sub_totald; ?></td>
			  <td width="120" align="right"><? echo $sub_totalh; ?></td>
			  <td width="120" align="left"></td>
			</tr>	
			
		  <? 					
		  }		  
		  ?></table><?
        }
		
        if($tipo_rep=="EXCEL2"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Mayor_Analitico.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="90" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="200" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>MAYOR ANALITICO</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="90" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="200" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?echo	$criterio1?></strong></font></td>
			 </tr>
			 <tr height="20">
			   <td width="90" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Fecha</strong></td>
			   <td width="80" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
			   <td width="80" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
			   <td width="200" align="left" bgcolor="#99CCFF"><strong>Beneficiario</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Debe</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Haber</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Saldo</strong></td>
			 </tr>
		  <?  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cta="";  $cant_mov=0; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta"];  $nombre_cuenta=$registro["nombre_cuenta"]; 
		       $nombre_cuenta=conv_cadenas($nombre_cuenta,0);
		       $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;  		       
			   if($prev_cta<>$cta_enc){ $anterior=$registro["columna3"]; if($registro["tsaldo"]=="Acreedor"){ $anterior=$registro["columna6"]; }else{$anterior=$registro["columna3"]; }
			   $anterior=formato_monto($anterior);
			     if(($sub_totald>0)or($sub_totalh>0)or($cant_mov>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 
					?>	 				 
                    <tr>
				      <td width="90" align="left"></td>
					  <td width="80" align="left"></td>
				      <td width="80" align="left"></td>
					  <td width="200" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="120" align="right">---------------</td>
					  <td width="120" align="right">---------------</td>
					  <td width="120" align="left"></td>
				    </tr>	
					<tr>
				      <td width="90" align="left"></td>
				      <td width="80" align="left"></td>
					  <td width="80" align="left"></td>
					  <td width="200" align="left"></td>
					  <td width="400" align="right"><? echo "Total Cuenta  : "; ?></td>
					  <td width="120" align="right"><? echo $sub_totald; ?></td>
					  <td width="120" align="right"><? echo $sub_totalh; ?></td>
					  <td width="120" align="left"></td>
				    </tr>	
					<tr>
				      <td width="90" align="left"></td>
				    </tr>	
                  <? 					
				 }
				 ?>	   
				   <tr>
				     <td width="90" align="left"><? echo $cta_enc; ?></td>
					 <td width="80" align="left"></td>
					 <td width="80" align="left"></td>
				     <td width="200" align="left"><? echo $nomb_cta_enc; ?></td>
					 <td width="400" align="left"></td>
					 <td width="120" align="left"></td>
					 <td width="120" align="right">Saldo Anterior :</td>
					 <td width="120" align="right"><? echo $anterior; ?></td>
				   </tr>
			     <? 					 
			    $prev_cta=$cta_enc; $sub_totald=0; $sub_totalh=0; $cant_mov=0;
			   }
		       $referencia=$registro["referencia"]; $fecha=$registro["fecha"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; $nombre=$registro["nombre"];
			   $debe=$registro["columna1"]; $haber=$registro["columna2"]; $anterior=$registro["columna3"]; $saldo=$registro["columna4"]; if($registro["tsaldo"]=="Acreedor"){ $saldo=$registro["columna5"]; }else{$saldo=$registro["columna4"]; }
			   //if($inc_benef=="SI"){ $descripcion=$registro["descripcion"]."; BENEFICIARIO: ".$registro["nombre"];}
			   $totald=$totald+$debe; $totalh=$totalh+$haber; $sub_totald=$sub_totald+$debe; $sub_totalh=$sub_totalh+$haber; $cant_mov=$cant_mov+1;
			   $debe=formato_monto($debe); 	$haber=formato_monto($haber); $fechaf=formato_ddmmaaaa($fecha);	$saldo=formato_monto($saldo); 			   
			   $descripcion=conv_cadenas($descripcion,0);
			   ?>	   
				<tr>
				   <td width="90" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $fechaf; ?></td>
				   <td width="80" align="left">'<? echo $referencia; ?></td>
				   <td width="80" align="left"><? echo $tipo_asiento; ?></td>
				   <td width="200" align="left"><? echo $nombre; ?></td>
				   <td width="400" align="justify"><? echo $descripcion; ?></td>
				   <td width="120" align="right"><? echo $debe; ?></td>
				   <td width="120" align="right"><? echo $haber; ?></td>
				   <td width="120" align="right"><? echo $saldo; ?></td>
				 </tr>
			   <? 		  
		  }
		  if(($sub_totald>0)or($sub_totalh>0)or($cant_mov>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 
			?>	 				 
			<tr>
			  <td width="90" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="200" align="left"></td>
			  <td width="400" align="left"></td>
			  <td width="120" align="right">---------------</td>
			  <td width="120" align="right">---------------</td>
			  <td width="120" align="left"></td>
			</tr>	
			<tr>
			  <td width="90" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="80" align="left"></td>
			  <td width="200" align="left"></td>
			  <td width="400" align="right"><? echo "Total Cuenta  : "; ?></td>
			  <td width="120" align="right"><? echo $sub_totald; ?></td>
			  <td width="120" align="right"><? echo $sub_totalh; ?></td>
			  <td width="120" align="left"></td>
			</tr>	
			
		  <? 					
		  }		  
		  ?></table><?
        }			
    }
}
?>