<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$num_cheque_d=$_GET["num_cheque_d"];$num_cheque_h=$_GET["num_cheque_h"];$num_orden_d=$_GET["num_orden_d"];$num_orden_h=$_GET["num_orden_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$tipo_rep=$_GET["tipo_rep"];$imprimir="S";$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
$criterio1="Fecha Desde: ".$fecha_d." Hasta: ".$fecha_h; $criterio2="";if($fecha_d==""){$sfecha_d="2010-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);} 
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
   $sSQL = "SELECT BAN006.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta,BAN006.Num_Cheque, BAN004.Fecha_Mov_Libro,
                BAN006.Ced_Rif, PRE099.Nombre, PAG001.Nro_Orden, BAN004.Descrip_Mov_Libro,BAN006.Anulado, BAN006.Nro_Informe,
                BAN006.Fecha_Anulado, BAN006.Entregado, BAN006.Fecha_Entregado, BAN006.Ced_Rif_Recib, BAN006.Nombre_Recib,
                BAN006.Monto_Cheque, PAG001.Fecha, substring(PAG001.Concepto,1,200) as concepto, (PAG001.Total_Causado- PAG001.Total_Retencion) AS Monto_Orden, PAG001.Nro_Cheque,
				to_char(BAN004.Fecha_Mov_Libro,'DD/MM/YYYY') as fecham, to_char(PAG001.Fecha,'DD/MM/YYYY') as fechao
                FROM BAN002, BAN004, BAN006, PAG001, PRE099
                WHERE BAN006.Cod_Banco = BAN002.Cod_Banco AND BAN004.Cod_Banco = BAN006.Cod_Banco AND
                BAN006.Cod_Banco = PAG001.Cod_Banco AND BAN006.Ced_Rif = PRE099.Ced_Rif AND
                BAN004.Referencia = BAN006.Num_Cheque AND  BAN006.Num_Cheque = PAG001.Nro_Cheque AND 
                (PAG001.tipo_pago='CHQ') AND ((BAN004.Tipo_Mov_Libro='CHQ') OR (BAN004.Tipo_Mov_Libro='ANU')) AND				
                BAN006.Cod_Banco>='".$cod_banco_d."' AND BAN006.Cod_Banco<='".$cod_banco_h."' AND
                BAN006.Num_Cheque>='".$num_cheque_d."' AND BAN006.Num_Cheque<='".$num_cheque_h."' AND
                PAG001.Nro_Orden>='".$num_orden_d."' AND PAG001.Nro_Orden<='".$num_orden_h."' AND
                BAN006.Ced_Rif>='".$cedula_d."' AND BAN006.Ced_Rif<='".$cedula_h."' AND
                BAN004.Fecha_Mov_Libro>='".$sfecha_d."' AND BAN004.Fecha_Mov_Libro<='".$sfecha_h."'
                ORDER BY BAN006.Cod_Banco, BAN006.Fecha, BAN006.Num_Cheque, PAG001.Nro_Orden";

	if($tipo_rep=="HTML"){ include ("../../class/phpreports/PHPReportMaker.php");
             $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Relacion_Cheque_Ord_Pago.xml");
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
				$this->Cell(30);
				$this->Cell(150,10,'RELACION CHEQUES / ORDENES DE PAGO',1,0,'C');
				$this->Ln(18);
				$this->SetFont('Arial','B',8);		
				$this->Cell(200,5,$criterio1,0,1,'L');				
                $this->Cell(200,5,$cod_banco_grupo." ".$nombre_banco_grupo."     ".$nro_cuenta_grupo,0,1,'L');
				$this->SetFont('Arial','B',7);
				$this->Cell(13,3,'CHEQUE','RLT',0);	
				$this->Cell(17,3,'','LT',0,'C');						
				$this->Cell(120,3,'','LT',0,'L');
				$this->Cell(15,3,'FECHA','LT',0,'C');	
				$this->Cell(20,3,'MONTO','LT',0,'C');
				$this->Cell(15,3,'','RLT',1,'C');	                				
				
				$this->Cell(13,3,'NUMERO','LB',0);
				$this->Cell(17,3,'CED/RIF','LB',0,'C');						
				$this->Cell(120,3,'NOMBRE','LB',0,'L');
				$this->Cell(15,3,'EMISION','LB',0,'C');	
				$this->Cell(20,3,'CHEQUE','LB',0,'C');
				$this->Cell(15,3,'ESTADO','RLB',1,'C');	 
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
		  $i=0;  $totalm=0; $sub_totalm=0;  $prev_cod_banco=""; $prev_referencia="";   $prev_num_cheque=""; $prev_nombre_banco=$nombre_banco_grupo; $prev_nro_cuenta=$nro_cuenta_grupo;
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $num_cheque=$registro["num_cheque"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $fecham=$registro["fecham"]; $entregado=$registro["entregado"];
		       $descrip_mov_libro=$registro["descrip_mov_libro"]; $monto_cheque=$registro["monto_cheque"];
		       if($entregado=="S"){$entregado="ENTREGADO";}else{if($entregado=="N"){$entregado="CAJA";}else{if($entregado=="U"){$entregado="UNIDAD";}else{$entregado="PROCESO";}}} 
		       if($php_os=="WINNT"){$nombre=$nombre; }	 else{ $nombre=utf8_decode($nombre); $nombre_banco=utf8_decode($nombre_banco); $descrip_mov_libro=utf8_decode($descrip_mov_libro);  }		   
			   $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; $num_cheque_grupo=$num_cheque; $ced_rif_grupo=$ced_rif; 
		       $nombre_grupo=$nombre; $fecham_grupo=$fecham; $entregado_grupo=$entregado; $descrip_mov_libro_grupo=$descrip_mov_libro; $monto_cheque_grupo=$monto_cheque;
               if($prev_cod_banco<>$cod_banco_grupo){ 
			     $pdf->SetFont('Arial','B',7); 
			     if($sub_totalm>0){ 
				    $sub_totalm=formato_monto($sub_totalm); 						    
				    $pdf->Cell(165,2,'',0,0);
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(15,2,'',0,1,'R');
					$pdf->Cell(165,5,"Total Banco: ".$prev_cod_banco."    ".$prev_nombre_banco."    ".$prev_nro_cuenta,0,0,'R');  
					$pdf->Cell(20,5,$sub_totalm,0,0,'R'); 
					$pdf->Cell(15,5,'',0,1,'R');
					$pdf->AddPage();					
				 }				 
				 $pdf->SetFont('Arial','',7);	 $prev_referencia=""; 
				 $prev_cod_banco=$cod_banco_grupo; $prev_nombre_banco=$nombre_banco_grupo;  $prev_nro_cuenta=$nro_cuenta_grupo; $sub_totalm=0; 
				 $prev_num_cheque="";
			   }
               if($prev_num_cheque<>$num_cheque_grupo){ $monto_cheque_grupo=$registro["monto_cheque"]; $monto_cheque_grupo=formato_monto($monto_cheque_grupo);
				  if($sub_totalm<>0){$pdf->Ln(2);}
				  $pdf->Cell(13,4,$num_cheque_grupo,0,0);
				  $pdf->Cell(17,4,$ced_rif_grupo,0,0,'L');
				  $pdf->Cell(120,4,$nombre_grupo,0,0,'L');
				  $pdf->Cell(15,4,$fecham_grupo,0,0,'C');
				  $pdf->Cell(20,4,$monto_cheque_grupo,0,0,'R');
			   	  $pdf->Cell(15,4,$entregado_grupo,0,1,'C');	
				  $pdf->MultiCell(200,3,$descrip_mov_libro_grupo,0);
				  
				  $pdf->Cell(10,3,'',0,0,'R');
				  $pdf->Cell(10,3,'ORDEN',0,0,'R');
				  $pdf->Cell(20,3,'FECHA ORDEN',0,0,'C');
				  $pdf->Cell(120,3,'CONCEPTO',0,0,'L');
				  $pdf->Cell(20,3,'MONTO',0,1,'R');
				  $pdf->Cell(10,2,'',0,0,'R');
				  $pdf->Cell(90,2,'-------------------------------------------------------------------------------------------------------------------------------',0,0,'L');
				  $pdf->Cell(80,2,'----------------------------------------------------------------------------------------------------------',0,1,'L');
				  $pdf->SetFont('Arial','',7);	
				  $prev_num_cheque=$num_cheque_grupo; 
			   }

		       $nro_orden=$registro["nro_orden"]; $fechao=$registro["fechao"]; $concepto=$registro["concepto"]; $num_cheque=$registro["num_cheque"];  
			   $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $fecham=$registro["fecham"]; $entregado=$registro["entregado"]; 
			   $descrip_mov_libro=$registro["descrip_mov_libro"]; $monto_cheque=$registro["monto_cheque"];  $monto_orden=$registro["monto_orden"]; 
		       if($entregado=="S"){$entregado="ENTREGADO";}else{if($entregado=="N"){$entregado="CAJA";}else{if($entregado=="U"){$entregado="UNIDAD";}else{$entregado="PROCESO";}}} 
			   $totalm=$totalm+$monto_orden; $sub_totalm=$sub_totalm+$monto_orden; 
			   $monto_orden=formato_monto($monto_orden);  $monto_cheque=formato_monto($monto_cheque);
			   if($php_os=="WINNT"){$concepto=$registro["concepto"]; }else{$concepto=utf8_decode($concepto);$nombre=utf8_decode($nombre);$descrip_mov_libro=utf8_decode($descrip_mov_libro);}		   
			   $pdf->Cell(10,3,'',0,0,'R'); 
			   $pdf->Cell(10,3,$nro_orden,0,0,'R'); 
			   $pdf->Cell(20,3,$fechao,0,0,'C'); 				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=120; 
			   $pdf->SetXY($x+$n,$y);
               $pdf->Cell(20,3,$monto_orden,0,1,'R'); 
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$concepto,0); 
				
			} $totalm=formato_monto($totalm);
			$pdf->SetFont('Arial','B',7);
			if($sub_totalm>0){ $sub_totalm=formato_monto($sub_totalm); 					    
				$pdf->Cell(165,2,'',0,0);
				$pdf->Cell(20,2,'---------------------',0,0,'R');
				$pdf->Cell(15,2,'',0,1,'R');
				$pdf->Cell(165,5,"Total Banco: ".$prev_cod_banco."    ".$prev_nombre_banco."    ".$prev_nro_cuenta,0,0,'R');
				$pdf->Cell(20,5,$sub_totalm,0,0,'R'); 
				$pdf->Cell(15,5,'',0,1,'R');
				$pdf->Ln(10);
			} 
			$pdf->Cell(165,2,'',0,0);
			$pdf->Cell(20,2,'==============',0,0,'R');
			$pdf->Cell(15,2,'',0,1,'R');
			$pdf->Cell(165,5,'TOTAL GENERAL: ',0,0,'R');
			$pdf->Cell(20,5,$totalm,0,0,'R'); 
			$pdf->Cell(20,5,'',0,1,'R'); 
			$pdf->Output();  
    }
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_Relacion_Cheque_Ord_Pago.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RELACION CHEQUES / ORDENES DE PAGO</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <strong><?	echo $criterio1?></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Cheque</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Ced/Rif</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha Emision</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto Cheque</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Estado</strong></td>
			 </tr>
		  <?  $i=0;  $totalm=0; $sub_totalm=0;  $prev_cod_banco="";  $prev_num_cheque=""; $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $num_cheque=$registro["num_cheque"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $fecham=$registro["fecham"]; $entregado=$registro["entregado"];
		       $descrip_mov_libro=$registro["descrip_mov_libro"]; $monto_cheque=$registro["monto_cheque"];
		       if($entregado=="S"){$entregado="ENTREGADO";}else{if($entregado=="N"){$entregado="CAJA";}else{if($entregado=="U"){$entregado="UNIDAD";}else{$entregado="PROCESO";}}} 
		       $nombre_banco=conv_cadenas($nombre_banco,0); $nombre=conv_cadenas($nombre,0);			   
			   $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; $num_cheque_grupo=$num_cheque; $ced_rif_grupo=$ced_rif; 
		       $nombre_grupo=$nombre; $fecham_grupo=$fecham; $entregado_grupo=$entregado; $descrip_mov_libro_grupo=$descrip_mov_libro; $monto_cheque_grupo=$monto_cheque;
               if($prev_cod_banco<>$cod_banco_grupo){ 
			    if($sub_totalm>0){ $sub_totalm=formato_monto($sub_totalm); 			
			     ?>	 				 
                   	<tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right"></td>
			        </tr>	
			        <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
			          <td width="100" align="right"><? echo "Total Banco: ".$prev_cod_banco; ?></td>
				      <td width="100" align="right"><? echo $sub_totalm; ?></td>
				      <td width="100" align="right"></td>
			        </tr>	
			        <tr>
				      <td width="100" align="left"></td>
			         </tr>	
                  <?}
			      ?>	   
			      <tr>
				  <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>'<? echo $cod_banco; ?></strong></td>
				  <td width="100" align="left"></td>
				  <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $nombre_banco."    ".$nro_cuenta; ?></strong></td>
			      </tr>
			     <? 					 
			    $prev_cod_banco=$cod_banco_grupo; $sub_totalm=0;}

			   if($prev_num_cheque<>$num_cheque_grupo){ $monto_cheque_grupo=$registro["monto_cheque"]; $monto_cheque_grupo=formato_monto($monto_cheque);
			      ?>	   
			      <tr>
					  <td width="100" align="left">'<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $num_cheque; ?></td>
					  <td width="100" align="left"><? echo $ced_rif; ?></td>
					  <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $nombre; ?></td>
					  <td width="100" align="center"><? echo $fecham; ?></td>
					  <td width="100" align="right"><? echo $monto_cheque_grupo; ?></td>
					  <td width="100" align="right"><? echo $entregado; ?></td>
			      </tr>	
			      <tr>
			      	<td width="100" align="right"><strong>Orden</strong></td>
			   	    <td width="100" align="left"><strong>Fecha Orden</strong></td>
			   	    <td width="400" align="left"><strong>Concepto</strong></td>
			     	<td width="100" align="right"><strong>Monto</strong></td>
			   	    <td width="100" align="right"><strong></strong></td>
					<td width="100" align="left"><strong></strong></td>
			      </tr>	
			     <? 					 
			    $prev_num_cheque=$num_cheque_grupo;}
		       $nro_orden=$registro["nro_orden"]; $fechao=$registro["fechao"]; $concepto=$registro["concepto"]; $num_cheque=$registro["num_cheque"];  
			   $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $fecham=$registro["fecham"]; $entregado=$registro["entregado"]; 
			   $descrip_mov_libro=$registro["descrip_mov_libro"]; $monto_cheque=$registro["monto_cheque"];  $monto_orden=$registro["monto_orden"]; 
		       if($entregado=="S"){$entregado="ENTREGADO";}else{if($entregado=="N"){$entregado="CAJA";}else{if($entregado=="U"){$entregado="UNIDAD";}else{$entregado="PROCESO";}}} 
			   $totalm=$totalm+$monto_orden; $sub_totalm=$sub_totalm+$monto_orden;   $monto_orden=formato_monto($monto_orden);  
			   $concepto=conv_cadenas($concepto,0); $nombre=conv_cadenas($nombre,0); $descrip_mov_libro=conv_cadenas($descrip_mov_libro,0);
			   ?>	   
				<tr>
				   <td width="100" align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_orden; ?></td>
				   <td width="100" align="left">'<? echo $fechao; ?></td>
				   <td width="400" align="justify"><? echo $concepto; ?></td>
				   <td width="100" align="right"><? echo $monto_orden; ?></td>
				   <td width="100" align="right"></td>
				   <td width="100" align="right"></td>
				 </tr>	
			   <? 		  
		  }$totalm=formato_monto($totalm);
		  if($sub_totalm>0){ $sub_totalm=formato_monto($sub_totalm); 
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="right"><? echo "Total Banco: ".$prev_cod_banco; ?></td>
			    <td width="100" align="right"><? echo $sub_totalm; ?></td>
			    <td width="100" align="right"></td>
			</tr>	
		   <? }?>	
            <tr>
				<td width="100" align="left"></td>
		   </tr>		   
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="left"></td>
				<td width="100" align="right">=============</td>
			    <td width="100" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="right"><strong>TOTAL</strong></td>
			    <td width="100" align="right"><? echo $totalm; ?></td>
			    <td width="100" align="right"></td>
			</tr>	
		   <?   
		  ?></table><?
    }
			 
}

?>

