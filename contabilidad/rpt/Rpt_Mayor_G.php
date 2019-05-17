<?include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php");include ("../../class/configura.inc");include ("../../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS;
$periodod=$_GET["periodod"]; $periodoh=$_GET["periodoh"];  $tipo_rpt=$_GET["tipo_rep"]; 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{$php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }   $fecha_d=Armar_Fecha($periodod, 1, $Fec_Ini_Ejer);    $fecha_h=Armar_Fecha($periodoh, 2, $Fec_Ini_Ejer);
    $criterio1="Desde ".$fecha_d." Al ".$fecha_h; $Sql="";$date = date("d-m-Y"); $hora = date("H:i:s a");
	if($fecha_d==""){$sfecha_d="2007-01-10";}else{$sfecha_d=formato_aaaammdd($fecha_d);} if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
	$Sql="SELECT ELIMINA_CON013('".$usuario_sia."','A')";  $resultado=pg_exec($conn,$Sql);     $error=pg_errormessage($conn);      $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
    $Sql="SELECT RPT_MAYOR_G_CON013('".$usuario_sia."','A','".$sfecha_d."','".$sfecha_h."')"; 
    $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);      $error="ERROR GRABANDO: ".substr($error, 0, 61);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
       else{$Sql= "select * from RPT_MAYOR_A WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='A' AND fecha>='".$fecha_d."' AND fecha<='".$fecha_h."' ORDER BY cod_cuenta"; $sSQL=$Sql;
    if($tipo_rpt=="HTML"){	 include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Mayor_General.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1,"date"=>$date,"hora"=>$hora));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run(); 
		}
    if($tipo_rpt=="PDF"){  $fecha_grupo="00/00/0000";	
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $codigo_cuenta_grupo;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'MAYOR GENERAL',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',10);
				$this->Cell(50);
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);
				$this->SetFont('Arial','B',7);
				$this->Cell(30,5,'CODIGO CUENTA',1,0,'L');
				$this->Cell(85,5,'NOMBRE CUENTA',1,0,'L');	
				$this->Cell(25,5,'SALDO ANTERIOR',1,0,'R');
				$this->Cell(20,5,'DEBITOS',1,0,'R');
				$this->Cell(19,5,'CREDITOS',1,0,'R');				
				$this->Cell(21,5,'SALDO ACTUAL',1,1,'R');
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
		  $i=0;  $total_columna1=0; $total_columna2=0; $total_columna3=0; $total_columna4=0; $sub_total_columna1=0; $sub_total_columna2=0; $sub_total_columna3=0; $sub_total_columna4=0; $prev_codigo_cuenta="";  $prev_nombre_cuenta=""; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $codigo_cuenta=$registro["codigo_cuenta"];   $nombre_cuenta=$registro["nombre_cuenta"];    $fecha=formato_ddmmaaaa($fecha);
               $codigo_cuenta_grupo=$codigo_cuenta; $nombre_cuenta_grupo=$nombre_cuenta;		       
			   if($prev_codigo_cuenta<>$codigo_cuenta_grupo){ 
			     if(($sub_total_columna1>0)or($sub_total_columna2>0)or($sub_total_columna3>0)or($sub_total_columna4>0)){ $sub_total_columna1=formato_monto($sub_total_columna1); $sub_total_columna2=formato_monto($sub_total_columna2); $sub_total_columna3=formato_monto($sub_total_columna3); $sub_total_columna4=formato_monto($sub_total_columna4); 
		   			$pdf->Cell(30,3,$prev_codigo_cuenta,0,0,'L'); 		   
		   			$x=$pdf->GetX();   $y=$pdf->GetY();  $w=90;		   
		   			$pdf->SetXY($x+$w,$y);
					$pdf->Cell(20,3,$sub_total_columna3,0,0,'R'); 
					$pdf->Cell(20,3,$sub_total_columna1,0,0,'R'); 
					$pdf->Cell(20,3,$sub_total_columna2,0,0,'R'); 	
					$pdf->Cell(20,3,$sub_total_columna4,0,1,'R');	   
		   			$pdf->SetXY($x,$y);	
		   			$pdf->MultiCell($w,3,$prev_nombre_cuenta,0); 				
				 }	
				 $prev_codigo_cuenta=$codigo_cuenta_grupo; $prev_nombre_cuenta=$nombre_cuenta_grupo; $sub_total_columna1=0; $sub_total_columna2=0; $sub_total_columna3=0; $sub_total_columna4=0;}

			      $cod_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; $columna1=$registro["columna1"]; $columna2=$registro["columna2"];  
			      $columna3=$registro["columna3"]; $columna4=$registro["columna4"]; 
				  if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta);}
                  $total_columna1=$total_columna1+$columna1; $total_columna2=$total_columna2+$columna2;
                  $sub_total_columna1=$columna1; $sub_total_columna2=$columna2; $sub_total_columna3=$columna3; $sub_total_columna4=$columna4;
                  $columna1=formato_monto($columna1); $columna2=formato_monto($columna2);  $columna3=formato_monto($columna3); $columna4=formato_monto($columna4);		   

			} $total_columna1=formato_monto($total_columna1); $total_columna2=formato_monto($total_columna2); $total_columna3=formato_monto($total_columna3); $total_columna4=formato_monto($total_columna4);
			     if(($sub_total_columna1>0)or($sub_total_columna2>0)or($sub_total_columna3>0)or($sub_total_columna4>0)){ $sub_total_columna1=formato_monto($sub_total_columna1); $sub_total_columna2=formato_monto($sub_total_columna2); $sub_total_columna3=formato_monto($sub_total_columna3); $sub_total_columna4=formato_monto($sub_total_columna4); 
		   			$pdf->Cell(30,3,$prev_codigo_cuenta,0,0,'L'); 		   
		   			$x=$pdf->GetX();   $y=$pdf->GetY();  $w=90;		   
		   			$pdf->SetXY($x+$w,$y);
					$pdf->Cell(20,3,$sub_total_columna3,0,0,'R'); 
					$pdf->Cell(20,3,$sub_total_columna1,0,0,'R'); 
					$pdf->Cell(20,3,$sub_total_columna2,0,0,'R'); 	
					$pdf->Cell(20,3,$sub_total_columna4,0,1,'R');	   
		   			$pdf->SetXY($x,$y);	
		   			$pdf->MultiCell($w,3,$prev_nombre_cuenta,0); 				
				 }	
			$pdf->SetFont('Arial','B',7); 
			$pdf->Cell(120,2,'',0,0);
			$pdf->Cell(20,2,'',0,0,'R');
			$pdf->Cell(20,2,'==============',0,0,'R');
			$pdf->Cell(20,2,'==============',0,0,'R');
			$pdf->Cell(20,2,'',0,1,'R');
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(120,5,'TOTAL GENERAL : ',0,0,'R');
			$pdf->Cell(20,5,'',0,0,'R'); 
			$pdf->Cell(20,5,$total_columna1,0,0,'R'); 
			$pdf->Cell(20,5,$total_columna2,0,0,'R'); 
			$pdf->Cell(20,5,'',0,1,'R');
			$pdf->Output();    
		}
if($tipo_rpt=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Mayor_General.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>MAYOR GENERAL</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	$criterio1?></strong></font></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>CODIGO CUENTA</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>NOMBRE CUENTA</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>SALDO ANTERIOR</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>DEBITOS</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>CREDITOS</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>SALDO ACTUAL</strong></td>
			 </tr>
		  <?  $i=0;  $total_columna1=0; $total_columna2=0; $total_columna3=0; $total_columna4=0; $sub_total_columna1=0; $sub_total_columna2=0; $sub_total_columna3=0; $sub_total_columna4=0; $prev_codigo_cuenta="";  $prev_nombre_cuenta=""; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $codigo_cuenta=$registro["codigo_cuenta"];   $nombre_cuenta=$registro["nombre_cuenta"];    $fecha=formato_ddmmaaaa($fecha);
                  $codigo_cuenta_grupo=$codigo_cuenta; $nombre_cuenta_grupo=$nombre_cuenta;

			   if($prev_codigo_cuenta<>$codigo_cuenta_grupo){ 
			     if(($sub_total_columna1>0)or($sub_total_columna2>0)or($sub_total_columna3>0)or($sub_total_columna4>0)){ $sub_total_columna1=formato_monto($sub_total_columna1); $sub_total_columna2=formato_monto($sub_total_columna2); $sub_total_columna3=formato_monto($sub_total_columna3); $sub_total_columna4=formato_monto($sub_total_columna4); 
                  		?>	 				 
                    <tr>
				      <td width="100" align="left"><? echo $prev_codigo_cuenta; ?></td>
				      <td width="400" align="left"><? echo $prev_nombre_cuenta; ?></td>
				      <td width="100" align="right"><? echo $sub_total_columna3; ?></td>
				      <td width="100" align="right"><? echo $sub_total_columna1; ?></td>
				      <td width="100" align="right"><? echo $sub_total_columna2; ?></td>
				      <td width="100" align="right"><? echo $sub_total_columna4; ?></td>
				    </tr>	
                   <?}	
				 $prev_codigo_cuenta=$codigo_cuenta_grupo; $prev_nombre_cuenta=$nombre_cuenta_grupo; $sub_total_columna1=0; $sub_total_columna2=0; $sub_total_columna3=0; $sub_total_columna4=0;}

		  $cod_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; $columna1=$registro["columna1"]; $columna2=$registro["columna2"];  
		  $columna3=$registro["columna3"]; $columna4=$registro["columna4"]; 
                  $total_columna1=$total_columna1+$columna1; $total_columna2=$total_columna2+$columna2;
                  $sub_total_columna1=$columna1; $sub_total_columna2=$columna2; $sub_total_columna3=$columna3; $sub_total_columna4=$columna4;
                  $columna1=formato_monto($columna1); $columna2=formato_monto($columna2);  $columna3=formato_monto($columna3); $columna4=formato_monto($columna4);
		  $nombre_cuenta=conv_cadenas($nombre_cuenta,0);
 			   
		  } $total_columna1=formato_monto($total_columna1); $total_columna2=formato_monto($total_columna2); $total_columna3=formato_monto($total_columna3); $total_columna4=formato_monto($total_columna4);
			     if(($sub_total_columna1>0)or($sub_total_columna2>0)or($sub_total_columna3>0)or($sub_total_columna4>0)){ $sub_total_columna1=formato_monto($sub_total_columna1); $sub_total_columna2=formato_monto($sub_total_columna2); $sub_total_columna3=formato_monto($sub_total_columna3); $sub_total_columna4=formato_monto($sub_total_columna4); 
                  		?>	 				 
                    		    <tr>
				      <td width="100" align="left"><? echo $prev_codigo_cuenta; ?></td>
				      <td width="400" align="left"><? echo $prev_nombre_cuenta; ?></td>
				      <td width="100" align="right"><? echo $sub_total_columna3; ?></td>
				      <td width="100" align="right"><? echo $sub_total_columna1; ?></td>
				      <td width="100" align="right"><? echo $sub_total_columna2; ?></td>
				      <td width="100" align="right"><? echo $sub_total_columna4; ?></td>
				    </tr>		
                  	         <?}		
				?>	 				 
                                   <tr>
				          <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="100" align="right"></td>
					  <td width="100" align="right">---------------</td>
					  <td width="100" align="right">---------------</td>
					  <td width="100" align="right"></td>
				    </tr>	
				    <tr>
				          <td width="100" align="left"></td>
					  <td width="400" align="right"><strong>TOTAL GENERAL</strong></strong></td>
					  <td width="100" align="right"></td>
					  <td width="100" align="right"><strong><? echo $total_columna1; ?></strong></td>
					  <td width="100" align="right"><strong><? echo $total_columna2; ?></strong></td>
					  <td width="100" align="right"></td>
				    </tr>	
				    <tr>
				      <td width="150" align="left"></td>
				    </tr>	
                                <?  
		  ?></table><?
        }		  
    }
}?>
