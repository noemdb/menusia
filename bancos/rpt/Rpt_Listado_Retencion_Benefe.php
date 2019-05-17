<?error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc"); 
$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$tipo_planilla_d=$_GET["tipo_planilla_d"];$tipo_planilla_h=$_GET["tipo_planilla_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$clasificacion_d=$_GET["clasificacion_d"];$clasificacion_h=$_GET["clasificacion_h"];$tipo_bene_d=$_GET["tipo_bene_d"];$tipo_bene_h=$_GET["tipo_bene_h"];$ordenado=$_GET["ordenado"];$generado=$_GET["generado"]; $tipo_comp=$_GET["tipo_comp"];  $Sql="";$date = date("d-m-Y");$hora = date("H:i:s a");$tipo_rpt=$_GET["tipo_rpt"];
$criterio1="Fecha Desde: ".$fecha_d." Al: ".$fecha_h; $criterio2="LISTADOS DE RETENCION POR BENEFICIARIO"; $php_os=PHP_OS; 
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
$criterio_s="  (BAN012.fecha_emision>='".$fecha_desde."') And (BAN012.fecha_emision<='".$fecha_hasta."') ";
if($tipo_comp==="ORDEN CANCELADA") { $criterio_s="  BAN012.fecha_emision<='".$fecha_hasta."' and BAN012.tipo_mov='O/P' and BAN012.referencia in (select nro_orden  from pag001 where status='I' and fecha_cheque>='".$fecha_desde."' and fecha_cheque<='".$fecha_hasta."') ";}
if($tipo_comp==="CHEQUE ENTREGADO"){ $criterio_s="  BAN012.fecha_emision<='".$fecha_hasta."' and BAN012.tipo_mov='O/P' and ((BAN012.referencia='00000000' and BAN012.fecha_emision>='".$fecha_desde."' AND BAN012.fecha_emision<='".$fecha_hasta."') OR (BAN012.referencia in (select nro_orden  from pag001 where Status='I' and text(cod_banco)||text(nro_cheque) in (select text(cod_banco)||text(num_cheque) from ban006 where entregado='S' and fecha_entregado>='".$fecha_desde."' and fecha_entregado<='".$fecha_hasta."') )) )"; }

   $conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else{ $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){ $php_os="WINNT";}
    $sSQL = "SELECT BAN012.Nro_Planilla, BAN012.Fecha_Emision, BAN012.Tipo_Planilla, BAN011.Descripcion, BAN012.Cod_Banco, BAN012.Tipo_Mov, BAN012.Referencia, BAN012.Nro_Documento, BAN012.nro_con_factura, 	
                BAN012.Ced_Rif, PRE099.Nombre, BAN012.monto_objeto, BAN012.Tasa, BAN012.Monto_Retencion,BAN012.Nro_Orden, PRE099.clasificacion, to_char(BAN012.Fecha_Emision,'DD/MM/YYYY') as fechae
                FROM BAN011 BAN011, BAN012 BAN012, PRE099 PRE099  WHERE BAN012.Ced_Rif = PRE099.Ced_Rif AND BAN012.Tipo_Planilla = BAN011.Codigo AND
                BAN012.Ced_Rif>='".$cedula_d."' AND BAN012.Ced_Rif<='".$cedula_h."' AND BAN012.Tipo_Planilla>='".$tipo_planilla_d."' AND BAN012.Tipo_Planilla<='".$tipo_planilla_h."' AND
                PRE099.clasificacion >='".$clasificacion_d."' AND PRE099.clasificacion <='".$clasificacion_h."' AND
                PRE099.Tipo_Benef>='".$tipo_bene_d."' AND PRE099.Tipo_Benef<='".$tipo_bene_h."'  and  ".$criterio_s." ORDER BY ".$ordenado;  
	if($tipo_rpt=="HTML"){	  
		  $oRpt = new PHPRepinclude ("../../class/phpreports/PHPReportMaker.php"); ortMaker();
          $oRpt->setXML("Rpt_Listado_Retencion_Beneficiario.xml");
          $oRpt->setUser("$user");
          $oRpt->setPassword("$password");
          $oRpt->setConnection("$host");
          $oRpt->setDatabaseInterface("postgresql");
          $oRpt->setSQL($sSQL);
          $oRpt->setDatabase("$dbname");
          $oRpt->setParameters(array("criterio1"=>$criterio1,"criterio2"=>$criterio2,"date"=>$date,"hora"=>$hora));
          $oRpt->run();
   }
   if($tipo_rpt=="PDF"){ $res=pg_query($sSQL); $ced_rif_grupo=""; $nombre_grupo=""; $tipo_planilla_grupo=""; $descripcion_grupo="";
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{ 	
		function Header(){ global $tam_logo;  global $criterio1; global $ced_rif_grupo; global $nombre_grupo; global $tipo_planilla_grupo; global $descripcion_grupo; global $registro;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(25);
			$this->Cell(160,10,'REPORTE LISTADOS DE RETENCION POR BENEFICIARIO',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(25);
			$this->Cell(160,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',7);
			$this->Cell(20,5,'NRO PLANILLA',1,0,'L');
			$this->Cell(21,5,'FECHA EMISION',1,0,'C');
			$this->Cell(19,5,'NRO ORDEN',1,0,'C');
			$this->Cell(60,5,'NRO DOCUMENTO',1,0,'C');
			$this->Cell(20,5,'NRO CONTROL',1,0,'C');
			$this->Cell(30,5,'MONTO OBJETO',1,0,'R');
			$this->Cell(10,5,'TASA',1,0,'R');
			$this->Cell(20,5,'RETENCION',1,1,'R');
            if($ced_rif_grupo<>""){ 
				$this->Cell(30,5,"Ced/Rif: ".$ced_rif_grupo,0,0,'L');
				$this->Cell(170,5,"Nombre: ".$nombre_grupo,0,1,'L');
			}
            if($tipo_planilla_grupo<>""){ 
				$this->Cell(15,5,"Planillas:",0,0,'L');
                $this->Cell(10,5,$tipo_planilla_grupo,0,0,'L'); 	
                $this->Cell(175,5,$descripcion_grupo,0,1,'L');
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
	  $i=0;  $total=0; $sub_total=""; $cantidad=0; $prev_ced_rif=""; $prev_tipo_planilla="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $ced_rif=$registro["ced_rif"];  $tipo_planilla=$registro["tipo_planilla"]; 
		   if($php_os=="WINNT"){$nombre=$registro["nombre"]; $descripcion=$registro["descripcion"];} else{$nombre=utf8_decode($registro["nombre"]); $descripcion=utf8_decode($registro["descripcion"]);}
		   $ced_rif_grupo=$ced_rif;  $nombre_grupo=$nombre;  $tipo_planilla_grupo=$tipo_planilla;  $descripcion_grupo=$descripcion; 
		   if($prev_ced_rif<>$ced_rif_grupo){ 
			    $pdf->SetFont('Arial','B',7); 
			    if($sub_total<>0){ $sub_total=formato_monto($sub_total);					    
				    $pdf->Cell(180,2,'',0,0);
					$pdf->Cell(20,2,'-------------------',0,1,'R');
					$pdf->Cell(180,5,"TOTAL BENEFICIARIO : ",0,0,'R'); 
					$pdf->Cell(20,5,$sub_total,0,1,'R'); 
					$pdf->Ln(10);}	
					$pdf->Cell(30,5,"Ced/Rif: ".$ced_rif_grupo,0,0,'L');
				    $pdf->Cell(170,5,"Nombre: ".$nombre_grupo,0,1,'L');
				$prev_ced_rif=$ced_rif_grupo; $sub_total=0;
			}
			if($prev_tipo_planilla<>$tipo_planilla_grupo) { 	
                $pdf->Cell(15,3,"Planillas:",0,0,'L');
			   	$pdf->Cell(10,3,$tipo_planilla_grupo,0,0,'L');
                $pdf->Cell(160,3,$descripcion_grupo,0,1,'L'); 			 
					
				$prev_tipo_planilla=$tipo_planilla_grupo; 
			}
			$pdf->SetFont('Arial','',7);   
		   $nro_planilla=$registro["nro_planilla"]; $fecha_emision=$registro["fecha_emision"]; $referencia=$registro["referencia"]; 
		   $nro_documento=$registro["nro_documento"]; $ced_rif=$registro["ced_rif"]; $nro_con_factura=$registro["nro_con_factura"]; $tipo_planilla=$registro["tipo_planilla"]; 
		   $descripcion=$registro["descripcion"]; $monto_objeto=$registro["monto_objeto"]; $tasa=$registro["tasa"]; $monto_retencion=$registro["monto_retencion"];
		   $total=$total+$monto_retencion; $sub_total=$sub_total+$monto_retencion; $cantidad=$cantidad+1;
		   $monto_retencion=formato_monto($monto_retencion); $fecha_emision=formato_ddmmaaaa($fecha_emision); 
		   $monto_objeto=formato_monto($monto_objeto); $tasa=formato_monto($tasa);
		   if($php_os=="WINNT"){$nombre=$registro["nombre"]; $descripcion=$registro["descripcion"];} else{$nombre=utf8_decode($registro["nombre"]); $descripcion=utf8_decode($registro["descripcion"]);}
		   $ld=strlen($nro_documento); if($ld>50){$nro_documento=substr($nro_documento,0,50);}
		   $pdf->Cell(20,3,$nro_planilla,0,0,'L'); 	
		   $pdf->Cell(20,3,$fecha_emision,0,0,'C');
		   $pdf->Cell(20,3,$referencia,0,0,'C');
		   $pdf->Cell(60,3,$nro_documento,0,0,'C');
		   $pdf->Cell(20,3,$nro_con_factura,0,0,'C');
		   $pdf->Cell(30,3,$monto_objeto,0,0,'R');    
		   $pdf->Cell(10,3,$tasa,0,0,'R');   	   
		   $pdf->Cell(20,3,$monto_retencion,0,1,'R'); 
		   

		} $total=formato_monto($total); $cantidad==formato_monto ($cantidad);
		$pdf->SetFont('Arial','B',7);
	    if($sub_total<>0){ $sub_total=formato_monto($sub_total); 						    
			$pdf->Cell(180,2,'',0,0);
			$pdf->Cell(20,2,'-------------------',0,1,'R');
			$pdf->Cell(180,5,"TOTAL BENEFICIARIO : ",0,0,'R'); 
			$pdf->Cell(20,5,$sub_total,0,1,'R'); 
			$pdf->Ln(10);
		}
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(180,3,'',0,0);
		$pdf->Cell(20,3,'============',0,1,'R');
		$pdf->Cell(180,3,'TOTAL GENERAL : ',0,0,'R');
		$pdf->Cell(20,3,$total,0,1,'R'); 
		$pdf->Output();   
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Retencion_Beneficiario.xls");	
	
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
            <td width="200" align="center" > <font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDENES DE PAGO POR BENEFICIARIO</strong></font></td>
	     </tr>
	     <tr height="20">
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="200" align="center" > <font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1?></strong></font></td>
		 </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>NRO PLANILLA</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>FECHA EMISION</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>NRO ORDEN</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF"><strong>NRO DOCUMENTO</strong></td>
		   <td width="200" align="left" bgcolor="#99CCFF"><strong>NRO CONTROL</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO OBJETO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>TASA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO RETENCION</strong></font></td>
         </tr>
     <?
	  
	  $i=0;  $total=0; $sub_total=0;  $cantidad=0; $prev_ced_rif=""; $prev_tipo_planilla="";
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $ced_rif=$registro["ced_rif"];   $tipo_planilla=$registro["tipo_planilla"]; 
		   $nombre=$registro["nombre"]; $descripcion=$registro["descripcion"];$nombre=conv_cadenas($nombre,0); $descripcion=conv_cadenas($descripcion,0);
		   $ced_rif_grupo=$ced_rif;  $nombre_grupo=$nombre;  $tipo_planilla_grupo=$tipo_planilla;  $descripcion_grupo=$descripcion; 
		   if($prev_ced_rif<>$ced_rif_grupo){ 
			   if($sub_total<>0){ $sub_total=formato_monto($sub_total); 
			     ?>	 				 
                    <tr>
			          <td width="100" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="200" align="left"></td>
					  <td width="200" align="left"></td>
				      <td width="100" align="left"></td>
			          <td width="100" align="left"></td>
			          <td width="100" align="right">---------------</td>
			      </tr>	
			      <tr>
			         <td width="100" align="left"></td>
				     <td width="100" align="left"></td>
			         <td width="100" align="left"></td>
			         <td width="200" align="left"></td>
					 <td width="200" align="left"></td>
				     <td width="100" align="left"></td>
			         <td width="100" align="left">TOTAL BENEFICIARIO</td>
				     <td width="100" align="right"><? echo $sub_total; ?></td>
			      </tr>	
			      <tr>
				  <td width="90" align="left"></td>
			      </tr>	
               <?}?>	   
			      <tr>
				  <td width="100" align="left">Ced/Rif :</td>
				  <td width="100" align="left"><? echo $ced_rif; ?></td>
				  <td width="100" align="left">Nombre :</td>
				  <td width="200" align="left"><? echo $nombre; ?></td>
			      </tr>
			     <? 					 
			    $prev_ced_rif=$ced_rif_grupo; $sub_total=0; 
			}					
            if($prev_tipo_planilla<>$tipo_planilla_grupo){ 
			    ?>	   
			    <tr>
				    <td width="100" align="left">Planillas :</td>
           		    <td width="100" align="center"><? echo $tipo_planilla; ?></td>
				    <td width="100" align="left"></td>
					<td width="200" align="left"><? echo $descripcion; ?></td>
			    </tr>
			    <?$prev_tipo_planilla=$tipo_planilla_grupo; 
			} 
			    
		   $nro_planilla=$registro["nro_planilla"]; $fecha_emision=$registro["fecha_emision"]; $referencia=$registro["referencia"]; $nro_con_factura=$registro["nro_con_factura"]; 
		   $nro_documento=$registro["nro_documento"]; $ced_rif=$registro["ced_rif"]; $nombre=$registro["nombre"]; $tipo_planilla=$registro["tipo_planilla"]; 
		   $descripcion=$registro["descripcion"]; $monto_objeto=$registro["monto_objeto"]; $tasa=$registro["tasa"]; $monto_retencion=$registro["monto_retencion"];
		   $total=$total+$monto_retencion; $sub_total=$sub_total+$monto_retencion; 
		   $monto_retencion=formato_monto($monto_retencion);  $fecha_emision=formato_ddmmaaaa($fecha_emision);
		   $monto_objeto=formato_monto($monto_objeto); $tasa=formato_monto($tasa);   $nombre=conv_cadenas($nombre,0);  
	    ?>	   
		   <tr>
                <td width="100" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_planilla; ?></td>
           		<td width="100" align="center"><? echo $fecha_emision; ?></td>
           		<td width="100" align="center">'<? echo $referencia; ?></td>
           		<td width="200" align="center">'<? echo $nro_documento; ?></td>
				<td width="200" align="center">'<? echo $nro_con_factura; ?></td>
           		<td width="100" align="right"><? echo $monto_objeto; ?></td>
           		<td width="100" align="right"><? echo $tasa; ?></td>
           		<td width="100" align="right"><? echo $monto_retencion; ?></td>
           </tr>
	    <? 
	    }  
        if($sub_total<>0){ $sub_total=formato_monto($sub_total); 
		  ?>	 				 
		  <tr>
			  <td width="100" align="left"></td>
			  <td width="100" align="left"></td>
			  <td width="100" align="left"></td>
			  <td width="200" align="left"></td>
			  <td width="200" align="left"></td>
			  <td width="100" align="left"></td>
			  <td width="100" align="left"></td>
			  <td width="100" align="right">---------------</td>
		  </tr>	
		  <tr>
			 <td width="100" align="left"></td>
			 <td width="100" align="left"></td>
			 <td width="100" align="left"></td>
			 <td width="200" align="left"></td>
			 <td width="200" align="left"></td>
			 <td width="100" align="left"></td>
			 <td width="100" align="left">TOTAL BENEFICIARIO</td>
			 <td width="100" align="right"><? echo $sub_total; ?></td>
		  </tr>	
		  <tr>
		     <td width="90" align="left"></td>
		  </tr>	
		<?
		}$total=formato_monto($total); 	
		?>	 				 
   		<tr> <td>&nbsp;</td>
		<tr>
			<td width="100"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
			<td width="100"><strong></strong></td>
            <td width="100"><strong></strong></td>			
			<td width="200" align="left" ><strong></strong></td>
			<td width="200" align="left" ><strong></strong></td>
			<td width="100"><strong></strong></td>
			<td width="100" align="right"><strong>TOTAL :</strong></td>
			<td width="100" align="right"><strong><? echo $total; ?></strong></font></td>
		 </tr>
	  </table><?
        }		  
    }

?>
