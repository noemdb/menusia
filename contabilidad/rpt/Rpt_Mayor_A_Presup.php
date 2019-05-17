<?include ("../../class/phpreports/PHPReportMaker.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php"); include ("../../class/configura.inc");
include ("../../class/conect.php"); error_reporting(E_ALL ^ E_NOTICE); $php_os=PHP_OS;
$periodod=$_GET["periodod"]; $periodoh=$_GET["periodoh"]; $cod_cuenta_d=$_GET["cod_cuenta_d"];$cod_cat_d=$_GET["cod_cat_d"];$cod_cat_h=$_GET["cod_cat_h"]; $cod_par_d=$_GET["cod_par_d"];$cod_par_h=$_GET["cod_par_h"];
$tipo_asiento_d=$_GET["tipo_asiento_d"];$tipo_asiento_h=$_GET["tipo_asiento_h"]; $salto_pag=$_GET["salto_pag"];$ordenar=$_GET["ordenar"]; $tipo_rep=$_GET["tipo_rep"]; $inc_benef=$_GET["inc_benef"];
$criterio1="Desde ".$fecha_d." Al ".$fecha_h." Cuenta:".$cod_cuenta_d; $Sql=""; 
if($fecha_d==""){$sfecha_d="2010-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}
if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
$date = date("d-m-Y"); $hora = date("H:i:s a");
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $sql="Select * from SIA005 where campo501='05'";  $resultado=pg_query($sql); $formato_presup="XX-XX-XX-XXX-XX-XX-XX";
    if($registro=pg_fetch_array($resultado,0)){$formato_presup=$registro["campo504"];$formato_categoria=$registro["campo526"];$formato_partida=$registro["campo527"];}
    $l=strlen($formato_presup); $c=strlen($formato_categoria); $p=strlen($formato_partida); $i=c+2;   $fecha_i=formato_ddmmaaaa($Fec_Ini_Ejer);
    $Sql="SELECT ELIMINA_CON013('".$usuario_sia."','9')"; $resultado=pg_exec($conn,$Sql); $error=pg_errormessage($conn);  $error="ERROR INICIALIZANDO: ".substr($error, 0, 61);
    $Sql="SELECT RPT_MAYOR_A_PRESUP_CON013('".$usuario_sia."','9','".$sfecha_d."','".$sfecha_h."','".$cod_cat_d."','".$cod_cat_h."','".$cod_par_d."','".$cod_par_h."','".$tipo_asiento_d."','".$tipo_asiento_h."','".$cod_cuenta_d."','".$ordenar."',".$i.",".$p.",".$c.")";
    $resultado=pg_exec($conn,$Sql); $error=pg_errormessage($conn); $error="ERROR GRABANDO: ".substr($error, 0, 61);
    if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
     else{ $Sql= "select * from RPT_MAYOR_A WHERE nombre_usuario='".$usuario_sia."' AND tipo_registro='9' AND fecha>='".$fecha_d."' AND fecha<='".$fecha_h."' AND fecha>='".$sfecha_d."' ORDER BY nro_linea";
        $sSQL = $Sql;             
	    if($tipo_rep=="HTML"){	
            $oRpt = new PHPReportMaker();
             $oRpt->setXML("Mayor_Analitico_Presup.xml");
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
		if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $cta_enc="00000000";	$nomb_cta_enc="";
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $cta_enc; global $nomb_cta_enc; global $registro;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				//$this->Image('../../imagenes/Logo_hidro.jpg',7,7,30);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'MAYOR ANALITICO PRESUPUESTO',1,0,'C');
				$this->Ln(10);
				$this->SetFont('Arial','B',8);
				$this->Cell(50);
				$this->Cell(100,10,$criterio1,0,0,'C');				
				$this->Ln(10);
				$this->SetFont('Arial','B',6);
				$this->Cell(15,5,'Fecha',1,0);
				$this->Cell(15,5,'Referencia',1,0);	
                $this->Cell(10,5,'Tipo',1,0);					
				$this->Cell(100,5,'Decripcion',1,0);
				$this->Cell(20,5,'Debe',1,0,'C');
				$this->Cell(20,5,'Haber',1,0,'C');
				$this->Cell(20,5,'Saldo',1,1,'C');
                if($cta_enc<>"00000000"){ $anterior=$registro["columna3"]; $anterior=formato_monto($anterior);
				  $this->Cell(30,5,$cta_enc,0,0);
			   	  $this->Cell(110,5,$nomb_cta_enc,0,0);
				  $this->Cell(40,5,"Saldo Anterior:",0,0,'R');
                  $this->Cell(20,5,$anterior,0,1,'R'); 	
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
		  $pdf->SetFont('Arial','',6);
		  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cta="";  
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta2"];  $nombre_cuenta=$registro["nombre_cuenta2"]; 
		       if($php_os=="WINNT"){$nombre_cuenta=$registro["nombre_cuenta2"]; }   else{$nombre_cuenta=utf8_decode($nombre_cuenta); }
		       $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;  		       
			   if($prev_cta<>$cta_enc){ $anterior=$registro["columna3"]; $anterior=formato_monto($anterior);
			     $pdf->SetFont('Arial','B',6); 
			     if(($sub_totald>0)or($sub_totalh>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 						    
				    $pdf->Cell(140,2,'',0,0);
					$pdf->Cell(20,2,'---------------',0,0,'R');
					$pdf->Cell(20,2,'---------------',0,1,'R');
					$pdf->Cell(140,5,"Total Cuenta  : ",0,0,'R'); 
					$pdf->Cell(20,5,$sub_totald,0,0,'R'); 
					$pdf->Cell(20,5,$sub_totalh,0,1,'R'); 
					$pdf->AddPage();					
				 }else{	
				 $pdf->Cell(30,5,$cta_enc,0,0);
			   	 $pdf->Cell(110,5,$nomb_cta_enc,0,0);
                 $pdf->Cell(40,5,"Saldo Anterior:",0,0,'R');
                 $pdf->Cell(20,5,$anterior,0,1,'R'); }				 
				 $pdf->SetFont('Arial','',6);	
				 $prev_cta=$cta_enc; $sub_totald=0; $sub_totalh=0;
			   }
		       $referencia=$registro["referencia"]; $fecha=$registro["fecha"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; $nombre=$registro["nombre"];
			   $debe=$registro["columna1"]; $haber=$registro["columna2"]; $anterior=$registro["columna3"]; $saldo=$registro["columna4"]; if($inc_benef=="SI"){ $descripcion=$registro["descripcion"]."; BENEFICIARIO: ".$registro["nombre"];}
			   $totald=$totald+$debe; $totalh=$totalh+$haber; $sub_totald=$sub_totald+$debe; $sub_totalh=$sub_totalh+$haber;
			   $debe=formato_monto($debe); 	$haber=formato_monto($haber); $fechaf=formato_ddmmaaaa($fecha);	$saldo=formato_monto($saldo); 
			  if($php_os=="WINNT"){$descripcion=$descripcion; }   else{$descripcion=utf8_decode($descripcion); }	   
			   $pdf->Cell(15,3,$fechaf,0,0); 
			   $pdf->Cell(15,3,$referencia,0,0); 
               $pdf->Cell(10,3,$tipo_asiento,0,0); 				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=100; 			   
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$debe,0,0,'R');
               $pdf->Cell(20,3,$haber,0,0,'R'); 
               $pdf->Cell(20,3,$saldo,0,1,'R'); 				
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$descripcion,0); 
				
			} $totald=formato_monto($totald); $totalh=formato_monto($totalh); 
			$pdf->SetFont('Arial','B',6);
			if(($sub_totald>0)or($sub_totalh>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 						    
				$pdf->Cell(140,2,'',0,0);
				$pdf->Cell(20,2,'------------',0,0,'R');
				$pdf->Cell(20,2,'------------',0,1,'R');
				$pdf->Cell(140,3,"Total Cuenta  : ",0,0,'R'); 
				$pdf->Cell(20,3,$sub_totald,0,0,'R'); 
				$pdf->Cell(20,3,$sub_totalh,0,1,'R'); 
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
		if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Mayor_Analitico_Pre.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="90" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>MAYOR ANALITICO PRESUPUESTO</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="90" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="80" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
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
		  <?  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cta="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $codigo_cuenta=$registro["codigo_cuenta2"];  $nombre_cuenta=$registro["nombre_cuenta2"]; 
		       $nombre_cuenta=conv_cadenas($nombre_cuenta,0);
		       $cta_enc=$codigo_cuenta;  $nomb_cta_enc=$nombre_cuenta;  		       
			   if($prev_cta<>$cta_enc){ $anterior=$registro["columna3"]; $anterior=formato_monto($anterior);
			     if(($sub_totald>0)or($sub_totalh>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 
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
			    $prev_cta=$cta_enc; $sub_totald=0; $sub_totalh=0;
			   }
		       $referencia=$registro["referencia"]; $fecha=$registro["fecha"];  $tipo_asiento=$registro["tipo_asiento"];  $descripcion=$registro["descripcion"]; $nombre=$registro["nombre"];
			   $debe=$registro["columna1"]; $haber=$registro["columna2"]; $anterior=$registro["columna3"]; $saldo=$registro["columna4"]; if($inc_benef=="SI"){ $descripcion=$registro["descripcion"]."; BENEFICIARIO: ".$registro["nombre"];}
			   $totald=$totald+$debe; $totalh=$totalh+$haber; $sub_totald=$sub_totald+$debe; $sub_totalh=$sub_totalh+$haber;
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
		  if(($sub_totald>0)or($sub_totalh>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 
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
	}	
}
?>