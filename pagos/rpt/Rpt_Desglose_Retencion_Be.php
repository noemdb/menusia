<? error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc");
$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$tipo_retencion_d=$_GET["tipo_retencion_d"];$tipo_retencion_h=$_GET["tipo_retencion_h"];$nro_orden_d=$_GET["nro_orden_d"];$nro_orden_h=$_GET["nro_orden_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$status_orden=$_GET["status_orden"];$tipo_rpt=$_GET["tipo_rpt"];
$criterio1="Fecha Desde: ".$fecha_d." Al: ".$fecha_h;$Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a"); $php_os=PHP_OS;
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
$sformula="";
   if ($status_orden=='I'){$criterio2="CANCELADA";  
      //$sformula=" and  pag001.status='I' and  pag001.fecha_cheque<='".$fecha_hasta."' ";
	  //$sformula=" and  ((substring(pag001.Tipo_Causado,1,1)<>'A') and ";
      //$sformula=$sformula."(((pag001.status='I') And (pag001.fecha_Cheque<='".$fecha_hasta."'))";
      //$sformula=$sformula." OR ((pag001.status='I') And (pag001.nro_orden In (SELECT nro_orden FROM pag007 Where (fecha_Cheque<='".$fecha_hasta."') And (anulado='S') And (fecha_anulado>'".$fecha_hasta."'))))";
      //$sformula=$sformula." OR ((pag001.status='N') And (pag001.nro_orden In (SELECT nro_orden FROM pag007 Where (fecha_Cheque<='".$fecha_hasta."') And (anulado='S') And (fecha_anulado>'".$fecha_hasta."')))) ) )";
 
      $sformula=" and  (substring(pag001.tipo_causado,1,1)<>'A') and ";
	  $sformula=$sformula."((pag004.status_r='I') And (pag004.fecha_cheque_r<='".$fecha_hasta."'))";
   }
   if ($status_orden=='S'){$criterio2="ANULADA"; 
      $sformula=" and (pag001.anulado='S' and pag001.fecha_anulado<='".$fecha_hasta."') ";
      $sformula=$sformula." and ((pag001.total_causado-pag001.total_retencion-pag001.total_ajuste-pag001.Monto_Am_Ant)-(pag001.Total_Pagado)>0)";
   }
   if ($status_orden=='N'){$criterio2="PENDIENTE"; 
   
      $sformula=" and pag001.status='N' and pag001.anulado='N'  ";
	  $sformula=" and ((substring(pag001.Tipo_Causado,1,1)<>'A') and ";
	  //$sformula=$sformula."((pag001.status='N') or ";	
	  $sformula=$sformula."((((pag001.status='N') and (pag001.nro_orden not in (SELECT nro_orden FROM pag007 Where (fecha_cheque<='".$fecha_hasta."') and ((anulado='S') and (fecha_anulado>'".$fecha_hasta."')) ))) or ";	
	  $sformula=$sformula."((pag001.status='I') and ( (pag001.fecha_cheque>'".$fecha_hasta."') and (pag001.nro_orden not in (SELECT nro_orden FROM pag007 Where (fecha_cheque<='".$fecha_hasta."') and (anulado='S') and (extract(month from fecha_cheque)<>extract(month from fecha_anulado)) ))) ) ) )";
	  $sformula=$sformula." and ((pag001.anulado='N') Or ((pag001.anulado='S') and (pag001.fecha_anulado>'".$fecha_hasta."')))";
	  $sformula=$sformula." and ((pag001.total_causado-pag001.total_retencion-pag001.total_ajuste)>0) )";
	  
	  $sformula=" and  (substring(pag001.tipo_causado,1,1)<>'A') and ";
	  $sformula=$sformula."( ((pag004.status_r='N') and ((pag001.anulado='N') Or ((pag001.anulado='S') and (pag001.fecha_anulado>'".$fecha_hasta."'))) ) or ((pag004.status_r='I') And (pag004.fecha_cheque_r>'".$fecha_hasta."')))";
	}
   if ($status_orden=='L'){$criterio2="LIBERADA"; $sformula=" and pag004.status_r='L' and  pag004.fecha_cheque_r<='".$fecha_hasta."' ";}
   
 function muestra_st_orden($mstatus_ord,$manu,$mfecha_anu,$mfecha_chq){global $status_orden; global $fecha_hasta;
   $ret_st="PENDIENTE";  $mfecha_chq=str_replace("-","",$mfecha_chq); $mfecha_anu=str_replace("-","",$mfecha_anu);
   if (($mstatus_ord=='I')and($mfecha_chq<=$fecha_hasta)){$ret_st="CANCELADA";}
   else{
     if(($manu=='S')and($mfecha_anu<=$fecha_hasta)){$ret_st="ANULADA";}
     if(($mstatus_ord=='L')and($mfecha_chq<=$fecha_hasta)){$ret_st="LIBERADA";}
	 if(($mstatus_ord=='A')and($mfecha_chq<=$fecha_hasta)){$ret_st="ABONADA";}
   }
   if ($status_orden=='I'){$ret_st="CANCELADA";}
   if ($status_orden=='S'){$ret_st="ANULADA";}
   if ($status_orden=='N'){$ret_st="PENDIENTE";} 
   if ($status_orden=='L'){$ret_st=="LIBERADA";}
   return $ret_st;
 }   
   $conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else{ $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
       $sSQL = "SELECT pag004.Nro_Orden_Ret, pag004.Aux_Orden, pag001.fecha, pag004.Des_Orden_Ret,pag004.Monto_Retencion, pag004.Ced_Rif_R, PRE099.Nombre, pag004.Status_R, pag001.anulado, pag001.fecha_anulado, 
				  pag004.Tipo_Retencion, pag004.fecha_Cheque_R, pag004.Tasa_Retencion, pag001.fecha_cheque, pag004.Monto_Objeto_Ret, pag003.Descripcion_Ret, pag001.Tipo_Causado, to_char(pag001.Fecha,'DD/MM/YYYY') as fechae
                  FROM pag001, pag003, pag004, PRE099 WHERE pag004.Ced_Rif_R = PRE099.Ced_Rif AND  pag003.Tipo_Retencion = pag004.Tipo_Retencion AND
                  pag001.Nro_Orden = pag004.aux_orden AND pag001.tipo_causado=pag004.tipo_caus_ret AND pag004.Ced_Rif_R>='".$cedula_d."' AND pag004.Ced_Rif_R<='".$cedula_h."' AND
                  pag004.Tipo_Retencion>='".$tipo_retencion_d."' AND pag004.Tipo_Retencion<='".$tipo_retencion_h."' AND pag004.Nro_Orden_Ret>='".$nro_orden_d."' AND pag004.Nro_Orden_Ret<='".$nro_orden_h."' AND
                  pag001.fecha>='".$fecha_desde."' AND pag001.fecha<='".$fecha_hasta."' " . $sformula ."  order by pag004.Ced_Rif_R, pag004.Nro_Orden_Ret";
    if($tipo_rpt=="HTML"){	  include ("../../class/phpreports/PHPReportMaker.php");
	      //echo $sSQL;
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Desglose_Retencion_Benf.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $ced_rif_r_grupo=""; $nombre_grupo="";	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 	
		function Header(){ global $criterio1; global $ced_rif_r_grupo; global $nombre_grupo; global $registro; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(40);
			$this->Cell(145,10,'DESGLOSE RETENCIONES POR BENEFICIARIOS',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,5,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(15,5,'ORDEN',1,0);
			$this->Cell(15,5,'FECHA',1,0);
			$this->Cell(10,5,'TIPO',1,0);
			$this->Cell(91,5,'DESCRIPCION RETENCION',1,0);
			$this->Cell(24,5,'MONTO OBJETO',1,0,'C');
			$this->Cell(10,5,'TASA',1,0,'C');
			$this->Cell(20,5,'MONTO',1,0,'C');
			$this->Cell(15,5,'ESTATUS',1,1);
            if($ced_rif_r_grupo<>""){ 
				 $this->Cell(30,5,"Ced/Rif:".$ced_rif_r_grupo,0,0,'L'); 	
				 $this->Cell(170,5,"Nombre:".$nombre_grupo,0,1,'L');
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
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total=0; $sub_total=""; $cantidad=0; $prev_ced_rif_r="";
	  $res=pg_query($sSQL);
	 // $pdf->MultiCell(200,3,$sSQL,0); 
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $ced_rif_r=$registro["ced_rif_r"];  $nombre=$registro["nombre"]; if($php_os=="WINNT"){$nombre=$registro["nombre"];} else{$nombre=utf8_decode($nombre); }
		   $ced_rif_r_grupo=$ced_rif_r;  $nombre_grupo=$nombre;  
		    if($prev_ced_rif_r<>$ced_rif_r_grupo){ 
			     $pdf->SetFont('Arial','B',7); 
			     if(($sub_total<>0)){ $sub_total=formato_monto($sub_total);					    
				    $pdf->Cell(165,2,'',0,0);
					$pdf->Cell(20,2,'----------------',0,1,'R');
					$pdf->Cell(165,5,"TOTAL BENEFICIARIO : ",0,0,'R'); 
					$pdf->Cell(20,5,$sub_total,0,0,'R'); 
					$pdf->Cell(15,5,'',0,1,'R'); 
					$pdf->AddPage();					
				 }else{ $pdf->Cell(30,5,"Ced/Rif: ".$ced_rif_r_grupo,0,0,'L');
                 	$pdf->Cell(170,5,"Nombre: ".$nombre_grupo,0,1,'L'); }				 
				 $pdf->SetFont('Arial','',7);	
				 $prev_ced_rif_r=$ced_rif_r_grupo; $sub_total=0;
			}
		   
		   $aux_orden=$registro["aux_orden"]; $fecha=$registro["fecha"]; $descripcion_ret=$registro["descripcion_ret"]; $cant_ordenes=$registro["cant_ordenes"];
		   $status_r=$registro["status_r"]; $ced_rif_r=$registro["ced_rif_r"]; $nombre=$registro["nombre"]; $tipo_retencion=$registro["tipo_retencion"]; 
		   $monto_objeto_ret=$registro["monto_objeto_ret"]; $tasa_retencion=$registro["tasa_retencion"]; $monto_retencion=$registro["monto_retencion"];
		   $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque_r"];
		   $st_orden=muestra_st_orden($status_r,$anulado,$fecha_anulado,$fecha_cheque); $cantidad=$cantidad+1;
		   $total=$total+$monto_retencion; $sub_total=$sub_total+$monto_retencion; 
		   $monto_retencion=formato_monto($monto_retencion); $cant_ordenes=formato_monto($cant_ordenes); $fecha=formato_ddmmaaaa($fecha);$tasa_retencion=formato_monto($tasa_retencion);
		   $monto_objeto_ret=formato_monto($monto_objeto_ret);
		   if($php_os=="WINNT"){$nombre=$registro["nombre"];} else{$nombre=utf8_decode($nombre); $descripcion_ret=utf8_decode($descripcion_ret);} 
		   $pdf->Cell(15,3,$aux_orden,0,0); 	
           $pdf->Cell(15,3,$fecha,0,0);	 
           $pdf->Cell(10,3,$tipo_retencion,0,0);	  
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=95;		   
		   $pdf->SetXY($x+$w,$y);
		   $pdf->Cell(20,3,$monto_objeto_ret,0,0,'R');
		   $pdf->Cell(10,3,$tasa_retencion,0,0,'R');		   
		   $pdf->Cell(20,3,$monto_retencion,0,0,'R'); 
		   $pdf->Cell(15,3,$st_orden,0,1);
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($w,3,$descripcion_ret,0); 
		} $total=formato_monto($total); $cantidad==formato_monto ($cantidad);
		$pdf->SetFont('Arial','B',7);
	    if(($sub_total>0)){ $sub_total=formato_monto($sub_total); 						    
			$pdf->Cell(165,5,'',0,0);
			$pdf->Cell(20,2,'----------------',0,1,'R');
			$pdf->Cell(165,3,'',0,0); 
			$pdf->Cell(20,3,$sub_total,0,1,'R'); 
			$pdf->Ln(10);
			
		} 
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(165,5,'',0,0);
		$pdf->Cell(20,3,'==============',0,1,'R');
		$pdf->Cell(165,3,'TOTAL GENERAL : ',0,0,'R');
		$pdf->Cell(20,3,$total,0,0,'R'); 
		$pdf->Cell(15,3,'',0,1);
		$pdf->Output();   
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Desgloce_Ret_Beneficiario.xls");	
	
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="80" align="left" ><strong></strong></td>
		    <td width="100" align="left" ><strong></strong></td>
			<td width="80" align="left" ><strong></strong></td>
            <td width="300" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>DESGLOSE RETENCIONES POR BENEFICIARIOS</strong></font></td>
	     </tr>
	     <tr height="20">
			<td width="80" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="80" align="left" ><strong></strong></td>
			<td width="300" align="center" > <font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	$criterio1?></strong></font></td>
		</tr>
         <tr height="20">
           <td width="80" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDEN</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>FECHA</strong></td>
           <td width="80" align="left" bgcolor="#99CCFF"><strong>TIPO RET</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>DESCRIPCION RETENCION</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO OBJETO</strong></td>
           <td width="50" align="center" bgcolor="#99CCFF" ><strong>TASA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>ESTATUS</strong></font></td>
         </tr>
     <?
	  
	  $i=0;  $total=0; $sub_total=0;  $cantidad=0; $prev_ced_rif_r="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $ced_rif_r=$registro["ced_rif_r"];  $nombre=$registro["nombre"]; $nombre=conv_cadenas($nombre,0);
		   $ced_rif_r_grupo=$ced_rif_r;  $nombre_grupo=$nombre;    
		   if($prev_ced_rif_r<>$ced_rif_r_grupo){ 
			 if($sub_total<>0){ $sub_total=formato_monto($sub_total); 
			     ?>	 				 
                <tr>
			      <td width="80" align="left"></td>
				  <td width="100" align="left"></td>
				  <td width="80" align="left"></td>
			      <td width="300" align="left"></td>
			      <td width="100" align="left"></td>
				  <td width="50" align="left"></td>
			      <td width="100" align="right">---------------</td>
				  <td width="100" align="left"></td>
			    </tr>	
			    <tr>
			       <td width="80" align="left"></td>
				   <td width="100" align="left"></td>
				   <td width="80" align="left"></td>
			       <td width="300" align="left"></td>
			       <td width="100" align="left"></td>
				   <td width="50" align="left"></td>
				   <td width="100" align="right"><? echo $sub_total; ?></td>
			       <td width="100" align="left"></td>
			    </tr>	
			    <tr>
				  <td width="80" align="left"></td>
			    </tr>	
             <? }?>	   
			      <tr>
				  <td width="80" align="left">Ced/Rif :</td>
				  <td width="100" align="left"><? echo $ced_rif_r; ?></td>
				  <td width="80" align="left">Nombre :</td>
				  <td width="300" align="left"><? echo $nombre; ?></td>
			      </tr>
			     <? 					 
			    $prev_ced_rif_r=$ced_rif_r_grupo; $sub_total=0;
		   }
		   $aux_orden=$registro["aux_orden"]; $fecha=$registro["fecha"]; $descripcion_ret=$registro["descripcion_ret"]; 
		   $status_r=$registro["status_r"]; $ced_rif_r=$registro["ced_rif_r"]; $nombre=$registro["nombre"]; $tipo_retencion=$registro["tipo_retencion"]; 
		   $monto_objeto_ret=$registro["monto_objeto_ret"]; $tasa_retencion=$registro["tasa_retencion"]; $monto_retencion=$registro["monto_retencion"];
		   $anulado=$registro["anulado"]; $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque_r"];
		   $st_orden=muestra_st_orden($status_r,$anulado,$fecha_anulado,$fecha_cheque); $cantidad=$cantidad+1;
		   $total=$total+$monto_retencion; $sub_total=$sub_total+$monto_retencion; 
		   $monto_retencion=formato_monto($monto_retencion); $fecha=formato_ddmmaaaa($fecha);$tasa_retencion=formato_monto($tasa_retencion);
		   $monto_objeto_ret=formato_monto($monto_objeto_ret);	 $nombre=conv_cadenas($nombre,0);  $descripcion_ret=conv_cadenas($descripcion_ret,0);
	      ?>	   
		   <tr>
                <td width="80" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $aux_orden; ?></td>
           		<td width="100" align="left"><? echo $fecha; ?></td>
           		<td width="80" align="left"><? echo $tipo_retencion; ?></td>
           		<td width="300" align="justify"><? echo $descripcion_ret; ?></td>
           		<td width="100" align="right"><? echo $monto_objeto_ret; ?></td>
           		<td width="50" align="right"><? echo $tasa_retencion; ?></td>
           		<td width="100" align="right"><? echo $monto_retencion; ?></td>
           		<td width="100" align="center"><? echo $st_orden; ?></td>
            </tr>
	    <? 
	    }  
        if($sub_total<>0){ $sub_total=formato_monto($sub_total); 
			?>	 				 
			<tr>
			   <td width="80" align="left"></td>
		       <td width="100" align="left"></td>
			   <td width="80" align="left"></td>
			   <td width="300" align="left"></td>
			   <td width="100" align="left"></td>
			   <td width="50" align="left"></td>
			   <td width="100" align="right">---------------</td>
		       <td width="100" align="left"></td>
			</tr>	
			<tr>
			   <td width="80" align="left"></td>
			   <td width="100" align="left"></td>
			   <td width="80" align="left"></td>
			   <td width="300" align="left"></td>
			   <td width="100" align="left"></td>
			   <td width="50" align="left"></td>
		       <td width="100" align="right"><? echo $sub_total; ?></td>
			   <td width="100" align="left"></td>
			</tr>	
			<?
		  }$total=formato_monto($total); $cantidad==formato_monto ($cantidad);	
		    ?>	 				 
   		   <tr>
     		   <td>&nbsp;</td>
            </tr>
            <tr>
				<td width="80"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
				<td width="100" align="right"><strong></strong></td>
				<td width="80" align="right"><strong></strong></td>
				<td width="300" align="right"><strong>TOTAL ORDENES:</strong></td>
				<td width="100" align="right"><strong></strong></td>
				<td width="50" align="right"><strong></strong></td>
				<td width="100" align="right"><strong><? echo $total; ?></strong></td>
				<td width="100" align="right"><strong></strong></td>
			 </tr>
		</table><?
        }		  
    }
?>
