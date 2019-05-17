<?include ("../../class/fun_fechas.php"); include ("../../class/fun_numeros.php");include ("../../class/configura.inc");include ("../../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?><script language="JavaScript">muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS');</script><?}   else{ $Nom_Emp=busca_conf(); }
$fecha_d=$_GET["fecha_d"]; $fecha_h=$_GET["fecha_h"]; $usuario_esp=$_GET["usuario_esp"]; $nomb_usuarioe=$_GET["nomb_usuarioe"]; $lu=strlen($nomb_usuarioe);
$referencia_d=$_GET["referencia_d"]; $referencia_h=$_GET["referencia_h"]; $ced_rif_d=$_GET["ced_rif_d"]; $ced_rif_h=$_GET["ced_rif_h"];
$tipo_asiento_d=$_GET["tipo_asiento_d"]; $tipo_asiento_h=$_GET["tipo_asiento_h"]; 
$monto_d=$_GET["monto_d"]; $monto_h=$_GET["monto_h"]; $monto_d=formato_numero($monto_d); $monto_h=formato_numero($monto_h);
$vstatus=$_GET["vstatus"]; $comp_esp=$_GET["comp_esp"]; $codigo_mov=$_GET["codigo_mov"]; $tipo_rep=$_GET["tipo_rep"]; 
$criterio1="Desde ".$fecha_d." Al ".$fecha_h; $Sql=""; $criterio2=""; $date = date("d-m-Y");$hora = date("H:i:s a");
if($fecha_d==""){$sfecha_d="2007-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
//echo "ESPERE GENERANDO REPORTE DIARIO GENERAL....","<br>";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $php_os=PHP_OS; $Nom_Emp=busca_conf(); if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }  $criterio_usu=" and ((columna1>=".$monto_d." and columna1<=".$monto_h." ) or (columna2>=".$monto_d." and columna2<=".$monto_h."))";
     if($usuario_esp=="SI"){ $criterio_usu=$criterio_usu." and ( text(referencia)||text(tipo_comp)||text(fecha) in (select text(con002.referencia)||text(con002.tipo_comp)||text(con002.fecha)  from con002 where substring(inf_usuario,1,$lu)='$nomb_usuarioe')) ";}
    $Sql="SELECT ELIMINA_CON013('".$usuario_sia."','1')"; $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);     $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
    if($comp_esp=="SI"){$Sql="SELECT RPT_DIARIO_CON013_ESP('".$usuario_sia."','1','".$sfecha_d."','".$sfecha_h."','".$referencia_d."','".$referencia_h."','".$tipo_asiento_d."','".$tipo_asiento_h."','".$ced_rif_d."','".$ced_rif_h."','".$vstatus."','".$codigo_mov."')"; }
      else{$Sql="SELECT RPT_DIARIO_CON013_RIF('".$usuario_sia."','1','".$sfecha_d."','".$sfecha_h."','".$referencia_d."','".$referencia_h."','".$tipo_asiento_d."','".$tipo_asiento_h."','".$ced_rif_d."','".$ced_rif_h."','".$vstatus."')"; }
    $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);     $error="ERROR GRABANDO: ".substr($error, 0, 61);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
     else{  $Sql= "select * from RPT_DIARIO WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='1' ".$criterio_usu." ORDER BY fecha, referencia, tipo_comp, aoperacion";
        $sSQL = $Sql; 
		if ($tipo_rep=="HTML"){		include ("../../class/phpreports/PHPReportMaker.php");	
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Diario_General.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
			 $oRpt->setParameters(array("criterio1"=>"$criterio1","criterio2"=>"$criterio2"));
             $oRpt->run();
             $aBench = $oRpt->getBenchmark();
             $iSec = $aBench["report_end"]-$aBench["report_start"];
        }
		if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $fec_enc="0000000000";	$nomb_cta_enc="";
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1;  global $fec_enc;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'DIARIO GENERAL',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',9);
				$this->Cell(50);
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);
				$this->SetFont('Arial','B',8);
                if($fec_enc<>"0000000000"){ 
				  $this->Cell(10,5,"FECHA:",0,0);
			   	  $this->Cell(100,5,$fec_enc,0,1);
				  $this->Ln(2);
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
		  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $sub_totalfd=0; $sub_totalfh=0; $prev_clave_comp=""; $prev_fec=""; 
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $clave_comp=$registro["clave_comp"];  $fec_enc=$registro["fechaf"]; 
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
				    if(($sub_totalfd<>0)or($sub_totalfh<>0)){ $sub_totalfd=formato_monto($sub_totalfd); $sub_totalfh=formato_monto($sub_totalfh); 						    
						$pdf->Cell(160,2,'',0,0);
						$pdf->Cell(20,2,'---------------------',0,0,'R');
						$pdf->Cell(20,2,'---------------------',0,1,'R');
						$pdf->Cell(160,4,"Total Fecha: ".$prev_fec,0,0,'R'); 
						$pdf->Cell(20,4,$sub_totalfd,0,0,'R'); 
						$pdf->Cell(20,4,$sub_totalfh,0,1,'R'); 
						$pdf->Ln(3);	$sub_totalfd=0; $sub_totalfh=0;				
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
				 $pdf->Cell(18,4,"REFERENCIA:",0,0);
			   	 $pdf->Cell(30,4,$referencia,0,0);
				 $pdf->Cell(15,4,"NOMBRE:",0,0);
				 $pdf->Cell(137,4,$nombre,0,1);
				 $pdf->Cell(19,4,"DESCRIPCION:",0,0);
				 $pdf->MultiCell(181,4,$descripcion,0);
				 $pdf->Cell(30,4,'Cuenta',1,0);
				 $pdf->Cell(120,4,'Nombre Cuenta',1,0);	
                 $pdf->Cell(10,4,'Tipo',1,0);	
				 $pdf->Cell(20,4,'Debe',1,0,'C');
				 $pdf->Cell(20,4,'Haber',1,1,'C');
				 $pdf->SetFont('Arial','',7);	
			   }
		       $referencia=$registro["referencia"]; $fecha=$registro["fecha"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; $nombre=$registro["nombre"];
			   $debe=$registro["columna1"]; $haber=$registro["columna2"]; $codigo_cuenta=$registro["cod_cuenta"];  
			   if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta"];}else{$nombre_cuenta=utf8_decode($registro["nombre_cuenta"]); }
			   $totald=$totald+$debe; $totalh=$totalh+$haber; $sub_totald=$sub_totald+$debe; $sub_totalh=$sub_totalh+$haber; $sub_totalfd=$sub_totalfd+$debe; $sub_totalfh=$sub_totalfh+$haber;
			   
			   if($debe==0){$debe="";}else{$debe=formato_monto($debe);} if($haber==0){$haber="";}else{$haber=formato_monto($haber);} $fechaf=formato_ddmmaaaa($fecha);				    
			   $pdf->Cell(30,3,$codigo_cuenta,0,0);
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=120; 			   
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(10,3,$tipo_asiento,0,0); 	
			   $pdf->Cell(20,3,$debe,0,0,'R');
               $pdf->Cell(20,3,$haber,0,0,'R'); 				
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$nombre_cuenta,0); 
				
			} $totald=formato_monto($totald); $totalh=formato_monto($totalh); 
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
					$pdf->Cell(160,5,"Total Comprobante : ",0,0,'R'); 
					$pdf->Cell(20,5,$sub_totald,0,0,'R'); 
					$pdf->Cell(20,5,$sub_totalh,0,1,'R'); 
					$pdf->Ln(5);
				}
			    if(($sub_totalfd<>0)or($sub_totalfh<>0)){ $sub_totalfd=formato_monto($sub_totalfd); $sub_totalfh=formato_monto($sub_totalfh); 						    
						$pdf->Cell(160,2,'',0,0);
						$pdf->Cell(20,2,'---------------------',0,0,'R');
						$pdf->Cell(20,2,'---------------------',0,1,'R');
						$pdf->Cell(160,4,"Total Fecha: ".$prev_fec,0,0,'R'); 
						$pdf->Cell(20,4,$sub_totalfd,0,0,'R'); 
						$pdf->Cell(20,4,$sub_totalfh,0,1,'R'); 
						$pdf->Ln(5);	$sub_totalfd=0; $sub_totalfh=0;				
				    } 
            }					
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
		  header("Content-Disposition: attachment; filename=Diario_General.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="150" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>DIARIO GENERAL</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="150" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
			 </tr>
			 
		  <?  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_clave_comp=""; $prev_fec=""; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1; $clave_comp=$registro["clave_comp"];  $fec_enc=$registro["fechaf"]; 
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
			     }
				 $prev_clave_comp=$clave_comp; $sub_totald=0; $sub_totalh=0;
				 $referencia=$registro["referencia"]; $nombre=$registro["nombre"];  $descripcion=$registro["descripcion"]; 
				 $descripcion=conv_cadenas($descripcion,0); $nombre=conv_cadenas($nombre,0);			 
				 
				 ?>	   
				   <tr>
				     <td width="150" align="left">REFERENCIA: <? echo $referencia; ?></td>
					 <td width="400" align="left">NOMBRE: <? echo $nombre; ?></td>					 
				   </tr>
				   <tr>
				     <td width="150" align="left">DESCRPCION:</td>
					 <td width="400" align="left"><? echo $descripcion; ?></td>					 
				   </tr>
				   <tr>
				       <td width="150" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Codigo</strong></td>
			   		   <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre Cuenta</strong></td>
					   <td width="80" align="left" bgcolor="#99CCFF"><strong>Tipo</strong></td>
					   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Debe</strong></td>
					   <td width="120" align="right" bgcolor="#99CCFF" ><strong>Haber</strong></td>
				   </tr>	
			     <? 				 
			   }
			   
			   $referencia=$registro["referencia"]; $fecha=$registro["fecha"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; $nombre=$registro["nombre"];
			   $debe=$registro["columna1"]; $haber=$registro["columna2"]; $codigo_cuenta=$registro["cod_cuenta"];  
			   $nombre_cuenta=$registro["nombre_cuenta"];$nombre_cuenta=conv_cadenas($nombre_cuenta,0);
			   $totald=$totald+$debe; $totalh=$totalh+$haber; $sub_totald=$sub_totald+$debe; $sub_totalh=$sub_totalh+$haber;
			   $debe=formato_monto($debe); 	$haber=formato_monto($haber); $fechaf=formato_ddmmaaaa($fecha);			   
			   ?>	   
				<tr>
				   <td width="150" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $codigo_cuenta; ?></td>
				   <td width="400" align="justify"><? echo $nombre_cuenta; ?></td>
				   <td width="80" align="left"><? echo $tipo_asiento; ?></td>
				   <td width="120" align="right"><? echo $debe; ?></td>
				   <td width="120" align="right"><? echo $haber; ?></td>
				 </tr>
			   <? 		  
		  } $totald=formato_monto($totald); $totalh=formato_monto($totalh);
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
		  <? 					
		  }?>
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
}
?>