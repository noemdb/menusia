<? include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc"); $php_os=PHP_OS;  error_reporting(E_ALL ^ E_NOTICE);
$nro_orden_d=$_GET["nro_orden_d"];$nro_orden_h=$_GET["nro_orden_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"];$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$tipo_orden_d=$_GET["tipo_orden_d"];$tipo_orden_h=$_GET["tipo_orden_h"];$cod_cuenta_d=$_GET["cod_cuenta_d"];$cod_cuenta_h=$_GET["cod_cuenta_h"];$tipo_rpt=$_GET["tipo_rpt"]; $agrupa_cuenta=$_GET["agrupa_cuenta"];
$criterio1="FECHA DESDE: ".$fecha_d." HASTA: ".$fecha_h;   $Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a");
    if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';}$fecha_desde=$ano1.$mes1.$dia1;
    if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';}$fecha_hasta=$ano1.$mes1.$dia1;
$conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTandO LA BASE DE DATOS'); </script> <?}
else{$php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
    // LLAMAR A PHP_REPORT
	$status_pag="((substring(pag001.tipo_causado,1,1)<>'A') and ";
	//$status_pag=$status_pag."((pag001.status='N') or ";	
	$status_pag=$status_pag."( (((pag001.status='N') and (pag001.nro_orden not in (SELECT nro_orden FROM PAG007 Where (fecha_cheque<='".$fecha_hasta."') and ((Anulado='S') and (fecha_anulado>'".$fecha_hasta."')) ))) or ";	
	$status_pag=$status_pag."((pag001.status='I') and ( (pag001.fecha_cheque>'".$fecha_hasta."') and (pag001.nro_orden not in (SELECT nro_orden FROM PAG007 Where (fecha_cheque<='".$fecha_hasta."') and (Anulado='S') and (extract(month from fecha_cheque)<>extract(month from fecha_anulado)) ))) ) ) )";
	$status_pag=$status_pag." and ((pag001.anulado='N') Or ((pag001.anulado='S') and (pag001.fecha_anulado>'".$fecha_hasta."')))";
	$status_pag=$status_pag." and ((pag001.total_causado-pag001.total_retencion-pag001.total_ajuste)>0) )";
	
	if($agrupa_cuenta=="NO"){$orden="  ORDER BY pag001.nro_orden";}	else{$orden="  ORDER BY pag001.cod_contable_o,pag001.nro_orden";}
		
   $sSQL = "SELECT pag001.fecha, pag001.nro_orden, PRE099.nombre, pag001.concepto, to_char(fecha,'DD/MM/YYYY') as fechae,
            (pag001.total_causado-pag001.total_retencion-pag001.total_ajuste-pag001.monto_am_ant+pag001.total_pasivos) as monto_orden,
			pag001.tipo_orden, pag001.cod_contable_o, pag008.des_tipo_orden, con001.nombre_cuenta
            FROM (pag001 LEFT JOIN pag008 ON (pag008.tipo_orden=pag001.tipo_orden)) left join con001 on (con001.codigo_cuenta=pag001.cod_contable_o), PRE099 WHERE pag001.Ced_Rif = PRE099.Ced_Rif and pag001.nro_orden>='".$nro_orden_d."' and pag001.nro_orden<='".$nro_orden_h."' and
            pag001.fecha>='".$fecha_desde."' and pag001.fecha<='".$fecha_hasta."' and pag001.Ced_Rif>='".$cedula_d."' and pag001.Ced_Rif<='".$cedula_h."' and
            pag001.tipo_orden>='".$tipo_orden_d."' and pag001.tipo_orden<='".$tipo_orden_h."' and pag001.cod_contable_o>='".$cod_cuenta_d."' and pag001.cod_contable_o<='".$cod_cuenta_h."' and ".$status_pag.$orden;
	if($tipo_rpt=="HTML"){	  include ("../../class/phpreports/PHPReportMaker.php");  //echo $sSQL;
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Orden_Pago_Por_Pagar.xml");
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
    if($agrupa_cuenta=="NO"){
      require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){global $criterio1; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(50);
			$this->Cell(100,10,'ORDENES DE PAGO POR PAGAR',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->Cell(13,5,'ORDEN',1,0);
			$this->Cell(13,5,'FECHA',1,0);
			$this->Cell(54,5,'NOMBRE',1,0);
			$this->Cell(100,5,'CONCEPTO',1,0);
			$this->Cell(20,5,'MONTO',1,1,'C');
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',5);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			
			// INI NMDB 30-04-2018
	        // $this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
	        $this->Cell(100,5,' ',0,0,'R');
	        // FIN NMDB 30-04-2018
		}
	  }
	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $total=0;  $cantidad=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];$fecha=$registro["fecha"]; $nombre=$registro["nombre"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $monto_orden=$registro["monto_orden"]; $monto_orden=formato_monto($monto_orden); 
		   $total=$total+$registro["monto_orden"];  $cantidad=$cantidad+1;
		   if($php_os=="WINNT"){$concepto=$registro["concepto"]; }   else{$nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto);}
		   $pdf->Cell(12,3,$nro_orden,0,0); 
		   $pdf->Cell(14,3,$fecha,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $w=100; $n=54;		   
		   $pdf->SetXY($x+$w+$n,$y);		   
		   $pdf->Cell(20,3,$monto_orden,0,1,'R'); $pasa_linea=0;
		   if ($y>=251) { $nombre=substr($nombre,0,64);}
		   if ($y>=254) { $nombre=substr($nombre,0,32);}
           if((strlen(trim($nombre))>35)and (strlen(trim($concepto))<=65) ) { $pasa_linea=1;}		   
		   if(strlen(trim($concepto))>strlen(trim($nombre)) and ($pasa_linea==0)){		   
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
		} $total=formato_monto($total); 
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(180,3,'',0,0);
		$pdf->Cell(20,3,'=============',0,1,'R');
		$pdf->Cell(30,3,'Cantidad Ordenes :',0,0,'L');
		$pdf->Cell(10,3,$cantidad,0,0,'L');
		$pdf->Cell(140,3,'Total Ordenes : ',0,0,'R');
		$pdf->Cell(20,3,$total,0,0,'R'); 
		$pdf->Output();   
	  }else{
	  require('../../class/fpdf/fpdf.php');
      class PDF extends FPDF{
		function Header(){global $criterio1; global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(160,10,'ORDENES DE PAGO PENDIENTE POR CODIGO CONTABLE',1,1,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(13,5,'ORDEN',1,0);
			$this->Cell(13,5,'FECHA',1,0);
			$this->Cell(79,5,'NOMBRE BENEFICIARIO',1,0);
			$this->Cell(75,5,'TIPO DE ORDEN',1,0);
			$this->Cell(20,5,'MONTO',1,1,'C');
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
	  $i=0;  $total=0;  $cantidad=0; $sub_total=0; $prev_cuenta=""; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1; $cod_contable_o=$registro["cod_contable_o"]; $nombre_cuenta=$registro["nombre_cuenta"];
	       $cod_cuenta_grupo=$cod_contable_o;  $nombre_cuenta_grupo=$nombre_cuenta;  
		   if($prev_cuenta<>$cod_cuenta_grupo){ 
			 $pdf->SetFont('Arial','B',7); 
			 if(($sub_total>0)or($cb>=1)){ $sub_total=formato_monto($sub_total);					    
				$pdf->Cell(180,2,'',0,0);
				$pdf->Cell(20,2,'-------------------',0,1,'R');
				$pdf->Cell(180,5,"TOTAL CUENTA  : ",0,0,'R'); 
				$pdf->Cell(20,5,$sub_total,0,1,'R');
				$pdf->Ln(5);
			 }	
			 $pdf->Cell(200,4,"CUENTA CONTALE: ".$cod_cuenta_grupo." ".$nombre_cuenta_grupo,0,1,'L');
			 $pdf->SetFont('Arial','',7);	
			 $prev_cuenta=$cod_cuenta_grupo; $sub_total=0; $cb=0;
		   }  
	  
	  
		   $nro_orden=$registro["nro_orden"];$fecha=$registro["fecha"]; $nombre=$registro["nombre"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $monto_orden=$registro["monto_orden"]; $monto_orden=formato_monto($monto_orden); 		   
		   $tipo_orden=$registro["tipo_orden"]; $cod_contable_o=$registro["cod_contable_o"]; $des_tipo_orden=$registro["des_tipo_orden"]; $nombre_cuenta=$registro["nombre_cuenta"];
		   
		   $total=$total+$registro["monto_orden"];  $cantidad=$cantidad+1; $sub_total=$sub_total+$registro["monto_orden"]; $cb=$cb+1;
		   if($php_os=="WINNT"){$concepto=$registro["concepto"]; }   else{$nombre=utf8_decode($nombre); $concepto=utf8_decode($concepto); $nombre_cuenta=utf8_decode($nombre_cuenta); $des_tipo_orden=utf8_decode($des_tipo_orden);}
		   $mtipo_orden=$tipo_orden." ".$des_tipo_orden;
		   
		   $pdf->Cell(12,4,$nro_orden,0,0); 
		   $pdf->Cell(14,4,$fecha,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $w=79; $n=75;		   
		   $pdf->SetXY($x+$w+$n,$y);		   
		   $pdf->Cell(20,4,$monto_orden,0,1,'R'); $pasa_linea=0;
		   
		   //if ($y>=251) { $nombre=substr($nombre,0,64);}
		   //if ($y>=254) { $nombre=substr($nombre,0,32);}
           //if((strlen(trim($nombre))>35)and (strlen(trim($mtipo_orden))<=65) ) { $pasa_linea=1;}		   
		   
		   if(strlen(trim($mtipo_orden))>strlen(trim($nombre)) and ($pasa_linea==0)){		   
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,4,$nombre,0);  
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($w,4,$mtipo_orden,0); 
		   }else{
		   $pdf->SetXY($x+$n,$y);	
		   $pdf->MultiCell($w,4,$mtipo_orden,0); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($n,4,$nombre,0); 
		   } 			
		} $total=formato_monto($total); 
		$pdf->SetFont('Arial','B',7);	
		
		if(($sub_total>0)or($cb>=1)){ $sub_total=formato_monto($sub_total);					    
			$pdf->Cell(180,2,'',0,0);
			$pdf->Cell(20,2,'-------------------',0,1,'R');
			$pdf->Cell(180,5,"TOTAL CUENTA  : ",0,0,'R'); 
			$pdf->Cell(20,5,$sub_total,0,1,'R');
		}
		$pdf->Output();

      }	  
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Rpt_Orden_Pago_Por_Pagar.xls");	
	
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="80" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="200" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDENES DE PAGO POR PAGAR</strong></font></td>
		 </tr>
		 <tr height="20">
		   <td width="80" align="left" ><strong></strong></td>
		   <td width="100" align="left" ><strong></strong></td>
		   <td width="200" align="left" ><strong></strong></td>
		   <td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
	     </tr>
         <tr height="20">
           <td width="80" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>ORDEN</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>FECHA</strong></td>
           <td width="200" align="left" bgcolor="#99CCFF"><strong>NOMBRE</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>CONCEPTO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO</strong></font></td>
         </tr>
     <?	  
	  $i=0;  $total=0;   $res=pg_query($sSQL); $cantidad=0;
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];$fecha=$registro["fecha"]; $nombre=$registro["nombre"]; $concepto=$registro["concepto"]; 
		   $fecha=formato_ddmmaaaa($fecha); $monto_orden=$registro["monto_orden"];   $monto_orden=formato_monto($monto_orden);  $cantidad=$cantidad+1;
		   $total=$total+$registro["monto_orden"];    $nombre=conv_cadenas($nombre,0);  $concepto=conv_cadenas($concepto,0);
	?>	   
		   <tr>
           <td width="80" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><? echo $nro_orden; ?></td>
           <td width="100" align="left"><? echo $fecha; ?></td>
           <td width="200" align="left"><? echo $nombre; ?></td>
           <td width="400" align="justify"><? echo $concepto; ?></td>
           <td width="100" align="right"><? echo $monto_orden; ?></td>

         </tr>
	<? }  $total=formato_monto($total);
        ?>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="80"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
		<td width="100"><strong></strong></td>
		<td width="200"><strong>CANTIDAD ORDENES : <? echo $cantidad; ?></strong></td>	
		<td width="400" align="right"><strong>TOTAL ORDENES:</strong></td>
		<td width="100" align="right"><strong><? echo $total; ?></strong></font></td>
      </tr>
	  </table><?
	}
}
?>
