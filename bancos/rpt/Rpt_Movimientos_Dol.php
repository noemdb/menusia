<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$equipo = getenv("COMPUTERNAME"); $mcod_m="ban04L".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$tipo_mov_d=$_GET["tipo_mov_d"];$tipo_mov_h=$_GET["tipo_mov_h"];$referencia_d=$_GET["referencia_d"];$referencia_h=$_GET["referencia_h"];$periodod=$_GET["periodod"]; $imp_benef=$_GET["imp_benef"]; $cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];  
$periodoh=$_GET["periodoh"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$subtotales=$_GET["subtotales"];$ordenarcheque=$_GET["ordenarcheque"];$imprimirbene=$_GET["imprimirbene"];$imprimircuen=$_GET["imprimircuen"];$imprimirorden="N";$imp_sinmov=$_GET["imp_sinmov"]; $tipo_rep=$_GET["tipo_rep"];
$criterio1="";$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
$criterio1="Desde ".$fecha_d." Al ".$fecha_h;    $des_mov=", ban035.descrip_mov_libro as des_mov "; if($imp_benef=="S"){ $des_mov=", text(pre099.nombre)||text('. ')||text(ban035.descrip_mov_libro) as des_mov ";}
if($imp_benef=="B"){ $des_mov=", pre099.nombre as des_mov ";}
if($fecha_d==""){$sfecha_d="2012-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);}  if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
 else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){ $php_os="WINNT";} 
   $Sql="SELECT RPT_MOV_DOLARES_BAN035('".$codigo_mov."','0','".$sfecha_d."','".$sfecha_h."','".$cod_banco_d."','".$cod_banco_h."','".$tipo_mov_d."','".$tipo_mov_h."','".$imprimirorden."','".$imp_sinmov."')";
    
    $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);      $error="ERROR GRABANDO: ".substr($error,0,91);if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
	$sSQL = "SELECT ban042.cod_banco, ban042.nombre_banco, ban042.nro_cuenta,ban035.nro_linea, ban035.tipo_mov_libro, ban035.referencia,ban035.descrip_mov_libro, ban035.fecha_mov_libro,ban035.monto_mov_libro,
				ban035.columna1, ban035.columna2, ban035.columna3, ban035.columna4, ban035.columna5, ban035.ced_rif, ban035.anulado, ban035.campo_str1,ban003.tipo, ban003.operacion, pre099.nombre, 
				extract(month from fecha_mov_libro) as mes_mov, to_char( ban035.fecha_mov_libro,'DD/MM/YYYY') as fecham ".$des_mov."
                FROM ban042 LEFT JOIN ban035 ON ban042.cod_banco=ban035.cod_banco LEFT JOIN ban003 ON ban003.Tipo_Movimiento = ban035.tipo_mov_libro
                LEFT JOIN pre099 ON ban035.ced_rif = pre099.ced_rif
                WHERE ban035.codigo_mov='".$codigo_mov."' AND ban042.cod_banco>='".$cod_banco_d."' AND ban042.cod_banco<='".$cod_banco_h."' AND ban035.ced_rif>='".$cedula_d."' AND ban035.ced_rif<='".$cedula_h."' AND
                ban035.tipo_mov_libro>='".$tipo_mov_d."' AND ban035.tipo_mov_libro<='".$tipo_mov_h."' AND  ban035.referencia>='".$referencia_d."' AND ban035.referencia<='".$referencia_h."' AND
                ban035.fecha_mov_libro>='".$sfecha_d."' AND ban035.fecha_mov_libro<='".$sfecha_h."'  ORDER BY ban042.cod_banco,ban035.nro_linea";
    if($tipo_rep=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");
	       
			 $oRpt = new PHPReportMaker();
             $oRpt->setXML("Rpt_Movimientos_Dolares.xml");
             $oRpt->setUser("$user");
             $oRpt->setPassword("$password");
             $oRpt->setConnection("localhost");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
             $aBench = $oRpt->getBenchmark();
             $iSec   = $aBench["report_end"]-$aBench["report_start"];
   }
   if($tipo_rep=="PDF"){  $res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_banco_grupo=""; $nombre_banco_grupo=""; $nro_cuenta_grupo=""; $prev_col3=0; $prev_col3=0; $prev_col5=0; $saldo_anterior=0;
	      if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		    if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);} $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; 
		    if($registro["columna5"]==0){$saldo_anterior=$registro["columna3"];}else{$saldo_anterior=$registro["columna4"];} $saldo_anterior=formato_monto($saldo_anterior);	
		  }
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $criterio1; global $cod_banco_grupo; global $nombre_banco_grupo; global $nro_cuenta_grupo; global $saldo_anterior; global $prev_col3; global $prev_col4; global $prev_col5;
				$this->Image('../../imagenes/Logo_emp.png',7,7,20);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'MOVIMIENTOS EN DOLARES',1,0,'C');
				$this->Ln(20);
				$this->SetFont('Arial','B',8);
				$this->Cell(100,5,$criterio1,0,1,'L');	                
				$this->Cell(200,5,$cod_banco_grupo." ".$nombre_banco_grupo."  ".$nro_cuenta_grupo,0,1);
				$this->SetFont('Arial','B',7);				
				$this->Cell(8,5,'TIPO',1,0);
				$this->Cell(17,5,'REFERENCIA',1,0,'C');					
				$this->Cell(87,5,'DESCRIPCION',1,0,'L');				
				$this->Cell(20,5,'CTA. FLUJO',1,0,'C');				
				$this->Cell(14,5,'FECHA',1,0,'C');	
				$this->Cell(18,5,'DEBITOS',1,0,'C');
				$this->Cell(18,5,'CREDITOS',1,0,'C');
				$this->Cell(18,5,'SALDO',1,1,'C');
                $this->Cell(180,5,"Saldo Anterior: ",0,0,'R');
				$this->Cell(20,5,$saldo_anterior,0,1,'R');					
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
		  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cod_banco="";  $prev_mes_mov="";
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  
		       $cod_banco=$registro["cod_banco"];  $nombre_banco=utf8_decode($registro["nombre_banco"]); $nro_cuenta=$registro["nro_cuenta"];
		       $mes_mov=$registro["mes_mov"]; if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);} 
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; $mes_mov_grupo=$mes_mov; 
			   if(($prev_mes_mov<>$mes_mov_grupo)or($prev_cod_banco<>$cod_banco_grupo)){
			     $pdf->SetFont('Arial','B',7); 
			     if(($sub_totald>0)or($sub_totalh>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 						    
				    $pdf->Cell(140,2,'',0,0);
					$pdf->Cell(20,2,'-------------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------------',0,1,'R');
					$pdf->Cell(140,5,"Sub-totales : ",0,0,'R'); 
					$pdf->Cell(20,5,$sub_totald,0,0,'R'); 
					$pdf->Cell(20,5,$sub_totalh,0,1,'R'); 				
				 }	 
				 $prev_mes_mov=$mes_mov_grupo; $sub_totald=0; $sub_totalh=0;
			   }
			   if($prev_cod_banco<>$cod_banco_grupo){ 
			     if($registro["columna5"]==0){$saldo_anterior=$registro["columna3"];}else{$saldo_anterior=$registro["columna4"];} $saldo_anterior=formato_monto($saldo_anterior);
			     $pdf->SetFont('Arial','B',7); 
			     if((($totald>0)or($totalh>0))or($i>1)){ $totald=formato_monto($totald); $totalh=formato_monto($totalh); 						    
				    $pdf->Cell(146,2,'',0,0);
					$pdf->Cell(18,2,'===============',0,0,'R');
					$pdf->Cell(18,2,'===============',0,1,'R');
					$pdf->Cell(146,5,"Totales : ",0,0,'R'); 
					$pdf->Cell(18,5,$totald,0,0,'R'); 
					$pdf->Cell(18,5,$totalh,0,1,'R');
                    $pdf->AddPage();
				 }			 
				 $prev_cod_banco=$cod_banco_grupo; $totald=0; $totalh=0;
			   }
			   $pdf->SetFont('Arial','',7);	
		       $tipo_mov_libro=$registro["tipo_mov_libro"]; $referencia=$registro["referencia"]; $descrip_mov_libro=$registro["descrip_mov_libro"]; $fecham=$registro["fecham"]; 
			   $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $mes_mov=$registro["mes_mov"]; $des_mov=$registro["des_mov"]; $monto_mov_libro=$registro["monto_mov_libro"]; $campo_str1=$registro["campo_str1"];
			   $columna1=$registro["columna1"]; $columna2=$registro["columna2"]; $columna4=$registro["columna4"]; 
			   $totald=$totald+$columna1; $totalh=$totalh+$columna2; $sub_totald=$sub_totald+$columna1; $sub_totalh=$sub_totalh+$columna2;
			   $columna1=formato_monto($columna1); 	$columna2=formato_monto($columna2);  $columna4=formato_monto($columna4); 			   
			   if($php_os=="WINNT"){$descrip_mov_libro=$registro["descrip_mov_libro"]; }else{$descrip_mov_libro=utf8_decode($descrip_mov_libro); $des_mov=utf8_decode($des_mov);}		   
			   if(($monto_mov_libro==0)and($referencia=="00000000")){ $tipo_mov_libro=""; $referencia=""; }
			   $pdf->Cell(8,3,$tipo_mov_libro,0,0); 
			   $pdf->Cell(16,3,$referencia,0,0,'L'); 				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=88; 
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$campo_str1,0,0,'L');
			   $pdf->Cell(14,3,$fecham,0,0,'C'); 
			   $pdf->Cell(18,3,$columna1,0,0,'R');
               $pdf->Cell(18,3,$columna2,0,0,'R'); 
               $pdf->Cell(18,3,$columna4,0,1,'R'); 			   
			   if($registro["columna5"]==0){$saldo_anterior=$registro["columna3"];}else{$saldo_anterior=$registro["columna4"];}  $saldo_anterior=formato_monto($saldo_anterior);
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$des_mov,0); 	
			} 			
			$pdf->SetFont('Arial','B',6);
			if(($sub_totald<>0)or($sub_totalh<>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 						    
				$pdf->Cell(146,2,'',0,0);
				$pdf->Cell(18,2,'----------------------',0,0,'R');
				$pdf->Cell(18,2,'----------------------',0,1,'R');
				$pdf->Cell(146,5,"Sub-totales  : ",0,0,'R'); 
				$pdf->Cell(18,5,$sub_totald,0,0,'R'); 
				$pdf->Cell(18,5,$sub_totalh,0,1,'R'); 
			} 

			$pdf->SetFont('Arial','B',6);
			$totald=formato_monto($totald); $totalh=formato_monto($totalh); 						    
			$pdf->Cell(146,2,'',0,0);
			$pdf->Cell(18,2,'===============',0,0,'R');
			$pdf->Cell(18,2,'===============',0,1,'R');
			$pdf->Cell(146,5,"Totales  : ",0,0,'R'); 
			$pdf->Cell(18,5,$totald,0,0,'R'); 
			$pdf->Cell(18,5,$totalh,0,1,'R'); 
			$pdf->Ln(10);
						
			$pdf->Output();   
			$pdf->SetFont('Arial','B',6);
		}
		
	if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_Movimientos_Dolares.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE MOVIMIENTOS EN DOLARES</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" ><strong><?	echo $criterio1?></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Tipo</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Cta.Flujo</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Debitos</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Creditos</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Saldo</strong></td>
			 </tr>
		  <?  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cod_banco="";  $prev_mes_mov="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $mes_mov=$registro["mes_mov"];	$cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; $mes_mov_grupo=$mes_mov; 
               if(($prev_mes_mov<>$mes_mov_grupo)or($prev_cod_banco<>$cod_banco_grupo)){ 
			     if(($sub_totald>0)or($sub_totalh>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 			
			     ?>	 				 
                   	<tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
			          <td width="100" align="left"></td>
					  <td width="100" align="left"></td>
			          <td width="100" align="right">-------------------</td>
			          <td width="100" align="right">-------------------</td>
			          <td width="100" align="right"></td>
			       </tr>	
			       <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
					  <td width="100" align="left"></td>
			          <td width="100" align="left">Sub-Total</td>
				      <td width="100" align="right"><? echo $sub_totald; ?></td>
				      <td width="100" align="right"><? echo $sub_totalh; ?></td>
				      <td width="100" align="right"></td>
			        </tr>	
			     <?}					 
			     $prev_mes_mov=$mes_mov_grupo; $sub_totald=0; $sub_totalh=0;}

			   if($prev_cod_banco<>$cod_banco_grupo){ $saldo_anterior=$registro["columna3"]; $saldo_anterior=formato_monto($saldo_anterior);
			    if((($totald>0)or($totalh>0))or($i>1)){ $totald=formato_monto($totald); $totalh=formato_monto($totalh); 			
			     ?>	 				 
                   	 <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
			          <td width="100" align="left"></td>
					  <td width="100" align="left"></td>
			          <td width="100" align="right">===============</td>
			          <td width="100" align="right">===============</td>
			          <td width="100" align="right"></td>
			        </tr>	
			        <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
					  <td width="100" align="left"></td>
			          <td width="100" align="left">Totales</td>
				      <td width="100" align="right"><? echo $totald; ?></td>
				      <td width="100" align="right"><? echo $totalh; ?></td>
				      <td width="100" align="right"></td>
			        </tr>	
			     <?}
			      ?>	   
			      <tr>
				    <td width="100" align="left"></td>
				    <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $cod_banco; ?></td>
				    <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $nombre_banco."    ".$nro_cuenta; ?></td>
				    <td width="100" align="left"></td>
					<td width="100" align="left"></td>
					<td width="100" align="left"></td>
					<td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">Saldo Anterior:</td>
				    <td width="100" align="right"><? echo $saldo_anterior; ?></td>
			      </tr>
			     <? 					 
			    $prev_cod_banco=$cod_banco_grupo; $totald=0; $totalh=0;}
		       $tipo_mov_libro=$registro["tipo_mov_libro"]; $referencia=$registro["referencia"]; $descrip_mov_libro=$registro["descrip_mov_libro"]; $fecham=$registro["fecham"]; 
			   $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $mes_mov=$registro["mes_mov"];  $des_mov=$registro["des_mov"]; $monto_mov_libro=$registro["monto_mov_libro"]; $campo_str1=$registro["campo_str1"];
			   $columna1=$registro["columna1"]; $columna2=$registro["columna2"]; $saldo_anterior=$registro["columna3"]; $columna4=$registro["columna4"]; 
			   $totald=$totald+$columna1; $totalh=$totalh+$columna2; $sub_totald=$sub_totald+$columna1; $sub_totalh=$sub_totalh+$columna2;
			   $columna1=formato_monto($columna1); 	$columna2=formato_monto($columna2);  $columna4=formato_monto($columna4);  			   
			   $descrip_mov_libro=conv_cadenas($descrip_mov_libro,0); $des_mov=conv_cadenas($des_mov,0); if(($monto_mov_libro==0)and($referencia=="00000000")){ $tipo_mov_libro=""; $referencia=""; }
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $tipo_mov_libro; ?></td>
				   <td width="100" align="left">'<? echo $referencia; ?></td>
				   <td width="400" align="justify"><? echo $des_mov; ?></td>
				   <td width="100" align="center"><? echo $fecham; ?></td>
				   <td width="100" align="left"><? echo $campo_str1; ?></td>
				   <td width="100" align="right"><? echo $columna1; ?></td>
				   <td width="100" align="right"><? echo $columna2; ?></td>
				   <td width="100" align="right"><? echo $columna4; ?></td>
				 </tr>
			   <? 		  
		  }
		  if(($sub_totald>0)or($sub_totalh>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="right">-------------------</td>
			    <td width="100" align="right">-------------------</td>
			    <td width="100" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="left">Sub-Total</td>
			    <td width="100" align="right"><? echo $sub_totald; ?></td>
			    <td width="100" align="right"><? echo $sub_totalh; ?></td>
			    <td width="100" align="right"></td>
			</tr>	
		  <? }

		  if(($totald>0)or($totalh>0)){ $totald=formato_monto($totald); $totalh=formato_monto($totalh); 
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="right">===============</td>
			    <td width="100" align="right">===============</td>
			    <td width="100" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
				<td width="100" align="left"></td>
			    <td width="100" align="left"><strong>Totales</strong></td>
			    <td width="100" align="right"><strong><? echo $totald; ?></strong></td>
			    <td width="100" align="right"><strong><? echo $totalh; ?></strong></td>
			    <td width="100" align="right"></td>
			</tr>	
	     <? } ?>		
		 </table><?
    }	
}
?>

