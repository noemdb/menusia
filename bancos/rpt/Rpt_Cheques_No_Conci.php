<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$periodod=$_GET["periodod"]; $tipo_rep=$_GET["tipo_rep"]; $Sql="";$criterio1="";$date = date("d-m-Y");$hora = date("H:i:s a");
$criterio2="CHEQUES NO CONCILIADO";     
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } 
       $fecha_d=Armar_Fecha($periodod, 1, $Fec_Ini_Ejer); $fecha_h=Armar_Fecha($periodod,2,$Fec_Ini_Ejer); $criterio1="	FECHA HASTA : ".$fecha_h; 
	   $sSQL = "SELECT BAN010.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN010.Tipo_Registro, BAN010.Tipo_Mov_Trans, BAN010.Referencia,
                BAN010.Descrip_Mov_Trans, BAN010.Beneficiario, BAN010.Fecha_Mov_Trans, BAN010.Monto_Mov_Trans, BAN010.Mes_Conciliado, to_char(BAN010.Fecha_Mov_Trans,'DD/MM/YYYY') as fecham
                FROM BAN002, BAN010 WHERE BAN002.Cod_Banco = BAN010.Cod_Banco AND (BAN010.Tipo_Mov_Trans='CHQ') AND ((BAN010.Tipo_Registro='1') OR (BAN010.Tipo_Registro='2')) AND
                BAN010.Cod_Banco='".$cod_banco_d."'  AND    BAN010.Mes_Conciliado='".$periodod."'   ORDER BY BAN010.Referencia, BAN010.Fecha_Mov_Trans";
    if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Cheques_No_Conciliados.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
             $aBench = $oRpt->getBenchmark();
             $iSec   = $aBench["report_end"]-$aBench["report_start"];
	}
	if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_banco_grupo="0000"; $nombre_banco_grupo=""; $nro_cuenta_grupo="00000000"; 
	      if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		  if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);} $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; }
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $tam_logo;  global $criterio1; global $cod_banco_grupo; global $nombre_banco_grupo; global $nro_cuenta_grupo; 
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(150,10,'CHEQUES NO CONCILIADOS',1,0,'C');
				$this->Ln(17);
				$this->SetFont('Arial','B',8);				
				$this->Cell(200,5,"BANCO: ".$cod_banco_grupo." ".$nombre_banco_grupo." ".$nro_cuenta_grupo,0,1);
				$this->Cell(100,5,$criterio1,0,1,'L');	
				$this->SetFont('Arial','B',6);
				$this->Cell(20,5,'CHEQUE NRO.',1,0);
				$this->Cell(20,5,'FECHA EMISION',1,0,'C');
				$this->Cell(140,5,'NOMBRE BENEFICIARIO',1,0,'L');
				$this->Cell(20,5,'MONTO CHEQUE',1,1,'R');
		
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
		  $i=0; $cant_chq=0; $total_cheque=0; $total=0; $prev_cod_banco="";  $prev_nombre_banco=""; $prev_nro_cuenta="";
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       if($php_os=="WINNT"){$nombre_banco=$nombre_banco; } else{$nombre_banco=utf8_decode($nombre_banco);}
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; 
			   if($prev_cod_banco<>$cod_banco_grupo){ 
			     $pdf->SetFont('Arial','B',6); 
			     if($total_cheque>0){ $total_cheque=formato_monto($total_cheque); 					    
				    $pdf->Cell(164,2,'',0,0);
					$pdf->Cell(20,2,'--------------------',0,1,'R');
					$pdf->Cell(164,5,"Total Banco: ".$prev_cod_banco."  ".$prev_nombre_banco."  ".$prev_nro_cuenta,0,0,'R');  
					$pdf->Cell(20,5,$total_cheque,0,1,'R'); 
					$pdf->AddPage();					
				 }				 
				 $pdf->SetFont('Arial','',6);	
				 $prev_cod_banco=$cod_banco_grupo; $prev_nombre_banco=$nombre_banco_grupo; $prev_nro_cuenta=$nro_cuenta_grupo; $total_cheque=0; 
			   }
               $num_cheque=$registro["referencia"]; $fechae=$registro["fecham"];$monto_cheque=$registro["monto_mov_trans"]; $nombre=$registro["beneficiario"];
			   $total=$total+$monto_cheque; $total_cheque=$total_cheque+$monto_cheque; $monto_cheque=formato_monto($monto_cheque);
			   if($php_os=="WINNT"){$nombre=$registro["beneficiario"]; }else{$nombre=utf8_decode($nombre);}	 $cant_chq=$cant_chq+1;	   
			   
			   $pdf->Cell(20,3,$num_cheque,0,0); 
			   $pdf->Cell(20,3,$fechae,0,0,'C');		   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=140; 
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$monto_cheque,0,1,'R');
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$nombre,0); 
			} $total=formato_monto($total);
			$pdf->SetFont('Arial','B',6);
			//if($total_cheque>0){ $total_cheque=formato_monto($total_cheque); 					    
			//	$pdf->Cell(180,2,'',0,0);
			//	$pdf->Cell(20,2,'--------------------',0,1,'R');
			//	$pdf->Cell(180,5,"Total Banco: ".$prev_cod_banco."    ".$prev_nombre_banco."    ".$prev_nro_cuenta,0,0,'R'); 
			//	$pdf->Cell(20,5,$total_cheque,0,1,'R'); 
			//	$pdf->Ln(10);
			//}
			$pdf->Cell(180,2,'',0,0,'L');
			$pdf->Cell(20,2,'==============',0,1,'R');
			$pdf->Cell(150,2,'Cantidad de Cheques '.$cant_chq,0,0,'L');
			
			$pdf->Cell(30,5,'TOTAL GENERAL: ',0,0,'R');
			$pdf->Cell(20,5,$total,0,1,'R'); 
			$pdf->Output();  
	}
	if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Cheques_No_Concialiado.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>CHEQUES NO CONCILIADOS</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <strong><?	echo $criterio1?></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Cheque Nro</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha Emision</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre Beneficiario</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto Cheque</strong></td>
			 </tr>
		  <?  $i=0;  $total_cheque=0; $total=0; $prev_cod_banco="";  $prev_nombre_banco=""; $prev_nro_cuenta=""; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta;
			   if($prev_cod_banco<>$cod_banco_grupo){ 
			    if($total_cheque>0){ $total_cheque=formato_monto($total_cheque);			
			     ?>	 				 
                  <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
			          <td width="100" align="right">------------------</td>
			      </tr>	
			      <tr>
			          <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="400" align="left"><? echo "Total: ".$prev_cod_banco."   ".$prev_nombre_banco."    ".$prev_nro_cuenta; ?></td>
			          <td width="100" align="right"><? echo $total_cheque; ?></td>
			      </tr>
                 <?}?>	   
			      <tr>
					  <td width="100" align="left">'<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_banco; ?></td>
					  <td width="100" align="left" ><strong></strong></td>
					  <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $nombre_banco."    ".$nro_cuenta; ?></td>
				  </tr>
			     <? 					 
			   $prev_cod_banco=$cod_banco_grupo; $prev_nombre_banco=$nombre_banco_grupo; $prev_nro_cuenta=$nro_cuenta_grupo; $total_cheque=0;  }
			   
			   $num_cheque=$registro["referencia"]; $fechae=$registro["fecham"];$monto_cheque=$registro["monto_mov_trans"]; $nombre=$registro["beneficiario"];
			   $total=$total+$monto_cheque; $total_cheque=$total_cheque+$monto_cheque; $monto_cheque=formato_monto($monto_cheque);$nombre=conv_cadenas($nombre,0);
			   $cant_chq=$cant_chq+1;
               ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $num_cheque; ?></td>
				   <td width="100" align="left"><? echo $fechae; ?></td>
				   <td width="400" align="justify"><? echo $nombre; ?></td>
				   <td width="100" align="right"><? echo $monto_cheque; ?></td>
				 </tr>
			   <? 		  
		  }$total=formato_monto($total);

		  if($total_cheque>0){ $total_cheque=formato_monto($total_cheque); 
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="right">------------------</td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"><? echo "Total: ".$prev_cod_banco."   ".$prev_nombre_banco."    ".$prev_nro_cuenta; ?></td>
			    <td width="100" align="right"><? echo $total_cheque; ?></td>
			</tr>	
		       <? }?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="right">=============</td>
			</tr>	
			<tr>
			    <td width="100" align="left">CANTIDAD:</td>
			    <td width="100" align="left"><? echo $cant_chq; ?></td>
			    <td width="400" align="right"><strong>TOTAL: </strong></td>
			    <td width="100" align="right"><strong><? echo $total; ?></strong></td>
			</tr>	
		   </table><?
    }
 }
?>

