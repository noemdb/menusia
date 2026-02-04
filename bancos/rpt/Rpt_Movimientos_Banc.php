<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$tipo_mov_d=$_GET["tipo_mov_d"];$tipo_mov_h=$_GET["tipo_mov_h"];$referencia_d=$_GET["referencia_d"];$referencia_h=$_GET["referencia_h"];$periodod=$_GET["periodod"];$periodoh=$_GET["periodoh"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$tipo_rep=$_GET["tipo_rep"];
$Sql="";$criterio1=""; $date = date("d-m-Y");$hora = date("H:i:s a"); $criterio1="Desde ".$fecha_d." Al ".$fecha_h;     $criterio2=""; $mcod_m="BAN05L".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
if($fecha_d==""){$sfecha_d="2010-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);} if($fecha_h==""){$sfecha_h="2999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} } 
    $Sql="SELECT RPT_mov_banco_BAN039('".$codigo_mov."','0','".$sfecha_d."','".$sfecha_h."','".$cod_banco_d."','".$cod_banco_h."','".$tipo_mov_d."','".$tipo_mov_h."','F','S')";
    $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn);      $error="ERROR GRABANDO: ".substr($error, 0, 61);  if (!$resultado){?><script language="JavaScript">muestra('<? echo $error; ?>');</script><? }
    $sSQL = "SELECT ban039.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta,   ban039.Tipo_Mov_Banco, ban039.Referencia, ban039.Fecha_Mov_Banco, ban039.Monto_Mov_Banco,
				ban039.columna1, ban039.columna2, ban039.columna3, ban039.columna4, ban039.columna5, BAN003.Tipo,	BAN003.Operacion, extract(month from fecha_mov_banco) as mes_mov, to_char(fecha_mov_banco,'DD/MM/YYYY') as fecham  
				FROM BAN002 BAN002, BAN003 BAN003, ban039 ban039
                WHERE BAN002.Cod_Banco = ban039.Cod_Banco AND ban039.Tipo_Mov_Banco = BAN003.Tipo_Movimiento AND ban039.codigo_mov='".$codigo_mov."' AND
                ban039.Cod_Banco>='".$cod_banco_d."' AND ban039.Cod_Banco<='".$cod_banco_h."' AND  ban039.Tipo_Mov_Banco>='".$tipo_mov_d."' AND ban039.Tipo_Mov_Banco<='".$tipo_mov_h."' AND
                ban039.Referencia>='".$referencia_d."' AND ban039.Referencia<='".$referencia_h."' AND  ban039.Fecha_Mov_Banco>='".$sfecha_d."' AND ban039.Fecha_Mov_Banco<='".$sfecha_h."'
                ORDER BY ban039.Cod_Banco, ban039.Fecha_Mov_Banco, substring(ban039.Referencia,3,6)";
    if($tipo_rep=="HTML"){	 include ("../../class/phpreports/PHPReportMaker.php");
     	$oRpt = new PHPReportMaker();
        $oRpt->setXML("Rpt_Movimientos_Bancos.xml");
        $oRpt->setUser("$user");
        $oRpt->setPassword("$password");
         $oRpt->setConnection("$host");
             $oRpt->setDatabaseInterface("postgresql");
             $oRpt->setSQL($sSQL);
             $oRpt->setDatabase("$dbname");
             $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2));
             $oRpt->putEnvObj("nombre_empresa",$Nom_Emp);
             $oRpt->run();
             $aBench = $oRpt->getBenchmark();
             $iSec   = $aBench["report_end"]-$aBench["report_start"];
	}	 
	if($tipo_rep=="PDF"){   $res=pg_query($sSQL); $filas=pg_num_rows($res); $cod_banco_grupo="0000"; $nombre_banco_grupo=""; $nro_cuenta_grupo="00000000"; 
	      if($filas>=1){$registro=pg_fetch_array($res,0); $cod_banco=$registro["cod_banco"]; $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		  if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);} $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; }
		  require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){global $tam_logo;   global $criterio1; global $cod_banco_grupo; global $nombre_banco_grupo; global $nro_cuenta_grupo;  global $registro;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'REPORTE MOVIMIENTOS EN BANCOS',1,0,'C');
				$this->Ln(20);
				$this->SetFont('Arial','B',9);
				$this->Cell(100,5,$criterio1,0,1,'L');	                
				$this->Cell(200,5,$cod_banco_grupo." ".$nombre_banco_grupo."  ".$nro_cuenta_grupo,0,1);
				$this->SetFont('Arial','B',8);	                
			    $this->Cell(20,5,'TIPO',1,0);
			    $this->Cell(20,5,'REFERENCIA',1,0,'C');						
			    $this->Cell(70,5,'FECHA',1,0,'L');	
			    $this->Cell(30,5,'DEBITOS',1,0,'C');
			    $this->Cell(30,5,'CREDITOS',1,0,'C');
			    $this->Cell(30,5,'SALDO ACTUAL',1,1,'C'); 
                $saldo_anterior=$registro["columna3"]; $saldo_anterior=formato_monto($saldo_anterior);
				$this->Cell(170,5,"Saldo Anterior:",0,0,'R');
                $this->Cell(30,5,$saldo_anterior,0,1,'R');	
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
		  $pdf->SetFont('Arial','',6);
		  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cod_banco="";  $prev_mes_mov="";
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nro_cuenta=$registro["nro_cuenta"];
		       $mes_mov=$registro["mes_mov"];$cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; $mes_mov_grupo=$mes_mov; 
               if(($prev_mes_mov<>$mes_mov_grupo)or($prev_cod_banco<>$cod_banco_grupo)){
			     $pdf->SetFont('Arial','B',6); 
			     if(($sub_totald>0)or($sub_totalh>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 						    
				    $pdf->Cell(110,2,'',0,0);
					$pdf->Cell(30,2,'-------------------------',0,0,'R');
					$pdf->Cell(30,2,'-------------------------',0,1,'R');
					$pdf->Cell(110,5,"Sub-totales : ",0,0,'R'); 
					$pdf->Cell(30,5,$sub_totald,0,0,'R'); 
					$pdf->Cell(30,5,$sub_totalh,0,1,'R'); 		
				 }			 
				 $pdf->SetFont('Arial','',6);	
				 $prev_mes_mov=$mes_mov_grupo; $sub_totald=0; $sub_totalh=0;
			   }

			   if($prev_cod_banco<>$cod_banco_grupo){ $saldo_anterior=$registro["columna3"]; $saldo_anterior=formato_monto($saldo_anterior);
			     $pdf->SetFont('Arial','B',6); 
			     if(($totald>0)or($totalh>0)){ $totald=formato_monto($totald); $totalh=formato_monto($totalh); 						    
				    $pdf->Cell(110,2,'',0,0);
					$pdf->Cell(30,2,'===============',0,0,'R');
					$pdf->Cell(30,2,'===============',0,1,'R');
					$pdf->Cell(110,5,"Totales : ",0,0,'R'); 
					$pdf->Cell(30,5,$totald,0,0,'R'); 
					$pdf->Cell(30,5,$totalh,0,1,'R'); 
					$pdf->AddPage();					
				 }				 
				 $pdf->SetFont('Arial','',6);	
				 $prev_cod_banco=$cod_banco_grupo; $totald=0; $totalh=0;
			   }

		       $tipo_mov_banco=$registro["tipo_mov_banco"]; $referencia=$registro["referencia"]; $descrip_mov_libro=$registro["descrip_mov_libro"]; $fecham=$registro["fecham"]; 
			   $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $mes_mov=$registro["mes_mov"];
			   $columna1=$registro["columna1"]; $columna2=$registro["columna2"]; $saldo_anterior=$registro["columna3"]; $columna4=$registro["columna4"]; 
			   $totald=$totald+$columna1; $totalh=$totalh+$columna2; $sub_totald=$sub_totald+$columna1; $sub_totalh=$sub_totalh+$columna2;
			   $columna1=formato_monto($columna1); 	$columna2=formato_monto($columna2);  $columna4=formato_monto($columna4); 
			   if($php_os=="WINNT"){$descrip_mov_libro=$registro["descrip_mov_libro"]; }    else{$descrip_mov_libro=utf8_decode($descrip_mov_libro);}		   
			   $pdf->Cell(20,3,$tipo_mov_banco,0,0,'L'); 
			   $pdf->Cell(20,3,$referencia,0,0,'C'); 				   
			   $pdf->Cell(70,3,$fecham,0,0,'L'); 
			   $pdf->Cell(30,3,$columna1,0,0,'R');
               $pdf->Cell(30,3,$columna2,0,0,'R'); 
               $pdf->Cell(30,3,$columna4,0,1,'R'); 	
			} 

			$pdf->SetFont('Arial','B',6);
			if(($sub_totald>0)or($sub_totalh>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 						    
				$pdf->Cell(110,2,'',0,0);
				$pdf->Cell(30,2,'-------------------------',0,0,'R');
				$pdf->Cell(30,2,'-------------------------',0,1,'R');
				$pdf->Cell(110,5,"Sub-totales : ",0,0,'R'); 
				$pdf->Cell(30,5,$sub_totald,0,0,'R'); 
				$pdf->Cell(30,5,$sub_totalh,0,1,'R'); 
			} 
			$pdf->SetFont('Arial','B',6);
			if(($totald>0)or($totalh>0)){ $totald=formato_monto($totald); $totalh=formato_monto($totalh); 						    
				$pdf->Cell(110,2,'',0,0);
				$pdf->Cell(30,2,'===============',0,0,'R');
				$pdf->Cell(30,2,'===============',0,1,'R');
				$pdf->Cell(110,5,"Totales : ",0,0,'R'); 
				$pdf->Cell(30,5,$totald,0,0,'R'); 
				$pdf->Cell(30,5,$totalh,0,1,'R'); 
				$pdf->Ln(10);
			}
			$pdf->Output();   
		}
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_Movimientos_Bancos.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE MOVIMIENTOS EN BANCOS</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <strong><?	echo $criterio1?></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Tipo</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Debitos</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Creditos</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Saldo Actual</strong></td>
			 </tr>
		  <?  $i=0;  $totald=0; $totalh=0; $sub_totald=0; $sub_totalh=0; $prev_cod_banco="";  $prev_mes_mov="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $mes_mov=$registro["mes_mov"];	 $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; $mes_mov_grupo=$mes_mov; 
               if(($prev_mes_mov<>$mes_mov_grupo)or($prev_cod_banco<>$cod_banco_grupo)){ 
			     if(($sub_totald>0)or($sub_totalh>0)){ $sub_totald=formato_monto($sub_totald); $sub_totalh=formato_monto($sub_totalh); 			
			     ?>	 				 
                   <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
			          <td width="100" align="right">-------------------</td>
			          <td width="100" align="right">-------------------</td>
			          <td width="100" align="right"></td>
			      </tr>	
			      <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="left">Sub-Total</td>
				     <td width="100" align="right"><? echo $sub_totald; ?></td>
				     <td width="100" align="right"><? echo $sub_totalh; ?></td>
				     <td width="100" align="right"></td>
			      </tr>	
			    <?}					 
			     $prev_mes_mov=$mes_mov_grupo; $sub_totald=0; $sub_totalh=0;}
			   if($prev_cod_banco<>$cod_banco_grupo){ $saldo_anterior=$registro["columna3"]; $saldo_anterior=formato_monto($saldo_anterior);
			    if(($totald>0)or($totalh>0)){ $totald=formato_monto($totald); $totalh=formato_monto($totalh); 			
			     ?>	 				 
                   	<tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
			          <td width="100" align="right">=============</td>
			          <td width="100" align="right">=============</td>
			          <td width="100" align="right"></td>
			        </tr>	
			        <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="left">Totales</td>
				      <td width="100" align="right"><? echo $totald; ?></td>
				      <td width="100" align="right"><? echo $totalh; ?></td>
				      <td width="100" align="right"></td>
			        </tr>	
                <?}
			      ?>	   
			      <tr>
				  <td width="100" align="left">'<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_banco; ?></td>
				  <td width="300" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $nombre_banco."    ".$nro_cuenta; ?></td>
				  <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">Saldo Anterior:</td>
				  <td width="100" align="right"><? echo $saldo_anterior; ?></td>
			      </tr>
			     <? 					 
			    $prev_cod_banco=$cod_banco_grupo; $totald=0; $totalh=0;}

		       $tipo_mov_banco=$registro["tipo_mov_banco"]; $referencia=$registro["referencia"]; $descrip_mov_libro=$registro["descrip_mov_libro"]; $fecham=$registro["fecham"]; 
			   $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $mes_mov=$registro["mes_mov"];
			   $columna1=$registro["columna1"]; $columna2=$registro["columna2"]; $saldo_anterior=$registro["columna3"]; $columna4=$registro["columna4"]; 
			   $totald=$totald+$columna1; $totalh=$totalh+$columna2; $sub_totald=$sub_totald+$columna1; $sub_totalh=$sub_totalh+$columna2;
			   $columna1=formato_monto($columna1); 	$columna2=formato_monto($columna2);  $columna4=formato_monto($columna4);  			   
			   $descrip_mov_libro=conv_cadenas($descrip_mov_libro,0);
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $tipo_mov_banco; ?></td>
				   <td width="100" align="left">'<? echo $referencia; ?></td>
				   <td width="400" align="center"><? echo $fecham; ?></td>
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
			    <td width="100" align="right">-------------------</td>
			    <td width="100" align="right">-------------------</td>
			    <td width="100" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left">Sub-Total</td>
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
			    <td width="100" align="right">=============</td>
			    <td width="100" align="right">=============</td>
			    <td width="100" align="right"></td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left">Totales</td>
			    <td width="100" align="right"><? echo $totald; ?></td>
			    <td width="100" align="right"><? echo $totalh; ?></td>
			    <td width="100" align="right"></td>
			</tr>	
		 <? }					
		  		  
		  ?></table><?
    }
    $Sql="Delete from ban039 Where (codigo_mov='".$codigo_mov."')"; $resultado=pg_exec($conn,$Sql);  $error=pg_errormessage($conn); 	
}
?>

