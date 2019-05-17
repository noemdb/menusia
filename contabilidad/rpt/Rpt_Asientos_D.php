<?include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php");include ("../../class/configura.inc");include ("../../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS;
$fecha_d=$_GET["fecha_d"]; $fecha_h=$_GET["fecha_h"];$referencia_d=$_GET["referencia_d"]; $referencia_h=$_GET["referencia_h"]; $ced_rif_d=$_GET["ced_rif_d"]; $ced_rif_h=$_GET["ced_rif_h"];
$tipo_asiento_d=$_GET["tipo_asiento_d"];$tipo_asiento_h=$_GET["tipo_asiento_h"]; $cta_unica=$_GET["cta_unica"]; $vstatus=$_GET["vstatus"];$tipo_rep=$_GET["tipo_rep"]; 
$criterio1="Desde ".$fecha_d." Al ".$fecha_h; 
if($fecha_d==""){$sfecha_d="2007-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
$date = date("d-m-Y");$hora = date("H:i:s a");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
    $Sql="SELECT ELIMINA_CON013('".$usuario_sia."','2')"; $resultado=pg_exec($conn,$Sql); $error=pg_errormessage($conn);
    $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
    if ($cta_unica==""){$criterio2=""; $Sql="SELECT RPT_DIARIO_CON013_RIF('".$usuario_sia."','2','".$sfecha_d."','".$sfecha_h."','".$referencia_d."','".$referencia_h."','".$tipo_asiento_d."','".$tipo_asiento_h."','".$ced_rif_d."','".$ced_rif_h."','".$vstatus."')";}
    else{$criterio2="Cuenta: ".$cta_unica; $Sql="SELECT RPT_ASIENTOS_DIARIOS_CON013_RIF('".$usuario_sia."','2','".$sfecha_d."','".$sfecha_h."','".$referencia_d."','".$referencia_h."','".$tipo_asiento_d."','".$tipo_asiento_h."','".$cta_unica."','".$ced_rif_d."','".$ced_rif_h."','".$vstatus."')";}
     $resultado=pg_exec($conn,$Sql); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
       else{  if($ced_rif_d==$ced_rif_h){ $criterio2=$criterio2." Cedula/Rif: ".$ced_rif_d; }
	        $sSQL= "select * from RPT_DIARIO WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='2' ORDER BY fecha, referencia, aoperacion";           }

   if ($tipo_rep=="HTML"){include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Asientos_Diarios.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>"$criterio1","criterio2"=>"$criterio2"));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
             $aBench = $oRpt->getBenchmark();
             $iSec = $aBench["report_end"]-$aBench["report_start"];}

    if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $fechaf_grupo="";	$referencia_grupo="00000000";
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1;  global $criterio2; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'ASIENTOS DIARIO',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',9);
				$this->Cell(50);
				$this->Cell(100,5,$criterio1,0,1,'C');	
                $this->Cell(50);
				$this->Cell(100,5,$criterio2,0,1,'C');				
				$this->Ln(3);
				$this->SetFont('Arial','B',7);
               		
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
		  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $sub_totald1=0; $sub_totalh1=0;  $sub_totald1=0; $sub_totalh1=0;  $prev_fechaf=""; $prev_referencia="";
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $clave_comp=$registro["clave_comp"];  $fec_enc=$registro["fechaf"]; 
		      $referencia=$registro["referencia"]; $nombre=$registro["nombre"];  $descripcion=$registro["descripcion"];
		      if($php_os=="WINNT"){ $nombre=$registro["nombre"];  $descripcion=$registro["descripcion"]; }else{$nombre=utf8_decode($registro["nombre"]); $descripcion=utf8_decode($registro["descripcion"]); }
                  $fechaf_grupo=$fechaf; $referencia_grupo=$referencia; $nombre_grupo=$nombre; $descripcion_grupo=$descripcion;
                  
              if($prev_clave_comp<>$clave_comp){ 
			     $pdf->SetFont('Arial','B',7); 
			     if(($sub_totald<>0)or($sub_totalh<>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 						    
				    $pdf->Cell(160,2,'',0,0);
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,1,'R');
					$pdf->Cell(160,4,"Total Comprobante  : ",0,0,'R'); 
					$pdf->Cell(20,4,$sub_totald,0,0,'R'); 
					$pdf->Cell(20,4,$sub_totalh,0,1,'R'); 
					$pdf->Ln(3);	$sub_totald=0; $sub_totalh=0;				
				 }
				 
				 if($prev_fec<>$fec_enc){					 
				    if(($sub_totald1<>0)or($sub_totalh1<>0)){ $sub_totald1=formato_monto($sub_totald1); $sub_totalh1=formato_monto($sub_totalh1); 						    
						$pdf->Cell(160,2,'',0,0);
						$pdf->Cell(20,2,'---------------------',0,0,'R');
						$pdf->Cell(20,2,'---------------------',0,1,'R');
						$pdf->Cell(160,4,"Total Fecha: ".$prev_fec,0,0,'R'); 
						$pdf->Cell(20,4,$sub_totald1,0,0,'R'); 
						$pdf->Cell(20,4,$sub_totalh1,0,1,'R'); 
						$pdf->Ln(3);	$sub_totald1=0; $sub_totalh1=0;				
				    }   
					$prev_fec=$fec_enc;
					$pdf->SetFont('Arial','B',8); 
				    $pdf->Cell(10,5,"FECHA:",0,0);
			   	    $pdf->Cell(100,5,$fec_enc,0,1);
					$pdf->SetFont('Arial','B',7); 
				 }		
				 $prev_clave_comp=$clave_comp; $sub_totald=0; $sub_totalh=0;
				 $referencia=$registro["referencia"];
				 if($php_os=="WINNT"){ $nombre=$registro["nombre"];  $descripcion=$registro["descripcion"]; }else{$nombre=utf8_decode($registro["nombre"]); $descripcion=utf8_decode($registro["descripcion"]); }
				 
		         
				 $pdf->SetFont('Arial','B',7);				 
				 $pdf->Cell(18,4,"REFERENCIA:",0,0,'L');
				 $pdf->SetFont('Arial','',7);	
			   	 $pdf->Cell(30,4,$referencia_grupo,0,0,'L');
				 $pdf->SetFont('Arial','B',7);	
				 $pdf->Cell(15,4,"NOMBRE:",0,0,'L');
				 $pdf->SetFont('Arial','',7);	
				 $pdf->Cell(137,4,$nombre_grupo,0,1,'L'); 
				 $pdf->SetFont('Arial','B',7);	
				 $pdf->Cell(19,4,"DESCRIPCION:",0,0,'L');
				 $pdf->SetFont('Arial','',7);	
				 $pdf->MultiCell(181,4,$descripcion,0);
				 $pdf->SetFont('Arial','B',7);				 
				 $pdf->Cell(30,4,'Codigo Cuenta',1,0,'L');
				 $pdf->Cell(120,4,'Nombre Cuenta',1,0,'L');	
                 $pdf->Cell(10,4,'Tipo',1,0,'C');	
				 $pdf->Cell(20,4,'Debe',1,0,'R');
				 $pdf->Cell(20,4,'Haber',1,1,'R');
				 $prev_referencia=$referencia; }

		       $referencia=$registro["referencia"]; $fecha=$registro["fecha"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; 
			   $nombre=$registro["nombre"]; $debe=$registro["columna1"]; $haber=$registro["columna2"]; $codigo_cuenta=$registro["cod_cuenta"];  
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"];}else{$nombre_cuenta=utf8_decode($registro["nombre_cuenta"]); }
               $totald=$totald+$debe; $totalh=$totalh+$haber; $sub_totald=$sub_totald+$debe; $sub_totalh=$sub_totalh+$haber;$sub_totald1=$sub_totald1+$debe; $sub_totalh1=$sub_totalh1+$haber;
			   if($debe==0){$debe="";}else{$debe=formato_monto($debe);} if($haber==0){$haber="";}else{$haber=formato_monto($haber);}  $fechaf=formato_ddmmaaaa($fechaf);	
			   $pdf->SetFont('Arial','',7);	
		   	   $pdf->Cell(30,3,$codigo_cuenta,0,0);
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=120; 			   
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(10,3,$tipo_asiento,0,0); 	
			   $pdf->Cell(20,3,$debe,0,0,'R');
               $pdf->Cell(20,3,$haber,0,0,'R'); 				
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$nombre_cuenta,0); 
				
			} 
			$pdf->SetFont('Arial','B',7);
			if($i==0){
			     $pdf->Cell(30,4,'Cuenta',1,0);
				 $pdf->Cell(120,4,'Nombre Cuenta',1,0);	
                 $pdf->Cell(10,4,'Tipo',1,0);	
				 $pdf->Cell(20,4,'Debe',1,0,'C');
				 $pdf->Cell(20,4,'Haber',1,1,'C');
				 $pdf->Ln(5);
			}
			else{
				if(($sub_totald>0)or($sub_totalh>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 						    
					$pdf->Cell(160,2,'',0,0);
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,1,'R');
					$pdf->Cell(160,5,"Total Comprobante  : ",0,0,'R'); 
					$pdf->Cell(20,5,$sub_totald,0,0,'R'); 
					$pdf->Cell(20,5,$sub_totalh,0,1,'R'); 
					$pdf->Ln(5);
				}
			    if(($sub_totald1>0)or($sub_totalh1>0)){ $sub_totald1=formato_monto($sub_totald1); $sub_totalh1=formato_monto($sub_totalh1); 					    
						$pdf->Cell(160,2,'',0,0);
						$pdf->Cell(20,2,'---------------------',0,0,'R');
						$pdf->Cell(20,2,'---------------------',0,1,'R');
						$pdf->Cell(160,4,"Total Fecha: ".$prev_fec,0,0,'R'); 
						$pdf->Cell(20,4,$sub_totald1,0,0,'R'); 
						$pdf->Cell(20,4,$sub_totalh1,0,1,'R'); 
						$pdf->Ln(5);	$sub_totald1=0; $sub_totalh1=0;				
				    } 
            }	$totald=formato_monto($totald); $totalh=formato_monto($totalh);				
			$pdf->Cell(160,2,'',0,0);
			$pdf->Cell(20,2,'==============',0,0,'R');
			$pdf->Cell(20,2,'==============',0,1,'R');
			$pdf->Cell(160,5,'TOTAL GENERAL : ',0,0,'R');
			$pdf->Cell(20,5,$totald,0,0,'R'); 
			$pdf->Cell(20,5,$totalh,0,1,'R'); 
			$pdf->Output();   
		}
		if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Asientos_Diario.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="150" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ASIENTOS DIARIOS</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="150" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
			 </tr>
			  <tr height="20">
				<td width="150" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio2?></strong></font></td>
			 </tr>
			 
		  <?  $i=0; $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $sub_totald1=0; $sub_totalh1=0;  $prev_fechaf=""; $prev_referencia=""; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $clave_comp=$registro["clave_comp"];  $fec_enc=$registro["fechaf"]; $referencia=$registro["referencia"]; $nombre=$registro["nombre"];  
		  $descripcion=$registro["descripcion"];
		  $fechaf_grupo=$fechaf; $referencia_grupo=$referencia; $nombre_grupo=$nombre; $descripcion_grupo=$descripcion; 


		      if($prev_clave_comp<>$clave_comp){ 
			    if(($sub_totald>0)or($sub_totalh>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 
					?>	 				 
                    <tr>
				      <td width="150" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="80" align="left"></td>
					  <td width="120" align="right">---------------</td>
					  <td width="120" align="right">---------------</td>
				    </tr>	
					<tr>
				      <td width="150" align="left"></td>
					  <td width="400" align="right"><? echo "Total Comprobante  : "; ?></td>
					  <td width="80" align="left"></td>
					  <td width="120" align="right"><? echo $sub_totald; ?></td>
					  <td width="120" align="right"><? echo $sub_totalh; ?></td>
				    </tr>	
					<tr>
				      <td width="150" align="left"></td>
				    </tr>	
                  <? 					
				 }
				 if($prev_fec<>$fec_enc){	$prev_fec=$fec_enc;				 
				 ?>	   
				   <tr>
				     <td width="150" align="left">FECHA: <? echo $fec_enc; ?></td>
				   </tr>
			     <? 					 
			     } ?>	   
				   <tr>
				     <td width="100" align="left"><strong>REFERENCIA:</strong></td>
				     <td width="400" align="left">'<? echo $referencia; ?></td>
				     <td width="400" align="left"><strong>NOMBRE:</strong></td>
				     <td width="400" align="left"><? echo $nombre; ?></td>
				     <td width="400" align="left"></td>					 
				   </tr>
				   <tr>
				       <td width="100" align="left"><strong>DESCRPCION:</strong></td>
				       <td width="400" align="left"><? echo $descripcion; ?></td>					 
				   </tr>
				   <tr>
				       <td width="100" align="left" bgcolor="#99CCFF"><strong>Codigo</strong></td>
			   	       <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre Cuenta</strong></td>
				       <td width="100" align="center" bgcolor="#99CCFF"><strong>Tipo</strong></td>
				       <td width="100" align="right" bgcolor="#99CCFF" ><strong>Debe</strong></td>
				       <td width="100" align="right" bgcolor="#99CCFF" ><strong>Haber</strong></td>
				   </tr>	
			     <? 
				 $prev_referencia=$referencia; $sub_totald1=0; $sub_totalh1=0;}

		        $referencia=$registro["referencia"]; $fecha=$registro["fecha"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; 
			   $nombre=$registro["nombre"]; $debe=$registro["columna1"]; $haber=$registro["columna2"]; $codigo_cuenta=$registro["cod_cuenta"];
			   $nombre_cuenta=$registro["nombre_cuenta"];$nombre_cuenta=conv_cadenas($nombre_cuenta,0);
               if($debe==0){$debe="";}else{$debe=$debe;}  if($haber==0){$haber="";}else{$haber=$haber;}
		       $totald=$totald+$debe; $totalh=$totalh+$haber; $sub_totald=$sub_totald+$debe; $sub_totalh=$sub_totalh+$haber;$sub_totald1=$sub_totald1+$debe; 
			   $sub_totalh1=$sub_totalh1+$haber;
			   $debe=formato_monto($debe); 	$haber=formato_monto($haber); $fechaf=formato_ddmmaaaa($fechaf);	   
			   ?>	   
				<tr>
				   <td width="100" align="left"><? echo $codigo_cuenta; ?></td>
				   <td width="400" align="justify"><? echo $nombre_cuenta; ?></td>
				   <td width="100" align="center"><? echo $tipo_asiento; ?></td>
				   <td width="100" align="right"><? echo $debe; ?></td>
				   <td width="100" align="right"><? echo $haber; ?></td>
				 </tr>
			   <? 		  
		        } $totald=formato_monto($totald); $totalh=formato_monto($totalh);	$sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 	 ?>	
		         <tr>
				      <td width="150" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="80" align="left"></td>
					  <td width="120" align="right">---------------</td>
					  <td width="120" align="right">---------------</td>
				    </tr>	
					<tr>
				      <td width="150" align="left"></td>
					  <td width="400" align="right"><? echo "Total Comprobante  : "; ?></td>
					  <td width="80" align="left"></td>
					  <td width="120" align="right"><? echo $sub_totald; ?></td>
					  <td width="120" align="right"><? echo $sub_totalh; ?></td>
				    </tr>	
					<tr>
				      <td width="150" align="left"></td>
				    </tr>	
					
			    		 
                     <tr>
				       <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="100" align="left"></td>
					  <td width="100" align="right">===============</td>
					  <td width="100" align="right">===============</td>
				    </tr>	
				    <tr>
				          <td width="100" align="left"></td>
					  <td width="400" align="right"></strong></td>
					  <td width="100" align="right"><strong>TOTAL GENERAL</strong></td>
					  <td width="100" align="right"><strong><? echo $totald; ?></strong></td>
					  <td width="100" align="right"><strong><? echo $totalh; ?></strong></td>
				    </tr>	
				    	
                </table><?
        }		  
}
?> 

