<?include ("../../class/fun_fechas.php");include ("../../class/fun_numeros.php");include ("../../class/configura.inc");include ("../../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE);
$fecha_d=$_GET["fecha_d"]; $fecha_h=$_GET["fecha_h"];$referencia_d=$_GET["referencia_d"]; $referencia_h=$_GET["referencia_h"]; $vstatus=$_GET["vstatus"]; $tipo_rpt=$_GET["tipo_rpt"];  // NUEVO
$criterio1="Desde ".$fecha_d." Al ".$fecha_h;$date = date("d-m-Y");$hora = date("H:i:s a");
if($fecha_d==""){$sfecha_d="2007-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
    $Sql="SELECT ELIMINA_CON013('".$usuario_sia."','4')"; $resultado=pg_exec($conn,$Sql); $error=pg_errormessage($conn); $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
    $Sql="SELECT RPT_RES_COMP_CON013('".$usuario_sia."','4','".$sfecha_d."','".$sfecha_h."','".$referencia_d."','".$referencia_h."','".$vstatus."')";
    $resultado=pg_exec($conn,$Sql); $error=pg_errormessage($conn);  $error="ERROR GRABANDO: ".substr($error, 0, 61);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    else{ $Sql= "select * from RPT_RES_COMP WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='4' ORDER BY fecha, referencia"; $sSQL = $Sql;
             
		if($tipo_rpt=="HTML"){	 include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Resumen_Comprobantes.xml");
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
		if($tipo_rpt=="PDF"){  $fechaf="00/00/0000";	
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $fechaf;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'RESUMEN DE COMPROBANTES',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',10);
				$this->Cell(50);
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);
				$this->SetFont('Arial','B',8);
				$this->Cell(20,3,'','LT',0);
				$this->Cell(14,3,'TIPO','T',0,'C');				
				$this->Cell(146,3,'','T',0);
				$this->Cell(20,3,'','RT',1,'C');
				
				$this->Cell(20,4,'REFERENCIA','LB',0);
				$this->Cell(14,4,'ASIENTO','B',0);				
				$this->Cell(146,4,'DESCRIPCION','B',0);
				$this->Cell(20,4,'MONTO','RB',1,'C');
				if($fechaf<>"00/00/0000"){
				  $this->Cell(40,5,'Fecha: '.$fechaf,0,1);
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
		  $pdf->SetFont('Arial','',8);
		  $i=0;  $total=0; $sub_total=0; $prev_fecha="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $fecha=$registro["fecha"];       $fechaf=formato_ddmmaaaa($fecha);		       
			   if($prev_fecha<>$fechaf){ 
			     $pdf->SetFont('Arial','B',8); 
			     if($sub_total>0){ $sub_total=formato_monto($sub_total); 				    
				    $pdf->Cell(180,2,'',0,0);
					$pdf->Cell(20,2,'==============',0,1,'R');
					$pdf->Cell(178,5,"Total Fecha ".$prev_fecha." : ",0,0,'R'); 
					$pdf->Cell(22,5,$sub_total,0,1,'R'); 
					$pdf->Ln(10);					
				 }	
				 $pdf->Cell(40,5,'Fecha: '.$fechaf,0,1);
				 $pdf->SetFont('Arial','',8);	
				 $prev_fecha=$fechaf; $sub_total=0;
			   }
		       $referencia=$registro["referencia"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"];   
			   $monto=$registro["columna1"]; $total=$total+$monto; $sub_total=$sub_total+$monto; $monto=formato_monto($monto); 	
               if($php_os=="WINNT"){$descripcion=$descripcion; }   else{$descripcion=utf8_decode($descripcion); }	
			   $pdf->Cell(20,3,$referencia,0,0); 
               $pdf->Cell(14,3,$tipo_asiento,0,0,'C'); 				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=146; 			   
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$monto,0,1,'R'); 			   
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$registro["descripcion"],0); 
				
			} $total=formato_monto($total); 
			$pdf->SetFont('Arial','B',8);
			if($sub_total>0){ $sub_total=formato_monto($sub_total); 
				$pdf->Cell(180,2,'',0,0);
				$pdf->Cell(20,2,'==============',0,1,'R');
				$pdf->Cell(178,5,"Total Fecha ".$prev_fecha." : ",0,0,'R'); 
				$pdf->Cell(22,5,$sub_total,0,1,'R'); 
				$pdf->Ln(10);
			}
			$pdf->Cell(180,2,'',0,0);
			$pdf->Cell(20,2,'==============',0,1,'R');
			$pdf->Cell(178,5,'TOTAL COMPROBANTES : ',0,0,'R');
			$pdf->Cell(22,5,$total,0,1,'R'); 
			$pdf->Output();   
		}
		if($tipo_rpt=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Resumen_Comprobantes.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RESUMEN DE COMPROBANTES</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	$criterio1?></strong></font></td>
			 </tr>
			 <tr height="20">
			   <td width="80" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Referencia</strong></td>
			   <td width="80" align="left" bgcolor="#99CCFF"><strong>Tipo Asiento</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
			   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Monto</strong></td>
			 </tr>
		  <?  $i=0;  $total=0; $sub_total=0; $prev_fecha="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $fecha=$registro["fecha"];       $fechaf=formato_ddmmaaaa($fecha);		       
			   if($prev_fecha<>$fechaf){ 			   
			     if($sub_total>0){ $sub_total=formato_monto($sub_total); 
                  ?>	 				 
                    <tr>
				      <td width="80" align="left"></td>
				      <td width="80" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="120" align="right">============</td>
				    </tr>	
					<tr>
				      <td width="80" align="left"></td>
				      <td width="80" align="left"></td>
					  <td width="400" align="right"><? echo "Total Fecha ".$prev_fecha." : "; ?></td>
					  <td width="120" align="right"><? echo $sub_total; ?></td>
				    </tr>	
					<tr>
				      <td width="80" align="left"></td>
				    </tr>	
                  <? 		
				 }	
				 ?>	   
				<tr>
				   <td width="80" align="left">FECHA:</td>
				   <td width="80" align="left"><? echo $fechaf; ?></td>
				 </tr>
			     <? 				 
				 $prev_fecha=$fechaf; $sub_total=0;
			   }
		       $referencia=$registro["referencia"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"];   
			   $monto=$registro["columna1"]; $total=$total+$monto; $sub_total=$sub_total+$monto; $monto=formato_monto($monto);
			   $descripcion=conv_cadenas($descripcion,0);
			   ?>	   
				<tr>
				   <td width="80" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $referencia; ?></td>
				   <td width="80" align="left"><? echo $tipo_asiento; ?></td>
				   <td width="400" align="justify"><? echo $descripcion; ?></td>
				   <td width="120" align="right"><? echo $monto; ?></td>
				 </tr>
			   <? 
 			   
		  } $total=formato_monto($total);
          if($sub_total>0){ $sub_total=formato_monto($sub_total);		  
			  ?>	 				 
				<tr>
				  <td width="80" align="left"></td>
				  <td width="80" align="left"></td>
				  <td width="400" align="left"></td>
				  <td width="120" align="right">============</td>
				</tr>	
				<tr>
				  <td width="80" align="left"></td>
				  <td width="80" align="left"></td>
				  <td width="400" align="right"><? echo "Total Fecha ".$prev_fecha." : "; ?></td>
				  <td width="120" align="right"><? echo $sub_total; ?></td>
				</tr>				
			  <? 
		  }	  
		  ?></table><?
        }		  
    }
}?>