<? error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php");  include ("../../class/configura.inc");
   $tipo_planilla_d=$_GET["tipo_planilla_d"];   $tipo_planilla_h=$_GET["tipo_planilla_h"];   $numero_planilla_d=$_GET["numero_planilla_d"];   $numero_planilla_h=$_GET["numero_planilla_h"];
   $fecha_d=$_GET["fecha_d"];   $fecha_h=$_GET["fecha_h"];   $tasa_d=$_GET["tasa_d"];   $tasa_h=$_GET["tasa_h"];   $tipo_en_d=$_GET["tipo_en_d"];   $tipo_en_h=$_GET["tipo_en_h"];
   $tipo_bene_d=$_GET["tipo_bene_d"];   $tipo_bene_h=$_GET["tipo_bene_h"];  $ordenado=$_GET["ordenado"]; $tipo_comp=$_GET["tipo_comp"];  $generado=$_GET["generado"];$tipo_rpt=$_GET["tipo_rpt"];
   $Sql=""; $date = date("d-m-Y");$hora = date("H:i:s a"); $php_os=PHP_OS; 
   $criterio1="Fecha Desde: ".$fecha_d." Al: ".$fecha_h; $criterio2="LISTADO PLANILLAS DE RETENCION";
   if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);} else{$fecha_d='';}$fecha_desde=$ano1.$mes1.$dia1;
   if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}  else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
$criterio_s="  (BAN012.fecha_emision>='".$fecha_desde."') And (BAN012.fecha_emision<='".$fecha_hasta."') ";
if($tipo_comp==="ORDEN CANCELADA") { $criterio_s="  BAN012.fecha_emision<='".$fecha_hasta."' and BAN012.tipo_mov='O/P' and BAN012.referencia in (select nro_orden  from pag001 where status='I' and fecha_cheque>='".$fecha_desde."' and fecha_cheque<='".$fecha_hasta."') ";}
if($tipo_comp==="CHEQUE ENTREGADO"){ $criterio_s="  BAN012.fecha_emision<='".$fecha_hasta."' and BAN012.tipo_mov='O/P' and ((BAN012.referencia='00000000' and BAN012.fecha_emision>='".$fecha_desde."' AND BAN012.fecha_emision<='".$fecha_hasta."') OR (BAN012.referencia in (select nro_orden  from pag001 where Status='I' and text(cod_banco)||text(nro_cheque) in (select text(cod_banco)||text(num_cheque) from ban006 where entregado='S' and fecha_entregado>='".$fecha_desde."' and fecha_entregado<='".$fecha_hasta."') )) )"; }
$conn=pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
else {  $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){ $php_os="WINNT";}
if($tipo_planilla_d==$tipo_planilla_h){$sql="SELECT descripcion,codigo FROM ban011 where codigo='".$tipo_planilla_d."'";$res=pg_query($sql);
if ($registro=pg_fetch_array($res,0)){$criterio2=$registro["descripcion"];} }
        $sSQL = "SELECT ban012.Nro_Planilla, ban012.Fecha_Emision, ban012.Tipo_Planilla,ban012.Cod_Banco, ban012.Tipo_Mov, ban012.Referencia,
                ban012.Ced_Rif, PRE099.Nombre, ban012.Monto_Pago, ban012.Monto_Objeto,ban012.Tasa, ban012.Monto_Retencion,ban012.Nro_Orden, PRE099.Tipo_Benef, to_char(ban012.Fecha_Emision,'DD/MM/YYYY') as fechae
                FROM ban012, PRE099 WHERE ban012.Ced_Rif = PRE099.Ced_Rif  AND
                ban012.Tipo_Planilla>='".$tipo_planilla_d."' AND ban012.Tipo_Planilla<='".$tipo_planilla_h."' AND ban012.Nro_Planilla>='".$numero_planilla_d."' AND ban012.Nro_Planilla<='".$numero_planilla_h."' AND
                ban012.Tasa>='".$tasa_d."' AND ban012.Tasa<='".$tasa_h."' AND PRE099.Tipo_Benef>='".$tipo_bene_d."' AND PRE099.Tipo_Benef<='".$tipo_bene_h."' and  ".$criterio_s." ORDER BY ".$ordenado;
    if($tipo_rpt=="HTML"){	include ("../../class/phpreports/PHPReportMaker.php");  
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Listado_Planillas_Retencion.xml");
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
			$this->Cell(100,10,'LISTADO PLANILLAS DE RETENCION',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',8);
			$this->Cell(50);
			$this->Cell(100,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',7);
			$this->Cell(14,3,'NUMERO','RLT',0);
			$this->Cell(13,3,'FECHA','RT',0);
			$this->Cell(7,3,'','RT',0);
			$this->Cell(14,3,'NUMERO','RT',0);
			$this->Cell(16,3,'','RT',0);
			$this->Cell(70,3,'','RT',0);
			$this->Cell(20,3,'MONTO','RT',0,'C');
			$this->Cell(20,3,'MONTO','RT',0,'C');
			$this->Cell(8,3,'','RT',0,'C');
			$this->Cell(18,3,'MONTO','RT',1,'C');
			
			$this->Cell(14,4,'PLANILLA','LB',0);
			$this->Cell(13,4,'EMISION','LB',0);
			$this->Cell(7,4,'TIPO','LB',0,'C');
			$this->Cell(14,4,'ORDEN','LB',0);
			$this->Cell(16,4,'RIF','LB',0,'C');
			$this->Cell(70,4,'NOMBRE','LB',0);
			$this->Cell(20,4,'PAGO','LB',0,'C');
			$this->Cell(20,4,'OBJETO','LB',0,'C');
			$this->Cell(8,4,'TASA','LB',0,'C');
			$this->Cell(18,4,'RETENCION','LRB',1,'C');
			$this->SetFont('Arial','',7);
		}
		function Footer(){ $ffechar=date("d-m-Y");$fhorar=date("H:i:s a"); 
			$this->SetY(-10);
			$this->SetFont('Arial','I',4);
			$this->Cell(100,5,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
			$this->Cell(100,5,'Fecha: '.$ffechar.' Hora: '.$fhorar,0,0,'R');
		}
	  }
	  
	  $pdf=new PDF('P', 'mm', Letter);
	  $pdf->AliasNbPages();
   	  $pdf->AddPage();
	  $pdf->SetFont('Arial','',7);
	  $i=0;  $totalp=0; $totalo=0; $totalr=0;
	  $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_planilla=$registro["nro_planilla"]; $fechae=$registro["fechae"]; $tipo_planilla=$registro["tipo_planilla"]; 
           $cod_banco=$registro["cod_banco"]; $tipo_mov=$registro["tipo_mov"]; $referencia=$registro["referencia"]; $ced_rif=$registro["ced_rif"];
           $nombre=$registro["nombre"]; $nro_orden=$registro["nro_orden"]; $tipo_benef=$registro["tipo_benef"]; $fecha_emision=formato_ddmmaaaa($fecha_emision); 
           $monto_pago=$registro["monto_pago"]; $monto_objeto=$registro["monto_objeto"]; $tasa=$registro["tasa"]; $monto_retencion=$registro["monto_retencion"];
           $monto_pago=formato_monto($monto_pago); $monto_objeto=formato_monto($monto_objeto); $tasa=formato_monto($tasa); $monto_retencion=formato_monto($monto_retencion);
           $totalp=$totalp+$registro["monto_pago"]; $totalo=$totalo+$registro["monto_objeto"]; $totalr=$totalr+$registro["monto_retencion"];
           if($php_os=="WINNT"){$nombre=$registro["nombre"]; }   else{$nombre=utf8_decode($nombre); }
		   $pdf->Cell(14,3,$nro_planilla,0,0); 
		   $pdf->Cell(13,3,$fechae,0,0); 
		   $pdf->Cell(7,3,$tipo_planilla,0,0,'C'); 
		   $pdf->Cell(13,3,$referencia,0,0);
           $pdf->Cell(17,3,$ced_rif,0,0); 		   
		   $x=$pdf->GetX();   $y=$pdf->GetY();  $w=70;		   
		   $pdf->SetXY($x+$w,$y);
		   $pdf->Cell(20,3,$monto_pago,0,0,'R'); 
           $pdf->Cell(20,3,$monto_objeto,0,0,'R'); 		   
		   $pdf->Cell(8,3,$tasa,0,0,'R'); 
		   $pdf->Cell(18,3,$monto_retencion,0,1,'R'); 
		   $pdf->SetXY($x,$y);	
		   $pdf->MultiCell($w,3,$nombre,0); 
		} $totalp=formato_monto($totalp); $totalo=formato_monto($totalo); $totalr=formato_monto($totalr);
		$pdf->SetFont('Arial','B',7);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(134,2,'',0,0);
		$pdf->Cell(20,2,'============',0,0,'R');
		$pdf->Cell(20,2,'============',0,0,'R');
        $pdf->Cell(8,2,'',0,0);
		$pdf->Cell(18,2,'============',0,1,'R');
		$pdf->Cell(134,5,'Total : ',0,0,'R');
		$pdf->Cell(20,5,$totalp,0,0,'R'); 
		$pdf->Cell(20,5,$totalo,0,0,'R'); 
		$pdf->Cell(8,5,'',0,0);
		$pdf->Cell(18,5,$totalr,0,0,'R'); 
		 
		$pdf->Output();   
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Listado_Planillas_Retencion.xls");		
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>LISTADO PLANILLAS DE RETENCION</strong></font></td>
		 </tr>
		 <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
		    <td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
		    <td width="400" align="center" > <font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong><? echo $criterio1; ?></strong></font></td>
	     </tr>
         <tr height="20">
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>NUMERO PLANILLA</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>FECHA EMISION</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>TIPO</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>NRO ORDEN</strong></td>
		   <td width="100" align="left" bgcolor="#99CCFF"><strong>RIF</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>NOMBRE</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>MONTO PAGO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>MONTO OBJETO</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>TASA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO RETENC</strong></font></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $totaln=0; $totalr=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_planilla=$registro["nro_planilla"]; $fechae=$registro["fechae"]; $tipo_planilla=$registro["tipo_planilla"]; 
           $cod_banco=$registro["cod_banco"]; $tipo_mov=$registro["tipo_mov"]; $referencia=$registro["referencia"]; $ced_rif=$registro["ced_rif"];
           $nombre=$registro["nombre"]; $nro_orden=$registro["nro_orden"]; $tipo_benef=$registro["tipo_benef"]; $fecha_emision=formato_ddmmaaaa($fecha_emision); 
           $monto_pago=$registro["monto_pago"]; $monto_objeto=$registro["monto_objeto"]; $tasa=$registro["tasa"]; $monto_retencion=$registro["monto_retencion"];
           $monto_pago=formato_monto($monto_pago); $monto_objeto=formato_monto($monto_objeto); $tasa=formato_monto($tasa); $monto_retencion=formato_monto($monto_retencion);
           $totalp=$totalp+$registro["monto_pago"]; $totalo=$totalo+$registro["monto_objeto"]; $totalr=$totalr+$registro["monto_retencion"];
           $nombre=conv_cadenas($nombre,0);  
	?>	   
        <tr>
           <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_planilla; ?></td>
           <td width="100" align="left"><? echo $fechae; ?></td>
           <td width="100" align="left">'<? echo $tipo_planilla; ?></td>
           <td width="100" align="left">'<? echo $referencia; ?></td>
		   <td width="100" align="left"><? echo $ced_rif; ?></td>
           <td width="400" align="justify"><? echo $nombre; ?></td>
           <td width="100" align="right"><? echo $monto_pago; ?></td>
           <td width="100" align="right"><? echo $monto_objeto; ?></td>
           <td width="100" align="right"><? echo $tasa; ?></td>
           <td width="100" align="right"><? echo $monto_retencion; ?></td>
         </tr>
	<? } $totalp=formato_monto($totalp); $totalo=formato_monto($totalo); $totalr=formato_monto($totalr);
        ?>
	   <tr> <td>&nbsp;</td>
	   <tr>
        <td width="100"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
		<td width="100"><strong></strong></td>	
		<td width="100" align="left" ><strong></strong></td>
		<td width="100" align="left" ><strong></strong></td>
		<td width="400" align="right"><strong>TOTAL :</strong></td>
		<td width="100" align="right"><strong><? echo $totalp; ?></strong></td>
		<td width="100" align="right"><strong><? echo $totalo; ?></strong></td>
		<td width="100" align="left" ><strong></strong></td>
		<td width="100" align="right"><strong><? echo $totalr; ?></strong></font></td>
      </tr>
      
	  </table><?
	}

   }
?>
