<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); error_reporting(E_ALL ^ E_NOTICE);
$periodod=$_GET["periodod"];$mes=$_GET["mes"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");
$tipo_rpt=$_GET["tipo_rpt"]; $tipo_comp=$_GET["tipo_comp"];
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}$fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
$criterio1="Periodo Fiscal:   "."Año : ".$periodod."  "."Mes :  ".$mes; 
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else{ $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }  
   $criterio_s=" BAN027.ano_fiscal='".$periodod."' AND  BAN027.Mes_Fiscal ='".$mes."' AND BAN027.fecha_emision>='".$fecha_desde."' AND BAN027.fecha_emision<='".$fecha_hasta."'";
   if($tipo_comp==="ORDEN CANCELADA") { $criterio_s=" BAN027.ano_fiscal='".$periodod."' AND BAN027.fecha_emision<='".$fecha_hasta."' and BAN027.monto_iva_retenido<>0 and BAN027.tipo_mov='O/P' and BAN027.referencia in (select nro_orden  from pag001 where status='I' and fecha_cheque>='".$fecha_desde."' and fecha_cheque<='".$fecha_hasta."') ";}
   if($tipo_comp==="CHEQUE ENTREGADO"){ $criterio_s=" BAN027.ano_fiscal='".$periodod."' AND BAN027.fecha_emision<='".$fecha_hasta."' and BAN027.monto_iva_retenido<>0 and BAN027.tipo_mov='O/P' and ((BAN027.referencia='' and BAN027.fecha_emision>='".$fecha_desde."' AND BAN027.fecha_emision<='".$fecha_hasta."') OR (BAN027.referencia in (select nro_orden  from pag001 where Status='I' and text(cod_banco)||text(nro_cheque) in (select text(cod_banco)||text(num_cheque) from ban006 where entregado='S' and fecha_entregado>='".$fecha_desde."' and fecha_entregado<='".$fecha_hasta."') )) )"; }
   $sSQL = "SELECT BAN027.ano_fiscal, BAN027.Mes_Fiscal, BAN027.Nro_Comprobante, BAN027.Nro_Operacion, BAN027.Ced_Rif, BAN027.fecha_emision, BAN027.Tipo_Operacion, BAN027.Tipo_Documento, BAN027.Fecha_Documento,
                BAN027.Nro_Documento, BAN027.Nro_Con_Documento, BAN027.Nro_Doc_Afectado, BAN027.Tipo_Transaccion, BAN027.Monto_Documento, BAN027.Monto_Exento_IVA, BAN027.Base_Imponible, BAN027.Tasa_IVA, BAN027.Monto_IVA,
                BAN027.monto_iva_retenido, BAN027.Cod_Banco, BAN027.tipo_mov, BAN027.Referencia, BAN027.Inf_Usuario, to_char(BAN027.fecha_emision,'DD/MM/YYYY') as fechae,  to_char(BAN027.Fecha_Documento,'DD/MM/YYYY') as fechad, PRE099.Nombre, PRE099.Campo_str2
                FROM BAN027, PRE099  WHERE BAN027.Ced_Rif = PRE099.Ced_Rif AND  ".$criterio_s."  ORDER BY BAN027.ano_fiscal, BAN027.Mes_Fiscal, BAN027.Nro_Comprobante";

   if($tipo_rpt=="HTML"){	  include ("../../class/phpreports/PHPReportMaker.php");
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Relacion_Comprobante_IVA.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $ano_fiscal_grupo=""; 	
      if($php_os=="WINNT"){$criterio1=$criterio1;}else{$criterio1=utf8_decode($criterio1);}
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){ global $criterio1; global $tam_logo; global $ano_fiscal_grupo;  global $registro;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(130,10,'RELACION COMPROBANTE IVA',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(130,5,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',5);
			$this->Cell(195,4,'',1,0,'L');
			$this->Cell(47,4,'COMPRAS INTERNAS O IMPORTANCIONES',1,0,'C');
			$this->Cell(18,4,'',1,1,'R');
			$this->SetFont('Arial','B',5);
			
			$this->Cell(7,3,'NRO.','RLT',0,'C');
			$this->Cell(16,3,'NUMERO','RT',0,'C');
			$this->Cell(11,3,'FECHA','RT',0,'C');
			$this->Cell(5,3,'','RT',0,'C');
			$this->Cell(20,3,'NUMERO','RT',0,'C');
			$this->Cell(15,3,'NUMERO','RT',0,'C');
			$this->Cell(13,3,'','RT',0,'C');
			$this->Cell(40,3,'','RT',0,'C');
			$this->Cell(10,3,'TIPO','RT',0,'C');
			$this->Cell(19,3,'NRO FACTURA','RT',0,'C');
			$this->Cell(19,3,'TOTAL COMPRA','RT',0,'C');
			$this->Cell(20,3,'COMPRA SIN ','RT',0,'C');
			$this->Cell(20,3,'BASE','RT',0,'C');
			$this->Cell(9,3,'','RT',0,'C');
			$this->Cell(18,3,'IMPUESTO','RT',0,'C');
			$this->Cell(18,3,'IVA','RT',1,'C');
			
			$this->Cell(7,3,'OPER','LB',0,'C');
			$this->Cell(16,3,'COMPROBANTE','LB',0,'C');
			$this->Cell(11,3,'DOCUMENT','LB',0,'C');
			$this->Cell(5,3,'TIPO','LB',0,'C');
			$this->Cell(20,3,'DOCUMENTO','LB',0,'C');
			$this->Cell(15,3,'CONTROL','LB',0,'C');
			$this->Cell(13,3,'RIF','LB',0,'C');
			$this->Cell(40,3,'NOMBRE','LB',0,'C');
			$this->Cell(10,3,'TRANSF','LB',0,'C');
			$this->Cell(19,3,'AFECTADA','LB',0,'C');
			$this->Cell(19,3,'INCLUYENDO IVA','LB',0,'C');
			$this->Cell(20,3,'DERECHO A IVA','LB',0,'C');
			$this->Cell(20,3,'IMPONIBLE','LB',0,'C');
			$this->Cell(9,3,'% ALIC.','LB',0,'C');
			$this->Cell(18,3,'IVA','LB',0,'C');
			$this->Cell(18,3,' RETENIDO','LRB',1,'C');

		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',3);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',5);
	  $i=0;  $sub_total1=""; $sub_total2=""; $sub_total3=""; $sub_total4=""; $sub_total5=""; $prev_ano_fiscal=""; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $ano_fiscal=$registro["ano_fiscal"]; 	 $ano_fiscal_grupo=$ano_fiscal; 
		   $nro_comprobante=$registro["nro_comprobante"]; $nro_operacion=$registro["nro_operacion"]; $fecha_emision=$registro["fecha_emision"]; 
           $fecha_documento=$registro["fecha_documento"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $nro_con_documento=$registro["nro_con_documento"]; 
           $tipo_mov=$registro["tipo_mov"]; $referencia=$registro["referencia"]; $tipo_documento=$registro["tipo_documento"]; $nro_documento=$registro["nro_documento"]; 
           $nro_doc_afectado=$registro["nro_doc_afectado"]; $tipo_transaccion=$registro["tipo_transaccion"]; $ano_fiscal=$registro["ano_fiscal"]; $mes_fiscal=$registro["mes_fiscal"];
           $monto_documento=$registro["monto_documento"]; $monto_exento_iva=$registro["monto_exento_iva"]; $base_imponible=$registro["base_imponible"]; 
           $tasa_iva=$registro["tasa_iva"]; $monto_iva=$registro["monto_iva"];$monto_iva_retenido=$registro["monto_iva_retenido"];	
	       $sub_total1=$sub_total1+$monto_documento; $sub_total2=$sub_total2+$monto_exento_iva; $sub_total3=$sub_total3+$base_imponible; $sub_total4=$sub_total4+$monto_iva;  $sub_total5=$sub_total5+$monto_iva_retenido;
           $monto_documento=formato_monto($monto_documento); $monto_exento_iva=formato_monto($monto_exento_iva);$base_imponible=formato_monto($base_imponible);
           $tasa_iva=formato_monto($tasa_iva);$monto_iva=formato_monto ($monto_iva);$monto_iva_retenido=formato_monto($monto_iva_retenido); $fecha_emision=formato_ddmmaaaa($fecha_emision);
           $fecha_documento=formato_ddmmaaaa($fecha_documento); if($php_os=="WINNT"){$nombre=$registro["nombre"];}else{$nombre=utf8_decode($registro["nombre"]);}
		   $h=3; if(strlen($nombre)>=45){$h=6;}
		   $pdf->Cell(7,$h,$nro_operacion,1,0,'C'); 
		   $pdf->Cell(16,$h,$ano_fiscal.$mes_fiscal.$nro_comprobante,1,0,'L'); 
		   $pdf->Cell(11,$h,$fecha_documento,1,0,'C'); 
		   $pdf->Cell(5,$h,$tipo_documento,1,0,'C'); 
		   $pdf->Cell(20,$h,$nro_documento,1,0,'C'); 
		   $pdf->Cell(15,$h,$nro_con_documento,1,0,'C'); 
		   $pdf->Cell(13,$h,$ced_rif,1,0,'L');   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=40;
		   $pdf->SetXY($x+$w,$y);
		   $pdf->Cell(10,$h,$tipo_transaccion,1,0,'C');	
		   $pdf->Cell(19,$h,$nro_doc_afectado,1,0,'L');	   
		   $pdf->Cell(19,$h,$monto_documento,1,0,'R'); 
           $pdf->Cell(20,$h,$monto_exento_iva,1,0,'R'); 		   
		   $pdf->Cell(20,$h,$base_imponible,1,0,'R'); 
		   $pdf->Cell(9,$h,$tasa_iva,1,0,'R'); 
		   $pdf->Cell(18,$h,$monto_iva,1,0,'R'); 
		   $pdf->Cell(18,$h,$monto_iva_retenido,1,1,'R'); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($w,3,$nombre,1);  
			
		} 
		$pdf->SetFont('Arial','B',6);
	    if(($sub_total1>0)or($sub_total2>0)or($sub_total3>0)or($sub_total4>0)or($sub_total5>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2); $sub_total3=formato_monto($sub_total3); $sub_total4=formato_monto($sub_total4); $sub_total5=formato_monto($sub_total5);							    
			
			$pdf->Cell(156,5,'',1,0,'R'); 
			$pdf->Cell(19,5,$sub_total1,1,0,'R'); 
			$pdf->Cell(20,5,$sub_total2,1,0,'R'); 
			$pdf->Cell(20,5,$sub_total3,1,0,'R'); 
			$pdf->Cell(9,5,'',1,0,'R'); 
			$pdf->Cell(18,5,$sub_total4,1,0,'R'); 
			$pdf->Cell(18,5,$sub_total5,1,1,'R'); 
		}			 
		$pdf->Output();     
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Relacion_Comprobantes_IVA.xls");	
	
	?>
       <table border="1" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="70" align="left" ><strong></strong></td>
			<td width="130" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
            <td width="300" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE RELACION BENEFICIARIOS/RETENCION</strong></font></td>
		 </tr>
	     <tr height="20">
			<td width="70" align="left" ><strong></strong></td>
			<td width="130" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="300" align="center" > <font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
		</tr>
         <tr height="20">
           <td width="70" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>NRO OP</strong></td>
           <td width="130" align="left" bgcolor="#99CCFF"><strong>N° COMPROBANTE</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>FECHA DOC</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>TIPO DE</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>NRO DOCUMENTO</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>NRO CONTROL DOCUMENTO</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>RIF</strong></td>
           <td width="300" align="left" bgcolor="#99CCFF"><strong>NOMBRE</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>TIPO DE TRANSF</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>N° FACTURA AFECTADA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>TOTAL COMPRAS INCLUYENDO IVA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>COMPRAS SIN DERECHO A CREDITO IVA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>BASE IMPONIBLE</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>% ALIC. </strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>IMPUESTO IVA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>IVA RETENIDO</strong></font></td>
         </tr>
     <?
	  
	  $i=0;  $sub_total1=""; $sub_total2=""; $sub_total3=""; $sub_total4=""; $sub_total5=""; $prev_ano_fiscal=""; 
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $ano_fiscal=$registro["ano_fiscal"];   $ano_fiscal_grupo=$ano_fiscal;  $nombre=conv_cadenas($nombre,0);   
			$nro_comprobante=$registro["nro_comprobante"]; $nro_operacion=$registro["nro_operacion"]; $fecha_emision=$registro["fecha_emision"]; 
            $fecha_documento=$registro["fecha_documento"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $nro_con_documento=$registro["nro_con_documento"]; 
            $tipo_mov=$registro["tipo_mov"]; $referencia=$registro["referencia"]; $tipo_documento=$registro["tipo_documento"]; $nro_documento=$registro["nro_documento"]; 
            $nro_doc_afectado=$registro["nro_doc_afectado"]; $tipo_transaccion=$registro["tipo_transaccion"];$ano_fiscal=$registro["ano_fiscal"]; $mes_fiscal=$registro["mes_fiscal"];
            $monto_documento=$registro["monto_documento"]; $monto_exento_iva=$registro["monto_exento_iva"]; $base_imponible=$registro["base_imponible"]; 
            $tasa_iva=$registro["tasa_iva"]; $monto_iva=$registro["monto_iva"];$monto_iva_retenido=$registro["monto_iva_retenido"];	
	        $sub_total1=$sub_total1+$monto_documento; $sub_total2=$sub_total2+$monto_exento_iva; $sub_total3=$sub_total3+$base_imponible; $sub_total4=$sub_total4+$monto_iva; 
		    $sub_total5=$sub_total5+$monto_iva_retenido;
            $monto_documento=formato_monto($monto_documento); $monto_exento_iva=formato_monto($monto_exento_iva);$base_imponible=formato_monto($base_imponible);
            $tasa_iva=formato_monto($tasa_iva);$monto_iva=formato_monto ($monto_iva);$monto_iva_retenido=formato_monto($monto_iva_retenido); $fecha_emision=formato_ddmmaaaa($fecha_emision);
            $fecha_documento=formato_ddmmaaaa($fecha_documento); $nombre=conv_cadenas($nombre,0);  
	    ?>	   
		   <tr>
                <td width="70" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_operacion; ?></td>
               <td width="130" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $ano_fiscal.$mes_fiscal.$nro_comprobante; ?></td>
           		<td width="100" align="center"><? echo $fecha_documento; ?></td>
           		<td width="100" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $tipo_documento; ?></td>
           		<td width="100" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $nro_documento; ?></td>
           		<td width="100" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $nro_con_documento; ?></td>
           		<td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $ced_rif; ?></td>
           		<td width="300" align="left"><? echo $nombre; ?></td>
           		<td width="100" align="center"><? echo $tipo_transaccion; ?></td>
           		<td width="100" align="left"><? echo $nro_doc_afectado; ?></td>
           		<td width="100" align="right"><? echo $monto_documento; ?></td>
           		<td width="100" align="right"><? echo $monto_exento_iva; ?></td>
           		<td width="100" align="right"><? echo $base_imponible; ?></td>
           		<td width="100" align="right"><? echo $tasa_iva; ?></td>
           		<td width="100" align="right"><? echo $monto_iva; ?></td>
           		<td width="100" align="right"><? echo $monto_iva_retenido; ?></td>
            </tr>
	    <? 
	    }  
       	?>	 				 
             <tr>
			      <td width="70" align="left"></td>
				  <td width="130" align="left"></td>
			      <td width="100" align="left"></td>
			      <td width="100" align="left"></td>
				  <td width="100" align="left"></td>
			      <td width="100" align="left"></td>
			      <td width="100" align="left"></td>
				  <td width="300" align="left"></td>
			      <td width="100" align="left"></td>
				  <td width="100" align="left"></td>
			      <td width="100" align="right"><? echo $sub_total1; ?></td>
			      <td width="100" align="right"><? echo $sub_total2; ?></td>
			      <td width="100" align="right"><? echo $sub_total3; ?></td>
			      <td width="100" align="right"></td>
			      <td width="100" align="right"><? echo $sub_total4; ?></td>
			      <td width="100" align="right"><? echo $sub_total5; ?></td>
			</tr>	
		</table><?
    }		  
}
?>
