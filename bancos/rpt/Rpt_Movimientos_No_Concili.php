<? include ("../../class/conect.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$tipo_mov_d=$_GET["tipo_mov_d"]; $tipo_mov_h=$_GET["tipo_mov_h"];$referencia_d=$_GET["referencia_d"]; $referencia_h=$_GET["referencia_h"]; $fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $mov_conc=$_GET["mov_conc"];$tipo_rep=$_GET["tipo_rep"]; 
$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a"); $mcod_m="BAN07L".$usuario_sia.$equipo; $codigo_mov=substr($mcod_m,0,49);
if($fecha_d==""){$sfecha_d="2010-01-01";}else{$sfecha_d=formato_aaaammdd($fecha_d);} if($fecha_h==""){$sfecha_h="9999-12-31";}else{$sfecha_h=formato_aaaammdd($fecha_h);}
$criterio1="Desde ".$fecha_d." Al ".$fecha_h;  $criterio2="MOVIMIENTOS A CONCILIAR";
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else { $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }

    $Sql="delete from ban037 where codigo_mov='".$codigo_mov."'";   $resultado=pg_exec($conn,$Sql);	
	if($mov_conc=="EN LIBRO"){ $nombre_rpt="Rpt_Movimientos_No_Conciliados.xml";
	  $Sql="insert into ban037 select '".$codigo_mov."',ban007.cod_banco,ban007.referencia,ban007.tipo_trans_libro,ban007.fecha_trans_libro,ban007.monto_trans_libro,ban007.beneficiario,ban007.mes_conciliacion,ban007.inf_usuario,ban007.monto_trans_libro,0,0,0,0,'','',ban007.desc_trans_libro FROM ban007,ban003 where ban007.tipo_trans_libro=ban003.tipo_movimiento AND ban003.Tipo='D' and ban007.cod_banco>='".$cod_banco_d."' AND ban007.cod_banco<='".$cod_banco_h."' and mes_conciliacion='00'";   $resultado=pg_exec($conn,$Sql);
      $Sql="insert into ban037 select '".$codigo_mov."',ban007.cod_banco,ban007.referencia,ban007.tipo_trans_libro,ban007.fecha_trans_libro,ban007.monto_trans_libro,ban007.beneficiario,ban007.mes_conciliacion,ban007.inf_usuario,0,ban007.monto_trans_libro,0,0,0,'','',ban007.desc_trans_libro FROM ban007,ban003 where ban007.tipo_trans_libro=ban003.tipo_movimiento AND ban003.Tipo='C' and ban007.cod_banco>='".$cod_banco_d."' AND ban007.cod_banco<='".$cod_banco_h."' and mes_conciliacion='00'";   $resultado=pg_exec($conn,$Sql);
      $Sql="insert into ban037 select '".$codigo_mov."',ban004.cod_banco,ban004.referencia,ban004.tipo_mov_libro,ban004.fecha_mov_libro,ban004.monto_mov_libro,'',ban004.mes_conciliacion,ban004.inf_usuario,ban004.monto_mov_libro,0,0,0,0,'','',ban004.descrip_mov_libro  FROM ban004,ban003 where ban004.tipo_mov_libro=ban003.tipo_movimiento AND ban003.Tipo='D' and ban004.cod_banco>='".$cod_banco_d."' AND ban004.cod_banco<='".$cod_banco_h."' and ban004.fecha_mov_libro<='".$sfecha_h."' and ban004.mes_conciliacion='00' and (ban004.anulado='N') and (ban004.tipo_mov_libro <> 'DAN') and (ban004.tipo_mov_libro <> 'CAN')";   $resultado=pg_exec($conn,$Sql);
      $Sql="insert into ban037 select '".$codigo_mov."',ban004.cod_banco,ban004.referencia,ban004.tipo_mov_libro,ban004.fecha_mov_libro,ban004.monto_mov_libro,'',ban004.mes_conciliacion,ban004.inf_usuario,0,ban004.monto_mov_libro,0,0,0,'','',ban004.descrip_mov_libro  FROM ban004,ban003 where ban004.tipo_mov_libro=ban003.tipo_movimiento AND ban003.Tipo='C' and ban004.cod_banco>='".$cod_banco_d."' AND ban004.cod_banco<='".$cod_banco_h."' and ban004.fecha_mov_libro<='".$sfecha_h."' and ban004.mes_conciliacion='00' and (ban004.anulado='N') and (ban004.tipo_mov_libro <> 'DAN') and (ban004.tipo_mov_libro <> 'CAN')";   $resultado=pg_exec($conn,$Sql);
    }
	else{ $nombre_rpt="Rpt_Movimientos_No_Conc_Bancos.xml";		
	  $Sql="insert into ban037 select '".$codigo_mov."',ban008.cod_banco,ban008.referencia,ban008.tipo_trans_banco,ban008.fecha_trans_banco,ban008.monto_trans_banco,ban008.bene_mov_trans_banco,ban008.mes_conciliacion,ban008.inf_usuario,ban008.monto_trans_banco,0,0,0,0,'','',ban008.des_mov_trans_banco FROM ban008,ban003 where ban008.tipo_trans_banco=ban003.tipo_movimiento AND ban003.Tipo='D' and ban008.cod_banco>='".$cod_banco_d."' AND ban008.cod_banco<='".$cod_banco_h."' and mes_conciliacion='00'"; $resultado=pg_exec($conn,$Sql);
	  $Sql="insert into ban037 select '".$codigo_mov."',ban008.cod_banco,ban008.referencia,ban008.tipo_trans_banco,ban008.fecha_trans_banco,ban008.monto_trans_banco,ban008.bene_mov_trans_banco,ban008.mes_conciliacion,ban008.inf_usuario,0,ban008.monto_trans_banco,0,0,0,'','',ban008.des_mov_trans_banco FROM ban008,ban003 where ban008.tipo_trans_banco=ban003.tipo_movimiento AND ban003.Tipo='C' and ban008.cod_banco>='".$cod_banco_d."' AND ban008.cod_banco<='".$cod_banco_h."' and mes_conciliacion='00'"; $resultado=pg_exec($conn,$Sql);
      $Sql="insert into ban037 select '".$codigo_mov."',ban005.cod_banco,ban005.referencia,ban005.tipo_mov_banco,ban005.fecha_mov_banco,ban005.monto_mov_banco,ban005.benef_mov_banco,ban005.mes_conciliacion,ban005.inf_usuario,ban005.monto_mov_banco,0,0,0,0,'','',ban005.des_mov_banco FROM ban005,ban003 where ban005.tipo_mov_banco=ban003.tipo_movimiento AND ban003.Tipo='D' and ban005.cod_banco>='".$cod_banco_d."' AND ban005.cod_banco<='".$cod_banco_h."' and ban005.fecha_mov_banco<='".$sfecha_h."' and ban005.mes_conciliacion='00'"; $resultado=pg_exec($conn,$Sql);
      $Sql="insert into ban037 select '".$codigo_mov."',ban005.cod_banco,ban005.referencia,ban005.tipo_mov_banco,ban005.fecha_mov_banco,ban005.monto_mov_banco,ban005.benef_mov_banco,ban005.mes_conciliacion,ban005.inf_usuario,0,ban005.monto_mov_banco,0,0,0,'','',ban005.des_mov_banco FROM ban005,ban003 where ban005.tipo_mov_banco=ban003.tipo_movimiento AND ban003.Tipo='C' and ban005.cod_banco>='".$cod_banco_d."' AND ban005.cod_banco<='".$cod_banco_h."' and ban005.fecha_mov_banco<='".$sfecha_h."' and ban005.mes_conciliacion='00'"; $resultado=pg_exec($conn,$Sql);
	  $Sql="SELECT codigo_mov, cod_banco, referencia, tipo_trans_libro, fecha_trans_libro, monto_trans_libro, beneficiario, mes_conciliacion, inf_usuario, columna1, columna2, columna3, columna4, columna5, campo_str1, campo_str2, desc_trans_libro FROM ban037";
    }
	
	$sSQL = "SELECT ban037.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, ban037.Tipo_Trans_Libro,ban037.Referencia, ban037.Fecha_Trans_Libro, ban037.Beneficiario, ban037.Monto_Trans_Libro, ban037.columna1, ban037.columna2,
                ban037.Desc_Trans_Libro, ban037.Desc_Trans_Libro, BAN003.Tipo, to_char(ban037.Fecha_Trans_Libro,'DD/MM/YYYY') as fecham, substring(ban037.Desc_Trans_Libro,1,100) as desc_m
                FROM BAN002 BAN002, BAN003 BAN003, ban037 ban037 WHERE ban037.codigo_mov='".$codigo_mov."' AND BAN002.Cod_Banco = ban037.Cod_Banco AND ban037.Tipo_Trans_Libro = BAN003.Tipo_Movimiento AND
				BAN002.Cod_Banco>='".$cod_banco_d."' AND BAN002.Cod_Banco<='".$cod_banco_h."' AND ban037.Tipo_Trans_Libro>='".$tipo_mov_d."' AND ban037.Tipo_Trans_Libro<='".$tipo_mov_h."' AND
                ban037.Referencia>='".$referencia_d."' AND ban037.Referencia<='".$referencia_h."' AND ban037.Fecha_Trans_Libro<='".$sfecha_h."'
                ORDER BY BAN002.Cod_Banco,ban037.Fecha_Trans_Libro,ban037.Referencia";
				
	if($tipo_rep=="HTML"){ 		include ("../../class/phpreports/PHPReportMaker.php");	
  			 $oRpt = new PHPReportMaker();
             $oRpt->setXML($nombre_rpt);
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
				$this->Cell(150,10,'MOVIMIENTOS A CONCILIAR EN LIBROS',1,0,'C');
				$this->Ln(18);
				$this->SetFont('Arial','B',8);
				$this->Cell(100,5,$criterio1,0,1,'L');					
				$this->Cell(200,5,"BANCO: ".$cod_banco_grup." ".$nombre_banco_grupo."     ".$nro_cuenta_grupo,0,1,'L');
				$this->SetFont('Arial','B',7);
				$this->Cell(7,5,'TIPO',1,0);
				$this->Cell(17,5,'REFERENCIA',1,0,'C');	
				$this->Cell(13,5,'FECHA',1,0,'C');					
				$this->Cell(123,5,'DESCRIPCION',1,0,'L');	
				$this->Cell(20,5,'DEBITOS',1,0,'C');
				$this->Cell(20,5,'CREDITOS',1,1,'C');	
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
		  $i=0;  $totald=0; $totalc=0; $prev_cod_banco="";  
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];   $nombre_banco=$registro["nombre_banco"]; 
if($php_os=="WINNT"){$nombre_banco=$nombre_banco;} else{$nombre_banco=utf8_decode($nombre_banco);} 
$nro_cuenta=$registro["nro_cuenta"];
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; 

			   if($prev_cod_banco<>$cod_banco_grupo){ 
			     $pdf->SetFont('Arial','B',7); 
			     if(($totald>0)or($totalc>0)){ $totald=formato_monto($totald); $totalc=formato_monto($totalc); 						    
				    $pdf->Cell(160,2,'',0,0);
					$pdf->Cell(20,2,'---------------------',0,0,'R');
					$pdf->Cell(20,2,'---------------------',0,1,'R');
					$pdf->Cell(160,5,"Total Banco: ".$prev_cod_banco."  ".$prev_nombre_banco."  ".$prev_nro_cuenta,0,0,'R');  
					$pdf->Cell(20,5,$totald,0,0,'R'); 
					$pdf->Cell(20,5,$totalc,0,1,'R'); 
					$pdf->AddPage();					
				 }			 
				 $pdf->SetFont('Arial','',7);	
				 $prev_cod_banco=$cod_banco_grupo; $totald=0; $totalc=0;
			   }		           
			   $tipo_trans_libro=$registro["tipo_trans_libro"]; $referencia=$registro["referencia"]; $desc_m=$registro["desc_m"]; $fecham=$registro["fecham"]; 
			   $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $columna1=$registro["columna1"]; $columna2=$registro["columna2"]; 
			   $totald=$totald+$columna1; $totalc=$totalc+$columna2;  $columna1=formato_monto($columna1); 	$columna2=formato_monto($columna2);  
			   if($php_os=="WINNT"){$desc_m=$registro["desc_m"]; } else{$desc_m=utf8_decode($desc_m);}		   
			   $pdf->Cell(7,3,$tipo_trans_libro,0,0); 
			   $pdf->Cell(16,3,$referencia,0,0,'C'); 
			   $pdf->Cell(14,3,$fecham,0,0,'C');				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=123; 			   
			   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(20,3,$columna1,0,0,'R');
               $pdf->Cell(20,3,$columna2,0,1,'R'); 
			   $pdf->SetXY($x,$y);
			   $pdf->MultiCell($n,3,$desc_m,0);
			} 
			$pdf->SetFont('Arial','B',7);
			if(($totald>0)or($totalc>0)){ $totald=formato_monto($totald); $totalc=formato_monto($totalc); 						    
				$pdf->Cell(160,2,'',0,0);
				$pdf->Cell(20,2,'---------------------',0,0,'R');
				$pdf->Cell(20,2,'---------------------',0,1,'R');
				$pdf->Cell(160,5,"Total Banco: ".$prev_cod_banco."  ".$prev_nombre_banco."  ".$prev_nro_cuenta,0,0,'R');  
					$pdf->Cell(20,5,$totald,0,0,'R'); 
				$pdf->Cell(20,5,$totalc,0,1,'R'); 
				$pdf->Ln(10);
			}
			$pdf->Output();  
	}
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_Movimientos_No_Conciliados.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left"><strong></strong></td>
				<td width="100" align="left"><strong></strong></td>
				<td width="100" align="left"><strong></strong></td>
				<td width="400" align="center"> <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>MOVIMIENTOS A CONCILIAR EN LIBROS</strong></font></td>
			 </tr>
			 <tr height="20">
				<td width="100" align="left"><strong></strong></td>
				<td width="100" align="left"><strong></strong></td>
				<td width="100" align="left"><strong></strong></td>
				<td width="400" align="center"><strong><?	echo $criterio1?></strong></td>
			 </tr>
			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Tipo</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Referencia</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Fecha</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Descripcion</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Debitos</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Creditos</strong></td>
			 </tr>
		  <?  $i=0;  $totald=0; $totalc=0; $prev_cod_banco="";  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
		       $cod_banco_grupo=$cod_banco; $nombre_banco_grupo=$nombre_banco; $nro_cuenta_grupo=$nro_cuenta; $mes_mov_grupo=$mes_mov; 
			   if($prev_cod_banco<>$cod_banco_grupo){ 
			    if(($totald>0)or($totalc>0)){ $totald=formato_monto($totald); $totalc=formato_monto($totalc); 			
			     ?>	 				 
                  <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			      </tr>	
			      <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="right"><? echo "Total: ".$prev_cod_banco; ?></td>
				     <td width="100" align="right"><? echo $totald; ?></td>
				     <td width="100" align="right"><? echo $totalc; ?></td>
			      </tr>	
			      <tr>
				  <td width="90" align="left"></td>
			      </tr>	
                  <?}?>	   
			      <tr>
					  <td width="100" align="left">'<font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_banco; ?></td>
					  <td width="100" align="left" ><strong></strong></td>
					  <td width="100" align="left" ><strong></strong></td>
					  <td width="400" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $nombre_banco."    ".$nro_cuenta; ?></td>
				  </tr>
			     <? 					 
			    $prev_cod_banco=$cod_banco_grupo; $totald=0; $totalc=0;}
		       $tipo_trans_libro=$registro["tipo_trans_libro"]; $referencia=$registro["referencia"]; $desc_m=$registro["desc_m"]; $fecham=$registro["fecham"]; 
			   $cod_banco=$registro["cod_banco"];  $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"];
			   $columna1=$registro["columna1"]; $columna2=$registro["columna2"];  $totald=$totald+$columna1; $totalc=$totalc+$columna2; 
			   $columna1=formato_monto($columna1); 	$columna2=formato_monto($columna2);  $desc_m=conv_cadenas($desc_m,0);
			   ?>	   
				<tr>
				   <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $tipo_trans_libro; ?></td>
				   <td width="100" align="left">'<? echo $referencia; ?></td>
				   <td width="100" align="center"><? echo $fecham; ?></td>
				   <td width="400" align="justify"><? echo $desc_m; ?></td>
				   <td width="100" align="right"><? echo $columna1; ?></td>
				   <td width="100" align="right"><? echo $columna2; ?></td>
				 </tr>
			   <? 		  
		  }
		  if(($totald>0)or($totalc>0)){ $totald=formato_monto($totald); $totalc=formato_monto($totalc); 
			?>	 				 
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="400" align="left"></td>
			    <td width="100" align="right">---------------</td>
			    <td width="100" align="right">---------------</td>
			</tr>	
			<tr>
			    <td width="100" align="left"></td>
			    <td width="100" align="left"></td>
			    <td width="100" align="right"></td>
			    <td width="400" align="right"><? echo "Total: ".$cod_banco; ?></td>
			    <td width="100" align="right"><? echo $totald; ?></td>
			    <td width="100" align="right"><? echo $totalc; ?></td>
			</tr>	
		  <? }	  
		  ?></table><?
    }
	$Sql="delete from ban037 where codigo_mov='".$codigo_mov."'";   $resultado=pg_exec($conn,$Sql);			 
}
?>

