<?  error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS; 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{  $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$tipo_orden_d=$_GET["tipo_orden_d"];$tipo_orden_h=$_GET["tipo_orden_h"];$status_orden=$_GET["status_orden"];
$criterio1="FECHA DESDE: ".$fecha_d." AL: ".$fecha_h;$Sql="";$tipo_rpt=$_GET["tipo_rpt"];
     $date = date("d-m-Y");$hora = date("H:i:s a");
     if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
     if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;

	$sformula="";
   if ($status_orden=='I'){$criterio2="CANCELADA";  
      $sformula=" and  pag001.status='I' and  pag001.fecha_cheque<='".$fecha_hasta."' ";
	  $sformula=" and  ((substring(pag001.Tipo_Causado,1,1)<>'A') and ";
      $sformula=$sformula."(((pag001.status='I') And (pag001.fecha_Cheque<='".$fecha_hasta."'))";
      $sformula=$sformula." OR ((pag001.status='I') And (pag001.nro_orden In (SELECT nro_orden FROM PAG007 Where (fecha_Cheque<='".$fecha_hasta."') And (anulado='S') And (fecha_anulado>'".$fecha_hasta."'))))";
      $sformula=$sformula." OR ((pag001.status='N') And (pag001.nro_orden In (SELECT nro_orden FROM PAG007 Where (fecha_Cheque<='".$fecha_hasta."') And (anulado='S') And (fecha_anulado>'".$fecha_hasta."')))) ) )";
 
   }
   if ($status_orden=='S'){$criterio2="ANULADA"; 
      $sformula=" and (pag001.anulado='S' and pag001.fecha_anulado<='".$fecha_hasta."') ";
      $sformula=$sformula." and ((pag001.total_causado-pag001.total_retencion-pag001.total_ajuste-pag001.Monto_Am_Ant)-(pag001.Total_Pagado)>0)";
   }
   if ($status_orden=='N'){$criterio2="PENDIENTE"; 
      $sformula=" and pag001.status='N' and pag001.anulado='N'  ";
	  $sformula=" and ((substring(pag001.Tipo_Causado,1,1)<>'A') and ";
	  //$sformula=$sformula."((pag001.status='N') or ";	
	  $sformula=$sformula."((((pag001.status='N') and (pag001.nro_orden not in (SELECT nro_orden FROM PAG007 Where (fecha_cheque<='".$fecha_hasta."') and ((anulado='S') and (fecha_anulado>'".$fecha_hasta."')) ))) or ";	
	  $sformula=$sformula."((pag001.status='I') and ( (pag001.fecha_cheque>'".$fecha_hasta."') and (pag001.nro_orden not in (SELECT nro_orden FROM PAG007 Where (fecha_cheque<='".$fecha_hasta."') and (anulado='S') and (extract(month from fecha_cheque)<>extract(month from fecha_anulado)) ))) ) ) )";
	  $sformula=$sformula." and ((pag001.anulado='N') Or ((pag001.anulado='S') and (pag001.fecha_anulado>'".$fecha_hasta."')))";
	  $sformula=$sformula." and ((pag001.total_causado-pag001.total_retencion-pag001.total_ajuste)>0) )";
	}
   if ($status_orden=='L'){$criterio2="LIBERADA"; $sformula=" and pag001.status='L' and  pag001.fecha_cheque<='".$fecha_hasta."' ";}
   
 function muestra_st_orden($mstatus_ord,$manu,$mfecha_anu,$mfecha_chq){global $status_orden; global $fecha_hasta;
   $ret_st="PENDIENTE";  $mfecha_chq=str_replace("-","",$mfecha_chq); $mfecha_anu=str_replace("-","",$mfecha_anu);
   if (($mstatus_ord=='I')and($mfecha_chq<=$fecha_hasta)){$ret_st="CANCELADA";}
   else{
     if ($status_orden=='I'){$ret_st="CANCELADA";}
     if ($status_orden=='S'){$ret_st="ANULADA";}
     if ($status_orden=='N'){$ret_st="PENDIENTE";} 
     if ($status_orden=='L'){$ret_st=="LIBERADA";}
   
     if(($manu=='S')and($mfecha_anu<=$fecha_hasta)){$ret_st="ANULADA";}
     if(($mstatus_ord=='L')and($mfecha_chq<=$fecha_hasta)){$ret_st="LIBERADA";}
	 if(($mstatus_ord=='A')and($mfecha_chq<=$fecha_hasta)){$ret_st="ABONADA";}
   }
   
   return $ret_st;
 }

$sSQL = "SELECT pag001.fecha, pag001.nro_orden,pag001.tipo_causado, PRE099.NOMBRE, pag001.CONCEPTO, (pag001.total_causado-pag001.total_retencion-pag001.total_ajuste-pag001.MONTO_AM_ANT+pag001.TOTAL_PASIVOS) as monto_orden, pag001.status, pag001.anulado, pag001.fecha_anulado, pag001.fecha_cheque,  to_char(fecha,'DD/MM/YYYY') as fechae 
FROM pag001,PRE099 WHERE pag001.Ced_Rif = PRE099.Ced_Rif  and pag001.fecha>='".$fecha_desde."' and pag001.fecha<='".$fecha_hasta."' and pag001.tipo_orden>='".$tipo_orden_d."' and pag001.tipo_orden<='".$tipo_orden_h."'" . $sformula . " order by pag001.fecha, pag001.nro_orden, pag001.tipo_causado";

    if($tipo_rpt=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");  
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Orden_Pago_fecha.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $fecha_grupo="";	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){  global $criterio1; global $fecha_grupo; global $registro;  global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(120,10,'REPORTE ORDENES DE PAGO POR FECHA',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(120,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(14,5,'ORDEN',1,0);
			$this->Cell(51,5,'NOMBRE',1,0);
			$this->Cell(100,5,'CONCEPTO',1,0);
			$this->Cell(20,5,'MONTO',1,0,'C');
			$this->Cell(15,5,'ESTATUS',1,1);
            if($fecha_grupo<>""){ 
				//$this->Cell(20,5,"Fecha Emision:",0,0,'L');
                //$this->Cell(20,5,$fecha_grupo,0,1,'L'); 	
			}		
		}  
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			
			// INI NMDB 30-04-2018
	        // $this->Cell(100,5,'fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
	        $this->Cell(100,5,' ',0,0,'R');
	        // FIN NMDB 30-04-2018
		}
	  }
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total=0; $sub_total=0;  $cantidad=0; $prev_fecha=""; $cb=0;
	  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  $fecha=$registro["fecha"]; $fecha=formato_ddmmaaaa($fecha);
		       $fecha_grupo=$fecha;  
			   if($prev_fecha<>$fecha_grupo){ $monto_orden=$registro["monto_orden"]; $monto_orden=formato_monto($monto_orden);
			     $pdf->SetFont('Arial','B',7); 
			     if(($sub_total>0)or($cb>=1)){ $sub_total=formato_monto($sub_total); 					    
					$pdf->Cell(165,2,'',0,0);
					$pdf->Cell(20,2,'=============',0,1,'R');
					$pdf->Cell(165,2,'Total Fecha : '.$prev_fecha." ",0,0,'R');
					$pdf->Cell(20,3,$sub_total,0,1,'R');
                    $pdf->Ln(10);
				 }
				 $pdf->Cell(20,5,"Fecha Emision:",0,0,'L'); $pdf->Cell(20,5,$fecha,0,1,'L'); 				 
				 $pdf->SetFont('Arial','',7);	
				 $prev_fecha=$fecha_grupo; $sub_total=0; $cb=0;
			   }
		   $nro_orden=$registro["nro_orden"];  $nombre=$registro["nombre"]; $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; $monto_orden=$registro["monto_orden"];
		   $fecha=formato_ddmmaaaa($fecha); $status=$registro["status"]; $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque);
		   $total=$total+$monto_orden; $sub_total=$sub_total+$monto_orden; $cantidad=$cantidad+1; $cb=$cb+1;
		   $monto_orden=formato_monto($monto_orden); $fecha=formato_ddmmaaaa($fecha); 
		   if($php_os=="WINNT"){$concepto=$registro["concepto"]; }   else{$nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $pdf->Cell(13,3,$nro_orden,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=52; $w=100;
		   $pdf->SetXY($x+$w+$n,$y);		   
		   $pdf->Cell(20,3,$monto_orden,0,0,'R'); 
		   $pdf->Cell(15,3,$st_orden,0,1);	
		   if ($y>=251) { $nombre=substr($nombre,0,60);}
		   if ($y>=254) { $nombre=substr($nombre,0,30);}
           if(strlen(trim($concepto))>strlen(trim($nombre))){		   
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$nombre,0);  
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($w,3,$concepto,0); 
		   }else{
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($w,3,$concepto,0); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$nombre,0); 
		   }   
			
		} $total=formato_monto($total); $cantidad=formato_monto ($cantidad);
		$pdf->SetFont('Arial','B',7);
	    if(($sub_total>0)or($cb>=1)){ $sub_total=formato_monto($sub_total); 						    
			$pdf->Cell(165,3,'',0,0);
			$pdf->Cell(20,3,'==============',0,1,'R');
			$pdf->Cell(165,2,'Total Fecha : '.$fecha_grupo." ",0,0,'R');
			$pdf->Cell(20,3,$sub_total,0,1,'R'); 
			$pdf->Ln(10);
		}
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(165,5,'',0,0);
		$pdf->Cell(20,3,'==============',0,1,'R');
		$pdf->Cell(35,3,'CANTIDAD DE ORDENES:   ',0,0,'L');
		$pdf->Cell(30,3,$cantidad,0,0,'L');
		$pdf->Cell(100,3,'TOTAL GENERAL : ',0,0,'R');
		$pdf->Cell(20,3,$total,0,1,'R'); 		
		$pdf->Output(); 
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Rpt_Orden_Pago_fecha.xls");	
	
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		   <td width="80" align="left" ><strong></strong></td>
		   <td width="200" align="left" ><strong></strong></td>
           <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDENES DE PAGO POR FECHA</strong></font></td>
	     </tr>
	     <tr height="20">
		   <td width="80" align="left" ><strong></strong></td>
		   <td width="200" align="left" ><strong></strong></td>
		   <td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
	     </tr>
            <tr height="20">
           	   <td width="80" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDEN</strong></td>
                <td width="200" align="left" bgcolor="#99CCFF"><strong>NOMBRE</strong></td>
                <td width="400" align="left" bgcolor="#99CCFF"><strong>CONCEPTO</strong></td>
                <td width="110" align="center" bgcolor="#99CCFF" ><strong>MONTO ORDEN </strong></td>
                <td width="100" align="center" bgcolor="#99CCFF" ><strong>Estatus</strong></font></td>
             </tr>
         <?
	  
	  $i=0;  $total=0; $sub_total=0;  $cantidad=0; $prev_fecha="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $fecha=$registro["fecha"]; $fecha=formato_ddmmaaaa($fecha);
		    $fecha_grupo=$fecha;  
			if($prev_fecha<>$fecha_grupo){ $monto_orden=$registro["monto_orden"]; $monto_orden=formato_monto($monto_orden);
				if(($sub_total>0)){ $sub_total=formato_monto($sub_total); 
				 ?>	 				 
				   <tr>
					  <td width="80" align="left"></td>
					  <td width="200" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="110" align="right">---------------</td>
					  <td width="100" align="left"></td>
				  </tr>	
				  <tr>
					  <td width="80" align="left"></td>
					  <td width="200" align="left"></td>
					  <td width="400" align="left"></td>
					  <td width="110" align="right"><? echo $sub_total; ?></td>
					  <td width="100" align="left"></td>
				  </tr>	
				  <tr>
				  <td width="90" align="left"></td>
				  </tr>	
				 <?  
				}
			      ?>	   
			      <tr>
				  <td width="120" align="left">fecha Emision :</td>
				  <td width="120" align="left"><? echo $fecha; ?></td>
			      </tr>
			     <? 					 
			    $prev_fecha=$fecha_grupo; $sub_total=0;;
			}

		   $nro_orden=$registro["nro_orden"];  $nombre=$registro["nombre"]; $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; $monto_orden=$registro["monto_orden"];
		   $status=$registro["status"]; $Anulado=$registro["Anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque);
		   $total=$total+$monto_orden; $sub_total=$sub_total+$monto_orden; $cantidad=$cantidad+1;
		   $monto_orden=formato_monto($monto_orden); $fecha=formato_ddmmaaaa($fecha); 
            $nombre=conv_cadenas($nombre,0);  $concepto=conv_cadenas($concepto,0);
	    ?>	   
		   <tr>
                <td width="80" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_orden; ?></td>
           		<td width="200" align="left"><? echo $nombre; ?></td>
           		<td width="400" align="justify"><? echo $concepto; ?></td>
           		<td width="110" align="right"><? echo $monto_orden; ?></td>
           		<td width="100" align="center"><? echo $st_orden; ?></td>
           </tr>
	    <? 
	    }  
        if(($sub_total>0)){ $sub_total=formato_monto($sub_total); 
			?>	 				 
			<tr>
			   <td width="80" align="left"></td>
			   <td width="200" align="left"></td>
			   <td width="400" align="left"></td>
			   <td width="110" align="right">---------------</td>
		       <td width="100" align="left"></td>
			</tr>	
			<tr>
			   <td width="80" align="left"></td>
		       <td width="200" align="left"></td>
			   <td width="400" align="left"></td>
		       <td width="110" align="right"><? echo $sub_total; ?></td>
			   <td width="100" align="left"></td>
			</tr>			
		      <?
		  }$total=formato_monto($total); $cantidad==formato_monto ($cantidad);	
		  ?>	 				 
			<tr>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			   <td width="80" align="left"></td>
			   <td width="200" align="left"></td>
			   <td width="400" align="left"></td>
			   <td width="110" align="right">===============</td>
		       <td width="100" align="left"></td>
			</tr>	
			<tr>
			   <td width="80">CANTIDAD ORDENES:</td>
			   <td width="200"><? echo $cantidad; ?></td>
			   <td width="400" align="right">TOTAL ORDENES:</td>
			   <td width="110" align="right"><? echo $total; ?></td>
			   <td width="100" align="left"></td>
			</tr> 
			
		  <?
		  ?></table><?
        }		  
    }
?>
