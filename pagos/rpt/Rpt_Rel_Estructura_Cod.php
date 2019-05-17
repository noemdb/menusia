<? include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$codigo_estrucrura_d=$_GET["codigo_estrucrura_d"];$codigo_estrucrura_h=$_GET["codigo_estrucrura_h"]; $tipo_rpt=$_GET["tipo_rpt"]; $Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a");
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");$date = date("d-m-Y");$hora = date("H:i:s a"); $php_os=PHP_OS;
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}
else{   $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
       // LLAMAR A PHP_REPORT
       $sSQL = "SELECT PAG006.cod_estructura, PAG006.Descripcion_Est, PAG009.Cod_Presup_Est,
                PAG006.Concepto_Est, PAG009.Monto_Est,pre001.denominacion FROM PAG006, PAG009, PRE001
                WHERE (PAG006.cod_estructura=PAG009.cod_estructura) AND (pre001.cod_presup=pag009.cod_presup_est) And (pre001.cod_fuente=pag009.fuente_est) AND
                PAG006.cod_estructura>='".$codigo_estrucrura_d."' AND PAG006.cod_estructura <='".$codigo_estrucrura_h."' order by PAG006.cod_estructura,PAG009.Cod_Presup_Est";

    if($tipo_rpt=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php"); 
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Rel_Estructura_Codigo.xml");
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
    if($tipo_rpt=="PDF"){  $cod_estructura_grupo="00/00/0000";	
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $cod_estructura_grupo; global $tam_logo;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(140,10,'REPORTE RELACION ESTRUCTURA DE CODIGOS',1,0,'C');
				$this->Ln(20);
				$this->SetFont('Arial','B',8);
				$this->Cell(38,5,'COD. PRESUPUESTARIO',1,0,'L');
				$this->Cell(142,5,'DENOMINACION',1,0,'L');					
				$this->Cell(20,5,'MONTO',1,1,'R');

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
		  $i=0;  $total_monto=0;  $sub_total_monto=0; $prev_cod_estructura="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_estructura=$registro["cod_estructura"]; $descripcion_est=$registro["descripcion_est"]; $concepto_est=$registro["concepto_est"];
                  $cod_estructura_grupo=$cod_estructura; $descripcion_est_grupo=$descripcion_est; $concepto_est_grupo=$concepto_est;
		       
			   if($prev_cod_estructura<>$cod_estructura_grupo){ 
			     $pdf->SetFont('Arial','B',8); 
			     if($sub_total_monto>0){ $sub_total_monto=formato_monto($sub_total_monto); 
				    $pdf->Cell(180,2,'',0,0);
					$pdf->Cell(20,2,'============',0,1,'R');
					$pdf->Cell(180,5,'TOTAL ESTRUCTURA: ',0,0,'R');
					$pdf->Cell(20,5,$sub_total_monto,0,1,'R'); 
					$pdf->Ln(10);					
				 }
				 $pdf->SetFont('Arial','B',8);	
			   	 $pdf->Cell(200,5,'Estructura Codigo: '.$cod_estructura_grupo.'    '.$descripcion_est_grupo,0,1,'L');				 
				 
				 $pdf->Cell(15,4,'Concepto: ',0,0,'L');
				 $x=$pdf->GetX();   $y=$pdf->GetY(); $n=185;
			   	 //$pdf->Cell(200,5,'Concepto: '.$concepto_est_grupo,0,1,'L');	$temp_concepto="Concepto: ".$concepto_est_grupo;
				 $pdf->SetFont('Arial','',8);
				 $pdf->SetXY($x,$y); 
		         $pdf->MultiCell($n,4,$concepto_est_grupo,0); 
				 $prev_cod_estructura=$cod_estructura_grupo; $sub_total_monto=0; }

			   $cod_presup_est=$registro["cod_presup_est"]; $denominacion=$registro["denominacion"]; $monto_est=$registro["monto_est"]; 
			   if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }else{$denominacion=utf8_decode($denominacion);}
			   $total_monto=$total_monto+$monto_est; $sub_total_monto=$sub_total_monto+$monto_est;  $monto_est=formato_monto($monto_est); 
			   $pdf->SetFont('Arial','',7); 
			   $pdf->Cell(38,4,$cod_presup_est,0,0,'L'); 		   
			   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=142;		   
			   $pdf->SetXY($x+$w,$y); 	
			   $pdf->Cell(20,4,$monto_est,0,1,'R');	   
			   $pdf->SetXY($x,$y);	
			   $pdf->MultiCell($w,4,$denominacion,0); 
				
			} $total_monto=formato_monto($total_monto); 
			$pdf->SetFont('Arial','B',8);
			 if($sub_total_monto>0){ $sub_total_monto=formato_monto($sub_total_monto); 
				$pdf->Cell(180,2,'',0,0);
				$pdf->Cell(20,2,'============',0,1,'R');
				$pdf->Cell(180,5,'TOTAL ESTRUCTURA: ',0,0,'R');
				$pdf->Cell(20,5,$sub_total_monto,0,1,'R'); 
				$pdf->Ln(10);					
			 }
	
			$pdf->Cell(180,2,'',0,0);
			$pdf->Cell(20,2,'============',0,1,'R');
			$pdf->SetFont('Arial','B',8);
			$pdf->Cell(180,5,'TOTAL GENERAL : ',0,0,'R');
			$pdf->Cell(20,5,$total_monto,0,1,'R'); 
			$pdf->Output();    
		}
    if($tipo_rpt=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Relacion_Estructura_Codigos.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE RELACION ESTRUCTURA DE CODIGOS</strong></font></td>
			 </tr>
			 <tr height="20">
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>COD. PRESUPUESTARIO</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>DENOMINACION</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>MONTO</strong></td>
			 </tr>
		  <?  $i=0;  $total_monto=0;  $sub_total_monto=0; $prev_cod_estructura="";   $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_estructura=$registro["cod_estructura"]; $descripcion_est=$registro["descripcion_est"]; $concepto_est=$registro["concepto_est"];
                  $cod_estructura_grupo=$cod_estructura; $descripcion_est_grupo=$descripcion_est; $concepto_est_grupo=$concepto_est;
		       
		if($prev_cod_estructura<>$cod_estructura_grupo){ 			   
			if($sub_total_monto>0){ $sub_total_monto=formato_monto($sub_total_monto); 
                  		?>	 				 
                    		    <tr>
				      <td width="100" align="left"></td>
				      <td width="400" align="left"></td>
				      <td width="100" align="right">____________</td>
				    </tr>	
				    <tr>
				      <td width="100" align="left"></td>
				      <td width="400" align="right"><strong>TOTAL ESTRUCTURA</strong></td>
				      <td width="100" align="right"><strong><? echo $sub_total_monto; ?></strong></td>
				    </tr>	
					<tr>
				      <td width="80" align="left"></td>
				    </tr>	
                  	         <?}	
				 ?>	   
				<tr>
				   <td width="100" align="left"><strong>Estructura Codigo:</strong></td>
				   <td width="400" align="left"><strong><? echo $cod_estructura_grupo.'    '.$descripcion_est_grupo; ?></strong></td>
				 </tr>
				<tr>
				   <td width="100" align="left"><strong>Concepto :</td>
				   <td width="400" align="left"><strong><? echo $concepto_est_grupo; ?></strong></td>
				 </tr>
			     <? 				 
				$prev_cod_estructura=$cod_estructura_grupo; $sub_total_monto=0; }

		  $cod_presup_est=$registro["cod_presup_est"]; $denominacion=$registro["denominacion"]; $monto_est=$registro["monto_est"]; 
                  if($php_os=="WINNT"){$denominacion=$registro["denominacion"]; }else{$denominacion=utf8_decode($denominacion);}
                  $total_monto=$total_monto+$monto_est; $sub_total_monto=$sub_total_monto+$monto_est; 
                  $monto_est=formato_monto($monto_est); 
		  $denominacion=conv_cadenas($denominacion,0);
			   ?>	   
				<tr>
				   <td width="100" align="left"><? echo $cod_presup_est; ?></td>
				   <td width="400" align="justify"><? echo $denominacion; ?></td>
				   <td width="100" align="right"><? echo $monto_est; ?></td>
				 </tr>
			   <? 
 			   
		  } $total_monto=formato_monto($total_monto); 
			if($sub_total_monto>0){ $sub_total_monto=formato_monto($sub_total_monto); 
                  		?>	 				 
                    		    <tr>
				      <td width="100" align="left"></td>
				      <td width="400" align="left"></td>
				      <td width="100" align="right">____________</td>
				    </tr>	
				    <tr>
				      <td width="100" align="left"></td>
				      <td width="400" align="right"><strong>TOTAL ESTRUCTURA</strong></td>
				      <td width="100" align="right"><strong><? echo $sub_total_monto; ?></strong></td>
				    </tr>	
					<tr>
				      <td width="80" align="left"></td>
				    </tr>	
                  	         <?}
				?>	 				 
                                   <tr>
				          <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="100" align="right">____________</td>
				    </tr>	
				    <tr>
				          <td width="100" align="left"></td>
					  <td width="400" align="right"><strong>TOTAL GENERAL</strong></strong></td>
					  <td width="100" align="right"><strong><? echo $total_monto; ?></strong></td>
				    </tr>	
				    <tr>
				      <td width="150" align="left"></td>
				    </tr>	
                                <?  
		  ?></table><?
        }		  
    }
?>
