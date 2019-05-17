<? error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); 
$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$comprobante_d=$_GET["comprobante_d"];$comprobante_h=$_GET["comprobante_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$agrupado=$_GET["agrupado"];  $tipo_comp=$_GET["tipo_comp"]; $tipo_rpt=$_GET["tipo_rpt"];
$criterio1="Fecha Desde: ".$fecha_d." Al: ".$fecha_h; $criterio2="";   $Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");    $php_os=PHP_OS; 
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}  $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}  else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
    $criterio_s="  BAN027.fecha_emision>='".$fecha_desde."' AND BAN027.fecha_emision<='".$fecha_hasta."'";
    if($tipo_comp==="ORDEN CANCELADA") { $criterio_s="  BAN027.fecha_emision<='".$fecha_hasta."' and BAN027.monto_iva_retenido<>0 and BAN027.tipo_mov='O/P' and BAN027.referencia in (select nro_orden  from pag001 where status='I' and fecha_cheque>='".$fecha_desde."' and fecha_cheque<='".$fecha_hasta."') ";}
    if($tipo_comp==="CHEQUE ENTREGADO"){ $criterio_s="  BAN027.fecha_emision<='".$fecha_hasta."' and BAN027.monto_iva_retenido<>0 and BAN027.tipo_mov='O/P' and ((BAN027.referencia='' and BAN027.fecha_emision>='".$fecha_desde."' AND BAN027.fecha_emision<='".$fecha_hasta."') OR (BAN027.referencia in (select nro_orden  from pag001 where Status='I' and text(cod_banco)||text(nro_cheque) in (select text(cod_banco)||text(num_cheque) from ban006 where entregado='S' and fecha_entregado>='".$fecha_desde."' and fecha_entregado<='".$fecha_hasta."') )) )"; }
    if($agrupado=="SI"){
	$sSQL = "SELECT BAN027.Ano_Fiscal, BAN027.Mes_Fiscal, BAN027.Nro_Comprobante, BAN027.Ced_Rif, PRE099.Nombre, BAN027.Referencia, BAN027.Fecha_Emision, to_char(BAN027.Fecha_Emision,'DD/MM/YYYY') as fechae,  
				sum(BAN027.monto_documento) as monto_documento, sum(BAN027.monto_exento_iva) as monto_exento_iva, sum(BAN027.base_imponible) as base_imponible,  sum(BAN027.monto_IVA) as monto_iva, sum(BAN027.monto_IVA_Retenido) as monto_iva_retenido				 
                FROM BAN027, PRE099 WHERE BAN027.Ced_Rif = PRE099.Ced_Rif AND  BAN027.Nro_Comprobante>='".$comprobante_d."' AND BAN027.Nro_Comprobante<='".$comprobante_h."' AND  BAN027.Ced_Rif>='".$cedula_d."' AND BAN027.Ced_Rif<='".$cedula_h."' AND  ".$criterio_s."
				Group by BAN027.Ano_Fiscal, BAN027.Mes_Fiscal, BAN027.Nro_Comprobante, BAN027.Ced_Rif, PRE099.Nombre, BAN027.Referencia, BAN027.Fecha_Emision, fechae
                ORDER BY BAN027.Ano_Fiscal, BAN027.Mes_Fiscal, BAN027.Nro_Comprobante";
    }else{$sSQL = "SELECT BAN027.Ano_Fiscal, BAN027.Mes_Fiscal, BAN027.Nro_Comprobante, BAN027.Nro_Operacion, BAN027.Ced_Rif, BAN027.Fecha_Emision, BAN027.Tipo_Operacion, BAN027.Tipo_Documento, BAN027.Fecha_Documento, BAN027.Nro_Documento,
                BAN027.Nro_Con_Documento, BAN027.Nro_Doc_Afectado, BAN027.Tipo_Transaccion, BAN027.monto_documento, BAN027.monto_exento_iva, BAN027.base_imponible, BAN027.Tasa_IVA, BAN027.monto_IVA, BAN027.monto_IVA_Retenido,
                BAN027.Cod_Banco, BAN027.Tipo_Mov, BAN027.Referencia, BAN027.Inf_Usuario, PRE099.Nombre,  
				to_char(BAN027.Fecha_Emision,'DD/MM/YYYY') as fechae,  to_char(BAN027.Fecha_Documento,'DD/MM/YYYY') as fechad 
                FROM BAN027, PRE099 WHERE BAN027.Ced_Rif = PRE099.Ced_Rif AND  BAN027.Nro_Comprobante>='".$comprobante_d."' AND BAN027.Nro_Comprobante<='".$comprobante_h."' AND BAN027.Ced_Rif>='".$cedula_d."' AND BAN027.Ced_Rif<='".$cedula_h."' AND  ".$criterio_s."
                ORDER BY BAN027.Ano_Fiscal, BAN027.Mes_Fiscal, BAN027.Nro_Comprobante, BAN027.Nro_Operacion"; }
	  
    if($tipo_rpt=="HTML"){	  include ("../../class/phpreports/PHPReportMaker.php");
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Listado_Ret_IVA.xml");
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
		function Header(){ global $tam_logo; global $criterio1;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(100,10,'LISTADO DE RETENCION IVA',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',7);
			$this->Cell(13,3,'COMPRO-','RLT',0);
			$this->Cell(13,3,'NUMERO','RT',0);
			$this->Cell(15,3,'FECHA','RT',0);
			$this->Cell(16,3,'','RT',0);
			$this->Cell(55,3,'','RT',0);
			$this->Cell(20,3,'MONTO CON','RT',0,'C');
			$this->Cell(18,3,'MONTO','RT',0,'C');
			$this->Cell(20,3,'BASE','RT',0,'C');
			$this->Cell(15,3,'IMPUESTO','RT',0,'C');
			$this->Cell(15,3,'IVA','RT',1,'C');
			
			$this->Cell(13,4,'BANTE','LB',0);
			$this->Cell(13,4,'ORDEN','LB',0);
			$this->Cell(15,4,'EMISION','LB',0);
			$this->Cell(16,4,'RIF','LB',0);
			$this->Cell(55,4,'NOMBRE DEL SUJETO RETENCION','LB',0);
			$this->Cell(20,4,'IVA','LB',0,'C');
			$this->Cell(18,4,'EXENTO','LB',0,'C');
			$this->Cell(20,4,'IMPONIBLE','LB',0,'C');
			$this->Cell(15,4,'IVA','LB',0,'C');
			$this->Cell(15,4,'RETENIDO','LRB',1,'C');
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
	  $i=0;  $total=0; $totaln=0; $totalr=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_comprobante=$registro["nro_comprobante"]; $fechae=$registro["fechae"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; 
		   $fecha_emision=formato_ddmmaaaa($fecha_emision); $monto_documento=$registro["monto_documento"]; $monto_exento_iva=$registro["monto_exento_iva"]; 
		   $base_imponible=$registro["base_imponible"]; $monto_iva=$registro["monto_iva"];$monto_iva_retenido=$registro["monto_iva_retenido"]; $referencia=$registro["referencia"];
		   $monto_documento=formato_monto($monto_documento); $monto_exento_iva=formato_monto($monto_exento_iva);$base_imponible=formato_monto($base_imponible);
		   $monto_iva=formato_monto ($monto_iva);$monto_iva_retenido=formato_monto($monto_iva_retenido); 
           $totald=$totald+$registro["monto_documento"]; $totale=$totale+$registro["monto_exento_iva"]; $totalb=$totalb+$registro["base_imponible"];  $totali=$totali+$registro["monto_iva"];
           $totalir=$totalir+$registro["monto_iva_retenido"];  if($php_os=="WINNT"){$nombre=$registro["nombre"];}else{$nombre=utf8_decode($registro["nombre"]);}
		   $pdf->Cell(13,3,$nro_comprobante,0,0); 
		   $pdf->Cell(13,3,$referencia,0,0); 
		   $pdf->Cell(14,3,$fechae,0,0); 
		   $pdf->Cell(17,3,$ced_rif,0,0);  		   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $n=54;		   
		   $pdf->SetXY($x+$n,$y);
		   $pdf->Cell(20,3,$monto_documento,0,0,'R'); 
           $pdf->Cell(18,3,$monto_exento_iva,0,0,'R'); 		   
		   $pdf->Cell(20,3,$base_imponible,0,0,'R'); 
		   $pdf->Cell(15,3,$monto_iva,0,0,'R'); 
		   $pdf->Cell(15,3,$monto_iva_retenido,0,1,'R'); 
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($n,3,$nombre,0); 
		} $totald=formato_monto($totald); $totale=formato_monto($totale); $totalb=formato_monto($totalb); $totali=formato_monto($totali); $totalir=formato_monto($totalir); 
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(111,2,'',0,0,'R');
		$pdf->Cell(20,2,'=============',0,0,'R');
		$pdf->Cell(18,2,'============',0,0,'R');
		$pdf->Cell(20,2,'=============',0,0,'R');
		$pdf->Cell(15,2,'==========',0,0,'R');
		$pdf->Cell(15,2,'==========',0,1,'R');
		$pdf->Cell(111,5,'Total : ',0,0,'R');
		$pdf->Cell(20,5,$totald,0,0,'R'); 
		$pdf->Cell(18,5,$totale,0,0,'R'); 
		$pdf->Cell(20,5,$totalb,0,0,'R'); 
		$pdf->Cell(15,5,$totali,0,0,'R'); 
		$pdf->Cell(15,5,$totalir,0,0,'R'); 		 
		$pdf->Output();   
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Listado_Retencion_IVA.xls");		
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="120" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO DE RETENCION IVA</strong></font></td>
		 </tr>
		  <tr height="20">
		    <td width="120" align="left" ><strong></strong></td>
		    <td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
		    <td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
	     </tr>
         <tr height="20">
           <td width="120" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>COMPROBANTE</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>FECHA EMISION</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>ORDEN</strong></td>
		   <td width="100" align="left" bgcolor="#99CCFF"><strong>RIF</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>NOMBRE DEL SUJETO DE RETENCION</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>MONTO CON IVA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>MONTO CON EXENTO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>BASE IMPONIBLE</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>IMPUESTO IVA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>IVA RETENIDO</strong></font></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $totaln=0; $totalr=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_comprobante=$registro["nro_comprobante"]; $fechae=$registro["fechae"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $referencia=$registro["referencia"];
           $fecha_emision=formato_ddmmaaaa($fecha_emision); $monto_documento=$registro["monto_documento"]; $monto_exento_iva=$registro["monto_exento_iva"]; 
           $base_imponible=$registro["base_imponible"]; $monto_iva=$registro["monto_iva"];$monto_iva_retenido=$registro["monto_iva_retenido"];
           $monto_documento=formato_monto($monto_documento); $monto_exento_iva=formato_monto($monto_exento_iva);$base_imponible=formato_monto($base_imponible);
           $monto_iva=formato_monto ($monto_iva);$monto_iva_retenido=formato_monto($monto_iva_retenido); 
		   $totald=$totald+$registro["monto_documento"]; $totale=$totale+$registro["monto_exento_iva"]; $totalb=$totalb+$registro["base_imponible"];  $totali=$totali+$registro["monto_iva"];
            $totalir=$totalir+$registro["monto_iva_retenido"]; $nombre=conv_cadenas($nombre,0);  
	?>	   
        <tr>
           <td width="120" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_comprobante; ?></td>
           <td width="100" align="left"><? echo $fechae; ?></td>
		   <td width="100" align="left"><? echo $referencia; ?></td>
           <td width="100" align="left"><? echo $ced_rif; ?></td>
           <td width="400" align="justify"><? echo $nombre; ?></td>
           <td width="100" align="right"><? echo $monto_documento; ?></td>
           <td width="100" align="right"><? echo $monto_exento_iva; ?></td>
           <td width="100" align="right"><? echo $base_imponible; ?></td>
           <td width="100" align="right"><? echo $monto_iva; ?></td>
           <td width="100" align="right"><? echo $monto_iva_retenido; ?></td>
         </tr>
	<? } $totald=formato_monto($totald); $totale=formato_monto($totale); $totalb=formato_monto($totalb); $totali=formato_monto($totali); $totalir=formato_monto($totalir);
        ?>
		<tr> <td>&nbsp;</td>
	   <tr>
        <td width="120"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
		<td width="100" align="left" ><strong></strong></td>
		<td width="100" align="left" ><strong></strong></td>
		<td width="400" align="right"><strong>TOTAL :</strong></td>
		<td width="100" align="right"><strong><? echo $totald; ?></strong></td>
		<td width="100" align="right"><strong><? echo $totale; ?></strong></td>
		<td width="100" align="right"><strong><? echo $totalb; ?></strong></td>
		<td width="100" align="right"><strong><? echo $totali; ?></strong></td>
		<td width="100" align="right"><strong><? echo $totalir; ?></strong></font></td>
      </tr>
  
	  </table><?
	}

   }
?>
