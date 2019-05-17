<? error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS; 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){ $php_os="WINNT";}
   $nro_orden_d=$_GET["nro_orden_d"];$nro_orden_h=$_GET["nro_orden_h"];$doc_causado_d=$_GET["doc_causado_d"];$doc_causado_h=$_GET["doc_causado_h"]; $tipo_rpt=$_GET["tipo_rpt"];
   $fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$tipo_orden_d=$_GET["tipo_orden_d"];$tipo_orden_h=$_GET["tipo_orden_h"];$status_orden=$_GET["status_orden"];
   $criterio1="Fecha Desde: ".$fecha_d." Hasta: ".$fecha_h; $date = date("d-m-Y");$hora = date("H:i:s a");    $Sql="";
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
   
   $sformula="";
   if ($status_orden=='I'){$criterio2="CANCELADA";  
      $sformula=" and  PAG022.status='I' and  PAG022.fecha_cheque<='".$fecha_hasta."' ";
	  $sformula=" and  ((substring(PAG022.Tipo_Causado,1,1)<>'A') and ";
      $sformula=$sformula."(((PAG022.status='I') And (PAG022.fecha_Cheque<='".$fecha_hasta."'))";
      $sformula=$sformula." OR ((PAG022.status='I') And (PAG022.nro_orden In (SELECT nro_orden FROM PAG007 Where (fecha_Cheque<='".$fecha_hasta."') And (anulado='S') And (fecha_anulado>'".$fecha_hasta."'))))";
      $sformula=$sformula." OR ((PAG022.status='N') And (PAG022.nro_orden In (SELECT nro_orden FROM PAG007 Where (fecha_Cheque<='".$fecha_hasta."') And (anulado='S') And (fecha_anulado>'".$fecha_hasta."')))) ) )";
 
     $sformula=" and  ((PAG022.status='I') and (PAG022.fecha_cheque<='".$fecha_hasta."') )";
      
   }
   
   if ($status_orden=='N'){$criterio2="PENDIENTE"; 
      $sformula=" and PAG022.status='N' and PAG022.anulado='N'  ";
	  $sformula=" and ((substring(PAG022.Tipo_Causado,1,1)<>'A') and ";
	  $sformula=$sformula."((PAG022.status='N') or ";	
	  $sformula=$sformula."(((PAG022.status='N') and (PAG022.nro_orden not in (SELECT nro_orden FROM PAG007 Where (fecha_cheque<='".$fecha_hasta."') and ((anulado='S') and (fecha_anulado>'".$fecha_hasta."')) ))) or ";	
	  $sformula=$sformula."((PAG022.status='I') and ( (PAG022.fecha_cheque>'".$fecha_hasta."') and (PAG022.nro_orden not in (SELECT nro_orden FROM PAG007 Where (fecha_cheque<='".$fecha_hasta."') and (anulado='S') and (extract(month from fecha_cheque)<>extract(month from fecha_anulado)) ))) ) ) )";
	  $sformula=$sformula." and ((PAG022.anulado='N') Or ((PAG022.anulado='S') and (PAG022.fecha_anulado>'".$fecha_hasta."')))";
	  $sformula=$sformula." and ((PAG022.total_causado-PAG022.total_retencion-PAG022.total_ajuste)>0) )";
	  
	  $sformula=" and  PAG022.status='N' ";
	  
	  $sformula="and ((PAG022.status='N') or ";	
	  $sformula=$sformula."((PAG022.status='I') and (PAG022.fecha_cheque>'".$fecha_hasta."') ) )";
	 
      
	}
 
   $cant_orden=0;
   $sql = "SELECT count(PAG022.nro_orden) as cant_orden FROM PAG022, PRE099  WHERE PAG022.Ced_Rif = PRE099.Ced_Rif and   PAG022.nro_orden>='".$nro_orden_d."' and PAG022.nro_orden<='".$nro_orden_h."' and  PAG022.fecha>='".$fecha_desde."' and PAG022.fecha<='".$fecha_hasta."'  and
          PAG022.Ced_Rif>='".$cedula_d."' and PAG022.Ced_Rif<='".$cedula_h."' and	PAG022.tipo_causado>='".$doc_causado_d."' and PAG022.tipo_causado<='".$doc_causado_h."' and  PAG022.tipo_orden>='".$tipo_orden_d."' and PAG022.tipo_orden<='".$tipo_orden_h."'" . $sformula ;
   $res=pg_query($sql); if($registro=pg_fetch_array($res,0)){$cant_orden=$registro["cant_orden"];}
    
   $sSQL = "SELECT PAG022.nro_orden,PAG022.tipo_causado,PRE099.nombre,PAG022.fecha,PAG022.concepto, PAG022.total_causado, PAG022.total_retencion, PAG022.status,  PAG022.fecha, (PAG022.total_causado - PAG022.total_retencion - PAG022.total_ajuste - PAG022.monto_am_ant) AS monto_orden, 
          pag022.cod_banco,PAG022.nro_cheque,PAG022.fecha_cheque,BAN002.nombre_banco 
          FROM PAG022 left join ban002 on (pag022.cod_banco=ban002.cod_banco), PRE099  WHERE PAG022.Ced_Rif = PRE099.Ced_Rif and   PAG022.nro_orden>='".$nro_orden_d."' and PAG022.nro_orden<='".$nro_orden_h."' and  PAG022.fecha>='".$fecha_desde."' and PAG022.fecha<='".$fecha_hasta."'  and
          PAG022.Ced_Rif>='".$cedula_d."' and PAG022.Ced_Rif<='".$cedula_h."' and	PAG022.tipo_causado>='".$doc_causado_d."' and PAG022.tipo_causado<='".$doc_causado_h."' and  PAG022.tipo_orden>='".$tipo_orden_d."' and PAG022.tipo_orden<='".$tipo_orden_h."'" . $sformula . " order by PAG022.nro_orden,PAG022.tipo_causado";
   //echo $sSQL;
   
   if($tipo_rpt=="HTML"){	 include ("../../class/phpreports/PHPReportMaker.php"); 
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Listado_Ord_Per_Ant.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("localhost");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"status_orden"=>$status_orden,"cant_orden"=>$cant_orden,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rpt=="PDF"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){global $criterio1; 
			$this->Image('../../imagenes/Logo_emp.png',7,7,20);
			$this->SetFont('Arial','B',15);
			$this->Cell(40);
			$this->Cell(140,10,'LISTADO ORDENES DE PAGO PERIODO ANTERIOR',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',6);	
			$this->Cell(15,5,'ORDEN',1,0);
			$this->Cell(40,5,'NOMBRE',1,0);
			$this->Cell(70,5,'DESCRIPCION',1,0);
			$this->Cell(20,5,'BRUTO',1,0,'C');
			$this->Cell(20,5,'RETENCIONES',1,0,'C');
			$this->Cell(20,5,'NETO',1,0,'C');
			$this->Cell(15,5,'Estatus',1,1);
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
	  $i=0;  $total=0; $totaln=0; $totalr=0; $cantidad=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $total_causado=$registro["total_causado"]; $status=$registro["status"]; $anulado=$registro["anulado"]; 
		   $nombre=$registro["nombre"];  $monto_ret=$registro["total_retencion"]; $monto_orden=$registro["monto_orden"]; $fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		   $cod_banco=$registro["cod_banco"];  $nro_cheque=$registro["nro_cheque"];  $fecha_cheque=$registro["fecha_cheque"];  $nombre_banco=$registro["nombre_banco"];
		   
		   //$st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque);	
		   if ($status_orden=='N'){$st_orden="PENDIENTE";}else{if($status=="I"){$st_orden="CANCELADA";}	else {$st_orden="PENDIENTE"; } }  $fecha_cheque=formato_ddmmaaaa($fecha_cheque);
		   $total=$total+$monto_orden; $totaln=$totaln+$total_causado; $totalr=$totalr+$monto_ret; $cantidad=$cantidad+1;
		   $total_causado=formato_monto($total_causado); $monto_ret=formato_monto($monto_ret); $monto_orden=formato_monto($monto_orden); 
           if($php_os=="WINNT"){$concepto=$registro["concepto"]; }   else{$nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $pdf->Cell(15,3,$nro_orden,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=40; $w=70;		   
		   $pdf->SetXY($x+$w+$n,$y);
		   $pdf->Cell(20,3,$total_causado,0,0,'R'); 
           $pdf->Cell(20,3,$monto_ret,0,0,'R'); 		   
		   $pdf->Cell(20,3,$monto_orden,0,0,'R'); 
		   $pdf->Cell(15,3,$st_orden,0,0); 
		   if ($y>=251) { $nombre=substr($nombre,0,45);}
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
           if($status=="I"){ 
             $pdf->Cell(15,3,"",0,0); 
			 $pdf->Cell(185,3,"CANCELADA CON BANCO: ".$cod_banco." ".$nombre_banco." NUMERO CHEQUE: ".$nro_cheque." FECHA CHEQUE: ".$fecha_cheque,0,1); 
		   } 
		   $pdf->Ln(1);
		   
		} $total=formato_monto($total); $totaln=formato_monto($totaln); $totalr=formato_monto($totalr);
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(125,2,'',0,0);
		$pdf->Cell(20,2,'===========',0,0,'R');
		$pdf->Cell(20,2,'============',0,0,'R');
		$pdf->Cell(20,2,'============',0,1,'R');
		
		$pdf->Cell(30,3,'Cantidad Ordenes :',0,0,'L');
		$pdf->Cell(10,3,$cantidad,0,0,'L');
		
		$pdf->Cell(85,5,'Total Ordenes :',0,0,'R');
		$pdf->Cell(20,5,$totaln,0,0,'R'); 
		$pdf->Cell(20,5,$totalr,0,0,'R'); 
		$pdf->Cell(20,5,$total,0,0,'R'); 
		$pdf->Cell(15,5,'',0,0);		 
		$pdf->Output();   
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Listado_Ordenes_Pago.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="80" align="left" ><strong></strong></td>
			<td width="200" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO ORDENES DE PAGO</strong></font></td>
		 </tr>
		 <tr height="20">
		   <td width="80" align="left" ><strong></strong></td>
		   <td width="200" align="left" ><strong></strong></td>
		   <td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
	     </tr>
         <tr height="20">
           <td width="80" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDEN</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF"><strong>NOMBRE</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>DESCRIPCION</strong></td>
           <td width="110" align="center" bgcolor="#99CCFF"><strong>BRUTO</strong></td>
           <td width="110" align="center" bgcolor="#99CCFF"><strong>RETENCIONES</strong></td>
           <td width="110" align="center" bgcolor="#99CCFF" ><strong>NETO </strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>Estatus</strong></font></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $totaln=0; $totalr=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];  $tipo_causado=$registro["tipo_causado"];  $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $total_causado=$registro["total_causado"]; $status=$registro["status"]; $anulado=$registro["anulado"];
		   $nombre=$registro["nombre"];  $monto_ret=$registro["total_retencion"]; $monto_orden=$registro["monto_orden"];$fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		   //$st_orden=muestra_st_orden($status,$anulado,$fecha_anulado,$fecha_cheque); 
		   if ($status_orden=='N'){$st_orden="PENDIENTE";}else{if($status=="I"){$st_orden="CANCELADA";}	else {$st_orden="PENDIENTE"; } } $cantidad=$cantidad+1;
		   $total=$total+$monto_orden; $totaln=$totaln+$total_causado; $totalr=$totalr+$monto_ret;
		   $total_causado=formato_monto($total_causado); $monto_ret=formato_monto($monto_ret); $monto_orden=formato_monto($monto_orden); 
		   $nombre=conv_cadenas($nombre,0);  $concepto=conv_cadenas($concepto,0);
	?>	   
		   <tr>
           <td width="80" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_orden; ?></td>
           <td width="200" align="left"><? echo $nombre; ?></td>
           <td width="400" align="justify"><? echo $concepto; ?></td>
           <td width="110" align="right"><? echo $total_causado; ?></td>
           <td width="110" align="right"><? echo $monto_ret; ?></td>
           <td width="110" align="right"><? echo $monto_orden; ?></td>
           <td width="100" align="center"><? echo $st_orden; ?></td>
         </tr>
	<? }  $total=formato_monto($total); $totaln=formato_monto($totaln); $totalr=formato_monto($totalr); ?>
	   <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td width="80"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
		<td width="200"><strong>CANTIDAD ORDENES : <? echo $cantidad; ?></strong></td>	
		<td width="400" align="right"><strong>TOTAL ORDENES:</strong></td>
		<td width="110" align="right"><strong><? echo $totaln; ?></strong></td>
		<td width="110" align="right"><strong><? echo $totalr; ?></strong></td>
		<td width="110" align="right"><strong><? echo $total; ?></strong></font></td>
      </tr>
      
	  </table><?
	}

   }
?>