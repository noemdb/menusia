<? error_reporting(E_ALL ^ E_NOTICE);include ("../../class/conect.php"); require ("../../class/fun_fechas.php"); require ("../../class/fun_numeros.php"); include ("../../class/configura.inc");
$cedula_d=$_GET["cedula_d"];$cedula_h=$_GET["cedula_h"];$fecha_d=$_GET["fecha_d"];$fecha_h=$_GET["fecha_h"]; $tipo_rpt=$_GET["tipo_rpt"];
$clasificacion_d=$_GET["clasificacion_d"]; $clasificacion_h=$_GET["clasificacion_h"];$tipo_bene_d=$_GET["tipo_bene_d"];$tipo_bene_h=$_GET["tipo_bene_h"];
$ordenado="pag016.nro_orden"; $Sql="";$date = date("d-m-Y");$hora = date("H:i:s a"); $php_os=PHP_OS; 
$criterio1="Fecha Desde: ".$fecha_d." Al: ".$fecha_h; $criterio2="LISTADO FACTURAS SIN RETENCION DE ISLR";
if (!(empty($fecha_d))){$ano1=substr($fecha_d,6,9);$mes1=substr($fecha_d,3,2);$dia1=substr($fecha_d,0,2);}else{$fecha_d='';} $fecha_desde=$ano1.$mes1.$dia1;
if (!(empty($fecha_h))){$ano1=substr($fecha_h,6,9);$mes1=substr($fecha_h,3,2);$dia1=substr($fecha_h,0,2);}else{$fecha_h='';} $fecha_hasta=$ano1.$mes1.$dia1;
   $conn = pg_connect("host=".$host." port=".$port." password=".$password." user=".$user." dbname=".$dbname."");
   if (pg_ErrorMessage($conn)){ ?> <script language="JavaScript">  muestra('OCURRIO UN ERROR CONECTANDO LA BASE DE DATOS'); </script> <?}
   else{ $php_os=PHP_OS; $Nom_Emp=busca_conf();  if($utf_rpt=="SI"){  if($php_os=="WINNT"){ $php_os="LINUX"; } else{$php_os="WINNT";} }
   $sSQL = "select pag016.nro_orden,pag016.nro_factura,pag016.nro_con_factura,pag016.fecha_factura,pag016.monto_sin_iva,pag016.monto_iva1_so,pag016.tasa_iva1,pag016.monto_iva1,pag016.monto_iva4_so,pag016.monto_iva4,pag016.monto_factura,pag016.rif_factura,pag016.status_2,
            pre099.Nombre,pre099.clasificacion,pre099.tipo_benef,pag001.fecha,pag001.anulado,pag001.status,to_char(pag001.fecha,'DD/MM/YYYY') as fechae,to_char(pag016.fecha_factura,'DD/MM/YYYY') as fechaf, substring(pag016.nro_factura,12,8) as nfactura 
            from pag016,pre099,pag001 WHERE pag016.nro_orden=pag001.nro_orden and pag001.anulado='N' and pag016.status_2='N' and pag016.rif_factura=pre099.ced_rif and (pag016.nro_orden not in (select pag004.nro_orden_ret from pag004,pag003 where pag004.tipo_retencion=pag003.tipo_retencion and pag003.ret_grupo='I')) AND
            pag016.rif_factura>='".$cedula_d."' AND pag016.rif_factura<='".$cedula_h."' AND
            pag001.fecha>='".$fecha_desde."' AND pag001.fecha<='".$fecha_hasta."' AND
            pre099.clasificacion >='".$clasificacion_d."' AND pre099.clasificacion <='".$clasificacion_h."' AND
            pre099.tipo_benef>='".$tipo_bene_d."' AND pre099.tipo_benef<='".$tipo_bene_h."' order by ".$ordenado.""; 
    if($tipo_rpt=="HTML"){	  include ("../../class/phpreports/PHPReportMaker.php");
		  $oRpt = new PHPReportMaker();
          $oRpt->setXML("Rpt_Listado_fact_sin_ret.xml");
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
		function Header(){global $criterio1;  global $tam_logo;
			$this->Image('../../imagenes/Logo_emp.png',7,7,$tam_logo);
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(170,10,'REPORTE LISTADOS FACTURAS SIN RETENCION ISLR',1,0,'C');
			$this->Ln(10);
			$this->SetFont('Arial','B',9);
			$this->Cell(30);
			$this->Cell(170,10,$criterio1,0,0,'C');				
			$this->Ln(10);
			$this->SetFont('Arial','B',7);
			$this->Cell(17,5,'NRO ORDEN',1,0,'L');
			$this->Cell(14,5,'FECHA',1,0,'C');
			$this->Cell(20,5,'NRO FACTURA',1,0,'C');
			$this->Cell(20,5,'FECHA FACT.',1,0,'C');
			$this->Cell(17,5,'CEDULA/RIF',1,0,'L');
			$this->Cell(55,5,'NOMBRE',1,0,'L');
			$this->Cell(21,5,'MONTO SIN IVA',1,0,'C');
			$this->Cell(15,5,'IVA',1,0,'C');
			$this->Cell(21,5,'MONTO CON IVA',1,1,'C');
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
	  $i=0;  $total=0;   $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];  $fecha=$registro["fecha"]; $ced_rif=$registro["rif_factura"];  $nombre=$registro["nombre"]; $nfactura=$registro["nfactura"]; $fecha_factura=$registro["fecha_factura"];
           $monto_sin_iva=$registro["monto_sin_iva"];$monto_iva1=$registro["monto_iva1"];$monto_factura=$registro["monto_factura"];	$nro_factura=$registro["nro_factura"];  
		   $total=$total+$monto_factura; $l=strlen($nro_factura); if($l>12){$c=$l-12; $nfactura=substr($nro_factura,$c,12);}else{$nfactura=$nro_factura;}
		   $monto_sin_iva=formato_monto($monto_sin_iva); $monto_iva1=formato_monto($monto_iva1); $monto_factura=formato_monto($monto_factura); 
		   $fecha=formato_ddmmaaaa($fecha); $fecha_factura=formato_ddmmaaaa($fecha_factura);
		   if($php_os=="WINNT"){$nombre=$registro["nombre"]; }	else{ $nombre=utf8_decode($nombre);;}
		   $pdf->Cell(16,3,$nro_orden,0,0,'L');
		   $pdf->Cell(15,3,$fecha,0,0,'C'); 
		   $pdf->Cell(20,3,$nfactura,0,0,'C'); 
		   $pdf->Cell(20,3,$fecha_factura,0,0,'C'); 
		   $pdf->Cell(17,3,$ced_rif,0,0,'C'); 
		   $x=$pdf->GetX();   $y=$pdf->GetY(); $w=55;		   
		   $pdf->SetXY($x+$w,$y);
		   $pdf->Cell(21,3,$monto_sin_iva,0,0,'R'); 
           $pdf->Cell(15,3,$monto_iva1,0,0,'R'); 		   
		   $pdf->Cell(21,3,$monto_factura,0,1,'R'); 
		   $pdf->SetXY($x,$y);
		   $pdf->MultiCell($w,3,$nombre,0);			
		} $total=formato_monto($total); 
		$pdf->SetFont('Arial','B',8);
		$x=$pdf->GetX();  $y=$pdf->GetY();
		$pdf->Cell(180,2,'',0,0);
		$pdf->Cell(20,2,'============',0,1,'R');
		$pdf->Cell(180,5,'Total: ',0,0,'R');
		$pdf->Cell(20,5,$total,0,1,'R'); 		 
		$pdf->Output();   
    }
    if($tipo_rpt=="EXCEL"){	
	  header("Content-type: application/vnd.ms-excel");
      header("Content-Disposition: attachment; filename=Listado_factura_sin_retenciones.xls");		
	?>
       <table border="0" cellspacing='0' cellpadding='0' align="left">
	     <tr height="20">
		    <td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
			<td width="100" align="left" ><strong></strong></td>
            <td width="400" align="center" > <font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>REPORTE LISTADOS FACTURAS SIN RETENCION ISLR</strong></font></td>
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
           <td width="100" align="left" bgcolor="#99CCFF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong>NRO ORDEN</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>FECHA</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>NRO FACTURA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>FECHA FACTURA</strong></td>
           <td width="100" align="left" bgcolor="#99CCFF"><strong>CEDULA/RIF</strong></td>
           <td width="400" align="left" bgcolor="#99CCFF"><strong>NOMBRE</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF"><strong>MONTO SIN IVA</strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>IVA </strong></td>
           <td width="100" align="center" bgcolor="#99CCFF" ><strong>MONTO CON IVA</strong></font></td>
         </tr>
     <?	  
	  $i=0;  $total=0; $res=pg_query($sSQL);
	  while($registro=pg_fetch_array($res)){ $i=$i+1;
		   $nro_orden=$registro["nro_orden"];  $fecha=$registro["fecha"]; $ced_rif=$registro["rif_factura"]; 
		   $nombre=$registro["nombre"]; $nfactura=$registro["nfactura"]; $nro_factura=$registro["nro_factura"]; $fecha_factura=$registro["fecha_factura"];
           $monto_sin_iva=$registro["monto_sin_iva"];$monto_iva1=$registro["monto_iva1"];$monto_factura=$registro["monto_factura"];	
		   $total=$total+$monto_factura; $l=strlen($nro_factura); if($l>12){$c=$l-12; $nfactura=substr($nro_factura,$c,12);}else{$nfactura=$nro_factura;}
		   $monto_sin_iva=formato_monto($monto_sin_iva); $monto_iva1=formato_monto($monto_iva1); $monto_factura=formato_monto($monto_factura); 
		   $fecha=formato_ddmmaaaa($fecha); $fecha_factura=formato_ddmmaaaa($fecha_factura);
		   $nombre=conv_cadenas($nombre,0);  $concepto=conv_cadenas($concepto,0);
	?>	   
		   <tr>
           <td width="100" align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033">'<? echo $nro_orden; ?></td>
           <td width="100" align="left"><? echo $fecha; ?></td>
           <td width="100" align="left"><? echo $nfactura; ?></td>
           <td width="100" align="left"><? echo $fecha_factura; ?></td>
           <td width="100" align="left"><? echo $ced_rif; ?></td>
           <td width="400" align="justify"><? echo $nombre; ?></td>
           <td width="100" align="right"><? echo $monto_sin_iva; ?></td>
           <td width="100" align="right"><? echo $monto_iva1; ?></td>
           <td width="100" align="right"><? echo $monto_factura; ?></td>
         </tr>
	<? }   
             $total=formato_monto($total); 
        ?>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
         <td width="100"><font size="2" face="Verdana, Arial, Helvetica, sans-serif" color="#000033"><strong></strong></td>
         <td width="100"><span class="Estilo5"></span></td>
         <td width="100"><span class="Estilo5"></span></td>
         <td width="100"><span class="Estilo5"></span></td>
         <td width="100"><span class="Estilo5"></span></td>
         <td width="400"><span class="Estilo5"></span></td>
         <td width="100"><span class="Estilo5"></span></td>
         <td width="100" align="right"><strong>TOTAL :</strong></td>
		 <td width="100" align="right"><strong><? echo $total; ?></strong></font></td>
    </tr>
	  </table><?
	}
} 
?>
