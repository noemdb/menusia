<?error_reporting(E_ALL ^ E_NOTICE); include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;  
$tipo_retencion_d=$_GET["tipo_retencion_d"];$tipo_retencion_h=$_GET["tipo_retencion_h"];$nro_orden_d=$_GET["numero_orden_d"];$nro_orden_h=$_GET["numero_orden_h"];
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $status_orden=$_GET["status_orden"]; $tipo_rpt=$_GET["tipo_rpt"];
$criterio1="FECHA DESDE: ".$fecha_d." AL: ".$fecha_h;  $Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a");
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);} else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;

$sformula="";

   if ($status_orden=='I'){$criterio2="CANCELADA";     
     // $sformula=" and  pag001.status='I' and  pag001.fecha_cheque<='".$fecha_hasta."' ";
	 // $sformula=" and  ((substring(pag001.tipo_causado,1,1)<>'A') and ";
     // $sformula=$sformula."(((pag001.status='I') And (pag001.fecha_Cheque<='".$fecha_hasta."'))";
     // $sformula=$sformula." OR ((pag001.status='I') And (pag001.nro_orden In (SELECT nro_orden FROM PAG007 Where (fecha_Cheque<='".$fecha_hasta."') And (anulado='S') And (fecha_anulado>'".$fecha_hasta."'))))";
     // $sformula=$sformula." OR ((pag001.status='N') And (pag001.nro_orden In (SELECT nro_orden FROM PAG007 Where (fecha_Cheque<='".$fecha_hasta."') And (anulado='S') And (fecha_anulado>'".$fecha_hasta."')))) ) )";
        $sformula=" and  (substring(pag001.tipo_causado,1,1)<>'A') and ";
		$sformula=$sformula."((pag004.status_r='I') And (pag004.fecha_cheque_r<='".$fecha_hasta."'))";
   }
   
   if ($status_orden=='S'){$criterio2="ANULADA"; 
      $sformula=" and (pag001.anulado='S' and pag001.fecha_anulado<='".$fecha_hasta."') ";
      $sformula=$sformula." and ((pag001.total_causado-pag001.total_retencion-pag001.total_ajuste-pag001.Monto_Am_Ant)-(pag001.Total_Pagado)>0)";
   }
   if ($status_orden=='N'){$criterio2="PENDIENTE"; 
      //$sformula=" and pag001.status='N' and pag001.anulado='N'  ";
	  //$sformula=" and ((substring(pag001.tipo_causado,1,1)<>'A') and ";
	  //$sformula=$sformula."((pag001.status='N') or ";	
	 // $sformula=$sformula."( (((pag001.status='N') and (pag001.nro_orden not in (SELECT nro_orden FROM PAG007 Where (fecha_cheque<='".$fecha_hasta."') and ((anulado='S') and (fecha_anulado>'".$fecha_hasta."')) ))) or ";	
	 // $sformula=$sformula."((pag001.status='I') and ( (pag001.fecha_cheque>'".$fecha_hasta."') and (pag001.nro_orden not in (SELECT nro_orden FROM PAG007 Where (fecha_cheque<='".$fecha_hasta."') and (anulado='S') and (extract(month from fecha_cheque)<>extract(month from fecha_anulado)) ))) ) ) )";
	 // $sformula=$sformula." and ((pag001.anulado='N') Or ((pag001.anulado='S') and (pag001.fecha_anulado>'".$fecha_hasta."')))";
	 // $sformula=$sformula." and ((pag001.total_causado-pag001.total_retencion-pag001.total_ajuste)>0) )";
	   $sformula=" and  (substring(pag001.tipo_causado,1,1)<>'A') and ";
	   $sformula=$sformula."((pag004.status_r='N') or ((pag004.status_r='I') And (pag004.fecha_cheque_r>'".$fecha_hasta."')))";
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
else{  $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
    $sSQL = "SELECT pag004.aux_orden, pag001.Fecha, pag001.Concepto,pag004.Monto_Retencion, pag001.Ced_Rif, PRE099.Nombre, pag001.Status,
              pag001.anulado, pag001.fecha_anulado, pag004.tipo_Retencion,pag004.nro_Orden_Ret, pag001.Fecha_Cheque, pag004.Monto_Objeto_Ret,
              pag004.Tasa_Retencion, pag004.status_r, pag004.Cod_Banco_R,pag004.nro_Cheque_R, pag004.Fecha_Cheque_R, pag004.tipo_Pago_R, 
			  to_char(pag001.Fecha,'DD/MM/YYYY') as fechae, pag001.fecha_cheque FROM pag001, pag004, PRE099
              WHERE pag001.Ced_Rif = PRE099.Ced_Rif AND pag001.nro_orden=pag004.aux_orden AND pag001.tipo_causado=pag004.tipo_caus_ret AND
              pag004.tipo_Retencion>='".$tipo_retencion_d."' AND pag004.tipo_Retencion<='".$tipo_retencion_h."' AND
              pag004.aux_orden>='".$nro_orden_d."' AND pag004.aux_orden<='".$nro_orden_h."' AND
              pag001.Fecha>='".$fecha_desde."' AND pag001.Fecha<='".$fecha_hasta."'" . $sformula . " order by pag004.aux_orden,pag004.tipo_Retencion";

   if($tipo_rpt=="HTML"){	 include ("../../class/phpreports/PHPReportMaker.php");  
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Relac_Orden_Retencion.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rpt=="PDF"){	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){global $criterio1; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(150,10,'REPORTE RELACION RETENCIONES/ORDENES',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',8);	
			$this->Cell(15,5,'ORDEN',1,0);
			$this->Cell(9,5,'TIPO',1,0,'C');
			$this->Cell(140,5,'CONCEPTO',1,0);
			$this->Cell(20,5,'MONTO',1,0,'C');
			$this->Cell(16,5,'ESTATUS',1,1,'C');
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
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total=0;  $cantidad=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $aux_orden=$registro["aux_orden"];  $tipo_retencion=$registro["tipo_retencion"]; $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $status=$registro["status"]; $anulado=$registro["anulado"]; $status_r=$registro["status_r"]; $fecha_cheque_r=$registro["fecha_cheque_r"];
		   $nombre=$registro["nombre"];  $monto_retencion=$registro["monto_retencion"];$fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		   $st_orden=muestra_st_orden($status_r,$anulado,$fecha_anulado,$fecha_cheque_r);
		   $total=$total+$monto_retencion; $cantidad=$cantidad+1;
		   $monto_retencion=formato_monto($monto_retencion); 
           if($php_os=="WINNT"){$concepto=$registro["concepto"]; }   else{$nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $pdf->Cell(15,3,$aux_orden,0,0); 
		   $pdf->Cell(9,3,$tipo_retencion,0,0,'C');		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=140; 	   
		   $pdf->SetXY($x+$n,$y);		   
		   $pdf->Cell(20,3,$monto_retencion,0,0,'R'); 
		   $pdf->Cell(16,3,$st_orden,0,0,'R'); 
		   if(strlen(trim($concepto))){		   
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,3,$concepto,0);  
		   }

		} $total=formato_monto($total); 
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(164,2,'',0,0);
		$pdf->Cell(20,2,'==============',0,0,'R');
		$pdf->Cell(16,2,'',0,1,'R');
		$pdf->Cell(164,5,'TOTAL GENERAL :',0,0,'R');
		$pdf->Cell(20,5,$total,0,0,'R'); 
		$pdf->Cell(16,5,'',0,1);		 
		$pdf->Output();   
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Relacion_Retenciones_Ordenes.xls");		
	  ?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
             <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>RELACION RETENCIONES/ORDENES</strong></font></td>
		 </tr>
		 <tr height="20">
		   <td width="100" align="left" ><strong></strong></td>
		   <td width="50" align="left" ><strong></strong></td>
		   <td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDEN</strong></td>
           <td width="50" align="left" bgcolor="#99CCFF"><strong>TIPO</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>CONCEPTO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>ESTATUS</strong></font></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $aux_orden=$registro["aux_orden"];  $tipo_retencion=$registro["tipo_retencion"]; $fecha=$registro["fecha"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $status=$registro["status"]; $anulado=$registro["anulado"]; $status_r=$registro["status_r"]; $fecha_cheque_r=$registro["fecha_cheque_r"];
		   $nombre=$registro["nombre"];  $monto_retencion=$registro["monto_retencion"];$fecha_anulado=$registro["fecha_anulado"]; $fecha_cheque=$registro["fecha_cheque"];
		   $st_orden=muestra_st_orden($status_r,$anulado,$fecha_anulado,$fecha_cheque_r);
		   $total=$total+$monto_retencion; $cantidad=$cantidad+1;
		   $monto_retencion=formato_monto($monto_retencion); 
		   $nombre=conv_cadenas($nombre,0);  $concepto=conv_cadenas($concepto,0);
	?>	   
         <tr>
           <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $aux_orden; ?></td>
           <td width="50" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $tipo_retencion; ?></td>
           <td width="400" align="justify"><? echo $concepto; ?></td>
           <td width="100" align="right"><? echo $monto_retencion; ?></td>
           <td width="100" align="center"><? echo $st_orden; ?></td>
         </tr>
	<? }  $total=formato_monto($total);  ?>
	   <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td width="100"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
		<td width="50"></td>	
		<td width="400" align="right"><strong>TOTAL GENERAL: </strong></td>
		<td width="100" align="right"><strong><? echo $total; ?></strong></td>
		<td width="100" align="right"></font></td>
      </tr>
      
	  </table><?
	}

   }
?>
