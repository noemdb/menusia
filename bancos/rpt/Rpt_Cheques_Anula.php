<?include ("../../class/seguridad.inc"); include ("../../class/conects.php"); include("../../class/fun_fechas.php"); include("../../class/fun_numeros.php");   include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE); 
$cod_banco_d=$_GET["cod_banco_d"];$cod_banco_h=$_GET["cod_banco_h"];$num_cheque_d=$_GET["num_cheque_d"];$num_cheque_h=$_GET["num_cheque_h"];
$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$fecha_anu_d=$_GET["fecha_anulado_d"];$fecha_anu_h=$_GET["fecha_anulado_h"];$ordenado=$_GET["ordenado"];$imprimir=$_GET["imprimir"];$Sql="";$date = date("d-m-Y");$hora = date("h:i:s a");
$tipo_rep=$_GET["tipo_rep"]; $date = date("d-m-Y");$hora = date("h:i:s a");
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}$fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
$fecha_a_d=formato_aaaammdd($fecha_anu_d); $fecha_a_h=formato_aaaammdd($fecha_anu_h);
$criterio1="Fecha Anulado Desde: ".$fecha_anu_d." Hasta: ".$fecha_anu_h;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $Nom_Emp=busca_conf();  $php_os=PHP_OS; if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
      if ($imprimir=='N'){ $nomb_rpt="Rpt_Cheques_Anulados.xml";} else { $nomb_rpt="Rpt_Cheques_Anulados_Detallado.xml";} 
      $sSQL = "SELECT BAN006.Cod_Banco, BAN002.Nombre_Banco, BAN002.Nro_Cuenta, BAN006.Num_Cheque, BAN006.Fecha, BAN006.Ced_Rif, PRE099.Nombre,
                BAN006.Nro_Orden_Pago, BAN006.Concepto, BAN006.Anulado, BAN006.Fecha_Anulado, BAN006.Entregado, BAN006.Fecha_Entregado, BAN006.Ced_Rif_Recib,
                BAN006.Nombre_Recib, BAN006.Monto_Cheque,BAN006.Concepto,BAN004.Descrip_Mov_Libro AS Des_Anulado, to_char(BAN006.Fecha,'DD/MM/YYYY') as fechae, to_char(BAN006.Fecha_Anulado,'DD/MM/YYYY') as fechaa
                FROM BAN002, BAN006, PRE099,BAN004
                WHERE  (BAN006.Cod_Banco = BAN004.Cod_Banco) AND (BAN006.Num_Cheque = BAN004.Referencia) AND (BAN004.Tipo_Mov_Libro='ANU') AND
                (BAN006.Cod_Banco = BAN002.Cod_Banco) AND (BAN006.Ced_Rif = PRE099.Ced_Rif) AND (BAN006.Anulado='S') AND
                BAN006.Cod_Banco>='".$cod_banco_d."' AND BAN006.Cod_Banco<='".$cod_banco_h."'  AND  BAN006.Num_Cheque>='".$num_cheque_d."' AND BAN006.Num_Cheque<='".$num_cheque_h."' AND
                BAN006.Ced_Rif>='".$cedula_d."' AND BAN006.Ced_Rif<='".$cedula_h."' AND  BAN006.Fecha>='".$fecha_desde."' AND BAN006.Fecha<='".$fecha_hasta."'  AND
                BAN006.Fecha_Anulado>='".$fecha_a_d."' AND BAN006.Fecha_Anulado<='".$fecha_a_h."' ORDER BY ".$ordenado."";	
	if($tipo_rep=="HTML"){ 	include ("../../class/phpreports/PHPReportMaker.php");		
             $oRpt = new PHPReportMaker();
             $oRpt->setXML($nomb_rpt);
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
	if($tipo_rep=="PDF"){   
	      require('../../class/fpdf/fpdf.php');
		  class PDF extends FPDF{
			function Header(){ global $tam_logo;  global $criterio1;
				$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
				$this->SetFont('Arial','B',15);
				$this->Cell(50);
				$this->Cell(100,10,'REPORTE CHEQUES ANULADOS',1,0,'C');
				$this->Ln(20);
				$this->SetFont('Arial','B',7);
				$this->Cell(100,5,$criterio1,0,1,'L');				
				$this->Cell(14,3,'NUMERO','RLT',0);
				$this->Cell(16,3,'','LT',0,'L');
				$this->Cell(59,3,'','LT',0,'L');
				$this->Cell(11,3,'','LT',0,'C');
				$this->Cell(50,3,'','LT',0,'L');	
				$this->Cell(15,3,'FECHA','LT',0,'C');
				$this->Cell(15,3,'FECHA','LT',0,'C');
				$this->Cell(20,3,'MONTO','RLT',1,'C');
				$this->Cell(14,3,'CHEQUE','LB',0);
				$this->Cell(16,3,'CED/RIF','LB',0,'L');
				$this->Cell(59,3,'NOMBRE','LB',0,'L');
				$this->Cell(11,3,'CODIGO','LB',0,'C');
				$this->Cell(50,3,'NOMBRE DEL BANCO','LB',0,'L');	
				$this->Cell(15,3,' EMISION','LB',0,'C');
				$this->Cell(15,3,'ANULADO','LB',0,'C');
				$this->Cell(20,3,'CHEQUE','RLB',1,'C');

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
		  $i=0;  $total=0; $cantidad=0;		  $res=pg_query($sSQL);
		  while($registro=pg_fetch_array($res)){ $i=$i+1;  
		       $num_cheque=$registro["num_cheque"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"];  
			   $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $fechae=$registro["fechae"]; $fechaa=$registro["fechaa"];
			   $monto_cheque=$registro["monto_cheque"]; $entregado=$registro["entregado"]; $concepto=$registro["concepto"]; $des_anulado=$registro["des_anulado"];
		       if($entregado=="S"){$entregado="ENTREGADO";}else{if($entregado=="N"){$entregado="CAJA";}else{if($entregado=="U"){$entregado="UNIDAD";}else{$entregado="PROCESO";}}} 
			   $total=$total+$monto_cheque; $monto_cheque=formato_monto($monto_cheque);  $cantidad=$cantidad+1;	
			   if($php_os=="WINNT"){$nombre=$registro["nombre"]; }   else{$nombre_banco=utf8_decode($nombre_banco); $nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto); $des_anulado=utf8_decode($des_anulado);}		   
			   $pdf->Cell(12,3,$num_cheque,0,0); 
			   $pdf->Cell(18,3,$ced_rif,0,0,'L');				   
			   $x=$pdf->GetX();   $y=$pdf->GetY(); $n=60; 	   
		   	   $pdf->SetXY($x+$n,$y);
			   $pdf->Cell(10,3,$cod_banco,0,0,'C');
			   $pdf->Cell(50,3,$nombre_banco,0,0,'L');
			   $pdf->Cell(15,3,$fechae,0,0,'C');
			   $pdf->Cell(15,3,$fechaa,0,0,'C');
               $pdf->Cell(20,3,$monto_cheque,0,1,'R'); 
               $pdf->SetXY($x,$y);
		       $pdf->MultiCell($n,3,$nombre,0); 
			   if ($imprimir=='S'){ $pdf->SetFont('Arial','',5);
			      $pdf->Cell(30,3,'CONCEPTO: ',0,0,'R');	
				  $pdf->MultiCell(170,3,$concepto,0);
				  $pdf->Cell(30,3,'MOTIVO ANULACION: ',0,0,'R');	
				  $pdf->MultiCell(170,3,$des_anulado,0);
				  $pdf->Ln(3);
				  $pdf->SetFont('Arial','',6);
			   }
			} $total=formato_monto($total); 
			$pdf->SetFont('Arial','B',7);
			$x=$pdf->GetX();  $y=$pdf->GetY();
			$pdf->Cell(180,2,'',0,0);
			$pdf->Cell(20,2,'============',0,1,'R');
			$pdf->Cell(30,3,'Cantidad de Cheques :',0,0,'L');
			$pdf->Cell(110,3,$cantidad,0,0,'L');
			$pdf->Cell(40,5,'Total :',0,0,'R');
			$pdf->Cell(20,5,$total,0,0,'R'); 	 
			$pdf->Output();  
		}
    if($tipo_rep=="EXCEL"){	
		  header("Content-type: application/vnd.ms-excel");
		  header("Content-Disposition: attachment; filename=Rpt_Cheques_Anulados.xls");
		  ?>
		   <table border="0" cellspacing='0' cellpadding='0' align="left">
			 <tr height="20">
				<td width="100" align="left" ><strong></strong></td>
				<td width="100" align="left" ><strong></strong></td>
				<td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE CHEQUES ANULADOS</strong></font></td>
			 </tr>

			 <tr height="20">
			   <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>Cheque Nro</strong></td>
			   <td width="100" align="left" bgcolor="#99CCFF"><strong>Ced/Rif</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>Cod/Banco</strong></td>
			   <td width="400" align="left" bgcolor="#99CCFF"><strong>Nombre Banco</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF"><strong>Fecha Emision</strong></td>
			   <td width="100" align="center" bgcolor="#99CCFF" ><strong>Fecha Anulado</strong></td>
			   <td width="100" align="right" bgcolor="#99CCFF" ><strong>Monto Cheque</strong></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		           $num_cheque=$registro["num_cheque"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"];  
			   $nombre_banco=$registro["nombre_banco"]; $nro_cuenta=$registro["nro_cuenta"]; $fechae=$registro["fechae"]; $fechaa=$registro["fechaa"];
			   $monto_cheque=$registro["monto_cheque"]; $entregado=$registro["entregado"];
		           if($entregado=="S"){$entregado="ENTREGADO";}else{if($entregado=="N"){$entregado="CAJA";}else{if($entregado=="U"){$entregado="UNIDAD";}else{$entregado="PROCESO";}}} 
			   $total=$total+$monto_cheque; $monto_cheque=formato_monto($monto_cheque);  $cantidad=$cantidad+1;	 
		           $nombre=conv_cadenas($nombre,0);  $nombre_banco=conv_cadenas($nombre_banco,0);
	?>	   
	<tr>
           <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $num_cheque; ?></td>
           <td width="100" align="left"><? echo $ced_rif; ?></td>
           <td width="400" align="justify"><? echo $nombre; ?></td>
           <td width="100" align="center">'<? echo $cod_banco; ?></td>
           <td width="400" align="justify"><? echo $nombre_banco; ?></td>
           <td width="100" align="center"><? echo $fechae; ?></td>
           <td width="100" align="center"><? echo $fechaa; ?></td>
           <td width="100" align="right"><? echo $monto_cheque; ?></td>
         </tr>
	<? }  $total=formato_monto($total);  ?>
	   <tr>
        <td>&nbsp;</td>
      </tr>
	  <tr>
                <td width="100" align="right"></td>
		<td width="100" align="right"></td>
		<td width="400" align="left"><strong>Cantidad de Cheques: <? echo $cantidad; ?></strong></td>
		<td width="100" align="right"></td>	
		<td width="400" align="right"></td>
		<td width="100" align="right"></td>
		<td width="100" align="right"><strong>TOTAL :</strong></td>
		<td width="100" align="right"><strong><? echo $total; ?></strong></td>
      </tr>
      
	  </table><?
	}

}
?>

