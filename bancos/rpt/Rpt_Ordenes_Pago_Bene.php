<? error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc");
$conn = pg_connect("host=".$host." port=5432 password=".$password." user=".$user." dbname=".$dbname.""); $php_os=PHP_OS;        
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
   $cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$nro_orden_d=$_GET["nro_orden_d"];$nro_orden_h=$_GET["nro_orden_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];
   $clasificacion_d=$_GET["clasificacion_d"];$clasificacion_h=$_GET["clasificacion_h"];$tipo_orden_d=$_GET["tipo_orden_d"];$tipo_orden_h=$_GET["tipo_orden_h"];$status_orden=$_GET["status_orden"];$ordenado=$_GET["ordenado"];$detallado=$_GET["detallado"];$tipo_rpt=$_GET["tipo_rpt"];
   $criterio1="fecha Desde: ".$fecha_d." Al: ".$fecha_h; $date = date("d-m-Y");$hora = date("H:i:s a");  $Sql="";
   //cambiar formato a la fecha
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}  else{$fecha_d='';}$fecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
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
	  $sformula=$sformula."((pag001.status='N') or ";	
	  $sformula=$sformula."(((pag001.status='N') and (pag001.nro_orden not in (SELECT nro_orden FROM PAG007 Where (fecha_cheque<='".$fecha_hasta."') and ((anulado='S') and (fecha_anulado>'".$fecha_hasta."')) ))) or ";	
	  $sformula=$sformula."((pag001.status='I') and ( (pag001.fecha_cheque>'".$fecha_hasta."') and (pag001.nro_orden not in (SELECT nro_orden FROM PAG007 Where (fecha_cheque<='".$fecha_hasta."') and (anulado='S') and (extract(month from fecha_cheque)<>extract(month from fecha_anulado)) ))) ) ) )";
	  $sformula=$sformula." and ((pag001.anulado='N') Or ((pag001.anulado='S') and (pag001.fecha_anulado>'".$fecha_hasta."')))";
	  $sformula=$sformula." and ((pag001.total_causado-pag001.total_retencion-pag001.total_ajuste)>0) )";
	}
   if ($status_orden=='L'){$criterio2="LIBERADA"; $sformula=" and pag001.status='L' and  pag001.fecha_cheque<='".$fecha_hasta."' ";}
   
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
   
   if($clasificacion_d=="TODOS"){$cformula="";}
   else{ $cformula="  and pre099.clasificacion>='".$clasificacion_d."' and pre099.clasificacion<='".$clasificacion_h."' "; } 

   $sSQL = "SELECT pag001.Ced_Rif, pre099.nombre, pag001.fecha, pag001.nro_orden, pag001.concepto, (pag001.total_causado-pag001.total_retencion-pag001.total_ajuste-pag001.monto_am_ant+pag001.total_pasivos) as monto_orden, pag001.status, pag001.anulado, pag001.fecha_anulado, pag001.fecha_cheque, to_char(fecha,'DD/MM/YYYY') as fechae 
         FROM pag001, pre099 WHERE pag001.Ced_Rif = pre099.Ced_Rif and  pag001.Ced_Rif>='".$cedula_d."' and pag001.Ced_Rif<='".$cedula_h."' and
         pag001.nro_orden>='".$nro_orden_d."' and pag001.nro_orden<='".$nro_orden_h."' and    pag001.fecha>='".$fecha_desde."' and pag001.fecha<='".$fecha_hasta."' and         
         pag001.tipo_orden>='".$tipo_orden_d."' and pag001.tipo_orden<='".$tipo_orden_h."'" . $sformula . $cformula ." ORDER BY ".$ordenado."";

   if($tipo_rpt=="HTML"){	  include ("../../class/phpreports/PHPReportMaker.php");
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Orden_Pago_Beneficiario.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $ced_rif_grupo=""; $nombre_grupo="";	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 	
		function Header(){ global $criterio1; global $ced_rif_grupo; global $nombre_grupo; global $registro;
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(120,10,'ORDENES DE PAGO POR BENEFICIARIO',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(120,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',6);
			$this->Cell(15,5,'ORDEN',1,0);
			$this->Cell(15,5,'FECHA',1,0);
			$this->Cell(135,5,'CONCEPTO',1,0);
			$this->Cell(20,5,'MONTO',1,0,'C');
			$this->Cell(15,5,'Estatus',1,1);
            if ($ced_rif_grupo<>""){ 
			   //$this->Cell(30,3,"CEDULA/RIF: ".$ced_rif_grupo,0,0,'L');
               //$this->Cell(150,3,"NOMBRE: ".$nombre_grupo,0,1,'L');
			}
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',6);
	  $i=0;  $total=0; $sub_total=""; $cantidad=0; $prev_ced_rif="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $ced_rif=$registro["ced_rif"];  if($php_os=="WINNT"){$nombre=$registro["nombre"];}else{$nombre=utf8_decode($registro["nombre"]); }
		   $ced_rif_grupo=$ced_rif;  $nombre_grupo=$nombre;  
		   if($prev_ced_rif<>$ced_rif_grupo){ 
			 $pdf->SetFont('Arial','B',6); 
			 if(($sub_total>0)){ $sub_total=formato_monto($sub_total);					    
				$pdf->Cell(165,2,'',0,0);
				$pdf->Cell(20,2,'-----------------',0,1,'R');
				$pdf->Cell(165,5,"TOTAL BENEFICIARIO : ",0,0,'R'); 
				$pdf->Cell(20,5,$sub_total,0,0,'R'); 
				$pdf->Cell(15,5,'',0,1,'R'); 	
				$pdf->Ln(5);
			 }	
			 $pdf->Cell(30,3,"CEDULA/RIF: ".$ced_rif_grupo,0,0,'L');
			 $pdf->Cell(150,3,"NOMBRE: ".$nombre_grupo,0,1,'L');
			 $pdf->SetFont('Arial','',6);	
			 $prev_ced_rif=$ced_rif_grupo; $sub_total=0;
		   }		   
		   $nro_orden=$registro["nro_orden"]; $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $status=$registro["status"]; $nombre=$registro["nombre"]; $monto_orden=$registro["monto_orden"];$fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque);
		   $total=$total+$monto_orden; $sub_total=$sub_total+$monto_orden; $cantidad=$cantidad+1;
		   $monto_orden=formato_monto($monto_orden); $fecha=formato_ddmmaaaa($fecha); 
		   if($php_os=="WINNT"){$concepto=$registro["concepto"]; }   else{$nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $temp_nomb=substr($concepto,0,20);
		   $pdf->Cell(15,3,$nro_orden,0,0); 	
           $pdf->Cell(15,3,$fecha,0,0);	   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=135;		   
		   $pdf->SetXY($x+$w,$y);		   
		   $pdf->Cell(20,3,$monto_orden,0,0,'R'); 
		   $pdf->Cell(15,3,$st_orden,0,1); 
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($w,3,$concepto,0); 
		} $total=formato_monto($total); $cantidad=formato_monto ($cantidad);
		$pdf->SetFont('Arial','B',7);
	    if(($sub_total>0)){ $sub_total=formato_monto($sub_total); 						    
			$pdf->Cell(165,2,'',0,0);
			$pdf->Cell(20,2,'-----------------',0,1,'R');
			$pdf->Cell(165,3,'',0,0); 
			$pdf->Cell(20,3,$sub_total,0,1,'R'); 
			$pdf->Ln(10);
		} 
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(165,5,'',0,0);
		$pdf->Cell(20,3,'=============',0,1,'R');
		$pdf->Cell(35,3,'CANTIDAD DE ORDENES: ',0,0,'L');
		$pdf->Cell(30,3,$cantidad,0,0,'L');
		$pdf->Cell(100,3,'TOTAL GENERAL : ',0,0,'R');
		$pdf->Cell(20,3,$total,0,0,'R'); 
		$pdf->Cell(20,3,'',0,1); 
		$pdf->Output();   
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Rpt_Orden_Pago_Beneficiario.xls");	
	
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
		    <td width="100" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDENES DE PAGO POR BENEFICIARIO</strong></font></td>
	     </tr>
	     <tr height="20">
		<td width="100" align="left" ><strong></strong></td>
		<td width="100" align="left" ><strong></strong></td>
		<td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1; ?></strong></font></td>
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDEN</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>FECHA</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>CONCEPTO</strong></td>
           <td width="110" align="center" bgcolor="#99CCFF" ><strong>MONTO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Estatus</strong></font></td>
         </tr>
     <?
	  
	  $i=0;  $total=0; $sub_total=0;  $cantidad=0; $prev_ced_rif="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $ced_rif=$registro["ced_rif"];  $nombre=utf8_decode($registro["nombre"]); 
		    $nombre=conv_cadenas($nombre,0);
		    $ced_rif_grupo=$ced_rif;  $nombre_grupo=$nombre;    
			if($prev_ced_rif<>$ced_rif_grupo){ 
			    if(($sub_total>0)){ $sub_total=formato_monto($sub_total); 
			     ?>	 				 
                   	<tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
			          <td width="110" align="right">---------------</td>
				      <td width="100" align="left"></td>
			         </tr>	
			         <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="400" align="left"></td>
				      <td width="110" align="right"><? echo $sub_total; ?></td>
			          <td width="100" align="left"></td>
			         </tr>	
			        <tr>
				      <td width="100" align="left"></td>
			         </tr>	
                  <?}
			      ?>	   
			      <tr>
				    <td width="100" align="left">Cedula/Rif :</td>
				    <td width="100" align="left"><? echo $ced_rif; ?></td>
				    <td width="400" align="left">Nombre : <? echo $nombre; ?></td>
				    <td width="110" align="left"></td>
				    <td width="100" align="left"></td>
			      </tr>
			     <? 					 
			    $prev_ced_rif=$ced_rif_grupo; $sub_total=0;
			}
  	       $nro_orden=$registro["nro_orden"]; $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $status=$registro["status"]; $nombre=$registro["nombre"]; $monto_orden=$registro["monto_orden"];$fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		   $st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque);
		   $total=$total+$monto_orden; $sub_total=$sub_total+$monto_orden; $cantidad=$cantidad+1;
		   $monto_orden=formato_monto($monto_orden);  $fecha=formato_ddmmaaaa($fecha); 
		   $nombre=conv_cadenas($nombre,0);  $concepto=conv_cadenas($concepto,0);
	?>	   
		   <tr>
                <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_orden; ?></td>
           		<td width="100" align="left"><? echo $fecha; ?></td>
           		<td width="400" align="justify"><? echo $concepto; ?></td>
           		<td width="110" align="right"><? echo $monto_orden; ?></td>
           		<td width="100" align="center"><? echo $st_orden; ?></td>
            </tr>
	    <? 
	}  
        if(($sub_total>0)){ $sub_total=formato_monto($sub_total); 
			?>	 				 
			<tr>
			   <td width="100" align="left"></td>
			   <td width="100" align="left"></td>
			   <td width="400" align="left"></td>
			   <td width="110" align="right">---------------</td>
		       <td width="100" align="left"></td>
			</tr>	
			<tr>
			   <td width="100" align="left"></td>
		       <td width="100" align="left"></td>
			   <td width="400" align="left"></td>
		       <td width="110" align="right"><? echo $sub_total; ?></td>
			   <td width="100" align="left"></td>
			</tr>			
		    <?
		  }$total=formato_monto($total); $cantidad=formato_monto($cantidad);	
		    ?>	 				 
			<tr>
			 <td>&nbsp;</td>
			</tr>
			<tr>
			   <td width="100" align="left">CANTIDAD:</td>
			   <td width="100" align="right"><? echo $cantidad; ?></td>
			   <td width="400" align="right" >TOTAL ORDENES:</td>
			   <td width="110" align="right"><? echo $total; ?></td>
			   <td width="100" align="left"></td>
			</tr>			   
			<?
		  ?></table><?
        }		  
    }

?>
