<? error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc");
$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$comprobante_d=$_GET["comprobante_d"];$comprobante_h=$_GET["comprobante_h"];$Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");$tipo_rpt=$_GET["tipo_rpt"];
$criterio1="Fecha Desde: ".$fecha_d." Al: ".$fecha_h; $criterio2="";     $php_os=PHP_OS;    
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}  $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}  else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");     
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else { $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){ $php_os="WINNT";}
    $sSQL = "SELECT BAN027.Ano_Fiscal, BAN027.Mes_Fiscal, BAN027.Nro_Comprobante, BAN027.Nro_Operacion, BAN027.Ced_Rif, BAN027.Fecha_Emision, BAN027.Tipo_Operacion, BAN027.Tipo_Documento,
                BAN027.Fecha_Documento, BAN027.Nro_Documento, BAN027.Nro_Con_Documento, BAN027.Nro_Doc_Afectado, BAN027.Tipo_Transaccion, BAN027.Monto_Documento,
                BAN027.Monto_Exento_IVA, BAN027.Base_Imponible, BAN027.Tasa_IVA, BAN027.Monto_IVA, BAN027.Monto_IVA_Retenido, BAN027.Cod_Banco, BAN027.Tipo_Mov, BAN027.Referencia,
                to_char(BAN027.Fecha_Emision,'DD/MM/YYYY') as fechae,  to_char(BAN027.Fecha_Documento,'DD/MM/YYYY') as fechad,  PRE099.Nombre, PRE099.Campo_str1
                FROM BAN027, PRE099   WHERE BAN027.Ced_Rif = PRE099.Ced_Rif  AND BAN027.Ced_Rif>='".$cedula_d."' AND BAN027.Ced_Rif<='".$cedula_h."' AND
                BAN027.Fecha_Emision>='".$fecha_desde."' AND BAN027.Fecha_Emision<='".$fecha_hasta."' AND BAN027.Nro_Comprobante>='".$comprobante_d."' AND BAN027.Nro_Comprobante<='".$comprobante_h."'
                ORDER BY BAN027.Ano_Fiscal, BAN027.Mes_Fiscal, BAN027.Nro_Comprobante, BAN027.Nro_Operacion";
   if($tipo_rpt=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");  
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Listado_Ret_IVA_Benficiario.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $ced_rif_grupo=""; $nombre_grupo=""; $nro_comprobante_grupo=""; $ano_fiscal_grupo=""; $mes_fiscal_grupo=""; $fecha_emision_grupo="";	
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 	
		function Header(){ global $tam_logo;  global $criterio1; global $ced_rif_grupo; global $nombre_grupo; global $nro_comprobante_grupo; global $ano_fiscal_grupo; global $mes_fiscal_grupo; 
			 global $fecha_emision_grupo; global $registro;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(150,10,'LISTADO DE RETENCION IVA POR BENEFICIARIO',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(140,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',7);
			$this->Cell(11,5,'NRO.OP',1,0);
			$this->Cell(16,5,'FECHA DOC',1,0);
			$this->Cell(11,5,'BANCO',1,0);
			$this->Cell(8,5,'MOV',1,0);
			$this->Cell(20,5,'REFERENCIA',1,0);
			$this->Cell(8,5,'TIPO',1,0);
			$this->Cell(40,5,'NRO. DOCUMENTO',1,0);
			$this->Cell(28,5,'FACTURA AFECTADA',1,0);
			$this->Cell(21,5,'MONTO CON IVA',1,0,'C');
			$this->Cell(21,5,'MONTO/EXENTO',1,0,'C');
			$this->Cell(22,5,'BASE IMPONIBLE',1,0,'C');
			$this->Cell(14,5,'TASA/IVA',1,0,'C');
			$this->Cell(20,5,'IMPUESTO/IVA',1,0,'C');
			$this->Cell(20,5,'IVA RETENIDO',1,1,'C');
            
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',4);
			$this->Cell(130,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(130,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('L', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',8);
	  $i=0;  $totalg1=0; $totalg2=0; $totalg3=0; $totalg4=0; $totalg5=0; $sub_totalb1=""; $sub_totalb2=""; $sub_totalb3=""; $sub_totalb4=""; $sub_totalb5=""; $sub_total1=""; $sub_total2=""; $sub_total3=""; $sub_total4=""; $sub_total5=""; $cantidad=0; 
	  $prev_ced_rif=""; $prev_nro_comprobante="";
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $ced_rif=$registro["ced_rif"];  if($php_os=="WINNT"){$nombre=$registro["nombre"];}else{$nombre=utf8_decode($registro["nombre"]);}
		   $nro_comprobante=$registro["nro_comprobante"]; $ano_fiscal=$registro["ano_fiscal"];  $mes_fiscal=$registro["mes_fiscal"]; $fecha_emision=$registro["fecha_emision"];
		   $ced_rif_grupo=$ced_rif;  $nombre_grupo=$nombre;  $nro_comprobante_grupo=$nro_comprobante;  $ano_fiscal_grupo=$ano_fiscal; $mes_fiscal_grupo=$mes_fiscal; 			       $fecha_emision_grupo=$fecha_emision;
		   if(($prev_nro_comprobante<>$nro_comprobante_grupo)or($prev_ced_rif<>$ced_rif_grupo)){ 
			    $pdf->SetFont('Arial','B',8); 
			    if(($sub_total1<>0)or($sub_total2<>0)or($sub_total3<>0)or($sub_total4<>0)or($sub_total5<>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2); $sub_total3=formato_monto($sub_total3); $sub_total4=formato_monto($sub_total4); $sub_total5=formato_monto($sub_total5);				    
				    $pdf->Cell(142,2,'',0,0);
					$pdf->Cell(21,2,'-------------------',0,0,'R');
					$pdf->Cell(21,2,'-------------------',0,0,'R');
					$pdf->Cell(22,2,'-------------------',0,0,'R');
					$pdf->Cell(14,2,'',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,1,'R');
					$pdf->Cell(142,4,"SUB-TOTAL : ",0,0,'R'); 
					$pdf->Cell(21,4,$sub_total1,0,0,'R'); 
					$pdf->Cell(21,4,$sub_total2,0,0,'R');
					$pdf->Cell(22,4,$sub_total3,0,0,'R');
					$pdf->Cell(14,4,'',0,0,'R');
					$pdf->Cell(20,4,$sub_total4,0,0,'R');
					$pdf->Cell(20,4,$sub_total5,0,1,'R');
					$pdf->Ln(3);
                    if($prev_ced_rif==$ced_rif_grupo){ $fecha_t=formato_ddmmaaaa($fecha_emision_grupo);
					$pdf->Cell(70,4,"Nro Comprobante: ".$ano_fiscal_grupo.$mes_fiscal_grupo.$nro_comprobante_grupo,0,0,'L');
                	$pdf->Cell(50,4,"Fecha Emision: ".$fecha_t,0,1,'L'); 	 }					
				 }else{  }
				 $prev_nro_comprobante=$nro_comprobante_grupo; $sub_total1=0; $sub_total2=0; $sub_total3=0; $sub_total4=0; $sub_total5=0;
			} 
		   if($prev_ced_rif<>$ced_rif_grupo){ 
			     $pdf->SetFont('Arial','B',8); 
			     if(($sub_totalb1>0)or($sub_totalb2>0)or($sub_totalb3>0)or($sub_totalb4>0)or($sub_totalb5>0)){ $sub_totalb1=formato_monto($sub_totalb1); $sub_totalb2=formato_monto($sub_totalb2); $sub_totalb3=formato_monto($sub_totalb3); $sub_totalb4=formato_monto($sub_totalb4); $sub_totalb5=formato_monto($sub_totalb5);						    
				    $pdf->Cell(142,2,'',0,0);
					$pdf->Cell(21,2,'-------------------',0,0,'R');
					$pdf->Cell(21,2,'-------------------',0,0,'R');
					$pdf->Cell(22,2,'-------------------',0,0,'R');
					$pdf->Cell(14,2,'',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,0,'R');
					$pdf->Cell(20,2,'-------------------',0,1,'R');
					$pdf->Cell(142,4,"TOTAL BENEFICIARIO : ",0,0,'R'); 
					$pdf->Cell(21,4,$sub_totalb1,0,0,'R'); 
					$pdf->Cell(21,4,$sub_totalb2,0,0,'R');
					$pdf->Cell(22,4,$sub_totalb3,0,0,'R');
					$pdf->Cell(14,4,'',0,0,'R');
					$pdf->Cell(20,4,$sub_totalb4,0,0,'R');
					$pdf->Cell(20,4,$sub_totalb5,0,1,'R');
					$pdf->Ln(5);	$fecha_t=formato_ddmmaaaa($fecha_emision_grupo);
                    $pdf->Cell(40,4,"CEDULA/RIF: ".$ced_rif_grupo,0,0,'L');
                 	$pdf->Cell(220,4,"NOMBRE: ".$nombre_grupo,0,1,'L');
                    $pdf->Cell(70,4,"Nro Comprobante: ".$ano_fiscal_grupo.$mes_fiscal_grupo.$nro_comprobante_grupo,0,0,'L');
                	$pdf->Cell(50,4,"Fecha Emision: ".$fecha_t,0,1,'L'); 					
				}else{$fecha_t=formato_ddmmaaaa($fecha_emision_grupo);
				    $pdf->Cell(40,4,"CEDULA/RIF: ".$ced_rif_grupo,0,0,'L');
                 	$pdf->Cell(220,4,"NOMBRE: ".$nombre_grupo,0,1,'L');
					$pdf->Cell(70,4,"Nro Comprobante: ".$ano_fiscal_grupo.$mes_fiscal_grupo.$nro_comprobante_grupo,0,0,'L');
                	$pdf->Cell(50,4,"Fecha Emision: ".$fecha_t,0,1,'L'); 	}
				$prev_ced_rif=$ced_rif_grupo; $sub_totalb1=0; $sub_totalb2=0; $sub_totalb3=0; $sub_totalb4=0; $sub_totalb5=0;
			}
		   $nro_comprobante=$registro["nro_comprobante"]; $nro_operacion=$registro["nro_operacion"]; $fecha_emision=$registro["fecha_emision"]; 
           $fecha_documento=$registro["fecha_documento"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"]; 
           $tipo_mov=$registro["tipo_mov"]; $referencia=$registro["referencia"]; $tipo_documento=$registro["tipo_documento"]; $nro_documento=$registro["nro_documento"]; 
           $nro_doc_afectado=$registro["nro_doc_afectado"];  $monto_documento=$registro["monto_documento"]; $monto_exento_iva=$registro["monto_exento_iva"]; 
		   $base_imponible=$registro["base_imponible"]; $tasa_iva=$registro["tasa_iva"]; $monto_iva=$registro["monto_iva"];$monto_iva_retenido=$registro["monto_iva_retenido"];
		   $totalg1=$totalg1+$monto_documento; $totalg2=$totalg2+$monto_exento_iva; $totalg3=$totalg3+$base_imponible; $totalg4=$totalg4+$monto_iva; $totalg5=$totalg5+$monto_iva_retenido;
	       $sub_totalb1=$sub_totalb1+$monto_documento; $sub_totalb2=$sub_totalb2+$monto_exento_iva; $sub_totalb3=$sub_totalb3+$base_imponible;  $sub_totalb4=$sub_totalb4+$monto_iva;  $sub_totalb5=$sub_totalb5+$monto_iva_retenido;	
	       $sub_total1=$sub_total1+$monto_documento; $sub_total2=$sub_total2+$monto_exento_iva; $sub_total3=$sub_total3+$base_imponible; $sub_total4=$sub_total4+$monto_iva; $sub_total5=$sub_total5+$monto_iva_retenido;
		   $monto_documento=formato_monto($monto_documento); $monto_exento_iva=formato_monto($monto_exento_iva);$base_imponible=formato_monto($base_imponible);
           $tasa_iva=formato_monto($tasa_iva);$monto_iva=formato_monto ($monto_iva);$monto_iva_retenido=formato_monto($monto_iva_retenido); $fecha_emision=formato_ddmmaaaa($fecha_emision);
           $fecha_documento=formato_ddmmaaaa($fecha_documento);
		   if($php_os=="WINNT"){$nombre=$registro["nombre"];}else{$nombre=utf8_decode($registro["nombre"]);}
		   $pdf->SetFont('Arial','',8);
		   $pdf->Cell(11,4,$nro_operacion,0,0); 
		   $pdf->Cell(16,4,$fecha_documento,0,0); 
		   $pdf->Cell(11,4,$cod_banco,0,0); 
		   $pdf->Cell(8,4,$tipo_mov,0,0); 
		   $pdf->Cell(20,4,$referencia,0,0); 
		   $pdf->Cell(8,4,$tipo_documento,0,0,'C');
		   $pdf->Cell(40,4,$nro_documento,0,0,'C');    
		   $pdf->Cell(28,4,$nro_doc_afectado,0,0);  		   
		   $pdf->Cell(21,4,$monto_documento,0,0,'R'); 
           $pdf->Cell(21,4,$monto_exento_iva,0,0,'R'); 		   
		   $pdf->Cell(22,4,$base_imponible,0,0,'R'); 
		   $pdf->Cell(14,4,$tasa_iva,0,0,'R'); 
		   $pdf->Cell(20,4,$monto_iva,0,0,'R'); 
		   $pdf->Cell(20,4,$monto_iva_retenido,0,1,'R'); 
		} 

		$totalg1=formato_monto($totalg1); $totalg2=formato_monto($totalg2); $totalg3=formato_monto($totalg3); $totalg4=formato_monto($totalg4); $totalg5=formato_monto($totalg5);
		$pdf->SetFont('Arial','B',8);
	    

		if(($sub_total1>0)or($sub_total2>0)or($sub_total3>0)or($sub_total4>0)or($sub_total5>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2); 		        $sub_total3=formato_monto($sub_total3); $sub_total4=formato_monto($sub_total4); $sub_total5=formato_monto($sub_total5);		 		    
			$pdf->Cell(142,2,'',0,0);
			$pdf->Cell(21,2,'-------------------',0,0,'R');
			$pdf->Cell(21,2,'-------------------',0,0,'R');
			$pdf->Cell(22,2,'-------------------',0,0,'R');
			$pdf->Cell(14,2,'',0,0,'R');
			$pdf->Cell(20,2,'-------------------',0,0,'R');
			$pdf->Cell(20,2,'-------------------',0,1,'R');
			$pdf->Cell(142,4,"SUB-TOTAL : ",0,0,'R'); 
			$pdf->Cell(21,4,$sub_total1,0,0,'R'); 
			$pdf->Cell(21,4,$sub_total2,0,0,'R');
			$pdf->Cell(22,4,$sub_total3,0,0,'R');
			$pdf->Cell(14,4,'',0,0,'R');
			$pdf->Cell(20,4,$sub_total4,0,0,'R');
			$pdf->Cell(20,4,$sub_total5,0,1,'R');
			$pdf->Ln(5);}
        
		if(($sub_totalb1>0)or($sub_totalb2>0)or($sub_totalb3>0)or($sub_totalb4>0)or($sub_totalb5>0)){ $sub_totalb1=formato_monto($sub_totalb1); $sub_totalb2=formato_monto($sub_totalb2); 		        $sub_totalb3=formato_monto($sub_totalb3); $sub_totalb4=formato_monto($sub_totalb4); $sub_totalb5=formato_monto($sub_totalb5);			  
			$pdf->Cell(142,2,'',0,0);
			$pdf->Cell(21,2,'-------------------',0,0,'R');
			$pdf->Cell(21,2,'-------------------',0,0,'R');
			$pdf->Cell(22,2,'-------------------',0,0,'R');
			$pdf->Cell(14,2,'',0,0,'R');
			$pdf->Cell(20,2,'-------------------',0,0,'R');
			$pdf->Cell(20,2,'-------------------',0,1,'R');
			$pdf->Cell(142,4,"TOTAL BENEFICIARIO : ",0,0,'R'); 
			$pdf->Cell(21,4,$sub_totalb1,0,0,'R'); 
			$pdf->Cell(21,4,$sub_totalb2,0,0,'R');
			$pdf->Cell(22,4,$sub_totalb3,0,0,'R');
			$pdf->Cell(14,4,'',0,0,'R');
			$pdf->Cell(20,4,$sub_totalb4,0,0,'R');
			$pdf->Cell(20,4,$sub_totalb5,0,1,'R');
			$pdf->Ln(5);}

		$pdf->SetFont('Arial','B',8);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(142,4,'',0,0);
		$pdf->Cell(21,4,'=============',0,0,'R');
		$pdf->Cell(21,4,'=============',0,0,'R');
		$pdf->Cell(22,4,'=============',0,0,'R');
		$pdf->Cell(14,4,'',0,0,'R');
		$pdf->Cell(20,4,'=============',0,0,'R');
		$pdf->Cell(20,4,'=============',0,1,'R');
		$pdf->Cell(142,4,'TOTAL GENERAL : ',0,0,'R');
		$pdf->Cell(21,4,$totalg1,0,0,'R'); 
		$pdf->Cell(21,4,$totalg2,0,0,'R');
		$pdf->Cell(22,4,$totalg3,0,0,'R');
		$pdf->Cell(14,4,'',0,0,'R');
		$pdf->Cell(20,4,$totalg4,0,0,'R');
		$pdf->Cell(20,4,$totalg5,0,1,'R');	 
		$pdf->Output();   
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Listado_Retencion_IVA_Beneficiario.xls");	
	
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="100" align="left"><strong></strong></td>
		    <td width="100" align="left"><strong></strong></td>
			<td width="100" align="left"><strong></strong></td>
		    <td width="50" align="left"><strong></strong></td>
		    <td width="100" align="left"><strong></strong></td>
		    <td width="50" align="left"><strong></strong></td>
            <td width="200" align="center"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO DE RETENCION IVA POR BENEFICIARIO</strong></font></td>
	    </tr>	    
	    <tr height="20">
		   <td width="100" align="left"><strong></strong></td>
	   	   <td width="100" align="left"><strong></strong></td>
		   <td width="100" align="left"><strong></strong></td>
		   <td width="50" align="left"><strong></strong></td>
		   <td width="100" align="left"><strong></strong></td>
		   <td width="50" align="left"><strong></strong></td>
		   <td width="200" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><?	echo $criterio1?></strong></font></td>
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>NRO OP</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>FECHA DOC</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>BANCO</strong></td>
           <td width="50" align="left" bgcolor="#99CCFF"><strong>MOV</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>REFERENCIA</strong></td>
           <td width="50" align="left" bgcolor="#99CCFF"><strong>TIPO DOC</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF"><strong>NRO DOCUMENTO</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF"><strong>FACTURA AFECTADA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO CON IVA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO CON EXENTO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>BASE IMPONIBLE</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>TASA IVA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>IMPUESTO IVA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>IVA RETENIDO</strong></font></td>
         </tr>
     <?
	  
	  $i=0;  $totalg1=0; $totalg2=0; $totalg3=0; $totalg4=0; $totalg5=0; $sub_totalb1=""; $sub_totalb2=""; $sub_totalb3=""; $sub_totalb4=""; $sub_totalb5=""; $sub_total1=""; $sub_total2=""; $sub_total3=""; $sub_total4=""; $sub_total5=""; $cantidad=0; 
		$prev_ced_rif=""; $prev_nro_comprobante="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $ced_rif=$registro["ced_rif"];  $nombre=utf8_decode($registro["nombre"]); 
		   $nro_comprobante=$registro["nro_comprobante"]; $ano_fiscal=$registro["ano_fiscal"];  $mes_fiscal=$registro["mes_fiscal"]; $fecha_emision=$registro["fecha_emision"];
		   $nombre=conv_cadenas($nombre,0); $fecha_emision=formato_ddmmaaaa($fecha_emision);
		   $ced_rif_grupo=$ced_rif;  $nombre_grupo=$nombre;  $nro_comprobante_grupo=$nro_comprobante;  $ano_fiscal_grupo=$ano_fiscal; $mes_fiscal_grupo=$mes_fiscal; 			       $fecha_emision_grupo=$fecha_emision;
		   $ced_rif_grupo=$ced_rif;  $nombre_grupo=$nombre;    
		   if($prev_ced_rif<>$ced_rif_grupo){ 
		       if(($sub_total1>0)or($sub_total2>0)or($sub_total3>0)or($sub_total4>0)or($sub_total5>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2); $sub_total3=formato_monto($sub_total3); $sub_total4=formato_monto($sub_total4); $sub_total5=formato_monto($sub_total5);			
			     ?>	 				 
                  	<tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="200" align="left"></td>
			          <td width="200" align="left"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			       </tr>	
			      <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="200" align="left"></td>
			          <td width="200" align="left">SUB- TOTAL</td>
					  <td width="100" align="right"><? echo $sub_total1; ?></td>
					  <td width="100" align="right"><? echo $sub_total2; ?></td>
					  <td width="100" align="right"><? echo $sub_total3; ?></td>
					  <td width="100" align="right"></td>
					  <td width="100" align="right"><? echo $sub_total4; ?></td>
					  <td width="100" align="right"><? echo $sub_total5; ?></td>
			      </tr>	
			      <tr>
				  <td width="90" align="left"></td>
			      </tr>	
               <? $prev_nro_comprobante=$nro_comprobante_grupo; $sub_total1=0; $sub_total2=0; $sub_total3=0; $sub_total4=0; $sub_total5=0;
			   }  
			   if(($sub_totalb1>0)or($sub_totalb2>0)or($sub_totalb3>0)or($sub_totalb4>0)or($sub_totalb5>0)){ $sub_totalb1=formato_monto($sub_totalb1); $sub_totalb2=formato_monto($sub_totalb2); $sub_totalb3=formato_monto($sub_totalb3); $sub_totalb4=formato_monto($sub_totalb4); $sub_totalb5=formato_monto($sub_totalb5);	
			     ?>	 				 
                   <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="200" align="left"></td>
			          <td width="200" align="left"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			      </tr>	
			      <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="200" align="left"></td>
			          <td width="200" align="left">TOTAL BENEFICIARIO</td>
					  <td width="100" align="right"><? echo $sub_totalb1; ?></td>
					  <td width="100" align="right"><? echo $sub_totalb2; ?></td>
					  <td width="100" align="right"><? echo $sub_totalb3; ?></td>
					  <td width="100" align="right"></td>
					  <td width="100" align="right"><? echo $sub_totalb4; ?></td>
					  <td width="100" align="right"><? echo $sub_totalb5; ?></td>
			      </tr>	
			      <tr>
				  <td width="90" align="left"></td>
			      </tr>	
              <?}
			      ?>	   
			      <tr>
					  <td width="100" align="left">Ced/Rif :</td>
					  <td width="100" align="left"><? echo $ced_rif; ?></td>
					  <td width="100" align="left"></td>
					  <td width="50" align="left"></td>
					  <td width="100" align="left">Nombre:</td>
					  <td width="50" align="left"></td>
					  <td width="200" align="left"><? echo $nombre; ?></td>
			      </tr>
				  <tr>
					  <td width="100" align="left">Comprobante:</td>
					  <td width="100" align="left">'<? echo $ano_fiscal.$mes_fiscal.$nro_comprobante; ?></td>
					  <td width="100" align="left">Fecha Emision :</td>
					  <td width="50" align="left"></td>
					  <td width="100" align="left"><? echo $fecha_emision; ?></td>
			      </tr>
			     <? 					 
			    $prev_ced_rif=$ced_rif_grupo; $sub_totalb1=0; $sub_totalb2=0; $sub_totalb3=0; $sub_totalb4=0; $sub_totalb5=0;
            }
			if(($prev_nro_comprobante<>$nro_comprobante_grupo)or($prev_ced_rif<>$ced_rif_grupo)){ 
			     if(($sub_total1>0)or($sub_total2>0)or($sub_total3>0)or($sub_total4>0)or($sub_total5>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2); $sub_total3=formato_monto($sub_total3); $sub_total4=formato_monto($sub_total4); $sub_total5=formato_monto($sub_total5);			
			     ?>	 				 
                  	<tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="200" align="left"></td>
			          <td width="200" align="left"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			       </tr>	
			      <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="200" align="left"></td>
			          <td width="200" align="left">SUB- TOTAL</td>
					  <td width="100" align="right"><? echo $sub_total1; ?></td>
					  <td width="100" align="right"><? echo $sub_total2; ?></td>
					  <td width="100" align="right"><? echo $sub_total3; ?></td>
					  <td width="100" align="right"></td>
					  <td width="100" align="right"><? echo $sub_total4; ?></td>
					  <td width="100" align="right"><? echo $sub_total5; ?></td>
			      </tr>	
			      <tr>
					<td width="90" align="left"></td>
			      </tr>	
                  <?}?>	   
			      <tr>
					  <td width="100" align="left">Comprobante:</td>
					  <td width="100" align="left">'<? echo $ano_fiscal.$mes_fiscal.$nro_comprobante; ?></td>
					  <td width="100" align="left">Fecha Emision :</td>
					  <td width="50" align="left"></td>
					  <td width="100" align="left"><? echo $fecha_emision; ?></td>
			      </tr>
			     <? 					 
			    $prev_nro_comprobante=$nro_comprobante_grupo; $sub_total1=0; $sub_total2=0; $sub_total3=0; $sub_total4=0; $sub_total5=0;
			}

		   $nro_comprobante=$registro["nro_comprobante"]; $nro_operacion=$registro["nro_operacion"]; $fecha_emision=$registro["fecha_emision"]; 
           $fecha_documento=$registro["fecha_documento"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $cod_banco=$registro["cod_banco"]; 
           $tipo_mov=$registro["tipo_mov"]; $referencia=$registro["referencia"]; $tipo_documento=$registro["tipo_documento"]; $nro_documento=$registro["nro_documento"]; 
           $nro_doc_afectado=$registro["nro_doc_afectado"];$monto_documento=$registro["monto_documento"]; $monto_exento_iva=$registro["monto_exento_iva"]; $base_imponible=$registro["base_imponible"]; 
           $tasa_iva=$registro["tasa_iva"]; $monto_iva=$registro["monto_iva"];$monto_iva_retenido=$registro["monto_iva_retenido"];
		   $totalg1=$totalg1+$monto_documento; $totalg2=$totalg2+$monto_exento_iva; $totalg3=$totalg3+$base_imponible; $totalg4=$totalg4+$monto_iva; $totalg5=$totalg5+$monto_iva_retenido;
	       $sub_totalb1=$sub_totalb1+$monto_documento; $sub_totalb2=$sub_totalb2+$monto_exento_iva; $sub_totalb3=$sub_totalb3+$base_imponible;   $sub_totalb4=$sub_totalb4+$monto_iva;  $sub_totalb5=$sub_totalb5+$monto_iva_retenido;	
	       $sub_total1=$sub_total1+$monto_documento; $sub_total2=$sub_total2+$monto_exento_iva; $sub_total3=$sub_total3+$base_imponible; $sub_total4=$sub_total4+$monto_iva;  $sub_total5=$sub_total5+$monto_iva_retenido;
           $monto_documento=formato_monto($monto_documento); $monto_exento_iva=formato_monto($monto_exento_iva);$base_imponible=formato_monto($base_imponible);
           $tasa_iva=formato_monto($tasa_iva);$monto_iva=formato_monto ($monto_iva);$monto_iva_retenido=formato_monto($monto_iva_retenido); $fecha_emision=formato_ddmmaaaa($fecha_emision);
           $fecha_documento=formato_ddmmaaaa($fecha_documento);$nombre=conv_cadenas($nombre,0);  
	?>	   
		   <tr>
                <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_operacion; ?></td>
           		<td width="100" align="center"><? echo $fecha_documento; ?></td>
           		<td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $cod_banco; ?></td>
           		<td width="50" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $tipo_mov; ?></td>
           		<td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $referencia; ?></td>
           		<td width="50" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $tipo_documento; ?></td>
           		<td width="200" align="center">'<? echo $nro_documento; ?></td>
           		<td width="200" align="center">'<? echo $nro_doc_afectado; ?></td>
           		<td width="100" align="right"><? echo $monto_documento; ?></td>
           		<td width="100" align="right"><? echo $monto_exento_iva; ?></td>
           		<td width="100" align="right"><? echo $base_imponible; ?></td>
           		<td width="50" align="right"><? echo $tasa_iva; ?></td>
           		<td width="100" align="right"><? echo $monto_iva; ?></td>
           		<td width="100" align="right"><? echo $monto_iva_retenido; ?></td>
            </tr>
	 <? }  

        $totalg1=formato_monto($totalg1); $totalg2=formato_monto($totalg2); $totalg3=formato_monto($totalg3); $totalg4=formato_monto($totalg4); $totalg5=formato_monto($totalg5);
        if(($sub_totalb1>0)or($sub_totalb2>0)or($sub_totalb3>0)or($sub_totalb4>0)or($sub_totalb5>0)){ $sub_totalb1=formato_monto($sub_totalb1); $sub_totalb2=formato_monto($sub_totalb2); $sub_totalb3=formato_monto($sub_totalb3); $sub_totalb4=formato_monto($sub_totalb4); $sub_totalb5=formato_monto($sub_totalb5);	
			?>	 				 
            <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="200" align="left"></td>
			          <td width="200" align="left"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			       </tr>	
			      <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="200" align="left"></td>
			          <td width="200" align="left">TOTAL BENEFICIARIO</td>
					  <td width="100" align="right"><? echo $sub_totalb1; ?></td>
					  <td width="100" align="right"><? echo $sub_totalb2; ?></td>
					  <td width="100" align="right"><? echo $sub_totalb3; ?></td>
					  <td width="100" align="right"></td>
					  <td width="100" align="right"><? echo $sub_totalb4; ?></td>
					  <td width="100" align="right"><? echo $sub_totalb5; ?></td>
			      </tr>	
				  
			
		      <?
		}
        if(($sub_total1>0)or($sub_total2>0)or($sub_total3>0)or($sub_total4>0)or($sub_total5>0)){ $sub_total1=formato_monto($sub_total1); $sub_total2=formato_monto($sub_total2); $sub_total3=formato_monto($sub_total3); $sub_total4=formato_monto($sub_total4); $sub_totalb5=formato_monto($sub_total5);	
			?>	 				 
                <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="200" align="left"></td>
			          <td width="200" align="left"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right"></td>
			          <td width="100" align="right">---------------</td>
			          <td width="100" align="right">---------------</td>
			       </tr>	
			      <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="50" align="left"></td>
				      <td width="200" align="left"></td>
			          <td width="200" align="left">SUB-TOTAL</td>
					  <td width="100" align="right"><? echo $sub_total1; ?></td>
					  <td width="100" align="right"><? echo $sub_total2; ?></td>
					  <td width="100" align="right"><? echo $sub_total3; ?></td>
					  <td width="100" align="right"></td>
					  <td width="100" align="right"><? echo $sub_total4; ?></td>
					  <td width="100" align="right"><? echo $sub_total5; ?></td>
			      </tr>	
			
		      <?
		}
		      ?>			 
   		<tr>
     		<td>&nbsp;</td>
        </tr>
        <tr>
			<td width="100"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
		    <td width="100" align="left"></td>
			<td width="100" align="left"></td>
			<td width="50" align="left"></td>
			<td width="100" align="left"></td>
			<td width="50" align="left"></td>
			<td width="200" align="left"></td>
            <td width="200"><strong>TOTAL ORDENES:</td>
			<td width="100" align="right"><strong><? echo $totalg1; ?></strong></td>
		    <td width="100" align="right"><strong><? echo $totalg2; ?></strong></td>
		    <td width="100" align="right"><strong><? echo $totalg3; ?></strong></td>
		    <td width="100" align="right"></td>
		    <td width="100" align="right"><strong><? echo $totalg4; ?></strong></td>
		    <td width="100" align="right"><strong><? echo $totalg5; ?></strong></font></td>
        </tr>
		</table><?
    }		  
  }
?>
