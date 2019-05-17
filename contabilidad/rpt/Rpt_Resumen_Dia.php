<?include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php");include ("../../class/configura.inc");include ("../../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS;
$fecha_d=$_GET["fecha_d"]; $fecha_h=$_GET["fecha_h"]; $cod_cuenta_d=$_GET["cod_cuenta_d"];$cod_cuenta_h=$_GET["cod_cuenta_h"]; $tipo_rpt=$_GET["tipo_rpt"];
$vstatus=$_GET["vstatus"];   $criterio1="Desde ".$fecha_d." Al ".$fecha_h;  $Sql=""; $date = date("d-m-Y"); $hora = date("H:i:s a");
if($fecha_d==""){$sfecha_d="2007-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
    $Sql="SELECT ELIMINA_CON013('".$usuario_sia."','5')";    $resultado=pg_exec($conn,$Sql);    $error=pg_errormessage($conn);    $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
    $Sql="SELECT RPT_RES_DIARIO_CON013('".$usuario_sia."','5','".$sfecha_d."','".$sfecha_h."','".$cod_cuenta_d."','".$cod_cuenta_h."','".$vstatus."')";
    $resultado=pg_exec($conn,$Sql);     $error=pg_errormessage($conn);     $error="ERROR GRABANDO: ".substr($error, 0, 61);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
       else{ $Sql= "select * from RPT_RES_DIARIO WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='5' ORDER BY fecha, cod_cuenta"; $sSQL = $Sql;

       if($tipo_rpt=="HTML"){	 include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Resumen_Diario.xml");
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
			function Header(){ global $criterio1; global $fecha_grupo;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'RESUMEN DE DIARIO',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',9);
				$this->Cell(50);
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);
				$this->SetFont('Arial','B',8);
				$this->Cell(30,5,'CODIGO CUENTA',1,0,'L');
				$this->Cell(130,5,'NOMBRE CUENTA',1,0,'L');	
				$this->Cell(20,5,'DEBE',1,0,'R');				
				$this->Cell(20,5,'HABER',1,1,'R');

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
		  $i=0;  $total_columna1=0; $total_columna2=0; $sub_total_columna1=0; $sub_total_columna2=0; $prev_fecha="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $fecha=$registro["fecha"];       $fecha=formato_ddmmaaaa($fecha);$fecha_grupo=$fecha;
		       if($prev_fecha<>$fecha_grupo){ 
			     $pdf->SetFont('Arial','B',7); 
			     if(($sub_total_columna1>0)or($sub_total_columna2>0)){ $sub_total_columna1=formato_monto($sub_total_columna1); $sub_total_columna2=formato_monto($sub_total_columna2); 
				    $pdf->Cell(160,2,'',0,0);
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,1,'R');
					$pdf->Cell(160,5,"Total Fecha ".$prev_fecha." : ",0,0,'R');
					$pdf->Cell(20,5,$sub_total_columna1,0,0,'R');  
					$pdf->Cell(20,5,$sub_total_columna2,0,1,'R'); 
					$pdf->Ln(5);					
				 }	
				 $pdf->Cell(10,5,'Fecha:',0,0,'L');
			   	 $pdf->Cell(100,5,$fecha_grupo,0,1,'L');
				 $pdf->SetFont('Arial','',7);	
				 $prev_fecha=$fecha_grupo; $sub_total_columna1=0; $sub_total_columna2=0;}
				$cod_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; $columna1=$registro["columna1"]; $columna2=$registro["columna2"];  
				if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta);}
				$total_columna1=$total_columna1+$columna1; $total_columna2=$total_columna2+$columna2;
				$sub_total_columna1=$sub_total_columna1+$columna1; $sub_total_columna2=$sub_total_columna2+$columna2;
				$columna1=formato_monto($columna1); $columna2=formato_monto($columna2); 			   
				$pdf->Cell(30,4,$cod_cuenta,0,0,'L'); 		   
				$x=$pdf->GetX();   $y=$pdf->GetY();  $w=130;		   
				$pdf->SetXY($x+$w,$y);
				$pdf->Cell(20,4,$columna1,0,0,'R'); 	
				$pdf->Cell(20,4,$columna2,0,1,'R');	   
				$pdf->SetXY($x,$y);	
				$pdf->MultiCell($w,4,$nombre_cuenta,0); 
				
			} $total_columna1=formato_monto($total_columna1); $total_columna2=formato_monto($total_columna2);
			$pdf->SetFont('Arial','B',7);
			if(($sub_total_columna1>0)or($sub_total_columna2>0)){ $sub_total_columna1=formato_monto($sub_total_columna1); $sub_total_columna2=formato_monto($sub_total_columna2); 
				$pdf->Cell(160,2,'',0,0);
				$pdf->Cell(20,2,'---------------------',0,0,'R');
				$pdf->Cell(20,2,'---------------------',0,1,'R');
				$pdf->Cell(160,5,"Total Fecha ".$prev_fecha." : ",0,0,'R');
				$pdf->Cell(20,5,$sub_total_columna1,0,0,'R');  
				$pdf->Cell(20,5,$sub_total_columna2,0,1,'R'); 
				$pdf->Ln(5);					
			}
	
			$pdf->Cell(160,2,'',0,0);
			$pdf->Cell(20,2,'==============',0,0,'R');
			$pdf->Cell(20,2,'==============',0,1,'R');
			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(160,5,'TOTAL GENERAL : ',0,0,'R');
			$pdf->Cell(20,5,$total_columna1,0,0,'R'); 
			$pdf->Cell(20,5,$total_columna2,0,1,'R'); 
			$pdf->Output();    
		}
    if($tipo_rpt=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Resumen_Diario.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RESUMEN DIARIO</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	$criterio1?></strong></font></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>CODIGO CUENTA</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>NOMBRE CUENTA</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>DEBE</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF"><strong>HABER</strong></td>
			 </tr>
		  <?  $i=0;  $total_columna1=0; $total_columna2=0; $sub_total_columna1=0; $sub_total_columna2=0; $prev_fecha="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $fecha=$registro["fecha"];       $fecha=formato_ddmmaaaa($fecha); $fecha_grupo=$fecha;
		       
		    if($prev_fecha<>$fecha_grupo){ 			   
			   if(($sub_total_columna1>0)or($sub_total_columna2>0)){ $sub_total_columna1=formato_monto($sub_total_columna1); $sub_total_columna2=formato_monto($sub_total_columna2); 
                ?>	 				 
                     <tr>
				      <td width="100" align="left"></td>
				      <td width="400" align="left"></td>
				      <td width="100" align="right">____________</td>
				      <td width="100" align="right">____________</td>
				    </tr>	
				    <tr>
				      <td width="100" align="left"></td>
				      <td width="400" align="right"><strong><? echo "Total Fecha ".$prev_fecha." : "; ?></strong></td>
				      <td width="100" align="right"><strong><? echo $sub_total_columna1; ?></strong></td>
				      <td width="100" align="right"><strong><? echo $sub_total_columna2; ?></strong></td>
				    </tr>	
					<tr>
				      <td width="80" align="left"></td>
				    </tr>	
                  <?}	
				 ?>	   
				<tr>
				   <td width="100" align="left">FECHA:</td>
				   <td width="400" align="left"><? echo $fecha_grupo; ?></td>
				 </tr>
			     <? 				 
				 $prev_fecha=$fecha_grupo; $sub_total_columna1=0; $sub_total_columna2=0;}
		  $cod_cuenta=$registro["cod_cuenta"]; $nombre_cuenta=$registro["nombre_cuenta"]; $columna1=$registro["columna1"]; $columna2=$registro["columna2"];  
                  if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"]; }else{$nombre_cuenta=utf8_decode($nombre_cuenta);}
                  $total_columna1=$total_columna1+$columna1; $total_columna2=$total_columna2+$columna2;
                  $sub_total_columna1=$sub_total_columna1+$columna1; $sub_total_columna2=$sub_total_columna2+$columna2;
                  $columna1=formato_monto($columna1); $columna2=formato_monto($columna2); 
		  $nombre_cuenta=conv_cadenas($nombre_cuenta,0);
			   ?>	   
				<tr>
				   <td width="100" align="left"><? echo $cod_cuenta; ?></td>
				   <td width="400" align="justify"><? echo $nombre_cuenta; ?></td>
				   <td width="100" align="right"><? echo $columna1; ?></td>
				   <td width="100" align="right"><? echo $columna2; ?></td>
				 </tr>
			   <? 
 			   
		  } $total_columna1=formato_monto($total_columna1); $total_columna2=formato_monto($total_columna2);
			if(($sub_total_columna1>0)or($sub_total_columna2>0)){ $sub_total_columna1=formato_monto($sub_total_columna1); $sub_total_columna2=formato_monto($sub_total_columna2); 
                  		?>	 				 
                     <tr>
				      <td width="100" align="left"></td>
				      <td width="400" align="left"></td>
				      <td width="100" align="right">____________</td>
				      <td width="100" align="right">____________</td>
				    </tr>	
				    <tr>
				      <td width="100" align="left"></td>
				      <td width="400" align="right"><strong><? echo "Total Fecha ".$prev_fecha." : "; ?></strong></td>
				      <td width="100" align="right"><strong><? echo $sub_total_columna1; ?></strong></td>
				      <td width="100" align="right"><strong><? echo $sub_total_columna2; ?></strong></td>
				    </tr>	
					<tr>
				      <td width="80" align="left"></td>
				    </tr>	
                 <?}	
				?>	 				 
                    <tr>
				      <td width="100" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="100" align="right">============</td>
					  <td width="100" align="right">============</td>
				    </tr>	
				    <tr>
				          <td width="100" align="left"></td>
					  <td width="400" align="right"><strong>TOTAL GENERAL</strong></strong></td>
					  <td width="100" align="right"><strong><? echo $total_columna1; ?></strong></td>
					  <td width="100" align="right"><strong><? echo $total_columna2; ?></strong></td>
				    </tr>	
				    <tr>
				      <td width="150" align="left"></td>
				    </tr>	
                </table><?
        }		  
    }
}?>
